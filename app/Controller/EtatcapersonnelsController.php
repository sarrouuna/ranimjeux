<?php

App::uses('AppController', 'Controller');

/**
 * Etatcapersonnels Controller
 *
 * @property Etatcapersonnel $Etatcapersonnel
 */
class EtatcapersonnelsController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'etatcapersonnels') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Famille');
        $this->loadModel('Article');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Tabetatcaparpersonnel');
        $this->loadModel('Personnel');
        $this->loadModel('Zone');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Categoriearticle');
        //zeinab
        $this->loadModel('Fournisseur');
        $this->loadModel('Articlefournisseur');

        $fournisseurs = $this->Fournisseur->find('list');
        //
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id =' . $exe;
        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pvb = 'Bonlivraison.pointdevente_id = ' . $p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }
        $this->Tabetatcaparpersonnel->query('TRUNCATE tabetatcaparpersonnels;');


        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            $condb4 = "";
            $condf4 = "";
            $conda4 = "";
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];

                $condb4 = 'Bonlivraison.exercice_id =' . $exercices[$exerciceid];
                $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
                $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____") {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
                $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
                $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
                $condf4 = "";
                $condb4 = "";
                $conda4 = "";
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____") {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
                $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
                $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
                $condf4 = "";
                $condb4 = "";
                $conda4 = "";
            }

            if ($this->request->data['Recherche']['client_id']) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $condb3 = 'Bonlivraison.client_id =' . $clientid;
                $condf3 = 'Factureclient.client_id =' . $clientid;
                $conda3 = 'Factureavoir.client_id =' . $clientid;
            }

            
            if (!empty($this->request->data['Recherche']['pointdevente_id'])) {
                $pointdeventeid = $this->request->data['Recherche']['pointdevente_id'];
                $condb5 = 'Bonlivraison.pointdevente_id =' . $pointdeventeid;
                $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
                $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
            }
            if ($this->request->data['Recherche']['famille_id']) {
                $familleid = $this->request->data['Recherche']['famille_id'];
                $condb7 = 'Article.famille_id =' . $familleid;
                $condf7 = 'Article.famille_id =' . $familleid;
                $conda7 = 'Article.famille_id =' . $familleid;
            }
            if (!empty($this->request->data['Recherche']['personnel_id'])) {
                $personnelid = $this->request->data['Recherche']['personnel_id'];
                $clients = $this->Client->find('all', array('recursive' => -1, 'conditions' => array('Client.personnel_id' => $personnelid)));
                //debug($clients);die;
                $abc = '0';
                foreach ($clients as $cl) {
                    $abc = $abc . ',' . $cl['Client']['id'];
                }
                $condb8 = 'Bonlivraison.client_id in (' . $abc . ')';
                $condf8 = 'Factureclient.client_id in (' . $abc . ')';
                $conda8 = 'Factureavoir.client_id in (' . $abc . ')';
            }

            if (!empty($this->request->data['Recherche']['zone_id'])) {
                $zoneid = $this->request->data['Recherche']['zone_id'];
                $clients = $this->Client->find('all', array('recursive' => -1, 'conditions' => array('Client.zone_id' => $zoneid)));
                $zone = '0';
                foreach ($clients as $cl) {
                    $zone = $zone . ',' . $cl['Client']['id'];
                }
                $condb9 = 'Bonlivraison.client_id in (' . $zone . ')';
                $condf9 = 'Factureclient.client_id in (' . $zone . ')';
                $conda9 = 'Factureavoir.client_id in (' . $zone . ')';
            }
            //zeinab
            if (!empty($this->request->data['Recherche']['fournisseur_id'])) {
                $fournisseurid = $this->request->data['Recherche']['fournisseur_id'];
                $arts = $this->Articlefournisseur->find('all', array('recursive' => -1, 'conditions' => array('Articlefournisseur.fournisseur_id' => $fournisseurid)));
                //debug($arts);die;
                $artf = '0';
                foreach ($arts as $k => $art) {
                    if ($art['Articlefournisseur']['article_id'] != '') {
                        $artf = $artf . ',' . $art['Articlefournisseur']['article_id'];
                    }
                }

                $condFsseur = '(Article.id in (' . $artf . ') OR Article.id IS NULL)';
                // debug($artf);die;
            }
            
        }


        $bonlivraisonparprixs = $this->Lignelivraison->find('all', array(
            'fields' => array('sum(Lignelivraison.totalttc) as total', 'Bonlivraison.client_id')
            , 'conditions' => array(@$pvb, @$condb1, @$condb2, @$condb4, @$condb5, @$condb6, @$condb7, @$condb8, @$condb9, @$condb10, @$condFsseur)
            , 'group' => array('Bonlivraison.id')
            , 'contain' => array('Bonlivraison.Client')
            , 'recursive' => 0));

        debug($bonlivraisonparprixs);
        $bonlivraisonpartotales = $this->Lignelivraison->find('all', array('fields' => array('sum(Lignelivraison.totalttc) as total')
            , 'conditions' => array(@$condb4)));



        $factureclientparprixs = $this->Lignefactureclient->find('all', array(
            'fields' => array('sum(Lignefactureclient.totalttc) as total', 'Factureclient.client_id')
            , 'conditions' => array('Factureclient.source="fac"', @$pvf, @$condf1, @$condf2, @$condf4, @$condf5, @$condf6, @$condf7, @$condf8, @$condf9, @$condf10, @$condFsseur)
            , 'group' => array('Factureclient.id')
            , 'contain' => array('Client')
            , 'recursive' => 0));
        
        debug($factureclientparprixs);
        $factureclientpartotales = $this->Lignefactureclient->find('all', array('fields' => array('sum(Lignefactureclient.totalttc) as total')
            , 'conditions' => array(@$condf4, 'Factureclient.source="fac"')));

        
        $factureavoirparprixs = $this->Lignefactureavoir->find('all', array(
            'fields' => array('sum(Lignefactureavoir.totalttc) as total', 'Factureavoir.client_id')
            , 'conditions' => array(@$pva, @$conda1, @$conda2, @$conda4, @$conda5, @$conda6, @$conda7, @$conda8, @$conda9, @$conda10, @$condFsseur)
            , 'group' => array('Factureavoir.id')
            , 'contain' => array('Client')
            , 'recursive' => 0));
        
        debug($factureavoirparprixs);die;
        $factureavoirpartotales = $this->Lignefactureavoir->find('all', array('fields' => array('sum(Lignefactureavoir.totalttc) as total')
            , 'conditions' => array(@$conda4)));
        
        
        $totaleBLF = $bonlivraisonpartotales[0][0]['total'] + $factureclientpartotales[0][0]['total'] - $factureavoirpartotales[0][0]['total'];


