<?php
App::uses('AppController', 'Controller');
/**
 * Stockdepots Controller
 *
 * @property Stockdepot $Stockdepot
 */
class StockdepotsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
           $lien=  CakeSession::read('lien_stock');
              $x="";
             //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='stockdepots'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
           $this->loadModel('Article');  
           $this->loadModel('Depot');
           $this->loadModel('Fournisseur');
           $this->loadModel('Famille');
           $this->loadModel('Lignecommande');
           $this->loadModel('LigneCommandeclient');
           $this->loadModel('Articlefournisseur');
           $date1 = date("Y-m-d");
           $cond1f = 'Commande.dateliv >= '."'".$date1."'";
           $cond1c = 'Commandeclient.dateliv >= '."'".$date1."'";
           $articleid="";$depotid="";
           $conditionkbira="";
           $condqte1="SUM(Stockdepot.quantite) <> 0 "; 
           $having=" HAVING ".$condqte1;
       if (isset($this->request->data) && !empty($this->request->data)) {
           //debug($this->request->data);
       if ($this->request->data['Stockdepot']['article_id']) {
            $articleid= $this->request->data['Stockdepot']['article_id'];
            $cond3 = 'Stockdepot.article_id ='.$articleid;
            $cond3f = 'Lignecommande.article_id ='.$articleid;
            $cond3c = 'Lignecommandeclient.article_id ='.$articleid;
            $condgroup="";
        } 
        if ($this->request->data['Stockdepot']['depot_id']) {
            $depotid= $this->request->data['Stockdepot']['depot_id'];
            $cond4 = 'Stockdepot.depot_id ='.$depotid;
            $cond4f = 'Commande.depot_id ='.$depotid;
            $cond4c = 'Lignecommandeclient.depot_id ='.$depotid;
        }
        if ($this->request->data['Stockdepot']['famille_id']) {
            $familleid= $this->request->data['Stockdepot']['famille_id'];
            $cond5 = 'Article.famille_id ='.$familleid;
        }
        if ($this->request->data['Stockdepot']['fournisseur_id']) {
            $fournisseurid = $this->request->data['Stockdepot']['fournisseur_id'];
            $articlefournisseurs=$this->Articlefournisseur->find('all',array('recursive'=>-1,'conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid)));
            $abc='0';
            foreach ($articlefournisseurs as $cl){
                if(!empty($cl['Articlefournisseur']['article_id'])){
              $abc=$abc.','.$cl['Articlefournisseur']['article_id']; 
                }
            }
            $cond6 = 'Stockdepot.article_id in ('.$abc.')';
        }
        $having="";
        $condqte1="";
        if ($this->request->data['Stockdepot']['typeqte_id']) {
            $typeqte_id= $this->request->data['Stockdepot']['typeqte_id'];
            $condqte1="";
            $condqte2="";
            $condqte3="";$conditionkbira="";$condqte11="";$condqte12="";$condqte13="";
            //debug($typeqte_id);
            $i=count($typeqte_id);
            $type="0";
            //debug($i);
            $having="";
            $condqte1="";
            foreach ($typeqte_id as $k=>$typeqte){
            $type=$type.",".$typeqte  ;  
            //debug($typeqte);
            
            if($i !=1){ 
            if($k==0){
            if($typeqte==1){
            $condqte1=$condqte1."SUM(Stockdepot.quantite) < 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)> 0 ";   
            }        
            }else{    
            if($typeqte==1){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)< 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)> 0 ";   
            }
            }}else{
            if($typeqte==1){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)< 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)> 0 ";   
            }    
            }
            }
            //$conditionkbira = array('OR'=>array($condqte11,$condqte12,$condqte13));
            //debug($conditionkbira);
            $having=" HAVING ".$condqte1;
        }
    } 
    $stockdepots = $this->Stockdepot->find('all', array('fields'=>array('sum(Stockdepot.quantite) as qte','Article.name','Article.code','Article.id','sum(Stockdepot.prix*Stockdepot.quantite)/sum(Stockdepot.quantite) as prix')
    ,'conditions' => array(@$cond3, @$cond4,@$cond5,@$cond6)
    ,'group'=>array('Stockdepot.article_id'.@$having)
    ,'order'=>array('Article.code'=>'asc')      
    ));
    
