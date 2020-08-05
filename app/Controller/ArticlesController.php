<?php

App::uses('AppController', 'Controller');

/**
 * Articles Controller
 *
 * @property Article $Article
 */
class ArticlesController extends AppController {

    public function index() {
        $this->loadModel('Typeetatarticle');
        $this->loadModel('Typestockarticle');
        $lien = CakeSession::read('lien_stock');
        $article = "";
        $totarticles = array();
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'articles') {
                    $article = 1;
                }
            }
        }
        if (( $article <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Articles"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Article']);
            } else {
                $this->request->data['Article'] = CakeSession::read('recherche');
            }
            //debug($this->request->data['Article']);die;
//            if ($this->request->data['Article']['code']) {
//                $code = $this->request->data['Article']['code'];
//                $cond1 = 'Article.code =' . $code;
//            }

            if ($this->request->data['Article']['soussousfamille_id']) {
                $soussousfamilleid = $this->request->data['Article']['soussousfamille_id'];
                $cond2 = 'Article.soussousfamille_id =' . $soussousfamilleid;
            }
            if ($this->request->data['Article']['sousfamille_id']) {
                $sousfamilleid = $this->request->data['Article']['sousfamille_id'];
                $cond3 = 'Article.sousfamille_id =' . $sousfamilleid;
            }
            if ($this->request->data['Article']['famille_id']) {
                $familleid = $this->request->data['Article']['famille_id'];
                $cond4 = 'Article.famille_id =' . $familleid;
            }
            if ($this->request->data['Article']['article_id']) {
                $articleid = $this->request->data['Article']['article_id'];
                $cond5 = 'Article.id =' . $articleid;
            }
//            if ($this->request->data['Article']['article_id']) {
//                $id = $this->request->data['Article']['article_id'];
//                $cond6 = 'Article.id =' . $id;
//            }
            if($this->request->data['Article']!=null){
           $totarticles = $this->Article->find('all', array('conditions' => array(@$cond1, @$cond2, @$cond3, @$cond4, @$cond5),'contain'=>array('Famille','Sousfamille'),'fields' => array('Article.id','Article.code','Article.name','Article.prixvente','Article.coutrevient','Famille.id','Famille.name','Sousfamille.id','Sousfamille.name')));
          //  debug($totarticles);
            }
        }
        // debug($articles);die;
        $familles = $this->Article->Famille->find('list');
        $sousfamilles = $this->Article->Sousfamille->find('list');
        $soussousfamilles = $this->Article->Soussousfamille->find('list');
        $typeetatarticles = $this->Typeetatarticle->find('list');
        $typestockarticles = $this->Typestockarticle->find('list');
        //$composantsoc = CakeSession::read('composantsoc');
        //$articles = $this->Article->find('list', array(
        //'conditions' => array('Article.societe'=>$composantsoc)));
