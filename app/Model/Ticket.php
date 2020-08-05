<?php
App::uses('AppModel', 'Model');
/**
 * Ticket Model
 *
 * @property Piecereglementcaisse $Piecereglementcaisse
 */
class Ticket extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'piecereglementcaisse_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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
		'Piecereglementcaisse' => array(
			'className' => 'Piecereglementcaisse',
			'foreignKey' => 'piecereglementcaisse_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
