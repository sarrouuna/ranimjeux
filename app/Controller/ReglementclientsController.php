<?php

App::uses('AppController', 'Controller');

/**
 * Reglementclients Controller
 *
 * @property Reglementclient $Reglementclient
 */
class ReglementclientsController extends AppController {

    public function index() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Famille');
        $this->loadModel('Client');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Ligneclient');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $this->loadModel('Personnel');
        $limit=300;
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $conde = 'Reglementclient.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Reglementclient.pointdevente_id = ' . $p;
        }
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        //$cond = 'Reglementclient.Date>=' . "'" . date('Y-m-d') . "'";
        //$cond1 = 'Reglementclient.Date<=' . "'" . date('Y-m-d') . "'";
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("edit", "view", "delete"))) && (CakeSession::read('Controller') == "Reglementclients"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("edit", "view", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Reglementclient']);
            } else {
                $this->request->data['Reglementclient'] = CakeSession::read('recherche');
            }
            $limit=100000;
            if ($this->request->data['Reglementclient']['exercice_id']) {
                $exerciceid = $this->request->data['Reglementclient']['exercice_id'];
                $cond4 = 'Reglementclient.exercice_id =' . $exercices[$exerciceid];
                $conde = "";
                $cond = "";
                $cond1 = "";
            }
            //debug($this->request->data['Reglementclient']);die;
            if ($this->request->data['Reglementclient']['Date_debut'] != '__/__/____') {
                $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date_debut'])));
                $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
                $cond4 = "";
            }
            if ($this->request->data['Reglementclient']['Date_fin'] != '__/__/____') {
                $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date_fin'])));
                $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
                $cond4 = "";
            }

            if ($this->request->data['Reglementclient']['client_id']) {
                $client_id = $this->request->data['Reglementclient']['client_id'];
                $cond3 = 'Reglementclient.client_id=' . $client_id;
            }

            if (!empty($this->request->data['Reglementclient']['pointdevente_id'])) {
                $pointdeventeid = $this->request->data['Reglementclient']['pointdevente_id'];
                $cond5 = 'Reglementclient.pointdevente_id =' . $pointdeventeid;
            }
            if ($this->request->data['Reglementclient']['libre_id']) {
                $libre_id = $this->request->data['Reglementclient']['libre_id'];
                if ($libre_id == 'Oui') {
                    $condlibre = 'Reglementclient.montantaffecte=0';
                } else {
                    $condlibre = 'Reglementclient.montantaffecte!=0';
                }
            }
            if ($this->request->data['Reglementclient']['numero']) {
                $numero = $this->request->data['Reglementclient']['numero'];
                $cond6 = 'Reglementclient.numero LIKE '."'%". $numero."%'";
            }
            if (!empty($this->request->data['Reglementclient']['personnel_id'])) {
                $personnel_id = $this->request->data['Reglementclient']['personnel_id'];
                $cond7 = 'Reglementclient.personnel_id =' . $personnel_id;
            }
        }
        //debug($limit);
        $libres = array();
        $libres['Oui'] = 'Oui';
        $libres['Non'] = 'Non';
        $reglementclients = $this->Reglementclient->find('all', array(
            'conditions' => array('Reglementclient.id >'=>0,@$pv, @$cond, @$conde, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$condlibre,@$cond6,@$cond7)
            ,'limit'=>$limit
            ,'order' => array('Reglementclient.id' => 'DESC')
            ,'recursive'=>0));
        //debug($reglementclients);die;
        $personnels = $this->Personnel->find('list');
        $Piecereglementclients= $this->Piecereglementclient->find('first', array(
            'conditions' => array('Piecereglementclient.reglementclient_id'=>$reglementclients[0]['Reglementclient']['id'])));
            //debug($Piecereglementclient);die;
       // $paiements = $this->Paiement->find('list');

        $this->set(compact('personnels','Piecereglementclients','pointdeventeid', 'libres', 'libre_id', 'reglementclients', 'collections', 'transferecommandebls', 'marques', 'familles', 'clients', 'ligneclients', 'Date_debut', 'marque_id', 'Date_fin', 'client_id', 'exerciceid', 'num_recu', 'pointdeventes', 'exercices'));
    }

    public function imprimerexcel() {
        $this->loadModel('Exercice');
        $this->layout = NULL;
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
//               $this->loadModel('Marque');
//              $this->loadModel('Famille');
        $this->loadModel('Client');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Ligneclient');
        // debug($this->request->query);die;
        $cond = '';
        $cond1 = '';
        $cond2 = '';
        $cond3 = '';
        $cond4 = '';
        $condlibre = '';
        $exercices = $this->Exercice->find('list');

        if (!empty($this->request->query['exercice_id'])) {
            $exerciceid = $this->request->query['exercice_id'];
            $cond4 = 'Reglementclient.exercice_id =' . $exercices[$exerciceid];
            $conde = "";
            $cond = "";
            $cond1 = "";
        }

        if (!empty($this->request->query['Date_debut'])) {
            $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_debut'])));
            $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
        }
        if (!empty($this->request->query['Date_fin'])) {
            $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_fin'])));
            $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
        }


        if (!empty($this->request->query['client_id'])) {
            $client_id = $this->request->query['client_id'];
            $cond3 = 'Reglementclient.client_id=' . $client_id;
        }
        if (!empty($this->request->query['libre_id'])) {
            if ($this->request->query['libre_id'] == 'Oui') {
                $condlibre = 'Reglementclient.montantaffecte=0';
            } else {
                $condlibre = 'Reglementclient.montantaffecte!=0';
            }
        }

        $this->Reglementclient->recursive = 2;
        $this->paginate = array(
            'order' => array('Reglementclient.id' => 'desc'),
            'conditions' => array($cond, $cond1, $cond2, $cond3, $cond4, $condlibre, @$conde));
        $reglements = $this->paginate();


        $this->set(compact('reglements', 'collections', 'transferecommandebls', 'marques', 'familles', 'clients', 'ligneclients', 'marque_id', 'Date_debut', 'Date_fin', 'client_id', 'num_recu'));
    }

    public function imprimerrecherche() {
        $this->loadModel('Exercice');
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
//               $this->loadModel('Marque');
//              $this->loadModel('Famille');
        $this->loadModel('Client');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Ligneclient');
        // debug($this->request->query);die;
        $cond = '';
        $cond1 = '';
        $cond2 = '';
        $cond3 = '';
        $cond4 = '';
        $condlibre = '';
        $exercices = $this->Exercice->find('list');

        if (!empty($this->request->query['exercice_id'])) {
            $exerciceid = $this->request->query['exercice_id'];
            $cond4 = 'Reglementclient.exercice_id =' . $exercices[$exerciceid];
            $conde = "";
            $cond = "";
            $cond1 = "";
        }

        if (!empty($this->request->query['Date_debut'])) {
            $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_debut'])));
            $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
        }
        if (!empty($this->request->query['Date_fin'])) {
            $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_fin'])));
            $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
        }


        if (!empty($this->request->query['client_id'])) {
            $client_id = $this->request->query['client_id'];
            $cond3 = 'Reglementclient.client_id=' . $client_id;
        }
        if (!empty($this->request->query['libre_id'])) {
            if ($this->request->query['libre_id'] == 'Oui') {
                $condlibre = 'Reglementclient.montantaffecte=0';
            } else {
                $condlibre = 'Reglementclient.montantaffecte!=0';
            }
        }

        $this->Reglementclient->recursive = 2;
        $this->paginate = array(
            'order' => array('Reglementclient.id' => 'desc'),
            'conditions' => array($cond, $cond1, $cond2, $cond3, $cond4, $condlibre, @$conde));
        $reglements = $this->paginate();


        $this->set(compact('reglements', 'collections', 'transferecommandebls', 'marques', 'familles', 'clients', 'ligneclients', 'marque_id', 'Date_debut', 'Date_fin', 'client_id', 'num_recu'));
    }

    public function view($id = null) {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Lignereglementclient');
        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id), 'recursive' => 1);
        $reglement = $this->Reglementclient->find('first', $options);
        $pieceregement = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id)));
        $ligneregement = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id)));

         //debug($reglement);die;
        $this->set(compact('reglement', 'pieceregement','ligneregement'));
    }

    public function imprimerview($id = null) {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Piecereglementclient');
        $this->loadModel('Lignereglementclient');

        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $reglement = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id), 'recursive' =>0));
        //debug($reglement);die;
        $pieceregement = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id), 'recursive' =>0));

        $ligneregement = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id), 'recursive' =>0));


        $this->set(compact('reglement', 'pieceregement', 'ligneregement'));
    }
    public function imprimerretenu($id = null) {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Piecereglementclient');
        $this->loadModel('Lignereglementclient');

        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $reglement = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id), 'recursive' =>0));
        //debug($reglement);die;
        $pieceregement = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id), 'recursive' =>0));

        $ligneregement = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id), 'recursive' =>0));


        $this->set(compact('reglement', 'pieceregement', 'ligneregement'));
    }
    public function add($client_id = 0, $poinvente = 0,$personnel=0,$idfac=0,$idbl=0) {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['add'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        //debug($client_id);
        //debug($poinvente);
        $this->loadModel('Factureclient');
        $this->loadModel('Bon');
        $this->loadModel('Factureavoir');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Factureavoir');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');

        if ($this->request->is('post')) {
            $client_id = $this->request->data['Reglementclient']['client_id'];
            $this->request->data['Reglementclient']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date'])));
            $this->request->data['Reglementclient']['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data['Reglementclient']['pointdevente_id'])) {
                $this->request->data['Reglementclient']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Reglementclient']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Reglementclient']['pointdevente_id'];
            }
            $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                'conditions' => array('Reglementclient.pointdevente_id' => $pv, 'Reglementclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
            } else {
                $mm = "000001";
            }


            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
            $this->request->data['Reglementclient']['numeroconca'] = $mm;
            $this->request->data['Reglementclient']['numero'] = $numspecial;

           // debug($this->request->data);die;
            $this->Reglementclient->create();
            if ($this->Reglementclient->save($this->request->data)) {
                $reg_id = $this->Reglementclient->id;
                $this->misejour("Reglementclient", "add", $reg_id);
                $mntt = $this->request->data['Reglementclient']['Montant'];
                $montantaffecter = 0;

                if (!empty($this->request->data['Lignereglement'])) {
                    foreach ($this->request->data['Lignereglement'] as $j => $l) {
                        if ($mntt > 0 && array_key_exists('factureclient_id', $l)) {
                            $li['reglementclient_id'] = $reg_id;
                            //debug($l['bonlivraison_id']);
                            $li['factureclient_id'] = $l['factureclient_id'];
                            $id_fac = $l['factureclient_id'];
                            $li['Montant'] = $l['Montant'];
                            $montantaffecter = $montantaffecter + $l['Montant'];
                            $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler+' . $l['Montant']), array('Factureclient.id' => $id_fac));
                            $this->Lignereglementclient->create();
                            $this->Lignereglementclient->save($li);
                        }
                    }
                }
                $li = array();
                if (!empty($this->request->data['Lignereglementimpaye'])) {
                    foreach ($this->request->data['Lignereglementimpaye']as $j => $l) {
                        if ($mntt > 0 && array_key_exists('piecereglementclient_id', $l)) {
                            $li['reglementclient_id'] = $reg_id;
                            $li['piecereglementclient_id'] = $l['piecereglementclient_id'];
                            $id_piece = $l['piecereglementclient_id'];
                            $li['Montant'] = $l['Montant'];
                            $montantaffecter = $montantaffecter + $l['Montant'];
                            $this->Piecereglementclient->updateAll(array('Piecereglementclient.reglement' => $reg_id, 'Piecereglementclient.mantantregler' => 'Piecereglementclient.mantantregler+' . $l['Montant']), array('Piecereglementclient.id' => $id_piece));
                            $this->Lignereglementclient->create();
                            $this->Lignereglementclient->save($li);
                        }
                    }
                }
				if (!empty($this->request->data['Lignereglementbonliv'])) {
					foreach ($this->request->data['Lignereglementbonliv']as $j => $l) {
						if ($mntt > 0 && array_key_exists('factureclient_id', $l)) {
							$li['reglementclient_id'] = $reg_id;
							//debug($l['bonlivraison_id']);
							$li['bonlivraison_id'] = $l['factureclient_id'];
							$id_fac = $l['factureclient_id'];
							$li['Montant'] = $l['Montant'];
							$montantaffecter = $montantaffecter + $l['Montant'];
							$this->Bonlivraison->updateAll(array('Bonlivraison.Montant_Regler ' => 'Bonlivraison.Montant_Regler+' . $l['Montant']), array('Bonlivraison.id' => $id_fac));
							$this->Lignereglementclient->create();
							$this->Lignereglementclient->save($li);
						}
					}
				}

				if (!empty($this->request->data['Lignereglementbonliv'])) {
					foreach ($this->request->data['Lignereglementbonliv']as $j => $l) {
						if ($mntt > 0 && array_key_exists('factureclient_id', $l)) {
							$li['reglementclient_id'] = $reg_id;
							//debug($l['bonlivraison_id']);
							$li['bonlivraison_id'] = $l['factureclient_id'];
							$id_fac = $l['factureclient_id'];
							$li['Montant'] = $l['Montant'];
							$montantaffecter = $montantaffecter + $l['Montant'];
							$this->Bonlivraison->updateAll(array('Bonlivraison.Montant_Regler ' => 'Bonlivraison.Montant_Regler+' . $l['Montant']), array('Bonlivraison.id' => $id_fac));
							$this->Lignereglementclient->create();
							$this->Lignereglementclient->save($li);
						}
					}
				}

                $this->Reglementclient->updateAll(array('Reglementclient.montantaffecte' => $montantaffecter), array('Reglementclient.id' => $reg_id));

                foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                    // debug($l);
                    //  $li['client_id']=$client_id;
                    if ($l['sup'] != 1) {
                        $lip['montant'] = $l['montant'];
//                                $li['num_recu']=$l['num_recu'];
                        if ($l['nameclient'] == "") {
                            $nameclients = $this->Reglementclient->Client->find('first', array('conditions' => array('Client.id' => $client_id)));
                            $lip['nameclient'] = $nameclients['Client']['code'] . " " . $nameclients['Client']['name'];
                        } else {
                            $lip['nameclient'] = $l['nameclient'];
                        }
                        $lip['paiement_id'] = $l['paiement_id'];
                        $lip['reglementclient_id'] = $reg_id;
                        $lip['echance'] = '';
                        $lip['num'] = '';
                        $lip['banque'] = '';
                        $lip['montant_brut'] = '';
                        $lip['montant_net'] = '';
                        $lip['to_id'] = '';
                        $lip['factureavoir_id'] = '';

                        if ($l['paiement_id'] != 1) {
                            $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                            $lip['num'] = $l['num_piece'];
                            $lip['banque'] = $l['banque'];
                        }
                        if ($l['paiement_id'] == 5) {
                            $lip['banque'] = '';
                            $lip['echance'] = '';
                            $lip['montant_brut'] = $l['montant_brut'];
                            $lip['montant_net'] = $l['montant_net'];
                            $lip['to_id'] = $l['taux'];
                        }
                        if ($l['paiement_id'] == 6) {
                            $lip['banque'] = '';
                            $lip['echance'] = '';
                            $lip['factureavoir_id'] = $l['favid'];

                            $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $l['favid']), false));
                            $this->Factureavoir->updateAll(array('Factureavoir.etat' => 2), array('Factureavoir.id' => $l['favid']));
                            $lip['num'] = $factureavoir['Factureavoir']['numero'];
                        }
                        $this->Piecereglementclient->create();
                        $this->Piecereglementclient->save($lip);
