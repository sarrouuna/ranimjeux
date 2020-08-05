<?php
App::uses('AppController', 'Controller');
/**
 * Deviprospects Controller
 *
 * @property Deviprospect $Deviprospect
 */
class DeviprospectsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
                $lien=  CakeSession::read('lien_achat');
                $commande="";
                if(!empty($lien)){
                foreach($lien as $k=>$liens){
                if(@$liens['lien']=='deviprospects'){
                    $commande=1;
                }}}
                if (( $commande <> 1)||(empty($lien))){
                $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                }    
		$this->Deviprospect->recursive = 0;
		$this->set('deviprospects', $this->paginate());
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
                if(!empty($lien)){
                foreach($lien as $k=>$liens){
                if(@$liens['lien']=='deviprospects'){
                    $commande=1;
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
		
        $devis=$this->Deviprospect->find('first',array('recursive' =>0,'conditions'=>array('Deviprospect.id' =>$id)));
        $day=date("d/m/Y",strtotime(str_replace('/','-',$devis['Deviprospect']['date'])));
        $importations= $this->Importation->find('list',array('conditions'=>array('Importation.fournisseur_id'=>$devis['Deviprospect']['fournisseur_id'],'Importation.etat'=>0),false));
        $importation=$this->Importation->find('first',array('recursive' =>-1,'conditions'=>array('Importation.id' =>$devis['Deviprospect']['importation_id'])));
        $tr=$importation['Importation']['tauxderechenge'];
        $coe=$importation['Importation']['coefficien'];
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
	$this->set(compact('t','devise','coe','tr','importations','fournisseurs','depots','lignedeviprospects','day','articles','fournis'));
	}

        
        
        
        
         public function imprimer($id = null) {
             $lien=  CakeSession::read('lien_achat');
                $commande="";
                if(!empty($lien)){
                foreach($lien as $k=>$liens){
                if(@$liens['lien']=='deviprospects'){
                    $commande=$liens['imprimer'];
                }}}
                if (( $commande <> 1)||(empty($lien))){
                $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                }
          
            $this->loadModel('Lignedeviprospect');
		if (!$this->Deviprospect->exists($id)) {
			throw new NotFoundException(__('Invalid devi'));
		}
		$options = array('conditions' => array('Deviprospect.' . $this->Deviprospect->primaryKey => $id));
		$this->set('deviprospect', $this->Deviprospect->find('first', $options));
                $lignedeviprospects = $this->Lignedeviprospect->find('all',array(
                    'conditions'=>array('Lignedeviprospect.deviprospect_id' => $id)
                    ));
                   // debug($deviprospect);
                 $this->set(compact('lignedeviprospects'));
	}
/**
 * add method
 *
 * @return void
 */
	public function add() {
            $lien=  CakeSession::read('lien_achat');
                $commande="";
                if(!empty($lien)){
                foreach($lien as $k=>$liens){
                if(@$liens['lien']=='deviprospects'){
                    $commande=$liens['add'];
                }}}
                if (( $commande <> 1)||(empty($lien))){
                $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                }
           
            $this->loadModel('Article');
            $this->loadModel('Stockdepot');
            $this->loadModel('Depot');
            $this->loadModel('Lignereception');
            $this->loadModel('Importation');
            $this->loadModel('Lignedeviprospect');
		if ($this->request->is('post')) {
                    //debug($this->request->data);die;
                    $this->request->data['Deviprospect']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Deviprospect']['date'])));
			$this->request->data['Deviprospect']['utilisateur_id']= CakeSession::read('users');
                        $this->request->data['Deviprospect']['pointdevente_id']= CakeSession::read('pointdevente');
                        $this->request->data['Deviprospect']['exercice_id']= date("Y");
                        $depotid=$this->request->data['Deviprospect']['depot_id'];
			$this->Deviprospect->create();  
                        if(!empty($this->request->data['Lignereception'])){
			if ($this->Deviprospect->save($this->request->data)) {
                         $id=$this->Deviprospect->id;
                       
                               $Lignereceptions=array();
                              foreach (  $this->request->data['Lignereception'] as $numl=>$f   ){
                                
                              if ($f['sup']!=1){
                                $Lignereceptions['deviprospect_id']=$id;
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
                                     $this->Lignedeviprospect->create();
                                     $this->Lignedeviprospect->save($Lignereceptions);
                              }
                             } 
                    
				$this->Session->setFlash(__('The bonreception has been saved'));
				$this->redirect(array('action' => 'index'));
                                
                                
                                
                                
                                
                                
			} else {
				$this->Session->setFlash(__('The bonreception could not be saved. Please, try again.'));
                        }}else {
				$this->Session->setFlash(__('le bonreception dois avoir aux moins une ligne de reception.'));
                        }
                        
		}
                 $numero = $this->Deviprospect->find('all', array('fields' =>
            array(
                'MAX(Deviprospect.numero) as num'
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
                $articles=$this->Article->find('list');
		$fournisseurs = $this->Deviprospect->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id <>'=>1)));
                $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
//                $importations = $this->Importation->find('list',array('conditions' => array('Importation.designation')));
		$this->set(compact('mm','fournisseurs','articles','depots'));
	}

        
        
        
        public function addindirect($tab=null) {
        $lien=  CakeSession::read('lien_achat');
                $commande="";
                if(!empty($lien)){
                foreach($lien as $k=>$liens){
                if(@$liens['lien']=='deviprospects'){
                    $commande=$liens['add'];
                }}}
                if (( $commande <> 1)||(empty($lien))){
                $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                }   
            $this->loadModel('Article');
            $this->loadModel('Stockdepot');
            $this->loadModel('Depot');
            $this->loadModel('Lignereception');
            $this->loadModel('Importation');
            $this->loadModel('Lignedeviprospect');
            $tab='('.$tab.'0)';
		if ($this->request->is('post')) {
                   // debug($this->request->data);die;
                        $this->request->data['Deviprospect']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Deviprospect']['date'])));
			$this->request->data['Deviprospect']['utilisateur_id']= CakeSession::read('users');
                        $this->request->data['Deviprospect']['pointdevente_id']= CakeSession::read('pointdevente');
                        $this->request->data['Deviprospect']['exercice_id']= date("Y");
                        $depotid=$this->request->data['Deviprospect']['depot_id'];
			$this->Deviprospect->create();  
			if ($this->Deviprospect->save($this->request->data)) {
                         $id=$this->Deviprospect->id;
                       
                               $Lignereceptions=array();
                              foreach (  $this->request->data['Lignedeviprospect'] as $numl=>$f   ){
                                
                              if ($f['sup']!=1){
                                $Lignereceptions['deviprospect_id']=$id;
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
                                     $this->Lignedeviprospect->create();
                                     $this->Lignedeviprospect->save($Lignereceptions);
                              }
                             } 
                    
				$this->Session->setFlash(__('The bonreception has been saved'));
				$this->redirect(array('action' => 'index'));
                                
                                
                                
                                
                                
                                
			 
                        }else {
				$this->Session->setFlash(__('The bonreception could not be saved. Please, try again.'));
                        }
                        
                        
		}
                else {
		$articlecommandes= $this->Article->find('all',array('conditions'=>array('Article.id in'.$tab)));
                }
                $numero = $this->Deviprospect->find('all', array('fields' =>
                array(
                'MAX(Deviprospect.numero) as num'
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
                $articles=$this->Article->find('list');
		$fournisseurs = $this->Deviprospect->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id <>'=>1)));
                $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('articlecommandes','mm','fournisseurs','articles','depots'));
	}
        
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $lien=  CakeSession::read('lien_achat');
                $commande="";
                if(!empty($lien)){
                foreach($lien as $k=>$liens){
                if(@$liens['lien']=='deviprospects'){
                    $commande=$liens['edit'];
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
             $this->loadModel('Ligneworkflow');
             $this->loadModel('Lignevalide');
             $p=CakeSession::read('users');
              //debug($p);die;
		if (!$this->Deviprospect->exists($id)) {
			throw new NotFoundException(__('Invalid bonreception'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    //debug( $this->request->data);
                   
                           
                       $this->request->data['Deviprospect']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Deviprospect']['date'])));
		       $this->request->data['Deviprospect']['utilisateur_id']= CakeSession::read('users');
                        if ($this->Deviprospect->save($this->request->data)) {
                            
                            
                            if ($this->request->data['Deviprospect']['valide']==1) {
                            $valider=0;
                            $personnel = $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$p),'recursive'=>-1));
                            $tab=array();
                            $ligneworkflows=$this->Ligneworkflow->find('first',array('conditions'=>array('Ligneworkflow.personnel_id'=>$personnel['Utilisateur']['personnel_id'],'Ligneworkflow.typeworkflow_id'=>2,'Workflow.document_id'=>1),'recursive'=>0));
                            $tab['ligneworkflow_id']=$ligneworkflows['Ligneworkflow']['id'];
                            $tab['id_piece']=$id;
                            $tab['document_id']=$ligneworkflows['Workflow']['document_id'];
                            $tab['personnel_id']=$personnel['Utilisateur']['personnel_id'];
                            $tab['date']=date("Y-m-d");
                            $tab['heure']=date("H:i:s");        
                            $this->Lignevalide->create();
                            $this->Lignevalide->save($tab);
                            //$this->Utilisateur->updateAll(array('Utilisateur.notifdevis' =>'Utilisateur.notifdevis'+1), array('Utilisateur.id'=>$p));
                            $ligneworkflow2s=$this->Ligneworkflow->find('all',array('conditions'=>array('Ligneworkflow.obligatoire'=>1,'Ligneworkflow.typeworkflow_id'=>2,'Workflow.document_id'=>1),'recursive'=>0));
                            foreach ($ligneworkflow2s as $ligne   ){
                            $lignevalides=$this->Lignevalide->find('count',array('conditions'=>array('Lignevalide.personnel_id'=>$ligne['Ligneworkflow']['personnel_id'],'Lignevalide.ligneworkflow_id'=>$ligne['Ligneworkflow']['id'],'Lignevalide.id_piece'=>$id),'recursive'=>2));
                            if($lignevalides==0){
                            $valider=1;    
                            }
                            }
                            if($valider==0){
                            $this->Deviprospect->updateAll(array('Deviprospect.etat' =>1), array('Deviprospect.id'=>$id));
                            $devis=$this->Deviprospect->find('count',array('conditions'=>array('Deviprospect.etat' =>1)));
                            $this->Utilisateur->updateAll(array('Utilisateur.notifdevis' => $devis));
                            }
                            }
                           
                           
                           $this->Lignedeviprospect->deleteAll(array('Lignedeviprospect.deviprospect_id'=>$id),false); 
                             $Lignereceptions=array();
                              foreach (  $this->request->data['Lignedeviprospect'] as $numl=>$f   ){
                              if ($f['sup']!=1){
                                $Lignereceptions['deviprospect_id']=$id;
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
                                     $this->Lignedeviprospect->create();
                                     $this->Lignedeviprospect->save($Lignereceptions);
                              }
                             } 
				$this->Session->setFlash(__('The bonreception has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bonreception could not be saved. Please, try again.'));
			}
		}
                else {
			$options = array('conditions' => array('Deviprospect.' . $this->Deviprospect->primaryKey => $id));
			$this->request->data = $this->Deviprospect->find('first', $options);
		}
        $devis=$this->Deviprospect->find('first',array('recursive' =>0,'conditions'=>array('Deviprospect.id' =>$id)));
        $day=date("d/m/Y",strtotime(str_replace('/','-',$devis['Deviprospect']['date'])));
        $importations= $this->Importation->find('list',array('conditions'=>array('Importation.fournisseur_id'=>$devis['Deviprospect']['fournisseur_id'],'Importation.etat'=>0),false));
        $importation=$this->Importation->find('first',array('recursive' =>-1,'conditions'=>array('Importation.id' =>$devis['Deviprospect']['importation_id'])));
        if($devis['Deviprospect']['importation_id']!=0){
        $tr=$importation['Importation']['tauxderechenge'];
        $coe=$importation['Importation']['coefficien'];
        }
        $fournisseur= $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$devis['Deviprospect']['fournisseur_id']),false));
        $devise=$fournisseur['Fournisseur']['devise_id'];
        $lignedeviprospects = $this->Lignedeviprospect->find('all',array('conditions'=>array('Lignedeviprospect.deviprospect_id' => $id)));
        $articles=$this->Article->find('list');   
        $fournisseurs = $this->Deviprospect->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id <>'=>1)));
        $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
        if (isset($_GET['t']) ){
        $t=1;
        }else{
        $t=0;    
        }
	$this->set(compact('id','t','devise','coe','tr','importations','fournisseurs','depots','lignedeviprospects','day','articles','fournis'));
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
                if(!empty($lien)){
                foreach($lien as $k=>$liens){
                if(@$liens['lien']=='deviprospects'){
                    $commande=$liens['delete'];
                }}}
                if (( $commande <> 1)||(empty($lien))){
                $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                }
            $this->loadModel('Utilisateur');
            $this->loadModel('Lignedeviprospect');
		$this->Deviprospect->id = $id;
		if (!$this->Deviprospect->exists()) {
			throw new NotFoundException(__('Invalid deviprospect'));
		}
		$this->request->onlyAllow('post', 'delete');
                $this->Lignedeviprospect->deleteAll(array('Lignedeviprospect.deviprospect_id'=>$id),false); 
		if ($this->Deviprospect->delete()) {
			$this->Session->setFlash(__('Deviprospect deleted'));
			$this->redirect(array('action' => 'index'));
		}
                $devis=$this->Deviprospect->find('count');
                $this->Utilisateur->updateAll(array('Utilisateur.notifdevis' => $devis), array('Utilisateur.id in(12,15)'));
		$this->Session->setFlash(__('Deviprospect was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        
        
      public function notifdevis() {
             
            $this->loadModel('Utilisateur');
            $this->loadModel('Ligneworkflow');
            $this->loadModel('Lignevalide');
             $this->layout = null;
             $data=$this->request->data;
             $d= $data['personnel'];
             $personnel = $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$d)));
             $devis=$this->Deviprospect->find('count');
             $nbrworkflows=$this->Ligneworkflow->find('count',array('conditions'=>array('Ligneworkflow.personnel_id'=>$personnel['Personnel']['id'],'Ligneworkflow.typeworkflow_id'=>2,'Workflow.document_id'=>1),'recursive'=>2));
             //debug($nbrworkflows);
             $ligneworkflow=$this->Ligneworkflow->find('first',array('conditions'=>array('Ligneworkflow.personnel_id'=>$personnel['Personnel']['id'],'Ligneworkflow.typeworkflow_id'=>2,'Workflow.document_id'=>1),'recursive'=>2));
             $lignevalides=$this->Lignevalide->find('count',array('conditions'=>array('Lignevalide.ligneworkflow_id'=>$ligneworkflow['Ligneworkflow']['id']),'recursive'=>2));
             if($nbrworkflows >0){
             $utilisateur = $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$d)));
             $notifdevis=$utilisateur['Utilisateur']['notifdevis'];
             }
             $listedevis=$this->Deviprospect->query('select * from deviprospects where id not in (select id_piece from lignevalides where document_id=1 and personnel_id='.$personnel['Personnel']['id'].') and etat=0');
             //debug($listedevis);
             $nbrdevis=$this->Deviprospect->query('select count(*) from deviprospects where id not in (select id_piece from lignevalides where document_id=1 and personnel_id='.$personnel['Personnel']['id'].') and etat=0');
             //debug($nbrdevis[0][0]['count(*)']);die;
             $nbdevis=$nbrdevis[0][0]['count(*)'];
             echo json_encode(array('notifdevis'=>$notifdevis,'devis'=>$devis,'d'=>$d,'listedevis'=>$listedevis,'lignevalides'=>$lignevalides,'nbdevis'=>$nbdevis,'nbrworkflows'=>$nbrworkflows));
             die;
	}   
        
        
        
}
