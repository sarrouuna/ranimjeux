<?php
App::uses('AppModel', 'Model');
/**
 * Commission Model
 *
 * @property Personnel $Personnel
 * @property Article $Article
 * @property Famille $Famille
 * @property Sousfamille $Sousfamille
 * @property Soussousfamille $Soussousfamille
 */
class Commission extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Personnel' => array(
			'className' => 'Personnel',
			'foreignKey' => 'personnel_id',
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
		'Famille' => array(
			'className' => 'Famille',
			'foreignKey' => 'famille_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sousfamille' => array(
			'className' => 'Sousfamille',
			'foreignKey' => 'sousfamille_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Soussousfamille' => array(
			'className' => 'Soussousfamille',
			'foreignKey' => 'soussousfamille_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
