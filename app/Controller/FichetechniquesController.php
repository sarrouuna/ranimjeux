<?php
App::uses('AppController', 'Controller');
/**
 * Fichetechniques Controller
 *
 * @property Fichetechnique $Fichetechnique
 */
class FichetechniquesController extends AppController {


	public function index() {
            $this->loadModel('Article');
		$this->Fichetechnique->recursive = 0;
		$this->set('fichetechniques', $this->paginate());
                $articles = $this->Article->find('list');
		$this->set(compact('articles'));
	}

	public function view($id = null) {
		$this->loadModel('Article');
            $this->loadModel('Lignefichetechnique');
		if (!$this->Fichetechnique->exists($id)) {
			throw new NotFoundException(__('Invalid fichetechnique'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    debug($this->request->data);die;
                    $this->request->data['Fichetechnique']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Fichetechnique']['date'])));
                    $this->request->data['Fichetechnique']['utilisateur_id']= CakeSession::read('users'); 
			if ($this->Fichetechnique->save($this->request->data)) {
                            $this->Lignefichetechnique->deleteAll(array('Lignefichetechnique.fichetechnique_id'=>$id),false); 
                            foreach (  $this->request->data['Ligneworkflow'] as $numl=>$f   ){
                                  
                              if ($f['sup']!=1){
                                $f['fichetechnique_id']=$id;
                                 $this->Lignefichetechnique->create();
                                 $this->Lignefichetechnique->save($f); 
                              }
                            }
				$this->Session->setFlash(__('The fichetechnique has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fichetechnique could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Fichetechnique.' . $this->Fichetechnique->primaryKey => $id));
			$this->request->data = $this->Fichetechnique->find('first', $options);
		}
                $lignefiches = $this->Lignefichetechnique->find('all',array('conditions'=>array('Lignefichetechnique.fichetechnique_id' => $id),'order'=>array('Lignefichetechnique.id'=>'asc'))); 
                $articles = $this->Article->find('list');
                $nvarticles = $this->Article->find('list');
		$exercices = $this->Fichetechnique->Exercice->find('list');
		$utilisateurs = $this->Fichetechnique->Utilisateur->find('list');
		$this->set(compact('nvarticles','articles', 'exercices', 'utilisateurs','lignefiches'));
	}

	public function add() {
            $this->loadModel('Article');
            $this->loadModel('Lignefichetechnique');
		if ($this->request->is('post')) {
                    //debug($this->request->data);die;
                    $this->request->data['Fichetechnique']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Fichetechnique']['date'])));
                    $this->request->data['Fichetechnique']['utilisateur_id']= CakeSession::read('users'); 
                    $this->request->data['Fichetechnique']['exercice_id']=date("Y");
			$this->Fichetechnique->create();
			if ($this->Fichetechnique->save($this->request->data)) {
                            $id=$this->Fichetechnique->id;
                             $this->misejour("Fichetechnique","add",$id);   
                            foreach (  $this->request->data['Ligneworkflow'] as $f   ){
                                if ($f['sup']!=1){
                                $f['fichetechnique_id']=$id;
                                $this->Lignefichetechnique->create();
                                $this->Lignefichetechnique->save($f); 
                                }
                            }
				$this->Session->setFlash(__('The fichetechnique has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fichetechnique could not be saved. Please, try again.'));
			}
		}
                $numero = $this->Fichetechnique->find('all', array('fields' =>
                array(
                'MAX(Fichetechnique.numero) as num')
                ,'conditions' => array('Fichetechnique.exercice_id'=>date("Y"))));
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
        $articles = $this->Article->find('list',array('conditions'=>array('Article.id <30')));
                $nvarticles = $this->Article->find('list',array('conditions'=>array('Article.id <30')));
		$exercices = $this->Fichetechnique->Exercice->find('list');
		$utilisateurs = $this->Fichetechnique->Utilisateur->find('list');
		$this->set(compact('nvarticles','mm','articles', 'exercices', 'utilisateurs'));
	}

	public function edit($id = null) {
            $this->loadModel('Article');
            $this->loadModel('Lignefichetechnique');
		if (!$this->Fichetechnique->exists($id)) {
			throw new NotFoundException(__('Invalid fichetechnique'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    //debug($this->request->data);die;
                    $this->request->data['Fichetechnique']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Fichetechnique']['date'])));
                    $this->request->data['Fichetechnique']['utilisateur_id']= CakeSession::read('users'); 
			if ($this->Fichetechnique->save($this->request->data)) {
                            $this->misejour("Fichetechnique","edit",$id);   
                            $this->Lignefichetechnique->deleteAll(array('Lignefichetechnique.fichetechnique_id'=>$id),false); 
                            foreach (  $this->request->data['Ligneworkflow'] as $numl=>$f   ){
                                  
                              if ($f['sup']!=1){
                                $f['fichetechnique_id']=$id;
                                 $this->Lignefichetechnique->create();
                                 $this->Lignefichetechnique->save($f); 
                              }
                            }
				$this->Session->setFlash(__('The fichetechnique has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The fichetechnique could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Fichetechnique.' . $this->Fichetechnique->primaryKey => $id));
			$this->request->data = $this->Fichetechnique->find('first', $options);
		}
                $lignefiches = $this->Lignefichetechnique->find('all',array('conditions'=>array('Lignefichetechnique.fichetechnique_id' => $id),'order'=>array('Lignefichetechnique.id'=>'asc'))); 
                $articles = $this->Article->find('list');
                $nvarticles = $this->Article->find('list');
		$exercices = $this->Fichetechnique->Exercice->find('list');
		$utilisateurs = $this->Fichetechnique->Utilisateur->find('list');
		$this->set(compact('nvarticles','articles', 'exercices', 'utilisateurs','lignefiches'));
	}

	public function delete($id = null) {
		$this->Fichetechnique->id = $id;
		if (!$this->Fichetechnique->exists()) {
			throw new NotFoundException(__('Invalid fichetechnique'));
		}
		$this->request->onlyAllow('post', 'delete');
                $abcd = $this->Fichetechnique->find('first', array('conditions' => array('Fichetechnique.id' => $id), 'recursive' => -1));
        $numansar=$abcd['Fichetechnique']['numero'];
		if ($this->Fichetechnique->delete()) {
                    $this->misejour("Fichetechnique",$numansar,$id); 
			$this->Session->setFlash(__('Fichetechnique deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Fichetechnique was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
