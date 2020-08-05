<?php
App::uses('AppModel', 'Model');
/**
 * Lignecopiestock Model
 *
 * @property Copiestockdepot $Copiestockdepot
 * @property Article $Article
 * @property Depot $Depot
 */
class Lignecopiestock extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Copiestockdepot' => array(
			'className' => 'Copiestockdepot',
			'foreignKey' => 'copiestockdepot_id',
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
