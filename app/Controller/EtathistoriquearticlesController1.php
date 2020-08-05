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
            $this->loadModel('Ligneproduction');
            $this->loadModel('Production');
            $this->loadModel('Lignetransfert');
            $this->loadModel('Lignefactureavoir');
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
            $condp4  = 'Production.exercice_id ='.$exercices[$exerciceid];
        }
         $testdate=0;     
        //debug($this->request->data);die;
         if($this->request->data['Recherche']['date1'] == "__/__/____" ){
               $this->request->data['Recherche']['date1']='01/01/2017'; 
               //debug($this->request->data['Recherche']['date1']);die;
            }
        if ($this->request->data['Recherche']['date1'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date1']))){
            $date1 = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['date1'])));
            
            if($date1 < "2017-01-01"){
            $date1='2017-01-01';    
            }
            if($date1 > "2017-01-01"){
            //debug($this->request->data['Recherche']['date1']);
            $testdate=1;
            $condb11 = 'Bonlivraison.date < '."'".$date1."'";
            $condf11 = 'Factureclient.date < '."'".$date1."'";
            
            $condfa11 = 'Factureavoir.date < '."'".$date1."'";
            $condbb11 = 'Bonreception.date < '."'".$date1."'";
            $condff11 = 'Facture.date < '."'".$date1."'";
            
            $condt11= 'Transfert.date < '."'".$date1."'";
            $condbrs11 = 'Bonreceptionstock.date < '."'".$date1."'";
            $condbss11 = 'Bonsortiestock.date < '."'".$date1."'";
            $condi11 = 'Inventaire.date < '."'".$date1."'"; 
            $condp11 = 'Production.date < '."'".$date1."'"; 
            }
            //$date1 = '2017-01-01';
            $condd1 = 'Devi.date >= '."'".$date1."'";
            $condc1 = 'Commandeclient.date >= '."'".$date1."'";
            $condb1 = 'Bonlivraison.date >= '."'".$date1."'";
            $condf1 = 'Factureclient.date >= '."'".$date1."'";
            //debug($condb1);
            $condfa1 = 'Factureavoir.date >= '."'".$date1."'";
            $condbb1 = 'Bonreception.date >= '."'".$date1."'";
            $condcc1 = 'Commande.date >= '."'".$date1."'";
            $condff1 = 'Facture.date >= '."'".$date1."'";
            
            $condt1= 'Transfert.date >= '."'".$date1."'";
            $condbrs1 = 'Bonreceptionstock.date >= '."'".$date1."'";
            $condbss1 = 'Bonsortiestock.date >= '."'".$date1."'";
            $condi1 = 'Inventaire.date >= '."'".$date1."'";
            $condp1 = 'Production.date >= '."'".$date1."'";
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
            $condp4="";
        }
        
        if ($this->request->data['Recherche']['date2'] != "__/__/____" &&(!empty($this->request->data['Recherche']['date2']))){
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
            $condp2 = 'Production.date <= '."'".$date2."'";
            
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
            $condp4="";
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
       
            $condt6  = 'Lignetransfert.article_id ='.$articleid;
            $condrs6 = 'Lignebonreceptionstock.article_id ='.$articleid;
            $condss6 = 'Lignebonsortiestock.article_id ='.$articleid;
            $condi6  = 'Ligneinventaire.article_id ='.$articleid;
            $condlp6  = 'Ligneproduction.article_id ='.$articleid; 
            $condp6  = 'Production.nvarticle ='.$articleid;
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
        $condi7="";
        if ($this->request->data['Recherche']['depot_id']) {
            $depotid = $this->request->data['Recherche']['depot_id'];
            $conddepot = 'Depot.id ='.$depotid;
            
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
            $condfaf7 ='Lignefactureavoirfr.depot_id ='.$depotid;
            $condtt7  = 'Transfert.depotarrive ='.$depotid;
            $condt7  = 'Lignetransfert.depot_id ='.$depotid;
            $condbrs7 ='Lignebonreceptionstock.depot_id ='.$depotid;
            $condbss7 ='Lignebonsortiestock.depot_id ='.$depotid;
            $condi7  = 'Inventaire.depot_id ='.$depotid;
            $condlp7  = 'Ligneproduction.depot_id ='.$depotid; 
            $condp7  = 'Production.depotarrive ='.$depotid; 
    
    
    
    
        $ligneinventaires=$this->Ligneinventaire->find('first', array(
        'conditions' => array(@$condi6,@$condi7),'recursive'=>0,'order'=>array('Ligneinventaire.id'=>'desc') ));
        //debug($ligneinventaires);die;
      if(!empty($ligneinventaires)){
      $qte=$ligneinventaires['Ligneinventaire']['quantite']  ; 
            if($testdate==0){
      $date12 = date("Y-m-d", strtotime(str_replace('/', '-', $ligneinventaires['Inventaire']['date'])));
            $condb1 = 'Bonlivraison.date >= '."'".$date12."'";
            $condf1 = 'Factureclient.date >= '."'".$date12."'";
            $condfa1 = 'Factureavoir.date >= '."'".$date12."'";
            $condbb1 = 'Bonreception.date >= '."'".$date12."'";
            $condff1 = 'Facture.date >= '."'".$date12."'";
            $condt1= 'Transfert.date >= '."'".$date12."'";
            $condbrs1 = 'Bonreceptionstock.date >= '."'".$date12."'";
            $condbss1 = 'Bonsortiestock.date >= '."'".$date12."'";
            $condi1 = 'Inventaire.date >= '."'".$date12."'";
            $condp1 = 'Production.date >= '."'".$date12."'";
            
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
            $condp4=""; 
            }
      }else{
          
      $qte=0;
      }
      $date13='2017-01-01'; 
            
            $condb12 = 'Bonlivraison.date >= '."'".$date13."'";
            $condf12 = 'Factureclient.date >= '."'".$date13."'";
            
            $condfa12 = 'Factureavoir.date >= '."'".$date13."'";
            $condbb12 = 'Bonreception.date >= '."'".$date13."'";
            $condff12 = 'Facture.date >= '."'".$date13."'";
            
            $condt12= 'Transfert.date >= '."'".$date13."'";
            $condbrs12 = 'Bonreceptionstock.date >= '."'".$date13."'";
            $condbss12 = 'Bonsortiestock.date >= '."'".$date13."'";
            $condi12 = 'Inventaire.date >= '."'".$date13."'";
            $condp12 = 'Production.date >= '."'".$date13."'";
      //debug(@$condb12);
      //debug(@$condb11);
      //debug(@$condb7);
            $solde=$qte;
            //debug("inventaire".$solde);
             if($testdate==1){
            $soldebl=$this->Lignelivraison->find('first', array(
            'fields'=>array('sum((Lignelivraison.quantite)) as quantite'),    
            'conditions' => array(@$condb12,@$condb11,@$condb6,@$condb7),'recursive'=>0 ));
            //debug($soldebl);die;
            if(!empty($soldebl)){
                $solde=$solde-$soldebl[0]['quantite'];
                //debug("bl");
                //debug("bl".$solde);
            }
            $soldefac=$this->Lignefactureclient->find('first', array(
            'fields'=>array('sum((Lignefactureclient.quantite)) as quantite'),    
            'conditions' => array(@$condf12,@$condf11,@$condf6,@$condf7,'Factureclient.source="fac"'),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde-$soldefac[0]['quantite'];
                //debug("fc");
                //debug("fc".$solde);
            }
            $soldeavoir=$this->Lignefactureavoir->find('first', array(
            'fields'=>array('sum(Lignefactureavoir.quantite) as quantite'),    
            'conditions' => array(@$condfa12,@$condfa11,@$condfa6,@$condfa7),'recursive'=>0 ));
            if(!empty($soldeavoir)){
                $solde=$solde+$soldeavoir[0]['quantite'];
               // debug($soldeavoir[0]['quantite']);
                //debug("avoir".$solde);
            }
            $solderec=$this->Lignereception->find('first', array(
            'fields'=>array('sum(Lignereception.quantite) as quantite'),    
            'conditions' => array('Bonreception.facture_id'=>0,@$condbb12,@$condbb11,@$condbb6,@$condbb7),'recursive'=>0 ));
            if(!empty($solderec)){
                $solde=$solde+$solderec[0]['quantite'];
                //debug("r");
                //debug("recp".$solde);
            }
            $soldefacf=$this->Lignefacture->find('first', array(
            'fields'=>array('sum(Lignefacture.quantite) as quantite'),    
            'conditions' => array(@$condff12,@$condff11,@$condff6,@$condff7),'recursive'=>0 ));
            if(!empty($soldefacf)){
                $solde=$solde+$soldefacf[0]['quantite'];
               // debug("ff");
               // debug("fc_frs".$solde);
            }
            $solderepst=$this->Lignebonreceptionstock->find('first', array(
            'fields'=>array('sum(Lignebonreceptionstock.quantite) as quantite'),    
            'conditions' => array(@$condbrs12,@$condbrs11,@$condrs6,@$condbrs7),'recursive'=>2 ));
            if(!empty($solderepst)){
                $solde=$solde+$solderepst[0]['quantite'];
                //debug("bs");
               // debug("recp_st".$solde);
            }
            $soldesst=$this->Lignebonsortiestock->find('first', array(
            'fields'=>array('sum(Lignebonsortiestock.quantite) as quantite'),    
            'conditions' => array(@$condbss12,@$condbss11,@$condss6,@$condbss7),'recursive'=>2 ));
            if(!empty($soldesst)){
                $solde=$solde-$soldesst[0]['quantite'];
                //debug($soldesst[0]['quantite']);
                //debug("sorie_st".$solde);
            }
            $prodsortie=$this->Ligneproduction->find('first', array(
            'fields'=>array('sum(Ligneproduction.qte) as quantite'),    
            'conditions' => array(@$condp12,@$condp11,@$condlp6,@$condlp7),'recursive'=>2 ));
            if(!empty($prodsortie)){
                $solde=$solde-$prodsortie[0]['quantite'];
                //debug("production_sortie".$solde);
            }
            $prodentre=$this->Production->find('first', array(
            'fields'=>array('sum(Production.qte) as quantite'),    
            'conditions' => array(@$condp12,@$condp11,@$condp6,@$condp7),'recursive'=>2 ));
            if(!empty($prodentre)){
                $solde=$solde+$prodentre[0]['quantite'];
                //debug("production_entreé".$solde);
            }
            $lignetransfert=$this->Lignetransfert->find('first', array(
            'fields'=>array('sum(Lignetransfert.quantite) as quantite'),    
            'conditions' => array(@$condt12,@$condt11,@$condt6,@$condt7),'recursive'=>2 ));
            if(!empty($lignetransfert)){
                //debug($lignetransfert[0]['quantite']);
                $solde=$solde-$lignetransfert[0]['quantite'];
                //debug("tansfert_sortie".$solde);
            }
            $transfert=$this->Lignetransfert->find('first', array(
            'fields'=>array('sum(Lignetransfert.quantite) as quantite'),    
            'conditions' => array(@$condt12,@$condt11,@$condt6,@$condtt7),'recursive'=>2 ));
            if(!empty($transfert)){
                //debug($transfert[0]['quantite']);
                $solde=$solde+$transfert[0]['quantite'];
                //debug("transfert_entreé".$solde);
            }
            }
      
           //debug($solde);

            $tabligneinventaires['client']="";
            $tabligneinventaires['fournisseur']="";
            $tabligneinventaires['utilisateur']="Stock Initial";
            $tabligneinventaires['date']="";
            $tabligneinventaires['type']="";
            $tabligneinventaires['indice']=10;
            $tabligneinventaires['numero']="";
            $tabligneinventaires['article']="";
            $tabligneinventaires['qte']=$solde;
            $tabligneinventaires['pu']="";
            $tabligneinventaires['ptot']="";
            $tabligneinventaires['mode']="";
            $historiquearticles=$this->Historiquearticle->find('first', array(
            'conditions' => array('Historiquearticle.indice'=>10),'recursive'=>-1 )); 
            if(!empty($historiquearticles)){
            $tabligneinventaires['id']=$historiquearticles['Historiquearticle']['id'];
            $tabligneinventaires['qte']=$historiquearticles['Historiquearticle']['qte']+$solde;
            }
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tabligneinventaires);
            
      
            //debug($solde);

//            $tabligneinventaires['client']="";
//            $tabligneinventaires['fournisseur']="";
//            $tabligneinventaires['utilisateur']="Stock Initial";
//            $tabligneinventaires['date']="";
//            $tabligneinventaires['type']="";
//            $tabligneinventaires['indice']=10;
//            $tabligneinventaires['numero']="";
//            $tabligneinventaires['article']="";
//            $tabligneinventaires['qte']=$solde;
//            $tabligneinventaires['pu']="";
//            $tabligneinventaires['ptot']="";
//            $tabligneinventaires['mode']="";
//            $historiquearticles=$this->Historiquearticle->find('first', array(
//            'conditions' => array('Historiquearticle.indice'=>10),'recursive'=>-1 )); 
//            if(!empty($historiquearticles)){
//            $tabligneinventaires['id']=$historiquearticles['Historiquearticle']['id'];
//            $tabligneinventaires['qte']=$historiquearticles['Historiquearticle']['qte']+$qte;
//            }
//            $this->Historiquearticle->create();
//            $this->Historiquearticle->save($tabligneinventaires);
//        
            
   
//******************************************************************************************************************************        
             
           
            
                
        
            

//******************************************************************************************************************************        
            $lignelivrisons=$this->Lignelivraison->find('all', array(
            'conditions' => array(@$condb1,@$condb2,@$condb3,@$condb4,@$condb6,@$condb7),'recursive'=>0 ));
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
            $tablignelivrisons['depot']=$lignelivrison['Depot']['code'];
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignelivrisons);
            }
