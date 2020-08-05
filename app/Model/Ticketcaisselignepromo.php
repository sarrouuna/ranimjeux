<?php
App::uses('AppModel', 'Model');
/**
 * Ticketcaisseligne Model
 *
 * @property Ticketcaisse $Ticketcaisse
 * @property Article $Article
 */
class Ticketcaisselignepromo extends AppModel {

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
		),'Ticketcaisseligne' => array(
			'className' => 'Ticketcaisseligne',
			'foreignKey' => 'ticketcaisseligne_id',
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
}
