<?php
App::uses('AppController', 'Controller');
/**
 * Etatworkflows Controller
 *
 * @property Etatworkflow $Etatworkflow
 */
class EtatworkflowsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $lien=  CakeSession::read('lien_parametrage');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etatworkflows'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }      
        $this->loadModel('Deviprospect');
        $this->loadModel('Ligneworkflow');
        $this->loadModel('Fournisseur');       
        $this->loadModel('Exercice'); 
        $exe=date('Y');
        $exercice = $this->Exercice->find('first',array('conditions'=>array('Exercice.name'=>$exe)));
        $exerciceid=$exercice['Exercice']['id'];
        $cond4 = 'Deviprospect.exercice_id ='.$exe;
        $exercices = $this->Exercice->find('list');
        
        if (isset($this->request->data) && !empty($this->request->data)) {
       // debug($this->request->data);die;
        if ($this->request->data['Recherche']['exercice_id']) {
            $exerciceid = $this->request->data['Recherche']['exercice_id'];
            $cond4 = 'Deviprospect.exercice_id ='.$exercices[$exerciceid];
        }
        
        if ($this->request->data['Recherche']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            $cond1 = 'Deviprospect.date >= '."'".$date1."'";
            $cond4 ="";
        }
        
        if ($this->request->data['Recherche']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
            $cond2 = 'Deviprospect.date <= '."'".$date2."'";
            $cond4 ="";
        }
        
       if ($this->request->data['Recherche']['fournisseur_id']) {
            $fournisseurid = $this->request->data['Recherche']['fournisseur_id'];
            $cond3 = 'Deviprospect.fournisseur_id ='.$fournisseurid;
        } 
        
    } 
        
        
        
	$deviprospects=$this->Deviprospect->find('all', array( 'conditions' => array('Deviprospect.id > ' => 0,@$cond1, @$cond2, @$cond3,@$cond4 ),'recursive'=>1));
        $ligneworkflowcreation=$this->Ligneworkflow->find('all',array('conditions'=>array('Ligneworkflow.typeworkflow_id'=>1,'Workflow.document_id'=>1),'recursive'=>1));
        $ligneworkflowvalider=$this->Ligneworkflow->find('all',array('conditions'=>array('Ligneworkflow.typeworkflow_id'=>2,'Workflow.document_id'=>1),'recursive'=>1));
        $ligneworkflowtransformation=$this->Ligneworkflow->find('all',array('conditions'=>array('Ligneworkflow.typeworkflow_id'=>3,'Workflow.document_id'=>1),'recursive'=>1));
        $fournisseurs = $this->Fournisseur->find('list');
        $ligneworkflows=$this->Ligneworkflow->find('all',array('conditions'=>array('Ligneworkflow.workflow_id' =>1),'order'=>array('Ligneworkflow.typeworkflow_id'=>'asc')));
        //debug($ligneworkflows);
        $this->set(compact('ligneworkflows','exerciceid','fournisseurs','exercices','deviprospects','ligneworkflowcreation','ligneworkflowtransformation','ligneworkflowvalider',$this->paginate()));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Etatworkflow->exists($id)) {
			throw new NotFoundException(__('Invalid etatworkflow'));
		}
		$options = array('conditions' => array('Etatworkflow.' . $this->Etatworkflow->primaryKey => $id));
		$this->set('etatworkflow', $this->Etatworkflow->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Etatworkflow->create();
			if ($this->Etatworkflow->save($this->request->data)) {
				$this->Session->setFlash(__('The etatworkflow has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatworkflow could not be saved. Please, try again.'));
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
		if (!$this->Etatworkflow->exists($id)) {
			throw new NotFoundException(__('Invalid etatworkflow'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Etatworkflow->save($this->request->data)) {
				$this->Session->setFlash(__('The etatworkflow has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etatworkflow could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Etatworkflow.' . $this->Etatworkflow->primaryKey => $id));
			$this->request->data = $this->Etatworkflow->find('first', $options);
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
		$this->Etatworkflow->id = $id;
		if (!$this->Etatworkflow->exists()) {
			throw new NotFoundException(__('Invalid etatworkflow'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Etatworkflow->delete()) {
			$this->Session->setFlash(__('Etatworkflow deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Etatworkflow was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
