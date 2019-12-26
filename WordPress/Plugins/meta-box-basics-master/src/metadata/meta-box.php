<?php
/**
 * Meta Box Handler.
 *
 * @package     KnowTheCode\Metadata
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://KnowTheCode.io
 * @license     GNU-2.0+
 */
namespace AntalTettinger\Metadata;
use WP_Post;
use AntalTettinger\ConfigStore as configStore;
add_action( 'admin_menu', __NAMESPACE__ . '\register_meta_boxes' );

/**
 * Register the meta boxes.
 *
 * @since 1.0.0
 *
 * @return void
 */
function register_meta_boxes() {
	foreach( get_meta_box_keys() as $meta_box_key ) {
		$config = configStore\getConfigParameter(
			$meta_box_key,
			'add_meta_box'
		);
		add_meta_box(
			$meta_box_key,
			$config['title'],
			__NAMESPACE__ . '\render_meta_box',
			$config['screen'],
			$config['context'],
			$config['priority'],
			$config['callback_args']
		);
	}
}
/**
 * Render the meta box
 *
 * @since 1.0.0
 *
 * @param WP_Post $post Instance of the post for this meta box
 * @param array $meta_box_args Array of meta box arguments
 *
 * @return void
 */
function render_meta_box( WP_Post $post, array $meta_box_args ) {
	$meta_box_key = $meta_box_args['id'];
	$config       = configStore\getConfig( $meta_box_key );
	// Security with a nonce
	wp_nonce_field( $meta_box_key . '_nonce_action', $meta_box_key . '_nonce_name' );
	// Get the metadata
	$custom_fields = array();
	foreach ( $config['custom_fields'] as $meta_key => $custom_field_config ) {
		$custom_fields[ $meta_key ] = get_post_meta( $post->ID, $meta_key, $custom_field_config['is_single'] );
		if ( ! $custom_fields[ $meta_key ] ) {
			$custom_fields[ $meta_key ] = $custom_field_config['default'];
		}
	}
	// Do any processing that needs to be done
	// Load the view file
	include $config['view'];
}
add_action( 'save_post', __NAMESPACE__ . '\save_subtitle_meta_box', 10, 2 );
/**
 * Description.
 *
 * @since 1.0.0
 *
 * @param integer $post_id Post ID.
 * @param stdClass $post Post object.
 *
 * @return void
 */
function save_subtitle_meta_box( $post_id, $post ) {
	foreach( get_meta_box_keys() as $meta_box_key ) {
		$config = configStore\getConfigParameter(
			$meta_box_key,
			'custom_fields'
		);
		// If this is not the right meta box, then bail out.
		if ( ! array_key_exists( $meta_box_key, $_POST ) ) {
			continue;
		}
		// Another conditional where we don't save
		// CRON AJAX....
		// If the nonce doesn't match, return false.
		if ( ! wp_verify_nonce(
			$meta_box_key . '_nonce_name',
			$meta_box_key . '_nonce_action'
		) ) {
			continue;
		}
		// Merge with defaults.
		$metadata = wp_parse_args(
			$_POST[ $meta_box_key ],
			// defaults
			array(
				'subtitle'      => '',
				'show_subtitle' => 0,
			)
		);
		foreach ( $metadata as $meta_key => $value ) {
			// if no value, delete the post meta record.
			if ( ! $value ) {
				delete_post_meta( $post_id, $meta_key );
				continue;
			}
			// validation and sanitizing
			if ( 'subtitle' === $meta_key ) {
				$value = sanitize_text_field( $value );
			} else {
				$value = 1;
			}
			update_post_meta( $post_id, $meta_key, $value );
		}
	}
}