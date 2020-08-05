<?php

App::uses('AppController', 'Controller');

/**
 * Reglementclients Controller
 *
 * @property Reglementclient $Reglementclient
 */
class ReglementclientsController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Famille');
        $this->loadModel('Client');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Ligneclient');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $conde = 'Reglementclient.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Reglementclient.pointdevente_id = ' . $p;
        }
        $clients = $this->Client->find('list');
        $soc= CakeSession::read('soc');
       if ((isset($this->request->data) && !empty($this->request->data))||(( in_array(CakeSession::read('view'),Array("edit","view","delete")))&&(CakeSession::read('Controller') =="Reglementclients"))) {
            if ((isset($this->request->data) && !empty($this->request->data))||((! in_array(CakeSession::read('view'),Array("edit","view","delete"))))) {
            CakeSession::write('recherche',$this->request->data['Recherche']);
            }else{
            $this->request->data['Recherche']=CakeSession::read('recherche');    
            }
            if ($this->request->data['Recherche']['Date_debut'] != '__/__/____') {
                $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['Date_debut'])));
                $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
            }
            if ($this->request->data['Recherche']['Date_fin'] != '__/__/____') {
                $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['Date_fin'])));
                $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
            }

            if ($this->request->data['Recherche']['client_id']) {
                $client_id = $this->request->data['Recherche']['client_id'];
                $cond3 = 'Reglementclient.client_id=' . $client_id;
            }
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $cond4 = 'Reglementclient.exercice_id =' . $exercices[$exerciceid];
                $conde="";
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
                    $cond6 = 'Reglementclient.pointdevente_id in (' . $ch_pv.')';
                    $pointdeventes=$this->Pointdevente->find('list',array('conditions'=>array('Pointdevente.societe_id'=>$societe_id)));
                }
            
                
            if ($this->request->data['Recherche']['pointdevente_id']) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                    $cond7 = 'Reglementclient.pointdevente_id ='.$pointdevente_id;
            }
            
        }

        $reglementclients = $this->Reglementclient->find('all', array('conditions' => array('Reglementclient.id > ' => 0, @$pv, @$cond, @$conde, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6, @$cond7)));
         $societes = $this->Societe->find('list',array('conditions'=>array('Societe.id in ('.$soc.')')));
        $this->set(compact('pointdeventeid','societes','pointdeventes','pointdevente_id','societe_id','reglementclients', 'collections', 'transferecommandebls', 'marques', 'familles', 'clients', 'ligneclients', 'Date_debut', 'marque_id', 'Date_fin', 'client_id', 'exerciceid', 'num_recu', 'pointdeventes', 'exercices'));
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
//               $this->loadModel('Marque'); 
//              $this->loadModel('Famille'); 
        $this->loadModel('Client');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Ligneclient');
        // debug($this->request->query);die;
        $cond = '';
        $cond1 = '';
        $cond2 = '';
        $cond3 = '';
        $cond4 = '';
        $cond6 = '';
        $cond7 = '';
        if (!empty($this->request->query['Date_debut'])) {
            $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_debut'])));
            $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
        }
        if (!empty($this->request->query['Date_fin'])) {
            $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_fin'])));
            $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
        }

        if (!empty($this->request->query['client_id'])) {
            $client_id = $this->request->query['client_id'];
            $cond3 = 'Reglementclient.client_id=' . $client_id;
        }

        $this->loadModel('Utilisateur');
            $this->loadModel('Pointdevente');
            $this->loadModel('Societe');
            $this->loadModel('Personnel');
                if ($this->request->query['societe_id']) {
                    $societe_id = $this->request->query['societe_id'];
                    $lespvs=$this->Pointdevente->find('all',array('conditions'=>array('Pointdevente.societe_id'=>$societe_id),'recursive'=>-1));
                    $ch_pv=0;
                    foreach ($lespvs as $lespv){
                        $ch_pv=$ch_pv.','.$lespv['Pointdevente']['id'];
                    }
                    $cond6 = 'Reglementclient.pointdevente_id in (' . $ch_pv.')';
                }
            
            if ($this->request->query['pointdevente_id']) {
                $pointdevente_id=$this->request->query['pointdevente_id'];
                    $cond7= 'Reglementclient.pointdevente_id =' . $pointdevente_id ;
            }
        
        
        $this->Reglementclient->recursive = 2;
        $this->paginate = array(
            'order' => array('Reglementclient.id' => 'desc'),
            'conditions' => array($cond, $cond1, $cond2, $cond3, $cond4, $cond6, $cond7));
        $reglements = $this->paginate();


        $this->set(compact('reglements', 'collections', 'transferecommandebls', 'marques', 'familles', 'clients', 'ligneclients', 'marque_id', 'Date_debut', 'Date_fin', 'client_id', 'num_recu'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Piecereglementclient');
        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id), 'recursive' => 2);
        $reglement = $this->Reglementclient->find('first', $options);
        $pieceregement = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id)));
        // debug($pieceregement);die;
        $this->set(compact('reglement', 'pieceregement'));
    }

    public function imprimerview($id = null) {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Piecereglementclient');
        $this->loadModel('Lignereglementclient');

        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id), 'recursive' => 2);
        $reglement = $this->Reglementclient->find('first', $options);
        $pieceregement = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id)));

        $ligneregement = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id)));

        //debug($ligneregement);die;
        $this->set(compact('reglement', 'pieceregement', 'ligneregement','id'));
    }

    public function add($client_id = 0, $poinvente = 0) {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['add'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        //debug($client_id);   
        //debug($poinvente); 
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');

        if ($this->request->is('post')) {
          
            $client_id = $this->request->data['Reglementclient']['client_id'];
            $this->request->data['Reglementclient']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date'])));
            $this->request->data['Reglementclient']['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data['Reglementclient']['pointdevente_id'])) {
                $this->request->data['Reglementclient']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Reglementclient']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Reglementclient']['pointdevente_id'];
            }
            $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                'conditions' => array('Reglementclient.pointdevente_id' => $pv, 'Reglementclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
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


            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
            $this->request->data['Reglementclient']['numeroconca'] = $mm;
            $this->request->data['Reglementclient']['numero'] = $numspecial;

            //debug($this->request->data);die;
            $this->Reglementclient->create();
            if ($this->Reglementclient->save($this->request->data)) {
                $reg_id = $this->Reglementclient->id;
                $this->misejour("Reglementclient", "add", $reg_id);
                $mntt = $this->request->data['Reglementclient']['Montant'];
                $montantaffecter = 0;
                if(!empty($this->request->data['Lignereglement'])){
                foreach ($this->request->data['Lignereglement']as $j => $l) {
                    if ($mntt > 0 && array_key_exists('factureclient_id', $l)) {
                        $li['reglementclient_id'] = $reg_id;
                        //debug($l['bonlivraison_id']);
                        $li['factureclient_id'] = $l['factureclient_id'];
                        $id_fac = $l['factureclient_id'];
                        $li['Montant'] = $l['Montant'];
                        $montantaffecter = $montantaffecter + $l['Montant'];
                        $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler+' . $l['Montant']), array('Factureclient.id' => $id_fac));
                        $this->Lignereglementclient->create();
                        $this->Lignereglementclient->save($li);
                    }
                }}
                $li=array();
                if(!empty($this->request->data['Lignereglementimpaye'])){
                foreach ($this->request->data['Lignereglementimpaye']as $j => $l) {
                    if ($mntt > 0 && array_key_exists('piecereglementclient_id', $l)) {
                        $li['reglementclient_id'] = $reg_id;
                        $li['piecereglementclient_id'] = $l['piecereglementclient_id'];
                        $id_piece = $l['piecereglementclient_id'];
                        $li['Montant'] = $l['Montant'];
                        $montantaffecter = $montantaffecter + $l['Montant'];
                        $this->Piecereglementclient->updateAll(array('Piecereglementclient.reglement ' => $reg_id,'Piecereglementclient.mantantregler' => 'Piecereglementclient.mantantregler+' . $l['Montant']), array('Piecereglementclient.id' => $id_piece));
                        $this->Lignereglementclient->create();
                        $this->Lignereglementclient->save($li);
                    }
                }}
                $this->Reglementclient->updateAll(array('Reglementclient.montantaffecte' => $montantaffecter), array('Reglementclient.id' => $reg_id));
                
                foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                    // debug($l);
                    //  $li['client_id']=$client_id;                               

                    $lip['montant'] = $l['montant'];
//                                $li['num_recu']=$l['num_recu'];
                    $lip['paiement_id'] = $l['paiement_id'];
                    $lip['reglementclient_id'] = $reg_id;
                    $lip['echance'] = '';
                    $lip['num'] = '';
                    $lip['banque'] = '';
                    $lip['montant_brut'] = '';
                    $lip['montant_net'] = '';
                    $lip['to_id'] = '';
                    $lip['factureavoir_id'] = '';

                    if ($l['paiement_id'] != 1) {
                        $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                        $lip['num'] = $l['num_piece'];
                        $lip['banque'] = $l['banque'];
                    }
                    if ($l['paiement_id'] == 5) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['montant_brut'] = $l['montant_brut'];
                        $lip['montant_net'] = $l['montant_net'];
                        $lip['to_id'] = $l['taux'];
                    }
                    if ($l['paiement_id'] == 6) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['factureavoir_id'] = $l['favid'];

                        $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $l['favid']), false));
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 2), array('Factureavoir.id' => $l['favid']));
                        $lip['num'] = $factureavoir['Factureavoir']['numero'];
                    }
                    $this->Piecereglementclient->create();
                    $this->Piecereglementclient->save($lip);
