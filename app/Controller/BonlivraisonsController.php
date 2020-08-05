<?php

App::uses('AppController', 'Controller');

/**
 * Bonlivraisons Controller
 *
 * @property Bonlivraison $Bonlivraison
 */
class BonlivraisonsController extends AppController {

    public function facturation_automatique() {
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
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Mois');
        $this->loadModel('Factureclient');
        $this->loadModel('Lignelivraison');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $mois = $this->Mois->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $cond4 = 'Bonlivraison.exercice_id =' . $exe;
        $pv = "";
        $pvv = 0;
        $p = CakeSession::read('pointdevente');
        //debug($p);die;
        if ($p > 0) {
            $pv = 'Bonlivraison.pointdevente_id = ' . $p;
        }
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Bonlivraisons"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {

                CakeSession::write('recherche', $this->request->data['Bonlivraison']);
            } else {
                $this->request->data['Bonlivraison'] = CakeSession::read('recherche');
            }
//            debug($this->request->data);
//            die;
            if ($this->request->data['Bonlivraison']['facture'] == 'facture') {
                $factures = CakeSession::read('facture_automatique');
//                debug($factures);die;
                $ptv = CakeSession::read('pv');
                $this->loadModel('Timbre');
                $this->loadModel('Factureclient');
                $this->loadModel('Lignefactureclient');
                $this->loadModel('Lignelivraison');
                foreach ($factures as $i => $f) {
                    $numero = $this->Factureclient->find('all', array('fields' => array('MAX(Factureclient.numeroconca) as num'),
                        'conditions' => array('Factureclient.pointdevente_id' => $ptv, 'Factureclient.exercice_id' => $f['Factureclient']['exercice_id']))
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
                    $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $ptv)));
                    $abrivation = $pointvente['Pointdevente']['abriviation'];
                    $f['Factureclient']['numero'] = $abrivation . "/" . $mm . "/" . $f['Factureclient']['exercice_id'];
                    $f['Factureclient']['numeroconca'] = $mm;
                    $this->Factureclient->create();
                    $this->Factureclient->save($f['Factureclient']);
                    $fac_id = $this->Factureclient->id;
                    $this->misejour("Factureclient", "add", $fac_id);
                    foreach ($f['Lignefactureclient'] as $ligne) {
                        $ligne['factureclient_id'] = $fac_id;
                        $this->Lignefactureclient->create();
                        $this->Lignefactureclient->save($ligne);
                        $this->Bonlivraison->updateAll(array('Bonlivraison.factureclient_id' => $fac_id), array('Bonlivraison.id' => $ligne['bonlivraison_id']));
                        $this->misejour("Bonlivraison", "edit", $ligne['bonlivraison_id']);
                    }
                }
                $this->redirect(array('controller' => 'Factureclients', 'action' => 'index/'));
            }
            if ($this->request->data['Bonlivraison']['facture'] == 'recherche') {
                $cond1 = "";
                $cond2 = "";
                $cond3 = "";
                $condnumd = "";
                $condnumf = "";
                if ($this->request->data['Bonlivraison']['date1'] != "__/__/____") {
                    $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonlivraison']['date1'])));
                    $cond1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
                }
                if ($this->request->data['Bonlivraison']['date2'] != "__/__/____") {
                    $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonlivraison']['date2'])));
                    $cond2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
                }

                if ($this->request->data['Bonlivraison']['pointdevente_id']) {
                    $pv = $this->request->data['Bonlivraison']['pointdevente_id'];
                    $condpv = 'Bonlivraison.pointdevente_id =' . $pv;
                }
                if (!empty($this->request->data['Bonlivraison']['bl_debut'])) {
                    $numd = $this->request->data['Bonlivraison']['bl_debut'];
                    $condnumd = 'Bonlivraison.numeroconca >= ' . $numd;
                }

                if (!empty($this->request->data['Bonlivraison']['bl_fin'])) {
                    $numf = $this->request->data['Bonlivraison']['bl_fin'];
                    $condnumf = 'Bonlivraison.numeroconca <=' . $numf;
                }
                if (!empty($this->request->data['Bonlivraison']['clientdebut'])) {
                    $clientd = $this->request->data['Bonlivraison']['clientdebut'];
                    $clt = $this->Client->find('first', array('conditions' => array('Client.id' => $clientd), false));
                    $cond3 = 'Client.code >=' . $clt['Client']['code'];
//                    $cond3 = 'Bonlivraison.client_id =' . $clientd;
//                    $condcld = 'Client.code >=' . $clientd;
                }

                if (!empty($this->request->data['Bonlivraison']['clientfin'])) {
                    $clientf = $this->request->data['Bonlivraison']['clientfin'];
                    $clt = $this->Client->find('first', array('conditions' => array('Client.id' => $clientf), false));
                    $cond33 = 'Bonlivraison.client_id =' . $clientf;
                    //$condclf = 'Client.code <=' . $clientf;
                }
                //if (empty($clientd)) {
                $clients = $this->Bonlivraison->find('all', array(
                    'fields' => array('Bonlivraison.client_id'),
                    'conditions' => array('Bonlivraison.auto LIKE "automatique"', 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id IS NOT NULL', @$condpv, @$cond1, @$cond2, @$condnumd, @$condnumf, @$cond3, @$cond33),
                    'order' => array('cast(Client.code as signed)' => 'ASC'),
                    'group' => array('Bonlivraison.client_id'),
                    'contain' => array('Client'),
                    'recursive' => -1
                ));
                // debug($clients);die;
//                } else {
//                    $clients = $this->Client->find('all', array(
//                        'conditions' => array(@$condcld, @$condclf),
//                        'recursive' => -1,
//                        'fields' => array('Client.id'),
//                        'order' => array('Client.id ASC')));
////                    debug($clients);
////                    die;
//                }
//                debug($clients);
//                die;




                $i = 0;
                $facture = array();
                if (!empty($clients)) {
                    foreach ($clients as $k => $cl) {
                        $this->loadModel('Timbre');
                        $timbres = $this->Timbre->find('first', array('recursive' => -1));
                        $timbremnt = $timbres['Timbre']['timbre'];

                        $clt = $this->Client->find('first', array(
                            'conditions' => array('Client.id' => $cl['Client']['id'])
                            , 'recursive' => -1)
                        );
                        if ($clt['Client']['avectimbre_id'] == 'Non') {
                            $timbremnt = 0;
                        }


                        $condclient = 'Bonlivraison.client_id =' . $cl['Client']['id'];
                        $bonlivraisons = $this->Bonlivraison->find('first', array(
                            'fields' => array('AVG(Bonlivraison.typeclient_id) typeclient_id','SUM(Bonlivraison.remise) remise', 'SUM(Bonlivraison.tva) tva', 'SUM(Bonlivraison.totalht) totalht', 'SUM(Bonlivraison.totalttc) totalttc', 'Client.code', 'Client.name'),
                            'conditions' => array('Bonlivraison.auto LIKE "automatique"', 'Bonlivraison.factureclient_id' => 0, @$condclient, @$condpv, @$cond1, @$cond2, @$condnumd, @$condnumf),
                            'order' => array('Bonlivraison.id' => 'desc'),
                            'contain' => array('Client'),
                            'recursive' => 1
                        ));
                        //debug($bonlivraisons);
                        if (!empty($bonlivraisons[0]['totalttc']) && !empty($bonlivraisons['Client']['id'])) {
                            $facture[$i]['Factureclient']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonlivraison']['date'])));
                            if ($i == 0) {
                                $numero = $this->Factureclient->find('all', array('fields' => array('MAX(Factureclient.numeroconca) as num'),
                                    'conditions' => array('Factureclient.pointdevente_id' => $pv, 'Factureclient.exercice_id' => date("Y", strtotime($facture[$i]['Factureclient']['date']))))
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
                                $facture[$i]['Factureclient']['numero'] = $abrivation . "/" . $mm . "/" . date("Y", strtotime($facture[$i]['Factureclient']['date']));
                                $facture[$i]['Factureclient']['numeroconca'] = $mm;
                            } else {
                                $mm = str_pad($mm + 1, 6, "0", STR_PAD_LEFT);
                                $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
                                $abrivation = $pointvente['Pointdevente']['abriviation'];
                                $facture[$i]['Factureclient']['numero'] = $abrivation . "/" . $mm . "/" . date("Y", strtotime($facture[$i]['Factureclient']['date']));
                                $facture[$i]['Factureclient']['numeroconca'] = $mm;
                            }

                            $facture[$i]['Factureclient']['typeclient_id'] = $bonlivraisons[0]['typeclient_id'];
                            $facture[$i]['Factureclient']['tva'] = $bonlivraisons[0]['tva'];
                            $facture[$i]['Factureclient']['remise'] = $bonlivraisons[0]['remise'];
                            $facture[$i]['Factureclient']['totalht'] = $bonlivraisons[0]['totalht'];
                            $facture[$i]['Factureclient']['totalttc'] = $bonlivraisons[0]['totalttc'] + $timbremnt;
                            $facture[$i]['Factureclient']['timbre_id'] = $timbremnt;
                            $facture[$i]['Factureclient']['client_id'] = $cl['Client']['id'];
                            $facture[$i]['Factureclient']['pointdevente_id'] = $pv;

                            $facture[$i]['Factureclient']['exercice_id'] = date("Y", strtotime($facture[$i]['Factureclient']['date']));
                            $facture[$i]['Factureclient']['source'] = 'bl';
                            $facture[$i]['Factureclient']['utilisateur_id'] = CakeSession::read('users');
                            $facture[$i]['Factureclient']['name'] = $bonlivraisons['Client']['code'] . " " . $bonlivraisons['Client']['name'];
                            $lignelivraisons = $this->Lignelivraison->find('all', array(
                                'fields' => array('Lignelivraison.bonlivraison_id', 'Lignelivraison.article_id', 'Lignelivraison.depot_id',
                                    '(Lignelivraison.article_id) article_iddd', 'id', '(Lignelivraison.designation) designation',
                                    'Lignelivraison.quantite', 'Lignelivraison.remise', 'Lignelivraison.prix', 'Lignelivraison.tva',
                                    'Lignelivraison.totalht', 'Lignelivraison.totalttc', 'Lignelivraison.prixnet', 'Lignelivraison.puttc'),
                                'conditions' => array('Bonlivraison.auto LIKE "automatique"', 'Bonlivraison.factureclient_id' => 0, $condclient, $condpv, $cond1, $cond2, $condnumd, $condnumf),
                            ));
//                        debug($lignelivraisons);
                            foreach ($lignelivraisons as $j => $ligne) {
                                $facture[$i]['Lignefactureclient'][$j]['bonlivraison_id'] = $ligne['Lignelivraison']['bonlivraison_id'];
                                $facture[$i]['Lignefactureclient'][$j]['depot_id'] = $ligne['Lignelivraison']['depot_id'];
                                $facture[$i]['Lignefactureclient'][$j]['article_id'] = $ligne['Lignelivraison']['article_id'];
                                $facture[$i]['Lignefactureclient'][$j]['quantite'] = $ligne['Lignelivraison']['quantite'];
                                $facture[$i]['Lignefactureclient'][$j]['quantitelivrai'] = $ligne['Lignelivraison']['quantite'];
                                $facture[$i]['Lignefactureclient'][$j]['prix'] = $ligne['Lignelivraison']['prix'];
                                $facture[$i]['Lignefactureclient'][$j]['prixnet'] = $ligne['Lignelivraison']['prixnet'];
                                $facture[$i]['Lignefactureclient'][$j]['puttc'] = $ligne['Lignelivraison']['puttc'];
                                $facture[$i]['Lignefactureclient'][$j]['totalhtans'] = $ligne['Lignelivraison']['totalht'];
                                $facture[$i]['Lignefactureclient'][$j]['remise'] = $ligne['Lignelivraison']['remise'];
                                $facture[$i]['Lignefactureclient'][$j]['tva'] = $ligne['Lignelivraison']['tva'];
                                $facture[$i]['Lignefactureclient'][$j]['totalht'] = $ligne['Lignelivraison']['totalht'];
                                $facture[$i]['Lignefactureclient'][$j]['totalttc'] = $ligne['Lignelivraison']['totalttc'];
                                $facture[$i]['Lignefactureclient'][$j]['designation'] = $ligne['Lignelivraison']['designation'];
                            }
                            $i++;
                        }
                    }
                }

                CakeSession::write('facture_automatique', $facture);
                CakeSession::write('pv', $pv);
            }
            // debug($facture);die;
        }
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $clientdebuts = $clientfins = $this->Client->find('list', array(
            'conditions' => array('Client.etat' => 1, 'Client.societe' => $composantsoc)
        ));
        $blfactures = array();
        $blfactures[1] = "Oui";
        $blfactures[2] = "Non";
        $pointdeventees = $this->Pointdevente->find('list');
        $this->set(compact('facture', 'clientfins', 'clientdebuts', 'soummebonlivraisons', 'pointdeventees', 'pvv', 'mois', 'blfactures', 'typedipliquations', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'bonlivraisons'));
    }


    public function index($id = NULL) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonlivraisons') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Client');
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
        $cond4 = 'Bonlivraison.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        //debug($p);die;
        if ($p > 0) {
            $pv = 'Bonlivraison.pointdevente_id = ' . $p;
        }
        $soc = CakeSession::read('soc');
        if ($id) {
            $cond8 = "Bonlivraison.id=" . $id;
        } else {
            $limit = 100;
        }
        $ordre = 'Bonlivraison.id DESC';
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Bonlivraisons"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Recherche']);
            } else {
                $this->request->data['Recherche'] = CakeSession::read('recherche');
            }
