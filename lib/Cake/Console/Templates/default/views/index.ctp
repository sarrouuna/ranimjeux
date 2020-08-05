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
        <a class="btn btn btn-danger" href="<?php echo '<?php echo $this->webroot;?>'.$pluralHumanName.'/add'?>"/> <i class="fa fa-plus-circle"></i> Ajouter </a>
    </div>
    
</div>
<br><input type="hidden" id="page" value="1"/>
<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></h3>
                                </div>
                                <div class="panel-body">
                                    <div class="ls-editable-table table-responsive ls-table">
                  <table class="table table-bordered table-striped table-bottomless" id="ls-editable-table">
                      <thead>
	<tr>
	<?php foreach ($fields as $field):    $field= ucfirst($field );?>
         
		<th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th>
	<?php endforeach; ?>
		<th class="actions" align="center"></th>
        </tr></thead><tbody>
	<?php
	echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
	echo "\t<tr>\n";
		foreach ($fields as $k=>$field) {
			$isKey = false;
                        if($k==0){$ab='style="display:none"';}else{$ab='';}
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "\t\t<td >\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
						break;
					}
				}
			}
			if ($isKey !== true) {
				echo "\t\t<td $ab><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
			}
		}

		echo "\t\t<td align=\"center\">\n";
		echo "\t\t\t<?php echo \$this->Html->link(\"<button class='btn btn-xs btn-success'><i class='fa fa-search'></i></button>\", array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('escape' => false)); ?>\n";
            echo "\t\t\t<?php echo \$this->Html->link(\"<button class='btn btn-xs btn-warning'><i class='fa fa-edit'></i></button>\", array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('escape' => false)); ?>\n";
            echo "\t\t\t<?php echo \$this->Form->postLink(\"<button class='btn btn-xs btn-danger'><i class='fa fa-trash-o'></i></button>\", array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('escape' => false,null), __('Veuillez vraiment supprimer cette enregistrement # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
            echo "\t\t</td>\n";            
            echo "\t</tr>\n";

	echo "<?php endforeach; ?>\n";
	?>
                          </tbody>
	</table>
	
                                </div></div></div></div></div>	