//debug($factureavoirparprixs);die;
        $tab = array();
        $i = 0;
        //debug($bonlivraisonparprixs);
        foreach ($bonlivraisonparprixs as $bonlivraison) {
//            debug($bonlivraison);die;
            $clients = $this->Client->find('first', array(
                'conditions' => array('Client.id' => $bonlivraison['Bonlivraison']['client_id'])));
            //debug($clients);die;
            $tab['clientid'] = $bonlivraison['Bonlivraison']['client_id'];
            if (!empty($clients)) {
                $tab['name'] = $clients['Client']['name'];
            }
            $tab['personnel_id'] = $clients['Client']['personnel_id'];
            //$tab['articleid']= $bonlivraison['Article']['id'];
            //$tab['article']= $bonlivraison['Article']['name'];
            //$tab['qte']= $bonlivraison[0]['quantite'];
            $tab['tot'] = $bonlivraison[0]['total'];
            $tab['por'] = round(($bonlivraison[0]['total'] / $totaleBLF) * 100, 3);
            $this->Tabetatcaparpersonnel->create();
            $this->Tabetatcaparpersonnel->save($tab);
            $i++;
        }


        $tab = array();
        $index = 0;
        //debug($factureclientparprixs);
        foreach ($factureclientparprixs as $facture) {
            $clients = $this->Client->find('first', array(
                'conditions' => array('Client.id' => $facture['Factureclient']['client_id'])));
            //debug($clients);die;
            $tab['clientid'] = $facture['Factureclient']['client_id'];
            if (!empty($clients)) {
                $tab['name'] = $clients['Client']['name'];
            }
            $tab['personnel_id'] = $clients['Client']['personnel_id'];
            //$tab['articleid']= $facture['Article']['id'];
            //$tab['article']= $facture['Article']['name'];
            //$tab['qte']= $facture[0]['quantite'];
            $tab['tot'] = $facture[0]['total'];
            $tab['por'] = round(($facture[0]['total'] / $totaleBLF) * 100, 3);
            $this->Tabetatcaparpersonnel->create();
            $this->Tabetatcaparpersonnel->save($tab);
            $index++;
        }


        if (!empty($factureavoirparprixs)) {
            $tab = array();
            $index = 0;
            //debug($factureavoirparprixs);
            foreach ($factureavoirparprixs as $facture) {
                $clients = $this->Client->find('first', array(
                    'conditions' => array('Client.id' => $facture['Factureavoir']['client_id'])));
                //debug($clients);die;
                $tab['clientid'] = $facture['Factureavoir']['client_id'];
                if (!empty($clients)) {
                    $tab['name'] = $clients['Client']['name'];
                }
                $tab['personnel_id'] = $clients['Client']['personnel_id'];
                //$tab['articleid']= $facture['Article']['id'];
                //$tab['article']= $facture['Article']['name'];
                //$tab['qte']= 0-$facture[0]['quantite'];
                $tab['tot'] = 0 - $facture[0]['total'];
                $tab['por'] = round(($facture[0]['total'] / $totaleBLF) * 100, 3);
                $this->Tabetatcaparpersonnel->create();
                $this->Tabetatcaparpersonnel->save($tab);
                $index++;
            }
        }
