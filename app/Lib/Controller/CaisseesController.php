<?php
App::uses('AppController', 'Controller');
/**
 * Caissees Controller
 *
 * @property Caissee $Caissee
 */
class CaisseesController extends AppController {


	public function index() {
          $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='caissees'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }   
       $this->loadModel('Piecereglement');       
       $this->loadModel('Piecereglementclient');
       $this->loadModel('Reglementclient');  
       $this->loadModel('Reglement');  
       $this->loadModel('Versement'); 
       $this->loadModel('Sortiecaissee'); 
       $this->Caissee->deleteAll(array('Caissee.id > ' => 0),false); 
       $caisses=array();
        if (isset($this->request->data) && !empty($this->request->data)) {
      //debug($this->request->data);die;
        if ($this->request->data['Caissee']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Caissee']['date1'])));
            $conda1 = 'Reglement.date >= '."'".$date1."'";
            $condb1 = 'Reglementclient.date >= '."'".$date1."'";
            $condc1 = 'Versement.date >= '."'".$date1."'";
            $condd1 = 'Sortiecaissee.date >= '."'".$date1."'";
        }
        $pid=1;
         
        if ($this->request->data['Caissee']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Caissee']['date2'])));
            $conda2 = 'Reglement.date <= '."'".$date2."'";
            $condb2 = 'Reglementclient.date <= '."'".$date2."'";
            $condc2 = 'Versement.date <= '."'".$date2."'";
            $condd2 = 'Sortiecaissee.date <= '."'".$date2."'";
        }
//    $reglements = $this->Reglement->find('all', array( 'conditions' => array('Reglement.id > ' => 0, @$conda1, @$conda2 ),'recursive'=>-1)); //debug($reglements);
//     $reglementid='(0,';
//            foreach ($reglements as $r){
//                $reglementid=$reglementid.$r['Reglement']['id'].',';
//              
//            }
//            $reglementid=$reglementid.'0)';
//            $conda3='Piecereglement.reglement_id in'. $reglementid;
//            $conda4 = 'Piecereglement.paiement_id = '.$pid;
//    $piecereglements = $this->Piecereglement->find('all', array( 'conditions' => array('Piecereglement.id > ' => 0, @$conda3, @$conda4))); //debug($piecereglements);
//    
    
    $reglementclients = $this->Reglementclient->find('all', array( 'conditions' => array('Reglementclient.id > ' => 0, @$condb1, @$condb2,  ),'recursive'=>-1));  
    $reglementclientid='(0,';
            foreach ($reglementclients as $rc){
                $reglementclientid=$reglementclientid.$rc['Reglementclient']['id'].',';
              
            }
            $reglementclientid=$reglementclientid.'0)';
            $condb3='Piecereglementclient.reglementclient_id in'. $reglementclientid;
            $condb4 = 'Piecereglementclient.paiement_id = '.$pid;
    $piecereglementclients = $this->Piecereglementclient->find('all', array( 'conditions' => array('Piecereglementclient.id > ' => 0, @$condb3, @$condb4 )));  //debug($piecereglementclients);
    
    
    $versements = $this->Versement->find('all', array( 'conditions' => array('Versement.id > ' => 0, @$condc1, @$condc2 ),'recursive'=>-1)); //debug($versements);
  //  $sortiecaissees = $this->Sortiecaissee->find('all', array( 'conditions' => array('Sortiecaissee.id > ' => 0, @$condd1, @$condd2  ),'recursive'=>-1)); //debug($sortiecaissees);die;
     
//        foreach (@$piecereglements as $pr) {
//            $caisses['date']=$pr['Reglement']['Date'];
//            $caisses['type']=2;
//            $caisses['raison']="Achat";
//            $caisses['montant']=$pr['Piecereglement']['montant'];
//              $this-> Caissee->create();
//              $this-> Caissee->save($caisses); 
//        }
        foreach (@$piecereglementclients as $prc) {
            $caisses['date']=$prc['Reglementclient']['Date'];
            $caisses['type']=1;
            $caisses['raison']="Vente";
            $caisses['montant']=$prc['Piecereglementclient']['montant'];
              $this-> Caissee->create();
              $this-> Caissee->save($caisses); 
        }   
        foreach (@$versements as $v) {
            $caisses['date']=$v['Versement']['date'];
            $caisses['type']=2;
            $caisses['raison']="Versement bancaire";
            $caisses['montant']=$v['Versement']['montant'];
              $this-> Caissee->create();
              $this-> Caissee->save($caisses); 
        }   
//         foreach (@$sortiecaissees as $sc) {
//            $caisses['date']=$sc['Sortiecaissee']['date'];
//            $caisses['type']=2;
//            $caisses['raison']=$sc['Sortiecaissee']['raison'];
//            $caisses['montant']=$sc['Sortiecaissee']['montant'];
//            $caisses['solde']=$sc['Sortiecaissee']['montant'];
//              $this-> Caissee->create();
//              $this-> Caissee->save($caisses); 
//        }   
    
    
            } 
        $caissees= $this->Caissee->find('all',array('conditions'=>array('Caissee.id > ' => 0),'order'=>array('Caissee.date'=>'ASC'),'recursive'=>-1));
        $solde=0;
        $this->Caissee->deleteAll(array('Caissee.id > ' => 0),false); 
        foreach ($caissees as $caisse) {
       
            if($caisse['Caissee']['type']==1){
              $solde=  $solde+$caisse['Caissee']['montant'];
              $caisse['Caissee']['solde']=$solde;}
            else{
              $solde=  $solde-$caisse['Caissee']['montant'];  
              $caisse['Caissee']['solde']=$solde;  
            }
              $this-> Caissee->create();
              $this-> Caissee->save($caisse); 
            //$this->Caissee->updateAll(array('Caissee.solde'=>$solde), array('Caissee.id' =>$caisse['Caissee']['id']));   
        }   
        $caissees= $this->Caissee->find('all',array('conditions'=>array('Caissee.id > ' => 0),'order'=>array('Caissee.date'=>'ASC'),'recursive'=>-1));
		$this->set(compact('caissees','date1','date2'));
	}
        
        public function imprimer() {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='caissees'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                if (!empty($this->request->query['date1'])){
                    $date1 = $this->request->query['date1'];
                }

                if (!empty($this->request->query['date2'])){
                    $date2 = $this->request->query['date2'];
                }
                $caissees= $this->Caissee->find('all',array('conditions'=>array('Caissee.id > ' => 0),'order'=>array('Caissee.date'=>'ASC'),'recursive'=>-1));
                //debug($caissees);die;
            $this->set(compact('date1','date2','caissees'));
	}
   
