<?php
App::uses('AppController', 'Controller');
/**
 * Inclusuivis Controller
 *
 * @property Inclusuivi $Inclusuivi
 */
class InclusuivisController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Inclusuivi->recursive = 0;
		$this->set('inclusuivis', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Inclusuivi->exists($id)) {
			throw new NotFoundException(__('Invalid inclusuivi'));
		}
		$options = array('conditions' => array('Inclusuivi.' . $this->Inclusuivi->primaryKey => $id));
		$this->set('inclusuivi', $this->Inclusuivi->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Inclusuivi->create();
			if ($this->Inclusuivi->save($this->request->data)) {
				$this->Session->setFlash(__('The inclusuivi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inclusuivi could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Inclusuivi->exists($id)) {
			throw new NotFoundException(__('Invalid inclusuivi'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Inclusuivi->save($this->request->data)) {
				$this->Session->setFlash(__('The inclusuivi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inclusuivi could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Inclusuivi.' . $this->Inclusuivi->primaryKey => $id));
			$this->request->data = $this->Inclusuivi->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Inclusuivi->id = $id;
		if (!$this->Inclusuivi->exists()) {
			throw new NotFoundException(__('Invalid inclusuivi'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Inclusuivi->delete()) {
			$this->Session->setFlash(__('Inclusuivi deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Inclusuivi was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
