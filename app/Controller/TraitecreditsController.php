<?php
App::uses('AppController', 'Controller');
/**
 * Traitecredits Controller
 *
 * @property Traitecredit $Traitecredit
 */
class TraitecreditsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
                $traitecredits = $this->Traitecredit->find('all',array('group'=>array('Traitecredit.piecereglement_id'),'recursive'=>0));
		//debug($traitecredits);
                $this->set(compact('traitecredits'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->loadModel('Piecereglement');
            $this->loadModel('Traitecredit');	
            $this->loadModel('Situationpiecereglement');
		$reglements = $this->Traitecredit->Reglement->find('list');
		$piecereglements = $this->Traitecredit->Piecereglement->find('list');
		$fournisseurs = $this->Traitecredit->Fournisseur->find('list');
		$importations = $this->Traitecredit->Importation->find('list');
		$this->set(compact('id','reglements', 'piecereglements', 'fournisseurs', 'importations'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Traitecredit->create();
			if ($this->Traitecredit->save($this->request->data)) {
				$this->Session->setFlash(__('The traitecredit has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The traitecredit could not be saved. Please, try again.'));
			}
		}
		$reglements = $this->Traitecredit->Reglement->find('list');
		$piecereglements = $this->Traitecredit->Piecereglement->find('list');
		$fournisseurs = $this->Traitecredit->Fournisseur->find('list');
		$importations = $this->Traitecredit->Importation->find('list');
		$this->set(compact('reglements', 'piecereglements', 'fournisseurs', 'importations'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
            $this->loadModel('Piecereglement');
            $this->loadModel('Traitecredit');	
            $this->loadModel('Situationpiecereglement');
		if ($this->request->is('post') || $this->request->is('put')) {
                 //debug($this->request->data['Traitecredit']['0']['nbrmoins']); 
                 //debug($this->request->data);die;
                 $piecereglement_id=$id;
                 $traitecredits = $this->Traitecredit->find('all',array('conditions'=>array('Traitecredit.piecereglement_id' => $piecereglement_id)));
                 foreach($traitecredits as $t){
                 $this->Piecereglement->deleteAll(array('Piecereglement.traitecredit_id' => $t['Traitecredit']['id']), false);
                 }
                 $this->Piecereglement->updateAll(array('Piecereglement.credit' =>0), array('Piecereglement.id' =>$piecereglement_id));
                 $piecesreg = $this->Piecereglement->find('first',array('conditions'=>array('Piecereglement.id' => $piecereglement_id)));
                 if(!empty($this->request->data['credits'][0])){    
                            foreach($this->request->data['credits'][0]['traitecredits']as $t=>$credit){
                            $credit['reglement_id']= $piecesreg['Piecereglement']['reglement_id'];
                            $credit['piecereglement_id']= $piecereglement_id;
                            $credit['fournisseur_id']=$piecesreg['Reglement']['fournisseur_id'];
                            $credit['importation_id']=$piecesreg['Piecereglement']['importation_id'];
                            $credit['echancecredit']=date("Y-m-d",strtotime(str_replace('/','-',$credit['echancecredit']))); 
                            $this->Traitecredit->create();
                            $this->Traitecredit->save($credit);
                            $credit['id']=$this->Traitecredit->id; 
                            $piece['reglement_id']=$piecesreg['Piecereglement']['reglement_id'];
                            $piece['paiement_id']=7;
                            $piece['montant']=$credit['montantcredit'];
                            $piece['date']=date("Y-m-d");
                            $piece['num']=$credit['num_piececredit'];
                            $piece['echance']=date("Y-m-d",strtotime(str_replace('/','-',$credit['echancecredit'])));
                            $piece['compte_id']=$piecesreg['Piecereglement']['compte_id'];
                            $piece['situation']="En attente";
                            $piece['etatpiecereglement_id']=1;
                            $piece['traitecredit_id']=$credit['id'];
                            $this->Piecereglement->create();
                            $this->Piecereglement->save($piece);
                            
                            }
                            $this->Piecereglement->updateAll(array('Piecereglement.credit' =>1), array('Piecereglement.id' =>$piecereglement_id));
                            $this->Situationpiecereglement->updateAll(array('Situationpiecereglement.nbrmoins' =>$this->request->data['Traitecredit']['0']['nbrmoins']), array('Situationpiecereglement.etatpiecereglement_id' =>9,'Situationpiecereglement.piecereglement_id' => $id));
                            
                            }
                            $this->redirect(array('controller' => 'traitecredits','action' => 'index'));	
		} 
		$reglements = $this->Traitecredit->Reglement->find('list');
		$piecereglements = $this->Traitecredit->Piecereglement->find('list');
		$fournisseurs = $this->Traitecredit->Fournisseur->find('list');
		$importations = $this->Traitecredit->Importation->find('list');
		$this->set(compact('id','reglements', 'piecereglements', 'fournisseurs', 'importations'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Traitecredit->id = $id;
		if (!$this->Traitecredit->exists()) {
			throw new NotFoundException(__('Invalid traitecredit'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Traitecredit->delete()) {
			$this->Session->setFlash(__('Traitecredit deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Traitecredit was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