//       $tab = $this->Tabetatcaparpersonnel->find('all', array(
//       'fields'=>array('sum(Tabetatcaparpersonnel.tot) as tot','clientid','name','article','sum(Tabetatcaparpersonnel.qte) as qte','personnel_id')
//       ,'group'=>array('Tabetatcaparpersonnel.clientid','Tabetatcaparpersonnel.articleid')
//       ,'recursive'=>2));
        debug($tab);die;
        $familles = $this->Famille->find('list');
        $clients = $this->Client->find('list');
        $personnels = $this->Personnel->find('list');
        $zones = $this->Zone->find('list');
        $personnelss = $this->Personnel->find('all');
        $this->set(compact('categoriearticleid','categoriearticles','fournisseurs', 'fourniseurid', 'personnelss', 'zoneid', 'zones', 'personnelid', 'personnels', 'familleid', 'pointdeventeid', 'articleid', 'familles', 'totaleBLF', 'articles', 'tab', 'bonlivraisons', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'factureclients'));
    }
    
    public function index_reg_personnel() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'etatcapersonnels') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
       $this->loadModel('Personnel'); 
       $this->loadModel('Piecereglementclient');
       $this->loadModel('Paiement');
       $this->loadModel('Reglementclient');
       $Date_deb="__/__/____" ;
       $Date_fn="__/__/____" ;
        if (isset($this->request->data) && !empty($this->request->data)) {
            
//        if($this->request->data['Recherche']['Date_debut'] == '__/__/____'){
//            $this->request->data['Recherche']['Date_debut']=date("d/m/Y");
//        }
//        if($this->request->data['Recherche']['Date_fin'] == '__/__/____'){
//            $this->request->data['Recherche']['Date_fin']=date("d/m/Y");
//        }
          
        if($this->request->data['Recherche']['Date_debut'] != '__/__/____'){
            $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Recherche']['Date_debut'])));
            $conddatedeb_reg='Reglementclient.Date>='."'".$Date_deb."'";
        }else{
           $Date_deb="__/__/____" ;
        }
        if($this->request->data['Recherche']['Date_fin'] != '__/__/____'){
            $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Recherche']['Date_fin'])));
            $conddatefin_reg='Reglementclient.Date<='."'".$Date_fn."'";
        }else{
           $Date_fn="__/__/____" ;
        }
        if (!empty($this->request->data['Recherche']['personnel_id'])) {
            $personnelid = $this->request->data['Recherche']['personnel_id'];
            $condpersonnel = 'Personnel.id=' . $personnelid;
        }
        if (!empty($this->request->data['Recherche']['paiement_id'])) {
            $paiementid = $this->request->data['Recherche']['paiement_id'];
            $abc='0';
            foreach ($paiementid as $cl){
              $abc=$abc.','.$cl;  
            }
            $condpaiement = 'Paiement.id in ('.$abc.')';
            $liste_paiements=$this->Paiement->find('all',array('recursive'=>-1,'conditions'=>array($condpaiement)));
        }
        }else{
            $condpaiement = 'Paiement.id in (1,2,3,4,5,8,22)';
            $liste_paiements=$this->Paiement->find('all',array('recursive'=>-1,'conditions'=>array($condpaiement)));
            //$this->request->data['Recherche']['Date_debut']=date("d/m/Y");
            //$this->request->data['Recherche']['Date_fin']=date("d/m/Y");
            //$conddatedeb_reg='Reglementclient.Date>='."'".date("Y-m-d")."'";
            //$conddatefin_reg='Reglementclient.Date<='."'".date("Y-m-d")."'";
        }
        $paiements=$this->Paiement->find('list');
        $personnels = $this->Personnel->find('list');
        $this->set(compact('personnelid','condpersonnel','liste_paiements','conddatefin_reg','conddatedeb_reg','paiements','personnels','Date_deb','Date_fn'));
        }
    
    public function imprimer_reg_personnel() {
        
       $this->loadModel('Personnel'); 
       $this->loadModel('Piecereglementclient');
       $this->loadModel('Paiement');
       $this->loadModel('Reglementclient');
       
        $this->response->type('pdf');
        $this->layout = 'pdf';
        $conddatedeb_reg="";
        $conddatefin_reg="";
        if ($this->request->query['Date_deb']!= '__/__/____') {
            $Date_deb=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_deb'])));
            $conddatedeb_reg='Reglementclient.Date>='."'".$Date_deb."'";
        }
        if ($this->request->query['Date_fn']!= '__/__/____') {
            $Date_fn=date("Y-m-d",strtotime(str_replace('/','-',$this->request->query['Date_fn'])));
            $conddatefin_reg='Reglementclient.Date<='."'".$Date_fn."'";
        }
        if ($this->request->query['personnelid']) {
            $personnelid = $this->request->query['personnelid'];
            $condpersonnel = 'Personnel.id=' . $personnelid;
        }
        
        $paiements=$this->Paiement->find('list');
        $personnels = $this->Personnel->find('list');
        $this->set(compact('condpersonnel','liste_paiements','conddatefin_reg','conddatedeb_reg','paiements','personnels','Date_deb','Date_fn'));
        }
    
    public function indexpersonnel() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if ($liens['lien'] == 'etatpointdeventes') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Personnel');


        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id =' . $exe;
        $condf4 = 'Factureclient.exercice_id =' . $exe;
        $conda4 = 'Factureavoir.exercice_id =' . $exe;
        $pv = "";
        $condb1 = "";
        $pvb = "";
        $condb3 = "";
        $condf1 = "";
        $pvf = "";
        $condf3 = "";
        $conda1 = "";
        $pva = "";
        $conda3 = "";
        $condb2 = "";
        $condf2 = "";
        $conda2 = "";
        $condb5 = "";
        $condf5 = "";
        $conda5 = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pvb = 'Bonlivraison.pointdevente_id = ' . $p;
            $pvf = 'Factureclient.pointdevente_id = ' . $p;
            $pva = 'Factureavoir.pointdevente_id = ' . $p;
        }
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $condb4 = 'Bonlivraison.exercice_id =' . $exercices[$exerciceid];
                $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
                $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____") {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
                $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
                $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
                $condf4 = "";
                $condf4av = "";
                $condb4 = "";
                $conda4 = "";
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____") {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
                $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
                $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
                $condf4 = "";
                $condf4av = "";
                $condb4 = "";
                $conda4 = "";
            }
            
            if (!empty($this->request->data['Recherche']['personnel_id'])) {
            $personnelid = $this->request->data['Recherche']['personnel_id'];
            $clients=$this->Client->find('all',array('recursive'=>-1,'conditions'=>array('Client.personnel_id'=>$personnelid)));
            //debug($clients);die;
            $abc='0';
            foreach ($clients as $cl){
              $abc=$abc.','.$cl['Client']['id'];  
            }
            $condb5 = 'Bonlivraison.client_id in ('.$abc.')';
            $condf5 = 'Factureclient.client_id in ('.$abc.')';
            $conda5 = 'Factureavoir.client_id in ('.$abc.')';
            $condpersonnel = 'Personnel.id=' . $personnelid;
            }
            
        }

        $bonlivraisonparprixs = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalht) as total, sum(Bonlivraison.totalttc) as totalttc, sum(Bonlivraison.Montant_Regler) as totalregler', 'client_id,Client.personnel_id')
            , 'conditions' => array($pvb, $condb1, $condb2, $condb3, $condb4, $condb5)
            , 'group' => array('Client.personnel_id')
            , 'contain' => array('Client')
            , 'recursive' => 2));
        //debug($bonlivraisonparprixs);
        $bonlivraisonpartotales = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalht) as total, sum(Bonlivraison.totalttc) as totalttc')
            , 'conditions' => array($pvb, $condb1, $condb2, $condb3, $condb4, $condb5)));

        $factureclientparprixs = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalht) as total,sum(Factureclient.totalttc) as totalttc,sum(Factureclient.Montant_Regler) as totalregler', 'client_id,Client.personnel_id')
            , 'conditions' => array('Factureclient.source="fac"', $pvf, $condf1, $condf2, $condf3, $condf4, $condf5)
            , 'group' => array('Client.personnel_id')
            , 'contain' => array('Client')
            , 'recursive' => 2));
        //debug($factureclientparprixs);die;
        $factureavoirparprixs = $this->Factureavoir->find('all', array('fields' => array('sum(Factureavoir.totalht) as total ,sum(Factureavoir.totalttc) as totalttc', 'client_id,Client.personnel_id')
            , 'conditions' => array($pva, $conda1, $conda2, $conda3, $conda4, $conda5)
            , 'group' => array('Client.personnel_id')
            , 'contain' => array('Client')
            , 'recursive' => 2));

        //debug($factureavoirparprixs);
        $factureclientpartotales = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalht) as total ,sum(Factureclient.totalttc) as totalttc')
        ,'conditions' => array('Factureclient.source="fac"', $pvf, $condf1, $condf2, $condf3, $condf4, $condf5)));
        
        $avoirclientpartotales = $this->Factureavoir->find('all', array('fields' => array('sum(Factureavoir.totalht) as total ,sum(Factureavoir.totalttc) as totalttc'), 'conditions' => array($pva, $conda1, $conda2, $conda3, $conda4, $conda5)));
        
        $totaleBLF = ($bonlivraisonpartotales[0][0]['total'] + $factureclientpartotales[0][0]['total']) - $avoirclientpartotales[0][0]['total'];
        $totaleBLFttc = ($bonlivraisonpartotales[0][0]['totalttc'] + $factureclientpartotales[0][0]['totalttc']) - $avoirclientpartotales[0][0]['totalttc'];
        
        $tab = array();
        $listepointdeventes = $this->Personnel->find('all', array('conditions' => array(@$condpersonnel)));
        foreach ($listepointdeventes as $i => $listepointdevente) {
            $tab[$i]['tot'] = 0;
            $tab[$i]['totttc'] = 0;
            $tab[$i]['mtregler'] = 0;
            $tab[$i]['por'] = 0;
            $tab[$i]['porttc'] = 0;
            $tab[$i]['Pid'] = $listepointdevente['Personnel']['id'];
            $tab[$i]['Pname'] = $listepointdevente['Personnel']['name'];
            foreach ($factureclientparprixs as $facture) {
                if ($facture['Client']['personnel_id'] == $listepointdevente['Personnel']['id']) {
                    $tab[$i]['tot'] = $tab[$i]['tot'] + $facture[0]['total'];
                    $tab[$i]['totttc'] = $tab[$i]['totttc'] + $facture[0]['totalttc'];
                    $tab[$i]['mtregler'] = $tab[$i]['mtregler'] + $facture[0]['totalregler'];
                    //$tab[$i]['por'] = sprintf("%01.3f", (($facture[0]['total'] + $tab[$i]['por']) / $totaleBLF) * 100);
                    //$tab[$i]['porttc'] = sprintf("%01.3f", (($facture[0]['totalttc'] + $tab[$i]['porttc']) / $totaleBLFttc) * 100);
                }
            }
            foreach ($bonlivraisonparprixs as $bonlivraison) {
                if ($listepointdevente['Personnel']['id'] == $bonlivraison['Client']['personnel_id']) {
                    $tab[$i]['tot'] = $tab[$i]['tot'] + $bonlivraison[0]['total'];
                    $tab[$i]['totttc'] = $tab[$i]['totttc'] + $bonlivraison[0]['totalttc'];
                    $tab[$i]['mtregler'] = $tab[$i]['mtregler'] + $bonlivraison[0]['totalregler'];
                    //$tab[$i]['por'] = sprintf("%01.3f", (($tab[$i]['por'] + $bonlivraison[0]['total']) / $totaleBLF) * 100);
                    //$tab[$i]['porttc'] = sprintf("%01.3f", (($tab[$i]['porttc'] + $bonlivraison[0]['totalttc']) / $totaleBLFttc) * 100);
                }
            }
            foreach ($factureavoirparprixs as $ij => $factureav) {
                if ($listepointdevente['Personnel']['id'] == $factureav['Client']['personnel_id']) {
                    $tab[$i]['tot'] = $tab[$i]['tot'] - $factureav[0]['total'];
                    $tab[$i]['totttc'] = $tab[$i]['totttc'] - $factureav[0]['totalttc'];
                }
            }
        }

        foreach ($tab as $j => $t) {
            $tab[$j]['por'] = sprintf("%01.3f", (($tab[$j]['tot']) / $totaleBLF) * 100);
            $tab[$j]['porttc'] = sprintf("%01.3f", (( $tab[$j]['totttc']) / $totaleBLFttc) * 100);
        }





