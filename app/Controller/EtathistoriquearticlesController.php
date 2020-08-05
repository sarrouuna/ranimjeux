<?php
App::uses('AppController', 'Controller');
/**
 * Etathistoriquearticles Controller
 *
 * @property Etathistoriquearticle $Etathistoriquearticle
 */
class EtathistoriquearticlesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index($article_id=null,$depot_id=null) {
        $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etathistoriquearticles'){
                        $vente=1;
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }    
            $this->loadModel('Lignedevi'); 
            $this->loadModel('Lignecommandeclient');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Lignelivraison');
            $this->loadModel('Ligneproduction');
            $this->loadModel('Production');
            $this->loadModel('Lignetransfert');
            $this->loadModel('Lignefactureavoir');
            $this->loadModel('Lignefactureavoirfr');
            $this->loadModel('Lignereception');
            $this->loadModel('Lignecommande');
            $this->loadModel('Lignefacture');
            
            $this->loadModel('Lignetransfert');
            $this->loadModel('Lignebonreceptionstock');
            $this->loadModel('Lignebonsortiestock');
            $this->loadModel('Ligneinventaire');
            $this->loadModel('Inventaire');
            $this->loadModel('Depot');
            $this->loadModel('Client');
            $this->loadModel('Exercice');
            $this->loadModel('Article');
            $this->loadModel('Fournisseur');
            $this->loadModel('Utilisateur');
            $this->loadModel('Historiquearticle');
            $this->loadModel('Typelignevente');
            $this->loadModel('Bonecart'); 
            
            $historiquearticles=array();
            $devi=1;
            $commande=1;
            $livrison=1;
            $facture=1;
            $factureavoir=1;
            $reception=1;
            $commandefour=1;
            $facturefour=1;
            $transfert=1;
            $bonreceptionstock=1;
            $bonsortiestock=1;
            $inventaire=1;
            $checkbox=""; 
       
       
        //$this->Historiquearticle->deleteAll(array('Historiquearticle.id >'=>0),false); 
        $this->Historiquearticle->query('TRUNCATE historiquearticles;');
         if (($this->request->is('post'))||($article_id !="")){ 
        debug($this->request->data);  
        
        
        if($this->request->is('get')) {
        if (!empty($article_id)) {
            $articleid = $article_id;
            $this->request->data['Recherche']['date1']="01/01/2019";
            $this->request->data['Recherche']['client_id']="";
            $this->request->data['Recherche']['article_id']=$articleid;
            $this->request->data['Recherche']['depot_id']=$depot_id;
            $this->request->data['Recherche']['date2']="__/__/____";
            $this->request->data['Recherche']['fournisseur_id']="";
            $this->request->data['Recherche']['exercice_id']="";
            $this->request->data['Recherche']['typelignevente_id']="";
        }}         
            

        if($this->request->data['Recherche']['date1'] == "__/__/____"){
            $this->request->data['Recherche']['date1']='01/01/2019';    
        }
        
            
        if(!isset($this->request->data['Recherche']['tousexercices'])){
        if(($this->request->data['Recherche']['date1'] == "__/__/____")||($this->request->data['Recherche']['date1'] == "01/01/2019")){
        $this->request->data['Recherche']['date1']='01/01/'.date("Y");
        }
        }else{
        $this->request->data['Recherche']['date1']='01/01/2000';
        $checkbox="checked";
        }     
            
        if ($this->request->data['Recherche']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            
            
            if($date1 > "2019-01-01"){
            $testdate=1;
            $condb11 = 'Bonlivraison.date < '."'".$date1."'";
            $condf11 = 'Factureclient.date < '."'".$date1."'";
            
            $condfa11 = 'Factureavoir.date < '."'".$date1."'";
            $condbb11 = 'Bonreception.date < '."'".$date1."'";
            $condff11 = 'Facture.date < '."'".$date1."'";
            $condfaf11 = 'Factureavoirfr.date < '."'".$date1."'";
            
            $condt11= 'Transfert.date < '."'".$date1."'";
            $condbrs11 = 'Bonreceptionstock.date < '."'".$date1."'";
            $condbss11 = 'Bonsortiestock.date < '."'".$date1."'";
            $condi11 = 'Inventaire.date < '."'".$date1."'"; 
            $condp11 = 'Production.date < '."'".$date1."'"; 
            }
            $condd1 = 'Devi.date >= '."'".$date1."'";
            $condc1 = 'Commandeclient.date >= '."'".$date1."'";
            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= '."'".$date1."'";
            $condfa1 = 'Factureavoir.date >= '."'".$date1."'";
            $condbb1 = 'Bonreception.date >= '."'".$date1."'";
            $condcc1 = 'Commande.date >= '."'".$date1."'";
            $condff1 = 'Facture.date >= '."'".$date1."'";
            $condfaf1 = 'Factureavoirfr.date >= '."'".$date1."'";
            $condt1= 'Transfert.date >= '."'".$date1."'";
            $condbrs1 = 'Bonreceptionstock.date >= '."'".$date1."'";
            $condbss1 = 'Bonsortiestock.date >= '."'".$date1."'";
            $condi1 = 'Inventaire.date >= '."'".$date1."'";
            $condp1 = 'Production.date >= '."'".$date1."'";
        }
        
        if ($this->request->data['Recherche']['date2'] != "__/__/____"){
            $date2 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date2'])));
            $condd2 = 'Devi.date >= '."'".$date2."'";
            $condc2 = 'Commandeclient.date <= '."'".$date2."'";
            $condb2 = 'Bonlivraison.date <= '."'".$date2."'";
            $condf2 = 'Factureclient.date <= '."'".$date2."'";
            
            $condfa2 = 'Factureavoir.date <= '."'".$date2."'";
            $condbb2 = 'Bonreception.date <= '."'".$date2."'";
            $condcc2 = 'Commande.date <= '."'".$date2."'";
            $condff2 = 'Facture.date <= '."'".$date2."'";
            $condfaf2 = 'Factureavoirfr.date <= '."'".$date2."'";
            
            $condt2 = 'Transfert.date <= '."'".$date2."'";
            $condbrs2 = 'Bonreceptionstock.date <= '."'".$date2."'";
            $condbss2 = 'Bonsortiestock.date <= '."'".$date2."'";
            $condi2 = 'Inventaire.date <= '."'".$date2."'";
            $condp2 = 'Production.date <= '."'".$date2."'";
            
        }
        
       if ($this->request->data['Recherche']['client_id']) {
            $clientid= $this->request->data['Recherche']['client_id'];
            $condd3 = 'Devi.client_id ='.$clientid;
            $condc3 = 'Commandeclient.client_id ='.$clientid;
            $condb3 = 'Bonlivraison.client_id ='.$clientid;
            $condf3 = 'Factureclient.client_id ='.$clientid;
            $condfa3 = 'Factureavoir.client_id ='.$clientid;
            $condbb5 = "";
            $condcc5 = "";
            $condff5 = "";
            $reception=0;
            $commandefour=0;
            $facturefour=0;
            $transfert=0;
            $bonreceptionstock=0;
            $bonsortiestock=0;
            $inventaire=0;
            
        } 
        
         if ($this->request->data['Recherche']['article_id']) {
            $articleid = $this->request->data['Recherche']['article_id'];
            $condd6 = 'Lignedevi.article_id ='.$articleid;
            $condc6 = 'Lignecommandeclient.article_id ='.$articleid;
            $condb6 = 'Lignelivraison.article_id ='.$articleid;
            $condf6 = 'Lignefactureclient.article_id ='.$articleid;
            
            $condfa6 = 'Lignefactureavoir.article_id ='.$articleid;
            $condbb6 = 'Lignereception.article_id ='.$articleid;
            $condcc6 = 'Lignecommande.article_id ='.$articleid;
            $condff6 = 'Lignefacture.article_id ='.$articleid;
            $condfaf6 = 'Lignefactureavoirfr.article_id ='.$articleid;
       
            $condt6  = 'Lignetransfert.article_id ='.$articleid;
            $condrs6 = 'Lignebonreceptionstock.article_id ='.$articleid;
            $condss6 = 'Lignebonsortiestock.article_id ='.$articleid;
            $condi6  = 'Ligneinventaire.article_id ='.$articleid;
            $condlp6  = 'Ligneproduction.article_id ='.$articleid; 
            $condp6  = 'Production.nvarticle ='.$articleid;
            $condBecr6  = 'Bonecart.article_id ='.$articleid;
        } 
        if ($this->request->data['Recherche']['fournisseur_id']) {
            $fournisseurid= $this->request->data['Recherche']['fournisseur_id'];
            $condbb5 = 'Bonreception.fournisseur_id ='.$fournisseurid;
            $condcc5 = 'Commande.fournisseur_id ='.$fournisseurid;
            $condff5 = 'Facture.fournisseur_id ='.$fournisseurid;
            $condfaf5 = 'Factureavoirfr.fournisseur_id ='.$fournisseurid;
            $condd3 = "";
            $condc3 = "";
            $condb3 = "";
            $condf3 = "";
            $condfa3 = "";
            $devi=0;
            $commande=0;
            $livrison=0;
            $facture=0;
            $factureavoir=0;
            $transfert=0;
            $bonreceptionstock=0;
            $bonsortiestock=0;
            $inventaire=0;
        } 
        $condi7="";
        if ($this->request->data['Recherche']['depot_id']) {
            $depotidd = $this->request->data['Recherche']['depot_id'];
            $conddepot = 'Depot.id ='.$depotidd;
        } 
        $solde=0;
//******************************************************************************************************************************        
$depots=$this->Depot->find('all', array(
'conditions' => array(@$conddepot),'recursive'=>0 ));
//debug($depots);die;
foreach ($depots as $dep) {
    
            $depotid = $dep['Depot']['id'];
            $condb7 = 'Lignelivraison.depot_id ='.$depotid;
            $condf7 = 'Lignefactureclient.depot_id ='.$depotid;
            $condfa7= 'Lignefactureavoir.depot_id ='.$depotid;
            
            $condbb7 = 'Lignereception.depot_id ='.$depotid;
            $condff7 = 'Lignefacture.depot_id ='.$depotid;
            $condfaf7 = 'Lignefactureavoirfr.depot_id ='.$depotid;
            
            $condfaf7 ='Lignefactureavoirfr.depot_id ='.$depotid;
            $condtt7  = 'Transfert.depotarrive ='.$depotid;
            $condt7  = 'Lignetransfert.depot_id ='.$depotid;
            $condbrs7 ='Lignebonreceptionstock.depot_id ='.$depotid;
            $condbss7 ='Lignebonsortiestock.depot_id ='.$depotid;
            $condi7  = 'Inventaire.depot_id ='.$depotid;
            $condlp7  = 'Ligneproduction.depot_id ='.$depotid; 
            $condp7  = 'Production.depotarrive ='.$depotid; 
            $condBecr7  = 'Bonecart.depot_id ='.$depotid; 
    
    
    
    
        $ligneinventaires=$this->Ligneinventaire->find('first', array('fields'=>array('sum((Ligneinventaire.quantite)) as quantite'),  
        'conditions' => array(@$condi6,@$condi7),'recursive'=>0,'order'=>array('Inventaire.id'=>'desc') ));
        if(!empty($ligneinventaires)){
        $qte=$ligneinventaires[0]['quantite']  ; 
        $tabligneinventaires['client']="";
        $tabligneinventaires['fournisseur']="";
        $tabligneinventaires['utilisateur']="Stock Initial (inventaire)";
        $tabligneinventaires['date']="";
        $tabligneinventaires['type']="";
        $tabligneinventaires['indice']=10;
        $tabligneinventaires['numero']="";
        $tabligneinventaires['article']="";
        $tabligneinventaires['qte']=sprintf("%.3f",$solde);
        $tabligneinventaires['pu']="";
        $tabligneinventaires['ptot']="";
        $tabligneinventaires['mode']="";
        $historiquearticles=$this->Historiquearticle->find('first', array(
        'conditions' => array('Historiquearticle.indice'=>10),'recursive'=>-1 )); 
        if(!empty($historiquearticles)){
        $tabligneinventaires['id']=$historiquearticles['Historiquearticle']['id'];
        $tabligneinventaires['qte']=sprintf("%.3f",$historiquearticles['Historiquearticle']['qte'])+sprintf("%.3f",$solde);
        }
        $this->Historiquearticle->create();
        $this->Historiquearticle->save($tabligneinventaires);
        }else{
        $qte=0;
        }
            
            $solde=sprintf("%.3f",$qte);
             if($testdate==1){
            $soldebl=$this->Lignelivraison->find('first', array( 
            'fields'=>array('sum((Lignelivraison.quantite)) as quantite'),    
            'conditions' => array(@$condb12,@$condb11,@$condb6,@$condb7),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde-sprintf("%.3f",$soldebl[0]['quantite']);
            }
            $soldefac=$this->Lignefactureclient->find('first', array(
            'fields'=>array('sum((Lignefactureclient.quantite)) as quantite'),    
            'conditions' => array('Factureclient.source'=>"fac",@$condf12,@$condf11,@$condf6,@$condf7),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde-sprintf("%.3f",$soldefac[0]['quantite']);
            }
            $soldeavoir=$this->Lignefactureavoir->find('first', array(
            'fields'=>array('sum(Lignefactureavoir.quantite) as quantite'),    
            'conditions' => array(@$condfa12,@$condfa11,@$condfa6,@$condfa7),'recursive'=>0 ));
            if(!empty($soldeavoir)){
                $solde=$solde+sprintf("%.3f",$soldeavoir[0]['quantite']);
            }
            $solderec=$this->Lignereception->find('first', array(
            'fields'=>array('sum(Lignereception.quantite) as quantite'),    
            'conditions' => array('Bonreception.facture_id'=>0,@$condbb12,@$condbb11,@$condbb6,@$condbb7),'recursive'=>0 ));
            if(!empty($solderec)){
                $solde=$solde+sprintf("%.3f",$solderec[0]['quantite']);
            }
            $soldefacf=$this->Lignefacture->find('first', array(
            'fields'=>array('sum(Lignefacture.quantite) as quantite'),    
            'conditions' => array(@$condff12,@$condff11,@$condff6,@$condff7),'recursive'=>0 ));
            if(!empty($soldefacf)){
                $solde=$solde+sprintf("%.3f",$soldefacf[0]['quantite']);
            }
            $soldefacfav=$this->Lignefactureavoirfr->find('first', array(
            'fields'=>array('sum(Lignefactureavoirfr.quantite) as quantite'),    
            'conditions' => array(@$condfaf12,@$condfaf11,@$condfaf6,@$condfaf7),'recursive'=>0 ));
            if(!empty($soldefacfav)){
                $solde=$solde-sprintf("%.3f",$soldefacfav[0]['quantite']);
            }
            $solderepst=$this->Lignebonreceptionstock->find('first', array(
            'fields'=>array('sum(Lignebonreceptionstock.quantite) as quantite'),    
            'conditions' => array(@$condbrs12,@$condbrs11,@$condrs6,@$condbrs7),'recursive'=>2 ));
            if(!empty($solderepst)){
                $solde=$solde+sprintf("%.3f",$solderepst[0]['quantite']);
            }
            $soldesst=$this->Lignebonsortiestock->find('first', array(
            'fields'=>array('sum(Lignebonsortiestock.quantite) as quantite'),    
            'conditions' => array(@$condbss12,@$condbss11,@$condss6,@$condbss7),'recursive'=>2 ));
            if(!empty($soldesst)){
                $solde=$solde-sprintf("%.3f",$soldesst[0]['quantite']);
            }
            $lignetransfert=$this->Lignetransfert->find('first', array(
            'fields'=>array('sum(Lignetransfert.quantite) as quantite'),    
            'conditions' => array(@$condt12,@$condt11,@$condt6,@$condt7),'recursive'=>2 ));
            if(!empty($lignetransfert)){
                $solde=$solde-sprintf("%.3f",$lignetransfert[0]['quantite']);
            }
            $transfert=$this->Lignetransfert->find('first', array(
            'fields'=>array('sum(Lignetransfert.quantite) as quantite'),    
            'conditions' => array(@$condt12,@$condt11,@$condt6,@$condtt7),'recursive'=>2 ));
            if(!empty($transfert)){
                $solde=$solde+sprintf("%.3f",$transfert[0]['quantite']);
            }}
      
           //debug($solde);

            
            
      
//******************************************************************************************************************************        
            $lignelivrisons=$this->Lignelivraison->find('all', array(
            'conditions' => array('Lignelivraison.id > 0',@$condb1,@$condb2,@$condb3,@$condb4,@$condb6,@$condb7),'recursive'=>0 ));
            if ($livrison==0) {
            $lignelivrisons=array();
            } 
            $tablignelivrisons=array(); 
            foreach ($lignelivrisons as $lignelivrison) {
            $client= $this->Client->find('first',array('conditions'=>array('Client.id'=>$lignelivrison['Bonlivraison']['client_id']),'recursive'=>-1));
             if(!empty($client)){
            @$name=$client['Client']['name'];
            }else {
            $name="";    
            }    
            $tablignelivrisons['client']=$name;
            $tablignelivrisons['fournisseur']="";
            $tablignelivrisons['utilisateur']="";
            $tablignelivrisons['date']=$lignelivrison['Bonlivraison']['date'];
            $tablignelivrisons['type']="Bon livraison";
            $tablignelivrisons['indice']=1;
            $tablignelivrisons['numero']=$lignelivrison['Bonlivraison']['numero'];
            $tablignelivrisons['article']=$lignelivrison['Article']['name'];
            $tablignelivrisons['qte']=$lignelivrison['Lignelivraison']['quantite'];
            $tablignelivrisons['pu']=$lignelivrison['Lignelivraison']['prix'];
            $tablignelivrisons['remise']=$lignelivrison['Lignelivraison']['remise'];
            $tablignelivrisons['tva']=$lignelivrison['Lignelivraison']['tva'];
            $tablignelivrisons['ptot']=$lignelivrison['Lignelivraison']['totalht'];
            $tablignelivrisons['mode']="Sortie";
            $tablignelivrisons['depot']=$lignelivrison['Depot']['code'];
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignelivrisons);
            }
//******************************************************************************************************************************        
            $lignefactures=$this->Lignefactureclient->find('all', array(
            'conditions' => array('Factureclient.source'=>"fac",@$condf1,@$condf2,@$condf3,@$condf4,@$condf6,@$condf7),'recursive'=>0 ));
            if ($facture==0) {
            $lignefactures=array();
            } 
            $tablignefactures=array();
            //debug($lignefactures);
            foreach ($lignefactures as $lignefacture) {
            $client= $this->Client->find('first',array('conditions'=>array('Client.id'=>$lignefacture['Factureclient']['client_id']),'recursive'=>-1));
            if(!empty($client)){
            $name=$client['Client']['name'];
            }else {
            $name="";    
            }    
            $tablignefactures['client']=$name;
            $tablignefactures['fournisseur']="";
            $tablignefactures['utilisateur']="";
            $tablignefactures['date']=$lignefacture['Factureclient']['date'];
            $tablignefactures['type']="BLFacture";
            $tablignefactures['indice']=2;
            $tablignefactures['numero']=$lignefacture['Factureclient']['numero'];
            $tablignefactures['article']=$lignefacture['Article']['name'];
            $tablignefactures['qte']=$lignefacture['Lignefactureclient']['quantite'];
            $tablignefactures['pu']=$lignefacture['Lignefactureclient']['prix'];
            $tablignefactures['remise']=$lignefacture['Lignefactureclient']['remise'];
            $tablignefactures['tva']=$lignefacture['Lignefactureclient']['tva'];
            $tablignefactures['ptot']=$lignefacture['Lignefactureclient']['totalht'];
            $tablignefactures['mode']="Sortie";
            $tablignefactures['depot']=$lignefacture['Depot']['code'];
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignefactures);
            }

//**********************************************************************************************************        
            $lignefactureavoirs=$this->Lignefactureavoir->find('all', array(
            'conditions' => array(@$condfa1,@$condfa2,@$condfa3,@$condfa4,@$condfa6,@$condfa7),'recursive'=>0 ));
            if ($factureavoir==0) {
            $lignefactureavoirs=array();
            } 
            $tablignefactureavoirs=array(); 
            foreach ($lignefactureavoirs as $lignefactureavoir) {
            $client= $this->Client->find('first',array('conditions'=>array('Client.id'=>$lignefactureavoir['Factureavoir']['client_id']),'recursive'=>-1));
            if(!empty($client)){
            @$name=$client['Client']['name'];
            }else {
            $name="";    
            }     
            $tablignefactureavoirs['client']=$name;
            $tablignefactureavoirs['fournisseur']="";
            $tablignefactureavoirs['utilisateur']="";
            $tablignefactureavoirs['date']=$lignefactureavoir['Factureavoir']['date'];
            $tablignefactureavoirs['type']="Avr.BLFacture";
            $tablignefactureavoirs['indice']=3;
            $tablignefactureavoirs['numero']=$lignefactureavoir['Factureavoir']['numero'];
            $tablignefactureavoirs['article']=$lignefactureavoir['Article']['name'];
            $tablignefactureavoirs['qte']=$lignefactureavoir['Lignefactureavoir']['quantite'];
            $tablignefactureavoirs['pu']=$lignefactureavoir['Lignefactureavoir']['prix'];
            $tablignefactureavoirs['remise']=$lignefactureavoir['Lignefactureavoir']['remise'];
            $tablignefactureavoirs['tva']=$lignefactureavoir['Lignefactureavoir']['tva'];
            $tablignefactureavoirs['ptot']=$lignefactureavoir['Lignefactureavoir']['totalht'];
            $tablignefactureavoirs['mode']="Entreé";
            $tablignefactureavoirs['depot']=$lignefactureavoir['Depot']['code'];
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignefactureavoirs);
            }
//******************************************************************************************************************************        
            $lignereceptions=$this->Lignereception->find('all', array(
            'conditions' => array('Bonreception.facture_id'=>0,@$condbb1,@$condbb2,@$condbb4,@$condbb5,@$condbb6,@$condbb7),'recursive'=>0 ));
            if ($reception==0) {
            $lignereceptions=array();
            } 
            $tablignereceptions=array(); 
            foreach ($lignereceptions as $lignereception) {
            $fournisseur= $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$lignereception['Bonreception']['fournisseur_id']),'recursive'=>-1));
            if(!empty($fournisseur)){
            $name=$fournisseur['Fournisseur']['name'];        
            }else {
            $name="";    
            } 
            $depot= $this->Depot->find('first',array('conditions'=>array('Depot.id'=>$lignereception['Lignereception']['depot_id']),'recursive'=>-1));
            if(!empty($depot)){
            $codedepot=$depot['Depot']['code'];        
            }else {
            $codedepot="";    
            }    
            $tablignereceptions['client']="";
            $tablignereceptions['fournisseur']=$name;
            $tablignereceptions['utilisateur']="";
            $tablignereceptions['date']=$lignereception['Bonreception']['date'];
            $tablignereceptions['type']="Bonreception";
            $tablignereceptions['indice']=4;
            $tablignereceptions['numero']=$lignereception['Bonreception']['numero'];
            $tablignereceptions['article']=$lignereception['Article']['name'];
            $tablignereceptions['qte']=$lignereception['Lignereception']['quantite'];
            if(empty($lignereception['Lignereception']['prix'])){
            $prix_avant_remise=$lignereception['Lignereception']['prixhtva'];    
            }else{
            $prix_avant_remise=$lignereception['Lignereception']['prixhtva']/(1+($lignereception['Lignereception']['tva']/100));    
            }
            $tablignereceptions['pu']=$prix_avant_remise;
            $tablignereceptions['remise']=$lignereception['Lignereception']['remise'];
            $tablignereceptions['tva']=$lignereception['Lignereception']['tva'];
            $tablignereceptions['ptot']=$lignereception['Lignereception']['totalht'];
            $tablignereceptions['mode']="Entreé";
            $tablignereceptions['depot']=$codedepot;
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignereceptions);
            }

