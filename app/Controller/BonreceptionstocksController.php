<?php

App::uses('AppController', 'Controller');

/**
 * Bonreceptionstocks Controller
 *
 * @property Bonreceptionstock $Bonreceptionstock
 */
class BonreceptionstocksController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptionstocks') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Exercice');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condb4 = 'Bonreceptionstock.exercice_id =' . $exe;

        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Bonreceptionstocks"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Recherche']);
            } else {
                $this->request->data['Recherche'] = CakeSession::read('recherche');
            }
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $condb4 = 'Bonreceptionstock.exercice_id =' . $exercices[$exerciceid];
            }

            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $condb1 = 'Bonreceptionstock.date >= ' . "'" . $date1 . "'";
                $condb4 = "";
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $condb2 = 'Bonreceptionstock.date <= ' . "'" . $date2 . "'";
                $condb4 = "";
            }
        }
        $bonreceptionstocks = $this->Bonreceptionstock->find('all', array(
            'conditions' => array('Bonreceptionstock.id > ' => 0, @$condb1, @$condb2, @$condb4)
        ));



        $this->set(compact('bonreceptionstocks', 'exerciceid', 'exercices', 'date1', 'date2'));
    }

    public function imprimer($id = null) {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptionstocks') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignebonreceptionstock');
        if (!$this->Bonreceptionstock->exists($id)) {
            throw new NotFoundException(__('Invalid bonreceptionstock'));
        }
        $lignebonreceptionstocks = $this->Lignebonreceptionstock->find('all', array(
            'conditions' => array('Lignebonreceptionstock.bonreceptionstock_id' => $id)
        ));


        $bonreceptionstock = $this->Bonreceptionstock->find('first', array('conditions' => array('Bonreceptionstock.id' => $id)));
        //debug($commande);die;
        $this->set(compact('bonreceptionstock', 'lignebonreceptionstocks'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_stock');
        $this->loadModel('Lignebonreceptionstock');
        $this->loadModel('Depot');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptionstocks') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Bonreceptionstock->exists($id)) {
            throw new NotFoundException(__('Invalid bonreceptionstock'));
        }
        $options = array('conditions' => array('Bonreceptionstock.' . $this->Bonreceptionstock->primaryKey => $id));
        $this->set('bonreceptionstock', $this->Bonreceptionstock->find('first', $options));
        $lignebonreceptionstocks = $this->Lignebonreceptionstock->find('all', array('conditions' => array('Lignebonreceptionstock.bonreceptionstock_id' => $id), 'recursive' => -1, 'order' => array('Lignebonreceptionstock.id' => 'ASC')));
        $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        $this->set(compact('lignebonreceptionstocks','depots'));
    }

    public function add() {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptionstocks') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignebonreceptionstock');
        if ($this->request->is('post')) {
//             debug($this->request->data);die;

            $this->request->data['Bonreceptionstock']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreceptionstock']['date'])));
            $this->request->data['Bonreceptionstock']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Bonreceptionstock']['exercice_id'] = date("Y");
            $this->Bonreceptionstock->create();
            if ($this->Bonreceptionstock->save($this->request->data)) {

                $id = $this->Bonreceptionstock->id;
                $this->misejour("Bonreceptionstock", "add", $id);
                $Lignebonreceptionstocks = array();
                $stockdepots = array();
                $depotreception = $this->request->data['Bonreceptionstock']['depot_id'];
                foreach ($this->request->data['Lignebonreceptionstock'] as $numl => $f) {

                    if ($f['sup'] != 1) {
                        if (($f['article_id'] != '')) {
                            $Lignebonreceptionstocks['depot_id'] = $depotreception;
                            $Lignebonreceptionstocks['article_id'] = $f['article_id'];
                            $Lignebonreceptionstocks['quantite'] = $f['quantite'];
                            $Lignebonreceptionstocks['bonreceptionstock_id'] = $id;
                            $this->Lignebonreceptionstock->create();
                            $this->Lignebonreceptionstock->save($Lignebonreceptionstocks);
                            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $depotreception), false));
                            if (!empty($stckdepot)) {
                                $stockdepots[$numl]['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] + $f['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                            } else {
                                $array = array();
                                $array['depot_id'] = $depotreception;
                                $array['article_id'] = $f['article_id'];
                                $array['quantite'] = $f['quantite'];
                                $this->Stockdepot->create();
                                $this->Stockdepot->save($array);
                            }
                            //$this->stock($f['depot_id'], $f['article_id']);
                        }
                    }
                }

                $this->Session->setFlash(__('The bonreceptionstock has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The bonreceptionstock could not be saved. Please, try again.'));
            }
        }
        $numero = $this->Bonreceptionstock->find('all', array('fields' =>
            array(
                'MAX(Bonreceptionstock.numero) as num'
        )));
        // debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
            if (!empty($n)) {
                $commande = $this->Bonreceptionstock->find('all', array('conditions' => array('Bonreceptionstock.numero' => $n), 'recursive' => -1));
                //debug($commande);die;
                if ($commande[0]['Bonreceptionstock']['exercice_id'] == date('Y')) {
                    $lastnum = $n;
                    $nume = intval($lastnum) + 1;
                    $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
                } else {
                    $mm = "000001";
                }
            } else {
                $mm = "000001";
            }
        }
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $articles = $this->Article->find('list', array('conditions' => array('Article.id <30')));
        $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));


        $depotarrives = $this->Depot->find('list');
        $utilisateurs = $this->Bonreceptionstock->Utilisateur->find('list');
        $this->set(compact('utilisateurs', 'articles', 'depots', 'depotarrives', 'mm'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptionstocks') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignebonreceptionstock');
        if (!$this->Bonreceptionstock->exists($id)) {
            throw new NotFoundException(__('Invalid bonreceptionstock'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
//            debug($this->request->data);die;        

            $lignebonreceptionstocks = $this->Lignebonreceptionstock->find('all', array('conditions' => array('Lignebonreceptionstock.bonreceptionstock_id' => $id), 'recursive' => -1));
            foreach ($lignebonreceptionstocks as $lra) {
                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite-' . $lra['Lignebonreceptionstock']['quantite']), array('Stockdepot.article_id' => $lra['Lignebonreceptionstock']['article_id'], 'Stockdepot.depot_id' => $lra['Lignebonreceptionstock']['depot_id']));
            }
            $this->Lignebonreceptionstock->deleteAll(array('Lignebonreceptionstock.bonreceptionstock_id' => $id), false);
            $this->request->data['Bonreceptionstock']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonreceptionstock']['date'])));
            $this->request->data['Bonreceptionstock']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Bonreceptionstock']['exercice_id'] = date("Y");
            $depotreception = $this->request->data['Bonreceptionstock']['depot_id'];
            if ($this->Bonreceptionstock->save($this->request->data)) {
                $this->misejour("Bonreceptionstock", "edit", $id);
                $Lignebonreceptionstocks = array();
                $stockdepots = array();
                foreach ($this->request->data['Lignebonreceptionstock'] as $numl => $f) {
                    if ($f['sup'] != 1) {
                        if ( ($f['article_id'] != '')) {
                            $Lignebonreceptionstocks['depot_id'] = $depotreception;
                            $Lignebonreceptionstocks['article_id'] = $f['article_id'];
                            $Lignebonreceptionstocks['quantite'] = $f['quantite'];
                            $Lignebonreceptionstocks['bonreceptionstock_id'] = $id;
                            $this->Lignebonreceptionstock->create();
                            $this->Lignebonreceptionstock->save($Lignebonreceptionstocks);
                            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $depotreception), false));
                            if (!empty($stckdepot)) {
                                $stockdepots[$numl]['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] + $f['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                            } else {
                                $array = array();
                                $array['depot_id'] = $depotreception;
                                $array['article_id'] = $f['article_id'];
                                $array['quantite'] = $f['quantite'];

                                $this->Stockdepot->create();
                                $this->Stockdepot->save($array);
                            }
                            //$this->stock($f['depot_id'], $f['article_id']);
                        }
                    }
                }


                $this->Session->setFlash(__('The bonreceptionstock has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The bonreceptionstock could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Bonreceptionstock.' . $this->Bonreceptionstock->primaryKey => $id));
            $this->request->data = $this->Bonreceptionstock->find('first', $options);
        }
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Lignebonreceptionstock');
        //$articles = $this->Article->find('list');
        $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));

        $lignebonreceptionstocks = $this->Lignebonreceptionstock->find('all', array('conditions' => array('Lignebonreceptionstock.bonreceptionstock_id' => $id), 'recursive' => -1, 'order' => array('Lignebonreceptionstock.id' => 'ASC')));
        $utilisateurs = $this->Bonreceptionstock->Utilisateur->find('list');
        $this->set(compact('lignebonreceptionstocks', 'utilisateurs', 'articles', 'depots', 'depotarrives', 'mm'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonreceptionstocks') {
                    $x = $liens['delete'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignebonreceptionstock');
        $this->Bonreceptionstock->id = $id;
        if (!$this->Bonreceptionstock->exists()) {
            throw new NotFoundException(__('Invalid bonreceptionstock'));
        }
        $lignebonreceptionstocks = $this->Lignebonreceptionstock->find('all', array('conditions' => array('Lignebonreceptionstock.bonreceptionstock_id' => $id), 'recursive' => -1));
        foreach ($lignebonreceptionstocks as $lra) {
//            debug($lra);die;
            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite -' . $lra['Lignebonreceptionstock']['quantite']), array('Stockdepot.article_id' => $lra['Lignebonreceptionstock']['article_id'], 'Stockdepot.depot_id' => $lra['Lignebonreceptionstock']['depot_id']));
        }
        $this->Lignebonreceptionstock->deleteAll(array('Lignebonreceptionstock.bonreceptionstock_id' => $id), false);
        $abcd = $this->Bonreceptionstock->find('first', array('conditions' => array('Bonreceptionstock.id' => $id), 'recursive' => -1));
        $numansar = $abcd['Bonreceptionstock']['numero'];
        $this->request->onlyAllow('post', 'delete');
        if ($this->Bonreceptionstock->delete()) {
            $this->misejour("Bonreceptionstock", $numansar, $id);
            $this->Session->setFlash(__('Bonreceptionstock deleted'));
            CakeSession::write('view', "delete");
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Bonreceptionstock was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
