<?php
App::uses('AppController', 'Controller');
/**
 * Stockdepotfactures Controller
 *
 * @property Stockdepotfacture $Stockdepotfacture
 */
class StockdepotfacturesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Stockdepotfacture->recursive = 0;
		$this->set('stockdepotfactures', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Stockdepotfacture->exists($id)) {
			throw new NotFoundException(__('Invalid stockdepotfacture'));
		}
		$options = array('conditions' => array('Stockdepotfacture.' . $this->Stockdepotfacture->primaryKey => $id));
		$this->set('stockdepotfacture', $this->Stockdepotfacture->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Stockdepotfacture->create();
			if ($this->Stockdepotfacture->save($this->request->data)) {
				$this->Session->setFlash(__('The stockdepotfacture has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The stockdepotfacture could not be saved. Please, try again.'));
			}
		}
		$factureclients = $this->Stockdepotfacture->Factureclient->find('list');
		$stockdepots = $this->Stockdepotfacture->Stockdepot->find('list');
		$this->set(compact('factureclients', 'stockdepots'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Stockdepotfacture->exists($id)) {
			throw new NotFoundException(__('Invalid stockdepotfacture'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Stockdepotfacture->save($this->request->data)) {
				$this->Session->setFlash(__('The stockdepotfacture has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The stockdepotfacture could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Stockdepotfacture.' . $this->Stockdepotfacture->primaryKey => $id));
			$this->request->data = $this->Stockdepotfacture->find('first', $options);
		}
		$factureclients = $this->Stockdepotfacture->Factureclient->find('list');
		$stockdepots = $this->Stockdepotfacture->Stockdepot->find('list');
		$this->set(compact('factureclients', 'stockdepots'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Stockdepotfacture->id = $id;
		if (!$this->Stockdepotfacture->exists()) {
			throw new NotFoundException(__('Invalid stockdepotfacture'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Stockdepotfacture->delete()) {
			$this->Session->setFlash(__('Stockdepotfacture deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Stockdepotfacture was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
