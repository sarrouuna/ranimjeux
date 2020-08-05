<?php
App::uses('Couleur', 'Model');

/**
 * Couleur Test Case
 *
 */
class CouleurTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.couleur',
		'app.article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Couleur = ClassRegistry::init('Couleur');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Couleur);

		parent::tearDown();
	}

}
