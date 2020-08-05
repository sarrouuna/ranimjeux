<?php
App::uses('AppController', 'Controller');
/**
 * Lignecommandes Controller
 *
 * @property Lignecommande $Lignecommande
 */
class LignecommandesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignecommande->recursive = 0;
		$this->set('lignecommandes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignecommande->exists($id)) {
			throw new NotFoundException(__('Invalid lignecommande'));
		}
		$options = array('conditions' => array('Lignecommande.' . $this->Lignecommande->primaryKey => $id));
		$this->set('lignecommande', $this->Lignecommande->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignecommande->create();
			if ($this->Lignecommande->save($this->request->data)) {
				$this->Session->setFlash(__('The lignecommande has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignecommande could not be saved. Please, try again.'));
			}
		}
		$commandes = $this->Lignecommande->Commande->find('list');
		$articles = $this->Lignecommande->Article->find('list');
		$this->set(compact('commandes', 'articles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignecommande->exists($id)) {
			throw new NotFoundException(__('Invalid lignecommande'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignecommande->save($this->request->data)) {
				$this->Session->setFlash(__('The lignecommande has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignecommande could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignecommande.' . $this->Lignecommande->primaryKey => $id));
			$this->request->data = $this->Lignecommande->find('first', $options);
		}
		$commandes = $this->Lignecommande->Commande->find('list');
		$articles = $this->Lignecommande->Article->find('list');
		$this->set(compact('commandes', 'articles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignecommande->id = $id;
		if (!$this->Lignecommande->exists()) {
			throw new NotFoundException(__('Invalid lignecommande'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignecommande->delete()) {
			$this->Session->setFlash(__('Lignecommande deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignecommande was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
