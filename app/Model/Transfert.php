<?php
App::uses('AppModel', 'Model');
/**
 * Transfert Model
 *
 * @property Utilisateur $Utilisateur
 * @property Lignetransfert $Lignetransfert
 */
class Transfert extends AppModel {


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
		),'Societe' => array(
			'className' => 'Societe',
			'foreignKey' => 'societedepart',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'Societearrive' => array(
			'className' => 'Societe',
			'foreignKey' => 'societearrive',
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
		'Lignetransfert' => array(
			'className' => 'Lignetransfert',
			'foreignKey' => 'transfert_id',
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
