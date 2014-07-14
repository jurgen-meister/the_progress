<?php echo $this->Html->script('modules/PurPurchases', FALSE); ?>

<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
	<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->
	<?php
		switch ($documentState){
			case '':
				$documentStateColor = '';
				$documentStateName = 'SIN ESTADO';
				break;
			case 'ORDER_PENDANT':
				$documentStateColor = 'label-warning';
				$documentStateName = 'ORDEN PENDIENTE';
				break;
			case 'ORDER_APPROVED':
				$documentStateColor = 'label-success';
				$documentStateName = 'ORDEN APROBADA';
				break;
			case 'ORDER_CANCELLED':
				$documentStateColor = 'label-important';
				$documentStateName = 'ORDEN CANCELADA';
				break;
		}
	?>
	<!-- //////////////////////////// Start - buttons /////////////////////////////////-->
	<div class="widget-box">
		<div class="widget-content nopadding">
			<?php 
				/////////////////START - SETTINGS BUTTON CANCEL /////////////////
				$url=array('action'=>'index_order');
				$parameters = $this->passedArgs;
				if(!isset($parameters['search'])){
//					unset($parameters['document_code']);
					unset($parameters['code']);
				}
				unset($parameters['id']);
				echo $this->Html->link('<i class=" icon-arrow-left"></i> Volver', array_merge($url,$parameters), array('class'=>'btn', 'escape'=>false)).' ';
				//////////////////END - SETTINGS BUTTON CANCEL /////////////////
			?>

			<?php 
				switch ($documentState){
							case '':
								$displayApproved = 'none';
								$displayCancelled = 'none';
								$displayToDraft = 'none';
								break;
							case 'ORDER_PENDANT':
								$displayApproved = 'inline';
								$displayCancelled = 'none';
								$displayToDraft = 'none';
								break;
							case 'ORDER_APPROVED':
								$displayApproved = 'none';
								$displayCancelled = 'inline';
								$displayToDraft = 'none';
								break;
							case 'ORDER_CANCELLED':
								$displayApproved = 'none';
								$displayCancelled = 'none';
								$displayToDraft = 'inline';
								break;
						}
						
				if($invoiceState !== array() && current($invoiceState) !== 'PINVOICE_LOGIC_DELETED' && current($invoiceState) !== 'DRAFT'){
					$displayInvoice = 'inline';
				}else{
					$displayInvoice = 'none';
				}		
				if ($movementState !== array() && current($movementState) !== 'LOGIC_DELETED' && current($movementState) !== 'DRAFT') {
					$displayMovement = 'inline';
				}else{
					$displayMovement = 'none';
				}	
			?>
			<?php
			if($documentState == 'ORDER_PENDANT' OR $documentState == ''){
				echo $this->BootstrapForm->submit('Guardar Cambios',array('class'=>'btn btn-primary','div'=>false, 'id'=>'btnSaveAll'));	
			}
			?>
			<a href="#" id="btnApproveState" class="btn btn-success" style="display:<?php echo $displayApproved;?>"><i class=" icon-ok icon-white"></i> Aprobar Orden de Compra</a>
			<a href="#" id="btnLogicDeleteState" class="btn btn-danger" style="display:<?php echo $displayApproved;?>"><i class=" icon-trash icon-white"></i> Eliminar</a>
			<a href="#" id="btnCancellState" class="btn btn-danger" style="display:<?php echo $displayCancelled;?>"><i class=" icon-remove icon-white"></i> Cancelar Orden de Compra</a>
			
			
			<?php
				$displayPrint = 'none';
				if($id <> ''){
					$displayPrint = 'inline';
				}
				echo $this->Html->link('<i class="icon-print icon-white"></i> Imprimir', array('action' => 'view_document_movement_pdf', $id.'.pdf'), array('class'=>'btn btn-primary','style'=>'display:'.$displayPrint, 'escape'=>false, 'title'=>'Nuevo', 'id'=>'btnPrint', 'target'=>'_blank')); 

			?>
			
			<a href="#" id="btnSetToPendant" class="btn btn-danger" style="display:<?php echo $displayToDraft;?>"><i class="icon-refresh icon-white"></i> Cambiar a Pendiente</a>
			
			<div class=" pull-right">
					<a href="#" id="btnGoInvoice" class="btn" style="display:<?php echo $displayInvoice;?>"> Factura</a>	
					<a href="#" id="btnGoMovements" class="btn" style="display:<?php echo $displayMovement;?>"> Movimiento(s)</a>
			</div>
			
		</div>
	</div>
	<!-- //////////////////////////// End - buttons /////////////////////////////////-->
	
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-edit"></i>								
			</span>
			<h5>Orden de Compra</h5>
			<span id="documentState" class="label <?php echo $documentStateColor;?>"><?php echo $documentStateName;?></span>
		</div>
		<div class="widget-content nopadding">
			
	<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->

	<!-- ////////////////////////////////// START - FORM STARTS ///////////////////////////////////// -->
		<?php echo $this->BootstrapForm->create('PurPurchase', array('class' => 'form-horizontal'));?>
		<fieldset>
	<!-- ////////////////////////////////// END - FORM ENDS /////////////////////////////////////// -->			
					
				
				<!-- ////////////////////////////////// START FORM ORDER FIELDS /////////////////////////////////////// -->
				<?php
				//////////////////////////////////START - block when APPROVED or CANCELLED///////////////////////////////////////////////////
				$disable = 'disabled';
				$supplier_disable = 'disabled';

				if($documentState == 'ORDER_PENDANT'){
					$disable = 'enabled';
					$supplier_disable = 'disabled';
				}
				
				if($documentState == ''){
					$disable = 'enabled';
					$supplier_disable = 'enabled';
				}
				
				//////////////////////////////////END - block when APPROVED or CANCELLED///////////////////////////////////////////////////
				
				echo $this->BootstrapForm->input('purchase_hidden', array(
					'id'=>'txtPurchaseIdHidden',
					'value'=>$id,
					'type'=>'hidden'
				));
							
				echo $this->BootstrapForm->input('doc_code', array(
					'id'=>'txtCode',
					'label'=>'Código:',
					'style'=>'background-color:#EEEEEE',
					'disabled'=>$disable,
					'placeholder'=>'El sistema generará el código',
				));
				
				echo $this->BootstrapForm->input('generic_code', array(
					'id'=>'txtGenericCode',
					'value'=>$genericCode,
					'type'=>'hidden'				
				));
				
				echo $this->BootstrapForm->input('note_code', array(
					'id'=>'txtNoteCode',
					'label' => 'No. Factura Proforma:',
					'disabled'=>$disable,
				));
				
				echo $this->BootstrapForm->input('date_in', array(
					'label' => 'Fecha:',
					'id'=>'txtDate',
					'value'=>$date,
					'disabled'=>$disable,
					'maxlength'=>'0',
					'class'=>'input-date-type'
				));
				
				echo $this->BootstrapForm->input('inv_warehouse_id', array(
					'label' => 'Almacén:',
					'id'=>'cbxWarehouses',
					'class'=>'span4',
					'disabled'=>$disable,
					'selected' => 2
				));
				