//******************************************************************************************************************************        
            $lignefacturefours=$this->Lignefacture->find('all', array(
            'conditions' => array(@$condff1,@$condff2,@$condff4,@$condff5,@$condff6,@$condff7),'recursive'=>0 ));
            //debug($lignefacturefours);
            if ($facturefour==0) {
            //$lignefacturefours=array();
            } 
            $tabfacturefours=array();
            if(!empty($lignefacturefours)){
            foreach ($lignefacturefours as $facturefour) {
            $fournisseur= $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$facturefour['Facture']['fournisseur_id']),'recursive'=>-1));
            if(!empty($fournisseur)){
            $name=$fournisseur['Fournisseur']['name'];        
            }else {
            $name="";    
            }
            $depot= $this->Depot->find('first',array('conditions'=>array('Depot.id'=>$facturefour['Lignefacture']['depot_id']),'recursive'=>-1));
            if(!empty($depot)){
            $codedepot=$depot['Depot']['code'];        
            }else {
            $codedepot="";    
            }
            if(empty($facturefour['Lignefacture']['remise'])){
            $facturefour['Lignefacture']['remise']=0;    
            }
            $tabfacturefours['client']="";
            $tabfacturefours['fournisseur']=$name;
            $tabfacturefours['utilisateur']="";
            $tabfacturefours['date']=$facturefour['Facture']['date'];
            $tabfacturefours['type']="Facture";
            $tabfacturefours['indice']=5;
            $tabfacturefours['numero']=$facturefour['Facture']['numero'];
            $tabfacturefours['article']=$facturefour['Article']['name'];
            $tabfacturefours['qte']=$facturefour['Lignefacture']['quantite'];
            if(empty($facturefour['Lignefacture']['prix'])){
            $prix_avant_remise=$facturefour['Lignefacture']['prixhtva'];    
            }else{
            $prix_avant_remise=$facturefour['Lignefacture']['prixhtva']/(1+($facturefour['Lignefacture']['tva']/100));    
            }
            $tabfacturefours['pu']=$prix_avant_remise;
            $tabfacturefours['remise']=$facturefour['Lignefacture']['remise'];
            $tabfacturefours['tva']=$facturefour['Lignefacture']['tva'];
            $tabfacturefours['ptot']=$facturefour['Lignefacture']['totalht'];
            $tabfacturefours['mode']="Entreé";
            $tabfacturefours['depot']=$codedepot;
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tabfacturefours);
            }}
            
