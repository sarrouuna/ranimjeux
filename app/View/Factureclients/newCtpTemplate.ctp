<table cellspacing="0"  style="width: 100%; margin: 1mm;font-size: 3mm;">
        <tr>
            <td align="center" style="width: 32.8%;border: 1px solid black;"   height="10px">CACHET ET SIGNATURE</td>
            <td align="center" style="width: 29.2%;border: 1px solid black;" >
                <table  style="width: 100%;">
                    <tr>
                        <td align="center" style="width: 40%;border-left:none;border-right:1px solid black;border-bottom: none;border-top: none;" >ASSIETTE</td>  
                        <td align="center" style="width: 20%;border-left:none;border-right:1px solid black;border-bottom: none;border-top: none;" >TAUX</td>  
                        <td align="center" style="width: 40%;">MONT. TVA</td>  
                    </tr>
                </table>
            </td>
            <td align="left" style="width: 38%;border: 1px solid black;">
                <table style="width: 100%;">
                    <tr>
                        <td align="left" style="width: 50%;">TOTAL H.T :</td>
                        <td align="right" style="width: 50%;"><?php echo number_format($factureclient[$model]['totalht'] + $factureclient[$model]['remise'], 3, '.', ' '); ?>&nbsp;&nbsp;</td>
                    </tr>
                </table>
            </td>  
        </tr>     
        <tr>
            <td align="center" style="width: 32.8%;border: 1px solid black;"   height="120px"></td>
            <td align="right" style="width: 29.2%;border: 1px solid black;">
                <table style="width: 100%;">
                    <?php
                    $obj = ClassRegistry::init($ligne_model);
                    $lignefactureclientstva = $obj->find('all', array('fields' => array(
                            'SUM((' . $ligne_model . '.totalht*' . $ligne_model . '.tva)/100)  mtva'
                            , 'SUM(' . $ligne_model . '.totalht) totalht'
                            , 'AVG(' . $ligne_model . '.tva) tva'),
                        'conditions' => array($ligne_model . '.' . $attribut => $factureclient[$model]['id'])
                        , 'group' => array($ligne_model . '.tva')
                    ));
                    $tva = 0;
                    foreach ($lignefactureclientstva as $i => $lr) {
                        if (!empty($lr[0]['mtva'])) {
                            $hauteurtva = 20 - 2;
                            ?>
                            <tr>
                                <td align="right" style="border-left:none;border-right:1px solid black;border-bottom: none;border-top: none;width: 40%;"  ><?php echo number_format($lr[0]['totalht'], 3, '.', ' '); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>  
                                <td align="center" style="border-left:none;border-right:1px solid black;border-bottom: none;border-top: none;width: 20%;"><?php echo sprintf('%.0f', $lr[0]['tva']); ?> %</td>  
                                <td align="right"  style="width: 40%;"><?php echo number_format($lr[0]['mtva'], 3, '.', ' '); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                        <?php }
                    } ?>
                    <tr>
                        <td  style="height:<?php echo $hauteurtva; ?>mm;border-left:none;border-right:1px solid black;border-bottom: none;border-top: none;"></td>
                        <td style="border-left:none;border-right:1px solid black;border-bottom: none;border-top: none;"></td>
                        <td></td>
                    </tr>    
                </table>
            </td>
            <td align="left" style="width: 38%;border: 1px solid black;">
                <table  style="width: 100%;" align="left" >
                    <tr>
                        <td height="24px" align="left">REMISE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                        <td  align="right"><?php echo number_format($factureclient[$model]['remise'], 3, '.', ' '); ?></td>
                    </tr>
                    <tr>
                        <td height="24px" align="left">NET H.TVA&nbsp;&nbsp;:</td>
                        <td align="right"><?php echo number_format($factureclient[$model]['totalht'], 3, '.', ' '); ?></td>
                    </tr>
                    <tr >
                        <td height="24px" align="left">TOTAL TVA  :</td>
                        <td align="right"><?php echo number_format($factureclient[$model]['tva'], 3, '.', ' '); ?></td>
                    </tr>
                    <tr>
                        <td height="24px" align="left">TIMBRE FIS&nbsp;:</td>
                        <td align="right"><?php echo number_format($factureclient[$model]['timbre_id'], 3, '.', ' '); ?></td>
                    </tr>
                    <tr>
                        <td style="border-left:none;border-right:none;border-bottom: none;border-top:none;"  align="left"><strong style="font-size:10;">NET T.T.C</strong></td>
                        <td style="border-left:none;border-right:none;border-bottom: none;border-top:none;" align="right"><strong style="font-size:10;"><?php echo number_format($factureclient[$model]['totalttc'], 3, '.', ' '); ?></strong></td>
                    </tr>
                </table>
            </td>  
        </tr> 
        <tr>
            <td colspan="3" style="width: 100%;vertical-align: top;">
                <strong style="font-size:5mm;margin-left: 20mm;">Arreter la présente Facture Client à  la somme de :</strong><br>
                <strong style="font-size:4mm;margin-left: 15mm;"><?php echo chifre_en_lettre($factureclient[$model]['totalttc'], 1, 1); ?></strong>
            </td>           
        </tr>
        <tr>
            <td colspan="3" style="height: 30mm;" ></td>
        </tr>


    </table>










 <table cellspacing="0"  style="width: 100%; margin: 1mm;font-size: 3mm;border: 1px solid black;border-collapse: collapse;">
        <tr>
            <td style="width: 32.8%;border: 1px solid black;">
            <table   style="width: 100%;border: 1px solid black;border-collapse: collapse;">    
            <tr>
            <td align="center" style="width: 100%;height:5mm;border: 1px solid black;">CACHET ET SIGNATURE</td>
            </tr>
            <tr>
            <td align="center" style="width: 100%;height:20mm;border: 1px solid black;"></td>    
            </tr>
            </table>
            </td>
            
            
            
            
            <td style="width: 29.2%;border: 1px solid black;">
            <table  style="width: 100%;border: 1px solid black;border-collapse: collapse;">
                    <tr>
                        <td align="center" style="height:5mm;width: 40%;border: 1px solid black;" >ASSIETTE</td>  
                        <td align="center" style="width: 20%;border: 1px solid black;" >TAUX</td>  
                        <td align="center" style="width: 40%;border: 1px solid black;">MONT. TVA</td>  
                    </tr>
                    <?php
                    $obj = ClassRegistry::init($ligne_model);
                    $lignefactureclientstva = $obj->find('all', array('fields' => array(
                            'SUM((' . $ligne_model . '.totalht*' . $ligne_model . '.tva)/100)  mtva'
                            , 'SUM(' . $ligne_model . '.totalht) totalht'
                            , 'AVG(' . $ligne_model . '.tva) tva'),
                        'conditions' => array($ligne_model . '.' . $attribut => $factureclient[$model]['id'])
                        , 'group' => array($ligne_model . '.tva')
                    ));
                    $tva = 0;
                    foreach ($lignefactureclientstva as $i => $lr) {
                        if (!empty($lr[0]['mtva'])) {
                            $hauteurtva = 20 - 2;
                            ?>
                            <tr>
                                <td align="right" style="border-left:none;border-right:1px solid black;border-bottom: none;border-top: none;width: 40%;"  ><?php echo number_format($lr[0]['totalht'], 3, '.', ' '); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>  
                                <td align="center" style="border-left:none;border-right:1px solid black;border-bottom: none;border-top: none;width: 20%;"><?php echo sprintf('%.0f', $lr[0]['tva']); ?> %</td>  
                                <td align="right"  style="width: 40%;"><?php echo number_format($lr[0]['mtva'], 3, '.', ' '); ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                        <?php }
                    } ?>
                    <tr>
                        <td  style="height:<?php echo $hauteurtva; ?>mm;border-left:none;border-right:1px solid black;border-bottom: none;border-top: none;"></td>
                        <td style="border-left:none;border-right:1px solid black;border-bottom: none;border-top: none;"></td>
                        <td></td>
                    </tr>
            </table>    
            </td>
            
            
            
            
            
            
            
            <td style="width: 38%;border: 1px solid black;"></td>
        </tr>
        <tr>
            <td colspan="3" style="height: 30mm;" ></td>
        </tr>


    </table>