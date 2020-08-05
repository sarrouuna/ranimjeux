<?php
App::uses('AppController', 'Controller');
/**
 * Ordres Controller
 *
 * @property Ordre $Ordre
 */
class OrdresController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Ordre->recursive = 0;
		$this->set('ordres', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
             $this->loadModel('Facture');
		if (!$this->Ordre->exists($id)) {
			throw new NotFoundException(__('Invalid ordre'));
		}
		$options = array('conditions' => array('Ordre.' . $this->Ordre->primaryKey => $id));
		$this->set('ordre', $this->Ordre->find('first', $options));
                 $factures = $this->Facture->find('all', array( 'conditions' => array('Facture.ordre_id =' => $id)  ,'order'=>array('Facture.date'=>'asc'))); //debug($factures);
		$this->set(compact('factures'));
	}

        
        
        
        public function imprimer($id = null) {
             $this->loadModel('Facture');
		if (!$this->Ordre->exists($id)) {
			throw new NotFoundException(__('Invalid ordre'));
		}
		$options = array('conditions' => array('Ordre.' . $this->Ordre->primaryKey => $id));
		$this->set('ordre', $this->Ordre->find('first', $options));
                 $factures = $this->Facture->find('all', array( 'conditions' => array('Facture.ordre_id =' => $id)  ,'order'=>array('Facture.date'=>'asc'))); //debug($factures);
		$this->set(compact('factures'));
	}
        
	public function add() {
             $this->loadModel('Facture');
		if ($this->request->is('post')) {
                      // debug($this->request->data);die;
                    if($this->request->data['Ordre']['Montant']!=''){
                         // debug($this->request->data);die;
                        $this->request->data['Ordre']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Ordre']['date'])));
			$this->Ordre->create();
			if ($this->Ordre->save($this->request->data)) {
                                $id=$this->Ordre->id;
                                foreach ($this->request->data['Facture'] as $f){
                                    if (@$f['ok']==1){
                                           $this->Facture->updateAll(array('Facture.ordre_id' =>$id), array('Facture.id' =>$f['id']));  
                                        }
                                }
				$this->Session->setFlash(__('The ordre has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ordre could not be saved. Please, try again.'));
			}
                    }else{
                        $show=1;
                    }    
		}
                 //debug($this->request->data);die;
          if(!empty($this->request->data)){//debug($this->request->data);die;
                if($this->request->data['Ordre']['Date_deb'] != '__/__/____'){
                $date_debut=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Ordre']['Date_deb'])));
                    $cond='Facture.date>='."'".$date_debut."'";
                
                    }
                     if($this->request->data['Ordre']['Date_fn'] != '__/__/____'){
                $date_fin=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Ordre']['Date_fn'])));
                    $cond1='Facture.date<='."'".$date_fin."'";
                }
                 if($this->request->data['Ordre']['fournisseur_id']){
                    $fournisseur_id=$this->request->data['Ordre']['fournisseur_id'];
                    $cond2="Facture.fournisseur_id='".$fournisseur_id."'";
                    }
                    $zero=0;
                    $cond3="Facture.ordre_id='".$zero."'";

             $factures = $this->Facture->find('all', array( 'conditions' => array('Facture.id > ' => 0, @$cond, @$cond1,@$cond2,$cond3,'Facture.totalttc>(Facture.Montant_Regler)')  ,'order'=>array('Facture.date'=>'asc'))); //debug($piecereglements);

                      // debug($factures);die;
          }
           $numero = $this->Ordre->find('all', array('fields' =>
            array(
                'MAX(Ordre.numero) as num'
                )));
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
		$fournisseurs = $this->Ordre->Fournisseur->find('list');
		$utilisateurs = $this->Ordre->Utilisateur->find('list');
		$this->set(compact('show','fournisseurs', 'utilisateurs','factures','mm'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
             $this->loadModel('Facture');
		if (!$this->Ordre->exists($id)) {
			throw new NotFoundException(__('Invalid ordre'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Ordre->save($this->request->data)) {
                             foreach ($this->request->data['Facture'] as $f){
                                    if (@$f['ok']==1){
                                           $this->Facture->updateAll(array('Facture.ordre_id' =>0), array('Facture.id' =>$f['id']));  
                                        }
                                }
				$this->Session->setFlash(__('The ordre has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The ordre could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Ordre.' . $this->Ordre->primaryKey => $id));
			$this->request->data = $this->Ordre->find('first', $options);
		}
                $ordre = $this->Ordre->find('first', array( 'conditions' => array('Ordre.id' => $id))); //debug($piecereglements);
                $factures = $this->Facture->find('all', array( 'conditions' => array('Facture.ordre_id =' => $id)  ,'order'=>array('Facture.date'=>'asc'))); //debug($factures);
		$fournisseurs = $this->Ordre->Fournisseur->find('list');
		$utilisateurs = $this->Ordre->Utilisateur->find('list');
		$this->set(compact('fournisseurs', 'utilisateurs','factures','ordre'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
             $this->loadModel('Facture');
		$this->Ordre->id = $id;
		if (!$this->Ordre->exists()) {
			throw new NotFoundException(__('Invalid ordre'));
		}
		$this->request->onlyAllow('post', 'delete');
                $factures = $this->Facture->find('all', array( 'conditions' => array('Facture.ordre_id =' => $id))); //debug($factures);
		 foreach ($factures as $f){
                                   
                                      $this->Facture->updateAll(array('Facture.ordre_id' =>0), array('Facture.id' =>$f['Facture']['id']));  
                                }
                
                if ($this->Ordre->delete()) {
			$this->Session->setFlash(__('Ordre deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Ordre was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
