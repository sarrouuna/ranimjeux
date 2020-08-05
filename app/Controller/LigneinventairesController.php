<?php
App::uses('AppController', 'Controller');
/**
 * Ligneinventaires Controller
 *
 * @property Ligneinventaire $Ligneinventaire
 */
class LigneinventairesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Ligneinventaire->recursive = 0;
		$this->set('ligneinventaires', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Ligneinventaire->exists($id)) {
			throw new NotFoundException(__('Invalid ligneinventaire'));
		}
		$options = array('conditions' => array('Ligneinventaire.' . $this->Ligneinventaire->primaryKey => $id));
		$this->set('ligneinventaire', $this->Ligneinventaire->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Ligneinventaire->create();
			if ($this->Ligneinventaire->save($this->request->data)) {
				$this->Session->setFlash(__('The ligneinventaire has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ligneinventaire could not be saved. Please, try again.'));
			}
		}
		$inventaires = $this->Ligneinventaire->Inventaire->find('list');
		$articles = $this->Ligneinventaire->Article->find('list');
		$this->set(compact('inventaires', 'articles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Ligneinventaire->exists($id)) {
			throw new NotFoundException(__('Invalid ligneinventaire'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ligneinventaire->save($this->request->data)) {
				$this->Session->setFlash(__('The ligneinventaire has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ligneinventaire could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Ligneinventaire.' . $this->Ligneinventaire->primaryKey => $id));
			$this->request->data = $this->Ligneinventaire->find('first', $options);
		}
		$inventaires = $this->Ligneinventaire->Inventaire->find('list');
		$articles = $this->Ligneinventaire->Article->find('list');
		$this->set(compact('inventaires', 'articles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Ligneinventaire->id = $id;
		if (!$this->Ligneinventaire->exists()) {
			throw new NotFoundException(__('Invalid ligneinventaire'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Ligneinventaire->delete()) {
			$this->Session->setFlash(__('Ligneinventaire deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ligneinventaire was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
