<?php
App::uses('Banque', 'Model');

/**
 * Banque Test Case
 *
 */
class BanqueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.banque',
		'app.piece',
		'app.client',
		'app.timbre',
		'app.boncommande',
		'app.utilisateur',
		'app.fonction',
		'app.bonlivraison',
		'app.ligneclient',
		'app.ville',
		'app.pay',
		'app.devi',
		'app.lignedevi',
		'app.article',
		'app.famille',
		'app.marque',
		'app.inventaire',
		'app.depot',
		'app.lignelignecollection',
		'app.lignecollection',
		'app.collection',
		'app.lignecommande',
		'app.mouvementstock',
		'app.ligneproduction',
		'app.production',
		'app.personnel',
		'app.acompte',
		'app.moi',
		'app.annee',
		'app.paie',
		'app.ligneligneproduction',
		'app.stockdepot',
		'app.ligneinventaire',
		'app.lignebonlivraison',
		'app.modele',
		'app.couleur',
		'app.taille',
		'app.type',
		'app.lignefacture',
		'app.facture',
		'app.transfereblfacture',
		'app.transferedeviscommande',
		'app.commande',
		'app.lignereglement',
		'app.reglement',
		'app.piecereglement',
		'app.paiement',
		'app.transferecommandebl',
		'app.bonsorty',
		'app.demande',
		'app.lignedemande',
		'app.matierepremiere',
		'app.unite',
		'app.family',
		'app.machine',
		'app.emplacement',
		'app.color',
		'app.typestock',
		'app.lbill',
		'app.bill',
		'app.fournisseur',
		'app.contact',
		'app.mpfournisseur',
		'app.bl',
		'app.bc',
		'app.lc',
		'app.lbl',
		'app.lot',
		'app.deposit',
		'app.inventory',
		'app.lignelot',
		'app.lineinventory',
		'app.stockmatierepremiere',
		'app.inventorie',
		'app.lignesorty',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Banque = ClassRegistry::init('Banque');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Banque);

		parent::tearDown();
	}

}