//                                 $id_piece= $this->Piece->id;
//                                 $lip['piece_id']=$id_piece;
//                                 $lip['reglement_id']=$reg_id;
//                                  $this->Piecereglementclient->create();
//                                 // debug($lip);
//                                 $this->Piecereglement->save($lip);
                    }
                }
                $this->Session->setFlash(__('The reglement has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The reglement could not be saved. Please, try again.'));
            }
        }
        $nameclt="";
        $valeurs = $this->To->find('list');
        $facture = array();
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Reglementclient->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        //$clients = $this->Reglementclient->Client->find('list');
        //$paiements = $this->Paiement->find('list'); //debug($paiements);die;
        if ($client_id) {
            $facture = $this->Factureclient->find('all', array('conditions' => array('Factureclient.client_id' => $client_id, 'Factureclient.totalttc>(Factureclient.Montant_Regler)'), 'recursive' => 0));
            $bonliv  = $this->Bonlivraison->find('all', array('conditions' => array('Bonlivraison.client_id' => $client_id, 'Bonlivraison.totalttc>(Bonlivraison.Montant_Regler)','factureclient_id=0'),'recursive' => 0));
            $factureavoir  = $this->Factureavoir->find('all', array('conditions' => array('Factureavoir.client_id' => $client_id, 'Factureavoir.totalttc>(Factureavoir.montant_regle)','factureclient_id=0'),'recursive' => 0));
           //debug($bonliv);die();
            $situat = "Impaye";
            $impayes = $this->Piecereglementclient->find('all', array(
                'conditions' => array(
                    'Piecereglementclient.situation =' . "'" . $situat . "'", 'Piecereglementclient.montant>Piecereglementclient.mantantregler')
                , 'recursive' => 0));
            $clt = $this->Reglementclient->Client->find('first', array(
            'conditions' => array('Client.id' => $client_id)));
            $nameclt=$clt['Client']['code']." ".$clt['Client']['name'];
        }


        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {
            $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                'conditions' => array('Reglementclient.pointdevente_id' => $pv, 'Reglementclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];
//  if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }
//
            } else {
                $mm = "000001";
            }

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            if ($poinvente) {
                $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                    'conditions' => array('Reglementclient.pointdevente_id' => $poinvente, 'Reglementclient.exercice_id' => date("Y")))
                );
                //debug($numero);die;
                foreach ($numero as $num) {
                    $n = $num[0]['num'];
                }
                if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];
//  if ($anne==date("Y")){
                    $lastnum = $n;
                    $nume = intval($lastnum) + 1;
                    $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }
//
                } else {
                    $mm = "000001";
                }

                $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $poinvente)));
                $abrivation = $pointvente['Pointdevente']['abriviation'];
                $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
            } else {
                $mm = 0;
            }
        }
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
		$this->loadModel('Paiement');
		$paiements = $this->Paiement->find('list', array('fields'=>array('Paiement.id','Paiement.name'),'conditions' => array('Paiement.id in (1,2,3,4,5,23,24,25)')));
        ///debug($paiement_id);
        $this->loadModel('Personnel');
        $personnels = $this->Personnel->find('list');
        $this->set(compact('personnel','personnels','nameclt','impayes','poinvente','factureavoir', 'mm', 'numspecial', 'clients', 'client_id', 'facture', 'idfac', 'idbl', 'paiements', 'valeurs', 'pointdeventes','bonliv'));
    }

    public function edit($id = null) {
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Bonlivraison');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Pointdevente');
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['edit'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglementclient'));
        }
        $piecesregclient = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id), 'recursive' => 0));  //debug($piecesregclient);die;
        $retenue = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id, 'Piecereglementclient.paiement_id' => 5), 'recursive' => 0));  //debug($piecesreg);die;
        $totalfacture = 0;
        $lignesreg = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id)));
        foreach ($lignesreg as $k => $ligne) {
            if (empty($ligne['Lignereglementclient']['piecereglementclient_id'])) {
                $facregclient[$ligne['Factureclient']['id']] = 1;
                $totalfacture = $totalfacture + $ligne['Factureclient']['totalttc'];
            } else {
                $totalfacture = $totalfacture + ($ligne['Piecereglementclient']['montant'] - $ligne['Piecereglementclient']['mantantregler']);
            }
        }
        $reglementclient = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id)));
        $client_id = $reglementclient['Reglementclient']['client_id'];


        if ($this->request->is('post') || $this->request->is('put')) {
           // debug($this->request->data);die;
            $this->request->data['Reglementclient']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date'])));
            if ($this->Reglementclient->save($this->request->data)) {
                $this->misejour("Reglementclient", "edit", $id);
                foreach ($piecesregclient as $piece) {
                    if ($piece['Piecereglementclient']['paiement_id'] == 6) {
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 1), array('Factureavoir.id' => $piece['Piecereglementclient']['factureavoir_id']));
                    }
                }
                //.....................................effacer  piece reglementclient , ligne reglementclient , ..........................................................................
                //$this->Piecereglementclient->deleteAll(array('Piecereglementclient.reglementclient_id' => $id), false);
                //debug($lignesreg);die;
                foreach ($lignesreg as $k => $ligne) {
                    if (!empty($ligne['Lignereglementclient']['factureclient_id'])) {
                        $this->Factureclient->updateAll(array('Factureclient.Montant_Regler' => 'Factureclient.Montant_Regler-' . $ligne['Lignereglementclient']['Montant']
                                ), array('Factureclient.id' => $ligne['Lignereglementclient']['factureclient_id']));
                    }
                    if (!empty($ligne['Lignereglementclient']['piecereglementclient_id'])) {
                        $this->Piecereglementclient->updateAll(array('Piecereglementclient.mantantregler' => 'Piecereglementclient.mantantregler-' . $ligne['Lignereglementclient']['Montant'], 'Piecereglementclient.reglement' => 0
                                ), array('Piecereglementclient.id' => $ligne['Lignereglementclient']['piecereglementclient_id']));
                    }
                }
                $this->Lignereglementclient->deleteAll(array('Lignereglementclient.reglementclient_id' => $id), false);
                //..............................fin effacer ligne reglementclient , piece reglementclient .............................................................................

                $reg_id = $id;
                $mntt = $this->request->data['Reglementclient']['Montant'];
                //debug($mntt);
                $montantaffecter = 0;
                if (!empty($this->request->data['Lignereglement'])) {
                    foreach ($this->request->data['Lignereglement']as $j => $l) {
                        if ($mntt > 0 && array_key_exists('factureclient_id', $l)) {
                            $li['reglementclient_id'] = $reg_id;
                            $li['factureclient_id'] = $l['factureclient_id'];
                            $id_fac = $l['factureclient_id'];
                            $li['Montant'] = $l['Montant'];
                            $montantaffecter = $montantaffecter + $l['Montant'];
                            $this->Factureclient->updateAll(array('Factureclient.Montant_Regler ' => 'Factureclient.Montant_Regler+' . $l['Montant']), array('Factureclient.id' => $id_fac));
                            $this->Lignereglementclient->create();
                            $this->Lignereglementclient->save($li);
                        }
                    }
                }
                $li = array();
                if (!empty($this->request->data['Lignereglementimpaye'])) {
                    foreach ($this->request->data['Lignereglementimpaye']as $j => $l) {
                        if ($mntt > 0 && array_key_exists('piecereglementclient_id', $l)) {
                            $li['reglementclient_id'] = $reg_id;
                            $li['piecereglementclient_id'] = $l['piecereglementclient_id'];
                            $id_piece = $l['piecereglementclient_id'];
                            $li['Montant'] = $l['Montant'];
                            $montantaffecter = $montantaffecter + $l['Montant'];
                            $this->Piecereglementclient->updateAll(array('Piecereglementclient.reglement ' => $reg_id, 'Piecereglementclient.mantantregler' => 'Piecereglementclient.mantantregler+' . $l['Montant']), array('Piecereglementclient.id' => $id_piece));
                            $this->Lignereglementclient->create();
                            $this->Lignereglementclient->save($li);
                        }
                    }
                }
				if (!empty($this->request->data['Lignereglementbonliv'])) {
					foreach ($this->request->data['Lignereglementbonliv']as $j => $l) {
						if ($mntt > 0 && array_key_exists('factureclient_id', $l)) {
							$li['reglementclient_id'] = $reg_id;
							$li['factureclient_id'] = $l['factureclient_id'];
							$id_fac = $l['factureclient_id'];
							$li['Montant'] = $l['Montant'];
							$montantaffecter = $montantaffecter + $l['Montant'];
							$this->Bonlivraison->updateAll(array('Bonlivraison.Montant_Regler ' => 'Bonlivraison.Montant_Regler+' . $l['Montant']), array('Bonlivraison.id' => $id_fac));
							$this->Lignereglementclient->create();
							$this->Lignereglementclient->save($li);
						}
					}
				}
                $this->Reglementclient->updateAll(array('Reglementclient.montantaffecte' => $montantaffecter), array('Reglementclient.id' => $reg_id));

                foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                    if ($l['sup'] != 1) {
                        //debug($l);
                        if ($l['sup'] != "") {
                            $currentPiece = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.id' => $l['id']), 'recursive' => -1));  //debug($piecesreg);die;
                        }
                        $lip['id'] = @$l['id'];
                        $lip['montant'] = $l['montant'];
                        if ($l['nameclient'] == "") {
                            $nameclients = $this->Reglementclient->Client->find('first', array('conditions' => array('Client.id' => $client_id)));
                            $lip['nameclient'] = $nameclients['Client']['code'] . " " . $nameclients['Client']['name'];
                        } else {
                            $lip['nameclient'] = $l['nameclient'];
                        }
                        $lip['paiement_id'] = $l['paiement_id'];
                        $lip['reglementclient_id'] = $reg_id;
                        $lip['echance'] = '';
                        $lip['num'] = '';
                        $lip['banque'] = '';
                        $lip['montant_brut'] = '';
                        $lip['montant_net'] = '';
                        $lip['to_id'] = '';
                        $lip['factureavoir_id'] = '';
                        if ($l['sup'] != "") {
                            $lip['situation'] = $currentPiece['Piecereglementclient']['situation'];
                            $lip['envoye'] = $currentPiece['Piecereglementclient']['envoye'];
                            $lip['valide'] = $currentPiece['Piecereglementclient']['valide'];
                            $lip['datesituation'] = $currentPiece['Piecereglementclient']['datesituation'];
                            $lip['reglement'] = $currentPiece['Piecereglementclient']['reglement'];
                            $lip['mantantregler'] = $currentPiece['Piecereglementclient']['mantantregler'];
                            $lip['emi'] = $currentPiece['Piecereglementclient']['emi'];
                        }
                        if ($l['paiement_id'] != 1) {
                            $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                            $lip['num'] = $l['num_piece'];
                            $lip['banque'] = $l['banque'];
                        }
                        if ($l['paiement_id'] == 5) {
                            $lip['banque'] = '';
                            $lip['echance'] = '';
                            $lip['montant_brut'] = @$l['montant_brut'];
                            $lip['montant_net'] = @$l['montant_net'];
                            $lip['to_id'] = @$l['taux'];
                        }
                        if ($l['paiement_id'] == 6) {
                            $lip['banque'] = '';
                            $lip['echance'] = '';
                            $lip['factureavoir_id'] = $l['favid'];

                            $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $l['favid']), false));
                            $this->Factureavoir->updateAll(array('Factureavoir.etat' => 2), array('Factureavoir.id' => $l['favid']));

                            if (!empty($factureavoir['Factureavoir']['numero'])) {
                                $lip['num'] = $factureavoir['Factureavoir']['numero'];
                            }
                        }
                        //$this->Piecereglementclient->create();
                        $this->Piecereglementclient->save($lip);
                    } else {
                        $this->Piecereglementclient->deleteAll(array('Piecereglementclient.id' => $l['id']), false);
                    }
                }



                $this->Session->setFlash(__('The reglementclient has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The reglementclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id));
            $this->request->data = $this->Reglementclient->find('first', $options);
        }
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Reglementclient->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $this->set(compact('clients'));
        $valeurs = $this->To->find('list');
        $reglementclient = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id), 'recursive' => 0));
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $reglementclient['Reglementclient']['Date'])));
        $facture = array();
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Reglementclient->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $paiements = $this->Paiement->find('list');
        if ($client_id) {
            $t = '0';
            $p = '0';
            foreach ($this->request->data['Lignereglementclient']as $j => $l) {
                if (!empty($l['factureclient_id'])) {
                    $t = $t . ',' . $l['factureclient_id'];
                }
            }
            foreach ($this->request->data['Lignereglementclient']as $j => $l) {
                if (!empty($l['piecereglementclient_id'])) {
                    $p = $p . ',' . $l['piecereglementclient_id'];
                }
            }
            $facture = $this->Factureclient->find('all', array('conditions' => array('Factureclient.client_id' => $client_id, '(Factureclient.totalttc>(Factureclient.Montant_Regler)) or Factureclient.id in(' . $t . ')'), 'recursive' => 0));
            $bonliv = $this->Bonlivraison->find('all', array('conditions' => array('Bonlivraison.client_id' => $client_id, '(Bonlivraison.totalttc>(Bonlivraison.Montant_Regler)) or Bonlivraison.id in(' . $t . ')'), 'recursive' => 0));
            $situat = "Impayé";
            $impayes = $this->Piecereglementclient->find('all', array(
                'conditions' => array(
                    ('(Piecereglementclient.montant>Piecereglementclient.mantantregler or Piecereglementclient.id in(' . $p . '))'),
                    'Piecereglementclient.situation =' . "'" . $situat . "'", 'Reglementclient.client_id' => $client_id)
                , 'recursive' => 0));
            $clt = $this->Reglementclient->Client->find('first', array(
            'conditions' => array('Client.id' => $client_id)));
            $nameclt=$clt['Client']['code']." ".$clt['Client']['name'];
        }
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->loadModel('Personnel');
        $personnels = $this->Personnel->find('list');
        $this->set(compact('personnels','nameclt','id', 'impayes', 'pointdeventes', 'clients', 'client_id', 'facture', 'paiements', 'valeurs', 'facregclient', 'totalfacture', 'piecesregclient', 'retenue', 'date','bonliv'));
    }

//******************reglement libre**********************************************************************************************************************

    public function indexrl() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Famille');
        $this->loadModel('Client');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Ligneclient');

//		$familles = $this->Famille->find('list');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $cond = 'Reglementclient.Date>=' . "'" . date('Y-m-d') . "'";
        $cond1 = 'Reglementclient.Date<=' . "'" . date('Y-m-d') . "'";
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("editrl", "viewrl", "delete"))) && (CakeSession::read('Controller') == "Reglementclients"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("editrl", "viewrl", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Reglementclient']);
            } else {
                $this->request->data['Reglementclient'] = CakeSession::read('recherche');
            }
            $cond = '';
            $cond1 = '';
            $cond2 = '';
            $cond3 = '';
            $cond4 = '';
            if ($this->request->data['Reglementclient']['Date_debut'] != '__/__/____') {
                $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date_debut'])));
                $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
            }
            if ($this->request->data['Reglementclient']['Date_fin'] != '__/__/____') {
                $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date_fin'])));
                $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
            }

            if ($this->request->data['Reglementclient']['client_id']) {
                $client_id = $this->request->data['Reglementclient']['client_id'];
                $cond3 = 'Reglementclient.client_id=' . $client_id;
            }
        }
        $reglementclients = $this->Reglementclient->find('all', array(
            'order' => array('Reglementclient.id' => 'desc'),
            'conditions' => array('Reglementclient.type' => 1, @$cond, @$cond1, @$cond2, @$cond3, @$cond4)));
