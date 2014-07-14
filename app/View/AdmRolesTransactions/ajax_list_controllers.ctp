<?php
echo $this->BootstrapForm->input('adm_controller_id', array('label'=>'Controladores','id'=>'controllers', 'name'=>'AdmActionsRole[adm_controller_id]'));

echo '<div id="boxTransactions">';
echo $this->BootstrapForm->input('adm_transaction_id', array('type'=>'select', 'multiple'=>'checkbox', 'id'=>'transactions', 'label'=>'Transacciones:', 'selected' => $checkedTransactions ));
echo '</div>';
?>