//******************************************************************************************************************************            
            $lignefactureavfours=$this->Lignefactureavoirfr->find('all', array(
            'conditions' => array(@$condfaf1,@$condfaf2,@$condfaf4,@$condfaf5,@$condfaf6,@$condfaf7),'recursive'=>0 ));
            //debug($lignefacturefours);
            if ($facturefour==0) {
            //$lignefacturefours=array();
            } 
            $tabfactureavfours=array();
            if(!empty($lignefactureavfours)){
            foreach ($lignefactureavfours as $facturefour) {
            $fournisseur= $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$facturefour['Factureavoirfr']['fournisseur_id']),'recursive'=>-1));
            if(!empty($fournisseur)){
            $name=$fournisseur['Fournisseur']['name'];        
            }else {
            $name="";    
            }
            $depot= $this->Depot->find('first',array('conditions'=>array('Depot.id'=>$facturefour['Lignefactureavoirfr']['depot_id']),'recursive'=>-1));
            if(!empty($depot)){
            $codedepot=$depot['Depot']['code'];        
            }else {
            $codedepot="";    
            }
            if(empty($facturefour['Lignefactureavoirfr']['remise'])){
            $facturefour['Lignefactureavoirfr']['remise']=0;    
            }
            $tabfactureavfours['client']="";
            $tabfactureavfours['fournisseur']=$name;
            $tabfactureavfours['utilisateur']="";
            $tabfactureavfours['date']=$facturefour['Factureavoirfr']['date'];
            $tabfactureavfours['type']="Facture Avoir FR";
            $tabfactureavfours['indice']=15;
            $tabfactureavfours['numero']=$facturefour['Factureavoirfr']['numero'];
            $tabfactureavfours['article']=$facturefour['Article']['name'];
            $tabfactureavfours['qte']=$facturefour['Lignefactureavoirfr']['quantite'];
            $tabfactureavfours['pu']=($facturefour['Lignefactureavoirfr']['totalht']/$facturefour['Lignefactureavoirfr']['quantite'])*(1+($facturefour['Lignefactureavoirfr']['remise']/100));
            $tabfactureavfours['remise']=$facturefour['Lignefactureavoirfr']['remise'];
            $tabfactureavfours['tva']=$facturefour['Lignefactureavoirfr']['tva'];
            $tabfactureavfours['ptot']=$facturefour['Lignefactureavoirfr']['totalht'];
            $tabfactureavfours['mode']="Sortie";
            $tabfactureavfours['depot']=$codedepot;
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tabfactureavfours);
            }}
            
