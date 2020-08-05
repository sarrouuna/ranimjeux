<?php
App::uses('AppModel', 'Model');
/**
 * Lignecommandeclient Model
 *
 * @property Commandeclient $Commandeclient
 * @property Article $Article
 */
class Lignecommandeclient extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Commandeclient' => array(
			'className' => 'Commandeclient',
			'foreignKey' => 'commandeclient_id',
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
