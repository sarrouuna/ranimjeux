<?php
App::uses('Emplacement', 'Model');

/**
 * Emplacement Test Case
 *
 */
class EmplacementTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.emplacement'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Emplacement = ClassRegistry::init('Emplacement');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Emplacement);

		parent::tearDown();
	}

}