//        foreach ($factureclientparprixs as $i => $facture) {
//            foreach ($bonlivraisonparprixs as $bonlivraison) {
//                if ($facture['Pointdevente']['id'] == $bonlivraison['Pointdevente']['id']) {
//                    $tab[$i]['PVid'] = $facture['Pointdevente']['id'];
//                    $tab[$i]['PVname'] = $facture['Pointdevente']['name'];
//                    $tab[$i]['tot'] = $facture[0]['total'] + $bonlivraison[0]['total'];
//                    $tab[$i]['totttc'] = $facture[0]['totalttc'] + $bonlivraison[0]['totalttc'];
//                    $tab[$i]['mtregler'] = $facture[0]['totalregler'] + $bonlivraison[0]['totalregler'];
//                    $tab[$i]['por'] = sprintf("%01.3f", (($facture[0]['total'] + $bonlivraison[0]['total']) / $totaleBLF) * 100);
//                    $tab[$i]['porttc'] = sprintf("%01.3f", (($facture[0]['totalttc'] + $bonlivraison[0]['totalttc']) / $totaleBLFttc) * 100);
//                }
//            }
//
//            if (@$tab[$i]['PVname'] == "") {
//                $tab[$i]['PVid'] = $facture['Pointdevente']['id'];
//                $tab[$i]['PVname'] = $facture['Pointdevente']['name'];
//                $tab[$i]['tot'] = $facture[0]['total'];
//                $tab[$i]['totttc'] = $facture[0]['totalttc'];
//                $tab[$i]['mtregler'] = $facture[0]['totalregler'];
//                $tab[$i]['por'] = sprintf("%01.3f", ($facture[0]['total'] / $totaleBLF) * 100);
//                $tab[$i]['porttc'] = sprintf("%01.3f", ($facture[0]['totalttc'] / $totaleBLFttc) * 100);
//            }
//            foreach ($factureavoirparprixs as $ij => $factureav) {
//                if ($tab[$i]['PVid'] == $factureav['Pointdevente']['id']) {
//
//                    $tab[$i]['tot'] = $tab[$i]['tot'] - $factureav[0]['total'];
//                    $tab[$i]['totttc'] = $tab[$i]['totttc'] - $factureav[0]['totalttc'];
//                }
//            }
//        }
        //debug($tab);die;


        $personnels = $this->Personnel->find('list');
        $this->set(compact('pointdeventeid', 'totaleBLF', 'totaleBLFttc', 'tab', 'bonlivraisons', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'personnels', 'factureclients'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'etatcapersonnels') {
                    $x = $liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Famille');
        $this->loadModel('Article');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Tabetatcaparpersonnel');
        $this->loadModel('Personnel');
        $this->loadModel('Zone');
        $this->loadModel('Articlefournisseur');
        //debug($this->request->data);die;
        if ($this->request->query['date1']) {
            $date1 = $this->request->query['date1'];
        }

        if ($this->request->query['date2']) {
            $date2 = $this->request->query['date2'];
        }

        if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
        }
        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
        }
        if ($this->request->query['articleid']) {
            $articleid = $this->request->query['articleid'];
        }
        if (!empty($this->request->query['pointdeventeid'])) {
            $pointdeventeid = $this->request->query['pointdeventeid'];
        }
        if ($this->request->query['familleid']) {
            $familleid = $this->request->query['familleid'];
        }
        if ($this->request->query['personnelid']) {
            $personnelid = $this->request->query['personnelid'];
        }
        if ($this->request->query['zoneid']) {
            $zoneid = $this->request->query['zoneid'];
        }



        $tab = $this->Tabetatcaparpersonnel->find('all', array(
            'fields' => array('sum(Tabetatcaparpersonnel.tot) as tot', 'clientid', 'name', 'article', 'sum(Tabetatcaparpersonnel.qte) as qte')
            , 'group' => array('Tabetatcaparpersonnel.clientid', 'Tabetatcaparpersonnel.articleid')
            , 'recursive' => 2));
