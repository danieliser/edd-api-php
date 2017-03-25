<?php

/**
 * Class EDD_API_Model_Sale
 */
class EDD_API_Model_Sale extends EDD_API_Model {

	/**
	 * @var
	 */
	public $ID;
	/**
	 * @var
	 */
	public $key;
	/**
	 * @var
	 */
	public $subtotal;
	/**
	 * @var
	 */
	public $tax;
	/**
	 * @var
	 */
	public $fees;
	/**
	 * @var
	 */
	public $total;
	/**
	 * @var
	 */
	public $gateway;
	/**
	 * @var
	 */
	public $email;
	/**
	 * @var
	 */
	public $date;
	/**
	 * @var array
	 */
	public $products = array();

	/**
	 * EDD_API_Model_Sale constructor.
	 *
	 * @param array $data
	 */
	public function __construct( $data = array() ) {
		parent::__construct( $data );

		if ( ! empty( $this->products ) ) {
			foreach ( $this->products as $key => $product ) {
				// TODO Currently EDD API doesn't return a full product model, and the keys are incorrect.
				//$this->products[ $key ] = new EDD_API_Model_Product( $product );
			}
		}
	}

}
