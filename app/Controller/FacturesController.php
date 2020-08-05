<?php

App::uses('AppController', 'Controller');

/**
 * Factures Controller
 *
 * @property Facture $Facture
 */
class FacturesController extends AppController {

   public function addfactureavoir($idfc = null) {
        $id_bn_reception = $idfc;
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
            $this->request->data['Factureavoirfr']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureavoirfr']['typefacture_id'] = 1;
            $this->request->data['Factureavoirfr']['facture_id'] = $idfc;
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
                $this->Facture->updateAll(array('Facture.factureavoirfr_id' => $id), array('Facture.id' => $idfc));
                $Lignefactureavoirfrs = array();
                $stockdepots = array();
                if (isset($this->request->data['Lignefacture'])) {
                    foreach ($this->request->data['Lignefacture'] as $numl => $f) {
                        if ($f['sup'] != 1) {
                            if (!empty($f['article_id']) && !empty($f['quantite'])) {
                                $stockdepots[$numl]['depot_id'] = $depot;
                                $stockdepots[$numl]['article_id'] = $f['article_id'];
                                $stockdepots[$numl]['quantite'] = $f['quantite'];
                                $Lignefactureavoirfrs['factureavoirfr_id'] = $id;
                                $Lignefactureavoirfrs['depot_id'] = $depot;
                                $Lignefactureavoirfrs['article_id'] = $f['article_id'];
                                $Lignefactureavoirfrs['lignefacture_id'] = $f['id'];
                                $Lignefactureavoirfrs['quantite'] = $f['quantite'];
                                $Lignefactureavoirfrs['remise'] = $f['remise'];
                                $Lignefactureavoirfrs['tva'] = $f['tva'];
                                $Lignefactureavoirfrs['prix'] = $f['prix'];
                                $Lignefactureavoirfrs['prixnet'] = $f['prixnet'];
                                $Lignefactureavoirfrs['puttc'] = $f['puttc'];
                                $Lignefactureavoirfrs['totalhtans'] = $f['totalhtans'];
                                $Lignefactureavoirfrs['totalht'] = $f['totalht'];
                                $Lignefactureavoirfrs['totalttc'] = $f['totalttc'];
                                $this->Lignefactureavoirfr->create();
                                if ($this->Lignefactureavoirfr->save($Lignefactureavoirfrs)) {
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
        $lignefactures = $this->Lignefacture->find('all', array('conditions' => array('Lignefacture.facture_id' => $idfc), 'order' => array('Lignefacture.id' => 'ASC')));
        $facture = $this->Facture->find('all', array('conditions' => array('Facture.id' => $idfc)));
//        debug($facture);   
        $dep = @$facture[0]['Lignefacture'][0]['depot_id'];
//        debug($dep);die;
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
            $poinvente = $facture[0]['Facture']['pointdevente_id'];
            $numero = $this->Factureavoirfr->find('all', array('fields' => array('MAX(Factureavoirfr.numeroconca) as num'),
                'conditions' => array('Factureavoirfr.pointdevente_id' => $poinvente, 'Factureavoirfr.exercice_id' => date("Y")))
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

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $poinvente)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        }
        //$articles = $this->Article->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Facture->Fournisseur->find('list', array(
            'conditions' => array('Fournisseur.societe' => $composantsoc)));
        $utilisateurs = $this->Facture->Utilisateur->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
//        debug($depots);die;
//        $typefactures = $this->Facture->Typefacture->find('list');
        $timbre = $this->Facture->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('idfc', 'dep', 'poinvente', 'pointdeventes', 'numspecial', 'fournisseurs', 'utilisateurs', 'timbre', 'depots', 'typefactures', 'mm', 'articles', 'lignefactures', 'facture'));
    }

    public function index($id = null) {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factures') {
                    $facture = 1;
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel('Utilisateur');
        $this->loadModel('Exercice');
        $this->loadModel('Societe');
        $this->loadModel('Pointdevente');
        $exercices = $this->Exercice->find('list');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
//        $soc = CakeSession::read('soc');
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Facture.pointdevente_id = ' . $p;
        }
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $conda = 'Facture.exercice_id =' . $exe;
        $socc = CakeSession::read('soc');
        $pvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id in (' . $socc . ')')));
        $liste_pv = '0';
        foreach ($pvs as $one_pv) {
            if (!empty($one_pv['Pointdevente']['id'])) {
                $liste_pv = $liste_pv . ',' . $one_pv['Pointdevente']['id'];
            }
        }
        //$cond6 = 'Facture.pointdevente_id in(' . $liste_pv . ')';
        if (!empty($id)) {
            $cond8 = "Facture.id=" . $id;
        } else {
            $limit = 100;
//            $date = date('Y-m-d');
//            $cond1 = 'Facture.date >= ' . "'" . $date . "'";
//            $cond2 = 'Facture.date <= ' . "'" . $date . "'";
//            $cond4 = "";
//            $date1 = $date;
//            $date2 = $date;
//            
        }

        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Factures"))) {
//debug($this->request->data);
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', @$this->request->data['Recherche']);
            } else {
                $this->request->data['Recherche'] = CakeSession::read('recherche');
            }
            
            if (!empty($this->request->data['Recherche']['exercice_id'])) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $conda = 'Facture.exercice_id =' . $exercices[$exerciceid];
            }

            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', @$this->request->data['Recherche']['date1'])));
                $cond1 = 'Facture.date >= ' . "'" . $date1 . "'";
                $conda="";
            }

            if (($this->request->data['Recherche']['date2']) != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', @$this->request->data['Recherche']['date2'])));
                $cond2 = 'Facture.date <= ' . "'" . $date2 . "'";
                $conda="";
            }
//debug($this->request->data['Recherche']['date2']);
            if (!empty($this->request->data['Recherche']['fournisseur_id'])) {
                $fournisseurid = $this->request->data['Recherche']['fournisseur_id'];
                $cond3 = 'Facture.fournisseur_id =' . $fournisseurid;
            }
//        $user=CakeSession::read('users');
//            $cond4 = 'Facture.utilisateur_id ='.$user;

            if (!empty($this->request->data['Recherche']['type_id'])) {
                $typeid = $this->request->data['Recherche']['type_id'];
                if ($typeid == 2) {
                    $type = "service";
                    $cond5 = 'Facture.type =' . "'" . $type . "'";
                } else {
                    $type = "service";
                    $cond5 = 'Facture.type <>' . "'" . $type . "'";
                }
            }
            


            $this->loadModel('Utilisateur');
            $this->loadModel('Pointdevente');
            $this->loadModel('Societe');
            $this->loadModel('Personnel');
            if (!empty($this->request->data['Recherche']['societe_id'])) {
                $societe_id = $this->request->data['Recherche']['societe_id'];
                $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
                $ch_pv = 0;
                foreach ($lespvs as $lespv) {
                    $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
                }
                //$cond6 = 'Facture.pointdevente_id in (' . $ch_pv . ')';
                $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societe_id)));
            }


            if (!empty($this->request->data['Recherche']['pointdevente_id'])) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                $cond7 = 'Facture.pointdevente_id =' . $pointdevente_id;
            }
            if ($this->request->data['Recherche']['numero']) {
                $fac_id = $this->request->data['Recherche']['numero'];
                $cond10 = 'Facture.numerofrs LIKE "%' . $fac_id.'%"';
                $cond1 = "";
                $cond2 = "";
                $conda = "";
                $pv="";
            }
            $limit = 100000;
        }
//        debug($cond6);die;
        $factures = $this->Facture->find('all', array(
            'conditions' => array('Facture.nature' => 'achat', @$conda, @$pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6, @$cond7, @$cond8, @$cond10),
            'limit'=>@$limit,
            'order'=>array('Facture.date'=>'desc'),
            'recursive'=>0
            ));
//        debug($factures); die;
        $types[1] = "Achat produits";
        $types[2] = "Services";
//        $societes = $this->Societe->find('list', array('conditions' => array('Societe.id in (' . $soc . ')')));
        $soc = CakeSession::read('soc');
        $sos = explode(',', $soc);
        $countsos = count($sos);
        if ($countsos > 1) {
            $societes = $this->Societe->find('list', array(
                'conditions' => array('Societe.id in' => $sos)
            ));
        }
//        if (isset($date1)) {
//            $this->request->data['Recherche']['date1'] = date("d/m/Y", strtotime(str_replace('/', '-', $date1)));
//        }
//        if (isset($date2)) {
//            $this->request->data['Recherche']['date2'] = date("d/m/Y", strtotime(str_replace('/', '-', $date2)));
//        }
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1,
                'Fournisseur.societe' => $composantsoc)));
        $utilisateurs = $this->Utilisateur->find('list');
        $this->loadModel('Typedipliquation');
        $typedipliquations = $this->Typedipliquation->find('list');
        $this->set(compact('fac_id', 'countsos', 'exerciceid', 'exercices', 'typedipliquations', 'date1', 'date2', 'societes', 'societe_id', 'pointdeventes', 'pointdevente_id', 'fournisseurid', 'utilisateurid', 'fournisseurs', 'typeid', 'types', 'utilisateurs', 'factures'));
    }
    
    
    public function indexdep($id = null) {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factures') {
                    $facture = 1;
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel('Utilisateur');
        $this->loadModel('Exercice');
        $this->loadModel('Societe');
        $this->loadModel('Pointdevente');
        $exercices = $this->Exercice->find('list');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
//        $soc = CakeSession::read('soc');
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Facture.pointdevente_id = ' . $p;
        }
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $conda = 'Facture.exercice_id =' . $exe;
        $socc = CakeSession::read('soc');
        $pvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id in (' . $socc . ')')));
        $liste_pv = '0';
        foreach ($pvs as $one_pv) {
            if (!empty($one_pv['Pointdevente']['id'])) {
                $liste_pv = $liste_pv . ',' . $one_pv['Pointdevente']['id'];
            }
        }
        $cond6 = 'Facture.pointdevente_id in(' . $liste_pv . ')';
        if (!empty($id)) {
            $cond8 = "Facture.id=" . $id;
        } else {
            $limit = 100;
//            $date = date('Y-m-d');
//            $cond1 = 'Facture.date >= ' . "'" . $date . "'";
//            $cond2 = 'Facture.date <= ' . "'" . $date . "'";
//            $cond4 = "";
//            $date1 = $date;
//            $date2 = $date;
//            
        }

        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Factures"))) {

            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', @$this->request->data['Recherche']);
            } else {
                $this->request->data['Recherche'] = CakeSession::read('recherche');
            }
            
            if (!empty($this->request->data['Recherche']['exercice_id'])) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $conda = 'Facture.exercice_id =' . $exercices[$exerciceid];
            }

            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', @$this->request->data['Recherche']['date1'])));
                $cond1 = 'Facture.date >= ' . "'" . $date1 . "'";
                $conda="";
            }

            if (!empty($this->request->data['Recherche']['date2']) != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', @$this->request->data['Recherche']['date2'])));
                $cond2 = 'Facture.date <= ' . "'" . $date2 . "'";
                $conda="";
            }

            if (!empty($this->request->data['Recherche']['fournisseur_id'])) {
                $fournisseurid = $this->request->data['Recherche']['fournisseur_id'];
                $cond3 = 'Facture.fournisseur_id =' . $fournisseurid;
            }
//        $user=CakeSession::read('users');
//            $cond4 = 'Facture.utilisateur_id ='.$user;

            if (!empty($this->request->data['Recherche']['type_id'])) {
                $typeid = $this->request->data['Recherche']['type_id'];
                if ($typeid == 2) {
                    $type = "service";
                    $cond5 = 'Facture.type =' . "'" . $type . "'";
                } else {
                    $type = "service";
                    $cond5 = 'Facture.type <>' . "'" . $type . "'";
                }
            }
            


            $this->loadModel('Utilisateur');
            $this->loadModel('Pointdevente');
            $this->loadModel('Societe');
            $this->loadModel('Personnel');
            if (!empty($this->request->data['Recherche']['societe_id'])) {
                $societe_id = $this->request->data['Recherche']['societe_id'];
                $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
                $ch_pv = 0;
                foreach ($lespvs as $lespv) {
                    $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
                }
                $cond6 = 'Facture.pointdevente_id in (' . $ch_pv . ')';
                $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societe_id)));
            }


            if (!empty($this->request->data['Recherche']['pointdevente_id'])) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                $cond7 = 'Facture.pointdevente_id =' . $pointdevente_id;
            }
            if ($this->request->data['Recherche']['fac_id']) {
                $fac_id = $this->request->data['Recherche']['fac_id'];
                $cond10 = 'Facture.id =' . $fac_id;
                $cond1 = "";
                $cond2 = "";
                $conda = "";
            }
            $limit = 100000;
        }
//        debug($cond6);die;
        $factures = $this->Facture->find('all', array(
            'conditions' => array('Facture.nature' => 'depense', @$conda, @$pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6, @$cond7, @$cond8, @$cond10),
            'limit'=>@$limit,
            'order'=>array('Facture.id'=>'desc')
            ));
//        debug($factures); die;
        $types[1] = "Achat produits";
        $types[2] = "Services";
//        $societes = $this->Societe->find('list', array('conditions' => array('Societe.id in (' . $soc . ')')));
        $soc = CakeSession::read('soc');
        $sos = explode(',', $soc);
        $countsos = count($sos);
        if ($countsos > 1) {
            $societes = $this->Societe->find('list', array(
                'conditions' => array('Societe.id in' => $sos)
            ));
        }