//        debug($reglementclients);die;

        $this->set(compact('reglementclients', 'collections', 'transferecommandebls', 'marques', 'familles', 'clients', 'ligneclients', 'marque_id', 'Date_debut', 'Date_fin', 'client_id', 'num_recu'));
    }

    public function viewrl($id = null) {
//            $lien=  CakeSession::read('lien_vente');
//               $utilisateur="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='reglements'){
//                        $utilisateur=1;
//                }}}
//              if (( $utilisateur <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }

        $this->loadModel('Piecereglementclient');
        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id), 'recursive' => 2);
        $reglement = $this->Reglementclient->find('first', $options);
        $pieceregement = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id)));
        // debug($pieceregement);die;
        $this->set(compact('reglement', 'pieceregement'));
    }

    public function addrl($client_id = 0) {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['add'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');
        $this->loadModel('Client');
        if ($this->request->is('post')) {
            // debug($this->request->data);die;
//                     foreach($this->request->data['pieceregelemnt']as $j=>$l){
//                                $li['client_id']=$client_id;
//
//                                $li['echance']=$l['echance'];
//                               $li['montant']=$l['montant'];
//                                $li['num']=$l['num_piece'];
//                            }
            $client_id = $this->request->data['Reglementclient']['client_id'];
            $this->request->data['Reglementclient']['type'] = 1;
            $this->request->data['Reglementclient']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date'])));
            $this->request->data['Reglementclient']['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data['Reglementclient']['pointdevente_id'])) {
                $this->request->data['Reglementclient']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Reglementclient']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Reglementclient']['pointdevente_id'];
            }
            $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                'conditions' => array('Reglementclient.pointdevente_id' => $pv, 'Reglementclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];
//       if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }
            } else {
                $mm = "000001";
            }


            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");

            $this->request->data['Reglementclient']['numeroconca'] = $mm;
            $this->request->data['Reglementclient']['numero'] = $numspecial;
            $this->Reglementclient->create();
            //debug($this->request->data);die;
            if ($this->Reglementclient->save($this->request->data)) {
                $reg_id = $this->Reglementclient->id;
                $this->misejour("Reglementclient", "add", $reg_id);
                $mntt = $this->request->data['Reglementclient']['Montant'];
                //debug($mntt);
                // debug($this->request->data['pieceregelemnt']);
                foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                    // debug($l);
                    //  $li['client_id']=$client_id;
                    if ($l['sup'] != 1) {
                        $lip['montant'] = $l['montant'];
                        if ($l['nameclient'] == "") {
                            $nameclients = $this->Reglementclient->Client->find('first', array('conditions' => array('Client.id' => $client_id)));
                            $lip['nameclient'] = $nameclients['Client']['code'] . " " . $nameclients['Client']['name'];
                        } else {
                            $lip['nameclient'] = $l['nameclient'];
                        }
//                                $li['num_recu']=$l['num_recu'];
                        $lip['paiement_id'] = $l['paiement_id'];
                        $lip['reglementclient_id'] = $reg_id;
                        $lip['echance'] = '';
                        $lip['num'] = '';
                        $lip['banque'] = '';
                        $lip['montant_brut'] = '';
                        $lip['montant_net'] = '';
                        $lip['to_id'] = '';
                        $lip['factureavoir_id'] = '';

                        if ($l['paiement_id'] != 1) {
                            $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                            $lip['num'] = $l['num_piece'];
                            $lip['banque'] = $l['banque'];
                        }
                        if ($l['paiement_id'] == 5) {
                            $lip['banque'] = '';
                            $lip['echance'] = '';
                            $lip['montant_brut'] = $l['montant_brut'];
                            $lip['montant_net'] = $l['montant_net'];
                            $lip['to_id'] = $l['taux'];
                        }
                        if ($l['paiement_id'] == 6) {
                            $lip['banque'] = '';
                            $lip['echance'] = '';
                            $lip['factureavoir_id'] = $l['favid'];

                            $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $l['favid']), false));
                            $this->Factureavoir->updateAll(array('Factureavoir.etat' => 2), array('Factureavoir.id' => $l['favid']));
                            $lip['num'] = $factureavoir['Factureavoir']['numero'];
                        }
                        $this->Piecereglementclient->create();
                        //debug($li);die;
                        $this->Piecereglementclient->save($lip);
//                                 $id_piece= $this->Piece->id;
//                                 $lip['piece_id']=$id_piece;
//                                 $lip['reglement_id']=$reg_id;
//                                  $this->Piecereglementclient->create();
//                                 // debug($lip);
//                                 $this->Piecereglement->save($lip);
                    }
                }
                //die;

                $this->Session->setFlash(__('The reglement has been saved'));
                $this->redirect(array('action' => 'indexrl'));
            } else {
                $this->Session->setFlash(__('The reglement could not be saved. Please, try again.'));
            }
        }
        $valeurs = $this->To->find('list');
        $facture = array();
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $paiements = $this->Paiement->find('list'); //debug($paiements);die;
        if ($client_id) {
            $facture = $this->Factureclient->find('all', array('conditions' => array('Factureclient.client_id' => $client_id, 'Factureclient.totalttc>(Factureclient.Montant_Regler)'), 'recursive' => 0));
        }


        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {
            $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                'conditions' => array('Reglementclient.pointdevente_id' => $pv, 'Reglementclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];
//  if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }
//
            } else {
                $mm = "000001";
            }

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            $mm = 0;
        }
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('mm', 'numspecial', 'clients', 'client_id', 'facture', 'paiements', 'valeurs', 'pointdeventes'));
    }

    public function editrl($id = null) {
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['edit'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglementclient'));
        }
        $piecesregclient = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id), 'recursive' => 2));  //debug($piecesregclient);die;

        $retenue = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id, 'Piecereglementclient.paiement_id' => 5), 'recursive' => 2));  //debug($piecesreg);die;

        $totalfacture = 0;
        $lignesreg = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id)));
        foreach ($lignesreg as $k => $ligne) {
            $facregclient[$ligne['Factureclient']['id']] = 1;
            $totalfacture = $totalfacture + $ligne['Factureclient']['totalttc'];
            //  aprrrr      $this->Factureclient->updateAll(array('Factureclient.Montant_Regler' => 'Factureclient.Montant_Regler-' . $ligne['Lignereglementclient']['Montant'],
            //  aprrrr      ), array('Factureclient.id' => $ligne['Lignereglementclient']['factureclient_id']));
        }
        $reglementclient = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id)));
        $client_id = $reglementclient['Reglementclient']['client_id'];
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);die;
            $this->request->data['Reglementclient']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date'])));
            if ($this->Reglementclient->save($this->request->data)) {
                $this->misejour("Reglementclient", "edit", $id);

                foreach ($piecesregclient as $piece) {
                    if ($piece['Piecereglementclient']['paiement_id'] == 6) {
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 1), array('Factureavoir.id' => $piece['Piecereglementclient']['factureavoir_id']));
                    }
                }

                //.....................................effacer  piece reglementclient , ligne reglementclient , ..........................................................................


                $this->Piecereglementclient->deleteAll(array('Piecereglementclient.reglementclient_id' => $id), false);

                //$lignesreg = $this->Lignereglementclient->find('all',array('conditions'=>array('Lignereglementclient.reglementclient_id' => $id)));  //debug($lignesreg);die;

                foreach ($lignesreg as $k => $ligne) {

                    $this->Factureclient->updateAll(array('Factureclient.Montant_Regler' => 'Factureclient.Montant_Regler-' . $ligne['Lignereglementclient']['Montant'],
                            ), array('Factureclient.id' => $ligne['Lignereglementclient']['factureclient_id']));
                }
                $this->Lignereglementclient->deleteAll(array('Lignereglementclient.reglementclient_id' => $id), false);

                //..............................fin effacer ligne reglementclient , piece reglementclient .............................................................................

                $reg_id = $id;
                $mntt = $this->request->data['Reglementclient']['Montant'];
                //debug($mntt);
                // debug($this->request->data['pieceregelemnt']);
                foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                    //debug($l);
                    //  $li['client_id']=$client_id;
                    if ($l['sup'] != 1) {
                        $lip['montant'] = $l['montant'];
                        if ($l['nameclient'] == "") {
                            $nameclients = $this->Reglementclient->Client->find('first', array('conditions' => array('Client.id' => $client_id)));
                            $lip['nameclient'] = $nameclients['Client']['code'] . " " . $nameclients['Client']['name'];
                        } else {
                            $lip['nameclient'] = $l['nameclient'];
                        }
//                                $li['num_recu']=$l['num_recu'];
                        $lip['paiement_id'] = $l['paiement_id'];
                        $lip['reglementclient_id'] = $reg_id;
                        $lip['echance'] = '';
                        $lip['num'] = '';
                        $lip['banque'] = '';
                        $lip['montant_brut'] = '';
                        $lip['montant_net'] = '';
                        $lip['to_id'] = '';
                        $lip['factureavoir_id'] = '';

                        if ($l['paiement_id'] != 1) {
                            $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                            $lip['num'] = $l['num_piece'];
                            $lip['banque'] = $l['banque'];
                        }
                        if ($l['paiement_id'] == 5) {
                            $lip['banque'] = '';
                            $lip['echance'] = '';
                            $lip['montant_brut'] = $l['montant_brut'];
                            $lip['montant_net'] = $l['montant_net'];
                            $lip['to_id'] = $l['taux'];
                        }
                        if ($l['paiement_id'] == 6) {
                            $lip['banque'] = '';
                            $lip['echance'] = '';
                            $lip['factureavoir_id'] = $l['favid'];

                            $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $l['favid']), false));
                            $this->Factureavoir->updateAll(array('Factureavoir.etat' => 2), array('Factureavoir.id' => $l['favid']));

                            if (!empty($factureavoir['Factureavoir']['numero'])) {
                                $lip['num'] = $factureavoir['Factureavoir']['numero'];
                            }
                        }
                        $this->Piecereglementclient->create();
                        //debug($li);die;
                        $this->Piecereglementclient->save($lip);
//                                 $id_piece= $this->Piece->id;
//                                 $lip['piece_id']=$id_piece;
//                                 $lip['reglement_id']=$reg_id;
//                                  $this->Piecereglementclient->create();
//                                 // debug($lip);
//                                 $this->Piecereglement->save($lip);
                    }
                }

                $this->Session->setFlash(__('The reglementclient has been saved'));
                $this->redirect(array('action' => 'indexrl'));
            } else {
                $this->Session->setFlash(__('The reglementclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id));
            $this->request->data = $this->Reglementclient->find('first', $options);
        }
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Reglementclient->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $this->set(compact('clients'));
        $valeurs = $this->To->find('list');
        $reglementclient = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id), 'recursive' => 0));
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $reglementclient['Reglementclient']['Date'])));
        $facture = array();
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Reglementclient->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $paiements = $this->Paiement->find('list'); //debug($paiements);die;
        if ($client_id) {
            $facture = $this->Factureclient->find('all', array('conditions' => array('Factureclient.client_id' => $client_id, 'Factureclient.totalttc>(Factureclient.Montant_Regler)'), 'recursive' => 0));
            //debug($bl);die;
        }
        //debug($valeurs);
        $this->set(compact('clients', 'client_id', 'facture', 'paiements', 'valeurs', 'facregclient', 'totalfacture', 'piecesregclient', 'retenue', 'date'));
    }

