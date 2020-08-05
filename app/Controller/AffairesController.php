<?php
App::uses('AppController', 'Controller');
/**
 * Affaires Controller
 *
 * @property Affaire $Affaire
 */
class AffairesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {

        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'devis') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Region');
        $this->loadModel('Exercice');
        $this->loadModel('Devi');
        $this->loadModel('Personnel');
        $this->loadModel('Typesuivitdevi');
        $affaires =array();
        $critere_recherche=0;
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $cond4 = 'Affaire.exercice_id =' . $exe;
        $cond33='';
        //debug(CakeSession::read('C'));
       // debug(CakeSession::read('C'));
        //debug($this->params);
       // debug(" Cont :".CakeSession::read('Controller'));
        //debug(" VIEW :".CakeSession::read('view'));
        //debug(" reche :".CakeSession::read('recherche'));
        if ((isset($this->request->data) && !empty($this->request->data))||(( in_array(CakeSession::read('view'),Array("edit","view","delete")))&&(CakeSession::read('Controller') =="Affaires"))) {
            if ((isset($this->request->data) && !empty($this->request->data))||((! in_array(CakeSession::read('view'),Array("edit","view","delete"))))) {
            CakeSession::write('recherche',$this->request->data['Affaire']);
            
           // debug("1");
            }else{
            $this->request->data['Affaire']=CakeSession::read('recherche');   
            //debug("2");
            }
            //debug($this->request->data);
            if (($this->request->data['Affaire']['date1'] != "__/__/____") && isset($this->request->data['Affaire']['date1'])) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Affaire']['date1'])));
                $cond1 = 'Affaire.date >= ' . "'" . $date1 . "'";
                $cond4 = "";
            }

            if (($this->request->data['Affaire']['date2'] != "__/__/____") && isset($this->request->data['Affaire']['date2'])) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Affaire']['date2'])));
                $cond2 = 'Affaire.date <= ' . "'" . $date2 . "'";
                $cond4 = "";
            }

            if ($this->request->data['Affaire']['client']) {
            $client = $this->request->data['Affaire']['client'];
            $devis=$this->Devi->find('all',array('recursive'=>-1,'conditions'=>array('Devi.name'=>$client)));
            $t='(0';
            foreach ($devis as $ad){
                if(!empty($ad['Devi']['affaire_id'])){
                $t=$t.','.$ad['Devi']['affaire_id'];
                }
            }
            $t=$t.')';
            $cond3 = 'Affaire.id  in'.$t;
                //$cond3 = 'Affaire.client_id =' . $clientid;
            }


            if ($this->request->data['Affaire']['typesuivitdevi_id']) {
                $typesuivitdevi_id = $this->request->data['Affaire']['typesuivitdevi_id'];
                $devis=$this->Devi->find('all',array('recursive'=>-1,'conditions'=>array('Devi.typesuivitdevi_id'=>$typesuivitdevi_id)));
                $t='(0';
                foreach ($devis as $ad){
                    if(!empty($ad['Devi']['affaire_id'])){
                        $t=$t.','.$ad['Devi']['affaire_id'];
                    }
                }
                $t=$t.')';
                $cond33 = 'Affaire.id  in'.$t;
                //$cond3 = 'Affaire.client_id =' . $clientid;
            }

            
            if ($this->request->data['Affaire']['responsable']) {
            $responsable = $this->request->data['Affaire']['responsable'];
            $t_aff='(0';
            foreach ($responsable as $res){
            if(!empty($res)){
            $like_affaire=$this->Affaire->find('all',array('recursive'=>-1,'conditions'=>array('Affaire.responsable  LIKE "%,'.$res.',%"')));
            //debug($like_affaire);
            if(!empty($like_affaire)){
            foreach ($like_affaire as $like_aff){
            $t_aff=$t_aff.','.$like_aff['Affaire']['id'];
            }}
            }
            }
            $t_aff=$t_aff.',0)';
            //debug($t_aff);
            $cond15 = 'Affaire.id  in'.$t_aff;
            }
            
            
            
            
            if ($this->request->data['Affaire']['exercice_id']) {
                $exercices = $this->Exercice->find('list');
                $exerciceid = $this->request->data['Affaire']['exercice_id'];
                $t_ex='(0';
                foreach ($exerciceid as $exe){
                $t_ex=$t_ex.','.$exercices[$exe];
                }
                $t_ex=$t_ex.',0)';
                $cond4 = 'Affaire.exercice_id in '.$t_ex;
            }
            
            
            if ($this->request->data['Affaire']['promoteur']) {
                $promoteur = $this->request->data['Affaire']['promoteur'];
                $cond5 = 'Affaire.promoteur ='. "'" . $promoteur. "'";
            }
            if ($this->request->data['Affaire']['bureaudetude']) {
                $bureaudetude = $this->request->data['Affaire']['bureaudetude'];
                $cond6 = 'Affaire.bureaudetude ='. "'" . $bureaudetude. "'";
            }
            if ($this->request->data['Affaire']['entreprisedefluide']) {
                $entreprisedefluide = $this->request->data['Affaire']['entreprisedefluide'];
                $cond7 = 'Affaire.entreprisedefluide =' . "'". $entreprisedefluide. "'";
            }
            if ($this->request->data['Affaire']['entreprisedebatiment']) {
                $entreprisedebatiment = $this->request->data['Affaire']['entreprisedebatiment'];
                $cond8 = 'Affaire.entreprisedebatiment =' . "'". $entreprisedebatiment. "'";
            }
            if ($this->request->data['Affaire']['architecte']) {
                $architecte = $this->request->data['Affaire']['architecte'];
                $cond9 = 'Affaire.architecte =' . "'". $architecte. "'";
            }
            if ($this->request->data['Affaire']['affaire']) {
                $name = $this->request->data['Affaire']['affaire'];
                $cond10 = 'Affaire.id ='.$name;
            }
            if ($this->request->data['Affaire']['region_id']) {
                $region_id = $this->request->data['Affaire']['region_id'];
                $cond11 = 'Affaire.region_id =' .  $region_id;
            }
            
            if ($this->request->data['Affaire']['situation_id']) {
               $situation_id = $this->request->data['Affaire']['situation_id'];
               $cond12 = 'Affaire.situation_id =' .  $situation_id;
            }
            if ($this->request->data['Affaire']['raisondeperde_id']) {
               $raisondeperde_id = $this->request->data['Affaire']['raisondeperde_id'];
               $cond13 = 'Affaire.raisondeperde_id =' .  $raisondeperde_id;
            }
            if ($this->request->data['Affaire']['revendeur']) {
                $revendeur = $this->request->data['Affaire']['revendeur'];
                $cond14 = 'Affaire.revendeur =' . "'". $revendeur. "'";
            }
            $critere_recherche=1;
            }
            //debug($this->request->data);
        $lisaffaires = $this->Affaire->find('all', array(
        'conditions' => array('Affaire.valide'=>1,@$cond1, @$cond2, @$cond3 , @$cond4, @$cond5, @$cond6, @$cond7, @$cond8, @$cond9,@$cond10,@$cond11,@$cond12,@$cond13,@$cond14,@$cond15,@$cond33
        ),'recursive'=>0));
        
        //debug($lisaffaires);die;
