<?php
App::uses('AppController', 'Controller');
/**
 * Fournisseurdevises Controller
 *
 * @property Fournisseurdevise $Fournisseurdevise
 */
class FournisseurdevisesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Fournisseurdevise->recursive = 0;
		$this->set('fournisseurdevises', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Fournisseurdevise->exists($id)) {
			throw new NotFoundException(__('Invalid fournisseurdevise'));
		}
		$options = array('conditions' => array('Fournisseurdevise.' . $this->Fournisseurdevise->primaryKey => $id));
		$this->set('fournisseurdevise', $this->Fournisseurdevise->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Fournisseurdevise->create();
			if ($this->Fournisseurdevise->save($this->request->data)) {
				$this->Session->setFlash(__('The fournisseurdevise has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fournisseurdevise could not be saved. Please, try again.'));
			}
		}
		$fournisseurs = $this->Fournisseurdevise->Fournisseur->find('list');
		$devises = $this->Fournisseurdevise->Devise->find('list');
		$this->set(compact('fournisseurs', 'devises'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Fournisseurdevise->exists($id)) {
			throw new NotFoundException(__('Invalid fournisseurdevise'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Fournisseurdevise->save($this->request->data)) {
				$this->Session->setFlash(__('The fournisseurdevise has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fournisseurdevise could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Fournisseurdevise.' . $this->Fournisseurdevise->primaryKey => $id));
			$this->request->data = $this->Fournisseurdevise->find('first', $options);
		}
		$fournisseurs = $this->Fournisseurdevise->Fournisseur->find('list');
		$devises = $this->Fournisseurdevise->Devise->find('list');
		$this->set(compact('fournisseurs', 'devises'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Fournisseurdevise->id = $id;
		if (!$this->Fournisseurdevise->exists()) {
			throw new NotFoundException(__('Invalid fournisseurdevise'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Fournisseurdevise->delete()) {
			$this->Session->setFlash(__('Fournisseurdevise deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Fournisseurdevise was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
