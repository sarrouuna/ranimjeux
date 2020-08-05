<?php
App::uses('Utilisateur', 'Model');

/**
 * Utilisateur Test Case
 *
 */
class UtilisateurTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.utilisateur',
		'app.menu',
		'app.utilisateurmenu'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Utilisateur = ClassRegistry::init('Utilisateur');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Utilisateur);

		parent::tearDown();
	}

}
