<?php
App::uses('AppController', 'Controller');
/**
 * Fonds Controller
 *
 * @property Fond $Fond
 */
class FondsController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Fond->recursive = 0;
		$this->set('Fonds', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Fond->id = $id;
		if (!$this->Fond->exists()) {
			throw new NotFoundException(__('Invalid Fond'));
		}
		$this->set('Fond', $this->Fond->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Fond->create();
			
			
		 $date1 = explode('/', $this->request->data['Fond']['date']);	
			  $new_dated = $date1[2] . '-' . $date1[1] . '-' . $date1[0];
           
			$this->request->data['Fond']['date']=$new_dated;
			
			if ($this->Fond->save($this->request->data)) {
				$this->redirect(array('action' => 'index'));
			} else {
			}
		}
		$utilisateurs = $this->Fond->Utilisateur->find('list');
		$this->set(compact('utilisateurs'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Fond->id = $id;
		if (!$this->Fond->exists()) {
			throw new NotFoundException(__('Invalid Fond'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Fond->save($this->request->data)) {
$this->redirect(array('action' => 'index'));
			} else {
			}
		} else {
			$this->request->data = $this->Fond->read(null, $id);
		}
		$utilisateurs = $this->Fond->Utilisateur->find('list');
		$this->set(compact('utilisateurs'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Fond->id = $id;
		if (!$this->Fond->exists()) {
			throw new NotFoundException(__('Invalid Fond'));
		}
		if ($this->Fond->delete()) {
			$this->flash(__('Fond deleted'), array('action' => 'index'));
		}
		$this->flash(__('Fond was not deleted'), array('action' => 'index'));
		$this->redirect(array('action' => 'index'));
	}
	
	
	
	public function journee() {
		$this->loadModel('Journee');
		$this->loadModel('Personnel');
		
		if ($this->request->is('post')) {
			$this->Journee->create();
			
		 @$date_debut=date("Y-m-d H:i:s",strtotime(str_replace('/','-',@$this->request->data['Fond']['date_debut'])));      
			$this->request->data['Fond']['date_debut']=$date_debut;
			if($this->request->data['Fond']['date_fin']!='')
	 @$date_fin=date("Y-m-d H:i:s",strtotime(str_replace('/','-',@$this->request->data['Fond']['date_fin'])));    
	 else
	   $date_fin='0000-00-00 00:00:00';
			$this->request->data['Fond']['date_fin']=$date_fin;
			
			if ($this->Journee->save($this->request->data['Fond'])) {
				
 				$journeeid=$this->Journee->id;

				foreach($this->request->data['detail'] as $detail)
				{
				$fond['personnel_id']=$detail['personnel_id'];	
				$fond['journee_id']=$journeeid;	
 if($detail['fond']=='')$fond['etat']=1; else $fond['etat']=0;				$fond['fond']=$detail['fond'];	
				$fond['date']=date("Y-m-d H:i:s",strtotime(str_replace('/','-',@$detail['date'])));  	
								$this->Fond->create();
$this->Fond->save($fond);
				}
				$this->redirect(array('controller'=>'journees','action' => 'index'));
			} else {
			}
		}
		
		$depots = $this->Journee->Depot->find('list');
		$personnels = $this->Personnel->find('all');
		$this->set(compact('depots','personnels'));
	}
	
	function cloture($journeeid=null,$idfond=null,$total=null)
	{
 		$this->Fond->create();
		$jour['etat']=2;
		$jour['id']=$idfond;
		$jour['Total']=$total;
		$this->Fond->save($jour);
			$this->redirect(array('controller'=>'Journees','action' => 'view/'.$journeeid));

	 	
	}
}
