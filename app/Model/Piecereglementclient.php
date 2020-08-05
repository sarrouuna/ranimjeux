<?php
App::uses('AppModel', 'Model');
/**
 * Piecereglementclient Model
 *
 * @property Paiement $Paiement
 * @property Reglementclient $Reglementclient
 */
class Piecereglementclient extends AppModel {


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
		'Reglementclient' => array(
			'className' => 'Reglementclient',
			'foreignKey' => 'reglementclient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'Client' => array(
			'className' => 'Client',
			'foreignKey' => '',
			'conditions' => 'Reglementclient.client_id=Client.id',
			'fields' => '',
			'order' => ''
		),
		'Compte' => array(
			'className' => 'Compte',
			'foreignKey' => 'compte_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