//******************************************************************************************************************************        
            $lignetransferts=$this->Lignetransfert->find('all', array(
            'conditions' => array(@$condt1,@$condt2,@$condt4,@$condt6,@$condtt7),'recursive'=>0 ));
            if ($transfert==0) {
            $lignetransferts=array();
            } 
            $tablignetransferts=array(); 
            foreach ($lignetransferts as $lignetransfert) {
            $utilisateur= $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$lignetransfert['Transfert']['utilisateur_id']),'recursive'=>0));
            if(!empty($fournisseur)){
            $name=$utilisateur['Personnel']['name'];     
            }else {
            $name="";    
            } 
            $depot= $this->Depot->find('first',array('conditions'=>array('Depot.id'=>$lignetransfert['Transfert']['depotarrive']),'recursive'=>-1));
            if(!empty($depot)){
            $codedepot=$depot['Depot']['code'];        
            }else {
            $codedepot="";    
            }
            $tablignetransferts['client']="";
            $tablignetransferts['fournisseur']="";
            $tablignetransferts['utilisateur']=$name;
            $tablignetransferts['date']=$lignetransfert['Transfert']['date'];
            $tablignetransferts['type']="Transfert";
            $tablignetransferts['indice']=6;
            $tablignetransferts['numero']=$lignetransfert['Transfert']['numero'];
            $tablignetransferts['article']=$lignetransfert['Article']['name'];
            $tablignetransferts['qte']=$lignetransfert['Lignetransfert']['quantite'];
            $tablignetransferts['pu']="";
            $tablignetransferts['ptot']="";
            $tablignetransferts['mode']="Entreé";
            $tablignetransferts['depot']=$codedepot;
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignetransferts);
            }
            $lignetransferts=$this->Lignetransfert->find('all', array(
            'conditions' => array(@$condt1,@$condt2,@$condt4,@$condt6,@$condt7),'recursive'=>0 ));
            if ($transfert==0) {
            $lignetransferts=array();
            } 
            $tablignetransferts=array(); 
            foreach ($lignetransferts as $lignetransfert) {
            $utilisateur= $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$lignetransfert['Transfert']['utilisateur_id']),'recursive'=>0));
            if(!empty($fournisseur)){
            $name=$utilisateur['Personnel']['name'];     
            }else {
            $name="";    
            } 
            $tablignetransferts['client']="";
            $tablignetransferts['fournisseur']="";
            $tablignetransferts['utilisateur']=$name;
            $tablignetransferts['date']=$lignetransfert['Transfert']['date'];
            $tablignetransferts['type']="Transfert";
            $tablignetransferts['indice']=6;
            $tablignetransferts['numero']=$lignetransfert['Transfert']['numero'];
            $tablignetransferts['article']=$lignetransfert['Article']['name'];
            $tablignetransferts['qte']=$lignetransfert['Lignetransfert']['quantite'];
            $tablignetransferts['pu']="";
            $tablignetransferts['ptot']="";
            $tablignetransferts['mode']="Sortie";
            $tablignetransferts['depot']=$lignetransfert['Depot']['code'];
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignetransferts);
            
            
            }
