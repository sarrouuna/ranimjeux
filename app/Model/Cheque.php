<?php
App::uses('AppModel', 'Model');
/**
 * Cheque Model
 *
 * @property Carnetcheque $Carnetcheque
 */
class Cheque extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Carnetcheque' => array(
			'className' => 'Carnetcheque',
			'foreignKey' => 'carnetcheque_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
