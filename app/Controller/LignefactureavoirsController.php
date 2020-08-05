<?php
App::uses('AppController', 'Controller');
/**
 * Lignefactureavoirs Controller
 *
 * @property Lignefactureavoir $Lignefactureavoir
 */
class LignefactureavoirsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignefactureavoir->recursive = 0;
		$this->set('lignefactureavoirs', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignefactureavoir->exists($id)) {
			throw new NotFoundException(__('Invalid lignefactureavoir'));
		}
		$options = array('conditions' => array('Lignefactureavoir.' . $this->Lignefactureavoir->primaryKey => $id));
		$this->set('lignefactureavoir', $this->Lignefactureavoir->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignefactureavoir->create();
			if ($this->Lignefactureavoir->save($this->request->data)) {
				$this->Session->setFlash(__('The lignefactureavoir has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignefactureavoir could not be saved. Please, try again.'));
			}
		}
		$factureavoirs = $this->Lignefactureavoir->Factureavoir->find('list');
		$depots = $this->Lignefactureavoir->Depot->find('list');
		$articles = $this->Lignefactureavoir->Article->find('list');
		$this->set(compact('factureavoirs', 'depots', 'articles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignefactureavoir->exists($id)) {
			throw new NotFoundException(__('Invalid lignefactureavoir'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignefactureavoir->save($this->request->data)) {
				$this->Session->setFlash(__('The lignefactureavoir has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignefactureavoir could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignefactureavoir.' . $this->Lignefactureavoir->primaryKey => $id));
			$this->request->data = $this->Lignefactureavoir->find('first', $options);
		}
		$factureavoirs = $this->Lignefactureavoir->Factureavoir->find('list');
		$depots = $this->Lignefactureavoir->Depot->find('list');
		$articles = $this->Lignefactureavoir->Article->find('list');
		$this->set(compact('factureavoirs', 'depots', 'articles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignefactureavoir->id = $id;
		if (!$this->Lignefactureavoir->exists()) {
			throw new NotFoundException(__('Invalid lignefactureavoir'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignefactureavoir->delete()) {
			$this->Session->setFlash(__('Lignefactureavoir deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignefactureavoir was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
