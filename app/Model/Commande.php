<?php
App::uses('AppModel', 'Model');
/**
 * Commande Model
 *
 * @property Fournisseur $Fournisseur
 * @property Lignecommande $Lignecommande
 */
class Commande extends AppModel {


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
                'Importation' => array(
			'className' => 'Importation',
			'foreignKey' => 'importation_id',
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

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Lignecommande' => array(
			'className' => 'Lignecommande',
			'foreignKey' => 'commande_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
