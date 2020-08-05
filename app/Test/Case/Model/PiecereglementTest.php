<?php
App::uses('Piecereglement', 'Model');

/**
 * Piecereglement Test Case
 *
 */
class PiecereglementTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.piecereglement',
		'app.paiement',
		'app.reglement',
		'app.lignereglement'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Piecereglement = ClassRegistry::init('Piecereglement');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Piecereglement);

		parent::tearDown();
	}

}
