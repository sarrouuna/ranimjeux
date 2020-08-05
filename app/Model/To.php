<?php
App::uses('AppModel', 'Model');
/**
 * To Model
 *
 * @property Piecereglement $Piecereglement
 */
class To extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Piecereglement' => array(
			'className' => 'Piecereglement',
			'foreignKey' => 'to_id',
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
