<?php

App::uses('AppController', 'Controller');

/**
 * 'Reglement.type' = 0 si c ets un regelment sur facture si  egale a a 1 cest un reglement libre
 * Reglements Controller
 *
 * @property Reglement $Reglement
 */
class ReglementcaissesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
          $status_garderie=  CakeSession::read('client');
        $par=CakeSession::read('parrametre');
        
           if ( $status_garderie <> "CL"){
    
     $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
               
           }
           $pv=  CakeSession::read('point');
 if ($this->request->is('post')) {
			//debug($this->request->data);die;
            if (isset($this->request->data['Reglement']['tout']) && !empty($this->request->data['Reglement']['tout'])) {
                 $debut="";$fin="";
                 $this->Reglement->recursive = 0;
                 if($par <> "P"){
        $this->set('reglements', $this->Reglement->find('all', array('conditions' => array('Reglement.pointvente_id' => $pv,'Reglement.type' => 0),
                    'order' => array('Reglement.id' => 'desc'))));
                 }else{
                    $this->set('reglements', $this->Reglement->find('all', array('conditions'=>array('Reglement.type' => 0),
                    'order' => array('Reglement.id' => 'desc')))); 
                 }
        $bb='closed';
        $this->set(compact('bb','debut','fin'));
            } if (isset($this->request->data['Reglement']['afficher']) && !empty($this->request->data['Reglement']['afficher'])) {
                
                $debut=$this->request->data['Reglement']['Entre'];
            $fin=$this->request->data['Reglement']['Et'];
            $date1 = explode('/', $this->request->data['Reglement']['Entre']);
            $new_dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $date2 = explode('/', $this->request->data['Reglement']['Et']);
            $new_datef = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $bb='opened';
            $this->Reglement->recursive = 0;
            if($par <> "P"){
        $this->set('reglements', $this->Reglement->find('all', array( 'conditions' => array('AND'=>array('Reglement.Date >=' => $new_dated,'Reglement.Date <=' => $new_datef,'Reglement.pointvente_id' => $pv,'Reglement.type' => 0)),
                    'order' => array('Reglement.id' => 'desc'))));
            }else{
               $this->set('reglements', $this->Reglement->find('all', array( 'conditions' => array('AND'=>array('Reglement.Date >=' => $new_dated,'Reglement.Date <=' => $new_datef,'Reglement.type' => 0)),
                    'order' => array('Reglement.id' => 'desc')))); 
            }
        $this->set(compact('bb','debut','fin'));
            }
        }
            else{
        $this->Reglement->recursive = 0;
        if($par <> "P"){
        $this->set('reglements', $this->Reglement->find('all', array('conditions' => array('Reglement.pointvente_id' => $pv,'Reglement.type' => 0),
                    'order' => array('Reglement.id' => 'desc'))));
                 }else{
                    $this->set('reglements', $this->Reglement->find('all', array(
                    'conditions'=>array('Reglement.type' => 0),
                    'order' => array('Reglement.id' => 'desc')))); 
                 }
        $bb='closed';$debut="";$fin="";
        $this->set(compact('bb','debut','fin'));
        }
