<?php
App::uses('AppController', 'Controller');
/**
 * Etatligneventes Controller
 *
 * @property Etatlignevente $Etatlignevente
 */
class EtatligneventesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatligneventes'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Lignefactureavoir');
            $this->loadModel('Pointdevente');
            $this->loadModel('Client');
            $this->loadModel('Exercice');
            $this->loadModel('Article');
            $this->loadModel('Fournisseur');
            $this->loadModel('Utilisateur');
            $this->loadModel('Historiquevente');
            $this->loadModel('Famille'); 
            $this->loadModel('Typelignevente');
            $this->loadModel('Factureclient');
            $this->loadModel('Bonlivraison');
            $this->loadModel('Factureavoir');
            
            $historiquearticles=array();
           
       
       
        $this->Historiquevente->query('TRUNCATE historiqueventes;');
        
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe=date('Y');
        $exercice = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
        $exerciceid=$exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id ='.$exe;
        $condf4 = 'Factureclient.exercice_id ='.$exe;
        $conda4 = 'Factureavoir.exercice_id ='.$exe;
        $pv="";
        $pvf="";
        $pva="";
        $p=CakeSession::read('pointdevente');
        if($p>0){
          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
          $pvf= 'Factureclient.pointdevente_id = '.$p;
          $pva= 'Factureavoir.pointdevente_id = '.$p;
        }
        
         if ($this->request->is('post')) { 
        //debug($this->request->data);die;
        if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            
            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= '."'".$date1."'";
            $conda1 = 'Factureavoir.date >= '."'".$date1."'";
            $condf4="";
            $condb4="";
            $conda4="";
            
        }
        
        if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
            
            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= '."'".$date2."'";
            $conda2 = 'Factureavoir.date <= '."'".$date2."'";
            $condf4="";
            $condb4="";
            $conda4="";
           
        }
        
       if ($this->request->data['Recherche']['client_id']) {
            $clientid= $this->request->data['Recherche']['client_id'];
            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id ='.$clientid;
            $conda3 = 'Factureavoir.client_id ='.$clientid;
        } 
         if ($this->request->data['Recherche']['exercice_id']) {
            $exerciceid = $this->request->data['Recherche']['exercice_id'];
            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id ='.$exercices[$exerciceid];
            $conda4 = 'Factureavoir.exercice_id ='.$exercices[$exerciceid];
        }
        
        if (!empty($this->request->data['Recherche']['pointdevente_id'])) {
            $pointdeventeid = $this->request->data['Recherche']['pointdevente_id'];
            $condb5 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id ='.$pointdeventeid;
            $conda5 = 'Factureavoir.pointdevente_id ='.$pointdeventeid;
            $pv="";
            $pvf="";
            $pva="";
        } 
//        if ($this->request->data['Recherche']['article_id']) {
//            $articleid = $this->request->data['Recherche']['article_id'];
//            $condb6 = 'Lignelivraison.article_id ='.$articleid;
//            $condf6 = 'Lignefactureclient.article_id ='.$articleid;
//            $conda6 = 'Lignefactureavoir.article_id ='.$articleid;
//        } 
//        
//         if ($this->request->data['Recherche']['famille_id']) {
//            $familleid= $this->request->data['Recherche']['famille_id'];
//            $condb7 = 'Article.famille_id ='.$familleid;
//            $condf7 = 'Article.famille_id ='.$familleid;
//            $conda7 = 'Article.famille_id ='.$familleid;
//        }
        
     
           
            
                
        

//******************************************************************************************************************************        
            $lignelivrisons=$this->Bonlivraison->find('all', array(
            'conditions' => array(@$pvb,@$condb1,@$condb2,@$condb3,@$condb4,@$condb5,@$condb6,@$condb7),'recursive'=>0 ));
            $tablignelivrisons=array(); 
            foreach ($lignelivrisons as $lignelivrison) {
            $client= $this->Client->find('first',array('conditions'=>array('Client.id'=>$lignelivrison['Bonlivraison']['client_id']),'recursive'=>-1));
             if(!empty($client)){
            @$name=$client['Client']['name'];
            }else {
            $name="";    
            }
            $tablignelivrisons['id_piece']=$lignelivrison['Bonlivraison']['id'];
            $tablignelivrisons['client']=$name;
            $tablignelivrisons['fournisseur']="";
            $tablignelivrisons['utilisateur']="";
            $tablignelivrisons['date']=$lignelivrison['Bonlivraison']['date'];
            $tablignelivrisons['type']="Bon livraison";
            $tablignelivrisons['indice']=1;
            $tablignelivrisons['numero']=$lignelivrison['Bonlivraison']['numero'];
            $tablignelivrisons['remise']=$lignelivrison['Bonlivraison']['remise'];
            $tablignelivrisons['fodec']=$lignelivrison['Bonlivraison']['fodec'];
            $tablignelivrisons['tva']=$lignelivrison['Bonlivraison']['tva'];
            $tablignelivrisons['totalht']=$lignelivrison['Bonlivraison']['totalht'];
            $tablignelivrisons['totalttc']=$lignelivrison['Bonlivraison']['totalttc'];
            $tablignelivrisons['mode']="Sortie";
            $this->Historiquevente->create();
            $this->Historiquevente->save($tablignelivrisons);
            }
