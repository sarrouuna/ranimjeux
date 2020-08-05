<?php
App::uses('AppController', 'Controller');
/**
 * Lignefactureclients Controller
 *
 * @property Lignefactureclient $Lignefactureclient
 */
class LignefactureclientsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignefactureclient->recursive = 0;
		$this->set('lignefactureclients', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignefactureclient->exists($id)) {
			throw new NotFoundException(__('Invalid lignefactureclient'));
		}
		$options = array('conditions' => array('Lignefactureclient.' . $this->Lignefactureclient->primaryKey => $id));
		$this->set('lignefactureclient', $this->Lignefactureclient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignefactureclient->create();
			if ($this->Lignefactureclient->save($this->request->data)) {
				$this->Session->setFlash(__('The lignefactureclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignefactureclient could not be saved. Please, try again.'));
			}
		}
		$factureclients = $this->Lignefactureclient->Factureclient->find('list');
		$articles = $this->Lignefactureclient->Article->find('list');
		$this->set(compact('factureclients', 'articles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignefactureclient->exists($id)) {
			throw new NotFoundException(__('Invalid lignefactureclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignefactureclient->save($this->request->data)) {
				$this->Session->setFlash(__('The lignefactureclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignefactureclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignefactureclient.' . $this->Lignefactureclient->primaryKey => $id));
			$this->request->data = $this->Lignefactureclient->find('first', $options);
		}
		$factureclients = $this->Lignefactureclient->Factureclient->find('list');
		$articles = $this->Lignefactureclient->Article->find('list');
		$this->set(compact('factureclients', 'articles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignefactureclient->id = $id;
		if (!$this->Lignefactureclient->exists()) {
			throw new NotFoundException(__('Invalid lignefactureclient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignefactureclient->delete()) {
			$this->Session->setFlash(__('Lignefactureclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignefactureclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
