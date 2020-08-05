<?php
App::uses('Timbre', 'Model');

/**
 * Timbre Test Case
 *
 */
class TimbreTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.timbre',
		'app.boncommande',
		'app.bonlivraison',
		'app.client',
		'app.type',
		'app.devi',
		'app.facture'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Timbre = ClassRegistry::init('Timbre');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Timbre);

		parent::tearDown();
	}

}
