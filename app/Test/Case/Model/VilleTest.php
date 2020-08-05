<?php
App::uses('Ville', 'Model');

/**
 * Ville Test Case
 *
 */
class VilleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ville',
		'app.ligneclient'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ville = ClassRegistry::init('Ville');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ville);

		parent::tearDown();
	}

}
