<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Recherche',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
              	<?php 
		echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>'Date de') ); 
		echo $this->Form->input('fournisseur_id',array('empty'=>'veuillez choisir !!','div'=>'form-group','label'=>'Fournisseur','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));?>
            </div>
            <div class="col-md-6">
            <?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
                echo $this->Form->input('exercice_id',array('value'=>$exerciceid,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
            ?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                <a class="btn btn-primary" href="<?php echo $this->webroot;?>etatworkflows/index"/>Afficher Tout </a>
<!--                <a  onClick="flvFPW1(wr+'Commandes/imprimerrecherche?fournisseurid=<?php echo @$fournisseurid;?>&date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>&validiteid=<?php echo @$validiteid;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>-->
                   

                    </div>
                </div>
            </div>
<?php echo $this->Form->end();?>
        </div>
    </div>
</div>
<br><input type="hidden" id="page" value="1"/>
   <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne d\'Ordre de travail'); ?></h3>
                                   
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Action</td>
                                    <td align="center" nowrap="nowrap">Personnel</td>
                                    <td align="center" nowrap="nowrap"> Obligation </td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($ligneworkflows as $i=>$l){ ?> 
                                <tr class="cc" >
                                    <td style="width:49%" align="center">
                                        <?php echo $l['Typeworkflow']['name']; ?>
                                    </td>
                                    <td style="width:49%" align="center">
                                        <?php echo $l['Personnel']['name']; ?>
                                    </td>
                                    <td align="center" style="width:1%" >
                                    <input disabled="disabled" type="checkbox" index="<?php echo $i;?>" <?php if($l['Ligneworkflow']['obligatoire']==1){ ?> checked="checked" <?php } ?>  class="obligation">
                                    </td>
                                </tr>
                                <?php } ?>
                                </tbody>
                                </table>
</div>
                            </div>
                        </div>                
</div> 
<br>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Etat d\'ordres de travail'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table" id="">
                      <thead>
	<tr>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
                <th><center><?php echo $this->Paginator->sort('Fournisseur_id'); ?></center></th>
	        <th><center><?php echo $this->Paginator->sort('Importation_id'); ?></center></th> 
		<th style="display:none"><center><?php echo $this->Paginator->sort('Utilisateur_id'); ?></center></th>
	         
		<th><center><?php echo $this->Paginator->sort('Numero'); ?></center></th>
	         
		<th><center><?php echo $this->Paginator->sort('Coefficient'); ?></center></th>
		<th><center><?php echo $this->Paginator->sort('Date'); ?></center></th>
	         
		<th><center><?php echo $this->Paginator->sort('Remise'); ?></center></th>
	         
		<th><center><?php echo $this->Paginator->sort('Tva'); ?></center></th>
	         
		<th><center><?php echo $this->Paginator->sort('Fodec'); ?></center></th>
	         
		<th><center><?php echo $this->Paginator->sort('Totalht'); ?></center></th>
	         
		<th><center><?php echo $this->Paginator->sort('Totalttc'); ?></center></th>
	        <th class="actions" align="center"></th> 
        </tr>
                      </thead><tbody>
	<?php //debug($ligneworkflowvalider);
        
        $style="";
        foreach ($deviprospects as $i=>$deviprospect){ 
        //debug($ligneworkflowcreation);    
        foreach ($ligneworkflowcreation as $creation){
           $testcreation=0; 
           if($creation['Ligneworkflow']['personnel_id'] != $deviprospect['Utilisateur']['personnel_id']){
               $testcreation=1;
           } 
        }
        //debug($testcreation);
        if( $testcreation==1) { 
            $style="background-color: #F1948A !important;" ;
            $img1='<img class="rounded" src="'.$this->webroot.'assets/images/refuse.jpg" width="30px" height="30px" />';
            }else { 
            $style="background-color: #76D7C4 !important;" ;
            $img1='<img class="rounded"  src="'.$this->webroot.'assets/images/Tick1.png" width="20px" height="20px" />';
            }
        //debug($style);
            
          
            
            
        $obj = ClassRegistry::init('Utilisateur');
        $utilisateur = $obj->find('first',array('conditions'=>array('Utilisateur.id'=>$deviprospect['Utilisateur']['id']),'recursive'=>2));    
        ?>
        <tr style="<?php echo $style ; ?>" id="tr<?php echo $i ; ?>">
		<td style="display:none"><?php echo h($deviprospect['Deviprospect']['id']); ?></td>
		<td >
			<?php echo $deviprospect['Fournisseur']['name'] ;?>
		</td>
                <td >
			<?php echo  $deviprospect['Importation']['name'] ;?>
		</td>
		<td style="display:none">
			<?php echo $deviprospect['Utilisateur']['name']?>
		</td>
		<td align="center"><?php echo h($deviprospect['Deviprospect']['numero']); ?></td>
		<td align="center"><?php echo sprintf('%.3f',h($deviprospect['Deviprospect']['coefficient'])); ?></td>
		<td align="center"><?php echo date("d-m-Y",strtotime(str_replace('/','-',h($deviprospect['Deviprospect']['date'])))); ?></td>
		<td align="right"><?php echo h($deviprospect['Deviprospect']['remise']); ?></td>
		<td align="right"><?php echo h($deviprospect['Deviprospect']['tva']); ?></td>
		<td align="right"><?php echo h($deviprospect['Deviprospect']['fodec']); ?></td>
		<td align="right"><?php echo h($deviprospect['Deviprospect']['totalht']); ?></td>
		<td align="right"><?php echo h($deviprospect['Deviprospect']['totalttc']); ?></td>
                <td style="background-color: white !important;" >
                <center>
                    <input type="hidden" id="ligne<?php echo $i ; ?>" value="0"/>
                    <button onclick="affichetr(<?php echo $i ; ?>)" class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>
                </center>
                </td>
                
		
	</tr>
        <tr style="display:none;" id="trr<?php echo $i ; ?>">
                <td>Crée par :</td>
                <td  align="center" colspan="3"></td>
                <td align="lfet" colspan="7"><?php echo $utilisateur['Personnel']['name']." ".@$img1 ;?></td>
	</tr>
        <tr  id="trrr<?php echo $i ; ?>" style="display:none;">
        <td>Validée par :</td>
        <td  align="center" colspan="3"></td>
        <td  align="lfet" colspan="7">
        <?php 
        foreach ($ligneworkflowvalider as $k=>$ligne){
        $valider="";    
        if($ligne['Ligneworkflow']['obligatoire'] == 1){
            $ob="obligatoire";
           }else{
             $ob="";  
           }
        $lignevalides=ClassRegistry::init('Lignevalide')->find('all',array('conditions'=>array('Lignevalide.ligneworkflow_id'=>$ligne['Ligneworkflow']['id'],'Lignevalide.id_piece'=>$deviprospect['Deviprospect']['id'],'Lignevalide.document_id'=>1),'recursive'=>2));
        if(!empty($lignevalides)){
        foreach ($lignevalides as $valide){
           $testcreation=0; 
           if($ligne['Ligneworkflow']['id'] == $valide['Lignevalide']['ligneworkflow_id']){
               $img='<img class="rounded"  src="'.$this->webroot.'assets/images/Tick1.png" width="20px" height="20px" />';
               $valider=" le ".date("d/m/Y",strtotime(str_replace('/','-',$valide['Lignevalide']['date'])))." à ".$valide['Lignevalide']['heure'] ;
           }else{
               $img='<img class="rounded" src="'.$this->webroot.'assets/images/refuse.jpg" width="30px" height="30px" />';
               $valider=" ";
           }
        }}else{
               $img='<img class="rounded"  src="'.$this->webroot.'assets/images/refuse.jpg" width="30px" height="30px" />';
        }
        echo $ligne['Personnel']['name']." ".@$img." ".$valider." ".$ob."</br>";
        }
        ?>
        </td>            
	</tr>
        <tr style="display:none;" id="trrrr<?php echo $i ; ?>">
                <td>transformée par :</td>
                <td  align="center" colspan="3"></td>
        <td align="lfet" colspan="7">
        <?php
        $lignecommandes=ClassRegistry::init('Commande')->find('first',array('conditions'=>array('Commande.deviprospect_id'=>$deviprospect['Deviprospect']['id']),'recursive'=>0));
        //debug($lignecommandes);
        if(!empty($lignecommandes)){
        $obj = ClassRegistry::init('Utilisateur');
        $utilisateurt = $obj->find('first',array('conditions'=>array('Utilisateur.id'=>$lignecommandes['Commande']['utilisateur_id']),'recursive'=>2));    
        foreach ($ligneworkflowtransformation as $transformation){
           $testtransformation=0; 
           if($creation['Ligneworkflow']['personnel_id'] != $utilisateurt['Utilisateur']['personnel_id']){
               $testtransformation=1;
           } 
        }
        if( $testtransformation==1) { 
            $img2='<img class="rounded" src="'.$this->webroot.'assets/images/refuse.jpg" width="30px" height="30px" />';
            }else { 
            $img2='<img class="rounded"  src="'.$this->webroot.'assets/images/Tick1.png" width="20px" height="20px" />';
            }
        ?>
        <?php echo $utilisateurt['Personnel']['name']." ".@$img2 ;
        }else{
            echo "Cette Suggestion de Commande n'est pas transformée " ;
        }
        ?>
        </td>
	</tr>
        <?php } ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


