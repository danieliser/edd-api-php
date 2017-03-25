<?php

if ( ! function_exists( 'wp_parse_args' ) ) {
	/**
	 * Merge user defined arguments into defaults array.
	 *
	 * This function is used throughout WordPress to allow for both string or array
	 * to be merged into another array.
	 *
	 * @param string|array|object $args Value to merge with $defaults.
	 * @param array|string $defaults Optional. Array that serves as the defaults. Default empty.
	 *
	 * @return array Merged user defined values with defaults.
	 */
	function wp_parse_args( $args, $defaults = '' ) {
		if ( is_object( $args ) ) {
			$r = get_object_vars( $args );
		} elseif ( is_array( $args ) ) {
			$r =& $args;
		} else {
			wp_parse_str( $args, $r );
		}

		if ( is_array( $defaults ) ) {
			return array_merge( $defaults, $r );
		}

		return $r;
	}
}

if ( ! function_exists( 'wp_parse_str' ) ) {
	/**
	 * Parses a string into variables to be stored in an array.
	 *
	 * @param string $string The string to be parsed.
	 * @param array $array Variables will be stored in this array.
	 */
	function wp_parse_str( $string, &$array ) {
		parse_str( $string, $array );
		if ( get_magic_quotes_gpc() ) {
			$array = stripslashes_deep( $array );
		}
	}
}

if ( ! function_exists( 'stripslashes_deep' ) ) {
	/**
	 * Maps a function to all non-iterable elements of an array or an object.
	 *
	 * This is similar to `array_walk_recursive()` but acts upon objects too.
	 *
	 * @param mixed $value The array, object, or scalar.
	 * @param callable $callback The function to map onto $value.
	 *
	 * @return mixed The value with the callback applied to all non-arrays and non-objects inside it.
	 */
	function map_deep( $value, $callback ) {
		if ( is_array( $value ) ) {
			foreach ( $value as $index => $item ) {
				$value[ $index ] = map_deep( $item, $callback );
			}
		} elseif ( is_object( $value ) ) {
			$object_vars = get_object_vars( $value );
			foreach ( $object_vars as $property_name => $property_value ) {
				$value->$property_name = map_deep( $property_value, $callback );
			}
		} else {
			$value = call_user_func( $callback, $value );
		}

		return $value;
	}
}

if ( ! function_exists( 'stripslashes_deep' ) ) {
	/**
	 * Navigates through an array, object, or scalar, and removes slashes from the values.
	 *
	 * @param mixed $value The value to be stripped.
	 *
	 * @return mixed Stripped value.
	 */
	function stripslashes_deep( $value ) {
		return map_deep( $value, 'stripslashes_from_strings_only' );
	}
}

if ( ! function_exists( 'stripslashes_from_strings_only' ) ) {
	/**
	 * Callback function for `stripslashes_deep()` which strips slashes from strings.
	 *
	 * @param mixed $value The array or string to be stripped.
	 *
	 * @return mixed $value The stripped value.
	 */
	function stripslashes_from_strings_only( $value ) {
		return is_string( $value ) ? stripslashes( $value ) : $value;
	}
}
