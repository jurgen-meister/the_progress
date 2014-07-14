<?php echo $this->Html->script('modules/InvItems', FALSE); ?>
<div class="span12">
	
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-edit"></i>								
			</span>
			<h5>Crear Producto</h5>			
		</div>
	<div class="widget-content nopadding">
		<?php echo $this->BootstrapForm->create('InvItem', array('class' => 'form-horizontal'));?>
			<fieldset>
					<?php
					
					echo $this->BootstrapForm->input('InvItemsSupplier.0.inv_supplier_id', array(
						'id' => 'supplier',
						'label' => '* Proveedor:',
						'required' => 'required'
						,'class'=>'span3'
						//'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;'
						)
					);
					
					echo $this->BootstrapForm->input('code', array(
						'id' => 'code',
						'style' => 'width:400px',
						'label' => '* Código:',
						'required' => 'required'
						
						//'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;'
						)
					);
					echo $this->BootstrapForm->input('inv_brand_id', array(
//		
						'id' => 'brand',
						'label' => '* Marca:',
						'required' => 'required',					
						'class'=>'span3'
						)
					);
					echo $this->BootstrapForm->input('inv_category_id', array(
//						'after' => $this->BootstrapForm->input('Crear Categoría', array(
//							'type' => 'button',
//							'href' => '#modalAddCategorie', 
//							'role' => 'button', 
//							'class' => 'btn btn-info', 						
//							'data-toggle' =>'modal',
//							'label' => false,						
//							'div' => false,
//							)
//						),
						'id' => 'category',
						'label' => '* Categoría:',
						'required' => 'required',
						'class'=>'span3'
						//'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;'
						)
					);				
					echo $this->BootstrapForm->input('name', array(
						'id' => 'name',
						'style' => 'width:400px',
						'label' => '* Nombre:',
						'rows' => 3,
						'required' => 'required',
						//'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;'
						)
					);
					echo $this->BootstrapForm->input('description', array(
						//'class=' => 'input-xxlarge',
						//'type' => 'text',
						'id' => 'description',
						'rows' => 5,
						'style'=>'width:400px',
						'label' => '* Descripcción:',
						'required' => 'required',
						//'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;'
						)				
					);
					
					
					
					echo $this->BootstrapForm->input('Aux.neutralPrice', array(
						'id' => 'txtPrice',
						'style' => 'width:200px',
						'label' => '* Precio FOB:',
						'required' => 'required',
						//'type'=>'number'
						)
					);
					
					echo $this->BootstrapForm->input('Aux.priceType', array(
						'id' => 'cbxPriceType',
						'label' => '* Moneda:',
						'required' => 'required',					
						'class'=>'span3',
						'type'=>'select',
						'options'=>array("BOLIVIANOS"=>"BOLIVIANOS", "DOLARES"=>"DOLARES")
						)
					);
					
					echo $this->BootstrapForm->input('InvPrice.0.date', array(
						'id' => 'txtPriceDate',
						'style' => 'width:200px',
						'label' => '* Precio valido desde fecha: ',
						'required' => 'required',
						'type'=>'text',
						'class'=>'input-date-type'
						//'class'=>'span4'
						//'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;'
						)
					);
					?>
					
				<div class="row-fluid">
					<div class="btn-toolbar" style="text-align:center">
					<?php echo $this->BootstrapForm->submit('Guardar', array('id'=>'btnAdd', 'class' => 'btn btn-primary', 'div' => false));
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
	