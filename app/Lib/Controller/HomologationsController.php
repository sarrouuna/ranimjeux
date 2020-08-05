<?php
App::uses('AppController', 'Controller');
/**
 * Homologations Controller
 *
 * @property Homologation $Homologation
 */
class HomologationsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
              $lien=  CakeSession::read('lien_stock');
               $homologation="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='homologations'){
                        $homologation=1;
                }}}
              if (( $homologation <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Homologation->recursive = 0;
		$this->set('homologations', $this->paginate());
         if (isset($this->request->data) && !empty($this->request->data)) {         
            if ($this->request->data['Homologation']['etat_id']) {
                 $etatid= $this->request->data['Homologation']['etat_id'];
                 $cond = 'Homologation.etat_id ='.$etatid;
             } 
         }

  $homologations = $this->Homologation->find('all', array( 'conditions' => array('Homologation.id > ' => 0, @$cond)));
       
		
                $etats = $this->Homologation->Etat->find('list');
                 $this->set(compact('etatid','etats','homologations',$this->paginate()));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            $this->loadModel('Article');
		if (!$this->Homologation->exists($id)) {
			throw new NotFoundException(__('Invalid homologation'));
		}
		$options = array('conditions' => array('Homologation.' . $this->Homologation->primaryKey => $id));
		$this->set('homologation', $this->Homologation->find('first', $options));
                 $articles = $this->Article->find('list');
                $this->set(compact('articles'));
	}
   public function imprimer($id = null) {
        $lien=  CakeSession::read('lien_stock');
               $homologation="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='homologations'){
                        $homologation=$liens['imprimer'];
                }}}
              if (( $homologation <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Article');
		if (!$this->Homologation->exists($id)) {
			throw new NotFoundException(__('Invalid homologation'));
		}
		$options = array('conditions' => array('Homologation.' . $this->Homologation->primaryKey => $id));
		$this->set('homologation', $this->Homologation->find('first', $options));
                 $articles = $this->Article->find('list');
                $this->set(compact('articles'));
	}
/**
 * add method
 *
 * @return void
 */
	public function add() {
             $lien=  CakeSession::read('lien_stock');
               $homologation="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='homologations'){
                        $homologation=$liens['add'];
                }}}
              if (( $homologation <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
              $this->loadModel('Article');
		if ($this->request->is('post')) {
                    //debug($this->request->data);die;
			$this->Homologation->create();
			if ($this->Homologation->save($this->request->data)) {
                             $id=$this->Homologation->id;
                          
				$this->Session->setFlash(__('The homologation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The homologation could not be saved. Please, try again.'));
			}
		}
                
                $articles = $this->Article->find('list');
                $this->set(compact('articles'));
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
               $homologation="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='homologations'){
                        $homologation=$liens['edit'];
                }}}
              if (( $homologation <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Article');
		if (!$this->Homologation->exists($id)) {
			throw new NotFoundException(__('Invalid homologation'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    // debug($this->request->data);die;
	             $this->request->data['Homologation']['etat_id']=2;
			if ($this->Homologation->save($this->request->data)) {
		        
                            $this->Session->setFlash(__('The homologation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The homologation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Homologation.' . $this->Homologation->primaryKey => $id));
			$this->request->data = $this->Homologation->find('first', $options);
		}
               
                 $articles = $this->Article->find('list');
                $this->set(compact('articles'));
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
               $homologation="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='homologations'){
                        $homologation=$liens['delete'];
                }}}
              if (( $homologation <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Homologation->id = $id;
		if (!$this->Homologation->exists()) {
			throw new NotFoundException(__('Invalid homologation'));
		}
		$this->request->onlyAllow('post', 'delete');
                                        
		if ($this->Homologation->delete()) {
			$this->Session->setFlash(__('Homologation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Homologation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        public function numlist() {
            $this->layout = null;
            $this->loadModel('Article');  
            $data = $this->request->data;
           $tabnum= $data['tabnum'];
           $homologations = $this->Homologation->find('list',array('fields' => array('Homologation.numero')));
           $homologationlist="";
           $numlist="";
                foreach ($homologations as $homo){
                    $homologationlist=$homologationlist." ".$homo;
                }
                 foreach ($tabnum as $num){
                      if(( !strstr(@$numlist, @$num))&( !strstr($homologationlist, @$num))) { 
                    $numlist=$numlist.",".$num;
                   }
                }
            $tabnum =explode(",",$numlist);  
            
            $select="<select  name='' table='Homologation' index='' id='' champ='numero' class='uniform_select'>"
           . "<option selected='selected' value='0'> Veuillez choisir !!</option>";
            foreach($tabnum as $nl){
                $select=$select."<option value=".$nl.">".$nl."</option>";
            }
            $select=$select.'</select>';
           
             echo $select;
         
        }
}
