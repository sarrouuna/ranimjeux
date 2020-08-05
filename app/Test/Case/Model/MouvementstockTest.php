<?php
App::uses('Mouvementstock', 'Model');

/**
 * Mouvementstock Test Case
 *
 */
class MouvementstockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.mouvementstock',
		'app.ligneproduction',
		'app.production',
		'app.article',
		'app.famille',
		'app.reference',
		'app.modele',
		'app.couleur',
		'app.taille',
		'app.type',
		'app.lignebonlivraison',
		'app.bonlivraison',
		'app.client',
		'app.timbre',
		'app.boncommande',
		'app.utilisateur',
		'app.devi',
		'app.ligneclient',
		'app.ville',
		'app.pay',
		'app.facture',
		'app.lignefacture',
		'app.transfereblfacture',
		'app.lignedevi',
		'app.transferedeviscommande',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.reglement',
		'app.transferecommandebl',
		'app.lignecommande',
		'app.commande',
		'app.stockdepot',
		'app.personnel',
		'app.ligneligneproduction',
		'app.depot'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Mouvementstock = ClassRegistry::init('Mouvementstock');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Mouvementstock);

		parent::tearDown();
	}

}
