<?php
App::uses('AppController', 'Controller');
/**
 * Typefactures Controller
 *
 * @property Typefacture $Typefacture
 */
class TypefacturesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Typefacture->recursive = 0;
		$this->set('typefactures', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Typefacture->exists($id)) {
			throw new NotFoundException(__('Invalid typefacture'));
		}
		$options = array('conditions' => array('Typefacture.' . $this->Typefacture->primaryKey => $id));
		$this->set('typefacture', $this->Typefacture->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Typefacture->create();
			if ($this->Typefacture->save($this->request->data)) {
				$this->Session->setFlash(__('The typefacture has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typefacture could not be saved. Please, try again.'));
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
		if (!$this->Typefacture->exists($id)) {
			throw new NotFoundException(__('Invalid typefacture'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Typefacture->save($this->request->data)) {
				$this->Session->setFlash(__('The typefacture has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typefacture could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Typefacture.' . $this->Typefacture->primaryKey => $id));
			$this->request->data = $this->Typefacture->find('first', $options);
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
		$this->Typefacture->id = $id;
		if (!$this->Typefacture->exists()) {
			throw new NotFoundException(__('Invalid typefacture'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Typefacture->delete()) {
			$this->Session->setFlash(__('Typefacture deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Typefacture was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
