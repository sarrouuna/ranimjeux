<?php
App::uses('AppController', 'Controller');
/**
 * Typedevisclients Controller
 *
 * @property Typedevisclient $Typedevisclient
 */
class TypedevisclientsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Typedevisclient->recursive = 0;
		$this->set('typedevisclients', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Typedevisclient->exists($id)) {
			throw new NotFoundException(__('Invalid typedevisclient'));
		}
		$options = array('conditions' => array('Typedevisclient.' . $this->Typedevisclient->primaryKey => $id));
		$this->set('typedevisclient', $this->Typedevisclient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Typedevisclient->create();
			if ($this->Typedevisclient->save($this->request->data)) {
				$this->Session->setFlash(__('The typedevisclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typedevisclient could not be saved. Please, try again.'));
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
		if (!$this->Typedevisclient->exists($id)) {
			throw new NotFoundException(__('Invalid typedevisclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Typedevisclient->save($this->request->data)) {
				$this->Session->setFlash(__('The typedevisclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typedevisclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Typedevisclient.' . $this->Typedevisclient->primaryKey => $id));
			$this->request->data = $this->Typedevisclient->find('first', $options);
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
		$this->Typedevisclient->id = $id;
		if (!$this->Typedevisclient->exists()) {
			throw new NotFoundException(__('Invalid typedevisclient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Typedevisclient->delete()) {
			$this->Session->setFlash(__('Typedevisclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Typedevisclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
