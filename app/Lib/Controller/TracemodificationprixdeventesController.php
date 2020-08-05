<?php
App::uses('AppController', 'Controller');
/**
 * Tracemodificationprixdeventes Controller
 *
 * @property Tracemodificationprixdevente $Tracemodificationprixdevente
 */
class TracemodificationprixdeventesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Tracemodificationprixdevente->recursive = 0;
		$this->set('tracemodificationprixdeventes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Tracemodificationprixdevente->exists($id)) {
			throw new NotFoundException(__('Invalid tracemodificationprixdevente'));
		}
		$options = array('conditions' => array('Tracemodificationprixdevente.' . $this->Tracemodificationprixdevente->primaryKey => $id));
		$this->set('tracemodificationprixdevente', $this->Tracemodificationprixdevente->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Tracemodificationprixdevente->create();
			if ($this->Tracemodificationprixdevente->save($this->request->data)) {
				$this->Session->setFlash(__('The tracemodificationprixdevente has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tracemodificationprixdevente could not be saved. Please, try again.'));
			}
		}
		$utilisateurs = $this->Tracemodificationprixdevente->Utilisateur->find('list');
		$this->set(compact('utilisateurs'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Tracemodificationprixdevente->exists($id)) {
			throw new NotFoundException(__('Invalid tracemodificationprixdevente'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Tracemodificationprixdevente->save($this->request->data)) {
				$this->Session->setFlash(__('The tracemodificationprixdevente has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tracemodificationprixdevente could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tracemodificationprixdevente.' . $this->Tracemodificationprixdevente->primaryKey => $id));
			$this->request->data = $this->Tracemodificationprixdevente->find('first', $options);
		}
		$utilisateurs = $this->Tracemodificationprixdevente->Utilisateur->find('list');
		$this->set(compact('utilisateurs'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Tracemodificationprixdevente->id = $id;
		if (!$this->Tracemodificationprixdevente->exists()) {
			throw new NotFoundException(__('Invalid tracemodificationprixdevente'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Tracemodificationprixdevente->delete()) {
			$this->Session->setFlash(__('Tracemodificationprixdevente deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Tracemodificationprixdevente was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
