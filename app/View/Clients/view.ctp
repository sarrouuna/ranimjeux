<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    }
    $(document).ready(function() {

    $(".iframe").colorbox({iframe:true, width:"60%", height:"60%", href: function(){
    return  wr+"Bonlivraisons/choix/"+$(this).attr('id');
    }})
    });
</script>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot; ?>Clients/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>

</div>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Consultation Client'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Client', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form', 'id' => 'defaultForm', 'data-bv-message' => 'This value is not valid', 'data-bv-feedbackicons-valid' => 'fa fa-check', 'data-bv-feedbackicons-invalid' => 'fa fa-bug', 'data-bv-feedbackicons-validating' => 'fa fa-refresh')); ?>

                <div class="col-md-6">     
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Point de vente'); ?></label>	
                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($pointdeventes[$client['Client']['pointdevente_id']]); ?>'>

                        </div>
                    </div>
                    
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Code'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['code']); ?>'>

                        </div>



                    </div>			 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Raison social'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['name']); ?>'>

                        </div>



                    </div>			 		 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Tel'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['tel']); ?>'>

                        </div>



                    </div>	<div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Fax'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['fax']); ?>'>

                        </div>



                    </div>	
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Zone'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $client['Zone']['name']; ?>'>
                        </div>



                    </div>	
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Adresse'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['adresse']); ?>'>

                        </div> </div>
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Activite'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['activite']); ?>'>

                        </div></div>



                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Autorisation'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['autorisation']); ?>'>

                        </div></div>  
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Remise'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['remise']); ?>'>

                        </div></div>  

                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Banque'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['banque']); ?>'>

                        </div>
                    </div>                    
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Etat'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($etats[$client['Client']['etat']]); ?>'>

                        </div>
                    </div>      
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Rib'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['rib']); ?>'>

                        </div>
                    </div> 

                </div>
                <div class="col-md-6">   



                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Photo Rib'); ?></label>	


                        <div class='col-sm-10'>
                            <?php if (!empty($client['Client']['photorib'])) { ?>             
                                <a onClick="flvFPW1(wr + 'files/upload/<?php echo $client['Client']['photorib']; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i>Imprimer</button></a>     
                            <?php } ?>
                        </div>
                    </div>

                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Type Vente'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['vente']); ?>'>

                        </div>
                    </div>  

                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Max echeance Cheque en jrs'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['chequejrs']); ?>'>

                        </div></div>  
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Max echeance Traite en jrs'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['traitejrs']); ?>'>

                        </div></div>  


                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Site Web'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['siteweb']); ?>'>

                        </div></div>

                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Code Postal'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['codepostal']); ?>'>

                        </div></div>

                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Mail'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['mail']); ?>'>

                        </div>



                    </div>			 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Familleclient'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $client['Familleclient']['name']; ?>'>
                        </div>



                    </div>			 <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Sousfamilleclient'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $client['Sousfamilleclient']['name']; ?>'>
                        </div>



                    </div>		

                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Matricule fiscale'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $client['Client']['matriculefiscale']; ?>'>
                        </div>



                    </div>	
                    <div class='form-group'>	
                        <label class='col-md-2 control-label'><?php echo __('Registre de  commerce'); ?></label>	


                        <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h($client['Client']['registrecommerce']); ?>'>

                        </div>
                    </div>	

                    <div class='form-group'>	                
                        <label class='col-md-2 control-label'><?php echo __('Registre de  commerce'); ?></label>       
                        <div class='col-sm-10'><?php // echo $this->Html->link($client['Client']['registrecommercef'], array('controller' => 'clients', 'action' => 'afficher', $client['Client']['id'],$client['Client']['registrecommercef']));      ?>
                            <?php if (!empty($client['Client']['registrecommercef'])) { ?>    
                                <a onClick="flvFPW1(wr + 'files/upload/<?php echo $client['Client']['registrecommercef']; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i>Imprimer</button></a>     
                            <?php } ?>
                        </div>
                    </div>	

                    <div class='form-group'> <label class='col-md-2 control-label'><?php echo __('Patente'); ?></label>
                        <div class='col-sm-10'>
                            <?php if (!empty($client['Client']['patente'])) { ?> 
                                <a onClick="flvFPW1(wr + 'files/upload/<?php echo $client['Client']['patente']; ?>', 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i>Imprimer</button></a>     
                            <?php } ?>
                        </div>
                    </div>	


                </div>


                <!-- Autre contact-->
                <div class="row ligne" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Contacts'); ?></h3>

                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:90%" align="center" >
                                    <thead>
                                        <tr>
                                            <td align="center" nowrap="nowrap">Nom prénom</td>
                                            <td align="center" nowrap="nowrap">Fonction</td>
                                            <td align="center" nowrap="nowrap">Tel</td>
                                            <td align="center" nowrap="nowrap">Mail</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        foreach ($contacts as $i => $contact) {
                                            ?>  
                                            <tr>
                                                <td style="width:25%">
                                                    <?php echo $this->Form->input('id', array('value' => $contact['Contact']['id'], 'name' => 'data[Contact][' . $i . '][id]', 'id' => 'id' . $i, 'champ' => 'id', 'table' => 'Contact', 'index' => $i, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'label' => 'Nom')); ?>
                                                    <?php echo $this->Form->input('sup', array('name' => 'data[Contact][' . $i . '][sup]', 'id' => 'sup0', 'champ' => 'sup', 'table' => 'Contact', 'index' => '0', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control', 'required data-bv-notempty-message' => 'Champ Obligatoire', 'label' => 'Nom')); ?>
                                                    <?php echo $this->Form->input('name', array('value' => $contact['Contact']['name'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Contact][' . $i . '][name]', 'table' => 'Contact', 'index' => $i, 'id' => 'name' . $i, 'champ' => 'name', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                </td>
                                                <td style="width:25%">
                                                    <?php echo $this->Form->input('fonction', array('value' => $contact['Contact']['fonction'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Contact][' . $i . '][fonction]', 'table' => 'Contact', 'index' => $i, 'id' => 'fonction' . $i, 'champ' => 'fonction', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                </td>
                                                <td style="width:25%">
                                                    <?php echo $this->Form->input('tel', array('value' => $contact['Contact']['tel'], 'name' => 'data[Contact][' . $i . '][tel]', 'id' => 'tel' . $i, 'table' => 'Contact', 'index' => $i, 'champ' => 'tel', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                </td>
                                                <td style="width:25%">
                                                    <?php echo $this->Form->input('mail', array('value' => $contact['Contact']['mail'], 'label' => '', 'div' => 'form-group', 'name' => 'data[Contact][' . $i . '][mail]', 'table' => 'Contact', 'index' => $i, 'id' => 'mail' . $i, 'champ' => 'mail', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                </td>
                                            </tr>
                                        <?php } ?> 
                                    </tbody>
                                </table>
                                <input type="hidden" value=<?php echo @$i; ?>  id="index" />
                            </div>
                        </div>
                    </div>                
                </div>                


                
                <div class="row ligne" >

                    <div class="col-md-12" >
                        <div class="panel panel-default" >
                            <div class="panel-heading">
                                <h3 class="panel-title"><?php echo __('Exonoration TVA'); ?></h3>
                              
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtabletva" style="width:90%" align="center" >
                                    <thead>
                                        <tr>
                                            <td align="center" nowrap="nowrap">Numero</td>
                                            <td align="center" nowrap="nowrap">Date debut</td>
                                            <td align="center" nowrap="nowrap">Date fin</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php
                                        foreach ($exos as $k => $x) {
                                            ?> 
                                        <tr>
                                            <td style="width:45%">
                                                <?php echo $this->Form->input('id', array('value' => $x['Exonorationclient']['id'], 'name' => 'data[Exonorationclient][' . $k . '][id]', 'id' => 'id' . $k, 'champ' => 'id', 'table' => 'Exonorationclient', 'index' => $k, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                <?php echo $this->Form->input('sup', array('name' => 'data[Exonorationtva][' . $k . '][sup]', 'id' => 'sup'. $k, 'champ' => 'sup', 'table' => 'Exonorationtva', 'index' => $k, 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'type' => 'hidden', 'after' => '</div>', 'class' => 'form-control')); ?>
                                                <?php echo $this->Form->input('numero', array('value' => $x['Exonorationclient']['num_exe'],'label' => '', 'div' => 'form-group', 'name' => 'data[Exonorationtva][' . $k . '][numero]', 'table' => 'Exonorationtva', 'index' => $k, 'id' => 'numero'. $k, 'champ' => 'numero', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control')); ?>
                                            </td>
                                            <td style="width:25%" align="center">
                                                <?php echo $this->Form->input('datedebut', array('value' => date("d/m/Y", strtotime(str_replace('-', '/',$x['Exonorationclient']['datedu']))),'label' => '', 'div' => 'form-group', 'name' => 'data[Exonorationtva][' . $k . '][datedebut]', 'table' => 'Exonorationtva', 'index' => $k, 'id' => 'datedebut'. $k, 'champ' => 'datedebut', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control datePickerOnly','type'=>'text')); ?>
                                            </td>
                                            <td style="width:25%" align="center">
                                                <?php echo $this->Form->input('datefin', array('value' => date("d/m/Y", strtotime(str_replace('-', '/',$x['Exonorationclient']['dateau']))),'name' => 'data[Exonorationtva][' . $k . '][datefin]', 'id' => 'datefin'. $k, 'table' => 'Exonorationtva', 'index' => $k, 'champ' => 'datefin', 'label' => '', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control datePickerOnly','type'=>'text')); ?>
                                            </td>
                                            
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <input type="hidden" value="<?php echo @$k; ?>" id="index" />
                            </div>
                        </div>
                    </div>                
                </div> 
                <?php echo $this->Form->end(); ?>

            </div></div></div></div>




