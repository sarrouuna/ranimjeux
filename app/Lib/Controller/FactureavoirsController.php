<?php
App::uses('AppController', 'Controller');
/**
 * Factureavoirs Controller
 *
 * @property Factureavoir $Factureavoir
 */
class FactureavoirsController extends AppController {

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
                if(@$liens['lien']=='factureavoirs'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Factureavoir->recursive = 0;
		$this->set('factureavoirs', $this->paginate());
                 $this->loadModel('Client');  
                 $this->loadModel('Typefacture');
                  $this->loadModel('Exercice'); 
                  $this->loadModel('Pointdevente');
        $pointdeventes = $this->Pointdevente->find('list');
       $exercices = $this->Exercice->find('list');
        $exe=date('Y');
       $exercice = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
       $exerciceid=$exercice['Exercice']['id'];
        $cond5 = 'Factureavoir.exercice_id ='.$exe;
         $pv="";
       $p=CakeSession::read('pointdevente');
       if($p>0){
          $pv= 'Factureavoir.pointdevente_id = '.$p;
       }
                 
         if (isset($this->request->data) && !empty($this->request->data)) {
        //debug($this->request->data);die;
        if ($this->request->data['Factureavoir']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoir']['date1'])));
            $cond1 = 'Factureavoir.date >= '."'".$date1."'";
            $cond5="";
        }
        
        if ($this->request->data['Factureavoir']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoir']['date2'])));
            $cond2 = 'Factureavoir.date <= '."'".$date2."'";
            $cond5="";
        }
        
       if (!empty($this->request->data['Factureavoir']['client_id'])) {
            $clientid= $this->request->data['Factureavoir']['client_id'];
            $cond3 = 'Factureavoir.client_id ='.$clientid;
        } 
         if (!empty($this->request->data['Factureavoir']['typefacture_id'])) {
            $typefactureid= $this->request->data['Factureavoir']['typefacture_id'];
            $cond4 = 'Factureavoir.typefacture_id ='.$typefactureid;
        } 
        if (!empty($this->request->data['Factureavoir']['exercice_id'])) {
            $exerciceid = $this->request->data['Factureavoir']['exercice_id'];
            $cond5 = 'Factureavoir.exercice_id ='.$exercices[$exerciceid];
        }
        if (!empty($this->request->data['Factureavoir']['pointdevente_id'])) {
            $pointdeventeid = $this->request->data['Factureavoir']['pointdevente_id'];
            $cond6 = 'Factureavoir.pointdevente_id ='.$pointdeventeid;
        } 
        
        
    } 
  $factureavoirs = $this->Factureavoir->find('all', array( 'conditions' => array('Factureavoir.id > '=>0,@$pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6 )));
  //debug($factureavoirs);       
		
                $clients = $this->Client->find('list');
                $typefactures = $this->Typefacture->find('list');
                $this->set(compact('pointdeventes','exerciceid','exercices','date1','date2','clientid','clients','typefactures','factureavoirs',$this->paginate()));

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
                if(@$liens['lien']=='factureavoirs'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Lignefactureavoir');
             $this->loadModel('Typefacture');
		if (!$this->Factureavoir->exists($id)) {
			throw new NotFoundException(__('Invalid factureavoir'));
		}
		$options = array('conditions' => array('Factureavoir.' . $this->Factureavoir->primaryKey => $id));
		$this->set('factureavoir', $this->Factureavoir->find('first', $options));
                $factureavoir=$this->Factureavoir->find('first',array('conditions'=>array('Factureavoir.id' => $id)));
                 $typefacture=$factureavoir['Factureavoir']['typefacture_id'];
                if($typefacture==1){
                $Lignefactureavoirs = $this->Lignefactureavoir->find('all',array('conditions'=>array('Lignefactureavoir.factureavoir_id' => $id)));
                }
		$this->set(compact('Lignefactureavoirs','typefacture'));
	}

        public function imprimerfavr($id = null) {
             $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factureavoirs'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Lignefactureavoir');
             $this->loadModel('Typefacture');
		if (!$this->Factureavoir->exists($id)) {
			throw new NotFoundException(__('Invalid factureavoir'));
		}
		$options = array('conditions' => array('Factureavoir.' . $this->Factureavoir->primaryKey => $id));
		$this->set('factureavoir', $this->Factureavoir->find('first', $options));
                $factureavoir=$this->Factureavoir->find('first',array('conditions'=>array('Factureavoir.id' => $id)));
                 $typefacture=$factureavoir['Factureavoir']['typefacture_id'];
                if($typefacture==1){
                $Lignefactureavoirs = $this->Lignefactureavoir->find('all',array('conditions'=>array('Lignefactureavoir.factureavoir_id' => $id)));
                }
		$this->set(compact('Lignefactureavoirs','typefacture'));
	}
         public function imprimerfavf($id = null) {
            $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factureavoirs'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Factureavoir->exists($id)) {
			throw new NotFoundException(__('Invalid factureavoir'));
		}
		$options = array('conditions' => array('Factureavoir.' . $this->Factureavoir->primaryKey => $id));
		$this->set('factureavoir', $this->Factureavoir->find('first', $options));
                
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
                if(@$liens['lien']=='factureavoirs'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Article');
            $this->loadModel('Depot');
            $this->loadModel('Stockdepot');
            $this->loadModel('Utilisateur');
            $this->loadModel('Lignefactureavoir');
             $this->loadModel('Factureclient');
            $this->loadModel('Pointdevente');
		if ($this->request->is('post')) {
                   // debug($this->request->data);die;
                     $this->request->data['Factureavoir']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Factureavoir']['date'])));
	             $this->request->data['Factureavoir']['utilisateur_id']= CakeSession::read('users');
                     $this->request->data['Factureavoir']['typefacture_id']=2;//modifier 19/04/2016
                     $this->request->data['Factureavoir']['factureclient_id']=$this->request->data['factureclient_id'];//modifier 19/04/2016
                     if($this->request->data['Factureavoir']['typefacture_id']==2){
                        $this->request->data['Factureavoir']['totalttc']=$this->request->data['Factureavoir']['totalttc']+0.500;         
                             }
                        if(empty($this->request->data['Factureavoir']['pointdevente_id'])){
                        $this->request->data['Factureavoir']['pointdevente_id']= CakeSession::read('pointdevente');
                        }
                        $this->request->data['Factureavoir']['exercice_id']=date("Y");

         $pv= CakeSession::read('pointdevente'); 
          if($pv==0) {
          $pv=$this->request->data['Factureavoir']['pointdevente_id'];   
         }
         $numero = $this->Factureavoir->find('all',
         array('fields' =>array('MAX(Factureavoir.numeroconca) as num'),
          'conditions' => array('Factureavoir.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
   $getexercice= $this->Factureavoir->find('first',array('conditions'=>array('Factureavoir.numeroconca'=>$n)));
  $anne=$getexercice['Factureavoir']['exercice_id'];  
       if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            }
           else {
                $mm = "000001";
            }  
            
        }else {
                $mm = "000001";
            }
                $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
                      
                        $this->request->data['Factureavoir']['numeroconca']=$mm;
                        $this->request->data['Factureavoir']['numero']=$numspecial;
                        
                    
			$this->Factureavoir->create();
			if ($this->Factureavoir->save($this->request->data)) {
                             $id=$this->Factureavoir->id;
                            $this->Factureclient->updateAll(array('Factureclient.factureavoir_id' => $id), array('Factureclient.id' =>$this->request->data['factureclient_id']));
                          
                              $Lignefactureavoirs=array();
                               $stockdepots=array();
                              if(isset($this->request->data['Lignefactureavoir'])){
                              foreach (  $this->request->data['Lignefactureavoir'] as $i=>$f   ){ 
                                 //  debug($f);die;
                              if ($f['sup']!=1){                                  
                                $Lignefactureavoirs['factureavoir_id']=$id;  
       $stockdepots['depot_id']=$Lignefactureavoirs['depot_id']=$f['depot_id'];
     $stockdepots['article_id']=$Lignefactureavoirs['article_id']= $f['article_id'];
      $stockdepots['quantite']= $Lignefactureavoirs['quantite']=$f['quantite'];
          $stockdepots['date']= $Lignefactureavoirs['datevalidite']=date("Y-m-d",strtotime(str_replace('/','-',$f['datevalidite'])));                                                             
                                $Lignefactureavoirs['remise']=$f['remise'];
                                $Lignefactureavoirs['tva']=$f['tva'];
                                $Lignefactureavoirs['prix']=$f['prixhtva'];
                                $Lignefactureavoirs['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignefactureavoirs['totalttc']=((($Lignefactureavoirs['totalht']))*(1+($f['tva']*0.01)));  
                                     $this->Lignefactureavoir->create();
                                     $this->Lignefactureavoir->save($Lignefactureavoirs);  
                                     //  debug($stockdepots);die;
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$stockdepots['article_id'],'Stockdepot.depot_id'=>$f['depot_id'],'Stockdepot.date'=> $stockdepots['date']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots['quantite']= $stockdepots['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }else{
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($stockdepots); 
                                   }
                                $this->Stockdepot->deleteAll(array('Stockdepot.article_id'=>$stockdepots['article_id'],'Stockdepot.depot_id'=>$f['depot_id'],'Stockdepot.quantite'=>0),false);    
                              
                              }
                              } }
				$this->Session->setFlash(__('The factureavoir has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The factureavoir could not be saved. Please, try again.'));
			}
		}
        $pv= CakeSession::read('pointdevente');
       // debug($pv);
          if($pv!=0) {
         $numero = $this->Factureavoir->find('all',
         array('fields' =>array('MAX(Factureavoir.numeroconca) as num'),
          'conditions' => array('Factureavoir.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
   $getexercice= $this->Factureavoir->find('first',array('conditions'=>array('Factureavoir.numeroconca'=>$n)));
  $anne=$getexercice['Factureavoir']['exercice_id'];  
  if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            }
           else {
                $mm = "000001";
            }  
            
        }else {
                $mm = "000001";
            }
        
                $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
         }else{
             $mm=0;
         }
            //debug($numspecial);  
         
                $articles = $this->Article->find('list');        
		$clients = $this->Factureavoir->Client->find('list');
		$utilisateurs = $this->Factureavoir->Utilisateur->find('list');
		$depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$typefactures = $this->Factureavoir->Typefacture->find('list');
                $timbre = $this->Factureavoir->Timbre->find('list',array('fields' => array('Timbre.timbre')));
                $pointdeventes=$this->Pointdevente->find('list');
		$this->set(compact('pointdeventes','numspecial','clients', 'utilisateurs','timbre', 'depots', 'typefactures','mm','articles'));
	}
         public function addfactureavoir() {
             $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factureavoirs'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Factureavoir');      
            $this->loadModel('Article');
            $this->loadModel('Stockdepot');
            $this->loadModel('Depot');
            $this->loadModel('Utilisateur');
            $this->loadModel('Lignefactureavoir');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Factureclient');
            $this->loadModel('Pointdevente');
		if ($this->request->is('post')) {
                    //debug($this->request->data);die;
                     $this->request->data['Factureavoir']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Factureavoir']['date'])));
	             $this->request->data['Factureavoir']['utilisateur_id']= CakeSession::read('users');
                     //$this->request->data['Factureavoir']['typefacture_id']=2;//modifier 19/04/2016
                     if($this->request->data['Factureavoir']['typefacture_id']==2){
                        $this->request->data['Factureavoir']['totalttc']=$this->request->data['Factureavoir']['totalttc']+0.500;         
                             }
                         if(empty($this->request->data['Factureavoir']['pointdevente_id'])){
                        $this->request->data['Factureavoir']['pointdevente_id']= CakeSession::read('pointdevente');
                        }
                    $this->request->data['Factureavoir']['exercice_id']=date("Y");
                        
         $pv= CakeSession::read('pointdevente'); 
         if($pv==0) {
          $pv=$this->request->data['Factureavoir']['pointdevente_id'];   
         }
         $numero = $this->Factureavoir->find('all',
         array('fields' =>array('MAX(Factureavoir.numeroconca) as num'),
          'conditions' => array('Factureavoir.pointdevente_id'=>$pv))
         );
        foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
   $getexercice= $this->Factureavoir->find('first',array('conditions'=>array('Factureavoir.numeroconca'=>$n)));
  $anne=$getexercice['Factureavoir']['exercice_id'];  
       if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            }
           else {
                $mm = "000001";
            }  
            
        }else {
                $mm = "000001";
            }
        
                        
                $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
                        
                        $this->request->data['Factureavoir']['numeroconca']=$mm;
                        $this->request->data['Factureavoir']['numero']=$numspecial;
        
			$this->Factureavoir->create();
			if ($this->Factureavoir->save($this->request->data)) {
                             $id=$this->Factureavoir->id;
                          
                              $Lignefactureavoirs=array();
                              $stockdepots=array();
                              if(isset($this->request->data['Lignefactureclient'])){
                              foreach (  $this->request->data['Lignefactureclient'] as $numl=>$f   ){ 
                                 //  debug($f);die;
                              if ($f['sup']!=1){     
                                $stockdepots[$numl]['depot_id']=$f['depot_id'];              
                                $stockdepots[$numl]['article_id']=$f['article_id'];
                                $stockdepots[$numl]['quantite']=$f['quantite'];
                                $Lignefactureavoirs['factureavoir_id']=$id;  
                                $Lignefactureavoirs['depot_id']=$f['depot_id'];
                                $Lignefactureavoirs['article_id']= $f['article_id'];
                                $Lignefactureavoirs['quantite']=$f['quantite'];
                                $Lignefactureavoirs['remise']=$f['remise'];
                                $Lignefactureavoirs['tva']=$f['tva'];
                                $Lignefactureavoirs['prix']=$f['prixhtva'];
                                $Lignefactureavoirs['prixnet']=$f['prixnet'];
                                $Lignefactureavoirs['puttc']=$f['puttc'];
                                $Lignefactureavoirs['totalhtans']=$f['totalhtans'];
                                $Lignefactureavoirs['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignefactureavoirs['totalttc']=((($Lignefactureavoirs['totalht']))*(1+($f['tva']*0.01)));  
                                     $this->Lignefactureavoir->create();
                                     $this->Lignefactureavoir->save($Lignefactureavoirs);  
                                     
                                     $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$stockdepots[$numl]['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']= $stockdepots[$numl]['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }else{
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($stockdepots[$numl]); 
                                   }
                                   
                             
                             
                                $this->Stockdepot->deleteAll(array('Stockdepot.article_id'=>$stockdepots[$numl]['article_id'],'Stockdepot.depot_id'=>$stockdepots[$numl]['depot_id'],'Stockdepot.quantite'=>0),false);    
                              }
                              } }
				$this->Session->setFlash(__('The factureavoir has been saved'));
                               // $this->redirect(array('controller' => 'bonentres','action' => 'add/'.$id));
                                $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The factureavoir could not be saved. Please, try again.'));
			}
		}
         $pv= CakeSession::read('pointdevente'); 
          if($pv!=0) {
         $numero = $this->Factureavoir->find('all',
         array('fields' =>array('MAX(Factureavoir.numeroconca) as num'),
          'conditions' => array('Factureavoir.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
   $getexercice= $this->Factureavoir->find('first',array('conditions'=>array('Factureavoir.numeroconca'=>$n)));
  $anne=$getexercice['Factureavoir']['exercice_id'];  
  if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            }
           else {
                $mm = "000001";
            }  
            
        }else {
                $mm = "000001";
            }
        
                $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
           }else{
             $mm=0;
         }     
            
                $articles = $this->Article->find('list');        
		$clients = $this->Factureavoir->Client->find('list');
		$utilisateurs = $this->Factureavoir->Utilisateur->find('list');
		$depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$typefactures = $this->Factureavoir->Typefacture->find('list');
                $timbre = $this->Factureavoir->Timbre->find('list',array('fields' => array('Timbre.timbre')));
                $pointdeventes=$this->Pointdevente->find('list');
		$this->set(compact('pointdeventes','numspecial','clients', 'utilisateurs','timbre', 'depots', 'typefactures','mm','articles','lignefactureclients','Factureclient'));
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
                if(@$liens['lien']=='factureavoirs'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Article');
            $this->loadModel('Depot');
            $this->loadModel('Stockdepot');
            $this->loadModel('Lignefactureavoir');
            $this->loadModel('Factureclient');
		if (!$this->Factureavoir->exists($id)) {
			throw new NotFoundException(__('Invalid factureavoir'));
		}
                $Factureavoirs = $this->Factureavoir->find('first',array('conditions'=>array('Factureavoir.id' => $id),'recursive'=>-1));
                //debug($Factureavoirs['Factureavoir']['factureclient_id']);
		if ($this->request->is('post') || $this->request->is('put')) {
                // debug( $this->request->data);die;
                  $this->request->data['Factureavoir']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Factureavoir']['date'])));
	          $this->request->data['Factureavoir']['utilisateur_id']= CakeSession::read('users');
                 // $this->request->data['Factureavoir']['typefacture_id']=2;//modifier 19/04/2016
                  if ($this->Factureavoir->save($this->request->data)) {
                      if( $this->request->data['Factureavoir']['factureclient_id']!=$Factureavoirs['Factureavoir']['factureclient_id']){
                       $this->Factureclient->updateAll(array('Factureclient.factureavoir_id' => 0), array('Factureclient.id' =>$Factureavoirs['Factureavoir']['factureclient_id']));/////98*98
                       $this->Factureclient->updateAll(array('Factureclient.factureavoir_id' => $id), array('Factureclient.id' => $this->request->data['Factureavoir']['factureclient_id']));/////98*98
                       }
                      $typefacture=$this->request->data['Factureavoir']['typefacture_id'];
                        if($typefacture==1){
                $Lignefactureavoirs = $this->Lignefactureavoir->find('all',array('conditions'=>array('Lignefactureavoir.factureavoir_id' => $id)));
     //*************retablir le stockdepot dans l'etat  avant l'ajout de facture a voir retour ***********************************************************
                    $stkdepots=array();
                    foreach (  $Lignefactureavoirs as $l=>$f   ){ 
                    $stkdepots[$l]['ancdepot_id']=$f['Lignefactureavoir']['depot_id'];
                    $stkdepots[$l]['ancarticle_id']=$f['Lignefactureavoir']['article_id'];
                    $stkdepots[$l]['ancquantite']=$f['Lignefactureavoir']['quantite'];
                   // $stkdepots[$l]['ancdate']=$f['Lignefactureavoir']['datevalidite'];  
                    }
                $this->Lignefactureavoir->deleteAll(array('Lignefactureavoir.factureavoir_id'=>$id),false); 
                                foreach (  $stkdepots as $i=>$stockdepots   ){ 
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$stockdepots['ancarticle_id'],'Stockdepot.depot_id'=>$stockdepots['ancdepot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots['ancquantite']= $stckdepot[0]['Stockdepot']['quantite']-$stockdepots['ancquantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots['ancquantite']), array('Stockdepot.article_id'=>$stockdepots['ancarticle_id'],'Stockdepot.depot_id'=>$stockdepots['ancdepot_id']));
                                   }
                                //$this->Stockdepot->deleteAll(array('Stockdepot.article_id'=>$stockdepots['ancarticle_id'],'Stockdepot.depot_id'=>$f['ancdepot_id'],'Stockdepot.quantite'=>0),false);    
                                }
                        $Lignefactureavoirs=array();
                        $stockdepots=array();
                        foreach (  $this->request->data['Lignefactureavoir'] as $numl=>$f   ){ 
                              if ($f['sup']!=1){                                  
                                $Lignefactureavoirs['factureavoir_id']=$id; 
                                $stockdepots[$numl]['depot_id']=$f['depot_id'];              
                                $stockdepots[$numl]['article_id']=$f['article_id'];
                                $stockdepots[$numl]['quantite']=$f['quantite'];
                                $Lignefactureavoirs['depot_id']=$f['depot_id'];
                                $Lignefactureavoirs['article_id']= $f['article_id'];
                                $Lignefactureavoirs['quantite']=$f['quantite'];
                                //$stockdepots['date']= $Lignefactureavoirs['datevalidite']=date("Y-m-d",strtotime(str_replace('/','-',$f['datevalidite'])));                                                             
                                $Lignefactureavoirs['remise']=$f['remise'];
                                $Lignefactureavoirs['tva']=$f['tva'];
                                $Lignefactureavoirs['prix']=$f['prix'];
                                $Lignefactureavoirs['totalht']=($f['prix']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignefactureavoirs['totalttc']=((($Lignefactureavoirs['totalht']))*(1+($f['tva']*0.01)));  
                                     $this->Lignefactureavoir->create();
                                     $this->Lignefactureavoir->save($Lignefactureavoirs);  
                                
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$stockdepots[$numl]['article_id'],'Stockdepot.depot_id'=>$stockdepots[$numl]['depot_id']),false)); 
                               // debug($stckdepot);die;
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']= $stockdepots[$numl]['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }else{
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($stockdepots[$numl]); 
                                   }
                                   
                             
                             
                                $this->Stockdepot->deleteAll(array('Stockdepot.article_id'=>$stockdepots[$numl]['article_id'],'Stockdepot.depot_id'=>$stockdepots[$numl]['depot_id'],'Stockdepot.quantite'=>0),false);    
                              }
                              } 
                      
                      }
                      
                      
                      
				$this->Session->setFlash(__('The factureavoir has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The factureavoir could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Factureavoir.' . $this->Factureavoir->primaryKey => $id));
			$this->request->data = $this->Factureavoir->find('first', $options);
		}
                  $typefacture=$this->request->data['Factureavoir']['typefacture_id'];
                if($typefacture==1){
                $Lignefactureavoirs = $this->Lignefactureavoir->find('all',array('conditions'=>array('Lignefactureavoir.factureavoir_id' => $id)));
                }
                $date=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Factureavoir']['date'])));
                $articles = $this->Article->find('list');
		$clients = $this->Factureavoir->Client->find('list');
		$utilisateurs = $this->Factureavoir->Utilisateur->find('list');
		$depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$typefactures = $this->Factureavoir->Typefacture->find('list');
                $timbre = $this->Factureavoir->Timbre->find('list',array('fields' => array('Timbre.timbre')));
                $factureclient=$this->request->data['Factureavoir']['factureclient_id'];
                $factureclients=$this->Factureclient->find('all', array( 'conditions' => array('Factureclient.client_id'=>$this->request->data['Factureavoir']['client_id'],('(Factureclient.factureavoir_id=0 or Factureclient.factureavoir_id='.$id.')')),'recursive'=>-1)) ;//19/04/2016
		$this->set(compact('clients','articles', 'utilisateurs','timbre', 'depots', 'typefactures','Lignefactureavoirs','date','typefacture','factureclients','factureclient'));
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
                if(@$liens['lien']=='factureavoirs'){
                        $x=$liens['delete'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Lignefactureavoir');
             $this->loadModel('Stockdepot');
             $this->loadModel('Factureclient');
             
		$this->Factureavoir->id = $id;
		if (!$this->Factureavoir->exists()) {
			throw new NotFoundException(__('Invalid factureavoir'));
		}
		$this->request->onlyAllow('post', 'delete');
                
                $lfavs=$this->Lignefactureavoir->find('all',array('conditions'=>array('Lignefactureavoir.factureavoir_id'=>$id),false)); 
                 //debug($lfavs);die;
                   foreach (  $lfavs as $i=>$lfav  ){ 
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$lfav['Lignefactureavoir']['article_id'],'Stockdepot.depot_id'=>$lfav['Lignefactureavoir']['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $lfav['Lignefactureavoir']['quantite']= $stckdepot[0]['Stockdepot']['quantite']-$lfav['Lignefactureavoir']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $lfav['Lignefactureavoir']['quantite']), array('Stockdepot.article_id'=>$lfav['Lignefactureavoir']['article_id'],'Stockdepot.depot_id'=>$lfav['Lignefactureavoir']['depot_id']));
                                   }
                                $this->Stockdepot->deleteAll(array('Stockdepot.article_id'=>$lfav['Lignefactureavoir']['article_id'],'Stockdepot.depot_id'=>$lfav['Lignefactureavoir']['depot_id'],'Stockdepot.quantite'=>0),false);    
                                }
                 $this->Lignefactureavoir->deleteAll(array('Lignefactureavoir.factureavoir_id'=>$id),false);  
                 
                 $this->Factureclient->updateAll(array('Factureclient.factureavoir_id' => 0), array('Factureclient.factureavoir_id' =>$id));
                
		if ($this->Factureavoir->delete()) {
			$this->Session->setFlash(__('Factureavoir deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Factureavoir was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
         public function getfactures(){
              $this->layout = null;
              $this->loadModel('Factureclient');
   
            $data = $this->request->data;
            $clientid= $data['clientid'];
 
            $factureclients=$this->Factureclient->find('all', array( 'conditions' => array('Factureclient.client_id'=>$clientid,'Factureclient.factureavoir_id'=>0),'recursive'=>-1)) ;
            $select="<select name='factureclient_id' champ='factureclient_id' id='factureclient_id' class='form-control  select ' onchange=''><option selected disabled hidden value=0> Veuillez choisir !!</option>";
            foreach($factureclients as $v){
                $select=$select."<option value=".$v['Factureclient']['id'].">".$v['Factureclient']['numero']."</option>";
              }
            $select=$select.'</select>';
            
            echo $select;
            die;
            } 
     public function  getmontantfav(){
            $this->layout = null;
            $data = $this->request->data;//debug($data);
           $json = null;
           $factureavoir_id= $data['id'];
         //debug($data);
        $factureavoir= $this->Factureavoir->find('first',array('conditions'=>array('Factureavoir.id'=>$factureavoir_id),false));
       
          $montant=$factureavoir['Factureavoir']['totalttc'];
          
         //debug($montant);die;
           echo json_encode(array('factureavoir_id'=>$factureavoir_id,'montant'=>$montant));
          die();
     } 
}
