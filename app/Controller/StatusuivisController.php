<?php
App::uses('AppController', 'Controller');
/**
 * Statusuivis Controller
 *
 * @property Statusuivi $Statusuivi
 */
class StatusuivisController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Statusuivi->recursive = 0;
		$this->set('statusuivis', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Statusuivi->exists($id)) {
			throw new NotFoundException(__('Invalid statusuivi'));
		}
		$options = array('conditions' => array('Statusuivi.' . $this->Statusuivi->primaryKey => $id));
		$this->set('statusuivi', $this->Statusuivi->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Statusuivi->create();
			if ($this->Statusuivi->save($this->request->data)) {
				$this->Session->setFlash(__('The statusuivi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The statusuivi could not be saved. Please, try again.'));
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
		if (!$this->Statusuivi->exists($id)) {
			throw new NotFoundException(__('Invalid statusuivi'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Statusuivi->save($this->request->data)) {
				$this->Session->setFlash(__('The statusuivi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The statusuivi could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Statusuivi.' . $this->Statusuivi->primaryKey => $id));
			$this->request->data = $this->Statusuivi->find('first', $options);
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
		$this->Statusuivi->id = $id;
		if (!$this->Statusuivi->exists()) {
			throw new NotFoundException(__('Invalid statusuivi'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Statusuivi->delete()) {
			$this->Session->setFlash(__('Statusuivi deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Statusuivi was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
