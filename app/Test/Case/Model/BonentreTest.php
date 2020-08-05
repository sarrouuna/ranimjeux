<?php
App::uses('Bonentre', 'Model');

/**
 * Bonentre Test Case
 *
 */
class BonentreTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
		'app.ligneentre'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Bonentre = ClassRegistry::init('Bonentre');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Bonentre);

		parent::tearDown();
	}

}
