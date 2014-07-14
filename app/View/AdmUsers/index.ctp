<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FORMATO DE #UNICORN -->
<!-- ************************************************************************************************************************ -->
<h3>
<?php
echo $this->Html->link('<i class="icon-plus icon-white"></i>', array('action' => 'add'), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Nuevo')); 
?>
<?php echo __(' Usuarios');?></h3>

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
				<th><?php echo 'Usuario';?></th>
				<th><?php echo 'Nombre completo';?></th>
				<th><?php echo 'Activo';?></th>
				<th><?php echo 'Fecha Actividad';?></th>
				<th class="actions"><?php echo __('');?></th>
			</tr>
		<?php foreach ($admUsers as $admUser): ?>
			<tr>
				<td><?php echo $cont++; ?>&nbsp;</td>
				<td><?php echo h($admUser['AdmUser']['login']); ?>&nbsp;</td>
				<td><?php echo h($admUser['AdmProfile']['first_name'].' '.$admUser['AdmProfile']['last_name1'].' '.$admUser['AdmProfile']['last_name2']); ?>&nbsp;</td>
				<td style="text-align: center"><?php 
				$lbl='badge-success';
				$state = 'SI';
				if($admUser['AdmUser']['active'] == 0){$lbl='badge-important'; $state='NO';}
				echo '<span class="badge '.$lbl.'">'.$state.'</span>';
				?>&nbsp;</td>
				<td style="text-align: center">					
					<?php
					$badge = 'badge-important';
					if($admUser['AdmUser']['token_valide_date'] == 1){
						$badge = 'badge-success';
					}
					echo '<span class="badge '.$badge.'">'.date("d/m/Y", strtotime($admUser['AdmUser']['active_date'])).'</span>'; 
					?>&nbsp;
				</td>
				<td class="actions">
					<?php 
					$url['action'] = 'edit';
					$parameters['id']=$admUser['AdmUser']['id'];
					echo $this->Html->link('<i class="icon-pencil icon-white"></i>'.__(''),  array_merge($url,$parameters), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Editar')); 
					echo ' '.$this->Html->link('<i class="icon-briefcase icon-white"></i>'.__(''),  array_merge(array('action'=>'index_user_restriction', $admUser['AdmUser']['id'])), array('class'=>'btn btn-primary', 'escape'=>false, 'title'=>'Asignar Roles')); 
//					echo ' '.$this->Form->postLink('<i class="icon-trash icon-white"></i>', array('action' => 'delete', $admUser['AdmUser']['id']), array('class'=>'btn btn-danger', 'escape'=>false, 'title'=>'Eliminar'), __('¿Esta seguro de eliminar este usuario?', $admUser['AdmUser']['id']));
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
<!-- ************************************************************************************************************************ -->