<?php
App::uses('AppModel', 'Model');
/**
 * Lignebonreceptionstock Model
 *
 * @property Depot $Depot
 * @property Article $Article
 * @property Bonreceptionstock $Bonreceptionstock
 */
class Lignebonreceptionstock extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
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
		),
		'Bonreceptionstock' => array(
			'className' => 'Bonreceptionstock',
			'foreignKey' => 'bonreceptionstock_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