//                                 $id_piece= $this->Piece->id;
//                                 $lip['piece_id']=$id_piece;
//                                 $lip['reglement_id']=$reg_id;
//                                  $this->Piecereglementclient->create();
//                                 // debug($lip);
//                                 $this->Piecereglement->save($lip);
                }
                $this->Session->setFlash(__('The reglement has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The reglement could not be saved. Please, try again.'));
            }
        }

        $valeurs = $this->To->find('list');
        $facture = array();
        $clients = $this->Reglementclient->Client->find('list',array(
            'conditions'=>array('Client.etat'=>1)
        ));
        
        $paiements = $this->Paiement->find('list'); //debug($paiements);die;
        if ($client_id) {
            $facture = $this->Factureclient->find('all', array('conditions' => array('Factureclient.client_id' => $client_id, 'Factureclient.totalttc>(Factureclient.Montant_Regler)'), 'recursive' => 0));
            $situat="Impaye";
            $impayes = $this->Piecereglementclient->find('all', array(
                'conditions' => array(
                    'Piecereglementclient.situation =' . "'" . $situat . "'", 'Piecereglementclient.montant>Piecereglementclient.mantantregler')
                , 'recursive' => 0));
        }


        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {
            $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                'conditions' => array('Reglementclient.pointdevente_id' => $pv, 'Reglementclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];  
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

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            if ($poinvente) {
                $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                    'conditions' => array('Reglementclient.pointdevente_id' => $poinvente, 'Reglementclient.exercice_id' => date("Y")))
                );
                //debug($numero);die;
                foreach ($numero as $num) {
                    $n = $num[0]['num'];
                }
                if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];  
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

                $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $poinvente)));
                $abrivation = $pointvente['Pointdevente']['abriviation'];
                $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
            } else {
                $mm = 0;
            }
        }
        $pointdeventes = $this->Pointdevente->find('list');
        //debug($this->request->data);
        $this->set(compact('impayes','poinvente', 'mm', 'numspecial', 'clients', 'client_id', 'facture', 'paiements', 'valeurs', 'pointdeventes'));
    }

    public function edit($id = null) {
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Pointdevente');
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['edit'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglementclient'));
        }
        $piecesregclient = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id), 'recursive' => 2));  //debug($piecesregclient);die;
        $retenue = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id, 'Piecereglementclient.paiement_id' => 5), 'recursive' => 2));  //debug($piecesreg);die;
        $totalfacture = 0;
        $lignesreg = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id)));
        foreach ($lignesreg as $k => $ligne) {
            if(empty($ligne['Lignereglementclient']['piecereglementclient_id'])){
            $facregclient[$ligne['Factureclient']['id']] = 1;
            $totalfacture = $totalfacture + $ligne['Factureclient']['totalttc'];
            }else{
            $totalfacture = $totalfacture + ($ligne['Piecereglementclient']['montant']-$ligne['Piecereglementclient']['mantantregler']);    
            }
        }
        $reglementclient = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id)));
        $client_id = $reglementclient['Reglementclient']['client_id'];


        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);die;
            $this->request->data['Reglementclient']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date'])));
            if ($this->Reglementclient->save($this->request->data)) {
                $this->misejour("Reglementclient", "edit", $id);
                foreach ($piecesregclient as $piece) {
                    if ($piece['Piecereglementclient']['paiement_id'] == 6) {
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 1), array('Factureavoir.id' => $piece['Piecereglementclient']['factureavoir_id']));
                    }
                }
                //.....................................effacer  piece reglementclient , ligne reglementclient , ..........................................................................
                //$this->Piecereglementclient->deleteAll(array('Piecereglementclient.reglementclient_id' => $id), false);
                //debug($lignesreg);die;
                foreach ($lignesreg as $k => $ligne) {
                    if(!empty($ligne['Lignereglementclient']['factureclient_id'])){
                    $this->Factureclient->updateAll(array('Factureclient.Montant_Regler' => 'Factureclient.Montant_Regler-' . $ligne['Lignereglementclient']['Montant'],
                            ), array('Factureclient.id' => $ligne['Lignereglementclient']['factureclient_id']));
                    }
                    if(!empty($ligne['Lignereglementclient']['piecereglementclient_id'])){
                    $this->Piecereglementclient->updateAll(array('Piecereglementclient.mantantregler' => 'Piecereglementclient.mantantregler-' . $ligne['Lignereglementclient']['Montant'],
                            ), array('Piecereglementclient.id' => $ligne['Lignereglementclient']['piecereglementclient_id']));
                    }
                }
                $this->Lignereglementclient->deleteAll(array('Lignereglementclient.reglementclient_id' => $id), false);
                //..............................fin effacer ligne reglementclient , piece reglementclient .............................................................................   

                $reg_id = $id;
                $mntt = $this->request->data['Reglementclient']['Montant'];
                //debug($mntt);
                $montantaffecter = 0;
                if(!empty($this->request->data['Lignereglement'])){
                foreach ($this->request->data['Lignereglement']as $j => $l) {
                    if ($mntt > 0 && array_key_exists('factureclient_id', $l)) {
                        $li['reglementclient_id'] = $reg_id;
                        $li['factureclient_id'] = $l['factureclient_id'];
                        $id_fac = $l['factureclient_id'];
                        $li['Montant'] = $l['Montant'];
                        $montantaffecter = $montantaffecter + $l['Montant'];
                        $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler+' . $l['Montant']), array('Factureclient.id' => $id_fac));
                        $this->Lignereglementclient->create();
                        $this->Lignereglementclient->save($li);
                    }
                }}
                $li=array();
                if(!empty($this->request->data['Lignereglementimpaye'])){
                foreach ($this->request->data['Lignereglementimpaye']as $j => $l) {
                    if ($mntt > 0 && array_key_exists('piecereglementclient_id', $l)) {
                        $li['reglementclient_id'] = $reg_id;
                        $li['piecereglementclient_id'] = $l['piecereglementclient_id'];
                        $id_piece = $l['piecereglementclient_id'];
                        $li['Montant'] = $l['Montant'];
                        $montantaffecter = $montantaffecter + $l['Montant'];
                        $this->Piecereglementclient->updateAll(array('Piecereglementclient.reglement ' => $reg_id,'Piecereglementclient.mantantregler' => 'Piecereglementclient.mantantregler+' . $l['Montant']), array('Piecereglementclient.id' => $id_piece));
                        $this->Lignereglementclient->create();
                        $this->Lignereglementclient->save($li);
                    }
                }}
                $this->Reglementclient->updateAll(array('Reglementclient.montantaffecte' => $montantaffecter), array('Reglementclient.id' => $reg_id));
                
                foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                if($l['sup']!=1){
                    //debug($l);
                    $lip['id'] = $l['id'];
                    $lip['montant'] = $l['montant'];
                    $lip['paiement_id'] = $l['paiement_id'];
                    $lip['reglementclient_id'] = $reg_id;
                    $lip['echance'] = '';
                    $lip['num'] = '';
                    $lip['banque'] = '';
                    $lip['montant_brut'] = '';
                    $lip['montant_net'] = '';
                    $lip['to_id'] = '';
                    $lip['factureavoir_id'] = '';

                    if ($l['paiement_id'] != 1) {
                        $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                        $lip['num'] = $l['num_piece'];
                        $lip['banque'] = $l['banque'];
                    }
                    if ($l['paiement_id'] == 5) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['montant_brut'] = $l['montant_brut'];
                        $lip['montant_net'] = $l['montant_net'];
                        $lip['to_id'] = $l['taux'];
                    }
                    if ($l['paiement_id'] == 6) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['factureavoir_id'] = $l['favid'];

                        $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $l['favid']), false));
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 2), array('Factureavoir.id' => $l['favid']));

                        if (!empty($factureavoir['Factureavoir']['numero'])) {
                            $lip['num'] = $factureavoir['Factureavoir']['numero'];
                        }
                    }
                    $this->Piecereglementclient->create();
                    $this->Piecereglementclient->save($lip);

            }else{
            $this->Piecereglementclient->deleteAll(array('Piecereglementclient.id' => $id), false);
            }
            }



                $this->Session->setFlash(__('The reglementclient has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The reglementclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id));
            $this->request->data = $this->Reglementclient->find('first', $options);
        }
        $clients = $this->Reglementclient->Client->find('list');
        $this->set(compact('clients'));
        $valeurs = $this->To->find('list');
        $reglementclient = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id), 'recursive' => 0));
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $reglementclient['Reglementclient']['Date'])));
        $facture = array();
        $clients = $this->Reglementclient->Client->find('list');
        $paiements = $this->Paiement->find('list'); //debug($paiements);die;
        if ($client_id) {
            $t = '0';
            foreach ($this->request->data['Lignereglementclient']as $j => $l) {
                if(!empty($l['factureclient_id'])){
                $t = $t . ',' . $l['factureclient_id'];
                }
            }
            $facture = $this->Factureclient->find('all', array('conditions' => array('Factureclient.client_id' => $client_id, '(Factureclient.totalttc>(Factureclient.Montant_Regler)) or Factureclient.id in(' . $t . ')'), 'recursive' => 0));
            $situat = "Impaye";
            $impayes = $this->Piecereglementclient->find('all', array(
            'conditions' => array(
            ('(Piecereglementclient.reglement=0 or Piecereglementclient.reglement=' . "'" . $id . "'" . ')'),
            'Piecereglementclient.situation =' . "'" . $situat . "'")
            , 'recursive' => 0));

        }
        //debug($valeurs);
        $pointdeventes = $this->Pointdevente->find('list');
        $this->set(compact('id','impayes','pointdeventes', 'clients', 'client_id', 'facture', 'paiements', 'valeurs', 'facregclient', 'totalfacture', 'piecesregclient', 'retenue', 'date'));
    }

    
