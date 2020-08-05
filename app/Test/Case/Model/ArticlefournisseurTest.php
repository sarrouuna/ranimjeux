<?php
App::uses('Articlefournisseur', 'Model');

/**
 * Articlefournisseur Test Case
 *
 */
class ArticlefournisseurTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.articlefournisseur',
		'app.article',
		'app.famille',
		'app.sousfamille',
		'app.soussousfamille',
		'app.unite',
		'app.articletag',
		'app.tag',
		'app.fournisseur',
		'app.famillefournisseur'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Articlefournisseur = ClassRegistry::init('Articlefournisseur');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Articlefournisseur);

		parent::tearDown();
	}

}
