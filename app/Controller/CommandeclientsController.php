<?php

App::uses('AppController', 'Controller');

/**
 * Commandeclients Controller
 *
 * @property Commandeclient $Commandeclient
 */
class CommandeclientsController extends AppController {

    public function index($id=NUll) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandeclients') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $cond4 = 'Commandeclient.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Commandeclient.pointdevente_id = ' . $p;
        }
        $soc= CakeSession::read('soc');
         if($id){
          $cond8="Commandeclient.id=".$id;
         // debug($cond8);die;
        }
        $limit = 100;
        
        if ((isset($this->request->data) && !empty($this->request->data))||(( in_array(CakeSession::read('view'),Array("edit","view","delete")))&&(CakeSession::read('Controller') =="Commandeclients"))) {
            if ((isset($this->request->data) && !empty($this->request->data))||((! in_array(CakeSession::read('view'),Array("edit","view","delete"))))) {
            CakeSession::write('recherche',$this->request->data['Recherche']);
            }else{
            $this->request->data['Recherche']=CakeSession::read('recherche');    
            }
            // debug($this->request->data);die;
            
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $cond4 = 'Commandeclient.exercice_id =' . $exercices[$exerciceid];
            }
            if (($this->request->data['Recherche']['date1'] != "__/__/____")&&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $cond1 = 'Commandeclient.date >= ' . "'" . $date1 . "'";
                $cond4 = "";
               
            }
           
            if (($this->request->data['Recherche']['dateliv1'] != "__/__/____")&&(!empty($this->request->data['Recherche']['dateliv1']))) {
                $dateliv1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['dateliv1'])));
                $conddateliv1 = 'Commandeclient.dateliv >= ' . "'" . $dateliv1 . "'";
                $cond4 = "";
            }

            if (($this->request->data['Recherche']['date2'] != "__/__/____")&&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $cond2 = 'Commandeclient.date <= ' . "'" . $date2 . "'";
                $cond4 = "";
            }
            if (($this->request->data['Recherche']['dateliv2'] != "__/__/____")&&(!empty($this->request->data['Recherche']['dateliv2']))) {
                $dateliv2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['dateliv2'])));
                $conddateliv2 = 'Commandeclient.dateliv <= ' . "'" . $dateliv2 . "'";
                $cond4 = "";
            }

            if ($this->request->data['Recherche']['client_id']) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $cond3 = 'Commandeclient.client_id =' . $clientid;
            }
            
            $this->loadModel('Utilisateur');
            $this->loadModel('Pointdevente');
            $this->loadModel('Societe');
            $this->loadModel('Personnel');
                if ($this->request->data['Recherche']['societe_id']) {
                    $societe_id = $this->request->data['Recherche']['societe_id'];
                    $lespvs=$this->Pointdevente->find('all',array('conditions'=>array('Pointdevente.societe_id'=>$societe_id),'recursive'=>-1));
                    $ch_pv=0;
                    foreach ($lespvs as $lespv){
                        $ch_pv=$ch_pv.','.$lespv['Pointdevente']['id'];
                    }
                    $cond6 = 'Commandeclient.pointdevente_id in (' . $ch_pv.')';
                    $pointdeventes=$this->Pointdevente->find('list',array('conditions'=>array('Pointdevente.societe_id'=>$societe_id)));
                }
            
                
            if ($this->request->data['Recherche']['pointdevente_id']) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                    $cond7 = 'Commandeclient.pointdevente_id ='.$pointdevente_id;
            }
            $limit = 100000;
        }
       
        $commandeclients = $this->Commandeclient->find('all', array('conditions' => array('Commandeclient.id > ' => 0, $pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, @$conddateliv1, @$conddateliv2,@$cond8)
            , 'order' => array('Commandeclient.id' => 'desc'),
            'limit' => $limit
            ));

        $this->loadModel('Typedipliquation');
        $typedipliquations = $this->Typedipliquation->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.etat' => 1,'Client.societe'=>$composantsoc)
        ));
        $societes = $this->Societe->find('list',array('conditions'=>array('Societe.id in ('.$soc.')')));
        //debug($date1);
