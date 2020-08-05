<?php
App::uses('AppController', 'Controller');
/**
 * Piecejointes Controller
 *
 * @property Piecejointe $Piecejointe
 */
class PiecejointesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Piecejointe->recursive = 0;
		$this->set('piecejointes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Piecejointe->exists($id)) {
			throw new NotFoundException(__('Invalid piecejointe'));
		}
		$options = array('conditions' => array('Piecejointe.' . $this->Piecejointe->primaryKey => $id));
		$this->set('piecejointe', $this->Piecejointe->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Piecejointe->create();
			if ($this->Piecejointe->save($this->request->data)) {
				$this->Session->setFlash(__('The piecejointe has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The piecejointe could not be saved. Please, try again.'));
			}
		}
		$namepiecejointes = $this->Piecejointe->Namepiecejointe->find('list');
		$importations = $this->Piecejointe->Importation->find('list');
		$this->set(compact('namepiecejointes', 'importations'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Piecejointe->exists($id)) {
			throw new NotFoundException(__('Invalid piecejointe'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Piecejointe->save($this->request->data)) {
				$this->Session->setFlash(__('The piecejointe has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The piecejointe could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Piecejointe.' . $this->Piecejointe->primaryKey => $id));
			$this->request->data = $this->Piecejointe->find('first', $options);
		}
		$namepiecejointes = $this->Piecejointe->Namepiecejointe->find('list');
		$importations = $this->Piecejointe->Importation->find('list');
		$this->set(compact('namepiecejointes', 'importations'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Piecejointe->id = $id;
		if (!$this->Piecejointe->exists()) {
			throw new NotFoundException(__('Invalid piecejointe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Piecejointe->delete()) {
			$this->Session->setFlash(__('Piecejointe deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Piecejointe was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