//******************reglement libre**********************************************************************************************************************    

    public function indexrl() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Famille');
        $this->loadModel('Client');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Ligneclient');
        $this->loadModel('Societe');
$soc= CakeSession::read('soc');
//		$familles = $this->Famille->find('list');
        $clients = $this->Client->find('list');
        if ((isset($this->request->data) && !empty($this->request->data))||(( in_array(CakeSession::read('view'),Array("editrl","viewrl","delete")))&&(CakeSession::read('Controller') =="Reglementclients"))) {
            if ((isset($this->request->data) && !empty($this->request->data))||((! in_array(CakeSession::read('view'),Array("editrl","viewrl","delete"))))) {
            CakeSession::write('recherche',$this->request->data['Recherche']);
            }else{
            $this->request->data['Recherche']=CakeSession::read('recherche');     
            }
            $cond = '';
            $cond1 = '';
            $cond2 = '';
            $cond3 = '';
            $cond4 = '';
            $cond6 = '';
            $cond7 = '';
            if ($this->request->data['Recherche']['Date_debut'] != '__/__/____') {
                $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['Date_debut'])));
                $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
            }
            if ($this->request->data['Recherche']['Date_fin'] != '__/__/____') {
                $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['Date_fin'])));
                $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
            }

            if ($this->request->data['Recherche']['client_id']) {
                $client_id = $this->request->data['Recherche']['client_id'];
                $cond3 = 'Reglementclient.client_id=' . $client_id;
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
                    $cond6 = 'Reglementclient.pointdevente_id in (' . $ch_pv.')';
                    $pointdeventes=$this->Pointdevente->find('list',array('conditions'=>array('Pointdevente.societe_id'=>$societe_id)));
                }
            
                
            if ($this->request->data['Recherche']['pointdevente_id']) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                    $cond7 = 'Reglementclient.pointdevente_id ='.$pointdevente_id;
            }
            
            
        }
        $reglementclients = $this->Reglementclient->find('all', array(
            'order' => array('Reglementclient.id' => 'desc'),
            'conditions' => array('Reglementclient.type' => 1, @$cond, @$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7)));
        $societes = $this->Societe->find('list',array('conditions'=>array('Societe.id in ('.$soc.')')));

        $this->set(compact('reglementclients','societes','pointdeventes','pointdevente_id','societe_id', 'collections', 'transferecommandebls', 'marques', 'familles', 'clients', 'ligneclients', 'marque_id', 'Date_debut', 'Date_fin', 'client_id', 'num_recu'));
    }

    public function viewrl($id = null) {
//            $lien=  CakeSession::read('lien_vente');
//               $utilisateur="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='reglements'){
//                        $utilisateur=1;
//                }}}
//              if (( $utilisateur <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }

        $this->loadModel('Piecereglementclient');
        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id), 'recursive' => 2);
        $reglement = $this->Reglementclient->find('first', $options);
        $pieceregement = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id)));
        // debug($pieceregement);die;
        $this->set(compact('reglement', 'pieceregement'));
    }

    public function addrl($client_id = 0) {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['add'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');

        if ($this->request->is('post')) {
            // debug($this->request->data);die;
//                     foreach($this->request->data['pieceregelemnt']as $j=>$l){
//                                $li['client_id']=$client_id;
//                               
//                                $li['echance']=$l['echance'];
//                               $li['montant']=$l['montant'];
//                                $li['num']=$l['num_piece'];
//                            }
            $client_id = $this->request->data['Reglementclient']['client_id'];
            $this->request->data['Reglementclient']['type'] = 1;
            $this->request->data['Reglementclient']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date'])));
            $this->request->data['Reglementclient']['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data['Reglementclient']['pointdevente_id'])) {
                $this->request->data['Reglementclient']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Reglementclient']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Reglementclient']['pointdevente_id'];
            }
            $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                'conditions' => array('Reglementclient.pointdevente_id' => $pv, 'Reglementclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];  
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

            $this->request->data['Reglementclient']['numeroconca'] = $mm;
            $this->request->data['Reglementclient']['numero'] = $numspecial;
            $this->Reglementclient->create();
            //debug($this->request->data);die;
            if ($this->Reglementclient->save($this->request->data)) {
                $reg_id = $this->Reglementclient->id;
                $this->misejour("Reglementclient","add",$reg_id);
                $mntt = $this->request->data['Reglementclient']['Montant'];
                //debug($mntt);
                // debug($this->request->data['pieceregelemnt']);
                foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                    // debug($l);
                    //  $li['client_id']=$client_id;                               

                    $lip['montant'] = $l['montant'];
//                                $li['num_recu']=$l['num_recu'];
                    $lip['paiement_id'] = $l['paiement_id'];
                    $lip['reglementclient_id'] = $reg_id;
                    $lip['echance'] = '';
                    $lip['num'] = '';
                    $lip['banque'] = '';
                    $lip['montant_brut'] = '';
                    $lip['montant_net'] = '';
                    $lip['to_id'] = '';
                    $lip['factureavoir_id'] = '';

                    if ($l['paiement_id'] != 1) {
                        $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                        $lip['num'] = $l['num_piece'];
                        $lip['banque'] = $l['banque'];
                    }
                    if ($l['paiement_id'] == 5) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['montant_brut'] = $l['montant_brut'];
                        $lip['montant_net'] = $l['montant_net'];
                        $lip['to_id'] = $l['taux'];
                    }
                    if ($l['paiement_id'] == 6) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['factureavoir_id'] = $l['favid'];

                        $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $l['favid']), false));
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 2), array('Factureavoir.id' => $l['favid']));
                        $lip['num'] = $factureavoir['Factureavoir']['numero'];
                    }
                    $this->Piecereglementclient->create();
                    //debug($li);die;
                    $this->Piecereglementclient->save($lip);
