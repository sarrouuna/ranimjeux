<?php
/**
 * BonsortyFixture
 *
 */
class BonsortyFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'demande_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'date' => array('type' => 'date', 'null' => true, 'default' => null),
		'numero' => array('type' => 'integer', 'null' => true, 'default' => null),
		'utilisateur_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'lot_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'demande_id' => 1,
			'date' => '2014-12-15',
			'numero' => 1,
			'utilisateur_id' => 1,
			'lot_id' => 1
		),
	);

}
