<?php
App::uses('AppController', 'Controller');
/**
 * Validites Controller
 *
 * @property Validite $Validite
 */
class ValiditesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Validite->recursive = 0;
		$this->set('validites', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Validite->exists($id)) {
			throw new NotFoundException(__('Invalid validite'));
		}
		$options = array('conditions' => array('Validite.' . $this->Validite->primaryKey => $id));
		$this->set('validite', $this->Validite->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Validite->create();
			if ($this->Validite->save($this->request->data)) {
				$this->Session->setFlash(__('The validite has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The validite could not be saved. Please, try again.'));
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
		if (!$this->Validite->exists($id)) {
			throw new NotFoundException(__('Invalid validite'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Validite->save($this->request->data)) {
				$this->Session->setFlash(__('The validite has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The validite could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Validite.' . $this->Validite->primaryKey => $id));
			$this->request->data = $this->Validite->find('first', $options);
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
		$this->Validite->id = $id;
		if (!$this->Validite->exists()) {
			throw new NotFoundException(__('Invalid validite'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Validite->delete()) {
			$this->Session->setFlash(__('Validite deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Validite was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
