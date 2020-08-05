<?php

App::uses('AppController', 'Controller');

/**
 * Copiestockdepots Controller
 *
 * @property Copiestockdepot $Copiestockdepot
 */
class CopiestockdepotsController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = 1;
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Copiestockdepot->recursive = 0;
        $this->set('copiestockdepots', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = 1;
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Copiestockdepot->exists($id)) {
            throw new NotFoundException(__('Invalid copiestockdepot'));
        }
        $options = array('conditions' => array('Copiestockdepot.' . $this->Copiestockdepot->primaryKey => $id));
        $this->set('copiestockdepot', $this->Copiestockdepot->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = $liens['add'];
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Inventaire');
        $this->loadModel('Depot');
        $this->loadModel('Lignecopiestock');
        if ($this->request->is('post')) {
            $this->request->data['Copiestockdepot']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Copiestockdepot']['date'])));
            $this->request->data['Copiestockdepot']['heure'] = date("H:i", time());
            $this->request->data['Copiestockdepot']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Copiestockdepot']['exercice_id'] = date("Y");
            //debug ($this->request->data);
            $this->Copiestockdepot->create();
            if ($this->Copiestockdepot->save($this->request->data)) {
                $id = $this->Copiestockdepot->id;
                $stckdepots = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $this->request->data['Copiestockdepot']['depot_id']), 'recursive' => -1));
                foreach ($stckdepots as $i => $stckdepot) {
                    if ($stckdepot['Stockdepot']['quantite'] != 0) {
                        $stckdepot['Stockdepot']['id'] = "";
                        $stckdepot['Stockdepot']['copiestockdepot_id'] = $id;
                $articles = $this->Article->find('first', array('conditions' => array('Article.id' => $stckdepot['Stockdepot']['article_id']), 'recursive' => -1));
                //debug($articles);
                //debug ($stckdepot);die;
                        //debug($stckdepot);die;
                if(!empty($articles)){
                $stckdepot['Stockdepot']['prix']=$articles['Article']['pmp'];
                }else{
                $stckdepot['Stockdepot']['prix']=0;    
                }
                        $this->Lignecopiestock->create();
                        $this->Lignecopiestock->save($stckdepot['Stockdepot']);
                    }
                }
                $this->misejour("Copiestockdepot", "add", $id);
                $this->Session->setFlash(__('The copie stock depot has been saved'));
                $this->redirect(array('action' => 'index'));
            }
        }
        $numero = $this->Copiestockdepot->find('all', array('fields' =>
            array('MAX(Copiestockdepot.numero) as num'),
            'conditions' => array('Copiestockdepot.exercice_id' => date("Y"))
        ));
        foreach ($numero as $num) {
            $n = $num[0]['num'];

            if (!empty($n)) {
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            } else {
                $mm = "000001";
            }
        }
        $inventaires = $this->Inventaire->find('list', array('fields' => array('Inventaire.numero'), 'conditions' => array('Inventaire.valide' => 0)));
        //$articles = $this->Copiestockdepot->Article->find('list');
        $depots = $this->Depot->find('list');
        $this->set(compact('mm', 'inventaires', 'articles', 'depots'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $lien = CakeSession::read('lien_stock');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'inventaires') {
                    $inventaire = $liens['edit'];
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Stockdepot');
        $this->loadModel('Inventaire');
        $this->loadModel('Lignecopiestock');
        if (!$this->Copiestockdepot->exists($id)) {
            throw new NotFoundException(__('Invalid copiestockdepot'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
//            debug($this->request->data);die;
            $this->request->data['Copiestockdepot']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Copiestockdepot']['date'])));
            $this->request->data['Copiestockdepot']['heure'] = date("H:i", time());
            $this->request->data['Copiestockdepot']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Copiestockdepot']['exercice_id'] = date("Y");
            $this->Lignecopiestock->deleteAll(array('Lignecopiestock.copiestockdepot_id' => $id), false);
            if ($this->Copiestockdepot->save($this->request->data)) {
                $stckdepots = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $this->request->data['Copiestockdepot']['depot_id']), 'recursive' => -1));
                foreach ($stckdepots as $i => $stckdepot) {
                    if ($stckdepot['Stockdepot']['quantite'] != 0) {
                        $stckdepot['Stockdepot']['id'] = "";
                        $stckdepot['Stockdepot']['copiestockdepot_id'] = $id;
                        $articles = $this->Article->find('first', array('conditions' => array('Article.id' => $stckdepot['Stockdepot']['article_id']), 'recursive' => -1));
                //debug($articles);
                //debug ($stckdepot);die;
                        //debug($stckdepot);die;
                if(!empty($articles)){
                $stckdepot['Stockdepot']['prix']=$articles['Article']['pmp'];
                }else{
                $stckdepot['Stockdepot']['prix']=0;    
                }
                        //debug ($stckdepot);die;
                        //debug($stckdepot);die;
                        $this->Lignecopiestock->create();
                        $this->Lignecopiestock->save($stckdepot['Stockdepot']);
                    }
                }
                $this->misejour("Copiestockdepot", "edit", $id);
                $this->Session->setFlash(__('The copiestockdepot has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The copiestockdepot could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Copiestockdepot.' . $this->Copiestockdepot->primaryKey => $id));
            $this->request->data = $this->Copiestockdepot->find('first', $options);
        }
        $inventaires = $this->Inventaire->find('list', array('fields' => array('Inventaire.numero'), 'conditions' => array('Inventaire.valide' => 0)));
        //$articles = $this->Copiestockdepot->Article->find('list');
        $depots = $this->Depot->find('list');
        $this->set(compact('mm', 'inventaires', 'articles', 'depots'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $lien = CakeSession::read('inventaires');
        $inventaire = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'copiestocks') {
                    $inventaire = $liens['delete'];
                }
            }
        }
        if (( $inventaire <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignecopiestock');
        $this->Copiestockdepot->id = $id;
        if (!$this->Copiestockdepot->exists()) {
            throw new NotFoundException(__('Invalid copiestockdepot'));
        }
        $this->request->onlyAllow('post', 'delete');
        $this->Lignecopiestock->deleteAll(array('Lignecopiestock.copiestockdepot_id' => $id), false);
        if ($this->Copiestockdepot->delete()) {
            $this->Session->setFlash(__('Copiestockdepot deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Copiestockdepot was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
