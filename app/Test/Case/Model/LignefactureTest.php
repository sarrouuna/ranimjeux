<?php
App::uses('Lignefacture', 'Model');

/**
 * Lignefacture Test Case
 *
 */
class LignefactureTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lignefacture',
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
		'app.utilisateurs'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lignefacture = ClassRegistry::init('Lignefacture');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lignefacture);

		parent::tearDown();
	}

}
