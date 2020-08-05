<?php
App::uses('AppController', 'Controller');
/**
 * Productions Controller
 *
 * @property Production $Production
 */
class ProductionsController extends AppController {

	public function index() {
            $this->loadModel('Article');
            $this->loadModel('Depot');
		$this->Production->recursive = 0;
		$this->set('productions', $this->paginate());
                $articles = $this->Article->find('list');
                $depots = $this->Depot->find('list');
		$this->set(compact('articles','depots'));
	}

	public function view($id = null) {
            $this->loadModel('Fichetechnique');
            $this->loadModel('Article');
            $this->loadModel('Ligneproduction');
            $this->loadModel('Depot');
            $this->loadModel('Lignefichetechnique');
            $this->loadModel('Stockdepot');
		if (!$this->Production->exists($id)) {
			throw new NotFoundException(__('Invalid production'));
		}
		$options = array('conditions' => array('Production.' . $this->Production->primaryKey => $id));
		$this->set('production', $this->Production->find('first', $options));$exercices = $this->Production->Exercice->find('list');
		$options = array('conditions' => array('Production.' . $this->Production->primaryKey => $id));
		$this->request->data = $this->Production->find('first', $options);
                $utilisateurs = $this->Production->Utilisateur->find('list');
                $lignefiches=array();
                $nvarticles=array();
                $fichetechnique = $this->Fichetechnique->find('list', array('fields'=>array('Fichetechnique.nvarticle')));
		foreach($fichetechnique as $i=>$f){
                $article= $this->Article->find('first',array('conditions'=>array('Article.id' => $f))); 
                $nvarticles[$article['Article']['id']]= $article['Article']['name'];   
                }
                $depotarrives = $this->Depot->find('list');
                $depots = $this->Depot->find('list');
                $articles = $this->Article->find('list');
                $ligneproductions = $this->Ligneproduction->find('all',array('conditions'=>array('Ligneproduction.production_id' => $id),'order'=>array('Ligneproduction.id'=>'asc'))); 
		$this->set(compact('ligneproductions','mm','articles','depots','article_id','lignefiches','depotarrives','nvarticles','exercices', 'utilisateurs'));
	}

