<?php
App::uses('Boncommande', 'Model');

/**
 * Boncommande Test Case
 *
 */
class BoncommandeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.boncommande',
		'app.client',
		'app.timbre',
		'app.bonlivraison',
		'app.devi',
		'app.facture',
		'app.reglement',
		'app.utilisateur',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.ligneclient',
		'app.ville',
		'app.pay'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Boncommande = ClassRegistry::init('Boncommande');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Boncommande);

		parent::tearDown();
	}

}
