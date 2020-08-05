  <div class="col-md-12" >
                            <div class="panel panel-default"> 
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
                                </div>
                                <div class="panel-body" >
        <?php echo $this->Form->create('Piecereglement',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php 
		
		echo $this->Form->input('Date_debut',array('label'=>'de','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
                ?>
                <div class="form-group">
                <label class='col-md-2 control-label'>Compte</label>
                <div class='col-sm-10'>
                    <select class="select" name="data[Piecereglement][compte_id]" id="compte_id">
                            <option value="">Veuillez choisir</option>
                            <?php foreach($comptes as $c){?>
                            <option value="<?php echo $c['Compte']['id'] ?>" <?php if(@$c['Compte']['id']==@$compte_id){?>selected="selected" <?php } ?>><?php echo $c['Compte']['banque'].' '.$c['Compte']['rib']; ?></option>
                           <?php  }
                            ?></select>
                </div></div>  
                </div>
            <div class="col-md-6"> 
                <?php 
                echo $this->Form->input('Date_fin',array('label'=>'Au','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
                ?>
            </div>   

                <div class="form-group">
                                        <div class="col-lg-9 col-lg-offset-3">
                                            <button type="submit" class="btn btn-primary testchoisicompte">Afficher</button> 
                                        </div>
                                        </div>
 
<?php echo $this->Form->end();?>





</div>
                            </div>
                        </div>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
<!--                                    <h3 class="panel-title"><?php echo __('Engagementcomptes'); ?></h3>-->
                                    <h3 class="panel-title" align='center'><?php echo @$compte['Compte']['banque']." ".@$compte['Compte']['rib']; ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
        <?php if(!empty($engagementcomptes)) { ?>         
        <table class="table table-bordered table-striped table-bottomless" id="">
                      <thead>
                          <tr>
                              <?php
                              if(empty($Date_debut)){
                              $Date_debut=$compte['Compte']['date'];
                              }
                              if($soldeint >0) {
                                  $nb=4;
                                  $typecompte="Débiteur";
                                  $nb2=2;
                              }else{
                                $nb=5;
                                $typecompte="Créditeur";
                                $nb2=0;
                              }
                              ?>
                              <td align="right" colspan="<?php echo  $nb ; ?>"><strong>solde <?php echo  $typecompte ; ?> au <?php echo date("d-m-Y",strtotime(str_replace('/','-',$Date_debut))); ?></strong></td>    
                              <td colspan="<?php echo  $nb2 ; ?>"><strong><?php echo   number_format($soldeint,3, '.', ' '); ?></strong></td>
                          </tr>
	<tr>
                <th class="actions" align="center" style="display:none"></th>
                <th class="actions" align="center">Date</th>
                <th class="actions" align="center">Action</th>
                <th class="actions" align="center">C/F</th>
                <th class="actions" align="center">Montant</th>
                <th class="actions" align="center">Débit</th>
                <th class="actions" align="center">Crédit</th>
        </tr>
                      </thead><tbody>
	<?php 
        $tot=$soldeint;
        foreach ($engagementcomptes as $engagementcompte): ?>
	<tr>
		<td style="display:none"><?php echo h($engagementcompte['Engagementcompte']['id']); ?></td>
		<td ><?php echo date("d-m-Y",strtotime(str_replace('/','-',$engagementcompte['Engagementcompte']['date']))); ?></td>
		<td ><?php echo $engagementcompte['Engagementcompte']['type']." ".$engagementcompte['Engagementcompte']['num']; ?></td>
		<td ><?php echo $engagementcompte['Engagementcompte']['observation']; ?></td>
                <td ><?php echo number_format($engagementcompte['Engagementcompte']['montant'],3, '.', ' '); ?></td>
		<td >
                    <?php
                if((($engagementcompte['Engagementcompte']['model']=="Piecereglementclient")||($engagementcompte['Engagementcompte']['model']=="Versement"))&&(($engagementcompte['Engagementcompte']['situation']=="Payé")||($engagementcompte['Engagementcompte']['situation']=="Impayé"))){
                    echo number_format($engagementcompte['Engagementcompte']['montant'],3, '.', ' ');
                    $tot=$tot+$engagementcompte['Engagementcompte']['montant'];
                }
                    ?>
                </td>
                
		<td >
                    <?php 
                if(($engagementcompte['Engagementcompte']['model']=="Bordereau")||(($engagementcompte['Engagementcompte']['model']=="Piecereglement")&&($engagementcompte['Engagementcompte']['situation']=="Payé"))||($engagementcompte['Engagementcompte']['situation']=="Impayéc")){
                    echo number_format($engagementcompte['Engagementcompte']['montant'],3, '.', ' ');
                    $tot=$tot-$engagementcompte['Engagementcompte']['montant'];
                }    
                    ?>
                </td>
		
	</tr>
        <?php endforeach; ?>
        
        <?php 
        
                              if(empty($Date_fin)){
                              $Date_fin=$engagementcompte['Engagementcompte']['date'];
                              }
                              if($tot >0) {
                                  $nb=4;
                                  $typecompte="Débiteur";
                                  $nb2=2;
                              }else{
                                $nb=5; 
                                $typecompte="Créditeur";
                                $nb2=0;
                              }
                              ?>
        <tr>
                              <td align="right" colspan="<?php echo $nb ;?>"><strong>solde <?php echo  $typecompte ; ?> au <?php echo date("d-m-Y",strtotime(str_replace('/','-',$Date_fin))); ?></strong></td>    
                              <td colspan="<?php echo  $nb2 ; ?>"><strong><?php echo number_format($tot,3, '.', ' ')  ; ?></strong></td>
                          </tr>

                          </tbody>
	</table>
        <?php  } ?>            
	
                                </div></div></div></div></div>	

