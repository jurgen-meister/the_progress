<?php
echo $this->BootstrapForm->input('sal_employee_id', array(
					'required' => 'required',
					'label' => 'Responsable:',
					'class'=>'input-xlarge',
					'id'=>'cbxEmployees'
				));


echo $this->BootstrapForm->input('sal_tax_number_id', array(
					'required' => 'required',
					'label' => 'NIT/CI - Nombre:',
					'class'=>'input-xlarge',
					'id'=>'cbxTaxNumbers'
				));
?>