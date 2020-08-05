<?php
App::uses('AppController', 'Controller');
/**
 * Lignecopiestocks Controller
 *
 * @property Lignecopiestock $Lignecopiestock
 */
class LignecopiestocksController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignecopiestock->recursive = 0;
		$this->set('lignecopiestocks', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignecopiestock->exists($id)) {
			throw new NotFoundException(__('Invalid lignecopiestock'));
		}
		$options = array('conditions' => array('Lignecopiestock.' . $this->Lignecopiestock->primaryKey => $id));
		$this->set('lignecopiestock', $this->Lignecopiestock->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignecopiestock->create();
			if ($this->Lignecopiestock->save($this->request->data)) {
				$this->Session->setFlash(__('The lignecopiestock has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignecopiestock could not be saved. Please, try again.'));
			}
		}
		$copiestockdepots = $this->Lignecopiestock->Copiestockdepot->find('list');
		$articles = $this->Lignecopiestock->Article->find('list');
		$depots = $this->Lignecopiestock->Depot->find('list');
		$this->set(compact('copiestockdepots', 'articles', 'depots'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignecopiestock->exists($id)) {
			throw new NotFoundException(__('Invalid lignecopiestock'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignecopiestock->save($this->request->data)) {
				$this->Session->setFlash(__('The lignecopiestock has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignecopiestock could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignecopiestock.' . $this->Lignecopiestock->primaryKey => $id));
			$this->request->data = $this->Lignecopiestock->find('first', $options);
		}
		$copiestockdepots = $this->Lignecopiestock->Copiestockdepot->find('list');
		$articles = $this->Lignecopiestock->Article->find('list');
		$depots = $this->Lignecopiestock->Depot->find('list');
		$this->set(compact('copiestockdepots', 'articles', 'depots'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignecopiestock->id = $id;
		if (!$this->Lignecopiestock->exists()) {
			throw new NotFoundException(__('Invalid lignecopiestock'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignecopiestock->delete()) {
			$this->Session->setFlash(__('Lignecopiestock deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignecopiestock was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
