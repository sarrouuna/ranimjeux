<?php
App::uses('AppController', 'Controller');
/**
 * Accueils Controller
 *
 * @property Accueil $Accueil
 */
class AccueilsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
            $stock="";
            $parametrage="";
            $achat="";
            $vente=""; 
            $finance=""; 
            $stat="";
            
            
            
            $stock=  CakeSession::read('stock');
            $parametrage=  CakeSession::read('parametrage');
            $achat=  CakeSession::read('achat');
            $vente=  CakeSession::read('vente'); 
            $finance=  CakeSession::read('finance'); 
            $stat=  CakeSession::read('stat');
            if(($parametrage=="par")|| ($stock=="stk")||($achat=="ach")||($vente=="vnt")||($finance=="fnc")||($stat=="stat")){
              //$this->redirect(array('controller' => 'utilisateurs','action' => 'accueil'));
            }else{
            $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));    
            }
            //$this->stockajouter(9);
            //$this->stock(4,9);  
            //$this->miseajourfactureachat();
            //$this->miseajourfacturevente();
           $this->set(compact('liens'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Accueil->exists($id)) {
			throw new NotFoundException(__('Invalid accueil'));
		}
		$options = array('conditions' => array('Accueil.' . $this->Accueil->primaryKey => $id));
		$this->set('accueil', $this->Accueil->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Accueil->create();
			if ($this->Accueil->save($this->request->data)) {
				$this->Session->setFlash(__('The accueil has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The accueil could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Accueil->exists($id)) {
			throw new NotFoundException(__('Invalid accueil'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Accueil->save($this->request->data)) {
				$this->Session->setFlash(__('The accueil has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The accueil could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Accueil.' . $this->Accueil->primaryKey => $id));
			$this->request->data = $this->Accueil->find('first', $options);
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
		$this->Accueil->id = $id;
		if (!$this->Accueil->exists()) {
			throw new NotFoundException(__('Invalid accueil'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Accueil->delete()) {
			$this->Session->setFlash(__('Accueil deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Accueil was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
