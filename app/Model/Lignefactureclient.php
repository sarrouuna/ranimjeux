<?php

App::uses('AppModel', 'Model');

/**
 * Lignefactureclient Model
 *
 * @property Factureclient $Factureclient
 * @property Article $Article
 */
class Lignefactureclient extends AppModel {
    /**
     * Validation rules
     *
     * @var array
     */
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Factureclient' => array(
            'className' => 'Factureclient',
            'foreignKey' => 'factureclient_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Lignetransfert' => array(
            'className' => 'Lignetransfert',
            'foreignKey' => 'lignetransfert_id',
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
        ,
        'Depot' => array(
            'className' => 'Depot',
            'foreignKey' => 'depot_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Bonlivraison' => array(
            'className' => 'Bonlivraison',
            'foreignKey' => 'bonlivraison_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
