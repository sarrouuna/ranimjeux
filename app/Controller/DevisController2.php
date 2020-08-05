<?php
App::uses('AppController', 'Controller');
/**
 * Devis Controller
 *
 * @property Devi $Devi
 */
class DevisController extends AppController {

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
                if(@$liens['lien']=='devis'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		       
       $this->loadModel('Client'); 
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Typedipliquation');
        
        $pointdeventes = $this->Pointdevente->find('list');
       $exercices = $this->Exercice->find('list');
       $exe=date('Y');
       $exercice = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
       $exerciceid=$exercice['Exercice']['id'];
       $cond4 = 'Devi.exercice_id ='.$exe;
        $pv="";
       $p=CakeSession::read('pointdevente');
       if($p>0){
          $pv= 'Devi.pointdevente_id = '.$p;
       }
         if (isset($this->request->data) && !empty($this->request->data)) {
       // debug($this->request->data);die;
        if ($this->request->data['Devi']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Devi']['date1'])));
            $cond1 = 'Devi.date >= '."'".$date1."'";
            $cond4="";
        }
        
        if ($this->request->data['Devi']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Devi']['date2'])));
            $cond2 = 'Devi.date <= '."'".$date2."'";
            $cond4="";
        }
        
       if ($this->request->data['Devi']['client_id']) {
            $clientid= $this->request->data['Devi']['client_id'];
            $cond3 = 'Devi.client_id ='.$clientid;
        } 
         if ($this->request->data['Devi']['exercice_id']) {
            $exerciceid = $this->request->data['Devi']['exercice_id'];
            $cond4 = 'Devi.exercice_id ='.$exercices[$exerciceid];
        } 
        if ($this->request->data['Devi']['pointdevente_id']) {
            $pointdeventeid = $this->request->data['Devi']['pointdevente_id'];
            $cond5 = 'Devi.pointdevente_id ='.$pointdeventeid;
        } 
        
    } 
  $devis = $this->Devi->find('all', array( 'conditions' => array('Devi.id > ' => 0,$pv, @$cond1, @$cond2, @$cond3 , @$cond4, @$cond5)
   ,'order'=>array('Devi.id'=>'desc')));
//    foreach ($devis as $facture){
//      $id=$facture['Devi']['id'];
//      $ttc=0;$ht=0;$tva=0;$remise=0;
//      foreach ($facture['Lignedevi'] as $ligne){
//         $ttc=$ttc+$ligne['totalttc'];
//         $ht=$ht+$ligne['totalht'];
//         $tva=$tva+$ligne['mtva'];
//         $remise=$remise+(($ligne['quantite']*$ligne['prix'])*($ligne['remise']/100));
//      }
//      //$ttc=$ttc+0.500;
//      $this->Devi->updateAll(array('Devi.remise' => $remise,'Devi.tva' => $tva
//      ,'Devi.totalht' => $ht,'Devi.totalttc' => $ttc), 
//      array('Devi.id' => $id));
//  }
		$typedipliquations=$this->Typedipliquation->find('list');
                $clients = $this->Client->find('list');
                 $this->set(compact('typedipliquations','pointdeventes','exerciceid','exercices','date1','date2','clientid','clients','devis'));

	}
        
        public function indexx() {
             $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='devis'){
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
        $cond4 = 'Devi.exercice_id ='.$exe;
        $pv="";
       $p=CakeSession::read('pointdevente');
       if($p>0){
          $pv= 'Devi.pointdevente_id = '.$p;
       }
         if (isset($this->request->data) && !empty($this->request->data)) {
       // debug($this->request->data);die;
        if ($this->request->data['Devi']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Devi']['date1'])));
            $cond1 = 'Devi.date >= '."'".$date1."'";
            $cond4="";
        }
        
        if ($this->request->data['Devi']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Devi']['date2'])));
            $cond2 = 'Devi.date <= '."'".$date2."'";
            $cond4="";
        }
        
       if ($this->request->data['Devi']['client_id']) {
            $clientid= $this->request->data['Devi']['client_id'];
            $cond3 = 'Devi.client_id ='.$clientid;
        } 
         if ($this->request->data['Devi']['exercice_id']) {
            $exerciceid = $this->request->data['Devi']['exercice_id'];
            $cond4 = 'Devi.exercice_id ='.$exercices[$exerciceid];
        } 
        if ($this->request->data['Devi']['pointdevente_id']) {
            $pointdeventeid = $this->request->data['Devi']['pointdevente_id'];
            $cond5 = 'Devi.pointdevente_id ='.$pointdeventeid;
        } 
        
    } 
  $devis = $this->Devi->find('all', array( 'conditions' => array('Devi.id > ' => 0,$pv, @$cond1, @$cond2, @$cond3 , @$cond4, @$cond5)));
//    foreach ($devis as $facture){
//      $id=$facture['Devi']['id'];
//      $ttc=0;$ht=0;$tva=0;$remise=0;
//      foreach ($facture['Lignedevi'] as $ligne){
//         $ttc=$ttc+$ligne['totalttc'];
//         $ht=$ht+$ligne['totalht'];
//         $tva=$tva+$ligne['mtva'];
//         $remise=$remise+(($ligne['quantite']*$ligne['prix'])*($ligne['remise']/100));
//      }
//      //$ttc=$ttc+0.500;
//      $this->Devi->updateAll(array('Devi.remise' => $remise,'Devi.tva' => $tva
//      ,'Devi.totalht' => $ht,'Devi.totalttc' => $ttc), 
//      array('Devi.id' => $id));
//  }
		
                $clients = $this->Client->find('list');
                 $this->set(compact('pointdeventes','exerciceid','exercices','date1','date2','clientid','clients','devis',$this->paginate()));

	}
        
