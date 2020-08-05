<?php
App::uses('Mpfournisseur', 'Model');

/**
 * Mpfournisseur Test Case
 *
 */
class MpfournisseurTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.mpfournisseur',
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
		'app.matierepremiere',
		'app.unite',
		'app.lineinventory',
		'app.inventory',
		'app.deposit',
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
		$this->Mpfournisseur = ClassRegistry::init('Mpfournisseur');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Mpfournisseur);

		parent::tearDown();
	}

}
