<?php

App::uses('AppController', 'Controller');


class AffectationsController extends AppController {
   
    public function index() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Famille');
        $this->loadModel('Client');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Ligneclient');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $pointdeventes = $this->Pointdevente->find('list');
       $exercices = $this->Exercice->find('list');
       $exe=date('Y');
       $exercice = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
       $exerciceid=$exercice['Exercice']['id'];
        $conde = 'Affectation.exercice_id ='.$exe;
        $pv="";
       $p=CakeSession::read('pointdevente');
       if($p>0){
          $pv= 'Affectation.pointdevente_id = '.$p;
       }
        $clients = $this->Client->find('list');
        if ($this->request->is('post') || $this->request->is('put')) {
            //  debug($this->request->data);//die;
           
            if ($this->request->data['Affectation']['Date_debut'] != '__/__/____') {
                $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Affectation']['Date_debut'])));
                $cond = 'Affectation.date>=' . "'" . $Date_debut . "'";
            }
            if ($this->request->data['Affectation']['Date_fin'] != '__/__/____') {
                $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Affectation']['Date_fin'])));
                $cond1 = 'Affectation.date<=' . "'" . $Date_fin . "'";
            }

            if ($this->request->data['Affectation']['client_id']) {
                $client_id = $this->request->data['Affectation']['client_id'];
                $cond3 = 'Affectation.client_id=' . $client_id;
            }
             if ($this->request->data['Affectation']['exercice_id']) {
            $exerciceid = $this->request->data['Affectation']['exercice_id'];
            $cond4 = 'Affectation.exercice_id ='.$exercices[$exerciceid];
             } 
        if (!empty($this->request->data['Affectation']['pointdevente_id'])) {
            $pointdeventeid = $this->request->data['Affectation']['pointdevente_id'];
            $cond5 = 'Affectation.pointdevente_id ='.$pointdeventeid;
        } 
        } 

         $affectations = $this->Affectation->find('all', array( 'conditions' => array('Affectation.id > ' => 0,@$pv,@$cond,@$conde, @$cond1, @$cond2, @$cond3, @$cond4,@$cond5)));

