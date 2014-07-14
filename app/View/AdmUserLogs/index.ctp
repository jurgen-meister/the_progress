<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Adm User Logs'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('adm_user_restriction_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('tipo');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('success');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_state');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_transaction');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('creator');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_created');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('modifier');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_modified');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($admUserLogs as $admUserLog): ?>
			<tr>
				<td><?php echo h($admUserLog['AdmUserLog']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($admUserLog['AdmUserRestriction']['id'], array('controller' => 'adm_user_restrictions', 'action' => 'view', $admUserLog['AdmUserRestriction']['id'])); ?>
				</td>
				<td><?php echo h($admUserLog['AdmUserLog']['tipo']); ?>&nbsp;</td>
				<td><?php echo h($admUserLog['AdmUserLog']['success']); ?>&nbsp;</td>
				<td><?php echo h($admUserLog['AdmUserLog']['lc_state']); ?>&nbsp;</td>
				<td><?php echo h($admUserLog['AdmUserLog']['lc_transaction']); ?>&nbsp;</td>
				<td><?php echo h($admUserLog['AdmUserLog']['creator']); ?>&nbsp;</td>
				<td><?php echo h($admUserLog['AdmUserLog']['date_created']); ?>&nbsp;</td>
				<td><?php echo h($admUserLog['AdmUserLog']['modifier']); ?>&nbsp;</td>
				<td><?php echo h($admUserLog['AdmUserLog']['date_modified']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $admUserLog['AdmUserLog']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $admUserLog['AdmUserLog']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $admUserLog['AdmUserLog']['id']), null, __('Are you sure you want to delete # %s?', $admUserLog['AdmUserLog']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Adm User Log')), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Adm User Restrictions')), array('controller' => 'adm_user_restrictions', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__('New %s', __('Adm User Restriction')), array('controller' => 'adm_user_restrictions', 'action' => 'add')); ?> </li>
		</ul>
		</div>
	</div>
</div>