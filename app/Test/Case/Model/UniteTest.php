<?php
App::uses('Unite', 'Model');

/**
 * Unite Test Case
 *
 */
class UniteTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.unite',
		'app.article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Unite = ClassRegistry::init('Unite');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Unite);

		parent::tearDown();
	}

}
