<?php
App::uses('AppController', 'Controller');
App::uses('CakeSession', 'Model/Datasource');
/**
 * Ticketcaisses Controller
 *
 * @property Ticketcaiss $Ticketcaiss
 */
class TicketcaissesController extends AppController {

    
    public function index() {
		$this->Ticketcaiss->recursive = 0;
		$this->set('ticketcaiss', $this->paginate());
	}
    
    
    
    
    
    
    


public function existecarte($carte = null)
		{
        $this->layout='';
		$this->loadModel('Cartefidelite');
		
		$cc=$this->Cartefidelite->find('all',array('conditions'=>array('Cartefidelite.numero'=>$carte)));
	if(!empty($cc))	$client=$cc[0]['Cartefidelite']['nomprenom']; else $client='';
	if(!empty($cc))	$id=$cc[0]['Cartefidelite']['id']; else $id='';
		$this->set(compact('client',$client));
		$this->set(compact('id',$id));
		}
		
		
public function qte()
{
        $this->layout='defaultnu';}

/**
 * index method
 *
 * @return void
 */
         public function imp($id = null) {
			  $Caisse=$this->Cookie->read('Caisse');

	/*   if ( $Caisse <> "Caisse"){
                 $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                }*/
            $this->loadModel('Ticketcaisseligne');
            $this->loadModel('Reglementcaisse');
            
		$this->Ticketcaiss->id = $id;
		if (!$this->Ticketcaiss->exists()) {
			throw new NotFoundException(__('Invalid ticketcaiss'));
		}
                
		$ligneticketcaiss=$this->Ticketcaisseligne->find('all',array('conditions'=>array('Ticketcaisseligne.ticketcaisse_id'=>$id),'recursive'=>1));
		$ticketcaiss=$this->Ticketcaiss->find('first',array('conditions'=>array('Ticketcaiss.id'=>$id),'recursive'=>0));
                $reg_id=$ticketcaiss['Ticketcaiss']['reglementcaisse_id'];
                $reglement=$this->Reglementcaisse->find('first',array('conditions'=>array('Reglementcaisse.id'=>$reg_id),'recursive'=>0));
                 //debug($ligneticketcaiss);die;
                $this->set(compact('ticketcaiss','ligneticketcaiss','reglement'));
                //$this->redirect(array('action' => 'index'));
	}

 public function accueil()
 {
	               $Caisse=$this->Cookie->read('Caisse');

	  /* if ( $Caisse <> "Caisse"){
                 $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                }*/
	 
	 
 }
	 
 
	public function add() {
            $Caisse=$this->Cookie->read('Caisse');
            $user=$this->Cookie->read('users');
            $pointv = $this->Cookie->read('point');
            $this->Cookie->write('Caisse', $Caisse, false, '24 hour');
            $this->Cookie->write('point', $pointv, false, '24 hour');
            $this->Cookie->write('users', $user, false, '24 hour');

        /*   if ( $Caisse <> "Caisse"){
                 $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                }*/
 
		   
		   
            $this->loadModel('Ticketcaisseligne');
            $this->loadModel('Paiement');
            $this->loadModel('Reglement');
            $this->loadModel('Lignereglement');
            $this->loadModel('Piecereglement');
            $this->loadModel('Cheque');
            $this->loadModel('Ticket');
            $this->loadModel('Depot');
            $this->loadModel('Article');
            $this->loadModel('Stockdepot');
            $this->loadModel('Ticketcaisselignepromo');
            $this->loadModel('Stockdepotfacture');
            $this->loadModel('Stockdepot');
            $this->loadModel('Ip');
            


        //$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	    //$ip = $this->Ip->find('all', array('recursive' => 0, 'conditions' => array( 'OR'=>array( 'Ip.host' => $hostname, 'Ip.ip' => $hostname))));
			// CakeSession::write('com',@$ip[0]['Ip']['com']);
			// CakeSession::write('ip',@$ip[0]['Ip']['ip']);


    if ($this->request->is('post')) {
        $enattente=$this->request->data['Ticketcaisse']['enattente'];
            
        
        
            if($enattente==2){
                $id=$this->request->data['Ticketcaisse']['ticket_repr'];
                $ticket_anc=$this->Ticketcaiss->find('first',array('conditions'=>array('Ticketcaiss.id'=>$id),'recursive'=>-1));
                $terji3stocks=$this->Stockdepotfacture->find('all',array('conditions'=>array('Stockdepotfacture.piece'=>'TicketCaisse','Stockdepotfacture.id_ticket'=>$id),'recursive'=>-1));
                //debug($terji3stocks);die;
                if(!empty($terji3stocks)){
                    foreach ($terji3stocks as $terji3stock){
                        //debug($terji3stock);die;
                        $lestk=$this->Stockdepot->find('first',array('conditions'=>array('Stockdepot.id'=>$terji3stock['Stockdepotfacture']['stockdepot_id']),'recursive'=>-1));
                       
                        $qt=0;
                        $qt=$lestk['Stockdepot']['quantite']+$terji3stock['Stockdepotfacture']['qte'];
                         //debug($qt);die;
                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => floatval($qt))
                                , array('Stockdepot.id' => $terji3stock['Stockdepotfacture']['stockdepot_id']));
                    }
                }
                $this->Stockdepotfacture->deleteAll(array('Stockdepotfacture.piece' => 'TicketCaisse','Stockdepotfacture.id_ticket' => $id));
                $this->Ticketcaisseligne->deleteAll(array('Ticketcaisseligne.ticketcaisse_id' => $id));
                $this->Ticketcaisselignepromo->deleteAll(array('Ticketcaisselignepromo.ticketcaisse_id' => $id));
                
            }
            
