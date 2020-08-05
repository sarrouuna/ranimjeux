<input type="hidden" id="index_kbira" value="<?php echo $index_kbira; ?>">
<table style="width: 100%;" >
<tr>
<td bgcolor="#F2D7D5" align="center" ><?php echo "Client :".$name; ?></td>
</tr>
<tr >
</table>

<div class="panel-body">
                          
<table style="width: 100%;">
    <td align="center"><input checked="checked" onclick="document.all.tabfac.style.display=document.all.tabfac.style.display=='none' ? '' : 'none'" class="aff_tabfac" type="checkbox" id="s6"  value="1"></td><td align="left">Factures</td><td align="left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td align="center"><input onclick="document.all.tabbl.style.display=document.all.tabbl.style.display=='none' ? '' : 'none'" class="aff_tabbl"  type="checkbox"  id="s7" value="1"></td><td align="left">BonLivraisons</td><td align="left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td align="center"><input onclick="document.all.tabcmd.style.display=document.all.tabcmd.style.display=='none' ? '' : 'none'" class="aff_tabcmd" type="checkbox" id="s8" value="1"></td><td align="left">Commandes</td><td align="left">&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td align="center"><input onclick="document.all.tabdv.style.display=document.all.tabdv.style.display=='none' ? '' : 'none'" class="aff_tabdv"  type="checkbox"  id="s9" value="1"></td><td align="left">Devis</td><td align="left">&nbsp;&nbsp;</td>
</tr>
</table>
</div>

<div class="panel-body" id="tabfac">
<table  style="width: 100%;" border="1" align="center" >
<tr>
<td colspan="8" bgcolor="#F2D7D5">Factures</td>
</tr>
<tr>
<td>id</td>
<td>Article</td>
<td>Qte</td>
<td>Prix</td>
<td>Remise</td>
<td>TOT_HT</td>
<td>TOT_TTC</td>
<td></td>
</tr>
    <?php
$nb=0;
//debug($lignefactures);
    foreach ($lignefactures as $lignefacture) { $nb=$nb+1; ?>
        <tr>
            <td ><?php echo $lignefacture['Lignefactureclient']['id']; ?></td>
            <td ><?php echo $lignefacture['Lignefactureclient']['designation']; ?></td>
            <td ><?php echo $lignefacture['Lignefactureclient']['quantite']; ?></td>
            <td >
                <?php echo $lignefacture['Lignefactureclient']['prix']; ?>
                <input type="hidden" id="prix_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['Lignefactureclient']['prix']; ?>">
                <input type="hidden" id="prixnet_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['Lignefactureclient']['prixnet']; ?>">
                <input type="hidden" id="puttc_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['Lignefactureclient']['puttc']; ?>">
                <input type="hidden" id="totalhtans_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['Lignefactureclient']['totalhtans']; ?>">
                <input type="hidden" id="remise_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['Lignefactureclient']['remise']; ?>">
                <input type="hidden" id="tva_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['Lignefactureclient']['tva']; ?>">
                <input type="hidden" id="totalht_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['Lignefactureclient']['totalht']; ?>">
                <input type="hidden" id="totalttc_ans<?php echo $nb; ?>" value="<?php echo $lignefacture['Lignefactureclient']['totalttc']; ?>">
            </td>
            <td ><?php echo $lignefacture['Lignefactureclient']['remise']; ?></td>
            <td ><?php echo $lignefacture['Lignefactureclient']['totalht']; ?></td>
            <td ><?php echo $lignefacture['Lignefactureclient']['totalttc']; ?></td>
            <td ><input href="#" type="radio" name="prix_select"  indexr="<?php echo $nb; ?>" onclick="changertout(<?php echo $nb; ?>)"></td>  
        </tr>
    <?php } ?>
</table>
</div>



<br><br>



<div class="panel-body" style="display:none" id="tabbl">
<table style="width: 100%;" border="1" align="center" >
<tr>
<td colspan="8" bgcolor="#F2D7D5">Bonlivraisons</td>
</tr>
<tr>
<td>id</td>
<td>Article</td>
<td>Qte</td>
<td>Prix</td>
<td>Remise</td>
<td>TOT_HT</td>
<td>TOT_TTC</td>
<td></td>
</tr>
    <?php
