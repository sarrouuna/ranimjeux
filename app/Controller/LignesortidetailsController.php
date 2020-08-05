<?php
App::uses('AppController', 'Controller');
/**
 * Lignesortidetails Controller
 *
 * @property Lignesortidetail $Lignesortidetail
 */
class LignesortidetailsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignesortidetail->recursive = 0;
		$this->set('lignesortidetails', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignesortidetail->exists($id)) {
			throw new NotFoundException(__('Invalid lignesortidetail'));
		}
		$options = array('conditions' => array('Lignesortidetail.' . $this->Lignesortidetail->primaryKey => $id));
		$this->set('lignesortidetail', $this->Lignesortidetail->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignesortidetail->create();
			if ($this->Lignesortidetail->save($this->request->data)) {
				$this->Session->setFlash(__('The lignesortidetail has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignesortidetail could not be saved. Please, try again.'));
			}
		}
		$lignesortis = $this->Lignesortidetail->Lignesorti->find('list');
		$stockdepots = $this->Lignesortidetail->Stockdepot->find('list');
		$this->set(compact('lignesortis', 'stockdepots'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignesortidetail->exists($id)) {
			throw new NotFoundException(__('Invalid lignesortidetail'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignesortidetail->save($this->request->data)) {
				$this->Session->setFlash(__('The lignesortidetail has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignesortidetail could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignesortidetail.' . $this->Lignesortidetail->primaryKey => $id));
			$this->request->data = $this->Lignesortidetail->find('first', $options);
		}
		$lignesortis = $this->Lignesortidetail->Lignesorti->find('list');
		$stockdepots = $this->Lignesortidetail->Stockdepot->find('list');
		$this->set(compact('lignesortis', 'stockdepots'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignesortidetail->id = $id;
		if (!$this->Lignesortidetail->exists()) {
			throw new NotFoundException(__('Invalid lignesortidetail'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignesortidetail->delete()) {
			$this->Session->setFlash(__('Lignesortidetail deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignesortidetail was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
