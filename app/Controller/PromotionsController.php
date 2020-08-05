<?php
App::uses('AppController', 'Controller');
/**
 * Promotions Controller
 *
 * @property Promotion $Promotion
 */
class PromotionsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Promotion->recursive = 0;
                $this->paginate = array(
                'limit'=>5000000,     
                'order' => array('Promotion.id' => 'desc'),
                'group' => array('Promotion.numero'));  
		$this->set('promotions', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Promotion->exists($id)) {
			throw new NotFoundException(__('Invalid promotion'));
		}
		
			$options = array('conditions' => array('Promotion.' . $this->Promotion->primaryKey => $id));
			$this->request->data = $this->Promotion->find('first', $options);
		
		//$articles = $this->Promotion->Article->find('list');
                $lignes=$this->Promotion->find('all',array('conditions'=>array('Promotion.numero'=>$this->request->data['Promotion']['numero']),'recursive'=>-1));
                
		$this->set(compact('articles','lignes'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
                    //debug($this->request->data);die;
                    $datedebut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Promotion']['datedebut'])));
                    $datefin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Promotion']['datefin'])));
			if (!empty($this->request->data['Promotionligne'])) {
                            foreach ($this->request->data['Promotionligne'] as $f) {
                                $tab = array();
                                if ($f['sup'] != 1) {
                                    if($f['article_id']!=""){
                                    $tab['article_id'] = $f['article_id'];
                                    $tab['numero'] = $this->request->data['Promotion']['numero'];
                                    $tab['designation'] = $this->request->data['Promotion']['designation'];
                                    $tab['qte'] = $f['qte'];
                                    $tab['prix'] = $f['prix'];
                                    $tab['prixgros'] = $f['prixgros'];
                                    $tab['datedebut'] = $datedebut;
                                    $tab['datefin'] = $datefin;
                                    $this->Promotion->create();
                                    $this->Promotion->save($tab);
                                }}
                            }
                        }
			
                            
				$this->redirect(array('action' => 'index'));
			
		}
                $numero = $this->Promotion->find('all', array(
                    'fields' => array('MAX(Promotion.numero) as num')));
            //    debug($numero);
        //        die;
                foreach ($numero as $num) {
                    $n = $num[0]['num'];

                    if (!empty($n)) {
                        $lastnum = $n;
                        $nume = intval($lastnum) + 1;
                        $mm = str_pad($nume, 6, "0", STR_PAD_LEFT);
                    } else {
                        $mm = str_pad(1, 6, "0", STR_PAD_LEFT);
                    }
                }
                
		//$articles = $this->Promotion->Article->find('list');
		$this->set(compact('articles','mm'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Promotion->exists($id)) {
			throw new NotFoundException(__('Invalid promotion'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                    //debug($this->request->data);die;
                    $datedebut = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Promotion']['datedebut'])));
                    $datefin = date("Y-m-d", strtotime(str_replace('/', '-', $this->request->data['Promotion']['datefin'])));
			if (!empty($this->request->data['Promotionligne'])) {
                            foreach ($this->request->data['Promotionligne'] as $f) {
                                if(($f['sup']==1)&&($f['id']!='')){
                                    $this->Promotion->deleteAll(array('Promotion.id' => $f['id']), false);
                                }
                                $tab = array();
                                if ($f['sup'] != 1) {
                                    if($f['article_id']!=""){
                                    $tab['article_id'] = $f['article_id'];
                                    $tab['id'] = @$f['id'];
                                    $tab['numero'] = $this->request->data['Promotion']['numero'];
                                    $tab['designation'] = $this->request->data['Promotion']['designation'];
                                    $tab['qte'] = $f['qte'];
                                    $tab['prix'] = $f['prix'];
                                    $tab['prixgros'] = $f['prixgros'];
                                    $tab['datedebut'] = $datedebut;
                                    $tab['datefin'] = $datefin;
                                    $this->Promotion->create();
                                    $this->Promotion->save($tab);
                                }}
                            }
                        }
                    
                    
				$this->redirect(array('action' => 'index'));
			
		} else {
			$options = array('conditions' => array('Promotion.' . $this->Promotion->primaryKey => $id));
			$this->request->data = $this->Promotion->find('first', $options);
		}
		//$articles = $this->Promotion->Article->find('list');
                $lignes=$this->Promotion->find('all',array('conditions'=>array('Promotion.numero'=>$this->request->data['Promotion']['numero']),'recursive'=>-1));
                
		$this->set(compact('articles','lignes'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Promotion->id = $id;
		if (!$this->Promotion->exists()) {
			throw new NotFoundException(__('Invalid promotion'));
		}
                $promo = $this->Promotion->find('first',array('conditions'=>array('Promotion.id'=>$id)));
                $numero=$promo['Promotion']['numero'];
		$this->request->onlyAllow('post', 'delete');
		if ($this->Promotion->delete()) {
                    $this->Promotion->deleteAll(array('Promotion.numero' => "'".$numero."'"), false);
			$this->Session->setFlash(__('Promotion deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Promotion was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
        
        
      
        
}
