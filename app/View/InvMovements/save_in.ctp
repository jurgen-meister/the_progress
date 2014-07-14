<?php echo $this->Html->script('modules/InvMovements', FALSE); // AFTER #UNICORN IMPLEMENTATION?> 
<?php //echo $this->Html->script('jquery.dataTables.min.js', FALSE); ?>
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
				$url=array('action'=>'index_in');
				$parameters = $this->passedArgs;
				if(!isset($parameters['search'])){
					unset($parameters['document_code']);
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
			<a href="#" id="btnApproveState" class="btn btn-success" style="display:<?php echo $displayApproved;?>"><i class=" icon-ok icon-white"></i> Aprobar Entrada</a>
			<a href="#" id="btnCancellState" class="btn btn-danger" style="display:<?php echo $displayCancelled;?>"><i class=" icon-remove icon-white"></i> Cancelar Entrada</a>
			
		</div>
	</div>
	<!-- //////////////////////////// End - buttons /////////////////////////////////-->
	
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-edit"></i>								
			</span>
			<h5>Entrada al Almacen</h5>
			<span id="documentState" class="label <?php echo $documentStateColor;?>"><?php echo $documentStateName;?></span>
		</div>
		<div class="widget-content nopadding">
		
	<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 1/2 *************************************** -->
		
		
	<!-- ////////////////////////////////// START - FORM STARTS ///////////////////////////////////// -->
		<?php echo $this->BootstrapForm->create('InvMovement', array('class' => 'form-horizontal'));?>
		<fieldset>
	<!-- ////////////////////////////////// END - FORM ENDS /////////////////////////////////////// -->			
				
				
				<!-- ////////////////////////////////// START FORM MOVEMENT FIELDS  /////////////////////////////////////// -->
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
				
				echo $this->BootstrapForm->input('date_in', array(
					'required' => 'required',
					'label' => 'Fecha de Ingreso:',
					'id'=>'txtDate',
					'value'=>$date,
					'disabled'=>$disable,
					'maxlength'=>'0',
					'class'=>'input-date-type'
				));
				
				
				echo $this->BootstrapForm->input('inv_warehouse_id', array(
					'required' => 'required',
					'label' => 'Almacén Destino:',
					'id'=>'cbxWarehouses',
					'class'=>'span4',
					//'value'=>$invWarehouses,
					'disabled'=>$disable,
					//'helpInline' => '<span class="label label-important">' . ('Obligatorio') . '</span>&nbsp;'
				));

				echo $this->BootstrapForm->input('inv_movement_type_id', array(
					'label' => 'Tipo Movimiento:',
					'id'=>'cbxMovementTypes',
					'class'=>'span4',
					'disabled'=>$disable,
					'required' => 'required',
					//'helpInline' => /*$btnAddMovementType.*/'<span class="label label-important">' . ('Obligatorio') . '</span>&nbsp;'
				));
				echo $this->BootstrapForm->input('description', array(
					'rows' => 2,
					//'style'=>'width:400px',//#UNICORN, COMMENT OR REPONSIVE DOESN'T WORK
					'label' => 'Observaciones:',
					'disabled'=>$disable,
					'id'=>'txtDescription'
				));
				?>
	
			</fieldset>
			<?php echo $this->BootstrapForm->end();?>
				<!-- ////////////////////////////////// END FORM MOVEMENT FIELDS /////////////////////////////////////// -->
				
					<!-- ////////////////////////////////// START MESSAGES /////////////////////////////////////// -->
					<div id="boxMessage"></div>
					<div id="processing"></div>
					<!-- ////////////////////////////////// END MESSAGES /////////////////////////////////////// -->
				
				<!-- ////////////////////////////////// START - MOVEMENT ITEMS DETAILS /////////////////////////////////////// -->
				
				

				

					<?php if($documentState == 'PENDANT' OR $documentState == ''){ ?>
						<a class="btn btn-primary" href='#' id="btnAddItem" title="Adicionar Item"><i class="icon-plus icon-white"></i></a>
					<?php } ?>
							<?php $limit = count($invMovementDetails); $counter = $limit;?>
							<table class="table table-bordered table-hover data-table" id="tablaItems">
								<thead>
									<tr>
										<th>Productos ( <span id="countItems"><?php echo $limit;?> </span> )</th>
										<th>Cantidad de Ingreso</th>
										<!--<th>Saldo Previo al Ingreso</th>-->
										<!--<th>Saldo Total</th>-->
										<?php if($documentState == 'PENDANT' OR $documentState == ''){ ?>
										<th class="columnItemsButtons"></th>
										<?php }?>
									</tr>
								</thead>
								<tbody>
									<?php
									for($i=0; $i<$limit; $i++){
//										$totalStock = $invMovementDetails[$i]['stock'] + $invMovementDetails[$i]['cantidad'];  //#2014
										echo '<tr id="itemRow'.$invMovementDetails[$i]['itemId'].'">';
											echo '<td><span id="spaItemName'.$invMovementDetails[$i]['itemId'].'">'.$invMovementDetails[$i]['item'].'</span><input type="hidden" value="'.$invMovementDetails[$i]['itemId'].'" id="txtItemId" ></td>';
											echo '<td style="text-align:center"><span id="spaQuantity'.$invMovementDetails[$i]['itemId'].'">'.$invMovementDetails[$i]['cantidad'].'</span></td>';
//											echo '<td style="text-align:center"><span id="spaStock'.$invMovementDetails[$i]['itemId'].'">'.$invMovementDetails[$i]['stock'].'</span></td>';
//											echo '<td style="text-align:center"><span id="spaStosck'.$invMovementDetails[$i]['itemId'].'">'.$totalStock.'</span></td>';
											if($documentState == 'PENDANT' OR $documentState == ''){
												echo '<td style="text-align:center" class="columnItemsButtons">';
												echo '<a class="btn btn-primary" href="#" id="btnEditItem'.$invMovementDetails[$i]['itemId'].'" title="Editar"><i class="icon-pencil icon-white"></i></a>
													<a class="btn btn-danger" href="#" id="btnDeleteItem'.$invMovementDetails[$i]['itemId'].'" title="Eliminar"><i class="icon-trash icon-white"></i></a>';
												echo '</td>';
											}
										echo '</tr>';								
									}
									?>
								</tbody>
							</table>
						
				
			<!-- ////////////////////////////////// END MOVEMENT ITEMS DETAILS /////////////////////////////////////// -->
			


	
	
	<!-- //******************************** START - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->
		</div> <!-- Belongs to: <div class="widget-content nopadding"> -->
	</div> <!-- Belongs to: <div class="widget-box"> -->
	<!-- //******************************** END - #UNICORN  WRAP FORM BOX PART 2/2 *************************************** -->

	
	

	
	
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
					echo '<div id="boxModalIntiateItemStock">';
						//////////////////////////////////////
						echo $this->BootstrapForm->input('items_id', array(				
						'label' => 'Producto:',
						'id'=>'cbxModalItems',
						'class'=>'span12'
						));
						echo '<div style="margin-bottom:45px"></div>'; //fix space otherwise won't work 
						$stock='';
						echo '<div id="boxModalStock">';
							echo $this->BootstrapForm->input('stock', array(				
							'label' => 'Saldo Previo al Ingreso:',
							'id'=>'txtModalStock',
							'value'=>$stock,
							'style'=>'background-color:#EEEEEE',
							'class'=>'input-small',
							'maxlength'=>'15'
							));
						echo '</div>';		
						//////////////////////////////////////
					echo '</div>';
					echo $this->BootstrapForm->input('quantity', array(				
					'label' => 'Cantidad de Ingreso:',
					'id'=>'txtModalQuantity',
					'class'=>'input-small',
					//'value'=>'6',
					'maxlength'=>'10'
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
<!-- ////////////////////////////////// END MODAL (Esta fuera del span9 pero sigue pertenciendo al template principal CONTAINER FLUID/ROW FLUID) ////////////////////////////// -->