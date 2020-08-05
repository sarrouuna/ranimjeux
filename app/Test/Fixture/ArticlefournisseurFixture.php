<?php
/**
 * ArticlefournisseurFixture
 *
 */
class ArticlefournisseurFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'article_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'fournisseur_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'prix' => array('type' => 'float', 'null' => true, 'default' => null),
		'reference' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
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
			'article_id' => 1,
			'fournisseur_id' => 1,
			'prix' => 1,
			'reference' => 'Lorem ipsum dolor sit amet'
		),
	);

}
