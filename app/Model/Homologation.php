<?php
App::uses('AppModel', 'Model');
/**
 * Homologation Model
 *
 * @property Articlehomologation $Articlehomologation
 * @property Article $Article
 */
class Homologation extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	
    var $actsAs = array(
            'MeioUpload.MeioUpload' => array(
                 'fichier' => array(
                    'dir' => 'files{DS}upload',
                    'create_directory' => true,
                    'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/bmp', 'image/x-icon', 'image/vnd.microsoft.icon','application/pdf', 'application/msword', 'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'application/rtf', 'application/zip'),
      'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif', '.bmp', '.ico', '.pdf', '.doc', '.pdf', '.docx', '.pptx', '.ppt', '.xls', '.xlsx', '.rtf', '.zip'),
                )
            )
        );
  public $belongsTo = array(
		
		'Etat' => array(
			'className' => 'Etat',
			'foreignKey' => 'etat_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
