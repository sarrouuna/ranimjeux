<?php
App::uses('To', 'Model');

/**
 * To Test Case
 *
 */
class ToTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.to',
		'app.piecereglement',
		'app.paiement',
		'app.piecereglementclient',
		'app.reglementclient',
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
		'app.articlefournisseur',
		'app.fournisseur',
		'app.famillefournisseur',
		'app.devise',
		'app.articletag',
		'app.tag',
		'app.stockdepot',
		'app.factureclient',
		'app.timbre',
		'app.lignefactureclient',
		'app.lignelivraison',
		'app.bonsorti',
		'app.commandeclient',
		'app.lignecommandeclient',
		'app.devi',
		'app.lignedevi',
		'app.lignereglementclient',
		'app.societe',
		'app.reglement',
		'app.lignereglement',
		'app.facture',
		'app.lignefacture',
		'app.cheque',
		'app.carnetcheque'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->To = ClassRegistry::init('To');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->To);

		parent::tearDown();
	}

}
