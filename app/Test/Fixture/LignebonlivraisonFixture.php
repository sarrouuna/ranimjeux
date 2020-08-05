<?php
/**
 * LignebonlivraisonFixture
 *
 */
class LignebonlivraisonFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'bonlivraison_id' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'article_id' => array('type' => 'string', 'null' => true, 'default' => '0', 'length' => 110, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'designation' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'Qte' => array('type' => 'float', 'null' => true, 'default' => '1.000', 'length' => '18,3'),
		'Prix' => array('type' => 'float', 'null' => true, 'default' => '0.000', 'length' => '18,3'),
		'Remise' => array('type' => 'float', 'null' => true, 'default' => '0.000', 'length' => '18,3'),
		'Fodec' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'Tva' => array('type' => 'float', 'null' => true, 'default' => '0'),
		'Total_HT' => array('type' => 'float', 'null' => true, 'default' => '0.000', 'length' => '18,3'),
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
			'bonlivraison_id' => 1,
			'article_id' => 'Lorem ipsum dolor sit amet',
			'designation' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'Qte' => 1,
			'Prix' => 1,
			'Remise' => 1,
			'Fodec' => 1,
			'Tva' => 1,
			'Total_HT' => 1
		),
	);

}
