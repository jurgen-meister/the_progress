<?php		
			echo $this->BootstrapForm->input('stock', array(				
				'label' => 'Stock:',
				'id'=>'txtModalStock',
				'value'=>$stock,
				'disabled'=>'disabled',
				'style'=>'background-color:#EEEEEE',
				'class'=>'span3',
				'maxlength'=>'15'
			));		
?>
