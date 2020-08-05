<?php
App::uses('AppController', 'Controller');



class RelevefournisseursController extends AppController {


	public function index2() {
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
        
        
                $this->loadModel('Relevefournisseur');
                $this->loadModel('Facture');
            
               $this->Relevefournisseur->query('TRUNCATE releves;');
            
                $this->loadModel('Fournisseur'); 
                $this->loadModel('Detailsbl');
                $this->loadModel('Bonreception');
                $this->loadModel('Reglement');  
                $this->loadModel('Lignereglement');
                
                $facture_reglee = $this->Facture->find('all',array('conditions'=>array('Facture.totalttc'=>'Facture.Montant_Regler'),'recursive'=>-1));
               
                
         if ($this->request->is('post') || $this->request->is('put')) {
                    $this->Relevefournisseur->query('TRUNCATE relevefournisseurs;');
                    $cond='';$condf='';$cond1='';$cond1f='';$cond2='';$cond2f='';$cond3='';$cond3f='';$cond4='';
                    $cond5='';$cond6='';$cond7='';$cond8='';$cond9='';
                    
                    $regs=array(); 
                    $regs['0']='Reglé';
                    $regs['1']='Non reglé';
                    //debug($this->request->data['Relevefournisseur']['reg']);die;
                        $Date_debut = '';
                    if($this->request->data['Relevefournisseur']['Date_debut'] != '__/__/____'){
                    $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Relevefournisseur']['Date_debut'])));
                    $cond='Bonreception.date>='."'".$Date_debut."'";
                    $condf='Facture.date>='."'".$Date_debut."'";
                    $cond5='Reglement.date>='."'".$Date_debut."'";
                    }
                    if($this->request->data['Relevefournisseur']['Date_fin'] != '__/__/____'){
                    $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Relevefournisseur']['Date_fin'])));
                    $cond1='Bonreception.date<='."'".$Date_fin."'";
                    $cond1f='Facture.date<='."'".$Date_fin."'";
                    $cond6='Reglement.date<='."'".$Date_fin."'";
                }
                    
                    if($this->request->data['Relevefournisseur']['fournisseur_id']){
                        $fournisseur_id=$this->request->data['Relevefournisseur']['fournisseur_id'];
                        $cond3='Bonreception.fournisseur_id='.$fournisseur_id;
                        $cond3f='Facture.fournisseur_id='.$fournisseur_id;
                        $cond8='Reglement.fournisseur_id='.$fournisseur_id;
                    }
                    $reg=@$this->request->data['Relevefournisseur']['reg'];
                    if($reg!=""){
                    if($reg=='0'){
                    $cond7 = array('(Bonreception.Montant_Regler)= Bonreception.totalttc'); 
                    $cond9 = array('(Facture.Montant_Regler)= Facture.totalttc');
                    //$cond7="";
                    }
                    if ($reg=='1') {
                    $cond7 = array('(Bonreception.Montant_Regler)<Bonreception.totalttc');
                    }
                    }
                    if(!empty($this->request->data['Relevefournisseur']['fournisseur_id'])&& $reg!='0'){
                    $bonreception=$this->Bonreception->find('all',array('conditions'=>array($cond1,$cond2,$cond3,$cond,$cond7)));
                   // debug($bonreception);die;
                    foreach ($bonreception as $bl){
                        $data=array();
                        $data1=array();
                        if($bl['Bonreception']['facture_id'] == 0){
                                $data['Type']='BL';
                                $data['Date']=$bl['Bonreception']['date'];
                                if ($reg==1){
                                    $data['Montant']=$bl['Bonreception']['totalttc']-$bl['Bonreception']['Montant_Regler'];
                                } else {
                                    $data['Montant']=$bl['Bonreception']['totalttc'];
                                }
                                $data['Numero']=$bl['Bonreception']['numero'];  
                           
                        } else  {
                       
                        $data['Type']='FAC';
                        $data['Date']=$bl['Facture']['date'];
                        if ($reg==1){
                                    $data['Montant']=$bl['Facture']['totalttc']-$bl['Facture']['Montant_Regler'];
                                } else {
                                    $data['Montant']=$bl['Facture']['totalttc'];
                                }
                        $data['Numero']=$bl['Facture']['numero'];
                        }
                        //debug($data);die;
                        $relev = $this->Relevefournisseur->find('all',array('conditions'=>array('Relevefournisseur.Type'=>$data['Type'],'Relevefournisseur.Numero'=>$data['Numero']),'recursive'=>-1));
                                if ($relev==array()){
                        
                        $this->Relevefournisseur->create();
                        $this->Relevefournisseur->save($data);
                                }
                    }
                    //debug($bonreception);die;
                     if($reg!='1'){
                    $reglement=$this->Reglement->find('all',array('conditions'=>array($cond5,$cond6,$cond8)));
                    //debug($reglement);die;
                    foreach ($reglement as $reg){
                        $mode="";$mm="";$nb_esp=0;$nb_chq=0;$nb_tr=0;$nb_vir=0;
                        foreach($reg['Piecereglement'] as $piece){
                            if(($piece['paiement_id']==1)){
                                $esp='Espèces';
                                $nb_esp=$nb_esp+1;
                            }
                            if(($piece['paiement_id']==2)){
                                $chq='Chèque';
                                $chqs='Chèques';
                                $nb_chq=$nb_chq+1;
                            }
                            if(($piece['paiement_id']==3)){
                                $tr='Traite';
                                $trs='Traites';
                                $nb_tr=$nb_tr+1;
                            }
                            if(($piece['paiement_id']==4)){
                                $vir='Virement';
                                $virs='Virements';
                                $nb_vir=$nb_vir+1;
                            }
                             
                            if($nb_esp ==0){ $m_esp="";}
                            if($nb_esp >0){ $m_esp=$esp;}
                            
                            if($nb_chq ==0){ $m_chq="";}
                            if($nb_chq ==1){ $m_chq=$nb_chq.$chq;}
                            if($nb_chq >1){ $m_chq=$nb_chq.$chqs;}
                            
                            if($nb_tr ==0){ $m_tr="";}
                            if($nb_tr ==1){ $m_tr=$nb_tr.$tr;}
                            if($nb_tr >1){ $m_tr=$nb_tr.$trs;}
                            
                            if($nb_vir ==0){ $m_vir="";}
                            if($nb_vir ==1){ $m_vir=$nb_vir.$vir;}
                            if($nb_vir >1){ $m_vir=$nb_vir.$virs;}
                            
                            $cep1='';$cep2='';$cep3='';
                            if(($nb_esp>0)&&($nb_chq>0 || $nb_tr>0 || $nb_vir>0 )){
                                $cep1='+';
                            }
                            if(($nb_chq>0)&&($nb_tr>0 || $nb_vir>0)){
                                $cep2='+';
                            }
                            if(($nb_tr>0)&&($nb_vir>0)){
                                $cep3='+';
                            }  
                             $mode=@$m_esp.@$cep1.@$m_chq.@$cep2.@$m_tr.@$cep3.@$m_vir;
                        }
                       
                        
                        $data=array();
                       
                        $data['Type']='REG';
                        $data['Date']=$reg['Reglement']['Date'];
                        $data['Numero']=@$reg['Reglement']['numero'];
                        $data['Montant']=$reg['Reglement']['Montant'];
                        $data['mode']=$mode;
                        $this->Relevefournisseur->create();
                        $this->Relevefournisseur->save($data);
                    }
                     }}
                     
                    //------- Ligne reglement pour Les Blnoir et factures réglés----------------------------------------------------- 
                    if(!empty($this->request->data['Relevefournisseur']['fournisseur_id'])&& $reg=='0'){
                   
                    $lignereg=array();$idreg="";$i=0;$j=0;

                if (@$lignereglementfac!=array()){
                foreach (@$lignereglementfac as $k=>$ligne){
                    //debug($ligne);die;
                    if($ligne['Reglement']['id']!=$idreg){$j++;
                       $lignereg[$j]['Reglement']=$ligne['Reglement'];
                       $idreg=$ligne['Reglement']['id'];
                       $i=0;
                    }
                    if($ligne['Reglement']['id']==$idreg){
                        $lignereg[$j]['Reglement']['bonl'][$i]['Bonreception']=$ligne['Facture'];
                        $i++;
                    }
                } 
                }
                 //debug($lignereg);die;  
                
                   //-----------------------------------------------------------------------------
                foreach ($lignereg as $ligner) {
                    //debug($ligner['Reglement']['bonl']);die;
                        foreach ($ligner['Reglement']['bonl'] as $bl){
                            //debug($bl);die;
                            $data=array();
                            if ($ligner['Reglement']['type']==0){
                            $data['Type']='FAC';
                              
                            } else { 
                            $data['Type']='BLnoir';    
                            }
                            $data['Date']=$bl['Bonreception']['date'];
                            $data['Montant']=$bl['Bonreception']['totalttc'];
                            $data['Numero']=$bl['Bonreception']['numero'];
                               //debug($data);die;
                            $relev = $this->Relevefournisseur->find('all',array('conditions'=>array('Relevefournisseur.Type'=>$data['Type'],'Relevefournisseur.Numero'=>$data['Numero']),'recursive'=>-1));
                                if ($relev==array()){
                                $this->Relevefournisseur->create();
                                $this->Relevefournisseur->save($data);
                                }
                        }
                   
                    //debug($ligner['Reglement']['Piecereglement']);die; 
                        
                        $mode="";$mm="";$nb_esp=0;$nb_chq=0;$nb_tr=0;$nb_vir=0;
                        foreach($ligner['Reglement']['Piece'] as $piece){
                            if(($piece['paiement_id']==1)){
                                $esp='Espèces';
                                $nb_esp=$nb_esp+1;
                            }
                            if(($piece['paiement_id']==2)){
                                $chq='Chèque';
                                $chqs='Chèques';
                                $nb_chq=$nb_chq+1;
                            }
                            if(($piece['paiement_id']==3)){
                                $tr='Traite';
                                $trs='Traites';
                                $nb_tr=$nb_tr+1;
                            }
                            if(($piece['paiement_id']==4)){
                                $vir='Virement';
                                $virs='Virements';
                                $nb_vir=$nb_vir+1;
                            }
                             
                            if($nb_esp ==0){ $m_esp="";}
                            if($nb_esp >0){ $m_esp=$esp;}
                            
                            if($nb_chq ==0){ $m_chq="";}
                            if($nb_chq ==1){ $m_chq=$nb_chq.$chq;}
                            if($nb_chq >1){ $m_chq=$nb_chq.$chqs;}
                            
                            if($nb_tr ==0){ $m_tr="";}
                            if($nb_tr ==1){ $m_tr=$nb_tr.$tr;}
                            if($nb_tr >1){ $m_tr=$nb_tr.$trs;}
                            
                            if($nb_vir ==0){ $m_vir="";}
                            if($nb_vir ==1){ $m_vir=$nb_vir.$vir;}
                            if($nb_vir >1){ $m_vir=$nb_vir.$virs;}
                            
                            $cep1='';$cep2='';$cep3='';
                            if(($nb_esp>0)&&($nb_chq>0 || $nb_tr>0 || $nb_vir>0 )){
                                $cep1='+';
                            }
                            if(($nb_chq>0)&&($nb_tr>0 || $nb_vir>0)){
                                $cep2='+';
                            }
                            if(($nb_tr>0)&&($nb_vir>0)){
                                $cep3='+';
                            }  
                             $mode=@$m_esp.@$cep1.@$m_chq.@$cep2.@$m_tr.@$cep3.@$m_vir;
                        }
//debug($ligner['Reglement']);die;
                       
                        $data['Type']='REG';
                       
                        $data['Date']=$ligner['Reglement']['date'];
                        $data['Montant']=0;
                        foreach ($ligner['Reglement']['Lignereglement'] as $l){
                        $data['Montant']+=$l['montant'];
                        }
                        $data['Numero']=$ligner['Reglement']['numero'];
                        $data['mode']=$mode;
                        $this->Relevefournisseur->create();
                        $this->Relevefournisseur->save($data);
                    }
                }   
                    
                    $relevefournisseurs=$this->Relevefournisseur->find('all',array('fields' => array('Relevefournisseur.Type', 'Relevefournisseur.Date', 'SUM(Relevefournisseur.Montant) Montant', 'Relevefournisseur.Numero', 'Relevefournisseur.mode'),'group' => array('Relevefournisseur.type','Relevefournisseur.Numero'),'order'=>array('Relevefournisseur.Date','Relevefournisseur.Type')));
                    
                    $solde_initial = 0.000;
                    
                    
                    if($this->request->data['Relevefournisseur']['Date_debut'] != '__/__/____'){
                    $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Relevefournisseur']['Date_debut'])));
                    
                    $total_bonlivrason_noirs = $this->Bonreception->find('all',array('fields'=>array('sum(Bonreception.totalttc) as total_bl'),
                        'conditions'=>array('Bonreception.date <'."'".$Date_debut."'",$cond3,'Bonreception.facture_id'=>0)));
                    
                    $total_factures = $this->Facture->find('all',array('fields'=>array('sum(Facture.totalttc) as total_fact'),
                        'conditions'=>array('Facture.date <'."'".$Date_debut."'",$cond3f)));
                    
                    
                    $total_reglements = $this->Reglement->find('all',array('fields'=>array('sum(Reglement.Montant) as total_reglement'),
                        'conditions'=>array('Reglement.date <'."'".$Date_debut."'",$cond8)));
                    
                    $solde_initial = $solde_initial + $total_bonlivrason_noirs[0][0]['total_bl'] + $total_factures[0][0]['total_fact'] -  $total_reglements[0][0]['total_reglement'];
                    } 
                    else {
                        $solde_initial = $solde_initial;
                    }
                    
                    $solde = array();
                    $solde['Type'] = "Solde initial";
                    $solde['Montant'] = $solde_initial;
                    $this->Relevefournisseur->create();
                    $this->Relevefournisseur->save($solde);
                    
               // debug($relevefournisseurs);die;
                    $this->set(compact('solde_initial','bonlivraison','reglement','relevefournisseurs','Date_debut','Date_fin','fournisseur_id','marque_id','regs'));
		    
                 }
                
                $regs=array();
                $regs[0]='Reglé';
                $regs[1]='Non reglé';
                $fournisseurs = $this->Fournisseur->find('list');
                $this->set(compact('regs','fournisseurs'));
	}
        
