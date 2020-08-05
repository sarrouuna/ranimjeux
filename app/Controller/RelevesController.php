<?php
App::uses('AppController', 'Controller');



class RelevesController extends AppController {


	public function index($clt=NULL) {
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
            $this->loadModel('Transfert');
            $this->loadModel('Societe');
            $this->loadModel('Pointdevente');
            $exercices = $this->Exercice->find('list');
            $exe=date('Y');
            $exercicet = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
            $exerciceid=$exercicet['Exercice']['id'];
            $condb4 = 'Bonlivraison.exercice_id ='.$exe;
            $condf4 = 'Factureclient.exercice_id ='.$exe;
            $condfa4 = 'Factureavoir.exercice_id ='.$exe;
            $condr4 = 'Reglementclient.exercice_id ='.$exe;
            $condtr4 = 'Transfert.exercice_id ='.$exe;
            $c1 = 'Relefe.exercice_id ='.$exe;
            
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
            
            
            
            $this->Relefe->query('TRUNCATE releves;');
            CakeSession::delete('soldeint');
            
            
        //$this->Relefe->deleteAll(array('Relefe.id >'=>0),false);
            $c5="";$recherche=0;
            if ($this->request->is('post') || ($clt != NULL)) {
                
            if($clt != NULL){
                $this->request->data['Recherche']['client_id']=$clt;
                $client = $this->Client->find('first', array('conditions' => array('Client.id' =>$clt), 'recursive' => -1));
                $sctclt = $this->Societe->find('first', array('conditions' => array('Societe.composantsoc' =>$client['Client']['societe']), 'recursive' => -1));
                $this->request->data['Recherche']['societe_id']=$sctclt['Societe']['id'];
                $this->request->data['Recherche']['date1']='01/01/'.date("Y");
                $this->request->data['Recherche']['date2']=date('d/m/Y');
                $this->request->data['Recherche']['bl_id']="";
                $this->request->data['Recherche']['personnel_id']="";
                $recherche=1;
                
            }    
                
                
                
             $this->Relefe->query('TRUNCATE releves;');
             CakeSession::delete('soldeint');
            if($this->request->data['Recherche']['date1'] == "__/__/____"){
               $this->request->data['Recherche']['date1']='01/01/'.date("Y"); 
            } 
            if($this->request->data['Recherche']['date2'] == "__/__/____"){
               $this->request->data['Recherche']['date2']=date('d/m/Y');
            } 
            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= '."'".$date1."'";
            $condfa1 = 'Factureavoir.date >= '."'".$date1."'";
            $condbb1 = 'Reglementclient.date >= '."'".$date1."'";
            //$condss1='Piecereglementclient.datesituation >= '."'".$date1."'";
            $condtr1 = 'Transfert.date >= '."'".$date1."'";
            $condbs = 'Bonlivraison.date < '."'".$date1."'";
            $condfs = 'Factureclient.date < '."'".$date1."'";
            $condfas = 'Factureavoir.date < '."'".$date1."'";
            $condbbs = 'Reglementclient.date < '."'".$date1."'";
            $condss='Piecereglementclient.datesituation < '."'".$date1."'";
            $condtrs = 'Transfert.date < '."'".$date1."'";
            $c2 = 'Relefe.date >= '."'".$date1."'";
           
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
            $condbr2 = 'Reglementclient.date <= '."'".$date2."'";
            //$condss2='Piecereglementclient.datesituation <= '."'".$date2."'";
            $condtr2 = 'Transfert.date <= '."'".$date2."'";
            
            $c3 = 'Relefe.date <= '."'".$date2."'";
            
            $condb4="";
            $condf4="";
            $condfa4="";
            $condr4="";
            
            
        }    
         $clientid="";           
         if ($this->request->data['Recherche']['client_id']) {
             
            $clientid= $this->request->data['Recherche']['client_id'];
            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id ='.$clientid;
            $condfa3='Factureavoir.client_id ='.$clientid;
            $condr3 = 'Reglementclient.client_id ='.$clientid;
            $client = $this->Client->find('first', array('conditions' => array('Client.id' =>$clientid), 'recursive' => -1));
            $condtr3 = 'Transfert.societearrive ='.$client['Client']['societe_id'];
        }
        
        if ($this->request->data['Recherche']['bl_id']) {
            $blid= $this->request->data['Recherche']['bl_id'];
            if($blid==0)
               $condb7 = 'Bonlivraison.id>0';
            else
               $condb7 = 'Bonlivraison.id =0';
        } 
        
        if ($this->request->data['Recherche']['personnel_id']) {
            $personnelid= $this->request->data['Recherche']['personnel_id'];
            $cond5 = 'Client.personnel_id ='.$personnelid;
            $personnel= $this->Personnel->find('all',array('conditions'=>array('Personnel.id'=>$personnelid),false));
            $name=$personnel[0]['Personnel']['name'];
        }
        if ($this->request->data['Recherche']['societe_id']) {
            $societeid= $this->request->data['Recherche']['societe_id'];
            $pointventes= $this->Pointdevente->find('all',array('conditions'=>array('Pointdevente.societe_id'=>$societeid),false));
            $p = '0';
                foreach ($pointventes as $ad) {
                    $p = $p . ',' . $ad['Pointdevente']['id'];
                }
            $p = $p;
            //$cond6 = "Piecereglement.paiement_id in (" . $p . ')';
            $condb6 = "Bonlivraison.pointdevente_id in (" . $p . ')';
            $condf6 = "Factureclient.pointdevente_id in (" . $p . ')';
            $condfa6="Factureavoir.pointdevente_id in (" . $p . ')';
            $condr6 = "Reglementclient.pointdevente_id in (" . $p . ')';
            $condtr6 = 'Transfert.societedepart ='.$societeid;
        }
        
            
            $factureavoirs=$this->Factureavoir->find('all', array(
            'conditions' => array(@$condfa1,@$condfa2,@$condfa3,@$condfa6,@$condfa4,@$cond5),'contain'=>array('Client'),'recursive'=>0 ));
            foreach ($factureavoirs as $factureavoir) {
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
                $this->Relefe->create();
                $this->Relefe->save($tablignedevis);
                }
            $bonlivraisons= $this->Bonlivraison->find('all', array('conditions' => array(
            'Bonlivraison.factureclient_id'=>0,@$condb1,@$condb2,@$condb3,@$condb4,@$cond5,@$condb6,@$condb7 ),'contain'=>array('Client'),'recursive'=>0 ));
            foreach ($bonlivraisons as $bonlivraison) {
                if($bonlivraison['Bonlivraison']['sortie']==0){$type="Bonlivraison";}else{$type="Bon Sortie";}
                $tablignelivraisons['client_id']=$bonlivraison['Bonlivraison']['client_id'];
                $tablignelivraisons['date']=$bonlivraison['Bonlivraison']['date'];
                $tablignelivraisons['numero']=$bonlivraison['Bonlivraison']['numero'];
                $tablignelivraisons['type']=$type;
                $tablignelivraisons['debit']=$bonlivraison['Bonlivraison']['totalttc'];
                $tablignelivraisons['credit']="";
                $tablignelivraisons['impaye']="";
                $tablignelivraisons['reglement']=$bonlivraison['Bonlivraison']['Montant_Regler'];
                $tablignelivraisons['avoir']="";
                 $tablignelivraisons['typ']="BL";
                $tablignelivraisons['solde']=$bonlivraison['Bonlivraison']['totalttc'];
                $tablignelivraisons['exercice_id']=$bonlivraison['Bonlivraison']['exercice_id'];
                $this->Relefe->create();
                $this->Relefe->save($tablignelivraisons);
                }
            $factureclients = $this->Factureclient->find('all', array('conditions' => array(
            @$condf1,@$condf2,@$condf3,@$condf4,@$cond5,@$condf6),'contain'=>array('Client'),'recursive'=>0));
             foreach ($factureclients as $factureclient) {
                $tablignefactureclients['client_id']=$factureclient['Factureclient']['client_id'];
                $tablignefactureclients['date']=$factureclient['Factureclient']['date'];
                $tablignefactureclients['numero']=$factureclient['Factureclient']['numero'];
                $tablignefactureclients['type']="Facture";
                $tablignefactureclients['debit']=$factureclient['Factureclient']['totalttc'];
                $tablignefactureclients['credit']="";
                $tablignefactureclients['impaye']="";
                $tablignefactureclients['reglement']="";
                $tablignefactureclients['avoir']="";
                $tablignefactureclients['solde']=$factureclient['Factureclient']['totalttc'];
                $tablignefactureclients['exercice_id']=$factureclient['Factureclient']['exercice_id'];
                $tablignefactureclients['typ']="Fac";
                $this->Relefe->create();
                $this->Relefe->save($tablignefactureclients);
                }
            
            $reglementlibres = $this->Reglementclient->find('all', array('conditions' => array(
            @$condbr1,@$condbr2,@$condr3,@$condr4,@$cond5,$condbb1,@$condr6,"Reglementclient.emi!='052'"),'contain'=>array('Client'),'recursive'=>0));
            foreach ($reglementlibres as $reglementlibre) {
                $tablignereglementlibres['client_id']=$reglementlibre['Reglementclient']['client_id'];
                $tablignereglementlibres['date']=$reglementlibre['Reglementclient']['Date'];
                $tablignereglementlibres['numero']=$reglementlibre['Reglementclient']['numero'];
                $liste = "<table width='100%' >";
                //$liste="";$cond5
                $Piecereglementclients = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $reglementlibre['Reglementclient']['id']), 'contain' => array('Paiement'), 'recursive' => 0));
                foreach ($Piecereglementclients as $k => $Piece) {
//                if($k==0){
//                $liste=$liste."".$Piece['Paiement']['name'];
//                if(!empty($Piece['Piecereglementclient']['num'])){
//                $liste=$liste." : ".$Piece['Piecereglementclient']['num'];    
//                }
//                if((!empty($Piece['Piecereglementclient']['echance']))&&($Piece['Piecereglementclient']['echance']!="1970-01-01")){
//                $liste=$liste." /echéance ".$Piece['Piecereglementclient']['echance'];    
//                }
//                $liste=$liste."==>".$Piece['Piecereglementclient']['montant']."<br>";
//                }else{
//                $liste=$liste." ".$Piece['Paiement']['name'];
//                if(!empty($Piece['Piecereglementclient']['num'])){
//                $liste=$liste." : ".$Piece['Piecereglementclient']['num'];    
//                }
//                if((!empty($Piece['Piecereglementclient']['echance']))&&($Piece['Piecereglementclient']['echance']!="1970-01-01")){
//                $liste=$liste." /echéance ".$Piece['Piecereglementclient']['echance'];    
//                }
//                $liste=$liste."==>".$Piece['Piecereglementclient']['montant']."<br>";
//                }
                    $liste = $liste . "<tr>";
                    $liste = $liste . "<td><strong>" . @$Piece['Paiement']['name'] . "</strong></td>";
                    $nnr = "";
                    if ($Piece['Piecereglementclient']['num'] == "") {
                        $nnr =@$Piece['Reglementclient']['numero'];
                    } else {
                        $nnr = @$Piece['Piecereglementclient']['num'];
                    }
                    $liste = $liste . "<td><strong>N&deg; : " . @$nnr . "</strong></td>";
                    if ((!empty($Piece['Piecereglementclient']['echance'])) && ($Piece['Piecereglementclient']['echance'] != "1970-01-01")) {
                        $Piece['Piecereglementclient']['echance'] = date("d/m/Y", strtotime(str_replace('/', '-', @$Piece['Piecereglementclient']['echance'])));
                    } else {
                        $Piece['Piecereglementclient']['echance'] = "";
                    }
                    $liste = $liste . "<td><strong> Ech&eacute;ance : " . @$Piece['Piecereglementclient']['echance'] . "</strong></td>";
                    $liste = $liste . "<td><strong>Montant ====> " . @$Piece['Piecereglementclient']['montant'] . "</strong></td>";
                    $liste = $liste . "</tr>";
                }
                $liste = $liste . "<tr><td colspan='4' style='height: 10px;' ></td></tr>";
                $lignereglementclients = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $reglementlibre['Reglementclient']['id']), 'recursive' => 0));
                    if (!empty($lignereglementclients)) {
                        $nn = "";
                        //$liste=$liste."<br>";
                        //debug($reglementlibre['Reglementclient']['id']);
                        foreach ($lignereglementclients as $k => $ligne) {
                            if (!empty($ligne['Lignereglementclient']['factureclient_id'])) {
                                //$liste=$liste." > BLFacture ".@$ligne['Factureclient']['numero'] ."  " .@$ligne['Lignereglementclient']['Montant']."<br>"  ; 
                                $liste = $liste . "<tr>";
                                $liste = $liste . '<td colspan="2"><a onClick="flvFPW1(wr+`Factureclients/imprimer/`+' . @$ligne['Factureclient']['id'] . ',`UPLOAD`,`width=800,height=1150,scrollbars=yes`,0,2,2);return document.MM_returnValue" href="javascript:;" ><strong>> BLFacture </strong></a></td>';
                                $liste = $liste . "<td> N&deg; : " . @$ligne['Factureclient']['numero'] . "</td>";
                                $liste = $liste . "<td>Montant : " . @$ligne['Lignereglementclient']['Montant'] . "</td>";
                                $liste = $liste . "</tr>";
                            } else {
                                //$liste=$liste." > Impayé Client ".@$ligne['Piecereglementclient']['num'] ."  " .@$ligne['Lignereglementclient']['Montant']."<br>"  ; 
                                $liste = $liste . "<tr>";
                            $piecereglementclientimp = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.id' =>$ligne['Lignereglementclient']['piecereglementclient_id']), 'recursive' => 0));
                                $liste = $liste . "<td colspan='2'> > ".$piecereglementclientimp['Paiement']['name']." Impay&eacute;  </td>";
                                if ($piecereglementclientimp['Piecereglementclient']['num'] == "") {
                                    $ans_reg = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $piecereglementclientimp['Piecereglementclient']['reglementclient_id']), 'recursive' => -1));
                                    $nn = $ans_reg['Reglementclient']['numero'];
                                } else {
                                    $nn = $piecereglementclientimp['Piecereglementclient']['num'];
                                }
                                $liste = $liste . "<td> N&deg; : " . @$nn . "</td>";
                                $liste = $liste . "<td>Montant : " . @$ligne['Lignereglementclient']['Montant'] . "</td>";
                                $liste = $liste . "</tr>";
                            }
                        }
                    }
                
                $liste.="</table>";
                $tablignereglementlibres['nbligneimp']=$k+3;
                $tablignereglementlibres['tr']=1;
                $tablignereglementlibres['type']=$liste;
                $tablignereglementlibres['debit']="";
                $tablignereglementlibres['credit']=$reglementlibre['Reglementclient']['Montant'];
                $tablignereglementlibres['impaye']="";
                $tablignereglementlibres['reglement']=$reglementlibre['Reglementclient']['Montant'];
                $tablignereglementlibres['avoir']="";
                $tablignereglementlibres['solde']=0-$reglementlibre['Reglementclient']['Montant'];
                $tablignereglementlibres['exercice_id']=$reglementlibre['Reglementclient']['exercice_id'];
                $tablignereglementlibres['typ']="Reg";
                if($reglementlibre['Reglementclient']['emi']!='052'){
                $this->Relefe->create();
                $this->Relefe->save($tablignereglementlibres);
                }
                
                
                
                } 
            
            $piecereglements = $this->Piecereglementclient->find('all', array('conditions' => array(
            'Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.situation="Impayé"',@$condbb1,@$condbr2,@$condr3,@$condr4,@$cond5,@$condss1,@$condr6),'contain'=>array('Paiement','Reglementclient'),'recursive'=>0));   
             //debug($piecereglements);die;
            foreach ($piecereglements as $piecereglement) { //debug($piecereglement);die;
                if($piecereglement['Piecereglementclient']['datesituation']==null){$piecereglement['Piecereglementclient']['datesituation']=$piecereglement['Reglementclient']['Date'];}
                $tablignepiecereglements['client_id']=$piecereglement['Reglementclient']['client_id'];
                $tablignepiecereglements['date']=$piecereglement['Piecereglementclient']['datesituation'];
                $tablignepiecereglements['numero']=$piecereglement['Reglementclient']['numero'];
                $tablignepiecereglements['tr']=1;
                $tablignepiecereglements['type']=$piecereglement['Paiement']['name'].' Impayé => '.$piecereglement['Piecereglementclient']['montant'].' : '.$piecereglement['Piecereglementclient']['num'].' Le '.date("d/m/Y", strtotime(str_replace('-', '/',$piecereglement['Piecereglementclient']['echance'])));
                $tablignepiecereglements['debit']=$piecereglement['Piecereglementclient']['montant'];
                $tablignepiecereglements['credit']="";
                $tablignepiecereglements['impaye']=$piecereglement['Piecereglementclient']['montant'];
                $tablignepiecereglements['reglement']="";
                $tablignepiecereglements['avoir']="";
                $tablignepiecereglements['solde']=$piecereglement['Piecereglementclient']['montant'];
                $tablignepiecereglements['exercice_id']=$piecereglement['Reglementclient']['exercice_id'];
                $tablignepiecereglements['typ']="Reg";
                $this->Relefe->create();
                $this->Relefe->save($tablignepiecereglements);
                }
                
            $transferts = $this->Transfert->find('all', array('conditions' => array(
            'Transfert.fact_vente=0',@$condtr1,@$condtr2,@$condtr3,@$condtr4,@$condtr6),'recursive'=>-1));  
            //debug($transferts);die;
            foreach ($transferts as $transfert) {
            $client = $this->Client->find('first', array('conditions' => array('Client.societe_id' =>$transfert['Transfert']['societearrive']), 'recursive' => -1));
                $tablignetransfert['client_id']=$client['Client']['id'];
                $tablignetransfert['date']=$transfert['Transfert']['date'];
                $tablignetransfert['numero']=$transfert['Transfert']['numero'];
                $tablignetransfert['type']="Transfert";
                $tablignetransfert['debit']=$transfert['Transfert']['totttc'];
                $tablignetransfert['credit']="";
                $tablignetransfert['impaye']="";
                $tablignetransfert['reglement']="";
                $tablignetransfert['avoir']="";
                $tablignetransfert['solde']=$transfert['Transfert']['totttc'];
                $tablignetransfert['exercice_id']=$transfert['Transfert']['exercice_id'];
                $tablignetransfert['typ']="transf";
                $this->Relefe->create();
                $this->Relefe->save($tablignetransfert);
                }    
                
                
            
      } 
        
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.societe'=>$composantsoc), 'order' => array('Client.code' => 'asc')
        ));
        $personnels = $this->Personnel->find('list'); 
        $societes = $this->Societe->find('list'); 
     $relefes=$this->Relefe->find('all', array('order'=>array('Relefe.date,Relefe.client_id'=>'asc'),
     'recursive'=>0 ));
