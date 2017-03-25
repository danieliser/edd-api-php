<?php

/**
 * Class EDD_API_Model_Category
 */
class EDD_API_Model_Category extends EDD_API_Model_Taxonomy {
	/**
	 * EDD_API_Model_Taxonomy constructor.
	 *
	 * @param array $data
	 */
	public function __construct( $data = array() ) {
		parent::__construct( $data );
	}
}
