<?php
App::uses('AppModel', 'Model');
/**
 * Famillearticle Model
 *
 * @property Article $Article
 */
class Famillearticle extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'Designation';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'famillearticle_id',
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
