<?php
App::uses('AppController', 'Controller');
/**
 * Soussousfamilles Controller
 *
 * @property Soussousfamille $Soussousfamille
 */
class SoussousfamillesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
             $lien=  CakeSession::read('lien_stock');
               $soussousfamille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='soussousfamilles'){
                        $soussousfamille=1;
                }}}
              if (( $soussousfamille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Soussousfamille->recursive = 0;
		$this->set('soussousfamilles', $this->paginate());
                
                
               
                 
                 
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
               $soussousfamille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='soussousfamilles'){
                        $soussousfamille=1;
                }}}
              if (( $soussousfamille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Soussousfamille->exists($id)) {
			throw new NotFoundException(__('Invalid soussousfamille'));
		}
		$options = array('conditions' => array('Soussousfamille.' . $this->Soussousfamille->primaryKey => $id));
		$this->set('soussousfamille', $this->Soussousfamille->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
             $lien=  CakeSession::read('lien_stock');
               $soussousfamille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='soussousfamilles'){
                        $soussousfamille=$liens['add'];
                }}}
              if (( $soussousfamille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if ($this->request->is('post')) {
			$this->Soussousfamille->create();
                        $this->request->data['Soussousfamille']['sousfamille_id']= @$this->request->data['sousfamille_id'];
			if ($this->Soussousfamille->save($this->request->data)) {
				$this->Session->setFlash(__('The soussousfamille has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The soussousfamille could not be saved. Please, try again.'));
			}
		}
         $codes = $this->Soussousfamille->find('all', array('fields' =>
            array(
                'MAX(Soussousfamille.code) as num'
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
		$familles = $this->Soussousfamille->Famille->find('list');
		$sousfamilles = $this->Soussousfamille->Sousfamille->find('list');
		$this->set(compact('familles', 'sousfamilles','code'));
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
               $soussousfamille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='soussousfamilles'){
                        $soussousfamille=$liens['edit'];
                }}}
              if (( $soussousfamille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Soussousfamille->exists($id)) {
			throw new NotFoundException(__('Invalid soussousfamille'));
		}
                $soussousfamille=$this->Soussousfamille->find('first',array('conditions'=>array('Soussousfamille.id' => $id)));
                $familleid=$soussousfamille['Famille']['id'];
		if ($this->request->is('post') || $this->request->is('put')) {
                      //debug($this->request->data);die;            
                     if($this->request->data['Soussousfamille']['famille_id']!= $familleid){
                        if ($this->request->data['Soussousfamille']['sousfamille_id']!= @$this->request->data['sousfamille_id']) {
                            $this->request->data['Soussousfamille']['sousfamille_id']='';
                            if(@$this->request->data['sousfamille_id']!=0){
                            $this->request->data['Soussousfamille']['sousfamille_id']= @$this->request->data['sousfamille_id'] ;
                          }
                        }
                     }
                    // debug($this->request->data);die;   
			if ($this->Soussousfamille->save($this->request->data)) {
				$this->Session->setFlash(__('The soussousfamille has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The soussousfamille could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Soussousfamille.' . $this->Soussousfamille->primaryKey => $id));
			$this->request->data = $this->Soussousfamille->find('first', $options);
		}
		$familles = $this->Soussousfamille->Famille->find('list');
		$sousfamilles = $this->Soussousfamille->Sousfamille->find('list',array('conditions'=>array('Sousfamille.famille_id' => $familleid)));
		$this->set(compact('familles', 'sousfamilles'));
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
               $soussousfamille="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='soussousfamilles'){
                        $soussousfamille=$liens['delete'];
                }}}
              if (( $soussousfamille <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Soussousfamille->id = $id;
		if (!$this->Soussousfamille->exists()) {
			throw new NotFoundException(__('Invalid soussousfamille'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Soussousfamille->delete()) {
			$this->Session->setFlash(__('Soussousfamille deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Soussousfamille was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
