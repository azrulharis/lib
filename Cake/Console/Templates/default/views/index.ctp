<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>

<?php echo "<?php echo \$this->Html->link(__('{$pluralHumanName}'), array('action' => 'index'), array('class' => 'btn btn-sm btn-primary')); ?>"; ?>  
<?php echo "<?php echo \$this->Html->link(__('Add {$pluralHumanName}'), array('action' => 'add'), array('class' => 'btn btn-sm btn-success')); ?>"; ?>

<div class="row"> 
  <div class="col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content"> 
<?php  
echo "<?php echo \$this->Session->flash(); ?>";  
?>

<?php echo "<?php echo \$this->Form->create('\${$modelClass}', array('url' => array('action' => 'index'), 'class' => 'form-horizontal', 'type' => 'GET')); ?>"; ?>
	<table cellpadding="0" cellspacing="0" class="table table-bordered">
	<tr>
	<td><?php echo "<?php echo \$this->Form->input('name', array('placeholder' => 'Request No', 'class' => 'form-control', 'required' => false, 'id' => 'findProduct', 'label' => false)); ?>"; ?> 
	</td> 
	<td><?php echo "<?php echo \$this->Form->input('user', array('placeholder' => 'End User', 'class' => 'form-control', 'required' => false, 'label' => false)); ?>"; ?> 
	</td>  

	<td><?php echo "<?php echo \$this->Form->input('date_from', array('placeholder' => 'Date from', 'class' => 'form-control date', 'required' => false, 'label' => false)); ?>"; ?> 
	</td> 

	<td><?php echo "<?php echo \$this->Form->input('date_from', array('placeholder' => 'Date to', 'class' => 'form-control date', 'required' => false, 'label' => false)); ?>"; ?>
	</td> 
		
	<td><?php echo "<?php echo \$this->Form->input('status', array('options' => \$status, 'empty' => '-All Status-', 'class' => 'form-control', 'required' => false, 'label' => false)); ?>"; ?>
	</td> 

	<td><?php echo "<?php echo \$this->Form->submit('Search', array('type' => 'submit', 'name' => 'search', 'class' => 'btn btn-success pull-right')); ?>"; ?></td> 
	</tr>
</table>
<?php echo "<?php echo \$this->Form->end(); ?>"; ?>

	
	<table cellpadding="0" cellspacing="0" class="table table-bordered table-hover">
	<thead>
	<tr>
	<?php foreach ($fields as $field): ?>
		<th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th>
	<?php endforeach; ?>
		<th class="actions"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	echo "<?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
	echo "\t<tr>\n";
		foreach ($fields as $field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
						break;
					}
				}
			}
			if ($isKey !== true) {
				echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
			}
		}

		echo "\t\t<td class=\"actions\">\n";
		echo "\t\t\t<?php echo \$this->Html->link(__('View'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
		echo "\t\t\t<?php echo \$this->Html->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n"; 
		echo "\t\t</td>\n";
	echo "\t</tr>\n";

	echo "<?php endforeach; ?>\n";
	?>
	</tbody>
	</table>
	<p>
	<?php echo "<?php
	echo \$this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>"; ?>
	</p>
	<ul class="pagination">
	<?php
		echo "<?php\n";
		echo "echo \$this->Paginator->prev('&laquo;', array('tag' => 'li', 'escape' => false), '<a href=\"#\">&laquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));";

		echo "echo \$this->Paginator->numbers(array('separator' => '', 'tag' => 'li', 'currentLink' => true, 'currentClass' => 'active', 'currentTag' => 'a'));";

		echo "echo \$this->Paginator->next('&raquo;', array('tag' => 'li', 'escape' => false), '<a href=\"#\">&raquo;</a>', array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false));";
		echo "\t?>\n";
	?>
	</ul>   
</div>
</div>
</div>
</div>
