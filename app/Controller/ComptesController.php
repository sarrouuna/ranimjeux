<?php

App::uses('AppController', 'Controller');

class ComptesController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'comptes') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Typecompte');
        $typecomptes = $this->Typecompte->find('list');

        $this->Compte->recursive = 0;
        $this->set('comptes', $this->paginate());
        $this->set(compact('typecomptes'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'comptes') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Compte->exists($id)) {
            throw new NotFoundException(__('Invalid compte'));
        }
        $this->loadModel('Typecompte');
        $typecomptes = $this->Typecompte->find('list');
        $options = array('conditions' => array('Compte.' . $this->Compte->primaryKey => $id));
        $this->set('compte', $this->Compte->find('first', $options));
        $this->set(compact('typecomptes'));
    }

    public function add() {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'comptes') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Compte');
        $this->loadModel('Typecompte');
        if ($this->request->is('post')) {
            $this->request->data['Compte']['date'] = date("Y-m-d");
            $this->Compte->create();
            if ($this->Compte->save($this->request->data)) {
                $id = $this->Compte->id;
                $this->misejour("Compte", "add", $id);
                $this->Session->setFlash(__('The compte has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The compte could not be saved. Please, try again.'));
            }
        }
        $typecomptes = $this->Typecompte->find('list');
        $this->set(compact('typecomptes'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'comptes') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Typecompte');
        $typecomptes = $this->Typecompte->find('list');
        if (!$this->Compte->exists($id)) {
            throw new NotFoundException(__('Invalid compte'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Compte->save($this->request->data)) {
                $this->misejour("Compte", "edit", $id);
                $this->Session->setFlash(__('The compte has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The compte could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Compte.' . $this->Compte->primaryKey => $id));
            $this->request->data = $this->Compte->find('first', $options);
        }
        $this->set(compact('typecomptes'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_finance');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'comptes') {
                    $x = $liens['delete'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Compte->id = $id;
        if (!$this->Compte->exists()) {
            throw new NotFoundException(__('Invalid compte'));
        }
        $this->request->onlyAllow('post', 'delete');
        $abcd = $this->Compte->find('first', array('conditions' => array('Compte.id' => $id), 'recursive' => -1));
        $numansar=$abcd['Compte']['code'];
        if ($this->Compte->delete()) {
            $this->misejour("Compte", $numansar, $id);
            $this->Session->setFlash(__('Compte deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Compte was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
