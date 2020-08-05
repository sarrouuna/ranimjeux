<?php
App::uses('AppModel', 'Model');
/**
 * Ticketcaisseligne Model
 *
 * @property Ticketcaisse $Ticketcaisse
 * @property Article $Article
 */
class Ticketcaisseligne extends AppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Ticketcaiss' => array(
			'className' => 'Ticketcaiss',
			'foreignKey' => 'ticketcaisse_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'article_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	 public $hasMany = array(
	 
		'Ticketcaisselignepromo' => array(
			'className' => 'Ticketcaisselignepromo',
			'foreignKey' => 'ticketcaisseligne_id',
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
