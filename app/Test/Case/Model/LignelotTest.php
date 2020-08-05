<?php
App::uses('Lignelot', 'Model');

/**
 * Lignelot Test Case
 *
 */
class LignelotTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lignelot'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lignelot = ClassRegistry::init('Lignelot');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lignelot);

		parent::tearDown();
	}

}
