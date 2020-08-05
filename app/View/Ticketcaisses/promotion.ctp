 <script type="text/javascript">

   function  test(){  
           ligne = 0;
           ligneqte = 0;
           var ttprix = 0;
           var ttqte = 0;
           var ttcmd = 0;

           maxart = $('#maxx<?php echo $this->params['pass'][1] ?>').val();
           for (i = 0; i <= maxart; i++)
           {
               prix = $('#prix<?php echo $this->params['pass'][1] ?>-' + i).val() || 0;
               qte = $('#qte<?php echo $this->params['pass'][1] ?>-' + i).val() || 0;
               cmd = $('#cmd<?php echo $this->params['pass'][1] ?>-' + i).val() || 0;
               //alert('prix ' + prix+' -- qte ' + qte +' ---  cmd ' + cmd);
               ttprix = ttprix + '**' + prix;
               ttqte = ttqte + '**' + qte;
               ttcmd = ttcmd + '**' + cmd;

               ligne = Number(ligne) + (Number(prix) * Number(qte) * Number(cmd));
               ligneqte = Number(ligneqte) + (Number(qte) * Number(cmd));
           }
           //alert( 'ligne '+ligne+' ligneqte '+ligneqte);
           $('#totprix<?php echo $this->params['pass'][1] ?>').val(ligne.toFixed(3));
           $('#totqte<?php echo $this->params['pass'][1] ?>').val(ligneqte);
           window.opener.ttprix<?php echo $this->params['pass'][1] ?>.value = ttprix;
           window.opener.ttqte<?php echo $this->params['pass'][1] ?>.value = ttqte;
           window.opener.ttcmd<?php echo $this->params['pass'][1] ?>.value = ttcmd;
           window.opener.qte<?php echo $this->params['pass'][1] ?>.setAttribute("readOnly", "true");
          
           window.opener.divprix<?php echo $this->params['pass'][1] ?>.innerText = '0.000'; 
           window.opener.divtotal<?php echo $this->params['pass'][1] ?>.innerText = ligne; 
           window.opener.qte<?php echo $this->params['pass'][1] ?>.value = ligneqte;
           window.opener.total<?php echo $this->params['pass'][1] ?>.value = Number(ligne).toFixed(3);
           window.opener.qte<?php echo $this->params['pass'][1] ?>.style.display = ligneqte;
           
           //window.opener.moin<?php echo $this->params['pass'][1] ?>.innerHTML = '<div   style="width:45px; height:35px ; padding-top:8px" ></div>'; 
           // window.opener.promo.innerHTML += '<div   id='' ></div>'; 
           
           window.opener.calcule();
           window.opener.plus<?php echo $this->params['pass'][1] ?>.innerHTML = '<a onClick="flvFPW1(\'' + wr + 'ticketcaisses/promotion/<?php echo $this->params['pass'][0] ?>/<?php echo $this->params['pass'][1] ?>/' + ttqte + '/' + ttprix + '/' + ttcmd + '\', \'UPLOAD\', \'width=500,height=450,scrollbars=yes\', 0, 2, 2 ); return document.MM_returnValue;" href=\'javascript:;\'  ><div   style="width:45px; height:35px ; padding-top:8px"  index=\'<?php echo $this->params['pass'][1] ?>\' class="   btn btn-xs btn-success">  <i class=\'glyphicon glyphicon-search\' >  </i></div></a> ';
           $ttr = window.opener.$('#td<?php echo $this->params['pass'][1] ?>').parent();
           window.opener.$($ttr).insertAfter(".th");
           //alert("1");
//           window.opener.inputcodebarre.style.display = 'yes';
//           $('#inputcodebarre').attr('disabled','disabled');
            //$('#select').hide();
            //$('#inputcodebarre').show();
           //alert("2");
           window.opener.$("#select").hide();
           //window.opener.select.style.display = 'none';
           //alert("3");
           window.opener.$("#inputcodebarre").show();
           //window.opener.inputcodebarre.style.display = 'yes';
           //alert("inputcodebarre");
           window.opener.nameart.focus();
           //console.log($ttr);
           window.close();

       }

           
           
    </script>
	<br /> 
    
    <?php
	
 
	 $ttprix= $this->params['pass'][3];
	$ttqte=$this->params['pass'][2];
	$ttcmd=$this->params['pass'][4];
	
	$artprix =explode('**',$ttprix);
	$artqte =explode('**',$ttqte);
	$artcmd =explode('**',$ttcmd);
	
	for ($i=1; $i<=count($artprix)-1 ; $i++)
	{
	 if(@$artcmd[$i] !='')
	@$cmd[$artprix[$i]]= $artcmd[$i]  ;
	else
	@$cmd[$artprix[$i]]=0 ;
 
	}
	
 
	?>
    
 
 
