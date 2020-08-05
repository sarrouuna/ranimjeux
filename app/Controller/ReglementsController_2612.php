<?php

App::uses('AppController', 'Controller');

/**
 * Reglements Controller
 *
 * @property Reglement $Reglement
 */
class ReglementsController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglements') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Famille');
        $this->loadModel('Client');
        $this->loadModel('Fournisseur');
        $this->loadModel('Piecereglement');
        $this->loadModel('Ligneclient');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $pointdeventes = $this->Pointdevente->find('list');
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $conde = 'Reglement.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        $soc = CakeSession::read('soc');
        if ($p > 0) {
            $pv = 'Reglement.pointdevente_id = ' . $p;
        }
//		$familles = $this->Famille->find('list');
        $fournisseurs = $this->Fournisseur->find('list');
        $cond = 'Reglement.Date>=' . "'" . date('Y-m-d') . "'";
         $cond1 = 'Reglement.Date<=' . "'" . date('Y-m-d') . "'";
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Reglements"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Recherche']);
            } else {
                $this->request->data['Recherche'] = CakeSession::read('recherche');
            }
            $cond = '';
            $cond1 = '';
            $cond2 = '';
            $cond3 = '';
            $cond4 = '';
            $cond6 = '';
            $cond7 = '';

            if ($this->request->data['Recherche']['exercice_id']) {
                $exerciceid = $this->request->data['Recherche']['exercice_id'];
                $conde = 'Reglement.exercice_id =' . $exercices[$exerciceid];
            }

            if ($this->request->data['Recherche']['Date_debut'] != '__/__/____') {
                $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['Date_debut'])));
                $cond = 'Reglement.Date>=' . "'" . $Date_debut . "'";
                $conde = '';
            }


            if ($this->request->data['Recherche']['Date_fin'] != '__/__/____') {
                $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Recherche']['Date_fin'])));
                $cond1 = 'Reglement.Date<=' . "'" . $Date_fin . "'";
                $conde = '';
            }


            if ($this->request->data['Recherche']['fournisseur_id']) {
                $fournisseur_id = $this->request->data['Recherche']['fournisseur_id'];
                $cond3 = 'Reglement.fournisseur_id=' . $fournisseur_id;
            }
            $this->loadModel('Utilisateur');
            $this->loadModel('Pointdevente');
            $this->loadModel('Societe');
            $this->loadModel('Personnel');
            if ($this->request->data['Recherche']['societe_id']) {
                $societe_id = $this->request->data['Recherche']['societe_id'];
                $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
                $ch_pv = 0;
                foreach ($lespvs as $lespv) {
                    $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
                }
                $cond6 = 'Reglement.pointdevente_id in (' . $ch_pv . ')';
                $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array('Pointdevente.societe_id' => $societe_id)));
            }


            if ($this->request->data['Recherche']['pointdevente_id']) {
                $pointdevente_id = $this->request->data['Recherche']['pointdevente_id'];
                $cond7 = 'Reglement.pointdevente_id =' . $pointdevente_id;
            }
        }

        $reglementfournisseurs = $this->Reglement->find('all', array('conditions' => array(@$pv, @$conde, @$cond, @$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7)));
//              $this->Reglement->recursive = 2;
//              $this->paginate = array(
//              'order' => array('Reglement.id' => 'desc'),
//              'conditions' => array(@$pv,@$conde,$cond,$cond1,$cond2,$cond3,$cond4));     
//              $reglementfournisseurs= $this->paginate();

        $societes = $this->Societe->find('list', array('conditions' => array('Societe.id in (' . $soc . ')')));
        $this->set(compact('exerciceid', 'exercices', 'societes', 'pointdeventes', 'pointdevente_id', 'societe_id', 'reglementfournisseurs', 'collections', 'transferecommandebls', 'marques', 'familles', 'fournisseurs', 'ligneclients', 'marque_id', 'Date_debut', 'Date_fin', 'fournisseur_id', 'num_recu'));


