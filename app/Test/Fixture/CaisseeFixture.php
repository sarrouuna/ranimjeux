<?php
/**
 * CaisseeFixture
 *
 */
class CaisseeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'date' => array('type' => 'date', 'null' => true, 'default' => null),
		'type' => array('type' => 'integer', 'null' => true, 'default' => null),
		'raison' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'montant' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '18,3'),
		'solde' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '18,3'),
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
			'date' => '2016-04-28',
			'type' => 1,
			'raison' => 'Lorem ipsum dolor sit amet',
			'montant' => 1,
			'solde' => 1
		),
	);

}
