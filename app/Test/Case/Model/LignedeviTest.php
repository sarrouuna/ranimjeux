<?php
App::uses('Lignedevi', 'Model');

/**
 * Lignedevi Test Case
 *
 */
class LignedeviTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lignedevi',
		'app.devi',
		'app.client',
		'app.bonlivraison',
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
		'app.factureclient',
		'app.lignefactureclient',
		'app.lignelivraison'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lignedevi = ClassRegistry::init('Lignedevi');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lignedevi);

		parent::tearDown();
	}

}
