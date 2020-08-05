<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
ini_set('max_execution_time', 3600); 
ini_set('memory_limit', '-1');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
  
    function stock($dep=null,$art=null){
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
            $this->loadModel('Inventaire');
            $this->loadModel('Depot');
            $this->loadModel('Client');
            $this->loadModel('Exercice');
            $this->loadModel('Article');
            $this->loadModel('Fournisseur');
            $this->loadModel('Utilisateur');
            $this->loadModel('Ligneproduction');
            $this->loadModel('Production');
            $this->loadModel('Stockdepot');
                $stock=$this->Stockdepot->find('all',array('recursive'=>-1
                ,'conditions'=>array('Stockdepot.depot_id'=>@$dep,'Stockdepot.article_id'=>@$art)
                    ));
                foreach ($stock as $ligne){
                $articleid=$ligne['Stockdepot']['article_id'];
                $depotid=$ligne['Stockdepot']['depot_id'];
                $id=$ligne['Stockdepot']['id'];
                $solde=0;
                if(!empty($articleid)){
                //********************************************
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
                //***********************************************
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
                $date12='2017-01-01';
                $qte=0;$ent=0;$sort=0;
                $ligneinventaires=$this->Ligneinventaire->find('first', array(
                'conditions' => array(@$condi6,@$condi7,'Inventaire.date = "2017-01-01"'),'recursive'=>0,'order'=>array('Ligneinventaire.id'=>'desc') ));
                if(!empty($ligneinventaires)){
                $qte=$ligneinventaires['Ligneinventaire']['quantite'];
                $solde=$solde+$qte;
                $ent=$ent+$solde;
                $date12 = "2017-01-01";
                }
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
                
            $soldebl=$this->Lignelivraison->find('first', array(
            'fields'=>array('sum((Lignelivraison.quantite)) as quantite'),    
            'conditions' => array(@$condb1,@$condb6,@$condb7,'Bonlivraison.factureclient_id'=>0),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde-$soldebl[0]['quantite'];
                $sort=$sort+$soldebl[0]['quantite'];
            }
            $soldefac=$this->Lignefactureclient->find('first', array(
            'fields'=>array('sum((Lignefactureclient.quantite)) as quantite'),    
            'conditions' => array(@$condf1,@$condf6,@$condf7),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde-$soldefac[0]['quantite'];
                $sort=$sort+$soldefac[0]['quantite'];
            }
            $soldeavoir=$this->Lignefactureavoir->find('first', array(
            'fields'=>array('sum(Lignefactureavoir.quantite) as quantite'),    
            'conditions' => array(@$condfa1,@$condfa6,@$condfa7),'recursive'=>0 ));
            if(!empty($soldeavoir)){
                $solde=$solde+$soldeavoir[0]['quantite'];
                $ent=$ent+$soldeavoir[0]['quantite'];
            }
            $solderec=$this->Lignereception->find('first', array(
            'fields'=>array('sum(Lignereception.quantite) as quantite'),    
            'conditions' => array('Bonreception.facture_id'=>0,@$condbb1,@$condbb6,@$condbb7),'recursive'=>0 ));
            if(!empty($solderec)){
                $solde=$solde+$solderec[0]['quantite'];
                $ent=$ent+$solderec[0]['quantite'];
            }
            $soldefacf=$this->Lignefacture->find('first', array(
            'fields'=>array('sum(Lignefacture.quantite) as quantite'),    
            'conditions' => array(@$condff1,@$condff6,@$condff7),'recursive'=>0 ));
            if(!empty($soldefacf)){
                $solde=$solde+$soldefacf[0]['quantite'];
                $ent=$ent+$soldefacf[0]['quantite'];
            }
            $solderepst=$this->Lignebonreceptionstock->find('first', array(
            'fields'=>array('sum(Lignebonreceptionstock.quantite) as quantite'),    
            'conditions' => array(@$condrs1,@$condrs6,@$condbrs7),'recursive'=>2 ));
            if(!empty($solderepst)){
                $solde=$solde+$solderepst[0]['quantite'];
                $ent=$ent+$solderepst[0]['quantite'];
            }
            $soldesst=$this->Lignebonsortiestock->find('first', array(
            'fields'=>array('sum(Lignebonsortiestock.quantite) as quantite'),    
            'conditions' => array(@$condss1,@$condss6,@$condbss7),'recursive'=>2 ));
            if(!empty($soldesst)){
            $solde=$solde-$soldesst[0]['quantite'];
            $sort=$sort+$soldesst[0]['quantite'];
            }
            $transfetsortie=$this->Lignetransfert->find('first', array(
            'fields'=>array('sum(Lignetransfert.quantite) as quantite'),    
            'conditions' => array(@$condt1,@$condt6,@$condt7),'recursive'=>2 ));
            if(!empty($transfetsortie)){
                $solde=$solde-$transfetsortie[0]['quantite'];
                $sort=$sort+$transfetsortie[0]['quantite'];
            }
            $transfertentre=$this->Lignetransfert->find('first', array(
            'fields'=>array('sum(Lignetransfert.quantite) as quantite'),    
            'conditions' => array(@$condt1,@$condt6,@$condtt7),'recursive'=>2 ));
            if(!empty($transfertentre)){
                $solde=$solde+$transfertentre[0]['quantite'];
                $ent=$ent+$transfertentre[0]['quantite'];
            }
            $prodsortie=$this->Ligneproduction->find('first', array(
            'fields'=>array('sum(Ligneproduction.qte) as quantite'),    
            'conditions' => array(@$condp1,@$condlp6,@$condlp7),'recursive'=>2 ));
            if(!empty($prodsortie)){
                $solde=$solde-$prodsortie[0]['quantite'];
                $ent=$ent+$prodsortie[0]['quantite'];
            }
            $prodentre=$this->Production->find('first', array(
            'fields'=>array('sum(Production.qte) as quantite'),    
            'conditions' => array(@$condp1,@$condp6,@$condp7),'recursive'=>2 ));
            if(!empty($prodentre)){
                $solde=$solde+$prodentre[0]['quantite'];
                $sort=$sort+$prodentre[0]['quantite'];
            }
            //echo 'depot'.$depotid.' qte = '.$solde. 'ente = '.$ent.' sort = '.$sort.' inv ='.$qte.'<br>';
            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $solde), 
           array('Stockdepot.id' => $id));
 }
    } }
    
    
    function misejour($model=null,$operation=null,$id=null,$pv=null){
        
                                $this->loadModel('Tracemisejour');
                                $tab['model']=$model;
                                $tab['id_piece']=$id;
                                if(! in_array($operation,Array("edit","add"))){
                                $tab['numero']=$operation; 
                                $operation="delete";
                                $tab['pointdevente_id']=$pv;
                                }
                                $tab['operation']=$operation;
                                $tab['utilisateur_id']=CakeSession::read('users');
                                $tab['date']=date("Y-m-d");
                                $tab['heure']=date("H:i",time());
                                $this->Tracemisejour->create();
                                $this->Tracemisejour->save($tab); 
                
    }
    function stockajouter($depot=null){

            $this->loadModel('Article');
            $this->loadModel('Stockdepot');
            $this->loadModel('Depot');
            $articles=$this->Article->find('all',array('conditions'=>array('Article.id<5000'),'recursive'=>-1));
            foreach ($articles as $article){
                $stock=$this->Stockdepot->find('first',array('recursive'=>-1
                ,'conditions'=>array('Stockdepot.depot_id'=>$depot,'Stockdepot.article_id'=>$article['Article']['id'])
                    ));
                if(empty($stock)){
                $tab['article_id']= $article['Article']['id'];
                $tab['depot_id']=$depot;
                $tab['quantite']= 0;
                $tab['prix']= 0;
                $this->Stockdepot->create();
                $this->Stockdepot->save($tab); 
                }
            }
            
                
    }
    
    function correctionstockinventaire($dep=null,$art=null,$date=null){
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
            $this->loadModel('Inventaire');
            $this->loadModel('Depot');
            $this->loadModel('Client');
            $this->loadModel('Exercice');
            $this->loadModel('Article');
            $this->loadModel('Fournisseur');
            $this->loadModel('Utilisateur');
            $this->loadModel('Ligneproduction');
            $this->loadModel('Production');
            $this->loadModel('Stockdepot');
                $stock=$this->Stockdepot->find('all',array('recursive'=>-1
                ,'conditions'=>array('Stockdepot.depot_id'=>@$dep,'Stockdepot.article_id'=>@$art)
                    ));
                foreach ($stock as $ligne){
                $articleid=$ligne['Stockdepot']['article_id'];
                $depotid=$ligne['Stockdepot']['depot_id'];
                $id=$ligne['Stockdepot']['id'];
                $solde=0;
                if(!empty($articleid)){
                //********************************************
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
                //***********************************************
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
                $qte=0;$ent=0;$sort=0;
                $ligneinventaires=$this->Ligneinventaire->find('first', array(
                'conditions' => array(@$condi6,@$condi7),'recursive'=>0,'order'=>array('Ligneinventaire.id'=>'desc') ));
                if(!empty($ligneinventaires)){
                $qte=$ligneinventaires['Ligneinventaire']['quantite'];
                $solde=$solde+$qte;
                $ent=$ent+$solde;
                }
                //debug($solde);
                $date12 = date("Y-m-d", strtotime(str_replace('/', '-',$date)));
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
                
            $soldebl=$this->Lignelivraison->find('first', array(
            'fields'=>array('sum((Lignelivraison.quantite)) as quantite'),    
            'conditions' => array(@$condb1,@$condb6,@$condb7,'Bonlivraison.factureclient_id'=>0),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde-$soldebl[0]['quantite'];
                $sort=$sort+$soldebl[0]['quantite'];
            }
            $soldefac=$this->Lignefactureclient->find('first', array(
            'fields'=>array('sum((Lignefactureclient.quantite)) as quantite'),    
            'conditions' => array(@$condf1,@$condf6,@$condf7),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde-$soldefac[0]['quantite'];
                $sort=$sort+$soldefac[0]['quantite'];
            }
            $soldeavoir=$this->Lignefactureavoir->find('first', array(
            'fields'=>array('sum(Lignefactureavoir.quantite) as quantite'),    
            'conditions' => array(@$condfa1,@$condfa6,@$condfa7),'recursive'=>0 ));
            if(!empty($soldeavoir)){
                $solde=$solde+$soldeavoir[0]['quantite'];
                $ent=$ent+$soldeavoir[0]['quantite'];
            }
            $solderec=$this->Lignereception->find('first', array(
            'fields'=>array('sum(Lignereception.quantite) as quantite'),    
            'conditions' => array('Bonreception.facture_id'=>0,@$condbb1,@$condbb6,@$condbb7),'recursive'=>0 ));
            if(!empty($solderec)){
                $solde=$solde+$solderec[0]['quantite'];
                $ent=$ent+$solderec[0]['quantite'];
            }
            $soldefacf=$this->Lignefacture->find('first', array(
            'fields'=>array('sum(Lignefacture.quantite) as quantite'),    
            'conditions' => array(@$condff1,@$condff6,@$condff7),'recursive'=>0 ));
            if(!empty($soldefacf)){
                $solde=$solde+$soldefacf[0]['quantite'];
                $ent=$ent+$soldefacf[0]['quantite'];
            }
            $solderepst=$this->Lignebonreceptionstock->find('first', array(
            'fields'=>array('sum(Lignebonreceptionstock.quantite) as quantite'),    
            'conditions' => array(@$condrs1,@$condrs6,@$condbrs7),'recursive'=>2 ));
            if(!empty($solderepst)){
                $solde=$solde+$solderepst[0]['quantite'];
                $ent=$ent+$solderepst[0]['quantite'];
            }
            $soldesst=$this->Lignebonsortiestock->find('first', array(
            'fields'=>array('sum(Lignebonsortiestock.quantite) as quantite'),    
            'conditions' => array(@$condss1,@$condss6,@$condbss7),'recursive'=>2 ));
            if(!empty($soldesst)){
            $solde=$solde-$soldesst[0]['quantite'];
            $sort=$sort+$soldesst[0]['quantite'];
            }
            $transfetsortie=$this->Lignetransfert->find('first', array(
            'fields'=>array('sum(Lignetransfert.quantite) as quantite'),    
            'conditions' => array(@$condt1,@$condt6,@$condt7),'recursive'=>2 ));
            if(!empty($transfetsortie)){
                $solde=$solde-$transfetsortie[0]['quantite'];
                $sort=$sort+$transfetsortie[0]['quantite'];
            }
            $transfertentre=$this->Lignetransfert->find('first', array(
            'fields'=>array('sum(Lignetransfert.quantite) as quantite'),    
            'conditions' => array(@$condt1,@$condt6,@$condtt7),'recursive'=>2 ));
            if(!empty($transfertentre)){
                $solde=$solde+$transfertentre[0]['quantite'];
                $ent=$ent+$transfertentre[0]['quantite'];
            }
            $prodsortie=$this->Ligneproduction->find('first', array(
            'fields'=>array('sum(Ligneproduction.qte) as quantite'),    
            'conditions' => array(@$condp1,@$condlp6,@$condlp7),'recursive'=>2 ));
            if(!empty($prodsortie)){
                $solde=$solde-$prodsortie[0]['quantite'];
                $ent=$ent+$prodsortie[0]['quantite'];
            }
            $prodentre=$this->Production->find('first', array(
            'fields'=>array('sum(Production.qte) as quantite'),    
            'conditions' => array(@$condp1,@$condp6,@$condp7),'recursive'=>2 ));
            if(!empty($prodentre)){
                $solde=$solde+$prodentre[0]['quantite'];
                $sort=$sort+$prodentre[0]['quantite'];
            }
            //echo 'depot'.$depotid.' qte = '.$solde. 'ente = '.$ent.' sort = '.$sort.' inv ='.$qte.'<br>';
            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $solde), 
           array('Stockdepot.id' => $id));
 }
    } }
    
     function correctionstockinventairepararticle($dep=null,$art=null,$date=null){
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
            $this->loadModel('Inventaire');
            $this->loadModel('Depot');
            $this->loadModel('Client');
            $this->loadModel('Exercice');
            $this->loadModel('Article');
            $this->loadModel('Fournisseur');
            $this->loadModel('Utilisateur');
            $this->loadModel('Ligneproduction');
            $this->loadModel('Production');
            $this->loadModel('Stockdepot');
                $stock=$this->Stockdepot->find('all',array('recursive'=>-1
                ,'conditions'=>array('Stockdepot.depot_id'=>@$dep,'Stockdepot.article_id'=>@$art)
                    ));
                foreach ($stock as $ligne){
                $articleid=$ligne['Stockdepot']['article_id'];
                $depotid=$ligne['Stockdepot']['depot_id'];
                $id=$ligne['Stockdepot']['id'];
                $solde=0;
                if(!empty($articleid)){
                //********************************************
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
                $condi7  = 'Ligneinventaire.depot_id ='.$depotid; 
                $condlp7  = 'Ligneproduction.depot_id ='.$depotid; 
                $condp7  = 'Production.depotarrive ='.$depotid; 
                //***********************************************
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
                $qte=0;$ent=0;$sort=0;
                $ligneinventaires=$this->Ligneinventaire->find('first', array(
                'conditions' => array(@$condi6,@$condi7),'recursive'=>0,'order'=>array('Ligneinventaire.id'=>'desc') ));
                if(!empty($ligneinventaires)){
                $qte=$ligneinventaires['Ligneinventaire']['quantite'];
                $solde=$solde+$qte;
                $ent=$ent+$solde;
                }
                //debug($solde);
                $date12 = date("Y-m-d", strtotime(str_replace('/', '-',$date)));
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
                
            $soldebl=$this->Lignelivraison->find('first', array(
            'fields'=>array('sum((Lignelivraison.quantite)) as quantite'),    
            'conditions' => array(@$condb1,@$condb6,@$condb7,'Bonlivraison.factureclient_id'=>0),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde-$soldebl[0]['quantite'];
                $sort=$sort+$soldebl[0]['quantite'];
            }
            $soldefac=$this->Lignefactureclient->find('first', array(
            'fields'=>array('sum((Lignefactureclient.quantite)) as quantite'),    
            'conditions' => array(@$condf1,@$condf6,@$condf7),'recursive'=>0 ));
            if(!empty($soldebl)){
                $solde=$solde-$soldefac[0]['quantite'];
                $sort=$sort+$soldefac[0]['quantite'];
            }
            $soldeavoir=$this->Lignefactureavoir->find('first', array(
            'fields'=>array('sum(Lignefactureavoir.quantite) as quantite'),    
            'conditions' => array(@$condfa1,@$condfa6,@$condfa7),'recursive'=>0 ));
            if(!empty($soldeavoir)){
                $solde=$solde+$soldeavoir[0]['quantite'];
                $ent=$ent+$soldeavoir[0]['quantite'];
            }
            $solderec=$this->Lignereception->find('first', array(
            'fields'=>array('sum(Lignereception.quantite) as quantite'),    
            'conditions' => array('Bonreception.facture_id'=>0,@$condbb1,@$condbb6,@$condbb7),'recursive'=>0 ));
            if(!empty($solderec)){
                $solde=$solde+$solderec[0]['quantite'];
                $ent=$ent+$solderec[0]['quantite'];
            }
            $soldefacf=$this->Lignefacture->find('first', array(
            'fields'=>array('sum(Lignefacture.quantite) as quantite'),    
            'conditions' => array(@$condff1,@$condff6,@$condff7),'recursive'=>0 ));
            if(!empty($soldefacf)){
                $solde=$solde+$soldefacf[0]['quantite'];
                $ent=$ent+$soldefacf[0]['quantite'];
            }
            $solderepst=$this->Lignebonreceptionstock->find('first', array(
            'fields'=>array('sum(Lignebonreceptionstock.quantite) as quantite'),    
            'conditions' => array(@$condrs1,@$condrs6,@$condbrs7),'recursive'=>2 ));
            if(!empty($solderepst)){
                $solde=$solde+$solderepst[0]['quantite'];
                $ent=$ent+$solderepst[0]['quantite'];
            }
            $soldesst=$this->Lignebonsortiestock->find('first', array(
            'fields'=>array('sum(Lignebonsortiestock.quantite) as quantite'),    
            'conditions' => array(@$condss1,@$condss6,@$condbss7),'recursive'=>2 ));
            if(!empty($soldesst)){
            $solde=$solde-$soldesst[0]['quantite'];
            $sort=$sort+$soldesst[0]['quantite'];
            }
            $transfetsortie=$this->Lignetransfert->find('first', array(
            'fields'=>array('sum(Lignetransfert.quantite) as quantite'),    
            'conditions' => array(@$condt1,@$condt6,@$condt7),'recursive'=>2 ));
            if(!empty($transfetsortie)){
                $solde=$solde-$transfetsortie[0]['quantite'];
                $sort=$sort+$transfetsortie[0]['quantite'];
            }
            $transfertentre=$this->Lignetransfert->find('first', array(
            'fields'=>array('sum(Lignetransfert.quantite) as quantite'),    
            'conditions' => array(@$condt1,@$condt6,@$condtt7),'recursive'=>2 ));
            if(!empty($transfertentre)){
                $solde=$solde+$transfertentre[0]['quantite'];
                $ent=$ent+$transfertentre[0]['quantite'];
            }
            $prodsortie=$this->Ligneproduction->find('first', array(
            'fields'=>array('sum(Ligneproduction.qte) as quantite'),    
            'conditions' => array(@$condp1,@$condlp6,@$condlp7),'recursive'=>2 ));
            if(!empty($prodsortie)){
                $solde=$solde-$prodsortie[0]['quantite'];
                $ent=$ent+$prodsortie[0]['quantite'];
            }
            $prodentre=$this->Production->find('first', array(
            'fields'=>array('sum(Production.qte) as quantite'),    
            'conditions' => array(@$condp1,@$condp6,@$condp7),'recursive'=>2 ));
            if(!empty($prodentre)){
                $solde=$solde+$prodentre[0]['quantite'];
                $sort=$sort+$prodentre[0]['quantite'];
            }
            //echo 'depot'.$depotid.' qte = '.$solde. 'ente = '.$ent.' sort = '.$sort.' inv ='.$qte.'<br>';
            $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $solde), 
           array('Stockdepot.id' => $id));
 }
    } }
    
    
    
    
    function arrd($montant=null,$nb_chiffre=null){
    $tabm=explode(".",$montant);
    
    if(!empty($tabm[1])){
    $troischiffre=substr($tabm[1],0,$nb_chiffre);
    $troischiffre=str_pad($troischiffre,$nb_chiffre, "0", STR_PAD_RIGHT);
    $n_v=$troischiffre;
    $ard=substr($tabm[1],$nb_chiffre,1);
    if($ard){
    if(($ard>=6) && ($ard <=9)) {
    $ard=$ard+1;
    } 
    $troischiffre=$n_v.''.$ard;
    }
    }else{
    $troischiffre=str_pad('',$nb_chiffre, "0", STR_PAD_RIGHT);    
    }
    $nouveau_montant=$tabm[0].'.'.$troischiffre;
    
    return $nouveau_montant;
    }
    
    
    
    static function encrypt_decrypt($string) {

        $string_length = strlen($string);
        $encrypted_string = "";
        /**
         * For each character of the given string generate the code
         */
        for ($position = 0; $position < $string_length; $position++) {
            $key = (($string_length + $position) + 1);
            $key = (255 + $key) % 255;
            $get_char_to_be_encrypted = SUBSTR($string, $position, 1);
            $ascii_char = ORD($get_char_to_be_encrypted);
            $xored_char = $ascii_char ^ $key;  //xor operation 
            $encrypted_char = CHR($xored_char);
            $encrypted_string .= $encrypted_char;
        }
        /**
         * Return the encrypted/decrypted string
         */
        return $encrypted_string;
    }
    
    
    
    function miseajourfactureachat(){

            $this->loadModel('Facture');
            $this->loadModel('Reglement');
            $this->loadModel('Lignereglement');
            $this->loadModel('Factureavoirfr');
            $this->loadModel('Imputationfactureavoirfr');
            
            //facture achat 
            $factures=$this->Facture->find('all',array('conditions' => array('Facture.pointdevente_id' =>2),'recursive'=>-1));
            foreach ($factures as $facture){
            $lignereglements = $this->Lignereglement->find('all', array('fields' => array('SUM(Lignereglement.Montant) as montantreg')
            , 'conditions' => array('Lignereglement.facture_id' => $facture['Facture']['id']),'recursive'=>-1));
            if(empty($lignereglements[0][0]['montantreg'])){
              $lignereglements[0][0]['montantreg']=0;  
            }
            $ligneavoirs = $this->Imputationfactureavoirfr->find('all', array('fields' => array('SUM(Imputationfactureavoirfr.montant) as montantavoir')
            , 'conditions' => array('Imputationfactureavoirfr.facture_id' => $facture['Facture']['id']),'recursive'=>-1));
            if(empty($ligneavoirs[0][0]['montantavoir'])){
              $ligneavoirs[0][0]['montantavoir']=0;  
            }
            $this->Facture->updateAll(array('Facture.Montant_Regler' => $lignereglements[0][0]['montantreg']+$ligneavoirs[0][0]['montantavoir']),array('Facture.id' => $facture['Facture']['id']));
            }
            
            
            //facture avoir achat
            $factureavoirfrs=$this->Factureavoirfr->find('all',array('conditions' => array('Factureavoirfr.pointdevente_id' =>2),'recursive'=>-1));
            foreach ($factureavoirfrs as $factureavoirfr){
            $ligneavoirs = $this->Imputationfactureavoirfr->find('all', array('fields' => array('SUM(Imputationfactureavoirfr.montant) as montantavoir')
            , 'conditions' => array('Imputationfactureavoirfr.factureavoirfr_id	' => $factureavoirfr['Factureavoirfr']['id']),'recursive'=>-1));
            if(empty($ligneavoirs[0][0]['montantavoir'])){
              $ligneavoirs[0][0]['montantavoir']=0;  
            }
            $this->Factureavoirfr->updateAll(array('Factureavoirfr.montant_regle' => $ligneavoirs[0][0]['montantavoir']),array('Factureavoirfr.id' => $factureavoirfr['Factureavoirfr']['id']));
            }
            
            
            //reglement frs achat
            $reglements=$this->Reglement->find('all',array('conditions' => array('Reglement.pointdevente_id' =>2),'recursive'=>-1));
            foreach ($reglements as $reglement){
            $lignereglements = $this->Lignereglement->find('all', array('fields' => array('SUM(Lignereglement.Montant) as montantreg')
            , 'conditions' => array('Lignereglement.reglement_id' => $reglement['Reglement']['id']),'recursive'=>-1));
            if(empty($lignereglements[0][0]['montantreg'])){
              $lignereglements[0][0]['montantreg']=0;  
            }
            $this->Reglement->updateAll(array('Reglement.montantaffecte' => $lignereglements[0][0]['montantreg']),array('Reglement.id' => $reglement['Reglement']['id']));
            }
            
                
    }
    
    
    function miseajourfacturevente(){
        
            $this->loadModel('Rectiffact19');
            $this->loadModel('Factureclient');
            $this->loadModel('Lignefactureclient');
            $this->loadModel('Bonlivraison');
            $this->loadModel('Lignelivraison');
            $ii=0;
            
            $listefactures=$this->Rectiffact19->find('all',array('recursive'=>-1,'group' => array('num_fact')));
            //debug($listefactures);die;
            foreach ($listefactures as $i=>$lfacture){
            $lfac=$this->Factureclient->find('first',array('conditions' => array('Factureclient.integration LIKE "'.$lfacture['Rectiffact19']['num_fact'].'"'),'recursive'=>-1));    
            if(!empty($lfac)){
            $this->Lignefactureclient->deleteAll(array('Lignefactureclient.factureclient_id' => $lfac['Factureclient']['id']), false);
            }}
            
            
            $factures=$this->Rectiffact19->find('all',array('recursive'=>-1,'group' => array('num_fact,num_bl')));
            foreach ($factures as $i=>$facture){$ii=$i+1;
            echo " facture ".$facture['Rectiffact19']['num_fact']."<br>";   
            $fac=$this->Factureclient->find('first',array('conditions' => array('Factureclient.integration LIKE "'.$facture['Rectiffact19']['num_fact'].'"'),'recursive'=>-1));
            if(!empty($fac)){
            $bl=$this->Bonlivraison->find('first',array('conditions' => array('Bonlivraison.integration LIKE "'.$facture['Rectiffact19']['num_bl'].'"'),'recursive'=>-1));
            //debug($fac);debug($bl);
            if(!empty($bl)){
            $lignebl=$this->Lignelivraison->find('all',array('conditions' => array('Lignelivraison.bonlivraison_id' =>$bl['Bonlivraison']['id']),'recursive'=>-1));
            //debug($lignebl);
            foreach ($lignebl as $ligne) {
                //debug($ligne);
                    $lig = array();
                    $lig['factureclient_id'] = $fac['Factureclient']['id'];
                    $lig['bonlivraison_id'] = $ligne['Lignelivraison']['bonlivraison_id'];
                    $lig['depot_id'] = $ligne['Lignelivraison']['depot_id'];
                    $lig['article_id'] = $ligne['Lignelivraison']['article_id'];
                    $lig['quantite'] = $ligne['Lignelivraison']['quantite'];
                    $lig['quantitelivrai'] = $ligne['Lignelivraison']['quantite'];
                    $lig['prix'] = $ligne['Lignelivraison']['prix'];
                    $lig['prixnet'] = $ligne['Lignelivraison']['prixnet'];
                    $lig['puttc'] = $ligne['Lignelivraison']['puttc'];
                    $lig['totalhtans'] = $ligne['Lignelivraison']['prix'];
                    $lig['remise'] = $ligne['Lignelivraison']['remise'];
                    $lig['tva'] = $ligne['Lignelivraison']['tva'];
                    $lig['totalht'] = $ligne['Lignelivraison']['totalht'];
                    $lig['totalttc'] = $ligne['Lignelivraison']['totalttc'];
                    $lig['designation'] = $ligne['Lignelivraison']['designation'];
                    $this->Lignefactureclient->create();
                    $this->Lignefactureclient->save($lig);
                }
                $this->Bonlivraison->updateAll(array('Bonlivraison.factureclient_id' => $fac['Factureclient']['id']), array('Bonlivraison.id' =>$bl['Bonlivraison']['id']));
            
            } else{
                echo "BL ".$facture['Rectiffact19']['num_bl'] ." mahich mawjouda<br>";
            }   
            }else{
                echo "facture ".$facture['Rectiffact19']['num_fact'] ." mahich mawjouda<br>";
            }
            echo "fin ligne ".$ii."<br>";
            }
             
                
    }
    
}

