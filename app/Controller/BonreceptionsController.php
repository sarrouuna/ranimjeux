<?php

App::uses('AppController', 'Controller');

class BonreceptionsController extends AppController {

//******************************************************------------Historiques----------******************************************************************************************
    public function historique() {
        $lien = CakeSession::read('lien_achat');
        $bonreception = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $bonreception = 1;
                }
            }
        }
        if (( $bonreception <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel('Article');
        $this->loadModel('Bonreception');
        $this->loadModel('Facture');
        $historiques = array();
        if (isset($this->request->data) && !empty($this->request->data)) {
            //debug($this->request->data);die;
            if ($this->request->data['Bonreception']['date1'] != "__/__/____") {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date1'])));
                $condb1 = 'Bonreception.date >= ' . "'" . $date1 . "'";
                $condf1 = 'Facture.date >= ' . "'" . $date1 . "'";
            }

            if ($this->request->data['Bonreception']['date2'] != "__/__/____") {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date2'])));
                $condb2 = 'Bonreception.date <= ' . "'" . $date2 . "'";
                $condf2 = 'Facture.date <= ' . "'" . $date2 . "'";
            }

            if ($this->request->data['Bonreception']['fournisseur_id']) {
                $fournisseurid = $this->request->data['Bonreception']['fournisseur_id'];
                $condb3 = 'Bonreception.fournisseur_id =' . $fournisseurid;
                $condf3 = 'Facture.fournisseur_id = ' . $fournisseurid;
            }
            $bonreceptions = $this->Bonreception->find('all', array('conditions' => array('Bonreception.id > ' => 0, @$condb1, @$condb2, @$condb3))); //debug($bonreceptions);die;
            $direct = "'direct'";
            $condf4 = 'Facture.type >= ' . $direct;
            $factures = $this->Facture->find('all', array('conditions' => array('Facture.id > ' => 0, @$condf1, @$condf2, @$condf3, $condf4)));  //debug($factures);die;
            $compteur = 0;

            if ($this->request->data['Bonreception']['article_id']) {
                $articleid = $this->request->data['Bonreception']['article_id'];
                foreach ($bonreceptions as $bonreception) {
                    foreach ($bonreception['Lignereception'] as $lignereception) {
                        $learticle = $this->Article->find('first', array('conditions' => array('Article.id' => $lignereception['article_id']), 'recursive' => -1));
                        if ($lignereception['article_id'] == $articleid) {
                            if ($compteur > 0) {
                                $compteur--;
                                if (($historiques[$compteur]['prix'] == $lignereception['prixhtva']) & ($historiques[$compteur]['Fournisseur'] == $bonreception['Fournisseur'])) {

                                    $historiques[$compteur]['quantite'] += $lignereception['quantite'];
                                    $historiques[$compteur]['date'] = $bonreception['Bonreception']['date'];
                                    $compteur++;
                                } else {
                                    $compteur++;
                                    $historiques[$compteur]['article_id'] = $lignereception['article_id'];
                                    $historiques[$compteur]['learticle'] = $learticle['Article']['nom'];
                                    $historiques[$compteur]['prix'] = $lignereception['prixhtva'];
                                    $historiques[$compteur]['quantite'] = $lignereception['quantite'];
                                    $historiques[$compteur]['date'] = $bonreception['Bonreception']['date'];
                                    $historiques[$compteur]['Fournisseur'] = $bonreception['Fournisseur'];
                                    $compteur++;
                                }
                            } else {
                                $historiques[$compteur]['article_id'] = $lignereception['article_id'];
                                $historiques[$compteur]['learticle'] = $learticle['Article']['nom'];
                                $historiques[$compteur]['prix'] = $lignereception['prixhtva'];
                                $historiques[$compteur]['quantite'] = $lignereception['quantite'];
                                $historiques[$compteur]['date'] = $bonreception['Bonreception']['date'];
                                $historiques[$compteur]['Fournisseur'] = $bonreception['Fournisseur'];
                                $compteur++;
                            }
                        }
                    }
                }
                foreach ($factures as $facture) {
                    foreach ($facture['Lignefacture'] as $lignefacture) {
                        $learticle = $this->Article->find('first', array('conditions' => array('Article.id' => $lignefacture['article_id']), 'recursive' => -1));
                        //debug($learticle);die;
                        if ($lignefacture['article_id'] == $articleid) {
                            if ($compteur > 0) {
                                $compteur--;
                                if (($historiques[$compteur]['prix'] == $lignefacture['prixhtva']) & ($historiques[$compteur]['Fournisseur'] == $facture['Fournisseur'])) {

                                    $historiques[$compteur]['quantite'] += $lignefacture['quantite'];
                                    $historiques[$compteur]['date'] = $facture['Facture']['date'];
                                    $compteur++;
                                } else {
                                    $compteur++;
                                    $historiques[$compteur]['article_id'] = $lignefacture['article_id'];
                                    $historiques[$compteur]['learticle'] = $learticle['Article']['nom'];
                                    $historiques[$compteur]['prix'] = $lignefacture['prixhtva'];
                                    $historiques[$compteur]['quantite'] = $lignefacture['quantite'];
                                    $historiques[$compteur]['date'] = $facture['Facture']['date'];
                                    $historiques[$compteur]['Fournisseur'] = $facture['Fournisseur'];
                                    $compteur++;
                                }
                            } else {
                                $historiques[$compteur]['article_id'] = $lignefacture['article_id'];
                                $historiques[$compteur]['learticle'] = $learticle['Article']['nom'];
                                $historiques[$compteur]['prix'] = $lignefacture['prixhtva'];
                                $historiques[$compteur]['quantite'] = $lignefacture['quantite'];
                                $historiques[$compteur]['date'] = $facture['Facture']['date'];
                                $historiques[$compteur]['Fournisseur'] = $facture['Fournisseur'];
                                $compteur++;
                            }
                        }
                    }
                }
                foreach ($historiques as $i => $historique) {
                    foreach ($historiques as $j => $historique) {
                        if (($j != $i) & ($historiques[$j]['prix'] == $historiques[$i]['prix']) & ($historiques[$j]['Fournisseur'] == $historiques[$i]['Fournisseur'])) {
                            $historiques[$i]['quantite'] += $historiques[$j]['quantite'];
                            $historiques[$i]['date'] = $historiques[$j]['date'];
                            $historiques[$j]['quantite'] = 0;
                        }
                    }
                }
            }
        }
        $fournisseurs = $this->Fournisseur->find('list'); //debug($fournisseurs);die;
        //$articles = $this->Article->find('list');
        $this->set(compact('date1', 'date2', 'fournisseurid', 'articleid', 'fournisseurs', 'articles', 'historiques', $this->paginate()));
    }

    public function imprimerhistorique() {
        $lien = CakeSession::read('lien_achat');
        $bonreception = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $bonreception = $liens['imprimer'];
                }
            }
        }
        if (( $bonreception <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel('Article');
        $this->loadModel('Bonreception');
        $this->loadModel('Facture');
        $historiques = array();
        // debug($this->request->query);die;
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $condb1 = 'Bonreception.date >= ' . "'" . $date1 . "'";
            $condf1 = 'Facture.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $condb2 = 'Bonreception.date <= ' . "'" . $date2 . "'";
            $condf2 = 'Facture.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $condb3 = 'Bonreception.fournisseur_id =' . $fournisseurid;
            $condf3 = 'Facture.fournisseur_id = ' . $fournisseurid;
        }
        $bonreceptions = $this->Bonreception->find('all', array('conditions' => array('Bonreception.id > ' => 0, @$condb1, @$condb2, @$condb3))); //debug($bonreceptions);die;
        $direct = "'direct'";
        $condf4 = 'Facture.type >= ' . $direct;
        $factures = $this->Facture->find('all', array('conditions' => array('Facture.id > ' => 0, @$condf1, @$condf2, @$condf3, $condf4)));  //debug($factures);die;
        $compteur = 0;
        //  if ($this->request->query['articleid']) {
        $articleid = $this->request->query['articleid'];
        foreach ($bonreceptions as $bonreception) {
            foreach ($bonreception['Lignereception'] as $lignereception) {
                $learticle = $this->Article->find('first', array('conditions' => array('Article.id' => $lignereception['article_id']), 'recursive' => -1));
                if ($lignereception['article_id'] == $articleid) {
                    if ($compteur > 0) {
                        $compteur--;
                        if (($historiques[$compteur]['prix'] == $lignereception['prixhtva']) & ($historiques[$compteur]['Fournisseur'] == $bonreception['Fournisseur'])) {

                            $historiques[$compteur]['quantite'] += $lignereception['quantite'];
                            $historiques[$compteur]['date'] = $bonreception['Bonreception']['date'];
                            $compteur++;
                        } else {
                            $compteur++;
                            $historiques[$compteur]['article_id'] = $lignereception['article_id'];
                            $historiques[$compteur]['learticle'] = $learticle['Article']['nom'];
                            $historiques[$compteur]['prix'] = $lignereception['prixhtva'];
                            $historiques[$compteur]['quantite'] = $lignereception['quantite'];
                            $historiques[$compteur]['date'] = $bonreception['Bonreception']['date'];
                            $historiques[$compteur]['Fournisseur'] = $bonreception['Fournisseur'];
                            $compteur++;
                        }
                    } else {
                        $historiques[$compteur]['article_id'] = $lignereception['article_id'];
                        $historiques[$compteur]['learticle'] = $learticle['Article']['nom'];
                        $historiques[$compteur]['prix'] = $lignereception['prixhtva'];
                        $historiques[$compteur]['quantite'] = $lignereception['quantite'];
                        $historiques[$compteur]['date'] = $bonreception['Bonreception']['date'];
                        $historiques[$compteur]['Fournisseur'] = $bonreception['Fournisseur'];
                        $compteur++;
                    }
                }
            }
        }
        foreach ($factures as $facture) {
            foreach ($facture['Lignefacture'] as $lignefacture) {
                $learticle = $this->Article->find('first', array('conditions' => array('Article.id' => $lignefacture['article_id']), 'recursive' => -1));
                if ($lignefacture['article_id'] == $articleid) {
                    if ($compteur > 0) {
                        $compteur--;
                        if (($historiques[$compteur]['prix'] == $lignefacture['prixhtva']) & ($historiques[$compteur]['Fournisseur'] == $facture['Fournisseur'])) {

                            $historiques[$compteur]['quantite'] += $lignefacture['quantite'];
                            $historiques[$compteur]['date'] = $facture['Facture']['date'];
                            $compteur++;
                        } else {
                            $compteur++;
                            $historiques[$compteur]['article_id'] = $lignefacture['article_id'];
                            $historiques[$compteur]['learticle'] = $learticle['Article']['nom'];
                            $historiques[$compteur]['prix'] = $lignefacture['prixhtva'];
                            $historiques[$compteur]['quantite'] = $lignefacture['quantite'];
                            $historiques[$compteur]['date'] = $facture['Facture']['date'];
                            $historiques[$compteur]['Fournisseur'] = $facture['Fournisseur'];
                            $compteur++;
                        }
                    } else {
                        $historiques[$compteur]['article_id'] = $lignefacture['article_id'];
                        $historiques[$compteur]['learticle'] = $learticle['Article']['nom'];
                        $historiques[$compteur]['prix'] = $lignefacture['prixhtva'];
                        $historiques[$compteur]['quantite'] = $lignefacture['quantite'];
                        $historiques[$compteur]['date'] = $facture['Facture']['date'];
                        $historiques[$compteur]['Fournisseur'] = $facture['Fournisseur'];
                        $compteur++;
                    }
                }
            }
        }
        foreach ($historiques as $i => $historique) {
            foreach ($historiques as $j => $historique) {
                if (($j != $i) & ($historiques[$j]['prix'] == $historiques[$i]['prix']) & ($historiques[$j]['Fournisseur'] == $historiques[$i]['Fournisseur'])) {
                    $historiques[$i]['quantite'] += $historiques[$j]['quantite'];
                    $historiques[$i]['date'] = $historiques[$j]['date'];
                    $historiques[$j]['quantite'] = 0;
                }
            }
        }

        //$articles = $this->Article->find('list');
        $this->set(compact('historiques', 'articles', 'date1', 'date2', 'fournisseurid', 'articleid'));
    }

