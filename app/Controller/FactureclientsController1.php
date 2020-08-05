<?php
App::uses('AppController', 'Controller');
App::uses('DevisController', 'Controller');
App::uses('BonlivraisonsController', 'Controller');
App::uses('CommandeclientsController', 'Controller');

/**
 * Factureclients Controller
 *
 * @property  $Factureclient
 */
class FactureclientsController extends AppController {

     public function imprimer($id = null, $model = null, $ligne_model = null, $attribut = null, $droit = null, $designation = null) {


        $model = $this->encrypt_decrypt(urldecode(stripslashes($model)));
        $ligne_model = $this->encrypt_decrypt(urldecode(stripslashes($ligne_model)));
        $attribut = $this->encrypt_decrypt(urldecode(stripslashes($attribut)));
        $droit = $this->encrypt_decrypt(urldecode(stripslashes($droit)));
        $designation = $this->encrypt_decrypt(urldecode(stripslashes($designation)));


        $this->response->type('pdf');
        $this->layout = 'pdf';
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == $droit) {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($ligne_model);
        $this->loadModel($model);

        $factureclient = $this->$model->find('first', array(
            'conditions' => array($model . '.id' => $id), 'recursive' => 0, 'contain' => array('Client')
        ));
        if($model=="Factureclient"){
            if($factureclient['Factureclient']['source']=="bl"){
            $order=array($ligne_model . '.bonlivraison_id' => 'ASC',$ligne_model . '.id' => 'ASC');
            }else{
            $order=array($ligne_model . '.id' => 'ASC');
            }
        }else{
            $order=array($ligne_model . '.id' => 'ASC');
        }
        if($model=="Factureclient"){$contain=array('Article','Bonlivraison');}else{$contain=array('Article');}
        $lignefactureclients = $this->$ligne_model->find('all', array(
            'conditions' => array($ligne_model . '.' . $attribut => $id), 'contain' => $contain , 'order' => $order
        ));

        $lignefactureclientstva = $this->$ligne_model->find('all', array('fields' => array(
                'SUM(' . $ligne_model . '.totalht*' . $ligne_model . '.tva)/100  mtva'
                , 'SUM(' . $ligne_model . '.totalht) totalht'
                , 'AVG(' . $ligne_model . '.tva) tva'),
            'conditions' => array($ligne_model . '.' . $attribut => $id)
            , 'group' => array($ligne_model . '.tva')
            ,'order'=>array($ligne_model.'.id ASC')
        ));
        //debug($factureclient);debug($lignefactureclients);debug($lignefactureclientstva);die;
        $this->set(compact('factureclient', 'lignefactureclients', 'lignefactureclientstva', 'id', 'model', 'ligne_model', 'attribut', 'droit', 'designation'));
    }

    public function imprimercomp($id = null, $model = null, $ligne_model = null, $attribut = null, $droit = null, $designation = null) {


        $model = $this->encrypt_decrypt(urldecode(stripslashes($model)));
        $ligne_model = $this->encrypt_decrypt(urldecode(stripslashes($ligne_model)));
        $attribut = $this->encrypt_decrypt(urldecode(stripslashes($attribut)));
        $droit = $this->encrypt_decrypt(urldecode(stripslashes($droit)));
        $designation = $this->encrypt_decrypt(urldecode(stripslashes($designation)));


        $this->response->type('pdf');
        $this->layout = 'pdf';
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == $droit) {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($ligne_model);
        $this->loadModel($model);

        $factureclient = $this->$model->find('first', array(
            'conditions' => array($model . '.id' => $id), 'recursive' => 0, 'contain' => array('Client')
        ));
        if($model=="Factureclient"){
            if($factureclient['Factureclient']['source']=="bl"){
            $order=array($ligne_model . '.bonlivraison_id' => 'ASC');
            }else{
            $order=array($ligne_model . '.id' => 'ASC');
            }
        }else{
            $order=array($ligne_model . '.id' => 'ASC');
        }
        if($model=="Factureclient"){$contain=array('Article','Bonlivraison');}else{$contain=array('Article');}
        $lignefactureclients = $this->$ligne_model->find('all', array(
            'conditions' => array($ligne_model . '.' . $attribut => $id), 'contain' => $contain , 'order' => $order
        ));

        $lignefactureclientstva = $this->$ligne_model->find('all', array('fields' => array(
                'SUM(' . $ligne_model . '.totalht*' . $ligne_model . '.tva)/100  mtva'
                , 'SUM(' . $ligne_model . '.totalht) totalht'
                , 'AVG(' . $ligne_model . '.tva) tva'),
            'conditions' => array($ligne_model . '.' . $attribut => $id)
            , 'group' => array($ligne_model . '.tva')
            ,'order'=>array($ligne_model.'.id ASC')
        ));

        //debug($factureclient);debug($lignefactureclients);debug($lignefactureclientstva);die;
        $this->set(compact('index','factureclient', 'lignefactureclients', 'lignefactureclientstva', 'id', 'model', 'ligne_model', 'attribut', 'droit', 'designation'));
    }

    public function getfactures() {
        $this->layout = null;

        $data = $this->request->data;
        $index = $data['index'];
        $client_id = $data['client_id'];
//        debug($this->request->data);die;
        $factureclients = $this->Factureclient->find('all', array(
            'fields' => array('Factureclient.id', 'Factureclient.numero'),
            'conditions' => array('Factureclient.client_id' => $client_id, 'Factureclient.totalttc > Factureclient.Montant_Regler'),
            'recursive' => -1));
//        debug($factureclients);die;
        $select = "<select name='data[Imputationfacture][" . $index . "][factureclient_id]' champ='factureclient_id' id='factureclient_id" . $index . "' class='form-control' onchange='testdoublefacture_et_getreste(" . $index . ")' >";
        $select = $select . "<option value=''>" . "-- Veuillez choisir --" . "</option>";
        foreach ($factureclients as $v) {
            $select = $select . "<option value=" . $v['Factureclient']['id'] . ">" . $v['Factureclient']['numero'] . "</option>";
        }
        $select = $select . '</select>';

        echo json_encode(array('select' => $select, 'index' => $index));
        die();
    }

    public function imprimertest() {

    }

    public function imprimerhaithammatricielle($id = null, $model = null, $ligne_model = null, $attribut = null, $droit = null, $designation = null) {


       // $model = $this->encrypt_decrypt(urldecode(stripslashes($model)));
        //$ligne_model = $this->encrypt_decrypt(urldecode(stripslashes($ligne_model)));
        //$attribut = $this->encrypt_decrypt(urldecode(stripslashes($attribut)));
        //$droit = $this->encrypt_decrypt(urldecode(stripslashes($droit)));
        ///$designation = $this->encrypt_decrypt(urldecode(stripslashes($designation)));
         //ebug($model);
        //debug($ligne_model);
        //debug($attribut);
        //debug($droit);
       // debug($designation);

        $this->response->type('pdf');
        $this->layout = 'pdf';
	 	$lien = CakeSession::read('lien_vente');
		$x = "";
		 //debug($lien);die;
		$lien = CakeSession::read('lien_vente');
		$x = "";
		//debug($lien);die;
		if (!empty($lien)) {
			foreach ($lien as $k => $liens) {
				if (@$liens['lien'] == 'factureclients') {
					$x = $liens['add'];
				}
			}
		}
		if (( $x <> 1) || (empty($lien))) {
			$this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
		}
        $this->loadModel($ligne_model);
        $this->loadModel($model);

        $factureclient = $this->$model->find('first', array(
            'conditions' => array($model . '.id' => $id), 'recursive' => 0
        ));
        if($model=="Factureclient"){$order=array($ligne_model . '.bonlivraison_id' => 'ASC');}else{$order=array($ligne_model . '.id' => 'ASC');}
        if($model=="Factureclient"){$contain=array('Article','Bonlivraison');}else{$contain=array('Article');}
        $lignefactureclients = $this->$ligne_model->find('all', array(
            'conditions' => array($ligne_model . '.' . $attribut => $id), 'contain' => $contain , 'order' => $order
        ));

        $lignefactureclientstva = $this->$ligne_model->find('all', array('fields' => array(
                'SUM(' . $ligne_model . '.totalht*' . $ligne_model . '.tva)/100  mtva'
                , 'SUM(' . $ligne_model . '.totalht) totalht'
                , 'AVG(' . $ligne_model . '.tva) tva'),
            'conditions' => array($ligne_model . '.' . $attribut => $id)
            , 'group' => array($ligne_model . '.tva')
        ));
        //debug($lignefactureclientstva);
        //debug($lignefactureclients);
        //debug($factureclient);
        $this->set(compact('factureclient', 'lignefactureclients', 'lignefactureclientstva', 'id', 'model', 'ligne_model', 'attribut', 'droit', 'designation'));
    }


    public function imprimerhaithammatricielleflexible($id = null, $model = null, $ligne_model = null, $attribut = null, $droit = null, $designation = null) {


        $model = $this->encrypt_decrypt(urldecode(stripslashes($model)));
        $ligne_model = $this->encrypt_decrypt(urldecode(stripslashes($ligne_model)));
        $attribut = $this->encrypt_decrypt(urldecode(stripslashes($attribut)));
        $droit = $this->encrypt_decrypt(urldecode(stripslashes($droit)));
        $designation = $this->encrypt_decrypt(urldecode(stripslashes($designation)));


        $this->response->type('pdf');
        $this->layout = 'pdf';
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == $droit) {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($ligne_model);
        $this->loadModel($model);

        $factureclient = $this->$model->find('first', array(
            'conditions' => array($model . '.id' => $id), 'recursive' => 0
        ));
        if($model=="Factureclient"){$order=array($ligne_model . '.bonlivraison_id' => 'ASC');}else{$order=array($ligne_model . '.id' => 'ASC');}
        if($model=="Factureclient"){$contain=array('Article','Bonlivraison');}else{$contain=array('Article');}
        $lignefactureclients = $this->$ligne_model->find('all', array(
            'conditions' => array($ligne_model . '.' . $attribut => $id), 'contain' => $contain , 'order' => $order
        ));
        $lignefactureclientstva = $this->$ligne_model->find('all', array('fields' => array(
                'SUM(' . $ligne_model . '.totalht*' . $ligne_model . '.tva)/100  mtva'
                , 'SUM(' . $ligne_model . '.totalht) totalht'
                , 'AVG(' . $ligne_model . '.tva) tva'),
            'conditions' => array($ligne_model . '.' . $attribut => $id)
            , 'group' => array($ligne_model . '.tva')
        ));
        //debug($factureclient)  ;die;
        $this->set(compact('factureclient', 'lignefactureclients', 'lignefactureclientstva', 'id', 'model', 'ligne_model', 'attribut', 'droit', 'designation'));
    }


	public function imprimerhaithammatricielleflexible_auto( $model = null, $ligne_model = null, $attribut = null, $droit = null, $designation = null) {


        $model = $this->encrypt_decrypt(urldecode(stripslashes($model)));
        $ligne_model = $this->encrypt_decrypt(urldecode(stripslashes($ligne_model)));
        $attribut = $this->encrypt_decrypt(urldecode(stripslashes($attribut)));
        $droit = $this->encrypt_decrypt(urldecode(stripslashes($droit)));
        $designation = $this->encrypt_decrypt(urldecode(stripslashes($designation)));


        $this->response->type('pdf');
        $this->layout = 'pdf';
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == $droit) {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($ligne_model);
        $this->loadModel($model);

        $factureclients = CakeSession::read('impression_automatique_flexible');

//        $lignefactureclientstva = $this->$ligne_model->find('all', array('fields' => array(
//                'SUM(' . $ligne_model . '.totalht*' . $ligne_model . '.tva)/100  mtva'
//                , 'SUM(' . $ligne_model . '.totalht) totalht'
//                , 'AVG(' . $ligne_model . '.tva) tva'),
//            'conditions' => array($ligne_model . '.' . $attribut => $id)
//            , 'group' => array($ligne_model . '.tva')
//        ));
        //debug($factureclient)  ;die;
        $this->set(compact('factureclients', 'lignefactureclients', 'lignefactureclientstva','model', 'ligne_model', 'attribut', 'droit', 'designation'));
    }
    public function impression_automatique_flexible() {
        CakeSession::delete('impression_automatique_flexible');
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
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

        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $cond4 = 'Factureclient.exercice_id =' . $exe;



        $soc = CakeSession::read('soc');

        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Factureclients"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Recherche']);
            } else {
                $this->request->data['Recherche'] = CakeSession::read('recherche');
            }
            //debug($this->request->data);
            if ($this->request->data['Recherche']['exercice_id']) {
                // debug("ex");
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $cond4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
                $l = 0;
            }
            if (!empty($this->request->data['Recherche']['facturationbl_id'])) {
                $facturationblid = $this->request->data['Recherche']['facturationbl_id'];
                $cond8 = 'Factureclient.source ="' . $facturationblid . '"';
//                debug($cond8);
                $l = 0;
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____" && (!empty($this->request->data['Recherche']['date1']))) { //debug('a');
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $cond1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
                $cond4 = "";
                $l = 0;
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" && (!empty($this->request->data['Recherche']['date2']))) { //debug('b');
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $cond2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
                $cond4 = "";
                $l = 0;
            }

            if ($this->request->data['Recherche']['client_id']) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $cond3 = 'Factureclient.client_id =' . $clientid;
                $l = 0;
            }

            if ($this->request->data['Recherche']['numeroconca1']) {
                $numeroconca1 = $this->request->data['Recherche']['numeroconca1'];
                $cond11 = 'Factureclient.numeroconca >=' . $numeroconca1;
            }
            if ($this->request->data['Recherche']['numeroconca2']) {
                $numeroconca2 = $this->request->data['Recherche']['numeroconca2'];
                $cond12 = 'Factureclient.numeroconca <=' . $numeroconca2;
            }


            $this->loadModel('Utilisateur');
            $this->loadModel('Pointdevente');
            $this->loadModel('Societe');
            $this->loadModel('Personnel');




            $cond7 = 'Factureclient.pointdevente_id =2';



        $factureclients = $this->Factureclient->find('all', array(
            'conditions' => array( @$pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, @$cond8, @$cond9, @$cond10,@$cond11,@$cond12)
            , 'order' => array('Factureclient.numero' => 'desc')
            , 'recursive' => 0
            ,'contain'=>array('Client')

        ));
        CakeSession::write('impression_automatique_flexible', $factureclients);
        //debug($factureclients);die;
        }

        $this->loadModel('Typedipliquation');
        $typedipliquations = $this->Typedipliquation->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array('conditions' => array('Client.societe' => $composantsoc)));
        $facturationbls['bl'] = "Facturation des BL";
        $facturationbls['fac'] = "Facturation Direct";
        $societes = $this->Societe->find('list', array('conditions' => array('Societe.id in (' . $soc . ')')));
        $pointdeventes = $this->Pointdevente->find('list');
        $this->set(compact('fac_id', 'facturationbls', 'typedipliquations', 'societes', 'pointdeventes', 'pointdevente_id', 'societe_id', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'factureclients'));
    }

    public function imprimerhaithammatricielle_equipement_auto( $model = null, $ligne_model = null, $attribut = null, $droit = null, $designation = null) {


        $model = $this->encrypt_decrypt(urldecode(stripslashes($model)));
        $ligne_model = $this->encrypt_decrypt(urldecode(stripslashes($ligne_model)));
        $attribut = $this->encrypt_decrypt(urldecode(stripslashes($attribut)));
        $droit = $this->encrypt_decrypt(urldecode(stripslashes($droit)));
        $designation = $this->encrypt_decrypt(urldecode(stripslashes($designation)));


        $this->response->type('pdf');
        $this->layout = 'pdf';
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == $droit) {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($ligne_model);
        $this->loadModel($model);

        $factureclients = CakeSession::read('impression_automatique_equipement');

//        $lignefactureclientstva = $this->$ligne_model->find('all', array('fields' => array(
//                'SUM(' . $ligne_model . '.totalht*' . $ligne_model . '.tva)/100  mtva'
//                , 'SUM(' . $ligne_model . '.totalht) totalht'
//                , 'AVG(' . $ligne_model . '.tva) tva'),
//            'conditions' => array($ligne_model . '.' . $attribut => $id)
//            , 'group' => array($ligne_model . '.tva')
//        ));
        //debug($factureclient)  ;die;
        $this->set(compact('factureclients', 'lignefactureclients', 'lignefactureclientstva','model', 'ligne_model', 'attribut', 'droit', 'designation'));
    }
    public function impression_automatique_equipement() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
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

        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $cond4 = 'Factureclient.exercice_id =' . $exe;



        $soc = CakeSession::read('soc');

        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Factureclients"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Recherche']);
            } else {
                $this->request->data['Recherche'] = CakeSession::read('recherche');
            }
            //debug($this->request->data);
            if ($this->request->data['Recherche']['exercice_id']) {
                // debug("ex");
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $cond4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
                $l = 0;
            }
            if (!empty($this->request->data['Recherche']['facturationbl_id'])) {
                $facturationblid = $this->request->data['Recherche']['facturationbl_id'];
                $cond8 = 'Factureclient.source ="' . $facturationblid . '"';
//                debug($cond8);
                $l = 0;
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____" && (!empty($this->request->data['Recherche']['date1']))) { //debug('a');
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $cond1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
                $cond4 = "";
                $l = 0;
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" && (!empty($this->request->data['Recherche']['date2']))) { //debug('b');
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $cond2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
                $cond4 = "";
                $l = 0;
            }

            if ($this->request->data['Recherche']['client_id']) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $cond3 = 'Factureclient.client_id =' . $clientid;
                $l = 0;
            }
            if ($this->request->data['Recherche']['numeroconca1']) {
                $numeroconca1 = $this->request->data['Recherche']['numeroconca1'];
                $cond11 = 'Factureclient.numeroconca >=' . $numeroconca1;
            }
            if ($this->request->data['Recherche']['numeroconca2']) {
                $numeroconca2 = $this->request->data['Recherche']['numeroconca2'];
                $cond12 = 'Factureclient.numeroconca <=' . $numeroconca2;
            }

            $this->loadModel('Utilisateur');
            $this->loadModel('Pointdevente');
            $this->loadModel('Societe');
            $this->loadModel('Personnel');




            $cond7 = 'Factureclient.pointdevente_id =1';



//        $factureclients = $this->Factureclient->find('all', array(
//            'conditions' => array( @$pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, @$cond8, @$cond9, @$cond10)
//            , 'order' => array('Factureclient.numero' => 'desc')
//            , 'recursive' => 2
//            , 'contain' => array('Client','Lignefactureclient','Lignefactureclient.Article','Lignefactureclient.Bonlivraison')
//        ));
            $factureclients = $this->Factureclient->find('all', array(
            'conditions' => array( @$pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, @$cond8, @$cond9, @$cond10, @$cond11, @$cond12)
            , 'order' => array('Factureclient.numero' => 'desc')
            , 'recursive' => 0
            ,'contain'=>array('Client')

        ));
        CakeSession::write('impression_automatique_equipement', $factureclients);
        //debug($factureclients);die;
        }

        $this->loadModel('Typedipliquation');
        $typedipliquations = $this->Typedipliquation->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array('conditions' => array( 'Client.societe' => $composantsoc)));
        $facturationbls['bl'] = "Facturation des BL";
        $facturationbls['fac'] = "Facturation Direct";
        $societes = $this->Societe->find('list', array('conditions' => array('Societe.id in (' . $soc . ')')));
        $pointdeventes = $this->Pointdevente->find('list');
        $this->set(compact('fac_id', 'facturationbls', 'typedipliquations', 'societes', 'pointdeventes', 'pointdevente_id', 'societe_id', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'factureclients'));
    }

    public function impression_automatique() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Client');
        $this->loadModel('Article');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Mois');
        $this->loadModel('Typedipliquation');
        $pointdeventes = $this->Pointdevente->find('list');
        $mois = $this->Mois->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $cond4 = 'Factureclient.exercice_id =' . $exe;
        $pv = "";
        $pvv = 0;
        $p = CakeSession::read('pointdevente');
        //debug($p);die;
        if ($p > 0) {
            $pv = 'Factureclient.pointdevente_id = ' . $p;
        }
        $facture = array();
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Factureclients"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {

                CakeSession::write('recherche', $this->request->data['Factureclient']);
            } else {
                $this->request->data['Factureclient'] = CakeSession::read('recherche');
            }
            debug($this->request->data);
//            die;
            $data = $this->request->data['Factureclient'];
//                debug($data['model']);die;
            $mod = $this->Typedipliquation->find('first', array(
                'conditions' => array('Typedipliquation.id' => $data['model'])
            ));
            $model = $mod['Typedipliquation']['name'];
            $ligne_model = $mod['Typedipliquation']['ligne'];
            $attribut = $mod['Typedipliquation']['attrb'];
            $this->loadModel($model);
            $this->loadModel($ligne_model);
            if ($this->request->data['Factureclient']['facture'] == 'recherche') {

                $cond1 = "";
                $cond2 = "";
                $cond3 = "";
                $condnumd = "";
                $condnumf = "";
                if ($this->request->data['Factureclient']['date1'] != "__/__/____") {
                    $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureclient']['date1'])));
                    $cond1 = $model . '.date >= ' . "'" . $date1 . "'";
                }
                if ($this->request->data['Factureclient']['date2'] != "__/__/____") {
                    $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureclient']['date2'])));
                    $cond2 = $model . '.date <= ' . "'" . $date2 . "'";
                }

                if ($this->request->data['Factureclient']['pointdevente_id']) {
                    $pv = $this->request->data['Factureclient']['pointdevente_id'];
                    $condpv = $model . '.pointdevente_id =' . $pv;
                }
                if (!empty($this->request->data['Factureclient']['bl_debut'])) {
                    $numd = $this->request->data['Factureclient']['bl_debut'];
                    $condnumd = $model . '.numeroconca >= ' . $numd;
                }

                if (!empty($this->request->data['Factureclient']['bl_fin'])) {
                    $numf = $this->request->data['Factureclient']['bl_fin'];
                    $condnumf = $model . '.numeroconca <=' . $numf;
                }
                if (!empty($this->request->data['Factureclient']['clientdebut'])) {
                    $clientd = $this->request->data['Factureclient']['clientdebut'];
                    $clientdeb = $this->Client->find('first', array('conditions' => array('Client.id' => $clientd), 'recursive' => -1));
                    //$cond3 = $model . '.client_id =' . $clientd;
                    $condcld = 'Client.code >=' . $clientdeb['Client']['code'];
                }

                if (!empty($this->request->data['Factureclient']['clientfin'])) {
                    $clientf = $this->request->data['Factureclient']['clientfin'];
                    $clientfin = $this->Client->find('first', array('conditions' => array('Client.id' => $clientf), 'recursive' => -1));
                    //$cond3 = 'Factureclient.client_id =' . $clientf;
                    $condclf = 'Client.code <=' . $clientfin['Client']['code'];
                }
//                if (empty($clientd)) {
//                    $clients = $this->$model->find('all', array(
//                        'fields' => array($model . '.client_id'),
//                        'conditions' => array($condpv, $cond1, $cond2, $condnumd, $condnumf),
//                        'order' => array($model . '.client_id' => 'ASC'),
//                        'group' => array($model . '.client_id'),
//                        'contain' => array('Client'),
//                        'recursive' => -1
//                    ));
////                    debug($clients);die;
//                } else {
//                    $clients = $this->Client->find('all', array(
//                        'conditions' => array($condcld, $condclf),
//                        'recursive' => -1,
//                        'fields' => array('Client.id'),
//                        'order' => array('Client.id ASC')));
////                     debug($clients);die;
//                }
////                $f = $this->Lignefactureclient->find('all');
////                debug($f);
////                die;
                $this->loadModel('Timbre');
                $i = 0;
                //foreach ($clients as $k => $cl) {
                //$condclient = $model . '.client_id =' . $cl['Client']['id'];
                $facture = $this->$model->find('all', array(
                    'conditions' => array(@$condpv, @$cond1, @$cond2, @$condnumd, @$condnumf, @$condcld, @$condclf),
                    'order' => array($model . '.numero' => 'asc'),
                    'contain' => array('Client'),
                    'recursive' => 0
                ));

                //$facture[$k] = $factureclients;
                // }
//                debug($factureclients);die;

                CakeSession::write('impression_automatique', $facture);
                CakeSession::write('pv', $pv);
            }
        }
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $clientdebuts = $clientfins = $this->Client->find('list', array(
            'conditions' => array()
        ));
        $blfactures = array();
        $blfactures[1] = "Oui";
        $blfactures[2] = "Non";

        $models = $this->Typedipliquation->find('list', array(
            'conditions' => array('Typedipliquation.id < 5'),
            'fields' => array('Typedipliquation.id', 'Typedipliquation.designation')
        ));
        $pointdeventees = $this->Pointdevente->find('list');
        $this->set(compact('attribut', 'ligne_model', 'model', 'models', 'facture', 'clientfins', 'clientdebuts', 'soummebonlivraisons', 'pointdeventees', 'pvv', 'mois', 'blfactures', 'typedipliquations', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'bonlivraisons'));
    }

    public function impauto() {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Article');
        $factures = CakeSession::read('facture_automatique');
        $articles = $this->Article->find('list');
        $depots = $this->Depot->find('list');
        $this->loadModel('Lignefactureclient');
        $this->set(compact('factures', 'depots', 'articles'));
    }

    public function imprimer_tout() {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Depot');
        $this->loadModel('Article');
        $factures = CakeSession::read('impression_automatique');
        //debug($factures);die;
//        $articles = $this->Article->find('list');
        $depots = $this->Depot->find('list');
        $this->loadModel('Lignefactureclient');
        $this->set(compact('factures', 'depots', 'articles'));
    }

    public function index($id = Null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
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
        $cond4 = 'Factureclient.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        //debug($p);
        if ($p > 0) {
            $pv = 'Factureclient.pointdevente_id = ' . $p;
        }

        $l = 100;
        $soc = CakeSession::read('soc');
        if ($id) {
            $cond9 = "Factureclient.id=" . $id;
            // debug($cond8);die;
        } else {
//            $date = date('Y-m-d');
//            $cond1 = 'Factureclient.date >= ' . "'" . $date . "'";
//            $cond2 = 'Factureclient.date <= ' . "'" . $date . "'";
//            $cond4 = "";
//            $date1 = $date;
//            $date2 = $date;
            $limit = 100;
        }
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Factureclients"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Recherche']);
            } else {
                $this->request->data['Recherche'] = CakeSession::read('recherche');
            }
            //debug($this->request->data);
            if ($this->request->data['Recherche']['exercice_id']) {
                // debug("ex");
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $cond4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
                $l = 0;
            }
            if (!empty($this->request->data['Recherche']['facturationbl_id'])) {
                $facturationblid = $this->request->data['Recherche']['facturationbl_id'];
                $cond8 = 'Factureclient.source ="' . $facturationblid . '"';
//                debug($cond8);
                $l = 0;
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____" && (!empty($this->request->data['Recherche']['date1']))) { //debug('a');
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $cond1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
                $cond4 = "";
                $l = 0;
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" && (!empty($this->request->data['Recherche']['date2']))) { //debug('b');
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $cond2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
                $cond4 = "";
                $l = 0;
            }

            if ($this->request->data['Recherche']['client_id']) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $cond3 = 'Factureclient.client_id =' . $clientid;
                $l = 0;
            }


            $this->loadModel('Utilisateur');
            $this->loadModel('Pointdevente');
            $this->loadModel('Societe');
            $this->loadModel('Personnel');
            if ($this->request->data['Recherche']['societe_id']) {
                $societe_id = $this->request->data['Recherche']['societe_id'];
                $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
                $ch_pv = 0;
                foreach ($lespvs as $lespv) {
                    $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
                }
                $cond6 = 'Factureclient.pointdevente_id in (' . $ch_pv . ')';
                $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societe_id)));
                $l = 0;
            }


            if ($this->request->data['Recherche']['pointdevente_id']) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                $cond7 = 'Factureclient.pointdevente_id =' . $pointdevente_id;
                $l = 0;
            }
            if ($this->request->data['Recherche']['fac_id']) {
                $fac_id = $this->request->data['Recherche']['fac_id'];
                $cond10 = 'Factureclient.id =' . $fac_id;
                $cond4 = "";
            }
            $limit = 1000000;
        }//die;
        $factureclients = $this->Factureclient->find('all', array(
            'conditions' => array(@$pv, @$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, @$cond8, @$cond9, @$cond10)
            , 'order' => array('Factureclient.id' => 'desc')
            , 'limit' => @$limit
            , 'recursive' => -1
                // , 'contain' => array('Client')
        ));


        $this->loadModel('Typedipliquation');
        $typedipliquations = $this->Typedipliquation->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $facturationbls['bl'] = "Facturation des BL";
        $facturationbls['fac'] = "Facturation Direct";
        $societes = $this->Societe->find('list', array('conditions' => array('Societe.id in (' . $soc . ')')));
