<?php
App::uses('AppController', 'Controller');
/**
 * Engagementcomptes Controller
 *
 * @property Engagementcompte $Engagementcompte
 */
class EngagementcomptesController extends AppController {

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
       $this->loadModel('Piecereglementclient');
       $this->loadModel('Bordereau');
       $this->loadModel('Versement');
       $this->loadModel('Situationpiecereglement');
       $this->loadModel('Situationpiecereglementclient');
       $this->loadModel('Traitecredit');
       $this->loadModel('Paiement');
       $this->loadModel('Reglement');
       $this->loadModel('Reglementclient');
       $etatpiecereglements = $this->Etatpiecereglement->find('list');
       $this->Engagementcompte->query('TRUNCATE engagementcomptes;');
       
        if (isset($this->request->data) && !empty($this->request->data)) {
        if($this->request->data['Piecereglement']['Date_debut'] != '__/__/____'){
            $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_debut'])));
            $cond1f='Situationpiecereglement.date>='."'".$Date_debut."'";
            $cond1c='Situationpiecereglementclient.date>='."'".$Date_debut."'";
            $cond1v='Versement.date>='."'".$Date_debut."'";
            $cond1r='Bordereau.date>='."'".$Date_debut."'";
            $cond1='Engagementcompte.date >='."'".$Date_debut."'";
        }
        if($this->request->data['Piecereglement']['Date_fin'] != '__/__/____'){
            $Date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_fin'])));
            $cond2f='Situationpiecereglement.date<='."'".$Date_fin."'";
            $cond2c='Situationpiecereglementclient.date<='."'".$Date_fin."'";
            $cond2v='Versement.date<='."'".$Date_fin."'";
            $cond2r='Bordereau.date<='."'".$Date_fin."'";
            $cond2='Engagementcompte.date <='."'".$Date_fin."'";
        }   
        if($this->request->data['Piecereglement']['compte_id']){
            $compte_id=$this->request->data['Piecereglement']['compte_id'];
            $cond3f="Piecereglement.compte_id='".$compte_id."'";
            $cond3c="Piecereglementclient.compte_id='".$compte_id."'";
            $cond3v="Versement.compte_id='".$compte_id."'";
            $cond3r="Bordereau.compte_id='".$compte_id."'";
            $cond3="Engagementcompte.compte_id='".$compte_id."'";
        }
        $conddatef='Situationpiecereglement.datemodification >='."'"."2017-01-01"."'";
        $conddatec='Situationpiecereglementclient.datemodification >='."'"."2017-01-01"."'";
        $conddatev='Versement.date >='."'"."2017-01-01"."'";
        $conddater='Bordereau.date >='."'"."2017-01-01"."'";
        //******************************************************************************************************************************        
            $listepiecefrs=$this->Situationpiecereglement->find('all', array(
            'conditions' => array(@$conddatef,@$cond3f,'Situationpiecereglement.etatpiecereglement_id in (6,3,4)'),    
            'recursive'=>0 ));
            //debug($listepiecefrs);
            $tabpiecefrs=array(); 
            foreach ($listepiecefrs as $liste) {
            $reglements=$this->Reglement->find('first', array('conditions' => array('Reglement.id'=>$liste['Piecereglement']['reglement_id']),'recursive'=>0 ));    
            //debug($reglements);die;
            $tabpiecefrs['observation']=$reglements['Fournisseur']['code']." ".$reglements['Fournisseur']['name']; 
            if(($liste['Piecereglement']['etatpiecereglement_id'] ==9)){
            $credits=$this->Traitecredit->find('all', array('conditions' => array('Traitecredit.piecereglement_id'=>$liste['Piecereglement']['id']),'recursive'=>0 ));    
            foreach ($credits as $credit) {
            $tabpiecefrs['piece_id']=$liste['Piecereglement']['id'];    
            $tabpiecefrs['compte_id']=$liste['Piecereglement']['compte_id'];
            $tabpiecefrs['paiement_id']=$liste['Piecereglement']['paiement_id'];
            $tabpiecefrs['date']=$credit['Traitecredit']['echancecredit'];
            $tabpiecefrs['num']=$credit['Traitecredit']['num_piececredit'];
            $tabpiecefrs['type']="tranche crédit";
            $tabpiecefrs['montant']=$credit['Traitecredit']['montantcredit'];
            $tabpiecefrs['montant_calculable']=0-$credit['Traitecredit']['montantcredit'];
            $tabpiecefrs['echance']="";
            $tabpiecefrs['model']="Piecereglement";
            $tabpiecefrs['situation']="Payé";
            $this->Engagementcompte->create();
            $this->Engagementcompte->save($tabpiecefrs);
            }
            }else{     
            if($liste['Situationpiecereglement']['agio'] !=0){
            $tabpiecefrs['piece_id']=$liste['Piecereglement']['id'];    
            $tabpiecefrs['compte_id']=$liste['Piecereglement']['compte_id'];
            $tabpiecefrs['paiement_id']=$liste['Piecereglement']['paiement_id'];
            $tabpiecefrs['date']=$liste['Situationpiecereglement']['datemodification'];
            $tabpiecefrs['num']=$liste['Piecereglement']['num'];
            $tabpiecefrs['type']="Agio";
            $tabpiecefrs['montant']=$liste['Situationpiecereglement']['agio'];
            $tabpiecefrs['montant_calculable']=0-$liste['Situationpiecereglement']['agio'];
            $tabpiecefrs['echance']=$liste['Piecereglement']['echance'];
            $tabpiecefrs['model']="Piecereglement";
            $tabpiecefrs['situation']="Agio";
            $this->Engagementcompte->create();
            $this->Engagementcompte->save($tabpiecefrs);    
            }   
            $tabpiecefrs['piece_id']=$liste['Piecereglement']['id'];    
            $tabpiecefrs['compte_id']=$liste['Piecereglement']['compte_id'];
            $tabpiecefrs['paiement_id']=$liste['Piecereglement']['paiement_id'];
            $tabpiecefrs['date']=$liste['Situationpiecereglement']['datemodification'];
            $tabpiecefrs['num']=$liste['Piecereglement']['num'];
            $paiement=$this->Paiement->find('first', array('conditions' => array('Paiement.id'=>$liste['Piecereglement']['paiement_id']),'recursive'=>0 ));
            //debug($paiement);
            if(!empty($paiement)){
            $tabpiecefrs['type']=$paiement['Paiement']['name'];
            }
            $tabpiecefrs['montant']=$liste['Piecereglement']['montant'];
            $tabpiecefrs['montant_calculable']=0-$liste['Piecereglement']['montant'];
            $tabpiecefrs['echance']=$liste['Piecereglement']['echance'];
            $tabpiecefrs['model']="Piecereglement";
            $tabpiecefrs['situation']=$etatpiecereglements[$liste['Situationpiecereglement']['etatpiecereglement_id']];
            $this->Engagementcompte->create();
            $this->Engagementcompte->save($tabpiecefrs);
            }}
            //******************************************************************************************************************************        
            $listepiececls=$this->Situationpiecereglementclient->find('all', array(
            'conditions' => array(@$conddatec,@$cond3c,'Situationpiecereglementclient.situation in ("On caissé","Escompte","Impayé")'),    
            'recursive'=>0 ));
            //debug($listepiececls);die;
            $tabpiecefrs=array(); 
            foreach ($listepiececls as $liste) {
            $reglementclients=$this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id'=>$liste['Piecereglementclient']['reglementclient_id']),'recursive'=>0 ));    
            //debug($reglementclients);die;
            $tabpiecefrs['observation']=$reglementclients['Client']['code']." ".$reglementclients['Client']['name']; 
                
            if($liste['Situationpiecereglementclient']['agio'] !=0){
            $tabpiecefrs['piece_id']=$liste['Piecereglementclient']['id'];    
            $tabpiecefrs['compte_id']=$liste['Piecereglementclient']['compte_id'];
            $tabpiecefrs['paiement_id']=$liste['Piecereglementclient']['paiement_id'];
            $tabpiecefrs['date']=$liste['Situationpiecereglementclient']['datemodification'];
            $tabpiecefrs['num']=$liste['Piecereglementclient']['num'];
            $tabpiecefrs['type']="Agio";
            $tabpiecefrs['montant']=$liste['Situationpiecereglementclient']['agio'];
            $tabpiecefrs['montant_calculable']=0-$liste['Situationpiecereglementclient']['agio'];
            $tabpiecefrs['echance']=$liste['Piecereglementclient']['echance'];
            $tabpiecefrs['model']="Piecereglementclient";
            $tabpiecefrs['situation']="Agio";
            $this->Engagementcompte->create();
            $this->Engagementcompte->save($tabpiecefrs);    
            }    
            $tabpiecefrs['piece_id']=$liste['Piecereglementclient']['id'];    
            $tabpiecefrs['compte_id']=$liste['Piecereglementclient']['compte_id'];
            $tabpiecefrs['paiement_id']=$liste['Piecereglementclient']['paiement_id'];
            $tabpiecefrs['date']=$liste['Situationpiecereglementclient']['datemodification'];
            $tabpiecefrs['num']=$liste['Piecereglementclient']['num'];
            $paiement=$this->Paiement->find('first', array('conditions' => array('Paiement.id'=>$liste['Piecereglementclient']['paiement_id']),'recursive'=>0 ));
            if(!empty($paiement)){
            $tabpiecefrs['type']=$paiement['Paiement']['name'];
            }
            $tabpiecefrs['montant']=$liste['Piecereglementclient']['montant'];
            $tabpiecefrs['montant_calculable']=$liste['Piecereglementclient']['montant'];
            $tabpiecefrs['echance']=$liste['Piecereglementclient']['echance'];
            $tabpiecefrs['model']="Piecereglementclient";
            if(($liste['Piecereglementclient']['paiement_id']==3)&&($liste['Situationpiecereglementclient']['situation']=="Escompte")||($liste['Situationpiecereglementclient']['situation']=="On caissé")){
            $tabpiecefrs['situation']="Payé";
            }else{
            if(($liste['Piecereglementclient']['paiement_id']==3)&&($liste['Situationpiecereglementclient']['situation']=="Impayé")){
            if($liste['Piecereglementclient']['emi']==1){
            $tabpiecefrs['situation']="Impayéc";     
            }else{
            $listepiecetestescompte=$this->Situationpiecereglementclient->find('all', array(
            'conditions' => array('Situationpiecereglementclient.piecereglementclient_id'=>$liste['Situationpiecereglementclient']['piecereglementclient_id'],'Situationpiecereglementclient.situation ="Escompte"'),    
            'recursive'=>-1));
            if(!empty($listepiecetestescompte)){
            $tabpiecefrs['situation']="Impayéc";    
            }else{
            $tabpiecefrs['situation']=$liste['Situationpiecereglementclient']['situation'];
            }
            }
            }else{
            // debug($liste['Situationpiecereglementclient']['situation']);die;
            $tabpiecefrs['situation']=$liste['Situationpiecereglementclient']['situation'];
            }}
            $this->Engagementcompte->create();
            $this->Engagementcompte->save($tabpiecefrs);
            }
            //******************************************************************************************************************************        
            $listeversements=$this->Versement->find('all', array('conditions' => array(
             @$cond3v,@$conddatev),
             'recursive'=>0 ));
            //debug($listeversements);die;
            $tabpiecefrs=array(); 
            foreach ($listeversements as $liste) {
            $tabpiecefrs['observation']=""; 
            $tabpiecefrs['piece_id']=$liste['Versement']['id'];    
            $tabpiecefrs['compte_id']=$liste['Versement']['compte_id'];
            $tabpiecefrs['paiement_id']=0;
            $tabpiecefrs['date']=$liste['Versement']['date'];
            $tabpiecefrs['num']=$liste['Versement']['numero'];
            $tabpiecefrs['type']="Versement";
            $tabpiecefrs['montant']=$liste['Versement']['montant'];
            $tabpiecefrs['montant_calculable']=$liste['Versement']['montant'];
            $tabpiecefrs['echance']="";
            $tabpiecefrs['model']="Versement";
            $tabpiecefrs['situation']="Payé";
            $this->Engagementcompte->create();
            $this->Engagementcompte->save($tabpiecefrs);
            }
            //******************************************************************************************************************************        
            $listeretrais=$this->Bordereau->find('all', array(
            'conditions' => array('Bordereau.type'=>2,@$cond3r,@$conddater),'recursive'=>0 ));
            //debug($listeretrais);die;
            $tabpiecefrs=array(); 
            foreach ($listeretrais as $liste) {
            $tabpiecefrs['observation']=$liste['Bordereau']['observation'];    
            $tabpiecefrs['piece_id']=$liste['Bordereau']['id'];    
            $tabpiecefrs['compte_id']=$liste['Bordereau']['compte_id'];
            $tabpiecefrs['paiement_id']=0;
            $tabpiecefrs['date']=$liste['Bordereau']['date'];
            $tabpiecefrs['num']=$liste['Bordereau']['numero'];
            $tabpiecefrs['type']="Retrait";
            $tabpiecefrs['montant']=$liste['Bordereau']['montantverse'];
            $tabpiecefrs['montant_calculable']=0-$liste['Bordereau']['montantverse'];
            $tabpiecefrs['echance']="";
            $tabpiecefrs['model']="Bordereau";
            $tabpiecefrs['situation']="Payé";
            $this->Engagementcompte->create();
            $this->Engagementcompte->save($tabpiecefrs);
            }
        $conddate='Engagementcompte.date >='."'"."2017-01-01"."'";    
        $engagementcomptes=$this->Engagementcompte->find('all', array(
        'conditions' => array(@$cond1,@$cond2,@$cond3,@$conddate,'Engagementcompte.situation in("Payé","Impayéc")')    
        ,'recursive'=>-1,'order'=>array('Engagementcompte.date'=>'asc') ));
        //debug($engagementcomptes);
        $compte=$this->Compte->find('first', array('conditions' => array('Compte.id'=>$compte_id),'recursive'=>0 ));
        if($this->request->data['Piecereglement']['Date_debut'] != '__/__/____'){
        $Date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Piecereglement']['Date_debut'])));
        $condd='Engagementcompte.date >='."'".$compte['Compte']['date']."'";
        $condf='Engagementcompte.date <'."'".$Date_debut."'";
        $solde=$this->Engagementcompte->find('all', array(
        'fields'=>array('sum(Engagementcompte.montant_calculable) as solde')    
        ,'conditions' => array(@$condd,@$condf,@$cond3)    
        ,'recursive'=>-1));
        $soldeint=$solde[0][0]['solde']+$compte['Compte']['solde'];
        }else{
        $soldeint=$compte['Compte']['solde'];
        }
        //debug($soldeint);die;
       
         
    }
           $comptes = $this->Compte->find('all');

