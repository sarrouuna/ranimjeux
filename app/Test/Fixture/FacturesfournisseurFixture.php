<?php
/**
 * FacturesfournisseurFixture
 *
 */
class FacturesfournisseurFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'Numero' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 20, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'fournisseur_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'Date' => array('type' => 'date', 'null' => true, 'default' => '0000-00-00'),
		'Total_HT' => array('type' => 'float', 'null' => true, 'default' => '0.000', 'length' => '18,3'),
		'Remise' => array('type' => 'float', 'null' => true, 'default' => '0.000', 'length' => '10,3'),
		'Tva' => array('type' => 'float', 'null' => true, 'default' => '0.000', 'length' => '10,3'),
		'Total_TTC' => array('type' => 'float', 'null' => true, 'default' => '0.000', 'length' => '18,3'),
		'fodec' => array('type' => 'float', 'null' => true, 'default' => '0.000', 'length' => '10,3'),
		'Montant_Regler' => array('type' => 'float', 'null' => true, 'default' => '0.000', 'length' => '18,3'),
		'utilisateur_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'timbre_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'timbre' => array('type' => 'float', 'null' => true, 'default' => '0.500', 'length' => '10,3'),
		'remise_reglement' => array('type' => 'float', 'null' => true, 'default' => '0.000', 'length' => '10,3'),
		'Type' => array('type' => 'integer', 'null' => false, 'default' => null),
		'typ' => array('type' => 'integer', 'null' => true, 'default' => '1'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'id' => array('column' => 'id', 'unique' => 0)
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
			'Numero' => 'Lorem ipsum dolor ',
			'fournisseur_id' => 1,
			'Date' => '2015-06-16',
			'Total_HT' => 1,
			'Remise' => 1,
			'Tva' => 1,
			'Total_TTC' => 1,
			'fodec' => 1,
			'Montant_Regler' => 1,
			'utilisateur_id' => 1,
			'timbre_id' => 1,
			'timbre' => 1,
			'remise_reglement' => 1,
			'Type' => 1,
			'typ' => 1
		),
	);

}
