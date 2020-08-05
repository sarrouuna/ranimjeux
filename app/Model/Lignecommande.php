<?php
App::uses('AppModel', 'Model');
/**
 * Lignecommande Model
 *
 * @property Commande $Commande
 * @property Article $Article
 */
class Lignecommande extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Commande' => array(
			'className' => 'Commande',
			'foreignKey' => 'commande_id',
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
