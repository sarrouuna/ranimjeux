<?php
App::uses('AppController', 'Controller');
/**
 * Situationpersonnels Controller
 *
 * @property Situationpersonnel $Situationpersonnel
 */
class SituationpersonnelsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Situationpersonnel->recursive = 0;
		$this->set('situationpersonnels', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Situationpersonnel->exists($id)) {
			throw new NotFoundException(__('Invalid situationpersonnel'));
		}
		$options = array('conditions' => array('Situationpersonnel.' . $this->Situationpersonnel->primaryKey => $id));
		$this->set('situationpersonnel', $this->Situationpersonnel->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Situationpersonnel->create();
			if ($this->Situationpersonnel->save($this->request->data)) {
				$this->Session->setFlash(__('The situationpersonnel has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The situationpersonnel could not be saved. Please, try again.'));
			}
		}
		$namesituations = $this->Situationpersonnel->Namesituation->find('list');
		$personnels = $this->Situationpersonnel->Personnel->find('list');
		$this->set(compact('namesituations', 'personnels'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Situationpersonnel->exists($id)) {
			throw new NotFoundException(__('Invalid situationpersonnel'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Situationpersonnel->save($this->request->data)) {
				$this->Session->setFlash(__('The situationpersonnel has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The situationpersonnel could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Situationpersonnel.' . $this->Situationpersonnel->primaryKey => $id));
			$this->request->data = $this->Situationpersonnel->find('first', $options);
		}
		$namesituations = $this->Situationpersonnel->Namesituation->find('list');
		$personnels = $this->Situationpersonnel->Personnel->find('list');
		$this->set(compact('namesituations', 'personnels'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Situationpersonnel->id = $id;
		if (!$this->Situationpersonnel->exists()) {
			throw new NotFoundException(__('Invalid situationpersonnel'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Situationpersonnel->delete()) {
			$this->Session->setFlash(__('Situationpersonnel deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Situationpersonnel was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
