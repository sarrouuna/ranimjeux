<?php
App::uses('AppModel', 'Model');
/**
 * Lignevalide Model
 *
 * @property Ligneworkflow $Ligneworkflow
 * @property Document $Document
 * @property Personnel $Personnel
 */
class Lignevalide extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Ligneworkflow' => array(
			'className' => 'Ligneworkflow',
			'foreignKey' => 'ligneworkflow_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'document_id',
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
		)
	);
}
