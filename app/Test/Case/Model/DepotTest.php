<?php
App::uses('Depot', 'Model');

/**
 * Depot Test Case
 *
 */
class DepotTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.depot',
		'app.inventaire',
		'app.stockdepot'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Depot = ClassRegistry::init('Depot');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Depot);

		parent::tearDown();
	}

}
