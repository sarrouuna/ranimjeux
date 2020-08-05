<?php
App::uses('AppController', 'Controller');
/**
 * Imputationfactureavoirs Controller
 *
 * @property Imputationfactureavoir $Imputationfactureavoir
 */
class ImputationfactureavoirsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Imputationfactureavoir->recursive = 0;
		$this->set('imputationfactureavoirs', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Imputationfactureavoir->exists($id)) {
			throw new NotFoundException(__('Invalid imputationfactureavoir'));
		}
		$options = array('conditions' => array('Imputationfactureavoir.' . $this->Imputationfactureavoir->primaryKey => $id));
		$this->set('imputationfactureavoir', $this->Imputationfactureavoir->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Imputationfactureavoir->create();
			if ($this->Imputationfactureavoir->save($this->request->data)) {
				$this->Session->setFlash(__('The imputationfactureavoir has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The imputationfactureavoir could not be saved. Please, try again.'));
			}
		}
		$factureavoirs = $this->Imputationfactureavoir->Factureavoir->find('list');
		$factureclients = $this->Imputationfactureavoir->Factureclient->find('list');
		$this->set(compact('factureavoirs', 'factureclients'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Imputationfactureavoir->exists($id)) {
			throw new NotFoundException(__('Invalid imputationfactureavoir'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Imputationfactureavoir->save($this->request->data)) {
				$this->Session->setFlash(__('The imputationfactureavoir has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The imputationfactureavoir could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Imputationfactureavoir.' . $this->Imputationfactureavoir->primaryKey => $id));
			$this->request->data = $this->Imputationfactureavoir->find('first', $options);
		}
		$factureavoirs = $this->Imputationfactureavoir->Factureavoir->find('list');
		$factureclients = $this->Imputationfactureavoir->Factureclient->find('list');
		$this->set(compact('factureavoirs', 'factureclients'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Imputationfactureavoir->id = $id;
		if (!$this->Imputationfactureavoir->exists()) {
			throw new NotFoundException(__('Invalid imputationfactureavoir'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Imputationfactureavoir->delete()) {
			$this->Session->setFlash(__('Imputationfactureavoir deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Imputationfactureavoir was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