//        if (isset($date1)) {
//            $this->request->data['Recherche']['date1'] = date("d/m/Y", strtotime(str_replace('/', '-', $date1)));
//        }
//        if (isset($date2)) {
//            $this->request->data['Recherche']['date2'] = date("d/m/Y", strtotime(str_replace('/', '-', $date2)));
//        }
        $this->set(compact('fac_id', 'facturationbls', 'typedipliquations', 'societes', 'pointdeventes', 'pointdevente_id', 'societe_id', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'factureclients'));
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
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
            $cond1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            $cond3 = 'Factureclient.client_id =' . $clientid;
        }

        $this->loadModel('Utilisateur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $this->loadModel('Personnel');
        if ($this->request->query['societe_id']) {
            $societe_id = $this->request->query['societe_id'];
            $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
            $ch_pv = 0;
            foreach ($lespvs as $lespv) {
                $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
            }
            $cond6 = 'Factureclient.pointdevente_id in (' . $ch_pv . ')';
        }

        if ($this->request->query['pointdevente_id']) {
            $pointdevente_id = $this->request->query['pointdevente_id'];
            $cond7 = 'Factureclient.pointdevente_id =' . $pointdevente_id;
        }
        if ($this->request->query['fac_id']) {
            $fac_id = $this->request->query['fac_id'];
            $cond8 = 'Factureclient.id =' . $fac_id;
            $cond1 = "";
            $cond2 = "";
        }

        $factureclients = $this->Factureclient->find('all', array('conditions' => array('Factureclient.id > ' => 0, @$cond1, @$cond2, @$cond3, @$cond6, @$cond7, @$cond8)));
//        debug($factureclients);die;
        $this->set(compact('factureclients', 'date1', 'date2', 'clientid'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
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
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Lignelivraison');
        if (!$this->Factureclient->exists($id)) {
            throw new NotFoundException(__('Invalid factureclient'));
        }


        if ($this->request->is('post')) {
            // //debug($this->request->data);die;
            $remiseajout = 0;
            $tvaajout = 0;
            $totalhtajout = 0;
            $totalttcajout = 0;
            $remisesup = 0;
            $tvasup = 0;
            $totalhtsup = 0;
            $totalttcsup = 0;
            $tab['id'] = $id;
            $tab['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureclient']['date'])));
            $numeros = explode('/', $this->request->data['Factureclient']['numero']);
            $tab['numero'] = $this->request->data['Factureclient']['numero'];
            $tab['numeroconca'] = $numeros[1];
            $this->Factureclient->save($tab);
            $this->misejour("Factureclient", "edit", $id);

            if ($this->request->data['Factureclient']['blfacturesup_id'] != '') {
                $this->Bonlivraison->updateAll(
                        array('Bonlivraison.factureclient_id' => 0), array('Bonlivraison.id'=>$this->request->data['Factureclient']['blfacturesup_id'])
                );
            }

             if ($this->request->data['Factureclient']['blfacturesup_id'] != '') {
            $this->Lignefactureclient->deleteAll(array('Lignefactureclient.bonlivraison_id'=>$this->request->data['Factureclient']['blfacturesup_id']), false);
             }

            if ($this->request->data['Factureclient']['blfacture_id'] != '') {
                foreach (@$this->request->data['Factureclient']['blfacture_id'] as $a) {
                    $dbl = $this->Bonlivraison->find('first', array('conditions' => array('Bonlivraison.id' => $a), 'contain' => array('Lignelivraison'), 'recursive' => 0));


                        $this->Bonlivraison->updateAll(
                                array('Bonlivraison.factureclient_id' => $id), array('Bonlivraison.id'=>$a)
                        );



                        foreach ($dbl['Lignelivraison'] as $d) { //debug($d);die;
                            $Lignefactureclients = array();
                            $Lignefactureclients['bonlivraison_id'] = $a;
                            $Lignefactureclients['factureclient_id'] = $id;
                            $Lignefactureclients['article_id'] = $d['article_id'];
                            $Lignefactureclients['depot_id'] = $d['depot_id'];
                            $Lignefactureclients['quantite'] = $d['quantite'];
                            $Lignefactureclients['remise'] = $d['remise'];
                            $Lignefactureclients['tva'] = $d['tva'];
                            $Lignefactureclients['prix'] = $d['prix'];
                            $Lignefactureclients['prixnet'] = $d['prixnet'];
                            $Lignefactureclients['puttc'] = $d['puttc'];
                            $Lignefactureclients['totalhtans'] = $d['totalhtans'];
                            $Lignefactureclients['designation'] = $d['designation'];
                            $Lignefactureclients['totalht'] = $d['totalht'];
                            $Lignefactureclients['totalttc'] = $d['totalttc'];
                            $Lignefactureclients['depotcomposee'] = $d['depotcomposee'];
                            $Lignefactureclients['pmp'] = $d['pmp'];
                            $Lignefactureclients['margebase'] = $d['margebase'];
                            $Lignefactureclients['prixachatmarge'] = $d['prixachatmarge'];
                            $Lignefactureclients['composee'] = 0;

                            $this->Lignefactureclient->create();
                            $this->Lignefactureclient->save($Lignefactureclients);

                    }
                }
            }
            $this->loadModel('Client');
            $this->loadModel('Timbre');
            $timbres = $this->Timbre->find('first', array('recursive' => -1));
            $timbremnt = $timbres['Timbre']['timbre'];
            $factureclients = $this->Factureclient->find('first', array('conditions' => array('Factureclient.id' => $id)));
            $clt = $this->Client->find('first', array('conditions' => array('Client.id' =>$factureclients['Factureclient']['client_id']), 'recursive' => -1));
            if ($clt['Client']['avectimbre_id'] == 'Non') {
                $timbremnt = 0;
            }


            $detailfac = $this->Bonlivraison->find('all', array('conditions' => array('Bonlivraison.factureclient_id' => $id), 'fields' => array('SUM(Bonlivraison.remise) as remise', 'SUM(Bonlivraison.tva) as tva', 'SUM(Bonlivraison.totalht) as totalht', 'SUM(Bonlivraison.totalttc) as totalttc'), 'recursive' => -1));
            if ($detailfac != array()) {
                if ($detailfac[0][0]['remise'] != NULL) {
                    $remisesup = $detailfac[0][0]['remise'];
                }
                if ($detailfac[0][0]['tva'] != NULL) {
                    $tvasup = $detailfac[0][0]['tva'];
                }
                if ($detailfac[0][0]['totalht'] != NULL) {
                    $totalhtsup = $detailfac[0][0]['totalht'];
                }
                if ($detailfac[0][0]['totalttc'] != NULL) {
                    $totalttcsup = $detailfac[0][0]['totalttc']+$timbremnt;
                }
            }
            $this->Factureclient->updateAll(
                    array('Factureclient.remise' => $remisesup,
                'Factureclient.tva' => $tvasup,
                'Factureclient.totalht' => $totalhtsup,
                'Factureclient.totalttc' => $totalttcsup)
                    , array('Factureclient.id' => $id)
            );
            $this->Session->setFlash(__('The Factureclient has been saved'));
            $this->redirect(array('action' => 'view/' . $id));
        }


        $factureclients = $this->Factureclient->find('first', array(
            'conditions' => array('Factureclient.id' => $id))); //debug($factureclients);//die;

        if ($factureclients['Factureclient']['source'] == 'bl') {
            $lignefactureclients = $this->Lignefactureclient->find('all', array(
                'conditions' => array('Lignefactureclient.factureclient_id' => $id)
                , 'order' => array('Lignefactureclient.bonlivraison_id' => 'asc')));
        } else {
            $lignefactureclients = $this->Lignefactureclient->find('all', array(
                'conditions' => array('Lignefactureclient.factureclient_id' => $id)));
        }
        $composantsoc = CakeSession::read('composantsoc');
//        $clients = $this->Client->find('list', array(
//            'conditions' => array('Client.etat' => 1, 'Client.societe' => $composantsoc)
//        ));
//        $pointdeventes = $this->Pointdevente->find('list');
        $blfacturesups = $this->Bonlivraison->find('list', array('conditions' => array('Bonlivraison.factureclient_id' => $id), 'fields' => array('Bonlivraison.numero')));

        $cond = '(Bonlivraison.factureclient_id=0 or Bonlivraison.factureclient_id IS NULL)';
        $blfactures = $this->Bonlivraison->find('list', array('conditions' => array($cond, 'Bonlivraison.client_id' => $factureclients['Factureclient']['client_id'], 'Bonlivraison.pointdevente_id' => $factureclients['Factureclient']['pointdevente_id']),'order'=>array('Bonlivraison.exercice_id'=>'desc','Bonlivraison.numeroconca'=>'desc'), 'fields' => array('Bonlivraison.numero')));

        $this->set(compact('pointdeventes', 'clients', 'factureclients', 'lignefactureclients', 'composantsoc', 'blfactures', 'blfacturesups'));
    }
    public function imprimertcpdf($id = null, $model = null, $ligne_model = null, $attribut = null, $droit = null, $designation = null) {


        $model = $this->encrypt_decrypt(urldecode(stripslashes($model)));
        $ligne_model = $this->encrypt_decrypt(urldecode(stripslashes($ligne_model)));
        $attribut = $this->encrypt_decrypt(urldecode(stripslashes($attribut)));
        $droit = $this->encrypt_decrypt(urldecode(stripslashes($droit)));
        $designation = $this->encrypt_decrypt(urldecode(stripslashes($designation)));


        //$this->response->type('pdf');
        $this->layout = '';
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == $droit) {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($ligne_model);
        $this->loadModel($model);

        $factureclient = $this->$model->find('first', array(
            'conditions' => array($model . '.id' => $id), 'recursive' => 0, 'contain' => array('Client')
        ));
        $lignefactureclients = $this->$ligne_model->find('all', array(
            'conditions' => array($ligne_model . '.' . $attribut => $id), 'contain' => array('Article','Bonlivraison')
        ));

        $lignefactureclientstva = $this->$ligne_model->find('all', array('fields' => array(
                'SUM(' . $ligne_model . '.totalht*' . $ligne_model . '.tva)/100  mtva'
                , 'SUM(' . $ligne_model . '.totalht) totalht'
                , 'AVG(' . $ligne_model . '.tva) tva'),
            'conditions' => array($ligne_model . '.' . $attribut => $id)
            , 'group' => array($ligne_model . '.tva')
        ));
        //debug($factureclient);debug($lignefactureclients);debug($lignefactureclientstva);die;
        $this->set(compact('factureclient', 'lignefactureclients', 'lignefactureclientstva', 'id', 'model', 'ligne_model', 'attribut', 'droit', 'designation'));
    }

    public function imprimer_ans($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefactureclient');
        if (!$this->Factureclient->exists($id)) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        $options = array('conditions' => array('Factureclient.' . $this->Factureclient->primaryKey => $id));
        $this->set('factureclient', $this->Factureclient->find('first', $options));
        $lignefactureclients = $this->Lignefactureclient->find('all', array(
            'conditions' => array('Lignefactureclient.factureclient_id' => $id)
        ));
        $lignefactureclientstva = $this->Lignefactureclient->find('all', array('fields' => array(
                'SUM(Lignefactureclient.totalht*Lignefactureclient.tva)/100  mtva'
                , 'SUM(Lignefactureclient.totalht) totalht'
                , 'AVG(Lignefactureclient.tva) tva'),
            'conditions' => array('Lignefactureclient.factureclient_id' => $id)
            , 'group' => array('Lignefactureclient.tva')
        ));
        //debug($lignefactureclientstva)  ;die;
        $this->set(compact('lignefactureclients', 'lignefactureclientstva'));
    }

    public function imprimerbl($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefactureclient');
        if (!$this->Factureclient->exists($id)) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        $options = array('conditions' => array('Factureclient.' . $this->Factureclient->primaryKey => $id));
        $this->set('factureclient', $this->Factureclient->find('first', $options));

        $lignefactureclients = $this->Lignefactureclient->find('all', array(
            'conditions' => array('Lignefactureclient.factureclient_id' => $id)
            , 'order' => array('Lignefactureclient.bonlivraison_id' => 'asc')));

        $lignefactureclientstva = $this->Lignefactureclient->find('all', array('fields' => array(
                'SUM(Lignefactureclient.totalht*Lignefactureclient.tva)/100  mtva'
                , 'SUM((Lignefactureclient.prix*(1-(Lignefactureclient.remise/100)))*Lignefactureclient.quantite) totalht'
                , 'AVG(Lignefactureclient.tva) tva'),
            'conditions' => array('Lignefactureclient.factureclient_id' => $id)
            , 'group' => array('Lignefactureclient.tva')
        ));
//        debug($lignefactureclientstva)  ;die;
        $this->set(compact('lignefactureclients', 'lignefactureclientstva'));
    }

    public function add($model = null, $ligne_model = null, $attribut = null,$facproforma= null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($model);
        $this->loadModel($ligne_model);
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        $this->loadModel('Client');
        $this->loadModel('Depot');
        $this->loadModel('Timbre');
        $this->loadModel('Client');
        $this->loadModel('Utilisateur');
        $this->loadModel('Articlecomposante');
        $this->loadModel('Typedipliquation');

        if ($this->request->is('post')) {
            //facture proforma
            if(!empty($facproforma)){
            $this->request->data['Devi']['proforma'] = 1;
            }





//            debug($this->request->data);
//            die;
            $model_base = $model;
//            debug($model_base);
            if (!empty($this->request->data[$model_base]['typedipliquation'])) {

                $typedipliquation = $this->Typedipliquation->find('first', array(
                    'conditions' => array('Typedipliquation.id' => $this->request->data[$model_base]['typedipliquation'])
                ));
                $model = $typedipliquation['Typedipliquation']['name'];
//                debug($model);
                $ligne_model = $typedipliquation['Typedipliquation']['ligne'];
                $attribut = $typedipliquation['Typedipliquation']['attrb'];
                $this->loadModel($model);
                $this->loadModel($ligne_model);
                $this->request->data[$model] = $this->request->data[$model_base];
//                debug($this->request->data);die;
				$pv = CakeSession::read('pointdevente');
                if ($pv == 0) {
                    $pv = $this->request->data[$model]['pointdevente_id'];
                }
                //debug($model);
                $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numeroconca) as num'),
                    'conditions' => array($model . '.pointdevente_id' => $pv, $model . '.exercice_id' => date("Y")))
                );
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
                //debug($mm);
                //debug($numspecial);
                $this->request->data[$model]['numeroconca'] = $mm;
                $this->request->data[$model]['numero'] = $numspecial;
            }


            $this->request->data[$model]['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            $this->request->data[$model]['utilisateur_id'] = CakeSession::read('users');
            $this->request->data[$model]['type'] = 'direct';
            if (empty($this->request->data[$model]['pointdevente_id'])) {
                $this->request->data[$model]['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data[$model]['exercice_id'] = date("Y", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            if (empty($this->request->data[$model]['timbre_id'])) {
                $this->request->data[$model]['timbre_id'] = 0;
            }
//******** zeinab ****************//
            $testnumero = $this->$model->find('count', array('conditions' => array($model . '.numero' => $this->request->data[$model]['numero'])));
            if ($testnumero == 1) {
                $pv = CakeSession::read('pointdevente');
                if ($pv == 0) {
                    $pv = $this->request->data[$model]['pointdevente_id'];
                }
                $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numeroconca) as num'),
                    'conditions' => array($model . '.pointdevente_id' => $pv, $model . '.exercice_id' => date("Y")))
                );
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

                $this->request->data[$model]['numeroconca'] = $mm;
                $this->request->data[$model]['numero'] = $numspecial;
            }
