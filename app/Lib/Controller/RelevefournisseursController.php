<?php
App::uses('AppController', 'Controller');



class RelevefournisseursController extends AppController {


	public function index() {
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
        
        public function  imprimerrecherche(){
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
              $this->loadModel('Relevefournisseur');
              $this->loadModel('Fournisseur'); 
              $Date_debut="";$Date_fin="";
              //debug($this->request->query);die;
                    if(!empty($this->request->query['Date_debut'])){
                    $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_debut'])));
                    }
                    if(!empty($this->request->query['Date_fin'])){
                    $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_fin'])));
                    }
                    
                    $reg=$this->request->query['reg'];
                    
                    $fournisseur_id=$this->request->query['fournisseur_id'];
                    
//                    $remisec=$this->request->query['remisec'];
//                    $typpp=$this->request->query['typpp'];
                    $netapayer=$this->request->query['netapayer'];
                    $cc="";
                   //debug($fournisseur_id);
                    if(!empty($fournisseur_id)){
                    $fournisseurs = $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$fournisseur_id)));
                    $cc=$fournisseurs['Fournisseur']['name'];
                    
                    }
                     
                     
                    //debug($remisec);die;
                     if($reg=='0'){
                        $relevefournisseurs=$this->Relevefournisseur->find('all',array('order'=>array('Relevefournisseur.Date','Relevefournisseur.Type'),
                            'conditions'=>array('Relevefournisseur.Type <> "Solde initial"')));
                     }
                     else
                     {
                        $relevefournisseurs=$this->Relevefournisseur->find('all',array('order'=>array('Relevefournisseur.Date','Relevefournisseur.Type'),
                            'conditions'=>array('Relevefournisseur.Type <> "Solde initial"')));
                     }
                     //debug($relevefournisseurs);
                     $solde = $this->Relevefournisseur->find('first',array('conditions'=>array('Relevefournisseur.Type = "Solde initial"')));
                     $soldeinitial = $solde['Relevefournisseur']['Montant'];
//debug($solde);die;
                    $this->set(compact('soldeinitial','netapayer','typpp','bonlivraison','reglement','relevefournisseurs','remisec','Date_debut','Date_fin','reg','fournisseur_id','marque_id','cc','mm'));
        }
        
}
