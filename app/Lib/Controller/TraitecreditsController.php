<?php
App::uses('AppController', 'Controller');
/**
 * Traitecredits Controller
 *
 * @property Traitecredit $Traitecredit
 */
class TraitecreditsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Traitecredit->recursive = 0;
		$this->set('traitecredits', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Traitecredit->exists($id)) {
			throw new NotFoundException(__('Invalid traitecredit'));
		}
		$options = array('conditions' => array('Traitecredit.' . $this->Traitecredit->primaryKey => $id));
		$this->set('traitecredit', $this->Traitecredit->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Traitecredit->create();
			if ($this->Traitecredit->save($this->request->data)) {
				$this->Session->setFlash(__('The traitecredit has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The traitecredit could not be saved. Please, try again.'));
			}
		}
		$reglements = $this->Traitecredit->Reglement->find('list');
		$piecereglements = $this->Traitecredit->Piecereglement->find('list');
		$fournisseurs = $this->Traitecredit->Fournisseur->find('list');
		$importations = $this->Traitecredit->Importation->find('list');
		$this->set(compact('reglements', 'piecereglements', 'fournisseurs', 'importations'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Traitecredit->exists($id)) {
			throw new NotFoundException(__('Invalid traitecredit'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Traitecredit->save($this->request->data)) {
				$this->Session->setFlash(__('The traitecredit has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The traitecredit could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Traitecredit.' . $this->Traitecredit->primaryKey => $id));
			$this->request->data = $this->Traitecredit->find('first', $options);
		}
		$reglements = $this->Traitecredit->Reglement->find('list');
		$piecereglements = $this->Traitecredit->Piecereglement->find('list');
		$fournisseurs = $this->Traitecredit->Fournisseur->find('list');
		$importations = $this->Traitecredit->Importation->find('list');
		$this->set(compact('reglements', 'piecereglements', 'fournisseurs', 'importations'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Traitecredit->id = $id;
		if (!$this->Traitecredit->exists()) {
			throw new NotFoundException(__('Invalid traitecredit'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Traitecredit->delete()) {
			$this->Session->setFlash(__('Traitecredit deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Traitecredit was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
