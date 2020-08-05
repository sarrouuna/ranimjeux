<?php

App::uses('AppController', 'Controller');

/**
 * Factureavoirs Controller
 *
 * @property Factureavoir $Factureavoir
 */
class FactureavoirsController extends AppController {

    public function addlibre() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Timbre');
        $this->loadModel('Client');
        $this->loadModel('Utilisateur');
        $this->loadModel('Articlecomposante');
        $this->loadModel('Typedipliquation');
        $this->loadModel('Factureclient');

        if ($this->request->is('post')) {
//            debug($this->request->data);
//            die;

            $this->request->data['Factureavoir']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoir']['date'])));
            $this->request->data['Factureavoir']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureavoir']['typefacture_id'] = 1;
            $this->request->data['Factureavoir']['source'] = 'libre';
            if (empty($this->request->data['Factureavoir']['pointdevente_id'])) {
                $this->request->data['Factureavoir']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Factureavoir']['exercice_id'] = date("Y", strtotime(str_replace('/', '-', $this->request->data['Factureavoir']['date'])));
            if (empty($this->request->data['Factureavoir']['timbre_id'])) {
                $this->request->data['Factureavoir']['timbre_id'] = 0;
            }

            $this->Factureavoir->create();
            if (!empty($this->request->data['Lignepiece'])) {
                if ($this->Factureavoir->save($this->request->data)) {
                    $id = $this->Factureavoir->id;
                    $this->misejour('Factureavoir', "add", $id);
                    // debug($id);die;
                    $Lignefactureclients = array();
                    $stockdepots = array();
                    // debug($this->request->data );die;
                    foreach ($this->request->data['Lignepiece'] as $numl => $f) {
                        //debug($f);die;
                        if ($f['sup'] != 1) {
                            if ($f['article_id'] != "") {
                                $f['depot_id'] = $this->request->data['Factureavoir']['depot_id'];
                                $stockdepots[$numl]['quantite'] = $f['quantite'];
                                $Lignefactureclients['factureavoir_id'] = $id;
                                $Lignefactureclients['article_id'] = $this->request->data['Lignepiece'][$numl]['article_id'];
                                $f['article_id'] = $this->request->data['Lignepiece'][$numl]['article_id'];
                                $Lignefactureclients['depot_id'] = $f['depot_id'];
                                $Lignefactureclients['quantite'] = $f['quantite'];
                                $Lignefactureclients['remise'] = $f['remise'];
                                $Lignefactureclients['tva'] = $f['tva'];
                                $Lignefactureclients['prix'] = $f['prixhtva'];
                                $Lignefactureclients['prixnet'] = $f['prixnet'];
                                $Lignefactureclients['puttc'] = $f['puttc'];
                                $Lignefactureclients['totalhtans'] = $f['totalhtans'];
                                $Lignefactureclients['designation'] = $f['designation'];
                                $Lignefactureclients['totalht'] = $f['totalht'];
                                $Lignefactureclients['totalttc'] = $f['totalttc'];
                                $Lignefactureclients['depotcomposee'] = $f['depotcomposee'];
                                $Lignefactureclients['pmp'] = $f['pmp'];
                                $Lignefactureclients['margebase'] = $f['margebase'];
                                $Lignefactureclients['prixachatmarge'] = $f['prixachatmarge'];
                                if ($f['type'] == 1) {
                                    $Lignefactureclients['composee'] = $f['type'];
                                } else {
                                    $Lignefactureclients['composee'] = 0;
                                }
                                // debug($Lignefactur $Lignefactureclients['composee'] = $f['type'];eclients);die;
                                $this->Lignefactureavoir->create();
                                if ($this->Lignefactureavoir->save($Lignefactureclients)) {
                                    // Mise à jour stock
                                    $qte_sorti = $f['quantite'];
                                    if ($f['type'] == 1) {
                                        $articlescomposantes = $this->Articlecomposante->find('all', array(
                                            'conditions' => array('Articlecomposante.article_id' => $f['article_id'])
                                        ));
                                        foreach ($articlescomposantes as $k => $articlescomposante) {
                                            $qte_vendu = $qte_sorti * $articlescomposante['Articlecomposante']['qte'];
                                            $stckdepot = $this->Stockdepot->find('first', array(
                                                'conditions' => array('Stockdepot.article_id' => $articlescomposante['Articlecomposante']['composant'],
                                                    'Stockdepot.depot_id' => $f['depot_id']), false));
                                            if (!empty($stckdepot)) {
                                                $qte = $stckdepot['Stockdepot']['quantite'] + $qte_vendu;
                                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                            } else {
                                                $stkn = array();
                                                $stkn['depot_id'] = $f['depot_id'];
                                                $stkn['article_id'] = $articlescomposante['Articlecomposante']['composant'];
                                                $stkn['quantite'] = $qte_vendu;
                                                $this->Stockdepot->create();
                                                $this->Stockdepot->save($stkn);
                                            }
                                        }
                                    } else {
                                        $stckdepot = $this->Stockdepot->find('first', array(
                                            'conditions' => array('Stockdepot.article_id' => $f['article_id'],
                                                'Stockdepot.depot_id' => $f['depot_id']), false));
                                        if (!empty($stckdepot)) {
                                            $qte = $stckdepot['Stockdepot']['quantite'] + $qte_sorti;
                                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                        } else {
                                            $stkn = array();
                                            $stkn['depot_id'] = $f['depot_id'];
                                            $stkn['article_id'] = $f['article_id'];
                                            $stkn['quantite'] = $qte_sorti;
                                            $this->Stockdepot->create();
                                            $this->Stockdepot->save($stkn);
                                        }
                                    }

                                    // Imputation sur des factures
                                    
                                }
                            }
                        }
                    }
					
									$this->loadModel('Imputationfactureavoir');
                                    if (!empty($this->request->data['Imputationfacture'])) {
                                        foreach ($this->request->data['Imputationfacture'] as $imputation) {
                                            if ($imputation['supfac'] != 1) {
                                                if ($imputation['factureclient_id'] != "") {
                                                    $imputation['factureavoir_id'] = $id;
                                                    $this->Imputationfactureavoir->create();
                                                    if ($this->Imputationfactureavoir->save($imputation)) {
                                                        $this->Factureavoir->updateAll(array('Factureavoir.montant_regle ' => 'Factureavoir.montant_regle+' . $imputation['montant']), array('Factureavoir.id' => $id));
                                                        $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler+' . $imputation['montant']), array('Factureclient.id' => $imputation['factureclient_id']));
                                                    }
                                                }
                                            }
                                        }
                                    }
					
					
                    $this->Session->setFlash(__('The Factureclient has been saved'));
                    //$this->redirect(array('action' => 'index'));
                    $this->redirect(array('controller' => 'Factureavoir' . 's', 'action' => 'index/' . $id));
                    //$this->redirect(array('action' => 'addbonsorti/'.$id));    
                } else {
                    $this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                }
            }
        }

        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {
            $numero = $this->Factureavoir->find('all', array('fields' => array('MAX(' . 'Factureavoir' . '.numeroconca) as num'),
                'conditions' => array('Factureavoir' . '.pointdevente_id' => $pv, 'Factureavoir' . '.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
//  $anne=$getexercice['Factureclient']['exercice_id'];  
//  if ($anne==date("Y")){
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

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            $mm = 0;
        }
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.etat' => 1, 'Client.societe' => $composantsoc), 'order' => array('Client.code' => 'asc')
        ));
        $utilisateurs = $this->Utilisateur->find('list');
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.id' => $p)));
        }
        $timbre = $this->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $typedipliquations = $this->Typedipliquation->find('list', array(
            'conditions' => array('Typedipliquation.id <' => 5),
            'fields' => array('Typedipliquation.id', 'Typedipliquation.name')
        ));
        //$articles = $this->Article->find('list', array('conditions' => array('Article.typeetatarticle_id' => 1), 'recursive' => -1));
        $this->set(compact('typedipliquations', 'model', 'articles', 'pointdeventes', 'clients', 'timbre', 'utilisateurs', 'depots', 'mm', 'numspecial'));
    }

