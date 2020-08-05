<?php
App::uses('AppController', 'Controller');
/**
 * Engagementfournisseurs Controller
 *
 * @property Engagementfournisseur $Engagementfournisseur
 */
class EngagementfournisseursController extends AppController {

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
                if(@$liens['lien']=='engagementfournisseurs'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
       $this->loadModel('Fournisseur');       
       $this->loadModel('Etatpiecereglement');  
       $this->loadModel('Exercice'); 
       $this->loadModel('Piecereglement');
       $exercices = $this->Exercice->find('list');
         if (isset($this->request->data) && !empty($this->request->data)) {
        if ($this->request->data['Engagementfournisseur']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Engagementfournisseur']['date1'])));
            $cond1 = 'Reglement.date >= '."'".$date1."'";
        }
        
        if ($this->request->data['Engagementfournisseur']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Engagementfournisseur']['date2'])));
            $cond2 = 'Reglement.date <= '."'".$date2."'";
        }
        
       if ($this->request->data['Engagementfournisseur']['fournisseur_id']) {
            $fournisseurid = $this->request->data['Engagementfournisseur']['fournisseur_id'];
            $cond3 = 'Reglement.fournisseur_id ='.$fournisseurid;
        } 
        
        if ($this->request->data['Engagementfournisseur']['etatpiecereglement_id']!='') {
            $etatpiecereglementid = $this->request->data['Engagementfournisseur']['etatpiecereglement_id'];
            $cond4 = 'Piecereglement.etatpiecereglement_id ='.$etatpiecereglementid;  
        }
        
    } 
  $piecereglements = $this->Piecereglement->find('all', array( 'conditions' => array('Piecereglement.id > ' => 0,'Reglement.importation_id <> ' => 0,'Piecereglement.paiement_id in (4,6,7)',@$cond1, @$cond2, @$cond3,@$cond4 ),'recursive'=>1));
  $etatpiecereglements = $this->Etatpiecereglement->find('list',array('recursive'=>1));
  $fournisseurs = $this->Fournisseur->find('list',array('conditions'=>array('Fournisseur.devise_id <>'=>1)));
    $this->set(compact('etatpiecereglementid','etatpiecereglements','exercices','date1','date2','fournisseurid','utilisateurid','fournisseurs','clotureid','clotures','utilisateurs','piecereglements',$this->paginate()));
}




    public function imprimerrecherche() { 
        $lien=  CakeSession::read('lien_achat');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='engagementfournisseurs'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
       $this->loadModel('Fournisseur');       
       $this->loadModel('Etatpiecereglement');  
       $this->loadModel('Exercice'); 
       $this->loadModel('Piecereglement');
       //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Reglement.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Reglement.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Reglement.fournisseur_id ='.$fournisseurid;
        } 
        if ($this->request->query['etatpiecereglementid']) {
            $etatpiecereglementid = $this->request->query['etatpiecereglementid'];
            $cond4 = 'Piecereglement.etatpiecereglement_id ='.$etatpiecereglementid;
        }
        
        
  $piecereglements = $this->Piecereglement->find('all', array( 'conditions' => array('Piecereglement.id > ' => 0,'Reglement.importation_id <> ' => 0,'Piecereglement.paiement_id in (4,6,7)',@$cond1, @$cond2, @$cond3,@$cond4 ),'recursive'=>1));