//******************reglement piece impay�***************************************************************************************************************

    public function indexrpi() {
        $lien = CakeSession::read('lien_vente');
        $x = "";
        //debug($lien);die;
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $x = 1;
                }
            }
        }
        if (( $x <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Famille');
        $this->loadModel('Client');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Ligneclient');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $exercices = $this->Exercice->find('list');
        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $conde = 'Reglementclient.exercice_id =' . $exe;
        $pv = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $pv = 'Reglementclient.pointdevente_id = ' . $p;
        }
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $deux = 2;
        $cond = 'Reglementclient.Date>=' . "'" . date('Y-m-d') . "'";
        $cond1 = 'Reglementclient.Date<=' . "'" . date('Y-m-d') . "'";
        if ((isset($this->request->data) && !empty($this->request->data)) || (( in_array(CakeSession::read('view'), Array("editrpi", "viewrpi", "delete"))) && (CakeSession::read('Controller') == "Reglementclients"))) {
            if ((isset($this->request->data) && !empty($this->request->data)) || ((!in_array(CakeSession::read('view'), Array("editrpi", "viewrpi", "delete"))))) {
                CakeSession::write('recherche', $this->request->data['Reglementclient']);
            } else {
                $this->request->data['Reglementclient'] = CakeSession::read('recherche');
            }
            if ($this->request->data['Reglementclient']['exercice_id']) {
                $exerciceid = $this->request->data['Reglementclient']['exercice_id'];
                $cond4 = 'Reglementclient.exercice_id =' . $exercices[$exerciceid];
            }
            if ($this->request->data['Reglementclient']['Date_debut'] != '__/__/____') {
                $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date_debut'])));
                $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
                $cond4 = '';
            }
            if ($this->request->data['Reglementclient']['Date_fin'] != '__/__/____') {
                $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date_fin'])));
                $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
                $cond4 = '';
            }

            if ($this->request->data['Reglementclient']['client_id']) {
                $client_id = $this->request->data['Reglementclient']['client_id'];
                $cond3 = 'Reglementclient.client_id=' . $client_id;
                $cond4 = '';
            }

            if (!empty($this->request->data['Reglementclient']['pointdevente_id'])) {
                $pointdeventeid = $this->request->data['Reglementclient']['pointdevente_id'];
                $cond5 = 'Reglementclient.pointdevente_id =' . $pointdeventeid;
                $cond4 = '';
            }
        }
        $condtype = 'Reglementclient.type = ' . $deux;
        $reglementclients = $this->Reglementclient->find('all', array('conditions' => array('Reglementclient.id > ' => 0, $condtype, @$pv, @$cond, @$conde, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5)));
        //debug($reglementclients);die;
        $this->set(compact('reglementclients', 'collections', 'transferecommandebls', 'marques', 'familles', 'clients', 'ligneclients', 'Date_debut', 'marque_id', 'Date_fin', 'client_id', 'exerciceid', 'num_recu', 'pointdeventes', 'exercices'));
    }

    public function viewrpi($id = null) {
//            $lien=  CakeSession::read('lien_vente');
//               $utilisateur="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='reglements'){
//                        $utilisateur=1;
//                }}}
//              if (( $utilisateur <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
//                   }

        $this->loadModel('Piecereglementclient');
        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id), 'recursive' => 2);
        $reglement = $this->Reglementclient->find('first', $options);
        $pieceregement = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id)));
        // debug($pieceregement);die;
        $this->set(compact('reglement', 'pieceregement'));
    }

    public function imprimerviewrpi($id = null) {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->loadModel('Piecereglementclient');
        $this->loadModel('Lignereglementclient');

        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglement'));
        }
        $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id), 'recursive' => 2);
        $reglement = $this->Reglementclient->find('first', $options);
        $pieceregement = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id)));

        $ligneregement = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id)));

        //debug($ligneregement);die;
        $this->set(compact('reglement', 'pieceregement', 'ligneregement'));
    }

    public function addrpi($client_id = 0, $poinvente = 0) {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['add'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Article');
        $this->loadModel('Depot');
        $this->loadModel('Lignelivraison');
        $this->loadModel('Stockdepot');
        $this->loadModel('Pointdevente');

        if ($this->request->is('post')) {
            //debug($this->request->data);
//                     foreach($this->request->data['pieceregelemnt']as $j=>$l){
//                                $li['client_id']=$client_id;
//
//                                $li['echance']=$l['echance'];
//                               $li['montant']=$l['montant'];
//                                $li['num']=$l['num_piece'];
//                            }
            $client_id = $this->request->data['Reglementclient']['client_id'];
            $this->request->data['Reglementclient']['type'] = 2;
            $this->request->data['Reglementclient']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date'])));
            $this->request->data['Reglementclient']['utilisateur_id'] = CakeSession::read('users');
            if (empty($this->request->data['Reglementclient']['pointdevente_id'])) {
                $this->request->data['Reglementclient']['pointdevente_id'] = CakeSession::read('pointdevente');
            }
            $this->request->data['Reglementclient']['exercice_id'] = date("Y");

            $pv = CakeSession::read('pointdevente');
            if ($pv == 0) {
                $pv = $this->request->data['Reglementclient']['pointdevente_id'];
            }
            $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                'conditions' => array('Reglementclient.pointdevente_id' => $pv, 'Reglementclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];
//       if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }
            } else {
                $mm = "000001";
            }


            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");

            $this->request->data['Reglementclient']['numeroconca'] = $mm;
            $this->request->data['Reglementclient']['numero'] = $numspecial;
            $this->Reglementclient->create();
            //debug($this->request->data);die;
            if ($this->Reglementclient->save($this->request->data)) {
                $reg_id = $this->Reglementclient->id;
                $this->misejour("Reglementclient", "add", $reg_id);
                $mntt = $this->request->data['Reglementclient']['Montant'];
                $montantaffecter = 0;
                //debug($mntt);
                foreach ($this->request->data['Lignereglement']as $j => $l) {
                    //debug($l);die;
                    //debug(array_key_exists('bonlivraison_id', $l));
                    if ($mntt > 0) {
                        $li['reglementclient_id'] = $reg_id;
                        //debug($l['bonlivraison_id']);
                        $li['piecereglementclient_id'] = $l['piecereglementclient_id'];
                        $id_piececlient = $l['piecereglementclient_id'];
                        $piecereglementclient = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.id' => $id_piececlient), 'recursive' => 0));

                        $mntfac = $piecereglementclient['Piecereglementclient']['montant'];
                        // debug ($mntbl);

                        if ($mntt >= $mntfac) {
                            $li['Montant'] = $mntfac;
                            $mntt = $mntt - $mntfac;
                            $mnr = $mntfac;
                        } else {
                            $li['Montant'] = $mntt;
                            $mnr = $mntt;
                            $mntt = 0;
                        }
                        $montantaffecter = $montantaffecter + $li['Montant'];
                        //die;
                        //debug($li);die;
                        $this->Piecereglementclient->updateAll(array('Piecereglementclient.reglement ' => $reg_id, 'Piecereglementclient.mantantregler ' => 'Piecereglementclient.mantantregler+' . $mnr), array('Piecereglementclient.id' => $id_piececlient));
                        $this->Lignereglementclient->create();
                        $this->Lignereglementclient->save($li);
                    }
                }
                $this->Reglementclient->updateAll(array('Reglementclient.montantaffecte' => $montantaffecter), array('Reglementclient.id' => $reg_id));
                ////die;
                // debug($this->request->data['pieceregelemnt']);
                foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                    // debug($l);
                    //  $li['client_id']=$client_id;

                    $lip['montant'] = $l['montant'];
//                                $li['num_recu']=$l['num_recu'];
                    $lip['paiement_id'] = $l['paiement_id'];
                    $lip['reglementclient_id'] = $reg_id;
                    $lip['echance'] = '';
                    $lip['num'] = '';
                    $lip['banque'] = '';
                    $lip['montant_brut'] = '';
                    $lip['montant_net'] = '';
                    $lip['to_id'] = '';
                    $lip['factureavoir_id'] = '';

                    if ($l['paiement_id'] != 1) {
                        $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                        $lip['num'] = $l['num_piece'];
                        $lip['banque'] = $l['banque'];
                    }
                    if ($l['paiement_id'] == 5) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['montant_brut'] = $l['montant_brut'];
                        $lip['montant_net'] = $l['montant_net'];
                        $lip['to_id'] = $l['taux'];
                    }
                    if ($l['paiement_id'] == 6) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['factureavoir_id'] = $l['favid'];

                        $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $l['favid']), false));
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 2), array('Factureavoir.id' => $l['favid']));
                        $lip['num'] = $factureavoir['Factureavoir']['numero'];
                    }
                    $this->Piecereglementclient->create();
                    //debug($li);die;
                    $this->Piecereglementclient->save($lip);
//                                 $id_piece= $this->Piece->id;
//                                 $lip['piece_id']=$id_piece;
//                                 $lip['reglement_id']=$reg_id;
//                                  $this->Piecereglementclient->create();
//                                 // debug($lip);
//                                 $this->Piecereglement->save($lip);
                }
                //die;

                $this->Session->setFlash(__('The reglement has been saved'));
                $this->redirect(array('action' => 'indexrpi'));
            } else {
                $this->Session->setFlash(__('The reglement could not be saved. Please, try again.'));
            }
        }
        $valeurs = $this->To->find('list');
        $facture = array();
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Reglementclient->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $paiements = $this->Paiement->find('list'); //debug($paiements);die;

        $situat = "Impaye";
        if ($client_id) {
//            $facture = $this->Piecereglementclient->find('all', array(
//                'conditions' => array('Piecereglementclient.reglement' => 0
//                    , 'Piecereglementclient.situation'=>"'".$situat."'")
//                , 'recursive' => 0));

            $facture = $this->Piecereglementclient->find('all', array(
                'conditions' => array(
                    'Piecereglementclient.situation =' . "'" . $situat . "'", 'Piecereglementclient.montant>Piecereglementclient.mantantregler')
                , 'recursive' => 0));

            // debug($facture);die;
        }


        $pv = CakeSession::read('pointdevente');
        if ($pv != 0) {
            $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                'conditions' => array('Reglementclient.pointdevente_id' => $pv, 'Reglementclient.exercice_id' => date("Y")))
            );
            //debug($numero);die;
            foreach ($numero as $num) {
                $n = $num[0]['num'];
            }
            if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];
//  if ($anne==date("Y")){
                $lastnum = $n;
                $nume = intval($lastnum) + 1;
                $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }
