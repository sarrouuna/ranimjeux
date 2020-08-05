<?php
App::uses('AppModel', 'Model');
/**
 * Ligneentre Model
 *
 * @property Bonentre $Bonentre
 * @property Article $Article
 * @property Depot $Depot
 * @property Stockdepot $Stockdepot
 * @property Lignereception $Lignereception
 * @property Lignefacture $Lignefacture
 */
class Ligneentre extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Bonentre' => array(
			'className' => 'Bonentre',
			'foreignKey' => 'bonentre_id',
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
		),
		'Stockdepot' => array(
			'className' => 'Stockdepot',
			'foreignKey' => 'stockdepot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Lignereception' => array(
			'className' => 'Lignereception',
			'foreignKey' => 'lignereception_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Lignefacture' => array(
			'className' => 'Lignefacture',
			'foreignKey' => 'lignefacture_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
