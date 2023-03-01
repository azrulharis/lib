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

<div class="<?php echo $pluralVar; ?> form">
<?php echo "<?php echo \$this->Form->create('{$modelClass}', array('class' => 'form-horizontal')); ?>\n"; ?>
 
<?php 
foreach ($fields as $field) {
	if (strpos($action, 'add') !== false && $field === $primaryKey) {
		continue;
	} elseif (in_array($field, array('created', 'modified', 'updated', 'date', 'date_from', 'date_to'))) { ?>
		<div class="form-group">
			<label class="col-sm-3"><?php echo ucwords($field); ?></label>
			<div class="col-sm-9"> 
			<?php echo "\t<?php echo \$this->Form->input('{$field}', array('type' => 'text', 'class' => 'form-control date', 'label' => false)); \t?>\n"; ?>
			</div>
		</div>
	<?php } elseif(in_array($field, array('attachment', 'file'))) { ?>
		<div class="form-group">
			<label class="col-sm-3"><?php echo ucwords($field); ?></label>
			<div class="col-sm-9"> 
			<?php echo "\t<?php echo \$this->Form->input('{$field}', array('type' => 'file', 'class' => 'form-control', 'label' => false)); \t?>\n"; ?>
			</div>
		</div>
	<?php } else { ?>
		<div class="form-group">
			<label class="col-sm-3"><?php echo ucwords($field); ?></label>
			<div class="col-sm-9"> 
			<?php echo "\t<?php echo \$this->Form->input('{$field}', array('type' => 'text', 'class' => 'form-control', 'label' => false)); \t?>\n"; ?>
			</div>
		</div>
	<?php }
}
if (!empty($associations['hasAndBelongsToMany'])) {
	foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
		echo "\t\techo \$this->Form->input('{$assocName}');\n";
	}
} 
?>

<div class="form-group">
	<label class="col-sm-3">&nbsp;</label>
	<div class="col-sm-9">
		<?php echo "<?php echo \$this->Form->button('Submit', array('class' => 'btn btn-success pull-right')); ?>"; ?>			
	</div>
</div>

<?php
	echo "<?php echo \$this->Form->end(); ?>\n";
?>
</div>
<div class="actions">
	<h3><?php echo "<?php echo __('Actions'); ?>"; ?></h3>
	<ul>

<?php if (strpos($action, 'add') === false): ?>
		<li><?php echo "<?php echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), array('confirm' => __('Are you sure you want to delete # %s?', \$this->Form->value('{$modelClass}.{$primaryKey}')))); ?>"; ?></li>
<?php endif; ?>
		<li><?php echo "<?php echo \$this->Html->link(__('List " . $pluralHumanName . "'), array('action' => 'index')); ?>"; ?></li>
<?php
		$done = array();
		foreach ($associations as $type => $data) {
			foreach ($data as $alias => $details) {
				if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
					echo "\t\t<li><?php echo \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index')); ?> </li>\n";
					echo "\t\t<li><?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add')); ?> </li>\n";
					$done[] = $details['controller'];
				}
			}
		}
?>
	</ul>
</div>

</div>
</div>
</div>
</div>
