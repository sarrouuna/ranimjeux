<?php
App::uses('Lignedemande', 'Model');

/**
 * Lignedemande Test Case
 *
 */
class LignedemandeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lignedemande',
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
		'app.lot',
		'app.deposit',
		'app.inventory',
		'app.bill',
		'app.fournisseur',
		'app.contact',
		'app.mpfournisseur',
		'app.matierepremiere',
		'app.unite',
		'app.family',
		'app.machine',
		'app.emplacement',
		'app.color',
		'app.typestock',
		'app.lbill',
		'app.lbl',
		'app.bl',
		'app.bc',
		'app.lc',
		'app.lignelot',
		'app.lineinventory',
		'app.stockmatierepremiere',
		'app.inventorie',
		'app.lignesorty'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lignedemande = ClassRegistry::init('Lignedemande');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lignedemande);

		parent::tearDown();
	}

}
