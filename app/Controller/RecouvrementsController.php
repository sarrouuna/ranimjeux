<?php
App::uses('AppController', 'Controller');
/**
 * Recouvrements Controller
 *
 * @property Recouvrement $Recouvrement
 */
class RecouvrementsController extends AppController {

    public function indexaaaa() {
            $lien=  CakeSession::read('lien_vente');
               $utilisateur="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='releves'){
                        $utilisateur=1;
                }}}
              if (( $utilisateur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Client');
            $this->loadModel('Exercice');
            $this->loadModel('Personnel');
            $this->loadModel('Lignefactureavoir');
            $this->loadModel('Factureclient');
            $this->loadModel('Bonlivraison');
            $this->loadModel('Reglementclient');
            $this->loadModel('Factureavoir');
            $this->loadModel('Piecereglementclient');
            $this->loadModel('Lignereglementclient');
            $this->loadModel('Pointdevente');
            $exercices = $this->Exercice->find('list');
            $exe=date('Y');
            $exercicet = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
            $exerciceid=$exercicet['Exercice']['id'];
            $condb4 = 'Bonlivraison.exercice_id ='.$exe;
            $condf4 = 'Factureclient.exercice_id ='.$exe;
            $condfa4 = 'Factureavoir.exercice_id ='.$exe;
            $condr4 = 'Reglementclient.exercice_id ='.$exe;
            $c1 = 'Recouvrement.exercice_id ='.$exe;
            $clientactif=0;
            $tablignedevis=array();
            $tablignelivraisons=array();
            $tablignefactureclients=array();
            $tablignereglementlibres=array();
            $tablignepiecereglements=array();
            $factureavoirs=array();
            $bonlivraisons=array();        
            $factureclients=array();
            $reglementlibres=array();
            $piecereglements=array();
            
             $cond6="'group'=>array('Recouvrement.client_id')";
            
            $this->Recouvrement->query('TRUNCATE recouvrements;');
            CakeSession::delete('soldeint');
            
            
        //$this->Recouvrement->deleteAll(array('Recouvrement.id >'=>0),false);
            $c5="";
            if ($this->request->is('post')) {  
                //debug($this->request->data);die;
            $this->Recouvrement->query('TRUNCATE recouvrements;');
             CakeSession::delete('soldeint');
            if($this->request->data['Recherche']['date1'] == "__/__/____"){
               $this->request->data['Recherche']['date1']='01/01/2000'; 
            } 
            if($this->request->data['Recherche']['date2'] == "__/__/____"){
               $this->request->data['Recherche']['date2']=date('d/m/Y');
            } 
            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= '."'".$date1."'";
            $condfa1 = 'Factureavoir.date >= '."'".$date1."'";
            $condr1 = 'Reglementclient.date >= '."'".$date1."'";
            $condss1='Piecereglementclient.datesituation >= '."'".$date1."'";
            $condbs = 'Bonlivraison.date < '."'".$date1."'";
            $condfs = 'Factureclient.date < '."'".$date1."'";
            $condfas = 'Factureavoir.date < '."'".$date1."'";
            $condbbs = 'Reglementclient.date < '."'".$date1."'";
            $condss='Piecereglementclient.datesituation < '."'".$date1."'";
            $c2 = 'Recouvrement.date >= '."'".$date1."'";
           
            $condb4="";
            $condf4="";
            $condfa4="";
            $condr4="";
        }
        
        if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= '."'".$date2."'";
            $condfa2 = 'Factureavoir.date <= '."'".$date2."'";
            $condr2 = 'Reglementclient.date <= '."'".$date2."'";
            $condss2='Piecereglementclient.datesituation <= '."'".$date2."'";
            
            $c3 = 'Recouvrement.date <= '."'".$date2."'";
            
            $condb4="";
            $condf4="";
            $condfa4="";
            $condr4="";
            
            
        }    
         $clientid="";           
         if ($this->request->data['Recherche']['client_id']) {
             
             $clientid='(0,';
             foreach ($this->request->data['Recherche']['client_id'] as $c){
                 $clientid=$clientid.$c.',';
             }
             $clientid=$clientid.'0)';
             //debug($clientid);die;
            //$clientid= $this->request->data['Recherche']['client_id'];
            $condb3 = 'Bonlivraison.client_id in '.$clientid;
            $condf3 = 'Factureclient.client_id in '.$clientid;
            $condfa3='Factureavoir.client_id in '.$clientid;
            $condr3 = 'Reglementclient.client_id in '.$clientid;
            $condclt = 'Client.id in '.$clientid;
        }
        if ($this->request->data['Recherche']['pointdevente_id']) {
             
            $pointdeventeid= $this->request->data['Recherche']['pointdevente_id'];
            $condb7 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf7 = 'Factureclient.pointdevente_id ='.$pointdeventeid;
            $condfa7='Factureavoir.pointdevente_id ='.$pointdeventeid;
            $condr7 = 'Reglementclient.pointdevente_id ='.$pointdeventeid;
        }
        
         
        if (!empty($this->request->data['Recherche']['personnel_id'])) {
            $personnelid = $this->request->data['Recherche']['personnel_id'];
            $clients=$this->Client->find('all',array('recursive'=>-1,'conditions'=>array('Client.personnel_id'=>$personnelid)));
            //debug($clients);die;
            $abc='0';
            foreach ($clients as $cl){
              $abc=$abc.','.$cl['Client']['id'];  
            }
            $condb5 = 'Bonlivraison.client_id in ('.$abc.')';
            $condf5 = 'Factureclient.client_id in ('.$abc.')';
            $conda5 = 'Factureavoir.client_id in ('.$abc.')';
            $condr5 = 'Reglementclient.client_id in ('.$abc.')';
        }
        
        if ($this->request->data['Recherche']['bl_id']) {
            $blid= $this->request->data['Recherche']['bl_id'];
            if($blid==0)
               $condb8 = 'Bonlivraison.id>0';
            else
               $condb8 = 'Bonlivraison.id =0';
        } 
            
            
             $factureavoirs=$this->Factureavoir->find('all', array(
            'conditions' => array('Factureavoir.inpute'=>0,'Factureavoir.totalttc>Factureavoir.montant_regle',@$condfa1,@$condfa2,@$condfa3,@$condfa4,@$conda5,@$condfa7),'recursive'=>-1 ));
        //debug($factureavoirs);die;
             if(!empty($factureavoirs)){
                 $clientactif=1;
             foreach ($factureavoirs as $factureavoir) {
                $req_client = $this->Client->find('first',array('conditions'=>array('Client.id'=>$factureavoir['Factureavoir']['client_id']),'recursive'=>-1));
                $tablignedevis['numclt']=$req_client['Client']['code'];
                $tablignedevis['client_id']=$factureavoir['Factureavoir']['client_id'];
                $tablignedevis['date']=$factureavoir['Factureavoir']['date'];
                $tablignedevis['numero']=$factureavoir['Factureavoir']['numero'];
                $tablignedevis['type']="Factureavoir";
                $tablignedevis['debit']="";
                $tablignedevis['credit']=$factureavoir['Factureavoir']['totalttc'];
                $tablignedevis['impaye']="";
                $tablignedevis['reglement']="";
                $tablignedevis['avoir']=$factureavoir['Factureavoir']['totalttc'];
                $tablignedevis['solde']=0-$factureavoir['Factureavoir']['totalttc'];
                $tablignedevis['exercice_id']=$factureavoir['Factureavoir']['exercice_id'];
                $tablignedevis['typ']="FR";
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignedevis);
             }}
            $bonlivraisons= $this->Bonlivraison->find('all', array('conditions' => array(
            'Bonlivraison.factureclient_id'=>0,'Bonlivraison.totalttc>0',@$condb1,@$condb2,@$condb3,@$condb4,@$condb5,@$condb8 ),'contain'=>array('Client'),'recursive'=>-1 ));
            if(!empty($bonlivraisons)){
                $clientactif=1;
            foreach ($bonlivraisons as $bonlivraison) {
                $req_client = $this->Client->find('first',array('conditions'=>array('Client.id'=>$bonlivraison['Bonlivraison']['client_id']),'recursive'=>-1));
                $tablignelivraisons['numclt']=$req_client['Client']['code'];
                $tablignelivraisons['client_id']=$bonlivraison['Bonlivraison']['client_id'];
                $tablignelivraisons['date']=$bonlivraison['Bonlivraison']['date'];
                $tablignelivraisons['numero']=$bonlivraison['Bonlivraison']['numero'];
                $tablignelivraisons['type']="Bonlivraison";
                $tablignelivraisons['debit']=$bonlivraison['Bonlivraison']['totalttc'];
                $tablignelivraisons['credit']="";
                $tablignelivraisons['impaye']="";
                $tablignelivraisons['reglement']=$bonlivraison['Bonlivraison']['Montant_Regler'];
                $tablignelivraisons['avoir']="";
                 $tablignelivraisons['typ']="BL";
                $tablignelivraisons['solde']=$bonlivraison['Bonlivraison']['totalttc']-$bonlivraison['Bonlivraison']['Montant_Regler'];
                $tablignelivraisons['exercice_id']=$bonlivraison['Bonlivraison']['exercice_id'];
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignelivraisons);
            }}
            $factureclients = $this->Factureclient->find('all', array('conditions' => array(
            'Factureclient.id > 0','Factureclient.totalttc >Factureclient.Montant_Regler',@$condf1,@$condf2,@$condf3,@$condf4,@$condf5,@$condf7),'recursive'=>-1));
            if(!empty($factureclients)){
                $clientactif=1;
            foreach ($factureclients as $factureclient) {
                $req_client = $this->Client->find('first',array('conditions'=>array('Client.id'=>$factureclient['Factureclient']['client_id']),'recursive'=>-1));
                $tablignefactureclients['numclt']=$req_client['Client']['code'];
                $tablignefactureclients['client_id']=$factureclient['Factureclient']['client_id'];
                $tablignefactureclients['date']=$factureclient['Factureclient']['date'];
                $tablignefactureclients['numero']=$factureclient['Factureclient']['numero'];
                $tablignefactureclients['type']="Facture ".$factureclient['Factureclient']['name'];
                $tablignefactureclients['debit']=$factureclient['Factureclient']['totalttc'];
                $tablignefactureclients['credit']="";
                $tablignefactureclients['impaye']="";
                $tablignefactureclients['reglement']=$factureclient['Factureclient']['Montant_Regler'];
                $tablignefactureclients['avoir']="";
                $tablignefactureclients['solde']=$factureclient['Factureclient']['totalttc']-$factureclient['Factureclient']['Montant_Regler'];
                $tablignefactureclients['exercice_id']=$factureclient['Factureclient']['exercice_id'];
                $tablignefactureclients['typ']="Fac";
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignefactureclients);
            }}
            
             $reglementlibres = $this->Reglementclient->find('all', array('conditions' => array(
            "Reglementclient.impute=0","Reglementclient.emi!='052'",'(Reglementclient.Montant>Reglementclient.montantaffecte)',@$condr1,@$condr2,@$condr3,@$condr4,@$condr5,@$condr7),'recursive'=>-1));
            if(!empty($reglementlibres)){
                $clientactif=1;
             foreach ($reglementlibres as $reglementlibre) {
                $req_client = $this->Client->find('first',array('conditions'=>array('Client.id'=>$reglementlibre['Reglementclient']['client_id']),'recursive'=>-1));
                $tablignereglementlibres['numclt']=$req_client['Client']['code'];
                $tablignereglementlibres['client_id']=$reglementlibre['Reglementclient']['client_id'];
                $tablignereglementlibres['date']=$reglementlibre['Reglementclient']['Date'];
                $tablignereglementlibres['numero']=$reglementlibre['Reglementclient']['numero'];
                $liste="Reg: ";
                $Piecereglementclients=$this->Piecereglementclient->find('all', array('conditions'=>array('Piecereglementclient.reglementclient_id'=>$reglementlibre['Reglementclient']['id']),'contain'=>array('Paiement'),'recursive'=>0 ));
                foreach ($Piecereglementclients as $k=>$Piece) {
                if($k==0){
                $liste=$liste."".$Piece['Paiement']['name'];
                if(!empty($Piece['Piecereglementclient']['num'])){
                $liste=$liste." : ".$Piece['Piecereglementclient']['num']."<br>";    
                }else{
                $liste=$liste."<br>";     
                }
                }else{
                $liste=$liste.$Piece['Paiement']['name'];
                if(!empty($Piece['Piecereglementclient']['num'])){
                $liste=$liste." : ".$Piece['Piecereglementclient']['num']."<br>";    
                }else{
                $liste=$liste."<br>";     
                }
                }
                }
                $tablignereglementlibres['type']=$liste;
                $tablignereglementlibres['debit']="";
                $tablignereglementlibres['credit']=$reglementlibre['Reglementclient']['Montant'];
                $tablignereglementlibres['impaye']="";
                $tablignereglementlibres['reglement']=$reglementlibre['Reglementclient']['montantaffecte'];
                $tablignereglementlibres['avoir']="";
                $tablignereglementlibres['solde']=$reglementlibre['Reglementclient']['montantaffecte']-$reglementlibre['Reglementclient']['Montant'];
                $tablignereglementlibres['exercice_id']=$reglementlibre['Reglementclient']['exercice_id'];
                $tablignereglementlibres['typ']="Reg";
                if($reglementlibre['Reglementclient']['emi']!='052'){
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignereglementlibres);
                }
                
                
                
            }} 
            
            $piecereglements = $this->Piecereglementclient->find('all', array('conditions' => array(
            'Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.situation="Impayé"','Piecereglementclient.montant>Piecereglementclient.mantantregler',@$condr1,@$condr3,@$condr4,@$condr5,@$condr7),'contain'=>array('Paiement','Reglementclient'),'recursive'=>0));   
            //debug($piecereglements);
            if(!empty($piecereglements)){
            $clientactif=1;    
            foreach ($piecereglements as $piecereglement) {
                $req_client = $this->Client->find('first',array('conditions'=>array('Client.id'=>$piecereglement['Reglementclient']['client_id']),'recursive'=>-1));
                $tablignepiecereglements['numclt']=$req_client['Client']['code'];
                $tablignepiecereglements['client_id']=$piecereglement['Reglementclient']['client_id'];
                $tablignepiecereglements['date']=$piecereglement['Piecereglementclient']['datesituation'];
                $tablignepiecereglements['numero']=$piecereglement['Reglementclient']['numero'];
                $tablignepiecereglements['type']=$piecereglement['Paiement']['name'].' : '.$piecereglement['Piecereglementclient']['num'];
                $tablignepiecereglements['debit']=$piecereglement['Piecereglementclient']['montant'];
                $tablignepiecereglements['credit']="";
                $tablignepiecereglements['impaye']=$piecereglement['Piecereglementclient']['montant'];
                $tablignepiecereglements['reglement']=$piecereglement['Piecereglementclient']['mantantregler'];
                $tablignepiecereglements['avoir']="";
                $tablignepiecereglements['solde']=$piecereglement['Piecereglementclient']['montant']-$piecereglement['Piecereglementclient']['mantantregler'];
                $tablignepiecereglements['exercice_id']=$piecereglement['Reglementclient']['exercice_id'];
                $tablignepiecereglements['typ']="Reg";
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignepiecereglements);
            }}
