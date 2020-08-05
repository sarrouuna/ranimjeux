<?php
App::uses('Pay', 'Model');

/**
 * Pay Test Case
 *
 */
class PayTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.pay',
		'app.ligneclient'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Pay = ClassRegistry::init('Pay');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Pay);

		parent::tearDown();
	}

}
