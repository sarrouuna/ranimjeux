<?php
App::uses('AppModel', 'Model');
/**
 * Ligneproduction Model
 *
 * @property Depot $Depot
 * @property Article $Article
 * @property Production $Production
 */
class Ligneproduction extends AppModel {


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
		'Production' => array(
			'className' => 'Production',
			'foreignKey' => 'production_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
