<?php
App::uses('Paiement', 'Model');

/**
 * Paiement Test Case
 *
 */
class PaiementTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.paiement',
		'app.piecereglement'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Paiement = ClassRegistry::init('Paiement');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Paiement);

		parent::tearDown();
	}

}
