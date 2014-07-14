<div class="span12">
    <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-edit"></i>								
            </span>
            <h5>Editar Almacen</h5>			
        </div>
        <div class="widget-content nopadding">
            <?php echo $this->BootstrapForm->create('InvWarehouse', array('class' => 'form-horizontal')); ?>
            <fieldset>

                <?php
                echo $this->BootstrapForm->input('name', array(
                    'label' => '* Nombre:',
                    'style' => 'width: 400px',
                    'required' => 'required',
//				'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
                ));
                echo $this->BootstrapForm->input('location', array(
                    'label' => '* Departamento:',
                    'style' => 'width: 400px',
                    'required' => 'required',
                    'type' => 'select',
                    'options' => $departaments = array("La Paz" => "La Paz", "Cochabamba" => "Cochabamba", "Santa Cruz" => "Santa Cruz", "Oruro" => "Oruro", "Potosi" => "Potosi", "Chuquisaca" => "Chuquisaca", "Tarija" => "Tarija", "Beni" => "Beni", "Pando" => "Pando"),
//				'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
                ));
                echo $this->BootstrapForm->input('address', array(
                    'label' => '* Dirección:',
                    'rows' => 5,
                    'style' => 'width: 400px',
                    'required' => 'required',
//				'helpInline' => '<span class="label label-important">' . __('Requerido') . '</span>&nbsp;')
                ));
                echo $this->BootstrapForm->hidden('id');
                ?>
                <div class="row-fluid">
                    <div class="span2"></div>
                    <div class="span6">
                        <div class="btn-toolbar">
                            <?php
                            echo $this->BootstrapForm->submit('Guardar', array('id' => 'saveButton', 'class' => 'btn btn-primary', 'div' => false));
                            echo $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn'));
                            ?>
                        </div>				
                    </div>
                    <div class="span4"></div>
                </div>	
            </fieldset>
<?php echo $this->BootstrapForm->end(); ?>
        </div>
    </div>
</div>