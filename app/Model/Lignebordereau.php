<?php
App::uses('AppModel', 'Model');
/**
 * Lignebordereau Model
 *
 * @property Bordereau $Bordereau
 */
class Lignebordereau extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Bordereau' => array(
			'className' => 'Bordereau',
			'foreignKey' => 'bordereau_id',
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
