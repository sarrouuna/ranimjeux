<?php
App::uses('Soussousfamille', 'Model');

/**
 * Soussousfamille Test Case
 *
 */
class SoussousfamilleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.soussousfamille',
		'app.famille',
		'app.article',
		'app.sousfamille'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Soussousfamille = ClassRegistry::init('Soussousfamille');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Soussousfamille);

		parent::tearDown();
	}

}
