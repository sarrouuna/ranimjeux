<?php
App::uses('AppModel', 'Model');
/**
 * Ticketcaiss Model
 *
 * @property Client $Client
 * @property Depot $Depot
 * @property Utilisateur $Utilisateur
 */
class Ticketcaiss extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Cartefidelite' => array(
			'className' => 'Cartefidelite',
			'foreignKey' => 'cartefidelite_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'client_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		), 
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Utilisateur' => array(
			'className' => 'Utilisateur',
			'foreignKey' => 'utilisateur_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		
		'Journee' => array(
			'className' => 'Journee',
			'foreignKey' => 'journee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        public $hasMany = array(
		'Ticketcaisseligne' => array(
			'className' => 'Ticketcaisseligne',
			'foreignKey' => 'ticketcaisse_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Ticketcaisselignepromo' => array(
			'className' => 'Ticketcaisselignepromo',
			'foreignKey' => 'ticketcaisse_id',
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
