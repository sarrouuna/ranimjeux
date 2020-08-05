<?php

App::uses('AppController', 'Controller');

class FactureavoirfrsController extends AppController {

    public function addlibre() {
         $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirfrs') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Factureavoirfr');
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Depot');
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureavoirfr');
        $this->loadModel('Lignefacture');
        $this->loadModel('Facture');
        $this->loadModel('Pointdevente');
        $this->loadModel('Bonreception');
        $this->loadModel('Lignereception');
        if ($this->request->is('post')) {

            $this->request->data['Factureavoirfr']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoirfr']['date'])));
            $this->request->data['Factureavoirfr']['datedeclaration'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoirfr']['datedeclaration'])));
            $this->request->data['Factureavoirfr']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureavoirfr']['typefacture_id'] = 1;
            $this->request->data['Factureavoirfr']['libre'] = 1;
            if (empty($this->request->data['Factureavoirfr']['pointdevente_id'])) {
                $this->request->data['Factureavoirfr']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Factureavoirfr']['exercice_id'] = date("Y");
            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Factureavoirfr']['pointdevente_id'];
            }
            $numero = $this->Factureavoirfr->find('all', array('fields' => array('MAX(Factureavoirfr.numeroconca) as num'),
                'conditions' => array('Factureavoirfr.pointdevente_id' => $pv, 'Factureavoirfr.exercice_id' => date("Y")))
            );
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
            $this->request->data['Factureavoirfr']['numeroconca'] = $mm;
            $this->request->data['Factureavoirfr']['numero'] = $numspecial;
            //$this->request->data['Factureavoirfr']['montant_regle'] = $this->request->data['Factureavoirfr']['totalttc'];
            $depot = $this->request->data['Factureavoirfr']['depot_id'];
//            debug($this->request->data);
//            die;
            $this->Factureavoirfr->create();
            if ($this->Factureavoirfr->save($this->request->data)) {
                $id = $this->Factureavoirfr->id;
                $this->misejour("Factureavoirfr", "add", $id);
                $Lignefactureavoirfrs = array();
                $stockdepots = array();
                if (isset($this->request->data['Lignepiece'])) {
                    foreach ($this->request->data['Lignepiece'] as $numl => $f) {
                        if ($f['sup'] != 1) {
                            if (!empty($f['article_id']) && !empty($f['quantite'])) {
                                $stockdepots[$numl]['depot_id'] = $depot;
                                $stockdepots[$numl]['article_id'] = $f['article_id'];
                                $stockdepots[$numl]['quantite'] = $f['quantite'];
                                $Lignefactureavoirfrs['factureavoirfr_id'] = $id;
                                $Lignefactureavoirfrs['depot_id'] = $depot;
                                $Lignefactureavoirfrs['article_id'] = $f['article_id'];
                                $Lignefactureavoirfrs['quantite'] = $f['quantite'];
                                $Lignefactureavoirfrs['remise'] = $f['remise'];
                                $Lignefactureavoirfrs['tva'] = $f['tva'];
                                $Lignefactureavoirfrs['prix'] = $f['prixhtva'];
                                $Lignefactureavoirfrs['prixnet'] = $f['prixnet'];
                                $Lignefactureavoirfrs['puttc'] = $f['puttc'];
                                $Lignefactureavoirfrs['fodec'] = $f['fodec'];
                                $Lignefactureavoirfrs['totalhtans'] = $f['prixhtva'];
                                $Lignefactureavoirfrs['totalht'] = $f['totalht'];
                                $Lignefactureavoirfrs['totalttc'] = $f['totalttc'];
                                $this->Lignefactureavoirfr->create();
                                $this->Lignefactureavoirfr->save($Lignefactureavoirfrs);
                                    $stckdepot = $this->Stockdepot->find('first', array(
                                        'conditions' => array('Stockdepot.article_id' => $stockdepots[$numl]['article_id'], 'Stockdepot.depot_id' => $depot),
                                        'recursive' => -1
                                    ));
                                    if (!empty($stckdepot)) {
                                        $stockdepots[$numl]['quantite'] = $stckdepot['Stockdepot']['quantite'] - $stockdepots[$numl]['quantite'];
                                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    } else {
                                        $stockdepots[$numl]['quantite'] = 0-$f['quantite'];
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($stockdepots[$numl]);
                                    }
                            }
                        }
                    }
                }
                // Imputation sur des factures
                $this->loadModel('Imputationfactureavoirfr');
                if (!empty($this->request->data['Imputationfacture'])) {
                    foreach ($this->request->data['Imputationfacture'] as $imputation) {
                        if ($imputation['supfac'] != 1) {
                            if ($imputation['facture_id'] != "") {
                                $imputation['factureavoirfr_id'] = $id;
                                $this->Imputationfactureavoirfr->create();
                                if ($this->Imputationfactureavoirfr->save($imputation)) {
                                    $this->Factureavoirfr->updateAll(array('Factureavoirfr.montant_regle ' => 'Factureavoirfr.montant_regle+' . $imputation['montant']), array('Factureavoirfr.id' => $id));
                                    $this->Facture->updateAll(array('Facture.Montant_Regler ' => 'Facture.Montant_Regler+' . $imputation['montant']), array('Facture.id' => $imputation['facture_id']));
                                }
                            }
                        }
                    }
                }
                $this->Session->setFlash(__('The Factureavoirfr has been saved'));
                // $this->redirect(array('controller' => 'bonentres','action' => 'add/'.$id));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Factureavoirfr could not be saved. Please, try again.'));
            }
        }

        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Facture->Fournisseur->find('list', array(
            'conditions' => array('Fournisseur.societe' => $composantsoc)));
        $utilisateurs = $this->Facture->Utilisateur->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $timbre = $this->Facture->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('idfc', 'dep', 'poinvente', 'pointdeventes', 'numspecial', 'fournisseurs', 'utilisateurs', 'timbre', 'depots', 'typefactures', 'mm', 'articles', 'lignefactures', 'facture'));
    }
    
    public function editlibre($id=null) {
         $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirfrs') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Factureavoirfr');
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Depot');
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureavoirfr');
        $this->loadModel('Lignefacture');
        $this->loadModel('Facture');
        $this->loadModel('Pointdevente');
        $this->loadModel('Bonreception');
        $this->loadModel('Lignereception');
        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Factureavoirfr']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoirfr']['date'])));
            $this->request->data['Factureavoirfr']['datedeclaration'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoirfr']['datedeclaration'])));
            $depot = $this->request->data['Factureavoirfr']['depot_id'];
            $numeros = explode('/', $this->request->data['Factureavoirfr']['numero']);
            $this->request->data['Factureavoirfr']['numeroconca'] = $numeros[1];
//            debug($this->request->data);die;
            if ($this->Factureavoirfr->save($this->request->data)) {
                $id = $this->Factureavoirfr->id;
                $this->misejour("Factureavoirfr", "edit", $id);
                
                //**********************************************
                
                $this->loadModel('Imputationfactureavoirfr');
                $imputationfactureavoirs = $this->Imputationfactureavoirfr->find('all', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id), 'recursive' => -1));