//*******************************//
            $numeros = explode('/', $this->request->data[$model]['numero']);
            $this->request->data[$model]['numeroconca'] = $numeros[1];
            $this->$model->create();
            if (!empty($this->request->data['Lignepiece'])) {
                if ($this->$model->save($this->request->data)) {
                    $id = $this->$model->id;
                    $this->misejour($model, "add", $id);
                    // debug($id);die;
                    $Lignefactureclients = array();
                    $stockdepots = array();
                    // debug($this->request->data );die;
                    foreach ($this->request->data['Lignepiece'] as $numl => $f) {
                        //debug($f);die;
                        if ($f['sup'] != 1) {
                            if ($f['article_id'] != "") {
                                $f['depot_id'] = $this->request->data[$model]['depot_id'];
                                $stockdepots[$numl]['quantite'] = $f['quantite'];
                                $Lignefactureclients[$attribut] = $id;
                                $Lignefactureclients['article_id'] = $this->request->data['Lignepiece'][$numl]['article_id'];
                                $f['article_id'] = $this->request->data['Lignepiece'][$numl]['article_id'];
                                $Lignefactureclients['depot_id'] = $f['depot_id'];
                                $Lignefactureclients['quantite'] = $f['quantite'];
                                $Lignefactureclients['remise'] = $f['remise'];
                                $Lignefactureclients['tva'] = $f['tva'];
                                $Lignefactureclients['prix'] = $f['prixhtva'];
                                $Lignefactureclients['prixnet'] = $f['prixnet'];
                                $Lignefactureclients['puttc'] = $f['puttc'];
                                $Lignefactureclients['totalhtans'] = $f['totalhtans'];
                                $Lignefactureclients['designation'] = $f['designation'];
                                $Lignefactureclients['totalht'] = $f['totalht'];
                                $Lignefactureclients['totalttc'] = $f['totalttc'];
                                $Lignefactureclients['depotcomposee'] = $f['depotcomposee'];
                                $Lignefactureclients['pmp'] = $f['pmp'];
                                if ($model == 'Factureclient' || $model == 'Bonlivraison') {
                                    $Lignefactureclients['margebase'] = $f['margebase'];
                                    $Lignefactureclients['prixachatmarge'] = $f['prixachatmarge'];
                                }
                                if ($f['type'] == 1) {
                                    $Lignefactureclients['composee'] = $f['type'];
                                } else {
                                    $Lignefactureclients['composee'] = 0;
                                }
                                // debug($Lignefactur $Lignefactureclients['composee'] = $f['type'];eclients);die;
                                $this->$ligne_model->create();
                                $this->$ligne_model->save($Lignefactureclients);

                                if (($model == "Factureclient") || ($model == "Bonlivraison")) {
                                    $qte_sorti = $f['quantite'];
                                    if ($f['type'] == 1) {
                                        $articlescomposantes = $this->Articlecomposante->find('all', array(
                                            'conditions' => array('Articlecomposante.article_id' => $f['article_id'])
                                        ));
                                        foreach ($articlescomposantes as $k => $articlescomposante) {
                                            $qte_vendu = $qte_sorti * $articlescomposante['Articlecomposante']['qte'];

                                        $testarticlecomposante = $this->Article->find('first', array(
                                            'conditions' => array('Article.id' =>$articlescomposante['Articlecomposante']['composant'])
                                        ));

                                        if ($testarticlecomposante['Article']['composee'] == 1) {

                                        $lesarticles_articlescomposantes = $this->Articlecomposante->find('all', array(
                                            'conditions' => array('Articlecomposante.article_id' =>$articlescomposante['Articlecomposante']['composant'])
                                        ));
                                        foreach ($lesarticles_articlescomposantes as $k => $lesarticles_articlescomposante) {
                                            $qte_vendu_articlecompose = $f['quantite'] *$articlescomposante['Articlecomposante']['qte'] * $lesarticles_articlescomposante['Articlecomposante']['qte'];

                                            $stckdepot = $this->Stockdepot->find('first', array(
                                                'conditions' => array('Stockdepot.article_id' => $lesarticles_articlescomposante['Articlecomposante']['composant'],
                                                    'Stockdepot.depot_id' => $f['depot_id']), false));
                                            if (!empty($stckdepot)) {
                                                $qte = $stckdepot['Stockdepot']['quantite'] - $qte_vendu_articlecompose;
                                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                            } else {
                                                $stkn = array();
                                                $stkn['depot_id'] = $f['depot_id'];
                                                $stkn['article_id'] = $lesarticles_articlescomposante['Articlecomposante']['composant'];
                                                $stkn['quantite'] = 0 - $qte_vendu_articlecompose;
                                                $this->Stockdepot->create();
                                                $this->Stockdepot->save($stkn);
                                            }



                                        }
                                        }else{


                                            $stckdepot = $this->Stockdepot->find('first', array(
                                                'conditions' => array('Stockdepot.article_id' => $articlescomposante['Articlecomposante']['composant'],
                                                    'Stockdepot.depot_id' => $f['depot_id']), false));
                                            if (!empty($stckdepot)) {
                                                $qte = $stckdepot['Stockdepot']['quantite'] - $qte_vendu;
                                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                            } else {
                                                $stkn = array();
                                                $stkn['depot_id'] = $f['depot_id'];
                                                $stkn['article_id'] = $articlescomposante['Articlecomposante']['composant'];
                                                $stkn['quantite'] = 0 - $qte_vendu;
                                                $this->Stockdepot->create();
                                                $this->Stockdepot->save($stkn);
                                            }
                                        }


                                        }
                                    } else {
                                        $stckdepot = $this->Stockdepot->find('first', array(
                                            'conditions' => array('Stockdepot.article_id' => $f['article_id'],
                                                'Stockdepot.depot_id' => $f['depot_id']), false));
                                        if (!empty($stckdepot)) {
                                            $qte = $stckdepot['Stockdepot']['quantite'] - $qte_sorti;
                                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                        } else {
                                            $stkn = array();
                                            $stkn['depot_id'] = $f['depot_id'];
                                            $stkn['article_id'] = $f['article_id'];
                                            $stkn['quantite'] = 0 - $qte_sorti;
                                            $this->Stockdepot->create();
                                            $this->Stockdepot->save($stkn);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if (($model == "Factureclient") || ($model == "Bonlivraison")) {
                    //$this->Client->updateAll(array('Client.modeclient_id' =>2), array('Client.id' =>$this->request->data[$model]['client_id']));
                    }
                    $this->Session->setFlash(__('The Factureclient has been saved'));
                    //$this->redirect(array('action' => 'index'));
                    if(!empty($facproforma)){
                    $action="indexx"  ;
                    }else{
                    $action="index"  ;
                    }
                    $this->redirect(array('controller' => $model . 's', 'action' => $action.'/' . $id));
                    //$this->redirect(array('action' => 'addbonsorti/'.$id));
                } else {
                    $this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                }
            }
        }

        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {
            $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numeroconca) as num'),
                'conditions' => array($model . '.pointdevente_id' => $pv, $model . '.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
//  $anne=$getexercice['Factureclient']['exercice_id'];
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
        $composantsoc = CakeSession::read('composantsoc');
//        $clients = $this->Client->find('list', array(
//            'conditions' => array('Client.etat' => 1, 'Client.societe' => $composantsoc), 'order' => array('Client.code' => 'asc')
//        ));
//		$composantsoc = CakeSession::read('composantsoc');
//        $matriculefiscales = $this->Client->find('list', array('fields' => array('Client.id','Client.matriculefiscale'),
//            'conditions' => array('Client.etat' => 1, 'Client.societe' => $composantsoc), 'order' => array('Client.code' => 'asc')
//        ));
        $utilisateurs = $this->Utilisateur->find('list');
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.id' => $p)));
        }
        $timbre = $this->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $typedipliquations = $this->Typedipliquation->find('list', array(
            'conditions' => array('Typedipliquation.id <' => 5),
            'fields' => array('Typedipliquation.id', 'Typedipliquation.name')
        ));
        //$articles = $this->Article->find('list', array('conditions' => array('Article.typeetatarticle_id' => 1), 'recursive' => -1));
        $this->set(compact('matriculefiscales','typedipliquations', 'model', 'articles', 'pointdeventes', 'clients', 'timbre', 'utilisateurs', 'depots', 'mm', 'numspecial'));
    }

    //jeya mel bonlivraison
    public function addindirect($tab = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['add'];
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
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Commande');
        $this->loadModel('Pointdevente');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Client');
        $this->loadModel('Reglementclient');
        $tbr = $tab . ',0)';
        list($idbr, $resteidbr) = explode(",", $tbr);
        $tbr = '(0,' . $tbr;
        $idbrs = array();

        $idlcs = explode(",", $tab);
        $clientid = $this->Bonlivraison->find('first', array('fields' => array('pointdevente_id', 'SUM(Bonlivraison.remise) remise', 'SUM(Bonlivraison.tva) tva', 'SUM(Bonlivraison.totalht) totalht'
                , 'SUM(Bonlivraison.totalttc) totalttc', 'AVG(Bonlivraison.client_id) client_id'), 'conditions' => array('Bonlivraison.id' => $idlcs), 'recursive' => 0));
        //debug($clientid);

        $lignelivraisons = $this->Lignelivraison->find('all', array('fields' => array('AVG(Lignelivraison.article_id) article_id', 'AVG(Lignelivraison.depot_id) depot_id', '(Lignelivraison.article_id) article_iddd', '(Lignelivraison.depot_id) depot_id', 'id'
                , 'SUM(Lignelivraison.quantite) quantite', 'SUM(Lignelivraison.remise*Lignelivraison.quantite) remise', 'SUM(Lignelivraison.prix*Lignelivraison.quantite) prix'
                , 'AVG(Lignelivraison.tva) tva', 'SUM(Lignelivraison.totalht) totalht', 'SUM(Lignelivraison.totalttc)totalttc', 'SUM(Lignelivraison.prixnet*Lignelivraison.quantite) prixnet', 'SUM(Lignelivraison.puttc*Lignelivraison.quantite) puttc')
            , 'conditions' => array('Lignelivraison.bonlivraison_id in' . $tbr), 'recursive' => 0
            , 'group' => array('Lignelivraison.article_id', 'Lignelivraison.depot_id')));
        //debug($lignelivraisons);die;
//             $reqclient = $this->Bonlivraison->find('first',array( 'conditions' => array('Bonlivraison.id'=>$idbr),'recursive'=>-2));
//             $lignefactures=$this->Lignelivraison->find('all', array( 'conditions' => array('Lignelivraison.bonlivraison_id in'.$tbr),'recursive'=>-2));
//             debug($reqclient);die;


        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $this->request->data['Factureclient']['fournisseur_id'] = $clientid[0]['client_id'];
            $this->request->data['Factureclient']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureclient']['date'])));
            $this->request->data['Factureclient']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureclient']['client_id'] = $clientid[0]['client_id'];
            $this->request->data['Factureclient']['type'] = 'indirect';
            $this->request->data['Factureclient']['source'] = 'bl';
            $this->request->data['Factureclient']['depot_id'] = '3';
            if (empty($this->request->data['Factureclient']['pointdevente_id'])) {
                $this->request->data['Factureclient']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Factureclient']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Factureclient']['pointdevente_id'];
            }
            $numero = $this->Factureclient->find('all', array('fields' => array('MAX(Factureclient.numeroconca) as num'),
                'conditions' => array('Factureclient.pointdevente_id' => $pv, 'Factureclient.exercice_id' => date("Y")))
            );
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
//  $anne=$getexercice['Factureclient']['exercice_id'];
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

            $this->request->data['Factureclient']['numeroconca'] = $mm;
            $this->request->data['Factureclient']['numero'] = $numspecial;
            // debug($this->request->data);die;
            $this->Factureclient->create();
            if ($this->Factureclient->save($this->request->data)) {
                $id = $this->Factureclient->id;
                $this->misejour("Factureclient", "add", $id);
                // inserer le facture_id dans les  bons de receptions cochés********************
                $idbrs = explode(",", $tab);
                //   debug($idbrs);die;
                foreach ($idbrs as $br) {
                    $this->Bonlivraison->updateAll(array('Bonlivraison.factureclient_id' => $id), array('Bonlivraison.id' => $br));
                }

                //debug($this->request->data['Lignefactureclient']);die;
                $Lignefactures = array();
                foreach ($this->request->data['Lignefactureclient'] as $numl => $f) {

                    //debug($f);die;
                    if ($f['sup'] != 1) {

                        $Lignefactures['factureclient_id'] = $id;
                        $Lignefactures['depot_id'] = $f['depot_id'];
                        $Lignefactures['article_id'] = $f['article_id'];
                        $Lignefactures['quantite'] = $f['quantite'];
                        $Lignefactures['prix'] = $f['prixhtva'];
                        $Lignefactures['remise'] = $f['remise'];
                        $Lignefactures['tva'] = $f['tva'];
                        $Lignefactures['prixnet'] = $f['prixnet'];
                        $Lignefactures['puttc'] = $f['puttc'];
                        $Lignefactures['totalhtans'] = $f['totalhtans'];
                        $Lignefactures['totalht'] = $f['totalht'];
                        $Lignefactures['totalttc'] = $f['totalttc'];
                        $this->Lignefactureclient->create();
                        $this->Lignefactureclient->save($Lignefactures);
                    }
                    //******************************************************************************************************************
                    if ($f['ans'] != 1) {
                        $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
                        if (!empty($stckdepot)) {
                            $stockdepots[$numl]['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] - $f['quantite'];
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                        }
                        // $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
                    }
                    //***************************************************************************************************************************
                    if ($f['ans'] == 1) {
                        $lignefactureanciens = $this->Lignelivraison->find('all', array('conditions' => array('Lignelivraison.id' => $f['id']), false));
                        foreach ($lignefactureanciens as $lr) {
                            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $lr['Lignelivraison']['article_id'], 'Stockdepot.depot_id' => $lr['Lignelivraison']['depot_id']), false));
                            if (!empty($stckdepot)) {
                                $stkdepqte['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] + $lr['Lignelivraison']['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stkdepqte['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                            } else {
                                $stkdepqte['quantite'] = $lr['Lignelivraison']['quantite'];
                                $stkdepqte['article_id'] = $lr['Lignelivraison']['article_id'];
                                $stkdepqte['depot_id'] = $lr['Lignelivraison']['depot_id'];
                                $this->Stockdepot->create();
                                $this->Stockdepot->save($stkdepqte);
                            }
                        }
                        $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
                        if (!empty($stckdepot)) {
                            $stockdepots[$numl]['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] - $f['quantite'];
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                        }
                        //$this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
                    }
                    //$this->stock($f['depot_id'], $f['article_id']);
                    //*****************************************************************************************************************************
                }

                $this->Session->setFlash(__('The facture has been saved'));
                //$this->redirect(array('action' => 'index'));
                //$this->redirect(array('controller' => $model . 's', 'action' => 'index'));
            } else {
                $this->Session->setFlash(__('The facture could not be saved. Please, try again.'));
            }
        }

        //*************************************************************************************************************************************
//          $lignefactureanciens= $this->Lignefactureclient->find('all',array('conditions'=>array('Lignefactureclient.factureclient_id'=>$id),false));
//                            foreach (  $lignefactureanciens as $lra   ){
//
//                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+'.$lra['Lignefactureclient']['quantite']), array('Stockdepot.article_id' =>$lra['Lignefactureclient']['article_id'],'Stockdepot.depot_id' =>$lra['Lignefactureclient']['depot_id']));
//                            }
//             $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false));
//                                if (!empty($stckdepot)){
//                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$stockdepots[$numl]['quantite'];
//                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
//                                   }
//                                   $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
        //**************************************trouver la liste des articles pour chaque depot *******************************************************
        /* foreach ($lignelivraisons as $ll) {
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
          } */

        //******************************************fin***********************************************************************************************************
        // debug($tabqtestock);die;
        //debug($tabqtestock['1.0000'][1]['qtestock']);die;


        $pv = CakeSession::read('pointdevente');
        if ($pv == 0) {
            $pv = $clientid['Bonlivraison']['pointdevente_id'];
        }
        $numero = $this->Factureclient->find('all', array('fields' => array('MAX(Factureclient.numeroconca) as num'),
            'conditions' => array('Factureclient.pointdevente_id' => $pv, 'Factureclient.exercice_id' => date("Y")))
        );
        //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        if (!empty($n)) {
//   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
//  $anne=$getexercice['Factureclient']['exercice_id'];
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




        $client = $this->Client->find('first', array('conditions' => array('Client.id' => $clientid[0]['client_id']), 'recursive' => -2));
        $pntv = $clientid['Bonlivraison']['pointdevente_id'];
        $client = $client['Client']['name'];
        $utilisateurs = $this->Factureclient->Utilisateur->find('list');
        $articles = $this->Article->find('list');
        $pointdeventes = $this->Pointdevente->find('list');
        $clients = $this->Factureclient->Client->find('list');
        $timbre = $this->Factureclient->Timbre->find('list', array('fields' => array('Timbre.timbre')));



        //****************************************************************************************************************************************************


        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Client');


        $client = $this->Client->find('all', array('conditions' => array('Client.id' => $clientid[0]['client_id']), false));
        $adresse = $client[0]['Client']['adresse'];
        $name = $client[0]['Client']['name'];
        $matriculefiscale = $client[0]['Client']['matriculefiscale'];
        $autorisation = $client[0]['Client']['autorisation'];
        $typeclient_id = $client[0]['Client']['typeclient_id'];

        $sumttc = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.totalttc) as totalttcb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid[0]['client_id'])));
        $summtreg = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.Montant_Regler) as totalregb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid[0]['client_id'])));
        $sumttcf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.totalttc) as totalttf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid[0]['client_id'])));
        $summtregf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.Montant_Regler) as totalregf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid[0]['client_id'])));
        $reglementlibre = $this->Reglementclient->find('all', array('fields' => array('sum(Reglementclient.Montant) as reglibretotale')
            , 'conditions' => array('Reglementclient.type ' => 1, 'Reglementclient.affectation_id  ' => 0, 'Reglementclient.client_id' => $clientid[0]['client_id'])));
        $valbl = $sumttc[0][0]['totalttcb'] - $summtreg[0][0]['totalregb'];
        $valfac = $sumttcf[0][0]['totalttf'] - $summtregf[0][0]['totalregf'];
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

        $tot = $clientid[0]['totalttc'] + $timbre[1];

        $vv = $this->Bonlivraison->find('first', array('conditions' => array('Bonlivraison.id in(' . $tab . ')'), 'recursive' => -1));
        $vente = $vv['Bonlivraison']['vente'];
        $this->set(compact('typeclient_id', 'name', 'vente', 'autorisation', 'solde', 'tot', 'clientid', 'tabqtestock', 'articles', 'depots', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'pntv', 'clients', 'client', 'utilisateurs', 'articles', 'mm', 'lignelivraisons', 'numspecial', 'timbre'));
    }

    // jeya mel commande
    public function addfacindirect($tab = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        // debug($tab);die;
        $this->loadModel('Pointdevente');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignecommandeclient');
        $this->loadModel('Commandeclient');
        $this->loadModel('Client');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
        $this->loadModel('Reglementclient');
        $tbr = $tab . ',0)';
        list($idbr, $resteidbr) = explode(",", $tbr);
        $tbr = '(0,' . $tbr;
        // debug($idbr);die;
        $idlcs = array();
        $idlcs = explode(",", $tab);

        $clientid = $this->Commandeclient->find('first', array('fields' => array('pointdevente_id', 'SUM(Commandeclient.remise) remise', 'SUM(Commandeclient.tva) tva', 'SUM(Commandeclient.totalht) totalht'
                , 'SUM(Commandeclient.totalttc) totalttc', 'AVG(Commandeclient.client_id) client_id'), 'conditions' => array('Commandeclient.id' => $idlcs), 'recursive' => -2));
        //debug($clientid);die;

        $lignelivraisons = $this->Lignecommandeclient->find('all', array('fields' => array('AVG(Lignecommandeclient.article_id) article_id', 'AVG(Lignecommandeclient.depot_id) depot_id', '(Lignecommandeclient.article_id) article_iddd', '(Lignecommandeclient.depot_id) depot_id'
                , 'SUM(Lignecommandeclient.quantite) quantite', 'SUM(Lignecommandeclient.remise*Lignecommandeclient.quantite) remise', 'SUM(Lignecommandeclient.prix*Lignecommandeclient.quantite) prix'
                , 'AVG(Lignecommandeclient.tva) tva', 'SUM(Lignecommandeclient.totalht) totalht', 'SUM(Lignecommandeclient.totalttc)totalttc', 'SUM(Lignecommandeclient.prixnet*Lignecommandeclient.quantite) prixnet', 'SUM(Lignecommandeclient.puttc*Lignecommandeclient.quantite) puttc')
            , 'conditions' => array('Lignecommandeclient.commandeclient_id in' . $tbr), 'recursive' => -2
            , 'group' => array('Lignecommandeclient.article_id', 'Lignecommandeclient.depot_id')));

        //debug($clientid);debug($lignelivraisons);die;

        if ($this->request->is('post')) {
            // debug($this->request->data);die;
            $this->request->data['Factureclient']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureclient']['date'])));
            $this->request->data['Factureclient']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureclient']['client_id'] = $clientid[0]['client_id'];
            $this->request->data['Factureclient']['type'] = 'direct';
            if (empty($this->request->data['Factureclient']['pointdevente_id'])) {
                $this->request->data['Factureclient']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Factureclient']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Factureclient']['pointdevente_id'];
            }
            $numero = $this->Factureclient->find('all', array('fields' => array('MAX(Factureclient.numeroconca) as num'),
                'conditions' => array('Factureclient.pointdevente_id' => $pv, 'Factureclient.exercice_id' => date("Y")))
            );
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
//  $anne=$getexercice['Factureclient']['exercice_id'];
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

            $this->request->data['Factureclient']['numeroconca'] = $mm;
            $this->request->data['Factureclient']['numero'] = $numspecial;
            //debug($this->request->data);die;
            $this->Factureclient->create();
            if (!empty($this->request->data['Lignefactureclient'])) {
                if ($this->Factureclient->save($this->request->data)) {
                    foreach ($idlcs as $idc) {
                        $this->Commandeclient->updateAll(array('Commandeclient.etat' => 1), array('Commandeclient.id' => $idc));
                    }
                    $id = $this->Factureclient->id;
                    $this->misejour("Factureclient", "add", $id);
                    $Lignelivraisons = array();
                    $stockdepots = array();
                    foreach ($this->request->data['Lignefactureclient'] as $numl => $f) {

                        //  debug($f);die;
                        if ($f['sup'] != 1) {

                            $stockdepots[$numl]['quantite'] = $f['quantite'];
                            $Lignefactures['factureclient_id'] = $id;
                            $Lignefactures['depot_id'] = $f['depot_id'];
                            $Lignefactures['article_id'] = $f['article_id'];
                            $Lignefactures['quantite'] = $f['quantite'];
                            $Lignefactures['remise'] = $f['remise'];
                            $Lignefactures['tva'] = $f['tva'];
                            $Lignefactures['prix'] = $f['prixhtva'];
                            $Lignefactures['prixnet'] = $f['prixnet'];
                            $Lignefactures['puttc'] = $f['puttc'];
                            $Lignefactures['totalhtans'] = $f['totalhtans'];
                            $Lignefactures['totalht'] = $f['totalht'];
                            $Lignefactures['totalttc'] = $f['totalttc'];
                            $this->Lignefactureclient->create();
                            $this->Lignefactureclient->save($Lignefactures);



                            $lignecommandeclients = $this->Lignecommandeclient->find('all', array(
                                'conditions' => array('Lignecommandeclient.commandeclient_id in' . $tbr, 'Lignecommandeclient.article_id' => $f['article_id']), 'recursive' => -1
                            ));
                            $int = $f['quantite'];
                            foreach ($lignecommandeclients as $n => $lbl) {
                                $reste = $lbl['Lignecommandeclient']['quantite'] - $lbl['Lignecommandeclient']['quantiteliv'];
                                if ($int > 0) {
                                    if ($reste >= $int) {
                                        $qtee = $int;
                                        $int = 0;
                                    }
                                    if ($reste < $int) {
                                        $qtee = $reste;
                                        $int = $int - $reste;
                                    }
                                    $this->Lignecommandeclient->updateAll(array('Lignecommandeclient.quantiteliv' => 'Lignecommandeclient.quantiteliv +' . $qtee), array('Lignecommandeclient.id' => $lbl['Lignecommandeclient']['id']));
                                }
                            }


                            $id_ligne = $this->Lignefactureclient->id;
                            $qte_sorti = $f['quantite'];
                            while ($qte_sorti > 0) {
                                $stckdepot = $this->Stockdepot->find('first', array(
                                    'conditions' => array('Stockdepot.article_id' => $f['article_id'],
                                        'Stockdepot.depot_id' => $f['depot_id'], 'Stockdepot.quantite >' => 0), false));
                                //debug($stckdepot);
                                if ($qte_sorti < $stckdepot['Stockdepot']['quantite']) {
                                    $qte = $stckdepot['Stockdepot']['quantite'] - $qte_sorti;
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    $this->loadModel('Stockdepotfacture');
                                    $tab = array();
                                    $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                    $tab['id_piece'] = $id;
                                    $tab['piece'] = "Factureclient";
                                    $tab['qte'] = $qte_sorti;
                                    $tab['ligne'] = $id_ligne;
                                    $this->Stockdepotfacture->create();
                                    $this->Stockdepotfacture->save($tab);
                                    $qte_sorti = 0;
                                } else {
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 0), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    $qte_sorti = $qte_sorti - $stckdepot['Stockdepot']['quantite'];
                                    $this->loadModel('Stockdepotfacture');
                                    $tab = array();
                                    $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                    $tab['id_piece'] = $id;
                                    $tab['piece'] = "Factureclient";
                                    $tab['ligne'] = $id_ligne;
                                    $tab['qte'] = $stckdepot['Stockdepot']['quantite'];
                                    $this->Stockdepotfacture->create();
                                    $this->Stockdepotfacture->save($tab);
                                }
                            }









//                            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
//                            if (!empty($stckdepot)) {
//                                $stockdepots[$numl]['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] - $stockdepots[$numl]['quantite'];
//                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
//                            }
                            //$this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
                            //$this->stock($f['depot_id'], $f['article_id']);
                        }
                    }
                    $this->Session->setFlash(__('The bonlivraison has been saved'));
                    //$this->redirect(array('action' => 'addbonsorti/'.$id));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                }
            }
        }

        $pv = CakeSession::read('pointdevente');
        if ($pv == 0) {
            $pv = $clientid['Commandeclient']['pointdevente_id'];
        }
        $numero = $this->Factureclient->find('all', array('fields' => array('MAX(Factureclient.numeroconca) as num'),
            'conditions' => array('Factureclient.pointdevente_id' => $pv, 'Factureclient.exercice_id' => date("Y")))
        );
        //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        if (!empty($n)) {
//   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
//  $anne=$getexercice['Factureclient']['exercice_id'];
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
          } */

        //******************************************fin***********************************************************************************************************
        // debug($tabqtestock);die;
        //debug($tabqtestock['1.0000'][1]['qtestock']);die;




        $client = $this->Client->find('first', array('conditions' => array('Client.id' => $clientid[0]['client_id']), 'recursive' => -2));
        $pntv = $clientid['Commandeclient']['pointdevente_id'];
        $client = $client['Client']['name'];
        $utilisateurs = $this->Factureclient->Utilisateur->find('list');
        //$articles = $this->Article->find('list');
        $timbre = $this->Factureclient->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        //debug($timbre);die;
        $pointdeventes = $this->Pointdevente->find('list');
        $clients = $this->Factureclient->Client->find('list');

        //****************************************************************************************************************************************************


        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Client');


        $client = $this->Client->find('all', array('conditions' => array('Client.id' => $clientid[0]['client_id']), false));
        $adresse = $client[0]['Client']['adresse'];
        $name = $client[0]['Client']['name'];
        $matriculefiscale = $client[0]['Client']['matriculefiscale'];
        $autorisation = $client[0]['Client']['autorisation'];
        $typeclient_id = $client[0]['Client']['typeclient_id'];

        $sumttc = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.totalttc) as totalttcb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid[0]['client_id'])));
        $summtreg = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.Montant_Regler) as totalregb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid[0]['client_id'])));
        $sumttcf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.totalttc) as totalttf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid[0]['client_id'])));
        $summtregf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.Montant_Regler) as totalregf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid[0]['client_id'])));
        $reglementlibre = $this->Reglementclient->find('all', array('fields' => array('sum(Reglementclient.Montant) as reglibretotale')
            , 'conditions' => array('Reglementclient.type  ' => 1, 'Reglementclient.affectation_id  ' => 0, 'Reglementclient.client_id' => $clientid[0]['client_id'])));
        $valbl = $sumttc[0][0]['totalttcb'] - $summtreg[0][0]['totalregb'];
        $valfac = $sumttcf[0][0]['totalttf'] - $summtregf[0][0]['totalregf'];
        $valglobal = $valbl + $valfac;
        $solde = $valglobal - $reglementlibre[0][0]['reglibretotale'];
        $valreste = $autorisation - ($valglobal - $reglementlibre[0][0]['reglibretotale']);
        //fin info client************************************************


        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Bonlivraison->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Bonlivraison->Depot->find('list', array('conditions' => array('Depot.id' => $p)));
        }


        $tot = $clientid[0]['totalttc'] + $timbre[1];


        $this->set(compact('typeclient_id', 'name', 'autorisation', 'solde', 'tot', 'clientid', 'tabqtestock', 'articles', 'depots', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'pntv', 'clients', 'client', 'utilisateurs', 'articles', 'mm', 'lignelivraisons', 'numspecial', 'timbre'));
    }

    //jeya mel devie
    public function addfacfromdeviseindirect($tab = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        // debug($tab);die;
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignedevi');
        $this->loadModel('Devi');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Client');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
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
                , 'AVG(Lignedevi.tva) tva', 'SUM(Lignedevi.totalht) totalht', 'SUM(Lignedevi.totalttc)totalttc', 'SUM(Lignedevi.prixnet*Lignedevi.quantite) prixnet', 'SUM(Lignedevi.puttc*Lignedevi.quantite) puttc')
            , 'conditions' => array('Lignedevi.devi_id in' . $tbr), 'recursive' => -2
            , 'group' => array('Lignedevi.article_id', 'Lignedevi.depot_id')));

        //debug($clientid);debug($lignelivraisons);die;
        if ($this->request->is('post')) {
            // debug($this->request->data);die;
            $this->request->data['Factureclient']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureclient']['date'])));
            $this->request->data['Factureclient']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureclient']['client_id'] = $clientid[0]['client_id'];
            $this->request->data['Factureclient']['type'] = 'direct';
            if (empty($this->request->data['Factureclient']['pointdevente_id'])) {
                $this->request->data['Factureclient']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Factureclient']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Factureclient']['pointdevente_id'];
            }
            $numero = $this->Factureclient->find('all', array('fields' => array('MAX(Factureclient.numeroconca) as num'),
                'conditions' => array('Factureclient.pointdevente_id' => $pv, 'Factureclient.exercice_id' => date("Y")))
            );
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
//  $anne=$getexercice['Factureclient']['exercice_id'];
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

            $this->request->data['Factureclient']['numeroconca'] = $mm;
            $this->request->data['Factureclient']['numero'] = $numspecial;
            //debug($this->request->data);die;
            $this->Factureclient->create();
            if (!empty($this->request->data['Lignefactureclient'])) {
                if ($this->Factureclient->save($this->request->data)) {
                    foreach ($idlcs as $idc) {
                        $this->Devi->updateAll(array('Devi.etat' => 1), array('Devi.id' => $idc));
                    }
                    $Lignelivraisons = array();
                    $id = $this->Factureclient->id;
                    $this->misejour("Factureclient", "add", $id);
                    $stockdepots = array();
                    foreach ($this->request->data['Lignefactureclient'] as $numl => $f) {

                        //  debug($f);die;
                        if ($f['sup'] != 1) {

                            $stockdepots[$numl]['quantite'] = $f['quantite'];
                            $Lignefactures['factureclient_id'] = $id;
                            $Lignefactures['depot_id'] = $f['depot_id'];
                            $Lignefactures['article_id'] = $f['article_id'];
                            $Lignefactures['quantite'] = $f['quantite'];
                            $Lignefactures['remise'] = $f['remise'];
                            $Lignefactures['tva'] = $f['tva'];
                            $Lignefactures['prix'] = $f['prixhtva'];
                            $Lignefactures['prixnet'] = $f['prixnet'];
                            $Lignefactures['puttc'] = $f['puttc'];
                            $Lignefactures['totalhtans'] = $f['totalhtans'];
                            $Lignefactures['totalht'] = $f['totalht'];
                            $Lignefactures['totalttc'] = $f['totalttc'];
                            $this->Lignefactureclient->create();
                            $this->Lignefactureclient->save($Lignefactures);

                            $id_ligne = $this->Lignefactureclient->id;
                            $qte_sorti = $f['quantite'];
                            while ($qte_sorti > 0) {
                                $stckdepot = $this->Stockdepot->find('first', array(
                                    'conditions' => array('Stockdepot.article_id' => $f['article_id'],
                                        'Stockdepot.depot_id' => $f['depot_id'], 'Stockdepot.quantite >' => 0), false));
                                //debug($stckdepot);
                                if ($qte_sorti < $stckdepot['Stockdepot']['quantite']) {
                                    $qte = $stckdepot['Stockdepot']['quantite'] - $qte_sorti;
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    $this->loadModel('Stockdepotfacture');
                                    $tab = array();
                                    $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                    $tab['id_piece'] = $id;
                                    $tab['piece'] = "Factureclient";
                                    $tab['qte'] = $qte_sorti;
                                    $tab['ligne'] = $id_ligne;
                                    $this->Stockdepotfacture->create();
                                    $this->Stockdepotfacture->save($tab);
                                    $qte_sorti = 0;
                                } else {
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 0), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    $qte_sorti = $qte_sorti - $stckdepot['Stockdepot']['quantite'];
                                    $this->loadModel('Stockdepotfacture');
                                    $tab = array();
                                    $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                    $tab['id_piece'] = $id;
                                    $tab['piece'] = "Factureclient";
                                    $tab['ligne'] = $id_ligne;
                                    $tab['qte'] = $stckdepot['Stockdepot']['quantite'];
                                    $this->Stockdepotfacture->create();
                                    $this->Stockdepotfacture->save($tab);
                                }
                            }





//                            $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $f['depot_id']), false));
//                            if (!empty($stckdepot)) {
//                                $stockdepots[$numl]['quantite'] = $stckdepot[0]['Stockdepot']['quantite'] - $stockdepots[$numl]['quantite'];
//                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
//                            }
                            // $this->Stockdepot->deleteAll(array('Stockdepot.quantite' =>0),false);
                            //$this->stock($f['depot_id'], $f['article_id']);
                        }
                    }
                    $this->Session->setFlash(__('The bonlivraison has been saved'));

                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('le bon de livraison dois avoir aux moins une ligne de livraison.'));
                }
            }
        }

        $pv = CakeSession::read('pointdevente');
        if ($pv == 0) {
            $pv = $clientid['Devi']['pointdevente_id'];
        }
        $numero = $this->Factureclient->find('all', array('fields' => array('MAX(Factureclient.numeroconca) as num'),
            'conditions' => array('Factureclient.pointdevente_id' => $pv, 'Factureclient.exercice_id' => date("Y")))
        );
        //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        if (!empty($n)) {
