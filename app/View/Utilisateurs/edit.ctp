<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Utilisateurs/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Modification Utilisateur'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Utilisateur',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
                if ($this->request->data['Utilisateur']['composantsoc'] =="q") {
                $this->request->data['Utilisateur']['composantsoc'] =1 ;
                }
                if ($this->request->data['Utilisateur']['composantsoc'] == "f") {
                    $this->request->data['Utilisateur']['composantsoc'] = 2;
                }
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('personnel_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select selectptvente','required data-bv-notempty-message'=>'Champ Obligatoire') );
	?>
             <div class="form-group"> 
                    <label class="col-md-2 control-label">Poste</label>
                    <div class="col-sm-10">    
                 <?php if($pointdeventetest==0){ ?>        
                 Admin <input type="radio" name="poste" value="0" id="poste1" class="choixposte" checked="checked"> 
                Point de vente <input type="radio" name="poste" value="1" id="poste2" class="choixposte">
                <?php } else { ?>
                Admin <input type="radio" name="poste" value="0" id="poste1" class="choixposte"> 
                Point de vente <input type="radio" name="poste" value="1" id="poste2" class="choixposte" checked="checked">
                <?php } ?>
                  </div>
            </div>
               <div class="pointdevente" <?php if($pointdeventetest==0){ ?> style="display: none;" <?php } ?> >
                <?php
                ?>
                     <div class='form-group' id='divptvt'  style='display: yes !important'> 
                            <label class='col-md-2 control-label'><?php echo __('Point de vente'); ?></label> 
                            <div class='col-sm-10' champ="Pointdevente_id" id="divptvente" >
                             <?php  echo $this->Form->input('pointdevente_id',array('id'=>'Pointdevente_id','empty'=>'Veuillez choisir','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                            ?>
                            </div>
                        </div>
                </div> 
                 <div class='form-group' id='divsoc'  style='display: yes !important'> 
                        <label class='col-md-2 control-label'><?php echo __('Societe'); ?></label> 
                        <div class='col-sm-10' champ="Societe_id" id="divsociete" >
                             <?php  echo $this->Form->input('societe_id',array('multiple'=>'multiple','value'=>explode(",",@$this->request->data['Utilisateur']['societe_id']),'id'=>'Societe_id','empty'=>'Veuillez choisir','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                        ?>
                             </div>
                    </div>
                <div class="form-group"> 
                    <label class="col-md-2 control-label">Stock n&eacute;gative</label>
                    <div class="col-sm-10">    
                   <?php if($stocknegatiftest==0){ ?>      
                 NON <input type="radio" name="stocknegatif" value="0" checked="checked"> 
                 OUI <input type="radio" name="stocknegatif" value="1"> 
                <?php } else { ?>
                 NON <input type="radio" name="stocknegatif" value="0"> 
                 OUI <input type="radio" name="stocknegatif" value="1" checked="checked">  
                <?php } ?>
                    </div></div>
                <div class="form-group"> 
                    <label class="col-md-2 control-label">Blocage Client</label>
                    <div class="col-sm-10">    
                   <?php if($blocageclienttest==0){ ?>      
                 NON <input type="radio" name="blocageclient" value="0" checked="checked"> 
                 OUI <input type="radio" name="blocageclient" value="1"> 
                <?php } else { ?>
                 NON <input type="radio" name="blocageclient" value="0"> 
                 OUI <input type="radio" name="blocageclient" value="1" checked="checked">  
                <?php } ?>
                    </div></div>
            </div>                    
                                    
                <div class="col-md-6">
                <?php
		echo $this->Form->input('login',array('id'=>'login','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control testutilisateur','required data-bv-notempty-message'=>'Champ Obligatoire') );
		echo $this->Form->input('password',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
	        ?>
                     <?php
                    echo $this->Form->input('composantsoc', array('empty'=>'Veuillez choisir','label'=>'Articles&Clients&Frs','div' => 'form-group', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                <div class="pointdevente" <?php if($pointdeventetest==0){ ?> style="display: none;" <?php } ?> >
                <?php
                echo $this->Form->input('depot_id',array('empty'=>'Veuillez choisir','label'=>'Depot','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );
                ?>
                </div>
  </div>               

                                    
       <?php 
       $matrice=array(); 
        // debug($liens[0]['Lien']);die;                                   
        foreach ($liens as $lien){
            //debug($lien);die;
            
          foreach($lien['Lien'] as $l) {
               //debug($l);die;
            $matrice[$lien['Menu']['name']][$l['lien']]['add']=$l['add'];
            $matrice[$lien['Menu']['name']][$l['lien']]['edit']=$l['edit'];                     
            $matrice[$lien['Menu']['name']][$l['lien']]['delete']=$l['delete'];
            $matrice[$lien['Menu']['name']][$l['lien']]['imprimer']=$l['imprimer'];
          }   
           
          }                          
          // debug($matrice);die;                         
        ?>                              

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading ">
                                <h3 class="panel-title">Droit d'acces</h3>
                                
                            </div>
                            <div class="panel-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs icon-tab">
                                    <li class="active"><a href="#stock" data-toggle="tab"><i class="fa fa-home"></i> <span>Stock</span></a></li>
                                    <li class="param"><a href="#parametrage" data-toggle="tab"><i class="fa fa-gears"></i> <span>Parametrage</span></a></li>
                                    <li class="acha"><a href="#achat" data-toggle="tab"><i class="fa fa-home"></i> <span>Achat</span></a></li>
                                    <li class="acha"><a href="#vente" data-toggle="tab"><i class="fa fa-home"></i> <span>Vente</span></a></li>
                                    <li class="finance"><a href="#finance" data-toggle="tab"><i class="fa fa-gears"></i> <span>Finance</span></a></li>
                                    <li class="stat"><a href="#stat" data-toggle="tab"><i class="fa fa-gears"></i> <span>Statistique</span></a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content tab-border">
    <div class="tab-pane fade in active" id="stock">
<table  cellpadding="4" cellspacing="1" class="table" width="100%">

<tbody>
<tr>
    <td align="center">Autorisation <input type="checkbox" <?php if(isset($matrice['Stock'])){?> checked="checked"<?php } ?> name="acces[]" id="ventetab" value="1"></td>
    <td align="center">Ajout</td>
    <td align="center">Modification</td>
    <td align="center">Suppression</td>
    <td align="center">Impression</td>
</tr>

 <tr class="articles" >
    
    <td align="left">Article</td>
    <td align="center">
        <input type="checkbox" <?php if(@$matrice['Stock']['articles']['add']==1){?> checked="checked"<?php } ?> name="data[1][Lien][0][add]"  value="1">
    <input type="hidden"   name="data[1][Lien][0][lien]"  value="articles">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['articles']['edit']==1){?> checked="checked"<?php } ?>  name="data[1][Lien][0][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['articles']['delete']==1){?> checked="checked"<?php } ?>  name="data[1][Lien][0][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['articles']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[1][Lien][0][imprimer]"  value="1"></td>
 
 </tr>

 <tr class="familles" >
    <td align="left">Familles</td>
    <td align="center">
    <input type="checkbox" <?php if(@$matrice['Stock']['familles']['add']==1){?> checked="checked"<?php } ?> name="data[1][Lien][1][add]"  value="1">
    <input type="hidden"   name="data[1][Lien][1][lien]"  value="familles">
    </td>
    <td align="center"><input type="checkbox"  <?php if(@$matrice['Stock']['familles']['edit']==1){?> checked="checked"<?php } ?> name="data[1][Lien][1][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"  <?php if(@$matrice['Stock']['familles']['delete']==1){?> checked="checked"<?php } ?>name="data[1][Lien][1][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"  <?php if(@$matrice['Stock']['familles']['imprimer']==1){?> checked="checked"<?php } ?>name="data[1][Lien][1][imprimer]"  value="1"></td>

 </tr>


 <tr class="sousfamilles" >
    <td align="left">Sous familles</td>
    <td align="center">
    <input type="checkbox"  <?php if(@$matrice['Stock']['sousfamilles']['add']==1){?> checked="checked"<?php } ?>name="data[1][Lien][2][add]"  value="1">
    <input type="hidden"   name="data[1][Lien][2][lien]"  value="sousfamilles">
    </td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['sousfamilles']['edit']==1){?> checked="checked"<?php } ?>name="data[1][Lien][2][edit]"  value="1"></td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['sousfamilles']['delete']==1){?> checked="checked"<?php } ?>name="data[1][Lien][2][delete]"  value="1"></td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['sousfamilles']['imprimer']==1){?> checked="checked"<?php } ?>name="data[1][Lien][2][imprimer]"  value="1"></td>

 </tr>
 <tr class="soussousfamilles" >
    <td align="left">Sous sous familles</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Stock']['soussousfamilles']['add']==1){?> checked="checked"<?php } ?> name="data[1][Lien][3][add]"  value="1">
    <input type="hidden"   name="data[1][Lien][3][lien]"  value="soussousfamilles">
    </td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['soussousfamilles']['edit']==1){?> checked="checked"<?php } ?>name="data[1][Lien][3][edit]"  value="1"></td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['soussousfamilles']['delete']==1){?> checked="checked"<?php } ?>name="data[1][Lien][3][delete]"  value="1"></td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['soussousfamilles']['imprimer']==1){?> checked="checked"<?php } ?>name="data[1][Lien][3][imprimer]"  value="1"></td>

 </tr>
<tr class="unites" >
    <td align="left">Unites</td>
    <td align="center">
    <input type="checkbox" <?php if(@$matrice['Stock']['unites']['add']==1){?> checked="checked"<?php } ?>name="data[1][Lien][4][add]"  value="1">
    <input type="hidden"   name="data[1][Lien][4][lien]"  value="unites">
    </td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['unites']['edit']==1){?> checked="checked"<?php } ?> name="data[1][Lien][4][edit]"  value="1"></td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['unites']['delete']==1){?> checked="checked"<?php } ?>name="data[1][Lien][4][delete]"  value="1"></td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['unites']['imprimer']==1){?> checked="checked"<?php } ?>name="data[1][Lien][4][imprimer]"  value="1"></td>

 </tr>
 
 <tr class="transferts" >
    <td align="left">Transferts</td>
    <td align="center">
    <input type="checkbox" <?php if(@$matrice['Stock']['transferts']['add']==1){?> checked="checked"<?php } ?>name="data[1][Lien][10][add]"  value="1">
    <input type="hidden"   name="data[1][Lien][10][lien]"  value="transferts">
    </td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['transferts']['edit']==1){?> checked="checked"<?php } ?> name="data[1][Lien][10][edit]"  value="1"></td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['transferts']['delete']==1){?> checked="checked"<?php } ?> name="data[1][Lien][10][delete]"  value="1"></td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['transferts']['imprimer']==1){?> checked="checked"<?php } ?> name="data[1][Lien][10][imprimer]"  value="1"></td>

 </tr>
 
 