//                debug($imputationfactureavoirs);die;
                if (!empty($imputationfactureavoirs)) {
                    foreach ($imputationfactureavoirs as $imputation) {
                        $this->Factureavoirfr->updateAll(array('Factureavoirfr.montant_regle ' => 'Factureavoirfr.montant_regle-' . $imputation['Imputationfactureavoirfr']['montant']), array('Factureavoirfr.id' => $id));
                        $this->Facture->updateAll(array('Facture.Montant_Regler ' => 'Facture.Montant_Regler-' . $imputation['Imputationfactureavoirfr']['montant']), array('Facture.id' => $imputation['Imputationfactureavoirfr']['facture_id']));
                    }
                    $this->Imputationfactureavoirfr->deleteAll(array('Imputationfactureavoirfr.factureavoirfr_id' => $id), false);
                }
                //***************************************Remise à 0 le stock
                $Lignefactureavoirs = $this->Lignefactureavoirfr->find('all', array('conditions' => array('Lignefactureavoirfr.factureavoirfr_id' => $id)));
                foreach ($Lignefactureavoirs as $i => $Lignefactureavoir) {
                    $qte_sorti = $Lignefactureavoir['Lignefactureavoirfr']['quantite'];
                    $stckdepot = $this->Stockdepot->find('first', array(
                        'conditions' => array('Stockdepot.article_id' => $Lignefactureavoir['Lignefactureavoirfr']['article_id'],
                            'Stockdepot.depot_id' => $Lignefactureavoir['Lignefactureavoirfr']['depot_id']), false));
                    if (!empty($stckdepot)) {
                        $qte = $stckdepot['Stockdepot']['quantite'] + $qte_sorti;
                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                    } else {
                        $stkn = array();
                        $stkn['depot_id'] = $Lignefactureavoir['Lignefactureavoirfr']['depot_id'];
                        $stkn['article_id'] = $Lignefactureavoir['Lignefactureavoirfr']['article_id'];
                        $stkn['quantite'] = $qte_sorti;
                        $this->Stockdepot->create();
                        $this->Stockdepot->save($stkn);
                    }
                }
                
                //*********************************************
                $Lignefactureavoirfrs = array();
                $stockdepots = array();
                if (isset($this->request->data['Lignepiece'])) {
                    foreach ($this->request->data['Lignepiece'] as $numl => $f) {
                        if ($f['sup'] != 1) {
                            if (!empty($f['article_id']) && !empty($f['quantite'])) {
                                $stockdepots[$numl]['depot_id'] = $depot;
                                $stockdepots[$numl]['article_id'] = $f['article_id'];
                                $stockdepots[$numl]['quantite'] = $f['quantite'];
                                $Lignefactureavoirfrs['factureavoirfr_id'] = $id;
                                $Lignefactureavoirfrs['id'] = @$f['id'];
                                $Lignefactureavoirfrs['depot_id'] = $depot;
                                $Lignefactureavoirfrs['article_id'] = $f['article_id'];
                                $Lignefactureavoirfrs['quantite'] = $f['quantite'];
                                $Lignefactureavoirfrs['remise'] = $f['remise'];
                                $Lignefactureavoirfrs['tva'] = $f['tva'];
                                $Lignefactureavoirfrs['prix'] = $f['prixhtva'];
                                $Lignefactureavoirfrs['prixnet'] = $f['prixnet'];
                                $Lignefactureavoirfrs['puttc'] = $f['puttc'];
                                $Lignefactureavoirfrs['fodec'] = $f['fodec'];
                                $Lignefactureavoirfrs['totalhtans'] = $f['prixhtva'];
                                $Lignefactureavoirfrs['totalht'] = $f['totalht'];
                                $Lignefactureavoirfrs['totalttc'] = $f['totalttc'];
                                $this->Lignefactureavoirfr->create();
                                $this->Lignefactureavoirfr->save($Lignefactureavoirfrs);
                                
                                //****Mise à jour stock
                                    $stckdepot = $this->Stockdepot->find('first', array(
                                        'conditions' => array('Stockdepot.article_id' => $stockdepots[$numl]['article_id'], 'Stockdepot.depot_id' => $depot),
                                        'recursive' => -1
                                    ));
                                    if (!empty($stckdepot)) {
                                        $stockdepots[$numl]['quantite'] = $stckdepot['Stockdepot']['quantite'] - $stockdepots[$numl]['quantite'];
                                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    } else {
                                        $stockdepots[$numl]['quantite'] = 0-$f['quantite'];
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($stockdepots[$numl]);
                                    }
                            }
                        }else{
                            $this->Lignefactureavoirfr->deleteAll(array('Lignefactureavoirfr.id' => $f['id']), false);
                        }
                    }
                }
                // Imputation sur des factures
                $this->loadModel('Imputationfactureavoirfr');
                if (!empty($this->request->data['Imputationfacture'])) {
                    foreach ($this->request->data['Imputationfacture'] as $imputation) {
                        if ($imputation['supfac'] != 1) {
                            if ($imputation['facture_id'] != "") {
                                $imputation['factureavoirfr_id'] = $id;
                                $this->Imputationfactureavoirfr->create();
                                if ($this->Imputationfactureavoirfr->save($imputation)) {
                                    $this->Factureavoirfr->updateAll(array('Factureavoirfr.montant_regle ' => 'Factureavoirfr.montant_regle+' . $imputation['montant']), array('Factureavoirfr.id' => $id));
                                    $this->Facture->updateAll(array('Facture.Montant_Regler ' => 'Facture.Montant_Regler+' . $imputation['montant']), array('Facture.id' => $imputation['facture_id']));
                                }
                            }
                        }
                    }
                }
                $this->Session->setFlash(__('The Factureavoirfr has been saved'));
                // $this->redirect(array('controller' => 'bonentres','action' => 'add/'.$id));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Factureavoirfr could not be saved. Please, try again.'));
            }
        }else {
            $options = array('conditions' => array('Factureavoirfr.' . $this->Factureavoirfr->primaryKey => $id));
            $this->request->data = $this->Factureavoirfr->find('first', $options);
        }
        $this->loadModel('Imputationfactureavoirfr');
        $listeimputationfactureavoirs = $this->Imputationfactureavoirfr->find('all', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id), 'recursive' => -1));
        if (!empty($listeimputationfactureavoirs)) {
            $fac = '';
            foreach ($listeimputationfactureavoirs as $ad) {
                $fac = $fac . ',' . $ad['Imputationfactureavoirfr']['facture_id'];
            }
        } else {
            $fac = 0;
        }
        $factures = $this->Facture->find('list', array('fields' => array('Facture.numerofrs'), 'conditions' => array('Facture.fournisseur_id' => $this->request->data['Factureavoirfr']['fournisseur_id'], '(Facture.totalttc > Facture.Montant_Regler OR Facture.id in (0' . $fac . '))'), 'recursive' => -1));
        $this->loadModel('Imputationfactureavoirfr');
        $imputationfactureavoirs = $this->Imputationfactureavoirfr->find('all', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id), 'recursive' => -1));
        $lignefactures = $this->Lignefactureavoirfr->find('all', array(
            'conditions' => array('Lignefactureavoirfr.factureavoirfr_id' => $id)
        ));
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Facture->Fournisseur->find('list', array(
            'conditions' => array('Fournisseur.societe' => $composantsoc)));
        $utilisateurs = $this->Facture->Utilisateur->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $timbre = $this->Facture->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('lignefactures','imputationfactureavoirs', 'factures', 'dep', 'poinvente', 'pointdeventes', 'numspecial', 'fournisseurs', 'utilisateurs', 'timbre', 'depots', 'typefactures'));
    }

    public function index() {
        $lien = CakeSession::read('lien_achat');
        $x = "";
//        debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirfrs') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Factureavoirfr->recursive = 0;
        $this->set('factureavoirs', $this->paginate());
        $this->loadModel('Fournisseur');
        $this->loadModel('Typefacture');
        $this->loadModel('Exercice');
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
        $cond5 = 'Factureavoirfr.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Factureavoirfr.pointdevente_id = ' . $p;
        }
        $cond4 = "";
        //$cond1 = 'Factureavoirfr.date >= ' . "'" . date('Y-m-d') . "'";
        //$cond2 = 'Factureavoirfr.date <= ' . "'" . date('Y-m-d') . "'";
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Factureavoirfrs"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Factureavoirfr']);
            } else {
                $this->request->data['Factureavoirfr'] = CakeSession::read('recherche');
            }
            //debug($this->request->data);die;
            if (!empty($this->request->data['Factureavoirfr']['exercice_id'])) {
                $exerciceid = $this->request->data['Factureavoirfr']['exercice_id'];
                $exercicee = $this->Exercice->find('first', array('conditions' => array('Exercice.id' => $exerciceid)));
                $cond5 = 'Factureavoirfr.exercice_id =' . $exercicee['Exercice']['name'];
            }
            if ($this->request->data['Factureavoirfr']['date1'] != "__/__/____") {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoirfr']['date1'])));
                $cond1 = 'Factureavoirfr.date >= ' . "'" . $date1 . "'";
                $cond5 = "";
            }

            if ($this->request->data['Factureavoirfr']['date2'] != "__/__/____") {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoirfr']['date2'])));
                $cond2 = 'Factureavoirfr.date <= ' . "'" . $date2 . "'";
                $cond5 = "";
            }

            if (!empty($this->request->data['Factureavoirfr']['fournisseur_id'])) {
                $clientid = $this->request->data['Factureavoirfr']['fournisseur_id'];
                $cond3 = 'Factureavoirfr.fournisseur_id =' . $clientid;
            }
            if (!empty($this->request->data['Factureavoirfr']['typefacture_id'])) {
                $typefactureid = $this->request->data['Factureavoirfr']['typefacture_id'];
                $cond4 = 'Factureavoirfr.typefacture_id =' . $typefactureid;
            }

            if (!empty($this->request->data['Factureavoirfr']['pointdevente_id'])) {
                $pointdeventeid = $this->request->data['Factureavoirfr']['pointdevente_id'];
                $cond6 = 'Factureavoirfr.pointdevente_id =' . $pointdeventeid;
            }
        }
        $factureavoirs = $this->Factureavoirfr->find('all', array('conditions' => array(@$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6)));
        //debug($factureavoirs);       
        //$fournisseurs = $this->Fournisseur->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Factureavoirfr->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1, 'Fournisseur.societe' => $composantsoc)));

        $typefactures = $this->Typefacture->find('list');
        $this->set(compact('pointdevente_id', 'typefactureid', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'fournisseurs', 'typefactures', 'factureavoirs'));
    }

    public function imprimerexcel() {

        $this->layout = '';
        $this->set('factureavoirs', $this->paginate());
        $this->loadModel('Fournisseur');
        $this->loadModel('Typefacture');
        $this->loadModel('Exercice');
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
        $cond5 = 'Factureavoirfr.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Factureavoirfr.pointdevente_id = ' . $p;
        }
        $cond4 = "";
        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.id' => $exerciceid)));
            $cond5 = 'Factureavoirfr.exercice_id ="' . $exercice['Exercice']['name'] . '"';
        }
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Factureavoirfr.date >= ' . "'" . $date1 . "'";
            $condtransfert = '';
            $cond4 = '';
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Factureavoirfr.date <= ' . "'" . $date2 . "'";
            $condtransfert = '';
            $cond4 = '';
        }

        if (!empty($this->request->query['fournisseurid'])) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Factureavoirfr.fournisseur_id =' . $fournisseurid;
        }

        if (!empty($this->request->query['typefactureid'])) {
            $typefactureid = $this->request->query['typefactureid'];
            $cond4 = 'Factureavoirfr.typefacture_id =' . $typefactureid;
        }
        if (!empty($this->request->query['pointdevente_id'])) {
            $pointdeventeid = $this->request->query['pointdevente_id'];
            $cond6 = 'Factureavoirfr.pointdevente_id =' . $pointdeventeid;
        }

        $factureavoirs = $this->Factureavoirfr->find('all', array('conditions' => array(@$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6)));
        $this->set(compact('pointdevente_id', 'typefactureid', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'fournisseurs', 'typefactures', 'factureavoirs'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirfrs') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefactureavoirfr');
        if (!$this->Factureavoirfr->exists($id)) {
            throw new NotFoundException(__('Invalid factureclient'));
        }
        $options = array('conditions' => array('Factureavoirfr.' . $this->Factureavoirfr->primaryKey => $id));
        $this->set('factureclient', $this->Factureavoirfr->find('first', $options));
        $lignefactureclients = $this->Lignefactureavoirfr->find('all', array(
            'conditions' => array('Lignefactureavoirfr.factureavoirfr_id' => $id)
        ));

        $this->loadModel('Imputationfactureavoirfr');
        $imputationfactureavoirs = $this->Imputationfactureavoirfr->find('all', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id), 'recursive' => 0));
        $this->set(compact('lignefactureclients', 'imputationfactureavoirs', 'factures'));
    }

    public function viewf($id = null) {
        $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirfrs') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefactureavoirfr');
        if (!$this->Factureavoirfr->exists($id)) {
            throw new NotFoundException(__('Invalid factureclient'));
        }
        $options = array('conditions' => array('Factureavoirfr.' . $this->Factureavoirfr->primaryKey => $id));
        $this->set('factureclient', $this->Factureavoirfr->find('first', $options));
        $lignefactureclients = $this->Lignefactureavoirfr->find('all', array(
            'conditions' => array('Lignefactureavoirfr.factureavoirfr_id' => $id)
        ));
        $this->loadModel('Tva');
        $tvas = $this->Tva->find('all');

        $this->loadModel('Imputationfactureavoirfr');
        $imputationfactureavoirs = $this->Imputationfactureavoirfr->find('all', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id), 'recursive' => 0));
        $this->set(compact('lignefactureclients', 'imputationfactureavoirs', 'factures', 'tvas'));
    }

    public function add() {
        $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirfrs') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Stockdepot');
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureavoirfr');
        $this->loadModel('Facture');
        $this->loadModel('Pointdevente');
        $this->loadModel('Tva');
        if ($this->request->is('post')) {
//            debug($this->request->data);
//            die;
            $this->request->data['Factureavoirfr']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoirfr']['date'])));
            $this->request->data['Factureavoirfr']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureavoirfr']['typefacture_id'] = 2; //modifier 19/04/2016

            if (empty($this->request->data['Factureavoirfr']['pointdevente_id'])) {
                $this->request->data['Factureavoirfr']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Factureavoirfr']['exercice_id'] = date("Y");
            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Factureavoirfr']['pointdevente_id'];
            }
            $numero = $this->Factureavoirfr->find('all', array('fields' => array('MAX(Factureavoirfr.numeroconca) as num'),
                'conditions' => array('Factureavoirfr.pointdevente_id' => $pv, 'Factureavoirfr.exercice_id' => date("Y")))
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
            $this->request->data['Factureavoirfr']['numeroconca'] = $mm;
            $this->request->data['Factureavoirfr']['numero'] = $numspecial;
            $this->Factureavoirfr->create();
            if ($this->Factureavoirfr->save($this->request->data)) {
                $id = $this->Factureavoirfr->id;
                $this->misejour("Factureavoirfr", "add", $id);
                // Enregistrement des ligne facture avoir
                if (!empty($this->request->data['Lignefactureavoirfr'])) {
                    foreach ($this->request->data['Lignefactureavoirfr'] as $ligne) {
                        $ligne['factureavoirfr_id'] = $id;
                        $this->Lignefactureavoirfr->create();
                        $this->Lignefactureavoirfr->save($ligne);
                    }
                }
                // Imputation sur des factures
                $this->loadModel('Imputationfactureavoirfr');
                if (!empty($this->request->data['Imputationfacture'])) {
                    foreach ($this->request->data['Imputationfacture'] as $imputation) {
                        if ($imputation['supfac'] != 1) {
                            if ($imputation['facture_id'] != "") {
                                $imputation['factureavoirfr_id'] = $id;
                                $this->Imputationfactureavoirfr->create();
                                if ($this->Imputationfactureavoirfr->save($imputation)) {
                                    $this->Factureavoirfr->updateAll(array('Factureavoirfr.montant_regle ' => 'Factureavoirfr.montant_regle+' . $imputation['montant']), array('Factureavoirfr.id' => $id));
                                    $this->Facture->updateAll(array('Facture.Montant_Regler ' => 'Facture.Montant_Regler+' . $imputation['montant']), array('Facture.id' => $imputation['facture_id']));
                                }
                            }
                        }
                    }
                }
                $this->Session->setFlash(__('The factureavoir has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The factureavoir could not be saved. Please, try again.'));
            }
        }
        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {

            $numero = $this->Factureavoirfr->find('all', array('fields' => array('MAX(Factureavoirfr.numeroconca) as num'),
                'conditions' => array('Factureavoirfr.pointdevente_id' => $pv, 'Factureavoirfr.exercice_id' => date("Y")))
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
        } else {
            $mm = 0;
        }
        //$articles = $this->Article->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Factureavoirfr->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1, 'Fournisseur.societe' => $composantsoc)));
        //$fournisseurs = $this->Factureavoirfr->Fournisseur->find('list');
        $utilisateurs = $this->Factureavoirfr->Utilisateur->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $typefactures = $this->Factureavoirfr->Typefacture->find('list');
        $timbre = $this->Factureavoirfr->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $tvas = $this->Tva->find('all');
        $this->set(compact('tvas', 'fournisseurs', 'pointdeventes', 'numspecial', 'clients', 'utilisateurs', 'timbre', 'depots', 'typefactures', 'mm', 'articles'));
    }

    public function addfactureavoir() {
//        $lien = CakeSession::read('lien_achat');
//        $x = "";
//        //debug($lien);die;
//        if (!empty($lien)) {
//            foreach ($lien as $k => $liens) {
//                if (@$liens['lien'] == 'factureavoirfrs') {
//                    $x = $liens['add'];
//                }
//            }
//        }
//        if (( $x <> 1) || (empty($lien))) {
//            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
//        }
        $this->loadModel('Factureavoirfr');
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Depot');
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureavoirfr');
        $this->loadModel('Lignefacture');
        $this->loadModel('Facture');
        $this->loadModel('Pointdevente');
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Factureavoirfr']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoirfr']['date'])));
            $this->request->data['Factureavoirfr']['utilisateur_id'] = CakeSession::read('users');
            //$this->request->data['Factureavoir']['typefacture_id']=2;//modifier 19/04/2016
