<?php

App::uses('AppController', 'Controller');

/**
 * Etatbenefices Controller
 *
 * @property Etatbenefice $Etatbenefice
 */
class EtatbeneficesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->loadModel('Famille');
        $this->loadModel('Article');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Personnel');
        $this->loadModel('Fournisseur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Bonreception');
        $this->loadModel('Facture');
        $this->loadModel('Factureavoirfr');
        $this->loadModel('Lignereception');
        $this->loadModel('Lignefacture');
        $this->loadModel('Lignefactureavoirfr');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Societe');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
//        $condblc4 = ' and bonlivraisons.exercice_id ='.$exe;
//        $condfc4 = ' and factureclients.exercice_id ='.$exe;
//        $condfac4 = ' and factureavoirs.exercice_id ='.$exe;
        $socc = CakeSession::read('soc');
        $pvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id in (' . $socc . ')')));
        $liste_pv = '0';
        foreach ($pvs as $one_pv) {
            if (!empty($one_pv['Pointdevente']['id'])) {
                $liste_pv = $liste_pv . ',' . $one_pv['Pointdevente']['id'];
            }
        }
        $condbsos = ' and bonlivraisons.pointdevente_id in (' . $liste_pv . ')';
        $condfsos = ' and factureclients.pointdevente_id in (' . $liste_pv . ')';
        $condasos = ' and factureavoirs.pointdevente_id in (' . $liste_pv . ')';
        $societe_id = "";
        $condblc4 = ' and bonlivraisons.exercice_id =' . date('Y');
        $condfc4 = ' and factureclients.exercice_id =' . date('Y');
        $condfac4 = ' and factureavoirs.exercice_id =' . date('Y');
        if ($this->request->is('post')) {
            //debug($this->request->data);
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

                $condbsos = ' and bonlivraisons.pointdevente_id in (' . $liste_pv . ')';
                $condfsos = ' and factureclients.pointdevente_id in (' . $liste_pv . ')';
                $condasos = ' and factureavoirs.pointdevente_id in (' . $liste_pv . ')';
            }
            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $condblc4 = ' and bonlivraisons.exercice_id =' . $exercices[$exerciceid];
                $condfc4 = ' and factureclients.exercice_id =' . $exercices[$exerciceid];
                $condfac4 = ' and factureavoirs.exercice_id =' . $exercices[$exerciceid];
            }
            if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $condblc1 = ' and bonlivraisons.date >= ' . '"' . $date1 . '"';
                $condfc1 = ' and factureclients.date >= ' . '"' . $date1 . '"';
                $condfac1 = ' and factureavoirs.date >= ' . '"' . $date1 . '"';
                $condfc4 = "";
                $condblc4 = "";
                $condfac4 = "";
            }
            if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $condblc2 = ' and bonlivraisons.date <= ' . '"' . $date2 . '"';
                $condfc2 = ' and factureclients.date <= ' . '"' . $date2 . '"';
                $condfac2 = ' and factureavoirs.date <= ' . '"' . $date2 . '"';
                $condfc4 = "";
                $condblc4 = "";
                $condfac4 = "";
            }
            //debug($this->request->data);die;
            if ($this->request->data['Recherche']['article_id']) {
                $articleid = $this->request->data['Recherche']['article_id'];
                $condblc3 = ' and lignelivraisons.article_id =' . $articleid;
                $condfc3 = ' and lignefactureclients.article_id =' . $articleid;
                $condfac3 = ' and lignefactureavoirs.article_id =' . $articleid;
            }
            if ($this->request->data['Recherche']['pointdevente_id']) {
                $pointdeventeid = $this->request->data['Recherche']['pointdevente_id'];
                $condblc5 = ' and bonlivraisons.pointdevente_id =' . $pointdeventeid;
                $condfc5 = ' and factureclients.pointdevente_id =' . $pointdeventeid;
                $condfac5 = ' and factureavoirs.pointdevente_id =' . $pointdeventeid;
            }
            if ($this->request->data['Recherche']['famille_id']) {
                $familleid = $this->request->data['Recherche']['famille_id'];
                $condblc6 = ' and articles.famille_id =' . $familleid;
                $condfc6 = ' and articles.famille_id =' . $familleid;
                $condfac6 = ' and articles.famille_id =' . $familleid;
            }
            if ($this->request->data['Recherche']['fournisseur_id']) {
                $fournisseurid = $this->request->data['Recherche']['fournisseur_id'];
                //debug($fournisseurid);
                $articlefournisseurs = $this->Articlefournisseur->find('all', array('recursive' => -1, 'conditions' => array('Articlefournisseur.fournisseur_id' => $fournisseurid)));
                if (!empty($articlefournisseurs)) {
                    $abc = '0';
                    foreach ($articlefournisseurs as $cl) {
                        if ($cl['Articlefournisseur']['article_id'] != '') {
                            $abc = $abc . ',' . $cl['Articlefournisseur']['article_id'];
                        }
                    }
                    $condblc7 = ' and lignelivraisons.article_id in (' . $abc . ')';
                    $condfc7 = ' and lignefactureclients.article_id in (' . $abc . ')';
                    $condfac7 = ' and lignefactureavoirs.article_id in (' . $abc . ')';
                }
            }
            if ($this->request->data['Recherche']['client_id']) {
                $clientid = $this->request->data['Recherche']['client_id'];
                $condblc8 = ' and bonlivraisons.client_id =' . $clientid;
                $condfc8 = ' and factureclients.client_id =' . $clientid;
                $condfac8 = ' and factureavoirs.client_id =' . $clientid;
            }
            if (!empty($this->request->data['Recherche']['personnel_id'])) {
                $personnelid = $this->request->data['Recherche']['personnel_id'];
                $clients = $this->Client->find('all', array('recursive' => -1, 'conditions' => array('Client.personnel_id' => $personnelid)));
                $abc = '0';
                foreach ($clients as $cl) {
                    if ($cl['Client']['id'] != '') {
                        $abc = $abc . ',' . $cl['Client']['id'];
                    }
                }
                $condblc9 = ' and bonlivraisons.client_id in (' . $abc . ')';
                $condfc9 = ' and factureclients.client_id in (' . $abc . ')';
                $condfac9 = ' and factureavoirs.client_id in (' . $abc . ')';
            }
            //$conditionfactureclient = array('AND'=>array(@$condfc1, @$condfc2 ,@$condfc3 , @$condfc4, @$condfc5, @$condfc6, @$condfc7, @$condfc8, @$condfc9));
            //$conditionbonlivraisonclient = array('AND'=>array(@$condblc1, @$condblc2,@$condblc3 ,  @$condblc4, @$condblc5, @$condblc6, @$condblc7, @$condblc8, @$condblc9));
            //$conditionfactureavoirclient = array('AND'=>array(@$condfac1, @$condfac2 ,@$condfac3 , @$condfac4, @$condfac5, @$condfac6, @$condfac7, @$condfac8, @$condfac9));
        }
