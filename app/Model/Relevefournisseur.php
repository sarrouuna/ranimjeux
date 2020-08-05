<?php
App::uses('AppModel', 'Model');
/**
 * Relevefournisseur Model
 *
 * @property Fournisseur $Fournisseur
 */
class Relevefournisseur extends AppModel {


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
		)
	);
}