<tr class="tags" >
    <td align="left">Tags</td>
    <td align="center">
    <input type="checkbox" <?php if(@$matrice['Stock']['tags']['add']==1){?> checked="checked"<?php } ?>name="data[1][Lien][5][add]"  value="1">
    <input type="hidden"   name="data[1][Lien][5][lien]"  value="tags">
    </td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['tags']['edit']==1){?> checked="checked"<?php } ?> name="data[1][Lien][5][edit]"  value="1"></td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['tags']['delete']==1){?> checked="checked"<?php } ?> name="data[1][Lien][5][delete]"  value="1"></td>
    <td align="center"><input type="checkbox" <?php if(@$matrice['Stock']['tags']['imprimer']==1){?> checked="checked"<?php } ?> name="data[1][Lien][5][imprimer]"  value="1"></td>

 </tr>

 <tr class="inventaires" >
    <td align="left">Inventaires</td>
    <td align="center">
    <input type="checkbox"  <?php if(@$matrice['Stock']['inventaires']['add']==1){?> checked="checked"<?php } ?>name="data[1][Lien][6][add]"  value="1">
    <input type="hidden"   name="data[1][Lien][6][lien]"  value="inventaires">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['inventaires']['edit']==1){?> checked="checked"<?php } ?> name="data[1][Lien][6][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['inventaires']['delete']==1){?> checked="checked"<?php } ?> name="data[1][Lien][6][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['inventaires']['imprimer']==1){?> checked="checked"<?php } ?> name="data[1][Lien][6][imprimer]"  value="1"></td>

