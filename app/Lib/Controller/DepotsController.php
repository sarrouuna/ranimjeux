<?php
App::uses('AppController', 'Controller');
/**
 * Depots Controller
 *
 * @property Depot $Depot
 */
class DepotsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
            $lien=  CakeSession::read('lien_stock');
               $depot="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='depots'){
                        $depot=1;
                }}}
              if (( $depot <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Depot->recursive = 0;
		$this->set('depots', $this->paginate());
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
               $depot="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='depots'){
                        $depot=1;
                }}}
              if (( $depot <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
		if (!$this->Depot->exists($id)) {
			throw new NotFoundException(__('Invalid depot'));
		}
		$options = array('conditions' => array('Depot.' . $this->Depot->primaryKey => $id));
		$this->set('depot', $this->Depot->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
              $lien=  CakeSession::read('lien_stock');
               $depot="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='depots'){
                        $depot=$liens['add'];
                }}}
                
              if (( $depot <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
                   
		if ($this->request->is('post')) {
			$this->Depot->create();
			if ($this->Depot->save($this->request->data)) {
				$this->Session->setFlash(__('The depot has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The depot could not be saved. Please, try again.'));
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
            $lien=  CakeSession::read('lien_stock');
               $depot="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='depots'){
                        $depot=$liens['edit'];
                }}}
              if (( $depot <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Depot->exists($id)) {
			throw new NotFoundException(__('Invalid depot'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Depot->save($this->request->data)) {
				$this->Session->setFlash(__('The depot has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The depot could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Depot.' . $this->Depot->primaryKey => $id));
			$this->request->data = $this->Depot->find('first', $options);
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
               $depot="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='depots'){
                        $depot=$liens['delete'];
                }}}
              if (( $depot <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Depot->id = $id;
		if (!$this->Depot->exists()) {
			throw new NotFoundException(__('Invalid depot'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Depot->delete()) {
			$this->Session->setFlash(__('Depot deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Depot was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