//            debug($this->request->data);
//            die;

            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $cond4 = 'Bonlivraison.exercice_id =' . $exercices[$exerciceid];
            }

            if ($this->request->data['Recherche']['date1'] != "__/__/____" && (!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $cond1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
                $cond4 = "";
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" && (!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $cond2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
                $cond4 = "";
            }

            if ($this->request->data['Recherche']['client_id']) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $cond3 = 'Bonlivraison.client_id =' . $clientid;
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
                $cond6 = 'Bonlivraison.pointdevente_id in (' . $ch_pv . ')';
                $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societe_id)));
            }


            if ($this->request->data['Recherche']['pointdevente_id']) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                $cond7 = 'Bonlivraison.pointdevente_id =' . $pointdevente_id;
            }
            if ($this->request->data['Recherche']['facturer']) {

                $val = $this->request->data['Recherche']['facturer'];
                if ($val == 1) {
                    $cond9 = 'Bonlivraison.factureclient_id > 0';
                } elseif ($val == 2) {
                    $cond9 = 'Bonlivraison.factureclient_id = 0';
                } else {
                    $cond9 = '';
                }
            }
//            debug($cond9);die;
            if ($this->request->data['Recherche']['bl_id']) {
                $bl_id = $this->request->data['Recherche']['bl_id'];
                $cond10 = 'Bonlivraison.id =' . $bl_id;
                $cond1 = "";
                $cond2 = "";
                $cond4 = "";
                $cond9 = '';
            }

            if ($this->request->data['Recherche']['order_id']) {
                $order_id = $this->request->data['Recherche']['order_id'];
                if($order_id==1){
                $ordre = 'Bonlivraison.numeroconca,Bonlivraison.exercice_id DESC';
                }
                if($order_id==2){
                $ordre = 'Client.code ASC';
                }
                if($order_id==3){
                $ordre = 'Bonlivraison.date ASC';
                }
            }

            $limit = 1000000;
            $cond8 = "";
        }
        $bonlivraisons = $this->Bonlivraison->find('all', array('conditions' => array($pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, @$cond8, @$cond9, @$cond10)
            , 'order' => array($ordre)
            , 'limit' => @$limit
            , 'recursive' => 0
            , 'contain' => array('Client','Factureclient')
        ));
        $this->loadModel('Typedipliquation');
        $typedipliquations = $this->Typedipliquation->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.etat' => 1, 'Client.societe' => $composantsoc)
        ));
        $societes = $this->Societe->find('list', array('conditions' => array('Societe.id in (' . $soc . ')')));
        $facturers = array();
        $facturers[1] = "OUI";
        $facturers[2] = "NON";
        $orders=array();
        $orders[1]="Par Numero";
        $orders[2]="Par Code Client";
        $orders[3]="Par Date";
        $this->set(compact('order_id','ordre','orders','val', 'bl_id', 'facturers', 'typedipliquations', 'societes', 'pointdeventes', 'pointdevente_id', 'societe_id', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'bonlivraisons'));
    }

    public function indexx() {
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
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Mois');
        $this->loadModel('Depot');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $mois = $this->Mois->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $cond4 = 'Bonlivraison.exercice_id =' . $exe;
        $pv = "";
        $pvv = 0;
        $p = CakeSession::read('pointdevente');
        //debug($p);die;
        if ($p > 0) {
            $pv = 'Bonlivraison.pointdevente_id = ' . $p;
        }
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Bonlivraisons"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {

                CakeSession::write('recherche', $this->request->data['Bonlivraison']);
            } else {
                $this->request->data['Bonlivraison'] = CakeSession::read('recherche');
            }

            //debug($this->request->data);die;



            if ($this->request->data['Bonlivraison']['facture'] == 'facture') {
                // debug($this->request->data);die;
                $this->loadModel('Timbre');
                $this->loadModel('Factureclient');
                $this->loadModel('Lignefactureclient');
                $this->loadModel('Lignelivraison');
                $bls = $this->Bonlivraison->find('first', array('fields' => array('AVG(Bonlivraison.typeclient_id) typeclient_id','pointdevente_id', 'depot_id', 'Client.name', 'SUM(Bonlivraison.remise) remise', 'SUM(Bonlivraison.tva) tva', 'SUM(Bonlivraison.totalht) totalht'
                        , 'SUM(Bonlivraison.totalttc) totalttc'), 'conditions' => array('Bonlivraison.id' => $this->request->data['facture']), 'recursive' => 0));
                $timbres = $this->Timbre->find('first', array('recursive' => -1));
                $facture = array('');
                //$facture['depot_id'] = $this->request->data['Bonlivraison']['depott_id'];
                $timbremnt = $timbres['Timbre']['timbre'];
                $clt = $this->Client->find('first', array(
                    'conditions' => array('Client.id' => $this->request->data['Bonlivraison']['client_id'])
                    , 'recursive' => -1)
                );
                if ($clt['Client']['avectimbre_id'] == 'Non') {
                    $timbremnt = 0;
                }
                $facture['typeclient_id'] = $bls[0]['typeclient_id'];
                $facture['tva'] = $bls[0]['tva'];
                $facture['remise'] = $bls[0]['remise'];
                $facture['totalht'] = $bls[0]['totalht'];
                $facture['totalttc'] = $bls[0]['totalttc'] + $timbremnt;
                $facture['timbre_id'] = $timbremnt;
                $facture['name'] = $bls['Client']['name'];
                $facture['client_id'] = $this->request->data['Bonlivraison']['client_id'];
                $facture['numero'] = $this->request->data['Bonlivraison']['numero'];
                $facture['numeroconca'] = $this->request->data['Bonlivraison']['numeroconca'];
                $facture['pointdevente_id'] = $this->request->data['Bonlivraison']['pointdeventee_id'];
                $facture['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonlivraison']['date'])));
                $facture['exercice_id'] = date("Y", strtotime($facture['date']));
                $facture['source'] = 'bl';
                $facture['utilisateur_id'] = CakeSession::read('users');
                $this->Factureclient->create();
                $this->Factureclient->save($facture);
                $fac_id = $this->Factureclient->id;
                $this->misejour("Factureclient", "add", $fac_id);
                $lignelivraisons = $this->Lignelivraison->find('all', array('fields' => array('Lignelivraison.bonlivraison_id', 'Lignelivraison.article_id', 'Lignelivraison.depot_id', '(Lignelivraison.article_id) article_iddd', 'id', '(Lignelivraison.designation) designation'
                        , 'Lignelivraison.quantite', 'Lignelivraison.remise', 'Lignelivraison.prix'
                        , 'Lignelivraison.tva', 'Lignelivraison.totalht', 'Lignelivraison.totalttc', 'Lignelivraison.prixnet', 'Lignelivraison.puttc')
                    , 'conditions' => array('Lignelivraison.bonlivraison_id' => $this->request->data['facture']), 'recursive' => 0
                    , 'order' => array('Lignelivraison.id' => 'ASC')
                ));
                foreach ($lignelivraisons as $ligne) {
                    $lig = array();
                    $lig['factureclient_id'] = $fac_id;
                    $lig['bonlivraison_id'] = $ligne['Lignelivraison']['bonlivraison_id'];
                    $lig['depot_id'] = $ligne['Lignelivraison']['depot_id'];
                    $lig['article_id'] = $ligne['Lignelivraison']['article_id'];
                    $lig['quantite'] = $ligne['Lignelivraison']['quantite'];
                    $lig['quantitelivrai'] = $ligne['Lignelivraison']['quantite'];
                    $lig['prix'] = $ligne['Lignelivraison']['prix'];
                    $lig['prixnet'] = $ligne['Lignelivraison']['prixnet'];
                    $lig['puttc'] = $ligne['Lignelivraison']['puttc'];
                    $lig['totalhtans'] = $ligne['Lignelivraison']['totalht'];
                    $lig['remise'] = $ligne['Lignelivraison']['remise'];
                    $lig['tva'] = $ligne['Lignelivraison']['tva'];
                    $lig['totalht'] = $ligne['Lignelivraison']['totalht'];
                    $lig['totalttc'] = $ligne['Lignelivraison']['totalttc'];
                    $lig['designation'] = $ligne['Lignelivraison']['designation'];
                    $this->Lignefactureclient->create();
                    $this->Lignefactureclient->save($lig);
                }
                $this->Bonlivraison->updateAll(array('Bonlivraison.factureclient_id' => $fac_id), array('Bonlivraison.id' => $this->request->data['facture']));
                foreach ($this->request->data['facture'] as $l) {
                $this->misejour("Bonlivraison", "edit", $l);
                }
                $this->redirect(array('controller' => 'Factureclients', 'action' => 'view/' . $fac_id));
            }
            if ($this->request->data['Bonlivraison']['facture'] == 'recherche') {
                $pvv = 1;
                if ($this->request->data['Bonlivraison']['exercice_id']) {
                    $exerciceid = $this->request->data['Bonlivraison']['exercice_id'];
                    $cond4 = 'Bonlivraison.exercice_id =' . $exercices[$exerciceid];
                }
                if (!empty($this->request->data['Bonlivraison']['mois_id'])) {
                    $moiss = $this->request->data['Bonlivraison']['mois_id'];
                    $cond7 = 'MONTH(Bonlivraison.date) = ' . $moiss;
                }
                if ($this->request->data['Bonlivraison']['date1'] != "__/__/____") {
                    $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonlivraison']['date1'])));
                    $cond1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
                    $cond4 = "";
                    $cond7 = "";
                }

                if ($this->request->data['Bonlivraison']['date2'] != "__/__/____") {
                    $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonlivraison']['date2'])));
                    $cond2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
                    $cond4 = "";
                    $cond7 = "";
                }

                if ($this->request->data['Bonlivraison']['client_id']) {
                    $clientid = $this->request->data['Bonlivraison']['client_id'];
                    $cond3 = 'Bonlivraison.client_id =' . $clientid;
                }

                if ($this->request->data['Bonlivraison']['pointdevente_id']) {
                    $pointdeventeid = $this->request->data['Bonlivraison']['pointdevente_id'];
                    $cond5 = 'Bonlivraison.pointdevente_id =' . $pointdeventeid;
                }

                $bonlivraisons = $this->Bonlivraison->find('all', array('conditions' => array('Bonlivraison.factureclient_id' => 0, $pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond7)
                    , 'order' => array('Bonlivraison.id' => 'desc')));

                $soummebonlivraisons = $this->Bonlivraison->find('all', array(
                    'fields' => array('SUM(Bonlivraison.totalttc) totalttc')
                    , 'conditions' => array('Bonlivraison.factureclient_id' => 0
                        , $pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond7)
                    , 'order' => array('Bonlivraison.numero' => 'desc')));
                //debug($soummebonlivraisons);die;
            }
        }

        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.etat' => 1, 'Client.societe' => $composantsoc)
        ));
        $blfactures = array();
        $blfactures[1] = "Oui";
        $blfactures[2] = "Non";
        $pointdeventees = $this->Pointdevente->find('list');
        $depotts = $this->Depot->find('list');
        $this->set(compact('depotts', 'soummebonlivraisons', 'pointdeventees', 'pvv', 'mois', 'blfactures', 'typedipliquations', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'bonlivraisons'));
    }

   public function imprimerrecherche() {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonlivraisons') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Client');
        //debug($this->request->query);die;
         $this->loadModel('Exercice');
        $exercices = $this->Exercice->find('list');
        $ordre = 'Bonlivraison.numeroconca,Bonlivraison.exercice_id DESC';
        if (!empty($this->request->query['exerciceid'])) {
                $exerciceid = $this->request->query['exerciceid'];
                $cond4 = 'Bonlivraison.exercice_id =' . $exercices[$exerciceid];
        }


        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            $cond3 = 'Bonlivraison.client_id =' . $clientid;
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
            $cond6 = 'Bonlivraison.pointdevente_id in (' . $ch_pv . ')';
        }

        if ($this->request->query['pointdevente_id']) {
            $pointdevente_id = $this->request->query['pointdevente_id'];
            $cond7 = 'Bonlivraison.pointdevente_id =' . $pointdevente_id;
        }
        if ($this->request->query['facturer']) {

            $val = $this->request->query['facturer'];
            if ($val == 1) {
                $cond9 = 'Bonlivraison.factureclient_id > 0';
            } elseif ($val == 2) {
                $cond9 = 'Bonlivraison.factureclient_id = 0';
            } else {
                $cond9 = '';
            }
        }

        if ($this->request->query['order']) {
            $order_id = $this->request->query['order'];
                if($order_id==1){
                $ordre = 'Bonlivraison.numeroconca,Bonlivraison.exercice_id DESC';
                }
                if($order_id==2){
                $ordre = 'Client.code ASC';
                }
                if($order_id==3){
                $ordre = 'Bonlivraison.date ASC';
                }

        }

//            debug($cond9);die;
//        if ($this->request->query['bl_id']) {
//            $bl_id = $this->request->query['bl_id'];
//            $cond10 = 'Bonlivraison.id =' . $bl_id;
//            $cond1 = "";
//            $cond2 = "";
//        }

        $bonlivraisons = $this->Bonlivraison->find('all',
        array('conditions' => array( 'Bonlivraison.id >0',@$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, @$cond9, @$cond10)
        ,'recursive'=>0,
        'order'=>array(@$ordre)));
        //debug($bonlivraisons);die;
        $this->set(compact('bonlivraisons', 'date1', 'date2', 'clientid'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonlivraisons') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignelivraison');
        if (!$this->Bonlivraison->exists($id)) {
            throw new NotFoundException(__('Invalid bonlivraison'));
        }
        $options = array('conditions' => array('Bonlivraison.' . $this->Bonlivraison->primaryKey => $id));
        $this->set('bonlivraison', $this->Bonlivraison->find('first', $options));
        $lignelivraisons = $this->Lignelivraison->find('all', array(
            'conditions' => array('Lignelivraison.bonlivraison_id' => $id)
        ));
        $this->set(compact('lignelivraisons'));
    }

    public function imprimer($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonlivraisons') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignelivraison');
        if (!$this->Bonlivraison->exists($id)) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        $options = array('conditions' => array('Bonlivraison.' . $this->Bonlivraison->primaryKey => $id));
        $this->set('bonlivraison', $this->Bonlivraison->find('first', $options));
        $lignelivraisons = $this->Lignelivraison->find('all', array(
            'conditions' => array('Lignelivraison.bonlivraison_id' => $id)
        ));
        $this->set(compact('lignelivraisons'));
    }

    public function add() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonlivraisons') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Bonlivraison']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonlivraison']['date'])));
            $this->request->data['Bonlivraison']['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data['Bonlivraison']['pointdevente_id'])) {
                $this->request->data['Bonlivraison']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Bonlivraison']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Bonlivraison']['pointdevente_id'];
            }
            $numero = $this->Bonlivraison->find('all', array('fields' => array('MAX(Bonlivraison.numeroconca) as num'),
                'conditions' => array('Bonlivraison.pointdevente_id' => $pv, 'Bonlivraison.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.numeroconca'=>$n)));