//                     if($this->request->data['Factureavoirfr']['typefacture_id']==2){
//                        $this->request->data['Factureavoirfr']['totalttc']=$this->request->data['Factureavoirfr']['totalttc']+0.500;         
//                             }
            if (empty($this->request->data['Factureavoirfr']['pointdevente_id'])) {
                $this->request->data['Factureavoirfr']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Factureavoirfr']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Factureavoirfr']['pointdevente_id'];
            }
            $numero = $this->Factureavoirfr->find('all', array('fields' => array('MAX(Factureavoirfr.numeroconca) as num'),
                'conditions' => array('Factureavoirfr.pointdevente_id' => $pv))
            );
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
                $getexercice = $this->Factureavoirfr->find('first', array('conditions' => array('Factureavoirfr.numeroconca' => $n)));
                $anne = $getexercice['Factureavoirfr']['exercice_id'];
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


            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");

            $this->request->data['Factureavoirfr']['numeroconca'] = $mm;
            $this->request->data['Factureavoirfr']['numero'] = $numspecial;

            $this->Factureavoirfr->create();
            if ($this->Factureavoirfr->save($this->request->data)) {
                $id = $this->Factureavoirfr->id;
                $this->misejour("Factureavoirfr", "add", $id);

                $Lignefactureavoirs = array();
                $stockdepots = array();
                if (isset($this->request->data['Lignefactureclient'])) {
                    foreach ($this->request->data['Lignefactureclient'] as $numl => $f) {
                        //  debug($f);die;
                        if ($f['sup'] != 1) {
                            if (!empty($f['depot_id']) && !empty($f['article_id'])) {
                                $stockdepots[$numl]['depot_id'] = $f['depot_id'];
                                $stockdepots[$numl]['article_id'] = $f['article_id'];
                                $stockdepots[$numl]['quantite'] = $f['quantite'];
                                $Lignefactureavoirs['factureavoirfr_id'] = $id;
                                $Lignefactureavoirs['depot_id'] = $f['depot_id'];
                                $Lignefactureavoirs['article_id'] = $f['article_id'];
                                $Lignefactureavoirs['quantite'] = $f['quantite'];
                                $Lignefactureavoirs['remise'] = $f['remise'];
                                $Lignefactureavoirs['tva'] = $f['tva'];
                                $Lignefactureavoirs['prix'] = $f['prixhtva'];
                                $Lignefactureavoirs['prixnet'] = $f['prixnet'];
                                $Lignefactureavoirs['puttc'] = $f['puttc'];
                                $Lignefactureavoirs['totalhtans'] = $f['totalhtans'];
                                $Lignefactureavoirs['totalht'] = ($f['prixhtva'] * (1 - $f['remise'] * 0.01)) * $f['quantite'];
                                $Lignefactureavoirs['totalttc'] = ((($Lignefactureavoirs['totalht'])) * (1 + ($f['tva'] * 0.01)));
                                $this->Lignefactureavoirfr->create();
                                $this->Lignefactureavoirfr->save($Lignefactureavoirs);
                                $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $stockdepots[$numl]['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
                                if (!empty($stckdepot)) {
                                    $stockdepots[$numl]['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] - $stockdepots[$numl]['quantite'];
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                                } else {
                                    $stockdepots[$numl]['quantite'] = (-1) * $stockdepots[$numl]['quantite'];
                                    $stockdepots[$numl]['prix'] = $f['prixhtva'];
                                    $this->Stockdepot->create();
                                    $this->Stockdepot->save($stockdepots[$numl]);
                                }
                                $this->Stockdepot->deleteAll(array('Stockdepot.article_id' => $stockdepots[$numl]['article_id'], 'Stockdepot.depot_id' => $stockdepots[$numl]['depot_id'], 'Stockdepot.quantite' => 0), false);
                            }
                        }
                    }
                }
                $this->Session->setFlash(__('The factureavoir has been saved'));
                // $this->redirect(array('controller' => 'bonentres','action' => 'add/'.$id));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The factureavoir could not be saved. Please, try again.'));
            }
        }
        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {
            $numero = $this->Factureavoirfr->find('all', array('fields' => array('MAX(Factureavoirfr.numeroconca) as num'),
                'conditions' => array('Factureavoirfr.pointdevente_id' => $pv))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
                $getexercice = $this->Factureavoirfr->find('first', array('conditions' => array('Factureavoirfr.numeroconca' => $n)));
                $anne = $getexercice['Factureavoirfr']['exercice_id'];
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

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            $mm = 0;
        }
        //$articles = $this->Article->find('list');
        //$fournisseurs = $this->Factureavoirfr->Fournisseur->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Factureavoirfr->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1, 'Fournisseur.societe' => $composantsoc)));

        $utilisateurs = $this->Factureavoirfr->Utilisateur->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $typefactures = $this->Factureavoirfr->Typefacture->find('list');
        $timbre = $this->Factureavoirfr->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('id', 'pointdeventes', 'numspecial', 'fournisseurs', 'utilisateurs', 'timbre', 'depots', 'typefactures', 'mm', 'articles', 'lignefactureclients', 'Factureclient'));
    }

    public function verifqte() {
        $user = CakeSession::read('users');
        $this->loadModel('Utilisateur');
        $droit = 0;
        $this->layout = null;
        $data = $this->request->data;

        $qte = $data['qte'];
        $index = $data['index'];
        $quantitestock = $data['quantitestock'];
        if (!empty($user)) {

            $ut = $this->Utilisateur->find('first', array(
                'conditions' => array('Utilisateur.id' => $user)));
            $stknegativ = $ut['Utilisateur']['stocknegatif'];

            if ($stknegativ == 1) {
                $droit = 1;
            }

            if ($stknegativ == 0) {
                if ($qte <= $quantitestock) {
                    $droit = 1;
                }
            }
        }
        echo $droit;
    }

    public function addfactavoirfr() {
//        $lien = CakeSession::read('lien_achat');
//        $x = "";
//        //debug($lien);die;
//        if (!empty($lien)) {
//            foreach ($lien as $k => $liens) {
//                if (@$liens['lien'] == 'factureavoirfrs') {
//                    $x = $liens['add'];
//                }
//            }
//        }
//        if (( $x <> 1) || (empty($lien))) {
//            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
//        }
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureavoirfr');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Factureavoirfr']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureclient']['date'])));
            $this->request->data['Factureavoirfr']['utilisateur_id'] = CakeSession::read('users');
            // $this->request->data['Factureavoirfr']['type']= 'direct';
            if (empty($this->request->data['Factureavoirfr']['pointdevente_id'])) {
                $this->request->data['Factureavoirfr']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Factureavoirfr']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Factureavoirfr']['pointdevente_id'];
            }
            $numero = $this->Factureavoirfr->find('all', array('fields' => array('MAX(Factureavoirfr.numeroconca) as num'),
                'conditions' => array('Factureavoirfr.pointdevente_id' => $pv, 'Factureavoirfr.exercice_id' => date("Y")))
            );
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
                //$getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
                //$anne=$getexercice['Factureclient']['exercice_id'];  
                //if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
                //}
                // else {
                // $mm = "000001";
                // }  
            } else {
                $mm = "000001";
            }


            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");

            $this->request->data['Factureavoirfr']['numeroconca'] = $mm;
            $this->request->data['Factureavoirfr']['numero'] = $numspecial;

            $this->Factureavoirfr->create();
            if (!empty($this->request->data['Lignefactureavoirfr'])) {
                if ($this->Factureavoirfr->save($this->request->data)) {
                    $id = $this->Factureavoirfr->id;
                    $this->misejour("Factureavoirfr", "add", $id);

                    $Lignefactureclients = array();
                    $stockdepots = array();

                    foreach ($this->request->data['Lignefactureclient'] as $numl => $f) {

                        //debug($f);die;
                        if ($f['sup'] != 1) {

                            $stockdepots[$numl]['quantite'] = $f['quantite'];
                            $Lignefactureclients['factureavoirfr_id'] = $id;
                            $Lignefactureclients['article_id'] = $this->request->data['Lignefactureclient'][$numl]['article_id'];
                            $f['article_id'] = $this->request->data['Lignefactureclient'][$numl]['article_id'];
                            $Lignefactureclients['depot_id'] = $f['depot_id'];
                            $Lignefactureclients['quantite'] = $f['quantite'];
                            $Lignefactureclients['remise'] = $f['remise'];
                            $Lignefactureclients['tva'] = $f['tva'];
                            $Lignefactureclients['prix'] = $f['prixhtva'];
                            $Lignefactureclients['prixnet'] = $f['prixnet'];
                            $Lignefactureclients['puttc'] = $f['puttc'];
                            $Lignefactureclients['totalhtans'] = $f['totalhtans'];
                            // $Lignefactureclients['designation']=$f['designation'];
                            $Lignefactureclients['totalht'] = ($f['prixhtva'] * (1 - $f['remise'] * 0.01)) * $f['quantite'];
                            $Lignefactureclients['totalttc'] = ((($Lignefactureclients['totalht'])) * (1 + ($f['tva'] * 0.01)));
                            // debug($Lignefactureclients);die;
                            $this->Lignefactureavoirfr->create();
                            $this->Lignefactureavoirfr->save($Lignefactureclients);

                            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
                            if (!empty($stckdepot)) {
                                $stockdepots[$numl]['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] - $stockdepots[$numl]['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                            }
                            $this->Stockdepot->deleteAll(array('Stockdepot.quantite' => 0), false);
                        }
                    }
                    $this->Session->setFlash(__('The Factureclient has been saved'));
                    $this->redirect(array('action' => 'index'));
                    //$this->redirect(array('action' => 'addbonsorti/'.$id));    
                } else {
                    $this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                }
            }
        }
        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {
            $numero = $this->Factureclient->find('all', array('fields' => array('MAX(Factureclient.numeroconca) as num'),
                'conditions' => array('Factureclient.pointdevente_id' => $pv))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
                $getexercice = $this->Factureclient->find('first', array('conditions' => array('Factureclient.numeroconca' => $n)));
                $anne = $getexercice['Factureclient']['exercice_id'];
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

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            $mm = 0;
        }
        $clients = $this->Factureclient->Client->find('list');
        $utilisateurs = $this->Factureclient->Utilisateur->find('list');
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Factureclient->Depot->find('list', array('conditions' => array('Depot.id' => $p)));
        }
        $timbre = $this->Factureclient->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $articles = $this->Article->find('list', array('conditions' => array('Article.typeetatarticle_id' => 1), 'recursive' => -1));
        $this->set(compact('articles', 'pointdeventes', 'clients', 'timbre', 'utilisateurs', 'depots', 'mm', 'numspecial'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirfrs') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Factureavoirfr');
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Depot');
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureavoirfr');
        $this->loadModel('Lignefacture');
        $this->loadModel('Facture');
        $this->loadModel('Pointdevente');
        $this->loadModel('Tva');
        $this->loadModel('Imputationfactureavoirfr');

        if (!$this->Factureavoirfr->exists($id)) {
            throw new NotFoundException(__('Invalid factureclient'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
//            debug($this->request->data);
//            die;
            $this->request->data['Factureavoirfr']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoirfr']['date'])));
            $this->request->data['Factureavoirfr']['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data['Factureavoirfr']['pointdevente_id'])) {
                $this->request->data['Factureavoirfr']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Factureavoirfr']['pointdevente_id'];
            }
            $factureavoirfrsans = $this->Factureavoirfr->find('first', array(
                'conditions' => array('Factureavoirfr.id' => $id),
                'recursive' => -1
            ));
            $totalttcans = $factureavoirfrsans['Factureavoirfr']['totalttc'];
            $this->Facture->updateAll(array('Facture.Montant_Regler ' => 'Facture.Montant_Regler -' . $totalttcans), array('Facture.factureavoirfr_id' => $id));
            if ($this->Factureavoirfr->save($this->request->data)) {
                $this->misejour("Factureavoirfr", "edit", $id);
                //*****************************Remise à l'état initiale : imputation
                $this->loadModel('Imputationfactureavoir');
                $imputationfactureavoirs = $this->Imputationfactureavoirfr->find('all', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id), 'recursive' => -1));
//                debug($imputationfactureavoirs);die;
                if (!empty($imputationfactureavoirs)) {
                    foreach ($imputationfactureavoirs as $imputation) {
                        $this->Factureavoirfr->updateAll(array('Factureavoirfr.montant_regle ' => 'Factureavoirfr.montant_regle-' . $imputation['Imputationfactureavoirfr']['montant']), array('Factureavoirfr.id' => $id));
                        $this->Facture->updateAll(array('Facture.Montant_Regler ' => 'Facture.Montant_Regler-' . $imputation['Imputationfactureavoirfr']['montant']), array('Facture.id' => $imputation['Imputationfactureavoirfr']['facture_id']));
                    }
                    $this->Imputationfactureavoirfr->deleteAll(array('Imputationfactureavoirfr.factureavoirfr_id' => $id), false);
                }
                // Enregistrement des ligne facture avoir
                if (!empty($this->request->data['Lignefactureavoirfr'])) {
                    foreach ($this->request->data['Lignefactureavoirfr'] as $ligne) {
                        $array = array();
                        $ligne['factureavoirfr_id'] = $id;
                        $array['Lignefactureavoirfr'] = $ligne;
                        $this->Lignefactureavoirfr->create();
                        $this->Lignefactureavoirfr->save($array);
                    }
                }
                // Imputation sur des factures
                if (!empty($this->request->data['Imputationfacture'])) {
                    foreach ($this->request->data['Imputationfacture'] as $imputation) {
                        if ($imputation['supfac'] != 1) {
                            if ($imputation['facture_id'] != "") {
                                $imputation['factureavoirfr_id'] = $id;
                                $this->Imputationfactureavoirfr->create();
                                if ($this->Imputationfactureavoirfr->save($imputation)) {
                                    $this->Factureavoirfr->updateAll(array('Factureavoirfr.montant_regle ' => 'Factureavoirfr.montant_regle+' . $imputation['montant']), array('Factureavoirfr.id' => $id));
                                    $this->Facture->updateAll(array('Facture.Montant_Regler ' => 'Facture.Montant_Regler+' . $imputation['montant']), array('Facture.id' => $imputation['facture_id']));
                                }
                            }
                        }
                    }
                }

                $this->Session->setFlash(__('The factureclient has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The factureclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Factureavoirfr.' . $this->Factureavoirfr->primaryKey => $id));
            $this->request->data = $this->Factureavoirfr->find('first', $options);
        }

        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Factureavoirfr->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1, 'Fournisseur.societe' => $composantsoc)));

        $utilisateurs = $this->Factureavoirfr->Utilisateur->find('list');

        $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Factureavoirfr']['date'])));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $typefactures = $this->Factureavoirfr->Typefacture->find('list');
        $this->loadModel('Imputationfactureavoirfr');
        $listeimputationfactureavoirs = $this->Imputationfactureavoirfr->find('all', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id), 'recursive' => -1));
