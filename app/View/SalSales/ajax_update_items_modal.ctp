<?php
						
		echo $this->BootstrapForm->input('items_id', array(				
		'label' => 'Item:',
		'id'=>'cbxModalItems',
		'class'=>'span12'
		));
		echo '<br>';
		echo '<br>';
		echo '<div id="boxModalPrice">';
			echo $this->BootstrapForm->input('sale_price', array(				
			'label' => 'Precio Unitario:',
			'id'=>'txtModalPrice',
			'value'=>$price,
			'class'=>'span3',
			'maxlength'=>'15'
			));
		echo '</div>';	

		echo '<div id="boxModalStock">';
			echo $this->BootstrapForm->input('stock', array(				
			'label' => 'Stock:',
			'id'=>'txtModalStock',
			'value'=>$stock,
			'disabled'=>'disabled',
			'style'=>'background-color:#EEEEEE',
			'class'=>'span3',
			'maxlength'=>'15'
			));
		echo '</div>';
?>