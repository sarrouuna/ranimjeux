<?php
App::uses('Taille', 'Model');

/**
 * Taille Test Case
 *
 */
class TailleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.taille',
		'app.article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Taille = ClassRegistry::init('Taille');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Taille);

		parent::tearDown();
	}

}
