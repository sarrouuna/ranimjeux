<?php
App::uses('Facture', 'Model');

/**
 * Facture Test Case
 *
 */
class FactureTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.facture',
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
		'app.depot',
		'app.inventaire',
		'app.ligneinventaire',
		'app.stockdepot',
		'app.utilisateurs',
		'app.lignefacture'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Facture = ClassRegistry::init('Facture');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Facture);

		parent::tearDown();
	}

}