    public function editlibre($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Timbre');
        $this->loadModel('Client');
        $this->loadModel('Utilisateur');
        $this->loadModel('Articlecomposante');
        $this->loadModel('Typedipliquation');
        $this->loadModel('Factureclient');
        if ($this->request->is('post') || $this->request->is('put')) {
//            debug($this->request->data);
//            die;
            //****************Préparation des données***************************
            $this->request->data['Factureavoir']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoir']['date'])));
            $this->request->data['Factureavoir']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureavoir']['typefacture_id'] = 1;
            $this->request->data['Factureavoir']['source'] = 'libre';
            if (empty($this->request->data['Factureavoir']['pointdevente_id'])) {
                $this->request->data['Factureavoir']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Factureavoir']['exercice_id'] = date("Y", strtotime(str_replace('/', '-', $this->request->data['Factureavoir']['date'])));
            if (empty($this->request->data['Factureavoir']['timbre_id'])) {
                $this->request->data['Factureavoir']['timbre_id'] = 0;
            }
            //******************************************************************
            $this->Factureavoir->create();
            if (!empty($this->request->data['Lignepiece'])) {
                if ($this->Factureavoir->save($this->request->data)) {
                    $id = $this->Factureavoir->id;
                    $this->misejour('Factureavoir', "edit", $id);
                    //*****************************Remise à l'état initiale : imputation
                    $this->loadModel('Imputationfactureavoir');
                    $imputationfactureavoirs = $this->Imputationfactureavoir->find('all', array('conditions' => array('Imputationfactureavoir.factureavoir_id' => $id), 'recursive' => -1));
                    if (!empty($imputationfactureavoirs)) {
                        foreach ($imputationfactureavoirs as $imputation) {
                            $this->Factureavoir->updateAll(array('Factureavoir.montant_regle ' => 'Factureavoir.montant_regle-' . $imputation['Imputationfactureavoir']['montant']), array('Factureavoir.id' => $id));
                            $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler-' . $imputation['Imputationfactureavoir']['montant']), array('Factureclient.id' => $imputation['Imputationfactureavoir']['factureclient_id']));
                        }
                        $this->Imputationfactureavoir->deleteAll(array('Imputationfactureavoir.factureavoir_id' => $id), false);
                    }
                    //***************************************Remise à 0 le stock
                    $Lignefactureavoirs = $this->Lignefactureavoir->find('all', array('conditions' => array('Lignefactureavoir.factureavoir_id' => $id)));

                    foreach ($Lignefactureavoirs as $i => $Lignefactureavoir) {
                        $qte_sorti = $Lignefactureavoir['Lignefactureavoir']['quantite'];

                        if ($Lignefactureavoir['Lignefactureavoir']['composee'] == 1) {
                            $articlescomposantes = $this->Articlecomposante->find('all', array(
                                'conditions' => array('Articlecomposante.article_id' => $Lignefactureavoir['Lignefactureavoir']['article_id'])
                            ));
                            foreach ($articlescomposantes as $k => $articlescomposante) {
                                $qte_vendu = $qte_sorti * $articlescomposante['Articlecomposante']['qte'];
                                $stckdepot = $this->Stockdepot->find('first', array(
                                    'conditions' => array('Stockdepot.article_id' => $articlescomposante['Articlecomposante']['composant'],
                                        'Stockdepot.depot_id' => $Lignefactureavoir['Lignefactureavoir']['depot_id']), false));
                                if (!empty($stckdepot)) {
                                    $qte = $stckdepot['Stockdepot']['quantite'] - $qte_vendu;
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                } else {
                                    $stkn = array();
                                    $stkn['depot_id'] = $Lignefactureavoir['Lignefactureavoir']['depot_id'];
                                    $stkn['article_id'] = $articlescomposante['Articlecomposante']['composant'];
                                    $stkn['quantite'] = 0 - $qte_vendu;
                                    $this->Stockdepot->create();
                                    $this->Stockdepot->save($stkn);
                                }
                            }
                        } else {
                            $stckdepot = $this->Stockdepot->find('first', array(
                                'conditions' => array('Stockdepot.article_id' => $Lignefactureavoir['Lignefactureavoir']['article_id'],
                                    'Stockdepot.depot_id' => $Lignefactureavoir['Lignefactureavoir']['depot_id']), false));
                            if (!empty($stckdepot)) {
                                $qte = $stckdepot['Stockdepot']['quantite'] - $qte_sorti;
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                            } else {
                                $stkn = array();
                                $stkn['depot_id'] = $Lignefactureavoir['Lignefactureavoir']['depot_id'];
                                $stkn['article_id'] = $Lignefactureavoir['Lignefactureavoir']['article_id'];
                                $stkn['quantite'] = 0 - $qte_sorti;
                                $this->Stockdepot->create();
                                $this->Stockdepot->save($stkn);
                            }
                        }
                    }
                    $this->Lignefactureavoir->deleteAll(array('Lignefactureavoir.factureavoir_id' => $id), false);
                    //**********************************Nouvelles enregistrement
                    $Lignefactureclients = array();
                    $stockdepots = array();
                    foreach ($this->request->data['Lignepiece'] as $numl => $f) {
                        if ($f['sup'] != 1) {
                            if ($f['article_id'] != "") {
                                $f['depot_id'] = $this->request->data['Factureavoir']['depot_id'];
                                $stockdepots[$numl]['quantite'] = $f['quantite'];
                                $Lignefactureclients['factureavoir_id'] = $id;
                                $Lignefactureclients['article_id'] = $this->request->data['Lignepiece'][$numl]['article_id'];
                                $f['article_id'] = $this->request->data['Lignepiece'][$numl]['article_id'];
                                $Lignefactureclients['depot_id'] = $f['depot_id'];
                                $Lignefactureclients['quantite'] = $f['quantite'];
                                $Lignefactureclients['remise'] = $f['remise'];
                                $Lignefactureclients['tva'] = $f['tva'];
                                $Lignefactureclients['prix'] = $f['prixhtva'];
                                $Lignefactureclients['prixnet'] = $f['prixnet'];
                                $Lignefactureclients['puttc'] = $f['puttc'];
                                $Lignefactureclients['totalhtans'] = $f['totalhtans'];
                                $Lignefactureclients['designation'] = $f['designation'];
                                $Lignefactureclients['totalht'] = $f['totalht'];
                                $Lignefactureclients['totalttc'] = $f['totalttc'];
                                $Lignefactureclients['depotcomposee'] = $f['depotcomposee'];
                                $Lignefactureclients['pmp'] = $f['pmp'];
                                $Lignefactureclients['margebase'] = $f['margebase'];
                                $Lignefactureclients['prixachatmarge'] = $f['prixachatmarge'];

                                if ($f['type'] == 1) {
                                    $Lignefactureclients['composee'] = $f['type'];
                                } else {
                                    $Lignefactureclients['composee'] = 0;
                                }
                                $this->Lignefactureavoir->create();
                                if ($this->Lignefactureavoir->save($Lignefactureclients)) {
                                    //*************************Mise à jour stock
                                    $qte_sorti = $f['quantite'];
                                    if ($f['type'] == 1) {
                                        $articlescomposantes = $this->Articlecomposante->find('all', array(
                                            'conditions' => array('Articlecomposante.article_id' => $f['article_id'])
                                        ));
                                        foreach ($articlescomposantes as $k => $articlescomposante) {
                                            $qte_vendu = $qte_sorti * $articlescomposante['Articlecomposante']['qte'];
                                            $stckdepot = $this->Stockdepot->find('first', array(
                                                'conditions' => array('Stockdepot.article_id' => $articlescomposante['Articlecomposante']['composant'],
                                                    'Stockdepot.depot_id' => $f['depot_id']), false));
                                            if (!empty($stckdepot)) {
                                                $qte = $stckdepot['Stockdepot']['quantite'] + $qte_vendu;
                                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                            } else {
                                                $stkn = array();
                                                $stkn['depot_id'] = $f['depot_id'];
                                                $stkn['article_id'] = $articlescomposante['Articlecomposante']['composant'];
                                                $stkn['quantite'] = $qte_vendu;
                                                $this->Stockdepot->create();
                                                $this->Stockdepot->save($stkn);
                                            }
                                        }
                                    } else {
                                        $stckdepot = $this->Stockdepot->find('first', array(
                                            'conditions' => array('Stockdepot.article_id' => $f['article_id'],
                                                'Stockdepot.depot_id' => $f['depot_id']), false));
                                        if (!empty($stckdepot)) {
                                            $qte = $stckdepot['Stockdepot']['quantite'] + $qte_sorti;
                                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                        } else {
                                            $stkn = array();
                                            $stkn['depot_id'] = $f['depot_id'];
                                            $stkn['article_id'] = $f['article_id'];
                                            $stkn['quantite'] = $qte_sorti;
                                            $this->Stockdepot->create();
                                            $this->Stockdepot->save($stkn);
                                        }
                                    }
                                    //***************Imputation sur des factures
                                    
                                }
                            }
                        }
                    }
					
									$this->loadModel('Imputationfactureavoir');
                                    if (!empty($this->request->data['Imputationfacture'])) {
                                        foreach ($this->request->data['Imputationfacture'] as $imputation) {
                                            if ($imputation['supfac'] != 1) {
                                                if ($imputation['factureclient_id'] != "") {
                                                    $imputation['factureavoir_id'] = $id;
                                                    $this->Imputationfactureavoir->create();
                                                    if ($this->Imputationfactureavoir->save($imputation)) {
                                                        $this->Factureavoir->updateAll(array('Factureavoir.montant_regle ' => 'Factureavoir.montant_regle+' . $imputation['montant']), array('Factureavoir.id' => $id));
                                                        $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler+' . $imputation['montant']), array('Factureclient.id' => $imputation['factureclient_id']));
                                                    }
                                                }
                                            }
                                        }
                                    }
					
					
                    $this->Session->setFlash(__('The Factureclient has been saved'));
                    //$this->redirect(array('action' => 'index'));
                    $this->redirect(array('controller' => 'Factureavoir' . 's', 'action' => 'index/' . $id));
                    //$this->redirect(array('action' => 'addbonsorti/'.$id));    
                } else {
                    $this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                }
            }
        } else {
            $options = array('conditions' => array('Factureavoir.' . $this->Factureavoir->primaryKey => $id));
            $this->request->data = $this->Factureavoir->find('first', $options);
            //  debug($this->request->data );
        }
        $Lignefactureavoirs = $this->Lignefactureavoir->find('all', array('conditions' => array('Lignefactureavoir.factureavoir_id' => $id), 'order' => array('Lignefactureavoir.id' => 'ASC')));
        $clientid = @$this->request->data['Factureavoir']['client_id'];
        $client = $this->Client->find('first', array('conditions' => array('Client.id' => $clientid), 'recursive' => -1));
//        debug($client);
//        die;
        $adresse = $client['Client']['adresse'];

        $matriculefiscale = $client['Client']['matriculefiscale'];
        $autorisation = $client['Client']['autorisation'];
        $name = $client['Client']['name'];
        $typeclient_id = $client['Client']['typeclient_id'];

        $pv = CakeSession::read('pointdevente');

        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array( 'Client.societe' => $composantsoc), 'order' => array('Client.code' => 'asc')
        ));
        $utilisateurs = $this->Utilisateur->find('list');
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.id' => $p)));
        }
        $timbre = $this->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));

        $this->loadModel('Imputationfactureavoir');
        $listeimputationfactureavoirs = $this->Imputationfactureavoir->find('all', array('conditions' => array('Imputationfactureavoir.factureavoir_id' => $id), 'recursive' => -1));
        if (!empty($listeimputationfactureavoirs)) {
            $fac = '';
            foreach ($listeimputationfactureavoirs as $ad) {
                $fac = $fac . ',' . $ad['Imputationfactureavoir']['factureclient_id'];
            }
        } else {
            $fac = 0;
        }
        $factureclients = $this->Factureclient->find('list', array('fields' => array('Factureclient.numero'), 'conditions' => array('Factureclient.client_id' => $this->request->data['Factureavoir']['client_id'], '(Factureclient.totalttc > Factureclient.Montant_Regler OR Factureclient.id in (0' . $fac . '))'), 'recursive' => -1));
        $this->loadModel('Imputationfactureavoir');
        $imputationfactureavoirs = $this->Imputationfactureavoir->find('all', array('conditions' => array('Imputationfactureavoir.factureavoir_id' => $id), 'recursive' => -1));

