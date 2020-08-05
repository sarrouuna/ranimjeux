<?php
App::uses('AppController', 'Controller');
/**
 * Lignecommandeclients Controller
 *
 * @property Lignecommandeclient $Lignecommandeclient
 */
class LignecommandeclientsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignecommandeclient->recursive = 0;
		$this->set('lignecommandeclients', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignecommandeclient->exists($id)) {
			throw new NotFoundException(__('Invalid lignecommandeclient'));
		}
		$options = array('conditions' => array('Lignecommandeclient.' . $this->Lignecommandeclient->primaryKey => $id));
		$this->set('lignecommandeclient', $this->Lignecommandeclient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignecommandeclient->create();
			if ($this->Lignecommandeclient->save($this->request->data)) {
				$this->Session->setFlash(__('The lignecommandeclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignecommandeclient could not be saved. Please, try again.'));
			}
		}
		$commandeclients = $this->Lignecommandeclient->Commandeclient->find('list');
		$articles = $this->Lignecommandeclient->Article->find('list');
		$this->set(compact('commandeclients', 'articles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignecommandeclient->exists($id)) {
			throw new NotFoundException(__('Invalid lignecommandeclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignecommandeclient->save($this->request->data)) {
				$this->Session->setFlash(__('The lignecommandeclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignecommandeclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignecommandeclient.' . $this->Lignecommandeclient->primaryKey => $id));
			$this->request->data = $this->Lignecommandeclient->find('first', $options);
		}
		$commandeclients = $this->Lignecommandeclient->Commandeclient->find('list');
		$articles = $this->Lignecommandeclient->Article->find('list');
		$this->set(compact('commandeclients', 'articles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignecommandeclient->id = $id;
		if (!$this->Lignecommandeclient->exists()) {
			throw new NotFoundException(__('Invalid lignecommandeclient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignecommandeclient->delete()) {
			$this->Session->setFlash(__('Lignecommandeclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignecommandeclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
