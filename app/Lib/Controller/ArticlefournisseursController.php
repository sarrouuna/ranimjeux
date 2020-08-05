<?php
App::uses('AppController', 'Controller');
/**
 * Articlefournisseurs Controller
 *
 * @property Articlefournisseur $Articlefournisseur
 */
class ArticlefournisseursController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Articlefournisseur->recursive = 0;
		$this->set('articlefournisseurs', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Articlefournisseur->exists($id)) {
			throw new NotFoundException(__('Invalid articlefournisseur'));
		}
		$options = array('conditions' => array('Articlefournisseur.' . $this->Articlefournisseur->primaryKey => $id));
		$this->set('articlefournisseur', $this->Articlefournisseur->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Articlefournisseur->create();
			if ($this->Articlefournisseur->save($this->request->data)) {
				$this->Session->setFlash(__('The articlefournisseur has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The articlefournisseur could not be saved. Please, try again.'));
			}
		}
		$articles = $this->Articlefournisseur->Article->find('list');
		$fournisseurs = $this->Articlefournisseur->Fournisseur->find('list');
		$this->set(compact('articles', 'fournisseurs'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Articlefournisseur->exists($id)) {
			throw new NotFoundException(__('Invalid articlefournisseur'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Articlefournisseur->save($this->request->data)) {
				$this->Session->setFlash(__('The articlefournisseur has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The articlefournisseur could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Articlefournisseur.' . $this->Articlefournisseur->primaryKey => $id));
			$this->request->data = $this->Articlefournisseur->find('first', $options);
		}
		$articles = $this->Articlefournisseur->Article->find('list');
		$fournisseurs = $this->Articlefournisseur->Fournisseur->find('list');
		$this->set(compact('articles', 'fournisseurs'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Articlefournisseur->id = $id;
		if (!$this->Articlefournisseur->exists()) {
			throw new NotFoundException(__('Invalid articlefournisseur'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Articlefournisseur->delete()) {
			$this->Session->setFlash(__('Articlefournisseur deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Articlefournisseur was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
