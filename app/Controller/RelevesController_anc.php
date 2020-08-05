<?php
App::uses('AppController', 'Controller');



class RelevesController extends AppController {


	public function index() {
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
            $exercices = $this->Exercice->find('list');
            $exe=date('Y');
            $exercicet = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
            $exerciceid=$exercicet['Exercice']['id'];
            $condb4 = 'Bonlivraison.exercice_id ='.$exe;
            $condf4 = 'Factureclient.exercice_id ='.$exe;
            $condfa4 = 'Factureavoir.exercice_id ='.$exe;
            $condr4 = 'Reglementclient.exercice_id ='.$exe;
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
            
            
            
        //$this->Relefe->deleteAll(array('Relefe.id >'=>0),false);
            $c5="";
            $this->request->data['Recherche']['date1']='01/01/2015';
            $this->request->data['Recherche']['date2']=date('d/m/Y');
            if ($this->request->is('post')) { 
                //debug($this->request->data);    
                $this->Relefe->query('TRUNCATE releves;');
                //die;
            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= '."'".$date1."'";
            $condfa1 = 'Factureavoir.date >= '."'".$date1."'";
            $condbb1 = 'Reglementclient.date >= '."'".$date1."'";
            $condss1='Piecereglementclient.datesituation >= '."'".$date1."'";
            $condbs = 'Bonlivraison.date < '."'".$date1."'";
            $condfs = 'Factureclient.date < '."'".$date1."'";
            $condfas = 'Factureavoir.date < '."'".$date1."'";
            $condbbs = 'Reglementclient.date < '."'".$date1."'";
            $condss='Piecereglementclient.datesituation < '."'".$date1."'";
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
            $condss2='Piecereglementclient.datesituation <= '."'".$date2."'";
            
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
        }
        
         
        if ($this->request->data['Recherche']['personnel_id']) {
            $personnelid= $this->request->data['Recherche']['personnel_id'];
            $cond5 = 'Client.personnel_id ='.$personnelid;
            $personnel= $this->Personnel->find('all',array('conditions'=>array('Personnel.id'=>$personnelid),false));
            $name=$personnel[0]['Personnel']['name'];
        }
        
            $solde=0;
            $factureavoirs=$this->Factureavoir->find('all', array(
            'conditions' => array(@$condfa1,@$condfa2,@$condfa3,@$condfa4,@$cond5),'recursive'=>0 ));
            $soldeavoir=$this->Factureavoir->find('first', array(
            'fields'=>array('sum(Factureavoir.totalttc) as solde'),    
            'conditions' => array(@$condfas,$condfa3),'recursive'=>0 ));
            if(!empty($soldeavoir)){
                $solde=$solde-$soldeavoir[0]['solde'];
                
            }
            
            $bonlivraisons= $this->Bonlivraison->find('all', array('conditions' => array(
            'Bonlivraison.factureclient_id'=>0,'Bonlivraison.totalttc >Bonlivraison.Montant_Regler',@$condb1,@$condb2,@$condb3,@$condb4,@$cond5 ),'recursive'=>0 ));
            $soldebl=$this->Bonlivraison->find('first', array(
            'fields'=>array('sum((Bonlivraison.totalttc)) as solde'),    
            'conditions' => array(@$condbs,$condb3,'Bonlivraison.factureclient_id'=>0),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde+$soldebl[0]['solde'];
                
            }
            
            $factureclients = $this->Factureclient->find('all', array('conditions' => array(
            'Factureclient.totalttc >Factureclient.Montant_Regler',@$condf1,@$condf2,@$condf3,@$condf4,@$cond5),'recursive'=>0));
            $soldefac=$this->Factureclient->find('first', array(
            'fields'=>array('sum((Factureclient.totalttc)) as solde'),    
            'conditions' => array(@$condfs,$condf3),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde+$soldefac[0]['solde'];
                
            }
            $reglementlibres = $this->Reglementclient->find('all', array('conditions' => array(
            @$condbr1,@$condbr2,@$condr3,@$condr4,@$cond5,$condbb1,"Reglementclient.emi!='052'"),'recursive'=>0));
            $soldereg=$this->Reglementclient->find('first', array(
            'fields'=>array('sum((Reglementclient.Montant)) as solde'),    
            'conditions' => array(@$condbbs,$condr3,"Reglementclient.emi!='052'"),'recursive'=>0 ));
            if(!empty($soldereg)){
                $solde=$solde-$soldereg[0]['solde'];
            }
            $piecereglements = $this->Piecereglementclient->find('all', array('conditions' => array(
            'Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.reglement=0','Piecereglementclient.situation="Impayé"',@$condr1,@$condss2,@$condr3,@$condr4,@$cond5,$condss1),'recursive'=>0));   
             $soldepiece=$this->Piecereglementclient->find('first', array(
            'fields'=>array('sum(Piecereglementclient.montant) as solde'),    
            'conditions' => array(@$condss,$condr3,'Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.reglement=0','Piecereglementclient.situation="Impayé"'),'recursive'=>0 ));
            if(!empty($soldepiece)){
                $solde=$solde+$soldepiece[0]['solde'];
                
            }
      } 
        
        $clients = $this->Client->find('list'); 
        $personnels = $this->Personnel->find('list');        
            
        $this->set(compact('solde','clientid','c5','c4','c3','c2','c1','piecereglements','factureavoirs','bonlivraisons','factureclients','reglementlibres','articles','clients','personnels','exercices','exerciceid','date1','clientid','marque_id','date2','name'));
    
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
           
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
           
        }
        
       if ($this->request->query['name']) {
            $name = $this->request->query['name'];
            
        } 
        $relefes=$this->Relefe->find('all', array('order'=>array('Relefe.client_id'),'recursive'=>0 ));
        //debug($relefes);
        $this->set(compact('relefes','date1','date2','name'));
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
        
       
        }
