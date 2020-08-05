<?php
App::uses('AppController', 'Controller');
/**
 * Liens Controller
 *
 * @property Lien $Lien
 */
class LiensController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lien->recursive = 0;
		$this->set('liens', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lien->exists($id)) {
			throw new NotFoundException(__('Invalid lien'));
		}
		$options = array('conditions' => array('Lien.' . $this->Lien->primaryKey => $id));
		$this->set('lien', $this->Lien->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lien->create();
			if ($this->Lien->save($this->request->data)) {
				$this->Session->setFlash(__('The lien has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lien could not be saved. Please, try again.'));
			}
		}
		$utilisateurmenus = $this->Lien->Utilisateurmenu->find('list');
		$this->set(compact('utilisateurmenus'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lien->exists($id)) {
			throw new NotFoundException(__('Invalid lien'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lien->save($this->request->data)) {
				$this->Session->setFlash(__('The lien has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lien could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lien.' . $this->Lien->primaryKey => $id));
			$this->request->data = $this->Lien->find('first', $options);
		}
		$utilisateurmenus = $this->Lien->Utilisateurmenu->find('list');
		$this->set(compact('utilisateurmenus'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lien->id = $id;
		if (!$this->Lien->exists()) {
			throw new NotFoundException(__('Invalid lien'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lien->delete()) {
			$this->Session->setFlash(__('Lien deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lien was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
