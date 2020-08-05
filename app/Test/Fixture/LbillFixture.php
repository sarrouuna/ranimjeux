<?php
/**
 * LbillFixture
 *
 */
class LbillFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'bill_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'matierepremiere_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'qte_piece' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'prix_unit' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'remise' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'tva' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'prix_ht' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'bill_id' => 1,
			'matierepremiere_id' => 1,
			'qte_piece' => 1,
			'prix_unit' => 1,
			'remise' => 1,
			'tva' => 1,
			'prix_ht' => 1
		),
	);

}
