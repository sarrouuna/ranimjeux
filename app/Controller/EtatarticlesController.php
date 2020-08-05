<?php

App::uses('AppController', 'Controller');

/**
 * Etatarticles Controller
 *
 * @property Etatarticle $Etatarticle
 */
class EtatarticlesController extends AppController {

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
                if (@$liens['lien'] == 'etatarticles') {
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
        $this->loadModel('Tabetatarticle');
        $this->loadModel('Tag');
        $this->loadModel('Articletag');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Fournisseur');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Personnel');
        $this->loadModel('Societe');
        $fournisseurs = $this->Fournisseur->find('list');
        $personnels = $this->Personnel->find('list');
        $this->Tabetatarticle->query('TRUNCATE tabetatarticles;');

        $pointdeventes = $this->Pointdevente->find('list');
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
        $socc = CakeSession::read('soc');
        $pvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id in (' . $socc . ')')));
        $liste_pv = '0';
        foreach ($pvs as $one_pv) {
            if (!empty($one_pv['Pointdevente']['id'])) {
                $liste_pv = $liste_pv . ',' . $one_pv['Pointdevente']['id'];
            }
        }
        $condbsos = 'Bonlivraison.pointdevente_id in (' . $liste_pv . ')';
        $condfsos = 'Factureclient.pointdevente_id in (' . $liste_pv . ')';
        $condasos = 'Factureavoir.pointdevente_id in (' . $liste_pv . ')';
        if ($this->request->is('post')) {
            //debug($this->request->data);die;
            if (!empty($this->request->data['Recherche']['societe_id'])) {
                $societe_id = $this->request->data['Recherche']['societe_id'];
                $societe_id = implode(',', $societe_id);
                $pvs = $this->Pointdevente->find('all', array(
                    'conditions' => array('Pointdevente.societe_id in (' . $societe_id . ')'),
                    'fields' => array('Pointdevente.id')
                ));
                $liste_pv = '0';
                foreach ($pvs as $one_pv) {
                    if (!empty($one_pv['Pointdevente']['id'])) {
                        $liste_pv = $liste_pv . ',' . $one_pv['Pointdevente']['id'];
                    }
                }
                $condbsos = 'Bonlivraison.pointdevente_id in (' . $liste_pv . ')';
                $condfsos = 'Factureclient.pointdevente_id in (' . $liste_pv . ')';
                $condasos = 'Factureavoir.pointdevente_id in (' . $liste_pv . ')';
            }
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $condb4 = 'Bonlivraison.exercice_id =' . $exercices[$exerciceid];
                $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
                $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];
            }
            if ($this->request->data['Recherche']['client_id']) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $condb32 = 'Bonlivraison.client_id =' . $clientid;
                $condf32 = 'Factureclient.client_id =' . $clientid;
                $conda32 = 'Factureavoir.client_id =' . $clientid;
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
                $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
                $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
                $condf4 = "";
                $condb4 = "";
                $conda4 = "";
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
                $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
                $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
                $condf4 = "";
                $condb4 = "";
                $conda4 = "";
            }



            if ($this->request->data['Recherche']['article_id']) {
                $articleid = $this->request->data['Recherche']['article_id'];
                $condb6 = 'Lignelivraison.article_id =' . $articleid;
                $condf6 = 'Lignefactureclient.article_id =' . $articleid;
                $conda6 = 'Lignefactureavoir.article_id =' . $articleid;
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
            if ($this->request->data['Recherche']['tag_id']) {
                $tagid = $this->request->data['Recherche']['tag_id'];
                $articles = $this->Articletag->find('all', array('recursive' => -1, 'conditions' => array('Articletag.tag_id' => $tagid)));
                $t = '(0';
                foreach ($articles as $ad) {
                    $t = $t . ',' . $ad['Articletag']['article_id'];
                }
                $t = $t . ')';
                $condb8 = 'Lignelivraison.article_id  in' . $t;
                $condf8 = 'Lignefactureclient.article_id in' . $t;
                $conda8 = 'Lignefactureavoir.article_id in' . $t;
            }
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

                $condFsseur = 'Article.id in (' . $artf . ')';
                // debug($artf);die;
            }
            if (!empty($this->request->data['Recherche']['personnel_id'])) {
                $personnelid = $this->request->data['Recherche']['personnel_id'];
                $clients = $this->Client->find('all', array('recursive' => -1, 'conditions' => array('Client.personnel_id' => $personnelid)));
                //debug($clients);die;
                $abc = '0';
                foreach ($clients as $cl) {
                    $abc = $abc . ',' . $cl['Client']['id'];
                }
                $condb9 = 'Bonlivraison.client_id in (' . $abc . ')';
                $condf9 = 'Factureclient.client_id in (' . $abc . ')';
                $conda9 = 'Factureavoir.client_id in (' . $abc . ')';
            }
        }
        $bonlivraisonparprixs = $this->Lignelivraison->find('all', array(
            'fields' => array('sum(Lignelivraison.totalht) as total', 'Article.name', 'Article.id', 'sum(Lignelivraison.quantite) as quantite', 'sum(Lignelivraison.totalttc) as totalttc')
            , 'conditions' => array(@$condb32, @$pvb, @$condb1, @$condb2, @$condb4, @$condb5, @$condb6, @$condb7, @$condb8, @$condb9, @$condFsseur, @$condbsos)
            , 'group' => array('Lignelivraison.article_id')
            , 'contain' => array('Bonlivraison', 'Article'), 'recursive' => 2));



        $bonlivraisonpartotales = $this->Lignelivraison->find('all', array('fields' => array('sum(Lignelivraison.totalht) as total')
            , 'conditions' => array(@$condb1, @$condb2, @$condb4)));

        $bonlivraisonpartotalesTTC = $this->Lignelivraison->find('all', array('fields' => array('sum(Lignelivraison.totalttc) as total')
            , 'conditions' => array(@$condb1, @$condb2, @$condb4)));


        $factureclientparprixs = $this->Lignefactureclient->find('all', array(
            'fields' => array('sum(Lignefactureclient.totalht) as total', 'Article.name', 'Article.id', 'sum(Lignefactureclient.quantite) as quantite', 'sum(Lignefactureclient.totalttc) as totalttc')
            , 'conditions' => array('Factureclient.source="fac"', @$condf32, @$pvf, @$condf1, @$condf2, @$condf4, @$condf5, @$condf6, @$condf7, @$condf8, @$condf9, @$condFsseur, @$condfsos)
            , 'group' => array('Lignefactureclient.article_id')
            , 'contain' => array('Factureclient', 'Article'), 'recursive' => 2));

        $factureclientpartotales = $this->Lignefactureclient->find('all', array('fields' => array('sum(Lignefactureclient.totalht) as total'), 'conditions' => array(@$condf1, @$condf2, @$condf4, 'Factureclient.source="fac"')));

        $factureclientpartotalesTTC = $this->Lignefactureclient->find('all', array('fields' => array('sum(Lignefactureclient.totalttc) as total')
            , 'conditions' => array(@$condf1, @$condf2, @$condf4, 'Factureclient.source="fac"')));




        $factureavoirparprixs = $this->Lignefactureavoir->find('all', array(
            'fields' => array('sum(Lignefactureavoir.totalht) as total', 'Article.name', 'Article.id', 'sum(Lignefactureavoir.quantite) as quantite', 'sum(Lignefactureavoir.totalttc) as totalttc')
            , 'conditions' => array(@$conda32, @$pva, @$conda1, @$conda2, @$conda4, @$conda5, @$conda6, @$conda7, @$conda8, @$conda9, @$condFsseur, @$condasos)
            , 'group' => array('Lignefactureavoir.article_id')
            , 'contain' => array('Factureavoir', 'Article'), 'recursive' => 2));

        $factureavoirpartotales = $this->Lignefactureavoir->find('all', array('fields' => array('sum(Lignefactureavoir.totalht) as total'), 'conditions' => array(@$conda1, @$conda2, @$conda4)));

        $factureavoirpartotalesTTC = $this->Lignefactureavoir->find('all', array('fields' => array('sum(Lignefactureavoir.totalttc) as total')
            , 'conditions' => array(@$conda1, @$conda2, @$conda4)));

        $totaleBLF = $bonlivraisonpartotales[0][0]['total'] + $factureclientpartotales[0][0]['total'] - $factureavoirpartotales[0][0]['total'];
        $totaleBLFTTC = $bonlivraisonpartotalesTTC[0][0]['total'] + $factureclientpartotalesTTC[0][0]['total'] - $factureavoirpartotalesTTC[0][0]['total'];

        //debug($factureclientpartotales);
        //debug($bonlivraisonpartotales);
        //debug($factureavoirpartotales);die;
