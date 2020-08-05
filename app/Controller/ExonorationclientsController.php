<?php
App::uses('AppController', 'Controller');
/**
 * Exonorationclients Controller
 *
 * @property Exonorationclient $Exonorationclient
 */
class ExonorationclientsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Exonorationclient->recursive = 0;
		$this->set('exonorationclients', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Exonorationclient->exists($id)) {
			throw new NotFoundException(__('Invalid exonorationclient'));
		}
		$options = array('conditions' => array('Exonorationclient.' . $this->Exonorationclient->primaryKey => $id));
		$this->set('exonorationclient', $this->Exonorationclient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Exonorationclient->create();
			if ($this->Exonorationclient->save($this->request->data)) {
				$this->Session->setFlash(__('The exonorationclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The exonorationclient could not be saved. Please, try again.'));
			}
		}
		$clients = $this->Exonorationclient->Client->find('list');
		$this->set(compact('clients'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Exonorationclient->exists($id)) {
			throw new NotFoundException(__('Invalid exonorationclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Exonorationclient->save($this->request->data)) {
				$this->Session->setFlash(__('The exonorationclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The exonorationclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Exonorationclient.' . $this->Exonorationclient->primaryKey => $id));
			$this->request->data = $this->Exonorationclient->find('first', $options);
		}
		$clients = $this->Exonorationclient->Client->find('list');
		$this->set(compact('clients'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Exonorationclient->id = $id;
		if (!$this->Exonorationclient->exists()) {
			throw new NotFoundException(__('Invalid exonorationclient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Exonorationclient->delete()) {
			$this->Session->setFlash(__('Exonorationclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Exonorationclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
