<?php
App::uses('AppModel', 'Model');
/**
 * Lignereglementclient Model
 *
 * @property Reglementclient $Reglementclient
 * @property Factureclient $Factureclient
 */
class Lignereglementclient extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Reglementclient' => array(
			'className' => 'Reglementclient',
			'foreignKey' => 'reglementclient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Factureclient' => array(
			'className' => 'Factureclient',
			'foreignKey' => 'factureclient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'Piecereglementclient' => array(
			'className' => 'Piecereglementclient',
			'foreignKey' => 'piecereglementclient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
