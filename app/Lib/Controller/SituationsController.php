<?php
App::uses('AppController', 'Controller');
/**
 * Situations Controller
 *
 * @property Situation $Situation
 */
class SituationsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Situation->recursive = 0;
		$this->set('situations', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Situation->exists($id)) {
			throw new NotFoundException(__('Invalid situation'));
		}
		$options = array('conditions' => array('Situation.' . $this->Situation->primaryKey => $id));
		$this->set('situation', $this->Situation->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Situation->create();
			if ($this->Situation->save($this->request->data)) {
				$this->Session->setFlash(__('The situation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The situation could not be saved. Please, try again.'));
			}
		}
		$namesituations = $this->Situation->Namesituation->find('list');
		$importations = $this->Situation->Importation->find('list');
		$this->set(compact('namesituations', 'importations'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Situation->exists($id)) {
			throw new NotFoundException(__('Invalid situation'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Situation->save($this->request->data)) {
				$this->Session->setFlash(__('The situation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The situation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Situation.' . $this->Situation->primaryKey => $id));
			$this->request->data = $this->Situation->find('first', $options);
		}
		$namesituations = $this->Situation->Namesituation->find('list');
		$importations = $this->Situation->Importation->find('list');
		$this->set(compact('namesituations', 'importations'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Situation->id = $id;
		if (!$this->Situation->exists()) {
			throw new NotFoundException(__('Invalid situation'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Situation->delete()) {
			$this->Session->setFlash(__('Situation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Situation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