//   $getexercice= $this->Factureclient->find('first',array('conditions'=>array('Factureclient.numeroconca'=>$n)));
//  $anne=$getexercice['Factureclient']['exercice_id'];
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


        //**************************************trouver la liste des articles pour chaque depot *******************************************************
        /* foreach ($lignelivraisons as $ll) {
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
          } */

        //******************************************fin***********************************************************************************************************
        // debug($tabqtestock);die;
        //debug($tabqtestock['1.0000'][1]['qtestock']);die;

        $client = $this->Client->find('first', array('conditions' => array('Client.id' => $clientid[0]['client_id']), 'recursive' => -2));
        $pntv = $clientid['Devi']['pointdevente_id'];
        $client = $client['Client']['name'];
        $utilisateurs = $this->Factureclient->Utilisateur->find('list');
        $timbre = $this->Factureclient->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        //$articles = $this->Article->find('list');
        $pointdeventes = $this->Pointdevente->find('list');
        $clients = $this->Factureclient->Client->find('list');

        //****************************************************************************************************************************************************


        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Client');


        $client = $this->Client->find('all', array('conditions' => array('Client.id' => $clientid[0]['client_id']), false));
        $adresse = $client[0]['Client']['adresse'];
        $name = $client[0]['Client']['name'];
        $matriculefiscale = $client[0]['Client']['matriculefiscale'];
        $autorisation = $client[0]['Client']['autorisation'];
        $typeclient_id = $client[0]['Client']['typeclient_id'];

        $sumttc = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.totalttc) as totalttcb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid[0]['client_id'])));
        $summtreg = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.Montant_Regler) as totalregb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid[0]['client_id'])));
        $sumttcf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.totalttc) as totalttf')
            , 'conditions' => array('Factureclient.id > ' => 0), 'Factureclient.client_id' => $clientid[0]['client_id']));
        $summtregf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.Montant_Regler) as totalregf')
            , 'conditions' => array('Factureclient.id > ' => 0), 'Factureclient.client_id' => $clientid[0]['client_id']));
        $reglementlibre = $this->Reglementclient->find('all', array('fields' => array('sum(Reglementclient.Montant) as reglibretotale')
            , 'conditions' => array('Reglementclient.type  ' => 1, 'Reglementclient.affectation_id ' => 0, 'Reglementclient.client_id' => $clientid[0]['client_id'])));
        $valbl = $sumttc[0][0]['totalttcb'] - $summtreg[0][0]['totalregb'];
        $valfac = $sumttcf[0][0]['totalttf'] - $summtregf[0][0]['totalregf'];
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


        $tot = $clientid[0]['totalttc'] + $timbre[1];

        $this->set(compact('typeclient_id', 'name', 'autorisation', 'solde', 'tot', 'clientid', 'tabqtestock', 'articles', 'depots', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'pntv', 'clients', 'client', 'utilisateurs', 'articles', 'mm', 'lignelivraisons', 'numspecial', 'timbre'));
    }

    public function addbonsorti($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepot');
        $this->loadModel('Article');
        $this->loadModel('Bonsorti');
        $this->loadModel('Lignesorti');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignesortidetail');
        if (!$this->Factureclient->exists($id)) {
            throw new NotFoundException(__('Invalid Factureclient'));
        }
        if ($this->request->is('post')) {
            //debug($this->request->data );die;
            $this->request->data['Bonsorti']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Bonsorti']['date'])));
            $this->request->data['Bonsorti']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Bonsorti']['factureclient_id'] = $id;
            $this->Bonsorti->create();
            if (!empty($this->request->data['Lignesorti'])) {
                if ($this->Bonsorti->save($this->request->data)) {
                    $idbs = $this->Bonsorti->id;
                    $qteliv = array();
                    $qtebl = 0;
                    $qtelivrai = 0;
                    foreach ($this->request->data['Lignesorti'] as $f) {
                        //debug($f);die;

                        if ($f['sup'] != 1) {
                            $Lignesortis['bonsorti_id'] = $idbs;
                            $Lignesortis['lignefactureclient_id'] = $f['id'];
                            $Lignesortis['depot_id'] = $f['depot_id'];
                            $Lignesortis['article_id'] = $f['article_id'];
                            $Lignesortis['quantite'] = $f['quantite'];
                            $qtebl = $qtebl + $f['quantite'];
                            $this->Lignesorti->create();
                            $this->Lignesorti->save($Lignesortis);
                            $idls = $this->Lignesorti->id;
                            $qteliv[$f['id']] = 0;
                            foreach ($f['Stockdepot'] as $sd) {
                                if (!empty($sd['quantite'])) {
                                    $qte = $sd['qtestock'] - $sd['quantite'];

                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $sd['id']));
                                    if (($qte == 0) & ($f['quantite'] < $f['quantitestock'])) {
                                        $this->Stockdepot->deleteAll(array('Stockdepot.id' => $sd['id']), false);
                                    }
                                    $Lignedetailsortis['lignesorti_id'] = $idls;
                                    $Lignedetailsortis['stockdepot_id'] = $sd['id'];
                                    $Lignedetailsortis['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $sd['date'])));
                                    $Lignedetailsortis['quantite'] = $sd['quantite'];
                                    $this->Lignesortidetail->create();
                                    $this->Lignesortidetail->save($Lignedetailsortis);
                                    $qteliv[$f['id']] = $qteliv[$f['id']] + $sd['quantite'];
                                    $qtelivrai = $qtelivrai + $sd['quantite'];
                                }
                            }
                            $this->Lignefactureclient->updateAll(array('Lignefactureclient.quantitelivrai' => 'Lignefactureclient.quantitelivrai+' . $qteliv[$f['id']]), array('Lignefactureclient.id' => $f['id']));
                        }
                    }
                    if ($qtelivrai == $qtebl) {
                        $this->Factureclient->updateAll(array('Factureclient.etat' => 1), array('Factureclient.id' => $id));
                    }
                    $this->Session->setFlash(__('The facture has been saved'));
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('la  facture  dois avoir aux moins une ligne de livraison.'));
                }
            }
        }
        $lignefactureclients = $this->Lignefactureclient->find('all', array('conditions' => array('Lignefactureclient.factureclient_id' => $id)));
        //debug($lignefactureclients); die;

        foreach ($lignefactureclients as $q => $ll) {

            //**************************************trouver la liste des articles pour chaque depot *******************************************************

            $artdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.depot_id' => $ll['Depot']['id']), 'recursive' => -1));
            $t = '(0,';
            foreach ($artdepot as $ad) {
                $a = '' . $ad['Stockdepot']['article_id'];
                if (!strstr($t, $a)) {
                    $t = $t . $ad['Stockdepot']['article_id'] . ',';
                }
            }
            $t = $t . '0)';

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
            $stkdepots = $this->Stockdepot->find('all', array(
                'conditions' => array('Stockdepot.article_id' => $ll['Article']['id'], 'Stockdepot.depot_id' => $ll['Depot']['id'])
                , 'order' => array('Stockdepot.date' => 'ASC'), 'recursive' => -1));
            $lignefactureclients[$q]['Stockdepots'] = $stkdepots;
            //debug($stkdepots); die;
        }
        $numero = $this->Bonsorti->find('all', array('fields' =>
            array(
                'MAX(Bonsorti.numero) as num'
        )));
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
        // debug($tabqtestock); die;
        $clients = $this->Factureclient->Client->find('list');
        $utilisateurs = $this->Factureclient->Utilisateur->find('list');
        $depots = $this->Factureclient->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        $this->set(compact('clients', 'utilisateurs', 'depots', 'lignefactureclients', 'articles', 'tabqtestock', 'mm'));
    }

     public function addfactureavoir($idfc = null) {


        $lien = CakeSession::read('lien_vente');
        $x = "";
//debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureavoirs') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Factureavoir');
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Depot');
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Factureclient');
        $this->loadModel('Pointdevente');
        $this->loadModel('Imputationfactureavoir');
        $this->loadModel('Articlecomposante');
        if ($this->request->is('post')) {

            $this->request->data['Factureavoir']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Factureavoir']['date'])));
            $this->request->data['Factureavoir']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Factureavoir']['typefacture_id'] = 1;
            $this->request->data['Factureavoir']['source'] = "fac";
            $this->request->data['Factureavoir']['factureclient_id'] = $idfc;
            if (empty($this->request->data['Factureavoir']['pointdevente_id'])) {
                $this->request->data['Factureavoir']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Factureavoir']['exercice_id'] = date("Y");
            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Factureavoir']['pointdevente_id'];
            }
            $numero = $this->Factureavoir->find('all', array('fields' => array('MAX(Factureavoir.numeroconca) as num'),
                'conditions' => array('Factureavoir.pointdevente_id' => $pv, 'Factureavoir.exercice_id' => date("Y")))
            );
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
            $this->request->data['Factureavoir']['numeroconca'] = $mm;
            $this->request->data['Factureavoir']['numero'] = $numspecial;
            $depot = $this->request->data['Factureavoir']['depot_id'];
            $imputation = array();
//             debug($this->request->data);
//            die;
            $this->Factureavoir->create();
            if ($this->Factureavoir->save($this->request->data)) {
                $id = $this->Factureavoir->id;
                $this->misejour("Factureavoir", "add", $id);
                $this->Factureclient->updateAll(array('Factureclient.factureavoir_id'=>$id),array('Factureclient.id'=>$idfc));
                //****************************************************Imputation
                $facclt = $this->Factureclient->find('first', array(
                    'recursive' => -1,
                    'fields' => array('Factureclient.totalttc', 'Factureclient.Montant_Regler'),
                    'conditions' => array('Factureclient.id' => $idfc)
                ));
                $imputation['factureavoir_id'] = $id;
                $imputation['factureclient_id'] = $idfc;
                $imputation['reste'] = $facclt['Factureclient']['totalttc'] - $facclt['Factureclient']['Montant_Regler'];
                $imputation['montant'] = $this->request->data['Factureavoir']['totalttc'];
                $this->Imputationfactureavoir->create();
                if ($this->Imputationfactureavoir->save($imputation)) {
                    $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler+' . $this->request->data['Factureavoir']['totalttc']), array('Factureclient.id' => $idfc));
                    $this->Factureavoir->updateAll(array('Factureavoir.montant_regle ' => $this->request->data['Factureavoir']['totalttc']), array('Factureavoir.id' => $id));
                }
                //***************************************Nouvelle enregistrement
                $Lignefactureclients = array();
                $stockdepots = array();
                if (isset($this->request->data['Lignefactureclient'])) {
                    foreach ($this->request->data['Lignefactureclient'] as $numl => $f) {
//  debug($f);die;
                        if ($f['sup'] != 1) {
                            if ($f['article_id'] != "") {
                                $f['depot_id'] = $this->request->data['Factureavoir']['depot_id'];
                                $stockdepots[$numl]['quantite'] = $f['quantite'];
                                $Lignefactureclients['factureavoir_id'] = $id;
                                $Lignefactureclients['article_id'] = $this->request->data['Lignefactureclient'][$numl]['article_id'];
                                $f['article_id'] = $this->request->data['Lignefactureclient'][$numl]['article_id'];
                                $Lignefactureclients['depot_id'] = $f['depot_id'];
                                $Lignefactureclients['quantite'] = $f['quantite'];
                                $Lignefactureclients['remise'] = $f['remise'];
                                $Lignefactureclients['tva'] = $f['tva'];
                                $Lignefactureclients['prix'] = $f['prixhtva'];
                                $Lignefactureclients['prixnet'] = $f['prixnet'];
                                $Lignefactureclients['puttc'] = $f['puttc'];
                                $Lignefactureclients['totalhtans'] = $f['totalhtans'];
                                $Lignefactureclients['designation'] = $f['designation'];
                                $Lignefactureclients['totalht'] = $f['totalht'];
                                $Lignefactureclients['totalttc'] = $f['totalttc'];
                                $Lignefactureclients['depotcomposee'] = $f['depotcomposee'];
                                $Lignefactureclients['pmp'] = $f['pmp'];
                                $Lignefactureclients['margebase'] = $f['margebase'];
                                $Lignefactureclients['prixachatmarge'] = $f['prixachatmarge'];
                                if ($f['type'] == 1) {
                                    $Lignefactureclients['composee'] = $f['type'];
                                } else {
                                    $Lignefactureclients['composee'] = 0;
                                }
                                // debug($Lignefactur $Lignefactureclients['composee'] = $f['type'];eclients);die;
                                $this->Lignefactureavoir->create();
                                if ($this->Lignefactureavoir->save($Lignefactureclients)) {
                                    // Mise à jour stock
                                    $qte_sorti = $f['quantite'];
                                    if ($f['type'] == 1) {
                                        $articlescomposantes = $this->Articlecomposante->find('all', array(
                                            'conditions' => array('Articlecomposante.article_id' => $f['article_id'])
                                        ));
                                        foreach ($articlescomposantes as $k => $articlescomposante) {
                                            $qte_vendu = $qte_sorti * $articlescomposante['Articlecomposante']['qte'];
                                            $stckdepot = $this->Stockdepot->find('first', array(
                                                'conditions' => array('Stockdepot.article_id' => $articlescomposante['Articlecomposante']['composant'],
                                                    'Stockdepot.depot_id' => $f['depot_id']), false));
                                            if (!empty($stckdepot)) {
                                                $qte = $stckdepot['Stockdepot']['quantite'] + $qte_vendu;
                                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                            } else {
                                                $stkn = array();
                                                $stkn['depot_id'] = $f['depot_id'];
                                                $stkn['article_id'] = $articlescomposante['Articlecomposante']['composant'];
                                                $stkn['quantite'] = $qte_vendu;
                                                $this->Stockdepot->create();
                                                $this->Stockdepot->save($stkn);
                                            }
                                        }
                                    } else {
                                        $stckdepot = $this->Stockdepot->find('first', array(
                                            'conditions' => array('Stockdepot.article_id' => $f['article_id'],
                                                'Stockdepot.depot_id' => $f['depot_id']), false));
                                        if (!empty($stckdepot)) {
                                            $qte = $stckdepot['Stockdepot']['quantite'] + $qte_sorti;
                                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                        } else {
                                            $stkn = array();
                                            $stkn['depot_id'] = $f['depot_id'];
                                            $stkn['article_id'] = $f['article_id'];
                                            $stkn['quantite'] = $qte_sorti;
                                            $this->Stockdepot->create();
                                            $this->Stockdepot->save($stkn);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $this->Session->setFlash(__('The factureavoir has been saved'));
// $this->redirect(array('controller' => 'bonentres','action' => 'add/'.$id));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The factureavoir could not be saved. Please, try again.'));
            }
        }
        $lignefactureclients = $this->Lignefactureclient->find('all', array('conditions' => array('Lignefactureclient.factureclient_id' => $idfc), 'order' => array('Lignefactureclient.id' => 'ASC')));
        $Factureclient = $this->Factureclient->find('all', array('conditions' => array('Factureclient.id' => $idfc)));
//debug($Factureclient);  die;
        $dep = @$Factureclient[0]['Factureclient']['depot_id'];
//        debug($dep); die;
        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {
            $numero = $this->Factureavoir->find('all', array('fields' => array('MAX(Factureavoir.numeroconca) as num'),
                'conditions' => array('Factureavoir.pointdevente_id' => $pv, 'Factureavoir.exercice_id' => date("Y")))
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
        } else {
            $poinvente = $Factureclient[0]['Factureclient']['pointdevente_id'];
            $numero = $this->Factureavoir->find('all', array('fields' => array('MAX(Factureavoir.numeroconca) as num'),
                'conditions' => array('Factureavoir.pointdevente_id' => $poinvente, 'Factureavoir.exercice_id' => date("Y")))
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

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $poinvente)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        }
//$articles = $this->Article->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Factureclient->Client->find('list');
//$clients = $this->Factureavoir->Client->find('list');
        $utilisateurs = $this->Factureavoir->Utilisateur->find('list');
        $depots = $this->Depot->find('list');
//        debug($depots);die;
        $typefactures = $this->Factureavoir->Typefacture->find('list');
        $timbre = $this->Factureavoir->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('dep', 'poinvente', 'pointdeventes', 'numspecial', 'clients', 'utilisateurs', 'timbre', 'depots', 'typefactures', 'mm', 'articles', 'lignefactureclients', 'Factureclient'));
    }
    public function edit($id = null, $model = null, $ligne_model = null, $attribut = null) {
//        debug($id);
//        debug($model);
//        debug($ligne_model);
//        debug($attribut);
        // die;
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($model);
        $this->loadModel($ligne_model);
        $this->loadModel('Pointdevente');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Stockdepot');
        $this->loadModel('Article');
        $this->loadModel('Reglementclient');
        $this->loadModel('Stockdepotfacture');
        $this->loadModel('Depot');
        $this->loadModel('Timbre');
        $this->loadModel('Client');
        $this->loadModel('Utilisateur');
        $this->loadModel('Articlecomposante');
        $this->loadModel('Typedipliquation');
        $diplicatuion=0;

        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);die;
            $model_base = $model;
            if (!empty($this->request->data[$model_base]['typedipliquation'])) {
                $diplicatuion=1;
                $last_numero=$this->request->data[$model_base]['numero'];
                $typedipliquation = $this->Typedipliquation->find('first', array('conditions' => array('Typedipliquation.id' => $this->request->data[$model_base]['typedipliquation'])));
                $model = $typedipliquation['Typedipliquation']['name'];
                $ligne_model = $typedipliquation['Typedipliquation']['ligne'];
                $attribut = $typedipliquation['Typedipliquation']['attrb'];
                $this->loadModel($model);
                $this->loadModel($ligne_model);
                $this->request->data[$model] = $this->request->data[$model_base];
		$pv = CakeSession::read('pointdevente');
                if ($pv == 0) {$pv = $this->request->data[$model]['pointdevente_id'];}else{
                $this->request->data[$model]['pointdevente_id']=$pv;
                }
                $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numeroconca) as num'),
                'conditions' => array($model . '.pointdevente_id' => $pv, $model . '.exercice_id' => date("Y"))));
                foreach ($numero as $num) { $n = $num[0]['num'];}
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
                $this->request->data[$model]['numeroconca'] = $mm;
                $this->request->data[$model]['numero'] = $numspecial;
                $this->request->data[$model]['id'] = "";
                $this->$model->create();
                $tttt=$model_base."sController";
                $tt = new $tttt;
                $tt->delete($id,1);
                $this->request->data[$model]['exercice_id'] = date("Y", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            }



            // debug($this->request->data);
            // die;
            $this->request->data[$model]['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            $this->request->data[$model]['utilisateur_id'] = CakeSession::read('users');
            //$this->request->data['Factureclient']['type']= 'direct';
            $numeros = explode('/', $this->request->data[$model]['numero']);
            $this->request->data[$model]['numeroconca'] = $numeros[1];
            if (empty($this->request->data[$model]['timbre_id'])) {
                $this->request->data[$model]['timbre_id'] = 0;
            }
           // debug($this->request->data);
           // die;
            if ($this->$model->save($this->request->data)) {


                if ($diplicatuion==1) {
                $id= $this->$model->id;
                $this->misejour($model, "add", $id);
                }else{
                $this->misejour($model, "edit", $id);
                }

                if ($diplicatuion==0) {
                if (($model == "Factureclient") || ($model == "Bonlivraison")) {
                    //
                    if ($model == "Factureclient") {
                        $factures = $this->$model->find('first', array('conditions' => array($model . '.id' => $id)));
                        $source = $factures[$model]['source'];
                        if ($source == "fac") {
                            $lignefactureanciens = $this->Lignefactureclient->find('all', array('conditions' => array('Lignefactureclient.factureclient_id' => $id), false));
//                            debug($lignefactureanciens);die;
                            foreach ($lignefactureanciens as $lra) {
                                if ($lra['Lignefactureclient']['composee'] == 1) {
                                    $articlescomposantes = $this->Articlecomposante->find('all', array(
                                        'conditions' => array('Articlecomposante.article_id' => $lra['Lignefactureclient']['article_id'])
                                    ));
                                    foreach ($articlescomposantes as $k => $articlescomposante) {

                                    $testarticlecomposante = $this->Article->find('first', array(
                                            'conditions' => array('Article.id' =>$articlescomposante['Articlecomposante']['composant'])
                                        ));
                                    if ($testarticlecomposante['Article']['composee'] == 1) {

                                        $lesarticles_articlescomposantes = $this->Articlecomposante->find('all', array(
                                            'conditions' => array('Articlecomposante.article_id' =>$articlescomposante['Articlecomposante']['composant'])
                                        ));
                                        foreach ($lesarticles_articlescomposantes as $k => $lesarticles_articlescomposante) {
                                            $qte_vendu_articlecompose = $lra['Lignefactureclient']['quantite']  *$articlescomposante['Articlecomposante']['qte'] * $lesarticles_articlescomposante['Articlecomposante']['qte'];
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $qte_vendu_articlecompose), array('Stockdepot.article_id' => $lesarticles_articlescomposante['Articlecomposante']['composant'], 'Stockdepot.depot_id' => $lra['Factureclient']['depot_id']));

                                        }}else{

                                    $qte_vendu = $lra['Lignefactureclient']['quantite'] * $articlescomposante['Articlecomposante']['qte'];
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $qte_vendu), array('Stockdepot.article_id' => $articlescomposante['Articlecomposante']['composant'], 'Stockdepot.depot_id' => $lra['Factureclient']['depot_id']));


                                    }
                                    }
                                } else {
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $lra['Lignefactureclient']['quantite']), array('Stockdepot.article_id' => $lra['Lignefactureclient']['article_id'], 'Stockdepot.depot_id' => $lra['Factureclient']['depot_id']));
                                }
                            }
                        }
                    } else {
                        $lignelivraisonanciens = $this->Lignelivraison->find('all', array(
                            'conditions' => array('Lignelivraison.bonlivraison_id' => $id), false));
                        foreach ($lignelivraisonanciens as $lra) {
                            if ($lra['Lignelivraison']['composee'] == 1) {
                                $articlescomposantes = $this->Articlecomposante->find('all', array(
                                    'conditions' => array('Articlecomposante.article_id' => $lra['Lignelivraison']['article_id'])
                                ));
                                foreach ($articlescomposantes as $k => $articlescomposante) {
                                $testarticlecomposante = $this->Article->find('first', array(
                                            'conditions' => array('Article.id' =>$articlescomposante['Articlecomposante']['composant'])
                                        ));
                                    if ($testarticlecomposante['Article']['composee'] == 1) {

                                        $lesarticles_articlescomposantes = $this->Articlecomposante->find('all', array(
                                            'conditions' => array('Articlecomposante.article_id' =>$articlescomposante['Articlecomposante']['composant'])
                                        ));
                                        foreach ($lesarticles_articlescomposantes as $k => $lesarticles_articlescomposante) {
                                            $qte_vendu_articlecompose = $lra['Lignefactureclient']['quantite']  *$articlescomposante['Articlecomposante']['qte'] * $lesarticles_articlescomposante['Articlecomposante']['qte'];
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $qte_vendu_articlecompose), array('Stockdepot.article_id' => $lesarticles_articlescomposante['Articlecomposante']['composant'], 'Stockdepot.depot_id' => $lra['Factureclient']['depot_id']));

                                        }}else{


                                    $qte_vendu = $lra['Lignelivraison']['quantite'] * $articlescomposante['Articlecomposante']['qte'];
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite +' . $qte_vendu), array('Stockdepot.article_id' => $articlescomposante['Articlecomposante']['composant'], 'Stockdepot.depot_id' => $lra['Bonlivraison']['depot_id']));

                                        }
                                }
                            } else {
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $lra['Lignelivraison']['quantite']), array('Stockdepot.article_id' => $lra['Lignelivraison']['article_id'], 'Stockdepot.depot_id' => $lra['Bonlivraison']['depot_id']));
                            }
                        }
                    }
                }
                }

                $Lignefactureclients = array();
                $stockdepots = array();
                foreach ($this->request->data['Lignepiece'] as $numl => $f) {
                    if ($f['sup'] != 1) {
                        if ($f['article_id'] != "") {
                            if (!empty($f['id'])) {
                                if ($diplicatuion==0) {
                                $Lignefactureclients['id'] = $f['id'];
                                }  else {
                                  $Lignefactureclients['id'] = "";
                                }
                            } else {
                                $Lignefactureclients['id'] = "";
                            }
                            $f['depot_id'] = $this->request->data[$model]['depot_id'];
                            $stockdepots[$numl]['quantite'] = $f['quantite'];
                            $Lignefactureclients[$attribut] = $id;
                            $Lignefactureclients['depot_id'] = $f['depot_id'];
                            $Lignefactureclients['article_id'] = $f['article_id'];
                            $Lignefactureclients['quantite'] = $f['quantite'];
                            $Lignefactureclients['pmp'] = $f['pmp'];
                            $Lignefactureclients['remise'] = $f['remise'];
                            $Lignefactureclients['tva'] = $f['tva'];
                            $Lignefactureclients['prix'] = $f['prixhtva'];
                            $Lignefactureclients['prixnet'] = $f['prixnet'];
                            $Lignefactureclients['puttc'] = $f['puttc'];
                            $Lignefactureclients['totalhtans'] = $f['totalhtans'];
                            $Lignefactureclients['designation'] = $f['designation'];
                            $Lignefactureclients['totalht'] = $f['totalht'];
                            $Lignefactureclients['totalttc'] = $f['totalttc'];
                            $Lignefactureclients['depotcomposee'] = $f['depotcomposee'];
                            if ($model == 'Factureclient' || $model == 'Bonlivraison') {
                                $Lignefactureclients['margebase'] = @$f['margebase'];
                                $Lignefactureclients['prixachatmarge'] = @$f['prixachatmarge'];
                            }
                            if ($f['type'] == 1) {
                                $Lignefactureclients['composee'] = $f['type'];
                            } else {
                                $Lignefactureclients['composee'] = 0;
                            }
                            //debug($Lignefactureclients);
                            $this->$ligne_model->create();
                            $this->$ligne_model->save($Lignefactureclients);
                            // Blok mise à jour
                            if (($model == "Factureclient") || ($model == "Bonlivraison")) {
                                if ($f['type'] == 1) {
                                    $articlescomposantes = $this->Articlecomposante->find('all', array(
                                        'conditions' => array('Articlecomposante.article_id' => $f['article_id'])
                                    ));
                                    foreach ($articlescomposantes as $k => $articlescomposante) {


                                    $testarticlecomposante = $this->Article->find('first', array(
                                            'conditions' => array('Article.id' =>$articlescomposante['Articlecomposante']['composant'])
                                        ));

                                        if ($testarticlecomposante['Article']['composee'] == 1) {

                                        $lesarticles_articlescomposantes = $this->Articlecomposante->find('all', array(
                                            'conditions' => array('Articlecomposante.article_id' =>$articlescomposante['Articlecomposante']['composant'])
                                        ));
                                        foreach ($lesarticles_articlescomposantes as $k => $lesarticles_articlescomposante) {
                                            $qte_vendu_articlecompose = $f['quantite'] *$articlescomposante['Articlecomposante']['qte'] * $lesarticles_articlescomposante['Articlecomposante']['qte'];

                                            $stckdepot = $this->Stockdepot->find('first', array(
                                                'conditions' => array('Stockdepot.article_id' => $lesarticles_articlescomposante['Articlecomposante']['composant'],
                                                    'Stockdepot.depot_id' => $f['depot_id']), false));
                                            if (!empty($stckdepot)) {
                                                $qte = $stckdepot['Stockdepot']['quantite'] - $qte_vendu_articlecompose;
                                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                            } else {
                                                $stkn = array();
                                                $stkn['depot_id'] = $f['depot_id'];
                                                $stkn['article_id'] = $lesarticles_articlescomposante['Articlecomposante']['composant'];
                                                $stkn['quantite'] = 0 - $qte_vendu_articlecompose;
                                                $this->Stockdepot->create();
                                                $this->Stockdepot->save($stkn);
                                            }



                                        }
                                        }else{





                                        $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $articlescomposante['Articlecomposante']['composant'], 'Stockdepot.depot_id' => $this->request->data[$model]['depot_id']), false));
                                        if (!empty($stckdepot)) {
                                            $qte_vendu = $stckdepot[0]['Stockdepot']['quantite'] - ($stockdepots[$numl]['quantite'] * $articlescomposante['Articlecomposante']['qte']);
                                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte_vendu), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                                        } else {
                                            $stkn = array();
                                            $stkn['depot_id'] = $this->request->data[$model]['depot_id'];
                                            $stkn['article_id'] = $articlescomposante['Articlecomposante']['composant'];
                                            $stkn['quantite'] = 0 - ($stockdepots[$numl]['quantite'] * $articlescomposante['Articlecomposante']['qte']);
                                            $this->Stockdepot->create();
                                            $this->Stockdepot->save($stkn);
                                        }


                                        }


                                    }
                                } else {
                                    $stckdepot = $this->Stockdepot->find('all', array('conditions' => array('Stockdepot.article_id' => $f['article_id'], 'Stockdepot.depot_id' => $this->request->data[$model]['depot_id']), false));
                                    if (!empty($stckdepot)) {
                                        $qte_vendu = $stckdepot[0]['Stockdepot']['quantite'] - $stockdepots[$numl]['quantite'];
                                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte_vendu), array('Stockdepot.id' => $stckdepot[0]['Stockdepot']['id']));
                                    } else {
                                        $stkn = array();
                                        $stkn['depot_id'] = $this->request->data[$model]['depot_id'];
                                        $stkn['article_id'] = $f['article_id'];
                                        $stkn['quantite'] = 0 - $stockdepots[$numl]['quantite'];
                                        $this->Stockdepot->create();
                                        $this->Stockdepot->save($stkn);
                                    }
                                }
                            }
                        }
                    } else {
                        if (!empty($f['id'])) {
                            $this->$ligne_model->deleteAll(array($ligne_model . '.id' => $f['id']), false);
                        }
                    }
                }
                $this->Session->setFlash(__('The factureclient has been saved'));
                //$this->redirect(array('action' => 'index'));
                $this->redirect(array('controller' => $model . 's', 'action' => 'index/' . $id));
            } else {
                $this->Session->setFlash(__('The factureclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array($model . '.' . $this->$model->primaryKey => $id));
            $this->request->data = $this->$model->find('first', $options);
            //$ligneoptions = array('conditions' => array('Lignefactureclient.factureclient_id' => $id),'recursive'=>-1, 'order' => array('Lignefactureclient.id' => 'ASC'));
            //$this->request->ligne = $this->Lignefactureclient->find('first', $ligneoptions);
            //debug($this->request->ligne);
        }
        $lignefactureclients = $this->$ligne_model->find('all', array('conditions' => array($ligne_model . '.' . $attribut => $id), 'order' => array($ligne_model . '.id' => 'ASC')));

        //$clients = $this->Client->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        //$clients = $this->Client->find('list');
        $utilisateurs = $this->Utilisateur->find('list');
        $timbre = $this->Timbre->find('list', array('fields' => array('Timbre.timbre')));
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data[$model]['date'])));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        //$articles = $this->Article->find('list');
        //info client**************************************************
        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Client');
        $facture = $this->$model->find('first', array('conditions' => array($model . '.id' => $id), false));
        $clientid = $facture[$model]['client_id'];
        $name = $facture[$model]['name'];
        $client = $this->Client->find('all', array('conditions' => array('Client.id' => $clientid), false));
        //$matriculefiscales = $this->Client->find('list', array('fields' => array('Client.id','Client.matriculefiscale'), 'order' => array('Client.code' => 'asc')));
        $adresse = $client[0]['Client']['adresse'];
        $matriculefiscale = $client[0]['Client']['matriculefiscale'];
        $autorisation = $client[0]['Client']['autorisation'];
        $typeclient_id = $client[0]['Client']['typeclient_id'];

        $sumttc = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalttc) as totalttcb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid, 'Bonlivraison.id not in (' . $id . ')')));
        $summtreg = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.Montant_Regler) as totalregb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $clientid)));
        $sumttcf = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalttc) as totalttf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid, 'Factureclient.id not in (' . $id . ')')));
        $summtregf = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.Montant_Regler) as totalregf')
            , 'conditions' => array('Factureclient.id > ' => 0, 'Factureclient.client_id' => $clientid)));
        $reglementlibre = $this->Reglementclient->find('all', array('fields' => array('sum(Reglementclient.Montant) as reglibretotale')
            , 'conditions' => array('Reglementclient.type  ' => 1, 'Reglementclient.affectation_id  ' => 0, 'Reglementclient.client_id' => $clientid)));
        $valbl = $sumttc[0][0]['totalttcb'] - $summtreg[0][0]['totalregb'];
        $valfac = $sumttcf[0][0]['totalttf'] - $summtregf[0][0]['totalregf'];
        $valglobal = $valbl + $valfac;
        $solde = $valglobal - $reglementlibre[0][0]['reglibretotale'];
        $valreste = $autorisation - ($valglobal - $reglementlibre[0][0]['reglibretotale']);
        //fin info client************************************************
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.id' => $p)));
        }
        $typedipliquations = $this->Typedipliquation->find('list', array(
            'conditions' => array('Typedipliquation.id <' => 5),
            'fields' => array('Typedipliquation.id', 'Typedipliquation.name')
        ));
        $this->set(compact('typedipliquations','matriculefiscales','ligne_model', 'model', 'typeclient_id', 'name', 'autorisation', 'solde', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'clients', 'utilisateurs', 'timbre', 'depots', 'date', 'lignefactureclients', 'articles', 'tabqtestock'));
    }

    public function transformation($model = null, $ligne_model = null, $attribut = null, $liste_in = null, $model_ans = null, $ligne_model_ans = null, $attribut_ans = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel($model);
        $this->loadModel($ligne_model);
        $this->loadModel($model_ans);
        $this->loadModel($ligne_model_ans);
        $this->loadModel('Pointdevente');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepot');
        $this->loadModel('Article');
        $this->loadModel('Reglementclient');
        $this->loadModel('Stockdepotfacture');
        $this->loadModel('Depot');
        $this->loadModel('Timbre');
        $this->loadModel('Client');
        $this->loadModel('Utilisateur');
        $this->loadModel('Lignecommandeclient');
        $this->loadModel('Articlecomposante');

        if ($this->request->is('post') || $this->request->is('put')) {

            $this->request->data[$model]['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            $this->request->data[$model]['utilisateur_id'] = CakeSession::read('users');
            if ($model_ans == 'Bonlivraison') {
                $this->request->data[$model]['source'] = 'bl';
            } else {
                $this->request->data[$model]['source'] = 'fac';
            }
            if (empty($this->request->data[$model]['pointdevente_id'])) {
                $this->request->data[$model]['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data[$model]['exercice_id'] = date("Y", strtotime(str_replace('/', '-', $this->request->data[$model]['date'])));
            if (empty($this->request->data[$model]['timbre_id'])) {
                $this->request->data[$model]['timbre_id'] = 0;
            }
            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data[$model]['pointdevente_id'];
            }
            $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numeroconca) as num'),
                'conditions' => array($model . '.pointdevente_id' => $pv, $model . '.exercice_id' => date("Y")))
            );
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
            $this->request->data[$model]['numeroconca'] = $mm;
            $this->request->data[$model]['numero'] = $numspecial;
            $this->$model->create();
            if ($this->$model->save($this->request->data)) {
                $id = $this->$model->id;
                $this->misejour($model, "add", $id);
                $liste = '(0,' . $liste_in . ',0)';
                $this->$model_ans->updateAll(array($model_ans . '.' . $attribut => $id), array($model_ans . '.id in ' . $liste));
                $Lignefactureclients = array();
                $stockdepots = array();
                foreach ($this->request->data['Lignepiece'] as $numl => $f) {
                    //  debug($f);die;
                    if ($f['sup'] != 1) {
                        if ($f['article_id'] != "") {
                            //$Lignefactureclients['id'] = $f['id'];
                            $f['depot_id'] = $this->request->data[$model]['depot_id'];
                            $stockdepots[$numl]['quantite'] = $f['quantite'];
                            $Lignefactureclients[$attribut] = $id;
                            $Lignefactureclients['depot_id'] = $f['depot_id'];
                            $Lignefactureclients['article_id'] = $f['article_id'];
                            $Lignefactureclients['quantite'] = $f['quantite'];
                            $Lignefactureclients['remise'] = $f['remise'];
                            $Lignefactureclients['tva'] = $f['tva'];
                            $Lignefactureclients['prix'] = $f['prixhtva'];
                            $Lignefactureclients['prixnet'] = $f['prixnet'];
                            $Lignefactureclients['puttc'] = $f['puttc'];
                            $Lignefactureclients['totalhtans'] = $f['totalhtans'];
                            $Lignefactureclients['designation'] = $f['designation'];
                            $Lignefactureclients['totalht'] = $f['totalht'];
                            $Lignefactureclients['totalttc'] = $f['totalttc'];
                            if ($f['type'] == 1) {
                                $Lignefactureclients['composee'] = $f['type'];
                            } else {
                                $Lignefactureclients['composee'] = 0;
                            }
                            if ($model_ans == "Commandeclient") {
                                $Lignefactureclients['lignecommandeclient_id'] = $f['Lignecommandeclient_id'];
                            }
                            if ($model_ans == 'Bonlivraison') {
                                $Lignefactureclients['bonlivraison_id'] = $f['bonlivraison_id'];
                            }
                            $this->$ligne_model->create();
                            $this->$ligne_model->save($Lignefactureclients);

                            if ($model_ans == "Commandeclient") {
                                if (!empty($f['commandeclient_id'])) {
                                    $lignecommandeclientfacture = $this->Lignecommandeclient->find('first', array('conditions' => array('Lignecommandeclient.id' => $f['Lignecommandeclient_id'])));
                                    $qte_liv = 0;
                                    if (($lignecommandeclientfacture['Lignecommandeclient']['quantite'] - $lignecommandeclientfacture['Lignecommandeclient']['quantiteliv']) < $f['quantite']) {
                                        $qte_liv = $lignecommandeclientfacture['Lignecommandeclient']['quantite'] - $lignecommandeclientfacture['Lignecommandeclient']['quantiteliv'];
                                    } else {
                                        $qte_liv = $f['quantite'];
                                    }
                                    $this->Lignecommandeclient->updateAll(array('Lignecommandeclient.quantiteliv' => 'Lignecommandeclient.quantiteliv +' . $qte_liv), array('Lignecommandeclient.id' => $f['Lignecommandeclient_id']));
                                }
                            }
                            if (($model == "Factureclient") || ($model == "Bonlivraison")) {
                                $qte_sorti = $f['quantite'];
                                if ($model_ans != 'Bonlivraison') {
                                    if ($f['type'] == 1) {
                                        $articlescomposantes = $this->Articlecomposante->find('all', array(
                                            'conditions' => array('Articlecomposante.article_id' => $f['article_id'])
                                        ));
                                        foreach ($articlescomposantes as $k => $articlescomposante) {

                                        $testarticlecomposante = $this->Article->find('first', array(
                                            'conditions' => array('Article.id' =>$articlescomposante['Articlecomposante']['composant'])
                                        ));

                                        if ($testarticlecomposante['Article']['composee'] == 1) {

                                        $lesarticles_articlescomposantes = $this->Articlecomposante->find('all', array(
                                            'conditions' => array('Articlecomposante.article_id' =>$articlescomposante['Articlecomposante']['composant'])
                                        ));
                                        foreach ($lesarticles_articlescomposantes as $k => $lesarticles_articlescomposante) {
                                            $qte_vendu_articlecompose = $f['quantite'] *$articlescomposante['Articlecomposante']['qte'] * $lesarticles_articlescomposante['Articlecomposante']['qte'];

                                            $stckdepot = $this->Stockdepot->find('first', array(
                                                'conditions' => array('Stockdepot.article_id' => $lesarticles_articlescomposante['Articlecomposante']['composant'],
                                                    'Stockdepot.depot_id' => $f['depot_id']), false));
                                            if (!empty($stckdepot)) {
                                                $qte = $stckdepot['Stockdepot']['quantite'] - $qte_vendu_articlecompose;
                                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                            } else {
                                                $stkn = array();
                                                $stkn['depot_id'] = $f['depot_id'];
                                                $stkn['article_id'] = $lesarticles_articlescomposante['Articlecomposante']['composant'];
                                                $stkn['quantite'] = 0 - $qte_vendu_articlecompose;
                                                $this->Stockdepot->create();
                                                $this->Stockdepot->save($stkn);
                                            }



                                        }
                                        }else{



                                            $qte_vendu = $qte_sorti * $articlescomposante['Articlecomposante']['qte'];
                                            $stckdepot = $this->Stockdepot->find('first', array(
                                                'conditions' => array('Stockdepot.article_id' => $articlescomposante['Articlecomposante']['composant'],
                                                    'Stockdepot.depot_id' => $f['depot_id']), false));
                                            if (!empty($stckdepot)) {
                                                $qte = $stckdepot['Stockdepot']['quantite'] - $qte_vendu;
                                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                            } else {
                                                $stkn = array();
                                                $stkn['depot_id'] = $f['depot_id'];
                                                $stkn['article_id'] = $articlescomposante['Articlecomposante']['composant'];
                                                $stkn['quantite'] = 0 - $qte_vendu;
                                                $this->Stockdepot->create();
                                                $this->Stockdepot->save($stkn);
                                            }

                                        }



                                        }
                                    } else {
                                        $stckdepot = $this->Stockdepot->find('first', array(
                                            'conditions' => array('Stockdepot.article_id' => $f['article_id'],
                                                'Stockdepot.depot_id' => $f['depot_id']), false));
                                        if (!empty($stckdepot)) {
                                            $qte = $stckdepot['Stockdepot']['quantite'] - $qte_sorti;
                                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                        } else {
                                            $stkn = array();
                                            $stkn['depot_id'] = $f['depot_id'];
                                            $stkn['article_id'] = $f['article_id'];
                                            $stkn['quantite'] = 0 - $qte_sorti;
                                            $this->Stockdepot->create();
                                            $this->Stockdepot->save($stkn);
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        $this->$ligne_model->deleteAll(array($ligne_model . '.id' => $f['id']), false);
                    }
                }
                $this->Session->setFlash(__('The factureclient has been saved'));
                //$this->redirect(array('action' => 'index'));
                $this->redirect(array('controller' => $model . 's', 'action' => 'index/' . $id));
            } else {
                $this->Session->setFlash(__('The factureclient could not be saved. Please, try again.'));
            }
        } else {
            $liste = '(0,' . $liste_in . ',0)';
            $condcommandeclient = "";
            $condqteliv = "";
            if ($model_ans == "Commandeclient") {
                $condcommandeclient = $ligne_model_ans . '.quantite != ' . $ligne_model_ans . '.quantiteliv';
                $condqteliv = '(' . $ligne_model_ans . '.quantiteliv) quantiteliv';
            }
            $entete = $this->$model_ans->find('first', array('fields' => array('typeclient_id','auto', 'ttretenue', 'retenue', 'ttfodec', 'fodec', 'pointdevente_id', 'depot_id', 'vente', 'SUM(' . $model_ans . '.remise) remise', 'SUM(' . $model_ans . '.tva) tva', 'SUM(' . $model_ans . '.totalht) totalht'
                    , 'SUM(' . $model_ans . '.totalttc-' . $model_ans . '.timbre_id) totalttc', 'AVG(' . $model_ans . '.client_id) client_id'), 'conditions' => array($model_ans . '.id in' . $liste), 'recursive' => -1));
//            debug($entete);die;
            $lignes = $this->$ligne_model_ans->find('all', array(
                'fields' => array('composee', '(' . $ligne_model_ans . '.article_id) article_id', '(' . $ligne_model_ans . '.article_id) article_iddd', '(' . $ligne_model_ans . '.id) id', '(' . $ligne_model_ans . '.designation) designation'
                    , '(' . $ligne_model_ans . '.quantite) quantite', @$condqteliv, '(' . $ligne_model_ans . '.remise) remise', '(' . $ligne_model_ans . '.prix) prix'
                    , '(' . $ligne_model_ans . '.tva) tva', '(' . $ligne_model_ans . '.totalht) totalht', '(' . $ligne_model_ans . '.totalttc)totalttc', '(' . $ligne_model_ans . '.prixnet) prixnet', '(' . $ligne_model_ans . '.puttc) puttc', '(' . $ligne_model_ans . '.' . $attribut_ans . ')' . $attribut_ans, '(' . $ligne_model_ans . '.id)' . $ligne_model_ans . '_id')
                , 'conditions' => array($model_ans . '.id in' . $liste, @$condcommandeclient)
                , 'recursive' => 0
                , 'group' => array($ligne_model_ans . '.id', $ligne_model_ans . '.article_id')
                , 'order' => array($ligne_model_ans . '.' . $attribut_ans => 'ASC')));


//            debug($entete);
//            debug($lignes);
        }

        $pv = CakeSession::read('pointdevente');
        if ($pv == 0) {
            $pv = $entete[$model_ans]['pointdevente_id'];
        }
        $numero = $this->$model->find('all', array('fields' => array('MAX(' . $model . '.numeroconca) as num'),
            'conditions' => array($model . '.pointdevente_id' => $pv, $model . '.exercice_id' => date("Y")))
        );
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
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Factureclient->Client->find('list', array(
            'conditions' => array('Client.etat' => 1, 'Client.societe' => $composantsoc)));
        $utilisateurs = $this->Utilisateur->find('list');
        $timbre = $this->Timbre->find('first', array('recursive' => -1));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        //info client**************************************************
        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Client');
        $clientid = $entete[0]['client_id'];
        $client = $this->Client->find('all', array('conditions' => array('Client.id' => $clientid), 'recursive' => -1));
        //debug($client);
        $name = $client[0]['Client']['code']." ".$client[0]['Client']['name'];
        $adresse = $client[0]['Client']['adresse'];
        $matriculefiscale = $client[0]['Client']['matriculefiscale'];
        $autorisation = $client[0]['Client']['autorisation'];
        $typeclient_id = $client[0]['Client']['typeclient_id'];
        $avectimbre = $client[0]['Client']['avectimbre_id'];

        $sumttc = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.totalttc) as totalttcb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $client[0]['Client']['id'])));
        $summtreg = $this->Bonlivraison->find('all', array('fields' => array('SUM(Bonlivraison.Montant_Regler) as totalregb')
            , 'conditions' => array('Bonlivraison.id > ' => 0, 'Bonlivraison.factureclient_id' => 0, 'Bonlivraison.client_id' => $client[0]['Client']['id'])));
        $sumttcf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.totalttc) as totalttf')
            , 'conditions' => array('Factureclient.id > ' => 0), 'Factureclient.client_id' => $client[0]['Client']['id']));
        $summtregf = $this->Factureclient->find('all', array('fields' => array('SUM(Factureclient.Montant_Regler) as totalregf')
            , 'conditions' => array('Factureclient.id > ' => 0), 'Factureclient.client_id' => $client[0]['Client']['id']));
        $reglementlibre = $this->Reglementclient->find('all', array('fields' => array('sum(Reglementclient.Montant) as reglibretotale')
            , 'conditions' => array('Reglementclient.type  ' => 1, 'Reglementclient.affectation_id ' => 0, 'Reglementclient.client_id' => $client[0]['Client']['id'])));
        $valbl = $sumttc[0][0]['totalttcb'] - $summtreg[0][0]['totalregb'];
        $valfac = $sumttcf[0][0]['totalttf'] - $summtregf[0][0]['totalregf'];
        $valglobal = $valbl + $valfac;
        $solde = $valglobal - $reglementlibre[0][0]['reglibretotale'];
        $valreste = $autorisation - ($valglobal - $reglementlibre[0][0]['reglibretotale']);
        //fin info client************************************************
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('fields' => array('Depot.designation'), 'conditions' => array('Depot.id' => $p)));
        }
        $this->set(compact('avectimbre','attribut_ans', 'ligne_model_ans', 'model_ans', 'lignes', 'entete', 'ligne_model', 'model', 'typeclient_id', 'name', 'autorisation', 'solde', 'valreste', 'matriculefiscale', 'adresse', 'pointdeventes', 'clients', 'utilisateurs', 'timbre', 'depots', 'date', 'lignefactureclients', 'articles', 'tabqtestock', 'mm', 'numspecial'));
    }

    public function delete($id = null,$redirection=null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['delete'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Stockdepot');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Stockdepotfacture');
        $this->loadModel('Commandeclient');
        $this->loadModel('Devi');
        $this->loadModel('Articlecomposante');
        $this->loadModel('Article');
        $this->loadModel('Bonlivraison');
        $this->Factureclient->id = $id;

        if (!$this->Factureclient->exists()) {
            throw new NotFoundException(__('Invalid factureclient'));
        }
        $facture = $this->Factureclient->find('first', array('conditions' => array('Factureclient.id' => $id), false));
        $source = $facture['Factureclient']['source'];
        $numansar = $facture['Factureclient']['numero'];
        $pvansar = $facture['Factureclient']['pointdevente_id'];
        if ($source == "fac") {
            $lignefactureanciens = $this->Lignefactureclient->find('all', array('conditions' => array('Lignefactureclient.factureclient_id' => $id), false));
            foreach ($lignefactureanciens as $lra) {
                if ($lra['Lignefactureclient']['composee'] == 1) {
                    $articlescomposantes = $this->Articlecomposante->find('all', array(
                        'conditions' => array('Articlecomposante.article_id' => $lra['Lignefactureclient']['article_id'])
                    ));
                    foreach ($articlescomposantes as $k => $articlescomposante) {

                    $testarticlecomposante = $this->Article->find('first', array(
                                            'conditions' => array('Article.id' =>$articlescomposante['Articlecomposante']['composant'])
                                        ));
                                    if ($testarticlecomposante['Article']['composee'] == 1) {

                                        $lesarticles_articlescomposantes = $this->Articlecomposante->find('all', array(
                                            'conditions' => array('Articlecomposante.article_id' =>$articlescomposante['Articlecomposante']['composant'])
                                        ));
                                        foreach ($lesarticles_articlescomposantes as $k => $lesarticles_articlescomposante) {
                                            $qte_vendu_articlecompose = $lra['Lignefactureclient']['quantite']  *$articlescomposante['Articlecomposante']['qte'] * $lesarticles_articlescomposante['Articlecomposante']['qte'];
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $qte_vendu_articlecompose), array('Stockdepot.article_id' => $lesarticles_articlescomposante['Articlecomposante']['composant'], 'Stockdepot.depot_id' => $lra['Factureclient']['depot_id']));

                                        }}else{

                                    $qte_vendu = $lra['Lignefactureclient']['quantite'] * $articlescomposante['Articlecomposante']['qte'];
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $qte_vendu), array('Stockdepot.article_id' => $articlescomposante['Articlecomposante']['composant'], 'Stockdepot.depot_id' => $lra['Factureclient']['depot_id']));


                                    }
                         }
                } else {
                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+' . $lra['Lignefactureclient']['quantite']), array('Stockdepot.article_id' => $lra['Lignefactureclient']['article_id'], 'Stockdepot.depot_id' => $lra['Factureclient']['depot_id']));
                }
            }
        }
        $this->Devi->updateAll(array('Devi.factureclient_id' => 0), array('Devi.factureclient_id' => $id));
        $this->Commandeclient->updateAll(array('Commandeclient.factureclient_id' => 0), array('Commandeclient.factureclient_id' => $id));
        $lrs = $this->Lignefactureclient->find('all', array('conditions' => array('Lignefactureclient.factureclient_id' => $id), false));
        foreach ($lrs as $lr) {
            if (!empty($lr['Lignefactureclient']['lignecommandeclient_id'])) {
                $this->Lignecommandeclient->updateAll(array('Lignecommandeclient.quantiteliv' => 'Lignecommandeclient.quantiteliv-' . $lr['Lignefactureclient']['quantite']), array('Lignecommandeclient.id' => $lr['Lignefactureclient']['lignecommandeclient_id']));
            }
        }
        $this->Bonlivraison->updateAll(array('Bonlivraison.factureclient_id' => 0), array('Bonlivraison.factureclient_id' => $id));
        $this->Lignefactureclient->deleteAll(array('Lignefactureclient.factureclient_id' => $id), false);
        if ($this->Factureclient->delete()) {
            $this->misejour("Factureclient", $numansar, $id,$pvansar);
            //$this->Session->setFlash(__('Factureclient deleted'));
            CakeSession::write('view', "delete");
            if($redirection!=1){
            $this->redirect(array('action' => 'index'));
            }
        }
       // $this->Session->setFlash(__('Factureclient was not deleted'));
    }

    public function article() {
        $this->layout = null;
        $this->loadModel('Article');
        $data = $this->request->data; //debug($data);
        $json = null;
        $articleid = $data['id'];
        //debug($data);
        $article = $this->Article->find('all', array('conditions' => array('Article.id' => $articleid), false));

        $tva = $article[0]['Article']['tva'];
        $prix = $article[0]['Article']['prixvente'];
        //debug($qtestock);die;
        echo json_encode(array('tva' => $tva, 'prix' => $prix));
        die();
    }

    public function testeditnumerofactures() {
        $this->loadModel('Pointdevente');
        $this->layout = null;
        $data = $this->request->data; //debug($data);
        $json = null;
        $test = 0;
        $numero = $data['numero'];
        $id_fac = $data['id_fac'];
        $model = $data['model'];
        $this->loadModel($model);
        $numeros = explode('/', $numero);
        $pv = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.abriviation' => $numeros[0]), false));
        $fac = $this->$model->find('first', array('conditions' => array($model . '.numeroconca' => $numeros[1], $model . '.pointdevente_id' => $pv['Pointdevente']['id'], $model . '.exercice_id' => $numeros[2]), false, 'recursive' => -1));
        //debug($fac);die;
        if (!empty($fac)) {
            if ($fac[$model]['id'] != $id_fac) {
                $test = 1;
            }
        }
        echo json_encode(array('test' => $test));
        die();
    }

    public function recap_reglement() {
        $this->layout = null;
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Reglementclient');
        $this->loadModel('Factureavoir');
        $data = $this->request->data; //debug($data);die;
        $json = null;
        $id = $data['id'];


        $lignereglementclients = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.factureclient_id' => $id), false));

        $factueclient = $this->Factureclient->find('first', array('conditions' => array('Factureclient.id' => $id), false));

        $factuecavoir = $this->Factureavoir->find('all', array('conditions' => array('Factureavoir.factureclient_id' => $factueclient['Factureclient']['id']), false));
        //debug($factuecavoir);die;
        $this->set(compact('lignereglementclients', 'factueclient', 'factuecavoir'));
    }

    public function recap_nouveau_prix($index = null, $article_id = null, $qtevendu = null, $depot_id = null, $edit = null,$model=null) {

        $this->loadModel('Depot');
        $this->loadModel('Article');
        $this->loadModel('Articlecomposante');
        $this->layout = "defaulthelmi";
        if (!isset($edit)) {
            $edit = 0;
            //debug($edit);die;
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            //$index_kbira = $index;
//            debug($this->request->data);
//            die;
            $this->request->data['Article']['composee'] = 1;
            $this->request->data['Article']['societe'] = CakeSession::read('composantsoc');
            $this->Article->create();
            if ($this->Article->save($this->request->data)) {
                $id = $this->Article->id;
                $this->misejour("Article", "add", $id);
                $ind = 0;
                foreach ($this->request->data['Lignepiece'] as $ligne) {
                    if ($ligne['sup'] == '' && !empty($ligne['article_id'])) {
                        $ind++;
                    }
                }
                $articlecomposante = $this->Articlecomposante->find('first', array(
                    'conditions' => array('')
                ));
                foreach ($this->request->data['Lignepiece'] as $ligne) {
                    if ($ligne['sup'] == '' && !empty($ligne['article_id'])) {
                        $articlecomposantes = array();
                        // cas article composante existe + cas id=""
                        if (empty($ligne['id']) && !empty($this->request->data['Article']['id'])) {
                            $artcomposante = $this->Articlecomposante->find('first', array(
                                'conditions' => array('Articlecomposante.article_id' => $id, 'Articlecomposante.composant' => $ligne['article_id']),
                                'recursive' => -1
                            ));
                            $articlecomposantes['id'] = $artcomposante['Articlecomposante']['id'];
                        } else {
                            $articlecomposantes['id'] = $ligne['id'];
                        }
                        $articlecomposantes['article_id'] = $id;
                        $articlecomposantes['composant'] = $ligne['article_id'];
                        $articlecomposantes['qte'] = $ligne['quantite'];
                        $articlecomposantes['cnt'] = $ind;
                        $this->Articlecomposante->create();
                        $this->Articlecomposante->save($articlecomposantes);
                    } else {
                        if (!(empty($ligne['id']))) {
                            $this->Articlecomposante->deleteAll(array('Articlecomposante.id' => $ligne['id']));
                        }
                    }
                }

                //CakeSession::write('testajoutarticle', '1');
                $this->Session->setFlash(__('The article has been saved'));
            } else {
                $this->Session->setFlash(__('The article could not be saved. Please, try again.'));
            }

            $totalht = ($this->request->data['Article']['prixvente'] * $this->request->data['Article']['qtevendu']);
            $totalttc = ($this->request->data['Article']['prixuttc'] * $this->request->data['Article']['qtevendu']);
            if($model!='Article'){
            ?>
            <script language="javascript"  >
                input = window.opener.document.getElementById("article_id<?php echo $index; ?>").value = "<?php echo $id; ?>";
                input = window.opener.document.getElementById("code<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['code']; ?>";
                input = window.opener.document.getElementById("designation<?php echo $index; ?>").value = "<?php echo addslashes ( $this->request->data['Article']['name']); ?>";
                //input = window.opener.document.getElementById("sirine").value = "1";
                input = window.opener.document.getElementById("totalhtans<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['prixvente']; ?>";
                input = window.opener.document.getElementById("prixhtva<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['prixvente']; ?>";
                input = window.opener.document.getElementById("prixnet<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['prixvente']; ?>";
                input = window.opener.document.getElementById("puttc<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['prixuttc']; ?>";
                input = window.opener.document.getElementById("tva<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['tva']; ?>";
                input = window.opener.document.getElementById("type<?php echo $index; ?>").value = "1";
                input = window.opener.document.getElementById("quantite<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['qtevendu']; ?>";
                input = window.opener.document.getElementById("totalht<?php echo $index; ?>").value = "<?php echo number_format($totalht, 3, '.', ''); ?>";
                input = window.opener.document.getElementById("totalttc<?php echo $index; ?>").value = "<?php echo number_format($totalttc, 3, '.', ''); ?>";
                input = window.opener.document.getElementById("quantite<?php echo $index; ?>").readOnly = true;
                input = window.opener.document.getElementById("depotcomposee<?php echo $index; ?>").value = "<?php echo $this->request->data['Article']['depot_id']; ?>";
                input = window.opener.document.getElementById("nouveauart<?php echo $index; ?>").innerHTML = '<a onClick="modifierchamptestindex_recap_nouveau_prix(<?php echo $index; ?>),flvFPW1(wr + `Factureclients/recap_nouveau_prix/<?php echo $index; ?>/<?php echo $id; ?>/<?php echo $this->request->data['Article']['qtevendu']; ?>/<?php echo $this->request->data['Article']['depot_id']; ?>/<?php echo $edit; ?>` ,\`UPLOAD\`, \`width=1200,height=600,scrollbars=yes\`, 0, 2, 2 ); return document.MM_returnValue;" href=\"javascript:;\"  >  <i class=\"glyphicon glyphicon-plus modifierchamptestindex_recap_nouveau_prix\" index=<?php echo $index; ?> style="color: #0080FF"></i></a>';
                window.opener.calculefacture();
                window.close();
            </script>
            <?PHP
            }else{
                $this->redirect(array('controller' =>'Articles', 'action' => 'index'));
            }
        }



        $index_kbira = $index;
        $arts = array();
        $arts = $this->Article->find('first', array(
            'conditions' => array('Article.id' => $article_id),
            'recursive' => -1
        ));
//        debug($arts);
        $articlecomposantes = $this->Articlecomposante->find('all', array(
            'conditions' => array('Articlecomposante.article_id' => $article_id),
            'recursive' => 0
        ));
//        debug($articlecomposantes);
        $numero = $this->Article->find('all', array(
            'fields' => array('MAX(substr(Article.code,5,6)) as num'),
            'conditions' => array('Article.composee' => 1,'Article.code LIKE "GRP/%"')
                )
        );
       //debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        if (!empty($n)) {

            $lastnum = $n;
            $nume = intval($lastnum) + 1;
            $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            $mm = "GRP/" . $mm;
        } else {
            $mm = "GRP/000001";
        }
        $p = CakeSession::read('depot');
        if ($p == 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.id' => $p)));
        }
        if (empty($arts)) {
            $mm = $mm;
        } else {
            $mm = $arts['Article']['code'];
        }
//        debug($edit);die;
        $this->set(compact('model','mm', 'edit', 'qtevendu', 'depot_id', 'arts', 'articlecomposantes', 'depots', 'depot_id', 'lignedevis', 'lignecommandes', 'lignelivrisons', 'lignefactures', 'name', 'index_kbira'));
    }

    public function getnumero() {
        $this->layout = null;
        $this->loadModel('Article');
        $numero = $this->Article->find('all', array(
            'fields' => array('MAX(substr(Article.code,5,6)) as num'),
            'conditions' => array('Article.composee' => 1)
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
            $mm = "GRP/" . $mm;
        } else {
            $mm = "GRP/000001";
        }
        echo json_encode(array('numero' => $mm));
        die();
    }

    public function etatfacture() {
        $this->loadModel('Client');
        $this->loadModel('Pointdevente');
        $this->loadModel('Exercice');


        CakeSession::delete('date1');
        CakeSession::delete('date2');
        CakeSession::delete('clientidfacture');
        CakeSession::delete('anneefacture');
        CakeSession::delete('pvfacture');

        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.etat' => 1, 'Client.societe' => $composantsoc)
        ));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];

        $types = array();
        $types['Exonore'] = "Exonoré";
        $types['Avoir'] = "Avoir";
        $types['Tout'] = "Tout";

        $this->set(compact('t', 'pointdeventeid', 'client_id', 'exercice_id', 'pointdeventes', 'clientid', 'date1', 'date2', 'clients', 'exercices', 'exerciceid', 'types'));
    }

    public function etatfacturesession() {
        CakeSession::delete('date1');
        CakeSession::delete('date2');
        CakeSession::delete('clientidfacture');
        CakeSession::delete('anneefacture');
        CakeSession::delete('pvfacture');
        //print_r($this->request->data);die;
        $date1 = $this->request->data['date1'];
        $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $date1)));
        $date2 = $this->request->data['date2'];
        $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $date2)));
        $clientidfacture = $this->request->data['clientidfacture'];
        $anneefacture = $this->request->data['anneefacture'];
        $pvfacture = $this->request->data['pvfacture'];

        CakeSession::write('date1', $date1);
        CakeSession::write('date2', $date2);
        CakeSession::write('clientidfacture', $clientidfacture);
        CakeSession::write('anneefacture', $anneefacture);
        CakeSession::write('pvfacture', $pvfacture);
        echo true;
        die;
    }

    public function imprimerexonore() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Pointdevente');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Utilisateur');
        $this->loadModel('Factureavoir');
        $this->loadModel('Tva');
        $this->loadModel('Exonorationclient');

        //debug($this->request->query);die;

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $clientidfacture = CakeSession::read('clientidfacture');
        $anneefacture = CakeSession::read('anneefacture');
        $pvfacture = CakeSession::read('pvfacture');

        //debug($date1); debug($date2); debug($clientidfacture); debug($anneefacture); debug($pvfacture);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        //$condexonore = 'Client.typeclient_id=2';

        $condexonore = '';
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = @$exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id =' . $exe;
        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }

        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($anneefacture != 0) {
            $exerciceid = $anneefacture;
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
            $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];

            $pcondf4 = ' and factureclients.exercice_id =' . $exercices[$exerciceid];
            $pconda4 = ' and factureavoirs.exercice_id =' . $exercices[$exerciceid];
        }
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondf1 = ' and factureclients.date >= ' . "'" . $date1 . "'";

            $condf4 = "";
            $conda4 = "";

            $pcondf4 = "";
            $pconda4 = "";
        }
        $condf2 = "";
        $conda2 = "";
        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondf2 = ' and factureclients.date <= ' . "'" . $date2 . "'";
            $pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";

            $condf4 = "";
            $conda4 = "";

            $pcondf4 = "";
            $pconda4 = "";
        }

        if ($clientidfacture != 0) {
            $clientid = $clientidfacture;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id =' . $clientid;
            $conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf3 = ' and factureclients.client_id =' . $clientid;
            $pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }


        if ($pvfacture != 0) {
            $pointdeventeid = $pvfacture;
//            $condb5 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
            $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
            $pv = "";
            $pvf = "";
            $pva = "";

            $pcondf5 = ' and factureclients.pointdevente_id =' . $pointdeventeid;
            $pconda5 = ' and factureavoirs.pointdevente_id =' . $pointdeventeid;
        }
        $cp = 0;

        $tmps = $this->Factureclient->query(
                'SELECT tmp.tva
        FROM (
        (SELECT  lignefactureclients.tva
        FROM  lignefactureclients ,factureclients
        where  factureclients.id=lignefactureclients.factureclient_id and lignefactureclients.tva!=0
        ' . @$pcondf1 . @$pcondf2 . @$pcondf3 . @$pcondf4 . @$pcondf5 . @$pcondf6 . @$pcondf7 . '
        group BY  lignefactureclients.tva
        )
        UNION ALL(
        SELECT  lignefactureavoirs.tva
        FROM  lignefactureavoirs,factureavoirs
        where  factureavoirs.id=lignefactureavoirs.factureavoir_id and lignefactureavoirs.tva!=0
        ' . @$pconda1 . @$pconda2 . @$pconda3 . @$pconda4 . @$pconda5 . @$pconda6 . @$pconda7 . '
        group BY  lignefactureavoirs.tva
        )
        )tmp
        group BY tmp.tva desc');

        $tvas=array();
        foreach ($tmps as $i => $t) {
            $tvas[$i]['Tva']['name'] = $t['tmp']['tva'];
        }

        sort($tvas);

//******************************************************************************************************************************


        $lignefactures = $this->Factureclient->find('all', array(
            'conditions' => array(@$pvf, @$condf1, @$condf2, @$condf3, @$condf4, @$condf5, @$condf6, @$condf7,"Factureclient.typeclient_id"=>2), 'order' => array('Factureclient.numero' => 'ASC'), 'contain' => array('Client', 'Timbre'), 'recursive' => 1));
        //debug($lignefactures);die;
        foreach ($lignefactures as $lignefacture) {

            $num_exono = $this->Exonorationclient->find('first', array('conditions' => (array('Exonorationclient.client_id' => $lignefacture['Factureclient']['client_id']
            , 'Exonorationclient.datedu <= ' => $lignefacture['Factureclient']['date'], 'Exonorationclient.dateau >= ' => $lignefacture['Factureclient']['date'])), 'recursive' => -1));


            $exono=$lignefacture['Factureclient']['typeclient_id'];
            if (floatval($exono) != 1) {

                @$name = $lignefacture['Client']['name'];
                @$adresse = $lignefacture['Client']['adresse'];
                @$mat = $lignefacture['Client']['matriculefiscale'];

                $tablignefactures[$cp]['id_piece'] = $lignefacture['Factureclient']['id'];
                $tablignefactures[$cp]['client'] = $name;
                $tablignefactures[$cp]['num_exe'] = @$num_exono['Exonorationclient']['num_exe'];
                $tablignefactures[$cp]['matriculefiscal'] = $mat;
                $tablignefactures[$cp]['date'] = $lignefacture['Factureclient']['date'];
                $tablignefactures[$cp]['type'] = "Facture client";
                $tablignefactures[$cp]['numero'] = $lignefacture['Factureclient']['numero'];
                $tablignefactures[$cp]['remise'] = $lignefacture['Factureclient']['remise'];
                $tablignefactures[$cp]['fodec'] = $lignefacture['Factureclient']['fodec'];
                $tablignefactures[$cp]['tva'] = $lignefacture['Factureclient']['tva'];
                $tablignefactures[$cp]['totalht'] = $lignefacture['Factureclient']['totalht'];
                $tablignefactures[$cp]['totalttc'] = $lignefacture['Factureclient']['totalttc'];
                $tablignefactures[$cp]['timbre'] = $lignefacture['Factureclient']['timbre_id'];

                $cp++;
            }
        }

//**********************************************************************************************************
        $lignefactureavoirs = $this->Factureavoir->find('all', array(
            'conditions' => array(@$pva, @$conda1, @$conda2, @$conda3, @$conda4, @$conda5, @$conda6, @$conda7,"Factureavoir.typeclient_id"=>2), 'order' => array('Factureavoir.numero' => 'ASC'), 'contain' => array('Client', 'Timbre'), 'recursive' => 1));

        foreach ($lignefactureavoirs as $lignefactureavoir) {

            $num_exono = $this->Exonorationclient->find('first', array('conditions' => (array('Exonorationclient.client_id' => $lignefactureavoir['Factureavoir']['client_id']
            , 'Exonorationclient.datedu <= ' => $lignefactureavoir['Factureavoir']['date'], 'Exonorationclient.dateau >= ' => $lignefactureavoir['Factureavoir']['date'])), 'recursive' => -1));


            $exono=$lignefactureavoir['Factureavoir']['typeclient_id'];
            if (floatval($exono) != 0) {

                @$name = $lignefactureavoir['Client']['name'];
                @$adresse = $lignefactureavoir['Client']['adresse'];
                @$mat = $lignefactureavoir['Client']['matriculefiscale'];
                $tablignefactures[$cp]['id_piece'] = $lignefactureavoir['Factureavoir']['id'];
                $tablignefactures[$cp]['client'] = $name;
                $tablignefactures[$cp]['num_exe'] = @$num_exono['Exonorationclient']['num_exe'];
                $tablignefactures[$cp]['matriculefiscal'] = $mat;
                $tablignefactures[$cp]['date'] = $lignefactureavoir['Factureavoir']['date'];
                $tablignefactures[$cp]['type'] = "Facture Avoir";
                $tablignefactures[$cp]['numero'] = $lignefactureavoir['Factureavoir']['numero'];
                $tablignefactures[$cp]['remise'] = $lignefactureavoir['Factureavoir']['remise'];
                $tablignefactures[$cp]['fodec'] = $lignefactureavoir['Factureavoir']['fodec'];
                $tablignefactures[$cp]['tva'] = $lignefactureavoir['Factureavoir']['tva'];
                $tablignefactures[$cp]['totalht'] = $lignefactureavoir['Factureavoir']['totalht'];
                $tablignefactures[$cp]['totalttc'] = $lignefactureavoir['Factureavoir']['totalttc'];
                $tablignefactures[$cp]['timbre'] = 0;


                $cp++;
            }
        }
//******************************************************************************************************************************

//        debug($tablignefactures);die;
        //$clients = $this->Client->find('list');
        //$pointdeventes = $this->Pointdevente->find('list');
        //$exercices = $this->Exercice->find('list');
        $types = array();
        $types['Exonore'] = "Exonoré";
        $types['Avoir'] = "Avoir";
        $types['Tout'] = "Tout";
        //debug($tablignefactures);die;*
        //$tvas = $this->Tva->find('all', array('recursive' => -1));

        $this->set(compact('exercices','pvfacture', 'date1', 'date2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function imprimeravoir() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Pointdevente');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Utilisateur');
        $this->loadModel('Factureavoir');
        $this->loadModel('Tva');

        //debug($this->request->query);die;

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $clientidfacture = CakeSession::read('clientidfacture');
        $anneefacture = CakeSession::read('anneefacture');
        $pvfacture = CakeSession::read('pvfacture');

        //debug($date1); debug($date2); debug($clientidfacture); debug($anneefacture); debug($pvfacture);die;

        /*         * ************************************************************* */
        $tablignefactures = array();



        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = @$exercice['Exercice']['id'];

        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }

        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondf1 = ' and factureclients.date >= ' . "'" . $date1 . "'";

            $condf4 = "";
            $conda4 = "";

            $pcondf4 = "";
            $pconda4 = "";
        }
        $condf2 = "";
        $conda2 = "";

        if ($anneefacture != 0) {
            $exerciceid = $anneefacture;
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
            $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];

            $pcondf4 = ' and factureclients.exercice_id =' . $exercices[$exerciceid];
            $pconda4 = ' and factureavoirs.exercice_id =' . $exercices[$exerciceid];
        }

        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondf2 = ' and factureclients.date <= ' . "'" . $date2 . "'";
            $pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";

            $condf4 = "";
            $conda4 = "";

            $pcondf4 = "";
            $pconda4 = "";
        }

        if ($clientidfacture != 0) {
            $clientid = $clientidfacture;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id =' . $clientid;
            $conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf3 = ' and factureclients.client_id =' . $clientid;
            $pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }


        if ($pvfacture != 0) {
            $pointdeventeid = $pvfacture;
//            $condb5 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
            $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
            $pv = "";
            $pvf = "";
            $pva = "";

            $pcondf5 = ' and factureclients.pointdevente_id =' . $pointdeventeid;
            $pconda5 = ' and factureavoirs.pointdevente_id =' . $pointdeventeid;
        }
        $cp = 0;


        $tmps = $this->Factureclient->query(
                'SELECT tmp.tva
        FROM (
        (SELECT  lignefactureavoirs.tva
        FROM  lignefactureavoirs,factureavoirs
        where  factureavoirs.id=lignefactureavoirs.factureavoir_id and lignefactureavoirs.tva!=0
        ' . @$pconda1 . @$pconda2 . @$pconda3 . @$pconda4 . @$pconda5 . @$pconda6 . @$pconda7 . '
        group BY  lignefactureavoirs.tva
        )
        )tmp
        group BY tmp.tva desc');

        $tvas=array();
        foreach ($tmps as $i => $t) {
            $tvas[$i]['Tva']['name'] = $t['tmp']['tva'];
        }

        sort($tvas); //debug($tvas);die;
//**********************************************************************************************************
        $lignefactureavoirs = $this->Factureavoir->find('all', array(
            'conditions' => array(@$pva, @$conda1, @$conda2, @$conda3, @$conda4, @$conda5, @$conda6, @$conda7), 'order' => array('Factureavoir.numero' => 'ASC'), 'contain' => array('Client', 'Timbre'), 'recursive' => 1));

        foreach ($lignefactureavoirs as $lignefactureavoir) {
            @$name = $lignefactureavoir['Client']['name'];
            @$adresse = $lignefactureavoir['Client']['adresse'];
            @$mat = $lignefactureavoir['Client']['matriculefiscale'];
            @$code = $lignefactureavoir['Client']['code'];
            $tablignefactures[$cp]['id_piece'] = $lignefactureavoir['Factureavoir']['id'];
            $tablignefactures[$cp]['client'] = $name;
            $tablignefactures[$cp]['adresse'] = @$adresse;
            $tablignefactures[$cp]['matriculefiscal'] = $mat;
            $tablignefactures[$cp]['code'] = $code;
            $tablignefactures[$cp]['date'] = $lignefactureavoir['Factureavoir']['date'];
            $tablignefactures[$cp]['type'] = "Facture Avoir";
            $tablignefactures[$cp]['numero'] = $lignefactureavoir['Factureavoir']['numero'];
            $tablignefactures[$cp]['remise'] = $lignefactureavoir['Factureavoir']['remise'];
            $tablignefactures[$cp]['fodec'] = $lignefactureavoir['Factureavoir']['fodec'];
            $tablignefactures[$cp]['tva'] = $lignefactureavoir['Factureavoir']['tva'];
            $tablignefactures[$cp]['totalht'] = $lignefactureavoir['Factureavoir']['totalht'];
            $tablignefactures[$cp]['totalttc'] = $lignefactureavoir['Factureavoir']['totalttc'];
            $tablignefactures[$cp]['timbre'] = $lignefactureavoir['Timbre']['timbre'];


            $cp++;
        }
//******************************************************************************************************************************


        //$clients = $this->Client->find('list');
        //$pointdeventes = $this->Pointdevente->find('list');
        //$exercices = $this->Exercice->find('list');
        $types = array();
        $types['Exonore'] = "Exonoré";
        $types['Avoir'] = "Avoir";
        $types['Tout'] = "Tout";
        //debug($tablignefactures);die;*
        //$tvas = $this->Tva->find('all', array('recursive' => -1));

        $this->set(compact('exercices','pvfacture', 'date1', 'date2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function imprimertout() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Pointdevente');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Utilisateur');
        $this->loadModel('Factureavoir');
        $this->loadModel('Tva');
        $this->loadModel('Exonorationclient');
        //debug($this->request->query);die;

        $this->response->type('pdf');
        $this->layout = 'pdf';

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $clientidfacture = CakeSession::read('clientidfacture');
        $anneefacture = CakeSession::read('anneefacture');
        $pvfacture = CakeSession::read('pvfacture');

        //debug($date1); debug($date2); debug($clientidfacture); debug($anneefacture); debug($pvfacture);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        $condexonore = 'Client.typeclient_id=2';

        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id =' . $exe;
        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }

        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($anneefacture != 0) {
            $exerciceid = $anneefacture;
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
            $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];

            $pcondf4 = ' and factureclients.exercice_id =' . $exercices[$exerciceid];
            $pconda4 = ' and factureavoirs.exercice_id =' . $exercices[$exerciceid];
        }
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondf1 = ' and factureclients.date >= ' . "'" . $date1 . "'";

            $condf4 = "";
            $conda4 = "";

            $pcondf4 = "";
            $pconda4 = "";
        }
        $condf2 = "";
        $conda2 = "";
        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondf2 = ' and factureclients.date <= ' . "'" . $date2 . "'";
            $pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";

            $condf4 = "";
            $conda4 = "";

            $pcondf4 = "";
            $pconda4 = "";
        }

        if ($clientidfacture != 0) {
            $clientid = $clientidfacture;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id =' . $clientid;
            $conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf3 = ' and factureclients.client_id =' . $clientid;
            $pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }


        if ($pvfacture != 0) {
            $pointdeventeid = $pvfacture;
//            $condb5 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
            $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
            $pv = "";
            $pvf = "";
            $pva = "";

            $pcondf5 = ' and factureclients.pointdevente_id =' . $pointdeventeid;
            $pconda5 = ' and factureavoirs.pointdevente_id =' . $pointdeventeid;
        }
        $cp = 0;
        $tvas = array();
        $tmps = $this->Factureclient->query(
                'SELECT tmp.tva
        FROM (
        (SELECT  lignefactureclients.tva
        FROM  lignefactureclients ,factureclients
        where  factureclients.id=lignefactureclients.factureclient_id and lignefactureclients.tva!=0
        ' . @$pcondf1 . @$pcondf2 . @$pcondf3 . @$pcondf4 . @$pcondf5 . @$pcondf6 . @$pcondf7 . '
        group BY  lignefactureclients.tva
        )
        UNION ALL(
        SELECT  lignefactureavoirs.tva
        FROM  lignefactureavoirs,factureavoirs
        where  factureavoirs.id=lignefactureavoirs.factureavoir_id and lignefactureavoirs.tva!=0
        ' . @$pconda1 . @$pconda2 . @$pconda3 . @$pconda4 . @$pconda5 . @$pconda6 . @$pconda7 . '
        group BY  lignefactureavoirs.tva
        )
        )tmp
        group BY tmp.tva desc');

        $tvas=array();
        foreach ($tmps as $i => $t) {
            $tvas[$i]['Tva']['name'] = $t['tmp']['tva'];
        }

        sort($tvas);
        $listvaall=array();

        //debug($tvas);die;
//        $ftva = $this->Lignefactureclient->find('all', array(
//            'fields'=>  array('Lignefactureclient.tva'),
//            'conditions' => array('Lignefactureclient.tva !=0',@$pvf, @$condf1, @$condf2, @$condf3, @$condf4, @$condf5, @$condf6, @$condf7),
//            'group' => array('Lignefactureclient.tva'), 'recursive' => 0));
//        $atva = $this->Lignefactureavoir->find('all', array(
//            'fields'=>  array('Lignefactureavoir.tva'),
//            'conditions' => array('Lignefactureavoir.tva !=0',@$pva, @$conda1, @$conda2, @$conda3, @$conda4, @$conda5, @$conda6, @$conda7),
//            'group' => array('Lignefactureavoir.tva'), 'recursive' => 0));
//
//        debug($ftva);
//                debug($atva);die;
        $selecttvabase = '';
        $selecttva = '';
        $selecttvabaseavoir = '';
        $selecttvaavoir = '';
        foreach ($tvas as $k => $t) {
            $tv = intval(floatval($t['Tva']['name']));
            if ($selecttvabase != '') {
                $selecttvabase = $selecttvabase . ',' . 'sum(case when lignefactureclients.tva = ' . $tv . ' then lignefactureclients.totalht else 0 end) as base' . $tv;
                $selecttva = $selecttva . ',' . 'sum(case when lignefactureclients.tva = ' . $tv . ' then round((lignefactureclients.totalht * lignefactureclients.tva)/100,3) else 0 end) as tva' . $tv;
            } else {
                $selecttvabase = $selecttvabase . 'sum(case when lignefactureclients.tva = ' . $tv . ' then lignefactureclients.totalht else 0 end) as base' . $tv;
                $selecttva = $selecttva . 'sum(case when lignefactureclients.tva = ' . $tv . ' then round((lignefactureclients.totalht * lignefactureclients.tva)/100,3) else 0 end) as tva' . $tv;
            }

            if ($selecttvabaseavoir != '') {
                $selecttvabaseavoir = $selecttvabaseavoir . ',' . 'sum(case when lignefactureavoirs.tva = ' . $tv . ' then lignefactureavoirs.totalht else 0 end) as base' . $tv;
                $selecttvaavoir = $selecttvaavoir . ',' . 'sum(case when lignefactureavoirs.tva = ' . $tv . ' then round((lignefactureavoirs.totalht * lignefactureavoirs.tva)/100,3) else 0 end) as tva' . $tv;
            } else {
                $selecttvabaseavoir = $selecttvabaseavoir . 'sum(case when lignefactureavoirs.tva = ' . $tv . ' then lignefactureavoirs.totalht else 0 end) as base' . $tv;
                $selecttvaavoir = $selecttvaavoir . 'sum(case when lignefactureavoirs.tva = ' . $tv . ' then round((lignefactureavoirs.totalht * lignefactureavoirs.tva)/100,3) else 0 end) as tva' . $tv;
            }
        }
//        debug($selecttvabase);
//        debug($selecttva);
        //die;
        $condfacture='';
        if ($selecttvabase != '') {
            $condfacture = ','.$selecttvabase . ',' . $selecttva;
        }
//******************************************************************************************************************************
//        $lignefactures = $this->Factureclient->find('all', array(
//            'conditions' => array(@$pvf, @$condf1, @$condf2, @$condf3, @$condf4, @$condf5, @$condf6, @$condf7), 'order' => array('Factureclient.numero' => 'ASC'), 'contain' => array('Client'), 'recursive' => 0));
        $lignefactures = $this->Factureclient->query('select factureclients.id,factureclients.totalht,factureclients.numero,factureclients.date,factureclients.timbre_id,factureclients.totalttc,factureclients.typeclient_id,clients.code,clients.name,clients.id
        ' . $condfacture . '
         from lignefactureclients ,factureclients ,clients  where lignefactureclients.factureclient_id=factureclients.id and factureclients.client_id=clients.id ' . @$pcondf1 . @$pcondf2 . @$pcondf3 . @$pcondf4 . @$pcondf5 . @$pcondf6 . @$pcondf7 . ' group by factureclients.numero');
     //   debug($lignefactures);die;
        $ccp = 0;
        foreach ($lignefactures as $lignefacture) {
            $venteexos = $this->Lignefactureclient->find('all', array('fields' => array('SUM(Lignefactureclient.totalht) as totalht')
            , 'conditions' => array('Lignefactureclient.factureclient_id' => $lignefacture['factureclients']['id'],'Lignefactureclient.tva'=>0),'recursive'=>-1));
            if((empty($venteexos[0][0]['totalht']))||($venteexos[0][0]['totalht']==0)){
                $venteexo="";
            }else{
               $venteexo= $venteexos[0][0]['totalht'];
            }
            //debug($venteexos);
//            $exono = $this->Exonorationclient->find('count', array('conditions' => (array('Exonorationclient.client_id' => $lignefacture['clients']['id']
//            , 'Exonorationclient.datedu <= ' => $lignefacture['factureclients']['date'], 'Exonorationclient.dateau >= ' => $lignefacture['factureclients']['date'])), 'recursive' => -1));

            $exono=$lignefacture['factureclients']['typeclient_id'];





            if (floatval($exono) != 1) {
                $ventesup = $lignefacture['factureclients']['totalht'];
            } else {
                $ventesup = "";
            }

            foreach ($tvas as $t) {
                if (floatval($exono) == 1) {
                    $tv = intval(floatval($t['Tva']['name']));
                    $tablignefactures[$cp]['base' . $tv] = $lignefacture[0]['base' . $tv];
                    $tablignefactures[$cp]['tva' . $tv] = $lignefacture[0]['tva' . $tv];

                    $listvaall[$ccp]['nom'] = 'Base ' . $tv . '%';
                    $listvaall[$ccp]['mtva'] = sprintf("%.3f", $lignefacture[0]['tva' . $tv]);
                    $listvaall[$ccp]['base'] = sprintf("%.3f", $lignefacture[0]['base' . $tv]);
                    $listvaall[$ccp]['tva'] = intval(floatval($tv));
                    $ccp++;
                } else {
                    $tv = intval(floatval($t['Tva']['name']));
                    $tablignefactures[$cp]['base' . $tv] = 0;
                    $tablignefactures[$cp]['tva' . $tv] = 0;

                    $listvaall[$ccp]['nom'] = 'Base ' . $tv . '%';
                    $listvaall[$ccp]['mtva'] = 0;
                    $listvaall[$ccp]['base'] = 0;
                    $listvaall[$ccp]['tva'] = intval(floatval($tv));
                    $ccp++;
                }
            }

            $tablignefactures[$cp]['venteexo'] = $venteexo;
            $tablignefactures[$cp]['ventesup'] = $ventesup;
            $tablignefactures[$cp]['id_piece'] = $lignefacture['factureclients']['id'];
            $tablignefactures[$cp]['idclient'] = $lignefacture['clients']['id'];
            $tablignefactures[$cp]['client'] = $lignefacture['clients']['name'];
            $tablignefactures[$cp]['code'] = $lignefacture['clients']['code'];
            $tablignefactures[$cp]['date'] = $lignefacture['factureclients']['date'];
            $tablignefactures[$cp]['type'] = "Facture client";
            $tablignefactures[$cp]['numero'] = $lignefacture['factureclients']['numero'];
            $tablignefactures[$cp]['totalttc'] = $lignefacture['factureclients']['totalttc'];
            $tablignefactures[$cp]['timbre'] = $lignefacture['factureclients']['timbre_id'];

            $cp++;
        }
      //  debug($tablignefactures);
       // die;
//**********************************************************************************************************
//        $lignefactureavoirs = $this->Factureavoir->find('all', array(
//            'conditions' => array(@$pva, @$conda1, @$conda2, @$conda3, @$conda4, @$conda5, @$conda6, @$conda7), 'order' => array('Factureavoir.numero' => 'ASC'), 'contain' => array('Client', 'Timbre'), 'recursive' => 1));
        $condfactureavoir='';
        if ($selecttvabaseavoir != '') {
            $condfactureavoir = ','.$selecttvabaseavoir . ',' . $selecttvaavoir;
        }
        $lignefactureavoirs = $this->Factureavoir->query('select factureavoirs.id,factureavoirs.totalht,factureavoirs.numero,factureavoirs.date,factureavoirs.timbre_id,factureavoirs.totalttc,factureavoirs.typeclient_id,clients.code,clients.name,clients.id
        ' . $condfactureavoir . '
         from lignefactureavoirs ,factureavoirs ,clients  where lignefactureavoirs.factureavoir_id=factureavoirs.id and factureavoirs.client_id=clients.id ' . @$pconda1 . @$pconda2 . @$pconda3 . @$pconda4 . @$pconda5 . @$pconda6 . @$pconda7 . ' group by factureavoirs.numero');

//debug($lignefactureavoirs);die;
        foreach ($lignefactureavoirs as $lignefactureavoir) { //debug($lignefactureavoir);die;

//            $exono = $this->Exonorationclient->find('count', array('conditions' => (array('Exonorationclient.client_id' => $lignefactureavoir['clients']['id']
//            , 'Exonorationclient.datedu <= ' => $lignefactureavoir['factureavoirs']['date'], 'Exonorationclient.dateau >= ' => $lignefactureavoir['factureavoirs']['date'])), 'recursive' => -1));
            $exono=$lignefactureavoir['factureavoirs']['typeclient_id'];
            if (floatval($exono) != 1) {
                $ventesup = 0-$lignefactureavoir['factureavoirs']['totalht'];
            } else {
                $ventesup = "";
            }

            foreach ($tvas as $t) {
                if (floatval($exono) == 1) {
                    $tv = intval(floatval($t['Tva']['name']));
                    $tablignefactures[$cp]['base' . $tv] =0- $lignefactureavoir[0]['base' . $tv];
                    $tablignefactures[$cp]['tva' . $tv] = 0-$lignefactureavoir[0]['tva' . $tv];

                    $listvaall[$ccp]['nom'] = 'Base ' . $tv . '%';
                    $listvaall[$ccp]['mtva'] = 0-sprintf("%.3f", $lignefactureavoir[0]['tva' . $tv]);
                    $listvaall[$ccp]['base'] = 0-sprintf("%.3f", $lignefactureavoir[0]['base' . $tv]);
                    $listvaall[$ccp]['tva'] = intval(floatval($tv));
                    $ccp++;
                } else {
                    $tv = intval(floatval($t['Tva']['name']));
                    $tablignefactures[$cp]['base' . $tv] = 0;
                    $tablignefactures[$cp]['tva' . $tv] = 0;

                    $listvaall[$ccp]['nom'] = 'Base ' . $tv . '%';
                    $listvaall[$ccp]['mtva'] = 0;
                    $listvaall[$ccp]['base'] = 0;
                    $listvaall[$ccp]['tva'] = intval(floatval($tv));
                    $ccp++;
                }
            }

            $tablignefactures[$cp]['venteexo'] = "";
            $tablignefactures[$cp]['ventesup'] = 0-$ventesup;
            $tablignefactures[$cp]['id_piece'] = $lignefactureavoir['factureavoirs']['id'];
            $tablignefactures[$cp]['client'] = @$lignefactureavoir['clients']['name'];
            $tablignefactures[$cp]['idclient'] = @$lignefactureavoir['factureavoirs']['client_id'];
            $tablignefactures[$cp]['code'] = @$lignefactureavoir['clients']['code'];
            $tablignefactures[$cp]['date'] = $lignefactureavoir['factureavoirs']['date'];
            $tablignefactures[$cp]['type'] = "Facture Avoir";
            $tablignefactures[$cp]['numero'] = $lignefactureavoir['factureavoirs']['numero'];
            $tablignefactures[$cp]['totalttc'] = 0-$lignefactureavoir['factureavoirs']['totalttc'];
            $tablignefactures[$cp]['timbre'] = 0;


            $cp++;
        }
//******************************************************************************************************************************


        ////$clients = $this->Client->find('list');
        //$pointdeventes = $this->Pointdevente->find('list');
        //$exercices = $this->Exercice->find('list');
        $types = array();
        $types['Exonore'] = "Exonoré";
        $types['Avoir'] = "Avoir";
        $types['Tout'] = "Tout";
        //debug($tablignefactures);
//        die;
        //$tvas = $this->Tva->find('all', array('recursive' => -1));

        $this->set(compact('exercices','pvfacture', 'listvaall', 'lignefacturessomme', 'date1', 'date2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

     public function getreste($factureclient_id = null, $action = null, $id = null) {
        $this->layout = null;
        $json = null;

        $facture = $this->Factureclient->find('first', array(
            'conditions' => array('Factureclient.id' => $factureclient_id),
            'recursive' => -1,
            'fields' => array('Factureclient.totalttc', 'Factureclient.Montant_Regler')
        ));
        if ($action == "edit") {
            $this->loadModel('Factureavoir');
            $this->loadModel('Imputationfactureavoir');
            $impts = $this->Imputationfactureavoir->find('first', array('conditions' => array('Imputationfactureavoir.factureavoir_id' => $id, 'Imputationfactureavoir.factureclient_id' => $factureclient_id), false));
            if (!empty($impts)) {
                $facture['Factureclient']['Montant_Regler'] = $facture['Factureclient']['Montant_Regler'] - $impts['Imputationfactureavoir']['montant'];
            }
        }
        $reste = $facture['Factureclient']['totalttc'] - $facture['Factureclient']['Montant_Regler'];
        echo json_encode(array('reste' => $reste));
        die();
    }

    public function imprimerhaitham($id = null) {
        $this->response->type('pdf');
        $this->layout = 'pdf';
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Lignefactureclient');
        if (!$this->Factureclient->exists($id)) {
            throw new NotFoundException(__('Invalid bonreception'));
        }
        $options = array('conditions' => array('Factureclient.' . $this->Factureclient->primaryKey => $id));
        $this->set('factureclient', $this->Factureclient->find('first', $options));

        $lignefactureclients = $this->Lignefactureclient->find('all', array(
            //'limit'=>41,
            'conditions' => array('Lignefactureclient.factureclient_id' => $id)
            , 'order' => array('Lignefactureclient.bonlivraison_id' => 'asc')));
//debug($lignefactureclients);die;
        $lignefactureclientstva = $this->Lignefactureclient->find('all', array('fields' => array(
                'SUM(Lignefactureclient.totalht*Lignefactureclient.tva)/100  mtva'
                , 'SUM(Lignefactureclient.totalht) totalht'
                , 'AVG(Lignefactureclient.tva) tva'),
            'conditions' => array('Lignefactureclient.factureclient_id' => $id)
            , 'group' => array('Lignefactureclient.tva')
        ));
        //debug($lignefactureclients)  ;die;
        $this->set(compact('lignefactureclients', 'lignefactureclientstva'));
    }

    public function numerofac() {
        $this->layout = null;
		$data = $this->request->data;
        $val = $data['val'];
        $tab = explode(' ', $val);
//        debug($tab);
        $ch = "'";
        foreach ($tab as $tabb) {
//        debug($tabb);
            $ch = $ch . '%`' . $tabb . '`';
        }
        $ch .= "%'";
        $cond = "Factureclient.numero LIKE " . $ch;
//        debug($cond);
//        $ch = str_replace(" ","",$ch);
//        debug($ch);die;
        $numero = $this->Factureclient->find('all', array(
            'conditions' => array($cond),
            'recursive' => -1,
            'fields' => array('Factureclient.id', 'Factureclient.numero'),
            'group' => array('Factureclient.id'),
			'limit' => 20
        ));
//        debug($numero);die;
        echo json_encode(array('numero' => $numero)); // Tableau to JSON <> Json_Decode JOSN TO TABLE
        die;
    }

    public function etatfacturedetails() {
        $this->loadModel('Client');
        $this->loadModel('Pointdevente');
        $this->loadModel('Exercice');
        $this->loadModel('Zone');


        CakeSession::delete('date1');
        CakeSession::delete('date2');
        CakeSession::delete('reglementr');
        CakeSession::delete('triagee');
        CakeSession::delete('ventee');
        CakeSession::delete('clientcode');
        CakeSession::delete('zonedetail');

        $clients = $this->Client->find('list');
        $zones = $this->Zone->find('list');

        $reglements = array();
        $reglements['Touslesfactures'] = "Tous les factures";
        $reglements['Facturesreglees'] = "Factures reglees";
        $reglements['Facturesnonreglees'] = "Factures non reglees";

        $triages = array();
        $triages['Parnumfacture'] = "Par N° facture";
        $triages['Pardate'] = "Par date";
        $triages['Parcodeclient'] = "Par code client";

        $ventes = array();
        $ventes['Touslesventes'] = "Tous les ventes";
        $ventes['BLF'] = "BLF";
        $ventes['Facture'] = "Facture";

        $this->set(compact('t', 'reglements', 'triages', 'ventes', 'zones', 'pointdeventeid', 'client_id', 'exercice_id', 'pointdeventes', 'clientid', 'date1', 'date2', 'clients', 'exercices', 'exerciceid', 'types'));
    }

    public function etatfacturesession2() {
        CakeSession::delete('date1');
        CakeSession::delete('date2');
        CakeSession::delete('reglement');
        CakeSession::delete('triage');
        CakeSession::delete('vente');
        CakeSession::delete('clientcode');
        CakeSession::delete('zonedetail');
        //print_r($this->request->data);die;
        $date1 = $this->request->data['date1'];
        $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $date1)));
        $date2 = $this->request->data['date2'];
        $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $date2)));
        $reglement = $this->request->data['reglement'];
        $triage = $this->request->data['triage'];
        $vente = $this->request->data['vente'];
        $clientcode = $this->request->data['clientcode'];
        $zonedetail = $this->request->data['zonedetail'];

        CakeSession::write('date1', $date1);
        CakeSession::write('date2', $date2);
        CakeSession::write('reglementt', $reglement);
        CakeSession::write('triagee', $triage);
        CakeSession::write('ventee', $vente);
        CakeSession::write('clientcode', $clientcode);
        CakeSession::write('zonedetail', $zonedetail);
        echo true;
        die;
    }

    public function imprimeravecdetails() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Pointdevente');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Utilisateur');
        $this->loadModel('Factureavoir');
        $this->loadModel('Tva');

        //debug($this->request->query);die;

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $reglement = CakeSession::read('reglement');
        $triage = CakeSession::read('triage');
        $vente = CakeSession::read('vente');
        $clientcode = CakeSession::read('clientcode');
        $zonedetail = CakeSession::read('zonedetail');

        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id =' . $exe;
        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }

        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $conddate1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            //$conda1 = 'Factureavoir.date >= '."'".$date1."'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }
        $condf2 = "";
        $conda2 = "";
        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $conddate2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            //$conda2 = 'Factureavoir.date <= '."'".$date2."'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }

        if ($clientcode != 0) {
            $clientid = $clientcode;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condclt = 'Factureclient.client_id =' . $clientid;
            //$conda3 = 'Factureavoir.client_id ='.$clientid;
        }
        if ($zonedetail != 0) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condzone = 'Client.zone_id =' . $zonedetail;
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        }

        if ($reglement != 0) {
            if ($reglement == "Facturesreglees") {
                $condregler = 'Factureclient.Montant_Regler !=0';
            }
            if ($reglement == "Facturesnonreglees") {
                $condnonregler = 'Factureclient.Montant_Regler =0';
            }
        }
        if ($vente != 0) {
            if ($vente == "BLF") {
                $condblf = "Factureclient.source ='fac'";
            }
            if ($vente == "Facture") {
                $condnonfacture = "Factureclient.source ='bl'";
            }
        }
        if (isset($triage)) {
            if ($triage == "Parnumfacture") {
                $ordre = 'Factureclient.numero ASC';
            }
            if ($triage == "Pardate") {
                $ordre = 'Factureclient.date ASC';
            }
            if ($triage == "Parcodeclient") {
                $ordre = 'Client.cast(code as signed) Asc';
            }
        }
        $cp = 0;
        //debug($triage);
