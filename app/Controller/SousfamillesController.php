<?php

App::uses('AppController', 'Controller');

/**
 * Sousfamilles Controller
 *
 * @property Sousfamille $Sousfamille
 */
class SousfamillesController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_stock');
        $sousfamille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'sousfamilles') {
                    $sousfamille = 1;
                }
            }
        }
        if (( $sousfamille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Sousfamille->recursive = 0;
        $this->set('sousfamilles', $this->paginate());
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_stock');
        $sousfamille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'sousfamilles') {
                    $sousfamille = 1;
                }
            }
        }
        if (( $sousfamille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Sousfamille->exists($id)) {
            throw new NotFoundException(__('Invalid sousfamille'));
        }
        $options = array('conditions' => array('Sousfamille.' . $this->Sousfamille->primaryKey => $id));
        $this->set('sousfamille', $this->Sousfamille->find('first', $options));
    }

    public function add() {
        $lien = CakeSession::read('lien_stock');
        $sousfamille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'sousfamilles') {
                    $sousfamille = $liens['add'];
                }
            }
        }
        if (( $sousfamille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        if ($this->request->is('post')) {
            $this->Sousfamille->create();
            if ($this->Sousfamille->save($this->request->data)) {
                $id=$this->Sousfamille->id;
                $this->misejour("Sousfamille","add",$id); 
                $this->Session->setFlash(__('The sousfamille has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The sousfamille could not be saved. Please, try again.'));
            }
        }
        $familles = $this->Sousfamille->Famille->find('list');
        $codes = $this->Sousfamille->find('all', array('fields' =>
            array(
                'MAX(Sousfamille.code) as num'
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
        $this->set(compact('familles', 'code'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_stock');
        $sousfamille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'sousfamilles') {
                    $sousfamille = $liens['edit'];
                }
            }
        }
        if (( $sousfamille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        if (!$this->Sousfamille->exists($id)) {
            throw new NotFoundException(__('Invalid sousfamille'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Sousfamille->save($this->request->data)) {
                $this->misejour("Sousfamille","edit",$id); 
                $this->Session->setFlash(__('The sousfamille has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The sousfamille could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Sousfamille.' . $this->Sousfamille->primaryKey => $id));
            $this->request->data = $this->Sousfamille->find('first', $options);
        }
        $familles = $this->Sousfamille->Famille->find('list');
        $this->set(compact('familles'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_stock');
        $sousfamille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'sousfamilles') {
                    $sousfamille = $liens['delete'];
                }
            }
        }
        if (( $sousfamille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Sousfamille->id = $id;
        if (!$this->Sousfamille->exists()) {
            throw new NotFoundException(__('Invalid sousfamille'));
        }
        $abcd = $this->Sousfamille->find('first', array('conditions' => array('Sousfamille.id' => $id), 'recursive' => -1));
        $numansar=$abcd['Sousfamille']['code'];
        $this->request->onlyAllow('post', 'delete');
        if ($this->Sousfamille->delete()) {
           
                $this->misejour("Sousfamille",$numansar,$id); 
            $this->Session->setFlash(__('Sousfamille deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Sousfamille was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    
    public function sousfamilleselect() {
        $this->layout = null;
        $data = $this->request->data;
        $art=array();
        if($data['val']!='0'){
        $prix = $this->Sousfamille->find('all', array(
        'conditions' => array('Sousfamille.name LIKE' => '%'.$data['val']. '%',
        'Sousfamille.famille_id'=>$data['famille_id']), 'recursive' => -1
        ));
        }else{
        $prix = $this->Sousfamille->find('all', array(
        'conditions' => array('Sousfamille.famille_id'=>$data['famille_id'])
        , 'recursive' => -1 ));   
        }
        echo json_encode(array('Prix' => $prix)); // Tableau to JSON <> Json_Decode JOSN TO TABLE 
        die();
    }
}
