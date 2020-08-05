<?php
App::uses('Bonsorty', 'Model');

/**
 * Bonsorty Test Case
 *
 */
class BonsortyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.bonsorty',
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
		'app.lignedemande',
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
		'app.inventorie'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Bonsorty = ClassRegistry::init('Bonsorty');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Bonsorty);

		parent::tearDown();
	}

}
