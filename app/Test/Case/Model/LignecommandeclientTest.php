<?php
App::uses('Lignecommandeclient', 'Model');

/**
 * Lignecommandeclient Test Case
 *
 */
class LignecommandeclientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lignecommandeclient',
		'app.commandeclient',
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
		$this->Lignecommandeclient = ClassRegistry::init('Lignecommandeclient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lignecommandeclient);

		parent::tearDown();
	}

}
