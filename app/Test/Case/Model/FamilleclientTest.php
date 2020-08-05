<?php
App::uses('Familleclient', 'Model');

/**
 * Familleclient Test Case
 *
 */
class FamilleclientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.familleclient',
		'app.sousfamilleclient'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Familleclient = ClassRegistry::init('Familleclient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Familleclient);

		parent::tearDown();
	}

}
