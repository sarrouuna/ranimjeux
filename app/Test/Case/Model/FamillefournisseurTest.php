<?php
App::uses('Famillefournisseur', 'Model');

/**
 * Famillefournisseur Test Case
 *
 */
class FamillefournisseurTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.famillefournisseur',
		'app.fournisseur'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Famillefournisseur = ClassRegistry::init('Famillefournisseur');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Famillefournisseur);

		parent::tearDown();
	}

}
