<?php

App::uses('AppController', 'Controller');

/**
 * Etatpointdeventes Controller
 *
 * property Etatpointdevente $Etatpointdevente
 */
class EtatpointdeventesController extends AppController {

    /**
     * index method
     *
     * return void
     */
    public function index() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if ($liens['lien'] == 'etatpointdeventes') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignefactureavoir');


        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id =' . $exe;
        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $condb1 = "";
        $pvb = "";
        $condb3 = "";
        $condf1 = "";
        $pvf = "";
        $condf3 = "";
        $conda1 = "";
        $pva = "";
        $conda3 = "";
        $condb2 = "";
        $condf2 = "";
        $conda2 = "";
        $condb5 = "";
        $condf5 = "";
        $conda5 = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pvb = 'Bonlivraison.pointdevente_id = ' . $p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }
        if ($this->request->is('post')) {
           // debug($this->request->data);
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $condb4 = 'Bonlivraison.exercice_id =' . $exercices[$exerciceid];
                $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
                $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____") {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
                $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
                $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
                $condf4 = "";
                $condf4av = "";
                $condb4 = "";
                $conda4 = "";
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____") {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
                $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
                $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
                $condf4 = "";
                $condf4av = "";
                $condb4 = "";
                $conda4 = "";
            }

            if (!empty($this->request->data['Recherche']['pointdevente_id'])) {
                $pointdeventeid = $this->request->data['Recherche']['pointdevente_id'];
                $condb5 = 'Bonlivraison.pointdevente_id =' . $pointdeventeid;
                $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
                $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
                $condpointvente = 'Pointdevente.id=' . $pointdeventeid;
            }
        }

        $bonlivraisonparprixs = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalht) as total, sum(Bonlivraison.totalttc) as totalttc, sum(Bonlivraison.Montant_Regler) as totalregler', 'pointdevente_id')
            , 'conditions' => array($pvb, $condb1, $condb2, $condb3, $condb4, $condb5)
            , 'group' => array('Bonlivraison.pointdevente_id')
            , 'contain' => array('Pointdevente.name'), 'recursive' => 2));
        
        
        //debug($bonlivraisonparprixs);
        
        $factureclientparprixs = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalht) as total,sum(Factureclient.totalttc) as totalttc,sum(Factureclient.Montant_Regler) as totalregler', 'pointdevente_id')
            , 'conditions' => array('Factureclient.source="fac"', $pvf, $condf1, $condf2, $condf3, $condf4, $condf5)
            , 'group' => array('Factureclient.pointdevente_id')
            , 'contain' => array('Pointdevente.name'), 'recursive' => 2));
        
        
       // debug($factureclientparprixs);
        
        
        $factureavoirparprixs = $this->Factureavoir->find('all', array('fields' => array('sum(Factureavoir.totalht) as total ,sum(Factureavoir.totalttc) as totalttc', 'pointdevente_id')
            , 'conditions' => array($pva, $conda1, $conda2, $conda3, $conda4, $conda5)
            , 'group' => array('Factureavoir.pointdevente_id')
            , 'contain' => array('Pointdevente.name'), 'recursive' => 2));
        
        
       // debug($factureavoirparprixs);
        
        $bonlivraisonpartotales = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalht) as total, sum(Bonlivraison.totalttc) as totalttc')
            , 'conditions' => array($pvb, $condb1, $condb2, $condb3, $condb4, $condb5)));

        $factureclientpartotales = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalht) as total ,sum(Factureclient.totalttc) as totalttc')
            , 'conditions' => array('Factureclient.source="fac"', $pvf, $condf1, $condf2, $condf3, $condf4, $condf5)));
        
        $avoirclientpartotales = $this->Factureavoir->find('all', array('fields' => array('sum(Factureavoir.totalht) as total ,sum(Factureavoir.totalttc) as totalttc')
            , 'conditions' => array($pva, $conda1, $conda2, $conda3, $conda4, $conda5)));
        
        $totaleBLF = ($bonlivraisonpartotales[0][0]['total'] + $factureclientpartotales[0][0]['total']) - $avoirclientpartotales[0][0]['total'];
        $totaleBLFttc = ($bonlivraisonpartotales[0][0]['totalttc'] + $factureclientpartotales[0][0]['totalttc']) - $avoirclientpartotales[0][0]['totalttc'];
        $tab = array();
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $listepointdeventes = $this->Pointdevente->find('all', array('conditions' => array(@$condpointvente,@$cond_liste_pv)));
        foreach ($listepointdeventes as $i => $listepointdevente) {
            $tab[$i]['tot'] = 0;
            $tab[$i]['totttc'] = 0;
            $tab[$i]['mtregler'] = 0;
            $tab[$i]['por'] = 0;
            $tab[$i]['porttc'] = 0;
            $tab[$i]['PVid'] = $listepointdevente['Pointdevente']['id'];
            $tab[$i]['PVname'] = $listepointdevente['Pointdevente']['name'];
            foreach ($factureclientparprixs as $facture) {
                if ($facture['Pointdevente']['id'] == $listepointdevente['Pointdevente']['id']) {
                    $tab[$i]['tot'] = $tab[$i]['tot'] + $facture[0]['total'];
                    $tab[$i]['totttc'] = $tab[$i]['totttc'] + $facture[0]['totalttc'];
                    $tab[$i]['mtregler'] = $tab[$i]['mtregler'] + $facture[0]['totalregler'];
                    //$tab[$i]['por'] = sprintf("%01.3f", (($facture[0]['total'] + $tab[$i]['por']) / $totaleBLF) * 100);
                    //$tab[$i]['porttc'] = sprintf("%01.3f", (($facture[0]['totalttc'] + $tab[$i]['porttc']) / $totaleBLFttc) * 100);
                }
            }
            foreach ($bonlivraisonparprixs as $bonlivraison) {
                if ($listepointdevente['Pointdevente']['id'] == $bonlivraison['Pointdevente']['id']) {
                    $tab[$i]['tot'] = $tab[$i]['tot'] + $bonlivraison[0]['total'];
                    $tab[$i]['totttc'] = $tab[$i]['totttc'] + $bonlivraison[0]['totalttc'];
                    $tab[$i]['mtregler'] = $tab[$i]['mtregler'] + $bonlivraison[0]['totalregler'];
                    //$tab[$i]['por'] = sprintf("%01.3f", (($tab[$i]['por'] + $bonlivraison[0]['total']) / $totaleBLF) * 100);
                    //$tab[$i]['porttc'] = sprintf("%01.3f", (($tab[$i]['porttc'] + $bonlivraison[0]['totalttc']) / $totaleBLFttc) * 100);
                }
            }
            foreach ($factureavoirparprixs as $ij => $factureav) {
                if ($listepointdevente['Pointdevente']['id'] == $factureav['Pointdevente']['id']) {
                    $tab[$i]['tot'] = $tab[$i]['tot'] - $factureav[0]['total'];
                    $tab[$i]['totttc'] = $tab[$i]['totttc'] - $factureav[0]['totalttc'];
                }
            }
        }

        foreach ($tab as $j => $t) {
            $tab[$j]['por'] = sprintf("%01.3f", (($tab[$j]['tot']) / $totaleBLF) * 100);
            $tab[$j]['porttc'] = sprintf("%01.3f", (( $tab[$j]['totttc']) / $totaleBLFttc) * 100);
        }






       // debug($tab);die;


        $clients = $this->Client->find('list');
        $this->set(compact('pointdeventeid', 'totaleBLF', 'totaleBLFttc', 'tab', 'bonlivraisons', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'factureclients'));
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if ($liens['lien'] == 'etatclients') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id =' . $exe;
        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $condb1 = "";
        $pvb = "";
        $condb3 = "";
        $condf1 = "";
        $pvf = "";
        $condf3 = "";
        $conda1 = "";
        $pva = "";
        $conda3 = "";
        $condb2 = "";
        $condf2 = "";
        $conda2 = "";
        $condb5 = "";
        $condf5 = "";
        $conda5 = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pvb = 'Bonlivraison.pointdevente_id = ' . $p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }

        //debug($this->request->query);die;
        $socc = CakeSession::read('soc');
        $pvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id in (' . $socc . ')')));
        $liste_pv = '0';
        foreach ($pvs as $one_pv) {
            if (!empty($one_pv['Pointdevente']['id'])) {
                $liste_pv = $liste_pv . ',' . $one_pv['Pointdevente']['id'];
            }
        }
        $condbsos = 'Bonlivraison.pointdevente_id in (' . $liste_pv . ')';
        $condfsos = 'Factureclient.pointdevente_id in (' . $liste_pv . ')';
        $condasos = 'Factureavoir.pointdevente_id in (' . $liste_pv . ')';
