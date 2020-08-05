<?php
App::uses('AppController', 'Controller');
/**
 * Lignesortis Controller
 *
 * @property Lignesorti $Lignesorti
 */
class LignesortisController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignesorti->recursive = 0;
		$this->set('lignesortis', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignesorti->exists($id)) {
			throw new NotFoundException(__('Invalid lignesorti'));
		}
		$options = array('conditions' => array('Lignesorti.' . $this->Lignesorti->primaryKey => $id));
		$this->set('lignesorti', $this->Lignesorti->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignesorti->create();
			if ($this->Lignesorti->save($this->request->data)) {
				$this->Session->setFlash(__('The lignesorti has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignesorti could not be saved. Please, try again.'));
			}
		}
		$bonsortis = $this->Lignesorti->Bonsorti->find('list');
		$articles = $this->Lignesorti->Article->find('list');
		$depots = $this->Lignesorti->Depot->find('list');
		$lignelivraisons = $this->Lignesorti->Lignelivraison->find('list');
		$lignefactures = $this->Lignesorti->Lignefacture->find('list');
		$this->set(compact('bonsortis', 'articles', 'depots', 'lignelivraisons', 'lignefactures'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignesorti->exists($id)) {
			throw new NotFoundException(__('Invalid lignesorti'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignesorti->save($this->request->data)) {
				$this->Session->setFlash(__('The lignesorti has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignesorti could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignesorti.' . $this->Lignesorti->primaryKey => $id));
			$this->request->data = $this->Lignesorti->find('first', $options);
		}
		$bonsortis = $this->Lignesorti->Bonsorti->find('list');
		$articles = $this->Lignesorti->Article->find('list');
		$depots = $this->Lignesorti->Depot->find('list');
		$lignelivraisons = $this->Lignesorti->Lignelivraison->find('list');
		$lignefactures = $this->Lignesorti->Lignefacture->find('list');
		$this->set(compact('bonsortis', 'articles', 'depots', 'lignelivraisons', 'lignefactures'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignesorti->id = $id;
		if (!$this->Lignesorti->exists()) {
			throw new NotFoundException(__('Invalid lignesorti'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignesorti->delete()) {
			$this->Session->setFlash(__('Lignesorti deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignesorti was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
