<?php
App::uses('AppController', 'Controller');
/**
 * Namesituations Controller
 *
 * @property Namesituation $Namesituation
 */
class NamesituationsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
            $lien=  CakeSession::read('lien_achat');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='namesituations'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   } 
		$this->Namesituation->recursive = 0;
		$this->set('namesituations', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            $lien=  CakeSession::read('lien_achat');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='namesituations'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   } 
            $this->loadModel('Personnel');
            $this->loadModel('Situationpersonnel');
		if (!$this->Namesituation->exists($id)) {
			throw new NotFoundException(__('Invalid namesituation'));
		}
		$options = array('conditions' => array('Namesituation.' . $this->Namesituation->primaryKey => $id));
		$this->set('namesituation', $this->Namesituation->find('first', $options));
                $personnels=$this->Personnel->find('all');
                $situationpersonnels=$this->Situationpersonnel->find('all',array('conditions'=>array('Situationpersonnel.namesituation_id' =>$id)));
                //debug($situationpersonnels);
                $this->set(compact('personnels','situationpersonnels'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
            $lien=  CakeSession::read('lien_achat');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='namesituations'){
                        $vente=$liens['add'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   } 
            $this->loadModel('Personnel');
            $this->loadModel('Situationpersonnel');
		if ($this->request->is('post')) {
                    //debug($this->request->data);die;
			$this->Namesituation->create();
			if ($this->Namesituation->save($this->request->data)) {
                            $id = $this->Namesituation->id;
                            $tab=array();
                            foreach ($this->request->data['Namesituation']['personnel_id'] as $p) {
                            $tab['namesituation_id']=$id;
                            $tab['personnel_id']=$p;
                            //debug($tab);die;
                            $this->Situationpersonnel->create();
                            $this->Situationpersonnel->save($tab);
                            }
				$this->Session->setFlash(__('The namesituation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The namesituation could not be saved. Please, try again.'));
			}
		}
                $personnels=$this->Personnel->find('list');
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
            $lien=  CakeSession::read('lien_achat');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='namesituations'){
                        $vente=$liens['edit'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   } 
            $this->loadModel('Personnel');
            $this->loadModel('Situationpersonnel');
		if (!$this->Namesituation->exists($id)) {
			throw new NotFoundException(__('Invalid namesituation'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    //debug($this->request->data);die;
			if ($this->Namesituation->save($this->request->data)) {
                        $this->Situationpersonnel->deleteAll(array('Situationpersonnel.namesituation_id'=>$id),false);
			$tab=array();
                            foreach ($this->request->data['Namesituation']['personnel_id'] as $p) {
                            $tab['namesituation_id']=$id;
                            $tab['personnel_id']=$p;
                            //debug($tab);die;
                            $this->Situationpersonnel->create();
                            $this->Situationpersonnel->save($tab);
                            }	
                        $this->Session->setFlash(__('The namesituation has been saved'));
                        $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The namesituation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Namesituation.' . $this->Namesituation->primaryKey => $id));
			$this->request->data = $this->Namesituation->find('first', $options);
		}
                $personnels=$this->Personnel->find('all');
                $situationpersonnels=$this->Situationpersonnel->find('all',array('conditions'=>array('Situationpersonnel.namesituation_id' =>$id)));
                //debug($situationpersonnels);
                $this->set(compact('personnels','situationpersonnels'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
            $lien=  CakeSession::read('lien_achat');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='namesituations'){
                        $vente=$liens['delete'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   } 
		$this->Namesituation->id = $id;
		if (!$this->Namesituation->exists()) {
			throw new NotFoundException(__('Invalid namesituation'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Namesituation->delete()) {
			$this->Session->setFlash(__('Namesituation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Namesituation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
