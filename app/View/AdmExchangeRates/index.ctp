<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
<h3>
<?php
echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'add'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo')); 
?>
<?php echo __(' Tipo de Cambio');?></h3>

		<!-- *********************************************** #UNICORN TABLE WRAP ********************************************-->
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-th"></i>
				</span>
				<h5><?php echo $this->BootstrapPaginator->counter(array('format' => __('Página {:page} de {:pages}, mostrando {:current} de un total de {:count} registros')));?></h5>
			</div>
			<div class="widget-content nopadding">
		<!-- *********************************************** #UNICORN TABLE WRAP ********************************************-->
		
		<?php $cont = $this->BootstrapPaginator->counter('{:start}');?>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<th><?php echo '#';?></th>
				<th><?php echo 'Fecha';?></th>
				<th><?php echo 'Dolares';?></th>
				<th><?php echo 'Bolivianos';?></th>				
				<th></th>
			</tr>
		<?php foreach ($admExchangeRates as $admExchangeRate): ?>
			<tr >
				<td style="text-align:center"><?php echo $cont++; ?>&nbsp;</td>
				<td style="text-align:center"><?php echo date("d/m/Y", strtotime($admExchangeRate['AdmExchangeRate']['date'])); ?>&nbsp;</td>				
				<td style="text-align:center"><?php echo h($admExchangeRate['AdmExchangeRate']['currency']); ?>&nbsp;</td>
				<td style="text-align:center"><?php echo h($admExchangeRate['AdmExchangeRate']['value']); ?>&nbsp;</td>				
				<td>
					<?php 
					$url['action'] = 'edit';
					//$parameters['id']=$admArea['AdmArea']['id'];
					echo $this->Html->link('<i class="icon-pencil icon-white"></i>'.__(''),  array_merge($url,array($admExchangeRate['AdmExchangeRate']['id'])), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Editar')); 
					echo ' '.$this->Form->postLink('<i class="icon-trash icon-white"></i>', array('action' => 'delete', $admExchangeRate['AdmExchangeRate']['id']), array('class'=>'btn btn-danger', 'escape'=>false, 'title'=>'Eliminar'), __('¿Esta seguro de borrar?', $admExchangeRate['AdmExchangeRate']['id']));
					?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<!-- *********************************************** #UNICORN TABLE WRAP ********************************************-->
		</div>
	</div>
	<!-- *********************************************** #UNICORN TABLE WRAP ********************************************-->
		<?php echo $this->BootstrapPaginator->pagination(); ?>
<!-- ************************************************************************************************************************ -->
</div><!-- FIN CONTAINER FLUID/ROW FLUID/SPAN12 - Del Template Principal #UNICORN
<!-- ************************************************************************************************************************ --></div>