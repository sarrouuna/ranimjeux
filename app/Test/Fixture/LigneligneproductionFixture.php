<?php
/**
 * LigneligneproductionFixture
 *
 */
class LigneligneproductionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'date' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'qte' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'ligneproduction_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'mouvementstock_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'date' => '2014-11-06 16:13:56',
			'qte' => 1,
			'ligneproduction_id' => 1,
			'mouvementstock_id' => 1
		),
	);

}
