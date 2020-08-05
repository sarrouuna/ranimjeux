<?php
App::uses('AppController', 'Controller');
/**
 * Fournisseurimportations Controller
 *
 * @property Fournisseurimportation $Fournisseurimportation
 */
class FournisseurimportationsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Fournisseurimportation->recursive = 0;
		$this->set('fournisseurimportations', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Fournisseurimportation->exists($id)) {
			throw new NotFoundException(__('Invalid fournisseurimportation'));
		}
		$options = array('conditions' => array('Fournisseurimportation.' . $this->Fournisseurimportation->primaryKey => $id));
		$this->set('fournisseurimportation', $this->Fournisseurimportation->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Fournisseurimportation->create();
			if ($this->Fournisseurimportation->save($this->request->data)) {
				$this->Session->setFlash(__('The fournisseurimportation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fournisseurimportation could not be saved. Please, try again.'));
			}
		}
		$fournisseurs = $this->Fournisseurimportation->Fournisseur->find('list');
		$importations = $this->Fournisseurimportation->Importation->find('list');
		$this->set(compact('fournisseurs', 'importations'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Fournisseurimportation->exists($id)) {
			throw new NotFoundException(__('Invalid fournisseurimportation'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Fournisseurimportation->save($this->request->data)) {
				$this->Session->setFlash(__('The fournisseurimportation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fournisseurimportation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Fournisseurimportation.' . $this->Fournisseurimportation->primaryKey => $id));
			$this->request->data = $this->Fournisseurimportation->find('first', $options);
		}
		$fournisseurs = $this->Fournisseurimportation->Fournisseur->find('list');
		$importations = $this->Fournisseurimportation->Importation->find('list');
		$this->set(compact('fournisseurs', 'importations'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Fournisseurimportation->id = $id;
		if (!$this->Fournisseurimportation->exists()) {
			throw new NotFoundException(__('Invalid fournisseurimportation'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Fournisseurimportation->delete()) {
			$this->Session->setFlash(__('Fournisseurimportation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Fournisseurimportation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
