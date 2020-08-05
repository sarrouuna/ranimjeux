<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Deviprospect',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
              	<?php 
		echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>'Date de') ); 
		echo $this->Form->input('fournisseur_id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','id'=>'fc','class'=>'form-control select  artfournisseur','empty'=>'Veuillez Choisir !!') );
                ?>
                </div>
                <div class="col-md-6">
                <?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
                ?>
                <div class='form-group' >	
                    <label class='col-md-2 control-label' id="labeldevise" ><?php echo __('Importation'); ?></label>	
                                  
			
                                  <div class='col-sm-10' champ="divimpor" id="divimpor" >     </div>
			
		
                                 
                </div>       
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                 <a class="btn btn-primary" href="<?php echo $this->webroot;?>variationtauxdechanges/index"/>Afficher Tout </a>
                <a  onClick="flvFPW1(wr+'Variationtauxdechanges/imprimerrecherche?fournisseurid=<?php echo @$fournisseurid;?>&date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>&importationid=<?php echo @$importationid;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                   
                   

                    </div>
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
                                    <h3 class="panel-title"><?php echo __('Variation taux de changes'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display:none"><?php echo $this->Paginator->sort('Id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Reglement_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Fournisseur_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Importation_id'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Date'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Type'); ?></th>
                
                <th><?php echo $this->Paginator->sort('Montant'); ?></th>
			
        </tr></thead><tbody>
	<?php
        $tot=0;
        foreach ($variationtauxdechanges as $variationtauxdechange): 
        if($variationtauxdechange['Variationtauxdechange']['type']=="Gain"){
        $tot=$tot+$variationtauxdechange['Variationtauxdechange']['montant']; 
        }else{
        $tot=$tot-$variationtauxdechange['Variationtauxdechange']['montant'];    
        }    
            
        ?>
	<tr>
		<td style="display:none"><?php echo h($variationtauxdechange['Variationtauxdechange']['id']); ?></td>
		<td >
			<?php echo $this->Html->link($variationtauxdechange['Reglement']['numeroconca'], array('controller' => 'reglements', 'action' => 'view', $variationtauxdechange['Reglement']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($variationtauxdechange['Fournisseur']['name'], array('controller' => 'fournisseurs', 'action' => 'view', $variationtauxdechange['Fournisseur']['id'])); ?>
		</td>
		<td >
			<?php echo $this->Html->link($variationtauxdechange['Importation']['name'], array('controller' => 'importations', 'action' => 'view', $variationtauxdechange['Importation']['id'])); ?>
		</td>
		<td ><?php echo date("d/m/Y",strtotime(str_replace('-','/',h($variationtauxdechange['Variationtauxdechange']['date'])))); ?></td>
		<td ><?php echo h($variationtauxdechange['Variationtauxdechange']['type']); ?></td>
		<td ><?php echo h($variationtauxdechange['Variationtauxdechange']['montant']); ?></td>
	</tr>
<?php endforeach; ?>
        <tfoot>
            <td align='center' colspan="5"><strong>Totale</strong></td>
            <td align='lfet'><strong><?php echo sprintf('%.3f',$tot); ?></strong></td>
        </tfoot>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


