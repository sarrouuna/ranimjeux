<?php
App::uses('Lignesortidetail', 'Model');

/**
 * Lignesortidetail Test Case
 *
 */
class LignesortidetailTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lignesortidetail',
		'app.lignesorti',
		'app.bonsorti',
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
		'app.homologation',
		'app.articlefournisseur',
		'app.fournisseur',
		'app.famillefournisseur',
		'app.articletag',
		'app.tag',
		'app.stockdepot',
		'app.factureclient',
		'app.lignefactureclient',
		'app.lignelivraison',
		'app.utilisateurs',
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
		$this->Lignesortidetail = ClassRegistry::init('Lignesortidetail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lignesortidetail);

		parent::tearDown();
	}

}
