<?php
App::uses('AppController', 'Controller');
/**
 * Transferts Controller
 *
 * @property Transfert $Transfert
 */
class TransfertsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	
        
        public function index() {
	$lien=  CakeSession::read('lien_stock');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='transferts'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }	
	
       $this->loadModel('Exercice');
       $this->loadModel('Depot');
       
       $exercices = $this->Exercice->find('list');
       $depots = $this->Depot->find('list');
       $exe=date('Y');
       $exercice = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
       $exerciceid=$exercice['Exercice']['id'];
       $condb4 = 'Transfert.exercice_id ='.$exe;
        
        if ($this->request->is('post')) { 
        //debug($this->request->data);die;
        if ($this->request->data['Recherche']['exercice_id']) {
            $exerciceid = $this->request->data['Recherche']['exercice_id'];
            $condb4 = 'Transfert.exercice_id ='.$exercices[$exerciceid];
        }     
            
        if ($this->request->data['Recherche']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            $condb1 = 'Transfert.date >= '."'".$date1."'";
            $condb4="";
        }
        
        if ($this->request->data['Recherche']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
            $condb2 = 'Transfert.date <= '."'".$date2."'";
            $condb4="";
        }
        
        if ($this->request->data['Recherche']['depot_id']) {
            $depotid = $this->request->data['Recherche']['depot_id'];
            $condb3 = 'Transfert.depotarrive ='.$depotid;
        } 
        
        
        
        
    } 
    $transferts = $this->Transfert->find('all', array(
    'conditions' => array('Transfert.id > ' => 0, @$condb1, @$condb2, @$condb3, @$condb4)
    ));

      
		
    $this->set(compact('transferts','exerciceid','exercices','date1','date2','depots','depotid',$this->paginate()));

	}

        
         public function imprimerrecherche() { 
        $lien=  CakeSession::read('lien_stock');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='transferts'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   } 
      
       //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Transfert.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Transfert.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['depotid']) {
            $depotid = $this->request->query['depotid'];
            $cond3 = 'Transfert.depotarrive ='.$depotid;
        } 
         if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $cond4 = 'Transfert.exercice_id ='.$exerciceid;
        } 
        $transferts = $this->Transfert->find('all', array(
    'conditions' => array('Transfert.id > ' => 0, @$condb1, @$condb2, @$condb3, @$condb4)
    )); 
        $this->loadModel('Depot');
       $depots = $this->Depot->find('list');

                 $this->set(compact('transferts','date1','date2','depotid','exerciceid','depots'));     
   
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
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='transferts'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Transfert->exists($id)) {
			throw new NotFoundException(__('Invalid transfert'));
		}
		$options = array('conditions' => array('Transfert.' . $this->Transfert->primaryKey => $id));
		$this->set('transfert', $this->Transfert->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
            $lien=  CakeSession::read('lien_stock');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='transferts'){
                        $vente=$liens['add'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Stockdepot');
            $this->loadModel('Lignetransfert');
		if ($this->request->is('post')) {
                  //  debug($this->request->data);die;
                    
                    $this->request->data['Transfert']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Transfert']['date'])));
			$this->request->data['Transfert']['utilisateur_id']= CakeSession::read('users'); 
                        $this->request->data['Transfert']['exercice_id']=date("Y");
                    
                    
                    
			$this->Transfert->create();
			if ($this->Transfert->save($this->request->data)) {
                            
                        //$depotdepart=$this->request->data['Transfert']['depotdepart'];
                        $depotarrive=$this->request->data['Transfert']['depotarrive'];
                            $id=$this->Transfert->id;
                        
                             $Lignetransferts=array();
                              $stockdepots=array(); 
                              foreach (  $this->request->data['Lignetransfert'] as $numl=>$f   ){
                                  
                              if ($f['sup']!=1){
                                $Lignetransferts['depot_id']=$f['depot_id'];  
                                $Lignetransferts['article_id']=$f['article_id'];
                                $Lignetransferts['quantite']=$f['quantite'];
                                $Lignetransferts['transfert_id']=$id;
                                 $this->Lignetransfert->create();
                                 $this->Lignetransfert->save($Lignetransferts); 
                            
                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$f['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                            
                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$depotarrive),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']+$f['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }else{
                                        $array=array();
                                        $array['article_id']=$f['article_id'];
                                        $array['depot_id']=$depotarrive;
                                        $array['quantite']=$f['quantite'];
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($array); 
                                   
                                   }
                            
                              }}
                            
				$this->Session->setFlash(__('The transfert has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transfert could not be saved. Please, try again.'));
			}
		}
                 $numero = $this->Transfert->find('all', array('fields' =>
            array(
                'MAX(Transfert.numero) as num'
                )));
       // debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
            if (!empty($n)) {
     $commande=$this->Transfert->find('all', array( 'conditions' => array('Transfert.numero'=>$n),'recursive'=>-1)) ; 
     //debug($commande);die;
          if($commande[0]['Transfert']['exercice_id']==date('Y')){      
     $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
          }  else {
              $mm = "000001";
          }
            } else {
                $mm = "000001";
            }
        } 
                $this->loadModel('Article');
                $this->loadModel('Depot');
               // $articles = $this->Article->find('list');
                $depots = $this->Depot->find('list');
               
              
                $depotarrives = $this->Depot->find('list');
		$utilisateurs = $this->Transfert->Utilisateur->find('list');
		$this->set(compact('utilisateurs','articles','depots','depotarrives','mm'));
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
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='transferts'){
                        $vente=$liens['edit'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Stockdepot');
            $this->loadModel('Lignetransfert');
		if (!$this->Transfert->exists($id)) {
			throw new NotFoundException(__('Invalid transfert'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                   // debug($this->request->data);die;
                    $this->request->data['Transfert']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Transfert']['date'])));
			$this->request->data['Transfert']['utilisateur_id']= CakeSession::read('users'); 
                        $this->request->data['Transfert']['exercice_id']=date("Y");
                    
			if ($this->Transfert->save($this->request->data)) {
                            
                       
                           $tansfert= $this->Transfert->find('first',array('conditions'=>array('Transfert.id'=>$id),false));
                           $depotarrive=$tansfert['Transfert']['depotarrive'];
                           $lignetransfets= $this->Lignetransfert->find('all',array('conditions'=>array('Lignetransfert.transfert_id'=>$id),false));
                           //debug($tansfert);die;
                           foreach (  $lignetransfets as $lra   ){
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite-'.$lra['Lignetransfert']['quantite']), array('Stockdepot.article_id' =>$lra['Lignetransfert']['article_id'],'Stockdepot.depot_id' =>$depotarrive));
                            
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+'.$lra['Lignetransfert']['quantite']), array('Stockdepot.article_id' =>$lra['Lignetransfert']['article_id'],'Stockdepot.depot_id' =>$lra['Lignetransfert']['depot_id']));
                           } 
                           //$this->Stockdepot->deleteAll(array('Stockdepot.quantite'=>0),false);
                           $this->Lignetransfert->deleteAll(array('Lignetransfert.transfert_id'=>$id),false);     
                            
                            $Lignetransferts=array();
                              $stockdepots=array(); 
                              foreach (  $this->request->data['Lignetransfert'] as $numl=>$f   ){
                                  
                              if ($f['sup']!=1){
                                $Lignetransferts['depot_id']=$f['depot_id'];  
                                $Lignetransferts['article_id']=$f['article_id'];
                                $Lignetransferts['quantite']=$f['quantite'];
                                $Lignetransferts['transfert_id']=$id;
                                 $this->Lignetransfert->create();
                                 $this->Lignetransfert->save($Lignetransferts); 
                            
                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$f['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                            
                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$depotarrive),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']+$f['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }else{
                                        $array=array();
                                        $array['article_id']=$f['article_id'];
                                        $array['depot_id']=$depotarrive;
                                        $array['quantite']=$f['quantite'];
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($array); 
                                   
                                   }
                            
                              }}
				$this->Session->setFlash(__('The transfert has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transfert could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Transfert.' . $this->Transfert->primaryKey => $id));
			$this->request->data = $this->Transfert->find('first', $options);
		}
		$this->loadModel('Article');
                $this->loadModel('Depot');
                $transferts = $this->Transfert->find('first',array('conditions'=>array('Transfert.id' => $id)));
                $lignetransferts = $this->Lignetransfert->find('all',array('conditions'=>array('Lignetransfert.transfert_id' => $id),'recursive'=>-1));
                //debug($lignetransferts);
                $tabt=array();
                $tabqte=array();
                foreach ($lignetransferts as $i=>$lignetransfert){
                $stckdepotqte= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.depot_id'=>$lignetransfert['Lignetransfert']['depot_id'],'Stockdepot.article_id'=>$lignetransfert['Lignetransfert']['article_id']),'recursive'=>-1));
                //debug($stckdepotqte);die;
                
                foreach ($stckdepotqte as $q=>$qte){
                $tabqte[$i]=$qte['Stockdepot']['quantite'];
                //debug($tabqte);
                }
                $articless= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.depot_id'=>$lignetransfert['Lignetransfert']['depot_id']),'recursive'=>-1));
                //debug($articless);
                $t='(0,';
                      foreach ($articless as $ad){
                          if(!empty($ad['Stockdepot']['article_id'])){
                         $a=''.$ad['Stockdepot']['article_id'];
                            if( !strstr($t, $a)) { 
                          $t=$t.$ad['Stockdepot']['article_id'].',';
                            }
                      }}
                      $t=$t.'0)';
                $tabt[$i]=$t;      
                      
                      
                   //debug($t);
                   
                   
               // $articles=$this->Article->find('list', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
                
                      
                }
                //debug($tabt);die;
                //debug($tabqte);
                $depots = $this->Depot->find('list');
                $depotarrives = $this->Depot->find('list');
		$utilisateurs = $this->Transfert->Utilisateur->find('list');
		$this->set(compact('tabqte','tabt','articless','articles','utilisateurs','articles','depots','depotarrives','mm','transferts','lignetransferts'));
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
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='transferts'){
                        $vente=$liens['delete'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Stockdepot');
            $this->loadModel('Lignetransfert');
		$this->Transfert->id = $id;
		if (!$this->Transfert->exists()) {
			throw new NotFoundException(__('Invalid transfert'));
		}
                $tansfert= $this->Transfert->find('first',array('conditions'=>array('Transfert.id'=>$id),false));
                           $depotarrive=$tansfert['Transfert']['depotarrive'];
                           $lignetransfets= $this->Lignetransfert->find('all',array('conditions'=>array('Lignetransfert.transfert_id'=>$id),false));
                           //debug($tansfert);die;
                           foreach (  $lignetransfets as $lra   ){
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite-'.$lra['Lignetransfert']['quantite']), array('Stockdepot.article_id' =>$lra['Lignetransfert']['article_id'],'Stockdepot.depot_id' =>$depotarrive));
                            
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+'.$lra['Lignetransfert']['quantite']), array('Stockdepot.article_id' =>$lra['Lignetransfert']['article_id'],'Stockdepot.depot_id' =>$lra['Lignetransfert']['depot_id']));
                           } 
                           //$this->Stockdepot->deleteAll(array('Stockdepot.quantite'=>0),false);
                           $this->Lignetransfert->deleteAll(array('Lignetransfert.transfert_id'=>$id),false);
                           
		$this->request->onlyAllow('post', 'delete');
		if ($this->Transfert->delete()) {
			$this->Session->setFlash(__('Transfert deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transfert was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
     public function stockdepot(){
     $this->layout = null;
              $this->loadModel('Article');
              $this->loadModel('Stockdepot');
             
           
         $data = $this->request->data;
        // debug($data);
         $json = null;
      $depotid= $data['id'];
      $index= $data['index'];
    // $index=$data['index']; 
       $name='article_id';
        $artdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.depot_id'=>$depotid),'recursive'=>-1));
     // debug($fourdevises);
      $t='(0,';
            foreach ($artdepot as $ad){
                if(!empty($ad['Stockdepot']['article_id'])){
               $a=''.$ad['Stockdepot']['article_id'];
                  if( !strstr($t, $a)) { 
                $t=$t.$ad['Stockdepot']['article_id'].',';
                  }
                }
            }
            $t=$t.'0)';
         //debug($t);
             $id='article_id';
             if ($depotid != 0) { 
            $articles=$this->Article->find('all', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
            $select="<select   name='data[Lignetransfert][".$index."][article_id]' table='Lignetransfert'  champ='article_id' id=article_id".$index." class='select form-control' onchange='qteart($index)'>";
            $select=$select."<option value=''>"."choix"."</option>";
            foreach($articles as $v){
                $select=$select."<option value=".$v['Article']['id'].">".$v['Article']['name']."</option>";
            }
            $select=$select.'</select>';
          
             }
             else{
                 $articles=$this->Article->find('all') ;
            $select="<select name='' champ='article_id' id=article_id".$index."  class='' onchange='qteart('.$index.')'>";
            $select=$select."<option value=''>"."choix"."</option>";
            foreach($articles as $v){
                $select=$select."<option value=".$v['Article']['id'].">".$v['Article']['name']."</option>";
            }
            $select=$select.'</select>';
       
             }

             echo json_encode(array('select'=>$select));
          die();
  }      
      
public function imprimer($id=NULL) { 
    $lien=  CakeSession::read('lien_stock');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='transferts'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
      $this->loadModel('Depot');        
      $this->loadModel('Lignetransfert');
                $transfers = $this->Transfert->find('first',array('conditions'=>array('Transfert.id'=>$id),'recursive'=>0));
               // debug($bonreceptions);die;
                $listelignetransfert = $this->Lignetransfert->find('all',array('conditions'=>array('Lignetransfert.transfert_id' => $id)));
               //debug($listelignetransfert);die;
                 $depotdeparts = $this->Depot->find('list');
                $this->set(compact('listelignetransfert','transfers','depotdeparts'));
       

   
         }     

  
}
