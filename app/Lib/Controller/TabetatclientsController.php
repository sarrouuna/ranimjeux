<?php
App::uses('AppController', 'Controller');
/**
 * Tabetatclients Controller
 *
 * @property Tabetatclient $Tabetatclient
 */
class TabetatclientsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Tabetatclient->recursive = 0;
		$this->set('tabetatclients', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Tabetatclient->exists($id)) {
			throw new NotFoundException(__('Invalid tabetatclient'));
		}
		$options = array('conditions' => array('Tabetatclient.' . $this->Tabetatclient->primaryKey => $id));
		$this->set('tabetatclient', $this->Tabetatclient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tabetatclient->create();
			if ($this->Tabetatclient->save($this->request->data)) {
				$this->Session->setFlash(__('The tabetatclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tabetatclient could not be saved. Please, try again.'));
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
		if (!$this->Tabetatclient->exists($id)) {
			throw new NotFoundException(__('Invalid tabetatclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Tabetatclient->save($this->request->data)) {
				$this->Session->setFlash(__('The tabetatclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tabetatclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tabetatclient.' . $this->Tabetatclient->primaryKey => $id));
			$this->request->data = $this->Tabetatclient->find('first', $options);
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
		$this->Tabetatclient->id = $id;
		if (!$this->Tabetatclient->exists()) {
			throw new NotFoundException(__('Invalid tabetatclient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Tabetatclient->delete()) {
			$this->Session->setFlash(__('Tabetatclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Tabetatclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
