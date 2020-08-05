<?php
App::uses('Color', 'Model');

/**
 * Color Test Case
 *
 */
class ColorTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.color',
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
		'app.lineinventory',
		'app.inventory',
		'app.deposit',
		'app.mpfournisseur',
		'app.fournisseur',
		'app.contact',
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
		$this->Color = ClassRegistry::init('Color');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Color);

		parent::tearDown();
	}

}
