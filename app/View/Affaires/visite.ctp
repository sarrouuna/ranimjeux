<script language="JavaScript">

function flvFPW1(){

var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

}

</script>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo $this->webroot;?>Affaires/index"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                   
                                </div>
                                <div class="panel-body">
        <?php echo $this->Form->create('Affaire',array('enctype' => 'multipart/form-data','autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>

         <div class="row ligne" >
                        
                        <div class="col-md-12" >
                            <div class="panel panel-default" >
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Programme Visite'); ?></h3>
                                    
                                </div>
                                <div class="panel-body">
                                <table class="table table-bordered table-striped table-bottomless" id="addtablec" style="width:100%" align="center" >
                                <thead>
                                <tr>
                                    <td align="center" nowrap="nowrap">Personnel</td>
                                    <td align="center" nowrap="nowrap">Date </td>
                                    <td align="center" nowrap="nowrap">Lieu</td>
                                    <td align="center" nowrap="nowrap">Note</td>
                                    <td align="center"></td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="tr" style="display:none;">
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('supp',array('name'=>'','id'=>'','champ'=>'supp','table'=>'Visite','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('id',array('name'=>'','id'=>'','champ'=>'id','table'=>'Visite','index'=>'','div'=>'form-group','between'=>'<div class="col-sm-10">','after'=>'</div>','type'=>'hidden','class'=>'form','label'=>'') );?>
                                        <?php echo $this->Form->input('personnel_id',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Visite','index'=>'','id'=>'','champ'=>'personnel_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'','empty'=>'Veuillez Choisir !!') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('date',array('type'=>'text','div'=>'form-group','label'=>'', 'name' => '','table'=>'Visite','index'=>'','id'=>'','champ'=>'date','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('lieu',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Visite','index'=>'','id'=>'','champ'=>'lieu','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:24%">
                                        <?php echo $this->Form->input('note',array('div'=>'form-group','label'=>'', 'name' => '','table'=>'Visite','index'=>'','id'=>'','champ'=>'note','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control ') );?>
                                    </td>
                                
                                    <td align="center"><i index=""  class="fa fa-times supsituation" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <?php 
                                if(!empty($toutvisites)){
                                foreach ($toutvisites as $s=>$situation) {  
                                $date=date("d/m/Y",strtotime(str_replace('/','/',$situation['Visite']['date'])));
                                ?>
                                <tr>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('supp',array('name'=>'data[Visite]['.$s.'][supp]','id'=>'supp'.$s,'champp'=>'sup','table'=>'Visite','index'=>$s,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('id',array('value'=>@$situation['Visite']['id'],'name'=>'data[Visite]['.$s.'][id]','id'=>'id'.$s,'champp'=>'id','table'=>'Visite','index'=>$s,'div'=>'form-group','between'=>'<div class="col-sm-10">','type'=>'hidden','after'=>'</div>','class'=>'form-control','label'=>'Nom') );?>
                                        <?php echo $this->Form->input('personnel_id',array('value'=>@$situation['Visite']['personnel_id'],'div'=>'form-group','label'=>'', 'name' => 'data[Visite]['.$s.'][personnel_id]','table'=>'Visite','index'=>$s,'id'=>'personnel_id'.$s,'champ'=>'personnel_id','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control','empty'=>'Veuillez choisir !!') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('date',array('type'=>'text','value'=>@$date,'label'=>'','div'=>'form-group', 'name' => 'data[Visite]['.$s.'][date]','table'=>'Visite','index'=>$s,'id'=>'date'.$s,'champ'=>'date','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control datePickerOnly') );?>
                                    </td>
                                    <td style="width:25%">
                                        <?php echo $this->Form->input('lieu',array('value'=>@$situation['Visite']['lieu'],'name'=>'data[Visite]['.$s.'][lieu]','id'=>'lieu'.$s,'table'=>'Visite','index'=>$s,'champ'=>'lieu','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td style="width:24%">
                                        <?php echo $this->Form->input('note',array('value'=>@$situation['Visite']['note'],'name'=>'data[Visite]['.$s.'][note]','id'=>'note'.$s,'table'=>'Visite','index'=>$s,'champ'=>'note','label'=>'','div'=>'form-group','between'=>'<div class="col-sm-12">','after'=>'</div>','class'=>'form-control') );?>
                                    </td>
                                    <td align="center"><i index="<?php echo @$s ; ?>"  class="fa fa-times supsituation" style="color: #c9302c;font-size: 22px;"></td>
                                </tr>
                                <?php }} ?>
                                </tbody>
                                </table>
              	<input type="hidden" value="<?php echo @$s ; ?>" id="indexc" />
</div>
                                <a class="btn btn-danger ajouterligne_c" table='addtablec' index='indexc' style="
                                    float: lfet; 
                                    position: relative; 
                                    top: 0px;
                                "><i class="fa fa-plus-circle"  ></i> Ajouter Visite</a>
                            </div>
                        </div>                
</div>                
                                    
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </div>
<?php echo $this->Form->end();?>
</div>
                            </div>
                        </div>
</div>

