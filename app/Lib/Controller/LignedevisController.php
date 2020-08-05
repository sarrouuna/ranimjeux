<?php
App::uses('AppController', 'Controller');
/**
 * Lignedevis Controller
 *
 * @property Lignedevi $Lignedevi
 */
class LignedevisController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignedevi->recursive = 0;
		$this->set('lignedevis', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignedevi->exists($id)) {
			throw new NotFoundException(__('Invalid lignedevi'));
		}
		$options = array('conditions' => array('Lignedevi.' . $this->Lignedevi->primaryKey => $id));
		$this->set('lignedevi', $this->Lignedevi->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignedevi->create();
			if ($this->Lignedevi->save($this->request->data)) {
				$this->Session->setFlash(__('The lignedevi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignedevi could not be saved. Please, try again.'));
			}
		}
		$devis = $this->Lignedevi->Devi->find('list');
		$articles = $this->Lignedevi->Article->find('list');
		$this->set(compact('devis', 'articles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignedevi->exists($id)) {
			throw new NotFoundException(__('Invalid lignedevi'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignedevi->save($this->request->data)) {
				$this->Session->setFlash(__('The lignedevi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignedevi could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignedevi.' . $this->Lignedevi->primaryKey => $id));
			$this->request->data = $this->Lignedevi->find('first', $options);
		}
		$devis = $this->Lignedevi->Devi->find('list');
		$articles = $this->Lignedevi->Article->find('list');
		$this->set(compact('devis', 'articles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignedevi->id = $id;
		if (!$this->Lignedevi->exists()) {
			throw new NotFoundException(__('Invalid lignedevi'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignedevi->delete()) {
			$this->Session->setFlash(__('Lignedevi deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignedevi was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
