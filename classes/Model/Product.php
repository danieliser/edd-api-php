<?php

/**
 * Class EDD_API_Model_Product
 */
class EDD_API_Model_Product extends EDD_API_Model {

	/**
	 * @var
	 */
	public $name;
	/**
	 * @var
	 */
	public $price;
	/**
	 * @var
	 */
	public $price_name;

	/**
	 * EDD_API_Model_Product constructor.
	 *
	 * @param array $data
	 */
	public function __construct( $data = array() ) {
		parent::__construct( $data );
	}

}
