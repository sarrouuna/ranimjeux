<?php
App::uses('AppController', 'Controller');
/**
 * Stockdepots Controller
 *
 * @property Stockdepot $Stockdepot
 */
class StockdepotsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
           $lien=  CakeSession::read('lien_stock');
              $x="";
             //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='stockdepots'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
           $this->loadModel('Article');  
           $this->loadModel('Depot');
           $this->loadModel('Lignecommande');
           $this->loadModel('LigneCommandeclient');
           $date1 = date("Y-m-d");
           $cond1f = 'Commande.dateliv >= '."'".$date1."'";
           $cond1c = 'Commandeclient.dateliv >= '."'".$date1."'";
           $articleid="";$depotid="";
       if (isset($this->request->data) && !empty($this->request->data)) {
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
    $stockdepots = $this->Stockdepot->find('all', array('fields'=>array('sum(Stockdepot.quantite) as qte','Article.name','Article.id'),'conditions' => array('Stockdepot.id > ' => 0, @$cond3, @$cond4 )
    ,'group'=>array('Stockdepot.article_id')));
    
//    $commandefrss = $this->Lignecommande->find('all', array('fields'=>array('sum(Lignecommande.quantite) as qte','Article.name','Article.id'),'conditions' => array('Lignecommande.id > ' => 0,@$cond1f, @$cond3f, @$cond4f )
//    ,'group'=>array('Lignecommande.article_id')));
//    debug($commandefrss);
//    $commandeclts = $this->LigneCommandeclient->find('all', array('fields'=>array('sum(LigneCommandeclient.quantite) as qte','Article.name','Article.id'),'conditions' => array('LigneCommandeclient.id > ' => 0,@$cond1c, @$cond3c, @$cond4c )
//    ,'group'=>array('LigneCommandeclient.article_id')));
//    debug($commandeclts);
    $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
    $articles = $this->Article->find('list');
    $this->set(compact('date1','cond4c','cond4f','cond3c','cond3f','cond1c','cond1f','depotid','articleid','clientid','articles','depots','stockdepots',$this->paginate()));
    
    }
  public function imprimer() { 
         $lien=  CakeSession::read('lien_stock');
              $vente="";
              if(!empty($lien)){
              foreach($lien as $k=>$liens){
              if(@$liens['lien']=='stockdepots'){
                    $vente=$liens['imprimer'];
               }}}
              if (( $vente <> 1)||(empty($lien))){
             $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
       $this->loadModel('Article');  
       $this->loadModel('Depot');
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
        $stockdepots = $this->Stockdepot->find('all', array('fields'=>array('sum(Stockdepot.quantite) as qte','Article.name','Article.id'),'conditions' => array('Stockdepot.id > ' => 0, @$cond3, @$cond4 )
        ,'group'=>array('Stockdepot.article_id')));

        $this->set(compact('date1','cond4c','cond4f','cond3c','cond3f','cond1c','cond1f','depotid','articleid','stockdepots','depotid','articleid','namedepot'));     
   
         }

	public function view($id = null) {
             $lien=  CakeSession::read('lien_stock');
              $x="";
             //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='stockdepots'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
		if (!$this->Stockdepot->exists($id)) {
			throw new NotFoundException(__('Invalid stockdepot'));
		}
		$options = array('conditions' => array('Stockdepot.' . $this->Stockdepot->primaryKey => $id));
		$this->set('stockdepot', $this->Stockdepot->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
            $lien=  CakeSession::read('lien_stock');
              $vente="";
              if(!empty($lien)){
              foreach($lien as $k=>$liens){
              if(@$liens['lien']=='stockdepots'){
                    $vente=$liens['add'];
               }}}
              if (( $vente <> 1)||(empty($lien))){
             $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
		if ($this->request->is('post')) {
			$this->Stockdepot->create();
			if ($this->Stockdepot->save($this->request->data)) {
				$this->Session->setFlash(__('The stockdepot has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The stockdepot could not be saved. Please, try again.'));
			}
		}
		$articles = $this->Stockdepot->Article->find('list');
		$depots = $this->Stockdepot->Depot->find('list');
		$this->set(compact('articles', 'depots'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
            $lien=  CakeSession::read('lien_stock');
              $vente="";
              if(!empty($lien)){
              foreach($lien as $k=>$liens){
              if(@$liens['lien']=='stockdepots'){
                    $vente=$liens['edit'];
               }}}
              if (( $vente <> 1)||(empty($lien))){
             $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
		if (!$this->Stockdepot->exists($id)) {
			throw new NotFoundException(__('Invalid stockdepot'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Stockdepot->save($this->request->data)) {
				$this->Session->setFlash(__('The stockdepot has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The stockdepot could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Stockdepot.' . $this->Stockdepot->primaryKey => $id));
			$this->request->data = $this->Stockdepot->find('first', $options);
		}
		$articles = $this->Stockdepot->Article->find('list');
		$depots = $this->Stockdepot->Depot->find('list');
		$this->set(compact('articles', 'depots'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
            $lien=  CakeSession::read('lien_stock');
              $vente="";
              if(!empty($lien)){
              foreach($lien as $k=>$liens){
              if(@$liens['lien']=='stockdepots'){
                    $vente=$liens['delete'];
               }}}
              if (( $vente <> 1)||(empty($lien))){
             $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
		$this->Stockdepot->id = $id;
		if (!$this->Stockdepot->exists()) {
			throw new NotFoundException(__('Invalid stockdepot'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Stockdepot->delete()) {
			$this->Session->setFlash(__('Stockdepot deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Stockdepot was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
