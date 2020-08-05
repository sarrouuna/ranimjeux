<?php

App::uses('AppController', 'Controller');

/**
 * Inventaires Controller
 *
 * @property Inventaire $Inventaire
 */
class InventairesController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = 1;
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Inventaires"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Inventaire']);
            } else {
                $this->request->data['Inventaire'] = CakeSession::read('recherche');
            }
            if ($this->request->data['Inventaire']['date1'] != "__/__/____") {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Inventaire']['date1'])));
                $cond1 = 'Inventaire.date >= ' . "'" . $date1 . "'";
            }

            if ($this->request->data['Inventaire']['date2'] != "__/__/____") {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Inventaire']['date2'])));
                $cond2 = 'Inventaire.date <= ' . "'" . $date2 . "'";
            }

            if ($this->request->data['Inventaire']['depot_id']) {
                $depotid = $this->request->data['Inventaire']['depot_id'];
                $cond3 = 'Inventaire.depot_id =' . $depotid;
            }
        }
        $inventaires = $this->Inventaire->find('all', array('conditions' => array('Inventaire.type' => 1, @$cond1, @$cond2, @$cond3)));
        // debug($inventaires);die;

        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $this->set(compact('date1', 'date2', 'depotid', 'depots', 'inventaires', $this->paginate()));
    }

    public function indexpararticle() {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = 1;
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Ligneinventaire');
        $this->loadModel('Article');
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Inventaires"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Inventaire']);
            } else {
                $this->request->data['Inventaire'] = CakeSession::read('recherche');
            }
            if ($this->request->data['Inventaire']['date1'] != "__/__/____") {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Inventaire']['date1'])));
                $cond1 = 'Inventaire.date >= ' . "'" . $date1 . "'";
            }

            if ($this->request->data['Inventaire']['date2'] != "__/__/____") {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Inventaire']['date2'])));
                $cond2 = 'Inventaire.date <= ' . "'" . $date2 . "'";
            }

            if ($this->request->data['Inventaire']['article_id']) {
                $depotid = $this->request->data['Inventaire']['article_id'];
                $cond3 = 'Ligneinventaire.article_id =' . $depotid;
            }
        }
        //$inventaires = $this->Inventaire->find('all', array('conditions' => array('Inventaire.type' => 2, @$cond1, @$cond2, @$cond3)));
        // debug($inventaires);die;
        $inventaires = $this->Ligneinventaire->find('all', array('conditions' => array('Inventaire.type' => 2, @$cond1, @$cond2, @$cond3), 'group' => array('Ligneinventaire.article_id', 'Ligneinventaire.inventaire_id')));

        $articles = $this->Article->find('list');
        $this->set(compact('date1', 'date2', 'depotid', 'articles', 'inventaires', $this->paginate()));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = 1;
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Ligneinventaire');
        $this->loadModel('Article');
        if (!$this->Inventaire->exists($id)) {
            throw new NotFoundException(__('Invalid inventaire'));
        }
        $options = array('conditions' => array('Inventaire.' . $this->Inventaire->primaryKey => $id));
        $this->set('inventaire', $this->Inventaire->find('first', $options));
        $articles = $this->Article->find('list', array('fields' => array('Article.name')));
        ;
        $ligneinvents = $this->Ligneinventaire->find('all', array(
            'conditions' => array('Ligneinventaire.inventaire_id' => $id)
        ));
        $this->set(compact('ligneinvents', 'articles'));
    }

    public function viewpararticle($id = NULL, $valide = NULL) {

        $this->loadModel('Depot');
        $this->loadModel('Article');
        $this->loadModel('Homologation');
        $this->loadModel('Ligneinventaire');
        $this->loadModel('Stockdepot');
        $this->loadModel('Copiestockdepot');
        $this->loadModel('Lignecopiestock');
        $this->loadModel('Bonecart');
        $inventaire = $this->Inventaire->find('first', array('conditions' => array('Inventaire.id' => $id)));
        $articleinventaires = $this->Ligneinventaire->find('first', array('conditions' => array('Ligneinventaire.inventaire_id' => $id), 'group' => array('Ligneinventaire.article_id')));
        //debug($articleinventaires);
        $ligneinventaires = $this->Ligneinventaire->find('all', array('conditions' => array('Ligneinventaire.inventaire_id' => $id), 'order' => array('Ligneinventaire.id' => 'ASC')));
        $articles = $this->Article->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $depot_touts = $this->Depot->find('all', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $this->set(compact('articleinventaires', 'ligneinventaires', 'inventaire', 'depots', 'articles', 'mm', 'depot_touts'));
    }

    public function imprimer($id = null) {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = $liens['imprimer'];
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Ligneinventaire');
        if (!$this->Inventaire->exists($id)) {
            throw new NotFoundException(__('Invalid inventaire'));
        }
        $inventaire = $this->Inventaire->find('first', array('conditions' => array('Inventaire.id' => $id),'recursive'=>-1,'contain'=>array('Depot')));
        $ligneinvents = $this->Ligneinventaire->find('all', array(
            'conditions' => array('Ligneinventaire.inventaire_id' => $id), 'order' => array('Ligneinventaire.id' => 'ASC'),'recursive'=>-1
        ));
        //debug($inventaire);
//        debug($ligneinvents);die;
        $this->set(compact('ligneinvents','inventaire'));
    }
    public function exportlistetout($id = null) {
        $this->layout = null;
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = $liens['imprimer'];
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Ligneinventaire');
        if (!$this->Inventaire->exists($id)) {
            throw new NotFoundException(__('Invalid inventaire'));
        }
        $inventaire = $this->Inventaire->find('first', array('conditions' => array('Inventaire.id' => $id),'recursive'=>-1,'contain'=>array('Depot')));
        $ligneinvents = $this->Ligneinventaire->find('all', array(
            'conditions' => array('Ligneinventaire.inventaire_id' => $id), 'order' => array('Ligneinventaire.id' => 'ASC'),'recursive'=>-1
        ));
        //debug($inventaire);
//        debug($ligneinvents);die;
        $this->set(compact('ligneinvents','inventaire'));
    }

    public function imprimerpararticle($id = null) {
        $this->loadModel('Depot');
        $this->loadModel('Article');
        $this->loadModel('Homologation');
        $this->loadModel('Ligneinventaire');
        $this->loadModel('Stockdepot');
        $this->loadModel('Copiestockdepot');
        $this->loadModel('Lignecopiestock');
        $this->loadModel('Bonecart');
        $inventaire = $this->Inventaire->find('first', array('conditions' => array('Inventaire.id' => $id)));
        $articleinventaires = $this->Ligneinventaire->find('first', array('conditions' => array('Ligneinventaire.inventaire_id' => $id), 'group' => array('Ligneinventaire.article_id')));
        //debug($articleinventaires);
        $ligneinventaires = $this->Ligneinventaire->find('all', array('conditions' => array('Ligneinventaire.inventaire_id' => $id), 'order' => array('Ligneinventaire.id' => 'ASC')));
        $articles = $this->Article->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $depot_touts = $this->Depot->find('all', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $this->set(compact('articleinventaires', 'ligneinventaires', 'inventaire', 'depots', 'articles', 'mm', 'depot_touts'));
    }

    public function add() {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = $liens['add'];
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Ligneinventaire');
        $this->loadModel('Article');
        $this->loadModel('Homologation');
        $this->loadModel('Stockdepot');
        $this->loadModel('Copiestockdepot');
        $this->loadModel('Lignecopiestock');
        $this->loadModel('Bonecart');
        if ($this->request->is('post')) {
            //debug ($this->request->data);die;
            $this->request->data['Inventaire']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Inventaire']['dateinv'])));
            $this->request->data['Inventaire']['exercice_id'] = date("Y");
            $this->Inventaire->create();
            if ($this->Inventaire->save($this->request->data)) {
                $id = $this->Inventaire->id;
                $this->misejour("Inventaire", "add", $id);
                $this->Session->setFlash(__('The inventaire has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The inventaire could not be saved. Please, try again.'));
            }
        }
        $numero = $this->Inventaire->find('all', array('fields' =>
            array(
                'MAX(Inventaire.numero) as num'
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
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $this->set(compact('depots', 'articles', 'mm'));
    }

    public function addpararticle() {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = $liens['add'];
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Article');
        $this->loadModel('Homologation');
        $this->loadModel('Ligneinventaire');
        $this->loadModel('Stockdepot');
        $this->loadModel('Copiestockdepot');
        $this->loadModel('Lignecopiestock');
        $this->loadModel('Bonecart');
        if ($this->request->is('post')) {
//            debug ($this->request->data);die;
            $this->request->data['Inventaire']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Inventaire']['dateinv'])));
            $this->request->data['Inventaire']['exercice_id'] = date("Y");
            $this->request->data['Inventaire']['type'] = 2;
            $this->Inventaire->create();
            if ($this->Inventaire->save($this->request->data)) {
                $id = $this->Inventaire->id;
                $this->misejour("Inventaire", "add", $id);
                $numero = $this->Copiestockdepot->find('all', array('fields' =>
                    array('MAX(Copiestockdepot.numero) as num'),
                    'conditions' => array('Copiestockdepot.exercice_id' => date("Y"))
                ));
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
                $Copiestockdepot['numero'] = $mm;
                $Copiestockdepot['date'] = date("Y-m-d");
                $Copiestockdepot['heure'] = date("H:i", time());
                $Copiestockdepot['utilisateur_id'] = CakeSession::read('users');
                $Copiestockdepot['exercice_id'] = date("Y");
                $Copiestockdepot['inventaire_id'] = $id;
                $this->Copiestockdepot->create();
                if ($this->Copiestockdepot->save($Copiestockdepot)) {
                    $idcopie = $this->Copiestockdepot->id;
                    $stckdepots = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $this->request->data['Inventaire']['article_id']), 'recursive' => -1));
                    //debug($stckdepots);die;
                    foreach ($stckdepots as $stckdepot) {
                        if ($stckdepot['Stockdepot']['quantite'] != 0) {
                            $stckdepot['Stockdepot']['id'] = "";
                            $stckdepot['Stockdepot']['copiestockdepot_id'] = $idcopie;
                            $this->Lignecopiestock->create();
                            $this->Lignecopiestock->save($stckdepot['Stockdepot']);
                        }
                    }
                    $this->misejour("Copiestockdepot", "add", $id);
                }
                foreach ($this->request->data['Ligneinventaire'] as $ligneinventaire) {
//                    debug($ligneinventaire);die;
                    if ($ligneinventaire['sup'] != 1) {
                        $ligneinventaire['article_id'] = $this->request->data['Inventaire']['article_id'];
                        $ligneinventaire['inventaire_id'] = $id;
                        //debug($ligneinventaire);die;
                        $this->Ligneinventaire->create();
                        $this->Ligneinventaire->save($ligneinventaire);
                        $prixstocks = $this->Lignecopiestock->find('all', array('conditions' => array('Copiestockdepot.inventaire_id' => $id, 'Lignecopiestock.article_id' => $this->request->data['Inventaire']['article_id'])));
                        $prix = 0;
                        foreach ($prixstocks as $prixst) {
                            if (!empty($prixstocks['Lignecopiestock']['prix'])) {
                                $prix = $prixstocks['Lignecopiestock']['prix'];
                            }
                        }
                        $depotid = $ligneinventaire['depot_id'];
                        $copiestock = $this->Copiestockdepot->find('first', array('conditions' => array('Copiestockdepot.inventaire_id' => $id)));
                        //$this->correctionstockinventairepararticle($depotid,$ligneinventaire['article_id'],$copiestock['Copiestockdepot']['date']);
                        //$this->Inventaire->updateAll(array('Inventaire.valide' =>1), array('Inventaire.id' => $id));
                        $testlignecopiestock = $this->Lignecopiestock->find('first', array('conditions' => array('Lignecopiestock.copiestockdepot_id' => $copiestock['Copiestockdepot']['id'], 'Lignecopiestock.depot_id' => $depotid, 'Lignecopiestock.article_id' => $ligneinventaire['article_id'])));
                        if (!empty($testlignecopiestock)) {
                            if ($testlignecopiestock['Lignecopiestock']['quantite'] != $ligneinventaire['quantite']) {
                                $bonecart['inventaire_id'] = $id;
                                $bonecart['article_id'] = $ligneinventaire['article_id'];
                                $bonecart['depot_id'] = $depotid;
                                $bonecart['qteanc'] = $testlignecopiestock['Lignecopiestock']['quantite'];
                                $bonecart['qtenv'] = $ligneinventaire['quantite'];
                                $bonecart['quantite'] = $ligneinventaire['quantite'] - $testlignecopiestock['Lignecopiestock']['quantite'];
                                $bonecart['prix'] = $testlignecopiestock['Lignecopiestock']['prix'];
                                $bonecart['prixtot'] = $testlignecopiestock['Lignecopiestock']['prix'] * $testlignecopiestock['Lignecopiestock']['quantite'];
                                $this->Bonecart->create();
                                $this->Bonecart->save($bonecart);
                                $this->Lignecopiestock->updateAll(array('Lignecopiestock.existe' => 1), array('Lignecopiestock.id' => $testlignecopiestock['Lignecopiestock']['id']));
                            }
                        } else {
                            $bonecart['inventaire_id'] = $id;
                            $bonecart['article_id'] = $ligneinventaire['article_id'];
                            $bonecart['depot_id'] = $depotid;
                            $bonecart['qteanc'] = 0;
                            $bonecart['qtenv'] = $ligneinventaire['quantite'];
                            $bonecart['quantite'] = $ligneinventaire['quantite'];
                            $bonecart['prix'] = 0;
                            $bonecart['prixtot'] = 0;
                            $this->Bonecart->create();
                            $this->Bonecart->save($bonecart);
                        }
                    }
                }
                //$copiestock = $this->Copiestockdepot->find('first', array('conditions' => array('Copiestockdepot.inventaire_id' => $id)));
                $restelignecopiestock = $this->Lignecopiestock->find('all', array('conditions' => array('Copiestockdepot.inventaire_id' => $id, 'Lignecopiestock.existe' => 0)));
                if (!empty($restelignecopiestock)) {
                    foreach ($restelignecopiestock as $rest) {
                        $bonecart['inventaire_id'] = $id;
                        $bonecart['article_id'] = $rest['Lignecopiestock']['article_id'];
//                        $bonecart['depot_id'] = $depotid;
                        $bonecart['depot_id'] = $rest['Lignecopiestock']['depot_id'];
                        $bonecart['qteanc'] = $rest['Lignecopiestock']['quantite'];
                        $bonecart['qtenv'] = 0;
                        $bonecart['quantite'] = 0 - $rest['Lignecopiestock']['quantite'];
                        $bonecart['prix'] = $rest['Lignecopiestock']['prix'];
                        $bonecart['prixtot'] = $rest['Lignecopiestock']['prix'] * (0 - $rest['Lignecopiestock']['quantite']);
                        $this->Bonecart->create();
                        $this->Bonecart->save($bonecart);
                    }
                }

                $this->Session->setFlash(__('The inventaire has been saved'));
                $this->redirect(array('action' => 'indexpararticle'));
            } else {
                $this->Session->setFlash(__('The inventaire could not be saved. Please, try again.'));
            }
        }
        $numero = $this->Inventaire->find('all', array('fields' =>
            array(
                'MAX(Inventaire.numero) as num'
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
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $depot_touts = $this->Depot->find('all', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $this->set(compact('depots', 'articles', 'mm', 'depot_touts'));
    }

    public function editpararticle($id = NULL, $valide = NULL) {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = $liens['add'];
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Article');
        $this->loadModel('Homologation');
        $this->loadModel('Ligneinventaire');
        $this->loadModel('Stockdepot');
        $this->loadModel('Copiestockdepot');
        $this->loadModel('Lignecopiestock');
        $this->loadModel('Bonecart');
        if ($this->request->is('post')) {
            //debug ($this->request->data);die;
            $this->request->data['Inventaire']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Inventaire']['dateinv'])));
            $this->request->data['Inventaire']['exercice_id'] = date("Y");
            $this->request->data['Inventaire']['type'] = 2;
            $this->Inventaire->create();
            if ($this->Inventaire->save($this->request->data)) {
                $id = $this->Inventaire->id;
                $this->misejour("Inventaire", "edit", $id);
                if ($valide == 1) {
                    $this->Stockdepot->deleteAll(array('Stockdepot.article_id' => $this->request->data['Inventaire']['article_id']), false);
                }
                $this->Bonecart->deleteAll(array('Bonecart.inventaire_id' => $id), false);
                //debug($this->request->data['Ligneinventaire']);
                foreach ($this->request->data['Ligneinventaire'] as $ligneinventaire) {

                    $ligneinventaire['article_id'] = $this->request->data['Inventaire']['article_id'];
                    $ligneinventaire['inventaire_id'] = $id;
                    //debug($ligneinventaire);die;
                    $this->Ligneinventaire->create();
                    $this->Ligneinventaire->save($ligneinventaire);
                    $prixstocks = $this->Lignecopiestock->find('all', array('conditions' => array('Copiestockdepot.inventaire_id' => $id, 'Lignecopiestock.article_id' => $this->request->data['Inventaire']['article_id'])));
                    $prix = 0;
                    foreach ($prixstocks as $prixst) {
                        if (!empty($prixstocks['Lignecopiestock']['prix'])) {
                            $prix = $prixstocks['Lignecopiestock']['prix'];
                        }
                    }
                    $depotid = $ligneinventaire['depot_id'];
                    $copiestock = $this->Copiestockdepot->find('first', array('conditions' => array('Copiestockdepot.inventaire_id' => $id)));
                    //debug($copiestock)
                    if ($valide == 1) {
                        $this->Ligneinventaire->updateAll(array('Ligneinventaire.qte_invpar' => $ligneinventaire['quantite']), array('Ligneinventaire.article_id' => $this->request->data['Inventaire']['article_id'],'Ligneinventaire.depot_id' =>$depotid,'Inventaire.date <='=>$this->request->data['Inventaire']['date'],'Inventaire.exercice_id'=>date("Y"),'Inventaire.type'=>1));
                        $newstock['article_id'] = $this->request->data['Inventaire']['article_id'];
                        $newstock['depot_id'] = $depotid;
                        $newstock['quantite'] = $ligneinventaire['quantite'];
                        $newstock['prix'] = $prix;
                        $this->Stockdepot->create();
                        $this->Stockdepot->save($newstock);
                        $id_stockdepot = $this->Stockdepot->id;
                        $this->correctionstockinventairepararticle($depotid, $ligneinventaire['article_id'], $copiestock['Copiestockdepot']['date']);
                        $this->Inventaire->updateAll(array('Inventaire.valide' => 1), array('Inventaire.id' => $id));


                        $testlignecopiestock = $this->Lignecopiestock->find('first', array('conditions' => array('Lignecopiestock.copiestockdepot_id' => $copiestock['Copiestockdepot']['id'], 'Lignecopiestock.depot_id' => $depotid, 'Lignecopiestock.article_id' => $ligneinventaire['article_id'])));
                        if (!empty($testlignecopiestock)) {
                            $teststockdepot = $this->Stockdepot->find('first', array('conditions' => array('Stockdepot.id' => $id_stockdepot)));
                            if ($testlignecopiestock['Lignecopiestock']['quantite'] != $teststockdepot['Stockdepot']['quantite']) {
                                $bonecart['inventaire_id'] = $id;
                                $bonecart['article_id'] = $ligneinventaire['article_id'];
                                $bonecart['depot_id'] = $depotid;

                                $bonecart['qteanc'] = $testlignecopiestock['Lignecopiestock']['quantite'];
                                $bonecart['qtenv'] = $ligneinventaire['quantite'];
                                $bonecart['quantite'] = $ligneinventaire['quantite'] - $testlignecopiestock['Lignecopiestock']['quantite'];
                                $bonecart['prix'] = $testlignecopiestock['Lignecopiestock']['prix'];
                                $bonecart['prixtot'] = $testlignecopiestock['Lignecopiestock']['prix'] * $testlignecopiestock['Lignecopiestock']['quantite'];
                                $this->Bonecart->create();
                                $this->Bonecart->save($bonecart);
                                $this->Lignecopiestock->updateAll(array('Lignecopiestock.existe' => 1), array('Lignecopiestock.id' => $testlignecopiestock['Lignecopiestock']['id']));
                            }
                        } else {
                            $bonecart['inventaire_id'] = $id;
                            $bonecart['article_id'] = $ligneinventaire['article_id'];
                            $bonecart['depot_id'] = $depotid;

                            $bonecart['qteanc'] = 0;
                            $bonecart['qtenv'] = $ligneinventaire['quantite'];
                            $bonecart['quantite'] = $ligneinventaire['quantite'];
                            $bonecart['prix'] = 0;
                            $bonecart['prixtot'] = 0;
                            $this->Bonecart->create();
                            $this->Bonecart->save($bonecart);
                        }
                    } else {
                        $testlignecopiestock = $this->Lignecopiestock->find('first', array('conditions' => array('Lignecopiestock.copiestockdepot_id' => $copiestock['Copiestockdepot']['id'], 'Lignecopiestock.depot_id' => $depotid, 'Lignecopiestock.article_id' => $ligneinventaire['article_id'])));
                        if (!empty($testlignecopiestock)) {
                            if ($testlignecopiestock['Lignecopiestock']['quantite'] != $ligneinventaire['quantite']) {
                                $bonecart['inventaire_id'] = $id;
                                $bonecart['article_id'] = $ligneinventaire['article_id'];
                                $bonecart['depot_id'] = $depotid;

                                $bonecart['qteanc'] = $testlignecopiestock['Lignecopiestock']['quantite'];
                                $bonecart['qtenv'] = $ligneinventaire['quantite'];
                                $bonecart['quantite'] = $ligneinventaire['quantite'] - $testlignecopiestock['Lignecopiestock']['quantite'];
                                $bonecart['prix'] = $testlignecopiestock['Lignecopiestock']['prix'];
                                $bonecart['prixtot'] = $testlignecopiestock['Lignecopiestock']['prix'] * $testlignecopiestock['Lignecopiestock']['quantite'];
                                $this->Bonecart->create();
                                $this->Bonecart->save($bonecart);
                                $this->Lignecopiestock->updateAll(array('Lignecopiestock.existe' => 1), array('Lignecopiestock.id' => $testlignecopiestock['Lignecopiestock']['id']));
                            }
                        } else {
                            $bonecart['inventaire_id'] = $id;
                            $bonecart['article_id'] = $ligneinventaire['article_id'];
                            $bonecart['depot_id'] = $depotid;

                            $bonecart['qteanc'] = 0;
                            $bonecart['qtenv'] = $ligneinventaire['quantite'];
                            $bonecart['quantite'] = $ligneinventaire['quantite'];
                            $bonecart['prix'] = 0;
                            $bonecart['prixtot'] = 0;
                            $this->Bonecart->create();
                            $this->Bonecart->save($bonecart);
                        }
                    }
                }
                $restelignecopiestock = $this->Lignecopiestock->find('all', array('conditions' => array('Copiestockdepot.inventaire_id' => $id, 'Lignecopiestock.existe' => 0)));
                if (!empty($restelignecopiestock)) {
                    foreach ($restelignecopiestock as $rest) {
                        $bonecart['inventaire_id'] = $id;
                        $bonecart['article_id'] = $rest['Lignecopiestock']['article_id'];
                        $bonecart['depot_id'] = $depotid;

                        $bonecart['qteanc'] = $rest['Lignecopiestock']['quantite'];
                        $bonecart['qtenv'] = 0;
                        $bonecart['quantite'] = 0 - $rest['Lignecopiestock']['quantite'];
                        $bonecart['prix'] = $rest['Lignecopiestock']['prix'];
                        $bonecart['prixtot'] = $rest['Lignecopiestock']['prix'] * (0 - $rest['Lignecopiestock']['quantite']);
                        $this->Bonecart->create();
                        $this->Bonecart->save($bonecart);
                    }
                }

                $this->Session->setFlash(__('The inventaire has been saved'));
                $this->redirect(array('action' => 'indexpararticle'));
            } else {
                $this->Session->setFlash(__('The inventaire could not be saved. Please, try again.'));
            }
        }
        $inventaire = $this->Inventaire->find('first', array('conditions' => array('Inventaire.id' => $id)));
        $articleinventaires = $this->Ligneinventaire->find('first', array('conditions' => array('Ligneinventaire.inventaire_id' => $id), 'group' => array('Ligneinventaire.article_id')));
        //debug($articleinventaires);
        $ligneinventaires = $this->Ligneinventaire->find('all', array('conditions' => array('Ligneinventaire.inventaire_id' => $id), 'order' => array('Ligneinventaire.id' => 'ASC')));
        $articles = $this->Article->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $depot_touts = $this->Depot->find('all', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $this->set(compact('articleinventaires', 'ligneinventaires', 'inventaire', 'depots', 'articles', 'mm', 'depot_touts'));
    }

    public function edit($id = null, $valide = null) {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = $liens['edit'];
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Ligneinventaire');
        $this->loadModel('Article');
        $this->loadModel('Homologation');
        $this->loadModel('Stockdepot');
        $this->loadModel('Copiestockdepot');
        $this->loadModel('Lignecopiestock');
        $this->loadModel('Bonecart');
        if (!$this->Inventaire->exists($id)) {
            throw new NotFoundException(__('Invalid inventaire'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);die;
            $this->request->data['Inventaire']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Inventaire']['dateinv'])));
            $this->request->data['Inventaire']['exercice_id'] = date("Y");
            if ($this->Inventaire->save($this->request->data)) {
                $this->misejour("Inventaire", "edit", $id);
                //$this->Bonecart->deleteAll(array('Bonecart.inventaire_id' => $id), false);
                //$this->Ligneinventaire->deleteAll(array('Ligneinventaire.inventaire_id' => $id), false);
//                die;
                if (isset($this->request->data['Ligneinventaire'])) {
                    $inventaire = $this->Inventaire->find('first', array('conditions' => array('Inventaire.id' => $id)));
                    $depotid = $inventaire['Inventaire']['depot_id'];
                    // Vider stock
                    if ($valide == 1) {
                        $this->Stockdepot->deleteAll(array('Stockdepot.depot_id' => $depotid), false);
                    }
                    foreach ($this->request->data['Ligneinventaire'] as $ligneinventaire) {
                        if ($ligneinventaire['article_id'] != "") {
                            if ($ligneinventaire['sup'] != 1) {
                                $ligneinventaire['inventaire_id'] = $id;
                                $ligneinventaire['depot_id'] = $depotid;
                                 $article_prixachat = $this->Article->find('first',
                                array('conditions' => array('Article.id' => $ligneinventaire['article_id'])));
                                if(empty($article_prixachat['Article']['coutderevien'])){
                                    $article_prixachat['Article']['coutderevien']=0;
                                }
                                $ligneinventaire['coutderevien'] = $article_prixachat['Article']['coutderevien'];
                                $this->Ligneinventaire->create();
                                $this->Ligneinventaire->save($ligneinventaire);
                                $ligneinv_id = $this->Ligneinventaire->id;
                                //**************Cas inventaire valide**********/
                                $ligneinventairetest = $this->Ligneinventaire->find('first', array('conditions' => array('Ligneinventaire.article_id' => $ligneinventaire['article_id'], 'Ligneinventaire.inventaire_id' => $id, 'Ligneinventaire.id !=' => $ligneinv_id)));
                                //***********Cas : non redondance**********/
                                if (empty($ligneinventairetest)) {
                                    // Nouveau stock
                                   if ($valide == 1) {
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($ligneinventaire);
                                        //$this->Inventaire->updateAll(array('Inventaire.valide' => 1), array('Inventaire.id' => $id));
                                    }
                                    $copiestock = $this->Copiestockdepot->find('first', array('conditions' => array('Copiestockdepot.inventaire_id' => $id), 'order' => array('Copiestockdepot.id' => 'desc')));
                                    //$this->correctionstockinventaire( $depotid, $ligneinventaire['article_id'], $copiestock['Copiestockdepot']['date']);
//                                    $this->stockajouter($depotid);
                                    $testlignecopiestock = $this->Lignecopiestock->find('first', array('conditions' => array('Lignecopiestock.copiestockdepot_id' => $copiestock['Copiestockdepot']['id'], 'Lignecopiestock.depot_id' => $depotid, 'Lignecopiestock.article_id' => $ligneinventaire['article_id'])));

                                    //Cas : Article existe
                                    if (!empty($testlignecopiestock)) {
                                        //Cas : les deux quantités sont différentes
                                        if ($testlignecopiestock['Lignecopiestock']['quantite'] != @$ligneinventaire['quantite']) {
                                            if($this->request->data['Inventaire']['typeinv']==0){
                                            $testlignebonecart = $this->Bonecart->find('first', array('conditions' => array('Bonecart.inventaire_id' => $id, 'Bonecart.depot_id' => $depotid, 'Bonecart.article_id' => $ligneinventaire['article_id'])));
                                            if (!empty($testlignebonecart)) {
                                                // Mise à jour bon ecart
                                                $bonecart['id'] = $testlignebonecart['Bonecart']['id'];
                                            } else {
                                                // Nouveau instance
                                                $bonecart['id'] = NULL;
                                            }
                                            $bonecart['inventaire_id'] = $id;
                                            $bonecart['article_id'] = $ligneinventaire['article_id'];
                                            $bonecart['depot_id'] = $depotid;
                                            $bonecart['qteanc'] = $testlignecopiestock['Lignecopiestock']['quantite'];
                                            $bonecart['qtenv'] = $ligneinventaire['quantite'];
                                            $bonecart['quantite'] = $ligneinventaire['quantite'] - $testlignecopiestock['Lignecopiestock']['quantite'];
                                            $bonecart['prix'] = $testlignecopiestock['Lignecopiestock']['prix'];
                                            $bonecart['prixtot'] = $testlignecopiestock['Lignecopiestock']['prix'] * $testlignecopiestock['Lignecopiestock']['quantite'];
                                            $this->Bonecart->create();
                                            $this->Bonecart->save($bonecart);
                                            }
                                        }
                                        if($this->request->data['Inventaire']['typeinv']==0){
                                        $this->Lignecopiestock->updateAll(array('Lignecopiestock.existe' => 1), array('Lignecopiestock.id' => $testlignecopiestock['Lignecopiestock']['id']));
                                        }
                                    }
                                    // Article non existe
                                    else {
                                        if($this->request->data['Inventaire']['typeinv']==0){
                                        $testlignebonecart = $this->Bonecart->find('first', array('conditions' => array('Bonecart.inventaire_id' => $id, 'Bonecart.depot_id' => $depotid, 'Bonecart.article_id' => $ligneinventaire['article_id'])));
                                        if (!empty($testlignebonecart)) {
                                            $bonecart['id'] = $testlignebonecart['Bonecart']['id'];
                                        } else {
                                            $bonecart['id'] = NULL;
                                        }
                                        $bonecart['inventaire_id'] = $id;
                                        $bonecart['article_id'] = @$ligneinventaire['article_id'];
                                        $bonecart['depot_id'] = @$depotid;
                                        $bonecart['qteanc'] = 0;
                                        $bonecart['qtenv'] = @$ligneinventaire['quantite'];
                                        $bonecart['quantite'] = @$ligneinventaire['quantite'];
                                        $bonecart['prix'] = @$testlignecopiestock['Lignecopiestock']['prix'];
                                        $bonecart['prixtot'] = @$testlignecopiestock['Lignecopiestock']['prix'] * @$ligneinventaire['quantite'];
                                        $this->Bonecart->create();
                                        $this->Bonecart->save($bonecart);
                                        }
                                    }
                                }
                                //*************Cas : redondance************/
                                else {
//                                        debug($ligneinventaire['article_id']);
                                    //$this->Ligneinventaire->updateAll(array('Ligneinventaire.quantite' => 'Ligneinventaire.quantite+'.$ligneinventaire['quantite']), array('Ligneinventaire.id' =>$ligneinventairetest['Ligneinventaire']['id']));
                                    if ($valide == 1) {
                                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . @$ligneinventaire['quantite']), array('Stockdepot.article_id' => @$ligneinventaire['article_id'], 'Stockdepot.depot_id' => $depotid));
                                    }
                                    $testbonecart = $this->Bonecart->find('first', array(
                                        'conditions' => array('Bonecart.article_id' => @$ligneinventaire['article_id'], 'Bonecart.inventaire_id' => $id),
                                        'recursive' => -1
                                    ));
                                    if($this->request->data['Inventaire']['typeinv']==0){
                                    if ($testbonecart != array()) {
                                        $this->Bonecart->updateAll(array('Bonecart.qtenv' => 'Bonecart.qtenv+' . @$ligneinventaire['quantite'], 'Bonecart.quantite' => 'Bonecart.quantite+' . @$ligneinventaire['quantite']), array('Bonecart.article_id' => @$ligneinventaire['article_id'], 'Bonecart.inventaire_id' => $id));
                                    } else {
                                        $bonecart['inventaire_id'] = $id;
                                        $bonecart['article_id'] = @$ligneinventaire['article_id'];
                                        $bonecart['depot_id'] = $depotid;
                                        $bonecart['qteanc'] = 0;
                                        $bonecart['qtenv'] = @$ligneinventaire['quantite'];
                                        $bonecart['quantite'] = @$ligneinventaire['quantite'];
                                        $bonecart['prix'] = 0;
                                        $bonecart['prixtot'] = 0;
                                        $this->Bonecart->create();
                                        $this->Bonecart->save($bonecart);
                                    }
                                    }
                                }
                            } else {
                                if (!@empty($ligneinventaire['id'])) {
                                    $this->Ligneinventaire->deleteAll(array('Ligneinventaire.id' => @$ligneinventaire['id']), false);
                                }
                            }
                        }
                    }
                    // Cas : existence d'article(lignecopiestok) dans  ligneinventaire
                    $copiestock_par_inventaire = $this->Copiestockdepot->find('first', array('conditions' => array('Copiestockdepot.inventaire_id' => $id)));
                    $restelignecopiestock = $this->Inventaire->query('SELECT * FROM lignecopiestocks WHERE lignecopiestocks.copiestockdepot_id='.$copiestock_par_inventaire['Copiestockdepot']['id'].'
                    AND NOT EXISTS ( SELECT * FROM ligneinventaires WHERE ligneinventaires.`article_id` = lignecopiestocks.article_id
                    AND ligneinventaires.inventaire_id='.$id.')');

                    //$restelignecopiestock = $this->Lignecopiestock->find('all', array('conditions' => array('Copiestockdepot.inventaire_id' => $id,'Lignecopiestock.depot_id' => $depotid, 'Lignecopiestock.existe' => 0), 'order' => array('Copiestockdepot.id' => 'desc')));
                    //debug($restelignecopiestock) ;die;
                    if (!empty($restelignecopiestock)) {
                        foreach ($restelignecopiestock as $rest) {
                            if($this->request->data['Inventaire']['typeinv']==0){
                            $testlignebonecart = $this->Bonecart->find('first', array('conditions' => array('Bonecart.inventaire_id' => $id, 'Bonecart.depot_id' => $depotid, 'Bonecart.article_id' => $rest['lignecopiestocks']['article_id'])));
                            if (!empty($testlignebonecart)) {
                                $bonecart['id'] = $testlignebonecart['Bonecart']['id'];
                            } else {
                                $bonecart['id'] = NULL;
                            }
                            $bonecart['inventaire_id'] = $id;
                            $bonecart['article_id'] = $rest['lignecopiestocks']['article_id'];
                            $bonecart['depot_id'] = $depotid;
                            $bonecart['qteanc'] = $rest['lignecopiestocks']['quantite'];
                            $bonecart['qtenv'] = 0;
                            $bonecart['quantite'] = 0 - $rest['lignecopiestocks']['quantite'];
                            $bonecart['prix'] = $rest['lignecopiestocks']['prix'];
                            $bonecart['prixtot'] = $rest['lignecopiestocks']['prix'] * (0 - $rest['lignecopiestocks']['quantite']);
                            $this->Bonecart->create();
                            $this->Bonecart->save($bonecart);
                            }
                        }
                    }
                }
                // delete tous les lignes (écart = 0)
                $this->Bonecart->deleteAll(array('Bonecart.quantite' => 0), false);
                if ($valide == 1) {
                $this->Inventaire->updateAll(array('Inventaire.valide' => 1), array('Inventaire.id' => $id));
                }

                $this->Session->setFlash(__('The inventaire has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The inventaire could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Inventaire.' . $this->Inventaire->primaryKey => $id));
            $this->request->data = $this->Inventaire->find('first', $options);
        }
        $day = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Inventaire']['date'])));

        $ligneinvents = $this->Ligneinventaire->find('all', array(
            'conditions' => array('Ligneinventaire.inventaire_id' => $id), 'order' => array('Ligneinventaire.id' => 'ASC'), 'recursive' => -1
        ));
        //debug($ligneinvents);die;
        //$articles = $this->Article->find('list');
        $depots = $this->Depot->find('list', array('fields' => array('Depot.designation')));
        $typeinvs[0]="Avec Bon D'ecart";
        $typeinvs[1]="Sans Bon D'ecart";

        $this->set(compact('typeinvs','valide', 'depots', 'articles', 'ligneinvents', 'day','valide'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = $liens['delete'];
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Copiestockdepot');
        $this->loadModel('Lignecopiestock');
        $this->loadModel('Bonecart');
        $this->loadModel('Ligneinventaire');
        $this->Inventaire->id = $id;
        if (!$this->Inventaire->exists()) {
            throw new NotFoundException(__('Invalid inventaire'));
        }
        $this->request->onlyAllow('post', 'delete');

        $Copiestockdepots = $this->Copiestockdepot->find('first', array('conditions' => array('Copiestockdepot.inventaire_id' => $id)));
            $this->Ligneinventaire->deleteAll(array('Ligneinventaire.inventaire_id'=>$id),false);
            $this->Lignecopiestock->deleteAll(array('Lignecopiestock.copiestockdepot_id'=>$Copiestockdepots['Copiestockdepot']['id']),false);
            $this->Copiestockdepot->deleteAll(array('Copiestockdepot.inventaire_id'=>$id),false);
            $this->Bonecart->deleteAll(array('Bonecart.inventaire_id'=>$id),false);


        $abcd = $this->Inventaire->find('first', array('conditions' => array('Inventaire.id' => $id), 'recursive' => -1));
        $numansar = $abcd['Inventaire']['numero'];

        if ($this->Inventaire->delete()) {
            $this->misejour("Inventaire", $numansar, $id);
            CakeSession::write('view', "delete");
            $this->Session->setFlash(__('Inventaire deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Inventaire was not deleted'));
        //$this->redirect(array('action' => 'index'));
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = $liens['imprimer'];
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');

        //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Inventaire.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Inventaire.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['depotid']) {
            $depotid = $this->request->query['depotid'];
            $cond3 = 'Inventaire.depot_id =' . $depotid;
        }

        $inventaires = $this->Inventaire->find('all', array('conditions' => array('Inventaire.id > ' => 0, @$cond1, @$cond2, @$cond3)));

        //debug($commandes);die;
        $this->set(compact('inventaires', 'date1', 'date2', 'depotid'));
    }

}
