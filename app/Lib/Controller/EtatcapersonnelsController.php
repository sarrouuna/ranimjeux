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
		$lien=  CakeSession::read('lien_stat');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatclients'){
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
        $this->loadModel('Tabetatcaparpersonnel');
        $this->loadModel('Personnel');
        $this->loadModel('Zone');
        
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
       $this->Tabetatcaparpersonnel->query('TRUNCATE tabetatcaparpersonnels;');  
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
        
       if ($this->request->data['Recherche']['client_id']) {
            $clientid= $this->request->data['Recherche']['client_id'];
            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id ='.$clientid;
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
        if (!empty($this->request->data['Recherche']['personnel_id'])) {
            $personnelid = $this->request->data['Recherche']['personnel_id'];
            $clients=$this->Client->find('all',array('recursive'=>-1,'conditions'=>array('Client.personnel_id'=>$personnelid)));
            $abc='0';
            foreach ($clients as $cl){
              $abc=$abc.','.$cl['Client']['id'];  
            }
            $condb8 = 'Bonlivraison.client_id in ('.$abc.')';
            $condf8 = 'Factureclient.client_id in ('.$abc.')';
        }
        
        if (!empty($this->request->data['Recherche']['zone_id'])) {
            $zoneid = $this->request->data['Recherche']['zone_id'];
            $clients=$this->Client->find('all',array('recursive'=>-1,'conditions'=>array('Client.zone_id'=>$zoneid)));
            $zone='0';
            foreach ($clients as $cl){
              $zone=$zone.','.$cl['Client']['id'];  
            }
            $condb9 = 'Bonlivraison.client_id in ('.$zone.')';
            $condf9 = 'Factureclient.client_id in ('.$zone.')';
        }
        
     
 $bonlivraisonparprixs = $this->Lignelivraison->find('all', array(
   'fields'=>array('sum(Bonlivraison.totalht) as total','Bonlivraison.client_id','Article.name','Article.id','sum(Lignelivraison.quantite) as quantite')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,@$pvb, @$condb1, @$condb2, @$condb3 , @$condb4, @$condb5, @$condb6, @$condb7, @$condb8, @$condb9)
  ,'group'=>array('Bonlivraison.client_id','Lignelivraison.article_id')
  ,'contain'=>array('Bonlivraison','Bonlivraison.Client','Article'),'recursive'=>2));
   
  $bonlivraisonpartotales = $this->Bonlivraison->find('all', array('fields'=>array('sum(Bonlivraison.totalht) as total')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0)));
  
  $factureclientparprixs = $this->Lignefactureclient->find('all', array(
   'fields'=>array('sum(Factureclient.totalht) as total','Factureclient.client_id','Article.name','Article.id','sum(Lignefactureclient.quantite) as quantite')
  ,'conditions' => array('Factureclient.id > ' => 0,@$pvf, @$condf1, @$condf2, @$condf3 , @$condf4, @$condf5, @$condf6, @$condf7, @$condf8, @$condf9)
  ,'group'=>array('Factureclient.client_id','Lignefactureclient.article_id')
  ,'contain'=>array('Factureclient','Factureclient.Client','Article'),'recursive'=>2));
  
  $factureclientpartotales = $this->Factureclient->find('all', array('fields'=>array('sum(Factureclient.totalht) as total'), 'conditions' => array('Factureclient.id > ' => 0)));
  $totaleBLF=$bonlivraisonpartotales[0][0]['total']+$factureclientpartotales[0][0]['total'];
   //debug($factureclientparprixs);die;
   $tab=array();
   $i=0;
       foreach ($bonlivraisonparprixs as $bonlivraison){
       $clients = $this->Client->find('first', array(
       'conditions' => array('Client.id'=>$bonlivraison['Bonlivraison']['client_id'])));
       //debug($clients);die;
       $tab[$i]['clientid']=$bonlivraison['Bonlivraison']['client_id'];
       if(!empty($clients)){
       $tab[$i]['name']= $clients['Client']['name'];
       }
       $tab[$i]['articleid']= $bonlivraison['Article']['id'];
       $tab[$i]['article']= $bonlivraison['Article']['name'];
       $tab[$i]['qte']= $bonlivraison[0]['quantite'];
       $tab[$i]['tot']= $bonlivraison[0]['total'];
       $tab[$i]['por']= round(($bonlivraison[0]['total']/$totaleBLF)*100, 3);
       $this->Tabetatcaparpersonnel->create();
       $this->Tabetatcaparpersonnel->save($tab[$i]); 
       $i++;
       }
       $tab=array();
       $index=0;
       foreach ($factureclientparprixs as $facture){
        $clients = $this->Client->find('first', array(
       'conditions' => array('Client.id'=>$facture['Factureclient']['client_id'])));
       //debug($clients);die;
       $tab[$index]['clientid']= $facture['Factureclient']['client_id'];
       if(!empty($clients)){
       $tab[$index]['name']= $clients['Client']['name'];
       }
       $tab[$index]['articleid']= $facture['Article']['id'];
       $tab[$index]['article']= $facture['Article']['name'];
       $tab[$index]['qte']= $facture[0]['quantite'];
       $tab[$index]['tot']= $facture[0]['total']; 
       $tab[$index]['por']= round(($facture[0]['total']/$totaleBLF)*100,3);
       $this->Tabetatcaparpersonnel->create();
       $this->Tabetatcaparpersonnel->save($tab[$index]);
       $index++;
        }
        
       $tab = $this->Tabetatcaparpersonnel->find('all', array(
       'fields'=>array('sum(Tabetatcaparpersonnel.tot) as tot','clientid','name','article','sum(Tabetatcaparpersonnel.qte) as qte')
       ,'group'=>array('Tabetatcaparpersonnel.clientid','Tabetatcaparpersonnel.articleid')
       ,'recursive'=>2));
        //debug($tab);die;
         }
                $familles = $this->Famille->find('list');
		$articles = $this->Article->find('list');
                $clients = $this->Client->find('list');
                $personnels = $this->Personnel->find('list');
                $zones = $this->Zone->find('list');
                 $this->set(compact('zoneid','zones','personnelid','personnels','familleid','pointdeventeid','articleid','familles','totaleBLF','articles','tab','bonlivraisons','pointdeventes','exerciceid','exercices','date1','date2','clientid','clients','factureclients'));

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	 public function imprimerrecherche() { 
         $lien=  CakeSession::read('lien_stat');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatcapersonnels'){
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
        $this->loadModel('Tabetatcaparpersonnel');
        $this->loadModel('Personnel');
        $this->loadModel('Zone');
        //debug($this->request->data);die;
        if ($this->request->query['date1']){
            $date1 = $this->request->query['date1'];
        }
        
         if ($this->request->query['date2']){
            $date2 = $this->request->query['date2'];
        }
        
        if ($this->request->query['clientid']) {
            $clientid= $this->request->query['clientid'];
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
            $familleid= $this->request->query['familleid'];
        } 
        if ($this->request->query['personnelid']) {
            $personnelid= $this->request->query['personnelid'];
        } 
        if ($this->request->query['zoneid']) {
            $zoneid= $this->request->query['zoneid'];
        } 
    
 
        
       $tab = $this->Tabetatcaparpersonnel->find('all', array(
       'fields'=>array('sum(Tabetatcaparpersonnel.tot) as tot','clientid','name','article','sum(Tabetatcaparpersonnel.qte) as qte')
       ,'group'=>array('Tabetatcaparpersonnel.clientid','Tabetatcaparpersonnel.articleid')
       ,'recursive'=>2));
    
        //debug($tab);die;
                $personnels = $this->Personnel->find('list');
                $pointdeventes = $this->Pointdevente->find('list');
                $exercices = $this->Exercice->find('list');
                $familles = $this->Famille->find('list');
		$articles = $this->Article->find('list');
                $clients = $this->Client->find('list');
                $zones = $this->Zone->find('list');
                //debug($clients);die;
                $this->set(compact('zoneid','zones','personnelid','personnels','familleid','pointdeventeid','articleid','familles','articles','tab','pointdeventes','exerciceid','exercices','date1','date2','clientid','clients'));

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