                 $this->set(compact('piecereglements','etatpiecereglementid','date1','date2','fournisseurid','clotureid'));     
   
         }
         
         
         
         
         
         
	public function view($id = null) {
		if (!$this->Engagementfournisseur->exists($id)) {
			throw new NotFoundException(__('Invalid engagementfournisseur'));
		}
		$options = array('conditions' => array('Engagementfournisseur.' . $this->Engagementfournisseur->primaryKey => $id));
		$this->set('engagementfournisseur', $this->Engagementfournisseur->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Engagementfournisseur->create();
			if ($this->Engagementfournisseur->save($this->request->data)) {
				$this->Session->setFlash(__('The engagementfournisseur has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The engagementfournisseur could not be saved. Please, try again.'));
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
		if (!$this->Engagementfournisseur->exists($id)) {
			throw new NotFoundException(__('Invalid engagementfournisseur'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Engagementfournisseur->save($this->request->data)) {
				$this->Session->setFlash(__('The engagementfournisseur has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The engagementfournisseur could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Engagementfournisseur.' . $this->Engagementfournisseur->primaryKey => $id));
			$this->request->data = $this->Engagementfournisseur->find('first', $options);
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
		$this->Engagementfournisseur->id = $id;
		if (!$this->Engagementfournisseur->exists()) {
			throw new NotFoundException(__('Invalid engagementfournisseur'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Engagementfournisseur->delete()) {
			$this->Session->setFlash(__('Engagementfournisseur deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Engagementfournisseur was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        public function recap() {
            $this->loadModel('Etatpiecereglement');
            $this->loadModel('Situationpiecereglement');
             $this->layout = null;
             $data=$this->request->data;
             $piecereglement_id= $data['index'];
             $piecereglement_tab=explode(',',$piecereglement_id);
             $result = count($piecereglement_tab);
             $etatpiecereglements = $this->Etatpiecereglement->find('list',array('conditions'=>array('Etatpiecereglement.id in (1,2,3,4)'))); //(1,3,7,8,9,10,11,12)
             $situationpiecereglements= $this->Situationpiecereglement->find('all',array('conditions'=>array('Situationpiecereglement.piecereglement_id'=>$piecereglement_id),false));   
             $this->set(compact('result','piecereglement_id','etatpiecereglements','situationpiecereglements'));
               
	}
        
        
        public function misajourrecap() {
            $this->loadModel('Etatpiecereglement');
            $this->loadModel('Situationpiecereglement');
            $this->loadModel('Piecereglement');
            $nbr_jour_mois="";
             $this->layout = null;
             $data=$this->request->data;
             //debug($data);   
             $piecereglement_id_tab= $data['piecereglement_id'];
             $piecereglement_tab=explode(',',$piecereglement_id_tab);
             $result = count($piecereglement_tab);
             foreach ($piecereglement_tab as $k=>$piecereglement_id){ 
             if($piecereglement_id !=""){  
             $data['piecereglement_id']=$piecereglement_id;     
             $data['date']=date("Y-m-d",strtotime(str_replace('/','-',$data['date'])));
             //$agiosituation= $data['agio'];
             $etatpiecereglement_id= $data['etatpiecereglement_id'];
             $data['utilisateur_id']=CakeSession::read('users');
             $data['datemodification']=date("Y-m-d");
             
             $data['id']='';
             $situationfrs=$this->Situationpiecereglement->find('all',array('conditions'=>array('Situationpiecereglement.piecereglement_id'=>$piecereglement_id)));   
             //debug($situationfrs);die;
             if(!empty($situationfrs)){
             foreach ($situationfrs as $k=>$situation){ 
             if($data['etatpiecereglement_id']==$situation['Situationpiecereglement']['etatpiecereglement_id']){
             $data['id']=$situation['Situationpiecereglement']['id'];    
             }
             }
             }else{
             $data['id']='';    
             }
             
             //debug($data);die;
             $this->Situationpiecereglement->create();
             $this->Situationpiecereglement->save($data);
             $etatpiecereglement=$this->Etatpiecereglement->find('first',array('conditions'=>array('Etatpiecereglement.id'=>$etatpiecereglement_id)));   
             $this->Piecereglement->updateAll(array('Piecereglement.datesituation' =>'"'.$data['date'].'"','Piecereglement.situation' =>'"'.$etatpiecereglement['Etatpiecereglement']['name'].'"','Piecereglement.etatpiecereglement_id' =>$etatpiecereglement_id), array('Piecereglement.id' =>$piecereglement_id));
             if($result==2){
             if(($data['etatpiecereglement_id']==7)||($data['etatpiecereglement_id']==8)||($data['etatpiecereglement_id']==10)){ 
             $nbr_jour_mois="Sur ".$data['nbrjour']." Jours";  
             $data['echancenf']=date("Y-m-d",strtotime(str_replace('/','-',$data['echancenf'])));
             $this->Piecereglement->updateAll(array('Piecereglement.nbrmoins' =>'"'.$nbr_jour_mois.'"','Piecereglement.echance' =>'"'.$data['echancenf'].'"'), array('Piecereglement.id' =>$piecereglement_id));
             }
             }
             }}
             $this->set(compact('piecereglement_id','etatpiecereglements','situationpiecereglement'));
        //die();       
	}
}
