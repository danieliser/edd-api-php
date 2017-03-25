<?php

/**
 * Class EDD_API_Model
 */
class EDD_API_Model {

	/**
	 * EDD_API_Model constructor.
	 *
	 * @param array $data
	 */
	public function __construct( $data = array() ) {
		$this->set_properties( $data );

		return $this;
	}

	public function set_properties( $data = array() ) {
		foreach ( $data as $key => $val ) {
			if ( property_exists( $this, $key ) ) {
				$this->$key = $val;
			}
		}
	}

}