//************************************************Caisse interne *********************************

    public function interne() {
          $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='interne'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }   
       $this->loadModel('Piecereglement');       
       $this->loadModel('Piecereglementclient');
       $this->loadModel('Reglementclient');  
       $this->loadModel('Alimentation');  
       $this->loadModel('Versement'); 
       $this->loadModel('Sortiecaissee'); 
       $this->Caissee->deleteAll(array('Caissee.id > ' => 0),false); 
       $caisses=array();
        if (isset($this->request->data) && !empty($this->request->data)) {
      //debug($this->request->data);die;
        if ($this->request->data['Caissee']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Caissee']['date1'])));
            $conda1 = 'Reglement.date >= '."'".$date1."'";
            $condb1 = 'Reglementclient.date >= '."'".$date1."'";
            $condc1 = 'Versement.date >= '."'".$date1."'";
            $condd1 = 'Sortiecaissee.date >= '."'".$date1."'";
            $condd1A = 'Alimentation.date >= '."'".$date1."'";
        }
        $pid=1;
         
        if ($this->request->data['Caissee']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Caissee']['date2'])));
            $conda2 = 'Reglement.date <= '."'".$date2."'";
            $condb2 = 'Reglementclient.date <= '."'".$date2."'";
            $condc2 = 'Versement.date <= '."'".$date2."'";
            $condd2 = 'Sortiecaissee.date <= '."'".$date2."'";
            $condd2A = 'Alimentation.date <= '."'".$date2."'";
        }
//    $reglements = $this->Reglement->find('all', array( 'conditions' => array('Reglement.id > ' => 0, @$conda1, @$conda2 ),'recursive'=>-1)); //debug($reglements);
//     $reglementid='(0,';
//            foreach ($reglements as $r){
//                $reglementid=$reglementid.$r['Reglement']['id'].',';
//              
//            }
//            $reglementid=$reglementid.'0)';
//            $conda3='Piecereglement.reglement_id in'. $reglementid;
//            $conda4 = 'Piecereglement.paiement_id = '.$pid;
//    $piecereglements = $this->Piecereglement->find('all', array( 'conditions' => array('Piecereglement.id > ' => 0, @$conda3, @$conda4))); //debug($piecereglements);
//    
    
//    $reglementclients = $this->Reglementclient->find('all', array( 'conditions' => array('Reglementclient.id > ' => 0, @$condb1, @$condb2,  ),'recursive'=>-1));  
//    $reglementclientid='(0,';
//            foreach ($reglementclients as $rc){
//                $reglementclientid=$reglementclientid.$rc['Reglementclient']['id'].',';
//              
//            }
//            $reglementclientid=$reglementclientid.'0)';
//            $condb3='Piecereglementclient.reglementclient_id in'. $reglementclientid;
//            $condb4 = 'Piecereglementclient.paiement_id = '.$pid;
//    $piecereglementclients = $this->Piecereglementclient->find('all', array( 'conditions' => array('Piecereglementclient.id > ' => 0, @$condb3, @$condb4 )));  //debug($piecereglementclients);
//    
//    
   // $versements = $this->Versement->find('all', array( 'conditions' => array('Versement.id > ' => 0, @$condc1, @$condc2 ),'recursive'=>-1)); //debug($versements);
   $sortiecaissees = $this->Sortiecaissee->find('all', array( 'conditions' => array('Sortiecaissee.id > ' => 0, @$condd1, @$condd2  ),'recursive'=>-1)); //debug($sortiecaissees);die;
   $alimentations = $this->Alimentation->find('all', array( 'conditions' => array('Alimentation.id > ' => 0, @$condd1A, @$condd2A  ),'recursive'=>-1)); //debug($alimentations);die;
  
   
//        foreach (@$piecereglements as $pr) {
//            $caisses['date']=$pr['Reglement']['Date'];
//            $caisses['type']=2;
//            $caisses['raison']="Achat";
//            $caisses['montant']=$pr['Piecereglement']['montant'];
//              $this-> Caissee->create();
//              $this-> Caissee->save($caisses); 
//        }
//        foreach (@$piecereglementclients as $prc) {
//            $caisses['date']=$prc['Reglementclient']['Date'];
//            $caisses['type']=1;
//            $caisses['raison']="Vente";
//            $caisses['montant']=$prc['Piecereglementclient']['montant'];
//              $this-> Caissee->create();
//              $this-> Caissee->save($caisses); 
//        }   
//          foreach (@$versements as $v) {
//            $caisses['date']=$v['Versement']['date'];
//            $caisses['type']=2;
//            $caisses['raison']="Versement bancaire";
//            $caisses['montant']=$v['Versement']['montant'];
//              $this-> Caissee->create();
//              $this-> Caissee->save($caisses); 
//        }   
          foreach (@$alimentations as $v) {
            $caisses['date']=$v['Alimentation']['date'];
            $caisses['type']=1;
            $caisses['raison']="Alimentation Caisse";
            $caisses['montant']=$v['Alimentation']['montant'];
              $this-> Caissee->create();
              $this-> Caissee->save($caisses); 
        }
         foreach (@$sortiecaissees as $sc) {
            $caisses['date']=$sc['Sortiecaissee']['date'];
            $caisses['type']=2;
            $caisses['raison']=$sc['Sortiecaissee']['raison'];
            $caisses['montant']=$sc['Sortiecaissee']['montant'];
            $caisses['solde']=$sc['Sortiecaissee']['montant'];
              $this-> Caissee->create();
              $this-> Caissee->save($caisses); 
        }   
    
    
            } 
        $caissees= $this->Caissee->find('all',array('conditions'=>array('Caissee.id > ' => 0),'order'=>array('Caissee.date'=>'ASC'),'recursive'=>-1));
        $solde=0;
        $this->Caissee->deleteAll(array('Caissee.id > ' => 0),false); 
        foreach ($caissees as $caisse) {
       
            if($caisse['Caissee']['type']==1){
              $solde=  $solde+$caisse['Caissee']['montant'];
              $caisse['Caissee']['solde']=$solde;}
            else{
              $solde=  $solde-$caisse['Caissee']['montant'];  
              $caisse['Caissee']['solde']=$solde;  
            }
              $this-> Caissee->create();
              $this-> Caissee->save($caisse); 
            //$this->Caissee->updateAll(array('Caissee.solde'=>$solde), array('Caissee.id' =>$caisse['Caissee']['id']));   
        }   
        $caissees= $this->Caissee->find('all',array('conditions'=>array('Caissee.id > ' => 0),'order'=>array('Caissee.date'=>'ASC'),'recursive'=>-1));
		$this->set(compact('caissees','date1','date2'));
	}
        
    public function imprimerinterne() {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='interne'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                if (!empty($this->request->query['date1'])){
                    $date1 = $this->request->query['date1'];
                }

                if (!empty($this->request->query['date2'])){
                    $date2 = $this->request->query['date2'];
                }
                $caissees= $this->Caissee->find('all',array('conditions'=>array('Caissee.id > ' => 0),'order'=>array('Caissee.date'=>'ASC'),'recursive'=>-1));
                //debug($caissees);die;
            $this->set(compact('date1','date2','caissees'));
	}
        
