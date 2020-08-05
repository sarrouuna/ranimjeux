<?php
App::uses('AppController', 'Controller');
/**
 * Bonlivraisons Controller
 *
 * @property Bonlivraison $Bonlivraison
 */
class BonlivraisonsController extends AppController {

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
                if(@$liens['lien']=='bonlivraisons'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                     $this->loadModel('Client'); 
                      $this->loadModel('Exercice'); 
                      $this->loadModel('Pointdevente');
        $pointdeventes = $this->Pointdevente->find('list');
       $exercices = $this->Exercice->find('list');
       $exe=date('Y');
       $exercice = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
       $exerciceid=$exercice['Exercice']['id'];
        $cond4 = 'Bonlivraison.exercice_id ='.$exe;
        $pv="";
       $p=CakeSession::read('pointdevente');
       //debug($p);die;
       if($p>0){
          $pv= 'Bonlivraison.pointdevente_id = '.$p;
       }
         if (isset($this->request->data) && !empty($this->request->data)) {
       // debug($this->request->data);die;
        if ($this->request->data['Bonlivraison']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonlivraison']['date1'])));
            $cond1 = 'Bonlivraison.date >= '."'".$date1."'";
            $cond4="";
        }
        
        if ($this->request->data['Bonlivraison']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonlivraison']['date2'])));
            $cond2 = 'Bonlivraison.date <= '."'".$date2."'";
            $cond4="";
        }
        
       if ($this->request->data['Bonlivraison']['client_id']) {
            $clientid= $this->request->data['Bonlivraison']['client_id'];
            $cond3 = 'Bonlivraison.client_id ='.$clientid;
        } 
         if ($this->request->data['Bonlivraison']['exercice_id']) {
            $exerciceid = $this->request->data['Bonlivraison']['exercice_id'];
            $cond4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
        } 
        if ($this->request->data['Bonlivraison']['pointdevente_id']) {
            $pointdeventeid = $this->request->data['Bonlivraison']['pointdevente_id'];
            $cond5 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
        } 
        
    } 
  $bonlivraisons = $this->Bonlivraison->find('all', array( 'conditions' => array('Bonlivraison.id > ' => 0,$pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5 )
  ,'order'=>array('Bonlivraison.id'=>'desc')));
    // debug($bonlivraisons);die;
//  foreach ($bonlivraisons as $facture){
//      $id=$facture['Bonlivraison']['id'];
//      $ttc=0;$ht=0;$tva=0;$remise=0;
//      foreach ($facture['Lignelivraison'] as $ligne){
//         $ttc=$ttc+$ligne['totalttc'];
//         $ht=$ht+$ligne['totalht'];
//         $tva=$tva+$ligne['mtva'];
//         $remise=$remise+(($ligne['quantite']*$ligne['prix'])*($ligne['remise']/100));
//      }
//      //$ttc=$ttc+0.500;
//      $this->Bonlivraison->updateAll(array('Bonlivraison.remise' => $remise,'Bonlivraison.tva' => $tva
//      ,'Bonlivraison.totalht' => $ht,'Bonlivraison.totalttc' => $ttc), 
//      array('Bonlivraison.id' => $id));
//  }
                $this->loadModel('Typedipliquation');
		$typedipliquations=$this->Typedipliquation->find('list');
                $clients = $this->Client->find('list');
                 $this->set(compact('typedipliquations','pointdeventes','exerciceid','exercices','date1','date2','clientid','clients','bonlivraisons',$this->paginate()));	
	}
        
        
  public function imprimerrecherche() { 
         $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonlivraisons'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
       $this->loadModel('Client');         
       //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Bonlivraison.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Bonlivraison.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            $cond3 = 'Bonlivraison.client_id ='.$clientid;
        } 
         
  $bonlivraisons = $this->Bonlivraison->find('all', array( 'conditions' => array('Bonlivraison.id > ' => 0, @$cond1, @$cond2, @$cond3 )));