    public function imprimerrecherche() { 
         $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='devis'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
       $this->loadModel('Client');         
       //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Devi.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Devi.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            $cond3 = 'Devi.client_id ='.$clientid;
        } 
         
  $devis = $this->Devi->find('all', array( 'conditions' => array('Devi.id > ' => 0, @$cond1, @$cond2, @$cond3 )));

                 $this->set(compact('devis','date1','date2','clientid'));     
   
         }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null,$type=null) {
            $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='devis'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            // debug($type);die;
            $this->loadModel('Lignedevi');
		if (!$this->Devi->exists($id)) {
			throw new NotFoundException(__('Invalid devi'));
		}
		$options = array('conditions' => array('Devi.' . $this->Devi->primaryKey => $id));
		$this->set('devi', $this->Devi->find('first', $options));
                $lignedevis = $this->Lignedevi->find('all',array('conditions'=>array('Lignedevi.devi_id' => $id)));  
                $this->set(compact('lignedevis','type'));
	}
        
        public function imprimer($id = null) {
           $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='devis'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Lignedevi');
		if (!$this->Devi->exists($id)) {
			throw new NotFoundException(__('Invalid devi'));
		}
		$options = array('conditions' => array('Devi.' . $this->Devi->primaryKey => $id));
		$this->set('devi', $this->Devi->find('first', $options));
                $lignedevis = $this->Lignedevi->find('all',array(
                'conditions'=>array('Lignedevi.devi_id' => $id)
                ,'order'=>array('Lignedevi.id'=>'ASC')));
                 $this->set(compact('lignedevis'));
	}
        
        public function imprimerfactproforma($id = null) {
           $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='devis'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Lignedevi');
		if (!$this->Devi->exists($id)) {
			throw new NotFoundException(__('Invalid devi'));
		}
		$options = array('conditions' => array('Devi.' . $this->Devi->primaryKey => $id));
		$this->set('devi', $this->Devi->find('first', $options));
                $lignedevis = $this->Lignedevi->find('all',array(
                    'conditions'=>array('Lignedevi.devi_id' => $id)
                    ));
                 $this->set(compact('lignedevis'));
	}
