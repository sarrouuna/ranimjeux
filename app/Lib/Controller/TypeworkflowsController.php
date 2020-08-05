<?php
App::uses('AppController', 'Controller');
/**
 * Typeworkflows Controller
 *
 * @property Typeworkflow $Typeworkflow
 */
class TypeworkflowsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Typeworkflow->recursive = 0;
		$this->set('typeworkflows', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Typeworkflow->exists($id)) {
			throw new NotFoundException(__('Invalid typeworkflow'));
		}
		$options = array('conditions' => array('Typeworkflow.' . $this->Typeworkflow->primaryKey => $id));
		$this->set('typeworkflow', $this->Typeworkflow->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Typeworkflow->create();
			if ($this->Typeworkflow->save($this->request->data)) {
				$this->Session->setFlash(__('The typeworkflow has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typeworkflow could not be saved. Please, try again.'));
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
		if (!$this->Typeworkflow->exists($id)) {
			throw new NotFoundException(__('Invalid typeworkflow'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Typeworkflow->save($this->request->data)) {
				$this->Session->setFlash(__('The typeworkflow has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typeworkflow could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Typeworkflow.' . $this->Typeworkflow->primaryKey => $id));
			$this->request->data = $this->Typeworkflow->find('first', $options);
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
		$this->Typeworkflow->id = $id;
		if (!$this->Typeworkflow->exists()) {
			throw new NotFoundException(__('Invalid typeworkflow'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Typeworkflow->delete()) {
			$this->Session->setFlash(__('Typeworkflow deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Typeworkflow was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