//   
//   debug($factureclientpartotalesTTC);
//   debug($bonlivraisonpartotalesTTC);
//   debug($factureavoirpartotalesTTC);
//   debug($totaleBLF);
//   debug($totaleBLFTTC);
//  
//  debug($bonlivraisonparprixs);
//  debug($factureclientparprixs);
//  debug($factureavoirparprixs);
        $tab = array();
        $i = 0;
        foreach ($bonlivraisonparprixs as $bonlivraison) {
            $tab[$i]['articleid'] = $bonlivraison['Article']['id'];
            $tab[$i]['article'] = $bonlivraison['Article']['name'];
            $tab[$i]['qte'] = $bonlivraison[0]['quantite'];
            $tab[$i]['tot'] = $bonlivraison[0]['total'];
            $tab[$i]['totalttc'] = $bonlivraison[0]['totalttc'];
            $tab[$i]['por'] = round(($bonlivraison[0]['total'] / $totaleBLF) * 100, 3);
            $this->Tabetatarticle->create();
            $this->Tabetatarticle->save($tab[$i]);
            $i++;
        }
        $tab = array();
        $index = 0;
        foreach ($factureclientparprixs as $facture) {
            $tab[$index]['articleid'] = $facture['Article']['id'];
            $tab[$index]['article'] = $facture['Article']['name'];
            $tab[$index]['qte'] = $facture[0]['quantite'];
            $tab[$index]['tot'] = $facture[0]['total'];
            $tab[$index]['totalttc'] = $facture[0]['totalttc'];
            $tab[$index]['por'] = round(($facture[0]['total'] / $totaleBLF) * 100, 3);
            $this->Tabetatarticle->create();
            $this->Tabetatarticle->save($tab[$index]);
            $index++;
        }
        if (!empty($factureavoirparprixs)) {
            $tab = array();
            $index = 0;
            foreach ($factureavoirparprixs as $facture) {
                $tab[$index]['articleid'] = $facture['Article']['id'];
                $tab[$index]['article'] = $facture['Article']['name'];
                $tab[$index]['qte'] = 0 - $facture[0]['quantite'];
                $tab[$index]['tot'] = 0 - $facture[0]['total'];
                $tab[$index]['totalttc'] = 0 - $facture[0]['totalttc'];
                $tab[$index]['por'] = round(($facture[0]['total'] / $totaleBLF) * 100, 3);
                $this->Tabetatarticle->create();
                $this->Tabetatarticle->save($tab[$index]);
                $index++;
            }
        }



        $tab = $this->Tabetatarticle->find('all', array(
            'fields' => array('sum(Tabetatarticle.tot) as tot', 'sum(Tabetatarticle.totalttc) as ttc', 'articleid', 'article', 'sum(Tabetatarticle.qte) as qte')
            , 'group' => array('Tabetatarticle.articleid')
            , 'order' => array('sum(Tabetatarticle.tot)' => 'desc')
            , 'recursive' => 2));
        //debug($tab);die;
        $familles = $this->Famille->find('list');
        //$articles = $this->Article->find('list');
        $clients = $this->Client->find('list');
        $tags = $this->Tag->find('list');
        $soc = CakeSession::read('soc');
       
        $sos = explode(',', $soc);
        $countsos = count($sos);
        $societes = array();
        if ($countsos > 1) {
            $societes = $this->Societe->find('list', array(
                'conditions' => array('Societe.id in' => $sos)
            ));
        }
        $this->set(compact('societes', 'countsos','personnels', 'fournisseurs', 'totaleBLFTTC', 'tagid', 'tags', 'familleid', 'pointdeventeid', 'articleid', 'familles', 'totaleBLF', 'articles', 'tab', 'bonlivraisons', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clients', 'factureclients'));
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'etatarticles') {
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
        $this->loadModel('Tabetatarticle');
        $this->loadModel('Tag');
        $this->loadModel('Articletag');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignefactureavoir');

        // $this->Tabetatarticle->query('TRUNCATE tabetatarticles;'); 

        $pointdeventes = $this->Pointdevente->find('list');
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

        //debug($this->request->data);die;
        if ($this->request->query['date1']) {
            $date1 = $this->request->query['date1'];
            $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
            $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }

        if ($this->request->query['date2']) {
            $date2 = $this->request->query['date2'];
            $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
            $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }


        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $condb4 = 'Bonlivraison.exercice_id =' . $exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
            $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];
        }
        if ($this->request->query['articleid']) {
            $articleid = $this->request->query['articleid'];
            $condb6 = 'Lignelivraison.article_id =' . $articleid;
            $condf6 = 'Lignefactureclient.article_id =' . $articleid;
            $conda6 = 'Lignefactureavoir.article_id =' . $articleid;
        }
        if (!empty($this->request->query['pointdeventeid'])) {
            $pointdeventeid = $this->request->query['pointdeventeid'];
            $condb5 = 'Bonlivraison.pointdevente_id =' . $pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
            $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
        }
        if ($this->request->query['familleid']) {
            $familleid = $this->request->query['familleid'];
            $condb7 = 'Article.famille_id =' . $familleid;
            $condf7 = 'Article.famille_id =' . $familleid;
            $conda7 = 'Article.famille_id =' . $familleid;
        }
        if ($this->request->query['tagid']) {
            $tagid = $this->request->query['tagid'];
            $articles = $this->Articletag->find('all', array('recursive' => -1, 'conditions' => array('Articletag.tag_id' => $tagid)));
            $t = '(0';
            foreach ($articles as $ad) {
                $t = $t . ',' . $ad['Articletag']['article_id'];
            }
            $t = $t . ')';
            $condb8 = 'Lignelivraison.article_id  in' . $t;
            $condf8 = 'Lignefactureclient.article_id in' . $t;
            $conda8 = 'Lignefactureavoir.article_id in' . $t;
        }

//    
//  $bonlivraisonparprixs = $this->Lignelivraison->find('all', array(
//   'fields'=>array('sum(Lignelivraison.totalht) as total','Article.name','Article.id','sum(Lignelivraison.quantite) as quantite')
//  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,@$pvb, @$condb1, @$condb2,  @$condb4, @$condb5, @$condb6, @$condb7, @$condb8)
//  ,'group'=>array('Lignelivraison.article_id')
//  ,'contain'=>array('Bonlivraison','Article'),'recursive'=>2));
        //debug($bonlivraisonparprixs);die; 