//        if($date1){
//        $this->request->data['Recherche']['date1']=date("d/m/Y", strtotime(str_replace('/', '-', $date1)));
//        }
//        if($date2){
//        $this->request->data['Recherche']['date2']=date("d/m/Y", strtotime(str_replace('/', '-', $date2)));
//        }
        //debug($date1);die;
        $this->set(compact('typedipliquations', 'pointdeventes','societes','pointdevente_id','societe_id', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'commandeclients'));
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandeclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Client');
        //debug($this->request->query);die;
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Commandeclient.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Commandeclient.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            $cond3 = 'Commandeclient.client_id =' . $clientid;
        }

        $bonlivraisons = $this->Commandeclient->find('all', array('conditions' => array('Commandeclient.id > ' => 0, @$cond1, @$cond2, @$cond3)));

        $this->set(compact('bonlivraisons', 'date1', 'date2', 'clientid'));
    }

    public function imprimer($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandeclients') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignecommandeclient');
        if (!$this->Commandeclient->exists($id)) {
            throw new NotFoundException(__('Invalid Commandeclient'));
        }
        $options = array('conditions' => array('Commandeclient.' . $this->Commandeclient->primaryKey => $id));
        $this->set('commandeclient', $this->Commandeclient->find('first', $options));
        $lignecommandeclients = $this->Lignecommandeclient->find('all', array(
            'conditions' => array('Lignecommandeclient.commandeclient_id' => $id)
            , 'order' => array('Lignecommandeclient.id' => 'ASC')
        ));
        $this->set(compact('lignecommandeclients'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandeclients') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignecommandeclient');
        if (!$this->Commandeclient->exists($id)) {
            throw new NotFoundException(__('Invalid commandeclient'));
        }
        $lignecommandeclients = $this->Lignecommandeclient->find('all', array(
            'conditions' => array('Lignecommandeclient.commandeclient_id' => $id)
        ));
        $options = array('conditions' => array('Commandeclient.' . $this->Commandeclient->primaryKey => $id));
        $this->set('commandeclient', $this->Commandeclient->find('first', $options));
        $this->set(compact('lignecommandeclients'));
    }

    public function add() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandeclients') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Timbre');
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        $this->loadModel('Lignecommandeclient');
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Commandeclient']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commandeclient']['date'])));
            $this->request->data['Commandeclient']['dateliv'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commandeclient']['dateliv'])));
            $this->request->data['Commandeclient']['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data['Commandeclient']['pointdevente_id'])) {
                $this->request->data['Commandeclient']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Commandeclient']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Commandeclient']['pointdevente_id'];
            }
            $numero = $this->Commandeclient->find('all', array('fields' => array('MAX(Commandeclient.numeroconca) as num'),
                'conditions' => array('Commandeclient.pointdevente_id' => $pv, 'Commandeclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//  $getexercice= $this->Commandeclient->find('first',array('conditions'=>array('Commandeclient.numeroconca'=>$n)));
//  $anne=$getexercice['Commandeclient']['exercice_id'];  
//       if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }  
            } else {
                $mm = "000001";
            }


            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");

            $this->request->data['Commandeclient']['numeroconca'] = $mm;
            $this->request->data['Commandeclient']['numero'] = $numspecial;
            if ($this->request->data['Commandeclient']['timbre_id'] == 0) {
                $this->request->data['Commandeclient']['timbre_id'] = 0;
            } else {
                $this->request->data['Commandeclient']['timbre_id'] = 1;
            }
            $this->Commandeclient->create();
            if ($this->Commandeclient->save($this->request->data)) {

                $commandeid = $this->Commandeclient->id;
                $this->misejour("Commandeclient", "add", $commandeid);
                foreach ($this->request->data['Lignecommande'] as $i => $lc) {
                    //debug($lc);die;
                    if ($lc['sup'] != 1) {
                        $Lignecommandeclients['commandeclient_id'] = $commandeid;
                        $Lignecommandeclients['article_id'] = $this->request->data['Lignecommande'][$i]['article_id'];
                        $Lignecommandeclients['quantite'] = $lc['quantite'];
                        $Lignecommandeclients['depot_id'] = $lc['depot_id'];
                        $Lignecommandeclients['remise'] = $lc['remise'];
                        $Lignecommandeclients['tva'] = $lc['tva'];
                        $Lignecommandeclients['prix'] = $lc['prixhtva'];
                        $Lignecommandeclients['prixnet'] = $lc['prixnet'];
                        $Lignecommandeclients['puttc'] = $lc['puttc'];
                        $Lignecommandeclients['totalhtans'] = $lc['totalhtans'];
                        $Lignecommandeclients['designation'] = $lc['designation'];
                        $Lignecommandeclients['totalht'] = $lc['totalht'];
                        $Lignecommandeclients['totalttc'] = $lc['totalttc'];
                        $this->Lignecommandeclient->create();
                        $this->Lignecommandeclient->save($Lignecommandeclients);
                    }
                }
                $this->Session->setFlash(__('The commandeclient has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The commandeclient could not be saved. Please, try again.'));
            }
        }
        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {
            $numero = $this->Commandeclient->find('all', array('fields' => array('MAX(Commandeclient.numeroconca) as num'),
                'conditions' => array('Commandeclient.pointdevente_id' => $pv, 'Commandeclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Commandeclient->find('first',array('conditions'=>array('Commandeclient.numeroconca'=>$n)));
//  $anne=$getexercice['Commandeclient']['exercice_id'];  
//  if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }  
            } else {
                $mm = "000001";
            }

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            $mm = 0;
        }
        //$articles = $this->Article->find('list', array('conditions' => array('Article.typeetatarticle_id' => 1), 'recursive' => -1));
        $clients = $this->Commandeclient->Client->find('list');
        $pointdeventes = $this->Pointdevente->find('list');
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.id' => $p)));
        }
        $timbre = $this->Timbre->find('list', array('fields' => array('Timbre.timbre')));

        $this->set(compact('depots', 'timbre', 'pointdeventes', 'clients', 'mm', 'articles', 'numspecial'));
    }

    public function add1() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandeclients') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        $this->loadModel('Lignecommandeclient');
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Commandeclient']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commandeclient']['date'])));
            $this->request->data['Commandeclient']['dateliv'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commandeclient']['dateliv'])));
            $this->request->data['Commandeclient']['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data['Commandeclient']['pointdevente_id'])) {
                $this->request->data['Commandeclient']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Commandeclient']['exercice_id'] = date("Y");
            $this->request->data['Commandeclient']['type'] = 1;

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Commandeclient']['pointdevente_id'];
            }
            $numero = $this->Commandeclient->find('all', array('fields' => array('MAX(Commandeclient.numeroconca) as num'),
                'conditions' => array('Commandeclient.pointdevente_id' => $pv, 'Commandeclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//  $getexercice= $this->Commandeclient->find('first',array('conditions'=>array('Commandeclient.numeroconca'=>$n)));
//  $anne=$getexercice['Commandeclient']['exercice_id'];  
//       if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }  
            } else {
                $mm = "000001";
            }


            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");

            $this->request->data['Commandeclient']['numeroconca'] = $mm;
            $this->request->data['Commandeclient']['numero'] = $numspecial;

            $this->Commandeclient->create();
            if ($this->Commandeclient->save($this->request->data)) {

                $commandeid = $this->Commandeclient->id;
                $this->misejour("Commandeclient", "add", $commandeid);
                foreach ($this->request->data['Lignecommande'] as $i => $lc) {
                    //debug($lc);die;
                    if ($lc['sup'] != 1) {
                        $Lignecommandeclients['commandeclient_id'] = $commandeid;
                        $Lignecommandeclients['article_id'] = $this->request->data['Lignecommande'][$i]['article_id'];
                        $Lignecommandeclients['quantite'] = $lc['quantite'];
                        //$Lignecommandeclients['depot_id']=$lc['depot_id'];
                        $Lignecommandeclients['remise'] = $lc['remise'];
                        $Lignecommandeclients['tva'] = $lc['tva'];
                        $Lignecommandeclients['prix'] = $lc['prixhtva'];
                        $Lignecommandeclients['prixnet'] = $lc['prixnet'];
                        $Lignecommandeclients['puttc'] = $lc['puttc'];
                        $Lignecommandeclients['totalhtans'] = $lc['totalhtans'];
                        $Lignecommandeclients['designation'] = $lc['designation'];
                        $Lignecommandeclients['totalht'] = $lc['totalht'];
                        $Lignecommandeclients['totalttc'] = $lc['totalttc'];
                        $this->Lignecommandeclient->create();
                        $this->Lignecommandeclient->save($Lignecommandeclients);
                    }
                }
                $this->Session->setFlash(__('The commandeclient has been saved'));
                $this->redirect(array('action' => 'index/'.$commandeid));
            } else {
                $this->Session->setFlash(__('The commandeclient could not be saved. Please, try again.'));
            }
        }
        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {
            $numero = $this->Commandeclient->find('all', array('fields' => array('MAX(Commandeclient.numeroconca) as num'),
                'conditions' => array('Commandeclient.pointdevente_id' => $pv, 'Commandeclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Commandeclient->find('first',array('conditions'=>array('Commandeclient.numeroconca'=>$n)));
//  $anne=$getexercice['Commandeclient']['exercice_id'];  
//  if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }  
            } else {
                $mm = "000001";
            }

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            $mm = 0;
        }
        //$articles = $this->Article->find('list', array('conditions' => array('Article.typeetatarticle_id' => 1), 'recursive' => -1));
        $clients = $this->Commandeclient->Client->find('list');
        $pointdeventes = $this->Pointdevente->find('list');
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.id' => $p)));
        }
        $this->set(compact('depots', 'pointdeventes', 'clients', 'mm', 'articles', 'numspecial'));
    }

    //jeya mel devis
    public function addcommindirect($tab = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandeclients') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        $this->loadModel('Timbre');
        $this->loadModel('Lignecommandeclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignedevi');
        $this->loadModel('Devi');
        $this->loadModel('Client');
        $this->loadModel('Reglementclient');

        $tbr = $tab . ',0)';
        list($idbr, $resteidbr) = explode(",", $tbr);
        $tbr = '(0,' . $tbr;
        // debug($idbr);die;
        $idlcs = array();
        $idlcs = explode(",", $tab);
        $clientid = $this->Devi->find('first', array('fields' => array('pointdevente_id', 'SUM(Devi.remise) remise', 'SUM(Devi.tva) tva', 'SUM(Devi.totalht) totalht'
                , 'SUM(Devi.totalttc) totalttc', 'AVG(Devi.client_id) client_id'), 'conditions' => array('Devi.id' => $idlcs), 'recursive' => -2));
        //debug($clientid);die;
        $lignelivraisons = $this->Lignedevi->find('all', array('fields' => array('AVG(Lignedevi.article_id) article_id', 'AVG(Lignedevi.depot_id) depot_id', '(Lignedevi.article_id) article_iddd', '(Lignedevi.depot_id) depot_id'
                , 'SUM(Lignedevi.quantite) quantite', 'SUM(Lignedevi.remise*Lignedevi.quantite) remise', 'SUM(Lignedevi.prix*Lignedevi.quantite) prix'
                , 'AVG(Lignedevi.tva) tva', 'SUM(Lignedevi.totalht) totalht', 'SUM(Lignedevi.totalttc) totalttc', 'SUM(Lignedevi.prixnet*Lignedevi.quantite) prixnet', 'SUM(Lignedevi.puttc*Lignedevi.quantite) puttc')
            , 'conditions' => array('Lignedevi.devi_id in' . $tbr), 'recursive' => -2
            , 'group' => array('Lignedevi.article_id', 'Lignedevi.depot_id')));
        //debug($clientid);debug($lignelivraisons);die;

        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Commandeclient']['dateliv'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commandeclient']['dateliv'])));
            $this->request->data['Commandeclient']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commandeclient']['date'])));
            $this->request->data['Commandeclient']['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data['Commandeclient']['pointdevente_id'])) {
                $this->request->data['Commandeclient']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Commandeclient']['exercice_id'] = date("Y");
            if ($this->request->data['Commandeclient']['timbre_id'] == 0) {
                $this->request->data['Commandeclient']['timbre_id'] = 0;
            } else {
                $this->request->data['Commandeclient']['timbre_id'] = 1;
            }
            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Commandeclient']['pointdevente_id'];
            }
            $numero = $this->Commandeclient->find('all', array('fields' => array('MAX(Commandeclient.numeroconca) as num'),
                'conditions' => array('Commandeclient.pointdevente_id' => $pv, 'Commandeclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Commandeclient->find('first',array('conditions'=>array('Commandeclient.numeroconca'=>$n)));
//  $anne=$getexercice['Commandeclient']['exercice_id'];  
//       if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }  
//            
            } else {
                $mm = "000001";
            }
            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");

            $this->request->data['Commandeclient']['numeroconca'] = $mm;
            $this->request->data['Commandeclient']['numero'] = $numspecial;

            $this->Commandeclient->create();
            if ($this->Commandeclient->save($this->request->data)) {
                foreach ($idlcs as $idc) {
                    $this->Devi->updateAll(array('Devi.etat' => 1), array('Devi.id' => $idc));
                }
                $commandeid = $this->Commandeclient->id;
                $this->misejour("Commandeclient","add",$commandeid);
                foreach ($this->request->data['Lignecommandeclient'] as $i => $lc) {
                    //  debug($lc);die;
                    if ($lc['sup'] != 1) {
                        if (empty($lc['article_id'])) {
                            $lc['article_id'] = $this->request->data['Lignelivraison'][$i]['article_id'];
                        }
                        $Lignecommandeclients['commandeclient_id'] = $commandeid;
                        $Lignecommandeclients['article_id'] = $lc['article_id'];
                        $Lignecommandeclients['depot_id'] = $lc['depot_id'];
                        $Lignecommandeclients['quantite'] = $lc['quantite'];
                        $Lignecommandeclients['remise'] = $lc['remise'];
                        $Lignecommandeclients['tva'] = $lc['tva'];
                        $Lignecommandeclients['prix'] = $lc['prixhtva'];
                        $Lignecommandeclients['prixnet'] = $lc['prixnet'];
                        $Lignecommandeclients['puttc'] = $lc['puttc'];
                        $Lignecommandeclients['totalhtans'] = $lc['totalhtans'];
                        $Lignecommandeclients['totalht'] = ($lc['prixhtva'] * (1 - $lc['remise'] * 0.01)) * $lc['quantite'];
                        $Lignecommandeclients['totalttc'] = ((($Lignecommandeclients['totalht'])) * (1 + ($lc['tva'] * 0.01)));
                        $this->Lignecommandeclient->create();
                        $this->Lignecommandeclient->save($Lignecommandeclients);
                    }
                }
                $this->Session->setFlash(__('The commandeclient has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The commandeclient could not be saved. Please, try again.'));
            }
        }
        $pv = CakeSession::read('pointdevente');
        if ($pv == 0) {
            $pv = $clientid['Devi']['pointdevente_id'];
        }
        $numero = $this->Commandeclient->find('all', array('fields' => array('MAX(Commandeclient.numeroconca) as num'),
            'conditions' => array('Commandeclient.pointdevente_id' => $pv, 'Commandeclient.exercice_id' => date("Y")))
        );
        //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        if (!empty($n)) {
//   $getexercice= $this->Commandeclient->find('first',array('conditions'=>array('Commandeclient.numeroconca'=>$n)));
//  $anne=$getexercice['Commandeclient']['exercice_id'];  
//  if ($anne==date("Y")){
            $lastnum = $n;
            $nume = intval($lastnum) + 1;
            $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }  