	public function add($article_id=null) {
            $this->loadModel('Fichetechnique');
            $this->loadModel('Article');
            $this->loadModel('Ligneproduction');
            $this->loadModel('Depot');
            $this->loadModel('Lignefichetechnique');
            $this->loadModel('Stockdepot');
		if ($this->request->is('post')) {
                    $this->request->data['Production']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Production']['date'])));
                    $this->request->data['Production']['utilisateur_id']= CakeSession::read('users'); 
                    $this->request->data['Production']['exercice_id']=date("Y");
                    //debug($this->request->data);die;
			$this->Production->create();
			if ($this->Production->save($this->request->data)) {
                            $id=$this->Production->id;
                            $this->misejour("Production","add",$id); 
                            foreach (  $this->request->data['Ligneworkflow'] as $f   ){
                                if ($f['sup']!=1){
                                $f['production_id']=$id;
                                $this->Ligneproduction->create();
                                $this->Ligneproduction->save($f);
                                
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $qte=$stckdepot[0]['Stockdepot']['quantite']-$f['qte'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qte), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                }
                                //$this->stock($f['depot_id'],$f['article_id']);
                                
                                }
                            }
                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$this->request->data['Production']['nvarticle'],'Stockdepot.depot_id'=>$this->request->data['Production']['depotarrive']),false)); 
                            if (!empty($stckdepot)){
                            $qte=$stckdepot[0]['Stockdepot']['quantite']+$this->request->data['Production']['qte'];
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qte), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                            }
                            //$this->stock($this->request->data['Production']['depotarrive'],$this->request->data['Production']['nvarticle']);
				$this->Session->setFlash(__('The production has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The production could not be saved. Please, try again.'));
			}
		}
                $lignefiches=array();
                $nvarticles=array();
                $fichetechnique = $this->Fichetechnique->find('list', array('fields'=>array('Fichetechnique.nvarticle')));
		foreach($fichetechnique as $i=>$f){
                $article= $this->Article->find('first',array('conditions'=>array('Article.id' => $f))); 
                $nvarticles[$article['Article']['id']]= $article['Article']['name'];   
                }
                $depotarrives = $this->Depot->find('list');
                $depots = $this->Depot->find('list');
                $articles = $this->Article->find('list');
		$utilisateurs = $this->Production->Utilisateur->find('list');
                if(!empty($article_id)){
                //debug($article_id);
                $lignefiches = $this->Lignefichetechnique->find('all',array('conditions'=>array('Fichetechnique.nvarticle' => $article_id),'order'=>array('Lignefichetechnique.id'=>'asc'))); 
                //debug($lignefiches);die;
                $numero = $this->Production->find('all', array('fields' =>
                array(
                'MAX(Production.numero) as num')
                ,'conditions' => array('Production.exercice_id'=>date("Y"))));
                foreach ($numero as $num) {
                $n = $num[0]['num'];
                if (!empty($n)) {
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
                } else {
                $mm = "000001";
                }
                } 
                }
		$this->set(compact('mm','articles','depots','article_id','lignefiches','depotarrives','nvarticles','exercices', 'utilisateurs'));
	}

	public function edit($id = null) {
            $this->loadModel('Fichetechnique');
            $this->loadModel('Article');
            $this->loadModel('Ligneproduction');
            $this->loadModel('Depot');
            $this->loadModel('Lignefichetechnique');
            $this->loadModel('Stockdepot');
		if (!$this->Production->exists($id)) {
			throw new NotFoundException(__('Invalid production'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                $ligneproductions = $this->Ligneproduction->find('all',array('conditions'=>array('Ligneproduction.production_id' => $id),'order'=>array('Ligneproduction.id'=>'asc'))); 
                foreach ($ligneproductions as $i=>$l) { 
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$l['Ligneproduction']['article_id'],'Stockdepot.depot_id'=>$l['Ligneproduction']['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $qte=$stckdepot[0]['Stockdepot']['quantite']+$l['Ligneproduction']['qte'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qte), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                }    
                }
                $productions = $this->Production->find('first',array('conditions'=>array('Production.id' => $id)));
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$productions['Production']['nvarticle'],'Stockdepot.depot_id'=>$productions['Production']['depotarrive']),false)); 
                                if (!empty($stckdepot)){
                                $qte=$stckdepot[0]['Stockdepot']['quantite']-$productions['Production']['qte'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qte), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                }
                $this->Ligneproduction->deleteAll(array('Ligneproduction.production_id'=>$id),false); 
                $this->request->data['Production']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Production']['date'])));
			if ($this->Production->save($this->request->data)) {
                            $this->misejour("Production","edit",$id); 
                            foreach (  $this->request->data['Ligneworkflow'] as $f   ){
                                if ($f['sup']!=1){
                                $f['production_id']=$id;
                                $this->Ligneproduction->create();
                                $this->Ligneproduction->save($f);
                                
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$f['article_id'],'Stockdepot.depot_id'=>$f['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $qte=$stckdepot[0]['Stockdepot']['quantite']-$f['qte'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qte), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                }
                                //$this->stock($f['depot_id'],$f['article_id']);
                                }
                            }
                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$this->request->data['Production']['nvarticle'],'Stockdepot.depot_id'=>$this->request->data['Production']['depotarrive']),false)); 
                            if (!empty($stckdepot)){
                            $qte=$stckdepot[0]['Stockdepot']['quantite']+$this->request->data['Production']['qte'];
                            $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qte), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                            }
                            //$this->stock($this->request->data['Production']['depotarrive'],$this->request->data['Production']['nvarticle']);
				$this->Session->setFlash(__('The production has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The production could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Production.' . $this->Production->primaryKey => $id));
			$this->request->data = $this->Production->find('first', $options);
		}
		$exercices = $this->Production->Exercice->find('list');
		$utilisateurs = $this->Production->Utilisateur->find('list');
                $lignefiches=array();
                $nvarticles=array();
                $fichetechnique = $this->Fichetechnique->find('list', array('fields'=>array('Fichetechnique.nvarticle')));
		foreach($fichetechnique as $i=>$f){
                $article= $this->Article->find('first',array('conditions'=>array('Article.id' => $f))); 
                $nvarticles[$article['Article']['id']]= $article['Article']['name'];   
                }
                $depotarrives = $this->Depot->find('list');
                $depots = $this->Depot->find('list');
                $articles = $this->Article->find('list');
                $ligneproductions = $this->Ligneproduction->find('all',array('conditions'=>array('Ligneproduction.production_id' => $id),'order'=>array('Ligneproduction.id'=>'asc'))); 
		$this->set(compact('ligneproductions','mm','articles','depots','article_id','lignefiches','depotarrives','nvarticles','exercices', 'utilisateurs'));
	}

	public function delete($id = null) {
                $this->loadModel('Ligneproduction');
                 $this->loadModel('Stockdepot');
		$this->Production->id = $id;
		if (!$this->Production->exists()) {
			throw new NotFoundException(__('Invalid production'));
		}
		$this->request->onlyAllow('post', 'delete');
                $ligneproductions = $this->Ligneproduction->find('all',array('conditions'=>array('Ligneproduction.production_id' => $id),'order'=>array('Ligneproduction.id'=>'asc'))); 
                foreach ($ligneproductions as $i=>$l) { 
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$l['Ligneproduction']['article_id'],'Stockdepot.depot_id'=>$l['Ligneproduction']['depot_id']),false)); 
                                if (!empty($stckdepot)){
                                $qte=$stckdepot[0]['Stockdepot']['quantite']+$l['Ligneproduction']['qte'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qte), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                }    
                }
                $productions = $this->Production->find('first',array('conditions'=>array('Production.id' => $id)));
                $numansar=$productions['Production']['numero'];
                                $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$productions['Production']['nvarticle'],'Stockdepot.depot_id'=>$productions['Production']['depotarrive']),false)); 
                                if (!empty($stckdepot)){
                                $qte=$stckdepot[0]['Stockdepot']['quantite']-$productions['Production']['qte'];
                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qte), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                }
                $this->Ligneproduction->deleteAll(array('Ligneproduction.production_id'=>$id),false); 
		if ($this->Production->delete()) {
                    $this->misejour("Production",$numansar,$id); 
			$this->Session->setFlash(__('Production deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Production was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
