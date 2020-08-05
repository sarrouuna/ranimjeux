<?php
App::uses('AppController', 'Controller');
/**
 * Clients Controller
 *
 * @property Client $Client
 */
class ClientsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
            $lien=  CakeSession::read('lien_vente');
               $client="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='clients'){
                        $client=1;
                }}}
              if (( $client <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Client->recursive = 0;
		$this->set('clients', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
             $lien=  CakeSession::read('lien_vente');
               $client="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='clients'){
                        $client=1;
                }}}
              if (( $client <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
              $this->loadModel('Contact');
		if (!$this->Client->exists($id)) {
			throw new NotFoundException(__('Invalid client'));
		}
		$options = array('conditions' => array('Client.' . $this->Client->primaryKey => $id));
		$this->set('client', $this->Client->find('first', $options));
                $contacts=$this->Contact->find('all',array('conditions'=>array('Contact.client_id' => $id)));
		$this->set(compact('contacts'));
	}
         public function imprimerimagerib($id= null) {
             $lien=  CakeSession::read('lien_vente');
               $client="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='clients'){
                        $client=$liens['imprimer'];
                }}}
              if (( $client <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
            }
             $client=$this->Client->find('first',array('conditions'=>array('Client.id' => $id)));
             $this->set(compact('client'));
          }
       public function imprimerimageRC($id= null) {
            $lien=  CakeSession::read('lien_vente');
               $client="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='clients'){
                        $client=$liens['imprimer'];
                }}}
              if (( $client <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
            }
             $client=$this->Client->find('first',array('conditions'=>array('Client.id' => $id)));
             $this->set(compact('client'));
          }
       public function imprimerimagePatente($id= null) {
            $lien=  CakeSession::read('lien_vente');
               $client="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='clients'){
                        $client=$liens['imprimer'];
                }}}
              if (( $client <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
            }
             $client=$this->Client->find('first',array('conditions'=>array('Client.id' => $id)));
             $this->set(compact('client'));
          }