//  $anne=$getexercice['Bonlivraison']['exercice_id'];
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
            $this->request->data['Bonlivraison']['numeroconca'] = $mm;
            $this->request->data['Bonlivraison']['numero'] = $numspecial;
            $this->Bonlivraison->create();
            if (!empty($this->request->data['Lignelivraison'])) {
                if ($this->Bonlivraison->save($this->request->data)) {
                    $id = $this->Bonlivraison->id;
                    $this->misejour("Bonlivraison", "add", $id);
                    // debug($id);die;
                    $Lignelivraisons = array();
                    $stockdepots = array();
                    foreach ($this->request->data['Lignelivraison'] as $numl => $f) {

                        //  debug($f);die;
                        if ($f['sup'] != 1) {

                            $stockdepots[$numl]['quantite'] = $f['quantite'];
                            $Lignelivraisons['bonlivraison_id'] = $id;
                            $Lignelivraisons['depot_id'] = $f['depot_id'];
                            $Lignelivraisons['article_id'] = $f['article_id'];
                            $Lignelivraisons['quantite'] = $f['quantite'];
                            $Lignelivraisons['remise'] = $f['remise'];
                            $Lignelivraisons['tva'] = $f['tva'];
                            $Lignelivraisons['prix'] = $f['prixhtva'];
                            $Lignelivraisons['prixnet'] = $f['prixnet'];
                            $Lignelivraisons['puttc'] = $f['puttc'];
                            $Lignelivraisons['totalhtans'] = $f['totalhtans'];
                            $Lignelivraisons['designation'] = $f['designation'];
                            $Lignelivraisons['totalht'] = $f['totalht'];
                            $Lignelivraisons['totalttc'] = $f['totalttc'];

                            $this->Lignelivraison->create();
                            $this->Lignelivraison->save($Lignelivraisons);


                            $id_ligne = $this->Lignelivraison->id;
                            $qte_sorti = $f['quantite'];
                            while ($qte_sorti > 0) {
                                $stckdepot = $this->Stockdepot->find('first', array(
                                    'conditions' => array('Stockdepot.article_id' => $f['article_id'],
                                        'Stockdepot.depot_id' => $f['depot_id'], 'Stockdepot.quantite >' => 0), false));
                                //debug($stckdepot);
                                if ($qte_sorti < $stckdepot['Stockdepot']['quantite']) {
                                    $qte = $stckdepot['Stockdepot']['quantite'] - $qte_sorti;
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    $this->loadModel('Stockdepotfacture');
                                    $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                    $tab['id_piece'] = $id;
                                    $tab['piece'] = "Bonlivraison";
                                    $tab['qte'] = $qte_sorti;
                                    $tab['ligne'] = $id_ligne;
                                    $this->Stockdepotfacture->create();
                                    $this->Stockdepotfacture->save($tab);
                                    $qte_sorti = 0;
                                } else {
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 0), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    $qte_sorti = $qte_sorti - $stckdepot['Stockdepot']['quantite'];
                                    $this->loadModel('Stockdepotfacture');
                                    $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                    $tab['id_piece'] = $id;
                                    $tab['piece'] = "Bonlivraison";
                                    $tab['ligne'] = $id_ligne;
                                    $tab['qte'] = $stckdepot['Stockdepot']['quantite'];
                                    $this->Stockdepotfacture->create();
                                    $this->Stockdepotfacture->save($tab);
                                }
                            }


//                            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
//                            if (!empty($stckdepot)) {
//                                $stockdepots[$numl]['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] - $stockdepots[$numl]['quantite'];
//                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
//                            }
                            //$this->stock($f['depot_id'], $f['article_id']);
                            //$this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
                        }
                    }

                    $this->Session->setFlash(__('The bonlivraison has been saved'));
                    $this->redirect(array('action' => 'index'));
                    //$this->redirect(array('action' => 'addbonsorti/'.$id));
                } else {
                    $this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                }
            }
        }
        $pv = CakeSession::read('pointdevente');
        //debug($pv);die;
        if ($pv != 0) {
            $numero = $this->Bonlivraison->find('all', array('fields' => array('MAX(Bonlivraison.numeroconca) as num'),
                'conditions' => array('Bonlivraison.pointdevente_id' => $pv, 'Bonlivraison.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.numeroconca'=>$n)));
//  $anne=$getexercice['Bonlivraison']['exercice_id'];
//  if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }
//
            } else {
                $mm = "000001";
            }

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            //debug($pointvente);die;
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            $mm = 0;
        }
        $clients = $this->Bonlivraison->Client->find('list');
        $utilisateurs = $this->Bonlivraison->Utilisateur->find('list');
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.id' => $p)));
        }
        //$articles = $this->Article->find('list', array('conditions' => array('Article.typeetatarticle_id' => 1), 'recursive' => -1));
        $pointdeventes = $this->Pointdevente->find('list');
        $this->set(compact('pointdeventes', 'numspecial', 'clients', 'utilisateurs', 'depots', 'articles', 'mm'));
    }

    //jeya mel commande
    public function addindirect($tab = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonlivraisons') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        // debug($tab);die;
        $this->loadModel('Reglementclient');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignecommandeclient');
        $this->loadModel('Commandeclient');
        $this->loadModel('Client');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
        $tbr = $tab . ',0)';
        list($idbr, $resteidbr) = explode(",", $tbr);
        $tbr = '(0,' . $tbr;
        // debug($idbr);die;
        $idlcs = array();
        $idlcs = explode(",", $tab);


        $clientid = $this->Commandeclient->find('first', array('fields' => array('pointdevente_id', 'SUM(Commandeclient.remise) remise', 'SUM(Commandeclient.tva) tva', 'SUM(Commandeclient.totalht) totalht'
                , 'SUM(Commandeclient.totalttc) totalttc', 'AVG(Commandeclient.client_id) client_id'), 'conditions' => array('Commandeclient.id' => $idlcs), 'recursive' => -1));
        //debug($clientid);die;

        $lignelivraisons = $this->Lignecommandeclient->find('all', array('fields' => array('AVG(Lignecommandeclient.article_id) article_id', 'AVG(Lignecommandeclient.depot_id) depot_id', '(Lignecommandeclient.article_id) article_iddd', '(Lignecommandeclient.depot_id) depot_id', '(Lignecommandeclient.id) id'
                , 'SUM(Lignecommandeclient.quantite) quantite', 'SUM(Lignecommandeclient.quantiteliv) quantiteliv', 'SUM(Lignecommandeclient.remise*Lignecommandeclient.quantite) remise', 'SUM(Lignecommandeclient.prix*Lignecommandeclient.quantite) prix'
                , 'AVG(Lignecommandeclient.tva) tva', 'SUM(Lignecommandeclient.totalht) totalht', 'SUM(Lignecommandeclient.totalttc)totalttc', 'SUM(Lignecommandeclient.prixnet*Lignecommandeclient.quantite) prixnet', 'SUM(Lignecommandeclient.puttc*Lignecommandeclient.quantite) puttc')
            , 'conditions' => array('Lignecommandeclient.commandeclient_id in' . $tbr), 'recursive' => -1
            , 'group' => array('Lignecommandeclient.article_id', 'Lignecommandeclient.depot_id', 'Lignecommandeclient.commandeclient_id')));

        //debug($lignelivraisons);die;


        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Bonlivraison']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonlivraison']['date'])));
            $this->request->data['Bonlivraison']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Bonlivraison']['client_id'] = $clientid[0]['client_id'];
            $this->request->data['Bonlivraison']['commandeclient_id'] = $tab;
            if (empty($this->request->data['Bonlivraison']['pointdevente_id'])) {
                $this->request->data['Bonlivraison']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Bonlivraison']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Bonlivraison']['pointdevente_id'];
            }
            $numero = $this->Bonlivraison->find('all', array('fields' => array('MAX(Bonlivraison.numeroconca) as num'),
                'conditions' => array('Bonlivraison.pointdevente_id' => $pv, 'Bonlivraison.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.numeroconca'=>$n)));
//  $anne=$getexercice['Bonlivraison']['exercice_id'];
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

            $this->request->data['Bonlivraison']['numeroconca'] = $mm;
            $this->request->data['Bonlivraison']['numero'] = $numspecial;
            $this->Bonlivraison->create();
            if (!empty($this->request->data['Lignelivraison'])) {
                if ($this->Bonlivraison->save($this->request->data)) {
                    foreach ($idlcs as $idc) {
                        $this->Commandeclient->updateAll(array('Commandeclient.etat' => 1), array('Commandeclient.id' => $idc));
                    }
                    $id = $this->Bonlivraison->id;
                    $this->misejour("Bonlivraison", "add", $id);
                    // debug($id);die;
                    $Lignelivraisons = array();
                    $stockdepots = array();
                    //debug($this->request->data );die;
                    foreach ($this->request->data['Lignelivraison'] as $numl => $f) {

                        //debug($f);die;
                        if ($f['sup'] != 1) {
                            $Lignelivraisons['lignecommandeclient_id'] = $f['id'];
                            $stockdepots[$numl]['quantite'] = $f['quantiteliv'];
                            $Lignelivraisons['bonlivraison_id'] = $id;
                            $Lignelivraisons['depot_id'] = $f['depot_id'];
                            $Lignelivraisons['article_id'] = $f['article_id'];
                            $Lignelivraisons['quantite'] = $f['quantiteliv'];
                            $Lignelivraisons['quantitelivrai'] = $f['quantiteliv'];
                            $stockdepots[$numl]['quantiteliv'] = $f['quantiteliv'];
                            $Lignelivraisons['remise'] = $f['remise'];
                            $Lignelivraisons['tva'] = $f['tva'];
                            $Lignelivraisons['prix'] = $f['prixhtva'];
                            $Lignelivraisons['prixnet'] = $f['prixnet'];
                            $Lignelivraisons['puttc'] = $f['puttc'];
                            $Lignelivraisons['totalhtans'] = $f['totalhtans'];
                            $Lignelivraisons['totalht'] = $f['totalht'];
                            $Lignelivraisons['totalttc'] = $f['totalttc'];
                            $this->Lignelivraison->create();
                            $this->Lignelivraison->save($Lignelivraisons);


                            $this->Lignecommandeclient->updateAll(array('Lignecommandeclient.quantiteliv' => 'Lignecommandeclient.quantiteliv +' . $f['quantiteliv']), array('Lignecommandeclient.id' => $f['id']));


                            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
                            if (!empty($stckdepot)) {
                                $stockdepots[$numl]['quantiteliv'] = $stckdepot[0]['Stockdepot']['quantite'] - $stockdepots[$numl]['quantiteliv'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantiteliv']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                            }
                            //$this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
                            $this->stock($f['depot_id'], $f['article_id']);
                        }
                    }
                    $this->Session->setFlash(__('The bonlivraison has been saved'));
                    //$this->redirect(array('action' => 'addbonsorti/'.$id));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                }
            }
        }

        $pv = CakeSession::read('pointdevente');
        if ($pv == 0) {
            $pv = $clientid['Commandeclient']['pointdevente_id'];
        }
        $numero = $this->Bonlivraison->find('all', array('fields' => array('MAX(Bonlivraison.numeroconca) as num'),
            'conditions' => array('Bonlivraison.pointdevente_id' => $pv, 'Bonlivraison.exercice_id' => date("Y")))
        );
        //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        if (!empty($n)) {
//   $getexercice= $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.numeroconca'=>$n)));
//  $anne=$getexercice['Bonlivraison']['exercice_id'];
//  if ($anne==date("Y")){
            $lastnum = $n;
            $nume = intval($lastnum) + 1;
            $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }
//
        } else {
            $mm = "000001";
        }

        $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));

        $abrivation = $pointvente['Pointdevente']['abriviation'];
        $numspecial = $abrivation . "/" . $mm . "/" . date("Y");



        //**************************************trouver la liste des articles pour chaque depot *******************************************************