//******************************************************************************************************************************        
            $lignebonreceptionstocks=$this->Lignebonreceptionstock->find('all', array(
            'conditions' => array(@$condbrs1,@$condbrs2,@$condbrs4,@$condrs6,@$condbrs7),'recursive'=>0 ));
            if ($bonreceptionstock==0) {
            $lignebonreceptionstocks=array();
            } 
            $tablignebonreceptionstocks=array(); 
            foreach ($lignebonreceptionstocks as $lignebonreceptionstock) {
            $utilisateur= $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$lignebonreceptionstock['Bonreceptionstock']['utilisateur_id']),'recursive'=>0));
            if(!empty($fournisseur)){
            $name=$utilisateur['Personnel']['name'];     
            }else {
            $name="";    
            }     
            $tablignebonreceptionstocks['client']="";
            $tablignebonreceptionstocks['fournisseur']="";
            $tablignebonreceptionstocks['utilisateur']=$name;
            $tablignebonreceptionstocks['date']=$lignebonreceptionstock['Bonreceptionstock']['date'];
            $tablignebonreceptionstocks['type']="Bon reception stock";
            $tablignebonreceptionstocks['indice']=7;
            $tablignebonreceptionstocks['numero']=$lignebonreceptionstock['Bonreceptionstock']['numero'];
            $tablignebonreceptionstocks['article']=$lignebonreceptionstock['Article']['name'];
            $tablignebonreceptionstocks['qte']=$lignebonreceptionstock['Lignebonreceptionstock']['quantite'];
            $tablignebonreceptionstocks['pu']="";
            $tablignebonreceptionstocks['ptot']="";
            $tablignebonreceptionstocks['mode']="Entreé";
            $tablignebonreceptionstocks['depot']=$lignebonreceptionstock['Depot']['code'];
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignebonreceptionstocks);
            }
