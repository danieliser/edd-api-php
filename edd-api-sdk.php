<?php

/**
 * @param $class
 */
function edd_api_sdk_autoloader( $class ) {

	// project-specific namespace prefix
	$prefix = 'EDD_API_';

	// base directory for the namespace prefix
	$base_dir = __DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR;

	// does the class use the namespace prefix?
	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		// no, move to the next registered autoloader
		return;
	}

	// get the relative class name
	$relative_class = substr( $class, $len );

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = $base_dir . str_replace( '_', DIRECTORY_SEPARATOR, $relative_class ) . '.php';

	// if the file exists, require it
	if ( file_exists( $file ) ) {
		require_once $file;
	}

}

spl_autoload_register( 'edd_api_sdk_autoloader' ); // Register autoloader

require_once ( 'non-wp-compat.php' );

/**
 * @return EDD_API_Wrapper
 */
function edd_api( $creds = null ) {
	return EDD_API_Wrapper::instance();
}



