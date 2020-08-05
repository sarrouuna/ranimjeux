<?php
App::uses('AppController', 'Controller');
/**
 * Etatcaarticles Controller
 *
 * @property Etatcaarticle $Etatcaarticle
 */
class EtatcaarticlesController extends AppController {

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
                if(@$liens['lien']=='etatcaarticles'){
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
        $this->loadModel('Personnel');
        $this->loadModel('Moi');
        $this->loadModel('Pointdevente');
        
        $pv="";
        $p=CakeSession::read('pointdevente');
        if($p>0){
          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
          $pvf= 'Factureclient.pointdevente_id = '.$p;
        }
        
        $exercice1s = $this->Exercice->find('list');
        $exe1=date('Y')-1;
        $exercice1 = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe1)));
        $exerciceid1=$exercice1['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id ='.$exe1;
        $condf4 = 'Factureclient.exercice_id ='.$exe1;
        
        
        $exercice2s = $this->Exercice->find('list');
        $exe2=date('Y');
        $exercice2 = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe2)));
        $exerciceid2=$exercice2['Exercice']['id'];
        $condb5 = 'Bonlivraison.exercice_id ='.$exe2;
        $condf5 = 'Factureclient.exercice_id ='.$exe2;
        
         if ($this->request->is('post')) { 
        //debug($this->request->data);die;
        
       if ($this->request->data['Recherche']['client_id']) {
            $clientid= $this->request->data['Recherche']['client_id'];
            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id ='.$clientid;
        } 
         if ($this->request->data['Recherche']['exercice1']) {
            $exerciceid1 = $this->request->data['Recherche']['exercice1'];
            $condb4 = 'Bonlivraison.exercice_id ='.$exercice1s[$exerciceid1];
            $condf4 = 'Factureclient.exercice_id ='.$exercice1s[$exerciceid1];
        }
        if ($this->request->data['Recherche']['exercice2']) {
            $exerciceid2 = $this->request->data['Recherche']['exercice2'];
            $condb5 = 'Bonlivraison.exercice_id ='.$exercice2s[$exerciceid2];
            $condf5 = 'Factureclient.exercice_id ='.$exercice2s[$exerciceid2];
        }
         if ($this->request->data['Recherche']['article_id']) {
            $articleid = $this->request->data['Recherche']['article_id'];
            $condb6 = 'Lignelivraison.article_id ='.$articleid;
            $condf6 = 'Lignefactureclient.article_id ='.$articleid;
            $group1='Lignelivraison.article_id';
            $group2='Lignefactureclient.article_id';
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
        if ($this->request->data['Recherche']['moi_id']) {
            $moiid= $this->request->data['Recherche']['moi_id'];
            //debug($moiid);die;
            $t='(0';
            foreach ($moiid as $ad){
                $t=$t.','.$ad;
            }
            $t=$t.')';
            $condb9 = 'EXTRACT(MONTH FROM Bonlivraison.date) in'.$t;
            $condf9 = 'EXTRACT(MONTH FROM Factureclient.date) in'.$t;
        }
        if (!empty($this->request->data['Recherche']['pointdevente_id'])) {
            $pointdeventeid = $this->request->data['Recherche']['pointdevente_id'];
            $condb10 = 'Bonlivraison.pointdevente_id ='.$pointdeventeid;
            $condf10 = 'Factureclient.pointdevente_id ='.$pointdeventeid;
        }
        
         } 
 $bonlivraisonparprix1s = $this->Lignelivraison->find('all', array(
   'fields'=>array('EXTRACT(MONTH FROM Bonlivraison.date) as mois','sum(Bonlivraison.totalht) as total','sum(Lignelivraison.quantite) as quantite')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,@$pvb,@$condb3 , @$condb4, @$condb6, @$condb7, @$condb8, @$condb9, @$condb10)
  ,'group'=>array('EXTRACT(MONTH FROM Bonlivraison.date)')
  //,'contain'=>array('Bonlivraison','Bonlivraison.Client','Article')
  ,'order'=>array('EXTRACT(MONTH FROM Bonlivraison.date)'=>'asc')   
  ,'recursive'=>2));
