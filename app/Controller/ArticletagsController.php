<?php
App::uses('AppController', 'Controller');
/**
 * Articletags Controller
 *
 * @property Articletag $Articletag
 */
class ArticletagsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Articletag->recursive = 0;
		$this->set('articletags', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Articletag->exists($id)) {
			throw new NotFoundException(__('Invalid articletag'));
		}
		$options = array('conditions' => array('Articletag.' . $this->Articletag->primaryKey => $id));
		$this->set('articletag', $this->Articletag->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Articletag->create();
			if ($this->Articletag->save($this->request->data)) {
				$this->Session->setFlash(__('The articletag has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The articletag could not be saved. Please, try again.'));
			}
		}
		$articles = $this->Articletag->Article->find('list');
		$tags = $this->Articletag->Tag->find('list');
		$this->set(compact('articles', 'tags'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Articletag->exists($id)) {
			throw new NotFoundException(__('Invalid articletag'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Articletag->save($this->request->data)) {
				$this->Session->setFlash(__('The articletag has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The articletag could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Articletag.' . $this->Articletag->primaryKey => $id));
			$this->request->data = $this->Articletag->find('first', $options);
		}
		$articles = $this->Articletag->Article->find('list');
		$tags = $this->Articletag->Tag->find('list');
		$this->set(compact('articles', 'tags'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Articletag->id = $id;
		if (!$this->Articletag->exists()) {
			throw new NotFoundException(__('Invalid articletag'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Articletag->delete()) {
			$this->Session->setFlash(__('Articletag deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Articletag was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
