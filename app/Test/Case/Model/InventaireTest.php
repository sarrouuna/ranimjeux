<?php
App::uses('Inventaire', 'Model');

/**
 * Inventaire Test Case
 *
 */
class InventaireTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.inventaire',
		'app.depot',
		'app.stockdepot',
		'app.ligneinventaire'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Inventaire = ClassRegistry::init('Inventaire');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Inventaire);

		parent::tearDown();
	}

}
