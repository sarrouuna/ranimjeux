<?php
App::uses('AppController', 'Controller');
/**
 * Bonsortiestocks Controller
 *
 * @property Bonsortiestock $Bonsortiestock
 */
class BonsortiestocksController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
	$lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonsortiestocks') {
                    $x =1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }	
	
       $this->loadModel('Exercice');
       $exercices = $this->Exercice->find('list');
       $exe=date('Y');
       $exercice = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
       $exerciceid=$exercice['Exercice']['id'];
       $condb4 = 'Bonsortiestock.exercice_id ='.$exe;
        
        if ($this->request->is('post')) { 
        //debug($this->request->data);die;
        if ($this->request->data['Recherche']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            $condb1 = 'Bonsortiestock.date >= '."'".$date1."'";
            $condb4="";
        }
        
        if ($this->request->data['Recherche']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
            $condb2 = 'Bonsortiestock.date <= '."'".$date2."'";
            $condb4="";
        }
        
        if ($this->request->data['Recherche']['exercice_id']) {
            $exerciceid = $this->request->data['Recherche']['exercice_id'];
            $condb4 = 'Bonsortiestock.exercice_id ='.$exercices[$exerciceid];
        } 
        
        
    } 
    $bonsortiestocks = $this->Bonsortiestock->find('all', array(
    'conditions' => array('Bonsortiestock.id > ' => 0, @$condb1, @$condb2, @$condb4)
    ));

      
		
    $this->set(compact('bonsortiestocks','exerciceid','exercices','date1','date2',$this->paginate()));

	}
        public function imprimer($id = null) {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonsortiestocks') {
                    $x =$liens['imprimer'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
               $this->loadModel('Lignebonsortiestock');
		if (!$this->Bonsortiestock->exists($id)) {
			throw new NotFoundException(__('Invalid Bon sorties tock'));
		}
                 $lignebonsortiestocks = $this->Lignebonsortiestock->find('all',array(
                    'conditions'=>array('Lignebonsortiestock.bonsortiestock_id' => $id)
                    ));
                    
                    
              $bonsortiestock=$this->Bonsortiestock->find('first',array('conditions'=>array('Bonsortiestock.id'=>$id)));      
		//debug($commande);die;
		$this->set(compact('lignebonsortiestocks', 'bonsortiestock'));
         }
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonsortiestocks') {
                    $x =1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }    
		if (!$this->Bonsortiestock->exists($id)) {
			throw new NotFoundException(__('Invalid bonsortiestock'));
		}
		$options = array('conditions' => array('Bonsortiestock.' . $this->Bonsortiestock->primaryKey => $id));
		$this->set('bonsortiestock', $this->Bonsortiestock->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	
        
        public function add() {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonsortiestocks') {
                    $x =$liens['add'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }    
            $this->loadModel('Stockdepot');
            $this->loadModel('Lignebonsortiestock');
		if ($this->request->is('post')) {
                   // debug($this->request->data);die;
                    
                    $this->request->data['Bonsortiestock']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonsortiestock']['date'])));
		    $this->request->data['Bonsortiestock']['utilisateur_id']= CakeSession::read('users'); 
                    $this->request->data['Bonsortiestock']['exercice_id']=date("Y");
                    
                    
                    
			$this->Bonsortiestock->create();
			if ($this->Bonsortiestock->save($this->request->data)) {
                            
                        
                            $id=$this->Bonsortiestock->id;
                        
                             $Lignetransferts=array();
                             $stockdepots=array(); 
                              foreach (  $this->request->data['Lignetransfert'] as $numl=>$f   ){
                                  
                              if ($f['sup']!=1){
                                $Lignetransferts['depot_id']=$f['depot_id'];  
                                $Lignetransferts['article_id']=$f['article_id'];
                                $Lignetransferts['quantite']=$f['quantite'];
                                $Lignetransferts['bonsortiestock_id']=$id;
                                 $this->Lignebonsortiestock->create();
                                 $this->Lignebonsortiestock->save($Lignetransferts); 
                            
                            
                            
                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$f['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                            
                              }}
                            
				$this->Session->setFlash(__('The bon sortie  has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bon sortie could not be saved. Please, try again.'));
			}
		}
                 $numero = $this->Bonsortiestock->find('all', array('fields' =>
            array(
                'MAX(Bonsortiestock.numero) as num'
                )));
       // debug($numero);die;
        foreach ($numero as $num) {
            $n = $num[0]['num'];
            if (!empty($n)) {
     $commande=$this->Bonsortiestock->find('all', array( 'conditions' => array('Bonsortiestock.numero'=>$n),'recursive'=>-1)) ; 
     //debug($commande);die;
          if($commande[0]['Bonsortiestock']['exercice_id']==date('Y')){      
     $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
          }  else {
              $mm = "000001";
          }
            } else {
                $mm = "000001";
            }
        } 
                $this->loadModel('Article');
                $this->loadModel('Depot');
               // $articles = $this->Article->find('list');
                $depots = $this->Depot->find('list');
               
              
                $depotarrives = $this->Depot->find('list');
		$utilisateurs = $this->Bonsortiestock->Utilisateur->find('list');
		$this->set(compact('utilisateurs','articles','depots','depotarrives','mm'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonsortiestocks') {
                    $x =$liens['edit'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }    
             $this->loadModel('Stockdepot');
            $this->loadModel('Lignebonsortiestock');
		if (!$this->Bonsortiestock->exists($id)) {
			throw new NotFoundException(__('Invalid bonsortiestock'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
		// debug($this->request->data);die;
                    $this->request->data['Bonsortiestock']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonsortiestock']['date'])));
			$this->request->data['Bonsortiestock']['utilisateur_id']= CakeSession::read('users'); 
                        $this->request->data['Bonsortiestock']['exercice_id']=date("Y");
                    
			if ($this->Bonsortiestock->save($this->request->data)) {
                            
                       
                           $lignetransfets= $this->Lignebonsortiestock->find('all',array('conditions'=>array('Lignebonsortiestock.bonsortiestock_id'=>$id),false));
                           //debug($tansfert);die;
                           foreach (  $lignetransfets as $lra   ){
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+'.$lra['Lignebonsortiestock']['quantite']), array('Stockdepot.article_id' =>$lra['Lignebonsortiestock']['article_id'],'Stockdepot.depot_id' =>$lra['Lignebonsortiestock']['depot_id']));
                           } 
                           $this->Lignebonsortiestock->deleteAll(array('Lignebonsortiestock.bonsortiestock_id'=>$id),false);     
                            
                            $Lignebonsortiestocks=array();
                            $stockdepots=array(); 
                              foreach (  $this->request->data['Lignetransfert'] as $numl=>$f   ){
                                  
                              if ($f['sup']!=1){
                                $Lignebonsortiestocks['depot_id']=$f['depot_id'];  
                                $Lignebonsortiestocks['article_id']=$f['article_id'];
                                $Lignebonsortiestocks['quantite']=$f['quantite'];
                                $Lignebonsortiestocks['bonsortiestock_id']=$id;
                                 $this->Lignebonsortiestock->create();
                                 $this->Lignebonsortiestock->save($Lignebonsortiestocks); 
                            
                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $stockdepots[$numl]['quantite']=$stckdepot[0]['Stockdepot']['quantite']-$f['quantite'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $stockdepots[$numl]['quantite']), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                   }
                            
                              }}
				$this->Session->setFlash(__('The bonsortiestock has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bonsortiestock could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Bonsortiestock.' . $this->Bonsortiestock->primaryKey => $id));
			$this->request->data = $this->Bonsortiestock->find('first', $options);
		}
		$this->loadModel('Article');
                $this->loadModel('Depot');
                $lignetransferts = $this->Lignebonsortiestock->find('all',array('conditions'=>array('Lignebonsortiestock.bonsortiestock_id' => $id),'recursive'=>-1));
                //debug($lignetransferts);
                $tabt=array();
                $tabqte=array();
                foreach ($lignetransferts as $i=>$lignetransfert){
                $stckdepotqte= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.depot_id'=>$lignetransfert['Lignebonsortiestock']['depot_id'],'Stockdepot.article_id'=>$lignetransfert['Lignebonsortiestock']['article_id']),'recursive'=>-1));
                foreach ($stckdepotqte as $q=>$qte){
                $tabqte[$i]=$qte['Stockdepot']['quantite'];
                }
                $articless= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.depot_id'=>$lignetransfert['Lignebonsortiestock']['depot_id']),'recursive'=>-1));
                //debug($articless);
                $t='(0,';
                      foreach ($articless as $ad){
                          if(!empty($ad['Stockdepot']['article_id'])){
                          $t=$t.$ad['Stockdepot']['article_id'].',';
                      }}
                $t=$t.'0)';
                $tabt[$i]=$t;      
                // $articles=$this->Article->find('list', array( 'conditions' => array('Article.id in'. $t),'recursive'=>-1)) ;
                }
                //debug($tabt);die;
                //debug($tabqte);
                $depots = $this->Depot->find('list');
                $depotarrives = $this->Depot->find('list');
		$this->set(compact('tabqte','tabt','articless','articles','utilisateurs','articles','depots','depotarrives','mm','transferts','lignetransferts'));
	}


/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
        $lien = CakeSession::read('lien_stock');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'bonsortiestocks') {
                    $x =$liens['delete'];
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }    
            $this->loadModel('Stockdepot');
            $this->loadModel('Lignebonsortiestock');
		$this->Bonsortiestock->id = $id;
		if (!$this->Bonsortiestock->exists()) {
			throw new NotFoundException(__('Invalid bonsortiestock'));
		}
                 $lignetransfets= $this->Lignebonsortiestock->find('all',array('conditions'=>array('Lignebonsortiestock.bonsortiestock_id'=>$id),false));
                           //debug($tansfert);die;
                           foreach (  $lignetransfets as $lra   ){
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 'Stockdepot.quantite+'.$lra['Lignebonsortiestock']['quantite']), array('Stockdepot.article_id' =>$lra['Lignebonsortiestock']['article_id'],'Stockdepot.depot_id' =>$lra['Lignebonsortiestock']['depot_id']));
                           } 
                           $this->Lignebonsortiestock->deleteAll(array('Lignebonsortiestock.bonsortiestock_id'=>$id),false);     
                            
		$this->request->onlyAllow('post', 'delete');
		if ($this->Bonsortiestock->delete()) {
			$this->Session->setFlash(__('Bonsortiestock deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Bonsortiestock was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
