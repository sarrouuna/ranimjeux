<?php
App::uses('AppController', 'Controller');
/**
 * Etatstockmins Controller
 *
 * @property Etatstockmin $Etatstockmin
 */
class EtatstockminsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $lien=  CakeSession::read('lien_stock');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatstockmins'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }   
           $this->loadModel('Article');  
           $this->loadModel('Depot');
           $this->loadModel('Lignecommande');
           $this->loadModel('LigneCommandeclient');
           $this->loadModel('Stockdepot');
           $date1 = date("Y-m-d");
           $cond1f = 'Commande.dateliv >= '."'".$date1."'";
           $cond1c = 'Commandeclient.dateliv >= '."'".$date1."'";
           $articleid="";$depotid="";
       if (isset($this->request->data) && !empty($this->request->data)) {
        if ($this->request->data['Stockdepot']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Stockdepot']['date2'])));
            $cond2f = 'Commande.dateliv >= '."'".$date2."'";
            $cond2c = 'Commandeclient.dateliv >= '."'".$date2."'";
        }
       if ($this->request->data['Stockdepot']['article_id']) {
            $articleid= $this->request->data['Stockdepot']['article_id'];
            $cond3 = 'Stockdepot.article_id ='.$articleid;
            $cond3f = 'Lignecommande.article_id ='.$articleid;
            $cond3c = 'Lignecommandeclient.article_id ='.$articleid;
        } 
        if ($this->request->data['Stockdepot']['depot_id']) {
            $depotid= $this->request->data['Stockdepot']['depot_id'];
            $cond4 = 'Stockdepot.depot_id ='.$depotid;
            $cond4f = 'Commande.depot_id ='.$depotid;
            $cond4c = 'Lignecommandeclient.depot_id ='.$depotid;
        } 
    } 
    $stockdepots = $this->Stockdepot->find('all', array('fields'=>array('sum(Stockdepot.quantite) as qte','Article.name','Article.id','Article.stockmin'),'conditions' => array('Stockdepot.id > ' => 0, @$cond3, @$cond4 )
    ,'group'=>array('Stockdepot.article_id')));
    $i = $this->Stockdepot->find('count', array('fields'=>array('sum(Stockdepot.quantite) as qte','Article.name','Article.id','Article.stockmin'),'conditions' => array('Stockdepot.id > ' => 0, @$cond3, @$cond4 )
    ,'group'=>array('Stockdepot.article_id')));
    //debug($i);
    
//    $commandefrss = $this->Lignecommande->find('all', array('fields'=>array('sum(Lignecommande.quantite) as qte','Article.name','Article.id'),'conditions' => array('Lignecommande.id > ' => 0,@$cond1f, @$cond3f, @$cond4f )
//    ,'group'=>array('Lignecommande.article_id')));
//    debug($commandefrss);
//    $commandeclts = $this->LigneCommandeclient->find('all', array('fields'=>array('sum(LigneCommandeclient.quantite) as qte','Article.name','Article.id'),'conditions' => array('LigneCommandeclient.id > ' => 0,@$cond1c, @$cond3c, @$cond4c )
//    ,'group'=>array('LigneCommandeclient.article_id')));
//    debug($commandeclts);
    $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
    $articles = $this->Article->find('list');
    $this->set(compact('date2','i','cond4c','cond4f','cond3c','cond3f','cond2c','cond2f','cond1c','cond1f','depotid','articleid','clientid','articles','depots','stockdepots',$this->paginate()));
    
    }
    
    
     public function imprimer() { 
        $lien=  CakeSession::read('lien_stock');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatstockmins'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }  
       $this->loadModel('Article');  
       $this->loadModel('Depot');
       $this->loadModel('Lignecommande');
       $this->loadModel('LigneCommandeclient');
       $this->loadModel('Stockdepot');
       $date1 = date("Y-m-d");
       $cond1f = 'Commande.dateliv >= '."'".$date1."'";
       $cond1c = 'Commandeclient.dateliv >= '."'".$date1."'";
       $namedepot=""; 
       if ($this->request->query['article_id']) {
            $articleid = $this->request->query['article_id'];
            $cond3 = 'Stockdepot.article_id ='.$articleid;
            $cond3f = 'Lignecommande.article_id ='.$articleid;
            $cond3c = 'Lignecommandeclient.article_id ='.$articleid;
        } 
        if ($this->request->query['depot_id']) {
            $depotid = $this->request->query['depot_id'];
            $cond4 = 'Stockdepot.depot_id ='.$depotid;
            $depots=$this->Depot->find('first',array('conditions'=>array('Depot.id'=>$depotid)));
            $namedepot=$depots['Depot']['designation'];
            $cond4f = 'Commande.depot_id ='.$depotid;
            $cond4c = 'Lignecommandeclient.depot_id ='.$depotid;
        }
        if ($this->request->query['date2']) {
            $date2 = $this->request->query['date2'];
            $cond2f = 'Commande.dateliv >= '."'".$date2."'";
            $cond2c = 'Commandeclient.dateliv >= '."'".$date2."'";
        }
        $stockdepots = $this->Stockdepot->find('all', array('fields'=>array('sum(Stockdepot.quantite) as qte','Article.name','Article.id','Article.stockmin'),'conditions' => array('Stockdepot.id > ' => 0, @$cond3, @$cond4 )
    ,'group'=>array('Stockdepot.article_id')));

        $this->set(compact('date2','date1','cond4c','cond4f','cond3c','cond3f','cond2c','cond2f','cond1c','cond1f','depotid','articleid','stockdepots','depotid','articleid','namedepot'));     
   
         }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Etatstockmin->exists($id)) {
			throw new NotFoundException(__('Invalid etatstockmin'));
		}
		$options = array('conditions' => array('Etatstockmin.' . $this->Etatstockmin->primaryKey => $id));
		$this->set('etatstockmin', $this->Etatstockmin->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Etatstockmin->create();
			if ($this->Etatstockmin->save($this->request->data)) {
				$this->Session->setFlash(__('The etatstockmin has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatstockmin could not be saved. Please, try again.'));
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
		if (!$this->Etatstockmin->exists($id)) {
			throw new NotFoundException(__('Invalid etatstockmin'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Etatstockmin->save($this->request->data)) {
				$this->Session->setFlash(__('The etatstockmin has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatstockmin could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Etatstockmin.' . $this->Etatstockmin->primaryKey => $id));
			$this->request->data = $this->Etatstockmin->find('first', $options);
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
		$this->Etatstockmin->id = $id;
		if (!$this->Etatstockmin->exists()) {
			throw new NotFoundException(__('Invalid etatstockmin'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Etatstockmin->delete()) {
			$this->Session->setFlash(__('Etatstockmin deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Etatstockmin was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
