<?php
						
	echo $this->BootstrapForm->input('date', array(	
		'label' => 'Fecha:',
		'id'=>'txtModalDate',
		'value'=>$datePay,
		'class'=>'span3',
		'maxlength'=>'15'
	));
	
	echo $this->BootstrapForm->input('amount', array(				
		'label' => 'Monto a Pagar:',
		'id'=>'txtModalPaidAmount',
		'value'=>$payDebt,
		'class'=>'span3',
		'maxlength'=>'15'
	));
					
?>