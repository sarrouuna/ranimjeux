<?php
App::uses('AppModel', 'Model');
/**
 * Affaire Model
 *
 * @property Devi $Devi
 */
class Affaire extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
    public $virtualFields = array(
   'nom' => 'CONCAT(Affaire.numero, " ", Affaire.name)');
    
   public $displayField = 'nom'; 
    
    public $belongsTo = array(
		'Utilisateur' => array(
			'className' => 'Utilisateur',
			'foreignKey' => 'utilisateur_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'Region' => array(
			'className' => 'Region',
			'foreignKey' => 'region_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
 
	public $hasMany = array(
		'Devi' => array(
			'className' => 'Devi',
			'foreignKey' => 'affaire_id',
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
