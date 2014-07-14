<div class="row-fluid">
	<div class="span9">
		<?php echo $this->BootstrapForm->create('AdmUserLog', array('class' => 'form-horizontal'));?>
			<fieldset>
				<legend><?php echo __('Edit %s', __('Adm User Log')); ?></legend>
				<?php
				echo $this->BootstrapForm->input('adm_user_restriction_id', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('tipo', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
				echo $this->BootstrapForm->input('success', array(
					'required' => 'required',
					'helpInline' => '<span class="label label-important">' . __('Required') . '</span>&nbsp;')
				);
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
			<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('AdmUserLog.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('AdmUserLog.id'))); ?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Adm User Logs')), array('action' => 'index'));?></li>
			<li><?php echo $this->Html->link(__('List %s', __('Adm User Restrictions')), array('controller' => 'adm_user_restrictions', 'action' => 'index')); ?></li>
			<li><?php echo $this->Html->link(__('New %s', __('Adm User Restriction')), array('controller' => 'adm_user_restrictions', 'action' => 'add')); ?></li>
		</ul>
		</div>
	</div>
</div>