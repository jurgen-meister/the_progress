<?php
echo $this->BootstrapForm->input('roles', array(
		'required' => 'required',
		'label'=>'* Role:',
		'type'=>'select',
		'options'=>$roles,
		'id'=>'cbxRoles',
		'name'=>'cbxRoles',
		//'placeholder'=>'Fecha en que el usuario dejará de estar activo',
		//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
	));
echo $this->BootstrapForm->input('areas', array(
		'required' => 'required',
		'label'=>'* Area:',
		'type'=>'select',
		'options'=>$areas,
		'id'=>'cbxAreas',
		'name'=>'cbxAreas',
		//'placeholder'=>'Fecha en que el usuario dejará de estar activo',
		//'helpInline' => '<span class="label label-important">' . __('Obligatorio') . '</span>&nbsp;'
	));