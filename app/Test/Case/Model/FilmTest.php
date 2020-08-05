<?php
App::uses('Film', 'Model');

/**
 * Film Test Case
 *
 */
class FilmTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.film',
		'app.annee',
		'app.serie',
		'app.filmtype'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Film = ClassRegistry::init('Film');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Film);

		parent::tearDown();
	}

}
