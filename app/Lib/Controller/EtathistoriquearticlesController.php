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
	public function index() {
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
            
            $this->loadModel('Lignefactureavoir');
            $this->loadModel('Lignereception');
            $this->loadModel('Lignecommande');
            $this->loadModel('Lignefacture');
            
            $this->loadModel('Lignetransfert');
            $this->loadModel('Lignebonreceptionstock');
            $this->loadModel('Lignebonsortiestock');
            $this->loadModel('Ligneinventaire');
            
            $this->loadModel('Client');
            $this->loadModel('Exercice');
            $this->loadModel('Article');
            $this->loadModel('Fournisseur');
            $this->loadModel('Utilisateur');
            $this->loadModel('Historiquearticle');
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
       
       
        //$this->Historiquearticle->deleteAll(array('Historiquearticle.id >'=>0),false); 
        $this->Historiquearticle->query('TRUNCATE historiquearticles;');
         if ($this->request->is('post')) { 
             
             
   
             
        //debug($this->request->data);die;
        if ($this->request->data['Recherche']['date1'] != "__/__/____"){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            $condd1 = 'Devi.date >= '."'".$date1."'";
            $condc1 = 'Commandeclient.date >= '."'".$date1."'";
            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= '."'".$date1."'";
            
            $condfa1 = 'Factureavoir.date >= '."'".$date1."'";
            $condbb1 = 'Bonreception.date >= '."'".$date1."'";
            $condcc1 = 'Commande.date >= '."'".$date1."'";
            $condff1 = 'Facture.date >= '."'".$date1."'";
            
            $condt1= 'Transfert.date >= '."'".$date1."'";
            $condbrs1 = 'Bonreceptionstock.date >= '."'".$date1."'";
            $condbss1 = 'Bonsortiestock.date >= '."'".$date1."'";
            $condi1 = 'Inventaire.date >= '."'".$date1."'";
            
            $condd4="";
            $condc4="";
            $condf4="";
            $condb4="";
            
            $condfa4="";
            $condbb4="";
            $condcc4="";
            $condff4="";
            
            $condt4="";
            $condbrs4="";
            $condbss4="";
            $condi4="";
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
            
            $condt2 = 'Transfert.date <= '."'".$date2."'";
            $condbrs2 = 'Bonreceptionstock.date <= '."'".$date2."'";
            $condbss2 = 'Bonsortiestock.date <= '."'".$date2."'";
            $condi2 = 'Inventaire.date <= '."'".$date2."'";
            
            $condd4="";
            $condc4="";
            $condf4="";
            $condb4="";
            
            $condfa4="";
            $condbb4="";
            $condcc4="";
            $condff4="";
            
            $condt4="";
            $condbrs4="";
            $condbss4="";
            $condi4="";
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
         if ($this->request->data['Recherche']['exercice_id']) {
            $exerciceid = $this->request->data['Recherche']['exercice_id'];
            
            $condd4 = 'Devi.exercice_id ='.$exercices[$exerciceid];
            $condc4 = 'Commandeclient.exercice_id ='.$exercices[$exerciceid];
            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condf4 = 'Factureclient.exercice_id ='.$exercices[$exerciceid];
            
            $condfa4 = 'Factureavoir.exercice_id ='.$exercices[$exerciceid];
            $condbb4 = 'Bonreception.exercice_id ='.$exercices[$exerciceid];
            $condcc4 = 'Commande.exercice_id ='.$exercices[$exerciceid];
            $condff4 = 'Facture.exercice_id ='.$exercices[$exerciceid];
       
            $condt4  = 'Transfert.exercice_id ='.$exercices[$exerciceid];
            $condbrs4 = 'Bonreceptionstock.exercice_id ='.$exercices[$exerciceid];
            $condbss4 = 'Bonsortiestock.exercice_id ='.$exercices[$exerciceid];
            $condi4  = 'Inventaire.exercice_id ='.$exercices[$exerciceid];
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
       
            $condt6  = 'Lignetransfert.article_id ='.$articleid;
            $condbrs6 = 'Lignebonreceptionstock.article_id ='.$articleid;
            $condbss6 = 'Lignebonsortiestock.article_id ='.$articleid;
            $condi6  = 'Ligneinventaire.article_id ='.$articleid;
        } 
        if ($this->request->data['Recherche']['fournisseur_id']) {
            $fournisseurid= $this->request->data['Recherche']['fournisseur_id'];
            $condbb5 = 'Bonreception.fournisseur_id ='.$fournisseurid;
            $condcc5 = 'Commande.fournisseur_id ='.$fournisseurid;
            $condff5 = 'Facture.fournisseur_id ='.$fournisseurid;
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
        
     
           
            
                
        
            
//            $lignedevis=$this->Lignedevi->find('all', array(
//            'conditions' => array(@$condd1,@$condd2,@$condd3,@$condd4,@$condd6),'recursive'=>0 ));
//            if ($devi==0) {
//            $lignedevis=array();
//            }
//            $tablignedevis=array(); 
//            foreach ($lignedevis as $lignedevi) {
//            $client= $this->Client->find('first',array('conditions'=>array('Client.id'=>$lignedevi['Devi']['client_id']),'recursive'=>-1));
//            //debug($client);die;
//            @$name=$client['Client']['name'];    
//            $tablignedevis['client']=@$name;
//            $tablignedevis['fournisseur']="";
//            $tablignedevis['utilisateur']="";
//            $tablignedevis['date']=$lignedevi['Devi']['date'];
//            $tablignedevis['type']="Devi";
//            $tablignedevis['indice']=1;
//            $tablignedevis['numero']=$lignedevi['Devi']['numero'];
//            $tablignedevis['article']=$lignedevi['Article']['name'];
//            $tablignedevis['qte']=$lignedevi['Lignedevi']['quantite'];
//            $tablignedevis['pu']=$lignedevi['Lignedevi']['prix'];
//            $tablignedevis['ptot']=$lignedevi['Lignedevi']['totalttc'];
//            $tablignedevis['mode']="Sortie";
//            $this->Historiquearticle->create();
//            $this->Historiquearticle->save($tablignedevis);
//            }
//******************************************************************************************************************************        
//            $lignecommandes=$this->Lignecommandeclient->find('all', array(
//            'conditions' => array(@$condc1,@$condc2,@$condc3,@$condc4,@$condc6),'recursive'=>0 ));
//            if ($commande==0) {
//            $lignecommandes=array();
//            } 
//            $tablignecommandes=array(); 
//            foreach ($lignecommandes as $lignecommandeclient) {
//            $client= $this->Client->find('first',array('conditions'=>array('Client.id'=>$lignecommandeclient['Commandeclient']['client_id']),'recursive'=>-1));
//            if(!empty($client)){
//            @$name=$client['Client']['name'];
//            }else {
//            $name="";    
//            }
//            $tablignecommandeclients['client']=@$name;
//            $tablignecommandeclients['fournisseur']="";
//            $tablignecommandeclients['utilisateur']="";
//            $tablignecommandeclients['date']=$lignecommandeclient['Commandeclient']['date'];
//            $tablignecommandeclients['type']="Commandeclient";
//            $tablignecommandeclients['indice']=1;
//            $tablignecommandeclients['numero']=$lignecommandeclient['Commandeclient']['numero'];
//            $tablignecommandeclients['article']=$lignecommandeclient['Article']['name'];
//            $tablignecommandeclients['qte']=$lignecommandeclient['Lignecommandeclient']['quantite'];
//            $tablignecommandeclients['pu']=$lignecommandeclient['Lignecommandeclient']['prix'];
//            $tablignecommandeclients['ptot']=$lignecommandeclient['Lignecommandeclient']['totalttc'];
//            $tablignecommandeclients['mode']="Sortie";
//            $this->Historiquearticle->create();
//            $this->Historiquearticle->save($tablignecommandeclients);
//            }
//******************************************************************************************************************************        
            $lignelivrisons=$this->Lignelivraison->find('all', array(
            'conditions' => array(@$condb1,@$condb2,@$condb3,@$condb4,@$condb6),'recursive'=>0 ));
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
            $tablignelivrisons['ptot']=$lignelivrison['Lignelivraison']['totalttc'];
            $tablignelivrisons['mode']="Sortie";
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignelivrisons);
            }
//******************************************************************************************************************************        
            $lignefactures=$this->Lignefactureclient->find('all', array(
            'conditions' => array(@$condf1,@$condf2,@$condf3,@$condf4,@$condf6),'recursive'=>0 ));
            if ($facture==0) {
            $lignefactures=array();
            } 
            $tablignefactures=array(); 
            foreach ($lignefactures as $lignefacture) {
            $client= $this->Client->find('first',array('conditions'=>array('Client.id'=>$lignefacture['Factureclient']['client_id']),'recursive'=>-1));
             if(!empty($client)){
            @$name=$client['Client']['name'];
            }else {
            $name="";    
            }    
            $tablignefactures['client']=$name;
            $tablignefactures['fournisseur']="";
            $tablignefactures['utilisateur']="";
            $tablignefactures['date']=$lignefacture['Factureclient']['date'];
            $tablignefactures['type']="Facture client";
            $tablignefactures['indice']=1;
            $tablignefactures['numero']=$lignefacture['Factureclient']['numero'];
            $tablignefactures['article']=$lignefacture['Article']['name'];
            $tablignefactures['qte']=$lignefacture['Lignefactureclient']['quantite'];
            $tablignefactures['pu']=$lignefacture['Lignefactureclient']['prix'];
            $tablignefactures['ptot']=$lignefacture['Lignefactureclient']['totalttc'];
            $tablignefactures['mode']="Sortie";
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignefactures);
            }

//**********************************************************************************************************        
            $lignefactureavoirs=$this->Lignefactureavoir->find('all', array(
            'conditions' => array(@$condfa1,@$condfa2,@$condfa3,@$condfa4,@$condfa6),'recursive'=>0 ));
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
            $tablignefactureavoirs['type']="Facture Avoir";
            $tablignefactureavoirs['indice']=1;
            $tablignefactureavoirs['numero']=$lignefactureavoir['Factureavoir']['numero'];
            $tablignefactureavoirs['article']=$lignefactureavoir['Article']['name'];
            $tablignefactureavoirs['qte']=$lignefactureavoir['Lignefactureavoir']['quantite'];
            $tablignefactureavoirs['pu']=$lignefactureavoir['Lignefactureavoir']['prix'];
            $tablignefactureavoirs['ptot']=$lignefactureavoir['Lignefactureavoir']['totalttc'];
            $tablignefactureavoirs['mode']="Entreé";
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignefactureavoirs);
            }
