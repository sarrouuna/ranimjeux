<?php
App::uses('AppModel', 'Model');
/**
 * Reglement Model
 *
 * @property Client $Client
 * @property Lignereglement $Lignereglement
 * @property Piecereglement $Piecereglement
 */
class Reglementcaisse extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'client_id';

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
//            ,
//            'Pointvente' => array(
//			'className' => 'Pointvente',
//			'foreignKey' => 'pointvente_id',
//			'conditions' => '',
//			'fields' => '',
//			'order' => ''
//		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
            
		'Piecereglementcaisse' => array(
			'className' => 'Piecereglementcaisse',
			'foreignKey' => 'reglementcaisse_id',
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
		'Ticketcaiss' => array(
			'className' => 'Ticketcaiss',
			'foreignKey' => 'reglementcaisse_id',
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
