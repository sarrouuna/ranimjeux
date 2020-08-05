<?php
App::uses('AppController', 'Controller');
/**
 * Typeligneventes Controller
 *
 * @property Typelignevente $Typelignevente
 */
class TypeligneventesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Typelignevente->recursive = 0;
		$this->set('typeligneventes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Typelignevente->exists($id)) {
			throw new NotFoundException(__('Invalid typelignevente'));
		}
		$options = array('conditions' => array('Typelignevente.' . $this->Typelignevente->primaryKey => $id));
		$this->set('typelignevente', $this->Typelignevente->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Typelignevente->create();
			if ($this->Typelignevente->save($this->request->data)) {
				$this->Session->setFlash(__('The typelignevente has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typelignevente could not be saved. Please, try again.'));
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
		if (!$this->Typelignevente->exists($id)) {
			throw new NotFoundException(__('Invalid typelignevente'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Typelignevente->save($this->request->data)) {
				$this->Session->setFlash(__('The typelignevente has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typelignevente could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Typelignevente.' . $this->Typelignevente->primaryKey => $id));
			$this->request->data = $this->Typelignevente->find('first', $options);
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
		$this->Typelignevente->id = $id;
		if (!$this->Typelignevente->exists()) {
			throw new NotFoundException(__('Invalid typelignevente'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Typelignevente->delete()) {
			$this->Session->setFlash(__('Typelignevente deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Typelignevente was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
