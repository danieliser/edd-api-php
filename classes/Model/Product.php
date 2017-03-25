<?php

/**
 * Class EDD_API_Model_Product
 */
class EDD_API_Model_Product extends EDD_API_Model {

	/**************************************
	 * Original API data                  *
	 **************************************/

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
	public $pricing;
	/**
	 * @var
	 */
	public $files;
	/**
	 * @var
	 */
	public $notes;
	/**
	 * @var
	 */
	public $licensing;

	/**************************************
	 * Product Information                *
	 **************************************/

	/**
	 * @var
	 */
	public $id;
	/**
	 * @var
	 */
	public $slug;
	/**
	 * @var
	 */
	public $title;
	/**
	 * @var
	 */
	public $create_date;
	/**
	 * @var
	 */
	public $modified_date;
	/**
	 * @var
	 */
	public $status;
	/**
	 * @var
	 */
	public $link;
	/**
	 * @var
	 */
	public $content;
	/**
	 * @var
	 */
	public $excerpt;
	/**
	 * @var
	 */
	public $thumbnail;

	/**
	 * @var EDD_API_Model_Category
	 */
	public $category;
	/**
	 * @var
	 */
	public $tags;
	/**
	 * @var
	 */
	public $sku;

	/**************************************
	 * Product Stats                      *
	 **************************************/

	/**
	 * @var
	 */
	public $total_sales;
	/**
	 * @var
	 */
	public $total_earnings;
	/**
	 * @var
	 */
	public $monthly_average_sales;
	/**
	 * @var
	 */
	public $monthly_average_earnings;

	/**
	 * EDD_API_Model_Product constructor.
	 *
	 * @param array $data
	 */
	public function __construct( $data = array() ) {
		parent::__construct( $data );

		if ( ! empty ( $this->info ) ) {
			$this->set_properties( $this->info );

			// Category
			if ( ! empty( $this->category ) ) {
				if ( ! isset( $this->category[0] ) ) {
					$this->category = array( $this->category );
				}

				foreach ( $this->category as $key => $category ) {
					$this->category[ $key ] = new EDD_API_Model_Category( $category );
				}
			}
			// Tags
			if ( ! empty( $this->tags ) ) {
				foreach ( $this->tags as $key => $tag ) {
					$this->tags[ $key ] = new EDD_API_Model_Tag( $tag );
				}
			}
		}

		if ( ! empty( $this->stats ) ) {
			foreach ( $this->stats as $prefix => $values ) {
				foreach ( $values as $key => $val ) {
					$key        = "{$prefix}_{$key}";
					$this->$key = $val;
				}
			}
		}

		// Files
		if ( ! empty( $this->files ) ) {
			foreach ( $this->files as $key => $file ) {
				$this->files[ $key ] = new EDD_API_Model_File( $file );
			}
		}
	}
}
