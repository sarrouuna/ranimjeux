<?php
App::uses('AppModel', 'Model');
/**
 * Situationpersonnel Model
 *
 * @property Namesituation $Namesituation
 * @property Personnel $Personnel
 */
class Situationpersonnel extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'namesituation_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

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
		'Personnel' => array(
			'className' => 'Personnel',
			'foreignKey' => 'personnel_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
