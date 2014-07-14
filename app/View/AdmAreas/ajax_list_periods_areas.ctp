<?php
echo $this->BootstrapForm->input('parent_area_id', array(
	'name'=>'AdmArea[parent_area]',
	'id'=>'cbxParent',
	'label'=>'* Padre:',
	'default'=>0,
	'required' => 'required',
	'class'=>'span4'
));				