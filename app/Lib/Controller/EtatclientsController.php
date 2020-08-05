<?php
App::uses('AppController', 'Controller');
/**
 * Etatclients Controller
 *
 * @property Etatclient $Etatclient
 */
class EtatclientsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$lien=  CakeSession::read('lien_stat');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatclients'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
	$this->loadModel('Bonlivraison'); 
        $this->loadModel('Factureclient');
        $this->loadModel('Client'); 
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Tabetatclient');
        
        
        $this->Tabetatclient->query('TRUNCATE tabetatclients;');  
        
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe=date('Y');
        $exercice = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
        $exerciceid=$exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id ='.$exe;
        $condf4 = 'Factureclient.exercice_id ='.$exe;
        $pv="";
        $p=CakeSession::read('pointdevente');
        if($p>0){
          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
          $pvf= 'Factureclient.pointdevente_id = '.$p;
        }
         if ($this->request->is('post')) { 
        //debug($this->request->data);die;
        if ($this->request->data['Recherche']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= '."'".$date1."'";
            $condf4="";
            $condb4="";
        }
        
        if ($this->request->data['Recherche']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= '."'".$date2."'";
            $condf4="";
            $condb4="";
        }
        
       if ($this->request->data['Recherche']['client_id']) {
            $clientid= $this->request->data['Recherche']['client_id'];
            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id ='.$clientid;
        } 
         if ($this->request->data['Recherche']['exercice_id']) {
            $exerciceid = $this->request->data['Recherche']['exercice_id'];
            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id ='.$exercices[$exerciceid];
        } 
        if (!empty($this->request->data['Recherche']['pointdevente_id'])) {
            $pointdeventeid = $this->request->data['Recherche']['pointdevente_id'];
            $condb5 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id ='.$pointdeventeid;
        } 
        
    } 
  $bonlivraisonparprixs = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalht) as total','Client.name','Client.id')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,@$pvb, @$condb1, @$condb2, @$condb3 , @$condb4, @$condb5)
  ,'group'=>array('Bonlivraison.client_id')));
  
  
   $bonlivraisonpartotales = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalht) as total')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0)));
   
  $factureclientparprixs = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalht) as total','Client.name','Client.id')
   , 'conditions' => array('Factureclient.id > ' => 0,@$pvf, @$condf1, @$condf2, @$condf3 , @$condf4, @$condf5)
   ,'group'=>array('Factureclient.client_id')));
  
  $factureclientpartotales = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalht) as total'), 'conditions' => array('Factureclient.id > ' => 0)));
  
  $totaleBLF=$bonlivraisonpartotales[0][0]['total']+$factureclientpartotales[0][0]['total'];
   //debug($factureclientpartotales);die;
       $tab=array();
       $i=0;
       //debug($bonlivraisonparprixs);
       //debug($factureclientparprixs);die;
       foreach ($factureclientparprixs as $facture){
       $tab[$i]['clientid']= $facture['Client']['id'];     
       $tab[$i]['name']= $facture['Client']['name'];    
       $tab[$i]['tot']= $facture[0]['total'];
       $tab[$i]['por']= round(($facture[0]['total']/$totaleBLF)*100,3);
       $this->Tabetatclient->create();
       $this->Tabetatclient->save($tab[$i]);
       $i++;
       }
       //debug($tab);die;
       $tab=array();
       $index=0;
       foreach ($bonlivraisonparprixs as $bonlivraison){
       $tab[$index]['clientid']= $bonlivraison['Client']['id'];
       $tab[$index]['name']= $bonlivraison['Client']['name'];
       $tab[$index]['tot']= $bonlivraison[0]['total']; 
       $tab[$index]['por']= round(($bonlivraison[0]['total']/$totaleBLF)*100,3);
       $this->Tabetatclient->create();
       $this->Tabetatclient->save($tab[$index]); 
       $index++;
       }
       
       
       
       $tab = $this->Tabetatclient->find('all', array(
       'fields'=>array('sum(Tabetatclient.tot) as tot','clientid','name','article','sum(Tabetatclient.qte) as qte')
       ,'group'=>array('Tabetatclient.clientid')
       ,'order'=>array('sum(Tabetatclient.tot)'=>'desc')    
       ,'recursive'=>2));
        
      
		
        $clients = $this->Client->find('list');
        $this->set(compact('pointdeventeid','totaleBLF','tab','bonlivraisons','pointdeventes','exerciceid','exercices','date1','date2','clientid','clients','factureclients'));

	}
    public function imprimerrecherche() { 
        $lien=  CakeSession::read('lien_stat');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatclients'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
	$this->loadModel('Bonlivraison'); 
        $this->loadModel('Factureclient');
        $this->loadModel('Client'); 
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Tabetatclient');
        
        
        $this->Tabetatclient->query('TRUNCATE tabetatclients;');  
       
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe=date('Y');
        $exercice = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
        $exerciceid=$exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id ='.$exe;
        $condf4 = 'Factureclient.exercice_id ='.$exe;
        $pv="";
        $p=CakeSession::read('pointdevente');
        if($p>0){
          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
          $pvf= 'Factureclient.pointdevente_id = '.$p;
        }
        
        //debug($this->request->data);die;
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= '."'".$date1."'";
            $condf4="";
            $condb4="";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= '."'".$date2."'";
            $condf4="";
            $condb4="";
        }
        
       if ($this->request->query['clientid']) {
            $clientid= $this->request->query['clientid'];
            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id ='.$clientid;
        } 
         if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id ='.$exercices[$exerciceid];
        } 
        if (!empty($this->request->query['pointdeventeid'])) {
            $pointdeventeid = $this->request->query['pointdeventeid'];
            $condb5 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id ='.$pointdeventeid;
        } 
        
    
  $bonlivraisonparprixs = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalht) as total','Client.name','Client.id')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,@$pvb, @$condb1, @$condb2, @$condb3 , @$condb4, @$condb5)
  ,'group'=>array('Bonlivraison.client_id')));
  
  
   $bonlivraisonpartotales = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalht) as total')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0)));
   
  $factureclientparprixs = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalht) as total','Client.name','Client.id')
   , 'conditions' => array('Factureclient.id > ' => 0,@$pvf, @$condf1, @$condf2, @$condf3 , @$condf4, @$condf5)
   ,'group'=>array('Factureclient.client_id')));
  
  $factureclientpartotales = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalht) as total'), 'conditions' => array('Factureclient.id > ' => 0)));
  
  $totaleBLF=$bonlivraisonpartotales[0][0]['total']+$factureclientpartotales[0][0]['total'];
   //debug($factureclientpartotales);die;
       $tab=array();
       $i=0;
       //debug($bonlivraisonparprixs);
       //debug($factureclientparprixs);die;
       foreach ($factureclientparprixs as $facture){
       $tab[$i]['clientid']= $facture['Client']['id'];     
       $tab[$i]['name']= $facture['Client']['name'];    
       $tab[$i]['tot']= $facture[0]['total'];
       $tab[$i]['por']= round(($facture[0]['total']/$totaleBLF)*100,3);
       $this->Tabetatclient->create();
       $this->Tabetatclient->save($tab[$i]);
       $i++;
       }
       //debug($tab);die;
       $tab=array();
       $index=0;
       foreach ($bonlivraisonparprixs as $bonlivraison){
       $tab[$index]['clientid']= $bonlivraison['Client']['id'];
       $tab[$index]['name']= $bonlivraison['Client']['name'];
       $tab[$index]['tot']= $bonlivraison[0]['total']; 
       $tab[$index]['por']= round(($bonlivraison[0]['total']/$totaleBLF)*100,3);
       $this->Tabetatclient->create();
       $this->Tabetatclient->save($tab[$index]); 
       $index++;
       }
       
       
       
       $tab = $this->Tabetatclient->find('all', array(
       'fields'=>array('sum(Tabetatclient.tot) as tot','clientid','name','article','sum(Tabetatclient.qte) as qte')
       ,'group'=>array('Tabetatclient.clientid')
       ,'order'=>array('sum(Tabetatclient.tot)'=>'desc')    
       ,'recursive'=>2));
        //debug($tab);die;
      
		
                $clients = $this->Client->find('list');
                 $this->set(compact('pointdeventeid','totaleBLF','tab','bonlivraisons','pointdeventes','exerciceid','exercices','date1','date2','clientid','clients','factureclients'));

         }

	

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Etatclient->exists($id)) {
			throw new NotFoundException(__('Invalid etatclient'));
		}
		$options = array('conditions' => array('Etatclient.' . $this->Etatclient->primaryKey => $id));
		$this->set('etatclient', $this->Etatclient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Etatclient->create();
			if ($this->Etatclient->save($this->request->data)) {
				$this->Session->setFlash(__('The etatclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatclient could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Etatclient->exists($id)) {
			throw new NotFoundException(__('Invalid etatclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Etatclient->save($this->request->data)) {
				$this->Session->setFlash(__('The etatclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Etatclient.' . $this->Etatclient->primaryKey => $id));
			$this->request->data = $this->Etatclient->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Etatclient->id = $id;
		if (!$this->Etatclient->exists()) {
			throw new NotFoundException(__('Invalid etatclient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Etatclient->delete()) {
			$this->Session->setFlash(__('Etatclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Etatclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
