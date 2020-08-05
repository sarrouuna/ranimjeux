<?php
App::uses('AppController', 'Controller');
/**
 * Lignereglements Controller
 *
 * @property Lignereglement $Lignereglement
 */
class LignereglementsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignereglement->recursive = 0;
		$this->set('lignereglements', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignereglement->exists($id)) {
			throw new NotFoundException(__('Invalid lignereglement'));
		}
		$options = array('conditions' => array('Lignereglement.' . $this->Lignereglement->primaryKey => $id));
		$this->set('lignereglement', $this->Lignereglement->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignereglement->create();
			if ($this->Lignereglement->save($this->request->data)) {
				$this->Session->setFlash(__('The lignereglement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignereglement could not be saved. Please, try again.'));
			}
		}
		$reglements = $this->Lignereglement->Reglement->find('list');
		$factures = $this->Lignereglement->Facture->find('list');
		$this->set(compact('reglements', 'factures'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignereglement->exists($id)) {
			throw new NotFoundException(__('Invalid lignereglement'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignereglement->save($this->request->data)) {
				$this->Session->setFlash(__('The lignereglement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignereglement could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignereglement.' . $this->Lignereglement->primaryKey => $id));
			$this->request->data = $this->Lignereglement->find('first', $options);
		}
		$reglements = $this->Lignereglement->Reglement->find('list');
		$factures = $this->Lignereglement->Facture->find('list');
		$this->set(compact('reglements', 'factures'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignereglement->id = $id;
		if (!$this->Lignereglement->exists()) {
			throw new NotFoundException(__('Invalid lignereglement'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignereglement->delete()) {
			$this->Session->setFlash(__('Lignereglement deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignereglement was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
