<?php
/**
 * LignebordereauFixture
 *
 */
class LignebordereauFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'bordereau_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'banque' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'rib' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
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
			'bordereau_id' => 1,
			'banque' => 'Lorem ipsum dolor sit amet',
			'rib' => 'Lorem ipsum dolor sit amet',
			'montant' => 1
		),
	);

}