//        if($clientactif==1){
//                $tablignedevis['client_id']=$clientid;
//                $tablignedevis['date']="";
//                $tablignedevis['numero']="";
//                $tablignedevis['type']="Solde Départ";
//                $tablignedevis['debit']="";
//                $tablignedevis['credit']="";
//                $tablignedevis['impaye']="";
//                $tablignedevis['reglement']="";
//                $tablignedevis['avoir']="";
//                $tablignedevis['solde']=$solde;
//                $tablignedevis['exercice_id']="";
//                $tablignedevis['typ']="";
//                $this->Recouvrement->create();
//                $this->Recouvrement->save($tablignedevis);    
//        }    
            
            
            
        }      
        
     $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.societe'=>$composantsoc)
        ));
     $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
    $relefes=$this->Recouvrement->find('all', array($cond6,'order'=>array('Recouvrement.numclt'=>'asc','Recouvrement.date'=>'asc'),
     'recursive'=>0 ));
     //debug($relefes);
//     if(!empty($clientid)){
//     $client=$this->Client->find('first', array('conditions' => array('Client.id'=>$clientid),'recursive'=>0 ));
//     $soldeint=$client['Client']['solde']+$solde;
//     CakeSession::write('soldeint',$soldeint);
//     }
     $personnels = $this->Personnel->find('list');
        $bls['0']='Avec BL';
        $bls['1']='Sans BL ';
        $this->set(compact('personnels','bls','condfas','condbs','condfs','condbbs','condbbs','relefes','soldeint','solde','clientid','c5','c4','c3','c2','c1','piecereglements','factureavoirs','bonlivraisons','factureclients','reglementlibres','articles','clients','pointdeventes','exercices','exerciceid','date1','clientid','marque_id','date2','name'));
    
   }  
   
   
   public function index($client_id=null) {
            $lien=  CakeSession::read('lien_vente');
               $utilisateur="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='releves'){
                        $utilisateur=1;
                }}}
              if (( $utilisateur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Client');
            $this->loadModel('Exercice');
            $this->loadModel('Personnel');
            $this->loadModel('Lignefactureavoir');
            $this->loadModel('Factureclient');
            $this->loadModel('Bonlivraison');
            $this->loadModel('Reglementclient');
            $this->loadModel('Factureavoir');
            $this->loadModel('Piecereglementclient');
            $this->loadModel('Lignereglementclient');
            $this->loadModel('Pointdevente');
            $exercices = $this->Exercice->find('list');
            $exe=date('Y');
            $exercicet = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
            $exerciceid=$exercicet['Exercice']['id'];
            $condb4 = 'Bonlivraison.exercice_id ='.$exe;
            $condf4 = 'Factureclient.exercice_id ='.$exe;
            $condfa4 = 'Factureavoir.exercice_id ='.$exe;
            $condr4 = 'Reglementclient.exercice_id ='.$exe;
            $c1 = 'Recouvrement.exercice_id ='.$exe;
            $clientactif=0;
            $tablignedevis=array();
            $tablignelivraisons=array();
            $tablignefactureclients=array();
            $tablignereglementlibres=array();
            $tablignepiecereglements=array();
            $factureavoirs=array();
            $bonlivraisons=array();        
            $factureclients=array();
            $reglementlibres=array();
            $piecereglements=array();
            
             $cond6="'group'=>array('Recouvrement.client_id')";
            
            $this->Recouvrement->query('TRUNCATE recouvrements;');
            CakeSession::delete('soldeint');
            
            
        //$this->Recouvrement->deleteAll(array('Recouvrement.id >'=>0),false);
            $c5="";
            if (($this->request->is('post'))||($client_id !="")){ 
            //debug($this->request->data);   
            if($this->request->is('get')) {
            if (!empty($client_id)) {
            $tab[0]= $client_id;  //par ce que on a une select multiple qui retourne un array 
            $this->request->data['Recherche']['date1']="01/01/2000";
            $this->request->data['Recherche']['date2']="__/__/____";
            $this->request->data['Recherche']['client_id']=$tab;
            $this->request->data['Recherche']['pointdevente_id']="";
            $this->request->data['Recherche']['personnel_id']="";
            $this->request->data['Recherche']['bl_id']="";
            }}     
                //debug($this->request->data);die;
            $this->Recouvrement->query('TRUNCATE recouvrements;');
             CakeSession::delete('soldeint');
            if($this->request->data['Recherche']['date1'] == "__/__/____"){
               $this->request->data['Recherche']['date1']='01/01/2000'; 
            } 
            if($this->request->data['Recherche']['date2'] == "__/__/____"){
               $this->request->data['Recherche']['date2']=date('d/m/Y');
            } 
            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= '."'".$date1."'";
            $condfa1 = 'Factureavoir.date >= '."'".$date1."'";
            $condr1 = 'Reglementclient.date >= '."'".$date1."'";
            $condss1='Piecereglementclient.datesituation >= '."'".$date1."'";
            $condbs = 'Bonlivraison.date < '."'".$date1."'";
            $condfs = 'Factureclient.date < '."'".$date1."'";
            $condfas = 'Factureavoir.date < '."'".$date1."'";
            $condbbs = 'Reglementclient.date < '."'".$date1."'";
            $condss='Piecereglementclient.datesituation < '."'".$date1."'";
            $c2 = 'Recouvrement.date >= '."'".$date1."'";
           
            $condb4="";
            $condf4="";
            $condfa4="";
            $condr4="";
        }
        
        if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= '."'".$date2."'";
            $condfa2 = 'Factureavoir.date <= '."'".$date2."'";
            $condr2 = 'Reglementclient.date <= '."'".$date2."'";
            $condss2='Piecereglementclient.datesituation <= '."'".$date2."'";
            
            $c3 = 'Recouvrement.date <= '."'".$date2."'";
            
            $condb4="";
            $condf4="";
            $condfa4="";
            $condr4="";
            
            
        }    
         $clientid="";           
         if ($this->request->data['Recherche']['client_id']) {
             
             $clientid='(0,';
             foreach ($this->request->data['Recherche']['client_id'] as $c){
                 $clientid=$clientid.$c.',';
             }
             $clientid=$clientid.'0)';
             //debug($clientid);die;
            //$clientid= $this->request->data['Recherche']['client_id'];
            $condb3 = 'Bonlivraison.client_id in '.$clientid;
            $condf3 = 'Factureclient.client_id in '.$clientid;
            $condfa3='Factureavoir.client_id in '.$clientid;
            $condr3 = 'Reglementclient.client_id in '.$clientid;
            $condclt = 'Client.id in '.$clientid;
        }
        if ($this->request->data['Recherche']['pointdevente_id']) {
             
            $pointdeventeid= $this->request->data['Recherche']['pointdevente_id'];
            $condb7 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf7 = 'Factureclient.pointdevente_id ='.$pointdeventeid;
            $condfa7='Factureavoir.pointdevente_id ='.$pointdeventeid;
            $condr7 = 'Reglementclient.pointdevente_id ='.$pointdeventeid;
        }
        
         
        if (!empty($this->request->data['Recherche']['personnel_id'])) {
            $personnelid = $this->request->data['Recherche']['personnel_id'];
            $clients=$this->Client->find('all',array('recursive'=>-1,'conditions'=>array('Client.personnel_id'=>$personnelid)));
            //debug($clients);die;
            $abc='0';
            foreach ($clients as $cl){
              $abc=$abc.','.$cl['Client']['id'];  
            }
            $condb5 = 'Bonlivraison.client_id in ('.$abc.')';
            $condf5 = 'Factureclient.client_id in ('.$abc.')';
            $conda5 = 'Factureavoir.client_id in ('.$abc.')';
            $condr5 = 'Reglementclient.client_id in ('.$abc.')';
        }
        
        if ($this->request->data['Recherche']['bl_id']) {
            $blid= $this->request->data['Recherche']['bl_id'];
            if($blid==0)
               $condb8 = 'Bonlivraison.id>0';
            else
               $condb8 = 'Bonlivraison.id =0';
        } 
            
            
             $factureavoirs=$this->Factureavoir->find('all', array(
            'conditions' => array('Factureavoir.totalttc>Factureavoir.montant_regle',@$condfa1,@$condfa2,@$condfa3,@$condfa4,@$conda5,@$condfa7),'recursive'=>-1 ));
        //debug($factureavoirs);die;
             if(!empty($factureavoirs)){
                 $clientactif=1;
             foreach ($factureavoirs as $factureavoir) {
                $req_client = $this->Client->find('first',array('conditions'=>array('Client.id'=>$factureavoir['Factureavoir']['client_id']),'recursive'=>-1));
                $tablignedevis['numclt']=$req_client['Client']['code'];
                $tablignedevis['client_id']=$factureavoir['Factureavoir']['client_id'];
                $tablignedevis['date']=$factureavoir['Factureavoir']['date'];
                if ($factureavoir['Factureavoir']['typefacture_id'] == 2) {
                $tablignedevis['numero']='<a TARGET=_BLANK class="" href="'.$this->webroot.'Factureavoirs/edit/'.$factureavoir['Factureavoir']['id'].'">'.$factureavoir['Factureavoir']['numero'].'</a>';    
                }
                if ($factureavoir['Factureavoir']['source'] == "libre") {
                $tablignedevis['numero']='<a TARGET=_BLANK class="" href="'.$this->webroot.'Factureavoirs/editlibre/'.$factureavoir['Factureavoir']['id'].'">'.$factureavoir['Factureavoir']['numero'].'</a>';    
                }
                
                if ($factureavoir['Factureavoir']['typefacture_id'] == 1) {
                $tablignedevis['type']='<a onClick="flvFPW1(wr+`Factureavoirs/imprimerfavr/`+'.$factureavoir['Factureavoir']['id'].',`UPLOAD`,`width=800,height=1150,scrollbars=yes`,0,2,2);return document.MM_returnValue" href="javascript:;" ><strong>Factureavoir N°     :'.$factureavoir['Factureavoir']['numero'].'</strong></a>';
                }else{
                $tablignedevis['type']='<a onClick="flvFPW1(wr+`Factureavoirs/imprimerfavf/`+'.$factureavoir['Factureavoir']['id'].',`UPLOAD`,`width=800,height=1150,scrollbars=yes`,0,2,2);return document.MM_returnValue" href="javascript:;" ><strong>Factureavoir N°     :'.$factureavoir['Factureavoir']['numero'].'</strong></a>';
                }
                $tablignedevis['debit']="";
                $tablignedevis['credit']=$factureavoir['Factureavoir']['totalttc'];
                $tablignedevis['impaye']="";
                $tablignedevis['reglement']=$factureavoir['Factureavoir']['montant_regle'];
                $tablignedevis['avoir']="";
                $tablignedevis['solde']=($factureavoir['Factureavoir']['totalttc']-$factureavoir['Factureavoir']['montant_regle'])*(-1);
                $tablignedevis['exercice_id']=$factureavoir['Factureavoir']['exercice_id'];
                $tablignedevis['typ']="FR";
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignedevis);
             }}
            $bonlivraisons= $this->Bonlivraison->find('all', array('conditions' => array(
            'Bonlivraison.factureclient_id'=>0,'Bonlivraison.sortie'=>0,'Bonlivraison.totalttc>0',@$condb1,@$condb2,@$condb3,@$condb4,@$condb5,@$condb8 ),'contain'=>array('Client'),'recursive'=>-1 ));
            if(!empty($bonlivraisons)){
                $clientactif=1;
            foreach ($bonlivraisons as $bonlivraison) {
                $req_client = $this->Client->find('first',array('conditions'=>array('Client.id'=>$bonlivraison['Bonlivraison']['client_id']),'recursive'=>-1));
                $tablignelivraisons['numclt']=$req_client['Client']['code'];
                $tablignelivraisons['client_id']=$bonlivraison['Bonlivraison']['client_id'];
                $tablignelivraisons['date']=$bonlivraison['Bonlivraison']['date'];
                $tablignelivraisons['numero']='<a TARGET=_BLANK class="" href="'.$this->webroot.'Factureclients/edit/'.$bonlivraison['Bonlivraison']['id'].'/Bonlivraison/Lignelivraison/bonlivraison_id">'.$bonlivraison['Bonlivraison']['numero'].'</a>';
                $tablignelivraisons['type']='<a onClick="flvFPW1(wr+`Factureclients/imprimer/`+'.$bonlivraison['Bonlivraison']['id'].'+`/'.urlencode(Appcontroller::encrypt_decrypt("Bonlivraison")).'/'.urlencode(Appcontroller::encrypt_decrypt("Lignelivraison")).'/'.urlencode(Appcontroller::encrypt_decrypt("bonlivraison_id")).'/'.urlencode(Appcontroller::encrypt_decrypt("bonlivraisons")).'/'.urlencode(Appcontroller::encrypt_decrypt("Bon livraison")).'`,`UPLOAD`,`width=800,height=1150,scrollbars=yes`,0,2,2);return document.MM_returnValue" href="javascript:;" ><strong>Bon de livraison     :'.$bonlivraison['Bonlivraison']['name'].'</strong></a>';                              
                $tablignelivraisons['debit']=$bonlivraison['Bonlivraison']['totalttc'];
                $tablignelivraisons['credit']="";
                $tablignelivraisons['impaye']="";
                $tablignelivraisons['reglement']=$bonlivraison['Bonlivraison']['Montant_Regler'];
                $tablignelivraisons['avoir']="";
                 $tablignelivraisons['typ']="BL";
                $tablignelivraisons['solde']=$bonlivraison['Bonlivraison']['totalttc']-$bonlivraison['Bonlivraison']['Montant_Regler'];
                $tablignelivraisons['exercice_id']=$bonlivraison['Bonlivraison']['exercice_id'];
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignelivraisons);
            }}
            $factureclients = $this->Factureclient->find('all', array('conditions' => array(
            'Factureclient.id > 0','Factureclient.totalttc >Factureclient.Montant_Regler',@$condf1,@$condf2,@$condf3,@$condf4,@$condf5,@$condf7),'recursive'=>-1));
            if(!empty($factureclients)){
                $clientactif=1;
            foreach ($factureclients as $factureclient) {
                $nom="";$imp="";
                 if($factureclient['Factureclient']['source']=="bl"){
                  $nom="Facture";   
                  $imp="imprimerbl";
                 }
                 if($factureclient['Factureclient']['source']=="fac"){
                  $nom="BlFacture";
                  $imp="imprimer";
                 }
                $req_client = $this->Client->find('first',array('conditions'=>array('Client.id'=>$factureclient['Factureclient']['client_id']),'recursive'=>-1));
                $tablignefactureclients['numclt']=$req_client['Client']['code'];
                $tablignefactureclients['client_id']=$factureclient['Factureclient']['client_id'];
                $tablignefactureclients['date']=$factureclient['Factureclient']['date'];
                $tablignefactureclients['numero']='<a TARGET=_BLANK class="" href="'.$this->webroot.'Factureclients/edit/'.$factureclient['Factureclient']['id'].'/Factureclient/Lignefactureclient/factureclient_id">'.$factureclient['Factureclient']['numero'].'</a>';
                $tablignefactureclients['type']='<a onClick="flvFPW1(wr+`Factureclients/'.$imp.'/`+'.$factureclient['Factureclient']['id'].'+`/'.urlencode(Appcontroller::encrypt_decrypt("Factureclient")).'/'.urlencode(Appcontroller::encrypt_decrypt("Lignefactureclient")).'/'.urlencode(Appcontroller::encrypt_decrypt("factureclient_id")).'/'.urlencode(Appcontroller::encrypt_decrypt("factureclients")).'/'.urlencode(Appcontroller::encrypt_decrypt("Facture")).'`,`UPLOAD`,`width=800,height=1150,scrollbars=yes`,0,2,2);return document.MM_returnValue" href="javascript:;" ><strong>'.$nom.'     :'.$factureclient['Factureclient']['name'].'</strong></a>';                              
                $tablignefactureclients['debit']=$factureclient['Factureclient']['totalttc'];
                $tablignefactureclients['credit']="";
                $tablignefactureclients['impaye']="";
                $tablignefactureclients['reglement']=$factureclient['Factureclient']['Montant_Regler'];
                $tablignefactureclients['avoir']="";
                $tablignefactureclients['solde']=$factureclient['Factureclient']['totalttc']-$factureclient['Factureclient']['Montant_Regler'];
                $tablignefactureclients['exercice_id']=$factureclient['Factureclient']['exercice_id'];
                $tablignefactureclients['typ']="Fac";
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignefactureclients);
            }}
            
             $reglementlibres = $this->Reglementclient->find('all', array('conditions' => array(
            "Reglementclient.impute=0","Reglementclient.emi!='052'",'(Reglementclient.Montant>Reglementclient.montantaffecte)',@$condr1,@$condr2,@$condr3,@$condr4,@$condr5,@$condr7),'recursive'=>-1));
            if(!empty($reglementlibres)){
                $clientactif=1;
             foreach ($reglementlibres as $reglementlibre) {
                $req_client = $this->Client->find('first',array('conditions'=>array('Client.id'=>$reglementlibre['Reglementclient']['client_id']),'recursive'=>-1));
                $tablignereglementlibres['numclt']=$req_client['Client']['code'];
                $tablignereglementlibres['client_id']=$reglementlibre['Reglementclient']['client_id'];
                $tablignereglementlibres['date']=$reglementlibre['Reglementclient']['Date'];
                $tablignereglementlibres['numero']='<a TARGET=_BLANK class="" href="'.$this->webroot.'Reglementclients/edit/'.$reglementlibre['Reglementclient']['id'].'">'.$reglementlibre['Reglementclient']['numero'].'</a>';
                $liste="Reg: ";
                $Piecereglementclients=$this->Piecereglementclient->find('all', array('conditions'=>array('Piecereglementclient.reglementclient_id'=>$reglementlibre['Reglementclient']['id']),'contain'=>array('Paiement'),'recursive'=>0 ));
                $liste="<table width='100%' >";
                foreach ($Piecereglementclients as $k=>$Piece) {
//                if($k==0){
//                $liste=$liste."".$Piece['Paiement']['name'];
//                if(!empty($Piece['Piecereglementclient']['num'])){
//                $liste=$liste." : ".$Piece['Piecereglementclient']['num']."<br>";    
//                }else{
//                $liste=$liste."<br>";     
//                }
//                }else{
//                $liste=$liste.$Piece['Paiement']['name'];
//                if(!empty($Piece['Piecereglementclient']['num'])){
//                $liste=$liste." : ".$Piece['Piecereglementclient']['num']."<br>";    
//                }else{
//                $liste=$liste."<br>";     
//                }
//                }
                $liste=$liste."<tr>";
                $liste=$liste."<td><strong>".@$Piece['Paiement']['name']."</strong></td>";
                if(empty($Piece['Piecereglementclient']['num'])){
                $Piece['Piecereglementclient']['num']="" ;   
                }
                $liste=$liste."<td><strong>".@$Piece['Piecereglementclient']['num']."</strong></td>";
                if((!empty($Piece['Piecereglementclient']['echance']))&&($Piece['Piecereglementclient']['echance']!="1970-01-01")){
                $Piece['Piecereglementclient']['echance']=date("d/m/Y",strtotime(str_replace('/','-',@$Piece['Piecereglementclient']['echance'])));    
                }else{
                $Piece['Piecereglementclient']['echance']="";    
                }
                $liste=$liste."<td><strong>".@$Piece['Piecereglementclient']['echance']."</strong></td>";
                $liste=$liste."<td><strong> ====> ".@$Piece['Piecereglementclient']['montant']."</strong></td>";
                $liste=$liste."</tr>";    
                }
                $liste.="</table>";
                $tablignereglementlibres['type']=$liste;
                $tablignereglementlibres['debit']="";
                $tablignereglementlibres['credit']=$reglementlibre['Reglementclient']['Montant'];
                $tablignereglementlibres['impaye']="";
                $tablignereglementlibres['reglement']=$reglementlibre['Reglementclient']['montantaffecte'];
                $tablignereglementlibres['avoir']="";
                $tablignereglementlibres['solde']=$reglementlibre['Reglementclient']['montantaffecte']-$reglementlibre['Reglementclient']['Montant'];
                $tablignereglementlibres['exercice_id']=$reglementlibre['Reglementclient']['exercice_id'];
                $tablignereglementlibres['typ']="Reg";
                if($reglementlibre['Reglementclient']['emi']!='052'){
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignereglementlibres);
                }
                
                
                
            }} 
            
            $piecereglements = $this->Piecereglementclient->find('all', array('conditions' => array(
            'Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.situation="Impayé"','Piecereglementclient.montant>Piecereglementclient.mantantregler',@$condr1,@$condss2,@$condr3,@$condr4,@$condr5,$condss1,@$condr7),'contain'=>array('Paiement','Reglementclient'),'recursive'=>0));   
            //debug($piecereglements);
            if(!empty($piecereglements)){
            $clientactif=1;    
            foreach ($piecereglements as $piecereglement) {
                $req_client = $this->Client->find('first',array('conditions'=>array('Client.id'=>$piecereglement['Reglementclient']['client_id']),'recursive'=>-1));
                $tablignepiecereglements['numclt']=$req_client['Client']['code'];
                $tablignepiecereglements['client_id']=$piecereglement['Reglementclient']['client_id'];
                $tablignepiecereglements['date']=$piecereglement['Piecereglementclient']['datesituation'];
                $tablignepiecereglements['numero']=$piecereglement['Reglementclient']['numero'];
                $tablignepiecereglements['type']=$piecereglement['Paiement']['name'].' : '.$piecereglement['Piecereglementclient']['num'];
                $tablignepiecereglements['debit']=$piecereglement['Piecereglementclient']['montant'];
                $tablignepiecereglements['credit']="";
                $tablignepiecereglements['impaye']=$piecereglement['Piecereglementclient']['montant'];
                $tablignepiecereglements['reglement']=$piecereglement['Piecereglementclient']['mantantregler'];
                $tablignepiecereglements['avoir']="";
                $tablignepiecereglements['solde']=$piecereglement['Piecereglementclient']['montant']-$piecereglement['Piecereglementclient']['mantantregler'];
                $tablignepiecereglements['exercice_id']=$piecereglement['Reglementclient']['exercice_id'];
                $tablignepiecereglements['typ']="Reg";
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignepiecereglements);
            }}
