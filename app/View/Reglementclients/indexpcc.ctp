<script language="JavaScript">
function flvFPW1(){
var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;
}
</script>
 <?php $add="";$edit="";$delete="";$imprimer=""; 
$lien=  CakeSession::read('lien_vente');
foreach($lien as $k=>$liens){
    //debug($liens);die;
	if(@$liens['lien']=='piecereglementclients'){
		//$add=$liens['add'];
		//$edit=$liens['edit'];
		//$delete=$liens['delete'];
		$imprimer=$liens['imprimer'];
	}

  
}
//if($add==1){
//    
//}
?>
<br><input type="hidden" id="page" value="1"/>
<div class="row">    
            <?php echo $this->Form->create('Piecereglementclient',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo __('Engagement client'); ?></h3>
                                </div>
                                <div class="panel-body">
                                    <input type="hidden" id="date" value="<?php echo date('d/m/Y');?>"/>
                                    <div class="ls-editable-table table-responsive ls-table">
                                        <center><button type="submit" class="btn btn-primary">Validé</button></center>      
                  <table class="table table-bordered table-striped table-bottomless" id="">
                      <thead>
	<tr  bgcolor="#EAEAEA">
		<td style="display: none;" ><?php echo 'Echéance'; ?></td>
                <td width="10%"> <?php echo 'Personnel'; ?></td>
                <td align="center" width="10%"><?php echo 'Paiement'; ?></td>
		<td align="center" width="23%"><?php echo 'Client'; ?></td>
                <td align="center" width="15%"><?php echo 'Numéro'; ?></td>
                <td align="center" width="10%"><?php echo 'Encaissement'; ?></td>
		<td align="center" width="10%"><?php echo 'Echéance'; ?></td>
		<td align="center" width="10%"><?php echo 'Montant'; ?></td>
                <td align="center" width="7%"><?php echo 'Situation'; ?></td>
        </tr></thead><tbody>
	<?php //debug($piecereglementclients);die;
        //sort($piecereglementclients);
        $tot=0;
         foreach ($piecereglementclients as $k=>$piece):
             $obj = ClassRegistry::init('Utilisateur');
        $utilisateur = $obj->find('first', array('conditions' => array('Utilisateur.id' => $piece['Reglementclient']['utilisateur_id']), 'recursive' => 0));  //debug($piecesreg);die;
             $tot=$tot+$piece['Piecereglementclient']['montant'];
            // debug($piecereglement);die;
         if(($piece['Piecereglementclient']['echance'] =="1970-01-01")) {
         $date=""; 
         }else{
         if(($piece['Piecereglementclient']['echance'] =="")) {
         $date="";   
         }else{
          $date=date("d/m/Y",strtotime(str_replace('-','/',($piece['Piecereglementclient']['echance']))));   
         }} 
         
         if($piece['Piecereglementclient']['situation'] =="On caissé"){
         $piece['Piecereglementclient']['situation']="Encaissé";
         }
             ?>
	<tr>
                
		<td style="display: none;" aria-sort="ascending" class="sorting_asc" aria-controls="ls-editable-table"><?php echo $piece['Piecereglementclient']['echance']; ?></td>
                <td><?php echo $utilisateur['Personnel']['name']; ?></td>
                <td><?php echo $piece['Paiement']['name']; ?></td>
                <td><?php echo $clients[$piece['Reglementclient']['client_id']]; ?></td>
                <td><?php echo $piece['Piecereglementclient']['num']; ?></td>
                <td><?php echo h(date("d/m/Y",strtotime(str_replace('-','/',($piece['Reglementclient']['Date']))))); ?></td>
                <td><?php echo $date; ?></td>
                <td align='center'><?php echo number_format($piece['Piecereglementclient']['montant'],3, '.', ' '); ?></td>
                <td align='center'><?php echo $piece['Piecereglementclient']['situation']; ?>
                    <input name="data[Piecereglementclient][chec_piece_id][<?php echo $k ;?>]"  type="hidden" id="chec_piece_id<?php echo $k ;?>" value="<?php echo $piece['Piecereglementclient']['id']?>" montant="<?php echo $piece['Piecereglementclient']['montant']?>" >   
                </td>
               
	</tr>
        
<?php endforeach; ?>
        <tr>
            <td align="center" colspan="6">Total</td>
            <td align="center">
            <?php echo number_format($tot,3, '.', ' ') ; ?>    
            </td>
        </tr>
                          </tbody>
	</table>
            <input name="data[Piecereglementclient][index]" value="<?php echo $k ;?>" type="hidden">      
<?php echo $this->Form->end();?>	
                                </div></div></div></div></div>	