//        $lelisaffaires = $this->Affaire->find('all', array(
//        'conditions' => array('Affaire.exercice_id' =>2017)
//        ,'order'=>array('Affaire.id'=>'asc')    
//        ,'recursive'=>0));
//        //debug($lelisaffaires);die;
//        foreach ($lelisaffaires as $affairee){
//        $numero = $this->Affaire->find('all', array('fields' => array('MAX(Affaire.numero) as num'),
//        'conditions' => array('Affaire.exercice_id' =>2017))
//        );
//            foreach ($numero as $num) {
//                $n = $num[0]['num'];
//            }
//            if (!empty($n)) {
//                $lastnum = $n;
//                $nume = intval($lastnum) + 1;
//                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            } else {
//                $mm = "000001";
//            }
//        //$this->Affaire->updateAll(array('Affaire.numero' =>"'".$mm."'"), array('Affaire.id' => $affairee['Affaire']['id']));
//        }
        $exercices = $this->Exercice->find('list');
        $promoteurs = $this->Affaire->find('list', array('fields' => array('Affaire.promoteur','Affaire.promoteur'),'group'=>array('Affaire.promoteur')));
        $bureaudetudes = $this->Affaire->find('list', array('fields' => array('Affaire.bureaudetude','Affaire.bureaudetude'),'group'=>array('Affaire.bureaudetude')));
        $architectes = $this->Affaire->find('list', array('fields' => array('Affaire.architecte','Affaire.architecte'),'group'=>array('Affaire.architecte')));
        $entreprisedebatiments = $this->Affaire->find('list', array('fields' => array('Affaire.entreprisedebatiment','Affaire.entreprisedebatiment'),'group'=>array('Affaire.entreprisedebatiment')));
        $entreprisedefluides = $this->Affaire->find('list', array('fields' => array('Affaire.entreprisedefluide','Affaire.entreprisedefluide'),'group'=>array('Affaire.entreprisedefluide')));
        $clients = $this->Devi->find('list', array('fields' => array('Devi.name','Devi.name'),'group'=>array('Devi.name')));
        $revendeurs = $this->Affaire->find('list', array('fields' => array('Affaire.revendeur','Affaire.revendeur'),'group'=>array('Affaire.revendeur')));
        $affaires = $this->Affaire->find('list');
        $regions = $this->Region->find('list');
        $typesuivitdevis = $this->Typesuivitdevi->find('list');

        $situations[1]="En cours";
        $situations[2]="Perdu";
        $situations[3]="Gagner";
        $raisondeperdes[1]="PRIX ELEVEE"; 
        $raisondeperdes[2]="MANQUE RELATION";
        $raisondeperdes[3]="DISPONIBILITE";
        $raisondeperdes[4]="PAS INTERSSE";
        $raisondeperdes[5]="MANQUE DE SUIVE"; 
        $raisondeperdes[6]="PRODUIT NON CONFORME";
        $responsables = $this->Personnel->find('list');
        $this->set(compact('responsables','revendeurs','raisondeperdes','typesuivitdevis','situations','regions','lisaffaires','clients','entreprisedefluides','entreprisedebatiments','architectes','bureaudetudes','promoteurs','affaires','exercices', $this->paginate()));
    }
    
    
        public function exp_etatexcel() { 
        $this->layout=null;
         
        $this->loadModel('Region');
        $this->loadModel('Exercice');
        $this->loadModel('Devi');
        $this->loadModel('Personnel');
        $affaires =array();
        $critere_recherche=0;
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $cond4 = 'Affaire.exercice_id =' . $exe;
        //debug(CakeSession::read('C'));
       // debug(CakeSession::read('C'));
        //debug($this->params);
       // debug(" Cont :".CakeSession::read('Controller'));
        //debug(" VIEW :".CakeSession::read('view'));
        //debug(" reche :".CakeSession::read('recherche'));
       
            $this->request->data['Affaire']=CakeSession::read('recherche');   
            //debug("2");
            
            //debug($this->request->data);
            if (($this->request->data['Affaire']['date1'] != "__/__/____") && isset($this->request->data['Affaire']['date1'])) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Affaire']['date1'])));
                $cond1 = 'Affaire.date >= ' . "'" . $date1 . "'";
                $cond4 = "";
            }

            if (($this->request->data['Affaire']['date2'] != "__/__/____") && isset($this->request->data['Affaire']['date2'])) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Affaire']['date2'])));
                $cond2 = 'Affaire.date <= ' . "'" . $date2 . "'";
                $cond4 = "";
            }

            if ($this->request->data['Affaire']['client']) {
            $client = $this->request->data['Affaire']['client'];
            $devis=$this->Devi->find('all',array('recursive'=>-1,'conditions'=>array('Devi.name'=>$client)));
            $t='(0';
            foreach ($devis as $ad){
                if(!empty($ad['Devi']['affaire_id'])){
                $t=$t.','.$ad['Devi']['affaire_id'];
                }
            }
            $t=$t.')';
            $cond3 = 'Affaire.id  in'.$t;
                //$cond3 = 'Affaire.client_id =' . $clientid;
            }
            
            if ($this->request->data['Affaire']['responsable']) {
            $responsable = $this->request->data['Affaire']['responsable'];
            $t_aff='(0';
            foreach ($responsable as $res){
            if(!empty($res)){
            $like_affaire=$this->Affaire->find('all',array('recursive'=>-1,'conditions'=>array('Affaire.responsable  LIKE "%,'.$res.',%"')));
            //debug($like_affaire);
            if(!empty($like_affaire)){
            foreach ($like_affaire as $like_aff){
            $t_aff=$t_aff.','.$like_aff['Affaire']['id'];
            }}
            }
            }
            $t_aff=$t_aff.',0)';
            //debug($t_aff);
            $cond15 = 'Affaire.id  in'.$t_aff;
            }


            if ($this->request->data['Affaire']['typesuivitdevi_id']) {
                $typesuivitdevi_id = $this->request->data['Affaire']['typesuivitdevi_id'];
                $devis=$this->Devi->find('all',array('recursive'=>-1,'conditions'=>array('Devi.typesuivitdevi_id'=>$typesuivitdevi_id)));
                $t='(0';
                foreach ($devis as $ad){
                    if(!empty($ad['Devi']['affaire_id'])){
                        $t=$t.','.$ad['Devi']['affaire_id'];
                    }
                }
                $t=$t.')';
                $cond33 = 'Affaire.id  in'.$t;
                //$cond3 = 'Affaire.client_id =' . $clientid;
            }
            
            if ($this->request->data['Affaire']['exercice_id']) {
                $exercices = $this->Exercice->find('list');
                $exerciceid = $this->request->data['Affaire']['exercice_id'];
                $t_ex='(0';
                foreach ($exerciceid as $exe){
                $t_ex=$t_ex.','.$exercices[$exe];
                }
                $t_ex=$t_ex.',0)';
                $cond4 = 'Affaire.exercice_id in '.$t_ex;
            }
            if ($this->request->data['Affaire']['promoteur']) {
                $promoteur = $this->request->data['Affaire']['promoteur'];
                $cond5 = 'Affaire.promoteur ='. "'" . $promoteur. "'";
            }
            if ($this->request->data['Affaire']['bureaudetude']) {
                $bureaudetude = $this->request->data['Affaire']['bureaudetude'];
                $cond6 = 'Affaire.bureaudetude ='. "'" . $bureaudetude. "'";
            }
            if ($this->request->data['Affaire']['entreprisedefluide']) {
                $entreprisedefluide = $this->request->data['Affaire']['entreprisedefluide'];
                $cond7 = 'Affaire.entreprisedefluide =' . "'". $entreprisedefluide. "'";
            }
            if ($this->request->data['Affaire']['entreprisedebatiment']) {
                $entreprisedebatiment = $this->request->data['Affaire']['entreprisedebatiment'];
                $cond8 = 'Affaire.entreprisedebatiment =' . "'". $entreprisedebatiment. "'";
            }
            if ($this->request->data['Affaire']['architecte']) {
                $architecte = $this->request->data['Affaire']['architecte'];
                $cond9 = 'Affaire.architecte =' . "'". $architecte. "'";
            }
            if ($this->request->data['Affaire']['affaire']) {
                $name = $this->request->data['Affaire']['affaire'];
                $cond10 = 'Affaire.id ='.$name;
            }
            if ($this->request->data['Affaire']['region_id']) {
                $region_id = $this->request->data['Affaire']['region_id'];
                $cond11 = 'Affaire.region_id =' .  $region_id;
            }
            
            if ($this->request->data['Affaire']['situation_id']) {
               $situation_id = $this->request->data['Affaire']['situation_id'];
               $cond12 = 'Affaire.situation_id =' .  $situation_id;
            }
            if ($this->request->data['Affaire']['raisondeperde_id']) {
               $raisondeperde_id = $this->request->data['Affaire']['raisondeperde_id'];
               $cond13 = 'Affaire.raisondeperde_id =' .  $raisondeperde_id;
            }
            if ($this->request->data['Affaire']['revendeur']) {
                $revendeur = $this->request->data['Affaire']['revendeur'];
                $cond14 = 'Affaire.revendeur =' . "'". $revendeur. "'";
            }
            $critere_recherche=1;
            
            //debug($this->request->data);
        $lisaffaires = $this->Affaire->find('all', array(
        'conditions' => array('Affaire.valide'=>1,@$cond1, @$cond2, @$cond3 , @$cond4, @$cond5, @$cond6, @$cond7, @$cond8, @$cond9,@$cond10,@$cond11,@$cond12,@$cond13,@$cond14,@$cond15,@$cond33
        ),'recursive'=>0));
        
        //debug($lisaffaires);die;
        