//     if(!empty($clientid)){
//     $client=$this->Client->find('first', array('conditions' => array('Client.id'=>$clientid),'recursive'=>0 ));
//     $soldeint=$client['Client']['solde']+$solde;
//     CakeSession::write('soldeint',$soldeint);
//     }
     
        $bls['0']='Avec BL';
        $bls['1']='Sans BL ';
        $this->set(compact('societeid','recherche','bls','condb7','condtrs','condtr3','condtr6','condss','condr3','condr6','condbbs','condr3','condr6','condfs','condf3','condf6','condbs','condb3','condb6','condfas','condfa3','condfa6','societes','relefes','soldeint','solde','clientid','c5','c4','c3','c2','c1','piecereglements','factureavoirs','bonlivraisons','factureclients','reglementlibres','articles','clients','personnels','exercices','exerciceid','date1','clientid','marque_id','date2','name'));
    
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
       if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
           $condbs = 'Bonlivraison.date < '."'".$date1."'";
            $condfs = 'Factureclient.date < '."'".$date1."'";
            $condfas = 'Factureavoir.date < '."'".$date1."'";
            $condbbs = 'Reglementclient.date < '."'".$date1."'";
            $condss='Piecereglementclient.datesituation < '."'".$date1."'";
            $condtrs = 'Transfert.date < '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
           
        }
        
       if ($this->request->query['name']) {
            $name = $this->request->query['name'];
            
        } 
		if ($this->request->query['societeid']) {
            $societeid = $this->request->query['societeid'];
            
        } 
        $relefes=$this->Relefe->find('all', array('order'=>array('Relefe.date,Relefe.typ'=>'asc'),
     'recursive'=>0 ));
        $soldeint=CakeSession::read('soldeint');
        //debug($relefes);
        $this->set(compact('condb7','condtrs','condtr3','condtr6','condss','condr3','condr6','condbbs','condr3','condr6','condfs','condf3','condf6','condbs','condb3','condb6','condfas','condfa3','condfa6','societeid','relefes','date1','date2','name','soldeint'));
    }
        
        public function indextotale() {
        $lien = CakeSession::read('lien_vente');
        $utilisateur = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'releves') {
                    $utilisateur = 1;
                }
            }
        }
        if (( $utilisateur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
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
        $all_clients = array();


        if ($this->request->is('post')) {

            if ($this->request->data['Recherche']['date1'] == "__/__/____") {
                $this->request->data['Recherche']['date1'] = '01/01/2002';
            }
            if ($this->request->data['Recherche']['date2'] == "__/__/____") {
                $this->request->data['Recherche']['date2'] = date('d/m/Y');
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
                $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
                $condfa1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
                $condbb1 = 'Reglementclient.date >= ' . "'" . $date1 . "'";
                $condss1 = 'Piecereglementclient.datesituation >= ' . "'" . $date1 . "'";
                $condbs = 'Bonlivraison.date < ' . "'" . $date1 . "'";
                $condfs = 'Factureclient.date < ' . "'" . $date1 . "'";
                $condfas = 'Factureavoir.date < ' . "'" . $date1 . "'";
                $condbbs = 'Reglementclient.date < ' . "'" . $date1 . "'";
                $condss = 'Piecereglementclient.datesituation < ' . "'" . $date1 . "'";
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
                $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
                $condfa2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
                $condbb2 = 'Reglementclient.date <= ' . "'" . $date2 . "'";
                $condss2 = 'Piecereglementclient.datesituation <= ' . "'" . $date2 . "'";
            }

            if ($this->request->data['Recherche']['client_id']) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $clt= $this->Client->find('first',array('conditions'=>array('Client.id'=>$clientid),false));
                $cond = 'Client.code >=' . $clt['Client']['code'];
            }
            if ($this->request->data['Recherche']['client2_id']) {
                $clientid2 = $this->request->data['Recherche']['client2_id'];
                $clt2= $this->Client->find('first',array('conditions'=>array('Client.id'=>$clientid2),false));
                $cond2 = 'Client.code <=' . $clt2['Client']['code'];
            }







            //debug($all_clients);die; 

            $all_clients = $this->Client->find('all', array('recursive' => -1, 'conditions' => array(@$cond,@$cond2), 'order' => array('Client.code' => 'asc')));

              //debug($all_clients);die;
        }
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array(
                'Client.societe'=>$composantsoc
                ), 'order' => array('Client.code' => 'asc')
        ));
        $client2s = $this->Client->find('list', array(
            'conditions' => array('Client.etat' => 1
                ,
                'Client.societe'=>$composantsoc
                ), 'order' => array('Client.code' => 'asc')
        ));
        //$clients = $this->Client->find('list');
        //$client2s = $this->Client->find('list');
        $personnels = $this->Personnel->find('list');
        $this->set(compact('client2s','condss', 'condbbs', 'condfas', 'condfs', 'condbs', 'condss2', 'condbb2', 'condf2', 'condb2', 'condfa2', 'condss1', 'condbb1', 'condf1', 'condb1', 'condfa1', 'all_clients', 'relefes', 'soldeint', 'solde', 'clientid', 'c5', 'c4', 'c3', 'c2', 'c1', 'piecereglements', 'factureavoirs', 'bonlivraisons', 'factureclients', 'reglementlibres', 'articles', 'clients', 'personnels', 'exercices', 'exerciceid', 'date1', 'clientid', 'marque_id', 'date2', 'name'));
    }

        public function imprimerexcel() {
        $this->layout = null;
        $lien = CakeSession::read('lien_vente');
        $utilisateur = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'releves') {
                    $utilisateur = $liens['imprimer'];
                }
            }
        }
        if (( $utilisateur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
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
        $all_clients = array();

        // debug($this->request->query);die;           


        if ($this->request->query['date1'] == "__/__/____") {
            $this->request->query['date1'] = '01/01/2015';
        }
        if ($this->request->query['date2'] == "__/__/____") {
            $this->request->query['date2'] = date('d/m/Y');
        }
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
            $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            $condfa1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condbb1 = 'Reglementclient.date >= ' . "'" . $date1 . "'";
            $condss1 = 'Piecereglementclient.datesituation >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
            $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            $condfa2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condbb2 = 'Reglementclient.date <= ' . "'" . $date2 . "'";
            $condss2 = 'Piecereglementclient.datesituation <= ' . "'" . $date2 . "'";
        }

        if (!empty($this->request->query['clientid'])) {
            $clientid = $this->request->query['clientid'];
            $cond = 'Client.id =' . $clientid;
        }
        $all_clients = $this->Client->find('all', array('recursive' => -1, 'conditions' => array(@$cond)));
        //debug($all_clients);die;
        $this->set(compact('condss2', 'condbb2', 'condf2', 'condb2', 'condfa2', 'condss1', 'condbb1', 'condf1', 'condb1', 'condfa1', 'all_clients', 'relefes', 'soldeint', 'solde', 'clientid', 'c5', 'c4', 'c3', 'c2', 'c1', 'piecereglements', 'factureavoirs', 'bonlivraisons', 'factureclients', 'reglementlibres', 'articles', 'clients', 'personnels', 'exercices', 'exerciceid', 'date1', 'clientid', 'marque_id', 'date2', 'name'));
    }

	


	public function view($id = null) {
		if (!$this->Relefe->exists($id)) {
			throw new NotFoundException(__('Invalid relefe'));
		}
		$options = array('conditions' => array('Relefe.' . $this->Relefe->primaryKey => $id));
		$this->set('relefe', $this->Relefe->find('first', $options));
	}


	public function add() {
		if ($this->request->is('post')) {
			$this->Relefe->create();
			if ($this->Relefe->save($this->request->data)) {
				$this->Session->setFlash(__('The relefe has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The relefe could not be saved. Please, try again.'));
			}
		}
	}


	public function edit($id = null) {
		if (!$this->Relefe->exists($id)) {
			throw new NotFoundException(__('Invalid relefe'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Relefe->save($this->request->data)) {
				$this->Session->setFlash(__('The relefe has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The relefe could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Relefe.' . $this->Relefe->primaryKey => $id));
			$this->request->data = $this->Relefe->find('first', $options);
		}
	}


	public function delete($id = null) {
		$this->Relefe->id = $id;
		if (!$this->Relefe->exists()) {
			throw new NotFoundException(__('Invalid relefe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Relefe->delete()) {
			$this->Session->setFlash(__('Relefe deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Relefe was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
         public function indextotale_n() {
        $this->layout = "default_n";
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
        $all_clients = array();

        if ($this->request->is('post')) {

            if ($this->request->data['Recherche']['date1'] == "__/__/____") {
                $this->request->data['Recherche']['date1'] = '01/01/2000';
            }
            if ($this->request->data['Recherche']['date2'] == "__/__/____") {
                $this->request->data['Recherche']['date2'] = date('d/m/Y');
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____") {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
                $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
                $condfa1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
                $condbb1 = 'Reglementclient.date >= ' . "'" . $date1 . "'";
                $condss1 = 'Piecereglementclient.datesituation >= ' . "'" . $date1 . "'";
                $condbs = 'Bonlivraison.date < ' . "'" . $date1 . "'";
                $condfs = 'Factureclient.date < ' . "'" . $date1 . "'";
                $condfas = 'Factureavoir.date < ' . "'" . $date1 . "'";
                $condbbs = 'Reglementclient.date < ' . "'" . $date1 . "'";
                $condss = 'Piecereglementclient.datesituation < ' . "'" . $date1 . "'";
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____") {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
                $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
                $condfa2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
                $condbb2 = 'Reglementclient.date <= ' . "'" . $date2 . "'";
                $condss2 = 'Piecereglementclient.datesituation <= ' . "'" . $date2 . "'";
            }

            if ($this->request->data['Recherche']['client_id']) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $cond = 'Client.id =' . $clientid;
            }

            if ($this->request->data['Recherche']['pointdevente_id']) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                $condp = 'Client.idste =' . $pointdevente_id;
                $pv = $this->Pointdevente->find('first', array('recursive' => -1, 'conditions' => array("Pointdevente.id"=>$pointdevente_id)));
                $pv_name=$pv['Pointdevente']['name'];
                $pv_id=$pv['Pointdevente']['id'];
            }





            //debug($all_clients);die; 

            $all_clients = $this->Client->find('all', array('recursive' => -1, 'conditions' => array(@$cond)));

            //  debug($all_clients);die;
        }
        
        $clients = $this->Client->find('list');
        $pointdeventes = $this->Pointdevente->find('list');
        $this->set(compact('pv_id','pv_name','condss', 'condbbs', 'condfas', 'condfs', 'condbs', 'condss2', 'condbb2', 'condf2', 'condb2', 'condfa2', 'condss1', 'condbb1', 'condf1', 'condb1', 'condfa1', 'all_clients', 'relefes', 'soldeint', 'solde', 'clientid', 'c5', 'c4', 'c3', 'c2', 'c1', 'piecereglements', 'factureavoirs', 'bonlivraisons', 'factureclients', 'reglementlibres', 'articles', 'clients', 'pointdeventes', 'exercices', 'exerciceid', 'date1', 'clientid', 'marque_id', 'date2', 'name'));
    }
       
        }
