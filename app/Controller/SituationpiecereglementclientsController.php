<?php
App::uses('AppController', 'Controller');
/**
 * Situationpiecereglementclients Controller
 *
 * @property Situationpiecereglementclient $Situationpiecereglementclient
 */
class SituationpiecereglementclientsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Situationpiecereglementclient->recursive = 0;
		$this->set('situationpiecereglementclients', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Situationpiecereglementclient->exists($id)) {
			throw new NotFoundException(__('Invalid situationpiecereglementclient'));
		}
		$options = array('conditions' => array('Situationpiecereglementclient.' . $this->Situationpiecereglementclient->primaryKey => $id));
		$this->set('situationpiecereglementclient', $this->Situationpiecereglementclient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Situationpiecereglementclient->create();
			if ($this->Situationpiecereglementclient->save($this->request->data)) {
				$this->Session->setFlash(__('The situationpiecereglementclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The situationpiecereglementclient could not be saved. Please, try again.'));
			}
		}
		$piecereglements = $this->Situationpiecereglementclient->Piecereglement->find('list');
		$utilisateurs = $this->Situationpiecereglementclient->Utilisateur->find('list');
		$this->set(compact('piecereglements', 'utilisateurs'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Situationpiecereglementclient->exists($id)) {
			throw new NotFoundException(__('Invalid situationpiecereglementclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Situationpiecereglementclient->save($this->request->data)) {
				$this->Session->setFlash(__('The situationpiecereglementclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The situationpiecereglementclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Situationpiecereglementclient.' . $this->Situationpiecereglementclient->primaryKey => $id));
			$this->request->data = $this->Situationpiecereglementclient->find('first', $options);
		}
		$piecereglements = $this->Situationpiecereglementclient->Piecereglement->find('list');
		$utilisateurs = $this->Situationpiecereglementclient->Utilisateur->find('list');
		$this->set(compact('piecereglements', 'utilisateurs'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Situationpiecereglementclient->id = $id;
		if (!$this->Situationpiecereglementclient->exists()) {
			throw new NotFoundException(__('Invalid situationpiecereglementclient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Situationpiecereglementclient->delete()) {
			$this->Session->setFlash(__('Situationpiecereglementclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Situationpiecereglementclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
