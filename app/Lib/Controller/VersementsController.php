<?php
App::uses('AppController', 'Controller');
/**
 * Versements Controller
 *
 * @property Versement $Versement
 */
class VersementsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='versements'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Versement->recursive = 0;
		$this->set('versements', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Versement->exists($id)) {
			throw new NotFoundException(__('Invalid versement'));
		}
		$options = array('conditions' => array('Versement.' . $this->Versement->primaryKey => $id));
		$this->set('versement', $this->Versement->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='versements'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Compte');
		if ($this->request->is('post')) {
                        $this->request->data['Versement']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Versement']['date'])));
			$this->request->data['Versement']['utilisateur_id']= CakeSession::read('users');
			$this->Versement->create();
			if ($this->Versement->save($this->request->data)) {
				$this->Session->setFlash(__('The versement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The versement could not be saved. Please, try again.'));
			}
		}
                
                $comptess = $this->Compte->find('all');
                foreach ($comptess as $c){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                }
        $numero = $this->Versement->find('all', array('fields' =>
            array(
                'MAX(Versement.numero) as num'
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
		$this->set(compact('comptes','mm'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function valider($id = null) {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='versements'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Compte');
		if (!$this->Versement->exists($id)) {
			throw new NotFoundException(__('Invalid versement'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                        $this->request->data['Versement']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Versement']['date'])));
			$this->request->data['Versement']['utilisateur_id']= CakeSession::read('users');
			$this->request->data['Versement']['etat']= 1;
			if ($this->Versement->save($this->request->data)) {
				$this->Session->setFlash(__('The versement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The versement could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Versement.' . $this->Versement->primaryKey => $id));
			$this->request->data = $this->Versement->find('first', $options);
		}
		$utilisateurs = $this->Versement->Utilisateur->find('list');
                $comptess = $this->Compte->find('all');
                foreach ($comptess as $c){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                }
                $date=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Versement']['date'])));
                $this->set(compact('utilisateurs', 'comptes','date'));
	}

        public function edit($id = null) {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='versements'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Compte');
		if (!$this->Versement->exists($id)) {
			throw new NotFoundException(__('Invalid versement'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                        $this->request->data['Versement']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Versement']['date'])));
			$this->request->data['Versement']['utilisateur_id']= CakeSession::read('users');
			if ($this->Versement->save($this->request->data)) {
				$this->Session->setFlash(__('The versement has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The versement could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Versement.' . $this->Versement->primaryKey => $id));
			$this->request->data = $this->Versement->find('first', $options);
		}
		$utilisateurs = $this->Versement->Utilisateur->find('list');
                $comptess = $this->Compte->find('all');
                foreach ($comptess as $c){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                }
                $date=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Versement']['date'])));
                $this->set(compact('utilisateurs', 'comptes','date'));
	}
        
	public function delete($id = null) {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='versements'){
                        $x=$liens['delete'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Versement->id = $id;
		if (!$this->Versement->exists()) {
			throw new NotFoundException(__('Invalid versement'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Versement->delete()) {
			$this->Session->setFlash(__('Versement deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Versement was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