//******************************************************************************************************************************        
            $lignefactures=$this->Lignefactureclient->find('all', array(
            'conditions' => array('Factureclient.source="fac"',@$condf1,@$condf2,@$condf3,@$condf4,@$condf6,@$condf7),'recursive'=>0 ));
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
            $tablignefactures['ptot']=$lignefacture['Lignefactureclient']['totalttc'];
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
            $tablignefactureavoirs['ptot']=$lignefactureavoir['Lignefactureavoir']['totalttc'];
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
            $tablignereceptions['pu']=$lignereception['Lignereception']['prix'];
            $tablignereceptions['ptot']=$lignereception['Lignereception']['totalttc'];
            $tablignereceptions['mode']="Entreé";
            $tablignereceptions['depot']=$codedepot;
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignereceptions);
            }
//******************************************************************************************************************************        

//******************************************************************************************************************************        
            $lignefacturefours=$this->Lignefacture->find('all', array(
            'conditions' => array(@$condff1,@$condff2,@$condff4,@$condff5,@$condff6,@$condff7),'recursive'=>0 ));
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
            $depot= $this->Depot->find('first',array('conditions'=>array('Depot.id'=>$facturefour['Lignefacture']['depot_id']),'recursive'=>-1));
            if(!empty($depot)){
            $codedepot=$depot['Depot']['code'];        
            }else {
            $codedepot="";    
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
            $tabfacturefours['pu']=$facturefour['Lignefacture']['prix'];
            $tabfacturefours['ptot']=$facturefour['Lignefacture']['totalttc'];
            $tabfacturefours['mode']="Entreé";
            $tabfacturefours['depot']=$codedepot;
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tabfacturefours);
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
            $tablignebonsortiestocks['client']="";
            $tablignebonsortiestocks['fournisseur']="";
            $tablignebonsortiestocks['utilisateur']=$name;
            $tablignebonsortiestocks['date']=$lignebonsortiestock['Bonsortiestock']['date'];
            $tablignebonsortiestocks['type']="Bon sortie stock";
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
            $historiquearticles=$this->Historiquearticle->find('all', array(
            'conditions' => array(),'recursive'=>-1 )); 
        //debug($historiquearticles);