//******************************************************************************************************************************
        $lignefactures = $this->Factureclient->find('all', array(
            'conditions' => array(@$conddate1, @$conddate2, @$condclt, @$condnonregler, @$condregler, @$condblf, @$condnonfacture), 'contain' => array('Client'), 'order' => @$ordre, 'recursive' => 0));
        //debug($lignefactures);die;
        foreach ($lignefactures as $lignefacture) {


            @$name = $lignefacture['Client']['name'];
            @$adresse = $lignefacture['Client']['adresse'];
            @$mat = $lignefacture['Client']['matriculefiscale'];
            @$code = $lignefacture['Client']['code'];
            @$tel = $lignefacture['Client']['tel'];
            $tablignefactures[$cp]['id_piece'] = $lignefacture['Factureclient']['id'];
            $tablignefactures[$cp]['client'] = $name;
            $tablignefactures[$cp]['adresse'] = @$adresse;
            $tablignefactures[$cp]['matriculefiscal'] = $mat;
            $tablignefactures[$cp]['code'] = $code;
            $tablignefactures[$cp]['tel'] = $tel;
            $tablignefactures[$cp]['date'] = date("d/m/Y", strtotime(str_replace('-', '/', $lignefacture['Factureclient']['date'])));
            $tablignefactures[$cp]['type'] = "Facture client";
            $tablignefactures[$cp]['numero'] = $lignefacture['Factureclient']['numero'];
            $tablignefactures[$cp]['remise'] = $lignefacture['Factureclient']['remise'];
            $tablignefactures[$cp]['fodec'] = $lignefacture['Factureclient']['fodec'];
            $tablignefactures[$cp]['tva'] = $lignefacture['Factureclient']['tva'];
            $tablignefactures[$cp]['totalht'] = $lignefacture['Factureclient']['totalht'];
            $tablignefactures[$cp]['totalttc'] = $lignefacture['Factureclient']['totalttc'];
            $tablignefactures[$cp]['timbre'] = $lignefacture['Factureclient']['timbre_id'];
            $tablignefactures[$cp]['mntregler'] = $lignefacture['Factureclient']['Montant_Regler'];
            $reste = floatval($lignefacture['Factureclient']['totalttc']) - floatval($lignefacture['Factureclient']['Montant_Regler']);
            $tablignefactures[$cp]['reste'] = $reste;

            $cp++;
        }
