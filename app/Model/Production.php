<?php
App::uses('AppModel', 'Model');
/**
 * Production Model
 *
 * @property Exercice $Exercice
 * @property Utilisateur $Utilisateur
 * @property Ligneproduction $Ligneproduction
 */
class Production extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Exercice' => array(
			'className' => 'Exercice',
			'foreignKey' => 'exercice_id',
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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Ligneproduction' => array(
			'className' => 'Ligneproduction',
			'foreignKey' => 'production_id',
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
