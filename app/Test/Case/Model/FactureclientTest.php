<?php
App::uses('Factureclient', 'Model');

/**
 * Factureclient Test Case
 *
 */
class FactureclientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
		'app.stockdepot',
		'app.lignefactureclient'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Factureclient = ClassRegistry::init('Factureclient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Factureclient);

		parent::tearDown();
	}

}