//***************************************************------------Fin_Historiques----------*****************************************************************************************************
    public function index() {
        $lien = CakeSession::read('lien_achat');
        $bonreception = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $bonreception = 1;
                }
            }
        }
        if (( $bonreception <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel('Utilisateur');
        $this->loadModel('Exercice');
        $this->loadModel('Societe');
        $this->loadModel('Pointdevente');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $exercices = $this->Exercice->find('list');
        $cond4 = 'Bonreception.exercice_id =' . date("Y");
        $pv = "";
        $p = CakeSession::read('pointdevente');

        if ($p > 0) {
            $pv = 'Bonreception.pointdevente_id = ' . $p;
        }
        $socc = CakeSession::read('soc');
        $pvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id in (' . $socc . ')')));
        $liste_pv = '0';
        foreach ($pvs as $one_pv) {
            if (!empty($one_pv['Pointdevente']['id'])) {
                $liste_pv = $liste_pv . ',' . $one_pv['Pointdevente']['id'];
            }
        }
//        $cond6 = 'Bonreception.pointdevente_id in (' . $liste_pv . ')';
//        $cond1 = 'Bonreception.date >= ' . "'" . date('Y-m-d') . "'";
//        $cond2 = 'Bonreception.date <= ' . "'" . date('Y-m-d') . "'";
//        $date1 = date('Y-m-d');
//        $date2 = date('Y-m-d');
        $limit = 100;
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Bonreceptions"))) {

            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Recherche']);
            } else {
                $this->request->data['Recherche'] = CakeSession::read('recherche');
            }
//             debug($this->request->data['Recherche']);die;
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $cond4 = 'Bonreception.exercice_id =' . $exercices[$exerciceid];
                
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $cond1 = 'Bonreception.date >= ' . "'" . $date1 . "'";
                $cond4 = "";
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $cond2 = 'Bonreception.date <= ' . "'" . $date2 . "'";
                $cond4 = "";
            }

            if ($this->request->data['Recherche']['fournisseur_id']) {
                $fournisseurid = $this->request->data['Recherche']['fournisseur_id'];
                $cond3 = 'Bonreception.fournisseur_id =' . $fournisseurid;
            }

            if ($this->request->data['Recherche']['transf_id'] == "0") {
                $transf = $this->request->data['Recherche']['transf_id'];
                $cond5 = 'Bonreception.facture_id =' . $transf;
            } elseif ($this->request->data['Recherche']['transf_id'] == "1") {
                $transf = $this->request->data['Recherche']['transf_id'];
                $cond5 = 'Bonreception.facture_id >= ' . $transf;
            }



            $this->loadModel('Utilisateur');
            $this->loadModel('Pointdevente');
            $this->loadModel('Societe');
            $this->loadModel('Personnel');
            if (@$this->request->data['Recherche']['societe_id']) {
                $societe_id = $this->request->data['Recherche']['societe_id'];
                $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
                $ch_pv = 0;
                foreach ($lespvs as $lespv) {
                    $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
                }
                $cond6 = 'Bonreception.pointdevente_id in (' . $ch_pv . ')';
                $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societe_id)));
            }


            if ($this->request->data['Recherche']['pointdevente_id']) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                $cond7 = 'Bonreception.pointdevente_id =' . $pointdevente_id;
            }
            if ($this->request->data['Recherche']['facturer']) {

                $val = $this->request->data['Recherche']['facturer'];
                if ($val == 1) {
                    $cond9 = 'Bonreception.facture_id > 0';
                } elseif ($val == 2) {
                    $cond9 = 'Bonreception.facture_id = 0';
                } else {
                    $cond9 = '';
                }
            }
//            debug($cond9);die;
            if ($this->request->data['Recherche']['bl_id']) {
                $bl_id = $this->request->data['Recherche']['bl_id'];
                $cond10 = 'Bonreception.id =' . $bl_id;
            }
            $limit = 100000;
        }
        $bonreceptions = $this->Bonreception->find('all', array(
            'conditions' => array('Bonreception.nature' =>'achat', $pv, @$cond1, @$cond2, @$cond3, @$cond5, @$cond4, @$cond6, @$cond7, @$cond9, @$cond10),
            'limit'=>$limit,
            'order'=>array('Bonreception.id'=>'desc')
            ));
        // debug($cond5);die;
        $transfs[0] = "Non transformé";
        $transfs[1] = "Transformé";
        $bes[0] = "Non Ajouté";
        $bes[1] = "Ajouté";
