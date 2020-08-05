<?php
App::uses('Lignesorty', 'Model');

/**
 * Lignesorty Test Case
 *
 */
class LignesortyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lignesorty'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lignesorty = ClassRegistry::init('Lignesorty');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lignesorty);

		parent::tearDown();
	}

}
