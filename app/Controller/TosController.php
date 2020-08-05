<?php
App::uses('AppController', 'Controller');
/**
 * Tos Controller
 *
 * @property To $To
 */
class TosController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->To->recursive = 0;
		$this->set('tos', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->To->exists($id)) {
			throw new NotFoundException(__('Invalid to'));
		}
		$options = array('conditions' => array('To.' . $this->To->primaryKey => $id));
		$this->set('to', $this->To->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->To->create();
			if ($this->To->save($this->request->data)) {
				$this->Session->setFlash(__('The to has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The to could not be saved. Please, try again.'));
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
		if (!$this->To->exists($id)) {
			throw new NotFoundException(__('Invalid to'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->To->save($this->request->data)) {
				$this->Session->setFlash(__('The to has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The to could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('To.' . $this->To->primaryKey => $id));
			$this->request->data = $this->To->find('first', $options);
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
		$this->To->id = $id;
		if (!$this->To->exists()) {
			throw new NotFoundException(__('Invalid to'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->To->delete()) {
			$this->Session->setFlash(__('To deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('To was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
