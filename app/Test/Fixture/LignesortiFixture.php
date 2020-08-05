<?php
/**
 * LignesortiFixture
 *
 */
class LignesortiFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'bonsortie_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'article_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'depot_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'quantite' => array('type' => 'integer', 'null' => true, 'default' => null),
		'lignelivraison_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'lignefacture_id' => array('type' => 'integer', 'null' => false, 'default' => '0'),
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
			'bonsortie_id' => 1,
			'article_id' => 1,
			'depot_id' => 1,
			'quantite' => 1,
			'lignelivraison_id' => 1,
			'lignefacture_id' => 1
		),
	);

}
