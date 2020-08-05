<?php
App::uses('Lignelivraison', 'Model');

/**
 * Lignelivraison Test Case
 *
 */
class LignelivraisonTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lignelivraison',
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
		'app.stockdepot'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lignelivraison = ClassRegistry::init('Lignelivraison');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lignelivraison);

		parent::tearDown();
	}

}
