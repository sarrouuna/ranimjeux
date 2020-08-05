<?php
App::uses('AppModel', 'Model');
/**
 * Cartefidelite Model
 *
 * @property Ticketcaiss $Ticketcaiss
 */
class Cartefidelite extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'datecreation' => array(
			'date' => array(
				'rule' => array('date'),
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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Ticketcaiss' => array(
			'className' => 'Ticketcaiss',
			'foreignKey' => 'cartefidelite_id',
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
