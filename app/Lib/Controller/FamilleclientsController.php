<?php
App::uses('AppController', 'Controller');
/**
 * Familleclients Controller
 *
 * @property Familleclient $Familleclient
 */
class FamilleclientsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
              $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='familleclients'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Familleclient->recursive = 0;
		$this->set('familleclients', $this->paginate());
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
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='familleclients'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Familleclient->exists($id)) {
			throw new NotFoundException(__('Invalid familleclient'));
		}
		$options = array('conditions' => array('Familleclient.' . $this->Familleclient->primaryKey => $id));
		$this->set('familleclient', $this->Familleclient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
             $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='familleclients'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if ($this->request->is('post')) {
			$this->Familleclient->create();
			if ($this->Familleclient->save($this->request->data)) {
				$this->Session->setFlash(__('The familleclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The familleclient could not be saved. Please, try again.'));
			}
		}
                $codes = $this->Familleclient->find('all', array('fields' =>
            array(
                'MAX(Familleclient.code) as num'
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
            $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='familleclients'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Familleclient->exists($id)) {
			throw new NotFoundException(__('Invalid familleclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Familleclient->save($this->request->data)) {
				$this->Session->setFlash(__('The familleclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The familleclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Familleclient.' . $this->Familleclient->primaryKey => $id));
			$this->request->data = $this->Familleclient->find('first', $options);
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
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='familleclients'){
                        $x=$liens['delete'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Familleclient->id = $id;
		if (!$this->Familleclient->exists()) {
			throw new NotFoundException(__('Invalid familleclient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Familleclient->delete()) {
			$this->Session->setFlash(__('Familleclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Familleclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
