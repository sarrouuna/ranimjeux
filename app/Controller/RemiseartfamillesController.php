<?php
App::uses('AppController', 'Controller');
/**
 * Remiseartfamilles Controller
 *
 * @property Remiseartfamille $Remiseartfamille
 */
class RemiseartfamillesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Remiseartfamille->recursive = 0;
		$this->set('remiseartfamilles', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Remiseartfamille->exists($id)) {
			throw new NotFoundException(__('Invalid remiseartfamille'));
		}
		$options = array('conditions' => array('Remiseartfamille.' . $this->Remiseartfamille->primaryKey => $id));
		$this->set('remiseartfamille', $this->Remiseartfamille->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Remiseartfamille->create();
			if ($this->Remiseartfamille->save($this->request->data)) {
				$this->Session->setFlash(__('The remiseartfamille has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The remiseartfamille could not be saved. Please, try again.'));
			}
		}
		$articles = $this->Remiseartfamille->Article->find('list');
		$familles = $this->Remiseartfamille->Famille->find('list');
		$this->set(compact('articles', 'familles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Remiseartfamille->exists($id)) {
			throw new NotFoundException(__('Invalid remiseartfamille'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Remiseartfamille->save($this->request->data)) {
				$this->Session->setFlash(__('The remiseartfamille has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The remiseartfamille could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Remiseartfamille.' . $this->Remiseartfamille->primaryKey => $id));
			$this->request->data = $this->Remiseartfamille->find('first', $options);
		}
		$articles = $this->Remiseartfamille->Article->find('list');
		$familles = $this->Remiseartfamille->Famille->find('list');
		$this->set(compact('articles', 'familles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Remiseartfamille->id = $id;
		if (!$this->Remiseartfamille->exists()) {
			throw new NotFoundException(__('Invalid remiseartfamille'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Remiseartfamille->delete()) {
			$this->Session->setFlash(__('Remiseartfamille deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Remiseartfamille was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
