<?php
App::uses('AppController', 'Controller');

class BonreceptionsController extends AppController {
//******************************************************------------Historiques----------******************************************************************************************
      public function historique() {
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
       $this->loadModel('Article');  
       $this->loadModel('Bonreception'); 
       $this->loadModel('Facture'); 
       $historiques=array();
        if (isset($this->request->data) && !empty($this->request->data)) {
      //debug($this->request->data);die;
        if ($this->request->data['Bonreception']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date1'])));
            $condb1 = 'Bonreception.date >= '."'".$date1."'";
            $condf1 = 'Facture.date >= '."'".$date1."'";

        }
        
        if ($this->request->data['Bonreception']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date2'])));
            $condb2 = 'Bonreception.date <= '."'".$date2."'";
            $condf2 = 'Facture.date <= '."'".$date2."'";
        }
        
       if ($this->request->data['Bonreception']['fournisseur_id']) {
            $fournisseurid = $this->request->data['Bonreception']['fournisseur_id'];
            $condb3 = 'Bonreception.fournisseur_id ='.$fournisseurid;
            $condf3 = 'Facture.fournisseur_id = '.$fournisseurid;
        } 
    $bonreceptions = $this->Bonreception->find('all', array( 'conditions' => array('Bonreception.id > ' => 0, @$condb1, @$condb2, @$condb3 ))); //debug($bonreceptions);die;
    $direct="'direct'"; $condf4 = 'Facture.type >= '.$direct;
    $factures = $this->Facture->find('all', array( 'conditions' => array('Facture.id > ' => 0, @$condf1, @$condf2, @$condf3,$condf4 )));  //debug($factures);die;
    $compteur=0;
    
        if ($this->request->data['Bonreception']['article_id']) {
                $articleid = $this->request->data['Bonreception']['article_id'];
                foreach ($bonreceptions as $bonreception) {
                        foreach ($bonreception['Lignereception'] as $lignereception) {
                                if ($lignereception['article_id']==$articleid){
                                    if($compteur>0){
                                        $compteur--;
                                        if(($historiques[$compteur]['prix']==$lignereception['prixhtva'])&($historiques[$compteur]['Fournisseur']==$bonreception['Fournisseur'])){
                                        
                                            $historiques[$compteur]['quantite']+=$lignereception['quantite']; 
                                            $historiques[$compteur]['date']=$bonreception['Bonreception']['date']; 
                                        $compteur++;
                                        }
                                        else{
                                        $compteur++;
                                        $historiques[$compteur]['article_id']=$lignereception['article_id']; 
                                        $historiques[$compteur]['prix']=$lignereception['prixhtva']; 
                                        $historiques[$compteur]['quantite']=$lignereception['quantite']; 
                                        $historiques[$compteur]['date']=$bonreception['Bonreception']['date']; 
                                        $historiques[$compteur]['Fournisseur']=$bonreception['Fournisseur']; 
                                        $compteur++;
                                        }
                                    }else{
                                    $historiques[$compteur]['article_id']=$lignereception['article_id']; 
                                    $historiques[$compteur]['prix']=$lignereception['prixhtva']; 
                                    $historiques[$compteur]['quantite']=$lignereception['quantite']; 
                                    $historiques[$compteur]['date']=$bonreception['Bonreception']['date']; 
                                    $historiques[$compteur]['Fournisseur']=$bonreception['Fournisseur']; 
                                    $compteur++;
                                    }
                                 }
                        }
                }
                foreach ($factures as  $facture) {
                        foreach ($facture['Lignefacture'] as  $lignefacture) {
                               if ($lignefacture['article_id']==$articleid){
                                  if($compteur>0){
                                        $compteur--;
                                        if(($historiques[$compteur]['prix']==$lignefacture['prixhtva'])&($historiques[$compteur]['Fournisseur']==$facture['Fournisseur'])){
                                        
                                            $historiques[$compteur]['quantite']+=$lignefacture['quantite']; 
                                            $historiques[$compteur]['date']=$facture['Facture']['date']; 
                                        $compteur++;
                                        }
                                        else{
                                        $compteur++;
                                        $historiques[$compteur]['article_id']=$lignefacture['article_id']; 
                                        $historiques[$compteur]['prix']=$lignefacture['prixhtva']; 
                                        $historiques[$compteur]['quantite']=$lignefacture['quantite']; 
                                        $historiques[$compteur]['date']=$facture['Facture']['date']; 
                                        $historiques[$compteur]['Fournisseur']=$facture['Fournisseur']; 
                                        $compteur++;
                                        }
                                    }else{  
                                $historiques[$compteur]['article_id']=$lignefacture['article_id']; 
                                $historiques[$compteur]['prix']=$lignefacture['prixhtva']; 
                                $historiques[$compteur]['quantite']=$lignefacture['quantite']; 
                                $historiques[$compteur]['date']=$facture['Facture']['date']; 
                                $historiques[$compteur]['Fournisseur']=$facture['Fournisseur']; 
                                $compteur++;
                                    }
                                }
                        }
                }
                foreach ($historiques as  $i=>$historique) {
                    foreach ($historiques as  $j=>$historique) {
                        if(($j!=$i)&($historiques[$j]['prix']==$historiques[$i]['prix'])&($historiques[$j]['Fournisseur']==$historiques[$i]['Fournisseur'])){
                           $historiques[$i]['quantite']+=$historiques[$j]['quantite']; 
                           $historiques[$i]['date']=$historiques[$j]['date'];
                           $historiques[$j]['quantite']=0;
                        }
                    }   
                }
        }
    } 
                $fournisseurs = $this->Fournisseur->find('list');//debug($fournisseurs);die;
                $articles = $this->Article->find('list');
                $this->set(compact('date1','date2','fournisseurid','articleid','fournisseurs','articles','historiques',$this->paginate()));
	}
    
