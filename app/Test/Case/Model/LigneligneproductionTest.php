<?php
App::uses('Ligneligneproduction', 'Model');

/**
 * Ligneligneproduction Test Case
 *
 */
class LigneligneproductionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ligneligneproduction',
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
		'app.mouvementstock'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ligneligneproduction = ClassRegistry::init('Ligneligneproduction');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ligneligneproduction);

		parent::tearDown();
	}

}
