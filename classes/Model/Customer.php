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

	/**
	 * @var
	 */
	public $customer_id;

	/**
	 * @var
	 */
	public $user_id;

	/**
	 * @var
	 */
	public $username;

	/**
	 * @var
	 */
	public $display_name;

	/**
	 * @var
	 */
	public $first_name;

	/**
	 * @var
	 */
	public $last_name;

	/**
	 * @var
	 */
	public $email;

	/**
	 * @var
	 */
	public $additional_emails;

	/**
	 * @var
	 */
	public $date_created;

	/**
	 * @var
	 */
	public $total_purchases;

	/**
	 * @var
	 */
	public $total_spent;

	/**
	 * @var
	 */
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

	/**
	 *
	 */
	public function get_purchases() {
		//edd_api()->get_purchases( $this->customer_id );
	}

}
