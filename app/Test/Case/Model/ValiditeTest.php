<?php
App::uses('Validite', 'Model');

/**
 * Validite Test Case
 *
 */
class ValiditeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.validite',
		'app.commande',
		'app.fournisseur',
		'app.famillefournisseur',
		'app.articlefournisseur',
		'app.article',
		'app.famille',
		'app.sousfamille',
		'app.soussousfamille',
		'app.unite',
		'app.homologation',
		'app.articlehomologation',
		'app.articletag',
		'app.tag',
		'app.lignecommande'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Validite = ClassRegistry::init('Validite');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Validite);

		parent::tearDown();
	}

}
