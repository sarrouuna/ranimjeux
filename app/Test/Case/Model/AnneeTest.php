<?php
App::uses('Annee', 'Model');

/**
 * Annee Test Case
 *
 */
class AnneeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.annee',
		'app.film'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Annee = ClassRegistry::init('Annee');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Annee);

		parent::tearDown();
	}

}
