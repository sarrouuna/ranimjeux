<?php
App::uses('AppController', 'Controller');
/**
 * Exercices Controller
 *
 * @property Exercice $Exercice
 */
class ExercicesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
         $lien=  CakeSession::read('lien_parametrage');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='exercices'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }    
		$this->Exercice->recursive = 0;
		$this->set('exercices', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
        $lien=  CakeSession::read('lien_parametrage');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='exercices'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }        
		if (!$this->Exercice->exists($id)) {
			throw new NotFoundException(__('Invalid exercice'));
		}
		$options = array('conditions' => array('Exercice.' . $this->Exercice->primaryKey => $id));
		$this->set('exercice', $this->Exercice->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
        $lien=  CakeSession::read('lien_parametrage');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='exercices'){
                        $vente=$liens['add'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }        
		if ($this->request->is('post')) {
			$this->Exercice->create();
			if ($this->Exercice->save($this->request->data)) {
				$this->Session->setFlash(__('The exercice has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The exercice could not be saved. Please, try again.'));
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
        $lien=  CakeSession::read('lien_parametrage');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='exercices'){
                        $vente=$liens['edit'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }    
		if (!$this->Exercice->exists($id)) {
			throw new NotFoundException(__('Invalid exercice'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Exercice->save($this->request->data)) {
				$this->Session->setFlash(__('The exercice has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The exercice could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Exercice.' . $this->Exercice->primaryKey => $id));
			$this->request->data = $this->Exercice->find('first', $options);
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
            $lien=  CakeSession::read('lien_parametrage');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='exercices'){
                        $vente=$liens['delete'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }
		$this->Exercice->id = $id;
		if (!$this->Exercice->exists()) {
			throw new NotFoundException(__('Invalid exercice'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Exercice->delete()) {
			$this->Session->setFlash(__('Exercice deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Exercice was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
