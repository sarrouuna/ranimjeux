<?php
App::uses('Contact', 'Model');

/**
 * Contact Test Case
 *
 */
class ContactTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.contact',
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
		'app.client',
		'app.familleclient',
		'app.sousfamilleclient',
		'app.zone',
		'app.bonlivraison',
		'app.utilisateur',
		'app.personnel',
		'app.fonction',
		'app.utilisateurmenu',
		'app.menu',
		'app.lien',
		'app.depot',
		'app.inventaire',
		'app.ligneinventaire',
		'app.stockdepot',
		'app.factureclient',
		'app.timbre',
		'app.lignefactureclient',
		'app.lignelivraison',
		'app.bonsorti',
		'app.commandeclient',
		'app.lignecommandeclient',
		'app.devi',
		'app.lignedevi'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Contact = ClassRegistry::init('Contact');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Contact);

		parent::tearDown();
	}

}
