<?php

App::uses('AppController', 'Controller');

/**
 * Familles Controller
 *
 * @property Famille $Famille
 */
class FamillesController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_stock');
        $famille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'familles') {
                    $famille = 1;
                }
            }
        }
        if (( $famille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->Famille->recursive = 0;
        $this->set('familles', $this->paginate());
    }

    public function view($id = null) {

        $lien = CakeSession::read('lien_stock');
        $famille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'familles') {
                    $famille = 1;
                }
            }
        }
        if (( $famille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Famille->exists($id)) {
            throw new NotFoundException(__('Invalid famille'));
        }
        $options = array('conditions' => array('Famille.' . $this->Famille->primaryKey => $id));
        $this->set('famille', $this->Famille->find('first', $options));
    }

    public function add() {
        $lien = CakeSession::read('lien_stock');
        $famille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'familles') {
                    $famille = $liens['add'];
                }
            }
        }
        if (( $famille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if ($this->request->is('post')) {
            $this->Famille->create();
            if ($this->Famille->save($this->request->data)) {
                $id=$this->Famille->id;
                $this->misejour("Famille","add",$id); 
                $this->Session->setFlash(__('The famille has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The famille could not be saved. Please, try again.'));
            }
        }
        $codes = $this->Famille->find('all', array('fields' =>
            array(
                'MAX(Famille.code) as num'
        )));
        foreach ($codes as $num) {
            $n = $num[0]['num'];

            if (!empty($n)) {
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $code = str_pad($nume, 6, "0", STR_PAD_LEFT);
            } else {
                $code = "000001";
            }
        }
        $this->set(compact('code'));
    }
 
    public function edit($id = null) {
        $lien = CakeSession::read('lien_stock');
        $famille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'familles') {
                    $famille = $liens['edit'];
                }
            }
        }
        if (( $famille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Famille->exists($id)) {
            throw new NotFoundException(__('Invalid famille'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Famille->save($this->request->data)) {
                $this->misejour("Famille","edit",$id); 
                $this->Session->setFlash(__('The famille has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The famille could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Famille.' . $this->Famille->primaryKey => $id));
            $this->request->data = $this->Famille->find('first', $options);
        }
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_stock');
        $famille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'familles') {
                    $famille = $liens['delete'];
                }
            }
        }
        if (( $famille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Famille->id = $id;
        if (!$this->Famille->exists()) {
            throw new NotFoundException(__('Invalid famille'));
        }
        $abcd = $this->Famille->find('first', array('conditions' => array('Famille.id' => $id), 'recursive' => -1));
        $numansar=$abcd['Famille']['code'];
        $this->request->onlyAllow('post', 'delete');
        if ($this->Famille->delete()) {
            
            $this->misejour("Famille",$numansar,$id); 
            $this->Session->setFlash(__('Famille deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Famille was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
    
    public function familleselect($data) {
        $this->layout = null;
        //$data = $this->request->data;
        $art=array();
        if($data!='0'){
        $prix = $this->Famille->find('all', array(
        'conditions' => array('Famille.name LIKE' => '%'.$data. '%'), 'recursive' => -1));
        }else{
        $prix = $this->Famille->find('all', array(
        'recursive' => -1));    
        }
        echo json_encode(array('Prix' => $prix)); // Tableau to JSON <> Json_Decode JOSN TO TABLE 
        die();
    }

}
