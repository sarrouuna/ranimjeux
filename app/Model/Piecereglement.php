<?php
App::uses('AppModel', 'Model');
/**
 * Piecereglement Model
 *
 * @property Paiement $Paiement
 * @property Reglement $Reglement
 */
class Piecereglement extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Paiement' => array(
			'className' => 'Paiement',
			'foreignKey' => 'paiement_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Reglement' => array(
			'className' => 'Reglement',
			'foreignKey' => 'reglement_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Societe' => array(
			'className' => 'Societe',
			'foreignKey' => 'societe_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'Cheque' => array(
			'className' => 'Cheque',
			'foreignKey' => 'cheque_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		) ,
                'Carnetcheque' => array(
			'className' => 'Carnetcheque',
			'foreignKey' => 'carnetcheque_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'Compte' => array(
			'className' => 'Compte',
			'foreignKey' => 'compte_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'To' => array(
			'className' => 'To',
			'foreignKey' => 'to_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
            
	);
}
