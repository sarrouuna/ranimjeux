<?php
App::uses('Bonlivraison', 'Model');

/**
 * Bonlivraison Test Case
 *
 */
class BonlivraisonTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.bonlivraison',
		'app.client',
		'app.utilisateur',
		'app.personnel',
		'app.fonction',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.depot',
		'app.inventaire',
		'app.ligneinventaire',
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
		'app.stockdepot',
		'app.lignelivraison'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Bonlivraison = ClassRegistry::init('Bonlivraison');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Bonlivraison);

		parent::tearDown();
	}

}
