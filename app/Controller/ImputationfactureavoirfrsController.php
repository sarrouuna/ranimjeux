<?php
App::uses('AppController', 'Controller');
/**
 * Imputationfactureavoirfrs Controller
 *
 * @property Imputationfactureavoirfr $Imputationfactureavoirfr
 */
class ImputationfactureavoirfrsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Imputationfactureavoirfr->recursive = 0;
		$this->set('imputationfactureavoirfrs', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Imputationfactureavoirfr->exists($id)) {
			throw new NotFoundException(__('Invalid imputationfactureavoirfr'));
		}
		$options = array('conditions' => array('Imputationfactureavoirfr.' . $this->Imputationfactureavoirfr->primaryKey => $id));
		$this->set('imputationfactureavoirfr', $this->Imputationfactureavoirfr->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Imputationfactureavoirfr->create();
			if ($this->Imputationfactureavoirfr->save($this->request->data)) {
				$this->Session->setFlash(__('The imputationfactureavoirfr has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The imputationfactureavoirfr could not be saved. Please, try again.'));
			}
		}
		$factureavoirfrs = $this->Imputationfactureavoirfr->Factureavoirfr->find('list');
		$factures = $this->Imputationfactureavoirfr->Facture->find('list');
		$this->set(compact('factureavoirfrs', 'factures'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Imputationfactureavoirfr->exists($id)) {
			throw new NotFoundException(__('Invalid imputationfactureavoirfr'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Imputationfactureavoirfr->save($this->request->data)) {
				$this->Session->setFlash(__('The imputationfactureavoirfr has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The imputationfactureavoirfr could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Imputationfactureavoirfr.' . $this->Imputationfactureavoirfr->primaryKey => $id));
			$this->request->data = $this->Imputationfactureavoirfr->find('first', $options);
		}
		$factureavoirfrs = $this->Imputationfactureavoirfr->Factureavoirfr->find('list');
		$factures = $this->Imputationfactureavoirfr->Facture->find('list');
		$this->set(compact('factureavoirfrs', 'factures'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Imputationfactureavoirfr->id = $id;
		if (!$this->Imputationfactureavoirfr->exists()) {
			throw new NotFoundException(__('Invalid imputationfactureavoirfr'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Imputationfactureavoirfr->delete()) {
			$this->Session->setFlash(__('Imputationfactureavoirfr deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Imputationfactureavoirfr was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
