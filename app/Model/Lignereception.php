<?php
App::uses('AppModel', 'Model');
/**
 * Lignereception Model
 *
 * @property Bonreception $Bonreception
 * @property Article $Article
 */
class Lignereception extends AppModel {

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Bonreception' => array(
			'className' => 'Bonreception',
			'foreignKey' => 'bonreception_id',
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
