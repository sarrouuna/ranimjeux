<?php
App::uses('AppModel', 'Model');
/**
 * Imputationfactureavoir Model
 *
 * @property Factureavoir $Factureavoir
 * @property Factureclient $Factureclient
 */
class Imputationfactureavoir extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Factureavoir' => array(
			'className' => 'Factureavoir',
			'foreignKey' => 'factureavoir_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Factureclient' => array(
			'className' => 'Factureclient',
			'foreignKey' => 'factureclient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
