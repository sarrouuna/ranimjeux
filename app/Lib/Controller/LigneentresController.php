<?php
App::uses('AppController', 'Controller');
/**
 * Ligneentres Controller
 *
 * @property Ligneentre $Ligneentre
 */
class LigneentresController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Ligneentre->recursive = 0;
		$this->set('ligneentres', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Ligneentre->exists($id)) {
			throw new NotFoundException(__('Invalid ligneentre'));
		}
		$options = array('conditions' => array('Ligneentre.' . $this->Ligneentre->primaryKey => $id));
		$this->set('ligneentre', $this->Ligneentre->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Ligneentre->create();
			if ($this->Ligneentre->save($this->request->data)) {
				$this->Session->setFlash(__('The ligneentre has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ligneentre could not be saved. Please, try again.'));
			}
		}
		$bonentres = $this->Ligneentre->Bonentre->find('list');
		$articles = $this->Ligneentre->Article->find('list');
		$depots = $this->Ligneentre->Depot->find('list');
		$stockdepots = $this->Ligneentre->Stockdepot->find('list');
		$lignereceptions = $this->Ligneentre->Lignereception->find('list');
		$lignefactures = $this->Ligneentre->Lignefacture->find('list');
		$this->set(compact('bonentres', 'articles', 'depots', 'stockdepots', 'lignereceptions', 'lignefactures'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Ligneentre->exists($id)) {
			throw new NotFoundException(__('Invalid ligneentre'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ligneentre->save($this->request->data)) {
				$this->Session->setFlash(__('The ligneentre has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ligneentre could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Ligneentre.' . $this->Ligneentre->primaryKey => $id));
			$this->request->data = $this->Ligneentre->find('first', $options);
		}
		$bonentres = $this->Ligneentre->Bonentre->find('list');
		$articles = $this->Ligneentre->Article->find('list');
		$depots = $this->Ligneentre->Depot->find('list');
		$stockdepots = $this->Ligneentre->Stockdepot->find('list');
		$lignereceptions = $this->Ligneentre->Lignereception->find('list');
		$lignefactures = $this->Ligneentre->Lignefacture->find('list');
		$this->set(compact('bonentres', 'articles', 'depots', 'stockdepots', 'lignereceptions', 'lignefactures'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Ligneentre->id = $id;
		if (!$this->Ligneentre->exists()) {
			throw new NotFoundException(__('Invalid ligneentre'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Ligneentre->delete()) {
			$this->Session->setFlash(__('Ligneentre deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ligneentre was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