//        if (isset($date1)) {
//            $this->request->data['Recherche']['date1'] = date("d/m/Y", strtotime(str_replace('/', '-', $date1)));
//        }
//        if (isset($date2)) {
//            $this->request->data['Recherche']['date2'] = date("d/m/Y", strtotime(str_replace('/', '-', $date2)));
//        }
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1,
                'Fournisseur.societe' => $composantsoc)));
        $utilisateurs = $this->Utilisateur->find('list');
        $this->loadModel('Typedipliquation');
        $typedipliquations = $this->Typedipliquation->find('list');
        $this->set(compact('fac_id', 'countsos', 'exerciceid', 'exercices', 'typedipliquations', 'date1', 'date2', 'societes', 'societe_id', 'pointdeventes', 'pointdevente_id', 'fournisseurid', 'utilisateurid', 'fournisseurs', 'typeid', 'types', 'utilisateurs', 'factures'));
    }

    public function view($id = null, $model = null, $ligne_model = null, $attribut = null) {

        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factures') {
                    $facture = 1;
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($model);
        $this->loadModel($ligne_model);
        $this->loadModel('Pointdevente');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepot');
        $this->loadModel('Article');
        $this->loadModel('Reglement');
        $this->loadModel('Stockdepotfacture');
        $this->loadModel('Depot');
        $this->loadModel('Timbre');
        $this->loadModel('Fournisseur');
        $this->loadModel('Utilisateur');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Lignefacture');
        $this->loadModel('Facture');
        $this->loadModel('Lignereception');
        $this->loadModel('Bonreception');
        
        $options = array('conditions' => array($model . '.' . $this->$model->primaryKey => $id));
        $this->request->data = $this->$model->find('first', $options);
        $lignefactureclients = $this->$ligne_model->find('all', array('conditions' => array($ligne_model . '.' . $attribut => $id), 'order' => array($ligne_model . '.id' => 'ASC')));
        $clients = $this->Fournisseur->find('list');
        $utilisateurs = $this->Utilisateur->find('list');
        $timbre = $this->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data[$model]['date'])));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        //info client**************************************************
        $this->loadModel('Bonreception');
        $this->loadModel($model);
        $this->loadModel('Fournisseur');
        $facture = $this->$model->find('first', array('conditions' => array($model . '.id' => $id), false));
        $clientid = $facture[$model]['fournisseur_id'];
        //$name = $facture[$model]['name'];
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1)));

        $sumttc = $this->Bonreception->find('all', array('fields' => array('sum(Bonreception.totalttc) as totalttcb')
            , 'conditions' => array('Bonreception.id > ' => 0, 'Bonreception.facture_id' => 0, 'Bonreception.fournisseur_id' => $clientid, 'Bonreception.id not in (' . $id . ')')));
        $summtreg = array(); //$this->Bonreception->find('all', array('fields' => array('sum(Bonreception.Montant_Regler) as totalregb')
        //, 'conditions' => array('Bonreception.id > ' => 0, 'Bonreception.facture_id' => 0, 'Bonreception.fournisseur_id' => $clientid)));
        $sumttcf = $this->Facture->find('all', array('fields' => array('sum(Facture.totalttc) as totalttf')
            , 'conditions' => array('Facture.id > ' => 0, 'Facture.fournisseur_id' => $clientid, 'Facture.id not in (' . $id . ')')));
        $summtregf = array(); //$this->Facture->find('all', array('fields' => array('sum(Facture.Montant_Regler) as totalregf')
        //, 'conditions' => array('Facture.id > ' => 0, 'Facture.fournisseur_id' => $clientid)));
        $reglementlibre = $this->Reglement->find('all', array('fields' => array('sum(Reglement.Montant) as reglibretotale')
            , 'conditions' => array('Reglement.fournisseur_id' => $clientid)));
        $valbl = 0; //$sumttc[0][0]['totalttcb'] - $summtreg[0][0]['totalregb'];
        $valfac = 0; //$sumttcf[0][0]['totalttf'] - $summtregf[0][0]['totalregf'];
        $valglobal = $valbl + $valfac;
        $solde = $valglobal - $reglementlibre[0][0]['reglibretotale'];
        //fin info client************************************************
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.id' => $p)));
        }
        $this->set(compact('ligne_model', 'fournisseurs', 'model', 'typeclient_id', 'name', 'autorisation', 'solde', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'clients', 'utilisateurs', 'timbre', 'depots', 'date', 'lignefactureclients', 'articles', 'tabqtestock'));
    }

    public function imprimerbonrecption($id = null) {


        $lien = CakeSession::read('lien_achat');
        $x = "";
//debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factures') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefacture');
        if (!$this->Facture->exists($id)) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        $options = array('conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
        $this->set('factureclient', $this->Facture->find('first', $options));
        $lignefactureclients = $this->Lignefacture->find('all', array(
            'conditions' => array('Lignefacture.facture_id' => $id), 'order' => array('Lignefacture.id' => 'asc')
        ));
        $lignefactureclientstva = $this->Lignefacture->find('all', array('fields' => array(
                'SUM(Lignefacture.totalht*Lignefacture.tva)/100  mtva'
                , 'SUM(Lignefacture.totalht) totalht'
                , 'AVG(Lignefacture.tva) tva'),
            'conditions' => array('Lignefacture.facture_id' => $id)
            , 'group' => array('Lignefacture.tva')
        ));
//debug($lignefactureclients) ;
// debug($lignefactureclientstva)  ;die;  
        $this->set(compact('lignefactureclients', 'lignefactureclientstva'));
    }

    public function imprimer($id = null) {

        $this->loadModel('Lignefacture');
        $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factures') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        if (!$this->Facture->exists($id)) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        $options = array('conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
        $this->set('factureclient', $this->Facture->find('first', $options));
        $lignefactureclients = $this->Lignefacture->find('all', array(
            'conditions' => array('Lignefacture.facture_id' => $id), 'order' => array('Lignefacture.id' => 'asc')
        ));
        $lignefactureclientstva = $this->Lignefacture->find('all', array('fields' => array(
                'SUM(Lignefacture.totalht*(1+(CASE WHEN Lignefacture.fodec IS NULL THEN 0 ELSE Lignefacture.fodec END/100))*Lignefacture.tva)/100  mtva'
                , 'SUM(Lignefacture.totalht*(1+(CASE WHEN Lignefacture.fodec IS NULL THEN 0 ELSE Lignefacture.fodec END/100))) totalht'
                , 'AVG(Lignefacture.tva) tva'),
            'conditions' => array('Lignefacture.facture_id' => $id)
            , 'group' => array('Lignefacture.tva')
        ));
        //debug($lignefactureclients) ;
        // debug($lignefactureclientstva)  ;die;  
        $this->set(compact('lignefactureclients', 'lignefactureclientstva'));
    }



    public function add($model = null, $ligne_model = null, $attribut = null,$nature=null) {
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
        $this->loadModel($model);
        $this->loadModel($ligne_model);
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Timbre');
        $this->loadModel('Fournisseur');
        $this->loadModel('Utilisateur');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel($ligne_model);
        $this->loadModel('Stockdepot');
        $this->loadModel('Fournisseur');
        $this->loadModel('Tracemodificationprixdevente');
        $this->loadModel('Pointdevente');
        $this->loadModel('Articlefournisseur');

        if ($this->request->is('post')) {
            
            $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numeroconca) as num'),
                'conditions' => array($model . '.exercice_id' => date("Y"),$model.".nature='".$nature."'"))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Facture->find('first',array('conditions'=>array('Facture.numeroconca'=>$n)));
//  $anne=$getexercice['Facture']['exercice_id'];  
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
            $this->request->data[$model]['numeroconca'] = $mm;
            $this->request->data[$model]['nature'] = $nature;
			if(floatval($this->request->data[$model]['totalhtanc'])!=0 && floatval($this->request->data[$model]['tvaanc'])!=0 && floatval($this->request->data[$model]['totalttcanc'])!=0){
                $ht_anc=$this->request->data[$model]['totalht'];
                $tva_anc=$this->request->data[$model]['tva'];
                $ttc_anc=$this->request->data[$model]['totalttc'];

                $this->request->data[$model]['totalht']=$this->request->data[$model]['totalhtanc'];
                $this->request->data[$model]['tva']=$this->request->data[$model]['tvaanc'];
                $this->request->data[$model]['totalttc']=$this->request->data[$model]['totalttcanc'];

                $this->request->data[$model]['totalhtanc']=$ht_anc;
                $this->request->data[$model]['tvaanc']=$tva_anc;
                $this->request->data[$model]['totalttcanc']=$ttc_anc;                
            }
            
            $depotid = $this->request->data[$model]['depot_id'];
            $this->request->data[$model]['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            $this->request->data[$model]['datedeclaration'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['datedeclaration'])));
            $this->request->data[$model]['utilisateur_id'] = CakeSession::read('users');
            $this->request->data[$model]['type'] = 'direct';
            $fournisseur_id = $this->request->data[$model]['fournisseur_id'];
            if (empty($this->request->data[$model]['pointdevente_id'])) {
                $this->request->data[$model]['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data[$model]['exercice_id'] = date("Y", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            if (empty($this->request->data[$model]['timbre_id'])) {
                $this->request->data[$model]['timbre_id'] = 0;
            }
            if (($model == "Facture") || ($model == "Bonreception")) {
                $this->request->data[$model]['time'] = date("Y-m-d H:i:s");
            }
            
            //debug($this->request->data);die;
            
            $this->$model->create();
            if (!empty($this->request->data['Lignereception'])) {
                if ($this->$model->save($this->request->data)) {
                    $id = $this->$model->id;
                    $this->misejour($model, "add", $id);
                    // debug($id);die;
                    $Lignefactureclients = array();
                    $stockdepots = array();
                    // debug($this->request->data );die;
                    foreach ($this->request->data['Lignereception'] as $numl => $f) {
                        //debug($f);die;
                        if ($f['sup'] != 1) {
                            if ($f['article_id'] != "") {
                                $f['depot_id'] = $this->request->data[$model]['depot_id'];
                                if ($f['qtebonus'] == '') {
                                    $f['qtebonus'] = 0;
                                }
                                $Lignefactureclients['qtebonus'] = $f['qtebonus'];
                                $stockdepots[$numl]['quantite'] = $f['quantite'] + $f['qtebonus'];
                                $Lignefactureclients[$attribut] = $id;
                                $Lignefactureclients['article_id'] = $f['article_id'];
                                $Lignefactureclients['depot_id'] = $f['depot_id'];
                                $Lignefactureclients['quantite'] = $f['quantite'] + $f['qtebonus'];
                                $Lignefactureclients['remise'] = $f['remise'];
                                $Lignefactureclients['tva'] = $f['tva'];
                                $Lignefactureclients['prixhtva'] = $f['prixhtva'];
                                $Lignefactureclients['prix'] = $f['prixhtva'];
                                $Lignefactureclients['designation'] = $f['designation'];
                                $Lignefactureclients['totalht'] = $f['totalht'];
                                $Lignefactureclients['totalttc'] = $f['totalttc'];
                                $Lignefactureclients['fodec'] = @$f['fodec'];
                                $Lignefactureclients['marge'] = @$f['marge'];
                                $Lignefactureclients['prixdeventeht'] = @$f['prixdeventeht'];
                                if (($model == "Facture") || ($model == "Bonreception")) {
                                    //**Enregistrement de cout et de quantité ancien
                                    $qtesum = $this->Stockdepot->find('first', array(
                                        'fields' => array('sum(Stockdepot.quantite) quantite'),
                                        'conditions' => array('Stockdepot.article_id' => $f['article_id'])));
                                    $articlepmp = $this->Article->find('first', array(
                                        'recursive' => -1,
                                        'conditions' => array('Article.id' => $f['article_id'])));
                                    $pmparticle = 0;
                                    if (!empty($articlepmp['Article']['pmp'])) {
                                        $pmparticle = $articlepmp['Article']['pmp'];
                                    }
                                    $tcc_article=$f['prixdeventeht']*(1+($articlepmp['Article']['tva']/100));
                                    $Lignefactureclients['qtestkancien'] = $qtesum[0]['quantite'];
                                    $Lignefactureclients['coutstkancien'] = $pmparticle;
                                    // Mise à jour article (marge, prix de vente)
                                    if(isset($f['checkbox'])){
                                    $this->Article->updateAll(array('Article.marge' => $f['marge'], 'Article.prixvente' => $f['prixdeventeht'],'Article.prixuttc' =>$tcc_article), array('Article.id' => $f['article_id']));
                                    }
                                }
                                //****************** zeinab ***********//
                                  
                                    if(isset($f['checkbox'])){
                                        $Lignefactureclients['check']=1; 
                                    }else{
                                        $Lignefactureclients['check']=0; 
                                    }
                                $this->$ligne_model->create();
                                $this->$ligne_model->save($Lignefactureclients);

                                /*                                 * ******** Verification des articles et mise à jour des familles ************ */
                                //debug($f);die;
                                $article_id = $f['article_id'];
                                $artdetails = $this->Article->find('first', array('conditions' => array('Article.id' => $article_id), 'recursive' => -1));
                                if ($f['famille_id'] == '' || $f['famille_id'] == null || empty($f['famille_id'])){
                                    $f['famille_id'] = "0";
                                }
                                if ($f['sousfamille_id'] == '' || $f['sousfamille_id'] == null || empty($f['sousfamille_id'])){
                                    $f['sousfamille_id'] = "0";
                                }
                                if ($f['soussousfamille_id'] == '' || $f['soussousfamille_id'] == null || empty($f['soussousfamille_id'])){
                                    $f['soussousfamille_id'] = "0";
                                }
                                if ($f['fodec'] == '' || $f['fodec'] == null || empty($f['fodec'])){
                                    $f['fodec'] = "0";
                                }
                                if ($f['remise'] == '' || $f['remise'] == null || empty($f['remise'])){
                                    $f['remise'] = "0";
                                }
                                //debug($f);die;
                                if (($model == "Facture") || ($model == "Bonreception")) {
                                    $mntremise = floatval($f['prixhtva']) * (floatval($f['remise']) / 100);
                                    $mntapresremise = floatval($f['prixhtva']) - floatval($mntremise);
                                    if ($artdetails != array()) {
                                        //debug($artdetails);die;
                                        $margebrutgros = $artdetails['Article']['margebrutgros'];
                                        $margebrutgross = floatval($f['prixhtva']) * floatval($margebrutgros) / 100;
                                        $prixventegros = floatval($f['prixhtva']) + floatval($margebrutgross);
                                        $margenet = (floatval($prixventegros) - floatval($mntapresremise)) / floatval($mntapresremise);
                                        $margebrutdetails = $artdetails['Article']['margebrutdetail'];
                                        $margebrutdetailss = floatval($f['prixhtva']) * floatval($margebrutdetails) / 100;
                                        $prixventedetails = floatval($f['prixhtva']) + floatval($margebrutdetailss);
                                        $margenetdetails = (floatval($prixventedetails) - floatval($mntapresremise)) / floatval($mntapresremise);
                                        //****************** zeinab ***********//
                                        if(isset($f['checkbox'])){
                                            $this->Article->updateAll(array(
                                            'Article.coutrevient' => ($f['prixhtva']*(1-($f['remise']/100))),
                                            'Article.prixav_remise' => $f['prixhtva'],
                                            'Article.remise' => $f['remise'],
                                            'Article.fodec' => $f['fodec'],
                                            'Article.famille_id' => $f['famille_id'],
                                            'Article.sousfamille_id' => $f['sousfamille_id'],
                                            'Article.soussousfamille_id' => $f['soussousfamille_id'])
                                                , array('Article.id' => $article_id));
                                        }else{
                                            $this->Article->updateAll(array(
                                            'Article.fodec' => $f['fodec'],
                                            'Article.famille_id' => $f['famille_id'],
                                            'Article.sousfamille_id' => $f['sousfamille_id'],
                                            'Article.soussousfamille_id' => $f['soussousfamille_id'])
                                                //'Article.prixachatnet' => $mntapresremise,
                                                //'Article.prixventegros' => $prixventegros,
                                                //'Article.margenetgros' => $margenet,
                                                //'Article.prixvente' => $prixventedetails,
                                                //'Article.margenetdetail' => $margenetdetails)
                                                , array('Article.id' => $article_id));
                                        }
                                        
                                        
                                        
                                    }
                                }

                                $artfrsdetails = $this->Articlefournisseur->find('first', array('conditions' => array('Articlefournisseur.article_id' => $article_id
                                        , 'Articlefournisseur.fournisseur_id' => $fournisseur_id), 'recursive' => -1));
                                if ($artfrsdetails == array()) {
                                    $artfrs = array();
                                    //$art['article_id']=$article_id;
                                    $artfrs['article_id'] = $article_id;
                                    $artfrs['fournisseur_id'] = $fournisseur_id;
                                    $artfrs['prix'] = $mntapresremise;
                                    $artfrs['reference'] = $f['articlefrs_id'];
                                    $this->Articlefournisseur->create();
                                    $this->Articlefournisseur->save($artfrs);
                                } else {
                                    $this->Articlefournisseur->updateAll(array('Articlefournisseur.prix' => $f['prixhtva'], 'Articlefournisseur.reference' => "'" . $f['articlefrs_id'] . "'"
                                            ), array('Articlefournisseur.article_id' => $article_id
                                        , 'Articlefournisseur.fournisseur_id' => $fournisseur_id));
                                }

                                if (($model == "Facture") || ($model == "Bonreception")) {
                                    //**Mise à jour de pmp
                                    $coutderevienttot = ($pmparticle * $qtesum[0]['quantite']) + $Lignefactureclients['totalht'];
                                    if ($qtesum[0]['quantite'] <= 0) {
                                        $coutderevient = $f['totalht'] / $f['quantite'];
                                    } else {
                                        $coutderevient = $coutderevienttot / ($qtesum[0]['quantite'] + $f['quantite']);
                                    }
                                    //debug($coutderevient);die;
                                    $this->Article->updateAll(array('Article.pmp' => $coutderevient), array('Article.id' => $f['article_id']));
                                    //** Mise à jour stock depot
                                    $stckdepot = $this->Stockdepot->find('all', array(
                                        'conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
                                    if (!empty($stckdepot)) {
                                        $qtestk = $stockdepots[$numl]['quantite'] + $stckdepot[0]['Stockdepot']['quantite'];
                                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qtestk), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                                    } else {
                                        $tab = array();
                                        $tab['depot_id'] = $Lignefactureclients['depot_id'];
                                        $tab['article_id'] = $Lignefactureclients['article_id'];
                                        $tab['quantite'] = $stockdepots[$numl]['quantite'];
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($tab);
                                    }
                                }
                            }
                        }
                    }
                    $this->Session->setFlash(__('The Facture has been saved'));
                    //$this->redirect(array('action' => 'index'));
                    $this->redirect(array('controller' => $model . 's', 'action' => 'index/' . $id));
                    //$this->redirect(array('action' => 'addbonsorti/'.$id));    
                } else {
                    $this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                }
            }
        }
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1,
                'Fournisseur.societe' => $composantsoc)));
        $utilisateurs = $this->Facture->Utilisateur->find('list');
        $timbre = $this->Facture->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        $societe = CakeSession::read('societe');
        //debug($societe);die;
        if ($societe != 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.id' => $societe, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        }
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        //$articles = $this->Article->find('list');
        //debug($articles);die;

        $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numeroconca) as num'),
            'conditions' => array($model . '.exercice_id' => date("Y")))
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
        
        $this->set(compact('nature','model', 'mm', 'fournisseurs', 'articles', 'pointdeventes', 'clients', 'timbre', 'utilisateurs', 'depots', 'mm', 'numspecial'));
    }

    public function add_anc() {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factures') {
                    $facture = $liens['add'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel($ligne_model);
        $this->loadModel('Stockdepot');
        $this->loadModel('Fournisseur');
        $this->loadModel('Tracemodificationprixdevente');
        $this->loadModel('Pointdevente');
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data[$model]['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            $this->request->data[$model]['datefacture'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['datefacture'])));
            $this->request->data[$model]['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data[$model]['pointdevente_id'])) {
                $this->request->data[$model]['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data[$model]['exercice_id'] = date("Y");

            $this->request->data[$model]['type'] = 'direct';

            //$depotid=$this->request->data[$model]['depot_id'];
            $this->Facture->create();
            if ($this->Facture->save($this->request->data)) {

                $id = $this->Facture->id;

                $this->misejour("Facture", "add", $id);
                $Lignefactures = array();
                //debug($this->request->data['Lignereception']);
                //die;
                foreach ($this->request->data['Lignereception'] as $i => $f) {

                    //debug($f);die;
                    if ($f['sup'] != 1) {


                        $Lignefactures['prixachatans'] = $f['prixachatans'];
                        $Lignefactures['margeans'] = $f['margeans'];
                        $Lignefactures['facture_id'] = $id;
                        $Lignefactures['depot_id'] = $f['depot_id'];
                        $depotid = $f['depot_id'];
                        $Lignefactures['article_id'] = $f['article_id']; //=$this->request->data[$ligne_model][$i]['article_id'];
                        $Lignefactures['quantite'] = $f['quantite'];
                        if (!empty($f['prix'])) {
                            $Lignefactures['prix'] = $f['prix'];
                            $Lignefactures['prix_anc'] = $f['prix_anc'];
                        }
                        $Lignefactures['prixhtva'] = $f['prixhtva'];
                        $Lignefactures['remise'] = @$f['remise'];
                        $Lignefactures['fodec'] = @$f['fodec'];
                        $Lignefactures['tva'] = $f['tva'];

                        $Lignefactures['prixhtva'] = $f['prixhtva'];
                        $Lignefactures['totalht'] = ($f['prixhtva'] * (1 - @$f['remise'] * 0.01)) * $f['quantite'];
                        $Lignefactures['totalttc'] = ((($Lignefactures['totalht']) * (1 + (@$f['fodec'] * 0.01))) * (1 + ($f['tva'] * 0.01)));
                        $this->Lignefacture->create();
                        $this->Lignefacture->save($Lignefactures);
                        $this->Article->updateAll(array('Article.coutrevient' => $f['prixhtva'], 'Article.tauxchange' => 1, 'Article.coefficient' => 1), array('Article.id' => $f['article_id']));
                        if ((!empty($f['margeA'])) || (!empty($f['pvA']))) {
                            $trace = array();
                            $aticle = $this->Article->find('first', array('conditions' => array('Article.id' => $f['article_id'])));
                            $marge_ans = $aticle['Article']['marge'];
                            $prixvente_ans = $aticle['Article']['prixvente'];
                            $this->Article->updateAll(array('Article.prixvente' => $f['pvA'], 'Article.marge' => $f['margeA']), array('Article.id' => $f['article_id']));
                            $trace['utilisateur_id'] = CakeSession::read('users');
                            $trace['date'] = date("Y-m-d");
                            $trace['heure'] = date("H:i", time());
                            $trace['article_id'] = $f['article_id'];
                            $trace['prixventeans'] = $prixvente_ans;
                            $trace['margeans'] = $marge_ans;
                            $trace['prixventenv'] = $f['pvA'];
                            $trace['margenv'] = $f['margeA'];
                            $this->Tracemodificationprixdevente->create();
                            $this->Tracemodificationprixdevente->save($trace);
                        }

                        $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $Lignefactures['article_id'], 'Stockdepot.depot_id' => $depotid), false));
                        if (!empty($stckdepot)) {
                            $coutderevienttot = ($stckdepot[0]['Stockdepot']['prix'] * $stckdepot[0]['Stockdepot']['quantite']) + $Lignefactures['totalht'];
                            $qte = $f['quantite'] + $stckdepot[0]['Stockdepot']['quantite'];
                            $coutderevient = $coutderevienttot / $qte;

                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $f['quantite'], 'Stockdepot.prix' => $coutderevient), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                            //$this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                        } else {
                            $f['prix'] = $Lignefactures['totalht'] / $f['quantite'];
                            $f['depot_id'] = $depotid;

                            $this->Stockdepot->create();
                            $this->Stockdepot->save($f);
                        }
                        // $this->Stockdepot->deleteAll(array('Stockdepot.article_id'=>$Lignefactures['article_id'],'Stockdepot.depot_id'=>$depotid,'Stockdepot.quantite'=>0),false);        
                        //$this->stock($depotid, $f['article_id']);
                    }
                }

                $this->Session->setFlash(__('The facture has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
            }
        }
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
        //$articles = '';
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1)));
        $utilisateurs = $this->Facture->Utilisateur->find('list');
        $timbre = $this->Facture->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        $societe = CakeSession::read('societe');
        //debug($societe);die;
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
        //$articles = $this->Article->find('list');
        //debug($articles);die;
        $this->set(compact('mm', 'fournisseurs', 'p', 'timbre', 'pointdeventes', 'utilisateurs', 'depots', 'articles'));
    }

    public function addindirect($tab = null) {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factures') {
                    $facture = $liens['add'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Pointdevente');
        $this->loadModel($ligne_model);
        $this->loadModel('Lignereception');
        $this->loadModel('Lignecommande');
        $this->loadModel('Bonreception');
        $this->loadModel('Article');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Commande');
        $this->loadModel('Stockdepot');
        $this->loadModel('Depot');
        $this->loadModel('Importation');
        $this->loadModel('Fournisseur');
        $this->loadModel('Tracemodificationprixdevente');
        $this->loadModel('Compte');
        $b = 0;
        //debug($tab.'---'.$listf);
        list($table, $listf) = explode(";", $tab);
        if ($table == 'commande') {
            $tab = $listf;
            $b = 1;
        } else {
            $tab = $listf;
            $b = 0;
        }
        $tbr = $tab . ',0)';
        list($idbr, $resteidbr) = explode(",", $tbr);
        $tbr = '(0,' . $tbr;
        $idbrs = explode(",", $tab);
        //debug($tbr);
        //debug($table);
        if ($b == 0) {
            $bonreception = $this->Bonreception->find('first', array('fields' => array('Bonreception.compte_id', 'SUM(Bonreception.remise) remise', 'SUM(Bonreception.fret) fret', 'SUM(Bonreception.avoir) avoir', 'SUM(Bonreception.fodec ) fodec ', 'SUM(Bonreception.tva) tva', 'SUM(Bonreception.totalht) totalht'
                    , 'SUM(Bonreception.totalttc) totalttc', 'AVG(Bonreception.fournisseur_id) fournisseur_id', 'AVG(Bonreception.importation_id) importation_id', 'AVG(Bonreception.coefficient) coefficient', 'AVG(Bonreception.depot_id) depot_id'), 'conditions' => array('Bonreception.id' => $idbrs), 'recursive' => -2));
            //debug($bonreception);

            $lignebonreceptions = $this->Lignereception->find('all', array('fields' => array('AVG(Lignereception.depot_id) depot_id', 'AVG(Article.marge) marge', 'AVG(Lignereception.article_id) article_id', '(Lignereception.article_id) article_iddd'
                    , 'SUM(Lignereception.quantite) quantite', 'SUM(Lignereception.remise*Lignereception.quantite) remise', 'SUM(Lignereception.prix*Lignereception.quantite) prix'
                    , 'AVG(Lignereception.tva) tva', 'AVG(Lignereception.fodec) fodec', 'SUM(Lignereception.totalht) totalht', 'SUM(Lignereception.totalttc)totalttc', 'SUM(Lignereception.prixhtva*Lignereception.quantite )prixhtva ')
                , 'conditions' => array('Lignereception.bonreception_id in' . $tbr), 'recursive' => -2
                , 'order' => array('Lignereception.id' => 'asc')
                , 'group' => array('Lignereception.article_id')));
            //debug($lignebonreceptions);     
        } else {
            $bonreception = $this->Commande->find('first', array('fields' => array('Commande.compte_id', 'SUM(Commande.remise) remise', 'SUM(Commande.fret) fret', 'SUM(Commande.avoir) avoir', 'SUM(Commande.fodec ) fodec ', 'SUM(Commande.tva) tva', 'SUM(Commande.totalht) totalht'
                    , 'SUM(Commande.totalttc) totalttc', 'AVG(Commande.fournisseur_id) fournisseur_id', 'AVG(Commande.importation_id) importation_id', 'AVG(Commande.coefficient) coefficient', 'AVG(Commande.depot_id) depot_id'), 'conditions' => array('Commande.id' => $idbrs), 'recursive' => -2));
            //debug($bonreception);

            $lignebonreceptions = $this->Lignecommande->find('all', array('fields' => array('AVG(Article.marge) marge', 'AVG(Lignecommande.article_id) article_id', '(Lignecommande.article_id) article_iddd'
                    , 'SUM(Lignecommande.quantite) quantite', 'SUM(Lignecommande.remise*Lignecommande.quantite) remise', 'SUM(Lignecommande.prix*Lignecommande.quantite) prix'
                    , 'AVG(Lignecommande.tva) tva', 'AVG(Lignecommande.fodec) fodec', 'SUM(Lignecommande.totalht) totalht', 'SUM(Lignecommande.totalttc)totalttc', 'SUM(Lignecommande.prixhtva*Lignecommande.quantite)prixhtva ')
                , 'conditions' => array('Lignecommande.commande_id in' . $tbr), 'recursive' => -2
                , 'order' => array('Lignecommande.id' => 'asc')
                , 'group' => array('Lignecommande.article_id')));
            //debug($lignebonreceptions); 
        }
        if ($this->request->is('post')) {
            //  debug($this->request->data);die;
            $this->request->data[$model]['commande_id'] = $tbr;
            $this->request->data[$model]['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            $this->request->data[$model]['datefacture'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['datefacture'])));
            $this->request->data[$model]['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data[$model]['pointdevente_id'])) {
                $this->request->data[$model]['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data[$model]['exercice_id'] = date("Y");
            if ($this->request->data[$model]['devise_id'] != 1) {
                $tc = $this->request->data[$model]['tr'];
                $coe = $this->request->data[$model]['coe'];
            } else {
                $tc = 1;
                $coe = 1;
            }
            if ($b == 1) {
                //$depotid=$this->request->data[$model]['depot_id'];
                $this->request->data[$model]['type'] = 'indirect';
                foreach ($idbrs as $c) {
                    $this->Commande->updateAll(array('Commande.validite_id' => 3), array('Commande.id' => $c));
                }
            } else {
                $this->request->data[$model]['type'] = 'indirect';
                foreach ($idbrs as $c) {
                    $this->Bonreception->updateAll(array('Bonreception.etat' => 1), array('Bonreception.id' => $c));
                }
            }

            //debug($this->request->data);die;
            $this->Facture->create();
            if ($this->Facture->save($this->request->data)) {
                $id = $this->Facture->id;

                $this->misejour("Facture", "add", $id);
                // inserer le facture_id dans les  bons de receptions ou les commandes cochés********************
                $idbrs = explode(",", $tab);
                //   debug($idbrs);die;
                foreach ($idbrs as $br) {
                    $this->Bonreception->updateAll(array('Bonreception.facture_id' => $id), array('Bonreception.id' => $br));
                    $this->Commande->updateAll(array('Commande.facture_id' => $id), array('Commande.id' => $br));
                }

                $Lignefactures = array();
                $totale_facture_devise = 0;
                foreach ($this->request->data['Lignedeviprospect'] as $f) {

                    if ($f['sup'] != 1) {


                        $Lignefactures['prixachatans'] = $f['prixachatans'];
                        $Lignefactures['margeans'] = $f['margeans'];
                        $Lignefactures['facture_id'] = $id;
                        $Lignefactures['depot_id'] = $f['depot_id'];
                        $depotid = $f['depot_id'];
                        $Lignefactures['article_id'] = $f['article_id'];
                        $Lignefactures['quantite'] = $f['quantite'];
                        if (!empty($f['prix'])) {
                            $Lignefactures['prix'] = $f['prix'];
                            $Lignefactures['prix_anc'] = $f['prix_anc'];
                        }
                        $Lignefactures['prixhtva'] = $f['prixhtva'];
                        $Lignefactures['remise'] = @$f['remise'];
                        $Lignefactures['fodec'] = @$f['fodec'];
                        $Lignefactures['tva'] = $f['tva'];

                        $Lignefactures['prixhtva'] = $f['prixhtva'];
                        if (!empty($f['prix'])) {
                            $Lignefactures['totalht'] = $f['totalht'];
                            $Lignefactures['totalttc'] = $f['totalttc'];
                        } else {
                            $Lignefactures['totalht'] = ($f['prixhtva'] * (1 - @$f['remise'] * 0.01)) * $f['quantite'];
                            $Lignefactures['totalttc'] = ((($Lignefactures['totalht']) * (1 + (@$f['fodec'] * 0.01))) * (1 + ($f['tva'] * 0.01)));
                        }
                        $this->Lignefacture->create();
                        $this->Lignefacture->save($Lignefactures);

                        if ($this->request->data[$model]['devise_id'] != 1) {
                            $this->Article->updateAll(array('Article.coutrevient' => sprintf('%.3f', $Lignefactures['totalht'] / $f['quantite']), 'Article.tauxchange' => $tc, 'Article.coefficient' => $coe, 'Article.prixachatdevise' => $f['prix']), array('Article.id' => $f['article_id']));
                        } else {
                            $this->Article->updateAll(array('Article.coutrevient' => $f['prixhtva'], 'Article.tauxchange' => $tc, 'Article.coefficient' => $coe, 'Article.prixachatdevise' => $f['prixhtva']), array('Article.id' => $f['article_id']));
                        }
                        if (!empty($f['prix'])) {
                            $importations = $this->Importation->find('first', array('conditions' => array('Importation.id' => $this->request->data[$model]['importation_id']), false));
                            $totale_facture_devise = $importations['Importation']['montantachat'];
                            $this->Facture->updateAll(array('Facture.totaldevise' => $totale_facture_devise), array('Facture.id' => $id));
                        }
                        if ((!empty($f['margeA'])) || (!empty($f['pvA']))) {
                            $trace = array();
                            $aticle = $this->Article->find('first', array('conditions' => array('Article.id' => $f['article_id'])));
                            $marge_ans = $aticle['Article']['marge'];
                            $prixvente_ans = $aticle['Article']['prixvente'];
                            $this->Article->updateAll(array('Article.prixvente' => $f['pvA'], 'Article.marge' => $f['margeA']), array('Article.id' => $f['article_id']));
                            $trace['utilisateur_id'] = CakeSession::read('users');
                            $trace['date'] = date("Y-m-d");
                            $trace['heure'] = date("H:i", time());
                            $trace['article_id'] = $f['article_id'];
                            $trace['prixventeans'] = $prixvente_ans;
                            $trace['margeans'] = $marge_ans;
                            $trace['prixventenv'] = $f['pvA'];
                            $trace['margenv'] = $f['margeA'];
                            $this->Tracemodificationprixdevente->create();
                            $this->Tracemodificationprixdevente->save($trace);
                        }

                        if ($b == 1) {

                            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $Lignefactures['article_id'], 'Stockdepot.depot_id' => $depotid), false));
                            if (!empty($stckdepot)) {
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $f['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                                //$this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                            } else {
                                $f['depot_id'] = $depotid;

                                $this->Stockdepot->create();
                                $this->Stockdepot->save($f);
                            }

                            // $this->stock($depotid, $f['article_id']);
                        }
                    }
                }

                $this->Session->setFlash(__('The facture has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
            }
        }
        $p = CakeSession::read('pointdevente');
        $societe = CakeSession::read('societe');
        if ($societe != 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societe, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        }
        $importation = $this->Importation->find('first', array('recursive' => -1, 'conditions' => array('Importation.id' => $bonreception[0]['importation_id'])));
        if ($bonreception[0]['importation_id'] != 0) {
            $impo = $importation['Importation']['name'];
            $tr = $importation['Importation']['tauxderechenge'];
            $coe = $importation['Importation']['coefficien'];
            $tot_coe = $tr * $coe;
        }
        $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $bonreception[0]['fournisseur_id']), false));
        $devise = $fournisseur['Fournisseur']['devise_id'];
        $name = $fournisseur['Fournisseur']['name'];
        $fournisseurs = $this->Fournisseur->find('list');
        //zeinab
        /* $art = $this->Facture->query('
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
          WHERE articlefournisseurs.fournisseur_id =' . $bonreception[0]['fournisseur_id'] . '
          AND articles.id = articlefournisseurs.article_id');
          $articles = array();
          foreach ($art as $v) {
          if ($v[0]['codeart'] == $v[0]['refart']) {
          $v[0]['refart'] = "";
          }
          $articles[$v[0]['id']] = $v[0]['refart'] . " " . $v[0]['codeart'] . " " . $v[0]['desart'];
          } */


        $importations = $this->Importation->find('list', array('conditions' => array('Importation.fournisseur_id' => $bonreception[0]['fournisseur_id'], 'Importation.etat' => 0), false));
        //debug($devise);
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
        //zeinab
        //$articles = $this->Article->find('list');
        $comptes = $this->Compte->find('list', array('fields' => array('Compte.banque')));
        $timbre = $this->Facture->Timbre->find('first', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('pointdeventes', 'p', 'timbre', 'b', 'comptes', 'mm', 'impo', 'name', 'devise', 'importations', 'tot_coe', 'coe', 'tr', 'lignebonreceptions', 'bonreception', 'fournisseurs', 'lignefactures', 'articles', 'fournisseurid', 'depots'));
    }

    public function addbonentre($id = null) {
        $lien = CakeSession::read('lien_achat');
        $x = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonentres') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($ligne_model);
        $this->loadModel('Stockdepot');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Bonreception');
        $this->loadModel('Bonentre');
        $this->loadModel('Ligneentre');
        if (!$this->Facture->exists($id)) {
            throw new NotFoundException(__('Invalid facture'));
        }
        if ($this->request->is('post')) {
            //debug($this->request->data );die;
            $this->request->data['Bonentre']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonentre']['date'])));
            $this->request->data['Bonentre']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Bonentre']['facture_id'] = $id;
            $this->Bonentre->create();
            if (!empty($this->request->data['Lignereception'])) {
                if ($this->Bonentre->save($this->request->data)) {
                    $idbe = $this->Bonentre->id;
                    foreach ($this->request->data['Lignereception'] as $i => $f) {

                        if ($f['sup'] != 1) {
                            $Ligneentres['bonentre_id'] = $idbe;
                            $Ligneentres['lignefacture_id'] = $f['id'];
                            $Ligneentres['article_id'] = $Lignefactures['article_id'];
                            if ($f['datevalidite'] != '__/__/____') {
                                $Ligneentres['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $f['datevalidite'])));
                                $cond = 'Stockdepot.date = ' . "'" . $Ligneentres['date'] . "'";
                            }
                            $Ligneentres['depot_id'] = $f['Detail'][0]['depot_id'];
                            $Ligneentres['quantite'] = $f['Detail'][0]['qte'];
                            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $Ligneentres['article_id'], 'Stockdepot.depot_id' => $Ligneentres['depot_id'], @$cond), false));
                            if (!empty($stckdepot)) {
                                $qtett = $Ligneentres['quantite'] + $stckdepot[0]['Stockdepot']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qtett), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                                $sdid = $stckdepot[0]['Stockdepot']['id'];
                            } else {
                                $this->Stockdepot->create();
                                $this->Stockdepot->save($Ligneentres);
                                $sdid = $this->Stockdepot->id;
                            }
                            $Ligneentres['stockdepot_id'] = $sdid;
                            $this->Ligneentre->create();
                            $this->Ligneentre->save($Ligneentres);

                            if ($f['quantite'] > $f['Detail'][0]['qte']) {
                                foreach ($this->request->data['Detail' . $i] as $di) {
                                    if ($di['sup'] != 1) {
                                        $Ligneentres['bonentre_id'] = $idbe;
                                        $Ligneentres['lignefacture_id'] = $f['id'];
                                        $Ligneentres['article_id'] = $Lignefactures['article_id'];
                                        if ($f['datevalidite'] != '__/__/____') {
                                            $Ligneentres['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $f['datevalidite'])));
                                            $cond = 'Stockdepot.date = ' . "'" . $Ligneentres['date'] . "'";
                                        }
                                        $Ligneentres['depot_id'] = $di['depot_id'];
                                        $Ligneentres['quantite'] = $di['qte'];

                                        $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $Ligneentres['article_id'], 'Stockdepot.depot_id' => $Ligneentres['depot_id'], @$cond), false));
                                        if (!empty($stckdepot)) {
                                            $qtett = $Ligneentres['quantite'] + $stckdepot[0]['Stockdepot']['quantite'];
                                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qtett), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                                            $sdid = $stckdepot[0]['Stockdepot']['id'];
                                        } else {
                                            $this->Stockdepot->create();
                                            $this->Stockdepot->save($Ligneentres);
                                            $sdid = $this->Stockdepot->id;
                                        }
                                        $Ligneentres['stockdepot_id'] = $sdid;
                                        $this->Ligneentre->create();
                                        $this->Ligneentre->save($Ligneentres);
                                    }
                                }
                            }
                        }
                    }

                    $this->Facture->updateAll(array('Facture.etat' => 1), array('Facture.id' => $id));

                    $this->Session->setFlash(__('The bonentre has been saved'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('le bon d entre dois avoir aux moins une ligne de entre.'));
                }
            }
        }
        $lignereceptions = $this->Lignefacture->find('all', array('conditions' => array('Lignefacture.facture_id' => $id)));


        $numero = $this->Bonentre->find('all', array('fields' =>
            array(
                'MAX(Bonentre.numero) as num'
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
        $fournisseurs = $this->Facture->Fournisseur->find('list');
        $utilisateurs = $this->Facture->Utilisateur->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $this->set(compact('fournisseurs', 'utilisateurs', 'depots', 'lignereceptions', 'articles', 'mm'));
    }

    public function edit($id = null, $model = null, $ligne_model = null, $attribut = null) {
//        debug($id);
//        debug($model);
//        debug($ligne_model);
//        debug($attribut);
        // die;
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($model);
        $this->loadModel($ligne_model);
        $this->loadModel('Pointdevente');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepot');
        $this->loadModel('Article');
        $this->loadModel('Reglement');
        $this->loadModel('Stockdepotfacture');
        $this->loadModel('Depot');
        $this->loadModel('Timbre');
        $this->loadModel('Fournisseur');
        $this->loadModel('Utilisateur');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Lignefacture');
        $this->loadModel('Facture');
        $this->loadModel('Lignereception');
        $this->loadModel('Bonreception');
        if ($this->request->is('post') || $this->request->is('put')) {
           // debug($this->request->data);die;
            $this->request->data[$model]['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            $this->request->data[$model]['datedeclaration'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['datedeclaration'])));
            $this->request->data[$model]['utilisateur_id'] = CakeSession::read('users');
            //$this->request->data[$model]['type']= 'direct';
            $fournisseur_id = $this->request->data[$model]['fournisseur_id'];
            if (empty($this->request->data[$model]['timbre_id'])) {
                $this->request->data[$model]['timbre_id'] = 0;
            }
			if(floatval($this->request->data[$model]['totalhtanc'])!=0 && floatval($this->request->data[$model]['tvaanc'])!=0 && floatval($this->request->data[$model]['totalttcanc'])!=0){
               
                $ht_anc=$this->request->data[$model]['totalht'];
                $tva_anc=$this->request->data[$model]['tva'];
                $ttc_anc=$this->request->data[$model]['totalttc'];

                //if(floatval($this->request->data[$model]['totalhtanc'])!=floatval($ht_anc) || floatval($this->request->data[$model]['tvaanc'])!=floatval($tva_anc) || floatval($this->request->data[$model]['totalttcanc'])!=floatval($ttc_anc)){

                $this->request->data[$model]['totalht']=$this->request->data[$model]['totalhtanc'];
                $this->request->data[$model]['tva']=$this->request->data[$model]['tvaanc'];
                $this->request->data[$model]['totalttc']=$this->request->data[$model]['totalttcanc'];

                $this->request->data[$model]['totalhtanc']=$ht_anc;
                $this->request->data[$model]['tvaanc']=$tva_anc;
                $this->request->data[$model]['totalttcanc']=$ttc_anc;                
            //}
        }
            //debug($this->request->data);die;        
            if ($this->$model->save($this->request->data)) {
                $this->misejour($model, "edit", $id);


                $tabarticle = array();
                $nouvarticle = array();
                $nouveau = 0;
                $tablignereception = array();
                $contlignereception = 0;
                $lot = array();
                /*                 * ******** PMP ************ */
                $lignereceptionanciens = $this->$ligne_model->find('all', array('conditions' => array($ligne_model . '.' . $attribut => $id), false));
                $bonreception = $this->$model->find('first', array('conditions' => array($model . '.id' => $id), false));
                //****Ancien cout de revient des articles
                $Lignereceptions = $this->$ligne_model->find('all', array('conditions' => array($ligne_model . '.' . $attribut => $id), false));
                if (($model == "Facture") || ($model == "Bonreception")) {
                    if (!empty($Lignereceptions)) {
                        foreach ($Lignereceptions as $f) {
                            $dernierachat = $this->$model->query(
                                    'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
        FROM (
        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
        FROM  factures,lignefactures
         where  factures.id=lignefactures.facture_id 
        and   lignefactures.article_id=' . $f[$ligne_model]['article_id'] . ' 
        and factures.time>' . '"' . $bonreception[$model]['time'] . '"' . '
        order BY  factures.time
        )
        UNION (
        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
        FROM  bonreceptions,lignereceptions
        where  bonreceptions.id=lignereceptions.bonreception_id and
        bonreceptions.facture_id=0 and
        lignereceptions.article_id=' . $f[$ligne_model]['article_id'] . ' 
       and bonreceptions.time>' . '"' . $bonreception[$model]['time'] . '"' . '
        order BY  bonreceptions.time
        )
        )tmp
        order BY tmp.time desc
        limit 1');


                            $tmps = $this->$model->query(
                                    'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
        FROM (
        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
        FROM  factures,lignefactures
         where  factures.id=lignefactures.facture_id 
        and   lignefactures.article_id=' . $f[$ligne_model]['article_id'] . ' 
        and factures.time<' . '"' . $bonreception[$model]['time'] . '"' . '
        order BY  factures.time
        )
        UNION (
        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
        FROM  bonreceptions,lignereceptions
        where  bonreceptions.id=lignereceptions.bonreception_id and
        bonreceptions.facture_id=0 and
        lignereceptions.article_id=' . $f[$ligne_model]['article_id'] . ' 
        and bonreceptions.time<' . '"' . $bonreception[$model]['time'] . '"' . '
        order BY  bonreceptions.time
        )
        )tmp
        order BY tmp.time desc
        limit 1');
                            if (empty($dernierachat)) {
                                if (!empty($tmps)) {
                                    $prixachat = $tmps[0]['tmp']['totalht'] / $tmps[0]['tmp']['quantite'];
                                } else {
                                    $rechfirstpmp = $this->Facture->query('SELECT articlepmps.coutrevient from articlepmps where article_id=' . $f[$ligne_model]['article_id']);
//                                    debug($rechfirstpmp);die;
                                    $prixachat = $rechfirstpmp[0]['articlepmps']['coutrevient'];
                                }
                                //$this->Article->updateAll(array('Article.coutrevient' => $prixachat), array('Article.id' => $f[$ligne_model]['article_id']));
                            }
                            $aticle = $this->Article->find('first', array('conditions' => array('Article.id' => $f[$ligne_model]['article_id'])));
                            if($aticle['Article']['pmp']!=0){
                            $n_marge = (($aticle['Article']['prixvente'] - $aticle['Article']['pmp']) / $aticle['Article']['pmp']) * 100;
                            }else{
                            $n_marge =100;    
                            }
                            //$this->Article->updateAll(array('Article.marge' => sprintf('%.3f', $n_marge)), array('Article.id' => $f[$ligne_model]['article_id']));
                        }
                    }
                }
                /*                 * ********Fin PMP ************ */


                /*                 * ******** PMP ************ */
                if (($model == "Facture") || ($model == "Bonreception")) {
                    foreach ($lignereceptionanciens as $indlra => $lra) {
//                        debug($lra);
                        $tabarticle[$indlra] = $lra[$ligne_model]['article_id'];
                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite-' . $lra[$ligne_model]['quantite']), array('Stockdepot.article_id' => $lra[$ligne_model]['article_id'], 'Stockdepot.depot_id' => $lra[$ligne_model]['depot_id']));
                        foreach ($this->request->data['Lignereception'] as $hah => $fligne) {
//                            debug($fligne);
                            if (!empty($fligne['id'])) {
                                //Si la ligne reste la même et on change l article
                                if ($fligne['id'] == $lra[$ligne_model]['id']) {

                                    if (($fligne['article_id'] != $lra[$ligne_model]['article_id'])) {
//                                $tablignereception[$contlignereception] = $lra[$ligne_model]['id'];
//                                $contlignereception++;
                                        $tmps = $this->$model->query(
                                                'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
                        FROM (
                        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $lra[$ligne_model]['article_id'] . '
                        and factures.time>=' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $lra[$ligne_model]['article_id'] . '
                        and bonreceptions.time>=' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                        )tmp
                        order BY tmp.time');
                                        if ($tmps != null) {

                                            if (($tmps[count($tmps) - 1]['tmp']['id'] == $lra[$ligne_model]['id']) && ($tmps[count($tmps) - 1]['tmp']['type'] == 0)) {
                                                //derniére ligne achat
                                                $nouveauprix = $lra[$ligne_model]['coutstkancien'];
                                                $this->Article->updateAll(array('Article.pmp' => $nouveauprix), array('Article.id' => $lra[$ligne_model]['article_id']));
                                            } else {
                                                //ligne achat intérmédiaire

                                                $afterachats = $this->$model->query(
                                                        'SELECT tmpafter.time,tmpafter.qtestkancien,tmpafter.coutstkancien,tmpafter.id,tmpafter.type
                        FROM (
                        (SELECT  factures.time,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $lra[$ligne_model]['article_id'] . '
                        and factures.time>' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $lra[$ligne_model]['article_id'] . ' 
                        and bonreceptions.time>' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                        )tmpafter
                        order BY tmpafter.time');
                                                $afterprix = $lra[$ligne_model]['coutstkancien'];
                                                $afterqte = $lra[$ligne_model]['qtestkancien'];
                                                foreach ($afterachats as $key => $afterachat) {
                                                    //$afterprixstk = $lra[$ligne_model]['coutstkancien'];
                                                    //$afterqtestk = $lra[$ligne_model]['qtestkancien'];
                                                    if ($afterachat['tmpafter']['type'] == 0) {
                                                        $this->Lignereception->updateAll(array('Lignereception.qtestkancien' => $afterqte, 'Lignereception.coutstkancien' => $afterprix), array('Lignereception.id' => $afterachat['tmpafter']['id']));
                                                    }
                                                    if ($afterachat['tmpafter']['type'] == 1) {
                                                        $this->Lignefacture->updateAll(array('LigneFacture.qtestkancien' => $afterqte, 'LigneFacture.coutstkancien' => $afterprix), array('LigneFacture.id' => $afterachat['tmpafter']['id']));
                                                    }


                                                    $dernierachatid = $afterachat['tmpafter']['id'];
                                                    $dernierachattyp = $afterachat['tmpafter']['type'];

                                                    //mettre à jour le nouveau coût de stock
                                                    if ($dernierachattyp == 0) {
                                                        $lignecr = $this->$ligne_model->find('first', array('recursive' => 1, 'conditions' => array($ligne_model . '.id' => $dernierachatid)));
                                                        $qteligne = $lignecr[$ligne_model]['quantite'];
                                                        $htligne = $lignecr[$ligne_model]['totalht'];
                                                        $afterprix = $lignecr[$ligne_model]['coutstkancien'];
                                                        $afterqte = $lignecr[$ligne_model]['qtestkancien'];
                                                    }
                                                    if ($dernierachattyp == 1) {
                                                        $lignecr = $this->Lignefacture->find('first', array('recursive' => 1, 'conditions' => array('Lignefacture.id' => $dernierachatid)));
                                                        $qteligne = $lignecr['Lignefacture']['quantite'];
                                                        $htligne = $lignecr['Lignefacture']['totalht'];
                                                        $afterprix = $lignecr['Lignefacture']['coutstkancien'];
                                                        $afterqte = $lignecr['Lignefacture']['qtestkancien'];
                                                    }
                                                    if ($afterqte <= 0) {
                                                        $afterprix = $htligne / $qteligne;
                                                    } else {
                                                        $afterprix = ($afterprix * $afterqte + $htligne) / ($qteligne + $afterqte);
                                                    }
                                                    $afterqte = $afterqte + $qteligne;
                                                }

                                                $this->Article->updateAll(array('Article.pmp' => $afterprix), array('Article.id' => $lra[$ligne_model]['article_id']));
                                            }
                                        }
                                        //Test 3al article jdid fama achat 9ablou ou non
                                        $testarticlejdid = $this->$model->query(
                                                'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
                        FROM (
                        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $fligne['article_id'] . ' 
                        and factures.time<' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $fligne['article_id'] . ' 
                        and bonreceptions.time<' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                        )tmp
                        order BY tmp.time desc
                        limit 1');
                                        if ($testarticlejdid != null) {
                                            //S'il y a au moins un achat precédent
                                            $acoutstkancien = $testarticlejdid[0]['tmp']['coutstkancien'];
                                            $aqtestkancien = $testarticlejdid[0]['tmp']['qtestkancien'];
                                            $qteac = $testarticlejdid[0]['tmp']['quantite'];
                                            $coutac = $testarticlejdid[0]['tmp']['totalht'];
                                            if ($aqtestkancien <= 0) {
                                                $pmpfinal = $testarticlejdid[0]['tmp']['totalht'] / $testarticlejdid[0]['tmp']['quantite'];
                                            } else {
                                                $pmpfinal = ($acoutstkancien * $aqtestkancien + $testarticlejdid[0]['tmp']['totalht']) / ($testarticlejdid[0]['tmp']['quantite'] + $aqtestkancien);
                                            }

                                            $this->$ligne_model->updateAll(array($ligne_model . '.qtestkancien' => $aqtestkancien + $qteac, $ligne_model . '.coutstkancien' => $pmpfinal), array($ligne_model . '.id' => $lra[$ligne_model]['id']));
                                        } else {
                                            $rechfirstpmp = $this->$model->query('SELECT articlepmps.qte, articlepmps.pmp from articlepmps where article_id=' . $fligne['article_id']);
                                            $firstcout = $rechfirstpmp[0]['articlepmps']['pmp'];
                                            $firstqte = $rechfirstpmp[0]['articlepmps']['qte'];
                                            $this->$ligne_model->updateAll(array($ligne_model . '.qtestkancien' => $firstqte, $ligne_model . '.coutstkancien' => $firstcout), array($ligne_model . '.id' => $lra[$ligne_model]['id']));
                                        }
                                        $tablignereception[$contlignereception] = $lra[$ligne_model]['id'];
                                        $contlignereception++;
                                    }
                                    //meme article 
                                    if (($fligne['article_id'] == $lra[$ligne_model]['article_id']) && ($fligne['quantite'] != $lra[$ligne_model]['quantite'] || $fligne['remise'] != $lra[$ligne_model]['remise'] || $fligne['prixhtva'] != $lra[$ligne_model]['prixhtva'])) {
                                        $tablignereception[$contlignereception] = $lra[$ligne_model]['id'];
                                        $contlignereception++;
                                    }
                                }
                            }
                        }
                    }
                }
                /*                 * ******** PMP ************ */




                $depotid = $this->request->data[$model]['depot_id'];
                $Lignefactureclients = array();
                $stockdepots = array();
                foreach ($this->request->data['Lignereception'] as $numl => $f) {
//                      debug($f);die;
                    if ($f['sup'] != 1) {
                        if ($f['article_id'] != "") {
                            $f['depot_id'] = $this->request->data[$model]['depot_id'];
                            if ($f['qtebonus'] == '') {
                                $f['qtebonus'] = 0;
                            }

                            $Lignefactureclients['qtebonus'] = $f['qtebonus'];
                            $stockdepots[$numl]['quantite'] = $f['quantite'] + $f['qtebonus'];
                            $stockdepots[$numl]['article_id'] = $f['article_id'];
                            $stockdepots[$numl]['depot_id'] = $this->request->data[$model]['depot_id'];
                            $Lignefactureclients[$attribut] = $id;
                            $Lignefactureclients['article_id'] = $f['article_id'];
                            $Lignefactureclients['id'] = @$f['id'];
                            $Lignefactureclients['depot_id'] = $f['depot_id'];
                            $Lignefactureclients['quantite'] = $f['quantite'] + $f['qtebonus'];
                            $Lignefactureclients['remise'] = $f['remise'];
                            $Lignefactureclients['tva'] = $f['tva'];
                            $Lignefactureclients['prixhtva'] = $f['prixhtva'];
                            $Lignefactureclients['prix'] = $f['prixhtva'];
                            $Lignefactureclients['designation'] = $f['designation'];
                            $Lignefactureclients['marge'] = @$f['marge'];
                            $Lignefactureclients['prixdeventeht'] = @$f['prixdeventeht'];
                            //juste lel pmp 
                            $Lignereceptions['totalht'] = $f['totalht'];
                            //*******
                            $Lignefactureclients['totalht'] = $f['totalht'];
                            $Lignefactureclients['totalttc'] = $f['totalttc'];
                            $Lignefactureclients['fodec'] = @$f['fodec'];
                              //****************** zeinab ***********//
                            if(isset($f['checkbox'])){
                                $Lignefactureclients['check']=1; 
                            }else{
                                $Lignefactureclients['check']=0; 
                            }
                            //$this->$ligne_model->create();
                            $this->$ligne_model->save($Lignefactureclients);
                            $id_ligne = $this->$ligne_model->id;
                            /*                             * ******** PMP ************ */
                            if (($model == "Facture") || ($model == "Bonreception")) {
                                // mise a jour article
                                $articlepmp = $this->Article->find('first', array(
                                        'recursive' => -1,
                                        'conditions' => array('Article.id' => $f['article_id'])));
                                $tcc_article=$f['prixdeventeht']*(1+($articlepmp['Article']['tva']/100));
                                if(isset($f['checkbox'])){
                                $this->Article->updateAll(array('Article.marge' => $f['marge'], 'Article.prixvente' => $f['prixdeventeht'],'Article.prixuttc' =>$tcc_article), array('Article.id' => $f['article_id']));
                                }
                                //mise a jour pmp
                                if ($f['id'] == '') {
                                    //Test 3al article jdid fama achat 9ablou ou non
                                    $testarticlejdid = $this->$model->query(
                                            'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
                        FROM (
                        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $f['article_id'] . ' 
                        and factures.time<' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $f['article_id'] . ' 
                        and bonreceptions.time<' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                        )tmp
                        order BY tmp.time desc
                        limit 1');
                                    if ($testarticlejdid != null) {
                                        //S'il y a au moins un achat precédent
                                        $acoutstkancien = $testarticlejdid[0]['tmp']['coutstkancien'];
                                        $aqtestkancien = $testarticlejdid[0]['tmp']['qtestkancien'];
                                        $qteac = $testarticlejdid[0]['tmp']['quantite'];
                                        $coutac = $testarticlejdid[0]['tmp']['totalht'];
                                        if ($aqtestkancien <= 0) {
                                            $pmpfinal = $testarticlejdid[0]['tmp']['totalht'] / $testarticlejdid[0]['tmp']['quantite'];
                                        } else {
                                            $pmpfinal = ($acoutstkancien * $aqtestkancien + $testarticlejdid[0]['tmp']['totalht']) / ($testarticlejdid[0]['tmp']['quantite'] + $aqtestkancien);
                                        }

                                        $this->$ligne_model->updateAll(array($ligne_model . '.qtestkancien' => $aqtestkancien + $qteac, $ligne_model . '.coutstkancien' => $pmpfinal), array($ligne_model . '.id' => $id_ligne));
                                    } else {
                                        $rechfirstpmp = $this->$model->query('SELECT articlepmps.qte, articlepmps.pmp from articlepmps where article_id=' . $f['article_id']);
                                       if(!empty($rechfirstpmp)){
									   $firstcout = $rechfirstpmp[0]['articlepmps']['pmp'];
                                        $firstqte = $rechfirstpmp[0]['articlepmps']['qte'];
									   }else{
										$firstcout =0;  
											$firstqte =0;
									   }
                                        $this->$ligne_model->updateAll(array($ligne_model . '.qtestkancien' => $firstqte, $ligne_model . '.coutstkancien' => $firstcout), array($ligne_model . '.id' => $id_ligne));
                                    }




                                    //Mise à jour des achats > achat actuelle
                                    $tmps = $this->$model->query(
                                            'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
                        FROM (
                        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $f['article_id'] . ' 
                        and factures.time>=' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $f['article_id'] . ' 
                        and bonreceptions.time>=' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                        )tmp
                        order BY tmp.time');
                                    if ($tmps != null) {
                                        //Si l'achat qu'on est entrain de modifier est la derni
                                        if (count($tmps) == 1) {
                                            $afterprixstk = $tmps[count($tmps) - 1]['tmp']['coutstkancien'];
                                            $afterqtestk = $tmps[count($tmps) - 1]['tmp']['qtestkancien'];
                                            if ($afterqtestk <= 0) {
                                                $pmpfinal = $Lignereceptions['totalht'] / $f['quantite'];
                                            } else {
                                                $pmpfinal = ($afterprixstk * $afterqtestk + $Lignereceptions['totalht']) / ($f['quantite'] + $afterqtestk);
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
                                                        $pmpanc = $lignecr['Lignereception']['coutstkancien'];
                                                        $qteanc = $lignecr['Lignereception']['qtestkancien'];
                                                        $pmp = $lignecr['Lignereception']['totalht'];
                                                        $qte = $lignecr['Lignereception']['quantite'];
                                                    }
                                                    if ($typepiece == 1) {
                                                        $this->Lignefacture->updateAll(array('Lignefacture.qtestkancien' => ($qte + $qteanc), 'Lignefacture.coutstkancien' => $pmpfinal), array('Lignefacture.id' => $tmp['tmp']['id']));
                                                        $lignecr = $this->Lignefacture->find('first', array('recursive' => 1, 'conditions' => array('Lignefacture.id' => $tmp['tmp']['id'])));
                                                        $pmpanc = $lignecr['Lignefacture']['coutstkancien'];
                                                        $qteanc = $lignecr['Lignefacture']['qtestkancien'];
                                                        $pmp = $lignecr['Lignefacture']['totalht'];
                                                        $qte = $lignecr['Lignefacture']['quantite'];
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
                                } else {
                                    //Si la ligne est la même, l'article est le meme mais la qte, prix ou remmise n ont pas la meme
                                    if (!empty($tablignereception)) {
                                        foreach ($tablignereception as $tablignerecep) {
                                            if ($tablignerecep == $f['id']) {

                                                $tmps = $this->$model->query(
                                                        'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
                        FROM (
                        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $f['article_id'] . ' 
                        and factures.time>=' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $f['article_id'] . ' 
                        and bonreceptions.time>=' . '"' . $bonreception[$model]['time'] . '"' . '
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
                                                            $pmpfinal = $Lignereceptions['totalht'] / $f['quantite'];
                                                        } else {
                                                            $pmpfinal = ($afterprixstk * $afterqtestk + $Lignereceptions['totalht']) / ($f['quantite'] + $afterqtestk);
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
                                                                    $pmp = $lignecr['Lignereception']['totalht'];
                                                                    $qte = $lignecr['Lignereception']['quantite'];
                                                                }
                                                                if ($typepiece == 1) {
                                                                    $this->Lignefacture->updateAll(array('Lignefacture.qtestkancien' => ($qte + $qteanc), 'Lignefacture.coutstkancien' => $pmpfinal), array('Lignefacture.id' => $tmp['tmp']['id']));
                                                                    $lignecr = $this->Lignefacture->find('first', array('recursive' => 1, 'conditions' => array('Lignefacture.id' => $tmp['tmp']['id'])));
//                                                            debug($lignecr);
                                                                    $pmpanc = $lignecr['Lignefacture']['coutstkancien'];
                                                                    $qteanc = $lignecr['Lignefacture']['qtestkancien'];
                                                                    $pmp = $lignecr['Lignefacture']['totalht'];
                                                                    $qte = $lignecr['Lignefacture']['quantite'];
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
                                        }
                                    }
                                }
                            }
                            /*                             * ******** Fin PMP ************ */

                            /*                             * ******** Verification des articles et mise à jour des familles ************ */
                            $artdetails = $this->Article->find('first', array('conditions' => array('Article.id' => $f['article_id']), 'recursive' => -1));
                            if ($f['famille_id'] == '' || $f['famille_id'] == null || empty($f['famille_id'])){
                                $f['famille_id'] = "0";
                            }
                            if ($f['sousfamille_id'] == '' || $f['sousfamille_id'] == null || empty($f['sousfamille_id'])){
                                $f['sousfamille_id'] = "0";
                            }
                            if ($f['soussousfamille_id'] == '' || $f['soussousfamille_id'] == null || empty($f['soussousfamille_id'])){
                                $f['soussousfamille_id'] = "0";
                            }
                            if ($f['fodec'] == '' || $f['fodec'] == null || empty($f['fodec'])){
                                $f['fodec'] = "0";
                            }
                            if ($f['remise'] == '' || $f['remise'] == null || empty($f['remise'])){
                                $f['remise'] = "0";
                            }
                            /*                             * ********Fin Verification des articles et mise à jour des familles ************ */


                            /*                             * ******** MJ Article ************ */
                            if (($model == "Facture") || ($model == "Bonreception")) {
                                $mntremise = floatval($f['prixhtva']) * (floatval($f['remise']) / 100);
                                $mntapresremise = floatval($f['prixhtva']) - floatval($mntremise);
                                if ($artdetails != array()) {
                                    //debug($artdetails);die;
                                    $margebrutgros = $artdetails['Article']['margebrutgros'];
                                    $margebrutgross = floatval($f['prixhtva']) * floatval($margebrutgros) / 100;
                                    $prixventegros = floatval($f['prixhtva']) + floatval($margebrutgross);

                                    $margenet = (floatval($prixventegros) - floatval($mntapresremise)) / floatval($mntapresremise);

                                    $margebrutdetails = $artdetails['Article']['margebrutdetail'];
                                    $margebrutdetailss = floatval($f['prixhtva']) * floatval($margebrutdetails) / 100;
                                    $prixventedetails = floatval($f['prixhtva']) + floatval($margebrutdetailss);
                                    $margenetdetails = (floatval($prixventedetails) - floatval($mntapresremise)) / floatval($mntapresremise);

                                    //****************** zeinab ***********//
                                        if(isset($f['checkbox'])){
                                            $this->Article->updateAll(array(
                                            'Article.coutrevient' => ($f['prixhtva']*(1-($f['remise']/100))),
                                            'Article.prixav_remise' => $f['prixhtva'],
                                            'Article.remise' => $f['remise'],
                                            'Article.fodec' => $f['fodec'],
                                            'Article.famille_id' => $f['famille_id'],
                                            'Article.sousfamille_id' => $f['sousfamille_id'],
                                            'Article.soussousfamille_id' => $f['soussousfamille_id'])
                                                , array('Article.id' => $f['article_id']));
                                        }else{
                                            $this->Article->updateAll(array(
                                            'Article.fodec' => $f['fodec'],
                                            'Article.famille_id' => $f['famille_id'],
                                            'Article.sousfamille_id' => $f['sousfamille_id'],
                                            'Article.soussousfamille_id' => $f['soussousfamille_id'])
                                                //'Article.prixachatnet' => $mntapresremise,
                                                //'Article.prixventegros' => $prixventegros,
                                                //'Article.margenetgros' => $margenet,
                                                //'Article.prixvente' => $prixventedetails,
                                                //'Article.margenetdetail' => $margenetdetails)
                                                , array('Article.id' => $f['article_id']));
                                        }
                                        
                                        
                                }
                            }
                            /*                             * ******** Fin MJ Article ************ */

                            /*                             * ******** MJ Article Frs ************ */
                            $artfrsdetails = $this->Articlefournisseur->find('first', array('conditions' => array('Articlefournisseur.article_id' => $f['article_id']
                                    , 'Articlefournisseur.fournisseur_id' => $fournisseur_id), 'recursive' => -1));
                            if ($artfrsdetails == array()) {
                                $artfrs = array();
                                //$art['article_id']=$article_id;
                                $artfrs['article_id'] = $f['article_id'];
                                $artfrs['fournisseur_id'] = $fournisseur_id;
                                $artfrs['prix'] = $mntapresremise;
                                $artfrs['reference'] = $f['articlefrs_id'];
                                $this->Articlefournisseur->create();
                                $this->Articlefournisseur->save($artfrs);
                            } else {
                                $this->Articlefournisseur->updateAll(array('Articlefournisseur.prix' => $f['prixhtva'], 'Articlefournisseur.reference' => "'" . $f['articlefrs_id'] . "'"
                                        ), array('Articlefournisseur.article_id' => $f['article_id']
                                    , 'Articlefournisseur.fournisseur_id' => $fournisseur_id));
                            }
                            /*                             * ********Fin MJ Article Frs ************ */

                            /*                             * ********MJ stock ************ */
                            if (($model == "Facture") || ($model == "Bonreception")) {
                                $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
                                if (!empty($stckdepot)) {
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                                } else {
                                    $this->Stockdepot->create();
                                    $this->Stockdepot->save($stockdepots[$numl]);
                                }
                            }
                            /*                             * ********Fin MJ stock ************ */
                        }
                    } else {
                        if ($f['id'] != '') {
                            /*                             * ******** PMP ************ */
                            if (($model == "Facture") || ($model == "Bonreception")) {
                                $tmps = $this->$model->query(
                                        'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
                        FROM (
                        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $f['article_id'] . ' 
                        and factures.time>=' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $f['article_id'] . ' 
                        and bonreceptions.time>=' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                        )tmp
                        order BY tmp.time');
                                if ($tmps != null) {
                                    if (($tmps[count($tmps) - 1]['tmp']['id'] == $f['id']) && ($tmps[count($tmps) - 1]['tmp']['type'] == 0)) {
                                        //nlawej achat eli just 9balh
                                        //Si l achat supprimé est la derniére achat
                                        //Dernier achat avant l'achat actuelle pour recherche qte et cout ancien
                                        $tmps = $this->$model->query(
                                                'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
                        FROM (
                        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $f['article_id'] . ' 
                        and factures.time<' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $f['article_id'] . ' 
                        and bonreceptions.time<' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                        )tmp
                        order BY tmp.time desc
                        limit 1');
                                        if (!empty($tmps)) {
                                            //S'il y a au moins un achat precédent
                                            $afterprixstk = $tmps[0]['tmp']['coutstkancien'];
                                            $afterqtestk = $tmps[0]['tmp']['qtestkancien'];
                                            $qteac = $tmps[0]['tmp']['quantite'];
                                            $coutac = $tmps[0]['tmp']['totalht'];
                                            if ($afterqtestk <= 0) {
                                                $pmpfinal = $tmps[0]['tmp']['totalht'] / $tmps[0]['tmp']['quantite'];
                                            } else {
                                                $pmpfinal = ($afterprixstk * $afterqtestk + $tmps[0]['tmp']['totalht']) / ($tmps[0]['tmp']['quantite'] + $afterqtestk);
                                            }
                                            $this->Article->updateAll(array('Article.pmp' => $pmpfinal), array('Article.id' => $f['article_id']));
                                        }
                                    } else {
                                        //ligne achat intérmédiaire
                                        //$this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite-' . $f['quantite']), array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $cedevi['Bonreception']['depot_id']));
                                        $afterachats = $this->$model->query(
                                                'SELECT tmpafter.time,tmpafter.qtestkancien,tmpafter.coutstkancien,tmpafter.id,tmpafter.type
                        FROM (
                        (SELECT  factures.time,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $f['article_id'] . ' 
                        and factures.time>' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $f['article_id'] . '
                        and bonreceptions.time>' . '"' . $bonreception[$model]['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                        )tmpafter
                        order BY tmpafter.time');
                                        $lignecr = $this->$ligne_model->find('first', array('recursive' => 1, 'conditions' => array($ligne_model . '.id' => $f['id'])));
                                        $afterprix = $lignecr[$ligne_model]['coutstkancien'];
                                        $afterqte = $lignecr[$ligne_model]['qtestkancien'];
                                        $qteligne = 0;
                                        foreach ($afterachats as $key => $afterachat) {

                                            if ($afterachat['tmpafter']['type'] == 0) {
                                                $this->Lignereception->updateAll(array('Lignereception.qtestkancien' => $afterqte + $qteligne, 'Lignereception.coutstkancien' => $afterprix), array('Lignereception.id' => $afterachat['tmpafter']['id']));
                                            }
                                            if ($afterachat['tmpafter']['type'] == 1) {
                                                $this->Lignefacture->updateAll(array('Lignefacture.qtestkancien' => $afterqte + $qteligne, 'Lignefacture.coutstkancien' => $afterprix), array('Lignefacture.id' => $afterachat['tmpafter']['id']));
                                            }
//                                        $afterprix = $afterachat['tmpafter']['coutstkancien'];
//                                        $afterqte = $afterachat['tmpafter']['qtestkancien'];
                                            $dernierachatid = $afterachat['tmpafter']['id'];
                                            $dernierachattyp = $afterachat['tmpafter']['type'];
                                            if ($dernierachattyp == 0) {
                                                $lignecr = $this->Lignereception->find('first', array('recursive' => 1, 'conditions' => array('Lignereception.id' => $dernierachatid)));
                                                $afterprix = $lignecr['Lignereception']['coutstkancien'];
                                                $afterqte = $lignecr['Lignereception']['qtestkancien'];
                                                $qteligne = $lignecr['Lignereception']['quantite'];
                                                $htligne = $lignecr['Lignereception']['totalht'];
                                            }
                                            if ($dernierachattyp == 1) {
                                                $lignecr = $this->Lignefacture->find('first', array('recursive' => 1, 'conditions' => array('Lignefacture.id' => $dernierachatid)));
                                                $afterprix = $lignecr['Lignefacture']['coutstkancien'];
                                                $afterqte = $lignecr['Lignefacture']['qtestkancien'];
                                                $qteligne = $lignecr['Lignefacture']['quantite'];
                                                $htligne = $lignecr['Lignefacture']['totalht'];
                                            }
                                            if (($afterqte + $qteligne) <= 0) {
                                                $afterprix = $htligne / $qteligne;
                                            } else {
                                                $afterprix = ($afterprix * $afterqte + $htligne) / ($qteligne + $afterqte);
                                            }
                                        }

                                        $this->Article->updateAll(array('Article.pmp' => $afterprix), array('Article.id' => $f['article_id']));
                                    }
                                }
                            }
                            /*                             * ********Fin PMP ************ */
                            /*                             * ******** delete ligne sup ************ */
                            $this->$ligne_model->deleteAll(array($ligne_model . '.id' => $f['id']), false);
                            /*                             * ********Fin delete ligne sup ************ */
                        }
                    }
                }
                $this->Session->setFlash(__('The ' . $model . ' has been saved'));
                //$this->redirect(array('action' => 'index'));
                $this->redirect(array('controller' => $model . 's', 'action' => 'index/' . $id));
            } else {
                $this->Session->setFlash(__('The factureclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array($model . '.' . $this->$model->primaryKey => $id));
            $this->request->data = $this->$model->find('first', $options);
            //$ligneoptions = array('conditions' => array('Lignefactureclient.facture_id' => $id),'recursive'=>-1, 'order' => array('Lignefactureclient.id' => 'ASC'));
            //$this->request->ligne = $this->Lignefactureclient->find('first', $ligneoptions);
            //debug($this->request->ligne);
        }
        $lignefactureclients = $this->$ligne_model->find('all', array('conditions' => array($ligne_model . '.' . $attribut => $id), 'order' => array($ligne_model . '.id' => 'ASC')));

        $clients = $this->Fournisseur->find('list');
        $utilisateurs = $this->Utilisateur->find('list');
        $timbre = $this->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data[$model]['date'])));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        //$articles = $this->Article->find('list');
        //info client**************************************************
        $this->loadModel('Bonreception');
        $this->loadModel($model);
        $this->loadModel('Fournisseur');
        $facture = $this->$model->find('first', array('conditions' => array($model . '.id' => $id), false));
        $clientid = $facture[$model]['fournisseur_id'];
        //$name = $facture[$model]['name'];
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1, 'Fournisseur.societe' => $composantsoc)));

//        $adresse = $fournisseurs[0]['Fournisseur']['adresse'];
//        $matriculefiscale = $fournisseurs[0]['Fournisseur']['matriculefiscale'];
//        $autorisation = '';
//        $typeclient_id = $fournisseurs[0]['Fournisseur']['famillefournisseur_id'];

        $sumttc = $this->Bonreception->find('all', array('fields' => array('sum(Bonreception.totalttc) as totalttcb')
            , 'conditions' => array('Bonreception.id > ' => 0, 'Bonreception.facture_id' => 0, 'Bonreception.fournisseur_id' => $clientid, 'Bonreception.id not in (' . $id . ')')));
        $summtreg = array(); //$this->Bonreception->find('all', array('fields' => array('sum(Bonreception.Montant_Regler) as totalregb')
        //, 'conditions' => array('Bonreception.id > ' => 0, 'Bonreception.facture_id' => 0, 'Bonreception.fournisseur_id' => $clientid)));
        $sumttcf = $this->Facture->find('all', array('fields' => array('sum(Facture.totalttc) as totalttf')
            , 'conditions' => array('Facture.id > ' => 0, 'Facture.fournisseur_id' => $clientid, 'Facture.id not in (' . $id . ')')));
        $summtregf = array(); //$this->Facture->find('all', array('fields' => array('sum(Facture.Montant_Regler) as totalregf')
        //, 'conditions' => array('Facture.id > ' => 0, 'Facture.fournisseur_id' => $clientid)));
        $reglementlibre = $this->Reglement->find('all', array('fields' => array('sum(Reglement.Montant) as reglibretotale')
            , 'conditions' => array('Reglement.fournisseur_id' => $clientid)));
        $valbl = 0; //$sumttc[0][0]['totalttcb'] - $summtreg[0][0]['totalregb'];
        $valfac = 0; //$sumttcf[0][0]['totalttf'] - $summtregf[0][0]['totalregf'];
        $valglobal = $valbl + $valfac;
        $solde = $valglobal - $reglementlibre[0][0]['reglibretotale'];
        //$valreste = $autorisation - ($valglobal - $reglementlibre[0][0]['reglibretotale']);
        //fin info client************************************************
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.id' => $p)));
        }
        $this->set(compact('ligne_model', 'fournisseurs', 'model', 'typeclient_id', 'name', 'autorisation', 'solde', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'clients', 'utilisateurs', 'timbre', 'depots', 'date', 'lignefactureclients', 'articles', 'tabqtestock'));
    }

    public function edit_anc($id = null, $model = null, $ligne_model = null, $attribut = null) {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factures') {
                    $facture = $liens['edit'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($model);
        $this->loadModel($ligne_model);
        $this->loadModel('Pointdevente');
        $this->loadModel('Depot');
        $this->loadModel('Article');
        $this->loadModel('Fournisseur');
        $this->loadModel('Stockdepot');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Importation');
        $this->loadModel('Tracemodificationprixdevente');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Compte');
        if (!$this->Facture->exists($id)) {
            throw new NotFoundException(__('Invalid facture'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug( $this->request->data);die;
            $this->request->data[$model]['datefacture'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['datefacture'])));
            $this->request->data[$model]['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            $this->request->data[$model]['utilisateur_id'] = CakeSession::read('users');
            if ($this->request->data[$model]['typefac'] == "service") {
                $this->request->data[$model]['type'] = 'service';
            }

            if ($this->request->data[$model]['typefac'] != "service") {
                $facture = $this->$model->find('first', array('conditions' => array($model . '.id' => $id), false));
                $Lignefactures = array();
                $lignefactureanciens = $this->$ligne_model->find('all', array('conditions' => array($ligne_model . '.' . $attribut => $id), false));
                foreach ($lignefactureanciens as $lra) {
                    //if($facture[$model]['type']=="direct"){
                    $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $lra[$ligne_model]['article_id'],
                            'Stockdepot.depot_id' => $lra[$ligne_model]['depot_id']), false));
                    $coutderevienttot = ($stckdepot[0]['Stockdepot']['prix'] * $stckdepot[0]['Stockdepot']['quantite']) - $lra[$ligne_model]['totalht'];
                    $condb1 = 'Bonreception.date >= ' . "'" . $this->request->data[$model]['date'] . "'";
                    $condf1 = 'Facture.date >= ' . "'" . $this->request->data[$model]['date'] . "'";
                    $qtelivres = $this->Lignelivraison->find('all', array(
                        'fields' => array('sum(Lignelivraison.quantite) as quantite')
                        , 'conditions' => array('Bonreception.' . $attribut => 0, 'Lignelivraison.article_id' => $lra[$ligne_model]['article_id'], @$condb1)
                        , 'recursive' => 2));
                    $qtefacs = $this->Lignefactureclient->find('all', array(
                        'fields' => array('sum(Lignefactureclient.quantite) as quantite')
                        , 'conditions' => array('Lignefactureclient.article_id' => $lra[$ligne_model]['article_id'], @$condf1)
                        , 'recursive' => 2));
                    $qtevente = $qtelivres[0][0]['quantite'] + $qtefacs[0][0]['quantite'];
                    $qte = $stckdepot[0]['Stockdepot']['quantite'] + $qtevente - $lra[$ligne_model]['quantite'];
                    if ($qte != 0) {
                        $coutderevient = $coutderevienttot / $qte;
                    } else {
                        $coutderevient = 0;
                    }
                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite-' . $lra[$ligne_model]['quantite'], 'Stockdepot.prix' => $coutderevient), array('Stockdepot.article_id' => $lra[$ligne_model]['article_id'], 'Stockdepot.depot_id' => $lra[$ligne_model]['depot_id']));
                }
                //} 
                //$this->Stockdepot->deleteAll(array('Stockdepot.quantite'=>0),false);
                $this->$ligne_model->deleteAll(array($ligne_model . '.' . $attribut => $id), false);
            }
            if ($this->Facture->save($this->request->data)) {
                //debug($this->request->data);die;
                $this->misejour($model, "edit", $id);

                if (!empty($this->request->data[$ligne_model])) {
                    foreach ($this->request->data[$ligne_model] as $f) {

                        //  debug($f);die;
                        if ($this->request->data[$model]['typefac'] != "service") {
                            if ($f['sup'] != 1) {



                                $Lignefactures['prixachatans'] = $f['prixachatans'];
                                $Lignefactures['margeans'] = $f['margeans'];

                                $Lignefactures['id'] = $f['id'];
                                $Lignefactures['facture_id'] = $id;
                                $Lignefactures['depot_id'] = $f['depot_id'];
                                $depotid = $f['depot_id'];
                                $Lignefactures['article_id'] = $f['article_id'];
                                $Lignefactures['quantite'] = $f['quantite'];
                                if (!empty($f['prix'])) {
                                    $Lignefactures['prix'] = $f['prix'];
                                    $Lignefactures['prix_anc'] = $f['prix_anc'];
                                }
                                $Lignefactures['prixhtva'] = $f['prixhtva'];
                                $Lignefactures['remise'] = @$f['remise'];
                                $Lignefactures['fodec'] = @$f['fodec'];
                                $Lignefactures['tva'] = $f['tva'];

                                $Lignefactures['prixhtva'] = $f['prixhtva'];
                                if (!empty($f['prix'])) {
                                    $Lignefactures['totalht'] = $f['totalht'];
                                    $Lignefactures['totalttc'] = $f['totalttc'];
                                } else {
                                    $Lignefactures['totalht'] = ($f['prixhtva'] * (1 - @$f['remise'] * 0.01)) * $f['quantite'];
                                    $Lignefactures['totalttc'] = ((($Lignefactures['totalht']) * (1 + (@$f['fodec'] * 0.01))) * (1 + ($f['tva'] * 0.01)));
                                }

                                $this->$ligne_model->create();
                                $this->$ligne_model->save($Lignefactures);

                                if (!empty($f['prix'])) {
                                    //zeinab
                                    $importations = $this->Importation->find('first', array('conditions' => array('Importation.id' => $this->request->data[$model]['importation_id']), false));
                                    $totale_facture_devise = $importations['Importation']['montantachat'];  //debug($importations);die;
                                    $this->Facture->updateAll(array($model . '.totaldevise' => $totale_facture_devise), array($model . '.id' => $id));

                                    $tc = $this->request->data[$model]['tr'];
                                    $coe = $this->request->data[$model]['coe'];
                                    if (empty($tc)) {
                                        $tc = 1;
                                    }
                                    if (empty($coe)) {
                                        $coe = 1;
                                    }
                                    if (empty($f['prixhtva'])) {
                                        $f['prixhtva'] = 0;
                                    }
                                    $this->Article->updateAll(array('Article.coutrevient' => sprintf('%.3f', $Lignefactures['totalht'] / $f['quantite']), 'Article.tauxchange' => $tc, 'Article.coefficient' => $coe, 'Article.prixachatdevise' => $f['prix']), array('Article.id' => $f['article_id']));
                                } else {
                                    $this->Article->updateAll(array('Article.coutrevient' => $f['prixhtva'], 'Article.tauxchange' => 1, 'Article.coefficient' => 1), array('Article.id' => $f['article_id']));
                                }
                                if ((!empty($f['margeA'])) || (!empty($f['pvA']))) {
                                    $trace = array();
                                    $aticle = $this->Article->find('first', array('conditions' => array('Article.id' => $f['article_id'])));
                                    $marge_ans = $aticle['Article']['marge'];
                                    $prixvente_ans = $aticle['Article']['prixvente'];
                                    $this->Article->updateAll(array('Article.prixvente' => $f['pvA'], 'Article.marge' => $f['margeA']), array('Article.id' => $f['article_id']));
                                    $trace['utilisateur_id'] = CakeSession::read('users');
                                    $trace['date'] = date("Y-m-d");
                                    $trace['heure'] = date("H:i", time());
                                    $trace['article_id'] = $f['article_id'];
                                    $trace['prixventeans'] = $prixvente_ans;
                                    $trace['margeans'] = $marge_ans;
                                    $trace['prixventenv'] = $f['pvA'];
                                    $trace['margenv'] = $f['margeA'];
                                    $this->Tracemodificationprixdevente->create();
                                    $this->Tracemodificationprixdevente->save($trace);
                                }
                                $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $depotid)));
                                // debug($stckdepot);die;     
                                if (!empty($stckdepot)) {
                                    $coutderevienttot = ($stckdepot[0]['Stockdepot']['prix'] * $stckdepot[0]['Stockdepot']['quantite']) + $Lignefactures['totalht'];
                                    $qte = $f['quantite'] + $stckdepot[0]['Stockdepot']['quantite'];
                                    if ($qte != 0) {
                                        $coutderevient = $coutderevienttot / $qte;
                                    } else {
                                        $coutderevient = 0;
                                    }
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $f['quantite'], 'Stockdepot.prix' => $coutderevient), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                                    // $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                } else {
                                    $f['prix'] = $Lignefactures['totalht'] / $f['quantite'];
                                    $f['depot_id'] = $depotid;

                                    $this->Stockdepot->create();
                                    $this->Stockdepot->save($f);
                                }
                                // $this->stock($depotid, $f['article_id']);
                            }
                        } else {
                            $this->Lignefacture->deleteAll(array($ligne_model . '.' . $attribut => $id), false);
                            $Lignefactures[$attribut] = $id;
                            $Lignefactures['designation'] = $f['designation'];
                            $Lignefactures['totalttc'] = $f['totalttc'];
                            $this->$ligne_model->create();
                            $this->$ligne_model->save($Lignefactures);
                        }
                    }
                }
                $this->Session->setFlash(__('The facture has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array($model . '.' . $this->$model->primaryKey => $id));
            $this->request->data = $this->$model->find('first', $options);
            //debug($this->request->data);
            $day = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data[$model]['date'])));
            $datefac = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data[$model]['datefacture'])));
            $lignefactures = $this->$ligne_model->find('all', array('conditions' => array($ligne_model . '.' . $attribut => $id), 'order' => array($ligne_model . '.id' => 'asc')));
            if ($this->request->data[$model]['importation_id'] != 0) {
                $importations = $this->Importation->find('list', array('conditions' => array('Importation.fournisseur_id' => $this->request->data[$model]['fournisseur_id'], 'Importation.etat' => 0), false));
                $tr = $this->request->data['Importation']['tauxderechenge'];
                $coe = $this->request->data['Importation']['coefficien'];
            }
            if ($this->request->data['Fournisseur']['devise_id'] != 1) {
                $fournisseurs = $this->$model->Fournisseur->find('list');
            } else {
                $fournisseurs = $this->$model->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1)));
            }
            $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $this->request->data['Fournisseur']['id']), false));
            $devise = $fournisseur['Fournisseur']['devise_id'];
            //zeinab
            /* $art = $this->Facture->query('
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
              WHERE articlefournisseurs.fournisseur_id =' . $this->request->data[$model]['fournisseur_id'] . '
              AND articles.id = articlefournisseurs.article_id');
              $articles = array();
              foreach ($art as $v) {
              if ($v[0]['codeart'] == $v[0]['refart']) {
              $v[0]['refart'] = "";
              }
              $articles[$v[0]['id']] = $v[0]['refart'] . " " . $v[0]['codeart'] . " " . $v[0]['desart'];
              }
              $articles = $this->Article->find('list'); */
            $p = CakeSession::read('pointdevente');
            $societe = CakeSession::read('societe');
            if ($societe != 0) {
                $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societe, 'Depot.typeetatarticle_id' => 1)));
            } else {
                $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
            }

            $timbre = $this->$model->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        }
        //debug($datefac);die;
        //zeinab
        $comptes = $this->Compte->find('list', array('fields' => array('Compte.banque')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('pointdeventes', 'p', 'devise', 'comptes', 'datefac', 'importations', 'coe', 'tr', 'fournisseurs', 'fournisseur', 'timbre', 'lignefactures', 'day', 'articles', 'depots'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
//debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factures') {
                    $facture = $liens['delete'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignefacture');
        $this->loadModel('Bonreception');
        $this->loadModel('Commande');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignereception');
        $this->loadModel('Bonreception');
        $this->loadModel('Article');
        $this->loadModel('Factureavoirfr');

        $this->Facture->id = $id;
        if (!$this->Facture->exists()) {
            throw new NotFoundException(__('Invalid facture'));
        }
        $this->request->onlyAllow('post', 'delete');

//$facture = $this->Facture->find('first', array('conditions' => array('Facture.id' => $id), false));
//$Lignefactures = array();
        $facture = $this->Facture->find('first', array('conditions' => array('Facture.id' => $id), 'recursive' => -1));
        $lignefactureanciens = $this->Lignefacture->find('all', array('conditions' => array('Lignefacture.facture_id' => $id), false));
//        debug($lignefactureanciens);
//        die;
        foreach ($lignefactureanciens as $lra) {
            if ($facture['Facture']['type'] != 'trans_bl') {
                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite-' . $lra['Lignefacture']['quantite']), array('Stockdepot.article_id' => $lra['Lignefacture']['article_id'], 'Stockdepot.depot_id' => $lra['Lignefacture']['depot_id']));
            }
        }




//recalcule pmp 
        if ($facture['Facture']['type'] != 'trans_bl') {
            $Lignereceptions = $this->Lignefacture->find('all', array('conditions' => array('Lignefacture.facture_id' => $id), false));
            if (!empty($Lignereceptions)) {
                foreach ($Lignereceptions as $f) {
                    $tmps = $this->Facture->query(
                            'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
                        FROM (
                        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $f['Lignefacture']['article_id'] . ' 
                        and factures.time>=' . '"' . $facture['Facture']['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $f['Lignefacture']['article_id'] . ' 
                        and bonreceptions.time>=' . '"' . $facture['Facture']['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                        )tmp
                        order BY tmp.time');
                    if ($tmps != null) {
                        if (($tmps[count($tmps) - 1]['tmp']['id'] == $f['Lignefacture']['id']) && ($tmps[count($tmps) - 1]['tmp']['type'] == 0)) {
//nlawej achat eli just 9balh
//Si l achat supprimé est la derniére achat
//Dernier achat avant l'achat actuelle pour recherche qte et cout ancien
                            $tmps = $this->Facture->query(
                                    'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
                        FROM (
                        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $f['Lignefacture']['article_id'] . ' 
                        and factures.time<' . '"' . $facture['Facture']['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $f['Lignefacture']['article_id'] . ' 
                        and bonreceptions.time<' . '"' . $facture['Facture']['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                        )tmp
                        order BY tmp.time desc
                        limit 1');
                            if (!empty($tmps)) {
//S'il y a au moins un achat precédent
                                $afterprixstk = $tmps[0]['tmp']['coutstkancien'];
                                $afterqtestk = $tmps[0]['tmp']['qtestkancien'];
                                $qteac = $tmps[0]['tmp']['quantite'];
                                $coutac = $tmps[0]['tmp']['totalht'];
                                if ($afterqtestk <= 0) {
                                    $pmpfinal = $tmps[0]['tmp']['totalht'] / $tmps[0]['tmp']['quantite'];
                                } else {
                                    $pmpfinal = ($afterprixstk * $afterqtestk + $tmps[0]['tmp']['totalht']) / ($tmps[0]['tmp']['quantite'] + $afterqtestk);
                                }
                                $this->Article->updateAll(array('Article.pmp' => $pmpfinal), array('Article.id' => $f['Lignefacture']['article_id']));
                            } else {
                                $rechfirstpmp = $this->Facture->query('SELECT articlepmps.pmp from articlepmps where article_id=' . $f['Lignefacture']['article_id']);
                                $dernierpmp = $rechfirstpmp[0]['articlepmps']['pmp'];
                                $this->Article->updateAll(array('Article.pmp' => $dernierpmp), array('Article.id' => $f['Lignefacture']['article_id']));
                            }
                        } else {
//ligne achat intérmédiaire
//$this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite-' . $f['quantite']), array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $cedevi['Bonreception']['depot_id']));
                            $afterachats = $this->Facture->query(
                                    'SELECT tmpafter.time,tmpafter.qtestkancien,tmpafter.coutstkancien,tmpafter.id,tmpafter.type
                        FROM (
                        (SELECT  factures.time,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $f['Lignefacture']['article_id'] . ' 
                        and factures.time>' . '"' . $facture['Facture']['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $f['Lignefacture']['article_id'] . '
                        and bonreceptions.time>' . '"' . $facture['Facture']['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                        )tmpafter
                        order BY tmpafter.time');
                            $lignecr = $this->Lignefacture->find('first', array('recursive' => 1, 'conditions' => array('Lignefacture.id' => $f['Lignefacture']['id'])));
                            $afterprix = $lignecr['Lignefacture']['coutstkancien'];
                            $afterqte = $lignecr['Lignefacture']['qtestkancien'];
                            $qteligne = 0;
                            foreach ($afterachats as $key => $afterachat) {

                                if ($afterachat['tmpafter']['type'] == 0) {
                                    $this->Lignereception->updateAll(array('Lignereception.qtestkancien' => $afterqte + $qteligne, 'Lignereception.coutstkancien' => $afterprix), array('Lignereception.id' => $afterachat['tmpafter']['id']));
                                }
                                if ($afterachat['tmpafter']['type'] == 1) {
                                    $this->Lignefacture->updateAll(array('Lignefacture.qtestkancien' => $afterqte + $qteligne, 'Lignefacture.coutstkancien' => $afterprix), array('Lignefacture.id' => $afterachat['tmpafter']['id']));
                                }
//                                        $afterprix = $afterachat['tmpafter']['coutstkancien'];
//                                        $afterqte = $afterachat['tmpafter']['qtestkancien'];
                                $dernierachatid = $afterachat['tmpafter']['id'];
                                $dernierachattyp = $afterachat['tmpafter']['type'];
                                if ($dernierachattyp == 0) {
                                    $lignecr = $this->Lignereception->find('first', array('recursive' => 1, 'conditions' => array('Lignereception.id' => $dernierachatid)));
                                    $afterprix = $lignecr['Lignereception']['coutstkancien'];
                                    $afterqte = $lignecr['Lignereception']['qtestkancien'];
                                    $qteligne = $lignecr['Lignereception']['quantite'];
                                    $htligne = $lignecr['Lignereception']['totalht'];
                                }
                                if ($dernierachattyp == 1) {
                                    $lignecr = $this->Lignefacture->find('first', array('recursive' => 1, 'conditions' => array('Lignefacture.id' => $dernierachatid)));
                                    $afterprix = $lignecr['Lignefacture']['coutstkancien'];
                                    $afterqte = $lignecr['Lignefacture']['qtestkancien'];
                                    $qteligne = $lignecr['Lignefacture']['quantite'];
                                    $htligne = $lignecr['Lignefacture']['totalht'];
                                }
                                if (($afterqte + $qteligne) <= 0) {
                                    $afterprix = $htligne / $qteligne;
                                } else {
                                    $afterprix = ($afterprix * $afterqte + $htligne) / ($qteligne + $afterqte);
                                }
                            }

                            $this->Article->updateAll(array('Article.pmp' => $afterprix), array('Article.id' => $f['Lignefacture']['article_id']));
                        }
                    }
                }
            }
        }
//fin recalcule pmp 

        if ($facture['Facture']['type'] == "trans_bl") {
            $this->Bonreception->updateAll(array('Bonreception.facture_id' => 0), array('Bonreception.facture_id' => $id));
            $this->Factureavoirfr->updateAll(array('Factureavoirfr.facture_id' => 0), array('Factureavoirfr.facture_id' => $id));
        }

        if ($facture['Facture']['type'] == "indirect") {
            $this->Bonreception->updateAll(array('Bonreception.facture_id' => 0), array('Bonreception.facture_id' => $id));
            $this->Commande->updateAll(array('Commande.facture_id' => 0, 'Commande.validite_id' => 2), array('Commande.facture_id' => $id));
        }
        $abcd = $this->Facture->find('first', array('conditions' => array('Facture.id' => $id), 'recursive' => -1));
        $numansar = $abcd['Facture']['numero'];
        $pvansar = $abcd['Facture']['pointdevente_id'];


//****
        if ($facture['Facture']['type'] != 'trans_bl') {
            $Lignereceptions = $this->Lignefacture->find('all', array('conditions' => array('Lignefacture.facture_id' => $id), false));
            if (!empty($Lignereceptions)) {
                foreach ($Lignereceptions as $f) {
                    $dernierachat = $this->Bonreception->query(
                            'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
        FROM (
        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
        FROM  factures,lignefactures
         where  factures.id=lignefactures.facture_id 
        and   lignefactures.article_id=' . $f['Lignefacture']['article_id'] . ' 
        and factures.time>' . '"' . $facture['Facture']['time'] . '"' . '
        order BY  factures.time
        )
        UNION (
        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
        FROM  bonreceptions,lignereceptions
        where  bonreceptions.id=lignereceptions.bonreception_id and
        bonreceptions.facture_id=0 and
        lignereceptions.article_id=' . $f['Lignefacture']['article_id'] . ' 
       and bonreceptions.time>' . '"' . $facture['Facture']['time'] . '"' . '
        order BY  bonreceptions.time
        )
        )tmp
        order BY tmp.time desc
        limit 1');
                    if (empty($dernierachat)) {

                        $tmps = $this->Bonreception->query(
                                'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
        FROM (
        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
        FROM  factures,lignefactures
         where  factures.id=lignefactures.facture_id 
        and   lignefactures.article_id=' . $f['Lignefacture']['article_id'] . ' 
        and factures.time<' . '"' . $facture['Facture']['time'] . '"' . '
        order BY  factures.time
        )
        UNION (
        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
        FROM  bonreceptions,lignereceptions
        where  bonreceptions.id=lignereceptions.bonreception_id and
        bonreceptions.facture_id=0 and
        lignereceptions.article_id=' . $f['Lignefacture']['article_id'] . ' 
       and bonreceptions.time<' . '"' . $facture['Facture']['time'] . '"' . '
        order BY  bonreceptions.time
        )
        )tmp
        order BY tmp.time desc
        limit 1');
                        if (empty($dernierachat)) {
                            if (!empty($tmps)) {
                                $prixachat = $tmps[0]['tmp']['totalht'] / $tmps[0]['tmp']['quantite'];
                            } else {
                                $rechfirstpmp = $this->Facture->query('SELECT articlepmps.coutrevient from articlepmps where article_id=' . $f['Lignefacture']['article_id']);
                                $prixachat = $rechfirstpmp[0]['articlepmps']['coutrevient'];
                            }
                           // $this->Article->updateAll(array('Article.coutrevient' => $prixachat), array('Article.id' => $f['Lignefacture']['article_id']));
                        }
                    }
                    $aticle = $this->Article->find('first', array('conditions' => array('Article.id' => $f['Lignefacture']['article_id'])));
//                $n_marge = (($aticle['Article']['prixvente'] - $aticle['Article']['pmp']) / $aticle['Article']['pmp']) * 100;
//                $this->Article->updateAll(array('Article.marge' => sprintf('%.3f', $n_marge)), array('Article.id' => $f['Lignefacture']['article_id']));
                }
            }
        }
//****


        if ($this->Facture->delete()) {
//*****
            $this->Lignefacture->deleteAll(array('Lignefacture.facture_id' => $id), false);
//*****
            $this->misejour("Facture", $numansar, $id,$pvansar);
            $this->Session->setFlash(__('Facture deleted'));
            CakeSession::write('view', "delete");
//$this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Facture was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factures') {
                    $facture = $liens['imprimer'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Facture.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Facture.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Facture.fournisseur_id =' . $fournisseurid;
        }
        if ($this->request->query['utilisateurid']) {
            $utilisateurid = $this->request->query['utilisateurid'];
            $cond4 = 'Facture.utilisateur_id =' . $utilisateurid;
        }
        if ($this->request->query['typeid']) {
            $typeid = $this->request->query['typeid'];
            if ($typeid == 2) {
                $type = "service";
                $cond5 = 'Facture.type =' . "'" . $type . "'";
            } else {
                $type = "service";
                $cond5 = 'Facture.type <>' . "'" . $type . "'";
            }
        }


        $this->loadModel('Utilisateur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $this->loadModel('Personnel');
        if (!empty($this->request->query['societe_id'])) {
            $societe_id = $this->request->query['societe_id'];
            $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
            $ch_pv = 0;
            foreach ($lespvs as $lespv) {
                $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
            }
            $cond6 = 'Facture.pointdevente_id in (' . $ch_pv . ')';
            $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societe_id)));
        }


        if (!empty($this->request->query['pointdevente_id'])) {
            $pointdevente_id = $this->request->query['pointdevente_id'];
            $cond7 = 'Facture.pointdevente_id =' . $pointdevente_id;
        }
        if ($this->request->query['fac_id']) {
            $fac_id = $this->request->query['fac_id'];
            $cond8 = 'Facture.id =' . $fac_id;
            $cond1 = "";
            $cond2 = "";
        }


        $factures = $this->Facture->find('all', array('conditions' => array('Facture.id > ' => 0, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6, @$cond7, @$cond8)));

        $this->set(compact('factures', 'date1', 'date2', 'fournisseurid', 'utilisateurid'));
    }

    public function artfour() {
        $this->layout = null;
        $this->loadModel('Article');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Fournisseur');


        $data = $this->request->data; //debug($data);
        $json = null;
        $fournisseurid = $data['id'];
        $name = 'article_id';

        $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $fournisseurid), false));
        $devise = $fournisseur['Fournisseur']['devise_id'];
        //  debug($devise);die;  

        $art = $this->Articlefournisseur->find('all', array('conditions' => array('Articlefournisseur.fournisseur_id' => $fournisseurid), 'recursive' => -1));
        $t = '(0,';
        foreach ($art as $l) {
            $t = $t . $l['Articlefournisseur']['article_id'] . ',';
        }
        $t = $t . '0)';
        // debug($t);

        if ($fournisseurid != 0) {
            $articles = $this->Article->find('all', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
            $select = "<select   name='data[Lignefacture][0][article_id]' table=$ligne_model index='0' champ='article_id' id='article_id0' class='select form-control idarticle' onchange='tvaart(0)'><option selected disabled hidden value=0> Veuillez choisir</option>";
            foreach ($articles as $v) {
                $select = $select . "<option value=" . $v['Article']['id'] . ">" . $v['Article']['name'] . "</option>";
            }
            $select = $select . '</select>';
            // die();
            //   debug($Articleid);
            // echo $code;
            // echo json_encode(array('select'=>$select));
        } else {
            $articles = $this->Article->find('all');
            $select = "<select name='" . $name . "' champ='article_id' id='article_id'  class='' onchange='tvaart(ind) testligneinv'><option selected disabled hidden value=0> Veuillez choisir</option>";
            foreach ($articles as $v) {
                $select = $select . "<option value=" . $v['Article']['id'] . ">" . $v['Article']['name'] . "</option>";
            }
            $select = $select . '</select>';
            // die();
            //   debug($Articleid);
            // echo $code;
        }
        $selectf = "<select name='" . $name . "' table=$ligne_model champ='article_id' id='article_id'  class='' onchange='tvaart(ind) testligneinv'><option selected disabled hidden value=0> Veuillez choisir</option>";
        $selectf = $selectf . "<option value=''>veullier choisir</option>";
        foreach ($articles as $v) {
            $selectf = $selectf . "<option value=" . $v['Article']['id'] . ">" . $v['Article']['name'] . "</option>";
        }
        $selectf = $selectf . '</select>';

        echo json_encode(array('select' => $select, 'selectf' => $selectf, 'devise' => $devise));
        die();
    }

    public function transformation($model = null, $ligne_model = null, $attribut = null, $liste_in = null, $model_ans = null, $ligne_model_ans = null, $attribut_ans = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($model);
        $this->loadModel($ligne_model);
        $this->loadModel($model_ans);
        $this->loadModel($ligne_model_ans);
        $this->loadModel('Pointdevente');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepot');
        $this->loadModel('Article');
        $this->loadModel('Reglementclient');
        $this->loadModel('Stockdepotfacture');
        $this->loadModel('Depot');
        $this->loadModel('Timbre');
        $this->loadModel('Fournisseur');
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignecommandeclient');
        $this->loadModel('Articlefournisseur');

        if ($this->request->is('post') || $this->request->is('put')) {
//            debug($this->request->data);
//            die;

            $fournisseur_id = $this->request->data[$model]['fournisseur_id'];
            $depotid = $this->request->data[$model]['depot_id'];
            $this->request->data[$model]['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            $this->request->data[$model]['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data[$model]['pointdevente_id'])) {
                $this->request->data[$model]['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data[$model]['exercice_id'] = date("Y", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            if (empty($this->request->data[$model]['timbre_id'])) {
                $this->request->data[$model]['timbre_id'] = 0;
            }
            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data[$model]['pointdevente_id'];
            }
            if ($model_ans == 'Bonreception') {
                $this->request->data[$model]['type'] = "trans_bl";
            } else {
                $this->request->data[$model]['type'] = "indirect";
            }
//            debug($this->request->data);
//            die;
            $this->$model->create();
            if ($this->$model->save($this->request->data)) {
                $id = $this->$model->id;
                $this->misejour($model, "add", $id);
                $liste = '(0,' . $liste_in . ',0)';
                $this->$model_ans->updateAll(array($model_ans . '.' . $attribut => $id), array($model_ans . '.id in ' . $liste));
                $Lignefactureclients = array();
                $stockdepots = array();
                foreach ($this->request->data['Lignereception'] as $numl => $f) {
//                    debug($f);
//                    die;
                    if ($f['sup'] != 1) {
                        if ($f['article_id'] != "") {
                            $f['depot_id'] = $this->request->data[$model]['depot_id'];
                            if ($f['qtebonus'] == '') {
                                $f['qtebonus'] = 0;
                            }
                            $Lignefactureclients['qtebonus'] = $f['qtebonus'];
                            $stockdepots[$numl]['quantite'] = $f['quantite'] + $f['qtebonus'];
                            $stockdepots[$numl]['depot_id'] = $f['depot_id'];
                            $stockdepots[$numl]['article_id'] = $f['article_id'];
                            $Lignefactureclients[$attribut] = $id;
                            $Lignefactureclients['depot_id'] = $f['depot_id'];
                            $Lignefactureclients['article_id'] = $f['article_id'];
                            $Lignefactureclients['quantite'] = $f['quantite'] + $f['qtebonus'];
                            $Lignefactureclients['remise'] = $f['remise'];
                            $Lignefactureclients['tva'] = $f['tva'];
                            $Lignefactureclients['prix'] = $f['prixhtva'];
                            $Lignefactureclients['fodec'] = $f['fodec'];
                            $Lignefactureclients['totalhtans'] = @$f['totalhtans'];
                            $Lignefactureclients['designation'] = $f['designation'];
                            $Lignefactureclients['totalht'] = $f['totalht'];
                            $Lignefactureclients['totalttc'] = $f['totalttc'];
                            $Lignefactureclients['marge'] = @$f['marge'];
                            $Lignefactureclients['prixdeventeht'] = @$f['prixdeventeht'];
                            if ($model_ans == "Commande") {
                                $Lignefactureclients['commande_id'] = $f['commande_id'];
                            }
                            if ($model_ans == 'Bonreception') {
                                $Lignefactureclients['bonreception_id'] = $f['bonreception_id'];
                            }
                            if (($model == "Facture") || ($model == "Bonreception")) {
                                // Mise à jour article
                                $this->Article->updateAll(array('Article.marge' => $f['marge'], 'Article.prixvente' => $f['prixdeventeht']), array('Article.id' => $f['article_id']));
                                if ($model_ans != "Bonreception") {
                                    //**Enregistrement de cout et de quantité ancien
                                    $qtesum = $this->Stockdepot->find('first', array(
                                        'fields' => array('sum(Stockdepot.quantite) quantite'),
                                        'conditions' => array('Stockdepot.article_id' => $f['article_id'])));
                                    $articlepmp = $this->Article->find('first', array(
                                        'recursive' => -1,
                                        'conditions' => array('Article.id' => $f['article_id'])));
                                    $pmparticle = 0;
                                    if (!empty($articlepmp['Article']['pmp'])) {
                                        $pmparticle = $articlepmp['Article']['pmp'];
                                    }
                                    $Lignefactureclients['qtestkancien'] = $qtesum[0]['quantite'];
                                    $Lignefactureclients['coutstkancien'] = $pmparticle;
                                }
                            }
                            $this->$ligne_model->create();
                            $this->$ligne_model->save($Lignefactureclients);
                            /*                             * ******** Verification des articles et mise à jour des familles ************ */
                            //debug($f);die;
                            $article_id = $f['article_id'];
                            $artdetails = $this->Article->find('first', array('conditions' => array('Article.id' => $article_id), 'recursive' => -1));
                            if ($f['famille_id'] == '' || $f['famille_id'] == null || empty($f['famille_id']))
                                $f['famille_id'] = "0";
                            if ($f['sousfamille_id'] == '' || $f['sousfamille_id'] == null || empty($f['sousfamille_id']))
                                $f['sousfamille_id'] = "0";
                            if ($f['soussousfamille_id'] == '' || $f['soussousfamille_id'] == null || empty($f['soussousfamille_id']))
                                $f['soussousfamille_id'] = "0";
                            if ($f['fodec'] == '' || $f['fodec'] == null || empty($f['fodec']))
                                $f['fodec'] = "0";
                            //debug($f);die;
                            if (($model == "Facture") || ($model == "Bonreception")) {
                                $mntremise = floatval($f['prixhtva']) * (floatval($f['remise']) / 100);
                                $mntapresremise = floatval($f['prixhtva']) - floatval($mntremise);
                                if ($artdetails != array()) {
                                    //debug($artdetails);die;
                                    $margebrutgros = $artdetails['Article']['margebrutgros'];
                                    $margebrutgross = floatval($f['prixhtva']) * floatval($margebrutgros) / 100;
                                    $prixventegros = floatval($f['prixhtva']) + floatval($margebrutgross);
                                    $margenet = (floatval($prixventegros) - floatval($mntapresremise)) / floatval($mntapresremise);
                                    $margebrutdetails = $artdetails['Article']['margebrutdetail'];
                                    $margebrutdetailss = floatval($f['prixhtva']) * floatval($margebrutdetails) / 100;
                                    $prixventedetails = floatval($f['prixhtva']) + floatval($margebrutdetailss);
                                    $margenetdetails = (floatval($prixventedetails) - floatval($mntapresremise)) / floatval($mntapresremise);
                                    $this->Article->updateAll(array(
                                        'Article.coutrevient' => $f['prixhtva'],
                                        'Article.remise' => $f['remise'],
                                        'Article.fodec' => $f['fodec'],
                                        'Article.famille_id' => $f['famille_id'],
                                        'Article.sousfamille_id' => $f['sousfamille_id'],
                                        'Article.soussousfamille_id' => $f['soussousfamille_id'])
                                            //'Article.prixachatnet' => $mntapresremise,
                                            //'Article.prixventegros' => $prixventegros,
                                            //'Article.margenetgros' => $margenet,
                                            //'Article.prixvente' => $prixventedetails,
                                            //'Article.margenetdetail' => $margenetdetails)
                                            , array('Article.id' => $article_id));
                                }
                            }
                            $artfrsdetails = $this->Articlefournisseur->find('first', array('conditions' => array('Articlefournisseur.article_id' => $article_id
                                    , 'Articlefournisseur.fournisseur_id' => $fournisseur_id), 'recursive' => -1));
                            if ($artfrsdetails == array()) {
                                $artfrs = array();
                                //$art['article_id']=$article_id;
                                $artfrs['article_id'] = $article_id;
                                $artfrs['fournisseur_id'] = $fournisseur_id;
                                $artfrs['prix'] = $mntapresremise;
                                $artfrs['reference'] = $f['articlefrs_id'];
                                $this->Articlefournisseur->create();
                                $this->Articlefournisseur->save($artfrs);
                            } else {
                                $this->Articlefournisseur->updateAll(array('Articlefournisseur.prix' => $f['prixhtva'], 'Articlefournisseur.reference' => "'" . $f['articlefrs_id'] . "'"
                                        ), array('Articlefournisseur.article_id' => $article_id
                                    , 'Articlefournisseur.fournisseur_id' => $fournisseur_id));
                            }

                            if (($model == "Facture") || ($model == "Bonreception")) {
                                if ($model_ans != "Bonreception") {
                                    //**Mise à jour de pmp
                                    $coutderevienttot = ($pmparticle * $qtesum[0]['quantite']) + $Lignefactureclients['totalht'];
                                    if ($qtesum[0]['quantite'] <= 0) {
                                        $coutderevient = $f['totalht'] / $f['quantite'];
                                    } else {
                                        $coutderevient = $coutderevienttot / ($qtesum[0]['quantite'] + $f['quantite']);
                                    }
                                    //debug($coutderevient);die;
                                    $this->Article->updateAll(array('Article.pmp' => $coutderevient), array('Article.id' => $f['article_id']));
                                    //** Mise à jour stock depot
                                    $stckdepot = $this->Stockdepot->find('all', array(
                                        'conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
                                    if (!empty($stckdepot)) {
                                        $qtestk = $stockdepots[$numl]['quantite'] + $stckdepot[0]['Stockdepot']['quantite'];
                                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qtestk), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                                    } else {
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($stockdepots[$numl]);
                                    }
                                }
                            }

//                            if (($model == "Facture") || ($model == "Bonreception")) {
//                            if ($model_ans != "Bonreception"){    
//                                $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
//                                if (!empty($stckdepot)) {
//                                    $coutderevienttot = ($stckdepot[0]['Stockdepot']['prix'] * $stckdepot[0]['Stockdepot']['quantite']) + $f['totalht'];
//                                    $qte = $f['quantite'] + $stckdepot[0]['Stockdepot']['quantite'];
//                                    $coutderevient = $coutderevienttot / $qte;
//                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $f['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
//                                    $this->Stockdepot->updateAll(array('Stockdepot.prix' => $coutderevient), array('Stockdepot.article_id' => $f['article_id']));
//                                } else {
//                                    $f['prix'] = $f['totalht'] / $f['quantite'];
//                                    $f['depot_id'] = $depotid;
//                                    $this->Stockdepot->create();
//                                    $this->Stockdepot->save($f);
//                                }
//                            }
//                            }
                        }
                    } else {
                        if (!empty($f['id'])) {
                            $this->$ligne_model->deleteAll(array($ligne_model . '.id' => $f['id']), false);
                        }
                    }
                }
                $this->Session->setFlash(__('The factureclient has been saved'));
                //$this->redirect(array('action' => 'index'));
                $this->redirect(array('controller' => $model . 's', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('The factureclient could not be saved. Please, try again.'));
            }
        } else {
            $liste = '(0,' . $liste_in . ',0)';
            $entete = $this->$model_ans->find('first', array('fields' => array('fodec', 'pointdevente_id', 'depot_id', 'SUM(' . $model_ans . '.remise) remise', 'SUM(' . $model_ans . '.tva) tva', 'SUM(' . $model_ans . '.totalht) totalht'
                    , 'SUM(' . $model_ans . '.totalttc) totalttc', 'AVG(' . $model_ans . '.fournisseur_id) fournisseur_id'), 'conditions' => array($model_ans . '.id in ' . $liste), 'recursive' => -1));
//            debug($entete);die;
            $lignes = $this->$ligne_model_ans->find('all', array(
                'fields' => array('(' . $ligne_model_ans . '.qtebonus) qtebonus', '(' . $ligne_model_ans . '.fodec) fodec', '(' . $ligne_model_ans . '.prixdeventeht) prixdeventeht', '(' . $ligne_model_ans . '.marge) marge', '(' . $ligne_model_ans . '.article_id) article_id', '(' . $ligne_model_ans . '.article_id) article_iddd', '(' . $ligne_model_ans . '.id) id'
                    , '(' . $ligne_model_ans . '.quantite) quantite', '(' . $ligne_model_ans . '.remise) remise', '(' . $ligne_model_ans . '.prixhtva) prixhtva', '(' . $ligne_model_ans . '.prix) prix'
                    , '(' . $ligne_model_ans . '.tva) tva', '(' . $ligne_model_ans . '.totalht) totalht', '(' . $ligne_model_ans . '.totalttc)totalttc',
                    '(' . $ligne_model_ans . '.' . $attribut_ans . ')' . $attribut_ans, '(' . $ligne_model_ans . '.id)' . $ligne_model_ans . '_id')
                , 'conditions' => array($model_ans . '.id in' . $liste)
                , 'recursive' => 0
                , 'group' => array($ligne_model_ans . '.id', $ligne_model_ans . '.article_id')
                , 'order' => array($ligne_model_ans . '.' . $attribut_ans => 'ASC')));
            //debug($entete);
            //debug($lignes);die;
        }
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1, 'Fournisseur.societe' => $composantsoc)));
        $utilisateurs = $this->Utilisateur->find('list');
        $timbre = $this->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.id' => $p)));
        }
        $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numeroconca) as num'),
            'conditions' => array($model . '.exercice_id' => date("Y")))
        );
        //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        if (!empty($n)) {
//   $getexercice= $this->Facture->find('first',array('conditions'=>array('Facture.numeroconca'=>$n)));
//  $anne=$getexercice['Facture']['exercice_id'];  
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
        $this->set(compact('entete', 'attribut_ans', 'mm', 'fournisseurs', 'ligne_model_ans', 'model_ans', 'lignes', 'entete', 'ligne_model', 'model', 'typeclient_id', 'name', 'autorisation', 'solde', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'clients', 'utilisateurs', 'timbre', 'depots', 'date', 'lignefactureclients', 'articles', 'tabqtestock', 'mm', 'numspecial'));
    }

    public function imprimertrans($id = null) {


        $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factures') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefacture');
        if (!$this->Facture->exists($id)) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        $options = array('conditions' => array('Facture.' . $this->Facture->primaryKey => $id));
        $this->set('factureclient', $this->Facture->find('first', $options));
        $lignefactureclients = $this->Lignefacture->find('all', array(
            'conditions' => array('Lignefacture.facture_id' => $id, 'Lignefacture.bonreception_id > 0'), 'order' => array('Lignefacture.bonreception_id' => 'asc')
        ));
        $ligneavrs = $this->Lignefacture->find('all', array(
            'conditions' => array('Lignefacture.facture_id' => $id, 'Lignefacture.factureavoirfr_id > 0'), 'order' => array('Lignefacture.factureavoirfr_id' => 'asc')
        ));
        $lignefactureclientstva = $this->Lignefacture->find('all', array('fields' => array(
                'SUM(Lignefacture.totalht*Lignefacture.tva)/100  mtva'
                , 'SUM(Lignefacture.totalht) totalht'
                , 'AVG(Lignefacture.tva) tva'),
            'conditions' => array('Lignefacture.facture_id' => $id)
            , 'group' => array('Lignefacture.tva')
        ));
        //debug($lignefactureclients) ;
        // debug($lignefactureclientstva)  ;die;  
        $this->set(compact('lignefactureclients', 'lignefactureclientstva', 'ligneavrs'));
    }

    public function exp_etatexcel() {
        $this->layout = null;
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factures') {
                    $facture = $liens['imprimer'];
                }
            }
        }
        $this->loadModel('Exercice');
        $exercices = $this->Exercice->find('list');
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
//debug($this->request->query);die;
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Facture.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Facture.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Facture.fournisseur_id =' . $fournisseurid;
        }
        if ($this->request->query['utilisateurid']) {
            $utilisateurid = $this->request->query['utilisateurid'];
            $cond4 = 'Facture.utilisateur_id =' . $utilisateurid;
        }
        if ($this->request->query['typeid']) {
            $typeid = $this->request->query['typeid'];
            if ($typeid == 2) {
                $type = "service";
                $cond5 = 'Facture.type =' . "'" . $type . "'";
            } else {
                $type = "service";
                $cond5 = 'Facture.type <>' . "'" . $type . "'";
            }
        }
        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $cond6 = 'Facture.exercice_id =' . $exercices[$exerciceid];
        }
        $factures = $this->Facture->find('all', array('conditions' => array('Facture.id > ' => 0, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6)));

        $this->set(compact('factures', 'date1', 'date2', 'fournisseurid', 'utilisateurid'));
    }

    //*************************zeinab
    public function addfactureservice($model = null, $ligne_model = null, $attribut = null) {
        $attr = preg_replace("/_id/e", '"s"', $attribut);
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == $attr) {
                    $facture = $liens['add'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel($model);
        $this->loadModel($ligne_model);
        $this->loadModel('Tva');
        $this->loadModel('Timbre');
        $this->loadModel('Pointdevente');

        if ($this->request->is('post')) {

            $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numeroconca) as num'),
                'conditions' => array($model . '.pointdevente_id' => CakeSession::read('pointdevente'), $model . '.exercice_id' => date("Y")))
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
            $this->request->data[$model]['numeroconca'] = $mm;
            $this->request->data[$model]['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            $this->request->data[$model]['datefacture'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['datefacture'])));
            $this->request->data[$model]['datedeclaration'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['datedeclaration'])));
            $this->request->data[$model]['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data[$model]['pointdevente_id'])) {
                $this->request->data[$model]['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data[$model]['exercice_id'] = date("Y");
            $this->request->data[$model]['type'] = 'service';
			$this->request->data[$model]['nature'] = 'achat';
            if (empty($this->request->data[$model]['timbre_id'])) {
                $this->request->data[$model]['timbre_id'] = 0;
            }
//             debug($this->request->data);  die;
            $this->$model->create();
            if ($this->$model->save($this->request->data)) {
                $id = $this->$model->id;
                $this->misejour($model, "add", $id);
                foreach ($this->request->data['Lignefactureservice'] as $numl => $f) {
                    //debug($f);die;
                    if ((float) $f['mth'] > 0) {
                        $Lignes = array();
                        $Lignes[$attribut] = $id;
                        $Lignes['totalht'] = $f['mth'];
                        $Lignes['tva'] = $f['tauxtva'];
                        $Lignes['tttva'] = $f['mtva'];
                        $Lignes['totalttc'] = $f['mttc'];
                        $this->$ligne_model->create();
                        $this->$ligne_model->save($Lignes);
                    }
                }
                $this->Session->setFlash(__('The facture has been saved'));
                $this->redirect(array('controller' => $model . 's', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
            }
        }
        $composantsoc = CakeSession::read('composantsoc');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1, 'Fournisseur.societe' => $composantsoc)));
        $tvas = $this->Tva->find('all');
        $timbre = $this->Facture->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $this->set(compact('fournisseurs', 'tvas', 'timbre', 'model', 'pointdeventes'));
    }

    public function editfactureservice($id = null, $model = null, $ligne_model = null, $attribut = null) {
        $attr = preg_replace("/_id/e", '"s"', $attribut);
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == $attr) {
                    $facture = $liens['edit'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel($model);
        $this->loadModel($ligne_model);
        $this->loadModel('Tva');
        $this->loadModel('Timbre');
        $this->loadModel('Pointdevente');
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data[$model]['id'] = $id;
            if (empty($this->request->data[$model]['pointdevente_id'])) {
                $this->request->data[$model]['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data[$model]['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            $this->request->data[$model]['datefacture'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['datefacture'])));
            $this->request->data[$model]['datedeclaration'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['datedeclaration'])));
            if (empty($this->request->data[$model]['timbre_id'])) {
                $this->request->data[$model]['timbre_id'] = 0;
            }
//             debug($this->request->data);  die;
            $this->$model->create();
            if ($this->$model->save($this->request->data)) {
                $id = $this->$model->id;
                $this->misejour($model, "edit", $id);
                foreach ($this->request->data['Lignefactureservice'] as $numl => $f) {
                    //debug($f);die;
                    if ((float) $f['mth'] > 0) {
                        $Lignes = array();
                        $Lignes[$attribut] = $id;
                        $Lignes['id'] = $f['id'];
                        $Lignes['totalht'] = $f['mth'];
                        $Lignes['tva'] = $f['tauxtva'];
                        $Lignes['tttva'] = $f['mtva'];
                        $Lignes['totalttc'] = $f['mttc'];
                        $this->$ligne_model->create();
                        $this->$ligne_model->save($Lignes);
                    } else {
                        if ($f['id'] != '')
                            $this->$ligne_model->deleteAll(array($ligne_model . '.id' => $f['id']), false);
                    }
                }
                $this->Session->setFlash(__('The facture has been saved'));
                $this->redirect(array('controller' => $model . 's', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array($model . '.' . $this->$model->primaryKey => $id));
            $this->request->data = $this->$model->find('first', $options);
            //debug($this->request->data);
        }
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1, 'Fournisseur.societe' => $composantsoc)));
        $tvas = $this->Tva->find('all');
        $timbre = $this->Facture->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('fournisseurs', 'tvas', 'timbre', 'model', 'ligne_model', 'attribut', 'pointdeventes'));
    }

    public function viewfactureservice($id = null, $model = null, $ligne_model = null, $attribut = null) {
        $attr = preg_replace("/_id/e", '"s"', $attribut);
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == $attr) {
                    $facture = $liens['add'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel($model);
        $this->loadModel($ligne_model);
        $this->loadModel('Tva');
        $this->loadModel('Timbre');
        $this->loadModel('Pointdevente');

        $options = array('conditions' => array($model . '.' . $this->$model->primaryKey => $id));
        $this->request->data = $this->$model->find('first', $options);
        //debug($this->request->data);

        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1, 'Fournisseur.societe' => $composantsoc)));
        $tvas = $this->Tva->find('all');
        $timbre = $this->Facture->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('fournisseurs', 'tvas', 'timbre', 'model', 'ligne_model', 'attribut', 'pointdeventes'));
    }

    public function imprimerfactureservice($id = null, $model = null, $ligne_model = null, $attribut = null) {
        $attr = preg_replace("/_id/e", '"s"', $attribut);
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == $attr) {
                    $facture = $liens['add'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel($model);
        $this->loadModel($ligne_model);
        $this->loadModel('Tva');
        $this->loadModel('Timbre');
        $this->loadModel('Pointdevente');

        $options = array('conditions' => array($model . '.' . $this->$model->primaryKey => $id));
        $factureclient = $this->$model->find('first', $options);
        //debug($factureclient[$model]['pointdevente_id']);die;

        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1, 'Fournisseur.societe' => $composantsoc)));
        $tvas = $this->Tva->find('all');
        $timbre = $this->Facture->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('fournisseurs', 'tvas', 'timbre', 'model', 'ligne_model', 'attribut', 'pointdeventes', 'factureclient'));
    }

    public function transformationfactureservice($model = null, $ligne_model = null, $attribut = null, $liste_in = null, $model_ans = null, $ligne_model_ans = null, $attribut_ans = null) {
        $attr = preg_replace("/_id/e", '"s"', $attribut);
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == $attr) {
                    $facture = $liens['delete'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($model);
        $this->loadModel($ligne_model);
        $this->loadModel($model_ans);
        $this->loadModel($ligne_model_ans);
        $this->loadModel('Pointdevente');
        $this->loadModel('Timbre');
        $this->loadModel('Tva');
        $this->loadModel('Fournisseur');
        $this->loadModel('Utilisateur');

        if ($this->request->is('post') || $this->request->is('put')) {
//            debug($this->request->data);    die;
            $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numeroconca) as num'),
                'conditions' => array($model . '.exercice_id' => date("Y")))
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
            $this->request->data[$model]['numeroconca'] = $mm;
            $this->request->data[$model]['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            $this->request->data[$model]['datefacture'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['datefacture'])));
            $this->request->data[$model]['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data[$model]['pointdevente_id'])) {
                $this->request->data[$model]['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data[$model]['exercice_id'] = date("Y");
            $this->request->data[$model]['type'] = 'service';
            if (empty($this->request->data[$model]['timbre_id'])) {
                $this->request->data[$model]['timbre_id'] = 0;
            }

//            debug($this->request->data);   die;
            $this->$model->create();
            if ($this->$model->save($this->request->data)) {
                $id = $this->$model->id;
                $this->misejour($model, "add", $id);
                $liste = '(0,' . $liste_in . ',0)';
                $this->$model_ans->updateAll(array($model_ans . '.' . $attribut => $id), array($model_ans . '.id in ' . $liste));
                $Lignefactureclients = array();
                foreach ($this->request->data['Lignefactureservice'] as $numl => $f) {
                    if ((float) $f['mth'] > 0) {
                        $Lignefactureclients = array();
                        $Lignefactureclients[$attribut] = $id;
                        $Lignefactureclients['totalht'] = $f['mth'];
                        $Lignefactureclients['tva'] = $f['tauxtva'];
                        $Lignefactureclients['tttva'] = $f['mtva'];
                        $Lignefactureclients['totalttc'] = $f['mttc'];

                        $this->$ligne_model->create();
                        $this->$ligne_model->save($Lignefactureclients);
                    }
                }


                $this->Session->setFlash(__('The facture has been saved'));
                $this->redirect(array('controller' => $model . 's', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('The factureclient could not be saved. Please, try again.'));
            }
        } else {
            $liste = '(0,' . $liste_in . ',0)';
            $entete = $this->$model_ans->find('first', array('fields' => array('pointdevente_id', 'SUM(' . $model_ans . '.tva) tva', 'SUM(' . $model_ans . '.totalht) totalht'
                    , 'SUM(' . $model_ans . '.totalttc) totalttc', 'AVG(' . $model_ans . '.fournisseur_id) fournisseur_id'), 'conditions' => array($model_ans . '.id in ' . $liste), 'recursive' => -1));
        }
        $composantsoc = CakeSession::read('composantsoc');
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1, 'Fournisseur.societe' => $composantsoc)));
        $utilisateurs = $this->Utilisateur->find('list');
        $tvas = $this->Tva->find('all');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $timbre = $this->Facture->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $this->set(compact('pointdeventes', 'entete', 'liste', 'attribut_ans', 'mm', 'timbre', 'tvas', 'fournisseurs', 'ligne_model_ans', 'model_ans', 'lignes', 'entete', 'ligne_model', 'model', 'typeclient_id', 'name', 'autorisation', 'solde', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'clients', 'utilisateurs', 'timbre', 'depots', 'date', 'lignefactureclients', 'articles', 'tabqtestock', 'mm', 'numspecial'));
    }

    public function deletefactureservice($id = null, $model = null, $ligne_model = null, $attribut = null) {
        $attr = preg_replace("/_id/e", '"s"', $attribut);
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == $attr) {
                    $facture = $liens['delete'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($ligne_model);
        $this->loadModel('Bonreception');
        $this->loadModel('Commande');
        $this->$model->id = $id;
        if (!$this->$model->exists()) {
            throw new NotFoundException(__('Invalid' . $model));
        }
        $this->request->onlyAllow('post', 'delete');
        $abcd = $this->$model->find('first', array('conditions' => array($model . '.id' => $id), 'recursive' => -1));
        $numansar = $abcd[$model]['numero'];
        $this->Commande->updateAll(array('Commande.' . $attribut => 0), array('Commande.' . $attribut => $id));
        if ($model == 'Facture') {
            $this->Bonreception->updateAll(array('Bonreception.' . $attribut => 0), array('Bonreception.' . $attribut => $id));
        }
        if ($this->$model->delete()) {
//*****
            $this->$ligne_model->deleteAll(array($ligne_model . '.' . $attribut => $id), false);
//*****
            $this->misejour($model, $numansar, $id);
            $this->Session->setFlash(__($model . ' deleted'));
            CakeSession::write('view', "delete");
        }
        $this->Session->setFlash(__($model . ' was not deleted'));
        $this->redirect(array('controller' => $model . 's', 'action' => 'index'));
    }

    ///*********************************************************************
    public function numerofac() {
        $this->layout = null;
		$data = $this->request->data;
        $val = $data['val'];
        $tab = explode(' ', $val);
        $ch = "'";
        foreach ($tab as $tabb) {
            $ch = $ch . '%`' . $tabb . '`';
        }
        $ch .= "%'";
        $cond = "Facture.numero LIKE " . $ch;
        $numero = $this->Facture->find('all', array(
            'conditions' => array($cond),
            'recursive' => -1,
            'fields' => array('Facture.id', 'Facture.numero'),
            'group' => array('Facture.id'),
        ));
        echo json_encode(array('numero' => $numero)); // Tableau to JSON <> Json_Decode JOSN TO TABLE 
        die;
    }
    public function etatfacturesession() {
        CakeSession::delete('date1');
        CakeSession::delete('date2');
        CakeSession::delete('datedec1');
        CakeSession::delete('datedec2');
        CakeSession::delete('clientidfacture');
        CakeSession::delete('pointdeventeachat');
        //CakeSession::delete('pvfacture');
        //print_r($this->request->data);die;
        $date1 = $this->request->data['date1'];
        $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $date1)));
        $date2 = $this->request->data['date2'];
        $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $date2)));
        $datedec1 = $this->request->data['datedec1'];
        $datedec1 = date("Y-m-d", strtotime(str_replace('/', '-', $datedec1)));
        $datedec2 = $this->request->data['datedec2'];
        $datedec2 = date("Y-m-d", strtotime(str_replace('/', '-', $datedec2)));
        $clientidfacture = $this->request->data['clientidfacture'];
        $pointdeventeachat = $this->request->data['pointdeventeachat'];
        //$pvfacture = $this->request->data['pvfacture'];

        CakeSession::write('date1', $date1);
        CakeSession::write('date2', $date2);
        CakeSession::write('datedec1', $datedec1);
        CakeSession::write('datedec2', $datedec2);
        CakeSession::write('clientidfacture', $clientidfacture);
        CakeSession::write('pointdeventeachat', $pointdeventeachat);
        //CakeSession::write('pvfacture', $pvfacture);
        echo true;
        die;
    }

    public function etatfacture() {
        $this->loadModel('Fournisseur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Exercice');


        CakeSession::delete('date1');
        CakeSession::delete('date2');
        CakeSession::delete('datedec1');
        CakeSession::delete('datedec2');
        CakeSession::delete('clientidfacture');
        CakeSession::delete('anneefacture');
        CakeSession::delete('pointdeventeachat');

        $fournisseurs = $this->Fournisseur->find('list');
        $p = CakeSession::read('pointdevente');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];

        $types = array();
        $types['Exonore'] = "Exonoré";
        $types['Avoir'] = "Avoir";
        $types['Tout'] = "Tout";

        $this->set(compact('t', 'pointdeventeid', 'client_id', 'exercice_id', 'pointdeventes', 'clientid', 'date1', 'date2', 'fournisseurs', 'exercices', 'exerciceid', 'types'));
    }
     public function imprimerachat() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }       
        $this->loadModel('Lignefacture');
        //$this->loadModel('Lignefactureavoirfrs');
        $this->loadModel('Fournisseur');
        //$this->loadModel('Factureavoirfrs');
        $this->loadModel('Tva');

        $this->response->type('pdf');
        $this->layout = 'pdf';

        //debug($this->request->query);die;

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $datedec1 = CakeSession::read('datedec1');
        $datedec2 = CakeSession::read('datedec2');
        $clientidfacture = CakeSession::read('clientidfacture');
        $pointdeventeachat = CakeSession::read('pointdeventeachat');

        
        //die;
        //$pvfacture = CakeSession::read('pvfacture');


