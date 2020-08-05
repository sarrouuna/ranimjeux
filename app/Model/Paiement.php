<?php
App::uses('AppModel', 'Model');
/**
 * Paiement Model
 *
 * @property Piecereglementclient $Piecereglementclient
 * @property Piecereglement $Piecereglement
 */
class Paiement extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Piecereglementclient' => array(
			'className' => 'Piecereglementclient',
			'foreignKey' => 'paiement_id',
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
		'Piecereglement' => array(
			'className' => 'Piecereglement',
			'foreignKey' => 'paiement_id',
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
