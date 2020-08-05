<?php
App::uses('AppController', 'Controller');
/**
 * Cheques Controller
 *
 * @property Cheque $Cheque
 */
class ChequesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Cheque->recursive = 0;
		$this->set('cheques', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Cheque->exists($id)) {
			throw new NotFoundException(__('Invalid cheque'));
		}
		$options = array('conditions' => array('Cheque.' . $this->Cheque->primaryKey => $id));
		$this->set('cheque', $this->Cheque->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Cheque->create();
			if ($this->Cheque->save($this->request->data)) {
				$this->Session->setFlash(__('The cheque has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cheque could not be saved. Please, try again.'));
			}
		}
		$carnetcheques = $this->Cheque->Carnetcheque->find('list');
		$this->set(compact('carnetcheques'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Cheque->exists($id)) {
			throw new NotFoundException(__('Invalid cheque'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Cheque->save($this->request->data)) {
				$this->Session->setFlash(__('The cheque has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cheque could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Cheque.' . $this->Cheque->primaryKey => $id));
			$this->request->data = $this->Cheque->find('first', $options);
		}
		$carnetcheques = $this->Cheque->Carnetcheque->find('list');
		$this->set(compact('carnetcheques'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Cheque->id = $id;
		if (!$this->Cheque->exists()) {
			throw new NotFoundException(__('Invalid cheque'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Cheque->delete()) {
			$this->Session->setFlash(__('Cheque deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Cheque was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
