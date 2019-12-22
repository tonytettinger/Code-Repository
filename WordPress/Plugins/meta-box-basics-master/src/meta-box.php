<?php
/**
 * Meta Box Basics
 *
 * @package     KnowTheCode\MetaBoxBasics
 * @since       1.0.0
 * @author      hellofromTonya
 * @link        https://KnowTheCode.io
 * @license     GNU-2.0+
 */

namespace KnowTheCode\MetaBoxBasics;

use WP_Post;

add_action( 'admin_menu', __NAMESPACE__ . '\register_meta_box' );
/**
 * Register the meta box.
 *
 * @since 1.0.0
 *
 * @return void
 */
function register_meta_box() {
	add_meta_box(
		'mbbasics_subtitle',
		__( 'Subtitle', 'mbbasics' ),
		__NAMESPACE__ . '\render_meta_box',
		'post'
	);
}

/**
 * Render the meta box
 *
 * @since 1.0.0
 *
 * @param WP_Post $post Instance of the post for this meta box
 * @param array $meta_box Array of meta box arguments
 *
 * @return void
 */
function render_meta_box( WP_Post $post, array $meta_box ) {
	// Security with a nonce
	wp_nonce_field( 'mbbasics_save', 'mbbasics_nonce' );

	// Get the metadata
	$subtitle = get_post_meta( $post->ID , 'subtitle', true);
	$show_subtitle = get_post_meta( $post->ID , 'show_subtitle', true);
	// Do any processing that needs to be done

	// Load the view file
	include METABOXBASICS_DIR . 'src/view.php';
}

add_action( 'save_post', __NAMESPACE__ . '\save_meta_box', 10, 2 );
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
function save_meta_box( $post_id, $post ) {


	// If the nonce doesn't match, return false.
	if ( ! wp_verify_nonce( $_POST['mbbasics_nonce'], 'mbbasics_save' ) ) {
		return false;
	}

	if ( ! array_key_exists('mbbasics', $_POST)) {
		return;
	}

	//merge with defaults

	$metadata = wp_parse_args(
		$_POST['mbbasics'],
		array(
			'subtitle' => '',
			'show_subtitle' => 0,
		)
		);

	foreach( $metadata as $meta_key => $value ) {

		//validation and sanitizing

		//if we should delete it
		if ( ! $value ) {
			delete_post_meta( $post_id, $meta_key );
		} else {
		//else do an update
			$value = 'subtitle' === $meta_key
			? $value = sanitize_text_field( $value )
			: $value = 1;
			update_post_meta( $post_id, $meta_key, $value );
		}

	}

/*
	if ( $_POST['subtitle'] ) { 
	// Merge the metadata.
	update_post_meta( $post_id, 'subtitle', sanitize_text_field( $_POST['subtitle'] ) );
	// Loop through the custom fields and update the `wp_postmeta` database.
	} else {
		delete_post_meta( $post_id, 'msubtitle');
	}

	if ( array_key_exists( 'show_subtitle', $_POST) ) { 
		// Merge the metadata.
		update_post_meta( $post_id, 'show_subtitle', 1 );
		// Loop through the custom fields and update the `wp_postmeta` database.
		} else {
			delete_post_meta( $post_id, 'show_subtitle');
		}
		*/
}
