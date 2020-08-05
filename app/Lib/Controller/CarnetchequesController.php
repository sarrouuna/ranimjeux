<?php
App::uses('AppController', 'Controller');
/**
 * Carnetcheques Controller
 *
 * @property Carnetcheque $Carnetcheque
 */
class CarnetchequesController extends AppController {

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
                if(@$liens['lien']=='carnetcheques'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
		$this->Carnetcheque->recursive = 0;
		$this->set('carnetcheques', $this->paginate());
	}


	public function view($id = null) {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='carnetcheques'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
            $this->loadModel('Cheque');
            $this->loadModel('Facture');
            $this->loadModel('Piecereglement');
            $this->loadModel('Alimentation');

		if (!$this->Carnetcheque->exists($id)) {
			throw new NotFoundException(__('Invalid carnetcheque'));
		}
		$factures = $this->Facture->find('list',array('fields' => array('Facture.numero')));
                $cheques=$this->Cheque->find('all',array('conditions'=>array('Cheque.carnetcheque_id'=>$id),false));
                $pieces=$this->Piecereglement->find('all',array('conditions'=>array('Piecereglement.carnetcheque_id'=>$id),'recursive'=>2));
                //debug($pieces);die;
                $alimentations=$this->Alimentation->find('all',array('conditions'=>array('Alimentation.carnetcheque_id'=>$id),'recursive'=>0));
                //debug($alimentations);die;
		$options = array('conditions' => array('Carnetcheque.' . $this->Carnetcheque->primaryKey => $id));
		$this->set('carnetcheque', $this->Carnetcheque->find('first', $options));
                $this->set(compact('cheques','pieces','alimentations','factures','id'));
	}
        
        public function imprimer($id = null) {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='carnetcheques'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
            $this->loadModel('Cheque');
            $this->loadModel('Facture');
            $this->loadModel('Piecereglement');
		if (!$this->Carnetcheque->exists($id)) {
			throw new NotFoundException(__('Invalid carnetcheque'));
		}
		$factures = $this->Facture->find('list',array('fields' => array('Facture.numero')));
                $cheques=$this->Cheque->find('all',array('conditions'=>array('Cheque.carnetcheque_id'=>$id),false));
                $pieces=$this->Piecereglement->find('all',array('conditions'=>array('Piecereglement.carnetcheque_id'=>$id),'recursive'=>2));
                //debug($pieces);die;
		$options = array('conditions' => array('Carnetcheque.' . $this->Carnetcheque->primaryKey => $id));
		$this->set('carnetcheque', $this->Carnetcheque->find('first', $options));
                $this->set(compact('cheques','pieces','factures','id'));
	}
        
