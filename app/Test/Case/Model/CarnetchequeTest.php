<?php
App::uses('Carnetcheque', 'Model');

/**
 * Carnetcheque Test Case
 *
 */
class CarnetchequeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.carnetcheque',
		'app.cheque'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Carnetcheque = ClassRegistry::init('Carnetcheque');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Carnetcheque);

		parent::tearDown();
	}

}
