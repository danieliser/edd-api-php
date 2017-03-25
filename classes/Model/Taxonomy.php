<?php

/**
 * Class EDD_API_Model_Taxonomy
 */
class EDD_API_Model_Taxonomy extends EDD_API_Model {

	/**
	 * @var
	 */
	public $term_id;
	/**
	 * @var
	 */
	public $name;
	/**
	 * @var
	 */
	public $slug;
	/**
	 * @var
	 */
	public $term_group;
	/**
	 * @var
	 */
	public $term_taxonomy_id;
	/**
	 * @var
	 */
	public $taxonomy;
	/**
	 * @var
	 */
	public $description;
	/**
	 * @var
	 */
	public $parent;
	/**
	 * @var
	 */
	public $count;
	/**
	 * @var
	 */
	public $filter;
	/**
	 * @var
	 */
	public $object_id;

	/**
	 * EDD_API_Model_Taxonomy constructor.
	 *
	 * @param array $data
	 */
	public function __construct( $data = array() ) {
		parent::__construct( $data );
	}

}
