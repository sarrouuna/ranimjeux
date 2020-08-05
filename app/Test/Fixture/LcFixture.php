<?php
/**
 * LcFixture
 *
 */
class LcFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'bc_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'matierepremiere_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'qte_pqt' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'qte_piece' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'qte_liv' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
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
			'bc_id' => 1,
			'matierepremiere_id' => 1,
			'qte_pqt' => 1,
			'qte_piece' => 1,
			'qte_liv' => 1
		),
	);

}
