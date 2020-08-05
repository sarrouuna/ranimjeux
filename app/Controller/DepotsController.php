<?php

App::uses('AppController', 'Controller');

/**
 * Depots Controller
 *
 * @property Depot $Depot
 */
class DepotsController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_stock');
        $depot = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'depots') {
                    $depot = 1;
                }
            }
        }
        if (( $depot <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Depot->recursive = 0;
        $this->set('depots', $this->paginate());
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_stock');
        $depot = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'depots') {
                    $depot = 1;
                }
            }
        }
        if (( $depot <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Depot->exists($id)) {
            throw new NotFoundException(__('Invalid depot'));
        }
        $options = array('conditions' => array('Depot.' . $this->Depot->primaryKey => $id));
        $this->set('depot', $this->Depot->find('first', $options));
    }

    public function add() {
        $this->loadModel('Typeetatarticle');
        $this->loadModel('Societe');
        $lien = CakeSession::read('lien_stock');
        $depot = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'depots') {
                    $depot = $liens['add'];
                }
            }
        }

        if (( $depot <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }


        if ($this->request->is('post')) {
            $this->Depot->create();
            if ($this->Depot->save($this->request->data)) {
                $id = $this->Depot->id;
                $this->misejour("Depot", "add", $id);
                $this->Session->setFlash(__('The depot has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The depot could not be saved. Please, try again.'));
            }
        }
        $typeetatarticles = $this->Typeetatarticle->find('list');
        $societes = $this->Societe->find('list');
        $this->set(compact('typeetatarticles', 'societes'));
    }

    public function edit($id = null) {
        $this->loadModel('Typeetatarticle');
        $this->loadModel('Societe');
        $lien = CakeSession::read('lien_stock');
        $depot = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'depots') {
                    $depot = $liens['edit'];
                }
            }
        }
        if (( $depot <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Depot->exists($id)) {
            throw new NotFoundException(__('Invalid depot'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Depot->save($this->request->data)) {
                $this->misejour("Depot", "edit", $id);
                $this->Session->setFlash(__('The depot has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The depot could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Depot.' . $this->Depot->primaryKey => $id));
            $this->request->data = $this->Depot->find('first', $options);
        }
        $typeetatarticles = $this->Typeetatarticle->find('list');
        $societes = $this->Societe->find('list');
        $this->set(compact('societes', 'typeetatarticles'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_stock');
        $depot = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'depots') {
                    $depot = $liens['delete'];
                }
            }
        }
        if (( $depot <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Depot->id = $id;
        if (!$this->Depot->exists()) {
            throw new NotFoundException(__('Invalid depot'));
        }
        $abcd = $this->Depot->find('first', array('conditions' => array('Depot.id' => $id), 'recursive' => -1));
        $numansar = $abcd['Depot']['code'];
        $this->request->onlyAllow('post', 'delete');
        if ($this->Depot->delete()) {
            $this->misejour("Depot", $numansar, $id);
            $this->Session->setFlash(__('Depot deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Depot was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function findedepot($val = null, $sos = null) {
        $this->layout = null;
//        debug($sos);
//        $data = $this->request->data;
        if ($sos == 0) {
            $prix = $this->Depot->find('all', array(
                'conditions' => array('Depot.nom LIKE' => '%' . $val . '%'), 'recursive' => -1
            ));
        }else{
             $prix = $this->Depot->find('all', array(
                'conditions' => array('Depot.nom LIKE' => '%' . $val . '%','Depot.societe_id'=>$sos), 'recursive' => -1
            ));
        }

        echo json_encode(array('Prix' => $prix));
        die();
    }

}
