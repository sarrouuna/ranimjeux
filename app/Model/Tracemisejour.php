<?php
App::uses('AppModel', 'Model');
/**
 * Tracemisejour Model
 *
 * @property Utilisateur $Utilisateur
 */
class Tracemisejour extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Utilisateur' => array(
			'className' => 'Utilisateur',
			'foreignKey' => 'utilisateur_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
