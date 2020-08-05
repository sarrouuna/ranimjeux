<?php
App::uses('AppController', 'Controller');
/**
 * Personnels Controller
 *
 * @property Personnel $Personnel
 */
class PersonnelsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
             $lien=  CakeSession::read('lien_parametrage');
               $personnel="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                  // debug($liens);die;
                if(@$liens['lien']=='personnels'){
                        $personnel=1;
                }}}
              if (( $personnel <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Personnel->recursive = 0;
		$this->set('personnels', $this->paginate());
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
               $personnel="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                  // debug($liens);die;
                if(@$liens['lien']=='personnels'){
                        $personnel=1;
                }}}
              if (( $personnel <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Personnel->exists($id)) {
			throw new NotFoundException(__('Invalid personnel'));
		}
		$options = array('conditions' => array('Personnel.' . $this->Personnel->primaryKey => $id));
		$this->set('personnel', $this->Personnel->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
            $lien=  CakeSession::read('lien_parametrage');
               $personnel="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                  // debug($liens);die;
                if(@$liens['lien']=='personnels'){
                        $personnel=$liens['add'];
                }}}
              if (( $personnel <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if ($this->request->is('post')) {
			$this->Personnel->create();
			if ($this->Personnel->save($this->request->data)) {
				$this->Session->setFlash(__('The personnel has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The personnel could not be saved. Please, try again.'));
			}
		}
		$fonctions = $this->Personnel->Fonction->find('list');
		$this->set(compact('fonctions'));
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
               $personnel="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                  // debug($liens);die;
                if(@$liens['lien']=='personnels'){
                        $personnel=$liens['edit'];
                }}}
              if (( $personnel <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Personnel->exists($id)) {
			throw new NotFoundException(__('Invalid personnel'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Personnel->save($this->request->data)) {
				$this->Session->setFlash(__('The personnel has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The personnel could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Personnel.' . $this->Personnel->primaryKey => $id));
			$this->request->data = $this->Personnel->find('first', $options);
		}
		$fonctions = $this->Personnel->Fonction->find('list');
		$this->set(compact('fonctions'));
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
               $personnel="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                  // debug($liens);die;
                if(@$liens['lien']=='personnels'){
                        $personnel=$liens['delete'];
                }}}
              if (( $personnel <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Personnel->id = $id;
		if (!$this->Personnel->exists()) {
			throw new NotFoundException(__('Invalid personnel'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Personnel->delete()) {
			$this->Session->setFlash(__('Personnel deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Personnel was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
