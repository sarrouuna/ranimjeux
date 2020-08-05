<?php
App::uses('AppModel', 'Model');
/**
 * Bonentre Model
 *
 * @property Fournisseur $Fournisseur
 * @property Utilisateur $Utilisateur
 * @property Bonreception $Bonreception
 * @property Facture $Facture
 * @property Ligneentre $Ligneentre
 */
class Bonentre extends AppModel {


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
		'Bonreception' => array(
			'className' => 'Bonreception',
			'foreignKey' => 'bonreception_id',
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
		'Factureavoir' => array(
			'className' => 'Factureavoir',
			'foreignKey' => 'factureavoir_id',
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
		'Ligneentre' => array(
			'className' => 'Ligneentre',
			'foreignKey' => 'bonentre_id',
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
