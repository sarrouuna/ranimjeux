<?php
App::uses('Typestock', 'Model');

/**
 * Typestock Test Case
 *
 */
class TypestockTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.typestock'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Typestock = ClassRegistry::init('Typestock');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Typestock);

		parent::tearDown();
	}

}
