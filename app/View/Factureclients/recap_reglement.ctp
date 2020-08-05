
                    <table border="0" style="width:100%">     
                        <tr style="width:100%">
                            <td align="center" style="width:100%">Client : <?php echo $factueclient['Client']['code']." ".$factueclient['Client']['name']." <br>"; ?></td>
                        </tr> 
                        <tr style="width:100%">   
                            <td align="center" style="width:100%">Fature Client N : <?php echo $factueclient['Factureclient']['numero']; ?></td>
                        </tr>   
                    </table><br><br>

<div>     
                    <table border="1" style="width:100%">
                         <tr style="width:100%">
                            <td align="center" style="width:13%">Fature</td>
                            <td align="center" style="width:13%">TTC</td>
                            <td align="center" style="width:30%">
                            <table border="1" style="width:100%">
                            <tr style="width:100%">
                                <td align="center" colspan="2" style="width:100%">Reglement</td>
                            </tr>    
                            <tr style="width:100%">
                               <td align="center" style="width:50%">Numero</td>
                               <td align="center" style="width:50%">Montant</td>
                            </tr>
                            </table>
                            </td>
                            <td align="center" style="width:30%">
                            <table border="1" style="width:100%">
                            <tr style="width:100%">
                                <td align="center" colspan="2" style="width:100%">Avoir</td>
                            </tr>    
                            <tr style="width:100%">
                               <td align="center" style="width:50%">Numero</td>
                               <td align="center" style="width:50%">Montant</td>
                            </tr>
                            </table>
                            </td>
                            <td align="center" style="width:14%">Montant Regler</td>
                        </tr>  
                        <tr style="width:100%">
                            <td align="left" style="width:13%"><?php echo $factueclient['Factureclient']['numero']; ?></td>
                            <td align="center" style="width:13%"><?php echo $factueclient['Factureclient']['totalttc']; ?></td>
                            <td align="center" style="width:30%">
                            <table border="1" style="width:100%">
                            <?php 
                            if(!empty($lignereglementclients)){
                                $total=0;
                            foreach ($lignereglementclients as $lr) { $total=$total+$lr['Lignereglementclient']['Montant'];?>
                            <tr style="width:100%">
                               <td align="center" style="width:50%"><?php echo $lr['Reglementclient']['numero']; ?></td>
                               <td align="center" style="width:50%"><?php echo $lr['Lignereglementclient']['Montant']; ?></td>
                            </tr>    
                            <?php }?>
                            <tr style="width:100%">
                               <td align="center" style="width:50%">Total</td>
                               <td align="center" style="width:50%"><?php  echo number_format($total,3, '.', ' '); ?></td>
                            </tr>
                            <?php }?>
                            </table>
                            </td>
                            <td align="center" style="width:30%">
                            <table border="1" style="width:100%">
                            <?php 
                            if(!empty($factuecavoir)){
                                $totalav=0;
                            foreach ($factuecavoir as $avoir) { $totalav=$totalav+@$avoir['Factureavoir']['totalttc'];?>    
                            <tr style="width:100%">
                               <td align="center" style="width:50%"><?php echo @$avoir['Factureavoir']['numero']; ?></td>
                               <td align="center" style="width:50%"><?php echo @$avoir['Factureavoir']['totalttc']; ?></td>
                            </tr> 
                            <?php }?>
                            <tr style="width:100%">
                               <td align="center" style="width:50%">Total</td>
                               <td align="center" style="width:50%"><?php  echo number_format($totalav,3, '.', ' '); ?></td>
                            </tr>
                            <?php }?>
                            </table>
                            </td>
                            <td align="center" style="width:14%"><?php echo $factueclient['Factureclient']['Montant_Regler']; ?></td>
                        </tr>   
                    </table>
                    

