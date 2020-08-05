<?php
App::uses('Personnel', 'Model');

/**
 * Personnel Test Case
 *
 */
class PersonnelTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.personnel',
		'app.fonction'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Personnel = ClassRegistry::init('Personnel');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Personnel);

		parent::tearDown();
	}

}