//        debug($articles);die;
        //$articles = $this->Article->find('list');
        $this->set(compact('articles', 'typestockarticles', 'typeetatarticles', 'code', 'familleid', 'sousfamilleid', 'soussousfamilleid', 'familles', 'sousfamilles', 'soussousfamilles', 'totarticles'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_stock');
        $article = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'articles') {
                    $article = 1;
                }
            }
        }
        if (( $article <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Client');
        $this->loadModel('Articleclient');
        $this->loadModel('Tag');
        $this->loadModel('Articletag');
        $this->loadModel('Remiseartfamille');
        $this->loadModel('Familleclient');
        $this->loadModel('Typeetatarticle');
        $this->loadModel('Typestockarticle');
        $this->loadModel('Depot');
        $this->loadModel('Stockdepot');
        if (!$this->Article->exists($id)) {
            throw new NotFoundException(__('Invalid article'));
        }
        $article = $this->Article->find('first', array('conditions' => array('Article.id' => $id)));
        $familleid = $article['Famille']['id'];
        $sousfamilleid = $article['Sousfamille']['id'];
        $options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id));
        $this->request->data = $this->Article->find('first', $options);
        $familles = $this->Article->Famille->find('list');
        $sousfamilles = $this->Article->Sousfamille->find('list', array('conditions' => array('Sousfamille.famille_id' => $familleid)));
        $soussousfamilles = $this->Article->Soussousfamille->find('list', array('conditions' => array('Soussousfamille.sousfamille_id' => $sousfamilleid)));
        $unites = $this->Article->Unite->find('list');
        $fournisseurs = $this->Fournisseur->find('list');
        $clients = $this->Client->find('list');
        $tags = $this->Tag->find('list');
        $typeetatarticles = $this->Typeetatarticle->find('list');
        $typestockarticles = $this->Typestockarticle->find('list');
        $familleclients = $this->Familleclient->find('list');
        $artclient = $this->Articleclient->find('all', array(
            'conditions' => array('Articleclient.article_id' => $id)
        ));
        $artfournisseur = $this->Articlefournisseur->find('all', array(
            'conditions' => array('Articlefournisseur.article_id' => $id)
        ));
        $artfamilleclients = $this->Remiseartfamille->find('all', array(
            'conditions' => array('Remiseartfamille.article_id' => $id)
        ));
        $stockdepots = $this->Stockdepot->find('all', array(
            'conditions' => array('Stockdepot.article_id' => $id)
        ));
        // debug($stockdepots);die;
        $depots = $this->Depot->find('list');
        $this->set(compact('depots', 'stockdepots', 'typestockarticles', 'typeetatarticles', 'artfamilleclients', 'familleclients', 'familles', 'sousfamilles', 'familleid', 'soussousfamilles', 'article', 'unites', 'fournisseurs', 'clients', 'artclient', 'tags', 'articlefournisseurs', 'artfournisseur'));
    }

    public function imprimerimage($id = null) {
        $lien = CakeSession::read('lien_stock');
        $article = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'articles') {
                    $article = $liens['imprimer'];
                }
            }
        }
        if (( $article <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $article = $this->Article->find('first', array('conditions' => array('Article.id' => $id)));
        $this->set(compact('article'));
    }

    public function tva18($id = null) {
		$this->layout = null;
		$this->loadModel('Article');

		//$article_id_ans=$this->request->data['article_id_ans'];
		$articles = $this->Article->find('all', array(
			'conditions' => array("Article.tva !=19"),
			'recursive' => -1,
		));
		//debug($articles);die();
		echo json_encode(array('nbr' => count($articles),'article'=>$articles));
		die();
	}


    public function add() {
        $lien = CakeSession::read('lien_stock');
        $article = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'articles') {
                    $article = $liens['add'];
                }
            }
        }
        if (( $article <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Client');
        $this->loadModel('Articleclient');
        $this->loadModel('Tag');
        $this->loadModel('Articletag');
        $this->loadModel('Familleclient');
        $this->loadModel('Remiseartfamille');
        $this->loadModel('Typeetatarticle');
        $this->loadModel('Typestockarticle');
        $this->loadModel('Depot');
        $this->loadModel('Stockdepot');
        $this->loadModel('Devise');
        $this->loadModel('Articlepmp');
        if ($this->request->is('post')) {
           // debug($this->request->data);die;
            $this->Article->create();
            $this->request->data['Article']['sousfamille_id'] = @$this->request->data['sousfamille_id'];
            $this->request->data['Article']['soussousfamille_id'] = @$this->request->data['soussousfamille_id'];
            $this->request->data['Article']['societe'] = CakeSession::read('composantsoc');
//            $this->request->data['Article']['prixuttc'] = @$this->request->data['Article']['prixvente'];
//            $this->request->data['Article']['prixttcgros'] = @$this->request->data['Article']['prixventegros'];
//            if ($this->request->data['Article']['tva'] != '') {
//                $this->request->data['Article']['prixuttc'] = $this->request->data['Article']['prixvente'] * (1 + ($this->request->data['Article']['tva'] / 100));
//                $this->request->data['Article']['prixttcgros'] = $this->request->data['Article']['prixventegros'] * (1 + ($this->request->data['Article']['tva'] / 100));
//            }
            if ($this->Article->save($this->request->data)) {
                $id = $this->Article->id;
                $this->misejour("Article", "add", $id);
                $articletag = array();
                $stock = array();
//                $depots = $this->Depot->find('all');
//                foreach ($depots as $depot) {
//                    $stock['article_id'] = $id;
//                    $stock['depot_id'] = $depot['Depot']['id'];
//                    $stock['quantite'] = 0;
//                    $stock['prix'] = 0;
//                    $this->Stockdepot->create();
//                    $this->Stockdepot->save($stock);
//                }

                if (!empty($this->request->data['Article']['tag_id'])) {
                    foreach ($this->request->data['Article']['tag_id'] as $t) {
                        $articletag['article_id'] = $id;
                        $articletag['tag_id'] = $t;
                        $this->Articletag->create();
                        $this->Articletag->save($articletag);
                    }
                }
                if (!empty($this->request->data['Articlefournisseur'])) {
                    foreach ($this->request->data['Articlefournisseur'] as $f) {
                        $tab = array();
                        if ($f['sup'] != 1) {
                            if ($f['fournisseur_id'] != "") {
                                $tab['article_id'] = $id;
                                $tab['fournisseur_id'] = $f['fournisseur_id'];
                                $tab['prix'] = $f['prix'];
                                $tab['reference'] = $f['reference'];
                                $this->Articlefournisseur->create();
                                $this->Articlefournisseur->save($tab);
                            }
                        }
                    }
                }
                if (!empty($this->request->data['Articleclient'])) {
                    foreach ($this->request->data['Articleclient'] as $f) {
                        $tab = array();
                        if ($f['sup'] != 1) {
                            $tab['article_id'] = $id;
                            $tab['client_id'] = $f['client_id'];
                            $tab['remise'] = $f['remise'];
                            $this->Articleclient->create();
                            $this->Articleclient->save($tab);
                        }
                    }
                }
                if (!empty($this->request->data['Remiseartfamille'])) {
                    foreach ($this->request->data['Remiseartfamille'] as $f) {
                        $tab = array();
                        if ($f['sup'] != 1) {
                            $tab['article_id'] = $id;
                            $tab['familleclient_id'] = $f['familleclient_id'];
                            $tab['remise'] = $f['remise'];
                            $this->Remiseartfamille->create();
                            $this->Remiseartfamille->save($tab);
                        }
                    }
                }

                if (!empty($this->request->data['Stockalert'])) {
                    foreach ($this->request->data['Stockalert'] as $st) {
                        $this->Stockdepot->updateAll(array('Stockdepot.stockalert' => $st['qte']), array('Stockdepot.article_id' => $id, 'Stockdepot.depot_id' => $st['depot_id']));                                //$this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                    }
                }

                $tabp = array();
                $tabp['article_id'] = $id;
                $tabp['pmp'] = 0;
                $tabp['qte'] = 0;
                $tabp['coutrevient'] = $this->request->data['Article']['coutrevient'];
                $this->Articlepmp->create();
                $this->Articlepmp->save($tabp);

                $this->Session->setFlash(__('The article has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The article could not be saved. Please, try again.'));
            }
        }
        $devises = $this->Devise->find('list');
        $familles = $this->Article->Famille->find('list');
//        debug($familles);die;
        $sousfamilles = $this->Article->Sousfamille->find('list');
        $soussousfamilles = $this->Article->Soussousfamille->find('list');
        $unites = $this->Article->Unite->find('list');
        $fournisseurs = $this->Fournisseur->find('list');
        $familleclients = $this->Familleclient->find('list');
        $clients = $this->Client->find('list');
        $typeetatarticles = $this->Typeetatarticle->find('list');
        $typestockarticles = $this->Typestockarticle->find('list');
        $tags = $this->Tag->find('list');
        $depots = $this->Depot->find('list');
        $depotistes = $this->Depot->find('all', array('recursive' => -1));
        //debug($depotistes);die;
        $this->set(compact('devises', 'depotistes', 'depots', 'typestockarticles', 'typeetatarticles', 'familleclients', 'familles', 'sousfamilles', 'soussousfamilles', 'unites', 'fournisseurs', 'clients', 'tags'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_stock');
        $article = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'articles') {
                    $article = $liens['edit'];
                }
            }
        }
        if (( $article <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Fournisseur');
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Client');
        $this->loadModel('Articleclient');
        $this->loadModel('Tag');
        $this->loadModel('Articletag');
        $this->loadModel('Remiseartfamille');
        $this->loadModel('Familleclient');
        $this->loadModel('Typeetatarticle');
        $this->loadModel('Typestockarticle');
        $this->loadModel('Depot');
        $this->loadModel('Stockdepot');
        if (!$this->Article->exists($id)) {
            throw new NotFoundException(__('Invalid article'));
        }
        $article = $this->Article->find('first', array('conditions' => array('Article.id' => $id)));
        $familleid = $article['Famille']['id'];
        $sousfamilleid = $article['Sousfamille']['id'];
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);die;
//            $this->request->data['Article']['prixuttc'] = @$this->request->data['Article']['prixvente'];
//            $this->request->data['Article']['prixttcgros'] = @$this->request->data['Article']['prixventegros'];
//            if ($this->request->data['Article']['tva'] != '') {
//                $this->request->data['Article']['prixuttc'] = $this->request->data['Article']['prixvente'] * (1 + ($this->request->data['Article']['tva'] / 100));
//                $this->request->data['Article']['prixttcgros'] = $this->request->data['Article']['prixventegros'] * (1 + ($this->request->data['Article']['tva'] / 100));
//            }

            if ($this->request->data['Article']['famille_id'] != $familleid) {
                if ($this->request->data['Article']['sousfamille_id'] != @$this->request->data['sousfamille_id']) {
                    $this->request->data['Article']['sousfamille_id'] = '';
                    $this->request->data['Article']['soussousfamille_id'] = '';
                    if (@$this->request->data['sousfamille_id'] != 0) {
                        $this->request->data['Article']['sousfamille_id'] = @$this->request->data['sousfamille_id'];
                        $this->request->data['Article']['soussousfamille_id'] = '';
                        if (@$this->request->data['soussousfamille_id'] != 0) {
                            $this->request->data['Article']['soussousfamille_id'] = @$this->request->data['soussousfamille_id'];
                        }
                    }
                }
            } else if ($this->request->data['Article']['sousfamille_id'] != $sousfamilleid) {

                $this->request->data['Article']['soussousfamille_id'] = '';
                if (@$this->request->data['soussousfamille_id'] != 0) {
                    $this->request->data['Article']['soussousfamille_id'] = @$this->request->data['soussousfamille_id'];
                }
            }


//            $this->request->data['Article']['prixuttc'] = $this->request->data['Article']['prixvente'] * (1 + ($this->request->data['Article']['tva'] / 100));
            // debug($this->request->data);die;
            if ($this->Article->save($this->request->data)) {
                $this->misejour("Article", "edit", $id);
                $this->Articletag->deleteAll(array('Articletag.article_id' => $id), false);
                if (!empty($this->request->data['Article']['tag'])) {
                    foreach ($this->request->data['Article']['tag'] as $t) {
                        $articletag['article_id'] = $id;
                        $articletag['tag_id'] = $t;
                        $this->Articletag->create();
                        $this->Articletag->save($articletag);
                    }
                }

                $this->Articlefournisseur->deleteAll(array('Articlefournisseur.article_id' => $id), false);
                if (!empty($this->request->data['Articlefournisseur'])) {
                    foreach ($this->request->data['Articlefournisseur'] as $af) {
                        $tab = array();
                        if ($af['sup'] != 1) {
                            $tab['id'] = @$af['id'];
                            $tab['article_id'] = $id;
                            $tab['fournisseur_id'] = $af['fournisseur_id'];
                            $tab['prix'] = $af['prix'];
                            $tab['reference'] = $af['reference'];
                            $this->Articlefournisseur->create();
                            $this->Articlefournisseur->save($tab);
                        } else {
                            $this->Articlefournisseur->deleteAll(array('Articlefournisseur.id' => $af['id']), false);
                        }
                    }
                }
                $this->Articleclient->deleteAll(array('Articleclient.article_id' => $id), false);
                if (!empty($this->request->data['Articleclient'])) {
                    foreach ($this->request->data['Articleclient'] as $f) {
                        $tab = array();
                        if ($f['sup'] != 1) {
                            $tab['article_id'] = $id;
                            $tab['client_id'] = $f['client_id'];
                            $tab['remise'] = $f['remise'];
                            $this->Articleclient->create();
                            $this->Articleclient->save($tab);
                        } else {
                            $this->Articleclient->deleteAll(array('Articleclient.id' => $f['id']), false);
                        }
                    }
                }

                if (!empty($this->request->data['Stockalert'])) {
                    foreach ($this->request->data['Stockalert'] as $st) {
                        $tab = array();
                        if ($st['supstock'] != 1) {
                            $this->Stockdepot->updateAll(array('Stockdepot.stockalert' => $st['qte']), array('Stockdepot.article_id' => $id, 'Stockdepot.depot_id' => $st['depot_id']));                                //$this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                        } else {
                            $this->Stockdepot->updateAll(array('Stockdepot.stockalert' => 0), array('Stockdepot.article_id' => $id, 'Stockdepot.depot_id' => $st['depot_id']));                                //$this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                        }
                    }
                }
/*

                define("HOST", "188.165.212.119");
                define("USER", "jouet19");
                define("PASS", "Jkd3cdDEvPZ!");
                define("DB", "jouet19");
                $conn = mysql_connect(HOST, USER, PASS);
                mysql_select_db(DB);
                mysql_set_charset('utf-8', $conn);

                $ppt = $this->request->data['Article']['prixuttc'];
				$prixht=$ppt/0.9;
                $code = $this->request->data['Article']['code'];
                mysql_query("update  yc_product  set yc_product.price ='$prixht' WHERE yc_product.reference='$code'") or die(mysql_error() . "update  yc_product  set yc_product.price ='$prixht' WHERE yc_product.reference='$code'");
                mysql_query("update  yc_product_shop,yc_product  set yc_product_shop.price ='$prixht' WHERE yc_product.id_product=yc_product_shop.id_product and yc_product.reference='$code'") or die(mysql_error() . "update  yc_product_shop  set yc_product_shop.price ='$prixht' WHERE yc_product.id_product=yc_product_shop.id_product and yc_product.reference='$code'");


                $strsql = "update  yc_product  set yc_product.price =" . $prixht . "where yc_product.reference =".$this->request->data['Article']['code'];
                $strsqll = "update  yc_product_shop  set yc_product_shop.price =" . $prixht . "where yc_product.id_product=yc_product_shop.id_product and yc_product.reference =".$this->request->data['Article']['code'];
                mysql_query($strsql, $conn);
                mysql_query($strsqll, $conn);
                mysql_close($conn);
 */
 
                $this->Session->setFlash(__('The article has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The article could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id));
            $this->request->data = $this->Article->find('first', $options);
        }

        $familles = $this->Article->Famille->find('list');
        $sousfamilles = $this->Article->Sousfamille->find('list', array('conditions' => array('Sousfamille.famille_id' => $familleid)));
        $soussousfamilles = $this->Article->Soussousfamille->find('list', array('conditions' => array('Soussousfamille.sousfamille_id' => $sousfamilleid)));
        $unites = $this->Article->Unite->find('list');
        $fournisseurs = $this->Fournisseur->find('list');
        $clients = $this->Client->find('list');
        $tags = $this->Tag->find('list');
        $typeetatarticles = $this->Typeetatarticle->find('list');
        $typestockarticles = $this->Typestockarticle->find('list');
        $familleclients = $this->Familleclient->find('list');
        $artclient = $this->Articleclient->find('all', array(
            'conditions' => array('Articleclient.article_id' => $id)
        ));
        $artfournisseur = $this->Articlefournisseur->find('all', array(
            'conditions' => array('Articlefournisseur.article_id' => $id)
        ));
        $artfamilleclients = $this->Remiseartfamille->find('all', array(
            'conditions' => array('Remiseartfamille.article_id' => $id)
        ));
        $stockdepots = $this->Stockdepot->find('all', array(
            'conditions' => array('Stockdepot.article_id' => $id)
        ));
        // debug($stockdepots);die;
        $depots = $this->Depot->find('list');
        $this->set(compact('depots', 'stockdepots', 'typestockarticles', 'typeetatarticles', 'artfamilleclients', 'familleclients', 'familles', 'sousfamilles', 'familleid', 'soussousfamilles', 'article', 'unites', 'fournisseurs', 'clients', 'artclient', 'tags', 'articlefournisseurs', 'artfournisseur'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_stock');
        $article = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'articles') {
                    $article = $liens['delete'];
                }
            }
        }
        if (( $article <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Articlefournisseur');
        $this->loadModel('Articleclient');
        $this->loadModel('Articletag');
        $this->Article->id = $id;
        if (!$this->Article->exists()) {
            throw new NotFoundException(__('Invalid article'));
        }
        $this->request->onlyAllow('post', 'delete');

        $this->Articlefournisseur->deleteAll(array('Articlefournisseur.article_id' => $id), false);
        $this->Articleclient->deleteAll(array('Articleclient.article_id' => $id), false);
        $this->Articletag->deleteAll(array('Articletag.article_id' => $id), false);
        $abcd = $this->Article->find('first', array('conditions' => array('Article.id' => $id), 'recursive' => -1));
        $numansar = $abcd['Article']['code'];
        $pvansar = $abcd['Article']['societe'];
        if ($this->Article->delete()) {
            CakeSession::write('view', "delete");
            $this->misejour("Article", $numansar, $id,$pvansar);
            $this->Session->setFlash(__('Article deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Article was not deleted'));
        //$this->redirect(array('action' => 'index'));
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_stock');
        $article = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'articles') {
                    $article = $liens['imprimer'];
                }
            }
        }
        if (( $article <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Famille');

        if ($this->request->query['code']) {
            $code = $this->request->query['code'];
            $cond1 = 'Article.code =' . $code;
        }
        if ($this->request->query['familleid']) {
            $familleid = $this->request->query['familleid'];
            $cond2 = 'Article.famille_id =' . $familleid;
        }
        if ($this->request->query['sousfamilleid']) {
            $sousfamilleid = $this->request->query['sousfamilleid'];
            $cond3 = 'Article.sousfamille_id =' . $sousfamilleid;
        }
        if ($this->request->query['soussousfamilleid']) {
            $soussousfamilleid = $this->request->query['soussousfamilleid'];
            $cond4 = 'Article.soussousfamille_id =' . $soussousfamilleid;
        }
        $articles = $this->Article->find('all', array('conditions' => array('Article.id > ' => 0, @$cond1, @$cond2, @$cond3, @$cond4)));
        $this->set(compact('articles', 'code', 'familleid', 'sousfamilleid', 'soussousfamilleid'));
    }

    public function getsousfamille() {
        $this->layout = null;
        $this->loadModel('Sousfamille');
        $this->loadModel('Famille');

        $data = $this->request->data;
        $familleid = $data['familleid'];

        $sousfamilles = $this->Sousfamille->find('all', array('conditions' => array('Sousfamille.famille_id' => $familleid), 'recursive' => -1));
        $select = "<select name='sousfamille_id'  champ='sousfamille_id' id='sousfamille_id' class='form-control  select ' onchange=' getsoussousfamille()'>";
        $select = $select . "<option value=''>veullier choisir</option>";
        foreach ($sousfamilles as $v) {
            $select = $select . "<option value=" . $v['Sousfamille']['id'] . ">" . $v['Sousfamille']['name'] . "</option>";
        }
        $select = $select . '</select>';

        echo $select;
        die;
    }

    public function getsoussousfamille() {
        $this->layout = null;
        $this->loadModel('Soussousfamille');
        $this->loadModel('Famille');

        $data = $this->request->data;
        $sousfamilleid = $data['sousfamilleid'];

        $soussousfamilles = $this->Soussousfamille->find('all', array('conditions' => array('Soussousfamille.sousfamille_id' => $sousfamilleid), 'recursive' => -1));
        $select = "<select name='soussousfamille_id' champ='soussousfamille_id' id='soussousfamille_id'  class='form-control  select ' onchange=''>";
        $select = $select . "<option value=''>veullier choisir</option>";
        foreach ($soussousfamilles as $v) {
            $select = $select . "<option value=" . $v['Soussousfamille']['id'] . ">" . $v['Soussousfamille']['name'] . "</option>";
        }
        $select = $select . '</select>';

        echo $select;
        die;
    }

    public function testlignereception() {
        $this->layout = null;
        $this->loadModel('Article');
        $data = $this->request->data; //debug($data);
        $articleid = $data['articleid'];
        $json = null;
        $article = $this->Article->find('first', array('conditions' => array('Article.id' => $articleid), false));
        //debug($prixaf);die;
        $lot = $article['Article']['lot'];
        $date = $article['Article']['date'];
        echo $lot . '' . $date;
        die();
    }

    public function testligneentre() {
        $this->layout = null;
        $this->loadModel('Article');
        $data = $this->request->data; //debug($data);
        $articleid = $data['articleid'];
        $json = null;
        $article = $this->Article->find('first', array('conditions' => array('Article.id' => $articleid), false));

        $date = $article['Article']['date'];
        echo $date;
        die();
    }

    public function recherchearticle() {

        $data = $this->request->data;
        $soc = CakeSession::read('composantsoc');
        $code = $data['val1'];
        $cond1 = 'Article.code = ' . "'" . $code . "'";
        $rechereart = $this->Article->find('count', array('conditions' => array($cond1,'Article.societe ' => $soc,'Article.typeetatarticle_id !=2')));
        // debug($recherecheutilisateur);die;

        echo $rechereart;
        die;
        // echo json_encode(array('rechclt'=>$recherecheclient));
        //$this->set(compact('utilisateurs','actionsrechereche','utilisateurid','date1','date2'));
    }

    // select semi automatique 'partie Vente'
    public function haithamselect() {
        $this->layout = null;
//        App::import('Model', 'Article');
//        $this->Article = new Article;
//        $this->Article = new Article;
//        $prix = $this->Article->find('all', array(
//            'conditions' => array('Article.name LIKE' => '%' . $data['val'] . '%', 'Article.typeetatarticle_id' => 1),
//            'recursive' => -1
//        ));
//        debug($prix);die;
//        $tab = explode(' ', $val);
//        $cond = '0=0';
//        $cond1 = '0=0';
//        foreach ($tab as $tabb) {
//            $cond .= " and Article.name LIKE '%" . $tabb . "%'";
//            $cond1 .= " and Article.code LIKE '%" . $tabb . "%'";
//        }
        // debug($cond);die;
        $data = $this->request->data;
        $val = $data['val'];
        $tab = explode(' ', $val);
        $cond = '0=0';
        $cond1 = '0=0';
        foreach ($tab as $tabb) {
            $cond .= " and Article.name LIKE '%" . addslashes($tabb) . "%'";
            $cond1 .= " and Article.code LIKE '%" . addslashes($tabb) . "%'";
        }




        $composantsoc = CakeSession::read('composantsoc');
        $prix = $this->Article->find('all', array(
            'conditions' => array('Article.typeetatarticle_id !=2','Article.societe'=>$composantsoc,'or' => array(@$cond, @$cond1)),
            'recursive' => -1,
            'group' => array('Article.id'),
            'fields' => array('Article.id', 'Article.nom','Article.name','Article.code','Article.pmp'),
            'limit'=>100
        ));

        echo json_encode(array('Prix' => $prix)); // Tableau to JSON <> Json_Decode JOSN TO TABLE
    }

    public function haithamcode() {
        $this->layout = null;
        App::import('Model', 'Article');
        $this->Article = new Article;
        $data = $this->request->data;
        $art = array();
        $this->Article = new Article;
        $prix = $this->Article->find('all', array(
            'conditions' => array('Article.code' => addslashes($data['val']),'Article.typeetatarticle_id !=2'), 'recursive' => -1
        ));

        echo json_encode(array('Prix' => $prix)); // Tableau to JSON <> Json_Decode JOSN TO TABLE
    }

    public function code() {
        $this->layout = null;
        App::import('Model', 'Article');
        $this->Article = new Article;
        $data = $this->request->data;
        $art = array();
        $this->Article = new Article;
        $id = 0;
        $des = '';

        $prix = $this->Article->find('first', array(
            'conditions' => array('Article.code' => $data['val'],'Article.typeetatarticle_id !=2'), 'recursive' => -1
        ));

        if (!empty($prix)) {
            $id = $prix['Article']['id'];
            $des = $prix['Article']['name'];
            $rem = $prix['Article']['remise_transfert'];
            $pmp = $prix['Article']['pmp'];
        }

        echo json_encode(array('id' => $id, 'des' => $des, 'rem' => $rem, 'pmp' => $pmp)); // Tableau to JSON <> Json_Decode JOSN TO TABLE
    }

    // select semi automatique 'partie Achat'
    public function haithamselectachat($val = null, $fournisseurid = null) {
        $this->layout = null;
        App::import('Model', 'Article');
        $this->Article = new Article;
        $data = $this->request->data;
        $art = array();
        $composantsoc = CakeSession::read('composantsoc');
        $this->Article = new Article;

        if ($fournisseurid != 0) {
            $prix = $this->Article->query('
              SELECT articles.id id, articles.code code, articles.name nom
              FROM  articles
              WHERE articles.name  LIKE "%' . addslashes($val) . '%"
              AND articles.societe="'.$composantsoc.'"
              AND NOT
              EXISTS (

              SELECT *
              FROM articlefournisseurs
              WHERE articles.id = articlefournisseurs.article_id
              )

              UNION
              SELECT articlefournisseurs.article_id id, articles.code code, articles.name nom
              FROM articlefournisseurs, articles
              WHERE articlefournisseurs.fournisseur_id =' . $fournisseurid . '
              AND articles.id = articlefournisseurs.article_id
/*              AND articles.name  LIKE ' . '"%.$val.%"' . '   */
              ');
        }

        //debug($prix);die;

        /* $prix = $this->Article->find('all', array(
          'conditions' => array('Article.name LIKE' => '%'.$data['val']. '%','Article.typeetatarticle_id' => 1), 'recursive' => -1
          )); */

        echo json_encode(array('Prix' => $prix)); // Tableau to JSON <> Json_Decode JOSN TO TABLE
    }

    public function codeachat() {
        $this->layout = null;
        App::import('Model', 'Article');
        $this->Article = new Article;
        $data = $this->request->data;
        $art = array();
        $this->Article = new Article;
        $this->loadModel('Articlefournisseur');
        $id = 0;
        $des = '';
        $four = $data['four'];
        //print_r($four);die;
        $prix = $this->Article->find('first', array(
            'conditions' => array('Article.code' => addslashes($data['val']),'Article.typeetatarticle_id !=2'), 'recursive' => -1
        ));

        if (!empty($prix)) {
            $artfour = $this->Articlefournisseur->find('count', array(
                'conditions' => array('Articlefournisseur.article_id' => $prix['Article']['id'], 'Articlefournisseur.fournisseur_id !=' => $four), 'recursive' => -1
            ));
        }
        //print_r($artfour);die;
        if (!empty($prix) && $artfour == 0) {
            $id = $prix['Article']['id'];
            $des = $prix['Article']['name'];
        }

        echo json_encode(array('id' => addslashes($id), 'des' => addslashes($des))); // Tableau to JSON <> Json_Decode JOSN TO TABLE
    }

    public function existencecode($code = null) {
        $this->layout = null;
        App::import('Model', 'Article');
        $this->Article = new Article;
        $article = $this->Article->find('first', array(
            'conditions' => array('Article.code' => @$code,'Article.typeetatarticle_id !=2'), 'recursive' => -1
        ));
        if ($article == array()) {
            $res = 0;
        } else {
            $res = 1;
        }
//        debug($article);die;
        echo json_encode(array('art' => $res)); // Tableau to JSON <> Json_Decode JOSN TO TABLE
        die();
    }

    public function checkartfrs($val = null, $frs = null) {
        $this->layout = null;
//        $data = $this->request->data;
        App::import('Model', 'Articlefournisseur');
        $this->Articlefournisseur = new Articlefournisseur;
//        $data = $this->request->data;

        $this->Articlefournisseur = new Articlefournisseur;

        $art = $this->Articlefournisseur->find('first', array(
            'conditions' => array('Articlefournisseur.reference' => $val, 'Articlefournisseur.fournisseur_id' => $frs), 'recursive' => 0
        ));
        $nb = $this->Articlefournisseur->find('count', array(
            'conditions' => array('Articlefournisseur.reference' => $val, 'Articlefournisseur.fournisseur_id' => $frs), 'recursive' => 0
        ));
        if (floatval($nb) > 0) {
            $article_id = $art['Articlefournisseur']['article_id'];
            $detailart = $this->Article->find('first', array(
                'conditions' => array('Article.id' => $article_id), 'recursive' => 1
            ));
        }

        echo json_encode(array('art' => @$art, 'nb' => @$nb, 'detailart' => @$detailart)); // Tableau to JSON <> Json_Decode JOSN TO TABLE
    }

    public function findfamille() {
        $this->layout = null;
        $test = 0;
        $data = $this->request->data;
        $detailart = $this->Article->find('first', array('conditions' => array('Article.id' => $data['val'])));
        if ($detailart != array()) {
            $test = 1;
        }
        echo json_encode(array('detailart' => $detailart, 'test' => $test)); // Tableau to JSON <> Json_Decode JOSN TO TABLE
    }

    public function codeselect($val = null) {
        $this->layout = null;
        App::import('Model', 'Article');
        $this->Article = new Article;
//        $this->Article = new Article;
//        $prix = $this->Article->find('all', array(
//            'conditions' => array('Article.name LIKE' => '%' . $data['val'] . '%', 'Article.typeetatarticle_id' => 1),
//            'recursive' => -1
//        ));
//        debug($prix);die;
//        $tab = explode(' ', $val);
//        $cond = '0=0';
//        $cond1 = '0=0';
//        foreach ($tab as $tabb) {
//            $cond1 .= " and Article.code LIKE '%" . $tabb . "%'";
//        }
//        // debug($cond);die;
        $composantsoc = CakeSession::read('composantsoc');
        $prix = $this->Article->find('all', array(
            'conditions' => array(" Article.code LIKE  '%" . addslashes($val) . "%' ",'Article.societe'=>$composantsoc,'Article.typeetatarticle_id !=2'),
            'recursive' => 0,
            'group' => array('Article.id'),
            'fields' => array('Article.id', 'Article.code')
        ));
//        $prix = $this->Article->query("SELECT id, code
//                    FROM  `articles`
//                    WHERE  `code` LIKE  '" . $val . "%'
//                    GROUP BY code");
        echo json_encode(array('Prix' => $prix)); // Tableau to JSON <> Json_Decode JOSN TO TABLE
        die();
    }
	public function codeselectindex($val = null) {
        $this->layout = null;
        App::import('Model', 'Article');
        $this->Article = new Article;
//        $this->Article = new Article;
//        $prix = $this->Article->find('all', array(
//            'conditions' => array('Article.name LIKE' => '%' . $data['val'] . '%', 'Article.typeetatarticle_id' => 1),
//            'recursive' => -1
//        ));
//        debug($prix);die;
//        $tab = explode(' ', $val);
//        $cond = '0=0';
//        $cond1 = '0=0';
//        foreach ($tab as $tabb) {
//            $cond1 .= " and Article.code LIKE '%" . $tabb . "%'";
//        }
//        // debug($cond);die;
        $composantsoc = CakeSession::read('composantsoc');
        $prix = $this->Article->find('all', array(
            'conditions' => array(" Article.code LIKE  '%" . addslashes($val) . "%' ",'Article.societe'=>$composantsoc),
            'recursive' => -1,
            'limit'=>100,
            'group' => array('Article.id'),
            //'fields' => array('Article.id', 'Article.code', 'Article.name')
        ));
//        $prix = $this->Article->query("SELECT id, code
//                    FROM  `articles`
//                    WHERE  `code` LIKE  '" . $val . "%'
//                    GROUP BY code");
        echo json_encode(array('Prix' => $prix)); // Tableau to JSON <> Json_Decode JOSN TO TABLE
        die();
    }





    // helmi auto autocomplete dans ligne vente et achat
    public function listecodearticles($val=null) {
        $this->layout = null;
        $composantsoc = CakeSession::read('composantsoc');
        $articles = $this->Article->find('all', array(
            'conditions' => array("Article.code LIKE  '%" . addslashes($val) . "%'",'Article.societe'=>$composantsoc,'Article.typeetatarticle_id !=2'),
            'recursive' => -1,
            'group' => array('Article.id'),
            'limit'=>100
        ));
        echo json_encode(array('Articles' => $articles));
        die();
    }
    public function listearticles($val=null) {
        $this->layout = null;
        $composantsoc = CakeSession::read('composantsoc');
        $articles = $this->Article->find('all', array(
            'conditions' => array("Article.name LIKE '%".addslashes($val)."%'",'Article.societe'=>$composantsoc,'Article.typeetatarticle_id !=2'),
            'recursive' => -1,
            'group' => array('Article.id'),
            'limit'=>100
        ));
        echo json_encode(array('Articles' => $articles));
        die();
    }

    // helmi auto autocomplete dans index article et historique article
    public function index_listecodearticles() {
        $this->layout = null;
        $composantsoc = CakeSession::read('composantsoc');
        $val=$this->request->data['val'];
        $tab = explode('%', $val);
        $val_composer="";
        foreach ($tab as $tabb) {if($tabb !=""){$val_composer .= "%".addslashes($tabb);}}
        $articles = $this->Article->find('all', array(
            'conditions' => array("Article.code LIKE  '" .$val_composer . "%'",'Article.societe'=>$composantsoc),
            'recursive' => -1,
            'group' => array('Article.id'),
            'limit'=>50
        ));
        echo json_encode(array('Articles' => $articles));
        die();
    }
    public function index_listearticles() {
        $this->layout = null;
        $composantsoc = CakeSession::read('composantsoc');
        $val=$this->request->data['val'];
        $tab = explode('%', $val);
        $val_composer="";
        foreach ($tab as $tabb) {if($tabb !=""){$val_composer .= "%".addslashes($tabb);}}
        $articles = $this->Article->find('all', array(
            'conditions' => array("Article.name LIKE '".$val_composer."%'",'Article.societe'=>$composantsoc),
            'recursive' => -1,
            'group' => array('Article.id'),
            'limit'=>50
        ));
        echo json_encode(array('Articles' => $articles));
        die();
    }
    public function detailarticles($val=null) {
        $this->layout = null;
        $articles = $this->Article->find('first', array(
            'conditions' => array("Article.id"=>$val),
            'recursive' => -1,
        ));
        echo json_encode(array('code' => $articles['Article']['code'],'des'=>$articles['Article']['name']));
        die();
    }
    public function getarticlehistorique() {
        $this->layout = null;
        $article_id_ans=$this->request->data['article_id_ans'];
        $articles = $this->Article->find('first', array(
            'conditions' => array("Article.id"=>$article_id_ans),
            'recursive' => -1,
        ));
        echo json_encode(array('tva' => $articles['Article']['tva']));
        die();
    }

}
