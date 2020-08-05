<?php
App::uses('AppController', 'Controller');
/**
 * Utilisateurmenus Controller
 *
 * @property Utilisateurmenu $Utilisateurmenu
 */
class UtilisateurmenusController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Utilisateurmenu->recursive = 0;
		$this->set('utilisateurmenus', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Utilisateurmenu->exists($id)) {
			throw new NotFoundException(__('Invalid utilisateurmenu'));
		}
		$options = array('conditions' => array('Utilisateurmenu.' . $this->Utilisateurmenu->primaryKey => $id));
		$this->set('utilisateurmenu', $this->Utilisateurmenu->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Utilisateurmenu->create();
			if ($this->Utilisateurmenu->save($this->request->data)) {
				$this->Session->setFlash(__('The utilisateurmenu has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The utilisateurmenu could not be saved. Please, try again.'));
			}
		}
		$utilisateurs = $this->Utilisateurmenu->Utilisateur->find('list');
		$menus = $this->Utilisateurmenu->Menu->find('list');
		$this->set(compact('utilisateurs', 'menus'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Utilisateurmenu->exists($id)) {
			throw new NotFoundException(__('Invalid utilisateurmenu'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Utilisateurmenu->save($this->request->data)) {
				$this->Session->setFlash(__('The utilisateurmenu has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The utilisateurmenu could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Utilisateurmenu.' . $this->Utilisateurmenu->primaryKey => $id));
			$this->request->data = $this->Utilisateurmenu->find('first', $options);
		}
		$utilisateurs = $this->Utilisateurmenu->Utilisateur->find('list');
		$menus = $this->Utilisateurmenu->Menu->find('list');
		$this->set(compact('utilisateurs', 'menus'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Utilisateurmenu->id = $id;
		if (!$this->Utilisateurmenu->exists()) {
			throw new NotFoundException(__('Invalid utilisateurmenu'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Utilisateurmenu->delete()) {
			$this->Session->setFlash(__('Utilisateurmenu deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Utilisateurmenu was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