//******************************************************************************************************************************        
                   // debug($solde);die;

            $ligneproductions=$this->Ligneproduction->find('all', array(
            'conditions' => array(@$condp1,@$condp2,@$condp4,@$condlp6,@$condlp7),'recursive'=>0 ));
           
            $tablignetransferts=array(); 
            foreach ($ligneproductions as $lignetransfert) {
            $depot= $this->Depot->find('first',array('conditions'=>array('Depot.id'=>$lignetransfert['Ligneproduction']['depot_id']),'recursive'=>-1));
            if(!empty($depot)){
            $codedepot=$depot['Depot']['code'];        
            }else {
            $codedepot="";    
            }
            $tablignetransferts['client']="";
            $tablignetransferts['fournisseur']="";
            $tablignetransferts['utilisateur']="";
            $tablignetransferts['date']=$lignetransfert['Production']['date'];
            $tablignetransferts['type']="Production";
            $tablignetransferts['indice']=9;
            $tablignetransferts['numero']=$lignetransfert['Production']['numero'];
            $tablignetransferts['article']=$lignetransfert['Article']['name'];
            $tablignetransferts['qte']=$lignetransfert['Ligneproduction']['qte'];
            $tablignetransferts['pu']="";
            $tablignetransferts['ptot']="";
            $tablignetransferts['mode']="Sortie";
            $tablignetransferts['depot']=$codedepot;
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignetransferts);
            }
            $articles = $this->Article->find('list');
            $lignetransferts=$this->Production->find('all', array(
            'conditions' => array(@$condp1,@$condp2,@$condp4,@$condp6,@$condp7),'recursive'=>0 ));
            
            $tablignetransferts=array(); 
            foreach ($lignetransferts as $lignetransfert) {
             $depot= $this->Depot->find('first',array('conditions'=>array('Depot.id'=>$lignetransfert['Production']['depotarrive']),'recursive'=>-1));
            if(!empty($depot)){
            $codedepot=$depot['Depot']['code'];        
            }else {
            $codedepot="";    
            }
            $tablignetransferts['client']="";
            $tablignetransferts['fournisseur']="";
            $tablignetransferts['utilisateur']="";
            $tablignetransferts['date']=$lignetransfert['Production']['date'];
            $tablignetransferts['type']="Production";
            $tablignetransferts['indice']=9;
            $tablignetransferts['numero']=$lignetransfert['Production']['numero'];
            $tablignetransferts['article']=$articles[$lignetransfert['Production']['nvarticle']];
            $tablignetransferts['qte']=$lignetransfert['Production']['qte'];
            $tablignetransferts['pu']="";
            $tablignetransferts['ptot']="";
            $tablignetransferts['mode']="Entreé";
            $tablignetransferts['depot']=$codedepot;
            $this->Historiquearticle->create();
            $this->Historiquearticle->save($tablignetransferts);
            
            
            }
}
    //**********************************************************************************************************        

           
            
            
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
        $articles = $this->Article->find('list');
        $clients = $this->Client->find('list'); 
        $fournisseurs = $this->Fournisseur->find('list'); 
        $typeligneventes = $this->Typelignevente->find('list'); 
        $depots = $this->Depot->find('list');
        $this->set(compact('depotid','depots','typeligneventes','clientid','articleid','fournisseurid','date1','date2','historiquearticles','fournisseurs','clients','articles','exercices','lignedevis','lignecommandes','lignelivrisons','lignefactures','name','exerciceid'));
               
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
        
         public function corrigestock() {
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
      
        if ($this->request->query['depotid']) {
            $depotid = $this->request->query['depotid'];
            
        } 
        if ($this->request->query['articleid']) {
            $articleid = $this->request->query['articleid'];
            
        }
        //$this->stock($depotid,$articleid);
        //$this->redirect(array('action' => 'index'));
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
