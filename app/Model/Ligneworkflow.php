<?php
App::uses('AppModel', 'Model');
/**
 * Ligneworkflow Model
 *
 * @property Workflow $Workflow
 * @property Typeworkflow $Typeworkflow
 * @property Personnel $Personnel
 */
class Ligneworkflow extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Workflow' => array(
			'className' => 'Workflow',
			'foreignKey' => 'workflow_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Typeworkflow' => array(
			'className' => 'Typeworkflow',
			'foreignKey' => 'typeworkflow_id',
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
