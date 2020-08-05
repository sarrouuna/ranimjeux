<?php
App::uses('AppModel', 'Model');
/**
 * Compte Model
 *
 */
class Compte extends AppModel {
 public $virtualFields = array(
   'nom' => 'CONCAT(Compte.banque, " ", Compte.rib)');
    
   public $displayField = 'nom'; 
}
