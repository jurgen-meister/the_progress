<?php
//		echo $this->BootstrapForm->input('sale_price', array(				
//			'label' => 'Precio Unitario:',
//			'id'=>'txtModalPrice',
//			'value'=>$price,
//			'class'=>'span3',
//			'maxlength'=>'15'
//			,'append' => 'Bs.'
//		));
//		
//		echo $this->BootstrapForm->input('stock', array(				
//				'label' => 'Stock:',
//				'id'=>'txtModalStock',
//				'value'=>$stock,
//				'disabled'=>'disabled',
//				'style'=>'background-color:#EEEEEE',
//				'class'=>'span3',
//				'maxlength'=>'15'
//				,'append' => 'u.'
//			));		

		echo $this->BootstrapForm->input('inv_warehouse_id', array(				
		'label' => 'Almacén:',
		'id'=>'cbxModalWarehouses',
		'class'=>'span6'
		));
		echo '<br>';
		echo '<br>';	
		echo '<div id="boxModalPriceStock">';
//		echo '<div id="boxModalPrice">';
			echo $this->BootstrapForm->input('sale_price', array(				
			'label' => 'Precio Unitario:',
			'id'=>'txtModalPrice',
			'value'=>$price,
			'class'=>'span3',
			'maxlength'=>'15'
			,'append' => 'Bs.'
			));
//		echo '</div>';	
			echo '<div id="boxModalStock">';
			echo $this->BootstrapForm->input('stock', array(				
			'label' => 'Stock:',
			'id'=>'txtModalStock',
			'value'=>$stock,
			'disabled'=>'disabled',
			'style'=>'background-color:#EEEEEE',
			'class'=>'span3',
			'maxlength'=>'15'
			,'append' => 'u.'
			));
			echo '</div>';
		echo '</div>';
?>
