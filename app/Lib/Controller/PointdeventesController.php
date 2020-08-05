<?php
App::uses('AppController', 'Controller');
/**
 * Pointdeventes Controller
 *
 * @property Pointdevente $Pointdevente
 */
class PointdeventesController extends AppController {

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
                if(@$liens['lien']=='pointdeventes'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }    
		$this->Pointdevente->recursive = 0;
		$this->set('pointdeventes', $this->paginate());
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
                if(@$liens['lien']=='pointdeventes'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }
		if (!$this->Pointdevente->exists($id)) {
			throw new NotFoundException(__('Invalid pointdevente'));
		}
		$options = array('conditions' => array('Pointdevente.' . $this->Pointdevente->primaryKey => $id));
		$this->set('pointdevente', $this->Pointdevente->find('first', $options));
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
                if(@$liens['lien']=='pointdeventes'){
                        $vente=$liens['add'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }
		if ($this->request->is('post')) {
			$this->Pointdevente->create();
			if ($this->Pointdevente->save($this->request->data)) {
				$this->Session->setFlash(__('The pointdevente has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pointdevente could not be saved. Please, try again.'));
			}
		}
		$personnels = $this->Pointdevente->Personnel->find('list');
		$this->set(compact('personnels'));
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
                if(@$liens['lien']=='pointdeventes'){
                        $vente=$liens['edit'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }
		if (!$this->Pointdevente->exists($id)) {
			throw new NotFoundException(__('Invalid pointdevente'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Pointdevente->save($this->request->data)) {
				$this->Session->setFlash(__('The pointdevente has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pointdevente could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Pointdevente.' . $this->Pointdevente->primaryKey => $id));
			$this->request->data = $this->Pointdevente->find('first', $options);
		}
		$personnels = $this->Pointdevente->Personnel->find('list');
		$this->set(compact('personnels'));
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
                if(@$liens['lien']=='pointdeventes'){
                        $vente=$liens['delete'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }
		$this->Pointdevente->id = $id;
		if (!$this->Pointdevente->exists()) {
			throw new NotFoundException(__('Invalid pointdevente'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Pointdevente->delete()) {
			$this->Session->setFlash(__('Pointdevente deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Pointdevente was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