/**
 * add method
 *
 * @return void
 */
	public function add() {
              $lien=  CakeSession::read('lien_vente');
               $client="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='clients'){
                        $client=$liens['add'];
                }}}
              if (( $client <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
              $this->loadModel('Contact');
              $this->loadModel('Typeclient');
              $this->loadModel('Modeclient');
              
		if ($this->request->is('post')) {
			$this->Client->create();
                        $this->request->data['Client']['sousfamilleclient_id']= @$this->request->data['sousfamilleclient_id'];
			if(empty($this->request->data['Client']['photorib']['name'])){
                            $this->request->data['Client']['photorib']="";
                        }
                        if(empty($this->request->data['Client']['registrecommercef']['name'])){
                            $this->request->data['Client']['registrecommercef']="";
                        }
                        if(empty($this->request->data['Client']['patente']['name'])){
                            $this->request->data['Client']['patente']="";
                        }
                        if ($this->Client->save($this->request->data)) {
                            $id=$this->Client->id;
                            if(!empty($this->request->data['Contact'])) {   
                                foreach (  $this->request->data['Contact'] as $contact   ){
                                  if ($contact['sup']!=1){
                                   if ($contact['name']!=""){   
                                  $contact['client_id']=$id;
                                  $this->Contact->create();
                                  $this->Contact->save($contact);
                                   }
                                  }
                                }
                            }
                            
				$this->Session->setFlash(__('The client has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client could not be saved. Please, try again.'));
			}
		}
		$familleclients = $this->Client->Familleclient->find('list');
		$sousfamilleclients = $this->Client->Sousfamilleclient->find('list');
		$zones = $this->Client->Zone->find('list');
                $personnels = $this->Client->Personnel->find('list');
                $typeclients = $this->Typeclient->find('list');
                $modeclients = $this->Modeclient->find('list');
		$this->set(compact('modeclients','typeclients','personnels','familleclients', 'sousfamilleclients', 'zones'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
            $lien=  CakeSession::read('lien_vente');
               $client="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='clients'){
                        $client=$liens['edit'];
                }}}
              if (( $client <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Client->exists($id)) {
			throw new NotFoundException(__('Invalid client'));
		}
              $this->loadModel('Contact');
              $this->loadModel('Typeclient');
              $this->loadModel('Modeclient');
              
                $client=$this->Client->find('first',array('conditions'=>array('Client.id' => $id)));
                $familleclientid=$client['Familleclient']['id'];
		if ($this->request->is('post') || $this->request->is('put')) {
                    
                   //debug($this->request->data);die;            
                     if($this->request->data['Client']['familleclient_id']!= $familleclientid){
                        if ($this->request->data['Client']['sousfamilleclient_id']!= @$this->request->data['sousfamilleclient_id']) {
                            $this->request->data['Client']['sousfamilleclient_id']='';
                            if(@$this->request->data['sousfamilleclient_id']!=0){
                            $this->request->data['Client']['sousfamilleclient_id']= @$this->request->data['sousfamilleclient_id'] ;
                          }
                        }
                     }
                        if(empty($this->request->data['Client']['photorib']['name'])){
                            $this->request->data['Client']['photorib']="";
                        }
                        if(empty($this->request->data['Client']['registrecommercef']['name'])){
                            $this->request->data['Client']['registrecommercef']="";
                        }
                        if(empty($this->request->data['Client']['patente']['name'])){
                            $this->request->data['Client']['patente']="";
                        }                    
                    
			if ($this->Client->save($this->request->data)) {
                            
                        if(!empty($this->request->data['Contact'])) {   
                              foreach (  $this->request->data['Contact'] as $contact   ){
                                  if ($contact['sup']!=1){
                                  if ($contact['name']!=""){     
                                  $contact['client_id']=$id;
                                  $this->Contact->create();
                                  $this->Contact->save($contact);
                                  }}else {
                               $this->Contact->deleteAll(array('Contact.id'=>$contact['id']),false); 
                              }
                                }
                        }
				$this->Session->setFlash(__('The client has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The client could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Client.' . $this->Client->primaryKey => $id));
			$this->request->data = $this->Client->find('first', $options);
		}
                $contacts=$this->Contact->find('all',array('conditions'=>array('Contact.client_id' => $id)));
		$familleclients = $this->Client->Familleclient->find('list');
		$sousfamilleclients = $this->Client->Sousfamilleclient->find('list',array('conditions'=>array('Sousfamilleclient.familleclient_id' => $familleclientid)));
		$zones = $this->Client->Zone->find('list');
                $personnels = $this->Client->Personnel->find('list');
                $typeclients = $this->Typeclient->find('list');
                $modeclients = $this->Modeclient->find('list');
		$this->set(compact('modeclients','typeclients','personnels','familleclients', 'sousfamilleclients', 'zones','contacts'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
            $lien=  CakeSession::read('lien_vente');
               $client="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='clients'){
                        $client=$liens['delete'];
                }}}
              if (( $client <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
                $this->loadModel('Contact');
		$this->Client->id = $id;
		if (!$this->Client->exists()) {
			throw new NotFoundException(__('Invalid client'));
		}
		$this->request->onlyAllow('post', 'delete');
                
                $this->Contact->deleteAll(array('Contact.client_id'=>$id),false); 
                
		if ($this->Client->delete()) {
			$this->Session->setFlash(__('Client deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Client was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
         public function getsousfamilleclient(){
              $this->layout = null;
              $this->loadModel('Sousfamilleclient');
   
            $data = $this->request->data;
            $familleclientid= $data['familleclientid'];
 
            $sousfamilleclients=$this->Sousfamilleclient->find('all', array( 'conditions' => array('Sousfamilleclient.familleclient_id'=>$familleclientid),'recursive'=>-1)) ;
            $select="<select name='sousfamilleclient_id' champ='sousfamilleclient_id' id='sousfamilleclient_id' class='form-control  select ' onchange=''><option selected disabled hidden value=0> Veuillez choisir !!</option>";
            foreach($sousfamilleclients as $v){
                $select=$select."<option value=".$v['Sousfamilleclient']['id'].">".$v['Sousfamilleclient']['name']."</option>";
              }
            $select=$select.'</select>';
            
            echo $select;
            die;
            } 
             public function testecheance(){
              $this->layout = null;
   
            $data = $this->request->data;
            $client_id= $data['client_id'];
            $paiement_id= $data['paiement_id'];
            
            $client=$this->Client->find('first', array( 'conditions' => array('Client.id'=>$client_id),'recursive'=>-1)) ;
            if($paiement_id==2){
               echo $client['Client']['chequejrs'];
            }else if($paiement_id==3){
               echo $client['Client']['traitejrs'];  
            }
            die;
            } 
            
            
            
            public function rechercheclient() {
           
            $data = $this->request->data;
            $code= $data['val1'];
            $cond1 = 'Client.code = '."'".$code."'";
            $rechereclient = $this->Client->find('count', array( 'conditions' => array( $cond1 )));
                // debug($recherecheutilisateur);die;
                 
                    echo $rechereclient;
                    die;
                 // echo json_encode(array('rechclt'=>$recherecheclient));
            
            //$this->set(compact('utilisateurs','actionsrechereche','utilisateurid','date1','date2'));
                  
        } 
}
