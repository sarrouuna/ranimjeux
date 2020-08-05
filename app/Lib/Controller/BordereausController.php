<?php
App::uses('AppController', 'Controller');
/**
 * Bordereaus Controller
 *
 * @property Bordereau $Bordereau
 */
class BordereausController extends AppController {

	public function index() {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bordereaus'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Bordereau->recursive = 0;
		$this->set('bordereaus', $this->paginate());
	}

        public function indexr() {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bordereaus'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                $this->loadModel('Compte');
		$this->Bordereau->recursive = 0;
		$this->set('bordereaus', $this->paginate());
                
                 $comptess = $this->Compte->find('all', array( 'conditions' => array('Compte.id > ' => 0)));
                foreach ($comptess as $c){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                }
        
                  if (isset($this->request->data) && !empty($this->request->data)) {
       // debug($this->request->data);die;
        if ($this->request->data['Bordereau']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date1'])));
            $cond1 = 'Bordereau.date >= '."'".$date1."'";
        }
        
        if ($this->request->data['Bordereau']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date2'])));
            $cond2 = 'Bordereau.date <= '."'".$date2."'";
        }
        
       if ($this->request->data['Bordereau']['compte_id']) {
            $compteid= $this->request->data['Bordereau']['compte_id'];
            $cond3 = 'Bordereau.factoring ='.$compteid;
        } 
        if ($this->request->data['Bordereau']['numero']) {
            $numero= $this->request->data['Bordereau']['numero'];
            $cond4 = 'Bordereau.numero ='.$numero;
        } 
        
    } 
  $bordereaus = $this->Bordereau->find('all', array( 'conditions' => array('Bordereau.id > ' => 0, @$cond1, @$cond2, @$cond3 )));
    // debug($devis);die;
       
		
                 $this->set(compact('date1','date2','compteid','comptes','bordereaus',$this->paginate()));
                
	}
        
         public function imprimerretrait() {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bordereaus'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                $this->loadModel('Compte');
		$this->Bordereau->recursive = 0;
		$this->set('bordereaus', $this->paginate());
                
                 $comptess = $this->Compte->find('all', array( 'conditions' => array('Compte.id > ' => 0)));
                foreach ($comptess as $c){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                }
        
       
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Bordereau.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Bordereau.date <= '."'".$date2."'";
        }
        
       if (!empty($this->request->query['compteid'])) {
            $compteid= $this->request->query['compteid'];
            $cond3 = 'Bordereau.factoring ='.$compteid;
        } 
        if (!empty($this->request->query['numero'])) {
            $numero= $this->request->query['numero'];
            $cond4 = 'Bordereau.numero ='.$numero;
        } 
        

