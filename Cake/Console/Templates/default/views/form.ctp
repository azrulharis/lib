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
<?php echo "<?php echo \$this->Form->create('{$modelClass}', array('class' => 'form-horizontal', 'type' => 'file')); ?>\n"; ?>
 
<?php 
foreach ($fields as $field) {
	if (strpos($action, 'add') !== false && $field === $primaryKey) {
		continue;
	} elseif (in_array($field, array('date', 'date_from', 'date_to'))) { ?>
		<div class="form-group">
			<label class="col-sm-3"><?php echo str_replace('_', ' ', ucwords($field)); ?></label>
			<div class="col-sm-9"> 
			<?php 
			$placeholder = str_replace('_', ' ', ucwords($field));

			echo "\t<?php echo \$this->Form->input('{$field}', array('placeholder' => {$placeholder}, 'type' => 'text', 'class' => 'form-control date', 'label' => false)); \t?>\n"; ?>
			</div>
		</div>
	<?php } elseif(in_array($field, array('attachment', 'file'))) { ?>
		<div class="form-group">
			<label class="col-sm-3"><?php echo str_replace('_', ' ', ucwords($field)); ?></label>
			<div class="col-sm-9"> 
			<?php echo "\t<?php echo \$this->Form->input('{$field}', array('type' => 'file', 'class' => 'form-control', 'label' => false)); \t?>\n"; ?>
			</div>
		</div>
	<?php } else { ?>
		<div class="form-group">
			<label class="col-sm-3"><?php echo str_replace('_', ' ', ucwords($field)); ?></label>
			<div class="col-sm-9"> 
			<?php echo "\t<?php echo \$this->Form->input('{$field}', array('placeholder' => {$placeholder}, 'type' => 'text', 'class' => 'form-control', 'label' => false)); \t?>\n"; ?>
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


		<hr/>
		<h4>Item</h4>
		<?php $auth = $this->Session->read('Auth'); ?>
		<table class="table table-bordered table-hover">
			<tr>
				<th>#</th>
				<th>Item</th>
				<th>Item Code</th>
				<th>Remark</th>
				<th>Qty</th>
				<th>UOM</th>
				<th>Action</th>
			</tr>
			<tbody id="output">
				<tr id="removeItem-0">
					<td>1</td> 
					<td>
						<input type="text" id="item-0" name="item[]" class="form-control findItem" placeholder="Item Name"required>
						<input id="item_id-0" type="hidden" name="item_id[]"required>
					</td>
					<td><input type="text" name="item_code[]" class="form-control" placeholder="Item Code"required></td> 
					<td><textarea name="remark[]" class="form-control" placeholder="Remark"></textarea></td> 
					<td><input type="text" name="quantity[]" class="form-control" placeholder="Qty"required></td> 
					<td>
						<select name="unit_id[]" class="form-control"required>
							<option value="">-Select UOM-</option>
							<?php echo "<?php foreach($units as $key => $val) { ?>"; ?>
							<?php echo "<option value="<?php echo $key; ?>"><?php echo $val; ?></option>"; ?>
							<?php echo "<?php } ?>"; ?>
						</select>
					</td>  
					<td></td> 
				</tr>
			</tbody> 
		</table> 
		<a href="#" id="addMore" onclick="return false" class="btn btn-default"><i class="fa fa-plus"></i> Add Item</a>
		<hr/>


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
