<?php
App::uses('AppController', 'Controller');
/**
 * Articles Controller
 *
 * @property Article $Article
 */
class ArticlesController extends AppController {
/**
 * index method
 *
 * @return void
 */
	public function index() {
             $lien=  CakeSession::read('lien_stock');
               $article="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='articles'){
                        $article=1;
                }}}
              if (( $article <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
              if (isset($this->request->data) && !empty($this->request->data)) {
                  //debug($this->request->data);die;
                  if ($this->request->data['Article']['code']) {
                     $code = $this->request->data['Article']['code'];
                     $cond1 = 'Article.code ='.$code;
                 }        
                   if ($this->request->data['Article']['soussousfamille_id']) {
                     $soussousfamilleid = $this->request->data['Article']['soussousfamille_id'];
                     $cond2 = 'Article.soussousfamille_id ='.$soussousfamilleid;
                 } 
                 if ($this->request->data['Article']['sousfamille_id']) {
                     $sousfamilleid = $this->request->data['Article']['sousfamille_id'];
                     $cond3 = 'Article.sousfamille_id ='.$sousfamilleid;
                 } 
                  if ($this->request->data['Article']['famille_id']) {
                     $familleid = $this->request->data['Article']['famille_id'];
                     $cond4 = 'Article.famille_id ='.$familleid;
                 } 
             } 
  $articles = $this->Article->find('all', array( 'conditions' => array( @$cond1, @$cond2, @$cond3, @$cond4 )));   
            // debug($articles);die;
               $familles = $this->Article->Famille->find('list');   
               $sousfamilles = $this->Article->Sousfamille->find('list');   
               $soussousfamilles = $this->Article->Soussousfamille->find('list');   
         $this->set(compact('code','familleid','sousfamilleid','soussousfamilleid','familles','sousfamilles','soussousfamilles','articles', $this->paginate()));
	}

	public function view($id = null) {
             $lien=  CakeSession::read('lien_stock');
               $article="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='articles'){
                        $article=1;
                }}}
              if (( $article <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Articlefournisseur');
             $this->loadModel('Tag');
             $this->loadModel('Articletag');
             $this->loadModel('Fournisseur');
             $this->loadModel('Client');
             $this->loadModel('Articleclient');
             $this->loadModel('Remiseartfamille');
             $this->loadModel('Familleclient');
		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}
		$options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id));
		$this->set('article', $this->Article->find('first', $options));
                $arttags=$this->Articletag->find('all',array('conditions'=>array('Articletag.article_id'=>$id)));
                
                $artfours=$this->Articlefournisseur->find('all',array('conditions'=>array('Articlefournisseur.article_id'=>$id)));
                $taglist="";
                foreach ($arttags as $at){
                    $taglist=$taglist." ".$at['Tag']['name'];
                }
               $clients=$this->Client->find('list');
               $familleclients=$this->Familleclient->find('list');
                $artclient=$this->Articleclient->find('all',array(
                    'conditions'=>array('Articleclient.article_id' => $id)
                    ));
                $artfamilleclients = $this->Remiseartfamille->find('all',array(
                    'conditions'=>array('Remiseartfamille.article_id' => $id)
                    ));
                
                $this->set(compact('familleclients','artfamilleclients','artfours','taglist','artclient','clients'));
	}
        
        public function imprimerimage($id= null) {
              $lien=  CakeSession::read('lien_stock');
               $article="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='articles'){
                        $article=$liens['imprimer'];
                }}}
              if (( $article <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $article=$this->Article->find('first',array('conditions'=>array('Article.id' => $id)));
             $this->set(compact('article'));
          }

	public function add() {
                $lien=  CakeSession::read('lien_stock');
               $article="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='articles'){
                        $article=$liens['add'];
                }}}
              if (( $article <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Fournisseur');
             $this->loadModel('Articlefournisseur');
            $this->loadModel('Client');
             $this->loadModel('Articleclient');
             $this->loadModel('Tag');
             $this->loadModel('Articletag');
             $this->loadModel('Familleclient');
             $this->loadModel('Remiseartfamille');
             $this->loadModel('Typeetatarticle');
             $this->loadModel('Typestockarticle');
		if ($this->request->is('post')) {
                  //debug($this->request->data);die;
                  
			$this->Article->create();
                        $this->request->data['Article']['sousfamille_id']= @$this->request->data['sousfamille_id'];
                        $this->request->data['Article']['soussousfamille_id']= @$this->request->data['soussousfamille_id'];
                        
                        $this->request->data['Article']['prixuttc']=  $this->request->data['Article']['prixvente']*(1+($this->request->data['Article']['tva']/100));
                        
                        if ($this->Article->save($this->request->data)) {
                            $id=$this->Article->id;
                            $articletag=array();
                             
                            
                            if(!empty($this->request->data['Article']['tag_id'])){
                                foreach ($this->request->data['Article']['tag_id'] as $t  ){
                                    $articletag['article_id']=$id;
                                    $articletag['tag_id']=$t;
                                    $this->Articletag->create();
                                    $this->Articletag->save($articletag);
                                }
                            }
                            
                            if(!empty($this->request->data['Articlefournisseur'])){
                            foreach (  $this->request->data['Articlefournisseur'] as $f   ){
                              $tab=array();
                              if ($f['sup']!=1){
                                $tab['article_id']=$id;
                                $tab['fournisseur_id']=$f['fournisseur_id'];
                                $tab['prix']=$f['prix'];
                                $tab['reference']=$f['reference'];
                              $this->Articlefournisseur->create();
                              $this->Articlefournisseur->save($tab);
                              }
                                
                            }}
                            if(!empty($this->request->data['Articleclient'])){
                             foreach (  $this->request->data['Articleclient'] as $f   ){
                              $tab=array();
                              if ($f['sup']!=1){
                                $tab['article_id']=$id;
                                $tab['client_id']=$f['client_id'];
                                $tab['remise']=$f['remise'];
                              $this->Articleclient->create();
                              $this->Articleclient->save($tab);
                              }
                                
                            }}
                            if(!empty($this->request->data['Remiseartfamille'])){
                            foreach (  $this->request->data['Remiseartfamille'] as $f   ){
                              $tab=array();
                              if ($f['sup']!=1){
                                $tab['article_id']=$id;
                                $tab['familleclient_id']=$f['familleclient_id'];
                                $tab['remise']=$f['remise'];
                              $this->Remiseartfamille->create();
                              $this->Remiseartfamille->save($tab);
                              }
                                
                            }}
                            
				$this->Session->setFlash(__('The article has been saved'));
				$this->redirect(array('action' => 'index'));
                                
			} else {
				$this->Session->setFlash(__('The article could not be saved. Please, try again.'));
			}
                        
		}
		$familles = $this->Article->Famille->find('list');
		$sousfamilles = $this->Article->Sousfamille->find('list');
		$soussousfamilles = $this->Article->Soussousfamille->find('list');
		$unites = $this->Article->Unite->find('list');
                $fournisseurs=$this->Fournisseur->find('list');
                $familleclients=$this->Familleclient->find('list');
                $clients=$this->Client->find('list');
                $typeetatarticles=$this->Typeetatarticle->find('list');
                $typestockarticles=$this->Typestockarticle->find('list');
                $tags=$this->Tag->find('list');
                //debug($fournisseurs);die;
		$this->set(compact('typestockarticles','typeetatarticles','familleclients','familles', 'sousfamilles', 'soussousfamilles', 'unites','fournisseurs','clients','tags'));
	}

	public function edit($id = null) {
            $lien=  CakeSession::read('lien_stock');
               $article="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='articles'){
                        $article=$liens['edit'];
                }}}
              if (( $article <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
             $this->loadModel('Fournisseur');
             $this->loadModel('Articlefournisseur');
             $this->loadModel('Client');
             $this->loadModel('Articleclient');
             $this->loadModel('Tag');
             $this->loadModel('Articletag');
             $this->loadModel('Remiseartfamille');
             $this->loadModel('Familleclient');
             $this->loadModel('Typeetatarticle');
             $this->loadModel('Typestockarticle');
		if (!$this->Article->exists($id)) {
			throw new NotFoundException(__('Invalid article'));
		}
                $article=$this->Article->find('first',array('conditions'=>array('Article.id' => $id)));
                $familleid=$article['Famille']['id'];
                $sousfamilleid=$article['Sousfamille']['id'];
		if ($this->request->is('post') || $this->request->is('put')) {
                    //debug($this->request->data);die;            
                     if($this->request->data['Article']['famille_id']!= $familleid){
                        if ($this->request->data['Article']['sousfamille_id']!= @$this->request->data['sousfamille_id']) {
                             $this->request->data['Article']['sousfamille_id']='';
                             $this->request->data['Article']['soussousfamille_id']=''; 
                            if(@$this->request->data['sousfamille_id']!=0){
                            $this->request->data['Article']['sousfamille_id']= @$this->request->data['sousfamille_id'] ;
                            $this->request->data['Article']['soussousfamille_id']='';
                            if( @$this->request->data['soussousfamille_id']!=0){
                            $this->request->data['Article']['soussousfamille_id']= @$this->request->data['soussousfamille_id'];
                           }
                          }
                        }
                     }else  if($this->request->data['Article']['sousfamille_id']!= $sousfamilleid){
                         
                                $this->request->data['Article']['soussousfamille_id']='';                
                                if( @$this->request->data['soussousfamille_id']!=0){
                                $this->request->data['Article']['soussousfamille_id']= @$this->request->data['soussousfamille_id'];
                               }
                         
                         
                     }
                     
                     
                      $this->request->data['Article']['prixuttc']=  $this->request->data['Article']['prixvente']*(1+($this->request->data['Article']['tva']/100));
                      
                     
                   // debug($this->request->data);die;
			if ($this->Article->save($this->request->data)) {
                            $this->Articletag->deleteAll(array('Articletag.article_id'=>$id),false);
                             if(!empty($this->request->data['Article']['tag'])){
                                foreach ($this->request->data['Article']['tag'] as $t  ){
                                    $articletag['article_id']=$id;
                                    $articletag['tag_id']=$t;
                                    $this->Articletag->create();
                                    $this->Articletag->save($articletag);
                                }
                             }
                             
                            $this->Articlefournisseur->deleteAll(array('Articlefournisseur.article_id'=>$id),false);
                            if(!empty($this->request->data['Articlefournisseur'])){
                              foreach (  $this->request->data['Articlefournisseur'] as $af   ){
                              $tab=array();
                              if ($af['sup']!=1){
                                $tab['id']=@$af['id'];
                                $tab['article_id']=$id;
                                $tab['fournisseur_id']=$af['fournisseur_id'];
                                $tab['prix']=$af['prix'];
                                $tab['reference']=$af['reference'];
                              $this->Articlefournisseur->create();
                              $this->Articlefournisseur->save($tab);
                              }else {
                               $this->Articlefournisseur->deleteAll(array('Articlefournisseur.id'=>$af['id']),false); 
                              }
                        }}
                            $this->Articleclient->deleteAll(array('Articleclient.article_id'=>$id),false);
                            if(!empty($this->request->data['Articleclient'])){
                             foreach (  $this->request->data['Articleclient'] as $f   ){
                              $tab=array();
                              if ($f['sup']!=1){
                                $tab['article_id']=$id;
                                $tab['client_id']=$f['client_id'];
                                $tab['remise']=$f['remise'];
                              $this->Articleclient->create();
                              $this->Articleclient->save($tab);
                              }else {
                               $this->Articleclient->deleteAll(array('Articleclient.id'=>$f['id']),false); 
                              }
                            }
                        }
                            
				$this->Session->setFlash(__('The article has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The article could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Article.' . $this->Article->primaryKey => $id));
			$this->request->data = $this->Article->find('first', $options);
		}
               
		$familles = $this->Article->Famille->find('list');
		$sousfamilles = $this->Article->Sousfamille->find('list',array('conditions'=>array('Sousfamille.famille_id' => $familleid)));
		$soussousfamilles = $this->Article->Soussousfamille->find('list',array('conditions'=>array('Soussousfamille.sousfamille_id' => $sousfamilleid)));
		$unites = $this->Article->Unite->find('list');
                $fournisseurs=$this->Fournisseur->find('list');
                $clients=$this->Client->find('list');
                $tags=$this->Tag->find('list');
                $typeetatarticles=$this->Typeetatarticle->find('list');
                $typestockarticles=$this->Typestockarticle->find('list');
                $familleclients=$this->Familleclient->find('list');
                $artclient=$this->Articleclient->find('all',array(
                    'conditions'=>array('Articleclient.article_id' => $id)
                    ));
                $artfournisseur = $this->Articlefournisseur->find('all',array(
                    'conditions'=>array('Articlefournisseur.article_id' => $id)
                    ));
                $artfamilleclients = $this->Remiseartfamille->find('all',array(
                    'conditions'=>array('Remiseartfamille.article_id' => $id)
                    ));
     
		$this->set(compact('typestockarticles','typeetatarticles','artfamilleclients','familleclients','familles', 'sousfamilles','familleid', 'soussousfamilles','article', 'unites','fournisseurs','clients','artclient','tags','articlefournisseurs','artfournisseur'));
	}

	public function delete($id = null) {
            $lien=  CakeSession::read('lien_stock');
               $article="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='articles'){
                        $article=$liens['delete'];
                }}}
              if (( $article <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
            $this->loadModel('Articlefournisseur');
            $this->loadModel('Articleclient');
            $this->loadModel('Articletag');      
		$this->Article->id = $id;
		if (!$this->Article->exists()) {
			throw new NotFoundException(__('Invalid article'));
		}
		$this->request->onlyAllow('post', 'delete');
                
                    $this->Articlefournisseur->deleteAll(array('Articlefournisseur.article_id'=>$id),false);
                    $this->Articleclient->deleteAll(array('Articleclient.article_id'=>$id),false);
                    $this->Articletag->deleteAll(array('Articletag.article_id'=>$id),false);
                
		if ($this->Article->delete()) {
			$this->Session->setFlash(__('Article deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Article was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
          public function imprimerrecherche() { 
         $lien=  CakeSession::read('lien_stock');
               $article="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='articles'){
                        $article=$liens['imprimer'];
                }}}
              if (( $article <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
       $this->loadModel('Famille');       
              
       if ($this->request->query['code']) {
            $code= $this->request->query['code'];
            $cond1 = 'Article.code ='.$code;
        } 
         if ($this->request->query['familleid']) {
            $familleid= $this->request->query['familleid'];
            $cond2 = 'Article.famille_id ='.$familleid;
        } 
        if ($this->request->query['sousfamilleid']) {
            $sousfamilleid= $this->request->query['sousfamilleid'];
            $cond3 = 'Article.sousfamille_id ='.$sousfamilleid;
        } 
        if ($this->request->query['soussousfamilleid']) {
            $soussousfamilleid= $this->request->query['soussousfamilleid'];
            $cond4 = 'Article.soussousfamille_id ='.$soussousfamilleid;
        } 
  $articles = $this->Article->find('all', array( 'conditions' => array('Article.id > ' => 0,@$cond1, @$cond2, @$cond3, @$cond4 )));
                 $this->set(compact('articles','code','familleid','sousfamilleid','soussousfamilleid'));     
   
         }
      
         public function getsousfamille(){
              $this->layout = null;
              $this->loadModel('Sousfamille');
              $this->loadModel('Famille');
   
            $data = $this->request->data;
            $familleid= $data['familleid'];
 
            $sousfamilles=$this->Sousfamille->find('all', array( 'conditions' => array('Sousfamille.famille_id'=>$familleid),'recursive'=>-1)) ;
            $select="<select name='sousfamille_id'  champ='sousfamille_id' id='sousfamille_id' class='form-control  select ' onchange=' getsoussousfamille()'><option selected disabled hidden value=0> Veuillez choisir !!</option>";
            foreach($sousfamilles as $v){
                $select=$select."<option value=".$v['Sousfamille']['id'].">".$v['Sousfamille']['name']."</option>";
              }
            $select=$select.'</select>';
            
            echo $select;
            die;
            } 
            
           public function getsoussousfamille(){
              $this->layout = null;
              $this->loadModel('Soussousfamille');
              $this->loadModel('Famille');
   
            $data = $this->request->data;
            $sousfamilleid= $data['sousfamilleid'];
 
            $soussousfamilles=$this->Soussousfamille->find('all', array( 'conditions' => array('Soussousfamille.sousfamille_id'=>$sousfamilleid),'recursive'=>-1)) ;
            $select="<select name='soussousfamille_id' champ='soussousfamille_id' id='soussousfamille_id'  class='form-control  select ' onchange=''><option selected disabled hidden value=0> Veuillez choisir !!</option>";
            foreach($soussousfamilles as $v){
                $select=$select."<option value=".$v['Soussousfamille']['id'].">".$v['Soussousfamille']['name']."</option>";
              }
            $select=$select.'</select>';
            
            echo $select;
            die;
            }      
            
         public function  testlignereception(){
            $this->layout = null;
            $this->loadModel('Article');  
            $data = $this->request->data;//debug($data);
           $articleid= $data['articleid'];
           $json = null;
        $article= $this->Article->find('first',array('conditions'=>array('Article.id'=>$articleid),false));
            //debug($prixaf);die;
          $lot=$article['Article']['lot'];
          $date=$article['Article']['date'];
           echo $lot.''.$date;
          die();
     }
        public function  testligneentre(){
            $this->layout = null;
            $this->loadModel('Article');  
            $data = $this->request->data;//debug($data);
           $articleid= $data['articleid'];
           $json = null;
        $article= $this->Article->find('first',array('conditions'=>array('Article.id'=>$articleid),false));
     
          $date=$article['Article']['date'];
           echo $date;
          die();
     }
     
     
     
       public function recherchearticle() {
           
            $data = $this->request->data;
            $code= $data['val1'];
            $cond1 = 'Article.code = '."'".$code."'";
            $rechereart = $this->Article->find('count', array( 'conditions' => array( $cond1 )));
                // debug($recherecheutilisateur);die;
                 
                    echo $rechereart;
                    die;
                 // echo json_encode(array('rechclt'=>$recherecheclient));
            
            //$this->set(compact('utilisateurs','actionsrechereche','utilisateurid','date1','date2'));
                  
        }  
     
     
     
     
     
     
     
     
          }