//                                 $id_piece= $this->Piece->id;
//                                 $lip['piece_id']=$id_piece;
//                                 $lip['reglement_id']=$reg_id;
//                                  $this->Piecereglementclient->create();
//                                 // debug($lip);
//                                 $this->Piecereglement->save($lip);
                }
                //die;

                $this->Session->setFlash(__('The reglement has been saved'));
                $this->redirect(array('action' => 'indexrl'));
            } else {
                $this->Session->setFlash(__('The reglement could not be saved. Please, try again.'));
            }
        }
        $valeurs = $this->To->find('list');
        $facture = array();
        $clients = $this->Reglementclient->Client->find('list');
        $paiements = $this->Paiement->find('list'); //debug($paiements);die;
        if ($client_id) {
            $facture = $this->Factureclient->find('all', array('conditions' => array('Factureclient.client_id' => $client_id, 'Factureclient.totalttc>(Factureclient.Montant_Regler)'), 'recursive' => 0));
        }


        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {
            $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                'conditions' => array('Reglementclient.pointdevente_id' => $pv, 'Reglementclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];  
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

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            $mm = 0;
        }
        $pointdeventes = $this->Pointdevente->find('list');
        $this->set(compact('mm', 'numspecial', 'clients', 'client_id', 'facture', 'paiements', 'valeurs', 'pointdeventes'));
    }

    public function editrl($id = null) {
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['edit'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglementclient'));
        }
        $piecesregclient = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id), 'recursive' => 2));  //debug($piecesregclient);die;

        $retenue = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id, 'Piecereglementclient.paiement_id' => 5), 'recursive' => 2));  //debug($piecesreg);die;

        $totalfacture = 0;
        $lignesreg = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id)));
        foreach ($lignesreg as $k => $ligne) {
            $facregclient[$ligne['Factureclient']['id']] = 1;
            $totalfacture = $totalfacture + $ligne['Factureclient']['totalttc'];
            //  aprrrr      $this->Factureclient->updateAll(array('Factureclient.Montant_Regler' => 'Factureclient.Montant_Regler-' . $ligne['Lignereglementclient']['Montant'],
            //  aprrrr      ), array('Factureclient.id' => $ligne['Lignereglementclient']['factureclient_id']));
        }
        $reglementclient = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id)));
        $client_id = $reglementclient['Reglementclient']['client_id'];
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);die;
            $this->request->data['Reglementclient']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date'])));
            if ($this->Reglementclient->save($this->request->data)) {
                $this->misejour("Reglementclient","edit",$id);

                foreach ($piecesregclient as $piece) {
                    if ($piece['Piecereglementclient']['paiement_id'] == 6) {
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 1), array('Factureavoir.id' => $piece['Piecereglementclient']['factureavoir_id']));
                    }
                }

                //.....................................effacer  piece reglementclient , ligne reglementclient , ..........................................................................


                $this->Piecereglementclient->deleteAll(array('Piecereglementclient.reglementclient_id' => $id), false);

                //$lignesreg = $this->Lignereglementclient->find('all',array('conditions'=>array('Lignereglementclient.reglementclient_id' => $id)));  //debug($lignesreg);die;

                foreach ($lignesreg as $k => $ligne) {

                    $this->Factureclient->updateAll(array('Factureclient.Montant_Regler' => 'Factureclient.Montant_Regler-' . $ligne['Lignereglementclient']['Montant'],
                            ), array('Factureclient.id' => $ligne['Lignereglementclient']['factureclient_id']));
                }
                $this->Lignereglementclient->deleteAll(array('Lignereglementclient.reglementclient_id' => $id), false);

                //..............................fin effacer ligne reglementclient , piece reglementclient .............................................................................   

                $reg_id = $id;
                $mntt = $this->request->data['Reglementclient']['Montant'];
                //debug($mntt);
                // debug($this->request->data['pieceregelemnt']);
                foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                    //debug($l);
                    //  $li['client_id']=$client_id;                               

                    $lip['montant'] = $l['montant'];
