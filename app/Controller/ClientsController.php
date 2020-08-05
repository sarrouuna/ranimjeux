<?php

App::uses('AppController', 'Controller');

/**
 * Clients Controller
 *
 * @property Client $Client
 */
class ClientsController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_vente');
        $client = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'clients') {
                    $client = 1;
                }
            }
        }
        if (( $client <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Typeclient');
        $this->loadModel('Zone');
        $this->loadModel('Familleclient');
        $this->loadModel('Modeclient');
        $this->loadModel('Societe');
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Clients"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('Client', $this->request->data['Client']);
            } else {
                $this->request->data['Client'] = CakeSession::read('Client');
            }
            //debug($this->request->data['Client']);
            
            if ($this->request->data['Client']['societe']) {
                $societe = $this->request->data['Client']['societe'];
                if($societe==1){$societe="q";}
                if($societe==2){$societe="f";}
                $cond1 = 'Client.societe =' . "'".$societe."'";
            }
            if ($this->request->data['Client']['client_id']) {
                $client_id = $this->request->data['Client']['client_id'];
                $cond2 = 'Client.id =' . $client_id;
            }
            if ($this->request->data['Client']['zone_id']) {
                $zone_id = $this->request->data['Client']['zone_id'];
                $cond3 = 'Client.zone_id =' . $zone_id;
            }
            if ($this->request->data['Client']['typeclient_id']) {
                $typeclient_id = $this->request->data['Client']['typeclient_id'];
                $cond4 = 'Client.typeclient_id =' . $typeclient_id;
            }
            if ($this->request->data['Client']['familleclient_id']) {
                $familleclient_id = $this->request->data['Client']['familleclient_id'];
                $cond5 = 'Client.familleclient_id =' . $familleclient_id;
            }
            if ($this->request->data['Client']['etat']) {
                $etat = $this->request->data['Client']['etat'];
                $cond6 = 'Client.etat =' . $etat;
            }
            if ($this->request->data['Client']['modeclient_id']) {
                $modeclient_id = $this->request->data['Client']['modeclient_id'];
                $cond7 = 'Client.modeclient_id =' . $modeclient_id;
            }
            if ($this->request->data['Client']['matriculefiscale']) {
                $matriculefiscale = $this->request->data['Client']['matriculefiscale'];
                $cond8 = 'Client.matriculefiscale LIKE  "%'.$matriculefiscale.'%"';
            }

            $listeclients = $this->Client->find('all', array(
            'conditions' => array(@$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6, @$cond7,@$cond8)
            //,'contain'=>array('Familleclient','Sousfamilleclient','Zone')
            //,'fields' => array('Familleclient.id','Familleclient.name','Sousfamilleclient.id','Sousfamilleclient.name','Zone.id','Zone.name','Client.id','Client.code','Client.name','Client.adresse','Client.tel','Client.fax','Client.mail')
            ,'recursive'=>-1
                ));
            //debug($listeclients);
        }
        $societes = $this->Societe->find('list');
        //$clients = $this->Client->find('list');
        $zones = $this->Zone->find('list');
        $typeclients = $this->Typeclient->find('list');
        $familleclients = $this->Familleclient->find('list');
        $modeclients = $this->Modeclient->find('list');
        $etats = array();
        $etats[1] = "Actif";
        $etats[2] = "Non Actif";
        $this->set(compact('modeclient_id','etat','familleclient_id','typeclient_id','zone_id','client_id','societe','listeclients','etats','modeclients','familleclients','typeclients','zones','clients','societes'));
    }
    
    public function exp_etatexcel() {
        $this->layout = null;
        $this->loadModel('Typeclient');
        $this->loadModel('Zone');
        $this->loadModel('Familleclient');
        $this->loadModel('Modeclient');
        $this->loadModel('Societe');
        
            $this->request->data['Client'] = CakeSession::read('Client');
            
            if ($this->request->data['Client']['societe']) {
                $societe = $this->request->data['Client']['societe'];
                if($societe==1){$societe="q";}
                if($societe==2){$societe="f";}
                $cond1 = 'Client.societe =' . "'".$societe."'";
            }
            if ($this->request->data['Client']['client_id']) {
                $client_id = $this->request->data['Client']['client_id'];
                $cond2 = 'Client.id =' . $client_id;
            }
            if ($this->request->data['Client']['zone_id']) {
                $zone_id = $this->request->data['Client']['zone_id'];
                $cond3 = 'Client.zone_id =' . $zone_id;
            }
            if ($this->request->data['Client']['typeclient_id']) {
                $typeclient_id = $this->request->data['Client']['typeclient_id'];
                $cond4 = 'Client.typeclient_id =' . $typeclient_id;
            }
            if ($this->request->data['Client']['familleclient_id']) {
                $familleclient_id = $this->request->data['Client']['familleclient_id'];
                $cond5 = 'Client.familleclient_id =' . $familleclient_id;
            }
            if ($this->request->data['Client']['etat']) {
                $etat = $this->request->data['Client']['etat'];
                $cond6 = 'Client.etat =' . $etat;
            }
            if ($this->request->data['Client']['modeclient_id']) {
                $modeclient_id = $this->request->data['Client']['modeclient_id'];
                $cond7 = 'Client.modeclient_id =' . $modeclient_id;
            }

            $listeclients = $this->Client->find('all', array('conditions' => array(@$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6, @$cond7)));
        
        
        $this->set(compact('modeclient_id','etat','familleclient_id','typeclient_id','zone_id','client_id','societe','listeclients','etats','modeclients','familleclients','typeclients','zones','clients','societes'));
    }
    
    
    
    public function view($id = null) {
        $lien = CakeSession::read('lien_vente');
        $client = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'clients') {
                    $client = 1;
                }
            }
        }
        if (( $client <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Contact');
        $this->loadModel('Pointdevente');
        $this->loadModel('Exonorationclient');
        
        if (!$this->Client->exists($id)) {
            throw new NotFoundException(__('Invalid client'));
        }
        $options = array('conditions' => array('Client.' . $this->Client->primaryKey => $id));
        $this->set('client', $this->Client->find('first', $options));
        $contacts = $this->Contact->find('all', array('conditions' => array('Contact.client_id' => $id)));
        $exos = $this->Exonorationclient->find('all', array('conditions' => array('Exonorationclient.client_id' => $id)));
        $etats = array();
        $etats[1] = "Actif";
        $etats[2] = "Non Actif";
        $pointdeventes = $this->Pointdevente->find('list');
        $avectimbres = array();
        $avectimbres['Oui'] = "Oui";
        $avectimbres['Non'] = "Non";
        $this->set(compact('contacts','avectimbres','exos', 'etats', 'pointdeventes'));
    }

    public function imprimerimagerib($id = null) {
        $lien = CakeSession::read('lien_vente');
        $client = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'clients') {
                    $client = $liens['imprimer'];
                }
            }
        }
        if (( $client <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $client = $this->Client->find('first', array('conditions' => array('Client.id' => $id)));
        $this->set(compact('client'));
    }

    public function imprimerimageRC($id = null) {
        $lien = CakeSession::read('lien_vente');
        $client = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'clients') {
                    $client = $liens['imprimer'];
                }
            }
        }
        if (( $client <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $client = $this->Client->find('first', array('conditions' => array('Client.id' => $id)));
        $this->set(compact('client'));
    }

    public function imprimerimagePatente($id = null) {
        $lien = CakeSession::read('lien_vente');
        $client = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'clients') {
                    $client = $liens['imprimer'];
                }
            }
        }
        if (( $client <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $client = $this->Client->find('first', array('conditions' => array('Client.id' => $id)));
        $this->set(compact('client'));
    }

    public function add() {
        $lien = CakeSession::read('lien_vente');
        $client = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'clients') {
                    $client = $liens['add'];
                }
            }
        }
        if (( $client <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Contact');
        $this->loadModel('Typeclient');
        $this->loadModel('Modeclient');
        $this->loadModel('Pointdevente');
        $this->loadModel('Exonorationclient');
        
        $ventes = array();
        $ventes['detail'] = 'detail';
        $ventes['gros'] = 'gros';
        if ($this->request->is('post')) {
//            debug($this->request->data);die;
            $this->Client->create();
            $this->request->data['Client']['sousfamilleclient_id'] = @$this->request->data['sousfamilleclient_id'];
           $this->request->data['Client']['societe'] = CakeSession::read('composantsoc');
            if (empty($this->request->data['Client']['photorib']['name'])) {
                $this->request->data['Client']['photorib'] = "";
            }
            if (empty($this->request->data['Client']['registrecommercef']['name'])) {
                $this->request->data['Client']['registrecommercef'] = "";
            }
            if (empty($this->request->data['Client']['patente']['name'])) {
                $this->request->data['Client']['patente'] = "";
            }
            if ($this->Client->save($this->request->data)) {
                $id = $this->Client->id;
                $this->misejour("Client", "add", $id);
                if (!empty($this->request->data['Contact'])) {
                    foreach ($this->request->data['Contact'] as $contact) {
                        if ($contact['sup'] != 1) {
                            if ($contact['name'] != "") {
                                $contact['client_id'] = $id;
                                $this->Contact->create();
                                $this->Contact->save($contact);
                            }
                        }
                    }
                }
                
                if($this->request->data['Client']['typeclient_id']==2){
                if (!empty($this->request->data['Exonorationtva'])) {
                    foreach ($this->request->data['Exonorationtva'] as $tva) {
                        if ($tva['sup'] != 1) {
                            if ($tva['numero'] != "") {
                                
                                $tva['client_id'] = $id;
                                $tva['num_exe'] = $tva['numero'];
                                $tva['datedu'] = date("Y-m-d", strtotime(str_replace('/', '-',$tva['datedebut'])));
                                $tva['dateau'] = date("Y-m-d", strtotime(str_replace('/', '-',$tva['datefin'])));
                                $this->Exonorationclient->create();
                                $this->Exonorationclient->save($tva);
                                //$this->loadModel('Bonlivraison');
                                //$this->loadModel('Factureclient');
                                //$this->Bonlivraison->updateAll(array('Bonlivraison.totalttc' =>'Bonlivraison.totalht'), array('Bonlivraison.client_id'=>$id,'Bonlivraison.date >='.'"'.$tva['datedu'].'"','Bonlivraison.date <='.'"'.$tva['dateau'].'"'));
                                //$this->Factureclient->updateAll(array('Factureclient.totalttc' =>'Factureclient.totalht+Factureclient.timbre_id'), array('Factureclient.client_id'=>$id,'Factureclient.date >='.'"'.$tva['datedu'].'"','Factureclient.date <='.'"'.$tva['dateau'].'"'));
                                
                                
                                
                                
                            }
                        }else {
                            $this->Exonorationclient->deleteAll(array('Exonorationclient.id' => $tva['id']), false);
                        }
                    }
                }}

                $this->Session->setFlash(__('The client has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The client could not be saved. Please, try again.'));
            }
        }
        $etats = array();
        $etats[1] = "Actif";
        $etats[2] = "Non Actif";
        $familleclients = $this->Client->Familleclient->find('list');
        $sousfamilleclients = $this->Client->Sousfamilleclient->find('list');
        $zones = $this->Client->Zone->find('list');
        $personnels = $this->Client->Personnel->find('list');
        $typeclients = $this->Typeclient->find('list');
        $modeclients = array();
        $modeclients[1] = "Autoriser";
        $modeclients[2] = "Bloquer";
        $pointdeventes = $this->Pointdevente->find('list');
        $avectimbres = array();
        $avectimbres['Oui'] = "Oui";
        $avectimbres['Non'] = "Non";
        $this->set(compact('etats','avectimbres', 'pointdeventes', 'modeclients', 'typeclients', 'ventes', 'personnels', 'familleclients', 'sousfamilleclients', 'zones'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_vente');
        $client = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'clients') {
                    $client = $liens['edit'];
                }
            }
        }
        if (( $client <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if (!$this->Client->exists($id)) {
            throw new NotFoundException(__('Invalid client'));
        }
        $this->loadModel('Contact');
        $this->loadModel('Typeclient');
        $this->loadModel('Modeclient');
        $this->loadModel('Pointdevente');
        $this->loadModel('Exonorationclient');
        
        $client = $this->Client->find('first', array('conditions' => array('Client.id' => $id)));
        $familleclientid = $client['Familleclient']['id'];
        $ventes = array();
        $ventes['detail'] = 'detail';
        $ventes['gros'] = 'gros';
        if ($this->request->is('post') || $this->request->is('put')) {

          // debug($this->request->data);die;            
            if ($this->request->data['Client']['familleclient_id'] != $familleclientid) {
                if ($this->request->data['Client']['sousfamilleclient_id'] != @$this->request->data['sousfamilleclient_id']) {
                    $this->request->data['Client']['sousfamilleclient_id'] = '';
                    if (@$this->request->data['sousfamilleclient_id'] != 0) {
                        $this->request->data['Client']['sousfamilleclient_id'] = @$this->request->data['sousfamilleclient_id'];
                    }
                }
            }
            
            if (empty($this->request->data['Client']['photorib']['name'])) {
                $this->request->data['Client']['photorib'] = "";
            }
            if (empty($this->request->data['Client']['registrecommercef']['name'])) {
                $this->request->data['Client']['registrecommercef'] = "";
            }
            if (empty($this->request->data['Client']['patente']['name'])) {
                $this->request->data['Client']['patente'] = "";
            }
            if($client['Client']['modeclient_id']==2){
            if ($this->request->data['Client']['modeclient_id'] == 1) {
               $this->request->data['Client']['dateautorisation']=date("Y-m-d"); 
            }
            }
            
            
            if ($this->Client->save($this->request->data)) {
                $this->misejour("Client", "edit", $id);

                if (!empty($this->request->data['Contact'])) {
                    foreach ($this->request->data['Contact'] as $contact) {
                        if ($contact['sup'] != 1) {
                            if ($contact['name'] != "") {
                                $contact['client_id'] = $id;
                                $this->Contact->create();
                                $this->Contact->save($contact);
                            }
                        } else {
                            $this->Contact->deleteAll(array('Contact.id' => $contact['id']), false);
                        }
                    }
                }
                if($this->request->data['Client']['typeclient_id']==2){
                if (!empty($this->request->data['Exonorationtva'])) {
                    foreach ($this->request->data['Exonorationtva'] as $tva) {
                        if ($tva['sup'] != 1) {
                            if ($tva['numero'] != "") {
                                
                                $tva['client_id'] = $id;
                                $tva['num_exe'] = $tva['numero'];
                                $tva['datedu'] = date("Y-m-d", strtotime(str_replace('/', '-',$tva['datedebut'])));
                                $tva['dateau'] = date("Y-m-d", strtotime(str_replace('/', '-',$tva['datefin'])));
                                $this->Exonorationclient->create();
                                $this->Exonorationclient->save($tva);
                                //$this->loadModel('Bonlivraison');
                                //$this->loadModel('Factureclient');
                                //$this->Bonlivraison->updateAll(array('Bonlivraison.totalttc' =>'Bonlivraison.totalht','Bonlivraison.typeclient_id'=>2), array('Bonlivraison.client_id'=>$id,'Bonlivraison.date >='.'"'.$tva['datedu'].'"','Bonlivraison.date <='.'"'.$tva['dateau'].'"'));
                                //$this->Factureclient->updateAll(array('Factureclient.totalttc' =>'Factureclient.totalht+Factureclient.timbre_id','Factureclient.typeclient_id'=>2), array('Factureclient.client_id'=>$id,'Factureclient.date >='.'"'.$tva['datedu'].'"','Factureclient.date <='.'"'.$tva['dateau'].'"'));
                                
                                
                                
                                
                            }
                        }else {
                            $this->Exonorationclient->deleteAll(array('Exonorationclient.id' => $tva['id']), false);
                        }
                    }
                }}
                
                
                $this->Session->setFlash(__('The client has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The client could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Client.' . $this->Client->primaryKey => $id));
            $this->request->data = $this->Client->find('first', $options);
        }
        $etats = array();
        $etats[1] = "Actif";
        $etats[2] = "Non Actif";
        $pointdeventes = $this->Pointdevente->find('list');
        $contacts = $this->Contact->find('all', array('conditions' => array('Contact.client_id' => $id)));
        $exos = $this->Exonorationclient->find('all', array('conditions' => array('Exonorationclient.client_id' => $id)));
        $familleclients = $this->Client->Familleclient->find('list');
        $sousfamilleclients = $this->Client->Sousfamilleclient->find('list', array('conditions' => array('Sousfamilleclient.familleclient_id' => $familleclientid)));
        $zones = $this->Client->Zone->find('list');
        $personnels = $this->Client->Personnel->find('list');
        $typeclients = $this->Typeclient->find('list');
        $modeclients = array();
        $modeclients[1] = "Autoriser";
        $modeclients[2] = "Bloquer";
        $avectimbres = array();
        $avectimbres['Oui'] = "Oui";
        $avectimbres['Non'] = "Non";
        $this->set(compact('etats','avectimbres', 'pointdeventes','exos', 'modeclients', 'typeclients', 'ventes', 'personnels', 'familleclients', 'sousfamilleclients', 'zones', 'contacts'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_vente');
        $client = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'clients') {
                    $client = $liens['delete'];
                }
            }
        }
        if (( $client <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Contact');
        $this->Client->id = $id;
        if (!$this->Client->exists()) {
            throw new NotFoundException(__('Invalid client'));
        }
        $this->request->onlyAllow('post', 'delete');

        $this->Contact->deleteAll(array('Contact.client_id' => $id), false);
        $abcd = $this->Client->find('first', array('conditions' => array('Client.id' => $id), 'recursive' => -1));
        $numansar = $abcd['Client']['code'];
        $pvansar = $abcd['Client']['societe'];
        if ($this->Client->delete()) {
            $this->misejour("Client", $numansar, $id,$pvansar);
            $this->Session->setFlash(__('Client deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Client was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function getsousfamilleclient() {
        $this->layout = null;
        $this->loadModel('Sousfamilleclient');

        $data = $this->request->data;
        $familleclientid = $data['familleclientid'];

        $sousfamilleclients = $this->Sousfamilleclient->find('all', array('conditions' => array('Sousfamilleclient.familleclient_id' => $familleclientid), 'recursive' => -1));
        $select = "<select name='sousfamilleclient_id' champ='sousfamilleclient_id' id='sousfamilleclient_id' class='form-control  select ' onchange=''><option selected disabled hidden value=0> Veuillez choisir !!</option>";
        foreach ($sousfamilleclients as $v) {
            $select = $select . "<option value=" . $v['Sousfamilleclient']['id'] . ">" . $v['Sousfamilleclient']['name'] . "</option>";
        }
        $select = $select . '</select>';

        echo $select;
        die;
    }

    public function testecheance() {
        $this->layout = null;

        $data = $this->request->data;
        $client_id = $data['client_id'];
        $paiement_id = $data['paiement_id'];

        $client = $this->Client->find('first', array('conditions' => array('Client.id' => $client_id), 'recursive' => -1));
        if ($paiement_id == 2) {
            echo $client['Client']['chequejrs'];
        } else if ($paiement_id == 3) {
            echo $client['Client']['traitejrs'];
        }
        die;
    }

    public function rechercheclient() {

        $data = $this->request->data;
        $code = $data['val1'];
        $cond1 = 'Client.code = ' . "'" . $code . "'";
        $rechereclient = $this->Client->find('count', array('conditions' => array($cond1)));
        // debug($recherecheutilisateur);die;

        echo $rechereclient;
        die;
        // echo json_encode(array('rechclt'=>$recherecheclient));
        //$this->set(compact('utilisateurs','actionsrechereche','utilisateurid','date1','date2'));
    }

    public function getnumero($pointvente = null, $id = null) {
        $this->layout = null;

        $numero = $this->Client->find('all', array(
            'fields' => array('MAX(Client.code) as num'),
            'conditions' => array('Client.pointdevente_id' => $pointvente, 'Client.id !=' => $id)
                )
        );
//        debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        if (!empty($n)) {

            $lastnum = $n;
            $nume = intval($lastnum) + 1;
            $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
        } else {
            $mm = "000001";
        }

        echo json_encode(array('numero' => $mm));
        die();
    }
    
     public function checkmatricule() {
         $this->layout = null;
         
         $matriculefiscale = $this->request->data['matriculefiscale'];
         $clientid = $this->request->data['clientid'];
         $soc = CakeSession::read('composantsoc');
         
         $cond='';
         if(floatval($clientid) !=0){
             $cond='Client.id !='.$clientid;
         }

        $nb = $this->Client->find('count', array(
            'conditions' => array('Client.matriculefiscale' => $matriculefiscale, 'Client.societe ' => $soc,$cond)
                )
        );
        
        echo json_encode(array('nb' => $nb));
        die();
     }
     
     public function checktimbre($client_id=NULL) {
         $this->layout = null;
         
         //$client_id = $this->request->data['client_id'];
        

        $clt = $this->Client->find('first', array(
            'conditions' => array('Client.id' => $client_id),
            'fields'=>array('Client.avectimbre_id')
                ,'recursive'=>-1)
        );
        
        echo json_encode(array('clt' => $clt));
        die();
     }
     
     
     public function bloquerclients($val = null, $id = null) {
        $this->layout = null;
        $this->Client->updateAll(array(
        'Client.etat' =>$val), array('Client.id' => $id));
        die;
    }
    
    //auto complete Client
    public function listeclients() {
        $this->layout = null;
        $val = $this->request->data['val'];
        $composantsoc = CakeSession::read('composantsoc');
        $tab = explode('%', $val);
        $val_composer="";
        foreach ($tab as $tabb) {if($tabb !=""){$val_composer .= "%".addslashes($tabb);}}
        $clients = $this->Client->find('all', array(
        'conditions' => array("(Client.code LIKE  '" . $val_composer . "%' or Client.name LIKE '".$val_composer."%' )",
            'Client.societe'=>$composantsoc,'Client.etat' => 1),
        'recursive' => -1,
        'limit'=>100,
        'order'=>'cast((Client.code) as signed) Asc'
        ));
        echo json_encode(array('Clients' => $clients)); 
        die();
    }
    public function listematriculefiscaleclients() {
        $this->layout = null;
        $val = $this->request->data['val'];
        $composantsoc = CakeSession::read('composantsoc');
        $tab = explode('%', $val);
        $val_composer="";
        foreach ($tab as $tabb) {if($tabb !=""){$val_composer .= "%".addslashes($tabb);}}
        $clients = $this->Client->find('all', array(
        'conditions' => array('Client.matriculefiscale LIKE  "'.$val_composer.'%"',
        'Client.societe'=>$composantsoc,'Client.etat' => 1),
        'recursive' => -1,
        'limit'=>100,
        'order'=>'cast((Client.code) as signed) Asc'
        ));
        echo json_encode(array('Clients' => $clients)); 
        die();
    }

}
