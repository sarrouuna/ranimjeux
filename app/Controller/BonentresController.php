<?php
App::uses('AppController', 'Controller');
/**
 * Bonentres Controller
 *
 * @property Bonentre $Bonentre
 */
class BonentresController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
             $lien=  CakeSession::read('lien_achat');
               $x="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonentres'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Bonentre->recursive = 0;
		$this->set('bonentres', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            $this->loadModel('Ligneentre');
		if (!$this->Bonentre->exists($id)) {
			throw new NotFoundException(__('Invalid bonentre'));
		}
		$options = array('conditions' => array('Bonentre.' . $this->Bonentre->primaryKey => $id));
		$this->set('bonentre', $this->Bonentre->find('first', $options));
                $ligneentres=$this->Ligneentre->find('all',array('conditions'=>array('Ligneentre.bonentre_id'=>$id),false));
                $this->set(compact('ligneentres'));
	}
      public function imprimer($id = null) {
           $lien=  CakeSession::read('lien_achat');
               $x="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonentres'){
                        $x=$liens['imprimer'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Ligneentre');
		if (!$this->Bonentre->exists($id)) {
			throw new NotFoundException(__('Invalid bonentre'));
		}
		$options = array('conditions' => array('Bonentre.' . $this->Bonentre->primaryKey => $id));
		$this->set('bonentre', $this->Bonentre->find('first', $options));
                $ligneentres=$this->Ligneentre->find('all',array('conditions'=>array('Ligneentre.bonentre_id'=>$id),false));
                //debug($ligneentres);die;
                $this->set(compact('ligneentres'));
	}
    //**************************les bonentres provenant de facture avoir*******************************************************
	  public function add($id=null) {
            $lien=  CakeSession::read('lien_achat');
               $x="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonentres'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Lignereception');
             $this->loadModel('Stockdepot');
             $this->loadModel('Article');
             $this->loadModel('Fournisseur');
             $this->loadModel('Depot');
             $this->loadModel('Factureavoir');
             $this->loadModel('Bonentre');
             $this->loadModel('Ligneentre');
             $this->loadModel('Lignefactureavoir');
		if (!$this->Factureavoir->exists($id)) {
			throw new NotFoundException(__('Invalid Factureavoir'));
		}
		if ($this->request->is('post')) {
                   //debug($this->request->data );die;
                    $this->request->data['Bonentre']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonentre']['date'])));
	            $this->request->data['Bonentre']['utilisateur_id']= CakeSession::read('users');
                    $this->request->data['Bonentre']['factureavoir_id']=$id;
                    //debug($this->request->data );die;
                    $this->Bonentre->create();
                     if(!empty($this->request->data['Lignefactureavoir'])){
			if ($this->Bonentre->save($this->request->data)) {
                         $idbe=$this->Bonentre->id; 
                               foreach (  $this->request->data['Lignefactureavoir'] as $i=>$f   ){  
                                    
                                if ($f['sup']!=1){
                                    $Ligneentres['bonentre_id']=$idbe;
                                    $Ligneentres['lignefactureavoir_id']=$f['id'];
                                    $Ligneentres['article_id']=$f['article_id'];   
                                    
                                    $Ligneentres['depot_id']=$f['Detail'][0]['depot_id'];
                                    $Ligneentres['quantite']=$f['Detail'][0]['qte'];
                                     if ($f['Detail'][0]['datevalidite']!= '__/__/____'){
                                    $Ligneentres['date']=date("Y-m-d",strtotime(str_replace('/','-',$f['Detail'][0]['datevalidite'])));
                                    $cond='Stockdepot.date = '."'".$Ligneentres['date']."'";}
                                    
                                           $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Ligneentres['article_id'],'Stockdepot.depot_id'=>$Ligneentres['depot_id'],@$cond),false)); 
                                           if (!empty($stckdepot)){
                                                $qtett= $Ligneentres['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qtett), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                                $sdid=$stckdepot[0]['Stockdepot']['id'];
                                            }else{
                                                $this->Stockdepot->create();
                                                $this->Stockdepot->save($Ligneentres); 
                                                $sdid=$this->Stockdepot->id;
                                            }
                                    $Ligneentres['stockdepot_id']=$sdid;        
                                    $this->Ligneentre->create();
                                    $this->Ligneentre->save($Ligneentres); 
                                    
                                        if($f['quantite']>$f['Detail'][0]['qte']){
                                            if(!empty($this->request->data['Detail'.$i])){
                                            foreach (  $this->request->data['Detail'.$i] as $di   ){ 
                                                if ($di['sup']!=1){
                                                    $Ligneentres['bonentre_id']=$idbe;
                                                    $Ligneentres['lignefactureavoir_id']=$f['id'];
                                                    $Ligneentres['article_id']=$f['article_id'];
                                                    
                                                    $Ligneentres['depot_id']=$di['depot_id'];
                                                    $Ligneentres['quantite']=$di['qte'];  
                                                     if ($di['datevalidite']!= '__/__/____'){
                                                    $Ligneentres['date']=date("Y-m-d",strtotime(str_replace('/','-',$di['datevalidite'])));
                                                    $cond='Stockdepot.date = '."'".$Ligneentres['date']."'";}
                                                       
                                                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Ligneentres['article_id'],'Stockdepot.depot_id'=>$Ligneentres['depot_id'],@$cond),false)); 
                                                            if (!empty($stckdepot)){
                                                                 $qtett= $Ligneentres['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                                                 $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qtett), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                                                 $sdid=$stckdepot[0]['Stockdepot']['id'];
                                                            }else{
                                                                 $this->Stockdepot->create();
                                                                 $this->Stockdepot->save($Ligneentres); 
                                                                 $sdid=$this->Stockdepot->id;
                                                            }
                                                    $Ligneentres['stockdepot_id']=$sdid;        
                                                    $this->Ligneentre->create();
                                                    $this->Ligneentre->save($Ligneentres);         
                                                       
                                                }    
                                        }}
                                        }
                                }
                             } 
                              
                           $this->Factureavoir->updateAll(array('Factureavoir.etat' =>1), array('Factureavoir.id' =>$id));       
                              
				$this->Session->setFlash(__('The bonentre has been saved'));
				$this->redirect(array('action' => 'index'));    
			} else {
				$this->Session->setFlash(__('le bon d entre dois avoir aux moins une ligne de entre.'));
                        }
		}
                }
         $Lignefactureavoirs = $this->Lignefactureavoir->find('all',array('conditions'=>array('Lignefactureavoir.factureavoir_id' => $id)));  
         

           $numero = $this->Bonentre->find('all', array('fields' =>
            array(
                'MAX(Bonentre.numero) as num'
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
                $articles = $this->Article->find('list');
		$fournisseurs = $this->Fournisseur->find('list');
		$depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('fournisseurs', 'utilisateurs', 'depots','Lignefactureavoirs','articles','mm'));   
        }
        
        //**************************les bonentres provenant de bonrecption (add)*******************************************************
	  public function addpbrd($id=null) {
            $lien=  CakeSession::read('lien_achat');
               $x="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonentres'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Lignereception');
             $this->loadModel('Stockdepot');
             $this->loadModel('Article');
             $this->loadModel('Fournisseur');
             $this->loadModel('Depot');
             $this->loadModel('Factureavoir');
             $this->loadModel('Bonentre');
             $this->loadModel('Ligneentre');
             $this->loadModel('Lignefactureavoir');
		if (!$this->Factureavoir->exists($id)) {
			throw new NotFoundException(__('Invalid Factureavoir'));
		}
		if ($this->request->is('post')) {
                   //debug($this->request->data );die;
                    $this->request->data['Bonentre']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonentre']['date'])));
	            $this->request->data['Bonentre']['utilisateur_id']= CakeSession::read('users');
                    $this->request->data['Bonentre']['factureavoir_id']=$id;
                    //debug($this->request->data );die;
                    $this->Bonentre->create();
                     if(!empty($this->request->data['Lignefactureavoir'])){
			if ($this->Bonentre->save($this->request->data)) {
                         $idbe=$this->Bonentre->id; 
                               foreach (  $this->request->data['Lignefactureavoir'] as $i=>$f   ){  
                                    
                                if ($f['sup']!=1){
                                    $Ligneentres['bonentre_id']=$idbe;
                                    $Ligneentres['lignefactureavoir_id']=$f['id'];
                                    $Ligneentres['article_id']=$f['article_id'];   
                                    
                                    $Ligneentres['depot_id']=$f['Detail'][0]['depot_id'];
                                    $Ligneentres['quantite']=$f['Detail'][0]['qte'];
                                     if ($f['Detail'][0]['datevalidite']!= '__/__/____'){
                                    $Ligneentres['date']=date("Y-m-d",strtotime(str_replace('/','-',$f['Detail'][0]['datevalidite'])));
                                    $cond='Stockdepot.date = '."'".$Ligneentres['date']."'";}
                                    
                                           $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Ligneentres['article_id'],'Stockdepot.depot_id'=>$Ligneentres['depot_id'],@$cond),false)); 
                                           if (!empty($stckdepot)){
                                                $qtett= $Ligneentres['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qtett), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                                $sdid=$stckdepot[0]['Stockdepot']['id'];
                                            }else{
                                                $this->Stockdepot->create();
                                                $this->Stockdepot->save($Ligneentres); 
                                                $sdid=$this->Stockdepot->id;
                                            }
                                    $Ligneentres['stockdepot_id']=$sdid;        
                                    $this->Ligneentre->create();
                                    $this->Ligneentre->save($Ligneentres); 
                                    
                                        if($f['quantite']>$f['Detail'][0]['qte']){
                                            foreach (  $this->request->data['Detail'.$i] as $di   ){ 
                                                if ($di['sup']!=1){
                                                    $Ligneentres['bonentre_id']=$idbe;
                                                    $Ligneentres['lignefactureavoir_id']=$f['id'];
                                                    $Ligneentres['article_id']=$f['article_id'];
                                                    
                                                    $Ligneentres['depot_id']=$di['depot_id'];
                                                    $Ligneentres['quantite']=$di['qte'];  
                                                     if ($di['datevalidite']!= '__/__/____'){
                                                    $Ligneentres['date']=date("Y-m-d",strtotime(str_replace('/','-',$di['datevalidite'])));
                                                    $cond='Stockdepot.date = '."'".$Ligneentres['date']."'";}
                                                       
                                                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Ligneentres['article_id'],'Stockdepot.depot_id'=>$Ligneentres['depot_id'],@$cond),false)); 
                                                            if (!empty($stckdepot)){
                                                                 $qtett= $Ligneentres['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                                                 $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qtett), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                                                 $sdid=$stckdepot[0]['Stockdepot']['id'];
                                                            }else{
                                                                 $this->Stockdepot->create();
                                                                 $this->Stockdepot->save($Ligneentres); 
                                                                 $sdid=$this->Stockdepot->id;
                                                            }
                                                    $Ligneentres['stockdepot_id']=$sdid;        
                                                    $this->Ligneentre->create();
                                                    $this->Ligneentre->save($Ligneentres);         
                                                       
                                                }    
                                            }
                                        }
                                }
                             } 
                              
                           $this->Factureavoir->updateAll(array('Factureavoir.etat' =>1), array('Factureavoir.id' =>$id));       
                              
				$this->Session->setFlash(__('The bonentre has been saved'));
				$this->redirect(array('action' => 'index'));    
			} else {
				$this->Session->setFlash(__('le bon d entre dois avoir aux moins une ligne de entre.'));
                        }
		}
                }
         $Lignefactureavoirs = $this->Lignefactureavoir->find('all',array('conditions'=>array('Lignefactureavoir.factureavoir_id' => $id)));  
         

           $numero = $this->Bonentre->find('all', array('fields' =>
            array(
                'MAX(Bonentre.numero) as num'
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
                $articles = $this->Article->find('list');
		$fournisseurs = $this->Fournisseur->find('list');
		$depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('fournisseurs', 'utilisateurs', 'depots','Lignefactureavoirs','articles','mm'));   
        }
        
        //**************************les bonentres provenant de bonreception (addindirect)****************************************************
	  public function addpbri($id=null) {
            $lien=  CakeSession::read('lien_achat');
               $x="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonentres'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Lignereception');
             $this->loadModel('Stockdepot');
             $this->loadModel('Article');
             $this->loadModel('Fournisseur');
             $this->loadModel('Depot');
             $this->loadModel('Factureavoir');
             $this->loadModel('Bonentre');
             $this->loadModel('Ligneentre');
             $this->loadModel('Lignefactureavoir');
		if (!$this->Factureavoir->exists($id)) {
			throw new NotFoundException(__('Invalid Factureavoir'));
		}
		if ($this->request->is('post')) {
                   //debug($this->request->data );die;
                    $this->request->data['Bonentre']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonentre']['date'])));
	            $this->request->data['Bonentre']['utilisateur_id']= CakeSession::read('users');
                    $this->request->data['Bonentre']['factureavoir_id']=$id;
                    //debug($this->request->data );die;
                    $this->Bonentre->create();
                     if(!empty($this->request->data['Lignefactureavoir'])){
			if ($this->Bonentre->save($this->request->data)) {
                         $idbe=$this->Bonentre->id; 
                               foreach (  $this->request->data['Lignefactureavoir'] as $i=>$f   ){  
                                    
                                if ($f['sup']!=1){
                                    $Ligneentres['bonentre_id']=$idbe;
                                    $Ligneentres['lignefactureavoir_id']=$f['id'];
                                    $Ligneentres['article_id']=$f['article_id'];   
                                    
                                    $Ligneentres['depot_id']=$f['Detail'][0]['depot_id'];
                                    $Ligneentres['quantite']=$f['Detail'][0]['qte'];
                                     if ($f['Detail'][0]['datevalidite']!= '__/__/____'){
                                    $Ligneentres['date']=date("Y-m-d",strtotime(str_replace('/','-',$f['Detail'][0]['datevalidite'])));
                                    $cond='Stockdepot.date = '."'".$Ligneentres['date']."'";}
                                    
                                           $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Ligneentres['article_id'],'Stockdepot.depot_id'=>$Ligneentres['depot_id'],@$cond),false)); 
                                           if (!empty($stckdepot)){
                                                $qtett= $Ligneentres['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                                $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qtett), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                                $sdid=$stckdepot[0]['Stockdepot']['id'];
                                            }else{
                                                $this->Stockdepot->create();
                                                $this->Stockdepot->save($Ligneentres); 
                                                $sdid=$this->Stockdepot->id;
                                            }
                                    $Ligneentres['stockdepot_id']=$sdid;        
                                    $this->Ligneentre->create();
                                    $this->Ligneentre->save($Ligneentres); 
                                    
                                        if($f['quantite']>$f['Detail'][0]['qte']){
                                            foreach (  $this->request->data['Detail'.$i] as $di   ){ 
                                                if ($di['sup']!=1){
                                                    $Ligneentres['bonentre_id']=$idbe;
                                                    $Ligneentres['lignefactureavoir_id']=$f['id'];
                                                    $Ligneentres['article_id']=$f['article_id'];
                                                    
                                                    $Ligneentres['depot_id']=$di['depot_id'];
                                                    $Ligneentres['quantite']=$di['qte'];  
                                                     if ($di['datevalidite']!= '__/__/____'){
                                                    $Ligneentres['date']=date("Y-m-d",strtotime(str_replace('/','-',$di['datevalidite'])));
                                                    $cond='Stockdepot.date = '."'".$Ligneentres['date']."'";}
                                                       
                                                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Ligneentres['article_id'],'Stockdepot.depot_id'=>$Ligneentres['depot_id'],@$cond),false)); 
                                                            if (!empty($stckdepot)){
                                                                 $qtett= $Ligneentres['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                                                 $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qtett), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                                                 $sdid=$stckdepot[0]['Stockdepot']['id'];
                                                            }else{
                                                                 $this->Stockdepot->create();
                                                                 $this->Stockdepot->save($Ligneentres); 
                                                                 $sdid=$this->Stockdepot->id;
                                                            }
                                                    $Ligneentres['stockdepot_id']=$sdid;        
                                                    $this->Ligneentre->create();
                                                    $this->Ligneentre->save($Ligneentres);         
                                                       
                                                }    
                                            }
                                        }
                                }
                             } 
                              
                           $this->Factureavoir->updateAll(array('Factureavoir.etat' =>1), array('Factureavoir.id' =>$id));       
                              
				$this->Session->setFlash(__('The bonentre has been saved'));
				$this->redirect(array('action' => 'index'));    
			} else {
				$this->Session->setFlash(__('le bon d entre dois avoir aux moins une ligne de entre.'));
                        }
		}
                }
         $Lignefactureavoirs = $this->Lignefactureavoir->find('all',array('conditions'=>array('Lignefactureavoir.factureavoir_id' => $id)));  
         

           $numero = $this->Bonentre->find('all', array('fields' =>
            array(
                'MAX(Bonentre.numero) as num'
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
                $articles = $this->Article->find('list');
		$fournisseurs = $this->Fournisseur->find('list');
		$depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('fournisseurs', 'utilisateurs', 'depots','Lignefactureavoirs','articles','mm'));   
        }
        
          public function editbe($id = null) {
             $lien=  CakeSession::read('lien_achat');
               $x="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonentres'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Depot');
            $this->loadModel('Stockdepot');
            $this->loadModel('Article');
            $this->loadModel('Ligneentre');
            $this->loadModel('Lignereception');
            $this->loadModel('Lignefacture');
             $this->loadModel('Lignefactureavoir');
		if (!$this->Bonentre->exists($id)) {
			throw new NotFoundException(__('Invalid bonentre'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                   // debug($this->request->data);die;
                    $this->request->data['Bonentre']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonentre']['date'])));
			if ($this->Bonentre->save($this->request->data)) {
                            
                                //delete ligne entres......*************************************************************
                                $Ligneentres=$this->Ligneentre->find('all',array('conditions'=>array('Ligneentre.bonentre_id' => $id))); 
                                       foreach ($Ligneentres as $i => $ligne) {
                                       $this->Stockdepot->updateAll(array('Stockdepot.quantite'=>'Stockdepot.quantite-'.$ligne['Ligneentre']['quantite']),
                                                 array('Stockdepot.id' =>$ligne['Ligneentre']['stockdepot_id']));   
                                       }
                                $this->Ligneentre->deleteAll(array('Ligneentre.bonentre_id'=>$id),false); 
                                //fin delete ligne entres......*************************************************************
                                
                                $idbe=$this->Bonentre->id; 
                               foreach (  $this->request->data['Lignefactureavoir'] as $i=>$f   ){  
                                    
                                if ($f['sup']!=1){
                                    $quantiteentre=0;
                                    if(isset($f['Detail'])){
                                     foreach ($f['Detail'] as $d){
                                        $Ligneentres['bonentre_id']=$idbe;
                                        $Ligneentres['lignefactureavoir_id']=$f['id'];
                                        $Ligneentres['article_id']=$f['article_id'];
                                        if ($d['datevalidite']!= '__/__/____'){
                                        $Ligneentres['date']=date("Y-m-d",strtotime(str_replace('/','-',$d['datevalidite'])));
                                        $cond='Stockdepot.date = '."'".$Ligneentres['date']."'";}
                                        $Ligneentres['depot_id']=$d['depot_id'];
                                        $Ligneentres['quantite']=$d['qte'];
                                        $quantiteentre=$quantiteentre+$d['qte'];
                                               $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Ligneentres['article_id'],'Stockdepot.depot_id'=>$Ligneentres['depot_id'],@$cond),false)); 
                                               if (!empty($stckdepot)){
                                                    $qtett= $Ligneentres['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qtett), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                                    $this->Stockdepot->deleteAll(array('Stockdepot.id > ' => 0,'Stockdepot.quantite'=>0),false);    
                                                    $sdid=$stckdepot[0]['Stockdepot']['id'];
                                                }else{
                                                    $this->Stockdepot->create();
                                                    $this->Stockdepot->save($Ligneentres); 
                                                    $sdid=$this->Stockdepot->id;
                                                }
                                        $Ligneentres['stockdepot_id']=$sdid;        
                                        $this->Ligneentre->create();
                                        $this->Ligneentre->save($Ligneentres); 
                                    }}
                                        //if($f['quantite']>$quantiteentre){
                                            if(isset($f['Detail'.$i])){
                                            foreach (  $this->request->data['Detail'.$i] as $di   ){ 
                                                if ($di['sup']!=1){
                                                    $Ligneentres['bonentre_id']=$idbe;
                                                    $Ligneentres['lignefactureavoir_id']=$f['id'];
                                                    $Ligneentres['article_id']=$f['article_id'];
                                                    if ($di['datevalidite']!= '__/__/____'){
                                                    $Ligneentres['date']=date("Y-m-d",strtotime(str_replace('/','-',$di['datevalidite'])));
                                                    $cond='Stockdepot.date = '."'".$Ligneentres['date']."'";}
                                                    $Ligneentres['depot_id']=$di['depot_id'];
                                                    $Ligneentres['quantite']=$di['qte'];  
                                                       
                                                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Ligneentres['article_id'],'Stockdepot.depot_id'=>$Ligneentres['depot_id'],@$cond),false)); 
                                                            if (!empty($stckdepot)){
                                                                 $qtett= $Ligneentres['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                                                 $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qtett), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                                                 $this->Stockdepot->deleteAll(array('Stockdepot.id > ' => 0,'Stockdepot.quantite'=>0),false);    
                                                                 $sdid=$stckdepot[0]['Stockdepot']['id'];
                                                            }else{
                                                                 $this->Stockdepot->create();
                                                                 $this->Stockdepot->save($Ligneentres); 
                                                                 $sdid=$this->Stockdepot->id;
                                                            }
                                                    $Ligneentres['stockdepot_id']=$sdid;        
                                                    $this->Ligneentre->create();
                                                    $this->Ligneentre->save($Ligneentres);         
                                                       
                                                }    
                                            }
                                        }   
                                }
                             } 
                                
                                
                                
				$this->Session->setFlash(__('The bonentre has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bonentre could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Bonentre.' . $this->Bonentre->primaryKey => $id));
			$this->request->data = $this->Bonentre->find('first', $options);
		}
                $bonentre = $this->Bonentre->find('first',array('conditions'=>array('Bonentre.id' => $id))); 
                
               if (!empty($bonentre['Bonentre']['factureavoir_id'])){
                $Lignefactureavoirs= $this->Lignefactureavoir->find('all',array('conditions'=>array('Lignefactureavoir.factureavoir_id' => $bonentre['Bonentre']['factureavoir_id'])));    
                }
                
                $ligneentres = $this->Ligneentre->find('all',array('conditions'=>array('Ligneentre.bonentre_id' =>$id))); 
                $fournisseurs = $this->Bonentre->Fournisseur->find('list');
		$utilisateurs = $this->Bonentre->Utilisateur->find('list');
		$bonreceptions = $this->Bonentre->Bonreception->find('list');
		$factures = $this->Bonentre->Facture->find('list');
                $articles = $this->Article->find('list');
                $date=date("d/m/Y",strtotime(str_replace('-','/',$bonentre['Bonentre']['date'])));
                $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('fournisseurs', 'utilisateurs', 'bonreceptions', 'factures', 'date', 'depots', 'articles', 'Lignefactureavoirs', 'ligneentres'));
	} 
    //**************************les bonentres provenant de facture avoir**************************fin*************************    

	public function edit($id = null) {
             $lien=  CakeSession::read('lien_achat');
               $x="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonentres'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Depot');
            $this->loadModel('Stockdepot');
            $this->loadModel('Article');
            $this->loadModel('Ligneentre');
            $this->loadModel('Lignereception');
            $this->loadModel('Lignefacture');
            // $this->loadModel('Lignefactureavoir');
		if (!$this->Bonentre->exists($id)) {
			throw new NotFoundException(__('Invalid bonentre'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    //debug($this->request->data);die;
                    $this->request->data['Bonentre']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Bonentre']['date'])));
			if ($this->Bonentre->save($this->request->data)) {
                            
                                //delete ligne entres......*************************************************************
                                $Ligneentres=$this->Ligneentre->find('all',array('conditions'=>array('Ligneentre.bonentre_id' => $id))); 
                                       foreach ($Ligneentres as $i => $ligne) {
                                       $this->Stockdepot->updateAll(array('Stockdepot.quantite'=>'Stockdepot.quantite-'.$ligne['Ligneentre']['quantite']),
                                                 array('Stockdepot.id' =>$ligne['Ligneentre']['stockdepot_id']));   
                                       }
                                $this->Ligneentre->deleteAll(array('Ligneentre.bonentre_id'=>$id),false); 
                                //fin delete ligne entres......*************************************************************
                                
                                $idbe=$this->Bonentre->id; 
                               foreach (  $this->request->data['Lignereception'] as $i=>$f   ){  
                                    
                                if ($f['sup']!=1){
                                    $quantiteentre=0;
                                   if(isset($f['Detail'])){
                                    foreach ($f['Detail'] as $d){
                                        $Ligneentres['bonentre_id']=$idbe;
                                        $Ligneentres['lignereception_id']=$f['id'];
                                        $Ligneentres['article_id']=$f['article_id'];
                                        if ($f['datevalidite']!= '__/__/____'){
                                        $Ligneentres['date']=date("Y-m-d",strtotime(str_replace('/','-',$f['datevalidite'])));
                                        $cond='Stockdepot.date = '."'".$Ligneentres['date']."'";}
                                        $Ligneentres['depot_id']=$d['depot_id'];
                                        $Ligneentres['quantite']=$d['qte'];
                                        $quantiteentre=$quantiteentre+$d['qte'];
                                               $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Ligneentres['article_id'],'Stockdepot.depot_id'=>$Ligneentres['depot_id'],@$cond),false)); 
                                               if (!empty($stckdepot)){
                                                    $qtett= $Ligneentres['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qtett), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                                    $this->Stockdepot->deleteAll(array('Stockdepot.id > ' => 0,'Stockdepot.quantite'=>0),false);    
                                                    $sdid=$stckdepot[0]['Stockdepot']['id'];
                                                }else{
                                                    $this->Stockdepot->create();
                                                    $this->Stockdepot->save($Ligneentres); 
                                                    $sdid=$this->Stockdepot->id;
                                                }
                                        $Ligneentres['stockdepot_id']=$sdid;        
                                        $this->Ligneentre->create();
                                        $this->Ligneentre->save($Ligneentres); 
                                }}
                                        if($f['quantite']>$quantiteentre){
                                             if(isset( $this->request->data['Detail'.$i])){
                                            foreach (  $this->request->data['Detail'.$i] as $di   ){ 
                                                if ($di['sup']!=1){
                                                    $Ligneentres['bonentre_id']=$idbe;
                                                    $Ligneentres['lignereception_id']=$f['id'];
                                                    $Ligneentres['article_id']=$f['article_id'];
                                                    if ($f['datevalidite']!= '__/__/____'){
                                                    $Ligneentres['date']=date("Y-m-d",strtotime(str_replace('/','-',$f['datevalidite'])));
                                                    $cond='Stockdepot.date = '."'".$Ligneentres['date']."'";}
                                                    $Ligneentres['depot_id']=$di['depot_id'];
                                                    $Ligneentres['quantite']=$di['qte'];  
                                                       
                                                            $stckdepot= $this->Stockdepot->find('all',array('conditions'=>array('Stockdepot.article_id'=>$Ligneentres['article_id'],'Stockdepot.depot_id'=>$Ligneentres['depot_id'],@$cond),false)); 
                                                            if (!empty($stckdepot)){
                                                                 $qtett= $Ligneentres['quantite']+$stckdepot[0]['Stockdepot']['quantite'];
                                                                 $this->Stockdepot->updateAll(array('Stockdepot.quantite' =>$qtett), array('Stockdepot.id' =>$stckdepot[0]['Stockdepot']['id']));
                                                                 $this->Stockdepot->deleteAll(array('Stockdepot.id > ' => 0,'Stockdepot.quantite'=>0),false);    
                                                                 $sdid=$stckdepot[0]['Stockdepot']['id'];
                                                            }else{
                                                                 $this->Stockdepot->create();
                                                                 $this->Stockdepot->save($Ligneentres); 
                                                                 $sdid=$this->Stockdepot->id;
                                                            }
                                                    $Ligneentres['stockdepot_id']=$sdid;        
                                                    $this->Ligneentre->create();
                                                    $this->Ligneentre->save($Ligneentres);         
                                                       
                                                }    
                                            }
                                        }  } 
                                }
                             } 
                                
                                
                                
				$this->Session->setFlash(__('The bonentre has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bonentre could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Bonentre.' . $this->Bonentre->primaryKey => $id));
			$this->request->data = $this->Bonentre->find('first', $options);
		}
                $bonentre = $this->Bonentre->find('first',array('conditions'=>array('Bonentre.id' => $id))); 
                if (!empty($bonentre['Bonentre']['bonreception_id'])){
                $lignereceptions = $this->Lignereception->find('all',array('conditions'=>array('Lignereception.bonreception_id' =>$bonentre['Bonentre']['bonreception_id']))); 
                }else if (!empty($bonentre['Bonentre']['facture_id'])){
                $lignereceptions=$lignefactures = $this->Lignefacture->find('all',array('conditions'=>array('Lignefacture.facture_id' =>$bonentre['Bonentre']['facture_id']))); 
                foreach ($lignefactures as $i => $lignefacture) {
                    $lignereceptions[$i]['Lignereception']=$lignefacture['Lignefacture'];
                }
                }
                $ligneentres = $this->Ligneentre->find('all',array('conditions'=>array('Ligneentre.bonentre_id' =>$id))); 
                $fournisseurs = $this->Bonentre->Fournisseur->find('list');
		$utilisateurs = $this->Bonentre->Utilisateur->find('list');
		$bonreceptions = $this->Bonentre->Bonreception->find('list');
		$factures = $this->Bonentre->Facture->find('list');
                $articles = $this->Article->find('list');
                $date=date("d/m/Y",strtotime(str_replace('-','/',$bonentre['Bonentre']['date'])));
                $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
		$this->set(compact('fournisseurs', 'utilisateurs', 'bonreceptions', 'factures', 'date', 'depots', 'articles', 'lignereceptions', 'ligneentres'));
	}
        
	public function delete($id = null) {
             $lien=  CakeSession::read('lien_achat');
               $x="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='bonentres'){
                        $x=$liens['delete'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Stockdepot');
             $this->loadModel('Ligneentre');
             $this->loadModel('Bonreception'); 
             $this->loadModel('Facture');
             $this->loadModel('Factureavoir');  
             
		$this->Bonentre->id = $id;
		if (!$this->Bonentre->exists()) {
			throw new NotFoundException(__('Invalid bonentre'));
		}
		$this->request->onlyAllow('post', 'delete');
                
                        $Ligneentres=$this->Ligneentre->find('all',array('conditions'=>array('Ligneentre.bonentre_id' => $id))); 
                        @$brid=$Ligneentres[0]['Bonentre']['bonreception_id'];
                        @$fid=$Ligneentres[0]['Bonentre']['facture_id'];
                        @$favid=$Ligneentres[0]['Bonentre']['factureavoir_id'];
                        
                                        if(!empty($brid)){   
                                        $this->Bonreception->updateAll(array('Bonreception.etat'=>0), array('Bonreception.id' =>@$brid));   
                                         }elseif (!empty($fid)) { 
                                        $this->Facture->updateAll(array('Facture.etat'=>0), array('Facture.id' =>@$fid));   
                                          }elseif (!empty($favid)){ 
                                        $this->Factureavoir->updateAll(array('Factureavoir.etat'=>0), array('Factureavoir.id' =>@$favid));   
                                          }  
                                          
                               foreach ($Ligneentres as $i => $ligne) {
                                        $this->Stockdepot->updateAll(array('Stockdepot.quantite'=>'Stockdepot.quantite-'.$ligne['Ligneentre']['quantite']), array('Stockdepot.id' =>$ligne['Ligneentre']['stockdepot_id']));   
                               }
                               
                        $this->Ligneentre->deleteAll(array('Ligneentre.bonentre_id'=>$id),false); 
                
		if ($this->Bonentre->delete()) {
			$this->Session->setFlash(__('Bonentre deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Bonentre was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