//******************************************************************************************************************************


        $clients = $this->Client->find('list', array('recursive' => -1));
        $pointdeventes = $this->Pointdevente->find('list', array('recursive' => -1));
        $exercices = $this->Exercice->find('list', array('recursive' => -1));
        $types = array();
        $types['Exonore'] = "Exonoré";
        $types['Avoir'] = "Avoir";
        $types['Tout'] = "Tout";
        //debug($tablignefactures);die;
        //$tvas = $this->Tva->find('all', array('recursive' => -1));

        $this->set(compact('exercices', 'date1', 'date2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function imprimersansdetails() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Pointdevente');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Utilisateur');
        $this->loadModel('Factureavoir');
        $this->loadModel('Tva');

        //debug($this->request->query);die;

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $reglement = CakeSession::read('reglement');
        $triage = CakeSession::read('triage');
        $vente = CakeSession::read('vente');
        $clientcode = CakeSession::read('clientcode');
        $zonedetail = CakeSession::read('zonedetail');

        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id =' . $exe;
        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }

        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $conddate1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            //$conda1 = 'Factureavoir.date >= '."'".$date1."'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }
        $condf2 = "";
        $conda2 = "";
        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $conddate2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            //$conda2 = 'Factureavoir.date <= '."'".$date2."'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }

        if ($clientcode != 0) {
            $clientid = $clientcode;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condclt = 'Factureclient.client_id =' . $clientid;
            //$conda3 = 'Factureavoir.client_id ='.$clientid;
        }
        if ($zonedetail != 0) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condzone = 'Client.zone_id =' . $zonedetail;
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        }

        if ($reglement != 0) {
            if ($reglement == "Facturesreglees") {
                $condregler = 'Factureclient.Montant_Regler !=0';
            }
            if ($reglement == "Facturesnonreglees") {
                $condnonregler = 'Factureclient.Montant_Regler =0';
            }
        }
        if ($vente != 0) {
            if ($vente == "BLF") {
                $condblf = "Factureclient.source ='fac'";
            }
            if ($vente == "Facture") {
                $condnonfacture = "Factureclient.source ='bl'";
            }
        } //debug($triage);
