<?php
App::uses('AppController', 'Controller');
/**
 * Pays Controller
 *
 * @property Pay $Pay
 */
class PaysController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='pays'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
		$this->Pay->recursive = 0;
		$this->set('pays', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
             $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='pays'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   } 
		if (!$this->Pay->exists($id)) {
			throw new NotFoundException(__('Invalid pay'));
		}
		$options = array('conditions' => array('Pay.' . $this->Pay->primaryKey => $id));
		$this->set('pay', $this->Pay->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
         $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='pays'){
                        $vente=$liens['add'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }     
		if ($this->request->is('post')) {
			$this->Pay->create();
			if ($this->Pay->save($this->request->data)) {
				$this->Session->setFlash(__('The pay has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pay could not be saved. Please, try again.'));
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
             $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='pays'){
                        $vente=$liens['edit'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   } 
		if (!$this->Pay->exists($id)) {
			throw new NotFoundException(__('Invalid pay'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Pay->save($this->request->data)) {
				$this->Session->setFlash(__('The pay has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pay could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Pay.' . $this->Pay->primaryKey => $id));
			$this->request->data = $this->Pay->find('first', $options);
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
             $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='pays'){
                        $vente=$liens['delete'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   } 
		$this->Pay->id = $id;
		if (!$this->Pay->exists()) {
			throw new NotFoundException(__('Invalid pay'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Pay->delete()) {
			$this->Session->setFlash(__('Pay deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Pay was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
