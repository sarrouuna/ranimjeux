<?php
/**
 * BordereauFixture
 *
 */
class BordereauFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'utilisateur_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'numero' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'banque' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'date' => array('type' => 'date', 'null' => true, 'default' => null),
		'rib' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'benificiaire' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'montant' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '18,3'),
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
			'numero' => 'Lorem ipsum dolor sit amet',
			'banque' => 'Lorem ipsum dolor sit amet',
			'date' => '2016-04-22',
			'rib' => 'Lorem ipsum dolor sit amet',
			'benificiaire' => 'Lorem ipsum dolor sit amet',
			'montant' => 1
		),
	);

}
