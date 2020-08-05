<?php
App::uses('AppController', 'Controller');
/**
 * Lignereceptions Controller
 *
 * @property Lignereception $Lignereception
 */
class LignereceptionsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignereception->recursive = 0;
		$this->set('lignereceptions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignereception->exists($id)) {
			throw new NotFoundException(__('Invalid lignereception'));
		}
		$options = array('conditions' => array('Lignereception.' . $this->Lignereception->primaryKey => $id));
		$this->set('lignereception', $this->Lignereception->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignereception->create();
			if ($this->Lignereception->save($this->request->data)) {
				$this->Session->setFlash(__('The lignereception has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignereception could not be saved. Please, try again.'));
			}
		}
		$bonreceptions = $this->Lignereception->Bonreception->find('list');
		$articles = $this->Lignereception->Article->find('list');
		$this->set(compact('bonreceptions', 'articles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignereception->exists($id)) {
			throw new NotFoundException(__('Invalid lignereception'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignereception->save($this->request->data)) {
				$this->Session->setFlash(__('The lignereception has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignereception could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignereception.' . $this->Lignereception->primaryKey => $id));
			$this->request->data = $this->Lignereception->find('first', $options);
		}
		$bonreceptions = $this->Lignereception->Bonreception->find('list');
		$articles = $this->Lignereception->Article->find('list');
		$this->set(compact('bonreceptions', 'articles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignereception->id = $id;
		if (!$this->Lignereception->exists()) {
			throw new NotFoundException(__('Invalid lignereception'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignereception->delete()) {
			$this->Session->setFlash(__('Lignereception deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignereception was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