//				echo $this->BootstrapForm->input('inv_supplier_id', array(
//					'label' => 'Proveedor:',
//					'id'=>'cbxSuppliers',
//					'disabled'=>$supplier_disable
//				));
				
				echo $this->BootstrapForm->input('description', array(
					'rows' => 2,
					'label' => 'Descripción:',
					'disabled'=>$disable,
					'id'=>'txtDescription'
				));
				
				echo $this->BootstrapForm->input('discount', array(
					'label' => 'Descuento:',
					'disabled'=>$disable,
					'id'=>'txtDiscount',
					'value'=>$discount,
					'type'=>'text'
				));
				
				echo '<div id="boxExRate">';
					echo $this->BootstrapForm->input('ex_rate', array(
						'label' => 'Tipo de Cambio:',
						'value'=>$exRate,
						'disabled'=>'disabled',
						'id'=>'txtExRate',
					//	'step'=>0.01,
					//	'min'=>0
						'type'=>'text'
					));
				echo '</div>';
				?>
				<!-- ////////////////////////////////// END FORM ORDER FIELDS /////////////////////////////////////// -->
				
					<!-- ////////////////////////////////// START MESSAGES /////////////////////////////////////// -->
					<div id="boxMessage"></div>
					<div id="processing"></div>
					<!-- ////////////////////////////////// END MESSAGES /////////////////////////////////////// -->
							
	<!-- ////////////////////////////////// START - END FORM ///////////////////////////////////// -->		
	</fieldset>
	<?php echo $this->BootstrapForm->end();?>
	<!-- ////////////////////////////////// END - END FORM ///////////////////////////////////// -->
	
	<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
		</div> <!-- Belongs to: <div class="widget-content nopadding"> -->
	</div> <!-- Belongs to: <div class="widget-box"> -->
	<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->

	<!-- ////////////////////////////////// START - MOVEMENT ITEMS DETAILS /////////////////////////////////////// -->
						
	<div class="widget-box">
		<div class="widget-title">
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#tab1">Items</a></li>
			</ul>
		</div>
		<div class="widget-content tab-content">
			<div id="tab1" class="tab-pane active">

				<?php if($documentState == 'ORDER_PENDANT' OR $documentState == ''){ ?>
					<a class="btn btn-primary" href='#' id="btnAddItem" title="Adicionar Item"><i class="icon-plus icon-white"></i></a>
				<?php } ?>
						<?php $limit = count($purDetails); $counter = $limit;?>
						<table class="table table-bordered table-hover data-table" id="tablaItems">
							<thead>
								<tr>
									<th>Item ( <span id="countItems"><?php echo $limit;?> </span> )</th>
									<th>Proveedor</th>
									<th>Cantidad</th>
									<th>Precio Unitario</th>
									<th>Subtotal</th>
									<?php if($documentState == 'ORDER_PENDANT' OR $documentState == ''){ ?>
									<th class="columnItemsButtons"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php
								$total = '0.00';
								for($i=0; $i<$limit; $i++){
//									$subtotal = ($purDetails[$i]['cantidad'])*($purDetails[$i]['exFobPrice']);
									echo '<tr id="itemRow'.$purDetails[$i]['itemId'].'s'.$purDetails[$i]['supplierId'].'">';
										echo '<td><span id="spaItemName'.$purDetails[$i]['itemId'].'">'.$purDetails[$i]['item'].'</span><input type="hidden" value="'.$purDetails[$i]['itemId'].'" id="txtItemId" ></td>';
										echo '<td><span id="spaSupplier'.$purDetails[$i]['itemId'].'">'.$purDetails[$i]['supplier'].'</span><input type="hidden" value="'.$purDetails[$i]['supplierId'].'" id="txtSupplierId'.$purDetails[$i]['itemId'].'" ></td>';
										echo '<td><span id="spaQuantity'.$purDetails[$i]['itemId'].'s'.$purDetails[$i]['supplierId'].'">'.$purDetails[$i]['cantidad'].'</span></td>';
										echo '<td><span id="spaExFobPrice'.$purDetails[$i]['itemId'].'s'.$purDetails[$i]['supplierId'].'">'.$purDetails[$i]['exFobPrice'].'</span></td>';
//										echo '<td><span id="spaSubtotal'.$purDetails[$i]['itemId'].'s'.$purDetails[$i]['supplierId'].'">'.number_format($subtotal, 2, '.', '').'</span></td>';
										echo '<td><span id="spaExSubtotal'.$purDetails[$i]['itemId'].'s'.$purDetails[$i]['supplierId'].'">'.$purDetails[$i]['exSubtotal'].'</span></td>';
										
										if($documentState == 'ORDER_PENDANT' OR $documentState == ''){
											echo '<td class="columnItemsButtons">';
											echo '<a class="btn btn-primary" href="#" id="btnEditItem'.$purDetails[$i]['itemId'].'s'.$purDetails[$i]['supplierId'].'" title="Editar"><i class="icon-pencil icon-white"></i></a>

												<a class="btn btn-danger" href="#" id="btnDeleteItem'.$purDetails[$i]['itemId'].'s'.$purDetails[$i]['supplierId'].'" title="Eliminar"><i class="icon-trash icon-white"></i></a>';
											echo '</td>';
										}
									echo '</tr>';	
									$total += $purDetails[$i]['exSubtotal'];
								}?>
							</tbody>
							<tfoot>
								<tr>
									<td></td>
									<td></td>
									<td></td>
									<td><h4>Total:</h4></td>
									<td><h4 id="total" ><?php echo number_format($total, 2, '.', '').' $us.'; ?></h4></td>
									<?php if($documentState == 'ORDER_PENDANT' OR $documentState == ''){ ?>
										<td></td>
									<?php }?>
								</tr>	
							</tfoot>	
						</table>

				
					
			</div>
		</div>                            
	</div>
								
	<!-- ////////////////////////////////// END ORDER ITEMS DETAILS /////////////////////////////////////// -->
	
<!-- ************************************************************************************************************************ -->
</div><!-- END CONTAINER FLUID/ROW FLUID/SPAN12 - MAIN Template #UNICORN -->
<!-- ************************************************************************************************************************ -->




<!-- ////////////////////////////////// START MODAL (Esta fuera del span9 pero sigue pertenciendo al template principal CONTAINER FLUID/ROW FLUID) ////////////////////////////// -->
			<div id="modalAddItem" class="modal hide fade ">
				  
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h3 id="myModalLabel">Cantidad Item</h3>
				  </div>
				  
				  <div class="modal-body">
					<!--<p>One fine body…</p>-->
					<?php
					
					
					echo '<div id="boxModalInitiateSupplierItemPrice">';
						//////////////////////////////////////
						echo $this->BootstrapForm->input('suppliers_id', array(
						'label' => 'Proveedor:',
						'id'=>'cbxModalSuppliers',
						'class'=>'span6'
						));
						
						echo '<div id="boxModalItemPrice">';
							//////////////////////////////////////
							echo $this->BootstrapForm->input('items_id', array(				
							'label' => 'Item:',
							'id'=>'cbxModalItems',
							'class'=>'span12'
							));
							
							echo $this->BootstrapForm->input('quantity', array(				
							'label' => 'Cantidad:',
							'id'=>'txtModalQuantity',
							'class'=>'span3',
							'maxlength'=>'10'
							));	
							
							echo $this->BootstrapForm->input('ex_subtotal', array(				
							'label' => 'Subtotal:',
							'id'=>'txtModalExSubtotal',
							'class'=>'span3',
							'maxlength'=>'10'
							));								
							
//							echo '<div id="boxModalPrice">';
//								$price='';
//								echo $this->BootstrapForm->input('ex_fob_price', array(				
//								'label' => 'Precio Unitario:',
//								'id'=>'txtModalPrice',
//								'value'=>$price,
//								'class'=>'span3',
//								'maxlength'=>'15',
//								'disabled'=>'disabled'
//								));
//							echo '</div>';		
							//////////////////////////////////////
						echo '</div>';
						//////////////////////////////////////
					echo '</div>';

				
					
					?>
					  <div id="boxModalValidateItem" class="alert-error"></div> 
				  </div>
				  
				  <div class="modal-footer">
					<a href='#' class="btn btn-primary" id="btnModalAddItem">Guardar</a>
					<a href='#' class="btn btn-primary" id="btnModalEditItem">Guardar</a>
					<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
					
				  </div>
					
			</div>
<!-- ////////////////////////////////// FIN MODAL (Esta fuera del span9 pero sigue pertenciendo al template principal CONTAINER FLUID/ROW FLUID) ////////////////////////////// -->