//******************************************************************************************************************************        
            $lignereceptions=$this->Lignereception->find('all', array(
            'conditions' => array(@$condbb1,@$condbb2,@$condbb4,@$condbb5,@$condbb6),'recursive'=>0 ));
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
            $tablignereceptions['client']="";
            $tablignereceptions['fournisseur']=$name;
            $tablignereceptions['utilisateur']="";
            $tablignereceptions['date']=$lignereception['Bonreception']['date'];
            $tablignereceptions['type']="Bonreception";
            $tablignereceptions['indice']=2;
            $tablignereceptions['numero']=$lignereception['Bonreception']['numero'];
            $tablignereceptions['article']=$lignereception['Article']['name'];
            $tablignereceptions['qte']=$lignereception['Lignereception']['quantite'];
            $tablignereceptions['pu']=$lignereception['Lignereception']['prix'];
            $tablignereceptions['ptot']=$lignereception['Lignereception']['totalttc'];
            $tablignereceptions['mode']="Entreé";
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignereceptions);
            }
//******************************************************************************************************************************        
//            $lignecommandefours=$this->Lignecommande->find('all', array(
//            'conditions' => array(@$condcc1,@$condcc2,@$condcc4,@$condcc5,@$condcc6),'recursive'=>0 ));
//            if ($commandefour==0) {
//            $lignecommandefours=array();
//            } 
//            $tabcommandefours=array(); 
//            foreach ($lignecommandefours as $commandefour) {
//            $fournisseur= $this->Fournisseur->find('first',array('conditions'=>array('Fournisseur.id'=>$commandefour['Commande']['fournisseur_id']),'recursive'=>-1));
//            if(!empty($fournisseur)){
//            $name=$fournisseur['Fournisseur']['name'];        
//            }else {
//            $name="";    
//            }                 
//            $tabcommandefours['client']="";
//            $tabcommandefours['fournisseur']=$name;
//            $tabcommandefours['utilisateur']="";
//            $tabcommandefours['date']=$commandefour['Commande']['date'];
//            $tabcommandefours['type']="Commande";
//            $tabcommandefours['indice']=2;
//            $tabcommandefours['numero']=$commandefour['Commande']['numero'];
//            $tabcommandefours['article']=$commandefour['Article']['name'];
//            $tabcommandefours['qte']=$commandefour['Lignecommande']['quantite'];
//            $tabcommandefours['pu']=$commandefour['Lignecommande']['prix'];
//            $tabcommandefours['ptot']=$commandefour['Lignecommande']['totalttc'];
//            $tabcommandefours['mode']="Entreé";
//            $this->Historiquearticle->create();
//            $this->Historiquearticle->save($tabcommandefours);
//            }
//******************************************************************************************************************************        
            $lignefacturefours=$this->Lignefacture->find('all', array(
            'conditions' => array(@$condff1,@$condff2,@$condff4,@$condff5,@$condff6),'recursive'=>0 ));
             if ($facturefour==0) {
            $lignefacturefours=array();
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
            $tabfacturefours['client']="";
            $tabfacturefours['fournisseur']=$name;
            $tabfacturefours['utilisateur']="";
            $tabfacturefours['date']=$facturefour['Facture']['date'];
            $tabfacturefours['type']="Facture";
            $tabfacturefours['indice']=2;
            $tabfacturefours['numero']=$facturefour['Facture']['numero'];
            $tabfacturefours['article']=$facturefour['Article']['name'];
            $tabfacturefours['qte']=$facturefour['Lignefacture']['quantite'];
            $tabfacturefours['pu']=$facturefour['Lignefacture']['prix'];
            $tabfacturefours['ptot']=$facturefour['Lignefacture']['totalttc'];
            $tabfacturefours['mode']="Entreé";
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tabfacturefours);
            }}
