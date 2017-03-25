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
		foreach ( $data as $key => $val ) {
			if ( property_exists( $this, $key ) ) {
				$this->$key = $val;
			}
		}

		return $this;
	}

}