//        debug($listeimputationfactureavoirs);die;
        if (!empty($listeimputationfactureavoirs)) {
            $fac = '';
            foreach ($listeimputationfactureavoirs as $ad) {
                $fac = $fac . ',' . $ad['Imputationfactureavoirfr']['facture_id'];
            }
        } else {
            $fac = 0;
        }
        $factures = $this->Facture->find('list', array('fields' => array('Facture.numerofrs'), 'conditions' => array('Facture.fournisseur_id' => $this->request->data['Factureavoirfr']['fournisseur_id'], '(Facture.totalttc > Facture.Montant_Regler OR Facture.id in (0' . $fac . '))'), 'recursive' => -1));
//        debug($factures);die;
        $this->loadModel('Imputationfactureavoirfr');
        $imputationfactureavoirs = $this->Imputationfactureavoirfr->find('all', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id), 'recursive' => -1));
        $tvas = $this->Tva->find('all');
        $this->set(compact('tvas', 'imputationfactureavoirs', 'factures', 'name', 'typefactures', 'autorisation', 'solde', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'fournisseurs', 'utilisateurs', 'timbre', 'depots', 'date', 'lignefactureclients', 'articles', 'tabqtestock'));
    }

    public function editfactureavoir($id = null) {
        $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirfrs') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Factureavoirfr');
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Depot');
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureavoirfr');
        $this->loadModel('Lignefacture');
        $this->loadModel('Facture');
        $this->loadModel('Pointdevente');
        $this->loadModel('Tva');
        $this->loadModel('Imputationfactureavoirfr');
        $this->loadModel('Bonreception');
        $this->loadModel('Lignereception');

        if (!$this->Factureavoirfr->exists($id)) {
            throw new NotFoundException(__('Invalid factureclient'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {

            //$this->request->data['Factureavoirfr']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoirfr']['date'])));
            $this->request->data['Factureavoirfr']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureavoirfr']['typefacture_id'] = 1;

            if (empty($this->request->data['Factureavoirfr']['pointdevente_id'])) {
                $this->request->data['Factureavoirfr']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            //$this->request->data['Factureavoirfr']['exercice_id'] = date("Y");
            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Factureavoirfr']['pointdevente_id'];
            }
            $depot = $this->request->data['Factureavoirfr']['depot_id'];
            $id_bn_reception = $this->request->data['Factureavoirfr']['facture_id'];
//            debug($this->request->data);
//            die;
            if ($this->Factureavoirfr->save($this->request->data)) {
                $this->misejour("Factureavoirfr", "edit", $id);
                //*****************************Remise à l'état initiale : imputation
                $this->loadModel('Imputationfactureavoirfr');
                $imputationfactureavoirs = $this->Imputationfactureavoirfr->find('all', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id), 'recursive' => -1));
//                debug($imputationfactureavoirs);die;
                if (!empty($imputationfactureavoirs)) {
                    foreach ($imputationfactureavoirs as $imputation) {
                        $this->Factureavoirfr->updateAll(array('Factureavoirfr.montant_regle ' => 'Factureavoirfr.montant_regle-' . $imputation['Imputationfactureavoirfr']['montant']), array('Factureavoirfr.id' => $id));
                        $this->Facture->updateAll(array('Facture.Montant_Regler ' => 'Facture.Montant_Regler-' . $imputation['Imputationfactureavoirfr']['montant']), array('Facture.id' => $imputation['Imputationfactureavoirfr']['facture_id']));
                    }
                    $this->Imputationfactureavoirfr->deleteAll(array('Imputationfactureavoirfr.factureavoirfr_id' => $id), false);
                }
                //***************************************Remise à 0 le stock
                $Lignefactureavoirs = $this->Lignefactureavoirfr->find('all', array('conditions' => array('Lignefactureavoirfr.factureavoirfr_id' => $id)));
                foreach ($Lignefactureavoirs as $i => $Lignefactureavoir) {
                    $qte_sorti = $Lignefactureavoir['Lignefactureavoirfr']['quantite'];
                    $stckdepot = $this->Stockdepot->find('first', array(
                        'conditions' => array('Stockdepot.article_id' => $Lignefactureavoir['Lignefactureavoirfr']['article_id'],
                            'Stockdepot.depot_id' => $Lignefactureavoir['Lignefactureavoirfr']['depot_id']), false));
                    if (!empty($stckdepot)) {
                        $qte = $stckdepot['Stockdepot']['quantite'] + $qte_sorti;
                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                    } else {
                        $stkn = array();
                        $stkn['depot_id'] = $Lignefactureavoir['Lignefactureavoirfr']['depot_id'];
                        $stkn['article_id'] = $Lignefactureavoir['Lignefactureavoirfr']['article_id'];
                        $stkn['quantite'] = $qte_sorti;
                        $this->Stockdepot->create();
                        $this->Stockdepot->save($stkn);
                    }
                }
                // Enregistrement des ligne facture avoir
                $Lignefactureavoirfrs = array();
                $stockdepots = array();
                if (isset($this->request->data['Lignefacture'])) {
                    foreach ($this->request->data['Lignefacture'] as $numl => $f) {
                        $array = array();
                        if ($f['sup'] != 1) {
                            if (!empty($f['article_id']) && !empty($f['quantite'])) {
                                $stockdepots[$numl]['depot_id'] = $depot;
                                $stockdepots[$numl]['article_id'] = $f['article_id'];
                                $stockdepots[$numl]['quantite'] = $f['quantite'];
                                $Lignefactureavoirfrs['factureavoirfr_id'] = $id;
                                $Lignefactureavoirfrs['depot_id'] = $depot;
                                $Lignefactureavoirfrs['article_id'] = $f['article_id'];
                                $Lignefactureavoirfrs['id'] = $f['id'];
                                $Lignefactureavoirfrs['quantite'] = $f['quantite'];
                                $Lignefactureavoirfrs['remise'] = $f['remise'];
                                $Lignefactureavoirfrs['tva'] = $f['tva'];
                                $Lignefactureavoirfrs['prix'] = $f['prix'];
                                $Lignefactureavoirfrs['prixnet'] = $f['prixnet'];
                                $Lignefactureavoirfrs['puttc'] = $f['puttc'];
                                $Lignefactureavoirfrs['totalhtans'] = $f['totalhtans'];
                                $Lignefactureavoirfrs['totalht'] = $f['totalht'];
                                $Lignefactureavoirfrs['totalttc'] = $f['totalttc'];
                                $Lignefactureavoirfrs['lignefacture_id'] = $f['lignefacture_id'];
                                $array['Lignefactureavoirfr'] = $Lignefactureavoirfrs;
                                $this->Lignefactureavoirfr->create();
                                if ($this->Lignefactureavoirfr->save($array)) {
                                    $lignereception = $this->Lignefacture->find('first', array('conditions' => array('Lignefacture.facture_id' => $id_bn_reception, 'Lignefacture.article_id' => $f['article_id'])));
                                    $bonreception = $this->Facture->find('first', array('conditions' => array('Facture.id' => $id_bn_reception)));

                                    if ((!empty($bonreception['Facture']['time'])) && (!empty($lignereception))) {

                                        //Mise Ã  jour pmp Bloc ou larticle est le meme et la quantite n est pas la meme
                                        $qterestante = $lignereception['Lignefacture']['quantite'] - $f['quantite'];

                                        $tmps = $this->Bonreception->query(
                                                'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
                                        FROM (
                                        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                                        FROM  factures,lignefactures
                                         where  factures.id=lignefactures.facture_id 
                                        and   lignefactures.article_id=' . $lignereception['Lignefacture']['article_id'] . ' 
                                        and factures.time>=' . '"' . $bonreception['Facture']['time'] . '"' . '
                                        order BY  factures.time
                                        )
                                        UNION (
                                        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                                        FROM  bonreceptions,lignereceptions
                                        where  bonreceptions.id=lignereceptions.bonreception_id and
                                        bonreceptions.facture_id=0 and
                                        lignereceptions.article_id=' . $lignereception['Lignefacture']['article_id'] . ' 
                                        and bonreceptions.time>=' . '"' . $bonreception['Facture']['time'] . '"' . '
                                        order BY  bonreceptions.time
                                        )
                                      
                                       
                                        )tmp
                                        order BY tmp.time');
//                                      
                                        if ($tmps != null) {
                                            //Si l'achat qu'on est entrain de modifier est la derni
                                            if (count($tmps) == 1) {
                                                $afterprixstk = $tmps[count($tmps) - 1]['tmp']['coutstkancien'];
                                                $afterqtestk = $tmps[count($tmps) - 1]['tmp']['qtestkancien'];
                                                if ($afterqtestk <= 0) {
                                                    $pmpfinal = $lignereception['Lignefacture']['totalht'] / $lignereception['Lignefacture']['quantite'];
                                                } else {
                                                    $pmpfinal = ($afterprixstk * $afterqtestk + ($lignereception['Lignefacture']['totalht'] / $lignereception['Lignefacture']['quantite'] * $qterestante)) / ($qterestante + $afterqtestk);
                                                }
                                                $this->Article->updateAll(array('Article.pmp' => $pmpfinal), array('Article.id' => $f['article_id']));
                                            } else {
                                                //maj qte ancien et prix ancien des achats > achat actuelle
                                                foreach ($tmps as $key => $tmp) {
                                                    if ($key == 0) {
                                                        $pmpanc = $tmps[0]['tmp']['coutstkancien'];
                                                        $qteanc = $tmps[0]['tmp']['qtestkancien'];
                                                        $pmp = $tmps[0]['tmp']['totalht'] - $Lignefactureavoirfrs['totalht'];
                                                        $qte = $tmps[0]['tmp']['quantite'] - $f['quantite'];

                                                        if ($qteanc <= 0) {
                                                            $pmpfinal = $pmp / $qte;
                                                        } else {
                                                            $pmpfinal = ($pmpanc * $qteanc + $pmp) / ($qte + $qteanc);
                                                        }
                                                    } else {
                                                        $typepiece = $tmp['tmp']['type'];
                                                        if ($typepiece == 0) {
                                                            $this->Lignereception->updateAll(array('Lignereception.qtestkancien' => ($qte + $qteanc), 'Lignereception.coutstkancien' => $pmpfinal), array('Lignereception.id' => $tmp['tmp']['id']));
                                                            $lignecr = $this->Lignereception->find('first', array('recursive' => 1, 'conditions' => array('Lignereception.id' => $tmp['tmp']['id'])));
//                                                            debug($lignecr);
                                                            $pmpanc = $lignecr['Lignereception']['coutstkancien'];
                                                            $qteanc = $lignecr['Lignereception']['qtestkancien'];
                                                            $pmp = $lignecr['Lignereception']['totalht'] - (($lignecr['Lignereception']['totalht'] / $lignecr['Lignereception']['quantite']) * $lignecr['Lignereception']['qte_retour']);
                                                            $qte = $lignecr['Lignereception']['quantite'] - $lignecr['Lignereception']['qte_retour'];
                                                        }
                                                        if ($typepiece == 1) {
                                                            $this->Lignefacture->updateAll(array('Lignefacture.qtestkancien' => ($qte + $qteanc), 'Lignefacture.coutstkancien' => $pmpfinal), array('Lignefacture.id' => $tmp['tmp']['id']));
                                                            $lignecr = $this->Lignefacture->find('first', array('recursive' => 1, 'conditions' => array('Lignefacture.id' => $tmp['tmp']['id'])));
//                                                            debug($lignecr);
                                                            $pmpanc = $lignecr['Lignefacture']['coutstkancien'];
                                                            $qteanc = $lignecr['Lignefacture']['qtestkancien'];
                                                            $pmp = $lignecr['Lignefacture']['totalht'] - (($lignecr['Lignefacture']['totalht'] / $lignecr['Lignefacture']['quantite']) * $lignecr['Lignefacture']['qte_retour']);
                                                            $qte = $lignecr['Lignefacture']['quantite'] - $lignecr['Lignefacture']['qte_retour'];
                                                        }

                                                        if ($qteanc <= 0) {
                                                            $pmpfinal = $pmp / $qte;
                                                        } else {
                                                            $pmpfinal = ($pmpanc * $qteanc + $pmp) / ($qte + $qteanc);
                                                        }
                                                    }
                                                }
                                                $this->Article->updateAll(array('Article.pmp' => $pmpfinal), array('Article.id' => $f['article_id']));
                                            }
                                        }
                                    }

                                    //****Mise à jour stock
                                    $stckdepot = $this->Stockdepot->find('first', array(
                                        'conditions' => array('Stockdepot.article_id' => $stockdepots[$numl]['article_id'], 'Stockdepot.depot_id' => $depot),
                                        'recursive' => -1
                                    ));
                                    if (!empty($stckdepot)) {
                                        $stockdepots[$numl]['quantite'] = $stckdepot['Stockdepot']['quantite'] - $stockdepots[$numl]['quantite'];
                                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    } else {
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($stockdepots[$numl]);
                                    }
                                }
                            }
                        }
                    }
                }
                // Imputation sur des factures
                if (!empty($this->request->data['Imputationfacture'])) {
                    foreach ($this->request->data['Imputationfacture'] as $imputation) {
                        if ($imputation['supfac'] != 1) {
                            if ($imputation['facture_id'] != "") {
                                $imputation['factureavoirfr_id'] = $id;
                                $this->Imputationfactureavoirfr->create();
                                if ($this->Imputationfactureavoirfr->save($imputation)) {
                                    $this->Factureavoirfr->updateAll(array('Factureavoirfr.montant_regle ' => 'Factureavoirfr.montant_regle+' . $imputation['montant']), array('Factureavoirfr.id' => $id));
                                    $this->Facture->updateAll(array('Facture.Montant_Regler ' => 'Facture.Montant_Regler+' . $imputation['montant']), array('Facture.id' => $imputation['facture_id']));
                                }
                            }
                        }
                    }
                }

                $this->Session->setFlash(__('The factureclient has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The factureclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array(
                'conditions' => array('Factureavoirfr.' . $this->Factureavoirfr->primaryKey => $id),
                'recursive' => 1,
                'contain' => array('Fournisseur.name', 'Pointdevente.name', 'Depot.designation'));
            $this->request->data = $this->Factureavoirfr->find('first', $options);
        }

        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Factureavoirfr->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1, 'Fournisseur.societe' => $composantsoc)));

        $utilisateurs = $this->Factureavoirfr->Utilisateur->find('list');

        $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Factureavoirfr']['date'])));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $typefactures = $this->Factureavoirfr->Typefacture->find('list');
        $this->loadModel('Imputationfactureavoirfr');
        $listeimputationfactureavoirs = $this->Imputationfactureavoirfr->find('all', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id), 'recursive' => -1));
