<?php
App::uses('AppController', 'Controller');
/**
 * Paiements Controller
 *
 * @property Paiement $Paiement
 */
class PaiementsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Paiement->recursive = 0;
		$this->set('paiements', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Paiement->exists($id)) {
			throw new NotFoundException(__('Invalid paiement'));
		}
		$options = array('conditions' => array('Paiement.' . $this->Paiement->primaryKey => $id));
		$this->set('paiement', $this->Paiement->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Paiement->create();
			if ($this->Paiement->save($this->request->data)) {
				$this->Session->setFlash(__('The paiement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The paiement could not be saved. Please, try again.'));
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
		if (!$this->Paiement->exists($id)) {
			throw new NotFoundException(__('Invalid paiement'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Paiement->save($this->request->data)) {
				$this->Session->setFlash(__('The paiement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The paiement could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Paiement.' . $this->Paiement->primaryKey => $id));
			$this->request->data = $this->Paiement->find('first', $options);
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
		$this->Paiement->id = $id;
		if (!$this->Paiement->exists()) {
			throw new NotFoundException(__('Invalid paiement'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Paiement->delete()) {
			$this->Session->setFlash(__('Paiement deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Paiement was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
