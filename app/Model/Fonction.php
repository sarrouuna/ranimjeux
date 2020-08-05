<?php
App::uses('AppModel', 'Model');
/**
 * Fonction Model
 *
 * @property Personnel $Personnel
 */
class Fonction extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Personnel' => array(
			'className' => 'Personnel',
			'foreignKey' => 'fonction_id',
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
