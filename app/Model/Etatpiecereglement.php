<?php
App::uses('AppModel', 'Model');
/**
 * Etatpiecereglement Model
 *
 * @property Situationpiecereglement $Situationpiecereglement
 */
class Etatpiecereglement extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Situationpiecereglement' => array(
			'className' => 'Situationpiecereglement',
			'foreignKey' => 'etatpiecereglement_id',
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
