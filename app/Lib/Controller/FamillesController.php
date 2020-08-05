<?php
App::uses('AppController', 'Controller');
/**
 * Familles Controller
 *
 * @property Famille $Famille
 */
class FamillesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
              $lien=  CakeSession::read('lien_stock');
               $famille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='familles'){
                        $famille=1;
                }}}
              if (( $famille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
		$this->Famille->recursive = 0;
		$this->set('familles', $this->paginate());
                
                  
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            
            $lien=  CakeSession::read('lien_stock');
               $famille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='familles'){
                        $famille=1;
                }}}
              if (( $famille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Famille->exists($id)) {
			throw new NotFoundException(__('Invalid famille'));
		}
		$options = array('conditions' => array('Famille.' . $this->Famille->primaryKey => $id));
		$this->set('famille', $this->Famille->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
              $lien=  CakeSession::read('lien_stock');
               $famille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='familles'){
                        $famille=$liens['add'];
                }}}
              if (( $famille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if ($this->request->is('post')) {
			$this->Famille->create();
			if ($this->Famille->save($this->request->data)) {
				$this->Session->setFlash(__('The famille has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The famille could not be saved. Please, try again.'));
			}
		}
         $codes = $this->Famille->find('all', array('fields' =>
            array(
                'MAX(Famille.code) as num'
                )));
           foreach ($codes as $num) {
                $n = $num[0]['num'];

                if (!empty($n)) {
                    $lastnum = $n;
                    $nume = intval($lastnum) + 1;
                    $code = str_pad($nume, 6, "0", STR_PAD_LEFT);
                } else {
                    $code = "000001";
                }
           }     
      $this->set(compact('code'));    
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
              $lien=  CakeSession::read('lien_stock');
               $famille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='familles'){
                        $famille=$liens['edit'];
                }}}
              if (( $famille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Famille->exists($id)) {
			throw new NotFoundException(__('Invalid famille'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Famille->save($this->request->data)) {
				$this->Session->setFlash(__('The famille has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The famille could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Famille.' . $this->Famille->primaryKey => $id));
			$this->request->data = $this->Famille->find('first', $options);
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
              $lien=  CakeSession::read('lien_stock');
               $famille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='familles'){
                        $famille=$liens['delete'];
                }}}
              if (( $famille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Famille->id = $id;
		if (!$this->Famille->exists()) {
			throw new NotFoundException(__('Invalid famille'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Famille->delete()) {
			$this->Session->setFlash(__('Famille deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Famille was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
