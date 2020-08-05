<?php

App::uses('AppController', 'Controller');

/**
 * Bordereaus Controller
 *
 * @property Bordereau $Bordereau
 */
class BordereausController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bordereaus') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Bordereau.pointdevente_id = ' . $p;
        }
        $bordereaus = $this->Bordereau->find('all', array('conditions' => array(@$pv,'Bordereau.type' => 1)));
        $this->set(compact('bordereaus'));
    }

    public function indexr() {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bordereaus') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Compte');
        $this->Bordereau->recursive = 0;
        $this->set('bordereaus', $this->paginate());

        $comptess = $this->Compte->find('all', array('conditions' => array('Compte.id > ' => 0)));
        foreach ($comptess as $c) {
            $comptes[$c['Compte']['id']] = $c['Compte']['banque'] . "  " . $c['Compte']['rib'];
        }

        if (isset($this->request->data) && !empty($this->request->data)) {
            // debug($this->request->data);die;
            if ($this->request->data['Bordereau']['date1'] != "__/__/____") {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date1'])));
                $cond1 = 'Bordereau.date >= ' . "'" . $date1 . "'";
            }

            if ($this->request->data['Bordereau']['date2'] != "__/__/____") {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date2'])));
                $cond2 = 'Bordereau.date <= ' . "'" . $date2 . "'";
            }

            if ($this->request->data['Bordereau']['compte_id']) {
                $compteid = $this->request->data['Bordereau']['compte_id'];
                $cond3 = 'Bordereau.factoring =' . $compteid;
            }
            if ($this->request->data['Bordereau']['numero']) {
                $numero = $this->request->data['Bordereau']['numero'];
                $cond4 = 'Bordereau.numero =' . $numero;
            }
        }
        $bordereaus = $this->Bordereau->find('all', array('conditions' => array('Bordereau.id > ' => 0, @$cond1, @$cond2, @$cond3)));
        // debug($devis);die;


        $this->set(compact('date1', 'date2', 'compteid', 'comptes', 'bordereaus'));
    }

    public function imprimerretrait() {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bordereaus') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Compte');
        $this->Bordereau->recursive = 0;
        $this->set('bordereaus', $this->paginate());

        $comptess = $this->Compte->find('all', array('conditions' => array('Compte.id > ' => 0)));
        foreach ($comptess as $c) {
            $comptes[$c['Compte']['id']] = $c['Compte']['banque'] . "  " . $c['Compte']['rib'];
        }


        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Bordereau.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Bordereau.date <= ' . "'" . $date2 . "'";
        }

        if (!empty($this->request->query['compteid'])) {
            $compteid = $this->request->query['compteid'];
            $cond3 = 'Bordereau.factoring =' . $compteid;
        }
        if (!empty($this->request->query['numero'])) {
            $numero = $this->request->query['numero'];
            $cond4 = 'Bordereau.numero =' . $numero;
        }


        $bordereaus = $this->Bordereau->find('all', array('conditions' => array('Bordereau.id > ' => 0, @$cond1, @$cond2, @$cond3)));


        $this->set(compact('date1', 'date2', 'compteid', 'comptes', 'bordereaus', $this->paginate()));
    }

    public function tabledebord() {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bordereaus') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Compte');
        $this->Bordereau->recursive = 0;
        $this->set('bordereaus', $this->paginate());

        $comptess = $this->Compte->find('all', array('conditions' => array('Compte.id > ' => 0)));
        foreach ($comptess as $c) {

            $comptes[$c['Compte']['id']] = $c['Compte']['banque'] . "  " . $c['Compte']['rib'];
        }
        $date1 = date("Y-m-d", strtotime(str_replace('/', '-', "")));
        if (isset($this->request->data) && !empty($this->request->data)) {
            // debug($this->request->data);die;
            if ($this->request->data['Bordereau']['date1'] != "__/__/____") {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date1'])));
                $cond1 = 'Bordereau.date >= ' . "'" . $date1 . "'";
            }

            if ($this->request->data['Bordereau']['date2'] != "__/__/____") {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date2'])));
                $cond2 = 'Bordereau.date <= ' . "'" . $date2 . "'";
            }

            if ($this->request->data['Bordereau']['compte_id']) {
                $compteid = $this->request->data['Bordereau']['compte_id'];
                $cond3 = 'Bordereau.factoring =' . $compteid;
            }
        }
        $bordereaus = $this->Bordereau->find('all', array('conditions' => array('Bordereau.id > ' => 0, @$cond1, @$cond2, @$cond3)));
        // debug($devis);die;


        $this->set(compact('date1', 'date2', 'compteid', 'comptes', 'bordereaus'));
    }

    public function imprimertableaudebord() {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bordereaus') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Compte');
        $this->Bordereau->recursive = 0;
        $this->set('bordereaus', $this->paginate());

        $comptess = $this->Compte->find('all', array('conditions' => array('Compte.id > ' => 0)));
        foreach ($comptess as $c) {
            $comptes[$c['Compte']['id']] = $c['Compte']['banque'] . "  " . $c['Compte']['rib'];
        }


        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Bordereau.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Bordereau.date <= ' . "'" . $date2 . "'";
        }

        if (!empty($this->request->query['compteid'])) {
            $compteid = $this->request->query['compteid'];
            $cond3 = 'Bordereau.factoring =' . $compteid;
        }
        if (!empty($this->request->query['numero'])) {
            $numero = $this->request->query['numero'];
            $cond4 = 'Bordereau.numero =' . $numero;
        }


        $bordereaus = $this->Bordereau->find('all', array('conditions' => array('Bordereau.id > ' => 0, @$cond1, @$cond2, @$cond3)));


        $this->set(compact('date1', 'date2', 'compteid', 'comptes', 'bordereaus', $this->paginate()));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bordereaus') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignebordereau');
        $this->loadModel('Reglementclient');
        $this->loadModel('Client');
        $this->loadModel('Piecereglementclient');
        if (!$this->Bordereau->exists($id)) {
            throw new NotFoundException(__('Invalid bordereau'));
        }
        $options = array('conditions' => array('Bordereau.' . $this->Bordereau->primaryKey => $id));
        $this->set('bordereau', $this->Bordereau->find('first', $options));
        $lignebordereaus = $this->Lignebordereau->find('all', array('conditions' => array('Lignebordereau.Bordereau_id' => $id), 'recursive' => -1));
        foreach ($lignebordereaus as $lb) {

            $reglementclients = $this->Reglementclient->find('all', array('conditions' => array('Reglementclient.client_id' => $lb['Lignebordereau']['client_id']), 'recursive' => -1));
            $t = '(0,';
            foreach ($reglementclients as $l) {
                $t = $t . $l['Reglementclient']['id'] . ',';
            }
            $t = $t . '0)';

            $piecereglementclientss = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id in' . $t), 'recursive' => -1));
            foreach ($piecereglementclientss as $prc) {
                if ($prc['Piecereglementclient']['paiement_id'] == 2) {
                    $piecereglementclients[$prc['Piecereglementclient']['id']] = "Chéque N° : " . $prc['Piecereglementclient']['num'];
                }
                if ($prc['Piecereglementclient']['paiement_id'] == 3) {
                    $piecereglementclients[$prc['Piecereglementclient']['id']] = "Traite N° : " . $prc['Piecereglementclient']['num'];
                }
            }
        }
        $bordereau = $this->Bordereau->find('first', array('conditions' => array('Bordereau.id' => $id), 'recursive' => -1));
        $factoring = 0;
        if (!empty($bordereau['Bordereau']['garantie'])) {
            $factoring = 1;
        }
        $clients = $this->Client->find('list');
        $this->set(compact('lignebordereaus', 'piecereglementclients', 'clients', 'factoring'));
    }

    public function viewr($id = null) {

        if (!$this->Bordereau->exists($id)) {
            throw new NotFoundException(__('Invalid bordereau'));
        }
        $options = array('conditions' => array('Bordereau.' . $this->Bordereau->primaryKey => $id));
        $this->set('bordereau', $this->Bordereau->find('first', $options));
    }

    public function imprimer($id = null) {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bordereaus') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignebordereau');
        $this->loadModel('Reglementclient');
        $this->loadModel('Client');
        $this->loadModel('Piecereglementclient');
        if (!$this->Bordereau->exists($id)) {
            throw new NotFoundException(__('Invalid bordereau'));
        }
        $options = array('conditions' => array('Bordereau.' . $this->Bordereau->primaryKey => $id));
        $this->set('bordereau', $this->Bordereau->find('first', $options));
        $lignebordereaus = $this->Lignebordereau->find('all', array('conditions' => array('Lignebordereau.Bordereau_id' => $id), 'recursive' => 0));
        foreach ($lignebordereaus as $lb) {

            $reglementclients = $this->Reglementclient->find('all', array('conditions' => array('Reglementclient.client_id' => $lb['Lignebordereau']['client_id']), 'recursive' => -1));
            $t = '(0,';
            foreach ($reglementclients as $l) {
                $t = $t . $l['Reglementclient']['id'] . ',';
            }
            $t = $t . '0)';

            $piecereglementclientss = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id in' . $t), 'recursive' => -1));
            foreach ($piecereglementclientss as $prc) {
                if ($prc['Piecereglementclient']['paiement_id'] == 2) {
                    $piecereglementclients[$prc['Piecereglementclient']['id']] = "Chéque N° : " . $prc['Piecereglementclient']['num'];
                }
                if ($prc['Piecereglementclient']['paiement_id'] == 3) {
                    $piecereglementclients[$prc['Piecereglementclient']['id']] = "Traite N° : " . $prc['Piecereglementclient']['num'];
                }
            }
        }
        $clients = $this->Client->find('list');
        $factoring = 0;
        if (!empty($bordereau['Bordereau']['garantie'])) {
            $factoring = 1;
        }
        $this->set(compact('lignebordereaus', 'piecereglementclients', 'clients', 'factoring', 'bordereau'));
    }

    public function add() {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bordereaus') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $factoring = 0;
        $this->loadModel('Paiement');
        $this->loadModel('Compte');
        $this->loadModel('Client');
        $this->loadModel('Lignebordereau');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Situationpiecereglementclient');
        $this->loadModel('Pointdevente');
        //debug($this->request->data['Bordereau']);die; 
        if (!empty($this->request->data['Bordereau']['enregistrer'])) {
            if ($this->request->data['Bordereau']['enregistrer'] == 1) {
                //debug($this->request->data);die; 
                if ($this->request->data['Bordereau']['Montant'] != '') {
                    $this->request->data['Bordereau']['Date_deb'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['Date_deb'])));
                    $this->request->data['Bordereau']['Date_fn'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['Date_fn'])));
                    $this->request->data['Bordereau']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date'])));
                    $this->request->data['Bordereau']['factoring'] = @$this->request->data['Bordereau']['comptefactoring_id'];
                    $this->request->data['Bordereau']['utilisateur_id'] = CakeSession::read('users');
                    $this->request->data['Bordereau']['etat'] = "1";
                    //debug($this->request->data);die;
                    
                    
                    $pv = CakeSession::read('pointdevente');
                    if ($pv == 0) {
                        $pv = $this->request->data['Bordereau']['pointdevente_id'];
                    }
                    $numero = $this->Bordereau->find('all', array('fields' => array('MAX(Bordereau.numeroconca) as num'),
                        'conditions' => array('Bordereau.pointdevente_id' => $pv, 'EXTRACT(YEAR FROM Bordereau.date)' => date("Y"),'Bordereau.etat'=>1))
                    );
                    //debug($numero);die;
                    foreach ($numero as $num) {
                        $n = $num[0]['num'];
                    }
                    if (!empty($n)) {

                        $lastnum = $n;
                        $nume = intval($lastnum) + 1;
                        $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
                    } else {
                        $mm = "000001";
                    }


                    $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
                    $abrivation = $pointvente['Pointdevente']['abriviation'];
                    $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
                    $this->request->data['Bordereau']['numeroconca'] = $mm;
                    $this->request->data['Bordereau']['numero'] = $numspecial;
                    
                    
                    $this->Bordereau->create();
                    if ($this->Bordereau->save($this->request->data)) {
                        $id = $this->Bordereau->id;
                        $this->misejour("Bordereau", "add", $id);
                        foreach ($this->request->data['lignebordereau'] as $lb) {
                            $situation2 = "Versé";
                            $situation1 = "Versé à escompte";
                            if (@$lb['ok'] == 1) {
                                $lb['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $lb['echance'])));
                                $lb['bordereau_id'] = $id;
                                $this->Lignebordereau->create();
                                $this->Lignebordereau->save($lb);


                                if ($this->request->data['Bordereau']['paiement_id'] == 2) {
                                    if ($this->request->data['Bordereau']['factoring'] == "") {
                                        $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' => "'" . $situation2 . "'", 'Piecereglementclient.compte_id' => $this->request->data['Bordereau']['compte_id']), array('Piecereglementclient.id' => $lb['piecereglementclient_id']));
                                        $data['piecereglementclient_id'] = $lb['piecereglementclient_id'];
                                        $data['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date'])));
                                        $data['agio'] = 0;
                                        $data['situation'] = $situation2;
                                        $data['compte_id'] = $this->request->data['Bordereau']['compte_id'];
                                        $data['utilisateur_id'] = CakeSession::read('users');
                                        $data['datemodification'] = date("Y-m-d");
                                        $this->Situationpiecereglementclient->create();
                                        $this->Situationpiecereglementclient->save($data);
                                    } else {
                                        $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' => "'" . $situation1 . "'", 'Piecereglementclient.compte_id' => $this->request->data['Bordereau']['compte_id']), array('Piecereglementclient.id' => $lb['piecereglementclient_id']));
                                        $data['piecereglementclient_id'] = $lb['piecereglementclient_id'];
                                        $data['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date'])));
                                        $data['agio'] = 0;
                                        $data['situation'] = $situation1;
                                        $data['compte_id'] = $this->request->data['Bordereau']['compte_id'];
                                        $data['utilisateur_id'] = CakeSession::read('users');
                                        $data['datemodification'] = date("Y-m-d");
                                        $this->Situationpiecereglementclient->create();
                                        $this->Situationpiecereglementclient->save($data);
                                    }
                                } else {
                                    if ($this->request->data['Bordereau']['factoring'] == "") {
                                        $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' => "'" . $this->request->data['Bordereau']['situation'] . "'", 'Piecereglementclient.compte_id' => $this->request->data['Bordereau']['compte_id']), array('Piecereglementclient.id' => $lb['piecereglementclient_id']));
                                        $data['piecereglementclient_id'] = $lb['piecereglementclient_id'];
                                        $data['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date'])));
                                        $data['agio'] = 0;
                                        $data['situation'] = $this->request->data['Bordereau']['situation'];
                                        $data['compte_id'] = $this->request->data['Bordereau']['compte_id'];
                                        $data['utilisateur_id'] = CakeSession::read('users');
                                        $data['datemodification'] = date("Y-m-d");
                                        $this->Situationpiecereglementclient->create();
                                        $this->Situationpiecereglementclient->save($data);
                                    } else {
                                        $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' => "'" . $situation1 . "'", 'Piecereglementclient.compte_id' => $this->request->data['Bordereau']['compte_id']), array('Piecereglementclient.id' => $lb['piecereglementclient_id']));
                                        $data['piecereglementclient_id'] = $lb['piecereglementclient_id'];
                                        $data['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date'])));
                                        $data['agio'] = 0;
                                        $data['situation'] = $this->request->data['Bordereau']['situation'];
                                        $data['compte_id'] = $this->request->data['Bordereau']['compte_id'];
                                        $data['utilisateur_id'] = CakeSession::read('users');
                                        $data['datemodification'] = date("Y-m-d");
                                        $this->Situationpiecereglementclient->create();
                                        $this->Situationpiecereglementclient->save($data);
                                    }
                                }
                            }
                        }

                        $this->Session->setFlash(__('The bordereau has been saved'));
                        $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Session->setFlash(__('The bordereau could not be saved. Please, try again.'));
                    }
                }
            }
        }
        //debug($this->request->data);
        if (!empty($this->request->data['Bordereau'])) {
            if ($this->request->data['Bordereau']['recherche'] == 1) { //debug($this->request->data);die;
                if ($this->request->data['Bordereau']['Date_deb'] != '__/__/____') {
                    $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['Date_deb'])));
                    $cond = 'Piecereglementclient.echance >=' . "'" . $Date_debut . "'";
                }
                if ($this->request->data['Bordereau']['Date_fn'] != '__/__/____') {
                    $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['Date_fn'])));
                    $cond1 = 'Piecereglementclient.echance <=' . "'" . $Date_fin . "'";
                }
                if ($this->request->data['Bordereau']['compte_id']) {
                    $compte_id = $this->request->data['Bordereau']['compte_id'];
                    $cond2 = "Piecereglementclient.compte_id='" . $compte_id . "'";
                    $compte = $this->Compte->find('first', array('conditions' => array('Compte.id' => $compte_id))); //debug($compte);die;
                    if ($compte['Compte']['typecompte_id'] == 2) {
                        $comptefactoring = $compte['Compte']['banque'] . ' ' . $compte['Compte']['rib'];
                        $comptefactoringid = $compte['Compte']['id'];
                        $factoring = 1;
                        $condcompte = "Compte.typecompte_id='" . $factoring . "'";
                    }
                }
                $st = "En attente";
                $conditionst = 'Piecereglementclient.situation=' . "'" . $st . "'";
                $paiementid = $this->request->data['Bordereau']['paiement_id'];
                $conditionpid = 'Piecereglementclient.paiement_id=' . $this->request->data['Bordereau']['paiement_id'];
                //debug($conditionpid);die;
                $cheques = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.id > ' => 0, @$cond, @$cond1, $conditionpid, $conditionst))); //debug($piecereglements);
                //debug($cheques);die;
            }
        }
        $comptess = $this->Compte->find('all', array('conditions' => array('Compte.id > ' => 0, @$condcompte)));
        foreach ($comptess as $c) {
            $comptes[$c['Compte']['id']] = $c['Compte']['banque'] . "  " . $c['Compte']['rib'];
        }
        
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id > ' => 1, 'Paiement.id < ' => 4)));
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.societe'=>$composantsoc)
        ));

        $this->set(compact('pointdeventes','compte_id', 'paiementid', 'comptes', 'comptebs', 'clients', 'mm', 'cheques', 'paiements', 'factoring', 'comptefactoring', 'comptefactoringid'));
    }

    public function addr() {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bordereaus') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Compte');
        $this->loadModel('Versement');
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Bordereau']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date'])));
            $compte = $this->Compte->find('first', array('conditions' => array('Compte.id' => $this->request->data['Bordereau']['compte_id']), false));
            $type = $compte['Compte']['typecompte_id'];

            if ($type == 2) {
                $this->request->data['Bordereau']['factoring'] = $this->request->data['Bordereau']['compte_id'];
            } else {
                $this->request->data['Bordereau']['compteversement'] = 0;
            }
            $this->request->data['Bordereau']['type'] = 2;
            $this->request->data['Bordereau']['utilisateur_id'] = CakeSession::read('users');

            $this->Bordereau->create();
            if ($this->Bordereau->save($this->request->data)) {
                $id = $this->Bordereau->id;
                $this->misejour("Retrait", "add", $id);
                if (!empty($this->request->data['Bordereau']['compteversement'])) {
                    $numero = $this->Versement->find('all', array('fields' =>
                        array(
                            'MAX(Versement.numero) as num'
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
                    $dataversement = array();
                    $dataversement['utilisateur_id'] = CakeSession::read('users');
                    $dataversement['compte_id'] = $this->request->data['Bordereau']['compteversement'];
                    $dataversement['numero'] = $mm;
                    $dataversement['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date'])));
                    $dataversement['montant'] = $this->request->data['Bordereau']['montantverse'];
                    $this->Versement->create();
                    $this->Versement->save($dataversement);
                }
                $this->Session->setFlash(__('The bordereau has been saved'));
                $this->redirect(array('action' => 'indexr'));
            } else {
                $this->Session->setFlash(__('The bordereau could not be saved. Please, try again.'));
            }
        }

        $comptess = $this->Compte->find('all', array('conditions' => array('Compte.id > ' => 0)));
        foreach ($comptess as $c) {
            $comptes[$c['Compte']['id']] = $c['Compte']['banque'] . "  " . $c['Compte']['rib'];
        }
        $numero = $this->Bordereau->find('all', array('fields' =>
            array(
                'MAX(Bordereau.numero) as num'
            ), 'conditions' => array('Bordereau.type' => 2)));
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
        $this->set(compact('comptes', 'mm'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bordereaus') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Paiement');
        $this->loadModel('Compte');
        $this->loadModel('Client');
        $this->loadModel('Lignebordereau');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Reglementclient');
        $this->loadModel('Situationpiecereglementclient');
        if (!$this->Bordereau->exists($id)) {
            throw new NotFoundException(__('Invalid bordereau'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Bordereau']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date'])));
            $this->request->data['Bordereau']['factoring'] = @$this->request->data['Bordereau']['comptefactoring_id'];
            $this->request->data['Bordereau']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Bordereau']['etat'] = "1";
            $lignebordereaus = $this->Lignebordereau->find('all', array('conditions' => array('Lignebordereau.Bordereau_id' => $id), 'recursive' => -1));
            foreach ($lignebordereaus as $lb) {
                $st = "En attente";
                $comp = "";
                $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' => "'" . $st . "'", 'Piecereglementclient.compte_id' => 0), array('Piecereglementclient.id' => $lb['Lignebordereau']['piecereglementclient_id']));
            }
            $this->Lignebordereau->deleteAll(array('Lignebordereau.bordereau_id' => $id), false);

            if ($this->Bordereau->save($this->request->data)) {
                $this->misejour("Bordereau", "edit", $id);
                foreach ($this->request->data['lignebordereau'] as $lb) {
                    $situation2 = "Versé";
                    $situation1 = "Escompté";
                    if (@$lb['ok'] == 1) {
                        $lb['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $lb['echance'])));
                        $lb['bordereau_id'] = $id;
                        $this->Lignebordereau->create();
                        $this->Lignebordereau->save($lb);
                        if ($this->request->data['Bordereau']['paiement_id'] == 2) {
                            if ($this->request->data['Bordereau']['factoring'] == "") {
                                $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' => "'" . $situation2 . "'", 'Piecereglementclient.compte_id' => $this->request->data['Bordereau']['compte_id']), array('Piecereglementclient.id' => $lb['piecereglementclient_id']));
                                $data['piecereglementclient_id'] = $lb['piecereglementclient_id'];
                                $data['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date'])));
                                $data['agio'] = 0;
                                $data['situation'] = $situation2;
                                $data['compte_id'] = $this->request->data['Bordereau']['compte_id'];
                                $data['utilisateur_id'] = CakeSession::read('users');
                                $data['datemodification'] = date("Y-m-d");
                                $data['id'] = '';
                                $situationfrs = $this->Situationpiecereglementclient->find('first', array('conditions' => array('Situationpiecereglementclient.piecereglementclient_id' => $data['piecereglementclient_id'], 'Situationpiecereglementclient.piecereglementclient_id' => $data['situation'])));
                                if (!empty($situationfrs)) {
                                    $data['id'] = $situationfrs['Situationpiecereglementclient']['id'];
                                }
                                $this->Situationpiecereglementclient->create();
                                $this->Situationpiecereglementclient->save($data);
                            } else {
                                $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' => "'" . $situation1 . "'", 'Piecereglementclient.compte_id' => $this->request->data['Bordereau']['compte_id']), array('Piecereglementclient.id' => $lb['piecereglementclient_id']));
                                $data['piecereglementclient_id'] = $lb['piecereglementclient_id'];
                                $data['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date'])));
                                $data['agio'] = 0;
                                $data['situation'] = $situation1;
                                $data['compte_id'] = $this->request->data['Bordereau']['compte_id'];
                                $data['utilisateur_id'] = CakeSession::read('users');
                                $data['datemodification'] = date("Y-m-d");
                                $data['id'] = '';
                                $situationfrs = $this->Situationpiecereglementclient->find('first', array('conditions' => array('Situationpiecereglementclient.piecereglementclient_id' => $data['piecereglementclient_id'], 'Situationpiecereglementclient.piecereglementclient_id' => $data['situation'])));
                                if (!empty($situationfrs)) {
                                    $data['id'] = $situationfrs['Situationpiecereglementclient']['id'];
                                }
                                $this->Situationpiecereglementclient->create();
                                $this->Situationpiecereglementclient->save($data);
                            }
                        } else {
                            $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' => "'" . $this->request->data['Bordereau']['situation'] . "'", 'Piecereglementclient.compte_id' => $this->request->data['Bordereau']['compte_id']), array('Piecereglementclient.id' => $lb['piecereglementclient_id']));
                            $data['piecereglementclient_id'] = $lb['piecereglementclient_id'];
                            $data['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date'])));
                            $data['agio'] = 0;
                            $data['situation'] = $this->request->data['Bordereau']['situation'];
                            $data['compte_id'] = $this->request->data['Bordereau']['compte_id'];
                            $data['utilisateur_id'] = CakeSession::read('users');
                            $data['datemodification'] = date("Y-m-d");
                            $data['id'] = '';
                            $situationfrs = $this->Situationpiecereglementclient->find('first', array('conditions' => array('Situationpiecereglementclient.piecereglementclient_id' => $data['piecereglementclient_id'], 'Situationpiecereglementclient.piecereglementclient_id' => $data['situation'])));
                            if (!empty($situationfrs)) {
                                $data['id'] = $situationfrs['Situationpiecereglementclient']['id'];
                            }
                            $this->Situationpiecereglementclient->create();
                            $this->Situationpiecereglementclient->save($data);
                        }
                    }
                }
                $this->Session->setFlash(__('The bordereau has been saved'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $options = array('conditions' => array('Bordereau.' . $this->Bordereau->primaryKey => $id));
            $this->request->data = $this->Bordereau->find('first', $options);
        }

        foreach ($this->request->data['Lignebordereau'] as $i => $lb) {
            $piece = '(0,';
            foreach ($this->request->data['Lignebordereau'] as $l) {
                $piece = $piece . $l['piecereglementclient_id'] . ',';
            }
            $piece = $piece . '0)';
            $reglementclients = $this->Reglementclient->find('all', array('conditions' => array('Reglementclient.client_id' => $lb['client_id']), 'recursive' => -1));
            $t = '(0,';
            foreach ($reglementclients as $l) {
                $t = $t . $l['Reglementclient']['id'] . ',';
            }
            $t = $t . '0)';
            $piecereglementclientss = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id in' . $t), 'recursive' => -1));
            foreach ($piecereglementclientss as $prc) {
                if ($prc['Piecereglementclient']['paiement_id'] == 2) {
                    $piecereglementclients[$i][$prc['Piecereglementclient']['id']] = "Chéque N° : " . $prc['Piecereglementclient']['num'];
                }
                if ($prc['Piecereglementclient']['paiement_id'] == 3) {
                    $piecereglementclients[$i][$prc['Piecereglementclient']['id']] = "Traite N° : " . $prc['Piecereglementclient']['num'];
                }
            }
        }
        //debug($this->request->data['Bordereau']);
        if ($this->request->data['Bordereau']['Date_deb'] != '__/__/____') {
            $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['Date_deb'])));
            $cond = 'Piecereglementclient.echance >=' . "'" . $Date_debut . "'";
            //debug($this->request->data['Bordereau']['Date_deb']);
            //debug($Date_debut);
        }

        if ($this->request->data['Bordereau']['Date_fn'] != '__/__/____') {
            $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['Date_fn'])));
            $cond1 = 'Piecereglementclient.echance <=' . "'" . $Date_fin . "'";
        }

        if ($this->request->data['Bordereau']['compte_id']) {
            $compte_id = $this->request->data['Bordereau']['compte_id'];
            $cond2 = "Piecereglementclient.compte_id='" . $compte_id . "'";
            $compte = $this->Compte->find('first', array('conditions' => array('Compte.id' => $compte_id))); //debug($compte);die;
            if ($compte['Compte']['typecompte_id'] == 2) {
                $comptefactoring = $compte['Compte']['banque'] . ' ' . $compte['Compte']['rib'];
                $comptefactoringid = $compte['Compte']['id'];
                $factoring = 1;
                $condcompte = "Compte.typecompte_id='" . $factoring . "'";
            }
        }
        $st = "En attente";
        $conditionst = 'Piecereglementclient.situation=' . "'" . $st . "'";
        $paiementid = $this->request->data['Bordereau']['paiement_id'];
        $conditionpid = 'Piecereglementclient.paiement_id=' . $this->request->data['Bordereau']['paiement_id'];
        //debug(@$cond);
        //debug(@$cond1);
        //debug(@$conditionpid);
        //debug(@$conditionpid);die;
        $cheques = $this->Piecereglementclient->find('all', array('conditions' => array('(Piecereglementclient.id in' . $piece . ') or (' . @$cond, @$cond1, @$conditionpid, @$conditionpid, @$conditionst . ')'))); //debug($piecereglements);
        //debug($cheques);die;


        $lignebordereaus = $this->Lignebordereau->find('all', array('conditions' => array('Lignebordereau.Bordereau_id' => $id), 'recursive' => -1));
        $bordereau = $this->Bordereau->find('first', array('conditions' => array('Bordereau.id' => $id), 'recursive' => -1));
        $factoring = 0;
        if (!empty($bordereau['Bordereau']['garantie'])) {
            $factoring = 1;
        }
        $comptess = $this->Compte->find('all');
        foreach ($comptess as $c) {
            if ($c['Compte']['typecompte_id'] == 1) {
                $comptes[$c['Compte']['id']] = $c['Compte']['banque'] . "  " . $c['Compte']['rib'];
            } else {
                $factorings[$c['Compte']['id']] = $c['Compte']['banque'] . "  " . $c['Compte']['rib'];
            }
        }
        $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id > ' => 1, 'Paiement.id < ' => 4)));
        $clients = $this->Client->find('list');
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Bordereau']['date'])));

        $this->set(compact('cheques', 'comptes', 'factorings', 'clients', 'date', 'lignebordereaus', 'piecereglementclients', 'factoring', 'paiements'));
    }

    public function editr($id = null) {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bordereaus') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Compte');

        if (!$this->Bordereau->exists($id)) {
            throw new NotFoundException(__('Invalid bordereau'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            // debug($this->request->data);die;
            $this->request->data['Bordereau']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date'])));
            $this->request->data['Bordereau']['utilisateur_id'] = CakeSession::read('users');

            if ($this->Bordereau->save($this->request->data)) {
                $this->misejour("Retrait", "edit", $id);
                $this->Session->setFlash(__('The bordereau has been saved'));
                $this->redirect(array('action' => 'indexr'));
            } else {
                $this->Session->setFlash(__('The bordereau could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Bordereau.' . $this->Bordereau->primaryKey => $id));
            $this->request->data = $this->Bordereau->find('first', $options);
        }


        $comptess = $this->Compte->find('all');
        foreach ($comptess as $c) {
            $comptes[$c['Compte']['id']] = $c['Compte']['banque'] . "  " . $c['Compte']['rib'];
        }
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Bordereau']['date'])));
        $this->set(compact('comptes', 'date'));
    }

    public function valider($id = null) {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bordereaus') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Paiement');
        $this->loadModel('Compte');
        $this->loadModel('Client');
        $this->loadModel('Lignebordereau');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Reglementclient');

        if (!$this->Bordereau->exists($id)) {
            throw new NotFoundException(__('Invalid bordereau'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);die;
            $this->request->data['Bordereau']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bordereau']['date'])));
            $this->request->data['Bordereau']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Bordereau']['etat'] = 1;

            if ($this->Bordereau->save($this->request->data)) {
                foreach ($this->request->data['lignebordereau'] as $lb) {//debug($lb); die;
                    if (isset($lb['etat'])) {
                        $lb['bordereau_id'] = $id;
                        $this->Lignebordereau->save($lb);
                    }
                    $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' => "'" . $lb['Piecereglementclient']['situation'] . "'"), array('Piecereglementclient.id' => $lb['id']));
                }
                $this->Session->setFlash(__('The bordereau has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The bordereau could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Bordereau.' . $this->Bordereau->primaryKey => $id));
            $this->request->data = $this->Bordereau->find('first', $options);
        }

        foreach ($this->request->data['Lignebordereau'] as $i => $lb) {

            $reglementclients = $this->Reglementclient->find('all', array('conditions' => array('Reglementclient.client_id' => $lb['client_id']), 'recursive' => -1));
            $t = '(0,';
            foreach ($reglementclients as $l) {
                $t = $t . $l['Reglementclient']['id'] . ',';
            }
            $t = $t . '0)';

            $piecereglementclientss = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id in' . $t), 'recursive' => -1));
            //debug($piecereglementclientss);die;
            foreach ($piecereglementclientss as $prc) {
                if ($prc['Piecereglementclient']['paiement_id'] == 2) {
                    $piecereglementclients[$i][$prc['Piecereglementclient']['id']] = "Chéque N° : " . $prc['Piecereglementclient']['num'];
                }
                if ($prc['Piecereglementclient']['paiement_id'] == 3) {
                    $piecereglementclients[$i][$prc['Piecereglementclient']['id']] = "Traite N° : " . $prc['Piecereglementclient']['num'];
                }
            } //debug($piecereglementclients);die;
        } //debug($piecereglementclients);die;
        $lignebordereaus = $this->Lignebordereau->find('all', array('conditions' => array('Lignebordereau.Bordereau_id' => $id), 'recursive' => 1));
        $bordereau = $this->Bordereau->find('first', array('conditions' => array('Bordereau.id' => $id), 'recursive' => -1));
        $factoring = 0;
        if (!empty($bordereau['Bordereau']['garantie'])) {
            $factoring = 1;
        }

        $comptess = $this->Compte->find('all');
        foreach ($comptess as $c) {
            if ($c['Compte']['typecompte_id'] == 1) {
                $comptes[$c['Compte']['id']] = $c['Compte']['banque'] . "  " . $c['Compte']['rib'];
            } else {
                $factorings[$c['Compte']['id']] = $c['Compte']['banque'] . "  " . $c['Compte']['rib'];
            }
        }
        $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id > ' => 1, 'Paiement.id < ' => 4)));
        $clients = $this->Client->find('list');
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Bordereau']['date'])));
        $this->set(compact('comptes', 'clients', 'date', 'lignebordereaus', 'piecereglementclients', 'factoring', 'factorings', 'paiements'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bordereaus') {
                    $x = $liens['delete'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignebordereau');
        $this->loadModel('Piecereglementclient');
        $this->Bordereau->id = $id;
        if (!$this->Bordereau->exists()) {
            throw new NotFoundException(__('Invalid bordereau'));
        }
        $this->request->onlyAllow('post', 'delete');
        $lignebordereaus = $this->Lignebordereau->find('all', array('conditions' => array('Lignebordereau.Bordereau_id' => $id), 'recursive' => -1));
        foreach ($lignebordereaus as $lb) {
            $st = "En attente";
            $comp = "";
            $this->Piecereglementclient->updateAll(array('Piecereglementclient.situation' => "'" . $st . "'", 'Piecereglementclient.compte_id' => 0), array('Piecereglementclient.id' => $lb['Lignebordereau']['piecereglementclient_id']));
        }
        $this->Lignebordereau->deleteAll(array('Lignebordereau.bordereau_id' => $id), false);
        $cebordereau = $this->Bordereau->find('first', array('conditions' => array('Bordereau.id' => $id), 'recursive' => -1));
        $typeb=$cebordereau['Bordereau']['type'];
        $numansar=$cebordereau['Bordereau']['numero'];
        if ($this->Bordereau->delete()) {
            if($typeb==2){
                 $this->misejour("Retrait", $numansar, $id);
            }
            if($typeb==1){
                 $this->misejour("Bordereau", $numansar, $id);
            }
           
            $this->Session->setFlash(__('Bordereau deleted'));
            if($typeb==1){
            $this->redirect(array('action' => 'index'));
            }
            if($typeb==2){
            $this->redirect(array('action' => 'indexr'));
            }
        }
        $this->Session->setFlash(__('Bordereau was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    //********************fonctions ajax*********************************       

    public function piecesclient() {
        $this->layout = null;
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Reglementclient');
        $data = $this->request->data;

        $clientid = $data['id'];
        $index = $data['index'];
        $name = 'piecereglementclient_id';
        $reglementclients = $this->Reglementclient->find('all', array('conditions' => array('Reglementclient.client_id' => $clientid), 'recursive' => -1));
        $t = '(0,';
        foreach ($reglementclients as $l) {
            $t = $t . $l['Reglementclient']['id'] . ',';
        }
        $t = $t . '0)';
        $id = 'piecereglementclient_id' . $index;
        $paiement;
        if ($clientid != 0) {
            $piecereglementclients = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id in' . $t), 'recursive' => -1));
            $select = "<select   name='data[lignebordereau][$index][piecereglementclient_id]' id='$id' table='Articlefournisseur' index='$index' champ='piecereglementclient_id0' id='piecereglementclient_id0' class='select form-control'  onchange='getpiece(" . $index . ")'><option selected disabled hidden value=0> Veuillez choisir</option>";
            foreach ($piecereglementclients as $p) {
                if ($p['Piecereglementclient']['paiement_id'] < 4 && $p['Piecereglementclient']['paiement_id'] > 1) {
                    if ($p['Piecereglementclient']['paiement_id'] == 2) {
                        $paiement = "Chèque";
                    } else {
                        $paiement = "Traite";
                    }
                    $select = $select . "<option value=" . $p['Piecereglementclient']['id'] . ">" . $paiement . " N° : " . $p['Piecereglementclient']['num'] . "</option>";
                }
            }
            $select = $select . '</select>';
        }
        echo $select;
        die();
    }

    public function getpiece() {
        $this->layout = null;
        $this->loadModel('Piecereglementclient');
        $data = $this->request->data;
        $json = null;
        $piecereglementclient_id = $data['id'];

        $piece = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.id' => $piecereglementclient_id), false));
        //debug($prixaf);die;
        $banque = $piece['Piecereglementclient']['banque'];
        $montant = $piece['Piecereglementclient']['montant'];
        echo json_encode(array('banque' => $banque, 'montant' => $montant));
        die();
    }

    public function compte() {
        $this->layout = null;
        $this->loadModel('Compte');
        $this->loadModel('Bordereau');
        $data = $this->request->data;
        $compte_id = $data['compte_id'];

        $compte = $this->Compte->find('first', array('conditions' => array('Compte.id' => $compte_id), false));
        $type = $compte['Compte']['typecompte_id'];
        $solde = $compte['Compte']['solde'];

        if ($type == 2) {
            $bordereaus = $this->Bordereau->find('all', array('conditions' => array('Bordereau.factoring' => $compte_id), false));
            foreach ($bordereaus as $bordereau) {
                if ($bordereau['Bordereau']['type'] == 1) {
                    $solde = $solde + $bordereau['Bordereau']['garantie'];
                } else {
                    $solde = $solde - $bordereau['Bordereau']['montantverse'];
                }
            }
            if ($solde == 0) {
                $solde = 0.000;
            }
            $comptes = $this->Compte->find('all');
            $select = "<label class='col-md-2 control-label'>Compte de versement</label><div class='col-sm-10'><select name='data[Bordereau][compteversement]' champ='compte_id' id='compte_id11' class='from-control' >";
            $select = $select . "<option value=''>" . "choix" . "</option>";
            foreach ($comptes as $v) {
                if ($v['Compte']['typecompte_id'] != 2) {
                    $select = $select . "<option value=" . $v['Compte']['id'] . ">" . $v['Compte']['banque'] . " " . $v['Compte']['rib'] . "</option>";
                }
            }
            $select = $select . '</select></div>';
        }
        echo json_encode(array('solde' => $solde, 'select' => $select));
        die();
    }

    public function indexpc() {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'piecereglementclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Client');
        $this->loadModel('Compte');
        $this->loadModel('Paiement');
        $clients = $this->Client->find('list');
        $comptes = $this->Compte->find('all');
        $piecereglementclients = array();
        $recherche = 0;
        $zero = 0;
        $cond0 = "Piecereglementclient.reglement='" . $zero . "'";
        if ($this->request->is('post') || $this->request->is('put')) {
            $cond = '';
            $cond1 = '';
            $cond2 = '';
            $cond3 = '';
            $cond4 = '';
            $cond5 = '';
            $cond6 = '';
            $cond7 = '';

            // debug($this->request->data);die;
            if ($this->request->data['Piecereglementclient']['Date_debut'] != '__/__/____') {
                $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Piecereglementclient']['Date_debut'])));
                $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
            }
            if ($this->request->data['Piecereglementclient']['Date_fin'] != '__/__/____') {
                $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Piecereglementclient']['Date_fin'])));
                $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
            }
            if ($this->request->data['Piecereglementclient']['Date_deb'] != '__/__/____') {
                $Date_deb = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Piecereglementclient']['Date_deb'])));
                $cond2 = 'Piecereglementclient.echance>=' . "'" . $Date_deb . "'";
            }
            if ($this->request->data['Piecereglementclient']['Date_fn'] != '__/__/____') {
                $Date_fn = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Piecereglementclient']['Date_fn'])));
                $cond3 = 'Piecereglementclient.echance<=' . "'" . $Date_fn . "'";
            }
            if ($this->request->data['Piecereglementclient']['client_id']) {
                $client_id = $this->request->data['Piecereglementclient']['client_id'];
                $cond4 = 'Reglementclient.client_id=' . $client_id;
            }
            $s = "En attente";
            //$condst="Piecereglementclient.situation='".$s."'";  
            if ($this->request->data['Piecereglementclient']['situation']) {
                $situation = $this->request->data['Piecereglementclient']['situation'];
                $cond6 = "Piecereglementclient.situation='" . $situation . "'";
                $condst = "";
            }
            if ($this->request->data['Piecereglementclient']['compte_id']) {
                $compte_id = $this->request->data['Piecereglementclient']['compte_id'];
                $cond7 = "Piecereglementclient.compte_id='" . $compte_id . "'";
            }
            if ($this->request->data['Piecereglementclient']['paiement_id']) {
                $paiement_id = $this->request->data['Piecereglementclient']['paiement_id'];
                $cond8 = "Piecereglementclient.paiement_id='" . $paiement_id . "'";
            }
            
            if ($this->request->data['Piecereglementclient']['numero']) {
                $numero = $this->request->data['Piecereglementclient']['numero'];
                $cond9 = "Piecereglementclient.num LIKE '%" . $numero . "%'";
            }
            
            if ($this->request->data['Piecereglementclient']['montant']) {
                $montant = $this->request->data['Piecereglementclient']['montant'];
                $cond10 = "Piecereglementclient.montant LIKE '%" . $montant . "%'";
            }
            
            
            $recherche = 1;
            $piecereglementclients = $this->Piecereglementclient->find('all', array('contain' => array('Reglementclient', 'Paiement.name','Client.name'),'order' => array('Piecereglementclient.echance' => 'ASC')
                , 'conditions' => array(@$condst, @$cond0, @$cond, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6, @$cond7, @$cond8, @$cond9, @$cond10), 'recursive' => 0));
        }
        $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id in (1,2,3,4)')));
        $this->set(compact('montant','numero','recherche', 'paiement_id', 'piecereglementclients', 'paiements', 'clients', 'comptes', 'Date_debut', 'Date_fin', 'Date_deb', 'Date_fn', 'client_id', 'num_recu', 'situation', 'compte_id'));
    }

    public function imprimerindexpc() {

        $this->loadModel('Piecereglementclient');
        $this->loadModel('Client');
        $this->loadModel('Compte');
        $this->loadModel('Paiement');

        //debug($this->request->query);


        $piecereglementclients = array();
        if (!empty($this->request->query['Date_debut'])) {
            $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_debut'])));
            $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
        }
        if (!empty($this->request->query['Date_fin'])) {
            $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_fin'])));
            $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
        }
        if (!empty($this->request->query['Date_deb'])) {
            $Date_deb = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_deb'])));
            $cond2 = 'Piecereglementclient.echance>=' . "'" . $Date_deb . "'";
        }
        if (!empty($this->request->query['Date_fn'])) {
            $Date_fn = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_fn'])));
            $cond3 = 'Piecereglementclient.echance<=' . "'" . $Date_fn . "'";
        }
        if (!empty($this->request->query['client_id'])) {
            $client_id = $this->request->query['client_id'];
            $cond4 = 'Reglementclient.client_id=' . $client_id;
        }
        if (!empty($this->request->query['situation'])) {
            $situation = $this->request->query['situation'];
            $cond6 = "Piecereglementclient.situation='" . $situation . "'";
        }
        if (!empty($this->request->query['compte_id'])) {
            $compte_id = $this->request->query['compte_id'];
            $cond7 = "Piecereglementclient.compte_id='" . $compte_id . "'";
        }
        if (!empty($this->request->query['paiement_id'])) {
            $paiement_id = $this->request->query['paiement_id'];
            $cond8 = "Piecereglementclient.paiement_id='" . $paiement_id . "'";
        }
        if (!empty($this->request->query['numero'])) {
                $numero = $this->request->query['numero'];
                $cond9 = "Piecereglementclient.num LIKE '%" . $numero . "%'";
            }
            
        if (!empty($this->request->query['montant'])) {
            $montant = $this->request->query['montant'];
            $cond10 = "Piecereglementclient.montant LIKE '%" . $montant . "%'";
        }


        $piecereglementclients = $this->Piecereglementclient->find('all', array('order' => array('Piecereglementclient.echance' => 'ASC')
            , 'conditions' => array('Piecereglementclient.id > ' => 0, @$cond, @$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, @$cond8, @$cond9, @$cond10), 'recursive' => 0));
        //debug($piecereglements);die;
        $clients = $this->Client->find('list');
        $comptes = $this->Compte->find('list');
        $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id in (1,2,3,4)')));
        $this->set(compact('montant','numero','recherche', 'paiement_id', 'piecereglementclients', 'paiements', 'clients', 'comptes', 'Date_debut', 'Date_fin', 'Date_deb', 'Date_fn', 'client_id', 'num_recu', 'situation', 'compte_id'));
    }

    public function indexpf() {
        $lien = CakeSession::read('lien_achat');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'piecereglements') {
                    $vente = 1;
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel('Etatpiecereglement');
        $this->loadModel('Exercice');
        $this->loadModel('Piecereglement');
        $this->loadModel('Compte');
        $this->loadModel('Paiement');
        $this->loadModel('Nacionalitefournisseur');
        $recherche = 0;
        $exercices = $this->Exercice->find('list');
        $piecereglements = array();
        if (isset($this->request->data) && !empty($this->request->data)) {

            //debug($this->request->data);

            $condpaye = "Piecereglement.situation <> 'Payé'";
            if ($this->request->data['Piecereglement']['Date_debut'] != '__/__/____') {
                $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Piecereglement']['Date_debut'])));
                $cond = 'Reglement.Date>=' . "'" . $Date_debut . "'";
            }
            if ($this->request->data['Piecereglement']['Date_fin'] != '__/__/____') {
                $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Piecereglement']['Date_fin'])));
                $cond1 = 'Reglement.Date<=' . "'" . $Date_fin . "'";
            }
            if ($this->request->data['Piecereglement']['Date_deb'] != '__/__/____') {
                $Date_deb = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Piecereglement']['Date_deb'])));
                $cond2 = 'Piecereglement.echance>=' . "'" . $Date_deb . "'";
            }
            if ($this->request->data['Piecereglement']['Date_fn'] != '__/__/____') {
                $Date_fn = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Piecereglement']['Date_fn'])));
                $cond3 = 'Piecereglement.echance<=' . "'" . $Date_fn . "'";
            }


            if ($this->request->data['Piecereglement']['fournisseur_id']) {
                $fournisseur_id = $this->request->data['Piecereglement']['fournisseur_id'];
                $cond4 = 'Reglement.fournisseur_id=' . $fournisseur_id;
            }


            if ($this->request->data['Piecereglement']['etatpiecereglement_id']) {
                $situation = $this->request->data['Piecereglement']['etatpiecereglement_id'];
                $t = '("0"';
                foreach ($situation as $ad) {
                    $t = $t . ',"' . $ad . '"';
                }
                $t = $t . ')';
                //debug($t);die;

                $cond6 = "Piecereglement.situation in" . $t;
                $tt = '/0/';
                foreach ($situation as $ad) {
                    $tt = $tt . ',/' . $ad . '/';
                }
                $tt = $tt;
                $condpaye = "";
            }



            if ($this->request->data['Piecereglement']['compte_id']) {
                $compte_id = $this->request->data['Piecereglement']['compte_id'];
                $c = '0';
                foreach ($compte_id as $ad) {
                    $c = $c . ',' . $ad;
                }
                $c = $c;
                $cond7 = "Piecereglement.compte_id in (" . $c . ')';
            }




            if ($this->request->data['Piecereglement']['paiement_id']) {
                $paiement_id = $this->request->data['Piecereglement']['paiement_id'];
                $p = '0';
                foreach ($paiement_id as $ad) {
                    $p = $p . ',' . $ad;
                }
                $p = $p;
                $cond8 = "Piecereglement.paiement_id in (" . $p . ')';
            }



            if ($this->request->data['Piecereglement']['nacionalitefournisseur_id']) {
                $nacionalitefournisseur_id = $this->request->data['Piecereglement']['nacionalitefournisseur_id'];
                if ($nacionalitefournisseur_id == 1) {
                    $fournisseurs = $this->Fournisseur->find('all', array('recursive' => -1, 'conditions' => array('Fournisseur.devise_id' => 1)));
                    $abc = '0';
                    foreach ($fournisseurs as $cl) {
                        $abc = $abc . ',' . $cl['Fournisseur']['id'];
                    }
                    $cond9 = 'Reglement.fournisseur_id in (' . $abc . ')';
                } else {
                    $fournisseurs = $this->Fournisseur->find('all', array('recursive' => -1, 'conditions' => array('Fournisseur.devise_id <>' => 1)));
                    $abc = '0';
                    foreach ($fournisseurs as $cl) {
                        $abc = $abc . ',' . $cl['Fournisseur']['id'];
                    }
                    $cond9 = 'Reglement.fournisseur_id in (' . $abc . ')';
                }
            }

            if ($this->request->data['Piecereglement']['regle_id']) {
                $regle_id = $this->request->data['Piecereglement']['regle_id'];
                //debug($regle_id);
                if ($regle_id == 1) {
                    $condreglefrs = 'Piecereglement.reglefournisseur=1';
                } else {
                    $condreglefrs = 'Piecereglement.reglefournisseur=0';
                }
                $condpaye = "";
            }
            if ($this->request->data['Piecereglement']['numero']) {
                $numero = $this->request->data['Piecereglement']['numero'];
                $cond10 = "Piecereglement.num LIKE '%" . $numero . "%'";
                $condpaye = "";
            }
            
            if ($this->request->data['Piecereglement']['montant']) {
                $montant = $this->request->data['Piecereglement']['montant'];
                $cond11 = "Piecereglement.montant LIKE '%" . $montant . "%'";
                $condpaye = "";
            }

            //debug($condreglefrs);die;
            $recherche = 1;
            $piecereglements = $this->Piecereglement->find('all', array('order' => array('Piecereglement.echance' => 'ASC')
                , 'conditions' => array('Piecereglement.credit' => 0, @$condreglefrs, @$condpaye, @$cond, @$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, @$cond8, @$cond9, @$cond10, @$cond11), 'recursive' => 0));
            //debug($piecereglements);die;
        }
        $regles[1] = "Reglé";
        $regles[2] = "Non Reglé";
        $etatpiecereglements = $this->Etatpiecereglement->find('list', array('fields' => array('Etatpiecereglement.name', 'Etatpiecereglement.name'), 'conditions' => array('Etatpiecereglement.id in (1,3,4,7,8,9,10,11,12)')));
        $fournisseurs = $this->Fournisseur->find('list');
        $comptes = $this->Compte->find('list');
        $nacionalitefournisseurs = $this->Nacionalitefournisseur->find('list');
        $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id in (2,3,4,6,7)')));
        $this->set(compact('montant','numero','regles', 'nacionalitefournisseur_id', 'abc', 'p', 'c', 'tt', 'recherche', 'nacionalitefournisseurs', 'etatpiecereglements', 'paiement_id', 'piecereglements', 'paiements', 'fournisseurs', 'comptes', 'Date_debut', 'Date_fin', 'Date_deb', 'Date_fn', 'fournisseur_id', 'num_recu', 'situation', 'compte_id'));
    }

    public function imprimerindexpf() {

        $this->loadModel('Fournisseur');
        $this->loadModel('Compte');
        $this->loadModel('Fournisseur');
        $this->loadModel('Etatpiecereglement');
        $this->loadModel('Exercice');
        $this->loadModel('Piecereglement');
        $this->loadModel('Paiement');
        $this->loadModel('Nacionalitefournisseur');

        //debug($this->request->query);

        $fournisseurs = $this->Fournisseur->find('list');
        $comptes = $this->Compte->find('all');


        if (!empty($this->request->query['Date_debut'])) {
            $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_debut'])));
            $cond = 'Reglement.Date>=' . "'" . $Date_debut . "'";
        }
        if (!empty($this->request->query['Date_fin'])) {
            $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_fin'])));
            $cond1 = 'Reglement.Date<=' . "'" . $Date_fin . "'";
        }
        if (!empty($this->request->query['Date_deb'])) {
            $Date_deb = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_deb'])));
            $cond2 = 'Piecereglement.echance>=' . "'" . $Date_deb . "'";
        }
        if (!empty($this->request->query['Date_fn'])) {
            $Date_fn = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_fn'])));
            $cond3 = 'Piecereglement.echance<=' . "'" . $Date_fn . "'";
        }
        if (!empty($this->request->query['fournisseur_id'])) {
            $fournisseur_id = $this->request->query['fournisseur_id'];
            $cond4 = 'Reglement.fournisseur_id=' . $fournisseur_id;
        }
        if (!empty($this->request->query['situation'])) {
            $situation = $this->request->query['situation'];
            $situationn = str_replace('/', '"', $situation);
            $cond6 = "Piecereglement.situation in (" . $situationn . ')';
            //debug($cond6);die;
        }
        if (!empty($this->request->query['compte_id'])) {
            $compte_id = $this->request->query['compte_id'];
            $cond7 = "Piecereglement.compte_id in (" . $compte_id . ')';
        }
        if (!empty($this->request->query['paiement_id'])) {
            $paiement_id = $this->request->query['paiement_id'];
            $cond8 = "Piecereglement.paiement_id in (" . $paiement_id . ')';
        }
        if (!empty($this->request->query['abc'])) {
            $nacionalitefournisseur_id = $this->request->query['nacionalitefournisseur_id'];
            $abc = $this->request->query['abc'];
            $cond9 = 'Reglement.fournisseur_id in (' . $abc . ')';
        }
        if (!empty($this->request->query['numero'])) {
                $numero = $this->request->query['numero'];
                $cond10 = "Piecereglement.num LIKE '%" . $numero . "%'";
                $condpaye = "";
            }
            
        if (!empty($this->request->query['montant'])) {
            $montant = $this->request->query['montant'];
            $cond11 = "Piecereglement.montant LIKE '%" . $montant . "%'";
            $condpaye = "";
        }

        $piecereglements = $this->Piecereglement->find('all', array('order' => array('Piecereglement.echance' => 'ASC')
            , 'conditions' => array('Piecereglement.id > ' => 0, @$cond, @$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, @$cond8, @$cond9, @$cond10, @$cond11), 'recursive' => 0));
        //debug($piecereglements);die;
        $etatpiecereglements = $this->Etatpiecereglement->find('list', array('fields' => array('Etatpiecereglement.name', 'Etatpiecereglement.name')));
        $fournisseurs = $this->Fournisseur->find('list');
        $comptes = $this->Compte->find('list');
        $nacionalitefournisseurs = $this->Nacionalitefournisseur->find('list');
        $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id in (2,3,4,6,7)')));
        $this->set(compact('montant','numero','nacionalitefournisseur_id', 'abc', 'p', 'c', 'tt', 'recherche', 'nacionalitefournisseurs', 'etatpiecereglements', 'paiement_id', 'piecereglements', 'paiements', 'fournisseurs', 'comptes', 'Date_debut', 'Date_fin', 'Date_deb', 'Date_fn', 'fournisseur_id', 'num_recu', 'situation', 'compte_id'));
    }

}
