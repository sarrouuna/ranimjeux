<?php
App::uses('AppController', 'Controller');
/**
 * Modeclients Controller
 *
 * @property Modeclient $Modeclient
 */
class ModeclientsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Modeclient->recursive = 0;
		$this->set('modeclients', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Modeclient->exists($id)) {
			throw new NotFoundException(__('Invalid modeclient'));
		}
		$options = array('conditions' => array('Modeclient.' . $this->Modeclient->primaryKey => $id));
		$this->set('modeclient', $this->Modeclient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Modeclient->create();
			if ($this->Modeclient->save($this->request->data)) {
				$this->Session->setFlash(__('The modeclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The modeclient could not be saved. Please, try again.'));
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
		if (!$this->Modeclient->exists($id)) {
			throw new NotFoundException(__('Invalid modeclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Modeclient->save($this->request->data)) {
				$this->Session->setFlash(__('The modeclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The modeclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Modeclient.' . $this->Modeclient->primaryKey => $id));
			$this->request->data = $this->Modeclient->find('first', $options);
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
		$this->Modeclient->id = $id;
		if (!$this->Modeclient->exists()) {
			throw new NotFoundException(__('Invalid modeclient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Modeclient->delete()) {
			$this->Session->setFlash(__('Modeclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Modeclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
