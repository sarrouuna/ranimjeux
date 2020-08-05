<?php

App::uses('AppController', 'Controller');

/**
 * Namepiecejointes Controller
 *
 * @property Namepiecejointe $Namepiecejointe
 */
class NamepiecejointesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $lien = CakeSession::read('lien_achat');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'namepiecejointes') {
                    $vente = 1;
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Namepiecejointe->recursive = 0;
        $namepiecejointes = $this->Namepiecejointe->find('all', array(
            'recursive' => 0
        ));
        $this->set(compact('namepiecejointes'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $lien = CakeSession::read('lien_achat');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'namepiecejointes') {
                    $vente = 1;
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Namepiecejointe->exists($id)) {
            throw new NotFoundException(__('Invalid namepiecejointe'));
        }
        $options = array('conditions' => array('Namepiecejointe.' . $this->Namepiecejointe->primaryKey => $id));
        $this->set('namepiecejointe', $this->Namepiecejointe->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $lien = CakeSession::read('lien_achat');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'namepiecejointes') {
                    $vente = $liens['add'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if ($this->request->is('post')) {
            $this->Namepiecejointe->create();
            if ($this->Namepiecejointe->save($this->request->data)) {
                $this->Session->setFlash(__('The namepiecejointe has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The namepiecejointe could not be saved. Please, try again.'));
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
        $lien = CakeSession::read('lien_achat');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'namepiecejointes') {
                    $vente = $liens['edit'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Namepiecejointe->exists($id)) {
            throw new NotFoundException(__('Invalid namepiecejointe'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Namepiecejointe->save($this->request->data)) {
                $this->Session->setFlash(__('The namepiecejointe has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The namepiecejointe could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Namepiecejointe.' . $this->Namepiecejointe->primaryKey => $id));
            $this->request->data = $this->Namepiecejointe->find('first', $options);
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
        $lien = CakeSession::read('lien_achat');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'namepiecejointes') {
                    $vente = $liens['delete'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Namepiecejointe->id = $id;
        if (!$this->Namepiecejointe->exists()) {
            throw new NotFoundException(__('Invalid namepiecejointe'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Namepiecejointe->delete()) {
            $this->Session->setFlash(__('Namepiecejointe deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Namepiecejointe was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