  $bordereaus = $this->Bordereau->find('all', array( 'conditions' => array('Bordereau.id > ' => 0, @$cond1, @$cond2, @$cond3 )));
       
		
                 $this->set(compact('date1','date2','compteid','comptes','bordereaus',$this->paginate()));
                
	}
        
        public function tabledebord() {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bordereaus'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                $this->loadModel('Compte');
		$this->Bordereau->recursive = 0;
		$this->set('bordereaus', $this->paginate());
                
                 $comptess = $this->Compte->find('all', array( 'conditions' => array('Compte.id > ' => 0)));
                foreach ($comptess as $c){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                }
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', "")));
                  if (isset($this->request->data) && !empty($this->request->data)) {
       // debug($this->request->data);die;
        if ($this->request->data['Bordereau']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date1'])));
            $cond1 = 'Bordereau.date >= '."'".$date1."'";
        }
        
        if ($this->request->data['Bordereau']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date2'])));
            $cond2 = 'Bordereau.date <= '."'".$date2."'";
        }
        
       if ($this->request->data['Bordereau']['compte_id']) {
            $compteid= $this->request->data['Bordereau']['compte_id'];
            $cond3 = 'Bordereau.factoring ='.$compteid;
        } 
        
    } 
  $bordereaus = $this->Bordereau->find('all', array( 'conditions' => array('Bordereau.id > ' => 0, @$cond1, @$cond2, @$cond3 )));
    // debug($devis);die;
       
		
                 $this->set(compact('date1','date2','compteid','comptes','bordereaus',$this->paginate()));
                
	}
        
        public function imprimertableaudebord() {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bordereaus'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                $this->loadModel('Compte');
		$this->Bordereau->recursive = 0;
		$this->set('bordereaus', $this->paginate());
                
                 $comptess = $this->Compte->find('all', array( 'conditions' => array('Compte.id > ' => 0)));
                foreach ($comptess as $c){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                }
        
       
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Bordereau.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Bordereau.date <= '."'".$date2."'";
        }
        
       if (!empty($this->request->query['compteid'])) {
            $compteid= $this->request->query['compteid'];
            $cond3 = 'Bordereau.factoring ='.$compteid;
        } 
        if (!empty($this->request->query['numero'])) {
            $numero= $this->request->query['numero'];
            $cond4 = 'Bordereau.numero ='.$numero;
        } 
        
 
  $bordereaus = $this->Bordereau->find('all', array( 'conditions' => array('Bordereau.id > ' => 0, @$cond1, @$cond2, @$cond3 )));
       
		
                 $this->set(compact('date1','date2','compteid','comptes','bordereaus',$this->paginate()));
                
	}
        
	public function view($id = null) {
        $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bordereaus'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
              $this->loadModel('Lignebordereau');
              $this->loadModel('Reglementclient');
              $this->loadModel('Client');
               $this->loadModel('Piecereglementclient');
		if (!$this->Bordereau->exists($id)) {
			throw new NotFoundException(__('Invalid bordereau'));
		}
		$options = array('conditions' => array('Bordereau.' . $this->Bordereau->primaryKey => $id));
		$this->set('bordereau', $this->Bordereau->find('first', $options));
                $lignebordereaus= $this->Lignebordereau->find('all',array('conditions'=>array('Lignebordereau.Bordereau_id'=>$id),'recursive'=>-1));
                foreach ($lignebordereaus as $lb){
          
                $reglementclients= $this->Reglementclient->find('all',array('conditions'=>array('Reglementclient.client_id'=>$lb['Lignebordereau']['client_id']),'recursive'=>-1));
                $t='(0,';
                foreach ($reglementclients as $l){
                    $t=$t.$l['Reglementclient']['id'].',';
                }
                $t=$t.'0)';
                
               $piecereglementclientss=$this->Piecereglementclient->find('all', array( 'conditions' => array('Piecereglementclient.reglementclient_id in'. $t),'recursive'=>-1)) ;
                   foreach ($piecereglementclientss as $prc) {
                       if($prc['Piecereglementclient']['paiement_id']==2){
                          $piecereglementclients[$prc['Piecereglementclient']['id']]="Chéque N° : ".$prc['Piecereglementclient']['num']; 
                       }
                        if($prc['Piecereglementclient']['paiement_id']==3){
                          $piecereglementclients[$prc['Piecereglementclient']['id']]="Traite N° : ".$prc['Piecereglementclient']['num']; 
                       }
                   } 
                } 
                 $bordereau= $this->Bordereau->find('first',array('conditions'=>array('Bordereau.id'=>$id),'recursive'=>-1));
                $factoring=0;
                if (!empty($bordereau['Bordereau']['garantie'])) {
                  $factoring=1;  
                }
                $clients = $this->Client->find('list');
		$this->set(compact('lignebordereaus','piecereglementclients','clients','factoring'));
	}
        
        public function viewr($id = null) {
             
		if (!$this->Bordereau->exists($id)) {
			throw new NotFoundException(__('Invalid bordereau'));
		}
		$options = array('conditions' => array('Bordereau.' . $this->Bordereau->primaryKey => $id));
		$this->set('bordereau', $this->Bordereau->find('first', $options));
                
	}

        public function imprimer($id = null) {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bordereaus'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
              $this->loadModel('Lignebordereau');
              $this->loadModel('Reglementclient');
              $this->loadModel('Client');
               $this->loadModel('Piecereglementclient');
		if (!$this->Bordereau->exists($id)) {
			throw new NotFoundException(__('Invalid bordereau'));
		}
		$options = array('conditions' => array('Bordereau.' . $this->Bordereau->primaryKey => $id));
		$this->set('bordereau', $this->Bordereau->find('first', $options));
                $lignebordereaus= $this->Lignebordereau->find('all',array('conditions'=>array('Lignebordereau.Bordereau_id'=>$id),'recursive'=>-1));
                foreach ($lignebordereaus as $lb){
          
                $reglementclients= $this->Reglementclient->find('all',array('conditions'=>array('Reglementclient.client_id'=>$lb['Lignebordereau']['client_id']),'recursive'=>-1));
                $t='(0,';
                foreach ($reglementclients as $l){
                    $t=$t.$l['Reglementclient']['id'].',';
                }
                $t=$t.'0)';
                
               $piecereglementclientss=$this->Piecereglementclient->find('all', array( 'conditions' => array('Piecereglementclient.reglementclient_id in'. $t),'recursive'=>-1)) ;
                   foreach ($piecereglementclientss as $prc) {
                       if($prc['Piecereglementclient']['paiement_id']==2){
                          $piecereglementclients[$prc['Piecereglementclient']['id']]="Chéque N° : ".$prc['Piecereglementclient']['num']; 
                       }
                        if($prc['Piecereglementclient']['paiement_id']==3){
                          $piecereglementclients[$prc['Piecereglementclient']['id']]="Traite N° : ".$prc['Piecereglementclient']['num']; 
                       }
                   } 
                } 
                $clients = $this->Client->find('list');
                  $factoring=0;
                if (!empty($bordereau['Bordereau']['garantie'])) {
                  $factoring=1;  
                }
		$this->set(compact('lignebordereaus','piecereglementclients','clients','factoring','bordereau'));
	}
        
	public function add() {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bordereaus'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
               $factoring=0;
              $this->loadModel('Paiement');
              $this->loadModel('Compte');
              $this->loadModel('Client');
              $this->loadModel('Lignebordereau');
              $this->loadModel('Piecereglementclient');
		if ($this->request->is('post')) {
                    if($this->request->data['Bordereau']['Montant']!=''){
                        $this->request->data['Bordereau']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bordereau']['date'])));
			$this->request->data['Bordereau']['factoring']= @$this->request->data['Bordereau']['comptefactoring_id'];
                        $this->request->data['Bordereau']['utilisateur_id']= CakeSession::read('users');
                        //debug($this->request->data);die;
			$this->Bordereau->create();
			if ($this->Bordereau->save($this->request->data)) {
                            $id=$this->Bordereau->id; 
                             foreach ($this->request->data['lignebordereau'] as $lb){
                                 $situation2="Vers�";$situation1="Escompt�";
                                    if (@$lb['ok']==1){
                                        $lb['bordereau_id']=$id;
                                        $this->Lignebordereau->create();
                                        $this->Lignebordereau->save($lb); 
                                      if(($this->request->data['Bordereau']['paiement_id']==3)||($this->request->data['Bordereau']['factoring']=="")){
                                      $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' =>"'".$situation1."'"), array('Piecereglementclient.id' =>$lb['piecereglementclient_id']));
                                      }else{
                                      $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' =>"'".$situation2."'"), array('Piecereglementclient.id' =>$lb['piecereglementclient_id']));
                                      }
                                   }
                             }
                            
				$this->Session->setFlash(__('The bordereau has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bordereau could not be saved. Please, try again.'));
			}
        }}
          //debug($this->request->data);die;
          if(!empty($this->request->data)){ //debug($this->request->data);die;
                if($this->request->data['Bordereau']['Date_deb'] != '__/__/____'){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bordereau']['Date_deb'])));
                    $cond='Piecereglementclient.echance>='."'".$Date_debut."'";
                
                    }
                     if($this->request->data['Bordereau']['Date_fn'] != '__/__/____'){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bordereau']['Date_fn'])));
                    $cond1='Piecereglementclient.echance<='."'".$Date_fin."'";
                }
                 if($this->request->data['Bordereau']['compte_id']){
                    $compte_id=$this->request->data['Bordereau']['compte_id'];
                    $cond2="Piecereglementclient.compte_id='".$compte_id."'";
                    
                    $compte = $this->Compte->find('first', array( 'conditions' => array('Compte.id' => $compte_id))); //debug($compte);die;
                    
                            if($compte['Compte']['typecompte_id']==2){
                                $comptefactoring=$compte['Compte']['banque'].' '.$compte['Compte']['rib'];
                                $comptefactoringid=$compte['Compte']['id'];
                                $factoring=1;
                                $condcompte="Compte.typecompte_id='".$factoring."'";
                            }  
                 }
                 $st="En attente";
            $conditionst='Piecereglementclient.situation='."'".$st."'";
            $conditionpid='Piecereglementclient.paiement_id='.$this->request->data['Bordereau']['paiement_id'];
             $cheques = $this->Piecereglementclient->find('all', array( 'conditions' => array('Piecereglementclient.id > ' => 0, @$cond, @$cond1,$conditionpid,$conditionst))); //debug($piecereglements);

                       //debug($cheques);die;
          }
		$comptess = $this->Compte->find('all', array( 'conditions' => array('Compte.id > ' => 0, @$condcompte)));
                foreach ($comptess as $c){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                }
        $numero = $this->Bordereau->find('all', array('fields' =>
            array(
                'MAX(Bordereau.numero) as num'
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
		$paiements = $this->Paiement->find('list', array( 'conditions' => array('Paiement.id > ' => 1, 'Paiement.id < ' => 4)));
                $clients = $this->Client->find('list');
		$this->set(compact('comptes','comptebs','clients','mm','cheques','paiements','factoring','comptefactoring','comptefactoringid'));
	}


        public function addr() {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bordereaus'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
              $this->loadModel('Compte');
		if ($this->request->is('post')) {
                    
                        $this->request->data['Bordereau']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bordereau']['date'])));
               
                        $compte= $this->Compte->find('first',array('conditions'=>array('Compte.id'=>$this->request->data['Bordereau']['compte_id']),false));
                         $type=$compte['Compte']['typecompte_id'];
                         
                    if($type==2){
			$this->request->data['Bordereau']['factoring']= $this->request->data['Bordereau']['compte_id'];
                    }
                        $this->request->data['Bordereau']['type']= 2;
                        $this->request->data['Bordereau']['utilisateur_id']= CakeSession::read('users');
                        //debug($this->request->data);die;
			$this->Bordereau->create();
			if ($this->Bordereau->save($this->request->data)) {
                           
				$this->Session->setFlash(__('The bordereau has been saved'));
				$this->redirect(array('action' => 'indexr'));
			} else {
				$this->Session->setFlash(__('The bordereau could not be saved. Please, try again.'));
			}
        }
         
		$comptess = $this->Compte->find('all', array( 'conditions' => array('Compte.id > ' => 0)));
                foreach ($comptess as $c){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                }
        $numero = $this->Bordereau->find('all', array('fields' =>
            array(
                'MAX(Bordereau.numero) as num'
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
		$this->set(compact('comptes','mm'));
	}
        
	public function edit($id = null) {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bordereaus'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
              $this->loadModel('Paiement');
              $this->loadModel('Compte');
              $this->loadModel('Client');
              $this->loadModel('Lignebordereau');
              $this->loadModel('Piecereglementclient');
              $this->loadModel('Reglementclient');
              
		if (!$this->Bordereau->exists($id)) {
			throw new NotFoundException(__('Invalid bordereau'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                       // debug($this->request->data);die;
                        $this->request->data['Bordereau']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bordereau']['date'])));
			$this->request->data['Bordereau']['utilisateur_id']= CakeSession::read('users');
                        
			if ($this->Bordereau->save($this->request->data)) {
                                $this->Lignebordereau->deleteAll(array('Lignebordereau.bordereau_id'=>$id),false);
                             foreach (  $this->request->data['lignebordereau'] as $lb   ){
                                 
                                    if ($lb['sup']!=1){
                                        $lb['bordereau_id']=$id;
                                        $this->Lignebordereau->create();
                                        $this->Lignebordereau->save($lb); 
                                    }
                             }
				$this->Session->setFlash(__('The bordereau has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bordereau could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Bordereau.' . $this->Bordereau->primaryKey => $id));
			$this->request->data = $this->Bordereau->find('first', $options);
		}
                
                foreach ($this->request->data['Lignebordereau'] as $i=>$lb){
          
                $reglementclients= $this->Reglementclient->find('all',array('conditions'=>array('Reglementclient.client_id'=>$lb['client_id']),'recursive'=>-1));
                $t='(0,';
                foreach ($reglementclients as $l){
                    $t=$t.$l['Reglementclient']['id'].',';
                }
                $t=$t.'0)';
                
               $piecereglementclientss=$this->Piecereglementclient->find('all', array( 'conditions' => array('Piecereglementclient.reglementclient_id in'. $t),'recursive'=>-1)) ;
                //debug($piecereglementclientss);die;
                   foreach ($piecereglementclientss as $prc) {
                       if($prc['Piecereglementclient']['paiement_id']==2){
                          $piecereglementclients[$i][$prc['Piecereglementclient']['id']]="Chéque N° : ".$prc['Piecereglementclient']['num']; 
                       }
                        if($prc['Piecereglementclient']['paiement_id']==3){
                          $piecereglementclients[$i][$prc['Piecereglementclient']['id']]="Traite N° : ".$prc['Piecereglementclient']['num']; 
                       }
                   } //debug($piecereglementclients);die;
                   
                } //debug($piecereglementclients);die;
                $lignebordereaus= $this->Lignebordereau->find('all',array('conditions'=>array('Lignebordereau.Bordereau_id'=>$id),'recursive'=>-1));
                $bordereau= $this->Bordereau->find('first',array('conditions'=>array('Bordereau.id'=>$id),'recursive'=>-1));
                $factoring=0;
                if (!empty($bordereau['Bordereau']['garantie'])) {
                  $factoring=1;  
                }
                $comptess = $this->Compte->find('all');
                foreach ($comptess as $c){
                    if($c['Compte']['typecompte_id']==1){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                    }else{
                    $factorings[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                    }
                }
		$paiements = $this->Paiement->find('list', array( 'conditions' => array('Paiement.id > ' => 1, 'Paiement.id < ' => 4)));
                $clients = $this->Client->find('list');
                $date=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Bordereau']['date'])));
		$this->set(compact('comptes','factorings','clients','date','lignebordereaus','piecereglementclients','factoring','paiements'));
	}

        public function editr($id = null) {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bordereaus'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
              $this->loadModel('Compte');
             
		if (!$this->Bordereau->exists($id)) {
			throw new NotFoundException(__('Invalid bordereau'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                       // debug($this->request->data);die;
                        $this->request->data['Bordereau']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bordereau']['date'])));
			$this->request->data['Bordereau']['utilisateur_id']= CakeSession::read('users');
                        
			if ($this->Bordereau->save($this->request->data)) {
				$this->Session->setFlash(__('The bordereau has been saved'));
				$this->redirect(array('action' => 'indexr'));
			} else {
				$this->Session->setFlash(__('The bordereau could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Bordereau.' . $this->Bordereau->primaryKey => $id));
			$this->request->data = $this->Bordereau->find('first', $options);
		}
                
              
                $comptess = $this->Compte->find('all');
                foreach ($comptess as $c){
                   $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                    
                }
                $date=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Bordereau']['date'])));
		$this->set(compact('comptes','date'));
	}
        
        public function valider($id = null) {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bordereaus'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
              $this->loadModel('Paiement');
              $this->loadModel('Compte');
              $this->loadModel('Client');
              $this->loadModel('Lignebordereau');
              $this->loadModel('Piecereglementclient');
              $this->loadModel('Reglementclient');
              
		if (!$this->Bordereau->exists($id)) {
			throw new NotFoundException(__('Invalid bordereau'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                       //debug($this->request->data);die;
                        $this->request->data['Bordereau']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bordereau']['date'])));
			$this->request->data['Bordereau']['utilisateur_id']= CakeSession::read('users');
			$this->request->data['Bordereau']['etat']= 1;
                        
			if ($this->Bordereau->save($this->request->data)) {
                             foreach (  $this->request->data['lignebordereau'] as $lb   ){//debug($lb); die;
                                    if (isset($lb['etat'])){
                                        $lb['bordereau_id']=$id;
                                        $this->Lignebordereau->save($lb); 
                                    }
                             $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' =>"'".$lb['Piecereglementclient']['situation']."'"), array('Piecereglementclient.id' =>$lb['id']));

                             
                                    }
				$this->Session->setFlash(__('The bordereau has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bordereau could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Bordereau.' . $this->Bordereau->primaryKey => $id));
			$this->request->data = $this->Bordereau->find('first', $options);
		}
                
                foreach ($this->request->data['Lignebordereau'] as $i=>$lb){
          
                $reglementclients= $this->Reglementclient->find('all',array('conditions'=>array('Reglementclient.client_id'=>$lb['client_id']),'recursive'=>-1));
                $t='(0,';
                foreach ($reglementclients as $l){
                    $t=$t.$l['Reglementclient']['id'].',';
                }
                $t=$t.'0)';
                
               $piecereglementclientss=$this->Piecereglementclient->find('all', array( 'conditions' => array('Piecereglementclient.reglementclient_id in'. $t),'recursive'=>-1)) ;
                //debug($piecereglementclientss);die;
                   foreach ($piecereglementclientss as $prc) {
                       if($prc['Piecereglementclient']['paiement_id']==2){
                          $piecereglementclients[$i][$prc['Piecereglementclient']['id']]="Chéque N° : ".$prc['Piecereglementclient']['num']; 
                       }
                        if($prc['Piecereglementclient']['paiement_id']==3){
                          $piecereglementclients[$i][$prc['Piecereglementclient']['id']]="Traite N° : ".$prc['Piecereglementclient']['num']; 
                       }
                   } //debug($piecereglementclients);die;
                   
                } //debug($piecereglementclients);die;
                $lignebordereaus= $this->Lignebordereau->find('all',array('conditions'=>array('Lignebordereau.Bordereau_id'=>$id),'recursive'=>1));
                $bordereau= $this->Bordereau->find('first',array('conditions'=>array('Bordereau.id'=>$id),'recursive'=>-1));
                $factoring=0;
                if (!empty($bordereau['Bordereau']['garantie'])) {
                  $factoring=1;  
                }
                
                $comptess = $this->Compte->find('all');
                 foreach ($comptess as $c){
                    if($c['Compte']['typecompte_id']==1){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                    }else{
                    $factorings[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                    }
                }
		$paiements = $this->Paiement->find('list', array( 'conditions' => array('Paiement.id > ' => 1, 'Paiement.id < ' => 4)));
                $clients = $this->Client->find('list');
                $date=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Bordereau']['date'])));
		$this->set(compact('comptes','clients','date','lignebordereaus','piecereglementclients','factoring','factorings','paiements'));
	}
        
	public function delete($id = null) {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bordereaus'){
                        $x=$liens['delete'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
              $this->loadModel('Lignebordereau');
		$this->Bordereau->id = $id;
		if (!$this->Bordereau->exists()) {
			throw new NotFoundException(__('Invalid bordereau'));
		}
		$this->request->onlyAllow('post', 'delete');
                
                   $this->Lignebordereau->deleteAll(array('Lignebordereau.bordereau_id'=>$id),false);
                
		if ($this->Bordereau->delete()) {
			$this->Session->setFlash(__('Bordereau deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Bordereau was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        //********************fonctions ajax*********************************       
        
      public function piecesclient(){
     $this->layout = null;
         $this->loadModel('Piecereglementclient');
         $this->loadModel('Reglementclient');
         $data = $this->request->data;
      
      $clientid= $data['id']; 
      $index=$data['index']; 
      $name='piecereglementclient_id';
      $reglementclients= $this->Reglementclient->find('all',array('conditions'=>array('Reglementclient.client_id'=>$clientid),'recursive'=>-1));
      $t='(0,';
            foreach ($reglementclients as $l){
                $t=$t.$l['Reglementclient']['id'].',';
              
            }
            $t=$t.'0)';
            $id='piecereglementclient_id'.$index;
            $paiement;
             if ($clientid != 0) { 
            $piecereglementclients=$this->Piecereglementclient->find('all', array( 'conditions' => array('Piecereglementclient.reglementclient_id in'. $t),'recursive'=>-1)) ;
            $select="<select   name='data[lignebordereau][$index][piecereglementclient_id]' id='$id' table='Articlefournisseur' index='$index' champ='piecereglementclient_id0' id='piecereglementclient_id0' class='select form-control'  onchange='getpiece(".$index.")'><option selected disabled hidden value=0> Veuillez choisir</option>";
            foreach($piecereglementclients as $p){ if ($p['Piecereglementclient']['paiement_id']<4 && $p['Piecereglementclient']['paiement_id']>1){
                if($p['Piecereglementclient']['paiement_id']==2){
                   $paiement="Chèque"; 
                }else{
                   $paiement="Traite";  
                }
                $select=$select."<option value=".$p['Piecereglementclient']['id'].">".$paiement." N° : ".$p['Piecereglementclient']['num']."</option>";
            }}
            $select=$select.'</select>';
             }
             echo $select;
          die();
      }      
      public function getpiece(){
         $this->layout = null;
         $this->loadModel('Piecereglementclient');
         $data = $this->request->data;
           $json = null;
         $piecereglementclient_id= $data['id']; 
  
         $piece= $this->Piecereglementclient->find('first',array('conditions'=>array('Piecereglementclient.id'=>$piecereglementclient_id),false));
            //debug($prixaf);die;
          $banque=$piece['Piecereglementclient']['banque'];
          $montant=$piece['Piecereglementclient']['montant'];
           echo json_encode(array('banque'=>$banque,'montant'=>$montant));
          die();
     }  
      public function compte(){
         $this->layout = null;
         $this->loadModel('Compte');
         $this->loadModel('Bordereau');
         $data = $this->request->data;
         $compte_id= $data['compte_id']; 
  
         $compte= $this->Compte->find('first',array('conditions'=>array('Compte.id'=>$compte_id),false));
          $type=$compte['Compte']['typecompte_id'];
          $solde=0;
          
            if($type==2){
                $bordereaus= $this->Bordereau->find('all',array('conditions'=>array('Bordereau.factoring'=>$compte_id),false));
                foreach ($bordereaus as $bordereau){
                   if($bordereau['Bordereau']['type']==1){
                      $solde=$solde+$bordereau['Bordereau']['garantie'] ;
                   }else{
                      $solde=$solde-$bordereau['Bordereau']['montantverse'] ;
                   }
                }
                if($solde==0){
                   $solde=0.000; 
                }
            }
           echo $solde;
          die();
     }  
   }
