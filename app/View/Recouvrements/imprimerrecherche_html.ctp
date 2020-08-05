<title>Recouvrement Client</title>
<style>
table.myFormat tr td { font-size: 12px; } 
table.myFormat tr th { font-size: 12px; } 
</style>  
<table border="1" style="border:2px solid black;width:100%;border-collapse:collapse;" class='myFormat'>
      
                            <tr><td colspan="9" style="height: 10px;" ></td></tr>                          
                            <?php if (!empty($date1) || !empty($date2)) { ?>                     
                                <tr>
                                    <td style="background-color: #F2D7D5;" align="center"><strong> Période </strong></td>    <td colspan="4" bgcolor="#F2D7D5" align="center"><strong><?php echo date("d/m/Y", strtotime(str_replace('-', '/', @$date1))); ?></strong></td><td align="center" colspan="4" bgcolor="#F2D7D5" ><strong><?php echo date("d/m/Y", strtotime(str_replace('-', '/', @$date2))); ?></strong></td>
                                </tr>
                                
                                    <tr><td colspan="9" style="height: 10px;" ></td></tr>
                                    <!--**************************************************************************************************************-->    
                                <?php } ?>
                                <?php if (!empty($name)) { ?>                     
                                    <tr>
                                        <td style="background-color: #F2D7D5;" align="center"><strong> Agent </strong></td>    <td colspan="8" bgcolor="#F2D7D5" ><strong><?php echo @$name; ?></strong></td>
                                    </tr><strong>
                                        <tr><td colspan="9" style="height: 10px;" ></td></tr>
                                        <!--**************************************************************************************************************-->    
                                    <?php } ?>
                                    <tr style="border:1px solid black;" class="tdreleveclient">

                                        <th  style="border:1px solid black;width: 5%;" bgcolor="#F2D7D5" ><strong><center>Date</center></strong></th>
                                        <th  style="border:1px solid black;width: 5%;" bgcolor="#F2D7D5"><strong><center>N° Piece</center></strong></th>
                                        <th  style="border:1px solid black;width: 50%;" bgcolor="#F2D7D5" ><strong><center>Libellé Piece</center></strong></th>
                                        <th  style="border:1px solid black;width: 7%;" bgcolor="#F2D7D5" ><strong><center>Dédit</center></strong></th>
                                        <th  style="border:1px solid black;width: 7%;" bgcolor="#F2D7D5" ><strong><center>Crédit</center></strong></th>
                                        <th  style="border:1px solid black;width: 7%;" bgcolor="#F2D7D5" ><strong><center>Impayé</center></strong></th>
                                        <th  style="border:1px solid black;width: 7%;" bgcolor="#F2D7D5" ><strong><center>Règlement</center></strong></th>
                                        <th  style="border:1px solid black;width: 5%;" bgcolor="#F2D7D5" ><strong><center>Avoir</center></strong></th>
                                        <th  style="border:1px solid black;width: 7%;" bgcolor="#F2D7D5" ><strong><center>Solde</center></strong></th>
                                    </tr>
                                    <tr><td colspan="9" style="height: 10px;" ></td></tr> </thead><tbody>





                                        <?php
                                        //debug($lignecommandes);
                                        $totdebit = 0;
                                        $totcredit = 0;
                                        $totimpayer = 0;
                                        $totreg = 0;
                                        $totavoir = 0;
                                        $totsolde = 0;
                                        $totdebitt = 0;
                                        $totcreditt = 0;
                                        $totimpayert = 0;
                                        $totregt = 0;
                                        $totavoirt = 0;
                                        $totsoldet = 0;
                                        $clt_id = 0;
                                        $sldtot = 0;
                                        $sldd = 0;
                                        $sld = 0;
                                        //$sld=$soldeint;
                                        foreach ($relefes as $i => $relefe) {
                                            //$sldd=0;    
                                            //$sld=0;
                                            $totdebitt = $totdebitt + @$relefe['Recouvrement']['debit'];
                                            $totcreditt = $totcreditt + @$relefe['Recouvrement']['credit'];
                                            $totimpayert = $totimpayert + @$relefe['Recouvrement']['impaye'];
                                            $totregt = $totregt + @$relefe['Recouvrement']['reglement'];
                                            $totavoirt = $totavoirt + @$relefe['Recouvrement']['avoir'];
                                            $totsoldet = $totsoldet + @$relefe['Recouvrement']['solde'];
                                            ?>




                                            <?php if ($relefe['Client']['id'] != $clt_id) { 
                                            $client_ans = ClassRegistry::init('Client')->find('first', array('conditions' => array('Client.id' =>$clt_id), 'recursive' => 0));
                                            ?>
                                                <?php if ($i != 0) {
                                                    ?>
                                                    <tr><td colspan="9" style="height: 10px;" ></td></tr>
                                                    <tr>
                                                        <td colspan="3" style="background-color: #F2D7D5;" align="center"><strong> Total <?php echo @$client_ans['Client']['code'] . "  " . @$client_ans['Client']['name']; ?>  </strong></td>    
                                                        <td  align="right"><strong><?php echo number_format(@$totdebit, 3, '.', ' '); ?></strong></td>
                                                        <td  align="right"><strong><?php echo number_format(@$totcredit, 3, '.', ' '); ?></strong></td>
                                                        <td  align="right"><strong><?php echo number_format(@$totimpayer, 3, '.', ' '); ?></strong></td>
                                                        <td  align="right"><strong><?php echo number_format(@$totreg, 3, '.', ' '); ?></strong></td>
                                                        <td  align="right"><strong><?php echo number_format(@$totavoir, 3, '.', ' '); ?></strong></td>
                                                        <td  align="right"><strong><?php echo number_format(@$sld, 3, '.', ' '); ?></strong></td>
                                                    </tr>
                                                    <tr><td colspan="9" style="height: 10px;" ></td></tr>
                                                    <?php
                                                    $totdebit = 0;
                                                    $totcredit = 0;
                                                    $totimpayer = 0;
                                                    $totreg = 0;
                                                    $totavoir = 0;
                                                    //$totsolde=0;
                                                    //$sld=0;
                                                    //$sldd=0;
                                                }
                                                ?> 
                                                <?php
                                                $clientt = ClassRegistry::init('Client')->find('first', array('conditions' => array('Client.id' => $relefe['Client']['id']), 'recursive' => 0));
                                                $soldeint = @$clientt['Client']['solderecouvrement'];
                                                $client_contact = ClassRegistry::init('Contact')->find('first', array('conditions' => array('Contact.client_id' =>$relefe['Client']['id'],'Contact.fonction="financier"'), 'recursive' =>-1));
                                                if ($soldeint > 0) {
                                                    $totdebit = @$totdebit + $soldeint;
                                                }
                                                if ($soldeint < 0) {
                                                    $totcredit = @$totcredit + $soldeint;
                                                }
                                                if ($soldeint > 0) {
                                                $sldtot = @$sldtot + $soldeint;
                                                }
                                                if ($soldeint < 0) {
                                                $sldtot = @$sldtot + $soldeint;
                                                }

                                                $clientid = @$relefe['Client']['id'];
                                                $sldd = 0;
                                                $sld = 0;
                                                //$sldtot=$soldeint;
                                                $sld = $soldeint;

                                                $condb3 = 'Bonlivraison.client_id =' . $clientid;
                                                $condf3 = 'Factureclient.client_id =' . $clientid;
                                                $condfa3 = 'Factureavoir.client_id =' . $clientid;
                                                $condr3 = 'Reglementclient.client_id =' . $clientid;


                                                ?>
                                                <tr>
                                                    <td style="background-color: #F2D7D5;" align="center"><strong> Client </strong></td>    
                                                    <td colspan="8"  ><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo @$relefe['Client']['code'] . "  " . @$relefe['Client']['name']."              ".@$relefe['Client']['tel'];  ?></strong></td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td style="background-color: #F2D7D5;" align="center" colspan="3"><strong> Solde départ </strong></td>
                                                    <td   align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                                            if ($soldeint >= 0) {
                                                                echo number_format(@$soldeint, 3, '.', ' ');
                                                            } else {
                                                                echo " ";
                                                            }
                                                            ?></strong></td>
                                                    <td   align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                                            if ($soldeint < 0) {
                                                                echo number_format((@$soldeint * (-1)), 3, '.', ' ');
                                                            } else {
                                                                echo " ";
                                                            }
                                                            ?></strong></td>
                                                    <td align="right"></td><td></td><td></td>
                                                    <td   align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php
                                                    if ($soldeint < 0) {
                                                        echo number_format((@$soldeint), 3, '.', ' ');
                                                    } else {
                                                        echo number_format(@$soldeint, 3, '.', ' ');
                                                    }
                                                            ?></strong></td>
                                                </tr>
                                                <?php
                                            }
                                            if ($relefe['Recouvrement']['debit'] != null) {
                                                // debug("debit");die;
                                                if ($relefe['Recouvrement']['typ'] == "imp") {
                                                    $sld = $sld + ($relefe['Recouvrement']['debit'] - $relefe['Recouvrement']['impaye']);
                                                } else {
                                                    $sld = $sld + ($relefe['Recouvrement']['debit'] - $relefe['Recouvrement']['reglement']);
                                                }
                                            } else {
                                                // debug("credit");die;
                                                $sld = $sld - ($relefe['Recouvrement']['credit'] - $relefe['Recouvrement']['reglement']);
                                            }
                                            $clt_id = $relefe['Client']['id'];
                                            ?>


                                            <tr>
                                                <td align="center" style="width: 5%;"><?php echo date("d/m/Y", strtotime(str_replace('/', '-', @$relefe['Recouvrement']['date']))); ?></td>
                                                <td align="center" style="width: 5%;"><?php echo @$relefe['Recouvrement']['numero']; ?></td>
                                                <td align="left" style="width: 50%;"><?php echo @$relefe['Recouvrement']['type']; ?></td>
                                                <td align="right" style="width: 7%;"><?php if((!empty($relefe['Recouvrement']['debit']))&&($relefe['Recouvrement']['debit']!=0)){echo number_format(@$relefe['Recouvrement']['debit'], 3, '.', ' ');}else{ echo "";} ?></td>
                                                <td align="right" style="width: 7%;"><?php if((!empty($relefe['Recouvrement']['credit']))&&($relefe['Recouvrement']['credit']!=0)){echo number_format(@$relefe['Recouvrement']['credit'], 3, '.', ' ');}else{ echo "";} ?></td>
                                                <td align="right" style="width: 7%;"><?php if((!empty($relefe['Recouvrement']['impaye']))&&($relefe['Recouvrement']['impaye']!=0)){echo number_format(@$relefe['Recouvrement']['impaye'], 3, '.', ' ');}else{ echo "";} ?></td>
                                                <td align="right" style="width: 7%;"><?php if((!empty($relefe['Recouvrement']['reglement']))&&($relefe['Recouvrement']['reglement']!=0)){echo number_format(@$relefe['Recouvrement']['reglement'], 3, '.', ' ');}else{ echo "";} ?></td>
                                                <td align="right" style="width: 5%;"><?php if((!empty($relefe['Recouvrement']['avoir']))&&($relefe['Recouvrement']['avoir']!=0)){echo number_format(@$relefe['Recouvrement']['avoir'], 3, '.', ' ');}else{ echo "";} ?></td>
                                                <td align="right" style="width: 7%;"><?php if((!empty($relefe['Recouvrement']['solde']))&&($relefe['Recouvrement']['solde']!=0)){echo number_format(@$relefe['Recouvrement']['solde'], 3, '.', ' ');}else{ echo "";} ?></td>
                                            </tr>
                                            <?php
                                            $totdebit = $totdebit + @$relefe['Recouvrement']['debit'];
                                            $totcredit = $totcredit + @$relefe['Recouvrement']['credit'];
                                            $totimpayer = $totimpayer + @$relefe['Recouvrement']['impaye'];
                                            $totreg = $totreg + @$relefe['Recouvrement']['reglement'];
                                            $totavoir = $totavoir + @$relefe['Recouvrement']['avoir'];
                                            if ($relefe['Recouvrement']['debit'] != null) {
                                                // debug("debit");die;
                                                if ($relefe['Recouvrement']['typ'] == "imp") {
                                                    $sldd = $sldd + ($relefe['Recouvrement']['debit'] - $relefe['Recouvrement']['impaye']);
                                                } else {
                                                    $sldd = $sldd + ($relefe['Recouvrement']['debit'] - $relefe['Recouvrement']['reglement']);
                                                }
                                            } else {
                                                // debug("credit");die;
                                                $sldd = $sldd - ($relefe['Recouvrement']['credit'] - $relefe['Recouvrement']['reglement']);
                                            }
                                            if ($relefe['Recouvrement']['debit'] != null) {
                                                // debug("debit");die;
                                                if ($relefe['Recouvrement']['typ'] == "imp") {
                                                    $sldtot = $sldtot + ($relefe['Recouvrement']['debit'] - $relefe['Recouvrement']['impaye']);
                                                } else {
                                                    $sldtot = $sldtot + ($relefe['Recouvrement']['debit'] - $relefe['Recouvrement']['reglement']);
                                                }
                                            } else {
                                                // debug("credit");die;
                                                $sldtot = $sldtot - ($relefe['Recouvrement']['credit'] - $relefe['Recouvrement']['reglement']);
                                            }
                                            ?>
                                            <?php
                                        }
                                        if (@$soldeint > 0) {
                                            $totdebit = @$totdebit + $soldeint;
                                        }
                                        if (@$soldeint < 0) {
                                            $totcredit = @$totcredit + $soldeint;
                                        }
                                        
                                        ?>
                                        <tr><td colspan="9" style="height: 10px;" ></td></tr>
                                        <tr>
                                            <td colspan="3" style="background-color: #F2D7D5;" align="center"><strong> Total <?php echo @$relefe['Client']['code'] . "  " . @$relefe['Client']['name']; ?> </strong></td>    
                                            <td  align="right"><strong><?php echo number_format(@$totdebit, 3, '.', ' '); ?></strong></td>
                                            <td  align="right"><strong><?php echo number_format(@$totcredit, 3, '.', ' '); ?></strong></td>
                                            <td  align="right"><strong><?php echo number_format(@$totimpayer, 3, '.', ' '); ?></strong></td>
                                            <td  align="right"><strong><?php echo number_format(@$totreg, 3, '.', ' '); ?></strong></td>
                                            <td  align="right"><strong><?php echo number_format(@$totavoir, 3, '.', ' '); ?></strong></td>
                                            <td  align="right"><strong><?php echo number_format(@$sldd, 3, '.', ' '); ?></strong></td>
                                        </tr>
                                        <tr><td colspan="9" style="height: 10px;" ></td></tr>
                                        <tr>
                                            <td colspan="3" style="background-color: #F2D7D5;" align="center"><strong> Total Général </strong></td>    
                                            <td  align="right"><strong><?php echo number_format(@$totdebitt, 3, '.', ' '); ?></strong></td>
                                            <td  align="right"><strong><?php echo number_format(@$totcreditt, 3, '.', ' '); ?></strong></td>
                                            <td  align="right"><strong><?php echo number_format(@$totimpayert, 3, '.', ' '); ?></strong></td>
                                            <td  align="right"><strong><?php echo number_format(@$totregt, 3, '.', ' '); ?></strong></td>
                                            <td  align="right"><strong><?php echo number_format(@$totavoirt, 3, '.', ' '); ?></strong></td>
                                            <td  align="right"><strong><?php echo number_format(@$sldtot, 3, '.', ' '); ?></strong></td>
                                        </tr>
                                    </tbody>
                                    </table>
<script>print();  
     window.close();
 </script>