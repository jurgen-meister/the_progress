<?php echo $this->Html->script('jquery.flot.min', FALSE); ?>
<?php echo $this->Html->script('jquery.flot.pie.min', FALSE); ?>
<?php echo $this->Html->script('jquery.flot.resize.min', FALSE); ?>
<?php echo $this->Html->script('jquery.flot.axislabels', FALSE); ?>
<?php echo $this->Html->script('jquery.flot.stack', FALSE); ?>
<?php echo $this->Html->script('unicorn', FALSE); ?>
<?php echo $this->Html->script('jquery.dataTables.min.js', FALSE); ?>
<?php echo $this->Html->script('jquery.uniform.js', FALSE); ?>
<?php echo $this->Html->script('modules/SalGraphicsNew', FALSE); ?>


<!-- ************************************************************************************************************************ -->
<div class="span12"><!-- START CONTAINER FLUID/ROW FLUID/SPAN12 - FROM MAIN TEMPLATE #UNICORN -->
    <!-- ************************************************************************************************************************ -->
    <!-- //////////////////////////// Start - filters /////////////////////////////////-->
    <div class="row-fluid">
        <div class="span12">

            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class=" icon-search"></i>
                    </span>
                    <h5>Gráficas de Ventas</h5>
                </div>
                <div class="widget-content nopadding">
                    <?php echo $this->BootstrapForm->create('SalSale', array('class' => 'form-horizontal', 'novalidate' => true)); ?>
                    <?php
                    echo $this->BootstrapForm->input('year', array(
                        'label' => 'Gestión:',
                        'id' => 'cbxYear',
                        'type' => 'select',
                        'class' => 'span4',
                        'options' => $years
                    ));
                    echo $this->BootstrapForm->input('month', array(
                        'label' => 'Mes:',
                        'id' => 'cbxMonth',
                        'type' => 'select',
                        'multiple' => 'multiple',
                        'class' => 'span10',
                        'options' => $months,
                        'selected' => array_keys($months),
                        'placeholder' => 'Seleccione meses'
                    ));
//                    echo $this->BootstrapForm->input('movementType', array(
//                        'label' => 'Tipo de Movimiento:',
//                        'id' => 'cbxMovementType',
//                        'class' => 'span6',
//                        'type' => 'select',
//                        'options' => $movementTypes,
//                    ));
                    echo $this->BootstrapForm->input('location', array(
                        'label' => 'Departamento:',
                        'id' => 'cbxLocation',
                        'class' => 'span4',
                        'type' => 'select',
                        'options' => $departaments,
                    ));
//                    echo $this->BootstrapForm->input('warehouse', array(
//                        'label' => 'Almacen:',
//                        'id' => 'cbxWarehouse',
//                        'class' => 'span4',
//                        'type' => 'select',
//                        'options' => $warehouses,
//                    ));
                    echo $this->BootstrapForm->input('currency', array(
                        'label' => 'Moneda:',
                        'id' => 'cbxCurrency',
                        'class' => 'span4',
                        'type' => 'select',
                        'options' => $currencies,
                    ));
                    echo $this->BootstrapForm->input('priceType', array(
                        'label' => 'Tipo de Precio:',
                        'id' => 'cbxPriceType',
                        'class' => 'span4',
                        'type' => 'select',
                        'options' => $priceTypes,
                    ));
                    echo $this->BootstrapForm->input('showBy', array(
                        'label' => 'Mostrar por:',
                        'id' => 'cbxShowBy',
                        'class' => 'span4',
                        'type' => 'select',
                        'options' => $showBy,
                    ));
                    if (count($groups) > 0) {
                        echo $this->BootstrapForm->input('group', array(
                            'label' => 'Agrupar por:',
                            'id' => 'cbxGroup',
                            'type' => 'select',
                            'class' => 'span4',
                            'options' => $groups
                        ));
                    }
                    ?>

                    <?php echo $this->BootstrapForm->end(); ?>
                    <div style ="background-color: #F5F5F5; padding-bottom:10px; padding-top: 10px;" align="center"><a href="#" id="btnGenerateGraphicsGroups" class="btn btn-primary noPrint "><i class="icon-signal icon-white"></i> Generar Gráfica</a></div>
                    <div id="boxMessage" class="alert-error"></div>
                    <div id="boxProcessing" align="center"></div>
                    <span id="spanHiddenLastSelectedGroup" style="display:none"></span>
                    <span id="spanHiddenGroupName" style="display:none"></span>
                    <span id="spanHiddenGroupId" style="display:none"></span>
                    <span id="spanHiddenGroupType" style="display:none"></span>
                    <span id="spanHiddenRequestType" style="display:none"></span>
                </div>
            </div>

        </div>
    </div>
    <!-- //////////////////////////// End - filters /////////////////////////////////-->

    <!-- *********************************************** #UNICORN SEARCH WRAP ********************************************-->

    <div class="row-fluid" id="boxGraphics">
        <div class="span4">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class=" icon-signal"></i>
                    </span>
                    <h5><span id="spanBoxGraphics">Resumen</span></h5>
                </div>
                <div class="widget-content nopadding">
                    <div id="boxDataTable"></div>
                </div>	
            </div>
        </div>

        <div class="span8">

            <!--Start - Accordion-->
            <div class="accordion widget-box" id="accordionGraphics">
                <div class="accordion-group">
                    <div class="accordion-heading widget-title">
                        <span class="accordion-toggle tip-left h5-acordion-title" data-original-title="Click para abrir o cerrar" data-toggle="collapse" data-parent="#accordionGraphics" href="#collapsePie">
                            Gráfica de Torta
                        </span>
                    </div>
                    <!--                    <div id="collapsePie" class="accordion-body collapse in">-->
                    <div id="collapsePie" class="accordion-body collapse in">
                        <div class="accordion-inner">
                            <div class="pie"></div>
                        </div>
                    </div>
                </div>
                <div class="accordion-group">
                    <div class="accordion-heading widget-title">
                        <span class="accordion-toggle tip-left h5-acordion-title" data-original-title="Click para abrir o cerrar" data-toggle="collapse" data-parent="#accordionGraphics" href="#collapseBars">
                            Gráfica de Barras
                        </span>
                    </div>
                    <div id="collapseBars" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <div class="bars"></div>
                        </div>
                    </div>
                </div>
                <div class="accordion-group">
                    <div class="accordion-heading widget-title">
                        <span class="accordion-toggle tip-left h5-acordion-title" data-original-title="Click para abrir o cerrar" data-toggle="collapse" data-parent="#accordionGraphics" href="#collapseLines">
                            Gráfica Linear
                        </span>
                    </div>
                    <div id="collapseLines" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <div class="chart"></div>
                        </div>
                    </div>
                </div>

            </div>
            <!--End - Accordion-->

        </div><!--END - Span8-->
    </div><!--END - Main Row Fluid-->






    <!-- *********************************************** #UNICORN SEARCH WRAP ********************************************-->



    <!-- ************************************************************************************************************************ -->
</div><!-- END CONTAINER FLUID/ROW FLUID/SPAN12 - FROM MAIN TEMPLATE #UNICORN
<!-- ************************************************************************************************************************ -->
