<?php
App::uses('AppModel', 'Model');
/**
 * Copiestockdepot Model
 *
 * @property Inventaire $Inventaire
 * @property Exercice $Exercice
 * @property Utilisateur $Utilisateur
 * @property Lignecopiestock $Lignecopiestock
 */
class Copiestockdepot extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Inventaire' => array(
			'className' => 'Inventaire',
			'foreignKey' => 'inventaire_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
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
		'Lignecopiestock' => array(
			'className' => 'Lignecopiestock',
			'foreignKey' => 'copiestockdepot_id',
			'dependent' => true,
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