//******************************************************************************************************************************        
//            $lignetransferts=$this->Lignetransfert->find('all', array(
//            'conditions' => array(@$condt1,@$condt2,@$condt4,@$condt6),'recursive'=>0 ));
//            if ($transfert==0) {
//            $lignetransferts=array();
//            } 
//            $tablignetransferts=array(); 
//            foreach ($lignetransferts as $lignetransfert) {
//            $utilisateur= $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$lignetransfert['Transfert']['utilisateur_id']),'recursive'=>0));
//            if(!empty($fournisseur)){
//            $name=$utilisateur['Personnel']['name'];     
//            }else {
//            $name="";    
//            }     
//            $tablignetransferts['client']="";
//            $tablignetransferts['fournisseur']="";
//            $tablignetransferts['utilisateur']=$name;
//            $tablignetransferts['date']=$lignetransfert['Transfert']['date'];
//            $tablignetransferts['type']="Transfert";
//            $tablignetransferts['indice']=3;
//            $tablignetransferts['numero']=$lignetransfert['Transfert']['numero'];
//            $tablignetransferts['article']=$lignetransfert['Article']['name'];
//            $tablignetransferts['qte']=$lignetransfert['Lignetransfert']['quantite'];
//            $tablignetransferts['pu']="";
//            $tablignetransferts['ptot']="";
//            $tablignetransferts['mode']="Entreé";
//            $this->Historiquearticle->create();
//            $this->Historiquearticle->save($tablignetransferts);
//            }
//******************************************************************************************************************************        
//            $lignebonreceptionstocks=$this->Lignebonreceptionstock->find('all', array(
//            'conditions' => array(@$condbrs1,@$condbrs2,@$condbrs4,@$condbrs6),'recursive'=>0 ));
//            if ($bonreceptionstock==0) {
//            $lignebonreceptionstocks=array();
//            } 
//            $tablignebonreceptionstocks=array(); 
//            foreach ($lignebonreceptionstocks as $lignebonreceptionstock) {
//            $utilisateur= $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$lignebonreceptionstock['Bonreceptionstock']['utilisateur_id']),'recursive'=>0));
//            if(!empty($fournisseur)){
//            $name=$utilisateur['Personnel']['name'];     
//            }else {
//            $name="";    
//            }     
//            $tablignebonreceptionstocks['client']="";
//            $tablignebonreceptionstocks['fournisseur']="";
//            $tablignebonreceptionstocks['utilisateur']=$name;
//            $tablignebonreceptionstocks['date']=$lignebonreceptionstock['Bonreceptionstock']['date'];
//            $tablignebonreceptionstocks['type']="Bon reception stock";
//            $tablignebonreceptionstocks['indice']=3;
//            $tablignebonreceptionstocks['numero']=$lignebonreceptionstock['Bonreceptionstock']['numero'];
//            $tablignebonreceptionstocks['article']=$lignebonreceptionstock['Article']['name'];
//            $tablignebonreceptionstocks['qte']=$lignebonreceptionstock['Lignebonreceptionstock']['quantite'];
//            $tablignebonreceptionstocks['pu']="";
//            $tablignebonreceptionstocks['ptot']="";
//            $tablignebonreceptionstocks['mode']="Entreé";
//            $this->Historiquearticle->create();
//            $this->Historiquearticle->save($tablignebonreceptionstocks);
//            }
//******************************************************************************************************************************        
//            $lignebonsortiestocks=$this->Lignebonsortiestock->find('all', array(
//            'conditions' => array(@$condbss1,@$condbss2,@$condbss4,@$condbss6),'recursive'=>0 ));
//            if ($bonsortiestock==0) {
//            $lignebonsortiestocks=array();
//            } 
//            $tablignebonsortiestocks=array(); 
//            foreach ($lignebonsortiestocks as $lignebonsortiestock) {
//            $utilisateur= $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$lignebonsortiestock['Bonsortiestock']['utilisateur_id']),'recursive'=>0));
//            if(!empty($fournisseur)){
//            $name=$utilisateur['Personnel']['name'];     
//            }else {
//            $name="";    
//            }     
//            $tablignebonsortiestocks['client']="";
//            $tablignebonsortiestocks['fournisseur']="";
//            $tablignebonsortiestocks['utilisateur']=$name;
//            $tablignebonsortiestocks['date']=$lignebonsortiestock['Bonsortiestock']['date'];
//            $tablignebonsortiestocks['type']="Bon sortie stock";
//            $tablignebonsortiestocks['indice']=3;
//            $tablignebonsortiestocks['numero']=$lignebonsortiestock['Bonsortiestock']['numero'];
//            $tablignebonsortiestocks['article']=$lignebonsortiestock['Article']['name'];
//            $tablignebonsortiestocks['qte']=$lignebonsortiestock['Lignebonsortiestock']['quantite'];
//            $tablignebonsortiestocks['pu']="";
//            $tablignebonsortiestocks['ptot']="";
//            $tablignebonsortiestocks['mode']="Sortie";
//            $this->Historiquearticle->create();
//            $this->Historiquearticle->save($tablignebonsortiestocks);
//            }
//******************************************************************************************************************************        
//            $ligneinventaires=$this->Ligneinventaire->find('all', array(
//            'conditions' => array(@$condi1,@$condi2,@$condi4,@$condi6),'recursive'=>0 ));
//            if ($inventaire==0) {
//            $ligneinventaires=array();
//            } 
//            $tabligneinventaires=array(); 
//            foreach ($ligneinventaires as $ligneinventaire) {
//            $utilisateur= $this->Utilisateur->find('first',array('conditions'=>array('Utilisateur.id'=>$ligneinventaire['Inventaire']['utilisateur_id']),'recursive'=>0));
//            if(!empty($fournisseur)){
//            $name=$utilisateur['Personnel']['name'];     
//            }else {
//            $name="";    
//            }     
//            $tabligneinventaires['client']="";
//            $tabligneinventaires['fournisseur']="";
//            $tabligneinventaires['utilisateur']=$name;
//            $tabligneinventaires['date']=$ligneinventaire['Inventaire']['date'];
//            $tabligneinventaires['type']="Inventaire";
//            $tabligneinventaires['indice']=3;
//            $tabligneinventaires['numero']=$ligneinventaire['Inventaire']['numero'];
//            $tabligneinventaires['article']=$ligneinventaire['Article']['name'];
//            $tabligneinventaires['qte']=$ligneinventaire['Ligneinventaire']['quantite'];
//            $tabligneinventaires['pu']="";
//            $tabligneinventaires['ptot']="";
//            $tabligneinventaires['mode']="Entreé";
//            $this->Historiquearticle->create();
//            $this->Historiquearticle->save($tabligneinventaires);
//            }
//******************************************************************************************************************************        
             
            
        
         
        
         $historiquearticles=$this->Historiquearticle->find('all', array(
            'conditions' => array('Historiquearticle.id >' => 0),'recursive'=>0,'order'=>array('Historiquearticle.date'=>'desc') ));
         
         
    }     
         
        //debug($historiquearticles);
        $articles = $this->Article->find('list');
        $clients = $this->Client->find('list'); 
        $fournisseurs = $this->Fournisseur->find('list'); 
         
                 $this->set(compact('clientid','articleid','fournisseurid','date1','date2','historiquearticles','fournisseurs','clients','articles','exercices','lignedevis','lignecommandes','lignelivrisons','lignefactures','name','exerciceid'));
               
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
        if ($this->request->query['exerciceid']) {
            $exerciceid = $this->request->query['exerciceid'];
            
        }
        $historiquearticles=$this->Historiquearticle->find('all', array(
            'conditions' => array('Historiquearticle.id >' => 0),'recursive'=>0,'order'=>array('Historiquearticle.date'=>'desc') ));
        //debug($relefes);
        $this->set(compact('historiquearticles','clientid','date1','date2','fournisseurid','articleid','exerciceid'));
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
