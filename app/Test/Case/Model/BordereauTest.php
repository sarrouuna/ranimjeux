<?php
App::uses('Bordereau', 'Model');

/**
 * Bordereau Test Case
 *
 */
class BordereauTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.bordereau',
		'app.utilisateur',
		'app.personnel',
		'app.fonction',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.lignebordereau'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Bordereau = ClassRegistry::init('Bordereau');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Bordereau);

		parent::tearDown();
	}

}
