<?php
App::uses('AppController', 'Controller');
/**
 * Bonsortis Controller
 *
 * @property Bonsorti $Bonsorti
 */
class BonsortisController extends AppController {

	public function index() {
             $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonsortis'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Bonsorti->recursive = 0;
		$this->set('bonsortis', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
             $this->loadModel('Lignesorti');
             $this->loadModel('Lignesortidetail');
		if (!$this->Bonsorti->exists($id)) {
			throw new NotFoundException(__('Invalid bonsorti'));
		}
		$options = array('conditions' => array('Bonsorti.' . $this->Bonsorti->primaryKey => $id));
		$this->set('bonsorti', $this->Bonsorti->find('first', $options));
                $lignesortis=$this->Lignesorti->find('all',array('conditions'=>array('Lignesorti.bonsorti_id' => $id))); 
                //debug($lignesortis);die;    
                $this->set(compact('lignesortis'));
	}
    public function imprimer($id = null) {
            $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonsortis'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Lignesorti');
             $this->loadModel('Lignesortidetail');
		if (!$this->Bonsorti->exists($id)) {
			throw new NotFoundException(__('Invalid Bonsorti'));
		}
		$options = array('conditions' => array('Bonsorti.' . $this->Bonsorti->primaryKey => $id));
		$this->set('bonsorti', $this->Bonsorti->find('first', $options));
                $lignesortis=$this->Lignesorti->find('all',array('conditions'=>array('Lignesorti.bonsorti_id' => $id))); 
                //debug($lignesortis);die;    
                $this->set(compact('lignesortis'));
	}
/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Bonsorti->create();
			if ($this->Bonsorti->save($this->request->data)) {
				$this->Session->setFlash(__('The bonsorti has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bonsorti could not be saved. Please, try again.'));
			}
		}
		$clients = $this->Bonsorti->Client->find('list');
		$utilisateurs = $this->Bonsorti->Utilisateur->find('list');
		$bonlivraisons = $this->Bonsorti->Bonlivraison->find('list');
		$factureclients = $this->Bonsorti->Factureclient->find('list');
		$this->set(compact('clients', 'utilisateurs', 'bonlivraisons', 'factureclients'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Bonsorti->exists($id)) {
			throw new NotFoundException(__('Invalid bonsorti'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Bonsorti->save($this->request->data)) {
				$this->Session->setFlash(__('The bonsorti has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bonsorti could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Bonsorti.' . $this->Bonsorti->primaryKey => $id));
			$this->request->data = $this->Bonsorti->find('first', $options);
		}
		$clients = $this->Bonsorti->Client->find('list');
		$utilisateurs = $this->Bonsorti->Utilisateur->find('list');
		$bonlivraisons = $this->Bonsorti->Bonlivraison->find('list');
		$factureclients = $this->Bonsorti->Factureclient->find('list');
		$this->set(compact('clients', 'utilisateurs', 'bonlivraisons', 'factureclients'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
            $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonsortis'){
                        $vente=$liens['delete'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Lignesorti');
             $this->loadModel('Lignesortidetail');
             $this->loadModel('Bonlivraison');
             $this->loadModel('Lignelivraison');
             $this->loadModel('Factureclient');
             $this->loadModel('Lignefactureclient');
             $this->loadModel('Stockdepot');
		$this->Bonsorti->id = $id;
		if (!$this->Bonsorti->exists()) {
			throw new NotFoundException(__('Invalid bonsorti'));
		}
		$this->request->onlyAllow('post', 'delete');
                
               
                $lignesortis=$this->Lignesorti->find('all',array('conditions'=>array('Lignesorti.bonsorti_id' => $id))); 
                @$blid=$lignesortis[0]['Bonsorti']['bonlivraison_id'];
                @$fcid=$lignesortis[0]['Bonsorti']['factureclient_id'];
                 //debug($blid);die;
                //debug($lignesortis);die;  
                
                       foreach ($lignesortis as $i => $ligne) {
                        if(!empty($blid)){   //debug($blid);die;
                       $this->Lignelivraison->updateAll(array('Lignelivraison.quantitelivrai'=>'Lignelivraison.quantitelivrai-'.$ligne['Lignelivraison']['quantitelivrai']), array('Lignelivraison.id' =>$ligne['Lignelivraison']['id']));   
                       $this->Bonlivraison->updateAll(array('Bonlivraison.etat'=>0), array('Bonlivraison.id' =>@$blid));   
                        }elseif (!empty($fcid)) { //debug($fcid);die;
                       $this->Lignefactureclient->updateAll(array('Lignefactureclient.quantitelivrai'=>'Lignefactureclient.quantitelivrai-'.$ligne['Lignefactureclient']['quantitelivrai']), array('Lignefactureclient.id' =>$ligne['Lignefactureclient']['id']));   
                       $this->Factureclient->updateAll(array('Factureclient.etat'=>0), array('Factureclient.id' =>@$fcid));   
                         } 
                            foreach ($ligne['Lignesortidetail'] as  $lsd){
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite'=>'Stockdepot.quantite+'.$lsd['quantite']), array('Stockdepot.id' =>$lsd['stockdepot_id']));   
                            $this->Lignesortidetail->deleteAll(array('Lignesortidetail.id'=>$lsd['id']),false);                        
                            }       
                       }
                       $this->Lignesorti->deleteAll(array('Lignesorti.bonsorti_id'=>$id),false);   
                  
		if ($this->Bonsorti->delete()) {
			$this->Session->setFlash(__('Bonsorti deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Bonsorti was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