//         if (isset($triage)) {
//            if ($triage=="Parnumfacture") {
//                $ordre = 'Factureclient.numero ASC';
//            }
//            if ($triage=="Pardate") {
//                $ordre = 'Factureclient.date ASC';
//            }
//            if ($triage=="Parcodeclient") {
//                $ordre = 'Client.code ASC';
//            }
        // }
        $ordre = 'Client.cast(code as signed) ASC';
        $cp = 0;
        //debug($triage);
//******************************************************************************************************************************
        $lignefactures = $this->Factureclient->find('all', array(
            'conditions' => array(@$conddate1, @$conddate2, @$condclt, @$condnonregler, @$condregler, @$condblf, @$condnonfacture), 'contain' => array('Client'), 'order' => array(@$ordre), 'recursive' => 0));
        //debug($lignefactures);die;
        foreach ($lignefactures as $lignefacture) {


            @$name = $lignefacture['Client']['name'];
            @$adresse = $lignefacture['Client']['adresse'];
            @$mat = $lignefacture['Client']['matriculefiscale'];
            @$code = $lignefacture['Client']['code'];
            @$tel = $lignefacture['Client']['tel'];

            $tablignefactures[$cp]['client'] = $name;
            $tablignefactures[$cp]['code'] = $code;
            $tablignefactures[$cp]['tel'] = $tel;
            $tablignefactures[$cp]['date'] = date("d/m/Y", strtotime(str_replace('-', '/', $lignefacture['Factureclient']['date'])));
            $tablignefactures[$cp]['numero'] = $lignefacture['Factureclient']['numero'];
            $tablignefactures[$cp]['totalttc'] = $lignefacture['Factureclient']['totalttc'];
            $tablignefactures[$cp]['mntregler'] = $lignefacture['Factureclient']['Montant_Regler'];
            $reste = floatval($lignefacture['Factureclient']['totalttc']) - floatval($lignefacture['Factureclient']['Montant_Regler']);
            $tablignefactures[$cp]['reste'] = $reste;

            $cp++;
        }
