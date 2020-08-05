<?php
App::uses('AppController', 'Controller');
/**
 * Alimentations Controller
 *
 * @property Alimentation $Alimentation
 */
class AlimentationsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='alimentations'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
		$this->Alimentation->recursive = 0;
		$this->set('alimentations', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='alimentations'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
		if (!$this->Alimentation->exists($id)) {
			throw new NotFoundException(__('Invalid alimentation'));
		}
		$options = array('conditions' => array('Alimentation.' . $this->Alimentation->primaryKey => $id));
		$this->set('alimentation', $this->Alimentation->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='alimentations'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
            $this->loadModel('Cheque');
		if ($this->request->is('post')) {
                   // debug($this->request->data);die;
                    $this->request->data['Alimentation']['cheque_id']= $this->request->data['pieceregelemnt'][0]['cheque_id'];
                    $this->request->data['Alimentation']['echance']= date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Alimentation']['echance'])));
                    $this->request->data['Alimentation']['date']= date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Alimentation']['date'])));
			$this->Alimentation->create();
			if ($this->Alimentation->save($this->request->data)) {
                                $this->Cheque->updateAll(array('Cheque.etat' =>1), array('Cheque.id' =>$this->request->data['Alimentation']['cheque_id']));
				$this->Session->setFlash(__('The alimentation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The alimentation could not be saved. Please, try again.'));
			}
		}
                
           $numero = $this->Alimentation->find('all', array('fields' =>
            array(
                'MAX(Alimentation.numero) as num'
                )));
        foreach ($numero as $num) {
            $n = $num[0]['num'];

            if (!empty($n)) {
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            } else {
                $mm = "000001";
            }
        }
		$carnetcheques = $this->Alimentation->Carnetcheque->find('list',array('fields' => array('Carnetcheque.numero')));
		$cheques = $this->Alimentation->Cheque->find('list');
		$this->set(compact('carnetcheques', 'cheques','mm'));
	}
  
        
	public function edit($id = null) {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='alimentations'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
            $this->loadModel('Cheque');
		if (!$this->Alimentation->exists($id)) {
			throw new NotFoundException(__('Invalid alimentation'));
		}
		$alimentation = $this->Alimentation->find('first',array('conditions' => array('Alimentation.id'=>$id)));
                $echance=date("d/m/Y",strtotime(str_replace('-','/',$alimentation['Alimentation']['echance'])));
                $cheque_id=$alimentation['Alimentation']['cheque_id'];
                //debug($echance);die;
		if ($this->request->is('post') || $this->request->is('put')) {
                    
                   $this->Cheque->updateAll(array('Cheque.etat' =>0), array('Cheque.id' =>$cheque_id));
                   
                    if(empty($this->request->data['Alimentation']['cheque_id'])){
                        $this->request->data['Alimentation']['cheque_id']= $this->request->data['pieceregelemnt'][0]['cheque_id'];
                    }
                     $this->request->data['Alimentation']['echance']= date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Alimentation']['echance'])));
	             $this->request->data['Alimentation']['date']= date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Alimentation']['date'])));
                     if ($this->Alimentation->save($this->request->data)) {
                            
                   $this->Cheque->updateAll(array('Cheque.etat' =>1), array('Cheque.id' =>$this->request->data['Alimentation']['cheque_id']));
                   
				$this->Session->setFlash(__('The alimentation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The alimentation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Alimentation.' . $this->Alimentation->primaryKey => $id));
			$this->request->data = $this->Alimentation->find('first', $options);
		}
                $date=date("d/m/Y",strtotime(str_replace('-','/',$alimentation['Alimentation']['date'])));
		$carnetcheques = $this->Alimentation->Carnetcheque->find('list',array('fields' => array('Carnetcheque.numero')));
		$cheques = $this->Alimentation->Cheque->find('list',array('fields' => array('Cheque.numero'),'conditions'=>array('Cheque.etat =0 or Cheque.id ='.$cheque_id)));
		$this->set(compact('carnetcheques','cheques','echance','date'));
	    }

            
	public function delete($id = null) {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='alimentations'){
                        $x=$liens['delete'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
            $this->loadModel('Cheque');
		$this->Alimentation->id = $id;
		if (!$this->Alimentation->exists()) {
			throw new NotFoundException(__('Invalid alimentation'));
		}
		$this->request->onlyAllow('post', 'delete');
                
                  $alimentation = $this->Alimentation->find('first',array('conditions' => array('Alimentation.id'=>$id)));
                  $cheque_id=$alimentation['Alimentation']['cheque_id'];
                  $this->Cheque->updateAll(array('Cheque.etat' =>0), array('Cheque.id' =>$cheque_id));

		if ($this->Alimentation->delete()) {
			$this->Session->setFlash(__('Alimentation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Alimentation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
