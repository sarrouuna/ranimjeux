<?php
App::uses('AppController', 'Controller');
/**
 * Typestockarticles Controller
 *
 * @property Typestockarticle $Typestockarticle
 */
class TypestockarticlesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Typestockarticle->recursive = 0;
		$this->set('typestockarticles', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Typestockarticle->exists($id)) {
			throw new NotFoundException(__('Invalid typestockarticle'));
		}
		$options = array('conditions' => array('Typestockarticle.' . $this->Typestockarticle->primaryKey => $id));
		$this->set('typestockarticle', $this->Typestockarticle->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Typestockarticle->create();
			if ($this->Typestockarticle->save($this->request->data)) {
				$this->Session->setFlash(__('The typestockarticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typestockarticle could not be saved. Please, try again.'));
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
		if (!$this->Typestockarticle->exists($id)) {
			throw new NotFoundException(__('Invalid typestockarticle'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Typestockarticle->save($this->request->data)) {
				$this->Session->setFlash(__('The typestockarticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The typestockarticle could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Typestockarticle.' . $this->Typestockarticle->primaryKey => $id));
			$this->request->data = $this->Typestockarticle->find('first', $options);
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
		$this->Typestockarticle->id = $id;
		if (!$this->Typestockarticle->exists()) {
			throw new NotFoundException(__('Invalid typestockarticle'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Typestockarticle->delete()) {
			$this->Session->setFlash(__('Typestockarticle deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Typestockarticle was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
