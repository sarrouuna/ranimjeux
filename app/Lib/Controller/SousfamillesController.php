<?php
App::uses('AppController', 'Controller');
/**
 * Sousfamilles Controller
 *
 * @property Sousfamille $Sousfamille
 */
class SousfamillesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
                  $lien=  CakeSession::read('lien_stock');
               $sousfamille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='sousfamilles'){
                        $sousfamille=1;
                }}}
              if (( $sousfamille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Sousfamille->recursive = 0;
		$this->set('sousfamilles', $this->paginate());
                
                
                
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
               $sousfamille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='sousfamilles'){
                        $sousfamille=1;
                }}}
              if (( $sousfamille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Sousfamille->exists($id)) {
			throw new NotFoundException(__('Invalid sousfamille'));
		}
		$options = array('conditions' => array('Sousfamille.' . $this->Sousfamille->primaryKey => $id));
		$this->set('sousfamille', $this->Sousfamille->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
              $lien=  CakeSession::read('lien_stock');
               $sousfamille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='sousfamilles'){
                        $sousfamille=$liens['add'];
                }}}
              if (( $sousfamille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
		if ($this->request->is('post')) {
			$this->Sousfamille->create();
			if ($this->Sousfamille->save($this->request->data)) {
				$this->Session->setFlash(__('The sousfamille has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sousfamille could not be saved. Please, try again.'));
			}
		}
		$familles = $this->Sousfamille->Famille->find('list');
          $codes = $this->Sousfamille->find('all', array('fields' =>
            array(
                'MAX(Sousfamille.code) as num'
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
		$this->set(compact('familles','code'));
                
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
               $sousfamille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='sousfamilles'){
                        $sousfamille=$liens['edit'];
                }}}
              if (( $sousfamille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
		if (!$this->Sousfamille->exists($id)) {
			throw new NotFoundException(__('Invalid sousfamille'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Sousfamille->save($this->request->data)) {
				$this->Session->setFlash(__('The sousfamille has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sousfamille could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Sousfamille.' . $this->Sousfamille->primaryKey => $id));
			$this->request->data = $this->Sousfamille->find('first', $options);
		}
		$familles = $this->Sousfamille->Famille->find('list');
		$this->set(compact('familles'));
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
               $sousfamille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='sousfamilles'){
                        $sousfamille=$liens['delete'];
                }}}
              if (( $sousfamille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Sousfamille->id = $id;
		if (!$this->Sousfamille->exists()) {
			throw new NotFoundException(__('Invalid sousfamille'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Sousfamille->delete()) {
			$this->Session->setFlash(__('Sousfamille deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Sousfamille was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
