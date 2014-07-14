<?php
				echo $this->BootstrapForm->input('ex_rate', array(
					'label' => 'Tipo de Cambio:',
					'value'=>$exRate,
					'disabled'=>'disabled',
					'id'=>'txtExRate',
				//	'step'=>0.01,
				//	'min'=>0
					'type'=>'text'
				));
?>