</tr>
<tr class="depots" >
    <td align="left">Dépots</td>
    <td align="center">
     <input type="checkbox"  <?php if(@$matrice['Stock']['depots']['add']==1){?> checked="checked"<?php } ?>name="data[1][Lien][7][add]"  value="1">
    <input type="hidden"   name="data[1][Lien][7][lien]"  value="depots">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['depots']['edit']==1){?> checked="checked"<?php } ?> name="data[1][Lien][7][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['depots']['delete']==1){?> checked="checked"<?php } ?> name="data[1][Lien][7][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['depots']['imprimer']==1){?> checked="checked"<?php } ?> name="data[1][Lien][7][imprimer]"  value="1"></td>

</tr>

<tr class="stockdepots" >
    <td align="left">Etat de Stock</td>
    <td align="center">
    <input type="hidden"  <?php if(@$matrice['Stock']['stockdepots']['add']==1){?> checked="checked"<?php } ?> name="data[1][Lien][9][lien]"  value="stockdepots">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['stockdepots']['imprimer']==1){?> checked="checked"<?php } ?> name="data[1][Lien][9][imprimer]"  value="1"></td>
</tr>
<tr class="bonreceptionstocks" >
    <td align="left">Bon Reception </td>
    <td align="center">
     <input type="checkbox"  <?php if(@$matrice['Stock']['bonreceptionstocks']['add']==1){?> checked="checked"<?php } ?>name="data[1][Lien][8][add]"  value="1">
    <input type="hidden"   name="data[1][Lien][8][lien]"  value="bonreceptionstocks">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['bonreceptionstocks']['edit']==1){?> checked="checked"<?php } ?> name="data[1][Lien][8][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['bonreceptionstocks']['delete']==1){?> checked="checked"<?php } ?> name="data[1][Lien][8][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['bonreceptionstocks']['imprimer']==1){?> checked="checked"<?php } ?> name="data[1][Lien][8][imprimer]"  value="1"></td>

</tr>
<tr class="bonsortiestocks" >
    <td align="left">Bon Sortie</td>
    <td align="center">
     <input type="checkbox"  <?php if(@$matrice['Stock']['bonsortiestocks']['add']==1){?> checked="checked"<?php } ?>name="data[1][Lien][11][add]"  value="1">
    <input type="hidden"   name="data[1][Lien][11][lien]"  value="bonsortiestocks">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['bonsortiestocks']['edit']==1){?> checked="checked"<?php } ?> name="data[1][Lien][11][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['bonsortiestocks']['delete']==1){?> checked="checked"<?php } ?> name="data[1][Lien][11][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['bonsortiestocks']['imprimer']==1){?> checked="checked"<?php } ?> name="data[1][Lien][11][imprimer]"  value="1"></td>

</tr>
<tr class="etatstockmins" >
    <td align="left">Etat de stock Min</td>
    <td align="center">
    <input type="hidden"   name="data[1][Lien][12][lien]"  value="etatstockmins">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['etatstockmins']['imprimer']==1){?> checked="checked"<?php } ?> name="data[1][Lien][12][imprimer]"  value="1"></td>
</tr>
<tr class="etatfuturcommandes" >
    <td align="left">Etat Futur Stock</td>
    <td align="center">
    <input type="hidden"   name="data[1][Lien][13][lien]"  value="etatfuturcommandes">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stock']['etatfuturcommandes']['imprimer']==1){?> checked="checked"<?php } ?> name="data[1][Lien][13][imprimer]"  value="1"></td>
</tr>
</tbody>
</table>


                                    </div>

    <div class="tab-pane fade in param" id="parametrage">
<table  cellpadding="4" cellspacing="1" class="table" width="100%">

<tbody>
<tr>
    <td align="center">Autorisation <input type="checkbox"<?php if(isset($matrice['Parametrage'])){?> checked="checked"<?php } ?>  name="acces[]" id="ventetab" value="2"></td>
    <td align="center">Ajout</td>
    <td align="center">Modification</td>
    <td align="center">Suppression</td>
    <td align="center">Impression</td>
</tr>
 <tr class="societes" >
    <td align="left">Societés</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Parametrage']['societes']['add']==1){?> checked="checked"<?php } ?> name="data[2][Lien][0][add]"  value="1">
    <input type="hidden"   name="data[2][Lien][0][lien]"  value="societes">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['societes']['edit']==1){?> checked="checked"<?php } ?> name="data[2][Lien][0][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['societes']['delete']==1){?> checked="checked"<?php } ?> name="data[2][Lien][0][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['societes']['imprimer']==1){?> checked="checked"<?php } ?> name="data[2][Lien][0][imprimer]"  value="1"></td>
    
