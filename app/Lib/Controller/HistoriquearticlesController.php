<?php
App::uses('AppController', 'Controller');
/**
 * Historiquearticles Controller
 *
 * @property Historiquearticle $Historiquearticle
 */
class HistoriquearticlesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Historiquearticle->recursive = 0;
		$this->set('historiquearticles', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Historiquearticle->exists($id)) {
			throw new NotFoundException(__('Invalid historiquearticle'));
		}
		$options = array('conditions' => array('Historiquearticle.' . $this->Historiquearticle->primaryKey => $id));
		$this->set('historiquearticle', $this->Historiquearticle->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Historiquearticle->create();
			if ($this->Historiquearticle->save($this->request->data)) {
				$this->Session->setFlash(__('The historiquearticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The historiquearticle could not be saved. Please, try again.'));
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
		if (!$this->Historiquearticle->exists($id)) {
			throw new NotFoundException(__('Invalid historiquearticle'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Historiquearticle->save($this->request->data)) {
				$this->Session->setFlash(__('The historiquearticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The historiquearticle could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Historiquearticle.' . $this->Historiquearticle->primaryKey => $id));
			$this->request->data = $this->Historiquearticle->find('first', $options);
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
		$this->Historiquearticle->id = $id;
		if (!$this->Historiquearticle->exists()) {
			throw new NotFoundException(__('Invalid historiquearticle'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Historiquearticle->delete()) {
			$this->Session->setFlash(__('Historiquearticle deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Historiquearticle was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
