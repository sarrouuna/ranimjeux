<?php
App::uses('AppController', 'Controller');
/**
 * Workflows Controller
 *
 * @property Workflow $Workflow
 */
class WorkflowsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $lien=  CakeSession::read('lien_parametrage');
               $utilisateur="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='workflows'){
                       $utilisateur=1;
                }}}
              if (( $utilisateur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
		$this->Workflow->recursive = 0;
		$this->set('workflows', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
             $lien=  CakeSession::read('lien_parametrage');
               $utilisateur="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='workflows'){
                       $utilisateur=1;
                }}}
              if (( $utilisateur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Typeworkflow');
            $this->loadModel('Personnel');
            $this->loadModel('Ligneworkflow');
		if (!$this->Workflow->exists($id)) {
			throw new NotFoundException(__('Invalid workflow'));
		}
		$options = array('conditions' => array('Workflow.' . $this->Workflow->primaryKey => $id));
		$this->set('workflow', $this->Workflow->find('first', $options));
                $documents = $this->Workflow->Document->find('list');
                $typeworkflows = $this->Typeworkflow->find('list');
                $personnels = $this->Personnel->find('list');
                $ligneworkflows=$this->Ligneworkflow->find('all',array('conditions'=>array('Ligneworkflow.workflow_id' =>$id)));
		$this->set(compact('documents','typeworkflows','personnels','ligneworkflows'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
             $lien=  CakeSession::read('lien_parametrage');
               $utilisateur="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='workflows'){
                       $utilisateur=$liens['add'];
                }}}
              if (( $utilisateur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Typeworkflow');
            $this->loadModel('Personnel');
            $this->loadModel('Ligneworkflow');
		if ($this->request->is('post')) {
                    //debug($this->request->data);die;
			$this->Workflow->create();
			if ($this->Workflow->save($this->request->data)) {
                            $id=$this->Workflow->id;
                        if(!empty($this->request->data['Ligneworkflow'])){    
                        foreach ($this->request->data['Ligneworkflow'] as $l){
                                  if ($l['sup']!=1){
                                  $l['workflow_id']=$id;
                                  $this->Ligneworkflow->create();
                                  $this->Ligneworkflow->save($l);
                                  }
                            }
                        }
				$this->Session->setFlash(__('The workflow has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The workflow could not be saved. Please, try again.'));
			}
		}
		$documents = $this->Workflow->Document->find('list');
                $typeworkflows = $this->Typeworkflow->find('list');
                $personnels = $this->Personnel->find('list');
		$this->set(compact('documents','typeworkflows','personnels'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
             $lien=  CakeSession::read('lien_parametrage');
               $utilisateur="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='workflows'){
                       $utilisateur=$liens['edit'];
                }}}
              if (( $utilisateur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Typeworkflow');
            $this->loadModel('Personnel');
            $this->loadModel('Ligneworkflow');
		if (!$this->Workflow->exists($id)) {
			throw new NotFoundException(__('Invalid workflow'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Workflow->save($this->request->data)) {
                        $this->Ligneworkflow->deleteAll(array('Ligneworkflow.workflow_id'=>$id),false);    
                        if(!empty($this->request->data['Ligneworkflow'])){    
                        foreach ($this->request->data['Ligneworkflow'] as $l){
                                  if ($l['sup']!=1){
                                  $l['workflow_id']=$id;
                                  $this->Ligneworkflow->create();
                                  $this->Ligneworkflow->save($l);
                                  }
                            }
                        }
				$this->Session->setFlash(__('The workflow has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The workflow could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Workflow.' . $this->Workflow->primaryKey => $id));
			$this->request->data = $this->Workflow->find('first', $options);
		}
		$documents = $this->Workflow->Document->find('list');
                $typeworkflows = $this->Typeworkflow->find('list');
                $personnels = $this->Personnel->find('list');
                $ligneworkflows=$this->Ligneworkflow->find('all',array('conditions'=>array('Ligneworkflow.workflow_id' =>$id)));
		$this->set(compact('documents','typeworkflows','personnels','ligneworkflows'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
             $lien=  CakeSession::read('lien_parametrage');
               $utilisateur="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='workflows'){
                       $utilisateur=$liens['delete'];
                }}}
              if (( $utilisateur <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Workflow->id = $id;
		if (!$this->Workflow->exists()) {
			throw new NotFoundException(__('Invalid workflow'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Workflow->delete()) {
			$this->Session->setFlash(__('Workflow deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Workflow was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
