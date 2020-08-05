<?php
App::uses('Family', 'Model');

/**
 * Family Test Case
 *
 */
class FamilyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.family'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Family = ClassRegistry::init('Family');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Family);

		parent::tearDown();
	}

}
