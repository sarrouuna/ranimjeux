<?php
App::uses('AppController', 'Controller');
/**
 * Lignebonsortiestocks Controller
 *
 * @property Lignebonsortiestock $Lignebonsortiestock
 */
class LignebonsortiestocksController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignebonsortiestock->recursive = 0;
		$this->set('lignebonsortiestocks', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignebonsortiestock->exists($id)) {
			throw new NotFoundException(__('Invalid lignebonsortiestock'));
		}
		$options = array('conditions' => array('Lignebonsortiestock.' . $this->Lignebonsortiestock->primaryKey => $id));
		$this->set('lignebonsortiestock', $this->Lignebonsortiestock->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignebonsortiestock->create();
			if ($this->Lignebonsortiestock->save($this->request->data)) {
				$this->Session->setFlash(__('The lignebonsortiestock has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignebonsortiestock could not be saved. Please, try again.'));
			}
		}
		$depots = $this->Lignebonsortiestock->Depot->find('list');
		$articles = $this->Lignebonsortiestock->Article->find('list');
		$bonsortiestocks = $this->Lignebonsortiestock->Bonsortiestock->find('list');
		$this->set(compact('depots', 'articles', 'bonsortiestocks'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignebonsortiestock->exists($id)) {
			throw new NotFoundException(__('Invalid lignebonsortiestock'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignebonsortiestock->save($this->request->data)) {
				$this->Session->setFlash(__('The lignebonsortiestock has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignebonsortiestock could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignebonsortiestock.' . $this->Lignebonsortiestock->primaryKey => $id));
			$this->request->data = $this->Lignebonsortiestock->find('first', $options);
		}
		$depots = $this->Lignebonsortiestock->Depot->find('list');
		$articles = $this->Lignebonsortiestock->Article->find('list');
		$bonsortiestocks = $this->Lignebonsortiestock->Bonsortiestock->find('list');
		$this->set(compact('depots', 'articles', 'bonsortiestocks'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignebonsortiestock->id = $id;
		if (!$this->Lignebonsortiestock->exists()) {
			throw new NotFoundException(__('Invalid lignebonsortiestock'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignebonsortiestock->delete()) {
			$this->Session->setFlash(__('Lignebonsortiestock deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignebonsortiestock was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
