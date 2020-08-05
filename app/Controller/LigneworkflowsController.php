<?php
App::uses('AppController', 'Controller');
/**
 * Ligneworkflows Controller
 *
 * @property Ligneworkflow $Ligneworkflow
 */
class LigneworkflowsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Ligneworkflow->recursive = 0;
		$this->set('ligneworkflows', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Ligneworkflow->exists($id)) {
			throw new NotFoundException(__('Invalid ligneworkflow'));
		}
		$options = array('conditions' => array('Ligneworkflow.' . $this->Ligneworkflow->primaryKey => $id));
		$this->set('ligneworkflow', $this->Ligneworkflow->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Ligneworkflow->create();
			if ($this->Ligneworkflow->save($this->request->data)) {
				$this->Session->setFlash(__('The ligneworkflow has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ligneworkflow could not be saved. Please, try again.'));
			}
		}
		$workflows = $this->Ligneworkflow->Workflow->find('list');
		$typeworkflows = $this->Ligneworkflow->Typeworkflow->find('list');
		$personnels = $this->Ligneworkflow->Personnel->find('list');
		$this->set(compact('workflows', 'typeworkflows', 'personnels'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Ligneworkflow->exists($id)) {
			throw new NotFoundException(__('Invalid ligneworkflow'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ligneworkflow->save($this->request->data)) {
				$this->Session->setFlash(__('The ligneworkflow has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ligneworkflow could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Ligneworkflow.' . $this->Ligneworkflow->primaryKey => $id));
			$this->request->data = $this->Ligneworkflow->find('first', $options);
		}
		$workflows = $this->Ligneworkflow->Workflow->find('list');
		$typeworkflows = $this->Ligneworkflow->Typeworkflow->find('list');
		$personnels = $this->Ligneworkflow->Personnel->find('list');
		$this->set(compact('workflows', 'typeworkflows', 'personnels'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Ligneworkflow->id = $id;
		if (!$this->Ligneworkflow->exists()) {
			throw new NotFoundException(__('Invalid ligneworkflow'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Ligneworkflow->delete()) {
			$this->Session->setFlash(__('Ligneworkflow deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ligneworkflow was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
