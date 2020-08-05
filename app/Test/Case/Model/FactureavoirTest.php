<?php
App::uses('Factureavoir', 'Model');

/**
 * Factureavoir Test Case
 *
 */
class FactureavoirTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.factureavoir',
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
		'app.article',
		'app.famille',
		'app.sousfamille',
		'app.soussousfamille',
		'app.unite',
		'app.homologation',
		'app.articlehomologation',
		'app.articlefournisseur',
		'app.fournisseur',
		'app.famillefournisseur',
		'app.articletag',
		'app.tag',
		'app.stockdepot',
		'app.factureclient',
		'app.lignefactureclient',
		'app.lignelivraison',
		'app.bonsorti',
		'app.commandeclient',
		'app.lignecommandeclient',
		'app.devi',
		'app.lignedevi',
		'app.utilisateurs',
		'app.typefacture',
		'app.lignefactureavoir'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Factureavoir = ClassRegistry::init('Factureavoir');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Factureavoir);

		parent::tearDown();
	}

}
