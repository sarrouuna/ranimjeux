<?php
App::uses('AppModel', 'Model');
/**
 * Soussousfamille Model
 *
 * @property Famille $Famille
 * @property Sousfamille $Sousfamille
 * @property Article $Article
 */
class Soussousfamille extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'soussousfamille_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
