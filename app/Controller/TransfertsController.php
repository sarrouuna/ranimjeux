<?php

App::uses('AppController', 'Controller');

/**
 * Transferts Controller
 *
 * @property Transfert $Transfert
 */
class TransfertsController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $lien = CakeSession::read('lien_stock');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'transferts') {
                    $vente = 1;
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Exercice');
        $this->loadModel('Depot');
        $this->loadModel('Pointdevente');


        $exercices = $this->Exercice->find('list');
        $depots = $this->Depot->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condb4 = 'Transfert.exercice_id =' . $exe;

        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Transferts"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Recherche']);
            } else {
                $this->request->data['Recherche'] = CakeSession::read('recherche');
            }
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $condb4 = 'Transfert.exercice_id =' . $exercices[$exerciceid];
            }

            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $condb1 = 'Transfert.date >= ' . "'" . $date1 . "'";
                $condb4 = "";
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $condb2 = 'Transfert.date <= ' . "'" . $date2 . "'";
                $condb4 = "";
            }

            if ($this->request->data['Recherche']['depot_id']) {
                $depotid = $this->request->data['Recherche']['depot_id'];
                $condb3 = 'Transfert.depotarrive =' . $depotid;
            }
        }
        $transferts = $this->Transfert->find('all', array(
            'conditions' => array('Transfert.id > ' => 0, @$condb1, @$condb2, @$condb3, @$condb4)
            , 'recursive' => 0));

        $pointventes = $this->Pointdevente->find('list');

        $this->set(compact('transferts', 'exerciceid', 'pointventes', 'exercices', 'date1', 'date2', 'depots', 'depotid'));
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_stock');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'transferts') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Transfert.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Transfert.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['depotid']) {
            $depotid = $this->request->query['depotid'];
            $cond3 = 'Transfert.depotarrive =' . $depotid;
        }
        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $cond4 = 'Transfert.exercice_id =' . $exerciceid;
        }
        $transferts = $this->Transfert->find('all', array(
            'conditions' => array('Transfert.id > ' => 0, @$condb1, @$condb2, @$condb3, @$condb4)
        ));
        $this->loadModel('Depot');
        $depots = $this->Depot->find('list');

        $this->set(compact('transferts', 'date1', 'date2', 'depotid', 'exerciceid', 'depots'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    /* public function view($id = null) {
      $lien = CakeSession::read('lien_stock');
      $vente = "";
      if (!empty($lien)) {
      foreach ($lien as $k => $liens) {
      if (@$liens['lien'] == 'transferts') {
      $vente = 1;
      }
      }
      }
      if (( $vente <> 1) || (empty($lien))) {
      $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
      }
      if (!$this->Transfert->exists($id)) {
      throw new NotFoundException(__('Invalid transfert'));
      }
      $options = array('conditions' => array('Transfert.' . $this->Transfert->primaryKey => $id));
      $this->set('transfert', $this->Transfert->find('first', $options));
      } */

    /**
     * add method
     *
     * @return void
     */
    public function add($societedepart = null, $societearrive = null, $typetransfert = null) {
        $lien = CakeSession::read('lien_stock');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'transferts') {
                    $vente = $liens['add'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignetransfert');
        $this->loadModel('Societe');
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        if ($this->request->is('post')) {
//            debug($this->request->data);
//            die;
            $this->request->data['Transfert']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Transfert']['date'])));
            $this->request->data['Transfert']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Transfert']['exercice_id'] = date("Y");
            if ($this->request->data['Transfert']['type'] == 0) {
                $this->request->data['Transfert']['societearrive'] = 0;
            }
            $this->Transfert->create();
            if ($this->Transfert->save($this->request->data)) {
                //$depotdepart=$this->request->data['Transfert']['depotdepart'];
                $depotarrive = $this->request->data['Transfert']['depotarrive'];
                $id = $this->Transfert->id;
                $this->misejour("Transfert", "add", $id);
                $Lignetransferts = array();
                $stockdepots = array();
                $tot_ht = 0;
                $tot_tva = 0;
                $tot_ttc = 0;
                foreach ($this->request->data['Lignetransfert'] as $numl => $f) {
                    if ($f['sup'] != 1) {
                        if (($f['article_id'] != '')) {
                            $Lignetransferts['article_id'] = $f['article_id'];
                            $Lignetransferts['quantite'] = $f['quantite'];
                            $Lignetransferts['depot_id'] = $this->request->data['Transfert']['depot_id'];
                            $Lignetransferts['remise'] = $f['remise'];
                            $Lignetransferts['transfert_id'] = $id;
                            $article = $this->Article->find('first', array('conditions' => array('Article.id' => $f['article_id']), 'recursive' => 0, false));
                            $Lignetransferts['tva'] = $article['Article']['tva'];
                            $Lignetransferts['remise'] = $f['remise'];
                            $Lignetransferts['prix'] = $article['Article']['prixvente'];
                            $rem = 0;
                            if ($f['remise'] != '') {
                                $rem = $article['Article']['prixvente'] * ($f['remise'] / 100);
                            }
                            $Lignetransferts['prixht'] = $article['Article']['prixvente'] - $rem;
                            $Lignetransferts['prixttc'] = ($Lignetransferts['prixht'] * (1 + ($article['Article']['tva'] / 100)));
                            $this->Lignetransfert->create();
                            $this->Lignetransfert->save($Lignetransferts);
                            /* $tot_ht=$tot_ht+($article['Article']['prixvente']*$f['quantite']);
                              $tot_ttc=$tot_ttc+(($article['Article']['prixvente']*$f['quantite'])*(1+($article['Article']['tva']/100))); */
                            $mnt = $Lignetransferts['prixht'] * $f['quantite'];
                            $tot_ht = $tot_ht + $mnt;
                            $tot_ttc = $tot_ttc + ($Lignetransferts['prixttc'] * $f['quantite']);
                            $tot_tva = $tot_ttc - $tot_ht;
                            $id_ligne = $this->Lignetransfert->id;
                            $qte_sorti = $f['quantite'];
                            // Mise à jour stockdepot depot départ
                            $stckdepotd = $this->Stockdepot->find('first', array(
                                'conditions' => array('Stockdepot.article_id' => $f['article_id'],
                                    'Stockdepot.depot_id' => $this->request->data['Transfert']['depot_id']), false));
                            //debug($stckdepot);
                            if ($stckdepotd != array()) {
                                $qte = $stckdepotd['Stockdepot']['quantite'] - $qte_sorti;
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepotd['Stockdepot']['id']));
                            } else {
                                $stkn = array();
                                $stkn['article_id'] = $f['article_id'];
                                $stkn['depot_id'] = $this->request->data['Transfert']['depot_id'];
                                $stkn['quantite'] = 0 - $qte_sorti;
                                $this->Stockdepot->create();
                                $this->Stockdepot->save($stkn);
                            }
                            // Mise à jour stockdepot depot arrivee
                            $stckdepota = $this->Stockdepot->find('first', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $depotarrive), false));
                            if ($stckdepota != array()) {
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $f['quantite']), array('Stockdepot.id' => $stckdepota['Stockdepot']['id']));
                            } else {
                                $stkn = array();
                                $stkn['article_id'] = $f['article_id'];
                                $stkn['quantite'] = $f['quantite'];
                                $stkn['depot_id'] = $depotarrive;
                                $this->Stockdepot->create();
                                $this->Stockdepot->save($stkn);
                            }
                        }
                    }
                }
                $this->Transfert->updateAll(array('Transfert.totht' => $tot_ht, 'Transfert.tottva' => $tot_tva, 'Transfert.totttc' => $tot_ttc), array('Transfert.id' => $id));
                $this->Session->setFlash(__('The transfert has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The transfert could not be saved. Please, try again.'));
            }
        }
        $numero = $this->Transfert->find('all', array(
            'conditions' => array('Transfert.exercice_id' => date('Y')),
            'fields' =>
            array(
                'MAX(Transfert.numero) as num'
        )));
        //debug($numero);die;
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
        $this->loadModel('Article');
        $this->loadModel('Depot');
        //$articles = $this->Article->find('list',array('conditions'=>array('Article.id<30')));
        if ($typetransfert == 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societedepart, 'Depot.typeetatarticle_id' => 1)));
            $depotarrives = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societedepart, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societedepart, 'Depot.typeetatarticle_id' => 1)));
            $depotarrives = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societearrive, 'Depot.typeetatarticle_id' => 1)));

            $pvdeparts = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societedepart)));
            $pvarrives = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societearrive)));
        }


        $utilisateurs = $this->Transfert->Utilisateur->find('list');
        $societedeparts = $this->Societe->find('list');
        $societearrives = $this->Societe->find('list');
        $this->set(compact('societearrive', 'pvdeparts', 'pvarrives', 'societedepart', 'typetransfert', 'societearrives', 'societedeparts', 'utilisateurs', 'articles', 'depots', 'depotarrives', 'mm'));
    }

    public function edit($id = null, $societedepart = null, $societearrive = null, $typetransfert = null) {
        $lien = CakeSession::read('lien_stock');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'transferts') {
                    $vente = $liens['edit'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignetransfert');
        $this->loadModel('Societe');
        $this->loadModel('Stockdepotfacture');
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        if (!$this->Transfert->exists($id)) {
            throw new NotFoundException(__('Invalid transfert'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
//            debug($this->request->data);die;
            $this->request->data['Transfert']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Transfert']['date'])));
            $this->request->data['Transfert']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Transfert']['exercice_id'] = date("Y");
            $depotarrive = $this->request->data['Transfert']['depotarrive'];
            $depotdepart = $this->request->data['Transfert']['depot_id'];
            if ($this->request->data['Transfert']['type'] == 0) {
                $this->request->data['Transfert']['societearrive'] = 0;
            }
            $tansfert = $this->Transfert->find('first', array('conditions' => array('Transfert.id' => $id), false));
            $depotarriveans = $tansfert['Transfert']['depotarrive'];
            $depotdepartans = $tansfert['Transfert']['depot_id'];
            $lignetransfets = $this->Lignetransfert->find('all', array('conditions' => array('Lignetransfert.transfert_id' => $id), false));
//            debug($lignetransfets);
//            die;
            //******************************************************************
            // Etat initale de stock
            foreach ($lignetransfets as $lra) {
                $stckdep = $this->Stockdepot->find('first', array(
                    'conditions' => array('Stockdepot.depot_id' => $depotdepartans, 'Stockdepot.article_id' => $lra['Lignetransfert']['article_id']),
                    'recursive' => -1
                ));
                if ($stckdep != array()) {
                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $lra['Lignetransfert']['quantite']), array('Stockdepot.id' => $stckdep['Stockdepot']['id']));
                } else {
                    $stkn = array();
                    $stkn['article_id'] = $lra['Lignetransfert']['article_id'];
                    $stkn['quantite'] = $lra['Lignetransfert']['quantite'];
                    $stkn['depot_id'] = $depotdepartans;
                    $this->Stockdepot->create();
                    $this->Stockdepot->save($stkn);
                }
                $stckarr = $this->Stockdepot->find('first', array(
                    'conditions' => array('Stockdepot.depot_id' => $depotarriveans, 'Stockdepot.article_id' => $lra['Lignetransfert']['article_id']),
                    'recursive' => -1
                ));
                 if ($stckarr != array()) {
                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite-' . $lra['Lignetransfert']['quantite']), array('Stockdepot.id' => $stckarr['Stockdepot']['id']));
                } else {
                    $stkn = array();
                    $stkn['article_id'] = $lra['Lignetransfert']['article_id'];
                    $stkn['quantite'] = $lra['Lignetransfert']['quantite'];
                    $stkn['depot_id'] = $depotarriveans;
                    $this->Stockdepot->create();
                    $this->Stockdepot->save($stkn);
                }
               
            }
            //******************************************************************
            if ($this->Transfert->save($this->request->data)) {
                $this->misejour("Transfert", "edit", $id);
                $Lignetransferts = array();
                $stockdepots = array();
                $tot_ht = 0;
                $tot_tva = 0;
                $tot_ttc = 0;
                $this->Lignetransfert->deleteAll(array('Lignetransfert.transfert_id' => $id), false);
                foreach ($this->request->data['Lignetransfert'] as $numl => $f) {
                    if ($f['sup'] != 1) {
                        if ( ($f['article_id'] != '')) {
                            $article = $this->Article->find('first', array('conditions' => array('Article.id' => $f['article_id']), 'recursive' => 0, false));
                            $Lignetransferts['prix'] = $article['Article']['prixvente'];
                            $rem = 0;
                            if ($f['remise'] != '') {
                                $rem = $article['Article']['prixvente'] * ($f['remise'] / 100);
                            }
                            $Lignetransferts['rem'] = $rem;
                            $Lignetransferts['prixht'] = $article['Article']['prixvente'] - $rem;
                            $Lignetransferts['tva'] = $article['Article']['tva'];
                            $Lignetransferts['prixttc'] = ($Lignetransferts['prixht'] * (1 + ($article['Article']['tva'] / 100)));
                            $Lignetransferts['remise'] = $f['remise'];
                            $Lignetransferts['depot_id'] = $depotdepart;
                            $Lignetransferts['article_id'] = $f['article_id'];
                            $Lignetransferts['quantite'] = $f['quantite'];
                            $Lignetransferts['transfert_id'] = $id;
                            //debug($Lignetransferts);
                            $this->Lignetransfert->create();
                            $this->Lignetransfert->save($Lignetransferts);
                            /* $tot_ht=$tot_ht+($Lignetransferts['prixht']*$f['quantite']);
                              $tot_ttc=$tot_ttc+(($Lignetransferts['prixht']*$f['quantite'])*(1+($Lignetransferts['tva']/100))); */
                            $mnt = $Lignetransferts['prixht'] * $f['quantite'];
                            $tot_ht = $tot_ht + $mnt;
                            $tot_ttc = $tot_ttc + ($Lignetransferts['prixttc'] * $f['quantite']);
                            $tot_tva = $tot_ttc - $tot_ht;
                            $id_ligne = $this->Lignetransfert->id;
                            $qte_sorti = $f['quantite'];

                            // Mise à jour stockdepot depot départ
                            $stckdepotd = $this->Stockdepot->find('first', array(
                                'conditions' => array('Stockdepot.article_id' => $f['article_id'],
                                    'Stockdepot.depot_id' => $depotdepart), false));
                            //debug($stckdepot);
                            if ($stckdepotd != array()) {
                                $qte = $stckdepotd['Stockdepot']['quantite'] - $qte_sorti;
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepotd['Stockdepot']['id']));
                            } else {
                                $stkn = array();
                                $stkn['article_id'] = $f['article_id'];
                                $stkn['depot_id'] = $depotdepart;
                                $stkn['quantite'] = 0 - $qte_sorti;
                                $this->Stockdepot->create();
                                $this->Stockdepot->save($stkn);
                            }
                            // Mise à jour stockdep
                            $stckdepota = $this->Stockdepot->find('first', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $depotarrive), false));
                            if ($stckdepota != array()) {
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $f['quantite']), array('Stockdepot.id' => $stckdepota['Stockdepot']['id']));
                            } else {
                                $stkn = array();
                                $stkn['article_id'] = $f['article_id'];
                                $stkn['quantite'] = $f['quantite'];
                                $stkn['depot_id'] = $depotarrive;
                                $this->Stockdepot->create();
                                $this->Stockdepot->save($stkn);
                            }
                        }
                    }
                }
                $this->Transfert->updateAll(array('Transfert.totht' => $tot_ht, 'Transfert.tottva' => $tot_tva, 'Transfert.totttc' => $tot_ttc), array('Transfert.id' => $id));
                $this->Session->setFlash(__('The transfert has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The transfert could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Transfert.' . $this->Transfert->primaryKey => $id));
            $this->request->data = $this->Transfert->find('first', $options);
        }
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $transferts = $this->Transfert->find('first', array('conditions' => array('Transfert.id' => $id)));
        $id = $transferts['Transfert']['id'];
        if (empty($societedepart)) {
            $typetransfert = $transferts['Transfert']['type'];
            $societedepart = $transferts['Transfert']['societedepart'];
            $societearrive = $transferts['Transfert']['societearrive'];
        }
        $lignetransferts = $this->Lignetransfert->find('all', array('conditions' => array('Lignetransfert.transfert_id' => $id), 'order' => array('Lignetransfert.id' => 'ASC'), 'recursive' => -1));
        //debug($lignetransferts);
        $tabt = array();
        $tabqte = array();
        /* foreach ($lignetransferts as $i => $lignetransfert) {
          $stckdepotqte = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $lignetransfert['Lignetransfert']['depot_id'], 'Stockdepot.article_id' => $lignetransfert['Lignetransfert']['article_id']), 'recursive' => -1));
          //debug($stckdepotqte);die;

          foreach ($stckdepotqte as $q => $qte) {
          $tabqte[$i] = $qte['Stockdepot']['quantite'];
          //debug($tabqte);
          }
          $articless = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $lignetransfert['Lignetransfert']['depot_id']), 'recursive' => -1));
          //debug($articless);
          $t = '(0,';
          foreach ($articless as $ad) {
          if (!empty($ad['Stockdepot']['article_id'])) {
          $a = '' . $ad['Stockdepot']['article_id'];
          if (!strstr($t, $a)) {
          $t = $t . $ad['Stockdepot']['article_id'] . ',';
          }
          }
          }
          $t = $t . '0)';
          $tabt[$i] = $t;


          //debug($t);
          // $articles=$this->Article->find('list', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
          } */
        //debug($tabt);die;
        //debug($tabqte);
        //$articles = $this->Article->find('list');
        $utilisateurs = $this->Transfert->Utilisateur->find('list');
        if ($typetransfert == 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societedepart, 'Depot.typeetatarticle_id' => 1)));
            $depotarrives = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societedepart, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societedepart, 'Depot.typeetatarticle_id' => 1)));
            $depotarrives = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societearrive, 'Depot.typeetatarticle_id' => 1)));
            $pvdeparts = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societedepart)));
            $pvarrives = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societearrive)));
        }

        $societedeparts = $this->Societe->find('list');
        $societearrives = $this->Societe->find('list');
        $this->set(compact('pvarrives', 'pvdeparts', 'id', 'societearrives', 'societedeparts', 'typetransfert', 'societedepart', 'societearrive', 'tabqte', 'tabt', 'articless', 'articles', 'utilisateurs', 'articles', 'depots', 'depotarrives', 'mm', 'transferts', 'lignetransferts'));
    }

    public function view($id = null, $societedepart = null, $societearrive = null, $typetransfert = null) {
        $lien = CakeSession::read('lien_stock');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'transferts') {
                    $vente = $liens['edit'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignetransfert');
        $this->loadModel('Societe');
        $this->loadModel('Stockdepotfacture');
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        if (!$this->Transfert->exists($id)) {
            throw new NotFoundException(__('Invalid transfert'));
        }

        $options = array('conditions' => array('Transfert.' . $this->Transfert->primaryKey => $id));
        $this->request->data = $this->Transfert->find('first', $options);

        $this->loadModel('Article');
        $this->loadModel('Depot');
        $transferts = $this->Transfert->find('first', array('conditions' => array('Transfert.id' => $id)));
        $id = $transferts['Transfert']['id'];
        if (empty($societedepart)) {
            $typetransfert = $transferts['Transfert']['type'];
            $societedepart = $transferts['Transfert']['societedepart'];
            $societearrive = $transferts['Transfert']['societearrive'];
        }
        $lignetransferts = $this->Lignetransfert->find('all', array('conditions' => array('Lignetransfert.transfert_id' => $id), 'order' => array('Lignetransfert.id' => 'ASC'), 'recursive' => -1));
        //debug($lignetransferts);
        $tabt = array();
        $tabqte = array();
        /* foreach ($lignetransferts as $i => $lignetransfert) {
          $stckdepotqte = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $lignetransfert['Lignetransfert']['depot_id'], 'Stockdepot.article_id' => $lignetransfert['Lignetransfert']['article_id']), 'recursive' => -1));
          //debug($stckdepotqte);die;

          foreach ($stckdepotqte as $q => $qte) {
          $tabqte[$i] = $qte['Stockdepot']['quantite'];
          //debug($tabqte);
          }
          $articless = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $lignetransfert['Lignetransfert']['depot_id']), 'recursive' => -1));
          //debug($articless);
          $t = '(0,';
          foreach ($articless as $ad) {
          if (!empty($ad['Stockdepot']['article_id'])) {
          $a = '' . $ad['Stockdepot']['article_id'];
          if (!strstr($t, $a)) {
          $t = $t . $ad['Stockdepot']['article_id'] . ',';
          }
          }
          }
          $t = $t . '0)';
          $tabt[$i] = $t;


          //debug($t);
          // $articles=$this->Article->find('list', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
          } */
        //debug($tabt);die;
        //debug($tabqte);
        //$articles = $this->Article->find('list');
        $utilisateurs = $this->Transfert->Utilisateur->find('list');
        if ($typetransfert == 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societedepart, 'Depot.typeetatarticle_id' => 1)));
            $depotarrives = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societedepart, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societedepart, 'Depot.typeetatarticle_id' => 1)));
            $depotarrives = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societearrive, 'Depot.typeetatarticle_id' => 1)));
            $pvdeparts = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societedepart)));
            $pvarrives = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societearrive)));
        }

        $societedeparts = $this->Societe->find('list');
        $societearrives = $this->Societe->find('list');
        $this->set(compact('pvarrives', 'pvdeparts', 'id', 'societearrives', 'societedeparts', 'typetransfert', 'societedepart', 'societearrive', 'tabqte', 'tabt', 'articless', 'articles', 'utilisateurs', 'articles', 'depots', 'depotarrives', 'mm', 'transferts', 'lignetransferts'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_stock');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'transferts') {
                    $vente = $liens['delete'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignetransfert');
        $this->loadModel('Factureclient');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Facture');
        $this->loadModel('Lignefacture');
        $this->Transfert->id = $id;
        if (!$this->Transfert->exists()) {
            throw new NotFoundException(__('Invalid transfert'));
        }
        $tansfert = $this->Transfert->find('first', array('conditions' => array('Transfert.id' => $id), false));
        $fact_vente = $tansfert['Transfert']['fact_vente'];
        $fact_achat = $tansfert['Transfert']['fact_achat'];
        //debug($fact_vente);die;
        $depotarrive = $tansfert['Transfert']['depotarrive'];
        $depotdepart = $tansfert['Transfert']['depot_id'];
        $numansar = $tansfert['Transfert']['numero'];
        $ancientransfert = $this->Transfert->find('first', array(
            'conditions' => array('Transfert.id' => $id),
            'recursive' => 1
        ));
//        debug($ancientransfert);die;
        foreach ($ancientransfert['Lignetransfert'] as $lra) {
//            debug($lra);
//            die;
            $stockdepart = $this->Stockdepot->find('first', array(
                'conditions' => array('Stockdepot.depot_id' => $depotdepart, 'Stockdepot.article_id' => $lra['article_id'])));
            if ($stockdepart == array()) {
                $stkn = array();
                $stkn['article_id'] = $lra['article_id'];
                $stkn['quantite'] = $lra['quantite'];
                $stkn['depot_id'] = $depotdepart;
                $this->Stockdepot->create();
                $this->Stockdepot->save($stkn);
            } else {
                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite +' . $lra['quantite']), array('Stockdepot.depot_id' => $lra['depot_id'], 'Stockdepot.article_id' => $lra['article_id']));
            }
            $stockarrive = $this->Stockdepot->find('first', array(
                'conditions' => array('Stockdepot.depot_id' => $depotarrive, 'Stockdepot.article_id' => $lra['article_id'])));
            if ($stockarrive == array()) {
                $stkn = array();
                $stkn['article_id'] = $lra['article_id'];
                $stkn['quantite'] = 0 - $lra['quantite'];
                $stkn['depot_id'] = $depotarrive;
                $this->Stockdepot->create();
                $this->Stockdepot->save($stkn);
            } else {
                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite -' . $lra['quantite']), array('Stockdepot.depot_id' => $ancientransfert['Transfert']['depotarrive'], 'Stockdepot.article_id' => $lra['article_id']));
            }
        }


        //$this->Stockdepot->deleteAll(array('Stockdepot.quantite'=>0),false);
        $this->Lignetransfert->deleteAll(array('Lignetransfert.transfert_id' => $id), false);
        $this->Factureclient->deleteAll(array('Factureclient.id' => $fact_vente), false);
        $this->Lignefactureclient->deleteAll(array('Lignefactureclient.factureclient_id' => $fact_vente), false);
        $this->Facture->deleteAll(array('Facture.id' => $fact_achat), false);
        $this->Lignefacture->deleteAll(array('Lignefacture.facture_id' => $fact_achat), false);
        $this->request->onlyAllow('post', 'delete');
        if ($this->Transfert->delete()) {
            $this->misejour("Transfert", $numansar, $id);
            $this->Session->setFlash(__('Transfert deleted'));
            CakeSession::write('view', "delete");
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Transfert was not deleted'));
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
        // $index=$data['index']; 
        $name = 'article_id';
        $artdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $depotid), 'recursive' => -1));
        // debug($fourdevises);
        $t = '(0,';
        foreach ($artdepot as $ad) {
            if (!empty($ad['Stockdepot']['article_id'])) {
                $a = '' . $ad['Stockdepot']['article_id'];
                if (!strstr($t, $a)) {
                    $t = $t . $ad['Stockdepot']['article_id'] . ',';
                }
            }
        }
        $t = $t . '0)';
        //debug($t);
        $id = 'article_id';
//             if ($depotid != 0) { 
//            $articles=$this->Article->find('all', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
//            $select="<select   name='data[Lignetransfert][".$index."][article_id]' table='Lignetransfert'  champ='article_id' id=article_id".$index." class='select form-control' onchange='qteart($index)'>";
//            $select=$select."<option value=''>"."choix"."</option>";
//            foreach($articles as $v){
//                $select=$select."<option value=".$v['Article']['id'].">".$v['Article']['name']."</option>";
//            }
//            $select=$select.'</select>';
//          
//             }
//             else{
        $articles = $this->Article->find('all');
        $select = "<select   name='data[Lignetransfert][" . $index . "][article_id]' table='Lignetransfert'  champ='article_id' id=article_id" . $index . " class='select form-control' onchange='qteart($index)'>";
        $select = $select . "<option value=''>" . "choix" . "</option>";
        foreach ($articles as $v) {
            $select = $select . "<option value=" . $v['Article']['id'] . ">" . $v['Article']['code'] . " " . $v['Article']['name'] . "</option>";
        }
        $select = $select . '</select>';

        //}

        echo json_encode(array('select' => $select));
        die();
    }

    public function imprimer($id = NULL) {
        $lien = CakeSession::read('lien_stock');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'transferts') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Lignetransfert');
        $this->loadModel('Pointdevente');
        $this->loadModel('Client');

        $transfers = $this->Transfert->find('first', array('conditions' => array('Transfert.id' => $id), 'recursive' => 0));
        //debug($transfers);die;
        $listelignetransfert = $this->Lignetransfert->find('all', array('conditions' => array('Lignetransfert.transfert_id' => $id)));
        //debug($listelignetransfert);die;
        $depots = $this->Depot->find('list');
        $lignetransfertstva = $this->Lignetransfert->find('all', array('fields' => array(
                'SUM(Lignetransfert.quantite*Lignetransfert.prixht*Lignetransfert.tva)/100  mtva'
                , 'SUM(Lignetransfert.quantite*Lignetransfert.prixht) totalht'
                , 'AVG(Lignetransfert.tva) tva'),
            'conditions' => array('Lignetransfert.transfert_id' => $id)
            , 'group' => array('Lignetransfert.tva')
        ));
        $pointventes = $this->Pointdevente->find('list');
        $client = $this->Client->find('first', array('conditions' => array('Client.societe_id' => $transfers['Transfert']['societearrive']), 'recursive' => -1));
        $this->set(compact('listelignetransfert', 'transfers', 'pointventes', 'depots', 'client', 'lignetransfertstva'));
    }

    public function imprimertest($id = NULL) {
        $lien = CakeSession::read('lien_stock');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'transferts') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Lignetransfert');
        $transfers = $this->Transfert->find('first', array('conditions' => array('Transfert.id' => $id), 'recursive' => 0));
        // debug($bonreceptions);die;
        $listelignetransfert = $this->Lignetransfert->find('all', array('conditions' => array('Lignetransfert.transfert_id' => $id)));
        //debug($listelignetransfert);die;
        $depotdeparts = $this->Depot->find('list');
        $this->set(compact('listelignetransfert', 'transfers', 'depotdeparts'));
    }

    public function facture_vente($id_trans = null) {
        $lien = CakeSession::read('lien_stock');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'transferts') {
                    $vente = $liens['edit'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignetransfert');
        $this->loadModel('Societe');
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        $this->loadModel('Client');
        $this->loadModel('Factureclient');
        $this->loadModel('Timbre');
        $transferts = $this->Transfert->find('first', array('conditions' => array('Transfert.id' => $id_trans), 'recursive' => 1));
        //debug($transferts);die;

        $data['date'] = date("Y-m-d");
        $data['utilisateur_id'] = CakeSession::read('users');
        $data['type'] = 'direct';
        $data['exercice_id'] = date("Y");
        $client = $this->Client->find('first', array('conditions' => array('Client.societe_id' => $transferts['Transfert']['societearrive']), 'recursive' => -1));
        $data['client_id'] = $client['Client']['id'];
        $data['name'] = $client['Client']['name'];
        $pv = $data['pointdevente_id'] = $transferts['Transfert']['pvarrive'];
        $data['transfert'] = 1;
        $numero = $this->Factureclient->find('all', array('fields' => array('MAX(Factureclient.numeroconca) as num'),
            'conditions' => array('Factureclient.pointdevente_id' => $pv, 'Factureclient.exercice_id' => date("Y")))
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

        $data['numeroconca'] = $mm;
        $data['numero'] = $numspecial;

        $this->Factureclient->create();
        if (!empty($transferts['Lignetransfert'])) {
            if ($this->Factureclient->save($data)) {
                $id = $this->Factureclient->id;
                $this->misejour("Factureclient", "add", $id);
                // debug($id);die;
                $Lignefactureclients = array();
                $stockdepots = array();
                // debug($this->request->data );die;
                $ttc = 0;
                $ht = 0;
                foreach ($transferts['Lignetransfert'] as $numl => $f) {

                    $article = $this->Article->find('first', array('conditions' => array('Article.id' => $f['article_id']), 'recursive' => -1));
                    $ht = $ht + $f['quantite'] * $article['Article']['prixvente'];
                    $ttc = $ttc + $f['quantite'] * $article['Article']['prixuttc'];
                    //debug($f);die;
                    $Lignefactureclients['factureclient_id'] = $id;
                    $Lignefactureclients['article_id'] = $f['article_id'];
                    $Lignefactureclients['depot_id'] = $f['depot_id'];
                    $Lignefactureclients['quantite'] = $f['quantite'];
                    $Lignefactureclients['remise'] = 0;
                    $Lignefactureclients['tva'] = $article['Article']['tva'];
                    $Lignefactureclients['prix'] = $article['Article']['prixvente'];
                    $Lignefactureclients['prixnet'] = $article['Article']['prixvente'];
                    $Lignefactureclients['puttc'] = $article['Article']['prixuttc'];
                    $Lignefactureclients['designation'] = $article['Article']['name'];
                    $Lignefactureclients['name'] = $article['Article']['name'];
                    $Lignefactureclients['totalht'] = $f['quantite'] * $article['Article']['prixvente'];
                    $Lignefactureclients['totalttc'] = $f['quantite'] * $article['Article']['prixuttc'];
                    // debug($Lignefactureclients);die;
                    $this->Lignefactureclient->create();
                    $this->Lignefactureclient->save($Lignefactureclients);
                }
                $tva = $ttc - $ht;
                $timbr = $this->Timbre->find('first', array('conditions' => array('Timbre.id' => 1)));
                $timb = $timbr['Timbre']['timbre'];
                $ttc = $ttc + $timb;
                $this->Factureclient->updateAll(array('Factureclient.tva' => $tva, 'Factureclient.totalht' => $ht, 'Factureclient.totalttc' => $ttc, 'Factureclient.remise' => 0), array('Factureclient.id' => $id));
                $this->Transfert->updateAll(array('Transfert.fact_vente' => $id), array('Transfert.id' => $id_trans));

                $this->Session->setFlash(__('The Factureclient has been saved'));
                $this->redirect(array('action' => 'index'));
                //$this->redirect(array('action' => 'addbonsorti/'.$id));    
            }
        }
    }

    public function facture_achat($id_trans = null) {
        $lien = CakeSession::read('lien_stock');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'transferts') {
                    $vente = $liens['edit'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Lignefacture');
        $this->loadModel('Stockdepot');
        $this->loadModel('Fournisseur');
        $this->loadModel('Tracemodificationprixdevente');
        $this->loadModel('Pointdevente');
        $this->loadModel('Facture');
        $this->loadModel('Fournisseur');
        $this->loadModel('Stockdepotfacture');
        $this->loadModel('Timbre');





        $transferts = $this->Transfert->find('first', array('conditions' => array('Transfert.id' => $id_trans), 'recursive' => 1));

        //debug($transferts);die;
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

        $data['date'] = date("Y-m-d");
        $data['datefacture'] = date("Y-m-d");
        $data['utilisateur_id'] = CakeSession::read('users');
        $pv = $data['pointdevente_id'] = $transferts['Transfert']['pvdepart'];
        $data['exercice_id'] = date("Y");
        $data['type'] = 'direct';
        $data['numeroconca'] = $mm;
        $data['transfert'] = 1;

        $client = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.societe_id' => $transferts['Transfert']['societedepart']), 'recursive' => -1));
        $data['fournisseur_id'] = $client['Fournisseur']['id'];

        //$depotid=$data['depot_id'];
        $this->Facture->create();
        if ($this->Facture->save($data)) {

            $id = $this->Facture->id;

            $this->misejour("Facture", "add", $id);
            $Lignefactures = array();
            //debug($this->request->data['Lignereception']);
            //die;
            $ttc = 0;
            $ht = 0;
            foreach ($transferts['Lignetransfert'] as $i => $f) {

                $stk = $this->Stockdepotfacture->find('first', array('conditions' => array('Stockdepotfacture.piece' => 'Transfert', 'Stockdepotfacture.ligne' => $f['id'])));


                $article = $this->Article->find('first', array('conditions' => array('Article.id' => $f['article_id']), 'recursive' => -1));
                $ht = $ht + $f['quantite'] * $article['Article']['prixvente'];
                $ttc = $ttc + $f['quantite'] * $article['Article']['prixuttc'];


                $Lignefactures['prixachatans'] = $article['Article']['prixvente'];
                $Lignefactures['facture_id'] = $id;
                $Lignefactures['depot_id'] = $transferts['Transfert']['depotarrive'];
                $Lignefactures['article_id'] = $f['article_id']; //=$this->request->data['Lignefacture'][$i]['article_id'];
                $Lignefactures['quantite'] = $f['quantite'];
                $Lignefactures['prix'] = $article['Article']['prixvente'];
                $Lignefactures['prix_anc'] = $article['Article']['prixvente'];
                $Lignefactures['prixhtva'] = $article['Article']['prixvente'];
                $Lignefactures['remise'] = 0;
                $Lignefactures['fodec'] = 0;
                $Lignefactures['tva'] = $article['Article']['tva'];

                //stockdepotfacture  articel , 

                $Lignefactures['totalht'] = $f['quantite'] * $article['Article']['prixvente'];
                $Lignefactures['totalttc'] = $f['quantite'] * $article['Article']['prixuttc'];
                $this->Lignefacture->create();
                $this->Lignefacture->save($Lignefactures);
            }

            $tva = $ttc - $ht;
            $timbr = $this->Timbre->find('first', array('conditions' => array('Timbre.id' => 1)));
            $timb = $timbr['Timbre']['timbre'];
            $ttc = $ttc + $timb;
            $this->Facture->updateAll(array('Facture.tva' => $tva, 'Facture.totalht' => $ht, 'Facture.totalttc' => $ttc, 'Facture.remise' => 0), array('Facture.id' => $id));
            $this->Transfert->updateAll(array('Transfert.fact_achat' => $id), array('Transfert.id' => $id_trans));




            $this->Session->setFlash(__('The facture has been saved'));
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
        }



        //debug($transferts);die;
    }

    public function transfert_facture($tab = null) {
        //debug($tab);die;
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
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        $this->loadModel('Lignetransfert');
        $this->loadModel('Timbre');
        $this->loadModel('Client');
        $this->loadModel('Factureclient');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Tracemodificationprixdevente');
        $this->loadModel('Lignefacture');
        $this->loadModel('Facture');
        $this->loadModel('Stockdepotfacture');
        $this->loadModel('Fournisseur');
        if ($this->request->is('post')) {
//            debug($this->request->data);
//            die;
            //---------- Factureclient -----------
            $this->request->data['Factureclient']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureclient']['date'])));
            $this->request->data['Factureclient']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureclient']['type'] = 'direct';
            $this->request->data['Factureclient']['pointdevente_id'] = $this->request->data['Factureclient']['lepv_depart'];
            $this->request->data['Factureclient']['exercice_id'] = date("Y");
            $this->request->data['Factureclient']['pointdevente_id'] = $this->request->data['Factureclient']['lepv_depart'];
            $this->request->data['Factureclient']['depot_id'] = $this->request->data['Lignetransfert'][0]['depot_id'];
            $lepv_depart = $this->request->data['Factureclient']['lepv_depart'];
            $numero = $this->Factureclient->find('all', array('fields' => array('MAX(Factureclient.numeroconca) as num'),
                'conditions' => array('Factureclient.pointdevente_id' => $lepv_depart, 'Factureclient.exercice_id' => date("Y")))
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


            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $lepv_depart)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
            $this->request->data['Factureclient']['numeroconca'] = $mm;
            $this->request->data['Factureclient']['numero'] = $numspecial;
            $this->Factureclient->create();
            if (!empty($this->request->data['Lignetransfert'])) {
                if ($this->Factureclient->save($this->request->data['Factureclient'])) {
                    $id = $this->Factureclient->id;
                    $fact_cl = $id;
                    $this->misejour("Factureclient", "add", $id);
                    // debug($id);die;
                    $Lignefactureclients = array();
                    $stockdepots = array();
                    // debug($this->request->data );die;
                    foreach ($this->request->data['Lignetransfert'] as $numl => $f) {
                        //debug($f);die;
                        if ($f['sup'] != 1) {
                            $stockdepots[$numl]['quantite'] = $f['quantite'];
                            $Lignefactureclients['factureclient_id'] = $id;
                            $Lignefactureclients['lignetransfert_id'] = $f['ligne_id'];
                            $Lignefactureclients['article_id'] = $f['article_id'];
                            $Lignefactureclients['depot_id'] = $f['depot_id'];
                            $Lignefactureclients['quantite'] = $f['quantite'];
                            $Lignefactureclients['remise'] = $f['remise'];
                            $Lignefactureclients['tva'] = $f['tva'];
                            $Lignefactureclients['prix'] = $f['prixhtva'];
                            $Lignefactureclients['prixnet'] = $f['prixnet'];
                            $Lignefactureclients['puttc'] = $f['puttc'];
                            $Lignefactureclients['totalhtans'] = $f['totalhtans'];
                            $Lignefactureclients['designation'] = $f['code'];
                            $Lignefactureclients['totalht'] = $f['totalht'];
                            $Lignefactureclients['totalttc'] = $f['totalttc'];
                            // debug($Lignefactureclients);die;
                            $this->Lignefactureclient->create();
                            $this->Lignefactureclient->save($Lignefactureclients);
                        }
                    }
                    /* $this->Session->setFlash(__('The Factureclient has been saved'));
                      $this->redirect(array('action' => 'index'));
                      //$this->redirect(array('action' => 'addbonsorti/'.$id)); */
                }
                /* else {
                  $this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                  } */
            }
            //------------ Facture Fournisseur ------
            //debug($this->request->data);die;
            $this->request->data['Facture'] = $this->request->data['Factureclient'];
            $this->request->data['Facture']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureclient']['date'])));
            $this->request->data['Facture']['datefacture'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureclient']['date'])));
            $this->request->data['Facture']['utilisateur_id'] = CakeSession::read('users');
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

            $this->request->data['Facture']['numeroconca'] = $mm;
            $this->request->data['Facture']['numero'] = $numspecial;
            $this->request->data['Facture']['pointdevente_id'] = @$this->request->data['Factureclient']['lepv_arrive'];
            $this->request->data['Facture']['exercice_id'] = date("Y");
            $this->request->data['Facture']['type'] = 'direct';
            $this->request->data['Facture']['fournisseur_id'] = $this->request->data['Factureclient']['fournisseur_id'];
//            debug($this->request->data);die;
            $this->Facture->create();
            if ($this->Facture->save($this->request->data['Facture'])) {

                $id = $this->Facture->id;
                $fact_fr = $id;
                $this->misejour("Facture", "add", $id);
                $Lignefactures = array();
                //debug($this->request->data['Lignereception']);
                //die;
                foreach ($this->request->data['Lignetransfert'] as $i => $f) {

                    //debug($f);die;
                    if ($f['sup'] != 1) {
                        $stkdepfacts = $this->Stockdepotfacture->find('all', array('conditions' => array('Stockdepotfacture.piece' => 'Transfert', 'Stockdepotfacture.id_piece' => $f['transfert_id'],
                                'Stockdepotfacture.ligne' => $f['ligne_id']), 'recursive' => -1));
                        $ch_id = 0;
                        if (!empty($stkdepfacts)) {
                            foreach ($stkdepfacts as $stkdepfact) {
                                $ch_id = $ch_id . ',' . $stkdepfact['Stockdepotfacture']['stockdepot_id'];
                            }
                            $stock = $this->Stockdepot->find('first', array('conditions' => array('Stockdepot.id in (' . $ch_id . ')')));
                        }
                        //$Lignefactures['prixachatans'] = $f['prixachatans'];
                        //$Lignefactures['margeans'] = $f['margeans'];
                        $Lignefactures['facture_id'] = $id;
                        $Lignefactures['lignetransfert_id'] = $f['ligne_id'];

                        $Lignefactures['depot_id'] = $f['depot_id'];
                        $depotid = $f['depot_id'];
                        $Lignefactures['article_id'] = $f['article_id']; //=$this->request->data['Lignefacture'][$i]['article_id'];
                        $Lignefactures['quantite'] = $f['quantite'];
                        if (!empty($f['prix'])) {
                            $Lignefactures['prix'] = $f['prix'];
                            $Lignefactures['prix_anc'] = $f['prix_anc'];
                        }
                        $Lignefactures['prixhtva'] = $f['prixhtva'];
                        $Lignefactures['remise'] = @$f['remise'];
                        $Lignefactures['fodec'] = @$f['fodec'];
                        $Lignefactures['tva'] = $f['tva'];
                        $Lignefactures['prixnet'] = $f['prixnet'];
                        $Lignefactures['prix'] = $f['prixnet'];
                        $Lignefactures['prixhtva'] = $f['prixhtva'];
                        $Lignefactures['puttc'] = $f['puttc'];
                        $Lignefactures['prixhtva'] = $f['prixhtva'];
                        $Lignefactures['totalht'] = ($f['prixhtva'] * (1 - @$f['remise'] * 0.01)) * $f['quantite'];
                        $Lignefactures['totalttc'] = ((($Lignefactures['totalht']) * (1 + (@$f['fodec'] * 0.01))) * (1 + ($f['tva'] * 0.01)));
                        $this->Lignefacture->create();
                        $this->Lignefacture->save($Lignefactures);
                        //$this->Article->updateAll(array('Article.coutrevient' => $f['prixhtva'], 'Article.tauxchange' => 1, 'Article.coefficient' => 1), array('Article.id' => $f['article_id']));
                        if ((!empty($f['margeA'])) || (!empty($f['pvA']))) {
                            $trace = array();
                            $aticle = $this->Article->find('first', array('conditions' => array('Article.id' => $f['article_id'])));
                            $marge_ans = $aticle['Article']['marge'];
                            $prixvente_ans = $aticle['Article']['prixvente'];
                            //$this->Article->updateAll(array('Article.prixvente' => $f['pvA'], 'Article.marge' => $f['margeA']), array('Article.id' => $f['article_id']));
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
                    }
                }
            }



            $this->Transfert->updateAll(array('Transfert.fact' => 1, 'Transfert.fact_vente' => $fact_cl, 'Transfert.fact_achat' => $fact_fr), array('Transfert.id in (' . $tab . ')'));


            $this->Session->setFlash(__('The facture has been saved'));
            $this->redirect(array('action' => 'index'));
        }
        $lignetransferts = $this->Lignetransfert->find('all', array('conditions' => array('Lignetransfert.transfert_id in(' . $tab . ')'), 'order' => array('Lignetransfert.id' => 'ASC'), 'recursive' => 0));
        $date_trans = $lignetransferts[0]['Transfert']['date'];
        $lepv_depart = $lignetransferts[0]['Transfert']['pvdepart'];
        $lepv_arrive = $lignetransferts[0]['Transfert']['pvarrive'];
        $societe_arrive = $lignetransferts[0]['Transfert']['societearrive'];
//        $transf = $this->Transfert->find('all', array('conditions' => array('Transfert.id'=>$id), 'recursive' => -1));

        $liste_pointvente_arrive = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_arrive)));
        //debug($liste_pointvente_arrive);
        $abc = '0';
        foreach ($liste_pointvente_arrive as $l_pointvente_arrive) {
            if (!empty($l_pointvente_arrive['Pointdevente']['id'])) {
                $abc = $abc . ',' . $l_pointvente_arrive['Pointdevente']['id'];
            }
        }
        //  debug($abc);
        $cond_bl = 'Bonlivraison.pointdevente_id in (' . $abc . ')';
        $cond_fac = 'Factureclient.pointdevente_id in (' . $abc . ')';
        $cond_ticket = 'Ticketcaiss.pointvente_id in (' . $abc . ')';
        if ($lepv_depart != 0) {
            $numero = $this->Factureclient->find('all', array('fields' => array('MAX(Factureclient.numeroconca) as num'),
                'conditions' => array('Factureclient.pointdevente_id' => $lepv_depart, 'Factureclient.exercice_id' => date("Y")))
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

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $lepv_depart)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
//            debug($numspecial);die;
        } else {
            $mm = 0;
        }

        $utilisateurs = $this->Utilisateur->find('list');
        $p = CakeSession::read('depot');
        $timbre = $this->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $pointdeventes = $this->Pointdevente->find('list');
        //$articles = $this->Article->find('list', array('conditions' => array('Article.typeetatarticle_id' => 1), 'recursive' => -1));

        //$clients = $this->Client->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
        'conditions' => array('Client.societe'=>$composantsoc)));
//        debug($lignetransferts[0]['Transfert']['societearrive']);die;
        $client = $this->Client->find('first', array('conditions' => array('Client.societe_id' => $lignetransferts[0]['Transfert']['societearrive']), 'recursive' => -1));
//        debug($client);die;
        $fr = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.societe_id' => $lignetransferts[0]['Transfert']['societedepart']), 'recursive' => -1));
//        debug($fr);die;
        $this->set(compact('cond_ticket', 'cond_fac', 'cond_bl', 'societe_arrive', 'articles', 'pointdeventes', 'lepv_depart', 'date_trans', 'lepv_arrive', 'client', 'fr', 'clients', 'timbre', 'fr_id', 'utilisateurs', 'depots', 'mm', 'numspecial', 'lignetransferts'));
    }

}