//                                $li['num_recu']=$l['num_recu'];
                    $lip['paiement_id'] = $l['paiement_id'];
                    $lip['reglementclient_id'] = $reg_id;
                    $lip['echance'] = '';
                    $lip['num'] = '';
                    $lip['banque'] = '';
                    $lip['montant_brut'] = '';
                    $lip['montant_net'] = '';
                    $lip['to_id'] = '';
                    $lip['factureavoir_id'] = '';

                    if ($l['paiement_id'] != 1) {
                        $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                        $lip['num'] = $l['num_piece'];
                        $lip['banque'] = $l['banque'];
                    }
                    if ($l['paiement_id'] == 5) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['montant_brut'] = $l['montant_brut'];
                        $lip['montant_net'] = $l['montant_net'];
                        $lip['to_id'] = $l['taux'];
                    }
                    if ($l['paiement_id'] == 6) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['factureavoir_id'] = $l['favid'];

                        $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $l['favid']), false));
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 2), array('Factureavoir.id' => $l['favid']));

                        if (!empty($factureavoir['Factureavoir']['numero'])) {
                            $lip['num'] = $factureavoir['Factureavoir']['numero'];
                        }
                    }
                    $this->Piecereglementclient->create();
                    //debug($li);die;
                    $this->Piecereglementclient->save($lip);
//                                 $id_piece= $this->Piece->id;
//                                 $lip['piece_id']=$id_piece;
//                                 $lip['reglement_id']=$reg_id;
//                                  $this->Piecereglementclient->create();
//                                 // debug($lip);
//                                 $this->Piecereglement->save($lip);
                }



                $this->Session->setFlash(__('The reglementclient has been saved'));
                $this->redirect(array('action' => 'indexrl'));
            } else {
                $this->Session->setFlash(__('The reglementclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id));
            $this->request->data = $this->Reglementclient->find('first', $options);
        }
        $clients = $this->Reglementclient->Client->find('list');
        $this->set(compact('clients'));
        $valeurs = $this->To->find('list');
        $reglementclient = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id), 'recursive' => 0));
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $reglementclient['Reglementclient']['Date'])));
        $facture = array();
        $clients = $this->Reglementclient->Client->find('list');
        $paiements = $this->Paiement->find('list'); //debug($paiements);die;
        if ($client_id) {
            $facture = $this->Factureclient->find('all', array('conditions' => array('Factureclient.client_id' => $client_id, 'Factureclient.totalttc>(Factureclient.Montant_Regler)'), 'recursive' => 0));
            //debug($bl);die;
        }
        //debug($valeurs);
        $this->set(compact('clients', 'client_id', 'facture', 'paiements', 'valeurs', 'facregclient', 'totalfacture', 'piecesregclient', 'retenue', 'date'));
    }

