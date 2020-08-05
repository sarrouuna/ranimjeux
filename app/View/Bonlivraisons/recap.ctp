<style>
.scrollh tbody {
    overflow-y: scroll;
}   
.results tr[visible='false'],
.no-result{
  display:none;
}

.results tr[visible='true']{
 /* display:table-row;*/
}

.counter{
  padding:8px; 
  color:#000;
  margin-right: 50px;
}

.tablehohercolor>tbody>tr:hover>td, .tablehohercolor>tbody>tr:hover>th {
  background-color: #D98880;
  color:#eeeeee;
}
</style>



<input type="hidden" id="index_kbira" value="<?php echo $index_kbira; ?>">
<table style="width: 100%;" >
<tr>
    <td  align="left" style="width: 30%;">
        <div class="form-group pull-left">
            <input type="text" class="searchdes form-control" placeholder="recherche" onkeyup="searchdes()" style="background-color: white;">
</div>
<span class="counter pull-right"></span>
    </td>
    <td bgcolor="#F2D7D5" align="center" style="width: 40%;"><?php echo "Client :".$name; ?></td>
    <td  align="center" style="width: 30%;"></td>
</tr>
<tr >
</table>
<br>
<!--<div class="panel-body">
                          
<table style="width: 100%;">
    <td align="center"><input checked="checked" onclick="document.all.tabfac.style.display=document.all.tabfac.style.display=='none' ? '' : 'none'" class="aff_tabfac" type="checkbox" id="s6"  value="1"></td><td align="left">Factures</td><td align="left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td align="center"><input onclick="document.all.tabbl.style.display=document.all.tabbl.style.display=='none' ? '' : 'none'" class="aff_tabbl"  type="checkbox"  id="s7" value="1"></td><td align="left">BonLivraisons</td><td align="left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td align="center"><input onclick="document.all.tabcmd.style.display=document.all.tabcmd.style.display=='none' ? '' : 'none'" class="aff_tabcmd" type="checkbox" id="s8" value="1"></td><td align="left">Commandes</td><td align="left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td align="center"><input onclick="document.all.tabdv.style.display=document.all.tabdv.style.display=='none' ? '' : 'none'" class="aff_tabdv"  type="checkbox"  id="s9" value="1"></td><td align="left">Devis</td><td align="left">&nbsp;&nbsp;</td>
</tr>
</table>
</div>-->



<table class="table  table-hover table-bordered table-striped table-bottomless tablejdid scrollh results  tablehohercolor" id="ls-editable-table" style="width: 100%;" border="1" align="center" >
<thead>
<tr class="entetetab" style="background-color: #c6b9b9;">
<th width="4%" >Numéro</th>
<th width="7%">Date</th>
<th width="35%" >Article</th>
<th width="5%">Qte</th>
<th width="8%">Prix HT B</th>
<th width="5%">Remise</th>
<th width="8%">Prix HT Net</th>
<th width="8%">TOT_HT</th>
<th width="8%">TOT_TTC</th>
<!--<th width="1%"></th>-->
</tr>
</thead><tbody>
    <?php
    
    
