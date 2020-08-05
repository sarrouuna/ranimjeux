<?php
App::uses('AppController', 'Controller');
/**
 * Famillefournisseurs Controller
 *
 * @property Famillefournisseur $Famillefournisseur
 */
class FamillefournisseursController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
             $lien=  CakeSession::read('lien_achat');
               $famillefournisseur="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='famillefournisseurs'){
                        $famillefournisseur=1;
                }}}
              if (( $famillefournisseur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Famillefournisseur->recursive = 0;
		$this->set('famillefournisseurs', $this->paginate());
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
               $famillefournisseur="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='famillefournisseurs'){
                        $famillefournisseur=1;
                }}}
              if (( $famillefournisseur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Famillefournisseur->exists($id)) {
			throw new NotFoundException(__('Invalid famillefournisseur'));
		}
		$options = array('conditions' => array('Famillefournisseur.' . $this->Famillefournisseur->primaryKey => $id));
		$this->set('famillefournisseur', $this->Famillefournisseur->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
            $lien=  CakeSession::read('lien_achat');
               $famillefournisseur="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='famillefournisseurs'){
                        $famillefournisseur=$liens['add'];
                }}}
              if (( $famillefournisseur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if ($this->request->is('post')) {
			$this->Famillefournisseur->create();
			if ($this->Famillefournisseur->save($this->request->data)) {
				$this->Session->setFlash(__('The famillefournisseur has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The famillefournisseur could not be saved. Please, try again.'));
			}
		}
                 $codes = $this->Famillefournisseur->find('all', array('fields' =>
            array(
                'MAX(Famillefournisseur.code) as num'
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
              $lien=  CakeSession::read('lien_achat');
               $famillefournisseur="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='famillefournisseurs'){
                        $famillefournisseur=$liens['edit'];
                }}}
              if (( $famillefournisseur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Famillefournisseur->exists($id)) {
			throw new NotFoundException(__('Invalid famillefournisseur'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Famillefournisseur->save($this->request->data)) {
				$this->Session->setFlash(__('The famillefournisseur has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The famillefournisseur could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Famillefournisseur.' . $this->Famillefournisseur->primaryKey => $id));
			$this->request->data = $this->Famillefournisseur->find('first', $options);
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
              $lien=  CakeSession::read('lien_achat');
               $famillefournisseur="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='famillefournisseurs'){
                        $famillefournisseur=$liens['delete'];
                }}}
              if (( $famillefournisseur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Famillefournisseur->id = $id;
		if (!$this->Famillefournisseur->exists()) {
			throw new NotFoundException(__('Invalid famillefournisseur'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Famillefournisseur->delete()) {
			$this->Session->setFlash(__('Famillefournisseur deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Famillefournisseur was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
