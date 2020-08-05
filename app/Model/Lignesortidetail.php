<?php
App::uses('AppModel', 'Model');
/**
 * Lignesortidetail Model
 *
 * @property Lignesorti $Lignesorti
 * @property Stockdepot $Stockdepot
 */
class Lignesortidetail extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Lignesorti' => array(
			'className' => 'Lignesorti',
			'foreignKey' => 'lignesorti_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Stockdepot' => array(
			'className' => 'Stockdepot',
			'foreignKey' => 'stockdepot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
