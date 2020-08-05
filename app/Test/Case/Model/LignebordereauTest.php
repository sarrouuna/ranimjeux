<?php
App::uses('Lignebordereau', 'Model');

/**
 * Lignebordereau Test Case
 *
 */
class LignebordereauTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lignebordereau',
		'app.bordereau',
		'app.utilisateur',
		'app.personnel',
		'app.fonction',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lignebordereau = ClassRegistry::init('Lignebordereau');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lignebordereau);

		parent::tearDown();
	}

}
