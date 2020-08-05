<?php
App::uses('AppController', 'Controller');
/**
 * Ticketcaisselignes Controller
 *
 * @property Ticketcaisseligne $Ticketcaisseligne
 */
class TicketcaisselignesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Ticketcaisseligne->recursive = 0;
		$this->set('ticketcaisselignes', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Ticketcaisseligne->id = $id;
		if (!$this->Ticketcaisseligne->exists()) {
			throw new NotFoundException(__('Invalid ticketcaisseligne'));
		}
		$this->set('ticketcaisseligne', $this->Ticketcaisseligne->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Ticketcaisseligne->create();
			if ($this->Ticketcaisseligne->save($this->request->data)) {
				$this->Session->setFlash(__('The ticketcaisseligne has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticketcaisseligne could not be saved. Please, try again.'));
			}
		}
		$ticketcaisses = $this->Ticketcaisseligne->Ticketcaisse->find('list');
		$articles = $this->Ticketcaisseligne->Article->find('list');
		$this->set(compact('ticketcaisses', 'articles'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Ticketcaisseligne->id = $id;
		if (!$this->Ticketcaisseligne->exists()) {
			throw new NotFoundException(__('Invalid ticketcaisseligne'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ticketcaisseligne->save($this->request->data)) {
				$this->Session->setFlash(__('The ticketcaisseligne has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ticketcaisseligne could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Ticketcaisseligne->read(null, $id);
		}
		$ticketcaisses = $this->Ticketcaisseligne->Ticketcaisse->find('list');
		$articles = $this->Ticketcaisseligne->Article->find('list');
		$this->set(compact('ticketcaisses', 'articles'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Ticketcaisseligne->id = $id;
		if (!$this->Ticketcaisseligne->exists()) {
			throw new NotFoundException(__('Invalid ticketcaisseligne'));
		}
		if ($this->Ticketcaisseligne->delete()) {
			$this->Session->setFlash(__('Ticketcaisseligne deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ticketcaisseligne was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
