<?php
App::uses('AppModel', 'Model');
/**
 * Validite Model
 *
 * @property Commande $Commande
 */
class Validite extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Commande' => array(
			'className' => 'Commande',
			'foreignKey' => 'validite_id',
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
