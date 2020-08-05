<?php
App::uses('AppModel', 'Model');
/**
 * Imputationfactureavoirfr Model
 *
 * @property Factureavoirfr $Factureavoirfr
 * @property Facture $Facture
 */
class Imputationfactureavoirfr extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Factureavoirfr' => array(
			'className' => 'Factureavoirfr',
			'foreignKey' => 'factureavoirfr_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Facture' => array(
			'className' => 'Facture',
			'foreignKey' => 'facture_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