      public function imprimerhistorique() { 
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
       $this->loadModel('Fournisseur');       
       $this->loadModel('Article');  
       $this->loadModel('Bonreception'); 
       $this->loadModel('Facture'); 
       $historiques=array();
     // debug($this->request->query);die;
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $condb1 = 'Bonreception.date >= '."'".$date1."'";
            $condf1 = 'Facture.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $condb2 = 'Bonreception.date <= '."'".$date2."'";
            $condf2 = 'Facture.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $condb3 = 'Bonreception.fournisseur_id ='.$fournisseurid;
            $condf3 = 'Facture.fournisseur_id = '.$fournisseurid;
        } 
        $bonreceptions = $this->Bonreception->find('all', array( 'conditions' => array('Bonreception.id > ' => 0, @$condb1, @$condb2, @$condb3 ))); //debug($bonreceptions);die;
        $direct="'direct'"; $condf4 = 'Facture.type >= '.$direct;
        $factures = $this->Facture->find('all', array( 'conditions' => array('Facture.id > ' => 0, @$condf1, @$condf2, @$condf3,$condf4 )));  //debug($factures);die;
        $compteur=0;
      //  if ($this->request->query['articleid']) {
            $articleid = $this->request->query['articleid'];
                foreach ($bonreceptions as $bonreception) {
                        foreach ($bonreception['Lignereception'] as $lignereception) {
                                if ($lignereception['article_id']==$articleid){
                                    if($compteur>0){
                                        $compteur--;
                                        if(($historiques[$compteur]['prix']==$lignereception['prixhtva'])&($historiques[$compteur]['Fournisseur']==$bonreception['Fournisseur'])){
                                        
                                            $historiques[$compteur]['quantite']+=$lignereception['quantite']; 
                                            $historiques[$compteur]['date']=$bonreception['Bonreception']['date']; 
                                        $compteur++;
                                        }
                                        else{
                                        $compteur++;
                                        $historiques[$compteur]['article_id']=$lignereception['article_id']; 
                                        $historiques[$compteur]['prix']=$lignereception['prixhtva']; 
                                        $historiques[$compteur]['quantite']=$lignereception['quantite']; 
                                        $historiques[$compteur]['date']=$bonreception['Bonreception']['date']; 
                                        $historiques[$compteur]['Fournisseur']=$bonreception['Fournisseur']; 
                                        $compteur++;
                                        }
                                    }else{
                                    $historiques[$compteur]['article_id']=$lignereception['article_id']; 
                                    $historiques[$compteur]['prix']=$lignereception['prixhtva']; 
                                    $historiques[$compteur]['quantite']=$lignereception['quantite']; 
                                    $historiques[$compteur]['date']=$bonreception['Bonreception']['date']; 
                                    $historiques[$compteur]['Fournisseur']=$bonreception['Fournisseur']; 
                                    $compteur++;
                                    }
                                 }
                        }
                }
                foreach ($factures as  $facture) {
                        foreach ($facture['Lignefacture'] as  $lignefacture) {
                               if ($lignefacture['article_id']==$articleid){
                                  if($compteur>0){
                                        $compteur--;
                                        if(($historiques[$compteur]['prix']==$lignefacture['prixhtva'])&($historiques[$compteur]['Fournisseur']==$facture['Fournisseur'])){
                                        
                                            $historiques[$compteur]['quantite']+=$lignefacture['quantite']; 
                                            $historiques[$compteur]['date']=$facture['Facture']['date']; 
                                        $compteur++;
                                        }
                                        else{
                                        $compteur++;
                                        $historiques[$compteur]['article_id']=$lignefacture['article_id']; 
                                        $historiques[$compteur]['prix']=$lignefacture['prixhtva']; 
                                        $historiques[$compteur]['quantite']=$lignefacture['quantite']; 
                                        $historiques[$compteur]['date']=$facture['Facture']['date']; 
                                        $historiques[$compteur]['Fournisseur']=$facture['Fournisseur']; 
                                        $compteur++;
                                        }
                                    }else{  
                                $historiques[$compteur]['article_id']=$lignefacture['article_id']; 
                                $historiques[$compteur]['prix']=$lignefacture['prixhtva']; 
                                $historiques[$compteur]['quantite']=$lignefacture['quantite']; 
                                $historiques[$compteur]['date']=$facture['Facture']['date']; 
                                $historiques[$compteur]['Fournisseur']=$facture['Fournisseur']; 
                                $compteur++;
                                    }
                                }
                        }
                }
                foreach ($historiques as  $i=>$historique) {
                    foreach ($historiques as  $j=>$historique) {
                        if(($j!=$i)&($historiques[$j]['prix']==$historiques[$i]['prix'])&($historiques[$j]['Fournisseur']==$historiques[$i]['Fournisseur'])){
                           $historiques[$i]['quantite']+=$historiques[$j]['quantite']; 
                           $historiques[$i]['date']=$historiques[$j]['date'];
                           $historiques[$j]['quantite']=0;
                        }
                    }   
                }
        
