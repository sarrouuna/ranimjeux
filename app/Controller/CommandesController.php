<?php

App::uses('AppController', 'Controller');

/**
 * Commandes Controller
 *
 * @property Commande $Commande
 */
class CommandesController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandes') {
                    $commande = 1;
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel('Validite');
        $this->loadModel('Exercice');
        $this->loadModel('Typedipliquation');
        $this->loadModel('Societe');
        $this->loadModel('Pointdevente');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $cond4 = 'Commande.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        //debug($p);die;
        if ($p > 0) {
            // debug($p);die;
            $pv = 'Commande.pointdevente_id = ' . $p;
        }
        $condtransfert = 'Commande.validite_id !=3';
        $veriff = 0;
        $users = CakeSession::read('users');
        $ppv = CakeSession::read('pointdevente');
//        $soc = CakeSession::read('soc');
        $socc = CakeSession::read('soc');
        $pvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id in (' . $socc . ')')));
        $liste_pv = '0';
        foreach ($pvs as $one_pv) {
            if (!empty($one_pv['Pointdevente']['id'])) {
                $liste_pv = $liste_pv . ',' . $one_pv['Pointdevente']['id'];
            }
        }
        $cond6 = 'Commande.pointdevente_id in (' . $liste_pv . ')';
//        $cond1 = 'Commande.date >= ' . "'" . date('Y-m-d') . "'";
//        $cond2 = 'Commande.date <= ' . "'" . date('Y-m-d') . "'";
//        $date1 = date('Y-m-d');
//        $date2 = date('Y-m-d');
        $limit = 100;
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Commandes"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Recherche']);
            } else {
                $this->request->data['Recherche'] = CakeSession::read('recherche');
            }
            if ($this->request->data['Recherche']['verif'] == 1) {
                $condtransfert = '';
                $veriff = 1;
            }
            // debug($this->request->data);die;
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $cond4 = 'Commande.exercice_id =' . $exercices[$exerciceid];
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $cond1 = 'Commande.date >= ' . "'" . $date1 . "'";
                $condtransfert = '';
                $cond4 = '';
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $cond2 = 'Commande.date <= ' . "'" . $date2 . "'";
                $condtransfert = '';
                $cond4 = '';
            }

            if ($this->request->data['Recherche']['fournisseur_id']) {
                $fournisseurid = $this->request->data['Recherche']['fournisseur_id'];
                $cond3 = 'Commande.fournisseur_id =' . $fournisseurid;
                $condtransfert = '';
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
                $cond6 = 'Commande.pointdevente_id in (' . $ch_pv . ')';
                $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societe_id)));
            }


            if ($this->request->data['Recherche']['pointdevente_id']) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                $cond7 = 'Commande.pointdevente_id =' . $pointdevente_id;
            }





            if ($this->request->data['Recherche']['verif'] == 1) {
                //$exerciceid=$exe;

                $fournisseurid = '';
                $date2 = '';
                $date1 = '';
                $condtransfert = '';
                $veriff = 1;
                @$cond1 = '';
                @$cond2 = '';
                @$cond3 = '';
                $cond4 = 'Commande.exercice_id =' . date('Y');
                @$cond6 = '';
                @$cond7 = '';
                $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => date('Y'))));
                $this->request->data['Recherche']['fournisseur_id'] = '';
                $this->request->data['Recherche']['date2'] = '';
                $this->request->data['Recherche']['date1'] = '';
                $exerciceid = $exercice['Exercice']['id'];
            }
            $limit = 100000;
        }
        $commandes = $this->Commande->find('all', array(
            'conditions' => array(@$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, $condtransfert),
            'limit' => $limit,
            'order' => array('Commande.id' => 'desc')
        ));

//        $societes = $this->Societe->find('list', array('conditions' => array('Societe.id in (' . $soc . ')')));
        $validites = $this->Validite->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1,
                'Fournisseur.societe' => $composantsoc)));
        $typedipliquations = $this->Typedipliquation->find('list', array('fields' => array('Typedipliquation.designation'), 'conditions' => array('Typedipliquation.id in (5,6)')));
        $soc = CakeSession::read('soc');
        $sos = explode(',', $soc);
        $countsos = count($sos);
        if ($countsos > 1) {
            $societes = $this->Societe->find('list', array(
                'conditions' => array('Societe.id in' => $sos)
            ));
        }
