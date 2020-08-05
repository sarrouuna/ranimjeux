<?php
App::uses('AppController', 'Controller');
/**
 * Commandes Controller
 *
 * @property Commande $Commande
 */
class CommandesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
             $lien=  CakeSession::read('lien_achat');
               $commande="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='commandes'){
                        $commande=1;
                }}}
              if (( $commande <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
        $this->loadModel('Fournisseur');       
        $this->loadModel('Validite');  
         $this->loadModel('Exercice'); 
       $exercices = $this->Exercice->find('list'); 
       $pv="";
       $p=CakeSession::read('pointdevente');
       if($p>0){
          $pv= 'Commande.pointdevente_id = '.$p;
       }
       
         if (isset($this->request->data) && !empty($this->request->data)) {
       // debug($this->request->data);die;
        if ($this->request->data['Commande']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commande']['date1'])));
            $cond1 = 'Commande.date >= '."'".$date1."'";
        }
        
        if ($this->request->data['Commande']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commande']['date2'])));
            $cond2 = 'Commande.date <= '."'".$date2."'";
        }
        
       if ($this->request->data['Commande']['fournisseur_id']) {
            $fournisseurid = $this->request->data['Commande']['fournisseur_id'];
            $cond3 = 'Commande.fournisseur_id ='.$fournisseurid;
        } 
        
        if ($this->request->data['Commande']['exercice_id']) {
            $exerciceid = $this->request->data['Commande']['exercice_id'];
            $cond4 = 'Commande.exercice_id ='.$exercices[$exerciceid];
        } 
         
    } 
  $commandes = $this->Commande->find('all', array( 'conditions' => array('Commande.id > ' => 0,$pv, @$cond1, @$cond2, @$cond3, @$cond4 )));

       
		$validites = $this->Validite->find('list');
                $fournisseurs = $this->Fournisseur->find('list');
              
                 $this->set(compact('exercices','date1','date2','fournisseurid','validiteid','validites','fournisseurs','commandes',$this->paginate()));
	}
        public function validite($id = null) {
                 $this->Commande->updateAll(array('Commande.validite_id' =>2), array('Commande.id' =>$id));
                 $this->redirect(array('controller' => 'commandes','action' => 'index'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            $lien=  CakeSession::read('lien_achat');
               $commande="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='commandes'){
                        $commande=1;
                }}}
              if (( $commande <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                $this->loadModel('Lignecommande');
             $this->loadModel('Articlefournisseur');
             $this->loadModel('Article');
             $this->loadModel('Importation');
             $this->loadModel('Depot');
		if (!$this->Commande->exists($id)) {
			throw new NotFoundException(__('Invalid commande'));
		}
                 $options = array('conditions' => array('Commande.' . $this->Commande->primaryKey => $id));
			$this->request->data = $this->Commande->find('first', $options);
                        //debug($this->request->data);
		
                $day=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Commande']['date'])));
                $lignecommandes = $this->Lignecommande->find('all',array('conditions'=>array('Lignecommande.commande_id' => $id)));
                if($this->request->data['Commande']['importation_id']!=0){
                $importations= $this->Importation->find('list',array('conditions'=>array('Importation.fournisseur_id'=>$this->request->data['Commande']['fournisseur_id'],'Importation.etat'=>0),false));
                $tr=$this->request->data['Importation']['tauxderechenge'];
                $coe=$this->request->data['Importation']['coefficien'];
                }
                if($this->request->data['Fournisseur']['devise_id']!=1){
                $fournisseurs = $this->Commande->Fournisseur->find('list');
                }else{
		$fournisseurs = $this->Commande->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id'=>1)));
                }
                $articles=$this->Article->find('list');
                $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
                
		$this->set(compact('depots','importations','coe','tr','articles','fournisseurs','lignecommandes','articles','day','fournis'));
	}
        public function imprimer($id = null) {
            $lien=  CakeSession::read('lien_achat');
               $commande="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='commandes'){
                        $commande=$liens['imprimer'];
                }}}
              if (( $commande <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
               }
               $this->loadModel('Lignecommande');
		if (!$this->Commande->exists($id)) {
			throw new NotFoundException(__('Invalid commande'));
		}
                 $lignecommandes = $this->Lignecommande->find('all',array(
                    'conditions'=>array('Lignecommande.commande_id' => $id)
                    ));
                    
                    
              $commande=$this->Commande->find('first',array('conditions'=>array('Commande.id'=>$id)));      
		//debug($commande);die;
		$this->set(compact('commande', 'lignecommandes'));
	}
        public function imprimerdevise($id = null) {
            $lien=  CakeSession::read('lien_achat');
               $commande="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='commandes'){
                        $commande=$liens['imprimer'];
                }}}
              if (( $commande <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
               }
               $this->loadModel('Lignecommande');
		if (!$this->Commande->exists($id)) {
			throw new NotFoundException(__('Invalid commande'));
		}
                 $lignecommandes = $this->Lignecommande->find('all',array(
                    'conditions'=>array('Lignecommande.commande_id' => $id)
                    ));
                    
                    
              $commande=$this->Commande->find('first',array('conditions'=>array('Commande.id'=>$id)));      
	      //debug($commande);die;
		$this->set(compact('commande', 'lignecommandes'));
	}
        public function imprimerinternationnal($id = null) {
            $lien=  CakeSession::read('lien_achat');
               $commande="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='commandes'){
                        $commande=$liens['imprimer'];
                }}}
              if (( $commande <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
               }
               $this->loadModel('Lignecommande');
		if (!$this->Commande->exists($id)) {
			throw new NotFoundException(__('Invalid commande'));
		}
                 $lignecommandes = $this->Lignecommande->find('all',array(
                    'conditions'=>array('Lignecommande.commande_id' => $id)
                    ));
                    
                    
              $commande=$this->Commande->find('first',array('conditions'=>array('Commande.id'=>$id)));      
		//debug($commande);die;
		$this->set(compact('commande', 'lignecommandes'));
	}     
        
        