//
            } else {
                $mm = "000001";
            }

            $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $pv)));
            $abrivation = $pointvente['Pointdevente']['abriviation'];
            $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
        } else {
            if ($poinvente) {
                $numero = $this->Reglementclient->find('all', array('fields' => array('MAX(Reglementclient.numeroconca) as num'),
                    'conditions' => array('Reglementclient.pointdevente_id' => $poinvente, 'Reglementclient.exercice_id' => date("Y")))
                );
                //debug($numero);die;
                foreach ($numero as $num) {
                    $n = $num[0]['num'];
                }
                if (!empty($n)) {
//   $getexercice= $this->Reglementclient->find('first',array('conditions'=>array('Reglementclient.numeroconca'=>$n)));
//  $anne=$getexercice['Reglementclient']['exercice_id'];
//  if ($anne==date("Y")){
                    $lastnum = $n;
                    $nume = intval($lastnum) + 1;
                    $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
//            }
//           else {
//                $mm = "000001";
//            }
//
                } else {
                    $mm = "000001";
                }

                $pointvente = $this->Pointdevente->find('first', array('conditions' => array('Pointdevente.id' => $poinvente)));
                $abrivation = $pointvente['Pointdevente']['abriviation'];
                $numspecial = $abrivation . "/" . $mm . "/" . date("Y");
            } else {
                $mm = 0;
            }
        }
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $this->set(compact('poinvente', 'mm', 'numspecial', 'clients', 'client_id', 'facture', 'paiements', 'valeurs', 'pointdeventes'));
    }

    public function editrpi($id = null) {
        $this->loadModel('Factureclient');
        $this->loadModel('Factureavoir');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['edit'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        if (!$this->Reglementclient->exists($id)) {
            throw new NotFoundException(__('Invalid reglementclient'));
        }
        $piecesregclient = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id), 'recursive' => 2));  //debug($piecesregclient);die;
        $retenue = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id, 'Piecereglementclient.paiement_id' => 5), 'recursive' => 2));  //debug($piecesreg);die;
        $totalfacture = 0;

        $lignesreg = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id)));
        foreach ($lignesreg as $k => $ligne) {
            $facregclient[$ligne['Piecereglementclient']['id']] = 1;
            $totalfacture = $totalfacture + $ligne['Piecereglementclient']['montant'];
            //  aprrrr      $this->Factureclient->updateAll(array('Factureclient.Montant_Regler' => 'Factureclient.Montant_Regler-' . $ligne['Lignereglementclient']['Montant'],
            //  aprrrr      ), array('Factureclient.id' => $ligne['Lignereglementclient']['factureclient_id']));
        }
        $reglementclient = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id)));
        $client_id = $reglementclient['Reglementclient']['client_id'];
        if ($this->request->is('post') || $this->request->is('put')) {
            // debug($this->request->data);die;
            $this->request->data['Reglementclient']['Date'] = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Reglementclient']['Date'])));
            if ($this->Reglementclient->save($this->request->data)) {
                $this->misejour("Reglementclient", "edit", $id);

                foreach ($piecesregclient as $piece) {
                    if ($piece['Piecereglementclient']['paiement_id'] == 6) {
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 1), array('Factureavoir.id' => $piece['Piecereglementclient']['factureavoir_id']));
                    }
                }

                //.....................................effacer  piece reglementclient , ligne reglementclient , ..........................................................................


                $this->Piecereglementclient->deleteAll(array('Piecereglementclient.reglementclient_id' => $id), false);

                //$lignesreg = $this->Lignereglementclient->find('all',array('conditions'=>array('Lignereglementclient.reglementclient_id' => $id)));  //debug($lignesreg);die;

                foreach ($lignesreg as $k => $ligne) {
                    // $lignesreg = $this->Lignereglementclient->find('first', array('conditions' => array('Lignereglementclient.piecereglementclient_id' => $piece['Piecereglementclient']['id'])));
                    $this->Piecereglementclient->updateAll(array('Piecereglementclient.reglement' => 0, 'Piecereglementclient.mantantregler ' => 'Piecereglementclient.mantantregler-' . $ligne['Lignereglementclient']['Montant']), array('Piecereglementclient.id' => $ligne['Lignereglementclient']['piecereglementclient_id']));
                }
                $this->Lignereglementclient->deleteAll(array('Lignereglementclient.reglementclient_id' => $id), false);

                //..............................fin effacer ligne reglementclient , piece reglementclient .............................................................................
                //debug($this->request->data);die;
                $reg_id = $id;
                $mntt = $this->request->data['Reglementclient']['Montant'];
                $montantaffecter = 0;
                //debug($mntt);
                foreach ($this->request->data['Lignereglement']as $j => $l) {
                    //debug($l);die;
                    //debug(array_key_exists('bonlivraison_id', $l));
                    if ($mntt > 0) {
                        $li['reglementclient_id'] = $reg_id;
                        //debug($l['bonlivraison_id']);
                        $li['piecereglementclient_id'] = $l['piecereglementclient_id'];
                        $id_piececlient = $l['piecereglementclient_id'];
                        $piecereglementclient = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.id' => $id_piececlient), 'recursive' => 0));

                        $mntfac = $piecereglementclient['Piecereglementclient']['montant'];

                        // debug ($mntbl);

                        if ($mntt >= $mntfac) {
                            $li['Montant'] = $mntfac;
                            $mntt = $mntt - $mntfac;
                            $mnr = $mntfac;
                        } else {
                            $li['Montant'] = $mntt;
                            $mnr = $mntt;
                            $mntt = 0;
                        }
                        $montantaffecter = $montantaffecter + $li['Montant'];
                        //die;
                        //debug($li);die;
                        $this->Piecereglementclient->updateAll(array('Piecereglementclient.reglement ' => $reg_id, 'Piecereglementclient.mantantregler ' => 'Piecereglementclient.mantantregler+' . $mnr), array('Piecereglementclient.id' => $id_piececlient));
                        $this->Lignereglementclient->create();
                        $this->Lignereglementclient->save($li);
                    }
                }
                $this->Reglementclient->updateAll(array('Reglementclient.montantaffecte' => $montantaffecter), array('Reglementclient.id' => $reg_id));
                ////die;
                // debug($this->request->data['pieceregelemnt']);
                foreach ($this->request->data['pieceregelemnt']as $j => $l) {
                    //debug($l);
                    //  $li['client_id']=$client_id;

                    $lip['montant'] = $l['montant'];
//                                $li['num_recu']=$l['num_recu'];
                    $lip['paiement_id'] = $l['paiement_id'];
                    $lip['reglementclient_id'] = $reg_id;
                    $lip['echance'] = '';
                    $lip['num'] = '';
                    $lip['banque'] = '';
                    $lip['montant_brut'] = '';
                    $lip['montant_net'] = '';
                    $lip['to_id'] = '';
                    $lip['factureavoir_id'] = '';

                    if ($l['paiement_id'] != 1) {
                        $lip['echance'] = date("Y-m-d", strtotime(str_replace('/', '-', $l['echance'])));
                        $lip['num'] = $l['num_piece'];
                        $lip['banque'] = $l['banque'];
                    }
                    if ($l['paiement_id'] == 5) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['montant_brut'] = $l['montant_brut'];
                        $lip['montant_net'] = $l['montant_net'];
                        $lip['to_id'] = $l['taux'];
                    }
                    if ($l['paiement_id'] == 6) {
                        $lip['banque'] = '';
                        $lip['echance'] = '';
                        $lip['factureavoir_id'] = $l['favid'];

                        $factureavoir = $this->Factureavoir->find('first', array('conditions' => array('Factureavoir.id' => $l['favid']), false));
                        $this->Factureavoir->updateAll(array('Factureavoir.etat' => 2), array('Factureavoir.id' => $l['favid']));

                        if (!empty($factureavoir['Factureavoir']['numero'])) {
                            $lip['num'] = $factureavoir['Factureavoir']['numero'];
                        }
                    }
                    $this->Piecereglementclient->create();
                    //debug($li);die;
                    $this->Piecereglementclient->save($lip);
                }



                $this->Session->setFlash(__('The reglementclient has been saved'));
                $this->redirect(array('action' => 'indexrpi'));
            } else {
                $this->Session->setFlash(__('The reglementclient could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Reglementclient.' . $this->Reglementclient->primaryKey => $id));
            $this->request->data = $this->Reglementclient->find('first', $options);
        }
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Reglementclient->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $this->set(compact('clients'));
        $valeurs = $this->To->find('list');
        $reglementclient = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id), 'recursive' => 0));
        $date = date("d/m/Y", strtotime(str_replace('-', '/', $reglementclient['Reglementclient']['Date'])));
        $facture = array();
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Reglementclient->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $paiements = $this->Paiement->find('list'); //debug($paiements);die;
        $situat = "Impaye";
        if ($client_id) {

            $facture = $this->Piecereglementclient->find('all', array(
                'conditions' => array(
                    // 'Piecereglementclient.reglement' => $id ,
                    ('(Piecereglementclient.reglement=0 or Piecereglementclient.reglement=' . "'" . $id . "'" . ')'),
                    'Piecereglementclient.situation =' . "'" . $situat . "'")
                , 'recursive' => 0));

            // debug($facture);die;
        }
        //debug($valeurs);
        $this->set(compact('clients', 'id', 'client_id', 'facture', 'paiements', 'valeurs', 'facregclient', 'totalfacture', 'piecesregclient', 'retenue', 'date'));
    }

    public function delete($id = null) {
        $this->loadModel('Reglementclient');
        $this->loadModel('Factureclient');
        $this->loadModel('Paiement');
        $this->loadModel('To');
        $this->loadModel('Lignereglementclient');
        $this->loadModel('Piecereglementclient');
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['delete'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }

        $this->Reglementclient->id = $id;
        if (!$this->Reglementclient->exists()) {
            throw new NotFoundException(__('Invalid reglementclient'));
        }
        $abcd = $this->Reglementclient->find('first', array('conditions' => array('Reglementclient.id' => $id), 'recursive' => -1));
        $numansar = $abcd['Reglementclient']['numero'];
        $pvansar = $abcd['Reglementclient']['pointdevente_id'];
        $this->request->onlyAllow('post', 'delete');
        if ($this->Reglementclient->delete()) {
            $this->misejour("Reglementclient", $numansar, $id,$pvansar);
            $piecesregclient = $this->Piecereglementclient->find('all', array('conditions' => array('Piecereglementclient.reglementclient_id' => $id), 'recursive' => 2));  //debug($piecesregclient);die;
            foreach ($piecesregclient as $piece) {
                if ($piece['Piecereglementclient']['paiement_id'] == 6) {
                    $this->Factureavoir->updateAll(array('Factureavoir.etat' => 1), array('Factureavoir.id' => $piece['Piecereglementclient']['factureavoir_id']));
                }
            }
            $this->Piecereglementclient->deleteAll(array('Piecereglementclient.reglementclient_id' => $id), false);
            $lignesreg = $this->Lignereglementclient->find('all', array('conditions' => array('Lignereglementclient.reglementclient_id' => $id)));
            if (!empty($lignesreg)) {
            foreach ($lignesreg as $k => $ligne) {
                if (!empty($ligne['Lignereglementclient']['factureclient_id'])) {
                    $this->Factureclient->updateAll(array('Factureclient.Montant_Regler' => 'Factureclient.Montant_Regler-' . $ligne['Lignereglementclient']['Montant'],
                            ), array('Factureclient.id' => $ligne['Lignereglementclient']['factureclient_id']));
                }
                if (!empty($ligne['Lignereglementclient']['piecereglementclient_id'])) {
                    $this->Piecereglementclient->updateAll(array('Piecereglementclient.mantantregler' => 'Piecereglementclient.mantantregler-' . $ligne['Lignereglementclient']['Montant'],
                            ), array('Piecereglementclient.id' => $ligne['Lignereglementclient']['piecereglementclient_id']));
                }
//                $this->Factureclient->updateAll(array('Factureclient.Montant_Regler' => 'Factureclient.Montant_Regler-' . $ligne['Lignereglementclient']['Montant'],
//                        ), array('Factureclient.id' => $ligne['Lignereglementclient']['factureclient_id']));
            }
        }
            $this->Lignereglementclient->deleteAll(array('Lignereglementclient.reglementclient_id' => $id), false);
            $this->Session->setFlash(__('Reglementclient deleted'));
            CakeSession::write('view', "delete");
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Reglementclient was not deleted'));
        //$this->redirect(array('action' => 'index'));
    }

    public function getfactureavoirs() {
        $this->layout = null;
        $this->loadModel('Factureavoir');
        $data = $this->request->data;

        $clientid = $data['clientid'];
        $index = $data['index'];
        //$name='piecereglementclient_id';
        $factureavoirs = $this->Factureavoir->find('all', array('conditions' => array('Factureavoir.client_id' => $clientid, 'Factureavoir.etat' => 1), 'recursive' => -1));

        $id = 'factureavoir_id' . $index;
        if ($clientid != 0) {
            $select = "<select   name='data[pieceregelemnt][$index][num_piece]' id='$id' table='pieceregelemnt' index='$index' champ='factureavoir_id0' id='factureavoir_id0' class='select form-control'  onchange='getmontantfav(" . $index . ")'><option selected disabled hidden value=0> Veuillez choisir</option>";
            foreach ($factureavoirs as $p) {
                $select = $select . "<option value=" . $p['Factureavoir']['id'] . ">" . $p['Factureavoir']['numero'] . "</option>";
            }
            $select = $select . '</select>';
        }
        echo $select;
        die();
    }

//a faire  !!!!!!!!
    public function indexpc() {
        $lien = CakeSession::read('lien_vente');
        $vente = "";
        if (!empty($lien)) {
            foreach ($lien as $k => $liens) {
                if (@$liens['lien'] == 'reglementclients') {
                    $vente = $liens['imprimer'];
                }
            }
        }
        if (( $vente <> 1) || (empty($lien))) {
            $this->redirect(array('controller' => 'utilisateurs', 'action' => 'login'));
        }
        $this->loadModel('Piecereglementclient');
        $this->loadModel('Client');
        $this->loadModel('Compte');
        $this->loadModel('Paiement');
        $this->loadModel('Personnel');
        $this->loadModel('Utilisateur');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Reglementclient->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $comptes = $this->Compte->find('all');
        $piecereglementclients = array();
        $recherche = 0;
        $zero = 0;
        if (CakeSession::read('users') != 15 && CakeSession::read('users') != 12 && CakeSession::read('users') != 17) {
            $conduser = "Reglementclient.utilisateur_id=" . CakeSession::read('users');
        }
        $cond0 = "Piecereglementclient.reglement='" . $zero . "'";
        $situation = array();
        $situation2 = array();
        $compte_id = array();
        $compte2_id = array();
        if ($this->request->is('post') || $this->request->is('put')) {
            $cond = '';
            $cond1 = '';
            $cond2 = '';
            $cond3 = '';
            $cond4 = '';
            $cond5 = '';
            $cond6 = '';
            $cond7 = '';

            //debug($this->request->data);die;

            if ($this->request->data['Piecereglementclient']['Date_debut'] != '__/__/____') {
                $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Piecereglementclient']['Date_debut'])));
                $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
            }
            if ($this->request->data['Piecereglementclient']['Date_fin'] != '__/__/____') {
                $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Piecereglementclient']['Date_fin'])));
                $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
            }
            if ($this->request->data['Piecereglementclient']['Date_deb'] != '__/__/____') {
                $Date_deb = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Piecereglementclient']['Date_deb'])));
                $cond2 = 'Piecereglementclient.echance>=' . "'" . $Date_deb . "'";
            }
            if ($this->request->data['Piecereglementclient']['Date_fn'] != '__/__/____') {
                $Date_fn = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Piecereglementclient']['Date_fn'])));
                $cond3 = 'Piecereglementclient.echance<=' . "'" . $Date_fn . "'";
            }
            if ($this->request->data['Piecereglementclient']['client_id']) {
                $client_id = $this->request->data['Piecereglementclient']['client_id'];
                $cond4 = 'Reglementclient.client_id=' . $client_id;
            }
            if ((isset($this->request->data['Piecereglementclient']['personnel_id'])) && !empty($this->request->data['Piecereglementclient']['personnel_id'])) {
                //debug($this->request->data['Piecereglementclient']['personnel_id']);die;
                $personnel_id = $this->request->data['Piecereglementclient']['personnel_id'];
                $utilisateur = $this->Utilisateur->find('first', array('conditions' => array('Utilisateur.personnel_id' => $personnel_id), 'recursive' => -1));  //debug($piecesreg);die;
                $conduser = 'Reglementclient.utilisateur_id=' . $utilisateur['Utilisateur']['id'];
            }
            $s = "En attente";
            //$condst="Piecereglementclient.situation='".$s."'";
            if (isset($this->request->data['Piecereglementclient']['situation'])) {
                $situation = $this->request->data['Piecereglementclient']['situation'];
                $t = '("0"';
                foreach ($situation as $ad) {
                    $t = $t . ',"' . $ad . '"';
                }
                $t = $t . ')';
                //$cond6 = "Piecereglement.situation in" . $t;
                $cond6 = "Piecereglementclient.situation in" . $t;
                $tt = '/0/';
                foreach ($situation as $ad) {
                    $tt = $tt . ',/' . $ad . '/';
                }
                $situationipm = $tt;
                $condst = "";
            }
            if (isset($this->request->data['Piecereglementclient']['situation2'])) {
                $situation2 = $this->request->data['Piecereglementclient']['situation2'];

                $t = '("0"';
                foreach ($situation2 as $ad) {
                    $t = $t . ',"' . $ad . '"';
                }
                $t = $t . ')';
                //$cond6 = "Piecereglement.situation in" . $t;
                $cond9 = "Piecereglementclient.situation not in" . $t;
                $tt = '/0/';
                foreach ($situation2 as $ad) {
                    $tt = $tt . ',/' . $ad . '/';
                }
                $situationimpN = $tt;
                $condst = "";
                //debug($situationimpN);die;
            }
            if (isset($this->request->data['Piecereglementclient']['compte_id'])) {
                $compte_id = $this->request->data['Piecereglementclient']['compte_id'];
                $t = '(0';
                foreach ($compte_id as $ad) {
                    $t = $t . ',' . $ad;
                }
                $t = $t . ')';
                //$cond6 = "Piecereglement.situation in" . $t;
                $cond7 = "Piecereglementclient.compte_id in " . $t;
                $comptev = $t;
                $tt = '/0/';
                foreach ($compte_id as $ad) {
                    $tt = $tt . ',/' . $ad . '/';
                }
                $compte_idimp = $tt;
            }
            if (isset($this->request->data['Piecereglementclient']['compte2_id'])) {
                $compte2_id = $this->request->data['Piecereglementclient']['compte2_id'];
                $t = '(0';
                foreach ($compte2_id as $ad) {
                    $t = $t . ',' . $ad;
                }
                $t = $t . ')';
                //$cond6 = "Piecereglement.situation in" . $t;
                $cond10 = "Piecereglementclient.compte_id not in " . $t;
                $compte_el = $t;
                $tt = '/0/';
                foreach ($compte2_id as $ad) {
                    $tt = $tt . ',/' . $ad . '/';
                }
                $compte_idimpN = $tt;
            }
            if ($this->request->data['Piecereglementclient']['paiement_id']) {
                $paiement_id = $this->request->data['Piecereglementclient']['paiement_id'];
                $t = '(0';
                foreach ($paiement_id as $ad) {
                    $t = $t . ',' . $ad;
                }
                $t = $t . ')';
                //$cond6 = "Piecereglement.situation in" . $t;
                $cond8 = "Piecereglementclient.paiement_id in" . $t;
                $tt = '/0/';
                foreach ($paiement_id as $ad) {
                    $tt = $tt . ',/' . $ad . '/';
                }
                $paiement_idimp = $tt;
            }
            if ($this->request->data['Piecereglementclient']['paiement2_id']) {
                $paiement2_id = $this->request->data['Piecereglementclient']['paiement2_id'];
                $t = '(0';
                foreach ($paiement2_id as $ad) {
                    $t = $t . ',' . $ad;
                }
                $t = $t . ')';
                //$cond6 = "Piecereglement.situation in" . $t;
                $cond11 = "Piecereglementclient.paiement_id not in" . $t;
                $tt = '/0/';
                foreach ($paiement2_id as $ad) {
                    $tt = $tt . ',/' . $ad . '/';
                }
                $paiement_idimpN = $tt;
            }
            $recherche = 1;
            // debug($this->request->data);die;
        }
        $piecereglementclients = $this->Piecereglementclient->find('all', array('order' => array('Piecereglementclient.echance' => 'ASC'), 'conditions' => array('Piecereglementclient.valide=0', @$condst, @$cond0, @$cond, @$cond1, @$cond2, @$cond3, @$cond4, @$cond5, @$cond6, @$cond7, @$cond8, @$cond9, @$cond10, @$cond11, @$conduser), 'recursive' => 1));
        //debug($this->request->data['Piecereglementclient']);
        // debug($compte_id);
        // debug($situation);
        // foreach ($situation as $k=>$s){  if($s =="Verse"){ debug("helmi");die; }}
        //debug($situation2);die;
        $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id in (1,2,3,4)')));
        $paiement2s = $this->Paiement->find('list', array('conditions' => array('Paiement.id in (1,2,3,4)')));
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Reglementclient->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $personnels = $this->Personnel->find('list');
        $this->set(compact('personnels', 'clients', 'compte2_id', 'comptev', 'compte_el', 'situationimpN', 'compte_idimpN', 'paiement_idimpN', 'situation2', 'paiement2s', 'situationipm', 'compte_idimp', 'paiement_idimp', 'recherche', 'paiement_id', 'piecereglementclients', 'paiements', 'clients', 'comptes', 'Date_debut', 'Date_fin', 'Date_deb', 'Date_fn', 'client_id', 'num_recu', 'situation', 'compte_id'));
    }

    public function recap_envoyer_piecereglement($piecereglement_id) {
        $this->loadModel('Piecereglementclient');
        $this->layout = null;
        $test = 1;
        $this->Piecereglementclient->updateAll(array('Piecereglementclient.envoye' => 1), array('Piecereglementclient.id in (' . $piecereglement_id . '0)'));
        echo json_encode(array('test' => $test));
        die();
    }

    public function imprimerindexpc() {

        $this->loadModel('Piecereglementclient');
        $this->loadModel('Client');
        $this->loadModel('Compte');
        $this->loadModel('Paiement');

        //debug($this->request->query);die;


        $piecereglementclients = array();
        if (!empty($this->request->query['Date_debut'])) {
            $Date_debut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_debut'])));
            $cond = 'Reglementclient.Date>=' . "'" . $Date_debut . "'";
        }
        if (!empty($this->request->query['Date_fin'])) {
            $Date_fin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_fin'])));
            $cond1 = 'Reglementclient.Date<=' . "'" . $Date_fin . "'";
        }
        if (!empty($this->request->query['Date_deb'])) {
            $Date_deb = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_deb'])));
            $cond2 = 'Piecereglementclient.echance>=' . "'" . $Date_deb . "'";
        }
        if (!empty($this->request->query['Date_fn'])) {
            $Date_fn = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->query['Date_fn'])));
            $cond3 = 'Piecereglementclient.echance<=' . "'" . $Date_fn . "'";
        }
        if (!empty($this->request->query['client_id'])) {
            $client_id = $this->request->query['client_id'];
            $cond4 = 'Reglementclient.client_id=' . $client_id;
        }
        if (!empty($this->request->query['situation'])) {
            $situation = $this->request->query['situation'];
            $situationn = str_replace('/', '"', $situation);
            $cond6 = "Piecereglementclient.situation in (" . $situationn . ')';
            //debug($cond6);die;
        }
        if (!empty($this->request->query['situation2'])) {
            $situation2 = $this->request->query['situation2'];
            $situationn2 = str_replace('/', '"', $situation2);
            $cond9 = "Piecereglementclient.situation not in (" . $situationn2 . ')';
            //debug($cond6);die;
        }
