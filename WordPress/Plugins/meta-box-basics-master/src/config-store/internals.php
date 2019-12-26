<?php
/**
 * ConfigStore's Internal Functionality (Private)
 *
 * @license     GNU-2.0+
 */
namespace AntalTettinger\ConfigStore;
/**
 * Description.
 *
 * @since 1.0.0
 *
 * @param string $store_key
 * @param array $config_to_store
 *
 * @return void
 */
function _the_store( $store_key = '', $config_to_store = array())  {
    
    static $config_store = array();
    // Store
    // Get the store.
	if ( !$store_key ) {
		return $config_store;
    }
    
	if ( $config_to_store ) {
        $config_store[ $store_key ] = $config_to_store;
		// store here.
    }
    
	if ( !array_key_exists( $store_key, $config_store ) ) {
		throw new \Exception(
			sprintf(
				__('Configuration for [%s] does not exist in the ConfigStore', 'config-store'),
				esc_html( $store_key )
			)
		);
    }
    
    return $config_store[$store_key];
}
/**
 * Load a configuration from the filesystem, returning its
 * storage key and configuration parameters.
 *
 * @since 1.0.0
 *
 * @param string $path_to_file Absolute path to the config file.
 *
 * @return array
 */
function _load_config_from_filesystem($path_to_file) {

    $config = (array) require $path_to_file;
	return array(
		key( $config ),
		current( $config )
	);
}

/**
 * Merge the configuration with defaults.
 *
 * @since 1.0.0
 *
 * @param array $config Array of configuration parameters
 * @param array $defaults Array of default parameters
 *
 * @return array
 */
function _merge_with_defaults( array $config, array $defaults ) {
	return array_replace_recursive( $defaults, $config );
}