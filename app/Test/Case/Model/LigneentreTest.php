<?php
App::uses('Ligneentre', 'Model');

/**
 * Ligneentre Test Case
 *
 */
class LigneentreTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ligneentre',
		'app.bonentre',
		'app.fournisseur',
		'app.famillefournisseur',
		'app.devise',
		'app.articlefournisseur',
		'app.article',
		'app.famille',
		'app.sousfamille',
		'app.soussousfamille',
		'app.unite',
		'app.articletag',
		'app.tag',
		'app.utilisateur',
		'app.personnel',
		'app.fonction',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.bonreception',
		'app.lignereception',
		'app.facture',
		'app.timbre',
		'app.lignefacture',
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
		$this->Ligneentre = ClassRegistry::init('Ligneentre');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ligneentre);

		parent::tearDown();
	}

}
