<script language="JavaScript" type="text/JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}
</script>
<input type="hidden" id="page" value="historiquearticle"/>
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche '); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Recherche',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
              	<?php 
		echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly ','type'=>'text','label'=>'Date de') ); 
		echo $this->Form->input('client_id',array('id'=>'client_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Client','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
       		//echo $this->Form->input('article_id',array('id'=>'article_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Article','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                //echo $this->Form->input('famille_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Famille','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                $p=CakeSession::read('pointdevente');
                if($p==0){
                echo $this->Form->input('pointdevente_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'Point de Vente','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                }
                ?>
</div>
<div class="col-md-6">
                <?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
                echo $this->Form->input('exercice_id',array('value'=>$exerciceid,'empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('typelignevente_id',array('multiple'=>'multiple','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Type','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary " id="aff">Chercher</button>  
<!--                 <a class="btn btn-primary" href="<?php //echo $this->webroot;?>/index"/>Afficher Tout </a>-->
                  
      <a  onClick="flvFPW1(wr+'Etatligneventes/imprimerrecherche?clientid=<?php echo @$clientid;?>&date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>&familleid=<?php echo @$familleid;?>&articleid=<?php echo @$articleid;?>&exerciceid=<?php echo @$exerciceid;?>&pointdeventeid=<?php echo @$pointdeventeid;?>&typeligneventeid=<?php echo @$t;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                   
                   

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
                                    <h3 class="panel-title"><?php echo __('Etat Vente Journalier'); ?>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">


<table  style="width: 100%;" border="1" align="center" >
<tr>
<td style="width: 10%;"><center>Date</center></td>   
<td><center>Numero</center></td>    
<td><center>Action</center></td>
<td><center>Client</center></td>
<!--<td><center>Article</center></td>
<td><center>Qte</center></td>-->
<td><center>TOT_HT</center></td>
<td><center>TOT_TTC</center></td>
<td><center>View</center></td>

</tr>
    <?php
$nb=0;
$tot_ht=0;
$tot_ttc=0;
$tot_remise=0;
$tot_fodec=0;
$tot_tva=0;
//debug($lignefactures);
    foreach ($historiquearticles as $historiquearticle) { 
    if($historiquearticle['Historiquevente']['indice'] !=3){
    $tot_remise=$tot_ht+$historiquearticle['Historiquevente']['remise'];
    $tot_fodec=$tot_ht+$historiquearticle['Historiquevente']['fodec'];
    $tot_tva=$tot_ht+$historiquearticle['Historiquevente']['tva'];
    $tot_ht=$tot_ht+$historiquearticle['Historiquevente']['totalht'];
    $tot_ttc=$tot_ttc+$historiquearticle['Historiquevente']['totalttc'];    
    }else{
    $tot_remise=$tot_ht-$historiquearticle['Historiquevente']['remise'];
    $tot_fodec=$tot_ht-$historiquearticle['Historiquevente']['fodec'];
    $tot_tva=$tot_ht-$historiquearticle['Historiquevente']['tva'];    
    $tot_ht=$tot_ht-$historiquearticle['Historiquevente']['totalht'];
    $tot_ttc=$tot_ttc-$historiquearticle['Historiquevente']['totalttc'];     
    }    
        $nb=$nb+1; ?>
        <tr >
            <td ><?php echo date("d-m-Y",strtotime(str_replace('/','-',$historiquearticle['Historiquevente']['date']))); ?></td>
            <td ><?php echo $historiquearticle['Historiquevente']['numero']; ?></td>
            <td ><?php echo $historiquearticle['Historiquevente']['type']; ?></td>
            <td ><?php echo $historiquearticle['Historiquevente']['client']; ?></td>  
<!--            <td ><?php //echo $historiquearticle['Historiquevente']['article']; ?></td>
            <td align="center"><?php //echo $historiquearticle['Historiquevente']['qte']; ?></td>-->
            <td align="center"><?php echo number_format($historiquearticle['Historiquevente']['totalht'],3, '.', ' '); ?></td>
            <td align="center"><?php echo number_format($historiquearticle['Historiquevente']['totalttc'],3, '.', ' '); ?></td>
            <td align="center">
            <?php if($historiquearticle['Historiquevente']['indice']==1){ ?>
                <a onClick="flvFPW1(wr+'Bonlivraisons/imprimer/'+<?php  echo $historiquearticle['Historiquevente']['id_piece'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
            <?php } ?>
            <?php if($historiquearticle['Historiquevente']['indice']==2){ ?>
                <a onClick="flvFPW1(wr+'Factureclients/imprimer/'+<?php  echo $historiquearticle['Historiquevente']['id_piece'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
            <?php } ?>
            <?php if($historiquearticle['Historiquevente']['indice']==3){ ?>
                <a onClick="flvFPW1(wr+'Factureavoirs/imprimerfavr/'+<?php  echo $historiquearticle['Historiquevente']['id_piece'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
            <?php } ?>
            </td>  
        </tr>
    <?php } ?>
        <tr>
            <td colspan="7" align="center"><strong><br></strong></td>
        </tr>
<!--        <tr>
            <td colspan="5" align="center"><strong>Total remise</strong></td>
            <td colspan="2" align="center"><strong><?php echo $tot_remise ; ?></strong></td>
        </tr>
        <tr>
            <td colspan="5" align="center"><strong>Total fodec</strong></td>
            <td colspan="2" align="center"><strong><?php echo $tot_fodec ; ?></strong></td>
        </tr>
        <tr>
            <td colspan="5" align="center"><strong>Total tva</strong></td>
            <td colspan="2" align="center"><strong><?php echo $tot_tva ; ?></strong></td>
        </tr>-->
        <tr>
            <td colspan="5" align="center"><strong>Total HT</strong></td>
            <td colspan="2" align="center"><strong><?php echo number_format($tot_ht,3, '.', ' ') ; ?></strong></td>
        </tr>
        <tr>
            <td colspan="5" align="center"><strong>Total TTC</strong></td>
            <td colspan="2" align="center"><strong><?php echo number_format($tot_ttc,3, '.', ' ') ; ?></strong></td>
        </tr>
</table>
</div>



<br><br>






















	
                                </div></div></div></div>


