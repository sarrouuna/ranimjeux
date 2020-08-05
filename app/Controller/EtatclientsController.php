<?php

App::uses('AppController', 'Controller');

/**
 * Etatclients Controller
 *
 * @property Etatclient $Etatclient
 */
class EtatclientsController extends AppController {

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
                if (@$liens['lien'] == 'etatclients') {
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
        $this->loadModel('Tabetatclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Personnel');
        $this->loadModel('Societe');
        $this->Tabetatclient->query('TRUNCATE tabetatclients;');

        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id =' . $exe;
        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pvb = 'Bonlivraison.pointdevente_id = ' . $p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }
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
        $societe_id = "";
        if ($this->request->is('post')) {
//            debug($this->request->data);
//            die;
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
//                $this->set(compact('societe_id'));
            }
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $condb4 = 'Bonlivraison.exercice_id =' . $exercices[$exerciceid];
                $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
                $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
                $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
                $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
                $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
                $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            }

            if ($this->request->data['Recherche']['client_id']) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $condb3 = 'Bonlivraison.client_id =' . $clientid;
                $condf3 = 'Factureclient.client_id =' . $clientid;
                $conda3 = 'Factureavoir.client_id =' . $clientid;
            }

            if (!empty($this->request->data['Recherche']['pointdevente_id'])) {
                $pointdeventeid = $this->request->data['Recherche']['pointdevente_id'];
                $condb5 = 'Bonlivraison.pointdevente_id =' . $pointdeventeid;
                $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
                $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
            }
            if (!empty($this->request->data['Recherche']['personnel_id'])) {
                $personnelid = $this->request->data['Recherche']['personnel_id'];
                $clients = $this->Client->find('all', array('recursive' => -1, 'conditions' => array('Client.personnel_id' => $personnelid)));
                //debug($clients);die;
                $abc = '0';
                foreach ($clients as $cl) {
                    $abc = $abc . ',' . $cl['Client']['id'];
                }
                $condb9 = 'Bonlivraison.client_id in (' . $abc . ')';
                $condf9 = 'Factureclient.client_id in (' . $abc . ')';
                $conda9 = 'Factureavoir.client_id in (' . $abc . ')';
            }
        }

        $bonlivraisonparprixs = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalht) as total', 'sum(Bonlivraison.totalttc) as totalttc', 'Client.name', 'Client.id')
            , 'conditions' => array('Bonlivraison.id > ' => 0, @$pvb, @$condb1, @$condb2, @$condb3, @$condb5, @$condb4, @$condb9, $condbsos)
            , 'group' => array('Bonlivraison.client_id')));


        $bonlivraisonpartotales = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalht) as total')
            , 'conditions' => array(@$condb4, @$condb1, @$condb2)));

        $bonlivraisonpartotalesTTC = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalttc) as total')
            , 'conditions' => array(@$condb4, @$condb1, @$condb2)));

        $factureclientparprixs = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalht) as total', 'sum(Factureclient.totalttc) as totalttc', 'Client.name', 'Client.id')
            , 'conditions' => array('Factureclient.source="fac"', 'Factureclient.id > ' => 0, @$pvf, @$condf1, @$condf2, @$condf3, @$condf4, @$condf5, @$condf9, $condfsos)
            , 'group' => array('Factureclient.client_id')));
        $factureclientpartotales = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalht) as total')
            , 'conditions' => array('Factureclient.source="fac"', @$condf4, @$condf1, @$condf2)));

        $factureclientpartotalesTTC = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalttc) as total')
            , 'conditions' => array('Factureclient.source="fac"', @$condf4, @$condf1, @$condf2)));

        $factureavoirparprixs = $this->Factureavoir->find('all', array('fields' => array('sum(Factureavoir.totalht) as total', 'sum(Factureavoir.totalttc) as totalttc', 'Client.name', 'Client.id')
            , 'conditions' => array('Factureavoir.id > ' => 0, @$pva, @$conda1, @$conda2, @$conda3, @$conda4, @$conda5, @$conda9, $condasos)
            , 'group' => array('Factureavoir.client_id')));

        $factureavoirpartotales = $this->Factureavoir->find('all', array('fields' => array('sum(Factureavoir.totalht) as total')
            , 'conditions' => array(@$conda4, @$conda1, @$conda2)));

        $factureavoirpartotalesTTC = $this->Factureavoir->find('all', array('fields' => array('sum(Factureavoir.totalttc) as total')
            , 'conditions' => array(@$conda4, @$conda1, @$conda2)));

