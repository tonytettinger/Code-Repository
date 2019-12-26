<?php
/**
 * Metadata Module - bootstrap file.
 *
 * @license     GNU-2.0+
 */

namespace AntalTettinger\Metadata;
use AntalTettinger\ConfigStore as configStore;

function autoload_configurations( array $config_files ) {
    $defaults = (array) require __DIR__ . '/defaults/meta-box-config.php';
    $defaults = current( $defaults );
	foreach( $config_files as $config_file ) {
		configStore\loadConfigFromFilesystem( $config_file, $defaults );
	}
}
function autoload() {
	include __DIR__ . '/meta-box.php';
}
/**
 * Get all of the meta box keys from the ConfigStore.
 *
 * @since 1.0.0
 *
 * @return array
 */
function get_meta_box_keys() {
	return (array) configStore\getAllKeys();
}
autoload();