<?php
App::uses('AppModel', 'Model');
/**
 * Facture Model
 *
 * @property Fournisseur $Fournisseur
 * @property Depot $Depot
 * @property Utilisateur $Utilisateur
 * @property Lignefacture $Lignefacture
 */
class Facture extends AppModel {


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
		'Utilisateur' => array(
			'className' => 'Utilisateur',
			'foreignKey' => 'utilisateur_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'Timbre' => array(
			'className' => 'Timbre',
			'foreignKey' => 'timbre_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Lignefacture' => array(
			'className' => 'Lignefacture',
			'foreignKey' => 'facture_id',
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
