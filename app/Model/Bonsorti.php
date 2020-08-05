<?php
App::uses('AppModel', 'Model');
/**
 * Bonsorti Model
 *
 * @property Client $Client
 * @property Utilisateurs $Utilisateurs
 * @property Bonlivraison $Bonlivraison
 * @property Factureclient $Factureclient
 */
class Bonsorti extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'bonlivraison_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'factureclient_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'date' => array(
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
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Client' => array(
			'className' => 'Client',
			'foreignKey' => 'client_id',
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
		),
		'Bonlivraison' => array(
			'className' => 'Bonlivraison',
			'foreignKey' => 'bonlivraison_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Factureclient' => array(
			'className' => 'Factureclient',
			'foreignKey' => 'factureclient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
