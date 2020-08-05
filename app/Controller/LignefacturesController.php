<?php
App::uses('AppController', 'Controller');
/**
 * Lignefactures Controller
 *
 * @property Lignefacture $Lignefacture
 */
class LignefacturesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignefacture->recursive = 0;
		$this->set('lignefactures', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignefacture->exists($id)) {
			throw new NotFoundException(__('Invalid lignefacture'));
		}
		$options = array('conditions' => array('Lignefacture.' . $this->Lignefacture->primaryKey => $id));
		$this->set('lignefacture', $this->Lignefacture->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignefacture->create();
			if ($this->Lignefacture->save($this->request->data)) {
				$this->Session->setFlash(__('The lignefacture has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignefacture could not be saved. Please, try again.'));
			}
		}
		$factures = $this->Lignefacture->Facture->find('list');
		$articles = $this->Lignefacture->Article->find('list');
		$this->set(compact('factures', 'articles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignefacture->exists($id)) {
			throw new NotFoundException(__('Invalid lignefacture'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignefacture->save($this->request->data)) {
				$this->Session->setFlash(__('The lignefacture has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignefacture could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignefacture.' . $this->Lignefacture->primaryKey => $id));
			$this->request->data = $this->Lignefacture->find('first', $options);
		}
		$factures = $this->Lignefacture->Facture->find('list');
		$articles = $this->Lignefacture->Article->find('list');
		$this->set(compact('factures', 'articles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignefacture->id = $id;
		if (!$this->Lignefacture->exists()) {
			throw new NotFoundException(__('Invalid lignefacture'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignefacture->delete()) {
			$this->Session->setFlash(__('Lignefacture deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignefacture was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