//        CakeSession::delete('date1');
//        CakeSession::delete('date2');
//        CakeSession::delete('datedec1');
//        CakeSession::delete('datedec2');
//        CakeSession::delete('clientidfacture');
//        CakeSession::delete('pointdeventeachat');
        //CakeSession::delete('pvfacture');
        //debug($date1); debug($date2); debug($clientidfacture); debug($anneefacture); debug($pvfacture);die;

        /*         * ************************************************************* */
        $tablignefactures = array();



        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Facture.date >= ' . "'" . $date1 . "'";
            //$conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            //$pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondf1 = ' and factures.date >= ' . "'" . $date1 . "'";
        }
        $condf2 = "";
        $conda2 = "";
        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Facture.date <= ' . "'" . $date2 . "'";
            //$conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondf2 = ' and factures.date <= ' . "'" . $date2 . "'";
            //$pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";
            
            
        }
        if ($datedec1 != "__/__/____" && $datedec1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condfdec1 = 'Facture.datedeclaration >= ' . "'" . $datedec1 . "'";
            //$conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            //$pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondfdec1 = ' and factures.datedeclaration >= ' . "'" . $datedec1 . "'";
        }
        
        if ($datedec2 != "__/__/____" && $datedec2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condfdec2 = 'Facture.datedeclaration <= ' . "'" . $datedec2 . "'";
            //$conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondfdec2 = ' and factures.datedeclaration <= ' . "'" . $datedec2 . "'";
            //$pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";
        }

        if ($clientidfacture != 0) {
            $clientid = $clientidfacture;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Facture.fournisseur_id =' . $clientid;
            //$conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf3 = ' and factures.fournisseur_id =' . $clientid;
            //$pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }
        if ($pointdeventeachat != 0) {
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf34 = 'Facture.pointdevente_id =' . $pointdeventeachat;
            //$conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf34 = ' and factures.pointdevente_id =' . $pointdeventeachat;
            //$pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }
        $condsource = "Facture.nature='achat'";
        $pcondsource = " and factures.nature='achat'";

        $condtype = "(Facture.type='direct' or Facture.type='trans_bl')";
        $pcondtype = " and (factures.type='direct' or factures.type='trans_bl')";


        $cp = 0;


        $tmps = $this->Facture->query(
                'SELECT tmp.tva
        FROM (
        (SELECT  lignefactures.tva
        FROM  lignefactures,factures
        where  factures.id=lignefactures.facture_id and lignefactures.tva!=0 
        ' . @$pcondf1 . @$pcondf2 .@$pcondfdec1 . @$pcondfdec2 . @$pcondf3 . @$pcondsource. @$pcondf34 . @$pcondtype . '
        group BY  lignefactures.tva
        )
        )tmp
        group BY tmp.tva desc');

        $tvas = array();
        foreach ($tmps as $i => $t) {
            $tvas[$i]['Tva']['name'] = $t['tmp']['tva'];
        }

        if ($tmps != array()) {
            sort($tvas); //debug($tvas);die;
        }
//**********************************************************************************************************        
        $lignefactureavoirs = $this->Facture->find('all', array(
            'conditions' => array(@$condf1, @$condf2,@$condfdec1, @$condfdec2, @$condf3, @$condsource,@$condf34,@$condtype), 'order' => array('Facture.date' => 'ASC'), 'contain' => array('Fournisseur', 'Timbre'), 'recursive' => 1));

           // debug($lignefactureavoirs);die;
        foreach ($lignefactureavoirs as $lignefactureavoir) {
            @$name = $lignefactureavoir['Fournisseur']['name'];
            @$adresse = $lignefactureavoir['Fournisseur']['adresse'];
            @$mat = $lignefactureavoir['Fournisseur']['matriculefiscale'];
            @$code = $lignefactureavoir['Fournisseur']['code'];
            $tablignefactures[$cp]['id_piece'] = $lignefactureavoir['Facture']['id'];
            $tablignefactures[$cp]['Fournisseur'] = $name;
            $tablignefactures[$cp]['adresse'] = @$adresse;
            $tablignefactures[$cp]['matriculefiscal'] = $mat;
            $tablignefactures[$cp]['code'] = $code;
            $tablignefactures[$cp]['date'] = $lignefactureavoir['Facture']['date'];
            $tablignefactures[$cp]['type'] = "Facture";
            $tablignefactures[$cp]['numero'] = $lignefactureavoir['Facture']['numero'];
            $tablignefactures[$cp]['numerofrs'] = $lignefactureavoir['Facture']['numerofrs'];
            $tablignefactures[$cp]['remise'] = $lignefactureavoir['Facture']['remise'];
            $tablignefactures[$cp]['fodec'] = $lignefactureavoir['Facture']['fodec'];
            $tablignefactures[$cp]['tva'] = $lignefactureavoir['Facture']['tva'];
            $tablignefactures[$cp]['totalht'] = $lignefactureavoir['Facture']['totalht'];
            $tablignefactures[$cp]['totalttc'] = $lignefactureavoir['Facture']['totalttc'];
            $tablignefactures[$cp]['timbre'] = $lignefactureavoir['Facture']['timbre_id'];


            $cp++;
        }
//******************************************************************************************************************************        


      //  $fournisseurs = $this->Fournisseur->find('list');
//        $pointdeventes = $this->Pointdevente->find('list');
//        $exercices = $this->Exercice->find('list');
//        $types = array();
//        $types['Exonore'] = "Exonoré";
//        $types['Avoir'] = "Avoir";
//        $types['Tout'] = "Tout";
        //debug($tablignefactures);die;*
        //$tvas = $this->Tva->find('all', array('recursive' => -1));
        //debug($lignefactureavoirs);die;
        $this->set(compact('exercices','pointdeventeachat', 'fournisseurs', 'date1', 'date2','datedec1', 'datedec2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function imprimerdepense() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }       
        $this->loadModel('Lignefacture');
        //$this->loadModel('Lignefactureavoirfrs');
        $this->loadModel('Fournisseur');
        //$this->loadModel('Factureavoirfrs');
        $this->loadModel('Tva');

        $this->response->type('pdf');
        $this->layout = 'pdf';

        //debug($this->request->query);die;

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $datedec1 = CakeSession::read('datedec1');
        $datedec2 = CakeSession::read('datedec2');
        $clientidfacture = CakeSession::read('clientidfacture');
        $pointdeventeachat = CakeSession::read('pointdeventeachat');
        //$pvfacture = CakeSession::read('pvfacture');


        CakeSession::delete('date1');
        CakeSession::delete('date2');
        CakeSession::delete('datedec1');
        CakeSession::delete('datedec2');
        CakeSession::delete('clientidfacture');
        CakeSession::delete('pointdeventeachat');
        //CakeSession::delete('pvfacture');
        //debug($date1); debug($date2); debug($clientidfacture); debug($anneefacture); debug($pvfacture);die;

        /*         * ************************************************************* */
        $tablignefactures = array();



        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Facture.date >= ' . "'" . $date1 . "'";
            //$conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            //$pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondf1 = ' and factures.date >= ' . "'" . $date1 . "'";
        }
        $condf2 = "";
        $conda2 = "";
        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Facture.date <= ' . "'" . $date2 . "'";
            //$conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondf2 = ' and factures.date <= ' . "'" . $date2 . "'";
            //$pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";
        }
        if ($datedec1 != "__/__/____" && $datedec1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condfdec1 = 'Facture.datedeclaration >= ' . "'" . $datedec1 . "'";
            //$conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            //$pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondfdec1 = ' and factures.datedeclaration >= ' . "'" . $datedec1 . "'";
        }
        
        if ($datedec2 != "__/__/____" && $datedec2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condfdec2 = 'Facture.datedeclaration <= ' . "'" . $datedec2 . "'";
            //$conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondfdec2 = ' and factures.datedeclaration <= ' . "'" . $datedec2 . "'";
            //$pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";
        }


        if ($clientidfacture != 0) {
            $clientid = $clientidfacture;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Facture.fournisseur_id =' . $clientid;
            //$conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf3 = ' and factures.fournisseur_id =' . $clientid;
            //$pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }
        if ($pointdeventeachat != 0) {
            //            $condb3 = 'Bonlivraison.client_id ='.$clientid;
                        $condf34 = 'Facture.pointdevente_id =' . $pointdeventeachat;
                        //$conda3 = 'Factureavoir.client_id =' . $clientid;
            
                        $pcondf34 = ' and factures.pointdevente_id =' . $pointdeventeachat;
                        //$pconda3 = ' and factureavoirs.client_id =' . $clientid;
                    }
        $condsource = "(Facture.nature='depense' or Facture.type='service')";
        $pcondsource = " and (factures.nature='depense' or factures.type='service')";
        $cp = 0;


        $tmps = $this->Facture->query(
                'SELECT tmp.tva
        FROM (
        (SELECT  lignefactures.tva
        FROM  lignefactures,factures
        where  factures.id=lignefactures.facture_id and lignefactures.tva!=0 
        ' . @$pcondf1 . @$pcondf2 . @$pcondfdec1 . @$pcondfdec2 . @$pcondf3 . @$pcondsource. @$pcondf34 . '
        group BY  lignefactures.tva
        )
        )tmp
        group BY tmp.tva desc');
//debug($tmps);die;
        $tvas = array();
        foreach ($tmps as $i => $t) {
            $tvas[$i]['Tva']['name'] = $t['tmp']['tva'];
        }

        if ($tmps != array()) {
            sort($tvas); //debug($tvas);die;
        }
//**********************************************************************************************************        
        $lignefactureavoirs = $this->Facture->find('all', array(
            'conditions' => array(@$condf1, @$condf2,@$condfdec1, @$condfdec2, @$condf3, @$condsource,@$condf34), 'order' => array('Facture.date' => 'ASC'), 'contain' => array('Fournisseur', 'Timbre'), 'recursive' => 1));

        foreach ($lignefactureavoirs as $lignefactureavoir) {
            @$name = $lignefactureavoir['Fournisseur']['name'];
            @$adresse = $lignefactureavoir['Fournisseur']['adresse'];
            @$mat = $lignefactureavoir['Fournisseur']['matriculefiscale'];
            @$code = $lignefactureavoir['Fournisseur']['code'];
            $tablignefactures[$cp]['id_piece'] = $lignefactureavoir['Facture']['id'];
            $tablignefactures[$cp]['Fournisseur'] = $name;
            $tablignefactures[$cp]['adresse'] = @$adresse;
            $tablignefactures[$cp]['matriculefiscal'] = $mat;
            $tablignefactures[$cp]['code'] = $code;
            $tablignefactures[$cp]['date'] = $lignefactureavoir['Facture']['date'];
            $tablignefactures[$cp]['type'] = "Facture";
            $tablignefactures[$cp]['numero'] = $lignefactureavoir['Facture']['numero'];
            $tablignefactures[$cp]['numerofrs'] = $lignefactureavoir['Facture']['numerofrs'];
            $tablignefactures[$cp]['remise'] = $lignefactureavoir['Facture']['remise'];
            $tablignefactures[$cp]['fodec'] = $lignefactureavoir['Facture']['fodec'];
            $tablignefactures[$cp]['tva'] = $lignefactureavoir['Facture']['tva'];
            $tablignefactures[$cp]['totalht'] = $lignefactureavoir['Facture']['totalht'];
            $tablignefactures[$cp]['totalttc'] = $lignefactureavoir['Facture']['totalttc'];
            $tablignefactures[$cp]['timbre'] = $lignefactureavoir['Facture']['timbre_id'];


            $cp++;
        }
//******************************************************************************************************************************        


        //$fournisseurs = $this->Fournisseur->find('list');
//        $pointdeventes = $this->Pointdevente->find('list');
//        $exercices = $this->Exercice->find('list');
//        $types = array();
//        $types['Exonore'] = "Exonoré";
//        $types['Avoir'] = "Avoir";
//        $types['Tout'] = "Tout";
        //debug($tablignefactures);die;*
        //$tvas = $this->Tva->find('all', array('recursive' => -1));

        $this->set(compact('exercices','pointdeventeachat', 'fournisseurs', 'date1', 'date2','datedec1', 'datedec2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function imprimeravoir() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }       
        $this->loadModel('Factureavoirfr');
        $this->loadModel('Lignefactureavoirfrs');
        $this->loadModel('Fournisseur');
        $this->loadModel('Factureavoirfrs');
        $this->loadModel('Tva');

        $this->response->type('pdf');
        $this->layout = 'pdf';

        //debug($this->request->query);die;

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $datedec1 = CakeSession::read('datedec1');
        $datedec2 = CakeSession::read('datedec2');
        $clientidfacture = CakeSession::read('clientidfacture');
        $pointdeventeachat = CakeSession::read('pointdeventeachat');
        //$pvfacture = CakeSession::read('pvfacture');


//        CakeSession::delete('date1');
//        CakeSession::delete('date2');
//        CakeSession::delete('datedec1');
//        CakeSession::delete('datedec2');
//        CakeSession::delete('clientidfacture');
//        CakeSession::delete('pointdeventeachat');
        //CakeSession::delete('pvfacture');
        //debug($date1); debug($date2); debug($clientidfacture); debug($anneefacture); debug($pvfacture);die;

        /*         * ************************************************************* */
        $tablignefactures = array();



        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureavoirfr.date >= ' . "'" . $date1 . "'";
            //$conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            //$pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondf1 = ' and factureavoirfrs.date >= ' . "'" . $date1 . "'";
        }
        $condf2 = "";
        $conda2 = "";
        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureavoirfr.date <= ' . "'" . $date2 . "'";
            //$conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondf2 = ' and factureavoirfrs.date <= ' . "'" . $date2 . "'";
            //$pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";
        }
        if ($datedec1 != "__/__/____" && $datedec1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condfdec1 = 'Factureavoirfr.datedeclaration >= ' . "'" . $datedec1 . "'";
            //$conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            //$pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondfdec1 = ' and factureavoirfrs.datedeclaration >= ' . "'" . $datedec1 . "'";
        }
        
        if ($datedec2 != "__/__/____" && $datedec2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condfdec2 = 'Factureavoirfr.datedeclaration <= ' . "'" . $datedec2 . "'";
            //$conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondfdec2 = ' and factureavoirfrs.datedeclaration <= ' . "'" . $datedec2 . "'";
            //$pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";
        }

        if ($clientidfacture != 0) {
            $clientid = $clientidfacture;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureavoirfr.fournisseur_id =' . $clientid;
            //$conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf3 = ' and factureavoirfrs.fournisseur_id =' . $clientid;
            //$pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }
        if ($pointdeventeachat != 0) {
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf34 = 'Factureavoirfr.pointdevente_id =' . $pointdeventeachat;
            //$conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf34 = ' and factureavoirfrs.pointdevente_id =' . $pointdeventeachat;
            //$pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }
        $condsource = "";
        $pcondsource = "";
        $cp = 0;


        $tmps = $this->Factureavoirfr->query(
                'SELECT tmp.tva
        FROM (
        (SELECT  lignefactureavoirfrs.tva
        FROM  lignefactureavoirfrs,factureavoirfrs
        where  factureavoirfrs.id=lignefactureavoirfrs.factureavoirfr_id and lignefactureavoirfrs.tva!=0 
        ' . @$pcondf1 . @$pcondf2.@$pcondfdec1 . @$pcondfdec2  . @$pcondf3 . @$pcondsource. @$pcondf34 . '
        group BY  lignefactureavoirfrs.tva
        )
        )tmp
        group BY tmp.tva desc');

        $tvas = array();
        foreach ($tmps as $i => $t) {
            $tvas[$i]['Tva']['name'] = $t['tmp']['tva'];
        }

        if ($tmps != array()) {
            sort($tvas); //debug($tvas);die;
        }
//**********************************************************************************************************        
        $lignefactureavoirs = $this->Factureavoirfr->find('all', array(
            'conditions' => array(@$condf1, @$condf2,@$condfdec1, @$condfdec2, @$condf3, @$condsource, @$condf34), 'order' => array('Factureavoirfr.date' => 'ASC'), 'contain' => array('Fournisseur', 'Timbre'), 'recursive' => 1));

        foreach ($lignefactureavoirs as $lignefactureavoir) { //debug($lignefactureavoirs);die;
            @$name = $lignefactureavoir['Fournisseur']['name'];
            @$adresse = $lignefactureavoir['Fournisseur']['adresse'];
            @$mat = $lignefactureavoir['Fournisseur']['matriculefiscale'];
            @$code = $lignefactureavoir['Fournisseur']['code'];
            $tablignefactures[$cp]['id_piece'] = $lignefactureavoir['Factureavoirfr']['id'];
            $tablignefactures[$cp]['Fournisseur'] = $name;
            $tablignefactures[$cp]['adresse'] = @$adresse;
            $tablignefactures[$cp]['matriculefiscal'] = $mat;
            $tablignefactures[$cp]['code'] = $code;
            $tablignefactures[$cp]['date'] = $lignefactureavoir['Factureavoirfr']['date'];
            $tablignefactures[$cp]['type'] = "Factureavoirfr";
            $tablignefactures[$cp]['numero'] = $lignefactureavoir['Factureavoirfr']['numero'];
            $tablignefactures[$cp]['numerofrs'] = ''; //$lignefactureavoir['Factureavoirfr']['numerofrs'];
            $tablignefactures[$cp]['remise'] = $lignefactureavoir['Factureavoirfr']['remise'];
            $tablignefactures[$cp]['fodec'] = $lignefactureavoir['Factureavoirfr']['fodec'];
            $tablignefactures[$cp]['tva'] = $lignefactureavoir['Factureavoirfr']['tva'];
            $tablignefactures[$cp]['totalht'] = $lignefactureavoir['Factureavoirfr']['totalht'];
            $tablignefactures[$cp]['totalttc'] = $lignefactureavoir['Factureavoirfr']['totalttc'];
            $tablignefactures[$cp]['timbre'] = $lignefactureavoir['Factureavoirfr']['timbre_id'];


            $cp++;
        }
//******************************************************************************************************************************        


        //$fournisseurs = $this->Fournisseur->find('list');
//        $pointdeventes = $this->Pointdevente->find('list');
//        $exercices = $this->Exercice->find('list');
//        $types = array();
//        $types['Exonore'] = "Exonoré";
//        $types['Avoir'] = "Avoir";
//        $types['Tout'] = "Tout";
        //debug($tablignefactures);die;*
        //$tvas = $this->Tva->find('all', array('recursive' => -1));

        $this->set(compact('pointdeventeachat','exercices', 'fournisseurs', 'date1', 'date2','datedec1', 'datedec2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function etatdetail() {
        $this->loadModel('Fournisseur');
        $this->loadModel('Paiement');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');




        CakeSession::delete('datedebutimpaye');
        CakeSession::delete('datefinimpaye');
        CakeSession::delete('reglementimpaye');
        CakeSession::delete('fournisseurimpaye');
        CakeSession::delete('triageimpaye');
        CakeSession::delete('venteimpaye');


        $fournisseurs = $this->Fournisseur->find('list');

        $triages = array();
        $triages['Parnumfacture'] = "Par N° Facture";
        $triages['Pardate'] = "Par date";
        $triages['Parcodeclient'] = "Par code fournisseur";

        $reglements = array();
        $reglements['Tous'] = "Tous";
        $reglements['Regle'] = "Regle";
        $reglements['Nonregle'] = "Non regle";

        $ventes = array();
        $ventes['Tous'] = "Tous";
        $ventes['Regle'] = "BLF";
        $ventes['Nonregle'] = "Facture";

        //$exercices=$this->Exercice->find('list');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));

        $this->set(compact('t', 'exercices', 'fournisseurs', 'ventes', 'exerciceid', 'reglements', 'triages', 'encaissements', 'paiements', 'zones', 'pointdeventeid', 'client_id', 'exercice_id', 'pointdeventes', 'clientid', 'date1', 'date2', 'clients', 'exercices', 'exerciceid', 'types'));
    }

    public function etatimpayesession() {
        CakeSession::delete('datedebutimpaye');
        CakeSession::delete('datefinimpaye');
        CakeSession::delete('reglementimpaye');
        CakeSession::delete('fournisseurimpaye');
        CakeSession::delete('triageimpaye');
        CakeSession::delete('venteimpaye');
        CakeSession::delete('pointdeventeachat');
        //print_r($this->request->data);die;
        $datedebutimpaye = $this->request->data['datedebutimpaye'];
        $datedebutimpaye = date("Y-m-d", strtotime(str_replace('/', '-', $datedebutimpaye)));
        $datefinimpaye = $this->request->data['datefinimpaye'];
        $datefinimpaye = date("Y-m-d", strtotime(str_replace('/', '-', $datefinimpaye)));


        $reglementimpaye = $this->request->data['reglementimpaye'];
        $fournisseurimpaye = $this->request->data['fournisseurimpaye'];
        $triageimpaye = $this->request->data['triageimpaye'];
        $venteimpaye = $this->request->data['venteimpaye'];
        $pointdeventeachat = $this->request->data['pointdeventeachat'];

        CakeSession::write('datedebutimpaye', $datedebutimpaye);
        CakeSession::write('datefinimpaye', $datefinimpaye);
        CakeSession::write('reglementimpaye', $reglementimpaye);
        CakeSession::write('fournisseurimpaye', $fournisseurimpaye);
        CakeSession::write('triageimpaye', $triageimpaye);
        CakeSession::write('venteimpaye', $venteimpaye);
        CakeSession::write('pointdeventeachat', $pointdeventeachat);
        echo true;
        die;
    }

    public function imprimeravecdetailsfactureachat() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));

        $this->loadModel('Exercice');
        $this->loadModel('Client');
        $this->loadModel('Paiement');

        $this->response->type('pdf');
        $this->layout = 'pdf';

        //debug($this->request->query);die;

        $datedebutimpaye = CakeSession::read('datedebutimpaye');
        $datefinimpaye = CakeSession::read('datefinimpaye');
        $reglementimpaye = CakeSession::read('reglementimpaye');
        $triageimpaye = CakeSession::read('triageimpaye');
        $fournisseurimpaye = CakeSession::read('fournisseurimpaye');
        $venteimpaye = CakeSession::read('venteimpaye');
        $pointdeventeachat = CakeSession::read('pointdeventeachat');



        //debug($datereglement1);die;;
        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();


        //debug($datedebutimpaye);
        //debug($datefinimpaye);die;
        if ($datedebutimpaye != "__/__/____" && $datedebutimpaye != "1970-01-01" && $datedebutimpaye != NULL) {
            $conddateimpaye = 'Facture.date >= ' . "'" . $datedebutimpaye . "'";
        }
        if ($datefinimpaye != "__/__/____" && $datefinimpaye != "1970-01-01" && $datefinimpaye != NULL) {
            $conddateimpaye1 = 'Facture.date <= ' . "'" . $datefinimpaye . "'";
        }

        if (isset($fournisseurimpaye) && $fournisseurimpaye != 0) {
            $condb4 = 'Facture.fournisseur_id =' . $fournisseurimpaye;
        }


        if (isset($reglementimpaye)) {
            $reg = $reglementimpaye;
        }

        if (isset($triageimpaye)) {
            if ($triageimpaye == "Parnumfacture") {
                $ordre = 'Facture.numero ASC';
            }
            if ($triageimpaye == "Pardate") {
                $ordre = 'Facture.date ASC';
            }
            if ($triageimpaye == "Parcodeclient") {
                $ordre = 'Facture.fournisseur_id Asc';
            }
        }
        if ($pointdeventeachat != 0) {
                        $pvf = 'Facture.pointdevente_id = ' . $pointdeventeachat;
                    }
        $cp = 0;

        //debug($conddatereg);debug($condannee);die;
//******************************************************************************************************************************        

        $lignefactures = $this->Facture->find('all', array(
            'conditions' => array(@$conddateimpaye, @$conddateimpaye1, @$condb4,@$pvf, "Facture.nature='achat'"), 'order' => @$ordre, 'recursive' => -1));
        //debug($lignefactures);die;

        $this->set(compact('reg', 'lignefactures', 'datedebutimpaye', 'datefinimpaye', 'exerciceid'));
    }

    public function imprimeravecdetailsfactureavoir() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));

        $this->loadModel('Exercice');
        $this->loadModel('Client');
        $this->loadModel('Paiement');
        $this->loadModel('Factureavoirfr');

        //$this->response->type('pdf');
        //$this->layout = 'pdf';

        //debug($this->request->query);die;

        $datedebutimpaye = CakeSession::read('datedebutimpaye');
        $datefinimpaye = CakeSession::read('datefinimpaye');
        $reglementimpaye = CakeSession::read('reglementimpaye');
        $triageimpaye = CakeSession::read('triageimpaye');
        $fournisseurimpaye = CakeSession::read('fournisseurimpaye');
        $venteimpaye = CakeSession::read('venteimpaye');
        $pointdeventeachat = CakeSession::read('pointdeventeachat');



        //debug($datereglement1);die;;
        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();


        //debug($datedebutimpaye);die;
        if ($datedebutimpaye != "__/__/____" && $datedebutimpaye != "1970-01-01" && $datedebutimpaye != NULL) {
            $conddateimpaye = 'Factureavoirfr.date >= ' . "'" . $datedebutimpaye . "'";
        }
        if ($datefinimpaye != "__/__/____" && $datefinimpaye != "1970-01-01" && $datefinimpaye != NULL) {
            $conddateimpaye1 = 'Factureavoirfr.date <= ' . "'" . $datefinimpaye . "'";
        }

        if (isset($fournisseurimpaye) && $fournisseurimpaye != 0) {
            $condb4 = 'Factureavoirfr.fournisseur_id =' . $fournisseurimpaye;
        }


        if (isset($reglementimpaye)) {
            $reg = $reglementimpaye;
        }

        if (isset($triageimpaye)) {
            if ($triageimpaye == "Parnumfacture") {
                $ordre = 'Factureavoirfr.numero ASC';
            }
            if ($triageimpaye == "Pardate") {
                $ordre = 'Factureavoirfr.date ASC';
            }
            if ($triageimpaye == "Parcodeclient") {
                $ordre = 'Fournisseur.code Asc';
            }
        }
        if ($pointdeventeachat != 0) {
            $pvf = 'Factureavoirfr.pointdevente_id = ' . $pointdeventeachat;
        }
        $cp = 0;

        //debug($conddatereg);debug($condannee);die;
//******************************************************************************************************************************        

        $lignefactures = $this->Factureavoirfr->find('all', array(
            'conditions' => array(@$conddateimpaye, @$conddateimpaye1, @$condb4,@$pvf), 'order' => @$ordre, 'recursive' => 0));
//debug($lignefactures);die;

        $this->set(compact('reg', 'lignefactures', 'datedebutimpaye', 'datefinimpaye', 'exerciceid'));
    }

    public function exportlisteachat() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }       
        $this->loadModel('Lignefacture');
        //$this->loadModel('Lignefactureavoirfrs');
        $this->loadModel('Fournisseur');
        //$this->loadModel('Factureavoirfrs');
        $this->loadModel('Tva');

        $this->layout = NULL;
        //debug($this->request->query);die;

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $datedec1 = CakeSession::read('datedec1');
        $datedec2 = CakeSession::read('datedec2');
        $clientidfacture = CakeSession::read('clientidfacture');
        $pointdeventeachat = CakeSession::read('pointdeventeachat');
        //$pvfacture = CakeSession::read('pvfacture');



        CakeSession::delete('date1');
        CakeSession::delete('date2');
        CakeSession::delete('datedec1');
        CakeSession::delete('datedec2');
        CakeSession::delete('clientidfacture');
        CakeSession::delete('pointdeventeachat');
        //CakeSession::delete('pvfacture');
        //debug($date1); debug($date2); debug($clientidfacture); die;

        /*         * ************************************************************* */
        $tablignefactures = array();



        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Facture.date >= ' . "'" . $date1 . "'";
            //$conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            //$pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondf1 = ' and factures.date >= ' . "'" . $date1 . "'";
        }
        $condf2 = "";
        $conda2 = "";
        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Facture.date <= ' . "'" . $date2 . "'";
            //$conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondf2 = ' and factures.date <= ' . "'" . $date2 . "'";
            //$pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";
        }
        if ($datedec1 != "__/__/____" && $datedec1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condfdec1 = 'Facture.datedeclaration >= ' . "'" . $datedec1 . "'";
            //$conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            //$pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondfdec1 = ' and factures.datedeclaration >= ' . "'" . $datedec1 . "'";
        }
        
        if ($datedec2 != "__/__/____" && $datedec2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condfdec2 = 'Facture.datedeclaration <= ' . "'" . $datedec2 . "'";
            //$conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondfdec2 = ' and factures.datedeclaration <= ' . "'" . $datedec2 . "'";
            //$pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";
        }

        if ($clientidfacture != 0) {
            $clientid = $clientidfacture;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Facture.fournisseur_id =' . $clientid;
            //$conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf3 = ' and factures.fournisseur_id =' . $clientid;
            //$pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }
        if ($pointdeventeachat != 0) {
            //            $condb3 = 'Bonlivraison.client_id ='.$clientid;
                        $condf34 = 'Facture.pointdevente_id =' . $pointdeventeachat;
                        //$conda3 = 'Factureavoir.client_id =' . $clientid;
            
                        $pcondf34 = ' and factures.pointdevente_id =' . $pointdeventeachat;
                        //$pconda3 = ' and factureavoirs.client_id =' . $clientid;
                    }
                    $condsource = "Facture.nature='achat'";
                    $pcondsource = " and factures.nature='achat'";
            
                    $condtype = "(Facture.type='direct' or Facture.type='trans_bl')";
                    $pcondtype = " and (factures.type='direct' or factures.type='trans_bl')";
        $cp = 0;


        $tmps = $this->Facture->query(
                'SELECT tmp.tva
        FROM (
        (SELECT  lignefactures.tva
        FROM  lignefactures,factures
        where  factures.id=lignefactures.facture_id and lignefactures.tva!=0 
        ' . @$pcondf1 . @$pcondf2 .@$pcondfdec1 . @$pcondfdec2 . @$pcondf3 . @$pcondsource. @$pcondf34 . @$pcondtype . '
        group BY  lignefactures.tva
        )
        )tmp
        group BY tmp.tva desc');

        $tvas = array();
        foreach ($tmps as $i => $t) {
            $tvas[$i]['Tva']['name'] = $t['tmp']['tva'];
        }

        if ($tmps != array()) {
            sort($tvas); //debug($tvas);die;
        }
//**********************************************************************************************************        
        $lignefactureavoirs = $this->Facture->find('all', array(
            'conditions' => array(@$condf1, @$condf2,@$condfdec1, @$condfdec2, @$condf3, @$condsource, @$condf34, @$condtype), 'order' => array('Facture.date' => 'ASC'), 'contain' => array('Fournisseur', 'Timbre'), 'recursive' => 1));

        foreach ($lignefactureavoirs as $lignefactureavoir) {
            @$name = $lignefactureavoir['Fournisseur']['name'];
            @$adresse = $lignefactureavoir['Fournisseur']['adresse'];
            @$mat = $lignefactureavoir['Fournisseur']['matriculefiscale'];
            @$code = $lignefactureavoir['Fournisseur']['code'];
            $tablignefactures[$cp]['id_piece'] = $lignefactureavoir['Facture']['id'];
            $tablignefactures[$cp]['Fournisseur'] = $name;
            $tablignefactures[$cp]['adresse'] = @$adresse;
            $tablignefactures[$cp]['matriculefiscal'] = $mat;
            $tablignefactures[$cp]['code'] = $code;
            $tablignefactures[$cp]['date'] = $lignefactureavoir['Facture']['date'];
            $tablignefactures[$cp]['type'] = "Facture";
            $tablignefactures[$cp]['numero'] = $lignefactureavoir['Facture']['numero'];
            $tablignefactures[$cp]['numerofrs'] = $lignefactureavoir['Facture']['numerofrs'];
            $tablignefactures[$cp]['remise'] = $lignefactureavoir['Facture']['remise'];
            $tablignefactures[$cp]['fodec'] = $lignefactureavoir['Facture']['fodec'];
            $tablignefactures[$cp]['tva'] = $lignefactureavoir['Facture']['tva'];
            $tablignefactures[$cp]['totalht'] = $lignefactureavoir['Facture']['totalht'];
            $tablignefactures[$cp]['totalttc'] = $lignefactureavoir['Facture']['totalttc'];
            $tablignefactures[$cp]['timbre'] = $lignefactureavoir['Facture']['timbre_id'];


            $cp++;
        }
//******************************************************************************************************************************        


       // $fournisseurs = $this->Fournisseur->find('list');
//        $pointdeventes = $this->Pointdevente->find('list');
//        $exercices = $this->Exercice->find('list');
//        $types = array();
//        $types['Exonore'] = "Exonoré";
//        $types['Avoir'] = "Avoir";
//        $types['Tout'] = "Tout";
        //debug($tablignefactures);die;
        //$tvas = $this->Tva->find('all', array('recursive' => -1));

        $this->set(compact('exercices', 'fournisseurs', 'date1', 'date2', 'datedec1', 'datedec2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function exportlistedepense() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }       
        $this->loadModel('Lignefacture');
        //$this->loadModel('Lignefactureavoirfrs');
        $this->loadModel('Fournisseur');
        //$this->loadModel('Factureavoirfrs');
        $this->loadModel('Tva');

        $this->layout = NULL;

        //debug($this->request->query);die;

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $datedec1 = CakeSession::read('datedec1');
        $datedec2 = CakeSession::read('datedec2');
        $clientidfacture = CakeSession::read('clientidfacture');
        $pointdeventeachat = CakeSession::read('pointdeventeachat');
        //$pvfacture = CakeSession::read('pvfacture');


        CakeSession::delete('date1');
        CakeSession::delete('date2');
        CakeSession::delete('datedec1');
        CakeSession::delete('datedec2');
        CakeSession::delete('clientidfacture');
        CakeSession::delete('pointdeventeachat');
        //CakeSession::delete('pvfacture');
        //debug($date1); debug($date2); debug($clientidfacture); debug($anneefacture); debug($pvfacture);die;

        /*         * ************************************************************* */
        $tablignefactures = array();



        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Facture.date >= ' . "'" . $date1 . "'";
            //$conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            //$pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondf1 = ' and factures.date >= ' . "'" . $date1 . "'";
        }
        $condf2 = "";
        $conda2 = "";
        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Facture.date <= ' . "'" . $date2 . "'";
            //$conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondf2 = ' and factures.date <= ' . "'" . $date2 . "'";
            //$pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";
        }
        if ($datedec1 != "__/__/____" && $datedec1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condfdec1 = 'Facture.datedeclaration >= ' . "'" . $datedec1 . "'";
            //$conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            //$pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondfdec1 = ' and factures.datedeclaration >= ' . "'" . $datedec1 . "'";
        }
       
        if ($datedec2 != "__/__/____" && $datedec2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condfdec2 = 'Facture.datedeclaration <= ' . "'" . $datedec2 . "'";
            //$conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondfdec2 = ' and factures.datedeclaration <= ' . "'" . $datedec2 . "'";
            //$pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";
        }

        if ($clientidfacture != 0) {
            $clientid = $clientidfacture;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Facture.fournisseur_id =' . $clientid;
            //$conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf3 = ' and factures.fournisseur_id =' . $clientid;
            //$pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }
        if ($pointdeventeachat != 0) {
            //            $condb3 = 'Bonlivraison.client_id ='.$clientid;
                        $condf34 = 'Facture.pointdevente_id =' . $pointdeventeachat;
                        //$conda3 = 'Factureavoir.client_id =' . $clientid;
            
                        $pcondf34 = ' and factures.pointdevente_id =' . $pointdeventeachat;
                        //$pconda3 = ' and factureavoirs.client_id =' . $clientid;
                    }
        $condsource = "(Facture.nature='depense' or Facture.type='service')";
        $pcondsource = " and (factures.nature='depense' or factures.type='service')";
        $cp = 0;


        $tmps = $this->Facture->query(
                'SELECT tmp.tva
        FROM (
        (SELECT  lignefactures.tva
        FROM  lignefactures,factures
        where  factures.id=lignefactures.facture_id and lignefactures.tva!=0 
        ' . @$pcondf1 . @$pcondf2.@$pcondfdec1 . @$pcondfdec2 . @$pcondf3 . @$pcondsource. @$pcondf34 . '
        group BY  lignefactures.tva
        )
        )tmp
        group BY tmp.tva desc');
//debug($tmps);die;
        $tvas = array();
        foreach ($tmps as $i => $t) {
            $tvas[$i]['Tva']['name'] = $t['tmp']['tva'];
        }

        if ($tmps != array()) {
            sort($tvas); //debug($tvas);die;
        }
//**********************************************************************************************************        
        $lignefactureavoirs = $this->Facture->find('all', array(
            'conditions' => array(@$condf1, @$condf2,@$condfdec1, @$condfdec2, @$condf3, @$condsource,@$condf34), 'order' => array('Facture.date' => 'ASC'), 'contain' => array('Fournisseur', 'Timbre'), 'recursive' => 1));

        foreach ($lignefactureavoirs as $lignefactureavoir) {
            @$name = $lignefactureavoir['Fournisseur']['name'];
            @$adresse = $lignefactureavoir['Fournisseur']['adresse'];
            @$mat = $lignefactureavoir['Fournisseur']['matriculefiscale'];
            @$code = $lignefactureavoir['Fournisseur']['code'];
            $tablignefactures[$cp]['id_piece'] = $lignefactureavoir['Facture']['id'];
            $tablignefactures[$cp]['Fournisseur'] = $name;
            $tablignefactures[$cp]['adresse'] = @$adresse;
            $tablignefactures[$cp]['matriculefiscal'] = $mat;
            $tablignefactures[$cp]['code'] = $code;
            $tablignefactures[$cp]['date'] = $lignefactureavoir['Facture']['date'];
            $tablignefactures[$cp]['type'] = "Facture";
            $tablignefactures[$cp]['numero'] = $lignefactureavoir['Facture']['numero'];
            $tablignefactures[$cp]['numerofrs'] = $lignefactureavoir['Facture']['numerofrs'];
            $tablignefactures[$cp]['remise'] = $lignefactureavoir['Facture']['remise'];
            $tablignefactures[$cp]['fodec'] = $lignefactureavoir['Facture']['fodec'];
            $tablignefactures[$cp]['tva'] = $lignefactureavoir['Facture']['tva'];
            $tablignefactures[$cp]['totalht'] = $lignefactureavoir['Facture']['totalht'];
            $tablignefactures[$cp]['totalttc'] = $lignefactureavoir['Facture']['totalttc'];
            $tablignefactures[$cp]['timbre'] = $lignefactureavoir['Facture']['timbre_id'];


            $cp++;
        }
//******************************************************************************************************************************        


        //$fournisseurs = $this->Fournisseur->find('list');
//        $pointdeventes = $this->Pointdevente->find('list');
//        $exercices = $this->Exercice->find('list');
//        $types = array();
//        $types['Exonore'] = "Exonoré";
//        $types['Avoir'] = "Avoir";
//        $types['Tout'] = "Tout";
        //debug($tablignefactures);die;*
        //$tvas = $this->Tva->find('all', array('recursive' => -1));

        $this->set(compact('exercices', 'fournisseurs', 'date1', 'date2','datedec1', 'datedec2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function exportlisteavoir() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }       
        $this->loadModel('Factureavoirfr');
        $this->loadModel('Lignefactureavoirfrs');
        $this->loadModel('Fournisseur');
        $this->loadModel('Factureavoirfrs');
        $this->loadModel('Tva');

        $this->layout = NULL;

        //debug($this->request->query);die;

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $datedec1 = CakeSession::read('datedec1');
        $datedec2 = CakeSession::read('datedec2');
        $clientidfacture = CakeSession::read('clientidfacture');
        $pointdeventeachat = CakeSession::read('pointdeventeachat');
        //$pvfacture = CakeSession::read('pvfacture');


        CakeSession::delete('date1');
        CakeSession::delete('date2');
        CakeSession::delete('datedec1');
        CakeSession::delete('datedec2');
        CakeSession::delete('clientidfacture');
        CakeSession::delete('pointdeventeachat');
        //CakeSession::delete('pvfacture');
        //debug($date1); debug($date2); debug($clientidfacture); debug($anneefacture); debug($pvfacture);die;

        /*         * ************************************************************* */
        $tablignefactures = array();



        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureavoirfr.date >= ' . "'" . $date1 . "'";
            //$conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            //$pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondf1 = ' and factureavoirfrs.date >= ' . "'" . $date1 . "'";
        }
        $condf2 = "";
        $conda2 = "";
        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureavoirfr.date <= ' . "'" . $date2 . "'";
            //$conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondf2 = ' and factureavoirfrs.date <= ' . "'" . $date2 . "'";
            //$pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";
        }
        if ($datedec1 != "__/__/____" && $datedec1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condfdec1 = 'Factureavoirfr.datedeclaration >= ' . "'" . $datedec1 . "'";
            //$conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            //$pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondfdec1 = ' and factureavoirfrs.datedeclaration >= ' . "'" . $datedec1 . "'";
        }
        
        if ($datedec2 != "__/__/____" && $datedec2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condfdec2 = 'Factureavoirfr.datedeclaration <= ' . "'" . $datedec2 . "'";
            //$conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondfdec2 = ' and factureavoirfrs.datedeclaration <= ' . "'" . $datedec2 . "'";
            //$pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";
        }

        if ($clientidfacture != 0) {
            $clientid = $clientidfacture;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureavoirfr.fournisseur_id =' . $clientid;
            //$conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf3 = ' and factureavoirfrs.fournisseur_id =' . $clientid;
            //$pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }
        if ($pointdeventeachat != 0) {
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf34 = 'Factureavoirfr.pointdevente_id =' . $pointdeventeachat;
            //$conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf34 = ' and factureavoirfrs.pointdevente_id =' . $pointdeventeachat;
            //$pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }
        $condsource = "";
        $pcondsource = "";
        $cp = 0;


        $tmps = $this->Factureavoirfr->query(
                'SELECT tmp.tva
        FROM (
        (SELECT  lignefactureavoirfrs.tva
        FROM  lignefactureavoirfrs,factureavoirfrs
        where  factureavoirfrs.id=lignefactureavoirfrs.factureavoirfr_id and lignefactureavoirfrs.tva!=0 
        ' . @$pcondf1 . @$pcondf2 .@$pcondfdec1 . @$pcondfdec2. @$pcondf3 . @$pcondsource. @$pcondf34 . '
        group BY  lignefactureavoirfrs.tva
        )
        )tmp
        group BY tmp.tva desc');

        $tvas = array();
        foreach ($tmps as $i => $t) {
            $tvas[$i]['Tva']['name'] = $t['tmp']['tva'];
        }

        if ($tmps != array()) {
            sort($tvas); //debug($tvas);die;
        }
//**********************************************************************************************************        
        $lignefactureavoirs = $this->Factureavoirfr->find('all', array(
            'conditions' => array(@$condf1, @$condf2,@$condfdec1, @$condfdec2, @$condf3, @$condsource,@$condf34), 'order' => array('Factureavoirfr.date' => 'ASC'), 'contain' => array('Fournisseur', 'Timbre'), 'recursive' => 1));

        foreach ($lignefactureavoirs as $lignefactureavoir) {
            @$name = $lignefactureavoir['Fournisseur']['name'];
            @$adresse = $lignefactureavoir['Fournisseur']['adresse'];
            @$mat = $lignefactureavoir['Fournisseur']['matriculefiscale'];
            @$code = $lignefactureavoir['Fournisseur']['code'];
            $tablignefactures[$cp]['id_piece'] = $lignefactureavoir['Factureavoirfr']['id'];
            $tablignefactures[$cp]['Fournisseur'] = $name;
            $tablignefactures[$cp]['adresse'] = @$adresse;
            $tablignefactures[$cp]['matriculefiscal'] = $mat;
            $tablignefactures[$cp]['code'] = $code;
            $tablignefactures[$cp]['date'] = $lignefactureavoir['Factureavoirfr']['date'];
            $tablignefactures[$cp]['type'] = "Factureavoirfr";
            $tablignefactures[$cp]['numero'] = $lignefactureavoir['Factureavoirfr']['numero'];
            $tablignefactures[$cp]['numerofrs'] = ''; //$lignefactureavoir['Factureavoirfr']['numerofrs'];
            $tablignefactures[$cp]['remise'] = $lignefactureavoir['Factureavoirfr']['remise'];
            $tablignefactures[$cp]['fodec'] = $lignefactureavoir['Factureavoirfr']['fodec'];
            $tablignefactures[$cp]['tva'] = $lignefactureavoir['Factureavoirfr']['tva'];
            $tablignefactures[$cp]['totalht'] = $lignefactureavoir['Factureavoirfr']['totalht'];
            $tablignefactures[$cp]['totalttc'] = $lignefactureavoir['Factureavoirfr']['totalttc'];
            $tablignefactures[$cp]['timbre'] = $lignefactureavoir['Factureavoirfr']['timbre_id'];


            $cp++;
        }
//******************************************************************************************************************************        


       // $fournisseurs = $this->Fournisseur->find('list');
//        $pointdeventes = $this->Pointdevente->find('list');
//        $exercices = $this->Exercice->find('list');
//        $types = array();
//        $types['Exonore'] = "Exonoré";
//        $types['Avoir'] = "Avoir";
//        $types['Tout'] = "Tout";
        //debug($tablignefactures);die;*
        //$tvas = $this->Tva->find('all', array('recursive' => -1));

        $this->set(compact('exercices', 'fournisseurs', 'date1', 'date2', 'datedec1', 'datedec2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function exportavecdetailsfactureachat() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));

        $this->loadModel('Exercice');
        $this->loadModel('Client');
        $this->loadModel('Paiement');

        $this->layout = NULL;

        //debug($this->request->query);die;

        $datedebutimpaye = CakeSession::read('datedebutimpaye');
        $datefinimpaye = CakeSession::read('datefinimpaye');
        $reglementimpaye = CakeSession::read('reglementimpaye');
        $triageimpaye = CakeSession::read('triageimpaye');
        $fournisseurimpaye = CakeSession::read('fournisseurimpaye');
        $venteimpaye = CakeSession::read('venteimpaye');
        $pointdeventeachat = CakeSession::read('pointdeventeachat');



        //debug($datereglement1);die;;
        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();


        //debug($datedebutimpaye);
        //debug($datefinimpaye);die;
        if ($datedebutimpaye != "__/__/____" && $datedebutimpaye != "1970-01-01" && $datedebutimpaye != NULL) {
            $conddateimpaye = 'Facture.date >= ' . "'" . $datedebutimpaye . "'";
        }
        if ($datefinimpaye != "__/__/____" && $datefinimpaye != "1970-01-01" && $datefinimpaye != NULL) {
            $conddateimpaye1 = 'Facture.date <= ' . "'" . $datefinimpaye . "'";
        }

        if (isset($fournisseurimpaye) && $fournisseurimpaye != 0) {
            $condb4 = 'Facture.fournisseur_id =' . $fournisseurimpaye;
        }


        if (isset($reglementimpaye)) {
            $reg = $reglementimpaye;
        }

        if (isset($triageimpaye)) {
            if ($triageimpaye == "Parnumfacture") {
                $ordre = 'Facture.numero ASC';
            }
            if ($triageimpaye == "Pardate") {
                $ordre = 'Facture.date ASC';
            }
            if ($triageimpaye == "Parcodeclient") {
                $ordre = 'Facture.fournisseur_id Asc';
            }
        }
        if ($pointdeventeachat != 0) {
            $pvf = 'Facture.pointdevente_id = ' . $pointdeventeachat;
        }
        $cp = 0;

        //debug($conddatereg);debug($condannee);die;
//******************************************************************************************************************************        

        $lignefactures = $this->Facture->find('all', array(
            'conditions' => array(@$conddateimpaye, @$conddateimpaye1, @$condb4,@$pvf, "Facture.nature='achat'"), 'order' => @$ordre, 'recursive' => -1));
        //debug($lignefactures);die;

        $this->set(compact('reg', 'lignefactures', 'datedebutimpaye', 'datefinimpaye', 'exerciceid'));
    }

    public function exportavecdetailsfactureavoir() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));

        $this->loadModel('Exercice');
        $this->loadModel('Client');
        $this->loadModel('Paiement');
        $this->loadModel('Factureavoirfr');

        $this->layout = NULL;

        //debug($this->request->query);die;

        $datedebutimpaye = CakeSession::read('datedebutimpaye');
        $datefinimpaye = CakeSession::read('datefinimpaye');
        $reglementimpaye = CakeSession::read('reglementimpaye');
        $triageimpaye = CakeSession::read('triageimpaye');
        $fournisseurimpaye = CakeSession::read('fournisseurimpaye');
        $venteimpaye = CakeSession::read('venteimpaye');
        $pointdeventeachat = CakeSession::read('pointdeventeachat');



        //debug($datereglement1);die;;
        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();


        //debug($datedebutimpaye);die;
        if ($datedebutimpaye != "__/__/____" && $datedebutimpaye != "1970-01-01" && $datedebutimpaye != NULL) {
            $conddateimpaye = 'Factureavoirfr.date >= ' . "'" . $datedebutimpaye . "'";
        }
        if ($datefinimpaye != "__/__/____" && $datefinimpaye != "1970-01-01" && $datefinimpaye != NULL) {
            $conddateimpaye1 = 'Factureavoirfr.date <= ' . "'" . $datefinimpaye . "'";
        }

        if (isset($fournisseurimpaye) && $fournisseurimpaye != 0) {
            $condb4 = 'Factureavoirfr.fournisseur_id =' . $fournisseurimpaye;
        }


        if (isset($reglementimpaye)) {
            $reg = $reglementimpaye;
        }

        if (isset($triageimpaye)) {
            if ($triageimpaye == "Parnumfacture") {
                $ordre = 'Factureavoirfr.numero ASC';
            }
            if ($triageimpaye == "Pardate") {
                $ordre = 'Factureavoirfr.date ASC';
            }
            if ($triageimpaye == "Parcodeclient") {
                $ordre = 'Fournisseur.code Asc';
            }
        }
        if ($pointdeventeachat != 0) {
            $pvf = 'Factureavoirfr.pointdevente_id = ' . $pointdeventeachat;
        }
        $cp = 0;

        //debug($conddatereg);debug($condannee);die;
//******************************************************************************************************************************        

        $lignefactures = $this->Factureavoirfr->find('all', array(
            'conditions' => array(@$conddateimpaye, @$conddateimpaye1, @$condb4,@$pvf), 'order' => @$ordre, 'recursive' => 0));
//debug($lignefactures);die;

        $this->set(compact('reg', 'lignefactures', 'datedebutimpaye', 'datefinimpaye', 'exerciceid'));
    }

	
	
	public function getfactures() {
        $this->layout = null;

        $data = $this->request->data;
        $index = $data['index'];
        $fournisseur_id = $data['fournisseur_id'];
//        debug($client_id);die;
        $factureclients = $this->Facture->find('all', array(
            'fields' => array('Facture.id', 'Facture.numerofrs'),
            'conditions' => array('Facture.fournisseur_id' => $fournisseur_id, 'Facture.totalttc > Facture.Montant_Regler'),
            'recursive' => -1));
//        debug($factureclients);die;
        $select = "<select name='data[Imputationfacture][" . $index . "][facture_id]' champ='facture_id' id='facture_id" . $index . "' class='form-control' onchange='testdoublefacturefr_et_getreste(" . $index . ")' >";
        $select = $select . "<option value=''>" . "-- Veuillez choisir --" . "</option>";
        foreach ($factureclients as $v) {
            $select = $select . "<option value=" . $v['Facture']['id'] . ">" . $v['Facture']['numerofrs'] . "</option>";
        }
        $select = $select . '</select>';

        echo json_encode(array('select' => $select, 'index' => $index));
        die();
    }

    public function getreste($factureclient_id = null, $action = null, $id = null) {
        $this->layout = null;
        $json = null;
        $this->loadModel('Factureavoirfr');

        $facture = $this->Facture->find('first', array(
            'conditions' => array('Facture.id' => $factureclient_id),
            'recursive' => -1,
            'fields' => array('Facture.totalttc', 'Facture.Montant_Regler')
        ));
        if ($action == "edit") {
            $this->loadModel('Imputationfactureavoirfr');
            $impts = $this->Imputationfactureavoirfr->find('first', array('conditions' => array('Imputationfactureavoirfr.factureavoirfr_id' => $id, 'Imputationfactureavoirfr.facture_id' => $factureclient_id), false));
            if (!empty($impts)) {
                $facture['Facture']['Montant_Regler'] = $facture['Facture']['Montant_Regler'] - $impts['Imputationfactureavoirfr']['montant'];
            }
//            debug($facture['Facture']['Montant_Regler']);
        }
        $reste = $facture['Facture']['totalttc'] - $facture['Facture']['Montant_Regler'];
        echo json_encode(array('reste' => $reste));
        die();
    }

}
