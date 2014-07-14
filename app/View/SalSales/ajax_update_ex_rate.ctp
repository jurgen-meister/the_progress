<?php
				echo $this->BootstrapForm->input('ex_rate', array(
					'label' => 'Tipo de Cambio:',
					'value'=>$exRate,
					'disabled'=>'disabled',
					'id'=>'txtExRate',
					'type'=>'text',
					'append' => 'Bs.'
				));
?>