//        $bonlivraisonparprixs = $this->Lignelivraison->find('all', array(
//        'fields'=>array('sum(Lignelivraison.totalht) as total','Article.name','Article.code','Article.id','sum(Lignelivraison.quantite) as quantite','sum(Lignelivraison.totalttc) as totalttc')
//        ,'conditions' => array(@$condblc1, @$condblc2,@$condblc3 ,  @$condblc4, @$condblc5, @$condblc6, @$condblc7, @$condblc8, @$condblc9)
//        ,'group'=>array('Lignelivraison.article_id')
//        ,'contain'=>array('Bonlivraison','Article'),'recursive'=>2));
//  
//        $factureclientparprixs = $this->Lignefactureclient->find('all', array(
//         'fields'=>array('sum(Lignefactureclient.totalht) as total','Article.name','Article.code','Article.id','sum(Lignefactureclient.quantite) as quantite','sum(Lignefactureclient.totalttc) as totalttc')
//        ,'conditions' => array('Factureclient.source="fac"',@$condfc1, @$condfc2 ,@$condfc3 , @$condfc4, @$condfc5, @$condfc6, @$condfc7, @$condfc8, @$condfc9)
//        ,'group'=>array('Lignefactureclient.article_id')
//        ,'contain'=>array('Factureclient','Article'),'recursive'=>2));
//  
//  
//        $factureavoirparprixs = $this->Lignefactureavoir->find('all', array(
//         'fields'=>array('0-sum(Lignefactureavoir.totalht) as total','Article.name','Article.code','Article.id','0-sum(Lignefactureavoir.quantite) as quantite','0-sum(Lignefactureavoir.totalttc) as totalttc')
//        ,'conditions' => array(@$condfac1, @$condfac2 ,@$condfac3 , @$condfac4, @$condfac5, @$condfac6, @$condfac7, @$condfac8, @$condfac9)
//        ,'group'=>array('Lignefactureavoir.article_id')
//        ,'contain'=>array('Factureavoir','Article'),'recursive'=>2));
//        //debug($etatbenefices);
//        echo 'SELECT SUM( tmp.qte ) qte, tmp.article_id ,tmp.name,tmp.code,SUM(tmp.ht) ht,SUM(tmp.ttc) ttc
//        FROM (
//        SELECT SUM(  `quantite` ) qte,  `article_id`, articles.name,articles.code,SUM(lignefactureclients.totalht) ht,SUM(lignefactureclients.totalttc) ttc
//        FROM  `lignefactureclients`,factureclients,articles
//        where   lignefactureclients.factureclient_id=factureclients.id and factureclients.source="fac"
//        and lignefactureclients.article_id=articles.id  
//        '.@$condfc1.''.@$condfc2.''.@$condfc3.''.@$condfc4.''.@$condfc5.''.@$condfc6.''.@$condfc7.''.@$condfc8.''.@$condfc9.'
//        GROUP BY  lignefactureclients.article_id
//        UNION (
//        SELECT SUM(  `quantite` ) qte,  `article_id` ,articles.name,articles.code,SUM(lignelivraisons.totalht) ht,SUM(lignelivraisons.totalttc) ttc
//        FROM  `lignelivraisons` ,bonlivraisons,articles
//        where   lignelivraisons.bonlivraison_id=bonlivraisons.id
//        and lignelivraisons.article_id=articles.id 
//        '.@$condblc1.''.@$condblc2,@$condblc3 .''. @$condblc4.''.@$condblc5.''.@$condblc6.''.@$condblc7.''.@$condblc8.''.@$condblc9.'
//        GROUP BY  lignelivraisons.article_id
//        )
//        UNION (
//        SELECT (
//        SUM(  `quantite` ) * -1)qte,  `article_id` ,articles.name,articles.code,SUM(lignefactureavoirs.totalht) ht,SUM(lignefactureavoirs.totalttc) ttc
//        FROM  `lignefactureavoirs` ,factureavoirs,articles
//        where   lignefactureavoirs.factureavoir_id=factureavoirs.id
//        and lignefactureavoirs.article_id=articles.id 
//        '.@$condfac1.''.@$condfac2.''.@$condfac3 .''.@$condfac4.''.@$condfac5.''.@$condfac6.''.@$condfac7.''.@$condfac8.''.@$condfac9.'
//        GROUP BY  lignefactureavoirs.article_id
//        )
//        )tmp
//        GROUP BY tmp.article_id';





        $etatbenefices = $this->Etatbenefice->query(
                'SELECT SUM( tmp.qte ) qte, tmp.article_id ,tmp.name,tmp.code,SUM(tmp.ht) ht,SUM(tmp.ttc) ttc
        FROM (
        SELECT SUM(  `quantite` ) qte,  `article_id`, articles.name,articles.code,SUM(lignefactureclients.totalht) ht,SUM(lignefactureclients.totalttc) ttc
        FROM  `lignefactureclients`,factureclients,articles
        where   lignefactureclients.factureclient_id=factureclients.id and factureclients.source="fac"
        and lignefactureclients.article_id=articles.id  
        ' . @$condfc1 . '' . @$condfc2 . '' . @$condfc3 . '' . @$condfc4 . '' . @$condfc5 . '' . @$condfc6 . '' . @$condfc7 . '' . @$condfc8 . '' . @$condfc9 . '' . @$condfsos . '
        GROUP BY lignefactureclients.article_id
        UNION (
        SELECT SUM( `quantite` ) qte, `article_id`, articles.name, articles.code, SUM(lignelivraisons.totalht) ht, SUM(lignelivraisons.totalttc) ttc
        FROM `lignelivraisons`, bonlivraisons, articles
        where lignelivraisons.bonlivraison_id = bonlivraisons.id
        and lignelivraisons.article_id = articles.id
        ' . @$condblc1 . '' . @$condblc2 . '' . @$condblc3 . '' . @$condblc4 . '' . @$condblc5 . '' . @$condblc6 . '' . @$condblc7 . '' . @$condblc8 . '' . @$condblc9 . '' . @$condbsos . '
        GROUP BY lignelivraisons.article_id
        )
        UNION (
        SELECT
        SUM(lignefactureavoirs.quantite * (-1)) qte, article_id, articles.name, articles.code, SUM(lignefactureavoirs.totalht * (-1)) ht, SUM(lignefactureavoirs.totalttc * (-1)) ttc
        FROM `lignefactureavoirs`, factureavoirs, articles
        where lignefactureavoirs.factureavoir_id = factureavoirs.id
        and lignefactureavoirs.article_id = articles.id
        ' . @$condfac1 . '' . @$condfac2 . '' . @$condfac3 . '' . @$condfac4 . '' . @$condfac5 . '' . @$condfac6 . '' . @$condfac7 . '' . @$condfac8 . '' . @$condfac9 . '' . @$condasos . '
        GROUP BY lignefactureavoirs.article_id
        )
        )tmp
        GROUP BY tmp.article_id');

        //debug($etatbenefices);die;



        $familles = $this->Famille->find('list');
        //$articles = array();//$this->Article->find('list');
        $clients = $this->Client->find('list');
        $personnels = $this->Personnel->find('list');
        $pointdeventes = $this->Pointdevente->find('list');
        $fournisseurs = $this->Fournisseur->find('list');
        $soc = CakeSession::read('soc');
        $sos = explode(',', $soc);
        $countsos = count($sos);
        $societes = array();
        if ($countsos > 1) {
            $societes = $this->Societe->find('list', array(
                'conditions' => array('Societe.id in' => $sos)
            ));
        } 
        // debug($etatbenefices);die;
        $this->set(compact('societe_id','societes', 'countsos', 'etatbenefices', 'fournisseurs', 'pointdeventes', 'articles', 'familles', 'personnels', 'exercices', 'clients', 'familleid', 'personnelid', 'fournisseurid', 'articleid', 'date1', 'date2', 'clientid', 'exerciceid'));
    }

    public function view($id = null) {
        if (!$this->Etatbenefice->exists($id)) {
            throw new NotFoundException(__('Invalid etatbenefice'));
        }
        $options = array('conditions' => array('Etatbenefice.' . $this->Etatbenefice->primaryKey => $id));
        $this->set('etatbenefice', $this->Etatbenefice->find('first', $options));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Etatbenefice->create();
            if ($this->Etatbenefice->save($this->request->data)) {
                $this->Session->setFlash(__('The etatbenefice has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatbenefice could not be saved. Please, try again.'));
            }
        }
    }

    public function edit($id = null) {
        if (!$this->Etatbenefice->exists($id)) {
            throw new NotFoundException(__('Invalid etatbenefice'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Etatbenefice->save($this->request->data)) {
                $this->Session->setFlash(__('The etatbenefice has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The etatbenefice could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Etatbenefice.' . $this->Etatbenefice->primaryKey => $id));
            $this->request->data = $this->Etatbenefice->find('first', $options);
        }
    }

    public function delete($id = null) {
        $this->Etatbenefice->id = $id;
        if (!$this->Etatbenefice->exists()) {
            throw new NotFoundException(__('Invalid etatbenefice'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Etatbenefice->delete()) {
            $this->Session->setFlash(__('Etatbenefice deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Etatbenefice was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    //zeinab
    public function imprimerrecherche() {
        $this->loadModel('Famille');
        $this->loadModel('Article');
        $this->loadModel('Client');
        $this->loadModel('Exercice');
        $this->loadModel('Personnel');
        $this->loadModel('Fournisseur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Lignefactureavoir');
        $this->loadModel('Bonreception');
        $this->loadModel('Facture');
        $this->loadModel('Factureavoirfr');
        $this->loadModel('Lignereception');
        $this->loadModel('Lignefacture');
        $this->loadModel('Lignefactureavoirfr');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Pointdevente');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condblc4 = ' and bonlivraisons.exercice_id = ' . $exercices[$exerciceid];
        $condfc4 = ' and factureclients.exercice_id = ' . $exercices[$exerciceid];
        $condfac4 = ' and factureavoirs.exercice_id = ' . $exercices[$exerciceid];

        $condfc1 = '';
        $condfc2 = '';
        $condfc3 = '';
        $condfc5 = '';
        $condfc6 = '';
        $condfc7 = '';
        $condfc8 = '';
        $condfc9 = '';
        $condblc1 = '';
        $condblc2 = '';
        $condblc3 = '';
        $condblc5 = '';
        $condblc6 = '';
        $condblc7 = '';
        $condblc8 = '';
        $condblc9 = '';
        $condfac1 = '';
        $condfac2 = '';
        $condfac3 = '';
        $condfac5 = '';
        $condfac6 = '';
        $condfac7 = '';
        $condfac8 = '';
        $condfac9 = '';
        $socc = CakeSession::read('soc');
        $pvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id in (' . $socc . ')')));
        $liste_pv = '0';
        foreach ($pvs as $one_pv) {
            if (!empty($one_pv['Pointdevente']['id'])) {
                $liste_pv = $liste_pv . ',' . $one_pv['Pointdevente']['id'];
            }
        }
        $condbsos = ' and bonlivraisons.pointdevente_id in (' . $liste_pv . ')';
        $condfsos = ' and factureclients.pointdevente_id in (' . $liste_pv . ')';
        $condasos = ' and factureavoirs.pointdevente_id in (' . $liste_pv . ')';
//          debug($this->request->query);die;
        if (!empty($this->request->query['societe_id'])) {
            $societe_id = $this->request->query['societe_id'];
            
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

            $condbsos = ' and bonlivraisons.pointdevente_id in (' . $liste_pv . ')';
            $condfsos = ' and factureclients.pointdevente_id in (' . $liste_pv . ')';
            $condasos = ' and factureavoirs.pointdevente_id in (' . $liste_pv . ')';
        }
        if (!empty($this->request->query['exercice_id'])) {
            $exerciceid = $this->request->query['exercice_id'];
            $condblc4 = ' and bonlivraisons.exercice_id = ' . $exercices[$exerciceid];
            $condfc4 = ' and factureclients.exercice_id = ' . $exercices[$exerciceid];
            $condfac4 = ' and factureavoirs.exercice_id = ' . $exercices[$exerciceid];
        }
        if (!empty($this->request->query['date1'])) {
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date1'])));
            $condblc1 = ' and bonlivraisons.date >= ' . '"' . $date1 . '"';
            $condfc1 = ' and factureclients.date >= ' . '"' . $date1 . '"';
            $condfac1 = ' and factureavoirs.date >= ' . '"' . $date1 . '"';
            $condfc4 = "";
            $condblc4 = "";
            $condfac4 = "";
        }
        if (!empty($this->request->query['date2'])) {
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['date2'])));
            $condblc2 = ' and bonlivraisons.date <= ' . '"' . $date2 . '"';
            $condfc2 = ' and factureclients.date <= ' . '"' . $date2 . '"';
            $condfac2 = ' and factureavoirs.date <= ' . '"' . $date2 . '"';
            $condfc4 = "";
            $condblc4 = "";
            $condfac4 = "";
        }
        if (!empty($this->request->query['article_id'])) {
            $articleid = $this->request->query['article_id'];
            $condblc3 = ' and lignelivraisons.article_id = ' . $articleid;
            $condfc3 = ' and lignefactureclients.article_id = ' . $articleid;
            $condfac3 = ' and lignefactureavoirs.article_id = ' . $articleid;
        }
        if (!empty($this->request->query['pointdevente_id'])) {
            $pointdeventeid = $this->request->query['pointdevente_id'];
            $condblc5 = ' and bonlivraisons.pointdevente_id = ' . $pointdeventeid;
            $condfc5 = ' and factureclients.pointdevente_id = ' . $pointdeventeid;
            $condfac5 = ' and factureavoirs.pointdevente_id = ' . $pointdeventeid;
        }
        if (!empty($this->request->query['famille_id'])) {
            $familleid = $this->request->query['famille_id'];
            $condblc6 = ' and articles.famille_id = ' . $familleid;
            $condfc6 = ' and articles.famille_id = ' . $familleid;
            $condfac6 = ' and articles.famille_id = ' . $familleid;
        }
        if (!empty($this->request->query['fournisseur_id'])) {
            $fournisseurid = $this->request->query['fournisseur_id'];
            // debug($fournisseurid);die;
            $articlefournisseurs = $this->Articlefournisseur->find('all', array('recursive' => -1, 'conditions' => array('Articlefournisseur.fournisseur_id' => $fournisseurid)));
            if (!empty($articlefournisseurs)) {
                $abc = '0';
                foreach ($articlefournisseurs as $cl) {
                    if ($cl['Articlefournisseur']['article_id'] != '') {
                        $abc = $abc . ', ' . $cl['Articlefournisseur']['article_id'];
                    }
                }
                $condblc7 = ' and lignelivraisons.article_id in (' . $abc . ')';
                $condfc7 = ' and lignefactureclients.article_id in (' . $abc . ')';
                $condfac7 = ' and lignefactureavoirs.article_id in (' . $abc . ')';
            }
        }
        if (!empty($this->request->query['client_id'])) {
            $clientid = $this->request->query['client_id'];
            $condblc8 = ' and bonlivraisons.client_id = ' . $clientid;
            $condfc8 = ' and factureclients.client_id = ' . $clientid;
            $condfac8 = ' and factureavoirs.client_id = ' . $clientid;
        }
        if (!empty($this->request->query['personnel_id'])) {
            $personnelid = $this->request->query['personnel_id'];
            $clients = $this->Client->find('all', array('recursive' => -1, 'conditions' => array('Client.personnel_id' => $personnelid)));
            $abc = '0';
            foreach ($clients as $cl) {
                if ($cl['Client']['id'] != '') {
                    $abc = $abc . ', ' . $cl['Client']['id'];
                }
            }
            $condblc9 = ' and bonlivraisons.client_id in (' . $abc . ')';
            $condfc9 = ' and factureclients.client_id in (' . $abc . ')';
            $condfac9 = ' and factureavoirs.client_id in (' . $abc . ')';
        }

        $etatbenefices = $this->Etatbenefice->query(
                'SELECT SUM( tmp.qte ) qte, tmp.article_id, tmp.name, tmp.code, SUM(tmp.ht) ht, SUM(tmp.ttc) ttc
        FROM (
        SELECT SUM( `quantite` ) qte, `article_id`, articles.name, articles.code, SUM(lignefactureclients.totalht) ht, SUM(lignefactureclients.totalttc) ttc
        FROM `lignefactureclients`, factureclients, articles
        where lignefactureclients.factureclient_id = factureclients.id and factureclients.source = "fac"
        and lignefactureclients.article_id = articles.id
        ' . @$condfc1 . '' . @$condfc2 . '' . @$condfc3 . '' . @$condfc4 . '' . @$condfc5 . '' . @$condfc6 . '' . @$condfc7 . '' . @$condfc8 . '' . @$condfc9 . '' . @$condfsos . '
        GROUP BY lignefactureclients.article_id
        UNION (
        SELECT SUM( `quantite` ) qte, `article_id`, articles.name, articles.code, SUM(lignelivraisons.totalht) ht, SUM(lignelivraisons.totalttc) ttc
        FROM `lignelivraisons`, bonlivraisons, articles
        where lignelivraisons.bonlivraison_id = bonlivraisons.id
        and lignelivraisons.article_id = articles.id
        ' . @$condblc1 . '' . @$condblc2 . '' . @$condblc3 . '' . @$condblc4 . '' . @$condblc5 . '' . @$condblc6 . '' . @$condblc7 . '' . @$condblc8 . '' . @$condblc9 . '' . @$condbsos . '
        GROUP BY lignelivraisons.article_id
        )
        UNION (
        SELECT
        SUM(lignefactureavoirs.quantite * (-1)) qte, article_id, articles.name, articles.code, SUM(lignefactureavoirs.totalht * (-1)) ht, SUM(lignefactureavoirs.totalttc * (-1)) ttc
        FROM `lignefactureavoirs`, factureavoirs, articles
        where lignefactureavoirs.factureavoir_id = factureavoirs.id
        and lignefactureavoirs.article_id = articles.id
        ' . @$condfac1 . '' . @$condfac2 . '' . @$condfac3 . '' . @$condfac4 . '' . @$condfac5 . '' . @$condfac6 . '' . @$condfac7 . '' . @$condfac8 . '' . @$condfac9 . '' . @$condasos . '
        GROUP BY lignefactureavoirs.article_id
        )
        )tmp
        GROUP BY tmp.article_id');

        //debug($etatbenefices);die;
        $familles = $this->Famille->find('list');
        $articles = $this->Article->find('list');
        $clients = $this->Client->find('list');
        $personnels = $this->Personnel->find('list');
        $pointdeventes = $this->Pointdevente->find('list');
        $fournisseurs = $this->Fournisseur->find('list');
        $this->set(compact('etatbenefices', 'fournisseurs', 'pointdeventes', 'articles', 'familles', 'personnels', 'exercices', 'clients', 'familleid', 'personnelid', 'articleid', 'date1', 'date2', 'clientid', 'exerciceid'));
    }

}
