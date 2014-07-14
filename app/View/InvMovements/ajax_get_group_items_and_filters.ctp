<?php 
if(isset($group)){
	echo '<div class="row-fluid">';
	echo $this->BootstrapForm->input('group', array(
	  'label' => false,
	  'id'=>'cbxReportGroupFilters',
	  'type'=>'select',
	  'multiple'=>'multiple',	
	  'class'=>'span12',    
	  'options'=>$group,
//	  'selected'=>  array_keys($group),
	  'placeholder'=>'Haga click para seleccionar agrupaciones'
	));
	echo '</div>';	
}
?>
<div id="boxGroupItems">
<table class="table table-bordered data-table with-check">
	<thead>
	<tr>
		<th><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" checked="checked" /></th>
		<th>Item</th>
		<th>Marca</th>
		<th>Categoria</th>
	</tr>
	</thead>

	<tbody>
	<?php foreach($item as $val){ ?>	
	<tr>
		<td><input type="checkbox" checked="checked" value="<?php echo $val['InvItem']['id'];?>" /></td>
		<td><?php echo '[ '.$val['InvItem']['code'].' ] '.$val['InvItem']['name'];?></td>
		<td><?php echo $val['InvBrand']['name'];?></td>
		<td><?php echo $val['InvCategory']['name'];?></td>
	</tr>
	<?php } ?>
	</tbody>
</table>  
</div>