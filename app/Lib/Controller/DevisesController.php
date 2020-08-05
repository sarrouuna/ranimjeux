<?php
App::uses('AppController', 'Controller');
/**
 * Devises Controller
 *
 * @property Devise $Devise
 */
class DevisesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Devise->recursive = 0;
		$this->set('devises', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Devise->exists($id)) {
			throw new NotFoundException(__('Invalid devise'));
		}
		$options = array('conditions' => array('Devise.' . $this->Devise->primaryKey => $id));
		$this->set('devise', $this->Devise->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Devise->create();
			if ($this->Devise->save($this->request->data)) {
				$this->Session->setFlash(__('The devise has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The devise could not be saved. Please, try again.'));
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
		if (!$this->Devise->exists($id)) {
			throw new NotFoundException(__('Invalid devise'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Devise->save($this->request->data)) {
				$this->Session->setFlash(__('The devise has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The devise could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Devise.' . $this->Devise->primaryKey => $id));
			$this->request->data = $this->Devise->find('first', $options);
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
		$this->Devise->id = $id;
		if (!$this->Devise->exists()) {
			throw new NotFoundException(__('Invalid devise'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Devise->delete()) {
			$this->Session->setFlash(__('Devise deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Devise was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
