<?php
App::uses('AppModel', 'Model');
/**
 * Carnetcheque Model
 *
 * @property Cheque $Cheque
 */
class Carnetcheque extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Cheque' => array(
			'className' => 'Cheque',
			'foreignKey' => 'carnetcheque_id',
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
        public $belongsTo = array(
		'Compte' => array(
			'className' => 'Compte',
			'foreignKey' => 'compte_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
