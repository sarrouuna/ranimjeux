<?php
/**
 * BcFixture
 *
 */
class BcFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'fournisseur_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'date' => array('type' => 'date', 'null' => false, 'default' => null),
		'numero' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 50),
		'bl_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'bl_id' => 1
		),
	);

}