//        foreach ($lignelivraisons as $ll) {
//            $artdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $ll[0]['depot_id']), 'recursive' => -1));
//            $t = '(0';
//            foreach ($artdepot as $ad) {
//                if (!empty($ad['Stockdepot']['article_id'])) {
//                    $t = $t . ',' . $ad['Stockdepot']['article_id'];
//                }
//            }
//            $t = $t . ')';
//
//            $articles = $this->Article->find('list', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
//            $tabqtestock[$ll[0]['depot_id']]['articles'] = $articles;
//
//            //**************************************trouver les qte en stock de chaque article pour chaque depot *******************************************************
//
//            $artstocks = $this->Article->find('all', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
//            //debug($artstocks);die;
//            foreach ($artstocks as $i => $as) {
//                $qtestock = 0;
//                $stockdepots = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $as['Article']['id'],
//                        'Stockdepot.depot_id' => $ll[0]['depot_id']), false));
//                foreach ($stockdepots as $stkdepot) {
//                    $qtestock = $qtestock + $stkdepot['Stockdepot']['quantite'];
//                }
//                $tabqtestock[$ll[0]['depot_id']][$as['Article']['id']]['qtestock'] = $qtestock;
//            }
//        }
        //******************************************fin***********************************************************************************************************
        // debug($tabqtestock);die;
        //debug($tabqtestock['1.0000'][1]['qtestock']);die;





        $client = $this->Client->find('first', array('conditions' => array('Client.id' => $clientid[0]['client_id']), 'recursive' => -2));
        $pntv = $clientid['Commandeclient']['pointdevente_id'];
        $client = $client['Client']['name'];
        $utilisateurs = $this->Bonlivraison->Utilisateur->find('list');
        //$articles = $this->Article->find('list', array('conditions' => array('Article.typeetatarticle_id' => 1), 'recursive' => -1));
        $pointdeventes = $this->Pointdevente->find('list');
        $clients = $this->Bonlivraison->Client->find('list');

        //****************************************************************************************************************************************************


        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Client');


        $client = $this->Client->find('all', array('conditions' => array('Client.id' => $clientid[0]['client_id']), false));
        $adresse = $client[0]['Client']['adresse'];
        $name = $client[0]['Client']['name'];
        $matriculefiscale = $client[0]['Client']['matriculefiscale'];
        $autorisation = $client[0]['Client']['autorisation'];
        $typeclient_id = $client[0]['Client']['typeclient_id'];

        $sumttc = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.totalttc) as totalttcb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid[0]['client_id'])));
        $summtreg = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.Montant_Regler) as totalregb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid[0]['client_id'])));
        $sumttcf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.totalttc) as totalttf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid[0]['client_id'])));
        $summtregf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.Montant_Regler) as totalregf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid[0]['client_id'])));
        $reglementlibre = $this->Reglementclient->find('all', array('fields' => array('sum(Reglementclient.Montant) as reglibretotale')
            , 'conditions' => array('Reglementclient.type  ' => 1, 'Reglementclient.affectation_id  ' => 0, 'Reglementclient.client_id' => $clientid[0]['client_id'])));
        $valbl = $sumttc[0][0]['totalttcb'] - $summtreg[0][0]['totalregb'];
        $valfac = $sumttcf[0][0]['totalttf'] - $summtregf[0][0]['totalregf'];
        $valglobal = $valbl + $valfac;
        $solde = $valglobal - $reglementlibre[0][0]['reglibretotale'];
        $valreste = $autorisation - ($valglobal - $reglementlibre[0][0]['reglibretotale']);
        //fin info client************************************************
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Bonlivraison->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Bonlivraison->Depot->find('list', array('conditions' => array('Depot.id' => $p)));
        }



        $this->set(compact('typeclient_id', 'name', 'autorisation', 'solde', 'clientid', 'tabqtestock', 'articles', 'depots', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'pntv', 'clients', 'client', 'utilisateurs', 'articles', 'mm', 'lignelivraisons', 'numspecial', 'timbre'));
    }

    //jeya mel devie
    public function addbonindirect($tab = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonlivraisons') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        // debug($tab);die;
        $this->loadModel('Reglementclient');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignedevi');
        $this->loadModel('Devi');
        $this->loadModel('Client');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
        $tbr = $tab . ',0)';
        list($idbr, $resteidbr) = explode(",", $tbr);
        $tbr = '(0,' . $tbr;
        // debug($idbr);die;
        $idlcs = array();
        $idlcs = explode(",", $tab);

        $clientid = $this->Devi->find('first', array('fields' => array('pointdevente_id', 'SUM(Devi.remise) remise', 'SUM(Devi.tva) tva', 'SUM(Devi.totalht) totalht'
                , 'SUM(Devi.totalttc) totalttc', 'AVG(Devi.client_id) client_id'), 'conditions' => array('Devi.id' => $idlcs), 'recursive' => -2));
        //debug($clientid);die;

        $lignelivraisons = $this->Lignedevi->find('all', array('fields' => array('AVG(Lignedevi.article_id) article_id', 'AVG(Lignedevi.depot_id) depot_id', '(Lignedevi.article_id) article_iddd', '(Lignedevi.depot_id) depot_id'
                , 'SUM(Lignedevi.quantite) quantite', 'SUM(Lignedevi.remise*Lignedevi.quantite) remise', 'SUM(Lignedevi.prix*Lignedevi.quantite) prix'
                , 'AVG(Lignedevi.tva) tva', 'SUM(Lignedevi.totalht) totalht', 'SUM(Lignedevi.totalttc)totalttc', 'SUM(Lignedevi.prixnet*Lignedevi.quantite) prixnet', 'SUM(Lignedevi.puttc*Lignedevi.quantite) puttc')
            , 'conditions' => array('Lignedevi.devi_id in' . $tbr), 'recursive' => -2
            , 'group' => array('Lignedevi.article_id', 'Lignedevi.depot_id')));

        //debug($clientid);debug($lignelivraisons);die;

        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Bonlivraison']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonlivraison']['date'])));
            $this->request->data['Bonlivraison']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Bonlivraison']['client_id'] = $clientid[0]['client_id'];
            if (empty($this->request->data['Bonlivraison']['pointdevente_id'])) {
                $this->request->data['Bonlivraison']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Bonlivraison']['exercice_id'] = date("Y");


            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Bonlivraison']['pointdevente_id'];
            }
            $numero = $this->Bonlivraison->find('all', array('fields' => array('MAX(Bonlivraison.numeroconca) as num'),
                'conditions' => array('Bonlivraison.pointdevente_id' => $pv, 'Bonlivraison.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.numeroconca'=>$n)));
//  $anne=$getexercice['Bonlivraison']['exercice_id'];
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

            $this->request->data['Bonlivraison']['numeroconca'] = $mm;
            $this->request->data['Bonlivraison']['numero'] = $numspecial;
            $this->Bonlivraison->create();
            if (!empty($this->request->data['Lignelivraison'])) {
                if ($this->Bonlivraison->save($this->request->data)) {
                    foreach ($idlcs as $idc) {
                        $this->Devi->updateAll(array('Devi.etat' => 1), array('Devi.id' => $idc));
                    }
                    $id = $this->Bonlivraison->id;
                    $this->misejour("Bonlivraison", "add", $id);
                    // debug($id);die;
                    $Lignelivraisons = array();
                    $stockdepots = array();
                    //debug($this->request->data );die;
                    foreach ($this->request->data['Lignelivraison'] as $numl => $f) {

                        //  debug($f);die;
                        if ($f['sup'] != 1) {
                            if (empty($f['article_id'])) {
                                $f['article_id'] = $this->request->data['Lignelivraison'][$numl]['article_id'];
                            }

                            $stockdepots[$numl]['quantite'] = $f['quantite'];
                            $Lignelivraisons['bonlivraison_id'] = $id;
                            $Lignelivraisons['depot_id'] = $f['depot_id'];
                            $Lignelivraisons['article_id'] = $f['article_id'];
                            $Lignelivraisons['quantite'] = $f['quantite'];
                            $Lignelivraisons['remise'] = $f['remise'];
                            $Lignelivraisons['tva'] = $f['tva'];
                            $Lignelivraisons['prix'] = $f['prixhtva'];
                            $Lignelivraisons['prixnet'] = $f['prixnet'];
                            $Lignelivraisons['puttc'] = $f['puttc'];
                            $Lignelivraisons['totalhtans'] = $f['totalhtans'];
                            $Lignelivraisons['totalht'] = $f['totalht'];
                            $Lignelivraisons['totalttc'] = $f['totalttc'];
                            $this->Lignelivraison->create();
                            $this->Lignelivraison->save($Lignelivraisons);

                            $id_ligne = $this->Lignelivraison->id;
                            $qte_sorti = $f['quantite'];
                            while ($qte_sorti > 0) {
                                $stckdepot = $this->Stockdepot->find('first', array(
                                    'conditions' => array('Stockdepot.article_id' => $f['article_id'],
                                        'Stockdepot.depot_id' => $f['depot_id'], 'Stockdepot.quantite >' => 0), false));
                                //debug($stckdepot);die;
                                if ($qte_sorti < $stckdepot['Stockdepot']['quantite']) {
                                    $qte = $stckdepot['Stockdepot']['quantite'] - $qte_sorti;
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    $this->loadModel('Stockdepotfacture');
                                    $tab = array();
                                    $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                    $tab['id_piece'] = $id;
                                    $tab['piece'] = "Bonlivraison";
                                    $tab['qte'] = $qte_sorti;
                                    $tab['ligne'] = $id_ligne;
                                    $this->Stockdepotfacture->create();
                                    $this->Stockdepotfacture->save($tab);
                                    $qte_sorti = 0;
                                } else {
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 0), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    $qte_sorti = $qte_sorti - $stckdepot['Stockdepot']['quantite'];
                                    $this->loadModel('Stockdepotfacture');
                                    $tab = array();
                                    $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                    $tab['id_piece'] = $id;
                                    $tab['piece'] = "Bonlivraison";
                                    $tab['ligne'] = $id_ligne;
                                    $tab['qte'] = $stckdepot['Stockdepot']['quantite'];
                                    $this->Stockdepotfacture->create();
                                    $this->Stockdepotfacture->save($tab);
                                }
                            }






//                            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
//                            if (!empty($stckdepot)) {
//                                $stockdepots[$numl]['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] - $stockdepots[$numl]['quantite'];
//                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
//                            }
                            //$this->stock($f['depot_id'], $f['article_id']);
                            // $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
                        }
                    }
                    $this->Session->setFlash(__('The bonlivraison has been saved'));
                    //$this->redirect(array('action' => 'addbonsorti/'.$id));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                }
            }
        }

        $pv = CakeSession::read('pointdevente');
        if ($pv == 0) {
            $pv = $clientid['Devi']['pointdevente_id'];
        }
        $numero = $this->Bonlivraison->find('all', array('fields' => array('MAX(Bonlivraison.numeroconca) as num'),
            'conditions' => array('Bonlivraison.pointdevente_id' => $pv, 'Bonlivraison.exercice_id' => date("Y")))
        );
        //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        if (!empty($n)) {
