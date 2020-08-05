<?php
/**
 * TransfereblfactureFixture
 *
 */
class TransfereblfactureFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'lignebonlivraison_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'lignefacture_id' => array('type' => 'integer', 'null' => true, 'default' => null),
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
			'lignebonlivraison_id' => 1,
			'lignefacture_id' => 1
		),
	);

}