//******************reglement piece impay�***************************************************************************************************************    

    public function indexrpi() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Famille');
        $this->loadModel('Client');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Ligneclient');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $conde = 'Reglementclient.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Reglementclient.pointdevente_id = ' . $p;
        }
        $clients = $this->Client->find('list');
        $deux = 2;
        $soc= CakeSession::read('soc');
        if ((isset($this->request->data) && !empty($this->request->data))||(( in_array(CakeSession::read('view'),Array("editrpi","viewrpi","delete")))&&(CakeSession::read('Controller') =="Reglementclients"))) {
            if ((isset($this->request->data) && !empty($this->request->data))||((! in_array(CakeSession::read('view'),Array("editrpi","viewrpi","delete"))))) {
            CakeSession::write('recherche',$this->request->data['Recherche']);
            }else{
            $this->request->data['Recherche']=CakeSession::read('recherche');    
            }

            if ($this->request->data['Recherche']['Date_debut'] != '__/__/____') {
                $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['Date_debut'])));
                $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
            }
            if ($this->request->data['Recherche']['Date_fin'] != '__/__/____') {
                $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['Date_fin'])));
                $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
            }

            if ($this->request->data['Recherche']['client_id']) {
                $client_id = $this->request->data['Recherche']['client_id'];
                $cond3 = 'Reglementclient.client_id=' . $client_id;
            }
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $cond4 = 'Reglementclient.exercice_id =' . $exercices[$exerciceid];
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
                    $cond6 = 'Reglementclient.pointdevente_id in (' . $ch_pv.')';
                    $pointdeventes=$this->Pointdevente->find('list',array('conditions'=>array('Pointdevente.societe_id'=>$societe_id)));
                }
            
                
            if ($this->request->data['Recherche']['pointdevente_id']) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                    $cond7 = 'Reglementclient.pointdevente_id ='.$pointdevente_id;
            }
            
            
            
            
            
        }
        $condtype = 'Reglementclient.type = ' . $deux;
        $reglementclients = $this->Reglementclient->find('all', array('conditions' => array('Reglementclient.id > ' => 0, $condtype, @$pv, @$cond, @$conde, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6, @$cond7)));
        $societes = $this->Societe->find('list',array('conditions'=>array('Societe.id in ('.$soc.')')));
        //debug($reglementclients);die;
        $this->set(compact('reglementclients', 'collections','societes','pointdeventes','pointdevente_id','societe_id', 'transferecommandebls', 'marques', 'familles', 'clients', 'ligneclients', 'Date_debut', 'marque_id', 'Date_fin', 'client_id', 'exerciceid', 'num_recu', 'pointdeventes', 'exercices'));
    }

    public function viewrpi($id = null) {
//            $lien=  CakeSession::read('lien_vente');
//               $utilisateur="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='reglements'){
//                        $utilisateur=1;
//                }}}
//              if (( $utilisateur <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }

        $this->loadModel('Piecereglementclient');
        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id), 'recursive' => 2);
        $reglement = $this->Reglementclient->find('first', $options);
        $pieceregement = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id)));
        // debug($pieceregement);die;
        $this->set(compact('reglement', 'pieceregement'));
    }

    public function imprimerviewrpi($id = null) {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Piecereglementclient');
        $this->loadModel('Lignereglementclient');

        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id), 'recursive' => 2);
        $reglement = $this->Reglementclient->find('first', $options);
        $pieceregement = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id)));

        $ligneregement = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id)));

        //debug($ligneregement);die;
        $this->set(compact('reglement', 'pieceregement', 'ligneregement'));
    }

    public function addrpi($client_id = 0, $poinvente = 0) {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['add'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');

        if ($this->request->is('post')) {
            //debug($this->request->data);
//                     foreach($this->request->data['pieceregelemnt']as $j=>$l){
//                                $li['client_id']=$client_id;
//                               
//                                $li['echance']=$l['echance'];
//                               $li['montant']=$l['montant'];
//                                $li['num']=$l['num_piece'];
//                            }
            $client_id = $this->request->data['Reglementclient']['client_id'];
            $this->request->data['Reglementclient']['type'] = 2;
            $this->request->data['Reglementclient']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date'])));
            $this->request->data['Reglementclient']['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data['Reglementclient']['pointdevente_id'])) {
                $this->request->data['Reglementclient']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Reglementclient']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Reglementclient']['pointdevente_id'];
            }
            $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                'conditions' => array('Reglementclient.pointdevente_id' => $pv, 'Reglementclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];  
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

            $this->request->data['Reglementclient']['numeroconca'] = $mm;
            $this->request->data['Reglementclient']['numero'] = $numspecial;
            $this->Reglementclient->create();
            //debug($this->request->data);die;
            if ($this->Reglementclient->save($this->request->data)) {
                $reg_id = $this->Reglementclient->id;
                $this->misejour("Reglementclient","add",$reg_id);
                $mntt = $this->request->data['Reglementclient']['Montant'];
                //debug($mntt);
                foreach ($this->request->data['Lignereglement']as $j => $l) {
                    //debug($l);die;
                    //debug(array_key_exists('bonlivraison_id', $l));
                    if ($mntt > 0) {
                        $li['reglementclient_id'] = $reg_id;
                        //debug($l['bonlivraison_id']);
                        $li['piecereglementclient_id'] = $l['piecereglementclient_id'];
                        $id_piececlient = $l['piecereglementclient_id'];
                        $piecereglementclient = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.id' => $id_piececlient), 'recursive' => 0));

                        $mntfac = $piecereglementclient['Piecereglementclient']['montant'];
                        // debug ($mntbl);

                        if ($mntt >= $mntfac) {
                            $li['Montant'] = $mntfac;
                            $mntt = $mntt - $mntfac;
                            $mnr = $mntfac;
                        } else {
                            $li['Montant'] = $mntt;
                            $mnr = $mntt;
                            $mntt = 0;
                        }

                        //die;
                        //debug($li);die;
                        $this->Piecereglementclient->updateAll(array('Piecereglementclient.reglement ' => $reg_id, 'Piecereglementclient.mantantregler ' => 'Piecereglementclient.mantantregler+' . $mnr), array('Piecereglementclient.id' => $id_piececlient));
                        $this->Lignereglementclient->create();
                        $this->Lignereglementclient->save($li);
                    }
                }//die;
                // debug($this->request->data['pieceregelemnt']);
                foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                    // debug($l);
                    //  $li['client_id']=$client_id;                               

                    $lip['montant'] = $l['montant'];
//                                $li['num_recu']=$l['num_recu'];
                    $lip['paiement_id'] = $l['paiement_id'];
                    $lip['reglementclient_id'] = $reg_id;
                    $lip['echance'] = '';
                    $lip['num'] = '';
                    $lip['banque'] = '';
                    $lip['montant_brut'] = '';
                    $lip['montant_net'] = '';
                    $lip['to_id'] = '';
                    $lip['factureavoir_id'] = '';

                    if ($l['paiement_id'] != 1) {
                        $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                        $lip['num'] = $l['num_piece'];
                        $lip['banque'] = $l['banque'];
                    }
                    if ($l['paiement_id'] == 5) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['montant_brut'] = $l['montant_brut'];
                        $lip['montant_net'] = $l['montant_net'];
                        $lip['to_id'] = $l['taux'];
                    }
                    if ($l['paiement_id'] == 6) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['factureavoir_id'] = $l['favid'];

                        $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $l['favid']), false));
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 2), array('Factureavoir.id' => $l['favid']));
                        $lip['num'] = $factureavoir['Factureavoir']['numero'];
                    }
                    $this->Piecereglementclient->create();
                    //debug($li);die;
                    $this->Piecereglementclient->save($lip);
