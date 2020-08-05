<?php
App::uses('AppModel', 'Model');
/**
 * Typefacture Model
 *
 * @property Factureavoir $Factureavoir
 */
class Typefacture extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Factureavoir' => array(
			'className' => 'Factureavoir',
			'foreignKey' => 'typefacture_id',
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
