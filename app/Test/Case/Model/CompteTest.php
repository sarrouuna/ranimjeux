<?php
App::uses('Compte', 'Model');

/**
 * Compte Test Case
 *
 */
class CompteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.compte'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Compte = ClassRegistry::init('Compte');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Compte);

		parent::tearDown();
	}

}