//        foreach ($affaires as $affaire){
//        $numero = $this->Affaire->find('all', array('fields' => array('MAX(Affaire.numero) as num'),
//            'conditions' => array('Affaire.exercice_id' => date("Y")))
//            );
//            foreach ($numero as $num) {
//                $n = $num[0]['num'];
//            }
//            if (!empty($n)) {
//                $lastnum = $n;
//                $nume = intval($lastnum) + 1;
//                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            } else {
//                $mm = "000001";
//            }
//        $this->Affaire->updateAll(array('Affaire.numero' =>"'".$mm."'"), array('Affaire.id' => $affaire['Affaire']['id']));
       // }
        $exercices = $this->Exercice->find('list');
        $promoteurs = $this->Affaire->find('list', array('fields' => array('Affaire.promoteur','Affaire.promoteur'),'group'=>array('Affaire.promoteur')));
        $bureaudetudes = $this->Affaire->find('list', array('fields' => array('Affaire.bureaudetude','Affaire.bureaudetude'),'group'=>array('Affaire.bureaudetude')));
        $architectes = $this->Affaire->find('list', array('fields' => array('Affaire.architecte','Affaire.architecte'),'group'=>array('Affaire.architecte')));
        $entreprisedebatiments = $this->Affaire->find('list', array('fields' => array('Affaire.entreprisedebatiment','Affaire.entreprisedebatiment'),'group'=>array('Affaire.entreprisedebatiment')));
        $entreprisedefluides = $this->Affaire->find('list', array('fields' => array('Affaire.entreprisedefluide','Affaire.entreprisedefluide'),'group'=>array('Affaire.entreprisedefluide')));
        $clients = $this->Devi->find('list', array('fields' => array('Devi.name','Devi.name'),'group'=>array('Devi.name')));
        $revendeurs = $this->Affaire->find('list', array('fields' => array('Affaire.revendeur','Affaire.revendeur'),'group'=>array('Affaire.revendeur')));
        $affaires = $this->Affaire->find('list');
        $regions = $this->Region->find('list');
        $situations[1]="En cours";
        $situations[2]="Perdu";
        $situations[3]="Gagner";
        $raisondeperdes[1]="PRIX ELEVEE"; 
        $raisondeperdes[2]="MANQUE RELATION";
        $raisondeperdes[3]="DISPONIBILITE";
        $raisondeperdes[4]="PAS INTERSSE";
        $raisondeperdes[5]="MANQUE DE SUIVE"; 
        $raisondeperdes[6]="PRODUIT NON CONFORME";
        $responsables = $this->Personnel->find('list');
        $this->set(compact('responsables','revendeurs','raisondeperdes','situations','regions','lisaffaires','clients','entreprisedefluides','entreprisedebatiments','architectes','bureaudetudes','promoteurs','affaires','exercices', $this->paginate()));
    }
    
    
    
    
        public function etataffaire() {
            $lien = CakeSession::read('lien_vente');
            $x = "";
            //debug($lien);die;
            if (!empty($lien)) {
                foreach ($lien as $k => $liens) {
                    if (@$liens['lien'] == 'devis') {
                        $x = 1;
                    }
                }
            }
            if (( $x <> 1) || (empty($lien))) {
                $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
            }

        $this->loadModel('Region');
        $this->loadModel('Exercice');
        $this->loadModel('Devi');
        $affaires =array();
        $critere_recherche=0;
        //debug(CakeSession::read('C'));
       // debug(CakeSession::read('C'));
        //debug($this->params);
       // debug(" Cont :".CakeSession::read('Controller'));
        //debug(" VIEW :".CakeSession::read('view'));
        //debug(" reche :".CakeSession::read('recherche'));
        if ((isset($this->request->data) && !empty($this->request->data))||(( in_array(CakeSession::read('view'),Array("edit","view","delete")))&&(CakeSession::read('Controller') =="Affaires"))) {
            if ((isset($this->request->data) && !empty($this->request->data))||((! in_array(CakeSession::read('view'),Array("edit","view","delete"))))) {
            CakeSession::write('recherche',$this->request->data['Affaire']);
            
           // debug("1");
            }else{
            $this->request->data['Affaire']=CakeSession::read('recherche');   
            //debug("2");
            }
            //debug($this->request->data);
            if (($this->request->data['Affaire']['date1'] != "__/__/____") && isset($this->request->data['Affaire']['date1'])) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Affaire']['date1'])));
                $cond1 = 'Affaire.date >= ' . "'" . $date1 . "'";
                $cond4 = "";
            }

            if (($this->request->data['Affaire']['date2'] != "__/__/____") && isset($this->request->data['Affaire']['date2'])) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Affaire']['date2'])));
                $cond2 = 'Affaire.date <= ' . "'" . $date2 . "'";
                $cond4 = "";
            }

            if ($this->request->data['Affaire']['client']) {
            $client = $this->request->data['Affaire']['client'];
            $devis=$this->Devi->find('all',array('recursive'=>-1,'conditions'=>array('Devi.name'=>$client)));
            $t='(0';
            foreach ($devis as $ad){
                if(!empty($ad['Devi']['affaire_id'])){
                $t=$t.','.$ad['Devi']['affaire_id'];
                }
            }
            $t=$t.')';
            $cond3 = 'Affaire.id  in'.$t;
                //$cond3 = 'Affaire.client_id =' . $clientid;
            }
            if ($this->request->data['Affaire']['exercice_id']) {
                $exercices = $this->Exercice->find('list');
                $exerciceid = $this->request->data['Affaire']['exercice_id'];
                $cond4 = 'Affaire.exercice_id =' . $exercices[$exerciceid];
            }
            if ($this->request->data['Affaire']['promoteur']) {
                $promoteur = $this->request->data['Affaire']['promoteur'];
                $cond5 = 'Affaire.promoteur ='. "'" . $promoteur. "'";
            }
            if ($this->request->data['Affaire']['bureaudetude']) {
                $bureaudetude = $this->request->data['Affaire']['bureaudetude'];
                $cond6 = 'Affaire.bureaudetude ='. "'" . $bureaudetude. "'";
            }
            if ($this->request->data['Affaire']['entreprisedefluide']) {
                $entreprisedefluide = $this->request->data['Affaire']['entreprisedefluide'];
                $cond7 = 'Affaire.entreprisedefluide =' . "'". $entreprisedefluide. "'";
            }
            if ($this->request->data['Affaire']['entreprisedebatiment']) {
                $entreprisedebatiment = $this->request->data['Affaire']['entreprisedebatiment'];
                $cond8 = 'Affaire.entreprisedebatiment =' . "'". $entreprisedebatiment. "'";
            }
            if ($this->request->data['Affaire']['architecte']) {
                $architecte = $this->request->data['Affaire']['architecte'];
                $cond9 = 'Affaire.architecte =' . "'". $architecte. "'";
            }
            if ($this->request->data['Affaire']['affaire']) {
                $name = $this->request->data['Affaire']['affaire'];
                $cond10 = 'Affaire.id ='.$name;
            }
            if ($this->request->data['Affaire']['region_id']) {
                $region_id = $this->request->data['Affaire']['region_id'];
                $cond11 = 'Affaire.region_id =' .  $region_id;
            }
            
