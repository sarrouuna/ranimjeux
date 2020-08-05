<?php
App::uses('AppModel', 'Model');
/**
 * Situation Model
 *
 * @property Namesituation $Namesituation
 * @property Importation $Importation
 * @property Importation $Importation
 */
class Situation extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Namesituation' => array(
			'className' => 'Namesituation',
			'foreignKey' => 'namesituation_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Importation' => array(
			'className' => 'Importation',
			'foreignKey' => 'importation_id',
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
		'Importation' => array(
			'className' => 'Importation',
			'foreignKey' => 'situation_id',
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
