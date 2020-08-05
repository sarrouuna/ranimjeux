<?php
App::uses('AppController', 'Controller');
/**
 * Piecereglements Controller
 *
 * @property Piecereglement $Piecereglement
 */
class PiecereglementsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
       $lien=  CakeSession::read('lien_achat');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='piecereglements'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }      
       $this->loadModel('Fournisseur');       
       $this->loadModel('Etatpiecereglement');  
       $this->loadModel('Exercice'); 
       $this->loadModel('Piecereglement');
       $this->loadModel('Compte');
       $this->loadModel('Paiement');
       
       $exercices = $this->Exercice->find('list');
         if (isset($this->request->data) && !empty($this->request->data)) {
        if($this->request->data['Piecereglement']['Date_debut'] != '__/__/____'){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_debut'])));
                    $cond='Reglement.Date>='."'".$Date_debut."'";
                
                    }
                if($this->request->data['Piecereglement']['Date_fin'] != '__/__/____'){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_fin'])));
                    $cond1='Reglement.Date<='."'".$Date_fin."'";
                }
                 if($this->request->data['Piecereglement']['Date_deb'] != '__/__/____'){
                $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_deb'])));
                    $cond2='Piecereglement.echance>='."'".$Date_deb."'";
                
                    }
                     if($this->request->data['Piecereglement']['Date_fn'] != '__/__/____'){
                $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_fn'])));
                    $cond3='Piecereglement.echance<='."'".$Date_fn."'";
                }
                    if($this->request->data['Piecereglement']['fournisseur_id']){
                    $fournisseur_id=$this->request->data['Piecereglement']['fournisseur_id'];
                    $cond4='Reglement.fournisseur_id='.$fournisseur_id;
                    }
                      
                      
                    if($this->request->data['Piecereglement']['situation']){
                    $situation=$this->request->data['Piecereglement']['situation'];
                    $cond6="Piecereglement.situation='".$situation."'";
                    }
                    if($this->request->data['Piecereglement']['compte_id']){
                    $compte_id=$this->request->data['Piecereglement']['compte_id'];
                    $cond7="Piecereglement.compte_id='".$compte_id."'";
                    }
                    if($this->request->data['Piecereglement']['paiement_id']){
                    $paiement_id=$this->request->data['Piecereglement']['paiement_id'];
                    $cond8="Piecereglement.paiement_id='".$paiement_id."'";
                    }
        
    } 
  $piecereglements = $this->Piecereglement->find('all', array( 'conditions' => array('Piecereglement.id > ' => 0,'Reglement.importation_id' => 0,'Piecereglement.paiement_id in (2,3)',@$cond,@$cond1, @$cond2, @$cond3,@$cond4,@$cond6,@$cond7,@$cond8 ),'recursive'=>0));
  $etatpiecereglements = $this->Etatpiecereglement->find('list',array('recursive'=>1));
  $fournisseurs = $this->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id'=>1)));
  $comptes = $this->Compte->find('all');
  $paiements = $this->Paiement->find('list',array('conditions'=>array('Paiement.id in (2,3)')));
  $this->set(compact('paiement_id','piecereglements','paiements','fournisseurs','comptes','Date_debut','Date_fin','Date_deb','Date_fn','client_id','num_recu','situation','compte_id',$this->paginate()));
  }
  
  
  public function imprimerindex(){
        $lien=  CakeSession::read('lien_achat');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='piecereglements'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
            $this->loadModel('Fournisseur');
            $this->loadModel('Compte');
            $fournisseurs = $this->Fournisseur->find('list');
            $comptes = $this->Compte->find('all');
            
                $cond='';$cond1='';$cond2='';$cond3='';$cond4='';$cond5='';$cond6='';$cond7='';$cond8='';
                
              //debug($this->request->query);die;
                if(!empty($this->request->query['Date_debut'])){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_debut'])));
                    $cond='Reglement.Date>='."'".$Date_debut."'";
                
                    }
                     if(!empty($this->request->query['Date_fin'])){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_fin'])));
                    $cond1='Reglement.Date<='."'".$Date_fin."'";
                }
                 if(!empty($this->request->query['Date_deb'] )){
                $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_deb'])));
                    $cond2='Piecereglement.echance>='."'".$Date_deb."'";
                
                    }
                     if(!empty($this->request->query['Date_fn'] )){
                $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_fn'])));
                    $cond3='Piecereglement.echance<='."'".$Date_fn."'";
                }
                    if(!empty($this->request->query['fournisseur_id'])){
                    $fournisseur_id=$this->request->query['fournisseur_id'];
                    $cond4='Reglement.fournisseur_id='.$fournisseur_id;
                    }
                      
                      
                     if(!empty($this->request->query['situation'])){
                    $situation=$this->request->query['situation'];
                    $cond6="Piecereglement.situation='".$situation."'";
                    }
                    if(!empty($this->request->query['compte_id'])){
                    $compte_id=$this->request->query['compte_id'];
                    $cond7="Piecereglement.compte_id='".$compte_id."'";
                    }
                    if(!empty($this->request->query['paiement_id'])){
                    $paiement_id=$this->request->query['paiement_id'];
                    $cond8="Piecereglement.paiement_id='".$paiement_id."'";
                    }
                    //debug($this->request->data);die;
                       $this->Piecereglement->recursive = 0;
                       $piecereglements=$this->Piecereglement->find('all',array(
                       'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Piecereglement.id > ' => 0,'Reglement.importation_id' => 0,'Piecereglement.paiement_id in (2,3)',@$cond,@$cond1, @$cond2, @$cond3,@$cond4,@$cond6,@$cond7,@$cond8 ),'recursive'=>0));
                       
                       $piece_att=$this->Piecereglement->find('all',array(
                           'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Reglement.importation_id' => 0,'Piecereglement.paiement_id in (2,3)','Piecereglement.situation'=>"En attente",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7,$cond8),'recursive'=>0));
                       
                       $piece_ver=$this->Piecereglement->find('all',array(
                           'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Reglement.importation_id' => 0,'Piecereglement.paiement_id in (2,3)','Piecereglement.situation'=>"Versé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7,$cond8),'recursive'=>0));
                       
                       $piece_pre=$this->Piecereglement->find('all',array(
                           'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Reglement.importation_id' => 0,'Piecereglement.paiement_id in (2,3)','Piecereglement.situation'=>"Préavis",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7,$cond8),'recursive'=>0));
                       
                       $piece_esc=$this->Piecereglement->find('all',array(
                           'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Reglement.importation_id' => 0,'Piecereglement.paiement_id in (2,3)','Piecereglement.situation'=>"Escompte",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7,$cond8),'recursive'=>0));
                       
                       $piece_pay=$this->Piecereglement->find('all',array(
                           'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Reglement.importation_id' => 0,'Piecereglement.paiement_id in (2,3)','Piecereglement.situation'=>"On caissé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7,$cond8),'recursive'=>0));
                       
                       $piece_imp=$this->Piecereglement->find('all',array(
                           'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Reglement.importation_id' => 0,'Piecereglement.paiement_id in (2,3)','Piecereglement.situation'=>"Impayé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7,$cond8),'recursive'=>0));
                   //debug($piecereglements);
//                        foreach ($piecereglements as $k=>$piece){
//        //debug($fournisseurs);die();
//        //debug($fournisseurs[$piece['Reglement']['fournisseur_id']]);die();
//                        }
            $this->set(compact('piece_esc','piecereglements','piece_att','piece_ver','piece_pre','piece_pay','piece_imp','fournisseurs','comptes','Date_debut','Date_fin','Date_deb','Date_fn','fournisseur_id','situation','compte_id'));
        }
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
        
       public function index_all() {
       $lien=  CakeSession::read('lien_achat');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='piecereglements'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }      
       $this->loadModel('Fournisseur');       
       $this->loadModel('Etatpiecereglement');  
       $this->loadModel('Exercice'); 
       $this->loadModel('Piecereglement');
       $this->loadModel('Compte');
       $this->loadModel('Paiement');
       $this->loadModel('Nacionalitefournisseur');
       
       $exercices = $this->Exercice->find('list');
         if (isset($this->request->data) && !empty($this->request->data)) {
        if($this->request->data['Piecereglement']['Date_debut'] != '__/__/____'){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_debut'])));
                    $cond='Reglement.Date>='."'".$Date_debut."'";
                
                    }
                if($this->request->data['Piecereglement']['Date_fin'] != '__/__/____'){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_fin'])));
                    $cond1='Reglement.Date<='."'".$Date_fin."'";
                }
                 if($this->request->data['Piecereglement']['Date_deb'] != '__/__/____'){
                $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_deb'])));
                    $cond2='Piecereglement.echance>='."'".$Date_deb."'";
                
                    }
                     if($this->request->data['Piecereglement']['Date_fn'] != '__/__/____'){
                $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_fn'])));
                    $cond3='Piecereglement.echance<='."'".$Date_fn."'";
                }
                    if($this->request->data['Piecereglement']['fournisseur_id']){
                    $fournisseur_id=$this->request->data['Piecereglement']['fournisseur_id'];
                    $cond4='Reglement.fournisseur_id='.$fournisseur_id;
                    }
                      
                      
                    if($this->request->data['Piecereglement']['etatpiecereglement_id']){
                    $situation=$this->request->data['Piecereglement']['etatpiecereglement_id'];
                    $cond6="Piecereglement.situation='".$situation."'";
                    }
                    if($this->request->data['Piecereglement']['compte_id']){
                    $compte_id=$this->request->data['Piecereglement']['compte_id'];
                    $cond7="Piecereglement.compte_id='".$compte_id."'";
                    }
                    if($this->request->data['Piecereglement']['paiement_id']){
                    $paiement_id=$this->request->data['Piecereglement']['paiement_id'];
                    $cond8="Piecereglement.paiement_id='".$paiement_id."'";
                    }
                    if($this->request->data['Piecereglement']['nacionalitefournisseur_id']){
                    $nacionalitefournisseur_id=$this->request->data['Piecereglement']['nacionalitefournisseur_id'];
                    if($nacionalitefournisseur_id==1){
                    $fournisseurs=$this->Fournisseur->find('all',array('recursive'=>-1,'conditions'=>array('Fournisseur.devise_id'=>1)));
                    $abc='0';
                    foreach ($fournisseurs as $cl){
                    $abc=$abc.','.$cl['Fournisseur']['id'];  
                    }
                    $cond9 = 'Reglement.fournisseur_id in ('.$abc.')';
                    }else{
                    $fournisseurs=$this->Fournisseur->find('all',array('recursive'=>-1,'conditions'=>array('Fournisseur.devise_id <>'=>1)));
                    $abc='0';
                    foreach ($fournisseurs as $cl){
                    $abc=$abc.','.$cl['Fournisseur']['id'];  
                    }
                    $cond9 = 'Reglement.fournisseur_id in ('.$abc.')';
                    }
                    }
                    //debug($condb9);die;
    } 
  $piecereglements = $this->Piecereglement->find('all', array( 'conditions' => array('Piecereglement.id > ' => 0,'Piecereglement.paiement_id in (2,3,4,6,7)',@$cond,@$cond1, @$cond2, @$cond3,@$cond4,@$cond6,@$cond7,@$cond8 ,@$cond9),'recursive'=>0));
  //debug($piecereglements);die;
  $etatpiecereglements = $this->Etatpiecereglement->find('list',  array('fields' => array('Etatpiecereglement.name','Etatpiecereglement.name')));
  $fournisseurs = $this->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id'=>1)));
  $comptes = $this->Compte->find('list');
  $nacionalitefournisseurs = $this->Nacionalitefournisseur->find('list');
  $paiements = $this->Paiement->find('list',array('conditions'=>array('Paiement.id in (2,3,4,6,7)')));
  $this->set(compact('nacionalitefournisseurs','etatpiecereglements','paiement_id','piecereglements','paiements','fournisseurs','comptes','Date_debut','Date_fin','Date_deb','Date_fn','client_id','num_recu','situation','compte_id',$this->paginate()));
  } 
        
        
        
        
        
        
        
        
        
	public function view($id = null) {
		if (!$this->Piecereglement->exists($id)) {
			throw new NotFoundException(__('Invalid piecereglement'));
		}
		$options = array('conditions' => array('Piecereglement.' . $this->Piecereglement->primaryKey => $id));
		$this->set('piecereglement', $this->Piecereglement->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Piecereglement->create();
			if ($this->Piecereglement->save($this->request->data)) {
				$this->Session->setFlash(__('The piecereglement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The piecereglement could not be saved. Please, try again.'));
			}
		}
		$paiements = $this->Piecereglement->Paiement->find('list');
		$reglements = $this->Piecereglement->Reglement->find('list');
		$this->set(compact('paiements', 'reglements'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Piecereglement->exists($id)) {
			throw new NotFoundException(__('Invalid piecereglement'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Piecereglement->save($this->request->data)) {
				$this->Session->setFlash(__('The piecereglement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The piecereglement could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Piecereglement.' . $this->Piecereglement->primaryKey => $id));
			$this->request->data = $this->Piecereglement->find('first', $options);
		}
		$paiements = $this->Piecereglement->Paiement->find('list');
		$reglements = $this->Piecereglement->Reglement->find('list');
		$this->set(compact('paiements', 'reglements'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Piecereglement->id = $id;
		if (!$this->Piecereglement->exists()) {
			throw new NotFoundException(__('Invalid piecereglement'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Piecereglement->delete()) {
			$this->Session->setFlash(__('Piecereglement deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Piecereglement was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        public function cheque(){
        $lien=  CakeSession::read('lien_achat');
        //debug($lien);die;
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='piecereglements'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
            $this->loadModel('Fournisseur');
            $this->loadModel('Compte');
            $fournisseurs = $this->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id'=>1)));
            $comptes = $this->Compte->find('all');
            if ($this->request->is('post') || $this->request->is('put')) {
                $cond='';$cond1='';$cond2='';$cond3='';$cond4='';$cond5='';$cond6='';$cond7='';
                
             // debug($this->request->data);die;
                if($this->request->data['Piecereglement']['Date_debut'] != '__/__/____'){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_debut'])));
                    $cond='Reglement.Date>='."'".$Date_debut."'";
                
                    }
                     if($this->request->data['Piecereglement']['Date_fin'] != '__/__/____'){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_fin'])));
                    $cond1='Reglement.Date<='."'".$Date_fin."'";
                }
                 if($this->request->data['Piecereglement']['Date_deb'] != '__/__/____'){
                $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_deb'])));
                    $cond2='Piecereglement.echance>='."'".$Date_deb."'";
                
                    }
                     if($this->request->data['Piecereglement']['Date_fn'] != '__/__/____'){
                $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_fn'])));
                    $cond3='Piecereglement.echance<='."'".$Date_fn."'";
                }
                    if($this->request->data['Piecereglement']['fournisseur_id']){
                    $fournisseur_id=$this->request->data['Piecereglement']['fournisseur_id'];
                    $cond4='Reglement.fournisseur_id='.$fournisseur_id;
                    }
                      
                      
                     if($this->request->data['Piecereglement']['situation']){
                    $situation=$this->request->data['Piecereglement']['situation'];
                    $cond6="Piecereglement.situation='".$situation."'";
                    }
                    if($this->request->data['Piecereglement']['compte_id']){
                    $compte_id=$this->request->data['Piecereglement']['compte_id'];
                    $cond7="Piecereglement.compte_id='".$compte_id."'";
                    }
            }
                   // debug($this->request->data);die;
                       $piecereglements = $this->Piecereglement->find('all',array(
                       'conditions' => array('Piecereglement.paiement_id'=>2,@$cond,@$cond1,@$cond2,@$cond3,@$cond4,@$cond5,@$cond6,@$cond7),'recursive'=>0));
                       
            
            $this->set(compact('piecereglements','fournisseurs','comptes','Date_debut','Date_fin','Date_deb','Date_fn','fournisseur_id','num_recu','situation','compte_id',$this->paginate()));
        }
         public function imprimercheque(){
        $lien=  CakeSession::read('lien_achat');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='piecereglements'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
            $this->loadModel('Fournisseur');
            $this->loadModel('Compte');
            $fournisseurs = $this->Fournisseur->find('list');
            $comptes = $this->Compte->find('all');
            
                $cond='';$cond1='';$cond2='';$cond3='';$cond4='';$cond5='';$cond6='';$cond7='';
                
              //debug($this->request->query);die;
                if(!empty($this->request->query['Date_debut'])){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_debut'])));
                    $cond='Reglement.Date>='."'".$Date_debut."'";
                
                    }
                     if(!empty($this->request->query['Date_fin'])){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_fin'])));
                    $cond1='Reglement.Date<='."'".$Date_fin."'";
                }
                 if(!empty($this->request->query['Date_deb'] )){
                $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_deb'])));
                    $cond2='Piecereglement.echance>='."'".$Date_deb."'";
                
                    }
                     if(!empty($this->request->query['Date_fn'] )){
                $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_fn'])));
                    $cond3='Piecereglement.echance<='."'".$Date_fn."'";
                }
                    if(!empty($this->request->query['fournisseur_id'])){
                    $fournisseur_id=$this->request->query['fournisseur_id'];
                    $cond4='Reglement.fournisseur_id='.$fournisseur_id;
                    }
                      
                      
                     if(!empty($this->request->query['situation'])){
                    $situation=$this->request->query['situation'];
                    $cond6="Piecereglement.situation='".$situation."'";
                    }
                    if(!empty($this->request->query['compte_id'])){
                    $compte_id=$this->request->query['compte_id'];
                    $cond7="Piecereglement.compte_id='".$compte_id."'";
                    }
                    //debug($this->request->data);die;
                      $piecereglements = $this->Piecereglement->find('all',array(
                       'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Piecereglement.paiement_id'=>2,$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7),'recursive'=>0));
                       
                       $piece_att=$this->Piecereglement->find('all',array(
                           'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Piecereglement.paiement_id'=>2,'Piecereglement.situation'=>"En attente",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7),'recursive'=>0));
                       
                       $piece_ver=$this->Piecereglement->find('all',array(
                           'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Piecereglement.paiement_id'=>2,'Piecereglement.situation'=>"Versé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7),'recursive'=>0));
                       
                       $piece_pre=$this->Piecereglement->find('all',array(
                           'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Piecereglement.paiement_id'=>2,'Piecereglement.situation'=>"Préavis",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7),'recursive'=>0));
                       
                       $piece_pay=$this->Piecereglement->find('all',array(
                           'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Piecereglement.paiement_id'=>2,'Piecereglement.situation'=>"On caissé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7),'recursive'=>0));
                       
                       $piece_imp=$this->Piecereglement->find('all',array(
                           'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Piecereglement.paiement_id'=>2,'Piecereglement.situation'=>"Impayé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7),'recursive'=>0));
                       // debug($piece_ver);die;
//$this->set('piecereglements', $this->paginate());
                       
//                      $piecereglements=$this->Piecereglement->find('all',array(
//                          'conditions' => array('Piecereglement.paiement_id'=>2,$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6),
//                          'recusive'=>2
//                      ));
                            //debug($piecereglements);die;  
            $this->set(compact('piecereglements','piece_att','piece_ver','piece_pre','piece_pay','piece_imp','fournisseurs','comptes','Date_debut','Date_fin','Date_deb','Date_fn','fournisseur_id','situation','compte_id'));
        }
        
        
        
        
        public function traite(){
        $lien=  CakeSession::read('lien_achat');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='piecereglements'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
            $this->loadModel('Fournisseur');
            $this->loadModel('Compte');
            $fournisseurs = $this->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id'=>1)));
            $comptes = $this->Compte->find('all');
            if ($this->request->is('post') || $this->request->is('put')) {
                $cond='';$cond1='';$cond2='';$cond3='';$cond4='';$cond5='';$cond6='';$cond7='';
             //   debug($this->request->data);die;
                if($this->request->data['Piecereglement']['Date_debut'] != '__/__/____'){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_debut'])));
                    $cond='Reglement.Date>='."'".$Date_debut."'";
                
                    }
                     if($this->request->data['Piecereglement']['Date_fin'] != '__/__/____'){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_fin'])));
                    $cond1='Reglement.Date<='."'".$Date_fin."'";
                }
                 if($this->request->data['Piecereglement']['Date_deb'] != '__/__/____'){
                $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_deb'])));
                    $cond2='Piecereglement.echance>='."'".$Date_deb."'";
                
                    }
                     if($this->request->data['Piecereglement']['Date_fn'] != '__/__/____'){
                $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_fn'])));
                    $cond3='Piecereglement.echance<='."'".$Date_fn."'";
                }
                    if($this->request->data['Piecereglement']['fournisseur_id']){
                    $fournisseur_id=$this->request->data['Piecereglement']['fournisseur_id'];
                    $cond4='Reglement.fournisseur_id='.$fournisseur_id;
                    }
                     
                       if($this->request->data['Piecereglement']['situation']){
                    $situation=$this->request->data['Piecereglement']['situation'];
                    $cond6="Piecereglement.situation='".$situation."'";
                    }
                     if($this->request->data['Piecereglement']['compte_id']){
                    $compte_id=$this->request->data['Piecereglement']['compte_id'];
                    $cond7="Piecereglement.compte_id='".$compte_id."'";
                    }
            }
                    $piecereglements = $this->Piecereglement->find('all',array(
                       'conditions' => array('Piecereglement.paiement_id'=>3,@$cond,@$cond1,@$cond2,@$cond3,@$cond4,@$cond5,@$cond6,@$cond7),'recursive'=>0));
            
            $this->set(compact('piecereglements','fournisseurs','comptes','Date_debut','Date_fin','Date_deb','Date_fn','fournisseur_id','situation','compte_id',$this->paginate()));
        }
        
         public function imprimertraite(){
        $lien=  CakeSession::read('lien_achat');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='piecereglements'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
            $this->loadModel('Fournisseur');
            $this->loadModel('Compte');
            $fournisseurs = $this->Fournisseur->find('list');
            $societes = $this->Compte->find('list');
            $societe = $this->Compte->find('all');
           
                $cond='';$cond1='';$cond2='';$cond3='';$cond4='';$cond5='';$cond6='';$cond7='';
                if(!empty($this->request->query['Date_debut'] )){
                $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_debut'])));
                    $cond='Reglement.Date>='."'".$Date_debut."'";
                
                    }
                     if(!empty($this->request->query['Date_fin'])){
                $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_fin'])));
                    $cond1='Reglement.Date<='."'".$Date_fin."'";
                }
                 if(!empty($this->request->query['Date_deb'] )){
                $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_deb'])));
                    $cond2='Piecereglement.echance>='."'".$Date_deb."'";
                
                    }
                     if(!empty($this->request->query['Date_fn'])){
                $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->query['Date_fn'])));
                    $cond3='Piecereglement.echance<='."'".$Date_fn."'";
                }
                    if(!empty($this->request->query['fournisseur_id'])){
                    $fournisseur_id=$this->request->query['fournisseur_id'];
                    $cond4='Reglement.fournisseur_id='.$fournisseur_id;
                    }
                      
                      if(!empty($this->request->query['situation'])){
                    $situation=$this->request->query['situation'];
                    $cond6="Piecereglement.situation='".$situation."'";
                    }
                     if(!empty($this->request->query['banque_id'])){
                    $banque_id=$this->request->query['banque_id'];
                    $cond7="Piecereglement.banque_id='".$banque_id."'";
                    }
                       $piecereglements = $this->Piecereglement->find('all',array(
                        'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Piecereglement.paiement_id'=>3,$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7),'recursive'=>0));
                    
                    $piece_att=$this->Piecereglement->find('all',array(
                        'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Piecereglement.paiement_id'=>3,'Piecereglement.situation'=>"En attente",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7),'recursive'=>0));
                    $piece_ver=$this->Piecereglement->find('all',array(
                        'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Piecereglement.paiement_id'=>3,'Piecereglement.situation'=>"Versé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7),'recursive'=>0));
                    $piece_esc=$this->Piecereglement->find('all',array(
                        'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Piecereglement.paiement_id'=>3,'Piecereglement.situation'=>"Escompte",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7),'recursive'=>0));
                    $piece_pay=$this->Piecereglement->find('all',array(
                        'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Piecereglement.paiement_id'=>3,'Piecereglement.situation'=>"On caissé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7),'recursive'=>0));
                    $piece_imp=$this->Piecereglement->find('all',array(
                        'order'=>array('Reglement.Date'=>'asc'),
                       'conditions' => array('Piecereglement.paiement_id'=>3,'Piecereglement.situation'=>"Impayé",$cond,$cond1,$cond2,$cond3,$cond4,$cond5,$cond6,$cond7),'recursive'=>0));
                               
            $this->set(compact('piecereglements','piece_att','piece_ver','piece_esc','piece_pay','piece_imp','fournisseurs','societes','societe','Date_debut','Date_fin','Date_deb','Date_fn','fournisseur_id','situation','compte_id'));
        }
        
        public function select($societe=null,$situation=null,$index=null){
            $this->layout=null;
            $this->loadModel('Piecereglement');
            $this->Piecereglement->updateAll(array('Piecereglement.situation' => "'".$situation."'"), array('Piecereglement.id' => $index));
        } 
         public function recap() {
            $this->loadModel('Etatpiecereglement');
            $this->loadModel('Situationpiecereglement');
             $this->layout = null;
             $data=$this->request->data;
             $piecereglement_id= $data['index'];
             $etatpiecereglements = $this->Etatpiecereglement->find('list',array('recursive'=>1));
             $situationpiecereglements= $this->Situationpiecereglement->find('all',array('conditions'=>array('Situationpiecereglement.piecereglement_id'=>$piecereglement_id),false));                
             $this->set(compact('piecereglement_id','etatpiecereglements','situationpiecereglements'));
               
	}
        public function misajourrecap() {
            $this->loadModel('Etatpiecereglement');
            $this->loadModel('Situationpiecereglement');
            $this->loadModel('Piecereglement');
             $this->layout = null;
             $data=$this->request->data;
             $piecereglement_id= $data['piecereglement_id'];
             $data['date']=date("Y-m-d",strtotime(str_replace('/','-',$data['date'])));;
             $agiosituation= $data['agio'];
             $stut= $data['situation'];
             $data['utilisateur_id']=CakeSession::read('users');
             $data['datemodification']=date("Y-m-d");
             
             $this->Situationpiecereglement->create();
             $this->Situationpiecereglement->save($data);
             $etatpiecereglement=$this->Etatpiecereglement->find('first',array('conditions'=>array('Etatpiecereglement.id'=>$stut)));   
             $this->Piecereglement->updateAll(array('Piecereglement.situation' =>'"'.$etatpiecereglement['Etatpiecereglement']['name'].'"','Piecereglement.etatpiecereglement_id' =>$stut), array('Piecereglement.id' =>$piecereglement_id));
            
             $this->set(compact('piecereglement_id','etatpiecereglements','situationpiecereglement'));
               
	}
 }
