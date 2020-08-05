<input type="hidden" id="index_kbira" value="<?php echo $index_kbira; ?>">
<div class="row"  id='div_ajout_article'>
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Ajout Article'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Article', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh', 'enctype' => 'multipart/form-data')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('famille_id', array('div' => 'form-group', 'between' => '<div class="col-sm-10">', 'id' => 'famille_id', 'after' => '</div>', 'class' => 'form-control select getsousfamille', 'empty' => 'Veuillez Choisir !!'));
                    ?>
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Sous Famille'); ?></label>	


                        <div class='col-sm-10' champ="divsousfamille" id="divsousfamille" >     </div>
                    </div>                
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Sous sous Famille'); ?></label>	


                        <div class='col-sm-10' champ="divsoussousfamille" id="divsoussousfamille">     </div>



                    </div> 


                    <?php
                    echo $this->Form->input('unite_id', array('id' => 'unite_id', 'label' => 'Unité', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('code', array('id' => 'code', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control testarticleexiste'));
                    echo $this->Form->input('codeinter', array('label' => 'code NGP', 'id' => 'code internationnal', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control testarticleexiste'));
                    echo $this->Form->input('name', array('label' => 'Désignation', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('typeetatarticle_id', array('label' => 'Etat Article', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'id' => 'typeetatarticle_id', 'after' => '</div>', 'class' => 'form-control select ', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('typestockarticle_id', array('label' => 'Etat Stock', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'id' => 'typestockarticle_id', 'after' => '</div>', 'class' => 'form-control select ', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('tag_id', array('id' => 'tag_id', 'multiple' => 'multiple', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('homologation', array('label' => 'Photo', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'file', 'multiple' => "true", 'id' => "file-3"));
                    ?></div> 
                <div class="col-md-6"><?php
                    echo $this->Form->input('stockalert', array('label' => 'Stock Alert', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
//                    echo $this->Form->input('stockmin', array('label' => 'Stock Min', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
//                    echo $this->Form->input('stockmax', array('label' => 'Stock Max', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
//                    echo $this->Form->input('stockoptimal', array('label' => 'Stock Optimal', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('prixachatdevise', array('label' => 'Prix D\'achat en devise', 'type' => 'text', 'id' => 'prixachatdevise', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control getcoutderevient'));
                    echo $this->Form->input('tauxchange', array('value' => 1, 'label' => 'Taux De Change', 'type' => 'text', 'id' => 'tauxchange', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control getcoutderevient'));
                    echo $this->Form->input('coefficient', array('value' => 1, 'label' => 'Coefficient', 'type' => 'text', 'id' => 'coefficient', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control getcoutderevient'));
                    
                    echo $this->Form->input('prixav_remise', array('champ'=>'prixav_remise','label' => 'Prix achat avant remise', 'type' => 'text', 'id' => 'prixav_remise', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control  calculcoutrevient champsreadonly'));
                    echo $this->Form->input('remise', array('champ'=>'remise','label' => 'Remise', 'type' => 'text', 'id' => 'remise', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control calculcoutrevient champsreadonly'));
                    echo $this->Form->input('coutrevient', array('champ'=>'coutrevient','label' => 'Prix achat net', 'type' => 'text', 'id' => 'coutrevient', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control calculcoutrevient champsreadonly'));
                    
                    echo $this->Form->input('marge', array('readonly', 'label' => 'Marge %', 'type' => 'text', 'id' => 'margepourcentage', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control calculmarge calculputtc'));
                    echo $this->Form->input('prixvente', array('readonly', 'label' => 'Prix De Vente HT', 'type' => 'text', 'id' => 'prixvente', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control calculmargev calculmargevente calculputtc'));
//                    echo $this->Form->input('margegros', array('label' => 'Marge % en Gros', 'type' => 'text', 'id' => 'margepourcentagegros', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control calculmargegros'));
//                    echo $this->Form->input('prixventegros', array('label' => 'Prix De Vente en Gros', 'type' => 'text', 'id' => 'prixventegros', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control calculmargevgros'));
                    echo $this->Form->input('tva', array('readonly', 'id' => 'tva', 'label' => 'TVA', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control calculputtc'));
                    echo $this->Form->input('prixuttc', array('readonly', 'label' => 'Prix TTC', 'type' => 'text', 'id' => 'prixuttc', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
//                    echo $this->Form->input('remise', array('label' => 'Remise Caisse', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'text'));
                    echo $this->Form->input('remise_vente', array('readonly', 'id' => 'remise_vente', 'label' => 'Remise Vente', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'text'));
                    echo $this->Form->input('remise_transfert', array('label' => 'Remise Transfert', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'text'));
                    ?>


                </div> 





                <center>

                    <button type="submit"  class="remodal-confirm ls-light-green-btn btn" >Enregistrer</button>

                </center>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>

