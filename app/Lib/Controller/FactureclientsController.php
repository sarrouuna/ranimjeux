<?php
App::uses('AppController', 'Controller');
/**
 * Factureclients Controller
 *
 * @property  $Factureclient
 */
class FactureclientsController extends AppController {

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
                if(@$liens['lien']=='factureclients'){
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
        $cond4 = 'Factureclient.exercice_id ='.$exe;
        $pv="";
       $p=CakeSession::read('pointdevente');
       //debug($p);
       if($p>0){
          $pv= 'Factureclient.pointdevente_id = '.$p;
       }
       
       $l=100;
         if (isset($this->request->data) && !empty($this->request->data)) {
       // debug($this->request->data);die;
        if ($this->request->data['Factureclient']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureclient']['date1'])));
            $cond1 = 'Factureclient.date >= '."'".$date1."'";
            $cond4="";
            $l=0;
        }
        
        if ($this->request->data['Factureclient']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureclient']['date2'])));
            $cond2 = 'Factureclient.date <= '."'".$date2."'";
            $cond4="";
            $l=0;
        }
        
       if ($this->request->data['Factureclient']['client_id']) {
            $clientid= $this->request->data['Factureclient']['client_id'];
            $cond3 = 'Factureclient.client_id ='.$clientid;
            $l=0;
        } 
        if ($this->request->data['Factureclient']['exercice_id']) {
            $exerciceid = $this->request->data['Factureclient']['exercice_id'];
            $cond4 = 'Factureclient.exercice_id ='.$exercices[$exerciceid];
            $l=0;
        } 
        if ($this->request->data['Factureclient']['pointdevente_id']) {
            $pointdeventeid = $this->request->data['Factureclient']['pointdevente_id'];
            $cond5 = 'Factureclient.pointdevente_id ='.$pointdeventeid;
            $l=0;
        } 
        
    } 
  $factureclients = $this->Factureclient->find('all', array( 'conditions' => array('Factureclient.id > ' => 0,@$pv, @$cond1, @$cond2, @$cond3, @$cond4 , @$cond5)
  ,'limit'=>$l,'order'=>array('Factureclient.id'=>'desc')));
//  foreach ($factureclients as $facture){
//      $id=$facture['Factureclient']['id'];
//      $ttc=0;$ht=0;$tva=0;$remise=0;
//      foreach ($facture['Lignefactureclient'] as $ligne){
//         $ttc=$ttc+$ligne['totalttc'];
//         $ht=$ht+$ligne['totalht'];
//         $tva=$tva+$ligne['mtva'];
//         $remise=$remise+(($ligne['quantite']*$ligne['prix'])*($ligne['remise']/100));
//      }
//      $ttc=$ttc+0.500;
//      $this->Factureclient->updateAll(array('Factureclient.remise' => $remise,'Factureclient.tva' => $tva
//      ,'Factureclient.totalht' => $ht,'Factureclient.totalttc' => $ttc), 
//      array('Factureclient.id' => $id));
//  }
       
		$this->loadModel('Typedipliquation');
		$typedipliquations=$this->Typedipliquation->find('list');
                $clients = $this->Client->find('list');
                 $this->set(compact('typedipliquations','pointdeventes','exerciceid','exercices','date1','date2','clientid','clients','factureclients',$this->paginate()));

	}
        
        
        
public function imprimerrecherche() { 
         $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factureclients'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
       $this->loadModel('Client');         
       //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Factureclient.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Factureclient.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            $cond3 = 'Factureclient.client_id ='.$clientid;
        } 
         
  $factureclients = $this->Factureclient->find('all', array( 'conditions' => array('Factureclient.id > ' => 0, @$cond1, @$cond2, @$cond3 )));

                 $this->set(compact('factureclients','date1','date2','clientid'));     
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
                if(@$liens['lien']=='factureclients'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
               $this->loadModel('Lignefactureclient');
		if (!$this->Factureclient->exists($id)) {
			throw new NotFoundException(__('Invalid factureclient'));
		}
		$options = array('conditions' => array('Factureclient.' . $this->Factureclient->primaryKey => $id));
		$this->set('factureclient', $this->Factureclient->find('first', $options));
                 $lignefactureclients = $this->Lignefactureclient->find('all',array(
                    'conditions'=>array('Lignefactureclient.factureclient_id' => $id)
                    )); 
                 $this->set(compact('lignefactureclients'));
	}
        
        
        