//$articles = $this->Article->find('list', array('conditions' => array('Article.typeetatarticle_id' => 1), 'recursive' => -1));
        $this->set(compact('imputationfactureavoirs', 'factureclients', 'name', 'typeclient_id', 'autorisation', 'matriculefiscale', 'tel', 'adresse', 'Lignefactureavoirs', 'typedipliquations', 'model', 'articles', 'pointdeventes', 'clients', 'timbre', 'utilisateurs', 'depots', 'mm', 'numspecial'));
    }

    public function index($id = NUll) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirs') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        
        $this->loadModel('Client');
        $this->loadModel('Typefacture');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $cond5 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Factureavoir.pointdevente_id = ' . $p;
        }
        $soc = CakeSession::read('soc');
        if ($id) {
            $cond8 = "Factureavoir.id=" . $id;
            // debug($cond8);die;
        } else {
            $date = date('Y-m-d');
            //$cond1 = 'Factureavoir.date >= ' . "'" . $date . "'";
            //$cond2 = 'Factureavoir.date <= ' . "'" . $date . "'";
            //$cond5 = "";
            //$date1 = $date;
            //$date2 = $date;
        }
        if (isset($this->request->data) && !empty($this->request->data)) {
            //debug($this->request->data);die;
            if (!empty($this->request->data['Recherche']['exercice_id'])) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $cond5 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____" && (!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $cond1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
                $cond5 = "";
            } 

            if ($this->request->data['Recherche']['date2'] != "__/__/____" && (!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $cond2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
                $cond5 = "";
            } 

            if (!empty($this->request->data['Recherche']['client_id'])) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $cond3 = 'Factureavoir.client_id =' . $clientid;
            }
            if (!empty($this->request->data['Recherche']['typefacture_id'])) {
                $typefactureid = $this->request->data['Recherche']['typefacture_id'];
                $cond4 = 'Factureavoir.typefacture_id =' . $typefactureid;
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
                $cond6 = 'Factureavoir.pointdevente_id in (' . $ch_pv . ')';
                $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societe_id)));
            }


            if ($this->request->data['Recherche']['pointdevente_id']) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                $cond7 = 'Factureavoir.pointdevente_id =' . $pointdevente_id;
            }
        }
        $factureavoirs = $this->Factureavoir->find('all', array('conditions' => array('Factureavoir.id > ' => 0, @$pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6, @$cond7, @$cond8)));
        //debug($factureavoirs);       

        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)));
        $typefactures = $this->Typefacture->find('list');
        $societes = $this->Societe->find('list', array('conditions' => array('Societe.id in (' . $soc . ')')));
        ///$this->request->data['Recherche']['date1'] = date("d/m/y", strtotime(str_replace('/', '-', @$date1)));
       // $this->request->data['Recherche']['date1'] = date("d/m/y", strtotime(str_replace('/', '-', @$date2)));
        $this->set(compact('pointdeventes', 'societes', 'pointdevente_id', 'societe_id', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'typefactures', 'factureavoirs'));
    }


    //************ zeinab *******************//
    public function imprimerexcel() {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirs') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Client');
        //debug($this->request->query);die;
        $this->layout = '';
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            $cond3 = 'Factureavoir.client_id =' . $clientid;
        }
        $this->loadModel('Client');
        $this->loadModel('Typefacture');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        if ($this->request->query['societe_id']) {
            $societe_id = $this->request->query['societe_id'];
            $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
            $ch_pv = 0;
            foreach ($lespvs as $lespv) {
                $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
            }
            $cond6 = 'Factureavoir.pointdevente_id in (' . $ch_pv . ')';
        }

        if ($this->request->query['pointdevente_id']) {
            $pointdevente_id = $this->request->query['pointdevente_id'];
            $cond7 = 'Factureavoir.pointdevente_id =' . $pointdevente_id;
        }
        if (!empty($this->request->query['typefacture_id'])) {
            $typefactureid = $this->request->query['typefacture_id'];
            $cond4 = 'Factureavoir.typefacture_id =' . $typefactureid;
        }

        $factureavoirs = $this->Factureavoir->find('all', array('conditions' => array('Factureavoir.id > ' => 0, @$pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6, @$cond7, @$cond8)));
        $this->set(compact('pointdeventes', 'typefactureid', 'societes', 'pointdevente_id', 'societe_id', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'typefactures', 'factureavoirs', $this->paginate()));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirs') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Typefacture');
        if (!$this->Factureavoir->exists($id)) {
            throw new NotFoundException(__('Invalid factureavoir'));
        }
        $options = array('conditions' => array('Factureavoir.' . $this->Factureavoir->primaryKey => $id));
        $this->set('factureavoir', $this->Factureavoir->find('first', $options));
        $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $id)));
        $typefacture = $factureavoir['Factureavoir']['typefacture_id'];
        if ($typefacture == 1) {
            $Lignefactureavoirs = $this->Lignefactureavoir->find('all', array('conditions' => array('Lignefactureavoir.factureavoir_id' => $id)));
        }
        $this->set(compact('Lignefactureavoirs', 'typefacture'));
    }

    public function imprimerfavr($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirs') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Typefacture');
        if (!$this->Factureavoir->exists($id)) {
            throw new NotFoundException(__('Invalid factureavoir'));
        }
        $options = array('conditions' => array('Factureavoir.' . $this->Factureavoir->primaryKey => $id));
        $this->set('factureavoir', $this->Factureavoir->find('first', $options));
        $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $id)));
        $typefacture = $factureavoir['Factureavoir']['typefacture_id'];
        if ($typefacture == 1) {
            $Lignefactureavoirs = $this->Lignefactureavoir->find('all', array('conditions' => array('Lignefactureavoir.factureavoir_id' => $id)));
        }
        $this->set(compact('Lignefactureavoirs', 'typefacture'));
    }

    public function imprimerfavf($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirs') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Factureavoir->exists($id)) {
            throw new NotFoundException(__('Invalid factureavoir'));
        }
        $this->loadModel('Imputationfactureavoir');
        $imputationfactureavoirs = $this->Imputationfactureavoir->find('all', array(
            'conditions' => array('Imputationfactureavoir.factureavoir_id' => $id),
            'recursive' => 0,
            'contain' => array('Factureclient.numero')
        ));
