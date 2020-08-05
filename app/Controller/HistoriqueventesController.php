<?php
App::uses('AppController', 'Controller');
/**
 * Historiqueventes Controller
 *
 * @property Historiquevente $Historiquevente
 */
class HistoriqueventesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Historiquevente->recursive = 0;
		$this->set('historiqueventes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Historiquevente->exists($id)) {
			throw new NotFoundException(__('Invalid historiquevente'));
		}
		$options = array('conditions' => array('Historiquevente.' . $this->Historiquevente->primaryKey => $id));
		$this->set('historiquevente', $this->Historiquevente->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Historiquevente->create();
			if ($this->Historiquevente->save($this->request->data)) {
				$this->Session->setFlash(__('The historiquevente has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The historiquevente could not be saved. Please, try again.'));
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
		if (!$this->Historiquevente->exists($id)) {
			throw new NotFoundException(__('Invalid historiquevente'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Historiquevente->save($this->request->data)) {
				$this->Session->setFlash(__('The historiquevente has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The historiquevente could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Historiquevente.' . $this->Historiquevente->primaryKey => $id));
			$this->request->data = $this->Historiquevente->find('first', $options);
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
		$this->Historiquevente->id = $id;
		if (!$this->Historiquevente->exists()) {
			throw new NotFoundException(__('Invalid historiquevente'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Historiquevente->delete()) {
			$this->Session->setFlash(__('Historiquevente deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Historiquevente was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
