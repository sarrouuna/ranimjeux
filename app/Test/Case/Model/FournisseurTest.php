<?php
App::uses('Fournisseur', 'Model');

/**
 * Fournisseur Test Case
 *
 */
class FournisseurTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.fournisseur',
		'app.famillefournisseur',
		'app.articlefournisseur'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Fournisseur = ClassRegistry::init('Fournisseur');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Fournisseur);

		parent::tearDown();
	}

}