                 $this->set(compact('bonlivraisons','date1','date2','clientid'));     
   
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
                if(@$liens['lien']=='bonlivraisons'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                $this->loadModel('Lignelivraison');
		if (!$this->Bonlivraison->exists($id)) {
			throw new NotFoundException(__('Invalid bonlivraison'));
		}
		$options = array('conditions' => array('Bonlivraison.' . $this->Bonlivraison->primaryKey => $id));
		$this->set('bonlivraison', $this->Bonlivraison->find('first', $options));
                 $lignelivraisons = $this->Lignelivraison->find('all',array(
                    'conditions'=>array('Lignelivraison.bonlivraison_id' => $id)
                    )); 
                 $this->set(compact('lignelivraisons'));
	}
        
        
        
        
        public function imprimer($id = null) {
            $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonlivraisons'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Lignelivraison');
		if (!$this->Bonlivraison->exists($id)) {
			throw new NotFoundException(__('Invalid bonreception'));
		}
		$options = array('conditions' => array('Bonlivraison.' . $this->Bonlivraison->primaryKey => $id));
		$this->set('bonlivraison', $this->Bonlivraison->find('first', $options));
                $lignelivraisons = $this->Lignelivraison->find('all',array(
                    'conditions'=>array('Lignelivraison.bonlivraison_id' => $id)
                    ));
                 $this->set(compact('lignelivraisons'));
	}
 
        
        
        
	public function add() {
             $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonlivraisons'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            
            $this->loadModel('Article');
            $this->loadModel('Depot');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Stockdepot');
            $this->loadModel('Pointdevente');
		if ($this->request->is('post')) {
                    //debug($this->request->data);die;
                        $this->request->data['Bonlivraison']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonlivraison']['date'])));
			$this->request->data['Bonlivraison']['utilisateur_id']= CakeSession::read('users');
                        if(empty($this->request->data['Bonlivraison']['pointdevente_id'])){
                        $this->request->data['Bonlivraison']['pointdevente_id']= CakeSession::read('pointdevente');
                        }
                        $this->request->data['Bonlivraison']['exercice_id']=date("Y");
                        
         $pv= CakeSession::read('pointdevente'); 
         if($pv==0) {
          $pv=$this->request->data['Bonlivraison']['pointdevente_id'];   
         }
         $numero = $this->Bonlivraison->find('all',
         array('fields' =>array('MAX(Bonlivraison.numeroconca) as num'),
          'conditions' => array('Bonlivraison.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {  
   $getexercice= $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.numeroconca'=>$n)));
  $anne=$getexercice['Bonlivraison']['exercice_id'];  
       if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            }
           else {
                $mm = "000001";
            }  
            
       } else {
                $mm = "000001";
            }
                $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
                        
                        $this->request->data['Bonlivraison']['numeroconca']=$mm;
                        $this->request->data['Bonlivraison']['numero']=$numspecial;
			$this->Bonlivraison->create();
                  if(!empty($this->request->data['Lignelivraison'])){
			if ($this->Bonlivraison->save($this->request->data)) {
                         $id=$this->Bonlivraison->id;
                        // debug($id);die;
                              $Lignelivraisons=array();
                              $stockdepots=array(); 
                              foreach (  $this->request->data['Lignelivraison'] as $numl=>$f   ){
                                 
                                 //  debug($f);die;
                              if ($f['sup']!=1){
                                 
                                $stockdepots[$numl]['quantite']=$f['quantite'];  
                                $Lignelivraisons['bonlivraison_id']=$id;
                                $Lignelivraisons['depot_id']=$f['depot_id'];
                                $Lignelivraisons['article_id']=$f['article_id'];
                                $Lignelivraisons['quantite']=$f['quantite'];
                                $Lignelivraisons['remise']=$f['remise'];
                                $Lignelivraisons['tva']=$f['tva'];
                                $Lignelivraisons['prix']=$f['prixhtva'];
                                $Lignelivraisons['prixnet']=$f['prixnet'];
                                $Lignelivraisons['puttc']=$f['puttc'];
                                $Lignelivraisons['totalhtans']=$f['totalhtans'];
                                $Lignelivraisons['designation']=$f['designation'];
                                $Lignelivraisons['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignelivraisons['totalttc']=((($Lignelivraisons['totalht']))*(1+($f['tva']*0.01)));  
                                     $this->Lignelivraison->create();
                                     $this->Lignelivraison->save($Lignelivraisons);
                                     
                                      $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$stockdepots[$numl]['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                             
                                $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
                              }
                             }
                             
				$this->Session->setFlash(__('The bonlivraison has been saved'));
				$this->redirect(array('action' => 'index'));  
                                //$this->redirect(array('action' => 'addbonsorti/'.$id));
			} else {
				$this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                        }
		}
                }
           $pv= CakeSession::read('pointdevente'); 
           //debug($pv);die;
         if($pv!=0) {
         $numero = $this->Bonlivraison->find('all',
         array('fields' =>array('MAX(Bonlivraison.numeroconca) as num'),
          'conditions' => array('Bonlivraison.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {  
   $getexercice= $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.numeroconca'=>$n)));
  $anne=$getexercice['Bonlivraison']['exercice_id'];  
  if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            }
           else {
                $mm = "000001";
            }  
            
       } else {
                $mm = "000001";
            }
        
                $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                //debug($pointvente);die;
                $numspecial=$abrivation."/".$mm."/".date("Y");
         }else{
             $mm=0;
         }
		$clients = $this->Bonlivraison->Client->find('list');
		$utilisateurs = $this->Bonlivraison->Utilisateur->find('list');
		$p=CakeSession::read('depot');
                if($p==0){
         	$depots = $this->Depot->find('list');
                }else{
         	$depots = $this->Depot->find('list',array('conditions'=>array('Depot.id'=>$p)));
                }
                 $articles=$this->Article->find('list', array( 'conditions' => array('Article.typeetatarticle_id'=>1),'recursive'=>-1)) ;
                $pointdeventes=$this->Pointdevente->find('list');
		$this->set(compact('pointdeventes','numspecial','clients', 'utilisateurs', 'depots','articles','mm'));
	}
        
        
        
        //jeya mel commande
     public function addindirect($tab=null) {
           $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonlivraisons'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
        // debug($tab);die;
            $this->loadModel('Reglementclient');       
            $this->loadModel('Article');
            $this->loadModel('Depot');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Lignecommandeclient');
            $this->loadModel('Commandeclient');
            $this->loadModel('Client');
            $this->loadModel('Stockdepot');
            $this->loadModel('Pointdevente');
            $tbr=$tab.',0)';
            list($idbr,$resteidbr)=explode(",",$tbr);
            $tbr='(0,'.$tbr;
           // debug($idbr);die;
            $idlcs=array();
            $idlcs=explode(",",$tab); 
            
            
            $clientid = $this->Commandeclient->find('first', array('fields'=>array('pointdevente_id','SUM(Commandeclient.remise) remise','SUM(Commandeclient.tva) tva','SUM(Commandeclient.totalht) totalht'
            ,'SUM(Commandeclient.totalttc) totalttc','AVG(Commandeclient.client_id) client_id'),'conditions' => array('Commandeclient.id'=>$idlcs),'recursive'=>-2));
           //debug($clientid);die;
            
             $lignelivraisons=$this->Lignecommandeclient->find('all', array('fields'=>array('AVG(Lignecommandeclient.article_id) article_id','AVG(Lignecommandeclient.depot_id) depot_id','(Lignecommandeclient.article_id) article_iddd','(Lignecommandeclient.id) id'
             ,'SUM(Lignecommandeclient.quantite) quantite','SUM(Lignecommandeclient.quantiteliv) quantiteliv','SUM(Lignecommandeclient.remise*Lignecommandeclient.quantite) remise','SUM(Lignecommandeclient.prix*Lignecommandeclient.quantite) prix'
             ,'AVG(Lignecommandeclient.tva) tva','SUM(Lignecommandeclient.totalht) totalht','SUM(Lignecommandeclient.totalttc)totalttc','SUM(Lignecommandeclient.prixnet*Lignecommandeclient.quantite) prixnet','SUM(Lignecommandeclient.puttc*Lignecommandeclient.quantite) puttc')
            ,'conditions' => array('Lignecommandeclient.commandeclient_id in'.$tbr),'recursive'=>-2
            ,'group'=>array('Lignecommandeclient.article_id','Lignecommandeclient.depot_id')));
             
          // debug($lignelivraisons);
             
             
		if ($this->request->is('post')) {
                   //debug($this->request->data);die;
                     $this->request->data['Bonlivraison']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonlivraison']['date'])));
	             $this->request->data['Bonlivraison']['utilisateur_id']= CakeSession::read('users');
                     $this->request->data['Bonlivraison']['client_id']= $clientid[0]['client_id'];
                       if(empty($this->request->data['Bonlivraison']['pointdevente_id'])){
                        $this->request->data['Bonlivraison']['pointdevente_id']= CakeSession::read('pointdevente');
                        }                         
                        $this->request->data['Bonlivraison']['exercice_id']=date("Y");
                        
         $pv= CakeSession::read('pointdevente'); 
         if($pv==0) {
          $pv=$this->request->data['Bonlivraison']['pointdevente_id'];   
         }
         $numero = $this->Bonlivraison->find('all',
         array('fields' =>array('MAX(Bonlivraison.numeroconca) as num'),
          'conditions' => array('Bonlivraison.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {  
   $getexercice= $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.numeroconca'=>$n)));
  $anne=$getexercice['Bonlivraison']['exercice_id'];  
       if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            }
           else {
                $mm = "000001";
            }  
            
       } else {
                $mm = "000001";
            }
                $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
                        
                        $this->request->data['Bonlivraison']['numeroconca']=$mm;
                        $this->request->data['Bonlivraison']['numero']=$numspecial;
			$this->Bonlivraison->create();
                  if(!empty($this->request->data['Lignelivraison'])){
			if ($this->Bonlivraison->save($this->request->data)) {
                            foreach ($idlcs as $idc){
                             $this->Commandeclient->updateAll(array('Commandeclient.etat' =>1), array('Commandeclient.id' =>$idc));       
                            }
                         $id=$this->Bonlivraison->id;
                        // debug($id);die;
                              $Lignelivraisons=array();
                               $stockdepots=array();
                               //debug($this->request->data );die;
                              foreach (  $this->request->data['Lignelivraison'] as $numl=>$f   ){
                                 
                                 //  debug($f);die;
                              if ($f['sup']!=1){
                                  
                                $stockdepots[$numl]['quantite']=$f['quantiteliv'];   
                                $Lignelivraisons['bonlivraison_id']=$id;
                                $Lignelivraisons['depot_id']=$f['depot_id'];
                                $Lignelivraisons['article_id']=$f['article_id'];
                                $Lignelivraisons['quantite']=$f['quantite'];
                                $Lignelivraisons['quantitelivrai']=$f['quantiteliv'];
                                $Lignelivraisons['remise']=$f['remise'];
                                $Lignelivraisons['tva']=$f['tva'];
                                $Lignelivraisons['prix']=$f['prixhtva'];
                                $Lignelivraisons['prixnet']=$f['prixnet'];
                                $Lignelivraisons['puttc']=$f['puttc'];
                                $Lignelivraisons['totalhtans']=$f['totalhtans'];
                                $Lignelivraisons['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignelivraisons['totalttc']=((($Lignelivraisons['totalht']))*(1+($f['tva']*0.01)));  
                                     $this->Lignelivraison->create();
                                     $this->Lignelivraison->save($Lignelivraisons);
                                     
                                $lignecommandeclients = $this->Lignecommandeclient->find('all',array(
                                 'conditions'=>array('Lignecommandeclient.commandeclient_id in'.$tbr,'Lignecommandeclient.article_id' =>$f['article_id']),'recursive'=>-1
                                ));
                               $int=$f['quantiteliv'];
                                foreach (  $lignecommandeclients as $n=>$lbl   ){
                                    $reste=$lbl['Lignecommandeclient']['quantite']-$lbl['Lignecommandeclient']['quantiteliv']; 
                                    if($int>0){
                                    if($reste>=$int){
                                        $qtee=$int;
                                        $int=0;
                                    }
                                    if($reste<$int){
                                        $qtee=$reste;
                                        $int=$int-$reste;
                                    }
                                $this->Lignecommandeclient->updateAll(array('Lignecommandeclient.quantiteliv' =>'Lignecommandeclient.quantiteliv +'.$qtee), array('Lignecommandeclient.id' =>$lbl['Lignecommandeclient']['id']));
                                    }  
                                  } 
                               
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantiteliv']=$stckdepot[0]['Stockdepot']['quantite']-$stockdepots[$numl]['quantiteliv'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantiteliv']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                                   $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);                              
                                   
                                   }
                             } 
				$this->Session->setFlash(__('The bonlivraison has been saved'));
				//$this->redirect(array('action' => 'addbonsorti/'.$id)); 
                                $this->redirect(array('action' => 'index')); 
			} else {
				$this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                        }
		}
                }
                
       $pv= CakeSession::read('pointdevente'); 
          if($pv==0){
             $pv=$clientid['Commandeclient']['pointdevente_id'];
             } 
         $numero = $this->Bonlivraison->find('all',
         array('fields' =>array('MAX(Bonlivraison.numeroconca) as num'),
          'conditions' => array('Bonlivraison.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
   $getexercice= $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.numeroconca'=>$n)));
  $anne=$getexercice['Bonlivraison']['exercice_id'];  
  if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            }
           else {
                $mm = "000001";
            }  
            
       } else {
                $mm = "000001";
            }
        
                $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
               
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
                
                
                
                //**************************************trouver la liste des articles pour chaque depot *******************************************************
            foreach (  $lignelivraisons as $ll   ){ 
         $artdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.depot_id'=>$ll[0]['depot_id']),'recursive'=>-1));
            $t='(0';
            foreach ($artdepot as $ad){
              if(!empty($ad['Stockdepot']['article_id'])){
                $t=$t.','.$ad['Stockdepot']['article_id'];
              }
            }
            $t=$t.')';
        
            $articles=$this->Article->find('list', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
            $tabqtestock[$ll[0]['depot_id']]['articles']=$articles;

    //**************************************trouver les qte en stock de chaque article pour chaque depot *******************************************************

                $artstocks=$this->Article->find('all', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ; 
                    //debug($artstocks);die;
                     foreach ($artstocks as $i=>$as){
                          $qtestock=0;
                       $stockdepots= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$as['Article']['id'],
                           'Stockdepot.depot_id'=>$ll[0]['depot_id']),false));  
                       foreach (  $stockdepots as $stkdepot   ){
                                    $qtestock=$qtestock+$stkdepot['Stockdepot']['quantite'];   
                                }
                           $tabqtestock[$ll[0]['depot_id']][$as['Article']['id']]['qtestock']=$qtestock;    
                     }
                 }
            
  //******************************************fin***********************************************************************************************************          
           // debug($tabqtestock);die;
            //debug($tabqtestock['1.0000'][1]['qtestock']);die;
                 
                 
                 
                 
                
		$client = $this->Client->find('first', array( 'conditions' => array('Client.id'=>$clientid[0]['client_id']),'recursive'=>-2));
                $pntv=$clientid['Commandeclient']['pointdevente_id'];
                $client=$client['Client']['name'];
		$utilisateurs = $this->Bonlivraison->Utilisateur->find('list');
                 $articles=$this->Article->find('list', array( 'conditions' => array('Article.typeetatarticle_id'=>1),'recursive'=>-1)) ;
                $pointdeventes=$this->Pointdevente->find('list');
                $clients = $this->Bonlivraison->Client->find('list');
                
                 //****************************************************************************************************************************************************            
                
              
            $this->loadModel('Bonlivraison');
            $this->loadModel('Factureclient');
            $this->loadModel('Client');
             
           
            $client= $this->Client->find('all',array('conditions'=>array('Client.id'=>$clientid[0]['client_id']),false));
            $adresse=$client[0]['Client']['adresse'];
            $name=$client[0]['Client']['name'];
            $matriculefiscale=$client[0]['Client']['matriculefiscale'];
            $autorisation=$client[0]['Client']['autorisation'];

            $sumttc= $this->Bonlivraison->find('all', array('fields'=>array('SUM(Bonlivraison.totalttc) as totalttcb')
                     ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,'Bonlivraison.client_id'=>$clientid[0]['client_id'])));
            $summtreg = $this->Bonlivraison->find('all', array('fields'=>array('SUM(Bonlivraison.Montant_Regler) as totalregb')
                     ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,'Bonlivraison.client_id'=>$clientid[0]['client_id'])));
            $sumttcf = $this->Factureclient->find('all', array('fields'=>array('SUM(Factureclient.totalttc) as totalttf')
                     , 'conditions' => array('Factureclient.id > ' => 0,'Factureclient.client_id'=>$clientid[0]['client_id'])));
            $summtregf = $this->Factureclient->find('all', array('fields'=>array('SUM(Factureclient.Montant_Regler) as totalregf')
                     , 'conditions' => array('Factureclient.id > ' => 0,'Factureclient.client_id'=>$clientid[0]['client_id'])));
            $reglementlibre = $this->Reglementclient->find('all', array('fields'=>array('sum(Reglementclient.Montant) as reglibretotale')
                     , 'conditions' => array('Reglementclient.type  ' => 1,'Reglementclient.affectation_id  ' => 0,'Reglementclient.client_id'=>$clientid[0]['client_id'])));
            $valbl=$sumttc[0][0]['totalttcb']-$summtreg[0][0]['totalregb'];
            $valfac=$sumttcf[0][0]['totalttf']-$summtregf[0][0]['totalregf'];
            $valglobal=$valbl+$valfac;
            $solde=$valglobal-$reglementlibre[0][0]['reglibretotale'];
            $valreste=$autorisation-($valglobal-$reglementlibre[0][0]['reglibretotale']);
            //fin info client************************************************
             $p=CakeSession::read('depot');
                if($p==0){
         	$depots = $this->Bonlivraison->Depot->find('list');
                }else{
         	$depots = $this->Bonlivraison->Depot->find('list',array('conditions'=>array('Depot.id'=>$p)));
                }  
                
                
                
		$this->set(compact('name','autorisation','solde','clientid','tabqtestock','articles','depots','valreste','matriculefiscale','adresse','pointdeventes','pntv','clients','client', 'utilisateurs','articles','mm','lignelivraisons','numspecial', 'timbre'));
	}
        
        
        
    //jeya mel devie
     public function addbonindirect($tab=null) {
           $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonlivraisons'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
        // debug($tab);die;
            $this->loadModel('Reglementclient');       
            $this->loadModel('Article');
            $this->loadModel('Depot');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Lignedevi');
            $this->loadModel('Devi');
            $this->loadModel('Client');
            $this->loadModel('Stockdepot');
            $this->loadModel('Pointdevente');
            $tbr=$tab.',0)';
            list($idbr,$resteidbr)=explode(",",$tbr);
            $tbr='(0,'.$tbr;
           // debug($idbr);die;
            $idlcs=array();
            $idlcs=explode(",",$tab);    
            
            $clientid = $this->Devi->find('first', array('fields'=>array('pointdevente_id','SUM(Devi.remise) remise','SUM(Devi.tva) tva','SUM(Devi.totalht) totalht'
            ,'SUM(Devi.totalttc) totalttc','AVG(Devi.client_id) client_id'),'conditions' => array('Devi.id'=>$idlcs),'recursive'=>-2));
           //debug($clientid);die;
            
             $lignelivraisons=$this->Lignedevi->find('all', array('fields'=>array('AVG(Lignedevi.article_id) article_id','AVG(Lignedevi.depot_id) depot_id','(Lignedevi.article_id) article_iddd'
             ,'SUM(Lignedevi.quantite) quantite','SUM(Lignedevi.remise*Lignedevi.quantite) remise','SUM(Lignedevi.prix*Lignedevi.quantite) prix'
             ,'AVG(Lignedevi.tva) tva','SUM(Lignedevi.totalht) totalht','SUM(Lignedevi.totalttc)totalttc','SUM(Lignedevi.prixnet*Lignedevi.quantite) prixnet','SUM(Lignedevi.puttc*Lignedevi.quantite) puttc')
            ,'conditions' => array('Lignedevi.devi_id in'.$tbr),'recursive'=>-2
            ,'group'=>array('Lignedevi.article_id','Lignedevi.depot_id')));
             
             //debug($clientid);debug($lignelivraisons);die;
             
		if ($this->request->is('post')) {
                   //debug($this->request->data);die;
                     $this->request->data['Bonlivraison']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonlivraison']['date'])));
	             $this->request->data['Bonlivraison']['utilisateur_id']= CakeSession::read('users');
                    $this->request->data['Bonlivraison']['client_id']= $clientid[0]['client_id'];
                       if(empty($this->request->data['Bonlivraison']['pointdevente_id'])){
                        $this->request->data['Bonlivraison']['pointdevente_id']= CakeSession::read('pointdevente');
                        }                       
                        $this->request->data['Bonlivraison']['exercice_id']=date("Y");
                        
                         
         $pv= CakeSession::read('pointdevente'); 
         if($pv==0) {
          $pv=$this->request->data['Bonlivraison']['pointdevente_id'];   
         }
         $numero = $this->Bonlivraison->find('all',
         array('fields' =>array('MAX(Bonlivraison.numeroconca) as num'),
          'conditions' => array('Bonlivraison.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {  
   $getexercice= $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.numeroconca'=>$n)));
  $anne=$getexercice['Bonlivraison']['exercice_id'];  
       if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            }
           else {
                $mm = "000001";
            }  
            
       } else {
                $mm = "000001";
            }
                $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
                        
                        $this->request->data['Bonlivraison']['numeroconca']=$mm;
                        $this->request->data['Bonlivraison']['numero']=$numspecial;
			$this->Bonlivraison->create();
                  if(!empty($this->request->data['Lignelivraison'])){
			if ($this->Bonlivraison->save($this->request->data)) {
                            foreach ($idlcs as $idc){
                               $this->Devi->updateAll(array('Devi.etat' =>1), array('Devi.id' =>$idc));       
                            } 
                         $id=$this->Bonlivraison->id;
                        // debug($id);die;
                              $Lignelivraisons=array();
                               $stockdepots=array();
                               //debug($this->request->data );die;
                              foreach (  $this->request->data['Lignelivraison'] as $numl=>$f   ){
                                 
                                 //  debug($f);die;
                              if ($f['sup']!=1){
                                  if(empty($f['article_id'])){
                                      $f['article_id']=$this->request->data['Lignelivraison'][$numl]['article_id'];
                                  }
                                 
                                $stockdepots[$numl]['quantite']=$f['quantite'];
                                $Lignelivraisons['bonlivraison_id']=$id;
                                $Lignelivraisons['depot_id']=$f['depot_id'];
                                $Lignelivraisons['article_id']=$f['article_id'];
                                $Lignelivraisons['quantite']=$f['quantite'];
                                $Lignelivraisons['remise']=$f['remise'];
                                $Lignelivraisons['tva']=$f['tva'];
                                $Lignelivraisons['prix']=$f['prixhtva'];
                                $Lignelivraisons['prixnet']=$f['prixnet'];
                                $Lignelivraisons['puttc']=$f['puttc'];
                                $Lignelivraisons['totalhtans']=$f['totalhtans'];
                                $Lignelivraisons['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignelivraisons['totalttc']=((($Lignelivraisons['totalht']))*(1+($f['tva']*0.01)));  
                                     $this->Lignelivraison->create();
                                     $this->Lignelivraison->save($Lignelivraisons);  
                                     
                                     
                                     $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$stockdepots[$numl]['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                                  $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
                              }
                             } 
				$this->Session->setFlash(__('The bonlivraison has been saved'));
				//$this->redirect(array('action' => 'addbonsorti/'.$id));    
                                $this->redirect(array('action' => 'index')); 
			} else {
				$this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                        }
		}
                }
                
        $pv= CakeSession::read('pointdevente'); 
         if($pv==0){
             $pv=$clientid['Devi']['pointdevente_id'];
             } 
         $numero = $this->Bonlivraison->find('all',
         array('fields' =>array('MAX(Bonlivraison.numeroconca) as num'),
          'conditions' => array('Bonlivraison.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
        $getexercice= $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.numeroconca'=>$n)));
       $anne=$getexercice['Bonlivraison']['exercice_id'];  
       if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            }
           else {
                $mm = "000001";
            }  
            
       } else {
                $mm = "000001";
            }
                $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
                
                
                 //**************************************trouver la liste des articles pour chaque depot *******************************************************
            foreach (  $lignelivraisons as $ll   ){ 
         $artdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.depot_id'=>$ll[0]['depot_id']),'recursive'=>-1));
           $t='(0';
            foreach ($artdepot as $ad){
              if(!empty($ad['Stockdepot']['article_id'])){
                $t=$t.','.$ad['Stockdepot']['article_id'];
              }
            }
            $t=$t.')';
        
            $articles=$this->Article->find('list', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
            $tabqtestock[$ll[0]['depot_id']]['articles']=$articles;

    //**************************************trouver les qte en stock de chaque article pour chaque depot *******************************************************

                $artstocks=$this->Article->find('all', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ; 
                    //debug($artstocks);die;
                     foreach ($artstocks as $i=>$as){
                          $qtestock=0;
                       $stockdepots= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$as['Article']['id'],
                           'Stockdepot.depot_id'=>$ll[0]['depot_id']),false));  
                       foreach (  $stockdepots as $stkdepot   ){
                                    $qtestock=$qtestock+$stkdepot['Stockdepot']['quantite'];   
                                }
                           $tabqtestock[$ll[0]['depot_id']][$as['Article']['id']]['qtestock']=$qtestock;    
                     }
                 }
            
  //******************************************fin***********************************************************************************************************          
           // debug($tabqtestock);die;
            //debug($tabqtestock['1.0000'][1]['qtestock']);die;
            
                 
		$client = $this->Client->find('first', array( 'conditions' => array('Client.id'=>$clientid[0]['client_id']),'recursive'=>-2));
                $pntv=$clientid['Devi']['pointdevente_id'];
                $client=$client['Client']['name'];
		$utilisateurs = $this->Bonlivraison->Utilisateur->find('list');
                $clients = $this->Bonlivraison->Client->find('list');
                $articles = $this->Article->find('list');
                $pointdeventes=$this->Pointdevente->find('list');
                
    //****************************************************************************************************************************************************            
                
              $this->loadModel('Bonlivraison');
            $this->loadModel('Factureclient');
            $this->loadModel('Client');
             
           
            $client= $this->Client->find('all',array('conditions'=>array('Client.id'=>$clientid[0]['client_id']),false));
            $adresse=$client[0]['Client']['adresse'];
            $name=$client[0]['Client']['name'];
            $matriculefiscale=$client[0]['Client']['matriculefiscale'];
            $autorisation=$client[0]['Client']['autorisation'];

            $sumttc= $this->Bonlivraison->find('all', array('fields'=>array('SUM(Bonlivraison.totalttc) as totalttcb')
                     ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,'Bonlivraison.client_id'=>$clientid[0]['client_id'])));
            $summtreg = $this->Bonlivraison->find('all', array('fields'=>array('SUM(Bonlivraison.Montant_Regler) as totalregb')
                     ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,'Bonlivraison.client_id'=>$clientid[0]['client_id'])));
            $sumttcf = $this->Factureclient->find('all', array('fields'=>array('SUM(Factureclient.totalttc) as totalttf')
                     , 'conditions' => array('Factureclient.id > ' => 0),'Factureclient.client_id'=>$clientid[0]['client_id']));
            $summtregf = $this->Factureclient->find('all', array('fields'=>array('SUM(Factureclient.Montant_Regler) as totalregf')
                     , 'conditions' => array('Factureclient.id > ' => 0),'Factureclient.client_id'=>$clientid[0]['client_id']));
            $reglementlibre = $this->Reglementclient->find('all', array('fields'=>array('sum(Reglementclient.Montant) as reglibretotale')
                     , 'conditions' => array('Reglementclient.type  ' => 1,'Reglementclient.affectation_id  ' => 0,'Reglementclient.client_id'=>$clientid[0]['client_id'])));
            $valbl=$sumttc[0][0]['totalttcb']-$summtreg[0][0]['totalregb'];
            $valfac=$sumttcf[0][0]['totalttf']-$summtregf[0][0]['totalregf'];
            $valglobal=$valbl+$valfac;
            $solde=$valglobal-$reglementlibre[0][0]['reglibretotale'];
            $valreste=$autorisation-($valglobal-$reglementlibre[0][0]['reglibretotale']);
            //fin info client************************************************
             $p=CakeSession::read('depot');
                if($p==0){
         	$depots = $this->Factureclient->Depot->find('list');
                }else{
         	$depots = $this->Factureclient->Depot->find('list',array('conditions'=>array('Depot.id'=>$p)));
                }  
                
                
		$this->set(compact('name','autorisation','solde','clientid','tabqtestock','articles','depots','valreste','matriculefiscale','adresse','pointdeventes','pntv','clients','client', 'utilisateurs','articles','mm','lignelivraisons','numspecial'));
	}
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */  
        public function addbonsorti($id = null) {
          $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonlivraisons'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Lignelivraison');
             $this->loadModel('Stockdepot');
             $this->loadModel('Article');
             $this->loadModel('Bonsorti');
             $this->loadModel('Lignesorti');
             $this->loadModel('Lignelivraison');
             $this->loadModel('Lignesortidetail');
		if (!$this->Bonlivraison->exists($id)) {
			throw new NotFoundException(__('Invalid bonlivraison'));
		}
		if ($this->request->is('post')) {
                     //debug($this->request->data );die;
                    $this->request->data['Bonsorti']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonsorti']['date'])));
	            $this->request->data['Bonsorti']['utilisateur_id']= CakeSession::read('users');
                    $this->request->data['Bonsorti']['bonlivraison_id']=$id;
                    $this->Bonsorti->create();
                     if(!empty($this->request->data['Lignesorti'])){
			if ($this->Bonsorti->save($this->request->data)) {
                            $idbs=$this->Bonsorti->id; 
                            $qteliv=array();
                            $qtebl=0;
                            $qtelivrai=0;
                               foreach (  $this->request->data['Lignesorti'] as $f   ){  
                                  //debug($f);die;
                                    
                              if ($f['sup']!=1){
                                $Lignesortis['bonsorti_id']=$idbs;
                                $Lignesortis['lignelivraison_id']=$f['id'];
                                $Lignesortis['depot_id']=$f['depot_id'];
                                $Lignesortis['article_id']=$f['article_id'];
                                $Lignesortis['quantite']=$f['quantite'];
                                $qtebl=$qtebl+$f['quantite'];
                                     $this->Lignesorti->create();
                                     $this->Lignesorti->save($Lignesortis); 
                                     $idls=$this->Lignesorti->id; 
                                     $qteliv[$f['id']]=0;    
                                if(!empty($f['Stockdepot'])){     
                               foreach (  $f['Stockdepot'] as $sd   ){ 
                                if (!empty($sd['quantite'])){
                                   $qte=$sd['qtestock']-$sd['quantite'];
                                    
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qte), array('Stockdepot.id' =>$sd['id']));  
                                       if(($qte==0)&($f['quantite']<$f['quantitestock'])) {
                                              $this->Stockdepot->deleteAll(array('Stockdepot.id'=>$sd['id']),false); 
                                             }       
                                $Lignedetailsortis['lignesorti_id']=$idls;
                                $Lignedetailsortis['stockdepot_id']=$sd['id'];
                                $Lignedetailsortis['date']=date("Y-m-d",strtotime(str_replace('/','-',$sd['date'])));
                                $Lignedetailsortis['quantite']=$sd['quantite'];  
                                     $this->Lignesortidetail->create();
                                     $this->Lignesortidetail->save($Lignedetailsortis); 
                                     $qteliv[$f['id']]= $qteliv[$f['id']]+$sd['quantite'];
                                     $qtelivrai=$qtelivrai+$sd['quantite'];
                                }
                                 }
                                 }
                             $this->Lignelivraison->updateAll(array('Lignelivraison.quantitelivrai'=>'Lignelivraison.quantitelivrai+'.$qteliv[$f['id']]), array('Lignelivraison.id' =>$f['id']));   
                              }
                             } 
                               if($qtelivrai==$qtebl){
                             $this->Bonlivraison->updateAll(array('Bonlivraison.etat' =>1), array('Bonlivraison.id' =>$id));       
                               }
				$this->Session->setFlash(__('The bonlivraison has been saved'));
				$this->redirect(array('action' => 'index'));    
			} else {
				$this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                        }
		}
                }
         $lignelivraisons = $this->Lignelivraison->find('all',array('conditions'=>array('Lignelivraison.bonlivraison_id' => $id)));  
          //debug($lignelivraisons); die;
         
      foreach (  $lignelivraisons as $q=>$ll   ){  
          
    //**************************************trouver la liste des articles pour chaque depot *******************************************************

         $artdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.depot_id'=>$ll['Depot']['id']),'recursive'=>-1));
           $t='(0,';
            foreach ($artdepot as $ad){
               $a=''.$ad['Stockdepot']['article_id'];
                  if( !strstr($t, $a)) { 
                $t=$t.$ad['Stockdepot']['article_id'].',';
                  }
            }
            $t=$t.'0)';
        
            $articles=$this->Article->find('list', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
            $tabqtestock[$ll['Depot']['id']]['articles']=$articles;

    //**************************************trouver les qte en stock de chaque article pour chaque depot *******************************************************

                $artstocks=$this->Article->find('all', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ; 
                    //debug($artstocks);die;
                     foreach ($artstocks as $i=>$as){
                          $qtestock=0;
                       $stockdepots= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$as['Article']['id'],
                           'Stockdepot.depot_id'=>$ll['Depot']['id']),false));  
                      
                       foreach (  $stockdepots as $stkdepot   ){
                                    $qtestock=$qtestock+$stkdepot['Stockdepot']['quantite'];   
                                }
                           $tabqtestock[$ll['Depot']['id']][$as['Article']['id']]['qtestock']=$qtestock;    
                     }
          $stkdepots= $this->Stockdepot->find('all',array(
              'conditions'=>array('Stockdepot.article_id'=>$ll['Article']['id'],'Stockdepot.depot_id'=>$ll['Depot']['id'])
                ,'order'=>array('Stockdepot.date'=>'ASC'),'recursive'=>-1));
          $lignelivraisons[$q]['Stockdepots']=$stkdepots;
           //debug($stkdepots); die;
          }
           $numero = $this->Bonsorti->find('all', array('fields' =>
            array(
                'MAX(Bonsorti.numero) as num'
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
                // debug($tabqtestock); die;
		$clients = $this->Bonlivraison->Client->find('list');
		$utilisateurs = $this->Bonlivraison->Utilisateur->find('list');
		$depots = $this->Bonlivraison->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('clients', 'utilisateurs', 'depots','lignelivraisons','articles','tabqtestock','mm'));   
        }
        
        
        
	public function edit($id = null) {
              $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonlivraisons'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
              $this->loadModel('Reglementclient');     
              $this->loadModel('Pointdevente'); 
             $this->loadModel('Lignelivraison');
             $this->loadModel('Stockdepot');
             $this->loadModel('Article');
		if (!$this->Bonlivraison->exists($id)) {
			throw new NotFoundException(__('Invalid bonlivraison'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    
                    $this->request->data['Bonlivraison']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonlivraison']['date'])));
	            $this->request->data['Bonlivraison']['utilisateur_id']= CakeSession::read('users');
                    
			if ($this->Bonlivraison->save($this->request->data)) {
                            
                            $lignelivrisonanciens= $this->Lignelivraison->find('all',array('conditions'=>array('Lignelivraison.bonlivraison_id'=>$id),false));
                            foreach (  $lignelivrisonanciens as $lra   ){
                               
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+'.$lra['Lignelivraison']['quantite']), array('Stockdepot.article_id' =>$lra['Lignelivraison']['article_id'],'Stockdepot.depot_id' =>$lra['Lignelivraison']['depot_id']));
                            } 
                              $this->Lignelivraison->deleteAll(array('Lignelivraison.bonlivraison_id'=>$id),false); 
                             $Lignelivraisons=array();
                             $stockdepots=array();
                               foreach (  $this->request->data['Lignelivraison'] as $numl=>$f   ){  
                                 //  debug($f);die;
                              if ($f['sup']!=1){
                                
                                $stockdepots[$numl]['quantite']=$f['quantite'];
                                $Lignelivraisons['bonlivraison_id']=$id;
                                $Lignelivraisons['depot_id']=$f['depot_id'];
                                $Lignelivraisons['article_id']=$f['article_id'];
                                $Lignelivraisons['quantite']=$f['quantite'];
                                $Lignelivraisons['remise']=$f['remise'];
                                $Lignelivraisons['tva']=$f['tva'];
                                $Lignelivraisons['prix']=$f['prixhtva'];
                                $Lignelivraisons['prixnet']=$f['prixnet'];
                                $Lignelivraisons['puttc']=$f['puttc'];
                                $Lignelivraisons['totalhtans']=$f['totalhtans'];
                                $Lignelivraisons['designation']=$f['designation'];
                                $Lignelivraisons['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignelivraisons['totalttc']=((($Lignelivraisons['totalht']))*(1+($f['tva']*0.01)));  
                                     $this->Lignelivraison->create();
                                     $this->Lignelivraison->save($Lignelivraisons);  
                                     
                                 $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$stockdepots[$numl]['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                                   $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false); 
                              }
                              
                             } 
				$this->Session->setFlash(__('The bonlivraison has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bonlivraison could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Bonlivraison.' . $this->Bonlivraison->primaryKey => $id));
			$this->request->data = $this->Bonlivraison->find('first', $options);
		}
         $bonlivraison = $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.id' => $id))); 
         $lignelivraisons = $this->Lignelivraison->find('all',array('conditions'=>array('Lignelivraison.bonlivraison_id' => $id)));  
          //debug($lignelivraisons); die;
         
      foreach (  $lignelivraisons as $ll   ){  
          
    //**************************************trouver la liste des articles pour chaque depot *******************************************************

         $artdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.depot_id'=>$ll['Lignelivraison']['depot_id']),'recursive'=>-1));
            $t='(0';
            foreach ($artdepot as $ad){
              if(!empty($ad['Stockdepot']['article_id'])){
                $t=$t.','.$ad['Stockdepot']['article_id'];
              }
            }
            $t=$t.')';
        
            $articles=$this->Article->find('list', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
            $tabqtestock[$ll['Depot']['id']]['articles']=$articles;

    //**************************************trouver les qte en stock de chaque article pour chaque depot *******************************************************

                $artstocks=$this->Article->find('all', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ; 
                    //debug($artstocks);die;
                     foreach ($artstocks as $i=>$as){
                          $qtestock=0;
                       $stockdepots= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$as['Article']['id'],
                           'Stockdepot.depot_id'=>$ll['Depot']['id']),false));  
                       foreach (  $stockdepots as $stkdepot   ){
                                    $qtestock=$qtestock+$stkdepot['Stockdepot']['quantite'];   
                                }
                           $tabqtestock[$ll['Depot']['id']][$as['Article']['id']]['qtestock']=$qtestock;    
                     }
          }
                // debug($tabqtestock); die;
		$clients = $this->Bonlivraison->Client->find('list');
		$utilisateurs = $this->Bonlivraison->Utilisateur->find('list');
                $date=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Bonlivraison']['date'])));
                $pointdeventes=$this->Pointdevente->find('list');
                  //info client**************************************************
            $this->loadModel('Bonlivraison');
            $this->loadModel('Factureclient');
            $this->loadModel('Client');
            $facture= $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.id'=>$id),false));
            $clientid=$facture['Bonlivraison']['client_id'];
            $name=$facture['Bonlivraison']['name'];
            $client= $this->Client->find('all',array('conditions'=>array('Client.id'=>$clientid),false));
            $adresse=$client[0]['Client']['adresse'];
            $matriculefiscale=$client[0]['Client']['matriculefiscale'];
            $autorisation=$client[0]['Client']['autorisation'];

            $sumttc= $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalttc) as totalttcb')
                     ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,'Bonlivraison.client_id'=>$clientid,'Bonlivraison.id not in ('.$id.')')));
            $summtreg = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.Montant_Regler) as totalregb')
                     ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,'Bonlivraison.client_id'=>$clientid)));
            $sumttcf = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalttc) as totalttf')
                     , 'conditions' => array('Factureclient.id > ' => 0,'Factureclient.client_id'=>$clientid,'Factureclient.id not in ('.$id.')')));
            $summtregf = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.Montant_Regler) as totalregf')
                     , 'conditions' => array('Factureclient.id > ' => 0,'Factureclient.client_id'=>$clientid)));
            $reglementlibre = $this->Reglementclient->find('all', array('fields'=>array('sum(Reglementclient.Montant) as reglibretotale')
                     , 'conditions' => array('Reglementclient.type  ' => 1,'Reglementclient.affectation_id  ' => 0,'Reglementclient.client_id'=>$clientid)));
            $valbl=$sumttc[0][0]['totalttcb']-$summtreg[0][0]['totalregb'];
            $valfac=$sumttcf[0][0]['totalttf']-$summtregf[0][0]['totalregf'];
            $valglobal=$valbl+$valfac;
            $solde=$valglobal-$reglementlibre[0][0]['reglibretotale'];
            $valreste=$autorisation-($valglobal-$reglementlibre[0][0]['reglibretotale']);
            //fin info client************************************************
            $p=CakeSession::read('depot');
                if($p==0){
         	$depots = $this->Bonlivraison->Depot->find('list',array('fields' => array('Depot.designation')));
                }else{
         	$depots = $this->Bonlivraison->Depot->find('list',array('fields' => array('Depot.designation'),'conditions'=>array('Depot.id'=>$p)));
                }
                $articles = $this->Article->find('list');
		$this->set(compact('name','autorisation','solde','bonlivraison','valreste','matriculefiscale','adresse','pointdeventes','clients', 'utilisateurs', 'depots','date','lignelivraisons','articles','tabqtestock'));
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
                if(@$liens['lien']=='bonlivraisons'){
                        $x=$liens['delete'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Lignelivraison');
             $this->loadModel('Stockdepot');
		$this->Bonlivraison->id = $id;
		if (!$this->Bonlivraison->exists()) {
			throw new NotFoundException(__('Invalid bonlivraison'));
		}
		$this->request->onlyAllow('post', 'delete');
                
                 $lrs=$this->Lignelivraison->find('all',array('conditions'=>array('Lignelivraison.Bonlivraison_id'=>$id),false)); 
                 //debug($lrs);die;
                 $stkdepqte=array();
                  foreach (  $lrs as $lr   ){
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$lr['Lignelivraison']['article_id'],'Stockdepot.depot_id'=>$lr['Lignelivraison']['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stkdepqte['quantite']= $stckdepot[0]['Stockdepot']['quantite']+$lr['Lignelivraison']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stkdepqte['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }else{
                                 $stkdepqte['quantite']=$lr['Lignelivraison']['quantite'];
                                 $stkdepqte['article_id']=$lr['Lignelivraison']['article_id'];
                                 $stkdepqte['depot_id']=$lr['Lignelivraison']['depot_id'];
                                 $this->Stockdepot->create();
                                 $this->Stockdepot->save($stkdepqte);
                                   }
                              }
                
                 $this->Lignelivraison->deleteAll(array('Lignelivraison.Bonlivraison_id'=>$id),false); 
                
		if ($this->Bonlivraison->delete()) {
			$this->Session->setFlash(__('Bonlivraison deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Bonlivraison was not deleted'));
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
      $index=$data['index']; 
       $name='article_id';
        $artdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.depot_id'=>$depotid),'recursive'=>-1));
     // debug($fourdevises);
      $t='(0,';
            foreach ($artdepot as $ad){
               $a=''.$ad['Stockdepot']['article_id'];
                  if( !strstr($t, $a)) { 
                $t=$t.$ad['Stockdepot']['article_id'].',';
                  }
            }
            $t=$t.'0)';
         //debug($t);
             $id='article_id'.$index;
             if ($depotid != 0) { 
            $articles=$this->Article->find('all', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
            $select="<select   name='data[Lignelivraison][".$index."][article_id]' table='Lignelivraison' index=".$index." champ=".$id." id=".$id." class='select form-control articleidbl' onchange='art(".$index.")'><option selected disabled hidden value=0> Veuillez choisir !!</option>";
            foreach($articles as $v){
                $select=$select."<option value=".$v['Article']['id'].">".$v['Article']['name']."</option>";
            }
            $select=$select.'</select>';
          
             }
             else{
                 $articles=$this->Article->find('all') ;
            $select="<select name='".$name."' champ='article_id' id='article_id'  class='' onchange='art(ind) '><option selected disabled hidden value=0> Veuillez choisir !!</option>";
            foreach($articles as $v){
                $select=$select."<option value=".$v['Article']['id'].">".$v['Article']['name']."</option>";
            }
            $select=$select.'</select>';
       
             }

             echo json_encode(array('select'=>$select));
          die();
  }      
  
  
                  
      public function  article(){
            $this->layout = null;
            $this->loadModel('Article');  
            $this->loadModel('Stockdepot');
            $this->loadModel('Client'); 
            $this->loadModel('Remiseartfamille');
            $this->loadModel('Articleclient');
            $data = $this->request->data;//debug($data);
           $json = null;
           $articleid= $data['id'];
           $depotid= $data['depotid'];
           
        // debug($data);
        $stockdepots= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$articleid,'Stockdepot.depot_id'=>$depotid),false));  
        $article= $this->Article->find('all',array('conditions'=>array('Article.id'=>$articleid),false));
        if(!empty($data['clientid'])){
        $clientid= $data['clientid'];    
        $client= $this->Client->find('first',array('conditions'=>array('Client.id'=>$clientid),'recursive'=>-1));
        $familleid=$article[0]['Article']['famille_id'];
        $familleclientid=$client['Client']['familleclient_id'];
        $remisefamille= $this->Remiseartfamille->find('first',array('conditions'=>array('Remiseartfamille.familleclient_id'=>$familleclientid,'Remiseartfamille.article_id'=>$articleid),'recursive'=>-1));
        $remiseartclient= $this->Articleclient->find('first',array('conditions'=>array('Articleclient.client_id'=>$clientid,'Articleclient.article_id'=>$articleid),'recursive'=>-1));
        }
//  debug($client);debug($remisefamille);debug($remiseartclient);
        //*******************Qte en stock***************************
        $qtestock=0;
        foreach ($stockdepots as $stkdepot){
          $qtestock=$qtestock+$stkdepot['Stockdepot']['quantite'];
         }
       //********************info article**************************************  
          $id=$article[0]['Article']['id'];
          $tva=$article[0]['Article']['tva'];
          $prix=$article[0]['Article']['prixvente'];
          $prixachat=$article[0]['Article']['coutrevient'];
          $designation=$article[0]['Article']['name'];
          $prixttc=$article[0]['Article']['prixuttc'];
      //*********************les remises******************************************  
        
          if(!empty($remiseartclient['Articleclient']['remise'])){
        $remise=$remiseartclient['Articleclient']['remise'];
         }elseif(!empty($remisefamille['Remiseartfamille']['remise'])){
        $remise=$remisefamille['Remiseartfamille']['remise'];
        }elseif(!empty($client['Client']['remise'])){
        $remise=$client['Client']['remise'];
        }
        else {
            $remise=0;
        }
      //***************************************************************************
        //debug($remise);
         echo json_encode(array('id'=>$id,'remise'=>$remise,'tva'=>$tva,'prix'=>$prix,'prixachat'=>$prixachat,'quantitestock'=>$qtestock,'des'=>$designation,'prixttc'=>$prixttc));
          die();
     }
     
     
     
     
     
      public function  getnums(){
            $this->layout = null;
            $this->loadModel('Pointdevente');
            $data = $this->request->data;//debug($data);
           $json = null;
           $pv = $data['id'];
           $model = $data['model'];
           $this->loadModel($model);
         $numero = $this->$model->find('all',
         array('fields' =>array('MAX('.$model.'.numeroconca) as num'),
          'conditions' => array($model.'.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {  
        $getexercice= $this->$model->find('first',array('conditions'=>array($model.'.numeroconca'=>$n)));
       $anne=$getexercice[$model]['exercice_id'];  
       if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            }
           else {
                $mm = "000001";
            }  
            
       } else {
                $mm = "000001";
            }
        
                $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
       
         echo json_encode(array('numspecial'=>$numspecial,'mm'=>$mm));
          die();
     }
     
    
     
     
     
     public function  getclients(){
            $this->layout = null;
            $this->loadModel('Client');  
            $this->loadModel('Bonlivraison');
            $this->loadModel('Factureclient');
            $this->loadModel('Reglementclient');
            $data = $this->request->data;//debug($data);
            $json = null;
            $clientid= $data['id'];
            $client= $this->Client->find('all',array('conditions'=>array('Client.id'=>$clientid),false));
            $adresse=$client[0]['Client']['adresse'];
            $name=$client[0]['Client']['name'];
            $matriculefiscale=$client[0]['Client']['matriculefiscale'];
            $autorisation=$client[0]['Client']['autorisation'];
            $modeclientid=$client[0]['Client']['modeclient_id'];
            if(empty($autorisation)){
              $val=0;
              $autorisation=0;
            }  else {
              $val=1;  
            }
           // debug($val);

            $sumttc= $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalttc) as totalttcb')
                     ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,'Bonlivraison.client_id'=>$clientid)));
            $summtreg = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.Montant_Regler) as totalregb')
                     ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,'Bonlivraison.client_id'=>$clientid)));
            $sumttcf = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalttc) as totalttf')
                     , 'conditions' => array('Factureclient.id > ' => 0,'Factureclient.client_id'=>$clientid)));
            $summtregf = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.Montant_Regler) as totalregf')
                     , 'conditions' => array('Factureclient.id > ' => 0,'Factureclient.client_id'=>$clientid)));
            $reglementlibre = $this->Reglementclient->find('all', array('fields'=>array('sum(Reglementclient.Montant) as reglibretotale')
                     , 'conditions' => array('Reglementclient.type' => 1,'Reglementclient.affectation_id' => 0,'Reglementclient.client_id'=>$clientid)));
            
            $valbl=$sumttc[0][0]['totalttcb']-$summtreg[0][0]['totalregb'];
            $valfac=$sumttcf[0][0]['totalttf']-$summtregf[0][0]['totalregf'];
            $valglobal=$valbl+$valfac;
            $solde=$valglobal-$reglementlibre[0][0]['reglibretotale'];
            $valreste=$autorisation-($solde);
            
            echo json_encode(array('modeclientid'=>$modeclientid,'name'=>$name,'adresse'=>$adresse,'matriculefiscale'=>$matriculefiscale,'valreste'=>$valreste,'autorisation'=>$val,'solde'=>$solde,'autor'=>$autorisation));
            die;
     }
        public function recap() {
            $this->loadModel('Devi'); 
            $this->loadModel('Lignedevi'); 
            $this->loadModel('Commandeclient');
            $this->loadModel('Lignecommandeclient');
            $this->loadModel('Factureclient');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Client');
            
             $this->layout = null;
             $data=$this->request->data;
		$clientid= $data['client_id'];
                $articleid= $data['article_id'];
                $index_kbira= $data['index'];
                
            $client= $this->Client->find('all',array('conditions'=>array('Client.id'=>$clientid),false));
            $name=$client[0]['Client']['name'];
            
            
            $lignedevis=$this->Lignedevi->find('all', array(
            'conditions' => array('Devi.client_id' => $clientid ,'Lignedevi.article_id' => $articleid),'recursive'=>0 ));
            $lignecommandes=$this->Lignecommandeclient->find('all', array(
            'conditions' => array('Commandeclient.client_id' => $clientid ,'Lignecommandeclient.article_id' => $articleid),'recursive'=>0 ));
            $lignelivrisons=$this->Lignelivraison->find('all', array(
            'conditions' => array('Bonlivraison.client_id' => $clientid ,'Lignelivraison.article_id' => $articleid),'recursive'=>0 ));
            $lignefactures=$this->Lignefactureclient->find('all', array(
            'conditions' => array('Factureclient.client_id' => $clientid ,'Lignefactureclient.article_id' => $articleid),'recursive'=>0 ));
           
                
                 $this->set(compact('lignedevis','lignecommandes','lignelivrisons','lignefactures','name','index_kbira'));
               
	}
        
        
        
      public function testqtes() {
           
            $this->loadModel('Commandeclient');
            $this->loadModel('Lignecommandeclient');
            
            
             $this->layout = null;
             $data=$this->request->data;
	     $id= $data['id'];
                
                
                
            
            $lignecommandes=$this->Lignecommandeclient->find('all', array(
            'conditions' => array('Lignecommandeclient.commandeclient_id' =>$id),'recursive'=>0 ));
        //debug($lignecommandes);
            $test=0;
            foreach (  $lignecommandes as $numl=>$l   ){
            if($l['Lignecommandeclient']['quantiteliv']>0) {   
                $test=1;
            }
            }    
                 echo json_encode(array('test'=>$test));
            die;
	}       
        
     
}
