<script language="JavaScript">
function flvFPW1(){
var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
}
</script>
 
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
		                echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly ','type'=>'text','label'=>'Date') );
                        //echo $this->Form->input('article_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Article','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                    ?>
                    <div class="col-dm-6" style="display:inline; position: relative;">
                        <?php
                        echo $this->Form->input('article_id', array('div' => 'form-group', 'index' => '0', 'id' => 'article_id0', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                        echo $this->Form->input('designation', array('div' => 'form-group','placeholder'=>'Designation','label'=>'Article', 'index' => '0', 'id' => 'designation0', 'champ' => 'designation', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control amineselect', 'type' => 'text')); ?>
                        <div class="form-group" style="display:inline; position: relative;bottom: 24px !important;left: 11px;">
                            <label></label>
                            <div id="res0" champ="res" index="0"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>

                        </div>
                    </div>


                </div>
               <div class="col-md-6">
                <?php
                echo $this->Form->input('depot_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Depot','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary" id="aff">Chercher</button>  
                 <a class="btn btn-primary" href="<?php echo $this->webroot;?>Stockdepots/index"/>Afficher Tout </a>
                    <?php //if($imprimer==1){ ?>
      <a  onClick="flvFPW1(wr+'etatstockmins/imprimer?article_id=<?php echo @$articleid;?>&depot_id=<?php echo @$depotid;?>&date2=<?php echo @$date2;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                    <?php // }?>
                   

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
                                    <h3 class="panel-title"><?php echo __('Stock depots Min'); ?></h3>
                                    <div id="divcommande" style="display:none;">
                                    <div class="col-md-12">
                                        <a class="btn btn btn-danger commander" 
                                           style="
                                           float: right; 
                                           position: relative;
                                           top: -25px;
                                           "   
                                        >
                                        <i class="fa fa-plus-circle ">
                                        </i> Commander </a>          
                                    </div>
                                    <div class="form-group" style="
                                           float: right; 
                                           position: relative;
                                           top: -65px;
                                           margin-right: 150px;
                                           "   
                                           > 
                                        Interne <input id="interne" type="radio" name="frs" value="0" checked="checked"><br> 
                                        Externe <input id="externe" type="radio" name="frs" value="1"> 
                                    </div>
                                     <div class="form-group" style="
                                           float: right; 
                                           position: relative;
                                           top: -65px;
                                           margin-right: 10px;
                                           "   
                                           >
                                        Fournisseur :
                                    </div>
                                    </div>    
                                </div>
                                <div class="panel-body">
                                  
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="">
                      <thead>
        <tr>
        <td align="right" colspan="5">
        <a  index="check" ligne="<?php echo $i; ?>" ind="<?php echo $i; ?>" class="cocherarticle testcocher">Tout Cocher</a>/
        <a  index="check" ligne="<?php echo $i; ?>" ind="<?php echo $i; ?>" class="decocherarticle">Tout Decocher</a>
        </td>
        </tr>
	<tr>
	         
		<td style="display: none;" ><?php echo ('Id'); ?></td>
	         
                <td align="center"><?php echo ('Article'); ?></td>
                <td align="center"><?php echo ('Quantite Min'); ?></td>
		<td align="center"><?php echo ('Quantite Réel'); ?></td>
	        <td align="center"><?php echo ('Quantite Théorique'); ?></td>
                <td align="center"></td>
        </tr></thead><tbody>
	<?php //debug($stockdepots);die;
        foreach ($stockdepots as $i=>$stockdepot): 
        $lignecommandes=ClassRegistry::init('Lignecommande')->find('all', array('fields'=>array('sum(Lignecommande.quantite) as qte'),'conditions' => array('Lignecommande.id > ' => 0,'Lignecommande.article_id' =>$stockdepot['Article']['id'],@$cond1f, @$cond3f, @$cond4f )
                ,'group'=>array('Lignecommande.article_id')));
                //debug($lignecommandes);
                $commandeclts =ClassRegistry::init('Lignecommandeclient')->find('all', array('fields'=>array('sum(Lignecommandeclient.quantite) as qte'),'conditions' => array('Lignecommandeclient.id > ' => 0,'Lignecommandeclient.article_id' =>$stockdepot['Article']['id'],@$cond1c, @$cond3c, @$cond4c )
                ,'group'=>array('Lignecommandeclient.article_id')));
                //debug($commandeclts);
                if(!empty($lignecommandes)){
                $qtecom_entre=$lignecommandes[0][0]['qte'];
                }else{
                $qtecom_entre=0;
                }
                if(!empty($commandeclts)){
                $qtecom_sortie=$commandeclts[0][0]['qte'];
                }else{
                $qtecom_sortie=0;
                }
                $qte_theorique=$stockdepot[0]['qte']-$qtecom_sortie+$qtecom_entre;    
            if($stockdepot['Article']['stockmin']>=$qte_theorique){
            ?>
	<tr>
		<td style="display:none"><?php echo h($stockdepot['Article']['id']); ?></td>
		<td >
			<?php echo $this->Html->link($stockdepot['Article']['name'], array('controller' => 'articles', 'action' => 'view', $stockdepot['Article']['id'])); ?>
		</td>
                <td align="center"><?php echo h($stockdepot['Article']['stockmin']); ?></td>
		<td align="center"><?php echo h($stockdepot[0]['qte']); ?></td>
                <td align="center">
                <?php echo $qte_theorique; ?> 
                </td>
                <td align="center">
                   <input type="checkbox" id="check<?php echo $i; ?>" value="<?php echo $stockdepot['Article']['id'];?>" name="checkbox[]" ligne="<?php echo $i; ?>" class="testcocher"/>
                </td>
	</tr>
            <?php } ?>
<?php endforeach; ?>
        <tfoot>
        <tr>
        <td align="right" colspan="5">
        <a  index="check" ligne="<?php echo $i; ?>" ind="<?php echo $i; ?>" class="cocherarticle testcocher">Tout Cocher</a>/
        <a  index="check" ligne="<?php echo $i; ?>" ind="<?php echo $i; ?>" class="decocherarticle">Tout Decocher</a>
        </td>
        </tr>
        </tfoot>
                          </tbody>
	</table>
        <input type="hidden" id="ligne" value="<?php echo $i; ?>">
                                </div></div></div></div></div>	


