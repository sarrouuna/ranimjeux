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
<?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_finance');
//debug($lien_achat);die;
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='bordereaus'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
       
} 
if($add==1){?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Bordereaus/addr"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<?php }?>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Bordereau',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
                    <?php 
              	    echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>'Date de') ); 
                    echo $this->Form->input('compte_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Compte','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                    ?>
                </div>
               <div class="col-md-6">
                <?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'à") ); 
                ?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                 <a class="btn btn-primary" href="<?php echo $this->webroot;?>Bordereaus/tabledebord"/>Afficher Tout </a>
                    <?php if($imprimer==1){ ?>
      <a  onClick="flvFPW1(wr+'Bordereaus/imprimertableaudebord?compteid=<?php echo @$compteid;?>&date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                    <?php }?>
                   

                    </div>
                </div>
            </div>
<?php echo $this->Form->end();?>
        </div>
    </div>
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Bordereaus/ Retraits factoring '); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="">
                      <thead>
	<tr>
	         
	        <th style="display:none"><?php echo ('id'); ?></th> 
		<th style="display:none"><?php echo ('Utilisateur_id'); ?></th>
	         
		<th><?php echo ('Numero'); ?></th>

                <th><?php echo ('Date'); ?></th>
	         
		<th><?php echo ('Compte factoring '); ?></th>
		
		<th><?php echo ('Compte bancaire'); ?></th>
                
		<th><?php echo ('Montant Total'); ?></th>

		<th><?php echo ('Agio'); ?></th>

		<th><?php echo ('Operation'); ?></th>

		<th><?php echo ('Garantie'); ?></th>
	         	         
		<th><?php echo ('Montant '); ?></th>


        </tr></thead><tbody>
	<?php  
        $tot=0;
        foreach ($bordereaus as $bordereau): 
        
        if(($bordereau['Bordereau']['garantie']!="")||(($bordereau['Bordereau']['type']==2)&($bordereau['Bordereau']['factoring']!=""))){
        if ($bordereau['Bordereau']['garantie']){
        $tot=$tot+$bordereau['Bordereau']['garantie'];    
        }else{
        $tot=$tot-$bordereau['Bordereau']['montantverse'];     
        }    
            ?>
	<tr>
		<td style="display:none"><?php echo h($bordereau['Bordereau']['id']); ?></td>
		<td style="display:none">
			<?php echo $this->Html->link($bordereau['Utilisateur']['name'], array('controller' => 'utilisateurs', 'action' => 'view', $bordereau['Utilisateur']['id'])); ?>
		</td>
		<td ><?php echo h($bordereau['Bordereau']['numero']); ?></td>
		<td ><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',$bordereau['Bordereau']['date'])))); ?></td>
		<td ><?php echo h($comptes[@$bordereau['Bordereau']['factoring']]); ?></td>
		<td ><?php if (@$bordereau['Bordereau']['factoring']!=@$bordereau['Bordereau']['compte_id']){echo h($comptes[@$bordereau['Bordereau']['compte_id']]); }?></td>
		<td ><?php echo h($bordereau['Bordereau']['Montant']); ?></td>
		<td ><?php echo h($bordereau['Bordereau']['agio']); ?></td>
		<td ><?php if ($bordereau['Bordereau']['garantie']){echo h('Versement');}else {echo h('Retrait');} ?></td>
                <td ><?php echo h($bordereau['Bordereau']['garantie']); ?></td>
		<td ><?php echo h($bordereau['Bordereau']['montantverse']); ?></td>
		
	</tr>
<?php } endforeach; ?>
        <tr>
            <td colspan="8" align="center"><strong>Total</strong></td>
            <td><strong><?php echo sprintf('%.3f',$tot); ?></strong></td>
        </tr>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


