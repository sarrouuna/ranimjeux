<script language="JavaScript" type="text/JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}
</script>
<input type="hidden" id="page"  value="indexarticle">
<div class="row" >
    <div class="col-md-12" >
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Recherche Historique Article'); ?></h3>
            </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Recherche',array('autocomplete' => 'off','class'=>'form-horizontal ls_form')); ?>

                <div class="col-md-6">                  
              	<?php 
		echo $this->Form->input('date1',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly ','type'=>'text','label'=>'Date de') ); 
		echo $this->Form->input('client_id',array('id'=>'client_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Client','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
       		//echo $this->Form->input('article_id',array('id'=>'article_id0','type'=>'hidden','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Article','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
       		echo $this->Form->input('depot_id',array('id'=>'depot_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Depot','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
                <?php
                echo $this->Form->input('article_id', array('div' => 'form-group', 'index' => '0', 'id' => 'article_id0', 'champ' => 'article_id', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control', 'type' => 'hidden'));
                ?>
                <?php
                echo $this->Form->input('code', array('yourid'=>'article_id0','div' => 'form-group', 'placeholder' => 'Code', 'label' => 'Code', 'index' => '0', 'id' => 'code0', 'champ' => 'code', 'between' => '<div class="col-sm-10"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div>', 'class' => 'form-control index_code_manuel_autocomplete', 'type' => 'text'));
                ?>

                <?php echo $this->Form->input('designation', array('yourid'=>'article_id0','div' => 'form-group', 'placeholder' => 'Designation', 'label' => 'Article', 'index' => '0', 'id' => 'designation0', 'champ' => 'designation', 'between' => '<div class="col-sm-10"><div class="autocomplete" style="width:100%;">', 'after' => '</div></div>', 'class' => 'form-control index_designation_manuel_autocomplete', 'type' => 'text')); ?>
                </div>
<div class="col-md-6">
                <?php
		echo $this->Form->input('date2',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
       		echo $this->Form->input('fournisseur_id',array('id'=>'fournisseur_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Fournisseur','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('exercice_id',array('empty'=>'veuillez choisir','div'=>'form-group','label'=>'année','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('typelignevente_id',array('multiple'=>'multiple','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Type','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
    
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <button type="submit" class="btn btn-primary testhistoriquearticle" id="aff">Chercher</button>  
                        <a  onClick="flvFPW1(wr+'Etathistoriquearticles/imprimerrecherche?clientid=<?php echo @$clientid;?>&date1=<?php echo @$date1;?>&date2=<?php echo @$date2;?>&fournisseurid=<?php echo @$fournisseurid;?>&articleid=<?php echo @$articleid;?>&exerciceid=<?php echo @$exerciceid;?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
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
                                    <h3 class="panel-title"><?php echo __('Etat Historique articles'); ?>
                                      
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">


<table  style="width: 100%;" border="1" align="center" >
<tr>
<td style="width: 10%;"><center>Date</center></td>   
<td><center>Action</center></td>
<td><center>Mg</center></td>
<td><center>N° Bon</center></td>
<td><center>Nom / Raison social</center></td>
<td><center>Entrée</center></td>
<td><center>Sortie</center></td>
<td><center>PU</center></td>
<td><center>TOT_TTC</center></td>

</tr>
    <?php
$nb=0;
//debug($lignefactures);
$qte_ent=0;
$qte_sor=0;
    foreach ($historiquearticles as $historiquearticle) { $nb=$nb+1; 
    if(!empty($historiquearticle['Historiquearticle']['date'])){
        $date=date("d-m-Y",strtotime(str_replace('/','-',$historiquearticle['Historiquearticle']['date'])));
    }else{
        $date="";
    }
    if($historiquearticle['Historiquearticle']['indice']==10){
        $qte_ent=$qte_ent+$historiquearticle['Historiquearticle']['qte'];
    }
    if($historiquearticle['Historiquearticle']['mode']=="Entreé"){
        $qte_ent=$qte_ent+$historiquearticle['Historiquearticle']['qte'];
    }
    if($historiquearticle['Historiquearticle']['mode']=="Sortie"){
        $qte_sor=$qte_sor+$historiquearticle['Historiquearticle']['qte'];
    }
    $qte_final=$qte_ent-$qte_sor;
    ?>
        <tr>
            <td ><?php echo $date ; ?></td>
            <td ><?php echo $historiquearticle['Historiquearticle']['type']; ?></td>
            <td ><?php echo $historiquearticle['Historiquearticle']['depot']; ?></td>
            <td ><?php echo $historiquearticle['Historiquearticle']['numero']; ?></td>
            <td <?php if($historiquearticle['Historiquearticle']['indice']==10){ ?>align="center"<?php }  ?>>
    <?php if (!empty($historiquearticle['Historiquearticle']['client']))   { ?>     <?php echo $historiquearticle['Historiquearticle']['client']; ?>  <?php }?>
    <?php if (!empty($historiquearticle['Historiquearticle']['fournisseur']))   { ?>     <?php echo $historiquearticle['Historiquearticle']['fournisseur']; ?>  <?php }?>
    <?php if (!empty($historiquearticle['Historiquearticle']['utilisateur']))   { ?>     <?php echo $historiquearticle['Historiquearticle']['utilisateur']; ?> <?php }?>
           </td>
           <?php if($historiquearticle['Historiquearticle']['indice']==10){ ?>
           <td align="center" colspan="2">
                <?php
                echo $historiquearticle['Historiquearticle']['qte'];
                ?>
            </td>
           <?php }else{  ?>
            <td align="right">
                <?php
                if($historiquearticle['Historiquearticle']['mode']=="Entreé"){
                echo $historiquearticle['Historiquearticle']['qte'];
                }
                ?>&nbsp;
            </td>
            <td align="right">
                <?php
                if($historiquearticle['Historiquearticle']['mode']=="Sortie"){
                echo $historiquearticle['Historiquearticle']['qte'];
                }
                ?>&nbsp;
            </td>
            <?php }  ?>
            <td align="right"><?php echo $historiquearticle['Historiquearticle']['pu']; ?></td>
            <td align="right"><?php echo $historiquearticle['Historiquearticle']['ptot']; ?></td>
        </tr>
    <?php } ?>
        <tr>
            <td colspan="5"></td>
            <td align="right"><?php echo $qte_ent; ?></td>
            <td align="right"><?php echo $qte_sor; ?></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td colspan="2" align="center"><?php echo @$qte_final; ?></td>
            <td colspan="2"></td>
        </tr>
</table>
</div>



<br><br>






















	
                                </div></div></div></div>


