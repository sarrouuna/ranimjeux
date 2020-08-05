<?php
App::uses('Utilisateurmenu', 'Model');

/**
 * Utilisateurmenu Test Case
 *
 */
class UtilisateurmenuTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.utilisateurmenu',
		'app.utilisateur',
		'app.menu',
		'app.lien'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Utilisateurmenu = ClassRegistry::init('Utilisateurmenu');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Utilisateurmenu);

		parent::tearDown();
	}

}
