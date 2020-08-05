<?php
/**
 * ArticleFixture
 *
 */
class ArticleFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'famille_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'sousfamille_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'soussousfamille_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'unite_id' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'code' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'stockalert' => array('type' => 'integer', 'null' => true, 'default' => null),
		'prixvente' => array('type' => 'float', 'null' => true, 'default' => null),
		'prixachat' => array('type' => 'float', 'null' => true, 'default' => null),
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
			'famille_id' => 1,
			'sousfamille_id' => 1,
			'soussousfamille_id' => 1,
			'unite_id' => 'Lorem ipsum dolor sit amet',
			'code' => 'Lorem ipsum dolor sit amet',
			'name' => 'Lorem ipsum dolor sit amet',
			'stockalert' => 1,
			'prixvente' => 1,
			'prixachat' => 1
		),
	);

}
