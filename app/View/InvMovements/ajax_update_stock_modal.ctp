<?php
		if($transfer == 'warehouses_transfer'){
			$labelStock = 'Stock Origen:';
		}else{
			$labelStock = 'Stock:';
		}	
		echo $this->BootstrapForm->input('stock', array(				
		'label' => $labelStock,
		'id'=>'txtModalStock',
		'value'=>$stock,
		'style'=>'background-color:#EEEEEE',
		'class'=>'input-small',
		'maxlength'=>'15'
		));
		
		if($transfer == 'warehouses_transfer'){
			echo $this->BootstrapForm->input('stock2', array(				
			'label' => 'Stock Destino:',
			'id'=>'txtModalStock2',
			'value'=>$stock2,
			'style'=>'background-color:#EEEEEE',
			'class'=>'input-small',
			'maxlength'=>'15'
			));
		}
?>
