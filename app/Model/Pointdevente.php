<?php
App::uses('AppModel', 'Model');
/**
 * Pointdevente Model
 *
 * @property Personnel $Personnel
 */
class Pointdevente extends AppModel {


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
            'Societe' => array(
			'className' => 'Societe',
			'foreignKey' => 'societe_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
