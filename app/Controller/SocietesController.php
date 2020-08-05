<?php
App::uses('AppController', 'Controller');
/**
 * Societes Controller
 *
 * @property Societe $Societe
 */
class SocietesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
              $lien=  CakeSession::read('lien_parametrage');
               $societe="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='societes'){
                        $societe=1;
                }}}
              if (( $societe <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Societe->recursive = 0;
		$this->set('societes', $this->paginate());
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
               $societe="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='societes'){
                        $societe=1;
                }}}
              if (( $societe <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Societe->exists($id)) {
			throw new NotFoundException(__('Invalid societe'));
		}
		$options = array('conditions' => array('Societe.' . $this->Societe->primaryKey => $id));
		$this->set('societe', $this->Societe->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
            $lien=  CakeSession::read('lien_parametrage');
               $societe="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='societes'){
                       $societe=$liens['add'];
                }}}
              if (( $societe <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                $this->loadModel('Client');
                $this->loadModel('Fournisseur');
		if ($this->request->is('post')) {
                    //debug($this->request->data);die;
			$this->Societe->create();
			if ($this->Societe->save($this->request->data)) {
                            $id = $this->Societe->id;
                        $tab['name']=$this->request->data['Societe']['nom'] ; 
                        $tab['societe_id']=$id; 
                        $this->Client->create();
                        if ($this->Client->save($tab)){
                        //debug("client");    
                        }
                        $this->Fournisseur->create();
                        if ($this->Fournisseur->save($tab)){
                        //debug("frs");    
                        }
                        //debug($this->request->data);die;
				$this->Session->setFlash(__('The societe has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The societe could not be saved. Please, try again.'));
			}
		}
        $types[0]="Détail" ;
        $types[1]="Gros" ;
        $this->set(compact('types'));
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
               $societe="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='societes'){
                       $societe=$liens['edit'];
                }}}
              if (( $societe <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Societe->exists($id)) {
			throw new NotFoundException(__('Invalid societe'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    //debug($this->request->data);die;
			if ($this->Societe->save($this->request->data)) {
				$this->Session->setFlash(__('The societe has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The societe could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Societe.' . $this->Societe->primaryKey => $id));
			$this->request->data = $this->Societe->find('first', $options);
                        //debug($this->request->data);die;
		}
        $types[0]="Détail" ;
        $types[1]="Gros" ;
        $this->set(compact('types'));
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
               $societe="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='societes'){
                       $societe=$liens['delete'];
                }}}
              if (( $societe <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Societe->id = $id;
		if (!$this->Societe->exists()) {
			throw new NotFoundException(__('Invalid societe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Societe->delete()) {
			$this->Session->setFlash(__('Societe deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Societe was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        public function testmeres() {
        $this->layout = null;
        $json = null;
        $var = 0;
        $var= $this->Societe->find('count', array('conditions' => array('Societe.mere' => 1)));
        echo json_encode(array('var' => $var));
        die;
    }
}
