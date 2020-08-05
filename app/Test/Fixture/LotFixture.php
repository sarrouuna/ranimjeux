<?php
/**
 * LotFixture
 *
 */
class LotFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'date' => array('type' => 'date', 'null' => true, 'default' => null),
		'numero' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 50),
		'deposit_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'bill_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'bl_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'date' => '2014-12-09',
			'numero' => 1,
			'deposit_id' => 1,
			'bill_id' => 1,
			'bl_id' => 1
		),
	);

}
