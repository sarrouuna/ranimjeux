<?php
App::uses('AppController', 'Controller');
/**
 * Typedipliquations Controller
 *
 * @property Typedipliquation $Typedipliquation
 */
class TypedipliquationsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Typedipliquation->recursive = 0;
		$this->set('typedipliquations', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Typedipliquation->exists($id)) {
			throw new NotFoundException(__('Invalid typedipliquation'));
		}
		$options = array('conditions' => array('Typedipliquation.' . $this->Typedipliquation->primaryKey => $id));
		$this->set('typedipliquation', $this->Typedipliquation->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Typedipliquation->create();
			if ($this->Typedipliquation->save($this->request->data)) {
				$this->Session->setFlash(__('The typedipliquation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typedipliquation could not be saved. Please, try again.'));
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
		if (!$this->Typedipliquation->exists($id)) {
			throw new NotFoundException(__('Invalid typedipliquation'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Typedipliquation->save($this->request->data)) {
				$this->Session->setFlash(__('The typedipliquation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typedipliquation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Typedipliquation.' . $this->Typedipliquation->primaryKey => $id));
			$this->request->data = $this->Typedipliquation->find('first', $options);
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
		$this->Typedipliquation->id = $id;
		if (!$this->Typedipliquation->exists()) {
			throw new NotFoundException(__('Invalid typedipliquation'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Typedipliquation->delete()) {
			$this->Session->setFlash(__('Typedipliquation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Typedipliquation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
