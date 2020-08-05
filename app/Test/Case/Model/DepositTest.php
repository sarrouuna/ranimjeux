<?php
App::uses('Deposit', 'Model');

/**
 * Deposit Test Case
 *
 */
class DepositTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.deposit',
		'app.inventory'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Deposit = ClassRegistry::init('Deposit');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Deposit);

		parent::tearDown();
	}

}
