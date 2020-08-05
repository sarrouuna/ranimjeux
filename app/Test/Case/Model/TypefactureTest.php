<?php
App::uses('Typefacture', 'Model');

/**
 * Typefacture Test Case
 *
 */
class TypefactureTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.typefacture',
		'app.factureavoir'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Typefacture = ClassRegistry::init('Typefacture');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Typefacture);

		parent::tearDown();
	}

}
