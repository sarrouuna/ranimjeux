<?php
/**
 * LignesortyFixture
 *
 */
class LignesortyFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'bonsorty_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'matierepremiere_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'lignedemande_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'qte_piece' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
		'qte_pqt' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
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
			'bonsorty_id' => 1,
			'matierepremiere_id' => 1,
			'lignedemande_id' => 1,
			'qte_piece' => 1,
			'qte_pqt' => 1,
			'lot_id' => 1
		),
	);

}