//******************************************************************************************************************************        
            $lignefactures=$this->Factureclient->find('all', array(
            'conditions' => array('Factureclient.source="fac"',@$pvf,@$condf1,@$condf2,@$condf3,@$condf4,@$condf5,@$condf6,@$condf7),'recursive'=>0 ));
            $tablignefactures=array(); 
            foreach ($lignefactures as $lignefacture) {
            $client= $this->Client->find('first',array('conditions'=>array('Client.id'=>$lignefacture['Factureclient']['client_id']),'recursive'=>-1));
             if(!empty($client)){
            @$name=$client['Client']['name'];
            }else {
            $name="";    
            }    
            $tablignefactures['id_piece']=$lignefacture['Factureclient']['id'];
            $tablignefactures['client']=$name;
            $tablignefactures['fournisseur']="";
            $tablignefactures['utilisateur']="";
            $tablignefactures['date']=$lignefacture['Factureclient']['date'];
            $tablignefactures['type']="Facture client";
            $tablignefactures['indice']=2;
            $tablignefactures['numero']=$lignefacture['Factureclient']['numero'];
            $tablignefactures['remise']=$lignefacture['Factureclient']['remise'];
            $tablignefactures['fodec']=$lignefacture['Factureclient']['fodec'];
            $tablignefactures['tva']=$lignefacture['Factureclient']['tva'];
            $tablignefactures['totalht']=$lignefacture['Factureclient']['totalht'];
            $tablignefactures['totalttc']=$lignefacture['Factureclient']['totalttc'];
            $tablignefactures['mode']="Sortie";
            $this->Historiquevente->create();
            $this->Historiquevente->save($tablignefactures);
            }

//**********************************************************************************************************        
            $lignefactureavoirs=$this->Factureavoir->find('all', array(
            'conditions' => array(@$pva,@$conda1,@$conda2,@$conda3,@$conda4,@$conda5,@$conda6,@$conda7),'recursive'=>0 ));
            $tablignefactureavoirs=array(); 
            foreach ($lignefactureavoirs as $lignefactureavoir) {
            $client= $this->Client->find('first',array('conditions'=>array('Client.id'=>$lignefactureavoir['Factureavoir']['client_id']),'recursive'=>-1));
            if(!empty($client)){
            @$name=$client['Client']['name'];
            }else {
            $name="";    
            }     
            $tablignefactureavoirs['id_piece']=$lignefactureavoir['Factureavoir']['id'];
            $tablignefactureavoirs['client']=$name;
            $tablignefactureavoirs['fournisseur']="";
            $tablignefactureavoirs['utilisateur']="";
            $tablignefactureavoirs['date']=$lignefactureavoir['Factureavoir']['date'];
            $tablignefactureavoirs['type']="Facture Avoir";
            $tablignefactureavoirs['indice']=3;
            $tablignefactureavoirs['numero']=$lignefactureavoir['Factureavoir']['numero'];
            $tablignefactureavoirs['remise']=$lignefactureavoir['Factureavoir']['remise'];
            $tablignefactureavoirs['fodec']=$lignefactureavoir['Factureavoir']['fodec'];
            $tablignefactureavoirs['tva']=$lignefactureavoir['Factureavoir']['tva'];
            $tablignefactureavoirs['totalht']=$lignefactureavoir['Factureavoir']['totalht'];
            $tablignefactureavoirs['totalttc']=$lignefactureavoir['Factureavoir']['totalttc'];
            $tablignefactureavoirs['mode']="Entreé";
            $this->Historiquevente->create();
            $this->Historiquevente->save($tablignefactureavoirs);
            }
