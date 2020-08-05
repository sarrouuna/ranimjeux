<script language="JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}
</script>


<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Importations/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation Importation'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Importation',array('type'=>'file','autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('name',array('readonly'=>'readonly','label'=>'Désignation','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('numero',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
	        echo $this->Form->input('date',array('readonly'=>'readonly','div'=>'form-group','value'=>$date,'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ') );		
	        echo $this->Form->input('dateliv',array('readonly'=>'readonly','div'=>'form-group','value'=>$dateliv,'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control ') );		
                echo $this->Form->input('fournisseur_id',array('disabled'=>'disabled','id'=>'fournisseur_id','empty'=>'Veuillez Choisir !!','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control select getdevise') );
		?>
                <div class='form-group' >	
                    <label class='col-md-2 control-label' id="labeldevise" ><?php echo __('Devise'); ?></label>	
                    <div class='col-sm-10' champ="divdevise" id="divdevise" > 
                      <select name='data[Importation][devise_id]' disabled='disabled' champ='devise_id' id='devise_id' class='form-control select ' onchange='' >
                        <option value=''>choix</option>
                        <?php    foreach($devises as $v){  ?>
                            <option value="<?php echo $v['Devise']['id']; ?>" <?php  if($v['Devise']['id']==$devise){?> selected="selected" <?php  }  ?>  ><?php echo $v['Devise']['name']; ?></option>
                        <?php    } ?>
                        </select>
                    </div>
                </div>
                <?php if($this->request->data['Importation']['Coefficientchoisi']==1){ $c="";$ac="checked=checked"; }else{$c="checked=checked";$ac=""; }?>
                <?php
                //echo $this->Form->input('devise_id',array('empty'=>'Veuillez Choisir !!','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('montantachat',array('readonly'=>'readonly','id'=>'montantachat','label'=>'Montant Achat','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo $this->Form->input('tauxderechenge',array('readonly'=>'readonly','type'=>'text','id'=>'tauxderechenge','label'=>'cours Devise','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo $this->Form->input('prixachat',array('readonly'=>'readonly','id'=>'prixachat','type'=>'hidden','label'=>'Prix d\'achat','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo $this->Form->input('totale',array('readonly'=>'readonly','type'=>'text','id'=>'totale','readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
                ?></div><div class="col-md-6"><?php
		echo"<table><tr><td>";
		echo $this->Form->input('avis',array('readonly'=>'readonly','type'=>'text','id'=>'avis','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('disabled'=>'disabled','value'=>@$this->request->data['Importation']['fournisseuravis'],'name'=>'data[Importation][fournisseuravis]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td><td>";
                if(!empty($fournisseurimportations[0]['Fournisseurimportation']['facture_id'])){
                ?>
                <a onClick="flvFPW1(wr+'Factures/imprimer/'+<?php  echo $fournisseurimportations[0]['Fournisseurimportation']['facture_id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                <?php
                }
                echo"</td></tr><tr><td>";
                echo $this->Form->input('transitaire',array('readonly'=>'readonly','type'=>'text','id'=>'transitaire','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('disabled'=>'disabled','value'=>@$this->request->data['Importation']['fournisseurtransitaire'],'name'=>'data[Importation][fournisseurtransitaire]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td><td>";
                if(!empty($fournisseurimportations[1]['Fournisseurimportation']['facture_id'])){
                ?>
                <a onClick="flvFPW1(wr+'Factures/imprimer/'+<?php  echo $fournisseurimportations[1]['Fournisseurimportation']['facture_id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                <?php
                }
                echo"</td></tr><tr><td>";
                echo $this->Form->input('ddttva',array('readonly'=>'readonly','type'=>'text','id'=>'ddttva','label'=>'DD&TVA','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('disabled'=>'disabled','value'=>@$this->request->data['Importation']['fournisseurddttva'],'name'=>'data[Importation][fournisseurddttva]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td><td>";
                if(!empty($fournisseurimportations[2]['Fournisseurimportation']['facture_id'])){
                ?>
                <a onClick="flvFPW1(wr+'Factures/imprimer/'+<?php  echo $fournisseurimportations[2]['Fournisseurimportation']['facture_id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                <?php
                }
                echo"</td></tr><tr><td>";
                echo $this->Form->input('assurence',array('readonly'=>'readonly','type'=>'text','label'=>'assurance','id'=>'assurence','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('disabled'=>'disabled','value'=>@$this->request->data['Importation']['fournisseurassurence'],'name'=>'data[Importation][fournisseurassurence]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td><td>";
                if(!empty($fournisseurimportations[3]['Fournisseurimportation']['facture_id'])){
                ?>
                <a onClick="flvFPW1(wr+'Factures/imprimer/'+<?php  echo $fournisseurimportations[3]['Fournisseurimportation']['facture_id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                <?php
                }
                echo"</td></tr><tr><td>";
                echo $this->Form->input('divers',array('readonly'=>'readonly','type'=>'text','id'=>'divers','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('disabled'=>'disabled','value'=>@$this->request->data['Importation']['fournisseurdivers'],'name'=>'data[Importation][fournisseurdivers]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td><td>";
                if(!empty($fournisseurimportations[4]['Fournisseurimportation']['facture_id'])){
                ?>
                <a onClick="flvFPW1(wr+'Factures/imprimer/'+<?php  echo $fournisseurimportations[4]['Fournisseurimportation']['facture_id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                <?php
                }
                echo"</td></tr><tr><td>";
                echo $this->Form->input('fraisfinancie',array('readonly'=>'readonly','type'=>'text','id'=>'fraisfinancie','label'=>'Frais Financiers','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('disabled'=>'disabled','value'=>@$this->request->data['Importation']['fournisseurfraisfinancie'],'name'=>'data[Importation][fournisseurfraisfinancie]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td><td>";
                if(!empty($fournisseurimportations[5]['Fournisseurimportation']['facture_id'])){
                ?>
                <a onClick="flvFPW1(wr+'Factures/imprimer/'+<?php  echo $fournisseurimportations[5]['Fournisseurimportation']['facture_id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                <?php
                }
                echo"</td></tr><tr><td>";
                echo $this->Form->input('magasinage',array('readonly'=>'readonly','type'=>'text','id'=>'magasinage','label'=>'Magasinage','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
                echo $this->Form->input('fournisseur',array('disabled'=>'disabled','value'=>@$this->request->data['Importation']['fournisseurmagasinage'],'name'=>'data[Importation][fournisseurmagasinage]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td><td>";
                if(!empty($fournisseurimportations[6]['Fournisseurimportation']['facture_id'])){
                ?>
                <a onClick="flvFPW1(wr+'Factures/imprimer/'+<?php  echo $fournisseurimportations[6]['Fournisseurimportation']['facture_id'];?>,'UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class='btn btn-xs ls-blue-btn'><i class='fa fa-print'></i></button></a>
                <?php
                }
                echo"</td></tr></table>";
                ?>
                </div>
                <div class="col-md-3"></div>                    
                <div class="col-md-6">
                <?php
                echo $this->Form->input('coefficien',array('value'=>  sprintf('%.2f',@$this->request->data['Importation']['coefficien']),'type'=>'text','type'=>'text','readonly'=>'readonly','id'=>'coefficien','label'=>'Coefficient','div'=>'form-group','between'=>'<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12">','after'=>'</div></td><td style="width: 5%;vertical-align: top"><input type="radio" disabled="disabled" name="data[Importation][Coefficientchoisi]"  value="0" '.$c.'></td></tr></table>','class'=>'form-control calculecoefficient') );
		echo $this->Form->input('coeff',array('readonly'=>'readonly','type'=>'text','type'=>'text','id'=>'coeff','label'=>'Ancien Coefficient','div'=>'form-group','between'=>'<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12">','after'=>'</div></td><td style="width: 5%;vertical-align: top"><input type="radio" disabled="disabled" name="data[Importation][Coefficientchoisi]"  value="1" '.$ac.'></td></tr></table>','class'=>'form-control ') );
                ?> 
                </div>
                                    
  <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('ajout Pieces Jointes'); ?></h3>
                                </div>
                                <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:90%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap" width="49%">Désignation</td>
                                    <td align="center" nowrap="nowrap" width="50%">Piece</td>
                                </tr>
                                </thead>
								
								
								
				<tr class="tr" style="display:none;">
                                <td> 
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Piecejointe','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('namepiecejointe_id',array('disabled'=>'disabled','empty'=>'choix','div'=>'form-group','label'=>'', 'name' => '','table'=>'Piecejointe','index'=>'','id'=>'','champ'=>'namepiecejointe_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'') );?>
                                        <?php echo $this->Form->input('id',array('empty'=>'choix','div'=>'form-group','label'=>'', 'name' => '','table'=>'Piecejointe','index'=>'','id'=>'','champ'=>'id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','type'=>'hidden') );?>
                                </td>
                                <td>
                                        <?php echo $this->Form->input('piece',array('name' => '','table'=>'Piecejointe','index'=>'','id'=>'','champ'=>'piece','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'file','multiple'=>"true") ); ?>       
                                    
									
				</td>
                                   
                                </tr>

                                     <?php foreach ($piecejointes as $i=>$piecejointe) {  ?>

                                <tr>
                                <td>
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Piecejointe]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Piecejointe','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('id',array('value'=>$piecejointe['Piecejointe']['id'],'div'=>'form-group','label'=>'', 'name' => 'data[Piecejointe]['.$i.'][id]','table'=>'Piecejointe','index'=>$i,'id'=>'id','champ'=>'id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'hidden') );?> 
			                <?php echo $this->Form->input('namepiecejointe_id',array('disabled'=>'disabled','value'=>$piecejointe['Piecejointe']['namepiecejointe_id'],'div'=>'form-group','label'=>'', 'name' => 'data[Piecejointe]['.$i.'][namepiecejointe_id]','table'=>'Piecejointe','index'=>'0','id'=>'name','champ'=>'name','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                </td>
                                <td>
                                        <?php echo $this->Form->input('piece',array('type'=>'hidden','value'=>$piecejointe['Piecejointe']['piece'],'name' => 'data[Piecejointe]['.$i.'][piece]','table'=>'Piecejointe','index'=>'0','champ'=>'piece','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') ); ?>       
                                <center>
                                    <a  onClick="flvFPW1(wr+'files/upload/<?php echo $piecejointe['Piecejointe']['piece'];?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>                   
				</center>	  
                                </td>
</tr>
                                     <?php } ?>
</tbody>
                                </table>
              	<input type="hidden" value="<?php echo @$i ; ?>" id="index" />
</div>
                            </div>
                        </div>                
</div>                                    
                                    

  <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Situation Importation'); ?></h3>
                                    
                                </div>
                                <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtablec" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Situation</td>
                                    <td align="center" nowrap="nowrap">Date début</td>
                                    <td align="center" nowrap="nowrap">Date fin</td>
                                    <td align="center" nowrap="nowrap">Nbr Jours </td>
                                    <td align="center"></td>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('supp',array('name'=>'','id'=>'','champ'=>'supp','table'=>'Situation','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'') );?>
                                        <?php echo $this->Form->input('namesituation_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Situation','index'=>'','id'=>'','champ'=>'namesituation_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('datedebut',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Situation','index'=>'','id'=>'','champ'=>'datedebut','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('datefin',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Situation','index'=>'','id'=>'','champ'=>'datefin','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:24%">
                                        <?php echo $this->Form->input('nbrjour',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Situation','index'=>'','id'=>'','champ'=>'nbrjour','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td align="center"> <input type="radio" name="" champ="contactchoisi"  index=""></td>
                                
                                </tr>
                                <?php foreach ($situations as $s=>$situation) {  
                                $datedebut=date("d/m/Y",strtotime(str_replace('/','/',$situation['Situation']['datedebut'])));
                                $datefin=date("d/m/Y",strtotime(str_replace('/','/',$situation['Situation']['datefin'])));
                                ?>
                                <tr>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('supp',array('name'=>'data[Situation]['.$s.'][supp]','id'=>'supp'.$s,'champp'=>'sup','table'=>'Situation','index'=>$s,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('namesituation_id',array('disabled'=>'disabled','value'=>@$situation['Situation']['namesituation_id'],'div'=>'form-group','label'=>'', 'name' => 'data[Situation]['.$s.'][namesituation_id]','table'=>'Situation','index'=>$s,'id'=>'namesituation_id'.$s,'champ'=>'namesituation_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez choisir !!') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('datedebut',array('readonly'=>'readonly','value'=>@$datedebut,'label'=>'','div'=>'form-group', 'name' => 'data[Situation]['.$s.'][datedebut]','table'=>'Situation','index'=>$s,'id'=>'datedebut'.$s,'champ'=>'datedebut','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('datefin',array('readonly'=>'readonly','value'=>@$datefin,'name'=>'data[Situation]['.$s.'][datefin]','id'=>'datefin'.$s,'table'=>'Situation','index'=>$s,'champ'=>'datefin','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td style="width:24%">
                                        <?php echo $this->Form->input('nbrjour',array('readonly'=>'readonly','value'=>@$situation['Situation']['nbrjour'],'name'=>'data[Situation]['.$s.'][nbrjour]','id'=>'nbrjour'.$s,'table'=>'Situation','index'=>$s,'champ'=>'nbrjour','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td> <input type="radio" name="data[contactchoisi]" disabled="disabled" <?php if($situation_id==$situation['Situation']['id']){?> checked="checked"<?php }?> value="<?php echo @$s ; ?>" index="<?php echo @$s ; ?>"></td>
                                </tr>
                                        <?php } ?>
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo @$s ; ?>" id="indexc" />
</div>
                            </div>
                        </div>                
</div> 

  <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Ligne d\'achat par cette importation'); ?></h3>
                                    
                                </div>
                                <div class="panel-body" >
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Ref </td> 
                                    <td align="center" nowrap="nowrap">Article</td>
                                    <td align="center" nowrap="nowrap"> Quantite </td>
                                    <td align="center" nowrap="nowrap">Prix</td>
                                    <td align="center" nowrap="nowrap">Tot Prix</td>
                                    <td align="center" nowrap="nowrap">CDR </td>       
                                    <td align="center" nowrap="nowrap">Total CDR</td> 
                                </tr>
                                </thead>
                                <tbody>

                                     <?php         foreach ($lignefactures as $i=>$lr){    ?> 
  
                                <tr>
                                    <td style="width:10%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $lr['Article']['code'] ?>'>  
                                    </td>
                                    <td style="width:52%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $lr['Article']['name'] ?>'>  
                                    </td>
                                    <td style="width:6%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $lr['Lignefacture']['quantite'] ?>'>  
                                    </td>
                                    <td style="width:8%">
                                          <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $lr['Lignefacture']['prix'] ?>'>  
                                    </td>
                                    <td style="width:8%">
                                        <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo sprintf('%.3f',$lr['Lignefacture']['prix']*$lr['Lignefacture']['quantite']); ?>'>  
                                    </td>
                                    <td style="width:8%">
                                        <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo $lr['Lignefacture']['prixhtva'] ?>'>  
                                    </td>
                                    <td style="width:8%">
                                        <input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo sprintf('%.3f',$lr['Lignefacture']['prixhtva']*$lr['Lignefacture']['quantite']); ?>'>  
                                    </td>
                                 <?php } ?> 
                                </tbody>
                                </table>
              	<input type="hidden" value=""  id="index" />
</div>
                            </div>
                        </div>                
</div> 
    <br>
 <?php   if(!empty($reglements)){       
     foreach($reglements as $reglement){
    ?>                          
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Consultation règlement fournisseur '); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo $this->Form->create('Reglement',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                           
           <div class="col-md-6">                         
             			 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Fournisseur'); ?></label>	
                                  
			<?php  //debug($reglement);die;?>
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo $reglement['Fournisseur']['name']; ?>'>
                                  </div>
			
		
                                 
                            </div>	
                
           </div><div class="col-md-6"> 
                                	 <div class='form-group'>	
                                 <label class='col-md-2 control-label'><?php echo __('Date'); ?></label>	
                                  	
                                  
			<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo date("d/m/Y",strtotime(str_replace('-','/',($reglement['Reglement']['Date'])))); ?>'>

                                  </div>
			
		
                                 
                                         </div> </div>
                                </div></div></div></div>

    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Factures  réglées '); ?></h3>
                                </div>
                                <div class="panel-body">
                                 
                                    <div class="ls-editable-table table-responsive ls-table">
                                <table class="table table-bordered table-striped table-bottomless" id="table">
                                    <thead>
                                            <tr>
                                                <td>Numéro</td>
                                                <td>Date</td>
                                                <td>Total TTC</td>
                                                <td>Montant réglé</td>
                                                 <td>Reste</td>
                                                
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            <?php 
                                                $t='0';
                                                foreach($reglement['Lignereglement']as $j=>$l){
                                                  $t=$t.','.$l['facture_id'];
                                                }
                                                
                                            
                                            $obj = ClassRegistry::init('Facture');
                                            $factures = $obj->find('all',array('conditions'=>array('Facture.id in('.$t.')'),'recursive'=>0));  
                                            //debug($factures);
                                            foreach ($factures as $l){ 
                                            ?>
                                            <tr>
                                                <td> <?php echo $l['Facture']['numero']; ?></td>
                                                <td><?php echo  date("d/m/Y",strtotime(str_replace('-','/',$l['Facture']['date']))); ?></td>
                                                <td><?php echo $l['Facture']['totalttc']; ?></td>
                                                <td><?php echo $l['Facture']['Montant_Regler']; ?> </td>
                                                <td><?php echo $l['Facture']['totalttc']-$l['Facture']['Montant_Regler']; ?></td>
                                                
                                            </tr>
                                            <?php }?>
                                             <tr>
                                                <td colspan="4" >Total</td>
                                                <td><?php echo h($reglement['Reglement']['Montant']); ?></td>
                                            </tr>
                                            
                                           
                                             <tr>
                                                <td colspan="4" >Net à payer </td>
                                                <td><?php echo h($reglement['Reglement']['Montant']); ?></td>
                                            </tr>
                                             
                                        </tbody></table>
                                    </div></div></div></div></div>
                                       
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Pièces règlement fournisseur'); ?></h3>
                                </div>
                                <div class="panel-body">
                                 
                                    <div class="ls-editable-table table-responsive ls-table">
                                        
                            <?php    $obj = ClassRegistry::init('Piecereglement');
                                $piecereglement = $obj->find('all',array('conditions'=>array('Piecereglement.reglement_id'=>$reglement['Reglement']['id'])));
                                //debug($piecereglement);
                                            
                              foreach($piecereglement as $i=>$lp ){
                                    $montantcredit=$lp['Piecereglement']['montant'];
                                if($lp['Piecereglement']['paiement_id']==7){
                                //$credit=$this->Traitecredit->find('all',array('conditions'=>array('Traitecredit.piecereglement_id'=>$pieceregement[0]['Piecereglement']['id']),'recursive'=>0));   
                                $obj = ClassRegistry::init('Traitecredit');
                                $credit = $obj->find('all',array('conditions'=>array('Traitecredit.piecereglement_id'=>$lp['Piecereglement']['id']),'recursive'=>0));   
                                //debug($piecereglement);
                                }    
                                $obj = ClassRegistry::init('Situationpiecereglement');
                                $situationpiecereglement = $obj->find('all',array('conditions'=>array('Situationpiecereglement.piecereglement_id'=>$lp['Piecereglement']['id'])));
                                //debug($situationpiecereglement);
                                    ?>
                                        <table class="table table-bordered table-striped table-bottomless" id="table">
                                            <tr>
                                                <td colspan="4"> Mode règlement</td>
                                                <td> <?php echo $lp['Paiement']['name']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"> Montant</td>
                                                <td><?php echo $lp['Piecereglement']['montant']; ?></td>
                                            </tr>
                                            
                                            <?php if($lp['Paiement']['id']!=1 && $lp['Paiement']['id']!=5) {?>
                                            <?php if($lp['Paiement']['id']!=7 ) {?>
                                             <tr>
                                                <td colspan="4"> Echéance</td>
                                                <td><?php echo date("d/m/Y",strtotime(str_replace('-','/',$lp['Piecereglement']['echance']))); ?></td>
                                            </tr>
                                            <?php } ?>
                                             <tr>
                                                <td colspan="4"> Numéro pièce</td>
                                                <td><?php echo $lp['Piecereglement']['num']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"> Banque</td>
                                             <td>
                                              <?php echo $this->Html->link($lp['Compte']['banque'], array('controller' => 'utilisateurs', 'action' => 'view', $lp['Compte']['id'])); ?>
                                             </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4"> Rib</td>
                                             <td>
                                              <?php echo $this->Html->link($lp['Compte']['rib'], array('controller' => 'utilisateurs', 'action' => 'view', $lp['Compte']['id'])); ?>
                                             </td>
                                            </tr>
                                            <?php }?>
                                            <?php if($lp['Paiement']['id']==5){?>
                                             <tr>
                                                <td colspan="4"> Montant Brut</td>
                                                <td><?php echo $lp['Piecereglement']['montant_brut']; ?></td>
                                            </tr>
                                             <tr>
                                                <td colspan="4"> Montant Net</td>
                                                <td><?php echo $lp['Piecereglement']['montant_net']; ?></td>
                                            </tr>
                                            
                                            <?php }?>
                                             <?php if($lp['Paiement']['id']==7 ) {?>
                                             <tr>
                                                <td colspan="4"> Nbr Moins</td>
                                                <td><?php echo $lp['Piecereglement']['nbrmoins']; ?></td>
                                            </tr>
                                            <?php } ?>
                                            </tbody>
                                        </table> <br>
                                            <?php } ?>
                                         <?php if($lp['Paiement']['id']==7 ) {?>
                                        <table  style="width: 100%;" border="1" align="center" id="tablet">
                                            <tr bgcolor="#F2D7D5">
                                                <td><center>N°</center></td>    
                                                <td><center>Numéro de piéce</center></td>
                                                <td><center>Echéance</center></td>
                                                <td><center>Montant</center></td>
                                            </tr>
                                                <?php 
                                                $totale=0;
                                                $agio=0;
                                                foreach ($credit as $n=>$c){ $m=$n+1;
                                                $totale=$totale+$c['Traitecredit']['montantcredit'];
                                                $agio=$totale-$montantcredit;
                                                ?>
                                            <tr id="trr<?php echo $m;?>">
                                                <td ><?php echo $m; ?></td>    
                                                <td >
                                                <?php  echo $this->Form->input('num_piececredit',array('readonly'=>'readonly','value'=>@$c['Traitecredit']['num_piececredit'],'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>$m,'id'=>'num_piececredit'.$m,'champ'=>'num_piececredit','table'=>'traitecredits','name'=>'data[traitecredits]['.$m.'][num_piececredit]') );  ?>  
                                                </td>
                                                <td >
                                                <?php  echo $this->Form->input('echancecredit',array('readonly'=>'readonly','value'=>date("d/m/Y",strtotime(str_replace('/','-',@$c['Traitecredit']['echancecredit']))),'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>$m,'id'=>'echancecredit'.$m,'champ'=>'echancecredit','table'=>'traitecredits','name'=>'data[traitecredits]['.$m.'][echancecredit]') );  ?>  
                                                </td>
                                                <td >
                                                <?php  echo $this->Form->input('montantcredit',array('readonly'=>'readonly','value'=>@$c['Traitecredit']['montantcredit'],'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>$m,'id'=>'montantcredit'.$m,'champ'=>'montantcredit','table'=>'traitecredits','name'=>'data[traitecredits]['.$m.'][montantcredit]') );  ?>  
                                                </td>
                                            </tr>
                                                <?php } ?>
                                            <tr>
                                                <td align="center" colspan="3"><label><strong>Total</strong></label></td><td align="center"><input type="text" id="total" class="form-control" readonly="readonly" value="<?php echo sprintf('%.3f',$totale); ?>"></td>
                                            </tr>
                                            <tr>
                                                <td align="center" colspan="3"><label><strong>Agio</strong></label></td><td align="center"><input type="text" id="agio" class="form-control" readonly="readonly" value="<?php echo sprintf('%.3f',$agio); ?>"></td>
                                            </tr>
                                            </table>
                                            <br>
                                        <?php } ?>
                                        <?php if(!empty($situationpiecereglement)){ ?>
                                <table class="table table-bordered table-striped table-bottomless" id="table">
                                        <thead>
                                            <tr bgcolor="#F2D7D5">
                                                <td><center>Etat</center></td>
                                                <td><center>Date</center></td>
                                                <td><center>Agio</center></td>
                                                <td align="center"></td>
                                                <td align="center">crédit</td>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            <?php 
                                            foreach ($situationpiecereglement as $l){ 
                                            ?>
                                            <tr>
                                                <td > <?php echo $l['Etatpiecereglement']['name']; ?></td>
                                                <td align="center"><?php echo  date("d/m/Y",strtotime(str_replace('-','/',$l['Situationpiecereglement']['date']))); ?></td>
                                                <td align="center"><?php echo $l['Situationpiecereglement']['agio']; ?></td>
                                                <td> <input type="radio" name="data[contactchoisi]" disabled="disabled" <?php if($l['Piecereglement']['etatpiecereglement_id']==$l['Situationpiecereglement']['etatpiecereglement_id']){?> checked="checked"<?php }?>></td>
                                            <?php if($l['Situationpiecereglement']['etatpiecereglement_id']==9){?>
                                                <td align="center">
                                                   
                                                    
                                                    
                                                 <table  style="width: 100%;" border="1" align="center" id="tablet">
                                            <tr bgcolor="#F2D7D5">
                                                <td><center>NÂ°</center></td>    
                                                <td><center>NumÃ©ro de piÃ©ce</center></td>
                                                <td><center>EchÃ©ance</center></td>
                                                <td><center>Montant</center></td>
                                            </tr>
                                                <?php 
                                                $credit=ClassRegistry::init('Traitecredit')->find('all',array('conditions'=>array('Traitecredit.piecereglement_id'=>$lp['Piecereglement']['id']),'order'=>array('Traitecredit.echancecredit'=>'asc'),'recursive'=>0));   
                                                $totale=0;
                                                $agio=0;
                                                foreach ($credit as $n=>$c){ $m=$n+1;
                                                $totale=$totale+$c['Traitecredit']['montantcredit'];
                                                //$agio=$totale-$montantcredit;
                                                ?>
                                            <tr id="tr<?php echo $m;?>">
                                                <td ><?php echo $m; ?></td>    
                                                <td >
                                                <?php  echo $this->Form->input('id',array('value'=>@$c['Traitecredit']['id'],'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'hidden','index'=>$m,'id'=>$i.'num_piececredit'.$m,'champ'=>'id','table'=>'traitecredits','name'=>'data[credits]['.$i.'][traitecredits]['.$m.'][id]') );  ?>  
                                                <?php  echo $this->Form->input('num_piececredit',array('readonly'=>'readonly','value'=>@$c['Traitecredit']['num_piececredit'],'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>$m,'id'=>$i.'num_piececredit'.$m,'champ'=>'num_piececredit','table'=>'traitecredits','name'=>'data[credits]['.$i.'][traitecredits]['.$m.'][num_piececredit]') );  ?>  
                                                </td>
                                                <td >
                                                <?php  echo $this->Form->input('echancecredit',array('readonly'=>'readonly','value'=>date("d/m/Y",strtotime(str_replace('/','-',@$c['Traitecredit']['echancecredit']))),'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>$m,'id'=>$i.'echancecredit'.$m,'champ'=>'echancecredit','table'=>'traitecredits','name'=>'data[credits]['.$i.'][traitecredits]['.$m.'][echancecredit]') );  ?>  
                                                </td>
                                                <td >
                                                <?php  echo $this->Form->input('montantcredit',array('readonly'=>'readonly','value'=>@$c['Traitecredit']['montantcredit'],'div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>$m,'id'=>$i.'montantcredit'.$m,'champ'=>'montantcredit','table'=>'traitecredits','name'=>'data[credits]['.$i.'][traitecredits]['.$m.'][montantcredit]','onkeyup'=>'calculetotalecredit('.$i.')') );  ?>  
                                                </td>
                                            </tr>
                                                <?php } ?>
                                            
                                            <tr id="" champ='tr' class="tr" table='tr' index='' style="display:none;">
                                                <td ><span index="" id="" champ="n"></span></td>    
                                                <td >
                                                <?php  echo $this->Form->input('num_piececredit',array('div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>'','id'=>'','champ'=>'num_piececredit','table'=>'traitecredits','name'=>'') );  ?>  
                                                </td>
                                                <td >
                                                <?php  echo $this->Form->input('echancecredit',array('div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ','label'=>'','type'=>'text','index'=>'','id'=>'','champ'=>'echancecredit','table'=>'traitecredits','name'=>'') );  ?>  
                                                </td>
                                                <td >
                                                <?php  echo $this->Form->input('montantcredit',array('div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','label'=>'','type'=>'text','index'=>'','id'=>'','champ'=>'montantcredit','table'=>'traitecredits','name'=>'') );  ?>  
                                                </td>
                                            </tr>
                                            </table>   
                                                    
                                                    
                                                </td>
                                                <?php }else{?>
                                                <td align="center"></td>
                                                <?php }?>
                                            </tr>
                                            <?php }?>
                                </table>
                                <?php }?>
              			</div>
                                 </div>
<?php echo $this->Form->end();?>
	
</div></div></div>                                
 <?php }} ?>                                          
                                    <center>
                                        <a  onClick="flvFPW1(wr+'Importations/imprimerview/<?php echo @$this->request->data['Importation']['id'];?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>
                                    </center>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>





