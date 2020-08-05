<?php
App::uses('AppController', 'Controller');
/**
 * Commissions Controller
 *
 * @property Commission $Commission
 */
class CommissionsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Commission->recursive = 0;
		$this->set('commissions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Commission->exists($id)) {
			throw new NotFoundException(__('Invalid commission'));
		}
		$options = array('conditions' => array('Commission.' . $this->Commission->primaryKey => $id));
		$this->set('commission', $this->Commission->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Commission->create();
			if ($this->Commission->save($this->request->data)) {
				$this->Session->setFlash(__('The commission has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The commission could not be saved. Please, try again.'));
			}
		}
		$personnels = $this->Commission->Personnel->find('list');
		$articles = $this->Commission->Article->find('list');
		$familles = $this->Commission->Famille->find('list');
		$sousfamilles = $this->Commission->Sousfamille->find('list');
		$soussousfamilles = $this->Commission->Soussousfamille->find('list');
		$this->set(compact('personnels', 'articles', 'familles', 'sousfamilles', 'soussousfamilles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Commission->exists($id)) {
			throw new NotFoundException(__('Invalid commission'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Commission->save($this->request->data)) {
				$this->Session->setFlash(__('The commission has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The commission could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Commission.' . $this->Commission->primaryKey => $id));
			$this->request->data = $this->Commission->find('first', $options);
		}
		$personnels = $this->Commission->Personnel->find('list');
		$articles = $this->Commission->Article->find('list');
		$familles = $this->Commission->Famille->find('list');
		$sousfamilles = $this->Commission->Sousfamille->find('list');
		$soussousfamilles = $this->Commission->Soussousfamille->find('list');
		$this->set(compact('personnels', 'articles', 'familles', 'sousfamilles', 'soussousfamilles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Commission->id = $id;
		if (!$this->Commission->exists()) {
			throw new NotFoundException(__('Invalid commission'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Commission->delete()) {
			$this->Session->setFlash(__('Commission deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Commission was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
