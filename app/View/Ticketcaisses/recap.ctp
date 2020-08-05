

<?php $i=0;
foreach ($lignes as $i=> $ligne) { //debug($ligne);die;
    $date = date('Y-m-d');
    $ttqte=0;$ttprix=0;$ttcmd=0;
    $ModelPromotion = ClassRegistry::init('Promotion');
    $exist_promo = $ModelPromotion->find('count', array('conditions' => array(
            'Promotion.article_id' => $ligne['Article']['id']
            , 'Promotion.datedebut <=' . "'" . $date . "'"
            , 'Promotion.datefin >=' . "'" . $date . "'"
    )));

if($exist_promo!=0){
    $lespromos = $ModelPromotion->find('all', array('conditions' => array(
            'Promotion.article_id' => $ligne['Article']['id']
            , 'Promotion.datedebut <=' . "'" . $date . "'"
            , 'Promotion.datefin >=' . "'" . $date . "'"
    )));
    //debug($lespromos);die;
    $ModelTicketcaisselignepromo = ClassRegistry::init('Ticketcaisselignepromo');
    $ttqte='0'."**".'1';
    $ttprix='0'."**".$ligne['Article']['prixuttc'];
    // Si awel ligna (mta3 par defaut teb3a promotion )
    $sipromo = $ModelTicketcaisselignepromo->find('first', array('conditions' => array(
            'Ticketcaisselignepromo.article_id' => $ligne['Article']['id']
            ,'Ticketcaisselignepromo.ticketcaisse_id'=>$ligne['Ticketcaisseligne']['ticketcaisse_id']
            ,'Ticketcaisselignepromo.ticketcaisseligne_id'=>$ligne['Ticketcaisseligne']['id']
            ,'Ticketcaisselignepromo.qteparlot'=>1
            ),'recursive'=>-1));
    if(!empty($sipromo)){
        $ttcmd='0'."**".$sipromo['Ticketcaisselignepromo']['qtecmd'];
    }
    
    
    
    foreach ($lespromos as $lespromo){
        $ttqte = $ttqte.'**'.$lespromo['Promotion']['qte'];
        $ttprix = $ttprix.'**'.$lespromo['Promotion']['prix'];
        //debug($lespromo['Promotion']['prix']);
        
        $lpromo = $ModelTicketcaisselignepromo->find('all', array('conditions' => array(
            'Ticketcaisselignepromo.article_id' => $ligne['Article']['id']
            ,'Ticketcaisselignepromo.ticketcaisse_id'=>$ligne['Ticketcaisseligne']['ticketcaisse_id']
            ,'Ticketcaisselignepromo.prixunite'=>$lespromo['Promotion']['prix']
            ,'Ticketcaisselignepromo.qteparlot'=>$lespromo['Promotion']['qte']
            )));
        if(!empty($lpromo)){
            $ttcmd=$ttcmd.'**'.$lpromo['Ticketcaisselignepromo']['qtecmd'];
        }else {
            $ttcmd=$ttcmd.'**'.'0';
        }        
    }
    
//    debug($ttqte);
//    debug($ttprix);
//    debug($ttcmd);
    
}
    
    ?>
<tr>

        <td champ='td' index='<?php echo $i; ?>' id="td<?php echo $i ?>" align='left'><div champ="divproduit"><?php echo $ligne['Article']['name']; ?></div> 


            <input type="hidden" champ='des' table='Lignecommande' readonly="readonly" id="des<?php echo $i; ?>" name="data[Lignecommande][<?php echo $i; ?>][des]" index='<?php echo $i; ?>' class="form-control" value="<?php echo $ligne['Article']['name']; ?>">
            <input type="hidden" champ='produit' table='Lignecommande' id="produit<?php echo $i; ?>" name="data[Lignecommande][<?php echo $i; ?>][produit]" index='<?php echo $i; ?>' value="<?php echo $ligne['Ticketcaisseligne']['article_id']; ?>">
            <input type="hidden" champ='composant_id' table='Lignecommande' id="composant_id<?php echo $i; ?>" name="data[Lignecommande][<?php echo $i; ?>][composant_id]" index='<?php echo $i; ?>' value="0">
            <input   table='Lignecommande' type='hidden'champ='ttprix' id="ttprix<?php echo $i; ?>" name="data[Lignecommande][<?php echo $i; ?>][ttprix]"  value="<?php echo $ttprix ?>"  index='<?php echo $i; ?>' style="width:75px; text-align:center"  class="form-control"   />
            <input   table='Lignecommande' type='hidden'champ='ttqte' id="ttqte<?php echo $i; ?>" name="data[Lignecommande][<?php echo $i; ?>][ttqte]" value="<?php echo $ttqte ?>"  index='<?php echo $i; ?>'  style="width:75px; text-align:center"   class="form-control"   />

            <input   table='Lignecommande' type='hidden' champ='ttcmd' id="ttcmd<?php echo $i; ?>" name="data[Lignecommande][<?php echo $i; ?>][ttcmd]" value="<?php echo $ttcmd ?>" index='<?php echo $i; ?>'  style="width:75px; text-align:center"   class="form-control"   />

        </td>
        <td align='right'> <div champ="divprix" id="divprix<?php echo $i; ?>"><?php echo $ligne['Article']['prixuttc']; ?></div>  <input type="hidden" id="prix<?php echo $i; ?>" readonly="readonly" champ='prix' table='Lignecommande' name="data[Lignecommande][<?php echo $i; ?>][prix]" index='<?php echo $i; ?>' value="<?php echo $ligne['Article']['prixuttc']; ?>" class="form-control"></td>
        <td align='center'> <!--<div champ="divqte" ></div>  -->
            
            <input type="" champ='qte' readonly="readonly" id="qte<?php echo $i; ?>" name="data[Lignecommande][<?php echo $i; ?>][qte]" table='Lignecommande' readonly="readonly" index='<?php echo $i; ?>' style="width:80px" value="<?php echo $ligne['Ticketcaisseligne']['qte']; ?>" class="form-control qtt" onkeyup="calcule()"> 
            <input type="hidden" champ='anc' id="anc<?php echo $i; ?>" name="data[Lignecommande][<?php echo $i; ?>][anc]" table='Lignecommande' readonly="readonly" index='<?php echo $i; ?>' style="width:80px" value="" class="form-control anc"  > 
            <input type="hidden" champ='promotion' table='Lignecommande' id="promotion<?php echo $i; ?>" name="data[Lignecommande][<?php echo $i; ?>][promotion]" index='<?php echo $i; ?>' style="width:50px" value="<?php echo $exist_promo; ?>" class="form-control" > 
        </td>
        <td align='right'> <div champ="divtotal" id="divtotal<?php echo $i; ?>"><?php echo $ligne['Ticketcaisseligne']['montant']; ?></div>  <input type="hidden" readonly="readonly" id="total<?php echo $i; ?>" champ='total' name="data[Lignecommande][<?php echo $i; ?>][total]" table='Lignecommande' index='<?php echo $i; ?>' value="<?php echo $ligne['Ticketcaisseligne']['montant']; ?>" class="form-control"></td>
        <td align='center' champ='plus' id="plus<?php echo $i; ?>"  index='<?php echo $i; ?>' >
            <?php if($exist_promo !=0){ ?>
            <a onClick="flvFPW1('<?php echo $this->webroot ; ?>ticketcaisses/promotion/<?php echo $ligne['Article']['id'] ?>/<?php echo $i ?>/<?php echo $ttqte ?>/<?php echo $ttprix ?>/<?php echo $ttcmd ?>','UPLOAD','width=500,height=450,scrollbars=yes',0,2,2);return document.MM_returnValue" href="javascript:;" >
                <div   style="width:45px; height:35px ; padding-top:8px"  index="<?php echo $i; ?>" class="   btn btn-xs btn-success">  <i class="glyphicon glyphicon-search" >  </i></div> 
            </a>
            <?php } ?>
        </td>
                                     <!--<td align='center'  champ='moin'   index='<?php echo $i; ?>'> <div     style="width:45px; height:35px;  padding-top:8px" index='<?php echo $i; ?>' class="moin btn btn-xs btn-warning"><i class="glyphicon glyphicon-minus"></i></div> </td>-->
        <td align='center'  champ='sup1'   index='<?php echo $i; ?>'> <div    style="width:45px; height:35px; padding-top:8px" index='<?php echo $i; ?>' class=" sup1 btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i></div>  </td>

    </tr> 
<?php } ?>
