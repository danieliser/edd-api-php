<?php

/**
 * Class EDD_API_Wrapper
 */
class EDD_API_Wrapper {

	private $api;

	/**
	 * EDD_API_Wrapper constructor.
	 *
	 * @param array $api
	 */
	public function __construct( $api = array() ) {
		$this->api = wp_parse_args( $api, array(
			'url'   => '',
			'key'   => '',
			'token' => '',
		) );
	}

	/**
	 * @param array $api
	 *
	 * @return static
	 */
	public static function instance( $api = array() ) {
		static $instances;

		array_multisort( $api );
		$hash = md5( json_encode( $api ) );

		if ( ! isset( $instances[ $hash ] ) ) {
			$instances[ $hash ] = new static( $api );
		}

		return $instances[ $hash ];
	}

	/**
	 * @param $customer
	 * @param array $args
	 *
	 * @return array|bool|mixed|object
	 */
	public function get_customer( $customer, $args = array() ) {
		$args = wp_parse_args( $args, array(
			'customer' => $customer,
		) );

		$request = $this->call_api( 'customers', $args );

		return $request && ! empty( $request['customers'][0] ) ? new EDD_API_Model_Customer( $request['customers'][0] ) : null;
	}

	/**
	 * @param $endpoint
	 * @param array $args
	 *
	 * @return array|bool|mixed|object
	 */
	public function call_api( $endpoint, $args = array() ) {

		$query_string = wp_parse_args( $args, array(
			'key'   => $this->api['key'],
			'token' => $this->api['token'],
		) );

		$url = $this->api['url'] . $endpoint . '?' . http_build_query( array_filter( $query_string ) );

		$request = wp_remote_get( $url, array(
			'timeout' => 30,
		) );

		if ( is_wp_error( $request ) ) {
			return false; // Bail early
		}

		$body = wp_remote_retrieve_body( $request );

		return $this->maybe_json_decode( $body );
	}

	/**
	 * @param $json
	 *
	 * @return array|mixed|object
	 */
	public function maybe_json_decode( $json ) {
		try {
			$json = json_decode( $json, true );
		} catch ( Exception $e ) {
		}

		return $json;
	}

	/**
	 * @param array $args
	 *
	 * @return array|bool|mixed|object
	 */
	public function get_customers( $args = array() ) {
		$args = wp_parse_args( $args, array(
			//  The date to retrieve earnings or sales for. This has three accepted values: today, yesterday & range.
			'date'      => null,
			// Format: YYYYMMDD. Example: 20120224 = 2012/02/24
			'startdate' => null,
			// Format: YYYYMMDD. Example: 20120531 = 2012/02/24
			'enddate'   => null,
		) );

		if ( ! empty( $args['startdate'] ) || ! empty( $args['enddate'] ) ) {
			$args['date'] = 'range';
		} else if ( ! in_array( $args['data'], array( 'today', 'yesterday', 'range' ) ) ) {
			$args['data'] = null;
		}

		$request = $this->call_api( 'customers', $args );

		$customers = $request && ! empty( $request['customers'] ) ? $request['customers'] : array();

		foreach ( $customers as $key => $customer ) {
			$customers[ $key ] = new EDD_API_Model_Customer( $customer );
		}

		return $customers;
	}

	/**
	 * Get products.
	 *
	 * Search for products by string, category & tag.
	 *
	 * @param array $args
	 *
	 * @return array|bool|mixed|object
	 */
	public function get_products( $args = array() ) {
		$args = wp_parse_args( $args, array(
			's'        => null, // Accepts search string.
			'category' => null, // Accepts name or id.
			'tag'      => null, // Accepts name or id.
		) );

		$request = $this->call_api( 'products', $args );

		$products = $request && ! empty( $request['products'] ) ? $request['products'] : array();

		foreach ( $products as $key => $product ) {
			$products[ $key ] = new EDD_API_Model_Product( $product );
		}

		return $products;
	}