//        else{
//		$this->Reglement->recursive = 1;
//		$reglementfournisseurs= $this->paginate();
//                
//                 $this->set(compact('reglementfournisseurs','collections','transferecommandebls','marques','familles','fournisseurs','ligneclients','Date_debut','marque_id','Date_fin','fournisseur_id','num_recu' ));
//	
//        }
    }

    public function imprimerrecherche() {
        $lien = CakeSession::read('lien_achat');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglements') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

//               $this->loadModel('Marque'); 
//              $this->loadModel('Famille'); 
        $this->loadModel('Fournisseur');
        $this->loadModel('Piecereglement');
        $this->loadModel('Ligneclient');
        // debug($this->request->query);die;
        $cond = '';
        $cond1 = '';
        $cond2 = '';
        $cond3 = '';
        $cond4 = '';
        $cond6 = '';
        $cond7 = '';
        if (!empty($this->request->query['Date_debut'])) {
            $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_debut'])));
            $cond = 'Reglement.Date>=' . "'" . $Date_debut . "'";
        }
        if (!empty($this->request->query['Date_fin'])) {
            $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_fin'])));
            $cond1 = 'Reglement.Date<=' . "'" . $Date_fin . "'";
        }

        if (!empty($this->request->query['fournisseur_id'])) {
            $fournisseur_id = $this->request->query['fournisseur_id'];
            $cond3 = 'Reglement.fournisseur_id=' . $fournisseur_id;
        }

        $this->loadModel('Utilisateur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $this->loadModel('Personnel');
        if ($this->request->query['societe_id']) {
            $societe_id = $this->request->query['societe_id'];
            $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
            $ch_pv = 0;
            foreach ($lespvs as $lespv) {
                $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
            }
            $cond6 = 'Reglement.pointdevente_id in (' . $ch_pv . ')';
        }

        if ($this->request->query['pointdevente_id']) {
            $pointdevente_id = $this->request->query['pointdevente_id'];
            $cond7 = 'Reglement.pointdevente_id =' . $pointdevente_id;
        }


        $this->Reglement->recursive = 2;
        $this->paginate = array(
            'order' => array('Reglement.id' => 'desc'),
            'conditions' => array($cond, $cond1, $cond2, $cond3, $cond4, $cond6, $cond7));
        $reglements = $this->paginate();


        $this->set(compact('reglements', 'collections', 'transferecommandebls', 'marques', 'familles', 'fournisseurs', 'ligneclients', 'marque_id', 'Date_debut', 'Date_fin', 'fournisseur_id', 'num_recu'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_achat');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglements') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Piecereglement');
        $this->loadModel('Traitecredit');
        if (!$this->Reglement->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $options = array('conditions' => array('Reglement.' . $this->Reglement->primaryKey => $id), 'recursive' => 2);
        $reglement = $this->Reglement->find('first', $options);
        $pieceregement = $this->Piecereglement->find('all', array('conditions' => array('Piecereglement.reglement_id' => $id)));
        //debug($pieceregement);die;
        if ($pieceregement[0]['Piecereglement']['paiement_id'] == 7) {
            $credit = $this->Traitecredit->find('all', array('conditions' => array('Traitecredit.piecereglement_id' => $pieceregement[0]['Piecereglement']['id']), 'recursive' => 0));
        }
        $this->set(compact('credit', 'reglement', 'pieceregement'));
    }

    public function imprimerview($id = null) {
        $lien = CakeSession::read('lien_achat');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglements') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Piecereglement');
        $this->loadModel('Traitecredit');
        if (!$this->Reglement->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $options = array('conditions' => array('Reglement.' . $this->Reglement->primaryKey => $id), 'recursive' => 2);
        $reglement = $this->Reglement->find('first', $options);
        $pieceregement = $this->Piecereglement->find('all', array('conditions' => array('Piecereglement.reglement_id' => $id)));
        if ($pieceregement[0]['Piecereglement']['paiement_id'] == 7) {
            $credit = $this->Traitecredit->find('all', array('conditions' => array('Traitecredit.piecereglement_id' => $pieceregement[0]['Piecereglement']['id']), 'recursive' => 0));
        }
        $this->set(compact('credit', 'reglement', 'pieceregement'));
    }

    public function add($fournisseur_id = 0) {
        $lien = CakeSession::read('lien_achat');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglements') {
                    $vente = $liens['add'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Facture');
        $this->loadModel('Paiement');
        $this->loadModel('Carnetcheque');
        $this->loadModel('Cheque');
        $this->loadModel('Lignereglement');
        $this->loadModel('Piecereglement');
        $this->loadModel('Compte');
        $this->loadModel('To');
        $this->loadModel('Traitecredit');
        $this->loadModel('Fournisseur');
        $this->loadModel('Importation');
        $this->loadModel('Variationtauxdechange');
        $this->loadModel('Etatpiecereglement');
        $this->loadModel('Situationpiecereglement');

        if ($this->request->is('post')) {

//             debug($this->request->data);die;
            $fournisseur_id = $this->request->data['Reglement']['fournisseur_id'];
            $this->request->data['Reglement']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglement']['Date'])));
            $this->request->data['Reglement']['utilisateur_id'] = CakeSession::read('users');
            $this->request->data['Reglement']['exercice_id'] = date("Y");
            $devisefournisseurs = $this->request->data['Reglement']['devisefournisseur'];
            if (empty($this->request->data['Reglement']['pointdevente_id'])) {
                $this->request->data['Reglement']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            //debug($devisefournisseurs);
            if (!empty($this->request->data['Reglement']['importation_id'])) {
                $importation_id = $this->request->data['Reglement']['importation_id'];
            } else {
                $importation_id = 0;
            }
            $numero = $this->Reglement->find('all', array('fields' => array('MAX(Reglement.numeroconca) as num')
                , 'conditions' => array('Reglement.exercice_id' => date("Y"))));
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//                        $getexercice= $this->Reglement->find('first',array('conditions'=>array('Reglement.numeroconca'=>$n)));
//                        $anne=$getexercice['Reglement']['exercice_id'];  
//                        if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//                        }
//                        else {
//                        $mm = "000001";
//                        }  
            } else {
                $mm = "000001";
            }
            $this->request->data['Reglement']['numeroconca'] = $mm;
            $this->Reglement->create();
            //debug($this->request->data);die;
            if ($this->Reglement->save($this->request->data)) {
                $reg_id = $this->Reglement->id;
                $this->misejour("Reglement", "add", $reg_id);
                $mntt = $this->request->data['Reglement']['Montant'];
                if (!empty($this->request->data['Lignereglement'])) {
                    foreach ($this->request->data['Lignereglement']as $j => $l) {
                        if ((!empty($l['facture_id']))) {
                            $importation_id = $l['importation_id'];
                            if ($mntt > 0) {
                                $li['reglement_id'] = $reg_id;
                                $li['facture_id'] = $l['facture_id'];
                                $id_fac = $l['facture_id'];
                                $li['tauxchange'] = @$l['tauxchange'];
                                $facture = $this->Facture->find('all', array('conditions' => array('Facture.id' => $id_fac), 'recursive' => -1));
                                //debug($facture);
                                $tc = 1;
                                if ($devisefournisseurs == 1) {
                                    $mntfac = $facture[0]['Facture']['totalttc'] - $facture[0]['Facture']['Montant_Regler'];
                                    if ($mntt >= $mntfac) {
                                        $li['Montant'] = $mntfac;
                                        $mntt = $mntt - $mntfac;
                                        $mnr = $mntfac;
                                    } else {
                                        $li['Montant'] = $mntt;
                                        $mnr = $mntt;
                                        $mntt = 0;
                                    }
                                    $mantant_reglet = $facture[0]['Facture']['Montant_Regler'] + $mnr;
                                } else {
                                    $importation = $this->Importation->find('first', array('conditions' => array('Importation.id' => $importation_id), 'recursive' => -1));
                                    $mntfac = ($facture[0]['Facture']['totalttc'] / $importation['Importation']['coefficien']) - ($facture[0]['Facture']['Montant_Regler'] * ($facture[0]['Facture']['tauxchange']));
                                    $mnttdevise = $this->request->data['Reglement']['Montant'] / ($li['tauxchange']);
                                    //debug($mntt); 
                                    //debug($mntfac);
                                    if ($mntt > $mntfac) {
                                        $li['Montant'] = $mntfac;
                                        $mntt = $mntt - $mntfac;
                                        $mnr = ($mntfac / $importation['Importation']['tauxderechenge']);
                                        //debug("mon>monfac".$mnr);
                                        $tc = $li['tauxchange'];
                                        $variationtauxdechange = $this->Variationtauxdechange->find('first', array('conditions' => array('Variationtauxdechange.importation_id' => $importation_id), 'recursive' => -1));
                                        if (!empty($variationtauxdechange)) {
                                            $credit['id'] = $variationtauxdechange['Variationtauxdechange']['id'];
                                        }
                                        $credit['reglement_id'] = $reg_id;
                                        $credit['fournisseur_id'] = $this->request->data['Reglement']['fournisseur_id'];
                                        $credit['importation_id'] = $importation_id;
                                        $credit['date'] = date("Y-m-d");
                                        $credit['montant'] = $mntt;
                                        $credit['type'] = "Perte";
                                        $this->Variationtauxdechange->create();
                                        $this->Variationtauxdechange->save($credit);
                                    } else {
                                        $mt = $mntfac - $mntt;
                                        $li['Montant'] = $mntt;
                                        $mnr = ($mntt / ($li['tauxchange']));
                                        //debug("mon<monfac".$mnr);
                                        $tc = $li['tauxchange'];
                                        $mntt = 0;
                                        $variationtauxdechange = $this->Variationtauxdechange->find('first', array('conditions' => array('Variationtauxdechange.importation_id' => $importation_id), 'recursive' => -1));
                                        if (!empty($variationtauxdechange)) {
                                            $credit['id'] = $variationtauxdechange['Variationtauxdechange']['id'];
                                        }
                                        $credit['reglement_id'] = $reg_id;
                                        $credit['fournisseur_id'] = $this->request->data['Reglement']['fournisseur_id'];
                                        $credit['importation_id'] = $importation_id;
                                        $credit['date'] = date("Y-m-d");
                                        $credit['montant'] = $mt;
                                        $credit['type'] = "Gain";
                                        $this->Variationtauxdechange->create();
                                        $this->Variationtauxdechange->save($credit);
                                    }
                                    $mantant_reglet = sprintf('%.3f', $facture[0]['Facture']['Montant_Regler'] + ($mnr));
                                }


                                //debug($mantant_reglet);die;
                                $this->Facture->updateAll(array('Facture.Montant_Regler ' => $mantant_reglet, 'Facture.tauxchange ' => $tc, 'Facture.etat' => 1), array('Facture.id' => $id_fac));
                                $this->Lignereglement->create();
                                $this->Lignereglement->save($li);
                            }
                        }
                    }
                }
                if (!empty($this->request->data['pieceregelemnt'])) {
                    foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                        if ($l['sup'] != 1) {
                            $lip['montant'] = $l['montant'];
                            $lip['paiement_id'] = $l['paiement_id'];
                            $lip['reglement_id'] = $reg_id;
                            $lip['echance'] = '';
                            $lip['compte_id'] = '';
                            $lip['montant_brut'] = '';
                            $lip['montant_net'] = '';
                            $lip['carnetcheque_id'] = '';
                            $lip['cheque_id'] = '';
                            $lip['to_id'] = '';
                            if (!empty($l['montantdevise'])) {
                                $md = $l['montantdevise'];
                            } else {
                                $md = 0;
                            }
                            if ($l['paiement_id'] != 1) {
                                $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                                $lip['num'] = $l['num_piece'];
                                $lip['compte_id'] = $l['compte_id'];
                            }
                            if ($l['paiement_id'] == 5) {
                                $lip['compte_id'] = '';
                                $lip['echance'] = '';
                                $lip['num'] = $l['num_piece'];
                                $lip['montant_brut'] = $l['montantbrut'];
                                $lip['montant_net'] = $l['montantnet'];
                                $lip['to_id'] = $l['taux'];
                            }
                            if ($l['paiement_id'] == 2) {
                                $carnetcheque = $this->Carnetcheque->find('first', array('conditions' => array('Carnetcheque.id' => $l['carnetcheque_id']), false));
                                $cheque = $this->Cheque->find('first', array('conditions' => array('Cheque.id' => $l['cheque_id']), false));
                                $this->Cheque->updateAll(array('Cheque.etat' => 1), array('Cheque.id' => $l['cheque_id']));
                                $lip['carnetcheque_id'] = $l['carnetcheque_id'];
                                $lip['compte_id'] = $carnetcheque['Carnetcheque']['compte_id'];
                                $lip['cheque_id'] = $l['cheque_id'];
                                $lip['num'] = $cheque['Cheque']['numero'];
                            }
                            if ($l['paiement_id'] == 1) {
                                $lip['num'] = '';
                                $lip['compte_id'] = $l['compte_id'];
                            }
                            if ($l['paiement_id'] == 7) {
                                $lip['nbrmoins'] = $l['nbrmoins'];
                                //$lip['montantdevise']=$l['montantdevise'];
                                //$md=$l['montantdevise'];
                            }
                            $this->Piecereglement->create();
                            $this->Piecereglement->save($lip);
                            $piecereglement_id = $this->Piecereglement->id;
                            if (isset($l['regle_id'])) {
                                if ($l['regle_id'] == 2) {
                                    $this->Piecereglement->updateAll(array('Piecereglement.reglefournisseur' => 1, 'Piecereglement.montantfrs' => $l['montant']), array('Piecereglement.id' => $piecereglement_id));
                                }
                            }

                            if (!empty($this->request->data['Situation'][$j])) {
                                foreach ($this->request->data['Situation'][$j]['etatpieceregelemnt'] as $k => $etatpieceregelemnt) {
                                    if ($etatpieceregelemnt['supp'] != 1) {
                                        $data['piecereglement_id'] = $piecereglement_id;
                                        $data['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $etatpieceregelemnt['echancenf'])));
                                        ;
                                        //$data['agio']= $this->request->data['etatpieceregelemnt'][$j]['agio'];
                                        $data['etatpiecereglement_id'] = $etatpieceregelemnt['etatpiecereglement_id'];
                                        $data['utilisateur_id'] = CakeSession::read('users');
                                        $data['datemodification'] = date("Y-m-d");
                                        $data['nbrjour'] = $etatpieceregelemnt['nbrjour'];
                                        $data['montant'] = $etatpieceregelemnt['montant'];
                                        if (($data['etatpiecereglement_id'] == 7) || ($data['etatpiecereglement_id'] == 8)) {
                                            $nbr_jour_mois = "Sur " . $data['nbrjour'] . " Jours";
                                        } else {
                                            $nbr_jour_mois = " ";
                                        }

                                        $this->Situationpiecereglement->create();
                                        $this->Situationpiecereglement->save($data);
                                        if ($k == $this->request->data['contactchoisi'][$j]) {
                                            $etatpiecereglement = $this->Etatpiecereglement->find('first', array('conditions' => array('Etatpiecereglement.id' => $data['etatpiecereglement_id'])));
                                            $this->Piecereglement->updateAll(array('Piecereglement.situation' => '"' . $etatpiecereglement['Etatpiecereglement']['name'] . '"', 'Piecereglement.nbrmoins' => '"' . $nbr_jour_mois . '"', 'Piecereglement.etatpiecereglement_id' => $data['etatpiecereglement_id']), array('Piecereglement.id' => $piecereglement_id));
                                            if ($data['date'] != "1970-01-01") {
                                                $this->Piecereglement->updateAll(array('Piecereglement.echance' => '"' . $data['date'] . '"'), array('Piecereglement.id' => $piecereglement_id));
                                            }
                                        }
                                    }
                                }




//                            if(!empty($this->request->data['credits'][$j])){    
//                            foreach($this->request->data['credits'][$j]['traitecredits']as $t=>$credit){
//                            $credit['reglement_id']= $reg_id;
//                            $credit['piecereglement_id']= $piecereglement_id;
//                            $credit['fournisseur_id']=$this->request->data['Reglement']['fournisseur_id'];
//                            $credit['importation_id']=$importation_id;
//                            $credit['echancecredit']=date("Y-m-d",strtotime(str_replace('/','-',$credit['echancecredit']))); 
//                            $this->Traitecredit->create();
//                            $this->Traitecredit->save($credit);
//                            $credit['id']=$this->Traitecredit->id;    
//                            //$piece['reglement_id']= $reg_id;
//                            $piece['paiement_id']=7;
//                            $piece['montant']=$credit['montantcredit'];
//                            $piece['date']=date("Y-m-d");
//                            $piece['num']=$credit['num_piececredit'];
//                            $piece['echance']=date("Y-m-d",strtotime(str_replace('/','-',$credit['echancecredit'])));
//                            $piece['compte_id']=$l['compte_id'];
//                            $piece['situation']="En attente";
//                            $piece['etatpiecereglement_id']=1;
//                            $piece['traitecredit_id']=$credit['id'];
//                            $this->Piecereglement->create();
//                            $this->Piecereglement->save($piece);
//                            
//                            }
//                            }
                            }
                        }
                    }

                    $this->Piecereglement->updateAll(array('Piecereglement.importation_id' => $importation_id), array('Piecereglement.id' => $piecereglement_id));
                    $this->Reglement->updateAll(array('Reglement.importation_id' => $importation_id), array('Reglement.id' => $reg_id));
                    if ($importation_id != 0) {
                        //$this->Importation->updateAll(array('Importation.regler '=>1),array('Importation.id' => $importation_id));
                    }
                }

                $this->Session->setFlash(__('The reglement has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The reglement could not be saved. Please, try again.'));
            }
        }
        if (!empty($fournisseur_id)) {
            $valeurs = $this->To->find('list');
            $facture = array();

            $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $fournisseur_id)));
            $devisefournisseur = $fournisseur['Fournisseur']['devise_id'];
            $namefournisseur = $fournisseur['Fournisseur']['name'];
            $carnetcheques = $this->Carnetcheque->find('list', array('fields' => array('Carnetcheque.numero')));

            if ($devisefournisseur == 1) {
                $facture = $this->Facture->find('all', array('conditions' => array('Facture.fournisseur_id' => $fournisseur_id, 'Facture.totalttc>Facture.Montant_Regler'), 'recursive' => 0));
                //debug($facture);die;
            } else {
                $facture = $this->Facture->find('all', array('conditions' => array('Facture.fournisseur_id' => $fournisseur_id, 'Facture.totalttc>(Facture.Montant_Regler)', 'Facture.totaldevise>(Facture.Montant_Regler)'), 'recursive' => 0));
            }
            //debug($facture);die;
            if ($devisefournisseur == 1) {
                $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id in (1,2,3,4,5)')));
            } else {
                $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id in (4,6)')));
                $etatpiecereglements = $this->Etatpiecereglement->find('list', array('conditions' => array('Etatpiecereglement.id in (1,3,7,8,10,11,12,13)')));
            }
            $comptess = $this->Compte->find('all');
            foreach ($comptess as $c) {
                $comptes[$c['Compte']['id']] = $c['Compte']['banque'] . "  " . $c['Compte']['rib'];
            }
        }
        $fournisseurs = $this->Reglement->Fournisseur->find('list');
        $importations = $this->Importation->find('list', array('conditions' => array('Importation.fournisseur_id' => $fournisseur_id, 'Importation.regler' => 0)));
        $numero = $this->Reglement->find('all', array('fields' => array('MAX(Reglement.numeroconca) as num')
            , 'conditions' => array('Reglement.exercice_id' => date("Y"))));
        foreach ($numero as $num) {
            $n = $num[0]['num'];
        }
        if (!empty($n)) {
//                $getexercice= $this->Reglement->find('first',array('conditions'=>array('Reglement.numeroconca'=>$n)));
//                $anne=$getexercice['Reglement']['exercice_id'];  
//                if ($anne==date("Y")){
            $lastnum = $n;
            $nume = intval($lastnum) + 1;
            $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//                }
//                else {
//                $mm = "000001";
//                }  
        } else {
            $mm = "000001";
        }
        $regles[1] = "Non Reglé";
        $regles[2] = "Reglé";
        $this->loadModel('Depot');
        $this->loadModel('Pointdevente');

        $p = CakeSession::read('pointdevente');
        $societe = CakeSession::read('societe');
        if ($societe != 0) {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.societe_id' => $societe, 'Depot.typeetatarticle_id' => 1)));
        } else {
            $depots = $this->Depot->find('list', array('conditions' => array('Depot.typeetatarticle_id' => 1)));
        }
        $pointdeventes = $this->Pointdevente->find('list');
        $this->set(compact('depots', 'pointdeventes', 'p', 'regles', 'namefournisseur', 'etatpiecereglements', 'mm', 'importations', 'devisefournisseur', 'fournisseurs', 'fournisseur_id', 'facture', 'paiements', 'carnetcheques', 'valeurs', 'comptes'));
    }

    public function edit($id = null) {
        $lien = CakeSession::read('lien_achat');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglements') {
                    $vente = $liens['edit'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Facture');
        $this->loadModel('Paiement');
        $this->loadModel('Carnetcheque');
        $this->loadModel('Cheque');
        $this->loadModel('Lignereglement');
        $this->loadModel('Piecereglement');
        $this->loadModel('Facture');
        $this->loadModel('Compte');
        $this->loadModel('To');
        $this->loadModel('Traitecredit');
        $this->loadModel('Fournisseur');
        $this->loadModel('Importation');
        $this->loadModel('Variationtauxdechange');
        $this->loadModel('Etatpiecereglement');
        $this->loadModel('Situationpiecereglement');
        if (!$this->Reglement->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }



        if ($this->request->is('post') || $this->request->is('put')) {
//            debug($this->request->data);die;
            $devisefournisseurs = $this->request->data['Reglement']['devisefournisseur'];
            $this->request->data['Reglement']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglement']['Date'])));
            if (!empty($this->request->data['Reglement']['importation_id'])) {
                $importation_id = $this->request->data['Reglement']['importation_id'];
            } else {
                $importation_id = 0;
            }
            $piecefrs = $this->Piecereglement->find('all', array('conditions' => array('Piecereglement.reglement_id' => $id)));
            $reglerfrs = Array();
            foreach ($piecefrs as $k => $piece) {
                $reglerfrs[$k]['montantfrs'] = $piece['Piecereglement']['montantfrs'];
            }

            if ($this->Reglement->save($this->request->data)) {
                $this->misejour("Reglement", "edit", $id);




                //.....................................effacer  piece reglement , ligne reglement , ..........................................................................

                $cheqs = $this->Piecereglement->find('all', array('conditions' => array('Piecereglement.reglement_id' => $id, 'Piecereglement.paiement_id' => 2)));
                if (!empty($cheqs)) {
                    foreach ($cheqs as $k => $piece) {
                        $this->Cheque->updateAll(array('Cheque.etat' => 0), array('Cheque.id' => $piece['Piecereglement']['cheque_id']));
                    }
                }
                //$this->Piecereglement->deleteAll(array('Piecereglement.reglement_id' => $id), false);
                //$this->Traitecredit->deleteAll(array('Traitecredit.reglement_id' => $id), false);
                $lignesreg = $this->Lignereglement->find('all', array('conditions' => array('Lignereglement.reglement_id' => $id), 'recursive' => 0));  //debug($lignesreg);die;
                if (!empty($lignesreg)) {
                    foreach ($lignesreg as $k => $ligne) {
                        if ($ligne['Facture']['importation_id'] != 0) {
                            $importation = $this->Importation->find('first', array('conditions' => array('Importation.id' => $ligne['Facture']['importation_id']), 'recursive' => -1));
                            $this->Facture->updateAll(array('Facture.Montant_Regler' => 'Facture.Montant_Regler-' . $ligne['Lignereglement']['Montant'] / $importation['Importation']['tauxderechenge'], 'Facture.etat' => 0), array('Facture.id' => $ligne['Lignereglement']['facture_id']));
                        } else {
                            $this->Facture->updateAll(array('Facture.Montant_Regler' => 'Facture.Montant_Regler-' . $ligne['Lignereglement']['Montant'], 'Facture.etat' => 0), array('Facture.id' => $ligne['Lignereglement']['facture_id']));
                        }
                    }
                    $this->Lignereglement->deleteAll(array('Lignereglement.reglement_id' => $id), false);
                    $this->Variationtauxdechange->deleteAll(array('Variationtauxdechange.reglement_id' => $id), false);
                }
                //..............................fin effacer ligne reglement , piece reglement .............................................................................   
                //debug($this->request->data);                   
                $reg_id = $id;


                $mntt = $this->request->data['Reglement']['Montant'];
                if (!empty($this->request->data['Lignereglement'])) {
                    foreach ($this->request->data['Lignereglement']as $j => $l) {
                        if ((!empty($l['facture_id']))) {
                            $importation_id = $l['importation_id'];
                            if ($mntt > 0 && array_key_exists('facture_id', $l)) {
                                $li['reglement_id'] = $id;
                                $li['facture_id'] = $l['facture_id'];
                                $id_fac = $l['facture_id'];
                                $li['tauxchange'] = @$l['tauxchange'];
                                $facture = $this->Facture->find('all', array('conditions' => array('Facture.id' => $id_fac), 'recursive' => 0));
                                $tc = 1;
                                if ($devisefournisseurs == 1) {
                                    $mntfac = $facture[0]['Facture']['totalttc'] - $facture[0]['Facture']['Montant_Regler'];
                                    if ($mntt >= $mntfac) {
                                        $li['Montant'] = $mntfac;
                                        $mntt = $mntt - $mntfac;
                                        $mnr = $mntfac;
                                    } else {
                                        $li['Montant'] = $mntt;
                                        $mnr = $mntt;
                                        $mntt = 0;
                                    }
                                    $mantant_reglet = $facture[0]['Facture']['Montant_Regler'] + $mnr;
                                } else {
                                    $importation = $this->Importation->find('first', array('conditions' => array('Importation.id' => $importation_id), 'recursive' => -1));
                                    $mntfac = ($facture[0]['Facture']['totaldevise'] * $importation['Importation']['tauxderechenge']) - ($facture[0]['Facture']['Montant_Regler'] * ($facture[0]['Facture']['tauxchange']));
                                    $mnttdevise = $this->request->data['Reglement']['Montant'] / ($li['tauxchange']);
                                    //debug($mntt); 
                                    //debug($mntfac);
                                    if ($mntt > $mntfac) {
                                        $li['Montant'] = $mntfac;
                                        $mntt = $mntt - $mntfac;
                                        $mnr = ($mntfac / $importation['Importation']['tauxderechenge']);
                                        //debug("mon>monfac".$mnr);
                                        $tc = $li['tauxchange'];
                                        if ($mntt != 0) {
                                            $variationtauxdechange = $this->Variationtauxdechange->find('first', array('conditions' => array('Variationtauxdechange.importation_id' => $importation_id), 'recursive' => -1));
                                            if (!empty($variationtauxdechange)) {
                                                $credit['id'] = $variationtauxdechange['Variationtauxdechange']['id'];
                                            }
                                            $credit['reglement_id'] = $reg_id;
                                            $credit['fournisseur_id'] = $this->request->data['Reglement']['fournisseur_id'];
                                            $credit['importation_id'] = $importation_id;
                                            $credit['date'] = date("Y-m-d");
                                            $credit['montant'] = $mntt;
                                            $credit['type'] = "Perte";
                                            $this->Variationtauxdechange->create();
                                            $this->Variationtauxdechange->save($credit);
                                        }
                                    } else {
                                        $mt = $mntfac - $mntt;
                                        $li['Montant'] = $mntfac;
                                        $mnr = ($mntt / ($li['tauxchange']));
                                        //debug("mon<monfac".$mnr);
                                        $tc = $li['tauxchange'];
                                        $mntt = 0;
                                        if ($mt != 0) {
                                            $variationtauxdechange = $this->Variationtauxdechange->find('first', array('conditions' => array('Variationtauxdechange.importation_id' => $importation_id), 'recursive' => -1));
                                            if (!empty($variationtauxdechange)) {
                                                $credit['id'] = $variationtauxdechange['Variationtauxdechange']['id'];
                                            }
                                            $credit['reglement_id'] = $reg_id;
                                            $credit['fournisseur_id'] = $this->request->data['Reglement']['fournisseur_id'];
                                            $credit['importation_id'] = $importation_id;
                                            $credit['date'] = date("Y-m-d");
                                            $credit['montant'] = $mt;
                                            $credit['type'] = "Gain";
                                            $this->Variationtauxdechange->create();
                                            $this->Variationtauxdechange->save($credit);
                                        }
                                    }
                                    $mantant_reglet = sprintf('%.3f', $facture[0]['Facture']['Montant_Regler'] + ($mnr));
                                }


                                //debug($importation_id);
                                $this->Facture->updateAll(array('Facture.Montant_Regler ' => $mantant_reglet, 'Facture.tauxchange ' => $tc, 'Facture.etat' => 1), array('Facture.id' => $id_fac));
                                $this->Lignereglement->create();
                                $this->Lignereglement->save($li);
                            }
                        }
                    }
                }
                if (!empty($this->request->data['pieceregelemnt'])) {
                    foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                        if ($l['sup'] != 1) {
                            $lip = array();
                            if ((isset($l['id'])) && (!empty($l['id']))) {
                                $lip['id'] = $l['id'];
                            }
                            $lip['montant'] = $l['montant'];
                            $lip['paiement_id'] = $l['paiement_id'];
                            $lip['reglement_id'] = $id;
                            $lip['echance'] = '';
                            $lip['compte_id'] = '';
                            $lip['montant_brut'] = '';
                            $lip['montant_net'] = '';
                            $lip['carnetcheque_id'] = '';
                            $lip['cheque_id'] = '';
                            $lip['to_id'] = '';
                            if (!empty($l['montantdevise'])) {
                                $md = $l['montantdevise'];
                            } else {
                                $md = 0;
                            }
                            if (($l['paiement_id'] == 3) || ($l['paiement_id'] == 4) || ($l['paiement_id'] == 6)) {
                                $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                                $lip['num'] = $l['num_piece'];
                                $lip['compte_id'] = @$l['compte_id'];
                            }
                            if ($l['paiement_id'] == 5) { //debug($lip);die;
                                $lip['compte_id'] = '';
                                $lip['echance'] = '';
                                $lip['num'] = $l['num_piece'];
                                $lip['montant_brut'] = $l['montant_brut'];
                                $lip['montant_net'] = $l['montant_net'];
                                $lip['to_id'] = $l['taux'];
                            }
                            if ($l['paiement_id'] == 2) {
                                $carnetcheque = $this->Carnetcheque->find('first', array('conditions' => array('Carnetcheque.id' => $l['carnetcheque_id']), false));
                                $cheque = $this->Cheque->find('first', array('conditions' => array('Cheque.id' => $l['cheque_id']), false));
                                $this->Cheque->updateAll(array('Cheque.etat' => 1), array('Cheque.id' => $l['cheque_id']));
                                $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                                $lip['carnetcheque_id'] = $l['carnetcheque_id'];
                                $lip['compte_id'] = $carnetcheque['Carnetcheque']['compte_id'];
                                $lip['cheque_id'] = $l['cheque_id'];
                                $lip['num'] = $cheque['Cheque']['numero'];  //debug($lip);die; 
                            }
                            if ($l['paiement_id'] == 1) {
                                $lip['num'] = '';
                                $lip['compte_id'] = $l['compte_id'];
                            }
                            if ($l['paiement_id'] == 7) {
                                $lip['nbrmoins'] = $l['nbrmoins'];
                                //$lip['montantdevise']=$l['montantdevise'];
                                $lip['compte_id'] = $l['compte_id'];
                                //$md=$l['montantdevise'];
                            }
                            $this->Piecereglement->create();
                            $this->Piecereglement->save($lip);
                            $piecereglement_id = $this->Piecereglement->id;
                            if ((isset($l['regle_id'])) && (!empty($l['regle_id']))) {
                                if ($l['regle_id'] == 2) {
                                    $this->Piecereglement->updateAll(array('Piecereglement.reglefournisseur' => 1, 'Piecereglement.montantfrs' => $l['montant']), array('Piecereglement.id' => $piecereglement_id));
                                }
                                if ($l['regle_id'] == 3) {
                                    $this->Piecereglement->updateAll(array('Piecereglement.reglefournisseur' => 1, 'Piecereglement.montantfrs' => $reglerfrs[$j]['montantfrs']), array('Piecereglement.id' => $piecereglement_id));
                                }
                            }

                            if (!empty($this->request->data['Situation'][$j])) {
                                foreach ($this->request->data['Situation'][$j]['etatpieceregelemnt'] as $k => $etatpieceregelemnt) {
                                    if ($etatpieceregelemnt['supp'] != 1) {
                                        if ((isset($etatpieceregelemnt['id'])) && (!empty($etatpieceregelemnt['id']))) {
                                            $data['id'] = $etatpieceregelemnt['id'];
                                        } else {
                                            $data['id'] = "";
                                        }
                                        $data['piecereglement_id'] = $piecereglement_id;
                                        $data['date'] = date("Y-m-d", strtotime(str_replace('/', '-', $etatpieceregelemnt['echancenf'])));
                                        ;
                                        //$data['agio']= $this->request->data['etatpieceregelemnt'][$j]['agio'];
                                        $data['etatpiecereglement_id'] = $etatpieceregelemnt['etatpiecereglement_id'];
                                        $data['utilisateur_id'] = CakeSession::read('users');
                                        $data['datemodification'] = date("Y-m-d");
                                        $data['nbrjour'] = $etatpieceregelemnt['nbrjour'];
                                        $data['montant'] = $etatpieceregelemnt['montant'];
                                        if (($data['etatpiecereglement_id'] == 7) || ($data['etatpiecereglement_id'] == 8)) {
                                            $nbr_jour_mois = "Sur " . $data['nbrjour'] . " Jours";
                                        } else {
                                            $nbr_jour_mois = " ";
                                        }

                                        $this->Situationpiecereglement->create();
                                        $this->Situationpiecereglement->save($data);
                                        if ($k == $this->request->data['contactchoisi'][$j]) {
                                            $etatpiece = $this->Etatpiecereglement->find('first', array('conditions' => array('Etatpiecereglement.id' => $data['etatpiecereglement_id'])));
                                            $this->Piecereglement->updateAll(array('Piecereglement.situation' => '"' . $etatpiece['Etatpiecereglement']['name'] . '"', 'Piecereglement.nbrmoins' => '"' . $nbr_jour_mois . '"', 'Piecereglement.echance' => '"' . $data['date'] . '"', 'Piecereglement.etatpiecereglement_id' => $data['etatpiecereglement_id']), array('Piecereglement.id' => $piecereglement_id));
                                            if ($data['etatpiecereglement_id'] == 9) {
                                                $this->Piecereglement->updateAll(array('Piecereglement.credit' => 1), array('Piecereglement.id' => $piecereglement_id));
                                            }
                                        }
                                    } else {
                                        if ((isset($etatpieceregelemnt['id'])) && (!empty($etatpieceregelemnt['id']))) {
                                            $data['id'] = $etatpieceregelemnt['id'];
                                            $this->Situationpiecereglement->deleteAll(array('Situationpiecereglement.id' => $data['id']), false);
                                        }
                                    }
                                }
                            }
                        } else {
                            if ($l['id'] != "") {
                                $piece = $this->Piecereglement->find('first', array('conditions' => array('Piecereglement.id' => $l['id'])));
                                if ($piece['Piecereglement']['etatpiecereglement_id'] == 9) {
                                    $traitecredits = $this->Traitecredit->find('first', array('conditions' => array('Traitecredit.piecereglement_id' => $l['id'])));
                                    foreach ($traitecredits as $t => $cred) {
                                        $piecetraitt = $this->Piecereglement->find('first', array('conditions' => array('Piecereglement.id' => $cred['Traitecredit']['id'])));
                                        $this->Situationpiecereglement->deleteAll(array('Situationpiecereglement.piecereglement_id' => $piecetraitt['Piecereglement']['id']), false);
                                        $this->Piecereglement->deleteAll(array('Piecereglement.traitecredit_id' => $cred['Traitecredit']['id']), false);
                                    }
                                    $this->Traitecredit->deleteAll(array('Traitecredit.piecereglement_id' => $l['id']), false);
                                }
                                $this->Situationpiecereglement->deleteAll(array('Situationpiecereglement.piecereglement_id' => $l['id']), false);
                                $this->Piecereglement->deleteAll(array('Piecereglement.id' => $l['id']), false);
                            }
                        }
                    }
                    if ($devisefournisseurs != 1) {
                        $this->Piecereglement->updateAll(array('Piecereglement.importation_id' => $importation_id), array('Piecereglement.id' => $l['id']));
                        $this->Reglement->updateAll(array('Reglement.importation_id' => $importation_id), array('Reglement.id' => $reg_id));
                    }
                    if ($importation_id != 0) {
                        //$this->Importation->updateAll(array('Importation.regler '=>1),array('Importation.id' => $importation_id));
                    }
                }

                $this->Session->setFlash(__('The reglement has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The reglement could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Reglement.' . $this->Reglement->primaryKey => $id));
            $this->request->data = $this->Reglement->find('first', $options);
            //debug($this->request->data);
        }

        $valeurs = $this->To->find('list');
        $facture = array();
        $fournisseurs = $this->Reglement->Fournisseur->find('list');
        $carnetcheques = $this->Carnetcheque->find('list', array('fields' => array('Carnetcheque.numero')));
        $reglement = $this->Reglement->find('first', array('conditions' => array('Reglement.id' => $id), 'recursive' => 0));
        $fournisseur_id = $reglement['Reglement']['fournisseur_id'];
        $fournisseur = $this->Fournisseur->find('first', array('conditions' => array('Fournisseur.id' => $fournisseur_id)));
        $devisefournisseur = $fournisseur['Fournisseur']['devise_id'];
        $namefournisseur = $fournisseur['Fournisseur']['name'];
        $fournisseur = $reglement['Fournisseur']['name'];
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $reglement['Reglement']['Date'])));
        $montant = $reglement['Reglement']['Montant'];
        $importation_id = $reglement['Reglement']['importation_id'];
        //debug($importation_id);
        if ($fournisseur_id) {
            $t = '0';
            foreach ($this->request->data['Lignereglement']as $j => $l) {
                $t = $t . ',' . $l['facture_id'];
            }


            //*******************************************************   
            if ($devisefournisseur == 1) {
                $facture = $this->Facture->find('all', array('conditions' => array('Facture.fournisseur_id' => $fournisseur_id, 'Facture.totalttc>Facture.Montant_Regler'), 'recursive' => 0));
                //debug($facture);die;
            } else {
                $facture = $this->Facture->find('all', array('conditions' => array('Facture.fournisseur_id' => $fournisseur_id, 'Facture.totalttc>(Facture.Montant_Regler)', 'Facture.totaldevise>(Facture.Montant_Regler)'), 'recursive' => 0));
            }




            if ($devisefournisseur == 1) {
                $facture = $this->Facture->find('all', array('conditions' => array('(Facture.id in(' . $t . ')) or (Facture.fournisseur_id =' . $fournisseur_id, 'Facture.totalttc > Facture.Montant_Regler)'), 'recursive' => 0));
                //debug($facture);die;
                $piecesreg = $this->Piecereglement->find('all', array('conditions' => array('Piecereglement.reglement_id' => $id), 'recursive' => 2, 'order' => array('Piecereglement.id' => 'asc')));  //debug($piecesreg);die;

                $retenue = $this->Piecereglement->find('first', array('conditions' => array('Piecereglement.reglement_id' => $id, 'Piecereglement.paiement_id' => 5), 'recursive' => -1));  //debug($piecesreg);die;
                //debug($retenue);
                $lignesreg = $this->Lignereglement->find('all', array('conditions' => array('Lignereglement.reglement_id' => $id)));  //debug($lignesreg);die;
                //debug($lignesreg);
                $totalfacture = 0;
                foreach ($lignesreg as $k => $ligne) {
                    $facreg[$ligne['Facture']['id']] = 1;
                    $totalfacture = $totalfacture + ($ligne['Facture']['totalttc'] - ($ligne['Facture']['Montant_Regler'] - $ligne['Lignereglement']['Montant']));
                }
            } else {
                $facture = $this->Facture->find('all', array('conditions' => array('(Facture.id in(' . $t . ')) or (Facture.fournisseur_id =' . $fournisseur_id, 'Facture.totalttc > Facture.Montant_Regler', 'Facture.totaldevise>(Facture.Montant_Regler))'), 'recursive' => 0));
                //debug($facture);
                $piecesreg = $this->Piecereglement->find('all', array('conditions' => array('Piecereglement.reglement_id' => $id, 'Piecereglement.traitecredit_id' => 0), 'recursive' => 2, 'order' => array('Piecereglement.id' => 'asc')));  //debug($piecesreg);die;

                $retenue = $this->Piecereglement->find('first', array('conditions' => array('Piecereglement.reglement_id' => $id, 'Piecereglement.paiement_id' => 5), 'recursive' => -1));  //debug($piecesreg);die;
                //debug($retenue);
                $lignesreg = $this->Lignereglement->find('all', array('conditions' => array('Lignereglement.reglement_id' => $id)));  //debug($lignesreg);die;
                //debug($lignesreg);
                $totalfacture = 0;
                foreach ($lignesreg as $k => $ligne) {
                    $importa = $this->Importation->find('first', array('conditions' => array('Importation.id' => $ligne['Facture']['importation_id'])));
                    $facreg[$ligne['Facture']['id']] = 1;
                    $variationtauxdechange = ClassRegistry::init('Variationtauxdechange')->find('first', array('conditions' => array('Variationtauxdechange.reglement_id' => $this->request->data['Reglement']['id']), 'recursive' => 0));
                    if (!empty($variationtauxdechange)) {
                        if ($variationtauxdechange['Variationtauxdechange']['type'] == 'Perte') {
                            $variation = $variationtauxdechange['Variationtauxdechange']['montant'];
                        } else {
                            $variation = $variationtauxdechange['Variationtauxdechange']['montant'] * (-1);
                        }
                    } else {
                        $variation = 0;
                    }
                    $totalfacture = $totalfacture + (($importa['Importation']['montantachat'] * $ligne['Lignereglement']['tauxchange']) - (($ligne['Facture']['Montant_Regler'] * $ligne['Lignereglement']['tauxchange']) - $ligne['Lignereglement']['Montant'])) + $variation;
                }
            }
        }
        $comptess = $this->Compte->find('all');
        foreach ($comptess as $c) {
            $comptes[$c['Compte']['id']] = $c['Compte']['banque'] . "  " . $c['Compte']['rib'];
        }


        if ($devisefournisseur == 1) {
            $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id in (1,2,3,4,5)')));
        } else {
            $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id in (4,6)')));
            $etatpiecereglements = $this->Etatpiecereglement->find('list', array('conditions' => array('Etatpiecereglement.id in (1,3,7,8,9,10,11,12,13)')));
        }

        if ($importation_id != 0) {
            $importations = $this->Importation->find('list', array('conditions' => array('(Importation.fournisseur_id=' . $fournisseur_id, 'Importation.regler =0', 'Importation.etat =0) or (Importation.id=' . $importation_id . ')')));
        } else {
            $importations = $this->Importation->find('list', array('conditions' => array('Importation.fournisseur_id' => $fournisseur_id, 'Importation.regler' => 0)));
        }
        $regles[1] = "Non Reglé";
        $regles[2] = "Reglé";
        $this->set(compact('regles', 'namefournisseur', 'etatpiecereglements', 'importations', 'devisefournisseur', 'credit', 'fournisseurs', 'fournisseur_id', 'fournisseur', 'facture', 'paiements', 'carnetcheques', 'valeurs', 'date', 'montant', 'facreg', 'totalfacture', 'piecesreg', 'lignesreg', 'retenue', 'comptes'));
    }

    public function delete($id = null) {
        $lien = CakeSession::read('lien_achat');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglements') {
                    $vente = $liens['delete'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Facture');
        $this->loadModel('Cheque');
        $this->loadModel('Lignereglement');
        $this->loadModel('Piecereglement');
        $this->loadModel('Importation');
        $this->loadModel('Variationtauxdechange');
        $this->loadModel('Traitecredit');
        $this->loadModel('Situationpiecereglement');
        $this->Reglement->id = $id;

        if (!$this->Reglement->exists()) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $this->request->onlyAllow('post', 'delete');
        $reg = $this->Reglement->find('first', array('conditions' => array('Reglement.id' => $id)));
        $importation_id = $reg['Reglement']['importation_id'];
        if ($importation_id != 0) {
            $this->Importation->updateAll(array('Importation.regler ' => 0), array('Importation.id' => $importation_id));
        }
        $piecesreg = $this->Piecereglement->find('all', array('conditions' => array('Piecereglement.reglement_id' => $id, 'Piecereglement.paiement_id' => 2)));
        if (!empty($piecesreg)) {
            foreach ($piecesreg as $k => $piece) {
                $this->Cheque->updateAll(array('Cheque.etat' => 0), array('Cheque.id' => $piece['Piecereglement']['cheque_id']));
            }
        }
        $piecereglementfrs = $this->Piecereglement->find('all', array('conditions' => array('Piecereglement.reglement_id' => $id)));
        foreach ($piecereglementfrs as $piecereglementfr) {
            if ($piecereglementfr['Piecereglement']['etatpiecereglement_id'] == 9) {
                $traitecredits = $this->Traitecredit->find('first', array('conditions' => array('Traitecredit.piecereglement_id' => $piecereglementfr['Piecereglement']['id'])));
                foreach ($traitecredits as $t => $cred) {
                    $piecetraitt = $this->Piecereglement->find('first', array('conditions' => array('Piecereglement.id' => $cred['Traitecredit']['id'])));
                    $this->Situationpiecereglement->deleteAll(array('Situationpiecereglement.piecereglement_id' => $piecetraitt['Piecereglement']['id']), false);
                    $this->Piecereglement->deleteAll(array('Piecereglement.traitecredit_id' => $cred['Traitecredit']['id']), false);
                }
                $this->Traitecredit->deleteAll(array('Traitecredit.piecereglement_id' => $piecereglementfr['Piecereglement']['id']), false);
            }
            $this->Situationpiecereglement->deleteAll(array('Situationpiecereglement.piecereglement_id' => $piecereglementfr['Piecereglement']['id']), false);
            $this->Piecereglement->deleteAll(array('Piecereglement.reglement_id' => $id), false);
        }
        $variationtaux = $this->Variationtauxdechange->find('first', array('conditions' => array('Variationtauxdechange.reglement_id' => $id)));
        if (!empty($variationtaux)) {
            $this->Variationtauxdechange->deleteAll(array('Variationtauxdechange.reglement_id' => $id), false);
        }
        //$this->Piecereglement->deleteAll(array('Piecereglement.reglement_id' => $id), false);
        $lignesreg = $this->Lignereglement->find('all', array('conditions' => array('Lignereglement.reglement_id' => $id)));
        $importation = $this->Importation->find('first', array('conditions' => array('Importation.id' => $importation_id), 'recursive' => -1));
        //$importation['Importation']['tauxderechenge']
        if ($importation_id == 0) {
            $importation['Importation']['tauxderechenge'] = 1;
        }
        foreach ($lignesreg as $k => $ligne) {
            if ($ligne['Facture']['importation_id'] != 0) {
                $importation = $this->Importation->find('first', array('conditions' => array('Importation.id' => $ligne['Facture']['importation_id']), 'recursive' => -1));
                $this->Facture->updateAll(array('Facture.Montant_Regler' => 'Facture.Montant_Regler-' . $ligne['Lignereglement']['Montant'] / $importation['Importation']['tauxderechenge'], 'Facture.etat' => 0), array('Facture.id' => $ligne['Lignereglement']['facture_id']));
            } else {
                $this->Facture->updateAll(array('Facture.Montant_Regler' => 'Facture.Montant_Regler-' . $ligne['Lignereglement']['Montant'], 'Facture.etat' => 0), array('Facture.id' => $ligne['Lignereglement']['facture_id']));
            }
        }
        $this->Lignereglement->deleteAll(array('Lignereglement.reglement_id' => $id), false);
        $abcd = $this->Reglement->find('first', array('conditions' => array('Reglement.id' => $id), 'recursive' => -1));
        $numansar = $abcd['Reglement']['numeroconca'];
        if ($this->Reglement->delete()) {
            $this->misejour("Reglement", $numansar, $id);
            $this->Session->setFlash(__('Reglement deleted'));
            CakeSession::write('view', "delete");
            $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('Reglement was not deleted'));
            CakeSession::write('view', "delete");
            $this->redirect(array('action' => 'index'));
        }
    }

    public function recap($nbrmoins = null, $id = null, $montant = null) {
        //$this->layout = null;
        $this->loadModel('Piecereglement');
        $this->loadModel('Traitecredit');
        if ($this->request->is('post') || $this->request->is('put')) {
            $piecereglement_tab = explode(',', $id);
            $piecereglement_id = $piecereglement_tab[0];
            $piecesreg = $this->Piecereglement->find('first', array('conditions' => array('Piecereglement.id' => $piecereglement_id)));
            if (!empty($this->request->data['credits'][0])) {
                foreach ($this->request->data['credits'][0]['traitecredits']as $t => $credit) {
                    $credit['reglement_id'] = $piecesreg['Piecereglement']['reglement_id'];
                    $credit['piecereglement_id'] = $piecereglement_id;
                    $credit['fournisseur_id'] = $piecesreg['Reglement']['fournisseur_id'];
                    $credit['importation_id'] = $piecesreg['Piecereglement']['importation_id'];
                    $credit['echancecredit'] = date("Y-m-d", strtotime(str_replace('/', '-', $credit['echancecredit'])));
                    $this->Traitecredit->create();
                    $this->Traitecredit->save($credit);
                    $credit['id'] = $this->Traitecredit->id;
                    $piece['reglement_id'] = $piecesreg['Piecereglement']['reglement_id'];
                    $piece['paiement_id'] = 7;
                    $piece['montant'] = $credit['montantcredit'];
                    $piece['date'] = date("Y-m-d");
                    $piece['num'] = $credit['num_piececredit'];
                    $piece['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $credit['echancecredit'])));
                    $piece['compte_id'] = $piecesreg['Piecereglement']['compte_id'];
                    $piece['situation'] = "En attente";
                    $piece['etatpiecereglement_id'] = 1;
                    $piece['traitecredit_id'] = $credit['id'];
                    $this->Piecereglement->create();
                    $this->Piecereglement->save($piece);
                }
                $this->Piecereglement->updateAll(array('Piecereglement.credit' => 1), array('Piecereglement.id' => $piecereglement_id));
            }
            $this->redirect(array('controller' => 'traitecredits', 'action' => 'index'));
        }
        $data = $this->request->data;
        //$nbrmoins= $data['nbrmoins'];
        $index = 0;
        $this->set(compact('index', 'nbrmoins', 'montant'));
    }
     //****************** ZEINAB ********//
     public function imprimerexcel() {
//        $lien = CakeSession::read('lien_achat');
//        $vente = "";
//        if (!empty($lien)) {
//            foreach ($lien as $k => $liens) {
//                if (@$liens['lien'] == 'reglements') {
//                    $vente = $liens['imprimer'];
//                }
//            }
//        }
//        if (( $vente <> 1) || (empty($lien))) {
//            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
//        }

        $this->loadModel('Fournisseur');
        $this->loadModel('Piecereglement');
        $this->loadModel('Ligneclient');
        $this->layout='';
        // debug($this->request->query);die;
        $cond = '';
        $cond1 = '';
        $cond2 = '';
        $cond3 = '';
        $cond4 = '';
        $cond6 = '';
        $cond7 = '';
        if (!empty($this->request->query['Date_debut'])) {
            $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_debut'])));
            $cond = 'Reglement.Date>=' . "'" . $Date_debut . "'";
        }
        if (!empty($this->request->query['Date_fin'])) {
            $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_fin'])));
            $cond1 = 'Reglement.Date<=' . "'" . $Date_fin . "'";
        }

        if (!empty($this->request->query['fournisseur_id'])) {
            $fournisseur_id = $this->request->query['fournisseur_id'];
            $cond3 = 'Reglement.fournisseur_id=' . $fournisseur_id;
        }

        $this->loadModel('Utilisateur');
        $this->loadModel('Pointdevente');
        $this->loadModel('Societe');
        $this->loadModel('Personnel');
        if ($this->request->query['societe_id']) {
            $societe_id = $this->request->query['societe_id'];
            $lespvs = $this->Pointdevente->find('all', array('conditions' => array('Pointdevente.societe_id' => $societe_id), 'recursive' => -1));
            $ch_pv = 0;
            foreach ($lespvs as $lespv) {
                $ch_pv = $ch_pv . ',' . $lespv['Pointdevente']['id'];
            }
            $cond6 = 'Reglement.pointdevente_id in (' . $ch_pv . ')';
        }

        if ($this->request->query['pointdevente_id']) {
            $pointdevente_id = $this->request->query['pointdevente_id'];
            $cond7 = 'Reglement.pointdevente_id =' . $pointdevente_id;
        }


        $this->Reglement->recursive = 2;
        $this->paginate = array(
            'order' => array('Reglement.id' => 'desc'),
            'conditions' => array($cond, $cond1, $cond2, $cond3, $cond4, $cond6, $cond7));
        $reglements = $this->paginate();


        $this->set(compact('reglements', 'collections', 'transferecommandebls', 'marques', 'familles', 'fournisseurs', 'ligneclients', 'marque_id', 'Date_debut', 'Date_fin', 'fournisseur_id', 'num_recu'));
    }


}
