<?php
App::uses('Fonction', 'Model');

/**
 * Fonction Test Case
 *
 */
class FonctionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.fonction',
		'app.personnel'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Fonction = ClassRegistry::init('Fonction');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Fonction);

		parent::tearDown();
	}

}
