<?php
App::uses('AppController', 'Controller');
/**
 * Factures Controller
 *
 * @property Facture $Facture
 */
class FacturesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
             $lien=  CakeSession::read('lien_achat');
               $facture="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factures'){
                        $facture=1;
                }}}
              if (( $facture <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		 $this->loadModel('Fournisseur');       
       $this->loadModel('Utilisateur');  
        $this->loadModel('Exercice'); 
       $exercices = $this->Exercice->find('list');
       $pv="";
       $p=CakeSession::read('pointdevente');
       if($p>0){
          $pv= 'Facture.pointdevente_id = '.$p;
       }
         if (isset($this->request->data) && !empty($this->request->data)) {
       //debug($this->request->data);die;
        if ($this->request->data['Facture']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Facture']['date1'])));
            $cond1 = 'Facture.date >= '."'".$date1."'";
        }
        
        if ($this->request->data['Facture']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Facture']['date2'])));
            $cond2 = 'Facture.date <= '."'".$date2."'";
        }
        
       if ($this->request->data['Facture']['fournisseur_id']) {
            $fournisseurid = $this->request->data['Facture']['fournisseur_id'];
            $cond3 = 'Facture.fournisseur_id ='.$fournisseurid;
        } 
        $user=CakeSession::read('users');
            $cond4 = 'Facture.utilisateur_id ='.$user;
         
        if ($this->request->data['Facture']['type_id']) {
            $typeid = $this->request->data['Facture']['type_id'];
            if($typeid==2){ $type="service";
            $cond5 = 'Facture.type ='."'".$type."'";
            }else{ $type="service";
            $cond5 = 'Facture.type <>'."'".$type."'";   
            }
        } 
         if ($this->request->data['Facture']['exercice_id']) {
            $exerciceid = $this->request->data['Facture']['exercice_id'];
            $cond6 = 'Facture.exercice_id ='.$exercices[$exerciceid];
        } 
    } 
  $factures = $this->Facture->find('all', array( 'conditions' => array('Facture.id > ' => 0,$pv, @$cond1, @$cond2, @$cond3,@$cond4,@$cond5,@$cond6 )));
       
		$types[1]="Achat produits";
		$types[2]="Services";
                $fournisseurs = $this->Fournisseur->find('list');
                $utilisateurs = $this->Utilisateur->find('list');
                 $this->set(compact('exercices','date1','date2','fournisseurid','utilisateurid','fournisseurs','typeid','types','utilisateurs','factures',$this->paginate()));
	
	}


	public function view($id = null) {
            $lien=  CakeSession::read('lien_achat');
               $facture="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factures'){
                        $facture=1;
                }}}
              if (( $facture <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Article');
            $this->loadModel('Fournisseur');
             $this->loadModel('Lignefacture');
             $this->loadModel('Stockdepot');
             $this->loadModel('Articlefournisseur');
		if (!$this->Facture->exists($id)) {
			throw new NotFoundException(__('Invalid facture'));
		}
		$options = array('conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
                
                $lignefactures = $this->Lignefacture->find('all',array(
                    'conditions'=>array('Lignefacture.facture_id' => $id)
                    ));
                    
                $facture=$this->Facture->find('first', $options);
                $articles=$this->Article->find('list');  
		$fournisseurs = $this->Facture->Fournisseur->find('list');
		$this->set(compact('facture','fournisseurs','articles','lignefactures','day','types'));   
	}
         
        public function imprimer($id = null) {
           $lien=  CakeSession::read('lien_achat');
               $facture="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factures'){
                        $facture=$liens['imprimer'];
                }}}
              if (( $facture <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Lignefacture');
            $this->loadModel('Article');
		if (!$this->Facture->exists($id)) {
			throw new NotFoundException(__('Invalid facture'));
		}
		$options = array('conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
		$this->set('facture', $this->Facture->find('first', $options));
                $facture=$this->Facture->find('first', $options);
                $articles=$this->Article->find('list'); 
                $lignefactures = $this->Lignefacture->find('all',array(
                    'conditions'=>array('Lignefacture.facture_id' => $id)
                    ));
                 $this->set(compact('facture','lignefactures','articles'));
	}
        
         public function imprimerfactureservice($id = null) {
           $lien=  CakeSession::read('lien_achat');
               $facture="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factures'){
                        $facture=$liens['imprimer'];
                }}}
              if (( $facture <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Facture->exists($id)) {
			throw new NotFoundException(__('Invalid facture'));
		}
		$options = array('conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
		$this->set('facture', $this->Facture->find('first', $options));
                $facture=$this->Facture->find('first', $options);
                 $this->set(compact('facture'));
	}

        public function addfactureservice() {
            $lien=  CakeSession::read('lien_achat');
               $facture="";
               
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factures'){
                        $facture=$liens['add'];
                }}}
              if (( $facture <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
		if ($this->request->is('post')) {
                    $this->request->data['Facture']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Facture']['date'])));
			$this->request->data['Facture']['utilisateur_id']= CakeSession::read('users');
                         $this->request->data['Facture']['pointdevente_id']= CakeSession::read('pointdevente');
                        $this->request->data['Facture']['exercice_id']= date("Y");
                        $this->request->data['Facture']['type']='service';
			$this->Facture->create();
			if ($this->Facture->save($this->request->data)) {
                    
				$this->Session->setFlash(__('The facture has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
			}
		}
		$fournisseurs = $this->Facture->Fournisseur->find('list',array('conditions'=>array('Fournisseur.famillefournisseur_id'=>1),false)); 
		$this->set(compact('fournisseurs'));
	}
        
	public function add() {
            $lien=  CakeSession::read('lien_achat');
               $facture="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factures'){
                        $facture=$liens['add'];
                }}}
              if (( $facture <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Article');       
            $this->loadModel('Lignefacture');
            $this->loadModel('Stockdepot');
            $this->loadModel('Fournisseur');
            $this->loadModel('Tracemodificationprixdevente');
		if ($this->request->is('post')) {
                   //debug($this->request->data);die;
                    $this->request->data['Facture']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Facture']['date'])));
			$this->request->data['Facture']['utilisateur_id']= CakeSession::read('users');
                        $this->request->data['Facture']['pointdevente_id']= CakeSession::read('pointdevente');
                        $this->request->data['Facture']['exercice_id']= date("Y");
                        $this->request->data['Facture']['type']='direct';
                        $depotid=$this->request->data['Facture']['depot_id'];
			$this->Facture->create();
			if ($this->Facture->save($this->request->data)) {
                            
                            $id=$this->Facture->id;
                        // debug($id);die;
                              $Lignefactures=array();
                              foreach (  $this->request->data['Lignefacture'] as $i=>$f   ){
                                 
                                    //debug($f);die;
                              if ($f['sup']!=1){
                                $Lignefactures['facture_id']=$id;
                                $Lignefactures['article_id']=$f['article_id']=$this->request->data['Lignefacture'][$i]['article_id'];
                                $Lignefactures['quantite']=$f['quantite'];
                                if(!empty($f['prix'])){
                                $Lignefactures['prix']=$f['prix'];
                                }
                                $Lignefactures['prixhtva']=$f['prixhtva'];
                                $Lignefactures['remise']=@$f['remise'];
                                $Lignefactures['fodec']=@$f['fodec'];
                                $Lignefactures['tva']=$f['tva'];
                                $Lignefactures['prixhtva']=$f['prixhtva'];
                                $Lignefactures['totalht']=($f['prixhtva']*(1-@$f['remise']*0.01))*$f['quantite'];
                                $Lignefactures['totalttc']=((($Lignefactures['totalht'])*(1+(@$f['fodec']*0.01)))*(1+($f['tva']*0.01)));  
                                     $this->Lignefacture->create();
                                     $this->Lignefacture->save($Lignefactures); 
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
                                
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Lignefactures['article_id'],'Stockdepot.depot_id'=>$depotid),false)); 
                                if (!empty($stckdepot)){
                               $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+'.$f['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                //$this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }else{
                                       $f['depot_id']=$depotid;
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($f); 
                                   }
                               // $this->Stockdepot->deleteAll(array('Stockdepot.article_id'=>$Lignefactures['article_id'],'Stockdepot.depot_id'=>$depotid,'Stockdepot.quantite'=>0),false);        
                                 
                              }
                             } 
                            
				$this->Session->setFlash(__('The facture has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
			}
		}
                $articles=$this->Article->find('list');
		$fournisseurs = $this->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id'=>1)));
		$utilisateurs = $this->Facture->Utilisateur->find('list');
                $timbre = $this->Facture->Timbre->find('list',array('fields' => array('Timbre.timbre')));
                $depots = $this->Facture->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('fournisseurs','timbre', 'utilisateurs','depots','articles'));
	}
               
        public function addindirect($tab=null) {
             $lien=  CakeSession::read('lien_achat');
               $facture="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factures'){
                        $facture=$liens['add'];
                }}}
              if (( $facture <> 1)||(empty($lien))){
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
            //debug($tab.'---'.$listf);
            list($table,$listf)=explode(";",$tab);
            if ($table=='commande'){
               $tab=$listf;
               $b=1;
            }else{
               $tab=$listf;
               $b=0; 
            }
            $tbr=$tab.',0)';
            list($idbr,$resteidbr)=explode(",",$tbr);
            $tbr='(0,'.$tbr;
            $idbrs=explode(",",$tab);
            //debug($tbr);
            //debug($table);
            if($b==0) {
            $bonreception = $this->Bonreception->find('first', array('fields'=>array('SUM(Bonreception.remise) remise','SUM(Bonreception.fodec ) fodec ','SUM(Bonreception.tva) tva','SUM(Bonreception.totalht) totalht'
            ,'SUM(Bonreception.totalttc) totalttc','AVG(Bonreception.fournisseur_id) fournisseur_id','AVG(Bonreception.importation_id) importation_id','AVG(Bonreception.coefficient) coefficient','AVG(Bonreception.depot_id) depot_id'),'conditions' => array('Bonreception.id'=>$idbrs),'recursive'=>-2));
            //debug($bonreception);
            
             $lignebonreceptions=$this->Lignereception->find('all', array('fields'=>array('AVG(Lignereception.article_id) article_id','(Lignereception.article_id) article_iddd'
             ,'SUM(Lignereception.quantite) quantite','SUM(Lignereception.remise*Lignereception.quantite) remise','SUM(Lignereception.prix*Lignereception.quantite) prix'
             ,'AVG(Lignereception.tva) tva','AVG(Lignereception.fodec) fodec','SUM(Lignereception.totalht) totalht','SUM(Lignereception.totalttc)totalttc','SUM(Lignereception.prixhtva )prixhtva ')
            ,'conditions' => array('Lignereception.bonreception_id in'.$tbr),'recursive'=>-2
            ,'group'=>array('Lignereception.article_id')));
            //debug($lignebonreceptions);     
            }else{
            $bonreception = $this->Commande->find('first', array('fields'=>array('SUM(Commande.remise) remise','SUM(Commande.fodec ) fodec ','SUM(Commande.tva) tva','SUM(Commande.totalht) totalht'
            ,'SUM(Commande.totalttc) totalttc','AVG(Commande.fournisseur_id) fournisseur_id','AVG(Commande.importation_id) importation_id','AVG(Commande.coefficient) coefficient','AVG(Commande.depot_id) depot_id'),'conditions' => array('Commande.id'=>$idbrs),'recursive'=>-2));
            //debug($bonreception);
            
             $lignebonreceptions=$this->Lignecommande->find('all', array('fields'=>array('AVG(Lignecommande.article_id) article_id','(Lignecommande.article_id) article_iddd'
             ,'SUM(Lignecommande.quantite) quantite','SUM(Lignecommande.remise*Lignecommande.quantite) remise','SUM(Lignecommande.prix*Lignecommande.quantite) prix'
             ,'AVG(Lignecommande.tva) tva','AVG(Lignecommande.fodec) fodec','SUM(Lignecommande.totalht) totalht','SUM(Lignecommande.totalttc)totalttc','SUM(Lignecommande.prixhtva )prixhtva ')
            ,'conditions' => array('Lignecommande.commande_id in'.$tbr),'recursive'=>-2
            ,'group'=>array('Lignecommande.article_id')));
            //debug($lignebonreceptions); 
            } 
            if ($this->request->is('post')) {
                  // debug($this->request->data);die;
                        $this->request->data['Facture']['commande_id']=$tbr;
                        $this->request->data['Facture']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Facture']['date'])));
			$this->request->data['Facture']['utilisateur_id']= CakeSession::read('users');
                        $this->request->data['Facture']['pointdevente_id']= CakeSession::read('pointdevente');
                        $this->request->data['Facture']['exercice_id']= date("Y");
                        $tc=$this->request->data['Facture']['tr'];
                        $coe=$this->request->data['Facture']['coe'];
                       if($b==1) {    
                           $depotid=$this->request->data['Facture']['depot_id'];
                           $this->request->data['Facture']['type']='indirect';
                           foreach ( $idbrs as $c){
                           $this->Commande->updateAll(array('Commande.validite_id' =>3), array('Commande.id' =>$c));
                           }
                        }else {
                        $this->request->data['Facture']['type']='indirect';
                        foreach ( $idbrs as $c){
                        $this->Bonreception->updateAll(array('Bonreception.etat' =>1), array('Bonreception.id' =>$c));
                        }
                        }
                        
                   //  debug($this->request->data);die;
			$this->Facture->create();
			if ($this->Facture->save($this->request->data)) {
                            $id=$this->Facture->id;
                            // inserer le facture_id dans les  bons de receptions ou les commandes cochés********************
                                                $idbrs=explode(",",$tab);
                                             //   debug($idbrs);die;
                                               foreach (  $idbrs as $br   ){ 
                                $this->Bonreception->updateAll(array('Bonreception.facture_id' => $id ), array('Bonreception.id' =>$br));
                                $this->Commande->updateAll(array('Commande.facture_id' =>$id), array('Commande.id' =>$br));
                                               }  
                       
                              $Lignefactures=array();
                              $totale_facture_devise=0;
                              foreach (  $this->request->data['Lignedeviprospect'] as $f   ){
                                 
                              if ($f['sup']!=1){
                                $Lignefactures['facture_id']=$id;
                                $Lignefactures['article_id']=$f['article_id'];
                                $Lignefactures['quantite']=$f['quantite'];
                                if(!empty($f['prix'])){
                                $Lignefactures['prix']=$f['prix'];
                                }
                                $Lignefactures['prixhtva']=$f['prixhtva'];
                                $Lignefactures['remise']=@$f['remise'];
                                $Lignefactures['fodec']=@$f['fodec'];
                                $Lignefactures['tva']=$f['tva'];
                                $Lignefactures['prixhtva']=$f['prixhtva'];
                                $Lignefactures['totalht']=($f['prixhtva']*(1-@$f['remise']*0.01))*$f['quantite'];
                                $Lignefactures['totalttc']=((($Lignefactures['totalht'])*(1+(@$f['fodec']*0.01)))*(1+($f['tva']*0.01)));  
                                     $this->Lignefacture->create();
                                     $this->Lignefacture->save($Lignefactures);
                                $this->Article->updateAll(array('Article.coutrevient' =>$f['prixhtva'],'Article.tauxchange' =>$tc,'Article.coefficient' =>$coe,'Article.prixachatdevise' =>$f['prix']), array('Article.id' =>$f['article_id']));
                                if(!empty($f['prix'])){
                                $totale_facture_devise=$totale_facture_devise+($f['prix']*$f['quantite']);
                                $this->Facture->updateAll(array('Facture.totaldevise' =>$totale_facture_devise), array('Facture.id' =>$id));
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
                                     
                                     if ($b==1) {
                                         
                                        $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Lignefactures['article_id'],'Stockdepot.depot_id'=>$depotid),false)); 
                                if (!empty($stckdepot)){
                               $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+'.$f['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                //$this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }else{
                                       $f['depot_id']=$depotid;
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($f); 
                                   } 
                                         
                                         
                                     }
                                       
                              }
                             } 
                            
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
        //debug($devise);
        $this->set(compact('impo','name','devise','importations','tot_coe','coe','tr','lignebonreceptions','bonreception','fournisseurs','lignefactures','articles','fournisseurid','depots'));
	}

        public function addbonentre($id = null) {
             $lien=  CakeSession::read('lien_achat');
               $x="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonentres'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Lignefacture');
             $this->loadModel('Stockdepot');
             $this->loadModel('Article');
             $this->loadModel('Depot');
             $this->loadModel('Bonreception');
             $this->loadModel('Bonentre');
             $this->loadModel('Ligneentre');
		if (!$this->Facture->exists($id)) {
			throw new NotFoundException(__('Invalid facture'));
		}
		if ($this->request->is('post')) {
                   //debug($this->request->data );die;
                    $this->request->data['Bonentre']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonentre']['date'])));
	            $this->request->data['Bonentre']['utilisateur_id']= CakeSession::read('users');
                    $this->request->data['Bonentre']['facture_id']=$id;
                    $this->Bonentre->create();
                     if(!empty($this->request->data['Lignereception'])){
			if ($this->Bonentre->save($this->request->data)) {
                         $idbe=$this->Bonentre->id; 
                               foreach (  $this->request->data['Lignereception'] as $i=>$f   ){  
                                    
                                if ($f['sup']!=1){
                                    $Ligneentres['bonentre_id']=$idbe;
                                    $Ligneentres['lignefacture_id']=$f['id'];
                                    $Ligneentres['article_id']=$Lignefactures['article_id'];
                                    if ($f['datevalidite']!= '__/__/____'){
                                    $Ligneentres['date']=date("Y-m-d",strtotime(str_replace('/','-',$f['datevalidite'])));
                                    $cond='Stockdepot.date = '."'".$Ligneentres['date']."'";}
                                    $Ligneentres['depot_id']=$f['Detail'][0]['depot_id'];
                                    $Ligneentres['quantite']=$f['Detail'][0]['qte'];
                                           $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Ligneentres['article_id'],'Stockdepot.depot_id'=>$Ligneentres['depot_id'],@$cond),false)); 
                                           if (!empty($stckdepot)){
                                                $qtett= $Ligneentres['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qtett), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                                $sdid=$stckdepot[0]['Stockdepot']['id'];
                                            }else{
                                                $this->Stockdepot->create();
                                                $this->Stockdepot->save($Ligneentres); 
                                                $sdid=$this->Stockdepot->id;
                                            }
                                    $Ligneentres['stockdepot_id']=$sdid;        
                                    $this->Ligneentre->create();
                                    $this->Ligneentre->save($Ligneentres); 
                                    
                                        if($f['quantite']>$f['Detail'][0]['qte']){
                                            foreach (  $this->request->data['Detail'.$i] as $di   ){ 
                                                if ($di['sup']!=1){
                                                    $Ligneentres['bonentre_id']=$idbe;
                                                    $Ligneentres['lignefacture_id']=$f['id'];
                                                    $Ligneentres['article_id']=$Lignefactures['article_id'];
                                                    if ($f['datevalidite']!= '__/__/____'){
                                                    $Ligneentres['date']=date("Y-m-d",strtotime(str_replace('/','-',$f['datevalidite'])));
                                                    $cond='Stockdepot.date = '."'".$Ligneentres['date']."'";}
                                                    $Ligneentres['depot_id']=$di['depot_id'];
                                                    $Ligneentres['quantite']=$di['qte'];  
                                                       
                                                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Ligneentres['article_id'],'Stockdepot.depot_id'=>$Ligneentres['depot_id'],@$cond),false)); 
                                                            if (!empty($stckdepot)){
                                                                 $qtett= $Ligneentres['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                                                 $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qtett), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                                                 $sdid=$stckdepot[0]['Stockdepot']['id'];
                                                            }else{
                                                                 $this->Stockdepot->create();
                                                                 $this->Stockdepot->save($Ligneentres); 
                                                                 $sdid=$this->Stockdepot->id;
                                                            }
                                                    $Ligneentres['stockdepot_id']=$sdid;        
                                                    $this->Ligneentre->create();
                                                    $this->Ligneentre->save($Ligneentres);         
                                                       
                                                }    
                                            }
                                        }
                                }
                             } 
                              
                             $this->Facture->updateAll(array('Facture.etat' =>1), array('Facture.id' =>$id));       
                              
				$this->Session->setFlash(__('The bonentre has been saved'));
				$this->redirect(array('action' => 'index'));    
			} else {
				$this->Session->setFlash(__('le bon d entre dois avoir aux moins une ligne de entre.'));
                        }
		}
                }
         $lignereceptions = $this->Lignefacture->find('all',array('conditions'=>array('Lignefacture.facture_id' => $id)));  
         

           $numero = $this->Bonentre->find('all', array('fields' =>
            array(
                'MAX(Bonentre.numero) as num'
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
                $articles = $this->Article->find('list');
		$fournisseurs = $this->Facture->Fournisseur->find('list');
		$utilisateurs = $this->Facture->Utilisateur->find('list');
		$depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('fournisseurs', 'utilisateurs', 'depots','lignereceptions','articles','mm'));   
        }
        
	public function edit($id = null) {
             $lien=  CakeSession::read('lien_achat');
               $facture="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factures'){
                        $facture=$liens['edit'];
                }}}
              if (( $facture <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Depot');      
             $this->loadModel('Article');
             $this->loadModel('Fournisseur');
             $this->loadModel('Lignefacture');
             $this->loadModel('Stockdepot');
             $this->loadModel('Articlefournisseur');
             $this->loadModel('Importation');
             $this->loadModel('Tracemodificationprixdevente');
             
		if (!$this->Facture->exists($id)) {
			throw new NotFoundException(__('Invalid facture'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    //debug( $this->request->data);die;
                       $this->request->data['Facture']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Facture']['date'])));
			$this->request->data['Facture']['utilisateur_id']= CakeSession::read('users');
                        
                        $facture= $this->Facture->find('first',array('conditions'=>array('Facture.id'=>$id),false));
                             $Lignefactures=array();
                             $lignefactureanciens= $this->Lignefacture->find('all',array('conditions'=>array('Lignefacture.facture_id'=>$id),false));
                            foreach (  $lignefactureanciens as $lra   ){
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite-'.$lra['Lignefacture']['quantite']), array('Stockdepot.article_id' =>$lra['Lignefacture']['article_id'],'Stockdepot.depot_id' =>$facture['Facture']['depot_id']));
                            } 
                           $this->Stockdepot->deleteAll(array('Stockdepot.quantite'=>0),false);
                           $this->Lignefacture->deleteAll(array('Lignefacture.facture_id'=>$id),false); 
                           
                           if ($this->Facture->save($this->request->data)) {
                           
                           if (!empty($this->request->data['Lignefacture'])){
                              foreach (  $this->request->data['Lignefacture'] as $f   ){
                                 
                                   //  debug($f);die;
                              if ($f['sup']!=1){
                                $Lignefactures['id']=$f['id'];
                                $Lignefactures['facture_id']=$id;
                                $Lignefactures['article_id']=$f['article_id'];
                                $Lignefactures['quantite']=$f['quantite'];
                                if(!empty($f['prix'])){
                                $Lignefactures['prix']=$f['prix'];
                                }
                                $Lignefactures['prixhtva']=$f['prixhtva'];
                                $Lignefactures['remise']=@$f['remise'];
                                $Lignefactures['fodec']=@$f['fodec'];
                                $Lignefactures['tva']=$f['tva'];
                                $Lignefactures['prixhtva']=$f['prixhtva'];
                                $Lignefactures['totalht']=($f['prixhtva']*(1-@$f['remise']*0.01))*$f['quantite'];
                                $Lignefactures['totalttc']=((($Lignefactures['totalht'])*(1+(@$f['fodec']*0.01)))*(1+($f['tva']*0.01))); 
                                  $this->Lignefacture->create();
                                  $this->Lignefacture->save($Lignefactures);
                                if(!empty($f['prix'])){
                                $tc=$this->request->data['Facture']['tr'];
                                $coe=$this->request->data['Facture']['coe'];    
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
                                     $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$this->request->data['Facture']['depot_id']))); 
                         // debug($stckdepot);die;     
                          if (!empty($stckdepot)){
                              $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+'.$f['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                               // $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }else{
                                       $f['depot_id']=$this->request->data['Facture']['depot_id'];
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($f); 
                                   }
                              }
                              
                             } 
                         }
				$this->Session->setFlash(__('The facture has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
			$this->request->data = $this->Facture->find('first', $options);
                        //debug($this->request->data);
                 $day=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Facture']['date'])));
                 $lignefactures = $this->Lignefacture->find('all',array('conditions'=>array('Lignefacture.facture_id' => $id)));
                 if($this->request->data['Facture']['importation_id']!=0){
                 $importations= $this->Importation->find('list',array('conditions'=>array('Importation.fournisseur_id'=>$this->request->data['Facture']['fournisseur_id'],'Importation.etat'=>0),false));
                 $tr=$this->request->data['Importation']['tauxderechenge'];
                 $coe=$this->request->data['Importation']['coefficien'];
                 }
                 if($this->request->data['Fournisseur']['devise_id']!=1){
                 $fournisseurs = $this->Facture->Fournisseur->find('list');
                 }else{
		 $fournisseurs = $this->Facture->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id'=>1)));
                 }
                 $articles=$this->Article->find('list');
                 $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
                 $timbre = $this->Facture->Timbre->find('list',array('fields' => array('Timbre.timbre')));
                 }
		$this->set(compact('importations','coe','tr','fournisseurs','fournisseur','timbre','lignefactures','day','articles','depots'));
	}

	public function delete($id = null) {
             $lien=  CakeSession::read('lien_achat');
               $facture="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factures'){
                        $facture=$liens['delete'];
                }}}
              if (( $facture <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Stockdepot');      
             $this->loadModel('Lignefacture');
             $this->loadModel('Bonreception');
             $this->loadModel('Commande');
		$this->Facture->id = $id;
		if (!$this->Facture->exists()){
			throw new NotFoundException(__('Invalid facture'));
		}
		$this->request->onlyAllow('post', 'delete');
                $lrs=$this->Lignefacture->find('all',array('conditions'=>array('Lignefacture.facture_id'=>$id))); 
                 //debug($lrs);die;
                  foreach (  $lrs as $lr   ){
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$lr['Lignefacture']['article_id'],'Stockdepot.depot_id'=>$lr['Facture']['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stkdepqte['quantite']= $stckdepot[0]['Stockdepot']['quantite']-$lr['Lignefacture']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stkdepqte['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                              }
                @$reqfactures=$this->Lignefacture->find('all',array('conditions'=>array('Lignefacture.facture_id'=>$id)));
                    foreach (@$reqfactures as $reqfacture){
                        foreach (@$reqfacture['Lignefacture'] as $lf){
                            $this->Lignefacture->deleteAll(array('Lignefacture.id'=>$lf),false);
                        }
                    }
                $this->Bonreception->updateAll(array('Bonreception.facture_id' =>0), array('Bonreception.facture_id' =>$id));    
                $this->Commande->updateAll(array('Commande.facture_id' =>0,'Commande.validite_id' =>2), array('Commande.facture_id' =>$id));
                
		if ($this->Facture->delete()) {
			$this->Session->setFlash(__('Facture deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Facture was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        
        public function imprimerrecherche() { 
         $lien=  CakeSession::read('lien_achat');
               $facture="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factures'){
                        $facture=$liens['imprimer'];
                }}}
              if (( $facture <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
       //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Facture.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Facture.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Facture.fournisseur_id ='.$fournisseurid;
        } 
         if ($this->request->query['utilisateurid']) {
            $utilisateurid = $this->request->query['utilisateurid'];
            $cond4 = 'Facture.utilisateur_id ='.$utilisateurid;
        } 
        if ($this->request->query['typeid']) {
            $typeid = $this->request->query['typeid'];
           if($typeid==2){ $type="service";
            $cond5 = 'Facture.type ='."'".$type."'";
            }else{ $type="service";
            $cond5 = 'Facture.type <>'."'".$type."'";   
            }
        } 
  $factures = $this->Facture->find('all', array( 'conditions' => array('Facture.id > ' => 0, @$cond1, @$cond2, @$cond3,@$cond4,@$cond5 )));

                 $this->set(compact('factures','date1','date2','fournisseurid','utilisateurid'));     
   
         }
        
        public function artfour(){
             $this->layout = null;
             $this->loadModel('Article');
             $this->loadModel('Articlefournisseur');
             $this->loadModel('Fournisseur');

           
         $data = $this->request->data;//debug($data);
         $json = null;
      $fournisseurid= $data['id']; 
      $name='article_id';
      
       $fournisseur= $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$fournisseurid),false));
       $devise=$fournisseur['Fournisseur']['devise_id'];
            //  debug($devise);die;  
      
      $art= $this->Articlefournisseur->find('all',array('conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid),'recursive'=>-1));
      $t='(0,';
            foreach ($art as $l){
                $t=$t.$l['Articlefournisseur']['article_id'].',';
              
            }
            $t=$t.'0)';
           // debug($t);
            
             if ($fournisseurid != 0) { 
            $articles=$this->Article->find('all', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
            $select="<select   name='data[Lignefacture][0][article_id]' table='Lignefacture' index='0' champ='article_id' id='article_id0' class='select form-control idarticle' onchange='tvaart(0)'><option selected disabled hidden value=0> Veuillez choisir</option>";
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
             $selectf="<select name='".$name."' table='Lignefacture' champ='article_id' id='article_id'  class='' onchange='tvaart(ind) testligneinv'><option selected disabled hidden value=0> Veuillez choisir</option>";
            $selectf=$selectf."<option value=''>veullier choisir</option>";
             foreach($articles as $v){
                $selectf=$selectf."<option value=".$v['Article']['id'].">".$v['Article']['name']."</option>";
            }
            $selectf=$selectf.'</select>';
              
             echo json_encode(array('select'=>$select,'selectf'=>$selectf,'devise'=>$devise));
          die();
        }  
}