//                                 $id_piece= $this->Piece->id;
//                                 $lip['piece_id']=$id_piece;
//                                 $lip['reglement_id']=$reg_id;
//                                  $this->Piecereglementclient->create();
//                                 // debug($lip);
//                                 $this->Piecereglement->save($lip);
                }
                //die;

                $this->Session->setFlash(__('The reglement has been saved'));
                $this->redirect(array('action' => 'indexrpi'));
            } else {
                $this->Session->setFlash(__('The reglement could not be saved. Please, try again.'));
            }
        }
        $valeurs = $this->To->find('list');
        $facture = array();
        $clients = $this->Reglementclient->Client->find('list');
        $paiements = $this->Paiement->find('list'); //debug($paiements);die;

        $situat = "Impaye";
        if ($client_id) {
//            $facture = $this->Piecereglementclient->find('all', array(
//                'conditions' => array('Piecereglementclient.reglement' => 0
//                    , 'Piecereglementclient.situation'=>"'".$situat."'")
//                , 'recursive' => 0));

            $facture = $this->Piecereglementclient->find('all', array(
                'conditions' => array(
                    'Piecereglementclient.situation =' . "'" . $situat . "'", 'Piecereglementclient.montant>Piecereglementclient.mantantregler')
                , 'recursive' => 0));

            // debug($facture);die; 
        }


        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {
            $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                'conditions' => array('Reglementclient.pointdevente_id' => $pv, 'Reglementclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];  
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

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            if ($poinvente) {
                $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                    'conditions' => array('Reglementclient.pointdevente_id' => $poinvente, 'Reglementclient.exercice_id' => date("Y")))
                );
                //debug($numero);die;
                foreach ($numero as $num) {
                    $n = $num[0]['num'];
                }
                if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];  
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

                $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $poinvente)));
                $abrivation = $pointvente['Pointdevente']['abriviation'];
                $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
            } else {
                $mm = 0;
            }
        }
        $pointdeventes = $this->Pointdevente->find('list');
        $this->set(compact('poinvente', 'mm', 'numspecial', 'clients', 'client_id', 'facture', 'paiements', 'valeurs', 'pointdeventes'));
    }

    public function editrpi($id = null) {
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['edit'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglementclient'));
        }
        $piecesregclient = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id), 'recursive' => 2));  //debug($piecesregclient);die;
        $retenue = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id, 'Piecereglementclient.paiement_id' => 5), 'recursive' => 2));  //debug($piecesreg);die;
        $totalfacture = 0;

        $lignesreg = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id)));
        foreach ($lignesreg as $k => $ligne) {
            $facregclient[$ligne['Piecereglementclient']['id']] = 1;
            $totalfacture = $totalfacture + $ligne['Piecereglementclient']['montant'];
            //  aprrrr      $this->Factureclient->updateAll(array('Factureclient.Montant_Regler' => 'Factureclient.Montant_Regler-' . $ligne['Lignereglementclient']['Montant'],
            //  aprrrr      ), array('Factureclient.id' => $ligne['Lignereglementclient']['factureclient_id']));
        }
        $reglementclient = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id)));
        $client_id = $reglementclient['Reglementclient']['client_id'];
        if ($this->request->is('post') || $this->request->is('put')) {
            // debug($this->request->data);die;
            $this->request->data['Reglementclient']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date'])));
            if ($this->Reglementclient->save($this->request->data)) {
                $this->misejour("Reglementclient","edit",$id);

                foreach ($piecesregclient as $piece) {
                    if ($piece['Piecereglementclient']['paiement_id'] == 6) {
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 1), array('Factureavoir.id' => $piece['Piecereglementclient']['factureavoir_id']));
                    }
                }

                //.....................................effacer  piece reglementclient , ligne reglementclient , ..........................................................................


                $this->Piecereglementclient->deleteAll(array('Piecereglementclient.reglementclient_id' => $id), false);

                //$lignesreg = $this->Lignereglementclient->find('all',array('conditions'=>array('Lignereglementclient.reglementclient_id' => $id)));  //debug($lignesreg);die;

                foreach ($lignesreg as $k => $ligne) {
                    // $lignesreg = $this->Lignereglementclient->find('first', array('conditions' => array('Lignereglementclient.piecereglementclient_id' => $piece['Piecereglementclient']['id'])));
                    $this->Piecereglementclient->updateAll(array('Piecereglementclient.reglement' => 0, 'Piecereglementclient.mantantregler ' => 'Piecereglementclient.mantantregler-' . $ligne['Lignereglementclient']['Montant']), array('Piecereglementclient.id' => $ligne['Lignereglementclient']['piecereglementclient_id']));
                }
                $this->Lignereglementclient->deleteAll(array('Lignereglementclient.reglementclient_id' => $id), false);

                //..............................fin effacer ligne reglementclient , piece reglementclient .............................................................................   
                //debug($this->request->data);die;         
                $reg_id = $id;
                $mntt = $this->request->data['Reglementclient']['Montant'];
                //debug($mntt);
                foreach ($this->request->data['Lignereglement']as $j => $l) {
                    //debug($l);die;
                    //debug(array_key_exists('bonlivraison_id', $l));
                    if ($mntt > 0) {
                        $li['reglementclient_id'] = $reg_id;
                        //debug($l['bonlivraison_id']);
                        $li['piecereglementclient_id'] = $l['piecereglementclient_id'];
                        $id_piececlient = $l['piecereglementclient_id'];
                        $piecereglementclient = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.id' => $id_piececlient), 'recursive' => 0));

                        $mntfac = $piecereglementclient['Piecereglementclient']['montant'];
                        // debug ($mntbl);

                        if ($mntt >= $mntfac) {
                            $li['Montant'] = $mntfac;
                            $mntt = $mntt - $mntfac;
                            $mnr = $mntfac;
                        } else {
                            $li['Montant'] = $mntt;
                            $mnr = $mntt;
                            $mntt = 0;
                        }

                        //die;
                        //debug($li);die;
                        $this->Piecereglementclient->updateAll(array('Piecereglementclient.reglement ' => $reg_id, 'Piecereglementclient.mantantregler ' => 'Piecereglementclient.mantantregler+' . $mnr), array('Piecereglementclient.id' => $id_piececlient));
                        $this->Lignereglementclient->create();
                        $this->Lignereglementclient->save($li);
                    }
                }//die;
                // debug($this->request->data['pieceregelemnt']);
                foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                    //debug($l);
                    //  $li['client_id']=$client_id;                               

                    $lip['montant'] = $l['montant'];