//debug($bonlivraisonparprix1s) ;  
 
 $bonlivraisonparprix2s = $this->Lignelivraison->find('all', array(
   'fields'=>array('EXTRACT(MONTH FROM Bonlivraison.date) as mois','sum(Bonlivraison.totalht) as total','sum(Lignelivraison.quantite) as quantite')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,@$pvb,@$condb3, @$condb5, @$condb6, @$condb7,@$condb8,  @$condb9, @$condb10)
  ,'group'=>array('EXTRACT(MONTH FROM Bonlivraison.date)')
  //,'contain'=>array('Bonlivraison.Client','Article')
  ,'order'=>array('EXTRACT(MONTH FROM Bonlivraison.date)'=>'asc')   
  ,'recursive'=>2));
//debug($bonlivraisonparprix2s) ;
 
  
  $factureclientparprix1s = $this->Lignefactureclient->find('all', array(
   'fields'=>array('EXTRACT(MONTH FROM Factureclient.date) as mois','sum(Factureclient.totalht) as total','sum(Lignefactureclient.quantite) as quantite')
  ,'conditions' => array('Factureclient.id > ' => 0,@$pvf,@$condf3 , @$condf4, @$condf6, @$condf7, @$condf8, @$condf9, @$condf10)
  ,'group'=>array('EXTRACT(MONTH FROM Factureclient.date)')
  //,'contain'=>array('Factureclient','Factureclient.Client','Article')
  ,'order'=>array('EXTRACT(MONTH FROM Factureclient.date)'=>'asc')   
  ,'recursive'=>2));
  //debug($factureclientparprix1s) ;
  $factureclientparprix2s = $this->Lignefactureclient->find('all', array(
   'fields'=>array('EXTRACT(MONTH FROM Factureclient.date) as mois','sum(Factureclient.totalht) as total','sum(Lignefactureclient.quantite) as quantite')
  ,'conditions' => array('Factureclient.id > ' => 0,@$pvf,@$condf3 , @$condf5, @$condf6, @$condf7, @$condf8, @$condf9, @$condf10)
  ,'group'=>array('EXTRACT(MONTH FROM Factureclient.date)')
  //,'contain'=>array('Factureclient','Factureclient.Client','Article')
  ,'order'=>array('EXTRACT(MONTH FROM Factureclient.date)'=>'asc')   
  ,'recursive'=>2));
  
  //debug($factureclientparprix2s) ;die;
 

