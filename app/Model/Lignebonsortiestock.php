<?php
App::uses('AppModel', 'Model');
/**
 * Lignebonsortiestock Model
 *
 * @property Depot $Depot
 * @property Article $Article
 * @property Bonsortiestock $Bonsortiestock
 */
class Lignebonsortiestock extends AppModel {


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
		'Bonsortiestock' => array(
			'className' => 'Bonsortiestock',
			'foreignKey' => 'bonsortiestock_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
