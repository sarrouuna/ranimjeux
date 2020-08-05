<script language="JavaScript" type="text/JavaScript">
    function flvFPW1(){
    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
    }
</script>

<br><input type="hidden" id="page" value="1"/>


<div class="row">
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Critére d\'affichage'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Tracemisejour', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">                  
                    <?php
                    echo $this->Form->input('date_debut', array('label' => 'Historique de','value'=>$date_lyoumad, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly'));
                    echo $this->Form->input('Tablemodel', array('label'=>'Page','empty' => '--Veuillez choisir--', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('User', array('label'=>'Utilisateur','empty' => '--Veuillez choisir--', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>

                </div><div class="col-md-6">
                    <?php
                    echo $this->Form->input('date_fin', array('label' => 'au','value'=>$date_lyoumaf, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control datePickerOnly'));
                    echo $this->Form->input('Tableaction', array('label'=>'Operation','empty' => '--Veuillez choisir--', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>   

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3" >
                        <button   type="submit" class="btn btn-primary" >Afficher</button> 
                        <a href="<?php echo $this->webroot; ?>Tracemisejours/indexx" class="btn btn-primary">Afficher Tout</a>
                       <a onClick="flvFPW1(wr+'Tracemisejours/imprimerrecherche?utilisateur=<?php echo @$utilisateur;?>&date_debut=<?php echo @$date_debut;?>&date_fin=<?php echo @$date_fin;?>&operation=<?php echo @$operation;?>&model=<?php echo @$model;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>

                    </div>
                </div>
<?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div></div>



<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Historique Utilisateur'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		
		<th><?php echo ('Utilisateur'); ?></th>
	         
		<th><?php echo ('Horaire'); ?></th>
	         
		<th><?php echo ('Action'); ?></th>
	         	
        </tr></thead><tbody>
	<?php foreach ($tracemisejours as $tracemisejour):
      
     
     $wakt = date('H:i',strtotime('+1 hour',strtotime($tracemisejour['Tracemisejour']['heure'])));
       
        $oper="";
        $pag="";
        if($tracemisejour['Tracemisejour']['operation']=="add"){
            $oper="Ajout";
        }
        if($tracemisejour['Tracemisejour']['operation']=="edit"){
            $oper="Modification";
        }
        if($tracemisejour['Tracemisejour']['operation']=="delete"){
            $oper="Suppression";
        }
        
        if($tracemisejour['Tracemisejour']['model']=="Factureclient"){
            $pag="Facture client";
        }else{
        if($tracemisejour['Tracemisejour']['model']=="Commandeclient"){
            $pag="Commande client";
        }else{
        if($tracemisejour['Tracemisejour']['model']=="Reglementclient"){
            $pag="Reglement client";
        }else{
         if($tracemisejour['Tracemisejour']['model']=="Bonlivraison"){
            $pag="Bon livraison";
        }else{
        if($tracemisejour['Tracemisejour']['model']=="Factureavoir"){
            $pag="Facture avoir client";
        }else{
        if($tracemisejour['Tracemisejour']['model']=="Factureavoirfr"){
            $pag="Facture avoir fournisseur";
        }else{
           $pag= $tracemisejour['Tracemisejour']['model'];
        }
        }}}}}
        if($tracemisejour['Tracemisejour']['operation']=="delete"){
            $numero=" Numéro : ".$tracemisejour['Tracemisejour']['numero'];
        }else{
            if($tracemisejour['Tracemisejour']['model']=="Retrait"){
                $modeltoucher = ClassRegistry::init('Bordereau')->find('first',array('conditions'=>array('Bordereau.id' => $tracemisejour['Tracemisejour']['id_piece'])));  
            $numero=" Numéro : ".@$modeltoucher['Bordereau']['numero'];
            }else{
            $modeltoucher = ClassRegistry::init($tracemisejour['Tracemisejour']['model'])->find('first',array('conditions'=>array($tracemisejour['Tracemisejour']['model'].'.id' => $tracemisejour['Tracemisejour']['id_piece'])));  
            $numero=" Numéro : ".@$modeltoucher[$tracemisejour['Tracemisejour']['model']]['numero'];
        }
        }
        //debug($tracemisejour['Tracemisejour']['model']."".$pag);
            ?>
	<tr>
		<td ><?php echo $tracemisejour['Utilisateur']['Personnel']['name']; ?>&nbsp;</td>
		<td ><?php echo date("d/m/Y", strtotime(str_replace('-', '/',$tracemisejour['Tracemisejour']['date'])))." ".$wakt; ?>&nbsp;</td>
		<td ><?php echo $oper." ".$pag." ".@$numero; ?>&nbsp;</td>
		
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


