<?php
App::uses('Retourstockmp', 'Model');

/**
 * Retourstockmp Test Case
 *
 */
class RetourstockmpTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.retourstockmp',
		'app.deposit',
		'app.entreemp',
		'app.fournisseur',
		'app.famillefournisseur',
		'app.facturecharge',
		'app.facturefournisseur',
		'app.utilisateur',
		'app.fonction',
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
		'app.reglement',
		'app.lignereglement',
		'app.piecereglement',
		'app.paiement',
		'app.piece',
		'app.banque',
		'app.lignebonlivraison',
		'app.ligneinventairefamille',
		'app.inventairefamille',
		'app.familletaille',
		'app.taille',
		'app.coutmp',
		'app.coutmpligne',
		'app.familie',
		'app.famillecomposant',
		'app.modele',
		'app.couleur',
		'app.type',
		'app.lignefacture',
		'app.facture',
		'app.transfereblfacture',
		'app.transferedeviscommande',
		'app.commande',
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
		'app.bl',
		'app.bc',
		'app.lc',
		'app.lbl',
		'app.lot',
		'app.lignelot',
		'app.lignempe',
		'app.lignempsorti',
		'app.sortiemp',
		'app.lignepre',
		'app.entreepr',
		'app.livfournisseur',
		'app.lignelivfournisseur',
		'app.mpfournisseur',
		'app.ligneprsorti',
		'app.sortiepr',
		'app.lignesorty',
		'app.lineinventory',
		'app.inventory',
		'app.stockmatierepremiere',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.lignefacturefournisseur',
		'app.contact',
		'app.retourstockmpligne'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Retourstockmp = ClassRegistry::init('Retourstockmp');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Retourstockmp);

		parent::tearDown();
	}

}
