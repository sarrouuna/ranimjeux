<?php
App::uses('AppController', 'Controller');
/**
 * Variationtauxdechanges Controller
 *
 * @property Variationtauxdechange $Variationtauxdechange
 */
class VariationtauxdechangesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $this->loadModel('Fournisseur');
        if (isset($this->request->data) && !empty($this->request->data)) {
        //debug($this->request->data);die;
        if ($this->request->data['Deviprospect']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Deviprospect']['date1'])));
            $cond1 = 'Variationtauxdechange.date >= '."'".$date1."'";
        }
        
        if ($this->request->data['Deviprospect']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Deviprospect']['date2'])));
            $cond2 = 'Variationtauxdechange.date <= '."'".$date2."'";
        }
        
       if ($this->request->data['Deviprospect']['fournisseur_id']) {
            $fournisseurid = $this->request->data['Deviprospect']['fournisseur_id'];
            $cond3 = 'Variationtauxdechange.fournisseur_id ='.$fournisseurid;
        } 
        if (isset($this->request->data['Deviprospect']['importation_id'])) {
            $importationid = $this->request->data['Deviprospect']['importation_id'];
            $cond4 = 'Variationtauxdechange.importation_id ='.$importationid;
        } 
        
       }     
//		$this->Variationtauxdechange->recursive = 0;
//                $this->Variationtauxdechange->conditions=array(@$cond1, @$cond2, @$cond3, @$cond4);
//		$this->set('variationtauxdechanges', $this->paginate());
        $variationtauxdechanges = $this->Variationtauxdechange->find('all',array('conditions'=>array('Variationtauxdechange.montant <> 0',@$cond1, @$cond2, @$cond3, @$cond4),'recursive'=>0));  //debug($piecesreg);die;
        $fournisseurs = $this->Fournisseur->find('list');
        $this->set(compact('importationid','fournisseurid','date2','date1','variationtauxdechanges','fournisseurs','exercices', $this->paginate()));
	}
        
        
        
        public function imprimerrecherche() { 
        $this->loadModel('Fournisseur');
        $this->loadModel('Importation');
        if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
            $cond1 = 'Variationtauxdechange.date >= '."'".$date1."'";
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
            $cond2 = 'Variationtauxdechange.date <= '."'".$date2."'";
        }
        
       if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $cond3 = 'Variationtauxdechange.fournisseur_id ='.$fournisseurid;
        } 
        if ($this->request->query['importationid']) {
            $importationid = $this->request->query['importationid'];
            $cond4 = 'Variationtauxdechange.importation_id ='.$importationid;
        }
       
        
        $variationtauxdechanges = $this->Variationtauxdechange->find('all',array('conditions'=>array(@$cond1, @$cond2, @$cond3, @$cond4),'recursive'=>0));  //debug($piecesreg);die;
        $fournisseurs = $this->Fournisseur->find('list');
        $importations = $this->Importation->find('list');
        $this->set(compact('importationid','fournisseurid','date2','date1','variationtauxdechanges','fournisseurs','importations'));
   
         }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Variationtauxdechange->exists($id)) {
			throw new NotFoundException(__('Invalid variationtauxdechange'));
		}
		$options = array('conditions' => array('Variationtauxdechange.' . $this->Variationtauxdechange->primaryKey => $id));
		$this->set('variationtauxdechange', $this->Variationtauxdechange->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Variationtauxdechange->create();
			if ($this->Variationtauxdechange->save($this->request->data)) {
				$this->Session->setFlash(__('The variationtauxdechange has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The variationtauxdechange could not be saved. Please, try again.'));
			}
		}
		$reglements = $this->Variationtauxdechange->Reglement->find('list');
		$fournisseurs = $this->Variationtauxdechange->Fournisseur->find('list');
		$importations = $this->Variationtauxdechange->Importation->find('list');
		$this->set(compact('reglements', 'fournisseurs', 'importations'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Variationtauxdechange->exists($id)) {
			throw new NotFoundException(__('Invalid variationtauxdechange'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Variationtauxdechange->save($this->request->data)) {
				$this->Session->setFlash(__('The variationtauxdechange has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The variationtauxdechange could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Variationtauxdechange.' . $this->Variationtauxdechange->primaryKey => $id));
			$this->request->data = $this->Variationtauxdechange->find('first', $options);
		}
		$reglements = $this->Variationtauxdechange->Reglement->find('list');
		$fournisseurs = $this->Variationtauxdechange->Fournisseur->find('list');
		$importations = $this->Variationtauxdechange->Importation->find('list');
		$this->set(compact('reglements', 'fournisseurs', 'importations'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Variationtauxdechange->id = $id;
		if (!$this->Variationtauxdechange->exists()) {
			throw new NotFoundException(__('Invalid variationtauxdechange'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Variationtauxdechange->delete()) {
			$this->Session->setFlash(__('Variationtauxdechange deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Variationtauxdechange was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