//        $getexercice= $this->Bonlivraison->find('first',array('conditions'=>array('Bonlivraison.numeroconca'=>$n)));
//       $anne=$getexercice['Bonlivraison']['exercice_id'];
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


        //**************************************trouver la liste des articles pour chaque depot *******************************************************
        /* foreach ($lignelivraisons as $ll) {
          $artdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $ll[0]['depot_id']), 'recursive' => -1));
          $t = '(0';
          foreach ($artdepot as $ad) {
          if (!empty($ad['Stockdepot']['article_id'])) {
          $t = $t . ',' . $ad['Stockdepot']['article_id'];
          }
          }
          $t = $t . ')';

          $articles = $this->Article->find('list', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
          $tabqtestock[$ll[0]['depot_id']]['articles'] = $articles;

          //**************************************trouver les qte en stock de chaque article pour chaque depot *******************************************************

          $artstocks = $this->Article->find('all', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
          //debug($artstocks);die;
          foreach ($artstocks as $i => $as) {
          $qtestock = 0;
          $stockdepots = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $as['Article']['id'],
          'Stockdepot.depot_id' => $ll[0]['depot_id']), false));
          foreach ($stockdepots as $stkdepot) {
          $qtestock = $qtestock + $stkdepot['Stockdepot']['quantite'];
          }
          $tabqtestock[$ll[0]['depot_id']][$as['Article']['id']]['qtestock'] = $qtestock;
          }
          } */

        //******************************************fin***********************************************************************************************************
        // debug($tabqtestock);die;
        //debug($tabqtestock['1.0000'][1]['qtestock']);die;


        $client = $this->Client->find('first', array('conditions' => array('Client.id' => $clientid[0]['client_id']), 'recursive' => -2));
        $pntv = $clientid['Devi']['pointdevente_id'];
        $client = $client['Client']['name'];
        $utilisateurs = $this->Bonlivraison->Utilisateur->find('list');
        $clients = $this->Bonlivraison->Client->find('list');
        //$articles = $this->Article->find('list');
        $pointdeventes = $this->Pointdevente->find('list');

        //****************************************************************************************************************************************************

        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Client');


        $client = $this->Client->find('all', array('conditions' => array('Client.id' => $clientid[0]['client_id']), false));
        $adresse = $client[0]['Client']['adresse'];
        $name = $client[0]['Client']['name'];
        $matriculefiscale = $client[0]['Client']['matriculefiscale'];
        $autorisation = $client[0]['Client']['autorisation'];
        $typeclient_id = $client[0]['Client']['typeclient_id'];

        $sumttc = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.totalttc) as totalttcb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid[0]['client_id'])));
        $summtreg = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.Montant_Regler) as totalregb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid[0]['client_id'])));
        $sumttcf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.totalttc) as totalttf')
            , 'conditions' => array('Factureclient.id > ' => 0), 'Factureclient.client_id' => $clientid[0]['client_id']));
        $summtregf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.Montant_Regler) as totalregf')
            , 'conditions' => array('Factureclient.id > ' => 0), 'Factureclient.client_id' => $clientid[0]['client_id']));
        $reglementlibre = $this->Reglementclient->find('all', array('fields' => array('sum(Reglementclient.Montant) as reglibretotale')
            , 'conditions' => array('Reglementclient.type  ' => 1, 'Reglementclient.affectation_id  ' => 0, 'Reglementclient.client_id' => $clientid[0]['client_id'])));
        $valbl = $sumttc[0][0]['totalttcb'] - $summtreg[0][0]['totalregb'];
        $valfac = $sumttcf[0][0]['totalttf'] - $summtregf[0][0]['totalregf'];
        $valglobal = $valbl + $valfac;
        $solde = $valglobal - $reglementlibre[0][0]['reglibretotale'];
        $valreste = $autorisation - ($valglobal - $reglementlibre[0][0]['reglibretotale']);
        //fin info client************************************************
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Factureclient->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Factureclient->Depot->find('list', array('conditions' => array('Depot.id' => $p)));
        }


        $this->set(compact('typeclient_id', 'name', 'autorisation', 'solde', 'clientid', 'tabqtestock', 'articles', 'depots', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'pntv', 'clients', 'client', 'utilisateurs', 'articles', 'mm', 'lignelivraisons', 'numspecial'));
    }


    public function addbonsorti($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonlivraisons') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignelivraison');
        $this->loadModel('Stockdepot');
        $this->loadModel('Article');
        $this->loadModel('Bonsorti');
        $this->loadModel('Lignesorti');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignesortidetail');
        if (!$this->Bonlivraison->exists($id)) {
            throw new NotFoundException(__('Invalid bonlivraison'));
        }
        if ($this->request->is('post')) {
            //debug($this->request->data );die;
            $this->request->data['Bonsorti']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonsorti']['date'])));
            $this->request->data['Bonsorti']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Bonsorti']['bonlivraison_id'] = $id;
            $this->Bonsorti->create();
            if (!empty($this->request->data['Lignesorti'])) {
                if ($this->Bonsorti->save($this->request->data)) {
                    $idbs = $this->Bonsorti->id;
                    $qteliv = array();
                    $qtebl = 0;
                    $qtelivrai = 0;
                    foreach ($this->request->data['Lignesorti'] as $f) {
                        //debug($f);die;

                        if ($f['sup'] != 1) {
                            $Lignesortis['bonsorti_id'] = $idbs;
                            $Lignesortis['lignelivraison_id'] = $f['id'];
                            $Lignesortis['depot_id'] = $f['depot_id'];
                            $Lignesortis['article_id'] = $f['article_id'];
                            $Lignesortis['quantite'] = $f['quantite'];
                            $qtebl = $qtebl + $f['quantite'];
                            $this->Lignesorti->create();
                            $this->Lignesorti->save($Lignesortis);
                            $idls = $this->Lignesorti->id;
                            $qteliv[$f['id']] = 0;
                            if (!empty($f['Stockdepot'])) {
                                foreach ($f['Stockdepot'] as $sd) {
                                    if (!empty($sd['quantite'])) {
                                        $qte = $sd['qtestock'] - $sd['quantite'];

                                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $sd['id']));
                                        if (($qte == 0) & ($f['quantite'] < $f['quantitestock'])) {
                                            $this->Stockdepot->deleteAll(array('Stockdepot.id' => $sd['id']), false);
                                        }
                                        $Lignedetailsortis['lignesorti_id'] = $idls;
                                        $Lignedetailsortis['stockdepot_id'] = $sd['id'];
                                        $Lignedetailsortis['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $sd['date'])));
                                        $Lignedetailsortis['quantite'] = $sd['quantite'];
                                        $this->Lignesortidetail->create();
                                        $this->Lignesortidetail->save($Lignedetailsortis);
                                        $qteliv[$f['id']] = $qteliv[$f['id']] + $sd['quantite'];
                                        $qtelivrai = $qtelivrai + $sd['quantite'];
                                    }
                                }
                            }
                            $this->Lignelivraison->updateAll(array('Lignelivraison.quantitelivrai' => 'Lignelivraison.quantitelivrai+' . $qteliv[$f['id']]), array('Lignelivraison.id' => $f['id']));
                        }
                    }
                    if ($qtelivrai == $qtebl) {
                        $this->Bonlivraison->updateAll(array('Bonlivraison.etat' => 1), array('Bonlivraison.id' => $id));
                    }
                    $this->Session->setFlash(__('The bonlivraison has been saved'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                }
            }
        }
        $lignelivraisons = $this->Lignelivraison->find('all', array('conditions' => array('Lignelivraison.bonlivraison_id' => $id)));
        //debug($lignelivraisons); die;

        foreach ($lignelivraisons as $q => $ll) {

            //**************************************trouver la liste des articles pour chaque depot *******************************************************

            $artdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $ll['Depot']['id']), 'recursive' => -1));
            $t = '(0,';
            foreach ($artdepot as $ad) {
                $a = '' . $ad['Stockdepot']['article_id'];
                if (!strstr($t, $a)) {
                    $t = $t . $ad['Stockdepot']['article_id'] . ',';
                }
            }
            $t = $t . '0)';

            $articles = $this->Article->find('list', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
            $tabqtestock[$ll['Depot']['id']]['articles'] = $articles;

            //**************************************trouver les qte en stock de chaque article pour chaque depot *******************************************************

            $artstocks = $this->Article->find('all', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
            //debug($artstocks);die;
            foreach ($artstocks as $i => $as) {
                $qtestock = 0;
                $stockdepots = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $as['Article']['id'],
                        'Stockdepot.depot_id' => $ll['Depot']['id']), false));

                foreach ($stockdepots as $stkdepot) {
                    $qtestock = $qtestock + $stkdepot['Stockdepot']['quantite'];
                }
                $tabqtestock[$ll['Depot']['id']][$as['Article']['id']]['qtestock'] = $qtestock;
            }
            $stkdepots = $this->Stockdepot->find('all', array(
                'conditions' => array('Stockdepot.article_id' => $ll['Article']['id'], 'Stockdepot.depot_id' => $ll['Depot']['id'])
                , 'order' => array('Stockdepot.date' => 'ASC'), 'recursive' => -1));
            $lignelivraisons[$q]['Stockdepots'] = $stkdepots;
            //debug($stkdepots); die;
        }
        $numero = $this->Bonsorti->find('all', array('fields' =>
            array(
                'MAX(Bonsorti.numero) as num'
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
        // debug($tabqtestock); die;
        $clients = $this->Bonlivraison->Client->find('list');
        $utilisateurs = $this->Bonlivraison->Utilisateur->find('list');
        $depots = $this->Bonlivraison->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $this->set(compact('clients', 'utilisateurs', 'depots', 'lignelivraisons', 'articles', 'tabqtestock', 'mm'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonlivraisons') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Reglementclient');
        $this->loadModel('Pointdevente');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Stockdepot');
        $this->loadModel('Article');
        $this->loadModel('Stockdepotfacture');
        if (!$this->Bonlivraison->exists($id)) {
            throw new NotFoundException(__('Invalid bonlivraison'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data['Bonlivraison']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonlivraison']['date'])));
            $this->request->data['Bonlivraison']['utilisateur_id'] = CakeSession::read('users');
            $numeros = explode('/', $this->request->data['Bonlivraison']['numero']);
            $this->request->data['Bonlivraison']['numeroconca'] = $numeros[1];

            if ($this->Bonlivraison->save($this->request->data)) {
                $this->misejour("Bonlivraison", "edit", $id);


                $lignefactureanciens = $this->Stockdepotfacture->find('all', array('conditions' => array('Stockdepotfacture.id_piece' => $id, 'Stockdepotfacture.piece' => "Bonlivraison"), false));
                foreach ($lignefactureanciens as $lra) {

                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $lra['Stockdepotfacture']['qte']), array('Stockdepot.id' => $lra['Stockdepotfacture']['stockdepot_id']));
                }
                $this->Stockdepotfacture->deleteAll(array('Stockdepotfacture.id_piece' => $id, 'Stockdepotfacture.piece' => "Bonlivraison"), false);






//                $lignelivrisonanciens = $this->Lignelivraison->find('all', array('conditions' => array('Lignelivraison.bonlivraison_id' => $id), false));
//                foreach ($lignelivrisonanciens as $lra) {
//
//                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $lra['Lignelivraison']['quantite']), array('Stockdepot.article_id' => $lra['Lignelivraison']['article_id'], 'Stockdepot.depot_id' => $lra['Lignelivraison']['depot_id']));
//                }
                //$this->Lignelivraison->deleteAll(array('Lignelivraison.bonlivraison_id' => $id), false);
                $Lignelivraisons = array();
                $stockdepots = array();
                foreach ($this->request->data['Lignelivraison'] as $numl => $f) {
                    //  debug($f);die;
                    if ($f['sup'] != 1) {
                        $Lignelivraisons['id'] = $f['id'];
                        $stockdepots[$numl]['quantite'] = $f['quantite'];
                        $Lignelivraisons['bonlivraison_id'] = $id;
                        $Lignelivraisons['depot_id'] = $f['depot_id'];
                        $Lignelivraisons['article_id'] = $f['article_id'];
                        $Lignelivraisons['quantite'] = $f['quantite'];
                        $Lignelivraisons['remise'] = $f['remise'];
                        $Lignelivraisons['tva'] = $f['tva'];
                        $Lignelivraisons['prix'] = $f['prixhtva'];
                        $Lignelivraisons['prixnet'] = $f['prixnet'];
                        $Lignelivraisons['puttc'] = $f['puttc'];
                        $Lignelivraisons['totalhtans'] = $f['totalhtans'];
                        $Lignelivraisons['designation'] = $f['designation'];
                        $Lignelivraisons['totalht'] = $f['totalht'];
                        $Lignelivraisons['totalttc'] = $f['totalttc'];
                        $this->Lignelivraison->create();
                        $this->Lignelivraison->save($Lignelivraisons);


                        $id_ligne = $this->Lignelivraison->id;
                        $qte_sorti = $f['quantite'];
                        while ($qte_sorti > 0) {
                            $stckdepot = $this->Stockdepot->find('first', array(
                                'conditions' => array('Stockdepot.article_id' => $f['article_id'],
                                    'Stockdepot.depot_id' => $f['depot_id'], 'Stockdepot.quantite >' => 0), false));
                            //debug($stckdepot);die;
                            if ($qte_sorti < $stckdepot['Stockdepot']['quantite']) {
                                $qte = $stckdepot['Stockdepot']['quantite'] - $qte_sorti;
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                $this->loadModel('Stockdepotfacture');
                                $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                $tab['id_piece'] = $id;
                                $tab['piece'] = "Bonlivraison";
                                $tab['qte'] = $qte_sorti;
                                $tab['ligne'] = $id_ligne;
                                $this->Stockdepotfacture->create();
                                $this->Stockdepotfacture->save($tab);
                                $qte_sorti = 0;
                            } else {
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 0), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                $qte_sorti = $qte_sorti - $stckdepot['Stockdepot']['quantite'];
                                $this->loadModel('Stockdepotfacture');
                                $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                $tab['id_piece'] = $id;
                                $tab['piece'] = "Bonlivraison";
                                $tab['ligne'] = $id_ligne;
                                $tab['qte'] = $stckdepot['Stockdepot']['quantite'];
                                $this->Stockdepotfacture->create();
                                $this->Stockdepotfacture->save($tab);
                            }
                        }



//                        $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
//                        if (!empty($stckdepot)) {
//                            $stockdepots[$numl]['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] - $stockdepots[$numl]['quantite'];
//                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
//                        }
                        //$this->stock($f['depot_id'], $f['article_id']);
                        //$this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
                    } else {
                        $this->Lignelivraison->deleteAll(array('Lignelivraison.id' => $f['id']), false);
                    }
                }
                $this->Session->setFlash(__('The bonlivraison has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The bonlivraison could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Bonlivraison.' . $this->Bonlivraison->primaryKey => $id));
            $this->request->data = $this->Bonlivraison->find('first', $options);
        }
        $bonlivraison = $this->Bonlivraison->find('first', array('conditions' => array('Bonlivraison.id' => $id)));
        $lignelivraisons = $this->Lignelivraison->find('all', array('conditions' => array('Lignelivraison.bonlivraison_id' => $id), 'order' => array('Lignelivraison.id' => 'ASC')));
        //debug($lignelivraisons); die;

        /*
          foreach ($lignelivraisons as $ll) {

          //**************************************trouver la liste des articles pour chaque depot *******************************************************

          $artdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $ll['Lignelivraison']['depot_id']), 'recursive' => -1));
          $t = '(0';
          foreach ($artdepot as $ad) {
          if (!empty($ad['Stockdepot']['article_id'])) {
          $t = $t . ',' . $ad['Stockdepot']['article_id'];
          }
          }
          $t = $t . ')';

          $articles = $this->Article->find('list', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
          $tabqtestock[$ll['Depot']['id']]['articles'] = $articles;

          //**************************************trouver les qte en stock de chaque article pour chaque depot *******************************************************

          $artstocks = $this->Article->find('all', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
          //debug($artstocks);die;
          foreach ($artstocks as $i => $as) {
          $qtestock = 0;
          $stockdepots = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $as['Article']['id'],
          'Stockdepot.depot_id' => $ll['Depot']['id']), false));
          foreach ($stockdepots as $stkdepot) {
          $qtestock = $qtestock + $stkdepot['Stockdepot']['quantite'];
          }
          $tabqtestock[$ll['Depot']['id']][$as['Article']['id']]['qtestock'] = $qtestock;
          }
          }
         */
        // debug($tabqtestock); die;
        $clients = $this->Bonlivraison->Client->find('list');
        $utilisateurs = $this->Bonlivraison->Utilisateur->find('list');
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Bonlivraison']['date'])));
        $pointdeventes = $this->Pointdevente->find('list');
        //info client**************************************************
        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Client');
        $facture = $this->Bonlivraison->find('first', array('conditions' => array('Bonlivraison.id' => $id), false));
        $clientid = $facture['Bonlivraison']['client_id'];
        $name = $facture['Bonlivraison']['name'];
        $client = $this->Client->find('all', array('conditions' => array('Client.id' => $clientid), false));
        $adresse = $client[0]['Client']['adresse'];
        $matriculefiscale = $client[0]['Client']['matriculefiscale'];
        $autorisation = $client[0]['Client']['autorisation'];
        $typeclient_id = $client[0]['Client']['typeclient_id'];

        $sumttc = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalttc) as totalttcb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid, 'Bonlivraison.id not in (' . $id . ')')));
        $summtreg = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.Montant_Regler) as totalregb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid)));
        $sumttcf = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalttc) as totalttf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid, 'Factureclient.id not in (' . $id . ')')));
        $summtregf = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.Montant_Regler) as totalregf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid)));
        $reglementlibre = $this->Reglementclient->find('all', array('fields' => array('sum(Reglementclient.Montant) as reglibretotale')
            , 'conditions' => array('Reglementclient.type  ' => 1, 'Reglementclient.affectation_id  ' => 0, 'Reglementclient.client_id' => $clientid)));
        $valbl = $sumttc[0][0]['totalttcb'] - $summtreg[0][0]['totalregb'];
        $valfac = $sumttcf[0][0]['totalttf'] - $summtregf[0][0]['totalregf'];
        $valglobal = $valbl + $valfac;
        $solde = $valglobal - $reglementlibre[0][0]['reglibretotale'];
        $valreste = $autorisation - ($valglobal - $reglementlibre[0][0]['reglibretotale']);
        //fin info client************************************************
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Bonlivraison->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Bonlivraison->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.id' => $p)));
        }
        //$articles = $this->Article->find('list');
        $this->set(compact('typeclient_id', 'name', 'autorisation', 'solde', 'bonlivraison', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'clients', 'utilisateurs', 'depots', 'date', 'lignelivraisons', 'articles', 'tabqtestock'));
    }


    public function delete($id = null,$redirection=null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonlivraisons') {
                    $x = $liens['delete'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Commandeclient');
        $this->loadModel('Lignecommandeclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Stockdepot');
        $this->loadModel('Stockdepotfacture');
        $this->loadModel('Devi');
        $this->loadModel('Articlecomposante');
        $this->loadModel('Article');
        $this->Bonlivraison->id = $id;
        if (!$this->Bonlivraison->exists()) {
            throw new NotFoundException(__('Invalid bonlivraison'));
        }
        $abcd = $this->Bonlivraison->find('first', array('conditions' => array('Bonlivraison.id' => $id), 'recursive' => -1));
        $numansar = $abcd['Bonlivraison']['numero'];
        $pvansar = $abcd['Bonlivraison']['pointdevente_id'];

        $lignefactureanciens = $this->Lignelivraison->find('all', array('conditions' => array('Lignelivraison.bonlivraison_id' => $id), false));
//                            debug($lignefactureanciens);die;
        foreach ($lignefactureanciens as $lra) {
            if ($lra['Lignelivraison']['composee'] == 1) {
                $articlescomposantes = $this->Articlecomposante->find('all', array(
                    'conditions' => array('Articlecomposante.article_id' => $lra['Lignelivraison']['article_id'])
                ));
                foreach ($articlescomposantes as $k => $articlescomposante) {

                $testarticlecomposante = $this->Article->find('first', array('conditions' => array('Article.id' =>$articlescomposante['Articlecomposante']['composant'])));
                if ($testarticlecomposante['Article']['composee'] == 1) {

                    $lesarticles_articlescomposantes = $this->Articlecomposante->find('all', array(
                        'conditions' => array('Articlecomposante.article_id' =>$articlescomposante['Articlecomposante']['composant'])
                    ));
                    foreach ($lesarticles_articlescomposantes as $k => $lesarticles_articlescomposante) {
                        $qte_vendu_articlecompose = $lra['Lignelivraison']['quantite']  *$articlescomposante['Articlecomposante']['qte'] * $lesarticles_articlescomposante['Articlecomposante']['qte'];
                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $qte_vendu_articlecompose), array('Stockdepot.article_id' => $lesarticles_articlescomposante['Articlecomposante']['composant'], 'Stockdepot.depot_id' => $lra['Bonlivraison']['depot_id']));

                    }}else{

                $qte_vendu = $lra['Lignelivraison']['quantite'] * $articlescomposante['Articlecomposante']['qte'];
                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $qte_vendu), array('Stockdepot.article_id' => $articlescomposante['Articlecomposante']['composant'], 'Stockdepot.depot_id' => $lra['Bonlivraison']['depot_id']));


                }

                }
            } else {
                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $lra['Lignelivraison']['quantite']), array('Stockdepot.article_id' => $lra['Lignelivraison']['article_id'], 'Stockdepot.depot_id' => $lra['Bonlivraison']['depot_id']));
            }
        }

        $this->Devi->updateAll(array('Devi.Bonlivraison_id' => 0), array('Devi.Bonlivraison_id' => $id));
        $this->Commandeclient->updateAll(array('Commandeclient.Bonlivraison_id' => 0), array('Commandeclient.Bonlivraison_id' => $id));
        $lrs = $this->Lignelivraison->find('all', array('conditions' => array('Lignelivraison.Bonlivraison_id' => $id), false));
        foreach ($lrs as $lr) {
            if (!empty($lr['Lignelivraison']['lignecommandeclient_id'])) {
                $this->Lignecommandeclient->updateAll(array('Lignecommandeclient.quantiteliv' => 'Lignecommandeclient.quantiteliv-' . $lr['Lignelivraison']['quantite']), array('Lignecommandeclient.id' => $lr['Lignelivraison']['lignecommandeclient_id']));
            }
        }
        $this->Lignelivraison->deleteAll(array('Lignelivraison.Bonlivraison_id' => $id), false);
        if ($this->Bonlivraison->delete()) {
            $this->misejour("Bonlivraison", $numansar, $id,$pvansar);
            //$this->Session->setFlash(__('Bonlivraison deleted'));
            CakeSession::write('view', "delete");
            if($redirection!=1){
            $this->redirect(array('action' => 'index'));
            }
        }
        //$this->Session->setFlash(__('Bonlivraison was not deleted'));
        //$this->redirect(array('action' => 'index'));
    }

    public function stockdepot() {
        $this->layout = null;
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');


        $data = $this->request->data;
        // debug($data);
        $json = null;
        $depotid = $data['id'];
        $index = $data['index'];
        $name = 'article_id';
        $artdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $depotid), 'recursive' => -1));
        // debug($fourdevises);
        $t = '(0,';
        foreach ($artdepot as $ad) {
            $a = '' . $ad['Stockdepot']['article_id'];
            if (!strstr($t, $a)) {
                $t = $t . $ad['Stockdepot']['article_id'] . ',';
            }
        }
        $t = $t . '0)';
        //debug($t);
        $id = 'article_id' . $index;
        if ($depotid != 0) {
            $articles = $this->Article->find('all', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
            $select = "<select   name='data[Lignelivraison][" . $index . "][article_id]' table='Lignelivraison' index=" . $index . " champ=" . $id . " id=" . $id . " class='select form-control articleidbl' onchange='art(" . $index . ")'><option selected disabled hidden value=0> Veuillez choisir !!</option>";
            foreach ($articles as $v) {
                $select = $select . "<option value=" . $v['Article']['id'] . ">" . $v['Article']['name'] . "</option>";
            }
            $select = $select . '</select>';
        } else {
            $articles = $this->Article->find('all');
            $select = "<select name='" . $name . "' champ='article_id' id='article_id'  class='' onchange='art(ind) '><option selected disabled hidden value=0> Veuillez choisir !!</option>";
            foreach ($articles as $v) {
                $select = $select . "<option value=" . $v['Article']['id'] . ">" . $v['Article']['name'] . "</option>";
            }
            $select = $select . '</select>';
        }

        echo json_encode(array('select' => $select));
        die();
    }

    public function article($articleid = null, $depotid = null, $clientid = null, $vente = null, $fournisseur_id = null) {
        $this->layout = null;
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Client');
        $this->loadModel('Remiseartfamille');
        $this->loadModel('Articleclient');
        $this->loadModel('Articlefournisseur');
        $data = $this->request->data;
//        debug($data);
        $json = null;
//        $articleid = $data['id'];
//        $depotid = $data['depotid'];
//        $vente = $data['vente'];
//        $clientid = $data['clientid'];
        // debug($data);
        $codefrs = "";
        if ($articleid != 0) {
            $stockdepots = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $articleid, 'Stockdepot.depot_id' => $depotid), false));
