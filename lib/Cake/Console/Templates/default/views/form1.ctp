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
$action1="";
if($action=='add'){
    $action1='Ajout';
}
if($action=='edit'){
    $action1='Modidication';
}
?>
<div class="row">
    <div class="col-md-12">
        <a class="btn btn btn-danger" href="<?php echo '<?php echo $this->webroot;?>'.$modelClass.'s/index'?>"/> <i class="fa fa-reply"></i> Retour </a>
    </div>
    
</div>
<br>
<?php 
 $i=0;
            foreach ($fields as $c=>$fieldd) {
              $i++;  
            }   
?>
<div class="row" >
                        <div class="col-md-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action1), $singularHumanName); ?></h3>
                                </div>
                                <div class="panel-body">
        <?php echo "<?php echo \$this->Form->create('{$modelClass}',array('autocomplete' => 'off','class'=>'form-horizontal ls_form','id'=>'defaultForm','data-bv-message'=>'This value is not valid','data-bv-feedbackicons-valid'=>'fa fa-check','data-bv-feedbackicons-invalid'=>'fa fa-bug','data-bv-feedbackicons-validating'=>'fa fa-refresh')); ?>\n"; ?>

<?php   
            $a=round($i/2);
            $b=($i%2);
//            if(($b>0)){
//                $a=$a+1;
//            }
            ?>
              <div class="col-md-6">                      
              <?php  $j=0;                    
		echo "\t<?php\n";
		foreach ($fields as $k=>$field) {$j++;
               $field= ucfirst($field );
			if (strpos($action, 'add') !== false && $field == $primaryKey) {
				continue;
			} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
			echo "\t\techo \$this->Form->input('{$field}',array('div'=>'form-group','between'=>'<div class=\"col-sm-10\">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire') );\n";
			}
               if($j==$a){         
                 echo "\t?>\n"; ?></div>
               <?php if($k+1!=$i){  ?>                     
               <div class="col-md-6"><?php echo "\t<?php\n"; }      
              $j=0;$a=$a-1; }}
              if($k==1){echo "\t?></div>\n";}
              
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				echo "\t\t <?php echo \$this->Form->input('{$assocName}',array('div'=>'form-group','between'=>'<div class=\"col-sm-10\">','after'=>'</div>','class'=>'form-control','required data-bv-notempty-message'=>'Champ Obligatoire'));?>\n";
			}
		}
		 
?>                 
<div class="form-group">
                                            <div class="col-lg-9 col-lg-offset-3">
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </div>
<?php
echo "<?php echo \$this->Form->end();?>\n";
?>
</div>
                            </div>
                        </div>
</div>

