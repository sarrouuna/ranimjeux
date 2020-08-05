<?php
App::uses('AppModel', 'Model');
/**
 * Remiseartfamille Model
 *
 * @property Article $Article
 * @property Famille $Famille
 */
class Remiseartfamille extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'article_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Familleclient' => array(
			'className' => 'Familleclient',
			'foreignKey' => 'familleclient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
