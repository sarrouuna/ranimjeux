<?php
App::uses('AppModel', 'Model');
/**
 * Factureclient Model
 *
 * @property Client $Client
 * @property Utilisateurs $Utilisateurs
 * @property Depot $Depot
 * @property Lignefactureclient $Lignefactureclient
 */
class Factureclient extends AppModel {


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
		),
                'Timbre' => array(
			'className' => 'Timbre',
			'foreignKey' => 'timbre_id',
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
		'Lignefactureclient' => array(
			'className' => 'Lignefactureclient',
			'foreignKey' => 'factureclient_id',
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
