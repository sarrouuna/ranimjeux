<?php
App::uses('AppController', 'Controller');
/**
 * Fonctions Controller
 *
 * @property Fonction $Fonction
 */
class FonctionsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
            $lien=  CakeSession::read('lien_parametrage');
               $fonction="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='fonctions'){
                        $fonction=1;
                }}}
              if (( $fonction <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Fonction->recursive = 0;
		$this->set('fonctions', $this->paginate());
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
               $fonction="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='fonctions'){
                        $fonction=1;
                }}}
              if (( $fonction <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Fonction->exists($id)) {
			throw new NotFoundException(__('Invalid fonction'));
		}
		$options = array('conditions' => array('Fonction.' . $this->Fonction->primaryKey => $id));
		$this->set('fonction', $this->Fonction->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
             $lien=  CakeSession::read('lien_parametrage');
               $fonction="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='fonctions'){
                        $fonction=$liens['add'];
                }}}
              if (( $fonction <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if ($this->request->is('post')) {
			$this->Fonction->create();
			if ($this->Fonction->save($this->request->data)) {
				$this->Session->setFlash(__('The fonction has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fonction could not be saved. Please, try again.'));
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
               $fonction="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='fonctions'){
                        $fonction=$liens['edit'];
                }}}
              if (( $fonction <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   } 
                   
                   
            if (!$this->Fonction->exists($id)) {
			throw new NotFoundException(__('Invalid fonction'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Fonction->save($this->request->data)) {
				$this->Session->setFlash(__('The fonction has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fonction could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Fonction.' . $this->Fonction->primaryKey => $id));
			$this->request->data = $this->Fonction->find('first', $options);
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
               $fonction="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='fonctions'){
                        $fonction=$liens['delete'];
                }}}
              if (( $fonction <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   } 
		$this->Fonction->id = $id;
		if (!$this->Fonction->exists()) {
			throw new NotFoundException(__('Invalid fonction'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Fonction->delete()) {
			$this->Session->setFlash(__('Fonction deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Fonction was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
