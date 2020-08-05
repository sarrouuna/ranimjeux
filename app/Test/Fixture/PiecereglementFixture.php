<?php
/**
 * PiecereglementFixture
 *
 */
class PiecereglementFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'paiement_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'reglement_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'id_piece' => array('type' => 'integer', 'null' => true, 'default' => null),
		'Montant' => array('type' => 'float', 'null' => true, 'default' => null, 'length' => '18,3'),
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
			'paiement_id' => 1,
			'reglement_id' => 1,
			'id_piece' => 1,
			'Montant' => 1
		),
	);

}