</tr>

 <tr class="fonctions" >
    <td align="left">Fonctions</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Parametrage']['fonctions']['add']==1){?> checked="checked"<?php } ?> name="data[2][Lien][1][add]"  value="1">
    <input type="hidden"   name="data[2][Lien][1][lien]"  value="fonctions">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['fonctions']['edit']==1){?> checked="checked"<?php } ?>  name="data[2][Lien][1][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['fonctions']['delete']==1){?> checked="checked"<?php } ?>  name="data[2][Lien][1][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['fonctions']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[2][Lien][1][imprimer]"  value="1"></td>

 </tr>


 <tr class="personnels" >
    <td align="left">Personnels</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Parametrage']['personnels']['add']==1){?> checked="checked"<?php } ?> name="data[2][Lien][2][add]"  value="1">
    <input type="hidden"   name="data[2][Lien][2][lien]"  value="personnels">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['personnels']['edit']==1){?> checked="checked"<?php } ?> name="data[2][Lien][2][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['personnels']['delete']==1){?> checked="checked"<?php } ?> name="data[2][Lien][2][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['personnels']['imprimer']==1){?> checked="checked"<?php } ?> name="data[2][Lien][2][imprimer]"  value="1"></td>

 </tr>
 <tr class="utilisateurs" >
    <td align="left">Utilisateurs</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Parametrage']['utilisateurs']['add']==1){?> checked="checked"<?php } ?> name="data[2][Lien][3][add]"  value="1">
    <input type="hidden"   name="data[2][Lien][3][lien]"  value="utilisateurs">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['utilisateurs']['edit']==1){?> checked="checked"<?php } ?> name="data[2][Lien][3][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['utilisateurs']['delete']==1){?> checked="checked"<?php } ?> name="data[2][Lien][3][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['utilisateurs']['imprimer']==1){?> checked="checked"<?php } ?> name="data[2][Lien][3][imprimer]"  value="1"></td>

 </tr>
  <tr class="pointdeventes" >
    <td align="left">Points De Ventes</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Parametrage']['pointdeventes']['add']==1){?> checked="checked"<?php } ?> name="data[2][Lien][4][add]"  value="1">
    <input type="hidden"   name="data[2][Lien][4][lien]"  value="pointdeventes">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['pointdeventes']['edit']==1){?> checked="checked"<?php } ?> name="data[2][Lien][4][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['pointdeventes']['delete']==1){?> checked="checked"<?php } ?> name="data[2][Lien][4][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['pointdeventes']['imprimer']==1){?> checked="checked"<?php } ?> name="data[2][Lien][4][imprimer]"  value="1"></td>

 </tr>
 </tr>
  <tr class="exercices" >
    <td align="left">Exercices</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Parametrage']['exercices']['add']==1){?> checked="checked"<?php } ?> name="data[2][Lien][5][add]"  value="1">
    <input type="hidden"   name="data[2][Lien][5][lien]"  value="exercices">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['exercices']['edit']==1){?> checked="checked"<?php } ?> name="data[2][Lien][5][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['exercices']['delete']==1){?> checked="checked"<?php } ?> name="data[2][Lien][5][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['exercices']['imprimer']==1){?> checked="checked"<?php } ?> name="data[2][Lien][5][imprimer]"  value="1"></td>

 </tr>
 <tr class="workflows" >
    <td align="left">Ordres de travail</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Parametrage']['workflows']['add']==1){?> checked="checked"<?php } ?> name="data[2][Lien][6][add]"  value="1">
    <input type="hidden"   name="data[2][Lien][6][lien]"  value="workflows">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['workflows']['edit']==1){?> checked="checked"<?php } ?> name="data[2][Lien][6][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['workflows']['delete']==1){?> checked="checked"<?php } ?> name="data[2][Lien][6][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['workflows']['imprimer']==1){?> checked="checked"<?php } ?> name="data[2][Lien][6][imprimer]"  value="1"></td>

 </tr>
 <tr class="etatworkflows" >
    <td align="left">Etat d'ordres de travail</td>
    <td align="center">
    <input type="hidden"   name="data[2][Lien][7][lien]"  value="etatworkflows">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['etatworkflows']['imprimer']==1){?> checked="checked"<?php } ?> name="data[2][Lien][7][imprimer]"  value="1"></td>

 </tr>
  <tr class="tracemisejours" >
    <td align="left">Historique utilisateur</td>
    <td align="center">
    <input type="hidden"   name="data[2][Lien][8][lien]"  value="tracemisejours">
    </td>
    <td align="center">
    </td>
    <td align="center">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Parametrage']['tracemisejours']['imprimer']==1){?> checked="checked"<?php } ?> name="data[2][Lien][8][imprimer]"  value="1"></td>

 </tr>
</tbody>
</table>


                                    </div>
                                    
    <div class="tab-pane fade in param" id="achat">
<table  cellpadding="4" cellspacing="1" class="table" width="100%">

<tbody>
<tr>
    <td align="center">Autorisation <input type="checkbox"<?php if(isset($matrice['Achat'])){?> checked="checked"<?php } ?>  name="acces[]" id="ventetab" value="3"></td>
    <td align="center">Ajout</td>
    <td align="center">Modification</td>
    <td align="center">Suppression</td>
    <td align="center">Impression</td>
