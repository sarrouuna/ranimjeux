<?php
App::uses('AppController', 'Controller');
/**
 * Lignelivraisons Controller
 *
 * @property Lignelivraison $Lignelivraison
 */
class LignelivraisonsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignelivraison->recursive = 0;
		$this->set('lignelivraisons', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignelivraison->exists($id)) {
			throw new NotFoundException(__('Invalid lignelivraison'));
		}
		$options = array('conditions' => array('Lignelivraison.' . $this->Lignelivraison->primaryKey => $id));
		$this->set('lignelivraison', $this->Lignelivraison->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignelivraison->create();
			if ($this->Lignelivraison->save($this->request->data)) {
				$this->Session->setFlash(__('The lignelivraison has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignelivraison could not be saved. Please, try again.'));
			}
		}
		$bonlivraisons = $this->Lignelivraison->Bonlivraison->find('list');
		$articles = $this->Lignelivraison->Article->find('list');
		$this->set(compact('bonlivraisons', 'articles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignelivraison->exists($id)) {
			throw new NotFoundException(__('Invalid lignelivraison'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignelivraison->save($this->request->data)) {
				$this->Session->setFlash(__('The lignelivraison has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignelivraison could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignelivraison.' . $this->Lignelivraison->primaryKey => $id));
			$this->request->data = $this->Lignelivraison->find('first', $options);
		}
		$bonlivraisons = $this->Lignelivraison->Bonlivraison->find('list');
		$articles = $this->Lignelivraison->Article->find('list');
		$this->set(compact('bonlivraisons', 'articles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignelivraison->id = $id;
		if (!$this->Lignelivraison->exists()) {
			throw new NotFoundException(__('Invalid lignelivraison'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignelivraison->delete()) {
			$this->Session->setFlash(__('Lignelivraison deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignelivraison was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
