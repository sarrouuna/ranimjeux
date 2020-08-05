<?php
App::uses('AppController', 'Controller');
/**
 * Fonds Controller
 *
 * @property Fond $Fond
 */
class JourneesController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Journee->recursive = 0;
		
		 $this->paginate =   array(
        
     
        'order' => array(
            'Journee.id' => 'desc'
        )
    );
		$this->set('journees', $this->paginate());
	}

 
        public function add() {
		$this->loadModel('Journee');
		$this->loadModel('Personnel');
                $this->loadModel('Fond');
                $this->loadModel('Fondcaisse');
		
		if ($this->request->is('post')) {
                    //debug($this->request->data);die;
			$this->Journee->create();
			
                        @$date_debut = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', @$this->request->data['Fond']['date_debut'])));
            $this->request->data['Fond']['date_debut'] = $date_debut;
            if ($this->request->data['Fond']['date_fin'] != '')
                @$date_fin = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', @$this->request->data['Fond']['date_fin'])));
            else
                $date_fin = '0000-00-00 00:00:00';
            $this->request->data['Fond']['date_fin'] = $date_fin;

            if ($this->Journee->save($this->request->data['Fond'])) {

                $journeeid = $this->Journee->id;

                foreach ($this->request->data['detail'] as $detail) {
                    $fond['personnel_id'] = $detail['personnel_id'];
                    $fond['journee_id'] = $journeeid;
                    if ($detail['fond'] == '')
                        $fond['etat'] = 1;
                    else
                        $fond['etat'] = 0;
                    $fond['fond'] = $detail['fond'];
                    $fond['date'] = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', @$detail['date'])));
                    $this->Fond->create();
                    $this->Fond->save($fond);
                }
                $this->redirect(array('controller'=>'journees','action' => 'index'));
			} else {
			}
		}
		
		$depots = $this->Journee->Depot->find('list');
		$personnels = $this->Personnel->find('all');
                $fondcaisse = $this->Fondcaisse->find('first',array('conditions'=>array('Fondcaisse.id'=>1)));
		$this->set(compact('depots','personnels','fondcaisse'));
	}
        
        
        
 public function view($id = null) {
		$this->Journee->id = $id;
		if (!$this->Journee->exists()) {
			throw new NotFoundException(__('Invalid Fond'));
		}
		
		
		$this->loadModel('Personnel');
		$this->loadModel('Ticketcaisse');
		$this->loadModel('Depot');
		$this->loadModel('Fond');
 		$personnels = $this->Personnel->find('all');
 		$depots = $this->Depot->find('list');
 		$journee = $this->Journee->find('first',array('conditions'=>array('Journee.id'=>$id)));
		$this->set(compact( 'personnels','journee','depots'));
	 
		
		$this->loadModel('Article');
		$this->loadModel('Famille');
		$this->loadModel('Ticketcaisseligne');
		foreach($personnels as $per)
		{
			$ticket[$per['Personnel']['id']]=$this->Ticketcaisse->find('all',array('fields'=>array('Sum( Total_TTC ) as Total_TTC'), 'conditions'=>array('Ticketcaisse.personnel_id'=>$per['Personnel']['id'],'Ticketcaisse.journee_id'=>$id)));
			$Fond[$per['Personnel']['id']]=$this->Fond->find('all',array( 'conditions'=>array('Fond.journee_id'=>$id,'Fond.personnel_id'=>$per['Personnel']['id'])));
		}
		
		
		
		$this->loadModel('Ticketcaiss');
		//////////////////////////marge calcule
			

        $this->set(compact( 'ticket','Fond'));
        $tick=0;
	    $tickets=$this->Ticketcaiss->find('list',array('conditions'=>array('Ticketcaiss.journee_id'=>$id)));
	    if(!empty($tickets)) $tick=implode(',',$tickets);
		
	    $Famillearticles = $this->Famille->find('all',array('recursive'=>0));
		$this->set(compact( 'Famillearticles'));

		foreach($Famillearticles as $per)
		{
		 $familleid=$per['Famille']['id'];
		 $articles[$familleid] = $this->Article->find('list',array('recursive'=>-1,'fields'=>array('Article.id'),'conditions'=>array('Article.famille_id'=>$familleid)));
		 //debug($articles[$familleid]);die;
		  if(!empty($articles[$familleid])) $art=implode(',',$articles[$familleid]);
		
		 $ligne[$familleid]=$this->Ticketcaisseligne->find('all',array('recursive'=>0,'fields'=>array("sum(Ticketcaisseligne.montant)","sum(Ticketcaisseligne.qte)","Ticketcaisseligne.article_id"),'conditions'=>array('Ticketcaisseligne.ticketcaisse_id in ('.$tick.")",'Ticketcaisseligne.article_id in ('.$art.")"),'group'=>array('Ticketcaisseligne.article_id')));
		}
				
			$this->set(compact( 'ligne' ));		
	if ($this->request->is('post')) {
            //debug($this->request->data);die;
		$this->Journee->create();
		$jour['etat']=2;
		$jour['id']=$id;
		$jour['TotalJournee']=$this->request->data['Journee']['TotalJournee'];
		$jour['Benefice']=$this->request->data['Journee']['Benefice'];
		$this->Journee->save($jour);
		
	
	 
		 $this->redirect(array('controller'=>'Journees','action' => 'index'));

	}
	}
 public function edit($id = null) {
		$this->Journee->id = $id;
		if (!$this->Journee->exists()) {
			throw new NotFoundException(__('Invalid Fond'));
		}
		$this->set('Journee', $this->Journee->read(null, $id));
		
		$this->loadModel('Personnel');
		$this->loadModel('Ticketcaisse');
		$this->loadModel('Fond');
		$this->loadModel('Depot');
 		$personnels = $this->Personnel->find('all');
 		$depots = $this->Depot->find('list');
		$this->set(compact( 'personnels','depots'));
                $journee=$this->Journee->find('first',array('conditions'=>array('Journee.id'=>$id)));
		foreach($personnels as $per)
		{
			$ticket[$per['Personnel']['id']]=$this->Ticketcaisse->find('all',array('fields'=>array('Sum( Total_TTC ) as Total_TTC'), 'conditions'=>array('Ticketcaisse.personnel_id'=>$per['Personnel']['id'],'Ticketcaisse.journee_id'=>$id)));
			$Fond[$per['Personnel']['id']]=$this->Fond->find('all',array( 'conditions'=>array('Fond.journee_id'=>$id,'Fond.personnel_id'=>$per['Personnel']['id'])));
			
			
		}
                //debug($Fond);die;
				$this->set(compact( 'ticket','Fond','journee'));
				
				
 if ($this->request->is('post')) {
			$this->Journee->create();
			
		 @$date_debut=date("Y-m-d H:i:s",strtotime(str_replace('/','-',@$this->request->data['Journee']['date_debut'])));      
			$this->request->data['Journee']['date_debut']=$date_debut;
			if(@$this->request->data['Journee']['date_fin']!='')
	 @$date_fin=date("Y-m-d H:i:s",strtotime(str_replace('/','-',@$this->request->data['Journee']['date_fin'])));    
	 else
	   $date_fin='0000-00-00 00:00:00';
			$this->request->data['Journee']['date_fin']=$date_fin;
		 
			if ($this->Journee->save($this->request->data['Journee'])) {
				
 				$journeeid=$this->Journee->id;

				foreach($this->request->data['detail'] as $detail)
				{
				$fond['personnel_id']=$detail['personnel_id'];	
				$fond['journee_id']=$journeeid;	
				$fond['fond']=$detail['fond'];	
			
			
				 if($detail['fond']=='')$fond['etat']=1; else $fond['etat']=0;

				$fond['id']=$detail['id'];	
				$fond['date']=date("Y-m-d H:i:s",strtotime(str_replace('/','-',@$detail['date'])));  
				if($detail['etat']!=2   ){	
								$this->Fond->create();
$this->Fond->save($fond);
				}
				}
				$this->redirect(array('controller'=>'journees','action' => 'index'));
			} else {
			}
		}

 
	}
 public function imprimer($id = null,$perso=null) {
		$this->Journee->id = $id;
		if (!$this->Journee->exists()) {
			throw new NotFoundException(__('Invalid Fond'));
		}
		$this->set('Journee', $this->Journee->read(null, $id));
		
		$this->loadModel('Personnel');
		$this->loadModel('Piecereglementcaisse');
		$this->loadModel('Ticketcaiss');
		$this->loadModel('Fond');
		if($perso!='')$cond=array("Personnel.id"=>$perso); else $cond=" 1=1";
 		$personnels = $this->Personnel->find('all',array('conditions'=>$cond));
		$this->set(compact( 'personnels'));
	    //debug($personnels);die;
		foreach($personnels as $per)
		{
			$ticket[$per['Personnel']['id']]=@$this->Ticketcaiss->find('all',array('fields'=>array('Sum( Total_TTC ) as Total_TTC','Sum( Rest ) as Rest'), 'conditions'=>array('Ticketcaiss.personnel_id'=>$per['Personnel']['id'],'Ticketcaiss.journee_id'=>$id)));

			$tab_haitham=$this->Ticketcaiss->find('list',array('recursive'=>0,'fields'=>array('Ticketcaiss.reglementcaisse_id'), 'conditions'=>array('Ticketcaiss.personnel_id'=>$per['Personnel']['id'],'Ticketcaiss.journee_id'=>$id)));
			//debug($tab_haitham);
			$reg[$per['Personnel']['id']]=@$tab_haitham;
		 	//debug(implode(',',$reg[$per['Personnel']['id']])); die;

			if(!empty($reg[$per['Personnel']['id']])) $r[$per['Personnel']['id']]=implode(',',$reg[$per['Personnel']['id']]); else $r[$per['Personnel']['id']]=0;
	        //debug($r);
			$tickets[$per['Personnel']['id']]=@$this->Piecereglementcaisse->find('all',array('recursive'=>0, 'conditions'=>array('Piecereglementcaisse.reglementcaisse_id in ('.$r[$per['Personnel']['id']].')')));
		 
			 
			$Fond[$per['Personnel']['id']]=@$this->Fond->find('all',array( 'conditions'=>array('Fond.journee_id'=>$id,'Fond.personnel_id'=>$per['Personnel']['id'])));
			
			
		} 
 // debug($tickets);die;
		
				$this->set(compact( 'ticket','Fond','tickets','perso'));

	}
	
 public function imprimerart($id = null,$perso=null) {
		$this->Journee->id = $id;
		if (!$this->Journee->exists()) {
			throw new NotFoundException(__('Invalid Fond'));
		}
		$this->set('Journee', $this->Journee->read(null, $id));
		
		$this->loadModel('Personnel');
		 
		$this->loadModel('Ticketcaiss');
		$this->loadModel('Article');
		$this->loadModel('Famillearticle');
		$this->loadModel('Ticketcaisseligne');
 	 $tick=0;
	 $tickets=$this->Ticketcaiss->find('list',array('conditions'=>array('Ticketcaiss.journee_id'=>$id)));
			if(!empty($tickets)) $tick=implode(',',$tickets);
			
			$Famillearticles = $this->Famillearticle->find('all',array('recursive'=>0));
		$this->set(compact( 'Famillearticles'));
	 
		foreach($Famillearticles as $per)
		{
		
		 $familleid=$per['Famillearticle']['id'];
		 $articles[$familleid] = $this->Article->find('list',array('recursive'=>-1,'fields'=>array('Article.id'),'conditions'=>array('Article.famillearticle_id'=>$familleid)));
		 	 
		  if(!empty($articles[$familleid])) $art=implode(',',$articles[$familleid]); 
		
		 $ligne[$familleid]=$this->Ticketcaisseligne->find('all',array('recursive'=>0,'fields'=>array("sum(Ticketcaisseligne.montant)","sum(Ticketcaisseligne.qte)","Ticketcaisseligne.article_id"),'conditions'=>array('Ticketcaisseligne.ticketcaisse_id in ('.$tick.")",'Ticketcaisseligne.article_id in ('.$art.")"),'group'=>array('Ticketcaisseligne.article_id')));
		}
		
		
	 // debug($ligne); die;

				$this->set(compact( 'ligne' ));

	}
	
	
 
}
