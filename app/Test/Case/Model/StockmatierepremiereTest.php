<?php
App::uses('Stockmatierepremiere', 'Model');

/**
 * Stockmatierepremiere Test Case
 *
 */
class StockmatierepremiereTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.stockmatierepremiere',
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
		'app.lineinventory',
		'app.inventorie',
		'app.mpfournisseur'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Stockmatierepremiere = ClassRegistry::init('Stockmatierepremiere');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Stockmatierepremiere);

		parent::tearDown();
	}

}
