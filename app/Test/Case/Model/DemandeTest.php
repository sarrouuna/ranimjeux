<?php
App::uses('Demande', 'Model');

/**
 * Demande Test Case
 *
 */
class DemandeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.demande',
		'app.utilisateur',
		'app.boncommande',
		'app.client',
		'app.timbre',
		'app.bonlivraison',
		'app.ligneclient',
		'app.ville',
		'app.pay',
		'app.devi',
		'app.lignedevi',
		'app.article',
		'app.famille',
		'app.lignecollection',
		'app.collection',
		'app.lignecommande',
		'app.transferecommandebl',
		'app.lignebonlivraison',
		'app.transfereblfacture',
		'app.lignefacture',
		'app.facture',
		'app.transferedeviscommande',
		'app.lignelignecollection',
		'app.modele',
		'app.couleur',
		'app.taille',
		'app.type',
		'app.ligneinventaire',
		'app.inventaire',
		'app.depot',
		'app.mouvementstock',
		'app.ligneproduction',
		'app.production',
		'app.personnel',
		'app.ligneligneproduction',
		'app.stockdepot',
		'app.reglement',
		'app.lignereglement',
		'app.piecereglement',
		'app.paiement',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.bonsorty',
		'app.lignedemande'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Demande = ClassRegistry::init('Demande');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Demande);

		parent::tearDown();
	}

}
