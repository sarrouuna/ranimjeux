<?php
App::uses('AppController', 'Controller');

/**
 * Deviprospects Controller
 *
 * @property Deviprospect $Deviprospect
 */
class DeviprospectsController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'deviprospects') {
                    $commande = 1;
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $condtransfert = 'Deviprospect.trasfert =0';
        $this->loadModel('Fournisseur');
        $this->loadModel('Importation');
        $this->loadModel('Exercice');
        $this->loadModel('Societe');
        $this->loadModel('Typedipliquation');
        $this->loadModel('Pointdevente');
        $exercices = $this->Exercice->find('list');

        $users = CakeSession::read('users');
        $pv = CakeSession::read('pointdevente');
//        $soc= CakeSession::read('soc');
        //debug($soc);
        $socc = CakeSession::read('soc');
        $pvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id in (' . $socc . ')')));
        $liste_pv = '0';
        foreach ($pvs as $one_pv) {
            if (!empty($one_pv['Pointdevente']['id'])) {
                $liste_pv = $liste_pv . ',' . $one_pv['Pointdevente']['id'];
            }
        }
        $cond6 = 'Deviprospect.pointdevente_id in (' . $liste_pv . ')';
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Deviprospects"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Recherche']);
            } else {
                $this->request->data['Recherche'] = CakeSession::read('recherche');
            }
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $cond4 = 'Deviprospect.exercice_id =' . $exercices[$exerciceid];
            }
            // debug($this->request->data);die;
            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $cond1 = 'Deviprospect.date >= ' . "'" . $date1 . "'";
                $cond4 = '';
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $cond2 = 'Deviprospect.date <= ' . "'" . $date2 . "'";
                $cond4 = '';
            }

            if ($this->request->data['Recherche']['fournisseur_id']) {
                $fournisseurid = $this->request->data['Recherche']['fournisseur_id'];
                $cond3 = 'Deviprospect.fournisseur_id =' . $fournisseurid;
            }
            if ($this->request->data['Recherche']['importation_id']) {
                $importationid = $this->request->data['Recherche']['importation_id'];
                $cond5 = 'Deviprospect.importation_id =' . $importationid;
            }


            $this->loadModel('Utilisateur');
            $this->loadModel('Pointdevente');
            $this->loadModel('Societe');
            $this->loadModel('Personnel');
            if ($this->request->data['Recherche']['societe_id']) {
                $societe_id = $this->request->data['Recherche']['societe_id'];
                $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
                $ch_pv = 0;
                foreach ($lespvs as $lespv) {
                    $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
                }
                $cond6 = 'Deviprospect.pointdevente_id in (' . $ch_pv . ')';
                $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societe_id)));
            }


            if ($this->request->data['Recherche']['pointdevente_id']) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                $cond7 = 'Deviprospect.pointdevente_id =' . $pointdevente_id;
            }

            if ($this->request->data['Recherche']['verif'] == 1) {
                $condtransfert = '';
                @$cond1 = '';
                @$cond2 = '';
                @$cond3 = '';
                @$cond4 = '';
                @$cond5 = '';
                @$cond6 = '';
                @$cond7 = '';
                $this->request->data['Recherche'] = array();
            }
        }

        $importations = $this->Importation->find('list');
        $fournisseurs = $this->Fournisseur->find('list');
