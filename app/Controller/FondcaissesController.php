<?php
App::uses('AppController', 'Controller');
/**
 * Fondcaisses Controller
 *
 * @property Fondcaiss $Fondcaiss
 */
class FondcaissesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Fondcaiss->recursive = 0;
		$this->set('fondcaisses', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Fondcaiss->exists($id)) {
			throw new NotFoundException(__('Invalid fondcaiss'));
		}
		$options = array('conditions' => array('Fondcaiss.' . $this->Fondcaiss->primaryKey => $id));
		$this->set('fondcaiss', $this->Fondcaiss->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Fondcaiss->create();
			if ($this->Fondcaiss->save($this->request->data)) {
				$this->Session->setFlash(__('The fondcaiss has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fondcaiss could not be saved. Please, try again.'));
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
		if (!$this->Fondcaiss->exists($id)) {
			throw new NotFoundException(__('Invalid fondcaiss'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Fondcaiss->save($this->request->data)) {
				$this->Session->setFlash(__('The fondcaiss has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fondcaiss could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Fondcaiss.' . $this->Fondcaiss->primaryKey => $id));
			$this->request->data = $this->Fondcaiss->find('first', $options);
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
		$this->Fondcaiss->id = $id;
		if (!$this->Fondcaiss->exists()) {
			throw new NotFoundException(__('Invalid fondcaiss'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Fondcaiss->delete()) {
			$this->Session->setFlash(__('Fondcaiss deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Fondcaiss was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
