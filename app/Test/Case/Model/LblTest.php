<?php
App::uses('Lbl', 'Model');

/**
 * Lbl Test Case
 *
 */
class LblTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lbl',
		'app.bl',
		'app.fournisseur',
		'app.contact',
		'app.pay',
		'app.ligneclient',
		'app.ville',
		'app.client',
		'app.timbre',
		'app.boncommande',
		'app.utilisateur',
		'app.bonlivraison',
		'app.lignebonlivraison',
		'app.article',
		'app.famille',
		'app.lignecollection',
		'app.collection',
		'app.lignecommande',
		'app.transferecommandebl',
		'app.transferedeviscommande',
		'app.lignedevi',
		'app.devi',
		'app.lignelignecollection',
		'app.modele',
		'app.couleur',
		'app.taille',
		'app.type',
		'app.lignefacture',
		'app.facture',
		'app.transfereblfacture',
		'app.ligneinventaire',
		'app.inventaire',
		'app.depot',
		'app.mouvementstock',
		'app.ligneproduction',
		'app.production',
		'app.personnel',
		'app.ligneligneproduction',
		'app.stockdepot',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.reglement',
		'app.lignereglement',
		'app.piecereglement',
		'app.paiement',
		'app.mpfournisseur',
		'app.matierepremiere',
		'app.unite',
		'app.family',
		'app.machine',
		'app.emplacement',
		'app.color',
		'app.typestock',
		'app.lineinventory',
		'app.inventory',
		'app.deposit',
		'app.stockmatierepremiere',
		'app.inventorie',
		'app.bill',
		'app.bc',
		'app.lc',
		'app.lot'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lbl = ClassRegistry::init('Lbl');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lbl);

		parent::tearDown();
	}

}
