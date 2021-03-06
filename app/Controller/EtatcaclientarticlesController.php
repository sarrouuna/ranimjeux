<?php

App::uses('AppController', 'Controller');

/**
 * Etatcaclientarticles Controller
 *
 * @property Etatcaclientarticle $Etatcaclientarticle
 */
class EtatcaclientarticlesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'etatcaclientarticles') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Famille');
        $this->loadModel('Article');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Personnel');
        $this->loadModel('Moi');
        $this->loadModel('Pointdevente');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Societe');

        $pv = "";
        $pvf = "";
        $pva = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pvb = 'Bonlivraison.pointdevente_id = ' . $p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }

        $exercice1s = $this->Exercice->find('list');
        $exe1 = date('Y') - 1;
        $exercice1 = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe1)));
        $exerciceid1 = $exercice1['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id =' . $exe1;
        $condf4 = 'Factureclient.exercice_id =' . $exe1;
        $conda4 = 'Factureavoir.exercice_id =' . $exe1;


        $exercice2s = $this->Exercice->find('list');
        $exe2 = date('Y');
        $exercice2 = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe2)));
        $exerciceid2 = $exercice2['Exercice']['id'];
        $condb5 = 'Bonlivraison.exercice_id =' . $exe2;
        $condf5 = 'Factureclient.exercice_id =' . $exe2;
        $conda5 = 'Factureavoir.exercice_id =' . $exe2;

//        $socc = CakeSession::read('soc');
//        $pvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id in (' . $socc . ')')));
//        $liste_pv = '0';
//        foreach ($pvs as $one_pv) {
//            if (!empty($one_pv['Pointdevente']['id'])) {
//                $liste_pv = $liste_pv . ',' . $one_pv['Pointdevente']['id'];
//            }
//        }
//        $condbsos = 'Bonlivraison.pointdevente_id in (' . $liste_pv . ')';
//        $condfsos = 'Factureclient.pointdevente_id in (' . $liste_pv . ')';
//        $condasos = 'Factureavoir.pointdevente_id in (' . $liste_pv . ')';
//        $societe_id = "";




        if ($this->request->is('post')) {
            //debug($this->request->data);die;

            if (!empty($this->request->data['Recherche']['societe_id'])) {
                $societe_id = $this->request->data['Recherche']['societe_id'];
                $societe_id = implode(',', $societe_id);
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
                $condbsos = 'Bonlivraison.pointdevente_id in (' . $liste_pv . ')';
                $condfsos = 'Factureclient.pointdevente_id in (' . $liste_pv . ')';
                $condasos = 'Factureavoir.pointdevente_id in (' . $liste_pv . ')';
            }



            if ($this->request->data['Recherche']['client_id']) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $condb3 = 'Bonlivraison.client_id =' . $clientid;
                $condf3 = 'Factureclient.client_id =' . $clientid;
                $conda3 = 'Factureavoir.client_id =' . $clientid;
            }
            if ($this->request->data['Recherche']['exercice1']) {
                $exerciceid1 = $this->request->data['Recherche']['exercice1'];
                $condb4 = 'Bonlivraison.exercice_id =' . $exercice1s[$exerciceid1];
                $condf4 = 'Factureclient.exercice_id =' . $exercice1s[$exerciceid1];
                $conda4 = 'Factureavoir.exercice_id =' . $exercice1s[$exerciceid1];
            }
            if ($this->request->data['Recherche']['exercice2']) {
                $exerciceid2 = $this->request->data['Recherche']['exercice2'];
                $condb5 = 'Bonlivraison.exercice_id =' . $exercice2s[$exerciceid2];
                $condf5 = 'Factureclient.exercice_id =' . $exercice2s[$exerciceid2];
                $conda5 = 'Factureavoir.exercice_id =' . $exercice2s[$exerciceid2];
            }
            if (!empty($this->request->data['Recherche']['personnel_id'])) {
                $personnelid = $this->request->data['Recherche']['personnel_id'];
                $clients = $this->Client->find('all', array('recursive' => -1, 'conditions' => array('Client.personnel_id' => $personnelid)));
                $abc = '0';
                foreach ($clients as $cl) {
                    $abc = $abc . ',' . $cl['Client']['id'];
                }
                $condb8 = 'Bonlivraison.client_id in (' . $abc . ')';
                $condf8 = 'Factureclient.client_id in (' . $abc . ')';
            }
            if ($this->request->data['Recherche']['moi_id']) {
                $moiid = $this->request->data['Recherche']['moi_id'];
                //debug($moiid);die;
                $t = '(0';
                foreach ($moiid as $ad) {
                    $t = $t . ',' . $ad;
                }
                $t = $t . ')';
                $condb9 = 'EXTRACT(MONTH FROM Bonlivraison.date) in' . $t;
                $condf9 = 'EXTRACT(MONTH FROM Factureclient.date) in' . $t;
                $conda9 = 'EXTRACT(MONTH FROM Factureavoir.date) in' . $t;
            }
            if (!empty($this->request->data['Recherche']['pointdevente_id'])) {
                $pointdeventeid = $this->request->data['Recherche']['pointdevente_id'];
                $condb10 = 'Bonlivraison.pointdevente_id =' . $pointdeventeid;
                $condf10 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
                $conda10 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
                $pv = "";
                $pvf = "";
                $pva = "";
            }
        }
        
        
        $bonlivraisonparprix1s = $this->Bonlivraison->find('all', array(
            'fields' => array('EXTRACT(MONTH FROM Bonlivraison.date) as mois', 'sum(Bonlivraison.totalttc) as total')
            , 'conditions' => array(@$pvb,@$condb3, @$condb4, @$condb6, @$condb7, @$condb8, @$condb9, @$condb10,@$condbsos)
            , 'group' => array('EXTRACT(MONTH FROM Bonlivraison.date)')
            //,'contain'=>array('Bonlivraison','Bonlivraison.Client','Article')
            , 'order' => array('EXTRACT(MONTH FROM Bonlivraison.date)' => 'asc')
            , 'recursive' => 2));