//            debug($stockdepots);die;
            $article = $this->Article->find('all', array('conditions' => array('Article.id' => $articleid), false));
            if (!empty($clientid)) {

                $client = $this->Client->find('first', array('conditions' => array('Client.id' => $clientid), 'recursive' => -1));
                $familleid = $article[0]['Article']['famille_id'];
                $familleclientid = $client['Client']['familleclient_id'];
                $tvaclient = $client['Client']['tva'];
                $remisefamille = $this->Remiseartfamille->find('first', array('conditions' => array('Remiseartfamille.familleclient_id' => $familleclientid, 'Remiseartfamille.article_id' => $articleid), 'recursive' => -1));
                $remiseartclient = $this->Articleclient->find('first', array('conditions' => array('Articleclient.client_id' => $clientid, 'Articleclient.article_id' => $articleid), 'recursive' => -1));
            }
  //debug($client);debug($remisefamille);debug($remiseartclient);debug($tvaclient);
            //*******************Qte en stock***************************
            $qtestock = 0;
            //debug($stockdepots);die;
            foreach ($stockdepots as $stkdepot) {
                $qtestock = $qtestock + $stkdepot['Stockdepot']['quantite'];
            }

            //********************info article**************************************
            $id = $article[0]['Article']['id'];
            $code = $article[0]['Article']['code'];
            $tva = $article[0]['Article']['tva'];
            $prix = $article[0]['Article']['prixvente'];

            //*********************les remises******************************************

            if (!empty($remiseartclient['Articleclient']['remise'])) {
                $remise = $remiseartclient['Articleclient']['remise'];
            } elseif (!empty($remisefamille['Remiseartfamille']['remise'])) {
                $remise = $remisefamille['Remiseartfamille']['remise'];
            } elseif (!empty($client['Client']['remise'])) {
                $remise = $client['Client']['remise'];
            } else {
                //$remise = 0;
            }
            //***************************************************************************
            if ($fournisseur_id == 0) {
                $prixachat = $article[0]['Article']['prixav_remise'];
            } else {
                $articlefournisseur = $this->Articlefournisseur->find('first', array('conditions' => array('Articlefournisseur.fournisseur_id' => $fournisseur_id, 'Articlefournisseur.article_id' => $articleid), 'recursive' => -1));
                if (!empty($articlefournisseur)) {
                    $prixachat = $articlefournisseur['Articlefournisseur']['prix']/(1-($article[0]['Article']['remise']/100));;
                    $codefrs = $articlefournisseur['Articlefournisseur']['reference'];
                    $remise = $article[0]['Article']['remise'];
                } else {
                    $prixachat = $article[0]['Article']['prixav_remise'];
                    $remise = $article[0]['Article']['remise'];
                    $codefrs = "";
                    //debug($remise);
                }
            }

            $prixachatmarge = $article[0]['Article']['coutrevient'];
            $designation = $article[0]['Article']['name'];
            $prixttc = $article[0]['Article']['prixuttc'];
            $remise_transfert = $article[0]['Article']['remise_transfert'];
            $remise_vente = $article[0]['Article']['remise_vente'];
            $composee = $article[0]['Article']['composee'];
            $marge = $article[0]['Article']['marge'];
            $prixdeventeht = $article[0]['Article']['prixvente'];
            $pmp = $article[0]['Article']['pmp'];
            if ($vente == 'gros') {
                $prix = $article[0]['Article']['prixventegros'];
                $prixttc = $article[0]['Article']['prixttcgros'];
                $marge = $article[0]['Article']['margegros'];
            }

            //debug($remise);
        }
        //debug($qtestock);die;
        echo json_encode(array('tvaclient'=>@$tvaclient,'prixachatmarge' => $prixachatmarge, 'codefrs' => $codefrs, 'articleid' => $articleid, 'id' => @$id, 'remise' => @$remise, 'tva' => @$tva, 'code' => @$code, 'prix' => @$prix, 'prixachat' => @$prixachat, 'quantitestock' => @$qtestock, 'des' => @$designation, 'prixttc' => @$prixttc, 'remise_transfert' => @$remise_transfert, 'composee' => @$composee, 'marge' => @$marge, 'prixdeventeht' => @$prixdeventeht, 'remise_vente' => @$remise_vente, 'pmp' => $pmp));
        die();
    }
    public function articlecode($code = null, $depotid = null, $clientid = null, $vente = null, $fournisseur_id = null) {
        $this->layout = null;
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Client');
        $this->loadModel('Remiseartfamille');
        $this->loadModel('Articleclient');
        $this->loadModel('Articlefournisseur');
        $data = $this->request->data;
//        debug($data);
        $json = null;
//       
//        $depotid = $data['depotid'];
//        $vente = $data['vente'];
//        $clientid = $data['clientid'];
        // debug($data);
        $codefrs = "";
	//	 $code = $data['id'];
		    $articlea = $this->Article->find('first', array('conditions' => array('Article.code' => $code), false));
			
			$articleid=$articlea['Article']['id'];
			//  echo $articleid;
 
 
        if (!empty($articlea)) {
            $stockdepots = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $articleid, 'Stockdepot.depot_id' => $depotid), false));
