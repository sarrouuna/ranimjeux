<?php
App::uses('AppController', 'Controller');
/**
 * Tvas Controller
 *
 * @property Tva $Tva
 */
class TvasController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Tva->recursive = 0;
		$this->set('tvas', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Tva->exists($id)) {
			throw new NotFoundException(__('Invalid tva'));
		}
		$options = array('conditions' => array('Tva.' . $this->Tva->primaryKey => $id));
		$this->set('tva', $this->Tva->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tva->create();
			if ($this->Tva->save($this->request->data)) {
				$this->Session->setFlash(__('The tva has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tva could not be saved. Please, try again.'));
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
		if (!$this->Tva->exists($id)) {
			throw new NotFoundException(__('Invalid tva'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Tva->save($this->request->data)) {
				$this->Session->setFlash(__('The tva has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tva could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tva.' . $this->Tva->primaryKey => $id));
			$this->request->data = $this->Tva->find('first', $options);
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
		$this->Tva->id = $id;
		if (!$this->Tva->exists()) {
			throw new NotFoundException(__('Invalid tva'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Tva->delete()) {
			$this->Session->setFlash(__('Tva deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Tva was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
