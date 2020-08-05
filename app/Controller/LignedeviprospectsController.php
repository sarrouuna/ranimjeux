<?php
App::uses('AppController', 'Controller');
/**
 * Lignedeviprospects Controller
 *
 * @property Lignedeviprospect $Lignedeviprospect
 */
class LignedeviprospectsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignedeviprospect->recursive = 0;
		$this->set('lignedeviprospects', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignedeviprospect->exists($id)) {
			throw new NotFoundException(__('Invalid lignedeviprospect'));
		}
		$options = array('conditions' => array('Lignedeviprospect.' . $this->Lignedeviprospect->primaryKey => $id));
		$this->set('lignedeviprospect', $this->Lignedeviprospect->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignedeviprospect->create();
			if ($this->Lignedeviprospect->save($this->request->data)) {
				$this->Session->setFlash(__('The lignedeviprospect has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignedeviprospect could not be saved. Please, try again.'));
			}
		}
		$deviprospects = $this->Lignedeviprospect->Deviprospect->find('list');
		$articles = $this->Lignedeviprospect->Article->find('list');
		$this->set(compact('deviprospects', 'articles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignedeviprospect->exists($id)) {
			throw new NotFoundException(__('Invalid lignedeviprospect'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignedeviprospect->save($this->request->data)) {
				$this->Session->setFlash(__('The lignedeviprospect has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignedeviprospect could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignedeviprospect.' . $this->Lignedeviprospect->primaryKey => $id));
			$this->request->data = $this->Lignedeviprospect->find('first', $options);
		}
		$deviprospects = $this->Lignedeviprospect->Deviprospect->find('list');
		$articles = $this->Lignedeviprospect->Article->find('list');
		$this->set(compact('deviprospects', 'articles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignedeviprospect->id = $id;
		if (!$this->Lignedeviprospect->exists()) {
			throw new NotFoundException(__('Invalid lignedeviprospect'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignedeviprospect->delete()) {
			$this->Session->setFlash(__('Lignedeviprospect deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignedeviprospect was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
