<?php
App::uses('AppController', 'Controller');
/**
 * Sortiecaissees Controller
 *
 * @property Sortiecaissee $Sortiecaissee
 */
class SortiecaisseesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='sortiecaissees'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Sortiecaissee->recursive = 0;
		$this->set('sortiecaissees', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='sortiecaissees'){
                        $x=1;
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Sortiecaissee->exists($id)) {
			throw new NotFoundException(__('Invalid sortiecaissee'));
		}
		$options = array('conditions' => array('Sortiecaissee.' . $this->Sortiecaissee->primaryKey => $id));
		$this->set('sortiecaissee', $this->Sortiecaissee->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='sortiecaissees'){
                        $x=$liens['add'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if ($this->request->is('post')) {
                        $this->request->data['Sortiecaissee']['date']=date("Y-m-d",strtotime(str_replace('/','-',$this->request->data['Sortiecaissee']['date'])));
			$this->request->data['Sortiecaissee']['utilisateur_id']= CakeSession::read('users');
			$this->Sortiecaissee->create();
			if ($this->Sortiecaissee->save($this->request->data)) {
				$this->Session->setFlash(__('The sortiecaissee has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sortiecaissee could not be saved. Please, try again.'));
			}
		}
        $numero = $this->Sortiecaissee->find('all', array('fields' =>
            array(
                'MAX(Sortiecaissee.numero) as num'
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
		$this->set(compact('mm'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='sortiecaissees'){
                        $x=$liens['edit'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		if (!$this->Sortiecaissee->exists($id)) {
			throw new NotFoundException(__('Invalid sortiecaissee'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Sortiecaissee->save($this->request->data)) {
				$this->Session->setFlash(__('The sortiecaissee has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sortiecaissee could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Sortiecaissee.' . $this->Sortiecaissee->primaryKey => $id));
			$this->request->data = $this->Sortiecaissee->find('first', $options);
		}
                $date=date("d/m/Y",strtotime(str_replace('-','/',$this->request->data['Sortiecaissee']['date'])));
		$this->set(compact('date'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
             $lien=  CakeSession::read('lien_finance');
               $x="";
               //debug($lien);die;
               if(!empty($lien)){
               foreach($lien as $k=>$liens){
                if(@$liens['lien']=='sortiecaissees'){
                        $x=$liens['delete'];
                }}}
              if (( $x <> 1)||(empty($lien))){
              $this->redirect(array('controller' => 'utilisateurs','action' => 'login'));
                   }
		$this->Sortiecaissee->id = $id;
		if (!$this->Sortiecaissee->exists()) {
			throw new NotFoundException(__('Invalid sortiecaissee'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Sortiecaissee->delete()) {
			$this->Session->setFlash(__('Sortiecaissee deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Sortiecaissee was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
