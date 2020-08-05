<?php

App::uses('AppController', 'Controller');

/**
 * Soussousfamilles Controller
 *
 * @property Soussousfamille $Soussousfamille
 */
class SoussousfamillesController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_stock');
        $soussousfamille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'soussousfamilles') {
                    $soussousfamille = 1;
                }
            }
        }
        if (( $soussousfamille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Soussousfamille->recursive = 0;
        $this->set('soussousfamilles', $this->paginate());
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_stock');
        $soussousfamille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'soussousfamilles') {
                    $soussousfamille = 1;
                }
            }
        }
        if (( $soussousfamille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Soussousfamille->exists($id)) {
            throw new NotFoundException(__('Invalid soussousfamille'));
        }
        $options = array('conditions' => array('Soussousfamille.' . $this->Soussousfamille->primaryKey => $id));
        $this->set('soussousfamille', $this->Soussousfamille->find('first', $options));
    }

    public function add() {
        $lien = CakeSession::read('lien_stock');
        $soussousfamille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'soussousfamilles') {
                    $soussousfamille = $liens['add'];
                }
            }
        }
        if (( $soussousfamille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if ($this->request->is('post')) {
            $this->Soussousfamille->create();
            $this->request->data['Soussousfamille']['sousfamille_id'] = @$this->request->data['sousfamille_id'];
            if ($this->Soussousfamille->save($this->request->data)) {
                $id=$this->Soussousfamille->id;
                $this->misejour("Soussousfamille","add",$id); 
                $this->Session->setFlash(__('The soussousfamille has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The soussousfamille could not be saved. Please, try again.'));
            }
        }
        $codes = $this->Soussousfamille->find('all', array('fields' =>
            array(
                'MAX(Soussousfamille.code) as num'
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
        $familles = $this->Soussousfamille->Famille->find('list');
        $sousfamilles = $this->Soussousfamille->Sousfamille->find('list');
        $this->set(compact('familles', 'sousfamilles', 'code'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_stock');
        $soussousfamille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'soussousfamilles') {
                    $soussousfamille = $liens['edit'];
                }
            }
        }
        if (( $soussousfamille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Soussousfamille->exists($id)) {
            throw new NotFoundException(__('Invalid soussousfamille'));
        }
        $soussousfamille = $this->Soussousfamille->find('first', array('conditions' => array('Soussousfamille.id' => $id)));
        $familleid = $soussousfamille['Famille']['id'];
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);die;            
            if ($this->request->data['Soussousfamille']['famille_id'] != $familleid) {
                if ($this->request->data['Soussousfamille']['sousfamille_id'] != @$this->request->data['sousfamille_id']) {
                    $this->request->data['Soussousfamille']['sousfamille_id'] = '';
                    if (@$this->request->data['sousfamille_id'] != 0) {
                        $this->request->data['Soussousfamille']['sousfamille_id'] = @$this->request->data['sousfamille_id'];
                    }
                }
            }
            // debug($this->request->data);die;   
            if ($this->Soussousfamille->save($this->request->data)) {
             
                $this->misejour("Soussousfamille","edit",$id); 
                $this->Session->setFlash(__('The soussousfamille has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The soussousfamille could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Soussousfamille.' . $this->Soussousfamille->primaryKey => $id));
            $this->request->data = $this->Soussousfamille->find('first', $options);
        }
        $familles = $this->Soussousfamille->Famille->find('list');
        $sousfamilles = $this->Soussousfamille->Sousfamille->find('list', array('conditions' => array('Sousfamille.famille_id' => $familleid)));
        $this->set(compact('familles', 'sousfamilles'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_stock');
        $soussousfamille = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'soussousfamilles') {
                    $soussousfamille = $liens['delete'];
                }
            }
        }
        if (( $soussousfamille <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Soussousfamille->id = $id;
        if (!$this->Soussousfamille->exists()) {
            throw new NotFoundException(__('Invalid soussousfamille'));
        }
        $abcd = $this->Soussousfamille->find('first', array('conditions' => array('Soussousfamille.id' => $id), 'recursive' => -1));
        $numansar=$abcd['Soussousfamille']['code'];
        $this->request->onlyAllow('post', 'delete');
        if ($this->Soussousfamille->delete()) {
            $this->misejour("Soussousfamille",$numansar,$id); 
            $this->Session->setFlash(__('Soussousfamille deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Soussousfamille was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
    
    public function soussousfamilleselect() {
        $this->layout = null;
        $data = $this->request->data;
        $art=array();
        if($data['val']!='0'){
        $prix = $this->Soussousfamille->find('all', array(
        'conditions' => array('Soussousfamille.name LIKE' => '%'.$data['val']. '%',
        'Soussousfamille.sousfamille_id'=>$data['sousfamille_id']), 'recursive' => -1
        ));
        }else{
        $prix = $this->Soussousfamille->find('all', array(
        'conditions' => array('Soussousfamille.sousfamille_id'=>$data['sousfamille_id'])
        , 'recursive' => -1 ));   
        }
       
        echo json_encode(array('Prix' => $prix)); // Tableau to JSON <> Json_Decode JOSN TO TABLE 
        die();
    }

}
