	<div class="span9">
		<h2><?php  echo __('Inv Price');?></h2>
		<dl>
			<dt><?php echo __('Id'); ?></dt>
			<dd>
				<?php echo h($invPrice['InvPrice']['id']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Inv Item'); ?></dt>
			<dd>
				<?php echo $this->Html->link($invPrice['InvItem']['full_name'], array('controller' => 'inv_items', 'action' => 'view', $invPrice['InvItem']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Inv Price Type'); ?></dt>
			<dd>
				<?php echo $this->Html->link($invPrice['InvPriceType']['name'], array('controller' => 'inv_price_types', 'action' => 'view', $invPrice['InvPriceType']['id'])); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Price'); ?></dt>
			<dd>
				<?php echo h($invPrice['InvPrice']['price']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Description'); ?></dt>
			<dd>
				<?php echo h($invPrice['InvPrice']['description']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc State'); ?></dt>
			<dd>
				<?php echo h($invPrice['InvPrice']['lc_state']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Lc Transaction'); ?></dt>
			<dd>
				<?php echo h($invPrice['InvPrice']['lc_transaction']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Creator'); ?></dt>
			<dd>
				<?php echo h($invPrice['InvPrice']['creator']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Created'); ?></dt>
			<dd>
				<?php echo h($invPrice['InvPrice']['date_created']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Modifier'); ?></dt>
			<dd>
				<?php echo h($invPrice['InvPrice']['modifier']); ?>
				&nbsp;
			</dd>
			<dt><?php echo __('Date Modified'); ?></dt>
			<dd>
				<?php echo h($invPrice['InvPrice']['date_modified']); ?>
				&nbsp;
			</dd>
		</dl>
	</div>