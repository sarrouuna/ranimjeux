<?php
/**
 * ReglementFixture
 *
 */
class ReglementFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'client_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'Date' => array('type' => 'date', 'null' => true, 'default' => null),
		'Retenu' => array('type' => 'float', 'null' => true, 'default' => '0.000', 'length' => '18,3'),
		'Montant' => array('type' => 'float', 'null' => true, 'default' => '0.000', 'length' => '18,3'),
		'versement' => array('type' => 'integer', 'null' => true, 'default' => '0'),
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
			'Date' => '2014-11-06',
			'Retenu' => 1,
			'Montant' => 1,
			'versement' => 1
		),
	);

}