/**
 * add method
 *
 * @return void
 */
	public function add($type=null) {
              $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='devis'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Depot');
             $this->loadModel('Pointdevente');
             $this->loadModel('Article');
             $this->loadModel('Lignedevi');
             $this->loadModel('Timbre');
		if ($this->request->is('post')) {
                     //debug($this->request->data);die;
                     $this->request->data['Devi']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Devi']['date'])));
		     $this->request->data['Devi']['utilisateur_id']= CakeSession::read('users');
                       if(empty($this->request->data['Devi']['pointdevente_id'])){
                        $this->request->data['Devi']['pointdevente_id']= CakeSession::read('pointdevente');
                        } 
                     $this->request->data['Devi']['totalttc']=$this->request->data['Devi']['totalttc']-$this->request->data['Devi']['timbre_id'];   
                     $this->request->data['Devi']['type']=$type;
                     $this->request->data['Devi']['exercice_id']=date("Y");
                      $pv= CakeSession::read('pointdevente'); 
            if($pv==0) {
          $pv=$this->request->data['Devi']['pointdevente_id'];   
         }
         $numero = $this->Devi->find('all',
         array('fields' =>array('MAX(Devi.numeroconca) as num'),
          'conditions' => array('Devi.pointdevente_id'=>$pv,'Devi.exercice_id'=>date("Y")))
         );
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {  
//        $getexercice= $this->Devi->find('first',array('conditions'=>array('Devi.numeroconca'=>$n)));
//        $anne=$getexercice['Devi']['exercice_id'];  
//        if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }  
            
       } else {
                $mm = "000001";
            }
            $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
                        
                        $this->request->data['Devi']['numeroconca']=$mm;
                        $this->request->data['Devi']['numero']=$numspecial;
			$this->Devi->create();
			 if(!empty($this->request->data['Lignedevi'])){
			if ($this->Devi->save($this->request->data)) {
                         $id=$this->Devi->id;
                               
                              foreach (  $this->request->data['Lignedevi'] as $i=>$f   ){
                              if ($f['sup']!=1){
                                $Lignedevis['devi_id']=$id;
                                $Lignedevis['depot_id']=$f['depot_id'];
                                $Lignedevis['article_id']=$this->request->data['Lignedevi'][$i]['article_id'];
                                $Lignedevis['quantite']=$f['quantite'];
                                $Lignedevis['remise']=$f['remise'];
                                $Lignedevis['tva']=$f['tva'];
                                $Lignedevis['prix']=$f['prixhtva'];
                                $Lignedevis['prixnet']=$f['prixnet'];
                                $Lignedevis['puttc']=$f['puttc'];
                                $Lignedevis['totalhtans']=$f['totalhtans'];
                                $Lignedevis['designation']=$f['designation'];
                                $Lignedevis['totalht']=$f['totalht'];
                                $Lignedevis['totalttc']=$f['totalttc'];  
                                     $this->Lignedevi->create();
                                     $this->Lignedevi->save($Lignedevis);  
                                 
                              }
                             }     
				$this->Session->setFlash(__('The devi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The devi could not be saved. Please, try again.'));
			}
		}
                }
         $pv= CakeSession::read('pointdevente'); 
         if($pv!=0) {
         $numero = $this->Devi->find('all',
         array('fields' =>array('MAX(Devi.numeroconca) as num'),
          'conditions' => array('Devi.pointdevente_id'=>$pv,'Devi.exercice_id'=>date("Y")))
         );
         //debug($numero);die;
         foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {  
        
//   $getexercice= $this->Devi->find('first',array('conditions'=>array('Devi.numeroconca'=>$n)));
//   //debug($getexercice);die;
//  $anne=$getexercice['Devi']['exercice_id'];  
//  if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }  
            
       } else {
                $mm = "000001";
            }
        
                $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
                 }else{
             $mm=0;
         }
                 $articles=$this->Article->find('list', array( 'conditions' => array('Article.typeetatarticle_id'=>1),'recursive'=>-1)) ;
                $clients = $this->Devi->Client->find('list');
                $pointdeventes=$this->Pointdevente->find('list');
                $p=CakeSession::read('depot');
                if($p==0){
         	$depots = $this->Depot->find('list');
                }else{
         	$depots = $this->Depot->find('list',array('conditions'=>array('Depot.id'=>$p)));
                }
                $timbre = $this->Timbre->find('list',array('fields' => array('Timbre.timbre')));
		$this->set(compact('timbre','depots','pointdeventes','clients','mm','articles','numspecial','type'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null,$type=null) {
             //debug($type);die;
             $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='devis'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Factureclient');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Stockdepot');
            $this->loadModel('Commande');
            $this->loadModel('Pointdevente');
            $this->loadModel('Bonlivraison');
            $this->loadModel('Article');
            $this->loadModel('Lignedevi');
            $this->loadModel('Reglementclient');
		if (!$this->Devi->exists($id)) {
			throw new NotFoundException(__('Invalid devi'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    // debug($this->request->data);die;
                     $this->request->data['Devi']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Devi']['date'])));
		     $this->request->data['Devi']['utilisateur_id']= CakeSession::read('users');
                     $this->request->data['Devi']['totalttc']=$this->request->data['Devi']['totalttc']-$this->request->data['Devi']['timbre_id']; 
                     $numeros=explode('/',$this->request->data['Devi']['numero']);       
                     $this->request->data['Devi']['numeroconca']=$numeros[1];
			if ($this->Devi->save($this->request->data)) {
                              $this->Lignedevi->deleteAll(array('Lignedevi.devi_id'=>$id),false); 
                               foreach (  $this->request->data['Lignedevi'] as $f   ){  
                                 //  debug($f);die;
                              if ($f['sup']!=1){
                                $Lignedevis['devi_id']=$id;
                                $Lignedevis['article_id']=$f['article_id'];
                                $Lignedevis['depot_id']=$f['depot_id'];
                                $Lignedevis['quantite']=$f['quantite'];
                                $Lignedevis['remise']=$f['remise'];
                                $Lignedevis['tva']=$f['tva'];
                                $Lignedevis['prix']=$f['prixhtva'];
                                $Lignedevis['prixnet']=$f['prixnet'];
                                $Lignedevis['puttc']=$f['puttc'];
                                $Lignedevis['totalhtans']=$f['totalhtans'];
                                $Lignedevis['designation']=$f['designation'];
                                $Lignedevis['totalht']=$f['totalht'];
                                $Lignedevis['totalttc']=$f['totalttc'];  
                                     $this->Lignedevi->create();
                                     $this->Lignedevi->save($Lignedevis);  
                                 
                              }
                             } 
				$this->Session->setFlash(__('The devi has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The devi could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Devi.' . $this->Devi->primaryKey => $id));
			$this->request->data = $this->Devi->find('first', $options);
		}
                 $numero = $this->Devi->find('all', array('fields' =>
            array(
                'MAX(Devi.numero) as num'
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
        $lignedevis = $this->Lignedevi->find('all',array(
            'order'=>array('Lignedevi.id'=>'ASC')
            ,'conditions'=>array('Lignedevi.devi_id' => $id)));  
          //debug($lignedevis); die;
                
		$clients = $this->Devi->Client->find('list');
                 $date=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Devi']['date'])));
                  $this->loadModel('Pointdevente');
                $pointdeventes=$this->Pointdevente->find('list');
                 foreach (  $lignedevis as $ll   ){ 
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
                 //info client**************************************************
            $this->loadModel('Bonlivraison');
            $this->loadModel('Factureclient');
            $this->loadModel('Client');
             
            $facture= $this->Devi->find('first',array('conditions'=>array('Devi.id'=>$id),false));
            $clientid=$facture['Devi']['client_id'];
            $name=$facture['Devi']['name'];
            $client= $this->Client->find('all',array('conditions'=>array('Client.id'=>$clientid),false));
            $adresse=$client[0]['Client']['adresse'];
            $matriculefiscale=$client[0]['Client']['matriculefiscale'];
            $autorisation=$client[0]['Client']['autorisation'];
            $typeclient_id=$client[0]['Client']['typeclient_id'];

            $sumttc= $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalttc) as totalttcb')
                     ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,'Bonlivraison.client_id'=>$clientid)));
            $summtreg = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.Montant_Regler) as totalregb')
                     ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,'Bonlivraison.client_id'=>$clientid)));
            $sumttcf = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalttc) as totalttf')
                     , 'conditions' => array('Factureclient.id > ' => 0,'Factureclient.client_id'=>$clientid)));
            $summtregf = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.Montant_Regler) as totalregf')
                     , 'conditions' => array('Factureclient.id > ' => 0,'Factureclient.client_id'=>$clientid)));
           $reglementlibre = $this->Reglementclient->find('all', array('fields'=>array('sum(Reglementclient.Montant) as reglibretotale')
                     , 'conditions' => array('Reglementclient.type > ' => 1,'Reglementclient.affectation_id > ' => 0,'Reglementclient.client_id'=>$clientid)));
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
                 $articles=$this->Article->find('list', array( 'conditions' => array('Article.typeetatarticle_id'=>1),'recursive'=>-1)) ;
		$this->set(compact('typeclient_id','name','autorisation','solde','tabqtestock','depots','valreste','matriculefiscale','adresse','pointdeventes','clients','mm','articles','lignedevis','date','type'));
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
                if(@$liens['lien']=='devis'){
                        $x=$liens['delete'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Devi->id = $id;
		if (!$this->Devi->exists()) {
			throw new NotFoundException(__('Invalid devi'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Devi->delete()) {
			$this->Session->setFlash(__('Devi deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Devi was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
      public function  article(){
            $this->layout = null;
            $this->loadModel('Article');  
            $data = $this->request->data;//debug($data);
           $json = null;
           $articleid= $data['id'];
           
        // debug($data);
        $article= $this->Article->find('all',array('conditions'=>array('Article.id'=>$articleid),false));
        
          $tva=$article[0]['Article']['tva'];
          $prix=$article[0]['Article']['prixvente'];
          $prixachat=$article[0]['Article']['prixachat'];
         
           echo json_encode(array('tva'=>$tva,'prix'=>$prix,'prixachat'=>$prixachat));
          die();
     }  
     
     
     
     public function diplique($id = null,$td=null,$model_ans=null,$ligne_ans=null,$attr=null) {
         
            $lien=  CakeSession::read('lien_vente');
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='devis'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
                   
             $this->loadModel('Lignefactureclient');
            $this->loadModel('Factureclient');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Stockdepot');
            $this->loadModel('Commande');
            $this->loadModel('Pointdevente');
            $this->loadModel('Bonlivraison');
            $this->loadModel('Article');
            $this->loadModel('Lignedevi');
            $this->loadModel('Reglementclient');
            $this->loadModel('Typedipliquation');
            $this->loadModel('Client');
            
            
            if (isset($_GET["id"])||isset($_GET["td"])||isset($_GET["model_ans"])||isset($_GET["ligne_ans"])||isset($_GET["attr"]) ){
               $id=$_GET['id'];
               $td=$_GET['td'];
               $model_ans=$_GET['model_ans'];
               $ligne_ans=$_GET['ligne_ans'];
               $attr=$_GET['attr'];
            }
            
            
            
            
            
            
            $duplication= $this->Typedipliquation->find('first',array('conditions'=>array('Typedipliquation.id'=>$td)));                 
                     
            $model=$duplication['Typedipliquation']['name'];         
            $ligne=$duplication['Typedipliquation']['ligne'];  
            $attr_nv=$duplication['Typedipliquation']['attrb'];
            
            
            $this->loadModel($model);
            $this->loadModel($ligne);
            $this->loadModel($model_ans);
            $this->loadModel($ligne_ans);
            
            
            
            
		if ($this->request->is('post')) {
                 //debug($this->request->data);die;
    
                     $this->request->data[$model]['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data[$model]['date'])));
		     $this->request->data[$model]['utilisateur_id']= CakeSession::read('users');
                       if(empty($this->request->data[$model]['pointdevente_id'])){
                        $this->request->data[$model]['pointdevente_id']= CakeSession::read('pointdevente');
                        }                     
                     
                     $this->request->data[$model]['exercice_id']=date("Y");
                      $pv= CakeSession::read('pointdevente'); 
            if($pv==0) {
          $pv=$this->request->data[$model]['pointdevente_id'];   
         }
         $numero = $this->$model->find('all',
         array('fields' =>array('MAX('.$model.'.numeroconca) as num'),
          'conditions' => array($model.'.pointdevente_id'=>$pv,$model.'.exercice_id'=>date("Y")))
         );
        // debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {  
//   $getexercice= $this->$model->find('first',array('conditions'=>array($model.'.numeroconca'=>$n)));
//  $anne=$getexercice[$model]['exercice_id'];
//    //debug($anne);die;  
//  if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }  
            
       } else {
                $mm = "000001";
            }
            $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
                        
                        $this->request->data[$model]['numeroconca']=$mm;
                        $this->request->data[$model]['numero']=$numspecial;
                        
                        
                        if($model=="Factureclient"){
                         $this->request->data[$model]['totalttc']=$this->request->data[$model]['totalttc']+0.500;   
                        }
                        if($model_ans=="Factureclient"){
                         $this->request->data[$model]['totalttc']=$this->request->data[$model]['totalttc']-0.500;   
                        }
                        
                        
                        
                        
                        
                        
			$this->$model->create();
			 if(!empty($this->request->data[$ligne])){
			if ($this->$model->save($this->request->data)) {
                         $id=$this->$model->id;
                              $stockdepots=array(); 
                              foreach (  $this->request->data[$ligne] as $i=>$f   ){
                              if ($f['sup']!=1){
                                $Lignedevis[$attr_nv]=$id;
                                $Lignedevis['depot_id']=$f['depot_id'];
                                $Lignedevis['article_id']=$this->request->data[$ligne][$i]['article_id'];
                                $Lignedevis['quantite']=$f['quantite'];
                                $Lignedevis['remise']=$f['remise'];
                                $Lignedevis['tva']=$f['tva'];
                                $Lignedevis['prix']=$f['prixhtva'];
                                $Lignedevis['prixnet']=$f['prixnet'];
                                $Lignedevis['puttc']=$f['puttc'];
                                $Lignedevis['totalhtans']=$f['totalhtans'];
                                $Lignedevis['designation']=$f['designation'];
                                $Lignedevis['totalht']=$f['totalht'];
                                $Lignedevis['totalttc']=$f['totalttc'];  
                                     $this->$ligne->create();
                                     $this->$ligne->save($Lignedevis);  
    
                                     
                                     
    if(($model=="Factureclient")||($model=="Bonlivraison")){
    $stockdepots[$i]['quantite']=$f['quantite'];
    $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$this->request->data[$ligne][$i]['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
    if (!empty($stckdepot)){
    $stockdepots[$i]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$stockdepots[$i]['quantite'];
    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$i]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
    }
    }
                             
                                     
                                     
                                     
                                     
                                     
                                     
                                 
                              }
                             }     
				$this->Session->setFlash(__('The devi has been saved'));
				//$this->redirect(array('action' => 'index'));
                                $this->redirect(array('controller'=>$model.'s','action' => 'index'));
			} else {
				$this->Session->setFlash(__('The devi could not be saved. Please, try again.'));
			}
		}
                }
                
                
                
                
                
                
                
                
                  $pv= CakeSession::read('pointdevente'); 
         if($pv!=0) {
        $numero = $this->$model->find('all',
         array('fields' =>array('MAX('.$model.'.numeroconca) as num'),
          'conditions' => array($model.'.pointdevente_id'=>$pv,$model.'.exercice_id'=>date("Y")))
         );
         //debug($numero);die;
         foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {  
        
//  $getexercice= $this->$model->find('first',array('conditions'=>array($model.'.numeroconca'=>$n)));
//  $anne=$getexercice[$model]['exercice_id'];
//  if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }  
            
       } else {
                $mm = "000001";
            }
        
                $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pv)));
                $abrivation=$pointvente['Pointdevente']['abriviation'];
                $numspecial=$abrivation."/".$mm."/".date("Y");
                 }else{
             $mm=0;
         }

          $lignedevis = $this->$ligne_ans->find('all',array('conditions'=>array($ligne_ans.'.'.$attr => $id)));  
          //debug($lignedevis); die;
                
		$clients = $this->Client->find('list');
                $this->loadModel('Pointdevente');
                $pointdeventes=$this->Pointdevente->find('list');
                 foreach (  $lignedevis as $ll   ){ 
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
                 //info client**************************************************
            $this->loadModel('Bonlivraison');
            $this->loadModel('Factureclient');
            $this->loadModel('Client');
            $this->loadModel('Typedipliquation'); 
            
            $facture= $this->$model_ans->find('first',array('conditions'=>array($model_ans.'.id'=>$id),false));
            $clientid=$facture[$model_ans]['client_id'];
            $name=$facture[$model_ans]['name'];
            $client= $this->Client->find('all',array('conditions'=>array('Client.id'=>$clientid),false));
            $adresse=$client[0]['Client']['adresse'];
            $matriculefiscale=$client[0]['Client']['matriculefiscale'];
            $autorisation=$client[0]['Client']['autorisation'];
            $typeclient_id=$client[0]['Client']['typeclient_id'];
            
            $sumttc= $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalttc) as totalttcb')
                     ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,'Bonlivraison.client_id'=>$clientid)));
            $summtreg = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.Montant_Regler) as totalregb')
                     ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,'Bonlivraison.client_id'=>$clientid)));
            $sumttcf = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalttc) as totalttf')
                     , 'conditions' => array('Factureclient.id > ' => 0,'Factureclient.client_id'=>$clientid)));
            $summtregf = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.Montant_Regler) as totalregf')
                     , 'conditions' => array('Factureclient.id > ' => 0,'Factureclient.client_id'=>$clientid)));
            $reglementlibre = $this->Reglementclient->find('all', array('fields'=>array('sum(Reglementclient.Montant) as reglibretotale')
                     , 'conditions' => array('Reglementclient.type > ' => 1,'Reglementclient.affectation_id > ' => 0,'Reglementclient.client_id'=>$clientid)));
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
                $articles=$this->Article->find('list', array( 'conditions' => array('Article.typeetatarticle_id'=>1),'recursive'=>-1)) ;
		$typedipliquations=$this->Typedipliquation->find('list');
                $x=$model;
                $this->set(compact('typeclient_id','model_ans','ligne_ans','ligne','x','clientid','typedipliquations','name','autorisation','solde','tabqtestock','depots','valreste','matriculefiscale','adresse','pointdeventes','clients','mm','articles','lignedevis','date','type'));
	}
     
     
     
}
