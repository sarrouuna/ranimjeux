<?php
App::uses('Transfereblfacture', 'Model');

/**
 * Transfereblfacture Test Case
 *
 */
class TransfereblfactureTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.transfereblfacture',
		'app.lignebonlivraison',
		'app.bonlivraison',
		'app.client',
		'app.timbre',
		'app.boncommande',
		'app.utilisateur',
		'app.devi',
		'app.ligneclient',
		'app.ville',
		'app.pay',
		'app.facture',
		'app.lignefacture',
		'app.article',
		'app.famille',
		'app.reference',
		'app.modele',
		'app.couleur',
		'app.taille',
		'app.type',
		'app.lignecommande',
		'app.commande',
		'app.transferecommandebl',
		'app.transferedeviscommande',
		'app.lignedevi',
		'app.ligneproduction',
		'app.production',
		'app.personnel',
		'app.ligneligneproduction',
		'app.mouvementstock',
		'app.depot',
		'app.stockdepot',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.reglement',
		'app.lignereglement',
		'app.piecereglement',
		'app.paiement'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Transfereblfacture = ClassRegistry::init('Transfereblfacture');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Transfereblfacture);

		parent::tearDown();
	}

}
