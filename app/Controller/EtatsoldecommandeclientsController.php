<?php
App::uses('AppController', 'Controller');
/**
 * Etatsoldecommandeclients Controller
 *
 * @property Etatsoldecommandeclient $Etatsoldecommandeclient
 */
class EtatsoldecommandeclientsController extends AppController {

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
                if(@$liens['lien']=='etatsoldecommandeclients'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
	    $this->loadModel('Devi'); 
            $this->loadModel('Lignedevi'); 
            $this->loadModel('Commandeclient');
            $this->loadModel('Lignecommandeclient');
            $this->loadModel('Factureclient');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Client');
            $this->loadModel('Exercice');
            $this->loadModel('Article');
       $name='';
       $testarticle=0;
       $testclient=0;
       $lignecommandes=array(); 
       $exercices = $this->Exercice->find('list');
       $exe=date('Y');
       $exercice = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
       $exerciceid=$exercice['Exercice']['id'];
       $condb4 = 'Commandeclient.exercice_id ='.$exe;
       $cond6=",'group'=>array('Commandeclient.client_id')";
        
         if ($this->request->is('post')) { 
        //debug($this->request->data);die;
         if ($this->request->data['Recherche']['regroupe_id']) {
            $regroupeid = $this->request->data['Recherche']['regroupe_id'];
            if($regroupeid==1){
            $cond6c=",'group'=>array('Commandeclient.client_id')";
            $cond6="";
            $cond6a="";
            $testclient=1;    
            }
            if($regroupeid==2){
            $cond6a=",'group'=>array('Lignecommandeclient.article_id')";
            $testarticle=1;
            $cond6="";
            }
            
        }   
        if ($this->request->data['Recherche']['exercice_id']) {
            $exerciceid = $this->request->data['Recherche']['exercice_id'];
            $condb4 = 'Commandeclient.exercice_id ='.$exercices[$exerciceid];
        }
        if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            $condb1 = 'Commandeclient.date >= '."'".$date1."'";
            $condb4="";
        }
        
        if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
            $condb2 = 'Commandeclient.date <= '."'".$date2."'";
            $condb4="";
        }
        
       if ($this->request->data['Recherche']['client_id']) {
            $clientid= $this->request->data['Recherche']['client_id'];
            $condb3 = 'Commandeclient.client_id ='.$clientid;
            $client= $this->Client->find('all',array('conditions'=>array('Client.id'=>$clientid),false));
            $name=$client[0]['Client']['code']."  ".$client[0]['Client']['name'];
            $cond6c=",'group'=>array('Commandeclient.client_id')";
            $cond6="";
            $cond6a="";
            $testclient=1;
        } 
         
        if ($this->request->data['Recherche']['article_id']) {
            $articleid = $this->request->data['Recherche']['article_id'];
            $condb6 = 'Lignecommandeclient.article_id ='.$articleid;
            $cond6a=",'group'=>array('Lignecommandeclient.article_id')";
            $cond6="";
            $testarticle=1;
        } 
        
        
     
            
             
                
            
