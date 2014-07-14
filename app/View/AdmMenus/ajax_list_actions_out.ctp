<?php
echo $this->BootstrapForm->input('adm_action_id', array('default'=>0, 'label'=>'* Controlador->Acción'
,'required' => 'required'
,'name'=>'AdmMenu[adm_action_id]'	
,'class'=>'span6'
,'id'=>'cbxAction'
));
echo "<br>";
echo $this->BootstrapForm->input('adm_menu_id', array(
					 'label'=>'* Menu padre'
					,'default'=>0
					,'class'=>'span3'
					,'name'=>'AdmMenu[parent_node]'	
					,'options'=>$parentsMenus
				));
echo "<br>";