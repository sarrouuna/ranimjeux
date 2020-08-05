<?php
App::uses('AppModel', 'Model');
/**
 * Namesituation Model
 *
 * @property Situation $Situation
 */
class Namesituation extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Situation' => array(
			'className' => 'Situation',
			'foreignKey' => 'namesituation_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),'Situationpersonnel' => array(
			'className' => 'Situationpersonnel',
			'foreignKey' => 'namesituation_id',
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