//                                $li['num_recu']=$l['num_recu'];
                    $lip['paiement_id'] = $l['paiement_id'];
                    $lip['reglementclient_id'] = $reg_id;
                    $lip['echance'] = '';
                    $lip['num'] = '';
                    $lip['banque'] = '';
                    $lip['montant_brut'] = '';
                    $lip['montant_net'] = '';
                    $lip['to_id'] = '';
                    $lip['factureavoir_id'] = '';

                    if ($l['paiement_id'] != 1) {
                        $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                        $lip['num'] = $l['num_piece'];
                        $lip['banque'] = $l['banque'];
                    }
                    if ($l['paiement_id'] == 5) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['montant_brut'] = $l['montant_brut'];
                        $lip['montant_net'] = $l['montant_net'];
                        $lip['to_id'] = $l['taux'];
                    }
                    if ($l['paiement_id'] == 6) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['factureavoir_id'] = $l['favid'];

                        $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $l['favid']), false));
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 2), array('Factureavoir.id' => $l['favid']));

                        if (!empty($factureavoir['Factureavoir']['numero'])) {
                            $lip['num'] = $factureavoir['Factureavoir']['numero'];
                        }
                    }
                    $this->Piecereglementclient->create();
                    //debug($li);die;
                    $this->Piecereglementclient->save($lip);
                }



                $this->Session->setFlash(__('The reglementclient has been saved'));
                $this->redirect(array('action' => 'indexrpi'));
            } else {
                $this->Session->setFlash(__('The reglementclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id));
            $this->request->data = $this->Reglementclient->find('first', $options);
        }
        $clients = $this->Reglementclient->Client->find('list');
        $this->set(compact('clients'));
        $valeurs = $this->To->find('list');
        $reglementclient = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id), 'recursive' => 0));
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $reglementclient['Reglementclient']['Date'])));
        $facture = array();
        $clients = $this->Reglementclient->Client->find('list');
        $paiements = $this->Paiement->find('list'); //debug($paiements);die;
        $situat = "Impaye";
        if ($client_id) {

            $facture = $this->Piecereglementclient->find('all', array(
                'conditions' => array(
                    // 'Piecereglementclient.reglement' => $id ,
                    ('(Piecereglementclient.reglement=0 or Piecereglementclient.reglement=' . "'" . $id . "'" . ')'),
                    'Piecereglementclient.situation =' . "'" . $situat . "'")
                , 'recursive' => 0));

            // debug($facture);die; 
        }
        //debug($valeurs);
        $this->set(compact('clients', 'id', 'client_id', 'facture', 'paiements', 'valeurs', 'facregclient', 'totalfacture', 'piecesregclient', 'retenue', 'date'));
    }

    public function delete($id = null) {
        $this->loadModel('Reglementclient');
        $this->loadModel('Factureclient');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['delete'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->Reglementclient->id = $id;
        if (!$this->Reglementclient->exists()) {
            throw new NotFoundException(__('Invalid reglementclient'));
        }
        $abcd = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id), 'recursive' => -1));
        $numansar=$abcd['Reglementclient']['numero'];
        $this->request->onlyAllow('post', 'delete');
        if ($this->Reglementclient->delete()) {
            $this->misejour("Reglementclient",$numansar,$id);
            $piecesregclient = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id), 'recursive' => 2));  //debug($piecesregclient);die;
            foreach ($piecesregclient as $piece) {
                if ($piece['Piecereglementclient']['paiement_id'] == 6) {
                    $this->Factureavoir->updateAll(array('Factureavoir.etat' => 1), array('Factureavoir.id' => $piece['Piecereglementclient']['factureavoir_id']));
                }
            }
            $this->Piecereglementclient->deleteAll(array('Piecereglementclient.reglementclient_id' => $id), false);
            $lignesreg = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id)));
            foreach ($lignesreg as $k => $ligne) {
                if(!empty($ligne['Lignereglementclient']['factureclient_id'])){
                    $this->Factureclient->updateAll(array('Factureclient.Montant_Regler' => 'Factureclient.Montant_Regler-' . $ligne['Lignereglementclient']['Montant'],
                            ), array('Factureclient.id' => $ligne['Lignereglementclient']['factureclient_id']));
                    }
                    if(!empty($ligne['Lignereglementclient']['piecereglementclient_id'])){
                    $this->Piecereglementclient->updateAll(array('Piecereglementclient.mantantregler' => 'Piecereglementclient.mantantregler-' . $ligne['Lignereglementclient']['Montant'],
                            ), array('Piecereglementclient.id' => $ligne['Lignereglementclient']['piecereglementclient_id']));
                    }
//                $this->Factureclient->updateAll(array('Factureclient.Montant_Regler' => 'Factureclient.Montant_Regler-' . $ligne['Lignereglementclient']['Montant'],
//                        ), array('Factureclient.id' => $ligne['Lignereglementclient']['factureclient_id']));
            }
            $this->Lignereglementclient->deleteAll(array('Lignereglementclient.reglementclient_id' => $id), false);
            $this->Session->setFlash(__('Reglementclient deleted'));
            CakeSession::write('view',"delete");
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Reglementclient was not deleted'));
        //$this->redirect(array('action' => 'index'));
    }

    public function getfactureavoirs() {
        $this->layout = null;
        $this->loadModel('Factureavoir');
        $data = $this->request->data;

        $clientid = $data['clientid'];
        $index = $data['index'];
        //$name='piecereglementclient_id';
        $factureavoirs = $this->Factureavoir->find('all', array('conditions' => array('Factureavoir.client_id' => $clientid, 'Factureavoir.etat' => 1), 'recursive' => -1));

        $id = 'factureavoir_id' . $index;
        if ($clientid != 0) {
            $select = "<select   name='data[pieceregelemnt][$index][num_piece]' id='$id' table='pieceregelemnt' index='$index' champ='factureavoir_id0' id='factureavoir_id0' class='select form-control'  onchange='getmontantfav(" . $index . ")'><option selected disabled hidden value=0> Veuillez choisir</option>";
            foreach ($factureavoirs as $p) {
                $select = $select . "<option value=" . $p['Factureavoir']['id'] . ">" . $p['Factureavoir']['numero'] . "</option>";
            }
            $select = $select . '</select>';
        }
        echo $select;
        die();
    }

//a faire  !!!!!!!!
}
