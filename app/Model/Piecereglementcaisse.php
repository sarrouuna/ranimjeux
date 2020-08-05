<?php
App::uses('AppModel', 'Model');
/**
 * Piecereglement Model
 *
 * @property Paiement $Paiement
 * @property Reglement $Reglement
 */
class Piecereglementcaisse extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'paiementcaisse_id';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Paiementcaisse' => array(
			'className' => 'Paiementcaisse',
			'foreignKey' => 'paiementcaisse_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Reglementcaisse' => array(
			'className' => 'Reglementcaisse',
			'foreignKey' => 'reglementcaisse_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
