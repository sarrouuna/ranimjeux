<?php
App::uses('Machine', 'Model');

/**
 * Machine Test Case
 *
 */
class MachineTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.machine'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Machine = ClassRegistry::init('Machine');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Machine);

		parent::tearDown();
	}

}
