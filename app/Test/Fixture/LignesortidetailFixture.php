<?php
/**
 * LignesortidetailFixture
 *
 */
class LignesortidetailFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'lignesorti_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'stockdepot_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'quantite' => array('type' => 'integer', 'null' => true, 'default' => null),
		'date' => array('type' => 'date', 'null' => true, 'default' => null),
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
			'lignesorti_id' => 1,
			'stockdepot_id' => 1,
			'quantite' => 1,
			'date' => '2016-03-21'
		),
	);

}
