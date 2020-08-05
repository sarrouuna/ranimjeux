<?php
App::uses('AppModel', 'Model');
/**
 * Sousfamilleclient Model
 *
 * @property Familleclient $Familleclient
 */
class Sousfamilleclient extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Familleclient' => array(
			'className' => 'Familleclient',
			'foreignKey' => 'familleclient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
