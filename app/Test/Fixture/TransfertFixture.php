<?php
/**
 * TransfertFixture
 *
 */
class TransfertFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'numero' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'date' => array('type' => 'date', 'null' => true, 'default' => null),
		'utilisateur_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'depotdepart' => array('type' => 'integer', 'null' => true, 'default' => null),
		'depotarrive' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'numero' => 'Lorem ipsum dolor sit amet',
			'date' => '2016-05-23',
			'utilisateur_id' => 1,
			'depotdepart' => 1,
			'depotarrive' => 1
		),
	);

}