//******************************************************************************************************************************


        $clients = $this->Client->find('list', array('recursive' => -1));
        $pointdeventes = $this->Pointdevente->find('list', array('recursive' => -1));
        $exercices = $this->Exercice->find('list', array('recursive' => -1));
        $types = array();
        $types['Exonore'] = "Exonoré";
        $types['Avoir'] = "Avoir";
        $types['Tout'] = "Tout";
        //debug($tablignefactures);die;
        //$tvas = $this->Tva->find('all', array('recursive' => -1));

        $this->set(compact('exercices', 'date1', 'date2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    //************ zeinab *******************//
    public function imprimerexcel() {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'factureclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Client');
        //debug($this->request->query);die;
        $this->layout = '';
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
        }

        if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            $cond3 = 'Factureclient.client_id =' . $clientid;
        }

        $this->loadModel('Utilisateur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $this->loadModel('Personnel');
        if ($this->request->query['societe_id']) {
            $societe_id = $this->request->query['societe_id'];
            $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
            $ch_pv = 0;
            foreach ($lespvs as $lespv) {
                $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
            }
            $cond6 = 'Factureclient.pointdevente_id in (' . $ch_pv . ')';
        }

        if ($this->request->query['pointdevente_id']) {
            $pointdevente_id = $this->request->query['pointdevente_id'];
            $cond7 = 'Factureclient.pointdevente_id =' . $pointdevente_id;
        }
        if ($this->request->query['fac_id']) {
            $fac_id = $this->request->query['fac_id'];
            $cond8 = 'Factureclient.id =' . $fac_id;
            $cond1 = "";
            $cond2 = "";
        }

        $factureclients = $this->Factureclient->find('all', array('conditions' => array('Factureclient.id > ' => 0, @$cond1, @$cond2, @$cond3, @$cond6, @$cond7, @$cond8)));
//        debug($factureclients);die;
        $this->set(compact('factureclients', 'date1', 'date2', 'clientid'));
    }



    public function exportlisteexonore() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Pointdevente');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Utilisateur');
        $this->loadModel('Factureavoir');
        $this->loadModel('Tva');
        $this->loadModel('Exonorationclient');

        $this->layout=NULL;

        //debug($this->request->query);die;

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $clientidfacture = CakeSession::read('clientidfacture');
        $anneefacture = CakeSession::read('anneefacture');
        $pvfacture = CakeSession::read('pvfacture');

        //debug($date1); debug($date2); debug($clientidfacture); debug($anneefacture); debug($pvfacture);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        //$condexonore = 'Client.typeclient_id=2';

        $condexonore = '';
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id =' . $exe;
        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }

        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($anneefacture != 0) {
            $exerciceid = $anneefacture;
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
            $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];

            $pcondf4 = ' and factureclients.exercice_id =' . $exercices[$exerciceid];
            $pconda4 = ' and factureavoirs.exercice_id =' . $exercices[$exerciceid];
        }
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondf1 = ' and factureclients.date >= ' . "'" . $date1 . "'";

            $condf4 = "";
            $conda4 = "";

            $pcondf4 = "";
            $pconda4 = "";
        }
        $condf2 = "";
        $conda2 = "";
        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondf2 = ' and factureclients.date <= ' . "'" . $date2 . "'";
            $pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";

            $condf4 = "";
            $conda4 = "";

            $pcondf4 = "";
            $pconda4 = "";
        }

        if ($clientidfacture != 0) {
            $clientid = $clientidfacture;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id =' . $clientid;
            $conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf3 = ' and factureclients.client_id =' . $clientid;
            $pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }


        if ($pvfacture != 0) {
            $pointdeventeid = $pvfacture;
//            $condb5 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
            $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
            $pv = "";
            $pvf = "";
            $pva = "";

            $pcondf5 = ' and factureclients.pointdevente_id =' . $pointdeventeid;
            $pconda5 = ' and factureavoirs.pointdevente_id =' . $pointdeventeid;
        }
        $cp = 0;

        $tmps = $this->Factureclient->query(
                'SELECT tmp.tva
        FROM (
        (SELECT  lignefactureclients.tva
        FROM  lignefactureclients ,factureclients
        where  factureclients.id=lignefactureclients.factureclient_id and lignefactureclients.tva!=0
        ' . @$pcondf1 . @$pcondf2 . @$pcondf3 . @$pcondf4 . @$pcondf5 . @$pcondf6 . @$pcondf7 . '
        group BY  lignefactureclients.tva
        )
        UNION ALL(
        SELECT  lignefactureavoirs.tva
        FROM  lignefactureavoirs,factureavoirs
        where  factureavoirs.id=lignefactureavoirs.factureavoir_id and lignefactureavoirs.tva!=0
        ' . @$pconda1 . @$pconda2 . @$pconda3 . @$pconda4 . @$pconda5 . @$pconda6 . @$pconda7 . '
        group BY  lignefactureavoirs.tva
        )
        )tmp
        group BY tmp.tva desc');

        $tvas=array();
        foreach ($tmps as $i => $t) {
            $tvas[$i]['Tva']['name'] = $t['tmp']['tva'];
        }

        sort($tvas);

//******************************************************************************************************************************


        $lignefactures = $this->Factureclient->find('all', array(
            'conditions' => array(@$pvf, @$condf1, @$condf2, @$condf3, @$condf4, @$condf5, @$condf6, @$condf7,"Factureclient.typeclient_id"=>2), 'order' => array('Factureclient.numero' => 'ASC'), 'contain' => array('Client', 'Timbre'), 'recursive' => 1));
        //debug($lignefactures);die;
        foreach ($lignefactures as $lignefacture) {

            $num_exono = $this->Exonorationclient->find('first', array('conditions' => (array('Exonorationclient.client_id' => $lignefacture['Factureclient']['client_id']
            , 'Exonorationclient.datedu <= ' => $lignefacture['Factureclient']['date'], 'Exonorationclient.dateau >= ' => $lignefacture['Factureclient']['date'])), 'recursive' => -1));



            $exono=$lignefacture['Factureclient']['typeclient_id'];
            if (floatval($exono) != 1) {

                @$name = $lignefacture['Client']['name'];
                @$adresse = $lignefacture['Client']['adresse'];
                @$mat = $lignefacture['Client']['matriculefiscale'];

                $tablignefactures[$cp]['id_piece'] = $lignefacture['Factureclient']['id'];
                $tablignefactures[$cp]['client'] = $name;
                $tablignefactures[$cp]['num_exe'] = @$num_exono['Exonorationclient']['num_exe'];
                $tablignefactures[$cp]['matriculefiscal'] = $mat;
                $tablignefactures[$cp]['date'] = $lignefacture['Factureclient']['date'];
                $tablignefactures[$cp]['type'] = "Facture client";
                $tablignefactures[$cp]['numero'] = $lignefacture['Factureclient']['numero'];
                $tablignefactures[$cp]['remise'] = $lignefacture['Factureclient']['remise'];
                $tablignefactures[$cp]['fodec'] = $lignefacture['Factureclient']['fodec'];
                $tablignefactures[$cp]['tva'] = $lignefacture['Factureclient']['tva'];
                $tablignefactures[$cp]['totalht'] = $lignefacture['Factureclient']['totalht'];
                $tablignefactures[$cp]['totalttc'] = $lignefacture['Factureclient']['totalttc'];
                $tablignefactures[$cp]['timbre'] = $lignefacture['Factureclient']['timbre_id'];

                $cp++;
            }
        }

//**********************************************************************************************************
        $lignefactureavoirs = $this->Factureavoir->find('all', array(
            'conditions' => array(@$pva, @$conda1, @$conda2, @$conda3, @$conda4, @$conda5, @$conda6, @$conda7,"Factureavoir.typeclient_id"=>2), 'order' => array('Factureavoir.numero' => 'ASC'), 'contain' => array('Client', 'Timbre'), 'recursive' => 1));

        foreach ($lignefactureavoirs as $lignefactureavoir) {

            $num_exono = $this->Exonorationclient->find('count', array('conditions' => (array('Exonorationclient.client_id' => $lignefactureavoir['Factureavoir']['client_id']
            , 'Exonorationclient.datedu <= ' => $lignefactureavoir['Factureavoir']['date'], 'Exonorationclient.dateau >= ' => $lignefactureavoir['Factureavoir']['date'])), 'recursive' => -1));


            $exono=$lignefactureavoir['Factureavoir']['typeclient_id'];

            if (floatval($exono) != 1) {

                @$name = $lignefactureavoir['Client']['name'];
                @$adresse = $lignefactureavoir['Client']['adresse'];
                @$mat = $lignefactureavoir['Client']['matriculefiscale'];
                $tablignefactures[$cp]['id_piece'] = $lignefactureavoir['Factureavoir']['id'];
                $tablignefactures[$cp]['client'] = $name;
                $tablignefactures[$cp]['num_exe'] = @$num_exono['Exonorationclient']['num_exe'];
                $tablignefactures[$cp]['matriculefiscal'] = $mat;
                $tablignefactures[$cp]['date'] = $lignefactureavoir['Factureavoir']['date'];
                $tablignefactures[$cp]['type'] = "Facture Avoir";
                $tablignefactures[$cp]['numero'] = $lignefactureavoir['Factureavoir']['numero'];
                $tablignefactures[$cp]['remise'] = $lignefactureavoir['Factureavoir']['remise'];
                $tablignefactures[$cp]['fodec'] = $lignefactureavoir['Factureavoir']['fodec'];
                $tablignefactures[$cp]['tva'] = $lignefactureavoir['Factureavoir']['tva'];
                $tablignefactures[$cp]['totalht'] = $lignefactureavoir['Factureavoir']['totalht'];
                $tablignefactures[$cp]['totalttc'] = $lignefactureavoir['Factureavoir']['totalttc'];
                $tablignefactures[$cp]['timbre'] = 0;


                $cp++;
            }
        }
//******************************************************************************************************************************


        $clients = $this->Client->find('list');
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $types = array();
        $types['Exonore'] = "Exonoré";
        $types['Avoir'] = "Avoir";
        $types['Tout'] = "Tout";
        //debug($tablignefactures);die;*
        //$tvas = $this->Tva->find('all', array('recursive' => -1));

        $this->set(compact('exercices', 'date1', 'date2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function exportlisteavoir() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Pointdevente');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Utilisateur');
        $this->loadModel('Factureavoir');
        $this->loadModel('Tva');

        $this->layout=NULL;

        //debug($this->request->query);die;

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $clientidfacture = CakeSession::read('clientidfacture');
        $anneefacture = CakeSession::read('anneefacture');
        $pvfacture = CakeSession::read('pvfacture');

        //debug($date1); debug($date2); debug($clientidfacture); debug($anneefacture); debug($pvfacture);die;

        /*         * ************************************************************* */
        $tablignefactures = array();



        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];

        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }

        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondf1 = ' and factureclients.date >= ' . "'" . $date1 . "'";

            $condf4 = "";
            $conda4 = "";

            $pcondf4 = "";
            $pconda4 = "";
        }
        $condf2 = "";
        $conda2 = "";

        if ($anneefacture != 0) {
            $exerciceid = $anneefacture;
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
            $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];

            $pcondf4 = ' and factureclients.exercice_id =' . $exercices[$exerciceid];
            $pconda4 = ' and factureavoirs.exercice_id =' . $exercices[$exerciceid];
        }

        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondf2 = ' and factureclients.date <= ' . "'" . $date2 . "'";
            $pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";

            $condf4 = "";
            $conda4 = "";

            $pcondf4 = "";
            $pconda4 = "";
        }

        if ($clientidfacture != 0) {
            $clientid = $clientidfacture;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id =' . $clientid;
            $conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf3 = ' and factureclients.client_id =' . $clientid;
            $pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }


        if ($pvfacture != 0) {
            $pointdeventeid = $pvfacture;
//            $condb5 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
            $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
            $pv = "";
            $pvf = "";
            $pva = "";

            $pcondf5 = ' and factureclients.pointdevente_id =' . $pointdeventeid;
            $pconda5 = ' and factureavoirs.pointdevente_id =' . $pointdeventeid;
        }
        $cp = 0;


        $tmps = $this->Factureclient->query(
                'SELECT tmp.tva
        FROM (
        (SELECT  lignefactureavoirs.tva
        FROM  lignefactureavoirs,factureavoirs
        where  factureavoirs.id=lignefactureavoirs.factureavoir_id and lignefactureavoirs.tva!=0
        ' . @$pconda1 . @$pconda2 . @$pconda3 . @$pconda4 . @$pconda5 . @$pconda6 . @$pconda7 . '
        group BY  lignefactureavoirs.tva
        )
        )tmp
        group BY tmp.tva desc');

        $tvas=array();
        foreach ($tmps as $i => $t) {
            $tvas[$i]['Tva']['name'] = $t['tmp']['tva'];
        }

        sort($tvas); //debug($tvas);die;
//**********************************************************************************************************
        $lignefactureavoirs = $this->Factureavoir->find('all', array(
            'conditions' => array(@$pva, @$conda1, @$conda2, @$conda3, @$conda4, @$conda5, @$conda6, @$conda7), 'order' => array('Factureavoir.numero' => 'ASC'), 'contain' => array('Client', 'Timbre'), 'recursive' => 1));

        foreach ($lignefactureavoirs as $lignefactureavoir) {
            @$name = $lignefactureavoir['Client']['name'];
            @$adresse = $lignefactureavoir['Client']['adresse'];
            @$mat = $lignefactureavoir['Client']['matriculefiscale'];
            @$code = $lignefactureavoir['Client']['code'];
            $tablignefactures[$cp]['id_piece'] = $lignefactureavoir['Factureavoir']['id'];
            $tablignefactures[$cp]['client'] = $name;
            $tablignefactures[$cp]['adresse'] = @$adresse;
            $tablignefactures[$cp]['matriculefiscal'] = $mat;
            $tablignefactures[$cp]['code'] = $code;
            $tablignefactures[$cp]['date'] = $lignefactureavoir['Factureavoir']['date'];
            $tablignefactures[$cp]['type'] = "Facture Avoir";
            $tablignefactures[$cp]['numero'] = $lignefactureavoir['Factureavoir']['numero'];
            $tablignefactures[$cp]['remise'] = $lignefactureavoir['Factureavoir']['remise'];
            $tablignefactures[$cp]['fodec'] = $lignefactureavoir['Factureavoir']['fodec'];
            $tablignefactures[$cp]['tva'] = $lignefactureavoir['Factureavoir']['tva'];
            $tablignefactures[$cp]['totalht'] = $lignefactureavoir['Factureavoir']['totalht'];
            $tablignefactures[$cp]['totalttc'] = $lignefactureavoir['Factureavoir']['totalttc'];
            $tablignefactures[$cp]['timbre'] = $lignefactureavoir['Timbre']['timbre'];


            $cp++;
        }
//******************************************************************************************************************************


        $clients = $this->Client->find('list');
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $types = array();
        $types['Exonore'] = "Exonoré";
        $types['Avoir'] = "Avoir";
        $types['Tout'] = "Tout";
        //debug($tablignefactures);die;*
        //$tvas = $this->Tva->find('all', array('recursive' => -1));

        $this->set(compact('exercices', 'date1', 'date2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function exportlistetout() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Pointdevente');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Utilisateur');
        $this->loadModel('Factureavoir');
        $this->loadModel('Tva');
        $this->loadModel('Exonorationclient');

        $this->layout=NULL;
        //debug($this->request->query);die;

//        $this->response->type('pdf');
//        $this->layout = 'pdf';

        $date1 = CakeSession::read('date1');
        $date2 = CakeSession::read('date2');
        $clientidfacture = CakeSession::read('clientidfacture');
        $anneefacture = CakeSession::read('anneefacture');
        $pvfacture = CakeSession::read('pvfacture');

        //debug($date1); debug($date2); debug($clientidfacture); debug($anneefacture); debug($pvfacture);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        $condexonore = 'Client.typeclient_id=2';

        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id =' . $exe;
        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }

        $condf1 = "";
        $conda1 = "";
        //debug($this->request->query);//die;
        if ($anneefacture != 0) {
            $exerciceid = $anneefacture;
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
            $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];

            $pcondf4 = ' and factureclients.exercice_id =' . $exercices[$exerciceid];
            $pconda4 = ' and factureavoirs.exercice_id =' . $exercices[$exerciceid];
        }
        if ($date1 != "__/__/____" && $date1 != "1970-01-01") {
            //$date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
//            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pconda1 = ' and factureavoirs.date >= ' . "'" . $date1 . "'";
            $pcondf1 = ' and factureclients.date >= ' . "'" . $date1 . "'";

            $condf4 = "";
            $conda4 = "";

            $pcondf4 = "";
            $pconda4 = "";
        }
        $condf2 = "";
        $conda2 = "";
        if ($date2 != "__/__/____" && $date2 != "1970-01-01") {
            //$date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
//            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
            $pcondf2 = ' and factureclients.date <= ' . "'" . $date2 . "'";
            $pconda2 = ' and factureavoirs.date <= ' . "'" . $date2 . "'";

            $condf4 = "";
            $conda4 = "";

            $pcondf4 = "";
            $pconda4 = "";
        }

        if ($clientidfacture != 0) {
            $clientid = $clientidfacture;
//            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id =' . $clientid;
            $conda3 = 'Factureavoir.client_id =' . $clientid;

            $pcondf3 = ' and factureclients.client_id =' . $clientid;
            $pconda3 = ' and factureavoirs.client_id =' . $clientid;
        }


        if ($pvfacture != 0) {
            $pointdeventeid = $pvfacture;
//            $condb5 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
            $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
            $pv = "";
            $pvf = "";
            $pva = "";

            $pcondf5 = ' and factureclients.pointdevente_id =' . $pointdeventeid;
            $pconda5 = ' and factureavoirs.pointdevente_id =' . $pointdeventeid;
        }
        $cp = 0;
        $tvas = array();
        $tmps = $this->Factureclient->query(
                'SELECT tmp.tva
        FROM (
        (SELECT  lignefactureclients.tva
        FROM  lignefactureclients ,factureclients
        where  factureclients.id=lignefactureclients.factureclient_id and lignefactureclients.tva!=0
        ' . @$pcondf1 . @$pcondf2 . @$pcondf3 . @$pcondf4 . @$pcondf5 . @$pcondf6 . @$pcondf7 . '
        group BY  lignefactureclients.tva
        )
        UNION ALL(
        SELECT  lignefactureavoirs.tva
        FROM  lignefactureavoirs,factureavoirs
        where  factureavoirs.id=lignefactureavoirs.factureavoir_id and lignefactureavoirs.tva!=0
        ' . @$pconda1 . @$pconda2 . @$pconda3 . @$pconda4 . @$pconda5 . @$pconda6 . @$pconda7 . '
        group BY  lignefactureavoirs.tva
        )
        )tmp
        group BY tmp.tva desc');

        $tvas=array();
        foreach ($tmps as $i => $t) {
            $tvas[$i]['Tva']['name'] = $t['tmp']['tva'];
        }

        sort($tvas);
        $listvaall=array();

        //debug($tvas);die;
//        $ftva = $this->Lignefactureclient->find('all', array(
//            'fields'=>  array('Lignefactureclient.tva'),
//            'conditions' => array('Lignefactureclient.tva !=0',@$pvf, @$condf1, @$condf2, @$condf3, @$condf4, @$condf5, @$condf6, @$condf7),
//            'group' => array('Lignefactureclient.tva'), 'recursive' => 0));
//        $atva = $this->Lignefactureavoir->find('all', array(
//            'fields'=>  array('Lignefactureavoir.tva'),
//            'conditions' => array('Lignefactureavoir.tva !=0',@$pva, @$conda1, @$conda2, @$conda3, @$conda4, @$conda5, @$conda6, @$conda7),
//            'group' => array('Lignefactureavoir.tva'), 'recursive' => 0));
//
//        debug($ftva);
//                debug($atva);die;
        $selecttvabase = '';
        $selecttva = '';
        $selecttvabaseavoir = '';
        $selecttvaavoir = '';
        foreach ($tvas as $k => $t) {
            $tv = intval(floatval($t['Tva']['name']));
            if ($selecttvabase != '') {
                $selecttvabase = $selecttvabase . ',' . 'sum(case when lignefactureclients.tva = ' . $tv . ' then lignefactureclients.totalht else 0 end) as base' . $tv;
                $selecttva = $selecttva . ',' . 'sum(case when lignefactureclients.tva = ' . $tv . ' then round((lignefactureclients.totalht * lignefactureclients.tva)/100,3) else 0 end) as tva' . $tv;
            } else {
                $selecttvabase = $selecttvabase . 'sum(case when lignefactureclients.tva = ' . $tv . ' then lignefactureclients.totalht else 0 end) as base' . $tv;
                $selecttva = $selecttva . 'sum(case when lignefactureclients.tva = ' . $tv . ' then round((lignefactureclients.totalht * lignefactureclients.tva)/100,3) else 0 end) as tva' . $tv;
            }

            if ($selecttvabaseavoir != '') {
                $selecttvabaseavoir = $selecttvabaseavoir . ',' . 'sum(case when lignefactureavoirs.tva = ' . $tv . ' then lignefactureavoirs.totalht else 0 end) as base' . $tv;
                $selecttvaavoir = $selecttvaavoir . ',' . 'sum(case when lignefactureavoirs.tva = ' . $tv . ' then round((lignefactureavoirs.totalht * lignefactureavoirs.tva)/100,3) else 0 end) as tva' . $tv;
            } else {
                $selecttvabaseavoir = $selecttvabaseavoir . 'sum(case when lignefactureavoirs.tva = ' . $tv . ' then lignefactureavoirs.totalht else 0 end) as base' . $tv;
                $selecttvaavoir = $selecttvaavoir . 'sum(case when lignefactureavoirs.tva = ' . $tv . ' then round((lignefactureavoirs.totalht * lignefactureavoirs.tva)/100,3) else 0 end) as tva' . $tv;
            }
        }
//        debug($selecttvabase);
//        debug($selecttva);
        //die;
        $condfacture='';
        if ($selecttvabase != '') {
            $condfacture = ','.$selecttvabase . ',' . $selecttva;
        }
//******************************************************************************************************************************
//        $lignefactures = $this->Factureclient->find('all', array(
//            'conditions' => array(@$pvf, @$condf1, @$condf2, @$condf3, @$condf4, @$condf5, @$condf6, @$condf7), 'order' => array('Factureclient.numero' => 'ASC'), 'contain' => array('Client'), 'recursive' => 0));
        $lignefactures = $this->Factureclient->query('select factureclients.id,factureclients.totalht,factureclients.numero,factureclients.date,factureclients.timbre_id,factureclients.totalttc,factureclients.typeclient_id,clients.code,clients.name,clients.id
        ' . $condfacture . '
         from lignefactureclients ,factureclients ,clients  where lignefactureclients.factureclient_id=factureclients.id and factureclients.client_id=clients.id ' . @$pcondf1 . @$pcondf2 . @$pcondf3 . @$pcondf4 . @$pcondf5 . @$pcondf6 . @$pcondf7 . ' group by factureclients.numero');
        //debug($lignefactures);die;
        $ccp = 0;
        foreach ($lignefactures as $lignefacture) {

            $venteexos = $this->Lignefactureclient->find('all', array('fields' => array('SUM(Lignefactureclient.totalht) as totalht')
            , 'conditions' => array('Lignefactureclient.factureclient_id' => $lignefacture['factureclients']['id'],'Lignefactureclient.tva'=>0),'recursive'=>-1));
            if((empty($venteexos[0][0]['totalht']))||($venteexos[0][0]['totalht']==0)){
                $venteexo="";
            }else{
               $venteexo= $venteexos[0][0]['totalht'];
            }

            //debug($lignefacture);die;
//            $exono = $this->Exonorationclient->find('count', array('conditions' => (array('Exonorationclient.client_id' => $lignefacture['clients']['id']
//            , 'Exonorationclient.datedu <= ' => $lignefacture['factureclients']['date'], 'Exonorationclient.dateau >= ' => $lignefacture['factureclients']['date'])), 'recursive' => -1));
            $exono = $lignefacture['factureclients']['typeclient_id'];
            if (floatval($exono) != 1) {
                $ventesup = $lignefacture['factureclients']['totalht'];
            } else {
                $ventesup = "";
            }

            foreach ($tvas as $t) {
                if (floatval($exono) == 1) {
                    $tv = intval(floatval($t['Tva']['name']));
                    $tablignefactures[$cp]['base' . $tv] = $lignefacture[0]['base' . $tv];
                    $tablignefactures[$cp]['tva' . $tv] = $lignefacture[0]['tva' . $tv];

                    $listvaall[$ccp]['nom'] = 'Base ' . $tv . '%';
                    $listvaall[$ccp]['mtva'] = sprintf("%.3f", $lignefacture[0]['tva' . $tv]);
                    $listvaall[$ccp]['base'] = sprintf("%.3f", $lignefacture[0]['base' . $tv]);
                    $listvaall[$ccp]['tva'] = intval(floatval($tv));
                    $ccp++;
                } else {
                    $tv = intval(floatval($t['Tva']['name']));
                    $tablignefactures[$cp]['base' . $tv] = 0;
                    $tablignefactures[$cp]['tva' . $tv] = 0;

                    $listvaall[$ccp]['nom'] = 'Base ' . $tv . '%';
                    $listvaall[$ccp]['mtva'] = 0;
                    $listvaall[$ccp]['base'] = 0;
                    $listvaall[$ccp]['tva'] = intval(floatval($tv));
                    $ccp++;
                }
            }

            $tablignefactures[$cp]['venteexo'] = $venteexo;
            $tablignefactures[$cp]['ventesup'] = $ventesup;
            $tablignefactures[$cp]['id_piece'] = $lignefacture['factureclients']['id'];
            $tablignefactures[$cp]['idclient'] = $lignefacture['clients']['id'];
            $tablignefactures[$cp]['client'] = $lignefacture['clients']['name'];
            $tablignefactures[$cp]['code'] = $lignefacture['clients']['code'];
            $tablignefactures[$cp]['date'] = $lignefacture['factureclients']['date'];
            $tablignefactures[$cp]['type'] = "Facture client";
            $tablignefactures[$cp]['numero'] = $lignefacture['factureclients']['numero'];
            $tablignefactures[$cp]['totalht'] = $lignefacture['factureclients']['totalht'];
            $tablignefactures[$cp]['totalttc'] = $lignefacture['factureclients']['totalttc'];
            $tablignefactures[$cp]['timbre'] = $lignefacture['factureclients']['timbre_id'];

            $cp++;
        }
//        debug($tablignefactures);
//        die;
//**********************************************************************************************************
//        $lignefactureavoirs = $this->Factureavoir->find('all', array(
//            'conditions' => array(@$pva, @$conda1, @$conda2, @$conda3, @$conda4, @$conda5, @$conda6, @$conda7), 'order' => array('Factureavoir.numero' => 'ASC'), 'contain' => array('Client', 'Timbre'), 'recursive' => 1));
        $condfactureavoir='';
        if ($selecttvabaseavoir != '') {
            $condfactureavoir = ','.$selecttvabaseavoir . ',' . $selecttvaavoir;
        }
        $lignefactureavoirs = $this->Factureavoir->query('select factureavoirs.id,factureavoirs.totalht,factureavoirs.numero,factureavoirs.date,factureavoirs.timbre_id,factureavoirs.totalttc,factureavoirs.typeclient_id,clients.code,clients.name,clients.id
        ' . $condfactureavoir . '
         from lignefactureavoirs ,factureavoirs ,clients  where lignefactureavoirs.factureavoir_id=factureavoirs.id and factureavoirs.client_id=clients.id ' . @$pconda1 . @$pconda2 . @$pconda3 . @$pconda4 . @$pconda5 . @$pconda6 . @$pconda7 . ' group by factureavoirs.numero');

//debug($lignefactureavoirs);die;
        foreach ($lignefactureavoirs as $lignefactureavoir) { //debug($lignefactureavoir);die;

//            $exono = $this->Exonorationclient->find('count', array('conditions' => (array('Exonorationclient.client_id' => $lignefactureavoir['clients']['id']
//            , 'Exonorationclient.datedu <= ' => $lignefactureavoir['factureavoirs']['date'], 'Exonorationclient.dateau >= ' => $lignefactureavoir['factureavoirs']['date'])), 'recursive' => -1));
            $exono = $lignefactureavoir['factureavoirs']['typeclient_id'];
            if (floatval($exono) != 1) {
                $ventesup = 0-$lignefactureavoir['factureavoirs']['totalht'];
            } else {
                $ventesup = "";
            }

            foreach ($tvas as $t) {
                if (floatval($exono) == 1) {
                    $tv = intval(floatval($t['Tva']['name']));
                    $tablignefactures[$cp]['base' . $tv] = 0-$lignefactureavoir[0]['base' . $tv];
                    $tablignefactures[$cp]['tva' . $tv] = 0-$lignefactureavoir[0]['tva' . $tv];

                    $listvaall[$ccp]['nom'] = 'Base ' . $tv . '%';
                    $listvaall[$ccp]['mtva'] = 0-sprintf("%.3f", $lignefactureavoir[0]['tva' . $tv]);
                    $listvaall[$ccp]['base'] = 0-sprintf("%.3f", $lignefactureavoir[0]['base' . $tv]);
                    $listvaall[$ccp]['tva'] = intval(floatval($tv));
                    $ccp++;
                } else {
                    $tv = intval(floatval($t['Tva']['name']));
                    $tablignefactures[$cp]['base' . $tv] = 0;
                    $tablignefactures[$cp]['tva' . $tv] = 0;

                    $listvaall[$ccp]['nom'] = 'Base ' . $tv . '%';
                    $listvaall[$ccp]['mtva'] = 0;
                    $listvaall[$ccp]['base'] = 0;
                    $listvaall[$ccp]['tva'] = intval(floatval($tv));
                    $ccp++;
                }
            }

            $tablignefactures[$cp]['venteexo'] = "";
            $tablignefactures[$cp]['ventesup'] = $ventesup;
            $tablignefactures[$cp]['id_piece'] = $lignefactureavoir['factureavoirs']['id'];
            $tablignefactures[$cp]['client'] = @$lignefactureavoir['clients']['name'];
            $tablignefactures[$cp]['idclient'] = @$lignefactureavoir['factureavoirs']['client_id'];
            $tablignefactures[$cp]['code'] = @$lignefactureavoir['clients']['code'];
            $tablignefactures[$cp]['date'] = $lignefactureavoir['factureavoirs']['date'];
            $tablignefactures[$cp]['type'] = "Facture Avoir";
            $tablignefactures[$cp]['numero'] = $lignefactureavoir['factureavoirs']['numero'];
            $tablignefactures[$cp]['totalht'] = 0-$lignefactureavoir['factureavoirs']['totalht'];
            $tablignefactures[$cp]['totalttc'] = 0-$lignefactureavoir['factureavoirs']['totalttc'];
            $tablignefactures[$cp]['timbre'] = 0;


            $cp++;
        }
//******************************************************************************************************************************


        $clients = $this->Client->find('list');
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $types = array();
        $types['Exonore'] = "Exonoré";
        $types['Avoir'] = "Avoir";
        $types['Tout'] = "Tout";
        //debug($tablignefactures);
//        die;
        //$tvas = $this->Tva->find('all', array('recursive' => -1));

        $this->set(compact('exercices', 'listvaall', 'lignefacturessomme', 'date1', 'date2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function listefactureclients() {
        $this->layout = null;
        $data = $this->request->data;
        $val = $data['val'];
        $pv = $data['pv'];
        $factureclients = $this->Factureclient->find('all', array(
            'conditions' => array("Factureclient.numero LIKE '%".addslashes($val)."%'",'Factureclient.pointdevente_id'=>$pv),
            'recursive' => -1,
            'group' => array('Factureclient.id'),
            'limit'=>70,
            'order'=>  array('Factureclient.id'=>'desc')
        ));
        echo json_encode(array('Factureclients' => $factureclients));
        die();

    }

    public function testdu3mois() {
        $this->layout = null;
        $data = $this->request->data;
        $client_id = $data['client_id'];

        $debut= date('Y-m-d');
        $time = strtotime($debut);
        $dateparmois=date('Y-m-d',strtotime('-3 month', $time));
        $first_day=date_create($dateparmois)->modify('first day of this month')->format('Y-m-d');
        $this->loadModel('Client');
        $clts = $this->Client->find('first', array(
            'conditions' => array(
            'Client.id'=>$client_id,
            ),
            'recursive' => -1,
        ));
        $factureclients = $this->Factureclient->find('count', array(
            'conditions' => array(
            'Factureclient.client_id'=>$client_id,
            'Factureclient.date < ' . "'" . $first_day . "'" ,
            'Factureclient.totalttc>Factureclient.Montant_Regler'
            ),
            'recursive' => -1,
        ));
        $this->loadModel('Piecereglementclient');
        $piecereglements = $this->Piecereglementclient->find('count', array(
            'conditions' => array(
            'Piecereglementclient.paiement_id in (2,3)',
            'Piecereglementclient.situation="Impayé"',
            'Piecereglementclient.montant>Piecereglementclient.mantantregler',
            'Reglementclient.client_id'=>$client_id
            )
            ,'contain'=>array('Reglementclient')
            ,'recursive'=>0
            ));

        echo json_encode(array('piecereglements'=>$piecereglements,'modeclient'=>$clts['Client']['modeclient_id'],'Factureclients' => $factureclients,'date_first_day'=>date("d/m/Y", strtotime(str_replace('/', '-',$first_day))),'client_id'=>$client_id));
        die();

    }






     public function gettimbre() {
        $this->layout = null;
        $data = $this->request->data;
        $client_id = $data['client_id'];
        $this->loadModel('Client');
        $this->loadModel('Timbre');
         $timbres = $this->Timbre->find('first', array('recursive' => -1));
                $timbre = $timbres['Timbre']['timbre'];
                if(!empty($client_id)){
                $clt = $this->Client->find('first', array('conditions' => array('Client.id' =>$client_id), 'recursive' => -1));
                if ($clt['Client']['avectimbre_id'] == 'Non') {
                    $timbre = 0;
                }
                }

        echo json_encode(array('timbre'=>$timbre));
        die();

    }

    public function numerofac_autocomplete() {
        $this->layout = null;
        $val = $this->request->data['val'];
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Factureclient.pointdevente_id = '.$p;
        }
        $tab = explode('%', $val);
        $val_composer="";
        foreach ($tab as $tabb) {if($tabb !=""){$val_composer .= "%".addslashes($tabb);}}
        $factureclients = $this->Factureclient->find('all', array(
        'conditions' => array("Factureclient.numero LIKE  '" . $val_composer . "%'",@$cond_liste_pv),
        'recursive' => -1,
        'limit'=>100,
        'order'=>'cast((Factureclient.numero) as signed) Asc'
        ));
        echo json_encode(array('factureclients' => $factureclients));
        die();
    }
//    public function suplesfacs(){
//        $factureclients = $this->Factureclient->find('all', array(
//        'conditions' => array("Factureclient.pointdevente_id"=>2,"Factureclient.exercice_id"=>2019 ,"Factureclient.numeroconca >=002362","Factureclient.numeroconca <=002463"),
//        'recursive' => -1,
//        ));        debug($factureclients);die;
////                foreach ($factureclients as $factureclient) {
////                $tttt="FactureclientsController";
////                $tt = new $tttt;
////                $tt->delete($factureclient['Factureclient']['id'],1);
////                }
//    }


}
