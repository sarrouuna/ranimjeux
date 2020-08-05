<?php
App::uses('AppController', 'Controller');
/**
 * Zones Controller
 *
 * @property Zone $Zone
 */
class ZonesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
              $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='zones'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Zone->recursive = 0;
		$this->set('zones', $this->paginate());
               
                
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='zones'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Zone->exists($id)) {
			throw new NotFoundException(__('Invalid zone'));
		}
		$options = array('conditions' => array('Zone.' . $this->Zone->primaryKey => $id));
		$this->set('zone', $this->Zone->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
             $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='zones'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if ($this->request->is('post')) {
			$this->Zone->create();
			if ($this->Zone->save($this->request->data)) {
				$this->Session->setFlash(__('The zone has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The zone could not be saved. Please, try again.'));
			}
		}
                 $codes = $this->Zone->find('all', array('fields' =>
            array(
                'MAX(Zone.code) as num'
                )));
           foreach ($codes as $num) {
                $n = $num[0]['num'];

                if (!empty($n)) {
                    $lastnum = $n;
                    $nume = intval($lastnum) + 1;
                    $code = str_pad($nume, 6, "0", STR_PAD_LEFT);
                } else {
                    $code = "000001";
                }
           }
           $this->loadModel('Pay');
           $pays=$this->Pay->find('list');
           $this->set(compact('code','pays'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
              $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='zones'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Zone->exists($id)) {
			throw new NotFoundException(__('Invalid zone'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Zone->save($this->request->data)) {
				$this->Session->setFlash(__('The zone has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The zone could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Zone.' . $this->Zone->primaryKey => $id));
			$this->request->data = $this->Zone->find('first', $options);
		}
           $this->loadModel('Pay');
           $pays=$this->Pay->find('list');
           $this->set(compact('pays'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
              $lien=  CakeSession::read('lien_vente');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='zones'){
                        $x=$liens['delete'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Zone->id = $id;
		if (!$this->Zone->exists()) {
			throw new NotFoundException(__('Invalid zone'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Zone->delete()) {
			$this->Session->setFlash(__('Zone deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Zone was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
