<?php
App::uses('AppModel', 'Model');
/**
 * Bonlivraison Model
 *
 * @property Client $Client
 * @property Utilisateur $Utilisateur
 * @property Depot $Depot
 * @property Lignelivraison $Lignelivraison
 */
class Bonlivraison extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'client_id',
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
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
            ,
		'Factureclient' => array(
			'className' => 'Factureclient',
			'foreignKey' => 'factureclient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Pointdevente' => array(
			'className' => 'Pointdevente',
			'foreignKey' => 'pointdevente_id',
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
		'Lignelivraison' => array(
			'className' => 'Lignelivraison',
			'foreignKey' => 'bonlivraison_id',
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