//            debug($stockdepots);die;
            $article = $this->Article->find('all', array('conditions' => array('Article.id' => $articleid), false));
            if (!empty($clientid)) {

                $client = $this->Client->find('first', array('conditions' => array('Client.id' => $clientid), 'recursive' => -1));
                $familleid = $article[0]['Article']['famille_id'];
                $familleclientid = $client['Client']['familleclient_id'];
                $tvaclient = $client['Client']['tva'];
                $remisefamille = $this->Remiseartfamille->find('first', array('conditions' => array('Remiseartfamille.familleclient_id' => $familleclientid, 'Remiseartfamille.article_id' => $articleid), 'recursive' => -1));
                $remiseartclient = $this->Articleclient->find('first', array('conditions' => array('Articleclient.client_id' => $clientid, 'Articleclient.article_id' => $articleid), 'recursive' => -1));
            }
  //debug($client);debug($remisefamille);debug($remiseartclient);debug($tvaclient);
            //*******************Qte en stock***************************
            $qtestock = 0;
            //debug($stockdepots);die;
            foreach ($stockdepots as $stkdepot) {
                $qtestock = $qtestock + $stkdepot['Stockdepot']['quantite'];
            }

            //********************info article**************************************
            $id = $article[0]['Article']['id'];
            $code = $article[0]['Article']['code'];
            $tva = $article[0]['Article']['tva'];
            $prix = $article[0]['Article']['prixvente'];

            //*********************les remises******************************************

            if (!empty($remiseartclient['Articleclient']['remise'])) {
                $remise = $remiseartclient['Articleclient']['remise'];
            } elseif (!empty($remisefamille['Remiseartfamille']['remise'])) {
                $remise = $remisefamille['Remiseartfamille']['remise'];
            } elseif (!empty($client['Client']['remise'])) {
                $remise = $client['Client']['remise'];
            } else {
                //$remise = 0;
            }
            //***************************************************************************
            if ($fournisseur_id == 0) {
                $prixachat = $article[0]['Article']['prixav_remise'];
            } else {
                $articlefournisseur = $this->Articlefournisseur->find('first', array('conditions' => array('Articlefournisseur.fournisseur_id' => $fournisseur_id, 'Articlefournisseur.article_id' => $articleid), 'recursive' => -1));
                if (!empty($articlefournisseur)) {
                    $prixachat = $articlefournisseur['Articlefournisseur']['prix']/(1-($article[0]['Article']['remise']/100));;
                    $codefrs = $articlefournisseur['Articlefournisseur']['reference'];
                    $remise = $article[0]['Article']['remise'];
                } else {
                    $prixachat = $article[0]['Article']['prixav_remise'];
                    $remise = $article[0]['Article']['remise'];
                    $codefrs = "";
                    //debug($remise);
                }
            }

            $prixachatmarge = $article[0]['Article']['coutrevient'];
            $designation = $article[0]['Article']['name'];
            $prixttc = $article[0]['Article']['prixuttc'];
            $remise_transfert = $article[0]['Article']['remise_transfert'];
            $remise_vente = $article[0]['Article']['remise_vente'];
            $composee = $article[0]['Article']['composee'];
            $marge = $article[0]['Article']['marge'];
            $prixdeventeht = $article[0]['Article']['prixvente'];
            $pmp = $article[0]['Article']['pmp'];
            if ($vente == 'gros') {
                $prix = $article[0]['Article']['prixventegros'];
                $prixttc = $article[0]['Article']['prixttcgros'];
                $marge = $article[0]['Article']['margegros'];
            }

            //debug($remise);
        } 
        //debug($qtestock);die;
        echo json_encode(array('tvaclient'=>@$tvaclient,'prixachatmarge' => $prixachatmarge, 'codefrs' => $codefrs, 'articleid' => $articleid, 'id' => @$id, 'remise' => @$remise, 'tva' => @$tva, 'code' => @$code, 'prix' => @$prix, 'prixachat' => @$prixachat, 'quantitestock' => @$qtestock, 'des' => @$designation, 'prixttc' => @$prixttc, 'remise_transfert' => @$remise_transfert, 'composee' => @$composee, 'marge' => @$marge, 'prixdeventeht' => @$prixdeventeht, 'remise_vente' => @$remise_vente, 'pmp' => $pmp));
        die();
    }

    public function articlecommandecomercial() {
        $this->layout = null;
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Client');
        $this->loadModel('Remiseartfamille');
        $this->loadModel('Articleclient');
        $data = $this->request->data; //debug($data);
        $json = null;
        $articleid = $data['id'];

        // debug($data);
        $stockdepots = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $articleid), false));
        $article = $this->Article->find('all', array('conditions' => array('Article.id' => $articleid), false));
        if (!empty($data['clientid'])) {
            $clientid = $data['clientid'];
            $client = $this->Client->find('first', array('conditions' => array('Client.id' => $clientid), 'recursive' => -1));
            $familleid = $article[0]['Article']['famille_id'];
            $familleclientid = $client['Client']['familleclient_id'];
            $remisefamille = $this->Remiseartfamille->find('first', array('conditions' => array('Remiseartfamille.familleclient_id' => $familleclientid, 'Remiseartfamille.article_id' => $articleid), 'recursive' => -1));
            $remiseartclient = $this->Articleclient->find('first', array('conditions' => array('Articleclient.client_id' => $clientid, 'Articleclient.article_id' => $articleid), 'recursive' => -1));
        }
