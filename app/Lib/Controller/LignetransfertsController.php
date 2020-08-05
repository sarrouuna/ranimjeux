<?php
App::uses('AppController', 'Controller');
/**
 * Lignetransferts Controller
 *
 * @property Lignetransfert $Lignetransfert
 */
class LignetransfertsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignetransfert->recursive = 0;
		$this->set('lignetransferts', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignetransfert->exists($id)) {
			throw new NotFoundException(__('Invalid lignetransfert'));
		}
		$options = array('conditions' => array('Lignetransfert.' . $this->Lignetransfert->primaryKey => $id));
		$this->set('lignetransfert', $this->Lignetransfert->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignetransfert->create();
			if ($this->Lignetransfert->save($this->request->data)) {
				$this->Session->setFlash(__('The lignetransfert has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignetransfert could not be saved. Please, try again.'));
			}
		}
		$articles = $this->Lignetransfert->Article->find('list');
		$transferts = $this->Lignetransfert->Transfert->find('list');
		$this->set(compact('articles', 'transferts'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignetransfert->exists($id)) {
			throw new NotFoundException(__('Invalid lignetransfert'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignetransfert->save($this->request->data)) {
				$this->Session->setFlash(__('The lignetransfert has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignetransfert could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignetransfert.' . $this->Lignetransfert->primaryKey => $id));
			$this->request->data = $this->Lignetransfert->find('first', $options);
		}
		$articles = $this->Lignetransfert->Article->find('list');
		$transferts = $this->Lignetransfert->Transfert->find('list');
		$this->set(compact('articles', 'transferts'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignetransfert->id = $id;
		if (!$this->Lignetransfert->exists()) {
			throw new NotFoundException(__('Invalid lignetransfert'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignetransfert->delete()) {
			$this->Session->setFlash(__('Lignetransfert deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignetransfert was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