//            if ($this->request->data['Affaire']['situation_id']) {
//               $situation_id = $this->request->data['Affaire']['situation_id'];
//               $cond12 = 'Affaire.situation_id =' .  $situation_id;
//            }
//            if ($this->request->data['Affaire']['raisondeperde_id']) {
//               $raisondeperde_id = $this->request->data['Affaire']['raisondeperde_id'];
//               $cond13 = 'Affaire.raisondeperde_id =' .  $raisondeperde_id;
//            }
            if ($this->request->data['Affaire']['revendeur']) {
                $revendeur = $this->request->data['Affaire']['revendeur'];
                $cond14 = 'Affaire.revendeur =' . "'". $revendeur. "'";
            }
            $critere_recherche=1;
            }
            //debug($this->request->data);
        $lisaffaireencours = $this->Affaire->find('count', array(
        'conditions' => array('Affaire.situation_id'=>1,@$cond1, @$cond2, @$cond3 , @$cond4, @$cond5, @$cond6, @$cond7, @$cond8, @$cond9,@$cond10,@$cond11,@$cond12,@$cond13,@$cond14
        ),'recursive'=>0
        ));
        $lisaffaireperdus = $this->Affaire->find('count', array(
        'conditions' => array('Affaire.situation_id'=>2,@$cond1, @$cond2, @$cond3 , @$cond4, @$cond5, @$cond6, @$cond7, @$cond8, @$cond9,@$cond10,@$cond11,@$cond12,@$cond13,@$cond14
        ),'recursive'=>0
        ));
        $lisaffairegagners = $this->Affaire->find('count', array(
        'conditions' => array('Affaire.situation_id'=>3,@$cond1, @$cond2, @$cond3 , @$cond4, @$cond5, @$cond6, @$cond7, @$cond8, @$cond9,@$cond10,@$cond11,@$cond12,@$cond13,@$cond14
        ),'recursive'=>0
        ));
        $exercices = $this->Exercice->find('list');
        $promoteurs = $this->Affaire->find('list', array('fields' => array('Affaire.promoteur','Affaire.promoteur'),'group'=>array('Affaire.promoteur')));
        $bureaudetudes = $this->Affaire->find('list', array('fields' => array('Affaire.bureaudetude','Affaire.bureaudetude'),'group'=>array('Affaire.bureaudetude')));
        $architectes = $this->Affaire->find('list', array('fields' => array('Affaire.architecte','Affaire.architecte'),'group'=>array('Affaire.architecte')));
        $entreprisedebatiments = $this->Affaire->find('list', array('fields' => array('Affaire.entreprisedebatiment','Affaire.entreprisedebatiment'),'group'=>array('Affaire.entreprisedebatiment')));
        $entreprisedefluides = $this->Affaire->find('list', array('fields' => array('Affaire.entreprisedefluide','Affaire.entreprisedefluide'),'group'=>array('Affaire.entreprisedefluide')));
        $clients = $this->Devi->find('list', array('fields' => array('Devi.name','Devi.name'),'group'=>array('Devi.name')));
        $revendeurs = $this->Affaire->find('list', array('fields' => array('Affaire.revendeur','Affaire.revendeur'),'group'=>array('Affaire.revendeur')));
        $affaires = $this->Affaire->find('list');
        $regions = $this->Region->find('list');
        $situations[1]="En cours";
        $situations[2]="Perdu";
        $situations[3]="Gagner";
        $raisondeperdes[1]="PRIX ELEVEE"; 
        $raisondeperdes[2]="MANQUE RELATION";
        $raisondeperdes[3]="DISPONIBILITE";
        $raisondeperdes[4]="PAS INTERSSE";
        $raisondeperdes[5]="MANQUE DE SUIVE"; 
        $raisondeperdes[6]="PRODUIT NON CONFORME";
        $this->set(compact('lisaffairegagners','lisaffaireperdus','lisaffaireencours','revendeurs','raisondeperdes','situations','regions','lisaffaires','clients','entreprisedefluides','entreprisedebatiments','architectes','bureaudetudes','promoteurs','affaires','exercices', $this->paginate()));
    }
    
        public function indexvisite() {
            $lien = CakeSession::read('lien_vente');
            $x = "";
            //debug($lien);die;
            if (!empty($lien)) {
                foreach ($lien as $k => $liens) {
                    if (@$liens['lien'] == 'devis') {
                        $x = 1;
                    }
                }
            }
            if (( $x <> 1) || (empty($lien))) {
                $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
            }

        $this->loadModel('Personnel');
        $this->loadModel('Visite');
        $this->loadModel('Devi');
        $affaires =array();
        //debug(CakeSession::read('Controller'));
        $datelyoum=date("d/m/Y");
        $conddatelyoum = 'Visite.date >= ' . "'" . date("Y-m-d", strtotime(str_replace('/', '-', $datelyoum))) . "'";
        
         if ($this->request->is('post')) { 
             //debug($this->request->data);
            if (($this->request->data['Visite']['date1'] != "__/__/____")) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Visite']['date1'])));
                $cond1 = 'Visite.date >= ' . "'" . $date1 . "'";
                $conddatelyoum="";
                $datelyoum=$this->request->data['Visite']['date1'];
            }else{
            $cond1 =""; 
            $datelyoum="";
            }

            if (($this->request->data['Visite']['date2'] != "__/__/____")) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Visite']['date2'])));
                $cond2 = 'Visite.date <= ' . "'" . $date2 . "'";
                $conddatelyoum="";
            }

            if ($this->request->data['Visite']['personnel_id']) {
                $personnelid = $this->request->data['Visite']['personnel_id'];
                $cond3 = 'Visite.personnel_id ='.  $personnelid;
            }
            if ($this->request->data['Visite']['affaire_id']) {
                $affaireid = $this->request->data['Visite']['affaire_id'];
                $cond4 = 'Visite.affaire_id ='.$affaireid;
            }
            if ($this->request->data['Visite']['bureaudetude']) {
                $bureaudetude = $this->request->data['Visite']['bureaudetude'];
                $cond5 = 'Affaire.bureaudetude ='. "'" . $bureaudetude. "'";
            }
            if ($this->request->data['Visite']['entreprisedefluide']) {
                $entreprisedefluide = $this->request->data['Visite']['entreprisedefluide'];
                $cond6 = 'Affaire.entreprisedefluide =' . "'". $entreprisedefluide. "'";
            }
        
            }
           // debug($this->request->data);
        $lisvisites = $this->Visite->find('all', array(
        'conditions' => array(@$conddatelyoum,@$cond1, @$cond2, @$cond3 , @$cond4, @$cond5, @$cond6
        ),'recursive'=>0));
        
        //debug($lisvisites);die;
        