//        $societes = $this->Societe->find('list', array('conditions' => array('Societe.id in (' . $soc . ')')));
        $fournisseurs = $this->Fournisseur->find('list'); //debug($fournisseurs);die;
        $utilisateurs = $this->Utilisateur->find('list');
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
        $facturers = array();
        $facturers[1] = "OUI";
        $facturers[2] = "NON";

        $this->set(compact('date2', 'date1', 'val', 'bl_id', 'facturers', 'countsos', 'exercices', 'societes', 'pointdeventes', 'societe_id', 'pointdevente_id', 'date1', 'date2', 'fournisseurid', 'utilisateurid', 'transf', 'be', 'transfs', 'bes', 'fournisseurs', 'utilisateurs', 'bonreceptions'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_achat');
        $bonreception = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $bonreception = 1;
                }
            }
        }
        if (( $bonreception <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignereception');
        $this->loadModel('Article');
        if (!$this->Bonreception->exists($id)) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        $options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
        $this->set('bonreception', $this->Bonreception->find('first', $options));
        $lignereceptions = $this->Lignereception->find('all', array(
            'conditions' => array('Lignereception.bonreception_id' => $id)
        ));
        $articles = $this->Article->find('list');
        $this->set(compact('lignereceptions', 'articles'));
    }

    public function imprimer($id = null) {


        $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignereception');
        if (!$this->Bonreception->exists($id)) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        $options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
        $this->set('factureclient', $this->Bonreception->find('first', $options));
        $lignefactureclients = $this->Lignereception->find('all', array(
            'conditions' => array('Lignereception.bonreception_id' => $id)
        ));
        $lignefactureclientstva = $this->Lignereception->find('all', array('fields' => array(
                'SUM(Lignereception.totalht*(1+(CASE WHEN Lignereception.fodec IS NULL THEN 0 ELSE Lignereception.fodec END/100))*Lignereception.tva)/100  mtva'
                , 'SUM(Lignereception.totalht*(1+(CASE WHEN Lignereception.fodec IS NULL THEN 0 ELSE Lignereception.fodec END/100))) totalht'
                , 'AVG(Lignereception.tva) tva'),
            'conditions' => array('Lignereception.bonreception_id' => $id)
            , 'group' => array('Lignereception.tva')
        ));
        //debug($lignefactureclients) ;
        // debug($lignefactureclientstva)  ;die;  
        $this->set(compact('lignefactureclients', 'lignefactureclientstva'));
    }

    public function imprimerpourdepot($id = null) {
        $lien = CakeSession::read('lien_achat');
        $bonreception = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $bonreception = $liens['imprimer'];
                }
            }
        }
        if (( $bonreception <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignereception');
        $this->loadModel('Article');
        if (!$this->Bonreception->exists($id)) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        $options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
        $this->set('bonreception', $this->Bonreception->find('first', $options));
        $articles = $this->Article->find('list');
        $lignereceptions = $this->Lignereception->find('all', array(
            'conditions' => array('Lignereception.bonreception_id' => $id)
        ));
        $this->set(compact('lignereceptions', 'articles'));
    }

    public function add() {
        $lien = CakeSession::read('lien_achat');
        $bonreception = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $bonreception = $liens['add'];
                }
            }
        }
        if (( $bonreception <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $name = 'Bonreceptions';
        //$helpers = array('Html', 'Ajax', 'Javascript');
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Depot');
        $this->loadModel('Lignereception');
        $this->loadModel('Homologation');
        $this->loadModel('Articlehomologation');
        $this->loadModel('Fournisseur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Tracemodificationprixdevente');
        if ($this->request->is('post')) {
//            debug($this->request->data);die;
            $this->request->data['Bonreception']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date'])));
            $this->request->data['Bonreception']['datefacture'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['datefacture'])));
            $this->request->data['Bonreception']['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data['Bonreception']['pointdevente_id'])) {
                $this->request->data['Bonreception']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Bonreception']['exercice_id'] = date("Y");
            //$depotid=$this->request->data['Bonreception']['depot_id'];
            $this->Bonreception->create();
            if (!empty($this->request->data['Lignereception'])) {
                if ($this->Bonreception->save($this->request->data)) {
                    $id = $this->Bonreception->id;
                    $this->misejour("Bonreception", "add", $id);
                    $Lignereceptions = array();
                    $stockdepots = array();
                    $lot = array();
                    foreach ($this->request->data['Lignereception'] as $numl => $f) {
                        if ($f['sup'] != 1) {
                            $Lignereceptions['margeans'] = $f['margeans'];
                            $Lignereceptions['prixachatans'] = $f['prixachatans'];
                            $Lignereceptions['bonreception_id'] = $id;
                            $Lignereceptions['depot_id'] = $stockdepots[$numl]['depot_id'] = $f['depot_id'];
                            $depotid = $f['depot_id'];
                            $stockdepots[$numl]['article_id'] = $Lignereceptions['article_id'] = $f['article_id'];
                            $stockdepots[$numl]['quantite'] = $Lignereceptions['quantite'] = $f['quantite'];
                            if (!empty($f['prix'])) {
                                $Lignereceptions['prix'] = $f['prix'];
                                $Lignereceptions['prix_anc'] = $f['prix_anc'];
                            }
                            $Lignereceptions['prixhtva'] = $f['prixhtva'];
                            $Lignereceptions['remise'] = @$f['remise'];
                            $Lignereceptions['fodec'] = @$f['fodec'];
                            $Lignereceptions['tva'] = $f['tva'];
                            $Lignereceptions['prixhtva'] = $f['prixhtva'];
                            $Lignereceptions['totalht'] = ($f['prixhtva'] * (1 - @$f['remise'] * 0.01)) * $f['quantite'];
                            $Lignereceptions['totalttc'] = ((($Lignereceptions['totalht']) * (1 + (@$f['fodec'] * 0.01))) * (1 + ($f['tva'] * 0.01)));
                            //$lot[$f['numerolot']][$numl]=$f['article_id'];
                            $this->Lignereception->create();
                            $this->Lignereception->save($Lignereceptions);
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

                            //  debug($stockdepots);die;
                            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $stockdepots[$numl]['article_id'], 'Stockdepot.depot_id' => $depotid, @$cond), false));
                            if (!empty($stckdepot)) {
                                $coutderevienttot = ($stckdepot[0]['Stockdepot']['prix'] * $stckdepot[0]['Stockdepot']['quantite']) + $Lignereceptions['totalht'];
                                $stockdepots[$numl]['quantite'] = $stockdepots[$numl]['quantite'] + $stckdepot[0]['Stockdepot']['quantite'];
                                $coutderevient = $coutderevienttot / $stockdepots[$numl]['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite'], 'Stockdepot.prix' => $coutderevient), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                            } else {
                                $stockdepots[$numl]['prix'] = $Lignereceptions['totalht'] / $f['quantite'];
                                $this->Stockdepot->create();
                                $this->Stockdepot->save($stockdepots[$numl]);
                            }
                            //$this->stock($depotid, $f['article_id']);
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
        $numero = $this->Bonreception->find('all', array('fields' =>
            array(
                'MAX(Bonreception.numeroconca) as num'
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
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1)));
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
        $this->set(compact('mm', 'fournisseurs', 'p', 'articles', 'depots', 'pointdeventes'));
    }

    public function addindirect($tab = null) {
        $lien = CakeSession::read('lien_achat');
        $bonreception = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $bonreception = $liens['add'];
                }
            }
        }
        if (( $bonreception <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefacture');
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
        $this->loadModel('Pointdevente');
        $b = 0;
        list($table, $listf) = explode(";", $tab);
        if ($table == 'commande') {
            $tab = $listf;
            $b = 1;
        }
        $tbr = $tab . ',0)';
        list($idbr, $resteidbr) = explode(",", $tbr);
        $tbr = '(0,' . $tbr;
        $idbrs = explode(",", $tab);
        //debug($tbr);           
        if ($b == 1) {
            $reqfournisseur = $this->Commande->find('all', array('conditions' => array('Commande.id' => $idbr), 'recursive' => -2));
        } else {
            $reqfournisseur = $this->Bonreception->find('all', array('conditions' => array('Bonreception.id' => $idbr), 'recursive' => -2));
        }


        $bonreception = $this->Commande->find('first', array('fields' => array('Commande.compte_id', 'SUM(Commande.fret) fret', 'SUM(Commande.avoir) avoir', 'SUM(Commande.remise) remise', 'SUM(Commande.fodec ) fodec ', 'SUM(Commande.tva) tva', 'SUM(Commande.totalht) totalht'
                , 'SUM(Commande.totalttc) totalttc', 'AVG(Commande.fournisseur_id) fournisseur_id', 'AVG(Commande.importation_id) importation_id', 'AVG(Commande.coefficient) coefficient', 'AVG(Commande.depot_id) depot_id'), 'conditions' => array('Commande.id' => $idbrs), 'recursive' => -2));
        //debug($bonreception);
        //zeinab
        $lignebonreceptions = $this->Lignecommande->find('all', array('fields' => array('AVG(Article.marge) marge', 'AVG(Lignecommande.article_id) article_id', '(Lignecommande.article_id) article_iddd'
                , 'SUM(Lignecommande.quantite) quantite', 'SUM(Lignecommande.remise*Lignecommande.quantite) remise', 'SUM(Lignecommande.prix*Lignecommande.quantite) prix'
                , 'AVG(Lignecommande.tva) tva', 'AVG(Lignecommande.fodec) fodec', 'SUM(Lignecommande.totalht) totalht', 'SUM(Lignecommande.totalttc)totalttc', 'SUM(Lignecommande.prixhtva*Lignecommande.quantite)prixhtva ')
            , 'conditions' => array('Lignecommande.commande_id in' . $tbr), 'recursive' => -2
            , 'order' => array('Lignecommande.id' => 'asc')
            , 'group' => array('Lignecommande.article_id')));
        // debug($lignebonreceptions); 
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Bonreception']['commande_id'] = $tbr;
            $this->request->data['Bonreception']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date'])));
            $this->request->data['Bonreception']['datefacture'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['datefacture'])));
            $this->request->data['Bonreception']['utilisateur_id'] = CakeSession::read('users');
            //$depotid=$this->request->data['Bonreception']['depot_id'];
            $this->request->data['Bonreception']['type'] = 'indirect';
            if (empty($this->request->data['Bonreception']['pointdevente_id'])) {
                $this->request->data['Bonreception']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Bonreception']['exercice_id'] = date("Y");
            if ($this->request->data['Bonreception']['devise_id'] != 1) {
                $tc = $this->request->data['Bonreception']['tr'];
                $coe = $this->request->data['Bonreception']['coe'];
            } else {
                $tc = 1;
                $coe = 1;
            }
            $this->Bonreception->create();
            if ($this->Bonreception->save($this->request->data)) {
                $id = $this->Bonreception->id;
                $this->misejour("Bonreception", "add", $id);
                $Lignereceptions = array();
                $stockdepots = array();
                $lot = array();
                foreach ($this->request->data['Lignedeviprospect'] as $numl => $f) {

                    //debug($f);die;
                    if ($f['sup'] != 1) {
                        //zeinab
                        $stockdepots[$numl]['article_id'] = $Lignereceptions['article_id'] = $f['article_id'];
                        $stockdepots[$numl]['quantite'] = $Lignereceptions['quantite'] = $f['quantite'];
                        $depotid = $f['depot_id'];
                        $stockdepots[$numl]['depot_id'] = $f['depot_id'];
                        $Lignereceptions['margeans'] = $f['margeans'];
                        $Lignereceptions['prixachatans'] = $f['prixachatans'];
                        $Lignereceptions['depot_id'] = $stockdepots[$numl]['depot_id'] = $f['depot_id'];
                        $Lignereceptions['bonreception_id'] = $id;
                        if (!empty($f['prix'])) {
                            $Lignereceptions['prix'] = $f['prix'];
                            $Lignereceptions['prix_anc'] = $f['prix_anc'];
                        }
                        $Lignereceptions['prixhtva'] = $f['prixhtva'];
                        $Lignereceptions['remise'] = @$f['remise'];
                        $Lignereceptions['fodec'] = @$f['fodec'];
                        $Lignereceptions['tva'] = $f['tva'];
                        $Lignereceptions['prixhtva'] = $f['prixhtva'];
                        if (!empty($f['prix'])) {
                            $Lignereceptions['totalht'] = $f['totalht'];
                            $Lignereceptions['totalttc'] = $f['totalttc'];
                        } else {
                            $Lignereceptions['totalht'] = ($f['prixhtva'] * (1 - @$f['remise'] * 0.01)) * $f['quantite'];
                            $Lignereceptions['totalttc'] = ((($Lignereceptions['totalht']) * (1 + (@$f['fodec'] * 0.01))) * (1 + ($f['tva'] * 0.01)));
                        }
                        $this->Lignereception->create();
                        $this->Lignereception->save($Lignereceptions);
                        $coutderevientHT = $Lignereceptions['totalht'] / $f['quantite'];


                        if ($this->request->data['Bonreception']['devise_id'] != 1) {
                            $this->Article->updateAll(array('Article.coutrevient' => sprintf('%.3f', $coutderevientHT), 'Article.tauxchange' => $tc, 'Article.coefficient' => $coe, 'Article.prixachatdevise' => $f['prix']), array('Article.id' => $f['article_id']));
                        } else {
                            $this->Article->updateAll(array('Article.coutrevient' => $f['prixhtva'], 'Article.tauxchange' => $tc, 'Article.coefficient' => $coe, 'Article.prixachatdevise' => $f['prixhtva']), array('Article.id' => $f['article_id']));
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

                        $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $stockdepots[$numl]['article_id'], 'Stockdepot.depot_id' => $depotid), false));
                        if (!empty($stckdepot)) {
                            $stockdepots[$numl]['quantite'] = $stockdepots[$numl]['quantite'] + $stckdepot[0]['Stockdepot']['quantite'];
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                        } else {
                            $this->Stockdepot->create();
                            $this->Stockdepot->save($stockdepots[$numl]);
                        }


                        //$this->stock($depotid, $f['article_id']);
                    }
                }
                if ($b == 1) {
                    foreach ($idbrs as $c) {
                        $this->Commande->updateAll(array('Commande.validite_id' => 3), array('Commande.id' => $c));
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
        /* $art = $this->Bonreception->query('
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
          }
          $articles = $this->Article->find('list'); */
        $importations = $this->Importation->find('list', array('conditions' => array('Importation.fournisseur_id' => $bonreception[0]['fournisseur_id'], 'Importation.etat' => 0), false));
        $numero = $this->Bonreception->find('all', array('fields' =>
            array(
                'MAX(Bonreception.numeroconca) as num'
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

        $comptes = $this->Compte->find('list', array('fields' => array('Compte.banque')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('pointdeventes', 'p', 'comptes', 'mm', 'impo', 'name', 'devise', 'importations', 'tot_coe', 'coe', 'tr', 'lignebonreceptions', 'bonreception', 'fournisseurs', 'lignefactures', 'articles', 'fournisseurid', 'depots'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_achat');
        $bonreception = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $bonreception = $liens['edit'];
                }
            }
        }
        if (( $bonreception <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Articlehomologation');
        $this->loadModel('Article');
        $this->loadModel('Fournisseur');
        $this->loadModel('Lignereception');
        $this->loadModel('Stockdepot');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Importation');
        $this->loadModel('Tracemodificationprixdevente');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Compte');
        $this->loadModel('Pointdevente');
        if (!$this->Bonreception->exists($id)) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug( $this->request->data);die;
            $this->request->data['Bonreception']['datefacture'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['datefacture'])));
            $this->request->data['Bonreception']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date'])));
            $this->request->data['Bonreception']['utilisateur_id'] = CakeSession::read('users');
            //$depotid=$this->request->data['Bonreception']['depot_id'];
            $bonreception = $this->Bonreception->find('first', array('conditions' => array('Bonreception.id' => $id), false));
            if ($this->Bonreception->save($this->request->data)) {
                $this->misejour("Bonreception", "edit", $id);
                $Lignereceptions = array();

                $lot = array();
                $lignereceptionanciens = $this->Lignereception->find('all', array('conditions' => array('Lignereception.bonreception_id' => $id), false));
                //debug($lignereceptionanciens);
                foreach ($lignereceptionanciens as $lra) {
                    //debug( $lra);die;
                    $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $lra['Lignereception']['article_id'],
                            'Stockdepot.depot_id' => $lra['Lignereception']['depot_id'])));
                    //debug($lra['Lignereception']['quantite']);die;
                    $coutderevienttot = ($stckdepot[0]['Stockdepot']['prix'] * $stckdepot[0]['Stockdepot']['quantite']) - $lra['Lignereception']['totalht'];
                    $condb1 = 'Bonlivraison.date >= ' . "'" . $this->request->data['Bonreception']['date'] . "'";
                    $condf1 = 'Factureclient.date >= ' . "'" . $this->request->data['Bonreception']['date'] . "'";
                    $qtelivres = $this->Lignelivraison->find('all', array(
                        'fields' => array('sum(Lignelivraison.quantite) as quantite')
                        , 'conditions' => array('Bonlivraison.factureclient_id' => 0, 'Lignelivraison.article_id' => $lra['Lignereception']['article_id'], @$condb1)
                        , 'recursive' => 2));
                    $qtefacs = $this->Lignefactureclient->find('all', array(
                        'fields' => array('sum(Lignefactureclient.quantite) as quantite')
                        , 'conditions' => array('Lignefactureclient.article_id' => $lra['Lignereception']['article_id'], @$condf1)
                        , 'recursive' => 2));
                    $qtevente = $qtelivres[0][0]['quantite'] + $qtefacs[0][0]['quantite'];
                    $qte = $stckdepot[0]['Stockdepot']['quantite'] + $qtevente - $lra['Lignereception']['quantite'];
                    if ($qte != 0) {
                        $coutderevient = $coutderevienttot / $qte;
                    } else {
                        $coutderevient = 0;
                    }
                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite -' . $lra['Lignereception']['quantite'], 'Stockdepot.prix' => $coutderevient), array('Stockdepot.article_id' => $lra['Lignereception']['article_id'], 'Stockdepot.depot_id' => $lra['Lignereception']['depot_id']));
                }


                //$this->Stockdepot->deleteAll(array('Stockdepot.quantite'=>0),false);
                $this->Lignereception->deleteAll(array('Lignereception.bonreception_id' => $id), false);

                foreach ($this->request->data['Lignereception'] as $numl => $f) {
                    $stockdepots = array();
                    //debug($f);die;
                    //zeinab
                    if ($f['sup'] != 1) {
                        $Lignereceptions['depot_id'] = $stockdepots['depot_id'] = $f['depot_id'];
                        $depotid = $f['depot_id'];
                        $stockdepots['article_id'] = $Lignereceptions['article_id'] = $f['article_id'];
                        $stockdepots['quantite'] = $Lignereceptions['quantite'] = $f['quantite'];

                        if ($this->request->data['Bonreception']['devise_id'] == 1) {
                            $Lignereceptions['margeans'] = $f['margeans'];
                            $Lignereceptions['prixachatans'] = $f['prixachatans'];
                            $Lignereceptions['bonreception_id'] = $id;
                            if (!empty($f['prix'])) {
                                $Lignereceptions['prix'] = $f['prix'];
                                $Lignereceptions['prix_anc'] = $f['prix_anc'];
                            }
                            $Lignereceptions['prixhtva'] = $f['prixhtva'];
                            $Lignereceptions['remise'] = @$f['remise'];
                            $Lignereceptions['fodec'] = @$f['fodec'];
                            $Lignereceptions['tva'] = $f['tva'];
                            $Lignereceptions['prixhtva'] = $f['prixhtva'];
                            if (!empty($f['prix'])) {
                                $Lignereceptions['totalht'] = $f['totalht'];
                                $Lignereceptions['totalttc'] = $f['totalttc'];
                            } else {
                                $Lignereceptions['totalht'] = ($f['prixhtva'] * (1 - @$f['remise'] * 0.01)) * $f['quantite'];
                                $Lignereceptions['totalttc'] = ((($Lignereceptions['totalht']) * (1 + (@$f['fodec'] * 0.01))) * (1 + ($f['tva'] * 0.01)));
                            }
                            $this->Lignereception->create();
                            $this->Lignereception->save($Lignereceptions);
                        }

                        if (!empty($f['prix'])) {
                            $tc = $this->request->data['Bonreception']['tr'];
                            $coe = $this->request->data['Bonreception']['coe'];
                            $this->Article->updateAll(array('Article.coutrevient' => sprintf('%.3f', $Lignereceptions['totalht'] / $f['quantite']), 'Article.tauxchange' => $tc, 'Article.coefficient' => $coe, 'Article.prixachatdevise' => $f['prix']), array('Article.id' => $f['article_id']));
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

                        $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $stockdepots['article_id'], 'Stockdepot.depot_id' => $depotid)));
                        // debug($stckdepot);die;     
                        if (!empty($stckdepot)) {
                            $coutderevienttot = ($stckdepot[0]['Stockdepot']['prix'] * $stckdepot[0]['Stockdepot']['quantite']) + $Lignereceptions['totalht'];
                            $stockdepots['quantite'] = $stockdepots['quantite'] + $stckdepot[0]['Stockdepot']['quantite'];
                            if ($stockdepots['quantite'] != 0) {
                                $coutderevient = $coutderevienttot / $stockdepots['quantite'];
                            } else {
                                $coutderevient = 0;
                            }
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots['quantite'], 'Stockdepot.prix' => $coutderevient), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                        } else {
                            $stockdepots['prix'] = $Lignereceptions['totalht'] / $f['quantite'];
                            $this->Stockdepot->create();
                            $this->Stockdepot->save($stockdepots);
                        }


                        //$this->stock($depotid, $f['article_id']);
                    }
                }

                //debug($h);die;


                $this->Session->setFlash(__('The bonreception has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The bonreception could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
            $this->request->data = $this->Bonreception->find('first', $options);
            //debug($this->request->data);

            $day = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Bonreception']['date'])));
            $datefac = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Bonreception']['datefacture'])));
            $lignereceptions = $this->Lignereception->find('all', array('conditions' => array('Lignereception.bonreception_id' => $id), 'order' => array('Lignereception.id' => 'asc')));


            if ($this->request->data['Bonreception']['importation_id'] != 0) {
                $importations = $this->Importation->find('list', array('conditions' => array('Importation.fournisseur_id' => $this->request->data['Bonreception']['fournisseur_id'], 'Importation.etat' => 0), false));
                $tr = $this->request->data['Importation']['tauxderechenge'];
                $coe = $this->request->data['Importation']['coefficien'];
            }
            if ($this->request->data['Fournisseur']['devise_id'] != 1) {
                $fournisseurs = $this->Bonreception->Fournisseur->find('list');
            } else {
                $fournisseurs = $this->Bonreception->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1)));
            }
            //zeinab
            /* $art = $this->Bonreception->query('
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
              WHERE articlefournisseurs.fournisseur_id =' . $this->request->data['Bonreception']['fournisseur_id'] . '
              AND articles.id = articlefournisseurs.article_id');
              $articles = array();
              foreach ($art as $v) {
              if ($v[0]['codeart'] == $v[0]['refart']) {
              $v[0]['refart'] = "";
              }
              $articles[$v[0]['id']] = $v[0]['refart'] . " " . $v[0]['codeart'] . " " . $v[0]['desart'];
              }
              $articles = $this->Article->find('list'); */
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
        $this->set(compact('comptes', 'pointdeventes', 'datefac', 'importations', 'p', 'coe', 'tr', 'fournisseurs', 'depots', 'lignereceptions', 'day', 'articles'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_achat');
        $bonreception = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $bonreception = $liens['delete'];
                }
            }
        }
        if (( $bonreception <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignereception');
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignefacture');
        $this->loadModel('Article');
        $this->loadModel('Facture');
        $this->loadModel('Bonreception');
        $this->Bonreception->id = $id;
        if (!$this->Bonreception->exists()) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        $this->request->onlyAllow('post', 'delete');

        $lrs = $this->Lignereception->find('all', array('conditions' => array('Lignereception.bonreception_id' => $id), false));
        foreach ($lrs as $lr) {
            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $lr['Lignereception']['article_id'], 'Stockdepot.depot_id' => $lr['Lignereception']['depot_id']), false));
            if (!empty($stckdepot)) {
                $stkdepqte['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] - $lr['Lignereception']['quantite'];
                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stkdepqte['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
            }
        }



        //recalcule pmp 
        $bonreception = $this->Bonreception->find('first', array('conditions' => array('Bonreception.id' => $id), 'recursive' => -1));
        $Lignereceptions = $this->Lignereception->find('all', array('conditions' => array('Lignereception.bonreception_id' => $id), false));
        if (!empty($Lignereceptions)) {
            foreach ($Lignereceptions as $f) {
                $tmps = $this->Bonreception->query(
                        'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
                        FROM (
                        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $f['Lignereception']['article_id'] . ' 
                        and factures.time>=' . '"' . $bonreception['Bonreception']['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $f['Lignereception']['article_id'] . ' 
                        and bonreceptions.time>=' . '"' . $bonreception['Bonreception']['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                        )tmp
                        order BY tmp.time');
                if ($tmps != null) {
                    if (($tmps[count($tmps) - 1]['tmp']['id'] == $f['Lignereception']['id']) && ($tmps[count($tmps) - 1]['tmp']['type'] == 0)) {
                        //nlawej achat eli just 9balh
                        //Si l achat supprimé est la derniére achat
                        //Dernier achat avant l'achat actuelle pour recherche qte et cout ancien
                        $tmps = $this->Bonreception->query(
                                'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
                        FROM (
                        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $f['Lignereception']['article_id'] . ' 
                        and factures.time<' . '"' . $bonreception['Bonreception']['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $f['Lignereception']['article_id'] . ' 
                        and bonreceptions.time<' . '"' . $bonreception['Bonreception']['time'] . '"' . '
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
                            $this->Article->updateAll(array('Article.pmp' => $pmpfinal), array('Article.id' => $f['Lignereception']['article_id']));
                        } else {
                            $rechfirstpmp = $this->Facture->query('SELECT articlepmps.pmp from articlepmps where article_id=' . $f['Lignereception']['article_id']);
                            $dernierpmp = $rechfirstpmp[0]['articlepmps']['pmp'];
                            $this->Article->updateAll(array('Article.pmp' => $dernierpmp), array('Article.id' => $f['Lignereception']['article_id']));
                        }
                    } else {
                        //ligne achat intérmédiaire
                        //$this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite-' . $f['quantite']), array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $cedevi['Bonreception']['depot_id']));
                        $afterachats = $this->Bonreception->query(
                                'SELECT tmpafter.time,tmpafter.qtestkancien,tmpafter.coutstkancien,tmpafter.id,tmpafter.type
                        FROM (
                        (SELECT  factures.time,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
                        FROM  factures,lignefactures
                         where  factures.id=lignefactures.facture_id 
                        and   lignefactures.article_id=' . $f['Lignereception']['article_id'] . ' 
                        and factures.time>' . '"' . $bonreception['Bonreception']['time'] . '"' . '
                        order BY  factures.time
                        )
                        UNION (
                        SELECT  bonreceptions.time,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
                        FROM  bonreceptions,lignereceptions
                        where  bonreceptions.id=lignereceptions.bonreception_id and
                        bonreceptions.facture_id=0 and
                        lignereceptions.article_id=' . $f['Lignereception']['article_id'] . '
                        and bonreceptions.time>' . '"' . $bonreception['Bonreception']['time'] . '"' . '
                        order BY  bonreceptions.time
                        )
                        )tmpafter
                        order BY tmpafter.time');
                        $lignecr = $this->Lignereception->find('first', array('recursive' => 1, 'conditions' => array('Lignereception.id' => $f['Lignereception']['id'])));
                        $afterprix = $lignecr['Lignereception']['coutstkancien'];
                        $afterqte = $lignecr['Lignereception']['qtestkancien'];
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
                        //mettre à jour le nouveau coût de stock
//                                    if ($dernierachattyp == 0) {
//                                        $lignecr = $this->Lignereception->find('first', array('recursive' => 1, 'conditions' => array('Lignereception.id' => $dernierachatid)));
//                                        $qteligne = $lignecr['Lignereception']['quantite'];
//                                        $htligne = $lignecr['Lignereception']['totalht'];
//                                    }
//                                    if ($dernierachattyp == 1) {
//                                        $lignecr = $this->Lignefacture->find('first', array('recursive' => 1, 'conditions' => array('Lignefacture.id' => $dernierachatid)));
//                                        $qteligne = $lignecr['Lignefacture']['quantite'];
//                                        $htligne = $lignecr['Lignefacture']['totalht'];
//                                    }
//                                    if ($afterqte <= 0) {
//                                        $prixstkfinal = $htligne / $qteligne;
//                                    } else {
//                                        $prixstkfinal = ($afterprix * $afterqte + $htligne) / ($qteligne + $afterqte);
//                                    }
                        $this->Article->updateAll(array('Article.pmp' => $afterprix), array('Article.id' => $f['Lignereception']['article_id']));
                    }
                }
            }
        }
        //fin recalcule pmp 
        //******
        $abcd = $this->Bonreception->find('first', array('conditions' => array('Bonreception.id' => $id), 'recursive' => -1));
        $numansar = $abcd['Bonreception']['numero'];
        $pvansar = $abcd['Bonreception']['pointdevente_id'];
        //*******
        //****
        $Lignereceptions = $this->Lignereception->find('all', array('conditions' => array('Lignereception.bonreception_id' => $id), false));
        if (!empty($Lignereceptions)) {
            foreach ($Lignereceptions as $f) {

                $dernierachat = $this->Bonreception->query(
                        'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
        FROM (
        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
        FROM  factures,lignefactures
         where  factures.id=lignefactures.facture_id 
        and   lignefactures.article_id=' . $f['Lignereception']['article_id'] . ' 
        and factures.time>' . '"' . $bonreception['Bonreception']['time'] . '"' . '
        order BY  factures.time
        )
        UNION (
        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
        FROM  bonreceptions,lignereceptions
        where  bonreceptions.id=lignereceptions.bonreception_id and
        bonreceptions.facture_id=0 and
        lignereceptions.article_id=' . $f['Lignereception']['article_id'] . ' 
       and bonreceptions.time>' . '"' . $bonreception['Bonreception']['time'] . '"' . '
        order BY  bonreceptions.time
        )
        )tmp
        order BY tmp.time desc
        limit 1');



                $tmps = $this->Bonreception->query(
                        'SELECT tmp.quantite, tmp.time,tmp.totalht,tmp.qtestkancien,tmp.coutstkancien,tmp.id,tmp.type
        FROM (
        (SELECT  factures.time,lignefactures.quantite,lignefactures.totalht,lignefactures.qtestkancien,lignefactures.coutstkancien,lignefactures.id,1 as type
        FROM  factures,lignefactures
         where  factures.id=lignefactures.facture_id 
        and   lignefactures.article_id=' . $f['Lignereception']['article_id'] . ' 
        and factures.time<' . '"' . $bonreception['Bonreception']['time'] . '"' . '
        order BY  factures.time
        )
        UNION (
        SELECT  bonreceptions.time,lignereceptions.quantite,lignereceptions.totalht,lignereceptions.qtestkancien,lignereceptions.coutstkancien,lignereceptions.id,0 as type
        FROM  bonreceptions,lignereceptions
        where  bonreceptions.id=lignereceptions.bonreception_id and
        bonreceptions.facture_id=0 and
        lignereceptions.article_id=' . $f['Lignereception']['article_id'] . ' 
        and bonreceptions.time<' . '"' . $bonreception['Bonreception']['time'] . '"' . '
        order BY  bonreceptions.time
        )
        )tmp
        order BY tmp.time desc
        limit 1');
                if (empty($dernierachat)) {
                    if (!empty($tmps)) {
                        $prixachat = $tmps[0]['tmp']['totalht'] / $tmps[0]['tmp']['quantite'];
                    } else {
                        $rechfirstpmp = $this->Facture->query('SELECT articlepmps.coutrevient from articlepmps where article_id=' . $f['Lignereception']['article_id']);
                        $prixachat = $rechfirstpmp[0]['articlepmps']['coutrevient'];
                    }
                    $this->Article->updateAll(array('Article.coutrevient' => $prixachat), array('Article.id' => $f['Lignereception']['article_id']));
                }
                $aticle = $this->Article->find('first', array('conditions' => array('Article.id' => $f['Lignereception']['article_id'])));
//                $n_marge = (($aticle['Article']['prixvente'] - $aticle['Article']['pmp']) / $aticle['Article']['pmp']) * 100;
//                $this->Article->updateAll(array('Article.marge' => sprintf('%.3f', $n_marge)), array('Article.id' => $f['Lignereception']['article_id']));
            }
        }
        //****




        if ($this->Bonreception->delete()) {
            //*****
            $this->Lignereception->deleteAll(array('Lignereception.bonreception_id' => $id), false);
            //******
            $this->misejour("Bonreception", $numansar, $id,$pvansar);
            $this->Session->setFlash(__('Bonreception deleted'));
            CakeSession::write('view', "delete");
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Bonreception was not deleted'));
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_achat');
        $bonreception = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $bonreception = $liens['imprimer'];
                }
            }
        }
        if (( $bonreception <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel('Utilisateur');
        // debug($this->request->query);die;
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Bonreception.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Bonreception.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Bonreception.fournisseur_id =' . $fournisseurid;
        }

        if ($this->request->query['transf'] == "0") {
            $transf = $this->request->query['transf'];
            $cond5 = 'Bonreception.facture_id =' . $transf;
        } elseif ($this->request->query['transf'] == "1") {
            $transf = $this->request->query['transf'];
            $cond5 = 'Bonreception.facture_id > ' . $transf;
        }

        $this->loadModel('Utilisateur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $this->loadModel('Personnel');
//        if ($this->request->query['societe_id']) {
//            $societe_id = $this->request->query['societe_id'];
//            $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
//            $ch_pv = 0;
//            foreach ($lespvs as $lespv) {
//                $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
//            }
//            $cond6 = 'Bonreception.pointdevente_id in (' . $ch_pv . ')';
//            $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societe_id)));
//        }
//
//
        if ($this->request->query['pointdevente_id']) {
            $pointdevente_id = $this->request->query['pointdevente_id'];
            $cond7 = 'Bonreception.pointdevente_id =' . $pointdevente_id;
        }
        if ($this->request->query['facturer']) {
            $val = $this->request->query['facturer'];
            if ($val == 1) {
                $cond9 = 'Bonreception.facture_id > 0';
            } elseif ($val == 2) {
                $cond9 = 'Bonreception.facture_id = 0';
            } else {
                $cond9 = '';
            }
        }
//            debug($cond9);die;
        if ($this->request->query['bl_id']) {
            $bl_id = $this->request->query['bl_id'];
            $cond10 = 'Bonreception.id =' . $bl_id;
            $cond1 = "";
            $cond2 = "";
        }
        $bonreceptions = $this->Bonreception->find('all', array('conditions' => array('Bonreception.id > ' => 0, @$cond1, @$cond2, @$cond3, @$cond5, @$cond6, @$cond7, @$cond9, @$cond10)));
        //$fournisseur=$this->Fournisseur->find('first', array( 'conditions' => array('Fournisseur.id'=> $fournisseurid),'recursive'=>-1)) ;
        //debug($fournisseurid);debug($utilisateurid);debug($date1);debug($date2); 
        // debug($bonreceptions);die;
        $this->set(compact('bonreceptions', 'date1', 'date2', 'fournisseurid', 'utilisateurid'));
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
        $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $fournisseurid), false));
        $devise = $fournisseur['Fournisseur']['devise_id'];
        //$name='article_id';
//         $art= $this->Articlefournisseur->find('all',array('conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid),'recursive'=>-1));
//         $t='(0,';
//            foreach ($art as $l){
//                $t=$t.$l['Articlefournisseur']['article_id'].',';
//            }
//         $t=$t.'0)';



        /*  if ($fournisseurid != 0) {
          $art = $this->Bonreception->query('
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
          //debug($art);die;
          //$art= $this->Articlefournisseur->find('all',array('conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid),'recursive'=>0));
          $select = "<select   name='data[Lignereception][0][article_id]' table='Lignereception' index='0' champ='article_id' id='article_id0' class='select form-control idarticle' onchange='tvaart(0)'>";
          $select = $select . "<option value=''>veullier choisir</option>";
          foreach ($art as $v) {
          if ($v[0]['codeart'] == $v[0]['refart']) {
          $v[0]['refart'] = "";
          }
          $select = $select . "<option value=" . $v[0]['id'] . ">" . $v[0]['refart'] . " " . $v[0]['codeart'] . " " . $v[0]['desart'] . "</option>";
          }
          $select = $select . '</select>';
          } else {
          $articles = $this->Article->find('all', array('conditions' => array('Article.typeetatarticle_id' => 1), 'recursive' => -1));
          $select = "<select name='" . $name . "' champ='article_id' id='article_id'  class='' onchange='tvaart(ind) testligneinv'><option selected disabled hidden value=0> Veuillez choisir</option>";
          foreach ($articles as $v) {
          $select = $select . "<option value=" . $v['Article']['id'] . ">" . $v['Article']['name'] . "</option>";
          }
          $select = $select . '</select>';
          }
         */



//            $selectf="<select name='".$name."' table='Lignereception' champ='article_id' id='article_id'  class='' onchange='tvaart(ind) testligneinv'><option selected disabled hidden value=0> Veuillez choisir</option>";
//            $selectf=$selectf."<option value=''>veullier choisir</option>";
//            foreach($articles as $v){
//                $selectf=$selectf."<option value=".$v['Article']['id'].">".$v['Article']['name']."</option>";
//            }
//            $selectf=$selectf.'</select>';


        $importations = $this->Importation->find('all', array('conditions' => array('Importation.fournisseur_id' => $fournisseurid, 'Importation.etat' => 0), false));
        $selecti = "<select name='data[Deviprospect][importation_id]' table='Deviprospect' champ='importation_id' id='importation_id'  class='' onchange='get_tr_coe()'>";
        $selecti = $selecti . "<option value=''>veullier choisir</option>";
        foreach ($importations as $i) {
            $nbrimportations = $this->Deviprospect->find('count', array('conditions' => array('Deviprospect.importation_id' => $i['Importation']['id']), false));
            //debug($nbrimportations);die;
            if ($nbrimportations == 0) {
                $selecti = $selecti . "<option value=" . $i['Importation']['id'] . ">" . $i['Importation']['name'] . "</option>";
            }
        }
        $selecti = $selecti . '</select>';





        //, 'select' => $select
        echo json_encode(array('selecti' => $selecti, 'devise' => $devise));
        die();
    }

    public function getarticles() {
        $this->layout = null;
        $this->loadModel('Article');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Fournisseur');
        //zeinab
        $prixanc = 0;
        $this->loadModel('Lignefacture');
        $this->loadModel('Lignereception');
        $data = $this->request->data; //debug($data);
        $json = null;
        $articleid = $data['id'];
        $fournisseurid = $data['fid'];
        $article = $this->Article->find('first', array('conditions' => array('Article.id' => $articleid), false));
        $frs = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $fournisseurid), false));
        //debug($frs);
        $testartfrs = $this->Articlefournisseur->find('first', array('conditions' => array('Articlefournisseur.fournisseur_id' => $fournisseurid, 'Articlefournisseur.article_id' => $articleid)));

        $tva = $article['Article']['tva'];
        $code = $article['Article']['code'];
        $prixachat = $article['Article']['coutrevient'];
        $marge = $article['Article']['marge'];
        $idart = $article['Article']['id'];
        if ($frs['Fournisseur']['devise_id'] != 1) {
            if (!empty($testartfrs)) {
                $prix = $testartfrs['Articlefournisseur']['prix'];
                $ref = $testartfrs['Articlefournisseur']['reference'];
            } else {
                $prix = "";
                $ref = "";
            }
        } else {
            $prix = $article['Article']['coutrevient'];
            $ref = "";
        }
        //zeinab
        $factures = $this->Lignefacture->find('first', array(
            'conditions' => array('Facture.fournisseur_id' => $fournisseurid, 'Lignefacture.article_id' => $articleid)
            , 'order' => array('Lignefacture.id' => 'desc')
            , 'recursive' => 0));
        //debug($factures);
        if (!empty($factures)) {
            $prixf = $factures['Lignefacture']['prixhtva'];
            $datef = $factures['Facture']['date'];
        } else {
            $prixf = 0;
            $datef = '1900-01-01';
        }
        $receptions = $this->Lignereception->find('first', array(
            'conditions' => array('Bonreception.fournisseur_id' => $fournisseurid, 'Lignereception.article_id' => $articleid)
            , 'order' => array('Lignereception.id' => 'desc')
            , 'recursive' => 0));
        if (!empty($receptions)) {
            $prixr = $receptions['Lignereception']['prixhtva'];
            $dater = $receptions['Bonreception']['date'];
        } else {
            $prixr = 0;
            $dater = '1900-01-01';
        }

        if ($dater > $datef) {
            $prixanc = $prixr;
        } else {
            $prixanc = $prixf;
        }

        echo json_encode(array('prixanc' => $prixanc, 'marge' => $marge, 'prixachat' => $prixachat, 'tva' => $tva, 'prix' => $prix, 'idart' => $idart, 'ref' => $ref, 'code' => $code));
        die();
    }

    public function testnumero() {
        $this->layout = null;
        $data = $this->request->data;
        $numero = $data['numero'];
        $controller = $data['controller'];
		$fournisseur_id = $data['fournisseur_id'];
        $this->loadModel($controller);
        $exist = 0;
        $num = $this->$controller->find('first', array('conditions' => array($controller . '.numerofrs' => $numero,$controller . '.fournisseur_id' => $fournisseur_id), false));
        // debug($Carnet);
        if (!empty($num)) {
            $exist = 1;
        }
        echo $exist;
        die;
    }

    public function recap() {
        $this->loadModel('Article');
        $this->loadModel('Lignedevi');
        $this->loadModel('Commandeclient');
        $this->loadModel('Lignecommandeclient');
        $this->loadModel('Factureclient');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Client');
        $this->loadModel('Articletag');

        $this->layout = null;
        $data = $this->request->data;
        $articleid = $data['article_id'];
        $index_kbira = $data['index'];
        $tableligne = $data['tableligne'];

        $article = $this->Article->find('first', array('conditions' => array('Article.id' => $articleid), false));
        $pv = $article['Article']['prixvente'];
        $marge = $article['Article']['marge'];
        $arttags = $this->Articletag->find('all', array('conditions' => array('Articletag.article_id' => $articleid)));
        $taglist = "";
        foreach ($arttags as $at) {
            $taglist = $taglist . " " . $at['Tag']['name'];
        }


        $this->set(compact('taglist', 'article', 'articleid', 'tableligne', 'pv', 'marge', 'lignelivrisons', 'lignefactures', 'name', 'index_kbira'));
    }

  public function transfertbl_fact() {
        $lien = CakeSession::read('lien_achat');
        $bonreception = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $bonreception = 1;
                }
            }
        }
        if (( $bonreception <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Timbre');
        $this->loadModel('Fournisseur');
        $this->loadModel('Utilisateur');
        $this->loadModel('Exercice');
        $this->loadModel('Lignereception');
        $this->loadModel('Factureavoirfr');
        $this->loadModel('Lignefactureavoirfr');
        $this->loadModel('Facture');
        $this->loadModel('Pointdevente');
        
        
        $exercices = $this->Exercice->find('list');
        $cond4 = 'Bonreception.exercice_id =' . date("Y");
        $cond44 = 'Factureavoirfr.exercice_id =' . date("Y");
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Bonreception.pointdevente_id = ' . $p;
        }
        $cond5 = 'Bonreception.facture_id = 0';
        $cond55 = 'Factureavoirfr.facture_id = 0';

        //debug($this->request->data);die;

        if (@$this->request->data['Bonreception']['facture'] == 'facture') {
            //debug('facture');die;
//            debug($this->request->data);
//            die;
            $this->loadModel('Timbre');
            $this->loadModel('Lignefacture');
            $this->loadModel('Lignereception');
            $bls = $this->Bonreception->find('first', array('fields' => array('Bonreception.pointdevente_id', 'Fournisseur.name', 'SUM(Bonreception.remise) remise', 'SUM(Bonreception.tva) tva', 'SUM(Bonreception.totalht) totalht'
                    , 'SUM(Bonreception.totalttc) totalttc'), 'conditions' => array('Bonreception.id' => $this->request->data['facture']), 'recursive' => 0));

            if (!empty($this->request->data['avoir'])) {
                $avrs = $this->Factureavoirfr->find('first', array('fields' => array('Fournisseur.name', 'SUM(Factureavoirfr.remise) remise', 'SUM(Factureavoirfr.tva) tva', 'SUM(Factureavoirfr.totalht) totalht'
                        , 'SUM(Factureavoirfr.totalttc) totalttc'), 'conditions' => array('Factureavoirfr.model' => 'bl', 'Factureavoirfr.id' => $this->request->data['avoir']), 'recursive' => 0));
                //debug($avrs);die;
            }


            $timbres = $this->Timbre->find('first', array('recursive' => -1));
            $facture = array('');
            $facture['tva'] = $bls[0]['tva'] - @$avrs[0]['tva'];
            $facture['remise'] = $bls[0]['remise'] - @$avrs[0]['remise'];
            $facture['totalht'] = $bls[0]['totalht'] - @$avrs[0]['totalht'];
            $facture['totalttc'] = $bls[0]['totalttc'] - @$avrs[0]['totalttc'] + $timbres['Timbre']['timbre'];
            $facture['timbre_id'] = $timbres['Timbre']['timbre'];
            $facture['name'] = $bls['Fournisseur']['name'];
            $facture['fournisseur_id'] = $this->request->data['Bonreception']['fournisseur_id'];
            $facture['numero'] = $this->request->data['Bonreception']['numero'];
            $facture['numerofrs'] = $this->request->data['Bonreception']['numerofrs'];
            $facture['numeroconca'] = $this->request->data['Bonreception']['numeroconca'];
            $facture['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date'])));
            $facture['datedeclaration'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['datedeclaration'])));
            $facture['exercice_id'] = date("Y", strtotime($facture['date']));
            $facture['utilisateur_id'] = CakeSession::read('users');
            $facture['type'] = 'trans_bl';
            $facture['pointdevente_id'] = $bls['Bonreception']['pointdevente_id'];
            $this->Facture->create();
            $this->Facture->save($facture);
            $fac_id = $this->Facture->id;
            $this->misejour("Facture", "add", $fac_id);
            $lignelivraisons = $this->Lignereception->find('all', array('conditions' => array('Lignereception.bonreception_id' => $this->request->data['facture']), 'recursive' => -1));

            //debug($lignelivraisons);die;
            foreach ($lignelivraisons as $ligne) { //debug($ligne);die;
                $ligne['Lignereception']['facture_id'] = $fac_id;
                $ligne['Lignereception']['bonreception_id'] = $ligne['Lignereception']['bonreception_id'];
                $ligne['Lignereception']['factureavoirfr_id'] = 0;
                $ligne['Lignereception']['id'] = '';
                $this->Lignefacture->create();
                $this->Lignefacture->save($ligne['Lignereception']);
            }

            if (!empty($this->request->data['avoir'])) {
                $ligneavrs = $this->Lignefactureavoirfr->find('all', array('conditions' => array('Lignefactureavoirfr.factureavoirfr_id' => $this->request->data['avoir']), 'recursive' => -1));
                foreach ($ligneavrs as $lignee) { //debug($ligne);die;
                    $lignee['Lignefactureavoirfr']['facture_id'] = $fac_id;
                    $lignee['Lignefactureavoirfr']['bonreception_id'] = 0;
                    $lignee['Lignefactureavoirfr']['factureavoirfr_id'] = $lignee['Lignefactureavoirfr']['factureavoirfr_id'];
                    $lignee['Lignefactureavoirfr']['quantite'] = (($lignee['Lignefactureavoirfr']['quantite']) * -1);
                    $lignee['Lignefactureavoirfr']['id'] = '';
                    $this->Lignefacture->create();
                    $this->Lignefacture->save($lignee['Lignefactureavoirfr']);
                }
            }


            $this->Bonreception->updateAll(array('Bonreception.facture_id' => $fac_id), array('Bonreception.id' => $this->request->data['facture']));
            if (!empty($this->request->data['avoir'])) {
                $this->Factureavoirfr->updateAll(array('Factureavoirfr.facture_id' => $fac_id), array('Factureavoirfr.id' => $this->request->data['avoir']));
            }
            $this->redirect(array('controller'=>'Factures','action' => 'view', $fac_id, 'Facture', 'Lignefacture', 'facture_id'));
        }




        if (@$this->request->data['Bonreception']['facture'] == 'recherche') {
            //debug('recherche');die;
            if ((isset($this->request->data) && !empty($this->request->data)) || ((in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Bonreceptions"))) {
                if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                    CakeSession::write('recherche', $this->request->data['Bonreception']);
                } else {
                    $this->request->data['Bonreception'] = CakeSession::read('recherche');
                }
                // debug($this->request->data);die;
                if ($this->request->data['Bonreception']['exercice_id']) {
                    $exerciceid = $this->request->data['Bonreception']['exercice_id'];
                    $cond4 = 'Bonreception.exercice_id =' . $exercices[$exerciceid];
                    $cond44 = 'Factureavoirfr.exercice_id =' . $exercices[$exerciceid];
                }
                if ($this->request->data['Bonreception']['date1'] != "__/__/____") {
                    $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date1'])));
                    $cond1 = 'Bonreception.date >= ' . "'" . $date1 . "'";
                    $cond11 = 'Factureavoirfr.date >= ' . "'" . $date1 . "'";
                    $cond4 = "";
                    $cond44 = "";
                }

                if ($this->request->data['Bonreception']['date2'] != "__/__/____") {
                    $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date2'])));
                    $cond2 = 'Bonreception.date <= ' . "'" . $date2 . "'";
                    $cond22 = 'Factureavoirfr.date <= ' . "'" . $date2 . "'";
                    $cond4 = "";
                    $cond44 = "";
                }

                if ($this->request->data['Bonreception']['fournisseur_id']) {
                    $fournisseurid = $this->request->data['Bonreception']['fournisseur_id'];
                    $cond3 = 'Bonreception.fournisseur_id =' . $fournisseurid;
                    $cond33 = 'Factureavoirfr.fournisseur_id =' . $fournisseurid;
                }
                if ($this->request->data['Bonreception']['avoirazs_id']) {
                    $avoirazs_id = $this->request->data['Bonreception']['avoirazs_id'];
                    if ($avoirazs_id == 'oui') {
                        $avoirs = $this->Factureavoirfr->find('all', array('conditions' => array('Factureavoirfr.model' => 'bl', @$cond11, @$cond22, @$cond33, @$cond55, @$cond44)));
                        $sommeavoirs = $this->Factureavoirfr->find('all', array('conditions' => array('Factureavoirfr.model' => 'bl', @$cond11, @$cond22, @$cond33, @$cond55, @$cond44), 'fields' => array('SUM(Factureavoirfr.totalttc) totalttc')));
                    }
                }
            }

            $bonreceptions = $this->Bonreception->find('all', array('conditions' => array('Bonreception.id > ' => 0, $pv, @$cond1, @$cond2, @$cond3, @$cond5, @$cond4),'recursive'=>0));
            $sommebonreceptions = $this->Bonreception->find('all', array('conditions' => array('Bonreception.id > ' => 0, $pv, @$cond1, @$cond2, @$cond3, @$cond5, @$cond4), 'fields' => array('SUM(Bonreception.totalttc) totalttc')));
            //debug($bonreceptions);
            //debug($sommebonreceptions);die;
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

        $avoirazs = array();
        $avoirazs['non'] = 'Non';
        $avoirazs['oui'] = 'Oui';

        $timbres = $this->Timbre->find('first', array('recursive' => -1));
        $fournisseurs = $this->Fournisseur->find('list'); //debug($fournisseurs);die;
        $utilisateurs = $this->Utilisateur->find('list');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('pointdeventes','timbres', 'exercices', 'date1', 'mm', 'avoirazs', 'sommebonreceptions', 'sommeavoirs', 'avoirazs_id', 'avoirs', 'sommeavoirs', 'date2', 'fournisseurid', 'utilisateurid', 'transf', 'be', 'transfs', 'bes', 'fournisseurs', 'utilisateurs', 'bonreceptions'));
    }
    public function addblservice() {
        $lien = CakeSession::read('lien_achat');
        $facture = "";

        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $facture = $liens['add'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Bonreception']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date'])));
            $this->request->data['Bonreception']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Bonreception']['pointdevente_id'] = CakeSession::read('pointdevente');
            $this->request->data['Bonreception']['exercice_id'] = date("Y");
            $this->request->data['Bonreception']['type'] = 'service';
            $this->request->data['Bonreception']['importation_id'] = 0;
