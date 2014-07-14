<?php
//		echo $this->BootstrapForm->input('stock', array(				
//			'label' => 'Stock:',
//			'id'=>'txtModalStock',
//			'value'=>$stock,
//			'disabled'=>'disabled',
//			'style'=>'background-color:#EEEEEE',
//			'class'=>'span3',
//			'maxlength'=>'15'
//			,'append' => 'u.'
//			));
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

			echo '<div id="boxModalStockTotal">';
			echo $this->BootstrapForm->input('stockTotal', array(				
			'label' => 'Stock Total:',
			'id'=>'txtModalStockTotal',
			'value'=>$stockTotal,
			'disabled'=>'disabled',
			'style'=>'background-color:#EEEEEE',
			'class'=>'span3',
			'maxlength'=>'15'
			,'append' => 'u.'	
			));
			echo '</div>';
			
//			echo $this->BootstrapForm->input('stockVirtual', array(	
//		'value'=>$stock2,	
//		'id'=>'txtModalStockVirtual'
////		,'type'=>'hidden'
//		));			
			
			echo $this->BootstrapForm->input('realStock', array(	
		'value'=>$invStock,	
		'id'=>'txtModalRealStock'
//		,'type'=>'hidden'
		));
?>
