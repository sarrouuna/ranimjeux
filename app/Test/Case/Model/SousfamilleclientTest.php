<?php
App::uses('Sousfamilleclient', 'Model');

/**
 * Sousfamilleclient Test Case
 *
 */
class SousfamilleclientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sousfamilleclient',
		'app.familleclient'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Sousfamilleclient = ClassRegistry::init('Sousfamilleclient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Sousfamilleclient);

		parent::tearDown();
	}

}