        public function index($frs_id=null,$societeid=null,$next=null) {
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
            $this->loadModel('Client');
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
            $transferts=array();
            $this->Relevefournisseur->query('TRUNCATE relevefournisseurs;');
            $sldini=0;CakeSession::delete('soldeint');
            
//            if(!empty($frs_id)){
//            $this->request->data['Recherche'] = CakeSession::read('releve');  
//            //debug($this->request->data);
//            }
            
            if ((!empty($this->request->data))||(!empty($frs_id)) ){               // debug("data");
            if (!empty($this->request->data)){
              $frs_id=null;
              $societeid=null;
              $next=null;
            }else{
            $this->request->data['Recherche']['date1']='01/01/2000'; 
            $this->request->data['Recherche']['date2']=date('d/m/Y');
            $this->request->data['Recherche']['societe_id']=$societeid;
            $this->request->data['Recherche']['fournisseur_id']=$frs_id;
            } 
           
            //CakeSession::write('releve', $this->request->data['Recherche']);
            
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
            $condbr1 = 'Reglement.date >= '."'".$date1."'";
            $condtr1 = 'Transfert.date >= '."'".$date1."'";
            
            $condb1anc = 'Bonreception.date < '."'".$date1."'";
            $condf1anc = 'Facture.date < '."'".$date1."'";
            $condfa1anc = 'Factureavoirfr.date < '."'".$date1."'";
            $condbr1anc = 'Reglement.date < '."'".$date1."'";
            $condtr1anc = 'Transfert.date < '."'".$date1."'";
           
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
            $condbr2 = 'Reglement.date <= '."'".$date2."'";
            $condtr2 = 'Transfert.date <= '."'".$date2."'";
            $condb4="";
            $condf4="";
            $condfa4="";
            $condr4="";
            
            
        }    
          
        if ($this->request->data['Recherche']['societe_id']) {
            if(!empty($societeid)){
            $p=  $societeid;
            $this->request->data['Recherche']['societe_id']=$societeid;
            $Soc= $this->Societe->find('first',array('conditions'=>array('Societe.id'=>$societeid),false));
            $ab_soc=$Soc['Societe']['composantsoc'];
            }else{
            $societeid= $this->request->data['Recherche']['societe_id'];
            $pointventes= $this->Pointdevente->find('all',array('conditions'=>array('Pointdevente.societe_id'=>$societeid),false));
            $p = '0';
                foreach ($pointventes as $ad) {
                    if(!empty($ad['Pointdevente']['id'])){
                    $p = $p . ',' . $ad['Pointdevente']['id'];
                }}
            $p = $p;
            }
            $condb6 = "Bonreception.pointdevente_id in (" . $p . ")";
            $condf6 = "Facture.pointdevente_id in (" . $p . ")";
            $condfa6="Factureavoirfr.pointdevente_id in (" . $p . ")";
            $condr6 = "Reglement.pointdevente_id in (" . $p . ")";
            $condtr6 = 'Transfert.societearrive ='.$societeid;
        }
        
        
        
         if ($this->request->data['Recherche']['fournisseur_id']) {
           // debug("d5al");
            if(!empty($frs_id)){
                $clientid=$frs_id;
               if(!empty($next)){ 
            $frss = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id'=>$frs_id)));
            $nextfrs = $this->Relevefournisseur->query('SELECT * from fournisseurs where societe="'.$ab_soc.'" and  cast(code as signed) =cast('.$frss['Fournisseur']['code'].' as signed)+1');
            //debug($nextfrs);
            $clientid=   $nextfrs[0]['fournisseurs']['id']; 
               } 
            $this->request->data['Recherche']['fournisseur_id']=$clientid;
            //debug("****".$this->request->data['Recherche']['fournisseur_id']);
            //debug("****".$clientid);
            }else{
            $clientid= $this->request->data['Recherche']['fournisseur_id'];
            }
            
//            $condb3 = 'Bonreception.fournisseur_id ='.$clientid;
//            $condf3 = 'Facture.fournisseur_id ='.$clientid;
//            $condfa3='Factureavoirfr.fournisseur_id ='.$clientid;
//            $condr3 = 'Reglement.fournisseur_id ='.$clientid;
//            $frs = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id'=>$clientid)));
//            $sldini=@$sldini+$frs['Fournisseur']['solde'];
//            $devise_id=$frs['Fournisseur']['devise_id'];
//            $condtr3 = 'Transfert.societedepart ='.$frs['Fournisseur']['societe_id'];
//            $condb3 = 'Bonreception.fournisseur_id =' . $clientid;
            
                    
                    $frs = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $clientid)));
                    $condb3 = 'Bonreception.fournisseur_id ='.$clientid;
                    $condf3 = 'Facture.fournisseur_id =' . $clientid;
                    $condfa3 = 'Factureavoirfr.fournisseur_id =' . $clientid;
                    $condr3 = 'Reglement.fournisseur_id =' . $clientid;
                    $condtr3 = 'Transfert.societedepart =' . $frs['Fournisseur']['societe_id'];
                    $devise_id = $frs['Fournisseur']['devise_id'];
                    $sldini = $frs['Fournisseur']['solde'];
                    
                    
                    $factureavoirancs = $this->Factureavoirfr->find('first', array(
                        'fields' => array('sum(Factureavoirfr.totalttc) as solde'),
                        'conditions' => array(@$condfa1anc, @$condfa3, @$condfa6), 'recursive' => 0));
                    //debug($factureavoirancs);
                    $bonlivraisonancs = $this->Bonreception->find('first', array(
                        'fields' => array('sum(Bonreception.totalttc) as solde'),
                        'conditions' => array('Bonreception.facture_id' => 0, @$condb1anc, @$condb3, @$condb6), 'recursive' => 0));
                    //debug($bonlivraisonancs);     
                    $factureclientancs = $this->Facture->find('first', array(
                        'fields' => array('sum(Facture.totalttc) as solde'),
                        'conditions' => array(@$condf1anc, @$condf3, @$condf6), 'recursive' => 0));
                    //debug($factureclientancs);    

                    $piecereglementancs =$this->Piecereglement->find('first', array('contain' => array('Reglement', 'Paiement')
                        , 'fields' => array('sum(Piecereglement.montant) as solde')
                        , 'conditions' => array(@$condbr1anc, @$condr3, @$condr6), 'recursive' => 2));

                    //debug($piecereglementancs);   

                    $piecereglementimpancs = $this->Piecereglement->find('first', array('contain' => array('Reglement', 'Paiement'),
                        'fields' => array('sum(Piecereglement.montant) as solde')
                        , 'conditions' => array('Piecereglement.id > 0', 'Piecereglement.situation="Impayé"', @$condbr1anc, @$condr3, @$condr6), 'recursive' => 2));
                    //debug($piecereglementimpancs);  

                    $soldetransfert = $this->Transfert->find('first', array(
                        'fields' => array('sum(Transfert.totttc) as solde'),
                        'conditions' => array(@$condtrs, $condtr3, $condtr6, 'Transfert.fact_achat=0'), 'recursive' => 0));
                    if (!empty($soldetransfert)) {
                        $sldini = $sldini + $soldetransfert[0]['solde'];
                    }
                    //debug($soldetransfert);

                    $sldini = $sldini - $factureavoirancs[0]['solde'];
                    $sldini = $sldini + $factureclientancs[0]['solde'];
                    $sldini = $sldini + $bonlivraisonancs[0]['solde'];
                    $sldini = $sldini - $piecereglementancs[0]['solde'];
                    $sldini = $sldini + $piecereglementimpancs[0]['solde'];

            
            
            
            
            
        }
        
         

        
        
        
       
            $factureavoirs=$this->Factureavoirfr->find('all', array(
            'conditions' => array('Factureavoirfr.typefacture_id!=8',@$condfa1,@$condfa2,@$condfa3,@$condfa4,@$cond5,@$condfa6),'recursive'=>-1 ));
            foreach ($factureavoirs as $factureavoir) {
                $tablignedevis['fournisseur_id']=$factureavoir['Factureavoirfr']['fournisseur_id'];
                $tablignedevis['date']=$factureavoir['Factureavoirfr']['date'];
                $tablignedevis['numero']=$factureavoir['Factureavoirfr']['numero'];
                $tablignedevis['type']="Facture avoir ".' : '.$factureavoir['Factureavoirfr']['numero'];;
                $tablignedevis['debit']="";
                $tablignedevis['echeance']="";
                $tablignedevis['typ']="FR";
                $tablignedevis['credit']=$factureavoir['Factureavoirfr']['totalttc'];
                $this->Relevefournisseur->create();
                $this->Relevefournisseur->save($tablignedevis);
                }

            $bonlivraisons= $this->Bonreception->find('all', array('conditions' => array(
            'Bonreception.id > 0' ,'Bonreception.facture_id'=>0,@$condb1,@$condb2,@$condb3,@$condb4,@$cond5,@$condb6 ),'recursive'=>-1 ));
            foreach ($bonlivraisons as $bonlivraison) {
                $des="Bon de Livraison".' : '.$bonlivraison['Bonreception']['numerofrs'];
                if($bonlivraison['Bonreception']['nature']=="achat"){
                    $des="Bon de Livraison".' : '.$bonlivraison['Bonreception']['numerofrs'];
                }
                if($bonlivraison['Bonreception']['nature']=="entree"){
                    $des="Bon d'entree".' : '.$bonlivraison['Bonreception']['numerofrs'];
                }
                $tablignelivraisons['fournisseur_id']=$bonlivraison['Bonreception']['fournisseur_id'];
                $tablignelivraisons['date']=$bonlivraison['Bonreception']['date'];
                $tablignelivraisons['numero']=$bonlivraison['Bonreception']['numerofrs'];
                $tablignelivraisons['type']=$des;
                $tablignelivraisons['debit']=$bonlivraison['Bonreception']['totalttc'];
                $tablignelivraisons['credit']="";
                $tablignelivraisons['impaye']="";
                $tablignelivraisons['echeance']="";
                $tablignelivraisons['reglement']="";
                $tablignelivraisons['typ']="BL";
                $tablignelivraisons['avoir']="";
                $this->Relevefournisseur->create();
                $this->Relevefournisseur->save($tablignelivraisons);
                }
            
            $factureclients = $this->Facture->find('all', array('conditions' => array(
            'Facture.id > 0',@$condf1,@$condf2,@$condf3,@$condf4,@$cond5,@$condf6),'recursive'=>-1));
            
            foreach ($factureclients as $factureclient) {
                $des="Fature".' : '.$factureclient['Facture']['numerofrs'];
                if($factureclient['Facture']['nature']=="achat"){
                    $des="Fature".' : '.$factureclient['Facture']['numerofrs'];
                }
                if($factureclient['Facture']['nature']=="depense"){
                    $des="Dèpense".' : '.$factureclient['Facture']['numerofrs'];
                }
                //debug($factureclient);die;
                $tablignefactureclients['fournisseur_id']=$factureclient['Facture']['fournisseur_id'];
                $tablignefactureclients['date']=$factureclient['Facture']['date'];
                $tablignefactureclients['numero']=$factureclient['Facture']['numerofrs'];
                $tablignefactureclients['type']=$des;
                $tablignefactureclients['debit']=$factureclient['Facture']['totalttc'];
                $tablignefactureclients['credit']="";
                $tablignefactureclients['impaye']="";
                $tablignefactureclients['echeance']="";
                $tablignefactureclients['reglement']="";
                $tablignefactureclients['avoir']="";
                 $tablignefactureclients['typ']="Fac";
                $this->Relevefournisseur->create();
                $this->Relevefournisseur->save($tablignefactureclients);
                }
            $reglementlibres = $this->Reglement->find('all', array('conditions' => array(
            'Reglement.id > 0','Reglement.libre'=>1,@$condbr1,@$condbr2,@$condr3,@$condr4,@$cond5),'recursive'=>0));
            
            
            
    $piecereglements = $this->Piecereglement->find('all', array('contain' => array('Reglement','Paiement'),'conditions' => array(
    @$condbr1,@$condbr2,@$condr3,@$condr4,@$cond5),'recursive'=>0));   
    foreach ($piecereglements as $piecereglement) {
                $tablignepiecereglements['fournisseur_id']=$piecereglement['Reglement']['fournisseur_id'];
                $tablignepiecereglements['date']=$piecereglement['Reglement']['Date'];
                $tablignepiecereglements['numero']=$piecereglement['Reglement']['numeroconca'];
                $tablignepiecereglements['type']="Reglement ".$piecereglement['Paiement']['name'].' : '.$piecereglement['Piecereglement']['num'];
                $tablignepiecereglements['debit']="";
                $tablignepiecereglements['credit']=$piecereglement['Piecereglement']['montant'];
                $tablignepiecereglements['echeance']=date("d/m/Y", strtotime(str_replace('-', '/',$piecereglement['Piecereglement']['echance'])));
                $tablignepiecereglements['impaye']="";
                $tablignepiecereglements['reglement']="";
                $tablignepiecereglements['avoir']="";
                $tablignereglementlibres['typ']="Reg";
                $this->Relevefournisseur->create();
                $this->Relevefournisseur->save($tablignepiecereglements);
                }
    
