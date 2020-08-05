<?php
App::uses('Caissee', 'Model');

/**
 * Caissee Test Case
 *
 */
class CaisseeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.caissee'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Caissee = ClassRegistry::init('Caissee');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Caissee);

		parent::tearDown();
	}

}
