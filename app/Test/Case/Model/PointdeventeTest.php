<?php
App::uses('Pointdevente', 'Model');

/**
 * Pointdevente Test Case
 *
 */
class PointdeventeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.pointdevente',
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
		$this->Pointdevente = ClassRegistry::init('Pointdevente');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Pointdevente);

		parent::tearDown();
	}

}
