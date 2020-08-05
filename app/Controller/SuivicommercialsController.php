<?php
App::uses('AppController', 'Controller');
/**
 * Suivicommercials Controller
 *
 * @property Suivicommercial $Suivicommercial
 */
class SuivicommercialsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $this->loadModel('Typesuivitdevi');    
	if ((isset($this->request->data) && !empty($this->request->data))||(( in_array(CakeSession::read('view'),Array("edit","view","delete")))&&(CakeSession::read('Controller') =="Suivicommercial"))) {
            if ((isset($this->request->data) && !empty($this->request->data))||((! in_array(CakeSession::read('view'),Array("edit","view","delete"))))) {
            CakeSession::write('recherche',$this->request->data['Recherche']);
            }else{
            $this->request->data['Recherche']=CakeSession::read('recherche');    
            }
            // debug($this->request->data);die;
            if (($this->request->data['Recherche']['date1'] != "__/__/____")&&(!empty($this->request->data['Recherche']['date1']))) {
                $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
                $cond1 = 'Suivicommercial.date >= ' . "'" . $date1 . "'";
            }

            if (($this->request->data['Recherche']['date2'] != "__/__/____")&&(!empty($this->request->data['Recherche']['date2']))) {
                $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
                $cond2 = 'Suivicommercial.date <= ' . "'" . $date2 . "'";
            }
            if ($this->request->data['Recherche']['typesuivitdevi_id']) {
                $typesuivitdevi_id = $this->request->data['Recherche']['typesuivitdevi_id'];
                $cond3 = 'Devi.typesuivitdevi_id =' . $typesuivitdevi_id;
            }
        }
        $suivicommercials = $this->Suivicommercial->find('all', array('conditions' => array(@$cond1, @$cond2,@$cond3)
        ,'order' => array('Suivicommercial.id' => 'desc')));
        $typesuivitdevis = $this->Typesuivitdevi->find('list');
        $this->set(compact('date1','date2','suivicommercials','typesuivitdevis','typesuivitdevi_id'));
	}
        
        public function exp_etatexcel() {
        $this->loadModel('Typesuivitdevi');    
        $this->layout=null;
        if (!empty($this->request->query['date1'])) {
            $date1 = $this->request->query['date1'];
            $cond1 = 'Suivicommercial.date >= ' . "'" . $date1 . "'";
        }

        if (!empty($this->request->query['date2'])) {
            $date2 = $this->request->query['date2'];
            $cond2 = 'Suivicommercial.date <= ' . "'" . $date2 . "'";
        }
        if (!empty($this->request->query['typesuivitdevi_id'])) {
            $typesuivitdevi_id = $this->request->query['typesuivitdevi_id'];
            $cond3 = 'Devi.typesuivitdevi_id =' . $typesuivitdevi_id;
        }

        

        $suivicommercials = $this->Suivicommercial->find('all', array('conditions' => array( @$cond1, @$cond2,@$cond3)));
        $typesuivitdevis = $this->Typesuivitdevi->find('list');
        $this->set(compact('suivicommercials', 'date1', 'date2','typesuivitdevi_id','typesuivitdevis'));
    }
        
        
        
        


	public function view($id = null) {
		if (!$this->Suivicommercial->exists($id)) {
			throw new NotFoundException(__('Invalid suivicommercial'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                   // debug($this->request->data);die;
            $this->request->data['Suivicommercial']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Suivicommercial']['date'])));
            if($this->request->data['Suivicommercial']['daterecu'] !="__/__/____"){
            $this->request->data['Suivicommercial']['daterecu'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Suivicommercial']['daterecu'])));
            }else{
            $this->request->data['Suivicommercial']['daterecu'] ="" ;   
            }
            if($this->request->data['Suivicommercial']['dateinstallation'] !="__/__/____"){
            $this->request->data['Suivicommercial']['dateinstallation'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Suivicommercial']['dateinstallation'])));
            }else{
            $this->request->data['Suivicommercial']['dateinstallation'] = ""  ;  
            }
            if ($this->Suivicommercial->save($this->request->data)) {
				$this->Session->setFlash(__('The suivicommercial has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The suivicommercial could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Suivicommercial.' . $this->Suivicommercial->primaryKey => $id));
			$this->request->data = $this->Suivicommercial->find('first', $options);
		}
		$statusuivis = $this->Suivicommercial->Statusuivi->find('list');
		$inclusuivis = $this->Suivicommercial->Inclusuivi->find('list');
		$devis = $this->Suivicommercial->Devi->find('list');
		$this->set(compact('statusuivis', 'inclusuivis', 'devis'));
	}


	public function add() {
		if ($this->request->is('post')) {
			$this->Suivicommercial->create();
			if ($this->Suivicommercial->save($this->request->data)) {
				$this->Session->setFlash(__('The suivicommercial has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The suivicommercial could not be saved. Please, try again.'));
			}
		}
		$statusuivis = $this->Suivicommercial->Statusuivi->find('list');
		$inclusuivis = $this->Suivicommercial->Inclusuivi->find('list');
		$devis = $this->Suivicommercial->Devi->find('list');
		$this->set(compact('statusuivis', 'inclusuivis', 'devis'));
	}


	public function edit($id = null) {
		if (!$this->Suivicommercial->exists($id)) {
			throw new NotFoundException(__('Invalid suivicommercial'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                   // debug($this->request->data);die;
            $this->request->data['Suivicommercial']['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Suivicommercial']['date'])));
            if($this->request->data['Suivicommercial']['daterecu'] !="__/__/____"){
            $this->request->data['Suivicommercial']['daterecu'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Suivicommercial']['daterecu'])));
            }else{
            $this->request->data['Suivicommercial']['daterecu'] ="" ;   
            }
            if($this->request->data['Suivicommercial']['dateinstallation'] !="__/__/____"){
            $this->request->data['Suivicommercial']['dateinstallation'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Suivicommercial']['dateinstallation'])));
            }else{
            $this->request->data['Suivicommercial']['dateinstallation'] = ""  ;  
            }
            if ($this->Suivicommercial->save($this->request->data)) {
				$this->Session->setFlash(__('The suivicommercial has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The suivicommercial could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Suivicommercial.' . $this->Suivicommercial->primaryKey => $id));
			$this->request->data = $this->Suivicommercial->find('first', $options);
		}
		$statusuivis = $this->Suivicommercial->Statusuivi->find('list');
		$inclusuivis = $this->Suivicommercial->Inclusuivi->find('list');
		$devis = $this->Suivicommercial->Devi->find('list');
		$this->set(compact('statusuivis', 'inclusuivis', 'devis'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Suivicommercial->id = $id;
		if (!$this->Suivicommercial->exists()) {
			throw new NotFoundException(__('Invalid suivicommercial'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Suivicommercial->delete()) {
			$this->Session->setFlash(__('Suivicommercial deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Suivicommercial was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
