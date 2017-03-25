<?php

/**
 * Class EDD_API_Model_Taxonomy
 */
class EDD_API_Model_Taxonomy extends EDD_API_Model {

	public $term_id;
	public $name;
	public $slug;
	public $term_group;
	public $term_taxonomy_id;
	public $taxonomy;
	public $description;
	public $parent;
	public $count;
	public $filter;
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