//        $this->Reglement->recursive = 0;
//        $this->set('reglements', $this->paginate());
//        $this->set('reglements', $this->Reglement->find('all', array(
//                    'order' => array('Reglement.id' => 'DESC'))));
    }

    /**
     * view method
     *
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $status_garderie=  CakeSession::read('client');
           if ( $status_garderie <> "CL"){
    
     $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
           }
        App::import('Model', 'Lignereglement');
        $this->Lignereglement = new Lignereglement;
        App::import('Model', 'Paiement');
        $this->Paiement = new Paiement;
        App::import('Model', 'Reglement');
        $this->Reglement = new Reglement;
        App::import('Model', 'Factureavoirfinancier');
        $this->Factureavoirfinancier = new Factureavoirfinancier; 
        App::import('Model', 'Piecereglement');
        $this->Piecereglement = new Piecereglement;
        App::import('Model', 'Cheque');
        $this->Cheque = new Cheque;
        App::import('Model', 'Traite');
        $this->Traite = new Traite;
        App::import('Model', 'Facture');
        $this->Facture = new Facture;
        $this->Reglement->id = $id;
        App::import('Model', 'Retenue');
        $this->Retenue = new Retenue;
        if (!$this->Reglement->exists()) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $this->set('reglement', $this->Reglement->read(null, $id));
        
        $reg=$this->Reglement->read(null, $id);
        //debug($reg['Piecereglement']);die;
        $factures = $this->Facture->find('all', array('recursive' => -1,
            'conditions' => array('Facture.client_id' => $reg['Reglement']['client_id']),
                ));
        
            foreach ($reg['Piecereglement'] as $ac => $acomp) {
                if ($acomp['paiement_id'] == 2) {
                    $ch = $this->Cheque->find('all', array(
                        'conditions' => array('Cheque.id' => $acomp['id_piece']), 'recursive' => -1,
                        'fields' => array('Cheque.Echeance', 'Cheque.Numero', 'Cheque.Numero', 'Cheque.Proprietaire')));
                }
                if ($acomp['paiement_id'] == 3) {
                    $ch = $this->Traite->find('all', array(
                        'conditions' => array('Traite.id' => $acomp['id_piece']), 'recursive' => -1,
                        'fields' => array('Traite.Echeance', 'Traite.Numero', 'Traite.Numero', 'Traite.Proprietaire')));
                }
                if ($acomp['paiement_id'] == 5) {
                    $ch = $this->Reglement->find('all', array(
                        'conditions' => array('Reglement.id' => $acomp['id_piece']), 'recursive' => -1
                        ));
                }
                if ($acomp['paiement_id'] == 6) {
                    $ch = $this->Factureavoirfinancier->find('all', array(
                        'conditions' => array('Factureavoirfinancier.id' => $acomp['id_piece']), 'recursive' => -1
                        ));
                }
                if ($acomp['paiement_id'] == 7) {
                    $ch = $this->Retenue->find('all', array(
                        'conditions' => array('Retenue.id' => $acomp['id_piece']), 'recursive' => -1
                        ));
                }
                if (($acomp['paiement_id'] == 2) || ($acomp['paiement_id'] == 3)||($acomp['paiement_id'] == 5) || ($acomp['paiement_id'] == 6)|| ($acomp['paiement_id'] == 7)) {
                    $cheque[$ac] = $ch[0];
                }
            }
        
        $this->set(compact('factures','cheque'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $status_garderie=  CakeSession::read('client');
           if ( $status_garderie <> "CL"){
    
     $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
           }
        if ($this->request->is('post')) {
            $this->Reglement->create();
            if ($this->Reglement->save($this->request->data)) {
                $this->flash(__('Reglement saved.'), array('action' => 'index'));
            } else {
                
            }
        }
        $clients = $this->Reglement->Client->find('list');
        $this->set(compact('clients'));
    }

/*    public function reglement($client_id = null) {
        $status_garderie=  CakeSession::read('client');
           if ( $status_garderie <> "CL"){
    
     $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
           }
        App::import('Model', 'Facture');
        $this->Facture = new Facture;
        App::import('Model', 'Lignereglement');
        $this->Lignereglement = new Lignereglement;
        App::import('Model', 'Paiement');
        $this->Paiement = new Paiement;
        App::import('Model', 'Factureavoir');
        $this->Factureavoir = new Factureavoir;
        App::import('Model', 'Factureavoirfinancier');
        $this->Factureavoirfinancier = new Factureavoirfinancier; 
        App::import('Model', 'Piecereglement');
        $this->Piecereglement = new Piecereglement;
        App::import('Model', 'Cheque');
        $this->Cheque = new Cheque;
        App::import('Model', 'Traite');
        $this->Traite = new Traite;
         App::import('Model', 'Banque');
        $this->Banque = new Banque;
        App::import('Model', 'Retenue');
        $this->Retenue = new Retenue;
        if ($this->request->is('post')) {
            $date2 = explode('/', $this->request->data['Reglement']['Date']);
            $new_date1 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $this->request->data['Reglement']['Date'] = $new_date1;
            $som = $this->request->data['Reglement']['Montant'];
            $this->request->data['Reglement']['utilisateur_id'] =  CakeSession::read('users');
           $this->request->data['Reglement']['pointvente_id']=  CakeSession::read('point');
            $this->Reglement->create();
            if ($this->Reglement->save($this->request->data)) {
                $id = $this->Reglement->id;
                foreach ($this->request->data['key'] as $abc) {
                    $facture = explode("/", $abc);
                    $mont = $facture[0];
                    $id_fact = $facture[1];
                    if (($mont <= $som) && ($mont > 0)) {
                        $this->request->data['Lignereglement']['reglement_id'] = $id;
                        $this->request->data['Lignereglement']['id_piece'] = $id_fact;
                        $this->request->data['Lignereglement']['type'] = 'fac';
                        $this->request->data['Lignereglement']['Montant'] = $mont;
                        $this->Lignereglement->create();
                        $this->Lignereglement->save($this->request->data['Lignereglement']);
                        $this->Facture->updateAll(array('Facture.Montant_Regler ' => 'Facture.Montant_Regler+' . $mont), array(
                            'Facture.id' => $id_fact
                        ));
                        $som = $som - $mont;
                        $mont = 0;
                    }
                    if (($mont > $som) && ($som > 0)) {
                        $this->request->data['Lignereglement']['reglement_id'] = $id;
                        $this->request->data['Lignereglement']['id_piece'] = $id_fact;
                        $this->request->data['Lignereglement']['type'] = 'fac';
                        $this->request->data['Lignereglement']['Montant'] = $som;
                        $this->Lignereglement->create();
                        $this->Lignereglement->save($this->request->data['Lignereglement']);
                        $this->Facture->updateAll(array('Facture.Montant_Regler ' => 'Facture.Montant_Regler+' . $som), array(
                            'Facture.id' => $id_fact
                        ));
                        $som = 0;
                        $mont = 0;
                    }
                }
                  if (isset($this->request->data['Piecereglement']) && !empty($this->request->data['Piecereglement'])) {
                        foreach ($this->request->data['Piecereglement'] as $acompte) {

                            $acompte['reglement_id'] = $id;
                            $acompte['Montant'] = $acompte['montant'];
                            $acompte['paiement_id'] = $acompte['paiement_id'];
                            $acompte['date'] = $new_date1;
                            $id_piece =0;
                            $this->Piecereglement->create();
                            $this->Piecereglement->saveAll($acompte);
                            $id_ligne = $this->Piecereglement->id;
                            if ($acompte['paiement_id'] == 2) {
                                $datee = explode('/', $acompte['echeance']);
                                $new_datee = $datee[2] . '-' . $datee[1] . '-' . $datee[0];
                                $this->request->data['Cheque']['Montant'] = $acompte['montant'];
                                $this->request->data['Cheque']['Echeance'] = $new_datee;
                                $this->request->data['Cheque']['Numero'] = $acompte['num'];
                                $this->request->data['Cheque']['Proprietaire'] = $acompte['proprietaire'];
                                $this->request->data['Cheque']['banque_id'] = $acompte['banque'];
                                $this->request->data['Cheque']['client_id'] = $this->request->data['Reglement']['client_id'];
                                $this->request->data['Cheque']['Date_encaissement'] = $new_date1;
                                $this->request->data['Cheque']['utilisateur_id'] =  CakeSession::read('users');
                                $this->request->data['Cheque']['pointvente_id']=  CakeSession::read('point');
                                $this->Cheque->create();
                                $this->Cheque->save($this->request->data['Cheque']);
                                $id_piece = $this->Cheque->id;
                            }
                            if ($acompte['paiement_id'] == 3) {
                                $datee = explode('/', $acompte['echeance']);
                                $new_datee = $datee[2] . '-' . $datee[1] . '-' . $datee[0];
                                $this->request->data['Traite']['Montant'] = $acompte['montant'];
                                $this->request->data['Traite']['Echeance'] = $new_datee;
                                $this->request->data['Traite']['Numero'] = $acompte['num'];
                                $this->request->data['Traite']['Proprietaire'] = $acompte['proprietaire'];
                                $this->request->data['Traite']['banque_id'] = $acompte['banque'];
                                $this->request->data['Traite']['client_id'] = $this->request->data['Reglement']['client_id'];
                                $this->request->data['Traite']['Date_Encaissement'] = $new_date1;
                                $this->request->data['Traite']['utilisateur_id'] =  CakeSession::read('users');
                                $this->request->data['Traite']['pointvente_id']=  CakeSession::read('point');
                                $this->Traite->create();
                                $this->Traite->save($this->request->data['Traite']);
                                $id_piece = $this->Traite->id;
                            }
                            if ($acompte['paiement_id'] == 7) {
                                
                                $this->request->data['Retenue']['Montant_Brut'] = $acompte['montantbrut'];
                                 $this->request->data['Retenue']['Montant'] = $acompte['montant'];
                                 $this->request->data['Retenue']['Montant_Net'] = $acompte['net'];
                                $this->request->data['Retenue']['client_id'] = $this->request->data['Reglement']['client_id'];
                                $this->request->data['Retenue']['Date'] = $new_date1;
                                $this->request->data['Retenue']['utilisateur_id'] =  CakeSession::read('users');
                                $this->request->data['Retenue']['pointvente_id']=  CakeSession::read('point');
                                $this->Retenue->create();
                                $this->Retenue->save($this->request->data['Retenue']);
                                $id_piece = $this->Retenue->id;
                            }
                            if ($acompte['paiement_id'] == 5) {
                                $id_piece=$acompte['avoir'];
                                $this->Reglement->updateAll(array('Reglement.Reste' => 'Reglement.Reste -'.$acompte['montant']), array(
                            'Reglement.id' => $acompte['avoir']
                            
                        ));
                                
                            }
                            if ($acompte['paiement_id'] == 6) {
                                $id_piece=$acompte['finance'];
                                $this->Factureavoirfinancier->updateAll(array('Factureavoirfinancier.Reste' => 'Factureavoirfinancier.Reste -'.$acompte['montant']), array(
                            'Factureavoirfinancier.id' => $acompte['finance']
                            
                        ));
                                
                            }
                            $this->Piecereglement->updateAll(
                                    array('Piecereglement.id_piece' => "$id_piece"), array('Piecereglement.id' => $id_ligne));
                        }
                    }
                $this->redirect(array('action' => 'index'));
            } else {
                
            }
        }
        $facture = $this->Facture->find('all', array(
            'conditions' => array('AND'=>array('Facture.Total_TTC+Facture.Timbre > Facture.Montant_Regler','Facture.client_id' => $client_id)), 'recursive' => 2,
            'contain' => array('Client', 'Bonlivraison', 'Client.Acompte', 'Bonlivraison.Boncommande', 'Bonlivraison.Acompte')));
        $cl = $client_id;
        $avoirs = $this->Factureavoir->find('list', array(
            'conditions' => array('AND'=>array('Factureavoir.client_id' => $client_id,'Factureavoir.Reste >0')), 'recursive' => -1,));
        $financiers = $this->Factureavoirfinancier->find('list', array(
            'conditions' => array('AND'=>array('Factureavoirfinancier.client_id' => $client_id,'Factureavoirfinancier.Reste >0')), 'recursive' => -1,));
        $mode = $this->Paiement->find('all', array('recursive' => -1));
        $clients = $this->Reglement->Client->find('list');
        $banques = $this->Banque->find('list');
        $this->set(compact('banques','clients', 'cl', 'facture','mode','avoirs','financiers'));
    }
*/
    public function reglement($client_id = null) {
        $status_garderie=  CakeSession::read('client');
           if ( $status_garderie <> "CL"){
    
     $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
           }
        App::import('Model', 'Facture');
        $this->Facture = new Facture;
        App::import('Model', 'Lignereglement');
        $this->Lignereglement = new Lignereglement;
        App::import('Model', 'Paiement');
        $this->Paiement = new Paiement;
        App::import('Model', 'Factureavoir');
        $this->Factureavoir = new Factureavoir;
        App::import('Model', 'Factureavoirfinancier');
        $this->Factureavoirfinancier = new Factureavoirfinancier; 
        App::import('Model', 'Piecereglement');
        $this->Piecereglement = new Piecereglement;
        App::import('Model', 'Cheque');
        $this->Cheque = new Cheque;
        App::import('Model', 'Traite');
        $this->Traite = new Traite;
         App::import('Model', 'Banque');
        $this->Banque = new Banque;
        App::import('Model', 'Retenue');
        $this->Retenue = new Retenue;
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $date2 = explode('/', $this->request->data['Reglement']['Date']);
            $new_date1 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $this->request->data['Reglement']['Date'] = $new_date1;
            $som = $this->request->data['Reglement']['Montant'];
            $this->request->data['Reglement']['utilisateur_id'] =  CakeSession::read('users');
           $this->request->data['Reglement']['pointvente_id']=  CakeSession::read('point');
            $this->Reglement->create();
            if ($this->Reglement->save($this->request->data)) {
                $id = $this->Reglement->id;
                foreach ($this->request->data['key'] as $abc) {
                    $facture = explode("/", $abc);
                    $mont = $facture[0];
                    $id_fact = $facture[1];
                    if (($mont <= $som) && ($mont > 0)) {
                        $abc='-'.$id;
                        $this->request->data['Lignereglement']['reglement_id'] = $id;
                        $this->request->data['Lignereglement']['id_piece'] = $id_fact;
                        $this->request->data['Lignereglement']['type'] = 'fac';
                        $this->request->data['Lignereglement']['Montant'] = $mont;
                        $this->Lignereglement->create();
                        $this->Lignereglement->save($this->request->data['Lignereglement']);
                        $this->Facture->updateAll(array('Facture.Montant_Regler ' => 'Facture.Montant_Regler+' . $mont,'Facture.id_acompte' => 'CONCAT(Facture.id_acompte,'."$abc".')'), array(
                            'Facture.id' => $id_fact
                        ));
                        $som = $som - $mont;
                        $mont = 0;
                    }
                    if (($mont > $som) && ($som > 0)) {
                        $abc='-'.$id;
                        $this->request->data['Lignereglement']['reglement_id'] = $id;
                        $this->request->data['Lignereglement']['id_piece'] = $id_fact;
                        $this->request->data['Lignereglement']['type'] = 'fac';
                        $this->request->data['Lignereglement']['Montant'] = $som;
                        $this->Lignereglement->create();
                        $this->Lignereglement->save($this->request->data['Lignereglement']);
                        $this->Facture->updateAll(array('Facture.Montant_Regler ' => 'Facture.Montant_Regler+' . $som,'Facture.id_acompte' => 'CONCAT(Facture.id_acompte,'."$abc".')'), array(
                            'Facture.id' => $id_fact
                        ));
                        $som = 0;
                        $mont = 0;
                    }
                }
                // Facture Avoir
                if(!empty($this->request->data['avo'])){
                foreach ($this->request->data['avo'] as $abc) {
                    $facture = explode("/", $abc);
                    $mont = $facture[0];
                    $mont= $mont * (-1);
                   //debug($mont);die;
                    $id_fact = $facture[1];
                    
                        $this->request->data['Lignereglement']['reglement_id'] = $id;
                        $this->request->data['Lignereglement']['id_piece'] = $id_fact;
                        $this->request->data['Lignereglement']['type'] = 'avoir';
                        $this->request->data['Lignereglement']['Montant'] = $mont;
                        $this->Lignereglement->create();
                        $this->Lignereglement->save($this->request->data['Lignereglement']);
                        $this->Factureavoir->updateAll(array('Factureavoir.Reg ' => 1), array(
                            'Factureavoir.id' => $id_fact
                        ));
                        
                        $mont = 0;
                    
                }
                }
                  if (isset($this->request->data['Piecereglement']) && !empty($this->request->data['Piecereglement'])) {
                        foreach ($this->request->data['Piecereglement'] as $acompte) {

                            $acompte['reglement_id'] = $id;
                            $acompte['Montant'] = $acompte['montant'];
                            $acompte['paiement_id'] = $acompte['paiement_id'];
                            $acompte['date'] = $new_date1;
                            $id_piece =0;
                            $this->Piecereglement->create();
                            $this->Piecereglement->saveAll($acompte);
                            $id_ligne = $this->Piecereglement->id;
                            if ($acompte['paiement_id'] == 2) {
                                $datee = explode('/', $acompte['echeance']);
                                $new_datee = $datee[2] . '-' . $datee[1] . '-' . $datee[0];
                                $this->request->data['Cheque']['Montant'] = $acompte['montant'];
                                $this->request->data['Cheque']['Echeance'] = $new_datee;
                                $this->request->data['Cheque']['Numero'] = $acompte['num'];
                                $this->request->data['Cheque']['Proprietaire'] = $acompte['proprietaire'];
                                $this->request->data['Cheque']['banque_id'] = $acompte['banque'];
                                $this->request->data['Cheque']['client_id'] = $this->request->data['Reglement']['client_id'];
                                $this->request->data['Cheque']['Date_encaissement'] = $new_date1;
                                $this->request->data['Cheque']['utilisateur_id'] =  CakeSession::read('users');
                                $this->request->data['Cheque']['pointvente_id']=  CakeSession::read('point');
                                $this->Cheque->create();
                                $this->Cheque->save($this->request->data['Cheque']);
                                $id_piece = $this->Cheque->id;
                            }
                            if ($acompte['paiement_id'] == 3) {
                                $datee = explode('/', $acompte['echeance']);
                                $new_datee = $datee[2] . '-' . $datee[1] . '-' . $datee[0];
                                $this->request->data['Traite']['Montant'] = $acompte['montant'];
                                $this->request->data['Traite']['Echeance'] = $new_datee;
                                $this->request->data['Traite']['Numero'] = $acompte['num'];
                                $this->request->data['Traite']['Proprietaire'] = $acompte['proprietaire'];
                                $this->request->data['Traite']['banque_id'] = $acompte['banque'];
                                $this->request->data['Traite']['client_id'] = $this->request->data['Reglement']['client_id'];
                                $this->request->data['Traite']['Date_Encaissement'] = $new_date1;
                                $this->request->data['Traite']['utilisateur_id'] =  CakeSession::read('users');
                                $this->request->data['Traite']['pointvente_id']=  CakeSession::read('point');
                                $this->Traite->create();
                                $this->Traite->save($this->request->data['Traite']);
                                $id_piece = $this->Traite->id;
                            }
                            if ($acompte['paiement_id'] == 7) {
                                
                                $this->request->data['Retenue']['Montant_Brut'] = $acompte['montantbrut'];
                                $this->request->data['Retenue']['Montant'] = $acompte['montant'];
                                $this->request->data['Retenue']['Montant_Net'] = $acompte['net'];
                                $this->request->data['Retenue']['client_id'] = $this->request->data['Reglement']['client_id'];
                                $this->request->data['Retenue']['Date'] = $new_date1;
                                $this->request->data['Retenue']['utilisateur_id'] =  CakeSession::read('users');
                                $this->request->data['Retenue']['pointvente_id']=  CakeSession::read('point');
                                $this->Retenue->create();
                                $this->Retenue->save($this->request->data['Retenue']);
                                $id_piece = $this->Retenue->id;
                            }
                            if ($acompte['paiement_id'] == 5) {
                                $id_piece=$acompte['avoir'];
                                $this->Reglement->updateAll(array('Reglement.Reste' => 'Reglement.Reste -'.$acompte['montant']), array(
                            'Reglement.id' => $acompte['avoir']
                            
                        ));
                                
                            }
                            if ($acompte['paiement_id'] == 6) {
                                $id_piece=$acompte['finance'];
                                $this->Factureavoirfinancier->updateAll(array('Factureavoirfinancier.Reste' => 'Factureavoirfinancier.Reste -'.$acompte['montant']), array(
                            'Factureavoirfinancier.id' => $acompte['finance']
                            
                        ));
                                
                            }
                            $this->Piecereglement->updateAll(
                                    array('Piecereglement.id_piece' => "$id_piece"), array('Piecereglement.id' => $id_ligne));
                        }
                    }
                $this->redirect(array('action' => 'index'));
            } else {
                
            }
        }
        $facture = $this->Facture->find('all', array(
            'conditions' => array('AND'=>array('Facture.Total_TTC> Facture.Montant_Regler','Facture.client_id' => $client_id)), 'recursive' => 2,
            'contain' => array('Client', 'Bonlivraison', 'Client.Acompte', 'Bonlivraison.Boncommande')
            ,'order'=>array('Facture.Numero asc')));
        $cl = $client_id;
        $avoirs = $this->Factureavoir->find('all', array(
            'conditions' => array('AND'=>array('Factureavoir.client_id' => $client_id,'Factureavoir.Reste >0','Factureavoir.Reg =0')), 'recursive' => -1,));
       //debug($avoirs);die;
        $financiers = $this->Factureavoirfinancier->find('list', array(
            'conditions' => array('AND'=>array('Factureavoirfinancier.client_id' => $client_id,'Factureavoirfinancier.Reste >0')), 'recursive' => -1,));
        $mode = $this->Paiement->find('all', array('recursive' => -1));
        $clients = $this->Reglement->Client->find('list');
        $banques = $this->Banque->find('list');
        $this->set(compact('banques','clients', 'cl', 'facture','mode','avoirs','financiers'));
    }

    /**
     * edit method
     *
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $status_garderie=  CakeSession::read('client');
           if ( $status_garderie <> "CL"){
    
     $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
           }
        $this->Reglement->id = $id;
        if (!$this->Reglement->exists()) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Reglement->save($this->request->data)) {
                $this->flash(__('The reglement has been saved.'), array('action' => 'index'));
            } else {
                
            }
        } else {
            $this->request->data = $this->Reglement->read(null, $id);
        }
        $clients = $this->Reglement->Client->find('list');
        $this->set(compact('clients'));
    }

    /**
     * delete method
     *
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        App::import('Model', 'Lignereglement');
        $this->Lignereglement = new Lignereglement;
        App::import('Model', 'Facture');
        $this->Facture = new Facture;
         App::import('Model', 'Piecereglement');
        $this->Piecereglement = new Piecereglement;
        App::import('Model', 'Cheque');
        $this->Cheque = new Cheque;
        App::import('Model', 'Traite');
        $this->Traite = new Traite;
        App::import('Model', 'Factureavoirfinancier');
        $this->Factureavoirfinancier = new Factureavoirfinancier;
        App::import('Model', 'Reglement');
        $this->Reglement = new Reglement;
        $this->loadModel('Factureavoir');
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Reglement->id = $id;
        if (!$this->Reglement->exists()) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $lignes = $this->Lignereglement->find('all', array('recursive' => -1,
            'conditions' => array('Lignereglement.reglement_id' => $id)
                ));
        $pieces = $this-> Piecereglement->find('all', array('recursive' => -1,
            'conditions' => array('Piecereglement.reglement_id' => $id)
                ));
        
        
       
        if ($this->Reglement->delete()) {
            foreach($lignes as $ligne){
           
            if($ligne['Lignereglement']['type']=='fac'){
                $this->Lignereglement->delete($ligne['Lignereglement']['id']);
             $this->Facture->updateAll(array('Facture.Montant_Regler' => 'Facture.Montant_Regler -'.$ligne['Lignereglement']['Montant']), array(
                            'Facture.id' => $ligne['Lignereglement']['id_piece'] )); 
            }
            
            if($ligne['Lignereglement']['type']=='avoir'){
                $this->Lignereglement->delete($ligne['Lignereglement']['id']);
             $this->Factureavoir->updateAll(array('Factureavoir.Reg' => 0 ), array(
                            'Factureavoir.id' => $ligne['Lignereglement']['id_piece'] )); 
            }
            
        }
        foreach($pieces as $piece){
         
          $this->Piecereglement->delete($piece['Piecereglement']['id']);
                if ($piece['Piecereglement']['paiement_id'] == 2) {
                    $this->Cheque->delete($piece['Piecereglement']['id_piece']);
                }
                if ($piece['Piecereglement']['paiement_id'] == 3) {
                    $this->Traite->delete($piece['Piecereglement']['id_piece']);
                }
                 if ($piece['Piecereglement']['paiement_id'] == 5) {
                     $this->Reglement->updateAll(array('Reglement.Reste' => 'Reglement.Reste +'.$piece['Piecereglement']['Montant']), array(
                            'Reglement.id' => $piece['Piecereglement']['id_piece']
                            
                        ));
                     
                }
                if ($piece['Piecereglement']['paiement_id'] == 6) {
                     $this->Factureavoirfinancier->updateAll(array('Factureavoirfinancier.Reste' => 'Factureavoirfinancier.Reste +'.$piece['Piecereglement']['Montant']), array(
                            'Factureavoirfinancier.id' => $piece['Piecereglement']['id_piece']
                            
                        ));
                     
                }
        }
        
            $this->flash(__('Reglement deleted'), array('action' => 'index'));
        }
        $this->flash(__('Reglement was not deleted'), array('action' => 'index'));
        $this->redirect(array('action' => 'index'));
    }
public function select($id = null) {
        $this->layout = null;
        App::import('Model', 'Reglement');
        $this->Reglement = new Reglement;
        $nums = $this->Reglement->find('all', array('recursive' => -1,
            'conditions' => array('Reglement.id' => $id),
            'fields' => array('Reglement.Total_TTC','Reglement.Reste')
                ));
         echo json_encode(array('Fac' => $nums));
        }
        public function select1($id = null) {
        $this->layout = null;
        App::import('Model', 'Factureavoirfinancier');
        $this->Factureavoirfinancier = new Factureavoirfinancier;
        $nums = $this->Factureavoirfinancier->find('all', array('recursive' => -1,
            'conditions' => array('Factureavoirfinancier.id' => $id),
            'fields' => array('Factureavoirfinancier.Montant','Factureavoirfinancier.Reste')
                ));
         echo json_encode(array('Fac' => $nums));
        }
         public function add_1() {
        App::import('Model', 'Paiement');
        $this->Paiement = new Paiement;
         App::import('Model', 'Banque');
        $this->Banque = new Banque;
         App::import('Model', 'Piecereglement');
        $this->Piecereglement = new Piecereglement;
        App::import('Model', 'Cheque');
        $this->Cheque = new Cheque;
        App::import('Model', 'Traite');
        $this->Traite = new Traite;
        $status_garderie=  CakeSession::read('client');
           if ( $status_garderie <> "CL"){
    
     $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
           }
        if ($this->request->is('post')) {
             $this->request->data['Reglement']['type']=1;
            $date2 = explode('/', $this->request->data['Reglement']['Date']);
            $new_date1 = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $this->request->data['Reglement']['Date'] = $new_date1;
            $som = $this->request->data['Reglement']['Montant'];
            $this->request->data['Reglement']['utilisateur_id'] =  CakeSession::read('users');
            $this->Reglement->create();
            if ($this->Reglement->save($this->request->data)) {
                $id = $this->Reglement->id;
                 if (isset($this->request->data['Piecereglement']) && !empty($this->request->data['Piecereglement'])) {
                        foreach ($this->request->data['Piecereglement'] as $acompte) {

                            $acompte['reglement_id'] = $id;
                            $acompte['Montant'] = $acompte['montant'];
                            $acompte['paiement_id'] = $acompte['paiement_id'];
                            $acompte['date'] = $new_date1;
                            $id_piece =0;
                            $this->Piecereglement->create();
                            $this->Piecereglement->saveAll($acompte);
                            $id_ligne = $this->Piecereglement->id;
                            if ($acompte['paiement_id'] == 2) {
                                $datee = explode('/', $acompte['echeance']);
                                $new_datee = $datee[2] . '-' . $datee[1] . '-' . $datee[0];
                                $this->request->data['Cheque']['Montant'] = $acompte['montant'];
                                $this->request->data['Cheque']['Echeance'] = $new_datee;
                                $this->request->data['Cheque']['Numero'] = $acompte['num'];
                                $this->request->data['Cheque']['Proprietaire'] = $acompte['proprietaire'];
                                $this->request->data['Cheque']['banque_id'] = $acompte['banque'];
                                $this->request->data['Cheque']['client_id'] = $this->request->data['Reglement']['client_id'];
                                $this->request->data['Cheque']['Date_encaissement'] = $new_date1;
                                $this->request->data['Cheque']['utilisateur_id'] =  CakeSession::read('users');
                                $this->request->data['Cheque']['pointvente_id']=  CakeSession::read('point');
                                $this->Cheque->create();
                                $this->Cheque->save($this->request->data['Cheque']);
                                $id_piece = $this->Cheque->id;
                            }
                            if ($acompte['paiement_id'] == 3) {
                                $datee = explode('/', $acompte['echeance']);
                                $new_datee = $datee[2] . '-' . $datee[1] . '-' . $datee[0];
                                $this->request->data['Traite']['Montant'] = $acompte['montant'];
                                $this->request->data['Traite']['Echeance'] = $new_datee;
                                $this->request->data['Traite']['Numero'] = $acompte['num'];
                                $this->request->data['Traite']['Proprietaire'] = $acompte['proprietaire'];
                                $this->request->data['Traite']['banque_id'] = $acompte['banque'];
                                $this->request->data['Traite']['client_id'] = $this->request->data['Reglement']['client_id'];
                                $this->request->data['Traite']['Date_Encaissement'] = $new_date1;
                                $this->request->data['Traite']['utilisateur_id'] =  CakeSession::read('users');
                                $this->request->data['Traite']['pointvente_id']=  CakeSession::read('point');
                                $this->Traite->create();
                                $this->Traite->save($this->request->data['Traite']);
                                $id_piece = $this->Traite->id;
                            }
                            
                           
                            $this->Piecereglement->updateAll(
                                    array('Piecereglement.id_piece' => "$id_piece"), array('Piecereglement.id' => $id_ligne));
                        }
                    }
                $this->redirect(array('action' => 'index_1'));
                $this->flash(__('Reglement saved.'), array('action' => 'index'));
            } else {
                
            }
        }
        $mode = $this->Paiement->find('all', array('recursive' => -1));
        $clients = $this->Reglement->Client->find('list',array('fields'=>array('Client.id','Client.Raison_Social')));
        $banques = $this->Banque->find('list');
        $this->set(compact('clients','mode','banques'));
       
        //$clients = $this->Reglement->Client->find('list');
        //$banques = $this->Banque->find('list');
        //$this->set(compact('banques','clients', 'mode'));
    }
    public function index_1() {
          $status_garderie=  CakeSession::read('client');
        $par=CakeSession::read('parrametre');
        
           if ( $status_garderie <> "CL"){
    
     $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
               
           }
           $pv=  CakeSession::read('point');
 if ($this->request->is('post')) {
			//debug($this->request->data);die;
            if (isset($this->request->data['Reglement']['tout']) && !empty($this->request->data['Reglement']['tout'])) {
                 $debut="";$fin="";
                 $this->Reglement->recursive = 0;
                 if($par <> "P"){
        $this->set('reglements', $this->Reglement->find('all', array('conditions' => array('Reglement.pointvente_id' => $pv,'Reglement.type' => 1),
                    'order' => array('Reglement.id' => 'desc'))));
                 }else{
                    $this->set('reglements', $this->Reglement->find('all', array(
                        'conditions' => array('Reglement.type' => 1),
                    'order' => array('Reglement.id' => 'desc')))); 
                 }
        $bb='closed';
        $this->set(compact('bb','debut','fin'));
            } if (isset($this->request->data['Reglement']['afficher']) && !empty($this->request->data['Reglement']['afficher'])) {
                
                $debut=$this->request->data['Reglement']['Entre'];
            $fin=$this->request->data['Reglement']['Et'];
            $date1 = explode('/', $this->request->data['Reglement']['Entre']);
            $new_dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
            $date2 = explode('/', $this->request->data['Reglement']['Et']);
            $new_datef = $date2[2] . '-' . $date2[1] . '-' . $date2[0];
            $bb='opened';
            $this->Reglement->recursive = 0;
            if($par <> "P"){
        $this->set('reglements', $this->Reglement->find('all', array( 'conditions' => array('AND'=>array('Reglement.Date >=' => $new_dated,'Reglement.Date <=' => $new_datef,'Reglement.pointvente_id' => $pv,'Regelement.type'=>1)),
                    'order' => array('Reglement.id' => 'desc'))));
            }else{
               $this->set('reglements', $this->Reglement->find('all', array( 'conditions' => array('AND'=>array('Reglement.Date >=' => $new_dated,'Reglement.Date <=' => $new_datef,'Reglement.type'=>1)),
                    'order' => array('Reglement.id' => 'desc')))); 
            }
        $this->set(compact('bb','debut','fin'));
            }
        }
            else{
        $this->Reglement->recursive = 0;
        if($par <> "P"){
        $this->set('reglements', $this->Reglement->find('all', array('conditions' => array('Reglement.pointvente_id' => $pv,'Reglement.type'=>1),
                    'order' => array('Reglement.id' => 'desc'))));
                 }else{
                    $this->set('reglements', $this->Reglement->find('all', array(
                        'conditions' => array('Reglement.type' => 1),
                    'order' => array('Reglement.id' => 'desc')))); 
                 }
        $bb='closed';$debut="";$fin="";
        $this->set(compact('bb','debut','fin'));
        }
//        $this->Reglement->recursive = 0;
//        $this->set('reglements', $this->paginate());
//        $this->set('reglements', $this->Reglement->find('all', array(
//                    'order' => array('Reglement.id' => 'DESC'))));
    }
     public function view_1($id = null) {
        $status_garderie=  CakeSession::read('client');
           if ( $status_garderie <> "CL"){
    
     $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
           }
        App::import('Model', 'Lignereglement');
        $this->Lignereglement = new Lignereglement;
        App::import('Model', 'Paiement');
        $this->Paiement = new Paiement;
        App::import('Model', 'Reglement');
        $this->Reglement = new Reglement;
        App::import('Model', 'Factureavoirfinancier');
        $this->Factureavoirfinancier = new Factureavoirfinancier; 
        App::import('Model', 'Piecereglement');
        $this->Piecereglement = new Piecereglement;
        App::import('Model', 'Cheque');
        $this->Cheque = new Cheque;
        App::import('Model', 'Traite');
        $this->Traite = new Traite;
        App::import('Model', 'Facture');
        $this->Facture = new Facture;
        $this->Reglement->id = $id;
        App::import('Model', 'Retenue');
        $this->Retenue = new Retenue;
        if (!$this->Reglement->exists()) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $this->set('reglement', $this->Reglement->read(null, $id));
        
        $reg=$this->Reglement->read(null, $id);
        //debug($reg['Piecereglement']);die;
        $factures = $this->Facture->find('all', array('recursive' => -1,
            'conditions' => array('Facture.client_id' => $reg['Reglement']['client_id']),
                ));
        
            foreach ($reg['Piecereglement'] as $ac => $acomp) {
                if ($acomp['paiement_id'] == 2) {
                    $ch = $this->Cheque->find('all', array(
                        'conditions' => array('Cheque.id' => $acomp['id_piece']), 'recursive' => -1,
                        'fields' => array('Cheque.Echeance', 'Cheque.Numero', 'Cheque.Numero', 'Cheque.Proprietaire')));
                }
                if ($acomp['paiement_id'] == 3) {
                    $ch = $this->Traite->find('all', array(
                        'conditions' => array('Traite.id' => $acomp['id_piece']), 'recursive' => -1,
                        'fields' => array('Traite.Echeance', 'Traite.Numero', 'Traite.Numero', 'Traite.Proprietaire')));
                }
                if ($acomp['paiement_id'] == 5) {
                    $ch = $this->Reglement->find('all', array(
                        'conditions' => array('Reglement.id' => $acomp['id_piece']), 'recursive' => -1
                        ));
                }
                if ($acomp['paiement_id'] == 6) {
                    $ch = $this->Factureavoirfinancier->find('all', array(
                        'conditions' => array('Factureavoirfinancier.id' => $acomp['id_piece']), 'recursive' => -1
                        ));
                }
                if ($acomp['paiement_id'] == 7) {
                    $ch = $this->Retenue->find('all', array(
                        'conditions' => array('Retenue.id' => $acomp['id_piece']), 'recursive' => -1
                        ));
                }
                if (($acomp['paiement_id'] == 2) || ($acomp['paiement_id'] == 3)||($acomp['paiement_id'] == 5) || ($acomp['paiement_id'] == 6)|| ($acomp['paiement_id'] == 7)) {
                    $cheque[$ac] = $ch[0];
                }
            }
        
        $this->set(compact('factures','cheque'));
    }
     public function delete_1($id = null) {
        App::import('Model', 'Lignereglement');
        $this->Lignereglement = new Lignereglement;
        App::import('Model', 'Facture');
        $this->Facture = new Facture;
         App::import('Model', 'Piecereglement');
        $this->Piecereglement = new Piecereglement;
        App::import('Model', 'Cheque');
        $this->Cheque = new Cheque;
        App::import('Model', 'Traite');
        $this->Traite = new Traite;
        App::import('Model', 'Factureavoirfinancier');
        $this->Factureavoirfinancier = new Factureavoirfinancier;
        App::import('Model', 'Reglement');
        $this->Reglement = new Reglement;
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Reglement->id = $id;
        if (!$this->Reglement->exists()) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $lignes = $this->Lignereglement->find('all', array('recursive' => -1,
            'conditions' => array('Lignereglement.reglement_id' => $id)
                ));
        $pieces = $this-> Piecereglement->find('all', array('recursive' => -1,
            'conditions' => array('Piecereglement.reglement_id' => $id)
                ));
        
        
       
        if ($this->Reglement->delete()) {
            foreach($lignes as $ligne){
           
            if($ligne['Lignereglement']['type']=='fac'){
                $this->Lignereglement->delete($ligne['Lignereglement']['id']);
             $this->Facture->updateAll(array('Facture.Montant_Regler' => 'Facture.Montant_Regler -'.$ligne['Lignereglement']['Montant']), array(
                            'Facture.id' => $ligne['Lignereglement']['id_piece']
                            
                        ));    
                 
            }
        }
        foreach($pieces as $piece){
         
          $this->Piecereglement->delete($piece['Piecereglement']['id']);
                if ($piece['Piecereglement']['paiement_id'] == 2) {
                    $this->Cheque->delete($piece['Piecereglement']['id_piece']);
                }
                if ($piece['Piecereglement']['paiement_id'] == 3) {
                    $this->Traite->delete($piece['Piecereglement']['id_piece']);
                }
                 if ($piece['Piecereglement']['paiement_id'] == 5) {
                     $this->Reglement->updateAll(array('Reglement.Reste' => 'Reglement.Reste +'.$piece['Piecereglement']['Montant']), array(
                            'Reglement.id' => $piece['Piecereglement']['id_piece']
                            
                        ));
                     
                }
                if ($piece['Piecereglement']['paiement_id'] == 6) {
                     $this->Factureavoirfinancier->updateAll(array('Factureavoirfinancier.Reste' => 'Factureavoirfinancier.Reste +'.$piece['Piecereglement']['Montant']), array(
                            'Factureavoirfinancier.id' => $piece['Piecereglement']['id_piece']
                            
                        ));
                     
                }
        }
        
            $this->flash(__('Reglement deleted'), array('action' => 'index_1'));
        }
        $this->flash(__('Reglement was not deleted'), array('action' => 'index_1'));
        $this->redirect(array('action' => 'index_1'));
    }

}
