<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Ticketcaisses/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Modification Ticketcaisse'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Ticketcaiss', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php
                    $date = date("d/m/Y", strtotime(str_replace('-', '/', $this->request->data['Ticketcaiss']['Date'])));
                    echo $this->Form->input('id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'readonly' => 'readonly', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('Numero', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'readonly' => 'readonly', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    ?></div><div class="col-md-6"><?php
                    echo $this->Form->input('Date', array('div' => 'form-group', 'disabled' => 'disabled', 'value' => $date, 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'text', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    echo $this->Form->input('Total_TTC', array('div' => 'form-group', 'readonly' => 'readonly', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'text', 'required data-bv-notempty-message' => 'Champ Obligatoire'));
                    
                    ?>
                </div>          



                <div class="col-md-12"  >
                    <div class="panel panel-default" >
                        <div class="panel-heading" style="background-color: #58ACFA">
                            <h3 class="panel-title"><?php echo __('Details'); ?></h3>

                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered table-striped table-bottomless" id="addtablemag" align="center" >
                                <thead>
                                    <tr style="background-color: #900;color: #fff;">
                                        <td style="width:25%;height: 30px" align="center" nowrap="nowrap">Article</td>
                                        <td style="width:15%" align="center">Quantite</td>
                                        <td style="width:15%" align="center">Prix Unitaire</td>
                                        <td style="width:15%" align="center">Remise</td>
                                        <td style="width:15%" align="center">Total</td>
                                        <td style="width:1%"align="center"></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="tr" style="display:none;">
                                        <td >
                                            <?php echo $this->Form->input('article_id', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignecommande', 'index' => '', 'id' => '', 'champ' => 'article_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => '', 'empty' => 'Veuillez Choisir !!')); ?>
                                            <?php echo $this->Form->input('sup', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignecommande', 'index' => '', 'id' => '', 'champ' => 'sup', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden')); ?>
                                            <?php echo $this->Form->input('id', array('div' => 'form-group', 'label' => '', 'name' => '', 'table' => 'Lignecommande', 'index' => '', 'id' => '', 'champ' => 'id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden')); ?>
                                        </td>
                                        <td><?php echo $this->Form->input('qte', array('div' => 'form-group', 'label' => '', 'type' => 'text', 'name' => '', 'table' => 'Lignecommande', 'index' => '', 'id' => '', 'champ' => 'qte', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeticket')); ?></td>
                                        <td><?php echo $this->Form->input('prix', array('div' => 'form-group', 'label' => '', 'type' => 'text', 'name' => '', 'table' => 'Lignecommande', 'index' => '', 'id' => '', 'champ' => 'prix', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeticket')); ?></td>
                                        <td><?php echo $this->Form->input('remise', array('div' => 'form-group', 'label' => '', 'type' => 'text', 'name' => '', 'table' => 'Lignecommande', 'index' => '', 'id' => '', 'champ' => 'remise', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeticket')); ?></td>
                                        <td><?php echo $this->Form->input('montant', array('div' => 'form-group', 'label' => '', 'type' => 'text', 'name' => '', 'table' => 'Lignecommande', 'index' => '', 'id' => '', 'champ' => 'montant', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeticket')); ?></td>

                                        <td>
                                            <i index=""  class="fa fa-times suphai" style="color: #c9302c;font-size: 22px;">
                                        </td>
                                    </tr>
                                    <?php
                                    $i =0;
                                    foreach ($ligneticketcaiss as  $ligne) { //debug($ligne);die; 
                                        $objpromo = ClassRegistry::init('Ticketcaisselignepromo');
                                        $countpromo = $objpromo->find('count', array(
                                            'conditions' => array(
                                                'Ticketcaisselignepromo.ticketcaisse_id' => $ligne['Ticketcaisseligne']['ticketcaisse_id']
                                                , 'Ticketcaisselignepromo.ticketcaisseligne_id' => $ligne['Ticketcaisseligne']['id']
                                                , 'Ticketcaisselignepromo.article_id' => $ligne['Ticketcaisseligne']['article_id'])
                                            , 'recursive' => -1));
                                        if (empty($ligne['Ticketcaisselignepromo'])) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td> 
                                                    <?php echo $this->Form->input('article_id', array('div' => 'form-group', 'label' => '', 'value' => $ligne['Ticketcaisseligne']['article_id'], 'name' => 'data[Lignecommande][' . $i . '][article_id]', 'table' => 'Lignecommande', 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!')); ?>
                                                    <?php echo $this->Form->input('sup', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignecommande][' . $i . '][sup]', 'table' => 'Lignecommande', 'index' => $i, 'id' => 'sup' . $i, 'champ' => 'sup', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden')); ?>
                                                </td>
                                                <td><?php echo $this->Form->input('qte', array('div' => 'form-group', 'label' => '', 'type' => 'text', 'value' => $ligne['Ticketcaisseligne']['qte'], 'name' => 'data[Lignecommande][' . $i . '][qte]', 'table' => 'Lignecommande', 'index' => $i, 'id' => 'qte' . $i, 'champ' => 'qte', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeticket')); ?></td>
                                                <td><?php echo $this->Form->input('prix', array('div' => 'form-group', 'label' => '', 'type' => 'text', 'value' => $ligne['Ticketcaisseligne']['prix'], 'name' => 'data[Lignecommande][' . $i . '][prix]', 'table' => 'Lignecommande', 'index' => $i, 'id' => 'prix' . $i, 'champ' => 'prix', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeticket')); ?></td>
                                                <td><?php echo $this->Form->input('montant', array('div' => 'form-group', 'label' => '', 'type' => 'text', 'value' => $ligne['Ticketcaisseligne']['montant'], 'name' => 'data[Lignecommande][' . $i . '][prix]', 'table' => 'Lignecommande', 'index' => $i, 'id' => 'prix' . $i, 'champ' => 'prix', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?></td>
                                                
                                                <td>
                                                    <i index="<?php echo $i; ?>"  class="fa fa-times suphai" style="color: #c9302c;font-size: 22px;">
                                                </td>
                                            </tr>
                                        <?php } 
                                        if(!empty($ligne['Ticketcaisselignepromo'])){
                                            foreach($ligne['Ticketcaisselignepromo'] as $k=>$promo){
                                                $i++;
                                        ?>
                                            
                                            
                                            <tr>
                                                <td> 
                                                    <?php echo $this->Form->input('article_id', array('div' => 'form-group', 'label' => '', 'value' => $ligne['Ticketcaisseligne']['article_id'], 'name' => 'data[Lignecommande][' . $i . '][article_id]', 'table' => 'Lignecommande', 'index' => $i, 'id' => 'article_id' . $i, 'champ' => 'article_id', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!')); ?>
                                                    <?php echo $this->Form->input('sup', array('div' => 'form-group', 'label' => '', 'name' => 'data[Lignecommande][' . $i . '][sup]', 'table' => 'Lignecommande', 'index' => $i, 'id' => 'sup' . $i, 'champ' => 'sup', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden')); ?>
                                                </td>
                                                <td><?php 
                                                $qq=$promo ['qtecmd']*$promo ['qteparlot'];
                                                echo $this->Form->input('qte', array('div' => 'form-group', 'label' => '', 'type' => 'text', 'value' => $qq, 'name' => 'data[Lignecommande][' . $i . '][qte]', 'table' => 'Lignecommande', 'index' => $i, 'id' => 'qte' . $i, 'champ' => 'qte', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeticket')); ?></td>
                                                <td><?php echo $this->Form->input('prix', array('div' => 'form-group', 'label' => '', 'type' => 'text', 'value' => $promo ['prixunite'], 'name' => 'data[Lignecommande][' . $i . '][prix]', 'table' => 'Lignecommande', 'index' => $i, 'id' => 'prix' . $i, 'champ' => 'prix', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control calculeticket')); ?></td>
                                                <td><?php 
                                                $tt=0;
                                                $tt=$promo ['prixunite']*$qq;
                                                $tt=sprintf('%.3f',$tt);
                                                echo $this->Form->input('montant', array('div' => 'form-group', 'label' => '', 'type' => 'text', 'value' =>$tt, 'name' => 'data[Lignecommande][' . $i . '][prix]', 'table' => 'Lignecommande', 'index' => $i, 'id' => 'prix' . $i, 'champ' => 'prix', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?></td>
                                                
                                                <td>
                                                    <i index="<?php echo $i; ?>"  class="fa fa-times suphai" style="color: #c9302c;font-size: 22px;">
                                                </td>
                                            </tr>
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            <?php } }?>
                                            
                                            
                                            
                                            
                                            
                                    <?php } ?>
                                </tbody>
                            </table>
                            <a class="btn btn-danger ajouterligne_haitham" table='addtablemag' index='indexmag' style="
                               float: right; 
                               position: relative;
                               top: -25px;
                               "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                            <input type="hidden" value="<?php echo $i ?>" id="indexmag" />
                        </div>
                    </div>
                </div>                                    














                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