//   debug($factureclientpartotales);
//   debug($bonlivraisonpartotales);
//   debug($factureavoirpartotales);
//   
//   debug($factureclientpartotalesTTC);
//   debug($bonlivraisonpartotalesTTC);
//   debug($factureavoirpartotalesTTC);
        $totaleBLF = $bonlivraisonpartotales[0][0]['total'] + $factureclientpartotales[0][0]['total'] - $factureavoirpartotales[0][0]['total'];
        $totaleBLFTTC = $bonlivraisonpartotalesTTC[0][0]['total'] + $factureclientpartotalesTTC[0][0]['total'] - $factureavoirpartotalesTTC[0][0]['total'];
//  debug($totaleBLF);
//  debug($totaleBLFTTC);
        $tab = array();
        $i = 0;
        //debug($bonlivraisonparprixs);
        //debug($factureclientparprixs);die;
        foreach ($factureclientparprixs as $facture) {
            $tab[$i]['clientid'] = $facture['Client']['id'];
            $tab[$i]['name'] = $facture['Client']['name'];
            $tab[$i]['tot'] = $facture[0]['total'];
            $tab[$i]['totalttc'] = $facture[0]['totalttc'];
            $tab[$i]['por'] = round(($facture[0]['total'] / $totaleBLF) * 100, 3);
            $this->Tabetatclient->create();
            $this->Tabetatclient->save($tab[$i]);
            $i++;
        }

        $tab = array();
        $index = 0;
        foreach ($bonlivraisonparprixs as $bonlivraison) {
            $tab[$index]['clientid'] = $bonlivraison['Client']['id'];
            $tab[$index]['name'] = $bonlivraison['Client']['name'];
            $tab[$index]['tot'] = $bonlivraison[0]['total'];
            $tab[$index]['totalttc'] = $bonlivraison[0]['totalttc'];
            $tab[$index]['por'] = round(($bonlivraison[0]['total'] / $totaleBLF) * 100, 3);
            $this->Tabetatclient->create();
            $this->Tabetatclient->save($tab[$index]);
            $index++;
        }

        if (!empty($factureavoirparprixs)) {
            $tab = array();
            $index = 0;
            foreach ($factureavoirparprixs as $bonlivraison) {
                $tab[$index]['clientid'] = $bonlivraison['Client']['id'];
                $tab[$index]['name'] = $bonlivraison['Client']['name'];
                $tab[$index]['totalttc'] = 0 - $bonlivraison[0]['totalttc'];
                $tab[$index]['tot'] = 0 - $bonlivraison[0]['total'];
                $tab[$index]['por'] = round(($bonlivraison[0]['total'] / $totaleBLF) * 100, 3);
                $this->Tabetatclient->create();
                $this->Tabetatclient->save($tab[$index]);
                $index++;
            }
        }

        //debug($tab);die;

        $tab = $this->Tabetatclient->find('all', array(
            'fields' => array('sum(Tabetatclient.tot) as tot', 'sum(Tabetatclient.totalttc) as ttc', 'clientid', 'name', 'article', 'sum(Tabetatclient.qte) as qte')
            , 'group' => array('Tabetatclient.clientid')
            , 'order' => array('sum(Tabetatclient.tot)' => 'desc')
            , 'recursive' => 2));

        //debug($tab);die;
        $soc = CakeSession::read('soc');
        $sos = explode(',', $soc);
        $countsos = count($sos);
        if ($countsos > 1) {
            $societes = $this->Societe->find('list', array(
                'conditions' => array('Societe.id in' => $sos)
            ));
        }
        $personnels = $this->Personnel->find('list');
        $clients = $this->Client->find('list');
        $this->set(compact('societe_id','countsos', 'societes', 'personnels', 'totaleBLFTTC', 'pointdeventeid', 'totaleBLF', 'tab', 'bonlivraisons', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'factureclients'));
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'etatclients') {
                    $x = $liens['imprimer'];
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
        $this->loadModel('Tabetatclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignefactureavoir');


        //  $this->Tabetatclient->query('TRUNCATE tabetatclients;');  

        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id =' . $exe;
        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pvb = 'Bonlivraison.pointdevente_id = ' . $p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }

        //debug($this->request->data);die;
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
            $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
            $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }

        if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            $condb3 = 'Bonlivraison.client_id =' . $clientid;
            $condf3 = 'Factureclient.client_id =' . $clientid;
            $conda3 = 'Factureavoir.client_id =' . $clientid;
        }

        if (!empty($this->request->query['pointdeventeid'])) {
            $pointdeventeid = $this->request->query['pointdeventeid'];
            $condb5 = 'Bonlivraison.pointdevente_id =' . $pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
            $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
        }