//        foreach ($affaires as $affaire){
//        $numero = $this->Affaire->find('all', array('fields' => array('MAX(Affaire.numero) as num'),
//            'conditions' => array('Affaire.exercice_id' => date("Y")))
//            );
//            foreach ($numero as $num) {
//                $n = $num[0]['num'];
//            }
//            if (!empty($n)) {
//                $lastnum = $n;
//                $nume = intval($lastnum) + 1;
//                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            } else {
//                $mm = "000001";
//            }
//        $this->Affaire->updateAll(array('Affaire.numero' =>"'".$mm."'"), array('Affaire.id' => $affaire['Affaire']['id']));
       // }
        $affaires = $this->Affaire->find('list');
        $personnels = $this->Personnel->find('list');
        $bureaudetudes = $this->Affaire->find('list', array('fields' => array('Affaire.bureaudetude','Affaire.bureaudetude'),'group'=>array('Affaire.bureaudetude')));
        $entreprisedefluides = $this->Affaire->find('list', array('fields' => array('Affaire.entreprisedefluide','Affaire.entreprisedefluide'),'group'=>array('Affaire.entreprisedefluide')));
        $this->set(compact('entreprisedefluides','bureaudetudes','datelyoum','lisvisites','affaires','personnels', $this->paginate()));
    }
    
    
    


	public function view($id = null,$notif=null) {

        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'devis') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
            $this->loadModel('Piecejointeaffaire');
            $this->loadModel('Region');
            if($notif==1){
            $this->Affaire->updateAll(array('Affaire.valide' => 1), array('Affaire.id' => $id));
            }
            
		$this->Affaire->id = $id;
		if (!$this->Affaire->exists()) {
			throw new NotFoundException(__('Invalid affaire'));
		}
                $options = array('conditions' => array('Affaire.' . $this->Affaire->primaryKey => $id));
                        $this->request->data = $this->Affaire->find('first', $options);
		$date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Affaire']['date'])));
                        if ($date=="01/01/1970"){
                        $date="";
                        }
                $piecejointes = $this->Piecejointeaffaire->find('all', array('conditions' => array('Piecejointeaffaire.affaire_id' => $id)));
                //debug($piecejointes);die; 
                $regions = $this->Region->find('list');
                $this->set(compact('date','piecejointes','regions'));   
	}


	public function add() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'devis') {
                    $x = $liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
            $this->loadModel('Piecejointeaffaire');
            $this->loadModel('Region');
            $this->loadModel('Personnel');
		if ($this->request->is('post')) {
                   // debug($this->request->data);die;
                $this->request->data['Affaire']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Affaire']['date'])));
                $this->request->data['Affaire']['exercice_id'] = date("Y");
                $this->request->data['Affaire']['utilisateur_id'] = CakeSession::read('users');
                $listeresp='0';
                if (!empty($this->request->data['Affaire']['responsable'])) {
                foreach ($this->request->data['Affaire']['responsable'] as $p) {
                $listeresp = $listeresp . ',' . $p; 
                }
                }
                $listeresp = $listeresp . ',0';
                $this->request->data['Affaire']['responsable'] = $listeresp;
			$this->Affaire->create();
			if ($this->Affaire->save($this->request->data)) {
                            $id = $this->Affaire->id;
                            $this->misejour("Affaire","add",$id);
                            if (!empty($this->request->data['Piecejointeaffaire'])) {
                            foreach ($this->request->data['Piecejointeaffaire'] as $piecejointe) {
                            //debug($this->request->data);die;
                            if ($piecejointe['piece'] != '') {
                            if ($piecejointe['sup'] != 1) {
                                //$piecejointe['piece'] = $piecejointe['piece']['name'];
                                $piecejointe['affaire_id'] = $id;
                                $this->Piecejointeaffaire->create();
                                $this->Piecejointeaffaire->save($piecejointe);
                            }
                        }
                    }
                }
                
				$this->Session->setFlash(__('The affaire has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The affaire could not be saved. Please, try again.'));
			}
		}
            $numero = $this->Affaire->find('all', array('fields' => array('MAX(Affaire.numero) as num'),
            'conditions' => array('Affaire.exercice_id' => date("Y")))
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
            $regions = $this->Region->find('list');
            $responsables = $this->Personnel->find('list');
        $this->set(compact('mm','regions','responsables'));
	}


	public function edit($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'devis') {
                    $x = $liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
            $this->loadModel('Piecejointeaffaire');
            $this->loadModel('Region');
            $this->loadModel('Personnel');
		$this->Affaire->id = $id;
		if (!$this->Affaire->exists()) {
			throw new NotFoundException(__('Invalid affaire'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                $this->request->data['Affaire']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Affaire']['date'])));
		$this->request->data['Affaire']['exercice_id'] = date("Y", strtotime(str_replace('/', '-', $this->request->data['Affaire']['date'])));
                if ($this->request->data['Affaire']['date']=="01/01/1970"){
                $this->request->data['Affaire']['date']="";  
                $this->request->data['Affaire']['exercice_id'] =date("Y"); 
                }
                
                $listeresp='0';
                if (!empty($this->request->data['Affaire']['responsable'])) {
                foreach ($this->request->data['Affaire']['responsable'] as $p) {
                $listeresp = $listeresp . ',' . $p; 
                }
                }
                $listeresp = $listeresp . ',0';
                $this->request->data['Affaire']['responsable'] = $listeresp;
                //debug($this->request->data);die;
                if ($this->Affaire->save($this->request->data)) {
                    if ($this->Affaire->save($this->request->data)) {
                        $this->misejour("Affaire","edit",$id);
                            if (!empty($this->request->data['Piecejointeaffaire'])) {
                    foreach ($this->request->data['Piecejointeaffaire'] as $piecejointe) {
                        if (($piecejointe['sup'] == 1) && ($piecejointe['id'] != "")) {
                            $this->Piecejointeaffaire->deleteAll(array('Piecejointeaffaire.id' => $piecejointe['id']), false);
                        }
                        if ($piecejointe['piece'] != '') {
                            if ($piecejointe['sup'] != 1) {
                                //debug($piecejointe);
                                //$piecejointe['piece'] = $piecejointe['piece']['name'];
                                $piecejointe['affaire_id'] = $id;
                                $this->Piecejointeaffaire->create();
                                $this->Piecejointeaffaire->save($piecejointe);
                            }
                        }
                    }
                }
				$this->Session->setFlash(__('The affaire has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The affaire could not be saved. Please, try again.'));
			}
                }} else {
			$options = array('conditions' => array('Affaire.' . $this->Affaire->primaryKey => $id));
                        $this->request->data = $this->Affaire->find('first', $options);
                        
                }
                $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Affaire']['date'])));
                        if ($date=="01/01/1970"){
                        $date="";
                        }
                $piecejointes = $this->Piecejointeaffaire->find('all', array('conditions' => array('Piecejointeaffaire.affaire_id' => $id)));
                //debug($piecejointes);die; 
                $regions = $this->Region->find('list');
                $responsables = $this->Personnel->find('list');
                $this->set(compact('date','piecejointes','regions','responsables'));        
		
	}

        public function visite($id = null) {
            $this->loadModel('Visite');
            $this->loadModel('Personnel');
		if ($this->request->is('post') || $this->request->is('put')) {
                     if(!empty($this->request->data['Visite'])){
                            foreach ($this->request->data['Visite'] as $visite){
                                if (($visite['supp']==1)&&($visite['id']!="")){
                                $this->Visite->deleteAll(array('Visite.id'=>$visite['id']),false); 
                                }
                                if ($visite['personnel_id']!=''){
                                  if($visite['supp']!=1){
                                  $visite['date']=date("Y-m-d",strtotime(str_replace('/','-',$visite['date'])));
                                  $visite['affaire_id']=$id;
                                  $this->Visite->create();
                                  $this->Visite->save($visite);
                                  }
                                }
                                }
                        }  
                        $this->redirect(array('action' => 'index'));
                }else{
                $toutvisites= $this->Visite->find('all',array('conditions'=>array('Visite.affaire_id'=>$id),false));  
                $personnels = $this->Personnel->find('list');
                }
                $this->set(compact('toutvisites','personnels'));        
		
	}
	public function delete($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'devis') {
                    $x = $liens['delete'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Affaire->id = $id;
		if (!$this->Affaire->exists()) {
			throw new NotFoundException(__('Invalid affaire'));
		}
                $affaire = $this->Affaire->find('first', array('conditions' => array('Affaire.id' => $id), false));
                $numansar=$affaire['Affaire']['numero'];
		if ($this->Affaire->delete()) {
                    $this->misejour("Affaire",$numansar,$id);
			$this->Session->setFlash(__('Affaire deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Affaire was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        
        public function  detailaffaires(){
            $this->layout = null;
            $data = $this->request->data;
            //$json = null;
            $affaire_id= $data['affaire_id'];
            
          $Affaire= $this->Affaire->find('first',array('conditions'=>array('Affaire.id'=>$affaire_id),false));
          //debug($Affaire);die;
          $numero=$Affaire['Affaire']['numero'];
          $name=$Affaire['Affaire']['name'];
          $bureaudetude=$Affaire['Affaire']['bureaudetude'];
          $entreprisedefluide=$Affaire['Affaire']['entreprisedefluide'];
        echo json_encode(array('numero' => $numero, 'name' => $name,'bureaudetude' => $bureaudetude, 'entreprisedefluide' => $entreprisedefluide)); 
        die;
     }  
     
     
     
         public function notif_affaire() {

            $this->loadModel('Affaire');
            $this->loadModel('Utilisateur');
            $this->loadModel('Ligneworkflow');
             $this->layout = null;
             $data=$this->request->data;
             $d= $data['personnel'];
             $nb=0;
             $tab=array();
             $personnel = $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$d)));
             $nbrworkflows = $this->Ligneworkflow->find('count', array('conditions' => array('Ligneworkflow.personnel_id' => $personnel['Personnel']['id'], 'Ligneworkflow.typeworkflow_id' => 2, 'Workflow.document_id' =>2), 'recursive' => 2));
             //debug($nbrworkflows);die;
             
             //$listebs=$this->Affaire->find('all',array('conditions'=>array('Affaire.valide'=>0)));
             $listebs=$this->Affaire->query('select * from affaires where  valide=0');
             //debug($listebs);die;
             foreach ($listebs as $i=>$listeb) {
                // debug($listeb);die;
             
             $personnel = $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$listeb['affaires']['utilisateur_id'])));
             $tab[$i]['personel']= $personnel['Personnel']['name']; 
             $tab[$i]['id']= $listeb['affaires']['id']; 
             $tab[$i]['numero']= $listeb['affaires']['numero'];
             $tab[$i]['name']= $listeb['affaires']['name'];
             $tab[$i]['date']= $listeb['affaires']['date'];
             }
             //debug($listebs);die;
             
             $nbr=$this->Affaire->query('select count(*) from affaires where  valide=0');
             $nb=$nbr[0][0]['count(*)'];
             
             //$toutpersonnel = $this->Utilisateur->find('list', array('fields' => array('Utilisateur.login')));
             //debug($toutpersonnel);die;
             
             
             echo json_encode(array('nbrworkflows'=>$nbrworkflows,'nb'=>$nb,'tab'=>$tab));
             die;
    }
    
    
    public function getpersonnel() {

            $this->loadModel('Utilisateur');
             $this->layout = null;
             $data=$this->request->data;
             $d= $data['personnel'];
             $personnel = $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$d)));
             
             $personnel_cree=$personnel['Personnel']['name'];
             echo json_encode(array('personnel_cree'=>$personnel_cree));
             die;
    }
     
    public function selectart2() {
            $this->layout = null;
            $data=$this->request->data;
            $affaire= $data['val'];
            $listebs=$this->Affaire->query('select * from affaires where  name LIKE "'.$affaire.'%" group by name');
             foreach ($listebs as $i=>$listeb) {
             $tab[$i]['id']= $listeb['affaires']['id']; 
             $tab[$i]['name']= $listeb['affaires']['name'];
             }
             //debug($tab);die;
             echo json_encode(array('tab'=>$tab));
             die;
    } 
    
    
    public function notif_visite() {

             $this->loadModel('Affaire');
             $this->loadModel('Utilisateur');
             $this->loadModel('Visite');
             $this->loadModel('Personnel');
             $this->layout = null;
             $data=$this->request->data;
             
             $d= $data['personnel'];
             //debug($d);die;
             $nb=0;
             $tabv=array();
             $datelyoum=date("Y-m-d");
             $Utilisateur= $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$d)));
             //debug($Utilisateur);die;
             $listebs=$this->Visite->query('select * from visites where  date >= "'.$datelyoum.'" and personnel_id='.$Utilisateur['Utilisateur']['personnel_id']);
             //debug($listebs);die;
             foreach ($listebs as $i=>$listeb) {
             $affaire = $this->Affaire->find('first',array('conditions'=>array('Affaire.id'=>$listeb['visites']['affaire_id'])));    
             $personnel = $this->Personnel->find('first',array('conditions'=>array('Personnel.id'=>$listeb['visites']['personnel_id'])));
             $tabv[$i]['personel']= $personnel['Personnel']['name']; 
             $tabv[$i]['id']= $listeb['visites']['id']; 
             $tabv[$i]['lieu']= $listeb['visites']['lieu'];
             $tabv[$i]['affaire']= $affaire['Affaire']['name'];
             $tabv[$i]['date']= $listeb['visites']['date'];
             }
             $nbr=$this->Visite->query('select count(*) from visites where  date >="'.$datelyoum.'" and personnel_id='.$Utilisateur['Utilisateur']['personnel_id']);
             $nb=$nbr[0][0]['count(*)'];
             echo json_encode(array('nbv'=>$nb,'tabv'=>$tabv));
             die;
    }
    
    public function selectbureauetudes() {
            $this->layout = null;
            $data=$this->request->data;
            $affaire= $data['val'];
            $listebs=$this->Affaire->query('select * from affaires where  bureaudetude LIKE "'.$affaire.'%" group by bureaudetude');
             foreach ($listebs as $i=>$listeb) {
             $tab[$i]['id']= $listeb['affaires']['id']; 
             $tab[$i]['bureaudetude']= $listeb['affaires']['bureaudetude'];
             }
             //debug($tab);die;
             echo json_encode(array('tab'=>$tab));
             die;
    }
    
    public function recap($affaire_id=null) {
        $this->loadModel('Devi');
        $this->loadModel('Client');
        $this->loadModel('Suivicommercial');
        $this->layout = null;
        $affaire = $this->Affaire->find('first', array('conditions' => array('Affaire.id' => $affaire_id), false));
        $devis = $this->Devi->find('all', array('conditions' => array('Devi.affaire_id' => $affaire_id), false));
        //debug($devis);die;
        $statusuivis = $this->Suivicommercial->Statusuivi->find('list');
        $raisondeperdes[1]="PRIX ELEVEE"; 
        $raisondeperdes[2]="MANQUE RELATION";
        $raisondeperdes[3]="DISPONIBILITE";
        $raisondeperdes[4]="PAS INTERSSE";
        $raisondeperdes[5]="MANQUE DE SUIVE"; 
        $raisondeperdes[6]="PRODUIT NON CONFORME";
        $this->set(compact('statusuivis','raisondeperdes','devis','affaire'));
    }
    
     
}
