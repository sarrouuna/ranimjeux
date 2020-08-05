<?php
App::uses('AppModel', 'Model');
/**
 * Lignefacture Model
 *
 * @property Facture $Facture
 * @property Article $Article
 */
class Lignefacture extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Facture' => array(
			'className' => 'Facture',
			'foreignKey' => 'facture_id',
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
             'Factureavoirfr' => array(
            'className' => 'Factureavoirfr',
            'foreignKey' => 'factureavoirfr_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Bonreception' => array(
            'className' => 'Bonreception',
            'foreignKey' => 'bonreception_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
	);
}
