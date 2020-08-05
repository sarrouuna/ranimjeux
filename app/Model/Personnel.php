<?php
App::uses('AppModel', 'Model');
/**
 * Personnel Model
 *
 * @property Fonction $Fonction
 */
class Personnel extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Fonction' => array(
			'className' => 'Fonction',
			'foreignKey' => 'fonction_id',
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