//******************************************************************************************************************************        
            $lignebonsortiestocks=$this->Lignebonsortiestock->find('all', array(
            'conditions' => array(@$condbss1,@$condbss2,@$condbss4,@$condss6,@$condbss7),'recursive'=>0 ));
            if ($bonsortiestock==0) {
            $lignebonsortiestocks=array();
            } 
            $tablignebonsortiestocks=array(); 
            foreach ($lignebonsortiestocks as $lignebonsortiestock) {
            $utilisateur= $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$lignebonsortiestock['Bonsortiestock']['utilisateur_id']),'recursive'=>0));
            if(!empty($fournisseur)){
            $name=$utilisateur['Personnel']['name'];     
            }else {
            $name="";    
            }
            if($lignebonsortiestock['Bonsortiestock']['valide']==0){
            $statu="<font size='3' color='red'>En Attente</font>";
            }else{
            if($lignebonsortiestock['Bonsortiestock']['valide']==1){
            $statu="<font size='3' color='red'>Valid&eacute;</font>";    
            }else{
            $statu="<font size='3' color='red'>Refus&eacute;</font>";     
            }    
            }
            $tablignebonsortiestocks['client']="";
            $tablignebonsortiestocks['fournisseur']="";
            $tablignebonsortiestocks['utilisateur']=$name;
            $tablignebonsortiestocks['date']=$lignebonsortiestock['Bonsortiestock']['date'];
            $tablignebonsortiestocks['type']="Bon sortie stock ".$statu;
            $tablignebonsortiestocks['indice']=8;
            $tablignebonsortiestocks['numero']=$lignebonsortiestock['Bonsortiestock']['numero'];
            $tablignebonsortiestocks['article']=$lignebonsortiestock['Article']['name'];
            $tablignebonsortiestocks['qte']=$lignebonsortiestock['Lignebonsortiestock']['quantite'];
            $tablignebonsortiestocks['pu']="";
            $tablignebonsortiestocks['ptot']="";
            $tablignebonsortiestocks['mode']="Sortie";
            $tablignebonsortiestocks['depot']=$lignebonsortiestock['Depot']['code'];
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignebonsortiestocks);
            }
            


    //**********************************************************************************************************    
