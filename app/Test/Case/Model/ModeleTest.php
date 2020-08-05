<?php
App::uses('Modele', 'Model');

/**
 * Modele Test Case
 *
 */
class ModeleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.modele',
		'app.article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Modele = ClassRegistry::init('Modele');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Modele);

		parent::tearDown();
	}

}
