<?php	
		echo $this->BootstrapForm->input('suppliers_id', array(
		'label' => 'Proveedor:',
		'id'=>'cbxModalSuppliers',
		'class'=>'span6'
		));
		echo '<br>';
		echo '<br>';
		echo '<div id="boxModalItemPrice">';
			//////////////////////////////////////
			echo $this->BootstrapForm->input('items_id', array(				
			'label' => 'Item:',
			'id'=>'cbxModalItems',
			'class'=>'span12'
			));
			echo '<br>';
			echo '<br>';	
			echo $this->BootstrapForm->input('quantity', array(				
			'label' => 'Cantidad:',
			'id'=>'txtModalQuantity',
			'class'=>'span3',
			'maxlength'=>'10'
			));	
			
			echo $this->BootstrapForm->input('ex_subtotal', array(				
			'label' => 'SubTotal:',
			'id'=>'txtModalExSubtotal',
			'class'=>'span3',
			'maxlength'=>'10'
			));	
					
//			echo '<div id="boxModalPrice">';
//				echo $this->BootstrapForm->input('ex_fob_price', array(				
//				'label' => 'Precio Unitario:',
//				'id'=>'txtModalPrice',
//				'value'=>$price,
//				'class'=>'span3',
//				'maxlength'=>'15',
//				'disabled'=>'disabled'	
//				));
//			echo '</div>';	
			//////////////////////////////////////
		echo '</div>';

?>