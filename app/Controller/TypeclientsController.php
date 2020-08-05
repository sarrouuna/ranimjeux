<?php
App::uses('AppController', 'Controller');
/**
 * Typeclients Controller
 *
 * @property Typeclient $Typeclient
 */
class TypeclientsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Typeclient->recursive = 0;
		$this->set('typeclients', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Typeclient->exists($id)) {
			throw new NotFoundException(__('Invalid typeclient'));
		}
		$options = array('conditions' => array('Typeclient.' . $this->Typeclient->primaryKey => $id));
		$this->set('typeclient', $this->Typeclient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Typeclient->create();
			if ($this->Typeclient->save($this->request->data)) {
				$this->Session->setFlash(__('The typeclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typeclient could not be saved. Please, try again.'));
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
		if (!$this->Typeclient->exists($id)) {
			throw new NotFoundException(__('Invalid typeclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Typeclient->save($this->request->data)) {
				$this->Session->setFlash(__('The typeclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typeclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Typeclient.' . $this->Typeclient->primaryKey => $id));
			$this->request->data = $this->Typeclient->find('first', $options);
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
		$this->Typeclient->id = $id;
		if (!$this->Typeclient->exists()) {
			throw new NotFoundException(__('Invalid typeclient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Typeclient->delete()) {
			$this->Session->setFlash(__('Typeclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Typeclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
