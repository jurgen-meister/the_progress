<?php echo $this->Html->script('modules/InvItems', FALSE); ?>
<div class="span12">
	
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-edit"></i>								
			</span>
			<h5>Editar Producto</h5>			
		</div>
	<div class="widget-content nopadding">
		<?php echo $this->BootstrapForm->create('InvItem', array('class' => 'form-horizontal'));?>
			<fieldset>				
					<?php
					echo $this->BootstrapForm->input('item_hidden',array(
						'id' => 'txtItemIdHidden',
						'type' => 'hidden',
						'value' => $id
					));
					
					echo $this->BootstrapForm->input('inv_supplier_id', array(
						'id' => 'supplier',
						'label' => '* Proveedor',
						'required' => 'required'
						,'class'=>'span4'
						//'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;'
						)
					);
					
					echo $this->BootstrapForm->input('code', array(
						'id' => 'code',
						'style' => 'width:400px',
						'label' => '* Código',
						'required' => 'required',
						//'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;'
						)
					);
					echo $this->BootstrapForm->input('inv_brand_id', array(		
						'id' => 'brand',
						'label' => '* Marca',
						'required' => 'required',					
						'class'=>'span4'
						)
					);
					echo $this->BootstrapForm->input('inv_category_id', array(
						'id' => 'category',
						'label' => '* Categoría',
						'required' => 'required',
						'class'=>'span5'
						)
					);				
					echo $this->BootstrapForm->input('name', array(
						'id' => 'name',
						'style' => 'width:400px',
						'label' => '* Nombre',
						'rows' => 3,
						'required' => 'required',
						)
					);
					echo $this->BootstrapForm->input('description', array(
						'id' => 'description',
						'rows' => 5,
						'style'=>'width:400px',
						'label' => '* Descripcción',
						'required' => 'required',
						)				
					);
