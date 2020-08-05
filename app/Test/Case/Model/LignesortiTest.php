<?php
App::uses('Lignesorti', 'Model');

/**
 * Lignesorti Test Case
 *
 */
class LignesortiTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lignesorti',
		'app.bonsortie',
		'app.article',
		'app.famille',
		'app.sousfamille',
		'app.soussousfamille',
		'app.unite',
		'app.homologation',
		'app.articlefournisseur',
		'app.fournisseur',
		'app.famillefournisseur',
		'app.articletag',
		'app.tag',
		'app.depot',
		'app.inventaire',
		'app.ligneinventaire',
		'app.stockdepot',
		'app.lignelivraison',
		'app.bonlivraison',
		'app.client',
		'app.utilisateur',
		'app.personnel',
		'app.fonction',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.factureclient',
		'app.lignefactureclient',
		'app.lignefacture',
		'app.facture'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lignesorti = ClassRegistry::init('Lignesorti');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lignesorti);

		parent::tearDown();
	}

}