//******************************************************************************************************************************        

            if ($this->request->data['Recherche']['typelignevente_id']) {
            $typeligneventeid= $this->request->data['Recherche']['typelignevente_id'];
            //debug($moiid);die;
            $t='0';
            foreach ($typeligneventeid as $ad){
                $t=$t.','.$ad;
            }
            $condhistorique1 = 'Historiquevente.indice in ('.$t.')';
           
            }
        
         
        
         $historiquearticles=$this->Historiquevente->find('all', array(
        'conditions' => array('Historiquevente.id >' => 0,@$condhistorique1),'recursive'=>0,'order'=>array('Historiquevente.date'=>'desc') ));
         
         
    }     
         
        $articles = $this->Article->find('list');
        $clients = $this->Client->find('list'); 
        $fournisseurs = $this->Fournisseur->find('list');
        $familles = $this->Famille->find('list');
        $typeligneventes = $this->Typelignevente->find('list', array(
        'conditions' => array('Typelignevente.id in (1,2,3)')));
         
    $this->set(compact('t','pointdeventeid','familleid','typeligneventeid','typeligneventes','familles','pointdeventes','clientid','articleid','fournisseurid','date1','date2','historiquearticles','fournisseurs','clients','articles','exercices','lignedevis','lignecommandes','lignelivrisons','lignefactures','name','exerciceid'));
               
	}
        
         public function imprimerrecherche() {
        $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etathistoriquearticles'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }       
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Lignefactureavoir');
            $this->loadModel('Pointdevente');
            $this->loadModel('Client');
            $this->loadModel('Exercice');
            $this->loadModel('Article');
            $this->loadModel('Fournisseur');
            $this->loadModel('Utilisateur');
            $this->loadModel('Historiquevente');
            $this->loadModel('Famille'); 
            $this->loadModel('Typelignevente');
            //debug($this->request->query);die;
       if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
           
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
           
        }
        
        if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            
        }
        if ($this->request->query['familleid']) {
            $familleid = $this->request->query['familleid'];
            
        } 
        if ($this->request->query['articleid']) {
            $articleid = $this->request->query['articleid'];
            
        }
        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
        }
        
        if ($this->request->query['pointdeventeid']) {
            $pointdeventeid = $this->request->query['pointdeventeid'];
        }
        
        if ($this->request->query['typeligneventeid']) {
            $typeligneventeid = $this->request->query['typeligneventeid'];
            $condhistorique1 = 'Historiquevente.indice in ('.$typeligneventeid.')';
        }
        
       $historiquearticles=$this->Historiquevente->find('all', array(
        'conditions' => array('Historiquevente.id >' => 0,@$condhistorique1),'recursive'=>0,'order'=>array('Historiquevente.date'=>'desc') ));
        
       
        $articles = $this->Article->find('list');
        $clients = $this->Client->find('list'); 
        $familles = $this->Famille->find('list');
        $typeligneventes = $this->Typelignevente->find('list');
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        
        $this->set(compact('exercices','pointdeventes','typeligneventes','familles','clients','articles','historiquearticles','pointdeventeid','typeligneventeid','clientid','date1','date2','familleid','articleid','exerciceid'));
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Etatlignevente->exists($id)) {
			throw new NotFoundException(__('Invalid etatlignevente'));
		}
		$options = array('conditions' => array('Etatlignevente.' . $this->Etatlignevente->primaryKey => $id));
		$this->set('etatlignevente', $this->Etatlignevente->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Etatlignevente->create();
			if ($this->Etatlignevente->save($this->request->data)) {
				$this->Session->setFlash(__('The etatlignevente has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatlignevente could not be saved. Please, try again.'));
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
		if (!$this->Etatlignevente->exists($id)) {
			throw new NotFoundException(__('Invalid etatlignevente'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Etatlignevente->save($this->request->data)) {
				$this->Session->setFlash(__('The etatlignevente has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatlignevente could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Etatlignevente.' . $this->Etatlignevente->primaryKey => $id));
			$this->request->data = $this->Etatlignevente->find('first', $options);
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
		$this->Etatlignevente->id = $id;
		if (!$this->Etatlignevente->exists()) {
			throw new NotFoundException(__('Invalid etatlignevente'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Etatlignevente->delete()) {
			$this->Session->setFlash(__('Etatlignevente deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Etatlignevente was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
