<?php
App::uses('AppModel', 'Model');
/**
 * Article Model
 *
 * @property Famille $Famille
 * @property Sousfamille $Sousfamille
 * @property Soussousfamille $Soussousfamille
 * @property Unite $Unite
 * @property Articlefournisseur $Articlefournisseur
 * @property Articletag $Articletag
 */
class Article extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */    
    

    
    
    public $virtualFields = array(
        'nom' => 'CONCAT(Article.code, " ", Article.name)'
        ,'desig_list' => 'CONCAT(Article.code," |-*-| ",Article.name, " |-*-| ", Article.prixvente )'
    );
    public $displayField = 'nom'; 
    
    
    
    var $actsAs = array(
        'MeioUpload.MeioUpload' => array(
             'homologation' => array(
                'dir' => 'files{DS}upload',
                'create_directory' => true,
                'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/bmp', 'image/x-icon', 'image/vnd.microsoft.icon','application/pdf', 'application/msword', 'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'application/rtf', 'application/zip'),
                'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif', '.bmp', '.ico', '.pdf', '.doc', '.pdf', '.docx', '.pptx', '.ppt', '.xls', '.xlsx', '.rtf', '.zip'),
                          )
                      )
                  );
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
		),
		'Soussousfamille' => array(
			'className' => 'Soussousfamille',
			'foreignKey' => 'soussousfamille_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Unite' => array(
			'className' => 'Unite',
			'foreignKey' => 'unite_id',
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
		'Articlefournisseur' => array(
			'className' => 'Articlefournisseur',
			'foreignKey' => 'article_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Articletag' => array(
			'className' => 'Articletag',
			'foreignKey' => 'article_id',
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
