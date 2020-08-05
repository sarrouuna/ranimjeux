<?php
App::uses('AppModel', 'Model');
/**
 * Lignelivraison Model
 *
 * @property Bonlivraison $Bonlivraison
 * @property Article $Article
 */
class Lignelivraison extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Bonlivraison' => array(
			'className' => 'Bonlivraison',
			'foreignKey' => 'bonlivraison_id',
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
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
