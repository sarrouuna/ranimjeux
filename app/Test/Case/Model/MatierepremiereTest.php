<?php
App::uses('Matierepremiere', 'Model');

/**
 * Matierepremiere Test Case
 *
 */
class MatierepremiereTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.matierepremiere',
		'app.type',
		'app.article',
		'app.famille',
		'app.lignecollection',
		'app.collection',
		'app.boncommande',
		'app.client',
		'app.timbre',
		'app.bonlivraison',
		'app.utilisateur',
		'app.devi',
		'app.ligneclient',
		'app.ville',
		'app.pay',
		'app.facture',
		'app.lignefacture',
		'app.transfereblfacture',
		'app.lignebonlivraison',
		'app.transferecommandebl',
		'app.lignecommande',
		'app.transferedeviscommande',
		'app.lignedevi',
		'app.inventaire',
		'app.depot',
		'app.mouvementstock',
		'app.ligneproduction',
		'app.production',
		'app.personnel',
		'app.ligneligneproduction',
		'app.stockdepot',
		'app.ligneinventaire',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.reglement',
		'app.lignereglement',
		'app.piecereglement',
		'app.paiement',
		'app.lignelignecollection',
		'app.modele',
		'app.couleur',
		'app.taille',
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
		'app.inventorie'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Matierepremiere = ClassRegistry::init('Matierepremiere');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Matierepremiere);

		parent::tearDown();
	}

}
