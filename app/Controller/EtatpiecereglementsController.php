<?php
App::uses('AppController', 'Controller');
/**
 * Etatpiecereglements Controller
 *
 * @property Etatpiecereglement $Etatpiecereglement
 */
class EtatpiecereglementsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Etatpiecereglement->recursive = 0;
		$this->set('etatpiecereglements', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Etatpiecereglement->exists($id)) {
			throw new NotFoundException(__('Invalid etatpiecereglement'));
		}
		$options = array('conditions' => array('Etatpiecereglement.' . $this->Etatpiecereglement->primaryKey => $id));
		$this->set('etatpiecereglement', $this->Etatpiecereglement->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Etatpiecereglement->create();
			if ($this->Etatpiecereglement->save($this->request->data)) {
				$this->Session->setFlash(__('The etatpiecereglement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatpiecereglement could not be saved. Please, try again.'));
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
		if (!$this->Etatpiecereglement->exists($id)) {
			throw new NotFoundException(__('Invalid etatpiecereglement'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Etatpiecereglement->save($this->request->data)) {
				$this->Session->setFlash(__('The etatpiecereglement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatpiecereglement could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Etatpiecereglement.' . $this->Etatpiecereglement->primaryKey => $id));
			$this->request->data = $this->Etatpiecereglement->find('first', $options);
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
		$this->Etatpiecereglement->id = $id;
		if (!$this->Etatpiecereglement->exists()) {
			throw new NotFoundException(__('Invalid etatpiecereglement'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Etatpiecereglement->delete()) {
			$this->Session->setFlash(__('Etatpiecereglement deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Etatpiecereglement was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
