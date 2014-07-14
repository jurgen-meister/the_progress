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
			
								/////////////////START - SETTINGS BUTTON CANCEL /////////////////
								$parameters = $this->passedArgs;
								if(isset($parameters['origin'])){
									if($parameters['origin']=='in'){
										$url=array('action'=>'index_in');
									}elseif($parameters['origin']=='out'){
										$url=array('action'=>'index_out');	
									}
									if(!isset($parameters['search'])){
										unset($parameters['document_code']);
										unset($parameters['code']);
									}
								}else{
									$url=array('action'=>'index_warehouses_transfer');
								}
								if(!isset($parameters['search'])){
									unset($parameters['document_code']);
								}else{
									if($parameters['search'] == 'empty'){
										unset($parameters['document_code']);
									}
								}
								//unset($parameters['id']);
								//echo $this->Html->link('Cancelar', array_merge($url,$parameters), array('class'=>'btn') );
								echo $this->Html->link('<i class=" icon-arrow-left"></i> Volver', array_merge($url,$parameters), array('class'=>'btn', 'escape'=>false)).' ';
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
				if($movementIdOut <> ''){
					$displayPrint = 'inline';
				}
				echo $this->Html->link('<i class="icon-print icon-white"></i> Imprimir', array('action' => 'view_document_movement_pdf', $movementIdOut.'.pdf'), array('class'=>'btn btn-primary','style'=>'display:'.$displayPrint, 'escape'=>false, 'title'=>'Nuevo', 'id'=>'btnPrint', 'target'=>'_blank')); 
								
			?>
			<a href="#" id="btnLogicDelete" class="btn btn-danger" style="display:<?php echo $displayApproved;?>"><i class=" icon-trash icon-white"></i> Eliminar</a>
			<?php
			if($documentState == 'PENDANT' OR $documentState == ''){
				echo $this->BootstrapForm->submit('Guardar Cambios',array('class'=>'btn btn-primary','div'=>false, 'id'=>'btnSaveAll'));	
			}
			?>
			<a href="#" id="btnApproveState" class="btn btn-success" style="display:<?php echo $displayApproved;?>"><i class=" icon-ok icon-white"></i> Aprobar Transferencia </a>
			<a href="#" id="btnCancellState" class="btn btn-danger" style="display:<?php echo $displayCancelled;?>"><i class=" icon-remove icon-white"></i> Cancelar Transferencia </a>
			
		</div>
	</div>
	<!-- //////////////////////////// End - buttons /////////////////////////////////-->


	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-edit"></i>								
			</span>
			<h5>Traspaso entre Almacenes</h5>
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
					'value'=>$movementIdOut,
					'type'=>'hidden'
				));
				
				echo $this->BootstrapForm->input('code', array(
					'id'=>'txtCode',
					//'label'=>'Codigo:',
					'label'=>false,
					'autocomplete'=>'off',
					'style'=>'background-color:#EEEEEE;display:none;',
					'disabled'=>$disable,
					'type'=>'hidden',
					'placeholder'=>'El sistema generará el código',
					'div'=>false
				));
				
				echo $this->BootstrapForm->input('document_code', array(
					'id'=>'txtDocumentCode',
					//'label'=>'Codigo Traspaso:',
					'label'=>false,
					'autocomplete'=>'off',
					'style'=>'background-color:#EEEEEE;display:none;',
					'disabled'=>$disable,
					'value'=>$documentCode,
					'placeholder'=>'El sistema generará el código',
					'div'=>false
				));
				
				echo $this->BootstrapForm->input('date_in', array(
					'required' => 'required',
					'label' => 'Fecha:',
					'id'=>'txtDate',
					'value'=>$date,
					'disabled'=>$disable,
					'maxlength'=>'0',
					'class'=>'input-date-type'
				));
				
				//debug($warehouses);				
				echo $this->BootstrapForm->input('warehouseOrigin', array(
					'required' => 'required',
					'label' => 'Almacen Origen (Salida):',
					'id'=>'cbxWarehouses',
					'class'=>'span4',
					'options'=>$warehouses,
					'value'=>$warehouseOut,
					'disabled'=>$disable,
					'type'=>'select',
				));
				
				echo $this->BootstrapForm->input('warehouseDestination', array(
					'required' => 'required',
					'label' => 'Almacen Destino (Entrada):',
					'id'=>'cbxWarehouses2',
					'class'=>'span4',
					'options'=>$warehouses,
					'value'=>$warehouseIn,
					'disabled'=>$disable,
					'type'=>'select',
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
						<?php if($documentState == 'PENDANT' OR $documentState == ''){ ?>
						<a class="btn btn-primary" href='#' id="btnAddItem" title="Adicionar Item"><i class="icon-plus icon-white"></i></a>
						<?php } ?>
						<?php $limit = count($invMovementDetailsOut); $counter = $limit;?>
						<table class="table table-bordered table-condensed table-hover" id="tablaItems">
							<thead>
								<tr>
									<th>Items ( <span id="countItems"><?php echo $limit;?> </span> )</th>
									<!--<th>Stock Origen (Salida)</th>-->
									<!--<th>Stock Destino (Entrada)</th>-->
									<th>Cantidad</th>
									<?php if($documentState == 'PENDANT' OR $documentState == ''){ ?>
									<th class="columnItemsButtons"></th>
									<?php }?>
								</tr>
							</thead>
							<tbody>
								<?php
								//debug($invMovementDetailsOut);
								//debug($invMovementDetailsIn);
								for($i=0; $i<$limit; $i++){
									echo '<tr id="itemRow'.$invMovementDetailsOut[$i]['itemId'].'" >';
										echo '<td><span id="spaItemName'.$invMovementDetailsOut[$i]['itemId'].'">'.$invMovementDetailsOut[$i]['item'].'</span><input type="hidden" value="'.$invMovementDetailsOut[$i]['itemId'].'" id="txtItemId" ></td>';
//										echo '<td style="text-align:center"><span id="spaStock'.$invMovementDetailsOut[$i]['itemId'].'">'.$invMovementDetailsOut[$i]['stock'].'</span></td>';    //#2014
//										echo '<td style="text-align:center"><span id="spaStock2-'.$invMovementDetailsOut[$i]['itemId'].'">'.$invMovementDetailsIn[$i]['stock'].'</span></td>';
										echo '<td style="text-align:center"><span id="spaQuantity'.$invMovementDetailsOut[$i]['itemId'].'">'.$invMovementDetailsOut[$i]['cantidad'].'</span></td>';
										if($documentState == 'PENDANT' OR $documentState == ''){
											echo '<td class="columnItemsButtons" style="text-align:center">';
											echo '<a class="btn btn-primary" href="#" id="btnEditItem'.$invMovementDetailsOut[$i]['itemId'].'" title="Editar"><i class="icon-pencil icon-white"></i></a>
												
												<a class="btn btn-danger" href="#" id="btnDeleteItem'.$invMovementDetailsOut[$i]['itemId'].'" title="Eliminar"><i class="icon-trash icon-white"></i></a>';
											echo '</td>';
										}
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
							'label' => 'Stock Origen (Salida):',
							'id'=>'txtModalStock',
							'value'=>$stock,
							'style'=>'background-color:#EEEEEE',
							'class'=>'input-small',
							'maxlength'=>'15'
							));
							echo $this->BootstrapForm->input('stock2', array(				
							'label' => 'Stock Destino (Entrada):',
							'id'=>'txtModalStock2',
							//'value'=>$stock2,
							'style'=>'background-color:#EEEEEE',
							'class'=>'input-small',
							'maxlength'=>'15'
							));
							
						echo '</div>';		
						//////////////////////////////////////
					echo '</div>';
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