//        if (!empty($this->request->query['situation'])) {
//            $situation = $this->request->query['situation'];
//            $cond6 = "Piecereglementclient.situation='" . $situation . "'";
//        }

        if (!empty($this->request->query['compte_id'])) {
            $compte_id = $this->request->query['compte_id'];
            $compte_id = str_replace('/', '"', $compte_id);
            $cond7 = "Piecereglementclient.compte_id in (" . $compte_id . ')';
        }
        if (!empty($this->request->query['compte2_id'])) {
            $compte2_id = $this->request->query['compte2_id'];
            $compte2_id = str_replace('/', '"', $compte2_id);
            $cond10 = "Piecereglementclient.compte_id not in (" . $compte2_id . ')';
        }
        if (!empty($this->request->query['paiement_id'])) {
            $paiement_id = $this->request->query['paiement_id'];
            $paiement_id = str_replace('/', '"', $paiement_id);
            $cond8 = "Piecereglementclient.paiement_id in (" . $paiement_id . ')';
        }
        if (!empty($this->request->query['paiement2_id'])) {
            $paiement2_id = $this->request->query['paiement2_id'];
            $paiement2_id = str_replace('/', '"', $paiement2_id);
            $cond11 = "Piecereglementclient.paiement_id not in (" . $paiement2_id . ')';
        }





//        if (!empty($this->request->query['compte_id'])) {
//            $compte_id = $this->request->query['compte_id'];
//            $cond7 = "Piecereglementclient.compte_id='" . $compte_id . "'";
//        }
//        if (!empty($this->request->query['paiement_id'])) {
//            $paiement_id = $this->request->query['paiement_id'];
//            $cond8 = "Piecereglementclient.paiement_id='" . $paiement_id . "'";
//        }


        $piecereglementclients = $this->Piecereglementclient->find('all', array('order' => array('Piecereglementclient.echance' => 'ASC'), 'conditions' => array('Piecereglementclient.id > ' => 0, @$cond, @$cond1, @$cond2, @$cond3, @$cond4, @$cond6, @$cond7, @$cond8, @$cond9, @$cond10, @$cond11), 'recursive' => 0));
        //debug($piecereglements);die;
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Reglementclient->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $comptes = $this->Compte->find('list');
        $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id in (1,2,3,4)')));
        $this->set(compact('recherche', 'paiement_id', 'piecereglementclients', 'paiements', 'clients', 'comptes', 'Date_debut', 'Date_fin', 'Date_deb', 'Date_fn', 'client_id', 'num_recu', 'situation', 'compte_id'));
    }

    public function indexpcc($utilisateur_id = null) {

        $this->loadModel('Piecereglementclient');
        $this->loadModel('Client');
        $this->loadModel('Compte');
        $this->loadModel('Paiement');
        $this->loadModel('Personnel');
        $this->loadModel('Utilisateur');
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Reglementclient->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $comptes = $this->Compte->find('all');
        $piecereglementclients = array();
        $recherche = 0;
        $zero = 0;
        if ($this->request->is('post') || $this->request->is('put')) {
            //debug($this->request->data);
            foreach ($this->request->data['Piecereglementclient']['chec_piece_id'] as $k => $piece) {
                $piecereglementclient = $this->Piecereglementclient->find('first', array('conditions' => array('Piecereglementclient.id' => $piece), 'recursive' => 1));
                //debug($piecereglementclient);
                if ($piecereglementclient['Piecereglementclient']['paiement_id'] == 1) {
                    $tab['utilisateur_id'] = CakeSession::read('users');
                    $tab['compte_id'] = 6;
                    $this->loadModel('Versement');
                    $numero = $this->Versement->find('all', array('fields' => array('MAX(Versement.numero) as num')));
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
                    $tab['numero'] = $mm;
                    $tab['date'] = date("Y-m-d");
                    $tab['montant'] = $piecereglementclient['Piecereglementclient']['montant'];
                    $tab['etat'] = 0;
                    $personnel = $this->Utilisateur->find('first', array('conditions' => array('Utilisateur.id' => $piecereglementclient['Reglementclient']['utilisateur_id'])));
                    $tab['observation'] = "Caisse " . $personnel['Personnel']['name'];
                    $this->Versement->create();
                    $this->Versement->save($tab);
                    $this->Piecereglementclient->updateAll(array('Piecereglementclient.valide' => 1, 'Piecereglementclient.situation' => "'On caissé'"), array('Piecereglementclient.id  =' . $piece));
                } else {
                    $this->Piecereglementclient->updateAll(array('Piecereglementclient.valide' => 1), array('Piecereglementclient.id  =' . $piece));
                }
            }
            //die;
        }
        $conduser = "Reglementclient.utilisateur_id=" . $utilisateur_id;

        $piecereglementclients = $this->Piecereglementclient->find('all', array('order' => array('Piecereglementclient.echance' => 'ASC'), 'conditions' => array('Piecereglementclient.envoye=1', 'Piecereglementclient.valide=0', @$conduser), 'recursive' => 1));

        $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id in (1,2,3,4)')));
        $paiement2s = $this->Paiement->find('list', array('conditions' => array('Paiement.id in (1,2,3,4)')));
        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Reglementclient->Client->find('list', array(
            'conditions' => array('Client.societe' => $composantsoc)
        ));
        $personnels = $this->Personnel->find('list');
        $this->set(compact('personnels', 'clients', 'compte2_id', 'comptev', 'compte_el', 'situationimpN', 'compte_idimpN', 'paiement_idimpN', 'situation2', 'paiement2s', 'situationipm', 'compte_idimp', 'paiement_idimp', 'recherche', 'paiement_id', 'piecereglementclients', 'paiements', 'clients', 'comptes', 'Date_debut', 'Date_fin', 'Date_deb', 'Date_fn', 'client_id', 'num_recu', 'situation', 'compte_id'));
    }

    public function etatrecette() {
        $this->loadModel('Client');
        $this->loadModel('Paiement');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');


        CakeSession::delete('datereglement1');
        CakeSession::delete('dateecheance1');
        CakeSession::delete('datebordereau1');
        CakeSession::delete('clientcode');
        CakeSession::delete('paiement_id');
        CakeSession::delete('datereglement2');
        CakeSession::delete('dateecheance2');
        CakeSession::delete('datebordereau2');
        CakeSession::delete('triagereglement');
        CakeSession::delete('encaissement_id');
        CakeSession::delete('anneereglement');


        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];

        $composantsoc = CakeSession::read('composantsoc');
        $clients = $this->Client->find('list', array(
            'conditions' => array('Client.etat' => 1, 'Client.societe' => $composantsoc)
        ));
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));

        $triages = array();
        $triages['Parnumfacture'] = "Par N° reglement";
        $triages['Pardate'] = "Par date echeance";
        $triages['Parcodeclient'] = "Par code client";



        $encaissements = array();
        $encaissements['Tous'] = "Tous";
        $encaissements['AvecBordereau'] = "Avec Bordereau";
        $encaissements['SansBordereau'] = "Sans Bordereau";

        $paiements = $this->Paiement->find('list', array('conditions' => array('Paiement.id < ' => 6, 'Paiement.id <> ' => 4)));
        $exercices = $this->Exercice->find('list');

        $this->set(compact('pointdeventes', 't', 'exercices', 'exerciceid', 'reglements', 'triages', 'encaissements', 'paiements', 'zones', 'pointdeventeid', 'client_id', 'exercice_id', 'pointdeventes', 'clientid', 'date1', 'date2', 'clients', 'exercices', 'exerciceid', 'types'));
    }

    public function etatrecettesession() {
        CakeSession::delete('datereglement1');
        CakeSession::delete('dateecheance1');
        CakeSession::delete('datebordereau1');
        CakeSession::delete('clientcode');
        CakeSession::delete('paiement_id');
        CakeSession::delete('datereglement2');
        CakeSession::delete('dateecheance2');
        CakeSession::delete('datebordereau2');
        CakeSession::delete('triagereglement');
        CakeSession::delete('encaissement_id');
        CakeSession::delete('anneereglement');
        CakeSession::delete('pointdevente_id_recette');
        //print_r($this->request->data);die;
        $datereglement1 = $this->request->data['datereglement1'];
        $datereglement1 = date("Y-m-d", strtotime(str_replace('/', '-', $datereglement1)));
        $datereglement2 = $this->request->data['datereglement2'];
        $datereglement2 = date("Y-m-d", strtotime(str_replace('/', '-', $datereglement2)));
        $dateecheance1 = $this->request->data['dateecheance1'];
        $dateecheance1 = date("Y-m-d", strtotime(str_replace('/', '-', $dateecheance1)));
        $dateecheance2 = $this->request->data['dateecheance2'];
        $dateecheance2 = date("Y-m-d", strtotime(str_replace('/', '-', $dateecheance2)));
        $datebordereau1 = $this->request->data['datebordereau1'];
        $datebordereau1 = date("Y-m-d", strtotime(str_replace('/', '-', $datebordereau1)));
        $datebordereau2 = $this->request->data['datebordereau2'];
        $datebordereau2 = date("Y-m-d", strtotime(str_replace('/', '-', $datebordereau2)));

        $paiement_id = $this->request->data['paiement_id'];
        $pointdevente_id = $this->request->data['pointdevente_id'];
        $triagereglement = $this->request->data['triagereglement'];
        $encaissement_id = $this->request->data['encaissement_id'];
        $clientcode = $this->request->data['clientcode'];
        $anneereglement = $this->request->data['anneereglement'];

        CakeSession::write('datereglement1', $datereglement1);
        CakeSession::write('dateecheance1', $dateecheance1);
        CakeSession::write('datebordereau1', $datebordereau1);
        CakeSession::write('clientcode', $clientcode);
        CakeSession::write('paiement_id', $paiement_id);
        CakeSession::write('datereglement2', $datereglement2);
        CakeSession::write('dateecheance2', $dateecheance2);
        CakeSession::write('datebordereau2', $datebordereau2);
        CakeSession::write('triagereglement', $triagereglement);
        CakeSession::write('encaissement_id', $encaissement_id);
        CakeSession::write('anneereglement', $anneereglement);
        CakeSession::write('pointdevente_id_recette', $pointdevente_id);
        echo true;
        die;
    }

    public function imprimeravecdetails() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));

        $this->loadModel('Exercice');
        $this->loadModel('Client');
        $this->loadModel('Paiement');

        $this->response->type('pdf');
        $this->layout = 'pdf';

        //debug($this->request->query);die;

        $datereglement1 = CakeSession::read('datereglement1');
        $dateecheance1 = CakeSession::read('dateecheance1');
        $datebordereau1 = CakeSession::read('datebordereau1');
        $clientcode = CakeSession::read('clientcode');
        $paiement_id = CakeSession::read('paiement_id');
        $datereglement2 = CakeSession::read('datereglement2');
        $dateecheance2 = CakeSession::read('dateecheance2');
        $datebordereau2 = CakeSession::read('datebordereau2');
        $triagereglement = CakeSession::read('triagereglement');
        $encaissement_id = CakeSession::read('encaissement_id');
        $anneereglement = CakeSession::read('anneereglement');
        $pointdevente_id_recette = CakeSession::read('pointdevente_id_recette');

        //debug($datereglement1);die;;
        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condf4 = 'Reglementclient.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Reglementclient.pointdevente_id = ' . $p;
        }


        //debug($this->request->query); //die;
        if (isset($anneereglement)) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $exerciceinfo = $this->Exercice->find('first', array('conditions' => array('Exercice.id' => $anneereglement)));
            $condannee = 'Reglementclient.exercice_id=' . $exerciceinfo['Exercice']['name'];
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        }
        if ($datereglement1 != "__/__/____" && $datereglement1 != "1970-01-01") {
            $conddatereg = 'Reglementclient.Date >= ' . "'" . $datereglement1 . "'";
            $condannee = "";
        }
        if ($datereglement2 != "__/__/____" && $datereglement2 != "1970-01-01") {
            $conddatereg2 = 'Reglementclient.Date <= ' . "'" . $datereglement2 . "'";
            $condannee = "";
        }
        if ($dateecheance1 != "__/__/____" && $dateecheance1 != "1970-01-01") {
            $conddateecheance = 'Piecereglementclient.echance >= ' . "'" . $dateecheance1 . "'";
        }
        if ($dateecheance2 != "__/__/____" && $dateecheance2 != "1970-01-01") {
            $conddateecheance2 = 'Piecereglementclient.echance <= ' . "'" . $dateecheance2 . "'";
        }
        if ($datebordereau1 != "__/__/____" && $datebordereau1 != "1970-01-01") {
            $conddatebord = 'Reglementclient.Date >= ' . "'" . $datebordereau1 . "'";
        }
        if ($datebordereau2 != "__/__/____" && $datebordereau2 != "1970-01-01") {
            $conddatebord2 = 'Reglementclient.Date <= ' . "'" . $datebordereau2 . "'";
        }

        if ($clientcode != 0) {
            $clientid = $clientcode;
            $condclt = 'Reglementclient.client_id =' . $clientid;
        }
        //debug($pointdevente_id_recette);die;
        if ($pointdevente_id_recette != 0) {

            $condpv = 'Reglementclient.pointdevente_id =' . $pointdevente_id_recette;
        }
        if ($paiement_id != 0) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condpaiement = 'Piecereglementclient.paiement_id =' . $paiement_id;
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        }

        if (isset($encaissement_id)) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $bordereau = $encaissement_id;
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        } else {
            $bordereau = 0;
        }

        if (isset($triagereglement)) {
            if ($triagereglement == "Parnumfacture") {
                $ordre = 'Reglementclient.numero ASC';
            }
            if ($triagereglement == "Pardate") {
                $ordre = 'Piecereglementclient.echance ASC';
            }
            if ($triagereglement == "Parcodeclient") {
                $ordre = 'cast((Client.code) as signed) Asc';
            }
        }
        $cp = 0;
        //debug($conddatereg);debug($condannee);die;
//******************************************************************************************************************************
        $this->loadModel('Piecereglementclient');
        $lignefactures = $this->Piecereglementclient->find('all', array(
//            'joins' => array(
//                array(
//            'table' => 'reglementclients',
//            'alias' => 'Reglementclientt',
//            'type' => 'INNER',
//            'conditions' => array(
//                'Piecereglementclient.reglementclient_id = Reglementclientt.id'
//            )
//        ),
//        array(
//            'table' => 'clients',
//            'alias' => 'Client',
//            'type' => 'INNER',
//            'conditions' => array(
//                'Client.id = Reglementclientt.client_id'
//            )
//        )
//    ),
           'contain' => array('Reglementclient','Client.code'),
            'conditions' => array(@$condpv, @$conddatereg, @$condannee, @$conddatereg2, @$conddateecheance, @$conddateecheance2, @$conddatebord, @$conddatebord2, @$condclt, @$condpaiement, @$condencaissement)
            , 'order' => @$ordre
            , 'recursive' => 0));