$personnelss = $this->Personnel->find('all');
//        debug($tab);die;
        $personnels = $this->Personnel->find('list');
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $familles = $this->Famille->find('list');
        $articles = $this->Article->find('list');
        $clients = $this->Client->find('list');
        $zones = $this->Zone->find('list');
        //debug($clients);die;
        $this->set(compact('personnelss','zoneid', 'zones', 'personnelid', 'personnels', 'familleid', 'pointdeventeid', 'articleid', 'familles', 'articles', 'tab', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Etatcapersonnel->create();
            if ($this->Etatcapersonnel->save($this->request->data)) {
                $this->Session->setFlash(__('The etatcapersonnel has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatcapersonnel could not be saved. Please, try again.'));
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
        if (!$this->Etatcapersonnel->exists($id)) {
            throw new NotFoundException(__('Invalid etatcapersonnel'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Etatcapersonnel->save($this->request->data)) {
                $this->Session->setFlash(__('The etatcapersonnel has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatcapersonnel could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Etatcapersonnel.' . $this->Etatcapersonnel->primaryKey => $id));
            $this->request->data = $this->Etatcapersonnel->find('first', $options);
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
        $this->Etatcapersonnel->id = $id;
        if (!$this->Etatcapersonnel->exists()) {
            throw new NotFoundException(__('Invalid etatcapersonnel'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Etatcapersonnel->delete()) {
            $this->Session->setFlash(__('Etatcapersonnel deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Etatcapersonnel was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