</tr>
 

 <tr class="fournisseurs" >
    <td align="left">Fournisseurs</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Achat']['fournisseurs']['add']==1){?> checked="checked"<?php } ?> name="data[3][Lien][0][add]"  value="1">
    <input type="hidden"   name="data[3][Lien][0][lien]"  value="fournisseurs">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['fournisseurs']['edit']==1){?> checked="checked"<?php } ?>  name="data[3][Lien][0][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['fournisseurs']['delete']==1){?> checked="checked"<?php } ?>  name="data[3][Lien][0][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['fournisseurs']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[3][Lien][0][imprimer]"  value="1"></td>

 </tr>


 <tr class="famillefournisseurs" >
    <td align="left">famille fournisseurs</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Achat']['famillefournisseurs']['add']==1){?> checked="checked"<?php } ?> name="data[3][Lien][1][add]"  value="1">
    <input type="hidden"   name="data[3][Lien][1][lien]"  value="famillefournisseurs">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['famillefournisseurs']['edit']==1){?> checked="checked"<?php } ?> name="data[3][Lien][1][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['famillefournisseurs']['delete']==1){?> checked="checked"<?php } ?> name="data[3][Lien][1][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['famillefournisseurs']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][1][imprimer]"  value="1"></td>

 </tr>
 <tr class="bonreceptions" >
    <td align="left">Bons de Livraisons</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Achat']['bonreceptions']['add']==1){?> checked="checked"<?php } ?> name="data[3][Lien][2][add]"  value="1">
    <input type="hidden"   name="data[3][Lien][2][lien]"  value="bonreceptions">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['bonreceptions']['edit']==1){?> checked="checked"<?php } ?> name="data[3][Lien][2][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['bonreceptions']['delete']==1){?> checked="checked"<?php } ?> name="data[3][Lien][2][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['bonreceptions']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][2][imprimer]"  value="1"></td>

 </tr>
 <tr class="factures" >
    <td align="left">Factures</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Achat']['factures']['add']==1){?> checked="checked"<?php } ?> name="data[3][Lien][3][add]"  value="1">
    <input type="hidden"   name="data[3][Lien][3][lien]"  value="factures">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['factures']['edit']==1){?> checked="checked"<?php } ?> name="data[3][Lien][3][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['factures']['delete']==1){?> checked="checked"<?php } ?> name="data[3][Lien][3][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['factures']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][3][imprimer]"  value="1"></td>

 </tr>
 <tr class="factureavoirfrs" >
    <td align="left">Factures Avoir</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Achat']['factureavoirfrs']['add']==1){?> checked="checked"<?php } ?> name="data[3][Lien][14][add]"  value="1">
    <input type="hidden"   name="data[3][Lien][14][lien]"  value="factureavoirfrs">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['factureavoirfrs']['edit']==1){?> checked="checked"<?php } ?> name="data[3][Lien][14][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['factureavoirfrs']['delete']==1){?> checked="checked"<?php } ?> name="data[3][Lien][14][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['factureavoirfrs']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][14][imprimer]"  value="1"></td>

 </tr>
 <tr class="deviprospects" >
    <td align="left">Suggestion Commandes</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Achat']['deviprospects']['add']==1){?> checked="checked"<?php } ?> name="data[3][Lien][10][add]"  value="1">
    <input type="hidden"   name="data[3][Lien][10][lien]"  value="deviprospects">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['deviprospects']['edit']==1){?> checked="checked"<?php } ?> name="data[3][Lien][10][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['deviprospects']['delete']==1){?> checked="checked"<?php } ?> name="data[3][Lien][10][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['deviprospects']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][10][imprimer]"  value="1"></td>

 </tr>
 <tr class="commandes" >
    <td align="left">Commandes</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Achat']['commandes']['add']==1){?> checked="checked"<?php } ?> name="data[3][Lien][4][add]"  value="1">
    <input type="hidden"   name="data[3][Lien][4][lien]"  value="commandes">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['commandes']['edit']==1){?> checked="checked"<?php } ?> name="data[3][Lien][4][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['commandes']['delete']==1){?> checked="checked"<?php } ?> name="data[3][Lien][4][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['commandes']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][4][imprimer]"  value="1"></td>

 </tr>
 <tr class="relevefournisseurs" >
    <td align="left">Releve fournisseurs</td>
    <td align="center">
    <input type="hidden"   name="data[3][Lien][7][lien]"  value="relevefournisseurs">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['relevefournisseurs']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][7][imprimer]"  value="1"></td>

 </tr>
 <tr class="reglements" >
    <td align="left">Reglement</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Achat']['reglements']['add']==1){?> checked="checked"<?php } ?> name="data[3][Lien][5][add]"  value="1">
    <input type="hidden"   name="data[3][Lien][5][lien]"  value="reglements">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['reglements']['edit']==1){?> checked="checked"<?php } ?> name="data[3][Lien][5][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['reglements']['delete']==1){?> checked="checked"<?php } ?> name="data[3][Lien][5][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['reglements']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][5][imprimer]"  value="1"></td>

 </tr>
 <tr class="piecereglements" >
    <td align="left">Etat de caisse</td>
    <td align="center">
    <input type="hidden"   name="data[3][Lien][6][lien]"  value="piecereglements">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['piecereglements']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][6][imprimer]"  value="1"></td>

 </tr>
 <tr class="importations" >
    <td align="left">Importation</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Achat']['importations']['add']==1){?> checked="checked"<?php } ?> name="data[3][Lien][8][add]"  value="1">
    <input type="hidden"   name="data[3][Lien][8][lien]"  value="importations">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['importations']['edit']==1){?> checked="checked"<?php } ?> name="data[3][Lien][8][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['importations']['delete']==1){?> checked="checked"<?php } ?> name="data[3][Lien][8][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['importations']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][8][imprimer]"  value="1"></td>

 </tr>
 <tr class="namepiecejointes" >
    <td align="left">Désignation piece jointe</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Achat']['namepiecejointes']['add']==1){?> checked="checked"<?php } ?> name="data[3][Lien][9][add]"  value="1">
    <input type="hidden"   name="data[3][Lien][9][lien]"  value="namepiecejointes">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['namepiecejointes']['edit']==1){?> checked="checked"<?php } ?> name="data[3][Lien][9][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['namepiecejointes']['delete']==1){?> checked="checked"<?php } ?> name="data[3][Lien][9][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['namepiecejointes']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][9][imprimer]"  value="1"></td>

 </tr>
 <tr class="namesituations" >
    <td align="left">Désignation Situation</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Achat']['namesituations']['add']==1){?> checked="checked"<?php } ?> name="data[3][Lien][11][add]"  value="1">
    <input type="hidden"   name="data[3][Lien][11][lien]"  value="namesituations">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['namesituations']['edit']==1){?> checked="checked"<?php } ?> name="data[3][Lien][11][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['namesituations']['delete']==1){?> checked="checked"<?php } ?> name="data[3][Lien][11][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['namesituations']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][11][imprimer]"  value="1"></td>

 </tr>
 <tr class="engagementfournisseurs" >
    <td align="left">Engagement Fournisseur</td>
    <td align="center">
    <input type="hidden"   name="data[3][Lien][12][lien]"  value="engagementfournisseurs">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['engagementfournisseurs']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][12][imprimer]"  value="1"></td>

 </tr>
 <tr class="etatpiecereglements" >
    <td align="left">Etat Piece Reglement</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Achat']['etatpiecereglements']['add']==1){?> checked="checked"<?php } ?> name="data[3][Lien][13][add]"  value="1">
    <input type="hidden"   name="data[3][Lien][13][lien]"  value="etatpiecereglements">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['etatpiecereglements']['edit']==1){?> checked="checked"<?php } ?> name="data[3][Lien][13][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['etatpiecereglements']['delete']==1){?> checked="checked"<?php } ?> name="data[3][Lien][13][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Achat']['etatpiecereglements']['imprimer']==1){?> checked="checked"<?php } ?> name="data[3][Lien][13][imprimer]"  value="1"></td>

 </tr>
 
</tbody>
</table>
                                    </div>
                                    
    <div class="tab-pane fade in param" id="vente">
<table  cellpadding="4" cellspacing="1" class="table" width="100%">

<tbody>
<tr>
    <td align="center">Autorisation <input type="checkbox"<?php if(isset($matrice['Vente'])){?> checked="checked"<?php } ?>  name="acces[]" id="ventetab" value="4"></td>
    <td align="center">Ajout</td>
    <td align="center">Modification</td>
    <td align="center">Suppression</td>
    <td align="center">Impression</td>
</tr>
 

 <tr class="clients" >
    <td align="left">Clients</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Vente']['clients']['add']==1){?> checked="checked"<?php } ?> name="data[4][Lien][0][add]"  value="1">
    <input type="hidden"   name="data[4][Lien][0][lien]"  value="clients">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['clients']['edit']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][0][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['clients']['delete']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][0][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['clients']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][0][imprimer]"  value="1"></td>

 </tr>
 <tr class="familleclients" >
    <td align="left">Famille clients</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Vente']['familleclients']['add']==1){?> checked="checked"<?php } ?> name="data[4][Lien][6][add]"  value="1">
    <input type="hidden"   name="data[4][Lien][6][lien]"  value="familleclients">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['familleclients']['edit']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][6][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['familleclients']['delete']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][6][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['familleclients']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][6][imprimer]"  value="1"></td>

 </tr>
 <tr class="sousfamilleclients" >
    <td align="left">Sous familles clients</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Vente']['sousfamilleclients']['add']==1){?> checked="checked"<?php } ?> name="data[4][Lien][7][add]"  value="1">
    <input type="hidden"   name="data[4][Lien][7][lien]"  value="sousfamilleclients">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['sousfamilleclients']['edit']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][7][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['sousfamilleclients']['delete']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][7][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['sousfamilleclients']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][7][imprimer]"  value="1"></td>

 </tr>
 <tr class="pays" >
    <td align="left">Pays</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Vente']['pays']['add']==1){?> checked="checked"<?php } ?> name="data[4][Lien][13][add]"  value="1">
    <input type="hidden"   name="data[4][Lien][13][lien]"  value="pays">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['pays']['edit']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][13][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['pays']['delete']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][13][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['pays']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][13][imprimer]"  value="1"></td>

 </tr>
 <tr class="zones" >
    <td align="left">Zones</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Vente']['zones']['add']==1){?> checked="checked"<?php } ?> name="data[4][Lien][8][add]"  value="1">
    <input type="hidden"   name="data[4][Lien][8][lien]"  value="zones">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['zones']['edit']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][8][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['zones']['delete']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][8][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['zones']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][8][imprimer]"  value="1"></td>

 </tr>
 
 
 <tr class="bonlivraisons" >
    <td align="left">Bon livraisons</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Vente']['bonlivraisons']['add']==1){?> checked="checked"<?php } ?> name="data[4][Lien][1][add]"  value="1">
    <input type="hidden"   name="data[4][Lien][1][lien]"  value="bonlivraisons">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['bonlivraisons']['edit']==1){?> checked="checked"<?php } ?> name="data[4][Lien][1][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['bonlivraisons']['delete']==1){?> checked="checked"<?php } ?> name="data[4][Lien][1][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['bonlivraisons']['imprimer']==1){?> checked="checked"<?php } ?> name="data[4][Lien][1][imprimer]"  value="1"></td>

 </tr>
