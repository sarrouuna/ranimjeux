<?php
/**
 * LineinventoryFixture
 *
 */
class LineinventoryFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'inventorie_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'matierepremiere_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'quantite_paquet' => array('type' => 'integer', 'null' => true, 'default' => null),
		'quantite_piece' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'inventorie_id' => 1,
			'matierepremiere_id' => 1,
			'quantite_paquet' => 1,
			'quantite_piece' => 1
		),
	);

}
