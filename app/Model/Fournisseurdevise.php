<?php
App::uses('AppModel', 'Model');
/**
 * Fournisseurdevise Model
 *
 * @property Fournisseur $Fournisseur
 * @property Devise $Devise
 */
class Fournisseurdevise extends AppModel {


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
		),
		'Devise' => array(
			'className' => 'Devise',
			'foreignKey' => 'devise_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
