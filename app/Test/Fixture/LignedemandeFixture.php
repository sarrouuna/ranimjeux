<?php
/**
 * LignedemandeFixture
 *
 */
class LignedemandeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'demande_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'matierepremiere_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'qte' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '10,3'),
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
			'demande_id' => 1,
			'matierepremiere_id' => 1,
			'qte' => 1
		),
	);

}
