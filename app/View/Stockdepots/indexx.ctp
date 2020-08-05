<script language="JavaScript" type="text/JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}

</script>
 <?php $add="";$edit="";$delete="";$imprimer="";$addindirect=""; 
$lien=  CakeSession::read('lien_stock');
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='stockdepot'){
		$add=$liens['add'];
		$edit=$liens['edit'];
		$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}
if(@$liens['lien']=='factureclients'){
		$addindirect=$liens['add'];	
	}
  
} 
if($add==1){?>

<?php } ?>
<br>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche'); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Stockdepot',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
                    <?php 
                    echo $this->Form->input('famille_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Famille','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                    echo $this->Form->input('article_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Article','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                    echo $this->Form->input('typeqte_id',array('multiple'=>'multiple','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Type Quantité','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                    ?>
                </div>
               <div class="col-md-6">
                <?php
                echo $this->Form->input('fournisseur_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Fournisseur','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('depot_id',array('multiple'=>'multiple','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Depot','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                 <a class="btn btn-primary" href="<?php echo $this->webroot;?>Stockdepots/index"/>Afficher Tout </a>
                    <?php //if($imprimer==1){ ?>
      <a  onClick="flvFPW1(wr+'Stockdepots/imprimer?article_id=<?php echo @$articleid;?>&depot_id=<?php echo @$depotid;?>&type=<?php echo @$type;?>&familleid=<?php echo @$familleid;?>&fournisseurid=<?php echo @$fournisseurid;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                    <?php // }?>
      <a  onClick="flvFPW1(wr+'Stockdepots/exp_etatexcel?article_id=<?php echo @$articleid;?>&depot_id=<?php echo @$depotid;?>&type=<?php echo @$type;?>&familleid=<?php echo @$familleid;?>&fournisseurid=<?php echo @$fournisseurid;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer Excel</button> </a>
                   

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
                                    <h3 class="panel-title"><?php echo __('Stockdepots'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	         
		<td style="display: none;" ><?php echo $this->Paginator->sort('Id'); ?></td>
	         
                <td align="center"><?php echo $this->Paginator->sort('Article'); ?></td>
		<?php  foreach($depotchoix as $j=>$depot){ ?>
                <th  nowrap="nowrap"><center><?php echo $depot['Depot']['designation']; ?></center></th>
                <?php } ?>
                <td align="center"><?php echo $this->Paginator->sort('Prix'); ?></td>
                <td align="center"><?php echo $this->Paginator->sort('Prix Tot'); ?></td>
        </tr></thead><tbody>
	<?php //debug($stockdepots);die;
        $total=0;
        foreach ($stockdepots as $stockdepot): 
            
        $total=$total+($stockdepot[0]['prix']*$stockdepot[0]['qte']);    
            ?>
	<tr>
		<td style="display:none"><?php echo h($stockdepot['Article']['id']); ?></td>
		<td >
			<?php echo $this->Html->link($stockdepot['Article']['code']." ".$stockdepot['Article']['name'], array('controller' => 'articles', 'action' => 'view', $stockdepot['Article']['id'])); ?>
		</td>
		<td align="center"><?php 
                $test=strpos($stockdepot[0]['qte'], ".");
                if($test==true){
                echo sprintf('%.3f',$stockdepot[0]['qte']);
                }else{
                echo $stockdepot[0]['qte'];    
                }
                ?></td>
                <td align="center">
                </td>
                <td align="center"><?php echo number_format($stockdepot[0]['prix'],3,'.',' '); ?></td>
                <td align="center"><?php echo number_format($stockdepot[0]['prix']*$stockdepot[0]['qte'],3,'.',' '); ?></td>
		
	</tr>
<?php endforeach; ?>
                          </tbody>
                          <tfoot>
                          <td colspan="4"><strong>Total</strong></td> 
                          <td><?php echo number_format($total,3,'.',' ');  ?></td>
                          </tfoot>
	</table>
	
                                </div></div></div></div></div>	


