<?php
App::uses('AppModel', 'Model');
/**
 * Alimentation Model
 *
 * @property Carnetcheque $Carnetcheque
 * @property Cheque $Cheque
 */
class Alimentation extends AppModel {


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
		),
		'Cheque' => array(
			'className' => 'Cheque',
			'foreignKey' => 'cheque_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