           // debug($this->request->data);die;
            
            
            
            $date2 = date('Y-m-d H:i:s');
            $depot_id = $this->Cookie->read('dpo');
            $journee_id = $this->Cookie->read('journee');
            $this->Cookie->write('dpo', $depot_id, false, '24 hour');
            $this->Cookie->write('journee', $journee_id, false, '24 hour');

            $this->request->data['Ticketcaisse']['Date'] = $date2;
            //$this->request->data['Ticketcaiss']['Type'] = 1;
            $this->request->data['Ticketcaisse']['utilisateur_id'] = $this->Cookie->read('users');
            $this->request->data['Ticketcaisse']['personnel_id'] = $this->Cookie->read('personnel_id');
            $this->request->data['Ticketcaisse']['pointvente_id'] = $this->Cookie->read('point');
            $this->request->data['Ticketcaisse']['depot_id'] = $this->Cookie->read('dpo');
            $us = $this->Cookie->read('users');
            if ($journee_id == '') {
                $this->loadModel('Journee');
                $jrs = $this->Journee->find('list', array('conditions' => array('Journee.depot_id' => 1, 'Journee.etat' => 0)));
                $journee_id = $jrs;
            }

            $this->request->data['Ticketcaisse']['journee_id'] = $journee_id;

            $nn = $this->Ticketcaiss->find('all', array('recursive' => -1, 'fields' =>
                array(
                    'MAX(Ticketcaiss.n) as num'
                ), 'conditions' => array('Ticketcaiss.journee_id' => $journee_id)));
            foreach ($nn as $num) {
                $n = $num[0]['num'];

                if (!empty($n)) {
                    $lastnum = $n;
                    $nume = intval($lastnum) + 1;
                    $mmp = $nume;
                } else {
                    $mmp = "1";
                }
            }
            $this->request->data['Ticketcaisse']['id'] = $journee_id . '-' . $us . '-' . $mmp;
            $this->request->data['Ticketcaisse']['n'] = $mmp;
            // debug( $this->request->data); die;
            $numero = $this->Ticketcaiss->find('all', array('recursive' => -1, 'fields' =>
                array(
                    'MAX(Ticketcaiss.Numero) as num'
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

            $this->request->data['Ticketcaisse']['Numero'] = $mm;
            
            if($enattente==2){
                $this->request->data['Ticketcaisse']['id'] = $ticket_anc['Ticketcaiss']['id'];
                $this->request->data['Ticketcaisse']['n'] = $ticket_anc['Ticketcaiss']['n'];
                $this->request->data['Ticketcaisse']['Numero'] = $ticket_anc['Ticketcaiss']['Numero'];
                $this->request->data['Ticketcaisse']['enattente'] = 0;
                $enattente=0;
            }
            
            
            
            
            
            $this->Ticketcaiss->create();
            // debug($this->request->data); die;
            if ($this->Ticketcaiss->save($this->request->data['Ticketcaisse'])) {
                $id = $this->request->data['Ticketcaisse']['id'];


                $prod = 0;


                $this->loadModel("Article");
                //----------- Creation ligne ticket + Mise a jour Stock depot et Qte alert d'article ------------
                if (isset($this->request->data['Lignecommande']) && !empty($this->request->data['Lignecommande'])) {
                    // debug($this->request->data);die;
                    $point = 0;
                    foreach ($this->request->data['Lignecommande'] as $ligne) {
                        //debug($ligne);die;
                        if ($ligne['qte'] != 0) {

                            $prod.=',' . $ligne['produit'];
                            $ligne['ticketcaisse_id'] = $this->request->data['Ticketcaisse']['id'];
                            $ligne['prix'] = $ligne['prix'];
                            $ligne['article_id'] = $ligne['produit'];

                            $ligne['designation'] = $ligne['des'];
                            $ligne['montant'] = $ligne['total'];

                            $art = $this->Article->find('all', array('contain' => array('Famille'), 'conditions' => array('Article.id' => $ligne['produit'])));

                            $point+= ($ligne['montant'] / 1.000) * $art[0]['Famille']['Points'];

                            $nn = $this->Ticketcaisseligne->find('all', array('recursive' => -1, 'fields' =>
                                array(
                                    'MAX(Ticketcaisseligne.n) as num'
                                ), 'conditions' => array('Ticketcaisseligne.ticketcaisse_id' => $this->request->data['Ticketcaisse']['id'])));

                            // debug($nn);
                            foreach ($nn as $num) {
                                $n = $num[0]['num'];

                                if (!empty($n)) {
                                    $lastnum = $n;
                                    $nume = intval($lastnum) + 1;
                                    $mmp = $nume;
                                } else {
                                    $mmp = "1";
                                }
                            }
                            $ligne['id'] = $mmp;

                            $ligne['id'] = $this->request->data['Ticketcaisse']['id'] . '-' . $mmp;
                            $ligne['n'] = $mmp;

                            //debug($ligne);

                            $this->Ticketcaisseligne->create();
                            $this->Ticketcaisseligne->save($ligne);
                            $idligne = $ligne['id'];



                            $ttprix = $ligne['ttprix'];
                            $ttqte = $ligne['ttqte'];
                            $ttcmd = $ligne['ttcmd'];

                            $artprix = explode('**', $ttprix);
                            $artqte = explode('**', $ttqte);
                            $artcmd = explode('**', $ttcmd);

                            for ($i = 1; $i <= count($artprix) - 1; $i++) {
                                if (@$artcmd[$i] != '')
                                    @$cmd[$artprix[$i]] = $artcmd[$i];
                                else
                                    @$cmd[$artprix[$i]] = 0;
                                if ($artcmd[$i] != 0) {

                                    $lignes['ticketcaisse_id'] = $id;
                                    $lignes['ticketcaisseligne_id'] = $idligne;
                                    $lignes['article_id'] = $ligne['produit'];
                                    $lignes['prixunite'] = $artprix[$i];
                                    $lignes['qteparlot'] = $artqte[$i];
                                    $lignes['qtecmd'] = $artcmd[$i];

                                    $lignes['montant'] = $artprix[$i] * $artqte[$i] * $artcmd[$i];


                                    $this->Ticketcaisselignepromo->create();
                                    $this->Ticketcaisselignepromo->save($lignes);
                                }
                            }



                            
                            
                            $qte_sorti = $ligne['qte'];
                            while ($qte_sorti > 0) {
                                $stckdepot = $this->Stockdepot->find('first', array(
                                    'conditions' => array('Stockdepot.article_id' => $ligne['produit'],
                                        'Stockdepot.depot_id' => $depot_id, 'Stockdepot.quantite >' => 0), false));
                                //debug($stckdepot);
                                if ($qte_sorti < $stckdepot['Stockdepot']['quantite']) {
                                    $qte = $stckdepot['Stockdepot']['quantite'] - $qte_sorti;
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    $this->loadModel('Stockdepotfacture');
                                    $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                    $tab['id_ticket'] = $id;
                                    $tab['piece'] = "TicketCaisse";
                                    $tab['qte'] = $qte_sorti;
                                    $tab['id_ticketligne'] = $idligne;
                                    $this->Stockdepotfacture->create();
                                    $this->Stockdepotfacture->save($tab);
                                    $qte_sorti = 0;
                                } else {
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 0), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    $qte_sorti = $qte_sorti - $stckdepot['Stockdepot']['quantite'];
                                    $this->loadModel('Stockdepotfacture');
                                    $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                    $tab['id_ticket'] = $id;
                                    $tab['piece'] = "TicketCaisse";
                                    $tab['id_ticketligne'] = $idligne;
                                    $tab['qte'] = $stckdepot['Stockdepot']['quantite'];
                                    $this->Stockdepotfacture->create();
                                    $this->Stockdepotfacture->save($tab);
                                }
                            }
                            
                            
                            
                        }
                    }//die;
                }
                $this->Ticketcaiss->updateAll(array('Ticketcaiss.point' => $point), array('Ticketcaiss.id' => $id));
                //	debug($point);die;	
                //----------------- enregistrement piece reglement  
                //$this->Session->setFlash(__('The ticketcaiss has been saved'));
?>
                <?php if($enattente==0){ ?>
                <script language="javascript" >     
                    document.location='<?php echo $this->webroot; ?>ticketcaisses/reg/<?php echo $id; ?>';
                    //document.location='<?php echo $this->webroot; ?>Ticketcaisses/add';
                </script>
                <?php } ?>
                <?php if($enattente==1){ ?>
                <script language="javascript" >     
                    document.location='<?php echo $this->webroot; ?>ticketcaisses/add';
                </script>
                <?php } ?>
                
                
                <?php
                // $this->redirect(array('action' => 'add'));
            } else {
                $this->Session->setFlash(__('The ticketcaiss could not be saved. Please, try again.'));
            }
        }
        $numero = $this->Ticketcaiss->find('all', array('recursive'=>-1,'fields' =>
            array(
                'MAX(Ticketcaiss.Numero) as num'
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
		$clients = $this->Ticketcaiss->Client->find('list');
                $codes = $this->Ticketcaiss->Client->find('list', array('recursive' => -1, 'fields' => array('Client.id', 'Client.Code')));
		$depots = $this->Ticketcaiss->Depot->find('list');
		$utilisateurs = $this->Ticketcaiss->Utilisateur->find('list');
                $modes = $this->Paiement->find('all', array('recursive' => -1, 'conditions' => array("OR" => array(
                    "Paiement.id" => array("1", "2", "15", "14")))));
                $articles = $this->Article->find('list',array('fields'=>array('Article.Code','Article.name')));
                $listdesignations = $this->Article->find('list',array('fields'=>'Article.desig_list'));
				$fond=$this->Cookie->read('Fond');
				$ip=$this->Cookie->read('ip');
				$com=$this->Cookie->read('com');
				
					 
		$this->set(compact('ip','com','fond','codes','clients','articles','listdesignations', 'depots', 'utilisateurs','mm','modes','banques'));
	}
        
        
        
        public function edit($id) {
           
            $this->loadModel('Ticketcaisseligne');
            $this->loadModel('Paiement');
            $this->loadModel('Reglement');
            $this->loadModel('Lignereglement');
            $this->loadModel('Piecereglement');
            $this->loadModel('Cheque');
            $this->loadModel('Ticket');
            $this->loadModel('Depot');
            $this->loadModel('Article');
            $this->loadModel('Stockdepot');
            $this->loadModel('Ticketcaisselignepromo');
            $this->loadModel('Stockdepotfacture');
            $this->loadModel('Stockdepot');
            $this->loadModel('Ip');
            


        //$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	    //$ip = $this->Ip->find('all', array('recursive' => 0, 'conditions' => array( 'OR'=>array( 'Ip.host' => $hostname, 'Ip.ip' => $hostname))));
			// CakeSession::write('com',@$ip[0]['Ip']['com']);
			// CakeSession::write('ip',@$ip[0]['Ip']['ip']);


    if ($this->request->is('post')) {
        debug($this->request->data);die;
        $enattente=$this->request->data['Ticketcaisse']['enattente'];
            
        
        
            if($enattente==2){
                $id=$this->request->data['Ticketcaisse']['ticket_repr'];
                $ticket_anc=$this->Ticketcaiss->find('first',array('conditions'=>array('Ticketcaiss.id'=>$id),'recursive'=>-1));
                $terji3stocks=$this->Stockdepotfacture->find('all',array('conditions'=>array('Stockdepotfacture.piece'=>'TicketCaisse','Stockdepotfacture.id_ticket'=>$id),'recursive'=>-1));
                //debug($terji3stocks);die;
                if(!empty($terji3stocks)){
                    foreach ($terji3stocks as $terji3stock){
                        //debug($terji3stock);die;
                        $lestk=$this->Stockdepot->find('first',array('conditions'=>array('Stockdepot.id'=>$terji3stock['Stockdepotfacture']['stockdepot_id']),'recursive'=>-1));
                       
                        $qt=0;
                        $qt=$lestk['Stockdepot']['quantite']+$terji3stock['Stockdepotfacture']['qte'];
                         //debug($qt);die;
                        $this->Stockdepot->updateAll(array('Stockdepot.quantite' => floatval($qt))
                                , array('Stockdepot.id' => $terji3stock['Stockdepotfacture']['stockdepot_id']));
                    }
                }
                $this->Stockdepotfacture->deleteAll(array('Stockdepotfacture.piece' => 'TicketCaisse','Stockdepotfacture.id_ticket' => $id));
                $this->Ticketcaisseligne->deleteAll(array('Ticketcaisseligne.ticketcaisse_id' => $id));
                $this->Ticketcaisselignepromo->deleteAll(array('Ticketcaisselignepromo.ticketcaisse_id' => $id));
                
            }
            
           // debug($this->request->data);die;
            
         
            
            if($enattente==2){
                $this->request->data['Ticketcaisse']['id'] = $ticket_anc['Ticketcaiss']['id'];
                $this->request->data['Ticketcaisse']['n'] = $ticket_anc['Ticketcaiss']['n'];
                $this->request->data['Ticketcaisse']['Numero'] = $ticket_anc['Ticketcaiss']['Numero'];
                $this->request->data['Ticketcaisse']['enattente'] = 0;
                $enattente=0;
            }
            
            
            
            
            
            $this->Ticketcaiss->create();
            // debug($this->request->data); die;
            if ($this->Ticketcaiss->save($this->request->data['Ticketcaisse'])) {
                $id = $this->request->data['Ticketcaisse']['id'];


                $prod = 0;


                $this->loadModel("Article");
                //----------- Creation ligne ticket + Mise a jour Stock depot et Qte alert d'article ------------
                if (isset($this->request->data['Lignecommande']) && !empty($this->request->data['Lignecommande'])) {
                    // debug($this->request->data);die;
                    $point = 0;
                    foreach ($this->request->data['Lignecommande'] as $ligne) {
                        //debug($ligne);die;
                        if ($ligne['qte'] != 0) {

                            $prod.=',' . $ligne['produit'];
                            $ligne['ticketcaisse_id'] = $this->request->data['Ticketcaisse']['id'];
                            $ligne['prix'] = $ligne['prix'];
                            $ligne['article_id'] = $ligne['produit'];

                            $ligne['designation'] = $ligne['des'];
                            $ligne['montant'] = $ligne['total'];

                            $art = $this->Article->find('all', array('contain' => array('Famille'), 'conditions' => array('Article.id' => $ligne['produit'])));

                            $point+= ($ligne['montant'] / 1.000) * $art[0]['Famille']['Points'];

                            $nn = $this->Ticketcaisseligne->find('all', array('recursive' => -1, 'fields' =>
                                array(
                                    'MAX(Ticketcaisseligne.n) as num'
                                ), 'conditions' => array('Ticketcaisseligne.ticketcaisse_id' => $this->request->data['Ticketcaisse']['id'])));

                            // debug($nn);
                            foreach ($nn as $num) {
                                $n = $num[0]['num'];

                                if (!empty($n)) {
                                    $lastnum = $n;
                                    $nume = intval($lastnum) + 1;
                                    $mmp = $nume;
                                } else {
                                    $mmp = "1";
                                }
                            }
                            $ligne['id'] = $mmp;

                            $ligne['id'] = $this->request->data['Ticketcaisse']['id'] . '-' . $mmp;
                            $ligne['n'] = $mmp;

                            //debug($ligne);

                            $this->Ticketcaisseligne->create();
                            $this->Ticketcaisseligne->save($ligne);
                            $idligne = $ligne['id'];



                            $ttprix = $ligne['ttprix'];
                            $ttqte = $ligne['ttqte'];
                            $ttcmd = $ligne['ttcmd'];

                            $artprix = explode('**', $ttprix);
                            $artqte = explode('**', $ttqte);
                            $artcmd = explode('**', $ttcmd);

                            for ($i = 1; $i <= count($artprix) - 1; $i++) {
                                if (@$artcmd[$i] != '')
                                    @$cmd[$artprix[$i]] = $artcmd[$i];
                                else
                                    @$cmd[$artprix[$i]] = 0;
                                if ($artcmd[$i] != 0) {

                                    $lignes['ticketcaisse_id'] = $id;
                                    $lignes['ticketcaisseligne_id'] = $idligne;
                                    $lignes['article_id'] = $ligne['produit'];
                                    $lignes['prixunite'] = $artprix[$i];
                                    $lignes['qteparlot'] = $artqte[$i];
                                    $lignes['qtecmd'] = $artcmd[$i];

                                    $lignes['montant'] = $artprix[$i] * $artqte[$i] * $artcmd[$i];


                                    $this->Ticketcaisselignepromo->create();
                                    $this->Ticketcaisselignepromo->save($lignes);
                                }
                            }



                            
                            
                            $qte_sorti = $ligne['qte'];
                            while ($qte_sorti > 0) {
                                $stckdepot = $this->Stockdepot->find('first', array(
                                    'conditions' => array('Stockdepot.article_id' => $ligne['produit'],
                                        'Stockdepot.depot_id' => $depot_id, 'Stockdepot.quantite >' => 0), false));
                                //debug($stckdepot);
                                if ($qte_sorti < $stckdepot['Stockdepot']['quantite']) {
                                    $qte = $stckdepot['Stockdepot']['quantite'] - $qte_sorti;
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => $qte), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    $this->loadModel('Stockdepotfacture');
                                    $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                    $tab['id_ticket'] = $id;
                                    $tab['piece'] = "TicketCaisse";
                                    $tab['qte'] = $qte_sorti;
                                    $tab['id_ticketligne'] = $idligne;
                                    $this->Stockdepotfacture->create();
                                    $this->Stockdepotfacture->save($tab);
                                    $qte_sorti = 0;
                                } else {
                                    $this->Stockdepot->updateAll(array('Stockdepot.quantite' => 0), array('Stockdepot.id' => $stckdepot['Stockdepot']['id']));
                                    $qte_sorti = $qte_sorti - $stckdepot['Stockdepot']['quantite'];
                                    $this->loadModel('Stockdepotfacture');
                                    $tab['stockdepot_id'] = $stckdepot['Stockdepot']['id'];
                                    $tab['id_ticket'] = $id;
                                    $tab['piece'] = "TicketCaisse";
                                    $tab['id_ticketligne'] = $idligne;
                                    $tab['qte'] = $stckdepot['Stockdepot']['quantite'];
                                    $this->Stockdepotfacture->create();
                                    $this->Stockdepotfacture->save($tab);
                                }
                            }
                            
                            
                            
                        }
                    }//die;
                }
                $this->Ticketcaiss->updateAll(array('Ticketcaiss.point' => $point), array('Ticketcaiss.id' => $id));
                //	debug($point);die;	
                //----------------- enregistrement piece reglement  
                //$this->Session->setFlash(__('The ticketcaiss has been saved'));
?>
                <?php if($enattente==0){ ?>
                <script language="javascript" >     
                    document.location='<?php echo $this->webroot; ?>ticketcaisses/reg/<?php echo $id; ?>';
                    //document.location='<?php echo $this->webroot; ?>Ticketcaisses/add';
                </script>
                <?php } ?>
                <?php if($enattente==1){ ?>
                <script language="javascript" >     
                    document.location='<?php echo $this->webroot; ?>ticketcaisses/add';
                </script>
                <?php } ?>
                
                
                <?php
                // $this->redirect(array('action' => 'add'));
            } else {
                $this->Session->setFlash(__('The ticketcaiss could not be saved. Please, try again.'));
            }
        }
        
            else {
			$options = array('conditions' => array('Ticketcaiss.' . $this->Ticketcaiss->primaryKey => $id),'recursive'=>-1);
			$this->request->data = $this->Ticketcaiss->find('first', $options);
		}
       
		$clients = $this->Ticketcaiss->Client->find('list');
                $codes = $this->Ticketcaiss->Client->find('list', array('recursive' => -1, 'fields' => array('Client.id', 'Client.Code')));
		$depots = $this->Ticketcaiss->Depot->find('list');
		$utilisateurs = $this->Ticketcaiss->Utilisateur->find('list');
                $modes = $this->Paiement->find('all', array('recursive' => -1, 'conditions' => array("OR" => array(
                    "Paiement.id" => array("1", "2", "15", "14")))));
                $articles = $this->Article->find('list',array('fields'=>array('Article.id','Article.name')));
                $listdesignations = $this->Article->find('list',array('fields'=>'Article.desig_list'));
		$ligneticketcaiss=$this->Ticketcaisseligne->find('all',array('conditions'=>array('Ticketcaisseligne.ticketcaisse_id'=>$id)));
                //debug($articles);die;
		$this->set(compact('ip','com','ligneticketcaiss','fond','codes','clients','articles','listdesignations', 'depots', 'utilisateurs','mm','modes','banques'));
	}
        
        
        
        
	public function reg($id = null) {
        $Caisse = $this->Cookie->read('Caisse');
        $user = $this->Cookie->read('users');
        $pointv = $this->Cookie->read('point');
        $this->Cookie->write('Caisse', $Caisse, false, '24 hour');
        $this->Cookie->write('point', $pointv, false, '24 hour');
        $this->Cookie->write('users', $user, false, '24 hour');

        /*  if ( $Caisse <> "Caisse"){
          $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
          } */



        $this->loadModel('Ticketcaisseligne');
        $this->loadModel('Paiementcaisse');
        $this->loadModel('Reglementcaisse');
        $this->loadModel('Piecereglementcaisse');
        $this->loadModel('Ticket');
        $this->loadModel('Depot');
        $this->loadModel('Article');
        $this->loadModel('Stockdepot');
        $this->loadModel('Ticketcaisselignepromo');
        $this->loadModel('Ip');


        //$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        //$ip = $this->Ip->find('all', array('recursive' => 0, 'conditions' => array( 'OR'=>array( 'Ip.host' => $hostname, 'Ip.ip' => $hostname))));
        // CakeSession::write('com',@$ip[0]['Ip']['com']);
        // CakeSession::write('ip',@$ip[0]['Ip']['ip']);


        if ($this->request->is('post')) {

            //debug($this->request->data);die;

            //debug($this->request->data);die;
            $date2 = date('Y-m-d H:i:s');

            $depot_id = $this->Cookie->read('dpo');
            $journee_id = $this->Cookie->read('journee');
            $this->Cookie->write('dpo', $depot_id, false, '24 hour');
            $this->Cookie->write('journee', $journee_id, false, '24 hour');

            $this->request->data['Ticketcaisse']['Date'] = $date2;
            //$this->request->data['Ticketcaiss']['Type'] = 1;
            $this->request->data['Ticketcaisse']['utilisateur_id'] = $this->Cookie->read('users');
            $this->request->data['Ticketcaisse']['personnel_id'] = $this->Cookie->read('personnel_id');
            $this->request->data['Ticketcaisse']['pointvente_id'] = $this->Cookie->read('point');
            $this->request->data['Ticketcaisse']['depot_id'] = $this->Cookie->read('point');
            $cartefidelite_id = $this->request->data['Ticketcaisse']['cartefidelite_id'];
            $point = $this->request->data['Ticketcaisse']['point'];

            //----------------- enregistrement piece reglement  
            $l = explode('-', $id);
            $journee_id = $l[0];
            $numero = $this->Reglementcaisse->find('all', array('recursive' => -1, 'fields' =>
                array(
                    'MAX(Reglementcaisse.n) as num'
                ), 'conditions' => array('Reglementcaisse.journee_id' => $journee_id)));
            foreach ($numero as $num) {
                $n = $num[0]['num'];

                if (!empty($n)) {
                    $lastnum = $n;
                    $nume = intval($lastnum) + 1;
                    $mm = $nume;
                } else {
                    $mm = "1";
                }
            }

            $idreg = $id . '-' . $mm;

            if (isset($this->request->data['Ticketcaisse']['Montant_Payer']) && !empty($this->request->data['Ticketcaisse']['Montant_Payer'])) {
                $this->request->data['Reglementcaisse']['Date'] = date('Y-m-d');
                $this->request->data['Reglementcaisse']['id'] = $idreg;
                $this->request->data['Reglementcaisse']['n'] = $mm;

                $this->request->data['Reglementcaisse']['client_id'] = @$this->request->data['Ticketcaisse']['client_id'];
                $this->request->data['Reglementcaisse']['Montant'] = $this->request->data['Ticketcaisse']['Montant_Payer'];
                $this->request->data['Reglementcaisse']['utilisateur_id'] = $this->Cookie->read('users');
                $this->request->data['Reglementcaisse']['pointvente_id'] = $this->Cookie->read('point');
                $this->request->data['Reglementcaisse']['journee_id'] = $journee_id;
                $mont_acompte = $this->request->data['Ticketcaisse']['Montant_Payer'];
                $Rest = $this->request->data['Ticketcaisse']['Rest'];
                $this->Reglementcaisse->create();
                $this->Reglementcaisse->save($this->request->data['Reglementcaisse']);

                $id_acompte = $idreg;
                
                // debug($this->request->data['Ticketcaisse']['mode_id']); die;
                if (isset($this->request->data['Ticketcaisse']['mode_id'])) {

                    foreach ($this->request->data['Ticketcaisse']['mode_id'] as $acompte) {
                        $reg = array();
                        // debug($acompte);die;
                        $ac['reglementcaisse_id'] = $id_acompte;
                        $ac['paiementcaisse_id'] = $acompte;
                        $id_piece = 0;

                        if ($acompte == 14) {
                            $ac['num'] = $this->request->data['Ticketcaisse']['piecec'];
                            $ac['Montant'] = $this->request->data['Ticketcaisse']['Montant_Piecec'];
                        }

                        if ($acompte == 15) {
                            $ac['Montant'] = $this->request->data['Ticketcaisse']['Montant_Ticket'];
                        }

                        // $ac['Montant'] = $this->request->data['Ticketcaisse']['Montant_Ticket'];

                        if ($acompte == 1) {
                            $ac['Montant'] = $this->request->data['Ticketcaisse']['Montant'];
                        }

                        if ($acompte == 2) {
                            $ac['Montant'] = $this->request->data['Ticketcaisse']['Montant_Piece'];

//                            $this->request->data['Cheque']['Montant'] = $ac['Montant'];
//                            $this->request->data['Cheque']['Echeance'] = date('Y-m-d');
//                            $this->request->data['Cheque']['Numero'] = $this->request->data['Ticketcaisse']['piece'];
//                            $this->request->data['Cheque']['utilisateur_id'] = $this->Cookie->read('users');
//                            $this->request->data['Cheque']['pointvente_id'] = $this->Cookie->read('point');
//                            $this->Cheque->create();
//                            $this->Cheque->save($this->request->data['Cheque']);
//                            $id_piece = $this->Cheque->id;
                        }

                        $ac['piece_id'] = $id_piece;

                        $numerop = $this->Piecereglementcaisse->find('all', array('recursive' => -1, 'fields' =>
                            array(
                                'MAX(Piecereglementcaisse.n) as num'
                            ), 'conditions' => array('Piecereglementcaisse.reglementcaisse_id' => $id_acompte)));
                        foreach ($numerop as $num) {
                            $n = $num[0]['num'];

                            if (!empty($n)) {
                                $lastnum = $n;
                                $nume = intval($lastnum) + 1;
                                $mmrp = $nume;
                            } else {
                                $mmrp = "1";
                            }
                        }
                        $ac['id'] = $id_acompte . '-' . $mmrp;
                        $ac['n'] = $mmrp;

                        $this->Piecereglementcaisse->create();
                        $this->Piecereglementcaisse->saveAll($ac);
                        $id_ligne = $ac['id'];

                        if ($acompte == 15) {
                            $ac['Montant'] = $this->request->data['Ticketcaisse']['Montant_Ticket'];
                            foreach ($this->request->data['Detailticket'] as $tick) {
                                $this->request->data['Ticket']['Prix_Ticket'] = $tick['Prix_Ticket'];
                                $this->request->data['Ticket']['Nombre_Ticket'] = $tick['Nombre_Ticket'];
                                $this->request->data['Ticket']['piecereglementcaisse_id'] = $id_ligne;

                                if ($this->request->data['Ticket']['Prix_Ticket'] != '') {
                                    $this->Ticket->create();
                                    $this->Ticket->save($this->request->data['Ticket']);
                                }
                            }
                        }

                        /*
                          $reg['reglement_id']=$id_acompte;
                          $reg['id_piece']=$id;
                          $reg['type']='ticket';
                          $reg['Montant']=$acompte['Montant'];
                          $this->Lignereglement->create();
                          $this->Lignereglement->save($reg);

                          $this->Piecereglement->updateAll(array('Piecereglement.id_piece' => "$id_piece"), array('Piecereglement.id' => $id_ligne)); */

                        $this->Ticketcaiss->updateAll(array('Ticketcaiss.cartefidelite_id' => "'" . $cartefidelite_id . "'", 'Ticketcaiss.reglementcaisse_id' => "'" . $id_acompte . "'", 'Ticketcaiss.Rest' => "$Rest", 'Ticketcaiss.Montant_Payer' => "$mont_acompte"), array('Ticketcaiss.id' => $id));
                        $this->loadModel('Cartefidelite');

///debug($id_acompte); die;
                        $this->Cartefidelite->updateAll(array('Cartefidelite.cumul' => 'Cartefidelite.cumul+' . $point), array('Cartefidelite.id' => $cartefidelite_id));
                    }
                }
            }



            //	$this->Session->setFlash(__('The ticketcaiss has been saved'));
                ?>
                             <script language="javascript" >     
            				  window.open('<?php echo $this->webroot; ?>ticketcaisses/imp/<?php echo $id; ?>', 'my div', 'height=400,width=600');
            				 document.location='<?php echo $this->webroot; ?>Ticketcaisses/add';
            				
            </script>
            <?php
            // $this->redirect(array('action' => 'add'));
        } else {
            //	$this->Session->setFlash(__('The ticketcaiss could not be saved. Please, try again.'));
        }

        $numero = $this->Ticketcaiss->find('all', array('fields' =>
            array(
                'MAX(Ticketcaiss.Numero) as num'
            ), 'recursive' => -1));
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
        $clients = $this->Ticketcaiss->Client->find('list');
        $codes = $this->Ticketcaiss->Client->find('list', array('recursive' => -1, 'fields' => array('Client.id', 'Client.Code')));
        $depots = $this->Ticketcaiss->Depot->find('list');
        $utilisateurs = $this->Ticketcaiss->Utilisateur->find('list');
        $modes = $this->Paiementcaisse->find('all', array('recursive' => -1, 'conditions' => array("OR" => array(
                    "Paiementcaisse.id" => array("1", "2", "15", "14", "16")))));
        $articles = $this->Article->find('list', array('fields' => array('Article.code', 'Article.name')));
        $listdesignations = $this->Article->find('list', array('fields' => 'Article.desig_list'));
        $tick = $this->Ticketcaiss->find('all', array('conditions' => array('Ticketcaiss.id' => $id)));

        $Total_TTC = $tick[0]['Ticketcaiss']['Total_TTC'];
        $point = $tick[0]['Ticketcaiss']['point'];
        $fond = $this->Cookie->read('Fond');
        $ip = $this->Cookie->read('ip');
        $com = $this->Cookie->read('com');



        $this->set(compact('point', 'ip', 'com', 'fond', 'Total_TTC', 'codes', 'clients', 'articles', 'listdesignations', 'depots', 'utilisateurs', 'mm', 'modes', 'banques'));
    }

    public function host(){$this->Cookie->delete('com');$this->Cookie->delete('ip');
		$this->layout=null;
		$this->loadModel('Ip');
		$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	    $ip = $this->Ip->find('all', array('recursive' => 0, 'conditions' => array( 'OR'=>array( 'Ip.host' => $hostname, 'Ip.ip' => $hostname))));
			
 
   $abc=array();
                        $abc[0]=$ip[0]['Ip']['com'];    
                        $abc[1]=$ip[0]['Ip']['ip']; 
                        echo json_encode($abc);
						
						
			 $this->Cookie->write('com',@$ip[0]['Ip']['com'],false,'24 hour');
			 $this->Cookie->write('ip',@$ip[0]['Ip']['ip'],false,'24 hour');
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
        
        
         public function selectart($codearta = null, $balance = null) {
        $this->layout = null;
        $this->loadModel('Famille');
        $this->loadModel('Article');
        $this->loadModel('Promotion');
        
            $Code = $codearta;
            $date=date('Y-m-d');
            $composantid = 0;
            $Designation = '';
            $array = $this->Article->find('first', array('conditions' => array('Article.code' => $Code, 'Article.prixuttc!=0.000'), 'recursive' => -1));
            $count = $this->Article->find('count', array('conditions' => array('Article.code' => $Code, 'Article.prixuttc!=0.000'), 'recursive' => -1));
            //debug($array);debug($date);
            $countpromo = $this->Promotion->find('count', array('conditions' => array(
                'Promotion.article_id' => $array['Article']['id']
                ,'Promotion.datedebut <='."'".$date."'"
                ,'Promotion.datefin >='."'".$date."'"
                ), 'recursive' => -1));
            //debug($countpromo);die;

//24 09011 00012
        //24 00003 00,465 0
        $qte = 1;

            $prixttc = $array['Article']['prixuttc'];


        $this->set(compact('array', 'count', 'composantid', 'bal','countpromo', 'codeart', 'prixttc', 'qte')); //envoie json par echo pas par $this->set(compact())
    }

    
    
    
    
    public function promotion($Code = null, $index = null) {
            $this->layout = 'defaultnu';
            $this->loadModel('Promotion');
            $this->loadModel('Article');
            $date=date('Y-m-d');
            $array = $this->Promotion->find('all', array('conditions' => array('Promotion.article_id' => $Code,'Promotion.datedebut <='."'".$date."'"
                ,'Promotion.datefin >='."'".$date."'"),'contain'=>array('Article'), 'recursive' => 0));
            $Article = $this->Article->find('all', array('conditions' => array('Article.id' => $Code), 'recursive' => -1));


            $this->set(compact('array', 'Article', 'index')); //envoie json par echo pas par $this->set(compact())
        }
        
        public function recap() {  
            $this->loadModel('Ticketcaisseligne');
            $this->layout = null;
            //print_r($this->request->data);die;
            $id=$this->request->data['ticket_repr'];
            $lignes=$this->Ticketcaisseligne->find('all',array('conditions'=>array('Ticketcaisseligne.ticketcaisse_id'=>$id),'recursive'=>0));
            $count=$this->Ticketcaisseligne->find('count',array('conditions'=>array('Ticketcaisseligne.ticketcaisse_id'=>$id)));
            // print_r($lignes);die;
            $this->set(compact('lignes','count'));
	}
        

}