            $this->set(compact('affectations','collections', 'transferecommandebls', 'marques', 'familles', 'clients', 'ligneclients', 'Date_debut', 'marque_id', 'Date_fin', 'client_id','exerciceid', 'num_recu','pointdeventes','exercices'));
        
    }
  
    public function imprimerrecherche() {
        $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='reglementclients'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
//               $this->loadModel('Marque'); 
        $this->loadModel('Reglementclient');
        $this->loadModel('Client');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Ligneclient');
        // debug($this->request->query);die;
        $cond = '';
        $cond1 = '';
        $cond2 = '';
        $cond3 = '';
        $cond4 = '';
        if (!empty($this->request->query['Date_debut'])) {
            $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_debut'])));
            $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
        }
        if (!empty($this->request->query['Date_fin'])) {
            $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_fin'])));
            $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
        }

        if (!empty($this->request->query['client_id'])) {
            $client_id = $this->request->query['client_id'];
            $cond3 = 'Reglementclient.client_id=' . $client_id;
        }

        $this->Reglementclient->recursive = 2;
        $this->paginate = array(
            'order' => array('Reglementclient.id' => 'desc'),
            'conditions' => array($cond, $cond1, $cond2, $cond3, $cond4));
        $reglements = $this->paginate();


        $this->set(compact('reglements', 'collections', 'transferecommandebls', 'marques', 'familles', 'clients', 'ligneclients', 'marque_id', 'Date_debut', 'Date_fin', 'client_id', 'num_recu'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Factureclient');
        $this->loadModel('Lignereglementclient');
        if (!$this->Affectation->exists($id)) {
            throw new NotFoundException(__('Invalid Affectation'));
        }
        $options = array('conditions' => array('Affectation.' . $this->Affectation->primaryKey => $id), 'recursive' => 0);
        $affectation = $this->Affectation->find('first', $options);
         //debug($affectaion);die;
        $factureclients = $this->Factureclient->find('all',array('conditions'=>array('Factureclient.affectation_id' => $id),'recursive'=>0));  //debug($factureclients);die;
        $lignereglementclients = $this->Lignereglementclient->find('all',array('conditions'=>array('Lignereglementclient.affectation_id' => $id),'recursive'=>0));  //debug($factureclients);die;
      
        $this->set(compact('affectation','factureclients','lignereglementclients'));
    }
    
    public function imprimerview($id = null) {
        $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='reglementclients'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                }
        $this->loadModel('Reglementclient');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Lignereglementclient');

        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id), 'recursive' => 2);
        $reglement = $this->Reglementclient->find('first', $options);
        $pieceregement = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id)));
        
        $ligneregement = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id)));
     
         //debug($ligneregement);die;
        $this->set(compact('reglement', 'pieceregement','ligneregement'));
    }

    public function add($client_id = 0) {
        $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='reglementclients'){
                        $vente=$liens['add'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
        $this->loadModel('Reglementclient');
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Article');
            $this->loadModel('Depot');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Stockdepot');
            $this->loadModel('Pointdevente');

        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $client_id = $this->request->data['Affectation']['client_id'];
            $this->request->data['Affectation']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Affectation']['Date'])));
	    $this->request->data['Affectation']['utilisateur_id']= CakeSession::read('users');
             if(empty($this->request->data['Affectation']['pointdevente_id'])){
            $this->request->data['Affectation']['pointdevente_id']= CakeSession::read('pointdevente');
             }
            $this->request->data['Affectation']['exercice_id']=date("Y");
                        
         $pv= CakeSession::read('pointdevente'); 
          if($pv==0) {
          $pv=$this->request->data['Affectation']['pointdevente_id'];   
         }
         $numero = $this->Affectation->find('all',
         array('fields' =>array('MAX(Affectation.numeroconca) as num'),
          'conditions' => array('Affectation.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {  
   $getexercice= $this->Affectation->find('first',array('conditions'=>array('Affectation.numeroconca'=>$n)));
  $anne=$getexercice['Affectation']['exercice_id'];  
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
                        
                        $this->request->data['Affectation']['numeroconca']=$mm;
                        $this->request->data['Affectation']['numero']=$numspecial;
            $this->Affectation->create();
          // debug($this->request->data);die;
            if ($this->Affectation->save($this->request->data)) {
                  //debug($this->request->data);die;
                $aff_id = $this->Affectation->id;
               // $mntt = $this->request->data['Affectation']['montant'];
               $compteur=0;
      $reglementlibres= $this->Reglementclient->find('all',array('conditions'=>array('Reglementclient.client_id'=>$client_id,'Reglementclient.type'=>1)));
        foreach ($reglementlibres as $j => $reglementlibre) {
            
            $mntt = $reglementlibre['Reglementclient']['Montant']-$reglementlibre['Reglementclient']['montantaffecte'];
            
               foreach ($this->request->data['Lignereglement']as $j => $l) {  //debug($l);
                   
                    if ($mntt > 0 && array_key_exists('factureclient_id', $l) && ($j>=$compteur)) {
                        
                        
                        $li['reglementclient_id'] = $reglementlibre['Reglementclient']['id'];//$reg_id;
                        $li['affectation_id'] = $aff_id;//$reg_id;
                        $li['factureclient_id'] = $l['factureclient_id'];
                        $id_fac = $l['factureclient_id'];
                        $facture = $this->Factureclient->find('all', array('conditions' => array('Factureclient.id' => $id_fac), 'recursive' => 0));

                        $mntfac = $facture[0]['Factureclient']['totalttc'] - $facture[0]['Factureclient']['Montant_Regler'];
                        

                        if ($mntt >= $mntfac) {
                        
                            $compteur=$j;
                            
                            $li['Montant'] = $mntfac;
                            $mntt = $mntt - $mntfac;
                            $mnr = $mntfac;
                        } else {
                            
                            $li['Montant'] = $mntt;
                            $mnr = $mntt;
                            $mntt = 0;
                        }
        
                        $this->Reglementclient->updateAll(array('Reglementclient.montantaffecte ' => 'Reglementclient.montantaffecte+'.$mnr
                                ,'Reglementclient.affectation_id ' =>$aff_id)
                                , array('Reglementclient.id' =>  $reglementlibre['Reglementclient']['id']));
                        
                        $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler+' . $mnr
                                ,'Factureclient.Montant_Affecte ' =>$mnr
                                ,'Factureclient.affectation_id ' =>$aff_id)
                                , array('Factureclient.id' => $id_fac));
                        $this->Lignereglementclient->create();
                        $this->Lignereglementclient->save($li);
                        
                           if ($mntt==0){ // la totalit� du montant du reglement libre est affect�e reglement devient de type  0 (reglement simple )
                               $this->Reglementclient->updateAll(array('Reglementclient.type ' => 0),
                                                                 array('Reglementclient.id' =>$reglementlibre['Reglementclient']['id']));
                               break;
                           }
                       // debug($this->request->data['Lignereglement']);die;
                    }
                }
        }


                $this->Session->setFlash(__('The Affectation has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Affectation could not be saved. Please, try again.'));
            }
        }
        $valeurs=$this->To->find('list');
        $facture = array();
        $clients = $this->Affectation->Client->find('list');
        $paiements = $this->Paiement->find('list'); //debug($paiements);die;
        if ($client_id) {
            $facture = $this->Factureclient->find('all', array('conditions' => array('Factureclient.client_id' => $client_id, 'Factureclient.totalttc>(Factureclient.Montant_Regler)'), 'recursive' => 0));
           }
           
           
        $pv= CakeSession::read('pointdevente'); 
            if($pv!=0) {
         $numero = $this->Affectation->find('all',
         array('fields' =>array('MAX(Affectation.numeroconca) as num'),
          'conditions' => array('Affectation.pointdevente_id'=>$pv))
         );
         //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {  
   $getexercice= $this->Affectation->find('first',array('conditions'=>array('Affectation.numeroconca'=>$n)));
  $anne=$getexercice['Affectation']['exercice_id'];  
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
         $reglementlibres= $this->Reglementclient->find('all',array('conditions'=>array('Reglementclient.client_id'=>$client_id,'Reglementclient.type'=>1)));
  $avance=0;//debug($reglementlibres);die;
   foreach ($reglementlibres as $reglementlibre) {
       $avance=$avance+ ($reglementlibre['Reglementclient']['Montant']-$reglementlibre['Reglementclient']['montantaffecte']);
   } //debug($reglementlibres);die;
                $pointdeventes=$this->Pointdevente->find('list');
        $this->set(compact('mm','numspecial','clients', 'client_id', 'facture', 'paiements', 'valeurs','pointdeventes','avance'));
    }

    public function edit($id = null) {
        
        $this->loadModel('Reglementclient');
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Pointdevente');
        
        $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='reglementclients'){
                        $vente=$liens['edit'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
        if (!$this->Affectation->exists($id)) {
            throw new NotFoundException(__('Invalid Affectation'));
        }
      
          $affect= $this->Affectation->find('first', array('conditions' => array('Affectation.id' => $id)));  
          $client_id=$affect['Affectation']['client_id'];
        if ($this->request->is('post') || $this->request->is('put')) {
           // debug($this->request->data);die;
            if ($this->Affectation->save($this->request->data)) {
                
               
                
 //.....................................effacer  ligne reglementclient annuler montant regle , montant affecte facture , affectation, ..........................................................................
                
                        $this->Reglementclient->updateAll(array('Reglementclient.montantaffecte ' => 0.000 )
                                , array('Reglementclient.affectation_id' => $id));
                         
                        $this->Factureclient->updateAll(array('Factureclient.Montant_Regler -(Factureclient.Montant_Affecte) '
                                                               ,'Factureclient.Montant_Affecte ' =>0.000 )
                                                               , array('Factureclient.affectation_id' => $id));
                                     
                        $this->Lignereglementclient->deleteAll(array('Lignereglementclient.affectation_id'=>$id),false);
      
                     
 //..............................fin effacer ligne reglementclient annuler montant regle , montant affecte facture , affectation,.............................................................................   
                
                        
                        
                    $aff_id = $this->Affectation->id;
               // $mntt = $this->request->data['Affectation']['montant'];
                $compteur=0;
      $reglementlibres= $this->Reglementclient->find('all',array('conditions'=>array('Reglementclient.client_id'=>$client_id,'Reglementclient.type'=>1)));
        foreach ($reglementlibres as $j => $reglementlibre) {
            
            $mntt = $reglementlibre['Reglementclient']['Montant']-$reglementlibre['Reglementclient']['montantaffecte'];
            
               foreach ($this->request->data['Lignereglement']as $j => $l) {  //debug($l);
                   
                    if ($mntt > 0 && array_key_exists('factureclient_id', $l) && ($j>=$compteur)) {
                        
                        
                        $li['reglementclient_id'] = $reglementlibre['Reglementclient']['id'];//$reg_id;
                        $li['affectation_id'] = $aff_id;//$reg_id;
                        $li['factureclient_id'] = $l['factureclient_id'];
                        $id_fac = $l['factureclient_id'];
                        $facture = $this->Factureclient->find('all', array('conditions' => array('Factureclient.id' => $id_fac), 'recursive' => 0));

                        $mntfac = $facture[0]['Factureclient']['totalttc'] - $facture[0]['Factureclient']['Montant_Regler'];
                        

                        if ($mntt >= $mntfac) {
                        
                            $compteur=$j;
                            
                            $li['Montant'] = $mntfac;
                            $mntt = $mntt - $mntfac;
                            $mnr = $mntfac;
                        } else {
                            
                            $li['Montant'] = $mntt;
                            $mnr = $mntt;
                            $mntt = 0;
                        }
        
                        $this->Reglementclient->updateAll(array('Reglementclient.montantaffecte ' => 'Reglementclient.montantaffecte+'.$mnr
                                ,'Reglementclient.affectation_id ' =>$aff_id)
                                , array('Reglementclient.id' =>  $reglementlibre['Reglementclient']['id']));
                        
                        $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler+' . $mnr
                                ,'Factureclient.Montant_Affecte ' =>$mnr
                                ,'Factureclient.affectation_id ' =>$aff_id)
                                , array('Factureclient.id' => $id_fac));
                        $this->Lignereglementclient->create();
                        $this->Lignereglementclient->save($li);
                        
                           if ($mntt==0){ // la totalit� du montant du reglement libre est affect�e reglement devient de type  0 (reglement simple )
                               $this->Reglementclient->updateAll(array('Reglementclient.type ' => 0),
                                                                 array('Reglementclient.id' =>$reglementlibre['Reglementclient']['id']));
                               break;
                           }
                       // debug($this->request->data['Lignereglement']);die;
                    }
                }
        }   
                        
                        
                
                
                
                $this->Session->setFlash(__('The reglementclient has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The reglementclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Affectation.' . $this->Affectation->primaryKey => $id));
            $affectation=$this->request->data = $this->Affectation->find('first', $options);
        }
        $clients = $this->Affectation->Client->find('list');
        $this->set(compact('clients'));
        $valeurs=$this->To->find('list');
        $reglementclient=$this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.id'=>$id),'recursive'=>0)); 
        $date=date("d/m/Y",strtotime(str_replace('-','/',$reglementclient['Reglementclient']['Date'])));
        $facture = array();
        $clients = $this->Reglementclient->Client->find('list');
        $paiements = $this->Paiement->find('list'); //debug($paiements);die;
        if ($client_id) {
            $facture = $this->Factureclient->find('all', array('conditions' => array('Factureclient.client_id' => $client_id), 'recursive' => 0));
            //debug($bl);die;
           }
        
            $affectation = $this->Affectation->find('first',  array('conditions' => array('Affectation.id' => $id)));
         //debug($affectaion);die;
        $factureclients = $this->Factureclient->find('all',array('conditions'=>array('Factureclient.affectation_id' => $id),'recursive'=>0));  //debug($factureclients);die;
        $lignereglementclients = $this->Lignereglementclient->find('all',array('conditions'=>array('Lignereglementclient.affectation_id' => $id),'recursive'=>0));  //debug($factureclients);die;
        $pointdeventes=$this->Pointdevente->find('list');
        
        $this->set(compact('clients', 'client_id', 'facture','pointdeventes', 'paiements', 'lignereglementclients','facregclient','totalfacture','factureclients','affectation','date'));
    }
    
    public function delete($id = null) {
            $lien=  CakeSession::read('lien_vente');
               $article="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='articles'){
                        $article=$liens['delete'];
                }}}
              if (( $article <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
        $this->loadModel('Factureclient');
        $this->loadModel('Reglementclient');
        $this->loadModel('Lignereglementclient');  
		$this->Affectation->id = $id;
		if (!$this->Affectation->exists()) {
			throw new NotFoundException(__('Invalid article'));
		}
		$this->request->onlyAllow('post', 'delete');
                

                        $this->Reglementclient->updateAll(array('Reglementclient.montantaffecte ' => 0.000 )
                                , array('Reglementclient.affectation_id' => $id));
                         
                        $this->Factureclient->updateAll(array('Factureclient.Montant_Regler -(Factureclient.Montant_Affecte) '
                                                               ,'Factureclient.Montant_Affecte ' =>0.000 )
                                                               , array('Factureclient.affectation_id' => $id));
                                     
                        $this->Lignereglementclient->deleteAll(array('Lignereglementclient.affectation_id'=>$id),false);
                
		if ($this->Affectation->delete()) {
			$this->Session->setFlash(__('Affectation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Affectation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}    
}