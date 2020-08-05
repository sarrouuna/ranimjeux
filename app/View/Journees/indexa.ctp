


<script language="javascript">


    function flvFPW1(){

        var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16;v11=new Array("width,left,"+v4,"height,top,"+v5);for (i=0;i<v11.length;i++){v12=v11[i].split(",");l_iTarget=parseInt(v12[2]);if (l_iTarget>1||v1[2].indexOf("%")>-1){v13=eval("screen."+v12[0]);for (v6=0;v6<v2.length;v6++){v10=v2[v6].split("=");if (v10[0]==v12[0]){v14=parseInt(v10[1]);if (v10[1].indexOf("%")>-1){v14=(v14/100)*v13;v2[v6]=v12[0]+"="+v14;}}if (v10[0]==v12[1]){v16=parseInt(v10[1]);v15=v6;}}if (l_iTarget==2){v7=(v13-v14)/2;v15=v2.length;}else if (l_iTarget==3){v7=v13-v14-v16;}v2[v15]=v12[1]+"="+v7;}}v8=v2.join(",");v9=window.open(v1[0],v1[1],v8);if (v3){v9.focus();}document.MM_returnValue=false;return v9;

    } 
 </script>

<div class="table">
    <div class="head"><h5 class="iFrames"><?php echo __('Journees');?></h5></div>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
            <tr>
                                    <th style="display:none">id</th>
                                    <th>Depot</th>
                                    <th  >Journee</th>
                                    <th  >Etat</th>
                                    <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
	foreach ($journees as $journee): ?>
<tr class='gradeX'>                                    <th style="display:none">id</th>

		<td align="center"  ><?php echo h($journee['Depot']['Nom']); ?></td>
		<td align="center"  ><?php echo  ($journee['Journee']['date_debut']) ; ?></td>
	     <th  ><?php if($journee['Journee']['etat']==0) {?> Journée Ouverte <?php } else {?>Journée Clôturée<?php }?></th>
	<td class="actions" align="center">
			<?php echo $this->Html->link($this->Html->image('consult.png'), array('action' => 'view', $journee['Journee']['id']),array('escape' => false)); ?>
            <?php if($journee['Journee']['etat']==0) {?>	<?php echo $this->Html->link($this->Html->image('modification.png'), array('action' => 'edit', $journee['Journee']['id']),array('escape' => false)); ?><?php }?>
	  	 <a onClick="flvFPW1('<?php echo $this->webroot;?>journees/imprimer/<?php echo $journee['Journee']['id']; ?>','UPLOAD','width=800,height=1150,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" ><?php echo  $this->Html->image('imprimer.png')?></a>
          
 		 
		</td>
	</tr>
<?php endforeach; ?>
 </tbody>        <tfoot>
      <tr>

                                    <th>Designation</th>
                                  
            </tr>
 </tfoot>
    </table>
</div>
