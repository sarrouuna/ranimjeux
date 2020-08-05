<?php
App::uses('AppModel', 'Model');
/**
 * Piecejointe Model
 *
 * @property Namepiecejointe $Namepiecejointe
 * @property Importation $Importation
 */
class Piecejointe extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
    var $actsAs = array(
        'MeioUpload.MeioUpload' => array(
            'piece' => array(
                'dir' => 'files{DS}upload',
                'create_directory' => true,
                'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/bmp', 'image/x-icon', 'image/vnd.microsoft.icon','application/pdf', 'application/msword', 'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'application/rtf', 'application/zip'),
                'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif', '.bmp', '.ico', '.pdf', '.doc', '.pdf', '.docx', '.pptx', '.ppt', '.xls', '.xlsx', '.rtf', '.zip'),
                          )
                      )
                  );
    
    
    
    
	public $belongsTo = array(
		'Namepiecejointe' => array(
			'className' => 'Namepiecejointe',
			'foreignKey' => 'namepiecejointe_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Importation' => array(
			'className' => 'Importation',
			'foreignKey' => 'importation_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