  $this->set(compact('compte','soldeint','engagementcomptes','paiement_id','piecereglements','paiements','fournisseurs','comptes','Date_debut','Date_fin','Date_deb','Date_fn','client_id','num_recu','situation','compte_id',$this->paginate()));
  }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Engagementcompte->exists($id)) {
			throw new NotFoundException(__('Invalid engagementcompte'));
		}
		$options = array('conditions' => array('Engagementcompte.' . $this->Engagementcompte->primaryKey => $id));
		$this->set('engagementcompte', $this->Engagementcompte->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Engagementcompte->create();
			if ($this->Engagementcompte->save($this->request->data)) {
				$this->Session->setFlash(__('The engagementcompte has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The engagementcompte could not be saved. Please, try again.'));
			}
		}
		$paiements = $this->Engagementcompte->Paiement->find('list');
		$comptes = $this->Engagementcompte->Compte->find('list');
		$this->set(compact('paiements', 'comptes'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Engagementcompte->exists($id)) {
			throw new NotFoundException(__('Invalid engagementcompte'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Engagementcompte->save($this->request->data)) {
				$this->Session->setFlash(__('The engagementcompte has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The engagementcompte could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Engagementcompte.' . $this->Engagementcompte->primaryKey => $id));
			$this->request->data = $this->Engagementcompte->find('first', $options);
		}
		$paiements = $this->Engagementcompte->Paiement->find('list');
		$comptes = $this->Engagementcompte->Compte->find('list');
		$this->set(compact('paiements', 'comptes'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Engagementcompte->id = $id;
		if (!$this->Engagementcompte->exists()) {
			throw new NotFoundException(__('Invalid engagementcompte'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Engagementcompte->delete()) {
			$this->Session->setFlash(__('Engagementcompte deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Engagementcompte was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