//        if($clientactif==1){
//                $tablignedevis['client_id']=$clientid;
//                $tablignedevis['date']="";
//                $tablignedevis['numero']="";
//                $tablignedevis['type']="Solde Départ";
//                $tablignedevis['debit']="";
//                $tablignedevis['credit']="";
//                $tablignedevis['impaye']="";
//                $tablignedevis['reglement']="";
//                $tablignedevis['avoir']="";
//                $tablignedevis['solde']=$solde;
//                $tablignedevis['exercice_id']="";
//                $tablignedevis['typ']="";
//                $this->Recouvrement->create();
//                $this->Recouvrement->save($tablignedevis);    
//        }    
            
            
            
        }      
        
     $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.societe'=>$composantsoc)
        ));
     $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
    $relefes=$this->Recouvrement->find('all', array($cond6,'order'=>array('Recouvrement.numclt'=>'asc','Recouvrement.date'=>'asc'),
     'recursive'=>0 ));
     //debug($relefes);
//     if(!empty($clientid)){
//     $client=$this->Client->find('first', array('conditions' => array('Client.id'=>$clientid),'recursive'=>0 ));
//     $soldeint=$client['Client']['solde']+$solde;
//     CakeSession::write('soldeint',$soldeint);
//     }
     $personnels = $this->Personnel->find('list');
        $bls['0']='Avec BL';
        $bls['1']='Sans BL ';
        $this->set(compact('personnels','bls','condfas','condbs','condfs','condbbs','condbbs','relefes','soldeint','solde','clientid','c5','c4','c3','c2','c1','piecereglements','factureavoirs','bonlivraisons','factureclients','reglementlibres','articles','clients','pointdeventes','exercices','exerciceid','date1','clientid','marque_id','date2','name'));
    
   } 
   
   
   public function imprimerrecherche() {
        $lien=  CakeSession::read('lien_vente');
               $utilisateur="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='releves'){
                        $utilisateur=$liens['imprimer'];
                }}}
              if (( $utilisateur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   $this->layout = null;
        $cond6="'group'=>array('Recouvrement.client_id')";           
                   
                   
                   
       if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
           
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
           
        }
        
       if ($this->request->query['name']) {
            $name = $this->request->query['name'];
            
        } 
        $relefes=$this->Recouvrement->find('all', array(@$cond6,'order'=>array('Recouvrement.numclt'=>'asc','Recouvrement.date'=>'asc'),
     'recursive'=>0 ));
        $soldeint=CakeSession::read('soldeint');
        //debug($relefes);
        $this->set(compact('relefes','date1','date2','name','soldeint'));
    }
    
    public function imprimerrecherche_html() {
        $lien=  CakeSession::read('lien_vente');
               $utilisateur="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='releves'){
                        $utilisateur=$liens['imprimer'];
                }}}
              if (( $utilisateur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
        //$this->response->type('pdf');
        $this->layout = '';
        $cond6="'group'=>array('Recouvrement.client_id')";           
                   
                   
                   
       if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
           
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
           
        }
        
       if ($this->request->query['name']) {
            $name = $this->request->query['name'];
            
        } 
        $relefes=$this->Recouvrement->find('all', array(@$cond6,'order'=>array('Recouvrement.numclt'=>'asc','Recouvrement.date'=>'asc'),
     'recursive'=>0 ));
        $soldeint=CakeSession::read('soldeint');
        //debug($relefes);
        $this->set(compact('relefes','date1','date2','name','soldeint'));
    }
	
		
		
	public function indexfrs() {
            $lien=  CakeSession::read('lien_achat');
               $utilisateur="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='relevefournisseurs'){
                        $utilisateur=1;
                }}}
              if (( $utilisateur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Fournisseur');
            $this->loadModel('Fournisseur');
            $this->loadModel('Exercice');
            $this->loadModel('Personnel');
            $this->loadModel('Lignefactureavoir');
            $this->loadModel('Facture');
            $this->loadModel('Bonreception');
             $this->loadModel('Fournisseur');
            $this->loadModel('Reglement');
            $this->loadModel('Factureavoirfr');
            $this->loadModel('Piecereglement');
            $this->loadModel('Lignereglement');
            $this->loadModel('Societe');
            $this->loadModel('Pointdevente');
            $this->loadModel('Transfert');
            $exercices = $this->Exercice->find('list');
            $exe=date('Y');
            $exercicet = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
            $exerciceid=$exercicet['Exercice']['id'];
            $condb4 = 'Bonreception.exercice_id ='.$exe;
            $condf4 = 'Facture.exercice_id ='.$exe;
            $condfa4 = 'Factureavoirfr.exercice_id ='.$exe;
            $condr4 = 'Reglement.exercice_id ='.$exe;
            $c1 = 'Recouvrement.exercice_id ='.$exe;
            $clientactif=0;
            $tablignedevis=array();
            $tablignelivraisons=array();
            $tablignefactureclients=array();
            $tablignereglementlibres=array();
            $tablignepiecereglements=array();
            $factureavoirs=array();
            $bonlivraisons=array();        
            $factureclients=array();
            $reglementlibres=array();
            $piecereglements=array();
            
             $cond6="'group'=>array('Recouvrement.fournisseur_id')";
            
            $this->Recouvrement->query('TRUNCATE recouvrements;');
            CakeSession::delete('soldeint');
            
            
        //$this->Recouvrement->deleteAll(array('Recouvrement.id >'=>0),false);
            $c5="";
            if ($this->request->is('post')) {  
                //debug($this->request->data);die;
            $this->Recouvrement->query('TRUNCATE recouvrements;');
             CakeSession::delete('soldeint');
            if($this->request->data['Recherche']['date1'] == "__/__/____"){
               $this->request->data['Recherche']['date1']='01/01/2000'; 
            } 
            if($this->request->data['Recherche']['date2'] == "__/__/____"){
               $this->request->data['Recherche']['date2']=date('d/m/Y');
            } 
            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            $condb1 = 'Bonreception.date >= '."'".$date1."'";
            $condf1 = 'Facture.date >= '."'".$date1."'";
            $condfa1 = 'Factureavoirfr.date >= '."'".$date1."'";
            $condr1 = 'Reglement.date >= '."'".$date1."'";
            $condss1='Piecereglement.datesituation >= '."'".$date1."'";
            $condbs = 'Bonreception.date < '."'".$date1."'";
            $condfs = 'Facture.date < '."'".$date1."'";
            $condfas = 'Factureavoirfr.date < '."'".$date1."'";
            $condbbs = 'Reglement.date < '."'".$date1."'";
            $condss='Piecereglement.datesituation < '."'".$date1."'";
            $c2 = 'Recouvrement.date >= '."'".$date1."'";
           
            $condb4="";
            $condf4="";
            $condfa4="";
            $condr4="";
        }
        
        if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
            $condb2 = 'Bonreception.date <= '."'".$date2."'";
            $condf2 = 'Facture.date <= '."'".$date2."'";
            $condfa2 = 'Factureavoirfr.date <= '."'".$date2."'";
            $condr2 = 'Reglement.date <= '."'".$date2."'";
            $condss2='Piecereglement.datesituation <= '."'".$date2."'";
            
            $c3 = 'Recouvrement.date <= '."'".$date2."'";
            
            $condb4="";
            $condf4="";
            $condfa4="";
            $condr4="";
            
            
        }    
         $clientid="";           
         if ($this->request->data['Recherche']['fournisseur_id']) {
             
             $clientid='(0,';
             foreach ($this->request->data['Recherche']['fournisseur_id'] as $c){
                 $clientid=$clientid.$c.',';
             }
             $clientid=$clientid.'0)';
             //debug($clientid);die;
            //$clientid= $this->request->data['Recherche']['fournisseur_id'];
            $condb3 = 'Bonreception.fournisseur_id in '.$clientid;
            $condf3 = 'Facture.fournisseur_id in '.$clientid;
            $condfa3='Factureavoirfr.fournisseur_id in '.$clientid;
            $condr3 = 'Reglement.fournisseur_id in '.$clientid;
            $condclt = 'Fournisseur.id in '.$clientid;
        }
        if ($this->request->data['Recherche']['pointdevente_id']) {
             
            $pointdeventeid= $this->request->data['Recherche']['pointdevente_id'];
            $condb7 = 'Bonreception.pointdevente_id ='.$pointdeventeid;
            $condf7 = 'Facture.pointdevente_id ='.$pointdeventeid;
            $condfa7='Factureavoirfr.pointdevente_id ='.$pointdeventeid;
            $condr7 = 'Reglement.pointdevente_id ='.$pointdeventeid;
        }
        
         
        if (!empty($this->request->data['Recherche']['personnel_id'])) {
            $personnelid = $this->request->data['Recherche']['personnel_id'];
            $clients=$this->Fournisseur->find('all',array('recursive'=>-1,'conditions'=>array('Fournisseur.personnel_id'=>$personnelid)));
            //debug($clients);die;
            $abc='0';
            foreach ($clients as $cl){
              $abc=$abc.','.$cl['Fournisseur']['id'];  
            }
            $condb5 = 'Bonreception.fournisseur_id in ('.$abc.')';
            $condf5 = 'Facture.fournisseur_id in ('.$abc.')';
            $conda5 = 'Factureavoirfr.fournisseur_id in ('.$abc.')';
            $condr5 = 'Reglement.fournisseur_id in ('.$abc.')';
        }
        
        if ($this->request->data['Recherche']['bl_id']) {
            $blid= $this->request->data['Recherche']['bl_id'];
            if($blid==0)
               $condb8 = 'Bonreception.id>0';
            else
               $condb8 = 'Bonreception.id =0';
        } 
            
            
             $factureavoirs=$this->Factureavoirfr->find('all', array(
            'conditions' => array('Factureavoirfr.totalttc>Factureavoirfr.montant_regle',@$condfa1,@$condfa2,@$condfa3,@$condfa4,@$conda5,@$condfa7),'recursive'=>-1 ));
        //debug($factureavoirs);die;
             if(!empty($factureavoirs)){
                 $clientactif=1;
             foreach ($factureavoirs as $factureavoir) {
                $req_client = $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$factureavoir['Factureavoirfr']['fournisseur_id']),'recursive'=>-1));
                $tablignedevis['numclt']=$req_client['Fournisseur']['code'];
                $tablignedevis['fournisseur_id']=$factureavoir['Factureavoirfr']['fournisseur_id'];
                $tablignedevis['date']=$factureavoir['Factureavoirfr']['date'];
                //if ($factureavoir['Factureavoirfr']['typefacture_id'] == 2) {
                $tablignedevis['numero']='<a TARGET=_BLANK class="" href="'.$this->webroot.'Factureavoirfrs/edit/'.$factureavoir['Factureavoirfr']['id'].'">'.$factureavoir['Factureavoirfr']['numero'].'</a>';    
                //}
