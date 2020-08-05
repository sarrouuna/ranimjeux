<?php
App::uses('Reglement', 'Model');

/**
 * Reglement Test Case
 *
 */
class ReglementTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.reglement',
		'app.client',
		'app.timbre',
		'app.boncommande',
		'app.utilisateur',
		'app.bonlivraison',
		'app.ligneclient',
		'app.ville',
		'app.pay',
		'app.devi',
		'app.lignedevi',
		'app.article',
		'app.famille',
		'app.reference',
		'app.modele',
		'app.couleur',
		'app.taille',
		'app.type',
		'app.lignebonlivraison',
		'app.transfereblfacture',
		'app.transferecommandebl',
		'app.lignecommande',
		'app.commande',
		'app.transferedeviscommande',
		'app.lignefacture',
		'app.facture',
		'app.ligneproduction',
		'app.production',
		'app.personnel',
		'app.ligneligneproduction',
		'app.mouvementstock',
		'app.depot',
		'app.stockdepot',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.lignereglement',
		'app.piecereglement',
		'app.paiement'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Reglement = ClassRegistry::init('Reglement');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Reglement);

		parent::tearDown();
	}

}