//        $societes = $this->Societe->find('list', array('conditions' => array('Societe.id in (' . $soc . ')')));
        $typedipliquations = $this->Typedipliquation->find('list', array('fields' => array('Typedipliquation.designation'), 'conditions' => array('Typedipliquation.id in (5,6)')));
        $this->Deviprospect->recursive = 0;
        $this->paginate = array('conditions' => array(@$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6, @$cond7, @$condtransfert));
        $this->set('deviprospects', $this->paginate());
        $soc = CakeSession::read('soc');
        $sos = explode(',', $soc);
        $countsos = count($sos);
        if ($countsos > 1) {
            $societes = $this->Societe->find('list', array(
                'conditions' => array('Societe.id in' => $sos)
            ));
        }
        $this->set(compact('countsos', 'typedipliquations', 'societes', 'exercices', 'pv', 'importations', 'fournisseurs', 'societe_id', 'pointdeventes'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'deviprospects') {
                    $commande = 1;
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Lignedeviprospect');
        $this->loadModel('Article');
        $this->loadModel('Fournisseur');
        $this->loadModel('Lignereception');
        $this->loadModel('Importation');
        $this->loadModel('Utilisateur');
        $options = array('conditions' => array('Deviprospect.' . $this->Deviprospect->primaryKey => $id));
        $this->request->data = $this->Deviprospect->find('first', $options);
        $devis = $this->Deviprospect->find('first', array('recursive' => 0, 'conditions' => array('Deviprospect.id' => $id)));
        $day = date("d/m/Y", strtotime(str_replace('/', '-', $devis['Deviprospect']['date'])));
        $importations = $this->Importation->find('list', array('conditions' => array('Importation.fournisseur_id' => $devis['Deviprospect']['fournisseur_id'], 'Importation.etat' => 0), false));
        $importation = $this->Importation->find('first', array('recursive' => -1, 'conditions' => array('Importation.id' => $devis['Deviprospect']['importation_id'])));
        $tr = $importation['Importation']['tauxderechenge'];
        $coe = $importation['Importation']['coefficien'];
        $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $devis['Deviprospect']['fournisseur_id']), false));
        $devise = $fournisseur['Fournisseur']['devise_id'];
        $lignedeviprospects = $this->Lignedeviprospect->find('all', array('conditions' => array('Lignedeviprospect.deviprospect_id' => $id), 'order' => array('Lignedeviprospect.id' => 'asc')));
        $articles = $this->Article->find('list');
        $fournisseurs = $this->Deviprospect->Fournisseur->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation')));
        if (isset($_GET['t'])) {
            $t = 1;
        } else {
            $t = 0;
        }
        $this->set(compact('t', 'devise', 'coe', 'tr', 'importations', 'fournisseurs', 'depots', 'lignedeviprospects', 'day', 'articles', 'fournis'));
    }

    public function imprimer($id = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'deviprospects') {
                    $commande = $liens['imprimer'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Lignedeviprospect');
        if (!$this->Deviprospect->exists($id)) {
            throw new NotFoundException(__('Invalid devi'));
        }
        $options = array('conditions' => array('Deviprospect.' . $this->Deviprospect->primaryKey => $id));
        $this->set('deviprospect', $this->Deviprospect->find('first', $options));
        $lignedeviprospects = $this->Lignedeviprospect->find('all', array(
            'conditions' => array('Lignedeviprospect.deviprospect_id' => $id)
        ));
        // debug($deviprospect);
        $this->set(compact('lignedeviprospects'));
    }

    public function imprimersansprix($id = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'deviprospects') {
                    $commande = $liens['imprimer'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Lignedeviprospect');
        if (!$this->Deviprospect->exists($id)) {
            throw new NotFoundException(__('Invalid devi'));
        }
        $options = array('conditions' => array('Deviprospect.' . $this->Deviprospect->primaryKey => $id));
        $this->set('deviprospect', $this->Deviprospect->find('first', $options));
        $lignedeviprospects = $this->Lignedeviprospect->find('all', array(
            'conditions' => array('Lignedeviprospect.deviprospect_id' => $id)
        ));
        // debug($deviprospect);
        $this->set(compact('lignedeviprospects'));
    }

    public function exp_etatexcel($id = null) {
        $this->layout = null;
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'deviprospects') {
                    $commande = $liens['imprimer'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Lignedeviprospect');
        if (!$this->Deviprospect->exists($id)) {
            throw new NotFoundException(__('Invalid devi'));
        }
        $options = array('conditions' => array('Deviprospect.' . $this->Deviprospect->primaryKey => $id));
        $this->set('deviprospect', $this->Deviprospect->find('first', $options));
        $lignedeviprospects = $this->Lignedeviprospect->find('all', array(
            'conditions' => array('Lignedeviprospect.deviprospect_id' => $id)
        ));
        // debug($deviprospect);
        $this->set(compact('lignedeviprospects'));
    }

    public function add() {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'deviprospects') {
                    $commande = $liens['add'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Depot');
        $this->loadModel('Lignereception');
        $this->loadModel('Importation');
        $this->loadModel('Lignedeviprospect');
        $this->loadModel('Articlefournisseur');
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Deviprospect']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Deviprospect']['date'])));
            $this->request->data['Deviprospect']['utilisateur_id'] = CakeSession::read('users');

            if (empty($this->request->data['Deviprospect']['pointdevente_id'])) {
                $this->request->data['Deviprospect']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Deviprospect']['exercice_id'] = date("Y");
            $depotid = $this->request->data['Deviprospect']['depot_id'];

            $this->Deviprospect->create();
            if (!empty($this->request->data['Lignereception'])) {
                if ($this->Deviprospect->save($this->request->data)) {
                    $id = $this->Deviprospect->id;
                    $this->misejour("Deviprospect", "add", $id);

                    $Lignereceptions = array();
                    foreach ($this->request->data['Lignereception'] as $numl => $f) {

                        if ($f['sup'] != 1) {
                            $f['deviprospect_id'] = $id;

                            $this->Lignedeviprospect->create();
                            $this->Lignedeviprospect->save($f);
                            $artfrs = array();
                            $testartfrs = $this->Articlefournisseur->find('first', array('conditions' => array('Articlefournisseur.fournisseur_id' => $this->request->data['Deviprospect']['fournisseur_id'], 'Articlefournisseur.article_id' => $f['article_id'])));
                            if (!empty($testartfrs)) {
                                $artfrs['id'] = $testartfrs['Articlefournisseur']['id'];
                            }
                            $artfrs['fournisseur_id'] = $this->request->data['Deviprospect']['fournisseur_id'];
                            $artfrs['article_id'] = $f['article_id'];
                            $artfrs['reference'] = $f['reference'];
                            $artfrs['prix'] = $f['prix'];
                            $this->Articlefournisseur->create();
                            $this->Articlefournisseur->save($artfrs);
                            //debug($artfrs);die;     
                        }
                    }

                    $this->Session->setFlash(__('The bonreception has been saved'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The bonreception could not be saved. Please, try again.'));
                }
            } else {
                $this->Session->setFlash(__('le bonreception dois avoir aux moins une ligne de reception.'));
            }
        }
        $numero = $this->Deviprospect->find('all', array('fields' =>
            array(
                'MAX(Deviprospect.numero) as num'
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
        //$articles = $this->Article->find('list');
        $fournisseurs = $this->Deviprospect->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id <>' => 1)));
        $p = CakeSession::read('pointdevente');
        $societe = CakeSession::read('societe');
        if ($societe != 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societe, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        }
        $pointdeventes = $this->Pointdevente->find('list');
//                $importations = $this->Importation->find('list',array('conditions' => array('Importation.designation')));
        $this->set(compact('mm', 'fournisseurs', 'p', 'articles', 'depots', 'pointdeventes'));
    }

    public function addindirect($tab = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'deviprospects') {
                    $commande = $liens['add'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Depot');
        $this->loadModel('Lignereception');
        $this->loadModel('Importation');
        $this->loadModel('Lignedeviprospect');
        $this->loadModel('Articlefournisseur');
        $tab = '(' . $tab . '0)';
        if ($this->request->is('post')) {
            // debug($this->request->data);die;
            $this->request->data['Deviprospect']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Deviprospect']['date'])));
            $this->request->data['Deviprospect']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Deviprospect']['pointdevente_id'] = CakeSession::read('pointdevente');
            $this->request->data['Deviprospect']['exercice_id'] = date("Y");
            $depotid = $this->request->data['Deviprospect']['depot_id'];
            $this->Deviprospect->create();
            if ($this->Deviprospect->save($this->request->data)) {
                $id = $this->Deviprospect->id;
                $this->misejour("Deviprospect", "add", $id);

                $Lignereceptions = array();
                foreach ($this->request->data['Lignedeviprospect'] as $numl => $f) {

                    if ($f['sup'] != 1) {
                        $Lignereceptions['deviprospect_id'] = $id;
                        $Lignereceptions['article_id'] = $f['article_id'];
                        $Lignereceptions['quantite'] = $f['quantite'];
                        if (!empty($f['prix'])) {
                            $Lignereceptions['prix'] = $f['prix'];
                            $Lignereceptions['prix'] = $f['prix'];
                        }
                        $Lignereceptions['prixhtva'] = $f['prixhtva'];
                        $Lignereceptions['remise'] = @$f['remise'];
                        $Lignereceptions['fodec'] = @$f['fodec'];
                        $Lignereceptions['tva'] = $f['tva'];
                        $Lignereceptions['prixhtva'] = $f['prixhtva'];
                        $Lignereceptions['totalht'] = ($f['prixhtva'] * (1 - @$f['remise'] * 0.01)) * $f['quantite'];
                        $Lignereceptions['totalttc'] = ((($Lignereceptions['totalht']) * (1 + (@$f['fodec'] * 0.01))) * (1 + ($f['tva'] * 0.01)));
                        $this->Lignedeviprospect->create();
                        $this->Lignedeviprospect->save($Lignereceptions);
                        $artfrs = array();
                        $testartfrs = $this->Articlefournisseur->find('first', array('conditions' => array('Articlefournisseur.fournisseur_id' => $this->request->data['Deviprospect']['fournisseur_id'], 'Articlefournisseur.article_id' => $f['article_id'])));
                        if (!empty($testartfrs)) {
                            $artfrs['id'] = $testartfrs['Articlefournisseur']['id'];
                        }
                        $artfrs['article_id'] = $this->request->data['Deviprospect']['fournisseur_id'];
                        $artfrs['article_id'] = $f['article_id'];
                        $artfrs['reference'] = $f['reference'];
                        $artfrs['prix'] = $f['prix'];
                        $this->Articlefournisseur->create();
                        $this->Articlefournisseur->save($artfrs);
                        //debug($artfrs);die;      
                    }
                }

                $this->Session->setFlash(__('The bonreception has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The bonreception could not be saved. Please, try again.'));
            }
        } else {
            $articlecommandes = $this->Article->find('all', array('conditions' => array('Article.id in' . $tab)));
        }
        $numero = $this->Deviprospect->find('all', array('fields' =>
            array(
                'MAX(Deviprospect.numero) as num'
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
        $articles = $this->Article->find('list');
        $fournisseurs = $this->Deviprospect->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id <>' => 1)));
        $societe = CakeSession::read('societe');
        if ($societe != 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societe, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        }
        $this->set(compact('articlecommandes', 'mm', 'fournisseurs', 'articles', 'depots'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'deviprospects') {
                    $commande = $liens['edit'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Lignedeviprospect');
        $this->loadModel('Article');
        $this->loadModel('Fournisseur');
        $this->loadModel('Lignereception');
        $this->loadModel('Importation');
        $this->loadModel('Utilisateur');
        $this->loadModel('Ligneworkflow');
        $this->loadModel('Lignevalide');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Compte');
        $this->loadModel('Pointdevente');
        $p = CakeSession::read('users');
        //zeinab
        $this->loadModel('Historiquesuggcdde');
        //debug($p);die;
        if (!$this->Deviprospect->exists($id)) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {


            // debug( $this->request->data);die;
            $this->request->data['Deviprospect']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Deviprospect']['date'])));
            $this->request->data['Deviprospect']['utilisateur_id'] = CakeSession::read('users');
            if ($this->Deviprospect->save($this->request->data)) {
                $this->misejour("Deviprospect", "edit", $id);
                if ($this->request->data['Deviprospect']['etat'] == 2) {
                    $this->Lignevalide->deleteAll(array('Lignevalide.id_piece' => $id));
                }
                if ($this->request->data['Deviprospect']['valide'] == 1) {
                    $valider = 0;
                    $personnel = $this->Utilisateur->find('first', array('conditions' => array('Utilisateur.id' => $p), 'recursive' => -1));
                    $tab = array();
                    $ligneworkflows = $this->Ligneworkflow->find('first', array('conditions' => array('Ligneworkflow.personnel_id' => $personnel['Utilisateur']['personnel_id'], 'Ligneworkflow.typeworkflow_id' => 2, 'Workflow.document_id' => 1), 'recursive' => 0));
                    $tab['ligneworkflow_id'] = $ligneworkflows['Ligneworkflow']['id'];
                    $tab['id_piece'] = $id;
                    $tab['document_id'] = $ligneworkflows['Workflow']['document_id'];
                    $tab['personnel_id'] = $personnel['Utilisateur']['personnel_id'];
                    $tab['date'] = date("Y-m-d");
                    $tab['heure'] = date("H:i:s");
                    $tab['remarque'] = $this->request->data['Deviprospect']['remarque'];
                    $this->Lignevalide->create();
                    $this->Lignevalide->save($tab);
                    //$this->Utilisateur->updateAll(array('Utilisateur.notifdevis' =>'Utilisateur.notifdevis'+1), array('Utilisateur.id'=>$p));
                    $ligneworkflow2s = $this->Ligneworkflow->find('all', array('conditions' => array('Ligneworkflow.obligatoire' => 1, 'Ligneworkflow.typeworkflow_id' => 2, 'Workflow.document_id' => 1), 'recursive' => 0));
                    foreach ($ligneworkflow2s as $ligne) {
                        $lignevalides = $this->Lignevalide->find('count', array('conditions' => array('Lignevalide.personnel_id' => $ligne['Ligneworkflow']['personnel_id'], 'Lignevalide.ligneworkflow_id' => $ligne['Ligneworkflow']['id'], 'Lignevalide.id_piece' => $id), 'recursive' => 2));
                        if ($lignevalides == 0) {
                            $valider = 1;
                        }
                    }
                    if ($valider == 0) {
                        $this->Deviprospect->updateAll(array('Deviprospect.etat' => 1), array('Deviprospect.id' => $id));
                        $devis = $this->Deviprospect->find('count', array('conditions' => array('Deviprospect.etat' => 1)));
                        $this->Utilisateur->updateAll(array('Utilisateur.notifdevis' => $devis));
                    }
                }
                //zeinab
                // historique edit ligne Suggestion cdde
                foreach ($this->request->data['Lignedeviprospect'] as $numl => $f) {
                    $histo = array();
                    if ($f['id'] == '' && $f['sup'] != 1) {
                        $histo['deviprospect_id'] = $id;
                        $histo['utilisateur_id'] = CakeSession::read('users');
                        $histo['date'] = date("Y-m-d H:i:s");
                        //$histo['lignedeviprospect_id']=$f['id'];
                        $histo['etat'] = 'ajout';

                        $histo['reference'] = $f['reference'];
                        $histo['quantite'] = $f['quantite'];
                        if (!empty($f['prix'])) {
                            $histo['prix'] = $f['prix'];
                        }
                        $histo['tva'] = $f['tva'];
                        $histo['remise'] = $f['remise'];
                        if (!empty($f['fodec'])) {
                            $histo['fodec'] = $f['fodec'];
                        }
                        $histo['totalht'] = $f['totalht'];
                        $histo['totalttc'] = $f['totalttc'];
                        $histo['prixhtva'] = $f['prixhtva'];

                        $this->Historiquesuggcdde->create();
                        $this->Historiquesuggcdde->save($histo);
                    } elseif ($f['id'] != '') {
                        $suggestion = $this->Lignedeviprospect->find('first', array('conditions' => array('Lignedeviprospect.id' => $f['id']), 'recursive' => -1));
                        //debug($suggestion);
                        //   debug($f);
                        if ($f['sup'] == 1) {
                            $histo['deviprospect_id'] = $id;
                            $histo['utilisateur_id'] = CakeSession::read('users');
                            $histo['date'] = date("Y-m-d H:i:s");
                            $histo['lignedeviprospect_id'] = $f['id'];
                            $histo['etat'] = 'supp';

                            $histo['reference'] = $suggestion['Lignedeviprospect']['reference'];
                            $histo['quantite'] = $suggestion['Lignedeviprospect']['quantite'];
                            $histo['prix'] = $suggestion['Lignedeviprospect']['prix'];
                            $histo['tva'] = $suggestion['Lignedeviprospect']['tva'];
                            $histo['remise'] = $suggestion['Lignedeviprospect']['remise'];
                            $histo['fodec'] = $suggestion['Lignedeviprospect']['fodec'];
                            $histo['totalht'] = $suggestion['Lignedeviprospect']['totalht'];
                            $histo['totalttc'] = $suggestion['Lignedeviprospect']['totalttc'];
                            $histo['prixhtva'] = $suggestion['Lignedeviprospect']['prixhtva'];

                            $this->Historiquesuggcdde->create();
                            $this->Historiquesuggcdde->save($histo);
                        } else {
                            if ($f['reference'] != $suggestion['Lignedeviprospect']['reference']) {
                                $histo['reference'] = $suggestion['Lignedeviprospect']['reference'];
                            }
                            if ($f['quantite'] != $suggestion['Lignedeviprospect']['quantite']) {
                                $histo['quantite'] = $suggestion['Lignedeviprospect']['quantite'];
                            }
                            if (!empty($f['prix'])) {
                                if ($f['prix'] != $suggestion['Lignedeviprospect']['prix']) {
                                    $histo['prix'] = $suggestion['Lignedeviprospect']['prix'];
                                }
                            }
                            if ($f['tva'] != $suggestion['Lignedeviprospect']['tva']) {
                                $histo['tva'] = $suggestion['Lignedeviprospect']['tva'];
                            }
                            if ($f['remise'] != $suggestion['Lignedeviprospect']['remise']) {
                                $histo['remise'] = $suggestion['Lignedeviprospect']['remise'];
                            }
                            if ($f['totalht'] != $suggestion['Lignedeviprospect']['totalht']) {
                                $histo['totalht'] = $suggestion['Lignedeviprospect']['totalht'];
                            }
                            if ($f['totalttc'] != $suggestion['Lignedeviprospect']['totalttc']) {
                                $histo['totalttc'] = $suggestion['Lignedeviprospect']['totalttc'];
                            }
                            if ($f['prixhtva'] != $suggestion['Lignedeviprospect']['prixhtva']) {
                                $histo['prixhtva'] = $suggestion['Lignedeviprospect']['prixhtva'];
                            }
                            if (!empty($f['fodec'])) {
                                if ($f['fodec'] != $suggestion['Lignedeviprospect']['fodec']) {
                                    $histo['fodec'] = $suggestion['Lignedeviprospect']['fodec'];
                                }
                            }
                            //  debug($histo);
                            if ($histo != array()) {
                                $histo['deviprospect_id'] = $id;
                                $histo['utilisateur_id'] = CakeSession::read('users');
                                $histo['date'] = date("Y-m-d H:i:s");
                                $histo['lignedeviprospect_id'] = $f['id'];
                                $histo['etat'] = 'modif';
                                $this->Historiquesuggcdde->create();
                                $this->Historiquesuggcdde->save($histo);
                            }
                        }
                    }
                }

                //    die; 
                $this->Lignedeviprospect->deleteAll(array('Lignedeviprospect.deviprospect_id' => $id), false);
                $Lignereceptions = array();
                foreach ($this->request->data['Lignedeviprospect'] as $numl => $f) {
                    $Lignereceptions = array();
                    if ($f['sup'] != 1) {
                        //zeinab
                        if ($this->request->data['devise'] == 1) {
                            $Lignereceptions['deviprospect_id'] = $id;
                            $Lignereceptions['article_id'] = $f['article_id'];
                            $Lignereceptions['quantite'] = $f['quantite'];
                            if (!empty($f['prix'])) {
                                $Lignereceptions['prix'] = $f['prix'];
                                $Lignereceptions['prix'] = $f['prix'];
                            }
                            $Lignereceptions['reference'] = $f['reference'];
                            $Lignereceptions['prixhtva'] = $f['prixhtva'];
                            $Lignereceptions['remise'] = @$f['remise'];
                            $Lignereceptions['fodec'] = @$f['fodec'];
                            $Lignereceptions['tva'] = $f['tva'];
                            $Lignereceptions['prixhtva'] = $f['prixhtva'];
                            $Lignereceptions['totalht'] = ($f['prixhtva'] / (1 + @$f['tva'] / 100)) * $f['quantite'];
                            $Lignereceptions['totalttc'] = $f['prixhtva'] * $f['quantite'];
                            $this->Lignedeviprospect->create();
                            $this->Lignedeviprospect->save($Lignereceptions);
                        } else {
                            $f['deviprospect_id'] = $id;
                            $this->Lignedeviprospect->create();
                            $this->Lignedeviprospect->save($f);
                        }
                        $artfrs = array();
                        $testartfrs = $this->Articlefournisseur->find('first', array('conditions' => array('Articlefournisseur.fournisseur_id' => $this->request->data['Deviprospect']['fournisseur_id'], 'Articlefournisseur.article_id' => $f['article_id'])));
                        if (!empty($testartfrs)) {
                            $artfrs['id'] = $testartfrs['Articlefournisseur']['id'];
                        }
                        $artfrs['fournisseur_id'] = $this->request->data['Deviprospect']['fournisseur_id'];
                        $artfrs['article_id'] = $f['article_id'];
                        $artfrs['reference'] = $f['reference'];
                        $artfrs['prix'] = $f['prix'];
                        $this->Articlefournisseur->create();
                        $this->Articlefournisseur->save($artfrs);
                        //debug($artfrs);die; 
                    }
                }
                $this->Session->setFlash(__('The bonreception has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The bonreception could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Deviprospect.' . $this->Deviprospect->primaryKey => $id));
            $this->request->data = $this->Deviprospect->find('first', $options);
        }
        $devis = $this->Deviprospect->find('first', array('recursive' => 0, 'conditions' => array('Deviprospect.id' => $id)));
        $day = date("d/m/Y", strtotime(str_replace('/', '-', $devis['Deviprospect']['date'])));
        $importations = $this->Importation->find('list', array('conditions' => array('Importation.fournisseur_id' => $devis['Deviprospect']['fournisseur_id'], 'Importation.etat' => 0), false));
        $importation = $this->Importation->find('first', array('recursive' => -1, 'conditions' => array('Importation.id' => $devis['Deviprospect']['importation_id'])));
        if ($devis['Deviprospect']['importation_id'] != 0) {
            $tr = $importation['Importation']['tauxderechenge'];
            $coe = $importation['Importation']['coefficien'];
        }
        $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $devis['Deviprospect']['fournisseur_id']), false));
        $devise = $fournisseur['Fournisseur']['devise_id'];
        $lignedeviprospects = $this->Lignedeviprospect->find('all', array('conditions' => array('Lignedeviprospect.deviprospect_id' => $id), 'order' => array('Lignedeviprospect.id' => 'asc')));
        //$articles=$this->Article->find('list');   
        $fournisseurs = $this->Deviprospect->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id <>' => 1)));
        $pointdeventes = $this->Pointdevente->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        if (isset($_GET['t'])) {
            $t = 1;
        } else {
            $t = 0;
        }
        //zeinab
        if (isset($_GET['b'])) {
            $b = $_GET['b'];
        } else {
            $b = 0;
        }

        $comptes = $this->Compte->find('list', array('fields' => array('Compte.banque')));

        /* $art = $this->Deviprospect->query('
          SELECT articles.id id, articles.code codeart, articles.name desart, articles.code refart
          FROM  articles
          WHERE NOT
          EXISTS (

          SELECT *
          FROM articlefournisseurs
          WHERE articles.id = articlefournisseurs.article_id
          )
          UNION
          SELECT articlefournisseurs.article_id id, articles.code codeart, articles.name desart, articlefournisseurs.reference refart
          FROM articlefournisseurs, articles
          WHERE articlefournisseurs.fournisseur_id =' . $devis['Deviprospect']['fournisseur_id'] . '
          AND articles.id = articlefournisseurs.article_id');
          $articles = array();
          foreach ($art as $v) {
          if ($v[0]['codeart'] == $v[0]['refart']) {
          $v[0]['refart'] = "";
          }
          $articles[$v[0]['id']] = $v[0]['refart'] . " " . $v[0]['codeart'] . " " . $v[0]['desart'];
          } */


        $p = CakeSession::read('pointdevente');
        $societe = CakeSession::read('societe');
        if ($societe != 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societe, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        }
        $this->set(compact('devis', 'comptes', 'id', 't', 'b', 'devise', 'coe', 'pointdeventes', 'p', 'tr', 'importations', 'fournisseurs', 'depots', 'lignedeviprospects', 'day', 'articles', 'fournis'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'deviprospects') {
                    $commande = $liens['delete'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignedeviprospect');
        $this->Deviprospect->id = $id;
        if (!$this->Deviprospect->exists()) {
            throw new NotFoundException(__('Invalid deviprospect'));
        }
        $this->request->onlyAllow('post', 'delete');
        $this->Lignedeviprospect->deleteAll(array('Lignedeviprospect.deviprospect_id' => $id), false);
        $abcd = $this->Deviprospect->find('first', array('conditions' => array('Deviprospect.id' => $id), 'recursive' => -1));
        $numansar = $abcd['Deviprospect']['numero'];
        if ($this->Deviprospect->delete()) {
            $this->misejour("Deviprospect", $numansar, $id);
            $this->Session->setFlash(__('Deviprospect deleted'));
            CakeSession::write('view', "delete");
            //$this->redirect(array('action' => 'index'));
        }
        $devis = $this->Deviprospect->find('count');
        $this->Utilisateur->updateAll(array('Utilisateur.notifdevis' => $devis), array('Utilisateur.id in(12,15)'));
        $this->Session->setFlash(__('Deviprospect was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function notifdevis($d = null) {

        $this->loadModel('Utilisateur');
        $this->loadModel('Ligneworkflow');
        $this->loadModel('Lignevalide');
        $this->loadModel('Fournisseur');
        $this->loadModel('Lignevalide');
        $this->layout = null;
        //$data = $this->request->data;
        //$d = $data['personnel'];
        $personnel = $this->Utilisateur->find('first', array('conditions' => array('Utilisateur.id' => $d)));

        $devis = $this->Deviprospect->find('count');
        $nbrworkflows = $this->Ligneworkflow->find('count', array('conditions' => array('Ligneworkflow.personnel_id' => $personnel['Personnel']['id'], 'Ligneworkflow.typeworkflow_id' => 2, 'Workflow.document_id' => 1), 'recursive' => 2));
        //debug($nbrworkflows);
        $ligneworkflow = $this->Ligneworkflow->find('first', array('conditions' => array('Ligneworkflow.personnel_id' => $personnel['Personnel']['id'], 'Ligneworkflow.typeworkflow_id' => 2, 'Workflow.document_id' => 1), 'recursive' => 2));
        //debug($ligneworkflow);

        $lignevalides = $this->Lignevalide->find('count', array('conditions' => array('Lignevalide.ligneworkflow_id' => $ligneworkflow['Ligneworkflow']['id']), 'recursive' => 2));
        if ($nbrworkflows > 0) {
            $utilisateur = $this->Utilisateur->find('first', array('conditions' => array('Utilisateur.id' => $d)));
            $notifdevis = $utilisateur['Utilisateur']['notifdevis'];
        }
        $listedevis = $this->Deviprospect->query('select * from deviprospects where id not in (select id_piece from lignevalides where document_id=1 and personnel_id=' . $personnel['Personnel']['id'] . ') and etat=0');
        //debug($listedevis);
        $nbrdevis = $this->Deviprospect->query('select count(*) from deviprospects where id not in (select id_piece from lignevalides where document_id=1 and personnel_id=' . $personnel['Personnel']['id'] . ') and etat=0');
        //debug($nbrdevis[0][0]['count(*)']);die;
        $nbdevis = $nbrdevis[0][0]['count(*)'];
        $fournisseurs = $this->Fournisseur->find('list');
        //zeinab
        $banque = $ligneworkflow['Ligneworkflow']['banque'];
        echo json_encode(array('banque' => $banque, 'fournisseurs' => $fournisseurs, 'notifdevis' => $notifdevis, 'devis' => $devis, 'd' => $d, 'listedevis' => $listedevis, 'lignevalides' => $lignevalides, 'nbdevis' => $nbdevis, 'nbrworkflows' => $nbrworkflows));
        die;
    }

    public function recapajoutarticle($index = null, $menu = null) {
        $this->loadModel('Article');
        $this->loadModel('Fournisseur');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Client');
        $this->loadModel('Articleclient');
        $this->loadModel('Tag');
        $this->loadModel('Articletag');
        $this->loadModel('Familleclient');
        $this->loadModel('Remiseartfamille');
        $this->loadModel('Typeetatarticle');
        $this->loadModel('Typestockarticle');
        $this->loadModel('Depot');
        $this->loadModel('Stockdepot');
        $this->loadModel('Articlepmp');
        $this->layout = "defaulthelmi";

        if ($this->request->is('post') && (@$this->request->data['Article'] != "")) {
//            debug($this->request->data);
//            die;
            $this->Article->create();
            $this->request->data['Article']['sousfamille_id'] = @$this->request->data['sousfamille_id'];
            $this->request->data['Article']['soussousfamille_id'] = @$this->request->data['soussousfamille_id'];
            $this->request->data['Article']['societe'] = CakeSession::read('composantsoc');
            //$this->request->data['Article']['prixuttc'] = $this->request->data['Article']['prixvente'] * (1 + ($this->request->data['Article']['tva'] / 100));
            //$this->request->data['Article']['prixttcgros'] = $this->request->data['Article']['prixventegros'] * (1 + ($this->request->data['Article']['tva'] / 100));
            if ($this->Article->save($this->request->data)) {
                $id = $this->Article->id;
                
                $tabp = array();
                $tabp['article_id'] = $id;
                $tabp['pmp'] = 0;
                $tabp['qte'] = 0;
                $tabp['coutrevient'] = $this->request->data['Article']['coutrevient'];
                $this->Articlepmp->create();
                $this->Articlepmp->save($tabp);
                
                
                if ($menu == 'achat') {
                    ?>
                    <script language="javascript"  >
                        // alert(<?php echo $index; ?>);
                        input = window.opener.document.getElementById('article_id<?php echo $index; ?>').value = "<?php echo $id; ?>";
                        input = window.opener.document.getElementById("code<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['code']; ?>";
                        input = window.opener.document.getElementById("designation<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['name']; ?>";
                    //                    input = window.opener.document.getElementById("sirine").value = "1";
                        input = window.opener.document.getElementById("prixachat<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['coutrevient']; ?>";
                        input = window.opener.document.getElementById("prixhtva<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['coutrevient']; ?>";
                        input = window.opener.document.getElementById("marge<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['marge']; ?>";
                        input = window.opener.document.getElementById("prixdeventeht<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['prixvente']; ?>";
                        input = window.opener.document.getElementById("remise<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['remise_vente']; ?>";
                        input = window.opener.document.getElementById("tva<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['tva']; ?>";
                    </script>
                <?php
                } else {
//                    $pnht = $this->request->data['Article']['prixvente'] - (($this->request->data['Article']['prixvente'] * $this->request->data['Article']['remise_vente']) / 100);
                    $prixuttc = $this->request->data['Article']['prixvente'] * (1 + ($this->request->data['Article']['tva'] / 100));
                    ?>
                    <script language="javascript"  >
                        input = window.opener.document.getElementById("article_id<?php echo $index; ?>").value = "<?php echo $id; ?>";
                        input = window.opener.document.getElementById("code<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['code']; ?>";
                        input = window.opener.document.getElementById("designation<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['name']; ?>";
                        input = window.opener.document.getElementById("totalhtans<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['prixvente']; ?>";
                        input = window.opener.document.getElementById("remise<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['remise_vente']; ?>";
                        input = window.opener.document.getElementById("prixhtva<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['prixvente']; ?>";
                        input = window.opener.document.getElementById("prixnet<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['prixvente']; ?>";
                        input = window.opener.document.getElementById("puttc<?php echo $index; ?>").value = "<?php echo $prixuttc; ?>";
                        input = window.opener.document.getElementById("tva<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['tva']; ?>";
                        input = window.opener.document.getElementById("type<?php echo $index; ?>").value = "0";
                        window.opener.calculefacture();
                    </script>
                <?php } ?>
                <script language="javascript"  >
                    window.close();
                </script>   
                <?PHP
//debug($id);die;
                // echo'<script language="javascript" type="text/javascript">';
                //echo'window.opener.chargerselectarticle('.$index.','.$id.','.$this->request->data['Article']['code'].','.$this->request->data['Article']['name'].')';
                //  echo'window.close();';
                //  echo'</script>';
                //debug('chargerselectarticle('.$index.','.$id.','.$this->request->data['Article']['code'].','.$this->request->data['Article']['name'].')');die;
                //$this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The article could not be saved. Please, try again.'));
            }
        } else {
            //$data=$this->request->data;
            $index_kbira = $index;
        }
        $index_kbira = $index;
        $familles = $this->Article->Famille->find('list');
        $sousfamilles = $this->Article->Sousfamille->find('list');
        $soussousfamilles = $this->Article->Soussousfamille->find('list');
        $unites = $this->Article->Unite->find('list');
        $fournisseurs = $this->Fournisseur->find('list');
        $familleclients = $this->Familleclient->find('list');
        $clients = $this->Client->find('list');
        $typeetatarticles = $this->Typeetatarticle->find('list');
        $typestockarticles = $this->Typestockarticle->find('list');
        $tags = $this->Tag->find('list');
        $societe = CakeSession::read('societe');
        if ($societe != 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societe, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        }
        $depotistes = $this->Depot->find('all', array('recursive' => -1));
        //debug($depotistes);die;
        $this->set(compact('index_kbira', 'depotistes', 'depots', 'typestockarticles', 'typeetatarticles', 'familleclients', 'familles', 'sousfamilles', 'soussousfamilles', 'unites', 'fournisseurs', 'clients', 'tags'));
    }

    public function artfour() {
        $this->layout = null;
        $this->loadModel('Article');
        $this->loadModel('Fournisseur');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Importation');
        $this->loadModel('Deviprospect');

        $data = $this->request->data; //debug($data);
        //$json = null;
        $fournisseurid = $data['id'];
        $index = $data['index'];
        $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $fournisseurid), false));
        $Articleder = $this->Article->find('first', array('order' => array('Article.id' => 'desc'), false));
        $devise = $fournisseur['Fournisseur']['devise_id'];

        if ($fournisseurid != 0) {
            $art = $this->Deviprospect->query('
            SELECT articles.id id, articles.code codeart, articles.name desart, articles.code refart
            FROM  articles 
            WHERE NOT 
            EXISTS (

            SELECT * 
            FROM articlefournisseurs
            WHERE articles.id = articlefournisseurs.article_id
            )
            UNION 
            SELECT articlefournisseurs.article_id id, articles.code codeart, articles.name desart, articlefournisseurs.reference refart
            FROM articlefournisseurs, articles
            WHERE articlefournisseurs.fournisseur_id =' . $fournisseurid . '
            AND articles.id = articlefournisseurs.article_id');

            //$art= $this->Articlefournisseur->find('all',array('conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid),'recursive'=>0));
            $select = "<select   name='data[Lignereception][" . $index . "][article_id]' table='Lignereception' index='" . $index . "' champ='article_id' id='article_id" . $index . "' class='select form-control idarticle' onchange='tvaart(" . $index . ")'>";
            $select = $select . "<option value=''>veullier choisir</option>";
            foreach ($art as $v) {
                if ($v[0]['codeart'] == $v[0]['refart']) {
                    $v[0]['refart'] = "";
                }
                if ($v[0]['id'] == $Articleder['Article']['id']) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $select = $select . "<option value=" . $v[0]['id'] . " " . $selected . " >" . $v[0]['refart'] . " " . $v[0]['codeart'] . " " . $v[0]['desart'] . "</option>";
            }
            $select = $select . '</select>';
        }
        echo json_encode(array('select' => $select));
        die();
    }

    public function notifBS() {


        $this->layout = null;
        $data = $this->request->data;
        $ds = $data['id'];
        $this->Deviprospect->updateAll(array('Deviprospect.etat' => 2), array('Deviprospect.id' => $ds));

        die;
    }

    public function diplique($id = null, $td = null, $model_ans = null, $ligne_ans = null, $attr = null) {

//        $lien = CakeSession::read('lien_vente');
//        if (!empty($lien)) {
//            foreach ($lien as $k => $liens) {
//                if (@$liens['lien'] == 'devis') {
//                    $x = $liens['add'];
//                }
//            }
//        }
//        if (( $x <> 1) || (empty($lien))) {
//            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
//        }


        $this->loadModel('Lignefacture');
        $this->loadModel('Facture');
        $this->loadModel('Lignereception');
        $this->loadModel('Lignefacture');
        $this->loadModel('Stockdepot');
        $this->loadModel('Commande');
        $this->loadModel('Pointdevente');
        $this->loadModel('Bonreception');
        $this->loadModel('Article');
        $this->loadModel('Lignedeviprospect');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Typedipliquation');
        $this->loadModel('Client');


        if (isset($_GET["id"]) || isset($_GET["td"]) || isset($_GET["model_ans"]) || isset($_GET["ligne_ans"]) || isset($_GET["attr"])) {
            $id = $_GET['id'];
            $td = $_GET['td'];
            $model_ans = $_GET['model_ans'];
            $ligne_ans = $_GET['ligne_ans'];
            $attr = $_GET['attr'];
        }
        //debug($model_ans);
        //debug($ligne_ans);
        $duplication = $this->Typedipliquation->find('first', array('conditions' => array('Typedipliquation.id' => $td)));
        $desg = $duplication['Typedipliquation']['designation'];
        $model = $duplication['Typedipliquation']['name'];
        $ligne = $duplication['Typedipliquation']['ligne'];
        $attr_nv = $duplication['Typedipliquation']['attrb'];


        $this->loadModel($model);
        $this->loadModel($ligne);
        $this->loadModel($model_ans);
        $this->loadModel($ligne_ans);




        if ($this->request->is('post')) {
            //debug($this->request->data);die;

            $this->request->data[$model]['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            $this->request->data[$model]['utilisateur_id'] = CakeSession::read('users');

            $this->request->data[$model]['exercice_id'] = date("Y");

            $this->$model->create();
            if (!empty($this->request->data['Lignefacture'])) {
                if ($this->$model->save($this->request->data)) {
                    $id = $this->$model->id;
                    $this->misejour($model, "add", $id);
                    $stockdepots = array();
                    foreach ($this->request->data['Lignefacture'] as $i => $f) {
                        if ($f['sup'] != 1) {
                            $f[$attr_nv] = $id;
                            $this->$ligne->create();
                            $this->$ligne->save($f);

                            $artfrs = array();
                            $testartfrs = $this->Articlefournisseur->find('first', array('conditions' => array('Articlefournisseur.fournisseur_id' => $this->request->data[$model]['fournisseur_id'], 'Articlefournisseur.article_id' => $f['article_id'])));
                            if (!empty($testartfrs)) {
                                $artfrs['id'] = $testartfrs['Articlefournisseur']['id'];
                            }
                            $artfrs['fournisseur_id'] = $this->request->data[$model]['fournisseur_id'];
                            $artfrs['article_id'] = $f['article_id'];
                            $artfrs['reference'] = @$f['reference'];
                            $artfrs['prix'] = $f['prix'];
                            $this->Articlefournisseur->create();
                            $this->Articlefournisseur->save($artfrs);
                        }
                    }
                    $this->Session->setFlash(__('The devi has been saved'));
                    //$this->redirect(array('action' => 'index'));
                    $this->redirect(array('controller' => $model, 'action' => 'index'));
                } else {
                    $this->Session->setFlash(__('The devi could not be saved. Please, try again.'));
                }
            }
        }


        $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numero) as num')
        ));
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
        $this->loadModel('Importation');
        $entete = $this->$model_ans->find('first', array('conditions' => array($model_ans . '.id' => $id), false));
        //debug($entete);
        $day = date("d/m/Y", strtotime(str_replace('-', '/', $entete[$model_ans]['date'])));
        if ($entete[$model_ans]['importation_id'] != 0) {

            $importations = $this->Importation->find('first', array('conditions' => array('Importation.id' => $entete[$model_ans]['importation_id'], 'Importation.etat' => 0), false));
            $tr = $importations['Importation']['tauxderechenge'];
            $coe = $importations ['Importation']['coefficien'];
        }
        $lignes = $this->$ligne_ans->find('all', array('conditions' => array($ligne_ans . '.' . $attr => $id), 'order' => array($ligne_ans . '.id' => 'ASC')));
        $this->loadModel('Fournisseur');
        if ($entete['Fournisseur']['devise_id'] != 1) {
            $fournisseurs = $this->Fournisseur->find('list');
            $importations = $this->Importation->find('list');
        } else {
            $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1)));
        }
        $this->loadModel('Depot');
        $this->loadModel('Typedipliquation');
        $societe = CakeSession::read('societe');
        if ($societe != 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societe, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        }
        //$articles = $this->Article->find('list', array('conditions' => array('Article.typeetatarticle_id' => 1), 'recursive' => -1));
        $typedipliquations = $this->Typedipliquation->find('list');
        $x = $model;
        $this->set(compact('desg', 'depots', 'articles', 'model', 'importations', 'mm', 'day', 'tr', 'coe', 'entete', 'lignes', 'typeclient_id', 'model_ans', 'ligne_ans', 'ligne', 'x', 'typedipliquations'));
    }

    public function recup_pointdevente($soc = null) {
        $this->loadModel('Pointdevente');
        $this->layout = null;
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $soc)));
        $this->set(compact('pointdeventes'));
    }

}
