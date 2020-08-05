<?php
App::uses('AppModel', 'Model');
/**
 * Situationpiecereglementclient Model
 *
 * @property Piecereglement $Piecereglement
 * @property Utilisateur $Utilisateur
 */
class Situationpiecereglementclient extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Piecereglementclient' => array(
			'className' => 'Piecereglementclient',
			'foreignKey' => 'piecereglementclient_id',
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
		)
	);
}
