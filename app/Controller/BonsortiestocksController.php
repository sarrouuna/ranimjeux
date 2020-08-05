<?php

App::uses('AppController', 'Controller');

/**
 * Bonsortiestocks Controller
 *
 * @property Bonsortiestock $Bonsortiestock
 */
class BonsortiestocksController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonsortiestocks') {
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
        $condb4 = 'Bonsortiestock.exercice_id =' . $exe;

        if ($this->request->is('post')) {
            //debug($this->request->data);die;


            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $condb4 = 'Bonsortiestock.exercice_id =' . $exercices[$exerciceid];
            }

            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $condb1 = 'Bonsortiestock.date >= ' . "'" . $date1 . "'";
                $condb4 = "";
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $condb2 = 'Bonsortiestock.date <= ' . "'" . $date2 . "'";
                $condb4 = "";
            }
        }
        $bonsortiestocks = $this->Bonsortiestock->find('all', array(
            'conditions' => array('Bonsortiestock.id > ' => 0, @$condb1, @$condb2, @$condb4)
        ));



        $this->set(compact('bonsortiestocks', 'exerciceid', 'exercices', 'date1', 'date2'));
    }

    public function imprimer($id = null) {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonsortiestocks') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignebonsortiestock');
        if (!$this->Bonsortiestock->exists($id)) {
            throw new NotFoundException(__('Invalid Bon sorties tock'));
        }
        $lignebonsortiestocks = $this->Lignebonsortiestock->find('all', array(
            'conditions' => array('Lignebonsortiestock.bonsortiestock_id' => $id)
        ));

        $bonsortiestock = $this->Bonsortiestock->find('first', array('conditions' => array('Bonsortiestock.id' => $id)));
        //debug($commande);die;
        $this->set(compact('lignebonsortiestocks', 'bonsortiestock'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonsortiestocks') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Bonsortiestock->exists($id)) {
            throw new NotFoundException(__('Invalid bonsortiestock'));
        }
        $this->loadModel('Lignebonsortiestock');
        $this->loadModel('Depot');
        $this->loadModel('Personnel');
        $bs = $this->Bonsortiestock->find('first', array('conditions' => array('Bonsortiestock.id' => $id), 'recursive' => -1));
        $validation = $bs['Bonsortiestock']['valide'];
        $personnels = $this->Personnel->find('list');
//        debug($validation);die;
        $options = array('conditions' => array('Bonsortiestock.' . $this->Bonsortiestock->primaryKey => $id));
        $this->set('bonsortiestock', $this->Bonsortiestock->find('first', $options));
        $lignetransferts = $this->Lignebonsortiestock->find('all', array('conditions' => array('Lignebonsortiestock.bonsortiestock_id' => $id), 'order' => array('Lignebonsortiestock.id' => 'ASC'), 'recursive' => -1));
        $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        $this->set(compact('lignetransferts', 'depots', 'validation', 'personnels'));
    }

    public function add() {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonsortiestocks') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignebonsortiestock');
        //zeinab
        $this->loadModel('Personnel');

        if ($this->request->is('post')) {
            // debug($this->request->data);die;
            $this->request->data['Bonsortiestock']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonsortiestock']['date'])));
            $this->request->data['Bonsortiestock']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Bonsortiestock']['exercice_id'] = date("Y");
            $depotsorti = $this->request->data['Bonsortiestock']['depot_id'];
            $this->Bonsortiestock->create();
            if ($this->Bonsortiestock->save($this->request->data)) {
                $id = $this->Bonsortiestock->id;
                $this->misejour("Bonsortiestock", "add", $id);
                $Lignetransferts = array();
                $stockdepots = array();
                foreach ($this->request->data['Lignetransfert'] as $numl => $f) {
                    if ($f['sup'] != 1) {
                        if (($f['article_id'] != '')) {
                            $Lignetransferts['depot_id'] = $depotsorti;
                            $Lignetransferts['article_id'] = $f['article_id'];
                            $Lignetransferts['quantite'] = $f['quantite'];
                            $Lignetransferts['bonsortiestock_id'] = $id;
                            $this->Lignebonsortiestock->create();
                            $this->Lignebonsortiestock->save($Lignetransferts);
                        }
                    }
                }

                $this->Session->setFlash(__('The bon sortie  has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The bon sortie could not be saved. Please, try again.'));
            }
        }
        $numero = $this->Bonsortiestock->find('all', array('fields' =>
            array(
                'MAX(Bonsortiestock.numero) as num'
        )));
        // debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
            if (!empty($n)) {
                $commande = $this->Bonsortiestock->find('all', array('conditions' => array('Bonsortiestock.numero' => $n), 'recursive' => -1));
                //debug($commande);die;
                if ($commande[0]['Bonsortiestock']['exercice_id'] == date('Y')) {
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
        // $articles = $this->Article->find('list');
        $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));


        $depotarrives = $this->Depot->find('list');
        //$articles = $this->Article->find('list',array('conditions'=>array('Article.id <30')));
        $utilisateurs = $this->Bonsortiestock->Utilisateur->find('list');
        //zeinab
        $personnels = $this->Personnel->find('list');
        $this->set(compact('personnels', 'utilisateurs', 'articles', 'depots', 'depotarrives', 'mm'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null, $valide = null) {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonsortiestocks') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignebonsortiestock');
        if (!$this->Bonsortiestock->exists($id)) {
            throw new NotFoundException(__('Invalid bonsortiestock'));
        }
        //zeinab  
        $bs = $this->Bonsortiestock->find('first', array('conditions' => array('Bonsortiestock.id' => $id), 'recursive' => -1));
        $validation = $bs['Bonsortiestock']['valide'];
        if ($this->request->is('post') || $this->request->is('put')) {
            //  debug($this->request->data);die;
            $bsans = $this->Bonsortiestock->find('first', array('conditions' => array('Bonsortiestock.id' => $id), 'recursive' => -1));
            $depotsortians = $bsans['Bonsortiestock']['depot_id'];
            $lignebsans = $this->Lignebonsortiestock->find('all', array(
                'conditions' => array('Lignebonsortiestock.bonsortiestock_id' => $id)
            ));
//            debug($lignebsans);die;
            $this->request->data['Bonsortiestock']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonsortiestock']['date'])));
            //$this->request->data['Bonsortiestock']['utilisateur_id']= CakeSession::read('users'); 
            $this->request->data['Bonsortiestock']['exercice_id'] = date("Y");
            $depotsorti = $this->request->data['Bonsortiestock']['depot_id'];
            if ($valide == 1) {

                if ($this->request->data['Bonsortiestock']['verif'] == 2) {
                    $this->request->data['Bonsortiestock']['valide'] = 2;
                    $this->request->data['Bonsortiestock']['alert'] = 1;
                } else {
                    $this->request->data['Bonsortiestock']['valide'] = 1;
                    $this->request->data['Bonsortiestock']['alert'] = 1;
                }
            }
            if ($valide == 2 || $bs['Bonsortiestock']['valide'] == 2) {
                $this->request->data['Bonsortiestock']['valide'] = 0;
                $this->request->data['Bonsortiestock']['alert'] = 0;
            }

            if ($this->Bonsortiestock->save($this->request->data)) {
                $this->misejour("Bonsortiestock", "edit", $id);
                //zeinab
                if ($validation == 1) {
                    foreach ($lignebsans as $lra) {
                        $stckdepot = $this->Stockdepot->find('first', array('conditions' => array('Stockdepot.article_id' => $lra['Lignebonsortiestock']['article_id'], 'Stockdepot.depot_id' => $depotsortians), false));
                        if (!empty($stckdepot)) {
                            $qte = $stckdepot[0]['Stockdepot']['quantite'] + $lra['Lignebonsortiestock']['quantite'];
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                        } else {
                            $array = array();
                            $array['depot_id'] = $depotsortians;
                            $array['article_id'] = $lra['Lignebonsortiestock']['article_id'];
                            $array['quantite'] = $lra['Lignebonsortiestock']['quantite'];
                            $this->Stockdepot->create();
                            $this->Stockdepot->save($array);
                        }
                    }
                }
                $this->Lignebonsortiestock->deleteAll(array('Lignebonsortiestock.bonsortiestock_id' => $id), false);
                $Lignebonsortiestocks = array();
                $stockdepots = array();
                foreach ($this->request->data['Lignetransfert'] as $numl => $f) {
                    if ($f['sup'] != 1) {
                        if (($f['article_id'] != '')) {
                            $Lignebonsortiestocks['depot_id'] = $depotsorti;
                            $Lignebonsortiestocks['article_id'] = $f['article_id'];
                            $Lignebonsortiestocks['quantite'] = $f['quantite'];
                            $Lignebonsortiestocks['bonsortiestock_id'] = $id;
                            $this->Lignebonsortiestock->create();
                            $this->Lignebonsortiestock->save($Lignebonsortiestocks);
                            if (($valide == 1) || ($validation == 1)) {
                                $id_ligne = $this->Lignebonsortiestock->id;
                                $qte_sorti = $f['quantite'];
                                $stckdepot = $this->Stockdepot->find('first', array(
                                    'conditions' => array('Stockdepot.article_id' => $f['article_id'],
                                        'Stockdepot.depot_id' => $depotsorti), false));
                                //debug($stckdepot);
                                if (!empty($stckdepot)) {
                                    $qte = $stckdepot['Stockdepot']['quantite'] - $qte_sorti;
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                } else {
                                    $stkn = array();
                                    $stkn['article_id'] = $f['article_id'];
                                    $stkn['depot_id'] = $depotsorti;
                                    $stkn['quantite'] = 0 - $f['quantite'];
                                    $this->Stockdepot->create();
                                    $this->Stockdepot->save($stkn);
                                }
                            }
                        }
                    }
                }
                $this->Session->setFlash(__('The bonsortiestock has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The bonsortiestock could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Bonsortiestock.' . $this->Bonsortiestock->primaryKey => $id));
            $this->request->data = $this->Bonsortiestock->find('first', $options);
        }
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Personnel');
        $lignetransferts = $this->Lignebonsortiestock->find('all', array('conditions' => array('Lignebonsortiestock.bonsortiestock_id' => $id), 'order' => array('Lignebonsortiestock.id' => 'ASC'), 'recursive' => -1));
        //debug($lignetransferts);
        $tabt = array();
        $tabqte = array();
        /* foreach ($lignetransferts as $i=>$lignetransfert){
          $stckdepotqte= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.depot_id'=>$lignetransfert['Lignebonsortiestock']['depot_id'],'Stockdepot.article_id'=>$lignetransfert['Lignebonsortiestock']['article_id']),'recursive'=>-1));
          foreach ($stckdepotqte as $q=>$qte){
          $tabqte[$i]=$qte['Stockdepot']['quantite'];
          }
          $articless= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.depot_id'=>$lignetransfert['Lignebonsortiestock']['depot_id']),'recursive'=>-1));

          $t='(0,';
          foreach ($articless as $ad){
          if(!empty($ad['Stockdepot']['article_id'])){
          $t=$t.$ad['Stockdepot']['article_id'].',';
          }}
          $t=$t.'0)';
          $tabt[$i]=$t;
          // $articles=$this->Article->find('list', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
          } */
        //debug($tabt);die;
        //debug($tabqte);
        //$articles = $this->Article->find('list');
        $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        $depotarrives = $this->Depot->find('list');
        //zeinab
        $personnels = $this->Personnel->find('list');
        $this->set(compact('validation', 'personnels', 'valide', 'tabqte', 'tabt', 'articless', 'articles', 'utilisateurs', 'articles', 'depots', 'depotarrives', 'mm', 'transferts', 'lignetransferts'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonsortiestocks') {
                    $x = $liens['delete'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignebonsortiestock');
        $this->loadModel('Stockdepotfacture');
        $this->Bonsortiestock->id = $id;
        if (!$this->Bonsortiestock->exists()) {
            throw new NotFoundException(__('Invalid bonsortiestock'));
        }

        $lignetransfets = $this->Lignebonsortiestock->find('all', array('conditions' => array('Lignebonsortiestock.bonsortiestock_id' => $id), false));
        //debug($tansfert);die;
        //zeinab  
        $bs = $this->Bonsortiestock->find('first', array('conditions' => array('Bonsortiestock.id' => $id), 'recursive' => -1));

        foreach ($lignetransfets as $lra) {
            //zeinab
            if ($bs['Bonsortiestock']['valide'] == 1) {

                $lignefactureanciens = $this->Stockdepotfacture->find('all', array('conditions' => array('Stockdepotfacture.id_piece' => $id, 'Stockdepotfacture.piece' => "Bonsortiestock"), false));
                foreach ($lignefactureanciens as $lra) {

                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $lra['Stockdepotfacture']['qte']), array('Stockdepot.id' => $lra['Stockdepotfacture']['stockdepot_id']));
                }
                $this->Stockdepotfacture->deleteAll(array('Stockdepotfacture.id_piece' => $id, 'Stockdepotfacture.piece' => "Bonlivraison"), false);





                //   $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+'.$lra['Lignebonsortiestock']['quantite']), array('Stockdepot.article_id' =>$lra['Lignebonsortiestock']['article_id'],'Stockdepot.depot_id' =>$lra['Lignebonsortiestock']['depot_id']));
            }
        }
        $this->Lignebonsortiestock->deleteAll(array('Lignebonsortiestock.bonsortiestock_id' => $id), false);
        $abcd = $this->Bonsortiestock->find('first', array('conditions' => array('Bonsortiestock.id' => $id), 'recursive' => -1));
        $numansar = $abcd['Bonsortiestock']['numero'];
        $this->request->onlyAllow('post', 'delete');
        if ($this->Bonsortiestock->delete()) {
            $this->misejour("Bonsortiestock", $numansar, $id);
            $this->Session->setFlash(__('Bonsortiestock deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Bonsortiestock was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function notifbsstock() {

        $this->loadModel('Lignebonsortiestock');
        $this->loadModel('Utilisateur');
        $this->layout = null;
        $data = $this->request->data;
        $d = $data['personnel'];
        $nb = 0;
        $personnel = $this->Utilisateur->find('first', array('conditions' => array('Utilisateur.id' => $d)));

        $listebs = $this->Bonsortiestock->query('select * from bonsortiestocks where personnel_id=' . $personnel['Personnel']['id'] . ' and valide=0');
        $nbr = $this->Bonsortiestock->query('select count(*) from bonsortiestocks where personnel_id=' . $personnel['Personnel']['id'] . ' and valide=0');
        $nb = $nbr[0][0]['count(*)'];

        //val
        $listebsval = $this->Bonsortiestock->query('select * from bonsortiestocks where utilisateur_id=' . $d . ' and valide=1 and alert=1');
        $nbrval = $this->Bonsortiestock->query('select count(*) from bonsortiestocks where utilisateur_id=' . $d . ' and valide=1 and alert=1');
        $nb += $nbrval[0][0]['count(*)'];

        //ref
        $listebsref = $this->Bonsortiestock->query('select * from bonsortiestocks where utilisateur_id=' . $d . ' and valide=2 and alert=1');
        $nbrref = $this->Bonsortiestock->query('select count(*) from bonsortiestocks where utilisateur_id=' . $d . ' and valide=2 and alert=1');
        $nb += $nbrref[0][0]['count(*)'];

        echo json_encode(array('nb' => $nb, 'listebs' => $listebs, 'listebsvalid' => $listebsval, 'listebsrefus' => $listebsref));
        die;
    }

    public function notifBS() {


        $this->layout = null;
        $data = $this->request->data;
        $bs = $data['bonsorti'];
        $this->Bonsortiestock->updateAll(array('Bonsortiestock.alert' => 0), array('Bonsortiestock.id' => $bs));

        die;
    }

}
