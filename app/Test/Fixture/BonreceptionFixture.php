<?php
/**
 * BonreceptionFixture
 *
 */
class BonreceptionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'fournisseur_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'utilisateurs_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'numero' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'date' => array('type' => 'date', 'null' => false, 'default' => null),
		'remise' => array('type' => 'float', 'null' => false, 'default' => null),
		'tva' => array('type' => 'integer', 'null' => false, 'default' => null),
		'fodec' => array('type' => 'integer', 'null' => false, 'default' => null),
		'totalht' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,3'),
		'totalttc' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,3'),
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
			'fournisseur_id' => 1,
			'utilisateurs_id' => 1,
			'numero' => 'Lorem ipsum dolor sit amet',
			'date' => '2016-02-22',
			'remise' => 1,
			'tva' => 1,
			'fodec' => 1,
			'totalht' => 1,
			'totalttc' => 1
		),
	);

}
