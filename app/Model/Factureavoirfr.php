<?php
App::uses('AppModel', 'Model');
/**
 * Factureavoirfr Model
 *
 * @property Fournisseur $Fournisseur
 * @property Utilisateur $Utilisateur
 * @property Timbre $Timbre
 * @property Facture $Facture
 * @property Typefacture $Typefacture
 * @property Pointdevente $Pointdevente
 * @property Exercice $Exercice
 */
class Factureavoirfr extends AppModel {


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
		'Facture' => array(
			'className' => 'Facture',
			'foreignKey' => 'facture_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Typefacture' => array(
			'className' => 'Typefacture',
			'foreignKey' => 'typefacture_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Pointdevente' => array(
			'className' => 'Pointdevente',
			'foreignKey' => 'pointdevente_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Exercice' => array(
			'className' => 'Exercice',
			'foreignKey' => 'exercice_id',
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
		)
            
	);
}
