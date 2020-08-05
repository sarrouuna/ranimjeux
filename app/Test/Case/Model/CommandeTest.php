<?php
App::uses('Commande', 'Model');

/**
 * Commande Test Case
 *
 */
class CommandeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.commande',
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
		'app.lignecommande'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Commande = ClassRegistry::init('Commande');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Commande);

		parent::tearDown();
	}

}
