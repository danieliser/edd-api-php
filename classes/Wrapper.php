<?php

/**
 * Class EDD_API_Wrapper
 */
class EDD_API_Wrapper {

	/**
	 * @var
	 */
	private $url;
	/**
	 * @var
	 */
	private $key;
	/**
	 * @var
	 */
	private $token;

	/**
	 * EDD_API_Wrapper constructor.
	 *
	 * @param array $args
	 */
	public function __construct( $args = array() ) {
		$args = wp_parse_args( $args, array(
			'url'   => defined( 'EDD_API_URL' ) ? EDD_API_URL : '',
			'key'   => defined( 'EDD_API_KEY' ) ? EDD_API_KEY : '',
			'token' => defined( 'EDD_API_TOKEN' ) ? EDD_API_TOKEN : '',
		) );

		$this->url   = $args['url'];
		$this->key   = $args['key'];
		$this->token = $args['token'];

		return $this;
	}

	/**
	 * @param array $args
	 *
	 * @return static
	 */
	public static function instance( $args = array() ) {
		static $instance;

		if ( ! isset( $instance ) ) {
			$instance = new static( $args );
		}

		return $instance;
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

		return $this->call_api( 'customers', $args );
	}

	/**
	 * @param $endpoint
	 * @param array $args
	 *
	 * @return array|bool|mixed|object
	 */
	public function call_api( $endpoint, $args = array() ) {

		$query_string = wp_parse_args( $args, array(
			'key'   => $this->key,
			'token' => $this->token,
		) );

		$url = $this->url . $endpoint . '?' . http_build_query( array_filter( $query_string ) );

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

}
