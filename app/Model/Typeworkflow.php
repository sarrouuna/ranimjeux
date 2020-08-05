<?php
App::uses('AppModel', 'Model');
/**
 * Typeworkflow Model
 *
 * @property Ligneworkflow $Ligneworkflow
 */
class Typeworkflow extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Ligneworkflow' => array(
			'className' => 'Ligneworkflow',
			'foreignKey' => 'typeworkflow_id',
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
