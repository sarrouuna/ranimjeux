<?php
App::uses('Cheque', 'Model');

/**
 * Cheque Test Case
 *
 */
class ChequeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cheque',
		'app.carnetcheque'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Cheque = ClassRegistry::init('Cheque');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Cheque);

		parent::tearDown();
	}

}