<tr class="factureclients" >
    <td align="left">Factures</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Vente']['factureclients']['add']==1){?> checked="checked"<?php } ?> name="data[4][Lien][2][add]"  value="1">
    <input type="hidden"   name="data[4][Lien][2][lien]"  value="factureclients">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['factureclients']['edit']==1){?> checked="checked"<?php } ?> name="data[4][Lien][2][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['factureclients']['delete']==1){?> checked="checked"<?php } ?> name="data[4][Lien][2][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['factureclients']['imprimer']==1){?> checked="checked"<?php } ?> name="data[4][Lien][2][imprimer]"  value="1"></td>

 </tr>
 <tr class="commandeclients" >
    <td align="left">Commandes</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Vente']['commandeclients']['add']==1){?> checked="checked"<?php } ?> name="data[4][Lien][3][add]"  value="1">
    <input type="hidden"   name="data[4][Lien][3][lien]"  value="commandeclients">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['commandeclients']['edit']==1){?> checked="checked"<?php } ?> name="data[4][Lien][3][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['commandeclients']['delete']==1){?> checked="checked"<?php } ?> name="data[4][Lien][3][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['commandeclients']['imprimer']==1){?> checked="checked"<?php } ?> name="data[4][Lien][3][imprimer]"  value="1"></td>

 </tr>
 <tr class="devis" >
    <td align="left">Devis</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Vente']['devis']['add']==1){?> checked="checked"<?php } ?> name="data[4][Lien][4][add]"  value="1">
    <input type="hidden"   name="data[4][Lien][4][lien]"  value="devis">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['devis']['edit']==1){?> checked="checked"<?php } ?> name="data[4][Lien][4][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['devis']['delete']==1){?> checked="checked"<?php } ?> name="data[4][Lien][4][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['devis']['imprimer']==1){?> checked="checked"<?php } ?> name="data[4][Lien][4][imprimer]"  value="1"></td>

 </tr>
 <tr class="factureavoirs" >
    <td align="left">Factures à voir</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Vente']['factureavoirs']['add']==1){?> checked="checked"<?php } ?> name="data[4][Lien][9][add]"  value="1">
    <input type="hidden"   name="data[4][Lien][9][lien]"  value="factureavoirs">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['factureavoirs']['edit']==1){?> checked="checked"<?php } ?> name="data[4][Lien][9][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['factureavoirs']['delete']==1){?> checked="checked"<?php } ?> name="data[4][Lien][9][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['factureavoirs']['imprimer']==1){?> checked="checked"<?php } ?> name="data[4][Lien][9][imprimer]"  value="1"></td>

 </tr>

 <tr class="reglementclients" >
    <td align="left">Reglement clients</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Vente']['reglementclients']['add']==1){?> checked="checked"<?php } ?> name="data[4][Lien][10][add]"  value="1">
    <input type="hidden"   name="data[4][Lien][10][lien]"  value="reglementclients">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['reglementclients']['edit']==1){?> checked="checked"<?php } ?> name="data[4][Lien][10][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['reglementclients']['delete']==1){?> checked="checked"<?php } ?> name="data[4][Lien][10][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['reglementclients']['imprimer']==1){?> checked="checked"<?php } ?> name="data[4][Lien][10][imprimer]"  value="1"></td>

 </tr>
  <tr class="piecereglementclients" >
    <td align="left">Etat de caisse</td>
    <td align="center">
    <input type="hidden"   name="data[4][Lien][11][lien]"  value="piecereglementclients">
    </td>
    <td align="center"></td>
    <td align="center"> </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['piecereglementclients']['imprimer']==1){?> checked="checked"<?php } ?> name="data[4][Lien][11][imprimer]"  value="1"></td>

 </tr>
 <tr class="releves" >
    <td align="left">Etat Solde Client</td>
    <td align="center">
    <input type="hidden"   name="data[4][Lien][12][lien]"  value="releves">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['releves']['imprimer']==1){?> checked="checked"<?php } ?> name="data[4][Lien][12][imprimer]"  value="1"></td>
