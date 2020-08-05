<?php

App::uses('AppController', 'Controller');

/**
 * Etatretenues Controller
 *
 * @property Etatretenue $Etatretenue
 */
class EtatretenuesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->loadModel('Piecereglement');
        $this->loadModel('Fournisseur');
        $this->loadModel('Exercice');
        $exercices = $this->Exercice->find('list');
        if (isset($this->request->data) && !empty($this->request->data)) {
            // debug($this->request->data);die;

            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $cond4 = 'Reglement.exercice_id =' . $exercices[$exerciceid];
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $cond1 = 'Reglement.Date >= ' . "'" . $date1 . "'";
                $cond4 ="";
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $cond2 = 'Reglement.Date <= ' . "'" . $date2 . "'";
                $cond4 ="";
            }

            if ($this->request->data['Recherche']['fournisseur_id']) {
                $fournisseurid = $this->request->data['Recherche']['fournisseur_id'];
                $cond3 = 'Reglement.fournisseur_id =' . $fournisseurid;
            }
        }
        $etatretenues = $this->Piecereglement->find('all', array('conditions' => array('Piecereglement.paiement_id' => 5, @$cond1, @$cond2, @$cond3, @$cond4), 'recursive' => 0));  //debug($piecesreg);die;
        //debug($etatretenues);die;
        $fournisseurs = $this->Fournisseur->find('list');
        $exercices = $this->Exercice->find('list');
        $this->set(compact('etatretenues', 'fournisseurs', 'exercices'));
    }

    public function imprimer($id = null) {
        $this->loadModel('Piecereglement');
        $this->loadModel('Lignereglement');
        $this->loadModel('Fournisseur');
        $this->loadModel('Exercice');
        $exercices = $this->Exercice->find('list');
        $etatretenues = $this->Piecereglement->find('first', array('conditions' => array('Piecereglement.id' => $id), 'recursive' => 0));  //debug($piecesreg);die;
        //debug($etatretenues);die;
        $lignereglements = $this->Lignereglement->find('all', array('conditions' => array('Lignereglement.reglement_id' => $etatretenues['Piecereglement']['reglement_id']), 'recursive' => 0));  //debug($piecesreg);die;
        $fournisseurs = $this->Fournisseur->find('list');
        $exercices = $this->Exercice->find('list');
        $frs = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $etatretenues['Reglement']['fournisseur_id']), 'recursive' => 0));  //debug($piecesreg);die;
        $this->set(compact('etatretenues', 'fournisseurs', 'exercices', 'lignereglements', 'frs'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Etatretenue->exists($id)) {
            throw new NotFoundException(__('Invalid etatretenue'));
        }
        $options = array('conditions' => array('Etatretenue.' . $this->Etatretenue->primaryKey => $id));
        $this->set('etatretenue', $this->Etatretenue->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Etatretenue->create();
            if ($this->Etatretenue->save($this->request->data)) {
                $this->Session->setFlash(__('The etatretenue has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatretenue could not be saved. Please, try again.'));
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
        if (!$this->Etatretenue->exists($id)) {
            throw new NotFoundException(__('Invalid etatretenue'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Etatretenue->save($this->request->data)) {
                $this->Session->setFlash(__('The etatretenue has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatretenue could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Etatretenue.' . $this->Etatretenue->primaryKey => $id));
            $this->request->data = $this->Etatretenue->find('first', $options);
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
        $this->Etatretenue->id = $id;
        if (!$this->Etatretenue->exists()) {
            throw new NotFoundException(__('Invalid etatretenue'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Etatretenue->delete()) {
            $this->Session->setFlash(__('Etatretenue deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Etatretenue was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