//debug($bonlivraisonparprix1s) ;  

        $bonlivraisonparprix2s = $this->Bonlivraison->find('all', array(
            'fields' => array('EXTRACT(MONTH FROM Bonlivraison.date) as mois', 'sum(Bonlivraison.totalttc) as total')
            , 'conditions' => array(@$pvb,@$condb3, @$condb5, @$condb6, @$condb7, @$condb9, @$condb10,@$condbsos)
            , 'group' => array('EXTRACT(MONTH FROM Bonlivraison.date)')
            //,'contain'=>array('Bonlivraison','Bonlivraison.Client','Article')
            , 'order' => array('EXTRACT(MONTH FROM Bonlivraison.date)' => 'asc')
            , 'recursive' => 2));
//debug($bonlivraisonparprix2s) ;


        $factureclientparprix1s = $this->Factureclient->find('all', array(
            'fields' => array('EXTRACT(MONTH FROM Factureclient.date) as mois', 'sum(Factureclient.totalttc) as total')
            , 'conditions' => array('Factureclient.source="fac"',@$pvf, @$condf3, @$condf4, @$condf6, @$condf7, @$condf8, @$condf9, @$condf10,@$condfsos)
            , 'group' => array('EXTRACT(MONTH FROM Factureclient.date)')
            //,'contain'=>array('Factureclient','Factureclient.Client','Article')
            , 'order' => array('EXTRACT(MONTH FROM Factureclient.date)' => 'asc')
            , 'recursive' => 2));
        //debug($factureclientparprix1s) ;
        $factureclientparprix2s = $this->Factureclient->find('all', array(
            'fields' => array('EXTRACT(MONTH FROM Factureclient.date) as mois', 'sum(Factureclient.totalttc) as total')
            , 'conditions' => array('Factureclient.source="fac"',@$pvf ,@$condf3, @$condf5, @$condf6, @$condf7, @$condf8, @$condf9, @$condf10,@$condfsos)
            , 'group' => array('EXTRACT(MONTH FROM Factureclient.date)')
            //,'contain'=>array('Factureclient','Factureclient.Client','Article')
            , 'order' => array('EXTRACT(MONTH FROM Factureclient.date)' => 'asc')
            , 'recursive' => 2));

        $factureavoirparprix1s = $this->Factureavoir->find('all', array(
            'fields' => array('EXTRACT(MONTH FROM Factureavoir.date) as mois', 'sum(Factureavoir.totalttc) as total')
            , 'conditions' => array('Factureavoir.id > ' => 0,@$pva, @$conda3, @$conda4, @$conda6, @$conda7, @$conda8, @$conda9, @$conda10,@$condasos)
            , 'group' => array('EXTRACT(MONTH FROM Factureavoir.date)')
            //,'contain'=>array('Factureclient','Factureclient.Client','Article')
            , 'order' => array('EXTRACT(MONTH FROM Factureavoir.date)' => 'asc')
            , 'recursive' => 2));


        $factureavoirparprix2s = $this->Factureavoir->find('all', array(
            'fields' => array('EXTRACT(MONTH FROM Factureavoir.date) as mois', 'sum(Factureavoir.totalttc) as total')
            , 'conditions' => array('Factureavoir.id > ' => 0,@$pva, @$conda3, @$conda5, @$conda6, @$conda7, @$conda8, @$conda9, @$conda10,@$condasos)
            , 'group' => array('EXTRACT(MONTH FROM Factureavoir.date)')
            //,'contain'=>array('Factureclient','Factureclient.Client','Article')
            , 'order' => array('EXTRACT(MONTH FROM Factureavoir.date)' => 'asc')
            , 'recursive' => 2));

        // debug($factureclientparprix2s) ;die;


        $familles = $this->Famille->find('list');
        $articles = $this->Article->find('list');
        $clients = $this->Client->find('list');
        $personnels = $this->Personnel->find('list');
        $mois = $this->Moi->find('list');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $soc = CakeSession::read('soc');
        $sos = explode(',', $soc);
        $countsos = count($sos);
        $societes = array();
        if ($countsos > 1) {
            $societes = $this->Societe->find('list', array(
                'conditions' => array('Societe.id in' => $sos)
            ));
        }
        $this->set(compact('societes', 'countsos','factureavoirparprix2s', 'factureavoirparprix1s', 'pointdeventes', 'exerciceid2', 'exerciceid1', 'factureclientparprix2s', 'factureclientparprix1s', 'bonlivraisonparprix2s', 'bonlivraisonparprix1s', 'moiid', 'mois', 'familleid', 'pointdeventeid', 'articleid', 'familles', 'totaleBLF', 'articles', 'tab', 'bonlivraisons', 'personnels', 'exerciceid1', 'exercice1s', 'exerciceid2', 'exercice2s', 'date1', 'date2', 'clientid', 'clients', 'factureclients'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Etatcaclientarticle->exists($id)) {
            throw new NotFoundException(__('Invalid etatcaclientarticle'));
        }
        $options = array('conditions' => array('Etatcaclientarticle.' . $this->Etatcaclientarticle->primaryKey => $id));
        $this->set('etatcaclientarticle', $this->Etatcaclientarticle->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Etatcaclientarticle->create();
            if ($this->Etatcaclientarticle->save($this->request->data)) {
                $this->Session->setFlash(__('The etatcaclientarticle has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatcaclientarticle could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Etatcaclientarticle->exists($id)) {
            throw new NotFoundException(__('Invalid etatcaclientarticle'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Etatcaclientarticle->save($this->request->data)) {
                $this->Session->setFlash(__('The etatcaclientarticle has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatcaclientarticle could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Etatcaclientarticle.' . $this->Etatcaclientarticle->primaryKey => $id));
            $this->request->data = $this->Etatcaclientarticle->find('first', $options);
        }
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Etatcaclientarticle->id = $id;
        if (!$this->Etatcaclientarticle->exists()) {
            throw new NotFoundException(__('Invalid etatcaclientarticle'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Etatcaclientarticle->delete()) {
            $this->Session->setFlash(__('Etatcaclientarticle deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Etatcaclientarticle was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
