<script language="JavaScript">

    function flvFPW1(){

    var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    }

</script>
<div class="row">   
<div class="col-md-12" >
            <div class="panel panel-default"> 
                                <div class="panel-heading">
                                    <h3 class="panel-title" style="position: relative;">
                                    <?php echo __('Recherche'); ?>
                                    <ul class="panel-control" style="top:0px;right:0px;">
                                    <li><a  href="javascript:void(0)"><i class="fa fa-square-o"></i></a></li>
                                    </ul>
                                    </h3>
                                </div>
            <div class="panel-body">
        <?php echo $this->Form->create('Recherche',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

                                   
                                    
                                    
            <div class="col-md-6">  
               
              	<?php 
		echo $this->Form->input('Date_debut',array('label'=>'de','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
                echo $this->Form->input('personnel_id',array('id'=>'personnel_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Personnel','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select'));
                ?>
                </div>
            <div class="col-md-6"> 
                <?php 
                echo $this->Form->input('Date_fin',array('label'=>'Au','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly','required data-bv-notempty-message'=>'Champ Obligatoire','type'=>'text') );
                //echo $this->Form->input('paiement_id',array('multiple','id'=>'paiement_id','empty'=>'veuillez choisir','div'=>'form-group','label'=>'Personnel','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select'));
                ?>
            </div>   

                <div class="form-group">
                <div class="col-lg-9 col-lg-offset-3">
                    <button type="submit" class="btn btn-primary">Afficher</button>
                    <a class="btn btn-primary" href="<?php echo $this->webroot;?>Etatcapersonnels/index_reg_personnel"/>Afficher Tout </a>
                    <a  onClick="flvFPW1(wr + 'Etatcapersonnels/imprimer_reg_personnel?personnelid=<?php echo @$personnelid; ?>&Date_deb=<?php echo @$Date_deb; ?>&Date_fn=<?php echo @$Date_fn; ?>'
                        , 'UPLOAD', 'width=800,height=1150,scrollbars=yes', 0, 2, 2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                </div>
                </div>
 
<?php echo $this->Form->end();?>





            </div>
                            </div>
                        </div>
</div>   
<br>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Encaissement journalier'); ?></h3>
                                    <h3 class="panel-title" align='center'></h3>
                                </div>
                              
        <table class="table table-bordered table-striped" id="">
        <thead>
	<tr>
            <th style="width: 25%" class="actions" align="center">Personnel</th>
            <th style="width: 15%" class="actions" align="center">Espece</th>
            <th style="width: 15%" class="actions" align="center">Traite</th>
            <th style="width: 15%" class="actions" align="center">Cheque</th>
            <th style="width: 15%" class="actions" align="center">Virement</th>
            <th style="width: 15%" class="actions" align="center">ToTal</th>
        </tr>
        </thead>
        <tbody>
        <?php 
        $piece_espece_tot=0;
        $piece_traite_tot=0;
        $piece_cheque_tot=0;
        $piece_virement_tot=0;
        $totale=0;
        $liste_personnels=ClassRegistry::init('Personnel')->find('all',array('recursive'=>-1,'conditions'=>array(@$condpersonnel)));
        foreach ($liste_personnels as $k=>$liste_personnel){ 
        $condP='Reglementclient.personnel_id=' . $liste_personnel['Personnel']['id'];   
        $piece_espece=ClassRegistry::init('Piecereglementclient')->find('first', array(
        'fields'=>array('sum((Piecereglementclient.montant)) as solde'),    
        'conditions' => array(@$conddatedeb_reg,@$conddatefin_reg,@$condP,'Piecereglementclient.paiement_id'=>1),'recursive'=>0));
        if(!empty($piece_espece)){$piece_espece=$piece_espece[0]['solde'];}
        
        //piece traite
        $piece_traite=ClassRegistry::init('Piecereglementclient')->find('first', array(
        'fields'=>array('sum((Piecereglementclient.montant)) as solde'),    
        'conditions' => array(@$conddatedeb_reg,@$conddatefin_reg,@$condP,'Piecereglementclient.paiement_id'=>3),'recursive'=>0));
        if(!empty($piece_traite)){$piece_traite=$piece_traite[0]['solde'];}
        
        //piece cheque
        $piece_cheque=ClassRegistry::init('Piecereglementclient')->find('first', array(
        'fields'=>array('sum((Piecereglementclient.montant)) as solde'),    
        'conditions' => array(@$conddatedeb_reg,@$conddatefin_reg,@$condP,'Piecereglementclient.paiement_id'=>2),'recursive'=>0));
        if(!empty($piece_cheque)){$piece_cheque=$piece_cheque[0]['solde'];}
        
        //piece virement
        $piece_virement=ClassRegistry::init('Piecereglementclient')->find('first', array(
        'fields'=>array('sum((Piecereglementclient.montant)) as solde'),    
        'conditions' => array(@$conddatedeb_reg,@$conddatefin_reg,@$condP,'Piecereglementclient.paiement_id'=>4),'recursive'=>0));
        if(!empty($piece_virement)){$piece_virement=$piece_virement[0]['solde'];}
        
        
        if($piece_espece==NULL){$piece_espece=0;}
        if($piece_traite==NULL){$piece_traite=0;}
        if($piece_cheque==NULL){$piece_cheque=0;}
        if($piece_virement==NULL){$piece_virement=0;}
        
        $piece_espece_tot=$piece_espece_tot+$piece_espece;
        $piece_traite_tot=$piece_traite_tot+$piece_traite;
        $piece_cheque_tot=$piece_cheque_tot+$piece_cheque;
        $piece_virement_tot=$piece_virement_tot+$piece_virement;    
        ?> 
            <tr>
                <td><?php echo $liste_personnel['Personnel']['name']; ?></td>
                <td align="right" ><strong><?php echo number_format($piece_espece,3, '.', ' ')  ; ?></strong></td>
                <td align="right" ><strong><?php echo number_format($piece_traite,3, '.', ' ')  ; ?></strong></td>
                <td align="right" ><strong><?php echo number_format($piece_cheque,3, '.', ' ')  ; ?></strong></td>
                <td align="right" ><strong><?php echo number_format($piece_virement,3, '.', ' ')  ; ?></strong></td>
                <td align="right" ><strong><?php echo number_format($piece_espece+$piece_traite+$piece_cheque+$piece_virement,3, '.', ' ')  ; ?></strong></td>
            </tr>
        <?php } ?> 
            <tr>
                <td align="left"><strong>Total</strong></td>  
                <td align="right" ><strong><?php echo number_format($piece_espece_tot,3, '.', ' ')  ; ?></strong></td>
                <td align="right" ><strong><?php echo number_format($piece_traite_tot,3, '.', ' ')  ; ?></strong></td>
                <td align="right" ><strong><?php echo number_format($piece_cheque_tot,3, '.', ' ')  ; ?></strong></td>
                <td align="right" ><strong><?php echo number_format($piece_virement_tot,3, '.', ' ')  ; ?></strong></td>
                <td align="center" ><strong><?php echo number_format($piece_espece_tot+$piece_traite_tot+$piece_cheque_tot+$piece_virement_tot,3, '.', ' ')  ; ?></strong></td>
            </tr>
            
        </tbody>
	</table>
	
                                </div></div></div>	






