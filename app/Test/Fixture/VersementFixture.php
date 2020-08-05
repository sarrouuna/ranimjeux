<?php
/**
 * VersementFixture
 *
 */
class VersementFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'utilisateur_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'compte_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'numero' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 255),
		'date' => array('type' => 'date', 'null' => true, 'default' => null),
		'montant' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '18,3'),
		'etat' => array('type' => 'integer', 'null' => true, 'default' => '0'),
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
			'utilisateur_id' => 1,
			'compte_id' => 1,
			'numero' => 1,
			'date' => '2016-04-26',
			'montant' => 1,
			'etat' => 1
		),
	);

}
