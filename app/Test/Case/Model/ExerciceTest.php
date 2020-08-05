<?php
App::uses('Exercice', 'Model');

/**
 * Exercice Test Case
 *
 */
class ExerciceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.exercice'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Exercice = ClassRegistry::init('Exercice');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Exercice);

		parent::tearDown();
	}

}
