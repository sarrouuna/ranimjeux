<?php
App::uses('AppModel', 'Model');
/**
 * Societe Model
 *
 */
class Societe extends AppModel {
    public $virtualFields = array(
   'name' => 'CONCAT(Societe.nom)');
    
   public $displayField = 'name'; 
    
 var $actsAs = array(
        'MeioUpload.MeioUpload' => array(
            'logo' => array(
                'dir' => 'img',
                'create_directory' => true,
                'allowed_mime' => array('image/jpeg', 'image/pjpeg', 'image/png', 'image/gif', 'image/bmp', 'image/x-icon', 'image/vnd.microsoft.icon','application/pdf', 'application/msword', 'application/vnd.ms-powerpoint', 'application/vnd.ms-excel', 'application/rtf', 'application/zip'),
  'allowed_ext' => array('.jpg', '.jpeg', '.png', '.gif', '.bmp', '.ico', '.pdf', '.doc', '.pdf', '.docx', '.pptx', '.ppt', '.xls', '.xlsx', '.rtf', '.zip'),
            )
        )
    );
}