        public function imprimer($id = null) {
           $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factureclients'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Lignefactureclient');
		if (!$this->Factureclient->exists($id)) {
			throw new NotFoundException(__('Invalid bonreception'));
		}
		$options = array('conditions' => array('Factureclient.' . $this->Factureclient->primaryKey => $id));
		$this->set('factureclient', $this->Factureclient->find('first', $options));
                $lignefactureclients = $this->Lignefactureclient->find('all',array(
                    'conditions'=>array('Lignefactureclient.factureclient_id' => $id)
                    ));
                 $this->set(compact('lignefactureclients'));
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
                if(@$liens['lien']=='factureclients'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Utilisateur');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Stockdepot');
            $this->loadModel('Pointdevente');
             $this->loadModel('Article');
		if ($this->request->is('post')) {
                    //debug($this->request->data);die;
                    $this->request->data['Factureclient']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Factureclient']['date'])));
	            $this->request->data['Factureclient']['utilisateur_id']= CakeSession::read('users');
                    $this->request->data['Factureclient']['type']= 'direct';
                    if(empty($this->request->data['Factureclient']['pointdevente_id'])){
                    $this->request->data['Factureclient']['pointdevente_id']= CakeSession::read('pointdevente');
                     }
                    $this->request->data['Factureclient']['exercice_id']=date("Y");
                        
         $pv= CakeSession::read('pointdevente'); 
          if($pv==0) {
          $pv=$this->request->data['Factureclient']['pointdevente_id'];   
         }
         $numero = $this->Factureclient->find('all',
         array('fields' =>array('MAX(Factureclient.numeroconca) as num'),
          'conditions' => array('Factureclient.pointdevente_id'=>$pv))
         );
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
  $anne=$getexercice['Factureclient']['exercice_id'];  
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
                        
                        $this->request->data['Factureclient']['numeroconca']=$mm;
                        $this->request->data['Factureclient']['numero']=$numspecial;
        
			$this->Factureclient->create();
		if(!empty($this->request->data['Lignefactureclient'])){
			if ($this->Factureclient->save($this->request->data)) {
                         $id=$this->Factureclient->id;
                        // debug($id);die;
                              $Lignefactureclients=array();
                               $stockdepots=array();
                              // debug($this->request->data );die;
                              foreach (  $this->request->data['Lignefactureclient'] as $numl=>$f   ){
                                 
                                   //debug($f);die;
                              if ($f['sup']!=1){
                                  
                                $stockdepots[$numl]['quantite']=$f['quantite'];
                                $Lignefactureclients['factureclient_id']=$id;
                                $Lignefactureclients['article_id']= $this->request->data['Lignefactureclient'][$numl]['article_id'];
                                $f['article_id']= $this->request->data['Lignefactureclient'][$numl]['article_id'];
                                $Lignefactureclients['depot_id']=$f['depot_id'];
                                $Lignefactureclients['quantite']=$f['quantite'];
                                $Lignefactureclients['remise']=$f['remise'];
                                $Lignefactureclients['tva']=$f['tva'];
                                $Lignefactureclients['prix']=$f['prixhtva'];
                                $Lignefactureclients['prixnet']=$f['prixnet'];
                                $Lignefactureclients['puttc']=$f['puttc'];
                                $Lignefactureclients['totalhtans']=$f['totalhtans'];
                                $Lignefactureclients['designation']=$f['designation'];
                                $Lignefactureclients['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignefactureclients['totalttc']=((($Lignefactureclients['totalht']))*(1+($f['tva']*0.01)));
                               // debug($Lignefactureclients);die;
                                     $this->Lignefactureclient->create();
                                     $this->Lignefactureclient->save($Lignefactureclients);  
                                     
                                     $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$stockdepots[$numl]['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                                 $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
                              }
                             } 
				$this->Session->setFlash(__('The Factureclient has been saved'));
                                $this->redirect(array('action' => 'index'));
				//$this->redirect(array('action' => 'addbonsorti/'.$id));    
			} else {
				$this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                        }
		}
		}
     $pv= CakeSession::read('pointdevente'); 
         if($pv!=0) {
         $numero = $this->Factureclient->find('all',
         array('fields' =>array('MAX(Factureclient.numeroconca) as num'),
          'conditions' => array('Factureclient.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
  $anne=$getexercice['Factureclient']['exercice_id'];  
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
        }else{
             $mm=0;
         }
		$clients = $this->Factureclient->Client->find('list');
		$utilisateurs = $this->Factureclient->Utilisateur->find('list');
                $p=CakeSession::read('depot');
                if($p==0){
         	$depots = $this->Factureclient->Depot->find('list');
                }else{
         	$depots = $this->Factureclient->Depot->find('list',array('conditions'=>array('Depot.id'=>$p)));
                }
                $timbre = $this->Factureclient->Timbre->find('list',array('fields' => array('Timbre.timbre')));
                $pointdeventes=$this->Pointdevente->find('list');
                $articles=$this->Article->find('list', array( 'conditions' => array('Article.typeetatarticle_id'=>1),'recursive'=>-1)) ;
		$this->set(compact('articles','pointdeventes','clients','timbre', 'utilisateurs', 'depots','mm','numspecial'));
	}
        
        
        //jeya mel bonlivraison
     public function addindirect($tab=null) {
        $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factureclients'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
        $this->loadModel('Lignefactureclient');
           $this->loadModel('Factureclient');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Article');
            $this->loadModel('Stockdepot');
            $this->loadModel('Commande');
            $this->loadModel('Pointdevente');
            $this->loadModel('Bonlivraison');
            $this->loadModel('Client');
            $this->loadModel('Reglementclient');
            $tbr=$tab.',0)';
            list($idbr,$resteidbr)=explode(",",$tbr);
            $tbr='(0,'.$tbr;
            $idbrs=array();
            
            $idlcs=explode(",",$tab);
            $clientid = $this->Bonlivraison->find('first', array('fields'=>array('pointdevente_id','SUM(Bonlivraison.remise) remise','SUM(Bonlivraison.tva) tva','SUM(Bonlivraison.totalht) totalht'
            ,'SUM(Bonlivraison.totalttc) totalttc','AVG(Bonlivraison.client_id) client_id'),'conditions' => array('Bonlivraison.id'=>$idlcs),'recursive'=>-2));
           //debug($clientid);die;
            
             $lignelivraisons=$this->Lignelivraison->find('all', array('fields'=>array('AVG(Lignelivraison.article_id) article_id','AVG(Lignelivraison.depot_id) depot_id','(Lignelivraison.article_id) article_iddd','id'
             ,'SUM(Lignelivraison.quantite) quantite','SUM(Lignelivraison.remise*Lignelivraison.quantite) remise','SUM(Lignelivraison.prix*Lignelivraison.quantite) prix'
             ,'AVG(Lignelivraison.tva) tva','SUM(Lignelivraison.totalht) totalht','SUM(Lignelivraison.totalttc)totalttc','SUM(Lignelivraison.prixnet*Lignelivraison.quantite) prixnet','SUM(Lignelivraison.puttc*Lignelivraison.quantite) puttc')
            ,'conditions' => array('Lignelivraison.bonlivraison_id in'.$tbr),'recursive'=>-2
            ,'group'=>array('Lignelivraison.article_id','Lignelivraison.depot_id')));
        
                
//             $reqclient = $this->Bonlivraison->find('first',array( 'conditions' => array('Bonlivraison.id'=>$idbr),'recursive'=>-2)); 
//             $lignefactures=$this->Lignelivraison->find('all', array( 'conditions' => array('Lignelivraison.bonlivraison_id in'.$tbr),'recursive'=>-2));
//             debug($reqclient);die;
             
             
             if ($this->request->is('post')) {
                    //debug($this->request->data);die;
                        $this->request->data['Factureclient']['fournisseur_id']= $clientid[0]['client_id'];
                        $this->request->data['Factureclient']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Factureclient']['date'])));
			$this->request->data['Factureclient']['utilisateur_id']= CakeSession::read('users');
                        $this->request->data['Factureclient']['client_id']= $clientid[0]['client_id'];
                        $this->request->data['Factureclient']['type']='indirect';
                        $this->request->data['Factureclient']['depot_id']='3';
                         if(empty($this->request->data['Factureclient']['pointdevente_id'])){
                         $this->request->data['Factureclient']['pointdevente_id']= CakeSession::read('pointdevente');
                         }
                    $this->request->data['Factureclient']['exercice_id']=date("Y");
                        
         $pv= CakeSession::read('pointdevente'); 
         if($pv==0) {
          $pv=$this->request->data['Factureclient']['pointdevente_id'];   
         }
         $numero = $this->Factureclient->find('all',
         array('fields' =>array('MAX(Factureclient.numeroconca) as num'),
          'conditions' => array('Factureclient.pointdevente_id'=>$pv))
         );
        foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
  $anne=$getexercice['Factureclient']['exercice_id'];  
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
                        
                        $this->request->data['Factureclient']['numeroconca']=$mm;
                        $this->request->data['Factureclient']['numero']=$numspecial;
                    // debug($this->request->data);die;
			$this->Factureclient->create();
			if ($this->Factureclient->save($this->request->data)) {
                            $id=$this->Factureclient->id;
                            // inserer le facture_id dans les  bons de receptions cochés********************
                                                $idbrs=explode(",",$tab);
                                             //   debug($idbrs);die;
                                               foreach (  $idbrs as $br   ){ 
                                $this->Bonlivraison->updateAll(array('Bonlivraison.factureclient_id' => $id ), array('Bonlivraison.id' =>$br));
                                               }  
                       
                        //debug($this->request->data['Lignefactureclient']);die;
                              $Lignefactures=array();
                               foreach (  $this->request->data['Lignefactureclient'] as $numl=>$f   ){
                                 
                                    //debug($f);die;
                              if ($f['sup']!=1){
                                  
                                $Lignefactures['factureclient_id']=$id;
                                $Lignefactures['depot_id']=$f['depot_id'];
                                $Lignefactures['article_id']=$f['article_id'];
                                $Lignefactures['quantite']=$f['quantite'];
                                $Lignefactures['prix']=$f['prixhtva'];
                                $Lignefactures['remise']=$f['remise'];
                                $Lignefactures['tva']=$f['tva'];
                                $Lignefactures['prixnet']=$f['prixnet'];
                                $Lignefactures['puttc']=$f['puttc'];
                                $Lignefactures['totalhtans']=$f['totalhtans'];
                                $Lignefactures['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignefactures['totalttc']=((($Lignefactures['totalht']))*(1+($f['tva']*0.01)));  
                                     $this->Lignefactureclient->create();
                                     $this->Lignefactureclient->save($Lignefactures);  
                                    
                              }
                      //******************************************************************************************************************
                               if ($f['ans']!=1){
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$f['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                                $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);    
                               }
                    //***************************************************************************************************************************
                             if ($f['ans']==1){
                            $lignefactureanciens= $this->Lignelivraison->find('all',array('conditions'=>array('Lignelivraison.id'=>$f['id']),false));
                           foreach (  $lignefactureanciens as $lr   ){
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
                                 $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$f['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                                $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);  
                                   
                           }
                    //*****************************************************************************************************************************
                               } 
                            
				$this->Session->setFlash(__('The facture has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
			}
		}
            
          //*************************************************************************************************************************************      
//          $lignefactureanciens= $this->Lignefactureclient->find('all',array('conditions'=>array('Lignefactureclient.factureclient_id'=>$id),false));
//                            foreach (  $lignefactureanciens as $lra   ){
//                               
//                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+'.$lra['Lignefactureclient']['quantite']), array('Stockdepot.article_id' =>$lra['Lignefactureclient']['article_id'],'Stockdepot.depot_id' =>$lra['Lignefactureclient']['depot_id']));
//                            } 
//             $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
//                                if (!empty($stckdepot)){
//                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$stockdepots[$numl]['quantite'];
//                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
//                                   }
//                                   $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
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
              
              
        $pv= CakeSession::read('pointdevente'); 
           if($pv==0){
             $pv=$clientid['Bonlivraison']['pointdevente_id'];
             } 
         $numero = $this->Factureclient->find('all',
         array('fields' =>array('MAX(Factureclient.numeroconca) as num'),
          'conditions' => array('Factureclient.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
  $anne=$getexercice['Factureclient']['exercice_id'];  
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
                
                
                
                
                $client = $this->Client->find('first', array( 'conditions' => array('Client.id'=>$clientid[0]['client_id']),'recursive'=>-2));
                $pntv=$clientid['Bonlivraison']['pointdevente_id'];
                $client=$client['Client']['name'];
		$utilisateurs = $this->Factureclient->Utilisateur->find('list');
                $articles=$this->Article->find('list', array( 'conditions' => array('Article.typeetatarticle_id'=>1),'recursive'=>-1)) ;
                $pointdeventes=$this->Pointdevente->find('list');
                $clients = $this->Factureclient->Client->find('list');
                $timbre = $this->Factureclient->Timbre->find('list',array('fields' => array('Timbre.timbre')));
                
              
                
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
                     , 'conditions' => array('Reglementclient.type ' => 1,'Reglementclient.affectation_id  ' => 0,'Reglementclient.client_id'=>$clientid[0]['client_id'])));
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
                
                 $tot=$clientid[0]['totalttc']+$timbre[1];
                
		$this->set(compact('name','autorisation','solde','tot','clientid','tabqtestock','articles','depots','valreste','matriculefiscale','adresse','pointdeventes','pntv','clients','client', 'utilisateurs','articles','mm','lignelivraisons','numspecial', 'timbre'));
	}
   
   
    // jeya mel commande 
      public function addfacindirect($tab=null) {
           $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factureclients'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
        // debug($tab);die;
            $this->loadModel('Pointdevente');
            $this->loadModel('Article');
            $this->loadModel('Depot');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Lignecommandeclient');
            $this->loadModel('Commandeclient');
            $this->loadModel('Client');
            $this->loadModel('Stockdepot');
            $this->loadModel('Pointdevente');
            $this->loadModel('Reglementclient');
            $tbr=$tab.',0)';
            list($idbr,$resteidbr)=explode(",",$tbr);
            $tbr='(0,'.$tbr;
           // debug($idbr);die;
            $idlcs=array();
            $idlcs=explode(",",$tab);       
                  
            $clientid = $this->Commandeclient->find('first', array('fields'=>array('pointdevente_id','SUM(Commandeclient.remise) remise','SUM(Commandeclient.tva) tva','SUM(Commandeclient.totalht) totalht'
            ,'SUM(Commandeclient.totalttc) totalttc','AVG(Commandeclient.client_id) client_id'),'conditions' => array('Commandeclient.id'=>$idlcs),'recursive'=>-2));
           //debug($clientid);die;
            
             $lignelivraisons=$this->Lignecommandeclient->find('all', array('fields'=>array('AVG(Lignecommandeclient.article_id) article_id','AVG(Lignecommandeclient.depot_id) depot_id','(Lignecommandeclient.article_id) article_iddd'
             ,'SUM(Lignecommandeclient.quantite) quantite','SUM(Lignecommandeclient.remise*Lignecommandeclient.quantite) remise','SUM(Lignecommandeclient.prix*Lignecommandeclient.quantite) prix'
             ,'AVG(Lignecommandeclient.tva) tva','SUM(Lignecommandeclient.totalht) totalht','SUM(Lignecommandeclient.totalttc)totalttc','SUM(Lignecommandeclient.prixnet*Lignecommandeclient.quantite) prixnet','SUM(Lignecommandeclient.puttc*Lignecommandeclient.quantite) puttc')
            ,'conditions' => array('Lignecommandeclient.commandeclient_id in'.$tbr),'recursive'=>-2
            ,'group'=>array('Lignecommandeclient.article_id','Lignecommandeclient.depot_id')));
             
             //debug($clientid);debug($lignelivraisons);die;
             
		if ($this->request->is('post')) {
                   // debug($this->request->data);die;
                     $this->request->data['Factureclient']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Factureclient']['date'])));
	             $this->request->data['Factureclient']['utilisateur_id']= CakeSession::read('users');
                     $this->request->data['Factureclient']['client_id']= $clientid[0]['client_id'];
                     $this->request->data['Factureclient']['type']='direct';
                        if(empty($this->request->data['Factureclient']['pointdevente_id'])){
                        $this->request->data['Factureclient']['pointdevente_id']= CakeSession::read('pointdevente');
                        }  
                        $this->request->data['Factureclient']['exercice_id']=date("Y");
                        
         $pv= CakeSession::read('pointdevente');
         if($pv==0) {
          $pv=$this->request->data['Factureclient']['pointdevente_id'];   
         }
         $numero = $this->Factureclient->find('all',
         array('fields' =>array('MAX(Factureclient.numeroconca) as num'),
          'conditions' => array('Factureclient.pointdevente_id'=>$pv))
         );
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
  $anne=$getexercice['Factureclient']['exercice_id'];  
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
                        
                        $this->request->data['Factureclient']['numeroconca']=$mm;
                        $this->request->data['Factureclient']['numero']=$numspecial;
                      //debug($this->request->data);die;
			$this->Factureclient->create();
                  if(!empty($this->request->data['Lignefactureclient'])){
			if ($this->Factureclient->save($this->request->data)) {
                            foreach ($idlcs as $idc){
                               $this->Commandeclient->updateAll(array('Commandeclient.etat' =>1), array('Commandeclient.id' =>$idc));       
                            }
                         $id=$this->Factureclient->id;
                        $Lignelivraisons=array();
                               $stockdepots=array();
                              foreach (  $this->request->data['Lignefactureclient'] as $numl=>$f   ){
                                 
                                 //  debug($f);die;
                              if ($f['sup']!=1){
                                 
                                $stockdepots[$numl]['quantite']=$f['quantite'];
                                $Lignefactures['factureclient_id']=$id;
                                $Lignefactures['depot_id']=$f['depot_id'];
                                $Lignefactures['article_id']=$f['article_id'];
                                $Lignefactures['quantite']=$f['quantite'];
                                $Lignefactures['remise']=$f['remise'];
                                $Lignefactures['tva']=$f['tva'];
                                $Lignefactures['prix']=$f['prixhtva'];
                                $Lignefactures['prixnet']=$f['prixnet'];
                                $Lignefactures['puttc']=$f['puttc'];
                                $Lignefactures['totalhtans']=$f['totalhtans'];
                                $Lignefactures['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignefactures['totalttc']=((($Lignefactures['totalht']))*(1+($f['tva']*0.01)));  
                                     $this->Lignefactureclient->create();
                                     $this->Lignefactureclient->save($Lignefactures);  
                                     
                                     
                                     
                             $lignecommandeclients = $this->Lignecommandeclient->find('all',array(
                                 'conditions'=>array('Lignecommandeclient.commandeclient_id in'.$tbr,'Lignecommandeclient.article_id' =>$f['article_id']),'recursive'=>-1
                                ));
                               $int=$f['quantite'];
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
             $pv=$clientid['Commandeclient']['pointdevente_id'];
             } 
         $numero = $this->Factureclient->find('all',
         array('fields' =>array('MAX(Factureclient.numeroconca) as num'),
          'conditions' => array('Factureclient.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
  $anne=$getexercice['Factureclient']['exercice_id'];  
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
		$utilisateurs = $this->Factureclient->Utilisateur->find('list');
                $articles = $this->Article->find('list');
                $timbre = $this->Factureclient->Timbre->find('list',array('fields' => array('Timbre.timbre')));
                //debug($timbre);die;
                $pointdeventes=$this->Pointdevente->find('list');
                $clients = $this->Factureclient->Client->find('list');
                
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
                
                
                $tot=$clientid[0]['totalttc']+$timbre[1];
                
                
		$this->set(compact('name','autorisation','solde','tot','clientid','tabqtestock','articles','depots','valreste','matriculefiscale','adresse','pointdeventes','pntv','clients','client', 'utilisateurs','articles','mm','lignelivraisons','numspecial', 'timbre'));
	}
        
        
        
        //jeya mel devie
       public function addfacfromdeviseindirect($tab=null) {
              $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factureclients'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
        // debug($tab);die;
            $this->loadModel('Article');
            $this->loadModel('Depot');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Lignedevi');
            $this->loadModel('Devi');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Client');
            $this->loadModel('Stockdepot');
            $this->loadModel('Pointdevente');
            $this->loadModel('Reglementclient');
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
                   // debug($this->request->data);die;
                     $this->request->data['Factureclient']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Factureclient']['date'])));
	             $this->request->data['Factureclient']['utilisateur_id']= CakeSession::read('users');
                     $this->request->data['Factureclient']['client_id']= $clientid[0]['client_id'];
                     $this->request->data['Factureclient']['type']='direct';
                        if(empty($this->request->data['Factureclient']['pointdevente_id'])){
                        $this->request->data['Factureclient']['pointdevente_id']= CakeSession::read('pointdevente');
                        }                       
                        $this->request->data['Factureclient']['exercice_id']=date("Y");
                        
         $pv= CakeSession::read('pointdevente'); 
         if($pv==0) {
          $pv=$this->request->data['Factureclient']['pointdevente_id'];   
         }
         $numero = $this->Factureclient->find('all',
         array('fields' =>array('MAX(Factureclient.numeroconca) as num'),
          'conditions' => array('Factureclient.pointdevente_id'=>$pv))
         );
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
  $anne=$getexercice['Factureclient']['exercice_id'];  
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
                        
                        $this->request->data['Factureclient']['numeroconca']=$mm;
                        $this->request->data['Factureclient']['numero']=$numspecial;
                      //debug($this->request->data);die;
			$this->Factureclient->create();
                  if(!empty($this->request->data['Lignefactureclient'])){
			if ($this->Factureclient->save($this->request->data)) {
                             foreach ($idlcs as $idc){
                               $this->Devi->updateAll(array('Devi.etat' =>1), array('Devi.id' =>$idc));       
                            } 
                         $Lignelivraisons=array();   
                         $id=$this->Factureclient->id;
                        $stockdepots=array();
                              foreach (  $this->request->data['Lignefactureclient'] as $numl=>$f   ){
                                 
                                 //  debug($f);die;
                              if ($f['sup']!=1){
                                
                                $stockdepots[$numl]['quantite']=$f['quantite'];
                                $Lignefactures['factureclient_id']=$id;
                                $Lignefactures['depot_id']=$f['depot_id'];
                                $Lignefactures['article_id']=$f['article_id'];
                                $Lignefactures['quantite']=$f['quantite'];
                                $Lignefactures['remise']=$f['remise'];
                                $Lignefactures['tva']=$f['tva'];
                                $Lignefactures['prix']=$f['prixhtva'];
                                $Lignefactures['prixnet']=$f['prixnet'];
                                $Lignefactures['puttc']=$f['puttc'];
                                $Lignefactures['totalhtans']=$f['totalhtans'];
                                $Lignefactures['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignefactures['totalttc']=((($Lignefactures['totalht']))*(1+($f['tva']*0.01)));  
                                     $this->Lignefactureclient->create();
                                     $this->Lignefactureclient->save($Lignefactures);  
                                     
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
				$this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                        }
		}
                }
                
       $pv= CakeSession::read('pointdevente'); 
          if($pv==0){
             $pv=$clientid['Devi']['pointdevente_id'];
             } 
         $numero = $this->Factureclient->find('all',
         array('fields' =>array('MAX(Factureclient.numeroconca) as num'),
          'conditions' => array('Factureclient.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) { 
   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
  $anne=$getexercice['Factureclient']['exercice_id'];  
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
		$utilisateurs = $this->Factureclient->Utilisateur->find('list');
                $timbre = $this->Factureclient->Timbre->find('list',array('fields' => array('Timbre.timbre')));
                $articles = $this->Article->find('list');
                $pointdeventes=$this->Pointdevente->find('list');
                $clients = $this->Factureclient->Client->find('list');
                
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
                     , 'conditions' => array('Reglementclient.type  ' => 1,'Reglementclient.affectation_id ' => 0,'Reglementclient.client_id'=>$clientid[0]['client_id'])));
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
                
                
               $tot=$clientid[0]['totalttc']+$timbre[1]; 
                
		$this->set(compact('name','autorisation','solde','tot','clientid','tabqtestock','articles','depots','valreste','matriculefiscale','adresse','pointdeventes','pntv','clients','client', 'utilisateurs','articles','mm','lignelivraisons','numspecial', 'timbre'));
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
                if(@$liens['lien']=='factureclients'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Lignefactureclient');
             $this->loadModel('Stockdepot');
             $this->loadModel('Article');
             $this->loadModel('Bonsorti');
             $this->loadModel('Lignesorti');
             $this->loadModel('Lignefactureclient');
             $this->loadModel('Lignesortidetail');
		if (!$this->Factureclient->exists($id)) {
			throw new NotFoundException(__('Invalid Factureclient'));
		}
		if ($this->request->is('post')) {
                     //debug($this->request->data );die;
                    $this->request->data['Bonsorti']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonsorti']['date'])));
	            $this->request->data['Bonsorti']['utilisateur_id']= CakeSession::read('users');
                    $this->request->data['Bonsorti']['factureclient_id']=$id;
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
                                $Lignesortis['lignefactureclient_id']=$f['id'];
                                $Lignesortis['depot_id']=$f['depot_id'];
                                $Lignesortis['article_id']=$f['article_id'];
                                $Lignesortis['quantite']=$f['quantite'];
                                $qtebl=$qtebl+$f['quantite'];
                                     $this->Lignesorti->create();
                                     $this->Lignesorti->save($Lignesortis); 
                                     $idls=$this->Lignesorti->id; 
                                     $qteliv[$f['id']]=0;                                     
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
                             $this->Lignefactureclient->updateAll(array('Lignefactureclient.quantitelivrai'=>'Lignefactureclient.quantitelivrai+'.$qteliv[$f['id']]), array('Lignefactureclient.id' =>$f['id']));   
                              }
                             } 
                               if($qtelivrai==$qtebl){
                             $this->Factureclient->updateAll(array('Factureclient.etat' =>1), array('Factureclient.id' =>$id));       
                               }
				$this->Session->setFlash(__('The facture has been saved'));
				$this->redirect(array('action' => 'index'));    
			} else {
				$this->Session->setFlash(__('la  facture  dois avoir aux moins une ligne de livraison.'));
                        }
		}
                }
         $lignefactureclients = $this->Lignefactureclient->find('all',array('conditions'=>array('Lignefactureclient.factureclient_id' => $id)));  
          //debug($lignefactureclients); die;
         
      foreach (  $lignefactureclients as $q=>$ll   ){  
          
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
          $lignefactureclients[$q]['Stockdepots']=$stkdepots;
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
		$clients = $this->Factureclient->Client->find('list');
		$utilisateurs = $this->Factureclient->Utilisateur->find('list');
		$depots = $this->Factureclient->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('clients', 'utilisateurs', 'depots','lignefactureclients','articles','tabqtestock','mm'));   
        }
        
        
        
        public function addfactureavoir($idfc = null) {
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
                   // debug($this->request->data);die;
                     $this->request->data['Factureavoir']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Factureavoir']['date'])));
	             $this->request->data['Factureavoir']['utilisateur_id']= CakeSession::read('users');
                     //$this->request->data['Factureavoir']['typefacture_id']=2;//modifier 19/04/2016
                     $this->request->data['Factureavoir']['factureclient_id']=$idfc;//modifier 19/04/2016
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
                            $this->Factureclient->updateAll(array('Factureclient.factureavoir_id' => $id), array('Factureclient.id' =>$idfc));
                          
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
                
                
         
         $lignefactureclients = $this->Lignefactureclient->find('all',array('conditions'=>array('Lignefactureclient.factureclient_id' => $idfc))); 
         $Factureclient = $this->Factureclient->find('all',array('conditions'=>array('Factureclient.id' => $idfc))); 
         
         

                $articles = $this->Article->find('list');        
		$clients = $this->Factureavoir->Client->find('list');
		$utilisateurs = $this->Factureavoir->Utilisateur->find('list');
		$depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$typefactures = $this->Factureavoir->Typefacture->find('list');
                $timbre = $this->Factureavoir->Timbre->find('list',array('fields' => array('Timbre.timbre')));
                $pointdeventes=$this->Pointdevente->find('list');
		$this->set(compact('pointdeventes','numspecial','clients', 'utilisateurs','timbre', 'depots', 'typefactures','mm','articles','lignefactureclients','Factureclient'));
	}
        
        
	public function edit($id = null) {
             $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='factureclients'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                  $this->loadModel('Pointdevente');  
              $this->loadModel('Lignefactureclient');
              $this->loadModel('Stockdepot');
              $this->loadModel('Article');
              $this->loadModel('Reglementclient');
		if (!$this->Factureclient->exists($id)) {
			throw new NotFoundException(__('Invalid factureclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                   // debug($this->request->data);die;
                     $this->request->data['Factureclient']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Factureclient']['date'])));
	            $this->request->data['Factureclient']['utilisateur_id']= CakeSession::read('users');
                       //$this->request->data['Factureclient']['type']= 'direct';
			if ($this->Factureclient->save($this->request->data)) {
                            
            $factures = $this->Factureclient->find('first',array('conditions'=>array('Factureclient.id' => $id))); 
            $type=$factures['Factureclient']['type'];
           // debug($factures);die;
            if($type=="direct"){
                            $lignefactureanciens= $this->Lignefactureclient->find('all',array('conditions'=>array('Lignefactureclient.factureclient_id'=>$id),false));
                            foreach (  $lignefactureanciens as $lra   ){
                               
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+'.$lra['Lignefactureclient']['quantite']), array('Stockdepot.article_id' =>$lra['Lignefactureclient']['article_id'],'Stockdepot.depot_id' =>$lra['Lignefactureclient']['depot_id']));
                            } 
            } 
                            $this->Lignefactureclient->deleteAll(array('Lignefactureclient.factureclient_id'=>$id),false); 
                             $Lignefactureclients=array();
                             $stockdepots=array();
                               foreach (  $this->request->data['Lignefactureclient'] as $numl=>$f   ){  
                                 //  debug($f);die;
                              if ($f['sup']!=1){
                                  
                                $stockdepots[$numl]['quantite']=$f['quantite'];
                                $Lignefactureclients['factureclient_id']=$id;
                                $Lignefactureclients['depot_id']=$f['depot_id'];
                                $Lignefactureclients['article_id']=$f['article_id'];
                                $Lignefactureclients['quantite']=$f['quantite'];
                                $Lignefactureclients['remise']=$f['remise'];
                                $Lignefactureclients['tva']=$f['tva'];
                                $Lignefactureclients['prix']=$f['prixhtva'];
                                $Lignefactureclients['prixnet']=$f['prixnet'];
                                $Lignefactureclients['puttc']=$f['puttc'];
                                $Lignefactureclients['totalhtans']=$f['totalhtans'];
                                $Lignefactureclients['designation']=$f['designation'];
                                $Lignefactureclients['totalht']=($f['prixhtva']*(1-$f['remise']*0.01))*$f['quantite'];
                                $Lignefactureclients['totalttc']=((($Lignefactureclients['totalht']))*(1+($f['tva']*0.01)));  
                                     $this->Lignefactureclient->create();
                                     $this->Lignefactureclient->save($Lignefactureclients);  
                                if($type=="direct"){     
                                 $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$stockdepots[$numl]['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                                   $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
                              }}
                             } 
				$this->Session->setFlash(__('The factureclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The factureclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Factureclient.' . $this->Factureclient->primaryKey => $id));
			$this->request->data = $this->Factureclient->find('first', $options);
		}
     //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++                
            $lignefactureclients = $this->Lignefactureclient->find('all',array('conditions'=>array('Lignefactureclient.factureclient_id' => $id))); 
                //debug($lignefactureclients); die;
         
      foreach (  $lignefactureclients as $ll   ){  
          
    //**************************************trouver la liste des articles pour chaque depot *******************************************************

         $artdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.depot_id'=>$ll['Depot']['id']),'recursive'=>-1));
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
                
                
		$clients = $this->Factureclient->Client->find('list');
		$utilisateurs = $this->Factureclient->Utilisateur->find('list');
                $timbre = $this->Factureclient->Timbre->find('list',array('fields' => array('Timbre.timbre')));
                $date=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Factureclient']['date'])));
                $pointdeventes=$this->Pointdevente->find('list');
                $articles=$this->Article->find('list');
                 //info client**************************************************
            $this->loadModel('Bonlivraison');
            $this->loadModel('Factureclient');
            $this->loadModel('Client');
            $facture= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.id'=>$id),false));
            $clientid=$facture['Factureclient']['client_id'];
            $name=$facture['Factureclient']['name'];
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
         	$depots = $this->Factureclient->Depot->find('list',array('fields' => array('Depot.designation')));
                }else{
         	$depots = $this->Factureclient->Depot->find('list',array('fields' => array('Depot.designation'),'conditions'=>array('Depot.id'=>$p)));
                }
		$this->set(compact('name','autorisation','solde','valreste','matriculefiscale','adresse','pointdeventes','clients', 'utilisateurs', 'timbre','depots','date','lignefactureclients','articles','tabqtestock'));
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
                if(@$liens['lien']=='factureclients'){
                        $x=$liens['delete'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Stockdepot');
            $this->loadModel('Lignefactureclient');
		$this->Factureclient->id = $id;
		if (!$this->Factureclient->exists()) {
			throw new NotFoundException(__('Invalid factureclient'));
		}
		$this->request->onlyAllow('post', 'delete');
                
                $facture=$this->Factureclient->find('first',array('conditions'=>array('Factureclient.id'=>$id),false)); 
               $typefacture=$facture['Factureclient']['type'];
               if($typefacture=="direct"){
                $lrs=$this->Lignefactureclient->find('all',array('conditions'=>array('Lignefactureclient.factureclient_id'=>$id),false)); 
                 //debug($lrs);die;
                $stkdepqte=array();
                  foreach (  $lrs as $lr   ){
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$lr['Lignefactureclient']['article_id'],'Stockdepot.depot_id'=>$lr['Lignefactureclient']['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stkdepqte['quantite']= $stckdepot[0]['Stockdepot']['quantite']+$lr['Lignefactureclient']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stkdepqte['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }else{
                                 $stkdepqte['quantite']=$lr['Lignefactureclient']['quantite'];
                                 $stkdepqte['article_id']=$lr['Lignefactureclient']['article_id'];
                                 $stkdepqte['depot_id']=$lr['Lignefactureclient']['depot_id'];
                                 $this->Stockdepot->create();
                                 $this->Stockdepot->save($stkdepqte);
                                   }
                              }
               }
                
                
        $this->Lignefactureclient->deleteAll(array('Lignefactureclient.factureclient_id'=>$id),false);    
		if ($this->Factureclient->delete()) {
			$this->Session->setFlash(__('Factureclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Factureclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
          
        public function  article(){
            $this->layout = null;
            $this->loadModel('Article');  
            $data = $this->request->data;//debug($data);
           $json = null;
           $articleid= $data['id'];
         //debug($data);
        $article= $this->Article->find('all',array('conditions'=>array('Article.id'=>$articleid),false));
       
          $tva=$article[0]['Article']['tva'];
          $prix=$article[0]['Article']['prixvente'];
         //debug($qtestock);die;
           echo json_encode(array('tva'=>$tva,'prix'=>$prix));
          die();
     } 
}
