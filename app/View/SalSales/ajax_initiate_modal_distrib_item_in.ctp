<?php
		echo $this->BootstrapForm->input('items_id', array(				
		'label' => 'Item:',
		'id'=>'cbxModalItemsDistrib',
		'class'=>'span12'
		));
		echo '<br>';
		echo '<br>';
		echo '<div id="boxModalWarehouseStock">';
			//////////////////////////////////////
			echo $this->BootstrapForm->input('inv_warehouse_id', array(				
			'label' => 'Almacén destino:',
			'id'=>'cbxModalWarehousesDistrib',
			'class'=>'span6',
//			'selected' => $warehouseIdForEdit	
			));
			echo '<br>';
			echo '<br>';
				echo '<div id="boxModalStock">';
				echo $this->BootstrapForm->input('stock', array(				
				'label' => 'Stock de almacén destino:',
//				'id'=>'txtModalDestinyStockDistrib',
					'id'=>'txtModalStockDestDistrib',
				'value'=>$stock,
				'disabled'=>'disabled',	
				'style'=>'background-color:#EEEEEE',
				'class'=>'span3',
				'maxlength'=>'15'
				,'append' => 'u.'
				));
				echo '</div>';		
			//////////////////////////////////////
		echo '</div>';
		
//		echo $this->BootstrapForm->input('stockVirtual', array(		
//			'label' => 'Stock Virtual de almacén destino:',
//		'id'=>'txtModalDestinyStockVirtual'
//		,'value'=>$stock2
////		,'type'=>'hidden'
//		));
		
		echo $this->BootstrapForm->input('realStock', array(	
			'label' => 'Stock Real de almacén destino:',
//			'id'=>'txtModalDestinyStockReal',
		'id'=>'txtModalRealStockDestDistrib'
		,'value'=>$invStock
//		,'type'=>'hidden'
		));
		
		echo $this->BootstrapForm->input('last_backorder_destiny', array(			
//						'id'=>'txtModalDestinyLastBOQuantityDistrib'
						'id'=>'txtModalLastBOQuantityDestDistrib'
			,'value'=>$bo
				//		,'type'=>'hidden'
						));	
		
		echo $this->BootstrapForm->input('virtualStockOrigen', array(		
			'label' => 'Stock Virtual de almacén origen:',
//		'id'=>'txtModalOriginStockVirtualDistrib'
			'id'=>'txtModalVirtualStockOrigDistrib'
		,'value'=>$stockOrig
//		,'type'=>'hidden'
		));
		
//		echo $this->BootstrapForm->input('last_warehouse_name', array(			
//		'id'=>'txtModalLastWarehouseName'
//		,'value'=>$lastWarehouse
//		,'type'=>'hidden'
//		));
?>