<?php
/**
 * LignefactureFixture
 *
 */
class LignefactureFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'facture_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'article_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'quantite' => array('type' => 'integer', 'null' => true, 'default' => null),
		'datefabrication' => array('type' => 'date', 'null' => true, 'default' => null),
		'datevalidite' => array('type' => 'date', 'null' => true, 'default' => null),
		'numerolot' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => 10),
		'prixhtva' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => 10),
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
			'facture_id' => 1,
			'article_id' => 1,
			'quantite' => 1,
			'datefabrication' => '2016-03-01',
			'datevalidite' => '2016-03-01',
			'numerolot' => 1,
			'prixhtva' => 1,
			'remise' => 1,
			'fodec' => 1,
			'tva' => 1,
			'totalht' => 1,
			'totalttc' => 1
		),
	);

}