//        if ($date1) {
//            $this->request->data['Recherche']['date1'] = date("d/m/Y", strtotime(str_replace('/', '-', $date1)));
//        }
//        if ($date2) {
//            $this->request->data['Recherche']['date2'] = date("d/m/Y", strtotime(str_replace('/', '-', $date2)));
//        }
        $this->set(compact('countsos', 'typedipliquations', 'exercices', 'societes', 'societes', 'pointdeventes', 'pointdevente_id', 'ppv', 'societe_id', 'veriff', 'exerciceid', 'date1', 'date2', 'fournisseurid', 'validiteid', 'validites', 'fournisseurs', 'commandes'));
    }

    public function validite($id = null) {
        $this->Commande->updateAll(array('Commande.validite_id' => 2), array('Commande.id' => $id));
        $this->redirect(array('controller' => 'commandes', 'action' => 'index'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandes') {
                    $commande = 1;
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignecommande');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Article');
        $this->loadModel('Importation');
        $this->loadModel('Depot');
        if (!$this->Commande->exists($id)) {
            throw new NotFoundException(__('Invalid commande'));
        }
        $options = array('conditions' => array('Commande.' . $this->Commande->primaryKey => $id));
        $this->request->data = $this->Commande->find('first', $options);
        //debug($this->request->data);

        $day = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Commande']['date'])));
        $lignecommandes = $this->Lignecommande->find('all', array('conditions' => array('Lignecommande.commande_id' => $id)));
        if ($this->request->data['Commande']['importation_id'] != 0) {
            $importations = $this->Importation->find('list', array('conditions' => array('Importation.fournisseur_id' => $this->request->data['Commande']['fournisseur_id'], 'Importation.etat' => 0), false));
            $tr = $this->request->data['Importation']['tauxderechenge'];
            $coe = $this->request->data['Importation']['coefficien'];
        }
        if ($this->request->data['Fournisseur']['devise_id'] != 1) {
            $fournisseurs = $this->Commande->Fournisseur->find('list');
        } else {
            $fournisseurs = $this->Commande->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1)));
        }
        $articles = $this->Article->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));

        $this->set(compact('depots', 'importations', 'coe', 'tr', 'articles', 'fournisseurs', 'lignecommandes', 'articles', 'day', 'fournis'));
    }

    public function exp_etatexcel($id = null) {
        $this->layout = null;
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandes') {
                    $commande = $liens['imprimer'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Lignecommande');
        if (!$this->Commande->exists($id)) {
            throw new NotFoundException(__('Invalid devi'));
        }
        $options = array('conditions' => array('Commande.' . $this->Commande->primaryKey => $id));
        $this->set('commande', $this->Commande->find('first', $options));
        $lignecommandes = $this->Lignecommande->find('all', array(
            'conditions' => array('Lignecommande.commande_id' => $id)
        ));
        // debug($deviprospect);
        $this->set(compact('lignecommandes'));
    }

    public function imprimer($id = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandes') {
                    $commande = $liens['imprimer'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignecommande');
        if (!$this->Commande->exists($id)) {
            throw new NotFoundException(__('Invalid commande'));
        }
        $lignecommandes = $this->Lignecommande->find('all', array(
            'conditions' => array('Lignecommande.commande_id' => $id)
        ));


        $commande = $this->Commande->find('first', array('conditions' => array('Commande.id' => $id)));
        $lignefactureclientstva = $this->Lignecommande->find('all', array('fields' => array(
                'SUM(Lignecommande.totalht*Lignecommande.tva)/100  mtva'
                , 'SUM(Lignecommande.totalht) totalht'
                , 'AVG(Lignecommande.tva) tva'),
            'conditions' => array('Lignecommande.commande_id' => $id)
            , 'group' => array('Lignecommande.tva')
        ));
        $this->set(compact('lignefactureclientstva', 'commande', 'lignecommandes'));
    }

    public function imprimerdevise($id = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandes') {
                    $commande = $liens['imprimer'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignecommande');
        if (!$this->Commande->exists($id)) {
            throw new NotFoundException(__('Invalid commande'));
        }
        $lignecommandes = $this->Lignecommande->find('all', array(
            'conditions' => array('Lignecommande.commande_id' => $id)
        ));


        $commande = $this->Commande->find('first', array('conditions' => array('Commande.id' => $id)));
        //debug($commande);die;
        $this->set(compact('commande', 'lignecommandes'));
    }

    public function imprimerinternationnal($id = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandes') {
                    $commande = $liens['imprimer'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignecommande');
        if (!$this->Commande->exists($id)) {
            throw new NotFoundException(__('Invalid commande'));
        }
        $lignecommandes = $this->Lignecommande->find('all', array(
            'conditions' => array('Lignecommande.commande_id' => $id)
        ));


        $commande = $this->Commande->find('first', array('conditions' => array('Commande.id' => $id)));
        //debug($commande);die;
        $this->set(compact('commande', 'lignecommandes'));
    }

    public function add() {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandes') {
                    $commande = $liens['add'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Article');
        $this->loadModel('Pointdevente');
        $this->loadModel('Lignecommande');
        $this->loadModel('Fournisseur');
        $this->loadModel('Depot');
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Commande']['dateliv'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commande']['dateliv'])));
            $this->request->data['Commande']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commande']['date'])));
            if (empty($this->request->data['Commande']['pointdevente_id'])) {
                $this->request->data['Commande']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Commande']['exercice_id'] = date("Y");
            $this->request->data['Commande']['utilisateur_id'] = CakeSession::read('users');


            $numero = $this->Commande->find('all', array('fields' => array('MAX(Commande.numeroconca) as num')
                , 'conditions' => array('Commande.exercice_id' => date("Y"))));
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//         $getexercice= $this->Commande->find('first',array('conditions'=>array('Commande.numeroconca'=>$n)));
//         $anne=$getexercice['Commande']['exercice_id'];  
//       if ($anne==date("Y")){   
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }  
            } else {
                $mm = "000001";
            }



            $this->request->data['Commande']['numeroconca'] = $mm;
            $this->request->data['Commande']['numero'] = $mm;
            $this->Commande->create();
            if ($this->Commande->save($this->request->data)) {
                $commandeid = $this->Commande->id;
                $this->misejour("Commande", "add", $commandeid);

                foreach ($this->request->data['Lignereception'] as $i => $lc) {
                    if ($lc['sup'] != 1) {
                        $lc['commande_id'] = $commandeid;
                        $lc['totalht'] = ($lc['prixhtva'] * (1 - @$lc['remise'] * 0.01)) * $lc['quantite'];
                        $lc['totalttc'] = ((($lc['totalht']) * (1 + (@$lc['fodec'] * 0.01))) * (1 + ($lc['tva'] * 0.01)));
                        $this->Lignecommande->create();
                        $this->Lignecommande->save($lc);
                    }
                }
                $this->Session->setFlash(__('The commande has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The commande could not be saved. Please, try again.'));
            }
        }

        $numero = $this->Commande->find('all', array('fields' => array('MAX(Commande.numeroconca) as num')
            , 'conditions' => array('Commande.exercice_id' => date("Y"))));
        //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        if (!empty($n)) {