//debug($lignelivrisons);
    foreach ($lignelivrisons as $lignelivrison) { $nb=$nb+1; ?>
        <tr>
            <td ><?php echo $lignelivrison['Lignelivraison']['id']; ?></td>
            <td ><?php echo $lignelivrison['Lignelivraison']['designation']; ?></td>
            <td ><?php echo $lignelivrison['Lignelivraison']['quantite']; ?></td>
            <td ><?php echo $lignelivrison['Lignelivraison']['prix']; ?>
                <input type="hidden" id="prix_ans<?php echo $nb; ?>" value="<?php echo $lignelivrison['Lignelivraison']['prix']; ?>">
                <input type="hidden" id="prixnet_ans<?php echo $nb; ?>" value="<?php echo $lignelivrison['Lignelivraison']['prixnet']; ?>">
                <input type="hidden" id="puttc_ans<?php echo $nb; ?>" value="<?php echo $lignelivrison['Lignelivraison']['puttc']; ?>">
                <input type="hidden" id="totalhtans_ans<?php echo $nb; ?>" value="<?php echo $lignelivrison['Lignelivraison']['totalhtans']; ?>">
                <input type="hidden" id="remise_ans<?php echo $nb; ?>" value="<?php echo $lignelivrison['Lignelivraison']['remise']; ?>">
                <input type="hidden" id="tva_ans<?php echo $nb; ?>" value="<?php echo $lignelivrison['Lignelivraison']['tva']; ?>">
                <input type="hidden" id="totalht_ans<?php echo $nb; ?>" value="<?php echo $lignelivrison['Lignelivraison']['totalht']; ?>">
                <input type="hidden" id="totalttc_ans<?php echo $nb; ?>" value="<?php echo $lignelivrison['Lignelivraison']['totalttc']; ?>">
            </td>
            <td ><?php echo $lignelivrison['Lignelivraison']['remise']; ?></td>
            <td ><?php echo $lignelivrison['Lignelivraison']['totalht']; ?></td>
            <td ><?php echo $lignelivrison['Lignelivraison']['totalttc']; ?></td>
            <td ><input href="#" type="radio" name="prix_select"  indexr="<?php echo $nb; ?>" onclick="changertout(<?php echo $nb; ?>)"></td>  
        </tr>
    <?php } ?>
</table>
</div>




<br><br>



<div class="panel-body" style="display:none" id="tabcmd">
<table style="width: 100%;" border="1" align="center" >
<tr>
<td colspan="8" bgcolor="#F2D7D5">Commandes</td>
</tr>
<tr>
<td>id</td>
<td>Article</td>
<td>Qte</td>
<td>Prix</td>
<td>Remise</td>
<td>TOT_HT</td>
<td>TOT_TTC</td>
<td></td>
</tr>
    <?php
