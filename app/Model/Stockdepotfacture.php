<?php
App::uses('AppModel', 'Model');
/**
 * Stockdepotfacture Model
 *
 * @property Factureclient $Factureclient
 * @property Stockdepot $Stockdepot
 */
class Stockdepotfacture extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		
		'Stockdepot' => array(
			'className' => 'Stockdepot',
			'foreignKey' => 'stockdepot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