</tr>
<tr class="etatsoldecommandeclients" >
    <td align="left">Etat Solde Commandes Clients</td>
    <td align="center">
    <input type="hidden"   name="data[4][Lien][5][lien]"  value="etatsoldecommandeclients">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['etatsoldecommandeclients']['imprimer']==1){?> checked="checked"<?php } ?> name="data[4][Lien][5][imprimer]"  value="1"></td>
</tr>
<tr class="etathistoriquearticles" >
    <td align="left">Historique Article</td>
    <td align="center">
    <input type="hidden"   name="data[4][Lien][14][lien]"  value="etathistoriquearticles">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['etathistoriquearticles']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][14][imprimer]"  value="1"></td>

 </tr>
 <tr class="etatligneventes" >
    <td align="left">Vente Journalier</td>
    <td align="center">
    <input type="hidden"   name="data[4][Lien][15][lien]"  value="etatligneventes">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Vente']['etatligneventes']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[4][Lien][15][imprimer]"  value="1"></td>

 </tr>
</tbody>
</table>
                                    </div> 
                                    
    <div class="tab-pane fade in finance" id="finance">
<table  cellpadding="4" cellspacing="1" class="table" width="100%">

<tbody>
<tr>
    <td align="center">Autorisation <input type="checkbox"<?php if(isset($matrice['Finance'])){?> checked="checked"<?php } ?>  name="acces[]" id="ventetab" value="5"></td>
    <td align="center">Ajout</td>
    <td align="center">Modification</td>
    <td align="center">Suppression</td>
    <td align="center">Impression</td>
</tr>
 <tr class="comptes" >
    <td align="left">Comptes</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Finance']['comptes']['add']==1){?> checked="checked"<?php } ?> name="data[5][Lien][0][add]"  value="1">
    <input type="hidden"   name="data[5][Lien][0][lien]"  value="comptes">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['comptes']['edit']==1){?> checked="checked"<?php } ?> name="data[5][Lien][0][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['comptes']['delete']==1){?> checked="checked"<?php } ?> name="data[5][Lien][0][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['comptes']['imprimer']==1){?> checked="checked"<?php } ?> name="data[5][Lien][0][imprimer]"  value="1"></td>

</tr>
<tr class="carnetcheques" >
    <td align="left">Souche chequier</td>
    <td align="center">
    <input type="checkbox"<?php if(@$matrice['Finance']['carnetcheques']['add']==1){?> checked="checked"<?php } ?> name="data[5][Lien][9][add]"  value="1">
    <input type="hidden"   name="data[5][Lien][9][lien]"  value="carnetcheques">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['carnetcheques']['edit']==1){?> checked="checked"<?php } ?> name="data[5][Lien][9][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['carnetcheques']['delete']==1){?> checked="checked"<?php } ?> name="data[5][Lien][9][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['carnetcheques']['imprimer']==1){?> checked="checked"<?php } ?> name="data[5][Lien][9][imprimer]"  value="1"></td>

</tr>
 <tr class="bordereaus" >
    <td align="left">Bordereaus</td>
     <td align="center">
    <input type="checkbox"<?php if(@$matrice['Finance']['bordereaus']['add']==1){?> checked="checked"<?php } ?> name="data[5][Lien][1][add]"  value="1">
    <input type="hidden"   name="data[5][Lien][1][lien]"  value="bordereaus">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['bordereaus']['edit']==1){?> checked="checked"<?php } ?> name="data[5][Lien][1][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['bordereaus']['delete']==1){?> checked="checked"<?php } ?> name="data[5][Lien][1][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['bordereaus']['imprimer']==1){?> checked="checked"<?php } ?> name="data[5][Lien][1][imprimer]"  value="1"></td>

</tr>
 <tr class="alimentations" >
    <td align="left">Alimentation caisse</td>
     <td align="center">
    <input type="checkbox"<?php if(@$matrice['Finance']['alimentations']['add']==1){?> checked="checked"<?php } ?> name="data[5][Lien][10][add]"  value="1">
    <input type="hidden"   name="data[5][Lien][10][lien]"  value="alimentations">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['alimentations']['edit']==1){?> checked="checked"<?php } ?> name="data[5][Lien][10][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['alimentations']['delete']==1){?> checked="checked"<?php } ?> name="data[5][Lien][10][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['alimentations']['imprimer']==1){?> checked="checked"<?php } ?> name="data[5][Lien][10][imprimer]"  value="1"></td>

</tr>
 <tr class="versements" >
    <td align="left">Versements</td>
     <td align="center">
    <input type="checkbox"<?php if(@$matrice['Finance']['versements']['add']==1){?> checked="checked"<?php } ?> name="data[5][Lien][2][add]"  value="1">
    <input type="hidden"   name="data[5][Lien][2][lien]"  value="versements">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['versements']['edit']==1){?> checked="checked"<?php } ?> name="data[5][Lien][2][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['versements']['delete']==1){?> checked="checked"<?php } ?> name="data[5][Lien][2][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['versements']['imprimer']==1){?> checked="checked"<?php } ?> name="data[5][Lien][2][imprimer]"  value="1"></td>

