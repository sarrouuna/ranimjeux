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
		$lien=  CakeSession::read('lien_stat');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatarticles'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
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
        
        
        
       $this->Tabetatarticle->query('TRUNCATE tabetatarticles;');  
        
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe=date('Y');
        $exercice = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
        $exerciceid=$exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id ='.$exe;
        $condf4 = 'Factureclient.exercice_id ='.$exe;
        $pv="";
        $p=CakeSession::read('pointdevente');
        if($p>0){
          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
          $pvf= 'Factureclient.pointdevente_id = '.$p;
        }
         if ($this->request->is('post')) { 
        //debug($this->request->data);die;
        if ($this->request->data['Recherche']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= '."'".$date1."'";
            $condf4="";
            $condb4="";
        }
        
        if ($this->request->data['Recherche']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= '."'".$date2."'";
            $condf4="";
            $condb4="";
        }
        
       
         if ($this->request->data['Recherche']['exercice_id']) {
            $exerciceid = $this->request->data['Recherche']['exercice_id'];
            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id ='.$exercices[$exerciceid];
        }
         if ($this->request->data['Recherche']['article_id']) {
            $articleid = $this->request->data['Recherche']['article_id'];
            $condb6 = 'Lignelivraison.article_id ='.$articleid;
            $condf6 = 'Lignefactureclient.article_id ='.$articleid;
        } 
        if (!empty($this->request->data['Recherche']['pointdevente_id'])) {
            $pointdeventeid = $this->request->data['Recherche']['pointdevente_id'];
            $condb5 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id ='.$pointdeventeid;
        } 
         if ($this->request->data['Recherche']['famille_id']) {
            $familleid= $this->request->data['Recherche']['famille_id'];
            $condb7 = 'Article.famille_id ='.$familleid;
            $condf7 = 'Article.famille_id ='.$familleid;
        } 
        
    } 
  $bonlivraisonparprixs = $this->Lignelivraison->find('all', array(
   'fields'=>array('sum(Bonlivraison.totalht) as total','Article.name','Article.id','sum(Lignelivraison.quantite) as quantite')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,@$pvb, @$condb1, @$condb2,  @$condb4, @$condb5, @$condb6, @$condb7)
  ,'group'=>array('Lignelivraison.article_id')
  ,'contain'=>array('Bonlivraison','Article'),'recursive'=>2));
  //debug($bonlivraisonparprixs);die; 
  $bonlivraisonpartotales = $this->Lignelivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalht) as total')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0)));
  
  $factureclientparprixs = $this->Lignefactureclient->find('all', array(
   'fields'=>array('sum(Factureclient.totalht) as total','Article.name','Article.id','sum(Lignefactureclient.quantite) as quantite')
  ,'conditions' => array('Factureclient.id > ' => 0,@$pvf, @$condf1, @$condf2 , @$condf4, @$condf5, @$condf6, @$condf7)
  ,'group'=>array('Lignefactureclient.article_id')
  ,'contain'=>array('Factureclient','Article'),'recursive'=>2));
  
  $factureclientpartotales = $this->Lignefactureclient->find('all', array('fields'=>array('sum(Factureclient.totalht) as total'), 'conditions' => array('Factureclient.id > ' => 0)));
  $totaleBLF=$bonlivraisonpartotales[0][0]['total']+$factureclientpartotales[0][0]['total'];
  // debug($factureclientparprixs);die;
       $tab=array();
       $i=0;
       foreach ($bonlivraisonparprixs as $bonlivraison){
       $tab[$i]['articleid']= $bonlivraison['Article']['id'];
       $tab[$i]['article']= $bonlivraison['Article']['name'];
       $tab[$i]['qte']= $bonlivraison[0]['quantite'];
       $tab[$i]['tot']= $bonlivraison[0]['total'];
       $tab[$i]['por']= round(($bonlivraison[0]['total']/$totaleBLF)*100, 3);
       $this->Tabetatarticle->create();
       $this->Tabetatarticle->save($tab[$i]); 
       $i++;
       }
       $tab=array();
       $index=0;
       foreach ($factureclientparprixs as $facture){
       $tab[$index]['articleid']= $facture['Article']['id'];
       $tab[$index]['article']= $facture['Article']['name'];
       $tab[$index]['qte']= $facture[0]['quantite'];
       $tab[$index]['tot']= $facture[0]['total']; 
       $tab[$index]['por']= round(($facture[0]['total']/$totaleBLF)*100,3);
       $this->Tabetatarticle->create();
       $this->Tabetatarticle->save($tab[$index]); 
       $index++;
       }
       $tab = $this->Tabetatarticle->find('all', array(
       'fields'=>array('sum(Tabetatarticle.tot) as tot','articleid','article','sum(Tabetatarticle.qte) as qte')
       ,'group'=>array('Tabetatarticle.articleid')
       ,'order'=>array('sum(Tabetatarticle.tot)'=>'desc')    
       ,'recursive'=>2));
        //debug($tab);die;
                $familles = $this->Famille->find('list');
		$articles = $this->Article->find('list');
                $clients = $this->Client->find('list');
                 $this->set(compact('familleid','pointdeventeid','articleid','familles','totaleBLF','articles','tab','bonlivraisons','pointdeventes','exerciceid','exercices','date1','date2','clients','factureclients'));

	}
        
        
        
    public function imprimerrecherche() { 
        $lien=  CakeSession::read('lien_stat');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatarticles'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
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
        
        
        
       $this->Tabetatarticle->query('TRUNCATE tabetatarticles;'); 
       
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe=date('Y');
        $exercice = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
        $exerciceid=$exercice['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id ='.$exe;
        $condf4 = 'Factureclient.exercice_id ='.$exe;
        $pv="";
        $p=CakeSession::read('pointdevente');
        if($p>0){
          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
          $pvf= 'Factureclient.pointdevente_id = '.$p;
        }
       
        //debug($this->request->data);die;
         if ($this->request->query['date1']){
            $date1 = $this->request->query['date1'];
            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= '."'".$date1."'";
            $condf4="";
            $condb4="";
        }
        
        if ($this->request->query['date2']){
            $date2 = $this->request->query['date2'];
            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= '."'".$date2."'";
            $condf4="";
            $condb4="";
        }
        
       
         if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id ='.$exercices[$exerciceid];
        }
         if ($this->request->query['articleid']) {
            $articleid = $this->request->query['articleid'];
            $condb6 = 'Lignelivraison.article_id ='.$articleid;
            $condf6 = 'Lignefactureclient.article_id ='.$articleid;
        } 
        if (!empty($this->request->query['pointdeventeid'])) {
            $pointdeventeid = $this->request->query['pointdeventeid'];
            $condb5 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf5 = 'Factureclient.pointdevente_id ='.$pointdeventeid;
        } 
         if ($this->request->query['familleid']) {
            $clientid= $this->request->query['familleid'];
            $condb7 = 'Article.famille_id ='.$clientid;
            $condf7 = 'Article.famille_id ='.$clientid;
        } 
        
    
  $bonlivraisonparprixs = $this->Lignelivraison->find('all', array(
   'fields'=>array('sum(Bonlivraison.totalht) as total','Article.name','Article.id','sum(Lignelivraison.quantite) as quantite')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,@$pvb, @$condb1, @$condb2,  @$condb4, @$condb5, @$condb6, @$condb7)
  ,'group'=>array('Lignelivraison.article_id')
  ,'contain'=>array('Bonlivraison','Article'),'recursive'=>2));
  //debug($bonlivraisonparprixs);die; 
  $bonlivraisonpartotales = $this->Lignelivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalht) as total')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0)));
  
  $factureclientparprixs = $this->Lignefactureclient->find('all', array(
   'fields'=>array('sum(Factureclient.totalht) as total','Article.name','Article.id','sum(Lignefactureclient.quantite) as quantite')
  ,'conditions' => array('Factureclient.id > ' => 0,@$pvf, @$condf1, @$condf2 , @$condf4, @$condf5, @$condf6, @$condf7)
  ,'group'=>array('Lignefactureclient.article_id')
  ,'contain'=>array('Factureclient','Article'),'recursive'=>2));
  
  $factureclientpartotales = $this->Lignefactureclient->find('all', array('fields'=>array('sum(Factureclient.totalht) as total'), 'conditions' => array('Factureclient.id > ' => 0)));
  $totaleBLF=$bonlivraisonpartotales[0][0]['total']+$factureclientpartotales[0][0]['total'];
  // debug($factureclientparprixs);die;
       $tab=array();
       $i=0;
       foreach ($bonlivraisonparprixs as $bonlivraison){
       $tab[$i]['articleid']= $bonlivraison['Article']['id'];
       $tab[$i]['article']= $bonlivraison['Article']['name'];
       $tab[$i]['qte']= $bonlivraison[0]['quantite'];
       $tab[$i]['tot']= $bonlivraison[0]['total'];
       $tab[$i]['por']= round(($bonlivraison[0]['total']/$totaleBLF)*100, 3);
       $this->Tabetatarticle->create();
       $this->Tabetatarticle->save($tab[$i]); 
       $i++;
       }
       $tab=array();
       $index=0;
       foreach ($factureclientparprixs as $facture){
       $tab[$index]['articleid']= $facture['Article']['id'];
       $tab[$index]['article']= $facture['Article']['name'];
       $tab[$index]['qte']= $facture[0]['quantite'];
       $tab[$index]['tot']= $facture[0]['total']; 
       $tab[$index]['por']= round(($facture[0]['total']/$totaleBLF)*100,3);
       $this->Tabetatarticle->create();
       $this->Tabetatarticle->save($tab[$index]); 
       $index++;
       }
       $tab = $this->Tabetatarticle->find('all', array(
       'fields'=>array('sum(Tabetatarticle.tot) as tot','articleid','article','sum(Tabetatarticle.qte) as qte')
       ,'group'=>array('Tabetatarticle.articleid')
       ,'order'=>array('sum(Tabetatarticle.tot)'=>'desc')    
       ,'recursive'=>2));
        //debug($tab);die;
      
		
                $clients = $this->Client->find('list');
                 $this->set(compact('familleid','pointdeventeid','articleid','familles','totaleBLF','tab','bonlivraisons','pointdeventes','exerciceid','exercices','date1','date2','clients','factureclients'));

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
}
