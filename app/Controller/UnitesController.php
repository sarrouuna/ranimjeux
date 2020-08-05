<?php

App::uses('AppController', 'Controller');

/**
 * Unites Controller
 *
 * @property Unite $Unite
 */
class UnitesController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_stock');
        $unite = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'unites') {
                    $unite = 1;
                }
            }
        }
        if (( $unite <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Unite->recursive = 0;
        $this->set('unites', $this->paginate());
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_stock');
        $unite = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'unites') {
                    $unite = 1;
                }
            }
        }
        if (( $unite <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Unite->exists($id)) {
            throw new NotFoundException(__('Invalid unite'));
        }
        $options = array('conditions' => array('Unite.' . $this->Unite->primaryKey => $id));
        $this->set('unite', $this->Unite->find('first', $options));
    }

    public function add() {
        $lien = CakeSession::read('lien_stock');
        $unite = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'unites') {
                    $unite = $liens['add'];
                }
            }
        }
        if (( $unite <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if ($this->request->is('post')) {
            $this->Unite->create();
            if ($this->Unite->save($this->request->data)) {
                $id=$this->Unite->id;
                $this->misejour("Unite","add",$id); 
                $this->Session->setFlash(__('The unite has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The unite could not be saved. Please, try again.'));
            }
        }
        $codes = $this->Unite->find('all', array('fields' =>
            array(
                'MAX(Unite.code) as num'
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
        $unite = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'unites') {
                    $unite = $liens['edit'];
                }
            }
        }
        if (( $unite <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Unite->exists($id)) {
            throw new NotFoundException(__('Invalid unite'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Unite->save($this->request->data)) {
                $this->misejour("Unite","edit",$id); 
                $this->Session->setFlash(__('The unite has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The unite could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Unite.' . $this->Unite->primaryKey => $id));
            $this->request->data = $this->Unite->find('first', $options);
        }
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_stock');
        $unite = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'unites') {
                    $unite = $liens['delete'];
                }
            }
        }
        if (( $unite <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Unite->id = $id;
        if (!$this->Unite->exists()) {
            throw new NotFoundException(__('Invalid unite'));
        }
        $abcd = $this->Unite->find('first', array('conditions' => array('Unite.id' => $id), 'recursive' => -1));
        $numansar=$abcd['Unite']['code'];
        $this->request->onlyAllow('post', 'delete');
        if ($this->Unite->delete()) {
          
                $this->misejour("Unite",$numansar,$id); 
            $this->Session->setFlash(__('Unite deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Unite was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
