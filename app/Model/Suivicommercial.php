<?php
App::uses('AppModel', 'Model');
/**
 * Suivicommercial Model
 *
 * @property Statusuivi $Statusuivi
 * @property Inclusuivi $Inclusuivi
 * @property Devi $Devi
 */
class Suivicommercial extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Statusuivi' => array(
			'className' => 'Statusuivi',
			'foreignKey' => 'statusuivi_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Inclusuivi' => array(
			'className' => 'Inclusuivi',
			'foreignKey' => 'inclusuivi_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Devi' => array(
			'className' => 'Devi',
			'foreignKey' => 'devi_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
