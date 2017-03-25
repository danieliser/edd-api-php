<?php

/**
 * Class EDD_API_Model_Customer
 */
class EDD_API_Model_Customer extends EDD_API_Model {

	/**
	 * @var
	 */
	public $info;
	/**
	 * @var
	 */
	public $stats;

	public $customer_id;

	public $user_id;

	public $username;

	public $display_name;

	public $first_name;

	public $last_name;

	public $email;

	public $additional_emails;

	public $date_created;

	public $total_purchases;

	public $total_spent;

	public $total_downloads;

	/**
	 * EDD_API_Model_Product constructor.
	 *
	 * @param array $data
	 */
	public function __construct( $data = array() ) {
		parent::__construct( $data );

		if ( ! empty( $this->info ) ) {
			$this->set_properties( $this->info );
		}

		if ( ! empty( $this->stats ) ) {
			$this->set_properties( $this->stats );
		}
	}

	public function get_purchases() {
		//edd_api()->get_purchases( $this->customer_id );
	}

}