//************************************************retenue client***************************
        public function retenue() {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='retenue'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
       $this->loadModel('Piecereglementclient');
       $this->loadModel('Reglementclient');  
       $this->loadModel('Client'); 
       $this->loadModel('Moi');  
       $this->loadModel('Factureclient');
       $retenues=array();
        if (isset($this->request->data) && !empty($this->request->data)) {
      //debug($this->request->data);die;
        $pid=5;
         if (isset($this->request->data['Caissee']['Annee'])){
            $annee =  $this->request->data['Caissee']['Annee'];
            $conditionyear='YEAR(Reglementclient.date)='."'".$annee."'";
        }
        $conditionmonth="(";
         if (isset($this->request->data['Caissee']['moi_id'])){
           foreach($this->request->data['Caissee']['moi_id'] as $moi){
               if($conditionmonth!='('){$conditionmonth=$conditionmonth.' or ';}  
            $conditionmonth=$conditionmonth.'MONTH(Reglementclient.date)='.$moi;
           }
            $moiid=  implode(",", $this->request->data['Caissee']['moi_id']) ;
        }
        $conditionmonth=$conditionmonth.')';
        //debug($conditionmonth);die;
 
    $reglementclients = $this->Reglementclient->find('all', array( 'conditions' => array('Reglementclient.id > ' => 0, @$conditionyear, @$conditionmonth,  ),'recursive'=>-1)); //debug($reglementclients);die; 
    $reglementclientid='(0,';
            foreach ($reglementclients as $rc){
                $reglementclientid=$reglementclientid.$rc['Reglementclient']['id'].',';
              
            }
            $reglementclientid=$reglementclientid.'0)';
           // debug($reglementclientid);die;
            $condb3='Piecereglementclient.reglementclient_id in'. $reglementclientid;
            $condb4 = 'Piecereglementclient.paiement_id = '.$pid;
    $piecereglementclients = $this->Piecereglementclient->find('all', array( 'conditions' => array('Piecereglementclient.id > ' => 0, @$condb3, @$condb4 ),'recursive'=>2));  //debug($piecereglementclients);
    
   
        foreach (@$piecereglementclients as $i=>$prc) {
            $retenues[$i]['date']=$prc['Reglementclient']['Date'];
            $retenues[$i]['Client']=$prc['Reglementclient']['client_id'];
            $retenues[$i]['numfactures']=$prc['Reglementclient']['Lignereglementclient'];
            $retenues[$i]['montant']=$prc['Piecereglementclient']['montant'];
        }   
     } 
       $mois = $this->Moi->find('list');
       $clients=$this->Client->find('list') ;
       $factureclients=$this->Factureclient->find('list',array('fields' => array('Factureclient.numero'))) ;
       $datefactureclients=$this->Factureclient->find('list',array('fields' => array('Factureclient.date'))) ;
     $this->set(compact('retenues','clients','factureclients','datefactureclients','date1','date2','mois','annee','moiid'));
	}
          public function imprimerretenue() {
              $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='retenue'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
               $this->loadModel('Piecereglementclient');
                $this->loadModel('Reglementclient');  
                $this->loadModel('Client'); 
                $this->loadModel('Moi');  
                $this->loadModel('Factureclient');
                $mois = $this->Moi->find('list');
                 $pid=5;
                 //debug($this->request->query['annee']);die;
                if (!empty($this->request->query['annee'])){ 
                    $annee =  $this->request->query['annee'];
                    $conditionyear='YEAR(Reglementclient.date)='."'".$annee."'";
                }
                $listmois="";
                $conditionmonth="(";
                if (isset($this->request->query['moiid'])){ $moiids=explode(",",$this->request->query['moiid']);
                  foreach($moiids as $moi){
                      if($conditionmonth!='('){$conditionmonth=$conditionmonth.' or ';}  
                   $conditionmonth=$conditionmonth.'MONTH(Reglementclient.date)='.$moi;
                  $listmois=$listmois.', '.$mois[$moi];
                  }
               }
                $conditionmonth=$conditionmonth.')';
                $reglementclients = $this->Reglementclient->find('all', array( 'conditions' => array('Reglementclient.id > ' => 0, @$conditionyear, @$conditionmonth,  ),'recursive'=>-1));  
    $reglementclientid='(0,';
            foreach ($reglementclients as $rc){
                $reglementclientid=$reglementclientid.$rc['Reglementclient']['id'].',';
              
            }
            $reglementclientid=$reglementclientid.'0)';
            $condb3='Piecereglementclient.reglementclient_id in'. $reglementclientid;
            $condb4 = 'Piecereglementclient.paiement_id = '.$pid;
    $piecereglementclients = $this->Piecereglementclient->find('all', array( 'conditions' => array('Piecereglementclient.id > ' => 0, @$condb3, @$condb4 ),'recursive'=>2));  //debug($piecereglementclients);
    
   
        foreach (@$piecereglementclients as $i=>$prc) {
            $retenues[$i]['date']=$prc['Reglementclient']['Date'];
            $retenues[$i]['Client']=$prc['Reglementclient']['client_id'];
            $retenues[$i]['numfactures']=$prc['Reglementclient']['Lignereglementclient'];
            $retenues[$i]['montant']=$prc['Piecereglementclient']['montant'];
        }   
    //debug($retenues);die;
       $moiss=$this->request->query['moiid'];
       $clients=$this->Client->find('list') ;
       $factureclients=$this->Factureclient->find('list',array('fields' => array('Factureclient.numero'))) ;
       $datefactureclients=$this->Factureclient->find('list',array('fields' => array('Factureclient.date'))) ;
       $this->set(compact('retenues','clients','factureclients','datefactureclients','date1','date2','mois','moiss','annee','listmois'));
	}
        
       //************************************************retenue fournisseur***************************
        
        public function retenuefournisseur() {
           $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='retenuefournisseur'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }     
       $this->loadModel('Piecereglement');
       $this->loadModel('Reglement');  
       $this->loadModel('Fournisseur'); 
       $this->loadModel('Moi');  
       $this->loadModel('Facture');
       $retenues=array();
        if (isset($this->request->data) && !empty($this->request->data)) {
      //debug($this->request->data);die;
        $pid=5;
         if (isset($this->request->data['Caissee']['Annee'])){
            $annee =  $this->request->data['Caissee']['Annee'];
            $conditionyear='YEAR(Reglement.date)='."'".$annee."'";
        }
        $conditionmonth="(";
         if (isset($this->request->data['Caissee']['moi_id'])){
             $moiid=  implode(",", $this->request->data['Caissee']['moi_id']) ;
           foreach($this->request->data['Caissee']['moi_id'] as $moi){
               if($conditionmonth!='('){$conditionmonth=$conditionmonth.' or ';}  
            $conditionmonth=$conditionmonth.'MONTH(Reglement.date)='.$moi;
           }
        }
        $conditionmonth=$conditionmonth.')';

    $reglements = $this->Reglement->find('all', array( 'conditions' => array('Reglement.id > ' => 0, @$conditionyear, @$conditionmonth,  ),'recursive'=>-1));  
    $reglementid='(0,';
            foreach ($reglements as $rc){
                $reglementid=$reglementid.$rc['Reglement']['id'].',';
              
            }
            $reglementid=$reglementid.'0)';
            $condb3='Piecereglement.reglement_id in'. $reglementid;
            $condb4 = 'Piecereglement.paiement_id = '.$pid;
    $piecereglements = $this->Piecereglement->find('all', array( 'conditions' => array('Piecereglement.id > ' => 0, @$condb3, @$condb4 ),'recursive'=>2));  //debug($piecereglementclients);
    
   
        foreach (@$piecereglements as $i=>$prc) {
            $retenues[$i]['date']=$prc['Reglement']['Date'];
            $retenues[$i]['Fournisseur']=$prc['Reglement']['fournisseur_id'];
            $retenues[$i]['numfactures']=$prc['Reglement']['Lignereglement'];
            $retenues[$i]['montant']=$prc['Piecereglement']['montant'];
        }   
     } 
       $mois = $this->Moi->find('list');
       $fournisseurs=$this->Fournisseur->find('list') ;
       $factures=$this->Facture->find('list',array('fields' => array('Facture.numero'))) ;
       $datefactures=$this->Facture->find('list',array('fields' => array('Facture.date'))) ;
     $this->set(compact('retenues','fournisseurs','factures','datefactures','mois','annee','moiid'));
	}
          public function imprimerretenuefournisseur() {
              $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='retenuefournisseur'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
               $this->loadModel('Piecereglement');
                $this->loadModel('Reglement');  
                $this->loadModel('Fournisseur'); 
                $this->loadModel('Moi');  
                $this->loadModel('Facture');
                $mois = $this->Moi->find('list');
                 $pid=5;
                 //debug($this->request->query['annee']);die;
                if (!empty($this->request->query['annee'])){ 
                    $annee =  $this->request->query['annee'];
                    $conditionyear='YEAR(Reglement.date)='."'".$annee."'";
                }
                $listmois="";
                $conditionmonth="(";
                if (isset($this->request->query['moiid'])){ $moiids=explode(",",$this->request->query['moiid']);
                  foreach($moiids as $moi){
                      if($conditionmonth!='('){$conditionmonth=$conditionmonth.' or ';}  
                   $conditionmonth=$conditionmonth.'MONTH(Reglement.date)='.$moi;
                  $listmois=$listmois.', '.$mois[$moi];
                  }
               }
                $conditionmonth=$conditionmonth.')';
                $reglements = $this->Reglement->find('all', array( 'conditions' => array('Reglement.id > ' => 0, @$conditionyear, @$conditionmonth,  ),'recursive'=>-1));  
    $reglementid='(0,';
            foreach ($reglements as $rc){
                $reglementid=$reglementid.$rc['Reglement']['id'].',';
              
            }
            $reglementid=$reglementid.'0)';
            $condb3='Piecereglement.reglement_id in'. $reglementid;
            $condb4 = 'Piecereglement.paiement_id = '.$pid;
    $piecereglements = $this->Piecereglement->find('all', array( 'conditions' => array('Piecereglement.id > ' => 0, @$condb3, @$condb4 ),'recursive'=>2));  //debug($piecereglementclients);
    
   
        foreach (@$piecereglements as $i=>$prc) {
            $retenues[$i]['date']=$prc['Reglement']['Date'];
            $retenues[$i]['Fournisseur']=$prc['Reglement']['fournisseur_id'];
            $retenues[$i]['numfactures']=$prc['Reglement']['Lignereglement'];
            $retenues[$i]['montant']=$prc['Piecereglement']['montant'];
        }   
    //debug($retenues);die;
       $moiss=$this->request->query['moiid'];
       $fournisseurs=$this->Fournisseur->find('list') ;
       $factures=$this->Facture->find('list',array('fields' => array('Facture.numero'))) ;
       $datefactures=$this->Facture->find('list',array('fields' => array('Facture.date'))) ;
       $this->set(compact('retenues','fournisseurs','factures','datefactures','mois','moiss','annee','listmois'));
	}
    //************************************************Etat des vente ***************************    
         public function etatvente() {
           $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatvente'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }     
       $this->loadModel('Piecereglementclient');
       $this->loadModel('Reglementclient');  
       $this->loadModel('Client'); 
       $this->loadModel('Moi');  
       $this->loadModel('Factureclient');
       $this->loadModel('Lignereglementclient');
       $this->loadModel('Paiement');
       $factureclients=array();
        if (isset($this->request->data) && !empty($this->request->data)) {
      //debug($this->request->data);die;
        $pid=5;
         if (isset($this->request->data['Caissee']['Annee'])){
            $annee =  $this->request->data['Caissee']['Annee'];
            $conditionyear='YEAR(Factureclient.date)='."'".$annee."'";
        }
        $conditionmonth="(";
         if (isset($this->request->data['Caissee']['moi_id'])){
           foreach($this->request->data['Caissee']['moi_id'] as $moi){
               if($conditionmonth!='('){$conditionmonth=$conditionmonth.' or ';}  
            $conditionmonth=$conditionmonth.'MONTH(Factureclient.date)='.$moi;
           }
            $moiid=  implode(",", $this->request->data['Caissee']['moi_id']) ;
        }
        $conditionmonth=$conditionmonth.')';
        //debug($conditionmonth);die;
 
    $factureclients = $this->Factureclient->find('all', array( 'conditions' => array('Factureclient.id > ' => 0, @$conditionyear, @$conditionmonth,  ),'recursive'=>0)); //debug($factureclients);die; 
     
            foreach ($factureclients as $fc){

               $lignereglementclients[$fc['Factureclient']['id']] = $this->Lignereglementclient->find('all', array( 'conditions' => array('Lignereglementclient.factureclient_id ='.$fc['Factureclient']['id']),'recursive'=>2)); 
            }   
     } 
       $paiements = $this->Paiement->find('list');
       $mois = $this->Moi->find('list');
       $clients=$this->Client->find('list') ;
     $this->set(compact('factureclients','clients','lignereglementclients','piecereglementclients','date1','date2','mois','annee','moiid','paiements'));
	}
          public function imprimeretatvente() {
              $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatvente'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
               $this->loadModel('Piecereglementclient');
                $this->loadModel('Reglementclient');  
                $this->loadModel('Client'); 
                $this->loadModel('Moi');  
                $this->loadModel('Factureclient');
                $this->loadModel('Paiement');
                $this->loadModel('Lignereglementclient');
                $factureclients=array();
                $mois = $this->Moi->find('list');
                 $pid=5;
                 //debug($this->request->query['annee']);die;
                if (!empty($this->request->query['annee'])){ 
                    $annee =  $this->request->query['annee'];
                    $conditionyear='YEAR(Factureclient.date)='."'".$annee."'";
                }
                $listmois="";
                $conditionmonth="(";
                if (isset($this->request->query['moiid'])){ $moiids=explode(",",$this->request->query['moiid']);
                  foreach($moiids as $moi){
                      if($conditionmonth!='('){$conditionmonth=$conditionmonth.' or ';}  
                   $conditionmonth=$conditionmonth.'MONTH(Factureclient.date)='.$moi;
                  $listmois=$listmois.', '.$mois[$moi];
                  }
               }
                $conditionmonth=$conditionmonth.')';
                 $factureclients = $this->Factureclient->find('all', array( 'conditions' => array('Factureclient.id > ' => 0, @$conditionyear, @$conditionmonth,  ),'recursive'=>0));//debug($factureclients);die; 
     
            foreach ($factureclients as $fc){

               $lignereglementclients[$fc['Factureclient']['id']] = $this->Lignereglementclient->find('all', array( 'conditions' => array('Lignereglementclient.factureclient_id ='.$fc['Factureclient']['id']),'recursive'=>2)); 
            }   
    
       $paiements = $this->Paiement->find('list');
       $moiss=$this->request->query['moiid'];
       $clients=$this->Client->find('list') ;
      // $this->set(compact('factureclients','clients','factureclients','datefactureclients','date1','date2','mois','moiss','annee','listmois','paiements'));
     $this->set(compact('factureclients','clients','lignereglementclients','piecereglementclients','date1','date2','mois','annee','listmois','paiements'));
	}
         //************************************************Etat des achat ***************************    
         public function etatachat() {
           $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatachat'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }     
       $this->loadModel('Piecereglement');
       $this->loadModel('Reglement');  
       $this->loadModel('Fournisseur'); 
       $this->loadModel('Moi');  
       $this->loadModel('Facture');
       $this->loadModel('Lignereglement');
       $this->loadModel('Paiement');
       $this->loadModel('Compte');
       $factures=array();
        if (isset($this->request->data) && !empty($this->request->data)) {
      //debug($this->request->data);die;
        $pid=5;
         if (isset($this->request->data['Caissee']['Annee'])){
            $annee =  $this->request->data['Caissee']['Annee'];
            $conditionyear='YEAR(Facture.date)='."'".$annee."'";
        }
        $conditionmonth="(";
         if (isset($this->request->data['Caissee']['moi_id'])){
           foreach($this->request->data['Caissee']['moi_id'] as $moi){
               if($conditionmonth!='('){$conditionmonth=$conditionmonth.' or ';}  
            $conditionmonth=$conditionmonth.'MONTH(Facture.date)='.$moi;
           }
            $moiid=  implode(",", $this->request->data['Caissee']['moi_id']) ;
        }
        $conditionmonth=$conditionmonth.')';
        //debug($conditionmonth);die;
 
    $factures = $this->Facture->find('all', array( 'conditions' => array('Facture.id > ' => 0, @$conditionyear, @$conditionmonth,  ),'recursive'=>0)); //debug($factureclients);die; 
     
            foreach ($factures as $f){

               $lignereglements[$f['Facture']['id']] = $this->Lignereglement->find('all', array( 'conditions' => array('Lignereglement.facture_id ='.$f['Facture']['id']),'recursive'=>2)); 
            }   
     } 
       $comptes=$this->Compte->find('list',array('fields' => array('Compte.banque'))) ;
       $paiements = $this->Paiement->find('list');
       $mois = $this->Moi->find('list');
       $fournisseurs=$this->Fournisseur->find('list') ;
     $this->set(compact('factures','fournisseurs','lignereglements','piecereglements','date1','date2','mois','annee','moiid','paiements','comptes'));
	}
          public function imprimeretatachat() {
              $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatachat'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
               $this->loadModel('Piecereglement');
                $this->loadModel('Reglement');  
                $this->loadModel('Fournisseur'); 
                $this->loadModel('Moi');  
                $this->loadModel('Facture');
                $this->loadModel('Paiement');
                $this->loadModel('Lignereglement');
                $this->loadModel('Compte');
                $factures=array();
                $mois = $this->Moi->find('list');
                 $pid=5;
                 //debug($this->request->query['annee']);die;
                if (!empty($this->request->query['annee'])){ 
                    $annee =  $this->request->query['annee'];
                    $conditionyear='YEAR(Facture.date)='."'".$annee."'";
                }
                $listmois="";
                $conditionmonth="(";
                if (isset($this->request->query['moiid'])){ $moiids=explode(",",$this->request->query['moiid']);
                  foreach($moiids as $moi){
                      if($conditionmonth!='('){$conditionmonth=$conditionmonth.' or ';}  
                   $conditionmonth=$conditionmonth.'MONTH(Facture.date)='.$moi;
                  $listmois=$listmois.', '.$mois[$moi];
                  }
               }
                $conditionmonth=$conditionmonth.')';
                 $factures = $this->Facture->find('all', array( 'conditions' => array('Facture.id > ' => 0, @$conditionyear, @$conditionmonth,  ),'recursive'=>0));//debug($factures);die; 
     
            foreach ($factures as $fc){

               $lignereglements[$fc['Facture']['id']] = $this->Lignereglement->find('all', array( 'conditions' => array('Lignereglement.facture_id ='.$fc['Facture']['id']),'recursive'=>2)); 
            }   
       $comptes=$this->Compte->find('list',array('fields' => array('Compte.banque'))) ;
       $paiements = $this->Paiement->find('list');
       $moiss=$this->request->query['moiid'];
       $fournisseurs=$this->Fournisseur->find('list') ;
     $this->set(compact('factures','fournisseurs','lignereglements','piecereglements','date1','date2','mois','annee','listmois','paiements','comptes'));
	}
        public function alimentationcaisse() {
        $lien=  CakeSession::read('lien_achat');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='reglements'){
                        $vente=$liens['add'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Carnetcheque');
            $this->loadModel('Cheque');
            $this->loadModel('Lignereglement');
            $this->loadModel('Piecereglement');
            $this->loadModel('Compte');
            $this->loadModel('Alimentation');
		if ($this->request->is('post')) {
                     debug($this->request->data);die;
                     $this->request->data['pieceregelemnt'][0]['carnetcheque_id'] ; 
                     $this->request->data['pieceregelemnt'][0]['cheque_id']; 
                     $this->request->data['pieceregelemnt'][0]['echance']= date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['pieceregelemnt'][0]['echance'] ))); 
                     $this->request->data['pieceregelemnt'][0]['montant'] ; 
                     $this->Reglement->create();
			if ($this->Reglement->save($this->request->data['pieceregelemnt'][0])) {
				$this->Session->setFlash(__('The reglement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The reglement could not be saved. Please, try again.'));
			}
		}
                $carnetcheques = $this->Carnetcheque->find('list',array('fields' => array('Carnetcheque.numero')));
                $comptess = $this->Compte->find('all');
                foreach ($comptess as $c){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                }
                $this->set(compact('carnetcheques','comptes'));
	}
}
