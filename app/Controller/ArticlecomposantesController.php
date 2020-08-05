<?php

App::uses('AppController', 'Controller');

/**
 * Articlecomposantes Controller
 *
 * @property Articlecomposante $Articlecomposante
 */
class ArticlecomposantesController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Articlecomposante->recursive = 0;
        $this->set('articlecomposantes', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Articlecomposante->exists($id)) {
            throw new NotFoundException(__('Invalid articlecomposante'));
        }
        $options = array('conditions' => array('Articlecomposante.' . $this->Articlecomposante->primaryKey => $id));
        $this->set('articlecomposante', $this->Articlecomposante->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Articlecomposante->create();
            if ($this->Articlecomposante->save($this->request->data)) {
                $this->Session->setFlash(__('The articlecomposante has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The articlecomposante could not be saved. Please, try again.'));
            }
        }
        $articles = $this->Articlecomposante->Article->find('list');
        $this->set(compact('articles'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Articlecomposante->exists($id)) {
            throw new NotFoundException(__('Invalid articlecomposante'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Articlecomposante->save($this->request->data)) {
                $this->Session->setFlash(__('The articlecomposante has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The articlecomposante could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Articlecomposante.' . $this->Articlecomposante->primaryKey => $id));
            $this->request->data = $this->Articlecomposante->find('first', $options);
        }
        $articles = $this->Articlecomposante->Article->find('list');
        $this->set(compact('articles'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Articlecomposante->id = $id;
        if (!$this->Articlecomposante->exists()) {
            throw new NotFoundException(__('Invalid articlecomposante'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Articlecomposante->delete()) {
            $this->Session->setFlash(__('Articlecomposante deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Articlecomposante was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    public function articlecomposant($couples = null, $cnt = null) {
        $this->loadModel('Article');
        $this->layout = null;
        $tables="";
        $jointures="";
        $conditions="";
        $couples=  explode('*', $couples);
        //debug($couples);
        foreach ($couples as $i=>$couple){
            $combinisons=  explode(',', $couple);
            //debug($combinisons);
            if($i==0){
            $tables.="articlecomposantes a".$i; 
            $jointures .="1=1 ";
            }else{
            $tables.=" ,articlecomposantes a".$i;
            $jointures .=" and a".($i-1).".article_id =a".$i.".article_id ";
            }
            $conditions.=" and (a".$i.".composant =".$combinisons['0']." and a".$i.".qte=".$combinisons['1']." and a".$i.".cnt=".$combinisons['2']." )";
        }
        //debug($tables);
        //debug($jointures);
        //debug($conditions);
        
        //$request = "SELECT article_id,count(*) FROM articlecomposantes WHERE (composant,qte,cnt) IN (" . $couples . ") group by article_id having count(*) = " . $cnt ;
        $request="SELECT a0.article_id FROM ".$tables." WHERE ".$jointures." ".$conditions." GROUP by a0.article_id";
        $art = $this->Articlecomposante->query($request);
        
        
        
        //debug($request);
        //debug($art);
        
        $articles = array();
        if (empty($art[0]['a0']['article_id'])) {
            $verif = 1;
        } else {
            $verif = 0;
            $articles = $this->Article->find('first', array(
                'conditions' => array('Article.id' => $art[0]['a0']['article_id']),
                'recursive' => -1
            ));
        }
        //debug($verif);debug($articles);die;
        
        echo json_encode(array('verif' => $verif, 'article' => $articles));
        die();
//            debug($art);die;
    }

}
