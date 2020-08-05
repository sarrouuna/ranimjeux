<?php
App::uses('AppModel', 'Model');
/**
 * Lignefichetechnique Model
 *
 * @property Article $Article
 * @property Fichetechnique $Fichetechnique
 */
class Lignefichetechnique extends AppModel {


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
		'Fichetechnique' => array(
			'className' => 'Fichetechnique',
			'foreignKey' => 'fichetechnique_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
