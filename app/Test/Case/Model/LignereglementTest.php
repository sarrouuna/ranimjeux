<?php
App::uses('Lignereglement', 'Model');

/**
 * Lignereglement Test Case
 *
 */
class LignereglementTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lignereglement',
		'app.reglement',
		'app.piecereglement'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lignereglement = ClassRegistry::init('Lignereglement');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lignereglement);

		parent::tearDown();
	}

}