        public function add() {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='carnetcheques'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
            $this->loadModel('Cheque');
            $this->loadModel('Compte');
		if ($this->request->is('post')) {
                    //debug($this->request->data);die;
			$this->Carnetcheque->create();
                        $debut=$this->request->data['Carnetcheque']['debut'];
                        $taille=$this->request->data['Carnetcheque']['taille'];
                         if (strlen($debut)<$taille){
                        $this->request->data['Carnetcheque']['debut']=str_pad($debut,$taille , "0", STR_PAD_LEFT);
                         }
			if ($this->Carnetcheque->save($this->request->data)) {
                           $id=$this->Carnetcheque->id; 
                           for ($i = $debut; $i <  ($debut+$this->request->data['Carnetcheque']['nombre']); $i++) {
                               
                                $cheque['carnetcheque_id']=$id;
                                $cheque['numero']=str_pad($i, $taille , "0", STR_PAD_LEFT);
                                     $this->Cheque->create();
                                     $this->Cheque->save($cheque); 
                                     
                            }

				$this->Session->setFlash(__('The carnetcheque has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The carnetcheque could not be saved. Please, try again.'));
			}
		}
                $comptess = $this->Compte->find('all');
                foreach ($comptess as $c){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
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
	public function edit($id = null) {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='carnetcheques'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
             $this->loadModel('Cheque');
             $this->loadModel('Compte');
		if (!$this->Carnetcheque->exists($id)) {
			throw new NotFoundException(__('Invalid carnetcheque'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Carnetcheque->save($this->request->data)) {
                            
                                $this->Cheque->deleteAll(array('Cheque.carnetcheque_id'=>$id),false); 
                                   for ($i = $this->request->data['Carnetcheque']['debut']; $i <=  $this->request->data['Carnetcheque']['nombre']; $i++) {

                                        $cheque['carnetcheque_id']=$id;
                                        $cheque['numero']=str_pad($i, $this->request->data['Carnetcheque']['taille'] , "0", STR_PAD_LEFT);
                                             $this->Cheque->create();
                                             $this->Cheque->save($cheque); 

                                    }
                            
				$this->Session->setFlash(__('The carnetcheque has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The carnetcheque could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Carnetcheque.' . $this->Carnetcheque->primaryKey => $id));
			$this->request->data = $this->Carnetcheque->find('first', $options);
		}
                 $comptess = $this->Compte->find('all');
                foreach ($comptess as $c){
                    $comptes[$c['Compte']['id']]=$c['Compte']['banque']."  ".$c['Compte']['rib'];
                }
                $this->set(compact('comptes','mm'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='carnetcheques'){
                        $x=$liens['delete'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
            $this->loadModel('Cheque');
		$this->Carnetcheque->id = $id;
		if (!$this->Carnetcheque->exists()) {
			throw new NotFoundException(__('Invalid carnetcheque'));
		}
		$this->request->onlyAllow('post', 'delete');
                
                  $this->Cheque->deleteAll(array('Cheque.carnetcheque_id'=>$id),false); 
		
                if ($this->Carnetcheque->delete()) {
			$this->Session->setFlash(__('Carnetcheque deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Carnetcheque was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
         public function testnum() {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='carnetcheques'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
            $this->layout = null;
            $data = $this->request->data;
           $numero= $data['numero'];
           $exist=0;
           $Carnet= $this->Carnetcheque->find('first',array('conditions'=>array('Carnetcheque.numero'=>$numero),false)); 
           // debug($Carnet);
           if(!empty($Carnet)){
              $exist=1;
           }
            echo $exist;  
            die;
        }
         public function getnumcheque() {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='carnetcheques'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
            $this->loadModel('Cheque'); 
            $this->layout = null;
            $data = $this->request->data;
            $name='num_piece';
           $carnetcheque_id= $data['carnetcheque_id'];
           $index= $data['index'];
            //debug($carnetcheque_id);
           $cheques= $this->Cheque->find('list',array(
               'fields' => array('Cheque.numero')
               ,'conditions'=>array('Cheque.carnetcheque_id'=>$carnetcheque_id,'Cheque.etat'=>0))); 
            // debug($cheques);
            $select="<select name='data[pieceregelemnt][".$index."][cheque_id]' champ='cheque_id' id='cheque_id".$index."' index='".$index."'  class='form-control select'><option> Veuillez choisir</option>";
            foreach($cheques as $i=>$v){
                $select=$select."<option value=".$i.">".$v."</option>";
            }
            $select=$select.'</select>';
            echo $select;  
            die;
        }
         public function editnumeroachat() {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='carnetcheques'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
            $this->layout = null;
            $data = $this->request->data;
           $piece_id= $data['piece_id'];
           $numeroachat= $data['numeroachat'];
           //debug($piece_id);
          // debug($numeroachat);
           $this->loadModel('Piecereglement');
          
                 //$this->Commande->updateAll(array('Commande.validite_id' =>2), array('Commande.id' =>$id));
              $this->Piecereglement->updateAll(array('Piecereglement.numeroachat' =>$numeroachat), array('Piecereglement.id' =>$piece_id));
           
              $exist=1;
           
            echo $exist;  
            die;
        }
}
