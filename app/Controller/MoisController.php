<?php
App::uses('AppController', 'Controller');
/**
 * Mois Controller
 *
 * @property Mois $Mois
 */
class MoisController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Mois->recursive = 0;
		$this->set('mois', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Mois->exists($id)) {
			throw new NotFoundException(__('Invalid mois'));
		}
		$options = array('conditions' => array('Mois.' . $this->Mois->primaryKey => $id));
		$this->set('mois', $this->Mois->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Mois->create();
			if ($this->Mois->save($this->request->data)) {
				$this->Session->setFlash(__('The mois has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mois could not be saved. Please, try again.'));
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
		if (!$this->Mois->exists($id)) {
			throw new NotFoundException(__('Invalid mois'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Mois->save($this->request->data)) {
				$this->Session->setFlash(__('The mois has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The mois could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Mois.' . $this->Mois->primaryKey => $id));
			$this->request->data = $this->Mois->find('first', $options);
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
		$this->Mois->id = $id;
		if (!$this->Mois->exists()) {
			throw new NotFoundException(__('Invalid mois'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Mois->delete()) {
			$this->Session->setFlash(__('Mois deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Mois was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
