<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('Lista %s', __('Mensajes de Error'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('Modulo');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('Código');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('Descipcion');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('Causa');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('Accion a Seguir');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('Origen');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('Comentarios');?></th>				
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($admErrorMessages as $admErrorMessage): ?>
			<tr>
				<td><?php echo h($admErrorMessage['AdmErrorMessage']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($admErrorMessage['AdmModule']['name'], array('controller' => 'adm_modules', 'action' => 'view', $admErrorMessage['AdmModule']['id'])); ?>
				</td>
				<td><?php echo h($admErrorMessage['AdmErrorMessage']['code']); ?>&nbsp;</td>
				<td><?php echo h($admErrorMessage['AdmErrorMessage']['description']); ?>&nbsp;</td>
				<td><?php echo h($admErrorMessage['AdmErrorMessage']['reason']); ?>&nbsp;</td>
				<td><?php echo h($admErrorMessage['AdmErrorMessage']['course_to_follow']); ?>&nbsp;</td>
				<td><?php echo h($admErrorMessage['AdmErrorMessage']['origin']); ?>&nbsp;</td>
				<td><?php echo h($admErrorMessage['AdmErrorMessage']['comments']); ?>&nbsp;</td>				
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $admErrorMessage['AdmErrorMessage']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $admErrorMessage['AdmErrorMessage']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $admErrorMessage['AdmErrorMessage']['id']), null, __('Are you sure you want to delete # %s?', $admErrorMessage['AdmErrorMessage']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
<!--	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Adm Error Message')), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Adm Modules')), array('controller' => 'adm_modules', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Adm Module')), array('controller' => 'adm_modules', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>-->
</div>