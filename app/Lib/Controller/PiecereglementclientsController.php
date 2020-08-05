<?php
App::uses('AppController', 'Controller');
/**
 * Piecereglementclients Controller
 *
 * @property Piecereglementclient $Piecereglementclient
 */
class PiecereglementclientsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='piecereglementclients'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
            $this->loadModel('Client');
            $this->loadModel('Compte');
            $this->loadModel('Paiement');
            $clients = $this->Client->find('list');
            $comptes = $this->Compte->find('all');
             $zero=0; $cond0="Piecereglementclient.reglement='".$zero."'";
            if ($this->request->is('post') || $this->request->is('put')) {
                $cond='';$cond1='';$cond2='';$cond3='';$cond4='';$cond5='';$cond6='';$cond7='';
                
             // debug($this->request->data);die;
                if($this->request->data['Piecereglementclient']['Date_debut'] != '__/__/____'){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglementclient']['Date_debut'])));
                    $cond='Reglementclient.Date>='."'".$Date_debut."'";
                
                    }
                     if($this->request->data['Piecereglementclient']['Date_fin'] != '__/__/____'){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglementclient']['Date_fin'])));
                    $cond1='Reglementclient.Date<='."'".$Date_fin."'";
                }
                 if($this->request->data['Piecereglementclient']['Date_deb'] != '__/__/____'){
                $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglementclient']['Date_deb'])));
                    $cond2='Piecereglementclient.echance>='."'".$Date_deb."'";
                
                    }
                     if($this->request->data['Piecereglementclient']['Date_fn'] != '__/__/____'){
                $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglementclient']['Date_fn'])));
                    $cond3='Piecereglementclient.echance<='."'".$Date_fn."'";
                }
                    if($this->request->data['Piecereglementclient']['client_id']){
                    $client_id=$this->request->data['Piecereglementclient']['client_id'];
                    $cond4='Reglementclient.client_id='.$client_id;
                    }
                      
                      
                     if($this->request->data['Piecereglementclient']['situation']){
                    $situation=$this->request->data['Piecereglementclient']['situation'];
                    $cond6="Piecereglementclient.situation='".$situation."'";
                    }
                    if($this->request->data['Piecereglementclient']['compte_id']){
                    $compte_id=$this->request->data['Piecereglementclient']['compte_id'];
                    $cond7="Piecereglementclient.compte_id='".$compte_id."'";
                    }
                    if($this->request->data['Piecereglementclient']['paiement_id']){
                    $paiement_id=$this->request->data['Piecereglementclient']['paiement_id'];
                    $cond8="Piecereglementclient.paiement_id='".$paiement_id."'";
                    }
            }
                   // debug($this->request->data);die;
                       $piecereglementclients = $this->Piecereglementclient->find('all',array('conditions'=>array('Piecereglementclient.paiement_id in (2,3)',@$cond0,@$cond,@$cond1,@$cond2,@$cond3,@$cond4,@$cond5,@$cond6,@$cond7,@$cond8),'recursive'=>2));
            $paiements = $this->Paiement->find('list',array('conditions'=>array('Paiement.id in (2,3)')));
            $this->set(compact('paiement_id','piecereglementclients','paiements','clients','comptes','Date_debut','Date_fin','Date_deb','Date_fn','client_id','num_recu','situation','compte_id'));
        }
