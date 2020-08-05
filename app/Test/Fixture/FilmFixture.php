<?php
/**
 * FilmFixture
 *
 */
class FilmFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'titre' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'lien' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'annee_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'nb_vues' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'notation' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'date_ajout' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'serie_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'nb' => array('type' => 'integer', 'null' => true, 'default' => '0'),
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
			'titre' => 'Lorem ipsum dolor sit amet',
			'lien' => 'Lorem ipsum dolor sit amet',
			'annee_id' => 1,
			'nb_vues' => 1,
			'notation' => 'Lorem ipsum dolor sit amet',
			'date_ajout' => 'Lorem ipsum dolor sit amet',
			'serie_id' => 1,
			'nb' => 1
		),
	);

}
