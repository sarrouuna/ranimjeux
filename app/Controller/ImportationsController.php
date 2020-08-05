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
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'importations') {
                    $facture = 1;
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Fournisseur');
        $this->loadModel('Situation');
        $this->loadModel('Exercice');
        $this->loadModel('Namesituation');
        $exercices = $this->Exercice->find('list');
        $condtransfert = 'Importation.etat =0';
        $veriff = 0;
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Importations"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Importation']);
            } else {
                $this->request->data['Importation'] = CakeSession::read('recherche');
            }
            if ($this->request->data['Importation']['verif'] == 1) {
                $condtransfert = '';
                $veriff = 1;
            }
            if ($this->request->data['Importation']['date1'] != "__/__/____") {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Importation']['date1'])));
                $cond1 = 'Importation.date >= ' . "'" . $date1 . "'";
            }

            if ($this->request->data['Importation']['date2'] != "__/__/____") {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Importation']['date2'])));
                $cond2 = 'Importation.date <= ' . "'" . $date2 . "'";
            }

            if ($this->request->data['Importation']['fournisseur_id']) {
                $fournisseurid = $this->request->data['Importation']['fournisseur_id'];
                $cond3 = 'Importation.fournisseur_id =' . $fournisseurid;
            }

            if ($this->request->data['Importation']['cloture_id'] != '') {
                $clotureid = $this->request->data['Importation']['cloture_id'];
                $cond4 = 'Importation.etat =' . $clotureid;
                $condtransfert = '';
            }
            if ($this->request->data['Importation']['namesituation_id'] != '') {
                $namesituationid = $this->request->data['Importation']['namesituation_id'];
                $cond5 = 'Situation.namesituation_id =' . $namesituationid;
            }
            if ($this->request->data['Importation']['verif'] == 1) {
                $namesituationid = '';
                $clotureid = '';
                $fournisseurid = '';
                $date2 = '';
                $date1 = '';
                $condtransfert = '';
                $veriff = 1;
                @$cond1 = '';
                @$cond2 = '';
                @$cond3 = '';
                @$cond4 = '';
                @$cond5 = '';
                $this->request->data['Importation'] = array();
            }
            //debug($clotureid);
        }
        $importations = $this->Importation->find('all', array('conditions' => array('Importation.id > ' => 0, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$condtransfert), 'recursive' => 1));

        $clotures[0] = "non cloturer";
        $clotures[1] = "cloturer";
        $fournisseurs = $this->Fournisseur->find('list');
        $namesituations = $this->Namesituation->find('list', array('recursive' => 1));
        //debug($veriff);die;
        $this->set(compact('namesituationid', 'veriff', 'namesituations', 'exercices', 'date1', 'date2', 'fournisseurid', 'utilisateurid', 'fournisseurs', 'clotureid', 'clotures', 'utilisateurs', 'importations', $this->paginate()));
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'importations') {
                    $facture = $liens['imprimer'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        //debug($this->request->query);
        if ($this->request->query['veriff'] == 0) {
            $condetat = 'Importation.etat =' . $this->request->query['veriff'];
        } else if ($this->request->query['veriff'] == 1) {
            $condetat = '';
        }
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Importation.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Importation.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Importation.fournisseur_id =' . $fournisseurid;
        }
        if ($this->request->query['clotureid']) {
            $clotureid = $this->request->query['clotureid'];
            $cond4 = 'Importation.etat =' . $clotureid;
            $condetat = '';
        }
        if ($this->request->query['namesituationid']) {
            $namesituationid = $this->request->query['namesituationid'];
            $cond5 = 'Situation.namesituation_id =' . $namesituationid;
        }

        $importations = $this->Importation->find('all', array('conditions' => array('Importation.id > ' => 0, @$condetat, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5), 'recursive' => 1));

        $this->set(compact('importations', 'namesituationid', 'date1', 'date2', 'fournisseurid', 'clotureid'));
    }

    public function imprimerview($id = null) {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'importations') {
                    $facture = $liens['imprimer'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
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
        $importation = $this->Importation->find('first', array('conditions' => array('Importation.id' => $id)));
        $devises = $this->Fournisseurdevise->find('all', array('conditions' => array('Fournisseurdevise.fournisseur_id' => $importation['Importation']['fournisseur_id'])));
        $devise = $importation['Importation']['devise_id'];
        $situation_id = $importation['Importation']['situation_id'];
        $date = date("d/m/Y", strtotime(str_replace('/', '/', $importation['Importation']['date'])));
        $piecejointes = $this->Piecejointe->find('all', array('conditions' => array('Piecejointe.importation_id' => $id)));
        $situations = $this->Situation->find('all', array('conditions' => array('Situation.importation_id' => $id)));
        $namepiecejointes = $this->Namepiecejointe->find('list');
        $namesituations = $this->Namesituation->find('list');
        $lignefactures = $this->Lignefacture->find('all', array(
            'conditions' => array('Facture.importation_id' => $id), 'recursive' => 1
        ));
        //debug($situations);
        $reglements = $this->Reglement->find('all', array('conditions' => array('Reglement.importation_id' => $id)));
        $this->set(compact('reglements', 'lignefactures', 'situation_id', 'situations', 'namesituations', 'date', 'fournisseurs', 'devises', 'devise', 'piecejointes', 'namepiecejointes'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null, $t = null) {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'importations') {
                    $facture = 1;
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
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
        $this->loadModel('Fournisseurimportation');
        $this->loadModel('Facture');
        $this->loadModel('Lignefacture');
        if ($t == 't') {
            // debug("helmi"); 
            $fournisseurimportations = $this->Fournisseurimportation->find('all', array('conditions' => array('Fournisseurimportation.importation_id' => $id)));
            //debug($fournisseurimportations);die;
            foreach ($fournisseurimportations as $i => $fournisseurimportation) {
                if (($fournisseurimportation['Fournisseurimportation']['fournisseur_id'] != "")) {
                    $numero = $this->Facture->find('all', array('fields' =>
                        array(
                            'MAX(Facture.numeroconca) as num'
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
                    $fournisseurimportation['fournisseur_id'] = $fournisseurimportation['Fournisseurimportation']['fournisseur_id'];
                    $fournisseurimportation['importation_id'] = $fournisseurimportation['Fournisseurimportation']['importation_id'];
                    $fournisseurimportation['date'] = date("Y-m-d");
                    $fournisseurimportation['utilisateur_id'] = CakeSession::read('users');
                    $fournisseurimportation['pointdevente_id'] = CakeSession::read('pointdevente');
                    $fournisseurimportation['exercice_id'] = date("Y");
                    $fournisseurimportation['numeroconca'] = $mm;
                    $fournisseurimportation['totalttc'] = $fournisseurimportation['Fournisseurimportation']['montant'];
                    $fournisseurimportation['type'] = "Service";
                    $this->Facture->create();
                    $this->Facture->save($fournisseurimportation);
                    $idfac = $this->Facture->id;
                    $this->Fournisseurimportation->updateAll(array('Fournisseurimportation.facture_id' => $idfac), array('Fournisseurimportation.id' => $fournisseurimportation['Fournisseurimportation']['id']));
                    $tabligne = array();
                    $tabligne['facture_id'] = $idfac;
                    $tabligne['designation'] = $fournisseurimportation['Fournisseurimportation']['name'];
                    $tabligne['type'] = 1;
                    $tabligne['totalttc'] = $fournisseurimportation['Fournisseurimportation']['montant'];
                    $this->Lignefacture->create();
                    $this->Lignefacture->save($tabligne);
                }
            }
            $this->Importation->updateAll(array('Importation.facturer' => 1), array('Importation.id' => $id));
        }
        $options = array('conditions' => array('Importation.' . $this->Importation->primaryKey => $id));
        $this->request->data = $this->Importation->find('first', $options);

        $fournisseurs = $this->Importation->Fournisseur->find('list');
        $importation = $this->Importation->find('first', array('conditions' => array('Importation.id' => $id)));
        $devises = $this->Fournisseurdevise->find('all', array('conditions' => array('Fournisseurdevise.fournisseur_id' => $importation['Importation']['fournisseur_id'])));
        $devise = $importation['Importation']['devise_id'];
        $situation_id = $importation['Importation']['situation_id'];
        $date = date("d/m/Y", strtotime(str_replace('/', '/', $importation['Importation']['date'])));
        $dateliv = date("d/m/Y", strtotime(str_replace('/', '/', $importation['Importation']['dateliv'])));
        $piecejointes = $this->Piecejointe->find('all', array('conditions' => array('Piecejointe.importation_id' => $id)));
        $situations = $this->Situation->find('all', array('conditions' => array('Situation.importation_id' => $id)));
        $namepiecejointes = $this->Namepiecejointe->find('list');
        $namesituations = $this->Namesituation->find('list');
        $lignefactures = $this->Lignefacture->find('all', array(
            'conditions' => array('Facture.importation_id' => $id, 'Lignefacture.type' => 0), 'recursive' => 1
        ));
        $reglements = $this->Reglement->find('all', array('conditions' => array('Reglement.importation_id' => $id)));
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
        $fournisseurimportations = $this->Fournisseurimportation->find('all', array('conditions' => array('Fournisseurimportation.importation_id' => $id), 'order' => array('Fournisseurimportation.id' => 'asc'), 'recursive' => -1));
        //debug($fournisseurimportations);die;
        $this->set(compact('fournisseurimportations', 'dateliv', 'credit', 'reglements', 'pieceregement', 'lignefactures', 'situation_id', 'situations', 'namesituations', 'date', 'fournisseurs', 'devises', 'devise', 'piecejointes', 'namepiecejointes'));
    }

    public function imprimerpiecejointe($id = null) {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'importations') {
                    $facture = $liens['imprimer'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
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
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'importations') {
                    $facture = $liens['add'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Namepiecejointe');
        $this->loadModel('Piecejointe');
        $this->loadModel('Namesituation');
        $this->loadModel('Situation');
        $this->loadModel('Situationpersonnel');
        $this->loadModel('Utilisateur');
        $this->loadModel('Fournisseurimportation');
        if ($this->request->is('post')) {
            // debug($this->request->data);die;
            $this->request->data['Importation']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Importation']['date'])));
            $this->request->data['Importation']['dateliv'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Importation']['dateliv'])));
            $Coefficientchoisi = $this->request->data['Importation']['Coefficientchoisi'];
            if ($Coefficientchoisi == 1) {
                $this->request->data['Importation']['coefficien'] = $this->request->data['Importation']['coeff'];
            }
            $this->Importation->create();
            if ($this->Importation->save($this->request->data)) {
                $id = $this->Importation->id;
                $fournisseurimportations = array();
                $fournisseurimportations[0]['fournisseur_id'] = $this->request->data['Importation']['fournisseuravis'];
                $fournisseurimportations[0]['montant'] = $this->request->data['Importation']['avis'];
                $fournisseurimportations[0]['importation_id'] = $id;
                $fournisseurimportations[0]['name'] = "Avis";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[0]);
                $fournisseurimportations[1]['fournisseur_id'] = $this->request->data['Importation']['fournisseurtransitaire'];
                $fournisseurimportations[1]['montant'] = $this->request->data['Importation']['transitaire'];
                $fournisseurimportations[1]['importation_id'] = $id;
                $fournisseurimportations[1]['name'] = "Transitaire";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[1]);
                $fournisseurimportations[2]['fournisseur_id'] = $this->request->data['Importation']['fournisseurddttva'];
                $fournisseurimportations[2]['montant'] = $this->request->data['Importation']['ddttva'];
                $fournisseurimportations[2]['importation_id'] = $id;
                $fournisseurimportations[2]['name'] = "Ddttva";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[2]);
                $fournisseurimportations[3]['fournisseur_id'] = $this->request->data['Importation']['fournisseurassurence'];
                $fournisseurimportations[3]['montant'] = $this->request->data['Importation']['assurence'];
                $fournisseurimportations[3]['importation_id'] = $id;
                $fournisseurimportations[3]['name'] = "Assurence";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[3]);
                $fournisseurimportations[4]['fournisseur_id'] = $this->request->data['Importation']['fournisseurdivers'];
                $fournisseurimportations[4]['montant'] = $this->request->data['Importation']['divers'];
                $fournisseurimportations[4]['importation_id'] = $id;
                $fournisseurimportations[4]['name'] = "Divers";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[4]);
                $fournisseurimportations[5]['fournisseur_id'] = $this->request->data['Importation']['fournisseurfraisfinancie'];
                $fournisseurimportations[5]['montant'] = $this->request->data['Importation']['fraisfinancie'];
                $fournisseurimportations[5]['importation_id'] = $id;
                $fournisseurimportations[5]['name'] = "Frais Financier";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[5]);
                $fournisseurimportations[6]['fournisseur_id'] = $this->request->data['Importation']['fournisseurmagasinage'];
                $fournisseurimportations[6]['montant'] = $this->request->data['Importation']['magasinage'];
                $fournisseurimportations[6]['importation_id'] = $id;
                $fournisseurimportations[6]['name'] = "Magasinage";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[6]);


                if (!empty($this->request->data['Piecejointe'])) {
                    foreach ($this->request->data['Piecejointe'] as $piecejointe) {
                        //debug($this->request->data);die;
                        if ($piecejointe['namepiecejointe_id'] != '') {
                            if ($piecejointe['sup'] != 1) {
                                $piecejointe['importation_id'] = $id;
                                $this->Piecejointe->create();
                                $this->Piecejointe->save($piecejointe);
                            }
                        }
                    }
                }
                if (!empty($this->request->data['Situation'])) {
                    foreach ($this->request->data['Situation'] as $s => $situation) {
                        //debug($this->request->data);die;
                        if ($situation['namesituation_id'] != '') {
                            $situation_index = $this->request->data['contactchoisi'];
                            if ($situation['supp'] != 1) {
                                $situation['datedebut'] = date("Y-m-d", strtotime(str_replace('/', '-', $situation['datedebut'])));
                                $situation['datefin'] = date("Y-m-d", strtotime(str_replace('/', '-', $situation['datefin'])));
                                $situation['importation_id'] = $id;
                                $this->Situation->create();
                                $this->Situation->save($situation);
                                $id_situation = $this->Situation->id;
                                if ($s == $situation_index) {
                                    $this->Importation->updateAll(array('Importation.situation_id' => $id_situation), array('Importation.id' => $id));
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
        $user = $this->Utilisateur->find('first', array('conditions' => array('Utilisateur.id' => CakeSession::read('users'))));
        $personnel_id = $user['Utilisateur']['personnel_id'];
        $situationpersonnels = $this->Situationpersonnel->find('all', array('conditions' => array('Situationpersonnel.personnel_id' => $personnel_id)));
        $t = '(0,';
        foreach ($situationpersonnels as $s => $st) {
            $t = $t . $st['Situationpersonnel']['namesituation_id'] . ',';
        }
        $t = $t . '0)';
        $namesituations = $this->Namesituation->find('list', array('conditions' => array('Namesituation.id in' . $t)));
        $this->set(compact('namesituations', 'fournisseurs', 'devises', 'mm', 'namepiecejointes'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'importations') {
                    $facture = $liens['edit'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Namepiecejointe');
        $this->loadModel('Piecejointe');
        $this->loadModel('Fournisseurdevise');
        $this->loadModel('Namesituation');
        $this->loadModel('Situation');
        $this->loadModel('Situationpersonnel');
        $this->loadModel('Utilisateur');
        $this->loadModel('Fournisseurimportation');
        if (!$this->Importation->exists($id)) {
            throw new NotFoundException(__('Invalid importation'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            // debug($this->request->data);die;
            $this->request->data['Importation']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Importation']['date'])));
            $this->request->data['Importation']['dateliv'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Importation']['dateliv'])));
            $Coefficientchoisi = $this->request->data['Importation']['Coefficientchoisi'];
            if ($Coefficientchoisi == 1) {
                $this->request->data['Importation']['coefficien'] = $this->request->data['Importation']['coeff'];
            }


            if ($this->Importation->save($this->request->data)) {
                $this->Fournisseurimportation->deleteAll(array('Fournisseurimportation.importation_id' => $id), false);
                $fournisseurimportations = array();
                $fournisseurimportations[0]['fournisseur_id'] = $this->request->data['Importation']['fournisseuravis'];
                $fournisseurimportations[0]['montant'] = $this->request->data['Importation']['avis'];
                $fournisseurimportations[0]['importation_id'] = $id;
                $fournisseurimportations[0]['name'] = "Avis";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[0]);
                $fournisseurimportations[1]['fournisseur_id'] = $this->request->data['Importation']['fournisseurtransitaire'];
                $fournisseurimportations[1]['montant'] = $this->request->data['Importation']['transitaire'];
                $fournisseurimportations[1]['importation_id'] = $id;
                $fournisseurimportations[1]['name'] = "Transitaire";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[1]);
                $fournisseurimportations[2]['fournisseur_id'] = $this->request->data['Importation']['fournisseurddttva'];
                $fournisseurimportations[2]['montant'] = $this->request->data['Importation']['ddttva'];
                $fournisseurimportations[2]['importation_id'] = $id;
                $fournisseurimportations[2]['name'] = "Ddttva";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[2]);
                $fournisseurimportations[3]['fournisseur_id'] = $this->request->data['Importation']['fournisseurassurence'];
                $fournisseurimportations[3]['montant'] = $this->request->data['Importation']['assurence'];
                $fournisseurimportations[3]['importation_id'] = $id;
                $fournisseurimportations[3]['name'] = "Assurence";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[3]);
                $fournisseurimportations[4]['fournisseur_id'] = $this->request->data['Importation']['fournisseurdivers'];
                $fournisseurimportations[4]['montant'] = $this->request->data['Importation']['divers'];
                $fournisseurimportations[4]['importation_id'] = $id;
                $fournisseurimportations[4]['name'] = "Divers";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[4]);
                $fournisseurimportations[5]['fournisseur_id'] = $this->request->data['Importation']['fournisseurfraisfinancie'];
                $fournisseurimportations[5]['montant'] = $this->request->data['Importation']['fraisfinancie'];
                $fournisseurimportations[5]['importation_id'] = $id;
                $fournisseurimportations[5]['name'] = "Frais Financier";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[5]);
                $fournisseurimportations[6]['fournisseur_id'] = $this->request->data['Importation']['fournisseurmagasinage'];
                $fournisseurimportations[6]['montant'] = $this->request->data['Importation']['magasinage'];
                $fournisseurimportations[6]['importation_id'] = $id;
                $fournisseurimportations[6]['name'] = "Magasinage";
                $this->Fournisseurimportation->create();
                $this->Fournisseurimportation->save($fournisseurimportations[6]);

                //debug($fournisseurimportations);die;                



                if (!empty($this->request->data['Piecejointe'])) {
                    foreach ($this->request->data['Piecejointe'] as $piecejointe) {
                        if (($piecejointe['sup'] == 1) && ($piecejointe['id'] != "")) {
                            $this->Piecejointe->deleteAll(array('Piecejointe.id' => $piecejointe['id']), false);
                        }
                        if ($piecejointe['namepiecejointe_id'] != '') {
                            if ($piecejointe['sup'] != 1) {
                                //debug($piecejointe);
                                $piecejointe['importation_id'] = $id;
                                $this->Piecejointe->create();
                                $this->Piecejointe->save($piecejointe);
                            }
                        }
                    }
                }
                if (!empty($this->request->data['Situation'])) {
                    $this->Situation->deleteAll(array('Situation.importation_id' => $id), false);
                    foreach ($this->request->data['Situation'] as $s => $situation) {
                        if ($situation['namesituation_id'] != '') {
                            $situation_index = $this->request->data['contactchoisi'];
                            if ($situation['supp'] != 1) {
                                $situation['datedebut'] = date("Y-m-d", strtotime(str_replace('/', '-', $situation['datedebut'])));
                                $situation['datefin'] = date("Y-m-d", strtotime(str_replace('/', '-', $situation['datefin'])));
                                $situation['importation_id'] = $id;
                                $this->Situation->create();
                                $this->Situation->save($situation);
                                $id_situation = $this->Situation->id;
                                if ($s == $situation_index) {
                                    $this->Importation->updateAll(array('Importation.situation_id' => $id_situation), array('Importation.id' => $id));
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
        $importation = $this->Importation->find('first', array('conditions' => array('Importation.id' => $id)));
        $devises = $this->Fournisseurdevise->find('all', array('conditions' => array('Fournisseurdevise.fournisseur_id' => $importation['Importation']['fournisseur_id'])));
        $devise = $importation['Importation']['devise_id'];
        $situation_id = $importation['Importation']['situation_id'];
        $date = date("d/m/Y", strtotime(str_replace('/', '/', $importation['Importation']['date'])));
        $dateliv = date("d/m/Y", strtotime(str_replace('/', '/', $importation['Importation']['dateliv'])));
        $piecejointes = $this->Piecejointe->find('all', array('conditions' => array('Piecejointe.importation_id' => $id)));
        $situations = $this->Situation->find('all', array('conditions' => array('Situation.importation_id' => $id)));
        $namepiecejointes = $this->Namepiecejointe->find('list');
        $user = $this->Utilisateur->find('first', array('conditions' => array('Utilisateur.id' => CakeSession::read('users'))));
        $personnel_id = $user['Utilisateur']['personnel_id'];
        $situationpersonnels = $this->Situationpersonnel->find('all', array('conditions' => array('Situationpersonnel.personnel_id' => $personnel_id)));
        $t = '(0,';
        foreach ($situationpersonnels as $s => $st) {
            $t = $t . $st['Situationpersonnel']['namesituation_id'] . ',';
        }
        $t = $t . '0)';
        $namesituations = $this->Namesituation->find('list', array('conditions' => array('Namesituation.id in' . $t)));
        $this->set(compact('dateliv', 'situation_id', 'situations', 'namesituations', 'date', 'fournisseurs', 'devises', 'devise', 'piecejointes', 'namepiecejointes'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'importations') {
                    $facture = $liens['delete'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Importation->id = $id;
        if (!$this->Importation->exists()) {
            throw new NotFoundException(__('Invalid importation'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Importation->delete()) {
            $this->Session->setFlash(__('Importation deleted'));
            CakeSession::write('view', "delete");
            //$this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Importation was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function cloture($id = null) {
        $this->Importation->id = $id;
        if (!$this->Importation->exists()) {
            throw new NotFoundException(__('Invalid importation'));
        }
        $c = 1;
        $this->Importation->updateAll(array('Importation.etat' => $c), false);
        $this->redirect(array('action' => 'index'));
    }

    public function getdevises() {

        $this->layout = null;
        // $json = null;
        $this->loadModel('Fournisseurdevise');
        $this->loadModel('Devise');
        $data = $this->request->data;
        $fournisseurid = $data['fournisseurid'];

        $devises = $this->Fournisseurdevise->find('all', array('conditions' => array('Fournisseurdevise.fournisseur_id' => $fournisseurid)));
        $select = "<select name='data[Importation][devise_id]' champ='devise_id' id='devise_id' class='form-control select ' onchange='' >";
        $select = $select . "<option value=''>" . "choix" . "</option>";
        foreach ($devises as $v) {
            $select = $select . "<option value=" . $v['Devise']['id'] . ">" . $v['Devise']['name'] . "</option>";
        }
        $select = $select . '</select>';

        $importations = $this->Importation->find('all', array('conditions' => array('Importation.fournisseur_id' => $fournisseurid), 'order' => array('Importation.id' => 'desc')));
        foreach ($importations as $i => $importation) {
            if ($i == 0) {
                $ancien_coeff = $importation['Importation']['coefficien'];
            }
        }
        if (empty($ancien_coeff)) {
            $ancien_coeff = 0;
        }
        echo json_encode(array('select' => $select, 'ancien_coeff' => $ancien_coeff));

        //echo $select;
        die();
    }

    public function getcoes() {
        $this->layout = null;
        $data = $this->request->data; //debug($data);
        $json = null;
        $importationid = $data['importationid'];
        $importation = $this->Importation->find('first', array('conditions' => array('Importation.id' => $importationid), false));
        $tr = $importation['Importation']['tauxderechenge'];
        $coe = $importation['Importation']['coefficien'];
        $prixachat = $importation['Importation']['montantachat'];
        $prixachat_tounssi = $importation['Importation']['prixachat'];
        echo json_encode(array('tr' => $tr, 'coe' => $coe, 'prixachat' => $prixachat, 'prixachat_tounssi' => $prixachat_tounssi));
        die();
    }

    public function recap() {
        $this->loadModel('Fournisseur');
        $this->layout = null;
        $data = $this->request->data;
        $fournisseurid = $data['fournisseur_id'];
        $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $fournisseurid)));
        $name = $fournisseur['Fournisseur']['name'];
        $importations = $this->Importation->find('all', array('conditions' => array('Importation.fournisseur_id' => $fournisseurid), 'order' => array('Importation.id' => 'desc')));

        $this->set(compact('importations', 'name', 'ancien_coeff'));
    }

}
