<?php
App::uses('AppModel', 'Model');
/**
 * Engagementcompte Model
 *
 * @property Paiement $Paiement
 * @property Compte $Compte
 */
class Engagementcompte extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Paiement' => array(
			'className' => 'Paiement',
			'foreignKey' => 'paiement_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Compte' => array(
			'className' => 'Compte',
			'foreignKey' => 'compte_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