//        debug($listeimputationfactureavoirs);die;
        if (!empty($listeimputationfactureavoirs)) {
            $fac = '';
            foreach ($listeimputationfactureavoirs as $ad) {
                $fac = $fac . ',' . $ad['Imputationfactureavoirfr']['facture_id'];
            }
        } else {
            $fac = 0;
        }
        $factures = $this->Facture->find('list', array('fields' => array('Facture.numerofrs'), 'conditions' => array('Facture.fournisseur_id' => $this->request->data['Factureavoirfr']['fournisseur_id'], '(Facture.totalttc > Facture.Montant_Regler OR Facture.id in (0' . $fac . '))'), 'recursive' => -1));
//        debug($factures);die;
        $this->loadModel('Imputationfactureavoirfr');
        $imputationfactureavoirs = $this->Imputationfactureavoirfr->find('all', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id), 'recursive' => -1));
        $tvas = $this->Tva->find('all');
        $lignefactures = $this->Lignefactureavoirfr->find('all', array(
            'conditions' => array('Lignefactureavoirfr.factureavoirfr_id' => $id)
        ));
        $this->set(compact('lignefactures', 'tvas', 'imputationfactureavoirs', 'factures', 'name', 'typefactures', 'autorisation', 'solde', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'fournisseurs', 'utilisateurs', 'timbre', 'depots', 'date', 'lignefactureclients', 'articles', 'tabqtestock'));
    }

    public function getfactures() {
        $this->layout = null;
        $this->loadModel('Facture');
        $data = $this->request->data;
        $clientid = $data['clientid'];
        $factureclients = $this->Facture->find('all', array('conditions' => array('Facture.fournisseur_id' => $clientid, 'Facture.factureavoirfr_id' => 0), 'recursive' => -1));
        $select = "<select name='facture_id' champ='factureclient_id' id='factureclient_id' class='form-control  select ' onchange=''><option selected disabled hidden value=0> Veuillez choisir !!</option>";
        foreach ($factureclients as $v) {
            $select = $select . "<option value=" . $v['Facture']['id'] . ">" . $v['Facture']['numero'] . "</option>";
        }
        $select = $select . '</select>';

        echo $select;
        die;
    }

    public function delete($id = null) {
//             $lien=  CakeSession::read('lien_achat');
//               $x="";
//               //debug($lien);die;
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='factureavoirfrs'){
//                        $x=$liens['delete'];
//                }}}
//              if (( $x <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignefactureavoirfr');
        $this->loadModel('Facture');
        $this->loadModel('Imputationfactureavoirfr');
        $this->loadModel('Lignereception');
        $this->loadModel('Bonreception');
        $this->loadModel('Lignefacture');
        $this->Factureavoirfr->id = $id;
        if (!$this->Factureavoirfr->exists()) {
            throw new NotFoundException(__('Invalid factureclient'));
        }
        $this->request->onlyAllow('post', 'delete');
        $id_bn_reception = $id;
        $facavoir = $this->Factureavoirfr->find('first', array(
            'conditions' => array('Factureavoirfr.id' => $id),
            'recursive' => -1
        ));

        //*****************************Remise à l'état initiale : imputation
        $this->loadModel('Imputationfactureavoirfr');
        $imputationfactureavoirs = $this->Imputationfactureavoirfr->find('all', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id), 'recursive' => -1));
        if (!empty($imputationfactureavoirs)) {
            foreach ($imputationfactureavoirs as $imputation) {
                $this->Factureavoirfr->updateAll(array('Factureavoirfr.montant_regle ' => 'Factureavoirfr.montant_regle-' . $imputation['Imputationfactureavoirfr']['montant']), array('Factureavoirfr.id' => $id));
                $this->Facture->updateAll(array('Facture.factureavoirfr_id' => 0, 'Facture.Montant_Regler ' => 'Facture.Montant_Regler-' . $imputation['Imputationfactureavoirfr']['montant']), array('Facture.id' => $imputation['Imputationfactureavoirfr']['facture_id']));
            }
            $this->Imputationfactureavoirfr->deleteAll(array('Imputationfactureavoirfr.factureavoirfr_id' => $id), false);
        }

        //******************************** Stock + PMP
        if ($facavoir['Factureavoirfr']['typefacture_id'] == 1) {
            $this->Facture->updateAll(array('Facture.factureavoirfr_id' => 0), array('Facture.factureavoirfr_id' => $id));
            $lrs = $this->Lignefactureavoirfr->find('all', array('conditions' => array('Lignefactureavoirfr.factureavoirfr_id' => $id), false));
            //debug($lrs);die;
            $stkdepqte = array();
            foreach ($lrs as $lr) {
                
                
              $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $lr['Lignefactureavoirfr']['article_id'], 'Stockdepot.depot_id' => $lr['Lignefactureavoirfr']['depot_id']), false));
                if (!empty($stckdepot)) {
                    $stkdepqte['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] + $lr['Lignefactureavoirfr']['quantite'];
                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stkdepqte['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                } else {
                    $stkdepqte['quantite'] = $lr['Lignefactureavoirfr']['quantite'];
                    $stkdepqte['article_id'] = $lr['Lignefactureavoirfr']['article_id'];
                    $stkdepqte['depot_id'] = $lr['Lignefactureavoirfr']['depot_id'];
                    $stkdepqte['prix'] = $lr['Lignefactureavoirfr']['prix'];
                    $this->Stockdepot->create();
                    $this->Stockdepot->save($stkdepqte);
                }  
                
                
               if ($facavoir['Factureavoirfr']['libre'] == 0) { 
                //******************************** PMP**************************
                $this->Lignefacture->updateAll(array('Lignefacture.qte_retour' => 'Lignefacture.qte_retour-' . $lr['Lignefactureavoirfr']['quantite']), array('Lignefacture.id' => $lr['Lignefactureavoirfr']['lignefacture_id']));
                $f['article_id'] = $lr['Lignefactureavoirfr']['article_id'];
                $lignereception = $this->Lignefacture->find('first', array('conditions' => array('Lignefacture.facture_id' => $id_bn_reception, 'Lignefacture.article_id' => $f['article_id'])));
                $bonreception = $this->Facture->find('first', array('conditions' => array('Facture.id' => $id_bn_reception)));
                if ((!empty($bonreception['Facture']['time'])) && (!empty($lignereception))) {

                    //Mise Ã  jour pmp Bloc ou larticle est le meme et la quantite n est pas la meme


                    $tmps = $this->Bonreception->query(
                            'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
                        FROM (
                        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $lignereception['Lignefacture']['article_id'] . ' 
                        and factures.time>=' . '"' . $bonreception['Facture']['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $lignereception['Lignefacture']['article_id'] . ' 
                        and bonreceptions.time>=' . '"' . $bonreception['Facture']['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                      
                       
                        )tmp
                        order BY tmp.time');
//                                      
                    if ($tmps != null) {
                        //Si l'achat qu'on est entrain de modifier est la derni
                        if (count($tmps) == 1) {
                            $afterprixstk = $tmps[count($tmps) - 1]['tmp']['coutstkancien'];
                            $afterqtestk = $tmps[count($tmps) - 1]['tmp']['qtestkancien'];
                            if ($afterqtestk <= 0) {
                                $pmpfinal = $lignereception['Lignefacture']['totalht'] / $lignereception['Lignefacture']['quantite'];
                            } else {
                                $pmpfinal = ($afterprixstk * $afterqtestk + $lignereception['Lignefacture']['totalht']) / ($lignereception['Lignefacture']['quantite'] + $afterqtestk);
                            }
                            $this->Article->updateAll(array('Article.pmp' => $pmpfinal), array('Article.id' => $f['article_id']));
                        } else {
                            //maj qte ancien et prix ancien des achats > achat actuelle
                            foreach ($tmps as $key => $tmp) {
                                if ($key == 0) {
                                    $pmpanc = $tmps[0]['tmp']['coutstkancien'];
                                    $qteanc = $tmps[0]['tmp']['qtestkancien'];
                                    $pmp = $tmps[0]['tmp']['totalht'];
                                    $qte = $tmps[0]['tmp']['quantite'];

                                    if ($qteanc <= 0) {
                                        $pmpfinal = $pmp / $qte;
                                    } else {
                                        $pmpfinal = ($pmpanc * $qteanc + $pmp) / ($qte + $qteanc);
                                    }
                                } else {
                                    $typepiece = $tmp['tmp']['type'];
                                    if ($typepiece == 0) {
                                        $this->Lignereception->updateAll(array('Lignereception.qtestkancien' => ($qte + $qteanc), 'Lignereception.coutstkancien' => $pmpfinal), array('Lignereception.id' => $tmp['tmp']['id']));
                                        $lignecr = $this->Lignereception->find('first', array('recursive' => 1, 'conditions' => array('Lignereception.id' => $tmp['tmp']['id'])));
//                                                            debug($lignecr);
                                        $pmpanc = $lignecr['Lignereception']['coutstkancien'];
                                        $qteanc = $lignecr['Lignereception']['qtestkancien'];
                                        $pmp = $lignecr['Lignereception']['totalht'] - (($lignecr['Lignereception']['totalht'] / $lignecr['Lignereception']['quantite']) * $lignecr['Lignereception']['qte_retour']);
                                        $qte = $lignecr['Lignereception']['quantite'] - $lignecr['Lignereception']['qte_retour'];
                                    }
                                    if ($typepiece == 1) {
                                        $this->Lignefacture->updateAll(array('Lignefacture.qtestkancien' => ($qte + $qteanc), 'Lignefacture.coutstkancien' => $pmpfinal), array('Lignefacture.id' => $tmp['tmp']['id']));
                                        $lignecr = $this->Lignefacture->find('first', array('recursive' => 1, 'conditions' => array('Lignefacture.id' => $tmp['tmp']['id'])));
//                                                            debug($lignecr);
                                        $pmpanc = $lignecr['Lignefacture']['coutstkancien'];
                                        $qteanc = $lignecr['Lignefacture']['qtestkancien'];
                                        $pmp = $lignecr['Lignefacture']['totalht'] - (($lignecr['Lignefacture']['totalht'] / $lignecr['Lignefacture']['quantite']) * $lignecr['Lignefacture']['qte_retour']);
                                        $qte = $lignecr['Lignefacture']['quantite'] - $lignecr['Lignefacture']['qte_retour'];
                                    }

                                    if ($qteanc <= 0) {
                                        $pmpfinal = $pmp / $qte;
                                    } else {
                                        $pmpfinal = ($pmpanc * $qteanc + $pmp) / ($qte + $qteanc);
                                    }
                                }
                            }
                            $this->Article->updateAll(array('Article.pmp' => $pmpfinal), array('Article.id' => $f['article_id']));
                        }
                    }
                }
                //*********************stock************************************
               }
            }
        }

        //**********************************************************************
        $this->Lignefactureavoirfr->deleteAll(array('Lignefactureavoirfr.factureavoirfr_id' => $id), false);
        $numansar = $facavoir['Factureavoirfr']['numero'];
        $pvansar = $facavoir['Factureavoirfr']['pointdevente_id'];
        if ($this->Factureavoirfr->delete()) {
            $this->misejour("Factureavoirfr", $numansar, $id,$pvansar);
            $this->Session->setFlash(__('Factureclient deleted'));
            CakeSession::write('view', "delete");
            //$this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Factureclient was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function imprimerfavf($id = null) {
        $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirfrs') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Factureavoirfr->exists($id)) {
            throw new NotFoundException(__('Invalid factureavoir'));
        }
        $options = array('conditions' => array('Factureavoirfr.' . $this->Factureavoirfr->primaryKey => $id));
        $this->set('factureavoir', $this->Factureavoirfr->find('first', $options));
        $this->loadModel('Imputationfactureavoirfr');
        $imputationfactureavoirs = $this->Imputationfactureavoirfr->find('all', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id), 'recursive' => 0));
        $this->set(compact('imputationfactureavoirs'));
    }

    public function imprimerfavr($id = null) {
        $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirfrs') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefactureavoirfr');
        if (!$this->Factureavoirfr->exists($id)) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        $options = array('conditions' => array('Factureavoirfr.' . $this->Factureavoirfr->primaryKey => $id));
        $this->set('factureclient', $this->Factureavoirfr->find('first', $options));
        $lignefactureclients = $this->Lignefactureavoirfr->find('all', array(
            'conditions' => array('Lignefactureavoirfr.factureavoirfr_id' => $id)
        ));
        $lignefactureclientstva = $this->Lignefactureavoirfr->find('all', array('fields' => array(
                'SUM(Lignefactureavoirfr.totalht*Lignefactureavoirfr.tva)/100  mtva'
                , 'SUM(Lignefactureavoirfr.totalht) totalht'
                , 'AVG(Lignefactureavoirfr.tva) tva'),
            'conditions' => array('Lignefactureavoirfr.factureavoirfr_id' => $id)
            , 'group' => array('Lignefactureavoirfr.tva')
        ));
        //debug($lignefactureclients) ;
        // debug($lignefactureclientstva)  ;die;  
        $this->set(compact('lignefactureclients', 'lignefactureclientstva'));
    }

    public function getfacturetotalttc($id = null) {
        $this->layout = null;
        $this->loadModel('Facture');
        $factures = $this->Facture->find('first', array('conditions' => array('Facture.id' => $id), 'recursive' => -1));
        $ttc = $factures['Facture']['totalttc'];
        $mr = $factures['Facture']['Montant_Regler'];
        echo json_encode(array('ttc' => $ttc, 'montant_regler' => $mr));
        die();
    }

}
