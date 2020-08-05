<?php
App::uses('AppModel', 'Model');
/**
 * Reglement Model
 *
 * @property Fournisseur $Fournisseur
 * @property Lignereglement $Lignereglement
 * @property Piecereglement $Piecereglement
 */
class Reglement extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Fournisseur' => array(
			'className' => 'Fournisseur',
			'foreignKey' => 'fournisseur_id',
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
		'Lignereglement' => array(
			'className' => 'Lignereglement',
			'foreignKey' => 'reglement_id',
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
			'foreignKey' => 'reglement_id',
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