//            $this->request->data['Bonreception']['importation_id'] = $this->request->data['Facture']['importation_id'];
//            if(empty($this->request->data['Facture']['importation_id'])){
//                $this->request->data['Bonreception']['importation_id']=0;
//            }
            $this->Bonreception->create();
            if ($this->Bonreception->save($this->request->data)) {
                $id = $this->Bonreception->id;
                $this->misejour("Bonreception", "add", $id);

                $this->Session->setFlash(__('The facture has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
            }
        }
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1)));
        $this->set(compact('fournisseurs'));
    }

    public function editblservice($id = null) {
        $this->loadModel('Importation');
        $this->loadModel('Fournisseur');
        $lien = CakeSession::read('lien_achat');
        $facture = "";

        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $facture = $liens['edit'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Bonreception->exists($id)) {
            throw new NotFoundException(__('Invalid etatlignevente'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);die;
            $this->request->data['Bonreception']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreception']['date'])));
            $this->request->data['Bonreception']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Bonreception']['pointdevente_id'] = CakeSession::read('pointdevente');
            $this->request->data['Bonreception']['exercice_id'] = date("Y");
            $this->request->data['Bonreception']['type'] = 'service';
            $this->request->data['Bonreception']['importation_id'] = 0;
//            $this->request->data['Bonreception']['importation_id'] = $this->request->data['Facture']['importation_id'];
//            if(empty($this->request->data['Facture']['importation_id'])){
//                $this->request->data['Bonreception']['importation_id']=0;
//            }


            if ($this->Bonreception->save($this->request->data)) {
                $this->Session->setFlash(__('The etatlignevente has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatlignevente could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
            $this->request->data = $this->Bonreception->find('first', $options);
        }
        $fournisseurs = $this->Fournisseur->find('list', array('conditions' => array('Fournisseur.devise_id' => 1)));

        $fournisseurid = $this->request->data['Bonreception']['fournisseur_id'];
        $cond_four = array('OR' => array(
                'Importation.fournisseuravis' => $fournisseurid
                , 'Importation.fournisseurtransitaire' => $fournisseurid
                , 'Importation.fournisseurddttva' => $fournisseurid
                , 'Importation.fournisseurassurence' => $fournisseurid
                , 'Importation.fournisseurdivers' => $fournisseurid
                , 'Importation.fournisseurfraisfinancie' => $fournisseurid
                , 'Importation.fournisseurmagasinage' => $fournisseurid
            //,'Importation.fournisseur_id' => $fournisseurid
        ));

        $importations = $this->Importation->find('list', array('conditions' => array($cond_four)));
        $this->set(compact('fournisseurs', 'importations'));
    }

    public function imprimerblservice($id = null) {
        $lien = CakeSession::read('lien_achat');
        $facture = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $facture = $liens['imprimer'];
                }
            }
        }
        if (( $facture <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Bonreception->exists($id)) {
            throw new NotFoundException(__('Invalid facture'));
        }
        $options = array('conditions' => array('Bonreception.' . $this->Bonreception->primaryKey => $id));
        $this->set('facture', $this->Bonreception->find('first', $options));
        $facture = $this->Bonreception->find('first', $options);
        $this->set(compact('facture'));
    }

    public function numerobl($val = null) {
        $this->layout = null;
        $tab = explode(' ', $val);
        $ch = "'";
        foreach ($tab as $tabb) {
            $ch = $ch . '%`' . $tabb . '`';
        }
        $ch .= "%'";
        $cond = "Bonreception.numero LIKE " . $ch;
        $numero = $this->Bonreception->find('all', array(
            'conditions' => array($cond),
            'recursive' => -1,
            'fields' => array('Bonreception.id', 'Bonreception.numero'),
            'group' => array('Bonreception.id'),
        ));
//        debug($numero);die;
        echo json_encode(array('numero' => $numero)); // Tableau to JSON <> Json_Decode JOSN TO TABLE 
        die;
    }
//************** zeinab ***********//
    public function imprimerexcel() {
        $lien = CakeSession::read('lien_achat');
        $bonreception = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptions') {
                    $bonreception = $liens['imprimer'];
                }
            }
        }
        if (( $bonreception <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
          $this->layout='';
        $this->loadModel('Fournisseur');
        $this->loadModel('Utilisateur');
        // debug($this->request->query);die;
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Bonreception.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Bonreception.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Bonreception.fournisseur_id =' . $fournisseurid;
        }

        if ($this->request->query['transf'] == "0") {
            $transf = $this->request->query['transf'];
            $cond5 = 'Bonreception.facture_id =' . $transf;
        } elseif ($this->request->query['transf'] == "1") {
            $transf = $this->request->query['transf'];
            $cond5 = 'Bonreception.facture_id > ' . $transf;
        }

        $this->loadModel('Utilisateur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $this->loadModel('Personnel');
//        if ($this->request->query['societe_id']) {
//            $societe_id = $this->request->query['societe_id'];
//            $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
//            $ch_pv = 0;
//            foreach ($lespvs as $lespv) {
//                $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
//            }
//            $cond6 = 'Bonreception.pointdevente_id in (' . $ch_pv . ')';
//            $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societe_id)));
//        }
//
//
        if ($this->request->query['pointdevente_id']) {
            $pointdevente_id = $this->request->query['pointdevente_id'];
            $cond7 = 'Bonreception.pointdevente_id =' . $pointdevente_id;
        }
        if ($this->request->query['facturer']) {
            $val = $this->request->query['facturer'];
            if ($val == 1) {
                $cond9 = 'Bonreception.facture_id > 0';
            } elseif ($val == 2) {
                $cond9 = 'Bonreception.facture_id = 0';
            } else {
                $cond9 = '';
            }
        }
//            debug($cond9);die;
        if ($this->request->query['bl_id']) {
            $bl_id = $this->request->query['bl_id'];
            $cond10 = 'Bonreception.id =' . $bl_id;
            $cond1 = "";
            $cond2 = "";
        }
        $bonreceptions = $this->Bonreception->find('all', array('conditions' => array('Bonreception.id > ' => 0, @$cond1, @$cond2, @$cond3, @$cond5, @$cond6, @$cond7, @$cond9, @$cond10)));
         $this->set(compact('bonreceptions', 'date1', 'date2', 'fournisseurid', 'utilisateurid'));
    }

}