//debug($lignefactures);die;

        $this->set(compact('bordereau', 'pointdevente_id_recette', 'lignefactures', 'datereglement1', 'datereglement2', 'triages', 'encaissements', 'paiements', 'date1', 'date2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function imprimersansdetails() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));

        $this->loadModel('Exercice');
        $this->loadModel('Client');
        $this->loadModel('Paiement');

        $this->response->type('pdf');
        $this->layout = 'pdf';

        //debug($this->request->query);die;

        $datereglement1 = CakeSession::read('datereglement1');
        $dateecheance1 = CakeSession::read('dateecheance1');
        $datebordereau1 = CakeSession::read('datebordereau1');
        $clientcode = CakeSession::read('clientcode');
        $paiement_id = CakeSession::read('paiement_id');
        $datereglement2 = CakeSession::read('datereglement2');
        $dateecheance2 = CakeSession::read('dateecheance2');
        $datebordereau2 = CakeSession::read('datebordereau2');
        $triagereglement = CakeSession::read('triagereglement');
        $encaissement_id = CakeSession::read('encaissement_id');
        $anneereglement = CakeSession::read('anneereglement');
        $pointdevente_id_recette = CakeSession::read('pointdevente_id_recette');

        //debug($datereglement1);die;;
        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condf4 = 'Reglementclient.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Reglementclient.pointdevente_id = ' . $p;
        }


        //debug($this->request->query);//die;
        if ($datereglement1 != "__/__/____" && $datereglement1 != "1970-01-01") {
            $conddatereg = 'Reglementclient.Date >= ' . "'" . $datereglement1 . "'";
        }
        if ($datereglement2 != "__/__/____" && $datereglement2 != "1970-01-01") {
            $conddatereg2 = 'Reglementclient.Date <= ' . "'" . $datereglement2 . "'";
        }
        if ($dateecheance1 != "__/__/____" && $dateecheance1 != "1970-01-01") {
            $conddateecheance = 'Piecereglementclient.echance >= ' . "'" . $dateecheance1 . "'";
        }
        if ($dateecheance2 != "__/__/____" && $dateecheance2 != "1970-01-01") {
            $conddateecheance2 = 'Piecereglementclient.echance <= ' . "'" . $dateecheance2 . "'";
        }
        if ($datebordereau1 != "__/__/____" && $datebordereau1 != "1970-01-01") {
            $conddatebord = 'Reglementclient.Date >= ' . "'" . $datebordereau1 . "'";
        }
        if ($datebordereau2 != "__/__/____" && $datebordereau2 != "1970-01-01") {
            $conddatebord2 = 'Reglementclient.Date <= ' . "'" . $datebordereau2 . "'";
        }

        if ($clientcode != 0) {
            $clientid = $clientcode;
            $condclt = 'Reglementclient.client_id =' . $clientid;
        }
        if ($pointdevente_id_recette != 0) {

            $condpv = 'Reglementclient.pointdevente_id =' . $pointdevente_id_recette;
        }
        if ($paiement_id != 0) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condpaiement = 'Piecereglementclient.paiement_id =' . $paiement_id;
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        }

        if (isset($encaissement_id)) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $bordereau = $encaissement_id;
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        } else {
            $bordereau = 0;
        }
        if (isset($anneereglement)) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $exerciceinfo = $this->Exercice->find('first', array('conditions' => array('Exercice.id' => $anneereglement)));
            $condannee = 'Reglementclient.exercice_id=' . $exerciceinfo['Exercice']['name'];
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        }
        if (isset($triagereglement)) {
            if ($triagereglement == "Parnumfacture") {
                $ordre = 'Reglementclient.numero ASC';
            }
            if ($triagereglement == "Pardate") {
                $ordre = 'Piecereglementclient.echance ASC';
            }
            if ($triagereglement == "Parcodeclient") {
                $ordre = 'cast((Client.code) as signed) Asc';
            }
        }
        $cp = 0;
        //debug($conddatereg);debug(@$condannee);die;
//******************************************************************************************************************************
        $this->loadModel('Piecereglementclient');
        $lignefactures = $this->Piecereglementclient->find('all', array(
            'joins' => array(
                array(
            'table' => 'reglementclients',
            'alias' => 'Reglementclientt',
            'type' => 'INNER',
            'conditions' => array(
                'Piecereglementclient.reglementclient_id = Reglementclientt.id'
            )
        ),
        array(
            'table' => 'clients',
            'alias' => 'Client',
            'type' => 'INNER',
            'conditions' => array(
                'Client.id = Reglementclientt.client_id'
            )
        )
    ),
            'contain' => array('Reglementclient'),
            'conditions' => array(@$condpv, @$conddatereg, @$condannee, @$conddatereg2, @$conddateecheance, @$conddateecheance2, @$conddatebord, @$conddatebord2, @$condclt, @$condpaiement, @$condencaissement), 'order' => @$ordre, 'recursive' => 0));



        $this->set(compact('bordereau', 'pointdevente_id_recette', 'lignefactures', 'datereglement1', 'datereglement2', 'triages', 'encaissements', 'paiements', 'date1', 'date2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function exportliste() {

        $this->layout = NULL;

        $this->loadModel('Exercice');
        $this->loadModel('Client');
        $this->loadModel('Paiement');

        //debug($this->request->query);die;

        $datereglement1 = CakeSession::read('datereglement1');
        $dateecheance1 = CakeSession::read('dateecheance1');
        $datebordereau1 = CakeSession::read('datebordereau1');
        $clientcode = CakeSession::read('clientcode');
        $paiement_id = CakeSession::read('paiement_id');
        $datereglement2 = CakeSession::read('datereglement2');
        $dateecheance2 = CakeSession::read('dateecheance2');
        $datebordereau2 = CakeSession::read('datebordereau2');
        $triagereglement = CakeSession::read('triagereglement');
        $encaissement_id = CakeSession::read('encaissement_id');
        $anneereglement = CakeSession::read('anneereglement');
        $pointdevente_id_recette = CakeSession::read('pointdevente_id_recette');

        //debug($datereglement1);die;;
        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condf4 = 'Reglementclient.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Reglementclient.pointdevente_id = ' . $p;
        }


        //debug($this->request->query);//die;
        if (isset($anneereglement)) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $exerciceinfo = $this->Exercice->find('first', array('conditions' => array('Exercice.id' => $anneereglement)));
            $condannee = 'Reglementclient.exercice_id=' . $exerciceinfo['Exercice']['name'];
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        }
        if ($datereglement1 != "__/__/____" && $datereglement1 != "1970-01-01") {
            $conddatereg = 'Reglementclient.Date >= ' . "'" . $datereglement1 . "'";
            $condannee = "";
        }
        if ($datereglement2 != "__/__/____" && $datereglement2 != "1970-01-01") {
            $conddatereg2 = 'Reglementclient.Date <= ' . "'" . $datereglement2 . "'";
            $condannee = "";
        }
        if ($dateecheance1 != "__/__/____" && $dateecheance1 != "1970-01-01") {
            $conddateecheance = 'Piecereglementclient.echance >= ' . "'" . $dateecheance1 . "'";
        }
        if ($dateecheance2 != "__/__/____" && $dateecheance2 != "1970-01-01") {
            $conddateecheance2 = 'Piecereglementclient.echance <= ' . "'" . $dateecheance2 . "'";
        }
        if ($datebordereau1 != "__/__/____" && $datebordereau1 != "1970-01-01") {
            $conddatebord = 'Reglementclient.Date >= ' . "'" . $datebordereau1 . "'";
        }
        if ($datebordereau2 != "__/__/____" && $datebordereau2 != "1970-01-01") {
            $conddatebord2 = 'Reglementclient.Date <= ' . "'" . $datebordereau2 . "'";
        }

        if ($clientcode != 0) {
            $clientid = $clientcode;
            $condclt = 'Reglementclient.client_id =' . $clientid;
        }
        //debug($pointdevente_id_recette);die;
        if ($pointdevente_id_recette != 0) {

            $condpv = 'Reglementclient.pointdevente_id =' . $pointdevente_id_recette;
        }
        if ($paiement_id != 0) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condpaiement = 'Piecereglementclient.paiement_id =' . $paiement_id;
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        }

        if (isset($encaissement_id)) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $bordereau = $encaissement_id;
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        } else {
            $bordereau = 0;
        }

        if (isset($triagereglement)) {
            if ($triagereglement == "Parnumfacture") {
                $ordre = 'Reglementclient.numero ASC';
            }
            if ($triagereglement == "Pardate") {
                $ordre = 'Piecereglementclient.echance ASC';
            }
            if ($triagereglement == "Parcodeclient") {
                $ordre = 'cast((Client.code) as signed) Asc';
            }
        }
        $cp = 0;
        //debug($conddatereg);debug($condannee);die;
//******************************************************************************************************************************
        $this->loadModel('Piecereglementclient');
        $lignefactures = $this->Piecereglementclient->find('all', array(
            'joins' => array(
                array(
                    'table' => 'reglementclients',
                    'alias' => 'Reglementclientt',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Piecereglementclient.reglementclient_id = Reglementclientt.id'
                    )
                ),
                array(
                    'table' => 'clients',
                    'alias' => 'Client',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Client.id = Reglementclientt.client_id'
                    )
                )
            ),
            'contain' => array('Reglementclient'),
            'conditions' => array(@$condpv, @$conddatereg, @$condannee, @$conddatereg2, @$conddateecheance, @$conddateecheance2, @$conddatebord, @$conddatebord2, @$condclt, @$condpaiement, @$condencaissement), 'order' => @$ordre, 'recursive' => 0));
//debug($lignefactures);die;

        $this->set(compact('bordereau', 'lignefactures', 'datereglement1', 'datereglement2', 'triages', 'encaissements', 'paiements', 'date1', 'date2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function exportliste_1() {

        $this->layout = NULL;

        $this->loadModel('Exercice');
        $this->loadModel('Client');
        $this->loadModel('Paiement');

        //debug($this->request->query);die;

        $datereglement1 = CakeSession::read('datereglement1');
        $dateecheance1 = CakeSession::read('dateecheance1');
        $datebordereau1 = CakeSession::read('datebordereau1');
        $clientcode = CakeSession::read('clientcode');
        $paiement_id = CakeSession::read('paiement_id');
        $datereglement2 = CakeSession::read('datereglement2');
        $dateecheance2 = CakeSession::read('dateecheance2');
        $datebordereau2 = CakeSession::read('datebordereau2');
        $triagereglement = CakeSession::read('triagereglement');
        $encaissement_id = CakeSession::read('encaissement_id');
        $anneereglement = CakeSession::read('anneereglement');
        $pointdevente_id_recette = CakeSession::read('pointdevente_id_recette');

        //debug($datereglement1);die;;
        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condf4 = 'Reglementclient.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Reglementclient.pointdevente_id = ' . $p;
        }


        //debug($this->request->query);//die;
        if ($datereglement1 != "__/__/____" && $datereglement1 != "1970-01-01") {
            $conddatereg = 'Reglementclient.Date >= ' . "'" . $datereglement1 . "'";
        }
        if ($datereglement2 != "__/__/____" && $datereglement2 != "1970-01-01") {
            $conddatereg2 = 'Reglementclient.Date <= ' . "'" . $datereglement2 . "'";
        }
        if ($dateecheance1 != "__/__/____" && $dateecheance1 != "1970-01-01") {
            $conddateecheance = 'Piecereglementclient.echance >= ' . "'" . $dateecheance1 . "'";
        }
        if ($dateecheance2 != "__/__/____" && $dateecheance2 != "1970-01-01") {
            $conddateecheance2 = 'Piecereglementclient.echance <= ' . "'" . $dateecheance2 . "'";
        }
        if ($datebordereau1 != "__/__/____" && $datebordereau1 != "1970-01-01") {
            $conddatebord = 'Reglementclient.Date >= ' . "'" . $datebordereau1 . "'";
        }
        if ($datebordereau2 != "__/__/____" && $datebordereau2 != "1970-01-01") {
            $conddatebord2 = 'Reglementclient.Date <= ' . "'" . $datebordereau2 . "'";
        }

        if ($clientcode != 0) {
            $clientid = $clientcode;
            $condclt = 'Reglementclient.client_id =' . $clientid;
        }
        if ($pointdevente_id_recette != 0) {

            $condpv = 'Reglementclient.pointdevente_id =' . $pointdevente_id_recette;
        }
        if ($paiement_id != 0) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $condpaiement = 'Piecereglementclient.paiement_id =' . $paiement_id;
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        }

        if (isset($encaissement_id)) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $bordereau = $encaissement_id;
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        } else {
            $bordereau = 0;
        }
        if (isset($anneereglement)) {
//            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
            $exerciceinfo = $this->Exercice->find('first', array('conditions' => array('Exercice.id' => $anneereglement)));
            $condannee = 'Reglementclient.exercice_id=' . $exerciceinfo['Exercice']['name'];
            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
        }
        if (isset($triagereglement)) {
            if ($triagereglement == "Parnumfacture") {
                $ordre = 'Reglementclient.numero ASC';
            }
            if ($triagereglement == "Pardate") {
                $ordre = 'Piecereglementclient.echance ASC';
            }
            if ($triagereglement == "Parcodeclient") {
                $ordre = 'cast((Client.code) as signed) Asc';
            }
        }
        $cp = 0;
        //debug($conddatereg);debug(@$condannee);die;
