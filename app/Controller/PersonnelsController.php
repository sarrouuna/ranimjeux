<?php

App::uses('AppController', 'Controller');

/**
 * Personnels Controller
 *
 * @property Personnel $Personnel
 */
class PersonnelsController extends AppController {

  
    public function index() {
        $lien = CakeSession::read('lien_parametrage');
        $personnel = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                // debug($liens);die;
                if (@$liens['lien'] == 'personnels') {
                    $personnel = 1;
                }
            }
        }
        if (( $personnel <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Personnel->recursive = 0;
        $this->set('personnels', $this->paginate());
    }
 
    public function view($id = null) {
        $lien = CakeSession::read('lien_parametrage');
        $personnel = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                // debug($liens);die;
                if (@$liens['lien'] == 'personnels') {
                    $personnel = 1;
                }
            }
        }
        if (( $personnel <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Personnel->exists($id)) {
            throw new NotFoundException(__('Invalid personnel'));
        }
        $options = array('conditions' => array('Personnel.' . $this->Personnel->primaryKey => $id));
        $this->set('personnel', $this->Personnel->find('first', $options));
    }

    public function add() {
        $lien = CakeSession::read('lien_parametrage');
        $personnel = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                // debug($liens);die;
                if (@$liens['lien'] == 'personnels') {
                    $personnel = $liens['add'];
                }
            }
        }
        if (( $personnel <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Societe');
        $this->loadModel('Commission');
        if ($this->request->is('post')) {
//            debug( $this->request->data);die;
            $this->Personnel->create();
            if ($this->Personnel->save($this->request->data)) {
                $id = $this->Personnel->id;
                $this->misejour("Personnel", "add", $id);
                if(!empty($this->request->data['Tcommission'])){
                foreach ($this->request->data['Tcommission'] as  $f) {

                    if ($f['sup'] != 1) {
                        $f['personnel_id'] = $id;
                        $this->Commission->create();
                        $this->Commission->save($f);
                    }
                }}
                $this->Session->setFlash(__('The personnel has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The personnel could not be saved. Please, try again.'));
            }
        }
        $fonctions = $this->Personnel->Fonction->find('list');
        $societes = $this->Societe->find('list');
        $commissionsurs['Article']="Article" ;
        $commissionsurs['Famille']="Famille" ;
        $commissionsurs['Sousfamille']="Sous famille" ;
        $commissionsurs['Soussousfamille']="Sous sous famille" ;
        $this->set(compact('societes','fonctions','commissionsurs'));
    }

    public function edit($id = null) {
         $this->loadModel('Societe');
        $lien = CakeSession::read('lien_parametrage');
        $personnel = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                // debug($liens);die;
                if (@$liens['lien'] == 'personnels') {
                    $personnel = $liens['edit'];
                }
            }
        }
        if (( $personnel <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Personnel->exists($id)) {
            throw new NotFoundException(__('Invalid personnel'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Personnel->save($this->request->data)) {
                $this->misejour("Personnel", "edit", $id);
                $this->Session->setFlash(__('The personnel has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The personnel could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Personnel.' . $this->Personnel->primaryKey => $id));
            $this->request->data = $this->Personnel->find('first', $options);
        }
        $fonctions = $this->Personnel->Fonction->find('list');
        $societes = $this->Societe->find('list');
        $commissionsurs['Article']="Article" ;
        $commissionsurs['Famille']="Famille" ;
        $commissionsurs['Sousfaille']="Sous faille" ;
        $commissionsurs['Soussousfamille']="Sous sous famille" ;
        $this->set(compact('fonctions','societes'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_parametrage');
        $personnel = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                // debug($liens);die;
                if (@$liens['lien'] == 'personnels') {
                    $personnel = $liens['delete'];
                }
            }
        }
        if (( $personnel <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Personnel->id = $id;
        if (!$this->Personnel->exists()) {
            throw new NotFoundException(__('Invalid personnel'));
        }
        $this->request->onlyAllow('post', 'delete');
     
        if ($this->Personnel->delete()) {
            $this->misejour("Personnel", $id, $id);
            $this->Session->setFlash(__('Personnel deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Personnel was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
    
     public function getcommissionsurs() {
        $this->layout = null;
        $data = $this->request->data; 
        $json = null;
        //debug($data);
        $commissionsur = $data['commissionsur'];
        $index = $data['index'];
        $commissionsurs['Article']="article_id" ;
        $commissionsurs['Famille']="famille_id" ;
        $commissionsurs['Sousfamille']="sousfamille_id" ;
        $commissionsurs['Soussousfamille']="soussousfamille_id" ;
        $this->loadModel($commissionsur);
        $req = $this->$commissionsur->find('all');
        //debug($req);die;
        $select="<label class='col-md-2 control-label'></label><div class='col-sm-12'><select name='data[Tcommission][".$index."][".$commissionsurs[$commissionsur]."]' champ='".$commissionsurs[$commissionsur]."' id='valeur".$index."' class='select ' onchange='' >";
        $select=$select."<option value=''>"."choix"."</option>";
            foreach($req as $v){
                $select=$select."<option value=".$v[$commissionsur]['id'].">".$v[$commissionsur]['code']." ".$v[$commissionsur]['name']."</option>";
            }
        $select=$select.'</select></div>';
        echo json_encode(array('select'=>$select,'champ'=>$commissionsurs[$commissionsur],'index'=>$index));
        die();
    }

}
