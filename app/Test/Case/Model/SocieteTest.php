<?php
App::uses('Societe', 'Model');

/**
 * Societe Test Case
 *
 */
class SocieteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.societe'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Societe = ClassRegistry::init('Societe');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Societe);

		parent::tearDown();
	}

}