//                if ($factureavoir['Factureavoirfr']['source'] == "libre") {
//                $tablignedevis['numero']='<a TARGET=_BLANK class="" href="'.$this->webroot.'Factureavoirfrs/editlibre/'.$factureavoir['Factureavoirfr']['id'].'">'.$factureavoir['Factureavoirfr']['numero'].'</a>';    
//                }
                
                if ($factureavoir['Factureavoirfr']['typefacture_id'] == 1) {
                $tablignedevis['type']='<a onClick="flvFPW1(wr+`Factureavoirfrs/imprimerfavr/`+'.$factureavoir['Factureavoirfr']['id'].',`UPLOAD`,`width=800,height=1150,scrollbars=yes`,0,2,2);return document.MM_returnValue" href="javascript:;" ><strong>Factureavoirfr N°     :'.$factureavoir['Factureavoirfr']['numero'].'</strong></a>';
                }else{
                $tablignedevis['type']='<a onClick="flvFPW1(wr+`Factureavoirfrs/imprimerfavf/`+'.$factureavoir['Factureavoirfr']['id'].',`UPLOAD`,`width=800,height=1150,scrollbars=yes`,0,2,2);return document.MM_returnValue" href="javascript:;" ><strong>Factureavoirfr N°     :'.$factureavoir['Factureavoirfr']['numero'].'</strong></a>';
                }
                $tablignedevis['debit']="";
                $tablignedevis['credit']=$factureavoir['Factureavoirfr']['totalttc'];
                $tablignedevis['impaye']="";
                $tablignedevis['reglement']=$factureavoir['Factureavoirfr']['montant_regle'];
                $tablignedevis['avoir']="";
                $tablignedevis['solde']=($factureavoir['Factureavoirfr']['totalttc']-$factureavoir['Factureavoirfr']['montant_regle'])*(-1);
                $tablignedevis['exercice_id']=$factureavoir['Factureavoirfr']['exercice_id'];
                $tablignedevis['typ']="FR";
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignedevis);
             }}
            $bonlivraisons= $this->Bonreception->find('all', array('conditions' => array(
            'Bonreception.facture_id'=>0,'Bonreception.totalttc>0',@$condb1,@$condb2,@$condb3,@$condb4,@$condb5,@$condb8 ),'contain'=>array('Fournisseur'),'recursive'=>-1 ));
            if(!empty($bonlivraisons)){
                $clientactif=1;
            foreach ($bonlivraisons as $bonlivraison) {
                $req_client = $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$bonlivraison['Bonreception']['fournisseur_id']),'recursive'=>-1));
                $tablignelivraisons['numclt']=$req_client['Fournisseur']['code'];
                $tablignelivraisons['fournisseur_id']=$bonlivraison['Bonreception']['fournisseur_id'];
                $tablignelivraisons['date']=$bonlivraison['Bonreception']['date'];
                $tablignelivraisons['numero']='<a TARGET=_BLANK class="" href="'.$this->webroot.'Factures/edit/'.$bonlivraison['Bonreception']['id'].'/Bonreception/Lignereception/bonreception_id">'.$bonlivraison['Bonreception']['numerofrs'].'</a>';
                $tablignelivraisons['type']='<a onClick="flvFPW1(wr+`Bonreceptions/imprimer/`+'.$bonlivraison['Bonreception']['id'].'+`/'.urlencode(Appcontroller::encrypt_decrypt("Bonreception")).'/'.urlencode(Appcontroller::encrypt_decrypt("Lignereception")).'/'.urlencode(Appcontroller::encrypt_decrypt("bonreception_id")).'/'.urlencode(Appcontroller::encrypt_decrypt("bonreceptions")).'/'.urlencode(Appcontroller::encrypt_decrypt("Bon livraison")).'`,`UPLOAD`,`width=800,height=1150,scrollbars=yes`,0,2,2);return document.MM_returnValue" href="javascript:;" ><strong>Bon de livraison     :'.$bonlivraison['Bonreception']['name'].'</strong></a>';                              
                $tablignelivraisons['debit']=$bonlivraison['Bonreception']['totalttc'];
                $tablignelivraisons['credit']="";
                $tablignelivraisons['impaye']="";
                $tablignelivraisons['reglement']=$bonlivraison['Bonreception']['Montant_Regler'];
                $tablignelivraisons['avoir']="";
                 $tablignelivraisons['typ']="BL";
                $tablignelivraisons['solde']=$bonlivraison['Bonreception']['totalttc']-$bonlivraison['Bonreception']['Montant_Regler'];
                $tablignelivraisons['exercice_id']=$bonlivraison['Bonreception']['exercice_id'];
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignelivraisons);
            }}
            $factureclients = $this->Facture->find('all', array('conditions' => array(
            'Facture.id > 0','Facture.totalttc >Facture.Montant_Regler',@$condf1,@$condf2,@$condf3,@$condf4,@$condf5,@$condf7),'recursive'=>-1));
            if(!empty($factureclients)){
                $clientactif=1;
            foreach ($factureclients as $factureclient) {
                $nom="";$imp="";
                 if($factureclient['Facture']['type']=="trans_bl"){
                  $nom="Facture";   
                  $imp="imprimertrans";
                 }else{
                  $nom="BlFacture";
                  $imp="imprimer";
                 }
                $req_client = $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$factureclient['Facture']['fournisseur_id']),'recursive'=>-1));
                $tablignefactureclients['numclt']=$req_client['Fournisseur']['code'];
                $tablignefactureclients['fournisseur_id']=$factureclient['Facture']['fournisseur_id'];
                $tablignefactureclients['date']=$factureclient['Facture']['date'];
                $tablignefactureclients['numero']='<a TARGET=_BLANK class="" href="'.$this->webroot.'Factures/edit/'.$factureclient['Facture']['id'].'/Facture/Lignefacture/facture_id">'.$factureclient['Facture']['numerofrs'].'</a>';
                $tablignefactureclients['type']='<a onClick="flvFPW1(wr+`Factures/'.$imp.'/`+'.$factureclient['Facture']['id'].'+`/'.urlencode(Appcontroller::encrypt_decrypt("Facture")).'/'.urlencode(Appcontroller::encrypt_decrypt("Lignefacture")).'/'.urlencode(Appcontroller::encrypt_decrypt("facture_id")).'/'.urlencode(Appcontroller::encrypt_decrypt("factures")).'/'.urlencode(Appcontroller::encrypt_decrypt("Facture")).'`,`UPLOAD`,`width=800,height=1150,scrollbars=yes`,0,2,2);return document.MM_returnValue" href="javascript:;" ><strong>'.$nom.'</strong></a>';                              
                $tablignefactureclients['debit']=$factureclient['Facture']['totalttc'];
                $tablignefactureclients['credit']="";
                $tablignefactureclients['impaye']="";
                $tablignefactureclients['reglement']=$factureclient['Facture']['Montant_Regler'];
                $tablignefactureclients['avoir']="";
                $tablignefactureclients['solde']=$factureclient['Facture']['totalttc']-$factureclient['Facture']['Montant_Regler'];
                $tablignefactureclients['exercice_id']=$factureclient['Facture']['exercice_id'];
                $tablignefactureclients['typ']="Fac";
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignefactureclients);
            }}
            
             $reglementlibres = $this->Reglement->find('all', array('conditions' => array(
            "Reglement.impute=0",'(Reglement.Montant>Reglement.montantaffecte)',@$condr1,@$condr2,@$condr3,@$condr4,@$condr5,@$condr7),'recursive'=>-1));
            if(!empty($reglementlibres)){
                $clientactif=1;
             foreach ($reglementlibres as $reglementlibre) {
                $req_client = $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$reglementlibre['Reglement']['fournisseur_id']),'recursive'=>-1));
                $tablignereglementlibres['numclt']=$req_client['Fournisseur']['code'];
                $tablignereglementlibres['fournisseur_id']=$reglementlibre['Reglement']['fournisseur_id'];
                $tablignereglementlibres['date']=$reglementlibre['Reglement']['Date'];
                $tablignereglementlibres['numero']='<a TARGET=_BLANK class="" href="'.$this->webroot.'Reglements/edit/'.$reglementlibre['Reglement']['id'].'">'.$reglementlibre['Reglement']['numeroconca'].'</a>';
                $liste="Reg: ";
                $Piecereglements=$this->Piecereglement->find('all', array('conditions'=>array('Piecereglement.reglement_id'=>$reglementlibre['Reglement']['id']),'contain'=>array('Paiement'),'recursive'=>0 ));
                $liste="<table width='100%' >";
                foreach ($Piecereglements as $k=>$Piece) {
//                if($k==0){
//                $liste=$liste."".$Piece['Paiement']['name'];
//                if(!empty($Piece['Piecereglement']['num'])){
//                $liste=$liste." : ".$Piece['Piecereglement']['num']."<br>";    
//                }else{
//                $liste=$liste."<br>";     
//                }
//                }else{
//                $liste=$liste.$Piece['Paiement']['name'];
//                if(!empty($Piece['Piecereglement']['num'])){
//                $liste=$liste." : ".$Piece['Piecereglement']['num']."<br>";    
//                }else{
//                $liste=$liste."<br>";     
//                }
//                }
                $liste=$liste."<tr>";
                $liste=$liste."<td><strong>".@$Piece['Paiement']['name']."</strong></td>";
                if(empty($Piece['Piecereglement']['num'])){
                $Piece['Piecereglement']['num']="" ;   
                }
                $liste=$liste."<td><strong>".@$Piece['Piecereglement']['num']."</strong></td>";
                if((!empty($Piece['Piecereglement']['echance']))&&($Piece['Piecereglement']['echance']!="1970-01-01")){
                $Piece['Piecereglement']['echance']=date("d/m/Y",strtotime(str_replace('/','-',@$Piece['Piecereglement']['echance'])));    
                }else{
                $Piece['Piecereglement']['echance']="";    
                }
                $liste=$liste."<td><strong>".@$Piece['Piecereglement']['echance']."</strong></td>";
                $liste=$liste."<td><strong> ====> ".@$Piece['Piecereglement']['montant']."</strong></td>";
                $liste=$liste."</tr>";    
                }
                $liste.="</table>";
                $tablignereglementlibres['type']=$liste;
                $tablignereglementlibres['debit']="";
                $tablignereglementlibres['credit']=$reglementlibre['Reglement']['Montant'];
                $tablignereglementlibres['impaye']="";
                $tablignereglementlibres['reglement']=$reglementlibre['Reglement']['montantaffecte'];
                $tablignereglementlibres['avoir']="";
                $tablignereglementlibres['solde']=$reglementlibre['Reglement']['montantaffecte']-$reglementlibre['Reglement']['Montant'];
                $tablignereglementlibres['exercice_id']=$reglementlibre['Reglement']['exercice_id'];
                $tablignereglementlibres['typ']="Reg";
                
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignereglementlibres);
                
                
                
                
            }} 
            
            $piecereglements = $this->Piecereglement->find('all', array('conditions' => array(
            'Piecereglement.paiement_id in (2,3)','Piecereglement.situation="Impayé"','Piecereglement.montant>Piecereglement.mantantregler',@$condr1,@$condss2,@$condr3,@$condr4,@$condr5,$condss1,@$condr7),'contain'=>array('Paiement','Reglement'),'recursive'=>0));   
            //debug($piecereglements);
            if(!empty($piecereglements)){
            $clientactif=1;    
            foreach ($piecereglements as $piecereglement) {
                $req_client = $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$piecereglement['Reglement']['fournisseur_id']),'recursive'=>-1));
                $tablignepiecereglements['numclt']=$req_client['Fournisseur']['code'];
                $tablignepiecereglements['fournisseur_id']=$piecereglement['Reglement']['fournisseur_id'];
                $tablignepiecereglements['date']=$piecereglement['Piecereglement']['datesituation'];
                $tablignepiecereglements['numero']=$piecereglement['Reglement']['numero'];
                $tablignepiecereglements['type']=$piecereglement['Paiement']['name'].' : '.$piecereglement['Piecereglement']['num'];
                $tablignepiecereglements['debit']=$piecereglement['Piecereglement']['montant'];
                $tablignepiecereglements['credit']="";
                $tablignepiecereglements['impaye']=$piecereglement['Piecereglement']['montant'];
                $tablignepiecereglements['reglement']=$piecereglement['Piecereglement']['mantantregler'];
                $tablignepiecereglements['avoir']="";
                $tablignepiecereglements['solde']=$piecereglement['Piecereglement']['montant']-$piecereglement['Piecereglement']['mantantregler'];
                $tablignepiecereglements['exercice_id']=$piecereglement['Reglement']['exercice_id'];
                $tablignepiecereglements['typ']="Reg";
                $this->Recouvrement->create();
                $this->Recouvrement->save($tablignepiecereglements);
            }}
