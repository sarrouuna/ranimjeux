<?php
App::uses('AppController', 'Controller');
/**
 * Lignereglementclients Controller
 *
 * @property Lignereglementclient $Lignereglementclient
 */
class LignereglementclientsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignereglementclient->recursive = 0;
		$this->set('lignereglementclients', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignereglementclient->exists($id)) {
			throw new NotFoundException(__('Invalid lignereglementclient'));
		}
		$options = array('conditions' => array('Lignereglementclient.' . $this->Lignereglementclient->primaryKey => $id));
		$this->set('lignereglementclient', $this->Lignereglementclient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignereglementclient->create();
			if ($this->Lignereglementclient->save($this->request->data)) {
				$this->Session->setFlash(__('The lignereglementclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignereglementclient could not be saved. Please, try again.'));
			}
		}
		$reglementclients = $this->Lignereglementclient->Reglementclient->find('list');
		$factureclients = $this->Lignereglementclient->Factureclient->find('list');
		$this->set(compact('reglementclients', 'factureclients'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignereglementclient->exists($id)) {
			throw new NotFoundException(__('Invalid lignereglementclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignereglementclient->save($this->request->data)) {
				$this->Session->setFlash(__('The lignereglementclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignereglementclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignereglementclient.' . $this->Lignereglementclient->primaryKey => $id));
			$this->request->data = $this->Lignereglementclient->find('first', $options);
		}
		$reglementclients = $this->Lignereglementclient->Reglementclient->find('list');
		$factureclients = $this->Lignereglementclient->Factureclient->find('list');
		$this->set(compact('reglementclients', 'factureclients'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignereglementclient->id = $id;
		if (!$this->Lignereglementclient->exists()) {
			throw new NotFoundException(__('Invalid lignereglementclient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignereglementclient->delete()) {
			$this->Session->setFlash(__('Lignereglementclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignereglementclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
