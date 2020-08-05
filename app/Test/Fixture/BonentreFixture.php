<?php
/**
 * BonentreFixture
 *
 */
class BonentreFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'fournisseur_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'utilisateur_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'date' => array('type' => 'date', 'null' => true, 'default' => null),
		'bonreception_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'facture_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'numero' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
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
			'utilisateur_id' => 1,
			'date' => '2016-04-05',
			'bonreception_id' => 1,
			'facture_id' => 1,
			'numero' => 'Lorem ipsum dolor sit amet'
		),
	);

}
