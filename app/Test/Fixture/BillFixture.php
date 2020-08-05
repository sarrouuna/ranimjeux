<?php
/**
 * BillFixture
 *
 */
class BillFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'fournisseur_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'date' => array('type' => 'date', 'null' => true, 'default' => null),
		'numero' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 50),
		'prix_ht' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'prix_ttc' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
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
			'fournisseur_id' => 1,
			'date' => '2014-12-09',
			'numero' => 1,
			'prix_ht' => 1,
			'prix_ttc' => 1
		),
	);

}