//    $commandefrss = $this->Lignecommande->find('all', array('fields'=>array('sum(Lignecommande.quantite) as qte','Article.name','Article.id'),'conditions' => array('Lignecommande.id > ' => 0,@$cond1f, @$cond3f, @$cond4f )
//    ,'group'=>array('Lignecommande.article_id')));
//    debug($commandefrss);
//    $commandeclts = $this->LigneCommandeclient->find('all', array('fields'=>array('sum(LigneCommandeclient.quantite) as qte','Article.name','Article.id'),'conditions' => array('LigneCommandeclient.id > ' => 0,@$cond1c, @$cond3c, @$cond4c )
//    ,'group'=>array('LigneCommandeclient.article_id')));
//    debug($commandeclts);
    $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
    //$articles = $this->Article->find('list');
    $familles = $this->Famille->find('list');
    $fournisseurs = $this->Fournisseur->find('list');
    $typeqtes=array();
    $typeqtes[1]="Quantité Négative";
    $typeqtes[2]="Quantité Zéro";
    $typeqtes[3]="Quantité Positive";
    //debug($fournisseurid);
    $this->set(compact('fournisseurid','familleid','fournisseurs','familles','type','typeqtes','date1','cond4c','cond4f','cond3c','cond3f','cond1c','cond1f','depotid','articleid','clientid','articles','depots','stockdepots'));
    
    }
        public function imprimer() { 
         $lien=  CakeSession::read('lien_stock');
              $vente="";
              if(!empty($lien)){
              foreach($lien as $k=>$liens){
              if(@$liens['lien']=='stockdepots'){
                    $vente=$liens['imprimer'];
               }}}
              if (( $vente <> 1)||(empty($lien))){
             $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
                  
                  
        $this->response->type('pdf');
        $this->layout = 'pdf';          
       $this->loadModel('Article');  
       $this->loadModel('Depot');
       $this->loadModel('Fournisseur');
           $this->loadModel('Famille');
           $this->loadModel('Lignecommande');
           $this->loadModel('LigneCommandeclient');
           $this->loadModel('Articlefournisseur');
       $date1 = date("Y-m-d");
       $cond1f = 'Commande.dateliv >= '."'".$date1."'";
       $cond1c = 'Commandeclient.dateliv >= '."'".$date1."'";
       $namedepot=""; 
       $condqte1="SUM(Stockdepot.quantite) <> 0 "; 
           $having=" HAVING ".$condqte1;
       //debug($this->request->query);die;
       if ($this->request->query['article_id']) {
            $articleid = $this->request->query['article_id'];
            $cond3 = 'Stockdepot.article_id ='.$articleid;
            $cond3f = 'Lignecommande.article_id ='.$articleid;
            $cond3c = 'Lignecommandeclient.article_id ='.$articleid;
        } 
        if ($this->request->query['depot_id']) {
            $depotid = $this->request->query['depot_id'];
            $cond4 = 'Stockdepot.depot_id ='.$depotid;
            $depots=$this->Depot->find('first',array('conditions'=>array('Depot.id'=>$depotid)));
            $namedepot=$depots['Depot']['designation'];
            $cond4f = 'Commande.depot_id ='.$depotid;
            $cond4c = 'Lignecommandeclient.depot_id ='.$depotid;
        }
        if ($this->request->query['familleid']) {
            $familleid = $this->request->query['familleid'];
            $cond5 = 'Article.famille_id ='.$familleid;
        }
        if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $articlefournisseurs=$this->Articlefournisseur->find('all',array('recursive'=>-1,'conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid)));
            $abc='0';
            foreach ($articlefournisseurs as $cl){
              $abc=$abc.','.$cl['Articlefournisseur']['article_id'];  
            }
            $cond6 = 'Stockdepot.article_id in ('.$abc.')';
        }
        if ($this->request->query['type']) {
            $typeqte_id= $this->request->query['type'];
            $typeqte_id=explode(',',$typeqte_id);
            $element = 0;
            unset($typeqte_id[array_search($element, $typeqte_id)]);
            //print_r($tab);
            //debug($typeqte_id);die;
            $condqte1="";
            $condqte2="";
            $condqte3="";$conditionkbira="";$condqte11="";$condqte12="";$condqte13="";
            //debug($typeqte_id);
            $i=count($typeqte_id);
            $type="0";
            //debug($i);
            $condqte1="";
            foreach ($typeqte_id as $k=>$typeqte){
            $type=$type.",".$typeqte  ;  
            //debug($typeqte);
            
            if($i !=1){ 
            if($k==0){
            if($typeqte==1){
            $condqte1=$condqte1."SUM(Stockdepot.quantite) < 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)> 0 ";   
            }        
            }else{    
            if($typeqte==1){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)< 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)> 0 ";   
            }
            }}else{
            if($typeqte==1){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)< 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)> 0 ";   
            }    
            }
            }
            //$conditionkbira = array('OR'=>array($condqte11,$condqte12,$condqte13));
            //debug($conditionkbira);
            $having=" HAVING ".$condqte1;
        }
            
        
    $stockdepots = $this->Stockdepot->find('all', array('fields'=>array('sum(Stockdepot.quantite) as qte','Article.name','Article.code','Article.id','sum(Stockdepot.prix*Stockdepot.quantite)/sum(Stockdepot.quantite) as prix')
    ,'conditions' => array(@$cond3, @$cond4,@$cond5,@$cond6)
    ,'group'=>array('Stockdepot.article_id'.@$having)
    ,'order'=>array('Article.code'=>'asc') 
    //,'limit'=>100
    ));
    //debug($stockdepots);die;
        $this->set(compact('date1','cond4c','cond4f','cond3c','cond3f','cond1c','cond1f','depotid','articleid','stockdepots','depotid','articleid','namedepot'));     
   
         }
        public function exp_etatexcel() { 
             $this->layout=null;
         $lien=  CakeSession::read('lien_stock');
              $vente="";
              if(!empty($lien)){
              foreach($lien as $k=>$liens){
              if(@$liens['lien']=='stockdepots'){
                    $vente=$liens['imprimer'];
               }}}
              if (( $vente <> 1)||(empty($lien))){
             $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
       $this->loadModel('Article');  
       $this->loadModel('Depot');
       $date1 = date("Y-m-d");
       $cond1f = 'Commande.dateliv >= '."'".$date1."'";
       $cond1c = 'Commandeclient.dateliv >= '."'".$date1."'";
       $namedepot=""; 
       $condqte1="SUM(Stockdepot.quantite) <> 0 "; 
           $having=" HAVING ".$condqte1;
       if ($this->request->query['article_id']) {
            $articleid = $this->request->query['article_id'];
            $cond3 = 'Stockdepot.article_id ='.$articleid;
            $cond3f = 'Lignecommande.article_id ='.$articleid;
            $cond3c = 'Lignecommandeclient.article_id ='.$articleid;
        } 
        if ($this->request->query['depot_id']) {
            $depotid = $this->request->query['depot_id'];
            $cond4 = 'Stockdepot.depot_id ='.$depotid;
            $depots=$this->Depot->find('first',array('conditions'=>array('Depot.id'=>$depotid)));
            $namedepot=$depots['Depot']['designation'];
            $cond4f = 'Commande.depot_id ='.$depotid;
            $cond4c = 'Lignecommandeclient.depot_id ='.$depotid;
        }
        if ($this->request->query['familleid']) {
            $familleid = $this->request->query['familleid'];
            $cond5 = 'Article.famille_id ='.$familleid;
        }
        if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $articlefournisseurs=$this->Articlefournisseur->find('all',array('recursive'=>-1,'conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid)));
            $abc='0';
            foreach ($articlefournisseurs as $cl){
              $abc=$abc.','.$cl['Articlefournisseur']['article_id'];  
            }
            $cond6 = 'Stockdepot.article_id in ('.$abc.')';
        }
        if ($this->request->query['type']) {
            $typeqte_id= $this->request->query['type'];
            $typeqte_id=explode(',',$typeqte_id);
            $element = 0;
            unset($typeqte_id[array_search($element, $typeqte_id)]);
            //print_r($tab);
            //debug($typeqte_id);die;
            $condqte1="";
            $condqte2="";
            $condqte3="";$conditionkbira="";$condqte11="";$condqte12="";$condqte13="";
            //debug($typeqte_id);
            $i=count($typeqte_id);
            $type="0";
            //debug($i);
            $condqte1="";
            foreach ($typeqte_id as $k=>$typeqte){
            $type=$type.",".$typeqte  ;  
            //debug($typeqte);
            
            if($i !=1){ 
            if($k==0){
            if($typeqte==1){
            $condqte1=$condqte1."SUM(Stockdepot.quantite) < 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)> 0 ";   
            }        
            }else{    
            if($typeqte==1){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)< 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)> 0 ";   
            }
            }}else{
            if($typeqte==1){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)< 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)> 0 ";   
            }    
            }
            }
            //$conditionkbira = array('OR'=>array($condqte11,$condqte12,$condqte13));
            //debug($conditionkbira);
            $having=" HAVING ".$condqte1;
        }
            
        
    $stockdepots = $this->Stockdepot->find('all', array('fields'=>array('sum(Stockdepot.quantite) as qte','Article.name','Article.code','Article.id','sum(Stockdepot.prix*Stockdepot.quantite)/sum(Stockdepot.quantite) as prix')
    ,'conditions' => array(@$cond3, @$cond4,@$cond5,@$cond6)
    ,'group'=>array('Stockdepot.article_id'.@$having)
    ,'order'=>array('Article.code'=>'asc')     
    ));
    
    //debug($stockdepots);die;
    
    
        $this->set(compact('date1','cond4c','cond4f','cond3c','cond3f','cond1c','cond1f','depotid','articleid','stockdepots','depotid','articleid','namedepot'));     
   
         } 
        
         
         
        public function indexx() {
           $lien=  CakeSession::read('lien_stock');
              $x="";
             //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='stockdepots'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
           $this->loadModel('Article');  
           $this->loadModel('Depot');
           $this->loadModel('Fournisseur');
           $this->loadModel('Famille');
           $this->loadModel('Lignecommande');
           $this->loadModel('LigneCommandeclient');
           $this->loadModel('Articlefournisseur');
           $date1 = date("Y-m-d");
           $cond1f = 'Commande.dateliv >= '."'".$date1."'";
           $cond1c = 'Commandeclient.dateliv >= '."'".$date1."'";
           $articleid="";$depotid="";
           
       if (isset($this->request->data) && !empty($this->request->data)) {
           //debug($this->request->data);
       if ($this->request->data['Stockdepot']['article_id']) {
            $articleid= $this->request->data['Stockdepot']['article_id'];
            $cond3 = 'Stockdepot.article_id ='.$articleid;
            $cond3f = 'Lignecommande.article_id ='.$articleid;
            $cond3c = 'Lignecommandeclient.article_id ='.$articleid;
            $condgroup="";
        } 
        if ($this->request->data['Stockdepot']['depot_id']) {
            $depotid= $this->request->data['Stockdepot']['depot_id'];
            $cond4 = 'Stockdepot.depot_id in'.$depotid;
            $cond4f = 'Commande.depot_id ='.$depotid;
            $cond4c = 'Lignecommandeclient.depot_id ='.$depotid;
        }
        if ($this->request->data['Stockdepot']['famille_id']) {
            $familleid= $this->request->data['Stockdepot']['famille_id'];
            $cond5 = 'Article.famille_id ='.$familleid;
        }
        if ($this->request->data['Stockdepot']['fournisseur_id']) {
            $fournisseurid = $this->request->data['Stockdepot']['fournisseur_id'];
            $articlefournisseurs=$this->Articlefournisseur->find('all',array('recursive'=>-1,'conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid)));
            $abc='0';
            foreach ($articlefournisseurs as $cl){
                if(!empty($cl['Articlefournisseur']['article_id'])){
              $abc=$abc.','.$cl['Articlefournisseur']['article_id']; 
                }
            }
            $cond6 = 'Stockdepot.article_id in ('.$abc.')';
        }
        if ($this->request->data['Stockdepot']['typeqte_id']) {
            $typeqte_id= $this->request->data['Stockdepot']['typeqte_id'];
            $condqte1="";
            $condqte2="";
            $condqte3="";$conditionkbira="";$condqte11="";$condqte12="";$condqte13="";
            //debug($typeqte_id);
            $i=count($typeqte_id);
            $type="0";
            //debug($i);
            foreach ($typeqte_id as $k=>$typeqte){
            $type=$type.",".$typeqte  ;  
            //debug($typeqte);
            if($i !=1){ 
            if($k==0){
            if($typeqte==1){
            $condqte11="Stockdepot.quantite < 0";   
            }
            if($typeqte==2){
            $condqte12="  Stockdepot.quantite = 0";   
            }
            if($typeqte==3){
            $condqte13=" Stockdepot.quantite > 0";   
            }        
            }else{    
            if($typeqte==1){
            $condqte11="Stockdepot.quantite < 0";   
            }
            if($typeqte==2){
            $condqte12="Stockdepot.quantite = 0";   
            }
            if($typeqte==3){
            $condqte13="Stockdepot.quantite > 0";   
            }
            }}else{
            if($typeqte==1){
            $condqte11="Stockdepot.quantite < 0";   
            }
            if($typeqte==2){
            $condqte12="  Stockdepot.quantite = 0";   
            }
            if($typeqte==3){
            $condqte13=" Stockdepot.quantite > 0";   
            }    
            }
            }
            $conditionkbira = array('OR'=>array($condqte11,$condqte12,$condqte13));
        }
    }
    $depotchoix=$this->Depot->find('all',array('fields' => array('Depot.designation'),'conditions' => array(@$cond4,'Depot.typeetatarticle_id'=>1)));
    $stockdepots = $this->Stockdepot->find('all', array('fields'=>array('sum(Stockdepot.quantite) as qte','Article.name','Article.code','Article.id','sum(Stockdepot.prix*Stockdepot.quantite)/sum(Stockdepot.quantite) as prix')
    ,'conditions' => array(@$cond3, @$cond4,@$conditionkbira,@$cond5,@$cond6)
    ,'group'=>array('Stockdepot.article_id')
    ,'order'=>array('Article.code'=>'asc')      
        ));
    
//    $commandefrss = $this->Lignecommande->find('all', array('fields'=>array('sum(Lignecommande.quantite) as qte','Article.name','Article.id'),'conditions' => array('Lignecommande.id > ' => 0,@$cond1f, @$cond3f, @$cond4f )
//    ,'group'=>array('Lignecommande.article_id')));
//    debug($commandefrss);
//    $commandeclts = $this->LigneCommandeclient->find('all', array('fields'=>array('sum(LigneCommandeclient.quantite) as qte','Article.name','Article.id'),'conditions' => array('LigneCommandeclient.id > ' => 0,@$cond1c, @$cond3c, @$cond4c )
//    ,'group'=>array('LigneCommandeclient.article_id')));
//    debug($commandeclts);
    $depots = $this->Depot->find('list',array('fields' => array('Depot.designation')));
    $articles = array();//$this->Article->find('list');
    $familles = $this->Famille->find('list');
    $fournisseurs = $this->Fournisseur->find('list');
    $typeqtes=array();
    $typeqtes[1]="Quantité Négative";
    $typeqtes[2]="Quantité Zéro";
    $typeqtes[3]="Quantité Positive";
    //debug($fournisseurid);
    $this->set(compact('depotchoix','fournisseurid','familleid','fournisseurs','familles','type','typeqtes','date1','cond4c','cond4f','cond3c','cond3f','cond1c','cond1f','depotid','articleid','clientid','articles','depots','stockdepots',$this->paginate()));
    
    }
    
    
    
        public function indexpardepot() {
           $lien=  CakeSession::read('lien_stock');
              $x="";
             //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='stockdepots'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
           $this->loadModel('Article');  
           $this->loadModel('Depot');
           $this->loadModel('Fournisseur');
           $this->loadModel('Famille');
           $this->loadModel('Lignecommande');
           $this->loadModel('LigneCommandeclient');
           $this->loadModel('Articlefournisseur');
           $date1 = date("Y-m-d");
           $cond1f = 'Commande.dateliv >= '."'".$date1."'";
           $cond1c = 'Commandeclient.dateliv >= '."'".$date1."'";
           $articleid="";$depotid="";
           $stockdepots=array();
            $condqte1="SUM(Stockdepot.quantite) <> 0 "; 
           $having=" HAVING ".$condqte1;
       if (isset($this->request->data) && !empty($this->request->data)) {
           //debug($this->request->data);
       if ($this->request->data['Stockdepot']['article_id']) {
            $articleid= $this->request->data['Stockdepot']['article_id'];
            $cond3 = 'Stockdepot.article_id ='.$articleid;
            $cond3f = 'Lignecommande.article_id ='.$articleid;
            $cond3c = 'Lignecommandeclient.article_id ='.$articleid;
            $condgroup="";
        } 
        if ($this->request->data['Stockdepot']['depot_id']) {
            $depotid= $this->request->data['Stockdepot']['depot_id'];
            $cond4 = 'Stockdepot.depot_id ='.$depotid;
            $cond4f = 'Commande.depot_id ='.$depotid;
            $cond4c = 'Lignecommandeclient.depot_id ='.$depotid;
            $conddepot = 'Depot.id ='.$depotid;
        $depotalls = $this->Depot->find('all',array('conditions' => array($conddepot,'Depot.typeetatarticle_id' => 1),'recursive'=>-1));
        }else{
        $depotalls = $this->Depot->find('all',array( 'conditions' => array('Depot.typeetatarticle_id' => 1),'recursive'=>-1));
        }
        if ($this->request->data['Stockdepot']['famille_id']) {
            $familleid= $this->request->data['Stockdepot']['famille_id'];
            $cond5 = 'Article.famille_id ='.$familleid;
        }
        if ($this->request->data['Stockdepot']['fournisseur_id']) {
            $fournisseurid = $this->request->data['Stockdepot']['fournisseur_id'];
            $articlefournisseurs=$this->Articlefournisseur->find('all',array('recursive'=>-1,'conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid)));
            $abc='0';
            foreach ($articlefournisseurs as $cl){
                if(!empty($cl['Articlefournisseur']['article_id'])){
              $abc=$abc.','.$cl['Articlefournisseur']['article_id']; 
                }
            }
            $cond6 = 'Stockdepot.article_id in ('.$abc.')';
        }
         if ($this->request->data['Stockdepot']['typeqte_id']) {
            $typeqte_id= $this->request->data['Stockdepot']['typeqte_id'];
            $condqte1="";
            $condqte2="";
            $condqte3="";$conditionkbira="";$condqte11="";$condqte12="";$condqte13="";
            //debug($typeqte_id);
            $i=count($typeqte_id);
            $type="0";
            //debug($i);
            $condqte1="";
            foreach ($typeqte_id as $k=>$typeqte){
            $type=$type.",".$typeqte  ;  
            //debug($typeqte);
            
            if($i !=1){ 
            if($k==0){
            if($typeqte==1){
            $condqte1=$condqte1."SUM(Stockdepot.quantite) < 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)> 0 ";   
            }        
            }else{    
            if($typeqte==1){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)< 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)> 0 ";   
            }
            }}else{
            if($typeqte==1){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)< 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)> 0 ";   
            }    
            }
            }
            //$conditionkbira = array('OR'=>array($condqte11,$condqte12,$condqte13));
            //debug($conditionkbira);
            $having=" HAVING ".$condqte1;
        }
    
    $stockdepots = $this->Stockdepot->find('all', array('fields'=>array('sum(Stockdepot.quantite) as qte','Article.name','Article.code','Article.id','sum(Stockdepot.prix*Stockdepot.quantite)/sum(Stockdepot.quantite) as prix')
    ,'conditions' => array(@$cond3, @$cond4,@$cond5,@$cond6)
    ,'group'=>array('Stockdepot.article_id'.@$having)
    //,'order'=>array('Article.code'=>'desc')      
    ));
    }else{
    $depotalls = $this->Depot->find('all',array( 'conditions' => array('Depot.typeetatarticle_id' => 1),'recursive'=>-1));
    } 
    $depots = $this->Depot->find('list',array('fields' => array('Depot.designation'), 'conditions' => array('Depot.typeetatarticle_id' => 1)));
    //$articles = $this->Article->find('list');
    $familles = $this->Famille->find('list');
    $fournisseurs = $this->Fournisseur->find('list');
    $typeqtes=array();
    $typeqtes[1]="Quantité Négative";
    $typeqtes[2]="Quantité Zéro";
    $typeqtes[3]="Quantité Positive";
    //debug($depotalls);die;
    $this->set(compact('depotalls','fournisseurid','familleid','fournisseurs','familles','type','typeqtes','date1','cond4c','cond4f','cond3c','cond3f','cond1c','cond1f','depotid','articleid','clientid','articles','depots','stockdepots'));
    
    }
        public function imprimerpardepot() { 
         $lien=  CakeSession::read('lien_stock');
              $vente="";
              if(!empty($lien)){
              foreach($lien as $k=>$liens){
              if(@$liens['lien']=='stockdepots'){
                    $vente=$liens['imprimer'];
               }}}
              if (( $vente <> 1)||(empty($lien))){
             $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
       $this->loadModel('Article');  
       $this->loadModel('Depot');
       $this->loadModel('Fournisseur');
           $this->loadModel('Famille');
           $this->loadModel('Lignecommande');
           $this->loadModel('LigneCommandeclient');
           $this->loadModel('Articlefournisseur');
       $date1 = date("Y-m-d");
       $cond1f = 'Commande.dateliv >= '."'".$date1."'";
       $cond1c = 'Commandeclient.dateliv >= '."'".$date1."'";
       $namedepot=""; 
       //debug($this->request->query);die;
       if ($this->request->query['article_id']) {
            $articleid = $this->request->query['article_id'];
            $cond3 = 'Stockdepot.article_id ='.$articleid;
            $cond3f = 'Lignecommande.article_id ='.$articleid;
            $cond3c = 'Lignecommandeclient.article_id ='.$articleid;
        } 
        if ($this->request->query['depot_id']) {
            $depotid = $this->request->query['depot_id'];
            $cond4 = 'Stockdepot.depot_id ='.$depotid;
            $depots=$this->Depot->find('first',array('conditions'=>array('Depot.id'=>$depotid)));
            $namedepot=$depots['Depot']['designation'];
            $cond4f = 'Commande.depot_id ='.$depotid;
            $cond4c = 'Lignecommandeclient.depot_id ='.$depotid;
        $depotalls = $this->Depot->find('all',array('conditions' => array($conddepot,'Depot.typeetatarticle_id' => 1),'recursive'=>-1));
        }else{
        $depotalls = $this->Depot->find('all',array( 'conditions' => array('Depot.typeetatarticle_id' => 1),'recursive'=>-1));
        }
        if ($this->request->query['familleid']) {
            $familleid = $this->request->query['familleid'];
            $cond5 = 'Article.famille_id ='.$familleid;
        }
        if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $articlefournisseurs=$this->Articlefournisseur->find('all',array('recursive'=>-1,'conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid)));
            $abc='0';
            foreach ($articlefournisseurs as $cl){
              $abc=$abc.','.$cl['Articlefournisseur']['article_id'];  
            }
            $cond6 = 'Stockdepot.article_id in ('.$abc.')';
        }
        if ($this->request->query['type']) {
            $typeqte_id= $this->request->query['type'];
            $typeqte_id=explode(',',$typeqte_id);
            $element = 0;
            unset($typeqte_id[array_search($element, $typeqte_id)]);
            //print_r($tab);
            //debug($typeqte_id);die;
            $condqte1="";
            $condqte2="";
            $condqte3="";$conditionkbira="";$condqte11="";$condqte12="";$condqte13="";
            //debug($typeqte_id);
            $i=count($typeqte_id);
            $type="0";
            //debug($i);
            $condqte1="";
            foreach ($typeqte_id as $k=>$typeqte){
            $type=$type.",".$typeqte  ;  
            //debug($k);
            
            if($i !=1){ 
            if($k==1){
            if($typeqte==1){
            $condqte1=$condqte1."SUM(Stockdepot.quantite) < 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)> 0 ";   
            }        
            }else{    
            if($typeqte==1){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)< 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)> 0 ";   
            }
            }}else{
            if($typeqte==1){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)< 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)> 0 ";   
            }    
            }
            }
            //$conditionkbira = array('OR'=>array($condqte11,$condqte12,$condqte13));
            //debug($conditionkbira);
            $having=" HAVING ".$condqte1;
        }
            
        
    $stockdepots = $this->Stockdepot->find('all', array('fields'=>array('sum(Stockdepot.quantite) as qte','Article.name','Article.code','Article.id','sum(Stockdepot.prix*Stockdepot.quantite)/sum(Stockdepot.quantite) as prix')
    ,'conditions' => array(@$cond3, @$cond4,@$cond5,@$cond6)
    ,'group'=>array('Stockdepot.article_id'.@$having)
    //,'order'=>array('Article.code'=>'asc')    
    ));
        $this->set(compact('depotalls','date1','cond4c','cond4f','cond3c','cond3f','cond1c','cond1f','depotid','articleid','stockdepots','depotid','articleid','namedepot'));     
   
    } 
        public function exp_etatexcelpardepot() { 
             $this->layout=null;
              $lien=  CakeSession::read('lien_stock');
              $vente="";
              if(!empty($lien)){
              foreach($lien as $k=>$liens){
              if(@$liens['lien']=='stockdepots'){
                    $vente=$liens['imprimer'];
               }}}
              if (( $vente <> 1)||(empty($lien))){
             $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
       $this->loadModel('Article');  
       $this->loadModel('Depot');
       $this->loadModel('Articlefournisseur');
       $date1 = date("Y-m-d");
       $cond1f = 'Commande.dateliv >= '."'".$date1."'";
       $cond1c = 'Commandeclient.dateliv >= '."'".$date1."'";
       $namedepot=""; 
       if ($this->request->query['article_id']) {
            $articleid = $this->request->query['article_id'];
            $cond3 = 'Stockdepot.article_id ='.$articleid;
            $cond3f = 'Lignecommande.article_id ='.$articleid;
            $cond3c = 'Lignecommandeclient.article_id ='.$articleid;
        } 
        if ($this->request->query['depot_id']) {
            $depotid = $this->request->query['depot_id'];
            $cond4 = 'Stockdepot.depot_id ='.$depotid;
            $depots=$this->Depot->find('first',array('conditions'=>array('Depot.id'=>$depotid)));
            $namedepot=$depots['Depot']['designation'];
            $cond4f = 'Commande.depot_id ='.$depotid;
            $cond4c = 'Lignecommandeclient.depot_id ='.$depotid;
        $depotalls = $this->Depot->find('all',array('conditions' => array($conddepot,'Depot.typeetatarticle_id' => 1),'recursive'=>-1));
        }else{
        $depotalls = $this->Depot->find('all',array( 'conditions' => array('Depot.typeetatarticle_id' => 1),'recursive'=>-1));
        }
        if ($this->request->query['familleid']) {
            $familleid = $this->request->query['familleid'];
            $cond5 = 'Article.famille_id ='.$familleid;
        }
        if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            $articlefournisseurs=$this->Articlefournisseur->find('all',array('recursive'=>-1,'conditions'=>array('Articlefournisseur.fournisseur_id'=>$fournisseurid)));
            $abc='0';
            foreach ($articlefournisseurs as $cl){
                if(!empty($cl['Articlefournisseur']['article_id'])){
                $abc=$abc.','.$cl['Articlefournisseur']['article_id'];  
                }
            }
            $cond6 = 'Stockdepot.article_id in ('.$abc.')';
        }
        if ($this->request->query['type']) {
            $typeqte_id= $this->request->query['type'];
            $typeqte_id=explode(',',$typeqte_id);
            $element = 0;
            unset($typeqte_id[array_search($element, $typeqte_id)]);
            //print_r($tab);
            //debug($typeqte_id);die;
            $condqte1="";
            $condqte2="";
            $condqte3="";$conditionkbira="";$condqte11="";$condqte12="";$condqte13="";
            //debug($typeqte_id);
            $i=count($typeqte_id);
            $type="0";
            //debug($i);
            $condqte1="";
            foreach ($typeqte_id as $k=>$typeqte){
            $type=$type.",".$typeqte  ;  
            //debug($k);
            
            if($i !=1){ 
            if($k==1){
            if($typeqte==1){
            $condqte1=$condqte1."SUM(Stockdepot.quantite) < 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)> 0 ";   
            }        
            }else{    
            if($typeqte==1){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)< 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."OR SUM(Stockdepot.quantite)> 0 ";   
            }
            }}else{
            if($typeqte==1){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)< 0 ";   
            }
            if($typeqte==2){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)= 0 ";   
            }
            if($typeqte==3){
            $condqte1=$condqte1."SUM(Stockdepot.quantite)> 0 ";   
            }    
            }
            }
            //$conditionkbira = array('OR'=>array($condqte11,$condqte12,$condqte13));
            //debug($conditionkbira);
            $having=" HAVING ".$condqte1;
        }
            
        
    $stockdepots = $this->Stockdepot->find('all', array('fields'=>array('sum(Stockdepot.quantite) as qte','Article.name','Article.code','Article.id','sum(Stockdepot.prix*Stockdepot.quantite)/sum(Stockdepot.quantite) as prix')
    ,'conditions' => array(@$cond3, @$cond4,@$cond5,@$cond6)
    ,'group'=>array('Stockdepot.article_id'.@$having)
    ,'order'=>array('Article.code'=>'asc')    
    ));
    $this->set(compact('depotalls','date1','cond4c','cond4f','cond3c','cond3f','cond1c','cond1f','depotid','articleid','stockdepots','depotid','articleid','namedepot'));     
    }
	
         
         
         
         
         
         
         
         
         
         
         public function view($id = null) {
             $lien=  CakeSession::read('lien_stock');
              $x="";
             //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='stockdepots'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
		if (!$this->Stockdepot->exists($id)) {
			throw new NotFoundException(__('Invalid stockdepot'));
		}
		$options = array('conditions' => array('Stockdepot.' . $this->Stockdepot->primaryKey => $id));
		$this->set('stockdepot', $this->Stockdepot->find('first', $options));
	}


	public function add() {
            $lien=  CakeSession::read('lien_stock');
              $vente="";
              if(!empty($lien)){
              foreach($lien as $k=>$liens){
              if(@$liens['lien']=='stockdepots'){
                    $vente=$liens['add'];
               }}}
              if (( $vente <> 1)||(empty($lien))){
             $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
		if ($this->request->is('post')) {
			$this->Stockdepot->create();
			if ($this->Stockdepot->save($this->request->data)) {
				$this->Session->setFlash(__('The stockdepot has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The stockdepot could not be saved. Please, try again.'));
			}
		}
		$articles = $this->Stockdepot->Article->find('list');
		$depots = $this->Stockdepot->Depot->find('list');
		$this->set(compact('articles', 'depots'));
	}


	public function edit($id = null) {
            $lien=  CakeSession::read('lien_stock');
              $vente="";
              if(!empty($lien)){
              foreach($lien as $k=>$liens){
              if(@$liens['lien']=='stockdepots'){
                    $vente=$liens['edit'];
               }}}
              if (( $vente <> 1)||(empty($lien))){
             $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
		if (!$this->Stockdepot->exists($id)) {
			throw new NotFoundException(__('Invalid stockdepot'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Stockdepot->save($this->request->data)) {
				$this->Session->setFlash(__('The stockdepot has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The stockdepot could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Stockdepot.' . $this->Stockdepot->primaryKey => $id));
			$this->request->data = $this->Stockdepot->find('first', $options);
		}
		$articles = $this->Stockdepot->Article->find('list');
		$depots = $this->Stockdepot->Depot->find('list');
		$this->set(compact('articles', 'depots'));
	}


	public function delete($id = null) {
            $lien=  CakeSession::read('lien_stock');
              $vente="";
              if(!empty($lien)){
              foreach($lien as $k=>$liens){
              if(@$liens['lien']=='stockdepots'){
                    $vente=$liens['delete'];
               }}}
              if (( $vente <> 1)||(empty($lien))){
             $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                  }
		$this->Stockdepot->id = $id;
		if (!$this->Stockdepot->exists()) {
			throw new NotFoundException(__('Invalid stockdepot'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Stockdepot->delete()) {
			$this->Session->setFlash(__('Stockdepot deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Stockdepot was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
