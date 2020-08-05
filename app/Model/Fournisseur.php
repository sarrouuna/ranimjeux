<?php
App::uses('AppModel', 'Model');
/**
 * Fournisseur Model
 *
 * @property Famillefournisseur $Famillefournisseur
 * @property Articlefournisseur $Articlefournisseur
 */
class Fournisseur extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
    
    public $virtualFields = array(
        'nom' => 'CONCAT(Fournisseur.code, " ", Fournisseur.name)'
        
    );
    public $displayField = 'nom'; 
    
    
        var $actsAs = array(
        'MeioUpload.MeioUpload' => array(
             'registrecommercef' => array(
                'dir' => 'files{DS}upload',
                'create_directory' => true,
                'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/bmp', 'image/x-icon', 'image/vnd.microsoft.icon','application/pdf', 'application/msword', 'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'application/rtf', 'application/zip'),
                'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif', '.bmp', '.ico', '.pdf', '.doc', '.pdf', '.docx', '.pptx', '.ppt', '.xls', '.xlsx', '.rtf', '.zip'),
                          ),
            'patente' => array(
                'dir' => 'files{DS}upload',
                'create_directory' => true,
                'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/bmp', 'image/x-icon', 'image/vnd.microsoft.icon','application/pdf', 'application/msword', 'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'application/rtf', 'application/zip'),
                'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif', '.bmp', '.ico', '.pdf', '.doc', '.pdf', '.docx', '.pptx', '.ppt', '.xls', '.xlsx', '.rtf', '.zip'),
                          )
                      )
                  );
	public $belongsTo = array(
		'Famillefournisseur' => array(
			'className' => 'Famillefournisseur',
			'foreignKey' => 'famillefournisseur_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'Devise' => array(
			'className' => 'Devise',
			'foreignKey' => 'devise_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'Pay' => array(
			'className' => 'Pay',
			'foreignKey' => 'pay_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),'Zone' => array(
			'className' => 'Zone',
			'foreignKey' => 'zone_id',
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
			'foreignKey' => 'fournisseur_id',
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
            'Factureavoirfr' => array(
			'className' => 'Factureavoirfr',
			'foreignKey' => 'fournisseur_id',
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
