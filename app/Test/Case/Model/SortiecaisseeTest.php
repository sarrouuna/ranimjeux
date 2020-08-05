<?php
App::uses('Sortiecaissee', 'Model');

/**
 * Sortiecaissee Test Case
 *
 */
class SortiecaisseeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.sortiecaissee',
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
		$this->Sortiecaissee = ClassRegistry::init('Sortiecaissee');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Sortiecaissee);

		parent::tearDown();
	}

}
