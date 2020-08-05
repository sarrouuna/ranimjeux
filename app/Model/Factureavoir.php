<?php
App::uses('AppModel', 'Model');
/**
 * Factureavoir Model
 *
 * @property Client $Client
 * @property Utilisateurs $Utilisateurs
 * @property Depot $Depot
 * @property Typefacture $Typefacture
 * @property Lignefactureavoir $Lignefactureavoir
 */
class Factureavoir extends AppModel {


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
		'Typefacture' => array(
			'className' => 'Typefacture',
			'foreignKey' => 'typefacture_id',
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
		'Lignefactureavoir' => array(
			'className' => 'Lignefactureavoir',
			'foreignKey' => 'factureavoir_id',
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
