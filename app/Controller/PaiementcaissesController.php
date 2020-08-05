<?php
App::uses('AppController', 'Controller');
/**
 * Paiementcaisses Controller
 *
 * @property Paiementcaiss $Paiementcaiss
 */
class PaiementcaissesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Paiementcaiss->recursive = 0;
		$this->set('paiementcaisses', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Paiementcaiss->exists($id)) {
			throw new NotFoundException(__('Invalid paiementcaiss'));
		}
		$options = array('conditions' => array('Paiementcaiss.' . $this->Paiementcaiss->primaryKey => $id));
		$this->set('paiementcaiss', $this->Paiementcaiss->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Paiementcaiss->create();
			if ($this->Paiementcaiss->save($this->request->data)) {
				$this->Session->setFlash(__('The paiementcaiss has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The paiementcaiss could not be saved. Please, try again.'));
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
		if (!$this->Paiementcaiss->exists($id)) {
			throw new NotFoundException(__('Invalid paiementcaiss'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Paiementcaiss->save($this->request->data)) {
				$this->Session->setFlash(__('The paiementcaiss has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The paiementcaiss could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Paiementcaiss.' . $this->Paiementcaiss->primaryKey => $id));
			$this->request->data = $this->Paiementcaiss->find('first', $options);
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
		$this->Paiementcaiss->id = $id;
		if (!$this->Paiementcaiss->exists()) {
			throw new NotFoundException(__('Invalid paiementcaiss'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Paiementcaiss->delete()) {
			$this->Session->setFlash(__('Paiementcaiss deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Paiementcaiss was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