$nb=0;
//debug($lignefactures);
    foreach ($lignefactures as $lignefacture) { $nb=$nb+1;
    
//    $cond_livrisons=' and lignelivraisons.article_id='. $ligne['tmp']['id'];
//    $cond_factures=' and lignefactureclients.article_id='. $ligne['tmp']['id'];
//    
//    $lignefacture = ClassRegistry::init('Bonlivraison')->query(
//        'SELECT  tmp.id ,tmp.name,tmp.code,tmp.coutrevient,tmp.quantite,tmp.prix,tmp.totalhtans,tmp.prixnet,tmp.remise,tmp.puttc,tmp.tva,tmp.totalht,tmp.totalttc,tmp.date,tmp.type
//        FROM (
//        (
//        SELECT   articles.id, articles.name ,articles.code,articles.coutrevient ,lignefactureclients.quantite ,lignefactureclients.prix,lignefactureclients.totalhtans
//        , lignefactureclients.prixnet, lignefactureclients.remise, lignefactureclients.puttc,lignefactureclients.tva
//        ,lignefactureclients.totalht ,lignefactureclients.totalttc ,factureclients.date ,"fac" type
//        FROM  `lignefactureclients`,factureclients,articles
//        where   lignefactureclients.factureclient_id=factureclients.id
//        and lignefactureclients.article_id=articles.id  
//        and factureclients.client_id='.$clientid.' 
//        ' . @$cond_factures . ' 
//        ORDER BY factureclients.date desc
//        )
//        UNION (
//        SELECT   articles.id, articles.name ,articles.code,articles.coutrevient ,lignelivraisons.quantite ,lignelivraisons.prix,lignelivraisons.totalhtans
//        , lignelivraisons.prixnet, lignelivraisons.remise, lignelivraisons.puttc,lignelivraisons.tva
//        ,lignelivraisons.totalht ,lignelivraisons.totalttc ,bonlivraisons.date ,"bl" type
//        FROM `lignelivraisons`, bonlivraisons, articles
//        where lignelivraisons.bonlivraison_id = bonlivraisons.id
//        and lignelivraisons.article_id = articles.id
//        and bonlivraisons.client_id='.$clientid.' 
//        ' . @$cond_livrisons . '
//        ORDER BY bonlivraisons.date desc
//        )
//        )tmp
//        ORDER BY tmp.date desc
//        limit 1
//        ');
    //debug($lignefactures);
    
    if(empty($lignefacture['tmp']['coutrevient'])){
    $lignefacture['tmp']['coutrevient']=0;    
    }
    $lignefacture['tmp']['prixnet']=sprintf('%.3f',$lignefacture['tmp']['prix']*(1-($lignefacture['tmp']['remise']/100)));
    if(empty($lignefacture['tmp']['prixnet'])){
    $lignefacture['tmp']['prixnet']=0;    
    }
    if($lignefacture['tmp']['coutrevient']!=0){
    $marge=(($lignefacture['tmp']['prixnet']-$lignefacture['tmp']['coutrevient'])/$lignefacture['tmp']['coutrevient'])*100;
    }else{
    $marge=100;    
    }
    
    
    ?>
    <tr <?php if ((($lignefacture['tmp']['composee']==0)&&(substr($lignefacture['tmp']['code'],0,3)!="Grp"))||(($lignefacture['tmp']['composee']==1)&&(ereg("FLEXIBLE",str_replace("'", '1*2*2*1*2',str_replace('"', '1*2**1*2', $lignefacture['tmp']['name'])))==false)) ) {?>  ondblclick="changertout(<?php echo $nb; ?>)"  <?php } ?>>
            <td width="4%" align="left"><?php echo $lignefacture['tmp']['type']; ?></td>
            <td width="7%" align="center"><?php echo $lignefacture['tmp']['date']; ?></td>
            <td width="35%" align="left"><?php echo $lignefacture['tmp']['code']." ".$lignefacture['tmp']['name']; ?></td>
            <td width="5%" align="center"><?php echo $lignefacture['tmp']['quantite']; ?></td>
            <td width="8%" align="right">
                <?php echo $lignefacture['tmp']['prix']; ?>
                <input type="hidden" id="id_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['tmp']['id']; ?>">
                <input type="hidden" id="code_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['tmp']['code']; ?>">
                <input type="hidden" id="name_ans<?php echo $nb; ?>" value="<?php echo str_replace("'", '1*2*2*1*2',str_replace('"', '1*2**1*2', $lignefacture['tmp']['name'])); ?>">
                <input type="hidden" id="coutrevient<?php echo $nb; ?>" value="<?php echo $lignefacture['tmp']['coutrevient']; ?>">
                <input type="hidden" id="marge<?php echo $nb; ?>" value="<?php echo $marge; ?>">
                <input type="hidden" id="quantite_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['tmp']['quantite']; ?>">
                <input type="hidden" id="prix_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['tmp']['prix']; ?>">
                <input type="hidden" id="prixnet_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['tmp']['prixnet']; ?>">
                <input type="hidden" id="puttc_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['tmp']['puttc']; ?>">
                <input type="hidden" id="totalhtans_ans<?php echo $nb; ?>" value="<?php echo @$lignefacture['tmp']['totalhtans']; ?>">
                <input type="hidden" id="remise_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['tmp']['remise']; ?>">
                <input type="hidden" id="tva_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['tmp']['tva']; ?>">
                <input type="hidden" id="totalht_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['tmp']['totalht']; ?>">
                <input type="hidden" id="totalttc_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['tmp']['totalttc']; ?>">
                <input type="hidden" id="composee_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['tmp']['composee']; ?>">
            </td>
            <td width="5%" align="center"><?php echo sprintf('%.2f',$lignefacture['tmp']['remise']); ?></td>
            <td width="8%" align="right"><?php echo $lignefacture['tmp']['prixnet']; ?></td>
            <td width="8%" align="right"><?php echo $lignefacture['tmp']['totalht']; ?></td>
            <td width="8%" align="right"><?php echo $lignefacture['tmp']['totalttc']; ?></td>
<!--            <td width="1%" align="center"><input href="#" type="radio" name="prix_select" class="remodal-closeradio" indexr="<?php echo $nb; ?>" onclick="changertout(<?php echo $nb; ?>)"></td>  -->
        </tr>
    <?php } ?>
   </tbody>  
</table>



<script>

  function searchdes () {
    var searchTerm = $(".searchdes").val();//alert(searchTerm);
    var listItem = $('.results tbody').children('tr');
    var searchSplit = searchTerm.replace(/ /g, "'):containsi('")
    
  $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
        return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
  });
    
  $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','false');
  });

  $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','true');
  });

  var jobCount = $('.results tbody tr[visible="true"]').length;
    $('.counter').text(jobCount + ' Articles');

  if(jobCount == '0') {$('.no-result').show();}
    else {$('.no-result').hide();}
		 
              }
</script>
