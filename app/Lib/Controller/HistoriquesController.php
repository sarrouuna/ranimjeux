<?php
App::uses('AppController', 'Controller');
/**
 * Bonreceptions Controller
 *
 * @property Bonreception $Bonreception
 */
class HistoriquesController extends AppController {


	public function historique() {
            
       $this->loadModel('Fournisseur');       
       $this->loadModel('Utilisateur');  
       $this->loadModel('Bonreception'); 
         if (isset($this->request->data) && !empty($this->request->data)) {
      //debug($this->request->data);die;
        if ($this->request->data['Bonreception']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date1'])));
            $cond1 = 'Bonreception.date >= '."'".$date1."'";
        }
        
        if ($this->request->data['Bonreception']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date2'])));
            $cond2 = 'Bonreception.date <= '."'".$date2."'";
        }
        
       if ($this->request->data['Bonreception']['fournisseur_id']) {
            $fournisseurid = $this->request->data['Bonreception']['fournisseur_id'];
            $cond3 = 'Bonreception.fournisseur_id ='.$fournisseurid;
        } 
         if ($this->request->data['Bonreception']['utilisateur_id']) {
            $utilisateurid = $this->request->data['Bonreception']['utilisateur_id'];
            $cond4 = 'Bonreception.utilisateur_id ='.$utilisateurid;
        } 
        if ($this->request->data['Bonreception']['transf_id']=="0"){
            $transf=$this->request->data['Bonreception']['transf_id'];
            $cond5 = 'Bonreception.facture_id ='.$transf;
            }elseif($this->request->data['Bonreception']['transf_id']=="1"){
            $transf=$this->request->data['Bonreception']['transf_id'];
            $cond5 = 'Bonreception.facture_id >= '.$transf;
            }
      
        if ($this->request->data['Bonreception']['be_id']) {
            $be = $this->request->data['Bonreception']['be_id'];
            $cond6 = 'Bonreception.etat ='.$be;
        } 
    } 
    $bonreceptions = $this->Bonreception->find('all', array( 'conditions' => array('Bonreception.id > ' => 0, @$cond1, @$cond2, @$cond3,@$cond4,@$cond5,@$cond6 )));
    // debug($cond5);die;
                $transfs[0]="Non transformé";
		$transfs[1]="Transformé";
                $bes[0]="Non Ajouté";
		$bes[1]="Ajouté";
                $fournisseurs = $this->Fournisseur->find('list');//debug($fournisseurs);die;
                $utilisateurs = $this->Utilisateur->find('list');
                 $this->set(compact('date1','date2','fournisseurid','utilisateurid','transf','be','transfs','bes','fournisseurs','utilisateurs','bonreceptions',$this->paginate()));
	}
        
	public function view($id = null) {
            $this->loadModel('Lignereception');
            $this->loadModel('Article');
		if (!$this->Bonreception->exists($id)) {
			throw new NotFoundException(__('Invalid bonreception'));
		}
		$options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
		$this->set('bonreception', $this->Bonreception->find('first', $options));
                    $lignereceptions = $this->Lignereception->find('all',array(
                    'conditions'=>array('Lignereception.bonreception_id' => $id)
                    ));
                $articles=$this->Article->find('list');
                $this->set(compact('lignereceptions','articles'));
	}
        
        public function imprimer($id = null) {
           $lien=  CakeSession::read('lien_achat');
               $bonreception="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonreceptions'){
                        $bonreception=$liens['imprimer'];
                }}}
              if (( $bonreception <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Lignereception');
            $this->loadModel('Article');
		if (!$this->Bonreception->exists($id)) {
			throw new NotFoundException(__('Invalid bonreception'));
		}
		$options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
		$this->set('bonreception', $this->Bonreception->find('first', $options));
                $articles=$this->Article->find('list'); 
                $lignereceptions = $this->Lignereception->find('all',array(
                    'conditions'=>array('Lignereception.bonreception_id' => $id)
                    ));
                 $this->set(compact('lignereceptions','articles'));
	}

        
        public function imprimerrecherche() { 
         $lien=  CakeSession::read('lien_achat');
               $bonreception="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonreceptions'){
                        $bonreception=$liens['imprimer'];
                }}}
              if (( $bonreception <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
       $this->loadModel('Fournisseur');       
       $this->loadModel('Utilisateur');  
     // debug($this->request->query);die;
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Bonreception.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Bonreception.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Bonreception.fournisseur_id ='.$fournisseurid;
        } 
         if ($this->request->query['utilisateurid']) {
            $utilisateurid = $this->request->query['utilisateurid'];
            $cond4 = 'Bonreception.utilisateur_id ='.$utilisateurid;
        } 
         if ($this->request->query['transf']=="0"){
            $transf=$this->request->query['transf'];
            $cond5 = 'Bonreception.facture_id ='.$transf;
            }elseif($this->request->query['transf']=="1"){
            $transf=$this->request->query['transf'];
            $cond5 = 'Bonreception.facture_id > '.$transf;
            }
      
        if ($this->request->query['be']!='') {
            $be = $this->request->query['be'];
            $cond6 = 'Bonreception.etat ='.$be;
        } 
  $bonreceptions = $this->Bonreception->find('all', array( 'conditions' => array('Bonreception.id > ' => 0, @$cond1, @$cond2, @$cond3,@$cond4,@$cond5,@$cond6 )));
  
                 $this->set(compact('bonreceptions','date1','date2','fournisseurid','utilisateurid'));     
   
         }

       
}
