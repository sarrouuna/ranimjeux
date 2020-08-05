<?php
App::uses('AppController', 'Controller');
/**
 * Lignevalides Controller
 *
 * @property Lignevalide $Lignevalide
 */
class LignevalidesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignevalide->recursive = 0;
		$this->set('lignevalides', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignevalide->exists($id)) {
			throw new NotFoundException(__('Invalid lignevalide'));
		}
		$options = array('conditions' => array('Lignevalide.' . $this->Lignevalide->primaryKey => $id));
		$this->set('lignevalide', $this->Lignevalide->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignevalide->create();
			if ($this->Lignevalide->save($this->request->data)) {
				$this->Session->setFlash(__('The lignevalide has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignevalide could not be saved. Please, try again.'));
			}
		}
		$ligneworkflows = $this->Lignevalide->Ligneworkflow->find('list');
		$documents = $this->Lignevalide->Document->find('list');
		$personnels = $this->Lignevalide->Personnel->find('list');
		$this->set(compact('ligneworkflows', 'documents', 'personnels'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignevalide->exists($id)) {
			throw new NotFoundException(__('Invalid lignevalide'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignevalide->save($this->request->data)) {
				$this->Session->setFlash(__('The lignevalide has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignevalide could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignevalide.' . $this->Lignevalide->primaryKey => $id));
			$this->request->data = $this->Lignevalide->find('first', $options);
		}
		$ligneworkflows = $this->Lignevalide->Ligneworkflow->find('list');
		$documents = $this->Lignevalide->Document->find('list');
		$personnels = $this->Lignevalide->Personnel->find('list');
		$this->set(compact('ligneworkflows', 'documents', 'personnels'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignevalide->id = $id;
		if (!$this->Lignevalide->exists()) {
			throw new NotFoundException(__('Invalid lignevalide'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignevalide->delete()) {
			$this->Session->setFlash(__('Lignevalide deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignevalide was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