?>
				  
	  
	  <!-- ////////////////////////////////// INICIO - PRECIOS /////////////////////////////////////// -->
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-briefcase"></i>								
			</span>
			<h5>Precios</h5>			
		</div>
	<div class="widget-content nopadding">
		
	<div class="row-fluid">
		<div class="span1"></div>
		<div id="boxTable" class="span8">
			<?php if($id <> null){?>
			<a class="btn btn-primary" href='#' id="btnAddPrice" title="Adicionar Precio"><i class="icon-plus icon-white"></i></a>
			<p></p>
			<?php }?>
			<table class="table table-bordered table-condensed table-striped table-hover" id="tablaPrecios">
				<thead>
					<tr>
						<th>Tipo de Precio</th>
						<th>Fecha</th>
						<th>Precio Bolivianos</th>
						<th>Precio Dolares</th>
						<th>Descripcion</th>
						<th class="columnItemsButtons"></th>
					</tr>
				</thead>
				<tbody>
					<?php for($i=0; $i<count($invPrices); $i++){?>
						<tr>							
							<td style="text-align:center;">
								<span id="<?php echo 'spaPriceType'.$invPrices[$i]['priceId']?>">
								<?php 
										echo $this->BootstrapForm->input($invPrices[$i]['priceId'], array(
											'type' => 'hidden',
											'value' => $invPrices[$i]['priceId'],
											'id' => 'txtPriceId'
											//'id' => 'txtPriceId'.$invPrices[$i]['priceId']
											));
										
										echo $this->BootstrapForm->input($invPrices[$i]['priceId'], array(
											'type' => 'hidden',
											'value' => $invPrices[$i]['itemId'],
											'id' => 'txtItemId'
											//'id' => 'txtPriceId'.$invPrices[$i]['priceId']
											));
										
										echo $this->BootstrapForm->input($invPrices[$i]['priceTypeId'], array(
											'type' => 'hidden',
											'value' => $invPrices[$i]['priceTypeId'],
											'id' => 'txtPriceTypeId'
											//'id' => 'txtPriceId'.$invPrices[$i]['priceId']
											));
										
										echo h($invPrices[$i]['priceType']); 
								?> 
								</span>
							</td>
							<td style="text-align:center;"><span id="<?php echo 'spaDate'.$invPrices[$i]['priceId']?>"><?php echo h(date("d/m/Y",  strtotime($invPrices[$i]['date']))); ?></span></td>
							<td style="text-align:center;"><span id="<?php echo 'spaPrice'.$invPrices[$i]['priceId']?>"><?php echo h($invPrices[$i]['price']); ?></span></td>
							<td style="text-align:center;"><span id="<?php echo 'spaExPrice'.$invPrices[$i]['priceId']?>"><?php echo h($invPrices[$i]['ex_price']); ?></span></td>
							<td><span id="<?php echo 'spaDescription'.$invPrices[$i]['priceId']?>"><?php echo h($invPrices[$i]['description']); ?></span></td>
							<td class="columnItemsButtons">
								<?php 
//									echo $this->Html->link('<i class= "icon-pencil icon-white"></i>','#', array(
//									'id' => 'btnEditPrice'.$invPrices[$i]['priceId'],
//									'class' => 'btn btn-info',
//									'escape'=>false, 
//									'title'=>'Editar'
//									));
									
									echo $this->Html->link('<i class= "icon-trash icon-white"></i>','#', array(
									'id' => 'btnDeletePrice'.$invPrices[$i]['priceId'],
									'class' => 'btn btn-danger',
									'escape'=>false, 
									'title'=>'Eliminar'
									)); 
								?>
							</td>
							
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="span3"></div>
	</div>		
	</div>
	</div>			
				<div class="row-fluid" style="text-align:center;">
					
					<div class="btn-toolbar">
					<?php echo $this->BootstrapForm->submit('Guardar', array('id'=>'saveButton', 'class' => 'btn btn-primary', 'div' => false));
					//debug($this->passedArgs['stock']);
					$url = array('action' => 'index');
					$parameters = array();
					if(isset($this->passedArgs['stock'])){
						$parameters = array("stock"=>$this->passedArgs['stock']);
					}
					if(isset($this->passedArgs['page'])){
						$parameters["page"] = $this->passedArgs['page'];
					}
					if(isset($this->passedArgs['code'])){
						$parameters["code"] = $this->passedArgs['code'];
					}
						   echo $this->Html->link('Cancelar', array_merge($url, $parameters), array('class'=>'btn') );
					?>
					</div>
					<div class="span4"></div>
				</div>	
			</fieldset>
		<?php echo $this->BootstrapForm->end();?>
	
	</div>
	</div>

		<div id="boxMessage"></div>
		<div id="processing"></div>

	</div>

	<!-- Prices Modal -->
<div id="modalAddPrice" class="modal hide ">
				  
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
	  <h3 id="myModalLabel">Precios</h3>
	</div>

	<div class="modal-body ">
	  
	  <?php
		echo '<div id="boxModalIntiatePrice">';
		echo '</div>';
		echo '<br>';
		//echo '<br>';
		echo $this->BootstrapForm->input('date', array(			
			'id' => 'txtModalDate',
			'label' => '* Fecha:',
			'required' => 'required',
			'class'=>'input-date-type'
			//'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;'
			)
		);		
		echo $this->BootstrapForm->input('priceType', array(
			'id' => 'cbxCurrencyType',
			'label' => '* Moneda:',
			'required' => 'required',					
			//'class'=>'span3',
			'type'=>'select',
			'options'=>array("BOLIVIANOS"=>"BOLIVIANOS", "DOLARES"=>"DOLARES")
			)
		);
		
		echo $this->BootstrapForm->input('price', array(
			'id' => 'txtModalPrice',
			'label' => '* Monto:',
			'required' => 'required',
			//'type'=>'number'
			//'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;'
			)
		);
		echo '<div id="boxModalValidateItem" class="alert-error"></div>';
		echo $this->BootstrapForm->input('description', array(
			'id' => 'txtModalDescription',
			'label' => 'Descripción:',
			'type'=>'textarea',
			'class'=>'span12'
		));						
	  ?>
	  
	</div>

	<div class="modal-footer">
	  <a href='#' class="btn btn-primary" id="btnModalAddPrice">Guardar</a>
	  <a href='#' class="btn btn-primary" id="btnModalEditPrice">Guardar</a>
	  <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>

	</div>
					
</div>


	<!-- Brands Modal -->
<div id="modalAddBrand" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Nueva Marca</h3>
  </div>
  <div class="modal-body form-horizontal">
    <?php	echo'<div id="boxModalAddBrand">';
			echo $this->BootstrapForm->input('name', array(
				'rows' => 3,				
				'label' => 'Nombre',
				'required' => 'required',
				'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
			);
			echo $this->BootstrapForm->input('description', array(
				'rows' => 5,
				//'style'=>'width:300px',
				'label' => 'Descripcion',
				'required' => 'required',
				'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
			);
			echo $this->BootstrapForm->input('country_source', array(
				'label' => 'Pais de Origen',
				'required' => 'required',
				'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
			);
			echo '</div>';
			?>	
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-primary" id="btnModalAddBrand">Guardar</button>
  </div>
</div>

	<!-- Categories Modal -->
<div id="modalAddCategorie" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Nueva Categoria</h3>
  </div>
  <div class="modal-body form-horizontal">
    
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
    <button class="btn btn-primary" id="btnModalAddCategorie">Guardar</button>
  </div>
</div>