//         $getexercice= $this->Commande->find('first',array('conditions'=>array('Commande.numeroconca'=>$n)));
//         $anne=$getexercice['Commande']['exercice_id'];  
//       if ($anne==date("Y")){   
            $lastnum = $n;
            $nume = intval($lastnum) + 1;
            $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }  
        } else {
            $mm = "000001";
        }
        $p = CakeSession::read('pointdevente');
        $societe = CakeSession::read('societe');
        if ($societe != 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societe, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        }

        $articles = '';
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1)));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('depots', 'pointdeventes', 'p', 'fournisseurs', 'mm', 'numspecial', 'articles'));
    }

    public function addfromdevis($id = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandes') {
                    $commande = $liens['add'];
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
        $this->loadModel('Deviprospect');
        $this->loadModel('Pointdevente');
        $this->loadModel('Lignecommande');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Compte');
        $this->loadModel('Pointdevente');
        if ($this->request->is('post') || $this->request->is('put')) {
            // debug( $this->request->data);die;
            $this->request->data['Commande']['dateliv'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commande']['dateliv'])));
            $this->request->data['Commande']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commande']['date'])));
            $this->request->data['Commande']['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data['Commande']['pointdevente_id'])) {
                $this->request->data['Commande']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Commande']['exercice_id'] = date("Y");
            $this->request->data['Commande']['deviprospect_id'] = $id;
            if ($this->Commande->save($this->request->data)) {
                $commandeid = $this->Commande->id;
                $this->misejour("Commande", "add", $commandeid);
                $this->Deviprospect->updateAll(array('Deviprospect.trasfert' => 1), array('Deviprospect.id' => $id));
                $Lignereceptions = array();
                foreach ($this->request->data['Lignedeviprospect'] as $numl => $f) {
                    if ($f['sup'] != 1) {
                        //zeinab
                        if ($this->request->data['devise'] == 1) {
                            $Lignefactures['prixachatans'] = $f['prixachatans'];
                            $Lignefactures['margeans'] = $f['margeans'];

                            $Lignereceptions['commande_id'] = $commandeid;
                            $Lignereceptions['article_id'] = $f['article_id'];
                            $Lignereceptions['quantite'] = $f['quantite'];
                            if (!empty($f['prix'])) {
                                $Lignereceptions['prix'] = $f['prix'];
                                $Lignereceptions['prix_anc'] = $f['prix_anc'];
                            }
                            $Lignereceptions['reference'] = $f['reference'];
                            $Lignereceptions['prixhtva'] = $f['prixhtva'];
                            $Lignereceptions['remise'] = @$f['remise'];
                            $Lignereceptions['fodec'] = @$f['fodec'];
                            $Lignereceptions['tva'] = $f['tva'];
                            $Lignereceptions['prixhtva'] = $f['prixhtva'];
                            $Lignereceptions['totalht'] = ($f['prixhtva'] / (1 + @$f['tva'] / 100)) * $f['quantite'];
                            $Lignereceptions['totalttc'] = $f['prixhtva'] * $f['quantite'];
                            $this->Lignecommande->create();
                            $this->Lignecommande->save($Lignereceptions);
                        }
                        if ($this->request->data['devise'] != 1) {
                            $f['commande_id'] = $commandeid;
                            $this->Lignecommande->create();
                            $this->Lignecommande->save($f);
                        }
                        $artfrs = array();
                        $testartfrs = $this->Articlefournisseur->find('first', array('conditions' => array('Articlefournisseur.fournisseur_id' => $this->request->data['Commande']['fournisseur_id'], 'Articlefournisseur.article_id' => $f['article_id'])));
                        if (!empty($testartfrs)) {
                            $artfrs['id'] = $testartfrs['Articlefournisseur']['id'];
                        }
                        $artfrs['fournisseur_id'] = $this->request->data['Commande']['fournisseur_id'];
                        $artfrs['article_id'] = $f['article_id'];
                        $artfrs['reference'] = $f['reference'];
                        $artfrs['prix'] = $f['prix'];
                        $this->Articlefournisseur->create();
                        $this->Articlefournisseur->save($artfrs);
                    }
                }
                $this->Session->setFlash(__('The bonreception has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The bonreception could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Commande.' . $this->Commande->primaryKey => $id));
            $this->request->data = $this->Commande->find('first', $options);
        }
        $numero = $this->Commande->find('all', array('fields' => array('MAX(Commande.numeroconca) as num')
            , 'conditions' => array('Commande.exercice_id' => date("Y"))));
        //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        if (!empty($n)) {
//         $getexercice= $this->Commande->find('first',array('conditions'=>array('Commande.numeroconca'=>$n)));
//         $anne=$getexercice['Commande']['exercice_id'];  
//       if ($anne==date("Y")){   
            $lastnum = $n;
            $nume = intval($lastnum) + 1;
            $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }  
        } else {
            $mm = "000001";
        }
        $devis = $this->Deviprospect->find('first', array('recursive' => 0, 'conditions' => array('Deviprospect.id' => $id)));
        //debug($devis);
        $day = date("d/m/Y", strtotime(str_replace('/', '-', $devis['Deviprospect']['date'])));
        $importations = $this->Importation->find('list', array('conditions' => array('Importation.fournisseur_id' => $devis['Deviprospect']['fournisseur_id'], 'Importation.etat' => 0), false));
        $importation = $this->Importation->find('first', array('recursive' => -1, 'conditions' => array('Importation.id' => $devis['Deviprospect']['importation_id'])));
        if ($devis['Deviprospect']['importation_id'] != 0) {
            $tr = $importation['Importation']['tauxderechenge'];
            $coe = $importation['Importation']['coefficien'];
            $tot_coe = $tr * $coe;
        }
        $importation = $devis['Deviprospect']['importation_id'];
        $fr = $devis['Deviprospect']['fournisseur_id'];
        $depot = $devis['Deviprospect']['depot_id'];
        $remise = $devis['Deviprospect']['remise'];
        $tva = $devis['Deviprospect']['tva'];
        $fodec = $devis['Deviprospect']['fodec'];
        $totalht = $devis['Deviprospect']['totalht'];
        $totalttc = $devis['Deviprospect']['totalttc'];
        $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $devis['Deviprospect']['fournisseur_id']), false));
        $devise = $fournisseur['Fournisseur']['devise_id'];
        $lignedeviprospects = $this->Lignedeviprospect->find('all', array('conditions' => array('Lignedeviprospect.deviprospect_id' => $id), 'order' => array('Lignedeviprospect.id' => 'asc')));
