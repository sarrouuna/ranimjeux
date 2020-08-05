<?php
App::uses('AppModel', 'Model');
/**
 * Client Model
 *
 * @property Familleclient $Familleclient
 * @property Sousfamilleclient $Sousfamilleclient
 * @property Zone $Zone
 * @property Bonlivraison $Bonlivraison
 * @property Bonsorti $Bonsorti
 * @property Commandeclient $Commandeclient
 * @property Devi $Devi
 * @property Factureclient $Factureclient
 */
class Client extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 * 
 */
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
                          ),
                      
             'photorib' => array(
                'dir' => 'files{DS}upload',
                'create_directory' => true,
                'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/bmp', 'image/x-icon', 'image/vnd.microsoft.icon','application/pdf', 'application/msword', 'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'application/rtf', 'application/zip'),
                'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif', '.bmp', '.ico', '.pdf', '.doc', '.pdf', '.docx', '.pptx', '.ppt', '.xls', '.xlsx', '.rtf', '.zip'),
                          )
                           )     
                  );
        public $virtualFields = array(
   'nom' => 'CONCAT(Client.code, " ", Client.name)');
    
   public $displayField = 'nom'; 
        
	public $belongsTo = array(
		'Familleclient' => array(
			'className' => 'Familleclient',
			'foreignKey' => 'familleclient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Sousfamilleclient' => array(
			'className' => 'Sousfamilleclient',
			'foreignKey' => 'sousfamilleclient_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Zone' => array(
			'className' => 'Zone',
			'foreignKey' => 'zone_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Personnel' => array(
			'className' => 'Personnel',
			'foreignKey' => 'personnel_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Typeclient' => array(
			'className' => 'Typeclient',
			'foreignKey' => 'typeclient_id',
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
		'Bonlivraison' => array(
			'className' => 'Bonlivraison',
			'foreignKey' => 'client_id',
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
		'Bonsorti' => array(
			'className' => 'Bonsorti',
			'foreignKey' => 'client_id',
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
		'Commandeclient' => array(
			'className' => 'Commandeclient',
			'foreignKey' => 'client_id',
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
		'Devi' => array(
			'className' => 'Devi',
			'foreignKey' => 'client_id',
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
		'Factureclient' => array(
			'className' => 'Factureclient',
			'foreignKey' => 'client_id',
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
		'Reglementclient' => array(
			'className' => 'Reglementclient',
			'foreignKey' => 'client_id',
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
