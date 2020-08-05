<?php
App::uses('AppModel', 'Model');
/**
 * Lignereglement Model
 *
 * @property Reglement $Reglement
 * @property Facture $Facture
 */
class Lignereglement extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Reglement' => array(
			'className' => 'Reglement',
			'foreignKey' => 'reglement_id',
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