//  $bonlivraisonpartotales = $this->Lignelivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalht) as total')
//  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0)));
//  
//  $factureclientparprixs = $this->Lignefactureclient->find('all', array(
//   'fields'=>array('sum(Lignefactureclient.totalht) as total','Article.name','Article.id','sum(Lignefactureclient.quantite) as quantite')
//  ,'conditions' => array('Factureclient.id > ' => 0,@$pvf, @$condf1, @$condf2 , @$condf4, @$condf5, @$condf6, @$condf7, @$condf8)
//  ,'group'=>array('Lignefactureclient.article_id')
//  ,'contain'=>array('Factureclient','Article'),'recursive'=>2));
//  
//  $factureavoirparprixs = $this->Lignefactureavoir->find('all', array(
//   'fields'=>array('sum(Lignefactureavoir.totalht) as total','Article.name','Article.id','sum(Lignefactureavoir.quantite) as quantite')
//  ,'conditions' => array('Factureavoir.id > ' => 0,@$pva, @$conda1, @$conda2 , @$conda4, @$conda5, @$conda6, @$conda7, @$conda8)
//  ,'group'=>array('Lignefactureavoir.article_id')
//  ,'contain'=>array('Factureavoir','Article'),'recursive'=>2));
//  
//  
//  $factureclientpartotales = $this->Lignefactureclient->find('all', array('fields'=>array('sum(Factureclient.totalht) as total'), 'conditions' => array('Factureclient.id > ' => 0)));
//  $totaleBLF=$bonlivraisonpartotales[0][0]['total']+$factureclientpartotales[0][0]['total'];
//  // debug($factureclientparprixs);die;
//       $tab=array();
//       $i=0;
//       foreach ($bonlivraisonparprixs as $bonlivraison){
//       $tab[$i]['articleid']= $bonlivraison['Article']['id'];
//       $tab[$i]['article']= $bonlivraison['Article']['name'];
//       $tab[$i]['qte']= $bonlivraison[0]['quantite'];
//       $tab[$i]['tot']= $bonlivraison[0]['total'];
//       $tab[$i]['por']= round(($bonlivraison[0]['total']/$totaleBLF)*100, 3);
//       $this->Tabetatarticle->create();
//       $this->Tabetatarticle->save($tab[$i]); 
//       $i++;
//       }
//       $tab=array();
//       $index=0;
//       foreach ($factureclientparprixs as $facture){
//       $tab[$index]['articleid']= $facture['Article']['id'];
//       $tab[$index]['article']= $facture['Article']['name'];
//       $tab[$index]['qte']= $facture[0]['quantite'];
//       $tab[$index]['tot']= $facture[0]['total']; 
//       $tab[$index]['por']= round(($facture[0]['total']/$totaleBLF)*100,3);
//       $this->Tabetatarticle->create();
//       $this->Tabetatarticle->save($tab[$index]); 
//       $index++;
//       }
//       if(!empty($factureavoirparprixs)){
//       $tab=array();
//       $index=0;
//       foreach ($factureavoirparprixs as $facture){
//       $tab[$index]['articleid']= $facture['Article']['id'];
//       $tab[$index]['article']= $facture['Article']['name'];
//       $tab[$index]['qte']= 0-$facture[0]['quantite'];
//       $tab[$index]['tot']= 0-$facture[0]['total']; 
//       $tab[$index]['por']= round(($facture[0]['total']/$totaleBLF)*100,3);
//       $this->Tabetatarticle->create();
//       $this->Tabetatarticle->save($tab[$index]); 
//       $index++;
//       }    
//       }
        $tab = $this->Tabetatarticle->find('all', array(
            'fields' => array('sum(Tabetatarticle.tot) as tot', 'sum(Tabetatarticle.totalttc) as ttc', 'articleid', 'article', 'sum(Tabetatarticle.qte) as qte')
            , 'group' => array('Tabetatarticle.articleid')
            , 'order' => array('sum(Tabetatarticle.tot)' => 'desc')
            , 'recursive' => 2));
        //debug($tab);die;


        $familles = $this->Famille->find('list');
        $articles = $this->Article->find('list');
        $clients = $this->Client->find('list');
        $tags = $this->Tag->find('list');
        $this->set(compact('tagid', 'tags', 'familleid', 'pointdeventeid', 'articleid', 'familles', 'totaleBLF', 'tab', 'bonlivraisons', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clients', 'factureclients'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Etatarticle->exists($id)) {
            throw new NotFoundException(__('Invalid etatarticle'));
        }
        $options = array('conditions' => array('Etatarticle.' . $this->Etatarticle->primaryKey => $id));
        $this->set('etatarticle', $this->Etatarticle->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Etatarticle->create();
            if ($this->Etatarticle->save($this->request->data)) {
                $this->Session->setFlash(__('The etatarticle has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatarticle could not be saved. Please, try again.'));
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
        if (!$this->Etatarticle->exists($id)) {
            throw new NotFoundException(__('Invalid etatarticle'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Etatarticle->save($this->request->data)) {
                $this->Session->setFlash(__('The etatarticle has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatarticle could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Etatarticle.' . $this->Etatarticle->primaryKey => $id));
            $this->request->data = $this->Etatarticle->find('first', $options);
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
        $this->Etatarticle->id = $id;
        if (!$this->Etatarticle->exists()) {
            throw new NotFoundException(__('Invalid etatarticle'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Etatarticle->delete()) {
            $this->Session->setFlash(__('Etatarticle deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Etatarticle was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
    
    public function etatmargearticle() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'etatarticles') {
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
        $this->loadModel('Tabetatarticle');
        $this->loadModel('Tag');
        $this->loadModel('Articletag');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Fournisseur');
        $this->loadModel('Personnel');
        $this->loadModel('Articlefournisseur');

        $this->Tabetatarticle->query('TRUNCATE tabetatarticles;');

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
        if ($this->request->is('post')) {
//            debug($this->request->data);die;
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



            if ($this->request->data['Recherche']['article_id']) {
                $articleid = $this->request->data['Recherche']['article_id'];
                $condb6 = 'Lignelivraison.article_id =' . $articleid;
                $condf6 = 'Lignefactureclient.article_id =' . $articleid;
                $conda6 = 'Lignefactureavoir.article_id =' . $articleid;
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
            if (@$this->request->data['Recherche']['tag_id']) {
                $tagid = $this->request->data['Recherche']['tag_id'];
                $articles = $this->Articletag->find('all', array('recursive' => -1, 'conditions' => array('Articletag.tag_id' => $tagid)));
                $t = '(0';
                foreach ($articles as $ad) {
                    $t = $t . ',' . $ad['Articletag']['article_id'];
                }
                $t = $t . ')';
                $condb8 = 'Lignelivraison.article_id  in' . $t;
                $condf8 = 'Lignefactureclient.article_id in' . $t;
                $conda8 = 'Lignefactureavoir.article_id in' . $t;
            }
            if ($this->request->data['Recherche']['client_id']) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $condb9 = 'Bonlivraison.client_id =' . $clientid;
                $condf9 = 'Factureclient.client_id =' . $clientid;
                $conda9 = 'Factureavoir.client_id =' . $clientid;
            }
            if (!empty($this->request->data['Recherche']['fournisseur_id'])) {
                $fournisseurid = $this->request->data['Recherche']['fournisseur_id'];
                $fournisseur = $this->Fournisseur->find('first', array('recursive' => -1, 'conditions' => array('Fournisseur.id' => $fournisseurid)));
                //debug($fournisseur);die;
                $devise_frs = $fournisseur['Fournisseur']['devise_id'];
                $id_frs = $fournisseur['Fournisseur']['id'];
                $arts = $this->Articlefournisseur->find('all', array('recursive' => -1, 'conditions' => array('Articlefournisseur.fournisseur_id' => $fournisseurid)));
                //debug($arts);die;
                $artf = '0';
                foreach ($arts as $k => $art) {
                    if ($art['Articlefournisseur']['article_id'] != '') {
                        $artf = $artf . ',' . $art['Articlefournisseur']['article_id'];
                    }
                }

                $condFsseur = 'Article.id in (' . $artf . ')';
                // debug($artf);die;
                $founisseur = '/0/';
                foreach ($arts as $k => $art) {
                    if ($art['Articlefournisseur']['article_id'] != '') {
                        $founisseur = $founisseur . ',/' . $art['Articlefournisseur']['article_id'] . '/';
                    }
                }
                $founisseur = $founisseur;
            }
            if (!empty($this->request->data['Recherche']['personnel_id'])) {
                $personnelid = $this->request->data['Recherche']['personnel_id'];
                $clients = $this->Client->find('all', array('recursive' => -1, 'conditions' => array('Client.personnel_id' => $personnelid)));
                //debug($clients);die;
                $abc = '0';
                foreach ($clients as $cl) {
                    if ($cl['Client']['id'] != '') {
                        $abc = $abc . ',' . $cl['Client']['id'];
                    }
                }
                $condb10 = 'Bonlivraison.client_id in (' . $abc . ')';
                $condf10 = 'Factureclient.client_id in (' . $abc . ')';
                $conda10 = 'Factureavoir.client_id in (' . $abc . ')';
                $personnel = '/0/';
                foreach ($clients as $cl) {
                    if ($cl['Client']['id'] != '') {
                        $personnel = $personnel . ',/' . $cl['Client']['id'] . '/';
                    }
                }
                $personnel = $personnel;
            }
            if ($this->request->data['Recherche']['factureclient_id']) {
                $factureclientid = $this->request->data['Recherche']['factureclient_id'];
                $condf11 = 'Factureclient.id =' . $factureclientid;
            }
            
        }
        $bonlivraisonparprixs = $this->Lignelivraison->find('all', array(
            'fields' => array('SUM(Lignelivraison.prix*Lignelivraison.quantite) prix', 'SUM(Lignelivraison.prixachatmarge*Lignelivraison.quantite) pmp', 'sum(Lignelivraison.totalht) as total', 'Article.name', 'Article.id', 'sum(Lignelivraison.quantite) as quantite', 'sum(Lignelivraison.totalttc) as totalttc')
            , 'conditions' => array(@$pvb, @$condb1, @$condb2, @$condb4, @$condb5, @$condb6, @$condb7, @$condb8, @$condb9, @$condFsseur, @$condb10, @$condb12)
            , 'group' => array('Lignelivraison.article_id')
            , 'contain' => array('Bonlivraison', 'Article'), 'recursive' => 2));



        $bonlivraisonpartotales = $this->Lignelivraison->find('all', array('fields' => array('sum(Lignelivraison.totalht) as total')
            , 'conditions' => array(@$condb4)));

        $bonlivraisonpartotalesTTC = $this->Lignelivraison->find('all', array('fields' => array('sum(Lignelivraison.totalttc) as total')
            , 'conditions' => array(@$condb4)));


        $factureclientparprixs = $this->Lignefactureclient->find('all', array(
            'fields' => array('SUM(Lignefactureclient.prix*Lignefactureclient.quantite) prix', 'SUM(Lignefactureclient.prixachatmarge*Lignefactureclient.quantite) pmp', 'sum(Lignefactureclient.totalht) as total', 'Article.name', 'Article.id', 'sum(Lignefactureclient.quantite) as quantite', 'sum(Lignefactureclient.totalttc) as totalttc')
            , 'conditions' => array('Factureclient.source="fac"', @$pvf, @$condf1, @$condf2, @$condf4, @$condf5, @$condf6, @$condf7, @$condf8, @$condf9, @$condFsseur, @$condf10, @$condf11, @$condf12)
            , 'group' => array('Lignefactureclient.article_id')
            , 'contain' => array('Factureclient', 'Article'), 'recursive' => 2));

        $factureclientpartotales = $this->Lignefactureclient->find('all', array('fields' => array('sum(Lignefactureclient.totalht) as total'), 'conditions' => array(@$condf4, 'Factureclient.source="fac"')));

        $factureclientpartotalesTTC = $this->Lignefactureclient->find('all', array('fields' => array('sum(Lignefactureclient.totalttc) as total')
            , 'conditions' => array(@$condf4, 'Factureclient.source="fac"')));




        $factureavoirparprixs = $this->Lignefactureavoir->find('all', array(
            'fields' => array('SUM(Lignefactureavoir.prix*Lignefactureavoir.quantite) prix', 'SUM(Lignefactureavoir.prixachatmarge*Lignefactureavoir.quantite) pmp', 'sum(Lignefactureavoir.totalht) as total', 'Article.name', 'Article.id', 'sum(Lignefactureavoir.quantite) as quantite', 'sum(Lignefactureavoir.totalttc) as totalttc')
            , 'conditions' => array(@$pva, @$conda1, @$conda2, @$conda4, @$conda5, @$conda6, @$conda7, @$conda8, @$conda9, @$condFsseur, @$conda10, @$conda12)
            , 'group' => array('Lignefactureavoir.article_id')
            , 'contain' => array('Factureavoir', 'Article'), 'recursive' => 2));

        $factureavoirpartotales = $this->Lignefactureavoir->find('all', array('fields' => array('sum(Lignefactureavoir.totalht) as total'), 'conditions' => array(@$conda4)));

        $factureavoirpartotalesTTC = $this->Lignefactureavoir->find('all', array('fields' => array('sum(Lignefactureavoir.totalttc) as total')
            , 'conditions' => array(@$conda4)));

        $totaleBLF = $bonlivraisonpartotales[0][0]['total'] + $factureclientpartotales[0][0]['total'] - $factureavoirpartotales[0][0]['total'];
        $totaleBLFTTC = $bonlivraisonpartotalesTTC[0][0]['total'] + $factureclientpartotalesTTC[0][0]['total'] - $factureavoirpartotalesTTC[0][0]['total'];

        

        if (empty($factureclientid)) {
            $tab = array();
            $i = 0;
            foreach ($bonlivraisonparprixs as $bonlivraison) {
                $tab[$i]['articleid'] = $bonlivraison['Article']['id'];
                $tab[$i]['article'] = $bonlivraison['Article']['name'];
                $tab[$i]['qte'] = $bonlivraison[0]['quantite'];

                if ($bonlivraison[0]['quantite'] == 0)
                    $bonlivraison[0]['quantite'] = 1;
                $tab[$i]['prix'] = $bonlivraison[0]['prix'] / $bonlivraison[0]['quantite'];
                $tab[$i]['pmp'] = $bonlivraison[0]['pmp'] / $bonlivraison[0]['quantite'];
                $tab[$i]['pmptot'] = $bonlivraison[0]['pmp'];

                $tab[$i]['tot'] = $bonlivraison[0]['total'];
                $tab[$i]['totalttc'] = $bonlivraison[0]['totalttc'];
                $tab[$i]['por'] = round(($bonlivraison[0]['total'] / $totaleBLF) * 100, 3);
                $this->Tabetatarticle->create();
                $this->Tabetatarticle->save($tab[$i]);
                $i++;
            }
        }
        $tab = array();
        $index = 0;
        foreach ($factureclientparprixs as $facture) {  //debug($facture);
            $tab[$index]['articleid'] = $facture['Article']['id'];
            $tab[$index]['article'] = $facture['Article']['name'];
            $tab[$index]['qte'] = $facture[0]['quantite'];

            if ($facture[0]['quantite'] == 0)
                $facture[0]['quantite'] = 1;
            $tab[$index]['prix'] = $facture[0]['prix'] / $facture[0]['quantite'];
            $tab[$index]['pmp'] = $facture[0]['pmp'] / $facture[0]['quantite'];
            $tab[$index]['pmptot'] = $facture[0]['pmp'];

            $tab[$index]['tot'] = $facture[0]['total'];
            $tab[$index]['totalttc'] = $facture[0]['totalttc'];
            $tab[$index]['por'] = round(($facture[0]['total'] / $totaleBLF) * 100, 3);
            // debug($tab[$index]);
            $this->Tabetatarticle->create();
            $this->Tabetatarticle->save($tab[$index]);
            $index++;
        } //die;
        if (empty($factureclientid)) {
            if (!empty($factureavoirparprixs)) {
                $tab = array();
                $index = 0;
                foreach ($factureavoirparprixs as $facture) {
                    $tab[$index]['articleid'] = $facture['Article']['id'];
                    $tab[$index]['article'] = $facture['Article']['name'];
                    $tab[$index]['qte'] = 0 - $facture[0]['quantite'];

                    if ($facture[0]['quantite'] == 0)
                        $facture[0]['quantite'] = 1;
                    $tab[$index]['prix'] = $facture[0]['prix'] / $facture[0]['quantite'];
                    $tab[$index]['pmp'] = $facture[0]['pmp'] / $facture[0]['quantite'];
                    $tab[$index]['pmptot'] = 0 - $facture[0]['pmp'];

                    $tab[$index]['tot'] = 0 - $facture[0]['total'];
                    $tab[$index]['totalttc'] = 0 - $facture[0]['totalttc'];
                    $tab[$index]['por'] = round(($facture[0]['total'] / $totaleBLF) * 100, 3);
                    $this->Tabetatarticle->create();
                    $this->Tabetatarticle->save($tab[$index]);
                    $index++;
                }
            }
        }



        $tab = $this->Tabetatarticle->find('all', array(
            'fields' => array('SUM(Tabetatarticle.prix*Tabetatarticle.qte) prix', 'SUM(Tabetatarticle.pmp*Tabetatarticle.qte) pmp', 'sum(Tabetatarticle.pmptot) as pmptot', 'sum(Tabetatarticle.tot) as tot', 'sum(Tabetatarticle.totalttc) as ttc', 'articleid', 'article', 'sum(Tabetatarticle.qte) as qte')
            , 'group' => array('Tabetatarticle.articleid')
            , 'order' => array('sum(Tabetatarticle.tot)' => 'desc')
            , 'recursive' => 2));
        //debug($tab);die;
        $familles = $this->Famille->find('list');
        //$articles = $this->Article->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Factureclient->Client->find('list', array(
            'conditions' => array('Client.etat' => 1, 'Client.societe' => $composantsoc)));
        //$factureclients = $this->Factureclient->find('list', array('fields' => array('Factureclient.id', 'Factureclient.numero')));
        $personnels = $this->Personnel->find('list');
        $fournisseurs = $this->Fournisseur->find('list', array(
            'conditions' => array('Fournisseur.societe' => $composantsoc)));
        //$tags = $this->Tag->find('list');
        //$categoriearticles = $this->Categoriearticle->find('list');
        $this->set(compact('categoriearticleid','factureclientid','personnelid','fournisseurid','clientid','tagid','categoriearticleid', 'categoriearticles', 'fournisseurs', 'factureclients', 'personnels', 'totaleBLFTTC', 'tagid', 'tags', 'familleid', 'pointdeventeid', 'articleid', 'familles', 'totaleBLF', 'articles', 'tab', 'bonlivraisons', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clients', 'factureclients'));
    }

    public function imprimerrecherchem() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'etatarticles') {
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
        $this->loadModel('Tabetatarticle');
        $this->loadModel('Tag');
        $this->loadModel('Articletag');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Fournisseur');
        $this->loadModel('Articlefournisseur');

        $this->Tabetatarticle->query('TRUNCATE tabetatarticles;');

        $pointdeventes = $this->Pointdevente->find('list');
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

        //debug($this->request->data);die;
        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $condb4 = 'Bonlivraison.exercice_id =' . $exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
            $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];
        }
        if ($this->request->query['date1']) {
            $date1 = $this->request->query['date1'];
            $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
            $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }
        if ($this->request->query['date2']) {
            $date2 = $this->request->query['date2'];
            $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
            $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }
        if ($this->request->query['articleid']) {
            $articleid = $this->request->query['articleid'];
            $condb6 = 'Lignelivraison.article_id =' . $articleid;
            $condf6 = 'Lignefactureclient.article_id =' . $articleid;
            $conda6 = 'Lignefactureavoir.article_id =' . $articleid;
        }
        if (!empty($this->request->query['pointdeventeid'])) {
            $pointdeventeid = $this->request->query['pointdeventeid'];
            $condb5 = 'Bonlivraison.pointdevente_id =' . $pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
            $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
        }
        if ($this->request->query['familleid']) {
            $familleid = $this->request->query['familleid'];
            $condb7 = 'Article.famille_id =' . $familleid;
            $condf7 = 'Article.famille_id =' . $familleid;
            $conda7 = 'Article.famille_id =' . $familleid;
        }
        if ($this->request->query['tagid']) {
            $tagid = $this->request->query['tagid'];
            $articles = $this->Articletag->find('all', array('recursive' => -1, 'conditions' => array('Articletag.tag_id' => $tagid)));
            $t = '(0';
            foreach ($articles as $ad) {
                $t = $t . ',' . $ad['Articletag']['article_id'];
            }
            $t = $t . ')';
            $condb8 = 'Lignelivraison.article_id  in' . $t;
            $condf8 = 'Lignefactureclient.article_id in' . $t;
            $conda8 = 'Lignefactureavoir.article_id in' . $t;
        }
        if ($this->request->query['client_id']) {
            $clientid = $this->request->query['client_id'];
            $condb9 = 'Bonlivraison.client_id =' . $clientid;
            $condf9 = 'Factureclient.client_id =' . $clientid;
            $conda9 = 'Factureavoir.client_id =' . $clientid;
        }
        if (!empty($this->request->query['fournisseur_id'])) {
            $fournisseurid = $this->request->query['fournisseur_id'];
            $fournisseur = $this->Fournisseur->find('first', array('recursive' => -1, 'conditions' => array('Fournisseur.id' => $fournisseurid)));
//            debug($fournisseur);die;
            $devise_frs = $fournisseur['Fournisseur']['devise_id'];
            $id_frs = $fournisseur['Fournisseur']['id'];
            $arts = $this->Articlefournisseur->find('all', array('recursive' => -1, 'conditions' => array('Articlefournisseur.fournisseur_id' => $fournisseurid)));
            //debug($arts);die;
            $artf = '0';
            if(!empty($arts)){
                foreach ($arts as $k => $art) {
                if ($art['Articlefournisseur']['article_id'] != '') {
                    $artf = $artf . ',' . $art['Articlefournisseur']['article_id'];
                }
            }
            }
            

            $condFsseur = 'Article.id in (' . $artf . ')';
            // debug($artf);die;
            $founisseur = '/0/';
            foreach ($arts as $k => $art) {
                if ($art['Articlefournisseur']['article_id'] != '') {
                    $founisseur = $founisseur . ',/' . $art['Articlefournisseur']['article_id'] . '/';
                }
            }
            $founisseur = $founisseur;
        }
        if (!empty($this->request->query['personnel_id'])) {
            $personnelid = $this->request->query['personnel_id'];
            $clients = $this->Client->find('all', array('recursive' => -1, 'conditions' => array('Client.personnel_id' => $personnelid)));
            //debug($clients);die;
            $abc = '0';
            foreach ($clients as $cl) {
                if ($cl['Client']['id'] != '') {
                    $abc = $abc . ',' . $cl['Client']['id'];
                }
            }
            $condb10 = 'Bonlivraison.client_id in (' . $abc . ')';
            $condf10 = 'Factureclient.client_id in (' . $abc . ')';
            $conda10 = 'Factureavoir.client_id in (' . $abc . ')';
            $personnel = '/0/';
            foreach ($clients as $cl) {
                if ($cl['Client']['id'] != '') {
                    $personnel = $personnel . ',/' . $cl['Client']['id'] . '/';
                }
            }
            $personnel = $personnel;
        }
        
        $bonlivraisonparprixs = $this->Lignelivraison->find('all', array(
            'fields' => array('SUM(Lignelivraison.prix*Lignelivraison.quantite) prix', 'SUM(Lignelivraison.pmp*Lignelivraison.quantite) pmp', 'sum(Lignelivraison.totalht) as total', 'Article.name', 'Article.id', 'sum(Lignelivraison.quantite) as quantite', 'sum(Lignelivraison.totalttc) as totalttc')
            , 'conditions' => array(@$pvb, @$condb1, @$condb2, @$condb4, @$condb5, @$condb6, @$condb7, @$condb8, @$condb9, @$condFsseur, @$condb10, @$condb12)
            , 'group' => array('Lignelivraison.article_id')
            , 'contain' => array('Bonlivraison', 'Article'), 'recursive' => 2));



        $bonlivraisonpartotales = $this->Lignelivraison->find('all', array('fields' => array('sum(Lignelivraison.totalht) as total')
            , 'conditions' => array(@$condb4)));

        $bonlivraisonpartotalesTTC = $this->Lignelivraison->find('all', array('fields' => array('sum(Lignelivraison.totalttc) as total')
            , 'conditions' => array(@$condb4)));


        $factureclientparprixs = $this->Lignefactureclient->find('all', array(
            'fields' => array('SUM(Lignefactureclient.prix*Lignefactureclient.quantite) prix', 'SUM(Lignefactureclient.pmp*Lignefactureclient.quantite) pmp', 'sum(Lignefactureclient.totalht) as total', 'Article.name', 'Article.id', 'sum(Lignefactureclient.quantite) as quantite', 'sum(Lignefactureclient.totalttc) as totalttc')
            , 'conditions' => array('Factureclient.source="fac"', @$pvf, @$condf1, @$condf2, @$condf4, @$condf5, @$condf6, @$condf7, @$condf8, @$condf9, @$condFsseur, @$condf10, @$condf11, @$condf12)
            , 'group' => array('Lignefactureclient.article_id')
            , 'contain' => array('Factureclient', 'Article'), 'recursive' => 2));

        $factureclientpartotales = $this->Lignefactureclient->find('all', array('fields' => array('sum(Lignefactureclient.totalht) as total'), 'conditions' => array(@$condf4, 'Factureclient.source="fac"')));

        $factureclientpartotalesTTC = $this->Lignefactureclient->find('all', array('fields' => array('sum(Lignefactureclient.totalttc) as total')
            , 'conditions' => array(@$condf4, 'Factureclient.source="fac"')));




        $factureavoirparprixs = $this->Lignefactureavoir->find('all', array(
            'fields' => array('SUM(Lignefactureavoir.prix*Lignefactureavoir.quantite) prix', 'SUM(Lignefactureavoir.pmp*Lignefactureavoir.quantite) pmp', 'sum(Lignefactureavoir.totalht) as total', 'Article.name', 'Article.id', 'sum(Lignefactureavoir.quantite) as quantite', 'sum(Lignefactureavoir.totalttc) as totalttc')
            , 'conditions' => array(@$pva, @$conda1, @$conda2, @$conda4, @$conda5, @$conda6, @$conda7, @$conda8, @$conda9, @$condFsseur, @$conda10, @$conda12)
            , 'group' => array('Lignefactureavoir.article_id')
            , 'contain' => array('Factureavoir', 'Article'), 'recursive' => 2));

        $factureavoirpartotales = $this->Lignefactureavoir->find('all', array('fields' => array('sum(Lignefactureavoir.totalht) as total'), 'conditions' => array(@$conda4)));

        $factureavoirpartotalesTTC = $this->Lignefactureavoir->find('all', array('fields' => array('sum(Lignefactureavoir.totalttc) as total')
            , 'conditions' => array(@$conda4)));

        $totaleBLF = $bonlivraisonpartotales[0][0]['total'] + $factureclientpartotales[0][0]['total'] - $factureavoirpartotales[0][0]['total'];
        $totaleBLFTTC = $bonlivraisonpartotalesTTC[0][0]['total'] + $factureclientpartotalesTTC[0][0]['total'] - $factureavoirpartotalesTTC[0][0]['total'];
      if (empty($factureclientid)) {
            $tab = array();
            $i = 0;
            foreach ($bonlivraisonparprixs as $bonlivraison) {
                $tab[$i]['articleid'] = $bonlivraison['Article']['id'];
                $tab[$i]['article'] = $bonlivraison['Article']['name'];
                $tab[$i]['qte'] = $bonlivraison[0]['quantite'];

                if ($bonlivraison[0]['quantite'] == 0)
                    $bonlivraison[0]['quantite'] = 1;
                $tab[$i]['prix'] = $bonlivraison[0]['prix'] / $bonlivraison[0]['quantite'];
                $tab[$i]['pmp'] = $bonlivraison[0]['pmp'] / $bonlivraison[0]['quantite'];
                $tab[$i]['pmptot'] = $bonlivraison[0]['pmp'];

                $tab[$i]['tot'] = $bonlivraison[0]['total'];
                $tab[$i]['totalttc'] = $bonlivraison[0]['totalttc'];
                $tab[$i]['por'] = round(($bonlivraison[0]['total'] / $totaleBLF) * 100, 3);
                $this->Tabetatarticle->create();
                $this->Tabetatarticle->save($tab[$i]);
                $i++;
            }
        }
        $tab = array();
        $index = 0;
        foreach ($factureclientparprixs as $facture) {  //debug($facture);
            $tab[$index]['articleid'] = $facture['Article']['id'];
            $tab[$index]['article'] = $facture['Article']['name'];
            $tab[$index]['qte'] = $facture[0]['quantite'];

            if ($facture[0]['quantite'] == 0)
                $facture[0]['quantite'] = 1;
            $tab[$index]['prix'] = $facture[0]['prix'] / $facture[0]['quantite'];
            $tab[$index]['pmp'] = $facture[0]['pmp'] / $facture[0]['quantite'];
            $tab[$index]['pmptot'] = $facture[0]['pmp'];

            $tab[$index]['tot'] = $facture[0]['total'];
            $tab[$index]['totalttc'] = $facture[0]['totalttc'];
            $tab[$index]['por'] = round(($facture[0]['total'] / $totaleBLF) * 100, 3);
            // debug($tab[$index]);
            $this->Tabetatarticle->create();
            $this->Tabetatarticle->save($tab[$index]);
            $index++;
        } //die;
        if (empty($factureclientid)) {
            if (!empty($factureavoirparprixs)) {
                $tab = array();
                $index = 0;
                foreach ($factureavoirparprixs as $facture) {
                    $tab[$index]['articleid'] = $facture['Article']['id'];
                    $tab[$index]['article'] = $facture['Article']['name'];
                    $tab[$index]['qte'] = 0 - $facture[0]['quantite'];

                    if ($facture[0]['quantite'] == 0)
                        $facture[0]['quantite'] = 1;
                    $tab[$index]['prix'] = $facture[0]['prix'] / $facture[0]['quantite'];
                    $tab[$index]['pmp'] = $facture[0]['pmp'] / $facture[0]['quantite'];
                    $tab[$index]['pmptot'] = 0 - $facture[0]['pmp'];

                    $tab[$index]['tot'] = 0 - $facture[0]['total'];
                    $tab[$index]['totalttc'] = 0 - $facture[0]['totalttc'];
                    $tab[$index]['por'] = round(($facture[0]['total'] / $totaleBLF) * 100, 3);
                    $this->Tabetatarticle->create();
                    $this->Tabetatarticle->save($tab[$index]);
                    $index++;
                }
            }
        }


        $tab = $this->Tabetatarticle->find('all', array(
            'fields' => array('SUM(Tabetatarticle.prix*Tabetatarticle.qte) prix', 'SUM(Tabetatarticle.pmp*Tabetatarticle.qte) pmp', 'sum(Tabetatarticle.pmptot) as pmptot', 'sum(Tabetatarticle.tot) as tot', 'sum(Tabetatarticle.totalttc) as ttc', 'articleid', 'article', 'sum(Tabetatarticle.qte) as qte')
            , 'group' => array('Tabetatarticle.articleid')
            , 'order' => array('sum(Tabetatarticle.tot)' => 'desc')
            , 'recursive' => 2));
        //debug($tab);die;


//        $familles = $this->Famille->find('list');
//        $articles = $this->Article->find('list');
//        $clients = $this->Client->find('list');
//        $tags = $this->Tag->find('list');
        $this->set(compact('tagid', 'tags', 'familleid', 'pointdeventeid', 'articleid', 'familles', 'totaleBLF', 'tab', 'bonlivraisons', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clients', 'factureclients'));
    }

    public function etatmargeclient() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'etatclients') {
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
        $this->loadModel('Tabetatclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Personnel');
        //$this->loadModel('Fournisseur');

        $this->Tabetatclient->query('TRUNCATE tabetatclients;');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Factureclient->Client->find('list', array(
            'conditions' => array('Client.etat' => 1, 'Client.societe' => $composantsoc)));

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
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____") {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
                $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
                $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
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
            if (!empty($this->request->data['Recherche']['personnel_id'])) {
                $personnelid = $this->request->data['Recherche']['personnel_id'];
                $clients = $this->Client->find('all', array('recursive' => -1, 'conditions' => array('Client.personnel_id' => $personnelid)));
                //debug($clients);die;
                $abc = '0';
                foreach ($clients as $cl) {
                    $abc = $abc . ',' . $cl['Client']['id'];
                }
                $condb9 = 'Bonlivraison.client_id in (' . $abc . ')';
                $condf9 = 'Factureclient.client_id in (' . $abc . ')';
                $conda9 = 'Factureavoir.client_id in (' . $abc . ')';
            }
            
        }


        $bonlivraisonparprixs = $this->Lignelivraison->find('all', array('fields' => array('SUM(Lignelivraison.pmp*Lignelivraison.quantite) pmp', 'sum(Lignelivraison.totalht) as total', 'sum(Bonlivraison.totalttc) as totalttc', 'Bonlivraison.client_id')
            , 'conditions' => array('Bonlivraison.id > ' => 0, @$pvb, @$condb1, @$condb2, @$condb3, @$condb4, @$condb5, @$condb9)
            , 'group' => array('Bonlivraison.client_id')));


        $bonlivraisonpartotales = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalht) as total')
            , 'conditions' => array(@$condb4, @$condb1, @$condb2,)));

        $bonlivraisonpartotalesTTC = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalttc) as total')
            , 'conditions' => array(@$condb4, @$condb1, @$condb2,)));



        $factureclientparprixs = $this->Lignefactureclient->find('all', array('fields' => array('SUM(Lignefactureclient.pmp*Lignefactureclient.quantite) pmp', 'sum(Lignefactureclient.totalht) as total', 'sum(Factureclient.totalttc) as totalttc', 'Factureclient.client_id')
            , 'conditions' => array('Factureclient.source="fac"', @$pvf, @$condf1, @$condf2, @$condf3, @$condf4, @$condf5, @$condf9, @$condf11)
            , 'group' => array('Factureclient.client_id')));

        $factureclientpartotales = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalht) as total')
            , 'conditions' => array('Factureclient.source="fac"', @$condf4, @$condf1, @$condf2)));

        $factureclientpartotalesTTC = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalttc) as total')
            , 'conditions' => array('Factureclient.source="fac"', @$condf4, @$condf1, @$condf2)));




        $factureavoirparprixs = $this->Lignefactureavoir->find('all', array('fields' => array('SUM(Lignefactureavoir.pmp*Lignefactureavoir.quantite) pmp', 'sum(Lignefactureavoir.totalht) as total', 'sum(Factureavoir.totalttc) as totalttc', 'Factureavoir.client_id')
            , 'conditions' => array(@$pva, @$conda1, @$conda2, @$conda3, @$conda4, @$conda5, @$conda9)
            , 'group' => array('Factureavoir.client_id')));


        $totaleBLF = @$bonlivraisonpartotales[0][0]['total'] + @$factureclientpartotales[0][0]['total'] - @$factureavoirpartotales[0][0]['total'];

        $totaleBLFTTC = @$bonlivraisonpartotalesTTC[0][0]['total'] + @$factureclientpartotalesTTC[0][0]['total'] - @$factureavoirpartotalesTTC[0][0]['total'];

        $tab = array();
        $i = 0;
        //debug($bonlivraisonparprixs);
        //debug($factureclientparprixs);die;
        foreach ($factureclientparprixs as $facture) {
            $nameclient = $this->Client->find('first', array('recursive' => -1, 'conditions' => array('Client.id' => $facture['Factureclient']['client_id'])));
            $tab[$i]['clientid'] = $facture['Factureclient']['client_id'];
            $tab[$i]['name'] = $nameclient['Client']['name'];
            $tab[$i]['tot'] = $facture[0]['total'];
            $tab[$i]['totalttc'] = $facture[0]['totalttc'];
            $tab[$i]['pmp'] = $facture[0]['pmp'];
            $tab[$i]['por'] = round(($facture[0]['total'] / $totaleBLF) * 100, 3);
            $this->Tabetatclient->create();
            $this->Tabetatclient->save($tab[$i]);
            $i++;
        }
        if (empty($factureclientid)) {
            $tab = array();
            $index = 0;
            foreach ($bonlivraisonparprixs as $bonlivraison) {
                $nameclient = $this->Client->find('first', array('recursive' => -1, 'conditions' => array('Client.id' => $bonlivraison['Bonlivraison']['client_id'])));
                $tab[$index]['clientid'] = $bonlivraison['Bonlivraison']['client_id'];
                $tab[$index]['name'] = $nameclient['Client']['name'];
                $tab[$index]['tot'] = $bonlivraison[0]['total'];
                $tab[$index]['totalttc'] = $bonlivraison[0]['totalttc'];
                $tab[$index]['pmp'] = $bonlivraison[0]['pmp'];
                $tab[$index]['por'] = round(($bonlivraison[0]['total'] / $totaleBLF) * 100, 3);
                $this->Tabetatclient->create();
                $this->Tabetatclient->save($tab[$index]);
                $index++;
            }
        }
        if (empty($factureclientid)) {
            if (!empty($factureavoirparprixs)) {
                $tab = array();
                $index = 0;
                foreach ($factureavoirparprixs as $bonlivraison) {
                    $nameclient = $this->Client->find('first', array('recursive' => -1, 'conditions' => array('Client.id' => $bonlivraison['Factureavoir']['client_id'])));
                    $tab[$index]['clientid'] = $bonlivraison['Factureavoir']['client_id'];
                    $tab[$index]['name'] = $nameclient['Client']['name'];
                    $tab[$index]['tot'] = 0 - $bonlivraison[0]['total'];
                    $tab[$index]['pmp'] = 0 - $bonlivraison[0]['pmp'];
                    $tab[$index]['por'] = round(($bonlivraison[0]['total'] / $totaleBLF) * 100, 3);
                    $this->Tabetatclient->create();
                    $this->Tabetatclient->save($tab[$index]);
                    $index++;
                }
            }
        }

        //debug($tab);die;

        $tab = $this->Tabetatclient->find('all', array(
            'fields' => array('sum(Tabetatclient.pmp) as pmp', 'sum(Tabetatclient.tot) as tot', 'sum(Tabetatclient.totalttc) as ttc', 'clientid', 'name', 'article', 'sum(Tabetatclient.qte) as qte')
            , 'group' => array('Tabetatclient.clientid')
            , 'order' => array('sum(Tabetatclient.tot)' => 'desc')
            , 'recursive' => 2));

        //debug($tab);die;
        $personnels = $this->Personnel->find('list');
        //$factureclients = $this->Factureclient->find('list', array('fields' => array('Factureclient.id', 'Factureclient.numero')));
        //$fournisseurs = $this->Fournisseur->find('list');
        $this->set(compact('fournisseurs', 'personnels', 'totaleBLFTTC', 'pointdeventeid', 'totaleBLF', 'tab', 'bonlivraisons', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'factureclients'));
    }

    public function imprimerrecherchec() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'etatarticles') {
                    $x = $liens['imprimer'];
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
        $this->loadModel('Tabetatclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Personnel');
        $this->loadModel('Fournisseur');

        $this->Tabetatclient->query('TRUNCATE tabetatclients;');
        //$clients = $this->Client->find('list');

        $pointdeventes = $this->Pointdevente->find('list');
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
            $condb5 = 'Bonlivraison.pointdevente_id = ' . $p;
            $condf5 = 'Factureclient.pointdevente_id = ' . $p;
            $conda5 = 'Factureavoir.pointdevente_id = ' . $p;
        }

        //debug($this->request->data);die;
        if ($this->request->query['date1']) {
            $date1 = $this->request->query['date1'];
            $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
            $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }

        if ($this->request->query['date2']) {
            $date2 = $this->request->query['date2'];
            $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
            $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }


        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $condb4 = 'Bonlivraison.exercice_id =' . $exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
            $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];
        }
        if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            $condb3 = 'Bonlivraison.client_id =' . $clientid;
            $condf3 = 'Factureclient.client_id =' . $clientid;
            $conda3 = 'Factureavoir.client_id =' . $clientid;
        }


        if (!empty($this->request->query['pointdeventeid'])) {
            $pointdeventeid = $this->request->query['pointdeventeid'];
            $condb5 = 'Bonlivraison.pointdevente_id =' . $pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
            $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
        }

        $bonlivraisonparprixs = $this->Lignelivraison->find('all', array('fields' => array('SUM(Lignelivraison.pmp*Lignelivraison.quantite) pmp', 'sum(Lignelivraison.totalht) as total', 'sum(Bonlivraison.totalttc) as totalttc', 'Bonlivraison.client_id')
            , 'conditions' => array('Bonlivraison.id > ' => 0, @$pvb, @$condb1, @$condb2, @$condb3, @$condb4, @$condb5, @$condb9)
            , 'group' => array('Bonlivraison.client_id')));


        $bonlivraisonpartotales = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalht) as total')
            , 'conditions' => array(@$condb4, @$condb1, @$condb2,)));

        $bonlivraisonpartotalesTTC = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalttc) as total')
            , 'conditions' => array(@$condb4, @$condb1, @$condb2,)));



        $factureclientparprixs = $this->Lignefactureclient->find('all', array('fields' => array('SUM(Lignefactureclient.pmp*Lignefactureclient.quantite) pmp', 'sum(Lignefactureclient.totalht) as total', 'sum(Factureclient.totalttc) as totalttc', 'Factureclient.client_id')
            , 'conditions' => array('Factureclient.source="fac"', @$pvf, @$condf1, @$condf2, @$condf3, @$condf4, @$condf5, @$condf9)
            , 'group' => array('Factureclient.client_id')));

        $factureclientpartotales = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalht) as total')
            , 'conditions' => array('Factureclient.source="fac"', @$condf4, @$condf1, @$condf2)));

        $factureclientpartotalesTTC = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalttc) as total')
            , 'conditions' => array('Factureclient.source="fac"', @$condf4, @$condf1, @$condf2)));




        $factureavoirparprixs = $this->Lignefactureavoir->find('all', array('fields' => array('SUM(Lignefactureavoir.pmp*Lignefactureavoir.quantite) pmp', 'sum(Lignefactureavoir.totalht) as total', 'sum(Factureavoir.totalttc) as totalttc', 'Factureavoir.client_id')
            , 'conditions' => array(@$pva, @$conda1, @$conda2, @$conda3, @$conda4, @$conda5, @$conda9)
            , 'group' => array('Factureavoir.client_id')));


        $totaleBLF = @$bonlivraisonpartotales[0][0]['total'] + @$factureclientpartotales[0][0]['total'] - @$factureavoirpartotales[0][0]['total'];

        $totaleBLFTTC = @$bonlivraisonpartotalesTTC[0][0]['total'] + @$factureclientpartotalesTTC[0][0]['total'] - @$factureavoirpartotalesTTC[0][0]['total'];

        $tab = array();
        $i = 0;
        //debug($bonlivraisonparprixs);
        //debug($factureclientparprixs);die;
        foreach ($factureclientparprixs as $facture) {
            $tab[$i]['clientid'] = $facture['Factureclient']['client_id'];
            $tab[$i]['name'] = $clients[$facture['Factureclient']['client_id']];
            $tab[$i]['tot'] = $facture[0]['total'];
            $tab[$i]['totalttc'] = $facture[0]['totalttc'];
            $tab[$i]['pmp'] = $facture[0]['pmp'];
            $tab[$i]['por'] = round(($facture[0]['total'] / $totaleBLF) * 100, 3);
            $this->Tabetatclient->create();
            $this->Tabetatclient->save($tab[$i]);
            $i++;
        }

        $tab = array();
        $index = 0;
        foreach ($bonlivraisonparprixs as $bonlivraison) {
            $tab[$index]['clientid'] = $bonlivraison['Bonlivraison']['client_id'];
            $tab[$index]['name'] = $clients[$bonlivraison['Bonlivraison']['client_id']];
            $tab[$index]['tot'] = $bonlivraison[0]['total'];
            $tab[$index]['totalttc'] = $bonlivraison[0]['totalttc'];
            $tab[$index]['pmp'] = $bonlivraison[0]['pmp'];
            $tab[$index]['por'] = round(($bonlivraison[0]['total'] / $totaleBLF) * 100, 3);
            $this->Tabetatclient->create();
            $this->Tabetatclient->save($tab[$index]);
            $index++;
        }

        if (!empty($factureavoirparprixs)) {
            $tab = array();
            $index = 0;
            foreach ($factureavoirparprixs as $bonlivraison) {
                $tab[$index]['clientid'] = $bonlivraison['Factureavoir']['client_id'];
                $tab[$index]['name'] = $clients[$bonlivraison['Factureavoir']['client_id']];
                $tab[$index]['tot'] = 0 - $bonlivraison[0]['total'];
                $tab[$index]['pmp'] = 0 - $bonlivraison[0]['pmp'];
                $tab[$index]['por'] = round(($bonlivraison[0]['total'] / $totaleBLF) * 100, 3);
                $this->Tabetatclient->create();
                $this->Tabetatclient->save($tab[$index]);
                $index++;
            }
        }

        //debug($tab);die;

        $tab = $this->Tabetatclient->find('all', array(
            'fields' => array('sum(Tabetatclient.pmp) as pmp', 'sum(Tabetatclient.tot) as tot', 'sum(Tabetatclient.totalttc) as ttc', 'clientid', 'name', 'article', 'sum(Tabetatclient.qte) as qte')
            , 'group' => array('Tabetatclient.clientid')
            , 'order' => array('sum(Tabetatclient.tot)' => 'desc')
            , 'recursive' => 2));

        debug($tab);die;
        $personnels = $this->Personnel->find('list');
        $this->set(compact('personnels', 'totaleBLFTTC', 'pointdeventeid', 'totaleBLF', 'tab', 'bonlivraisons', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'factureclients'));
    }
    
    
    public function etatmarge_mois() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'etatclients') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Moi');

        
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
            }

            if ($this->request->data['Recherche']['date2'] != "__/__/____") {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
                $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
                $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            }

            

            if (!empty($this->request->data['Recherche']['pointdevente_id'])) {
                $pointdeventeid = $this->request->data['Recherche']['pointdevente_id'];
                $condb5 = 'Bonlivraison.pointdevente_id =' . $pointdeventeid;
                $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
                $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
            }
            
            
        }
        $mois = $this->Moi->find('list');

        
        
        $this->set(compact());
    }

    public function imprimer_mois() {
        $lien = CakeSession::read('lien_stat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'etatarticles') {
                    $x = $liens['imprimer'];
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
        $this->loadModel('Tabetatclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Personnel');
        $this->loadModel('Fournisseur');

        $this->Tabetatclient->query('TRUNCATE tabetatclients;');
        //$clients = $this->Client->find('list');

        $pointdeventes = $this->Pointdevente->find('list');
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
            $condb5 = 'Bonlivraison.pointdevente_id = ' . $p;
            $condf5 = 'Factureclient.pointdevente_id = ' . $p;
            $conda5 = 'Factureavoir.pointdevente_id = ' . $p;
        }

        //debug($this->request->data);die;
        if ($this->request->query['date1']) {
            $date1 = $this->request->query['date1'];
            $condb1 = 'Bonlivraison.date >= ' . "'" . $date1 . "'";
            $condf1 = 'Factureclient.date >= ' . "'" . $date1 . "'";
            $conda1 = 'Factureavoir.date >= ' . "'" . $date1 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }

        if ($this->request->query['date2']) {
            $date2 = $this->request->query['date2'];
            $condb2 = 'Bonlivraison.date <= ' . "'" . $date2 . "'";
            $condf2 = 'Factureclient.date <= ' . "'" . $date2 . "'";
            $conda2 = 'Factureavoir.date <= ' . "'" . $date2 . "'";
            $condf4 = "";
            $condb4 = "";
            $conda4 = "";
        }


        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $condb4 = 'Bonlivraison.exercice_id =' . $exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id =' . $exercices[$exerciceid];
            $conda4 = 'Factureavoir.exercice_id =' . $exercices[$exerciceid];
        }
        if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            $condb3 = 'Bonlivraison.client_id =' . $clientid;
            $condf3 = 'Factureclient.client_id =' . $clientid;
            $conda3 = 'Factureavoir.client_id =' . $clientid;
        }


        if (!empty($this->request->query['pointdeventeid'])) {
            $pointdeventeid = $this->request->query['pointdeventeid'];
            $condb5 = 'Bonlivraison.pointdevente_id =' . $pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id =' . $pointdeventeid;
            $conda5 = 'Factureavoir.pointdevente_id =' . $pointdeventeid;
        }

        $bonlivraisonparprixs = $this->Lignelivraison->find('all', array('fields' => array('SUM(Lignelivraison.pmp*Lignelivraison.quantite) pmp', 'sum(Lignelivraison.totalht) as total', 'sum(Bonlivraison.totalttc) as totalttc', 'Bonlivraison.client_id')
            , 'conditions' => array('Bonlivraison.id > ' => 0, @$pvb, @$condb1, @$condb2, @$condb3, @$condb4, @$condb5, @$condb9)
            , 'group' => array('Bonlivraison.client_id')));


        $bonlivraisonpartotales = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalht) as total')
            , 'conditions' => array(@$condb4, @$condb1, @$condb2,)));

        $bonlivraisonpartotalesTTC = $this->Bonlivraison->find('all', array('fields' => array('sum(Bonlivraison.totalttc) as total')
            , 'conditions' => array(@$condb4, @$condb1, @$condb2,)));



        $factureclientparprixs = $this->Lignefactureclient->find('all', array('fields' => array('SUM(Lignefactureclient.pmp*Lignefactureclient.quantite) pmp', 'sum(Lignefactureclient.totalht) as total', 'sum(Factureclient.totalttc) as totalttc', 'Factureclient.client_id')
            , 'conditions' => array('Factureclient.source="fac"', @$pvf, @$condf1, @$condf2, @$condf3, @$condf4, @$condf5, @$condf9)
            , 'group' => array('Factureclient.client_id')));

        $factureclientpartotales = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalht) as total')
            , 'conditions' => array('Factureclient.source="fac"', @$condf4, @$condf1, @$condf2)));

        $factureclientpartotalesTTC = $this->Factureclient->find('all', array('fields' => array('sum(Factureclient.totalttc) as total')
            , 'conditions' => array('Factureclient.source="fac"', @$condf4, @$condf1, @$condf2)));




        $factureavoirparprixs = $this->Lignefactureavoir->find('all', array('fields' => array('SUM(Lignefactureavoir.pmp*Lignefactureavoir.quantite) pmp', 'sum(Lignefactureavoir.totalht) as total', 'sum(Factureavoir.totalttc) as totalttc', 'Factureavoir.client_id')
            , 'conditions' => array(@$pva, @$conda1, @$conda2, @$conda3, @$conda4, @$conda5, @$conda9)
            , 'group' => array('Factureavoir.client_id')));


        $totaleBLF = @$bonlivraisonpartotales[0][0]['total'] + @$factureclientpartotales[0][0]['total'] - @$factureavoirpartotales[0][0]['total'];

        $totaleBLFTTC = @$bonlivraisonpartotalesTTC[0][0]['total'] + @$factureclientpartotalesTTC[0][0]['total'] - @$factureavoirpartotalesTTC[0][0]['total'];

        $tab = array();
        $i = 0;
        //debug($bonlivraisonparprixs);
        //debug($factureclientparprixs);die;
        foreach ($factureclientparprixs as $facture) {
            $tab[$i]['clientid'] = $facture['Factureclient']['client_id'];
            $tab[$i]['name'] = $clients[$facture['Factureclient']['client_id']];
            $tab[$i]['tot'] = $facture[0]['total'];
            $tab[$i]['totalttc'] = $facture[0]['totalttc'];
            $tab[$i]['pmp'] = $facture[0]['pmp'];
            $tab[$i]['por'] = round(($facture[0]['total'] / $totaleBLF) * 100, 3);
            $this->Tabetatclient->create();
            $this->Tabetatclient->save($tab[$i]);
            $i++;
        }

        $tab = array();
        $index = 0;
        foreach ($bonlivraisonparprixs as $bonlivraison) {
            $tab[$index]['clientid'] = $bonlivraison['Bonlivraison']['client_id'];
            $tab[$index]['name'] = $clients[$bonlivraison['Bonlivraison']['client_id']];
            $tab[$index]['tot'] = $bonlivraison[0]['total'];
            $tab[$index]['totalttc'] = $bonlivraison[0]['totalttc'];
            $tab[$index]['pmp'] = $bonlivraison[0]['pmp'];
            $tab[$index]['por'] = round(($bonlivraison[0]['total'] / $totaleBLF) * 100, 3);
            $this->Tabetatclient->create();
            $this->Tabetatclient->save($tab[$index]);
            $index++;
        }

        if (!empty($factureavoirparprixs)) {
            $tab = array();
            $index = 0;
            foreach ($factureavoirparprixs as $bonlivraison) {
                $tab[$index]['clientid'] = $bonlivraison['Factureavoir']['client_id'];
                $tab[$index]['name'] = $clients[$bonlivraison['Factureavoir']['client_id']];
                $tab[$index]['tot'] = 0 - $bonlivraison[0]['total'];
                $tab[$index]['pmp'] = 0 - $bonlivraison[0]['pmp'];
                $tab[$index]['por'] = round(($bonlivraison[0]['total'] / $totaleBLF) * 100, 3);
                $this->Tabetatclient->create();
                $this->Tabetatclient->save($tab[$index]);
                $index++;
            }
        }

        //debug($tab);die;

        $tab = $this->Tabetatclient->find('all', array(
            'fields' => array('sum(Tabetatclient.pmp) as pmp', 'sum(Tabetatclient.tot) as tot', 'sum(Tabetatclient.totalttc) as ttc', 'clientid', 'name', 'article', 'sum(Tabetatclient.qte) as qte')
            , 'group' => array('Tabetatclient.clientid')
            , 'order' => array('sum(Tabetatclient.tot)' => 'desc')
            , 'recursive' => 2));

        debug($tab);die;
        $personnels = $this->Personnel->find('list');
        $this->set(compact('personnels', 'totaleBLFTTC', 'pointdeventeid', 'totaleBLF', 'tab', 'bonlivraisons', 'pointdeventes', 'exerciceid', 'exercices', 'date1', 'date2', 'clientid', 'clients', 'factureclients'));
    }


}
