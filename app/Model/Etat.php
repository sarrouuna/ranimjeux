<?php
App::uses('AppModel', 'Model');
/**
 * Etat Model
 *
 * @property Homologation $Homologation
 */
class Etat extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Homologation' => array(
			'className' => 'Homologation',
			'foreignKey' => 'etat_id',
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
