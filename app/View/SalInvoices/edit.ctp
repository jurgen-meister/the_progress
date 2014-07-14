<div class="row-fluid">
	<div class="span9">
		<?php echo $this->BootstrapForm->create('SalInvoice', array('class' => 'form-horizontal'));?>
			<fieldset>
				<legend><?php echo __('Edit %s', __('Sal Invoice')); ?></legend>
				<?php
				echo $this->BootstrapForm->input('sal_sale_id', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('invoice_number');
				echo $this->BootstrapForm->input('date');
				echo $this->BootstrapForm->input('name');
				echo $this->BootstrapForm->input('nit');
				echo $this->BootstrapForm->input('total');
				echo $this->BootstrapForm->input('description');
				echo $this->BootstrapForm->input('lc_state', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('lc_transaction', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('creator', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('date_created', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('modifier');
				echo $this->BootstrapForm->input('date_modified');
				echo $this->BootstrapForm->hidden('id');
				?>
				<?php echo $this->BootstrapForm->submit(__('Submit'));?>
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SalInvoice.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('SalInvoice.id'))); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Invoices')), array('action' => 'index'));?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Sal Sales')), array('controller' => 'sal_sales', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Sal Sale')), array('controller' => 'sal_sales', 'action' => 'add')); ?></li>
		</ul>
		</div>
	</div>
</div>