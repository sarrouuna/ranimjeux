<?php

App::uses('AppController', 'Controller');

/**
 * Tags Controller
 *
 * @property Tag $Tag
 */
class TagsController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_stock');
        $tag = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'tags') {
                    $tag = 1;
                }
            }
        }
        if (( $tag <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Tag->recursive = 0;
        $this->set('tags', $this->paginate());
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_stock');
        $tag = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'tags') {
                    $tag = 1;
                }
            }
        }
        if (( $tag <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Tag->exists($id)) {
            throw new NotFoundException(__('Invalid tag'));
        }
        $options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id));
        $this->set('tag', $this->Tag->find('first', $options));
    }

    public function add() {
        $lien = CakeSession::read('lien_stock');
        $tag = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'tags') {
                    $tag = $liens['add'];
                }
            }
        }
        if (( $tag <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if ($this->request->is('post')) {
            $this->Tag->create();
            if ($this->Tag->save($this->request->data)) {
                $id = $this->Tag->id;
                $this->misejour("Tag", "add", $id);
                $this->Session->setFlash(__('The tag has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
            }
        }
        $codes = $this->Tag->find('all', array('fields' =>
            array(
                'MAX(Tag.code) as num'
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
        $tag = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'tags') {
                    $tag = $liens['edit'];
                }
            }
        }
        if (( $tag <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Tag->exists($id)) {
            throw new NotFoundException(__('Invalid tag'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Tag->save($this->request->data)) {
                $this->misejour("Tag", "edit", $id);
                $this->Session->setFlash(__('The tag has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The tag could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Tag.' . $this->Tag->primaryKey => $id));
            $this->request->data = $this->Tag->find('first', $options);
        }
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_stock');
        $tag = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'tags') {
                    $tag = $liens['delete'];
                }
            }
        }
        if (( $tag <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Tag->id = $id;
        if (!$this->Tag->exists()) {
            throw new NotFoundException(__('Invalid tag'));
        }
        $abcd = $this->Tag->find('first', array('conditions' => array('Tag.id' => $id), 'recursive' => -1));
        $numansar=$abcd['Tag']['code'];
        $this->request->onlyAllow('post', 'delete');
        if ($this->Tag->delete()) {

            $this->misejour("Tag", $numansar, $id);
            $this->Session->setFlash(__('Tag deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Tag was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