//debug($lignecommandes);
    foreach ($lignecommandes as $lignecommande) { $nb=$nb+1; ?>
        <tr>
            <td ><?php echo $lignecommande['Lignecommandeclient']['id']; ?></td>
            <td ><?php echo $lignecommande['Lignecommandeclient']['designation']; ?></td>
            <td ><?php echo $lignecommande['Lignecommandeclient']['quantite']; ?></td>
            <td ><?php echo $lignecommande['Lignecommandeclient']['prix']; ?>
                <input type="hidden" id="prix_ans<?php echo $nb; ?>" value="<?php echo $lignecommande['Lignecommandeclient']['prix']; ?>">
                <input type="hidden" id="prixnet_ans<?php echo $nb; ?>" value="<?php echo $lignecommande['Lignecommandeclient']['prixnet']; ?>">
                <input type="hidden" id="puttc_ans<?php echo $nb; ?>" value="<?php echo $lignecommande['Lignecommandeclient']['puttc']; ?>">
                <input type="hidden" id="totalhtans_ans<?php echo $nb; ?>" value="<?php echo $lignecommande['Lignecommandeclient']['totalhtans']; ?>">
                <input type="hidden" id="remise_ans<?php echo $nb; ?>" value="<?php echo $lignecommande['Lignecommandeclient']['remise']; ?>">
                <input type="hidden" id="tva_ans<?php echo $nb; ?>" value="<?php echo $lignecommande['Lignecommandeclient']['tva']; ?>">
                <input type="hidden" id="totalht_ans<?php echo $nb; ?>" value="<?php echo $lignecommande['Lignecommandeclient']['totalht']; ?>">
                <input type="hidden" id="totalttc_ans<?php echo $nb; ?>" value="<?php echo $lignecommande['Lignecommandeclient']['totalttc']; ?>">
            </td>

            <td ><?php echo $lignecommande['Lignecommandeclient']['remise']; ?></td>
            <td ><?php echo $lignecommande['Lignecommandeclient']['totalht']; ?></td>
            <td ><?php echo $lignecommande['Lignecommandeclient']['totalttc']; ?></td>
            <td ><input href="#" type="radio" name="prix_select"  indexr="<?php echo $nb; ?>" onclick="changertout(<?php echo $nb; ?>)"></td>  
        </tr>
    <?php } ?>
</table>
</div>





<br><br>



<div class="panel-body" style="display:none" id="tabdv">
<table style="width: 100%;" border="1" align="center" >
<tr>
<td colspan="8" bgcolor="#F2D7D5">Devis</td>
</tr>
<tr>
<td>id</td>
<td>Article</td>
<td>Qte</td>
<td>Prix</td>
<td>Remise</td>
<td>TOT_HT</td>
<td>TOT_TTC</td>
<td></td>
</tr>
    <?php
//debug($lignedevis);
    foreach ($lignedevis as $lignedevi) { $nb=$nb+1; ?>
        <tr>
            <td ><?php echo $lignedevi['Lignedevi']['id']; ?></td>
            <td ><?php echo $lignedevi['Lignedevi']['designation']; ?></td>
            <td ><?php echo $lignedevi['Lignedevi']['quantite']; ?></td>
            <td ><?php echo $lignedevi['Lignedevi']['prix']; ?>
                <input type="hidden" id="prix_ans<?php echo $nb; ?>" value="<?php echo $lignedevi['Lignedevi']['prix']; ?>">
                <input type="hidden" id="prixnet_ans<?php echo $nb; ?>" value="<?php echo $lignedevi['Lignedevi']['prixnet']; ?>">
                <input type="hidden" id="puttc_ans<?php echo $nb; ?>" value="<?php echo $lignedevi['Lignedevi']['puttc']; ?>">
                <input type="hidden" id="totalhtans_ans<?php echo $nb; ?>" value="<?php echo $lignedevi['Lignedevi']['totalhtans']; ?>">
                <input type="hidden" id="remise_ans<?php echo $nb; ?>" value="<?php echo $lignedevi['Lignedevi']['remise']; ?>">
                <input type="hidden" id="tva_ans<?php echo $nb; ?>" value="<?php echo $lignedevi['Lignedevi']['tva']; ?>">
                <input type="hidden" id="totalht_ans<?php echo $nb; ?>" value="<?php echo $lignedevi['Lignedevi']['totalht']; ?>">
                <input type="hidden" id="totalttc_ans<?php echo $nb; ?>" value="<?php echo $lignedevi['Lignedevi']['totalttc']; ?>">
            </td>
            <td ><?php echo $lignedevi['Lignedevi']['remise']; ?></td>
            <td ><?php echo $lignedevi['Lignedevi']['totalht']; ?></td>
            <td ><?php echo $lignedevi['Lignedevi']['totalttc']; ?></td>
            <td ><input href="#" type="radio" name="prix_select"  indexr="<?php echo $nb; ?>" onclick="changertout(<?php echo $nb; ?>)"></td>  
        </tr>
    <?php } ?>
</table>
</div>