//        if($clientactif==1){
//                $tablignedevis['fournisseur_id']=$clientid;
//                $tablignedevis['date']="";
//                $tablignedevis['numero']="";
//                $tablignedevis['type']="Solde Départ";
//                $tablignedevis['debit']="";
//                $tablignedevis['credit']="";
//                $tablignedevis['impaye']="";
//                $tablignedevis['reglement']="";
//                $tablignedevis['avoir']="";
//                $tablignedevis['solde']=$solde;
//                $tablignedevis['exercice_id']="";
//                $tablignedevis['typ']="";
//                $this->Recouvrement->create();
//                $this->Recouvrement->save($tablignedevis);    
//        }    
            
            
            
        }      
        
     $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Fournisseur->find('list', array(
            'conditions' => array('Fournisseur.societe'=>$composantsoc)
        ));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv))); 
    $relefes=$this->Recouvrement->find('all', array($cond6,'order'=>array('Recouvrement.numclt'=>'asc','Recouvrement.date'=>'asc'),
     'recursive'=>0 ));
     //debug($relefes);
//     if(!empty($clientid)){
//     $client=$this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id'=>$clientid),'recursive'=>0 ));
//     $soldeint=$client['Fournisseur']['solde']+$solde;
//     CakeSession::write('soldeint',$soldeint);
//     }
     $personnels = $this->Personnel->find('list');
        $bls['0']='Avec BL';
        $bls['1']='Sans BL ';
        $this->set(compact('fournisseurs','personnels','bls','condfas','condbs','condfs','condbbs','condbbs','relefes','soldeint','solde','clientid','c5','c4','c3','c2','c1','piecereglements','factureavoirs','bonlivraisons','factureclients','reglementlibres','articles','clients','pointdeventes','exercices','exerciceid','date1','clientid','marque_id','date2','name'));
    
   }
   
   public function imprimerrecherchefrs() {
        $lien=  CakeSession::read('lien_vente');
               $utilisateur="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='releves'){
                        $utilisateur=$liens['imprimer'];
                }}}
              if (( $utilisateur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   $this->layout = null;
        $cond6="'group'=>array('Recouvrement.fournisseur_id')";           
                   
                   
                   
       if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
           
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
           
        }
        
       if ($this->request->query['name']) {
            $name = $this->request->query['name'];
            
        } 
        $relefes=$this->Recouvrement->find('all', array(@$cond6,'order'=>array('Recouvrement.numclt'=>'asc','Recouvrement.date'=>'asc'),
     'recursive'=>0 ));
        $soldeint=CakeSession::read('soldeint');
        //debug($relefes);
        $this->set(compact('relefes','date1','date2','name','soldeint'));
    }	
		
		
		
		
		
		
}
