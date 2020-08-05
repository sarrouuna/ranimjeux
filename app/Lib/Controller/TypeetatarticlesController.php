<?php
App::uses('AppController', 'Controller');
/**
 * Typeetatarticles Controller
 *
 * @property Typeetatarticle $Typeetatarticle
 */
class TypeetatarticlesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Typeetatarticle->recursive = 0;
		$this->set('typeetatarticles', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Typeetatarticle->exists($id)) {
			throw new NotFoundException(__('Invalid typeetatarticle'));
		}
		$options = array('conditions' => array('Typeetatarticle.' . $this->Typeetatarticle->primaryKey => $id));
		$this->set('typeetatarticle', $this->Typeetatarticle->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Typeetatarticle->create();
			if ($this->Typeetatarticle->save($this->request->data)) {
				$this->Session->setFlash(__('The typeetatarticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typeetatarticle could not be saved. Please, try again.'));
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
		if (!$this->Typeetatarticle->exists($id)) {
			throw new NotFoundException(__('Invalid typeetatarticle'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Typeetatarticle->save($this->request->data)) {
				$this->Session->setFlash(__('The typeetatarticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typeetatarticle could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Typeetatarticle.' . $this->Typeetatarticle->primaryKey => $id));
			$this->request->data = $this->Typeetatarticle->find('first', $options);
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
		$this->Typeetatarticle->id = $id;
		if (!$this->Typeetatarticle->exists()) {
			throw new NotFoundException(__('Invalid typeetatarticle'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Typeetatarticle->delete()) {
			$this->Session->setFlash(__('Typeetatarticle deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Typeetatarticle was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