$familles = $this->Famille->find('list');
$articles = $this->Article->find('list');
$clients = $this->Client->find('list');
$personnels = $this->Personnel->find('list');
$mois = $this->Moi->find('list');
$pointdeventes = $this->Pointdevente->find('list');
$this->set(compact('pointdeventes','exerciceid2','exerciceid1','factureclientparprix2s','factureclientparprix1s','bonlivraisonparprix2s','bonlivraisonparprix1s','moiid','mois','familleid','personnelid','articleid','familles','totaleBLF','articles','tab','bonlivraisons','personnels','exerciceid1','exercice1s','exerciceid2','exercice2s','date1','date2','clientid','clients','factureclients'));

	}
        
        
        public function imprimerrecherche() { 
       
        $this->loadModel('Famille');     
        $this->loadModel('Article');
	$this->loadModel('Bonlivraison'); 
        $this->loadModel('Lignelivraison');
        $this->loadModel('Factureclient');
        $this->loadModel('Lignefactureclient');
        $this->loadModel('Client'); 
        $this->loadModel('Exercice');
        $this->loadModel('Personnel');
        $this->loadModel('Moi');
        
        
        
        $exercice1s = $this->Exercice->find('list');
        $exe1=date('Y')-1;
        $exercice1 = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe1)));
        $exerciceid1=$exercice1['Exercice']['id'];
        $condb4 = 'Bonlivraison.exercice_id ='.$exe1;
        $condf4 = 'Factureclient.exercice_id ='.$exe1;
        
        
        $exercice2s = $this->Exercice->find('list');
        $exe2=date('Y');
        $exercice2 = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe2)));
        $exerciceid2=$exercice2['Exercice']['id'];
        $condb5 = 'Bonlivraison.exercice_id ='.$exe2;
        $condf5 = 'Factureclient.exercice_id ='.$exe2;
        
        //debug($this->request->data);die;
        if ($this->request->query['clientid']) {
            $clientid= $this->request->query['clientid'];
            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id ='.$clientid;
        } 
         if ($this->request->query['exercice1']) {
            $exercice1= $this->request->query['exercice1'];
            $condb4 = 'Bonlivraison.exercice_id ='.$exercice1s[$exercice1];
            $condf4 = 'Factureclient.exercice_id ='.$exercice1s[$exercice1];
        } 
         if ($this->request->query['exercice2']) {
            $exercice2= $this->request->query['exercice2'];
            $condb5 = 'Bonlivraison.exercice_id ='.$exercice2s[$exercice2];
            $condf5 = 'Factureclient.exercice_id ='.$exercice2s[$exercice2];
        } 
         if ($this->request->query['articleid']) {
            $articleid = $this->request->query['articleid'];
            $condb6 = 'Lignelivraison.article_id ='.$articleid;
            $condf6 = 'Lignefactureclient.article_id ='.$articleid;
        } 
         
         if ($this->request->query['familleid']) {
            $clientid= $this->request->query['familleid'];
            $condb7 = 'Article.famille_id ='.$clientid;
            $condf7 = 'Article.famille_id ='.$clientid;
        } 
        if (!empty($this->request->query['personnelid'])) {
            $personnelid = $this->request->query['personnelid'];
            $clients=$this->Client->find('all',array('recursive'=>-1,'conditions'=>array('Client.personnel_id'=>$personnelid)));
            $abc='0';
            foreach ($clients as $cl){
              $abc=$abc.','.$cl['Client']['id'];  
            }
            $condb8 = 'Bonlivraison.client_id in ('.$abc.')';
            $condf8 = 'Factureclient.client_id in ('.$abc.')';
        } 
        if (!empty($this->request->query['moiid'])) {
            $moiid = $this->request->query['moiid'];
            $t='(0';
            foreach ($moiid as $ad){
                $t=$t.','.$ad;
            }
            $t=$t.')';
            $condb9 = 'EXTRACT(MONTH FROM Bonlivraison.date) in'.$t;
            $condf9 = 'EXTRACT(MONTH FROM Factureclient.date) in'.$t;
        } 
    
 $bonlivraisonparprix1s = $this->Lignelivraison->find('all', array(
   'fields'=>array('EXTRACT(MONTH FROM Bonlivraison.date) as mois','sum(Bonlivraison.totalht) as total','sum(Lignelivraison.quantite) as quantite')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,@$condb3 , @$condb4, @$condb6, @$condb7, @$condb8, @$condb9)
  ,'group'=>array('Lignelivraison.article_id','EXTRACT(MONTH FROM Bonlivraison.date)')
  //,'contain'=>array('Bonlivraison','Bonlivraison.Client','Article')
  ,'order'=>array('EXTRACT(MONTH FROM Bonlivraison.date)'=>'asc')   
  ,'recursive'=>2));
//debug($bonlivraisonparprix1s) ;  
 
 $bonlivraisonparprix2s = $this->Lignelivraison->find('all', array(
   'fields'=>array('EXTRACT(MONTH FROM Bonlivraison.date) as mois','sum(Bonlivraison.totalht) as total','sum(Lignelivraison.quantite) as quantite')
  ,'conditions' => array('Bonlivraison.id > ' => 0,'Bonlivraison.factureclient_id'=>0,@$condb3, @$condb5, @$condb6, @$condb7,  @$condb9)
  ,'group'=>array('Lignelivraison.article_id','EXTRACT(MONTH FROM Bonlivraison.date)')
  //,'contain'=>array('Bonlivraison','Bonlivraison.Client','Article')
  ,'order'=>array('EXTRACT(MONTH FROM Bonlivraison.date)'=>'asc')   
  ,'recursive'=>2));
