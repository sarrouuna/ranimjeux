<?php
App::uses('Sousfamille', 'Model');

/**
 * Sousfamille Test Case
 *
 */
class SousfamilleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sousfamille',
		'app.famille',
		'app.article',
		'app.soussousfamille'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Sousfamille = ClassRegistry::init('Sousfamille');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Sousfamille);

		parent::tearDown();
	}

}
