<?php
/**
 * Meta WordPress Plugin
 *
 * @wordpress-plugin
 * Plugin Name: Meta Box Basics WordPress Plugin
 * Description: Custom meta box basics plugin to add a custom meta box to our sandbox.
 * Version:     1.0.0
 * Author:      Antal (based on Tonya Mork's plugin)
 * Author URI:  https://antaltettinger.com
 * Text Domain: mbbasics
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace AntalTettinger\MetaBox;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheatin&#8217; uh?' );
}

/**
 * Setup the plugin's constants.
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_constants() {
	$plugin_url = plugin_dir_url( __FILE__ );
	if ( is_ssl() ) {
		$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
	}

	define( 'METABOX_URL', $plugin_url );
	define( 'METABOX_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Launch the plugin
 *
 * @since 1.0.0
 *
 * @return void
 */
function launch() {
	init_constants();

	require __DIR__ . '/src/config-store/module.php';
	require __DIR__ . '/src/metadata/module.php';

	// load the configuration files into the module.
	\AntalTettinger\Metadata\autoload_configurations( array(
		__DIR__ . '/config/portfolio.php',
		__DIR__ . '/config/subtitle.php',
	) );
}

launch();
