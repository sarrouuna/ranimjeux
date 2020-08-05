<?php
App::uses('AppController', 'Controller');
/**
 * Tabetatcaparpersonnels Controller
 *
 * @property Tabetatcaparpersonnel $Tabetatcaparpersonnel
 */
class TabetatcaparpersonnelsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Tabetatcaparpersonnel->recursive = 0;
		$this->set('tabetatcaparpersonnels', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Tabetatcaparpersonnel->exists($id)) {
			throw new NotFoundException(__('Invalid tabetatcaparpersonnel'));
		}
		$options = array('conditions' => array('Tabetatcaparpersonnel.' . $this->Tabetatcaparpersonnel->primaryKey => $id));
		$this->set('tabetatcaparpersonnel', $this->Tabetatcaparpersonnel->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tabetatcaparpersonnel->create();
			if ($this->Tabetatcaparpersonnel->save($this->request->data)) {
				$this->Session->setFlash(__('The tabetatcaparpersonnel has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tabetatcaparpersonnel could not be saved. Please, try again.'));
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
		if (!$this->Tabetatcaparpersonnel->exists($id)) {
			throw new NotFoundException(__('Invalid tabetatcaparpersonnel'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Tabetatcaparpersonnel->save($this->request->data)) {
				$this->Session->setFlash(__('The tabetatcaparpersonnel has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tabetatcaparpersonnel could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tabetatcaparpersonnel.' . $this->Tabetatcaparpersonnel->primaryKey => $id));
			$this->request->data = $this->Tabetatcaparpersonnel->find('first', $options);
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
		$this->Tabetatcaparpersonnel->id = $id;
		if (!$this->Tabetatcaparpersonnel->exists()) {
			throw new NotFoundException(__('Invalid tabetatcaparpersonnel'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Tabetatcaparpersonnel->delete()) {
			$this->Session->setFlash(__('Tabetatcaparpersonnel deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Tabetatcaparpersonnel was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