//  $bonlivraisonparprixs = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalht) as total','Client.name','Client.id')
//  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,@$pvb, @$condb1, @$condb2, @$condb3 , @$condb4, @$condb5)
//  ,'group'=>array('Bonlivraison.client_id')));
//  
//  
//   $bonlivraisonpartotales = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalht) as total')
//  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0)));
//   
//  $factureclientparprixs = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalht) as total','Client.name','Client.id')
//   , 'conditions' => array('Factureclient.id > ' => 0,@$pvf, @$condf1, @$condf2, @$condf3 , @$condf4, @$condf5)
//   ,'group'=>array('Factureclient.client_id')));
//  
//   $factureavoirparprixs = $this->Factureavoir->find('all', array('fields'=>array('sum(Factureavoir.totalht) as total','Client.name','Client.id')
//   , 'conditions' => array('Factureavoir.id > ' => 0,@$pva, @$conda1, @$conda2, @$conda3 , @$conda4, @$conda5)
//   ,'group'=>array('Factureavoir.client_id')));
//  
//  
//  
//  $factureclientpartotales = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalht) as total'), 'conditions' => array('Factureclient.id > ' => 0)));
//  
//  $totaleBLF=$bonlivraisonpartotales[0][0]['total']+$factureclientpartotales[0][0]['total'];
//   //debug($factureclientpartotales);die;
//       $tab=array();
//       $i=0;
//       //debug($bonlivraisonparprixs);
//       //debug($factureclientparprixs);die;
//       foreach ($factureclientparprixs as $facture){
//       $tab[$i]['clientid']= $facture['Client']['id'];     
//       $tab[$i]['name']= $facture['Client']['name'];    
//       $tab[$i]['tot']= $facture[0]['total'];
//       $tab[$i]['por']= round(($facture[0]['total']/$totaleBLF)*100,3);
//       $this->Tabetatclient->create();
//       $this->Tabetatclient->save($tab[$i]);
//       $i++;
//       }
//       //debug($tab);die;
//       $tab=array();
//       $index=0;
//       foreach ($bonlivraisonparprixs as $bonlivraison){
//       $tab[$index]['clientid']= $bonlivraison['Client']['id'];
//       $tab[$index]['name']= $bonlivraison['Client']['name'];
//       $tab[$index]['tot']= $bonlivraison[0]['total']; 
//       $tab[$index]['por']= round(($bonlivraison[0]['total']/$totaleBLF)*100,3);
//       $this->Tabetatclient->create();
//       $this->Tabetatclient->save($tab[$index]); 
//       $index++;
//       }
//       
//       if(!empty($factureavoirparprixs)){
//       $tab=array();
//       $index=0;
//       foreach ($factureavoirparprixs as $bonlivraison){
//       $tab[$index]['clientid']= $bonlivraison['Client']['id'];
//       $tab[$index]['name']= $bonlivraison['Client']['name'];
//       $tab[$index]['tot']= 0-$bonlivraison[0]['total']; 
//       $tab[$index]['por']= round(($bonlivraison[0]['total']/$totaleBLF)*100,3);
//       $this->Tabetatclient->create();
//       $this->Tabetatclient->save($tab[$index]); 
//       $index++;
//       }
//       }
//       
        $tab = $this->Tabetatclient->find('all', array(
            'fields' => array('sum(Tabetatclient.tot) as tot', 'sum(Tabetatclient.totalttc) as ttc', 'clientid', 'name', 'article', 'sum(Tabetatclient.qte) as qte')
            , 'group' => array('Tabetatclient.clientid')
            , 'order' => array('sum(Tabetatclient.tot)' => 'desc')
            , 'recursive' => 2));
        //debug($tab);die;


        $clients = $this->Client->find('list');
        $this->set(compact('pointdeventeid', 'totaleBLF', 'tab', 'bonlivraisons', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'factureclients'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Etatclient->exists($id)) {
            throw new NotFoundException(__('Invalid etatclient'));
        }
        $options = array('conditions' => array('Etatclient.' . $this->Etatclient->primaryKey => $id));
        $this->set('etatclient', $this->Etatclient->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Etatclient->create();
            if ($this->Etatclient->save($this->request->data)) {
                $this->Session->setFlash(__('The etatclient has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatclient could not be saved. Please, try again.'));
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
        if (!$this->Etatclient->exists($id)) {
            throw new NotFoundException(__('Invalid etatclient'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Etatclient->save($this->request->data)) {
                $this->Session->setFlash(__('The etatclient has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Etatclient.' . $this->Etatclient->primaryKey => $id));
            $this->request->data = $this->Etatclient->find('first', $options);
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
        $this->Etatclient->id = $id;
        if (!$this->Etatclient->exists()) {
            throw new NotFoundException(__('Invalid etatclient'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Etatclient->delete()) {
            $this->Session->setFlash(__('Etatclient deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Etatclient was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
