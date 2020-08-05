<?php
App::uses('AppModel', 'Model');
/**
 * Commandeclient Model
 *
 * @property Client $Client
 * @property Lignecommandeclient $Lignecommandeclient
 */
class Commandeclient extends AppModel {


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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Lignecommandeclient' => array(
			'className' => 'Lignecommandeclient',
			'foreignKey' => 'commandeclient_id',
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
