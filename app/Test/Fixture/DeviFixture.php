<?php
/**
 * DeviFixture
 *
 */
class DeviFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'client_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'numero' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'date' => array('type' => 'date', 'null' => true, 'default' => null),
		'remise' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'tva' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'fodec' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'totalht' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'totalttc' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'client_id' => 1,
			'numero' => 'Lorem ipsum dolor sit amet',
			'date' => '2016-03-18',
			'remise' => 1,
			'tva' => 1,
			'fodec' => 1,
			'totalht' => 1,
			'totalttc' => 1
		),
	);

}
