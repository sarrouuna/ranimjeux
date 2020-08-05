<?php
App::uses('Ligneproduction', 'Model');

/**
 * Ligneproduction Test Case
 *
 */
class LigneproductionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
		'app.mouvementstock'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ligneproduction = ClassRegistry::init('Ligneproduction');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ligneproduction);

		parent::tearDown();
	}

}