public function imprimerindex(){
         $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='piecereglementclients'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
            $this->loadModel('Client');
            $this->loadModel('Compte');
            $clients = $this->Client->find('list');
            $comptes = $this->Compte->find('all');
            
                $cond='';$cond1='';$cond2='';$cond3='';$cond4='';$cond5='';$cond6='';$cond7='';
                
              //debug($this->request->query);die;
                if(!empty($this->request->query['Date_debut'])){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_debut'])));
                    $cond='Reglementclient.Date>='."'".$Date_debut."'";
                
                    }
                     if(!empty($this->request->query['Date_fin'])){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_fin'])));
                    $cond1='Reglementclient.Date<='."'".$Date_fin."'";
                }
                 if(!empty($this->request->query['Date_deb'] )){
                $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_deb'])));
                    $cond2='Piecereglementclient.echance>='."'".$Date_deb."'";
                
                    }
                     if(!empty($this->request->query['Date_fn'] )){
                $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_fn'])));
                    $cond3='Piecereglementclient.echance<='."'".$Date_fn."'";
                }
                    if(!empty($this->request->query['client_id'])){
                    $client_id=$this->request->query['client_id'];
                    $cond4='Reglementclient.client_id='.$client_id;
                    }
                      
                      
                     if(!empty($this->request->query['situation'])){
                    $situation=$this->request->query['situation'];
                    $cond6="Piecereglementclient.situation='".$situation."'";
                    }
                    if(!empty($this->request->query['compte_id'])){
                    $compte_id=$this->request->query['compte_id'];
                    $cond7="Piecereglementclient.compte_id='".$compte_id."'";
                    }
                    if(!empty($this->request->query['paiement_id'])){
                    $paiement_id=$this->request->query['paiement_id'];
                    $cond8="Piecereglementclient.paiement_id='".$paiement_id."'";
                    }
                     $zero=0;
                     $cond0="Piecereglementclient.reglement='".$zero."'";
                    //debug($this->request->data);die;
                       $piecereglementclients = $this->Piecereglementclient->find('all',array('conditions'=>array('Piecereglementclient.paiement_id in (2,3)',@$cond0,@$cond,@$cond1,@$cond2,@$cond3,@$cond4,@$cond5,@$cond6,@$cond7,@$cond8),'recursive'=>2));
                       $piece_att=$this->Piecereglementclient->find('all',array(
                           'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.situation'=>"En attente",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                       
                       $piece_ver=$this->Piecereglementclient->find('all',array(
                           'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.situation'=>"Versé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                       
                       $piece_pre=$this->Piecereglementclient->find('all',array(
                           'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.situation'=>"Préavis",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                       
                       $piece_pay=$this->Piecereglementclient->find('all',array(
                           'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.situation'=>"Payé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                       
                       $piece_imp=$this->Piecereglementclient->find('all',array(
                           'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.situation'=>"Impayé",$cond0,$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                      
            $this->set(compact('piecereglementclients','piece_att','piece_ver','piece_pre','piece_pay','piece_imp','clients','societes','comptes','Date_debut','Date_fin','Date_deb','Date_fn','client_id','situation','compte_id'));
        }
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Piecereglementclient->exists($id)) {
			throw new NotFoundException(__('Invalid piecereglementclient'));
		}
		$options = array('conditions' => array('Piecereglementclient.' . $this->Piecereglementclient->primaryKey => $id));
		$this->set('piecereglementclient', $this->Piecereglementclient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Piecereglementclient->create();
			if ($this->Piecereglementclient->save($this->request->data)) {
				$this->Session->setFlash(__('The piecereglementclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The piecereglementclient could not be saved. Please, try again.'));
			}
		}
		$paiements = $this->Piecereglementclient->Paiement->find('list');
		$reglementclients = $this->Piecereglementclient->Reglementclient->find('list');
		$this->set(compact('paiements', 'reglementclients'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Piecereglementclient->exists($id)) {
			throw new NotFoundException(__('Invalid piecereglementclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Piecereglementclient->save($this->request->data)) {
				$this->Session->setFlash(__('The piecereglementclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The piecereglementclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Piecereglementclient.' . $this->Piecereglementclient->primaryKey => $id));
			$this->request->data = $this->Piecereglementclient->find('first', $options);
		}
		$paiements = $this->Piecereglementclient->Paiement->find('list');
		$reglementclients = $this->Piecereglementclient->Reglementclient->find('list');
		$this->set(compact('paiements', 'reglementclients'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Piecereglementclient->id = $id;
		if (!$this->Piecereglementclient->exists()) {
			throw new NotFoundException(__('Invalid piecereglementclient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Piecereglementclient->delete()) {
			$this->Session->setFlash(__('Piecereglementclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Piecereglementclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        
        public function cheque(){
          $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='piecereglementclients'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
            $this->loadModel('Client');
            $this->loadModel('Compte');
            $clients = $this->Client->find('list');
            $comptes = $this->Compte->find('all');
             $zero=0; $cond0="Piecereglementclient.reglement='".$zero."'";
            if ($this->request->is('post') || $this->request->is('put')) {
                $cond='';$cond1='';$cond2='';$cond3='';$cond4='';$cond5='';$cond6='';$cond7='';
                
             // debug($this->request->data);die;
                if($this->request->data['Piecereglementclient']['Date_debut'] != '__/__/____'){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglementclient']['Date_debut'])));
                    $cond='Reglementclient.Date>='."'".$Date_debut."'";
                
                    }
                     if($this->request->data['Piecereglementclient']['Date_fin'] != '__/__/____'){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglementclient']['Date_fin'])));
                    $cond1='Reglementclient.Date<='."'".$Date_fin."'";
                }
                 if($this->request->data['Piecereglementclient']['Date_deb'] != '__/__/____'){
                $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglementclient']['Date_deb'])));
                    $cond2='Piecereglementclient.echance>='."'".$Date_deb."'";
                
                    }
                     if($this->request->data['Piecereglementclient']['Date_fn'] != '__/__/____'){
                $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglementclient']['Date_fn'])));
                    $cond3='Piecereglementclient.echance<='."'".$Date_fn."'";
                }
                    if($this->request->data['Piecereglementclient']['client_id']){
                    $client_id=$this->request->data['Piecereglementclient']['client_id'];
                    $cond4='Reglementclient.client_id='.$client_id;
                    }
                      
                      
                     if($this->request->data['Piecereglementclient']['situation']){
                    $situation=$this->request->data['Piecereglementclient']['situation'];
                    $cond6="Piecereglementclient.situation='".$situation."'";
                    }
                    if($this->request->data['Piecereglementclient']['compte_id']){
                    $compte_id=$this->request->data['Piecereglementclient']['compte_id'];
                    $cond7="Piecereglementclient.compte_id='".$compte_id."'";
                    }
                   
                   // debug($this->request->data);die;
                       $this->Piecereglementclient->recursive = 2;
                       $this->paginate = array(
                       'conditions' => array('Piecereglementclient.paiement_id'=>2,$cond0,$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7));
                       $this->set('piecereglementclients', $this->paginate());
            }else{
            $this->Piecereglementclient->recursive = 2;
            $this->paginate = array(
            'conditions' => array('Piecereglementclient.paiement_id'=>2,$cond0));
            $this->set('piecereglementclients', $this->paginate());
            }
            $this->set(compact('clients','comptes','Date_debut','Date_fin','Date_deb','Date_fn','client_id','num_recu','situation','compte_id'));
        }
         public function imprimercheque(){
         $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='piecereglementclients'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
            $this->loadModel('Client');
            $this->loadModel('Compte');
            $clients = $this->Client->find('list');
            $comptes = $this->Compte->find('all');
            
                $cond='';$cond1='';$cond2='';$cond3='';$cond4='';$cond5='';$cond6='';$cond7='';
                
              //debug($this->request->query);die;
                if(!empty($this->request->query['Date_debut'])){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_debut'])));
                    $cond='Reglementclient.Date>='."'".$Date_debut."'";
                
                    }
                     if(!empty($this->request->query['Date_fin'])){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_fin'])));
                    $cond1='Reglementclient.Date<='."'".$Date_fin."'";
                }
                 if(!empty($this->request->query['Date_deb'] )){
                $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_deb'])));
                    $cond2='Piecereglementclient.echance>='."'".$Date_deb."'";
                
                    }
                     if(!empty($this->request->query['Date_fn'] )){
                $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_fn'])));
                    $cond3='Piecereglementclient.echance<='."'".$Date_fn."'";
                }
                    if(!empty($this->request->query['client_id'])){
                    $client_id=$this->request->query['client_id'];
                    $cond4='Reglementclient.client_id='.$client_id;
                    }
                      
                      
                     if(!empty($this->request->query['situation'])){
                    $situation=$this->request->query['situation'];
                    $cond6="Piecereglementclient.situation='".$situation."'";
                    }
                    if(!empty($this->request->query['compte_id'])){
                    $compte_id=$this->request->query['compte_id'];
                    $cond7="Piecereglementclient.compte_id='".$compte_id."'";
                    }
                     $zero=0;
                     $cond0="Piecereglementclient.reglement='".$zero."'";
                    //debug($this->request->data);die;
                       $this->Piecereglementclient->recursive = 2;
                       $piecereglementclients=$this->Piecereglementclient->find('all',array(
                       'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id'=>2,$cond0,$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                       
                       $piece_att=$this->Piecereglementclient->find('all',array(
                           'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id'=>2,'Piecereglementclient.situation'=>"En attente",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                       
                       $piece_ver=$this->Piecereglementclient->find('all',array(
                           'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id'=>2,'Piecereglementclient.situation'=>"Versé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                       
                       $piece_pre=$this->Piecereglementclient->find('all',array(
                           'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id'=>2,'Piecereglementclient.situation'=>"Préavis",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                       
                       $piece_pay=$this->Piecereglementclient->find('all',array(
                           'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id'=>2,'Piecereglementclient.situation'=>"Payé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                       
                       $piece_imp=$this->Piecereglementclient->find('all',array(
                           'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id'=>2,'Piecereglementclient.situation'=>"Impayé",$cond0,$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                       // debug($piece_ver);die;
//$this->set('piecereglements', $this->paginate());
                       
//                      $piecereglements=$this->Piecereglement->find('all',array(
//                          'conditions' => array('Piecereglement.paiement_id'=>2,$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6),
//                          'recusive'=>2
//                      ));
                            //debug($piecereglements);die;  
            $this->set(compact('piecereglementclients','piece_att','piece_ver','piece_pre','piece_pay','piece_imp','clients','societes','comptes','Date_debut','Date_fin','Date_deb','Date_fn','client_id','situation','compte_id'));
        }
        
        
        
        
        public function traite(){
          $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='piecereglementclients'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
            $this->loadModel('Client');
            $this->loadModel('Compte');
            $clients = $this->Client->find('list');
            $comptes = $this->Compte->find('all');
             $zero=0; $cond0="Piecereglementclient.reglement='".$zero."'";
            if ($this->request->is('post') || $this->request->is('put')) {
                $cond='';$cond1='';$cond2='';$cond3='';$cond4='';$cond5='';$cond6='';$cond7='';
             //   debug($this->request->data);die;
                if($this->request->data['Piecereglementclient']['Date_debut'] != '__/__/____'){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglementclient']['Date_debut'])));
                    $cond='Reglementclient.Date>='."'".$Date_debut."'";
                
                    }
                     if($this->request->data['Piecereglementclient']['Date_fin'] != '__/__/____'){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglementclient']['Date_fin'])));
                    $cond1='Reglementclient.Date<='."'".$Date_fin."'";
                }
                 if($this->request->data['Piecereglementclient']['Date_deb'] != '__/__/____'){
                $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglementclient']['Date_deb'])));
                    $cond2='Piecereglementclient.echance>='."'".$Date_deb."'";
                
                    }
                     if($this->request->data['Piecereglementclient']['Date_fn'] != '__/__/____'){
                $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglementclient']['Date_fn'])));
                    $cond3='Piecereglementclient.echance<='."'".$Date_fn."'";
                }
                    if($this->request->data['Piecereglementclient']['client_id']){
                    $client_id=$this->request->data['Piecereglementclient']['client_id'];
                    $cond4='Reglementclient.client_id='.$client_id;
                    }
                     
                       if($this->request->data['Piecereglementclient']['situation']){
                    $situation=$this->request->data['Piecereglementclient']['situation'];
                    $cond6="Piecereglementclient.situation='".$situation."'";
                    }
                     if($this->request->data['Piecereglementclient']['compte_id']){
                    $compte_id=$this->request->data['Piecereglementclient']['compte_id'];
                    $cond7="Piecereglementclient.compte_id='".$compte_id."'";
                    }
                 
                       $this->Piecereglementclient->recursive = 2;
                       $this->paginate = array(
                       'conditions' => array('Piecereglementclient.paiement_id'=>3,$cond0,$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7));
                       $this->set('piecereglementclients', $this->paginate());
            }else{
            $this->Piecereglementclient->recursive = 2;
            $this->paginate = array(
            'conditions' => array('Piecereglementclient.paiement_id'=>3,$cond0));
            $this->set('piecereglementclients', $this->paginate());
            }
            $this->set(compact('clients','comptes','Date_debut','Date_fin','Date_deb','Date_fn','client_id','situation','compte_id'));
        }
        
         public function imprimertraite(){
               $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='piecereglementclients'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
            $this->loadModel('Client');
            $this->loadModel('Compte');
            $clients = $this->Client->find('list');
            $comptes = $this->Compte->find('all');
           
                $cond='';$cond1='';$cond2='';$cond3='';$cond4='';$cond5='';$cond6='';$cond7='';
                if(!empty($this->request->query['Date_debut'] )){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_debut'])));
                    $cond='Reglementclient.Date>='."'".$Date_debut."'";
                
                    }
                     if(!empty($this->request->query['Date_fin'])){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_fin'])));
                    $cond1='Reglementclient.Date<='."'".$Date_fin."'";
                }
                 if(!empty($this->request->query['Date_deb'] )){
                $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_deb'])));
                    $cond2='Piecereglementclient.echance>='."'".$Date_deb."'";
                
                    }
                     if(!empty($this->request->query['Date_fn'])){
                $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->query['Date_fn'])));
                    $cond3='Piecereglementclient.echance<='."'".$Date_fn."'";
                }
                    if(!empty($this->request->query['client_id'])){
                    $client_id=$this->request->query['client_id'];
                    $cond4='Reglementclient.client_id='.$client_id;
                    }
                      
                      if(!empty($this->request->query['situation'])){
                    $situation=$this->request->query['situation'];
                    $cond6="Piecereglementclient.situation='".$situation."'";
                    }
                     if(!empty($this->request->query['compte_id'])){
                    $compte_id=$this->request->query['compte_id'];
                    $cond7="Piecereglementclient.compte_id='".$compte_id."'";
                    }
                     $zero=0;
                     $cond0="Piecereglementclient.reglement='".$zero."'";
                       $this->Piecereglementclient->recursive = 2;
                    $piecereglementclients=$this->Piecereglementclient->find('all',array(
                        'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id'=>3,$cond0,$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                    
                    $piece_att=$this->Piecereglementclient->find('all',array(
                        'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id'=>3,'Piecereglementclient.situation'=>"En attente",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                    $piece_ver=$this->Piecereglementclient->find('all',array(
                        'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id'=>3,'Piecereglementclient.situation'=>"Versé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                    $piece_esc=$this->Piecereglementclient->find('all',array(
                        'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id'=>3,'Piecereglementclient.situation'=>"Escompte",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                    $piece_pay=$this->Piecereglementclient->find('all',array(
                        'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id'=>3,'Piecereglementclient.situation'=>"Payé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                    $piece_imp=$this->Piecereglementclient->find('all',array(
                        'order'=>array('Reglementclient.Date'=>'asc'),
                       'conditions' => array('Piecereglementclient.paiement_id'=>3,'Piecereglementclient.situation'=>"Impayé",$cond0,$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7)));
                               
            $this->set(compact('piecereglementclients','piece_att','piece_ver','piece_esc','piece_pay','piece_imp','clients','comptes','Date_debut','Date_fin','Date_deb','Date_fn','client_id','situation','compte_id'));
        }
        
        public function select($societe=null,$situation=null,$index=null){
            $this->layout=null;
            $this->loadModel('Piecereglementclient');
            $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' => "'".$situation."'",'Piecereglementclient.compte_id'=>"'".$societe."'"), array('Piecereglementclient.id' => $index));


        }        
}
