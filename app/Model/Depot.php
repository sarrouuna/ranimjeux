<?php
App::uses('AppModel', 'Model');
/**
 * Depot Model
 *
 * @property Inventaire $Inventaire
 * @property Stockdepot $Stockdepot
 */
class Depot extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
    
    public $virtualFields = array(
   'nom' => 'CONCAT(Depot.code, " ", Depot.designation)');
    
   public $displayField = 'nom'; 
    
    
    
    
	public $hasMany = array(
		'Inventaire' => array(
			'className' => 'Inventaire',
			'foreignKey' => 'depot_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Stockdepot' => array(
			'className' => 'Stockdepot',
			'foreignKey' => 'depot_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Facture' => array(
			'className' => 'Facture',
			'foreignKey' => 'depot_id',
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
