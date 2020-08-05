<?php
App::uses('AppController', 'Controller');
/**
 * Tabetatarticles Controller
 *
 * @property Tabetatarticle $Tabetatarticle
 */
class TabetatarticlesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Tabetatarticle->recursive = 0;
		$this->set('tabetatarticles', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Tabetatarticle->exists($id)) {
			throw new NotFoundException(__('Invalid tabetatarticle'));
		}
		$options = array('conditions' => array('Tabetatarticle.' . $this->Tabetatarticle->primaryKey => $id));
		$this->set('tabetatarticle', $this->Tabetatarticle->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tabetatarticle->create();
			if ($this->Tabetatarticle->save($this->request->data)) {
				$this->Session->setFlash(__('The tabetatarticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tabetatarticle could not be saved. Please, try again.'));
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
		if (!$this->Tabetatarticle->exists($id)) {
			throw new NotFoundException(__('Invalid tabetatarticle'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Tabetatarticle->save($this->request->data)) {
				$this->Session->setFlash(__('The tabetatarticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tabetatarticle could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tabetatarticle.' . $this->Tabetatarticle->primaryKey => $id));
			$this->request->data = $this->Tabetatarticle->find('first', $options);
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
		$this->Tabetatarticle->id = $id;
		if (!$this->Tabetatarticle->exists()) {
			throw new NotFoundException(__('Invalid tabetatarticle'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Tabetatarticle->delete()) {
			$this->Session->setFlash(__('Tabetatarticle deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Tabetatarticle was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
