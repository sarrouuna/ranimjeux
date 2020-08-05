<?php
App::uses('AppModel', 'Model');
/**
 * Famillefournisseur Model
 *
 * @property Fournisseur $Fournisseur
 */
class Famillefournisseur extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Fournisseur' => array(
			'className' => 'Fournisseur',
			'foreignKey' => 'famillefournisseur_id',
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