                $articles = $this->Article->find('list');
                $this->set(compact('historiques','articles','date1','date2','fournisseurid','articleid'));     
    }

//***************************************************------------Fin_Historiques----------*****************************************************************************************************
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
       $this->loadModel('Exercice'); 
       $exercices = $this->Exercice->find('list');
        $pv="";
       $p=CakeSession::read('pointdevente');
       if($p>0){
          $pv= 'Bonreception.pointdevente_id = '.$p;
       }
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
       
        if ($this->request->data['Bonreception']['transf_id']=="0"){
            $transf=$this->request->data['Bonreception']['transf_id'];
            $cond5 = 'Bonreception.facture_id ='.$transf;
            }elseif($this->request->data['Bonreception']['transf_id']=="1"){
            $transf=$this->request->data['Bonreception']['transf_id'];
            $cond5 = 'Bonreception.facture_id >= '.$transf;
            }
        if ($this->request->data['Bonreception']['exercice_id']) {
            $exerciceid = $this->request->data['Bonreception']['exercice_id'];
            $cond4 = 'Bonreception.exercice_id ='.$exercices[$exerciceid];
        } 
       
    } 
    $bonreceptions = $this->Bonreception->find('all', array( 'conditions' => array('Bonreception.id > ' => 0,$pv, @$cond1, @$cond2, @$cond3,@$cond5,@$cond4 )));
    // debug($cond5);die;
                $transfs[0]="Non transformé";
		$transfs[1]="Transformé";
                $bes[0]="Non Ajouté";
		$bes[1]="Ajouté";
                $fournisseurs = $this->Fournisseur->find('list');//debug($fournisseurs);die;
                $utilisateurs = $this->Utilisateur->find('list');
                $this->set(compact('exercices','date1','date2','fournisseurid','utilisateurid','transf','be','transfs','bes','fournisseurs','utilisateurs','bonreceptions',$this->paginate()));
	}
        
	public function view($id = null) {
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

        public function imprimerpourdepot($id = null) {
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
            $this->loadModel('Depot');
            $this->loadModel('Lignereception');
            $this->loadModel('Homologation');
            $this->loadModel('Articlehomologation');
            $this->loadModel('Fournisseur');
            $this->loadModel('Tracemodificationprixdevente');
		if ($this->request->is('post')) {
                  //debug($this->request->data);die;
                    $this->request->data['Bonreception']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonreception']['date'])));
			$this->request->data['Bonreception']['utilisateur_id']= CakeSession::read('users');
                        $this->request->data['Bonreception']['pointdevente_id']= CakeSession::read('pointdevente');
                        $this->request->data['Bonreception']['exercice_id']= date("Y");
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
                                if(!empty($f['prix'])){
                                $Lignereceptions['prix']=$f['prix'];
                                }
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['remise']=@$f['remise'];
                                $Lignereceptions['fodec']=@$f['fodec'];
                                $Lignereceptions['tva']=$f['tva'];
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['totalht']=($f['prixhtva']*(1-@$f['remise']*0.01))*$f['quantite'];
                                $Lignereceptions['totalttc']=((($Lignereceptions['totalht'])*(1+(@$f['fodec']*0.01)))*(1+($f['tva']*0.01)));  
                                //$lot[$f['numerolot']][$numl]=$f['article_id'];
                                     $this->Lignereception->create();
                                     $this->Lignereception->save($Lignereceptions); 
                                $this->Article->updateAll(array('Article.coutrevient' =>$f['prixhtva'],'Article.tauxchange' =>1,'Article.coefficient' =>1), array('Article.id' =>$f['article_id']));
                                
                                if((!empty($f['margeA']))||(!empty($f['pvA']))){
                                $trace=array();    
                                $aticle= $this->Article->find('first',array('conditions'=>array('Article.id'=>$f['article_id'])));    
                                $marge_ans=$aticle['Article']['marge'];
                                $prixvente_ans=$aticle['Article']['prixvente'];
                                $this->Article->updateAll(array('Article.prixvente' =>$f['pvA'],'Article.marge' =>$f['margeA']), array('Article.id' =>$f['article_id']));
                                $trace['utilisateur_id']= CakeSession::read('users');
                                $trace['date']=date("Y-m-d");
                                $trace['heure']=date("H:i",time());
                                $trace['article_id']=$f['article_id'];
                                $trace['prixventeans']=$prixvente_ans;
                                $trace['margeans']=$marge_ans;
                                $trace['prixventenv']=$f['pvA'];
                                $trace['margenv']=$f['margeA'];
                                $this->Tracemodificationprixdevente->create();
                                $this->Tracemodificationprixdevente->save($trace);
                                }      
                                     
                                     //  debug($stockdepots);die;
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$stockdepots[$numl]['article_id'],'Stockdepot.depot_id'=>$depotid,@$cond),false)); 
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
                    
				$this->Session->setFlash(__('The bonreception has been saved'));
				$this->redirect(array('action' => 'index'));
                                
                                
                                
                                
                                
                                
			} else {
				$this->Session->setFlash(__('The bonreception could not be saved. Please, try again.'));
                        }}else {
				$this->Session->setFlash(__('le bonreception dois avoir aux moins une ligne de reception.'));
                        }
                        
		}
                $articles=$this->Article->find('list');
		$fournisseurs = $this->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id'=>1)));
                $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
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
            $this->loadModel('Depot');
            $this->loadModel('Importation');
            $this->loadModel('Fournisseur');
            $this->loadModel('Tracemodificationprixdevente');
            $b=0;
            list($table,$listf)=explode(";",$tab);
              if ($table=='commande'){
               $tab=$listf;
               $b=1;
            }
            $tbr=$tab.',0)';
            list($idbr,$resteidbr)=explode(",",$tbr);
            $tbr='(0,'.$tbr;
            $idbrs=explode(",",$tab);
            //debug($tbr);           
            if($b==1) {  
            $reqfournisseur = $this->Commande->find('all',array( 'conditions' => array('Commande.id'=>$idbr),'recursive'=>-2));
            }else {
            $reqfournisseur = $this->Bonreception->find('all',array( 'conditions' => array('Bonreception.id'=>$idbr),'recursive'=>-2));   
            }
            
            
            $bonreception = $this->Commande->find('first', array('fields'=>array('SUM(Commande.remise) remise','SUM(Commande.fodec ) fodec ','SUM(Commande.tva) tva','SUM(Commande.totalht) totalht'
            ,'SUM(Commande.totalttc) totalttc','AVG(Commande.fournisseur_id) fournisseur_id','AVG(Commande.importation_id) importation_id','AVG(Commande.coefficient) coefficient','AVG(Commande.depot_id) depot_id'),'conditions' => array('Commande.id'=>$idbrs),'recursive'=>-2));
            //debug($bonreception);
            
             $lignebonreceptions=$this->Lignecommande->find('all', array('fields'=>array('AVG(Lignecommande.article_id) article_id','(Lignecommande.article_id) article_iddd'
             ,'SUM(Lignecommande.quantite) quantite','SUM(Lignecommande.remise*Lignecommande.quantite) remise','SUM(Lignecommande.prix*Lignecommande.quantite) prix'
             ,'AVG(Lignecommande.tva) tva','AVG(Lignecommande.fodec) fodec','SUM(Lignecommande.totalht) totalht','SUM(Lignecommande.totalttc)totalttc','SUM(Lignecommande.prixhtva )prixhtva ')
            ,'conditions' => array('Lignecommande.commande_id in'.$tbr),'recursive'=>-2
            ,'group'=>array('Lignecommande.article_id')));
            //debug($lignebonreceptions); 
            if ($this->request->is('post')) {
                    //debug($this->request->data);die;
                        $this->request->data['Bonreception']['commande_id']=$tbr;
                        $this->request->data['Bonreception']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonreception']['date'])));
			$this->request->data['Bonreception']['utilisateur_id']= CakeSession::read('users');
                        $depotid=$this->request->data['Bonreception']['depot_id'];
                        $this->request->data['Bonreception']['type']='indirect';
                        $this->request->data['Bonreception']['pointdevente_id']= CakeSession::read('pointdevente');
                        $this->request->data['Bonreception']['exercice_id']= date("Y");
                        $tc=$this->request->data['Bonreception']['tr'];
                        $coe=$this->request->data['Bonreception']['coe'];
			$this->Bonreception->create();
			if ($this->Bonreception->save($this->request->data)) {
                            $id=$this->Bonreception->id;
                       
                               $Lignereceptions=array();
                               $stockdepots=array();
                               $lot=array();
                              foreach (  $this->request->data['Lignedeviprospect'] as $numl=>$f   ){
                                 
                                    //debug($f);die;
                              if ($f['sup']!=1){  
                                $stockdepots[$numl]['depot_id']=$depotid;
                                $Lignereceptions['bonreception_id']=$id;
                                $stockdepots[$numl]['article_id']=$Lignereceptions['article_id']=$f['article_id'];
                                $stockdepots[$numl]['quantite']=$Lignereceptions['quantite']=$f['quantite'];
                                $Lignereceptions['bonreception_id']=$id;
                                if(!empty($f['prix'])){
                                $Lignereceptions['prix']=$f['prix'];
                                }
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['remise']=@$f['remise'];
                                $Lignereceptions['fodec']=@$f['fodec'];
                                $Lignereceptions['tva']=$f['tva'];
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['totalht']=($f['prixhtva']*(1-@$f['remise']*0.01))*$f['quantite'];
                                $Lignereceptions['totalttc']=((($Lignereceptions['totalht'])*(1+(@$f['fodec']*0.01)))*(1+($f['tva']*0.01)));  
                               // $lot[$f['numerolot']][$numl]=$f['article_id']; 
                                     $this->Lignereception->create();
                                     $this->Lignereception->save($Lignereceptions);
                                $this->Article->updateAll(array('Article.coutrevient' =>$f['prixhtva'],'Article.tauxchange' =>$tc,'Article.coefficient' =>$coe,'Article.prixachatdevise' =>$f['prix']), array('Article.id' =>$f['article_id']));
                                 if((!empty($f['margeA']))||(!empty($f['pvA']))){
                                $trace=array();    
                                $aticle= $this->Article->find('first',array('conditions'=>array('Article.id'=>$f['article_id'])));    
                                $marge_ans=$aticle['Article']['marge'];
                                $prixvente_ans=$aticle['Article']['prixvente'];
                                $this->Article->updateAll(array('Article.prixvente' =>$f['pvA'],'Article.marge' =>$f['margeA']), array('Article.id' =>$f['article_id']));
                                $trace['utilisateur_id']= CakeSession::read('users');
                                $trace['date']=date("Y-m-d");
                                $trace['heure']=date("H:i",time());
                                $trace['article_id']=$f['article_id'];
                                $trace['prixventeans']=$prixvente_ans;
                                $trace['margeans']=$marge_ans;
                                $trace['prixventenv']=$f['pvA'];
                                $trace['margenv']=$f['margeA'];
                                $this->Tracemodificationprixdevente->create();
                                $this->Tracemodificationprixdevente->save($trace);
                                }      
                                     
                                 $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$stockdepots[$numl]['article_id'],'Stockdepot.depot_id'=>$depotid),false)); 
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
                             if($b==1) { 
                             foreach ( $idbrs as $c){
                                $this->Commande->updateAll(array('Commande.validite_id' =>3), array('Commande.id' =>$c));
                             }}
				$this->Session->setFlash(__('The facture has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
			}
		}
        $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
        $importation=$this->Importation->find('first',array('recursive' =>-1,'conditions'=>array('Importation.id' =>$bonreception[0]['importation_id'])));
        if($bonreception[0]['importation_id']!=0){
        $impo=$importation['Importation']['name'];    
        $tr=$importation['Importation']['tauxderechenge'];
        $coe=$importation['Importation']['coefficien'];
        $tot_coe=$tr*$coe;
        }
        $fournisseur= $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$bonreception[0]['fournisseur_id']),false));
        $devise=$fournisseur['Fournisseur']['devise_id'];
        $name=$fournisseur['Fournisseur']['name'];
        $fournisseurs = $this->Fournisseur->find('list');
        $articles = $this->Article->find('list');
        $importations= $this->Importation->find('list',array('conditions'=>array('Importation.fournisseur_id'=>$bonreception[0]['fournisseur_id'],'Importation.etat'=>0),false));
        $this->set(compact('impo','name','devise','importations','tot_coe','coe','tr','lignebonreceptions','bonreception','fournisseurs','lignefactures','articles','fournisseurid','depots'));
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
             $this->loadModel('Depot');
             $this->loadModel('Articlehomologation');
             $this->loadModel('Article');
             $this->loadModel('Fournisseur');
             $this->loadModel('Lignereception');
             $this->loadModel('Stockdepot');
             $this->loadModel('Articlefournisseur');
             $this->loadModel('Importation');
             $this->loadModel('Tracemodificationprixdevente');
		if (!$this->Bonreception->exists($id)) {
			throw new NotFoundException(__('Invalid bonreception'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                   // debug( $this->request->data);die;
                       $this->request->data['Bonreception']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonreception']['date'])));
			$this->request->data['Bonreception']['utilisateur_id']= CakeSession::read('users');
                        $depotid=$this->request->data['Bonreception']['depot_id'];
                   $bonreception= $this->Bonreception->find('first',array('conditions'=>array('Bonreception.id'=>$id),false));
                        if ($this->Bonreception->save($this->request->data)) {
                             $Lignereceptions=array();
                              $stockdepots=array();
                              $lot=array();
                           $lignereceptionanciens= $this->Lignereception->find('all',array('conditions'=>array('Lignereception.bonreception_id'=>$id),false));
                            foreach (  $lignereceptionanciens as $lra   ){
                                //debug( $lra);die;
//                            $stockdepots= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$lra['article_id'],
//                             'Stockdepot.depot_id'=> $bonreception['Bonreception']['depot_id'] ),false)); 
//                                
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite-'.$lra['Lignereception']['quantite']), array('Stockdepot.article_id' =>$lra['Lignereception']['article_id'],'Stockdepot.depot_id' =>$bonreception['Bonreception']['depot_id']));
                            } 
                             $this->Stockdepot->deleteAll(array('Stockdepot.quantite'=>0),false);
                           $this->Lignereception->deleteAll(array('Lignereception.bonreception_id'=>$id),false); 
                              foreach (  $this->request->data['Lignereception'] as $numl=>$f   ){
                                 
                                     //debug($f);die;
                              if ($f['sup']!=1){
                                $Lignereceptions['bonreception_id']=$id;
                                $stockdepots['depot_id']=$depotid;
                                $stockdepots['article_id']=$Lignereceptions['article_id']=$f['article_id'];
                                $stockdepots['quantite']=$Lignereceptions['quantite']=$f['quantite'];
                                if(!empty($f['prix'])){
                                $Lignereceptions['prix']=$f['prix'];
                                }
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['remise']=@$f['remise'];
                                $Lignereceptions['fodec']=@$f['fodec'];
                                $Lignereceptions['tva']=$f['tva'];
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['totalht']=($f['prixhtva']*(1-@$f['remise']*0.01))*$f['quantite'];
                                $Lignereceptions['totalttc']=((($Lignereceptions['totalht'])*(1+(@$f['fodec']*0.01)))*(1+($f['tva']*0.01))); 
                                //$lot[$f['numerolot']][$numl]=$f['article_id']; 
                                     $this->Lignereception->create();
                                     $this->Lignereception->save($Lignereceptions);
                                if(!empty($f['prix'])){
                                $tc=$this->request->data['Bonreception']['tr'];
                                $coe=$this->request->data['Bonreception']['coe'];    
                                $this->Article->updateAll(array('Article.coutrevient' =>$f['prixhtva'],'Article.tauxchange' =>$tc,'Article.coefficient' =>$coe,'Article.prixachatdevise' =>$f['prix']), array('Article.id' =>$f['article_id']));
                                }else{
                                $this->Article->updateAll(array('Article.coutrevient' =>$f['prixhtva'],'Article.tauxchange' =>1,'Article.coefficient' =>1), array('Article.id' =>$f['article_id']));
                                }
                                if((!empty($f['margeA']))||(!empty($f['pvA']))){
                                $trace=array();    
                                $aticle= $this->Article->find('first',array('conditions'=>array('Article.id'=>$f['article_id'])));    
                                $marge_ans=$aticle['Article']['marge'];
                                $prixvente_ans=$aticle['Article']['prixvente'];
                                $this->Article->updateAll(array('Article.prixvente' =>$f['pvA'],'Article.marge' =>$f['margeA']), array('Article.id' =>$f['article_id']));
                                $trace['utilisateur_id']= CakeSession::read('users');
                                $trace['date']=date("Y-m-d");
                                $trace['heure']=date("H:i",time());
                                $trace['article_id']=$f['article_id'];
                                $trace['prixventeans']=$prixvente_ans;
                                $trace['margeans']=$marge_ans;
                                $trace['prixventenv']=$f['pvA'];
                                $trace['margenv']=$f['margeA'];
                                $this->Tracemodificationprixdevente->create();
                                $this->Tracemodificationprixdevente->save($trace);
                                }
                                
                          $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$stockdepots['article_id'],'Stockdepot.depot_id'=>$depotid))); 
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
                            
                                  //debug($h);die;
                                 
                              
				$this->Session->setFlash(__('The bonreception has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bonreception could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
			$this->request->data = $this->Bonreception->find('first', $options);
		        //debug($this->request->data);
                
                 $day=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Bonreception']['date'])));
                 $lignereceptions = $this->Lignereception->find('all',array('conditions'=>array('Lignereception.bonreception_id' => $id)));
                    
                    
                if($this->request->data['Bonreception']['importation_id']!=0){
                $importations= $this->Importation->find('list',array('conditions'=>array('Importation.fournisseur_id'=>$this->request->data['Bonreception']['fournisseur_id'],'Importation.etat'=>0),false));
                $tr=$this->request->data['Importation']['tauxderechenge'];
                $coe=$this->request->data['Importation']['coefficien'];
                }
                if($this->request->data['Fournisseur']['devise_id']!=1){
                $fournisseurs = $this->Bonreception->Fournisseur->find('list');
                }else{
		$fournisseurs = $this->Bonreception->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id'=>1)));
                }
                $articles=$this->Article->find('list');
                $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
                }
		$this->set(compact('importations','coe','tr','fournisseurs','depots','lignereceptions','day','articles'));
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
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$lr['Lignereception']['article_id'],'Stockdepot.depot_id'=>$lr['Bonreception']['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stkdepqte['quantite']= $stckdepot[0]['Stockdepot']['quantite']-$lr['Lignereception']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stkdepqte['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                                   $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);

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
     // debug($this->request->query);die;
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
         
         if ($this->request->query['transf']=="0"){
            $transf=$this->request->query['transf'];
            $cond5 = 'Bonreception.facture_id ='.$transf;
            }elseif($this->request->query['transf']=="1"){
            $transf=$this->request->query['transf'];
            $cond5 = 'Bonreception.facture_id > '.$transf;
            }
      
       
  $bonreceptions = $this->Bonreception->find('all', array( 'conditions' => array('Bonreception.id > ' => 0, @$cond1, @$cond2, @$cond3,@$cond5 )));
  //$fournisseur=$this->Fournisseur->find('first', array( 'conditions' => array('Fournisseur.id'=> $fournisseurid),'recursive'=>-1)) ;

    //debug($fournisseurid);debug($utilisateurid);debug($date1);debug($date2); 
   // debug($bonreceptions);die;
                 $this->set(compact('bonreceptions','date1','date2','fournisseurid','utilisateurid'));     
   
         }

        public function artfour(){
              $this->layout = null;
              $this->loadModel('Article');
              $this->loadModel('Fournisseur');
              $this->loadModel('Articlefournisseur');
              $this->loadModel('Importation');
           
         $data = $this->request->data;//debug($data);
         $json = null;
      $fournisseurid= $data['id'];
      
       $fournisseur= $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$fournisseurid),false));
       $devise=$fournisseur['Fournisseur']['devise_id'];
            //  debug($devise);die;

      $name='article_id';
      
      $art= $this->Articlefournisseur->find('all',array('conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid),'recursive'=>-1));
      $t='(0,';
            foreach ($art as $l){
                $t=$t.$l['Articlefournisseur']['article_id'].',';
              
            }
            $t=$t.'0)';
           // debug($t);
            
             if ($fournisseurid != 0) { 
            $articles=$this->Article->find('all', array( 'conditions' => array('Article.id in'. $t ,'Article.typeetatarticle_id'=>1),'recursive'=>-1)) ;
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
                 $articles=$this->Article->find('all', array( 'conditions' => array('Article.typeetatarticle_id'=>1),'recursive'=>-1)) ;
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
            
            
       $importations= $this->Importation->find('all',array('conditions'=>array('Importation.fournisseur_id'=>$fournisseurid,'Importation.etat'=>0),false));
       $selecti="<select name='data[Deviprospect][importation_id]' table='Deviprospect' champ='importation_id' id='importation_id'  class='' onchange='get_tr_coe()'>";
            $selecti=$selecti."<option value=''>veullier choisir</option>";
             foreach($importations as $i){
                $selecti=$selecti."<option value=".$i['Importation']['id'].">".$i['Importation']['name']."</option>";
            }
            $selecti=$selecti.'</select>';      
       
       
       
       
       
       
       echo json_encode(array('selecti'=>$selecti,'select'=>$select,'selectf'=>$selectf,'devise'=>$devise));
       die();
        }  
        
        public function  getarticles(){
            $this->layout = null;
            $this->loadModel('Article');  
            $this->loadModel('Articlefournisseur');
            $this->loadModel('Fournisseur');
            $data = $this->request->data;//debug($data);
           $json = null;
           $articleid= $data['id'];
           $fournisseurid=$data['fid'];
        $article= $this->Article->find('first',array('conditions'=>array('Article.id'=>$articleid),false));
        $frs= $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$fournisseurid),false));
        //debug($frs);
          $tva=$article['Article']['tva'];
          $idart=$article['Article']['id'];
          if($frs['Fournisseur']['devise_id']!=1){
          $prix=$article['Article']['prixachatdevise'];
          }else{
          $prix=$article['Article']['coutrevient'];    
          }
           echo json_encode(array('tva'=>$tva,'prix'=>$prix,'idart'=>$idart));
          die();
     }
     
         public function testnumero() {
            $this->layout = null;
            $data = $this->request->data;
           $numero= $data['numero'];
           $controller= $data['controller'];
           $this->loadModel($controller);
           $exist=0;
           $num= $this->$controller->find('first',array('conditions'=>array($controller.'.numero'=>$numero),false)); 
           // debug($Carnet);
           if(!empty($num)){
              $exist=1;
           }
            echo $exist;  
            die;
        }
     public function recap() {
            $this->loadModel('Article'); 
            $this->loadModel('Lignedevi'); 
            $this->loadModel('Commandeclient');
            $this->loadModel('Lignecommandeclient');
            $this->loadModel('Factureclient');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Client');
            
             $this->layout = null;
             $data=$this->request->data;
             $articleid= $data['article_id'];
             $index_kbira= $data['index'];
             $tableligne= $data['tableligne'];
             
            $article= $this->Article->find('first',array('conditions'=>array('Article.id'=>$articleid),false));
            $pv=$article['Article']['prixvente'];
            $marge=$article['Article']['marge'];
            
            
                
                 $this->set(compact('tableligne','pv','marge','lignelivrisons','lignefactures','name','index_kbira'));
               
	}
        
}
