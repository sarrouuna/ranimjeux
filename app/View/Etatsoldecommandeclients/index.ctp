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
<input type="hidden" id="page" value="soldecommande"/>
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
		echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly ','type'=>'text','label'=>'Date de') ); 
		echo $this->Form->input('client_id', array('type'=>'hidden','id' => 'client_id', 'div' => 'form-group', 'between' => '<div class="col-sm-12">', 'after' => '</div>', 'class' => 'form-control'));
                echo $this->Form->input('clientname', array('label'=>'Client','yourid'=>'client_id','id' => 'clientname', 'div' => 'form-group', 'between' => '<div class="col-sm-10"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div>', 'class' => 'form-control autocomplete_name_clients'));
                //echo $this->Form->input('article_id',array('id'=>'article_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Article','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));

?>
<div class="col-dm-6" style="display:inline; position: relative;">
                        <?php
                        echo $this->Form->input('article_id', array('div' => 'form-group', 'index' => '0', 'id' => 'article_id0', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                        echo $this->Form->input('designation', array('div' => 'form-group', 'placeholder' => 'Designation', 'label' => 'Article', 'index' => '0', 'id' => 'designation0', 'champ' => 'designation', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control amineselect', 'type' => 'text'));
                        ?>
                        <div class="form-group" style="display:inline; position: relative;bottom: 24px !important;left: 11px;">
                            <label></label>
                            <div id="res0" champ="res" index="0"  class="haithamcss" onMouseMove="this.style.visibility = 'visible';" ></div>

                        </div>
                    </div>
</div>
<div class="col-md-6">
                <?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
                echo $this->Form->input('exercice_id',array('value'=>$exerciceid,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('regroupe_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Regroupement par','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary " id="aff">Chercher</button>  
<!--                 <a class="btn btn-primary" href="<?php //echo $this->webroot;?>/index"/>Afficher Tout </a>-->
                  
          <a  onClick="flvFPW1(wr+'Etatsoldecommandeclients/imprimerrecherche?clientid=<?php echo @$clientid;?>&date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>&articleid=<?php echo @$articleid;?>&exerciceid=<?php echo @$exerciceid;?>&regroupeid=<?php echo @$regroupeid;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>                   
                   

                    </div>
                </div>
            </div>
<?php echo $this->Form->end();?>
        </div>
    </div>
</div>
<br>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Etat solde commandes clients'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="" style="border:2px solid black;">
                      <thead>
                          <tr style="border:2px solid black;">
	         
                <th style="border:2px solid black; width:10%;" bgcolor="#F2D7D5"  ><strong><center>Délai Liv</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" colspan="2"><strong><center><?php if(($testclient==0)&&($testarticle==1)){  ?>Client <?php }else { ?>Article <?php } ?></center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Q.Com</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Q.Liv</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>Solde</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>M.TTC</center></strong></th>
                <th style="border:2px solid black;" bgcolor="#F2D7D5" ><strong><center>B.Com</center></strong></th>
                <th style="border:2px solid black; width:10%;" bgcolor="#F2D7D5" ><strong><center>Date</center></strong></th>
                  </tr><tr><td colspan="9" style="height: 10px;" ></td></tr> </thead><tbody>
<!--**************************************************************************************************************-->    
<?php if(!empty($name)){  ?>                     
<tr>
    <td style="background-color: #F2D7D5;" align="center"> Client </td>    <td colspan="8" bgcolor="#F2D7D5" ><strong><?php  echo @$name; ?></strong></td>
</tr>
<!--**************************************************************************************************************-->    
<?php } ?>


	<?php //debug($lignecommandes);
        $totqte=0;
        $totqteliv=0;
        $totsolde=0;
        $totttc=0;
        $clt_id=0;
        $art_id=0;
        $totqteg=0;
        $totqtelivg=0;
        $totsoldeg=0;
        $totttcg=0;
        foreach ($lignecommandes as $i=>$lignecommande): 
        if(empty($name)){ 
$obj = ClassRegistry::init('Client');
$test = $obj->find('first',array('conditions'=>array('Client.id'=>$lignecommande['Commandeclient']['client_id']),'recursive'=>-1));
        } ?>
        <?php 
        $totqteg=$totqteg+@$lignecommande['Lignecommandeclient']['quantite'];
        $totqtelivg=$totqtelivg+@$lignecommande['Lignecommandeclient']['quantiteliv'];
        $totsoldeg=$totsoldeg+(@$lignecommande['Lignecommandeclient']['quantite']-@$lignecommande['Lignecommandeclient']['quantiteliv']);
        $totttcg=$totttcg+(@$lignecommande['Lignecommandeclient']['puttc']*(@$lignecommande['Lignecommandeclient']['quantite']-@$lignecommande['Lignecommandeclient']['quantiteliv']));
        ?>
<!--**************************************************************************************************************-->
<?php if(empty($name)&&($testarticle==0)){  ?>
<?php if ($lignecommande['Commandeclient']['client_id']!=$clt_id){?>
<?php if($i!=0){ ?>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<tr>
    <td colspan="3" style="background-color: #F2D7D5;" align="center"><strong> Total Client </strong></td>    
    <td  align="right"><strong><?php  echo number_format(@$totqte,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totqteliv,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totsolde,3, '.', ' '); ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totttc,3, '.', ' '); ?></strong></td>
    <td  align="right" colspan="2" style="background-color: #F2D7D5;"><strong></strong></td>
</tr>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<?php   $totqte=0;
        $totqteliv=0;
        $totsolde=0;
        $totttc=0; 
        
}?>
<tr>
    <td style="background-color: #F2D7D5;" align="center"><strong> Client </strong></td>    <td colspan="8"  ><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php   echo @$test['Client']['code']."  ".@$test['Client']['name']; ?></strong></td>
</tr>
<?php }} 
$clt_id=$lignecommande['Commandeclient']['client_id'];
?>

<!--**************************************************************************************************************-->    

<?php if(empty($name)&&($testarticle==1)){  ?>
<?php if ($lignecommande['Article']['id']!=$art_id){ ?>
<?php if($i!=0){ 
         ?>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<tr>
    <td colspan="3" style="background-color: #F2D7D5;" align="center"><strong> Total Article </strong></td>    
    <td  align="right"><strong><?php  echo @$totqte; ?></strong></td>
    <td  align="right"><strong><?php  echo @$totqteliv; ?></strong></td>
    <td  align="right"><strong><?php  echo @$totsolde; ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totttc,3, '.', ' '); ?></strong></td>
    <td  align="right" colspan="2" style="background-color: #F2D7D5;"><strong></strong></td>
</tr>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<?php   $totqte=0;
        $totqteliv=0;
        $totsolde=0;
        $totttc=0; 
        
}?>
<tr>
    <td style="background-color: #F2D7D5;" align="center"><strong> Article </strong></td>    <td colspan="8"  ><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo @$lignecommande['Article']['code']."  ".@$lignecommande['Article']['name']; ?></strong></td>
</tr>
<?php }} 
$art_id=$lignecommande['Article']['id'];
?>

<!--**************************************************************************************************************-->    
<?php if(empty($lignecommande['Commandeclient']['dateliv'])){$d="";}else{$d=date("d-m-Y",strtotime(str_replace('/','-',$lignecommande['Commandeclient']['dateliv'])));} ?>
	<tr>
		<td align="center"><?php echo $d  ;?></td>
                <?php if(($testclient==0)&&($testarticle==1)){  ?> 
		<td align="center"><?php echo @$test['Client']['code'] ;?></td>
                <td align="left"><?php echo @$test['Client']['name'] ;?></td>
                <?php } ?>
                <?php if(($testclient==1)&&($testarticle==0)){  ?>
                <td align="center"><?php echo @$lignecommande['Article']['code'] ;?></td>
                <td align="left"><?php echo @$lignecommande['Article']['name'] ;?></td>
                <?php } ?>
                <?php if(($testclient==0)&&($testarticle==0)){  ?>
                <td align="center"><?php echo @$lignecommande['Article']['code'] ;?></td>
                <td align="left"><?php echo @$lignecommande['Article']['name'] ;?></td>
                <?php } ?>
                <?php if(($testclient==1)&&($testarticle==1)){  ?>
                <td align="center"><?php echo @$lignecommande['Article']['code'] ;?></td>
                <td align="left"><?php echo @$lignecommande['Article']['name'] ;?></td>
                <?php } ?>
                <td align="right"><?php echo @$lignecommande['Lignecommandeclient']['quantite'] ;?></td>
                <td align="right"><?php echo @$lignecommande['Lignecommandeclient']['quantiteliv'] ;?></td>
                <td align="right"><?php echo @$lignecommande['Lignecommandeclient']['quantite']-@$lignecommande['Lignecommandeclient']['quantiteliv'] ;?></td>
                <td align="right"><?php echo number_format(@$lignecommande['Lignecommandeclient']['puttc']*(@$lignecommande['Lignecommandeclient']['quantite']-@$lignecommande['Lignecommandeclient']['quantiteliv']),3, '.', ' ') ;?></td>
                <td align="center"><?php echo @$lignecommande['Commandeclient']['numero'] ;?></td>
                <td align="center"><?php echo date("d-m-Y",strtotime(str_replace('/','-',@$lignecommande['Commandeclient']['date']))) ;?></td>
	</tr>
<!--**************************************************************************************************************-->    
        <?php 
        $totqte=$totqte+@$lignecommande['Lignecommandeclient']['quantite'];
        $totqteliv=$totqteliv+@$lignecommande['Lignecommandeclient']['quantiteliv'];
        $totsolde=$totsolde+(@$lignecommande['Lignecommandeclient']['quantite']-@$lignecommande['Lignecommandeclient']['quantiteliv']);
        $totttc=$totttc+(@$lignecommande['Lignecommandeclient']['puttc']*(@$lignecommande['Lignecommandeclient']['quantite']-@$lignecommande['Lignecommandeclient']['quantiteliv']));
        ?>
<!--**************************************************************************************************************-->    
<?php endforeach; ?>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<tr>
    <td colspan="3" style="background-color: #F2D7D5;" align="center"><strong> Total <?php if(($testclient==1)&&($testarticle==0)){  ?>Client <?php }else { ?>Article <?php } ?> </strong></td>    
    <td  align="right"><strong><?php  echo @$totqte; ?></strong></td>
    <td  align="right"><strong><?php  echo @$totqteliv; ?></strong></td>
    <td  align="right"><strong><?php  echo @$totsolde; ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totttc,3, '.', ' '); ?></strong></td>
    <td  align="right" colspan="2" style="background-color: #F2D7D5;"><strong></strong></td>
</tr>
<tr><td colspan="9" style="height: 10px;" ></td></tr>
<tr>
    <td colspan="3" style="background-color: #F2D7D5;" align="center"><strong> Total Générale </strong></td>    
    <td  align="right"><strong><?php  echo @$totqteg; ?></strong></td>
    <td  align="right"><strong><?php  echo @$totqtelivg; ?></strong></td>
    <td  align="right"><strong><?php  echo @$totsoldeg; ?></strong></td>
    <td  align="right"><strong><?php  echo number_format(@$totttcg,3, '.', ' '); ?></strong></td>
    <td  align="right" colspan="2" style="background-color: #F2D7D5;"><strong></strong></td>
</tr>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


