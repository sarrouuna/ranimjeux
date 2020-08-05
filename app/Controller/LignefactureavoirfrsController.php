<?php
App::uses('AppController', 'Controller');
/**
 * Lignefactureavoirfrs Controller
 *
 * @property Lignefactureavoirfr $Lignefactureavoirfr
 */
class LignefactureavoirfrsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignefactureavoirfr->recursive = 0;
		$this->set('lignefactureavoirfrs', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignefactureavoirfr->exists($id)) {
			throw new NotFoundException(__('Invalid lignefactureavoirfr'));
		}
		$options = array('conditions' => array('Lignefactureavoirfr.' . $this->Lignefactureavoirfr->primaryKey => $id));
		$this->set('lignefactureavoirfr', $this->Lignefactureavoirfr->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignefactureavoirfr->create();
			if ($this->Lignefactureavoirfr->save($this->request->data)) {
				$this->Session->setFlash(__('The lignefactureavoirfr has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignefactureavoirfr could not be saved. Please, try again.'));
			}
		}
		$factureavoirfrs = $this->Lignefactureavoirfr->Factureavoirfr->find('list');
		$depots = $this->Lignefactureavoirfr->Depot->find('list');
		$articles = $this->Lignefactureavoirfr->Article->find('list');
		$this->set(compact('factureavoirfrs', 'depots', 'articles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignefactureavoirfr->exists($id)) {
			throw new NotFoundException(__('Invalid lignefactureavoirfr'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignefactureavoirfr->save($this->request->data)) {
				$this->Session->setFlash(__('The lignefactureavoirfr has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignefactureavoirfr could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignefactureavoirfr.' . $this->Lignefactureavoirfr->primaryKey => $id));
			$this->request->data = $this->Lignefactureavoirfr->find('first', $options);
		}
		$factureavoirfrs = $this->Lignefactureavoirfr->Factureavoirfr->find('list');
		$depots = $this->Lignefactureavoirfr->Depot->find('list');
		$articles = $this->Lignefactureavoirfr->Article->find('list');
		$this->set(compact('factureavoirfrs', 'depots', 'articles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignefactureavoirfr->id = $id;
		if (!$this->Lignefactureavoirfr->exists()) {
			throw new NotFoundException(__('Invalid lignefactureavoirfr'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignefactureavoirfr->delete()) {
			$this->Session->setFlash(__('Lignefactureavoirfr deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignefactureavoirfr was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
