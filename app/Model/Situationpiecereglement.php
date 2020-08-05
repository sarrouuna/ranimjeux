<?php
App::uses('AppModel', 'Model');
/**
 * Situationpiecereglement Model
 *
 * @property Etatpiecereglement $Etatpiecereglement
 * @property Piecereglement $Piecereglement
 */
class Situationpiecereglement extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Etatpiecereglement' => array(
			'className' => 'Etatpiecereglement',
			'foreignKey' => 'etatpiecereglement_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Piecereglement' => array(
			'className' => 'Piecereglement',
			'foreignKey' => 'piecereglement_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
