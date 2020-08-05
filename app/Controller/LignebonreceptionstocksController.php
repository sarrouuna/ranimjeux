<?php
App::uses('AppController', 'Controller');
/**
 * Lignebonreceptionstocks Controller
 *
 * @property Lignebonreceptionstock $Lignebonreceptionstock
 */
class LignebonreceptionstocksController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignebonreceptionstock->recursive = 0;
		$this->set('lignebonreceptionstocks', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignebonreceptionstock->exists($id)) {
			throw new NotFoundException(__('Invalid lignebonreceptionstock'));
		}
		$options = array('conditions' => array('Lignebonreceptionstock.' . $this->Lignebonreceptionstock->primaryKey => $id));
		$this->set('lignebonreceptionstock', $this->Lignebonreceptionstock->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignebonreceptionstock->create();
			if ($this->Lignebonreceptionstock->save($this->request->data)) {
				$this->Session->setFlash(__('The lignebonreceptionstock has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignebonreceptionstock could not be saved. Please, try again.'));
			}
		}
		$depots = $this->Lignebonreceptionstock->Depot->find('list');
		$articles = $this->Lignebonreceptionstock->Article->find('list');
		$bonreceptionstocks = $this->Lignebonreceptionstock->Bonreceptionstock->find('list');
		$this->set(compact('depots', 'articles', 'bonreceptionstocks'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignebonreceptionstock->exists($id)) {
			throw new NotFoundException(__('Invalid lignebonreceptionstock'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignebonreceptionstock->save($this->request->data)) {
				$this->Session->setFlash(__('The lignebonreceptionstock has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignebonreceptionstock could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignebonreceptionstock.' . $this->Lignebonreceptionstock->primaryKey => $id));
			$this->request->data = $this->Lignebonreceptionstock->find('first', $options);
		}
		$depots = $this->Lignebonreceptionstock->Depot->find('list');
		$articles = $this->Lignebonreceptionstock->Article->find('list');
		$bonreceptionstocks = $this->Lignebonreceptionstock->Bonreceptionstock->find('list');
		$this->set(compact('depots', 'articles', 'bonreceptionstocks'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignebonreceptionstock->id = $id;
		if (!$this->Lignebonreceptionstock->exists()) {
			throw new NotFoundException(__('Invalid lignebonreceptionstock'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignebonreceptionstock->delete()) {
			$this->Session->setFlash(__('Lignebonreceptionstock deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignebonreceptionstock was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