//             $lignebonecarts=$this->Bonecart->find('all', array(
//            'conditions' => array('Inventaire.valide'=>1,@$condi1,@$condi2,@$condi4,@$condBecr6,@$condBecr7),'recursive'=>0 ));
//            //debug($lignebonecarts);die;
//            
//            $tablignebonecarts=array(); 
//            foreach ($lignebonecarts as $lignebonecart) {
//            if($lignebonecart['Bonecart']['quantite']<0){
//            $typeqte="Sortie";    
//            }else{
//            $typeqte="Entreé";     
//            }
//            $statu="";
//            if($lignebonecart['Inventaire']['valide']==0){
//            $statu="<font size='3' color='red'>En Attente</font>";
//            }else{
//            $statu="<font size='3' color='red'>Valid&eacute;</font>";    
//            }
//            $tablignebonecarts['client']="";
//            $tablignebonecarts['fournisseur']="";
//            $tablignebonecarts['utilisateur']="";
//            $tablignebonecarts['date']=$lignebonecart['Inventaire']['date'];
//            $tablignebonecarts['type']="Bon ecart ".$statu;
//            $tablignebonecarts['indice']=11;
//            $tablignebonecarts['numero']=$lignebonecart['Inventaire']['numero'];
//            $tablignebonecarts['article']=$lignebonecart['Article']['name'];
//            $tablignebonecarts['qte']=abs($lignebonecart['Bonecart']['quantite']);
//            $tablignebonecarts['pu']="";
//            $tablignebonecarts['ptot']="";
//            $tablignebonecarts['mode']=$typeqte;
//            $tablignebonecarts['depot']=$lignebonecart['Depot']['code'];
//            $this->Historiquearticle->create();
//            $this->Historiquearticle->save($tablignebonecarts);
//            }
            

