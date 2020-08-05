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
                                    <h3 class="panel-title"><?php echo __('Modification Importation'); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Importation',array('type'=>'file','autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

            <div class="col-md-6">                  
              	<?php
		echo $this->Form->input('id',array('div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('name',array('label'=>'Désignation','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
		echo $this->Form->input('numero',array('readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
	        echo $this->Form->input('date',array('div'=>'form-group','value'=>$date,'type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
	        echo $this->Form->input('dateliv',array('value'=>$dateliv,'label'=>'Date livraison prévue','div'=>'form-group','type'=>'text','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control datePickerOnly') );		
                echo $this->Form->input('fournisseur_id',array('id'=>'fournisseur_id','empty'=>'Veuillez Choisir !!','div'=>'form-group','between'=>'<div class="col-sm-8">','after'=>'</div>','class'=>'form-control select getdevise','between'=>'<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12">','after'=>'</div></td><td style="width: 5%;vertical-align: top"><span title="Ancien prix"><a   onclick="recap_importation()" href="#reModal_refuser" champ="order" id="order" value="0" <button class="  "><i class="fa fa fa-pencil"></i></a></span></td></tr></table>') );
		?>
                <div class='form-group' >	
                    <label class='col-md-2 control-label' id="labeldevise" ><?php echo __('Devise'); ?></label>	
                    <div class='col-sm-10' champ="divdevise" id="divdevise" > 
                      <select name='data[Importation][devise_id]' champ='devise_id' id='devise_id' class='form-control select ' onchange='' >
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
		echo $this->Form->input('montantachat',array('type'=>'text','id'=>'montantachat','label'=>'Montant Achat','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo $this->Form->input('tauxderechenge',array('type'=>'text','id'=>'tauxderechenge','label'=>'Cours Devise','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo $this->Form->input('prixachat',array('type'=>'text','id'=>'prixachat','type'=>'hidden','label'=>'Prix d\'achat','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo $this->Form->input('totale',array('type'=>'text','id'=>'totale','readonly'=>'readonly','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
                ?></div><div class="col-md-6"><?php
                echo"<table><tr><td>";
		echo $this->Form->input('avis',array('type'=>'text','id'=>'avis','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseuravis'],'name'=>'data[Importation][fournisseuravis]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr><tr><td>";
                echo $this->Form->input('transitaire',array('type'=>'text','id'=>'transitaire','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseurtransitaire'],'name'=>'data[Importation][fournisseurtransitaire]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr><tr><td>";
                echo $this->Form->input('ddttva',array('type'=>'text','id'=>'ddttva','label'=>'DD&TVA','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseurddttva'],'name'=>'data[Importation][fournisseurddttva]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr><tr><td>";
                echo $this->Form->input('assurence',array('type'=>'text','label'=>'assurance','id'=>'assurence','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseurassurence'],'name'=>'data[Importation][fournisseurassurence]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr><tr><td>";
                echo $this->Form->input('divers',array('type'=>'text','id'=>'divers','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseurdivers'],'name'=>'data[Importation][fournisseurdivers]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr><tr><td>";
                echo $this->Form->input('fraisfinancie',array('type'=>'text','id'=>'fraisfinancie','label'=>'Frais Financiers','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
		echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseurfraisfinancie'],'name'=>'data[Importation][fournisseurfraisfinancie]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr><tr><td>";
                echo $this->Form->input('magasinage',array('type'=>'text','id'=>'magasinage','label'=>'Magasinage','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control calculecoefficient') );
		echo"</td><td>";
                echo $this->Form->input('fournisseur',array('value'=>@$this->request->data['Importation']['fournisseurmagasinage'],'name'=>'data[Importation][fournisseurmagasinage]','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','id'=>'fc','class'=>'form-control','empty'=>'Veuillez Choisir un fournisseur !!') );
                echo"</td></tr></table>";
                //echo $this->Form->input('coefficien',array('type'=>'text','type'=>'text','readonly'=>'readonly','id'=>'coefficien','label'=>'Coefficient','div'=>'form-group','between'=>'<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12">','after'=>'</div></td><td style="width: 5%;vertical-align: top"><input type="radio" name="data[Importation][Coefficientchoisi]"  value="0" '.$c.'></td></tr></table>','class'=>'form-control calculecoefficient') );
		//echo $this->Form->input('coeff',array('type'=>'text','type'=>'text','id'=>'coeff','label'=>'Ancien Coefficient','div'=>'form-group','between'=>'<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12">','after'=>'</div></td><td style="width: 5%;vertical-align: top"><input type="radio" name="data[Importation][Coefficientchoisi]"  value="1" '.$ac.'></td></tr></table>','class'=>'form-control ') );
                
                ?>
                </div>  
  
  <div class="col-md-6">
                <?php
                echo $this->Form->input('coefficien',array('id'=>'coefficien','type'=>'hidden','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') );
                echo $this->Form->input('c',array('value'=>sprintf('%.2f',@$this->request->data['Importation']['coefficien']),'type'=>'text','readonly'=>'readonly','id'=>'c','label'=>'Coefficient','div'=>'form-group','between'=>'<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12">','after'=>'</div></td><td style="width: 5%;vertical-align: top"><input checked="checked" type="radio" name="data[Importation][Coefficientchoisi]" value="0" ></td></tr></table>','class'=>'form-control calculecoefficient') );
		echo $this->Form->input('coeff',array('type'=>'text','id'=>'coeff','label'=>'Ancien Coefficient','div'=>'form-group','between'=>'<table style="width: 70%"><tr><td style="width: 95%"><div class="col-sm-12">','after'=>'</div></td><td style="width: 5%;vertical-align: top"><input type="radio" name="data[Importation][Coefficientchoisi]" value="1" ></td></tr></table>','class'=>'form-control ') );
                ?> 
  </div>
  
                                    
  <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('ajout Pieces Jointes'); ?></h3>
                                    <a class="btn btn-danger ajouterligne_w" table='addtable' index='index' style="
                                    float: right; 
                                    position: relative;
                                    top: -25px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter ligne</a>
                                </div>
                                <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtable" style="width:90%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap" width="49%">Désignation</td>
                                    <td align="center" nowrap="nowrap" width="50%">Piece</td>
                                    <td align="center" width="1%"></td>
                                </tr>
                                </thead>
								
								
								
				<tr class="tr" style="display:none;">
                                <td> 
                                        <?php echo $this->Form->input('sup',array('name'=>'','id'=>'','champ'=>'sup','table'=>'Piecejointe','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('namepiecejointe_id',array('empty'=>'choix','div'=>'form-group','label'=>'', 'name' => '','table'=>'Piecejointe','index'=>'','id'=>'','champ'=>'namepiecejointe_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'') );?>
                                        <?php echo $this->Form->input('id',array('empty'=>'choix','div'=>'form-group','label'=>'', 'name' => '','table'=>'Piecejointe','index'=>'','id'=>'','champ'=>'id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','type'=>'hidden') );?>
                                </td>
                                <td>
                                        <?php echo $this->Form->input('piece',array('name' => '','table'=>'Piecejointe','index'=>'','id'=>'','champ'=>'piece','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control','type'=>'file','multiple'=>"true") ); ?>       
                                    
									
				</td>
                                   
                                    <td align="center"><i index=""  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>

                                     <?php foreach ($piecejointes as $i=>$piecejointe) {  ?>

                                <tr>
                                <td>
                                        <?php echo $this->Form->input('sup',array('name'=>'data[Piecejointe]['.$i.'][sup]','id'=>'sup'.$i,'champ'=>'sup','table'=>'Piecejointe','index'=>$i,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('id',array('value'=>$piecejointe['Piecejointe']['id'],'div'=>'form-group','label'=>'', 'name' => 'data[Piecejointe]['.$i.'][id]','table'=>'Piecejointe','index'=>$i,'id'=>'id','champ'=>'id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','type'=>'hidden') );?> 
			                <?php echo $this->Form->input('namepiecejointe_id',array('value'=>$piecejointe['Piecejointe']['namepiecejointe_id'],'div'=>'form-group','label'=>'', 'name' => 'data[Piecejointe]['.$i.'][namepiecejointe_id]','table'=>'Piecejointe','index'=>'0','id'=>'name','champ'=>'name','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                </td>
                                <td>
                                        <?php echo $this->Form->input('piece',array('type'=>'hidden','value'=>$piecejointe['Piecejointe']['piece'],'name' => 'data[Piecejointe]['.$i.'][piece]','table'=>'Piecejointe','index'=>'0','champ'=>'piece','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','class'=>'form-control') ); ?>       
                                <center>
                                    <a  onClick="flvFPW1(wr+'files/upload/<?php echo $piecejointe['Piecejointe']['piece'];?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><button class="btn btn-primary">Imprimer</button> </a>                   
				</center>	  
                                </td>
                                    <td align="center"><i index="<?php echo $i ; ?>"  class="fa fa-times supor" style="color: #c9302c;font-size: 22px;"></td>
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
                                    <a class="btn btn-danger ajouterligne_c" table='addtablec' index='indexc' style="
                                    float: right; 
                                    position: relative;
                                    top: -25px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter Situation</a>
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
                                
                                    <td align="center"><i index=""  class="fa fa-times supsituation" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <?php foreach ($situations as $s=>$situation) {  
                                $datedebut=date("d/m/Y",strtotime(str_replace('/','/',$situation['Situation']['datedebut'])));
                                $datefin=date("d/m/Y",strtotime(str_replace('/','/',$situation['Situation']['datefin'])));
                                ?>
                                <tr>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('supp',array('name'=>'data[Situation]['.$s.'][supp]','id'=>'supp'.$s,'champp'=>'sup','table'=>'Situation','index'=>$s,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('namesituation_id',array('value'=>@$situation['Situation']['namesituation_id'],'div'=>'form-group','label'=>'', 'name' => 'data[Situation]['.$s.'][namesituation_id]','table'=>'Situation','index'=>$s,'id'=>'namesituation_id'.$s,'champ'=>'namesituation_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','empty'=>'Veuillez choisir !!') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('datedebut',array('value'=>@$datedebut,'label'=>'','div'=>'form-group', 'name' => 'data[Situation]['.$s.'][datedebut]','table'=>'Situation','index'=>$s,'id'=>'datedebut'.$s,'champ'=>'datedebut','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control datePickerOnly','onblur'=>'nbrjour('.$s.')') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('datefin',array('value'=>@$datefin,'name'=>'data[Situation]['.$s.'][datefin]','id'=>'datefin'.$s,'table'=>'Situation','index'=>$s,'champ'=>'datefin','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control datePickerOnly','onblur'=>'nbrjour('.$s.')') );?>
                                    </td>
                                    <td style="width:24%">
                                        <?php echo $this->Form->input('nbrjour',array('value'=>@$situation['Situation']['nbrjour'],'name'=>'data[Situation]['.$s.'][nbrjour]','id'=>'nbrjour'.$s,'table'=>'Situation','index'=>$s,'champ'=>'nbrjour','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                   <td> <input type="radio" name="data[contactchoisi]" <?php if($situation_id==$situation['Situation']['id']){?> checked="checked"<?php }?> value="<?php echo @$s ; ?>" index="<?php echo @$s ; ?>"></td>
                                    <td align="center"><i index="<?php echo @$s ; ?>"  class="fa fa-times supsituation" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                        <?php } ?>
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo @$s ; ?>" id="indexc" />
</div>
                            </div>
                        </div>                
</div> 

<!-- ***********************************************************************************************-->


 <div class="remodal" style="width: 100%" data-remodal-id="reModal_refuser"  id="poppa">
                    <div id="importation_par_frs">
                      
                        
                    </div>
                    <br>
                   <a  class="remodal-confirm ls-light-green-btn btn" ><strong>OK</strong></a>
                    
               </div> 
                                 
                                    
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary testimportation">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

