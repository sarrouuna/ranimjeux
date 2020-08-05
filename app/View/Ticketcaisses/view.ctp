


<fieldset>

    <div class="widget first">
        <div class="head"><h5 class="iList"><?php echo __('Consultation   Ticketcaiss'); ?></h5></div>
    

    <?php echo $this->Form->create('Ticketcaiss',array('class'=>'mainForm'));?>
        <table style="width: 100%"><tr><td style="width: 50%;">
        			 <div class='rowElem'>	
                                 <label><?php echo __('Numero'); ?></label>	
                                  <div  class='formRight'>	
                                  
			<?php echo h($ticketcaiss['Ticketcaiss']['Numero']); ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>			 <div class='rowElem'>	
                                 <label><?php echo __('Client'); ?></label>	
                                  <div class='formRight'>
                                  
			<?php echo 
                                  $this->Html->link($ticketcaiss['Client']['Raison_Social'], array('controller' => 'clients', 'action' => 'view', $ticketcaiss['Client']['id'])); ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>
                </td><td style="width: 50%;">
                            <div class='rowElem'>	
                                 <label><?php echo __('Depot'); ?></label>	
                                  <div class='formRight'>
                                  
			<?php echo 
                                  $this->Html->link($ticketcaiss['Depot']['Nom'], array('controller' => 'depots', 'action' => 'view', $ticketcaiss['Depot']['id'])); ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div>			 <div class='rowElem'>	
                                 <label><?php echo __('Date'); ?></label>	
                                  <div  class='formRight'>	
                                  
			<?php echo h(date('d/m/Y', strtotime(str_replace('-', '/',$ticketcaiss['Ticketcaiss']['Date'])))); ?>
			&nbsp;
		
                                 </div>	
                            </div><div class='fix'></div></td></tr></table>
                            <table cellpadding="0" cellspacing="0" width="100%" class="tableStatic" id="lignedevis">
                    <thead>
                        <tr>
                            <td width="10%" align="center"><h4>Code</h4></td>
                            <td width="25%" align="center"><h4>D&eacute;signation</h4></td>
                            <td width="7%" align="center"><h4>Qte</h4></td>
                            <td width="7%" align="center"><h4>Prix</h4></td>
                            <td width="8%" align="center"><h4>TTC</h4></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lignes as $k=>$ligne){?>
                           <tr>
                            <td width="10%" align="center"><?php echo $ligne['Article']['Code'];?></td>
                            <td width="25%" align="center"><?php echo $ligne['Article']['Designation'];?></td>
                            <td width="7%" align="center"><?php echo $ligne['Ticketcaisseligne']['qte'];?></td>
                            <td width="7%" align="center"><?php echo $ligne['Ticketcaisseligne']['prix'];?></td>
                            <td width="8%" align="right"><?php echo $ligne['Ticketcaisseligne']['montant'];?></td>
                        </tr> 
                       <?php } ?>
                        <tr>
                            <td colspan="4" align="right">Total</td>
                            <td align="right"><?php echo $ticketcaiss['Ticketcaiss']['Total_TTC'];?></td>
                        </tr>
                    </tbody>
                            </table>
  <?php echo $this->Form->end();?>
</div>

</fieldset>