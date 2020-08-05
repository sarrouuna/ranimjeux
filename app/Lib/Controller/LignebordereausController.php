<?php
App::uses('AppController', 'Controller');
/**
 * Lignebordereaus Controller
 *
 * @property Lignebordereau $Lignebordereau
 */
class LignebordereausController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Lignebordereau->recursive = 0;
		$this->set('lignebordereaus', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Lignebordereau->exists($id)) {
			throw new NotFoundException(__('Invalid lignebordereau'));
		}
		$options = array('conditions' => array('Lignebordereau.' . $this->Lignebordereau->primaryKey => $id));
		$this->set('lignebordereau', $this->Lignebordereau->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Lignebordereau->create();
			if ($this->Lignebordereau->save($this->request->data)) {
				$this->Session->setFlash(__('The lignebordereau has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignebordereau could not be saved. Please, try again.'));
			}
		}
		$bordereaus = $this->Lignebordereau->Bordereau->find('list');
		$this->set(compact('bordereaus'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Lignebordereau->exists($id)) {
			throw new NotFoundException(__('Invalid lignebordereau'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Lignebordereau->save($this->request->data)) {
				$this->Session->setFlash(__('The lignebordereau has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The lignebordereau could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Lignebordereau.' . $this->Lignebordereau->primaryKey => $id));
			$this->request->data = $this->Lignebordereau->find('first', $options);
		}
		$bordereaus = $this->Lignebordereau->Bordereau->find('list');
		$this->set(compact('bordereaus'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Lignebordereau->id = $id;
		if (!$this->Lignebordereau->exists()) {
			throw new NotFoundException(__('Invalid lignebordereau'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Lignebordereau->delete()) {
			$this->Session->setFlash(__('Lignebordereau deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Lignebordereau was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
