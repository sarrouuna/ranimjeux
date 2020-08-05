<?php
App::uses('Ligneclient', 'Model');

/**
 * Ligneclient Test Case
 *
 */
class LigneclientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ligneclient',
		'app.ville',
		'app.pay',
		'app.client',
		'app.timbre',
		'app.boncommande',
		'app.bonlivraison',
		'app.devi',
		'app.facture',
		'app.reglement'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ligneclient = ClassRegistry::init('Ligneclient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ligneclient);

		parent::tearDown();
	}

}