<table width="50%" style="padding-left:15px; padding-right:15px; text-align:center" align="center" border="1" cellpadding="2" cellspacing="2"  class="table">
<tr align="center">

    <td  width="25%" style="background-color: #900;color: #fff">&nbsp;Qt&eacute; / Lot </td>   
    
<p align="center"><font face="Arial, Helvetica, sans-serif" size="4"><b>Article : <?php echo ($Article[0]['Article']['name']);?><b></font></p>
<br /><div class="col-md-12">
          
          
           <div class="col-md-6">
                <div class="detailticketdata">
                    <div class="semidetailticketdata">
                        <ul class="ligneticketdata" id="commandlistitems"></ul>

<td  width="35%" style="background-color: #900;color: #fff">&nbsp; Prix / Unit&eacute;</td>
<td  width="35%" style="background-color: #900;color: #fff">&nbsp;Qt&eacute; Command&eacute;e</td>

</tr><?php   $p=0;?>
<tr>
 <input  type='hidden' name="data[Lignecommande][<?php echo $this->params['pass'][1]?>][Article][<?php echo $p;?>][id]" readonly="readonly" style="border:0px;width:75px; background-color:#f9f9f9; text-align:center"  value="<?php echo $this->params['pass'][0]?>" id="id<?php echo $this->params['pass'][1]?>-<?php echo $p;?>" class="form-control"   /> 
<td  width="25%" align="center"> <input  type='text' name="data[Lignecommande][<?php echo $this->params['pass'][1]?>][Article][<?php echo $p;?>][qte]" readonly="readonly" style="border:0px; background-color:#f9f9f9; text-align:center;width:75px"   value="1" id="qte<?php echo $this->params['pass'][1]?>-<?php echo $p;?>" class="form-control"    /> </td>
<td  width="35%" align="center"><input  type='text' name="data[Lignecommande][<?php echo $this->params['pass'][1]?>][Article][<?php echo $p;?>][prix]"  readonly="readonly"style="border:0px; background-color:#f9f9f9; text-align:center; width:75px" value="<?php echo $array[0]['Article']['prixuttc'];?>" id="prix<?php echo $this->params['pass'][1]?>-<?php echo $p;?>" class="form-control"    />  </td>
<td  width="35%" align="center"><input  type='text' name="data[Lignecommande][<?php echo $this->params['pass'][1]?>][Article][<?php echo $p;?>][cmd]"  value="<?php echo @$cmd [$array[0]['Article']['prixuttc']];?>" style="width:75px; text-align:center" id="cmd<?php echo $this->params['pass'][1]?>-<?php echo $p;?>" class="form-control"   /></td>

</tr>
 

<?php foreach($array as  $tab)
{ $p++;?> 
<tr>

<td  width="25%"> <input  name="data[Lignecommande][<?php echo $this->params['pass'][1]?>][Article][<?php echo $p;?>][qte]" type='text' readonly="readonly" style="border:0px; background-color:#f9f9f9; text-align:center"   value="<?php echo $tab['Promotion']['qte'];?>" id="qte<?php echo $this->params['pass'][1]?>-<?php echo $p;?>" class="form-control" style="width:75px"  /> </td>
<td  width="35%"><input    name="data[Lignecommande][<?php echo $this->params['pass'][1]?>][Article][<?php echo $p;?>][prix]"type='text' name=""  readonly="readonly"style="border:0px; background-color:#f9f9f9; text-align:center" value="<?php echo $tab['Promotion']['prix'];?>" id="prix<?php echo $this->params['pass'][1]?>-<?php echo $p;?>" class="form-control" style="width:75px"  />  </td>
<td  width="35%" align="center"><input   name="data[Lignecommande][<?php echo $this->params['pass'][1]?>][Article][<?php echo $p;?>][cmd]"type='text' name="" value="<?php echo  @$cmd [ $tab['Promotion']['prix']];?>" style="width:75px; text-align:center" id="cmd<?php echo $this->params['pass'][1]?>-<?php echo $p;?>" class="form-control"   /></td>

</tr>
 
<?php }?>

<input type='hidden' id="maxx<?php echo $this->params['pass'][1]?>" value="<?php echo $p;?>" class="form-control" style="width:75px"  />
<input type='hidden' id="totqte<?php echo $this->params['pass'][1]?>"  class="form-control" style="width:75px"  />
<input type='hidden' id="totprix<?php echo $this->params['pass'][1]?>" class="form-control" style="width:75px"  />
<input type='hidden' id="paiement_id<?php echo $this->params['pass'][1]?>" class="form-control" style="width:75px" value="-1-"  />
 

</table>
<br />
 
   <div align="center"><button    onclick='test()'style="height:55px; width:85px" class=" submitForm   "  id="butonsubmit"data-style="expand-right" data-size="l"  >Valider</button></div>
</div></div></div></div>