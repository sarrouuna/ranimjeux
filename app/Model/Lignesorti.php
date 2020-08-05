<?php
App::uses('AppModel', 'Model');
/**
 * Lignesorti Model
 *
 * @property Bonsorti $Bonsorti
 * @property Article $Article
 * @property Depot $Depot
 * @property Lignelivraison $Lignelivraison
 * @property Lignefacture $Lignefacture
 * @property Lignesortidetail $Lignesortidetail
 */
class Lignesorti extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'lignelivraison_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lignefactureclient_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Bonsorti' => array(
			'className' => 'Bonsorti',
			'foreignKey' => 'bonsorti_id',
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
		'Lignelivraison' => array(
			'className' => 'Lignelivraison',
			'foreignKey' => 'lignelivraison_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Lignefactureclient' => array(
			'className' => 'Lignefactureclient',
			'foreignKey' => 'lignefactureclient_id',
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
		'Lignesortidetail' => array(
			'className' => 'Lignesortidetail',
			'foreignKey' => 'lignesorti_id',
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
