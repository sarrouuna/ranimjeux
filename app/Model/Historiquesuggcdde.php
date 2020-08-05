<?php
App::uses('AppModel', 'Model');
/**
 * Historiquesuggcdde Model
 *
 * @property Utilisateur $Utilisateur
 * @property Lignedeviprospect $Lignedeviprospect
 * @property Deviprospect $Deviprospect
 */
class Historiquesuggcdde extends AppModel {


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
		),
		'Lignedeviprospect' => array(
			'className' => 'Lignedeviprospect',
			'foreignKey' => 'lignedeviprospect_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Deviprospect' => array(
			'className' => 'Deviprospect',
			'foreignKey' => 'deviprospect_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
