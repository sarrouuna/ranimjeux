<?php
App::uses('AppController', 'Controller');
/**
 * Situationpiecereglements Controller
 *
 * @property Situationpiecereglement $Situationpiecereglement
 */
class SituationpiecereglementsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Situationpiecereglement->recursive = 0;
		$this->set('situationpiecereglements', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Situationpiecereglement->exists($id)) {
			throw new NotFoundException(__('Invalid situationpiecereglement'));
		}
		$options = array('conditions' => array('Situationpiecereglement.' . $this->Situationpiecereglement->primaryKey => $id));
		$this->set('situationpiecereglement', $this->Situationpiecereglement->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Situationpiecereglement->create();
			if ($this->Situationpiecereglement->save($this->request->data)) {
				$this->Session->setFlash(__('The situationpiecereglement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The situationpiecereglement could not be saved. Please, try again.'));
			}
		}
		$etatpiecereglements = $this->Situationpiecereglement->Etatpiecereglement->find('list');
		$piecereglements = $this->Situationpiecereglement->Piecereglement->find('list');
		$this->set(compact('etatpiecereglements', 'piecereglements'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Situationpiecereglement->exists($id)) {
			throw new NotFoundException(__('Invalid situationpiecereglement'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Situationpiecereglement->save($this->request->data)) {
				$this->Session->setFlash(__('The situationpiecereglement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The situationpiecereglement could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Situationpiecereglement.' . $this->Situationpiecereglement->primaryKey => $id));
			$this->request->data = $this->Situationpiecereglement->find('first', $options);
		}
		$etatpiecereglements = $this->Situationpiecereglement->Etatpiecereglement->find('list');
		$piecereglements = $this->Situationpiecereglement->Piecereglement->find('list');
		$this->set(compact('etatpiecereglements', 'piecereglements'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Situationpiecereglement->id = $id;
		if (!$this->Situationpiecereglement->exists()) {
			throw new NotFoundException(__('Invalid situationpiecereglement'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Situationpiecereglement->delete()) {
			$this->Session->setFlash(__('Situationpiecereglement deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Situationpiecereglement was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
