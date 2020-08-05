<?php
App::uses('Filmtype', 'Model');

/**
 * Filmtype Test Case
 *
 */
class FilmtypeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.filmtype',
		'app.film',
		'app.annee',
		'app.serie',
		'app.type'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Filmtype = ClassRegistry::init('Filmtype');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Filmtype);

		parent::tearDown();
	}

}
