<?php
/**
 * LignedeviFixture
 *
 */
class LignedeviFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'devi_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'article_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'qauntite' => array('type' => 'integer', 'null' => true, 'default' => null),
		'prix' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => 10),
		'remise' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => 10),
		'fodec' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => 10),
		'tva' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => 10),
		'totalht' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => 10),
		'totalttc' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => 10),
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
			'devi_id' => 1,
			'article_id' => 1,
			'qauntite' => 1,
			'prix' => 1,
			'remise' => 1,
			'fodec' => 1,
			'tva' => 1,
			'totalht' => 1,
			'totalttc' => 1
		),
	);

}
