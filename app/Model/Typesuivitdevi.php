<?php
App::uses('AppModel', 'Model');
/**
 * Typesuivitdevi Model
 *
 */
class Typesuivitdevi extends AppModel {
public $hasMany = array(
		'Devi' => array(
			'className' => 'Devi',
			'foreignKey' => 'typesuivitdevi_id',
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
