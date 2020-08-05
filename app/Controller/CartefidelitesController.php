<?php
App::uses('AppController', 'Controller');
/**
 * Cartefidelites Controller
 *
 * @property Cartefidelite $Cartefidelite
 */
class CartefidelitesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Cartefidelite->recursive = 0;
		$this->set('cartefidelites', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Cartefidelite->exists($id)) {
			throw new NotFoundException(__('Invalid cartefidelite'));
		}
		$options = array('conditions' => array('Cartefidelite.' . $this->Cartefidelite->primaryKey => $id));
		$this->set('cartefidelite', $this->Cartefidelite->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Cartefidelite->create();
			if ($this->Cartefidelite->save($this->request->data)) {
				$this->Session->setFlash(__('The cartefidelite has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cartefidelite could not be saved. Please, try again.'));
			}
		}
                
                $numero = $this->Cartefidelite->find('all', array('fields' =>
            array(
                'MAX(Cartefidelite.numero) as num'
                )));
        foreach ($numero as $num) {
            $n = $num[0]['num'];

            if (!empty($n)) {
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            } else {
                $mm = "000001";
            }
        }
        $this->set(compact('mm'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Cartefidelite->exists($id)) {
			throw new NotFoundException(__('Invalid cartefidelite'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Cartefidelite->save($this->request->data)) {
				$this->Session->setFlash(__('The cartefidelite has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cartefidelite could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Cartefidelite.' . $this->Cartefidelite->primaryKey => $id));
			$this->request->data = $this->Cartefidelite->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Cartefidelite->id = $id;
		if (!$this->Cartefidelite->exists()) {
			throw new NotFoundException(__('Invalid cartefidelite'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Cartefidelite->delete()) {
			$this->Session->setFlash(__('Cartefidelite deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Cartefidelite was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
