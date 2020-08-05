<?php
App::uses('AppModel', 'Model');
/**
 * Reglementclient Model
 *
 * @property Client $Client
 * @property Lignereglementclient $Lignereglementclient
 * @property Piecereglementclient $Piecereglementclient
 */
class Affectation extends AppModel {


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
		'Lignereglementclient' => array(
			'className' => 'Lignereglementclient',
			'foreignKey' => 'affectation_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Factureclient' => array(
			'className' => 'Factureclient',
			'foreignKey' => 'affectation_id',
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
