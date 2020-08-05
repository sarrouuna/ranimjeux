<?php
App::uses('Lien', 'Model');

/**
 * Lien Test Case
 *
 */
class LienTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lien',
		'app.utilisateurmenu',
		'app.utilisateur',
		'app.menu'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lien = ClassRegistry::init('Lien');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lien);

		parent::tearDown();
	}

}
