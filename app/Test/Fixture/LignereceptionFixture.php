<?php
/**
 * LignereceptionFixture
 *
 */
class LignereceptionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'bonreception_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'article_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'quantite' => array('type' => 'integer', 'null' => false, 'default' => null),
		'datefabrication' => array('type' => 'date', 'null' => false, 'default' => null),
		'datevalidite' => array('type' => 'date', 'null' => false, 'default' => null),
		'numerolot' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'prixhtva' => array('type' => 'float', 'null' => false, 'default' => null),
		'remise' => array('type' => 'float', 'null' => false, 'default' => null),
		'fodec' => array('type' => 'integer', 'null' => false, 'default' => null),
		'tva' => array('type' => 'integer', 'null' => false, 'default' => null),
		'totalht' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,3'),
		'totalttc' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,3'),
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
			'bonreception_id' => 1,
			'article_id' => 1,
			'quantite' => 1,
			'datefabrication' => '2016-02-22',
			'datevalidite' => '2016-02-22',
			'numerolot' => 'Lorem ipsum dolor sit amet',
			'prixhtva' => 1,
			'remise' => 1,
			'fodec' => 1,
			'tva' => 1,
			'totalht' => 1,
			'totalttc' => 1
		),
	);

}