//          debug($this->request->query);die;
        if (!empty($this->request->query['societe_id'])) {
            $societe_id = $this->request->query['societe_id'];
            $pvs = $this->Pointdevente->find('all', array(
                'conditions' => array('Pointdevente.societe_id in (' . $societe_id . ')'),
                'fields' => array('Pointdevente.id')
            ));
            $liste_pv = '0';
            foreach ($pvs as $one_pv) {
                if (!empty($one_pv['Pointdevente']['id'])) {
                    $liste_pv = $liste_pv . ',' . $one_pv['Pointdevente']['id'];
                }
            }
//            debug($liste_pv);die;
            $condbsos = 'Bonlivraison.pointdevente_id in (' . $liste_pv . ')';
            $condfsos = 'Factureclient.pointdevente_id in (' . $liste_pv . ')';
            $condasos = 'Factureavoir.pointdevente_id in (' . $liste_pv . ')';
        }
        if ($this->request->query['exerciceid']) {
            $exerciceidd = $this->request->query['exerciceid'];
            $ex = $this->Exercice->find('first', array('conditions' => array('Exercice.id' => $exerciceidd)));
            $exerciceid = $ex['Exercice']['name'];
            $condb4 = 'Bonlivraison.exercice_id =' . $exerciceid;
            $condf4 = 'Factureclient.exercice_id =' . $exerciceid;
            $conda4 = 'Factureavoir.exercice_id =' . $exerciceid;
        }
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
            $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condf4av = "";
            $condb4 = "";
            $conda4 = "";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
            $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condf4av = "";
            $condb4 = "";
            $conda4 = "";
        }
        if (!empty($this->request->query['pointdeventeid'])) {
            $pointdeventeid = $this->request->query['pointdeventeid'];
            $condb5 = 'Bonlivraison.pointdevente_id =' . $pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
            $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pointdeventeid)));
            $name = $pointvente['Pointdevente']['name'];
        }


        $bonlivraisonparprixs = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalht) as total, sum(Bonlivraison.totalttc) as totalttc, sum(Bonlivraison.Montant_Regler) as totalregler', 'pointdevente_id')
            , 'conditions' => array($pvb, $condb1, $condb2, $condb3, $condb4, $condb5, $condbsos)
            , 'group' => array('Bonlivraison.pointdevente_id')
            , 'contain' => array('Pointdevente.name'), 'recursive' => 2));

        $bonlivraisonpartotales = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalht) as total, sum(Bonlivraison.totalttc) as totalttc')
            , 'conditions' => array($pvb, $condb1, $condb2, $condb3, $condb4, $condb5, $condbsos)));

        $factureclientparprixs = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalht) as total,sum(Factureclient.totalttc) as totalttc,sum(Factureclient.Montant_Regler) as totalregler', 'pointdevente_id')
            , 'conditions' => array('Factureclient.source="fac"', $pvf, $condf1, $condf2, $condf3, $condf4, $condf5, $condfsos)
            , 'group' => array('Factureclient.pointdevente_id')
            , 'contain' => array('Pointdevente.name'), 'recursive' => 2));

        $factureavoirparprixs = $this->Factureavoir->find('all', array('fields' => array('sum(Factureavoir.totalht) as total ,sum(Factureavoir.totalttc) as totalttc', 'pointdevente_id')
            , 'conditions' => array($pva, $conda1, $conda2, $conda3, $conda4, $conda5, $condasos)
            , 'group' => array('Factureavoir.pointdevente_id')
            , 'contain' => array('Pointdevente.name'), 'recursive' => 2));

        //debug($factureavoirparprixs);die;
        $factureclientpartotales = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalht) as total ,sum(Factureclient.totalttc) as totalttc'),
            'conditions' => array('Factureclient.source="fac"', $pvf, $condf1, $condf2, $condf3, $condf4, $condf5, $condfsos)));
        $avoirclientpartotales = $this->Factureavoir->find('all', array('fields' => array('sum(Factureavoir.totalht) as total ,sum(Factureavoir.totalttc) as totalttc'), 'conditions' => array($pva, $conda1, $conda2, $conda3, $conda4, $conda4, $conda5, $condasos)));
        $totaleBLF = ($bonlivraisonpartotales[0][0]['total'] + $factureclientpartotales[0][0]['total']) - $avoirclientpartotales[0][0]['total'];
        $totaleBLFttc = ($bonlivraisonpartotales[0][0]['totalttc'] + $factureclientpartotales[0][0]['totalttc']) - $avoirclientpartotales[0][0]['totalttc'];
        $tab = array();

        foreach ($factureclientparprixs as $i => $facture) {
            foreach ($bonlivraisonparprixs as $bonlivraison) {
                if ($facture['Pointdevente']['id'] == $bonlivraison['Pointdevente']['id']) {
                    $tab[$i]['PVid'] = $facture['Pointdevente']['id'];
                    $tab[$i]['PVname'] = $facture['Pointdevente']['name'];
                    $tab[$i]['tot'] = $facture[0]['total'] + $bonlivraison[0]['total'];
                    $tab[$i]['totttc'] = $facture[0]['totalttc'] + $bonlivraison[0]['totalttc'];
                    $tab[$i]['mtregler'] = $facture[0]['totalregler'] + $bonlivraison[0]['totalregler'];
                    $tab[$i]['por'] = sprintf("%01.3f", (($facture[0]['total'] + $bonlivraison[0]['total']) / $totaleBLF) * 100);
                    $tab[$i]['porttc'] = sprintf("%01.3f", (($facture[0]['totalttc'] + $bonlivraison[0]['totalttc']) / $totaleBLFttc) * 100);
                }
            }

            if (@$tab[$i]['PVname'] == "") {
                $tab[$i]['PVid'] = $facture['Pointdevente']['id'];
                $tab[$i]['PVname'] = $facture['Pointdevente']['name'];
                $tab[$i]['tot'] = $facture[0]['total'];
                $tab[$i]['totttc'] = $facture[0]['totalttc'];
                $tab[$i]['mtregler'] = $facture[0]['totalregler'];
                $tab[$i]['por'] = sprintf("%01.3f", ($facture[0]['total'] / $totaleBLF) * 100);
                $tab[$i]['porttc'] = sprintf("%01.3f", ($facture[0]['totalttc'] / $totaleBLFttc) * 100);
            }
            foreach ($factureavoirparprixs as $ij => $factureav) {
                if ($tab[$i]['PVid'] == $factureav['Pointdevente']['id']) {

                    $tab[$i]['tot'] = $tab[$i]['tot'] - $factureav[0]['total'];
                    $tab[$i]['totttc'] = $tab[$i]['totttc'] - $factureav[0]['totalttc'];
                }
            }
        }
        // debug($tab);

        $clients = $this->Client->find('list');
        $this->set(compact('name', 'pointdeventeid', 'totaleBLF', 'totaleBLFttc', 'tab', 'bonlivraisons', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'factureclients'));
    }

    /**
     * view method
     *
     * throws NotFoundException
     * param string $id
     * return void
     */
    public function view($id = null) {
        if (!$this->Etatpointdevente->exists($id)) {
            throw new NotFoundException(__('Invalid etatpointdevente'));
        }
        $options = array('conditions' => array('Etatpointdevente.' . $this->Etatpointdevente->primaryKey => $id));
        $this->set('etatpointdevente', $this->Etatpointdevente->find('first', $options));
    }

    /**
     * add method
     *
     * return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Etatpointdevente->create();
            if ($this->Etatpointdevente->save($this->request->data)) {
                $this->Session->setFlash(__('The etatpointdevente has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatpointdevente could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * throws NotFoundException
     * param string $id
     * return void
     */
    public function edit($id = null) {
        if (!$this->Etatpointdevente->exists($id)) {
            throw new NotFoundException(__('Invalid etatpointdevente'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Etatpointdevente->save($this->request->data)) {
                $this->Session->setFlash(__('The etatpointdevente has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatpointdevente could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Etatpointdevente.' . $this->Etatpointdevente->primaryKey => $id));
            $this->request->data = $this->Etatpointdevente->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * throws NotFoundException
     * param string $id
     * return void
     */
    public function delete($id = null) {
        $this->Etatpointdevente->id = $id;
        if (!$this->Etatpointdevente->exists()) {
            throw new NotFoundException(__('Invalid etatpointdevente'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Etatpointdevente->delete()) {
            $this->Session->setFlash(__('Etatpointdevente deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Etatpointdevente was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
