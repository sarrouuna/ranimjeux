<?php

App::uses('AppController', 'Controller');

/**
 * Fournisseurs Controller
 *
 * @property Fournisseur $Fournisseur
 */
class FournisseursController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_achat');
        $fournisseur = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'fournisseurs') {
                    $fournisseur = 1;
                }
            }
        }
        if (( $fournisseur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            
             if ($this->request->data['Fournisseur']['fournisseure']) {
                $cond3 = "Fournisseur.id = '" . $this->request->data['Fournisseur']['fournisseure'] . "'";
            }

            $fournisseurs = $this->Fournisseur->find('all', array(
                'conditions' => array(@$cond3),
                'recursive' => 0
            ));
            
        } else {
            $fournisseurs = array();
        }
        $fournisseures = $this->Fournisseur->find('list');
        $this->set(compact('fournisseurs','fournisseures'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_achat');
        $fournisseur = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'fournisseurs') {
                    $fournisseur = 1;
                }
            }
        }
        if (( $fournisseur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Contact');
        if (!$this->Fournisseur->exists($id)) {
            throw new NotFoundException(__('Invalid fournisseur'));
        }
        $options = array('conditions' => array('Fournisseur.' . $this->Fournisseur->primaryKey => $id));
        $this->set('fournisseur', $this->Fournisseur->find('first', $options));
        $contacts = $this->Contact->find('all', array('conditions' => array('Contact.fournisseur_id' => $id)));
        $this->set(compact('contacts'));
    }

    public function imprimerimageRC($id = null) {
        $lien = CakeSession::read('lien_achat');
        $fournisseur = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'fournisseurs') {
                    $fournisseur = $liens['imprimer'];
                }
            }
        }
        if (( $fournisseur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $id)));
        $this->set(compact('fournisseur'));
    }

    public function imprimerimagePatente($id = null) {
        $lien = CakeSession::read('lien_achat');
        $fournisseur = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'fournisseurs') {
                    $fournisseur = $liens['imprimer'];
                }
            }
        }
        if (( $fournisseur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $id)));
        $this->set(compact('fournisseur'));
    }

    public function add() {
        $lien = CakeSession::read('lien_achat');
        $fournisseur = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'fournisseurs') {
                    $fournisseur = $liens['add'];
                }
            }
        }
        if (( $fournisseur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Contact');
        $this->loadModel('Fournisseurdevise');
        if ($this->request->is('post')) {
            $devise = $this->request->data['Fournisseur']['devise_id'];
            $this->request->data['Fournisseur']['devise_id'] = $this->request->data['Fournisseur']['devise_id'][0];
            $this->request->data['Fournisseur']['societe'] = CakeSession::read('composantsoc');
            $this->Fournisseur->create();
            if ($this->Fournisseur->save($this->request->data)) {
                $id = $this->Fournisseur->id;
                 $this->misejour("Fournisseur", "add", $id);
                $t = array();
                if (!empty($devise)) {
                    foreach ($devise as $d) {
                        $t['devise_id'] = $d;
                        $t['fournisseur_id'] = $id;
                        $this->Fournisseurdevise->create();
                        $this->Fournisseurdevise->save($t);
                    }
                }
                if (!empty($this->request->data['Contact'])) {
                    foreach ($this->request->data['Contact'] as $contact) {
                        if ($contact['sup'] != 1) {
                            if ($contact['name'] != "") {
                                $contact['fournisseur_id'] = $id;
                                $this->Contact->create();
                                $this->Contact->save($contact);
                            }
                        }
                    }
                }
                $this->Session->setFlash(__('The fournisseur has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The fournisseur could not be saved. Please, try again.'));
            }
        }
        $this->loadModel('Zone');
        $this->loadModel('Pay');
        $pays = $this->Pay->find('list');
        $zones = $this->Zone->find('list');
        $devises = $this->Fournisseur->Devise->find('list');
        $famillefournisseurs = $this->Fournisseur->Famillefournisseur->find('list');
        $this->set(compact('famillefournisseurs', 'devises', 'pays', 'zones'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_achat');
        $fournisseur = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'fournisseurs') {
                    $fournisseur = $liens['edit'];
                }
            }
        }
        if (( $fournisseur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Contact');
        $this->loadModel('Fournisseurdevise');
        if (!$this->Fournisseur->exists($id)) {
            throw new NotFoundException(__('Invalid fournisseur'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);die;
            $this->Fournisseurdevise->deleteAll(array('Fournisseurdevise.fournisseur_id' => $id), false);
            $devise = $this->request->data['Fournisseur']['devise_id'];
            $this->request->data['Fournisseur']['devise_id'] = $this->request->data['Fournisseur']['devise_id'][0];
            if ($this->Fournisseur->save($this->request->data)) {
                $this->misejour("Fournisseur", "edit", $id);

                $t = array();
                foreach ($devise as $d) {
                    $t['devise_id'] = $d;
                    $t['fournisseur_id'] = $id;
                    $this->Fournisseurdevise->create();
                    $this->Fournisseurdevise->save($t);
                }
                if (!empty($this->request->data['Contact'])) {
                    foreach ($this->request->data['Contact'] as $contact) {
                        if ($contact['sup'] != 1) {
                            if ($contact['name'] != "") {
                                $contact['fournisseur_id'] = $id;
                                $this->Contact->create();
                                $this->Contact->save($contact);
                            }
                        } else {
                            $this->Contact->deleteAll(array('Contact.id' => $contact['id']), false);
                        }
                    }
                }


                $this->Session->setFlash(__('The fournisseur has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The fournisseur could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Fournisseur.' . $this->Fournisseur->primaryKey => $id));
            $this->request->data = $this->Fournisseur->find('first', $options);
        }
        $this->loadModel('Zone');
        $this->loadModel('Pay');
        $pays = $this->Pay->find('list');
        $zones = $this->Zone->find('list');
        $contacts = $this->Contact->find('all', array('conditions' => array('Contact.fournisseur_id' => $id)));
        $devises = $this->Fournisseurdevise->find('all', array('conditions' => array('Fournisseurdevise.fournisseur_id' => $id)));
        //debug($devises);die;
        $devisess = $this->Fournisseur->Devise->find('all');
        $famillefournisseurs = $this->Fournisseur->Famillefournisseur->find('list');
        $this->set(compact('famillefournisseurs', 'devises', 'contacts', 'zones', 'pays', 'devisess'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_achat');
        $fournisseur = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'fournisseurs') {
                    $fournisseur = $liens['delete'];
                }
            }
        }
        if (( $fournisseur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Contact');
        $this->Fournisseur->id = $id;
        if (!$this->Fournisseur->exists()) {
            throw new NotFoundException(__('Invalid fournisseur'));
        }
        $this->request->onlyAllow('post', 'delete');
        $abcd = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $id), 'recursive' => -1));
         $numansar=$abcd['Fournisseur']['code'];
         $pvansar=$abcd['Fournisseur']['societe'];
        $this->Contact->deleteAll(array('Contact.fournisseur_id' => $id), false);

        if ($this->Fournisseur->delete()) {
             $this->misejour("Fournisseur",$numansar,$id,$pvansar);
            $this->Session->setFlash(__('Fournisseur deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Fournisseur was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
