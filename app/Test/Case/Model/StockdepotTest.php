<?php
App::uses('Stockdepot', 'Model');

/**
 * Stockdepot Test Case
 *
 */
class StockdepotTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.stockdepot',
		'app.article',
		'app.famille',
		'app.sousfamille',
		'app.soussousfamille',
		'app.unite',
		'app.articlefournisseur',
		'app.fournisseur',
		'app.famillefournisseur',
		'app.articletag',
		'app.tag',
		'app.depot',
		'app.inventaire',
		'app.ligneinventaire'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Stockdepot = ClassRegistry::init('Stockdepot');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Stockdepot);

		parent::tearDown();
	}

}
