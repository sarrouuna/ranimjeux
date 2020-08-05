<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo '<?php echo $this->webroot;?>'.$singularHumanName.'s/index'?>"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></h3>
                                </div>
                                <div class="panel-body">
         <?php echo "<?php echo \$this->Form->create('{$modelClass}',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>\n"; ?>                           
<?php 
 $i=0;
            foreach ($fields as $c=>$fieldd) {
              $i++;  
            } 
            $a=round($i/2);
            $b=($i%2);
//            if(($b>0)){
//                $a=$a+1;
//            }
?>
           <div class="col-md-6">                         
             <?php $j=0; 
foreach ($fields as $k=>$field) {$j++;   
	$isKey = false;
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $alias => $details) {
			if ($field === $details['foreignKey']) {
                            
				$isKey = true;
				echo "\t\t <div class='form-group'>\t
                                 <label class='col-md-2 control-label'><?php echo __('" . Inflector::humanize(Inflector::underscore(ucfirst($alias))) . "'); ?></label>\t
                                  \n\t\t\t
                                  <div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' value='<?php echo \${$singularVar}['{$alias}']['{$details['displayField']}']; ?>'>
                                  </div>\n\t\t\t&nbsp;\n\t\t
                                 
                            </div>\t";
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t <div class='form-group'>\t
                                 <label class='col-md-2 control-label'><?php echo __('" . Inflector::humanize(ucfirst($field)) . "'); ?></label>\t
                                  \t
                                  \n\t\t\t<div class='col-sm-10'><input type='text'  class='form-control' readonly='readonly' class='input' value='<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>'>

                                  </div>\n\t\t\t&nbsp;\n\t\t
                                 
</div>\t";
                                  
}
if($j==$a){  ?></div>
               <?php if($k+1!=$i){  ?>                     
               <div class="col-md-6"><?php  }      
              $j=0;$a=$a-1; }}
              if($k==1){?></div><?php } ?>

<?php
echo "<?php echo \$this->Form->end();?>\n";
?>	
</div></div></div></div>


	

