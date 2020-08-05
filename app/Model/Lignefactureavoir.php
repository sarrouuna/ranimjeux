<?php
App::uses('AppModel', 'Model');
/**
 * Lignefactureavoir Model
 *
 * @property Factureavoir $Factureavoir
 * @property Depot $Depot
 * @property Article $Article
 */
class Lignefactureavoir extends AppModel {


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
		)
	);
}
