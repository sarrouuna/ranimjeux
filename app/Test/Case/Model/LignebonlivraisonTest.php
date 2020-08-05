<?php
App::uses('Lignebonlivraison', 'Model');

/**
 * Lignebonlivraison Test Case
 *
 */
class LignebonlivraisonTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
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
		'app.lignedevi',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.reglement',
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
		'app.ligneproduction',
		'app.stockdepot',
		'app.transfereblfacture'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lignebonlivraison = ClassRegistry::init('Lignebonlivraison');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lignebonlivraison);

		parent::tearDown();
	}

}
