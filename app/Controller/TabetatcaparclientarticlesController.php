<?php
App::uses('AppController', 'Controller');
/**
 * Tabetatcaparclientarticles Controller
 *
 * @property Tabetatcaparclientarticle $Tabetatcaparclientarticle
 */
class TabetatcaparclientarticlesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Tabetatcaparclientarticle->recursive = 0;
		$this->set('tabetatcaparclientarticles', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Tabetatcaparclientarticle->exists($id)) {
			throw new NotFoundException(__('Invalid tabetatcaparclientarticle'));
		}
		$options = array('conditions' => array('Tabetatcaparclientarticle.' . $this->Tabetatcaparclientarticle->primaryKey => $id));
		$this->set('tabetatcaparclientarticle', $this->Tabetatcaparclientarticle->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tabetatcaparclientarticle->create();
			if ($this->Tabetatcaparclientarticle->save($this->request->data)) {
				$this->Session->setFlash(__('The tabetatcaparclientarticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tabetatcaparclientarticle could not be saved. Please, try again.'));
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
		if (!$this->Tabetatcaparclientarticle->exists($id)) {
			throw new NotFoundException(__('Invalid tabetatcaparclientarticle'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Tabetatcaparclientarticle->save($this->request->data)) {
				$this->Session->setFlash(__('The tabetatcaparclientarticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tabetatcaparclientarticle could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tabetatcaparclientarticle.' . $this->Tabetatcaparclientarticle->primaryKey => $id));
			$this->request->data = $this->Tabetatcaparclientarticle->find('first', $options);
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
		$this->Tabetatcaparclientarticle->id = $id;
		if (!$this->Tabetatcaparclientarticle->exists()) {
			throw new NotFoundException(__('Invalid tabetatcaparclientarticle'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Tabetatcaparclientarticle->delete()) {
			$this->Session->setFlash(__('Tabetatcaparclientarticle deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Tabetatcaparclientarticle was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
