<?php
						
		echo $this->BootstrapForm->input('items_id', array(				
		'label' => 'Producto:',
		'id'=>'cbxModalItems',
		'class'=>'span12',
		));
		echo '<div style="margin-bottom:45px"></div>'; //fix space otherwise won't work 
		
		echo '<div id="boxModalStock">';
		if($transfer == 'warehouses_transfer'){
			$labelStock = 'Stock Origen (Salida):';
		}else{
			$labelStock = 'Stock:';
		}
		
//		echo $this->BootstrapForm->input('stock', array(  // #2014  ALL
//		'label' => $labelStock,
//		'id'=>'txtModalStock',
//		'value'=>$stock,
//		'style'=>'background-color:#EEEEEE',
//		'class'=>'input-small',
//		'maxlength'=>'15'
//		));
//		
//		if($transfer == 'warehouses_transfer'){
//			echo $this->BootstrapForm->input('stock2', array(				
//			'label' => 'Stock Destino (Entrada):',
//			'id'=>'txtModalStock2',
//			'value'=>$stock2,
//			'style'=>'background-color:#EEEEEE',
//			'class'=>'input-small',
//			'maxlength'=>'15'
//			));
//		}
		echo '</div>';	
		//echo '<br>';
		
			
	
		
		
?>