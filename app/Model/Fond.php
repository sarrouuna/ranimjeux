<?php
App::uses('AppModel', 'Model');
/**
 * Fond Model
 *
 * @property Client $Client
 */
class Fond extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	//public $displayField = 'Designation';

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Personnel' => array(
			'className' => 'Personnel',
			'foreignKey' => 'personnel_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Journee' => array(
			'className' => 'Journee',
			'foreignKey' => 'journee_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
}
