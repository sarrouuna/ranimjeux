<?php
/**
 * MouvementstockFixture
 *
 */
class MouvementstockFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'qte' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => 10),
		'ligneproduction_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'depot_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'qte' => 1,
			'ligneproduction_id' => 1,
			'depot_id' => 1
		),
	);

}
