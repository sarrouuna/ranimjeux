<?php
App::uses('AppModel', 'Model');
/**
 * Zone Model
 *
 */
class Zone extends AppModel {
    
    public $hasMany = array(
		'Fournisseur' => array(
			'className' => 'Fournisseur',
			'foreignKey' => 'pay_id',
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
public $belongsTo = array(
		'Pay' => array(
			'className' => 'Pay',
			'foreignKey' => 'pay_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
