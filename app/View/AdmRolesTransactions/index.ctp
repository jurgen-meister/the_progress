<div class="row-fluid">
	<div class="span9">
		<h2><?php echo __('List %s', __('Adm Roles Transactions'));?></h2>

		<p>
			<?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
		</p>

		<table class="table">
			<tr>
				<th><?php echo $this->BootstrapPaginator->sort('id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('adm_role_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('adm_transaction_id');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_state');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('lc_transaction');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('creator');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_created');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('modifier');?></th>
				<th><?php echo $this->BootstrapPaginator->sort('date_modified');?></th>
				<th class="actions"><?php echo __('Actions');?></th>
			</tr>
		<?php foreach ($admRolesTransactions as $admRolesTransaction): ?>
			<tr>
				<td><?php echo h($admRolesTransaction['AdmRolesTransaction']['id']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($admRolesTransaction['AdmRole']['name'], array('controller' => 'adm_roles', 'action' => 'view', $admRolesTransaction['AdmRole']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($admRolesTransaction['AdmTransaction']['name'], array('controller' => 'adm_transactions', 'action' => 'view', $admRolesTransaction['AdmTransaction']['id'])); ?>
				</td>
				<td><?php echo h($admRolesTransaction['AdmRolesTransaction']['lc_state']); ?>&nbsp;</td>
				<td><?php echo h($admRolesTransaction['AdmRolesTransaction']['lc_transaction']); ?>&nbsp;</td>
				<td><?php echo h($admRolesTransaction['AdmRolesTransaction']['creator']); ?>&nbsp;</td>
				<td><?php echo h($admRolesTransaction['AdmRolesTransaction']['date_created']); ?>&nbsp;</td>
				<td><?php echo h($admRolesTransaction['AdmRolesTransaction']['modifier']); ?>&nbsp;</td>
				<td><?php echo h($admRolesTransaction['AdmRolesTransaction']['date_modified']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $admRolesTransaction['AdmRolesTransaction']['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $admRolesTransaction['AdmRolesTransaction']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $admRolesTransaction['AdmRolesTransaction']['id']), null, __('Are you sure you want to delete # %s?', $admRolesTransaction['AdmRolesTransaction']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
</div>