<?php
App::uses('AppController', 'Controller');
/**
 * Inventaires Controller
 *
 * @property Inventaire $Inventaire
 */
class InventairesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
              $lien=  CakeSession::read('lien_stock');
               $inventaire="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='inventaires'){
                        $inventaire=1;
                }}}
              if (( $inventaire <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   $this->loadModel('Depot');  
                    if (isset($this->request->data) && !empty($this->request->data)) {
       // debug($this->request->data);die;
        if ($this->request->data['Inventaire']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Inventaire']['date1'])));
            $cond1 = 'Inventaire.date >= '."'".$date1."'";
        }
        
        if ($this->request->data['Inventaire']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Inventaire']['date2'])));
            $cond2 = 'Inventaire.date <= '."'".$date2."'";
        }
        
       if ($this->request->data['Inventaire']['depot_id']) {
            $depotid = $this->request->data['Inventaire']['depot_id'];
            $cond3 = 'Inventaire.depot_id ='.$depotid;
        } 
    } 
  $inventaires = $this->Inventaire->find('all', array( 'conditions' => array('Inventaire.id > ' => 0, @$cond1, @$cond2, @$cond3)));
    // debug($inventaires);die;
       
                   $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('date1','date2','depotid','depots','inventaires', $this->paginate()));
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
               $inventaire="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='inventaires'){
                        $inventaire=1;
                }}}
              if (( $inventaire <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Ligneinventaire');
            $this->loadModel('Article');
		if (!$this->Inventaire->exists($id)) {
			throw new NotFoundException(__('Invalid inventaire'));
		}
		$options = array('conditions' => array('Inventaire.' . $this->Inventaire->primaryKey => $id));
		$this->set('inventaire', $this->Inventaire->find('first', $options));
                $articles=$this->Article->find('list',array('fields' => array('Article.name')));; 
                $ligneinvents = $this->Ligneinventaire->find('all',array(
                    'conditions'=>array('Ligneinventaire.inventaire_id' => $id)
                    ));
                 $this->set(compact('ligneinvents','articles'));
	}

        
        
        public function imprimer($id = null) {
           $lien=  CakeSession::read('lien_stock');
               $inventaire="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='inventaires'){
                        $inventaire=$liens['imprimer'];
                }}}
              if (( $inventaire <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Ligneinventaire');
            $this->loadModel('Article');
		if (!$this->Inventaire->exists($id)) {
			throw new NotFoundException(__('Invalid inventaire'));
		}
		$options = array('conditions' => array('Inventaire.' . $this->Inventaire->primaryKey => $id));
		$this->set('inventaire', $this->Inventaire->find('first', $options));
                $articles=$this->Article->find('list'); 
                $ligneinvents = $this->Ligneinventaire->find('all',array(
                    'conditions'=>array('Ligneinventaire.inventaire_id' => $id)
                    ));
                 $this->set(compact('ligneinvents','articles'));
	}
/**
 * add method
 *
 * @return void
 */
	public function add() {
             $lien=  CakeSession::read('lien_stock');
               $inventaire="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='inventaires'){
                        $inventaire=$liens['add'];
                }}}
              if (( $inventaire <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Depot');
             $this->loadModel('Article');
             $this->loadModel('Homologation');
             $this->loadModel('Ligneinventaire');
             $this->loadModel('Stockdepot');
		if ($this->request->is('post')) {
                    //debug ($this->request->data);die;
                    $this->request->data['Inventaire']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Inventaire']['dateinv'])));
		    $this->request->data['Inventaire']['exercice_id']=date("Y");	
                    $this->Inventaire->create();
			if ($this->Inventaire->save($this->request->data)) {
                              $id=$this->Inventaire->id;
                              
                                    $inventaire=$this->Inventaire->find('first',array('conditions'=>array('Inventaire.id' => $id)));
                                    $depotid=$inventaire['Inventaire']['depot_id'];
                                    $this->Stockdepot->deleteAll(array('Stockdepot.depot_id'=>$depotid),false);    
                                    
                               foreach (  $this->request->data['Ligneinventaire'] as $ligneinventaire  ){

                                 if ($ligneinventaire['sup']!=1){
                                     $ligneinventaire['inventaire_id']=$id;
                                     $ligneinventaire['depot_id']=$depotid;
                                        $this->Ligneinventaire->create();
                                        $this->Ligneinventaire->save($ligneinventaire);
                                        
                                     
                                                        $this->Stockdepot->create();
                                                        $this->Stockdepot->save($ligneinventaire); 
                                 }
                               }
                               
				$this->Session->setFlash(__('The inventaire has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inventaire could not be saved. Please, try again.'));
			}
		}
        $numero = $this->Inventaire->find('all', array('fields' =>
            array(
                'MAX(Inventaire.numero) as num'
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
                 $articles=$this->Article->find('list');
		$depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('depots','articles','mm'));
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
               $inventaire="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='inventaires'){
                        $inventaire=$liens['edit'];
                }}}
              if (( $inventaire <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Depot');
             $this->loadModel('Ligneinventaire');
             $this->loadModel('Article');
             $this->loadModel('Homologation');
             $this->loadModel('Stockdepot');
		if (!$this->Inventaire->exists($id)) {
			throw new NotFoundException(__('Invalid inventaire'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                     //debug($this->request->data);die;
                 $this->request->data['Inventaire']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Inventaire']['dateinv'])));
		 $this->request->data['Inventaire']['exercice_id']=date("Y");	
                 if ($this->Inventaire->save($this->request->data)) {
                           if(isset($this->request->data['Ligneinventaire'])){
                               
                                    $inventaire=$this->Inventaire->find('first',array('conditions'=>array('Inventaire.id' => $id)));
                                    $depotid=$inventaire['Inventaire']['depot_id'];
                                    $this->Stockdepot->deleteAll(array('Stockdepot.depot_id'=>$depotid),false);  
                            
                             foreach (  $this->request->data['Ligneinventaire'] as $ligneinventaire   ){
                              if ($ligneinventaire['sup']!=1){
                                     $ligneinventaire['inventaire_id']=$id;
                                     $ligneinventaire['depot_id']=$depotid;
                                        $this->Ligneinventaire->create();
                                        $this->Ligneinventaire->save($ligneinventaire);  
                                                        $ligneinventaire['id']='';
                                                        $this->Stockdepot->create();
                                                        $this->Stockdepot->save($ligneinventaire); 
                                                        
                                 } else {
                               $this->Ligneinventaire->deleteAll(array('Ligneinventaire.id'=>$ligneinventaire['id']),false); 
                              }
                            }
                           }
                           
				$this->Session->setFlash(__('The inventaire has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The inventaire could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Inventaire.' . $this->Inventaire->primaryKey => $id));
			$this->request->data = $this->Inventaire->find('first', $options);
		}
                    $day=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Inventaire']['date'])));
                // debug($this->request->data['Inventaire']['date']);die;
                    $ligneinvents = $this->Ligneinventaire->find('all',array(
                    'conditions'=>array('Ligneinventaire.inventaire_id' => $id)
                    ));
                   
                $articles=$this->Article->find('list');
		$depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('depots','articles','ligneinvents','day'));
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
               $inventaire="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='inventaires'){
                        $inventaire=$liens['delete'];
                }}}
              if (( $inventaire <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Stockdepot');      
             $this->loadModel('Ligneinventaire');
		$this->Inventaire->id = $id;
		if (!$this->Inventaire->exists()) {
			throw new NotFoundException(__('Invalid inventaire'));
		}
		$this->request->onlyAllow('post', 'delete');
                
                        //  $inventaire=$this->Inventaire->find('first',array('conditions'=>array('Inventaire.id' => $id)));
                        //  $depotid=$inventaire['Inventaire']['depot_id'];
                        //  $this->Stockdepot->deleteAll(array('Stockdepot.depot_id'=>$depotid),false); 
                                    
                 $req_inventaire_ligneinvs=$this->Ligneinventaire->find('all',array('conditions'=>array('Ligneinventaire.inventaire_id'=>$id)));
                 
                    foreach ($req_inventaire_ligneinvs as $req_inventaire_ligneinv){
                       
                        foreach ($req_inventaire_ligneinv['Ligneinventaire'] as $li){
                            // debug($li);die;
                            $this->Ligneinventaire->deleteAll(array('Ligneinventaire.id'=>$li),false);
                        }
                    }
                
		if ($this->Inventaire->delete()) {
			$this->Session->setFlash(__('Inventaire deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Inventaire was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        public function imprimerrecherche() { 
         $lien=  CakeSession::read('lien_stock');
               $inventaire="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='inventaires'){
                        $inventaire=$liens['imprimer'];
                }}}
              if (( $inventaire <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
       $this->loadModel('Depot');       
     
       //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Inventaire.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Inventaire.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['depotid']) {
            $depotid = $this->request->query['depotid'];
            $cond3 = 'Inventaire.depot_id ='.$depotid;
        } 
         
  $inventaires = $this->Inventaire->find('all', array( 'conditions' => array('Inventaire.id > ' => 0, @$cond1, @$cond2, @$cond3 )));

   //debug($commandes);die;
                 $this->set(compact('inventaires','date1','date2','depotid'));     
   
         }
}
