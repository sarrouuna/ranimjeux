<?php
App::uses('Ligneinventaire', 'Model');

/**
 * Ligneinventaire Test Case
 *
 */
class LigneinventaireTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ligneinventaire',
		'app.inventaire',
		'app.depot',
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
		'app.tag'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ligneinventaire = ClassRegistry::init('Ligneinventaire');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ligneinventaire);

		parent::tearDown();
	}

}
