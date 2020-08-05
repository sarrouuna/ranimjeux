<?php
/**
 * LignetransfertFixture
 *
 */
class LignetransfertFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'article_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'quantite' => array('type' => 'integer', 'null' => true, 'default' => null),
		'transfert_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'article_id' => 1,
			'quantite' => 1,
			'transfert_id' => 1
		),
	);

}
