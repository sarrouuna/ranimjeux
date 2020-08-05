<?php
App::uses('AppController', 'Controller');
/**
 * Bonreceptions Controller
 *
 * @property Bonreception $Bonreception
 */
class BonreceptionsController extends AppController {


	public function index() {
            $lien=  CakeSession::read('lien_achat');
               $bonreception="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonreceptions'){
                        $bonreception=1;
                }}}
              if (( $bonreception <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
       $this->loadModel('Fournisseur');       
       $this->loadModel('Utilisateur');  
       
         if (isset($this->request->data) && !empty($this->request->data)) {
       // debug($this->request->data);die;
        if ($this->request->data['Bonreception']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date1'])));
            $cond1 = 'Bonreception.date >= '."'".$date1."'";
        }
        
        if ($this->request->data['Bonreception']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date2'])));
            $cond2 = 'Bonreception.date <= '."'".$date2."'";
        }
        
       if ($this->request->data['Bonreception']['fournisseur_id']) {
            $fournisseurid = $this->request->data['Bonreception']['fournisseur_id'];
            $cond3 = 'Bonreception.fournisseur_id ='.$fournisseurid;
        } 
         if ($this->request->data['Bonreception']['utilisateur_id']) {
            $utilisateurid = $this->request->data['Bonreception']['utilisateur_id'];
            $cond4 = 'Bonreception.utilisateur_id ='.$utilisateurid;
        } 
    } 
    $bonreceptions = $this->Bonreception->find('all', array( 'conditions' => array('Bonreception.id > ' => 0, @$cond1, @$cond2, @$cond3,@$cond4 )));
    // debug($bonreceptions);die;
       
		
                $fournisseurs = $this->Fournisseur->find('list');
                $utilisateurs = $this->Utilisateur->find('list');
                 $this->set(compact('date1','date2','fournisseurid','utilisateurid','fournisseurs','utilisateurs','bonreceptions',$this->paginate()));
	}
        
	public function view($id = null) {
            $this->loadModel('Lignereception');
            $this->loadModel('Article');
		if (!$this->Bonreception->exists($id)) {
			throw new NotFoundException(__('Invalid bonreception'));
		}
		$options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
		$this->set('bonreception', $this->Bonreception->find('first', $options));
                    $lignereceptions = $this->Lignereception->find('all',array(
                    'conditions'=>array('Lignereception.bonreception_id' => $id)
                    ));
                $articles=$this->Article->find('list');
                $this->set(compact('lignereceptions','articles'));
	}
        
        public function imprimer($id = null) {
           $lien=  CakeSession::read('lien_achat');
               $bonreception="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonreceptions'){
                        $bonreception=$liens['imprimer'];
                }}}
              if (( $bonreception <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Lignereception');
            $this->loadModel('Article');
		if (!$this->Bonreception->exists($id)) {
			throw new NotFoundException(__('Invalid bonreception'));
		}
		$options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
		$this->set('bonreception', $this->Bonreception->find('first', $options));
                $articles=$this->Article->find('list'); 
                $lignereceptions = $this->Lignereception->find('all',array(
                    'conditions'=>array('Lignereception.bonreception_id' => $id)
                    ));
                 $this->set(compact('lignereceptions','articles'));
	}

	public function add() {
            $lien=  CakeSession::read('lien_achat');
               $bonreception="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonreceptions'){
                        $bonreception=$liens['add'];
                }}}
              if (( $bonreception <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $name = 'Bonreceptions';
           $helpers = array('Html','Ajax','Javascript');
            $this->loadModel('Article');
            $this->loadModel('Stockdepot');
            $this->loadModel('Lignereception');
            $this->loadModel('Homologation');
            $this->loadModel('Articlehomologation');
		if ($this->request->is('post')) {
                    //debug($this->request->data);die;
                    $this->request->data['Bonreception']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonreception']['date'])));
			$this->request->data['Bonreception']['utilisateur_id']= CakeSession::read('users');
                         $depotid=$this->request->data['Bonreception']['depot_id'];
			$this->Bonreception->create();  
                        if(!empty($this->request->data['Lignereception'])){
			if ($this->Bonreception->save($this->request->data)) {
                         $id=$this->Bonreception->id;
                       
                               $Lignereceptions=array();
                               $stockdepots=array();
                               $lot=array();
                              foreach (  $this->request->data['Lignereception'] as $numl=>$f   ){
                                
                              if ($f['sup']!=1){
                                $Lignereceptions['bonreception_id']=$id;
                                $stockdepots[$numl]['depot_id']=$depotid;
                                $stockdepots[$numl]['article_id']=$Lignereceptions['article_id']=$f['article_id'];
                                $stockdepots[$numl]['quantite']=$Lignereceptions['quantite']=$f['quantite'];
                                $stockdepots[$numl]['date']=$Lignereceptions['datevalidite']=date("Y-m-d",strtotime(str_replace('/','-',$f['datevalidite'])));
                                $Lignereceptions['datefabrication']=date("Y-m-d",strtotime(str_replace('/','-',$f['datefabrication'])));
                                $Lignereceptions['numerolot']=$f['numerolot'];
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['remise']=$f['remise'];
                                $Lignereceptions['fodec']=$f['fodec'];
                                $Lignereceptions['tva']=$f['tva'];
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignereceptions['totalttc']=((($Lignereceptions['totalht'])*(1+($f['fodec']*0.01)))*(1+($f['tva']*0.01)));  
                                $lot[$f['numerolot']][$numl]=$f['article_id'];
                                     $this->Lignereception->create();
                                     $this->Lignereception->save($Lignereceptions);  
                                     //  debug($stockdepots);die;
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$stockdepots[$numl]['article_id'],'Stockdepot.depot_id'=>$depotid,'Stockdepot.date'=> $stockdepots[$numl]['date']),false)); 
                                if (!empty($stckdepot)){
                                $coutderevienttot=($stckdepot[0]['Stockdepot']['prix']*$stckdepot[0]['Stockdepot']['quantite'])+$Lignereceptions['totalht'];    
                                $stockdepots[$numl]['quantite']= $stockdepots[$numl]['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                $coutderevient=$coutderevienttot/$stockdepots[$numl]['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite'],'Stockdepot.prix' =>$coutderevient ), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                }else{
                                        $stockdepots[$numl]['prix']=$Lignereceptions['totalht']/$f['quantite'];
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($stockdepots[$numl]); 
                                   }
                                   //$this->stock($depotid,$f['article_id']); 
                              }
                             } 
                              foreach (  $this->request->data['Homologation'] as $h   ){
                                  //debug($h);die;
                                  if ($h['sup']!=1){
                                    $this->Homologation->create(); 
                                    $this->Homologation->save($h); 
                                    $idh=$this->Homologation->id;
                                    //debug($idh);die;
                                    $tab=array();
                                    foreach ( $lot[$h['numero']] as $articleid) {
                                     $tab['homologation_id']=$idh;
                                     $tab['article_id']=$articleid;
                                     $this->Articlehomologation->deleteAll(array('Articlehomologation.article_id'=>$articleid),false); 
                                     $this->Articlehomologation->create();
                                     $this->Articlehomologation->save($tab);    
                                    }
                                  }
                              }
				$this->Session->setFlash(__('The bonreception has been saved'));
				$this->redirect(array('action' => 'index'));
                                
                                
                                
                                
                                
                                
			} else {
				$this->Session->setFlash(__('The bonreception could not be saved. Please, try again.'));
                        }}else {
				$this->Session->setFlash(__('le bonreception dois avoir aux moins une ligne de reception.'));
                        }
                        
		}
                $articles=$this->Article->find('list');
		$fournisseurs = $this->Bonreception->Fournisseur->find('list');
                $depots = $this->Bonreception->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('fournisseurs','articles','depots'));
	}
        
        public function addindirect($tab=null) {
              $lien=  CakeSession::read('lien_achat');
               $bonreception="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonreceptions'){
                        $bonreception=$liens['add'];
                }}}
              if (( $bonreception <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Lignefacture');
            $this->loadModel('Lignereception');
            $this->loadModel('Lignecommande');
            $this->loadModel('Bonreception');
            $this->loadModel('Article');
            $this->loadModel('Articlefournisseur');
            $this->loadModel('Commande');
            $this->loadModel('Stockdepot');
             $this->loadModel('Homologation');
             $this->loadModel('Articlehomologation');
            //debug($tab);die;
            $b=0;
         
       list($table,$listf)=explode(";",$tab);
              if ($table=='commande'){
               $tab=$listf;
               $b=1;
          }
            
            //debug($tab);die; 
            
            $tbr=$tab.',0)';
            list($idbr,$resteidbr)=explode(",",$tbr);
            $tbr='(0,'.$tbr;
           // debug($idbr);die;
            $idbrs=array();
                
                       
                       
               if($b==1) {       
            $reqfournisseur = $this->Commande->find('all',array( 'conditions' => array('Commande.id'=>$idbr),'recursive'=>-2));
               }else {
            $reqfournisseur = $this->Bonreception->find('all',array( 'conditions' => array('Bonreception.id'=>$idbr),'recursive'=>-2));   
               }
             
            if ($this->request->is('post')) {
                    //debug($this->request->data);die;
                        $this->request->data['Bonreception']['fournisseur_id']= $reqfournisseur[0]['Fournisseur']['id'];
                        $this->request->data['Bonreception']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonreception']['date'])));
			$this->request->data['Bonreception']['utilisateur_id']= CakeSession::read('users');
                        $depotid=$this->request->data['Bonreception']['depot_id'];
                        $this->request->data['Bonreception']['type']='indirect';
                   
			$this->Bonreception->create();
			if ($this->Bonreception->save($this->request->data)) {
                            $id=$this->Bonreception->id;
                       
                               $Lignereceptions=array();
                               $stockdepots=array();
                               $lot=array();
                              foreach (  $this->request->data['Lignereception'] as $numl=>$f   ){
                                 
                                    //debug($f);die;
                              if ($f['sup']!=1){  
                                $stockdepots[$numl]['depot_id']=$depotid;
                                $Lignereceptions['bonreception_id']=$id;
                                $stockdepots[$numl]['article_id']=$Lignereceptions['article_id']=$f['article_id'];
                                $stockdepots[$numl]['quantite']=$Lignereceptions['quantite']=$f['quantite'];
                                $stockdepots[$numl]['date']=$Lignereceptions['datevalidite']=date("Y-m-d",strtotime(str_replace('/','-',$f['datevalidite'])));
                                $Lignereceptions['bonreception_id']=$id;
                                $Lignereceptions['datefabrication']=date("Y-m-d",strtotime(str_replace('/','-',$f['datefabrication'])));
                                $Lignereceptions['numerolot']=$f['numerolot'];
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['remise']=$f['remise'];
                                $Lignereceptions['fodec']=$f['fodec'];
                                $Lignereceptions['tva']=$f['tva'];
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignereceptions['totalttc']=((($Lignereceptions['totalht'])*(1+($f['fodec']*0.01)))*(1+($f['tva']*0.01)));  
                                $lot[$f['numerolot']][$numl]=$f['article_id']; 
                                     $this->Lignereception->create();
                                     $this->Lignereception->save($Lignereceptions);  
                                 //  debug($stockdepots);die;
                                 $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$stockdepots[$numl]['article_id'],'Stockdepot.depot_id'=>$depotid,'Stockdepot.date'=> $stockdepots[$numl]['date']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']= $stockdepots[$numl]['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }else{
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($stockdepots[$numl]); 
                                   }
                                $this->Stockdepot->deleteAll(array('Stockdepot.article_id'=>$stockdepots[$numl]['article_id'],'Stockdepot.depot_id'=>$depotid,'Stockdepot.quantite'=>0),false);    
                              }
                             } 
                               foreach (  $this->request->data['Homologation'] as $h   ){
                                  //debug($h);die;
                                  if ($h['sup']!=1){
                                    $this->Homologation->create(); 
                                    $this->Homologation->save($h); 
                                    $idh=$this->Homologation->id;
                                    //debug($idh);die;
                                     $tab=array();
                                    foreach ( $lot[$h['numero']] as $articleid) {
                                     $tab['homologation_id']=$idh;
                                     $tab['article_id']=$articleid;
                                     $this->Articlehomologation->deleteAll(array('Articlehomologation.article_id'=>$articleid),false); 
                                     // debug($tab);die;
                                     $this->Articlehomologation->create();
                                     $this->Articlehomologation->save($tab);    
                                    }
                                  }
                              }
				$this->Session->setFlash(__('The facture has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
			}
		}
                   $art= $this->Articlefournisseur->find('all',array('conditions'=>array('Articlefournisseur.fournisseur_id'=>$reqfournisseur[0]['Fournisseur']['id']),'recursive'=>-1));
                    $t='(0,';
                       foreach ($art as $l){
                          $t=$t.$l['Articlefournisseur']['article_id'].',';
                             }
                    $t=$t.'0)';
                    $articles=$this->Article->find('list', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;  
                    $fournisseurid=$reqfournisseur[0]['Fournisseur']['id'];
                    
		 if($b==1) {      
            $lignefactures = $this->Lignecommande->find('all',array( 'conditions' => array('Lignecommande.commande_id in'.$tbr),'recursive'=>-2));
            
                   foreach (  $lignefactures as $i=>$lf   ){
            
            $lignefactures[$i]['Lignereception']= $lignefactures[$i]['Lignecommande'];
            $lignefactures[$i]['Lignereception']['tva']=$lignefactures[$i]['Article']['tva'];
            $prixaf = $this->Articlefournisseur->find('all',
                    array('conditions'=>array('Articlefournisseur.article_id'=>$lignefactures[$i]['Article']['id'],
                        'Articlefournisseur.fournisseur_id'=>$fournisseurid),false)); 
            //debug($prixaf);die;
            $lignefactures[$i]['Lignereception']['prixhtva']=$prixaf[0]['Articlefournisseur']['prix'];

                   }
               }
               else {$lignefactures=$this->Lignereception->find('all', array( 'conditions' => array('Lignereception.bonreception_id in'.$tbr),'recursive'=>-2));
               } 
               //debug($lignefactures);die;
                $depots = $this->Bonreception->Depot->find('list',array('fields' => array('Depot.designation')));
                $fournisseurs=$reqfournisseur[0]['Fournisseur']['name'];
                $this->set(compact('fournisseurs','lignefactures','articles','fournisseurid','depots'));
	}

	public function edit($id = null) {
             $lien=  CakeSession::read('lien_achat');
               $bonreception="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonreceptions'){
                        $bonreception=$liens['edit'];
                }}}
              if (( $bonreception <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Homologation');
             $this->loadModel('Articlehomologation');
             $this->loadModel('Article');
             $this->loadModel('Fournisseur');
             $this->loadModel('Lignereception');
             $this->loadModel('Stockdepot');
             $this->loadModel('Articlefournisseur');
		if (!$this->Bonreception->exists($id)) {
			throw new NotFoundException(__('Invalid bonreception'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    //debug( $this->request->data);die;
                       $this->request->data['Bonreception']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonreception']['date'])));
			$this->request->data['Bonreception']['utilisateur_id']= CakeSession::read('users');
                        $depotid=$this->request->data['Bonreception']['depot_id'];
                       if ($this->Bonreception->save($this->request->data)) {
                             $Lignereceptions=array();
                              $stockdepots=array();
                              $lot=array();
                            foreach (  $this->request->data['Lignereceptionancien'] as $lra   ){
                                //debug( $lra);die;
                            $stockdepots= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$lra['article_id'],
                             'Stockdepot.depot_id'=> $this->request->data['depotidancien']),false)); 
                            //debug( $stockdepots);die;
                            $sd=$stockdepots[0]['Stockdepot']['id']; 
                           if($stockdepots[0]['Stockdepot']['quantite']-$lra['quantite']>0){
                          $this->Stockdepot->updateAll(array('Stockdepot.quantite' => ($stockdepots[0]['Stockdepot']['quantite']-$lra['quantite']) )
                                  , array('Stockdepot.id' =>$sd));
                           } else {
                                 $this->Stockdepot->deleteAll(array('Stockdepot.id' =>$sd),false);
                           }   
                            } 
                           $this->Lignereception->deleteAll(array('Lignereception.bonreception_id'=>$id),false); 
                           
                           
                              foreach (  $this->request->data['Lignereception'] as $numl=>$f   ){
                                 
                                     //debug($f);die;
                              if ($f['sup']!=1){
                                $Lignereceptions['bonreception_id']=$id;
                                $stockdepots['depot_id']=$depotid;
                                $stockdepots['article_id']=$Lignereceptions['article_id']=$f['article_id'];
                                $stockdepots['quantite']=$Lignereceptions['quantite']=$f['quantite'];
                                $stockdepots['date']=$Lignereceptions['datevalidite']=date("Y-m-d",strtotime(str_replace('/','-',$f['datevalidite'])));
                                $Lignereceptions['datefabrication']=date("Y-m-d",strtotime(str_replace('/','-',$f['datefabrication'])));
                                $Lignereceptions['numerolot']=$f['numerolot'];
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['remise']=$f['remise'];
                                $Lignereceptions['fodec']=$f['fodec'];
                                $Lignereceptions['tva']=$f['tva'];
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignereceptions['totalttc']=((($Lignereceptions['totalht'])*(1+($f['fodec']*0.01)))*(1+($f['tva']*0.01))); 
                                $lot[$f['numerolot']][$numl]=$f['article_id']; 
                                     $this->Lignereception->create();
                                     $this->Lignereception->save($Lignereceptions); 
                                     
                          $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$stockdepots['article_id'],'Stockdepot.depot_id'=>$depotid,'Stockdepot.date'=> $stockdepots['date']),false)); 
                         // debug($stckdepot);die;     
                          if (!empty($stckdepot)){
                                $stockdepots['quantite']= $stockdepots['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }else{
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($stockdepots); 
                                   }
                              }
                             } 
                              foreach (  $this->request->data['Homologation'] as $h   ){
                                  //debug($h);die;
                                  if ($h['sup']!=1){
                                    $this->Homologation->create(); 
                                    $this->Homologation->save($h); 
                                    $idh=$this->Homologation->id;
                                    //debug($lot);die;
                                    $tab=array();
                                    foreach ( $lot[$h['numero']] as $articleid) {
                                     $tab['homologation_id']=$idh;
                                     $tab['article_id']=$articleid;
                                     $this->Articlehomologation->deleteAll(array('Articlehomologation.article_id'=>$articleid),false); 
                                     $this->Articlehomologation->create();
                                     $this->Articlehomologation->save($tab);    
                                    }
                                  }
                              }
				$this->Session->setFlash(__('The bonreception has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bonreception could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
			$this->request->data = $this->Bonreception->find('first', $options);
		}
                
                 $day=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Bonreception']['date'])));
                    $lignereceptions = $this->Lignereception->find('all',array(
                    'conditions'=>array('Lignereception.bonreception_id' => $id)
                    ));
                    
                    
                    $fournis=$this->request->data['Fournisseur']['name'];
                    $fournisseurid=$this->request->data['Fournisseur']['id'];
                    $name='article_id';
                    $art= $this->Articlefournisseur->find('all',array('conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid),'recursive'=>-1));
                    $t='(0,';
                       foreach ($art as $l){
                          $t=$t.$l['Articlefournisseur']['article_id'].',';
                             }
                    $t=$t.'0)';
                    $articles=$this->Article->find('list', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;    
                    
		$fournisseurs = $this->Bonreception->Fournisseur->find('list');
                $depots = $this->Bonreception->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('fournisseurs', 'depots','lignereceptions','day','articles','fournis'));
	}

	public function delete($id = null) {
             $lien=  CakeSession::read('lien_achat');
               $bonreception="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonreceptions'){
                        $bonreception=$liens['delete'];
                }}}
              if (( $bonreception <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
              $this->loadModel('Lignereception');
              $this->loadModel('Stockdepot');
		$this->Bonreception->id = $id;
		if (!$this->Bonreception->exists()) {
			throw new NotFoundException(__('Invalid bonreception'));
		}
		$this->request->onlyAllow('post', 'delete');
    
                 $lrs=$this->Lignereception->find('all',array('conditions'=>array('Lignereception.bonreception_id'=>$id),false)); 
                 //debug($lrs);die;
                  foreach (  $lrs as $lr   ){
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$lr['Lignereception']['article_id'],'Stockdepot.depot_id'=>$lr['Bonreception']['depot_id'],'Stockdepot.date'=> $lr['Lignereception']['datevalidite']),false)); 
                                if (!empty($stckdepot)){
                                $stkdepqte['quantite']= $stckdepot[0]['Stockdepot']['quantite']-$lr['Lignereception']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stkdepqte['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                              }
                 $this->Lignereception->deleteAll(array('Lignereception.bonreception_id'=>$id),false);    
                
		if ($this->Bonreception->delete()) {
			$this->Session->setFlash(__('Bonreception deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Bonreception was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
                
        public function imprimerrecherche() { 
         $lien=  CakeSession::read('lien_achat');
               $bonreception="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonreceptions'){
                        $bonreception=$liens['imprimer'];
                }}}
              if (( $bonreception <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
       $this->loadModel('Fournisseur');       
       $this->loadModel('Utilisateur');  
       //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Bonreception.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Bonreception.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Bonreception.fournisseur_id ='.$fournisseurid;
        } 
         if ($this->request->query['utilisateurid']) {
            $utilisateurid = $this->request->query['utilisateurid'];
            $cond4 = 'Bonreception.utilisateur_id ='.$utilisateurid;
        } 
  $bonreceptions = $this->Bonreception->find('all', array( 'conditions' => array('Bonreception.id > ' => 0, @$cond1, @$cond2, @$cond3,@$cond4 )));
  //$fournisseur=$this->Fournisseur->find('first', array( 'conditions' => array('Fournisseur.id'=> $fournisseurid),'recursive'=>-1)) ;

    //debug($fournisseurid);debug($utilisateurid);debug($date1);debug($date2); 
   // debug($bonreceptions);die;
                 $this->set(compact('bonreceptions','date1','date2','fournisseurid','utilisateurid'));     
   
         }

        public function artfour(){
             $this->layout = null;
              $this->loadModel('Article');
              $this->loadModel('Articlefournisseur');
             
           
         $data = $this->request->data;//debug($data);
         $json = null;
      $fournisseurid= $data['id']; 
      $name='article_id';
      
      $art= $this->Articlefournisseur->find('all',array('conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid),'recursive'=>-1));
      $t='(0,';
            foreach ($art as $l){
                $t=$t.$l['Articlefournisseur']['article_id'].',';
              
            }
            $t=$t.'0)';
           // debug($t);
            
             if ($fournisseurid != 0) { 
            $articles=$this->Article->find('all', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
            $select="<select   name='data[Lignereception][0][article_id]' table='Lignereception' index='0' champ='article_id' id='article_id0' class='select form-control idarticle' onchange='tvaart(0)'><option selected disabled hidden value=0> Veuillez choisir</option>";
            foreach($articles as $v){
                $select=$select."<option value=".$v['Article']['id'].">".$v['Article']['name']."</option>";
            }
            $select=$select.'</select>';
             // die();
       //   debug($Articleid);
          // echo $code;
         // echo json_encode(array('select'=>$select));
             }
             
             
             else{
                 $articles=$this->Article->find('all') ;
            $select="<select name='".$name."' champ='article_id' id='article_id'  class='' onchange='tvaart(ind) testligneinv'><option selected disabled hidden value=0> Veuillez choisir</option>";
            foreach($articles as $v){
                $select=$select."<option value=".$v['Article']['id'].">".$v['Article']['name']."</option>";
            }
            $select=$select.'</select>';
             // die();
       //   debug($Articleid);
          // echo $code;
          
                 
             }
             $selectf="<select name='".$name."' table='Lignereception' champ='article_id' id='article_id'  class='' onchange='tvaart(ind) testligneinv'><option selected disabled hidden value=0> Veuillez choisir</option>";
            $selectf=$selectf."<option value=''>veullier choisir</option>";
             foreach($articles as $v){
                $selectf=$selectf."<option value=".$v['Article']['id'].">".$v['Article']['name']."</option>";
            }
            $selectf=$selectf.'</select>';
            
            
            
             echo json_encode(array('select'=>$select,'selectf'=>$selectf));
          die();
        }  
        
        public function  gettva(){
            $this->layout = null;
            $this->loadModel('Article');  
            $this->loadModel('Articlefournisseur');
            $data = $this->request->data;//debug($data);
           $json = null;
           $articleid= $data['id'];
           $fournisseurid=$data['fid'];
           //debug($data);die;
        $article= $this->Article->find('all',array('conditions'=>array('Article.id'=>$articleid),false));
    $prixaf= $this->Articlefournisseur->find('all',array('conditions'=>array('Articlefournisseur.article_id'=>$articleid,'Articlefournisseur.fournisseur_id'=>$fournisseurid),false)); 
            //debug($prixaf);die;
          $tva=$article[0]['Article']['tva'];
          $idart=$article[0]['Article']['id'];
          $prix=$prixaf[0]['Articlefournisseur']['prix'];
           echo json_encode(array('tva'=>$tva,'prix'=>$prix,'idart'=>$idart));
          die();
     }
}
