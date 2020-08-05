<?php

App::uses('AppController', 'Controller');

/**
 * Tracemisejours Controller
 *
 * @property Tracemisejour $Tracemisejour
 */
class TracemisejoursController extends AppController {

    public function index() {
        $this->Tracemisejour->recursive = 0;
        $this->set('tracemisejours', $this->paginate());
    }

    public function indexx() {
$lien=  CakeSession::read('lien_parametrage');
               $utilisateurh="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='tracemisejours'){
                        $utilisateurh=1;
                }}}
              if (( $utilisateurh <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
        $date_lyoumad = date('d/m/Y');
        $date_lyoumaf = date('d/m/Y');
        $date_lyoum = date('Y-m-d');
        $cond2 = 'Tracemisejour.date >=' . "'" . $date_lyoum . "'";
        $cond3 = 'Tracemisejour.date <=' . "'" . $date_lyoum . "'";
        if ($this->request->is('post') || $this->request->is('put')) {
            if (!empty($this->request->data['Tracemisejour']['User'])) {
                $utilisateur = $this->request->data['Tracemisejour']['User'];
                $cond1 = 'Tracemisejour.utilisateur_id=' . $utilisateur;
            }
            if ($this->request->data['Tracemisejour']['date_debut'] != '__/__/____') {
                $date_lyoumad=$this->request->data['Tracemisejour']['date_debut'];
                $date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Tracemisejour']['date_debut'])));
                $cond2 = 'Tracemisejour.date >=' . "'" . $date_debut . "'";
            }

            if ($this->request->data['Tracemisejour']['date_fin'] != '__/__/____') {
                $date_lyoumaf=$this->request->data['Tracemisejour']['date_fin'];
                $date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Tracemisejour']['date_fin'])));
                $cond3 = 'Tracemisejour.date <=' . "'" . $date_fin . "'";
            }
            if (!empty($this->request->data['Tracemisejour']['Tableaction'])) {
                $operation = $this->request->data['Tracemisejour']['Tableaction'];
                $cond4 = 'Tracemisejour.operation=' . '"'.$operation.'"';
            }
            if (!empty($this->request->data['Tracemisejour']['Tablemodel'])) {
                $model = $this->request->data['Tracemisejour']['Tablemodel'];
                $cond5 = 'Tracemisejour.model=' .'"'. $model.'"';
            }
        }

        $tracemisejours = $this->Tracemisejour->find('all', array('conditions' => array(@$cond1, @$cond2, @$cond3, @$cond4, @$cond5), 'contain' => array('Utilisateur.Personnel'), 'recursive' => 2));
        //debug($tracemisejours);
        $utilisateurs = $this->Tracemisejour->find('all', array('contain' => array('Utilisateur.Personnel'), 'group' => array('Tracemisejour.utilisateur_id', 'recursive' => 2)));
        $users = array();
        foreach ($utilisateurs as $indice => $u) {
            $users[$u['Tracemisejour']['utilisateur_id']] = $u['Utilisateur']['Personnel']['name'];
        }
        
        $models = $this->Tracemisejour->find('all', array( 'group' => array('Tracemisejour.model', 'recursive' => -1)));
        $tablemodels = array();
        foreach ($models as $indicet => $t) {
            if($t['Tracemisejour']['model']=='Factureclient'){
                $mod='Facture client';
            }
            else if($t['Tracemisejour']['model']=='Commandeclient'){
                $mod='Commande client';
            }else if($t['Tracemisejour']['model']=='Reglementclient'){
                $mod='Reglement client';
            }else if($t['Tracemisejour']['model']=='Bonlivraison'){
                $mod='Bon livraison';
            }
            else if($t['Tracemisejour']['model']=='Factureavoir'){
                $mod='Facture avoir client';
            }else if($t['Tracemisejour']['model']=='Factureavoirfr'){
                $mod='Facture avoir fournisseur';
            }
            else{
               $mod=$t['Tracemisejour']['model'];
            }
            $tablemodels[$t['Tracemisejour']['model']] = $mod;
        }
        
        $actions = $this->Tracemisejour->find('all', array( 'group' => array('Tracemisejour.operation', 'recursive' => -1)));
        $tableactions = array();
        foreach ($actions as $indiceta => $ta) {
            if($ta['Tracemisejour']['operation']=='add'){
                $opr='Ajout';
            }else if($ta['Tracemisejour']['operation']=='edit'){
                $opr='Modification';
            }else {
                $opr='Suppression';
            }
            $tableactions[$ta['Tracemisejour']['operation']] = $opr;
        }
        
        $this->set(compact('operation','model','utilisateur','date_debut','date_fin','date_lyoumaf','date_lyoumad','tracemisejours','tableactions', 'tablemodels', 'users'));
    }
    
     public function imprimerrecherche() { 
         $lien=  CakeSession::read('lien_parametrage');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='tracemisejours'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
         
         $date_lyoum = date('Y-m-d');
        $cond2 = 'Tracemisejour.date >=' . "'" . $date_lyoum . "'";
        $cond3 = 'Tracemisejour.date <=' . "'" . $date_lyoum . "'";
        if (!empty($this->request->query['date_debut'])){
            $date1 = $this->request->query['date_debut'];
            $cond2 = 'Tracemisejour.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date_fin'])){
            $date2 = $this->request->query['date_fin'];
            $cond3 = 'Tracemisejour.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['utilisateur']) {
           $cond1 = 'Tracemisejour.utilisateur_id=' . $this->request->query['utilisateur'];
        } 
        if ($this->request->query['model']) {
           $cond4 = 'Tracemisejour.model=' . '"'. $this->request->query['model']. '"';
        } 
        if ($this->request->query['operation']) {
           $cond5 = 'Tracemisejour.operation=' . '"'.$this->request->query['operation']. '"';
        } 
         
        $bonlivraisons = $this->Tracemisejour->find('all', array('conditions' => array(@$cond1, @$cond2, @$cond3, @$cond4, @$cond5), 'contain' => array('Utilisateur.Personnel'), 'recursive' => 2));

                 $this->set(compact('bonlivraisons','date1','date2'));     
   
         }

    public function view($id = null) {
        if (!$this->Tracemisejour->exists($id)) {
            throw new NotFoundException(__('Invalid tracemisejour'));
        }
        $options = array('conditions' => array('Tracemisejour.' . $this->Tracemisejour->primaryKey => $id));
        $this->set('tracemisejour', $this->Tracemisejour->find('first', $options));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Tracemisejour->create();
            if ($this->Tracemisejour->save($this->request->data)) {
                $this->Session->setFlash(__('The tracemisejour has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The tracemisejour could not be saved. Please, try again.'));
            }
        }
        $utilisateurs = $this->Tracemisejour->Utilisateur->find('list');
        $this->set(compact('utilisateurs'));
    }

    public function edit($id = null) {
        if (!$this->Tracemisejour->exists($id)) {
            throw new NotFoundException(__('Invalid tracemisejour'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Tracemisejour->save($this->request->data)) {
                $this->Session->setFlash(__('The tracemisejour has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The tracemisejour could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Tracemisejour.' . $this->Tracemisejour->primaryKey => $id));
            $this->request->data = $this->Tracemisejour->find('first', $options);
        }
        $utilisateurs = $this->Tracemisejour->Utilisateur->find('list');
        $this->set(compact('utilisateurs'));
    }

    public function delete($id = null) {
        $this->Tracemisejour->id = $id;
        if (!$this->Tracemisejour->exists()) {
            throw new NotFoundException(__('Invalid tracemisejour'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Tracemisejour->delete()) {
            $this->Session->setFlash(__('Tracemisejour deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Tracemisejour was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
