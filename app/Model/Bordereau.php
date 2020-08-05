<?php
App::uses('AppModel', 'Model');
/**
 * Bordereau Model
 *
 * @property Utilisateur $Utilisateur
 * @property Lignebordereau $Lignebordereau
 */
class Bordereau extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Utilisateur' => array(
			'className' => 'Utilisateur',
			'foreignKey' => 'utilisateur_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'Compte' => array(
			'className' => 'Compte',
			'foreignKey' => 'compte_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'Factoring' => array(
			'className' => 'Compte',
			'foreignKey' => 'factoring',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'Paiement' => array(
			'className' => 'Paiement',
			'foreignKey' => 'paiement_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Lignebordereau' => array(
			'className' => 'Lignebordereau',
			'foreignKey' => 'bordereau_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