//  debug($client);debug($remisefamille);debug($remiseartclient);
        //*******************Qte en stock***************************
        $qtestock = 0;
        foreach ($stockdepots as $stkdepot) {
            $qtestock = $qtestock + $stkdepot['Stockdepot']['quantite'];
        }
        //********************info article**************************************
        $id = $article[0]['Article']['id'];
        $tva = $article[0]['Article']['tva'];
        $prix = $article[0]['Article']['prixvente'];
        $prixachat = $article[0]['Article']['coutrevient'];
        $designation = $article[0]['Article']['name'];
        $prixttc = $article[0]['Article']['prixuttc'];
        //*********************les remises******************************************

        if (!empty($remiseartclient['Articleclient']['remise'])) {
            $remise = $remiseartclient['Articleclient']['remise'];
        } elseif (!empty($remisefamille['Remiseartfamille']['remise'])) {
            $remise = $remisefamille['Remiseartfamille']['remise'];
        } elseif (!empty($client['Client']['remise'])) {
            $remise = $client['Client']['remise'];
        } else {
            $remise = 0;
        }
        //***************************************************************************
        //debug($remise);
        echo json_encode(array('id' => $id, 'remise' => $remise, 'tva' => $tva, 'prix' => $prix, 'prixachat' => $prixachat, 'quantitestock' => $qtestock, 'des' => $designation, 'prixttc' => $prixttc));
        die();
    }

    public function getnums() {
        $this->layout = null;
        $this->loadModel('Pointdevente');
        $data = $this->request->data; //debug($data);
        $json = null;
        $pv = $data['id'];
        $model = $data['model'];
        $nature = $data['nature'];
        $date = $data['date'];
        $dd = explode('/', $date);
        $ans = $dd['2'];
        $this->loadModel($model);
        $cond = "";
        if ($nature != '0') {
            $cond = $model . ".nature='" . $nature . "'";
        }


        $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numeroconca) as num'),
            'conditions' => array($model . '.pointdevente_id' => $pv, $model . '.exercice_id' => $ans, $cond))
        );
        //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        //debug($n);
        if (!empty($n)) {
            //$getexercice= $this->$model->find('first',array('conditions'=>array($model.'.numeroconca'=>$n)));
            //$anne=$getexercice[$model]['exercice_id'];
            //debug($anne);
            //if ($anne==date("Y")){
            $lastnum = $n;
            $nume = intval($lastnum) + 1;
            $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            // }
            //else {
            ////  $mm = "000001";
            // }
        } else {
            $mm = "000001";
        }
        $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
        $abrivation = $pointvente['Pointdevente']['abriviation'];
        $numspecial = $abrivation . "/" . $mm . "/" . $ans;
        echo json_encode(array('numspecial' => $numspecial, 'mm' => $mm));
        die();
    }

    public function getclients() {
        //debug("aaaaaa");die;
        $this->layout = null;
        $this->loadModel('Client');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Reglementclient');
        $data = $this->request->data; //debug($data);
        $json = null;
        $clientid = $data['id'];
        $client = $this->Client->find('all', array('conditions' => array('Client.id' => $clientid),'recursive' => -1, false));
        //debug($client);die();
        $adresse = $client[0]['Client']['adresse'];
        $code = $client[0]['Client']['code'];
        $name = $code . " " . $client[0]['Client']['name'];
        $matriculefiscale = $client[0]['Client']['matriculefiscale'];
        $autorisation = $client[0]['Client']['autorisation'];
        $modeclientid = $client[0]['Client']['modeclient_id'];
        $typeclientid = $client[0]['Client']['typeclient_id'];
        $vente=$client[0]['Client']['vente'];
        $avectimbreid = $client[0]['Client']['avectimbre_id'];
        if (empty($autorisation)) {
            $val = 0;
            $autorisation = 0;
        } else {
            $val = 1;
        }
        // debug($val);

        $sumttc = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalttc) as totalttcb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid)));
        $summtreg = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.Montant_Regler) as totalregb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid)));
        $sumttcf = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalttc) as totalttf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid)));
        $summtregf = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.Montant_Regler) as totalregf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid)));
        $reglementlibre = $this->Reglementclient->find('all', array('fields' => array('sum(Reglementclient.Montant) as reglibretotale')
            , 'conditions' => array('Reglementclient.type' => 1, 'Reglementclient.affectation_id' => 0, 'Reglementclient.client_id' => $clientid)));

        $valbl = $sumttc[0][0]['totalttcb'] - $summtreg[0][0]['totalregb'];
        $valfac = $sumttcf[0][0]['totalttf'] - $summtregf[0][0]['totalregf'];
        $valglobal = $valbl + $valfac;
        $solde = $valglobal - $reglementlibre[0][0]['reglibretotale'];
        $valreste = $autorisation - ($solde);

        //**************************************

        $this->loadModel('Client');
        $clts = $this->Client->find('first', array('conditions' => array('Client.id'=>$clientid),'recursive' => -1));
        $debut= date('Y-m-d');
        $time = strtotime($debut);
        $dateparmois=date('Y-m-d',strtotime('-'.$clts['Client']['nbrmois'].' month', $time));
        $first_day=date_create($dateparmois)->modify('first day of this month')->format('Y-m-d');
        if($modeclientid==1){
        $last_day_mois_autorisation=date_create($clts['Client']['dateautorisation'])->modify('last day of this month')->format('Y-m-d');
        if(date("Y-m-d")>$last_day_mois_autorisation){
        $this->Client->updateAll(array('Client.modeclient_id' =>2), array('Client.id' => $clientid));
        $modeclientid=2;
        }
        }
        $factureclients = $this->Factureclient->find('count', array(
            'conditions' => array(
            'Factureclient.client_id'=>$clientid,
            'Factureclient.date < ' . "'" . $first_day . "'" ,
            'Factureclient.totalttc>Factureclient.Montant_Regler'
            ),
            'recursive' => -1,
        ));
        $this->loadModel('Piecereglementclient');
        $piecereglements = $this->Piecereglementclient->find('count', array(
            'conditions' => array(
            'Piecereglementclient.paiement_id in (2,3)',
            'Piecereglementclient.situation="Impayé"',
            'Piecereglementclient.montant>Piecereglementclient.mantantregler',
            'Reglementclient.client_id'=>$clientid
            )
            ,'contain'=>array('Reglementclient')
            ,'recursive'=>0
            ));
        //*****************************************************************************
		echo json_encode(array('avectimbreid'=>$avectimbreid,'typeclientid' => $typeclientid, 'modeclientid' => $modeclientid,'vente'=>$vente,
            'name' => $name, 'adresse' => $adresse, 'matriculefiscale' => $matriculefiscale, 'valreste' => $valreste,
            'autorisation' => $val, 'solde' => $solde, 'autor' => $autorisation,
            'piecereglements'=>$piecereglements,'modeclient'=>$modeclientid,
            'Factureclients' => $factureclients,'date_first_day'=>date("d/m/Y", strtotime(str_replace('/', '-',$first_day))),
            'client_id'=>$clientid
                ));
        die;
    }

   public function recap($index_kbira=null,$clientid=null,$articleid=null) {
        $this->loadModel('Devi');
        $this->loadModel('Lignedevi');
        $this->loadModel('Commandeclient');
        $this->loadModel('Lignecommandeclient');
        $this->loadModel('Factureclient');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Client');

        $this->layout = null;
//        $data = $this->request->data;
//        $clientid = $data['client_id'];
//        $articleid = $data['article_id'];
//        $index_kbira = $data['index'];
        if($clientid!=0){
        $client = $this->Client->find('all', array('conditions' => array('Client.id' => $clientid), false));
        $name = $client[0]['Client']['name'];
        if($articleid!=0){
//        $cond_devis='Lignedevi.article_id='. $articleid;
//        $cond_commandes='Lignecommandeclient.article_id='. $articleid;
//        $cond_livrisons='Lignelivraison.article_id='. $articleid;
//        $cond_factures='Lignefactureclient.article_id='. $articleid;

        $cond_livrisons=' and lignelivraisons.article_id='. $articleid;
        $cond_factures=' and lignefactureclients.article_id='. $articleid;
        }
        $annee=date("Y");
        $annee_precedent=date("Y")-1;
        $annee_precedent_a=date("Y")-2;
        $annee_precedent_b=date("Y")-3;
//        $lignedevis = $this->Lignedevi->find('all', array(
//            'conditions' => array('Devi.client_id' => $clientid, @$cond_devis), 'recursive' => 0,'contain'=>array('Devi')));
//        $lignecommandes = $this->Lignecommandeclient->find('all', array(
//            'conditions' => array('Commandeclient.client_id' => $clientid, @$cond_commandes), 'recursive' => 0,'contain'=>array('Commandeclient')));
//        $lignelivrisons = $this->Lignelivraison->find('all', array(
//            'conditions' => array('Bonlivraison.client_id' => $clientid,@$cond_livrisons,'Bonlivraison.exercice_id in ('.$annee.','.$annee_precedent.')')
//            , 'recursive' => -1
//            ,'group'=>array('Lignelivraison.article_id')
//            ,'contain'=>array('Bonlivraison','Article.code')
//            ,'order'=>array('Bonlivraison.date'=>'desc')
//            ));
//
//
//        $lignefactures = $this->Lignefactureclient->find('all', array(
//            'conditions' => array('Factureclient.client_id' => $clientid, @$cond_factures,'Factureclient.exercice_id in ('.$annee.','.$annee_precedent.')'),
//            'recursive' => -1
//            ,'group'=>array('Lignefactureclient.article_id')
//            ,'contain'=>array('Factureclient','Article.code')
//            ,'order'=>array('Factureclient.date'=>'desc')
//            //,'limit'=>500
//            ));
            //debug($lignefactures);die;

        $lignefactures = $this->Bonlivraison->query(
        'SELECT  tmp.id ,tmp.name,tmp.code,tmp.coutrevient,tmp.quantite,tmp.prix,tmp.totalhtans,tmp.prixnet,tmp.remise,tmp.puttc,tmp.tva,tmp.totalht,tmp.totalttc,tmp.date,tmp.type,tmp.composee
        FROM (
        (
        SELECT   articles.id, articles.name ,articles.code,articles.coutrevient ,lignefactureclients.quantite ,lignefactureclients.prix,lignefactureclients.totalhtans
        , lignefactureclients.prixnet, lignefactureclients.remise, lignefactureclients.puttc,lignefactureclients.tva
        ,lignefactureclients.totalht ,lignefactureclients.totalttc ,factureclients.date ,"fac" type,articles.composee
        FROM  `lignefactureclients`,factureclients,articles
        where   lignefactureclients.factureclient_id=factureclients.id
        and lignefactureclients.article_id=articles.id
        and factureclients.client_id='.$clientid.' and factureclients.exercice_id in ('.$annee.','.$annee_precedent.','.$annee_precedent_a.','.$annee_precedent_b.')
        ' . @$cond_factures . '
        ORDER BY factureclients.date desc
        )
        UNION (
        SELECT   articles.id, articles.name ,articles.code,articles.coutrevient ,lignelivraisons.quantite ,lignelivraisons.prix,lignelivraisons.totalhtans
        , lignelivraisons.prixnet, lignelivraisons.remise, lignelivraisons.puttc,lignelivraisons.tva
        ,lignelivraisons.totalht ,lignelivraisons.totalttc ,bonlivraisons.date ,"bl" type,articles.composee
        FROM `lignelivraisons`, bonlivraisons, articles
        where lignelivraisons.bonlivraison_id = bonlivraisons.id
        and lignelivraisons.article_id = articles.id
        and bonlivraisons.client_id='.$clientid.' and bonlivraisons.exercice_id in ('.$annee.','.$annee_precedent.','.$annee_precedent_a.','.$annee_precedent_b.')
        ' . @$cond_livrisons . '
        ORDER BY bonlivraisons.date desc
        )
        )tmp
        ORDER BY tmp.date desc
        ');


//        $lignefactures = $this->Bonlivraison->query(
//        'SELECT  tmp.id
//        FROM (
//        (
//        SELECT   articles.id
//        FROM  `lignefactureclients`,factureclients,articles
//        where   lignefactureclients.factureclient_id=factureclients.id
//        and lignefactureclients.article_id=articles.id
//        and factureclients.client_id='.$clientid.' and factureclients.exercice_id in ('.$annee.','.$annee_precedent.')
//        ' . @$cond_factures . '
//
//        )
//        UNION (
//        SELECT   articles.id
//        FROM `lignelivraisons`, bonlivraisons, articles
//        where lignelivraisons.bonlivraison_id = bonlivraisons.id
//        and lignelivraisons.article_id = articles.id
//        and bonlivraisons.client_id='.$clientid.' and bonlivraisons.exercice_id in ('.$annee.','.$annee_precedent.')
//        ' . @$cond_livrisons . '
//
//        )
//        )tmp
//        GROUP BY tmp.id
//
//        ');

        //debug($lignefactures);die;



        }else{
//        $lignedevis=array();
//        $lignecommandes=array();
//        $lignelivrisons=array();
        $lignefactures=array();
        }

        $this->set(compact('clientid','lignedevis', 'lignecommandes', 'lignelivrisons', 'lignefactures', 'name', 'index_kbira'));
    }
    public function testqtes() {

        $this->loadModel('Commandeclient');
        $this->loadModel('Lignecommandeclient');


        $this->layout = null;
        $data = $this->request->data;
        $id = $data['id'];




        $lignecommandes = $this->Lignecommandeclient->find('all', array(
            'conditions' => array('Lignecommandeclient.commandeclient_id' => $id), 'recursive' => 0));
        //debug($lignecommandes);
        $test = 0;
        foreach ($lignecommandes as $numl => $l) {
            if ($l['Lignecommandeclient']['quantiteliv'] > 0) {
                $test = 1;
            }
        }
        echo json_encode(array('test' => $test));
        die;
    }

    public function numerobl($val = null) {
        $this->layout = null;
        $tab = explode(' ', $val);
        $ch = "'";
        foreach ($tab as $tabb) {
            $ch = $ch . '%`' . $tabb . '`';
        }
        $ch .= "%'";
        $cond = "Bonlivraison.numero LIKE " . $ch;
        $numero = $this->Bonlivraison->find('all', array(
            'conditions' => array($cond),
            'recursive' => -1,
            'fields' => array('Bonlivraison.id', 'Bonlivraison.numero'),
            'group' => array('Bonlivraison.id'),
        ));
//        debug($numero);die;
        echo json_encode(array('numero' => $numero)); // Tableau to JSON <> Json_Decode JOSN TO TABLE
        die;
    }

    public function facturationautos($val = null, $id = null) {
        $this->layout = null;

        $this->Bonlivraison->updateAll(array(
            'Bonlivraison.auto' => "'" . $val . "'"), array('Bonlivraison.id' => $id));
    }

    //************** zeinab *****************//
    public function getlesnums() {
        $this->layout = null;
        $this->loadModel('Pointdevente');
        $data = $this->request->data; //debug($data);
        $json = null;
        $pv = $data['id'];
        $model = $data['model'];
        $nature = $data['nature'];
        $num = $data['num'];
        $this->loadModel($model);
        $cond = "";
        if ($nature != '0') {
            $cond = $model . ".nature='" . $nature . "'";
        }
        $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
        $abrivation = $pointvente['Pointdevente']['abriviation'];
        $tab = explode('/', $num);
        //debug($tab); die;
        $num = (int) $tab[1];
        $year = $tab[2];
        $tab = strtolower($model) . 's';
        $numeros = $this->$model->query('SELECT numeroconca +1
                    FROM  `' . $tab . '` f
                    WHERE numeroconca <> ( SELECT MAX( numeroconca )  FROM  `' . $tab . '` f WHERE  `exercice_id` =' . $year . ' and `pointdevente_id` =' . $pv . ' )
                                AND  `exercice_id` =' . $year . ' AND numeroconca +1 NOT
                                IN ( SELECT numeroconca FROM  `' . $tab . '`  WHERE  `exercice_id` =' . $year . ' and `pointdevente_id` =' . $pv . ' )
                    limit 1;');

        $select = "<select id='selectnum' class=' inputspcial' onchange='changerNumero();' style='width:95%;'>"
                . " <option value=''> Veuillez Choisir !!</option> ";
        $verif = 0;
        while (count($numeros) > 0) {
            $verif = 1;
            $mm = str_pad($numeros[0][0]['numeroconca +1'], 6, "0", STR_PAD_LEFT);
            //debug($mm);
            $select .= " <option value='" . $abrivation . "/" . $mm . "/" . $year . "'>" . $abrivation . "/" . $mm . "/" . $year . "</option>";
            $numeros = $this->$model->query('SELECT numeroconca +1
                    FROM  `' . $tab . '` f
                    WHERE numeroconca <> ( SELECT MAX( numeroconca )  FROM  `' . $tab . '` f WHERE  `exercice_id` =' . $year . ' and `pointdevente_id` =' . $pv . '  and numeroconca>' . $mm . ')
                                AND numeroconca>' . $mm . '
                                AND  `exercice_id` =' . $year . ' AND numeroconca +1 NOT
                                IN ( SELECT numeroconca FROM  `' . $tab . '`  WHERE  `exercice_id` =' . $year . ' and `pointdevente_id` =' . $pv . ' and numeroconca>' . $mm . ')
                    limit 1;');
        }

        $select .= "</select>";
        echo json_encode(array('select' => $select, 'verif' => $verif));
        die();
    }

    public function getlesnums_PremNum() {
        $this->layout = null;
        $this->loadModel('Pointdevente');
        $data = $this->request->data; //debug($data);
        $json = null;
        $pv = $data['id'];
        $model = $data['model'];
        $nature = $data['nature'];
        $num = $data['num'];
        $this->loadModel($model);
        $cond = "";
        if ($nature != '0') {
            $cond = $model . ".nature='" . $nature . "'";
        }
        $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
        $abrivation = $pointvente['Pointdevente']['abriviation'];
        $tab = explode('/', $num);
        //debug($tab); die;
        $num = (int) $tab[1];
        $year = $tab[2];
        $select = "<select multiple  id='selectnum' class=' inputspcial' onchange='changerNumero();' style='width:95%; height:20px;'> ";
        $verif = 0;
        $tab = strtolower($model) . 's';
        $numeros = $this->$model->query('SELECT numeroconca +1
                    FROM  `' . $tab . '` f
                    WHERE numeroconca <> ( SELECT MAX( numeroconca )  FROM  `' . $tab . '` f WHERE  `exercice_id` =' . $year . ' and `pointdevente_id` =' . $pv . ' )
                                AND  `exercice_id` =' . $year . ' AND numeroconca +1 NOT
                                IN ( SELECT numeroconca FROM  `' . $tab . '`  WHERE  `exercice_id` =' . $year . ' and `pointdevente_id` =' . $pv . ' )
                    limit 1;');
        //  debug($numeros);die;
        if (count($numeros) > 0) {
            $verif = 1;
            $mm = str_pad($numeros[0][0]['numeroconca +1'], 6, "0", STR_PAD_LEFT);
            $select .= " <option value='" . $abrivation . "/" . $mm . "/" . $year . "'>" . $abrivation . "/" . $mm . "/" . $year . "</option>";
        }
        //  }
        $select .= "</select>";
        echo json_encode(array('select' => $select, 'verif' => $verif));
        die();
    }

    public function codearticle() {
        $this->layout = null;
        $data = $this->request->data;
        $code = $data['code'];
        $this->loadModel('Article');
        $id = 0;
        $composantsoc = CakeSession::read('composantsoc');
        $article = $this->Article->find('first', array('conditions' => array('Article.code' => $code,'Article.societe'=>$composantsoc), false));
        if ($article != array()) {
            $id = $article['Article']['id'];
        }
        echo json_encode(array('id' => $id));
        die();
    }

    public function imprimerexcel() {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonlivraisons') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Client');
        //debug($this->request->query);die;
        $this->loadModel('Utilisateur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $this->loadModel('Personnel');
        $this->layout = '';
        $ordre = 'Bonlivraison.numeroconca,Bonlivraison.exercice_id DESC';
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            $cond3 = 'Bonlivraison.client_id =' . $clientid;
        }


        if ($this->request->query['societe_id']) {
            $societe_id = $this->request->query['societe_id'];
            $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
            $ch_pv = 0;
            foreach ($lespvs as $lespv) {
                $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
            }
            $cond6 = 'Bonlivraison.pointdevente_id in (' . $ch_pv . ')';
        }

        if ($this->request->query['pointdevente_id']) {
            $pointdevente_id = $this->request->query['pointdevente_id'];
            $cond7 = 'Bonlivraison.pointdevente_id =' . $pointdevente_id;
        }
        if ($this->request->query['facturer']) {

            $val = $this->request->query['facturer'];
            if ($val == 1) {
                $cond9 = 'Bonlivraison.factureclient_id > 0';
            } elseif ($val == 2) {
                $cond9 = 'Bonlivraison.factureclient_id = 0';
            } else {
                $cond9 = '';
            }
        }
        if ($this->request->query['order']) {
            $order_id = $this->request->query['order'];
                if($order_id==1){
                $ordre = 'Bonlivraison.numeroconca,Bonlivraison.exercice_id DESC';
                }
                if($order_id==2){
                $ordre = 'Client.code ASC';
                }
                if($order_id==3){
                $ordre = 'Bonlivraison.date ASC';
                }

        }
//            debug($cond9);die;


        $bonlivraisons = $this->Bonlivraison->find('all', array('conditions' => array('Bonlivraison.id > ' => 0,
            @$cond1, @$cond2, @$cond3, @$cond6, @$cond7, @$cond9, @$cond10)
            ,'recursive'=>0,
        'order'=>array(@$ordre)));


        $this->set(compact('bonlivraisons', 'date1', 'date2', 'clientid'));
    }

//******************************************//
    public function upnum($pv = null, $model = null) {
        $this->loadModel("$model");
        $this->loadModel("Pointdevente");
        $annee = $this->$model->find('all', array('fields' => array($model . '.exercice_id'),
            'group' => array($model . '.exercice_id')));
        foreach ($annee as $an) {
            $ans = $an["$model"]["exercice_id"];
            $mms = $this->$model->find('all', array('fields' => array($model . '.id'),
                'conditions' => array($model . '.exercice_id' => $ans, $model . '.pointdevente_id' => $pv), 'recursive' => -1));

            foreach ($mms as $mn) {

                $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numeroconca) as num'),
                    'conditions' => array($model . '.pointdevente_id' => $pv, $model . '.exercice_id' => $ans), 'recursive' => -1)
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
                $numspecial = $abrivation . "/" . $mm . "/" . $ans;

                $this->$model->updateAll(
                        array($model . '.numeroconca' => "'" . $mm . "'", $model . '.numero' => "'" . $numspecial . "'"), array($model . '.id ' => $mn["$model"]["id"]));

                echo $mn["$model"]["id"] . ' ' . $numspecial . '<br>';
            }
        }
    }

    public function numerobl_autocomplete() {
        $this->layout = null;
        $val = $this->request->data['val'];
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Bonlivraison.pointdevente_id = '.$p;
        }
        $tab = explode('%', $val);
        $val_composer="";
        foreach ($tab as $tabb) {if($tabb !=""){$val_composer .= "%".addslashes($tabb);}}
        $bonlivraisons = $this->Bonlivraison->find('all', array(
        'conditions' => array("Bonlivraison.numero LIKE  '" . $val_composer . "%'",@$cond_liste_pv),
        'recursive' => -1,
        'limit'=>100,
        'order'=>'cast((Bonlivraison.numero) as signed) Asc'
        ));
        echo json_encode(array('bonlivraisons' => $bonlivraisons));
        die();
    }

}
