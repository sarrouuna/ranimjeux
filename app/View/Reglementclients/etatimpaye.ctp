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
		echo $this->Form->input('datereglement1',array('div'=>'form-group','id'=>'datedebutimpaye','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly ','type'=>'text','label'=>'Du') ); 
                echo $this->Form->input('reglement_id',array('empty'=>'veuillez choisir','id'=>'reglementimpaye','div'=>'form-group','label'=>'Reglement','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                echo $this->Form->input('pointdevente_id', array('id' => 'pointdeventeimpaye', 'empty' => 'veuillez choisir', 'div' => 'form-group', 'label' => 'Point de vente', 'between' => '<div class="col-sm-10">', 'after' => '</div>', 'class' => 'form-control'));

                ?>
</div>
<div class="col-md-6">
                <?php
		echo $this->Form->input('datereglement2',array('div'=>'form-group','id'=>'datefinimpaye','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','type'=>'text','label'=>"Jusqu'Ã ") ); 
                echo $this->Form->input('triage_id',array('id'=>'triageimpaye','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Triage','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control'));
                ?>
 
                </div>      

                <div class="form-group">
                    <div class="col-lg-9 col-lg-offset-3">
                        <!--<button type="submit" class="btn btn-primary " id="aff">Chercher</button>-->  
<!--                 <a class="btn btn-primary" href="<?php //echo $this->webroot;?>/index"/>Afficher Tout </a>-->
                  
      <!--<a  onClick="flvFPW1(wr+'Factureclients/imprimerexonore','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary etatfacture">Imprimer Exonore</button> </a>-->
      <a  onClick="flvFPW1(wr+'Reglementclients/imprimeravecdetailsimpaye','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary etatimpaye">Imprimer avec details</button> </a>
      <a  onClick="flvFPW1(wr+'Reglementclients/imprimersansdetailsimpaye','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary etatimpaye">Imprimer sans details</button> </a>
      <a href="<?php echo $this->webroot; ?>Reglementclients/exportlisteavecdetailsimpaye" class="btn ls-brown-btn etatimpaye">Exporter avec details</a>
      <a href="<?php echo $this->webroot; ?>Reglementclients/exportlistesansdetailsimpaye" class="btn ls-brown-btn etatimpaye">Exporter sans details</a>

                    </div>
                </div>
            </div>
<?php echo $this->Form->end();?>
        </div>
    </div>
</div>



