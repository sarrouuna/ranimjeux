<?php
/**
 * LignefactureclientFixture
 *
 */
class LignefactureclientFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'factureclient_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'article_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'quantite' => array('type' => 'integer', 'null' => false, 'default' => null),
		'prix' => array('type' => 'integer', 'null' => false, 'default' => null),
		'remise' => array('type' => 'integer', 'null' => false, 'default' => null),
		'fodec' => array('type' => 'integer', 'null' => false, 'default' => null),
		'tva' => array('type' => 'integer', 'null' => false, 'default' => null),
		'totalht' => array('type' => 'integer', 'null' => false, 'default' => null),
		'totalttc' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			
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
			'factureclient_id' => 1,
			'article_id' => 1,
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
