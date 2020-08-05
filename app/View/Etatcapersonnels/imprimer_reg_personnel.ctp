<?php


$lborder = 'border="0"';
ob_start();
?>

<style>
.classtable {
  border-collapse: collapse;
}

.classtable td {
  border: 2px solid black;
}
</style>  
<?php
$societe=CakeSession::read('societe');
$ModelSociete = ClassRegistry::init('Societe');
$soc = $ModelSociete->find('first', array('conditions' => array('Societe.id' =>1)));
?>
<page backtop="60mm" backbottom="10mm" footer="page">
    <page_header style="margin-top: 0mm " >
        <table style="width: 100%;"  border="0">
            <tr>
                <td style="width: 80%;" align="left" >
                    <strong style="font-size:5mm;"><?php echo $soc['Societe']['nom'] ;?></strong> <br>
                    <table>
                        <tr>
                            <td align="left" width="70%" style="font-size:3mm;">
                                <strong><?php echo $soc['Societe']['activite'] ;?></strong><br>
                                <?php echo $soc['Societe']['adresse'] ;?><br>
                                <strong>M.F : </strong><?php echo $soc['Societe']['codetva'] ;?><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RC : </strong><?php echo $soc['Societe']['rc'] ;?><br> 
                                <strong>RIB : </strong><?php echo $soc['Societe']['rib'] ;?><br>
                                <strong>TEL/FAX : </strong><?php echo $soc['Societe']['tel'] ;?><br>   
                            </td>
                        </tr>
                    </table>
                </td>
                <td  style="width: 20%;" align="left">
                    <IMG SRC="../webroot/img/<?php echo $soc["Societe"]["logo"];?>" style="width: 100px;height:80px;" >
                </td>

            </tr>
        </table>
        
        <br>
    </page_header>
    <table cellspacing="0"  style="width: 100%;font-size: 3mm;border: 1px solid black;">
	<tr>
            <td style="width: 40%;border: 1px solid black;background-color:#b8b8b8;" class="actions" align="center">Personnel</td>
            <td style="width: 15%;border: 1px solid black;background-color:#b8b8b8;" class="actions" align="center">Espece</td>
            <td style="width: 15%;border: 1px solid black;background-color:#b8b8b8;" class="actions" align="center">Traite</td>
            <td style="width: 15%;border: 1px solid black;background-color:#b8b8b8;" class="actions" align="center">Cheque</td>
            <td style="width: 15%;border: 1px solid black;background-color:#b8b8b8;" class="actions" align="center">Virement</td>
        </tr>
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
                <td style="width: 40%;border: 1px solid black;"><?php echo $liste_personnel['Personnel']['name']; ?></td>
                <td style="width: 15%;border: 1px solid black;" align="right" ><strong><?php echo number_format($piece_espece,3, '.', ' ')  ; ?></strong></td>
                <td style="width: 15%;border: 1px solid black;" align="right" ><strong><?php echo number_format($piece_traite,3, '.', ' ')  ; ?></strong></td>
                <td style="width: 15%;border: 1px solid black;" align="right" ><strong><?php echo number_format($piece_cheque,3, '.', ' ')  ; ?></strong></td>
                <td style="width: 15%;border: 1px solid black;" align="right" ><strong><?php echo number_format($piece_virement,3, '.', ' ')  ; ?></strong></td>
            </tr>
        <?php } ?> 
            <tr>
                <td style="width: 40%;border: 1px solid black;" align="left"><strong>Total</strong></td>  
                <td style="width: 15%;border: 1px solid black;" align="right" ><strong><?php echo number_format($piece_espece_tot,3, '.', ' ')  ; ?></strong></td>
                <td style="width: 15%;border: 1px solid black;" align="right" ><strong><?php echo number_format($piece_traite_tot,3, '.', ' ')  ; ?></strong></td>
                <td style="width: 15%;border: 1px solid black;" align="right" ><strong><?php echo number_format($piece_cheque_tot,3, '.', ' ')  ; ?></strong></td>
                <td style="width: 15%;border: 1px solid black;" align="right" ><strong><?php echo number_format($piece_virement_tot,3, '.', ' ')  ; ?></strong></td>
            </tr>
            <tr>
                <td style="width: 40%;border: 1px solid black;"><strong>Total Général</strong></td>  
                <td style="width: 60%;border: 1px solid black;" colspan="4" align="center" ><strong><?php echo number_format($piece_espece_tot+$piece_traite_tot+$piece_cheque_tot+$piece_virement_tot,3, '.', ' ')  ; ?></strong></td>
            </tr>
	</table>    
</page>


<page_footer >
    
</page_footer>
 
<?php
$content = ob_get_clean();
APP::import("Vendor", "html2pdf/html2pdf");
try {
    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content);
    $html2pdf->Output('imprimer_reg_personnel.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>
        