//        debug($imputationfactureavoirs);die;
        $options = array('conditions' => array('Factureavoir.' . $this->Factureavoir->primaryKey => $id));
        $factureavoir = $this->Factureavoir->find('first', $options);
        $this->set(compact('imputationfactureavoirs', 'factureavoir'));
    }

    public function add() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirs') {
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
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Factureclient');
        $this->loadModel('Pointdevente');
        if ($this->request->is('post')) {
//            debug($this->request->data);
//            die;
            $this->request->data['Factureavoir']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoir']['date'])));
            $this->request->data['Factureavoir']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureavoir']['typefacture_id'] = 2;
            if (empty($this->request->data['Factureavoir']['pointdevente_id'])) {
                $this->request->data['Factureavoir']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Factureavoir']['exercice_id'] = date("Y");


            $this->Factureavoir->create();
            if ($this->Factureavoir->save($this->request->data)) {
                $id = $this->Factureavoir->id;
                $this->misejour("Factureavoir", "add", $id);
                // Imputation sur des factures
                $this->loadModel('Imputationfactureavoir');
                if (!empty($this->request->data['Imputationfacture'])) {
                    foreach ($this->request->data['Imputationfacture'] as $imputation) {
                        if ($imputation['supfac'] != 1) {
                            if ($imputation['factureclient_id'] != "") {
                                $imputation['factureavoir_id'] = $id;
                                $this->Imputationfactureavoir->create();
                                if ($this->Imputationfactureavoir->save($imputation)) {
                                    $this->Factureavoir->updateAll(array('Factureavoir.montant_regle ' => 'Factureavoir.montant_regle+' . $imputation['montant']), array('Factureavoir.id' => $id));
                                    $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler+' . $imputation['montant']), array('Factureclient.id' => $imputation['factureclient_id']));
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
        // debug($pv);
        if ($pv != 0) {
            $numero = $this->Factureavoir->find('all', array('fields' => array('MAX(Factureavoir.numeroconca) as num'),
                'conditions' => array('Factureavoir.pointdevente_id' => $pv, 'Factureavoir.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Factureavoir->find('first',array('conditions'=>array('Factureavoir.numeroconca'=>$n)));
//  $anne=$getexercice['Factureavoir']['exercice_id'];  
//  if ($anne==date("Y")){
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

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            $mm = 0;
        }
        //debug($numspecial);  
        //$articles = $this->Article->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Factureavoir->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)));
        //$clients = $this->Factureavoir->Client->find('list');
        $utilisateurs = $this->Factureavoir->Utilisateur->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $typefactures = $this->Factureavoir->Typefacture->find('list');
        $timbre = $this->Factureavoir->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('pointdeventes', 'numspecial', 'clients', 'utilisateurs', 'timbre', 'depots', 'typefactures', 'mm', 'articles'));
    }

    public function addfactureavoir() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirs') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Factureavoir');
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Depot');
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Factureclient');
        $this->loadModel('Pointdevente');
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Factureavoir']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoir']['date'])));
            $this->request->data['Factureavoir']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureavoir']['typefacture_id'] = 1;
            //$this->request->data['Factureavoir']['typefacture_id']=2;//modifier 19/04/2016
//                     if($this->request->data['Factureavoir']['typefacture_id']==2){
//                        $this->request->data['Factureavoir']['totalttc']=$this->request->data['Factureavoir']['totalttc']+0.500;         
//                             }
            if (empty($this->request->data['Factureavoir']['pointdevente_id'])) {
                $this->request->data['Factureavoir']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Factureavoir']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Factureavoir']['pointdevente_id'];
            }
            $numero = $this->Factureavoir->find('all', array('fields' => array('MAX(Factureavoir.numeroconca) as num'),
                'conditions' => array('Factureavoir.pointdevente_id' => $pv, 'Factureavoir.exercice_id' => date("Y")))
            );
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Factureavoir->find('first',array('conditions'=>array('Factureavoir.numeroconca'=>$n)));
//  $anne=$getexercice['Factureavoir']['exercice_id'];  
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


            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");

            $this->request->data['Factureavoir']['numeroconca'] = $mm;
            $this->request->data['Factureavoir']['numero'] = $numspecial;
            if ($this->request->data['Factureavoir']['timbre_id'] == 0) {
                $this->request->data['Factureavoir']['timbre_id'] = 0;
            }
            $this->Factureavoir->create();
            if ($this->Factureavoir->save($this->request->data)) {
                $id = $this->Factureavoir->id;
                $this->misejour("Factureavoir", "add", $id);
                $Lignefactureavoirs = array();
                $stockdepots = array();
                if (isset($this->request->data['Lignefactureclient'])) {
                    foreach ($this->request->data['Lignefactureclient'] as $numl => $f) {
                        //  debug($f);die;
                        if ($f['sup'] != 1) {
                            $stockdepots[$numl]['depot_id'] = $f['depot_id'];
                            $stockdepots[$numl]['article_id'] = $f['article_id'];
                            $stockdepots[$numl]['quantite'] = $f['quantite'];
                            $Lignefactureavoirs['factureavoir_id'] = $id;
                            $Lignefactureavoirs['depot_id'] = $f['depot_id'];
                            $Lignefactureavoirs['article_id'] = $f['article_id'];
                            $Lignefactureavoirs['quantite'] = $f['quantite'];
                            $Lignefactureavoirs['remise'] = $f['remise'];
                            $Lignefactureavoirs['tva'] = $f['tva'];
                            $Lignefactureavoirs['prix'] = $f['prixhtva'];
                            $Lignefactureavoirs['prixnet'] = $f['prixnet'];
                            $Lignefactureavoirs['puttc'] = $f['puttc'];
                            $Lignefactureavoirs['totalhtans'] = $f['totalhtans'];
                            $Lignefactureavoirs['totalht'] = $f['totalht'];
                            $Lignefactureavoirs['totalttc'] = $f['totalttc'];
                            $this->Lignefactureavoir->create();
                            $this->Lignefactureavoir->save($Lignefactureavoirs);

                            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $stockdepots[$numl]['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
                            if (!empty($stckdepot)) {
                                $stockdepots[$numl]['quantite'] = $stockdepots[$numl]['quantite'] + $stckdepot[0]['Stockdepot']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                            } else {
                                $this->Stockdepot->create();
                                $this->Stockdepot->save($stockdepots[$numl]);
                            }

                            //$this->stock($f['depot_id'],$f['article_id']);
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
            $numero = $this->Factureavoir->find('all', array('fields' => array('MAX(Factureavoir.numeroconca) as num'),
                'conditions' => array('Factureavoir.pointdevente_id' => $pv, 'Factureavoir.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Factureavoir->find('first',array('conditions'=>array('Factureavoir.numeroconca'=>$n)));
//  $anne=$getexercice['Factureavoir']['exercice_id'];  
//  if ($anne==date("Y")){
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

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            $mm = 0;
        }

        //$articles = $this->Article->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Factureavoir->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)));
        //$clients = $this->Factureavoir->Client->find('list');
        $utilisateurs = $this->Factureavoir->Utilisateur->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $typefactures = $this->Factureavoir->Typefacture->find('list');
        $timbre = $this->Factureavoir->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('pointdeventes', 'numspecial', 'clients', 'utilisateurs', 'timbre', 'depots', 'typefactures', 'mm', 'articles', 'lignefactureclients', 'Factureclient'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirs') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Factureclient');
        $this->loadModel('Pointdevente');
        if (!$this->Factureavoir->exists($id)) {
            throw new NotFoundException(__('Invalid factureavoir'));
        }
        $Factureavoirs = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $id), 'recursive' => -1));
        //debug($Factureavoirs['Factureavoir']['factureclient_id']);
        if ($this->request->is('post') || $this->request->is('put')) {
//             debug( $this->request->data);die;
            $this->request->data['Factureavoir']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoir']['date'])));
            $this->request->data['Factureavoir']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureavoir']['typefacture_id'] = 2;
            $this->request->data['Factureavoir']['timbre_id'] = 0;
            if (empty($this->request->data['Factureavoir']['pointdevente_id'])) {
                $this->request->data['Factureavoir']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            //$this->request->data['Factureavoir']['exercice_id'] = date("Y");
            if ($this->Factureavoir->save($this->request->data)) {
                $this->misejour("Factureavoir", "edit", $id);
                //*****************************Remise à l'état initiale : imputation
                $this->loadModel('Imputationfactureavoir');
                $imputationfactureavoirs = $this->Imputationfactureavoir->find('all', array('conditions' => array('Imputationfactureavoir.factureavoir_id' => $id), 'recursive' => -1));
                if (!empty($imputationfactureavoirs)) {
                    foreach ($imputationfactureavoirs as $imputation) {
                        $this->Factureavoir->updateAll(array('Factureavoir.montant_regle ' => 'Factureavoir.montant_regle-' . $imputation['Imputationfactureavoir']['montant']), array('Factureavoir.id' => $id));
                        $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler-' . $imputation['Imputationfactureavoir']['montant']), array('Factureclient.id' => $imputation['Imputationfactureavoir']['factureclient_id']));
                    }
                    $this->Imputationfactureavoir->deleteAll(array('Imputationfactureavoir.factureavoir_id' => $id), false);
                }
                // Imputation sur des factures
                if (!empty($this->request->data['Imputationfacture'])) {
                    foreach ($this->request->data['Imputationfacture'] as $imputation) {
                        if ($imputation['supfac'] != 1) {
                            if ($imputation['factureclient_id'] != "") {
                                $imputation['factureavoir_id'] = $id;
                                $this->Imputationfactureavoir->create();
                                if ($this->Imputationfactureavoir->save($imputation)) {
                                    $this->Factureavoir->updateAll(array('Factureavoir.montant_regle ' => 'Factureavoir.montant_regle+' . $imputation['montant']), array('Factureavoir.id' => $id));
                                    $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler+' . $imputation['montant']), array('Factureclient.id' => $imputation['factureclient_id']));
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
        } else {
            $options = array('conditions' => array('Factureavoir.' . $this->Factureavoir->primaryKey => $id));
            $this->request->data = $this->Factureavoir->find('first', $options);
        }
        $typefacture = $this->request->data['Factureavoir']['typefacture_id'];
        $totfacture = $this->request->data['Factureavoir']['totalttc'];
        if ($typefacture == 1) {
            $Lignefactureavoirs = $this->Lignefactureavoir->find('all', array('conditions' => array('Lignefactureavoir.factureavoir_id' => $id), 'order' => array('Lignefactureavoir.id' => 'ASC')));
        }
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Factureavoir']['date'])));
        //$articles = $this->Article->find('list');
        //$clients = $this->Factureavoir->Client->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Factureavoir->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)));
        $utilisateurs = $this->Factureavoir->Utilisateur->find('list');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->loadModel('Imputationfactureavoir');
        $listeimputationfactureavoirs = $this->Imputationfactureavoir->find('all', array('conditions' => array('Imputationfactureavoir.factureavoir_id' => $id), 'recursive' => -1));
        if (!empty($listeimputationfactureavoirs)) {
            $fac = '';
            foreach ($listeimputationfactureavoirs as $ad) {
                $fac = $fac . ',' . $ad['Imputationfactureavoir']['factureclient_id'];
            }
        } else {
            $fac = 0;
        }
        $factureclients = $this->Factureclient->find('list', array('fields' => array('Factureclient.numero'), 'conditions' => array('Factureclient.client_id' => $this->request->data['Factureavoir']['client_id'], '(Factureclient.totalttc > Factureclient.Montant_Regler OR Factureclient.id in (0' . $fac . '))'), 'recursive' => -1));
        $this->loadModel('Imputationfactureavoir');
        $imputationfactureavoirs = $this->Imputationfactureavoir->find('all', array('conditions' => array('Imputationfactureavoir.factureavoir_id' => $id), 'recursive' => -1));
        $this->set(compact('imputationfactureavoirs', 'factureclients', 'pointdeventes', 'clients', 'articles', 'utilisateurs', 'timbre', 'depots', 'typefactures', 'Lignefactureavoirs', 'date', 'typefacture', 'factureclients', 'factureclient'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirs') {
                    $x = $liens['delete'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Stockdepot');
        $this->loadModel('Factureclient');
        $this->loadModel('Articlecomposante');

        $this->Factureavoir->id = $id;
        if (!$this->Factureavoir->exists()) {
            throw new NotFoundException(__('Invalid factureavoir'));
        }

        $this->request->onlyAllow('post', 'delete');
        $facavoir = $this->Factureavoir->find('first', array(
            'conditions' => array('Factureavoir.id' => $id),
            'recursive' => -1
        ));
//        debug($facavoir);
//        die;
        //*****************************Remise à l'état initiale : imputation
        $this->loadModel('Imputationfactureavoir');

        $imputationfactureavoirs = $this->Imputationfactureavoir->find('all', array('conditions' => array('Imputationfactureavoir.factureavoir_id' => $id), 'recursive' => -1));
        if (!empty($imputationfactureavoirs)) {
            foreach ($imputationfactureavoirs as $imputation) {
                $this->Factureavoir->updateAll(array('Factureavoir.montant_regle ' => 'Factureavoir.montant_regle-' . $imputation['Imputationfactureavoir']['montant']), array('Factureavoir.id' => $id));
                $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler-' . $imputation['Imputationfactureavoir']['montant']), array('Factureclient.id' => $imputation['Imputationfactureavoir']['factureclient_id']));
            }
            $this->Imputationfactureavoir->deleteAll(array('Imputationfactureavoir.factureavoir_id' => $id), false);
        }
        if ($facavoir['Factureavoir']['typefacture_id'] == 2) {
            $Lignefactureavoirs = $this->Lignefactureavoir->find('all', array('conditions' => array('Lignefactureavoir.factureavoir_id' => $id)));
            foreach ($Lignefactureavoirs as $i => $Lignefactureavoir) {
                $qte_sorti = $Lignefactureavoir['Lignefactureavoir']['quantite'];
                if ($Lignefactureavoir['Lignefactureavoir']['composee'] == 1) {
                    $articlescomposantes = $this->Articlecomposante->find('all', array(
                        'conditions' => array('Articlecomposante.article_id' => $Lignefactureavoir['Lignefactureavoir']['article_id'])
                    ));
                    foreach ($articlescomposantes as $k => $articlescomposante) {
                        $qte_vendu = $qte_sorti * $articlescomposante['Articlecomposante']['qte'];
                        $stckdepot = $this->Stockdepot->find('first', array(
                            'conditions' => array('Stockdepot.article_id' => $articlescomposante['Articlecomposante']['composant'],
                                'Stockdepot.depot_id' => $Lignefactureavoir['Lignefactureavoir']['depot_id']), false));
                        if (!empty($stckdepot)) {
                            $qte = $stckdepot['Stockdepot']['quantite'] - $qte_vendu;
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                        } else {
                            $stkn = array();
                            $stkn['depot_id'] = $Lignefactureavoir['Lignefactureavoir']['depot_id'];
                            $stkn['article_id'] = $articlescomposante['Articlecomposante']['composant'];
                            $stkn['quantite'] = 0 - $qte_vendu;
                            $this->Stockdepot->create();
                            $this->Stockdepot->save($stkn);
                        }
                    }
                } else {
                    $stckdepot = $this->Stockdepot->find('first', array(
                        'conditions' => array('Stockdepot.article_id' => $Lignefactureavoir['Lignefactureavoir']['article_id'],
                            'Stockdepot.depot_id' => $Lignefactureavoir['Lignefactureavoir']['depot_id']), false));
                    if (!empty($stckdepot)) {
                        $qte = $stckdepot['Stockdepot']['quantite'] - $qte_sorti;
                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                    } else {
                        $stkn = array();
                        $stkn['depot_id'] = $Lignefactureavoir['Lignefactureavoir']['depot_id'];
                        $stkn['article_id'] = $Lignefactureavoir['Lignefactureavoir']['article_id'];
                        $stkn['quantite'] = 0 - $qte_sorti;
                        $this->Stockdepot->create();
                        $this->Stockdepot->save($stkn);
                    }
                }
            }
            $this->Lignefactureavoir->deleteAll(array('Lignefactureavoir.factureavoir_id' => $id), false);
        }

        $numansar = $facavoir['Factureavoir']['numero'];
        $pvansar = $facavoir['Factureavoir']['pointdevente_id'];
        if ($this->Factureavoir->delete()) {
             if ($facavoir['Factureavoir']['typefacture_id'] == 1){
                $this->Factureclient->updateAll(array('Factureclient.factureavoir_id'=> 0),array('Factureclient.id'=>$facavoir['Factureavoir']['factureclient_id']));
             }
            $this->misejour("Factureavoir", $numansar, $id,$pvansar);
            $this->Session->setFlash(__('Factureavoir deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Factureavoir was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function getfactures() {
        $this->layout = null;
        $this->loadModel('Factureclient');

        $data = $this->request->data;
        $clientid = $data['clientid'];

        $factureclients = $this->Factureclient->find('all', array('conditions' => array('Factureclient.client_id' => $clientid, 'Factureclient.totalttc>Factureclient.Montant_Regler'), 'recursive' => -1));
        $select = "<select name='factureclient_id' champ='factureclient_id' id='factureclient_id' class='form-control  select ' onchange=''>";
        $select = $select . "<option value=''>veullier choisir</option>";
        foreach ($factureclients as $v) {
            $select = $select . "<option value=" . $v['Factureclient']['id'] . ">" . $v['Factureclient']['numero'] . "</option>";
        }
        $select = $select . '</select>';

        echo $select;
        die;
    }

    public function getmontantfav() {
        $this->layout = null;
        $data = $this->request->data; //debug($data);
        $json = null;
        $factureavoir_id = $data['id'];
        //debug($data);
        $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $factureavoir_id), false));

        $montant = $factureavoir['Factureavoir']['totalttc'];

        //debug($montant);die;
        echo json_encode(array('factureavoir_id' => $factureavoir_id, 'montant' => $montant));
        die();
    }

}
