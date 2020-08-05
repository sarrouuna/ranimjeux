<?php
/**
 * BonsortiFixture
 *
 */
class BonsortiFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'client_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'utilisateurs_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'bonlivraison_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'factureclient_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'date' => array('type' => 'date', 'null' => false, 'default' => null),
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
			'utilisateurs_id' => 1,
			'bonlivraison_id' => 1,
			'factureclient_id' => 1,
			'date' => '2016-03-21'
		),
	);

}
