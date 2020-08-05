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
	if(@$liens['lien']=='carnetcheques'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
       
} 
if($add==1){?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Carnetcheques/add"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<?php } ?>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Souche chequier'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<th><?php echo $this->Paginator->sort('Numero'); ?></th>
                
	        <th><?php echo $this->Paginator->sort('Banque'); ?></th> 

	        <th><?php echo $this->Paginator->sort('Rib'); ?></th> 
                
		<th><?php echo $this->Paginator->sort('Debut'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Nombre'); ?></th>
	         
		<th><?php echo $this->Paginator->sort('Taille'); ?></th>
			<th class="actions" align="center"></th>
                        <th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php     foreach ($carnetcheques as $i=>$carnetcheque): ?>
	<tr>
		<td style="display:none"><?php echo h($carnetcheque['Carnetcheque']['id']); ?>&nbsp;</td>
		<td ><?php echo h($carnetcheque['Carnetcheque']['numero']); ?>&nbsp;</td>
		<td ><?php echo h($carnetcheque['Compte']['banque']); ?>&nbsp;</td>
		<td ><?php echo h($carnetcheque['Compte']['rib']); ?>&nbsp;</td>
		<td ><?php echo h($carnetcheque['Carnetcheque']['debut']); ?>&nbsp;</td>
		<td ><?php echo h($carnetcheque['Carnetcheque']['nombre']); ?>&nbsp;</td>
		<td ><?php echo h($carnetcheque['Carnetcheque']['taille']); ?>&nbsp;</td>
                <td align="center">
                    <input  type="checkbox" index="<?php echo $carnetcheque['Carnetcheque']['id']; ?>" class="js-switch-brown fermercarnetcheque" <?php //if ($devi['Devi']['eliminermontant']==0){ ?>checked <?php //}?>/>
                </td>
		<td align="center">
			<?php echo $this->Html->link("<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>", array('action' => 'view', $carnetcheque['Carnetcheque']['id']),array('escape' => false)); ?>
			<?php if($edit==1){ echo $this->Html->link("<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>", array('action' => 'edit', $carnetcheque['Carnetcheque']['id']),array('escape' => false)); } ?>
			<?php if($delete==1){ echo $this->Form->postLink("<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>", array('action' => 'delete', $carnetcheque['Carnetcheque']['id']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', $carnetcheque['Carnetcheque']['id']));} ?>
		<?php  if($imprimer==1) { ?>
                  <a onClick="flvFPW1(wr+'Carnetcheques/imprimer/'+<?php  echo $carnetcheque['Carnetcheque']['id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                <?php  } ?>
                </td>
	</tr>
<?php endforeach; ?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


