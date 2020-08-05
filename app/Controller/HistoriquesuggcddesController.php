<?php
App::uses('AppController', 'Controller');
/**
 * Historiquesuggcddes Controller
 *
 * @property Historiquesuggcdde $Historiquesuggcdde
 */
class HistoriquesuggcddesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Historiquesuggcdde->recursive = 0;
		$this->set('historiquesuggcddes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Historiquesuggcdde->exists($id)) {
			throw new NotFoundException(__('Invalid historiquesuggcdde'));
		}
		$options = array('conditions' => array('Historiquesuggcdde.' . $this->Historiquesuggcdde->primaryKey => $id));
		$this->set('historiquesuggcdde', $this->Historiquesuggcdde->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Historiquesuggcdde->create();
			if ($this->Historiquesuggcdde->save($this->request->data)) {
				$this->Session->setFlash(__('The historiquesuggcdde has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The historiquesuggcdde could not be saved. Please, try again.'));
			}
		}
		$utilisateurs = $this->Historiquesuggcdde->Utilisateur->find('list');
		$lignedeviprospects = $this->Historiquesuggcdde->Lignedeviprospect->find('list');
		$deviprospects = $this->Historiquesuggcdde->Deviprospect->find('list');
		$this->set(compact('utilisateurs', 'lignedeviprospects', 'deviprospects'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Historiquesuggcdde->exists($id)) {
			throw new NotFoundException(__('Invalid historiquesuggcdde'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Historiquesuggcdde->save($this->request->data)) {
				$this->Session->setFlash(__('The historiquesuggcdde has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The historiquesuggcdde could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Historiquesuggcdde.' . $this->Historiquesuggcdde->primaryKey => $id));
			$this->request->data = $this->Historiquesuggcdde->find('first', $options);
		}
		$utilisateurs = $this->Historiquesuggcdde->Utilisateur->find('list');
		$lignedeviprospects = $this->Historiquesuggcdde->Lignedeviprospect->find('list');
		$deviprospects = $this->Historiquesuggcdde->Deviprospect->find('list');
		$this->set(compact('utilisateurs', 'lignedeviprospects', 'deviprospects'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Historiquesuggcdde->id = $id;
		if (!$this->Historiquesuggcdde->exists()) {
			throw new NotFoundException(__('Invalid historiquesuggcdde'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Historiquesuggcdde->delete()) {
			$this->Session->setFlash(__('Historiquesuggcdde deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Historiquesuggcdde was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
