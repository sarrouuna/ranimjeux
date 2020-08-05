<?php
/**
 * LigneproductionFixture
 *
 */
class LigneproductionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'qte' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'qte_liv' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'qte_rest' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'production_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'article_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'personnel_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'qte_liv' => 1,
			'qte_rest' => 1,
			'production_id' => 1,
			'article_id' => 1,
			'personnel_id' => 1
		),
	);

}
