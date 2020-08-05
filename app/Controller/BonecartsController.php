<?php
App::uses('AppController', 'Controller');
/**
 * Bonecarts Controller
 *
 * @property Bonecart $Bonecart
 */
class BonecartsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$bonecarts = $this->Bonecart->find('all',array('group'=>array('Bonecart.inventaire_id'),'recursive'=>0));
                $this->set(compact('bonecarts',$this->paginate()));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$bon = $this->Bonecart->find('all',array('conditions' => array('Bonecart.inventaire_id' =>$id),'group'=>array('Bonecart.inventaire_id'),'recursive'=>0));
		$bonecarts = $this->Bonecart->find('all', array('conditions' => array('Bonecart.inventaire_id' =>$id), 'order' => array('Bonecart.id' => 'ASC')));
                //debug($bon);
                //debug($bonecarts);die;
                $this->set(compact('bonecarts','bon'));
	}
        public function imprimer($id = null) {
		$bon = $this->Bonecart->find('all',array('conditions' => array('Bonecart.inventaire_id' =>$id),'group'=>array('Bonecart.inventaire_id'),'recursive'=>0));
		$bonecarts = $this->Bonecart->find('all', array('conditions' => array('Bonecart.inventaire_id' =>$id), 'order' => array('Bonecart.id' => 'ASC')));
                //debug($bon);
                //debug($bonecarts);die;
                $this->set(compact('bonecarts','bon'));
	}

        
        public function index1() {
            $this->loadModel('Inventaire');
                $inventaires = $this->Inventaire->find('list', array('fields' => array('Inventaire.numero'),'conditions' => array('Inventaire.valide' =>0)));
		$bonecarts = $this->Bonecart->find('all',array('group'=>array('Bonecart.inventaire_id'),'recursive'=>0));
                $this->set(compact('inventaires','bonecarts',$this->paginate()));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view1($id = null) {
		$bonecarts = $this->Bonecart->find('all', array('conditions' => array('Bonecart.inventaire_id' =>$id), 'order' => array('Bonecart.id' => 'ASC')));
                $this->set(compact('bonecarts'));
	}
        public function imprimer1($id = null) {
		$bon = $this->Bonecart->find('all',array('group'=>array('Bonecart.inventaire_id'),'recursive'=>0));
		$bonecarts = $this->Bonecart->find('all', array('conditions' => array('Bonecart.inventaire_id' =>$id), 'order' => array('Bonecart.id' => 'ASC')));
                //debug($bonecart);
                //debug($bonecarts);die;
                $this->set(compact('bonecarts','bon'));
	}
        
        
        
        
        
        
        
/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Bonecart->create();
			if ($this->Bonecart->save($this->request->data)) {
				$this->Session->setFlash(__('The bonecart has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bonecart could not be saved. Please, try again.'));
			}
		}
		$inventaires = $this->Bonecart->Inventaire->find('list');
		$articles = $this->Bonecart->Article->find('list');
		$depots = $this->Bonecart->Depot->find('list');
		$this->set(compact('inventaires', 'articles', 'depots'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Bonecart->exists($id)) {
			throw new NotFoundException(__('Invalid bonecart'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Bonecart->save($this->request->data)) {
				$this->Session->setFlash(__('The bonecart has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bonecart could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Bonecart.' . $this->Bonecart->primaryKey => $id));
			$this->request->data = $this->Bonecart->find('first', $options);
		}
		$inventaires = $this->Bonecart->Inventaire->find('list');
		$articles = $this->Bonecart->Article->find('list');
		$depots = $this->Bonecart->Depot->find('list');
		$this->set(compact('inventaires', 'articles', 'depots'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Bonecart->id = $id;
		if (!$this->Bonecart->exists()) {
			throw new NotFoundException(__('Invalid bonecart'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Bonecart->delete()) {
			$this->Session->setFlash(__('Bonecart deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Bonecart was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
