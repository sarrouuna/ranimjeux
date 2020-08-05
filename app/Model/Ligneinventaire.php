<?php
App::uses('AppModel', 'Model');
/**
 * Ligneinventaire Model
 *
 * @property Inventaire $Inventaire
 * @property Article $Article
 */
class Ligneinventaire extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Inventaire' => array(
			'className' => 'Inventaire',
			'foreignKey' => 'inventaire_id',
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
