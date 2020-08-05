<?php
/**
 * MatierepremiereFixture
 *
 */
class MatierepremiereFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'designation' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'prixachat' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'stockalert' => array('type' => 'integer', 'null' => true, 'default' => null),
		'quantite' => array('type' => 'integer', 'null' => true, 'default' => null),
		'dimension' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'type_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'unite_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'family_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'machine_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'emplacement_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'color_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'typestock_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'qte_pqt' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'qte_piece' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
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
			'code' => 'Lorem ipsum dolor sit amet',
			'designation' => 'Lorem ipsum dolor sit amet',
			'prixachat' => 1,
			'stockalert' => 1,
			'quantite' => 1,
			'dimension' => 'Lorem ipsum dolor sit amet',
			'type_id' => 1,
			'unite_id' => 1,
			'family_id' => 1,
			'machine_id' => 1,
			'emplacement_id' => 1,
			'color_id' => 1,
			'typestock_id' => 1,
			'qte_pqt' => 1,
			'qte_piece' => 1
		),
	);

}
