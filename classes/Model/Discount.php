<?php

/**
 * Class EDD_API_Model_Discount
 */
class EDD_API_Model_Discount extends EDD_API_Model {

	public $ID;
	public $name;
	public $code;
	public $amount;
	public $min_price;
	public $type;
	public $uses;
	public $max_uses;
	public $start_date;
	public $exp_date;
	public $status;
	public $product_requirements;
	public $requirement_condition;
	public $global_discount;
	public $single_use;

}