	/**
	 * @param array $args
	 *
	 * @return array|bool|mixed|object
	 */
	public function get_product( $product, $args = array() ) {
		$args = wp_parse_args( $args, array(
			'product' => $product,
		) );

		$request = $this->call_api( 'products', $args );

		return $request && ! empty( $request['products'][0] ) ? new EDD_API_Model_Product( $request['products'][0] ) : null;
	}

	/**
	 * @param $type
	 * @param $value
	 * @param array $args
	 *
	 * @return array|bool|mixed|object
	 */
	public function get_sales_by_( $type, $value, $args = array() ) {

		$args = wp_parse_args( $args, array(
			'number'      => null,
			'email'       => null,
			'id'          => null,
			'purchasekey' => null,
		) );

		switch ( $type ) {
			case 'id':
				$args['id'] = $value;
				break;
			case 'purchasekey':
				$args['purchasekey'] = $value;
				break;
			case 'email':
			default:
				$args['email'] = $value;
				break;
		}

		$request = $this->call_api( 'sales', $args );

		$sales = $request && ! empty( $request['sales'] ) ? $request['sales'] : array();

		foreach ( $sales as $key => $sale ) {
			$sales[ $key ] = new EDD_API_Model_Sale( $sale );
		}

		return $sales;
	}

	/**
	 * Get discounts.
	 *
	 * @param array $args
	 *
	 * @return array|bool|mixed|object
	 */
	public function get_discounts( $args = array() ) {
		$args = wp_parse_args( $args, array() );

		$request = $this->call_api( 'discounts', $args );

		$discounts = $request && ! empty( $request['discounts'] ) ? $request['discounts'] : array();

		foreach ( $discounts as $key => $discount ) {
			$discounts[ $key ] = new EDD_API_Model_Discount( $discount );
		}

		return $discounts;
	}

	/**
	 * Get download logs.
	 *
	 * @param null $customer
	 *
	 * @return array|bool|mixed|object
	 */
	public function get_download_logs( $customer = null ) {
		$args = array(
			'customer' => $customer, // Accepts email or ID string.
		);

		$request = $this->call_api( 'download-logs', $args );

		$download_logs = $request && ! empty( $request['download_logs'] ) ? $request['download_logs'] : array();

		foreach ( $download_logs as $key => $download_log ) {
			$download_logs[ $key ] = new EDD_API_Model_Log( $download_log );
		}

		return $download_logs;
	}

	/**
	 * Get store stats.
	 *
	 * @param null $type
	 * @param array $args
	 *
	 * @return array|bool|mixed|object
	 */
	public function get_stats( $type = null, $args = array() ) {

		if ( is_array( $type ) && ! isset( $args ) || empty( $args ) ) {
			$args = $type;
		} else {
			$args['type'] = $type;
		}

		// product & date options cannot be combined.
		$args = wp_parse_args( $args, array(
			// Accepts sales or earnings.
			'type'      => null,
			//  The date to retrieve earnings or sales for. This has three accepted values: today, yesterday & range.
			'date'      => null,
			// Format: YYYYMMDD. Example: 20120224 = 2012/02/24
			'startdate' => null,
			// Format: YYYYMMDD. Example: 20120531 = 2012/02/24
			'enddate'   => null,
			// Used to retrieve sale or earnings stats for a specific product, or all products. This option has two accepted values: all or a product # id.
			'product'   => null,
		) );

		if ( empty( $args['type'] ) ) {
			return null;
		}

		if ( ! empty( $args['startdate'] ) || ! empty( $args['enddate'] ) ) {
			$args['date'] = 'range';
		} else if ( ! in_array( $args['data'], array( 'today', 'yesterday', 'range' ) ) ) {
			$args['data'] = null;
		}

		$request = $this->call_api( 'stats', $args );

		if ( ! $request || is_wp_error( $request ) ) {
			return $request;
		}

		if ( $args['date'] == 'range' ) {
			return $request;
		}

		return ! empty( $request[ $args['type'] ] ) ? $request[ $args['type'] ] : null;
	}


}
