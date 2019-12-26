<?php
/**
 * Public API to interact with the ConfigStore.
 *
 * @license     GNU-2.0+
 */
namespace AntalTettinger\ConfigStore;
/**
 * Get a specific configuration from the store.
 *
 * @since 1.0.0
 *
 * @param string $store_key
 *
 * @return mixed
 */
function getConfig( $store_key ) {
	return _the_store( $store_key );
}
/**
 * Get a specific configuration parameter from the store.
 *
 * @since 1.0.0
 *
 * @param string $store_key
 * @param string $parameter_key
 *
 * @return mixed
 */
function getConfigParameter( $store_key, $parameter_key ) {
    $config = getConfig( $store_key );
    if ( ! array_key_exists( $parameter_key, $config ) ) {
		throw new \Exception(
			sprintf(
				__('The configuration parameter [%s] within [%s] does not exist in this configuration', 'config-store'),
				esc_html( $parameter_key ),
				esc_html( $store_key )
			)
		);
	}
	return $config[ $parameter_key ];
}
/**
 * Load the configuration into the store from the
 * absolute path to the configuration file.
 *
 * @since 1.0.0
 *
 * @param string $path_to_file Absolute path to the config file.
 * @param array $defaults (optional) Array of default parameters.
 */
function loadConfigFromFilesystem( $path_to_file, array $defaults = array() ) {
	list( $store_key, $config ) = _load_config_from_filesystem( $path_to_file );
	// Merge with any defaults.
	if ( $defaults ) {
		$config = _merge_with_defaults( $config, $defaults );
	}
	_the_store( $store_key, $config );
	return $store_key;
}

// code left out for brevity
/**
 * Get all the store keys.
 *
 * @since 1.0.0
 *
 * @return array
 */
function getAllKeys() {
	$config_store = _the_store();
	return array_keys( $config_store );
}