/**
 * add method
 *
 * @return void
 */
	public function add() {
             $lien=  CakeSession::read('lien_achat');
               $commande="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='commandes'){
                        $commande=$liens['add'];
                }}}
              if (( $commande <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Article');       
            $this->loadModel('Pointdevente');
            $this->loadModel('Lignecommande');
            $this->loadModel('Fournisseur');
            $this->loadModel('Depot');
        if ($this->request->is('post')) {
                  //debug($this->request->data);die;
                        $this->request->data['Commande']['dateliv']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Commande']['dateliv'])));
                        $this->request->data['Commande']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Commande']['date'])));
                        if(empty($this->request->data['Commande']['pointdevente_id'])){
                        $this->request->data['Commande']['pointdevente_id']= CakeSession::read('pointdevente');
                        } 
                        $this->request->data['Commande']['exercice_id']=date("Y");
                        $this->request->data['Commande']['utilisateur_id']= CakeSession::read('users');

         
         $numero = $this->Commande->find('all',
         array('fields' =>array('MAX(Commande.numeroconca) as num')));
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {
         $getexercice= $this->Commande->find('first',array('conditions'=>array('Commande.numeroconca'=>$n)));
         $anne=$getexercice['Commande']['exercice_id'];  
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
       
        
                        
                     $this->request->data['Commande']['numeroconca']=$mm;
                     $this->request->data['Commande']['numero']=$mm;
                     $this->Commande->create();
			if ($this->Commande->save($this->request->data)) {
                             $commandeid=$this->Commande->id;
                             
                             foreach (  $this->request->data['Lignereception'] as  $i=>$lc   ){
                              if ($lc['sup']!=1){
                                     $lc['commande_id']=$commandeid;
                                     $lc['totalht']=($lc['prixhtva']*(1-@$lc['remise']*0.01))*$lc['quantite'];
                                     $lc['totalttc']=((($lc['totalht'])*(1+(@$lc['fodec']*0.01)))*(1+($lc['tva']*0.01)));  
                                     $this->Lignecommande->create();
                                     $this->Lignecommande->save($lc);  
                              }
                             }
				$this->Session->setFlash(__('The commande has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The commande could not be saved. Please, try again.'));
			}
		}
        
        $numero = $this->Commande->find('all',
         array('fields' =>array('MAX(Commande.numeroconca) as num')));
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {
         $getexercice= $this->Commande->find('first',array('conditions'=>array('Commande.numeroconca'=>$n)));
         $anne=$getexercice['Commande']['exercice_id'];  
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
            
      
               
                $articles=$this->Article->find('list');
		$fournisseurs = $this->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id'=>1)));
                $pointdeventes=$this->Pointdevente->find('list');
                $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('depots','pointdeventes','fournisseurs','mm','numspecial','articles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
        
   public function addfromdevis($id = null) {
    $lien=  CakeSession::read('lien_achat');
               $commande="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='commandes'){
                        $commande=$liens['add'];
                }}}
              if (( $commande <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                   
             $this->loadModel('Depot');
             $this->loadModel('Lignedeviprospect');
             $this->loadModel('Article');
             $this->loadModel('Fournisseur');
             $this->loadModel('Lignereception');
             $this->loadModel('Importation');
             $this->loadModel('Utilisateur');
             $this->loadModel('Deviprospect');
             $this->loadModel('Pointdevente');
             $this->loadModel('Lignecommande');
		if ($this->request->is('post') || $this->request->is('put')) {
                   // debug( $this->request->data);die;
                        $this->request->data['Commande']['dateliv']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Commande']['dateliv'])));
                        $this->request->data['Commande']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Commande']['date'])));
			$this->request->data['Commande']['utilisateur_id']= CakeSession::read('users');
                        //$this->request->data['Commande']['pointdevente_id']= CakeSession::read('pointdevente');
                        $this->request->data['Commande']['exercice_id']=date("Y");
                        $this->request->data['Commande']['deviprospect_id']=$id;
                        if ($this->Commande->save($this->request->data)) {
                            $commandeid=$this->Commande->id;
                            $this->Deviprospect->updateAll(array('Deviprospect.trasfert' => 1), array('Deviprospect.id'=>$id));
                             $Lignereceptions=array();
                              foreach (  $this->request->data['Lignedeviprospect'] as $numl=>$f   ){
                              if ($f['sup']!=1){
                                $Lignereceptions['commande_id']=$commandeid;
                                $Lignereceptions['article_id']=$f['article_id'];
                                $Lignereceptions['quantite']=$f['quantite'];
                                if(!empty($f['prix'])){
                                $Lignereceptions['prix']=$f['prix'];
                                }
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['remise']=@$f['remise'];
                                $Lignereceptions['fodec']=@$f['fodec'];
                                $Lignereceptions['tva']=$f['tva'];
                                $Lignereceptions['prixhtva']=$f['prixhtva'];
                                $Lignereceptions['totalht']=($f['prixhtva']*(1-@$f['remise']*0.01))*$f['quantite'];
                                $Lignereceptions['totalttc']=((($Lignereceptions['totalht'])*(1+(@$f['fodec']*0.01)))*(1+($f['tva']*0.01)));  
                                     $this->Lignecommande->create();
                                     $this->Lignecommande->save($Lignereceptions);
                              }
                             } 
				$this->Session->setFlash(__('The bonreception has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bonreception could not be saved. Please, try again.'));
			}
		}
                else {
			$options = array('conditions' => array('Commande.' . $this->Commande->primaryKey => $id));
			$this->request->data = $this->Commande->find('first', $options);
		}
        $numero = $this->Commande->find('all',
         array('fields' =>array('MAX(Commande.numeroconca) as num')));
         //debug($numero);die;
       foreach ($numero as $num) {
            $n = $num[0]['num'];
         }
       if (!empty($n)) {
         $getexercice= $this->Commande->find('first',array('conditions'=>array('Commande.numeroconca'=>$n)));
         $anne=$getexercice['Commande']['exercice_id'];  
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
        $devis=$this->Deviprospect->find('first',array('recursive' =>0,'conditions'=>array('Deviprospect.id' =>$id)));
        //debug($devis);
        $day=date("d/m/Y",strtotime(str_replace('/','-',$devis['Deviprospect']['date'])));
        $importations= $this->Importation->find('list',array('conditions'=>array('Importation.fournisseur_id'=>$devis['Deviprospect']['fournisseur_id'],'Importation.etat'=>0),false));
        $importation=$this->Importation->find('first',array('recursive' =>-1,'conditions'=>array('Importation.id' =>$devis['Deviprospect']['importation_id'])));
        if($devis['Deviprospect']['importation_id']!=0){
        $tr=$importation['Importation']['tauxderechenge'];
        $coe=$importation['Importation']['coefficien'];
        $tot_coe=$tr*$coe;
        }
        $importation=$devis['Deviprospect']['importation_id'];
        $fr=$devis['Deviprospect']['fournisseur_id'];
        $depot=$devis['Deviprospect']['depot_id'];
        $remise=$devis['Deviprospect']['remise'];
        $tva=$devis['Deviprospect']['tva'];
        $fodec=$devis['Deviprospect']['fodec'];
        $totalht=$devis['Deviprospect']['totalht'];
        $totalttc=$devis['Deviprospect']['totalttc'];
        $fournisseur= $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$devis['Deviprospect']['fournisseur_id']),false));
        $devise=$fournisseur['Fournisseur']['devise_id'];
        $lignedeviprospects = $this->Lignedeviprospect->find('all',array('conditions'=>array('Lignedeviprospect.deviprospect_id' => $id)));
        $articles=$this->Article->find('list');   
	$fournisseurs = $this->Deviprospect->Fournisseur->find('list');
        $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
        if (isset($_GET['t']) ){
        $t=1;
        }else{
        $t=0;    
        }
        $pointdeventes=$this->Pointdevente->find('list');
	$this->set(compact('devis','totalttc','totalht','fodec','tva','remise','tot_coe','depot','fr','importation','pointdeventes','mm','numspecial','t','devise','coe','tr','importations','fournisseurs','depots','lignedeviprospects','day','articles','fournis'));
	}     
        
        
        
    public function addfrometatstock($tab=null) {
    $lien=  CakeSession::read('lien_achat');
               $commande="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='commandes'){
                        $commande=$liens['add'];
                }}}
              if (( $commande <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
             $this->loadModel('Depot');
             $this->loadModel('Lignedeviprospect');
             $this->loadModel('Article');
             $this->loadModel('Fournisseur');
             $this->loadModel('Lignereception');
             $this->loadModel('Importation');
             $this->loadModel('Utilisateur');
             $this->loadModel('Deviprospect');
             $this->loadModel('Pointdevente');
             $this->loadModel('Lignecommande');
             
                $tab='('.$tab.'0)';
                //debug($tab);die;
		if ($this->request->is('post')) {
                  //debug($this->request->data);die;
                        $this->request->data['Commande']['dateliv']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Commande']['dateliv'])));
                        $this->request->data['Commande']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Commande']['date'])));
                        if(empty($this->request->data['Commande']['pointdevente_id'])){
                        $this->request->data['Commande']['pointdevente_id']= CakeSession::read('pointdevente');
                        } 
                        $this->request->data['Commande']['exercice_id']=date("Y");
                        $this->request->data['Commande']['utilisateur_id']= CakeSession::read('users');
                        $numero = $this->Commande->find('all',
                        array('fields' =>array('MAX(Commande.numeroconca) as num')));
                        //debug($numero);die;
                        foreach ($numero as $num) {
                        $n = $num[0]['num'];
                        }
                        if (!empty($n)) {
                        $getexercice= $this->Commande->find('first',array('conditions'=>array('Commande.numeroconca'=>$n)));
                        $anne=$getexercice['Commande']['exercice_id'];  
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
                        $this->request->data['Commande']['numeroconca']=$mm;
                        $this->request->data['Commande']['numero']=$mm;
                        $this->Commande->create();
			if ($this->Commande->save($this->request->data)) {
                             $commandeid=$this->Commande->id;
                             
                             foreach (  $this->request->data['Lignereception'] as  $i=>$lc   ){
                              if ($lc['sup']!=1){
                                     $lc['commande_id']=$commandeid;
                                     $lc['totalht']=($lc['prixhtva']*(1-@$lc['remise']*0.01))*$lc['quantite'];
                                     $lc['totalttc']=((($lc['totalht'])*(1+(@$lc['fodec']*0.01)))*(1+($lc['tva']*0.01)));  
                                     $this->Lignecommande->create();
                                     $this->Lignecommande->save($lc);  
                              }
                             }
				$this->Session->setFlash(__('The commande has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The commande could not be saved. Please, try again.'));
			}
		}
                else {
		$articlecommandes= $this->Article->find('all',array('conditions'=>array('Article.id in'.$tab)));
		}
                //****************************************************************
                $numero = $this->Commande->find('all',
                array('fields' =>array('MAX(Commande.numeroconca) as num')));
                //debug($numero);die;
                foreach ($numero as $num) {
                $n = $num[0]['num'];
                }
                if (!empty($n)) {
                $getexercice= $this->Commande->find('first',array('conditions'=>array('Commande.numeroconca'=>$n)));
                $anne=$getexercice['Commande']['exercice_id'];  
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
                $articles=$this->Article->find('list');
		$fournisseurs = $this->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id'=>1)));
                $pointdeventes=$this->Pointdevente->find('list');
                $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('articlecommandes','depots','pointdeventes','fournisseurs','mm','numspecial','articles'));
	}          
        
        
 //****************************************************       
        
	public function edit($id = null) {
             $lien=  CakeSession::read('lien_achat');
               $commande="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='commandes'){
                        $commande=$liens['edit'];
                }}}
              if (( $commande <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Lignecommande');
             $this->loadModel('Articlefournisseur');
             $this->loadModel('Article');
             $this->loadModel('Importation');
             $this->loadModel('Depot');
		if (!$this->Commande->exists($id)) {
			throw new NotFoundException(__('Invalid commande'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                  //debug( $this->request->data);die;
                $this->request->data['Commande']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Commande']['date'])));
                $this->request->data['Commande']['dateliv']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Commande']['dateliv'])));
                if ($this->Commande->save($this->request->data)) {
            $this->Lignecommande->deleteAll(array('Lignecommande.commande_id'=>$id),false); 
                             foreach (  $this->request->data['Lignereception'] as  $i=>$lc   ){
                              if ($lc['sup']!=1){
                                     $lc['commande_id']=$id;
                                     $lc['totalht']=($lc['prixhtva']*(1-@$lc['remise']*0.01))*$lc['quantite'];
                                     $lc['totalttc']=((($lc['totalht'])*(1+(@$lc['fodec']*0.01)))*(1+($lc['tva']*0.01)));
                                     $this->Lignecommande->create();
                                     $this->Lignecommande->save($lc);  
                              }
                             }
				$this->Session->setFlash(__('The commande has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The commande could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Commande.' . $this->Commande->primaryKey => $id));
			$this->request->data = $this->Commande->find('first', $options);
                        //debug($this->request->data);
                $dateliv=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Commande']['dateliv'])));
                $day=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Commande']['date'])));
                $lignecommandes = $this->Lignecommande->find('all',array('conditions'=>array('Lignecommande.commande_id' => $id)));
                if($this->request->data['Commande']['importation_id']!=0){
                $importations= $this->Importation->find('list',array('conditions'=>array('Importation.fournisseur_id'=>$this->request->data['Commande']['fournisseur_id'],'Importation.etat'=>0),false));
                $tr=$this->request->data['Importation']['tauxderechenge'];
                $coe=$this->request->data['Importation']['coefficien'];
                }
                if($this->request->data['Fournisseur']['devise_id']!=1){
                $fournisseurs = $this->Commande->Fournisseur->find('list');
                }else{
		$fournisseurs = $this->Commande->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id'=>1)));
                }
                $articles=$this->Article->find('list');
                $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
                }
		$this->set(compact('dateliv','depots','importations','coe','tr','articles','fournisseurs','lignecommandes','articles','day','fournis'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
             $lien=  CakeSession::read('lien_achat');
               $commande="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='commandes'){
                        $commande=$liens['delete'];
                }}}
              if (( $commande <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
              $this->loadModel('Lignecommande');
		$this->Commande->id = $id;
		if (!$this->Commande->exists()) {
			throw new NotFoundException(__('Invalid commande'));
		}
		$this->request->onlyAllow('post', 'delete');
                
             $this->Lignecommande->deleteAll(array('Lignecommande.Commande_id'=>$id),false); 

  
		if ($this->Commande->delete()) {
			$this->Session->setFlash(__('Commande deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Commande was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
       public function imprimerrecherche() { 
         $lien=  CakeSession::read('lien_achat');
               $commande="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='commandes'){
                        $commande=$liens['imprimer'];
                }}}
              if (( $commande <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
       $this->loadModel('Fournisseur');       
     
       //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Commande.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Commande.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Commande.fournisseur_id ='.$fournisseurid;
        } 
         if ($this->request->query['validiteid']) {
            //if($this->request->query['validiteid']=='2'){
            //$validiteid = $this->request->query['validiteid']-1;
            //$cond4 = 'Commande.validite_id > '.$validiteid;
            //}else{
            $validiteid = $this->request->query['validiteid'];
            $cond4 = 'Commande.validite_id ='.$validiteid;
            //}
        } 
         
  $commandes = $this->Commande->find('all', array( 'conditions' => array('Commande.id > ' => 0, @$cond1, @$cond2, @$cond3, @$cond4 )));

   //debug($commandes);die;
                 $this->set(compact('commandes','date1','date2','fournisseurid','validiteid'));     
   
         }
}