//        $art = $this->Deviprospect->query('
//        SELECT articles.id id, articles.code codeart, articles.name desart, articles.code refart
//        FROM  articles 
//        WHERE NOT 
//        EXISTS (
//
//        SELECT * 
//        FROM articlefournisseurs
//        WHERE articles.id = articlefournisseurs.article_id
//        )
//        UNION 
//        SELECT articlefournisseurs.article_id id, articles.code codeart, articles.name desart, articlefournisseurs.reference refart
//        FROM articlefournisseurs, articles
//        WHERE articlefournisseurs.fournisseur_id =' . $fr . '
//        AND articles.id = articlefournisseurs.article_id');
//        $articles = array();
//        foreach ($art as $v) {
//            if ($v[0]['codeart'] == $v[0]['refart']) {
//                $v[0]['refart'] = "";
//            }
//            $articles[$v[0]['id']] = $v[0]['refart'] . " " . $v[0]['codeart'] . " " . $v[0]['desart'];
//        }
        $fournisseurs = $this->Deviprospect->Fournisseur->find('list');
        $p = CakeSession::read('pointdevente');
        $societe = CakeSession::read('societe');
        if ($societe != 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societe, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        }
        if (isset($_GET['t'])) {
            $t = 1;
        } else {
            $t = 0;
        }
        //zeinab
        $comptes = $this->Compte->find('list', array('fields' => array('Compte.banque')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('pointdeventes', 'p', 'comptes', 'devis', 'totalttc', 'totalht', 'fodec', 'tva', 'remise', 'tot_coe', 'depot', 'fr', 'importation', 'pointdeventes', 'mm', 'numspecial', 't', 'devise', 'coe', 'tr', 'importations', 'fournisseurs', 'depots', 'lignedeviprospects', 'day', 'articles', 'fournis'));
    }

    public function addfrometatstock($tab = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandes') {
                    $commande = $liens['add'];
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
        $this->loadModel('Deviprospect');
        $this->loadModel('Pointdevente');
        $this->loadModel('Lignecommande');

        $tab = '(' . $tab . '0)';
        //debug($tab);die;
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Commande']['dateliv'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commande']['dateliv'])));
            $this->request->data['Commande']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commande']['date'])));
            if (empty($this->request->data['Commande']['pointdevente_id'])) {
                $this->request->data['Commande']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Commande']['exercice_id'] = date("Y");
            $this->request->data['Commande']['utilisateur_id'] = CakeSession::read('users');
            $numero = $this->Commande->find('all', array('fields' => array('MAX(Commande.numeroconca) as num')));
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
                $getexercice = $this->Commande->find('first', array('conditions' => array('Commande.numeroconca' => $n)));
                $anne = $getexercice['Commande']['exercice_id'];
                if ($anne == date("Y")) {
                    $lastnum = $n;
                    $nume = intval($lastnum) + 1;
                    $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
                } else {
                    $mm = "000001";
                }
            } else {
                $mm = "000001";
            }
            $this->request->data['Commande']['numeroconca'] = $mm;
            $this->request->data['Commande']['numero'] = $mm;
            $this->Commande->create();
            if ($this->Commande->save($this->request->data)) {
                $commandeid = $this->Commande->id;
                $this->misejour("Commande", "add", $commandeid);
                foreach ($this->request->data['Lignereception'] as $i => $lc) {
                    if ($lc['sup'] != 1) {
                        $lc['commande_id'] = $commandeid;
                        $lc['totalht'] = ($lc['prixhtva'] * (1 - @$lc['remise'] * 0.01)) * $lc['quantite'];
                        $lc['totalttc'] = ((($lc['totalht']) * (1 + (@$lc['fodec'] * 0.01))) * (1 + ($lc['tva'] * 0.01)));
                        $this->Lignecommande->create();
                        $this->Lignecommande->save($lc);
                    }
                }
                $this->Session->setFlash(__('The commande has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The commande could not be saved. Please, try again.'));
            }
        } else {
            $articlecommandes = $this->Article->find('all', array('conditions' => array('Article.id in' . $tab)));
        }
        //****************************************************************
        $numero = $this->Commande->find('all', array('fields' => array('MAX(Commande.numeroconca) as num')));
        //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        if (!empty($n)) {
            $getexercice = $this->Commande->find('first', array('conditions' => array('Commande.numeroconca' => $n)));
            $anne = $getexercice['Commande']['exercice_id'];
            if ($anne == date("Y")) {
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            } else {
                $mm = "000001";
            }
        } else {
            $mm = "000001";
        }
        $articles = $this->Article->find('list');
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1)));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $societe = CakeSession::read('societe');
        if ($societe != 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societe, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        }
        $this->set(compact('articlecommandes', 'depots', 'pointdeventes', 'fournisseurs', 'mm', 'numspecial', 'articles'));
    }

    //****************************************************       

    public function edit($id = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandes') {
                    $commande = $liens['edit'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignecommande');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Article');
        $this->loadModel('Importation');
        $this->loadModel('Pointdevente');
        $this->loadModel('Depot');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Compte');
        if (!$this->Commande->exists($id)) {
            throw new NotFoundException(__('Invalid commande'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug( $this->request->data);die;
            $this->request->data['Commande']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commande']['date'])));
            $this->request->data['Commande']['dateliv'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commande']['dateliv'])));
            if ($this->Commande->save($this->request->data)) {
                $this->misejour("Commande", "edit", $id);
                $this->Lignecommande->deleteAll(array('Lignecommande.commande_id' => $id), false);
                foreach ($this->request->data['Lignereception'] as $i => $lc) {
                    if ($lc['sup'] != 1) {
                        //zeinab
                        if ($this->request->data['devise'] == 1) {
                            $Lignefactures['prixachatans'] = $lc['prixachatans'];
                            $Lignefactures['margeans'] = $lc['margeans'];
                            $Lignereceptions['commande_id'] = $id;
                            $Lignereceptions['article_id'] = $lc['article_id'];
                            $Lignereceptions['quantite'] = $lc['quantite'];
                            if (!empty($lc['prix'])) {
                                $Lignereceptions['prix'] = $lc['prix'];
                                $Lignereceptions['prix_anc'] = $lc['prix_anc'];
                            }
                            // $Lignereceptions['reference']=$lc['reference'];
                            $Lignereceptions['prixhtva'] = $lc['prixhtva'];
                            $Lignereceptions['remise'] = @$lc['remise'];
                            $Lignereceptions['fodec'] = @$lc['fodec'];
                            $Lignereceptions['tva'] = $lc['tva'];
                            $Lignereceptions['prixhtva'] = $lc['prixhtva'];
                            $Lignereceptions['totalht'] = ($lc['prixhtva'] / (1 + @$lc['tva'] / 100)) * $lc['quantite'];
                            $Lignereceptions['totalttc'] = $lc['prixhtva'] * $lc['quantite'];
                            $this->Lignecommande->create();
                            $this->Lignecommande->save($Lignereceptions);
                        }
                        if ($this->request->data['devise'] != 1) {
                            $lc['commande_id'] = $id;
                            //$lc['totalht']=($lc['prixhtva']*(1-@$lc['remise']*0.01))*$lc['quantite'];
                            // $lc['totalttc']=((($lc['totalht'])*(1+(@$lc['fodec']*0.01)))*(1+($lc['tva']*0.01)));
                            $this->Lignecommande->create();
                            $this->Lignecommande->save($lc);
                        }
                        if (!empty($lc['prix'])) {
                            $artfrs = array();
                            $testartfrs = $this->Articlefournisseur->find('first', array('conditions' => array('Articlefournisseur.fournisseur_id' => $this->request->data['Commande']['fournisseur_id'], 'Articlefournisseur.article_id' => $lc['article_id'])));
                            if (!empty($testartfrs)) {
                                $artfrs['id'] = $testartfrs['Articlefournisseur']['id'];
                            }
                            $artfrs['fournisseur_id'] = $this->request->data['Commande']['fournisseur_id'];
                            $artfrs['article_id'] = $lc['article_id'];
                            $artfrs['reference'] = $lc['reference'];
                            $artfrs['prix'] = $lc['prix'];
                            $this->Articlefournisseur->create();
                            $this->Articlefournisseur->save($artfrs);
                        }
                    }
                }
                $this->Session->setFlash(__('The commande has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The commande could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Commande.' . $this->Commande->primaryKey => $id));
            $this->request->data = $this->Commande->find('first', $options);
            //debug($this->request->data);
            $dateliv = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Commande']['dateliv'])));
            $day = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Commande']['date'])));
            $lignecommandes = $this->Lignecommande->find('all', array('conditions' => array('Lignecommande.commande_id' => $id), 'order' => array('Lignecommande.id' => 'asc')));
            if ($this->request->data['Commande']['importation_id'] != 0) {
                $importations = $this->Importation->find('list', array('conditions' => array('Importation.fournisseur_id' => $this->request->data['Commande']['fournisseur_id'], 'Importation.etat' => 0), false));
                $tr = $this->request->data['Importation']['tauxderechenge'];
                $coe = $this->request->data['Importation']['coefficien'];
            }
            if ($this->request->data['Fournisseur']['devise_id'] != 1) {
                $fournisseurs = $this->Commande->Fournisseur->find('list');
            } else {
                $fournisseurs = $this->Commande->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1)));
            }
            //$articles = $this->Article->find('list');
        }
        //zeinab
        $comptes = $this->Compte->find('list', array('fields' => array('Compte.banque')));
        $p = CakeSession::read('pointdevente');
        $societe = CakeSession::read('societe');
        if ($societe != 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societe, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        }
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('pointdeventes', 'comptes', 'dateliv', 'depots', 'p', 'importations', 'coe', 'tr', 'articles', 'fournisseurs', 'lignecommandes', 'articles', 'day', 'fournis'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandes') {
                    $commande = $liens['delete'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignecommande');
        $this->Commande->id = $id;
        if (!$this->Commande->exists()) {
            throw new NotFoundException(__('Invalid commande'));
        }
        $this->request->onlyAllow('post', 'delete');

        $this->Lignecommande->deleteAll(array('Lignecommande.Commande_id' => $id), false);
        $abcd = $this->Commande->find('first', array('conditions' => array('Commande.id' => $id), 'recursive' => -1));
        $numansar = $abcd['Commande']['numero'];

        if ($this->Commande->delete()) {
            $this->misejour("Commande", $numansar, $id);
            $this->Session->setFlash(__('Commande deleted'));
            CakeSession::write('view', "delete");
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Commande was not deleted'));
        //$this->redirect(array('action' => 'index'));
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandes') {
                    $commande = $liens['imprimer'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel('Exercice');
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Commande.pointdevente_id = ' . $p;
        }
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $cond4 = 'Commande.exercice_id =' . $exe;

        $users = CakeSession::read('users');
        $ppv = CakeSession::read('pointdevente');
        $soc = CakeSession::read('soc');
        //debug($this->request->query);die;
        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.id' => $exerciceid)));
            $cond4 = 'Commande.exercice_id =' . $exercice['Exercice']['name'];
        }
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Commande.date >= ' . "'" . $date1 . "'";
            $condtransfert = '';
            $cond4 = '';
        }
        if ($this->request->query['veriff'] == 0) {
            $condtransfert = 'Commande.validite_id !=3';
        } else if ($this->request->query['veriff'] == 1) {
            $condtransfert = '';
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Commande.date <= ' . "'" . $date2 . "'";
            $condtransfert = '';
            $cond4 = '';
        }

        if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Commande.fournisseur_id =' . $fournisseurid;
            $condtransfert = '';
        }

        $this->loadModel('Utilisateur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $this->loadModel('Personnel');
        if ($this->request->query['societe_id']) {
            $societe_id = $this->request->query['societe_id'];
            $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
            $ch_pv = 0;
            foreach ($lespvs as $lespv) {
                $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
            }
            $cond6 = 'Commande.pointdevente_id in (' . $ch_pv . ')';
        }

        if ($this->request->query['pointdevente_id']) {
            $pointdevente_id = $this->request->query['pointdevente_id'];
            $cond7 = 'Commande.pointdevente_id =' . $pointdevente_id;
        }


        $commandes = $this->Commande->find('all', array('conditions' => array(@$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, @$pv, @$condtransfert)));

        //debug($commandes);die;
        $this->set(compact('commandes', 'date1', 'date2', 'fournisseurid', 'validiteid'));
    }
    
    //********** zeinab **********//
     public function imprimerexcel() {
        $lien = CakeSession::read('lien_achat');
        $commande = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandes') {
                    $commande = $liens['imprimer'];
                }
            }
        }
        if (( $commande <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
         $this->layout='';
        $this->loadModel('Fournisseur');
        $this->loadModel('Exercice');
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Commande.pointdevente_id = ' . $p;
        }
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $cond4 = 'Commande.exercice_id =' . $exe;

        $users = CakeSession::read('users');
        $ppv = CakeSession::read('pointdevente');
        $soc = CakeSession::read('soc');
        //debug($this->request->query);die;
        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.id' => $exerciceid)));
            $cond4 = 'Commande.exercice_id =' . $exercice['Exercice']['name'];
        }
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Commande.date >= ' . "'" . $date1 . "'";
            $condtransfert = '';
            $cond4 = '';
        }
        if ($this->request->query['veriff'] == 0) {
            $condtransfert = 'Commande.validite_id !=3';
        } else if ($this->request->query['veriff'] == 1) {
            $condtransfert = '';
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Commande.date <= ' . "'" . $date2 . "'";
            $condtransfert = '';
            $cond4 = '';
        }

        if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Commande.fournisseur_id =' . $fournisseurid;
            $condtransfert = '';
        }

        $this->loadModel('Utilisateur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $this->loadModel('Personnel');
        if ($this->request->query['societe_id']) {
            $societe_id = $this->request->query['societe_id'];
            $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
            $ch_pv = 0;
            foreach ($lespvs as $lespv) {
                $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
            }
            $cond6 = 'Commande.pointdevente_id in (' . $ch_pv . ')';
        }

        if ($this->request->query['pointdevente_id']) {
            $pointdevente_id = $this->request->query['pointdevente_id'];
            $cond7 = 'Commande.pointdevente_id =' . $pointdevente_id;
        }


        $commandes = $this->Commande->find('all', array('conditions' => array(@$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, @$pv, @$condtransfert)));

        //debug($commandes);die;
        $this->set(compact('commandes', 'date1', 'date2', 'fournisseurid', 'validiteid'));
    }

}
