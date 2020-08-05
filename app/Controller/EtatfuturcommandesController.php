<?php
App::uses('AppController', 'Controller');
/**
 * Etatfuturcommandes Controller
 *
 * @property Etatfuturcommande $Etatfuturcommande
 */
class EtatfuturcommandesController extends AppController {

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
                if(@$liens['lien']=='etatfuturcommandes'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
        }  
           $this->loadModel('Article');  
           $this->loadModel('Depot');
           $this->loadModel('Lignecommande');
           $this->loadModel('Lignecommandeclient');
           $this->loadModel('Stockdepot');
           $this->loadModel('Etatfuturcommande');
           $date1 = date("Y-m-d");
           //debug($date1);
           $cond1f = 'Commande.dateliv >= '."'".$date1."'";
           $cond1c = 'Commandeclient.dateliv >= '."'".$date1."'";
           $articleid="";$depotid="";
           $etatfuturcommandes=array();
       if (isset($this->request->data) && !empty($this->request->data)) {
           
        $this->Etatfuturcommande->query('TRUNCATE etatfuturcommandes;');   
        
        if ($this->request->data['Stockdepot']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Stockdepot']['date2'])));
            $cond2f = 'Commande.dateliv <= '."'".$date2."'";
            $cond2c = 'Commandeclient.dateliv <= '."'".$date2."'";
        }
       if ($this->request->data['Stockdepot']['article_id']) {
            $articleid= $this->request->data['Stockdepot']['article_id'];
            $cond3 = 'Stockdepot.article_id ='.$articleid;
            $cond3f = 'Lignecommande.article_id ='.$articleid;
            $cond3c = 'Lignecommandeclient.article_id ='.$articleid;
        } 
        
     
    $stockdepots = $this->Stockdepot->find('all', array('fields'=>array('sum(Stockdepot.quantite) as qte','Article.name','Article.id','Article.stockmin'),'conditions' => array('Stockdepot.id > ' => 0, @$cond3 )
    ,'group'=>array('Stockdepot.article_id')));
    //debug($stockdepots);
            $tabstockdepots=array(); 
            $tabstockdepots['date']=date("Y-m-d");
            $tabstockdepots['type']="stock initiale";
            $tabstockdepots['qte']=$stockdepots[0][0]['qte'];
            $tabstockdepots['qtetot']=$stockdepots[0][0]['qte'];
            $this->Etatfuturcommande->create();
            $this->Etatfuturcommande->save($tabstockdepots);
            
    
    $commandefrss = $this->Lignecommande->find('all', array('conditions' => array('Lignecommande.id > ' => 0,'Commande.validite_id in (0,1)',@$cond1f, @$cond3f, @$cond2f )
    ));
    //debug($commandefrss);
    foreach ($commandefrss as $commandefrs) {
            $tabcommandefrss=array(); 
            $tabcommandefrss['date']=$commandefrs['Commande']['dateliv'];
            $tabcommandefrss['type']="Entrée";
            $tabcommandefrss['qte']=$commandefrs['Lignecommande']['quantite'];
            $tabcommandefrss['qtetot']=$commandefrs['Lignecommande']['quantite'];
            $this->Etatfuturcommande->create();
            $this->Etatfuturcommande->save($tabcommandefrss);    
    }
    
    $commandeclts = $this->Lignecommandeclient->find('all', array('conditions' => array('Lignecommandeclient.id > ' => 0,'Commandeclient.etat' => 0,@$cond1c, @$cond3c, @$cond2c )
    ));
    //debug($commandeclts);
    foreach ($commandeclts as $commandeclt) {
            $tabcommandeclts=array(); 
            $tabcommandeclts['date']=$commandeclt['Commandeclient']['dateliv'];
            $tabcommandeclts['type']="Sortie";
            $tabcommandeclts['qte']=$commandeclt['Lignecommandeclient']['quantite'];
            $tabcommandeclts['qtetot']=$commandeclt['Lignecommandeclient']['quantite'];
            $this->Etatfuturcommande->create();
            $this->Etatfuturcommande->save($tabcommandeclts);    
    }
    $etatfuturcommandes=$this->Etatfuturcommande->find('all', array(
    'conditions' => array('Etatfuturcommande.id >' => 0),'recursive'=>0,'order'=>array('Etatfuturcommande.date'=>'asc')
    ));
    //debug($etatfuturcommandes);
    $datefuturcommandes=$this->Etatfuturcommande->find('all', array(
    'conditions' => array('Etatfuturcommande.id >' => 0),'recursive'=>0,'order'=>array('Etatfuturcommande.date'=>'asc')
    ,'group'=>array('Etatfuturcommande.date')));
    //debug($datefuturcommandes);
    }
    //$articles = $this->Article->find('list');
    $this->set(compact('datefuturcommandes','etatfuturcommandes','date2','i','cond4c','cond4f','cond3c','cond3f','cond2c','cond2f','cond1c','cond1f','depotid','articleid','clientid','articles','depots','stockdepots',$this->paginate()));
    
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Etatfuturcommande->exists($id)) {
			throw new NotFoundException(__('Invalid etatfuturcommande'));
		}
		$options = array('conditions' => array('Etatfuturcommande.' . $this->Etatfuturcommande->primaryKey => $id));
		$this->set('etatfuturcommande', $this->Etatfuturcommande->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Etatfuturcommande->create();
			if ($this->Etatfuturcommande->save($this->request->data)) {
				$this->Session->setFlash(__('The etatfuturcommande has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatfuturcommande could not be saved. Please, try again.'));
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
		if (!$this->Etatfuturcommande->exists($id)) {
			throw new NotFoundException(__('Invalid etatfuturcommande'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Etatfuturcommande->save($this->request->data)) {
				$this->Session->setFlash(__('The etatfuturcommande has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatfuturcommande could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Etatfuturcommande.' . $this->Etatfuturcommande->primaryKey => $id));
			$this->request->data = $this->Etatfuturcommande->find('first', $options);
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
		$this->Etatfuturcommande->id = $id;
		if (!$this->Etatfuturcommande->exists()) {
			throw new NotFoundException(__('Invalid etatfuturcommande'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Etatfuturcommande->delete()) {
			$this->Session->setFlash(__('Etatfuturcommande deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Etatfuturcommande was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