            $lignecommandes=$this->Lignecommandeclient->find('all', array(
            'conditions' => array('Lignecommandeclient.quantite > Lignecommandeclient.quantiteliv',@$condb1,@$condb2,@$condb3,@$condb4,@$condb6),'recursive'=>0 ,@$cond6,@$cond6c,@$cond6a));
            
            
        }    
           
        
        $articles = array();//$this->Article->find('list');
        $clients = $this->Client->find('list'); 
        $regroupes[1]="Client";
        $regroupes[2]="Article";
         
         
         
         
                 $this->set(compact('regroupeid','regroupes','testclient','testarticle','clients','articles','exercices','lignedevis','lignecommandes','lignelivrisons','lignefactures','name','exerciceid','clientid','date1','date2','articleid'));
               
	}
        
         public function imprimerrecherche() {
        $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatsoldecommandeclients'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }      
             
            $this->loadModel('Devi'); 
            $this->loadModel('Lignedevi'); 
            $this->loadModel('Commandeclient');
            $this->loadModel('Lignecommandeclient');
            $this->loadModel('Factureclient');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Client');
            $this->loadModel('Exercice');
            $this->loadModel('Article');
             
             
             
       $name='';
       $testarticle=0;
       $testclient=0;
       $exercices = $this->Exercice->find('list');
       $lignecommandes=array(); 
       $exe=date('Y');      
       $condb4 = 'Commandeclient.exercice_id ='.$exe;      
       $cond6=",'group'=>array('Commandeclient.client_id')";
       
       if ($this->request->query['regroupeid']) {
            $regroupeid = $this->request->query['regroupeid'];
            if($regroupeid==1){
//            $cond6c=",'group'=>array('Commandeclient.client_id')";
//            $cond6="";
//            $testclient=1;
//            $testarticle=0;
            }
            if($regroupeid==2){
            $cond6a=",'group'=>array('Lignecommandeclient.article_id')";
            $testarticle=1;
            $testclient=0;
            $cond6="";
            }
        }
       
       
       if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $condb1 = 'Commandeclient.date >= '."'".$date1."'";
            $condb4="";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $condb2 = 'Commandeclient.date <= '."'".$date2."'";
            $condb4="";
        }
        
        if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            $condb3 = 'Commandeclient.client_id ='.$clientid;
            $client= $this->Client->find('all',array('conditions'=>array('Client.id'=>$clientid),false));
            $name=$client[0]['Client']['code']."  ".$client[0]['Client']['name'];
            $cond6c=",'group'=>array('Commandeclient.client_id')";
            $cond6="";
            $cond6a="";
            $testclient=1;
        }
       
        if ($this->request->query['articleid']) {
            $articleid = $this->request->query['articleid'];
            $condb6 = 'Lignecommandeclient.article_id ='.$articleid;
            $cond6a=",'group'=>array('Lignecommandeclient.article_id')";
            $cond6="";
            $testarticle=1;
        }
        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            $condb4 = 'Commandeclient.exercice_id ='.$exercices[$exerciceid];
        }
        $l=200;
         $lignecommandes=$this->Lignecommandeclient->find('all', array(
            'conditions' => array('Lignecommandeclient.quantite > Lignecommandeclient.quantiteliv',@$condb1,@$condb2,@$condb3,@$condb4,@$condb6),'recursive'=>0 ,@$cond6,@$cond6c,@$cond6a,'limit'=>$l));
       // debug($lignecommandes);    
                 $this->set(compact('testclient','testarticle','clients','articles','exercices','lignedevis','lignecommandes','lignelivrisons','lignefactures','name','exerciceid','clientid','date1','date2','articleid'));
    }
        

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Etatsoldecommandeclient->exists($id)) {
			throw new NotFoundException(__('Invalid etatsoldecommandeclient'));
		}
		$options = array('conditions' => array('Etatsoldecommandeclient.' . $this->Etatsoldecommandeclient->primaryKey => $id));
		$this->set('etatsoldecommandeclient', $this->Etatsoldecommandeclient->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Etatsoldecommandeclient->create();
			if ($this->Etatsoldecommandeclient->save($this->request->data)) {
				$this->Session->setFlash(__('The etatsoldecommandeclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatsoldecommandeclient could not be saved. Please, try again.'));
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
		if (!$this->Etatsoldecommandeclient->exists($id)) {
			throw new NotFoundException(__('Invalid etatsoldecommandeclient'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Etatsoldecommandeclient->save($this->request->data)) {
				$this->Session->setFlash(__('The etatsoldecommandeclient has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatsoldecommandeclient could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Etatsoldecommandeclient.' . $this->Etatsoldecommandeclient->primaryKey => $id));
			$this->request->data = $this->Etatsoldecommandeclient->find('first', $options);
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
		$this->Etatsoldecommandeclient->id = $id;
		if (!$this->Etatsoldecommandeclient->exists()) {
			throw new NotFoundException(__('Invalid etatsoldecommandeclient'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Etatsoldecommandeclient->delete()) {
			$this->Session->setFlash(__('Etatsoldecommandeclient deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Etatsoldecommandeclient was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
