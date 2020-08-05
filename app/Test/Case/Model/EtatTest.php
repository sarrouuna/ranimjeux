<?php
App::uses('Etat', 'Model');

/**
 * Etat Test Case
 *
 */
class EtatTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.etat',
		'app.homologation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Etat = ClassRegistry::init('Etat');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Etat);

		parent::tearDown();
	}

}
