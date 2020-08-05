<?php

App::uses('AppModel', 'Model');

/**
 * Articlecomposante Model
 *
 * @property Article $Article
 */
class Articlecomposante extends AppModel {
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
        'Article' => array(
            'className' => 'Article',
            'foreignKey' => 'composant',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
