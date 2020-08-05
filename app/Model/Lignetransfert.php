<?php
App::uses('AppModel', 'Model');
/**
 * Lignetransfert Model
 *
 * @property Article $Article
 * @property Transfert $Transfert
 */
class Lignetransfert extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'article_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Transfert' => array(
			'className' => 'Transfert',
			'foreignKey' => 'transfert_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
