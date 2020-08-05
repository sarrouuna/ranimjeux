<?php
App::uses('Famille', 'Model');

/**
 * Famille Test Case
 *
 */
class FamilleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.famille',
		'app.article',
		'app.sousfamille',
		'app.soussousfamille'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Famille = ClassRegistry::init('Famille');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Famille);

		parent::tearDown();
	}

}
