<?php

App::uses('AppController', 'Controller');

/**
 * Utilisateurs Controller
 *
 * @property Utilisateur $Utilisateur
 */
class UtilisateursController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_parametrage');
        $utilisateur = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'utilisateurs') {
                    $utilisateur = 1;
                }
            }
        }
        if (( $utilisateur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->Utilisateur->recursive = 0;
        $this->set('utilisateurs', $this->paginate());
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_parametrage');
        $utilisateur = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'utilisateurs') {
                    $utilisateur = 1;
                }
            }
        }
        if (( $utilisateur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lien');
        $this->loadModel('Utilisateurmenu');
        if (!$this->Utilisateur->exists($id)) {
            throw new NotFoundException(__('Invalid utilisateur'));
        }
        $options = array('conditions' => array('Utilisateur.' . $this->Utilisateur->primaryKey => $id));
        $this->set('utilisateur', $this->Utilisateur->find('first', $options));
        $liens = $this->Utilisateurmenu->find('all', array(
            'conditions' => array('Utilisateurmenu.utilisateur_id' => $id)));
        $this->set(compact('liens'));
    }

    public function add() {

        $lien = CakeSession::read('lien_parametrage');
        $utilisateur = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'utilisateurs') {
                    $utilisateur = $liens['add'];
                }
            }
        }
        if (( $utilisateur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Pointdevente');
        $this->loadModel('Lien');
        $this->loadModel('Personnel');
        $this->loadModel('Utilisateurmenu');
        $this->loadModel('Societe');
        $caisses=array();
        $caisses['non']='non';
        $caisses['oui']='oui';
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            if ($this->request->data['poste'] == 0) {
                $this->request->data['Utilisateur']['pointdevente_id'] = 0;
                $this->request->data['Utilisateur']['depot_id'] = 0;
            }
            if ($this->request->data['stocknegatif'] == 1) {
                $this->request->data['Utilisateur']['stocknegatif'] = 1;
            }
            if ($this->request->data['blocageclient'] == 1) {
                $this->request->data['Utilisateur']['blocageclient'] = 1;
            }
            if ($this->request->data['Utilisateur']['societe_id'] != array()) {
                $this->request->data['Utilisateur']['societe_id'] = implode(",", $this->request->data['Utilisateur']['societe_id']);
            }
            if ($this->request->data['Utilisateur']['composantsoc'] == 1) {
                $this->request->data['Utilisateur']['composantsoc'] = "q";
            }
            if ($this->request->data['Utilisateur']['composantsoc'] == 2) {
                $this->request->data['Utilisateur']['composantsoc'] = "f";
            }
            $this->Utilisateur->create();
            if ($this->Utilisateur->save($this->request->data)) {
                $id = $this->Utilisateur->id;
                $this->misejour("Utilisateur", "add", $id);
                if (isset($this->request->data['acces']) && !empty($this->request->data['acces'])) {
                    // debug($this->request->data['acces']);die;
                    foreach ($this->request->data['acces'] as $ligne) {
                        $data = array();
                        $data['menu_id'] = $ligne;
                        $data['utilisateur_id'] = $id;
                        $this->Utilisateurmenu->create();
                        $this->Utilisateurmenu->save($data);
                        $idutili = $this->Utilisateurmenu->id;
                        if (isset($this->request->data[$ligne]['Lien']) && !empty($this->request->data[$ligne]['Lien'])) {
                            foreach ($this->request->data[$ligne]['Lien'] as $lig) {
                                if ((!empty($lig['add'])) || (!empty($lig['edit'])) || (!empty($lig['delete'])) || (!empty($lig['imprimer']))) {
                                    $lig['utilisateurmenu_id'] = $idutili;
                                    $this->Lien->create();
                                    $this->Lien->save($lig);
                                }
                            }
                        }
                    }
                }
                $this->Session->setFlash(__('The utilisateur has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The utilisateur could not be saved. Please, try again.'));
            }
            $this->Lien->create();
            $this->Utilisateur->save($this->request->data);
        }

        $personnels = $this->Personnel->find('list');
        $pointdeventes = $this->Pointdevente->find('list');
        $depots = $this->Depot->find('list');
        $composantsocs = $this->Societe->find('list');
        $this->set(compact('composantsocs','depots', 'personnels', 'pointdeventes','caisses'));
    }

    public function edit($id = null) {

        $lien = CakeSession::read('lien_parametrage');
        $utilisateur = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'utilisateurs') {
                    $utilisateur = $liens['edit'];
                }
            }
        }
        if (( $utilisateur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Pointdevente');
        $this->loadModel('Lien');
        $this->loadModel('Utilisateurmenu');
        $this->loadModel('Societe');
        $caisses=array();
        $caisses['non']='non';
        $caisses['oui']='oui';
        if (!$this->Utilisateur->exists($id)) {
            throw new NotFoundException(__('Invalid utilisateur'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);die;
            if ($this->request->data['stocknegatif'] == 1) {
                $this->request->data['Utilisateur']['stocknegatif'] = 1;
            } else {
                $this->request->data['Utilisateur']['stocknegatif'] = 0;
            }
            if ($this->request->data['blocageclient'] == 1) {
                $this->request->data['Utilisateur']['blocageclient'] = 1;
            } else {
                $this->request->data['Utilisateur']['blocageclient'] = 0;
            }
            if ($this->request->data['Utilisateur']['societe_id'] != array()) {
                $this->request->data['Utilisateur']['societe_id'] = implode(",", $this->request->data['Utilisateur']['societe_id']);
            }
            if ($this->request->data['Utilisateur']['composantsoc'] == 1) {
                $this->request->data['Utilisateur']['composantsoc'] = "q";
            }
            if ($this->request->data['Utilisateur']['composantsoc'] == 2) {
                $this->request->data['Utilisateur']['composantsoc'] = "f";
            }
            $req_utilisateur_menus = $this->Utilisateurmenu->find('all', array('conditions' => array('Utilisateurmenu.utilisateur_id' => $id)));
            foreach ($req_utilisateur_menus as $req_utilisateur_menu) {
                foreach ($req_utilisateur_menu['Lien'] as $lien) {
                    $this->Lien->deleteAll(array('Lien.id' => $lien['id']), false);
                }
            }

            $this->Utilisateurmenu->deleteAll(array('Utilisateurmenu.utilisateur_id' => $id), false);

            if (isset($this->request->data['acces']) && !empty($this->request->data['acces'])) {
                //$this->Utilisateurmenu->deleteAll(array('Utilisateurmenu.utilisateur_id'=>$id),false); 
                foreach ($this->request->data['acces'] as $ligne) {
                    //debug($ligne);die;
                    $data = array();
                    $data['menu_id'] = $ligne;
                    $data['utilisateur_id'] = $id;
                    $this->Utilisateurmenu->create();
                    $this->Utilisateurmenu->save($data);
                    $idutili = $this->Utilisateurmenu->id;
                    if (isset($this->request->data[$ligne]['Lien']) && !empty($this->request->data[$ligne]['Lien'])) {
                        foreach ($this->request->data[$ligne]['Lien'] as $lig) {
                            if ((!empty($lig['add'])) || (!empty($lig['edit'])) || (!empty($lig['delete'])) || (!empty($lig['imprimer']))) {
                                $lig['utilisateurmenu_id'] = $idutili;
                                $this->Lien->create();
                                $this->Lien->save($lig);
                            }
                        }
                    }
                }
            }




            if ($this->Utilisateur->save($this->request->data)) {
                $this->misejour("Utilisateur", "edit", $id);
                $this->Session->setFlash(__('The utilisateur has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The utilisateur could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Utilisateur.' . $this->Utilisateur->primaryKey => $id));
            $this->request->data = $this->Utilisateur->find('first', $options);
        }

        $this->loadModel('Societe');
        $this->loadModel('Personnel');
        $utilisateur = $this->Utilisateur->find('first', array('conditions' => array('Utilisateur.id' => $id)));
        $pers = $this->Personnel->find('first', array('conditions' => array('Personnel.id' => $utilisateur['Utilisateur']['personnel_id'])));
        $pointdeventetest = $utilisateur['Utilisateur']['pointdevente_id'];
        $stocknegatiftest = $utilisateur['Utilisateur']['stocknegatif'];
        $blocageclienttest = $utilisateur['Utilisateur']['blocageclient'];
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $pers['Personnel']['societe_id'])));
        $societes = $this->Societe->find('list');
        $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $pers['Personnel']['societe_id'])));
        $personnels = $this->Utilisateur->Personnel->find('list');
        $liens = $this->Utilisateurmenu->find('all', array(
            'conditions' => array('Utilisateurmenu.utilisateur_id' => $id)));
        //$li= $this->loadModel('Lien');
        // debug($li);die;
        $composantsocs = $this->Societe->find('list');
        $this->set(compact('blocageclienttest','composantsocs','societes','depots', 'menus', 'personnels', 'liens', 'pointdeventes', 'pointdeventetest', 'stocknegatiftest','caisses'));
    }

    public function delete($id = null) {

        $lien = CakeSession::read('lien_parametrage');
        $utilisateur = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'utilisateurs') {
                    $utilisateur = $liens['delete'];
                }
            }
        }
        if (( $utilisateur <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Lien');
        $this->loadModel('Utilisateurmenu');
        $this->Utilisateur->id = $id;
        if (!$this->Utilisateur->exists()) {
            throw new NotFoundException(__('Invalid utilisateur'));
        }
        $this->request->onlyAllow('post', 'delete');


        $req_utilisateur_menus = $this->Utilisateurmenu->find('all', array('conditions' => array('Utilisateurmenu.utilisateur_id' => $id)));
        foreach ($req_utilisateur_menus as $req_utilisateur_menu) {
            foreach ($req_utilisateur_menu['Lien'] as $lien) {
                $this->Lien->deleteAll(array('Lien.id' => $lien['id']), false);
            }
        }
        $this->Utilisateurmenu->deleteAll(array('Utilisateurmenu.utilisateur_id' => $id), false);

        if ($this->Utilisateur->delete()) {
            $this->misejour("Utilisateur", $id, $id);
            $this->Session->setFlash(__('Utilisateur deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Utilisateur was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function login($origin=null) {
        $this->loadModel('Societe');
        App::import('Model', 'Utilisateurmenu');
        $this->Utilisateurmenu = new Utilisateurmenu;
        CakeSession::delete('lien_achat');
        CakeSession::delete('lien_stock');
        CakeSession::delete('lien_parametrage');
        CakeSession::delete('lien_vente');
        CakeSession::delete('lien_finance');
        CakeSession::delete('lien_stat');
        CakeSession::delete('pointdevente');
        CakeSession::delete('depot');
        CakeSession::delete('users');
        CakeSession::delete('fonct_id');
        CakeSession::delete('stat');
        CakeSession::delete('achat');
        CakeSession::delete('stock');
        CakeSession::delete('parametrage');
        CakeSession::delete('vente');
        CakeSession::delete('finance');
        CakeSession::delete('soc');
        CakeSession::delete('blocageclient');
        CakeSession::delete('nomste');

        $this->layout = null;

        if ($this->request->is('post') || $this->request->is('put')) {

            $user = $this->request->data['login'];
            $password = $this->request->data['password'];
            $utilisateur = $this->Utilisateur->find('all', array('recursive' => 0, 'conditions' => array('Utilisateur.login' => $user, 'Utilisateur.password' => $password)));
            //debug($utilisateur);die;
            $poindevente = $utilisateur[0]['Utilisateur']['pointdevente_id'];
            $depot = $utilisateur[0]['Utilisateur']['depot_id'];
           
// debug($poindevente);die;
            $logo = $this->Societe->find('first', array('recursive' => 0, 'conditions' => array('Societe.id' => 1)));
            //debug($logo['Societe']['logo']);die;
            CakeSession::write('logo', $logo['Societe']['logo']);
            CakeSession::write('nomste', $logo['Societe']['nom']);
            CakeSession::write('soc', $utilisateur[0]['Utilisateur']['societe_id']);

            if ($utilisateur != array()) {
                $id = $utilisateur[0]['Utilisateur']['id'];
                $composantsoc = $utilisateur[0]['Utilisateur']['composantsoc'];
                $blocageclient = $utilisateur[0]['Utilisateur']['blocageclient'];
                CakeSession::write('users', $id);
                CakeSession::write('pointdevente', $poindevente);
                CakeSession::write('composantsoc', $composantsoc);
                CakeSession::write('blocageclient', $blocageclient);
                 //if(!empty($utilisateur[0]['Personnel']['societe_id'])){
                 CakeSession::write('societe', $depot);
                // }else{
                // CakeSession::write('societe',0);    
                // }
                $utilisateurmenu = $this->Utilisateurmenu->find('all', array('recursive' => 1, 'conditions' => array('Utilisateurmenu.utilisateur_id' => $id)));
                //debug($utilisateurmenu);die; 
                $var = '';
                foreach ($utilisateurmenu as $utili) {
                    //debug($utili);die;
                    $idu = $utili['Utilisateurmenu']['id'];
                    if ($utili['Utilisateurmenu']['menu_id'] == 1) {
                        $var = 'stock';
                        CakeSession::write('stock', 'stk');
                        CakeSession::write('lien_stock', $utili['Lien']);
                        $menu1 = $utili['Lien'][0]['lien'];
                    }
                    if ($utili['Utilisateurmenu']['menu_id'] == 2) {
                        $var = 'parametrage';
                        CakeSession::write('parametrage', 'par');
                        CakeSession::write('lien_parametrage', $utili['Lien']);
                        $menu2 = $utili['Lien'][0]['lien'];
                    }
                    if ($utili['Utilisateurmenu']['menu_id'] == 3) {
                        $var = 'achat';
                        CakeSession::write('achat', 'ach');
                        CakeSession::write('lien_achat', $utili['Lien']);
                        $menu3 = $utili['Lien'][0]['lien'];
                    }
                    if ($utili['Utilisateurmenu']['menu_id'] == 4) {
                        $var = 'vente';
                        CakeSession::write('vente', 'vnt');
                        CakeSession::write('lien_vente', $utili['Lien']);
                        $menu4 = @$utili['Lien'][0]['lien'];
                    }
                    if ($utili['Utilisateurmenu']['menu_id'] == 5) {//debug($utili);die;
                        $var = 'finance';
                        CakeSession::write('finance', 'fnc');
                        CakeSession::write('lien_finance', $utili['Lien']);
                        $menu5 = @$utili['Lien'][0]['lien'];
                    }
                    if ($utili['Utilisateurmenu']['menu_id'] == 6) {//debug($utili);die;
                        $var = 'stat';
                        CakeSession::write('stat', 'stat');
                        CakeSession::write('lien_stat', $utili['Lien']);
                        $menu6 = @$utili['Lien'][0]['lien'];
                    }
                }
                CakeSession::write('defaultmenu', $var);
//    if($var=='stock'){
//    $this->redirect(array('controller'=>$menu1,'action' => 'index'));}
//    elseif($var=='parametrage'){
//    $this->redirect(array('controller'=>$menu2,'action' => 'index'));}
//    elseif($var=='achat'){
//    $this->redirect(array('controller'=>$menu3,'action' => 'index'));}
//     elseif($var=='vente'){
//    $this->redirect(array('controller'=>$menu4,'action' => 'index'));}
//     elseif($var=='finance'){
//    $this->redirect(array('controller'=>$menu5,'action' => 'index'));}
//     elseif($var=='stat'){
//    $this->redirect(array('controller'=>$menu6,'action' => 'index'));}


            if($origin==1){
            ?>    
            <script language='javascript'>
            input= window.opener.document.getElementById("testmsglogin").value="0";    
            window.close(); 
            </script>
            <?php }else{
                $this->redirect(array('controller' => 'accueils', 'action' => 'index'));
            }
            } else {
                CakeSession::delete('lien_achat');
                CakeSession::delete('lien_stock');
                CakeSession::delete('lien_parametrage');
                CakeSession::delete('lien_vente');
                CakeSession::delete('lien_finance');
                CakeSession::delete('lien_stat');
                CakeSession::delete('pointdevente');
                CakeSession::delete('depot');
                CakeSession::delete('users');
                CakeSession::delete('fonct_id');
                CakeSession::delete('stat');
                CakeSession::delete('achat');
                CakeSession::delete('stock');
                CakeSession::delete('parametrage');
                CakeSession::delete('vente');
                CakeSession::delete('finance');
                CakeSession::delete('soc');
                
            }
        }
    }

    public function testqtenegatif() {
        $this->layout = null;
        $this->loadModel('Client');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $data = $this->request->data; //debug($data);
        $json = null;
        $id = CakeSession::read('users');
        $utilisateur = $this->Utilisateur->find('first', array('conditions' => array('Utilisateur.id' => $id)));
        $stocknegatiftest = $utilisateur['Utilisateur']['stocknegatif'];
        echo json_encode(array('qtenegatif' => $stocknegatiftest));
        die();
    }

    public function rechercheutilisateur() {

        $data = $this->request->data;
        $login = $data['val1'];
        $cond1 = 'Utilisateur.login = ' . "'" . $login . "'";
        $recherecheutilisateur = $this->Utilisateur->find('count', array('conditions' => array($cond1)));
        // debug($recherecheutilisateur);die;

        echo $recherecheutilisateur;
        die;
        //echo json_encode(array('rechclt'=>$recherecheclient));
        //$this->set(compact('utilisateurs','actionsrechereche','utilisateurid','date1','date2'));
    }
    
    public function testlogin() {
        $this->layout = null;
        $json = null;
//        CakeSession::write('users',$this->params['user']);
//        CakeSession::write('pointdevente',$this->params['pointdevente']);
//        CakeSession::write('depot',$this->params['depot']);
//        CakeSession::write('stock',$this->params['stock']);
//        CakeSession::write('lien_stock',$this->params['lien_stock']);
//        CakeSession::write('parametrage',$this->params['parametrage']);
//        CakeSession::write('lien_parametrage',$this->params['lien_parametrage']);
//        CakeSession::write('achat',$this->params['achat']);
//        CakeSession::write('lien_achat',$this->params['lien_achat']);
//        CakeSession::write('vente',$this->params['vente']);
//        CakeSession::write('lien_vente',$this->params['lien_vente']);
//        CakeSession::write('finance',$this->params['finance']);
//        CakeSession::write('lien_finance',$this->params['lien_finance']);
//        CakeSession::write('stat',$this->params['stat']);
//        CakeSession::write('lien_stat',$this->params['lien_stat']);
//        CakeSession::write('defaultmenu',$this->params['defaultmenu']);
        $user=CakeSession::read('users');
        if(empty($user)){
        $user=0;    
        }
        echo json_encode(array('user' =>$user));
        die();
    }

}
