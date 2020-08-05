<script language="JavaScript" type="text/JavaScript">

    function flvFPW1(){

    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    }

</script> 


<?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_vente');
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='clients'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
} 
if($add==1){?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Clients/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br>
<?php }?>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Client', array('autocomplete' => 'off', 'class' => 'form-horizontal ls_form')); ?>

                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('societe', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Societ&egrave;', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('client_id', array('label' => 'Client', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'id' => 'article_id', 'after' => '</div>', 'class' => 'form-control select ', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('zone_id', array('label' => 'Zone', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'id' => 'article_id', 'after' => '</div>', 'class' => 'form-control select ', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('typeclient_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Type', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                    echo $this->Form->input('familleclient_id', array('label' => 'Famille', 'div' => 'form-group', 'between' => '<div class="col-sm-10">', 'id' => 'typeetatarticle_id', 'after' => '</div>', 'class' => 'form-control select ', 'empty' => 'Veuillez Choisir !!'));
                    echo $this->Form->input('etat', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Etat', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    echo $this->Form->input('modeclient_id', array('empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Autorisation', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));
                    ?>
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                        <?php if ($imprimer == 1) { ?>
                            <a  onClick="flvFPW1(wr+'Clients/exp_etatexcel?societe=<?php echo @$societe; ?>&client_id=<?php echo @$client_id; ?>&zone_id=<?php echo @$zone_id; ?>&typeclient_id=<?php echo @$typeclient_id; ?>&familleclient_id=<?php echo @$familleclient_id; ?>&etat=<?php echo @$etat; ?>&modeclient_id=<?php echo @$modeclient_id; ?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" >
                            <button class="btn btn-primary">Imprimer Excel</button> </a>
                        <?php } ?>


                    </div>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Clients'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th style="display:none"><?php echo ('Id'); ?></th>
	         
                <th ><center><?php echo ('Code'); ?></center></th>
	         
		<th ><center><?php echo ('Raison sociale'); ?></center></th>
	         
<!--		<th><center><?php echo ('Adresse'); ?></center></th>-->
	         
		<th><center><?php echo ('Tel'); ?></center></th>
	         
		<th><center><?php echo ('Fax'); ?></center></th>
	         
		<th><center><?php echo ('Mail'); ?></center></th>
	         
		<th><center><?php echo ('Familleclient_id'); ?></center></th>
	         
<!--		<th><center><?php echo ('Sousfamilleclient_id'); ?></center></th>-->
	         
		<th><center><?php echo ('Zone_id'); ?></center></th>
			<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php 
        if(!empty($listeclients)){
        foreach ($listeclients as $client): 
 //$nbtotale=0;          
 $obj1 = ClassRegistry::init('Devi'); 
 $nb1 = $obj1->find('count',array('conditions'=>array('Devi.client_id'=>$client['Client']['id'])));
$obj2 = ClassRegistry::init('Commandeclient'); 
 $nb2 = $obj2->find('count',array('conditions'=>array('Commandeclient.client_id'=>$client['Client']['id'])));
$obj3 = ClassRegistry::init('Bonlivraison'); 
 $nb3 = $obj3->find('count',array('conditions'=>array('Bonlivraison.client_id'=>$client['Client']['id'])));
$obj4 = ClassRegistry::init('Factureclient'); 
 $nb4 = $obj4->find('count',array('conditions'=>array('Factureclient.client_id'=>$client['Client']['id'])));
$obj5 = ClassRegistry::init('Factureavoir'); 
 $nb5 = $obj5->find('count',array('conditions'=>array('Factureavoir.client_id'=>$client['Client']['id'])));
$obj6 = ClassRegistry::init('Reglementclient'); 
 $nb6 = $obj6->find('count',array('conditions'=>array('Reglementclient.client_id'=>$client['Client']['id'])));
$nbtotale=$nb1+$nb2+$nb3+$nb4+$nb5+$nb6;
            
            
            ?>
	<tr>
		<td style="display:none"><?php echo h($client['Client']['id']); ?></td>
		<td ><?php echo h($client['Client']['code']); ?></td>
		<td ><?php echo h($client['Client']['name']); ?></td>
<!--		<td ><?php echo h($client['Client']['adresse']); ?></td>-->
		<td ><?php echo h($client['Client']['tel']); ?></td>
		<td ><?php echo h($client['Client']['fax']); ?></td>
		<td ><?php echo h($client['Client']['mail']); ?></td>
		<td >
			<?php echo $this->Html->link($client['Familleclient']['name'], array('controller' => 'familleclients', 'action' => 'view', $client['Familleclient']['id'])); ?>
		</td>
<!--		<td >
			<?php echo $this->Html->link($client['Sousfamilleclient']['name'], array('controller' => 'sousfamilleclients', 'action' => 'view', $client['Sousfamilleclient']['id'])); ?>
		</td>-->
		<td >
			<?php echo $this->Html->link($client['Zone']['name'], array('controller' => 'zones', 'action' => 'view', $client['Zone']['id'])); ?>
		</td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $client['Client']['id']),array('escape' => false)); ?>
			<?php if($edit==1){ echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $client['Client']['id']),array('escape' => false)); }?>
			<?php if(($delete==1)  && ($nbtotale==0)){ echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $client['Client']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $client['Client']['id']));} ?>
		</td>
	</tr>
        <?php endforeach; }?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


