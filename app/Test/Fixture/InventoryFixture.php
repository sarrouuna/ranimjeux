<?php
/**
 * InventoryFixture
 *
 */
class InventoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'date' => array('type' => 'date', 'null' => true, 'default' => null),
		'numero' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 63, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'deposit_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'date' => '2014-12-04',
			'numero' => 'Lorem ipsum dolor sit amet',
			'deposit_id' => 1
		),
	);

}
