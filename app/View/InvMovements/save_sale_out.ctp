<?php echo $this->Html->script('modules/InvMovements', FALSE); ?>

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
			case 'PENDANT':
				$documentStateColor = 'label-warning';
				$documentStateName = 'PENDIENTE';
				break;
			case 'APPROVED':
				$documentStateColor = 'label-success';
				$documentStateName = 'APROBADO';
				break;
			case 'CANCELLED':
				$documentStateColor = 'label-important';
				$documentStateName = 'CANCELADO';
				break;
		}
	?>
	
	<!-- //////////////////////////// Start - buttons /////////////////////////////////-->
	<div class="widget-box">
		<div class="widget-content nopadding">
			<?php 
				/////////////////START - SETTINGS BUTTON CANCEL /////////////////
				$parameters = $this->passedArgs;
				/*
				$url=array();
				if($idMovement == ''){
					$url=array('action'=>'index_sale_out');
					if(!isset($parameters['search'])){
						unset($parameters['document_code']);
					}else{
						if($parameters['search'] == 'empty'){
							unset($parameters['document_code']);
						}
					}
				}else{
					$url['action']='index_out';
					if(!isset($parameters['search'])){//no search
						unset($parameters['document_code']);
						unset($parameters['code']);
					}else{//yes search
						if($parameters['search']=='yes'){
							if(isset($parameters['document_code']) && isset($parameters['code'])){
								unset($parameters['document_code']);
							}
							if(isset($parameters['document_code'])){
								unset($parameters['code']);
							}
						}
						if($parameters['search']=='empty'){
							unset($parameters['document_code']);
						}
					}
				}
				*/
				unset($parameters['id']);
				if($parameters['documentCodeNoSet'] == ''){
					unset($parameters['document_code']);
				}else{
					$parameters['document_code'] = $parameters['documentCodeNoSet'];
				}
				//debug($parameters);
				echo $this->Html->link('<i class=" icon-arrow-left"></i> Volver', array_merge(array("action"=>"index_sale_out"),$parameters), array('class'=>'btn', 'escape'=>false)).' ';
				//////////////////END - SETTINGS BUTTON CANCEL /////////////////
			?>

			<?php 
				switch ($documentState){
							case '':
								$displayApproved = 'none';
								$displayCancelled = 'none';
								break;
							case 'PENDANT':
								$displayApproved = 'inline';
								$displayCancelled = 'none';
								break;
							case 'APPROVED':
								$displayApproved = 'none';
								$displayCancelled = 'inline';
								break;
							case 'CANCELLED':
								$displayApproved = 'none';
								$displayCancelled = 'none';
								break;
						}
			?>
			<?php
				$displayPrint = 'none';
				if($id <> ''){
					$displayPrint = 'inline';
				}
				echo $this->Html->link('<i class="icon-print icon-white"></i> Imprimir', array('action' => 'view_document_movement_pdf', $id.'.pdf'), array('class'=>'btn btn-primary','style'=>'display:'.$displayPrint, 'escape'=>false, 'title'=>'Nuevo', 'id'=>'btnPrint', 'target'=>'_blank')); 

			?>
			<a href="#" id="btnLogicDelete" class="btn btn-danger" style="display:<?php echo $displayApproved;?>"><i class=" icon-trash icon-white"></i> Eliminar</a>
			<?php
			if($documentState == 'PENDANT' OR $documentState == ''){
				echo $this->BootstrapForm->submit('Guardar Cambios',array('class'=>'btn btn-primary','div'=>false, 'id'=>'btnSaveAll'));	
			}
			?>
			<a href="#" id="btnApproveState" class="btn btn-success" style="display:<?php echo $displayApproved;?>"><i class=" icon-ok icon-white"></i> Aprobar Salida</a>
			<a href="#" id="btnCancellState" class="btn btn-danger" style="display:<?php echo $displayCancelled;?>"><i class=" icon-remove icon-white"></i> Cancelar Salida</a>
			
		</div>
	</div>
	<!-- //////////////////////////// End - buttons /////////////////////////////////-->
	
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-edit"></i>								
			</span>
			<h5>Salida de Venta del Almacen</h5>
			<span id="documentState" class="label <?php echo $documentStateColor;?>"><?php echo $documentStateName;?></span>
		</div>
		<div class="widget-content nopadding">
	<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->
	

	<!-- ////////////////////////////////// INICIO - INICIO FORM ///////////////////////////////////// -->
		<?php echo $this->BootstrapForm->create('InvMovement', array('class' => 'form-horizontal'));?>
		<fieldset>
	<!-- ////////////////////////////////// FIN - INICIO FORM /////////////////////////////////////// -->			
				
				<!-- ////////////////////////////////// INICIO CAMPOS FORMULARIOS MOVIMIENTO /////////////////////////////////////// -->
				<?php
				
				//////////////////////////////////START - block when APPROVED or CANCELLED///////////////////////////////////////////////////
				$disable = 'disabled';
				
				if($documentState == 'PENDANT' OR $documentState == ''){
					$disable = 'enabled';	
				}
				
				//////////////////////////////////END - block when APPROVED or CANCELLED///////////////////////////////////////////////////
				echo $this->BootstrapForm->input('movement_hidden', array(
					'id'=>'txtMovementIdHidden',
					'value'=>$id,
					'type'=>'hidden'
				));
				
				echo $this->BootstrapForm->input('code', array(
					'id'=>'txtCode',
					//'label'=>'Codigo:',
					'label'=>false,
					'autocomplete'=>'off',
					'style'=>'background-color:#EEEEEE;display:none;',
					'disabled'=>$disable,
					'placeholder'=>'El sistema generará el código',
					'div'=>false
				));
				
				echo $this->BootstrapForm->input('document_code', array(
					'id'=>'txtDocumentCode',
					'autocomplete'=>'off',
					//'label'=>'Codigo Documento Ref:',
					'label'=>false,
					'style'=>'background-color:#EEEEEE;display:none;',
					'disabled'=>$disable,
					'value'=>$documentCode,
					'div'=>false
				));
				
				echo $this->BootstrapForm->input('note_code', array(
					'id'=>'txtNoteCode',
					'autocomplete'=>'off',
					'label'=>'Nota Remision:',
					'style'=>'background-color:#EEEEEE',
					'disabled'=>$disable,
					'value'=>$noteCode
				));
				
				echo $this->BootstrapForm->input('date_in', array(
					'required' => 'required',
					'label' => 'Fecha:',
					'id'=>'txtDate',
					'value'=>$date,
					'disabled'=>$disable,
					'maxlength'=>'0',
					'class'=>'input-date-type'
					//'helpInline' => '<span class="label label-important">' . ('Obligatorio') . '</span>&nbsp;'
				));
				
				
				
				echo $this->BootstrapForm->input('inv_warehouse_id', array(
					'required' => 'required',
					'label' => 'Almacén:',
					'id'=>'cbxWarehouses',
					'class'=>'span4',
					//'value'=>$invWarehouses,
					'disabled'=>$disable,
					//'helpInline' => '<span class="label label-important">' . ('Obligatorio') . '</span>&nbsp;'
				));

				
				echo $this->BootstrapForm->input('description', array(
					'rows' => 2,
					//'style'=>'width:400px',
					'label' => 'Descripción:',
					'disabled'=>$disable,
					'id'=>'txtDescription'
				));
				?>
				</fieldset>
				<?php echo $this->BootstrapForm->end();?>
				<!-- ////////////////////////////////// FIN CAMPOS FORMULARIOS MOVIMIENTO /////////////////////////////////////// -->
				
				<!-- ////////////////////////////////// START MESSAGES /////////////////////////////////////// -->
					<div id="boxMessage"></div>
					<div id="processing"></div>
				<!-- ////////////////////////////////// END MESSAGES /////////////////////////////////////// -->
				
				<!-- ////////////////////////////////// INICIO - ITEMS /////////////////////////////////////// -->

						<?php //if($documentState == 'PENDANT' OR $documentState == ''){ ?>
						<!--<a class="btn btn-primary" href='#' id="btnAddItem" title="Adicionar Item"><i class="icon-plus icon-white"></i></a>-->
						<?php //} ?>
						<?php $limit = count($invMovementDetails); $counter = $limit;?>
						<table class="table table-bordered table-condensed table-hover" id="tablaItems">
							<thead>
								<tr>
									<th>Items ( <span id="countItems"><?php echo $limit;?> </span> )</th>
									<!--<th>Stock</th>-->
									<!--<th>Venta</th>-->
									<th>Cantidad</th>
									<?php if($documentState == 'PENDANT' OR $documentState == ''){ ?>
									<th class="columnItemsButtons"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php
								for($i=0; $i<$limit; $i++){
									echo '<tr id="itemRow'.$invMovementDetails[$i]['itemId'].'" >';
										echo '<td><span id="spaItemName'.$invMovementDetails[$i]['itemId'].'">'.$invMovementDetails[$i]['item'].'</span><input type="hidden" value="'.$invMovementDetails[$i]['itemId'].'" id="txtItemId" ></td>';
//										echo '<td><span id="spaStock'.$invMovementDetails[$i]['itemId'].'">'.$invMovementDetails[$i]['stock'].'</span></td>';  //#2014
										//echo '<td><span id="spaQuantityDocument'.$invMovementDetails[$i]['itemId'].'">'.$invMovementDetails[$i]['cantidadVenta'].'</span></td>';
										echo '<td><span id="spaQuantity'.$invMovementDetails[$i]['itemId'].'">'.$invMovementDetails[$i]['cantidad'].'</span></td>';
										/*
										if($documentState == 'PENDANT' OR $documentState == ''){
											echo '<td class="columnItemsButtons">';
											echo '<a class="btn btn-primary" href="#" id="btnEditItem'.$invMovementDetails[$i]['itemId'].'" title="Editar"><i class="icon-pencil icon-white"></i></a>
												
												<a class="btn btn-danger" href="#" id="btnDeleteItem'.$invMovementDetails[$i]['itemId'].'" title="Eliminar"><i class="icon-trash icon-white"></i></a>';
											echo '</td>';
										}
										 * */
									echo '</tr>';								
								}
								?>
							</tbody>
						</table>

			<!-- ////////////////////////////////// FIN ITEMS /////////////////////////////////////// -->

		

	
	<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
		</div> <!-- Belongs to: <div class="widget-content nopadding"> -->
	</div> <!-- Belongs to: <div class="widget-box"> -->
	<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
	
	
	
<!-- ************************************************************************************************************************ -->
</div><!-- FIN CONTAINER FLUID/ROW FLUID/SPAN9 - Del Template Principal (SPAN3 reservado para menu izquierdo) -->
<!-- ************************************************************************************************************************ -->




<!-- ////////////////////////////////// INICIO MODAL (Esta fuera del span9 pero sigue pertenciendo al template principal CONTAINER FLUID/ROW FLUID) ////////////////////////////// -->
			<div id="modalAddItem" class="modal hide fade ">
				  
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h3 id="myModalLabel">Cantidad Item</h3>
				  </div>
				  
				  <div class="modal-body">
					<!--<p>One fine body…</p>-->
					<?php
					echo '<div id="boxModalIntiateItemStock">';
						//////////////////////////////////////

						echo $this->BootstrapForm->input('items_id', array(				
						'label' => 'Producto:',
						'id'=>'cbxModalItems',
						'class'=>'span12',
						));
						echo '<div style="margin-bottom:45px"></div>'; //fix space otherwise won't work 
						$stock='';
						echo '<div id="boxModalStock">';
							echo $this->BootstrapForm->input('stock', array(				
							'label' => 'Stock:',
							'id'=>'txtModalStock',
							'value'=>$stock,
							'style'=>'background-color:#EEEEEE',
							'class'=>'input-small',
							'maxlength'=>'15'
							));

						echo '</div>';		
						//echo '<br>';

						//////////////////////////////////////
					echo '</div>';
					
					echo $this->BootstrapForm->input('quantity_purchase', array(				
							'label' => 'Venta:',
							'id'=>'txtModalQuantityDocument',
							'style'=>'background-color:#EEEEEE',
							'class'=>'input-small',
							'maxlength'=>'15'
							));
					
					//echo '<br>';
					echo $this->BootstrapForm->input('quantity', array(				
					'label' => 'Cantidad:',
					'id'=>'txtModalQuantity',
					'class'=>'input-small',
					//'value'=>'6',
					'maxlength'=>'10',
					));
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