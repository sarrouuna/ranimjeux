<?php
App::uses('AppModel', 'Model');
/**
 * Lignefactureavoirfr Model
 *
 * @property Factureavoirfr $Factureavoirfr
 * @property Depot $Depot
 * @property Article $Article
 */
class Lignefactureavoirfr extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Factureavoirfr' => array(
			'className' => 'Factureavoirfr',
			'foreignKey' => 'factureavoirfr_id',
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
