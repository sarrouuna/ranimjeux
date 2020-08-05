<?php
App::uses('AppController', 'Controller');
/**
 * Sousfamilleclients Controller
 *
 * @property Sousfamilleclient $Sousfamilleclient
 */
class SousfamilleclientsController extends AppController {


	public function index() {
             $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='sousfamilleclients'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Sousfamilleclient->recursive = 0;
		$this->set('sousfamilleclients', $this->paginate());
	}

	public function view($id = null) {
            $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='sousfamilleclients'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Sousfamilleclient->exists($id)) {
			throw new NotFoundException(__('Invalid sousfamilleclient'));
		}
		$options = array('conditions' => array('Sousfamilleclient.' . $this->Sousfamilleclient->primaryKey => $id));
		$this->set('sousfamilleclient', $this->Sousfamilleclient->find('first', $options));
	}

	public function add() {
            $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='sousfamilleclients'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if ($this->request->is('post')) {
			$this->Sousfamilleclient->create();
			if ($this->Sousfamilleclient->save($this->request->data)) {
                            $id = $this->Sousfamilleclient->id;
                            $this->misejour("Sousfamilleclient","add",$id);
				$this->Session->setFlash(__('The sousfamilleclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sousfamilleclient could not be saved. Please, try again.'));
			}
		}
                 $codes = $this->Sousfamilleclient->find('all', array('fields' =>
            array(
                'MAX(Sousfamilleclient.code) as num'
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
           
		$familleclients = $this->Sousfamilleclient->Familleclient->find('list');
		$this->set(compact('familleclients','code'));
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
                if(@$liens['lien']=='sousfamilleclients'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Sousfamilleclient->exists($id)) {
			throw new NotFoundException(__('Invalid sousfamilleclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Sousfamilleclient->save($this->request->data)) {
				$this->Session->setFlash(__('The sousfamilleclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sousfamilleclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Sousfamilleclient.' . $this->Sousfamilleclient->primaryKey => $id));
			$this->request->data = $this->Sousfamilleclient->find('first', $options);
		}
		$familleclients = $this->Sousfamilleclient->Familleclient->find('list');
		$this->set(compact('familleclients'));
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
                if(@$liens['lien']=='sousfamilleclients'){
                        $x=$liens['delete'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Sousfamilleclient->id = $id;
		if (!$this->Sousfamilleclient->exists()) {
			throw new NotFoundException(__('Invalid sousfamilleclient'));
		}
                $abcd = $this->Sousfamilleclient->find('first', array('conditions' => array('Sousfamilleclient.id' => $id), 'recursive' => -1));
                $numansar=$abcd['Sousfamilleclient']['code'];
		$this->request->onlyAllow('post', 'delete');
		if ($this->Sousfamilleclient->delete()) {
                    $this->misejour("Sousfamilleclient",$numansar,$id);
			$this->Session->setFlash(__('Sousfamilleclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Sousfamilleclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
