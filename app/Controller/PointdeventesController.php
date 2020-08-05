<?php

App::uses('AppController', 'Controller');

/**
 * Pointdeventes Controller
 *
 * @property Pointdevente $Pointdevente
 */
class PointdeventesController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_parametrage');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'pointdeventes') {
                    $vente = 1;
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Pointdevente->recursive = 0;
        $this->set('pointdeventes', $this->paginate());
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_parametrage');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'pointdeventes') {
                    $vente = 1;
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Pointdevente->exists($id)) {
            throw new NotFoundException(__('Invalid pointdevente'));
        }
        $options = array('conditions' => array('Pointdevente.' . $this->Pointdevente->primaryKey => $id));
        $this->set('pointdevente', $this->Pointdevente->find('first', $options));
    }

    public function add() {
        $this->loadModel('Societe');
        $lien = CakeSession::read('lien_parametrage');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'pointdeventes') {
                    $vente = $liens['add'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if ($this->request->is('post')) {
//            debug($this->request->data);
//            die;
            if ($this->request->data['Pointdevente']['fodecp'] == 0) {
                $this->request->data['Pointdevente']['fodec'] = '';
            }
            if ($this->request->data['Pointdevente']['retenuep'] == 0) {
                $this->request->data['Pointdevente']['retenue'] = '';
            }
            $this->Pointdevente->create();
            if ($this->Pointdevente->save($this->request->data)) {
                $id = $this->Pointdevente->id;
                $this->misejour("Pointdevente", "add", $id);
                $this->Session->setFlash(__('The pointdevente has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The pointdevente could not be saved. Please, try again.'));
            }
        }
        $personnels = $this->Pointdevente->Personnel->find('list');
        $societes = $this->Societe->find('list');
        $this->set(compact('personnels', 'societes'));
    }

    public function edit($id = null) {
        $this->loadModel('Societe');
        $lien = CakeSession::read('lien_parametrage');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'pointdeventes') {
                    $vente = $liens['edit'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Pointdevente->exists($id)) {
            throw new NotFoundException(__('Invalid pointdevente'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->request->data['Pointdevente']['fodecp'] == 0) {
                $this->request->data['Pointdevente']['fodec'] = '';
            }
            if ($this->request->data['Pointdevente']['retenuep'] == 0) {
                $this->request->data['Pointdevente']['retenue'] = '';
            }
            if ($this->Pointdevente->save($this->request->data)) {
                $this->misejour("Pointdevente", "edit", $id);
                $this->Session->setFlash(__('The pointdevente has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The pointdevente could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Pointdevente.' . $this->Pointdevente->primaryKey => $id));
            $this->request->data = $this->Pointdevente->find('first', $options);
        }
        $personnels = $this->Pointdevente->Personnel->find('list');
        $societes = $this->Societe->find('list');
        $this->set(compact('personnels', 'societes'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_parametrage');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'pointdeventes') {
                    $vente = $liens['delete'];
                }
            }
        }

        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        } $this->loadModel('Devi');
        $this->loadModel('Commandeclient');
        $this->loadModel('Factureclient');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Reglementclient');
        $pvid = $id;
        $sumttc = $this->Bonlivraison->find('count', array('conditions' => array('Bonlivraison.pointdevente_id' => $pvid)));
        $summtreg = $this->Commandeclient->find('count', array('conditions' => array('Commandeclient.pointdevente_id' => $pvid)));
        $sumttcf = $this->Devi->find('count', array('conditions' => array('Devi.pointdevente_id' => $pvid)));
        $summtregf = $this->Factureclient->find('count', array('conditions' => array('Factureclient.pointdevente_id' => $pvid)));
        $reglementlibre = $this->Reglementclient->find('count', array('conditions' => array('Reglementclient.pointdevente_id' => $pvid)));

        $var = $sumttc + $summtreg + $sumttcf + $summtregf + $reglementlibre;
        if ($var == 0) {
            $this->Pointdevente->id = $id;
            if (!$this->Pointdevente->exists()) {
                throw new NotFoundException(__('Invalid pointdevente'));
            }
            $this->request->onlyAllow('post', 'delete');
            $abcd = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $id), 'recursive' => -1));
            $numansar = $abcd['Pointdevente']['code'];
            if ($this->Pointdevente->delete()) {
                $this->misejour("Pointdevente", $numansar, $id);
                $this->Session->setFlash(__('Pointdevente deleted'));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            $this->Session->setFlash(__('Pointdevente was not deleted'));
            $this->redirect(array('action' => 'index'));
        }
    }

    public function testpvutilisers() {
        $this->layout = null;
        $this->loadModel('Devi');
        $this->loadModel('Commandeclient');
        $this->loadModel('Factureclient');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Reglementclient');
        $data = $this->request->data;
        $json = null;
        $pvid = $data['id'];
        $var = 0;

        $sumttc = $this->Bonlivraison->find('count', array('conditions' => array('Bonlivraison.pointdevente_id' => $pvid)));
        $summtreg = $this->Commandeclient->find('count', array('conditions' => array('Commandeclient.pointdevente_id' => $pvid)));
        $sumttcf = $this->Devi->find('count', array('conditions' => array('Devi.pointdevente_id' => $pvid)));
        $summtregf = $this->Factureclient->find('count', array('conditions' => array('Factureclient.pointdevente_id' => $pvid)));
        $reglementlibre = $this->Reglementclient->find('count', array('conditions' => array('Reglementclient.pointdevente_id' => $pvid)));


        $var = $sumttc + $summtreg + $sumttcf + $summtregf + $reglementlibre;
        //debug($var); 
        echo json_encode(array('var' => $var));
        die;
    }

    public function listesocietes() {
        $this->layout = null;
        $this->loadModel('Societe');
        $this->loadModel('Personnel');
        $this->loadModel('Depot');
        $data = $this->request->data;
        $id = $data['id'];
        $modele = $data['modele'];

        $sousFamillee = $this->Personnel->find('first', array('conditions' => array('Personnel.id ' => $id)));
        $sousFamille = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id ' => @$sousFamillee['Personnel']['societe_id'])));
        $depots = $this->Depot->find('all', array('conditions' => array('Depot.societe_id ' => @$sousFamillee['Personnel']['societe_id'])));
        $soc = $this->Societe->find('all');
        $select = "<select name='data[" . $modele . "][pointdevente_id]'  champ='pointdevente_id'  id='Pointdevente_id' class='form-control' >";
        $select = $select . "<option value=''>" . "-- Veuillez choisir --" . "</option>";
        foreach ($sousFamille as $v) {
            $select = $select . "<option value=" . $v['Pointdevente']['id'] . ">" . $v['Pointdevente']['name'] . "</option>";
        }
        $select = $select . '</select>';



        $selectdepot = "<select name='data[" . $modele . "][depot_id]'  champ='depot_id'  id='depot_id' class='form-control' >";
        $selectdepot = $selectdepot . "<option value=''>" . "-- Veuillez choisir --" . "</option>";
        foreach ($depots as $v) {
            $selectdepot = $selectdepot . "<option value=" . $v['Depot']['id'] . ">" . $v['Depot']['designation'] . "</option>";
        }
        $selectdepot = $selectdepot . '</select>';




        $selecte = "<select name='data[" . $modele . "][societe_id][]'  multiple='multiple' champ='societe_id'  id='Societe_id' class='form-control' >";
        $selecte = $selecte . "<option value=''>" . "-- Veuillez choisir --" . "</option>";
        foreach ($soc as $vv) {
            $chaine = '';
            if ($vv['Societe']['id'] == @$sousFamillee['Personnel']['societe_id']) {
                $chaine = "selected";
            }
            $selecte = $selecte . "<option " . $chaine . " value=" . $vv['Societe']['id'] . ">" . $vv['Societe']['nom'] . "</option>";
        }
        $selecte = $selecte . '</select>';

        echo json_encode(array('select' => $select, 'selecte' => $selecte, 'selectdepot' => $selectdepot));
        die;
    }

    public function getfodecretenue($id = null) {
        $this->layout = null;
        $pointdeventes = $this->Pointdevente->find('first', array(
            'conditions' => array('Pointdevente.id ' => @$id)));
        if(!empty($pointdeventes['Pointdevente']['fodec'])){
        $fodec = $pointdeventes['Pointdevente']['fodec'];
        }else{
        $fodec = 0;    
        }
        if(!empty($pointdeventes['Pointdevente']['retenue'])){
        $retenue = $pointdeventes['Pointdevente']['retenue'];
        }else{
        $retenue =0;    
        }
        echo json_encode(array('fodec' => $fodec, 'retenue' => $retenue));
        die;
    }

}
