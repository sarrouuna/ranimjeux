<?php
App::uses('Lignefactureclient', 'Model');

/**
 * Lignefactureclient Test Case
 *
 */
class LignefactureclientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lignefactureclient',
		'app.factureclient',
		'app.fournisseur',
		'app.famillefournisseur',
		'app.articlefournisseur',
		'app.article',
		'app.famille',
		'app.sousfamille',
		'app.soussousfamille',
		'app.unite',
		'app.articletag',
		'app.tag',
		'app.utilisateurs',
		'app.depot',
		'app.inventaire',
		'app.ligneinventaire',
		'app.stockdepot'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lignefactureclient = ClassRegistry::init('Lignefactureclient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lignefactureclient);

		parent::tearDown();
	}

}
