<?php
App::uses('Mois', 'Model');

/**
 * Mois Test Case
 *
 */
class MoisTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.mois'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Mois = ClassRegistry::init('Mois');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Mois);

		parent::tearDown();
	}

}
