<?php
App::uses('AppController', 'Controller');
/**
 * Etats Controller
 *
 * @property Etat $Etat
 */
class EtatsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Etat->recursive = 0;
		$this->set('etats', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Etat->exists($id)) {
			throw new NotFoundException(__('Invalid etat'));
		}
		$options = array('conditions' => array('Etat.' . $this->Etat->primaryKey => $id));
		$this->set('etat', $this->Etat->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Etat->create();
			if ($this->Etat->save($this->request->data)) {
				$this->Session->setFlash(__('The etat has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etat could not be saved. Please, try again.'));
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
		if (!$this->Etat->exists($id)) {
			throw new NotFoundException(__('Invalid etat'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Etat->save($this->request->data)) {
				$this->Session->setFlash(__('The etat has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etat could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Etat.' . $this->Etat->primaryKey => $id));
			$this->request->data = $this->Etat->find('first', $options);
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
		$this->Etat->id = $id;
		if (!$this->Etat->exists()) {
			throw new NotFoundException(__('Invalid etat'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Etat->delete()) {
			$this->Session->setFlash(__('Etat deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Etat was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
