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
            
            if ($this->request->is('post')) { 
                //debug($this->request->data);    
                
            if ($this->request->data['Recherche']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= '."'".$date1."'";
            $condfa1 = 'Factureavoir.date >= '."'".$date1."'";
            $condbb1 = 'Reglementclient.date >= '."'".$date1."'";
           
            $condb4="";
            $condf4="";
            $condfa4="";
            $condr4="";
        }
        
        if ($this->request->data['Recherche']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= '."'".$date2."'";
            $condfa2 = 'Factureavoir.date <= '."'".$date2."'";
            $condbr2 = 'Reglementclient.date <= '."'".$date2."'";
            
            $condb4="";
            $condf4="";
            $condfa4="";
            $condr4="";
            
            
        }    
                    
         if ($this->request->data['Recherche']['client_id']) {
            $clientid= $this->request->data['Recherche']['client_id'];
            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id ='.$clientid;
            $condfa3='Factureavoir.client_id ='.$clientid;
            $condr3 = 'Reglementclient.client_id ='.$clientid;
        }
        
         if ($this->request->data['Recherche']['exercice_id']) {
            $exerciceid = $this->request->data['Recherche']['exercice_id'];
            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id ='.$exercices[$exerciceid];
            $condfa4 = 'Factureavoir.exercice_id ='.$exercices[$exerciceid];
            $condr4 = 'Reglementclient.exercice_id ='.$exercices[$exerciceid];
        }
        if ($this->request->data['Recherche']['personnel_id']) {
            $personnelid= $this->request->data['Recherche']['personnel_id'];
            $cond5 = 'Client.personnel_id ='.$personnelid;
            $personnel= $this->Personnel->find('all',array('conditions'=>array('Personnel.id'=>$personnelid),false));
            $name=$personnel[0]['Personnel']['name'];
//            $condf5 = 'Client.personnel_id ='.$personnelid;
//            $condfa5='Client.personnel_id ='.$personnelid;
//            $condr5 = 'Client.personnel_id ='.$personnelid;
//            $clientrs=$this->Client->find('all',array('conditions'=>array('Client.personnel_id'=>$personnelid)));
//            $ch=0;
//            foreach ($clientrs as $clientr){
//                $ch=$ch.','.$clientr['Client']['id'];
//            }
//            $cond5 = 'Client.personnel_id in ('.$ch.')';
        }
        
          
            $factureavoirs=$this->Factureavoir->find('all', array(
            'conditions' => array(@$condfa1,@$condfa2,@$condfa3,@$condfa4,@$cond5),'recursive'=>0 ));
//            foreach ($factureavoirs as $factureavoir) {
//            //$tablignedevis['numclt']=$factureavoir['Client']['code'];
//            $tablignedevis['client_id']=$factureavoir['Factureavoir']['client_id'];
//            $tablignedevis['date']=$factureavoir['Factureavoir']['date'];
//            $tablignedevis['numero']=$factureavoir['Factureavoir']['numero'];
//            $tablignedevis['type']="Factureavoir";
//            $tablignedevis['debit']="";
//            $tablignedevis['credit']=$factureavoir['Factureavoir']['totalttc'];
//            $tablignedevis['impaye']="";
//            $tablignedevis['reglement']="";
//            $tablignedevis['avoir']=$factureavoir['Factureavoir']['totalttc'];
//            $tablignedevis['solde']=0;
//            $this->Relefe->create();
//            $this->Relefe->save($tablignedevis);
//            }
            
            
            
            $bonlivraisons= $this->Bonlivraison->find('all', array('conditions' => array(
            'Bonlivraison.id > 0' ,'Bonlivraison.factureclient_id'=>0,'Bonlivraison.totalttc >Bonlivraison.Montant_Regler',@$condb1,@$condb2,@$condb3,@$condb4,@$cond5 ),'recursive'=>0 ));
//            foreach ($bonlivraisons as $bonlivraison) {
//            //$tablignelivraisons['numclt']=$bonlivraison['Client']['code'];
//            $tablignelivraisons['client_id']=$bonlivraison['Bonlivraison']['client_id'];
//            $tablignelivraisons['date']=$bonlivraison['Bonlivraison']['date'];
//            $tablignelivraisons['numero']=$bonlivraison['Bonlivraison']['numero'];
//            $tablignelivraisons['type']="Bonlivraison";
//            $tablignelivraisons['debit']=$bonlivraison['Bonlivraison']['totalttc'];
//            $tablignelivraisons['credit']="";
//            $tablignelivraisons['impaye']="";
//            $tablignelivraisons['reglement']=$bonlivraison['Bonlivraison']['Montant_Regler'];
//            $tablignelivraisons['avoir']="";
//            $tablignelivraisons['solde']=$bonlivraison['Bonlivraison']['totalttc']-$bonlivraison['Bonlivraison']['Montant_Regler'];
//            $this->Relefe->create();
//            $this->Relefe->save($tablignelivraisons);
//            }
            
            
            $factureclients = $this->Factureclient->find('all', array('conditions' => array(
            'Factureclient.id > 0','Factureclient.totalttc >Factureclient.Montant_Regler',@$condf1,@$condf2,@$condf3,@$condf4,@$cond5),'recursive'=>0));
//            foreach ($factureclients as $factureclient) {
//            $tablignefactureclients['numclt']=$factureclient['Client']['code'];
//            $tablignefactureclients['client_id']=$factureclient['Factureclient']['client_id'];
//            $tablignefactureclients['date']=$factureclient['Factureclient']['date'];
//            $tablignefactureclients['numero']=$factureclient['Factureclient']['numero'];
//            $tablignefactureclients['type']="Facture";
//            $tablignefactureclients['debit']=$factureclient['Factureclient']['totalttc'];
//            $tablignefactureclients['credit']="";
//            $tablignefactureclients['impaye']="";
//            $tablignefactureclients['reglement']=$factureclient['Factureclient']['Montant_Regler'];
//            $tablignefactureclients['avoir']="";
//            $tablignefactureclients['solde']=$factureclient['Factureclient']['totalttc']-$factureclient['Factureclient']['Montant_Regler'];
//            $this->Relefe->create();
//            $this->Relefe->save($tablignefactureclients);
//            }
            
            $reglementlibres = $this->Reglementclient->find('all', array('conditions' => array(
            'Reglementclient.id > 0','Reglementclient.Montant > Reglementclient.montantaffecte',@$condr1,@$condr2,@$condr3,@$condr4,@$cond5),'recursive'=>0));
           // debug($reglementlibres);
//            foreach ($reglementlibres as $reglementlibre) {
//            //$tablignereglementlibres['numclt']=$reglementlibre['Client']['code'];
//            $tablignereglementlibres['client_id']=$reglementlibre['Reglementclient']['client_id'];
//            $tablignereglementlibres['date']=$reglementlibre['Reglementclient']['Date'];
//            $tablignereglementlibres['numero']=$reglementlibre['Reglementclient']['numero'];
//            $liste="";
//            $Piecereglementclients=$this->Piecereglementclient->find('all', array('condition'=>array('Piecereglementclient.reglementclient_id'),'recursive'=>-1 ));
//            foreach ($Piecereglementclients as $k=>$Piece) {
//            if($k==0){
//            $liste=$liste."".$Piece['Piecereglementclient']['num'];
//            }else{
//            $liste=$liste.",".$Piece['Piecereglementclient']['num'];
//            }
//            }
//            $tablignereglementlibres['type']=$liste;
//            $tablignereglementlibres['debit']="";
//            $tablignereglementlibres['credit']=$reglementlibre['Reglementclient']['Montant'];
//            $tablignereglementlibres['impaye']="";
//            $m=0;
//            $Lignereglementclients=$this->Lignereglementclient->find('all', array('condition'=>array('Lignereglementclient.reglementclient_id'),'recursive'=>-1 ));
//            foreach ($Lignereglementclients as $l=>$Ligne) {
//            $m=$m+$Ligne['Lignereglementclient']['Montant'];
//            }
//            $tablignereglementlibres['reglement']=$m;
//            $tablignereglementlibres['avoir']="";
//            $tablignereglementlibres['solde']=$m-$reglementlibre['Reglementclient']['Montant'];
//            $this->Relefe->create();
//            $this->Relefe->save($tablignereglementlibres);
//            }            
          
                                
        //$relefes=$this->Relefe->find('all', array('group'=>array('Relefe.client_id'),'recursive'=>-1 ));
                     
     $piecereglements = $this->Piecereglementclient->find('all', array('conditions' => array(
            'Piecereglementclient.id > 0','Piecereglementclient.paiement_id in (2,3)','Piecereglementclient.reglement=0','Piecereglementclient.situation="Impayé"',@$condr1,@$condr2,@$condr3,@$condr4,@$cond5),'recursive'=>2));   
    // debug($piecereglements);
      }        
        $clients = $this->Client->find('list'); 
        $personnels = $this->Personnel->find('list');        
            
        $this->set(compact('piecereglements','factureavoirs','bonlivraisons','factureclients','reglementlibres','articles','clients','personnels','exercices','exerciceid','date1','client_id','marque_id','date2','name'));
    
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