//    $piecereglements = $this->Piecereglement->find('all', array('contain' => array('Reglement','Paiement'),'conditions' => array(
//    'Piecereglement.reglefournisseur =1',@$condbr1,@$condbr2,@$condr3,@$condr4,@$cond5),'recursive'=>2));   
//     
//     foreach ($piecereglements as $piecereglement) {
//                $tablignepiecereglements['fournisseur_id']=$piecereglement['Reglement']['fournisseur_id'];
//                $tablignepiecereglements['date']=$piecereglement['Reglement']['Date'];
//                $tablignepiecereglements['numero']=$piecereglement['Reglement']['numeroconca']." / ".$piecereglement['Reglement']['exercice_id'];
//                $tablignepiecereglements['type']="Reglement ".$piecereglement['Paiement']['name'].' : '.$piecereglement['Piecereglement']['num'];;
//                $tablignepiecereglements['debit']="";
//                $tablignepiecereglements['credit']=$piecereglement['Piecereglement']['montant'];
//                $tablignepiecereglements['echeance']=date("d/m/Y", strtotime(str_replace('-', '/',$piecereglement['Piecereglement']['echance'])));
//                $tablignepiecereglements['impaye']="";
//                $tablignepiecereglements['reglement']="";
//                $tablignepiecereglements['avoir']="";
//                $tablignereglementlibres['typ']="Reg";
//                $this->Relevefournisseur->create();
//                $this->Relevefournisseur->save($tablignepiecereglements);
//                }
     
      $piecereglementimps = $this->Piecereglement->find('all', array('contain' => array('Reglement','Paiement'),'conditions' => array(
            'Piecereglement.id > 0','Piecereglement.etatpiecereglement_id=4',@$condbr1,@$condbr2,@$condr3,@$condr4,@$cond5),'recursive'=>0));   
        foreach ($piecereglementimps as $piecereglementimp) {
                $tablignepiecereglementimps['fournisseur_id']=$piecereglementimp['Reglement']['fournisseur_id'];
                $tablignepiecereglementimps['date']=$piecereglementimp['Piecereglement']['datesituation'];
                $tablignepiecereglementimps['numero']=$piecereglementimp['Reglement']['numeroconca'];
                $tablignepiecereglementimps['type']="Reglement ".$piecereglementimp['Paiement']['name'].' : '.$piecereglementimp['Piecereglement']['num'];
                $tablignepiecereglementimps['debit']=$piecereglementimp['Piecereglement']['montant'];
                $tablignepiecereglementimps['credit']="";
                $tablignepiecereglementimps['echeance']=date("d/m/Y", strtotime(str_replace('-', '/',$piecereglementimp['Piecereglement']['echance'])));
                $tablignepiecereglementimps['impaye']="";
                $tablignepiecereglementimps['reglement']="";
                $tablignepiecereglementimps['avoir']="";
                $tablignereglementlibres['typ']="Reg";
                $this->Relevefournisseur->create();
                $this->Relevefournisseur->save($tablignepiecereglementimps);
                }
                
            $transferts = $this->Transfert->find('all', array('conditions' => array(
            'Transfert.fact_achat=0',@$condtr1,@$condtr2,@$condtr3,@$condtr4,@$condtr6),'recursive'=>-1));  
            //debug($transferts);die;
            foreach ($transferts as $transfert) {
            $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id'=>$transfert['Transfert']['societedepart'])));
                $tablignetransfert['fournisseur_id']=$fournisseur['Fournisseur']['id'];
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
                $this->Relevefournisseur->create();
                $this->Relevefournisseur->save($tablignetransfert);
                }        
                
                
                
                
                
                
            
     
      }
        //CakeSession::write('soldeint',$sldini);
        //$fournisseurs = $this->Fournisseur->find('list', array('order'=>array('Fournisseur.code'=>'asc'))); 
      $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Fournisseur->find('list', array(
            'conditions' => array(
                'Fournisseur.societe'=>$composantsoc
                ), 'order' => array('Fournisseur.code' => 'asc')
        ));
        $personnels = $this->Personnel->find('list');
        $societes = $this->Societe->find('list'); 
        $relefes=$this->Relevefournisseur->find('all', array('order'=>array('Relevefournisseur.date,Relevefournisseur.fournisseur_id'=>'asc'),'recursive'=>0 )); 
        //debug($relefes);die;
        $this->set(compact('sldini','societeid','clientid','condtr6','condtr1anc','condbr1anc','condbr2','condr3','condr6','condf1anc','condf2','condf3','condf6','condb1anc','condb2','condb3','condb6','condfa1anc','condfa2','condfa3','condfa6','societes','sldini','relefes','piecereglements','piecereglementimps','sldini','factureavoirs','bonlivraisons','factureclients','reglementlibres','articles','fournisseurs','personnels','exercices','exerciceid','date1','client_id','marque_id','date2','name'));
    
   }
   
   
        public function indextotale() {
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
        $all_frss = array();
$composantsoc = CakeSession::read('composantsoc');

        if ($this->request->is('post')) {

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
            $condbr1 = 'Reglement.date >= '."'".$date1."'";
            $condtr1 = 'Transfert.date >= '."'".$date1."'";
            
            $condb1anc = 'Bonreception.date < '."'".$date1."'";
            $condf1anc = 'Facture.date < '."'".$date1."'";
            $condfa1anc = 'Factureavoirfr.date < '."'".$date1."'";
            $condbr1anc = 'Reglement.date < '."'".$date1."'";
            $condtr1anc = 'Transfert.date < '."'".$date1."'";
           
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
            $condbr2 = 'Reglement.date <= '."'".$date2."'";
            $condtr2 = 'Transfert.date <= '."'".$date2."'";
            $condb4="";
            $condf4="";
            $condfa4="";
            $condr4="";
            
            
        }    
                    
         

            if ($this->request->data['Recherche']['fournisseur_id']) {
                $fournisseur_id = $this->request->data['Recherche']['fournisseur_id'];
                $frs= $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$fournisseur_id),false));
                $cond = 'Fournisseur.code >=' . $frs['Fournisseur']['code'];
            }
            if ($this->request->data['Recherche']['fournisseur2_id']) {
                $fournisseur_id2 = $this->request->data['Recherche']['fournisseur2_id'];
                $frs2= $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$fournisseur_id2),false));
                $cond2 = 'Fournisseur.code <=' . $frs2['Fournisseur']['code'];
            }







            //debug($all_clients);die; 

            $all_frss = $this->Fournisseur->find('all', array('recursive' => -1, 'conditions' => array(@$cond,@$cond2,'Fournisseur.societe'=>$composantsoc), 'order' => array('Fournisseur.code' => 'asc')));

              //debug($all_frss);die;
        }
        
        $fournisseurs = $this->Fournisseur->find('list', array(
            'conditions' => array(
                'Fournisseur.societe'=>$composantsoc
                ), 'order' => array('Fournisseur.code' => 'asc')
        ));
        $fournisseur2s = $this->Fournisseur->find('list', array(
            'conditions' => array(
                'Fournisseur.societe'=>$composantsoc
                ), 'order' => array('Fournisseur.code' => 'asc')
        ));
        //$clients = $this->Client->find('list');
        //$client2s = $this->Client->find('list');
        $personnels = $this->Personnel->find('list');
        $this->set(compact('fournisseur2s','condss', 'condbbs', 'condfas', 'condfs', 'condbs', 'condss2', 'condbb2', 'condf2', 'condb2', 'condfa2', 'condss1', 'condbb1', 'condf1', 'condb1', 'condfa1', 'all_frss', 'relefes', 'soldeint', 'solde', 'clientid', 'c5', 'c4', 'c3', 'c2', 'c1', 'piecereglements', 'factureavoirs', 'bonlivraisons', 'factureclients', 'reglementlibres', 'articles', 'fournisseurs', 'personnels', 'exercices', 'exerciceid', 'date1', 'clientid', 'marque_id', 'date2', 'name'));
    }


	public function view($id = null) {
		if (!$this->Relevefournisseur->exists($id)) {
			throw new NotFoundException(__('Invalid relefe'));
		}
		$options = array('conditions' => array('Relevefournisseur.' . $this->Relevefournisseur->primaryKey => $id));
		$this->set('relefe', $this->Relevefournisseur->find('first', $options));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->Relevefournisseur->create();
			if ($this->Relevefournisseur->save($this->request->data)) {
				$this->Session->setFlash(__('The relefe has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The relefe could not be saved. Please, try again.'));
			}
		}
	}

	public function edit($id = null) {
		if (!$this->Relevefournisseur->exists($id)) {
			throw new NotFoundException(__('Invalid relefe'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Relevefournisseur->save($this->request->data)) {
				$this->Session->setFlash(__('The relefe has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The relefe could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Relevefournisseur.' . $this->Relevefournisseur->primaryKey => $id));
			$this->request->data = $this->Relevefournisseur->find('first', $options);
		}
	}

	public function delete($id = null) {
		$this->Relevefournisseur->id = $id;
		if (!$this->Relevefournisseur->exists()) {
			throw new NotFoundException(__('Invalid relefe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Relevefournisseur->delete()) {
			$this->Session->setFlash(__('Relevefournisseur deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Relevefournisseur was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        public function imprimerrecherche() {
        $lien=  CakeSession::read('lien_achat');
               $utilisateur="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='relevefournisseurs'){
                        $utilisateur=$liens['imprimer'];
                }}}
              if (( $utilisateur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
       if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
           
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
           
        }
        
       if ($this->request->query['name']) {
            $name = $this->request->query['name'];
            
        } 
        $relefes=$this->Relevefournisseur->find('all', array('order'=>array('Relevefournisseur.date,Relevefournisseur.typ'=>'asc'),'recursive'=>0 ));    
        $soldeint=CakeSession::read('soldeint');
        $this->set(compact('soldeint','relefes','date1','date2','name'));
    }
        
}
