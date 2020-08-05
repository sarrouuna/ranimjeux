<?php
App::uses('AppController', 'Controller');
/**
 * Typesuivitdevis Controller
 *
 * @property Typesuivitdevi $Typesuivitdevi
 */
class TypesuivitdevisController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Typesuivitdevi->recursive = 0;
		$this->set('typesuivitdevis', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Typesuivitdevi->exists($id)) {
			throw new NotFoundException(__('Invalid typesuivitdevi'));
		}
		$options = array('conditions' => array('Typesuivitdevi.' . $this->Typesuivitdevi->primaryKey => $id));
		$this->set('typesuivitdevi', $this->Typesuivitdevi->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Typesuivitdevi->create();
			if ($this->Typesuivitdevi->save($this->request->data)) {
				$this->Session->setFlash(__('The typesuivitdevi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typesuivitdevi could not be saved. Please, try again.'));
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
		if (!$this->Typesuivitdevi->exists($id)) {
			throw new NotFoundException(__('Invalid typesuivitdevi'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Typesuivitdevi->save($this->request->data)) {
				$this->Session->setFlash(__('The typesuivitdevi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typesuivitdevi could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Typesuivitdevi.' . $this->Typesuivitdevi->primaryKey => $id));
			$this->request->data = $this->Typesuivitdevi->find('first', $options);
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
		$this->Typesuivitdevi->id = $id;
		if (!$this->Typesuivitdevi->exists()) {
			throw new NotFoundException(__('Invalid typesuivitdevi'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Typesuivitdevi->delete()) {
			$this->Session->setFlash(__('Typesuivitdevi deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Typesuivitdevi was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
