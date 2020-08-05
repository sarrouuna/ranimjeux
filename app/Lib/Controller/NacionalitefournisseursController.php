<?php
App::uses('AppController', 'Controller');
/**
 * Nacionalitefournisseurs Controller
 *
 * @property Nacionalitefournisseur $Nacionalitefournisseur
 */
class NacionalitefournisseursController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Nacionalitefournisseur->recursive = 0;
		$this->set('nacionalitefournisseurs', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Nacionalitefournisseur->exists($id)) {
			throw new NotFoundException(__('Invalid nacionalitefournisseur'));
		}
		$options = array('conditions' => array('Nacionalitefournisseur.' . $this->Nacionalitefournisseur->primaryKey => $id));
		$this->set('nacionalitefournisseur', $this->Nacionalitefournisseur->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Nacionalitefournisseur->create();
			if ($this->Nacionalitefournisseur->save($this->request->data)) {
				$this->Session->setFlash(__('The nacionalitefournisseur has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The nacionalitefournisseur could not be saved. Please, try again.'));
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
		if (!$this->Nacionalitefournisseur->exists($id)) {
			throw new NotFoundException(__('Invalid nacionalitefournisseur'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Nacionalitefournisseur->save($this->request->data)) {
				$this->Session->setFlash(__('The nacionalitefournisseur has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The nacionalitefournisseur could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Nacionalitefournisseur.' . $this->Nacionalitefournisseur->primaryKey => $id));
			$this->request->data = $this->Nacionalitefournisseur->find('first', $options);
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
		$this->Nacionalitefournisseur->id = $id;
		if (!$this->Nacionalitefournisseur->exists()) {
			throw new NotFoundException(__('Invalid nacionalitefournisseur'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Nacionalitefournisseur->delete()) {
			$this->Session->setFlash(__('Nacionalitefournisseur deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Nacionalitefournisseur was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
