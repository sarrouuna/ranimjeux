<?php
/**
 * LignefactureavoirFixture
 *
 */
class LignefactureavoirFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'factureavoir_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'depot_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'article_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'datevalidite' => array('type' => 'date', 'null' => true, 'default' => null),
		'quantite' => array('type' => 'integer', 'null' => true, 'default' => null),
		'prix' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'remise' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'fodec' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'tva' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'totalht' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'totalttc' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
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
			'factureavoir_id' => 1,
			'depot_id' => 1,
			'article_id' => 1,
			'datevalidite' => '2016-03-25',
			'quantite' => 1,
			'prix' => 1,
			'remise' => 1,
			'fodec' => 1,
			'tva' => 1,
			'totalht' => 1,
			'totalttc' => 1
		),
	);

}
