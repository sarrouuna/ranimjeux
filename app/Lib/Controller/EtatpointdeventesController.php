<?php
App::uses('AppController', 'Controller');
/**
 * Etatpointdeventes Controller
 *
 * @property Etatpointdevente $Etatpointdevente
 */
class EtatpointdeventesController extends AppController {

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
  $bonlivraisonparprixs = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalht) as total,sum(Bonlivraison.Montant_Regler) as totalregler','pointdevente_id')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,@$pvb, @$condb1, @$condb2, @$condb3 , @$condb4, @$condb5)
  ,'group'=>array('Bonlivraison.pointdevente_id')
  ,'contain'=>array('Pointdevente.name'),'recursive'=>2));
   $bonlivraisonpartotales = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalht) as total')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0)));
 $factureclientparprixs = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalht) as total,sum(Factureclient.Montant_Regler) as totalregler','pointdevente_id')
  ,'conditions' => array('Factureclient.id > ' => 0,@$pvf, @$condf1, @$condf2, @$condf3 , @$condf4, @$condf5)
  ,'group'=>array('Factureclient.pointdevente_id')
  ,'contain'=>array('Pointdevente.name'),'recursive'=>2));
 $factureclientpartotales = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalht) as total'), 'conditions' => array('Factureclient.id > ' => 0)));
  $totaleBLF=$bonlivraisonpartotales[0][0]['total']+$factureclientpartotales[0][0]['total'];
   //debug($bonlivraisonparprixs);die;
   $tab=array();
   
       foreach ($factureclientparprixs as $i=>$facture){
           foreach ($bonlivraisonparprixs as $bonlivraison){
               if($facture['Pointdevente']['id']==$bonlivraison['Pointdevente']['id']){
                    $tab[$i]['PVname']= $facture['Pointdevente']['name'];    
                    $tab[$i]['tot']= $facture[0]['total']+$bonlivraison[0]['total']; 
                    $tab[$i]['mtregler']=$facture[0]['totalregler']+$bonlivraison[0]['totalregler']; 
                    $tab[$i]['por']=sprintf("%01.3f",(($facture[0]['total']+$bonlivraison[0]['total'])/$totaleBLF)*100); 
           }
           }
           if(@$tab[$i]['PVname']==""){
                    $tab[$i]['PVname']= $facture['Pointdevente']['name'];    
                    $tab[$i]['tot']= $facture[0]['total']; 
                    $tab[$i]['mtregler']=$facture[0]['totalregler'];
                    $tab[$i]['por']=sprintf("%01.3f",($facture[0]['total']/$totaleBLF)*100); 
           }
           }
        //debug($tab);die;
      
		
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
        
       
         if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id ='.$exercices[$exerciceid];
        } 
        if (!empty($this->request->query['pointdeventeid'])) {
            $pointdeventeid = $this->request->query['pointdeventeid'];
            $condb5 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id ='.$pointdeventeid;
            $pointvente= $this->Pointdevente->find('first',array('conditions'=>array('Pointdevente.id'=>$pointdeventeid)));
            $name=$pointvente['Pointdevente']['name'];
        } 
        
    
  $bonlivraisonparprixs = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalttc) as total,sum(Bonlivraison.Montant_Regler) as totalregler','pointdevente_id')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,@$pvb, @$condb1, @$condb2, @$condb3 , @$condb4, @$condb5)
  ,'group'=>array('Bonlivraison.pointdevente_id')
  ,'contain'=>array('Pointdevente.name'),'recursive'=>2));
   $bonlivraisonpartotales = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalttc) as total')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0)));
 $factureclientparprixs = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalttc) as total,sum(Factureclient.Montant_Regler) as totalregler','pointdevente_id')
  ,'conditions' => array('Factureclient.id > ' => 0,@$pvf, @$condf1, @$condf2, @$condf3 , @$condf4, @$condf5)
  ,'group'=>array('Factureclient.pointdevente_id')
  ,'contain'=>array('Pointdevente.name'),'recursive'=>2));
 $factureclientpartotales = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalttc) as total'), 'conditions' => array('Factureclient.id > ' => 0)));
  $totaleBLF=$bonlivraisonpartotales[0][0]['total']+$factureclientpartotales[0][0]['total'];
   //debug($bonlivraisonparprixs);die;
   $tab=array();
    foreach ($factureclientparprixs as $i=>$facture){
           foreach ($bonlivraisonparprixs as $bonlivraison){
               if($facture['Pointdevente']['id']==$bonlivraison['Pointdevente']['id']){
                    $tab[$i]['PVname']= $facture['Pointdevente']['name'];    
                    $tab[$i]['tot']= $facture[0]['total']+$bonlivraison[0]['total']; 
                    $tab[$i]['mtregler']=$facture[0]['totalregler']+$bonlivraison[0]['totalregler']; 
                    $tab[$i]['por']=sprintf("%01.3f",(($facture[0]['total']+$bonlivraison[0]['total'])/$totaleBLF)*100); 
           }
           }
           if(@$tab[$i]['PVname']==""){
                    $tab[$i]['PVname']= $facture['Pointdevente']['name'];    
                    $tab[$i]['tot']= $facture[0]['total']; 
                    $tab[$i]['mtregler']=$facture[0]['totalregler'];
                    $tab[$i]['por']=sprintf("%01.3f",($facture[0]['total']/$totaleBLF)*100); 
           }
           }
        //debug($tab);die;
      
		
                $clients = $this->Client->find('list');
                 $this->set(compact('name','pointdeventeid','totaleBLF','tab','bonlivraisons','pointdeventes','exerciceid','exercices','date1','date2','clientid','clients','factureclients'));

         }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Etatpointdevente->exists($id)) {
			throw new NotFoundException(__('Invalid etatpointdevente'));
		}
		$options = array('conditions' => array('Etatpointdevente.' . $this->Etatpointdevente->primaryKey => $id));
		$this->set('etatpointdevente', $this->Etatpointdevente->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Etatpointdevente->create();
			if ($this->Etatpointdevente->save($this->request->data)) {
				$this->Session->setFlash(__('The etatpointdevente has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatpointdevente could not be saved. Please, try again.'));
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
		if (!$this->Etatpointdevente->exists($id)) {
			throw new NotFoundException(__('Invalid etatpointdevente'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Etatpointdevente->save($this->request->data)) {
				$this->Session->setFlash(__('The etatpointdevente has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatpointdevente could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Etatpointdevente.' . $this->Etatpointdevente->primaryKey => $id));
			$this->request->data = $this->Etatpointdevente->find('first', $options);
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
		$this->Etatpointdevente->id = $id;
		if (!$this->Etatpointdevente->exists()) {
			throw new NotFoundException(__('Invalid etatpointdevente'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Etatpointdevente->delete()) {
			$this->Session->setFlash(__('Etatpointdevente deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Etatpointdevente was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
