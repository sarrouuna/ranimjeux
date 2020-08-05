<?php
App::uses('AppModel', 'Model');
/**
 * Devi Model
 *
 * @property Client $Client
 * @property Lignedevi $Lignedevi
 */
class Devi extends AppModel {


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
                'Typedevisclient' => array(
			'className' => 'Typedevisclient',
			'foreignKey' => 'typedevisclient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'Typesuivitdevi' => array(
			'className' => 'Typesuivitdevi',
			'foreignKey' => 'typesuivitdevi_id',
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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Lignedevi' => array(
			'className' => 'Lignedevi',
			'foreignKey' => 'devi_id',
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