//**************************************************************************************************************************       

}          
            
            
        if ($this->request->data['Recherche']['typelignevente_id']) {
            $typeligneventeid= $this->request->data['Recherche']['typelignevente_id'];
            //debug($moiid);die;
            $t='0';
            foreach ($typeligneventeid as $ad){
                $t=$t.','.$ad;
            }
            $condhistorique1 = 'Historiquearticle.indice in ('.$t.')';
           
            }    
        
         
        
         $historiquearticles=$this->Historiquearticle->find('all', array(
            'conditions' => array('Historiquearticle.id >' => 0,@$condhistorique1),'recursive'=>0,'order'=>array('Historiquearticle.date'=>'asc') ));
         
         
    }     
         
        //debug($historiquearticles);
        $clients = $this->Client->find('list'); 
        $fournisseurs = $this->Fournisseur->find('list'); 
        $typeligneventes = $this->Typelignevente->find('list'); 
        $depots = $this->Depot->find('list', array('conditions'=>array('Depot.typeetatarticle_id'=>1)));
        $this->set(compact('checkbox','depotidd','depots','typeligneventes','clientid','articleid','fournisseurid','date1','date2','historiquearticles','fournisseurs','clients','articles','exercices','lignedevis','lignecommandes','lignelivrisons','lignefactures','name','exerciceid'));
               
	}
        
         public function imprimerrecherche() {
        $lien=  CakeSession::read('lien_vente');
               $vente="";
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='etathistoriquearticles'){
                        $vente=$liens['imprimer'];
                }}}
              if (( $vente <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }       
             $this->loadModel('Historiquearticle');
             $this->loadModel('Depot');
            $this->loadModel('Article');
       
       if (!empty($this->request->query['date1'])){
            $date1 = $this->request->query['date1'];
           
        }
        
        if (!empty($this->request->query['date2'])){
            $date2 = $this->request->query['date2'];
           
        }
        
        if ($this->request->query['clientid']) {
            $clientid = $this->request->query['clientid'];
            
        }
        if ($this->request->query['fournisseurid']) {
            $fournisseurid = $this->request->query['fournisseurid'];
            
        } 
        if ($this->request->query['articleid']) {
            $articleid = $this->request->query['articleid'];
            
        }
        if ($this->request->query['depotidd']) {
            $depotid = $this->request->query['depotidd'];
            
        }
        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            
        }
        $historiquearticles=$this->Historiquearticle->find('all', array(
            'conditions' => array('Historiquearticle.id >' => 0),'recursive'=>0,'order'=>array('Historiquearticle.date'=>'asc') ));
        //debug($relefes);
        //$articles = $this->Article->find('list');
        $depots = $this->Depot->find('list', array('conditions'=>array('Depot.typeetatarticle_id'=>1)));
        $this->set(compact('depots','articles','depotid','historiquearticles','clientid','date1','date2','fournisseurid','articleid','exerciceid'));
    }
        
        

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Etathistoriquearticle->exists($id)) {
			throw new NotFoundException(__('Invalid etathistoriquearticle'));
		}
		$options = array('conditions' => array('Etathistoriquearticle.' . $this->Etathistoriquearticle->primaryKey => $id));
		$this->set('etathistoriquearticle', $this->Etathistoriquearticle->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Etathistoriquearticle->create();
			if ($this->Etathistoriquearticle->save($this->request->data)) {
				$this->Session->setFlash(__('The etathistoriquearticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etathistoriquearticle could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Etathistoriquearticle->exists($id)) {
			throw new NotFoundException(__('Invalid etathistoriquearticle'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Etathistoriquearticle->save($this->request->data)) {
				$this->Session->setFlash(__('The etathistoriquearticle has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The etathistoriquearticle could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Etathistoriquearticle.' . $this->Etathistoriquearticle->primaryKey => $id));
			$this->request->data = $this->Etathistoriquearticle->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Etathistoriquearticle->id = $id;
		if (!$this->Etathistoriquearticle->exists()) {
			throw new NotFoundException(__('Invalid etathistoriquearticle'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Etathistoriquearticle->delete()) {
			$this->Session->setFlash(__('Etathistoriquearticle deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Etathistoriquearticle was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