//            
        } else {
            $mm = "000001";
        }






        //**************************************trouver la liste des articles pour chaque depot *******************************************************
      /*  foreach ($lignelivraisons as $ll) {
            $artdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $ll[0]['depot_id']), 'recursive' => -1));
            $t = '(0';
            foreach ($artdepot as $ad) {
                if (!empty($ad['Stockdepot']['article_id'])) {
                    $t = $t . ',' . $ad['Stockdepot']['article_id'];
                }
            }
            $t = $t . ')';

            $articles = $this->Article->find('list', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
            $tabqtestock[$ll[0]['depot_id']]['articles'] = $articles;

            //**************************************trouver les qte en stock de chaque article pour chaque depot *******************************************************

            $artstocks = $this->Article->find('all', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
            //debug($artstocks);die;
            foreach ($artstocks as $i => $as) {
                $qtestock = 0;
                $stockdepots = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $as['Article']['id'],
                        'Stockdepot.depot_id' => $ll[0]['depot_id']), false));
                foreach ($stockdepots as $stkdepot) {
                    $qtestock = $qtestock + $stkdepot['Stockdepot']['quantite'];
                }
                $tabqtestock[$ll[0]['depot_id']][$as['Article']['id']]['qtestock'] = $qtestock;
            }
        }*/

        //******************************************fin***********************************************************************************************************          
        // debug($tabqtestock);die;
        //debug($tabqtestock['1.0000'][1]['qtestock']);die;




        $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
        $abrivation = $pointvente['Pointdevente']['abriviation'];
        $numspecial = $abrivation . "/" . $mm . "/" . date("Y");

        $pntv = $clientid['Devi']['pointdevente_id'];
        $clients = $this->Commandeclient->Client->find('list');
        $pointdeventes = $this->Pointdevente->find('list');

        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Client');


        $client = $this->Client->find('all', array('conditions' => array('Client.id' => $clientid[0]['client_id']), false));
        $adresse = $client[0]['Client']['adresse'];
        $name = $client[0]['Client']['name'];
        $matriculefiscale = $client[0]['Client']['matriculefiscale'];
        $autorisation = $client[0]['Client']['autorisation'];
        $typeclient_id = $client[0]['Client']['typeclient_id'];

        $SUMttc = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.totalttc) as totalttcb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid[0]['client_id'])));
        $SUMmtreg = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.Montant_Regler) as totalregb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid[0]['client_id'])));
        $SUMttcf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.totalttc) as totalttf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid[0]['client_id'])));
        $SUMmtregf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.Montant_Regler) as totalregf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid[0]['client_id'])));
        $reglementlibre = $this->Reglementclient->find('all', array('fields' => array('sum(Reglementclient.Montant) as reglibretotale')
            , 'conditions' => array('Reglementclient.type' => 1, 'Reglementclient.affectation_id' => 0, 'Reglementclient.client_id' => $clientid[0]['client_id'])));
        $valbl = $SUMttc[0][0]['totalttcb'] - $SUMmtreg[0][0]['totalregb'];
        $valfac = $SUMttcf[0][0]['totalttf'] - $SUMmtregf[0][0]['totalregf'];
        $valglobal = $valbl + $valfac;
        $solde = $valglobal - $reglementlibre[0][0]['reglibretotale'];
        $valreste = $autorisation - ($valglobal - $reglementlibre[0][0]['reglibretotale']);
        //fin info client************************************************
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Factureclient->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Factureclient->Depot->find('list', array('conditions' => array('Depot.id' => $p)));
        }
        //$articles = $this->Article->find('list', array('conditions' => array('Article.typeetatarticle_id' => 1), 'recursive' => -1));
        $timbre = $this->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $this->set(compact('typeclient_id', 'timbre', 'name', 'autorisation', 'solde', 'tabqtestock', 'articles', 'depots', 'valreste', 'matriculefiscale', 'adresse', 'lignelivraisons', 'clientid', 'pointdeventes', 'pntv', 'clients', 'mm', 'articles', 'lignelivraisons', 'numspecial'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandeclients') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Factureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepot');
        $this->loadModel('Commande');
        $this->loadModel('Pointdevente');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Article');
        $this->loadModel('Lignecommandeclient');
        $this->loadModel('Reglementclient');
        $this->loadModel('Timbre');

        if (!$this->Commandeclient->exists($id)) {
            throw new NotFoundException(__('Invalid commandeclient'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);die;
            $this->request->data['Commandeclient']['dateliv'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commandeclient']['dateliv'])));
            $this->request->data['Commandeclient']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commandeclient']['date'])));
            $numeros = explode('/', $this->request->data['Commandeclient']['numero']);
            $this->request->data['Commandeclient']['numeroconca'] = $numeros[1];
            if ($this->request->data['Commandeclient']['timbre_id'] == 0) {
                $this->request->data['Commandeclient']['timbre_id'] = 0;
            } else {
                $this->request->data['Commandeclient']['timbre_id'] = 1;
            }
            if ($this->Commandeclient->save($this->request->data)) {
                $this->misejour("Commandeclient", "edit", $id);
                $this->Lignecommandeclient->deleteAll(array('Lignecommandeclient.Commandeclient_id' => $id), false);
                foreach ($this->request->data['Lignecommandeclient'] as $lc) {
                    //debug($lc);die;
                    if ($lc['sup'] != 1) {
                        $Lignecommandeclients['commandeclient_id'] = $id;
                        $Lignecommandeclients['depot_id'] = $lc['depot_id'];
                        $Lignecommandeclients['article_id'] = $lc['article_id'];
                        $Lignecommandeclients['quantite'] = $lc['quantite'];
                        $Lignecommandeclients['remise'] = $lc['remise'];
                        $Lignecommandeclients['tva'] = $lc['tva'];
                        $Lignecommandeclients['prix'] = $lc['prixhtva'];
                        $Lignecommandeclients['prixnet'] = $lc['prixnet'];
                        $Lignecommandeclients['puttc'] = $lc['puttc'];
                        $Lignecommandeclients['totalhtans'] = $lc['totalhtans'];
                        $Lignecommandeclients['designation'] = $lc['designation'];
                        $Lignecommandeclients['totalht'] = $lc['totalht'];
                        $Lignecommandeclients['totalttc'] = $lc['totalttc'];
                        $this->Lignecommandeclient->create();
                        $this->Lignecommandeclient->save($Lignecommandeclients);
                    }
                }
                $this->Session->setFlash(__('The commandeclient has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The commandeclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Commandeclient.' . $this->Commandeclient->primaryKey => $id));
            $this->request->data = $this->Commandeclient->find('first', $options);
        }
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Commandeclient']['date'])));
        $dateliv = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Commandeclient']['dateliv'])));
        $lignecommandeclients = $this->Lignecommandeclient->find('all', array(
            'conditions' => array('Lignecommandeclient.commandeclient_id' => $id)
            , 'order' => array('Lignecommandeclient.id' => 'ASC')
        ));

        $clients = $this->Commandeclient->Client->find('list');
        $this->loadModel('Pointdevente');
        $pointdeventes = $this->Pointdevente->find('list');


       /* foreach ($lignecommandeclients as $ll) {
            //**************************************trouver la liste des articles pour chaque depot *******************************************************

            $artdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $ll['Depot']['id']), 'recursive' => -1));
            // debug($artdepot);
            $t = '(0';
            foreach ($artdepot as $ad) {
                if (!empty($ad['Stockdepot']['article_id'])) {
                    $t = $t . ',' . $ad['Stockdepot']['article_id'];
                }
            }
            $t = $t . ')';

            $articles = $this->Article->find('list', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
            $tabqtestock[$ll['Depot']['id']]['articles'] = $articles;

            //**************************************trouver les qte en stock de chaque article pour chaque depot *******************************************************

            $artstocks = $this->Article->find('all', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
            //debug($artstocks);die;
            foreach ($artstocks as $i => $as) {
                $qtestock = 0;
                $stockdepots = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $as['Article']['id'],
                        'Stockdepot.depot_id' => $ll['Depot']['id']), false));
                foreach ($stockdepots as $stkdepot) {
                    $qtestock = $qtestock + $stkdepot['Stockdepot']['quantite'];
                }
                $tabqtestock[$ll['Depot']['id']][$as['Article']['id']]['qtestock'] = $qtestock;
            }
        }*/
        // debug($tabqtestock);die;
        //info client**************************************************
        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Client');

        $facture = $this->Commandeclient->find('first', array('conditions' => array('Commandeclient.id' => $id), false));
        $clientid = $facture['Commandeclient']['client_id'];
        $cname = $facture['Commandeclient']['name'];
        $client = $this->Client->find('all', array('conditions' => array('Client.id' => $clientid), false));
        $adresse = $client[0]['Client']['adresse'];
        $matriculefiscale = $client[0]['Client']['matriculefiscale'];
        $autorisation = $client[0]['Client']['autorisation'];
        $typeclient_id = $client[0]['Client']['typeclient_id'];

        $sumttc = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.totalttc) as totalttcb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid)));
        $summtreg = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.Montant_Regler) as totalregb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid)));
        $sumttcf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.totalttc) as totalttf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid)));
        $summtregf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.Montant_Regler) as totalregf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid)));
        $reglementlibre = $this->Reglementclient->find('all', array('fields' => array('sum(Reglementclient.Montant) as reglibretotale')
            , 'conditions' => array('Reglementclient.type > ' => 1, 'Reglementclient.affectation_id > ' => 0, 'Reglementclient.client_id' => $clientid)));
        $valbl = $sumttc[0][0]['totalttcb'] - $summtreg[0][0]['totalregb'];
        $valfac = $sumttcf[0][0]['totalttf'] - $summtregf[0][0]['totalregf'];
        $valglobal = $valbl + $valfac;
        $solde = $valglobal - $reglementlibre[0][0]['reglibretotale'];
        $valreste = $autorisation - ($valglobal - $reglementlibre[0][0]['reglibretotale']);
        //fin info client************************************************
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Factureclient->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Factureclient->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.id' => $p)));
        }
        $timbre = $this->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        //$articles = $this->Article->find('list');
        $this->set(compact('typeclient_id', 'timbre', 'name', 'autorisation', 'solde', 'tabqtestock', 'depots', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'clients', 'lignecommandeclients', 'articles', 'date', 'dateliv'));
    }

    public function edit1($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandeclients') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Factureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepot');
        $this->loadModel('Commande');
        $this->loadModel('Pointdevente');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Article');
        $this->loadModel('Lignecommandeclient');
        $this->loadModel('Reglementclient');

        if (!$this->Commandeclient->exists($id)) {
            throw new NotFoundException(__('Invalid commandeclient'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);die;
            $this->request->data['Commandeclient']['dateliv'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commandeclient']['dateliv'])));
            $this->request->data['Commandeclient']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Commandeclient']['date'])));
            $numeros = explode('/', $this->request->data['Commandeclient']['numero']);
            $this->request->data['Commandeclient']['numeroconca'] = $numeros[1];
            $this->request->data['Commandeclient']['type'] = 1;
            if ($this->Commandeclient->save($this->request->data)) {
              $this->misejour("Commandeclient","edit",$id);
                $this->Lignecommandeclient->deleteAll(array('Lignecommandeclient.Commandeclient_id' => $id), false);
                foreach ($this->request->data['Lignecommandeclient'] as $lc) {
                    //debug($lc);die;
                    if ($lc['sup'] != 1) {
                        $Lignecommandeclients['commandeclient_id'] = $id;
                        //$Lignecommandeclients['depot_id']=$lc['depot_id'];
                        $Lignecommandeclients['article_id'] = $lc['article_id'];
                        $Lignecommandeclients['quantite'] = $lc['quantite'];
                        $Lignecommandeclients['remise'] = $lc['remise'];
                        $Lignecommandeclients['tva'] = $lc['tva'];
                        $Lignecommandeclients['prix'] = $lc['prixhtva'];
                        $Lignecommandeclients['prixnet'] = $lc['prixnet'];
                        $Lignecommandeclients['puttc'] = $lc['puttc'];
                        $Lignecommandeclients['totalhtans'] = $lc['totalhtans'];
                        $Lignecommandeclients['designation'] = $lc['designation'];
                        $Lignecommandeclients['totalht'] = $lc['totalht'];
                        $Lignecommandeclients['totalttc'] = $lc['totalttc'];
                        $this->Lignecommandeclient->create();
                        $this->Lignecommandeclient->save($Lignecommandeclients);
                    }
                }
                $this->Session->setFlash(__('The commandeclient has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The commandeclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Commandeclient.' . $this->Commandeclient->primaryKey => $id));
            $this->request->data = $this->Commandeclient->find('first', $options);
        }
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Commandeclient']['date'])));
        $dateliv = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Commandeclient']['dateliv'])));
        $lignecommandeclients = $this->Lignecommandeclient->find('all', array(
            'conditions' => array('Lignecommandeclient.commandeclient_id' => $id)
            , 'order' => array('Lignecommandeclient.id' => 'ASC')
        ));

        $clients = $this->Commandeclient->Client->find('list');
        $this->loadModel('Pointdevente');
        $pointdeventes = $this->Pointdevente->find('list');
        foreach ($lignecommandeclients as $ll) {
            //**************************************trouver la liste des articles pour chaque depot *******************************************************

            $artdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $ll['Depot']['id']), 'recursive' => -1));
            // debug($artdepot);
            $t = '(0';
            foreach ($artdepot as $ad) {
                if (!empty($ad['Stockdepot']['article_id'])) {
                    $t = $t . ',' . $ad['Stockdepot']['article_id'];
                }
            }
            $t = $t . ')';

            $articles = $this->Article->find('list', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
            $tabqtestock[$ll['Depot']['id']]['articles'] = $articles;

            //**************************************trouver les qte en stock de chaque article pour chaque depot *******************************************************

            $artstocks = $this->Article->find('all', array('conditions' => array('Article.id in' . $t), 'recursive' => -1));
            //debug($artstocks);die;
            foreach ($artstocks as $i => $as) {
                $qtestock = 0;
                $stockdepots = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $as['Article']['id'],
                        'Stockdepot.depot_id' => $ll['Depot']['id']), false));
                foreach ($stockdepots as $stkdepot) {
                    $qtestock = $qtestock + $stkdepot['Stockdepot']['quantite'];
                }
                $tabqtestock[$ll['Depot']['id']][$as['Article']['id']]['qtestock'] = $qtestock;
            }
        }
        // debug($tabqtestock);die;
        //info client**************************************************
        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Client');

        $facture = $this->Commandeclient->find('first', array('conditions' => array('Commandeclient.id' => $id), false));
        $clientid = $facture['Commandeclient']['client_id'];
        $cname = $facture['Commandeclient']['name'];
        $client = $this->Client->find('all', array('conditions' => array('Client.id' => $clientid), false));
        $adresse = $client[0]['Client']['adresse'];
        $matriculefiscale = $client[0]['Client']['matriculefiscale'];
        $autorisation = $client[0]['Client']['autorisation'];
        $typeclient_id = $client[0]['Client']['typeclient_id'];

        $sumttc = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.totalttc) as totalttcb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid)));
        $summtreg = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.Montant_Regler) as totalregb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid)));
        $sumttcf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.totalttc) as totalttf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid)));
        $summtregf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.Montant_Regler) as totalregf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid)));
        $reglementlibre = $this->Reglementclient->find('all', array('fields' => array('sum(Reglementclient.Montant) as reglibretotale')
            , 'conditions' => array('Reglementclient.type > ' => 1, 'Reglementclient.affectation_id > ' => 0, 'Reglementclient.client_id' => $clientid)));
        $valbl = $sumttc[0][0]['totalttcb'] - $summtreg[0][0]['totalregb'];
        $valfac = $sumttcf[0][0]['totalttf'] - $summtregf[0][0]['totalregf'];
        $valglobal = $valbl + $valfac;
        $solde = $valglobal - $reglementlibre[0][0]['reglibretotale'];
        $valreste = $autorisation - ($valglobal - $reglementlibre[0][0]['reglibretotale']);
        //fin info client************************************************
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Factureclient->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Factureclient->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.id' => $p)));
        }
        $articles = $this->Article->find('list');
        $this->set(compact('typeclient_id', 'name', 'autorisation', 'solde', 'tabqtestock', 'depots', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'clients', 'lignecommandeclients', 'articles', 'date', 'dateliv'));
    }

    public function delete($id = null,$redirection=null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'commandeclients') {
                    $x = $liens['delete'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignecommandeclient');
        $this->loadModel('Devi');
        $this->Commandeclient->id = $id;
        if (!$this->Commandeclient->exists()) {
            throw new NotFoundException(__('Invalid commandeclient'));
        }

        $this->Lignecommandeclient->deleteAll(array('Lignecommandeclient.Commandeclient_id' => $id), false);
        $abcd = $this->Commandeclient->find('first', array('conditions' => array('Commandeclient.id' => $id), 'recursive' => -1));
        $numansar=$abcd['Commandeclient']['numero'];
        $this->Devi->updateAll(array('Devi.Commandeclient_id' =>0), array('Devi.Commandeclient_id' =>$id));

        if ($this->Commandeclient->delete()) {
             $this->misejour("Commandeclient",$numansar,$id);
            //$this->Session->setFlash(__('Commandeclient deleted'));
            CakeSession::write('view',"delete");
            if($redirection!=1){
            $this->redirect(array('action' => 'index'));
            }
        }
        //$this->Session->setFlash(__('Commandeclient was not deleted'));
        //$this->redirect(array('action' => 'index'));
    }

}