</tr>
<tr class="sortiecaissees" >
    <td align="left">Sortie caisse</td>
     <td align="center">
    <input type="checkbox"<?php if(@$matrice['Finance']['sortiecaissees']['add']==1){?> checked="checked"<?php } ?> name="data[5][Lien][3][add]"  value="1">
    <input type="hidden"   name="data[5][Lien][3][lien]"  value="sortiecaissees">
    </td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['sortiecaissees']['edit']==1){?> checked="checked"<?php } ?> name="data[5][Lien][3][edit]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['sortiecaissees']['delete']==1){?> checked="checked"<?php } ?> name="data[5][Lien][3][delete]"  value="1"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['sortiecaissees']['imprimer']==1){?> checked="checked"<?php } ?> name="data[5][Lien][3][imprimer]"  value="1"></td>

</tr>
<tr class="interne" >
    <td align="left">Caisse interne</td>
    <td align="center">
    <input type="hidden"   name="data[5][Lien][11][lien]"  value="interne">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['interne']['imprimer']==1){?> checked="checked"<?php } ?> name="data[5][Lien][11][imprimer]"  value="1"></td>
</tr>
<tr class="caissees" >
    <td align="left">Caisse</td>
    <td align="center">
    <input type="hidden"   name="data[5][Lien][4][lien]"  value="caissees">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['caissees']['imprimer']==1){?> checked="checked"<?php } ?> name="data[5][Lien][4][imprimer]"  value="1"></td>
</tr>
<tr class="retenue" >
    <td align="left">Retenue Clients</td>
    <td align="center">
    <input type="hidden"   name="data[5][Lien][5][lien]"  value="retenue">
    </td>
   <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['retenue']['imprimer']==1){?> checked="checked"<?php } ?> name="data[5][Lien][5][imprimer]"  value="1"></td>
</tr>
<tr class="retenuefournisseur" >
    <td align="left">Retenue Fournisseurs</td>
    <td align="center">
    <input type="hidden"   name="data[5][Lien][6][lien]"  value="retenuefournisseur">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['retenuefournisseur']['imprimer']==1){?> checked="checked"<?php } ?> name="data[5][Lien][6][imprimer]"  value="1"></td>
</tr>
<tr class="etatvente" >
    <td align="left">Etat des ventes</td>
    <td align="center">
    <input type="hidden"   name="data[5][Lien][7][lien]"  value="etatvente">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['etatvente']['imprimer']==1){?> checked="checked"<?php } ?> name="data[5][Lien][7][imprimer]"  value="1"></td>
</tr>
<tr class="etatachat" >
    <td align="left">Etat des achats</td>
    <td align="center">
    <input type="hidden"   name="data[5][Lien][8][lien]"  value="etatachat">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Finance']['etatachat']['imprimer']==1){?> checked="checked"<?php } ?> name="data[5][Lien][8][imprimer]"  value="1"></td>
</tr>

</tbody>
</table>

                                    </div>
                                    
    <div class="tab-pane fade in param" id="stat">
<table  cellpadding="4" cellspacing="1" class="table" width="100%">

<tbody>
<tr>
    <td align="center">Autorisation <input type="checkbox"<?php if(isset($matrice['Stat'])){?> checked="checked"<?php } ?>  name="acces[]" id="ventetab" value="6"></td>
    <td align="center">Ajout</td>
    <td align="center">Modification</td>
    <td align="center">Suppression</td>
    <td align="center">Impression</td>
</tr>
 <tr class="etatclients" >
    <td align="left">CA par client</td>
    <td align="center">
    <input type="hidden"   name="data[6][Lien][0][lien]"  value="etatclients">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stat']['etatclients']['imprimer']==1){?> checked="checked"<?php } ?> name="data[6][Lien][0][imprimer]"  value="1"></td>
    
</tr>
<tr class="etatarticles" >
    <td align="left">CA par Article</td>
    <td align="center">
    <input type="hidden"   name="data[6][Lien][2][lien]"  value="etatarticles">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stat']['etatarticles']['imprimer']==1){?> checked="checked"<?php } ?> name="data[6][Lien][2][imprimer]"  value="1"></td>
    
</tr>

 <tr class="etatclientarticles" >
    <td align="left">CA par client/Article</td>
    <td align="center">
    <input type="hidden"   name="data[6][Lien][1][lien]"  value="etatclientarticles">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stat']['etatclientarticles']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[6][Lien][1][imprimer]"  value="1"></td>

 </tr>
<tr class="etatpointdeventes" >
    <td align="left">CA par Point De Vente</td>
    <td align="center">
    <input type="hidden"   name="data[6][Lien][3][lien]"  value="etatpointdeventes">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stat']['etatpointdeventes']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[6][Lien][3][imprimer]"  value="1"></td>

 </tr>

<tr class="etatcaarticles" >
    <td align="left">CA par Article/Année</td>
    <td align="center">
    <input type="hidden"   name="data[6][Lien][4][lien]"  value="etatcaarticles">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stat']['etatcaarticles']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[6][Lien][4][imprimer]"  value="1"></td>

 </tr>
 
 
<tr class="etatcaclientarticles" >
    <td align="left">CA par Client/Année</td>
    <td align="center">
    <input type="hidden"   name="data[6][Lien][5][lien]"  value="etatcaclientarticles">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stat']['etatcaclientarticles']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[6][Lien][5][imprimer]"  value="1"></td>

 </tr>
 
 <tr class="etatcapersonnels" >
    <td align="left">CA par Personnel</td>
    <td align="center">
    <input type="hidden"   name="data[6][Lien][6][lien]"  value="etatcapersonnels">
    </td>
    <td align="center"></td>
    <td align="center"></td>
    <td align="center"><input type="checkbox"<?php if(@$matrice['Stat']['etatcapersonnels']['imprimer']==1){?> checked="checked"<?php } ?>  name="data[6][Lien][6][imprimer]"  value="1"></td>

 </tr>
 
</tbody>
</table>


                                    </div>                                 
                                    
                                    
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </div>
<?php echo $this->Form->end();?>
                </div>
                            </div>
                        </div>
</div>