//debug($bonlivraisonparprix2s) ;
 
  
  $factureclientparprix1s = $this->Lignefactureclient->find('all', array(
   'fields'=>array('EXTRACT(MONTH FROM Factureclient.date) as mois','sum(Factureclient.totalht) as total','sum(Lignefactureclient.quantite) as quantite')
  ,'conditions' => array('Factureclient.id > ' => 0,@$condf3 , @$condf4, @$condf6, @$condf7, @$condf8, @$condf9)
  ,'group'=>array('Lignefactureclient.article_id','EXTRACT(MONTH FROM Factureclient.date)')
  //,'contain'=>array('Factureclient','Factureclient.Client','Article')
  ,'order'=>array('EXTRACT(MONTH FROM Factureclient.date)'=>'asc')   
  ,'recursive'=>2));
 //debug($factureclientparprix1s) ;
  $factureclientparprix2s = $this->Lignefactureclient->find('all', array(
   'fields'=>array('EXTRACT(MONTH FROM Factureclient.date) as mois','sum(Factureclient.totalht) as total','sum(Lignefactureclient.quantite) as quantite')
  ,'conditions' => array('Factureclient.id > ' => 0,@$condf3 , @$condf5, @$condf6, @$condf7, @$condf8, @$condf9)
  ,'group'=>array('Lignefactureclient.article_id','EXTRACT(MONTH FROM Factureclient.date)')
  //,'contain'=>array('Factureclient','Factureclient.Client','Article')
  ,'order'=>array('EXTRACT(MONTH FROM Factureclient.date)'=>'asc')   
  ,'recursive'=>2));
 //debug($factureclientparprix2s) ;die;   
    $familles = $this->Famille->find('list');
    $articles = $this->Article->find('list');
    $clients = $this->Client->find('list');
    $personnels = $this->Personnel->find('list');
    $mois = $this->Moi->find('list');
    $this->set(compact('exerciceid2','exerciceid1','factureclientparprix2s','factureclientparprix1s','bonlivraisonparprix2s','bonlivraisonparprix1s','moiid','mois','familleid','personnelid','articleid','familles','totaleBLF','articles','tab','bonlivraisons','personnels','exerciceid1','exercice1s','exerciceid2','exercice2s','date1','date2','clientid','clients','factureclients'));

}
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view() {
		
	}

        public function test() {
		
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Etatcaarticle->create();
			if ($this->Etatcaarticle->save($this->request->data)) {
				$this->Session->setFlash(__('The etatcaarticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatcaarticle could not be saved. Please, try again.'));
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
		if (!$this->Etatcaarticle->exists($id)) {
			throw new NotFoundException(__('Invalid etatcaarticle'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Etatcaarticle->save($this->request->data)) {
				$this->Session->setFlash(__('The etatcaarticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatcaarticle could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Etatcaarticle.' . $this->Etatcaarticle->primaryKey => $id));
			$this->request->data = $this->Etatcaarticle->find('first', $options);
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
		$this->Etatcaarticle->id = $id;
		if (!$this->Etatcaarticle->exists()) {
			throw new NotFoundException(__('Invalid etatcaarticle'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Etatcaarticle->delete()) {
			$this->Session->setFlash(__('Etatcaarticle deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Etatcaarticle was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
      public function getarticlefamilles() {
	
            $this->layout = null;
            $this->loadModel('Article');
            $data = $this->request->data;
            $familleid= $data['familleid'];
 
            $articles=$this->Article->find('all',array('conditions'=>array('Article.famille_id' => $familleid)));
            $select="<label class='col-md-2 control-label'>Article</label><div class='col-sm-10'><select name='data[Recherche][article_id]' champ='article_id' id='article_id' class='select ' onchange='' >";
            $select=$select."<option value=''>"."choix"."</option>";
            foreach($articles as $v){
                $select=$select."<option value=".$v['Article']['id'].">".$v['Article']['name']."</option>";
              }
            $select=$select.'</select></div>';
	 echo json_encode(array('select'=>$select));
         die();
      }
        
        
        
}
