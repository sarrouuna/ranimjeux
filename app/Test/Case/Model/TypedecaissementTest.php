<?php
App::uses('Typedecaissement', 'Model');

/**
 * Typedecaissement Test Case
 *
 */
class TypedecaissementTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.typedecaissement'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Typedecaissement = ClassRegistry::init('Typedecaissement');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Typedecaissement);

		parent::tearDown();
	}

}
