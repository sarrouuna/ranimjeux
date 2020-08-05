<?php
App::uses('AppController', 'Controller');
/**
 * Importations Controller
 *
 * @property Importation $Importation
 */
class ImportationsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $lien=  CakeSession::read('lien_achat');
        $facture="";
        //debug($lien);die;
        if(!empty($lien)){
        foreach($lien as $k=>$liens){
        if(@$liens['lien']=='importations'){
        $facture=1;
        }}}
        if (( $facture <> 1)||(empty($lien))){
        $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }
        
       $this->loadModel('Fournisseur');       
       $this->loadModel('Situation');  
       $this->loadModel('Exercice'); 
       $this->loadModel('Namesituation');
       $exercices = $this->Exercice->find('list');
         if (isset($this->request->data) && !empty($this->request->data)) {
       //debug($this->request->data);die;
        if ($this->request->data['Importation']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Importation']['date1'])));
            $cond1 = 'Importation.date >= '."'".$date1."'";
        }
        
        if ($this->request->data['Importation']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Importation']['date2'])));
            $cond2 = 'Importation.date <= '."'".$date2."'";
        }
        
       if ($this->request->data['Importation']['fournisseur_id']) {
            $fournisseurid = $this->request->data['Importation']['fournisseur_id'];
            $cond3 = 'Importation.fournisseur_id ='.$fournisseurid;
        } 
        
        if ($this->request->data['Importation']['cloture_id']!='') {
            $clotureid = $this->request->data['Importation']['cloture_id'];
            $cond4 = 'Importation.etat ='.$clotureid;  
        }
        if ($this->request->data['Importation']['namesituation_id']!='') {
            $namesituationid = $this->request->data['Importation']['namesituation_id'];
            $cond5 = 'Situation.namesituation_id ='.$namesituationid;  
        } 
        //debug($clotureid);
    } 
  $importations = $this->Importation->find('all', array( 'conditions' => array('Importation.id > ' => 0,@$cond1, @$cond2, @$cond3,@$cond4,@$cond5 ),'recursive'=>1));
      
    $clotures[0]="non cloturer";
    $clotures[1]="cloturer";
    $fournisseurs = $this->Fournisseur->find('list');
    $namesituations = $this->Namesituation->find('list',array('recursive'=>1));
    //debug($importations);
    $this->set(compact('namesituationid','namesituations','exercices','date1','date2','fournisseurid','utilisateurid','fournisseurs','clotureid','clotures','utilisateurs','importations',$this->paginate()));
}

    public function imprimerrecherche() { 
    $lien=  CakeSession::read('lien_achat');
        $facture="";
        //debug($lien);die;
        if(!empty($lien)){
        foreach($lien as $k=>$liens){
        if(@$liens['lien']=='importations'){
        $facture=$liens['imprimer'];
        }}}
        if (( $facture <> 1)||(empty($lien))){
        $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }    
       //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Importation.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Importation.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Importation.fournisseur_id ='.$fournisseurid;
        } 
        if ($this->request->query['clotureid']) {
            $clotureid = $this->request->query['clotureid'];
            $cond4 = 'Importation.etat ='.$utilisateurid;
        }
        if ($this->request->query['namesituationid']) {
            $namesituationid = $this->request->query['namesituationid'];
            $cond5 = 'Situation.namesituation_id ='.$namesituationid;
        }
        
  $importations = $this->Importation->find('all', array( 'conditions' => array('Importation.id > ' => 0,@$cond1, @$cond2, @$cond3,@$cond4,@$cond5 ),'recursive'=>1));

                 $this->set(compact('importations','namesituationid','date1','date2','fournisseurid','clotureid'));     
   
         }
         
         
         public function imprimerview($id = null) {
             $lien=  CakeSession::read('lien_achat');
        $facture="";
        //debug($lien);die;
        if(!empty($lien)){
        foreach($lien as $k=>$liens){
        if(@$liens['lien']=='importations'){
        $facture=$liens['imprimer'];
        }}}
        if (( $facture <> 1)||(empty($lien))){
        $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }    
	    $this->loadModel('Namepiecejointe');
            $this->loadModel('Piecejointe');
            $this->loadModel('Fournisseurdevise');
            $this->loadModel('Namesituation');
            $this->loadModel('Situation');
            $this->loadModel('Lignefacture');
            $this->loadModel('Reglement');
		if (!$this->Importation->exists($id)) {
			throw new NotFoundException(__('Invalid importation'));
		}
		
		$options = array('conditions' => array('Importation.' . $this->Importation->primaryKey => $id));
		$this->request->data = $this->Importation->find('first', $options);
                //debug($this->request->data );
		$fournisseurs = $this->Importation->Fournisseur->find('list');
                $importation=$this->Importation->find('first',array('conditions'=>array('Importation.id' => $id)));
                $devises=$this->Fournisseurdevise->find('all',array('conditions'=>array('Fournisseurdevise.fournisseur_id' =>$importation['Importation']['fournisseur_id'])));
		$devise=$importation['Importation']['devise_id'];
                $situation_id=$importation['Importation']['situation_id'];
                $date=date("d/m/Y",strtotime(str_replace('/','/',$importation['Importation']['date'])));
                $piecejointes=$this->Piecejointe->find('all',array('conditions'=>array('Piecejointe.importation_id' =>$id)));
                $situations=$this->Situation->find('all',array('conditions'=>array('Situation.importation_id' =>$id)));
                $namepiecejointes = $this->Namepiecejointe->find('list');
                $namesituations = $this->Namesituation->find('list');
                $lignefactures = $this->Lignefacture->find('all',array(
                    'conditions'=>array('Facture.importation_id' => $id),'recursive'=>1
                    ));
                //debug($situations);
                $reglements= $this->Reglement->find('all',array('conditions'=>array('Reglement.importation_id'=>$id)));
                $this->set(compact('reglements','lignefactures','situation_id','situations','namesituations','date','fournisseurs', 'devises','devise','piecejointes','namepiecejointes'));
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
        $facture="";
        //debug($lien);die;
        if(!empty($lien)){
        foreach($lien as $k=>$liens){
        if(@$liens['lien']=='importations'){
        $facture=1;
        }}}
        if (( $facture <> 1)||(empty($lien))){
        $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }    
	    $this->loadModel('Namepiecejointe');
            $this->loadModel('Piecejointe');
            $this->loadModel('Fournisseurdevise');
            $this->loadModel('Namesituation');
            $this->loadModel('Situation');
            $this->loadModel('Lignefacture');
            $this->loadModel('Piecereglement');
            $this->loadModel('Traitecredit');
            $this->loadModel('Reglement');
		if (!$this->Importation->exists($id)) {
			throw new NotFoundException(__('Invalid importation'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    //debug($this->request->data['Piecejointe']);die;
                    $this->request->data['Importation']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Importation']['date'])));
			if ($this->Importation->save($this->request->data)) {
                            foreach ($this->request->data['Piecejointe'] as $piecejointe){
                                if (($piecejointe['sup']==1)&&($piecejointe['id']!="")){
                                $this->Piecejointe->deleteAll(array('Piecejointe.id'=>$piecejointe['id']),false); 
                                }
                                  if ($piecejointe['sup']!=1){
                                      //debug($piecejointe);
                                  $piecejointe['importation_id']=$id;
                                  $this->Piecejointe->create();
                                  $this->Piecejointe->save($piecejointe);
                                  }
                                }
				$this->Session->setFlash(__('The importation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The importation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Importation.' . $this->Importation->primaryKey => $id));
			$this->request->data = $this->Importation->find('first', $options);
		}
		$fournisseurs = $this->Importation->Fournisseur->find('list');
                $importation=$this->Importation->find('first',array('conditions'=>array('Importation.id' => $id)));
                $devises=$this->Fournisseurdevise->find('all',array('conditions'=>array('Fournisseurdevise.fournisseur_id' =>$importation['Importation']['fournisseur_id'])));
		$devise=$importation['Importation']['devise_id'];
                $situation_id=$importation['Importation']['situation_id'];
                $date=date("d/m/Y",strtotime(str_replace('/','/',$importation['Importation']['date'])));
                $piecejointes=$this->Piecejointe->find('all',array('conditions'=>array('Piecejointe.importation_id' =>$id)));
                $situations=$this->Situation->find('all',array('conditions'=>array('Situation.importation_id' =>$id)));
                $namepiecejointes = $this->Namepiecejointe->find('list');
                $namesituations = $this->Namesituation->find('list');
                $lignefactures = $this->Lignefacture->find('all',array(
                    'conditions'=>array('Facture.importation_id' => $id),'recursive'=>1
                    ));
                $reglements= $this->Reglement->find('all',array('conditions'=>array('Reglement.importation_id'=>$id)));
//                if($reglement){
//                $pieceregement=$this->Piecereglement->find('all',array('conditions'=>array('Piecereglement.reglement_id'=>$reglement['Reglement']['id'])));
//                if($pieceregement[0]['Piecereglement']['paiement_id']==7){
//                $credit=$this->Traitecredit->find('all',array('conditions'=>array('Traitecredit.piecereglement_id'=>$pieceregement[0]['Piecereglement']['id']),'recursive'=>0));   
//                }
//                    $t='0';
//                    foreach($this->request->data['Lignereglement']as $j=>$l){
//                      $t=$t.','.$l['facture_id'];
//                    }
//                    
//                    $facture=$this->Facture->find('all',array('conditions'=>array('Facture.fournisseur_id'=>$fournisseur_id,('(Facture.id in('.$t.') or Facture.totalttc>(Facture.Montant_Regler))'),'Facture.importation_id'=>$importation_id),'recursive'=>0));
//                    //debug($facture);
//                    
//                }
                $this->set(compact('credit','reglements','pieceregement','lignefactures','situation_id','situations','namesituations','date','fournisseurs', 'devises','devise','piecejointes','namepiecejointes'));
	}
        
        
        
        public function imprimerpiecejointe($id= null) {
        $lien=  CakeSession::read('lien_achat');
        $facture="";
        //debug($lien);die;
        if(!empty($lien)){
        foreach($lien as $k=>$liens){
        if(@$liens['lien']=='importations'){
        $facture=$liens['imprimer'];
        }}}
        if (( $facture <> 1)||(empty($lien))){
        $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }        
            if ($this->request->query['piece']) {
            $piece = $this->request->query['piece'];
        }
             $this->set(compact('piece'));
          }

/**
 * add method
 *
 * @return void
 */
	public function add() {
            $lien=  CakeSession::read('lien_achat');
        $facture="";
        //debug($lien);die;
        if(!empty($lien)){
        foreach($lien as $k=>$liens){
        if(@$liens['lien']=='importations'){
        $facture=$liens['add'];
        }}}
        if (( $facture <> 1)||(empty($lien))){
        $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }    
            $this->loadModel('Namepiecejointe');
            $this->loadModel('Piecejointe');
            $this->loadModel('Namesituation');
            $this->loadModel('Situation');
            $this->loadModel('Situationpersonnel');
		if ($this->request->is('post')) {
                //debug($this->request->data);die;
                $this->request->data['Importation']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Importation']['date'])));
		$Coefficientchoisi=$this->request->data['Importation']['Coefficientchoisi'];
                if($Coefficientchoisi==1){
                $this->request->data['Importation']['coefficien']=$this->request->data['Importation']['coeff'];    
                }
                $this->Importation->create();
			if ($this->Importation->save($this->request->data)) {
                            $id=$this->Importation->id;
                        if(!empty($this->request->data['Piecejointe'])){    
                        foreach ($this->request->data['Piecejointe'] as $piecejointe){
                                //debug($this->request->data);die;
                            if ($piecejointe['namepiecejointe_id']!=''){
                                  if ($piecejointe['sup']!=1){
                                  $piecejointe['importation_id']=$id;
                                  $this->Piecejointe->create();
                                  $this->Piecejointe->save($piecejointe);
                                  }
                            }
                            }
                        }
                        if(!empty($this->request->data['Situation'])){    
                        foreach ($this->request->data['Situation'] as $s=>$situation){
                                //debug($this->request->data);die;
                            if ($situation['namesituation_id']!=''){
                                $situation_index= $this->request->data['contactchoisi'];
                                  if ($situation['supp']!=1){
                                  $situation['datedebut']=date("Y-m-d",strtotime(str_replace('/','-',$situation['datedebut'])));
                                  $situation['datefin']=date("Y-m-d",strtotime(str_replace('/','-',$situation['datefin'])));
                                  $situation['importation_id']=$id;
                                  $this->Situation->create();
                                  $this->Situation->save($situation);
                                  $id_situation=$this->Situation->id;
                                  if($s==$situation_index){
                                  $this->Importation->updateAll(array('Importation.situation_id' =>$id_situation), array('Importation.id' =>$id));
                                  }
                                  }
                            }
                                } 
                        }
				$this->Session->setFlash(__('The importation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The importation could not be saved. Please, try again.'));
			}
		}
                $numero = $this->Importation->find('all', array('fields' =>
            array(
                'MAX(Importation.numero) as num'
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
		$fournisseurs = $this->Importation->Fournisseur->find('list');
		$devises = $this->Importation->Devise->find('list');
                $namepiecejointes = $this->Namepiecejointe->find('list');
                $situationpersonnels=$this->Situationpersonnel->find('all',array('conditions'=>array('Situationpersonnel.personnel_id' =>CakeSession::read('users'))));
                $t='(0,';
                foreach ($situationpersonnels as $s=>$st){
                            $t=$t.$st['Situationpersonnel']['namesituation_id'].',';
                        }
                $t=$t.'0)'; 
                $namesituations = $this->Namesituation->find('list',array('conditions'=>array('Namesituation.id in'.$t)));
		$this->set(compact('namesituations','fournisseurs', 'devises','mm','namepiecejointes'));
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
        $facture="";
        //debug($lien);die;
        if(!empty($lien)){
        foreach($lien as $k=>$liens){
        if(@$liens['lien']=='importations'){
        $facture=$liens['edit'];
        }}}
        if (( $facture <> 1)||(empty($lien))){
        $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }    
            $this->loadModel('Namepiecejointe');
            $this->loadModel('Piecejointe');
            $this->loadModel('Fournisseurdevise');
            $this->loadModel('Namesituation');
            $this->loadModel('Situation');
            $this->loadModel('Situationpersonnel');
		if (!$this->Importation->exists($id)) {
			throw new NotFoundException(__('Invalid importation'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                   // debug($this->request->data);die;
                    $this->request->data['Importation']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Importation']['date'])));
		    $Coefficientchoisi=$this->request->data['Importation']['Coefficientchoisi'];
                    if($Coefficientchoisi==1){
                    $this->request->data['Importation']['coefficien']=$this->request->data['Importation']['coeff'];    
                    }
                    if ($this->Importation->save($this->request->data)) {
                        if(!empty($this->request->data['Piecejointe'])){
                            foreach ($this->request->data['Piecejointe'] as $piecejointe){
                                if (($piecejointe['sup']==1)&&($piecejointe['id']!="")){
                                $this->Piecejointe->deleteAll(array('Piecejointe.id'=>$piecejointe['id']),false); 
                                }
                                if ($piecejointe['namepiecejointe_id']!=''){
                                  if ($piecejointe['sup']!=1){
                                      //debug($piecejointe);
                                  $piecejointe['importation_id']=$id;
                                  $this->Piecejointe->create();
                                  $this->Piecejointe->save($piecejointe);
                                  }
                                }
                                }
                        }
                                if(!empty($this->request->data['Situation'])){
                                $this->Situation->deleteAll(array('Situation.importation_id'=>$id),false);
                                foreach ($this->request->data['Situation'] as $s=>$situation){
                                  if ($situation['namesituation_id']!=''){
                                  $situation_index= $this->request->data['contactchoisi'];
                                  if ($situation['supp']!=1){
                                  $situation['datedebut']=date("Y-m-d",strtotime(str_replace('/','-',$situation['datedebut'])));
                                  $situation['datefin']=date("Y-m-d",strtotime(str_replace('/','-',$situation['datefin'])));
                                  $situation['importation_id']=$id;
                                  $this->Situation->create();
                                  $this->Situation->save($situation);
                                  $id_situation=$this->Situation->id;
                                  if($s==$situation_index){
                                  $this->Importation->updateAll(array('Importation.situation_id' =>$id_situation), array('Importation.id' =>$id));
                                  }
                                  }
                                  }
                                }
                                }
				$this->Session->setFlash(__('The importation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The importation could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Importation.' . $this->Importation->primaryKey => $id));
			$this->request->data = $this->Importation->find('first', $options);
		}
		$fournisseurs = $this->Importation->Fournisseur->find('list');
                $importation=$this->Importation->find('first',array('conditions'=>array('Importation.id' => $id)));
                $devises=$this->Fournisseurdevise->find('all',array('conditions'=>array('Fournisseurdevise.fournisseur_id' =>$importation['Importation']['fournisseur_id'])));
		$devise=$importation['Importation']['devise_id'];
                $situation_id=$importation['Importation']['situation_id'];
                $date=date("d/m/Y",strtotime(str_replace('/','/',$importation['Importation']['date'])));
                $piecejointes=$this->Piecejointe->find('all',array('conditions'=>array('Piecejointe.importation_id' =>$id)));
                $situations=$this->Situation->find('all',array('conditions'=>array('Situation.importation_id' =>$id)));
                $namepiecejointes = $this->Namepiecejointe->find('list');
                $situationpersonnels=$this->Situationpersonnel->find('all',array('conditions'=>array('Situationpersonnel.personnel_id' =>CakeSession::read('users'))));
                $t='(0,';
                foreach ($situationpersonnels as $s=>$st){
                            $t=$t.$st['Situationpersonnel']['namesituation_id'].',';
                        }
                $t=$t.'0)'; 
                $namesituations = $this->Namesituation->find('list',array('conditions'=>array('Namesituation.id in'.$t)));
                $this->set(compact('situation_id','situations','namesituations','date','fournisseurs', 'devises','devise','piecejointes','namepiecejointes'));
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
        $facture="";
        //debug($lien);die;
        if(!empty($lien)){
        foreach($lien as $k=>$liens){
        if(@$liens['lien']=='importations'){
        $facture=$liens['delete'];
        }}}
        if (( $facture <> 1)||(empty($lien))){
        $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }    
		$this->Importation->id = $id;
		if (!$this->Importation->exists()) {
			throw new NotFoundException(__('Invalid importation'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Importation->delete()) {
			$this->Session->setFlash(__('Importation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Importation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
     public function cloture($id = null) {
		$this->Importation->id = $id;
		if (!$this->Importation->exists()) {
			throw new NotFoundException(__('Invalid importation'));
		}
                $c=1;
                $this->Importation->updateAll(array('Importation.etat'=>$c),false);
		$this->redirect(array('action' => 'index'));
	}
        
     public function getdevises() {
	
		$this->layout = null;
		// $json = null;
            $this->loadModel('Fournisseurdevise');
            $this->loadModel('Devise');
            $data = $this->request->data;
            $fournisseurid= $data['fournisseurid'];
 
            $devises=$this->Fournisseurdevise->find('all',array('conditions'=>array('Fournisseurdevise.fournisseur_id' => $fournisseurid)));
            $select="<select name='data[Importation][devise_id]' champ='devise_id' id='devise_id' class='form-control select ' onchange='' >";
            $select=$select."<option value=''>"."choix"."</option>";
            foreach($devises as $v){
                $select=$select."<option value=".$v['Devise']['id'].">".$v['Devise']['name']."</option>";
              }
            $select=$select.'</select>';
   
            $importations=$this->Importation->find('all',array('conditions'=>array('Importation.fournisseur_id' => $fournisseurid),'order'=>array('Importation.id'=>'desc')));
            foreach ($importations as $i=>$importation) { 
            if($i==0){
            $ancien_coeff=$importation['Importation']['coefficien'];
            }
            }    
			
	 echo json_encode(array('select'=>$select,'ancien_coeff'=>$ancien_coeff));
			 
            //echo $select;
            die();
	}        
        
     public function  getcoes(){
            $this->layout = null;
            $data = $this->request->data;//debug($data);
            $json = null;
            $importationid=$data['importationid'];
            $importation= $this->Importation->find('first',array('conditions'=>array('Importation.id'=>$importationid),false));
            $tr=$importation['Importation']['tauxderechenge'];
            $coe=$importation['Importation']['coefficien'];
            $prixachat=$importation['Importation']['montantachat'];
            $prixachat_tounssi=$importation['Importation']['prixachat'];
           echo json_encode(array('tr'=>$tr,'coe'=>$coe,'prixachat'=>$prixachat,'prixachat_tounssi'=>$prixachat_tounssi));
          die();
     }
     
     
     public function recap() {
             $this->loadModel('Fournisseur');
             $this->layout = null;
             $data=$this->request->data;
             $fournisseurid= $data['fournisseur_id'];
    $fournisseur=$this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id' => $fournisseurid)));
    $name=$fournisseur['Fournisseur']['name'];
    $importations=$this->Importation->find('all',array('conditions'=>array('Importation.fournisseur_id' => $fournisseurid),'order'=>array('Importation.id'=>'desc')));
     
    $this->set(compact('importations','name','ancien_coeff'));
               
	} 
     
     
     
     
}