//******************************************************************************************************************************
        $this->loadModel('Piecereglementclient');
        $lignefactures = $this->Piecereglementclient->find('all', array(
            'joins' => array(
                array(
                    'table' => 'reglementclients',
                    'alias' => 'Reglementclientt',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Piecereglementclient.reglementclient_id = Reglementclientt.id'
                    )
                ),
                array(
                    'table' => 'clients',
                    'alias' => 'Client',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Client.id = Reglementclientt.client_id'
                    )
                )
            ),
            'contain' => array('Reglementclient'),
            'conditions' => array(@$condpv, @$conddatereg, @$condannee, @$conddatereg2, @$conddateecheance, @$conddateecheance2, @$conddatebord, @$conddatebord2, @$condclt, @$condpaiement, @$condencaissement), 'order' => @$ordre, 'recursive' => 0));



        $this->set(compact('bordereau', 'lignefactures', 'datereglement1', 'datereglement2', 'triages', 'encaissements', 'paiements', 'date1', 'date2', 'tvas', 'types', 'tablignefactures', 'pointdeventes', 'typeligneventes', 'familles', 'clients', 'articles', 'historiquearticles', 'pointdeventeid', 'typeligneventeid', 'clientid', 'date1', 'date2', 'familleid', 'articleid', 'exerciceid'));
    }

    public function etatimpaye() {
        $this->loadModel('Client');
        $this->loadModel('Paiement');
        $this->loadModel('Exercice');
        $this->loadModel('Pointdevente');



        CakeSession::delete('datereglement1');
        CakeSession::delete('dateecheance1');
        CakeSession::delete('datebordereau1');
        CakeSession::delete('clientcode');
        CakeSession::delete('paiement_id');
        CakeSession::delete('datereglement2');
        CakeSession::delete('dateecheance2');
        CakeSession::delete('datebordereau2');
        CakeSession::delete('triagereglement');
        CakeSession::delete('encaissement_id');
        CakeSession::delete('anneereglement');
        CakeSession::delete('pointdeventeimpaye');

        $exe = date('Y');
        $p = CakeSession::read('pointdevente');
        if ($p > 0) {
            $cond_liste_pv = 'Pointdevente.id = '.$p;
        }
        $pointdeventes = $this->Pointdevente->find('list', array('conditions' => array(@$cond_liste_pv)));
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];

        //$clients = $this->Client->find('list');

        $triages = array();
        $triages['Parnumfacture'] = "Par N° Impaye";
        $triages['Pardate'] = "Par date";
        $triages['Parcodeclient'] = "Par code client";

        $reglements = array();
        $reglements['Tous'] = "Tous";
        $reglements['Regle'] = "Regle";
        $reglements['Nonregle'] = "Non regle";

        $exercices = $this->Exercice->find('list');

        $this->set(compact('t', 'exercices', 'pointdeventes', 'exerciceid', 'reglements', 'triages', 'encaissements', 'paiements', 'zones', 'pointdeventeid', 'client_id', 'exercice_id', 'pointdeventes', 'clientid', 'date1', 'date2', 'clients', 'exercices', 'exerciceid', 'types'));
    }

    public function etatimpayesession() {
        CakeSession::delete('datedebutimpaye');
        CakeSession::delete('datefinimpaye');
        CakeSession::delete('reglementimpaye');
        CakeSession::delete('triageimpaye');
        CakeSession::delete('exerciceimpaye');
        CakeSession::delete('datereglement2');
        CakeSession::delete('pointdeventeimpaye');
        //print_r($this->request->data);die;
        $datedebutimpaye = $this->request->data['datedebutimpaye'];
        $datedebutimpaye = date("Y-m-d", strtotime(str_replace('/', '-', $datedebutimpaye)));
        $datefinimpaye = $this->request->data['datefinimpaye'];
        $datefinimpaye = date("Y-m-d", strtotime(str_replace('/', '-', $datefinimpaye)));


        $reglementimpaye = $this->request->data['reglementimpaye'];
        $triageimpaye = $this->request->data['triageimpaye'];
        $exerciceimpaye = $this->request->data['exerciceimpaye'];
        $pointdeventeimpaye = $this->request->data['pointdeventeimpaye'];

        CakeSession::write('datedebutimpaye', $datedebutimpaye);
        CakeSession::write('datefinimpaye', $datefinimpaye);
        CakeSession::write('reglementimpaye', $reglementimpaye);
        CakeSession::write('triageimpaye', $triageimpaye);
        CakeSession::write('exerciceimpaye', $exerciceimpaye);
        CakeSession::write('pointdeventeimpaye', $pointdeventeimpaye);
        echo true;
        die;
    }

    public function imprimeravecdetailsimpaye() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));

        $this->loadModel('Exercice');
        $this->loadModel('Client');
        $this->loadModel('Paiement');

        //debug($this->request->query);die;

        $datedebutimpaye = CakeSession::read('datedebutimpaye');
        $datefinimpaye = CakeSession::read('datefinimpaye');
        $reglementimpaye = CakeSession::read('reglementimpaye');
        $triageimpaye = CakeSession::read('triageimpaye');
        $exerciceimpaye = CakeSession::read('exerciceimpaye');
        $datereglement2 = CakeSession::read('datereglement2');
        $pointdeventeimpaye = CakeSession::read('pointdeventeimpaye');

        //debug($datereglement1);die;;
        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condf4 = 'Reglementclient.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        //$p = CakeSession::read('pointdeventeimpaye'); //debug($p);die;
        if ($pointdeventeimpaye != 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Reglementclient.pointdevente_id = ' . $pointdeventeimpaye;
        }


        //debug($datedebutimpaye);die;
        if ($datedebutimpaye != "__/__/____" && $datedebutimpaye != "1970-01-01" && $datedebutimpaye != NULL) {
            $conddateimpaye = 'Reglementclient.Date >= ' . "'" . $datedebutimpaye . "'";
        }
        if ($datefinimpaye != "__/__/____" && $datefinimpaye != "1970-01-01" && $datefinimpaye != NULL) {
            $conddateimpaye1 = 'Reglementclient.Date <= ' . "'" . $datefinimpaye . "'";
        }

//        if (isset($exerciceimpaye)) {
////            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
//            $exerciceinfo = $this->Exercice->find('first', array('conditions' => array('Exercice.id' => $exerciceimpaye)));
//            $condannee = 'Reglementclient.exercice_id='.$exerciceinfo['Exercice']['name'];
//            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
//        }


        if (isset($reglementimpaye)) {
            $reg = $reglementimpaye;
        }

        if (isset($triageimpaye)) {
            if ($triageimpaye == "Parnumfacture") {
                $ordre = 'Piecereglementclient.num ASC';
            }
            if ($triageimpaye == "Pardate") {
                $ordre = 'Reglementclient.Date ASC';
            }
            if ($triageimpaye == "Parcodeclient") {
                $ordre = 'cast((Client.code) as signed) Asc';
            }
        }
        $cp = 0;

        //debug($conddatereg);debug($condannee);die;
//******************************************************************************************************************************
        $this->loadModel('Piecereglementclient');
        $lignefactures = $this->Piecereglementclient->find('all', array(
            'contain' => array('Reglementclient','Client'),
            'conditions' => array(@$conddateimpaye, @$conddateimpaye1, @$conddatereg2, @$pvf, 'Piecereglementclient.situation LIKE "%Impay%"'), 'order' => @$ordre, 'recursive' => -1));
//debug($lignefactures);die;

        $this->set(compact('reg', 'pointdeventeimpaye', 'lignefactures', 'datedebutimpaye', 'datefinimpaye', 'exerciceid'));
    }

    public function imprimersansdetailsimpaye() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));

        $this->loadModel('Exercice');
        $this->loadModel('Client');
        $this->loadModel('Paiement');

        //debug($this->request->query);die;

        $datedebutimpaye = CakeSession::read('datedebutimpaye');
        $datefinimpaye = CakeSession::read('datefinimpaye');
        $reglementimpaye = CakeSession::read('reglementimpaye');
        $triageimpaye = CakeSession::read('triageimpaye');
        $exerciceimpaye = CakeSession::read('exerciceimpaye');
        $datereglement2 = CakeSession::read('datereglement2');
        $pointdeventeimpaye = CakeSession::read('pointdeventeimpaye');

        //debug($datereglement1);die;;
        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condf4 = 'Reglementclient.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        //$p = CakeSession::read('pointdeventeimpaye');
        if ($pointdeventeimpaye > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Reglementclient.pointdevente_id = ' . $pointdeventeimpaye;
        }


        //debug($datedebutimpaye);die;
        if ($datedebutimpaye != "__/__/____" && $datedebutimpaye != "1970-01-01" && $datedebutimpaye != NULL) {
            $conddateimpaye = 'Reglementclient.Date >= ' . "'" . $datedebutimpaye . "'";
        }
        if ($datefinimpaye != "__/__/____" && $datefinimpaye != "1970-01-01" && $datefinimpaye != NULL) {
            $conddateimpaye1 = 'Reglementclient.Date <= ' . "'" . $datefinimpaye . "'";
        }

//        if (isset($exerciceimpaye)) {
////            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
//            $exerciceinfo = $this->Exercice->find('first', array('conditions' => array('Exercice.id' => $exerciceimpaye)));
//            $condannee = 'Reglementclient.exercice_id='.$exerciceinfo['Exercice']['name'];
//            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
//        }


        if (isset($reglementimpaye)) {
            $reg = $reglementimpaye;
        }

        if (isset($triageimpaye)) {
            if ($triageimpaye == "Parnumfacture") {
                $ordre = 'Piecereglementclient.num ASC';
            }
            if ($triageimpaye == "Pardate") {
                $ordre = 'Reglementclient.Date ASC';
            }
            if ($triageimpaye == "Parcodeclient") {
                $ordre = 'cast((Client.code) as signed) Asc';
            }
        }
        $cp = 0;
        //debug($conddatereg);debug($condannee);die;
//******************************************************************************************************************************
        $this->loadModel('Piecereglementclient');
        $lignefactures = $this->Piecereglementclient->find('all', array(
            'contain' => array('Reglementclient','Client'),
            'conditions' => array(@$conddateimpaye, @$conddateimpaye1, @$conddatereg2, @$pvf, 'Piecereglementclient.situation LIKE "%Impay%"'), 'order' => @$ordre, 'recursive' => 0));
//debug($lignefactures);die;

        $this->set(compact('reg', 'pointdeventeimpaye', 'lignefactures', 'datedebutimpaye', 'datefinimpaye', 'exerciceid'));
    }

    public function exportlisteavecdetailsimpaye() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));

        $this->loadModel('Exercice');
        $this->loadModel('Client');
        $this->loadModel('Paiement');

        $this->layout = NULL;

        //debug($this->request->query);die;

        $datedebutimpaye = CakeSession::read('datedebutimpaye');
        $datefinimpaye = CakeSession::read('datefinimpaye');
        $reglementimpaye = CakeSession::read('reglementimpaye');
        $triageimpaye = CakeSession::read('triageimpaye');
        $exerciceimpaye = CakeSession::read('exerciceimpaye');
        $datereglement2 = CakeSession::read('datereglement2');
        $pointdeventeimpaye = CakeSession::read('pointdeventeimpaye');

        //debug($datereglement1);die;;
        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condf4 = 'Reglementclient.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        //$p = CakeSession::read('pointdeventeimpaye');
        if ($pointdeventeimpaye > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Reglementclient.pointdevente_id = ' . $pointdeventeimpaye;
        }


        //debug($datedebutimpaye);die;
        if ($datedebutimpaye != "__/__/____" && $datedebutimpaye != "1970-01-01" && $datedebutimpaye != NULL) {
            $conddateimpaye = 'Reglementclient.Date >= ' . "'" . $datedebutimpaye . "'";
        }
        if ($datefinimpaye != "__/__/____" && $datefinimpaye != "1970-01-01" && $datefinimpaye != NULL) {
            $conddateimpaye1 = 'Reglementclient.Date <= ' . "'" . $datefinimpaye . "'";
        }

//        if (isset($exerciceimpaye)) {
////            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
//            $exerciceinfo = $this->Exercice->find('first', array('conditions' => array('Exercice.id' => $exerciceimpaye)));
//            $condannee = 'Reglementclient.exercice_id='.$exerciceinfo['Exercice']['name'];
//            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
//        }


        if (isset($reglementimpaye)) {
            $reg = $reglementimpaye;
        }

        if (isset($triageimpaye)) {
            if ($triageimpaye == "Parnumfacture") {
                $ordre = 'Piecereglementclient.num ASC';
            }
            if ($triageimpaye == "Pardate") {
                $ordre = 'Reglementclient.Date ASC';
            }
            if ($triageimpaye == "Parcodeclient") {
                $ordre = 'cast((Client.code) as signed) Asc';
            }
        }
        $cp = 0;

        //debug($conddatereg);debug($condannee);die;
//******************************************************************************************************************************
        $this->loadModel('Piecereglementclient');
        $lignefactures = $this->Piecereglementclient->find('all', array(
            'contain' => array('Reglementclient','Client'),
            'conditions' => array(@$conddateimpaye, @$conddateimpaye1, @$conddatereg2, @$pvf, 'Piecereglementclient.situation LIKE "%Impay%"'), 'order' => @$ordre, 'recursive' => -1));
//debug($lignefactures);die;

        $this->set(compact('reg', 'lignefactures', 'datedebutimpaye', 'datefinimpaye', 'exerciceid'));
    }

    public function exportlistesansdetailsimpaye() {
//        $lien=  CakeSession::read('lien_vente');
//               $vente="";
//               if(!empty($lien)){
//               foreach($lien as $k=>$liens){
//                if(@$liens['lien']=='etathistoriquearticles'){
//                        $vente=$liens['imprimer'];
//                }}}
//              if (( $vente <> 1)||(empty($lien))){
//              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));

        $this->loadModel('Exercice');
        $this->loadModel('Client');
        $this->loadModel('Paiement');

        $this->layout = NULL;

        //debug($this->request->query);die;

        $datedebutimpaye = CakeSession::read('datedebutimpaye');
        $datefinimpaye = CakeSession::read('datefinimpaye');
        $reglementimpaye = CakeSession::read('reglementimpaye');
        $triageimpaye = CakeSession::read('triageimpaye');
        $exerciceimpaye = CakeSession::read('exerciceimpaye');
        $datereglement2 = CakeSession::read('datereglement2');
        $pointdeventeimpaye = CakeSession::read('pointdeventeimpaye');

        //debug($datereglement1);die;;
        //debug($date1); debug($date2); debug($reglement); debug($triage); debug($vente);debug($clientcode);debug($zonedetail);die;

        /*         * ************************************************************* */
        $tablignefactures = array();

        $exe = date('Y');
        $exercice = $this->Exercice->find('first', array('conditions' => array('Exercice.name' => $exe)));
        $exerciceid = $exercice['Exercice']['id'];
        $condf4 = 'Reglementclient.exercice_id =' . $exe;
        $pv = "";
        $pvf = "";
        $pva = "";
        //$p = CakeSession::read('pointdeventeimpaye');
        if ($pointdeventeimpaye > 0) {
//          $pvb= 'Bonlivraison.pointdevente_id = '.$p;
            $pvf = 'Reglementclient.pointdevente_id = ' . $pointdeventeimpaye;
        }


        //debug($datedebutimpaye);die;
        if ($datedebutimpaye != "__/__/____" && $datedebutimpaye != "1970-01-01" && $datedebutimpaye != NULL) {
            $conddateimpaye = 'Reglementclient.Date >= ' . "'" . $datedebutimpaye . "'";
        }
        if ($datefinimpaye != "__/__/____" && $datefinimpaye != "1970-01-01" && $datefinimpaye != NULL) {
            $conddateimpaye1 = 'Reglementclient.Date <= ' . "'" . $datefinimpaye . "'";
        }

//        if (isset($exerciceimpaye)) {
////            $condb4 = 'Bonlivraison.exercice_id ='.$exercices[$exerciceid];
//            $exerciceinfo = $this->Exercice->find('first', array('conditions' => array('Exercice.id' => $exerciceimpaye)));
//            $condannee = 'Reglementclient.exercice_id='.$exerciceinfo['Exercice']['name'];
//            //$conda4 = 'Factureavoir.exercice_id ='.$zonedetail;
//        }


        if (isset($reglementimpaye)) {
            $reg = $reglementimpaye;
        }

        if (isset($triageimpaye)) {
            if ($triageimpaye == "Parnumfacture") {
                $ordre = 'Piecereglementclient.num ASC';
            }
            if ($triageimpaye == "Pardate") {
                $ordre = 'Reglementclient.Date ASC';
            }
            if ($triageimpaye == "Parcodeclient") {
                $ordre = 'cast((Client.code) as signed) Asc';
            }
        }
        $cp = 0;
        //debug($conddatereg);debug($condannee);die;
//******************************************************************************************************************************
        $this->loadModel('Piecereglementclient');
        $lignefactures = $this->Piecereglementclient->find('all', array(
            'contain' => array('Reglementclient','Client'),
            'conditions' => array(@$conddateimpaye, @$conddateimpaye1, @$conddatereg2, @$pvf, 'Piecereglementclient.situation LIKE "%Impay%"'), 'order' => @$ordre, 'recursive' => 0));
//debug($lignefactures);die;

        $this->set(compact('reg', 'lignefactures', 'datedebutimpaye', 'datefinimpaye', 'exerciceid'));
    }

    public function imputereglements($val = null, $id = null) {
        $this->layout = null;
        $this->Reglementclient->updateAll(array(
            'Reglementclient.impute' => $val), array('Reglementclient.id' => $id));
        die;
    }

}
