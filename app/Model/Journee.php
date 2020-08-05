<?php
App::uses('AppModel', 'Model');
/**
 * Fond Model
 *
 * @property Client $Client
 */
class Journee extends AppModel {
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
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
}
