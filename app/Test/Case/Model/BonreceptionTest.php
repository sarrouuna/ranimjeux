<?php
App::uses('Bonreception', 'Model');

/**
 * Bonreception Test Case
 *
 */
class BonreceptionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.bonreception',
		'app.fournisseur',
		'app.famillefournisseur',
		'app.articlefournisseur',
		'app.article',
		'app.famille',
		'app.sousfamille',
		'app.soussousfamille',
		'app.unite',
		'app.articletag',
		'app.tag',
		'app.utilisateurs',
		'app.lignereception'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Bonreception = ClassRegistry::init('Bonreception');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Bonreception);

		parent::tearDown();
	}

}
